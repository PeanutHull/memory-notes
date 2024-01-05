1. 框架：web界面开发库，加上周边配套的工具，构成开发框架
### Vue
1. 认识
   - 不用手动操作dom
   - 简洁轻量、快速、模块友好
   - 数据绑定：数据和视图双向绑定/数据驱动
   - 组件化：单独的vue组件可以互相引用而组装起来
   - 数据间依赖自动处理
1. 特性
   - 模块化：按需采用，庞大生态
   - 渐进式：逐步集成，可以逐步采用在项目中，不必完全投身于使用vue构建整个前端
   - 响应式：能够侦测到数据的变化并自动更新视图
     1. vue2原理：
        - 侦测变化: vue遍历其data对象中所有属性，使用`Object.defineProperty`将它们转换为getter/setter
        - 依赖收集: 组件模板被编译成渲染函数后，会被执行以生成虚拟dom。在这个过程中，模板中用到的响应式数据的getter会被调用，vue会记录当前正在读取数据的组件为"依赖"
        - 依赖跟踪: 每个响应式数据都会关联一个依赖列表（称为依赖跟踪或观察者列表），用于存储所有依赖于该数据的组件
        - 派发更新: 当响应式数据发生变化时（setter被调用），vue会通知与数据相关联的所有依赖，即通知所有订阅了这个数据变化的组件，然后组件会重新渲染视图
     1. vue3原理：基于ES6的`Proxy`对象，提供了更强大的拦截能力
        - 侦测变化: Vue 3使用`Proxy`对象包裹响应式数据，这样可以侦测到所有类型的数据变更，包括属性的添加和删除，以及数组的索引和长度变化
        - 依赖收集: 当组件渲染时，它会访问代理对象的属性，`Proxy`的getter拦截器会自动收集当前渲染函数作为依赖
        - 依赖跟踪: Vue 3中引入了Composition API，通过`ref`和`reactive`来创建响应式变量，这些变量同样会维护一个依赖列表
        - 派发更新: 当代理对象的属性被修改时，`Proxy`的setter拦截器会被触发，Vue将自动查找依赖列表，并触发组件的重新渲染
1. 组成
   - 响应式系统
   - 模板引擎

   - 路由器
   - 状态管理
1. 开发环境
   - node/npm/webpack
   - vue-cli：脚手架工具，用来生成模板的vue工程
   - element：vue的组件库
   - vuex
     1. 认识：为vue应用程序开发的状态管理模式和库，集中式管理所有组件状态，并以相应规则保证状态以可预测的方式发生变化。通过利用vue的响应式和组件系统的优势，提供了一个运行于前端的单向数据流架构
     1. 意义：大型应用组件间状态共享会复杂且难以管理。直接通信和事件广播可能会导致数据流动难以追踪和维护。vuex通过集中式存储管理所有组件的状态，并以规则确保状态的变化是可预测的，从而解决了这些问题
     1. 核心概念
        - State
        - Getters
        - Mutations
        - Actions
        - Modules
     1. 工作流程
        - 组件通过调用 actions 来处理异步事件或复杂逻辑
        - Actions 提交 mutations 来更改状态
        - State 的变化会反馈到 Vue 组件中，可能会触发组件的重新渲染
        - 组件可以通过 getters 来获取派生的状态，以便减少重复逻辑和计算
### React
1. 认识：提供高效的视图渲染和更新，facebook开发并在2013年开源
   - 组件化开发：每个组件负责管理自己的状态和渲染
   - 声明式编码
   - 虚拟dom
1. 生态
   - 路由库：React Router
   - 状态管理库：Redux、MobX
   - UI组件库：Material-UI、Ant Design
### React Native
1. 认识：通过桥接机制将js中的组件/逻辑与原生平台的api和组件连接起来，使用原生组件渲染界面，利用js的实现跨平台的逻辑
1. 实现原理
   - js代码独立线程运行：和ui线程分离，互不影响，重js逻辑ui也能流畅
   - 桥接Bridge模式：js线程与原生环境之间的通信通过序列化的数据桥接过程来实现，包含数据和指令，可以更新ui等
   - 原生组件：React Native提供了一系列等同于原生ios和android组件的封装。如`<View>`对应iOS的UIView、Android的View，`<Text>`对应UILabel和TextView等。当js代码执行渲染时，它实际上是在创建这些原生组件的声明，这些声明随后通过桥接传递给原生端进行渲染
   - 原生模块：除了封装原生UI组件，还允许开发者编写自己的原生模块和插件，实现自行扩展
   - 虚拟dom：可快速且高效地更新ui
   - 异步和批处理：桥接机制会尽可能地异步和批量执行操作，使得js线程可以不用等待
   - 支持热重载：修改立即可见，无需重新编译整个应用
