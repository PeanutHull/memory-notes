### JavaEE
1. JavaEE理解：是一种语言，也是一个平台，是企业级分布式应用开发标准。构建于Java SE之上，提供API和运行环境，来运行大规模、可扩展的多层次的网络应用
1. 特点
   - 分布式
   - 事务性
   - 安全性
   - 集成化
   - 可扩展、可移植、易维护
1. JavaEE规范
   - 分类
     1. Servlet
     1. JSP
     1. EJB
     1. JMS：Java消息服务，实现异步的消息传递。支持点对点/发布订阅，可实现事务型/一致性/持久性消息传递
     1. JTA：Java事务处理API，Java Transaction API，保证了用户操作ACID（即原子、一致、隔离、持久）属性，跨数据源必须使用全局事务JTA，提供了分布式事务服务，实现了透明的事务管理方式，划清数据库中上行和下行的通信界限
     1. JTS：Java事务服务，Java Transaction Service，是一个组件事务监视器，为应用服务器/资源管理器/独立应用/通信资源管理器提供事务服务
     1. RMI：远程方法调用，Remote Method Invoke。像调用本地一样调用另一个java虚拟机上的方法，stub/skeleton层提供客户端和服务端交互接口
     1. IDL/CORBA：接口定义语言/公用对象请求代理程序体系结构
     1. JNDI:Java的命名和目录接口，Java Naming and Directory Interfaces。使Java能够无缝地获取任何可目录化的企业信息，独立于目录协议，可以访问LDAP、NDS
     1. JDBC
     1. XML
     1. JavaMail API
     1. JAF：JavaBean Activation Framewor，提供统一处理不同数据格式的方法
1. JavaEE容器
   - 理解：就是运行环境
   - 分类
     1. Web容器
        - Tomcat
          - 理解：是Web服务器，也是servlet、jsp的运行环境/容器，最新的servlet和jsp规范总是能在Tomcat中得到体现
          - 特点：技术先进、性能稳定、免费开源
          - 响应http过程：web浏览器——Tomcat——Web服务器——Servlet容器——Servlet实例1/Servlet实例2
          - 不足：静态html能力不如apache，可以集成使用，Apache作为HTTP Web服务器，Tomcat作为Web容器
          - 组成：Container容器——Engine——HOST——Servlet
        - Jetty
          - 理解：为JSP和servlet提供运行环境的用Java语言编写的的web容器
     1. Java EE应用容器
        - 理解：ejb容器无最大访问量一说，本身就是分布式/可伸缩的，只需增加机器就可实现同时计算，Tomcat和Jetty不是JavaEE容器，无法运行EJB或JMS技术
        - 包含：GlassFish、JBoss、Oracle Weblogic、IBM WebSphere
          1. Jboss
          - 理解：开源的管理EJB的容器和服务器，不支持Servlet/JSP，一般与Tomcat/Jetty配合使用
          - 特点
            1. JMX微内核作为总线结构
            1. 面向服务架构(SOA，Service-Oriented Architecture)
            1. 具有统一的类装载器，实现应用热部署和热卸载能力
            1. 高度模块化和松耦合
            1. 支持集群
   - 提供的服务
     1. 事务
     1. 状态管理
     1. 多线程
     1. 资源池
     1. 其他底层细节
1. RMI
   - 理解：Java Remote method invocation，java方法远程调用，基于socket方式的远程调用，是java分布式的基础，将对象序列化在网络上传输
   - 原理：服务端编写interface和其实现，客户端远程调用
     1. 先定义RMI能够提供的服务，即interface，生成调用入口，编写实现类
     1. 编写RMI注册机制，并启动
     1. 客户端就可以访问了
