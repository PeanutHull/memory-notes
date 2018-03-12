### Servlet
1. 认识：Java写的服务器端小程序，部署在web服务器上的组件，可以访问所有java API，用于创建基于java的动态网页，无法独立运行，必须运行在servlet容器中，一个请求一个线程，性能好，独立于平台，安全性好
1. 内置对象，9个，是Web容器创建的一组对象，可以不new直接使用的内置对象
   - pageContext        pageContext
   - page               this
   - application        getServletContext()，整个web应用
   - config             getServletConfig
   - request
   - response
   - out                response.getWriter();
   - session            request.getSession()
   - exception          Throwable
1. pageContext
   - 理解：PageContext类的实例，提供对jsp页面所有对象和命名空间的访问，相当于所有功能的集大成者。包含除page和exception的6大对象、指令信息(如缓冲信息/页面scope/错误页面地址)
   - 方法：getOut/getSession/getPage/getRequest/getResponse/get(set)Attribute/getAttributeScope/forward/include
1. page
   - 理解：Object类的实例，指当前页面，类似this
   - 方法：getClass/hashCode/equals/copy/clone/toString/notify/notifyAll/wait
1. application
   - 理解：ServletContext的实例，实现用户数据共享，可存放全局变量。始于服务器启动终于服务器关闭
   - 方法：setAttribute/getAttribute/getAttributeNames/getServerInfo(返回jsp引擎)
1. config
   - 理解：ServletConfig类的实例，是servlet初始化时定义数据使用
   - 方法：getServletContext/getInitParameter/getInitParameterNames
1. request
   - 理解：请求，`javax.servlet.http.HttpServletRequest`的实例，页面返回前都有效
   - 方法
     1. getParameter()：单个参数
     1. getParameterValues()：多个参数
     1. getParameterNames()：所有参数
1. response
   - 理解：响应，`javax.servlet.http.HttpServletResponse`的实例，只对当前页面有效
   - 方法
     1. getWriter()
     1. setContentType()
     1. setCharacterEncoding("utf-8")
1. out
   - 理解：PrintWriter类的实例，用于输出结果。缓冲区：Buffer，内存的一块区域用来保存临时的数据，用于加速数据输出，好比一颗颗和一碗碗吃米饭
   - 方法
     1. println：向客户端打印，`out.println();`
     1. flush：将缓冲区内容输出到客户端
     1. clear：清除缓冲区内容，flush之后调用抛异常
     1. clearBuffer：清除缓冲区内容，flush之后调用不抛异常
     1. close：关闭缓冲区
1. Session
   - 理解：HttpSession类，通过超链接打开的属于同一次会话
     1. getAttribute/setAttribute
     1. getMaxInactiveInterval/setMaxInactiveInterval(过期时间)
     1. invalidate(销毁)
1. exception
   - 理解：Exception类的对象，页面异常对象
   - 方法
     1. getMessage
     1. printStackTrace(显示异常栈轨迹)
     1. FillInStackTrace(重写异常执行栈轨迹)
     1. toString
1. 过滤器
   - 理解：请求/响应动作之前进行拦截，能改变用户请求的路径，不能改变返回数据
   - 生命周期：调用链，按照web.xml的定义顺序，filter1请求传回过滤链前->filter2请求传回过滤链前->service->filter1请求传回过滤链后->filter2请求传回过滤链后
     1. web.xml：实例化一次
	 1. init：初始化
	 1. doFilter()：开始过滤
	 1. destory()：销毁
   - 捕捉动作：Servlet2.5支持
     1. REQUEST：用户直接访问页面时调用
     1. ORWARD：转发时调用，即通过RequestDispatcher的forward访问
     1. INCLUDE：被包含的请求时调用，即通过RequestDispatcher的include访问		
     1. ERROR：通过声明式异常处理机制时调用
   - Servlet3.0新功能
     1. async：支持异步处理，先返回结果，后台一直执行直到结束，开启web.xml和Filter类的异步开关，`AsyncContext context = request.startAsync();`
     1. @WebFilter：将一个类声明为过滤器
   - 实例
     1. web.xml配置
        ```XML
        <filter>
          <filter-name>LogFilter</filter-name>
          <filter-class>com.runoob.test.LogFilter</filter-class>
          <init-param>
            <param-name>Site</param-name>
            <param-value>菜鸟教程</param-value>
          </init-param>
        </filter>
        <filter-mapping>
          <filter-name>LogFilter</filter-name>
          <url-pattern>/*</url-pattern>
          <dispatcher></dispatcher>                 // 过滤类型请求，dispatcher：REQUEST、INCLUDE、FORWARD、ERROR，默认REQUEST
        </filter-mapping>
        ```
     1. 过滤器类
		```Java
		public class LogFilter implements Filter{
			public void  init(FilterConfig config) throws ServletException {
				String site = config.getInitParameter("Site");                  // 获取初始化参数
			}
			public void doFilter(ServletRequest request, ServletResponse response, FilterChain chain) throws java.io.IOException, ServletException {
				chain.doFilter(request,response);                               // 完成具体的过滤操作，FilterChain指出后续过滤器
			}
			public void destroy(){}                                             // Filter实例被Web容器从服务移除之前调用
		}
		```
