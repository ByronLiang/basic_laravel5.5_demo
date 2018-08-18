<?php

namespace Modules\AggregationPay\Entities;

use Modules\AggregationPay\Events\AggregationPayEvent;
use Modules\AggregationPay\Services\AlipayService;
use Modules\AggregationPay\Services\WechatService;

/**
 * @property string        $status
 * @property float         $amount
 * @property PaymentRecord $paymentRecord
 */
class RefundRecord extends \App\Models\Model
{
    const STATUS_REFUNDING = 'refunding'; // 退款中
    const STATUS_REFUNDED = 'refunded'; // 已退款
    const STATUS_FAILURE = 'failure'; // 失败

    protected $casts = [
        'failure_reason' => 'object',
    ];

    protected $hidden = [
        'able_id',
        'able_type',
        'failure_reason',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function (self $self) {
            $paymentRecord = $self->paymentRecord;
            if (PaymentRecord::STATUS_PAID != $paymentRecord->status) {
                abort(500, '创建退款记录失败，非付款记录');
            }
            $can_refund_amount = (float) bcsub($paymentRecord->amount, $paymentRecord->refund_amount, 2);
            if (!$self->amount) {
                $self->amount = $can_refund_amount;
            }
            if (0 >= $self->amount || $self->amount > $can_refund_amount) {
                abort(500, '无效退款金额');
            }

            if (!$self->able_id || !$self->able_type) {
                $self->able_id = $paymentRecord->able_id;
                $self->able_type = $paymentRecord->able_type;
            }
        });
        static::created(function (self $model) {
            $model->initiateRefund();
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|self
     */
    public function able()
    {
        return $this->morphTo();
    }

    public function statusToRefunded()
    {
        if (self::STATUS_REFUNDED == $this->status) {
            return $this;
        }
        $this->status = self::STATUS_REFUNDED;
        $this->save();

        event(new AggregationPayEvent($this));

        return $this;
    }

    public function statusToFailure($failure_reason = [])
    {
        $this->status = self::STATUS_FAILURE;
        $this->failure_reason = json_encode($failure_reason, JSON_UNESCAPED_UNICODE);
        $this->save();

        return $this;
    }

    /**
     * 发起退款操作.
     *
     * @return $this|RefundRecord
     *
     * @throws \Exception
     */
    public function initiateRefund()
    {
        if (self::STATUS_REFUNDED == $this->status) {
            return $this;
        }
        if ($this->paymentRecord->amount < $this->amount) {
            $this->amount = $this->paymentRecord->amount;
        }
        if (!$this->refund_no) {
            $this->refund_no = date('YmdHis').$this->id;
            $this->save();
        }
        $channel = $this->paymentRecord->channel;

        if ($this->amount < 0.01) {
            return $this->statusToRefunded();
        }

        switch ($channel) {
            case 'alipay_web':
                $result = AlipayService::getInstance('web')
                    ->tradeRefund(
                        $this->paymentRecord->payment_no,
                        $this->amount,
                        $this->refund_no
                    );
                if (10000 == $result->code) {
                    $this->statusToRefunded();
                } elseif (40004 != $result->code) {
                    $this->statusToFailure($result);
                    abort(422, json_encode($result));
                }
                break;
            case 'wechat_public':
            case 'wechat_qr':
            case 'wechat_wap':
                $result = WechatService::getInstance('public')
                    ->refund(
                        $this->paymentRecord->payment_no,
                        $this->refund_no,
                        $this->paymentRecord->amount,
                        $this->amount
                    );
                if ('FAIL' == $result['result_code']) {
                    // if(in_array($result->err_code, ['ERROR', 'USER_ACCOUNT_ABNORMAL'])){
                    //无法退款，取消操作
                    // }
                    if ('NOTENOUGH' == $result['err_code']) {
                        throw new \Exception('微信商户平台可用余额不足，请充值后重试');
                    }
                    $this->statusToFailure($result);
                    \Log::error('退款失败:'.$result['err_code_des']);
                    throw new \Exception('微信退款出错，请联系处理');
                } elseif ('SUCCESS' == $result['return_code'] && 'SUCCESS' == $result['result_code']) {
                    $this->statusToRefunded();
                }
                break;
            case 'test':
                return $this->statusToRefunded();
                break;
        }

        return $this;
    }

    public function paymentRecord()
    {
        return $this->belongsTo(PaymentRecord::class);
    }
}
