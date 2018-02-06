1. jade模板引擎
    ```
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
            .container // class名称
                .cow
                    each item in movies // 循环控制
                        a(href="/movie/#{item.id}")
    ```
###Vue
1. Vue
 - 解释：web界面开发库，加上周边配套的工具，构成开发框架
1. 特点
 - 简洁轻量、快速、模块友好
 - 数据绑定：数据和视图双向绑定/数据驱动
 - 组件化：单独的vue组件可以互相引用而组装起来
 - 数据间依赖自动处理
1. 开发环境介绍
 - node/npm/webpack
 - vue-cli：脚手架工具，用来生成模板的vue工程，即按照设计图盖房子


1. 同时从两方面入手：一是官网的语法熟悉教程，二是通过一个成熟的demo去理解构建一个实际使用的项目过程。同步进行，掌握速度应该会快
1. yii结合vue：将vue独立出来，放到yii的目录中，vue和yii采用http通信即可。
1. 文档阅读：vue官网
1. 知识收集:http://gold.xitu.io/tag/Vue.js
###Angular
1. 目的：为web应用增强html的能力
1. 简述：为html进行扩展，html是伟大的静态语言，但它不适用与动态展示，angular帮助html进行web开发，并且很好和其他类库合作
1. 特性
 - 模块 module
 - 组件 component
 - 指令模板
 - MVVM/双向数据绑定(Data Binding)
 - 指令
 - 服务
 - 路由
 - *指令集丰富
 - 依赖注入
1. 解释
```
-双向数据绑定：自动更新视图的方法，解放你修改DOM的双手，体现在ng-model，双方一改都改。并且是普通的js对象
-控制器：关注数据变化和注册回调，定义DOM行为
-自身强大的指令集和服务器交互：ajax
-单页应用：深度链接，展示特定页面
-指令和组件：为应用创建特殊html，定制功能。使用指令创建重用组件
-依赖注入
-可测试的
```
1. 缺点：大而全，无法定制化，即重，性能不清楚
1. 语法定调
```
ng-app
    ng-controller=""
    ng-click="method()"
    {{obj.value}}
```

####使用
1. 组成
 - ng 核心模块
    1. Directive:核心指令集，ngClick/ngInclude/ngReapeat
    1. Service/Factories：核心服务集，通过DI来使用
    1. filter：核心过滤器，在指令和表达式渲染前转换模板数据
    1. Global APIs：核心公共API函数，低级js操作中可用
    1. function/object/provider
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
1. 表达式
 - 表示：{{ data }}
 - 特性：包含文字、运算符、变量，支持过滤器，不支持条件判断、循环、异常
1. 指令
 - ng-model：建立视图和作用域的联系，实现数据双向绑定。model是普通的js对象，没有必要去继承专有类型去实现特定特性，易于测试/维护/重用/无样板
 - ng-controller：是DOM元素的行为，不要操作DOM，应该注册回调和监听model变化
 - $scope.$watch(变量/函数, 执行的方法);
1. 路由...待补充：官网的示例Deep Linking
1. 实际使用
 - 外部修改angular数据
```
// 方法一：抓scope，用$apply触发数据同步到视图
var $scope = angular.element(appElement).scope();
$scope.$apply(function () {
    $scope.data = [{ id: 1, cnt: 4 }];
});
方法二：内部写好方法，里应外合，直接采用
parent.angular.offline();
```

1. angular：执行父窗口angular方法
parent.angular.element('#task_btn_37').scope().offline();
###Jquery
####总览
1. learn more, write less
1. 特点
 - 完美浏览器兼容性
 - 强大选择器、DOM操作
 - 多选的事件处理机制、链式操作
 - 插件丰富
 - AJAX、动画

####基础知识
1. $和window.onload
```
$(document).ready(function() {
 DOM加载完可以运行，可以存在多个
})
简写为：
$(function() {
 // 简写
})
类似window.onload，这个要图片加载完才运行
$(window).load(function() {})等价于window.onload
```
1. jQuery对象和DOM对象
 - 之间不能调用彼此方法
 - 相互转化
```
jQ——DOM:
$(..).get(0)或者$(..)[0]
DOM——jQ:
cr = document.getElementById(..);
$cr = $(cr)     // 转换完成
```
1. 和其他框架协作
 - 交出$：jQuery.noConflict();
 - 创建快捷方式：var $j = jQuery.noConflict();
 
