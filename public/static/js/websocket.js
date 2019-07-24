/**
 * 与GatewayWorker建立websocket连接，域名和端口改为你实际的域名端口，
 * 其中端口为Gateway端口，即start_gateway.php指定的端口。
 * start_gateway.php 中需要指定websocket协议，像这样
 * $gateway = new Gateway(websocket://0.0.0.0:7272);
 */
var data;
//防止微信重定向再次执行
setTimeout (wsload,10);
function wsload()
{
    ws = new WebSocket("ws://"+document.domain+":7272");
    // 服务端主动推送消息时会触发这里的onmessage
    ws.onmessage = function(e){
        // json数据转换成js对象
        var data = eval("("+e.data+")");
        var type = data.type || '';
        switch(type){
            // Events.php中返回的init类型的消息，将client_id发给后台进行uid绑定
            case 'init':
                // 利用jquery发起ajax请求，将client_id发给后端进行uid绑定
                $.post('请求地址', {client_id: data.client_id,uid:sessionId}, function(data){

                    //业务逻辑
                
                }, 'json');

            //用户加载进来获取分组头像信息
            case 'join':
                
                break;
            case 'startAnswering':
            
                break;

            case 'warning':
               
                break;
               
            case 'UserClickComplete':
               
                break;
            case 'sendOtherInt':
               
            // 心跳检测
            case 'ping':

                data = '{"type":"ping","data":"hello"}';
                ws.send(data);
                break;
            // 当mvc框架调用GatewayClient发消息时直接alert出来
            default :
                console.log(e);
        }
    };

    ws.onopen = function (ev) {
        console.log("连接成功");
    }

    ws.onclose = function (evt) {
        console.log(evt);
        alert("连接失败");
}