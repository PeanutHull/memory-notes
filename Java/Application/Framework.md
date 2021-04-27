### Hibernate
1. JDBC
   - 理解：Java Database Connectivity。执行sql语句的API
   - 优缺点
     1. 优点：语法简单，性能好
     1. 缺点：大项目中使用复杂，难以实现MVC，不够简洁
   - 实例
        ```Java
        package com.runoob.test;
    
        import java.sql.*;

        public class MySQLDemo {

            // JDBC 驱动名及数据库 URL
            static final String JDBC_DRIVER = "com.mysql.jdbc.Driver";  
            static final String DB_URL = "jdbc:mysql://localhost:3306/RUNOOB";

            // 数据库的用户名与密码，需要根据自己的设置
            static final String USER = "root";
            static final String PASS = "123456";

            public static void main(String[] args) {
                Connection conn = null;
                Statement stmt = null;
                try{
                    // 注册 JDBC 驱动
                    Class.forName("com.mysql.jdbc.Driver");
                
                    // 打开链接
                    System.out.println("连接数据库...");
                    conn = DriverManager.getConnection(DB_URL,USER,PASS);
                
                    // 执行查询
                    System.out.println(" 实例化Statement对...");
                    stmt = conn.createStatement();
                    String sql;
                    sql = "SELECT id, name, url FROM websites";
                    ResultSet rs = stmt.executeQuery(sql);
                
                    // 展开结果集数据库
                    while(rs.next()){
                        // 通过字段检索
                        int id  = rs.getInt("id");
                        String name = rs.getString("name");
                        String url = rs.getString("url");
            
                        // 输出数据
                        System.out.print("ID: " + id);
                        System.out.print(", 站点名称: " + name);
                        System.out.print(", 站点 URL: " + url);
                        System.out.print("\n");
                    }
                    // 完成后关闭
                    rs.close();
                    stmt.close();
                    conn.close();
                }catch(SQLException se){
                    // 处理 JDBC 错误
                    se.printStackTrace();
                }catch(Exception e){
                    // 处理 Class.forName 错误
                    e.printStackTrace();
                }finally{
                    // 关闭资源
                    try{
                        if(stmt!=null) stmt.close();
                    }catch(SQLException se2){
                    }// 什么都不做
                    try{
                        if(conn!=null) conn.close();
                    }catch(SQLException se){
                        se.printStackTrace();
                    }
                }
                System.out.println("Goodbye!");
            }
        }
        ```
1. ORM
   - 理解：Object Relation Mapping。在关系型数据库和拥有面向对象的编程语言转换的技术。
   - 特点
     1. 访问对象而不是表
     1. 隐藏了sql实现的细节
     1. 基于业务的概念而不是数据库的结构
     1. 应用程序的快速开发
   - 组成
     1. 实现CURD的API
     1. 引用类和属性查询的API
     1. 可配置的服务来指定映射元数据
     1. 事务对象等其他优化功能
   - ORM框架
     1. Enterprise JavaBeans Entity Beans
     1. Java Data Objects
     1. Castor
     1. TopLink
     1. Spring DAO
     1. Hibernat
     1. MyBatis
1. 认识
   - 理解：高性能的对象/关系型持久化存储和查询服务。用于和数据库交互，就是桥梁，是处理O/R映射机制和模式。需要理解Hibernate框架的API，01年出的对象关系框架
   - 特点
     1. XML文件映射类到数据库，抽象不熟悉的sql类型，提供熟悉的java对象
     1. 简单的数据访问
     1. 支持众多数据库：MySQL、PostgreSQL、FrontBase、DB2、Oracle、SQL Server
     1. 支持的技术：J2EE、Eclipse plug-ins、Maven
   - 架构
     1. 配置对象：如hibernate.properties和hibernate.cfg.xml
     1. SessionFactory对象：每个数据库对应一个工厂对象
     1. Session对象：避免长时间开启，并非线程安全
     1. Query对象
     1. Transaction对象：RDBMS的事务支持功能，底层由jdbc或者JTA处理
     1. Criteria对象：创造和执行面向规则查询的对象来检索对象
