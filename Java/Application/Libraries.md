### DAO
1. 理解：Data Access Object，用来封装访问数据库的代码
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
     
1. 中间件
   - ActiveMQ
     1. 概述：Apache出品，是最流行的开源消息总线。完全支持JMS1.1和J2EE1.4规范的JMS provider实现
     1. 特性
        - 多语言客户端：Java、C、C++、C#、Ruby、Python、PHP
        - 多种应用协议：OpenWire、Stomp REST、WS Notification、XMPP、AMQP
        - 支持JMS1.1和J2EE1.4规范，包括持久化、XA消息、事务
        - 高级特性：虚拟主题、组合目的、镜像队列
     1. 优点：遵循JMS规范、安装部署方便
     1. 缺点：会丢消息，重心在下代产品上
     1. 适用：中小企业级消息应用场景
   - rabbitMQ
     1. 概述：是开源的AMQP实现，服务端用Erlang编写，用于分布式系统中存储转发消息，易用性、扩展性、高可用性等表现不俗
     1. 特性
        - 支持多客户端：Java、JMS、C、.Net、Ruby、Python、PHP、ActionScript
        - AMQP的完整实现：vhost、Exchange、Binding、Routing key(虚拟主机、路由器、绑定、交换器)
        - 事务支持/发布确认
        - 消息持久化
     1. 优点：稳定性、安全性有保障
     1. 缺点：不支持动态扩展
     1. 适用：企业级应用
   - Kafka
     1. 概述：是高吞吐量的分布式发布订阅消息系统，是分布式的、分区的、可靠的分布式日志存储服务。本身做日志存储的，对消息的顺序要求严格
     1. 特性
        - 通过O(1)磁盘数据结构提供消息持久化，对于TB级的消息存储也能够保持长时间的稳定性能
        - 高吞吐量：普通硬件也支持每秒数百万的消息
        - Partition、Consumer Group
     1. 优点：可动态扩展节点、高性能、高吞吐量、无限扩容、消息可指定追溯
     1. 缺点：严格的顺序机制，不支持标准的消息协议，不支持消息优先级，不利于平台迁移
     1. 适用：大数据日志处理，对实时性、可靠性要求稍低
   - 比较
     1. RabbitMQ平台无关，剩下两个都偏Java
### Hession
1. 理解：Hessian是一个轻量级的remoting onhttp工具，使用简单的方法提供了RMI的功能