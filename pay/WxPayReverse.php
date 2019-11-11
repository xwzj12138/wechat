<?php
/**
 *
 * 撤销输入对象
 * @author xwzj
 *
 */

namespace Wechat\Pay;


class WxPayReverse extends WxPayDataBase
{
    //api证书公钥文件
    protected $sslcert_path;
    //api证书私钥
    protected $sslkey_path;
    /**
     * 设置微信的订单号，优先使用
     * @param string $value
     **/
    public function SetTransaction_id($value)
    {
        $this->values['transaction_id'] = $value;
    }
    /**
     * 获取微信的订单号，优先使用的值
     * @return 值
     **/
    public function GetTransaction_id()
    {
        return $this->values['transaction_id'];
    }
    /**
     * 判断微信的订单号，优先使用是否存在
     * @return true 或 false
     **/
    public function IsTransaction_idSet()
    {
        return array_key_exists('transaction_id', $this->values);
    }


    /**
     * 设置商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no
     * @param string $value
     **/
    public function SetOut_trade_no($value)
    {
        $this->values['out_trade_no'] = $value;
    }
    /**
     * 获取商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no的值
     * @return 值
     **/
    public function GetOut_trade_no()
    {
        return $this->values['out_trade_no'];
    }
    /**
     * 判断商户系统内部的订单号,transaction_id、out_trade_no二选一，如果同时存在优先级：transaction_id> out_trade_no是否存在
     * @return true 或 false
     **/
    public function IsOut_trade_noSet()
    {
        return array_key_exists('out_trade_no', $this->values);
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
     * 设置证书
     * @param string $value
     **/
    public function SetSslcert_path($value)
    {
        $this->sslcert_path = $value;
    }
    /**
     * 设置证书
     * @return 值
     **/
    public function GetSslcert_path()
    {
        return $this->sslcert_path;
    }

    /**
     * 设置证书
     * @param string $value
     **/
    public function SetSslkey_path($value)
    {
        $this->sslkey_path = $value;
    }
    /**
     * 设置证书
     * @return 值
     **/
    public function GetSslkey_path()
    {
        return $this->sslkey_path;
    }

    /**
     * 撤销订单API接口，参数appid、mchid、out_trade_no和transaction_id必须填写一个
     * spbill_create_ip、nonce_str不需要填入
     * @param $inputObj
     * @param int $timeOut
     * @return array
     * @throws WxPayException
     */
    public function reverse($timeOut = 6)
    {
        $url = "https://api.mch.weixin.qq.com/secapi/pay/reverse";
        //检测必填参数
        if(!$this->IsOut_trade_noSet() && !$this->IsTransaction_idSet()) {
            throw new WxPayException("撤销订单API接口中，参数out_trade_no和transaction_id必须填写一个！");
        }
        if($this->GetSslkey_path()==null || $this->GetSslcert_path()==null){
            throw new WxPayException("该接口必须使用api证书，请设置api证书文件路径");
        }
        $this->SetNonce_str($this->getNonceStr());//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();

        $response = $this->postXmlCurl($xml, $url, $timeOut,$this->GetSslcert_path(),$this->GetSslkey_path());
        return $this->xmlToArray($response);
    }
}