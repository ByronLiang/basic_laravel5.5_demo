<?php

namespace Modules\AggregationPay\Entities;

use Modules\AggregationPay\Services\AlipayService;
use Modules\AggregationPay\Services\WechatService;
use Modules\AggregationPay\Events\AggregationPayEvent;

/**
 * @method static |self whereStatus($status)
 *
 * @property int    $id
 * @property float  $amount
 * @property float  $refund_amount
 * @property string $status
 */
class PaymentRecord extends \App\Models\Model
{
    const STATUS_PAYING = 'paying';
    const STATUS_PAID = 'paid';
    const STATUS_REFUNDED = 'refunded';

    protected $hidden = [
         'able_id',
         'able_type',
    ];

    protected $attributes = [
        'status' => self::STATUS_PAYING,
    ];

    protected $casts = [
        'amount' => 'float',
        'refund_amount' => 'float',
    ];

    protected static function boot()
    {
        parent::boot();
        static::updating(function (self $self) {
            if ($self->refund_amount != $self->getOriginal('refund_amount') && $self->refund_amount == $self->amount) {
                $self->statusToRefunded();
            }
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo|self
     */
    public function able()
    {
        return $this->morphTo();
    }

    /**
     * @param $notify_url
     * @param string $return_url
     *
     * @return PaymentRecord|mixed|null|string
     *
     * @throws \Exception
     */
    public function initiatePayment($notify_url, $return_url = '')
    {
        if (self::STATUS_PAYING != $this->status) {
            throw new \Exception('已支付');
        }
        if (!$this->payment_no) {
            $this->payment_no = date('YmdHis').$this->id;
            $this->save();
        }

        if (!$this->amount || $this->amount < 0.01) {
            return $this->statusToPaid();
        }

        if (!$return_url) {
            $return_url = url('');
        }
        if (!strpos($return_url, '://')) {
            $return_url = url($return_url);
        }

        if (strstr($this->channel, 'alipay_')) {
            $trade_types = [
                'alipay_app' => 'tradeAppPay',
                'alipay_web' => 'tradePagePay',
                'alipay_wap' => 'tradeWapPay',
            ];

            return AlipayService::getInstance()
                ->setNotifyUrl($notify_url)
                ->{$trade_types[$this->channel]}(
                    $this->payment_no,
                    $this->payment_no,
                    $this->amount,
                    $return_url,
                    $this->remark
                );
        } elseif (strstr($this->channel, 'wechat_')) {
            $trade_types = [
                'wechat_wap' => 'MWEB',
                'wechat_qr' => 'NATIVE',
                'wechat_public' => 'JSAPI',
                'wechat_applet' => 'JSAPI',
                'wechat_app' => 'APP',
            ];

            return WechatService::getInstance(str_replace('wechat_', '', $this->channel))
                ->setNotifyUrl($notify_url)
                ->paymentConfig(
                    $this->payment_no,
                    $this->amount,
                    $this->payment_no,
                    $this->remark,
                    $trade_types[$this->channel]
                );
        } else {
            return $this->statusToPaid();
        }
    }

    /**
     * @return bool
     *
     * @throws \Exception
     */
    public function checkStatus()
    {
        if (self::STATUS_PAYING != $this->status) {
            return true;
        }
        switch ($this->channel) {
            case 'alipay_app':
            case 'alipay_web':
            case 'alipay_wap':
                $res = AlipayService::getInstance()
                    ->tradeQuery($this->payment_no);
                if (10000 == $res->code) {
                    $this->statusToPaid();

                    return true;
                } elseif (40004 != $res->code) {
                    abort(422, json_encode($res));
                }
                break;
            case 'wechat_wap':
            case 'wechat_qr':
            case 'wechat_public':
            case 'wechat_applet':
            case 'wechat_app':
                $res = WechatService::getInstance(str_replace('wechat_', '', $this->channel))->payment()
                    ->order
                    ->queryByOutTradeNumber($this->payment_no);
                if ('SUCCESS' == $res['return_code'] && 'SUCCESS' == $res['trade_state']) {
                    $this->statusToPaid();

                    return true;
                } else {
                    abort(422, json_encode($res));
                }
                break;
        }
        \Log::error('无效支付状态检查', $this->toArray());

        return false;
    }

    public function statusToPaid()
    {
        if (self::STATUS_PAID == $this->status) {
            return $this;
        }
        $this->status = self::STATUS_PAID;
        $this->save();

        event(new AggregationPayEvent($this));

        return $this;
    }

    public function statusToRefunded()
    {
        if (self::STATUS_REFUNDED == $this->status) {
            return $this;
        }
        $this->status = self::STATUS_REFUNDED;
        $this->save();

        return $this;
    }

    public function refundRecords()
    {
        return $this->hasMany(RefundRecord::class);
    }

    public function refundRecordsRefunded()
    {
        return $this->refundRecords()->where('status', RefundRecord::STATUS_REFUNDED);
    }
}