1. Bean
   - 理解：是遵循了JavaBean技术规范的类或者称为可重用组件。遵循JavaBean技术规范的拥有getXxx、setXxx、isXxx、addXxxListener、XxxEvent等的类。JavaBean最初是为Java GUI的可视化编程实现的.你拖动IDE构建工具创建一个GUI 组件（如多选框）,其实是工具给你创建java类,并提供将类的属性暴露出来给你修改调整,将事件监听器暴露出来
   - 优点
     1. Bean可以控制它的属性、事件和方法是否暴露给其他程序
     1. Bean可以接收来自其他对象的事件，也可以产生事件给其他对象
   - 特点
     1. 必须为公共类，并且可序列化，即实现java.io.Serializable接口
     1. 若有构造参数，必须是无参的，类中不能出现main函数
     1. 所有属性必须通过public的get、set、isXxx方法来操作，并且是私有的
     1. 包含必要的事件处理方法
   - 组成
     1. 属性
        - Simple属性：具有setter、getter方法对的属性
        - Indexed属性：表示数据值，针对数据的simple属性
        - Bound属性：属性值发生变化时，会触发其他JavaBean
        - Constrained属性：属性值将要发生变化时，与该属性建立关系的其他java对象可以否决其改变
     1. 方法
     1. 事件：是事件发起者，也是接收者
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
1. POJO
   - 理解：实体类，简单java对象(Plain Old Java Objects)
   - 特点
     1. 编写应用程序类快速和简单
     1. 使用面向对象的角度写代码
1. Bean和EJB和POJO
   - 历史
     1. 在java1996年发布,当年12月即发布了java bean1.00-A,有什么用呢?通过统一的规范可以设置对象的值(get,set方法),这是最初的java bean;
     1. 在实际企业开发中,需要实现事务,安全,分布式,javabean就不好用了.sun公司就开始往上面堆功能,这里java bean就复杂为EJB;
     1. EJB功能强大,但是太重了.此时出现DI(依赖注入),AOP(面向切面)技术,通过简单的java bean也能完成EJB的事情,这里的java bean简化为POJO;
     1. Spring诞生了;
### Servlet
1. 认识：用Java写的一个服务器端小程序，是部署在web服务器上的组件，可以访问所有java API，可以搜集表单等浏览器的东西和创建动态网页，为创建基于web的java应用程序
1. 特点：Servlet应用无法独立运行，必须运行在Servlet容器中，Servlet在web服务器的地址空间执行，一个请求一个线程，性能好。独立于平台，安全性好。html的链接/开头的表示相对目录，没有的表示绝对目录
1. 编写
	```Java
	// 继承HttpServlet，类关系：自定义setvlet——HttpServlet类(实现了http协议)——GenericServlet类(与协议无关)——Servlet接口(方法：Init/service/destory)
	// 重写doGet()或者doPost()
	// 在web.xml中注册Servlet
	public class Xxx extends HttpServlet{
		@Override
		protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {}
		protected void doPost(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {}
		// 输出html
		PrintWriter out = response.getWriter();
		response.setContentType("text/html;charset=utf-8");
		out.println("<p>你好</p>";
	}
	<servlet>
		<servlet-name>Xxx</servlet-name>
		<servlet-class>com.package.Xxx</servlet-class>
	</servlet>
	<servlet-mapping> // 指向对应的servlet，即servlet-name要对应
		<servlet-name>Xxx</servlet-name>
		<url-pattern>/url</servlet-pattern> // 必须以/开头
	</servlet-mapping>
	```
1. 九大内置对象
   - Config：getServletConfig
   - application：getServletContext();整个web应用
   - session：request.getSession();
   - page：this
   - pageContext：pageContext
   - request
   - response
   - out：response.getWriter();
   - exception：Throwable
1. Servlet项目结构
   - src：源码目录
   - webapp：用于存放web资源，WEB-INF是java web应用固定的存放配置和类库的目录，是安全目录，只有服务端能访问
   - web.xml是配置文件，也叫部署描述符
1. Servlet的生命周期
   - init()
   - service()：服务器收到的每一个请求会创建新的线程并单一调用service()方法，service()方法检查请求类型，适当的调用doGet、doPost、doPut、doDelete等方法
   - doGet/doPost
   - destory()：只被调用一次