1. 监听器
   - 理解：针对其他对象发生的事件/状态改变，进行监听和处理的对象。是servlet规范定义的一种特殊类，用于监听ServletContext/HttpSession/ServletRequest域对象的创建/销毁/属性修改等事件，可以在事件发生前、发生后做出响应。优先级：监听器->过滤器->Servlet
   - 分类
     1. 按照监听对象
	    - ServletContext：应用程序环境对象
		- ServletRequest：请求消息对象
		- HttpSession：用户会话对象
     1. 按照监听的事件：域对象的创建/销毁，属性增加/删除
   - 实例
        ```Java
        public class XxxListener implements ServletContextListener{                     // 针对ServletContext	
            public void contextInitialized(ServletContextEvent servletcontextecent) {}
            public void contextDestoryed(ServletContextEvent servletcontextecent) {}
        }
        <listener>                                                                      // web.xml注册
            <listener-class>com.package.XxxListener</listener-class>
        </listener>
        ```
1. wiki
   - 国际化：Locale对象提供，如en_US。i18n 国际化、l10n 本地化
   - 目录结构
      1. src：源码目录
      1. WEB-INF：存放web资源/配置/类库，安全目录只有服务端能访问，包含web.xml部署描述符
   - 生命周期
      1. init()
         - 容器执行时，先读取web.xml的配置、检验错误
         - 读取listener、context-param节点
         - 容器创建一个ServletContext(application)，并将param配置写入ServletContext，web项目所有部分都将共享这个上下文
         - 容器先后创建listener、filter、servlet实例
      1. service()：服务器收到的每一个请求会创建新的线程并单一调用service()方法，检查请求类型选择doGet、doPost、doPut、doDelete
      1. doGet/doPost
      1. destory()：只调用一次
   - 类的继承关系：自定义servlet——HttpServlet类(实现了http协议)——GenericServlet类(与协议无关)——Servlet接口
   - 版本变迁：servlet2.4起配置顺序不再强制要求，servlet3.0起可以使用注解配置servlet
   - web.xml：web-app是根元素，DOCYTPE声指示适用的servlet规范版本，子元素状态可有可无、唯一一个、可多个，大小写敏感
### JSP
1. 理解：Java Server Pages，是简化的servlet设计，在html中插入java代码(scriptlet)和jsp标记(tag)，实现了html中的java扩展，与servlet比较，方便编写html，不用大量的println一句句的输出，servlet是老的cgi的方式，内置对象和servlet相同
1. 标记
   - 指令标记
     1. <%@ page name="value" %>：声明页面属性
     1. <%@ taglib uri="" prefix="" %>：引入标签库/自定义标签
     1. <%@ include file="url" %>：引入其他文件，如jsp、html、文本文件。等价于jsp:directive.include
   - 声明标记
     1. <%! %>：声明变量方法类
   - 表达式标记
     1. <%= %>：输出结果，不以分号结束，和out.println()相同
   - 脚本标记
     1. <% %>：运行java代码
   - 动作标记
     1. <jsp:forward page="url">
     1. <jsp:include page="url">
     1. <jsp:useBean id="" class="">
   - 注释标记
     1. `<%-- --%>`：jsp注释
     1. `<!-- -->`：html注释
1. 标准动作标记
   - 理解：形式<jsp:xxx>，即标准动作标签/元素
   - 属性
     1. id：该动作元素的唯一标识，可以通过PageContext调用
     1. scope：作用域，为page(当前页面有效)、request、session、application
   - 组成
     1. useBean
     1. include/forward/param/params/plugin/fallback：jsp1.2存在的基本元素。param：forward的子标签，plugin：用于包含Applet和JavaBean
     1. root/declaration/scriptlet/expression/text/output：jsp2.0新增，和文档有关，text：文本模板，只能包含文本和EL表达式
     1. element/body/attribute：jsp2.0新增，用于XML动态生成，分别表示父标签、主体、属性
     1. invoke/dobody：jsp2.0新增，用在Tag File中
