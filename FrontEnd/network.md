1. XMLHttpRequest
   - 方法
        ```PHP
        var request = new XMLHttpRequest;
        request.open("GET", "get.php", true);
        request.send();
        request.onreadystatechange = function() {}
        ```
1. XMLHttpRequest方法：
  - 发送：open/send/setRequestHeader
  - 接收：status/statusText/getAllResponseHeader
        ```
        var request = new XMLHttpRequest;
        request.open("GET", "get.php", true);
        request.send();
        request.onreadystatechange = function() {
            if(request.readyState === 4 && request.status === 200) {
                console.log('接收成功');
            }
        }
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
1. DevTools
   - 全局搜索文件和关键字：ctrl+shift+F
   - 执行命令：ctrl+shift+P
   - 事件断点：Sources——右侧面板——Event Listener Breakpoints，会在事件产生时产生断点
1. 前端工具集
   - nodejs：现代工业化前端的基础
   - npm：前端工具/模块源。还有bower，前端模块源，维护模块的安装、升级、删除等
   - gulp/webpack/fis：构建工具
   - mock：接口服务、本地工具
1. 模块化
   - 封装的渐进
     1. 放大模式：实现模块的扩展或继承
        ```
        var module1 = (function (mod){

    　　　　mod.m3 = function () {};

    　　　　return mod;

    　　})(module1);                      // 为module1模块添加了一个新方法m3()
        ```
   - 现存规范
     1. CommonJS规范：诞生较早的nodejs使用的，同步加载形式，
        - Browserify
          1. 理解：将CommonJS规范的文件可以运行在浏览器端，部署时处理代码依赖，将模块打包为一个文件
          1. 问题
             - 暂时用不到的代码也会被打包，体积大，加载慢
             - 只要一个模块更新，整个文件缓存失效
          1. 解决方案：入口点技术，每个入口点打包一个文件，两个入口点的相同依赖模块单独打包为common.js，避免空间浪费
     1. AMD规范：Asynchronous Module Definition，异步模块定义，异步加载的形式，为浏览器而生。所依赖模块的使用语句都定义在一个回调函数中，被依赖模块加载完成之后，回调函数才会运行。表现形式：`require([module], callback)`，第二个参数callback是加载成功之后的回调函数
        - requireJS
          1. 理解：实现js文件的异步加载，避免网页失去响应；管理模块之间的依赖性，便于代码的编写和维护
          1. 使用
             - 指定主模块：`<script src="js/require.js" data-main="js/main"></script>`
             - 加载模块：`require(['jquery', 'underscore', 'backbone'], function ($, _, Backbone){});`
             - 添加一些配置：`require.config({})`，其中shim用来配置不支持AMD规范的模块
          1. 插件：domready
          1. AMD模块定义
            ```
            define(['myLib'], function(myLib){})        // 参数一定义依赖的模块
            ```
     1. CMD规范：Common Module Definition，异步加载，用的时候再require，需要将所有依赖解析一遍才能找到依赖。seajs推崇，具体规范和使用还待深挖
        ```
        define(function(require, exports, module) {
            var clock = require('clock');
            clock.start();
        });
        ```
1. NodeJS：NodeJS自带模块功能，可以使用require和module.exports构建项目
### 
1. 前端构建工具
   - 理解：用于自动化构建代码，提供编译、压缩和部署等一系列操作，提高工作效率
   - 分类
     1. grant
     1. gulp
        - 理解：基于流的代码自动化工具
     1. webpack
     1. fis
