### 语法
1. 类
   - Function
     1. 理解：js内建的类，function是简写的创建函数的方法
     1. 方法：call／apply／bind
     1. 实例：`new Function ([arg], functionBody)`
1. 原型链
    ```
    1 new：构造器的形式，有原型，就是new的那个对象
    这个函数对象默认带一个prototype属性，这个属性是对象属性
    2 new构造一个对象，特点是当前原型会指向上级的prototype属性，一直向上————foo.proto————obj.prototype————null
    3 对象上的属性分对象属性和原型链属性，对象属性是先访问的，没有对象属性才去找原型链属性，实现了继承
    ```
     1. 第三种：obj.create:  var obj = obj.create({x:1});
     1. 使用new和create，其原型就会指向他的构造器的prototype属性，属性访问会向上寻找
   - 结构：
     1. 各种属性
       - obj.hasOwnProperty();        是否是对象本身的成员属性
       - obj.defineProperty();        创建属性
       - obj.propertyIsEnumerable();  是否是可枚举的属性(ToString为false)
     1. [{proto}]原型，prototype对象属性
     1. class标签属于哪一类
     1. extensible是否允许增加新的属性
          1. get和set方法使用函数方法设置和读取属性，原型链上有get/set方法，操作相应属性失败，先走get/set方法,想操作用defineProperty
     1. 设置属性Object.defineProperty()，设置多个属性Object.defineProperties();
    ```
    Object.defineProperty(对象,属性名,{
            // 属性标签
            configurable:,
            writable:,
            enumerable:,
            value:值
    })
    多个属性定义，使用get方法
    Object.defineProperties(对象,{
        title:{value:'',enumerable:true},
        luck:{
            get:function() {
                return Math.random() > 0.5 ? 'good' ： 'bad'
            }
        },
    })
    ```
1. 预解释
   - 理解：寻找全局变量(带var)赋undefined和全局函数(带function)放入内存，之后再从第一行运行js代码。所以js先声明后赋值不出错，函数定义位置不影响调用
    ```
    alert(a);
    var a = 100;
    // 和以下的区别，他们都是不会报错的
    // 预解释时var只能声明，不能定义。function声明和定义是同时的
    a = 100;
    alert(a);
    // 所以下面的看结果就知道
    alert(n);
    var n = 10;
    var n = 9;
    var n;
    alert(n)
    // 和function的对比
    fn();
    function fn() {
        alert('1');
    }
    fn();
    function fn() {
        alert('2');
    }
    fn();
    ```
1. 闭包
   - 理解：源于js特有的链式作用域，即子对象会查找父对象的变量并可见，但是子的变量对父不可见。闭包就是把子的变量作返回值给父，即闭包。如下
    ```
    // f2函数为闭包
    function f1(){
        // 函数内部声明变量时，不使用var，实际上声明了一个全局变量
        var n=999;
        function f2(){
            alert(n);
        }
        return f2;
    }
    var result=f1();
    result(); // 999
    ```
   - 总结：js中，只有函数内部的子函数才能读取局部变量，闭包就是一个函数，一个函数内部的函数。也是一座连接函数内部和外部的桥梁。闭包是有数据的行为
   - 用途：获得函数内部变量，使变量长期保留内存
    ```
    // 闭包可以在父函数外部，改变父函数内部的值，常驻内存随时可以使用
    // nAdd没有使用var关键字，因此nAdd是全局变量，nAdd的值是一个匿名函数，匿名函数本身也是一个闭包，所以nAdd相当于是一个setter，可在函数外部对内部的局部变量操作
    function f1(){
        var n=999;
        nAdd=function(){n+=1}
        function f2(){
            alert(n);
        }
        return f2;
    }
    var result=f1();
    result(); // 999
    nAdd();
    result(); // 1000
    ```
   - 注意：退出函数前，不使用的局部变量要全部删除。在外部可改变内部的值
