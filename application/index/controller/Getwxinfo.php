<?php
namespace app\index\controller;

class Getwxinfo
{
    private $appid;

    private $secret;

    function __construct($appid,$secret)
    {
        $this->appid = $appid;

        $this->secret = $secret;
    }

    public function index()
    {
        $redirect_uri = urlencode('回调地址'); //回调地址

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$this->appid&redirect_uri=$redirect_uri&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect";

        echo "<script>window.location.href='".$url."';</script>";
    }

    public function PostCurl($code)
    {
        //第一步:取全局access_token
//        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appid&secret=$this->secret";
//        $token = $this->getJson($url);

        //第二步:取得openid
        $oauth2Url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$this->appid&secret=$this->secret&code=$code&grant_type=authorization_code";
        $oauth2 = $this->getJson($oauth2Url);

        //第三步:根据全局access_token和openid查询用户信息

//        $access_token = $token["access_token"];
        $access_token = $oauth2["access_token"];
        $openid = $oauth2['openid'];

//        $get_user_info_url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
        $get_user_info_url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $userinfo = $this->getJson($get_user_info_url);
        //打印用户信息
       print_r($userinfo);die;

        //带参数跳转 执行登录业务
        
   }

    function getJson($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output, true);
    }

    public function getAppid()
    {
        return $this->appid;
    }
}