1. JSTL
   - 理解：JSP Standard Tag Library，JSP标准标签库。实现代码复用、增强可读性、简化开发
   - 分类
     1. 核心标签
     1. 格式化标签
     1. sql标签
     1. xml标签
     1. jstl函数
   - 使用
     1. 核心标签
        ```Java
        <c:out value="${salary}"/> // 在JSP中显示数据
        <c:set var="salary" scope="session" value="${2000*2}"/> // 保存数据，设置变量值和对象属性，类似<jsp:setProperty>
        <c:remove var="salary"/> // 删除数据
        // if
        <c:if test = "${catchException != null}">
            发生了异常: ${catchException.message}</p>
        </c:if>
        // choose，用于判断
        <c:choose>
            <c:when test="${salary <= 0}"></c:when>
            <c:when test="${salary > 1000}"></c:when>
            <c:otherwise></c:otherwise>
        </c:choose>
        // forEach
        <c:forEach var="i" begin="1" end="5">
            Item <c:out value="${i}"/><p>
        </c:forEach>
        // forTokens，根据指定分隔符分隔内容并迭代输出
        <c:forTokens items="google,runoob,taobao" delims="," var="name">
            <c:out value="${name}"/><p>
        </c:forTokens>
        // import，检索url，将其内容展示给页面
        <c:import>  
        // redirect，重定向
        <c:redirect url="http://www.runoob.com"/>
        // url，使用可选参数构造url
        // param，给包含或重定向的页面传递参数
        <c:url var="myURL" value="main.jsp">
            <c:param name="name" value="Runoob"/>
            <c:param name="url" value="www.runoob.com"/>
        </c:url>
        // catch，处理异常状况，将错误信息储存起来
        <c:catch var ="catchException">
            <% int x = 5/0;%>
        </c:catch>
        ```
     1. 格式化标签：引入`<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/fmt" %>`
        - `<fmt:formatNumber>` // 针对指定格式或精度的数字
        - `<fmt:parseNumber>` // 解析代表数字、货币、百分比的字符串
        - `<fmt:formatDate>` // 针对日期和时间
        - `<fmt:parseDate>` // 解析代表日期和时间的字符串
        - `<fmt:setLocale>` // 指定地区
        - `<fmt:timeZone>` // 指定时区
        - `<fmt:setTimeZone>` // 指定时区
        - `<fmt:bundle>` // 绑定资源
        - `<fmt:setBundle>` // 绑定资源
        - `<fmt:message>` // 显示资源配置文件信息
        - `<fmt:requestEncoding>` // 设置request的字符编码
        - TODO 以上没有仔细看：http://www.runoob.com/jsp/jsp-jstl.html
     1. sql标签：引入`<%@ taglib prefix="fmt" uri="http://java.sun.com/jsp/jstl/sql" %>`
        - `<sql:setDataSource>` // 指定数据源
        - `<sql:query>` // 运行查询语句
        - `<sql:update>` // 运行更新语句
        - `<sql:param>` // 设置sql语句的参数
        - `<sql:dateParam>` // 将SQL语句中的日期参数设为指定的java.util.Date值
        - `<sql:transaction>` // 执行事务语句
          ```Java
          <sql:setDataSource var="snapshot" driver="com.mysql.jdbc.Driver"
              url="jdbc:mysql://localhost/TEST"
              user="root"  password="pass123"/>
          <sql:query dataSource="${snapshot}" var="result">
              SELECT * from Employees;
          </sql:query>
          ```
     1. xml标签：引入`***xml %>`
        - `<x:out>` // 类似<%= ... >，只用于XPath表达式
        - `<x:parse>` // 解析xml
        - `<x:set>` // 设置XPath表达式
        - `<x:if>` // 判断XPath表达式
        - `<x:forEach>` // 迭代xml的节点
        - `<x:choose>/<x:when>/<x:otherwise>` // 
        - `<x:transform>` // XSL转换应用在XML中
        - `<x:param>` // 和<x:transform>共同使用，用于设置XSL样式表
     1. JSTL函数：引入`<%@ taglib prefix="fn" uri="http://java.sun.com/jsp/jstl/functions" %>`
        - `fn:length()` // 字符串长度
        - `fn:join()` // 字符串合并
        - `fn:replace()` // 替换字符串
        - `fn:split()` // 分割字符串
        - `fn:trim()` // 移除首尾空白
        - `fn:toLowerCase()/fn:toUpperCase()` // 转大小写
        - `fn:indexOf()	` // 返回指定字符串出现的位置
        - `fn:substring()/fn:substringAfter()/` // 返回(之前/之后)的子串
        - `fn:contains()/fn:containsIgnoreCase()` // 测试字符串是否包含指定的子串
        - `fn:startsWith()` // 是否以指定开头开始
        - `fn:endsWith()` // 是否以指定后缀结尾
        - `fn:escapeXml()` // 跳过可以作为XML标记的字符
   - EL
     1. 理解：Expression Language，表达式语言，创建表达式并输出结果。和<%=%>作用相同
     1. 表示：${expr}
     1. 基础操作符
        - `.` // 访问一个bean属性或者映射条目，不能用于键名包含-符号和为变量时不适用
        - `[]` // 数组或者链表的元素，如${booklist[0].price}
        - `+-*/%` // 加减乘除取余
        - `==!=><` // 各种等于不等于
        - `&&||!` // 与或非
        - `empty` // 是否为空
     1. 变量：环境变量，或称为隐式对象，部分有：PageScope/RequestScope/SessionScope/ApplicationScope
     1. 函数：${ns:func(param1, param2)}，这些函数必须被定义在自定义标签库中
     1. 举例：`<%=session.getValue("name")%>`等同于`<c:out value="${sessionScope.name}">`
