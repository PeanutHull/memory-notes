### 认识
1. 理解：开源、基于内存、可持久化的日志型的Key-Value非关系型数据库，对关系型数据库起到补充作用。常用作缓存、数据库、消息中间件，使用ANSI C编写
   - 速度快，性能高：读11万次/秒，写8万次/秒
   - 数据结构丰富
   - 功能多，key过期，发布/订阅模式，事务、Lua脚本
   - 所有操作都是原子的
   - 数据持久化、LRU回收
   - 主从同步、Sentinel提供高可用，Cluster提供自动分区
### 组成
1. 数据类型
   - string
     1. 认识：字符串，键值对类型、二进制安全的字符串，意味着可包含任意对象(如一个图片)，最大512MB
        - 自动扩展大小、数据类型自动转换
     1. 命令
        - set/get、mset/mget、setbit/getbit：单个、多个、位操作，按照偏移量设置位(可做Bloom过滤器)
          1. set
             - EX：过期时间秒
             - PX：过期时间毫秒
             - NX：不存在才设置
             - XX：存在才设置
        - setex/psetex、setnx/msetnx、setrange/getrange：设置过期时间、存在才设置、按照偏移量设置
        - incr/incrby/incrbyfloat、decr/decrby：加/减、一/N，可当原子计数器
        - getset、strlen、append：设置并返回旧值、长度、追加到末尾
   - list
     1. 认识：双向链表，首尾插入的按照插入顺序排序的字符串列表，访问中间的时间复杂度为O(N)，最多40亿个(2^232-1)
        - 存储消耗要高于单个字符串，但是可以部分获取，不用像string整个取出来再解码
     1. 命令
        - lpush/rpush/lpop/rpop/rpoplpush/lpushx/rpushx：压入、弹出、存在时才压入
        - blpop/brpop/brpoplpush：支持指定最大秒数的阻塞式弹出数据，单位秒
        - lset/linsert：指定位置的设置、前/后插入元素
        - lrange/lindex/llen：范围查看、指定位置查看、查看长度
          1. `lrange xx 0 -1`：查看所有，-1表示从尾部开始
        - lrem/ltrim：删除、指定范围删除
   - hash
     1. 认识：哈希，哈希类型的键值对集合，field为string类型，可存储对象，最多40亿对
        - 存储消耗高于字符串
     1. 命令
        - hset/hmset/hsetnx：设置
        - hget/hmget/hgetall：获取
        - hkeys/hvals/hlen/hscan：键值对数量、迭代键值对
        - hincrby/hincrbyfloat：单个key可以计数，加一
        - hdel/hexists：删除n个字段、是否存在某个字段
   - set
     1. 认识：无序集合，string类型的成员唯一的无序集合。通过hash table实现，所有操作复杂度都是O(1)
     1. 命令
        - sadd/spop/smove/srem：移除某一随机元素、移到另一集合、移除n个
        - sdiff/sdiffstone/sinter/sinterstone/sunion/sunionstone：求差集、求交集、求并集。[并储存到另一个集合]
        - scard/sismember/smembers/sscan：成员数量、是否成员、返回所有成员、迭代元素
   - zset
     1. 认识：有序集合，string类型的成员唯一的有序集合，每个元素关联一个double类型的分数
        - 成员唯一，分数可重复
        - 可通过分数进行排序，通过哈希表实现，最多40亿个(2^232-1)
        - 适用于有序且不重复
     1. 命令
        - zadd/zrem/zremrangebylex/zremrangebyscore/zremrangebyrank
        - zcard/zcount/zlexcount/zscan：成员数、指定分数区间的成员数、指定字典区间的成员数
        - zrange/zrangebylex/zrangebyscore：通过索引区间、字典区间、分数返回成员
        - zrevrange/zrevrangebyscore/zrevrank：通过索引、分数返回指定区间成员、返回排名。分数都是从高到底
        - zscore/zrank：返回分数值、返回指定成员索引
        - zincrby：已存在的score值增量加increment，不存在则添加
        - zinterstore/zunionstore：计算交并集
   - HyperLogLog
     1. 认识：基数统计的算法(集中不重复元素数量)
        - 输入元素数量非常大时，计算基数所需的空间总是固定的、很小的。每个HyperLogLog键只需要花费12KB内存，就可以计算接近2^64个不同元素的基数
        - 只计算基数，不储存输入元素
        - 比如数据集{1,3,5,7,5,7,8}，那么基数集为{1,3,5,7,8}, 基数(不重复元素数量)为5
     1. 命令
        - pfadd/pfcount/pfmerge：添加、返回基数估算值、合并
   - geospatial：地理空间，索引半径查找，如附近的人
   - bitmaps
     1. 认识：位图，即位的数组，用位可以表示两种情况，节省存储
        - 其实就是普通的字符串，也就是byte数组，可以用get/set，也可以用getbit/setbit看成「位数组」来处理
     1. 操作：「零存整取」、「零存零取」、「整存零取」都行，「零存」使用setbit对位值进行逐个设置，「整存」使用字符串一次性填充所有位数组
1. 数据类型的适用场景
   - string：可持久化的缓存，如session_id为key的session，二进制安全，图片、文件什么的，原子计数器做粉丝数、关注数、ip封锁次数啥的
   - list：消息排行，消息队列，日志收集器，配合发布订阅
     1. 队列的安全性：单个队列一旦pop出去客户端崩溃，消息丢失，利用rpoplpush弄个备份队列，数据丢了再去备份队列取一下
   - hash：存对象数据，如用户基本信息，直接更新即可
   - set：做不重复的集合，存不重复用户名啦、每日投票一次啦
   - zset：有序的不重复集合，如热门内容的排序，只需修改score，排行榜