####选择器
1. 这种选择器是跨浏览器的，和css选择器类似
1. 基本选择器
```
#/./E/*/,
```
1. 层次选择器
```
 空格     后代，子子孙孙
 >        只是子代
 +        在prev元素后所有的元素，包括父父级的兄弟元素。如：$("label + input")
 ~        之后所有同辈,等同$(..).nextAll()
```
1. 过滤选择器
 - 基本过滤
```
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
 - 内容过滤
```
:contains(text)            选择文本为test的
:has(selector)             有匹配的
:parent                    包含文本或者元素
:empty()                   不包含文本或者元素
```
 - 子元素选择
```
:nth-child(2n/even/odd)        数字或索引
:first-child/:last-child       类似:first只匹配一个元素，此为每个父元素匹配一个子元素
:nth-of-type(1)                所有prev类型子元素中的第一个
```
1. 属性选择器
```
[attr=value]
!=                           不等于
^=                           以...开始
$=                           以...结束
*=                           含有
|=                           等于或为前缀
[attr=value][attr=value]     缩小范围查找
```
1. 表单选择
 - 表单元素选择
```
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
 - 表单属性选择
```
:enabled/:disabled
:checked/:selected         select建议用于select元素
:input/:text/:submit
```
1. 其他特点
 - 转义特殊符号
```
$('#id\\#b');
```
 - .filter可以加入多个搜索条件，.find子子孙孙，.children只是子代

####DOM操作
1. 组成
 - DOM core————通用性强，应用于任何标记性语言
```
如 getElementById/ByTagName()
getAttribute()/setAttribute()
```
 - HTML DOM————html专属
```
如 document.forms/src
```
 - CSS DOM
```
如 element.style.color
```
1. 创建DOM
 - append、prepend、after、before
```
$(..).append('<p/>')或者('<p></p>')         内部追加
$(A).appendTO(B)                            内部A加到B中
.
after();                                    外部加后面
insertAfter()                               A加到B后面
before();                                   外部加前面
```
1. 删除
```
remove()                 返回移除的引用
detach()                 不移除事件，remove会移除
empty()                  替代html()，清空
```
1. 复制、包裹标签
```
$(..).clone().append();                同时复制事件clone(true)
wrap/wrapAll/wrapInner
```
1. 属性操作
```
attr()
removeAttr()
hasClass()           判断
```
1. html、文本、值
```
html()
text()
val()
```
1. 焦点
```
focus()
blur()
```
1. 遍历节点
```
next()/prev()
siblings()
children()
parent()/parents()/closest()
```

####CSS、样式
1. css
```
.css()                   可获得外部css数据,attr/css都可一次设置多个、也可链式设置
.height()/.width()
```
1. 位置
```
offset()                    元素在当前视口的相对偏移
position()                  对于最近一个的position
scrollTop()/scrollLeft()
e.pageY/X                   获得鼠标位置
```
1. 尺寸
```
height([val|fn])           可用来设置window和document的高
如：$("p").height(function(n,c){
        return c+10;
});
width([val|fn])
innerHeight()
innerWidth()
outerHeight([soptions])
outerWidth([options])
```
1. 驼峰代替：fontSize 或者加引号写成'font-size'

####事件和动画
1. 绑定事件
```
bind()
unbing()
one()                  只产生一次事件
$(~).bind().bind()     绑定多个事件
```
1. 事件属性
```
event.type                     获取事件类型，'click'
event.target                   获得触发事件的元素
event.pageY/X
event.relatedTarget            鼠标事件的元素捕获
event.which                    获得点击的哪个鼠标按键
$(..).mouseDown(function(e) {
        alert(e.which);      1左2中3右
})
```
1. 表单事件
```
// 加入原生更灵活
// 反选：.click(function() {
        this.checked != this.checked;
})
// prop替代attr，可以将属性值统一，如checked=checked、checked=true
```
1. 冒泡：事件向上传递直至顶端。相反过程的事件捕获，只能原生
```
event.stopPropagetion()
```
1. 阻止元素默认行为
```
event.preventDefault()
或者 return false;
或者 function(e) {
        e.preventDefault()
}
```
1. 模拟事件方法
```
// 单独的如
$.click()
// 触发自定义事件
trigger()    // 如 $("input").trigger("delay")
```
1. 动画
```
show()/hide()                         可加延时，fast
fadeIn()/fadeOut()/集成toggle()        切换显示、隐藏
slideUp()/slideDown()                 改变高度，改变时有方向
animate(params, speed, callback)
is(':animate')                        是否处于运动状态
.delay(1000)                          延迟
```
1. 事件命名空间
 - 理解：为同个元素绑定的多个事件类型，用命名空间进行规范，可以绑定一个或多个命名空间
 - 认识：事件后加点和别名以便引用事件，如"click.a"。可以只触发/删除使用命名空间的事件
