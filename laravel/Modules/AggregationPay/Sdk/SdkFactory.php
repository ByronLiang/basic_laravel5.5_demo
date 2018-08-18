<?php

namespace Modules\AggregationPay\Sdk;

/**
 * @method setChargeNoticeUrl($notice_url)
 * @method chargeNotice(\Closure $callback)
 * @method chargeCreate(string $payment_no, float $amount, string $subject, string $body, array $extra = [])
 * @method chargeQuery(string $payment_no)
 * @method refundCreate(string $payment_no, float $payment_amount, string $refund_no, float $refund_amount, string $description, array $metadata = [])
 * @method refundQuery(string $payment_no, string $refund_no)
 */
class SdkFactory
{
    /**
     * @var SdkInterface
     */
    private $strategy;

    /**
     * SdkFactory constructor.
     *
     * @param $channel
     *
     * @throws \Exception
     */
    public function __construct($channel)
    {
        switch ($channel) {
            case 'a':
                $this->strategy = new ConcreteStrategyA();
                break;
            case 'b':
                $this->strategy = new ConcreteStrategyB();
                break;
            case 'c':
                $this->strategy = new ConcreteStrategyC();
                break;
            default:
                throw new \Exception('未定义支付方式');
                break;
        }
        if (!$this->strategy instanceof SdkInterface) {
            throw new \Exception('未 implements SdkInterface');
        }
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->strategy, $name], $arguments);
    }
}
