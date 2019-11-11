<?php
/**
 * Notes: 支付通知
 * Date: 2019/11/11
 * @author: 陈星星
 */

require_once '../vendor/autoload.php';

\Wechat\Pay\WxPayNotify::notify(function ($result){
    //处理回调结果,$result为数组
    //根据商户订单号判断是否已经支付成功
    if($result['out_trade_no']=='支付成功'){
        return true;
    }
    //记录微信支付订单号
    $result['transaction_id'];
    //支付完成时间
    $result['time_end'];
    //修改支付记录，修改订单状态
    //如果修改失败
    throw new \Wechat\Pay\WxPayException('异常信息');
});