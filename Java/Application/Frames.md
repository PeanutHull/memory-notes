### MVC
1. Controller：和Model层通过JavaBean交流数据
1. Model
   - DAO：即数据模型，不处理业务逻辑，只为业务层提供辅助，完成获取原始数据或持久层数据等。被Service层调取执行数据操作，逻辑在service层写
   - Pojo：原始的数据Bean
### Strut 2
1. 理解：最初理解为WebWork 2。是一个应用程序框架，是1.X版本的完全重写版。目的是更容易开发web程序
1. 功能
   - POJO 表单和 POJO 动作：处理表单
   - 标签支持：包括ajax标签功能
   - 视图技术：支持多个视图选项JSP，Freemarker，Velocity和XSLT
1. 特点
   - MVC：控制器调度servlet过滤器和拦截器实现，值栈和OGNL提供共同主线，连接和集成其他组件
   - 易于整合
   - 模板支持
   - 插件支持
1. 架构
   - 动作
   - 拦截器
   - 值栈/OGNL
   - 结果/结果类型
   - 视图技术
1. 流程
   - 接收请求，路由指向适当的动作
   - 前置拦截器，做验证等
   - 执行动作
   - 后置拦截器启动
   - 返回视图
1. 使用
   1. 配置文件：连接动作、视图、控制器的配置文件，如struts.xml，web.xml，struts.properties
      - web.xml：配置路由指向strut2框架处理
        ```Java
        <filter>
            <filter-name>struts2</filter-name>
            <filter-class>org.apache.struts2.dispatcher.FilterDispatcher</filter-class>
        </filter>
        <filter-mapping>
            <filter-name>struts2</filter-name>
            <url-pattern>/*</url-pattern>
        </filter-mapping>
        ```
      - struts.xml：配置具体的动作和路由映射
        ```Java
        <action name="路由名" class="指向的动作" method="execute">
            <result name="success">显示的视图</result>
        </action>
        ```
   1. 拦截器
      - 功能
        1. 动作之前调用
        1. 动作之后调用
        1. 捕获异常，以便执行交替处理
      - 部分方法
        - alias：别名
        - i18n：跟踪选定的语言
        - params：设置动作的参数
        - validation：验证支持
      - 实例
        ```Java
        <action name="hello" 
         class="com.tutorialspoint.Struts 2.HelloWorldAction" 
         method="execute">
            <interceptor-ref name="params"/> // 拦截器
            <interceptor-ref name="myinterceptor" /> // 拦截器
            <result name="success">/HelloWorld.jsp</result>
        </action>
        ```
   1. 视图和结果
      - 结果
        1. 返回不用的结果，如XML何JSON，默认结果类型dispatcher。兼容多种标记语言，如Velocity，Freemaker，XSLT和Tiles
        ```Java
        // 使用FreeMarker模板引擎输出
        <result name="success" type="freemarker">
            <param name="location">/hello.fm</param>
         </result>
        // 重定向
        <result name="success" type="redirect">
            <param name="location">/xxx.jsp</param >
        </result>
        ```
1. 标签
   - 控制标签
     1. if：`<s:if test="%{false}"></s:else>`
     1. iterator：迭代标签
        ```Java
        <s:iterator value="days">
            <s:property/>
        </s:iterator>
        ```
     1. merge：融合标签
        ```Java
        <s:append var="myAppendIterator">
            <s:param value="%{myList1}" />
            <s:param value="%{myList2}" />
        </s:append>
        ```
     1. append ：附加标签
        ```Java
        <s:merge var="myMergedIterator">
            <s:param value="%{myList1}" />
            <s:param value="%{myList2}" />
        </s:merge>
        ```
     1. generator：生成器标签
        ```Java
        <s:generator val="%{'aaa,bbb,ccc,ddd,eee'}">
            <s:iterator>
                <s:property /><br/>
            </s:iterator>
        </s:generator>
        ```
   - 数据标签
     1. property ：属性标签，`<s:property value="" default="" />`
     1. set ：属性标签，`<s:set name="" value=""/>`
     1. push：向栈中push
        ```Java
        <s:push value="user">
            <s:propery value="firstName" />
        </s:push>
        ```
     1. i18n/test：文本，`<s:text/i18n name="main.title"/>`
     1. date：日期，`<s:date name="person.birthday" format="dd/MM/yyyy" />`
     1. url：`<s:url value="">`
     1. ui：参数标签
        ```Java
        <ui:component>
            <ui:param name="key"     value="[0]"/>
        </ui:component>
        ```
     1. include：包含另一个jsp
        ```Java
        <s:include value="myJsp.jsp">
            <s:param name="param1" value="value2" />
        </s:include>
        ```
     1. bean
        ```Java
        <s:bean name="org.apache.struts2.util.Counter" var="counter">
            <s:param name="first" value="20"/>
        </s:bean>
        ```
   - 表单标签
     1. `<s:form action="">`
     1. `<s:radio label="" name="" list="{'',''}" />`
     1. `<s:select label="" name="" value="%{''}" list="%{#{'':''}}">`