1. request和response
   - request：请求，javax.servlet.http.HttpServletRequest类的实例
     1. 方法
        - getParameter()：单个参数
        - getParameterValues()：多个参数
        - getParameterNames()：所有参数
     1. 例子
        ```Java
        // 获得单个参数
        String name =new String(request.getParameter("name").getBytes("ISO8859-1"),"UTF-8");
        // 获得多个参数        
        Enumeration paramNames = request.getParameterNames();
        while(paramNames.hasMoreElements()) {
            String paramName = (String)paramNames.nextElement();
            request.getParameterValues(paramName);
        }
        ```
     1. 方法补充
        - `Enumeration getHeaderNames()` // 返回所有头信息
        - `Cookie[] getCookies()` //
        - `HttpSession getSession()` // 获取session对话，无则创建
        - `Object getAttribute(String name)` // 以对象形式返回属性，无则null
        - `int getParameterMap()` // 以Map形式返回属性
        - `String getAuthType()` // 如SSL、BASIC，无则null
        - `String getMethod()` // GET、POST
        - `String getHeader(String name)` // 字符串形式的头信息
        - `String getQueryString()` // get参数
        - `int getContentLength()` // post的长度，字节为单位，未知为-1
        - `String getRemoteAddr()` // 获取请求者ip
   - response：响应，是javax.servlet.http.HttpServletResponse类的实例
     1. 方法
        - getWriter()
        - setContentType()
     1. 例子
        ```Java
        // 定义消息头部
        response.setContentType("text/html;charset=UTF-8");
        // 输出文字
        PrintWriter out = response.getWriter();
        out.println("<html></html>");
        // 重定向
        response.setStatus(response.SC\_MOVED_TEMPORARILY);
        response.setHeader("Location", site);
        ```
     1. 方法补充
         - `void setStatus(int sc)` // 设置状态码
         - `void addCookie(Cookie cookie)`
         - `void addHeader(String name, String value)`
         - `void setHeader(String name, String value)`
         - `void setContentLength(int len)` // 
         - `void setBufferSize(int size)` // 为响应主体设置首选缓冲大小
         - `void flushBuffer()` // 缓冲写入客户端
         - `void resetBuffer()` // 清除缓冲区内容，不清除状态码和头
         - `void reset()` // 都清除
         - `public void setStatus(int statusCode)`
         - `public void sendError(int code, String message)` // 会出现tomcat原生的错误页面
         - `public void sendRedirect(String url)` // 302跳转，带一个location头
1. Cookie
   - 设置cookie
     ```Java
     Cookie cookie = new Cookie("key","value"); // 不能包含特殊字符
     cookie.setMaxAge(60\*60*24);
     response.addCookie(cookie);
     ```
   - 获取cookie
      ```Java
      Cookie cookies = request.getCookies();
      for (int i = 0; i < cookies.length; i++){
        cookie = cookies[i];
        cookie.getName();
        cookie.getValue();
      }
      ```
   - 删除cookie：设置有效期为0，然后加到头部
      ```Java
      Cookie cookies = request.getCookies();
      for (int i = 0; i < cookies.length; i++){
        cookie = cookies[i];
        cookie.setMaxAge(0);
        response.addCookie(cookie);
      }
      ```
   - 方法
     1. `public String getName()` // 返回cookie的名称
     1. `public String getValue()`
     1. `public void setValue(String newValue)`
     1. `public void setPath(String uri)` // cookie的路径，路径不同不能访问
     1. `public void getDomain()/setDomain(String pattern)` // cookie的域
     1. `public void getMaxAge()/setMaxAge(int expiry)`
     1. `public void setSecure()/getComment()/setComment(String purpose)`
1. Session
   - 使用：HttpSession对象
     ```Java
     // 创建
     HttpSession session = request.getSession(true); // 无则创建
     // 删除
     session.invalidate();
     session.setMaxInactiveInterval(0);
     ```
   - 方法
     1. `public void setMaxInactiveInterval(int interval)/getMaxInactiveInterval()`
     1. `public void setAttribute(String name, Object value)/`
     1. `public Object getAttribute(String name)`
     1. `public Enumeration getAttributeNames()` // 返回名称集
     1. `public void removeAttribute(String name)`
     1. `public String getId()` // 返回唯一标识符
     1. `public long getCreationTime()`
     1. `public long getLastAccessedTime()`
     1. `public boolean isNew()` // 客户端没传回session，为true
     1. `public void invalidate()` // 删除session
   - web.xml配置过期时间，单位分钟
     ```Java
     <session-config>
        <session-timeout>15</session-timeout>
     </session-config>
     ```
