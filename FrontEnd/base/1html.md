1. html：hyper text markup language，超文本标记语言，浏览器解释执行，语法要求不严，标签不闭合/大小写不注意/引号运用不严格。html和htm无区别，xhtml是语法严格的版本，但不流行
1. html：标准通用标记语言SGML(Standard Generalized Markup Language)的分支：超文本标记语言(html HyperText Markup Language)和XML
  - 实例
    ```
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Page Title</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
        <script src="main.js"></script>
    </head>
    <body>
        
    </body>
    </html>
    ```
1. 标签
   - 理解：用两个尖括号括起来，不区分大小写，一个标签可以有N个属性，每个标签都闭合，不能交叉嵌套。属性是配合标签来完善功能的
   - 分类
     1. 对标签：包含起始和结束标签，内容写在对标签中间，属性写在起始标签括号内
     1. 单标签
   - 组成
     1. a：可以打开一个超链接，超链接是网络的灵魂。属性：`target="_blank"`、`href="跳转位置的元素、ID、class，#id表示锚点作定位器"`
        - target：
          1. _self    当前窗口（默认）
          1. _blank    新窗口
          1. _parent 父框架集
          1. _top 整个窗口
          1. _framename 指定框架
     1. img：属性：title(鼠标停留的显示)、alt(加载失败文本提示和seo指定图片内容)，可以做热点地图
     1. span、h1~h6、strong、em、u
     1. ul/li/ol：属性：`list-style:none`、`colspan`、`rowspan`
     1. dl>dt+dd*2：自定义列表，dl开始/dt标题/dd列表内容
     1. table/tr/td
     1. form：属性：`action`、`method`，多个值用中括号同时传递
        - input：text/password/radio/checkbox/file/button/submit/hidden/reset
        - select/option：属性：`multiple="multiple"` 表示可多选、`selected="selected"`
        - textarea
     1. div
     1. pre、hr、br
1. meta
   - 理解：元信息标签，辅助性标签，用于设定页面格式、针对搜索引擎，键值对形式。`<meta>`
   - 分类
     1. name/content：属性作用
        - keywords、description、robots、author
        - viewport：移动设备，`<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no"/>`
          1. initial-scale：初始缩放比例 0~10
          1. minimum/maximum-scale：允许用户缩放到的比例
          1. user-scalable：用户是否可以手动缩放 (no,yes)
          1. initial-scale：为1则非响应式网站上，以100%宽度渲染
     1. http-equiv/content：文件头作用，向浏览器传递有用信息
        - Content-Type：如text/html; charset=utf-8。h5字符集简写为`<meta charset="utf-8">`
        - Content-Language：如zh-cn，GBK兼容GB2312，UTF-8万国码
        - Expires：页面过期时间，如Fri,12 Jan 2001 18:18:18 GMT，GMT时间格式
        - Refresh：自动刷新时间和地址，如100;url=
        - Set-Cookie：如cookievalue=，expires=，path=/
        - Pragma：cache模式，如no-cache
        - Window-Target：强制窗口以独立页面显示，如_top
1. body中的标签存放展示的内容，网页主体
1. 帧窗口：也叫框架技术，把页面分成多个小窗口，每个对应自己的html，布局复杂，效率没有单页高，seo不友好。<frameset>标记框架开始和结束，不代表实体的框架，不建议使用
   - <frame>：具体框架，不能和body共存，属性：`name` a标签可用target="name"指定显示、`scrolling` yes/no/auto
   - <iframe>：可和body共存
1. icon
   - 标签页图标，根路径命名为favicon.ico，浏览器自动载入
   - 标签载入：`<link rel="shortcut icon" type="image/x-icon" href=""/>`
1. 实体：用符号表示特殊字符，被表示的字符有"/</>/&/空格
1. 注释：`<!--...-->`
1. 表单提交
```html
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="name">
    <input type="file" name="file">
    <input type="submit">
</form>
```
### wiki
1. 知识点
   - /表示标签结束，单标签/符号在后边如`<img/>`，对标签/在字母前边`<a></a>`
   - html/css/js不区别单双引号
1. web标准：结构(html)、表现(css)、行为(js)相分离
   - html：语义化标签，规范使用
1. 浏览器引擎：分为渲染引擎(layout engineer)和javascript引擎
   - 浏览器内核分类
     1. -ms-：Trident：IE
     1. -moz-：Gecko：FireFox
     1. -webkit-：Webkit：Safari
     1. -webkit-：Chromium/Bink：Chrome
1. seo：description中写自然语言，和关键字高度关联但不雷同，字数合适
1. doctype：文档声明，告知浏览器所使用的超文本或者可扩展超文本规范。<!DOCTYPE> 声明必须是html文档的第一行，位于html标签之前。html4.01这个声明引用DTD，因为其基于SGML，DTD 规定了标记语言的规则，这样浏览器才能正确地呈现内容。html5不基于，不需要引用DTD。`<!DOCTYPE html>`
1. html版本
   - html4.01
   - html5
     1. 结构层：新的标签。布局结构：header——navigator——content——sidebar——footer   
     1. 表现层：选择器、动画、圆角
     1. 行为：canves
1. meta标签其他属性
    ```html
    // UC强制竖屏
    <meta name="screen-orientation" content="portrait">
    // UC强制全屏
    <meta name="full-screen" content="yes">
    // UC应用模式
    <meta name="browsermode" content="application">
    // QQ强制竖屏
    <meta name="x5-orientation" content="portrait">
    // QQ强制全屏
    <meta name="x5-fullscreen" content="true">
    // QQ应用模式
    <meta name="x5-page-mode" content="app">
    // 优先使用最新版本
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
    <meta http-equiv="X-UA-Compatible" content="IE=6" ><!-- 使用IE6 -->
    <meta http-equiv="X-UA-Compatible" content="IE=7" ><!-- 使用IE7 -->
    <meta http-equiv="X-UA-Compatible" content="IE=8" ><!-- 使用IE8 -->
    // 浏览器内核控制
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    // Windows 8
    <meta name="msapplication-TileColor" content="#000"/> <!-- Windows 8 磁贴颜色 -->
    <meta name="msapplication-TileImage" content="icon.png"/> <!-- Windows 8 磁贴图标 -->
    // 避免百度转码
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    // apple的webapp全屏模式
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    ```
