### MongoDB
1. 认识：基于文档的非关系型分布式开源数据库，是可扩展性的表结构。文档按照BSON存储，增删改查等命令和js语法很像
   - 灵活的文档模型，强大查询语言
   - 高性能：mmapv1、wiredtiger、mongorocks（rocksdb）、in-memory等引擎
   - 高可用：故障自动切换
   - 水平扩展：可扩展分片集群，海量数据存储
1. 适用场景
   - 表结构可能会不断扩展的MySQL表结构，可通过mongoDB存储，可保证表结构扩展性
   - 存储日志，利用分片集群支持海量数据，同时使用聚集分析和MapReduce的能力
1. 不适用场景
   - PB级不适用
   - 文档字段几十个
   - ERP、CRM等富关联应用
   - 跨表原子性更新
   - 100%时间可写入：mongo切换主节点不可写
1. 缺点
   - 多表关联：仅支持Left Outer Join
　　- sql语句支持：查询为主，部分支持
   - 多文档、多表原子事务不支持
   - 16mb文档大小限制，不支持中文排序 ，服务端js性能欠佳
### 操作
1. 组成：数据库、集合、文档
   - collection：集合，表，一个集合里的文档可有不同结构
   - document：文档，行
1. 关键字
   - db：数据库实例
   - rs：复制级
   - sh：分片
1. 数据库操作
    ```sql
    db.stats()
    db.version()
    db.getMongo()

    use xx                                              // 选中

    show dbs                                            // 查看全部    
    db/db.getName()                                     // 查看名称

    db.dropDatabase()                                   // 删
    ```
1. 集合操作
    ```sql
    use xx

    show collections                                    // 查看集合内容
    db.getCollectionNames()

    db.createCollection('xx')                           // 创建
    db.xx.renameCollection('xx')

    coll = db.getCollection("xx")                       // 得到集合对象

    coll.drop();
    ```
1. 文档操作
   - 查
    ```sql
    db.xx.find()                                        // 查
    use xx
    coll = db.getCollection("xx")

    coll.find()
    coll.find({xx:"xx"})

    coll.insert({xx:"xx"})                              // 增

    coll.save({_id:ObjectId("55cc3"),xx:"xx"})          // 改，直接更新
    coll.update({xx:"xx"},{xx:"xx",password:"567890"})  // 按条件，update(query, update, options)
    coll.update({xx:"xx"},{$set: {password:"567890"}});

    coll.remove({xx:"WangEr"})                          // 删，匹配到即删除
    coll.remove({})                                     // 删除所有
    ```
1. 索引：地理位置、文本、TTL索引
1. 事务：只支持单文档事务
session.start_transaction()
session.commit_transaction()
1. 应用
   - 二级索引
   - 地理位置索引
   - 全文搜索
   - 动态查询
   - 聚合框架
   - MapReduce
   - GridFS：基于mongoDB的分布式文件存储系统，解决大文件存储。也是存储和查询超过BSON文件大小限制(16M)的规范，采用分片存储
   - 内存引擎 
   - 地理分布
### 运维
1. 基础操作
   - 开关
     1. 命令行方式：`mongod --dbpath= --logpath=/xx.log --port=27017 --logappend --fork`
        - --fork：后台运行
        - --auth：是否验证权限
        - --bind_ip/bind_ip_all：限制访问ip
        - --shutdown：关闭
     1. 配置文件方式：`mongod -f xx.conf --shutdown`
        ```conf
        vim xx.conf
        dbpath=
        logpath=
        port=27017
        ```
   - 连接：`mongo`
1. 系统操作：`db.shutdownServer()`
1. 自动分片、水平扩展
1. 自动复制、高可用
### wiki
1. bson：json的轻量化二进制格式
1. aggregation & mapreduce：数据分析，用户可以自己写查询语句或脚本，将请求都分发到MongoDB上完成
1. mongod进程收到SIGINT信号或者SIGTERM信号，会关闭打开连接、内存数据强制刷到磁盘、等待当前操作执行完毕、安全停止。不能kill -9，会数据丢失、数据文件损坏
1. gist
   - 插入一万条数据：`for(i=0;i<10000;i++){ db.log.insert({"uid":i,"name":"mongodb","age":6,"date":new Date()});}`
