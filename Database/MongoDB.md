### MongoDB
1. 认识：基于文档的非关系型数据库，是可扩展性的表结构。文档按照BSON存储，增删改查等命令和js语法很像
   - 索引：地理位置、文本、TTL索引
   - 事务：只支持单文档事务
   - 灵活的文档模型
   - 高性能：mmapv1、wiredtiger、mongorocks（rocksdb）、in-memory等引擎
   - 高可用：故障自动切换
   - 可扩展分片集群：海量数据存储，水平扩展
   - Gridfs	解决文件存储的需求
   - aggregation & mapreduce：数据分析，用户可以自己写查询语句或脚本，将请求都分发到 MongoDB 上完成
1. 适用场景
   - 表结构可能会不断扩展的MySQL表结构，可通过mongoDB存储，可保证表结构扩展性
   - 存储日志，利用分片集群支持海量数据，同时使用聚集分析和MapReduce的能力
1. 组成
   - 集合：collection，表，一个集合里的文档可有不同结构
   - 文档：document：行
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
1. 应用
   - GridFS：基于mongoDB的分布式文件存储系统，也是存储和查询超过BSON文件大小限制(16M)的规范，采用分片存储
1. 运维
   - 连接：mongo默认启动无鉴权，可以配置
### wiki
1. bson：json的轻量化二进制格式