1. 异步
   - 原因：单线程即任何一个函数都是从头到尾——界面更新／鼠标事件／计时器都先排队，后串行执行
   - 定义：javascript的异步编程模式，XHR/异步函数？
   - 对js的理解：js是单线程执行的脚本语言
   - 实际使用
     1. 实现方式：回调函数(注入函数触发)／事件触发(XHR的成功和错误)
     1. 回调与异步：会带来严重的函数嵌套问题，优秀的异步接口设计方案CommonJS
        ```
        // Promises/A
        method()
        .then(function(fs) {
            return fs.method1();
        })
        .then(function(fs) {
        // 链式调用
        });
        ```
     1. Generator：是协程在es6中的实现，有yield关键字，表示异步开始，协程奥妙在于代码的写法非常像同步操作，异步同步化，除了yield，像一样的
     1. async、await：async就是将Generator的星号换成async，yield换成await。async的返回值是promise对象
        - 内置执行器，Generato必须要有执行器，才有了co模块，async只有一行
        - 不用像Generator需要调用next方法，或者co模块，才能真正执行，得到结果
        - 更好的语义，async表示函数里有异步操作，await表示后边表达式需要等待结果
1. 回调
   - 定义：一个函数的指针(地址)被用为它指向的函数，这就是回调函数，回调函数不是由该函数的实现方直接调用，而是在特定的事件/方法时另一方调用
   - 对function理解：在js中，function是内置的类对象，就可以储存和传递。回调：是功能性编程技术
   - 回调函数理解：来自函数式编程，是其重要的技术。
   - 代码层理解：将一个函数作为参数传递给其他的函数/方法
    ```
    // 回调举例，将函数传递给了forEach方法
    var friends = ["Mike", "Stacy", "Andy", "Rick"];
    friends.forEach(function (eachName, index){
    console.log(index + 1 + ". " + eachName); // 1. Mike, 2. Stacy, 3. Andy, 4. Rick
    });
    ```
   - 实际使用
     1. 回调赋值方法
        ```
        // 提前定义好
        function name() {
        }
        method(name)
        // 匿名函数
        method(function () {
        })
        ```
        2. 回调可以用在同步/异步中
        ```
        // 同步
        var fun1 = function(callback) {
            callback();
        }
        // 异步
        $.ajax().done(callback);
        ```
     1. 执行回调函数
        ```
        (callback && typeof(callback) === "function") && callback();
        ```
     1. 回调函数传递参数
        ```
        $.get('myhtmlpage.html', myCallBack('foo', 'bar'));//这是错的，那么要带参数呢？
        $.get('myhtmlpage.html', function(){//带参数的使用函数表达式
            myCallBack('foo', 'bar');
        });    
        ```
     1. this/call/apply
        ```
        函数中的回调函数的this指向的是window，call和apply可以保护this对象
        callback.apply (callback);
        ```
   - 属性访问表达式：var o = {x:1}   o.x  o['x']
1. 对象/数组操作：加减：push/splice，合并：to = to.concat(mergeFrom)
   - 检测数据类型：
     1. typeof：适合基本类型的判断，数组、函数、对象都判断为对象，null失效
     1. instanceof:用于判断对象，基于原型链，不能跨ifame
        ```
        obj instanceof Object
        左边操作数上的原型链上是否有右边构造函数的prototype属性
        JavaScript是按引用查找对象，会一直向上查找，
        prototype解释：
        任何构造函数(new之前的)都有prototype属性，他是用new方法构造出的对象的原型
        ```
   - Object.prototype.toString: ie678会把null弄成obj
    ```
    示例：
    Object.prototype.toString.apply([]) === "[object Array]"
    Object.prototype.toString.apply(null) === "[object Null]"
    Object.prototype.toString.apply(undefined) === "[object Undefined]"
    Object.prototype.toString.apply(function(){}) === "[object Function]"
    ```
   - constructor：对象都有constructor属性，指向构造这个对象的构造器，
   - duck type：鸭子
 delete obj.x   变成undefined，去掉对象的值
   - 其他：delete/in/instanceof/typeof/new/this/void(0)
     1. x in window // true   
     1. delete obj.x/不可以删除var定义的变量，无var的隐式定义可以删除     
        - for in: 执行顺序不确定，对象属性的原型链属性也会出现。`for(var x in obj) {}`
   - with：不用加对象来访问属性，层数较多时可以用，不建议使用，严格模式禁止了。`with({x:1}) {}`