1. 其他
   - 创建自定义标签类
     1. 定义类
        ```Java
        import javax.servlet.jsp.tagext.*;
        public class HelloTag extends SimpleTagSupport {
        public void doTag() throws JspException, IOException {
            JspWriter out = getJspContext().getOut();
            out.println("Hello Custom Tag!");
        }
        }
        ```
     1. 建立标签配置文件：ROOT\WEB-INF\xxx.tld
   - 处理xml文档
     1. 发送xml：修改页面头`<%@ page contentType="text/xml" %>`
     1. 展示xml
      ```Java
      <c:import var="bookInfo" url="http://localhost:8080/books.xml"/> // 载入xml文档
      <x:parse xml="${bookInfo}" var="output"/>
      <x:out select="$output/books/book[1]/name" />
      ```
   - 生命周期
     1. 编译阶段：解析jsp转成Servlet，编译Servlet文件，生成servlet类
     1. 初始化阶段：加载Servlet类，创建实例，调用初始化方法——jspInit()
     1. 执行阶段：_jspService(HttpServletRequest request,HttpServletResponse response)
     1. 销毁阶段:jspDestroy()
### JavaEE
1. 理解：是一个平台，是企业级分布式应用开发标准。有13个规范，构建于Java SE之上，提供API和运行环境，来运行大规模、可扩展的多层次的网络应用
1. 特点：分布式、事务性、安全性、集成化、可扩展、可移植、易维护
1. 规范：13个
   - Servlet
   - JSP
   - EJB
   - JMS：Java消息服务，实现异步的消息传递。支持点对点/发布订阅，可实现事务型/一致性/持久性消息传递
   - JTA：Java事务处理API，Java Transaction API，保证了用户操作ACID（即原子、一致、隔离、持久）属性，跨数据源必须使用全局事务JTA，提供了分布式事务服务，实现了透明的事务管理方式，划清数据库中上行和下行的通信界限
   - JTS：Java事务服务，Java Transaction Service，是一个组件事务监视器，为应用服务器/资源管理器/独立应用/通信资源管理器提供事务服务
   - RMI：远程方法调用，Remote Method Invoke。像调用本地一样调用另一个java虚拟机上的方法，stub/skeleton层提供客户端和服务端交互接口
   - IDL/CORBA：接口定义语言/公用对象请求代理程序体系结构
   - JNDI：Java的命名和目录接口，Java Naming and Directory Interfaces。使Java能够无缝地获取任何可目录化的企业信息，独立于目录协议，可以访问LDAP、NDS
   - JDBC
   - XML
   - JavaMail API
   - JAF：JavaBean Activation Framewor，提供统一处理不同数据格式的方法
1. JavaEE容器
   - 理解：就是运行环境
   - Web容器
     1. Tomcat
     1. Jetty：为JSP和servlet提供运行环境的用Java语言编写的的web容器
   - 应用容器
     1. 理解：ejb容器无最大访问量一说，本身就是分布式/可伸缩的，只需增加机器就可实现同时计算，Tomcat和Jetty不是应用容器，无法运行EJB或JMS技术
     1. 组成：JBoss、GlassFish、Oracle Weblogic、IBM WebSphere
        - Jboss
          1. 理解：开源的管理EJB的容器和服务器，不支持Servlet/JSP，一般与Tomcat/Jetty配合使用
          1. 特点
             - JMX微内核作为总线结构
             - 面向服务架构(SOA，Service-Oriented Architecture)
             - 具有统一的类装载器，实现应用热部署和热卸载能力
             - 高度模块化和松耦合
             - 支持集群
