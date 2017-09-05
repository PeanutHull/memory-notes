### Java知识点
1. Java衍生语言
   - Groovy
     1. 理解：Groovy是JVM衍生的与JAVA语法高度兼容的动态强类型语言，可以运行在JVM上
   - Scala
     1. 理解：是一门多范式的编程语言,设计初衷是要集成面向对象编程和函数式编程的各种特性，支持函数式编程的类LISP语言，可以运行在JVM上
   - Clojure
     1. 理解：是一种运行在Java平台上的Lisp方言
1. JNI：提供了若干的API实现了Java和其他语言的通信（主要是C&C++）
1. Guava
   - 理解：一种基于开源的Java库，提供了用于集合，缓存，支持原语，并发性，常见注解，字符串处理，I/O和验证的实用扩展方法
1. 关键字
   - 基础关键字
     1. 注解
     1. java虚拟机
     1. IO、阻塞和非阻塞
     1. NIO
     1. 并发
     1. 线程池
     1. 同步容器和并发容器
     1. 反射
   - 高级关键字
     1. quartz
     1. 事务管理
     1. 连接池
     1. dubbo
     1. 分布式
     1. Netty
     1. CDN
     1. Elasticsearch
     1. solr
     1. 负载均衡
     1. mysql集群
     1. JVM性能调优
     1. 负载均衡
1. 关键功能具备
   - 异步任务
   - 缓存
   - 日志
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
### Java小程序
1. Applet
   - 理解：java编写的小应用程序，可以包含在html页中，内嵌于浏览器执行。产生于浏览器出现不久还只能支持静态页面的时候，用于创建RIAs，用于提供丰富互联网服务，如动画、动态内容、与服务器通讯、富客户端应用。是java的一种应用程序，要求浏览器支持JVM，作用类似flash，嵌入在html中，现在基本没人用
   - 特点
     1. 可以实现图形、人机交互等多媒体表现
     1. 提供了抽象窗口工具箱的窗口环境开发工具，用于建立标准的图形用户界面
     1. 可以包含awt、swing的组件
     1. Applet必须运行于某个特定的“容器”，这个容器可以是浏览器本身，也可以是通过各种外挂程式，或者包括支持Applet的移动设备在內的其他各种程序来运行。与一般的Java应用程序不同，Applet不是通过main方法來运行的。在运行时Applet通常会与用戶进行互动，显示动态的画面，并且还会遵循严格的安全检查，阻止潜在的不安全因素（例如根据安全策略，限制Applet对客戶端文件系统的访问）
   - 使用：要求为支持java的浏览器在下载applet后在用户计算机上运行
   - 历史
     1. Flash出现后，Applet没有竞争力
     1. 后来ajax出现了，浏览器可以和服务器通讯了
     1. 后来Html5出现了，有音频、视频、2D图形(Canvas)，WebGL引入了3D图形
   - 另：RIA三大技术：Flash、Silverlight、JavaFX
1. Awt
   - 理解：Abstract Window ToolKit 抽象窗口工具包。提供了一套与本地图形界面进行交互的接口，实际上是在利用操作系统所提供的图形库来构建界面
   - 特点
     1. 由于不同操作系统的图形库所提供的功能是不一样的，在一个平台上存在的功能在另外一个平台上则可能不存在。为了实现Java语言所宣称的"一次编译，到处运行"的概念，AWT 不得不通过牺牲功能来实现其平台无关性，也就是说，AWT 所提供的图形功能是各种通用型操作系统所提供的图形功能的交集
     1. AWT 是基于本地方法的C/C++程序，其运行速度比较快
1. Swing
   - 理解：用于开发Java应用程序用户界面的开发工具包。开发出来的程序可以在java虚拟机里独立运行，为了解决awt的问题而推出，比awt有更好的屏幕显示元素。是在AWT的基础上构建的一套新的图形界面系统，拥有更多的界面库
1. JavaFX
   - 理解：是Java的下一代图形用户界面工具包，对标Flash，用于创建RIAs(Rich Internet application)，是一种跨平台的桌面技术，2008年发布正式版
   - 组成
     1. JavaFX脚本
     1. JavaFX Mobile(一种移动操作系统)
   - 特点
     1. 可以直接调用java API
     1. JDK支持三大操作系统
     1. css定义外观，有WebView、3D图形、富文本、多点触控
