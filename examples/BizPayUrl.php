<?php
/**
 * Notes: 扫码支付模式一
 * Date: 2019/11/11
 * @author: 陈星星
 */

require_once '../vendor/autoload.php';

$inputObj = new \Wechat\Pay\WxPayBizPayUrl(['partnerkey'=>'支付秘钥，用于签名验证','appid'=>'微信应用的唯一标识appid']);
//重置appid
$inputObj->SetAppid('应用的唯一标识');

$inputObj->SetMch_id('商户号');

$inputObj->SetProduct_id('商品ID');

//获取二维码内容
$qr_code_content = $inputObj->bizpayurl();

//生成二维码,可以使用QRCode生成二维码在保存在本地。前端使用二维码url访问即可