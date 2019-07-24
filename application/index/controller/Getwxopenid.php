<?php
namespace app\index\controller;

use app\index\controller\Getwxinfo;
use think\Request;
class Getwxopenid{

    function index()
    {
        $getWxInfo = new GetWxInfo('appid','secret');


        //回调参数
        if (!empty($_REQUEST['code'])){
            $code = $_GET['code'];
            $getWxInfo->PostCurl($code);
        }else{
            $getWxInfo->index();
        }
    }
}