### 模块规范
1. 分类
   - CommonJS：诞生较早的nodejs使用的，同步加载形式。对于模块的处理，解决依赖。操作流程为模块的定义——>标识——>引用
   - AMD：Asynchronous Module Definition，异步模块定义，异步加载的形式，为浏览器而生。所依赖模块的使用语句都定义在一个回调函数中，被依赖模块加载完成之后，回调函数才会运行。表现形式：`require([module], callback)`，第二个参数callback是加载成功之后的回调函数
    ```
    define(['myLib'], function(myLib){})        // 参数一定义依赖的模块
    ```
   - CMD：Common Module Definition，异步加载，用的时候再require，需要将所有依赖解析一遍才能找到依赖。seajs推崇，具体规范和使用还待深挖
    ```
    define(function(require, exports, module) {
        var clock = require('clock');
        clock.start();
    });
    ```
1. 封装的渐进
   - 放大模式：实现模块的扩展或继承
    ```
    var module1 = (function (mod){

　　　　mod.m3 = function () {};

　　　　return mod;

　　})(module1);                      // 为module1模块添加了一个新方法m3()
    ```
1. Browserify
   - 理解：将CommonJS规范的文件可以运行在浏览器端，部署时处理代码依赖，将模块打包为一个文件
   - 问题
     1. 暂时用不到的代码也会被打包，体积大，加载慢
     1. 只要一个模块更新，整个文件缓存失效
   - 解决方案：入口点技术，每个入口点打包一个文件，两个入口点的相同依赖模块单独打包为common.js，避免空间浪费
1. RequireJS
   - 解释：代码模块化、加速优化代码、以module ID代替url。实现js文件的异步加载，避免网页失去响应；管理模块之间的依赖性，便于代码的编写和维护
     1. 使用
        - 指定主模块：`<script src="js/require.js" data-main="js/main"></script>`
        - 加载模块：`require(['jquery', 'underscore', 'backbone'], function ($, _, Backbone){});`
        - 添加一些配置：`require.config({})`，其中shim用来配置不支持AMD规范的模块
   - 使用：
     1. 以相对于baseUrl的地址加载所有代码，默认假定依赖资源都是js文件，无需加.js后缀，RequireJS进行module ID到path时自动补足后缀，可在path config设置
        ```
        // 页面顶层script标签的特殊属性data-main，require用它来启动脚本的加载过程，一般baseUrl和该属性地址相一致
        // baseUrl可通过RequireJS config手动设置，没指定config、data-main，则默认baseUrl为包含requrieJS的目录
        <script data-main="scripts/main.js" src="scripts/require.js"></script>
        ```
     1. 避开baseUrl + paths解析过程，直接加载为相对于当前html文档的脚本，则module ID符合以下规则
        ```
        以 ".js" 结束.
        以 "/" 开始.
        包含 URL 协议, 如 "http:" or "https:".
        ```
   - 插件：domready
1. RequireJS
   - 特点：防止js加载阻塞页面渲染。以module ID替代URL地址。
   - 功能
     1. 防止命名冲突
     1. 解决js之间的依赖
     1. 模块化代码
   - API：
     1. define           定义一个模块
     1. require          加载依赖模块，并执行加载完后的回调函数，会按照先后顺序加载js的
     1. requirejs        requirejs === require
   - 使用步骤
     1. 引入requirejs、配置好主js文件app.js
     1. define模块，require加载
   - 举例
    ```
    定义模块、声明依赖、使用依赖的js文件
    // 例1
    // mod1.js
    =================
    define(function() {
            return {a:3};
    })
    // mod2.js
    =================
    define(['mod1'],function(m1) {
            var a,b=2;
            a = b*m1.a;
            return {
                a:a
                b:b
            }
    })
    // 例2
    // animate.js
    =================
    define(function() {
            function Animate() {};
            return {Animate:Animate};
    });
    // tabview.js
    =================
    define(['animate'], function(a) {
            function TabView() {
                this.animate = new a.Animate();
            };
            return {TabView:TabView};
    })
    // main.js
    =====================
    require(['tabview'], function(tab) {
            var tabview = new tab.TabView;
    })
    ```
   - 常识
     1. data-main：所指js将在加载完reuqire.js后处理，并且将此作为默认为根路径baseUrl，可省去.js后缀
