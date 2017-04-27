### Servlet
1. 认识：为创建基于web的java应用程序，可以访问所有java API。是运行在web服务器上的，作为来自http请求和数据库之间的中间层。可以搜集表单等浏览器的东西和创建动态网页
1. 特点：Servlet在web服务器的地址空间执行，不会一个客户端一个进程，性能好。独立于平台，安全性好
1. Servlet项目结构
   - src：源码目录
   - web：用于存放web资源，WEB-INF是java web应用固定的存放配置和类库的目录，web.xml是配置文件，也叫部署描述符
   - xx.iml是IntelliJ的项目文件
1. Servlet的生命周期
   - init()
   - service()：Servlet容器即web浏览器，服务器收到的每一个请求会创建新的线程并单一调用service()方法，service()方法检查请求类型，适当的调用doGet、doPost、doPut、doDelete等方法
   - doGet、doPost
   - destory()：只被调用一次
1. 参数
   - request：请求
     1. 方法
        ```Java
        getParameter()：单个参数
        getParameterValues()：多个参数
        getParameterNames()：所有参数
        ```
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
      1. 请求方法补充
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
   - response：响应
     1. 方法
        ```Java
        setContentType()
        getWriter()        
        ```
     1. 例子
        ```Java
        // 定义消息头部
        response.setContentType("text/html;charset=UTF-8");
        // 输出文字
        PrintWriter out = response.getWriter();
        out.println("<html>");
        out.println("</html>");
        ```
     1. 响应方法补充
         - `void setStatus(int sc)` // 设置状态码
         - `void addCookie(Cookie cookie)`
         - `void addHeader(String name, String value)`
         - `void setHeader(String name, String value)`
         - `void setContentLength(int len)` // 
         - `void setBufferSize(int size)` // 为响应主体设置首选缓冲大小
         - `void flushBuffer()` // 缓冲写入客户端
         - `void resetBuffer()` // 清除缓冲区内容，不清除状态码和头
         - `void reset()` // 都清除
      1. 状态码：发送错误码，会出现tomcat原生的错误页面
         - `public void setStatus(int statusCode)`
         - `public void sendError(int code, String message)`
         - `public void sendRedirect(String url)` // 302，带一个location头
      1. 重定向
          ```Java
          response.setStatus(response.SC\_MOVED_TEMPORARILY);
          response.setHeader("Location", site);
          ```
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
   - 中文处理
     ```Java
     String str = java.net.URLEncoder.encode("中文"，"UTF-8");
     String str = java.net.URLDecoder.decode("编码后的字符串","UTF-8");
     ```
   - 方法
     1. `public String getName()` // 返回cookie的名称
     1. `public String getValue()`
     1. `public void setValue(String newValue)`
     1. `public void setPath(String uri)` // cookie的路径，路径不同不能访问
     1. `public void getDomain()/setDomain(String pattern)` // cookie的域
     1. `public void getMaxAge()/setMaxAge(int expiry)`
     1. `public void setSecure()/getComment()/setComment(String purpose)` // 
