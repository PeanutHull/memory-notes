### 认识
1. 认识：基于文档的非关系型分布式开源数据库，是可扩展性的表结构。C++编写，文档按照BSON存储，增删改查等命令和js语法很像
   - 灵活的文档模型，强大查询语言，支持查询联接
   - 具有快照隔离的分布式多文档ACID事务
   - 高性能：mmapv1、wiredtiger、mongorocks（rocksdb）、in-memory等引擎
   - 高可用：故障自动切换
   - 水平扩展：可扩展分片集群，海量数据存储
   - 两种关系：引入、嵌入式
1. 适用场景
   - 表结构可能会不断扩展的MySQL表结构，可通过mongoDB存储，可保证表结构扩展性
   - 存储日志，利用分片集群支持海量数据，同时使用聚集分析和MapReduce的能力
   - 性能真的不太行，几百万区分度低的数据，查起来大几百毫秒，适合小应用，灵活快速
1. 不适用场景
   - PB级不适用
   - 文档字段几十个
   - ERP、CRM等富关联应用
   - 跨表原子性更新
   - 100%时间可写入：mongo切换主节点不可写
1. 缺点
   - 多表关联：仅支持Left Outer Join
   - 16mb文档大小限制，不支持中文排序，服务端js性能欠佳
1. 应用场景
   - 二级索引
   - 地理位置索引
   - 全文搜索
   - 动态查询
   - 聚合框架
   - MapReduce
   - GridFS：基于mongoDB的分布式文件存储系统，解决大文件(超16M)存储。采用分片存储
   - journal：硬关闭时帮助数据库恢复的日志，可配置日志在特定用例的性能和可靠性之间取得平衡
### 组成
1. 认识
   - 组成：数据库、集合、文档
     1. db：数据库实例
     1. collection：集合，表，一个集合里的文档可有不同结构
     1. document：文档，行
     1. 只读视图：v3.4
     1. 按需实例化视图：v4.2开始
     1. rs：副本集
     1. sh：分片
   - 特点
     1. UTF-8编码的字符串才是合法的
1. db
   - 分类
     1. admin：管理库，这个库的用户自动继承所有数据库的权限。特定服务器端命令也只能从这个数据库运行
     1. local：本地库，库数据不会做副本集，可以用来存储限于本地单台服务器的任意集合
     1. config：配置库，用于分片设置时，config数据库在内部使用，用于保存分片的相关信息
   - 操作
     1. 状态
        - db.stats()
        - db.version()
        - db.getMongo()
     1. 使用
        - use xx                                              // 选中
     1. 查看
        - show dbs                                            // 查看全部    
        - db/db.getName()                                     // 查看名称
     1. 删除
        - db.dropDatabase()                                   // 删
1. collection
   - 认识：集合，插入数据时，集合会被创建
     1. capped collections：封顶集合，固定大小的集合，有很高的性能以及队列过期的特性。数据存储空间值是提前分配的，单位字节。oplog.rs用了这个
        - 可以按照文档的插入顺序保存到集合中，在磁盘上存放位置也是按照插入顺序来保存的，所以提高了新增数据的效率
        - 更新后的文档不可以超过之前文档的大小，就可以确保所有文档在磁盘上的位置一直保持不变
        - `db.createCollection("xx", {capped:true, size:x})`
   - 操作
     1. 查看
        - show collections                                    // 查看集合内容
        - db.getCollection()/listCollections()
        - db.getCollectionNames()
        - db.getCollectionInfos()
     1. 修改
        - db.createCollection(name, options)
          1. capped
          1. size：最大大小
          1. max：文档最大数量
        - db.xx.renameCollection('xx')
     1. 获取
        - coll = db.getCollection("xx")                       // 得到集合对象
     1. 删除
        - coll.drop();                                        // 删
1. document
   - 认识：文档，是一组键值对，即BSON
     1. 主键为_id(ObjectId.getTimestamp()可获取创建时间)，用于创建文档的id，可以很快生成和排序，为12字节，4字节时间戳，3字节机器码，2字节PID，3字节随机数
     1. 键值对有序，区分类型和大小写
     1. 不需要设置相同的字段，相同的字段不需要相同的数据类型
     1. 不要求文档有相同模式，v3.2在新增、更新时可强制执行规则验证
     1. 不能有重复键，键不能有\0(用于表示键结尾)，.和$只在特定环境使用，_开头的是保留的(不严格要求)
     1. 值可以是多种数据类型，甚至可以是整个嵌入的文档
