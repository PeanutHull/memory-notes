1. XMLHttpRequest
   - 方法
        ```PHP
        var request = new XMLHttpRequest;
        request.open("GET", "get.php", true);
        request.send();
        request.onreadystatechange = function() {}
        ```
1. 浏览器实时通信解决方案
   - 轮询：循环间隔一定时间不断发送请求，服务端不需修改，服务端有结果立即返回并关闭连接
     1. 特点：简单粗暴，请求和处理资源大部分被浪费。固定的请求间隔要么消息延迟，要么只有最后一次有效。要求服务器处理速度很快
     1. 实例
        ```
        window.setInterval(function () {
            // 发送请求
        }, 3000);
        ```
   - 长连接：即Comet，基于HTTP长连接的"服务器推"技术。服务端收到请求hold住，有新消息时返回数据，此时客户端再次发起请求，循环下去。即阻塞模型(一直打电话，没收到就不挂电话)，和上边的都体现了http的被动性，服务端不能主动联系客户端。实现方式有ajax、iframe、script脚本
     1. 特点：消息即时送达，无无效请求。对服务端是个考验，需要维护很多长连接，要有高并发的能力
     1. 实例
        ```
        // 递归调用
        (function longPolling() {
            $.ajax({
                timeout: 5000,
                error: function () {
                    longPolling();
                },
                success: function () {
                    longPolling();
                }
            });
        })();
        ```
   - WebSocket：全双工的消息机制，服务器可以给客户端推送消息，是一个网络协议，和http有一定的交集，
     1. 实现
        ```
        websocket = new WebSocket();                    # javascript
        websocket.send();
        websocket.onmessage = function (evt) {};
        $ws = new swoole_websocket_server();            # php swoole实现
        $ws->on('open/message/close', function () {
            $ws->push();
        });
        ```
1. html：标准通用标记语言SGML(Standard Generalized Markup Language)的分支：超文本标记语言(html HyperText Markup Language)和XML
