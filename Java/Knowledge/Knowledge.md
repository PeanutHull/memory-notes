### Java小程序
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
### Java知识点
1. Groovy
   - 理解：Groovy是JVM衍生的与JAVA语法高度兼容的动态强类型语言
1. POJO
   - 理解：实体类，简单java对象(Plain Old Java Objects)
   - 特点
     1. 编写应用程序类快速和简单
     1. 使用面向对象的角度写代码
1. 轻量级容器
   - 理解：提供了可插拔的体系结构
   - 容器提供的服务
     1. 声明周期管理
     1. 依赖解析
     1. 组件查找
     1. 应用程序配置
     1. 事物管理
     1. 安全性
     1. 线程管理
     1. 对象和资源池
     1. 对组件的远程访问
     1. 通过JMX之类的API管理组件
     1. 容器的扩展和定制
   - 控制反转
     1. 分类：依赖查找、依赖注入
### 各知识点版本
1. 最新版本
   1. 基础
      - Java8 = Java SE 8 = java se 1.8 = JDK 8
      - J2EE 1.5 = Java EE 5
   1. Java EE
      - Servlet 3.1
      - JSP 2.3
      - EJB 3.0
   1. 工具
      - Tomcat 9.0.0
      - Jetty 9.4.6
      - Jboss 7.1
      - Maven 3.3.9
      - Junit 4.12
      - Log4j 1.2.17
   1. 框架
      - Spring 5.0/4.3
      - Hibernate 5.2.x
      - Mybatis 3.4
1. Java EE版本历史
   - java技术————1995年
   - J2EE 1————1999年
   - J2EE 1.4————EJB2.0————2002年
   - JavaEE 5————EJB3.0————2006年————简化开发、引入注释、更新的web服务、加强的持久化模型
   - JavaEE 7————提高生产力：带注释的POJO————html5：WebSockets、json、Servlet3.1 NIO、REST————企业需求：批量处理实现不间断OLTP性能、简化多线程并发任务的定义提高可扩展性、简化JMS具有选择性和灵活性
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