<?php
/**
 * Notes:
 * Date: 2019/12/20
 * @author: 陈星星
 */

require_once "../vendor/autoload.php";

try{
    $wxuser = new \Wechat\Weapp\WxUser(['appid'=>'43214321432143','appSecret'=>'fdsbvfdbfdsbhgfngfbv']);

    $data = $wxuser->getWeAppAuthInfo('0438HveO1T78H91RA4cO1XLmeO18Hvef');
}catch (Exception $e){
    echo '错误状态码:'.$e->getCode().PHP_EOL;
    echo '错误文件:'.$e->getFile().PHP_EOL;
    echo '错误行数:'.$e->getLine().PHP_EOL;
    echo '错误信息:'.$e->getMessage().PHP_EOL;
}
var_dump($data);