1. key
   - 库
     1. select index：切换库，更像命名空间，隔离key名冲突。索引号只能是数字不能自定义，可设置数量，开始和默认是0
     1. move：移动key到某个库中
   - 查看
     1. dbsize：key的数量
     1. keys：查找符合给定模式的key
     1. exists：是否存在
     1. type：查看类型
     1. scan：会使过期的key删除，带来内存占用的下降
     1. sort by xx*->xx desc get xx*->xx get # store xx：对队列、集合按照某些规则排序，by可用通配符，get用于获取指定键值，store结果存储
   - 过期时间
     1. 认识
        - string在set后会清除过期时间
     1. 命令
        - expire/pexpire：[用毫秒]设置过期时间
        - expireat/pexpireat：用[毫秒]时间戳设置过期时间
        - ttl/pttl：用[毫]秒返回剩余时间，time to live
        - persist：移除过期时间
     1. 删除机制：惰性(用时判断)、定时(内部定时任务)、主动(lru删除)
   - 修改
     1. rename/renamenx：[key不存在时]重命名
     1. del
   - 其他
     1. randomkey：随机返回
     1. dump：序列化
     1. echo string：打印字符串
1. 功能
   - 管道
     1. 认识：pipeline，不直接响应，一次性发送多条命令，一次性返回所有响应。减少了多次数据往返时间，提高服务端利用率
     1. 使用
        ```php
        $redis->pipeline();
        $redis->exec();
        ```
   - 超时
     1. 认识：expire，设置超时时间，超时后不删除，只有对值进行改变才会删除，过期是不可靠的
        ```lua
        SET mykey "Hello"
        EXPIRE mykey 10
        ```
     1. 删除策略
        - 被动删除：读写时触发
        - 主动删除：后台每秒10次取出100检查是否超过25个过期，超过则继续如此处理
        - 内存超限时触发
   - 队列
     1. 可靠队列：rpoplpush，实现一定程度的可靠队列，发给client前另存到另一个队列
     1. 队列延迟：blpop/brpop阻塞读可以解决，list作队列的空队列的空轮询时进行睡眠的消息延迟问题
        - 注意闲置连接主动断开重试的处理
     1. 发布订阅
        - 认识：pub/sub，一种消息通信模式，发送者发送消息，订阅者接收消息，是原子的
        - 使用
          1. subscribe/unsubscribe/psubscribe/punsubscribe：订阅/退订n个，[给定模式(通配符等)]
          1. publish：发布
          1. pubsub：查看订阅和发布系统状态
     1. 延时队列
        - zset实现，消息到期时间为score
          1. 多线程作高可用轮询zset
          1.  zrem决定多线程唯一的属主，zrangebyscore和zrem进行lua脚本原子化操作，多线程之间争抢任务不会浪费白取一次任务
        - 实例
        ```py
        # 消费消息
        def loop():
            while True:
                values = redis.zrangebyscore("delay-queue", 0, time.time(), start=0, num=1)         # 最多取 1 条
                if not values: 
                    time.sleep(1)                                               # 延时队列空的，休息 1s
                    continue
                value = values[0]                                               # 拿第一条，也只有一条
                success = redis.zrem("delay-queue", value)                      # 从消息队列中移除该消息
                if success:                                                     # 因为有多进程并发的可能，最终只会有一个进程可以抢到消息
                    msg = json.loads(value)
                    handle_msg(msg) 
        # 添加消息
        def delay(msg):
            msg.id = str(uuid.uuid4()) # 保证 value 值唯一
            value = json.dumps(msg)
            retry_ts = time.time() + 5 # 5 秒后重试
            redis.zadd("delay-queue", retry_ts, value) 
        ```
   - 事务
     1. 认识：一组命令在一个步骤里执行，具有原子性
        - 不具备回滚机制，需要自己收拾烂摊子
        - 事务中不能获取同一事务其他命令执行的结果
        - 错误处理：语法错误所有命令不执行，运行错误不影响其他命令执行(会造成问题)
     1. 使用
        - multi：标记开始
        - watch：监视n个key，exec前值被改变则取消事务，即提供了CAS(check-and-set)行为
        - unwatch：取消所有key的监视
        - exec：执行事务
        - discard：取消
   - 锁：锁的性能也是很高
     1. 使用incr的原子计数特性实现库存扣减，防止超卖
     1. 单实例分布式锁
        - 实现
          1. 加锁：set nx ex rangeValue，排他+过期+随机串，一段时间内唯一
          1. 解锁：lua脚本判断随机value相等和删锁进行原子执行
             - 设置一个不可猜测的长随机字符串作为口令串，防止持有过期锁的客户端误删现有锁
        - 特性
          1. 可重入性：支持线程在持有锁的情况下再次请求加锁就是可重入。程序要存储当前持有锁的计数，精确一点还需要考虑内存锁计数的过期时间
          1. 过期性：存在执行时间超出锁时间，造成同时拥有锁，这就是setnx陷阱，可以在拿到锁三分之二时间后，进行锁的延时申请，这个申请要和一开始拿锁的校验等级相同
             - 具体实现有java的redisson。由于需要业务代码和定时触发器同时运行，php没有异步，除非扩充多进程
        - 加锁失败的处理
          1. 直接抛出异常，通知用户稍后重试
          1. sleep一会再重试：碰撞频繁不合适
          1. 将请求转移至延时队列，过一会再试：合理
     1. 分布式锁
        - RedLock：一个集群中依次在大多数节点建锁(n/2+1)，建锁时间小于超时时间则成功，否则就删掉全部锁重抢(即使有的节点没有加锁成功)
          1. 基于集群都是独立master，不存在集群协调机制，否则主从的架构可能在主从切换时恰好导致同时拥有锁
          1. 客户端应设置响应超时时间，防止集群挂掉傻傻等待，并在超时时删掉全部锁。还可轮询重试抢锁。同样服务端也不要留给某个节点太长时间，应该尽快尝试下一个
          1. redlock内部在客户端无法取到锁时，应该在一个随机的并且大于拿锁时间的延迟后重试，尽可能防止多客户端在同时抢夺同一锁(防止脑裂，没人会拿到锁)
             - 拿到锁的时间越短，脑裂概率越低
             - 客户端拿锁失败时，应尽快释放锁，否则已经存在脑裂，只能等待锁自动释放，叫做惩罚
          1. 使用当前时间减去开始拿锁时间即获取锁使用的时间
          1. 时钟漂移带来的时间差对于失效时间来说几乎可以忽略不计
          1. redis重启时，没有备份锁排斥性失效，有AOF没有fsync=always也不行，不过有AOF重启后失效时间还是按照之前的，可以设置重启机ttl后再提供服务，但可能会导致服务整体不可用的时间变长
        - zk：抢锁就是节点尝试创建临时znode，建锁失败则注册监听器，解锁就是删除znode，然后zk通知客户端抢锁，也可弄成顺序节点，多个抢锁就依次监听上个znode
        - 比较：zk设计定位就是分布式协调，注册监听器即可，但大并发压力会较大，比redis的轮询性能开销小
   - 脚本
      - 认识：支持lua脚本，内嵌lua解释器
      - 命令
        1. `eval script numkeys key`：执行，会缓存sha1以便下次用evalsha调用
           - 如`eval "return {KEYS[1],KEYS[2],ARGV[1],ARGV[2]}" 2 key1 key2 first second`
        1. `evalsha sha1 numkeys key`：指定sha1码执行，可以第一次eval，之后省传输用evalsha
        1. `script load script`：加载，不执行
        1. `script exists script`：是否已加载
        1. `script kill`：杀死脚本
        1. `script flush`：移除
