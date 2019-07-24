<?php
namespace app\index\controller;
require_once APP_PATH .'/GatewayClient-master/Gateway.php';
use think\Request;
use GatewayClient\Gateway;
use think\Db;
class Wswork{

    /*
    *   模拟客户端进行业务通讯
    *   调用GatewayClient-master客户端与服务端通讯
    */
    public function establishRoom()
    {
        //接收参数
       $result = Request::instance()->post();

       if ($result['status'] == 'establishRoom')
       {
           //根据邀请者id来创建房间
           if (!isset($result['parent_id']) || $result['parent_id'] <= 0){

               $client_id = Gateway::getClientIdByUid($result['id'])[0];

               Gateway::joinGroup($client_id,$result['id']);

               //判断当前对局是否满员
               if (Gateway::getClientIdCountByGroup($result['id']) > 2)
               {
                   //向clientId推送讯息
                   Gateway::sendToClient($client_id, json_encode(array(
                       'type'      => 'warning',
                       'message' => '当前链接人数已满员',
                   )));
               }

               //绑定该用户的分组
                $_SESSION['group'] = $result['id'];
               //向当前分组广播讯息
               Gateway::sendToGroup($result['id'], json_encode(array(
                   'type'      => 'join',
                   'groupId' => $result['id'],
               )),$exclude_client_id = '',$raw = false);

               //创建房间成功
               return 200;
           }else{
                return 500;
           }
       }else{
           return 505;
       }
    }


    /*
     * 随机出一道题
     * 推送用户端
     * type subject
     */
    public function sendGroupSubject()
    {
        $data = Request::instance()->post();
        //获取用户的分组
        $group = $_SESSION['group'];
        //向分组广播讯息
        Gateway::sendToGroup($group, json_encode(array(
            'type'      => 'subject',
            'data' => $data['data'],
        )),$exclude_client_id = '',$raw = false);
    }
    /*

    */
    public function groupJumpHtml()
    {
        
    }

    /*
     *  
     */
    public function userClickSubject()
    {
       
    }

    /*
     * 
     */
    public function getOtherInt()
    {
       
    }
}
