<?php
/**
 * Created by PhpStorm.
 * User: stevie
 * Date: 2017/4/13
 * Time: 13:17.
 */

namespace Ganguo\AlipayAop;

interface AlipayRequestInterface
{
    public function setBizContent($bizContent);

    public function getApiMethodName();
}
