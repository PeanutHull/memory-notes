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
   - 理解：高性能的对象/关系型持久化存储和查询服务。用于和数据库交互，就是桥梁，是处理O/R映射机制和模式。需要理解Hibernate框架的API，是01年出的对象关系框架
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
1. 认识：用于构建轻量级、健壮的J2EE应用程序，为了解决开发的复杂性。为应用程序提供基础设施。
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