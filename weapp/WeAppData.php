<?php
/**
 * Notes: 小程序数据类
 * Date: 2019/11/11
 * @author: 陈星星
 */

namespace Wechat\Weapp;


use Wechat\curl\Request;

class WeAppData
{
    //小程序标识
    public $appid;
    //小程序秘钥
    public $appSecret;
    //请求的域名
    protected $domain = 'https://api.weixin.qq.com/';

    /**
     * WeAppData constructor.
     * @param $appid 小程序唯一标识
     * @param $appSecret 小程序秘钥
     */
    public function __construct($appid,$appSecret)
    {
        $this->appid = $appid;
        $this->appSecret = $appSecret;
    }

    /**
     * 请求数据
     * @param $url 请求链接
     * @param null $post 请求参数
     * @return mixed
     * @throws WeAppException
     */
    public static function getData($url,$post=null)
    {
        $data = Request::curl_request($url,$post);
        if($data['errcode']!=0){
            throw new WeAppException($data['errmsg']);
        }
        return $data;
    }

    /**
     * 获取用户信息
     * @param $code 用户登录授权的code，wx.login()返回的code
     * @return mixed 返回用户信息
     * ['openid'=>'用户唯一标识','session_key'=>'会话密钥','errcode'=>'错误码','errmsg'=>'错误信息',
     * 'unionid'=>'用户在开放平台的唯一标识符，在满足 UnionID 下发条件的情况下会返回'
     * ]
     * @throws WeAppException
     */
    public function getUserInfo($code)
    {
        $url = $this->domain.'sns/jscode2session?appid='.$this->appid.'&secret='.$this->appSecret.'&js_code='.$code.'&grant_type=authorization_code';
        $data = Request::curl_request($url);
        if(!empty($data['errcode'])){
            throw new WeAppException($data['errmsg']);
        }
        return $data;
    }

    /**
     * 获取接口权限值access_token
     * @return mixed
     * @throws WeAppException
     */
    public function getAccessToken()
    {
        $url = $this->domain.'cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appSecret;
        $data = Request::curl_request($url);
        if(!empty($data['errcode'])){
            throw new WeAppException($data['errmsg']);
        }
        return $data;
    }

}