### 应用
1. 布隆过滤器
   - 认识：用于判断一个元素在不在一个集合里，
     1. 空间和时间方面都有巨大的优势
     1. 不需要存储元素本身，可用于保密场合
     1. 存在误算率，数据越多，误算率越高
     1. 不能删除元素，需要确保的确在集合里，另外计数器回绕也有问题
   - 设计：元素hash后映射成位阵列中的一个点。只要看这个点是不是1就可以知道集合中有没有了。需要处理hash冲突，解决方法是使用多个hash，如果有一个说不在集合中，那肯定就不在
1. 持久化
   - 方式分类
     1. RDB：redis database，通过快照内存中数据定时将数据存储在硬盘，可以恢复redis的内容
        - 触发条件
          1. 根据规则自动快照：save的配置
          1. 执行save、bgsave：save会阻塞所有客户端请求，避免生产环境使用
          1. 执行flushall
          1. 执行replication：设置了主从时，复制初始化会自动快照
        - 快照生成原理：fork出子进程进行数据存储，完成后替换旧的rdb文件
          1. 快照结束时才替换rdb文件，说明任何时候rdb文件都是完整的
          1. unix使用写时复制功能，fork之后到进程结束前的修改/新增不会被记录
          1. 一旦redis异常，rdb方式会丢失最后一次快照之后的数据
        - 运维
          1. 如果修改/新增较多较大时，占用内存可能显著增大，因为写时复制会增加内存占用，需要设置linux的应用申请内存超过可用内存
          1. rdb文件是默认设置被压缩的，1000万键值对，大小1G的rdb，载入内存花费20多秒
        - 配置
          1. dbfilename：默认dump.rdb
          1. save <seconds> <changes>：n时间内，n次更新操作，就将数据同步到数据文件，可存在多条，或的关系
          1. dir：目录
          1. rdbcompression：是否压缩，关闭节约cpu，但是文件变的巨大
        - 触发机制
          1. save会造成redis阻塞的，得等着，因为redis是单线程的，复杂度O(N)
             - 文件策略：新的替换老的
          1. bgsave是fork新进程进行，fork过程中会造成阻塞，设计或使用不好同样阻塞很长时间，二者执行内容相同
          1. 自动：通过多条配置，满足一个就触发
     1. AOF
        - 认识：append only file，更新数据后追加记录命令，搭配AOF降低数据丢失的可能性，默认不开启，和rdb文件位置相同，
          1. redis启动时，相比于rdb，优先使用aof恢复数据，逐个执行aof命令来载入数据，比rdb方式慢
          1. 由于操作系统的缓存机制，aof记录后没有真正写入硬盘，系统默认30秒同步一次，如果系统异常则数据丢失，可设置appendfsync同步硬盘的时机
        - 实现：纯文本记录，是redis的原始通信协议内容，会按照一定条件进行aof优化重写，不和之前的aof相关，比如三条合一条，手动触发 bgrewriteaof
        - 配置
          1. appendonly：开关
          1. appendfilename：默认appendonly.aof
          1. appendfsync：记录方式，no等待系统将数据同步到磁盘(快)，always更新后将数据写到磁盘(慢，安全)，everysec每秒一次(折衷)
          1. auto-aof-rewrite-percentage：aof重写触发机制，当前aof大小超过上一次重写时大小的百分比时，进行重写
          1. auto-aof-rewrite-min-size：aof重写的最小文件大小
   - 比较：![avatar](../images/save_vs_bgsave.png)
     1. rdb是快照，aof是日志
     1. 二者结合使用
   - 日志
     1. 有log文件和rdb文件，rdb是自己的协议不能直接cat查看，日志可以
   - 备份恢复
     1. 备份：save/bgsave
     1. 恢复：将dump.rdb文件放到redis目录并启动即可
1. 扩容：横向扩容、纵向扩容
1. 守护进程
   - daemonize no：yes
1. 分区
   - 认识：分割数据到多个Redis实例。提高容量，扩展计算能力和带宽
     1. 不支持多个key同时操作，事务中也不行
     1. 多实体数据库维护复杂，容量调整复杂，用presharding解决
   - 类型
     1. 范围：不同范围放到不同实例中，需要维护范围表
     1. hash：使用crc32将key转为数字，然后取模(模为实例数量)确定实例
   - 自动分区：cluster
### 架构
1. 单机
   - 认识：简单，不需要数据同步，单点故障隐患，性能瓶颈
