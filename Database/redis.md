#### 认识和使用
1. 理解：开源使用ANSI C编写，基于内存，可持久化的日志型、Key-Value数据库。对关系型数据库起到补充作用，多客户端支持。常用作缓存、数据库、消息中间件
   - 速度快，性能高：读11万次/秒，写8万次/秒
   - 多数据结构，发布/订阅模式，key过期
   - 原子操作、事务、数据持久化、Lua脚本、LRU收回
   - 主从同步、Sentinel提供高可用，Cluster提供自动分区
1. 数据类型
   - string：字符串，键值对类型，二进制安全，意味着可以包含任意对象(比如一个图片的内容)，最大512MB
     1. set/get/del/exists/append/rename/expire/pexpire/ttl/pttl
        - 2.6版本开始，set命令增加了键存在与否的判断和过期时间的设置
     1. 利用INCR命令簇（INCR, DECR, INCRBY）来把字符串当作原子计数器使用，incr提供了原子操作
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
   - zset：有序集合，每个元素会关联一个double类型的分数，通过分数为成员进行排序，并且插入有序，适用于有序且不重复
     1. zadd/zrem/zrange/zrank/zcard/zcount/zscore/zscan
   - bitmaps：位图，即位的数组
   - hyperloglogs：2.8.9新增，是做基数统计的算法，即快速计算基数(集中不重复元素数量)。输入元素的数量或者体积非常非常大时，计算基数所需的空间总是固定的、很小的。每个HyperLogLog键只需要花费12KB内存，就可以计算接近2^64个不同元素的基数
     1. pfadd/pfcount/pfmerge
   - geospatial：地理空间，索引半径查找
1. 功能
   - 超时：expire，设置超时时间，超时后不删除，只有对值进行改变才会删除，过期是不可靠的
    ```
    SET mykey "Hello"
    EXPIRE mykey 10
    ```
   - 发布订阅：pub/sub，一种消息通信模式，发送者(pub)发送消息，订阅者(sub)接收消息，是原子的
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
#### 应用
1. 命令
   - 服务器命令
     1. info：服务器信息
     1. save：异步保存数据到硬盘
     1. bgsave：后台异步保存数据到磁盘
     1. client list：客户端列表
     1. keys：查看所有keys
     1. dbsize：key的数量
     1. type：查看key类型
     1. flushall：删除所有数据库的所有key
     1. flushdb：删除当前数据库的所有key
     1. debug segfault：让redis崩溃
     1. monitor：实时打印接收到的命令，调试用
     1. slowlog subcommand：管理慢日志
     1. sync：用于复制功能的内部
   - ping：查看是否运行
   - select index：切换到指定数据库，更像命名空间，隔离key名冲突，索引号只能是数字不能自定义，可以设置数据库数量，以0开始，默认使用0
   - auth password：验证密码
   - echo string：打印字符串
1. 脚本：eval，执行lua脚本，内嵌lua环境
   - eval script numkeys key：使用解释器执行脚本
   - script load script：缓冲脚本
   - script exists script：脚本是否存在
   - evalsha sha1 numkeys key：根据给定sha1码执行缓从的脚本
   - script flush：移除缓冲脚本
   - script kill：杀死脚本
1. 锁
   - set nx ex val lua：排他，过期，一段时间内唯一的特性
     1. 存在执行时间超出锁时间，造成同时拥有锁，这就是setnx陷阱
     1. 删除锁时，锁已过期，这个间隔他人拿到了锁，会误删他人锁：利用lua脚本，拿锁和删锁原子操作，解决了此问题
   - RedLock：分布式锁，watch，multi事务
```
do {
    $microtime = microtime(true) * 1000;
    $microtimeout = $microtime+$timeout+1;
    
    $isLock = $redis->setnx('lock.count', $microtimeout);                   // 上锁
    if (!$isLock) {
        $getTime = $redis->get('lock.count');
        if ($getTime > $microtime) {
            usleep(5000);                                                   // 睡眠 降低抢锁频率　缓解redis压力
            continue;                                                       // 未超时继续等待
        }
        
        $previousTime = $redis->getset('lock.count', $microtimeout);        // 超时,抢锁,可能有几毫秒级时间差可忽略
        if ((int)$previousTime < $microtime) {
            break;                                                          // 已获得锁
        }
    }
} while (!$isLock);
$count = $redis->get('count')? : 0;
```
1. 集群
   - TwemProxy
   - Codis
   - pika
#### 运维
1. 默认端口6379
1. 安装和启动
   - 启动server：`src/redis-server|redis-server.exe`
   - 停止server：`src/redis-cli|redis-server.exe shutdown`
   - 连接本地server：`src/redis-cli`
   - 连接远程server：`src/redis-cli|redis-cli.exe -h host -p port -a password`
