<?php
namespace app\index\controller;
require_once APP_PATH .'/GatewayClient-master/Gateway.php';

use think\Controller;
use GatewayClient\Gateway;
use think\Db;
use think\Request;
class Index extends Controller
{
    //首页
    public function index()
    {
        if(!isset($_SESSION['id'])) //未进行微信授权
        {
            $this->redirect('Getwxopenid/index');
        }

        return $this->fetch();
    }
    /*
        @param client_id string
        @param uid       string 
    */
    public function bind()
    {
        $result = Request::instance()->post();
        // client_id与uid绑定
        Gateway::bindUid($result['client_id'], $result['uid']);
    }

    /*
     *  接收用户端答题请求
     *  发送给当前小组所有客户端
     */
    public function groupJumpHtml()
    {
        $result = Request::instance()->post();
        $group = $_SESSION['group'];

        //向分组广播讯息
        Gateway::sendToGroup($group, json_encode(array(
            'type'      => 'startAnswering',
            'url' => $result['url'],
        )),$exclude_client_id = '',$raw = false);
    }
}