1. 主从
   - 认识：利用复制实现数据在不同库的同步，实现读写分离、冗余备份，可继续向下配置树状从
   - 作用
     1. 负载均衡、读写分离
     1. 数据备份
     1. 故障转移
     1. Redis Sentinel 、Cluster的基石
   - 形式分类
     1. 一主多从
     1. 树状结构：不建议，会带来运维困难、数据一致性降低
   - 特性
     1. 增量同步：offset、backlog、run_id一同起作用
        - 标识唯一运行实例：`run_id`，用于保障主从复制安全
        - 复制偏移量：`slave_repl_offset`
        - 复制缓冲：`repl_backlog_*`，主保持一个默认大小1M的先进先出的队列，有从连接时主在把写操作发送给从的同时，也写入一份到缓冲区。用于增量复制/丢失命令补救
        - replid：解决主从切换必引起全量复制的问题，通过记录旧replication id，其他从和新主执行同步时也可以增量同步
        - 如果从开启AOF，那么从重启后依然会进行全量，因为AOF没有保存replication id和offset，并且AOF的加载优先于RDB，RDB保存了这俩
     1. 主从心跳
        - 维持长连接，每隔10s主ping从，`repl-ping-slave-period`
        - 从回复offset，检查数据复制状况
        - 断线重连
          1. v2.8之前断开重连都会全量同步
          1. 偏移量不在缓冲区中只能全量同步
     1. 过期key处理：从不会让key过期，会等待主的del命令，v3.2从自己判断是否过期
     1. 加速复制：`repl-diskless-sync yes`，主不写磁盘直接发送rdb，v2.8.18
     1. 是否延迟发包：`repl-disable-tcp-nodelay`，是否合并较小的tcp数据包以节省宽带，发送时间间隔由一般默认40ms的linux内核设置决定，默认关闭，会加重主从延迟
   - 复制原理
     1. 全量复制：v2.8之前，sync，![avatar](../images/redis_fullsync.png)
        - 初始化阶段
          1. slave发起sync命令，2.8之后使用psync
          1. master：乐观复制，存在一开始主从数据不一致的时间窗口，但是会最终同步。不会同步给从后再返回给客户端，保证主的性能
             - 后台进程fork保存rdb快照，并缓存执行快照保存期间的命令(写时复制)
               1. 导致io和cpu消耗，以及写时复制的内存消耗，可能造成主节点毫秒或秒级的卡顿
               1. 是非阻塞的
             - 发送rdb文件
               1. 会导致网络出口爆增，磁盘顺序IO吞吐量高，会影响正常访问，并带来其他连锁影响
          1. slave载入快照(和重启原理一致)，并执行缓存的命令
             - 从同步时是非阻塞的，可设置是否响应
        - 同步阶段：master每次收到写命令时，就将命令同步给salve，贯穿始终
     1. 增量复制：![avatar](../images/redis_psync.png)
   - 醉驾实践
     1. 主从都要开启持久化
   - 命令
     1. `slaveof ip port`：设置从，可实现同步和默认的从只读
     1. `masterauth xxx`：主节点密码
     1. `slaveof no one`：停止同步(也就是变成了主)
   - 配置
     1. 增量同步
        - `repl-backlog-size`：积压队列长度，默认1M
        - `repl-backlog-ttl`：主从断开连接后，多长时间释放积压队列的内存，默认1小时
     1. 复制安全
        - `min-slaves-to-write`：主可写的最少的从数量，即设置乐观复制的尺度
        - `min-slaves-max-lag`：从最大的延迟
   - 状态：`info replication`
    ```conf
    role:master|slave
    connected_slaves:2                                          // 连接的从节点数据
    master_replid:xxxxxxxxxxxxxxxxxxxxxxxxxxx                   // 当前主节点id
    master_replid2:00000000000000000000000000                   // 老主节点id，发生主从切换时写入
    master_repl_offset:196                                      // 主节点已写入命令的偏移量，主节点会将命令转为字节写入队列，salve的offset对比得出延迟
                                                                // 以下都是2.8新增
    second_repl_offset:-1                                       // 避免每次的主从改变的全量复制
    repl_backlog_active:1                                       // 缓冲区，1开启
    repl_backlog_size:1048576                                   // 缓冲区大小，1M
    repl_backlog_first_byte_offset:1                            // 缓冲区起始位置
    repl_backlog_histlen:224                                    // 缓冲区当前长度

    // 主
    slave0:ip=xx,port=xx,state=online,offset=n,lag=1            // offset：当前从节点读取的偏移量，lag：延迟时间，秒
    // 从
    master_host:xx
    master_port:n
    master_link_status:up
    master_last_io_seconds_age:5                                // 主从最后一次同步的时间
    master_sync_in_process:0                                    // 主从同步状态，0未同步，1正在同步
    slave_repl_offset:n                                         // 从复制命令的偏移量
    slave_priority:100                                          // 从节点选举时的权重，0永远不可能
    slave_read_only:1
    ```
