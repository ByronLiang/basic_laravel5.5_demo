<?php

namespace Modules\AggregationPay\Sdk\Platforms;

use Omnipay\Alipay\Requests\AopTradeWapPayRequest;
use Omnipay\Alipay\Responses\AopCompletePurchaseResponse;
use Omnipay\Alipay\AopWapGateway;
use Omnipay\Alipay\Responses\AopTradeWapPayResponse;

class AlipayWap implements \Modules\AggregationPay\Sdk\SdkInterface
{
    /**
     * @var self
     */
    private static $instance;

    public static function getInstance($type = '')
    {
        if (empty($type)) {
            $type = config('aggregation_pay.alipay_default');
        }
        if (!static::$instance) {
            $config = config('aggregation_pay.alipay.'.$type);
            static::$instance = new static(
                $config['app_id'],
                $config['alipay_public_key_path'],
                $config['app_private_key_path']
            );
            if ($config['sandbox']) {
                static::$instance->gateway->sandbox();
            }
            if ($config['rsa2']) {
                static::$instance->gateway->setSignType('RSA2');
            }
        }

        return static::$instance;
    }

    /**
     * @var AopWapGateway
     */
    public $gateway;

    public function __construct($app_id, $alipay_public_key_path, $app_private_key_path, $sign_type = 'RSA')
    {
        /**
         * @var AopWapGateway
         */
        $gateway = \Omnipay\Omnipay::create('Alipay_AopWap');
        $gateway->setSignType($sign_type); // RSA/RSA2/MD5
        $gateway->setAppId($app_id);
        $gateway->setPrivateKey($app_private_key_path);
        $gateway->setAlipayPublicKey($alipay_public_key_path);

        $this->gateway = $gateway;
    }

    /**
     * 设置支付.
     *
     * @param string $notice_url
     *
     * @return mixed
     */
    public function setPayNoticeUrl(string $notice_url)
    {
        $this->gateway->setNotifyUrl($notice_url);

        return $this;
    }

    /**
     * 支付回调.
     *
     * @param \Closure $callback
     *
     * @return mixed|void
     *
     * @throws \Omnipay\Common\Exception\InvalidRequestException
     */
    public function payNotice(\Closure $callback)
    {
        $gateway = $this->gateway;
        $request = $gateway->completePurchase();
        $request->setParams(array_merge($_POST, $_GET)); //Don't use $_REQUEST for may contain $_COOKIE

        /*
         * @var AopCompletePurchaseResponse $response
         */
        try {
            $response = $request->send();

            if ($response->isPaid()) {
                $callback();
                /*
                 * Payment is successful
                 */
                die('success'); //The notify response should be 'success' only
            } else {
                /*
                 * Payment is not successful
                 */
                die('fail'); //The notify response
            }
        } catch (\Exception $e) {
            /*
             * Payment is not successful
             */
            die('fail'); //The notify response
        }
    }

    /**
     * @param string $payment_no
     * @param float  $amount
     * @param string $subject
     * @param string $body
     * @param array  $extra      其他参数
     *
     * @return mixed|string
     */
    public function payCreate(string $payment_no, float $amount, string $subject, string $body, array $extra = [])
    {
        $gateway = $this->gateway;
        $gateway->setReturnUrl($extra['return_url']);

        /**
         * @var AopTradeWapPayRequest
         */
        $request = $gateway->purchase();

        $request->setBizContent([
            'subject' => $subject,
            'out_trade_no' => $payment_no,
            'total_amount' => $amount,
            'product_code' => 'QUICK_WAP_PAY',
        ]);

        /**
         * @var AopTradeWapPayResponse
         */
        $response = $request->send();

        return $response->getRedirectUrl();
    }

    /**
     * @param string $payment_no
     *
     * @return mixed|\Omnipay\Alipay\Requests\AopTradeQueryRequest
     */
    public function payQuery(string $payment_no)
    {
        return $this->gateway->query([
            'out_trade_no' => $payment_no,
        ]);
    }

    /**
     * @param string $payment_no
     * @param float  $payment_amount
     * @param string $refund_no
     * @param float  $refund_amount
     * @param string $refund_reason
     * @param array  $metadata       其他参数
     *
     * @return mixed
     */
    public function refundCreate(string $payment_no, float $payment_amount, string $refund_no, float $refund_amount, string $refund_reason, array $metadata = [])
    {
        return $this->gateway->refund([
            'out_trade_no' => $payment_no,
            'refund_amount' => $refund_amount,
            'out_request_no' => $refund_no,
            'refund_reason' => $refund_reason,
        ]);
    }

    /**
     * @param string $payment_no
     * @param string $refund_no
     *
     * @return mixed
     */
    public function refundQuery(string $payment_no, string $refund_no)
    {
        return $this->gateway->refundQuery([
            'out_trade_no' => $payment_no,
            'out_request_no' => $refund_no,
        ]);
    }
}
