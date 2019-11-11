<?php
/**
 *
 * 下载对账单输入对象
 * @author xwzj
 *
 */

namespace Wechat\Pay;


class WxPayDownloadBill extends WxPayDataBase
{
    /**
     * 设置微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单
     * @param string $value
     **/
    public function SetDevice_info($value)
    {
        $this->values['device_info'] = $value;
    }
    /**
     * 获取微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单的值
     * @return 值
     **/
    public function GetDevice_info()
    {
        return $this->values['device_info'];
    }
    /**
     * 判断微信支付分配的终端设备号，填写此字段，只下载该设备号的对账单是否存在
     * @return true 或 false
     **/
    public function IsDevice_infoSet()
    {
        return array_key_exists('device_info', $this->values);
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
     * 设置下载对账单的日期，格式：20140603
     * @param string $value
     **/
    public function SetBill_date($value)
    {
        $this->values['bill_date'] = $value;
    }
    /**
     * 获取下载对账单的日期，格式：20140603的值
     * @return 值
     **/
    public function GetBill_date()
    {
        return $this->values['bill_date'];
    }
    /**
     * 判断下载对账单的日期，格式：20140603是否存在
     * @return true 或 false
     **/
    public function IsBill_dateSet()
    {
        return array_key_exists('bill_date', $this->values);
    }


    /**
     * 设置ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单
     * @param string $value
     **/
    public function SetBill_type($value)
    {
        $this->values['bill_type'] = $value;
    }
    /**
     * 获取ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单的值
     * @return 值
     **/
    public function GetBill_type()
    {
        return $this->values['bill_type'];
    }
    /**
     * 判断ALL，返回当日所有订单信息，默认值SUCCESS，返回当日成功支付的订单REFUND，返回当日退款订单REVOKED，已撤销的订单是否存在
     * @return true 或 false
     **/
    public function IsBill_typeSet()
    {
        return array_key_exists('bill_type', $this->values);
    }

    /**
     * 下载对账单，参数appid、mchid、bill_date为必填参数
     * spbill_create_ip、nonce_str不需要填入
     * @param WxPayDownloadBill $inputObj
     * @param int $timeOut
     * @throws WxPayException
     * @return 成功时返回，其他抛异常
     */
    public function downloadBill($timeOut = 6)
    {
        $url = "https://api.mch.weixin.qq.com/pay/downloadbill";
        //检测必填参数
        if(!$this->IsBill_dateSet()) {
            throw new WxPayException("对账单接口中，缺少必填参数bill_date！");
        }
        $this->SetNonce_str($this->getNonceStr());//随机字符串

        $this->SetSign();//签名
        $xml = $this->ToXml();

        $response = $this->postXmlCurl($xml, $url, $timeOut);
        if(substr($response, 0 , 5) == "<xml>"){
            return "";
        }
        return $response;
    }
}