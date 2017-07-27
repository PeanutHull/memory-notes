### 掌握知识点
1. 基础
   - OOP概念
   - 抽象类与接口
   - 构造函数与initialization order（初始化顺序）
   - 关键字：static、final、 volatile、synchronized、transient、this等等
   - File I/O 和 序列化
   - Collections：List、Map、Set
   - 异常
   - 泛型
   - JVM和内存管理
   - 多线程和同步
   - 设计模式
   - 反射机制
1. Web
   - JSP/Servlets
   - SSM三大框架
   - Tomcat
   - 基本库：log4j
### Java知识点
1. Applet
   - 理解：java编写的小应用程序，包含在html页中，产生于浏览器出现不久，还只能支持静态页面，用于创建RIAs，用于提供丰富互联网服务，如动画、动态内容、与服务器通讯、富客户端应用
   - 特点
     1. 可以实现图形、人机交互等多媒体表现
     1. 提供了抽象窗口工具箱的窗口环境开发工具，用于建立标准的图形用户界面
   - 使用：要求为支持java的浏览器在下载applet后在用户计算机上运行
   - 历史
     1. Flash出现后，Applet没有竞争力
     1. 后来ajax出现了，浏览器可以和服务器通讯了
     1. 后来Html5出现了，有音频、视频、2D图形(Canvas)，WebGL引入了3D图形
1. JavaFX
   - 理解：是Java的下一代图形用户界面工具包，对标Flash，用于创建RIAs(Rich Internet application)，是一种跨平台的桌面技术，2008年发布正式版
   - 组成
     1. JavaFX脚本
     1. JavaFX Mobile(一种移动操作系统)
   - 特点
     1. 可以直接调用java API
     1. JDK支持三大操作系统
     1. css定义外观，有WebView、3D图形、富文本、多点触控
   - 另：RIA三大技术：Flash、Silverlight、JavaFX
1. Swing
1. JNI：提供了若干的API实现了Java和其他语言的通信（主要是C&C++）
### 各知识点版本
1. 最新版本
   1. 基础
      - Java8 = Java SE 8 = java se：1.8.0 = JDK 8
      - Java EE 7：ee是一个大型的养猪场，而se自是个黑白花猪
   1. Java EE
      - Servlet 3.1
      - JSP：
   1. 工具
      - Tomcat：9.0.0
      - Maven：3.3.9
      - 
   1. 框架
1. Servlet版本历史
   - 4.0——草案——HTTP/2支持
   - 3.1——2013年——JavaEE 7——Non-blocking I/O
   - `3.0`——2009年——JavaEE 6, JavaSE 6——简易开发、异步servlet、新的注解使web.xml部署描述文件开始不再是必选、插件支持
   - `2.5`——2005年——JavaEE 5, JavaSE 5——支持注释
   - `2.4`——2003年——J2EE 1.4, J2SE 1.3——web.xml
   - `2.3`——2001年——J2EE 1.3, J2SE 1.2——增加Filter
   - 2.2——1999年——J2EE 1.2, J2SE 1.2
   - 2.1——1998年————添加请求转发
   - 2.0————JDK 1.1
   - 1.0——1997年
1. JSP版本特性
   - 2.0：加入了EL表达式语言
1. Tomcat版本对servlet/jsp的支持
   - 9.X——Java8——servlet4.0——jsp2.4
   - 8.X——Java7——servlet3.1——jsp2.3
   - 7.X——Java6——servlet3.0——jsp2.2
   - 6.X——Java5——servlet2.5——jsp2.1
   - 5.5——Java5——servlet2.4——jsp2.0
   - 4.1——Java5——servlet2.3——jsp1.2
   - 3.3——Java5——servlet2.2——jsp1.1