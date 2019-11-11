<?php
/**
 * Notes: 退款类
 * Date: 2019/11/11
 * @author: 陈星星
 */

require_once '../vendor/autoload.php';

$inputObj = new \Wechat\Pay\WxPayRefund();

//商户订单号，微信支付订单号两者至少要有一个
$inputObj->SetOut_trade_no('退款订单对应的订单号');

$inputObj->SetTransaction_id('微信支付订单号');

$inputObj->SetOut_refund_no('商户内部退款订单号');

$inputObj->SetTotal_fee('订单总金额');

$inputObj->SetRefund_fee('退款金额');

$inputObj->SetOp_user_id('设置操作员账号，可以直接使用商户号');

//请求退款
$data = $inputObj->refund();