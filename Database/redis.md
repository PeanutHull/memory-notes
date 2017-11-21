#### Redis
1. 理解：是开源使用ANSI C语言编写的，可基于内存亦可持久化的日志型、Key-Value数据库。对关系型数据库起到补充作用，多客户端支持。常用作缓存、数据库、消息中间件
   - 速度快，性能高
   - 实现了多数据结构，发布/订阅模式，key过期
   - 支持数据持久化、原子操作、Lua脚本、LRU收回、事务、主从同步
1. 特性
   - 原子性：单个操作都是原子性的，多个操作支持事务
   - 数据持久化：会周期性的把数据写入硬盘，有着不同的级别
     1. 数据存储方式：内存、磁盘、文件
   - 主从同步
     1. 实现了数据备份
1. 数据类型
   - string：字符串，键值对类型
   - list：双向链表，用于push/pop，获取范围值
   - sets：集合，添加/删除，求交并差，成员唯一性
   - zset：有序集合，成员唯一性，分数可重复
   - dict/hashes：哈希类型键值对的集合，用来表示对象
   - 位图
   - hyperloglogs
1. 事务
   - 概念：一组命令在一个步骤里执行，具有原子性
   - 用法
    ```
    MULTI
    EXEC
    ```
1. 使用
   - set/get/del
   - lpush/lpop/lrange
   - sadd/remove/smembers
   - zadd/zrange
   - hmset/hgetall
   - subscribe/publish
   - 发布/订阅：一种消息通信模式，SUBSCRIBE，PSUBSCRIBE，UNSUBSCRIBE，PUNSUBSCRIBE
    ```
    subscribe channelName           # 订阅
    publish channelName value       # 发布
    ```
1. 脚本、连接、备份：save、管道传输、分区
1. 配置：存储配置：save seconds updates、appendonly、appendfsync
#### 应用
1. 主从配置：master-slave，从机的配置文件中指定slaveof参数为主机的ip和port即可
1. 哨兵机制：sentinel，做redis的存活性检测，提供高可用
1. 自动分区：Cluster
#### wiki
1. 安装和启动
   - unit
     1. 启动server：`src/redis-server`
     1. 启动cli：`src/redis-cli`
     1. 停止server：`src/redis-cli shutdown`
   - windows
     1. 启动server：`redis-server.exe redis.conf`
        ```
        // 将redis注册为服务，开机启动
        redis-server --service-install  --service-name redis6379 --prot 6379
        ```
     1. 启动cli：`redis-cli.exe -h 127.0.0.1 -p 6379`
1. php和redis
   - php扩展：PRedis、phpredis(c扩展)
   - windows下安装php的redis扩展
    ```
    // 下载：php_redis.dll、php_igbinary.dll————注意ts(线程安全)和nts的区别
    // 添加配置文件
    extension=php_igbinary.dll
    extension=php_redis.dll
    ```
   - 连接/测试
    ```php
    $redis = new Redis();
    $redis->connect('127.0.0.1',6379);
    $redis->ping(); // 返回+PONG
    $redis->set/get();                      # String
    $redis->lpush/lrange();                 # list
    $redis->subscribe/publish();            # 发布订阅
    ```
