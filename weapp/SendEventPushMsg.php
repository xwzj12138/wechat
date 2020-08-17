<?php
/**
 * Notes: 消息推送信息返回格式化类
 * Date: 2019/11/12
 * @author: 陈星星
 */

namespace Wechat\Weapp;


class SendEventPushMsg
{
    //用户的唯一标识
    public $openid;
    //公众号标识
    public $ToUserName;
    //推送的数据
    public $push_data;

    public function __construct($openid,$ToUserName)
    {
        $this->openid = $openid;
        $this->ToUserName = $ToUserName;
    }

    /**
     * 回复文本消息
     * @param $Content 文本内容
     * @return string
     */
    public function text($Content)
    {
        $time = time();
        return "<xml><ToUserName>".$this->openid."</ToUserName>
                    <FromUserName>".$this->ToUserName."</FromUserName>
                    <CreateTime>".$time."</CreateTime>
                    <MsgType>text</MsgType>
                    <Content>".$Content."</Content>
                </xml>";
    }

    /**
     * 回复图片消息
     * @param $image 图片地址
     * @return string
     */
    public function image($image)
    {
        $time = time();
        return "<xml>
                    <ToUserName>".$this->openid."</ToUserName>
                    <FromUserName>".$this->ToUserName."</FromUserName>
                    <CreateTime>".$time."</CreateTime>
                    <MsgType>image</MsgType>
                    <Image><MediaId>".$image."</MediaId></Image>
                </xml>";
    }

    /**
     * 回复语音消息
     * @param $voice 语音链接
     * @return string
     */
    public function voice($voice)
    {
        $time = time();
        return "<xml>
                    <ToUserName>".$this->openid."</ToUserName>
                    <FromUserName>".$this->ToUserName."</FromUserName>
                    <CreateTime>".$time."</CreateTime>
                    <MsgType>voice</MsgType>
                    <Voice><MediaId>".$voice."</MediaId></Voice>
                </xml>";
    }

    /**
     * 回复视频消息
     * @param $media_id 通过素材管理中的接口上传多媒体文件，得到的id
     * @param $title 视频消息的标题
     * @param $description 视频消息的描述
     * @return string
     */
    public function video($media_id,$title,$description)
    {
        $time = time();
        return "<xml>
                    <ToUserName>".$this->openid."</ToUserName>
                    <FromUserName>".$this->ToUserName."</FromUserName>
                    <CreateTime>".$time."</CreateTime>
                    <MsgType>video</MsgType>
                    <Video>
                    <MediaId>".$media_id."</MediaId>
                    <Title>".$title."</Title>
                    <Description>".$description."</Description>
                    </Video>
                </xml>";
    }

    /**
     * 回复音乐消息
     * @param $title 音乐标题
     * @param $description 音乐描述
     * @param $music_url 音乐链接
     * @param $hq_music_url 高质量音乐链接，WIFI环境优先使用该链接播放音乐
     * @param $media_id 缩略图的媒体id，通过素材管理中的接口上传多媒体文件，得到的id
     * @return string
     */
    public function music($title,$description,$music_url,$hq_music_url,$media_id)
    {
        $time = time();
        return "<xml>
                    <ToUserName>".$this->openid."</ToUserName>
                    <FromUserName>".$this->ToUserName."</FromUserName>
                    <CreateTime>".$time."</CreateTime>
                    <MsgType>music</MsgType>
                    <Music>
                    <Title>".$title."</Title>
                    <Description>".$description."</Description>
                    <MusicUrl>".$music_url."</MusicUrl>
                    <HQMusicUrl>".$hq_music_url."</HQMusicUrl>
                    <ThumbMediaId>".$media_id."</ThumbMediaId>
                    </Music>
                </xml>";
    }

    /**
     * 回复图文消息
     * @param $data 图文消息信息，注意，如果图文数超过限制，则将只发限制内的条数
     * 格式[{"title":"标题","description":"描述","picurl":"图片链接","url":"点击图文消息跳转链接"}]
     * @return string
     */
    public function news($data)
    {
        $time = time();
        $count = count($data);
        $xml = "<xml>
                <ToUserName>".$this->openid."</ToUserName>
                <FromUserName>".$this->ToUserName."</FromUserName>
                <CreateTime>".$time."</CreateTime>
                <MsgType>news</MsgType>
                <ArticleCount>".$count."</ArticleCount><Articles>";
        foreach ($data as $v){
            $xml .= "<item>
                        <Title>".$v['title']."</Title>
                        <Description>".$v['description']."</Description>
                        <PicUrl>".$v['picurl']."</PicUrl>
                        <Url>".$v['url']."</Url>
                    </item>";
        }
        $xml .= "</xml>";
        return $xml;
    }
}