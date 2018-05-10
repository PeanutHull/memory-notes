   - switch多条件对应一个结果
    ```
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
         1. 防止全局污染
    ```
    (function() {
    })());          代码立即执行
    ```
         1. 函数自更新
    ```
    function selfUpdate() {
        window.selfUpdate = function() {
             alert('second run!');
        };
        alert('first run!');
    }
    selfUpdate(); // first run!
    selfUpdate(); // second run!
    ```
         1. 写：属性接连赋值，var yz = obj && obj.y && obj.y.z，从左向右，为false返回，不为false时继续往后走，最后返回undefined或z的值
###应用
1. js跳出最外层循环
```javascript
outerloop:
    for (var i=0; i<10; i++){
        for (var j=0; j<10; j++){
            break;
            break outerloop;
        }
    }
```
1. JSON解析：
  - eval：较危险，不能防止恶意代码，方法会直接执行
```
var jsonobj = eval('(' + jsondata + ')');
alert(jsonobj.name);
```
  - JSON.parse：有检测json格式错误的能力
```
var jsonobj = JSON.parse(jsondata);
alert(jsonobj.name);
```
1. 跨域
   - 理解：
     1. 形成原因：浏览器的同源策略，从安全性考虑的一个域上加载的脚本不允许访问另一个域的文档属性，不允许跨域访问并非是浏览器限制了发起请求，而是返回结果被浏览器拦截了。如嵌入银行登录页面，就可获知密码。同源：协议/域名/端口相同
     1. 特性
        - html5的ajax允许发起跨域请求，存疑，还待更全面、深入理解，还有很多知识点没有掌握
        - 浏览器脚本不能访问跨域资源内容，只能执行或渲染：`<img>、<script>、<link>、<iframe>`等标签可加载跨域资源不受同源限制
   - 解决方案：想要实现跨域访问，需要被调用方的服务端指示浏览器，我的资源可以被其他人使用
     1. web代理：本域脚本利用本域服务器端发起跨域请求然后返回，即本域服务器做代理，做请求转发
     1. jsonp实现方案
        - 原理：直接去调用其他域名下的js脚本文件
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
        - 认识：Cross-Origin Resource Sharing，w3c的跨域请求的标准方案，各大浏览器都支持
        - 实现：加入响应头，浏览器就允许了
        ```
        header("Access-Control-Allow-Origin:*,http://www.xx.com");          # 允许所有/某个域名访问该资源
        header("Access-Control-Allow-Methods:POST,GET");
        ```
1. Hybrid App开发
 - 集成组件和打包的：appcan、Dcloud(组件库mui)、WeX5、APICloud
 - 组件代码库：Ionic(放弃IOS6和Android4.1以下的版本支持)
 - 打包工具：Cordova、Phonegap
 - 安卓模拟器：genymotion、海马玩
1. jsBridge定义不同平台、app构建viewport、只访问jsBridge的方法，他去实现不同情况的请求方法————把不变的放在一起
1. MEAN————全栈javascript开发架构
 - 理解：即MongoDB、ExpressJS，AngularJS、Node.js
    1. MongoDB是一个使用JSON风格存储的数据库，非常适合javascript。(JSON是JS数据格式)
    1. ExpressJS是一个Web应用框架，提供有帮助的组件和模块帮助建立一个网站应用。
    1. AngularJS是一个前端MVC框架。
    1. Node.js是一个并发 异步 事件驱动的Javascript服务器后端开发平台。
 - 特点：
    1. 数据格式前后端无缝通用JSON数据格式
    1. 数据库对象即前后端对象，方便，前后端语法相同，还是方便
###安全
1. XSS与防范：
 - 概念：跨站脚本(Cross Site Script)：让某网站执行一个非法脚本。
 - 发生条件：非法脚本必须在浏览器中解析，点在HTML、URL、javascript，顺序为HTML——URL——JS
 - HTML:浏览器解析顺序：能识别的编码符号都解码(但是只在俩个地反解：标签内容和标签属性值)
 - URL:传输要进行转义：整个URL转用 encodeURI，如果对参数的值转用 encodeURIComponent
 - Javascript特殊字符：JS的转义都采用\解决，三种类型：
      - 直接反斜杠：  \'\"   \\(转义反斜杠本身)
      - 十六进制：  \x22\x27
      - Unicode：  \u0022\u0027
 - 举例：
```
危险写法，这里输入来自用户，用户输入不可靠：
el.innerHTML = title.value;
修改后：
el.innerHTML = escapeHTML(title.value);
```
 - 阻止办法：用适当的方法对html、js转义
