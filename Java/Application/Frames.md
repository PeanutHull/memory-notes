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
1. 认识：用于构建轻量级、健壮的J2EE应用程序，为了解决开发的复杂性。为应用程序提供基础设施。容器类框架。是Java系的全栈开发框架
1. 重难点
   - 依赖注入
   - 控制反转
   - Bean声明周期
   - AOP
   - 注解
   - 代理
   - 事务管理
   - ApplicationContext，Bean实例化
1. 特点
   1. 方便解耦，简化开发。IOC分层架构，灵活选用组件
   1. AOP支持，面向方面编程
   1. 声明式事务支持
   1. 降低java ee API的使用难度
   1. 方便程序测试、方便集成各种框架，可以用在任何J2EE服务器中。通过启用POJO编程模型，不需要使用EJB容器产品
1. 组成
   - IOC：Bean、Context、表达式语言
     1. 和AOP组成spring的核心
     1. 将类之间的依赖从代码中脱离出来，用配置的方式描述。由IOC容器负责依赖类之间的管理
     1. BeanFactory是核心接口
     1. Context模块构建于核心模块之上，添加i18n、Bean生命周期控制、框架事件体系、资源加载透明化等功能。
     1. 表达式语言是统一表达式语言(Unified EL)的扩展，用于查询和管理运行期的对象，方便的通过表达式和Ioc交互
   - AOP：Spring AOP、Aspects、Instrument
     1. 横切逻辑编程
     1. 整合了AspectJAOP语言级的框架，
   - 数据访问和集成：JDBC、ORM、OXM、JMS、事务管理
     1. 包含表、XML、消息等和其不同的访问方法
     1. spring建立了和数据形式/访问技术无关的统一DAO层
   - web及远程操作：MVC、Web Service、WebSocket、Portlet
     1. 整合其他框架
1. 架构
   - Spring Core：主要组件BeanFactory，使用IOC将配置、依赖规范和应用程序分开
   - Spring Context：Spring的上下文是个配置文件，包括企业服务，有JNDI、EJB、mail、i18n、校验
   - Spring AOP：通过配置管理特性，AOP模块为其他应用提供事务管理服务，不用依赖EJB组件，就可集成声明性事务管理
   - Spring ORM：插入了很多ORM框架，如JDO、Hibernate、iBatis，都遵从Spring的通用事务和DAO异常结构
   - Spring DAO：提供异常层次结构，来管理异常和不同数据库的错误信息，简化了错误处理，
   - Spring Web：为基于Web的应用程度提供上下文，支持与Struts的集成，简化了参数绑定到对象的工作
   - Spring Web MVC：是全功能构建Web的MVC框架，包括了JSP、Velocity等
1. 依赖注入
   - 如何实现
   - 优点
   - 使用
     1. 基于XML的装配方式
     1. 基于Java Configuration的装配方式
     1. 自动装配
     1. 多种装配方式的混用
     1. 处理装配的歧义
     1. 如何注入属性值
1. Spring Bean
   - 作用域
     1. Singleton
     1. Prototype
     1. Request
     1. Session
     1. Global
1. AOP
   - 切面、目标对象、切点、通知、织入等基本概念
   - 如何定义切点：定义切点的aspectJ语法
   - 定义通知
     1. 前置通知（Before)
     1. 后置通知（AfterReturning）
     1. 异常通知（AfterThrowing）
     1. 最终通知（After）
     1. 环绕通知（Around）
     1. 如何给切面传参
1. 使用
   - 业务分层
     1. 持久层：JDBC
     1. 业务层：声明式事务
     1. 展现层：Spring MVC
   - 实践注意点
     1. 当使用`Set<Object>`，即自定义对象的Set集合，要在pojo中重写equals和hashCode方法，因为要保证这两个方法针对的对象属性相同，才能保证输出的bool结果的一致
     1. 自动载入用`@Autowired`或者`@Resource`，后者更好，不出红线
     1. 返回值为List的写法提醒`ServerResponse<List<Category>>`
### Spring MVC
1. 理解：能够利用Spring本身的诸多好处来容易开发web应用
1. 重难点
   - handlerMapping
   - RequestMapping
   - 适配器
   - 拦截器
   - 视图和模型
   - Struts2和Spring MVC的区别
### Spring Boot
### Netty
1. 理解：Netty是由JBOSS提供的一个java开源框架。Netty提供异步的、事件驱动的网络应用程序框架和工具