### 操作
1. 运算符
   - 符号
     1. $：顶级字段名称不能以$开头
     1. .：点表示法，表示更深一层的字段
     1. 匹配所有写法：{}
   - 查询
     1. 比较
        - $in/$nin：(不)匹配数组中指定的任何值
        - $eq/$ne：(不)匹配等于指定值的值
        - $gt/$gte：匹配大于/或等于指定值的值
        - $lt/$lte：匹配小于/或等于指定值的值
     1. 数组
        - $all：匹配包含查询中指定的所有元素的数组
        - $elemMatch：如果array字段中的元素符合所有指定$elemMatch条件，则选择文档
        - $size：如果数组字段为指定大小，则选择文档
     1. 元素
        - $exists
        - $type：指定字段类型，如2 string，10 null
     1. 评估
        - $expr：允许在查询语言中使用聚合表达式
        - $jsonSchema：根据给定的JSON Schema验证文档
        - $mod：对字段的值执行模运算并选择具有指定结果的文档
        - $regex：选择值与指定的正则表达式匹配的文档
        - $text：执行文本搜索
        - $where：匹配满足JavaScript表达式的文档
     1. 逻辑，用于查询子句
        - $and：使用逻辑AND连接查询子句，返回与这两个子句条件匹配的所有文档
        - $or：用逻辑OR连接查询子句，返回与任一子句条件匹配的所有文档
        - $not：反转查询表达式的效果，并返回与查询表达式不匹配的文档
        - $nor：用逻辑NOR连接查询子句，返回所有不能匹配这两个子句的文档
     1. 地理空间
        - $geoIntersects：选择与GeoJSON几何形状相交的几何形状。2dsphere索引支持 $geoIntersects
        - $geoWithin：选择边界GeoJSON几何内的几何，2dsphere和2D指标支持 $geoWithin
        - $near：返回点附近的地理空间对象，需要地理空间索引，2dsphere和2D指标支持 $near
        - $nearSphere：返回球体上某个点附近的地理空间对象，需要地理空间索引，2dsphere和2D指标支持 $nearSphere
     1. 按位
        - $bitsAllClear：匹配数字或二进制值，其中一组位的所有值均为0
        - $bitsAllSet：匹配数字或二进制值，其中一组位的所有值均为1
        - $bitsAnyClear：匹配数值或二进制值，在这些数值或二进制值中，一组位的位置中任何位的值为0
        - $bitsAnySet：匹配数值或二进制值，在这些数值或二进制值中，一组位的位置中任何位的值为1
     1. 注释
        - $comment：向查询谓词添加注释
   - 映射
     1. $：数组中匹配查询条件的第一个元素
     1. $elemMatch：符合指定$elemMatch条件的数组中的第一个元素
     1. $meta：项目在$text操作期间分配的文档分数
     1. $slice：限制从数组中投影的元素数量。支持limit和skip
   - 更新
     1. 字段
        - $currentDate：将字段的值设置为当前日期，即日期或时间戳
        - $inc：将字段的值增加指定的数量
        - $min：仅当指定值小于现有字段值时才更新该字段
        - $max：仅当指定值大于现有字段值时才更新该字段
        - $mul：将字段的值乘以指定的数量
        - $rename：重命名字段
        - $set：设置文档中字段的值
        - $setOnInsert：如果更新导致插入文档，则设置字段的值。对修改现有文档的更新操作没有影响
        - $unset：从文档中删除指定的字段
     1. 数组
        - 运算符
          1. $：充当占位符，以更新与查询条件匹配的第一个元素
          1. $[]：充当占位符，以更新匹配查询条件的文档的数组中的所有元素
          1. $[<identifier>]：充当占位符，以更新arrayFilters与查询条件匹配的文档中所有与条件匹配的元素
          1. $addToSet：仅当元素不存在于集合中时才将它们添加到数组中
          1. $pop：删除数组的第一项或最后一项
          1. $pull：删除与指定查询匹配的所有数组元素
          1. $push：将项目添加到数组
          1. $pullAll：从数组中删除所有匹配的值
        - 修饰符
          1. $each：修改$push和$addToSet运算符以附加多个项以进行数组更新
          1. $position：修改$push运算符以指定要添加元素的数组中的位置
          1. $slice：修改$push运算符以限制更新数组的大小
          1. $sort：修改$push运算符以对存储在数组中的文档重新排序
     1. 按位：$bit：执行按位AND，OR和XOR整数值的更新
   - 聚合管道阶段
   - 聚合管道
     1. 算术
     1. 列表
     1. 布尔
     1. 累加器等等