### 大数据
1. Hadoop
   - 基础
     1. Hadoop1介绍
     1. Hadoop1架构
     1. Hadoop2架构
     1. HDFS操作
     1. yarn操作
   - 应用
     1. Hive数据仓库
     1. zk服务
     1. HBase非关心型数据库
     1. Sqoop数据库抽取工具
     1. Flume日志抽取工具
   - Spark
   - 基础
     1. Spark介绍
     1. RDD弹性分布式数据集
     1. Scala编程
   - 应用
     1. Spark-SQL组件
     1. DataFrame组件
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
      - Jboss 7.1/wildfly
      - Maven 3.3.9
      - Jekins 2.6
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
### 实际项目经验
1. Java 从零打造企业级电商实战 - 服务端
   - MyBatis
     1. 返回新增的主键：mapper.xml文件中insert标签加入属性：`useGeneratedKeys="true" keyProperty="id"`
     1. 数据绑定更新对应数据：mapper.xml文件中update指定parameterType的类地址：`parameterType="com.mall.pojo.Xxx"`
     1. 批量插入：对应于子订单的批量插入
1. 零碎
   - 获得当前运行的文件夹目录：`request.getSession().getServletContext().getRealPath('upload');`
   - Mac启动tomcat
     1. 启动：进入bin目录————sudo chmod 755 \*.sh————sudo sh startup.sh
     1. 关闭：sudo sh shutdown.sh(部署项目后需要重启)
1. 经验与心得
   - 实际的项目要找到官方的配置，根据官方的配置去写项目的配置
1. Java运行环境搭建
   - JDK
     1. rpm安装
     1. 编辑环境变量
      ```java
      vim /etc/prifile
      // 最下边添加
      export JAVA_HOME=/usr/java/jdk1.7.0_80
      export CLASSPATH=.:$JAVA_HOME/jre/lib/rt.jar:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar
      export MAVEN_HOME=/developer/apache-maven-3.0.5
      export CATALINA_HOME=/developer/apache-tomcat-7.0.73
      export PATH=$PATH:$JAVA_HOME/bin:$CATALINA_HOME/bin:$MAVEN_HOME/bin:$NODE_HOME/bin:/usr/local/bin:$RUBY_HOME/bin
      // 配置生效
      source /etc/profile
      // 检验
      java -version
      ```
   - Tomcat
      ```java
      // 解压压缩包
      tar -zxvf tomcat.tar.gz
      // 编辑配置文件
      vim conf/server.xml
      <Connector ... URIEncoding="UTF-8">
      // 启动tomcat
      cd bin;
      ./startup.sh
      ```
   - Maven
   - Nginx
      ```java
      // 安装nginx依赖
      yum -y install gcc zlib zlib-devel pcre-devel openssl openssl-devel 
      // 下载nginx安装包并解压、编译
      ./configure;make;make install;
      // 启动
      cd sbin;
      ./nginx;
      ```
   - Mysql
      ```java
      yum -y install mysql-server // 安装
      vim /etc/my.cnf // 设置字符集
      character-set-server=utf8 // [mysqld]下添加
      default-character-set=utf8
      ```
   - 部署脚本
      ```java
      echo "======更新代码======="    
      cd /developer/git-repository/mmall
      git fetch
      git pull
      echo "======编译并跳过单元测试======="
      mvn clean package -Dmaven.test.skip=true
      echo "======转移war包======="
      rm /developer/apache-tomcat-7.0.73/webapps/ROOT.war    
      cp /developer/mmall.war  /developer/apache-tomcat-7.0.73/webapps/ROOT.war
      rm -rf /developer/apache-tomcat-7.0.73/webapps/ROOT
      echo "======启动tomcat======="
      /developer/apache-tomcat-7.0.73/bin/shutdown.sh
      for i in {1..10}
      do
        echo $i"s"
        sleep 1s
      done
      /developer/apache-tomcat-7.0.73/bin/startup.sh
      ```