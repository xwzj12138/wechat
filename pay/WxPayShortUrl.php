<?php
/**
 *
 * 短链转换输入对象
 * @author xwzj
 *
 */

namespace Wechat\Pay;


class WxPayShortUrl extends WxPayDataBase
{

    /**
     * 设置需要转换的URL，签名用原串，传输需URL encode
     * @param string $value
     **/
    public function SetLong_url($value)
    {
        $this->values['long_url'] = $value;
    }

    /**
     * 获取需要转换的URL，签名用原串，传输需URL encode的值
     * @return 值
     **/
    public function GetLong_url()
    {
        return $this->values['long_url'];
    }

    /**
     * 判断需要转换的URL，签名用原串，传输需URL encode是否存在
     * @return true 或 false
     **/
    public function IsLong_urlSet()
    {
        return array_key_exists('long_url', $this->values);
    }

    /**
     * 设置随机字符串，不长于32位。推荐随机数生成算法
     * @param string $value
     **/
    public function SetNonce_str($value)
    {
        $this->values['nonce_str'] = $value;
    }

    /**
     * 获取随机字符串，不长于32位。推荐随机数生成算法的值
     * @return 值
     **/
    public function GetNonce_str()
    {
        return $this->values['nonce_str'];
    }

    /**
     * 判断随机字符串，不长于32位。推荐随机数生成算法是否存在
     * @return true 或 false
     **/
    public function IsNonce_strSet()
    {
        return array_key_exists('nonce_str', $this->values);
    }

    /**
     *
     * 转换短链接
     * 该接口主要用于扫码原生支付模式一中的二维码链接转成短链接(weixin://wxpay/s/XXXXXX)，
     * 减小二维码数据量，提升扫描速度和精确度。
     * appid、mchid、spbill_create_ip、nonce_str不需要填入
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function shorturl($timeOut = 6)
    {
        $url = "https://api.mch.weixin.qq.com/tools/shorturl";
        //检测必填参数
        if(!$this->IsLong_urlSet()) {
            throw new WxPayException("需要转换的URL，签名用原串，传输需URL encode！");
        }
        $this->SetNonce_str($this->getNonceStr());//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();

        $response = $this->postXmlCurl($xml, $url,$timeOut);
        return $this->xmlToArray($response);
    }
}