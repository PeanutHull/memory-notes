#### Redis
1. 理解：是开源使用ANSI C语言编写的，可基于内存亦可持久化的日志型、Key-Value数据库。对关系型数据库起到补充作用，多客户端支持。常用作缓存、数据库、消息中间件
   - 速度快，性能高
   - 实现了多数据结构，发布/订阅模式，key过期
   - 支持数据持久化、原子操作、主从同步
1. 特性
   - 原子性：单个操作都是原子性的，多个操作支持事务
   - 数据持久化：会周期性的把数据写入硬盘
     1. 数据存储方式：内存、磁盘、文件
   - 主从同步：实现了数据备份
1. 数据类型
   - string：字符串，键值对类型
   - list：双向链表，用于push/pop，获取范围值
   - sets：集合，添加/删除，求交并差，集合元素具有唯一性
   - zset：有序集合，类似集合，加入了顺序属性的集合，成员唯一性，分数可重复
   - dict/hashes：哈希类型键值对的集合，用来表示对象
1. 事务
   - 概念：一组命令在一个步骤里执行，具有原子性
   - 用法
    ```
    MULTI
    命令......
    EXEC
    ```
1. 使用
   - set/get/del
   - lpush/lpop/lrange
   - sadd/remove/smembers
   - zadd/zrange
   - hmset/hgetall
   - subscribe/publish
   - 发布/订阅
    ```
    订阅：
    subscribe channelName
    发布：
    publish channelName value
    ```
#### 应用
1. 安装和启动
   - windows
     1. 启动server：`redis-server.exe redis.conf`
        ```
        // 将redis注册为服务，开机启动
        redis-server --service-install  --service-name redis6379 --prot 6379
        ```
     1. 启动客户端：`redis-cli.exe -h 127.0.0.1 -p 6379`
1. 主从配置：master-slave，从机的配置文件中指定slaveof参数为主机的ip和port即可
1. sentinel：哨兵机制，做redis的存活性检测
1. 脚本、连接、备份：save、管道传输、分区
1. 配置：存储配置：save seconds updates、appendonly、appendfsync
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
    // String
    $redis->set("String-name", "Redis String");
    $redis->get("String-name", "Redis String");
    // list
    $redis->lpush("tutorial-list", "Redis");
    $redis->lrange("tutorial-list", 0 ,5);
    // 一种消息通信模式，关键词：通道channel、发送者pub、接收者sub、消息路由转发角色
    // 订阅，处于监听的模式，此时除了SUBSCRIBE， PSUBSCRIBE，UNSUBSCRIBE，PUNSUBSCRIBE这4条命令之外的所有其它命令都不能用
    $channel = 'sms';  // channel
    $redis->subscribe(array($channel), 'callback');
    //
    function callback($redis, $channel, $message) {
        var_dump($message);
        exit;
    }
    // 发布
    $redis->publish('channel', 'Hello Word');
    // 循环处理队列数据
    // 1.当队列里无数据时，程序自动结束，关键词：false、while
    // 2.采用队列处理，堆栈保存的策略，关键词：队列REDIS_KEY_ORDERED、堆栈REDIS_KEY_ORDERED_ACK
    while (false !== $order_id = $redis->rpoplpush(C('REDIS_KEY_ORDERED'), C('REDIS_KEY_ORDERED_ACK'))) {
        $this->handle_order($order_id);
        $redis->lpop(C('REDIS_KEY_ORDERED_ACK'));
    }
    ```
