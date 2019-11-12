<?php
/**
 * Notes: 支付回调通知
 * Date: 2019/11/1
 * @author: 陈星星
 */

namespace Wechat\Pay;


class WxPayNotify extends WxPayDataBase
{
    //返回数据是否需要签名
    public $needSign = false;
    //返回的状态码
    public $return_code = 'SUCCESS';
    //返回信息
    public $return_msg = 'OK';

    /**
     * 支付结果通用通知
     * @param $callback
     * 直接回调函数使用方法: notify(you_function);
     * 回调类成员函数方法:notify(array($this, you_function));
     * @return bool|mixed
     */
    public static function notify($callback)
    {
        //获取通知的数据
        $xml = file_get_contents('php://input');
        $baseObj = new self();
        //如果返回成功则验证签名
        try {
            $result = $baseObj->xmlToArray($xml);
            call_user_func($callback, $result);
        } catch (WxPayException $e){
            $baseObj->return_code = 'FAIL';
            $baseObj->return_msg = $e->getMessage();
        }
        return $baseObj->returnData();
    }

    /**
     * 回调入口
     */
    public function Handle()
    {
        //获取通知的数据
        WxPayNotify::notify(array($this,'NotifyProcess'));
        return $this->GetValues();
    }

    /**
     *
     * 回调方法入口，子类可重写该方法
     * 注意：
     * 1、微信回调超时时间为2s，建议用户使用异步处理流程，确认成功之后立刻回复微信服务器
     * 2、微信服务器在调用失败或者接到回包为非确认包的时候，会发起重试，需确保你的回调是可以重入
     * @param array $data 回调解释出的参数
     * @param string $msg 如果回调处理失败，可以将错误信息输出到该方法
     * @return true回调出来完成不需要继续回调，false回调处理未完成需要继续回调
     */
    protected function NotifyProcess($data)
    {
        //TODO 用户基础该类之后需要重写该方法，成功的时候不需要处理，失败返回抛出WxPayException异常类即可
    }

    /**
     * 输出xml
     */
    protected function returnData()
    {
        $this->FromArray(['return_code'=>$this->return_code,'return_msg'=>$this->return_msg]);
        if($this->needSign && $this->return_code=='SUCCESS'){
            $this->SetSign();
        }
        $xml = $this->ToXml();
        echo $xml;
    }
}