### Flutter
1. 认识：google的开源移动ui框架，快速在ios、android构建原生用户界面。渲染技术使用GDI，gpu渲染，比rn快很多。使用Dart语言
   - 跨平台：Linux、Android、IOS、Fuchsia
   - 原生：体验更好、性能更好，可以120fps
   - 开源：技术的生态环境，google推广
1. 特点
   - 基于底层Engine中的Skia库搭建起一套自渲染引擎，不需要在基于web内容的渲染，在性能上做到了媲美原生
1. Dart：可用于全平台、web、脚本、服务端开发，google的开源的面向对象语言，立志成为下一代web开发语言，目前2.x版本
1. Fuchsia：google的操作系统
1. Hybrid App开发
   - 集成组件和打包的：flutter、appcan、Dcloud(组件库mui)、WeX5、APICloud
   - 组件代码库：Ionic(没落，放弃IOS6和Android4.1以下的版本支持)，React Native(生成原生app，但以view为基础嵌入)
   - 打包工具：Cordova、Phonegap
   - 安卓模拟器：genymotion、海马玩
   - weex、quasar、nativeScript
### WebAssembly
1. 认识：WebAssembly(缩写Wasm)是基于堆栈虚拟机的二进制指令格式。Wasm为了一个可移植的目标而设计的，可用于编译C/C+/RUST等高级语言，使客户端和服务器应用程序能够在Web上部署
1. 理解：可以使用非JavaScript编写代码并且能在浏览器上运行的技术方案。让Web执行低级二进制语法，解决目前JS效率问题，设计立足点为快速，内存安全和开放，专门为编译而设计的语言
   - V8引擎也支持WebAssembly，可在Node.js中无缝嵌入
   - 用途：适合那些需要非常高性能的Web产品
     1. asm.js 不仅能让浏览器运行 3D 游戏，还可以运行各种服务器软件，比如 Lua、Ruby 和 SQLite。 这意味着很多工具和算法，都可以使用现成的代码，不用重新写一遍。另外，由于 asm.js 的运行速度较快，所以一些计算密集型的操作（比如计算 Hash）可以使用 C / C++ 实现，再在 JS 中调用它们。
     1. Figma基于React构建的，但应用程序的主要功能部分是WebAssembly图形编辑器，它由C++应用编写，并转译为WebAssembly，使用WebGL在Canvas中呈现
     1. AutoCAD也发布了在Web应用程序中运行的流行设计产品，使用WebAssembly呈现其复杂的编辑器，该编辑器（从桌面客户端代码库迁移）是使用C++构建的
     1. 取代：当年javafx，微软的银光号都称 flash杀手，终结者，要取代flash，结果自己先死了。 flash之死是被时代和它自己杀死的，绝非是这些后来的小弟们。无论是js，flash，还是h5，他们都是不同时期的王者。当前dart要杀js，ts要杀js，历史的车轮总是惊人的相似。可以预见最后js肯定是被自己搞死而非这些小弟们，当然wasm连小弟都不是，它只是路人
1. 特点
   - 安全性：运行在JS虚拟机的沙盒环境中，具有与JavaScript相同的安全策略，浏览器确保相同的源和权限策略
   - 高性能：将在执行之前转换为二进制文件。在理论上它可以达到与C等本机编译语言同等的性能，呈几何级的性能提高
1. 转换机制
   - 编译器前端：将c、c++、Rust编译为LLVM IR 码
   - 编译器后端：将LLVM IR编译成各架构（x86，AMD64，ARM）对应的机器码
1. 应用
   - 转换流程
     1. c/c++            Emscripten编译，即构建工具链
     1. wasm文件、html    胶接代码，就是WebAssembly，用支持的浏览器访问html