1. 过滤器
   - 理解：对请求或者响应动作之前进行拦截
   - 特点：能改变用户请求的路径，不能改变返回数据
   - 生命周期
     1. web.xml：实例化一次
	 1. init：初始化
	 1. 开始过滤：doFilter();
	 1. 销毁：destory();
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
          <dispatcher></dispatcher> // 过滤类型请求，dispatcher：REQUEST、INCLUDE、FORWARD、ERROR，默认REQUEST
        </filter-mapping>
        ```
     1. 过滤器类
		```Java
		public class LogFilter implements Filter{
			public void  init(FilterConfig config) throws ServletException {
				// 运行流程为web应用程序启动——web服务器创建Filter实例对象——调用init——读取web.xml——完成对象的初始化
				// 获取初始化参数
				String site = config.getInitParameter("Site");
			}
			public void  doFilter(ServletRequest request, ServletResponse response, FilterChain chain) throws java.io.IOException, ServletException {
				// 完成具体的过滤操作，FilterChain指出后续过滤器
				chain.doFilter(request,response); // 把请求传回过滤链
			}
			public void destroy( ){
				// 在Filter实例被 Web容器从服务移除之前调用
			}
		}
		```
   - 过滤器链：按照web.xml中定义的顺序，filter1请求传回过滤链前->filter2请求传回过滤链前->service->filter1请求传回过滤链后->filter2请求传回过滤链后
   - 分类
     1. Servlet2.5
	    - REQUEST：用户直接访问页面时调用
		- FORWARD：转发时调用，即通过RequestDispatcher的forward访问
		- INCLUDE：被包含的请求时调用，即通过RequestDispatcher的include访问		
		- ERROR：通过声明式异常处理机制时调用
	 1. Servlet3.0
	    - ASYNC：支持异步处理，即先返回结果，后台一直执行直到结束
		```Java
		AsyncContext context = request.startAsync(); // 在doGet方法中，同时开启web.xml和Filter类的异步开关
		```
        - @WebFilter注解将一个类声明为过滤器
1. 监听器
   - 理解：针对其他对象发生的事件/状态改变，进行监听和处理的对象。是servlet规范定义的一种特殊类，用于监听ServletContext/HttpSession/ServletRequest域对象的创建/销毁/属性修改的事件，可以在事件发生前、发生后做出相应
   - 特点
     1. 启动顺序为web.xml中定义的顺序
	 1. 优先级：监听器->过滤器->Servlet
   - 分类
     1. 按照监听对象
	    - ServletContext：应用程序环境对象
		- HttpSession：用户会话对象
		- ServletRequest：请求消息对象
     1. 按照监听的事件
	    - 域对象的创建/销毁
		- 域对象的属性增加/删除
		- 绑定到HttpSession域中的某个对象的状态
   - 创建
    ```Java
    // 创建实现监听器接口的类
    // 针对ServletContext	
    // TODO 其余两种监听类
    public class XxxListener implements ServletContextListener{
      public void contextInitialized(ServletContextEvent servletcontextecent) {}
      public void contextDestoryed(ServletContextEvent servletcontextecent) {}
    }
    // 在web.xml注册
    <listener>
      <listener-class>com.package.XxxListener</listener-class>
    </listener>
    ```
1. 异常：web.xml匹配异常类型
   - 使用：error-page元素决定，状态码或者异常
   - 错误相关的属性
     1. status_code：`Integer`，即`java.lang.Integer`
     1. exception_type：`Class`，异常类型
     1. message：`String`
     1. request_uri：`String`
     1. exception：`Throwable`
     1. servlet_name：`String`
   - 使用
        ```XML
        // 全部
        <error-page>
            <error-code>403</error-code>
            <location>/ErrorHandler</location>
        </error-page>
        <error-page>
            <exception-type>
                javax.servlet.ServletException/java.io.IOException/java.lang.Throwable(全部)
            </exception-type >
            <location>/ErrorHandler</location>
        </error-page>
        ```
1. 国际化
   - 概念
     1. i18n：国际化      
     1. l10n：本地化
     1. locale：区域设置，如en_US
   - 使用：Locale对象提供
   - 中文处理
     ```Java
     String str = java.net.URLEncoder.encode("中文"，"UTF-8");
     String str = java.net.URLDecoder.decode("编码后的字符串","UTF-8");
     ```
   - 方法
     1. `String getCountry()` // 两个大写字母形式的ISO 3166格式国家代码
     1. `String getDisplayCountry()` // 国家名称
     1. `String getLanguage()` // 小写字母的 ISO 639格式语言代码
     1. `String getDisplayLanguage()` // 语言名称
     1. `String getISO3Country()` // 国家的3个字母缩写
     1. `String getISO3Language()` // 语言的3个字母缩写
1. 文件上传和下载
   - 上传
      ```Java
      // 检测是否为多媒体上传
      if (!ServletFileUpload.isMultipartContent(request)) {
          // 如果不是则停止
          PrintWriter writer = response.getWriter();
          writer.println("Error: 表单必须包含 enctype=multipart/form-data");
          writer.flush();
          return;
      }
      // 上传配置
      private static final String UPLOAD_DIRECTORY = "upload";      
      private static final int MEMORY_THRESHOLD     = 1024 * 1024 * 3;  // 3MB
      private static final int MAX\_FILE\_SIZE      = 1024 * 1024 * 40; // 40MB
      private static final int MAX\_REQUEST\_SIZE   = 1024 * 1024 * 50; // 50MB
      // 存储目录
      String uploadPath = request.getServletContext().getRealPath("./") + File.separator + UPLOAD_DIRECTORY;
      // 如果目录不存在则创建
      File uploadDir = new File(uploadPath);
      if (!uploadDir.exists()) {
          uploadDir.mkdir();
      }
      // 设置内存临界值 - 超过后将产生临时文件并存储于临时目录中
      DiskFileItemFactory factory = new DiskFileItemFactory();
      factory.setSizeThreshold(MEMORY_THRESHOLD);
      factory.setRepository(new File(System.getProperty("java.io.tmpdir"))); 
      // 上传类
      ServletFileUpload upload = new ServletFileUpload(factory);
      upload.setFileSizeMax(MAX\_FILE_SIZE); // 设置最大文件上传值
      upload.setSizeMax(MAX\_REQUEST_SIZE); // 设置最大请求值 (包含文件和表单数据)
      upload.setHeaderEncoding("UTF-8"); // 中文处理
      try {
            // 解析请求的内容提取文件数据
            @SuppressWarnings("unchecked")
            List<FileItem> formItems = upload.parseRequest(request);
            if (formItems != null && formItems.size() > 0) {
                // 迭代表单数据
                for (FileItem item : formItems) {
                    // 处理不在表单中的字段
                    if (!item.isFormField()) {
                        // 提取文件
                        String fileName = new File(item.getName()).getName();
                        String filePath = uploadPath + File.separator + fileName;
                        File storeFile = new File(filePath);
                        // 保存文件到硬盘
                        item.write(storeFile);
                        request.setAttribute("message", "文件上传成功!");
                    }
                }
            }
        } catch (Exception ex) {
            request.setAttribute("message", "错误信息: " + ex.getMessage());
        }
      ```
   - 下载
      ```Java
      // 获取文件名
      String filename = request.getParameter("name");
      filename = new String(filename.getBytes("iso-8859-1"),"utf-8");
      // 设置文件MIME类型  
      response.setContentType(getServletContext().getMimeType(filename));  
      // 设置Content-Disposition  
      response.setHeader("Content-Disposition", "attachment;filename="+filename);
      // 文件绝对路径
      ServletContext context = this.getServletContext();
      String fullFileName = context.getRealPath("/download/"+filename);
      //输入流为项目文件，输出流指向浏览器
      InputStream is=new FileInputStream(fullFileName);
      ServletOutputStream os =response.getOutputStream();
      int len=-1;
      byte[] b=new byte[1024];
      while((len=is.read(b))!=-1){
          os.write(b,0,len);
      }
      //关闭流
      is.close();
      os.close();
      ```
1. 实际使用
   - 调试：`System.out.println()`，输出的信息会记录在web服务器日志里
   - 跳转
	```Java
	// /表示根目录
	response.sendRedirect(request.getContextPath + "/要跳转的页面相对地址"); // 重定向，地址改变
	request.getRequestDispatcher("/要跳转的页面相对地址").forward(request, response); // 转发请求，地址不变
	```
### JSP
1. 理解：`Java Server Pages` 是简化的servlet设计，在html中插入java代码(Scriptlet)和jsp标记(tag)，实现了html中的Java扩展(通常用<% %>包裹)。是动态生成web网页的一种标准
1. 特点
   - jsp已经是编译好的，不需要预先载入解释器和目标脚本
   - 与纯Servlet比较，方便编写html，而不用大量的println来一句一句的输出，servlet是老的cgi的方式
   - 基于Java API
1. 组成
   - 指令：用`<%!@%>`表示
     1. `<%@ page name="value" %>`：声明页面属性
        - 属性
           1. `language` 指定页面的脚本语言，默认java
           1. `import` 指定使用的类
           1. `contentType` MIME和字符编码
           1. `extends` 指定Servlet继承
           1. `info` 页面的描述信息
           1. `session` 是否使用session
           1. `errorPage` 发生错误转向的错误页面
           1. `isErrorPage` 表示本页面是否可作为错误页面
           1. `buffer` out对象使用缓冲区的大小
           1. `autoFlush` 控制out对象的缓冲区
           1. `isELIgnored` 是否执行EL表达式
           1. `isScriptingEnabled` 脚本元素是否能被使用
           1. `isThreadSafe` 指定对页面的访问是否为线程安全
        - 举例：`<%@ page language="java" import="java.util.*" contentType="text/html; charset="utf-8"%>`
     1. `<%@ include file="" %>` 包含其他文件，如jsp、html、文本文件。<%@ include等价于jsp:directive.include
     1. `<%@ taglib uri="" prefix="" %>` 引入标签库或者自定义标签
   - 声明：JSP页面定义变量或方法，用`<%!%>`表示，或者`<jsp:declaration></jsp:declaration>`
   - 表达式：用来直接输出结果的简便方式，用`<%=%>`表示，不以分号结束，和`out.println()`相同。或者`<jsp:expression></jsp:expression>`
     1. 举例
        ```java
        <%!
        String s = "你好";
        %>
        <%=s %>
        ```
   - 脚本：JSP页面执行的java代码，用`<%%>`表示，或者`<jsp:scriptlet></jsp:scriptlet>`
     1. if判断
        ```Java
        <% if (day == 1 | day == 7) { %>
        <% } else { %>
        <% } %>
        ```
     1. switch
         ```Java
         <%
         switch(day) {
           case 0:
             break;
           default:
         }
         %>
         ```
      1. for循环
          ```Java
          <%for ( i = 1; data <= 3; i++){ %>
          <%}%>
          ```
   - 注释
     1. `<%----%>`：JSP注释，不会被编译
     1. `<!---->`：HTML注释
     1. `//和/**/`：脚本注释