### Taro
1. 认识：开放式跨端跨框架解决方案，支持使用react/vue/nerv等框架开发微信/京东/百度/支付宝/字节跳动/qq/飞书小程序、h5/reactNative等应用，京东凹凸实验室创建和维护
   - 跨平台编译
   - 组件化开发
### Angular
1. 认识：大而全，为html进行扩展，html是伟大的静态语言，但不适用动态展示，angular帮助html进行web开发，并且很好和其他类库合作，为web应用增强html的能力
1. 组成
   - 模块 module
   - 组件 component
   - 指令模板
   - MVVM/双向数据绑定(Data Binding)：自动更新视图的方法，解放你修改DOM的双手，体现在ng-model，双方一改都改。并且是普通的js对象
   - 指令、组件：为应用创建特殊html，定制功能。使用指令创建重用组件
     1. ng-model：建立视图和作用域的联系，实现数据双向绑定。model是普通的js对象，没有必要去继承专有类型去实现特定特性，易于测试/维护/重用/无样板
     1. ng-controller：是DOM元素的行为，不要操作DOM，应该注册回调和监听model变化
     1. $scope.$watch(变量/函数, 执行的方法);
   - 服务
   - 路由
   - *指令集丰富
   - 依赖注入
   - 控制器：关注数据变化和注册回调，定义DOM行为
   - 单页应用：深度链接，展示特定页面
1. 表达式：{{data}}，包含文字、运算符、变量，支持过滤器，不支持条件判断、循环、异常
1. ng
   - ng-app
   - ng-controller
   - ng核心模块
    1. Directive:核心指令集，ngClick/ngInclude/ngReapeat
    1. Service/Factories：核心服务集，通过DI来使用
    1. filter：核心过滤器，在指令和表达式渲染前转换模板数据
    1. Global APIs：核心公共API函数，低级js操作中可用
    1. function/object/provider：ng-click
   - ngRoute 提供路由功能，提供hashbang和HTML5 pushState方式
    1. Services/Factories：路由管理，\$routeParams路由中的参数\$route当前路由\$routeProvider注册路由
    1. Directives：根据路由显示模板
   - ngAnimate 提供动画支持
   - ngMessages 表单验证
   - ngTouch 触摸事件，基于jq的处理
   - ngCookies
   - ngResource 以REST方式请求数据
   - ngSanitize 安全解析和操作html
   - ngAria 残疾人支持
   - ngMock 用来注入mock modules, factories, services and providers
1. 经验
   - 外部修改angular数据
    ```js
    // 方法一：抓scope，用$apply触发数据同步到视图
    var $scope = angular.element(appElement).scope();
    $scope.$apply(function () {
        $scope.data = [{ id: 1, cnt: 4 }];
    });
    // 方法二：内部写好方法，里应外合，直接采用
    parent.angular.offline();
    ```
   - 执行父窗口angular方法：`parent.angular.element('#task_btn_37').scope().offline()`
### Jquery
1. 认识：learn more, write less
   - 完美浏览器兼容性
   - 强大选择器、DOM操作
   - 多选的事件处理机制、链式操作
   - 插件丰富
   - ajax、动画
