<?php
/**
 * Notes:微信网页js相关SDK
 * Date: 2020/3/2
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class Jssdk extends WeAppData
{
    /**
     * 网页授权
     * @param $redirect_url 授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
     * @param string $scope 应用授权作用域，
     * snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），
     * snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且， 即使在未关注的情况下，只要用户授权，也能获取其信息 ）
     * @param string $state
     */
    public function auth($redirect_url,$scope='snsapi_userinfo',$state=null)
    {
        $redirect_url = urlencode($redirect_url);
        $url = $this->domain.'/connect/oauth2/authorize?appid='.$this->appid.'&redirect_uri='.$redirect_url.'&response_type=code&scope='.$scope;
        if($state) $url.'&state='.$state;
        $url = $url.'#wechat_redirect';
        header('location:'.$url);
    }

    /**
     * 获取 jsapi_ticket
     * @param $token 全局接口请求token
     * @return mixed
     * @throws WeAppException
     */
    public function getTicket($token)
    {
        $url = $this->domain.'cgi-bin/ticket/getticket?access_token='.$token.'&type=jsapi';
        return $this->getData($url);
    }

    /**
     * js签名
     * @param $jsapi_ticket  JS API的临时票据
     * @param $noncestr 随机字符串
     * @param $timestamp 时间戳
     * @param $url 当前网页的URL，不包含#及其后面部分
     * @return string 返回签名字符串
     */
    private function signature($jsapi_ticket,$noncestr,$timestamp,$url)
    {
        $str = 'jsapi_ticket='.$jsapi_ticket.'&noncestr='.$noncestr.'&timestamp='.$timestamp.'&url='.$url;
        return sha1($str);
    }

    /**
     * 获取js-sdk 配置参数
     * @param $jsapi_ticket JS API的临时票据
     * @param $url 当前网页的URL，不包含#及其后面部分
     * @param array $jsApiList 需要使用的JS接口列表
     * @return array 返回js-sdk需要的所有参数
     * @throws WeAppException
     */
    public function getJsConfig($jsapi_ticket,$url,$jsApiList=[])
    {
        if(empty($this->appid)) throw new WeAppException('appid不能为空');
        $time = time();
        $nonceStr = $this->getNonceStr();
        return [
            'appId'=>$this->appid,
            'timestamp'=>$time,
            'nonceStr'=>$nonceStr,
            'signature'=>$this->signature($jsapi_ticket,$nonceStr,$time,$url),
            'jsApiList'=>$jsApiList
        ];
    }

    /**
     *  生成随机字符串
     */
    private function getNonceStr($length = 32)
    {
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }
}