1. 内置对象
   - 理解：是Web容器创建的一组对象，可以不new直接使用的内置对象
   - 组成
     1. `request` HttpServletRequest类的实例
     1. `response` HttpServletResponse类的实例
     1. `out` PrintWriter类的实例，用于输出结果
        - 缓冲区：Buffer，内存的一块区域用来保存临时的数据，用于加速数据输出，好比一颗颗和一碗碗吃米饭
        - 方法
          1. println：向客户端打印，`out.println("你好");`
          1. getBufferSize：缓冲区字节数
          1. flush：将缓冲区内容输出到客户端
          1. clear：清除缓冲区内容，flush之后调用会抛异常
          1. clearBuffer：清除缓冲区内容，flush之后调用不会抛异常
          1. close：关闭缓冲区
     1. `session` HttpSession类的实例
     1. `application` ServletContext类的实例，与应用上下文有关
     1. `page` 类似this关键字，整个页面的代表
     1. `pageContext` PageContext类的实例，提供对JSP页面所有对象和命名空间的访问
        - 理解：包含request/response/application/config/session/out对象，也包含指令信息，如缓冲信息/页面scop/错误页面地址，还有一些字段：PAGE\_SCOPE/REQUEST\_SCOPE/SESSION_SCOPE等
     1. `exception` Exception类的对象，代表JSP页面中的异常对象
     1. `config` ServletConfig类的实例
   - 作用域范围