1. 选择器
   - 认识：跨浏览器
   - 基本选择器：`#/./E/*/,`
   - 层次选择器
    ```js
    空格     后代，子子孙孙
    >        只是子代
    +        在prev元素后所有的元素，包括父父级的兄弟元素。如：$("label + input")
    ~        之后所有同辈,等同$(..).nextAll()
    ```
   - 过滤选择器
     1. 基本过滤
        ```js
        :first/:last     $('div:first')所有div第一个
        not()            $('div:not(.className)')
        :even/:odd       偶奇
        :eq/:gt/:lt      大小于
        :lang()          等于字符/字符开头加-。$("p:lang(aa)")
        :animated        正执行动画效果的元素 $("div:not(:animated)").animate({left:"+=20"}, 1000);
        :focus
        :hidden          display:none/type=hidden的元素
        :visible         不可见元素
        ```
     1. 属性选择器
        ```js
        [attr=value]
        !=                           不等于
        ^=                           以...开始
        $=                           以...结束
        *=                           含有
        |=                           等于或为前缀
        [attr=value][attr=value]     缩小范围查找
        ```
     1. 内容过滤
        ```js
        :contains(text)            选择文本为test的
        :has(selector)             有匹配的
        :parent                    包含文本或者元素
        :empty()                   不包含文本或者元素
        ```
     1. 子元素选择
        ```js
        :nth-child(2n/even/odd)        数字或索引
        :first-child/:last-child       类似:first只匹配一个元素，此为每个父元素匹配一个子元素
        :nth-of-type(1)                所有prev类型子元素中的第一个
        ```
   - 表单选择器
     1. 表单元素选择
        ```js
        :input
        :text
        :password
        :radio
        :checkbox
        :submit
        :image
        :reset
        :button
        :file
        ```
     1. 表单属性选择
        ```js
        :enabled/:disabled
        :checked/:selected         select建议用于select元素
        :input/:text/:submit
        ```
1. DOM
   - 元素操作
     1. DOM core：通用性强，应用于任何标记性语言
        - getElementById/ByTagName()
        - getAttribute()/setAttribute()
     1. HTML DOM：html专属
        - document.forms/src
     1. jQuery
        - 新增：append、prepend、after、before
            ```js
            $(..).append('<p/>')或者('<p></p>')          // 内部追加
            $(A).appendTO(B)                            // 内部A加到B中

            after();                                    // 外部加后面
            insertAfter()                               // A加到B后面
            before();                                   // 外部加前面
            ```
        - 删除
            ```js
            remove()                 // 返回移除的引用
            detach()                 // 不移除事件，remove会移除
            empty()                  // 替代html()，清空
            ```
        - 复制、包裹标签
            ```js
            $(..).clone().append();                // 同时复制事件clone(true)
            wrap/wrapAll/wrapInner
            ```
        - 遍历节点
            ```js
            next()/prev()
            siblings()
            children()
            parent()/parents()/closest()
            ```
        - html、文本、值
            ```js
            html()
            text()
            val()
            ```
   - 属性操作
     1. CSS DOM
        - element.style.color
     1. jQuery
        - attr
        - removeAttr
        - hasClass：判断
1. 样式
   - css
     1. css：可获得外部css数据,attr/css都可一次设置多个、也可链式设置
   - 尺寸
     1. width/height/innerWidth/outerHeight([val|fn])           可用来设置window和document的高
        ```
        $("p").height(function(n,c){
            return c+10;
        });
        ```
   - 位置
     1. offset                    元素在当前视口的相对偏移
     1. position                  对于最近一个的position
     1. scrollTop/scrollLeft
     1. e.pageY/X                 获得鼠标位置
1. 事件
   - 绑定：one/bind/unbing，one只产生一次事件,绑定多个事件`$(~).bind().bind()`
   - 属性
        ```js
        event.type                     获取事件类型，'click'
        event.target                   获得触发事件的元素
        event.pageY/X
        event.relatedTarget            鼠标事件的元素捕获
        event.which                    获得点击的哪个鼠标按键
        $(..).mouseDown(function(e) {
            alert(e.which);      1左2中3右
        })
        ```
   - 焦点：focus/blur
   - 表单
        ```js
        // 加入原生更灵活
        // 反选：.click(function() {
                this.checked != this.checked;
        })
        // prop替代attr，可以将属性值统一，如checked=checked、checked=true
        ```
   - 动画
        ```js
        show()/hide()                         可加延时，fast
        fadeIn()/fadeOut()/集成toggle()        切换显示、隐藏
        slideUp()/slideDown()                 改变高度，改变时有方向
        animate(params, speed, callback)
        is(':animate')                        是否处于运动状态
        .delay(1000)                          延迟
        ```
   - 冒泡：事件向上传递直至顶端。相反过程的事件捕获，只能原生。`event.stopPropagetion()`
   - 阻止默认行为
        ```js
        event.preventDefault()
        或者 return false;
        或者 function(e) {
                e.preventDefault()
        }
        ```
   - 模拟事件：click/trigger
   - 命名空间
     1. 理解：为同个元素绑定的多个事件类型，用命名空间进行规范，可以绑定一个或多个命名空间
     1. 认识：事件后加点和别名以便引用事件，如"click.a"。可以只触发/删除使用命名空间的事件
        ```js
        // 该属性属于Event对象
        function handler( event ){
                alert( event.namespace );
        }
        // 不限定命名空间触发
        $p.trigger("click");   // 返回值为""
        // 只触发不带命名空间的，加！
        $p.trigger("click!");
        // 删除事件时，可以指定命名空间
        $("div").unbind("click.a");
        ```
     1. 应用
        ```js
        // 当一个元素绑定两个click事件，怎么卸载其中一个？
        解决办法1：$(“#element").off("click", clickName);    // 指定事件
        // 当不知道事件名或者是匿名函数怎么半?
        $("#element").on("click", function() {
            console.log("doSomething");
        });
        ```
