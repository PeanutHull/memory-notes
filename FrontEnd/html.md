1. html：超文本标记语言
1. dom：一组用来描述脚本怎样与结构性文档进行交互和访问的Web标准。DOM定义了一系列的对象、方法和属性，用于访问、操作和创建文档中的内容、结构、样式以及行为。
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
        - Content-Type：如text/html; charset=utf-8。h5字符集可简写为`<meta charset="utf-8">`
        - Content-Language：如zh-cn
        - Expires：页面过期时间，如Fri,12 Jan 2001 18:18:18 GMT，GMT时间格式
        - Refresh：自动刷新时间和地址，如100;url=
        - Set-Cookie：如cookievalue=，expires=，path=/
        - Pragma：cache模式，如no-cache
        - Window-Target：强制窗口以独立页面显示，如_top
1. icon
   - 标签页图标，根路径命名为favicon.ico，浏览器自动载入
   - 标签载入：`<link rel="shortcut icon" type="image/x-icon" href=""/>`
1. html5
   - 结构层：新的标签
     1. 布局结构：header——navigator——content——sidebar——footer   
   - 表现层：选择器、动画、圆角
   - 行为：canves
### wiki
1. web标准：结构(html)、表现(css)、行为(js)相分离
   - 语义化标签，规范使用
1. 浏览器引擎：分为渲染引擎(layout engineer)和javascript引擎
   - 浏览器内核分类
     1. -ms-：Trident：IE
     1. -moz-：Gecko：FireFox
     1. -webkit-：Webkit：Safari
     1. -webkit-：Chromium/Bink：Chrome
1. seo：description中写自然语言，和关键字高度关联但不雷同，字数合适
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