1. 哨兵
   - 认识：针对redis主从的分布式独立进程，提供监控、提醒、自动故障转移、配置提供者，2.6版本的sentinel不能用
     1. 属性
        - 端口26379
        - 最少3个sentinel实例，2个无法做投票
        - 独立机器中运行，甚至需要多地部署
     1. 优点
        - 降低误报可能性
        - 降低对客户端的影响
        - 任意sentinel节点都可提供服务
     1. 不足
        - 主从切换需要时间
        - 动态扩容复杂
   - TILT模式：拿不到正确的系统时间时进入，这时候无法判断redis是否下线，是sentinel的被动模式
   - 节点管理
     1. sentinel
        - 添加：直接启动
        - 删除：不会完全清除已添加过的sentinel信息
          1. 停止sentinel进程
          1. 告诉其他sentinel，`sentinel reset masterName`，也是一个个操作
          1. `sentinel master masterName`
     1. 删除旧主或者无法访问的slave：`sentinel reset masterName`，重置所有状态信息
   - 工作原理
     1. 内部定时任务
        - 每1秒每个sentinel对其他sentinel、redis执行ping
        - 每2秒每个sentinel订阅一个master的channel交换信息，检测信息传播
        - 每10秒每个sentinel对master和slave执行info
     1. 下线
        - 主观下线：sdown，单个sentinel得出的下线判断
        - 客观下线：odown，多个sentinel相互交流后得出的下线判断，然后开启failover
          1. 仲裁：少数服从多数原理，quonum
     1. 选举：raft共识算法的Leader Election方法
        - 故障迁移一致性：选择leader sentinel
          1. 一个epoch内，只有一个leader
          1. sentinel配置以最后写入者胜出的方式传播至其他sentinel
        - 选择新主
          1. 先根据权重
          1. 权重一样，根据最少的lag
          1. lag一样，run_id最小的
     1. 故障转移
        - 主恢复后会变为从
        - 新从需要全量同步新主
     1. 故障转移流程
        - 每秒ping
        - 有效回复ping的时间超时，认定主观下线
        - 共同商议后满足客观下线条件
          1. 投票选举主节点，从节点向新主全量同步数据
          1. 主标记为客观下线时，info由10s一次改为1s一次，最快恢复节点全貌
          1. sentinel节点集合更新
          1. sentinel监控新的主
        - 不满足客观下线
          1. 主客观下线状态移除
          1. 重新ping有效时，主观下线移除
   - 使用
     1. 命令
        ```
        redis-sentinel xx.conf                                  // 开启监控，只监控主数据库即可，会自动发现从，可同时监控多个主从系统
        ```
     1. 配置
        ```
        sentinel monitor masterName ip port quonum              // 执行恢复的最低哨兵通过票数，num是满足投票的比例，一般为二分之一加一
        sentinel down-after milliseconds masterName 30000       // 认定断线的豪秒数，要比主从心跳的时间长点
        sentinel failover-timeout masterName 180000             // failover操作的限定豪秒数
        ```
1. 集群
   - 认识：cluster，用于解决容量和并发性能，无中心结构、分布式、自动故障转移、高可用、可扩展。![avatar](../images/redis_cluster.png)
     1. 高可用性：通过增加slave做热备数据副本，能够实现故障自动转移
   - 优点：
     1. 客户端直连，免去了代理损耗
     1. 重试时间应该大于cluster-node-time时间
     1. 不建议使用pipeline和multi-keys操作，减少max redirect产生的场景
     1. 分片了，没有库的概念
   - 缺点
     1. 数据异步复制，无法保证强一致性
     1. 不支持跨slot查询和修改，不支持跨solt事务操作
     1. 不支持多数据库空间，集群模式只能用0
     1. 不支持嵌套树状复制结构
     1. 要求客户端缓存slots mapping信息并及时更新
   - 实现
     1. 主分配solt插槽，从做故障切换
        - 最少6个节点保证高可用，3主3从，因为集群最少3个主
     1. 所有节点通过轻量的二进制流言Gossip协议连接，交换维护整个集群节点metadata，可扩展到1000个节点
        - 存放哈希槽的bitmap通过Gossip协议在结点之间传递
   - 分片方式
     1. slot：hash slot，虚拟槽，处理分区时节点变化的问题，将所有的物理节点映射到预分好的16384个slot中
        - 根据`CRC16(key) Mod 16384`决定key在哪个槽中
          1. crc16的结果是16位的，可以支持到65536进行取模运算，为什么只到16384，一是心跳消息头太大(8kb)浪费带宽，认为节点有1000个足够了，槽位越小，信息压缩越高
        - 节点变化，数据需要迁移，槽需要重新分配，服务可以不停
     1. 客户端分片：客户端直接选择正确的节点，如Jedis
        - 逻辑简单，性能高
        - 业务逻辑和数据存储逻辑耦合，可运维性查。多业务各自使用redis，集群资源难以管理，不支持动态增删节点
     1. 代理协助分片：代理根据配置的分片模式转发到正确的节点，如Twemproxy、Codis，比较成熟
     1. 查询路由：Query Routing，先到随机节点，这个节点保证你到正确的节点，或者客户端重新发起到正确节点
   - 数据分区方式
     1. 范围：同一范围查询不需要跨节点
     1. 节点取余：扩缩容数据迁移量大，翻倍扩容可相对减少迁移量
     1. 一致性哈希：每个节点分配一个token，范围一般在0~232，这些token构成一个哈希环。根据要存储的key计算hash，顺时针第一个大于等于该哈希值的token节点
        - 顺时针的组成哈希环，节点为哈希环中的键，按照节点之间的哈希范围确定位置
     1. 虚拟槽：每个node均匀分配slot范围，减少扩缩容的影响，需要存储node和slot的映射
        - CRC16(key)&16384：哈希运算后取余
   - 使用
     1. `cluster info`：查看状态
     1. `cluster nodes`：查看节点
     1. `cluster meet 127.0.0.1 6380`：连接节点
     1. `cluster addslots {0...5461}`：分配槽位
     1. `cluster replicate xx`：分配为某节点的从
     1. `redis-cli -cluster`：连接集群，c是集群模式
1. 网校tw架构
   - hash分片数据到redis上
   - 高可用：confd + etcd + tw + redis一从热备 + sentinel
     1. tw本身高可用
        - etcd集群做保活，设置10秒过期，tw每2秒续期，一旦tw发生变化，etcd切换tw，通知confd
          1. etcd：go编写，支持watch并且主动通知
        - confd收到etcd的通知后，完成客户端ip配置文件的更新
     1. 高可用
        - 每个业务最少提供两个 TwemProxy 供业务方连接
        - redis 发生主从切换，TwemProxy 会实时生成新的配置文件，并自动重启
     1. 客户端sdk负责负载均衡
     1. 一从热备：假如从库一直提供服务，从库一旦重连导致从库数据不对
     1. 哨兵监控：完成主从切换后，通知etcd，然后confd更新客户端ip配置文件
   - 架构图：![avatar](../images/redis_wx_framework.png)
   - 扩容：找新机器，用工具同步存量+增量的旧数据，然后挂到tw上
1. 阿里云指标
   - 认识：百万QPS，最好性能512G内存、最大连载数320000、最大吞吐1536M
   - 功能
     1. 负载均衡
     1. 多个proxy，负责故障转移
     1. 分片服务器，单节点，不需同步数据，不提供数据持久化和备份策略，节点故障会丢失数据。集群版是双节点
     1. 配置服务器，即Configserver，存储集群配置信息及分区策略，采用双副本的高可用架构