1. RMI
   - 理解：Java Remote method invocation，java方法远程调用，基于socket方式的远程调用，是java分布式的基础，将对象序列化在网络上传输
   - 原理：服务端编写interface和其实现，客户端远程调用
     1. 先定义RMI能够提供的服务，即interface，生成调用入口，编写实现类
     1. 编写RMI注册机制，并启动
     1. 客户端就可以访问了
1. EJB
   - 理解：JavaEE服务器端组件模型，Enterprise Java Beans，用于部署分布式应用程序，是一个逻辑概念，与传统的bean无关，就是将一个业务逻辑类放在服务器上部署，供客户端调用，依赖RMI通信，EJB3.0从早期版本已分离出来。用于部署分布式的程序，非常重量级，配置复杂，没有spring轻量，目前使用比较少。容器类框架
   - 关键字：服务集群、企业开发
   - 特点
     1. 数据持久化
     1. 事务处理
     1. 并发控制
     1. 基于JMS的事件驱动
     1. 基于JNDI的名字和空间管理
     1. 基于JCE和JAAS的安全管理
     1. 应用服务器端的软件组件部署
     1. 使用RMI-IIOP协议的远程过程调用
     1. 将业务方法暴露为Web服务
   - 组成
     1. JPA：Java Persistence API，中文名Java持久层API。是JDK 5.0注解或XML描述对象关系表的映射关系，并将运行期的实体对象持久化到数据库中，提供了一种标准的OR映射解决方案
   - 分类
     1. 会话Bean
     1. 实体Bean：和数据库打交道
     1. 消息驱动Bean
   - EJB容器：是EJB组件的运行环境，为部署EJB组件提供服务，包括事务、安全、远程客户端的网络发布、资源管理等
   - EJB服务器：管理EJB容器的高端进程或应用程序，并提供对系统服务的访问
     1. EJB客户端：Servlet/JSP/Java Application/Web Service/Applet/EJB
     1. EJB服务器：Enterprise Bean
   - EJB架构：ejb客户端————RMI/JNDI————remote/home接口————ejb服务器————ejb容器————BEAN代理————对象池————ejb实例————ejb部署描述
1. JSF：Java Server Faces，Java EE中构建web页面的，基于事件绑定，基本没人用。Facelets是jsf MVC的视图部分，利用数据将模板转为html
### wiki
1. Servlet版本历史
   - 4.0——草案——HTTP/2支持
   - 3.1——2013年——JavaEE 7——NIO
   - 3.0——2009年——JavaEE 6, JavaSE 6——简易开发，异步servlet、新注解使web.xml部署描述文件开始不再是必选、插件支持
   - 2.5——2005年——JavaEE 5, JavaSE 5——支持注释
   - 2.4——2003年——J2EE 1.4, J2SE 1.3——web.xml
   - 2.3——2001年——J2EE 1.3, J2SE 1.2——增加Filter
   - 2.2——1999年——J2EE 1.2, J2SE 1.2
   - 2.1——1998年————添加请求转发
   - 2.0——JDK 1.1
   - 1.0——1997年
1. JSP版本特性
   - 2.0：加入了EL表达式语言
1. Tomcat版本和servlet、jsp的支持
   - 9.X——Java8——servlet4.0——jsp2.4
   - 8.X——Java7——servlet3.1——jsp2.3
   - 7.X——Java6——servlet3.0——jsp2.2
   - 6.X——Java5——servlet2.5——jsp2.1
   - 5.5——Java5——servlet2.4——jsp2.0
   - 4.1——Java5——servlet2.3——jsp1.2
   - 3.3——Java5——servlet2.2——jsp1.1
1. Java EE版本历史
   - Java：1995年
   - J2ee 1：1999年
   - J2ee 1.4：2002年，EJB2.0
   - JavaEE 5：2006年，EJB3.0，简化开发、引入注释、更新的web服务、加强的持久化模型
   - JavaEE 7：提高生产力，带注释的POJO————html5：WebSockets、json、Servlet3.1 NIO、REST————企业需求：批量处理实现不间断OLTP性能、简化多线程并发任务的定义提高可扩展性、简化JMS具有选择性和灵活性