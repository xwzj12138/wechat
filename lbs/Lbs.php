<?php
/**
 * Notes:腾讯地图定位相关
 * Date: 2019/12/20
 * @author: 陈星星
 */

namespace Wechat\Lbs;


use Wechat\Curl\Request;
use Wechat\Weapp\WeAppException;

class Lbs
{
    //腾讯地图开放平台秘钥
    public $key;

    /**
     * 构造函数
     */
    public function __construct($locationKey)
    {
        $this->key = $locationKey;
    }

    /**
     * 请求基类
     * @param $url 请求url
     * @param null $param post请求参数
     * @return mixed
     * @throws WeAppException
     */
    public function base($url,$param=null)
    {
        $data = Request::curl_request($url,$param);
        if($data['status']!=0){
            throw new WeAppException($data['message']);
        }
        return $data;
    }

    /**
     * 获取地址的坐标
     */
    public function getLocation($address)
    {
        $url = 'https://apis.map.qq.com/ws/geocoder/v1/';
        $param = ['key'=>$this->key,'address'=>$address];
        $data = $this->base($url,$param);
        return $data['result'];
    }
    /**
     * 根据坐标获取地址
     */
    public function getAddress($lat,$lng,$page_index=0)
    {
        $url = 'https://apis.map.qq.com/ws/geocoder/v1/';
        $param = ['key'=>$this->key,'location'=>$lat.','.$lng];
        if($page_index>0){
            $param['get_poi'] = 1;
            $param['poi_options'] = 'address_format=short;radius=1000;page_size=20;policy=1;page_index=1'.$page_index;
        }
        $data = $this->base($url,$param);
        return $data['result'];
    }
    /**
     * 根据关键字搜索
     */
    public function search($region,$keyword)
    {
        $url = 'https://apis.map.qq.com/ws/place/v1/suggestion?key='.$this->key.'&region='.$region.'&keyword='.$keyword;
        $data = $this->base($url);
        return $data;
    }
}