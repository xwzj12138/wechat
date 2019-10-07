<?php
/**
 * WechatSDK 异常类
 */

namespace Wechat\Exception;


class WxPayException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}