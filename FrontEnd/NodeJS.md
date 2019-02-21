### Node
1. Node.js
   - 认识：采用v8引擎的超快js解释器/运行环境。使用事件驱动、非阻塞异步io、单线程。轻量高效，没有浏览器的安全限制，提供文件读写、进程管理、网络通信等
     1. 优点：采用事件驱动、非阻塞IO模型、异步编程、为网络服务而设计、轻量高效
     1. 缺点：
   - 组成：交互组件、异步请求
   - 特点
     1. 所有io方法都提供异步版本，接受回调函数。某些方法的阻塞版本以Sync结尾
     1. 非阻塞可以维持很多连接，没有锁，一个线程处理所有请求
### 组成
1. 全局变量：process
1. 模块
   - assert
     1. 理解：断言，编写程序的单元测试用例
     1. assert.fail(actual_实际值, expected_期望值, message, operator) // 抛出异常
   - 事件
        ```js
        var EventEmitter = require('events').EventEmitter;
        var life = new EventEmitter;
        life.on('eventName' function(params) {});               // 绑定事件
        life.emit('eventName' params);                          // 触发事件
        life.listeners('eventName').length;                     // 事件监听数量
        EventEmitter.listenerCount(life, 'eventName');          // 事件监听数量
        ```
1. io
   - fs
     1. 理解：文件系统
   - buffer
     1. 理解：缓冲，node用来处理二进制数据。是个对象，有自己的构造函数，用于tcp/图像/文件/网络
     1. 实例
    ```js
    new Buffer('123456', 'base64');
    var buf = new Buffer(7);
    buf.write('12345678');              // 只存7个
    ```
   - stream
     1. 解释：流，标准输入输出错误
     1. 示例
        ```js
        var fs = require('fs');
        fs.readFileSync('file');
        fs.writeFileSync('file', source);
        // 流过程的精准控制
        var readStream = fs.createReadStream('file');
        readStream.on('data', function(chunk) {
            console.log(Buffer.isBuffer(chunk));
            console.log(chunk.toString('utf8'));
            // 模拟异步处理
            readStream.pause();
            setTimeout(function() {
                readStream.resume();
            }, 10)
        }).on('readable/end/close/error', function(chunk) {
                console.log('xxx');
        });
        ```
1. 网络
   - url
     1. url.parse()：解析http地址的相关信息
     1. url.format()：生成合法的url地址
     1. url.resolve()：生成合法的url地址
   - querystring
     1. querystring.escape()：urlencode
     1. querystring.unescape()：urldecode
   - net
   - http
     1. 启动http服务器
        ```js
        var http = require('http');                     // 修改内容，需要node重启生效
        http.createServer(function(req,res) {
            res.writeHead(200, {'Content-Type': 'text/plain'});
            res.end('hello nodejs\n');
        }).listen(1337, '127.0.0.1');
        console.log('Server running at http://127.0.0.1:1337/');
        ```
     1. request
        ```js
        var http = require('http');                     // 发post请求
        var querystring = require('querystring');
        var options = {
            hostname: '',
            port: 80,
            method: 'POST',
            headers: {}
        }
        var req = http.request(options, function(res) {
            res.on('data/end/error', function(chunk) {});
        })
        ```
     1. get，对request的封装，默认method为get、调用end方法
        ```js
        var http = require('http');
        http.get(url, function(res) {
            res.on('data', function(data) {});
            res.on('end', function(data) {});
        }).on('error', function() {});
        ```
1. 进程
   - child_process
   - cluster
### 应用
1. express框架
    ```js
    var express = require('express');
    var port = process.env.PORT || 3000;
    var app = express();
    app.set('views', './views');                // 设置视图
    app.set('view engine', 'jade');             // 设置模板引擎
    app.listen(port);
    app.use(express.cookieParser({
        secret: '',
    }));
    app.use(express.session({
        secret: '',
    }));
    app.get('/', function(req, res) {           // 设置路由
        res.render('index', {
            title: 'imooc index',
        });
    });
    app.get('/movie/:id', function(req, res) {
        res.render('movie', {
            title: 'imooc movie',
        });
    });
    console.log('sys started');
    ```
