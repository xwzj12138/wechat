<?php
/**
 * Notes:订阅模板消息类
 * Date: 2019/12/16
 * @author: 陈星星
 */

namespace Wechat\Weapp;


use Wechat\Curl\Request;

class WeappTemplate extends WeAppData
{
    /**
     * 添加订阅模板消息
     * @param $access_token 接口权限值
     * @param $tid 模板标题 id，可通过接口获取，也可登录小程序后台查看获取
     * @param $kidList 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配
     * （例如 [3,5,4] 或 [4,5,3]），最多支持5个，最少2个关键词组合
     * @param string $sceneDesc 服务场景描述，15个字以内
     * @return mixed
     * @throws WeAppException
     */
    public function create($access_token,$tid,$kidList,$sceneDesc='')
    {
        $url = $this->domain.'wxaapi/newtmpl/addtemplate?access_token='.$access_token;
        return $this->getData($url,['tid'=>$tid,'kidList'=>$kidList,'sceneDesc'=>$sceneDesc]);
    }

    /**
     * 删除订阅模板
     * @param $access_token 接口权限值
     * @param $priTmplId 模板id
     * @return mixed
     * @throws WeAppException
     */
    public function delTemplate($access_token,$priTmplId)
    {
        $url = $this->domain.'wxaapi/newtmpl/deltemplate?access_token='.$access_token;
        return $this->getData($url,['priTmplId'=>$priTmplId]);
    }

    /**
     * 获取小程序账号的类目
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getCategory($access_token)
    {
        $url = $this->domain.'wxaapi/newtmpl/getcategory?access_token='.$access_token;
        return $this->getData($url);
    }

    /**
     * 获取模板标题下的关键词列表
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getPubtemplateKeywords($access_token,$tid)
    {
        $url = $this->domain.'wxaapi/newtmpl/getpubtemplatekeywords?access_token='.$access_token;
        return $this->getData($url,['tid'=>$tid]);
    }

    /**
     * 获取帐号所属类目下的公共模板标题
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getPubtemplatetitles($access_token,$ids,$start=0,$limit=25)
    {
        if($start<0) throw new WeAppException('start最小为0');
        if($limit>30) throw new WeAppException('limit最大为30');
        $url = $this->domain.'wxaapi/newtmpl/getpubtemplatetitles?access_token='.$access_token;
        return $this->getData($url,['ids'=>$ids,'start'=>$start,'limit'=>$limit]);
    }

    /**
     * 获取当前帐号下的个人模板列表
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getTemplate($access_token)
    {
        $url = $this->domain.'wxaapi/newtmpl/gettemplate?access_token='.$access_token;
        return $this->getData($url);
    }

    /**
     * 发送小程序订阅消息模板
     * @param $post 请求的参数
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function sendSubscribeMessage($access_token,$post)
    {
        if (empty($post['openid'])){
            throw new WeAppException('openid不能为空');
        }elseif (empty($post['template_id'])){
            throw new WeAppException('模板id不能为空');
        }elseif (empty($post['data'])){
            throw new WeAppException('公众号模板消息的数据不能为空');
        }
        $url = $this->domain.'cgi-bin/message/subscribe/send?access_token='.$access_token;
        return Request::curl_request($url,$post);
    }
}