1. ajax：$.ajax————$.load()————$.get/post()————$.getScript/getJson()
   - $.load()：载入页面用
   - callback(responseText, textStatus, XMLHttpRequest)
1. 延迟对象：deferred对象，jQuery的回调函数解决方案，延迟到未来某个点再执行
    ```js
    // 链式的延迟回调
    $.ajax("test.html")
    　　.done(function(){ alert("哈哈，成功了！");} )
    　　.fail(function(){ alert("出错啦！"); } )
    　　.done(function(){ alert("第二个回调函数！");} );
    ```
   - 多个操作指定回调函数：`$.when($.ajax("test1.html"), $.ajax("test2.html")).fail().done();`
1. 经验
   - $和window.onload
    ```js
    // DOM加载完可以运行，可以存在多个。即
    $(function() {})
    $(document).ready(function() {})
    // 这个图片加载完才运行
    $(window).load(function() {})
    ```
   - 转义特殊符号：`$('#id\\#b');`
   - .filter可以加入多个搜索条件，.find子子孙孙，.children只是子代
   - 驼峰代替：fontSize 或者加引号写成'font-size'
   - $('form/DOM').serialize()，序列化为字符串a=1&b=2，中文自动转码。反序列化unserialize。和$.param差不多。serializeArray()，序列化为JSON
   - jQuery对象和DOM对象，之间不能调用彼此方法
    ```js
    // jQ——>DOM
    $(..).get(0)或者$(..)[0]
    // DOM——>jQ:
    cr = document.getElementById(..);
    $cr = $(cr)
    ```
   - 和其他框架协作
    ```js
    jQuery.noConflict();            // 交出$
    var $j = jQuery.noConflict();   // 创建快捷方式
    ```
1. wiki
   - 1.7的on替代了bing/delegate/live，支持AMD，弃用live/die，off代替unbind/undelegate/die
   - 插件有jquery.form.js、jquery.cookies.js
   - 编写jquery插件方法
     1. 封装对象方法
     1. 封装全局函数
     1. 选择器插件
### jade
1. jade模板引擎
    ```js
    // 布局样式
    html
        head
            meta(charset="utf-8")
            title #{title}
            include ./include/head // 模板继承
        body
            h1 #{title}
    // 文件引入
    link(href="...", rel="stylesheet")
    script(src="...")
    // 模板继承、模块定义
    extend ../layout
    block content
            .container                                  // class名称
                .cow
                    each item in movies                 // 循环控制
                        a(href="/movie/#{item.id}")
    ```
### day.js
1. 轻量级时间日期处理库
### 其他
1. MobX
   - 认识：通过透明的函数响应式编程TFRP使得状态管理变得简单和可扩展。和React搭配
1. Ant Design 是一套企业级前端设计语言和基于 React 的前端框架实现
1. lamejs：js重写的mp3编码器
1. MEAN
   - 认识：全栈javascript开发架构，即MongoDB、ExpressJS，AngularJS、Node.js
     1. MongoDB是一个使用JSON风格存储的数据库，非常适合javascript。(JSON是JS数据格式)
     1. ExpressJS是一个Web应用框架，提供有帮助的组件和模块帮助建立一个网站应用
     1. AngularJS是一个前端MVC框架
     1. Node.js是一个并发 异步 事件驱动的Javascript服务器后端开发平台
   - 特点
     1. 数据格式前后端无缝通用JSON数据格式
     1. 数据库对象即前后端对象，方便，前后端语法相同，还是方便