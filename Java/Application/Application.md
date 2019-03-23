1. Controller：和Model层通过JavaBean交流数据
1. Model
   - DAO：即数据模型，不处理业务逻辑，只为业务层提供辅助，完成获取原始数据或持久层数据等。被service层调取执行数据操作，逻辑在service层写
   - Pojo：原始的数据Bean
1. Bean
   - 理解：遵循了JavaBean规范的类
   - 特点
     1. 必须为公共类，可序列化
     1. 若有构造参数，必须是无参的，类中不能出现main函数
     1. 所有属性是私有的，必须通过public的get/set/isXxx来操作
     1. 包含必要的事件处理方法，如addXxxListener、XxxEvent
   - 组成
     1. 属性
        - Simple属性：具有setter、getter方法对的属性
        - Indexed属性：表示数据值，针对数据的simple属性
        - Bound属性：属性值发生变化时，会触发其他JavaBean
        - Constrained属性：属性值将要发生变化时，与该属性建立关系的其他java对象可以否决其改变
     1. 事件：是事件发起者，也是接收者
1. POJO：Plain Old Java Objects，简单java对象，使编写应用程序类快速和简单，使用面向对象的角度写代码
1. Bean和EJB和POJO
   - 在java1996年发布,当年12月即发布了java bean1.00-A,有什么用呢?通过统一的规范可以设置对象的值(get,set方法),这是最初的java bean
   - 在实际企业开发中,需要实现事务,安全,分布式,javabean就不好用了.sun公司就开始往上面堆功能,这里java bean就复杂为EJB
   - EJB功能强大,但是太重了，此时出现DI、AOP技术,通过简单的java bean也能完成EJB的事情,这里的java bean简化为POJO
   - Spring诞生了
### DAO
1. 理解：Data Access Object，用来封装访问数据库的代码，即持久层
1. 部署脚本
    ```java
    echo "======更新代码======="    
    cd /developer/git-repository/mmall
    git fetch
    git pull
    echo "======编译并跳过单元测试======="
    mvn clean package -Dmaven.test.skip=true
    echo "======转移war包======="
    rm /developer/apache-tomcat-7.0.73/webapps/ROOT.war    
    cp /developer/mmall.war  /developer/apache-tomcat-7.0.73/webapps/ROOT.war
    rm -rf /developer/apache-tomcat-7.0.73/webapps/ROOT
    echo "======启动tomcat======="
    /developer/apache-tomcat-7.0.73/bin/shutdown.sh
    for i in {1..10}
    do
    echo $i"s"
    sleep 1s
    done
    /developer/apache-tomcat-7.0.73/bin/startup.sh
    ```
### Java 从零打造企业级电商实战 - 服务端
1. MyBatis
   - 返回新增的主键：mapper.xml文件中insert标签加入属性：`useGeneratedKeys="true" keyProperty="id"`
   - 数据绑定更新对应数据：mapper.xml文件中update指定parameterType的类地址：`parameterType="com.mall.pojo.Xxx"`
   - 批量插入：对应于子订单的批量插入
1. 获得当前运行的文件夹目录：`request.getSession().getServletContext().getRealPath('upload');`
1. 当使用`Set<Object>`，即自定义对象的Set集合，要在pojo中重写equals和hashCode方法，因为要保证这两个方法针对的对象属性相同，才能保证输出的bool结果一致
1. 返回值为List的写法提醒`ServerResponse<List<Category>>`
### 淘淘商城
1. 技术点
   - Nginx反向代理
   - Druid数据库连接池
   - FastDFS：分布式文件系统
   - Redis集群缓存
   - Solr集群搜索
   - Freemaker模板引擎
   - 单点登录、session共享
   - Quartz任务调度：定时器
1. 架构组成
   - taotao-common：项目中用到的通用工具类和pojo
   - taotao-parent
   - taotao-manage
