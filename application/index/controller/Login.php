<?php
namespace app\index\controller;

/*
 *
 */
use think\Controller;
use think\Request;
use think\Db;
use think\Session;

class Login extends Controller{

    /*
      用户登录操作
    */
    public function index(Request $request)
    {
        //用户参数
        $dataInfo = [
           'openid'  => Request::instance()->param('openid'),
            'nickname'   => Request::instance()->param('nickname'),
            'headimgurl'   => Request::instance()->param('headimgurl'),

        ];

        //查询是否存在账号信息
         
        //注册session数据

    }

}