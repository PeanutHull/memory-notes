###Servlet
1. 认识：为创建基于web的java应用程序，可以访问所有java API。是运行在web服务器上的，作为来自http请求和数据库之间的中间层。可以搜集表单等浏览器的东西和创建动态网页
1. 特点：Servlet在web服务器的地址空间执行，不会一个客户端一个进程，性能好。独立于平台，安全性好
1. Servlet项目结构
   - src：源码目录
   - web：用于存放web资源，WEB-INF是java web应用固定的存放配置和类库的目录，web.xml是配置文件
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