1. 功能点
   - maven的tomcat7插件启动项目：manager项目————右键————run as————第二个maven build————clean tomcat7:run
   - 静态资源映射：`<mvc:resources location="/WEB-INF/js/" mapping="/js/**"/>`，指定到WEB-INF目录下
   - 分页插件的使用
     1. 添加pagehelper的依赖
     1. myBatis配置文件中加入分页插件
        ```xml
        <plugins>
            <plugin interceptor="com.github.pagehelper.PageHelper">
            <!-- 指定使用的数据库是什么 -->
            <property name="dialect" value="mysql" />
            </plugin>
        </plugins>
        ```
     1. 书写分页代码
        ```java
        // 分页处理
		PageHelper.startPage(page, rows);
		// 执行查询
		TbItemExample example = new TbItemExample();
		List<TbItem> list = itemMapper.selectByExample(example);
		// 取分页信息
		PageInfo<TbItem> pageinfo = new PageInfo<>(list);
		// 返回结果
		EasyUIDataGridResult result = new EasyUIDataGridResult();
		result.setTotal(pageinfo.getTotal());
		result.setRows(list);
        return result;
        ```
   - 图片服务器
   - FastDFS：开源国产的分布式文件存储系统，实现了冗余备份、负载均衡、线性扩容等机制，注重高可用、高性能，提供上传、下载功能。Tracker集群提供负载均衡等调度，Storage集群提供存储
1. 知识点
   - 传参中使用Integer等包装类，起到缺少参数但是不报错的作用
   - log4j调试方法，怎么关闭运行时不停输出log信息
### 大数据
1. 认识：是概念也是技术，是以hadoop为代表的大数据平台框架上进行数据分析的技术。pc->云计算->大数据，因为一台机器无法处理了
   - hadoop和spark的基础大数据框架
   - 实时数据处理、离线数据处理、数据分析、数据挖掘、机器算法预测分析
1. Hadoop
   - 认识：开源的大数据框架，分布式计算的解决方案
   - 组成
     1. HDFS
     1. MapReduce
   - HDFS
     1. 认识：分布式文件系统，是基础，管理千百台机器，用起来跟本地一样，支持TB、PB为单位的大量数据存储，简单便捷的文件获取，有副本策略，可构建在廉价机器上，有容错和恢复机制，支持流式数据访问，一次写入，多次读取最高效。不适合大量小文件存储，不适合并发写入，不支持文件随机修改，不支持随机读等低延时的访问方式
     1. 组成
        - 数据块：是抽象块，屏蔽了文件的概念，简化了存储设计，按照块分开存储非整个文件存储，默认64M，一般128M，备份3个
        - NameNode：管理文件系统的命名空间，存放文件元数据，维护所有文件和目录，文件和数据块的映射，记录文件中各个块的所在数据节点的信息
        - DataNode：工作节点，存储并检索数据块，向NameNode更新存储块的列表
     1. 流程
        - 写：client->NameNode写请求->分块写入DataNode节点，自动完成副本备份->向NameNode汇报存储完成->通知client完成
        - 读：client->NameNode读请求->找出最近的DataNode节点信息->client从DataNode分块下载文件
     1. 操作命令：hdfs fds -ls /：查看根目录
        - -mkdir：创建文件夹
        - -copyFromLocal/copyTolocal：hdfs和本地文件交互
        - -get/put
   - MapReduce
     1. 编程模型：文件分片后，每个分片由单独机器处理即map方法，汇总各个计算结果就是Reduce方法，其他的分布式计算框架效率更高，支持更多算子
     1. 认识：分布式计算，是解决方案，是编程模型、编程方法，是抽象的理论
     1. Yarn：Hadoop2以后的资源管理器，负责整个集群MapReduce管理和调度，可扩展和可靠性、资源利用率更好，支持多种计算框架，如离线批处理、内存计算、迭代计算、流式计算，是主从架构，可实现ha
        - ResourceManager：分配和调度资源，启动并监控ApplicationMaster，监控NodeManager
        - ApplicationMaster：为MapReduce申请资源，分配给内部任务，负责数据切分，监控任务的执行和容错
        - NodeManager：管理单个节点的资源，处理以上的命令