1. 安装和配置、映射
   - 安装
     1. Hibernate官网下载应用
     1. 将所有jar包添加到CLASSPATH中
   - 配置
     1. 配置文件：java属性文件-`hibernate.properties`/XML文件-`hibernate.cfg.xml`
     1. 作用：映射文件帮助Hibernate确定如何从该类提取值，并将其映射在表格和相关域中
     1. 配置示例
        ```XML
        <hibernate-configuration>
            <session-factory>
                <property name="hibernate.dialect">
                    org.hibernate.dialect.MySQLDialect
                </property>
                <property name="hibernate.connection.driver_class">
                    com.mysql.jdbc.Driver
                </property>
                <!-- Assume test is the database name -->
                <property name="hibernate.connection.url">
                    jdbc:mysql://localhost/test
                </property>
                <property name="hibernate.connection.username">
                    root
                </property>
                <property name="hibernate.connection.password">
                    root123
                </property>
                <!-- List of XML mapping files -->
                <mapping resource="Employee.hbm.xml"/>
            </session-factory>
        </hibernate-configuration>
        ```
   - 映射
     1. 表的映射：保存文件名`classname>.hbm.xml`
        ```XML
        <hibernate-mapping>
            <class name="Employee" table="EMPLOYEE"> // 类名name，表table
                <meta attribute="class-description"></meta>
                <id name="id" type="int" column="id"> // 主键
                    <generator class="native"/>
                </id>
                <property name="firstName" column="first_name" type="string"/> // 字段
                <property name="lastName" column="last_name" type="string"/>
                <property name="salary" column="salary" type="int"/>
            </class>
        </hibernate-mapping>
        ```
     1. 映射类型：对应一对sql和java类型，提供互相转换的功能
        - 简单映射
          1. 原始类型：integer、string、character、byte、boolean、true/false
          1. jdk相关：class、timezone
          1. 二进制和大型数据：binary、text、blob
          1. 日期和时间：date、time、timestamp
        - 集合映射
          1. \<set>：对应java.util.Set/SortSet
          1. \<list>：java.util.List
          1. \<bag>\<ibag>：Collection
          1. \<map>：java.util.Map/SortedMap
        - 关联映射：一对一、一对多、多对多
        - 组件映射：就是指接口、抽象类这种的吧，组件类就是完全依靠拥有它的实体类的生命周期的引用的类
     1. 自动生成映射：XDoclet、Middlegen、AndroMDA   

   - 使用流程
     1. 创建POJO类：Plain Old Java Object 
     1. 创建映射文件
     1. 创建应用程序类
1. 会话：获取和数据库的连接，需要时才和数据库连接。持久态的session被保存，通过Session对象检索找回
   - 实体类的实体状态
     1. 瞬时状态：数据库中无相关联的记录且无标识符值
     1. 持久状态：数据库中无相关联的记录，有标识符值，与一个session关联
     1. 脱管状态：关闭session，实例变为脱管状态
   - hibernate的状态
     1. 瞬时：刚new出一个对象
     1. 持久化：被保存到数据库中了
     1. 离线：数据库有，session中不存在
   - 方法
     1. `` // 
     1. `Session get(String entityName, Serializable id)` // 返回标识符或null的持久化实例
     1. `Serializable getIdentifier(Object object)` // 返回给定实体关联的session的标识符值
     1. `SessionFactory getSessionFactory()`
     1. `void refresh(Object object)` // 从数据库中重新读取给定实例的状态
     1. `boolean isDirty()` // session中是否包含必须与数据库同步的变化
     1. `boolean isOpen()` // session是否处于开启状态
     1. `boolean isConnected()` // 当前session是否连接
     1. `Connection close()` // 释放和清理连接来结束session
     1. `void clear()` // 完全清除session
