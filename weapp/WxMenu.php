<?php
/**
 * Notes: 微信公众号菜单栏相关
 * Date: 2019/11/15
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class WxMenu extends WeAppData
{
    /**
     * 创建菜单栏
     * @param $access_token 接口权限值
     * @param $post
     * @return mixed
     * @throws WeAppException
     */
    public function create($access_token,$post)
    {
        if (empty($post['button'])) throw new WeAppException('请设置一级按钮');
        foreach ($post['button'] as $k => $item) {
            if (empty($item['name'])) throw new WeAppException('请设置第' . $k . '个一级按钮名称');
            if (!empty($item['sub_button'])) {
                foreach ($item['sub_button'] as $i => $v) {
                    if (empty($item['name'])) throw new WeAppException('请设置第' . $k . '个一级按钮下个的第' . $i . '个二级按钮名不能为空');
                }
            }
        }
        $url = $this->domain . 'cgi-bin/menu/create?access_token=' . $access_token;
        return $this->getData($url, $post);
    }

    /**
     * 查询菜单栏
     * @param $access_token
     * @return mixed
     * @throws WeAppException
     */
    public function getMenuInfo($access_token)
    {
        $url = $this->domain . 'cgi-bin/get_current_selfmenu_info?access_token=' . $access_token;
        return $this->getData($url);
    }

    /**
     * 删除菜单栏
     * @param $access_token
     * @return mixed
     * @throws WeAppException
     */
    public function delete($access_token)
    {
        $url = $this->domain . 'cgi-bin/menu/delete?access_token=' . $access_token;
        return $this->getData($url);
    }
}
