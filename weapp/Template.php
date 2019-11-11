<?php
/**
 * Notes:
 * Date: 2019/11/11
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class Template extends WeAppData
{
    //请求的域名
    const domain = 'https://api.weixin.qq.com/';
    /**
     * 添加模板
     * @param $template_id 模板id
     * @param $keyword_id_list 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如[3,5,4]或[4,5,3]），最多支持10个关键词组合
     * @param $access_token 接口权限值值access_token
     * @return mixed
     * @throws WeAppException
     */
    public static function add($template_id,$keyword_id_list,$access_token)
    {
        $url = self::domain.'cgi-bin/wxopen/template/add?access_token='.$access_token;
        return self::getData($url,['id'=>$template_id,'keyword_id_list'=>$keyword_id_list]);
    }

    /**
     * 删除模板
     * @param $template_id
     * @param $access_token
     */
    public static function dellete($template_id,$access_token){}
    /**
     * 发送模板消息
     * @param $post
     * @param $token
     * @return mixed
     * @throws WeAppException
     */
    public function send($post,$access_token)
    {
        $url = $this->domain.'cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        return $this->getData($url,$post);
    }
}