1. Session
   - 使用：HttpSession对象
     ```Java
     // 创建
     HttpSession session = request.getSession(true); // 无则创建
     // 删除：invalidate()/setMaxInactiveInterval(0)/logout
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
   - jsp页面
      ```Java
      <body>
          <center>
              <h2>${message}</h2>
          </center>
      </body>
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
1. 过滤器
   - 理解：对请求或者响应动作之前进行动态拦截、改变数据。就是在web.xml中定义访问请求和过滤类的对应关系，在访问时起作用
   - 特点：n个过滤器对应；都在之前，即请求拦截，响应处理
   - 分类
     1. 身份验证：Authentication Filters
     1. 数据压缩：Data compression Filters
     1. 加密：Encryption Filters
     1. 图像转换：Image Conversion Filters
     1. 日志记录和审核：Logging and Auditing Filters
     1. 资源访问事件
     1. MIME-TYPE链：MIME-TYPE Chain Filters
     1. 标计划：Tokenizing Filters
     1. XSL/T：XSL/T Filters，转换XML内容
   - 使用：在web.xml中的声明标签，然后映射到Servlet或Url
     1. web.xml
        - filter：表示一个过滤器，可以用于多个Servlet、Servlet组、jsp、html
        - filter-mapping：表示过滤器的绑定范围
        - filter-mapping：决定过滤器使用范围
        - dispatcher：REQUEST、INCLUDE、FORWARD、ERROR
   - 方法：实现了 javax.servlet.Filter类
     1. `public void doFilter (ServletRequest, ServletResponse, FilterChain)` // 具体的过滤操作在这，请求或响应符合标签声明时，访问这个方法，FilterChain指出后续过滤器
     1. `public void init(FilterConfig filterConfig)` // web应用程序启动——web服务器创建Filter实例对象——调用init——读取web.xml——完成对象的初始化
     1. `public void destroy()` // 析构方法
   - 实例
     1. web.xml配置
        ```XML
        // filter-class：指定使用的过滤类
        // init-param：FilterConfig对象的初始化参数，可在init中获取
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
          </filter-mapping>
        ```
     1. 过滤器类
        ```Java
        import javax.servlet.*;
        import java.util.*;

        public class LogFilter implements Filter{
          public void  init(FilterConfig config) throws ServletException {
            // 获取初始化参数
            String site = config.getInitParameter("Site"); 
            System.out.println("网站名称: " + site); 
          }
          public void  doFilter(ServletRequest request, ServletResponse response, FilterChain chain) throws java.io.IOException, ServletException {
            
            chain.doFilter(request,response); // 把请求传回过滤链
          }
          public void destroy( ){
            /* 在 Filter 实例被 Web 容器从服务移除之前调用 */
          }
        }
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
     1. web.xml
        ```XML
        // 全部
        <error-page>
            <error-code>403</error-code> // 或者
            <location>/ErrorHandler</location>
        </error-page>
        <error-page>
            <exception-type>
              javax.servlet.ServletException/java.io.IOException/java.lang.Throwable(全部)
            </exception-type >
            <location>/ErrorHandler</location>
        </error-page>
        ```
1. 调试：`System.out.println()`，输出的信息会记录在web服务器日志里
1. 国际化
   - 概念
     1. i18n：国际化      
     1. l10n：本地化
     1. locale：区域设置，如en_US
   - 使用：Locale对象提供
   - 方法
     1. `String getCountry()` // 两个大写字母形式的ISO 3166格式国家代码
     1. `String getDisplayCountry()` // 国家名称
     1. `String getLanguage()` // 小写字母的 ISO 639格式语言代码
     1. `String getDisplayLanguage()` // 语言名称
     1. `String getISO3Country()` // 国家的3个字母缩写
     1. `String getISO3Language()` // 语言的3个字母缩写

### JSP
1. 理解：`Java Server Pages` 动态生成html、xml的web网页的标准。为java提供接口服务于http，跨平台。使用JSP标签在html中插入java代码，通常<% %>包裹。主要用于实现界面
1. 特点
   - jsp已经是编译好的，不需要预先载入解释器和目标脚本
   - JSP基于Java API
   - 与纯Servlet比较，方便编写html，而不用大量的println
1. 实例
      ```Java
      <body>
        <%
          out.println("Hello World！");
        %>
      </body>
      ```
1. 生命周期
   - 编译阶段：解析jsp转成Servlet，编译Servlet文件，生成servlet类
   - 初始化阶段：加载Servlet类，创建实例，调用初始化方法——jspInit()
   - 执行阶段：调用Servlet服务方法：_jspService(HttpServletRequest request,HttpServletResponse response)
   - 销毁阶段：销毁Servlet实例:jspDestroy()
   - 实例
      ```Java
      <body>
      <h1>666</h1>
      <%!
        public void jspInit(){}
        public void jspDestroy(){}
      %>
      <%
        System.out.println(request.getRemoteAddr());
      %>
      </body>
      ```
1. 语法
   - 脚本程序
     1. `<% 代码片段 %>`
     1. `<jsp:scriptlet>代码片段</jsp:scriptlet>`
   - 声明变量/方法
     1. `<%! declaration; [ declaration; ] +... %>`
     1. `<jsp:declaration>代码片段</jsp:declaration>`
   - 表达式