1. 查询
   - 方法
     1. coll.find(query, projection).limit(n).skip(n).sort({KEY:1}).pretty()
        - projection：指定返回字段
        - sort：1 升序，-1降序
        - pretty：以易读方式读取数据
     1. coll.findOne()
     1. coll.distinct("xx")：查询去掉当前集合中某列的重复数据
   - 用法
     1. 普通查询
        - coll.find({})：查询所有
        - coll.find( { status : "A" } , { item.value : 1 , status : 1 , _id : 0 } )：控制选取和排除的字段，1选取，0排除
     1. 数组查询
        - coll.find({tags:["red","blank"]})：恰好具有两个元素的数组
        - coll.find({tags:{$all:["red","blank"]}})：同时包含元素的数组
     1. 空字段、缺少字段
        - coll.find( { item : null } )：匹配值是null的item字段或不包含item字段的文档
        - coll.find( { item : { $type: 10 } } )：仅匹配item字段值为null的文档
        - coll.find( { item : { $exists: false } } )：字段存在检查
     1. 运算符查询
        - coll.find( { xx : "xx" , xx : { $gt : x } } , { xx : "xx" } )：查询条件 + 查询字段，查询字段顺序也要完全匹配，否则查不出来
        - coll.find( { instock : { $elemMatch : { qty : { $gt : 10 , $lte : 20 } } } } )：$elemMatch指定多个条件
        - coll.find( { 'instock.qty.0.a' : {$lte:20 } } )
        - coll.find().sort({$natural: 1})
     1. 多重关系查询
        - and：coll.find( { status: "A", qty: { $lt: 30 } } )
        - or：coll.find( { $or: [ { status: "A" }, { qty: { $lt: 30 } } ] } )
   - 游标：find返回游标
     1. hasNext()和next()和objsLeftInBatch()(剩余文档数)来迭代游标，toArray()方法耗尽游标
     1. 服务器将在闲置10分钟后或客户端用尽光标后自动关闭游标
        - 关闭超时：`cursor.noCursorTimeout()`或者`db.users.find().noCursorTimeout();`，那就必须使用`cursor.close()`手动关闭
     1. 服务器批量返回结果不会超过16M
1. CURD
   - 新增
     1. 认识
        - 插入数据没有db和collection会自动创建
     1. 方法
        - db.collection.insert()：单个或多个
        - db.collection.save()：废弃，根据_id新增或更新，使用replaceOne代替
        - db.collection.insertOne()
        - db.collection.insertMany([<document n>], {writeConcern: 1/0,ordered: <boolean>})
          1. writeConcern：是否确认写，默认是
          1. ordered：是否顺序写
        - db.collection.bulkWrite()：批量插入、更新、删除
          1. 有序 VS 无序
             - 遇到错误是否继续执行，有序否，无序是
             - 分片上有序慢，因为要等待上一个，无序是同时发出
   - 更新
     1. 方法
        - db.collection.updateOne()
        - db.collection.updateMany()
        - db.collection.update(<query>, <update>, {upsert: <boolean>, multi: <boolean>, writeConcern: <document>})
          1. query：更新条件
          1. update：更新内容
          1. upsert：不存在是否插入
          1. multi：是否更新多条，默认更新一个
        - db.collection.replaceOne()
        - db.collection.findOneAndUpdate()
        - db.collection.findAndModify()

        - Bulk.find.update()
        - Bulk.find.updateOne()
        - Bulk.find.upsert()
   - 删除
     1. 认识：remove不会真正释放空间，使用`db.repairDatabase()`或者`db.runCommand({repairDatabase:1})`回收磁盘
     1. 方法
        - db.collection.remove(<query>, {justOne: <boolean>, writeConcern: <document>, collation: <document>})
        - db.collection.deleteMany()
        - db.collection.deleteOne()
