<?php
/**
 * Notes: 下单支付类
 * Date: 2019/11/11
 * @author: 陈星星
 */

//tp框架可以直接在控制器中使用，无需引入自动加载类
require_once '../vendor/autoload.php';

use Wechat\Pay\WxPayUnifiedOrder;
use Wechat\Pay\WxPayException;

//实际使用时，可以根据需求捕获异常信息
try{
    $inputObj = new WxPayUnifiedOrder();
    //支付类型：JSAPI，NATIVE，APP，
    $inputObj->SetTrade_type('APP');

    //设置商品或支付单简要描述
    $inputObj->SetBody('摩推支付');

    //用户唯一标识
    $inputObj->SetOpenid('gvdbgdsnbggcc');

    //商户订单号
    $inputObj->SetOut_trade_no('gvdbgdsnbggcc');

    //支付回调url
    $inputObj->SetNotify_url('http://');

    //设置appid
    $inputObj->SetAppid('vfdsbfdsbfdsdf');

    //设置商户号
    $inputObj->SetMch_id('vcdsbgffsbfd');

    //商户平台支付秘钥
    $inputObj->SetPartnerkey('sdadf');

    //设置支付价格，单位：分
    $inputObj->SetTotal_fee(5*100);

    //请求统一下单接口，获取预支付交易会话ID
    $wx_pay = $inputObj->unifiedOrder();

    if($wx_pay['return_code']!="SUCCESS" || $wx_pay['result_code'] !="SUCCESS")
    {
        $msg = empty($wx_pay['err_code_des'])?$wx_pay['return_msg']:$wx_pay['err_code_des'];
        throw new WxPayException($msg);
    }elseif ($wx_pay['trade_type']=='NATIVE'){
        //扫码支付模式二不需要再次签名，可以直接获取url
        //code_url的值并非固定，使用时按照URL格式转成二维码即可
        return $wx_pay['code_url'];
    }
    $data = $inputObj->getPayInfo($wx_pay);
}catch (\Exception $e){
    echo $e->getMessage();
}