<?php
/**
 * Notes: 支付通知
 * Date: 2019/11/11
 * @author: 陈星星
 */

require_once '../vendor/autoload.php';

$pay_notify = new \Wechat\Pay\WxPayNotify(['partnerkey'=>'支付秘钥，用于签名验证','appid'=>'微信应用的唯一标识appid']);

return $pay_notify->notify(function ($result){
});