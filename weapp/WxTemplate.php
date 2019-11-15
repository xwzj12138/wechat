<?php
/**
 * Notes: 模板消息相关
 * 注意：小程序模板消息接口将于2020年1月10日下线，所以此处只使用公众号模板消息
 * Date: 2019/11/11
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class WxTemplate extends WeAppData
{

    /**
     * 设置行业可在微信公众平台后台完成，每月可修改行业1次
     * @param $access_token 接口权限值
     * @param $industry_id1 公众号模板消息所属行业编号
     * @return mixed
     * @throws WeAppException
     */
    public function setIndustry($access_token,$industry_id1)
    {
        $url = $this->domain.'cgi-bin/template/api_set_industry?access_token='.$access_token;
        return $this->getData($url,['industry_id1'=>$industry_id1]);
    }

    /**
     * 获取帐号设置的行业信息
     * @param $access_token
     * @return mixed
     * @throws WeAppException
     */
    public function getIndustry($access_token)
    {
        $url = $this->domain.'cgi-bin/template/get_industry?access_token='.$access_token;
        return $this->getData($url);
    }

    /**
     * 获取模板id
     * @param $template_id_short 模板编号
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getTemplateId($template_id_short,$access_token)
    {
        $url = $this->domain.'cgi-bin/template/api_add_template?access_token='.$access_token;
        return $this->getData($url,['template_id_short'=>$template_id_short]);
    }

    /**
     * 获取已添加至帐号下所有模板列表
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function getPrivateTemplate($access_token)
    {
        $url = $this->domain.'cgi-bin/template/get_all_private_template?access_token='.$access_token;
        return $this->getData($url);
    }
    /**
     * 删除模板
     * @param $template_id
     * @param $access_token
     * @return mixed
     * @throws WeAppException
     */
    public function delete($template_id,$access_token)
    {
        $url = $this->domain.'cgi-bin/template/del_private_template?access_token='.$access_token;
        return $this->getData($url,['template_id'=>$template_id]);
    }

    /**
     * 微信公众号发送模板消息
     * 注意：小程序模板消息接口将于2020年1月10日下线，所以此处只使用公众号模板消息
     * @param $post 微信公众发送的消息
     * @param $access_token 接口权限值
     * @return mixed
     * @throws WeAppException
     */
    public function send($post,$access_token)
    {
        //检测公众号消息参数验证
        if(empty($this->appid)){
            throw new WeAppException('公众号唯一标识不能为空');
        }elseif (empty($post['openid'])){
            throw new WeAppException('openid不能为空');
        }elseif (empty($post['template_id'])){
            throw new WeAppException('模板id不能为空');
        }elseif (empty($post['data'])){
            throw new WeAppException('公众号模板消息的数据不能为空');
        }
        //检查跳转的小程序信息是否存在
        if(!empty($post['miniprogram'])){
            if (empty($post['miniprogram']['appid'])){
                throw new WeAppException('所要跳转的小程序appid不能为空');
            }elseif (empty($post['miniprogram']['pagepath'])){
                throw new WeAppException('所要跳转的小程序pagepath不能为空');
            }
        }
        $post['appid'] = $this->appid;

        $url = $this->domain.'cgi-bin/message/template/send?access_token='.$access_token;
        return $this->getData($url,$post);
    }
}