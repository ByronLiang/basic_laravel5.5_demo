<?php

namespace Ganguo\ClientAggregationUpload;

use Config;
use Qiniu\Auth;

class QiniuService
{
    private $accessKey;
    private $secretKey;
    private $bucket;
    private $domain;
    private $upload_url;

    public function __construct()
    {
        $qiniu = Config::get('filesystems.disks.qiniu');
        if (!$qiniu) {
            abort(403, '缺少七牛配置');
        }
        $this->accessKey = $qiniu['access_key'];
        $this->secretKey = $qiniu['secret_key'];
        $this->bucket = $qiniu['bucket'];
        $this->domain = $qiniu['domain'];
        $this->upload_url = $qiniu['upload_url'];
    }

    public function getToken()
    {
        $auth = new Auth($this->accessKey, $this->secretKey);
        $token = $auth->uploadToken($this->bucket, null, 60 * 60);
        $domain = $this->domain;
        $upload_url = $this->upload_url;

        return compact('token', 'domain', 'upload_url');
    }
}