```
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
 - 应用
```
// 当一个元素绑定两个click事件，怎么卸载其中一个？
解决办法1：$(“#element").off("click", clickName);    // 指定事件
// 当不知道事件名或者是匿名函数怎么半?
$("#element")
        .on("click", function() {
            console.log("doSomething");
        });
```

####AJAX
1. ajax：$.ajax————$.load()————$.get/post()————$.getScript/getJson()
```
$.load()           载入页面用
callback(responseText, textStatus, XMLHttpRequest)   返回的内容、请求的状态(success/error/timeout/notmodified)、XML对象.jquery对xml的处理能力也很强
```
1. $('form/DOM').serialize()，序列化为字符串a=1&b=2，中文自动转码。反序列化unserialize。和$.param差不多。serializeArray()，序列化为JSON
1. ajax默认为全局，可以使用ajax全局函数：ajaxStart/ajaxSend/

####deferred————延迟对象
1. deferred对象就是jQuery的回调函数解决方案，延迟到未来某个点再执行
```
// 链式的延迟回调
$.ajax("test.html")
　　.done(function(){ alert("哈哈，成功了！");} )
　　.fail(function(){ alert("出错啦！"); } )
　　.done(function(){ alert("第二个回调函数！");} );
```
1. 多个操作指定回调函数
```
$.when($.ajax("test1.html"), $.ajax("test2.html")).fail().done();
```

####版本、插件
1. 1.7的on替代了bing/delegate/live，支持AMD，弃用live/die，off代替unbind/undelegate/die
1. 插件有jquery.form.js、jquery.cookies.js
1. 编写jquery插件方法
 - 封装对象方法
 - 封装全局函数
 - 选择器插件

####优化和技巧
1. 内容、表现、行为相分离
```
// 这是不对的，但是能运行
function demo() {}
<p onclick="demo()"></p>
1 判断元素是否存在：$(..).length()，跟js一样
2 DOM对象不存在选择时会报错，$(..)[0]不会
```
1. $(~).find()可以提高搜索的性能
1. IE8及以下对class的检索只能搜索DOM，所以非常低效
1. attr=value，这种搜索同样对性能有害，加上find、filter
1. $(~).find(:hidden)，伪选择器也慢，用#
1. 同一个操作对象多用链式开发
1. 可以将jquery缓冲到全局变量中，供其他函数使用
1. 先循环生成DOM，再一次性插入html()，DOM操作很低效
1. for代替$.each，原生代替jquery，如this.style.css替代css()
1. 相同的代码可以写成jquery插件
1. 用join代替+连接字符串
1. jquery可以强大的操作xml
1. 技巧
```
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
或者
$(~).find('option:selected');
```
####实际的那些坑
1. 使用sco引入页面，多次引入页面，表单重复提交
 - 原理：使用了$(document).on("submit", "form", function(e){}绑定事件，因为document给整个页面绑了多次事件，才会多次提交。sco没有起另外一个iframe，只是把一些DOM放入了模态框，$(document)是把整个页面绑了多次事件
 - 解决办法：将事件绑在具体的模态框里，DOM消失时，事件也就没有了
```
$('#region_form').on("submit", "", function(e){
```
1. 用on替代live事件
```
// 未来元素事件要绑定到document上，用on
// 因为事件冒泡，绑到了document上，之前没有元素就绑不了事件
$(document).on('click', '#element', function() {})
```
1. 添加DOM元素
```
var html = [];
html.push('<tr>');           // js的push方法
html.push('<td class="col-sm-1"></td>');
html.push('</tr>');
tbody.append(html.join(''));
```