1. Spark
   - 认识：基于内存的大数据并行计算框架，是主流的方案，是替代MapReduce的方案，兼容hdfs、hive、mysql等数据源，比较快。是Scale写的，运行在JVM上
     1. RDD：弹性分布式数据集，分布式内存存储数据结构
     1. 基于事件驱动，通过线程池复用提高性能
   - 组件
     1. Spark Core：任务调度、内存管理、容错机制，定义RDD
     1. Spark SQL：做报表统计
     1. Spark Streaming：实时数据流，类似storm，用于在kafka接受数据做实时统计
     1. Mlib：通用机器学习包，包含分类、聚类、回归，模型评估、数据导入，支持集群横向扩展
     1. Graphx：处理图的并行计算
     1. Cluster Managers：集群管理
   - 积累
     1. 用起来：目前spark sql、pyspark、struct streaming都比较易用，在自己的业务场景先用起来，再逐步的优化
     1. 视野及场景提高：可以关注类似spark submit、中国数据库技术大会、hbase中国社区相关的 topic，看看其他公司都怎么使用的；另外需要关注spark和其他组件的配合使用，类似hbase、mongo、solr等
     1. spark本身原理：可以关注spark每个版本的release note、hbase中国社区的相关问答。另外推荐几个比较好的原理博客
        - https://github.com/JerryLead/SparkInternals
        - https://github.com/jaceklaskowski/mastering-spark-sql-book
        - https://github.com/jaceklaskowski/spark-structured-streaming-book
   - 历史
     1. 09年诞生，加州大学伯克利分校的研究项目，最初基于mapReduce
     1. 10年开源
     1. 11年开发高级组件，如Spark Streaming
     1. 13年转移到apache下，成为顶级项目
1. Storm
   - 认识：twitter开源的类似hadoop(架构比较像而已)的实时流式计算框架，解决hadoop不能实时处理的问题，应用于实时推荐/网站统计/监控预警
     1. 适用场景广泛：实时处理和更新，持续并行化查询
     1. 可伸缩性高：加机器提高并行度即可
     1. 异常健壮：集群易管理，可轮流重启节点
     1. 容错性好
   - 架构类型
     1. 主从：简单高效，主节点存在单点问题
     1. 对称：复杂，无单点问题，如zk
   - 组件
     1. Mimbus：对应多个zk，zk对应多个supervisor
     1. zk：分配任务和心跳
     1. supervisor
     1. worker
1. Flink
1. Beam
1. HBase
   - 认识：高可靠、高性能、面向列，可伸缩，实时读写的分布式非关系型数据库，利用hdfs作为文件存储系统，支持mr程序读取数据，可以存储非结构化、半结构化、结构化数据，可以存储大量小文件。架构体系为zk->master->多个RegionServer->hdfs
     1. 海量存储：上百亿行*上百万列
     1. 准实时查询
     1. 面向列：面向列的存储和权限控制，支持独立检索，可动态决定行有哪些列
     1. 多版本
     1. 稀疏性：空列不占用空间，表可以很稀疏
     1. 扩展性：底层依赖hdfs
     1. 高可靠性：WAL机制保证数据写入不会因集群异常而写入丢失，Replication保证集群出现严重问题数据不丢失损坏
     1. 高性能：底层的LSM数据结构和RowKey使得具有高写入性能，region切分、主键索引和缓存机制具备随机读取性能，针对RowKey的查询达到毫秒级别
   - 组成
     1. RowKey：数据唯一标识，按字段排序，不支持条件查询，只支持RowKey查询
     1. Column Family：列簇，多个列的集合，越少越好不超3个否则降低性能，列数没有限制，只有插入数据才存在，列是有顺序的，列可动态添加，数据自动切分，高性能读写
     1. TimeStamp：支持多版本数据同时存在
   - 使用
     1. 表结构模型：不需要指定列，只需要指定列簇即多个列
     1. 数据结构模型：RowKey即主键，TimeStamp版本号，还有列簇的数据填充
     1. 命令
        - create/drop
        - list/describe
        - scan/get/put/delete/count/truncate
        - enable/disable
        - is_enabled/is_disabled
1. Hive
   - 认识：提供大量结构化数据检索的功能的数据仓库。用hdfs存储、MapReduce进行计算。是sql解析引擎，将sql转换为mr job在hadoop中执行，hive的表就是hdfs的目录/文件
     1. 基于hdfs
     1. 可用于数据提取转化加载ETL
     1. 支持类sql查询
     1. 支持mapper和reducer处理
   - 组成
     1. MetaStore：元数据，存储在mysql等中，包括表名、表列、表分区、表属性、表目录
   - 执行过程：解释器、编译器、优化器，完成语法分析、词法分析、编译、优化、查询计划的生成，生成查询计划存储在hdfs中，随后由MapReduce执行
   - 数据类型
     1. tinyint、smallint、int、bigint
     1. float、double
     1. boolean
     1. string
     1. Array
     1. Map
     1. Struct
     1. Data
   - 数据模型
     1. table：内部表
     1. partition：分区表
     1. external table：外部表
     1. bucket table：桶表
     1. 视图
   - 数据仓库：面向主题的、集成的、不可更新的数据集合，用于企业或组织的决策分析处理
