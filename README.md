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

## 事件推送相关

```php

//tp或其他框架可以直接在控制器中使用，无需引入自动加载类
require_once '../vendor/autoload.php';

//tp5以上可以直接return即可，其他框架可以根据框架需求返回
echo \Wechat\Weapp\EventPush::getData('111111',function ($push_data){
    switch (strtolower($push_data['MsgType'])){
        case 'event':
            switch (strtolower($push_data['Event'])){
                case 'subscribe':
                    //关注关注事件，这里分为直接关注事件和扫描带参数二维码事件,还未关注时的事件推送
                    return (new \Wechat\Weapp\SendEventPushMsg())->text('欢迎关注公众号');
                    break;
                case 'unsubscribe':
                    //取消关注事件
                    break;
                case 'SCAN':
                    //扫描带参数二维码事件,用户已关注时的事件推送
                    break;
                case 'LOCATION':
                    //上报地理位置事件
                    break;
                case 'CLICK':
                    //自定义菜单事件
                    break;
            }
            break;
        case 'text':
            //文本消息
            break;
        case 'image':
            //图片消息
            break;
        case 'voice':
            //语音消息
            break;
        case 'video':
            //视频消息
            break;
        case 'shortvideo':
            //小视频消息
            break;
        case 'location':
            //地理位置消息
            break;
        case 'link':
            //链接消息
            break;
    }
});
```

*****

> 所有代码api都可以在examples目录中查看

----
## 目录结构

~~~
wechat  SDK根目录
├─curl           curl封装代码目录
│  ├─Request             请求类
│
├─examples                  示例代码目录
│  ├─BizPayUrl.php          扫码支付模式一示例代码
│  ├─PayNotify.php          微信支付回调通知示例代码
│  └─PayUnifiedOrder        微信支付示例代码
│  └─Refund                 退款示例代码
│  └─WxEventPush            微信事件推送
│
├─pay                        支付相关代码目录
│  ├─WxPayBizPayUrl.php     扫码支付模式一生成二维码参数
│  ├─WxPayCloseOrder.php    关闭订单输入对象
│  └─WxPayDataBase          基础数据类
│  └─WxPayDownloadBill      下载对账单输入对象
│  └─WxPayException         微信异常处理
│  └─WxPayMicroPay          提交被扫输入对象
│  └─WxPayNotify            支付回调通知
│  └─WxPayOrderQuery        订单查询
│  └─WxPayRefund            提交退款
│  └─WxPayRefundQuery       退款查询
│  └─WxPayReverse           撤销输入
│  └─WxPayShortUrl          短链转换
│  └─WxPayUnifiedOrder      统一下单输入对象
│
├─weapp                      公众号及小程序相关SDK
│  ├─EventPush.php          微信公众号事件推送类
│  ├─SendEventPushMsg.php   消息推送信息返回格式化类
│  └─WeAppData              数据基类
│  └─WeAppException         微信异常处理
│  └─WxTemplate             模板消息相关
│  └─WxUser                 微信用户相关
│
~~~