1. 历史
   - Emscripten：可以将C/C++代码编译成JS代码，但不是普通的JS，而是一种叫做asm.js的JavaScript变体，性能差不多是原生代码的50%
     1. asm.js：变量都是静态类型，取消垃圾回收机制。除了这两点与JavaScript无差异。也就是说是JavaScript的一个严格的子集，只能使用后者的一部分语法
     1. emscripten：底层是LLVM编译器，理论上任何可以生成LLVM IR（Intermediate Representation）的语言，都可以编译生成asm.js
   - Portable Native Client：也是一种能让浏览器运行C/C++代码的技术
   - WebAssembly：Google, Microsoft, Mozilla, Apple等合作开发。asm.js是文本，WebAssembly是二进制字节码，因此运行速度更快、体积更小
   - cheerp：将c++交叉编译成js的解决方案，后来直到wasm的原型和草案通过，17年底cheerp技术才开始支持到wasm，wast的交叉编译。cheerp原有代码基本上不需要更改就能直接生成wasm字节码。cheerp最新版本是2.0，有win版本。后来搞了一套cheerpj给java开发人员用于移植java的老富客户端应用
   - flascc：adobe公司的 flash as3 交叉编译方案，是通过gcc生成优化过的AS3代码，搞得不是很彻底（没有生成字节码），编译速度很慢。最早是可以支持c开发， 后来全部到flascc 改成了c++ sdk ，体积暴增。随着flash技术没落而完结
   - ane：adobe的air拓展方案之一，所谓拓展其实在平台上就是dll/so，通过代理技术（类似jni）使用。目前还存在于tv端，移动游戏端。
   - swig 号称将c++/c 转化成多种语言的拓展，包括不限于（js,tcl,python,lua,java,php,perl)等等等。其实也是类似上面的技术， 公开C函数和符号， 上层加上各种语言的数据包装调用。你如果选用了这个技术，就要忍受他的一些智能的傻逼的行为， 有时候转会造成内存泄漏，比如拷贝大块内存来做包装
   - 其他：alchemy
   - 支持语言：C，C++和Rust，预计会推出的语言有Go，Java和C#
   - 使用WebAssembly对浏览器API进行任何调用时，目前还需要JS进行交互，用JS作为入口。未来WebAssembly可能被浏览器内置支持，并使其能够直接调用DOM，Web Workers或其他浏览器API等
### PWA
1. 认识：Progressive Web App，渐进式web应用程序，渐进式的跳出浏览器的范围，跟原生应用做更深层次的结合，是20年前ajax和10年前的响应式布局的又一场革命，web应用的又一个全新时代
   - 诞生场景：web应用体验不佳
     1. 网页资源下载的网络延迟
     1. 依赖浏览器作为入口，可以放到主屏
     1. 没有好的离线方案
     1. 没有好的消息通知方案
   - 解决方案
     1. W3C Web App Manifest：系统交互，作用域、图标等
     1. Service Worker：离线缓存、可编程、可做http代理，离线优先革命
     1. Push Notification：让推送服务具备向web推送的能力
   - 展望
     1. ios正在逐步支持
     1. js-to-native和PWA消化hybird的问题
     1. 特性还是草案，各种终端不支持
### Chromium
1. CEF： Chromium Embedded Framework，为第三方应用提供可嵌入浏览器支持
### 编译工具
1. TypeScript
1. Babel：转为es5
1. Flow
1. Reason
1. Purescript
1. postCSS
### 构建工具
1. 认识：用于构建代码，提供编译、压缩和部署等一系列自动化操作的工具，用来提高工作效率
1. 分类
   - grant
   - gulp
   - webpack
     1. 解释：前端工具、解决模块加载、依赖，预处理、打包、有requirejs、gulp的功能
     1. 优点：支持commonJS、AMD模块，支持多模块加载器如less等的打包，支持css、图片打包
     1. 命令：
        - webpack      // 最基本的启动webpack的方法
        - webpack -w      // 提供watch方法；实时进行打包更新
        - webpack -p      // 对打包后的文件进行压缩
        - webpack -d      // 提供source map，方便调式代码
   - fis
   - parcel
   - rollup
   - poi
### Gulp
1. 理解：基于流的自动化构建工具
1. 功能：
   - 测试
   - 语法检查
   - 文件合并、压缩
   - 格式化
   - 浏览器自动刷新
   - 部署文件生成
   - 监听文件变化并重复以上步骤
1. 特点：
   - 基于nodeJS
   - 速度、效率、简化
   - 插件丰富，几乎不用自己用js写构建过程
   - 代码优于配置：构建脚本是代码，不是配置
