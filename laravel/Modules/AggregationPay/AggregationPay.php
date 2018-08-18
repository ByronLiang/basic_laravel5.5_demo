<?php

declare(strict_types=1);

namespace Modules\AggregationPay;

use Modules\AggregationPay\Entities\PaymentRecord;
use Modules\AggregationPay\Services\WechatService;

class AggregationPay
{
    /**
     * @param string                  $channel
     * @param AggregationPayInterface $order
     * @param float                   $amount
     * @param string                  $remark
     * @param string                  $return_url
     *
     * @return array
     *
     * @throws \Exception
     */
    public function payment(string $channel, AggregationPayInterface $order, float $amount, string $remark = '', string $return_url = '')
    {
        $channels = array_keys(trans('AggregationPay::payment.channels'));
        if (!in_array($channel, $channels)) {
            return abort(403, '无效支付渠道，仅支持：'.implode(',', $channels));
        }

        if (env('DISABLED_PAY')) {
            $channel = 'test';
        }

        $record = $order->paymentRecords()->create([
            'channel' => $channel,
            'amount' => $amount,
            'remark' => $remark,
        ]);

        $notify_url = action(config('aggregation_pay.notify_action'), $channel);

        return [
            'payment_record' => $record,
            'res' => $record->initiatePayment($notify_url, $return_url),
        ];
    }

    /**
     * @param AggregationPayInterface $payment_order
     * @param string                  $remark
     * @param float                   $amount
     * @param AggregationPayInterface $refund_order
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function refund(AggregationPayInterface $payment_order, string $remark = '', float $amount = null, AggregationPayInterface $refund_order = null)
    {
        if (!$payment_order->paymentRecordPaid) {
            abort(500, '无支付记录订单');
        }

        if (!$refund_order) {
            $refund_order = $payment_order;
        }

        return $refund_order->refundRecords()->firstOrCreate([
            'amount' => $amount,
            'remark' => $remark,
            'payment_record_id' => $payment_order->paymentRecordPaid->id,
        ]);
    }

    /**
     * @param $payment_no
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function paymentQuery($payment_no)
    {
        $payment_record = PaymentRecord::where('payment_no', $payment_no)->firstOrFail();

        return $payment_record->checkStatus();
    }

    /**
     * @param $channel
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     *
     * @throws \EasyWeChat\Kernel\Exceptions\Exception|\Exception
     */
    public function payHook($channel)
    {
        if (strstr($channel, 'alipay_')) {
            $payment_record = PaymentRecord::where('payment_no', request('out_trade_no'))
                ->first();

            if ($payment_record && $payment_record->checkStatus()) {
                return response('success');
            }

            return response('fail');
        } elseif (strstr($channel, 'wechat_')) {
            return WechatService::getInstance()->payment()->handlePaidNotify(function ($message, $fail) {
                $payment_record = PaymentRecord::where('payment_no', $message['out_trade_no'])
                    ->first();

                if (!$payment_record) { // 如果订单不存在
                    $fail('Order not exist.'); // 告诉微信，我已经处理完了，订单没找到，别再通知我了
                }

                if ('paid' == $payment_record->status) {
                    return true;
                }

                if ('SUCCESS' === $message['result_code']) {
                    $payment_record->checkStatus();
                }

                return true;
            });
        } else {
            abort(404, '找不到此订单');
        }

        return $channel;
    }
}
