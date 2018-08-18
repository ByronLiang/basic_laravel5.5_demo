<?php

namespace Modules\AggregationPay\Tests;

use Modules\AggregationPay\AggregationPay;
use Tests\TestCase;

class PayTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testExample()
    {
        $pay = new AggregationPay();

        $order = new \stdClass();
        $order->id = time();

        $res = $pay->payment('alipay_app', $order, 1, '测试支付');
//        $res = $pay->payment('alipay_web', $order, 1, '测试支付');
//        $res = $pay->payment('wechat_app', $order, 1, '测试支付');
        $res = $pay->paymentQuery('201805041840214');
        dd($res);
    }
}