1. 行为：使用XML动态插入文件/Html、重用JavaBean组件等
   - 形式：<\jsp:action_name attribute="value" />
   - 属性
     1. id：行为元素的唯一标识，通过PageContext调用
     1. scope：识别行为元素的生命周期，四个值：page、request、session、application
   - 组成
     1. 创建XML元素
        - 标签
          1. `jsp:element`：动态创建XML元素
          1. `jsp:attribute`：定义XML元素的属性
          1. `jsp:body`：定义XML元素的主体
        - 使用
            ```Java
            <jsp:element name="xmlElement">
                <jsp:attribute name="xmlElementAttr">
                </jsp:attribute>
                <jsp:body>
                </jsp:body>
            </jsp:element>
            ```
     1. 使用JavaBean
        - 标签     
          1. `jsp:useBean`：使用JavaBean组件，java组件重用
          1. `jsp:getProperty/setProperty`：JavaBean组件的值
        - 属性
          1. `name` // 指定适用的Bean
          1. `property` // 属性名
          1. `value` // 属性值
          1. `param` // 默认值
        - 使用
            ```Java
            <jsp:useBean id="" >
                <jsp:setProperty name="" property=""/>
                <jsp:getProperty name="" property=""/>
            </jsp:useBean>
            ```
     1. 引入页面
        - 使用：`<jsp:include page="" flush="true" />`，flush表示引入前是否刷新缓冲区
        - 使用：`jsp:plugin`：用于包含Applet和JavaBean对象
            ```Java
            <jsp:plugin type="applet" codebase="dirname" code="MyApplet.class" width="60" height="80">
                <jsp:param name="fontcolor" value="red" />
                <jsp:param name="background" value="black" />
                <jsp:fallback></jsp:fallback>
            </jsp:plugin>
            ```
     1. 跳转：向另一个文件传递request对象。`<jsp:forward page="" />`
     1. 文本模板：`jsp:text`
        - 理解：只能包含文本和EL表达式
