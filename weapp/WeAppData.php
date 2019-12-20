<?php
/**
 * Notes: 数据基类
 * Date: 2019/11/11
 * @author: 陈星星
 */

namespace Wechat\Weapp;


use Wechat\Curl\Request;

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
     * @param $config 配置列表
     */
    public function __construct($config=[])
    {
        if(!isset($config['appid'])){
            $this->appid = $config['appid'];
        }
        if(!isset($config['appSecret'])){
            $this->appSecret = $config['appSecret'];
        }
    }

    /**
     * 请求数据
     * @param $url 请求链接
     * @param null $post 请求参数
     * @return mixed
     * @throws WeAppException
     */
    public function getData($url,$post=null)
    {
        $data = Request::curl_request($url,$post);
        $data = json_decode($data,true);
        if($data['errcode']!=0){
            throw new WeAppException($data['errmsg']);
        }
        return $data;
    }
}