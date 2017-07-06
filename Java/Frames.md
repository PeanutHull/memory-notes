### EJB
1. 理解：用于部署分布式的程序，非常重量级，配置复杂，没有spring轻量，目前使用比较少。容器类框架
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
1. 认识：用于构建轻量级、健壮的J2EE应用程序，为了解决开发的复杂性。为应用程序提供基础设施。容器类框架
1. 理解：Spring的功能可以用在任何J2EE服务器中。通过启用POJO编程模型，不需要使用EJB容器产品
1. 特点
   1. 分层架构，灵活选用其中的组件
   1. AOP，面向方面编程
   1. IOC，控制反转容器
   1. 提供一致的事务管理，可以变成本地事务、全局事务
1. 架构
   - Spring Core：主要组件BeanFactory，使用IOC将配置、依赖规范和应用程序分开
   - Spring Context：Spring的上下文是个配置文件，包括企业服务，有JNDI、EJB、mail、i18n、校验
   - Spring AOP：通过配置管理特性，AOP模块为其他应用提供事务管理服务，不用依赖EJB组件，就可集成声明性事务管理
   - Spring ORM：插入了很多ORM框架，如JDO、Hibernate、iBatis，都遵从Spring的通用事务和DAO异常结构
   - Spring DAO：提供异常层次结构，来管理异常和不同数据库的错误信息，简化了错误处理，
   - Spring Web：为基于Web的应用程度提供上下文，支持与Struts的集成，简化了参数绑定到对象的工作
   - Spring Web MVC：是全功能构建Web的MVC框架，包括了JSP、Velocity等