1. 查询
   - 理解：是面向对象的，针对对象和其属性，
   - 基本查询
     1. SELECT、FROM、AS
        ```Java
        String hql = "SELECT E.firstName FROM Employee E WHERE E.id = 10 ORDER BY E.salary DESC, E.salary DESC" + "GROUP BY E.firstName"; // 别名E
        Query query = session.createQuery(hql);
        List results = query.list();
        ```
     1. UPDATE、DELETE、INSERT(必须有一个对象才能插入到另一个对象中)
        ```Java
        String hql = "UPDATE Employee set salary = 10 WHERE id = 1";
        String hql = "DELETE FROM Employee WHERE id = 1";
        String hql = "INSERT INTO Employee(firstName, lastName, salary)"  + 
             "SELECT firstName, lastName, salary FROM old_employee";
        Query query = session.createQuery(hql);
        query.executeUpdate();
        ```
     1. avg/count/max/min/sum
        ```Java
        String hql = "SELECT count(distinct E.firstName) FROM Employee E"; // 只计算集中的唯一值
        ```
     1. 命名参数、分页查询
        ```Java
        String hql = "FROM Employee E WHERE E.id = :employee_id";
        Query query = session.createQuery(hql);
        query.setParameter("employee_id",10);
        query.setFirstResult(1);
        query.setMaxResults(10);
        List results = query.list();
        ```
   - 标准查询：Criteria 对象，执行标准查询时返回持久化对象的类的实例
     1. 添加查询条件：add()
        ```Java
        Criteria cr = session.createCriteria(Employee.class);
        cr.add(Restrictions.eq/gt/li/like/ilike/between/isNull/isNotNull/isEmpty/isNotEmpty("salary", 2000));
        LogicalExpression or/andExp = Restrictions.or/and(salary, name); // 添加or/and条件
        cr.add(or/andExp);
        cr.addOrder(Order.desc("salary"));
        cr.setFirstResult(1); // 分页
        cr.setMaxResults(10);
        List results = cr.list();
        ```
     1. 结果处理
        ```Java
        cr.setProjection(Projections.rowCount/avg/max/min/sum());
        ```
1. 其他功能
   - 原生sql
     1. 标量查询：获取标量的值
        ```Java
        String sql = "SELECT first_name, salary FROM EMPLOYEE";
        SQLQuery query = session.createSQLQuery(sql);
        query.setResultTransformer(Criteria.ALIAS\_TO\_ENTITY_MAP);
        List results = query.list();
        ```
     1. 实体查询：获取整体的实体对象
        ```Java
        String sql = "SELECT * FROM EMPLOYEE";
        SQLQuery query = session.createSQLQuery(sql);
        query.addEntity(Employee.class);
        List results = query.list(); 
        ```
     1. 指定sql查询
        ```Java
        String sql = "SELECT * FROM EMPLOYEE WHERE id = :employee_id";
        query.setParameter("employee_id", 10);
        ```
   - 注释
     1. 理解：一种给O/R映射关系提供元数据的方法。被添加到POJO Java文件中，有利于更好理解表结构。更大的灵活性是XML方法
     1. 组成
        - @Id
        - @Entity：表示此类为实体bean
        - @Table
   - 缓冲：缓冲提供者
   - 批处理
        ```Java
        Session session = SessionFactory.openSession();
        Transaction tx = session.beginTransaction();
        for ( int i=0; i<100000; i++ ) {
            Employee employee = new Employee(.....);
            session.save(employee);
        }
        // 改良后，及时清掉缓冲，和batch_size一样
        if( i % 50 == 0 ) {
            session.flush();
            session.clear();
        }
        tx.commit();
        session.close();
        ```
   - 拦截器
     1. 理解：Hibernate的对象的生命周期中，任何状态改变而注册触发的方法
     1. 方法
        - `instantiate()` // 实例化时调用
        - `onDelete()` // 对象被删除前使用
        - `onFlushDirty()` // flush时发现对象被修改等时触发
        - `onLoad()` // 对象初始化前
        - `onSave()` // 被保存前
        - `preFlush` // flush前
     1. 使用：实现Interceptor类/继承EmptyInterceptor类
