### 应用
1. 跨域
   - 认识
     1. 形成原因：SOP，浏览器的同源策略，从安全性考虑的一个域上加载的脚本不允许访问另一个域的文档属性，不允许跨域访问并非是浏览器限制了发起请求，而是返回结果被浏览器拦截了。如嵌入银行登录页面，就可获知密码。同源：协议/域名/端口相同
     1. 特性
        - html5的ajax允许发起跨域请求，存疑，还待更全面、深入理解，还有很多知识点没有掌握
        - 浏览器脚本不能访问跨域资源内容，只能执行或渲染：`<img>、<script>、<link>、<iframe>`等标签可加载跨域资源不受同源限制
   - 解决方案：想要实现跨域访问，需要被调用方的服务端指示浏览器，我的资源可以被其他人使用
     1. web代理：本域脚本利用本域服务器端发起跨域请求然后返回，即本域服务器做代理，做请求转发
     1. jsonp实现方案
        - 原理：直接去调用其他域名下的js脚本文件，只支持get，可支持老式浏览器
        - 实现
        ```
        // $.ajax
        dataType: "jsonp"
        jsonp: "callback_function_name"

        // php
        $jsonp = $_GET['callback_function_name'];
        $resutl = $jsonp . '{json格式数据}';
        ```
     1. iframe方案
     1. CORS
        - 认识：Cross-Origin Resource Sharing，跨域资源共享，w3c的跨域请求的标准方案，克服了ajax的同源策略，各大浏览器都支持
        - 实现：服务端加入响应头，浏览器就允许了
            ```javascript
            header("Access-Control-Allow-Origin:*,http://www.xx.com");          // 允许所有/某个域名访问该资源
            header("Access-Control-Allow-Credentials:true");                    // 是否允许发送cookie，前端需显性打开，true的话上一不能为*，因为cookie同源
            header("Access-Control-Allow-Methods:POST,GET");
            header("Access-Control-Allow-Headers:prelogid,DNTX-Requested-With"); // 指定6个基本响应头之外的，Cache-Control/Content-Language/Content-Type/Expires/Last-Modified/Pragma
            header("Access-Control-Expose-Headers:X-Pagenation-Count"); //  指定6个基本响应头之外的可暴露的头部
            ```
        - 浏览器对其分类：
          1. 类别：同时满足以上条件是简单的
             - 简单请求：直接发出请求，添加origin头
             - 非简单请求
          1. 条件
             - 三种请求方法：head、get、post
             - 请求头不超出以下字段：Accept、Accept-Language、Content-Language、Last-Event-ID、Content-Type(仅三个application/x-www-form-urlencoded、multipart/form-data、text/plain)
     1. CORB：当跨域请求回来的数据 MIME type 同跨域标签应有的 MIME 类型不匹配时，浏览器会启动 CORB 保护数据不被泄漏，被保护的数据类型只有 htmlxml 和 json
        - 一个域名一个独立运行进程，跨域打破了这个限制
          1. SCA：Side-Channel Attacks 旁道攻击，由于利用程序运行时(同样的内存)，系统产生的一些物理特征（如：时延，能耗，电磁，错误消息，频率等）进行推测型攻击
1. 浏览器实时通信解决方案
   - 轮询：循环间隔固定时间不断发送请求，服务端不需修改，服务端有结果立即返回并关闭连接
     1. 特点：简单粗暴，请求和处理资源大部分被浪费。固定的请求间隔要么消息延迟，要么只有最后一次有效。要求服务器处理速度很快
     1. 实例
        ```
        window.setInterval(function () {
            // 发送请求
        }, 3000);
        ```
   - 长连接：即Comet，基于HTTP长连接的"服务器推"技术。服务端收到请求hold住，有新消息时返回数据，此时客户端再次发起请求，循环下去。即阻塞模型(一直打电话，没收到就不挂电话)，服务端不能主动联系客户端。实现方式有ajax、iframe、script脚本
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
   - WebSocket：全双工的消息机制，服务器可以给客户端推送消息，是一个网络协议，和http有一定的交集，是HTML5的重要特性
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
   - SSE
     1. 认识：Server-Sent Events，基于http的允许服务端主动推送的技术，客户端不能向上发数据，是单向通讯，是html5标准的一部分，比websocket更简单轻量
        - 自动重连机制：一旦连接断开，靠的是浏览器自动重连，每个浏览器的重连策略和措施可能不同
        - content-type：text/event-stream
     1. 作用
        - 可实现长耗时的异步处理后通知
        - 消息通知
     1. 实现流程
        - client：发起open event steam请求
        - server：通过这个连接，推送event
     1. demo
        - client
            ```js
            const numberElement = document.getElementById("sse");
            const source = new EventSource('http://localhost:8080/sse');

            source.onmessage = (event) => {
                numberElement.innerText = event.data;
            };
            source.onerror = (error) => {
                console.error("SSE error:", error);
            };
            ```
        - server：Spring4.2支持
            ```js
            var express = require('express')
            var fs = require('fs')
            var app = express()

            app.get('/stream', (req, res) => {
            res.writeHead(200, {
                "Content-Type": "text/event-stream",
                "Cache-Control": "no-cache",
                "Connection": "keep-alive"
            });

            var interval = setInterval(function () {
                res.write("data: " + (new Date()) + "\n\n");
            }, 1000);

            req.connection.addListener("close", function () {
                clearInterval(interval);
            }, false);
            })

            app.listen(9999, (err) => {
            if (err) {
                console.log(err)
                return
            }
            console.log('listening on port 9999')
            })
            ```
