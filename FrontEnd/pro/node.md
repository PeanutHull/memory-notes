### Node
1. 认识：采用v8引擎的js运行时/解释器/运行环境，并提供了文件读写、进程管理、网络通信等，拥有了服务端程序的功能
   - 优点：采用事件驱动、非阻塞IO模型、异步编程、为网络服务而设计、轻量高效
   - 缺点：单线程，二进制数据操作慢、浮点运算精度差
1. 特点
   - 事件驱动、非阻塞异步io、单线程
   - 所有io方法都提供异步版本，接受回调函数。某些方法的阻塞版本以Sync结尾
   - 适合高并发、io密集、少量业务逻辑的场景
1. 组成
   - REPL：Read Eval Print Loop，交互式解释器，可在里边输入命令执行。node命令进入，可输入多行、设置变量
### 模块
1. 分类
   - 全局模块：不需要引用
     1. process
        - `process.env`：环境变量
        - `process.argv`
        - `process.nextTick()`：事件循环中的插队机制
     1. os：系统数据
     1. moment：时间
   - 系统模块：需要require，不需要下载
   - 自定义模块
     1. 认识：模块，nodejs继承了commonjs的理念，node里每个js文件都是一个独立的模块
     1. 功能：使用require导入其他模块，返回用exports暴露的模块的对象。没有命名空间干扰，不担心变量污染和方法隔离(因为已经作为一个个独立的模块)
     1. 引用方式：文件路径、模块名
     1. 创建举例：创建/导出/加载/使用
        ```js
        // 暴露公开的api
        function add() {}                           // 创建
        exports.add = add;                          // 导出
        // 引用其他模块
        var student = require('./student');         // 加载
        student.add(params);                        // 使用
        // 其他
        exports.add = add 和 module.exports = add   // 实现功能是一样的，exports是实际存在的东西，add是exports的方法，用来将属性赋给exports
        ```
1. assert
   - 理解：断言，编写程序的单元测试用例
   - assert.fail(actual_实际值, expected_期望值, message, operator) // 抛出异常
1. events：事件
    ```js
    var EventEmitter = require('events').EventEmitter;
    var life = new EventEmitter;
    life.on('eventName' function(params) {});               // 绑定事件
    life.emit('eventName' params);                          // 触发事件
    life.listeners('eventName').length;                     // 事件监听数量
    EventEmitter.listenerCount(life, 'eventName');          // 事件监听数量
    ```
1. io
   - fs：处理文件读写
   - path：处理路径
   - buffer
     1. 理解：缓冲，node用来处理二进制数据。是个对象，有自己的构造函数，用于tcp/图像/文件/网络
     1. 实例
        ```js
        new Buffer('123456', 'base64');
        var buf = new Buffer(7);
        buf.write('12345678');              // 只存7个
        ```
   - stream
     1. 认识：流，标准输入输出、错误
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
   - url：url操作
     1. url.parse()：解析http地址的相关信息
     1. url.format()：生成合法的url地址
     1. url.resolve()：生成合法的url地址
   - querystring
     1. querystring.escape()：urlencode
     1. querystring.unescape()：urldecode
   - net
   - http
     1. 认识：是node的一等公民，有流式和低延迟
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
     1. fork：创建子进程 `child_process.fork()`
     1. spawn：子进程非node，结果以流的形式返回
     1. execFile：子进程非node，结果以回调的形式返回
     1. exec：子进程非node，执行shell命令，结果以回调的形式返回，比较危险
     1. 举例
        ```js
        let cp=require('child_process');

        cp.exec('echo hello world',function(err,stdout){                    // exec
            console.log(stdout);
        });

        cp.execFile('echo',['hello','world'],function(err,stdout){          // execFile
            console.log(stdout);
        });
        ```
   - cluster：利用多核cpu，创建一堆node子进程，共享套接字从而实现负载均衡
     1. 进程间通信：...
