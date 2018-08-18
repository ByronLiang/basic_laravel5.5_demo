<?php

namespace Ganguo\ClientAggregationUpload;

class AliyunOssService
{
    private $accessKeyId;
    private $accessKeySecret;
    private $bucket;
    private $endpoint;
    private $isCName;

    public function __construct()
    {
        $qiniu = \Config::get('filesystems.disks.oss');
        if (!$qiniu) {
            abort(403, '缺少oss配置');
        }
        $this->accessKeyId = $qiniu['access_id'];
        $this->accessKeySecret = $qiniu['access_key'];
        $this->bucket = $qiniu['bucket'];
        $this->endpoint = $qiniu['endpoint'];
        $this->isCName = $qiniu['isCName'];
    }

    public function getToken()
    {
        $id = $this->accessKeyId;
        $key = $this->accessKeySecret;
        $host = $this->endpoint;

        $now = time();
        $expire = 30; //设置该policy超时时间是10s. 即这个policy过了这个有效时间，将不能访问
        $end = $now + $expire;
        $expiration = $this->gmt_iso8601($end);

        $dir = '';

        //最大文件大小.用户可以自己设置
        $conditions[] = [
            'content-length-range',
            0,
            1048576000,
        ];

        //表示用户上传的数据,必须是以$dir开始, 不然上传会失败,这一步不是必须项,只是为了安全起见,防止用户通过policy上传到别人的目录
        $conditions[] = [
            'starts-with',
            '$key',
            $dir,
        ];

        $arr = [
            'expiration' => $expiration,
            'conditions' => $conditions,
        ];

        $policy = json_encode($arr);
        $base64_policy = base64_encode($policy);
        $signature = base64_encode(hash_hmac('sha1', $base64_policy, $key, true));

        $response = [];
        $response['accessid'] = $id;
        $response['host'] = $host;
        $response['policy'] = $base64_policy;
        $response['signature'] = $signature;
        $response['expire'] = $end;
        //这个参数是设置用户上传指定的前缀
        $response['dir'] = $dir;

        return $response;
    }

    private function gmt_iso8601($time)
    {
        $dtStr = date('c', $time);
        $mydatetime = new \DateTime($dtStr);
        $expiration = $mydatetime->format(\DateTime::ISO8601);
        $pos = strpos($expiration, '+');
        $expiration = substr($expiration, 0, $pos);

        return $expiration.'Z';
    }
}