1. EL
   - 理解：Expression Language，即表达式语言，可使用各种类型的数据来创建算术/逻辑表达式
   - 基础操作符
     1. `.` // 访问一个bean属性或者映射条目
     1. `[]` // 数组或者链表的元素
     1. `+-*/%` // 加减乘除取余
     1. `==!=><` // 各种等于不等于
     1. `&&||!` // 与或非
     1. `empty` // 是否为空
   - EL中的函数：${ns:func(param1, param2)}，这些函数必须被定义在自定义标签库中
   - 举例
     ```Java
     <%@ page isELIgnored ="true|false" %>
     ${2*box.width+2*box.height}
     ```
1. JSTL
   - 理解：JSP Standard Tag Library，即JSP标准标签库，封装了JSP应用的通用核心功能。支持迭代、判断、xml操作、sql标签、自定义标签
   - 分类
     1. 核心标签
     1. 格式化标签
     1. sql标签
     1. xml标签
     1. JSTL函数
   - 安装：将官方jar包放到`/WEB-INF/lib/`下，web.xml添加配置
     ```XML
     <jsp-config>
       <taglib>
         <taglib-uri>http://java.sun.com/jstl/fmt</taglib-uri>
         <taglib-location>/WEB-INF/fmt.tld</taglib-location>
       </taglib>
     </jsp-config>
     ```
   - 使用
     1. 核心标签：先引用`<%@ taglib prefix="c" uri="http://java.sun.com/jsp/jstl/core" %>`
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
1. 自定义标签
   - 方法
     1. 创建自定义标签类
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
1. 处理xml文档
   - 发送xml：修改页面头`<%@ page contentType="text/xml" %>`
   - 展示xml
      ```Java
      <c:import var="bookInfo" url="http://localhost:8080/books.xml"/> // 载入xml文档
      <x:parse xml="${bookInfo}" var="output"/>
      <x:out select="$output/books/book[1]/name" />
      ```
1. 生命周期
   - 编译阶段：解析jsp转成Servlet，编译Servlet文件，生成servlet类
   - 初始化阶段：加载Servlet类，创建实例，调用初始化方法——jspInit()
   - 执行阶段：_jspService(HttpServletRequest request,HttpServletResponse response)
   - 销毁阶段:jspDestroy()