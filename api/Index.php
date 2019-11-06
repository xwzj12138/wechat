<?php
/**
 * Notes:
 * Date: 2019/11/6
 * @author: 陈星星
 */

namespace api;


use Wechat\Pay\WxPayApi;
use Wechat\Pay\WxPayException;
use Wechat\Pay\WxPayUnifiedOrder;

class Index
{
    public function index()
    {
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

            //设置支付价格，单位：分
            $inputObj->SetTotal_fee(5*100);

            //请求统一下单接口，获取预支付交易会话ID
            $wx_pay = WxPayApi::unifiedOrder($inputObj);
            if($wx_pay['return_code']!="SUCCESS" || $wx_pay['result_code'] !="SUCCESS")
            {
                $msg = empty($wx_pay['err_code_des'])?$wx_pay['return_msg']:$wx_pay['err_code_des'];
                throw new WxPayException($msg);
            }

            //获取支付签名等信息,扫码支付不需要再次签名，可以直接获取url
            $data = $inputObj->getPayInfo($wx_pay);
        }catch (\Exception $e){
            echo $e->getMessage();
        }
    }
}