### Spring
1. 认识：用于构建轻量级/健壮的J2EE应用程序、解决开发的复杂性，是全栈的容器类框架
1. 特点
   1. IoC分层架构，灵活选用组件，方便集成各种框架，简化开发
   1. AOP支持，面向方面编程
   1. 声明式事务支持
   1. 使用pojo编程模型
1. 组成
   - 组件
     1. Spring Core：主要组件BeanFactory，使用IOC将配置、依赖规范和应用程序分开
     1. Spring AOP：通过配置管理特性，AOP模块为其他应用提供事务管理服务，不用依赖EJB组件，就可集成声明性事务管理
     1. Spring Context：Spring的上下文是个配置文件，包括企业服务，有JNDI、EJB、mail、i18n、校验
     1. Spring ORM：插入了很多ORM框架，如JDO、Hibernate、iBatis，都遵从Spring的通用事务和DAO异常结构
     1. Spring DAO：提供异常层次结构，来管理异常和不同数据库的错误信息，简化了错误处理，
     1. Spring Web：为基于Web的应用程度提供上下文，支持与Struts的集成，简化了参数绑定到对象的工作
     1. Spring Web MVC：是全功能构建Web的MVC框架，包括了JSP、Velocity等
1. IoC：控制反转，Inversion of Control
   - 理解：将类之间的依赖从代码中脱离出来，用配置的方式描述，由IOC容器负责依赖类之间的管理。和AOP组成spring的核心/基础。Context模块构建于核心模块之上，添加i18n、Bean生命周期控制、框架事件体系、资源加载透明化等功能。BeanFactory是核心接口
   - 设计思想：用DI(Dependency Injection)依赖注入的概念来代替IoC而便于理解，让调用类对某接口实现类(被依赖类)的依赖关系由第三方(容器或者协作类)注入，以移除调用类对某接口实现类的直接依赖。角色有调用类(主体逻辑实现类)，接口实现类(被依赖类)，第三方装配类(将前二者组合起来)
   - IoC分类
     1. 构造函数注入：通过构造函数将接口实现类当做变量注入，适用于调用类全局依赖接口实现类
     1. 属性注入：用setter方法在需要时才注入
     1. 接口注入：调用类实现一个接口，在接口方法中注入接口实现类，绕了，跟属性注入方式一样，还多了个调用类接口
   - 实现原理：反射是实现依赖注入的基础，第三方装配类将决定依赖的关系交给用户，由用户定义
   - Spring基础接口：
   - Bean生命周期：
   - 使用
     1. 基于XML的装配方式
     1. 基于Java Configuration的装配方式
     1. 自动装配
     1. 多种装配方式的混用
     1. 处理装配的歧义
     1. 如何注入属性值
1. AOP
   - 切面、目标对象、切点、通知、织入等基本概念，横切逻辑编程，整合了AspectJAOP语言级的框架，
   - 如何定义切点：定义切点的aspectJ语法
   - 定义通知
     1. 前置通知（Before)
     1. 后置通知（AfterReturning）
     1. 异常通知（AfterThrowing）
     1. 最终通知（After）
     1. 环绕通知（Around）
     1. 如何给切面传参
1. Spring Bean 的作用域
   - Singleton
   - Prototype
   - Request
   - Session
   - Global
