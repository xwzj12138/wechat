<?php
/**
 * Notes: 微信事件推送
 * Date: 2019/11/12
 * @author: 陈星星
 */

require_once '../vendor/autoload.php';


echo \Wechat\Weapp\EventPush::getData('111111',function ($push_data,$send_obj){
    switch (strtolower($push_data['MsgType'])){
        case 'event':
            switch (strtolower($push_data['Event'])){
                case 'subscribe':
                    //关注关注事件，这里分为直接关注事件和扫描带参数二维码事件,还未关注时的事件推送
                    return $send_obj->text('欢迎关注公众号');
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