### 功能
1. 索引
   - 认识：包括类型、属性
   - 特性
     1. 建索引过程会阻塞其它数据库操作
     1. ttl索引：独立线程清除。默认60s扫描一次，删除也不一定是立即删除成功
     1. 不分大小写
     1. 部分
   - 属性
     1. 单字段
     1. 复合：compound，`db.users.createIndex({name: 1, age: 1})`
     1. 多键
     1. 文本
     1. 通配符
     1. hash
     1. 2d/2dsphere/geoHaystack
   - 操作
     1. coll.listIndexes();
     1. coll.createIndex(keys, options)
        - keys：{projection:1/-1}，可指定多个创建复合索引
        - options
          1. name：索引名称
          1. unique：是否唯一索引
          1. background：是否后台方式创建索引
          1. sparse：不存在字段是否无索引，无的话对应的文档查不出
          1. expireAfterSeconds：ttl索引，超时或者特定时间自动删除的索引，只适用单字段索引
          1. weights：权重值，相对于其他索引的权重
          1. v：版本号
          1. default_language/language_override：对于文本索引，决定停用词、词干、词器的规则列表
     1. coll.createIndexes()
     1. coll.dropIndex()
     1. coll.dropIndexes()
   - 查看
     1. coll.getIndexes()
     1. coll.totalIndexSize()
   - 可重试写入、读取
     1. 认识：在遇到网络错误或在副本集或分片群集中找不到正常的主操作时自动重试一次。不适用单节点，需要支持文档级锁定的存储引擎，v3.6
   - 读写关注
     1.读关注认识：允许你控制从副本集和分片集群读取数据的一致性和隔离性
     1.读关注级别
        - local
        - available
        - majority
        - linearizable
        - snapshot：仅用于多文档事务
     1. 写关注认识：写操作的确认级别
        - 多文档事务可以在事务级别设置写关注
1. 事务
   - session.start_transaction()
   - session.commit_transaction()
1. 聚合
   - 分类
     1. aggregate：聚合管道，以数据处理管道的概念为蓝本的。文档进入多阶段管道，将文档转换为聚合结果，用于处理、计算数据，并返回处理结果
        - `db.mycol.aggregate([{$group : {_id : "$by_user", num_tutorial : {$sum : 1}}}])`
        - 类似：`select by_user, count(*) from mycol group by by_user`
        - 先match再group管道实例：`db.coll.aggregate( [{ $match : { score : { $gt : 70} } },{ $group: { _id: null, count: { $sum: 1}}}]);`
     1. map-reduce
     1. 单一目的聚合方法
1. 视图
   - 认识
     1. 是只读的，不能重命名
     1. 使用其上游集合的索引
     1. 不能指定$natural排序
   - 操作
     1. `db.createView(<view>, <source>, <pipeline>, <collation>)`
     1. `db.collection.find()/findOne()/aggregate()/count()/distinct()`
1. GeoJSON
   - 认识：存储地理空间数据，可以提供查询范围内的东西的能力
     1. 有效的经度值在-180 180
     1. 有效的纬度值在-90 90
### 运维
1. 认识
   - mongod是守护进程，mongo是客户端
   - mongod进程收到SIGINT信号或者SIGTERM信号，会关闭打开连接、内存数据强制刷到磁盘、等待当前操作执行完毕、安全停止。不能kill -9，会数据丢失、数据文件损坏
1. 基础操作
   - 开关
     1. 命令行方式：`mongod --dbpath= --logpath=/xx.log --logappend --port=27017 --fork --bind_ip_all`
        - --fork：后台运行
        - --auth：是否验证权限
        - --bind_ip/bind_ip_all：限制访问ip
        - --shutdown：关闭
        - --replSet：设置副本集节点名称
        - --chunkSize：指定chunk大小，单位MB
     1. 配置文件方式：`mongod -f xx.conf --shutdown`
        ```conf
        vim xx.conf
        dbpath=
        logpath=
        port=27017
        ```
     1. 关闭：`db.shutdownServer()`
     1. 重启：`mongo restart`
   - 连接：`mongo`、mongo shell
1. 数据导出导入
   - 导出：`mongodump -h dbhost -d dbname -o dbdirectory`
   - 导入：`mongorestore -h <hostname><:port> -d dbname <path>`
1. 监控
   - 数据库
     1. totalSize：集合中索引+数据压缩存储之后的大小
     1. storageSize：集合中数据压缩存储的大小