1. 配置
   - 配置操作：config get/set/rewrite/ */configName configValue
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
     1. 主从配置：从机的配置文件中指定slaveof参数为主机的ip和port即可
        - slaveof <masterip> <masterport>
        - masterauth <master-password>
1. 持久化
   - RDB
   - AOF：fsync
1. 安全
   - 获得/设置密码：config get/set requirepass
   - 检验密码是否正确：auth password
1. 性能测试
   - redis-benchmark [option] [option value]
     1. -h/-p：地址端口
     1. -s：指定socket
     1. -c：并发连接数
     1. -n：请求数
     1. -d：字节形式指定set/get大小
     1. -k：1=keep alive 0=reconnect
1. 备份恢复
   - 备份：save/bgsave，产生dump.rdb文件，即备份成功
   - 恢复：将dump.rdb文件放到redis目录并启动即可，config get dir获得目录
1. 集群配置
   - 数据分片：hash slot，引入哈希槽和节点的对应关系确定key的位置，存放哈希槽的Bitmap通过Gossip协议，在结点之间传递
1. 哨兵机制：sentinel，做redis的存活性检测，提供高可用
#### 原理
1. 复杂的数据结构在内存中操作非常简单，redis可以做很复杂的操作
1. 磁盘中是紧凑追加方式存在，不存在随机io
1. 达到最大内存后，Redis会先尝试清除已到期或即将到期的Key，当此方法处理后，仍然到达最大内存设置，将无法再进行写入操作，但仍然可以进行读取操作。Redis新的vm机制，会把Key存放内存，Value会存放在swap区
1. 虚拟内存机制：VM机制将数据分页存放，由Redis将访问量较少的页即冷数据swap到磁盘上，访问多的页面由磁盘自动换出到内存中，突破了物理内存的限制
1. 连接原理：Redis通过监听一个TCP端口或者Unix socket的方式来接收来自客户端的连接，当一个连接建立后，Redis内部会进行以下一些操作
   - 首先，客户端socket会被设置为非阻塞模式，因为Redis在网络事件处理上采用的是非阻塞多路复用模型
   - 然后为这个socket设置TCP_NODELAY属性，禁用Nagle算法
   - 然后创建一个可读的文件事件用于监听这个客户端socket的数据发送
1. redis协议：流言协议
1. 主从同步原理：主准备所有的命令，利用redis协议，发送到从，执行并且放入到内存中
1. 哨兵机制：通过多个sentinel的订阅和发布，实现对主的监视
1. 探索方向：中文网的知识点梳理掌握（主要每个点都掌握，否则过不了关），各个文章的配置和讲解，云栖论坛的相关帖子搜索
#### wiki
1. 数据类型应用场景
   - string：可持久化的缓存，如session_id为key的session，二进制安全，图片、文件什么的，原子计数器做粉丝数、关注数、ip封锁次数啥的
   - hash：存对象数据，如用户基本信息，直接更新即可
   - list：消息排行，消息队列，日志收集器，配合发布订阅
   - set：做不重复的集合，存不重复用户名啦、每日投票一次啦
   - zset：有序的不重复集合，如热门内容的排序，只需修改score，排行榜
1. Redis是单进程单线程的网络模型，命令是一个接着一个执行的，不存在并行执行的情况
   - 用的是epoll,poll,select网络模型
   - 单线程处理所有的客户端连接请求，命令读写请求
   - 2个命令组合起来才算是完成一个业务，但是2个命令组合起来就不具备原子性，所有在两个命令之间其他客户端会出现读写脏数据的情况
1. list的安全性
   - 不安全队列：一旦pop出去客户端崩溃，消息丢失
   - 安全队列：rpoplpush，弄个备份队列，数据丢了再去备份队列取一下
1. Memcache：高性能分布式内存对象缓存系统，内存里维护一个统一的巨大的hash表，能够存储图像等数据
1. 阿里云Redis集群版
   - 表现
     1. 突破百万QPS，最好性能512G内存、最大连载数320000、最大吞吐1536M
     1. 功能支持：slots槽数
   - 组成
     1. 代理服务器：多台代理服务器，负载均衡、故障转移
     1. 分片服务器：多台分片服务器，双副本高可用架构，主动主备切换
     1. 配置服务器：存储集群配置信息和分区策略，双副本高可用架构
   - 双机热备是指双副本吗？双副本是指两台备份机器吗？
1. 数据库缓存一致性方案
   - key过期，mysql更新不更新redis
     1. 开发成本低，管理成本低
     1. 不一致时间很长
   - key过期，mysql更新时，更新redis
     1. 延迟更小
     1. 损耗双倍资源
   - key过期，消息队列异步更新redis
   - key过期，从库订阅binlog来更新redis