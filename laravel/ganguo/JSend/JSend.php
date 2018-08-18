<?php

namespace Ganguo\JSend;

use Illuminate\Support\Collection;

class JSend
{
    /**
     * @param $data
     *
     * @return array|null|string
     */
    private function toString($data)
    {
        if ($data instanceof Collection) {
            return self::toString(
                $data->map(function ($item) {
                    return self::toString($item);
                })
                    ->all()
            );
        } elseif (is_object($data)) {
            if (method_exists($data, 'toArray')) {
                return self::toString($data->toArray());
            } elseif (method_exists($data, 'getAttributes')) {
                return self::toString($data->getAttributes());
            } elseif (method_exists($data, '__toString')) {
                return $data->__toString();
            } elseif ('stdClass' === get_class($data) && $data === new \stdClass()) {
                return null;
            } else {
                return self::toString((array) $data);
            }
        } elseif (is_array($data)) {
            $output = [];
            foreach ($data as $key => $value) {
                $output[$key] = self::toString($value);
            }

            return $output;
        } else {
            return $data;
        }
    }

    /**
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function success($data = null)
    {
        $success = JSendResponse::success(static::toString($data));

        return response()->json($success->toArray(), 200);
    }

    /**
     * @param null $errorMessage
     * @param null $errorCode
     * @param null $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function error($errorMessage = null, $errorCode = null, $data = null)
    {
        $error = JSendResponse::error($errorMessage, $errorCode, static::toString($data));

        $status = 202;
        if ($errorCode >= 400 && $errorCode < 600) {
            $status = $errorCode;
        }

        return response()->json($error->toArray(), $status);
    }
}