1. Spring MVC
   - 注解
     1. @Controller：负责处理由DispatcherServlet分发的请求，并返回一个数据模型Model。搭配完成请求。依赖spring的发现，方法有两种
        ```java
        <!--方式一-->
        <bean class="com.host.app.web.controller.MyController"/>
        <!--方式二-->
        < context:component-scan base-package = "com.host.app.web"/>
        ```
     1. @RequestMapping
        - 理解：处理请求地址的映射，用于类上表示类中所有的父路径，用于方法表示子路径
        - 属性
          1. value：请求的实际地址，地址可以是URI Template
          1. method：GET、POST、PUT、DELETE等
          1. consumes：指定处理请求的提交内容类型(Content-Type)，如application/json
          1. produces：指定返回的内容类型，仅当请求头的Accept包含该类型才返回
          1. params：指定必须存在的参数值
          1. headers：指定必须存在的header值
     1. @ResponseBody：通过适当的HttpMessageConverter转换为指定格式后，写入到Response对象的body数据区，不用于返回html的情况，用于json/xml情况
     1. @RestController：避免重复写RequestMapping和ResponseBody
     1. @ModelAttribute：该Controller所有方法调用前先执行ModelAttribute指定的方法
     1. @SessionAttributes：写入session值，用于类
     1. @Resource和@Autowired
        - 理解：用于bean的注入，都可以写在字段和setter方法上，如果写在字段上，不需要写setter方法
        ```java
        <!--二者选其一-->
        @Autowired/Resource
        private UserDao userDao; // 用于字段
        @Autowired/Resource
        public void setUserDao(UserDao userDao) { // 用于setter方法
            this.userDao = userDao;
        }
        ```
        - 不同点
          1. Autowired默认按照类型注入，如果允许null值，设置required属性为false。按照名称注入要加`@Qualifier("userDao")`注解
          1. Resource默认按照名称注入，由J2EE提供，需导入javax.annotation.Resource。属性有name和type，分别指定则使用不同注入方法，都不指定使用反射按照名称注入
     1. @HttpEntity：用于标注访问请求和响应头
     1. @requestParam：获得请求参数，属性有defaultValue/required/value
        ```java
        public ServerResponse add(HttpSession session, @RequestParam(value = "parentId", defaultValue = "0") int parentId) {}
        ```
     1. @PathVariable：取出uri模板中的变量作为参数
        ```java
        @RequestMapping(value="/user/{userId}", method = RequestMethod.GET)  
        public String getLogin(@PathVariable("userId") String userId){}
        ```
     1. @Service：标注一个业务逻辑组件类
     1. @Repository：用于dao层，在impl上使用
     1. @Component：通用注解，用于无法确定类属于的层，不建议使用
1. 使用
   - 业务分层
     1. 持久层：JDBC、MyBatis
     1. 业务层：Service、声明式事务
     1. 展现层：Spring MVC
   - 官方参考项目
     1. spring-mvc-showcase：参考控制器、配置等写法
     1. greenhouse：也有很多配置和项目
     1. spring-petclinic：用spring boot启动，有很多官方的小例子
### Spring Boot
1. 理解：旨在简化创建产品级的 Spring 应用和服务，提供了命令行工具，是封装了spring再面向用户的
### 微服务
1. 理解：微服务架构是一种架构模式，是分布式网状结构，它提倡将单一应用程序划分成一组小的服务，服务之间互相协调、互相配合，为用户提供最终价值。微服务架构 ≈ 模块化开发 + 分布式计算
1. 组成
   - 服务注册：服务提供方将自己调用地址注册到服务注册中心
   - 负载均衡：服务提供方一般以多实例的形式提供服务

   - 服务网关：服务网关是服务调用的唯一入口，可以在这个组件实现用户鉴权、动态路由、灰度发布、A/B 测试、负载限流等功能
   - 分布式事务：分布式事务技术（TCC、高可用消息服务、最大努力通知）保证数据的一致性   
   - 配置中心：本地化的配置信息（properties, xml, yaml 等）注册到配置中心
   - 服务发现：找到自己需要调用的服务的地址
   - 集成框架：集成框架以配置的形式将所有微服务组件集成到统一的界面框架下
   - 调用链：记录完成一个业务逻辑时调用到的微服务，便于排错
   - API管理：以方便的形式编写及更新API文档
   - 支撑平台：系统微服务化后，系统变得更加碎片化，系统的部署、运维、监控等都比单体架构更加复杂，那么，就需要将大部分的工作自动化，如持续集成、蓝绿发布、健康检查、性能健康等
1. 价值：适用于复杂、大型的项目
   - 规模大（团队超过 10 人）
   - 业务复杂度高（系统超过 5 个子模块）
   - 需要长期演进（项目开发和维护周期超过半年）
1. 实例：使用Spring Cloud提供的 服务注册(Eureka)、服务发现(Ribbon)、服务网关(Zuul)三个组件即可以快速入门
   - 步骤
     1. 现有技术体系开发单一职责微服务————注册中心、服务发现、负载均衡
     1. 服务提供方将地址信息注册到注册中心，调用方将服务地址从注册中心拉下来
     1. 通过服务网关将微服务API暴露给门户或移动APP————服务网关
     1. 将管理端模块集成到统一的操作界面上————管理端集成框架
   - 技术点
     1. 负载均衡：实现服务注册和转发功能
     1. 服务网关：反向代理、权限认证、数据剪裁、数据聚合
     1. 管理端框架
### Netty
1. 理解：Netty是由JBOSS提供的一个java开源框架。Netty提供异步的、事件驱动的网络应用程序框架和工具