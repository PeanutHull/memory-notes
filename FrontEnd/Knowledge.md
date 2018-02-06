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
1. 跨域：
  - web代理
  - jsonp：直接去调用其他域名下的js脚本文件
```
jQuery中$.ajax修改：
  1 dataType: "jsonp", 2jsonp: "回调方法名",
php中：
  1 $jsonp = $_GET['回调方法名'];
  2 $resutl = $jsonp . '{json格式数据}';
```
  - Html5的XHR2
```
在php加入头信息：
header("Access-Control-Allow-Origin:*");
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