### 应用
1. mongoose
   - 解释：node的mongoDB驱动，提供Schema、Model、Document对象。安装：`npm install mongodb`
   - 组成
     1. Schema：模式
        - 解释：数据库模型骨架，无数据库操作能力。文本属性，定义集合的文档结构，如字段、类型、唯一性、索引、验证。
        - 示例
        ```js
        var schema = new mongoose.Schema({      // 定义一个Schema
            name:String                         // 定义一个属性name，类型为String
            age:Number
        });
        ```
     1. Model：模型
        - 解释：由Schema发布生成的模型，具有抽象属性、行为的数据库操作对象。集合中所有文档的表示
        - 示例
        ```js
        var model = db.model('person', schema);     // 发布为Model
        var model = db.model('person');             // 发布可通过名字索引，无则异常
        model.find(function(err,persons){});        // 查询到的所有person
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
1. sequelize
   - 认识：ORM，适用于Postgres、MySQL、SQL Server
   - 安装：`npm install sequelize`
   - 使用
    ```js
    var Sequelize = require('sequelize');
    var sequelize = new Sequelize();
    ```
1. axios：http客户端
1. node-pdftk：服务端pdf处理工具，合并、旋转、加水印、加附件、加密等
1. socket.io：node和前端的websocket等
1. express框架：年事已高，17年github的star数量最高
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
1. fastify：框架，快速低开销的web框架
1. PM2
   - node的进程控制器，可以管理多个
   - 安装：`npm install pm2 -g`
   - 使用
     1. 初始化：`pm2 init`
        - 设置进程个数
        - 异常是否自动重启
        - 设置启动的环境变量
     1. 启动/停止：`pm2 start/restart/delete app.js`
     1. 查看：`pm2 list/log`
     1. 监控：`pm2 monit`
1. puppeteer
   - 认识：headless chrome node api，chrome团队开发。导致其他自动化库停止维护，如phantomJS、selenium
     1. 截图、生成pdf
     1. 爬ssr、spa的网站
     1. 模拟用户操作
     1. 分析网页性能
     1. 提供自动化测试环境
1. helium
   - 认识：Selenium-Python-Helium，web自动化开源框架，使用python，封装selenium，屏蔽很多细节，自带webDriver浏览器驱动，不适合二次开发，适合快速使用
1. cypress
   - 认识：和其他工具在浏览器外部运行不同，cypress将所有代码注入空白页面，测试代码和业务代码一起运行。可用于UI集成测试、API接口测试和单元测试
     1. 由于运行在由Cypress全权控制的浏览器中，Cypress的测试代码可以直接操作DOM、Window Objects甚至Local Storages而无须通过网络访问，也因此它更快
1. selenium
   - 理解：支持用脚本控制浏览器的工具，核心基于jsUnit，完全由js编写，运行在浏览器中，04年诞生
     1. 在爬虫行不通下，可以上这个
   - 成员
     1. IDE：脚本录制工具
     1. WebDriver：编写和运行
     1. Grid：并行处理
1. ffi：Foreign Function Interface，用js加载、调用动态库，俗称调dll，php也有相关扩展
   - 不需要源代码，不需要每次重编译node
   - 性能有折损，类似其他语言的FFI调试，此方法近似黑盒调用，调错比较困难
1. node框架
   - express
   - koa
   - egg：阿里开源的企业级框架
   - adonis
   - nest
   - Next.js：采用react，实现了SSR和SPA
   - Nuxt：采用vue，实现了SSR和SPA
### Tool
1. nvm
   - 认识：node版本管理工具
   - 使用
     1. nvm ls-remote：列出所有远程服务器的官方node version list
     1. nvm list：列出所有已安装的node版本
     1. nvm list available：显示所有可下载的版本
     
     1. nvm install [node版本号]：安装指定版本node
     1. nvm install stable：安装最新版node
     1. nvm uninstall [node版本号]：删除已安装的指定版本

     1. nvm use [node版本号]：切换到指定版本 node
     1. nvm current：当前 node 版本
     
     1. nvm alias [别名] [node版本号]：给不同的版本号添加别名
     1. nvm unalias [别名]：删除已定义的别名
     1. nvm alias default [node版本号]：设置默认版本
1. npm：包管理工具
1. n：node版本管理工具
   - 安装：`npm install n -g`
   - 操作
     1. 查看当前版本：`n list`
     1. 指定版本升级：`n 12.18.3`
     1. 删除旧版本：`n rm xxx`
1. heapdump：用于内存泄露分析，将结果导入chrome dev toole中进行分析
1. inspector：单点调试。搭配调试工具如vs code和dev tools（地址：chrome://inspect）
   - 查看上下文变量
   - 函数调用栈
   - 暂停状态执行代码
   - 不侵入代码
### wiki
1. 历史
   - 09年诞生，v8是谷歌开发的c++编写的最快的js解析引擎
   - 0.10.35：分化出了io.js，和node分化成了两个阵营，io性能更激进一点
   - 2020.04：14、12.18 LTS
1. promise
   - 面对的问题：回调增多，需要分析哪些代码处理应用逻辑，哪些处理异步调用，代码支离破碎，错误处理处处需要存在
   - 解释：是一种模式/对象，用来传递异步操作的消息，返回一个代表承诺的结果对象，用then方法注册状态变化时对应的回调函数。es6原生提供promise对象，解决A+规范
   - 目的：将异步操作以同步操作的流程表达出来，避免嵌套的回调函数
   - 特点：对象状态不受外界影响
   - 三种状态
     1. 未完成：pending
     1. 已完成：fulfilled
     1. 失败：rejected
1. 相关概念
   - OpenJS基金会
   - Deno：运行在V8上的安全的ts、js运行时，node之父编写
   - SSR：服务端渲染
   - SPA：单页应用
   - JXcore：多线程版node，100%兼容node。还有打包功能，生成jx二进制文件，jxp中间件文件(包含需要编译的完整项目信息)
1. 调优
   - process.env.UV_THREADPOOL_SIZE：io线程池数量，默认4
1. node理解
   - 组成
     1. node standard library
     1. node binding：联络c++
     1. v8、libuv、c-ares、zlib、openssl等
   - node
     1. 以libuv为核心，事件驱动就是依赖的libuv的事件循环
     1. 比如数据加解密重cpu，一个个算，前面没完成，后边就等着，就会阻塞
     1. 所以
     1. 杂谈：就是前端人玩玩后端服务
   - 单线程
     1. 认识：只是指自身js运行的单线程
     1. 步骤
        - 执行同步代码的主线程(只占用cpu内核) + 异步的io线程
        - 一旦主线程执行完成，将会消费事件队列
     1. 好处
        - 状态单一
        - 没有锁
        - 不需要线程间同步
        - 减少系统上下文的切换
        - 有效提高单核CPU的使用率
   - 异步io执行过程
     1. 发起io调用
        - js代码执行
        - node核心将参数和回调函数封装成请求对象
        - 将请求对象推入io线程池等待执行
        - js的异步调用结束，继续执行后续操作
     1. 执行回调
        - libuv用event loop来控制何时调用io队列
        - 取出封装在请求对象中的回调函数并执行，用以完成回调目的
   - EventLoop
     1. 认识：node的EventLoop有6个事件队列/阶段/观察者，每个阶段都有一个FIFO的先进先出的callbacks队列，每个阶段都有自己的事件处理方式. 一个个的阶段往下走, 每当进入某个阶段将会在该阶段内执行回调，直到队列耗尽或者回调的最大数量已执行, 那么将进入下一个处理阶段
     1. 阶段
        - timers：执行setTimeout()和setInterval()中到期的callback，当超过了约定的时间才会来执行，可能被延误，所以定时不准
        - I/O callbacks：上一轮循环中有少数的I/Ocallback会被延迟到这一轮的这一阶段执行
        - idl、prepare：仅内部使用
        - poll：最为重要的阶段，执行I/O callback，在适当的条件下会阻塞在这个阶段，连接、数据从这里加入
        - check：执行setImmediate的callback
        - close callbacks：执行close事件的callback，例如socket.on("close",func)
     1. 图示：![avatar](../../images/libuv_eventLoop.png)