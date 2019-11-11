# wechat
微信相关SDK

## Installation

Use [Composer](https://getcomposer.org/) to install the library.

``` bash
composer require xwzj/wechat
```
## 小程序，公众号，H5支付，App支付，扫码支付模式二

```php
<?php

//tp或其他框架可以直接在控制器中使用，无需引入自动加载类
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
        //扫码支付不需要再次签名，可以直接获取url
        //code_url的值并非固定，使用时按照URL格式转成二维码即可
        return $wx_pay['code_url'];
    }
    $data = $inputObj->getPayInfo($wx_pay);
}catch (\Exception $e){
    echo $e->getMessage();
}
```

## 支付回调  （小程序，公众号，H5支付，App支付，扫码支付模式二）

```php
<?php

//tp或其他框架可以直接在控制器中使用，无需引入自动加载类
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
```

## 申请退款

```php
<?php

//tp或其他框架可以直接在控制器中使用，无需引入自动加载类
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
```

## 扫码支付模式一

```php
<?php

//tp或其他框架可以直接在控制器中使用，无需引入自动加载类
require_once '../vendor/autoload.php';

$inputObj = new \Wechat\Pay\WxPayBizPayUrl();

$inputObj->SetAppid('应用的唯一标识');

$inputObj->SetMch_id('商户号');

$inputObj->SetProduct_id('商品ID');

$inputObj->SetPartnerkey('商户平台秘钥');

//获取二维码内容
$qr_code_content = $inputObj->bizpayurl();

//生成二维码,可以使用QRCode生成二维码在保存在本地。前端使用二维码url访问即可

```