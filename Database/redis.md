#### 认识和使用
1. 理解：是开源使用ANSI C语言编写的，可基于内存亦可持久化的日志型、Key-Value数据库。对关系型数据库起到补充作用，多客户端支持。常用作缓存、数据库、消息中间件。端口6379
   - 速度快，性能高
   - 实现了多数据结构，发布/订阅模式，key过期
   - 支持原子操作、数据持久化、Lua脚本、LRU收回、事务、主从同步
   - Sentinel提供高可用，Cluster提供自动分区
1. 特性
   - 性能好：读11万次/秒，写8万次/秒
   - 原子性：单个操作都是原子性的，多个操作支持事务
   - 数据持久化：会周期性的把数据写入硬盘，有着不同的级别
     1. 数据存储方式：内存、磁盘、文件
   - 主从同步
     1. 实现了数据备份
1. 数据类型
   - string：字符串，键值对类型，二进制安全，意味着可以包含任意对象(比如一个图片的内容)，最大512MB
     1. set/get/del/exists/append/rename/expire/pexpire/ttl/pttl
     1. 利用INCR命令簇（INCR, DECR, INCRBY）来把字符串当作原子计数器使用
     1. 将字符串作为GETRANGE 和 SETRANGE的随机访问向量
     1. 在小空间里编码大量数据，或者使用 GETBIT 和 SETBIT创建一个Redis支持的Bloom过滤器
   - hash：哈希类型键值对的集合，用来表示对象，最多40亿对
     1. hset/hmset/hget/hmget/hgetall
     1. hkeys/hvals/hlen/hscan
     1. hdel/hexists
   - list：列表，双向链表，按照插入顺序排序，最多40亿个，访问中间的数据时间复杂度为O(N)
     1. lpush/lpop/lrange/rpush/rpop/rpoplpush
     1. blpop/brpop/brpoplpush
     1. linsert/lrem/lset/lindex/ltrim/llen
   - set：无序集合，是string类型的集合，通过hash表实现，无论多少数据添加/删除/查找的复杂度都是O(1)。成员唯一性
     1. sadd/spop/srem/smove/scard/smembers
     1. sdiff/sinter/sunion/sscan
     1. sismember
   - zset：有序集合，每个元素会关联一个double类型的分数，通过分数为成员进行排序，成员唯一性
     1. zadd/zrem/zrange/zrank/zcard/zcount/zscore/zscan
   - bitmaps：位图，即位的数组
   - hyperloglogs：2.8.9新增，是做基数统计的算法，即快速计算基数(集中不重复元素数量)。输入元素的数量或者体积非常非常大时，计算基数所需的空间总是固定的、很小的。每个HyperLogLog键只需要花费12KB内存，就可以计算接近2^64个不同元素的基数
     1. pfadd/pfcount/pfmerge
   - geospatial：地理空间，索引半径查找
1. 其他功能
   - 超时：expire，设置超时时间，超时后不删除，只有对值进行改变才会删除
        ```
        SET mykey "Hello"
        EXPIRE mykey 10
        ```
   - 发布订阅：pub/sub，一种消息通信模式，发送者(pub)发送消息，订阅者(sub)接收消息
     1. pubsub：查看订阅和发布系统状态
     1. subscribe：订阅一个或多个，unsubscribe退订。psubscribe/punsubscribe用于给定模式的频道，即使用通配符啥的
     1. publish：发布
   - 事务：一组命令在一个步骤里执行，具有原子性
     1. multi：开始
     1. exec：执行
     1. discard：取消
     1. watch：监视一个多个key，值被改变则取消事务
     1. unwatch：取消监视
   - 管道
     1. 理解：pipelining，通常客户端请求都是socket阻塞的，管道是请求未响应时继续发送请求，然后一次性读取所有响应，节省了多次的网络传输时间
     1. 好处：减少了往返时延，提高了效率，提高了服务端的利用率
     1. 使用
        ```
        # php，开始和结束
        $redis->pipeline();
        $redis->exec();
        ```
   - 分区
     1. 理解：即分割数据到多个Redis实例的过程，每个实例只保存key的一个子集。
     1. 优点：提高容量，扩展计算能力和带宽
     1. 缺点
        - 不支持多个key同时操作，事务中也不行
        - 多实体数据库维护复杂，容量调整复杂，用presharding解决
     1. 分区类型
        - 范围分区：不同范围放到不同实例中，需要维护范围表
        - hash分区：使用crc32将key转为数字，然后取模(模为实例数量)确定实例
     1. 自动分区：Cluster
   - 命令
     1. 服务器命令
        - info：服务器信息
        - save：异步保存数据到硬盘
        - bgsave：后台异步保存数据到磁盘
        - client list：客户端列表
        - dbsize：key的数量
        - flushall：删除所有数据库的所有key
        - flushdb：删除当前数据库的所有key
        - debug segfault：让redis崩溃
        - monitor：实时打印接收到的命令，调试用
        - slowlog subcommand：管理慢日志
        - sync：用于复制功能的内部
     1. ping：查看是否运行
     1. select index：切换数据库
     1. auth password：验证密码
     1. echo string：打印字符串
   - 脚本：eval，执行lua脚本，内嵌lua环境
     1. eval script numkeys key：使用解释器执行脚本
     1. script load script：缓冲脚本
     1. script exists script：脚本是否存在
     1. evalsha sha1 numkeys key：根据给定sha1码执行缓从的脚本
     1. script flush：移除缓冲脚本
     1. script kill：杀死脚本