1. 使用步骤：安装nodejs -> 全局安装gulp -> 项目安装gulp以及gulp插件 -> 配置gulpfile.js -> 运行任务
   - 查看gulp
    ```
    gulp -v
    ```
   - 本地安装gulp插件
    ```
    // 初始化本地环境
    npm install --save-dev
    // 安装插件
    npm install gulp-less --save-dev
    ```
   - 创建gulp配置文件gulpfile.js
     1.  
        ```javascript
        // 初始内容
        var gulp = require('gulp');
        gulp.task('default', function () {
        });
        .
        // 五个基础API
        gulp.task(name[, deps], fn) 定义任务  name：任务名称 deps：依赖任务名称 fn：回调函数
        gulp.src(globs[, options]) 执行任务处理的文件  globs：处理的文件路径(字符串或者字符串数组)
        gulp.dest(path[, options]) 处理完后文件生成路径
        gulp.watch(glob[, options], tasks)／gulp.watch(glob[, options, cb])
        gulp.run
        ```
     1. 示例less编译
        ```javascript
        //导入工具包 require('node_modules里对应模块')
        var gulp = require('gulp'), //本地安装gulp所用到的地方
                    less = require('gulp-less');
        .
        //定义一个testLess任务（自定义任务名称）
        gulp.task('testLess', function () {
                gulp.src('src/less/index.less') //该任务针对的文件
                    .pipe(less()) //该任务调用的模块
                    .pipe(gulp.dest('src/css')); //将会在src/css下生成index.css
        });
        .
        gulp.task('default',['testLess', 'elseTask']); //定义默认任务
        ```
     1. 示例语法检查和合并文件
        ```js
        var gulp = require('gulp');
        var jshint = require('gulp-jshint');
        var concat = require('gulp-concat');
        var uglify = require('gulp-uglify');
        var rename = require('gulp-rename');
        .
        // 语法检查
        gulp.task('jshint', function () {
                    return gulp.src('src/*.js')
                        .pipe(jshint())
                        .pipe(jshint.reporter('default'));
        });
        .
        // 合并文件之后压缩代码
        gulp.task('minify', function (){
                    return gulp.src('src/*.js')
                        .pipe(concat('all.js'))
                        .pipe(gulp.dest('dist'))
                        .pipe(uglify())
                        .pipe(rename('all.min.js'))
                        .pipe(gulp.dest('dist'));
        });
        .
        // 监视文件的变化
        gulp.task('watch', function () {
                    gulp.watch('src/*.js', ['jshint', 'minify']);
        });
        .
        // 注册缺省任务
        gulp.task('default', ['jshint', 'minify', 'watch']);
        ```
 1. 运行gulp
    ```
    // 执行特定任务
    gulp 任务名称；
    // 如编译less
    gulp testLess；
    ```
1. 总结
    ```
    // 将获取的文件的处理结果再传给下面，直到全部完成
    // pipe是stream 模块里负责传递流数据的方法，将stream对象返回出去，以便任务之间依次传递执行
    gulp.task('任务名称', function () {
            return gulp.src('文件')
                .pipe(...)
                .pipe(...)
                // 直到任务的最后一步
                .pipe(...);
    });
    ```
1. 更多插件
   - 语法检查（gulp-jshint）
   - 合并文件（gulp-concat）
   - 压缩代码（gulp-uglify）
   - 文件改名（gulp-rename）
1. 建议
   - 花点时间浏览一下 gulp.js 插件库，大致了解下利用已有的插件你都可以做哪些事情
   - 对于常用的插件，仔细阅读它们自己的文档，以便发挥出它们最大的功效
   - 抽时间学习 gulp.js API，特别是 gulp.task() 里关于任务体的详细描述，学会如何执行回调函数（callback），如何返回 promise 等等
   - 尝试编写适合自己工作流程和习惯的任务，如果它工作良好，把它做成插件发布给大家吧！
### 原理
1. js的运行方式发展
   - 解释器：
   - 即时编译器：JITs，速度快10倍
1. js的其他语法
   - 微软的 TypeScrip
   - 谷歌的 Dart
   - Mozilla的 asm.js
   - W3C的 WebAssembly