<?php
/**
 * Notes: 微信异常处理
 * Date: 2019/11/1
 * @author: 陈星星
 */

namespace Wechat\Pay;


class WxPayException extends \Exception
{
    public function errorMessage()
    {
        return $this->getMessage();
    }
}