<?php

namespace Ganguo\ClientAggregationUpload;

class ClientAggregationUpload
{
    public function getParameter($drive = 'local')
    {
        switch ($drive) {
            case 'oss':
                $oss = (new AliyunOssService())->getToken();
                $parameter = [
                    'form' => [
                        'policy' => $oss['policy'],
                        'OSSAccessKeyId' => $oss['accessid'],
                        'success_action_status' => 200,
                        'signature' => $oss['signature'],
                    ],
                    'domain' => $oss['host'],
                    'upload_url' => $oss['host'],
                ];
                break;
            case 'qiniu':
                $qiniu = (new QiniuService())->getToken();
                $parameter = [
                    'form' => [
                        'token' => $qiniu['token'],
                    ],
                    'domain' => $qiniu['domain'],
                    'upload_url' => $qiniu['upload_url'],
                ];
                break;
            case 'local':
            default:
                $token = csrf_token();
                \Cache::put('_token_'.$token, $token, 2);
                $parameter = [
                    'form' => [
                        '_token' => $token,
                    ],
                    'domain' => url('/upload/'),
                    'upload_url' => request()->url(),
                ];
                break;
        }
        $parameter['drive'] = $drive;

        return $parameter;
    }

    public function local(\Illuminate\Http\Request $request)
    {
        if (!$request->has('_token') || $request->get('_token') != \Cache::get('_token_'.$request->get('_token'))) {
            abort(403, '上传失败，token错误');
        }

        $file = $request->file('file');

        if ($file && !$file->isValid()) {
            return abort(422, '上传失败');
        }
        $file->move('upload', $request->key);

        return [
            'key' => $request->key,
        ];
    }
}
