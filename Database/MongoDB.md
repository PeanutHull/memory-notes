### MongoDB
1. 认识
   - 解释：基于文档的非关系型数据库。文档按照BSON(json的轻量化二进制格式)存储，增删改查等命令和js语法很像。
   - 组成：集合(collection)和文档(document)来描述和存储数据，collection相当于表，document相当于行，但是一个集合里的文档可以有不同的结构。
1. 连接：mongo默认启动无鉴权，可以配置
1. 集合操作
   - 查
    ```sql
    use accounts
    show collections
    // 得到集合对象
    use accounts
    coll = db.getCollection("accounts")
    ```
   - 增
    ```sql
    // 无新建数据库功能，可以先切库，再新建库
    use accounts
    db.createCollection('accounts')
    show dbs
    ```
   - 改
   - 删
    ```sql
    use accounts
    db.dropDatabase()
    // 和
    use accounts
    coll = db.getCollection("accounts")
    coll.drop();
    ```
1. 文档操作
   - 查
    ```sql
    use accounts
    coll = db.getCollection("accounts")
    coll.find({name:"ZhangSan"})
    ```
   - 增
    ```sql
    use accounts
    coll = db.getCollection("accounts")
    coll.insert({name:"ZhangSan",password:"123456"})
    coll.insert({name:"WangEr",password:"nicai"})
    ```
   - 改
    1. save(obj)
    ```sql
    // 直接更新对象
    coll.save({_id:ObjectId("55cc3e25b36"),name:"ZhangSan",password:"5690"})
    ```
    1. update(query, update, options)。
    ```sql
    coll.update({name:"ZhangSan"},{name:"ZhangSan",password:"567890"})
    // 或者
    coll.update({name:"ZhangSan"},{$set: {password:"567890"}});
    ```
   - 删
    ```sql
    // 将传入的对象属性和数据库的对比，匹配到即删除
    use accounts
    coll = db.getCollection("accounts")
    coll.remove({name:"WangEr"})
    coll.find()
    coll.remove({}) // 删除所有
    coll.find()
    ```
### wiki
1. NoSql分类
   - 按照存储方式
     1. 列：Hbase、Cassandra、Hypertable
        - 方便存储结构化和半结构化数据
        - 列查询有IO优势
     1. kv：Redis、MemcacheDB
        - 快速查询value
     1. 文档：MongoDB、CouchDB
        - 类json格式存储，内容是文档型的，可对字段建立索引实现关系数据库的某些功能
     1. 对象：db4o、Versant
     1. 图：Neo4J
     1. 时序
1. 分布式系统
   - CAP理论：Consistency 一致性，Availability 可用性，Partition tolerance 分区容错性，不可兼得
   - BASE方案：Basically Available 基本可用，Soft state 软状态，Eventually Consistent 最终一致，牺牲某时刻一致性保证最终一致性
   - 分布式事务实现：只能实现弱一致性
     1. 两阶段提交/XA：事务管理器协调，先问问ok不，再判断是否全部ok，https://github.com/yu199195/happylifeplat-transaction
     1. TCC：Try-Confirm-Cancel：https://github.com/yu199195/happylifeplat-tcc
     1. 基于消息中间件的解决分布式事务框架：https://github.com/yu199195/myth
     1. 消息中间件支持：jms(activimq),amqp(rabbitmq),kafka,roceketmq。
     1. rpc框架支持 : dubbo(可用Fescar保持数据一致性),motan,springcloud
     1. 本地事务日志存储支持 : redis,mogondb,zookeeper,file,mysql
1. sql历史
   - Oracle：
     1. 不开源，传奇的公司，传奇的大老板，连续12年每年销售额翻一番。
     1. 诞生早、结构严谨、高可用、高性能，著作权归作者所有。大杀四方：金融、通信、能源、运输、零售、制造等各个行业的大型公司基本都是用了Oracle。Oracle的应用，主要在传统行业的数据化业务中，比如：银行、金融这样的对可用性、健壮性、安全性、实时性要求极高的业务；零售、物流这样对海量数据存储分析要求很高的业务。此外，高新制造业如芯片厂也基本都离不开Oracle；电商也有很多使用者，如京东（正在投奔Oracle）、阿里巴巴（计划去Oracle化）。而且由于Oracle对复杂计算、统计分析的强大支持，在互联网数据分析、数据挖掘方面的应用也越来越多。一个典型场景是这样的：某电信公司（非国内）下属某分公司的数据中心，有4台Oracle Sun的大型服务器用来安装Solaris操作系统和Oracle并提供计算服务，3台Sun Storage磁盘阵列来提供Oracle数据存储，12台IBM小型机，一台Oracle Exadata服务器，一台500T的磁带机用来存储历史数据，San连接内网，使用Tuxedo中间件来保证扩展性和无损迁移。建立支持高并发的Oracle数据库，通过OLTP系统用来对海量数据实时处理、操作，建立高运算量的Oracle数据仓库，用OLAP系统用来分析营收数据及提供自动报表。总预算约750万美金。
   - MySQL：开源，原则上开源、简便易用、面向互联网开发。基本上，互联网的爆发成就了MySQL，LAMP架构风靡天下。使用、开发最不方便，运维不方便。MYSQL只是组件没Oracle那么多而已，性能上面差点，但是免费。MySQL的可定制(自由度)、集群部署便宜被大企业使用，高手小树枝也可以打败敌人。MySQL基本是生于互联网，长于互联网。其应用实例也大都集中于互联网方向，MySQL的高并发存取能力并不比大型数据库差，同时价格便宜，安装使用简便快捷，深受广大互联网公司的喜爱。并且由于MySQL的开源特性，针对一些对数据库有特别要求的应用，可以通过修改代码来实现定向优化，例如SNS、LBS等互联网业务。一个典型的应用场景是：某互联网公司，成立之初，仅有PC数台，通过LAMP架构迅速搭起网站框架。随着业务扩张、市场扩大，迅速发展成为6台Dell小型机的中型网站。现在花了三年，终于成为垂直领域的最大网站，计划中的数据中心，拥有Dell机架式服务器40台，总预算20万美金。
   - SQL Server：不开源，为IBM公司的OS/2操作系统开发。分Microsoft SQL Server、Sybase SQL Server
可以提供全套的Microsoft服务
   - 架构：Oracle根据二进制后的文件功能行进行划分，各种优化;MySQL有软肋、支持极简单的HINT;SQL Server纵向划分，逐层解析
   - 大型数据库：海量数据、高吞吐量；复杂逻辑、高计算量，以及高可用性。Oracle，DB2比较典型
