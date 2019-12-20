<?php
/**
 * Notes: 微信用户相关
 * Date: 2019/11/12
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class WxUser extends WeAppData
{
    /**
     * 获取小程序授权信息
     * @param $code 用户登录授权的code，wx.login()返回的code
     * @return mixed 返回用户信息
     * ['openid'=>'用户唯一标识','session_key'=>'会话密钥','errcode'=>'错误码','errmsg'=>'错误信息',
     * 'unionid'=>'用户在开放平台的唯一标识符，在满足 UnionID 下发条件的情况下会返回'
     * ]
     * @throws WeAppException
     */
    public function getWeAppAuthInfo($code)
    {
        $url = $this->domain.'sns/jscode2session?appid='.$this->appid.'&secret='.$this->appSecret.'&js_code='.$code.'&grant_type=authorization_code';
        return WeAppData::getData($url);
    }

    /**
     * 小程序数据解密
     * @param $sessionKey  用户在小程序登录后获取的会话密钥
     * @param $encryptedData 加密的用户数据
     * @param $iv 与用户数据一同返回的初始向量
     * @return mixed
     * @throws WeAppException
     */
    public function decryptWeAppData( $sessionKey,$encryptedData, $iv )
    {
        if (strlen($sessionKey) != 24) {
            throw new WeAppException('请重新授权');
        }
        $aesKey=base64_decode($sessionKey);


        if (strlen($iv) != 24) {
            throw new WeAppException('iv值错误');
        }
        $aesIV=base64_decode($iv);

        $aesCipher=base64_decode($encryptedData);

        $result=openssl_decrypt( $aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);

        $data=json_decode( $result ,true);
        if( $data  == NULL || $data['watermark']['appid'] != $this->appid )
        {
            throw new WeAppException('解密失败');
        }
        return $data;
    }

    /**
     * 获取access_token。小程序和公众号access_token值不同，但是获取方法相同
     * @return mixed
     * @throws WeAppException
     */
    public function getAccessToken()
    {
        $url = $this->domain.'cgi-bin/token?grant_type=client_credential&appid='.$this->appid.'&secret='.$this->appSecret;
        return $this->getData($url);
    }

    /**
     * 获取开放平台接口权限值
     * @param $code 授权码
     * @return mixed
     * @throws WeAppException
     */
    public function getOpenPlatformToekn($code)
    {
        $url = $this->domain.'sns/oauth2/access_toke?grant_type=authorization_code&appid='.$this->appid.'&secret='.$this->appSecret.'&code='.$code;
        return $this->getData($url);
    }

    /**
     * 开放平台接口获取用户信息
     * @param $accessToken 接口权限值
     * @param $openid 用户在开放平台的唯一标识
     * @return mixed
     * @throws WeAppException
     */
    public function getOpenPlatformUserInfo($accessToken,$openid)
    {
        $url = $this->domain.'sns/userinfo?access_token='.$accessToken.'&openid='.$openid;
        return $this->getData($url);
    }
}