### MyBatis
1. 重难点
   - 基本增删改查
   - 注解方式
   - 动态SQL
   - 参数传递
   - 一对一、一对多、多对多
   - SQL Maps
   - 数据关联、动态映射
   - 事务关联
1. 插件
   - MyBatis-generator：右侧Maven按钮————Plugins————执行MyBatis-generator
   - MyBatis-plugin：IDEA的插件，安装这个可以提示方法
   - MyBatis-pagehelper————分页插件
1. 数据库连接池框架
   - Druid：java最好的数据库连接池，提供强大的监控和扩展功能
   - DBCP：apache上的一个java项目，是tomcat使用的li连接池组件
   - C3P0：Hibernate使用的连接池，C3P0稳定性较高
1. 分布式事务管理器
   - XA
     1. 理解：是数据库与事务管理器的接口标准，采用两阶段提交方式来管理分布式事务，包括以xa_/ax_开头的两套函数
     1. 函数
        - xa_open/xa_close 建立/关闭与资源管理器的连接
        - xa_start/xa_end 开始/结束本地事务
        - xa_prepare/xa_commit/xa_rollback 预提交、提交、回滚本地事务
        - xa_recover 回滚预提交的事务
        - ax_reg/ax_unreg 允许资源管理器在TMS(TRANSACTION MANAGER SERVER)动态注册/取消注册。ax_开头的函数使资源管理器可以动态地在事务管理器中进行注册，并可以对XID(TRANSACTION IDS)进行操作
   - 分类
     1. Atomikos
        - 特点：崩溃/重启恢复、兼容JTA API、嵌套事务支持、为XA和非XA提供内置JDBC适配器、内置JMS适配器(也就是队列连接器)XA-capable
        - 使用：添加数据源--配置数据源--配置jta事务管理
     1. Bitronix：实现了JTA API、支持XA事务管理
### JPA
1. 理解：采用Spring Data JPA实现
### 消息中间件
1. 中间件：非底层操作系统软件，非业务应用软件，不是给终端用户使用的，称为中间件
1. 消息中间件：专注于数据的发送和接收，利用高效可靠的`异步`消息传递机制，集成`分布式`系统
1. JMS和AMOP
   - 理解
     - JMS规范：是java平台中面向消息中间件的API，用于在两个系统间/分布式系统中发送消息，进行`异步`通信
       1. 消息传输类型：p2p，pub/sub
       1. 消息类型：Text/Map/Bytes/Stream/Object/Message
       1. 特性：定义了API层面的标准，client可直接通过JMS通信，但是跨平台性很差
     - AMQP协议：advanced message queuing protocol，是提供统一消息服务的应用层标准协议，基于此协议的客户端和消息中间件可传递信息，不受不同产品/语言的限制
       1. 消息传输类型：direct、fanout、topic、headers、system
       1. 消息类型：byte[]
       1. 特性：面向消息、队列、路由、可靠性、安全
   - 对比
     1. JMS是一个java API，AMQP是传输层的线协议
     1. AMQP就是为了跨语言，JMS只有java
### Hession
1. 理解：Hessian是一个轻量级的remoting onhttp工具，使用简单的方法提供了RMI的功能
### Quartz
1. 理解：任务调度、资源调度框架，执行定时任务用的，提供运行环境的持久化机制。涉及多线程并发、运行时间的制定解析、运行现场保持与恢复、线程池维护
1. 组成
   - Job：执行具体任务的接口
   - JobDetail：任务的具体描述
   - Trigger：触发器，包括SimpleTrigger、CronTrigger
   - Scheduler：独立Quartz运行容器，将Trigger和JobDetail绑定
   - ThreadPool：Scheduler运行任务的线程池
   - Calendar：org.quartz.Calendar，是日历特定时间点的集合
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
1. 认识：用于构建轻量级、健壮的j2ee应用程序，解决开发的复杂性，是全栈的容器类框架
1. 特点
   - IoC分层架构，灵活选用组件，方便集成各种框架，简化开发
   - AOP支持，面向切面编程
   - 声明式事务支持
   - 使用pojo编程模型