1. 配置
   - 操作配置：config get/set/rewrite/ */configName configValue
   - 配置分类
     1. 常规
        - port/bind/timeout：超时断掉连接，为0不断
        - requirepass foobared：密码
        - maxclients 128
        - maxmemory <bytes>：内存限制
        - include /path/to/local.conf：子配置文件
     1. 日志
        - loglevel verbose：debug、verbose、notice、warning
        - logfile stdout：日志记录方式，默认标准输出。守护进程方式运行时日志发送给/dev/null
        - appendonly no：是否每次更新数据后进行日志记录，本身按照save条件来同步，断电可能导致数据丢失
        - appendfilename appendonly.aof：更新日志文件名
        - appendfsync everysec：更新日志条件，no等待系统将数据同步到磁盘(快)，always每次更新后手动调用fsync()将数据写到磁盘(慢，安全)，everysec每秒一次(折衷)
     1. 数据
        - dbfilename dump.rdb：本地数据库名
        - databases 16：数据库数量
        - dir ./：数据库目录
        - save <seconds> <changes>：n时间内，n次更新操作，就将数据同步到数据文件
        - rdbcompression yes：是否压缩数据，关闭节约cpu，但是文件变的巨大
     1. 内存
        - vm-enabled no：是否启用虚拟内存机制
        - vm-swap-file /tmp/redis.swap：虚拟内存文件路径，多个Redis实例不可共享
        - vm-max-memory 0/vm-page-size 32/vm-pages 134217728/vm-max-threads 4
     1. 守护进程的方式
        - daemonize no：yes
        - pidfile /var/run/redis.pid：pid位置
     1. 主从配置
        - slaveof <masterip> <masterport>
        - masterauth <master-password>
1. 性能测试
   - redis-benchmark [option] [option value]
     1. -h/-p：地址端口
     1. -s：指定socket
     1. -c：并发连接数
     1. -n：请求数
     1. -d：字节形式指定set/get大小
     1. -k：1=keep alive 0=reconnect
1. 主从配置：master-slave，从机的配置文件中指定slaveof参数为主机的ip和port即可
1. Redis集群
#### 运维
1. 安装和启动
   - 启动server：`src/redis-server|redis-server.exe`
   - 停止server：`src/redis-cli|redis-server.exe shutdown`
   - 连接本地server：`src/redis-cli`
   - 连接远程server：`src/redis-cli|redis-cli.exe -h host -p port -a password`
1. 哨兵机制：sentinel，做redis的存活性检测，提供高可用
1. 持久化
   - RDB
   - AOF：fsync
1. 备份恢复
   - 备份：save/bgsave，产生dump.rdb文件，即备份成功
   - 恢复：将dump.rdb文件放到redis目录并启动即可，config get dir获得目录
1. 安全
   - 获得/设置密码：config get/set requirepass
   - 检验密码是否正确：auth password
#### 原理
1. 复杂的数据结构在内存中操作非常简单，redis可以做很复杂的操作
1. 磁盘中是紧凑追加方式存在，不存在随机io
1. 达到最大内存后，Redis会先尝试清除已到期或即将到期的Key，当此方法处理后，仍然到达最大内存设置，将无法再进行写入操作，但仍然可以进行读取操作。Redis新的vm机制，会把Key存放内存，Value会存放在swap区
1. 虚拟内存机制：VM机制将数据分页存放，由Redis将访问量较少的页即冷数据swap到磁盘上，访问多的页面由磁盘自动换出到内存中
1. 连接原理：Redis通过监听一个TCP端口或者Unix socket的方式来接收来自客户端的连接，当一个连接建立后，Redis内部会进行以下一些操作
   - 首先，客户端socket会被设置为非阻塞模式，因为Redis在网络事件处理上采用的是非阻塞多路复用模型
   - 然后为这个socket设置TCP_NODELAY属性，禁用Nagle算法
   - 然后创建一个可读的文件事件用于监听这个客户端socket的数据发送
1. redis协议：流言协议
1. 主从同步原理：主准备所有的命令，利用redis协议，发送到从，执行并且放入到内存中
1. 哨兵机制：通过多个sentinel的订阅和发布，实现对主的监视
1. 探索方向：中文网的知识点梳理掌握（主要每个点都掌握，否则过不了关），各个文章的配置和讲解，云栖论坛的相关帖子搜索
#### 应用
1. 主从配置
1. 集群配置
1. 数据测试，定性处理指标
#### wiki
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
1. 阿里云Redis集群版
   - 表现
     1. 突破百万QPS，最好性能512G内存、最大连载数320000、最大吞吐1536M
     1. 功能支持：mset/mget、slots槽数
   - 特点
     1. 统一域名访问
     1. 存储空间可扩展，容量大
     1. 服务高可用
     1. 专业监控和数据管理平台，包括：cpu、连接数、磁盘空间利用，可视化运维
   - 组成
     1. 代理服务器：多台代理服务器，负载均衡、故障转移
     1. 分片服务器：多台分片服务器，双副本高可用架构，主动主备切换
     1. 配置服务器：存储集群配置信息和分区策略，双副本高可用架构
   - 整套解决方案
     1. 客户端
     1. slb负载均衡
     1. 服务集群
        - 代理服务器
        - 分片服务器：主节点、备节点
        - 配置服务器
        - 运行/数据监控
   - 疑问
     1. 双机热备是指双副本吗？双副本是指两台备份机器吗？