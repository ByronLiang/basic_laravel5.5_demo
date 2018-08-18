<?php

return [
    'notify_action' => '',
    'alipay_default' => 'default',
    'wechat_default' => 'default',
    'alipay' => [
        'default' => [
            'app_id' => env('ALIPAY_APPID'),
            'alipay_public_key_path' => storage_path('certificate/alipay_default/alipay_public_key.pem'),
            'app_private_key_path' => storage_path('certificate/alipay_default/app_private_key.pem'),
            'rsa2' => false,
            'sandbox' => false,
        ],
        'test' => [
            'app_id' => '2016072800110686',
            'alipay_public_key_path' => storage_path('certificate/alipay_test/alipay_public_key.pem'),
            'app_private_key_path' => storage_path('certificate/alipay_test/app_private_key.pem'),
            'rsa2' => true,
            'sandbox' => true,
        ],
    ],
    'wechat' => [
        'default' => [
            'app_id' => env('WECHAT_OFFICIAL_ACCOUNT_APPID'),
            'secret' => env('WECHAT_OFFICIAL_ACCOUNT_SECRET'),
            'token' => env('WECHAT_OFFICIAL_ACCOUNT_TOKEN'),
            'aes_key' => env('WECHAT_OFFICIAL_ACCOUNT_AES_KEY'),
            //支付相关
            'mch_id' => env('WECHAT_PAYMENT_MCH_ID'),
            'key' => env('WECHAT_PAYMENT_KEY'),
            'cert_path' => storage_path('certificate/wechat_default/apiclient_cert.pem'),
            'key_path' => storage_path('certificate/wechat_default/apiclient_key.pem'),
        ],
    ],
];