1. 应用
   - apache三大分布式计算：Hadoop、Spark、Storm
     1. Hadoop：离线处理、时效性要求不高
     1. Spark：失效要求高
   - zk服务
   - Sqoop数据库抽取工具
   - Flume日志抽取工具
   - DataFrame组件
1. Hadoop生态圈
   - Hadoop
   - Spark
   - Storm
   - Flume
   - Zookeeper
   - HBase
   - Hive
   - Oozie
   - Mahout
   - Pig
   - Hue
   - Avro
   - Bigtop
   - HCatalog
   - Ambari
   - Sqoop
   - Giraph
1. Zookeeper
   - 认识：开源的分布式协调服务框架，提供一致性服务，如配置、域名、同步。提供了分布式独享锁、选举、队列。google的chubby的实现，Hadoop的正式子项目。最常担任生产者和消费者的注册中心
   - 功能
     1. 文件系统：每个目录是一个znode节点，节点可以存储数据，类型有持久化、持久化顺序、临时、临时顺序。临时节点做ha故障切换
     1. 通知机制：znode节点有变化(数据改变/删除)时，通知客户端
   - 配置：zoo.cfg
1. Kafka
   - 认识：LinkIn开源的流式处理平台。传输上构建实时数据流管道，处理上构建实时数据处理应用
     1. 发布、订阅数据流，类似消息队列
     1. 流数据存储，可容忍错误数据
     1. 数据产生时同步处理
   - 特点
     1. 分布式
        - 多分区
        - 多副本
        - 多订阅者
        - 基于zk调度：强依赖zk
     1. 高性能
        - 高吞吐量/高并发：每秒几十万
        - 低延迟
        - 时间复杂度：O(1)
     1. 持久化/扩展性
        - 数据可持久
        - 容错性
        - 支持在线水平扩展
        - 消息自动平衡
   - 结构设计
     1. 物理概念
        - Broker：kafka集群的每个节点
        - Partition：有序的数据存储基本单元，一个topic存储到多个partition
        - Replication：partition的数据副本，只有一个Replication Leader
        - ReplicaManager：管理当前Broker所有分区和副本
     1. 逻辑概念
        - Topic：消息类别，对数据进行区分、隔离
   - 高级特性
     1. 消息事务：不用担心消息丢失，由于满足读取-处理-写入，流处理需求的不断增强，数据一致的容忍。
        - 事务定义
          1. 最多一次
          1. 最少一次
          1. 精确的一次：会被且仅被传输一次
        - 事务保证
          1. 内部重试问题：Procedure幂等处理
          1. 多分区原子写入
          1. 避免僵死实例：每个事务Procedure分配一个事务id，
     1. 零拷贝：用户空间无拷贝
        - 过程
          1. 操作系统将数据从磁盘->内核空间页缓存
          1. 将数据位置和长度信息描述符增加到内核空间(socket缓存区)
          1. 操作系统将数据内核拷贝->网卡缓冲区
        - 原过程
          1. 操作系统将数据从磁盘->内核空间页缓存
          1. 应用程序内核空间->用户空间缓存
          1. 应用程序用户空间缓存->内核空间socket缓存
          1. socket缓存区->网卡缓冲区
        - 实现方案
          1. 网络传输持久性日志快
          1. Java NIO channle.transforTo方法
          1. linux sendfile系统调用
   - 应用
     1. 消息队列
     1. 行为跟踪：所有数据堆一起然后处理
     1. 元信息监控
     1. 日志收集
     1. 流处理：数据串起来，流动起来
     1. 事件源：记录事件状态变更，可做状态回溯
     1. 持久性日志
   - wiki
     1. 历史：11年开源加入apache
     1. LinkIn开源的东西
        - Databus：分布式数据同步系统
        - Cubert：高性能计算引擎
        - ParSeq：java异步处理框架
