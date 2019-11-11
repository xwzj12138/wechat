<?php
/**
 *
 * 扫码支付模式一生成二维码参数
 * @author xwzj
 *
 */

namespace Wechat\Pay;


class WxPayBizPayUrl extends WxPayDataBase
{
    private $url = 'weixin://wxpay/bizpayurl';
    /**
     * 设置随机字符串
     * @param string $value
     **/
    public function SetNonce_str($value)
    {
        $this->values['nonce_str'] = $value;
    }
    /**
     * 获取随机字符串的值
     * @return 值
     **/
    public function GetNonce_str()
    {
        return $this->values['nonce_str'];
    }
    /**
     * 判断随机字符串是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     * 设置商品ID
     * @param string $value
     **/
    public function SetProduct_id($value)
    {
        $this->values['product_id'] = $value;
    }
    /**
     * 获取商品ID的值
     * @return 值
     **/
    public function GetProduct_id()
    {
        return $this->values['product_id'];
    }
    /**
     * 判断商品ID是否存在
     * @return true 或 false
     **/
    public function IsProduct_idSet()
    {
        return array_key_exists('product_id', $this->values);
    }

    /**
     *
     * 生成二维码规则,模式一生成支付二维码
     * spbill_create_ip、nonce_str不需要填入
     * @throws WxPayException
     * @return string
     */
    public function bizpayurl()
    {
        if(!$this->IsProduct_idSet()){
            throw new WxPayException("生成二维码，缺少必填参数product_id！");
        }
        if(!$this->IsAppidSet()){
            throw new WxPayException("生成二维码，缺少必填参数appid！");
        }
        if(!$this->IsMch_idSet()){
            throw new WxPayException("生成二维码，缺少必填参数mch_id！");
        }
        $this->SetTime_stamp(time());//时间戳
        $this->SetNonce_str($this->getNonceStr());//随机字符串

        $this->SetSign();//签名

        $data = $this->GetValues();

        return $this->url.'?'.http_build_query($data);
    }
}