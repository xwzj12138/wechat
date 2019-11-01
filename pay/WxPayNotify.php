<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/5/25
 * Time: 12:34
 */

namespace Wechat\Pay;


class WxPayNotify extends WxPayDataBase
{

    protected $FromXml;
    /**
     * 回调入口
     */
    public function Handle()
    {
        //获取通知的数据
        $this->FromXml = file_get_contents('php://input');
        try{
            //将xml转数组
            $values = $this->FromXml($this->FromXml);
            if($values['return_code']!='SUCCESS'){
                return $this->returnData(['return_code'=>'FAIL','return_msg'=>'错误不需要回调']);
            }
            //如果返回成功则验证签名
            $this->CheckSign();
        }catch (\Exception $e){
            return $this->returnData(['return_code'=>'FAIL','return_msg'=>$e->msg]);
        }
        return $this->GetValues();
    }

    /**
     * 输出xml
     */
    public function returnData($data=['return_code'=>'SUCCESS','return_msg'=>'ok'])
    {
        $this->values = $data;
        $xml = $this->ToXml();
        echo $xml;
    }
}