<?php
/**
 * Notes: 数据基类
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
}