### 中间件
1. TwemProxy
   - 认识：twitter开源的redis/memcache的快速、轻量级的单线程代理服务器，可对多台redis/memcache进行管理和分配。就是分片、分布式方案
     1. 支持失败节点自动删除
     1. 支持设置HashTag：将两个key哈希到同一个实例
     1. 和redis、客户端采用长链接，减少连接数
     1. 数据自动分片
        - hash：MD5、CRC16、CRC32、CRC32a、hsieh、murmur、Jenkins
        - 分片：ketama、modular、random
        - 可设置权重
     1. 支持集群部署，上边接负载均衡
     1. 支持状态监控：监控ip、端口、刷新间隔时间
     1. 使用pipelining处理请求和响应
     1. 不支持redis事务
     1. 使用某些命令需要保证key都在同一个分片上：SIDFF,SDIFFSTORE,SINTER,SINTERSTORE,SMOVE,SUNION and SUNIONSTORE
     1. 相对于官方较新的Redis Cluster架构，容量伸缩较麻烦
     1. 支持memcached ASCII协议和redis协议
   - 如何一份数据复制两份发到两个实例？
   - 运维
     1. 同时使用tw和pipeline时，如果对pipeline的执行顺序有要求，那么要设置tw对redis的server_connections数量为1，否则会导致顺序错乱。因为tw用epoll，每个连接有独立的队列，每个连接用完就会扔到队尾准备重复利用，就势必导致两个命令在两个不同的连接上进行，到了redis那里就有可能造成顺序错乱，如zadd和expire一起用
1. Codis
   - 没有pipeline
1. Pika：从rocksdb发展来的开源类redis系统，redis容量过大的解决方案，建议作Redis的备份仓库，可极大的降低运维成本
   - 用硬盘存储，速度慢
   - 支持redis协议，不是100%兼容
   - 数据在硬盘上是压缩的，迁移到redis需要将当前的容量乘以5
1. Cluster：太复杂，是去中心化的。没有tw的简单，用的稳定
### 设计
1. 数据类型
   - string
     1. 是动态字符串，会自动转换类型，遇到计算了就转为数值
     1. 预分配冗余空间
        - 减少内存频繁分配
        - 长度小于1M加倍扩容，超过一次只会多扩1M
   - list
     1. 快速链表的结构，不是数组，意味着插入和删除操作非常快，时间复杂度为O(1)，索引定位很慢，时间复杂度为O(n)
     1. 内存分配：元素较少用连续内存的压缩列表(ziplist)存储；多时用快速链表(quicklist)，是将多个ziplist使用双向指针串起来使用，既满足了快速的插入删除性能，又不会出现太大的空间冗余
        - 普通链表需要的附加指针空间太大，浪费空间、加重内存碎片化
   - hash
     1. 无序字典，类似java的HashMap，数组 + 链表二维结构。第一维hash的数组位置碰撞时，将碰撞元素使用链表串接起来
     1. 渐进式rehash：保留新旧两个hash结构并同时查询，在后续的定时任务中及hash的子指令中渐进的迁移
   - set
     1. 相当于一个特殊字典，字典中所有value都是null
   - zset
     1. 使用跳跃列表的数据结构，结构特殊、复杂。
        - 因为要支持随机插入和删除，链表操作就要二分查找，平层太慢，所以设计为多层元素，元素可以在不同层次之间进行「跳跃」，定位时一层层下潜
        - 随机策略来决定新元素可以兼职到第几层，最顶层L31层，L2层25%的概率，只有极少数元素深入到顶层。元素越多越深入的层次就越深、概率越大
1. 数据类型特性
   - list/set/hash/zset
     1. create if not exists 
     1. drop if no elements：内存回收，最后一个元素弹出自动回收
1. 内存
   - 复杂的数据结构在内存中操作非常简单，redis可以做很复杂的操作
   - 达到最大内存后，Redis会先尝试清除已到期或即将到期的Key，当此方法处理后，仍然到达最大内存设置，将无法再进行写入操作，但仍然可以进行读取操作。Redis新的vm机制，会把Key存放内存，Value会存放在swap区
   - 虚拟内存机制：VM机制将数据分页存放，由Redis将访问量较少的页即冷数据swap到磁盘上，访问多的页面由磁盘自动换出到内存中，突破了物理内存的限制
1. 磁盘中是紧凑追加方式存在，不存在随机io
1. 连接原理
   - 认识Redis通过监听一个TCP端口或者Unix socket的方式来接收来自客户端的连接，当一个连接建立后，Redis内部会进行以下一些操作
     1. 首先，客户端socket会被设置为非阻塞模式，因为Redis在网络事件处理上采用的是非阻塞多路复用模型
     1. 然后为这个socket设置TCP_NODELAY属性，禁用Nagle算法
     1. 然后创建一个可读的文件事件用于监听这个客户端socket的数据发送
1. redis协议：流言协议
1. 主从同步原理：主准备所有的命令，利用redis协议，发送到从，执行并且放入到内存中
1. 哨兵机制：通过多个sentinel的订阅和发布，实现对主的监视
1. Redis是单进程单线程的网络模型，命令是一个接着一个执行的，不存在并行执行的情况
   - 用的是epoll,poll,select网络模型
   - 单线程处理所有的客户端连接请求，命令读写请求
   - 2个命令组合起来才算是完成一个业务，但是2个命令组合起来就不具备原子性，所有在两个命令之间其他客户端会出现读写脏数据的情况