1. mongoose
   - 解释：构建在mongo之上，提供Schema、Model、Document对象，node的mongoDB驱动，安装：`npm install mongodb`
   - 组成
     1. Schema：模式
        - 解释：数据库模型骨架，无数据库操作能力。文本属性，定义集合的文档结构，如字段、类型、唯一性、索引、验证。
        - 示例
        ```js
        var schema = new mongoose.Schema({      // 定义一个Schema
            name:String                         //定义一个属性name，类型为String
            age:Number
        });
        ```
     1. Model：模型
        - 解释：由Schema发布生成的模型，具有抽象属性、行为的数据库操作对象。集合中所有文档的表示
        - 示例
        ```js
        var model = db.model('person',schema);      // 发布为Model
        var model = db.model('person');             // 发布可通过名字索引，无则异常
        model.find(function(err,persons){});        //查询到的所有person
        ```
     1. Document/Entity：文档
        - 解释：由Model创建的实体，集合中单个文档的表示
        - 示例
        ```js
        var entity = new model({                    // 用Model创建Entity
            name:'Krouky'
        });
        entity.save(function(error) {
            if(error) return handleError(error);
        });
        ```
   - 方法
     1. Query：查询
     1. Aggregate：聚合
   - 使用：建立models和schemas文件夹，分开放模式、模型
    ```js
    PersonSchema.methos.speak = function(){                 //为Schema模型追加speak方法
        console.log('我的名字叫'+this.name);
    }
    var PersonModel = db.model('Person',PersonSchema);
    var personEntity = new PersonModel({name:'Krouky'});
    personEntity.speak();
    ```
### Tool
1. 模块和包管理
   - Commonjs：对于模块的处理，解决依赖。操作流程为模块的定义——>标识——>引用。
   - node的模块：
     1. 解释：nodejs继承了commonjs的理念，node里每个js文件都是一个独立的模块
     1. 功能：使用require导入其他模块而返回模块对象即exports暴露的，没有命名空间的干扰，不担心变量污染和方法定义的隔离(因为已经作为一个个独立的模块)
     1. 分类：
        - 核心模块：http、fs、path
        - 文件模块：var aa = require('./aa.js');
        - 第三方模块：promise = require('bluebird');
     1. 引用方式：文件路径、模块名
     1. 创建举例：创建/导出/加载/使用
        ```js
        // 暴露公开的api
        function add() {}                           // 创建
        exports.add = add;                          // 导出
        // 引用其他模块
        var student = require('./student');         // 加载
        student.add(params);                        // 使用
        // 后记
        exports.add = add 和 module.exports = add 实现功能是一样的      // exports是实际存在的东西，add是exports的方法，用来将属性赋给exports
        ```
### wiki
1. 历史
   - 09年诞生，v8是谷歌开发的c++编写的最快的js解析引擎
   - 0.10.35分化出了io.js，和node分化成了两个阵营，io性能更激进一点
1. node.js
   - 就是调用一些既有的接口，完成一些功能
   - 适合：带来前后台统一，应用场景是高并发的轮询
1. 单进程单线程解决方案
   - 开启多个进程，每个进程绑定不同的端口，用反向代理服务器做负载均衡
   - 进程绑定在同一个端口侦听。在Node.js中，提供了进程间发送“文件句柄” 的功能
   - 一个进程负责监听、接收连接，然后把接收到的连接平均发送到子进程中去处理
1. promise
   - 面对的问题：回调增多，需要分析哪些代码处理应用逻辑，哪些处理异步调用，代码支离破碎，错误处理处处需要存在
   - 解释：promise模式，是一种对象，用来传递异步操作的消息，返回一个代表承诺的结果对象，用then方法注册状态变化时对应的回调函数。es6原生提供promise对象，解决A+规范。目的：将异步操作以同步操作的流程表达出来，避免嵌套的回调函数。有统一的接口，
   - 特点：对象状态不受外界影响。
   - 三种状态：未完成pending、已完成fulfilled、失败rejected