### 写法和技巧
1. XMLHttpRequest
  - 组成
    1. 发送：open/send/setRequestHeader
    1. 接收：status/statusText/getAllResponseHeader
        ```js
        var request = new XMLHttpRequest;
        request.open("GET", "get.php", true);
        request.send();
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status === 200) {
                console.log('接收成功');
            }
        }
        ```
   - 使用
    ```js
    var request = new XMLHttpRequest;
    request.open("GET", "get.php", true);
    request.send();
    request.onreadystatechange = function() {}
    ```
1. JSON解析
  - eval：较危险，不能防止恶意代码，方法会直接执行
    ```js
    var jsonobj = eval('(' + jsondata + ')');
    alert(jsonobj.name);
    ```
  - JSON.parse：有检测json格式错误的能力
    ```js
    var jsonobj = JSON.parse(jsondata);
    alert(jsonobj.name);
    ```
1. 一些写法
   - js跳出最外层循环
    ```js
    outerloop:
        for (var i=0; i<10; i++){
            for (var j=0; j<10; j++){
                break;
                break outerloop;
            }
        }
    ```
   - switch多条件对应一个结果
    ```js
    switch(val) {
            case(1);
            case(2);
                console.log(3);
            case(4);
            case(5);
                console.log(4);
            default();
    }
    ```
   - 防止全局污染
    ```js
    (function() {
    })());                  // 代码立即执行
    ```
   - 函数自更新
    ```js
    function selfUpdate() {
        window.selfUpdate = function() {
             alert('second run!');
        };
        alert('first run!');
    }
    selfUpdate();           // first run!
    selfUpdate();           // second run!
    ```
   - 写：属性接连赋值，var yz = obj && obj.y && obj.y.z，从左向右，为false返回，不为false时继续往后走，最后返回undefined或z的值
1. 其他
   - 内容、表现、行为相分离
    ```html
    // 这是不对的，但是能运行
    function demo() {}
    <p onclick="demo()"></p>
    1 判断元素是否存在：$(..).length()，跟js一样
    2 DOM对象不存在选择时会报错，$(..)[0]不会
    ```
   - $(~).find()可以提高搜索的性能
   - IE8及以下对class的检索只能搜索DOM，所以非常低效
   - attr=value，这种搜索同样对性能有害，加上find、filter
   - $(~).find(:hidden)，伪选择器也慢，用#
   - 同一个操作对象多用链式开发
   - 可以将jquery缓冲到全局变量中，供其他函数使用
   - 先循环生成DOM，再一次性插入html()，DOM操作很低效
   - for代替$.each，原生代替jquery，如this.style.css替代css()
   - 相同的代码可以写成jquery插件
   - 用join代替+连接字符串
   - jquery可以强大的操作xml
    ```js
    // 禁用右键菜单
    $(document).bind('contextmenu',function(e){ return false; })
    // 判断元素是否存在
    $(~).length();
    // 点击div跳转
    给div内部添加a标签
    // 敲击回车执行
    $(~).keyup(function(e) {
            if(e.which == '13') {}
    })
    // 获取选中的下拉框
    $('#select option:selected');
    // 或者
    $(~).find('option:selected');
    ```
1. 实际的坑
   - 使用sco引入页面，多次引入页面，表单重复提交
     1. 原理：使用了$(document).on("submit", "form", function(e){}绑定事件，因为document给整个页面绑了多次事件，才会多次提交。sco没有起另外一个iframe，只是把一些DOM放入了模态框，$(document)是把整个页面绑了多次事件
     1. 解决办法：将事件绑在具体的模态框里，DOM消失时，事件也就没有了
        ```js
        $('#region_form').on("submit", "", function(e){
        ```
   - 用on替代live事件
    ```js
    // 未来元素事件要绑定到document上，用on
    // 因为事件冒泡，绑到了document上，之前没有元素就绑不了事件
    $(document).on('click', '#element', function() {})
    ```
   - 添加DOM元素
    ```js
    var html = [];
    html.push('<tr>');           // js的push方法
    html.push('<td class="col-sm-1"></td>');
    html.push('</tr>');
    tbody.append(html.join(''));
    ```
### wiki
1. 前端工具集
   - nodejs：现代工业化前端的基础
   - npm：前端工具/模块源。还有bower，前端模块源，维护模块的安装、升级、删除等
   - gulp/webpack/fis：构建工具
   - mock：接口服务、本地工具
1. jsBridge：定义不同平台、app构建viewport、只访问jsBridge的方法，他去实现不同情况的请求方法————把不变的放在一起
1. 断电续传协议：tus