<?php
/**
 * Notes: curl请求封装类
 * Date: 2019/11/11
 * @author: 陈星星
 */

namespace Wechat\Curl;

class Request
{
    /**
     * 请求封装类
     * @param $url 请求链接
     * @param null $post 发送的数据
     * @param int $second 请求超时时间，超过这个时间自动断开请求
     * @return mixed
     */
    public static function curl_request($url,$post=null,$second = 10)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);

        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            throw new WeAppException("curl出错，错误码:$error");
        }
    }
}