### 运维
1. 命令
   - 服务器
     1. info：所有的服务器信息
        - info replication：查看主从信息
     1. client list：客户端列表
     1. ping：查看是否运行
     1. monitor：实时打印接收到的命令，调试用
     1. debug segfault：让redis崩溃
     1. config
        - `config get requirepass`：查看密码
        - `config set requirepass xxx/''`：设置/取消密码
   - 数据
     1. save/bgsave/lastsave：默认生成dump.rdb文件，查看最后一次保存确认是否后台保存成功
     1. flushdb/flushall：删除当前/所有数据库的所有key
   - 其他
     1. slowlog subcommand：管理慢日志
     1. sync：用于复制功能的内部
     1. `src/redis-cli -h host -p port -a password`：客户端发起连接
   - 配置
     1. 操作：`config get/set/rewrite */configName configValue`
     1. 分类
        - 基础
          1. port/bind/timeout(无操作连接超时时间，为0不断)
          1. maxclients：最大连接数
          1. databases：数量
          1. maxmemory：最大占用内存，单位字节
          1. maxmemory-policy：超最大内存后策略
             - volatile-lru、allkeys-lru：根据lru算法(Least Recently Used)，删除过期/一个键。并不准确，随机取n(maxmemory-samples)个找最久未被使用
             - volatile-random、allkeys-random：随机删除过期/一个键
             - volatile-ttl：删除过期时间最近的一个键
             - noeviction：不删除，只报错
          1. maxmemory-samples
          1. include：子配置文件地址
          1. requirepass：设置密码，`auth` 检验密码是否正确
        - 日志
          1. loglevel：debug/verbose/notice/warning
          1. logfile：文件地址，守护进程方式运行时日志发送给/dev/null
        - 内存
          1. vm-enabled：是否启用虚拟内存机制
          1. vm-swap-file：虚拟内存文件路径，多Redis实例不可共享
          1. vm-max-memory 0/vm-page-size 32/vm-pages 134217728/vm-max-threads 4
1. 性能测试
   - redis-benchmark
     1. -h/-p：地址端口
     1. -s：指定socket
     1. -c：并发连接数
     1. -n：请求数
     1. -d：字节形式指定set/get大小
     1. -k：1=keep alive 0=reconnect
1. 服务治理：连接数过多、慢查询、短连接、长连接
   - 主从延迟：外部程序监听，进行报警
   - 脏数据
     1. 主从延迟
     1. 从可写
   - 复制
     1. 规避全量复制：增大复制缓冲区
     1. 规避复制风暴
        - 主重启，多从同时复制：提供故障转移机制，或者改为树状复制结构，因为同时发送多个RDB费带宽
1. 主库重启 checklist 
   - 世纪互联主从库节点 zabbix 关闭报警
   - 世纪互联主从库节点 注释脉搏脚本
   - 切换Master到从库，修改参数并重启
    ```
    redis-cli -h 10.20.52.245 -p 8379 sentinel failover jy-courseware-redis
    redis-cli -h 10.20.52.245 -p 9379 sentinel failover jy-tnt-redis

    vim /boot/grub/grub.conf
    isolcpus=10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29 
    for i in {1..9}; do /etc/init.d/${i}379redis stop; done 
    init 6
    ```
   - 重启完成后sysbench验证,重启redis服务
    ```
    /bin/rm -rf /root/scripts/sysbench.sh
    cd /root/scripts && wget -N --http-user=XueRs --http-passwd=xxx http://soft.xesv5.com:88/dell/sysbench.sh
    ./sysbench.sh  --test=cpu --num-threads=${v_cpu_num} --max-requests=600000 run
    for i in {1..9}; do /etc/init.d/${i}379redis start;sleep 60; done 
    for i in {1..9};do sed -i '/slaveof/d' /data/${i}379redis/etc/redis.conf;done
    for i in {1..9};do cat /data/${i}379redis/etc/redis.conf |grep slaveof;done
    ```
   - 同步完成后，切回原主
    ```
    redis-cli -h 10.20.52.245 -p 8379 sentinel failover jy-courseware-redis
    redis-cli -h 10.20.52.245 -p 9379 sentinel failover jy-tnt-redis
    ```
   - 开启zabbix报警和脉搏，sentinel reset 
   - yf的同步节点挂到sjhl从库
    ```
    /etc/init.d/irqbalance restart
    chkconfig irqbalance on
    ```
1. 日志
   - redis.log：人可读
   - sentinel.log：人可读
1. 目录
   - 配置，数据，日志
### 最佳实践
1. 使用
   - 结构体用hash还是string
     1. string
        - 每次访问大量字段
        - 值不能存储为字符串的时候
     1. hash
        - 大多数情况中只访问少量字段
        - 始终知道哪些字段可用
1. 使用规范
   - key名设计
     1. 【建议】：可读性和管理性，以业务名为前缀，以一定规则分割，比如业务名:表名:id
     1. 【建议】: 简洁性，保证语义的前提下，控制key的长度，当key较长时，内存占用也不容易忽视
     1. 【建议】：redis单实例内存控制在 10G以内，内存越大，触发持久化的操作阻塞主线程的时间越长
   - value设计
     1. 【强制】：禁止在redis中存储图片
     1. 【强制】：禁止在集合结构中只存不清，对于集合结构中数据增加频繁必须要有删除机制
     1. 【建议】：拒绝bigkey（防止网卡流量，慢查询)： string类型控制在10KB以内，hash、list、set、zset元素个数不要超过5000。
     1. 【建议】：选择合适的数据类型： 存储数据时选择合适的数据类型，要合理控制key和value的大小和个数以使用更优化的数据结构，如 ziplist
   - 命令使用
     1. 【强制】：禁止使用 FLUSHDB FLUSHALL KEYS BGSZVE SAVE BGREWRITEAOF命令
     1. 【强制】：使用 SCAN 命令时应该批次使用，单次扫描key数量不应超过 2万，间隔0.5s
     1. 【建议】：使用批量操作以提高效率
     1. 【建议】：谨慎全量操作hash set等集合结构，O(N)命令关注N的数量，如hgetall/lrange/smembers/zrange要明确N的值, 遍历需求可用hscan、sscan、zscan代替
     1. 【建议】：zset服务器消耗最高，要排序还要去重，尽量少用    
   - 客户端使用
     1. 【强制】：新上线或者迁移的redis服务强制使用密码，应用层要进行配置
     1. 【强制】：只允许读取本部门redis， 需要使用其他部门数据则将数据服务化
     1. 【建议】：应用层自行处理长连接断开问题，db组只负责维护redis服务域名的存活，应用层要考虑dns切換之后原来的连接无法使用的状况