1. 安全
   - 认识：权限管理，默认没有权限
   - 权限分类
     1. Read/readWrite：读写
     1. dbAdmin：执行管理函数、索引管理、查看统计、访问system.profile
     1. userAdmin：管理用户，允许用户向system.users集合写入
     1. admin库中
        - root：只在admin数据库中可用。超级账号，超级权限
        - readAnyDatabase/readWriteAnyDatabase：所有数据库读写权限
        - userAdminAnyDatabase/dbAdminAnyDatabase：所有数据库管理权限
        - clusterAdmin：分片和副本集相关函数的管理权限
   - 操作
     1. `db.createUser({user:"root", pwd:"root", roles:[{role:"root",db:"admin"}]})`：创建用户
     1. `db.dropUser("xx")`：删除
     1. `db.auth("name","secret")`：验证用户
   - 启用权限：在conf中`authorization: enabled`，然后重启
### 设计
1. 变更流：可订阅collection、db、sh、rs的数据变更
1. 存储引擎：WiredTiger、内存
1. oplog.rs：mongoDB的操作日志文件，如记录了文档更新日志，记录了要同步给从的数据，如果从追不上oplog，就得重新初始化
### 架构
1. 架构
   - ReplicaSet：副本集，将数据同步在多个节点中。一主n从架构，一般为三节点架构，oplog用于同步。只能通过主节点将Mongo服务添加到副本集中
     1. 特点
        - 一写多读：多读性能强，所有写入在主节点
        - 自动故障转移：可用性高
        - 自动恢复
     1. 缺点
        - 只有一写，性能不够
        - 延迟敏感的读只能在主节点
        - 单副本集最多12节点
        - 本地磁盘空间有限
     1. 组成
        - primary
        - secondary：备节点
        - hidden：仲裁节点
     1. 命令
        - rs.initiate()：启动副本集
        - rs.add("xx.com:27017")：添加副本集成员
        - db.isMaster()：是否主节点
        - rs.conf()
        - rs.status()
   - Sharding：分片，用于数据大量增长，v3.4
     1. 组成
        - mongos：代理服务，多副本作高可用，是MongoDB分片配置的路由服务,它处理来自应用程序层的查询,并确定分片集群中此数据的位置。用于分片集群的控制器和查询路由器.分片将数据集分区为不连续的部分
        - configServer：配置服务器，存储整个ClusterMetadata，其中包括chunk数据。多副本作高可用
        - shardN：数据节点，用副本集作高可用
     1. 协议：MongoDB协议、DynamoDB协议
     1. 方法
        - addshard
        - enablesharding：设置分片存储的数据库
### wiki
1. bson：json的轻量化二进制格式，BSON文件大小限制16M
   - 数据类型
     1. Null：用于创建空值
     1. Boolean：布尔值，用于存储布尔值（真/假）
     1. Integer：整型数值，用于存储数值，根据服务器分为32位或64位
     1. Double：双精度浮点值
     1. String：字符串

     1. Timestamp：时间戳
     1. Date：日期时间，UNIX时间格式

     1. Array：用于将数组或列表或多个值存储为一个键
     1. Object ID：对象id
     1. Object：用于内嵌文档

     1. Binary Data：二进制数据，用于存储二进制数据
     1. Regular expression：正则表达式类型，用于存储正则表达式
     1. Code：代码类型，用于在文档中存储js代码
     1. Symbol：符号，该数据类型基本上等同于字符串类型，但不同的是，它一般用于采用特殊符号类型的语言
     1. Min/Max keys：将一个值与BSON元素的最低值和最高值相对比
1. gist
   - 插入一万条数据：`for(i=0;i<10000;i++){ db.log.insert({"uid":i,"name":"mongodb","age":6,"date":new Date()});}`
1. releaseNote
   - 3.2
     1. 新增insertOne/insertMany等
   - 4.0
     1. 跨文档事务支持
     1. 读性能大幅扩展：借助事务，备节点不再因为同步日志而阻塞读取请求
     1. 新增分片40%迁移速度提升：
   - 4.2
     1. 分布式事务：采用二段提交方式，保证分片集群事务的ACID特性
     1. 可重试读：提供弱网环境下自动重试能力
     1. 通配符索引：支持创建通配符索引
     1. 字段级加密：驱动层面支持字段级加密，避免全库加密
     1. 物化视图：可缓存计算结果
   - 6.0
   - 7.0
1. 历史
   - 07年：由10gen团队所发展
   - 09年：首度推出
   - 12年：2.1
   - 19年8月：4.2