1. 组成
   - Spring Core：主要组件BeanFactory，使用IOC将配置、依赖规范和应用程序分开
   - Spring AOP：通过配置管理特性，AOP模块为其他应用提供事务管理服务，不用依赖EJB组件，就可集成声明性事务管理
   - Spring Context：Spring上下文是个配置文件，包括企业服务，有JNDI、EJB、mail、i18n、校验
   - Spring ORM：插入了很多ORM框架，如JDO、Hibernate、iBatis，都遵从Spring的通用事务和DAO异常结构
   - Spring DAO：提供异常层次结构，来管理异常和不同数据库的错误信息，简化了错误处理，
   - Spring Web：为基于Web的应用程度提供上下文，支持与Struts的集成，简化了参数绑定到对象的工作
   - Spring Web MVC：是全功能构建Web的MVC框架，包括了JSP、Velocity等
1. IoC
   - 理解：控制反转，Inversion of Control，将类之间的依赖从代码中脱离出来，用配置的方式描述，由IOC容器负责依赖类之间的管理。和AOP组成spring的核心/基础。Context模块构建于之上，添加i18n、Bean生命周期控制、框架事件体系、资源加载透明化等功能。BeanFactory是核心接口。用DI(Dependency Injection)依赖注入的概念来代替IoC而便于理解，让调用类对某接口实现类(被依赖类)的依赖关系由第三方(容器或者协作类)注入，以移除调用类对某接口实现类的直接依赖。角色有调用类(主体逻辑实现类)，接口实现类(被依赖类)，第三方装配类(将前二者组合起来)。反射是实现依赖注入的基础，第三方装配类将决定依赖的关系交给用户，由用户定义
   - 注入方式
     1. 构造函数注入：通过构造函数将接口实现类当做变量注入，适用于调用类全局依赖接口实现类
     1. 属性注入：用setter方法在需要时才注入
     1. 接口注入：调用类实现一个接口，在接口方法中注入接口实现类，绕了，跟属性注入方式一样，还多了个调用类接口
   - 装配方式
     1. 基于XML的装配方式
     1. 基于Java Configuration的装配方式
     1. 自动装配
     1. 多种装配方式的混用
     1. 处理装配的歧义
     1. 如何注入属性值
   - Spring基础接口
   - Bean生命周期
   - Spring Bean 的作用域
     1. Singleton
     1. Prototype
     1. Request
     1. Session
     1. Global
1. AOP
   - 理解：可以理解为切面、目标对象、切点、通知等基本概念，横切逻辑编程，整合了AspectJAOP语言级框架，aspectJ语法定义切点
   - 通知类型
     1. 前置通知（Before)
     1. 后置通知（AfterReturning）
     1. 异常通知（AfterThrowing）
     1. 最终通知（After）
   - 如何给切面传参
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
     1. @Resource和@Autowired
        - 理解：用于bean的注入，可以写在字段和setter方法上，如果写在字段上，不需要写setter方法
        ```java
        @Autowired/Resource                             // 二者选其一
        private UserDao userDao;                        // 用于字段
        @Autowired/Resource
        public void setUserDao(UserDao userDao) {       // 用于setter方法
            this.userDao = userDao;
        }
        ```
        - 不同点
          1. Autowired默认按照类型注入，如果允许null值，设置required属性为false。按照名称注入要加`@Qualifier("userDao")`注解
          1. Resource默认按照名称注入，由J2EE提供，需导入javax.annotation.Resource。属性有name和type，分别指定则使用不同注入方法，都不指定使用反射按照名称注入
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
### Netty
1. 理解：Netty是由JBOSS提供的一个java开源框架。Netty提供异步的、事件驱动的网络应用程序框架和工具
### 业务网关
1. Spring Cloud gateway
1. linkered
1. zuul
### 熔断器
1. Hystrix
1. Sentinel
1. Resilience4J
1. Spring Retry