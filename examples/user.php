<?php
/**
 * Notes:
 * Date: 2019/12/20
 * @author: 陈星星
 */

require_once "../vendor/autoload.php";

try{
    $wxuser = new \Wechat\Weapp\WxUser(['appid'=>'wxea2586a42af671d8','appSecret'=>'c67a3ec60bad199a5102c5e88a4cbd2b']);

    $data = $wxuser->getWeAppAuthInfo('0437IyXk1v4eLn0dH5Yk1BdoXk17IyXD');
}catch (Exception $e){
    echo '错误状态码:'.$e->getCode().PHP_EOL;
    echo '错误文件:'.$e->getFile().PHP_EOL;
    echo '错误行数:'.$e->getLine().PHP_EOL;
    echo '错误信息:'.$e->getMessage().PHP_EOL;
}
var_dump($data);