1. 缓存常见问题
   - 缓存穿透：缓存和数据库中都没有数据，但是用户一直发起请求
     1. 加强校验，避免非法请求
     1. 缓存设置为key-null，过期时间设置短些：30s
   - 缓存击穿：缓存数据过期，并发查同一条数据
     1. 热点数据不过期，双写
     1. 互斥读锁（请求KEY，进程ID，超时），读完后写缓存，其他请求区间随机时间等待，重试
   - 缓存雪崩：大量数据同时过期
     1. 热点数据不过期，双写
     1. 缓存过期时间区间随机
     1. 如果缓存通过代理访问，调整hash算法，确保热KEY均匀分布在不同分片上
   - 热KEY：单机被集中大量访问
     1. 收集数据（代理层，后台，客户端），提前准备预案
     1. 数据冗余备份，通过随机数将key-value分散到不同分片中
     1. 二级缓存，缓存到内存中
   - 大key：拆，导致网卡撑爆、慢查询等
     1. 加随机数前缀放到不同分片上
     1. 用hash的hget方法只取精确的
     1. 分成小key，用mget拿
1. 性能监控
   - qps
   - 客户端数
   - cpu
   - 内存
   - 流量入和出
1. 缓存治理
   - 数据库缓存一致性方案
     1. key过期，mysql更新不更新redis
        - 开发成本低，管理成本低
        - 不一致时间很长
     1. key过期，mysql更新时，更新redis
        - 延迟更小
        - 损耗双倍资源
     1. key过期，消息队列异步更新redis
     1. key过期，从库订阅binlog来更新redis
### wiki
1. 历史
   - 2009年，开源
   - 2.6：set命令增加键存在与否的判断和过期时间的设置，新增lua环境
   - 2.8：新增，支持复制的断线重连时有条件的增量数据传输，可用的哨兵机制
   - 2.8.9：新增，HyperLogLog
   - 2.8.18：新增，无硬盘复制(避免硬盘性能瓶颈)
   - 3.0：2015年，新增，集群功能
   - 6.0
     1. ACL安全策略
   - 6.2：最新
1. 编程语言客户端
   - php：官方推荐两个
     1. Predis：php代码实现的原生客户端
     1. phpredis：c编写的php扩展，性能更好
   - ruby：redis-rb，最稳定的客户端
   - python：redis-py
   - node：node_redis、ioredis，前者早，后者功能丰富
1. Memcache：高性能分布式内存对象缓存系统，内存里维护一个统一的巨大的hash表，能够存储图像等数据
### lua
1. lua
   - 认识：高效的、简洁轻量的、动态类型的、可扩展的脚本语言，lua是葡萄牙语月亮的意思，是卫星语言，能够方便嵌入其他语言中
     1. redis内嵌lua就是为了提供给用户无限可能，因为命令不可能无限提供
   - 基础
     1. 不要求缩进，结尾可以省略;
     1. 注释：-- 单行，--[[]] 多行
     1. 操作符
        - + - * / % ^
        - == ~=(不等于) > < >=
        - not and or：支持短路，只要不是nil或false就是真，0和空字符串也是真
        - ..：连接符
        - #：字符串/表长度计算符
   - 数据类型
     1. 分类
        - nil：空
        - boolean：true、false
        - number：整数和浮点数
        - string：字符串，二进制安全，单双引号定义，支持换行符
        - table：表，数组或者字典，唯一数据结构，索引为整数时和数组一样，数组从1开始
        - function：是一等值，可存变量、作为返回值等
     1. 操作
        - 转换：tonumber、tostring
     1. 详细
        - table
            ```lua
            -- 表
            a = []                          -- 定义
            a = {                           -- 定义
                k = 'v'
            }

            a['k'] = 'v'                    -- 赋值

            a.k                             -- 访问
            for k,v in pairs(a) do          -- 遍历，pairs类似迭代器，ipairs用于数组，前者遍历不为nil的，后者只会遍历整数
            end
            ```
        - 函数
            ```lua
            local a = function (...)        -- 定义，可变参数
            end
            local function a ()             -- 语法糖
            end
            ```
   - 变量
     1. 全局变量：`a = 1`
     1. 局部变量
        ```lua
        local a = 1
        local e,f
        ```
   - 流程控制
     1. if
        ```lua
        if xx then
        elseif xx then
        else
        end
        ```
     1. 循环
        ```lua
        for 初值，终止，步长 do
        end

        while xx do
        end

        repeat 
        until xx
        ```
   - 标准库
     1. 分类：Base、String、Table、Math、Debug、cJson、cmsgpack
     1. 使用：`string.len(str)`
   - 和redis的交互
     1. lua脚本使用redis
        - call：`redis.call('get', 'a')`，直接返回错误不继续
        - pcall：记录错误并继续执行
     1. 类型转换：redis类型 ===> lua类型，反转即反过来
        - 整数 => 数字、字符串 => 字符串
        - 多行字符串 => 表(数组形式)
        - 状态/错误 => 表(ok/err)
        - 空 => false
     1. 特点
        - 禁用全局变量，保证脚本隔离
        - 禁止使用lua标准库中和文件、系统调用相关的函数，一是防止拉低性能，二是防止依赖外部条件(系统时间、文件内容等)，因为日志和持久化只能记录脚本内容，内容和参数都一样才能保证执行结果一样
        - 对随机数和随机结果进行了特殊处理，可以生成了当参数传递进去
        - 脚本执行是原子的，单线程的，lua-time-limit限制脚本最长执行时间，之后接受其他指令不执行返回busy，只执行两个指令：script kill和shutdown nosave。kill还是等到脚本执行完毕，因为要原子性，nosave可以立即终止，但是丢数据
        - 不应该在脚本中执行耗时的操作，因为redis单线程，程序却是多进/线程




1. 细节
1. 优点
1. 缺点
1. 最佳实践