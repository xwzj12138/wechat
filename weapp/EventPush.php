<?php
/**
 * Notes: 微信公众号事件推送类
 * Date: 2019/11/12
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class EventPush
{
    /**
     * 获取推送的数据并验证签名，判断是否微信推送的
     * @param $token 签名token值，必须与微信公众号设置的token一致
     * @param $callback 回调函数，签名验证成功后的回调，回调参数，$push_data：微信推送的数据 $send_obj，消息发送对象
     * @return bool|mixed
     */
    public static function getData($token,$callback)
    {
        if(empty($_GET['signature'])) return 'success';
        if(empty($_GET['timestamp'])) return 'success';
        if(empty($_GET['nonce'])) return 'success';
        $tmpArray = array($token,$_GET['timestamp'],$_GET['nonce']);
        sort($tmpArray,SORT_STRING);
        $tmpstr = implode($tmpArray);
        $tmpstr = sha1($tmpstr);
        //初次验证签名，直接返回随机字符串echostr
        if($tmpstr==$_GET['signature']){
            if(isset($_GET['echostr'])){
                return $_GET['echostr'];
            }
            //获取事件推送的数据对象
            $push_data = self::xmlToArray();
            $send_obj = new SendEventPushMsg($push_data['FromUserName'],$push_data['ToUserName']);
            return call_user_func($callback, $push_data,$send_obj);
        }
        return 'success';
    }

    /**
     * 获取事件推送的数据并转为数组
     * @return mixed
     */
    protected static function xmlToArray()
    {
        $xml = file_get_contents("php://input");
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
}