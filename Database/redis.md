### 认识
1. 理解：开源、基于内存、可持久化的日志型、Key-Value的数据库，多客户端支持。对关系型数据库起到补充作用。常用作缓存、数据库、消息中间件，使用ANSI C编写
   - 速度快，性能高：读11万次/秒，写8万次/秒
   - 多数据结构，key过期，发布/订阅模式
   - 所有操作都是原子的、事务、Lua脚本
   - 数据持久化、LRU收回
   - 主从同步、Sentinel提供高可用，Cluster提供自动分区
1. key
   - 库
     1. select index：切换某个库，更像命名空间，隔离key名冲突。索引号只能是数字不能自定义，可设置数量，开始和默认是0
     1. move：移动key到某个库中
   - 查看
     1. dbsize：key的数量
     1. keys：查找符合给定模式的key
     1. exists：是否存在
     1. type：查看类型
     1. sort by xx*->xx desc get xx*->xx get # store xx：对队列、集合按照某些规则排序，by可用通配符，get用于获取指定键值，store结果存储
   - 过期时间
     1. expire/pexpire：[用毫秒]设置过期时间
     1. expireat/pexpireat：用[毫秒]时间戳设置过期时间
     1. ttl/pttl：用[毫]秒返回剩余时间，time to live
     1. persist：移除过期时间
   - 修改
     1. rename/renamenx：[key不存在时]重命名
     1. del
   - 其他
     1. randomkey：随机返回
     1. dump：序列化
     1. echo string：打印字符串
1. 数据类型
   - string
     1. 认识：字符串，键值对类型、二进制安全的字符串，意味着可包含任意对象(如一个图片)，最大512MB
     1. 命令
        - set/get、mset/mget、setbit/getbit：单个、多个、按照偏移量设置位(可做Bloom过滤器)
        - setex/psetex、setnx/msetnx、setrange/getrange：设置过期时间、存在才设置、按照偏移量设置
        - incr/incrby/incrbyfloat、decr/decrby：加/减、一/N，可当原子计数器
        - getset、strlen、append：设置并返回旧值、长度、追加到末尾
   - hash
     1. 认识：哈希，哈希类型的键值对集合，field为string类型，可存储对象，最多40亿对
     1. 命令
        - hset/hmset/hsetnx：设置
        - hget/hmget/hgetall：获取
        - hkeys/hvals/hlen/hscan：键值对数量、迭代键值对
        - hincrby/hincrbyfloat：加一
        - hdel/hexists：删除n个字段、是否存在某个字段
   - list
     1. 认识：双向链表，首尾插入的按照插入顺序排序的字符串列表，访问中间的时间复杂度为O(N)，双向链表，最多40亿个(2^232-1)
     1. 命令
        - lpush/rpush/lpop/rpop/rpoplpush/lpushx/rpushx：压入、弹出、存在时才压入
        - blpop/brpop/brpoplpush：带超时时间的弹出数据，单位秒
        - lset/linsert：索引设置、在前/后插入元素
        - lrem/ltrim：删除、范围删除
        - lrange/lindex/llen：范围查看、索引查看、长度。`lrange xx 0 -1` 查看所有
   - set
     1. 认识：无序集合，string类型的成员唯一的无序集合。通过hash表实现，所有操作复杂度都是O(1)
     1. 命令
        - sadd/spop/smove/srem：移除某一随机元素、移到另一集合、移除n个
        - sdiff/sdiffstone/sinter/sinterstone/sunion/sunionstone：求差集、求交集、求并集。[并储存到另一个集合]
        - scard/sismember/smembers/sscan：成员数量、是否成员、返回所有成员、迭代元素
   - zset
     1. 认识：有序集合，string类型的成员唯一的有序集合，每个元素关联一个double类型的分数
        - 适用于有序且不重复
        - 成员唯一，分数可重复
        - 可通过分数进行排序，通过哈希表实现，最多40亿个(2^232-1)
     1. 命令
        - zadd/zrem/zremrangebylex/zremrangebyscore/zremrangebyrank
        - zcard/zcount/zlexcount/zscan：成员数、指定分数区间的成员数、指定字典区间的成员数
        - zrange/zrangebylex/zrangebyscore：通过索引区间、字典区间、分数返回成员
        - zrevrange/zrevrangebyscore/zrevrank：通过索引、分数返回指定区间成员、返回排名。分数都是从高到底
        - zscore/zrank：返回分数值、返回指定成员索引
        - zincrby/zinterstore/zunionstore
   - HyperLogLog
     1. 认识：基数统计的算法(集中不重复元素数量)
        - 输入元素数量非常大时，计算基数所需的空间总是固定的、很小的。每个HyperLogLog键只需要花费12KB内存，就可以计算接近2^64个不同元素的基数
        - 只计算基数，不储存输入元素
        - 比如数据集{1,3,5,7,5,7,8}，那么基数集为{1,3,5,7,8}, 基数(不重复元素数量)为5
     1. 命令
        - pfadd/pfcount/pfmerge：添加、返回基数估算值、合并
   - geospatial：地理空间，索引半径查找，如附近的人
   - bitmaps：位图，即位的数组
1. 功能
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
   - 发布订阅
     1. 认识：pub/sub，一种消息通信模式，发送者发送消息，订阅者接收消息，是原子的
     1. 使用
        - subscribe/unsubscribe/psubscribe/punsubscribe：订阅/退订n个，[给定模式(通配符等)]
        - publish：发布
        - pubsub：查看订阅和发布系统状态
   - 管道
     1. 认识：pipeline，不直接响应，一次性发送多条命令，一次性返回所有响应。减少了多次数据往返时间，提高服务端利用率
     1. 使用
        ```php
        $redis->pipeline();
        $redis->exec();
        ```
   - 事务
     1. 认识：一组命令在一个步骤里执行，具有原子性
        - 不具备回滚机制，需要自己收拾烂摊子
        - 事务中不能获取事务中其他命令执行的结果
        - 错误处理：语法错误所有命令不执行，运行错误不影响其他命令执行(会造成问题)
     1. 使用
        - multi：标记开始
        - watch：监视n个key，exec前值被改变则取消事务，可以提供CAS(check-and-set)行为
        - unwatch：取消所有key的监视
        - exec：执行事务
        - discard：取消
   - 锁
     1. set nx ex val lua：排他，过期，一段时间内唯一的特性
        - 存在执行时间超出锁时间，造成同时拥有锁，这就是setnx陷阱
        - 删除锁时，锁已过期，这个间隔他人拿到了锁，会误删他人锁：利用lua脚本，拿锁和删锁原子操作，解决了此问题
     1. 分布式锁
        - 分类
          1. RedLock：一个集群中依次在大多数节点建锁(5个节点就需要建3个锁)，建锁时间小于超时时间则成功，否则就删掉锁重抢。轮询重试抢锁，利用key的过期和nx特性，删除锁时使用事务和对比内容是否一致判断是否误删他人锁
          1. zk：抢锁就是节点尝试创建临时znode，建锁失败则注册监听器，放锁就是删除znode，然后zk通知客户端抢锁，也可以弄成顺序节点，多个抢锁就依次监听上一个znode
        - 比较：zk注册监听器即可，比redis的轮询性能开销小
   - 脚本
      - 认识：执行lua脚本，内嵌lua解释器
      - 命令
        1. `eval script numkeys key`：执行，会缓存sha1以便下次用evalsha调用
           - 如`eval "return {KEYS[1],KEYS[2],ARGV[1],ARGV[2]}" 2 key1 key2 first second`
        1. `evalsha sha1 numkeys key`：指定sha1码执行，可以第一次eval，之后省传输用evalsha
        1. `script load script`：加载，不执行
        1. `script exists script`：是否已加载
        1. `script kill`：杀死脚本
        1. `script flush`：移除
### 应用
1. 持久化
   - 方式分类：二者结合使用
     1. RDB：通过快照(内存中数据的副本)定时将数据存储在硬盘
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
   - 备份恢复
     1. 备份：save/bgsave
     1. 恢复：将dump.rdb文件放到redis目录并启动即可
1. 主从
   - 认识：利用复制实现数据在不同库的同步，实现读写分离、冗余备份，可继续向下配置孙子辈的从
   - 命令
     1. `slaveof <masterip> <masterport>`：设置从：从库这么设置即可实现同步和默认的从只读
     1. `slaveof no one`：停止同步(也就是变成了主)
     1. `masterauth <master-password>`
     1. `info replication`：查看同步状态
   - 配置
     1. `repl-backlog-size`：积压队列长度，默认1M
     1. `repl-backlog-ttl`：主从断开连接后，多长时间释放积压队列的内存，默认1小时
     1. `min-slaves-to-write`：依据从的数量可设置主可写的条件，即设置乐观复制的尺度
     1. `min-slaves-max-lag`：可设置从的最长失去连接时间，从而利用上条配置控制主从不一致的问题，默认关闭
   - 复制原理
     1. 初始化阶段
        - slave发起sync命令(2.8之后使用psync  run id  断开前的命名偏移量)
        - master后台开始保存快照(rdb持久化)，并缓存执行快照保存期间的命令，快照完成后，将缓存和命令发送给slave
          1. 进程fork进行全量备份，导致io和cpu消耗，以及写时复制的内存消耗，可能造成主节点毫秒或秒级的卡顿
          1. 发送GB级rdb，会导致网络出口爆增，磁盘顺序IO吞吐量高，会影响正常访问，并带来其他连锁影响
          1. 采用乐观复制，允许复制开始后一段时间内主从数据不一致，但是会最终同步。不会同步给从后再返回给客户端，保证主的性能
        - slave载入快照(和重启原理一致)，并执行缓存的命令
          1. 从同步时不会阻塞，可设置是否响应的命令
     1. 同步阶段：master每次收到写命令时，就将命令同步给salve，贯穿始终
   - 增量复制
     1. 实现基础
        - 从记录主的每次重启变更的run id
        - 主同步给从时，会将命令放到backlog中，并记录命令的偏移量范围
        - 从接收命名时，也记录下命令的偏移量
     1. 断线重连判断标准
        - run id是否一致
        - 最后同步的命令偏移量是否在队列中，不在只能全量同步
   - 从持久化：为提高性能，禁止主的持久化，开启从的持久化，从崩溃重启后主自动将数据同步过来。主崩溃后，严格顺序按照步骤，先从提升为主，主再切为从
1. 哨兵
   - 认识：独立的进程，可开多个，哨兵可相互监控，对节点做失败判定分为主观下线和客观下线，对从做主观下线不执行故障转移。2.6版本的哨兵不能用。最少3个，2个无法做投票
     1. 故障检测：做redis的存活性检测，提供高可用
        - 单点视角
        - 检测信息传播
        - 下线判决
     1. 故障恢复：自动主从故障切换，
        - 选举：Raft算法的Leader Election方法，节点拉票、拉票优先级、主节点投票
   - 使用
     1. 命令：`redis-sentinel xx.conf`，只监控主数据库即可，会自动发现从
     1. conf内容：`sentinel monitor masterName ip port 执行恢复的最低哨兵通过票数`，可同时监控多个主从系统
1. 集群
   - 认识：cluster，用于解决容量和并发性能，单机受制于主库的内存容量，利用多台计算机内存来实现更大的数据库和带宽
     1. 采用无中心架构，每个节点都保存数据和整个集群状态，每个节点都和其它所有节点连接(ping-pong机制)。可线性扩展到1000个节点
     1. 一致性哈希思想
     1. 客户端直连，免去了代理损耗
     1. 要求客户端缓存slots mapping信息并及时更新
     1. 不能保证数据强一致性
     1. 不支持跨slot查询和修改，不支持跨solt事务操作，支持的不友好
     1. 不支持多数据库空间，集群模式只能用0
     1. 不支持嵌套树状复制结构
     1. 重试时间应该大于cluster-node-time时间
     1. 不建议使用pipeline和multi-keys操作，减少max redirect产生的场景
   - 实现：实现基础是分片，将分片指派给多个实例
     1. 分片：利用槽，redis使用虚拟槽来处理分区时节点变化的问题。将所有的物理节点映射到预分好的16384个slot中
        - 槽：hash slot，根据`CRC16(key) Mod 16384`决定key在哪个槽中
     1. 节点状态同步：Gossip协议，轻量的二进制协议，最终一致性。存放哈希槽的bitmap通过Gossip协议在结点之间传递
     1. 高可用性：通过增加slave做热备数据副本，能够实现故障自动转移
   - 实现方式
     1. 查询路由：Query Routing，先到随机节点，这个节点保证你到正确的节点，或者客户端重新发起到正确节点
     1. 客户端分片：Client Side Partitioning，客户端直接选择正确的节点，如Jedis
        - 逻辑简单，性能高
        - 业务逻辑和数据存储逻辑耦合，可运维性查。多业务各自使用redis，集群资源难以管理，不支持动态增删节点
     1. 代理协助分片：代理根据配置的分片模式转发到正确的节点，如Twemproxy、Codis，比较成熟
   - 故障转移
     1. 身份切换
     1. 接管职权
     1. 广而告之
     1. 履行义务
   - 使用
     1. `cluster info`：查看状态
     1. `cluster nodes`：查看节点
     1. `cluster meet 127.0.0.1 6380`：连接节点
     1. `cluster addslots {0...5461}`：分配槽位
     1. `cluster replicate xx`：分配为某节点的从
     1. `redis-cli -c`：连接集群，c是集群模式
1. 扩容：横向扩容、纵向扩容
1. 守护进程
   - daemonize no：yes
   - pidfile /var/run/redis.pid：pid位置
1. 分区
   - 认识：分割数据到多个Redis实例。提高容量，扩展计算能力和带宽
     1. 不支持多个key同时操作，事务中也不行
     1. 多实体数据库维护复杂，容量调整复杂，用presharding解决
   - 类型
     1. 范围：不同范围放到不同实例中，需要维护范围表
     1. hash：使用crc32将key转为数字，然后取模(模为实例数量)确定实例
   - 自动分区：cluster
### 运维
1. 命令
   - 服务器
     1. info：服务器信息
     1. client list：客户端列表
     1. ping：查看是否运行
     1. monitor：实时打印接收到的命令，调试用
     1. debug segfault：让redis崩溃
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
   - redis-benchmark [option] [option value]
     1. -h/-p：地址端口
     1. -s：指定socket
     1. -c：并发连接数
     1. -n：请求数
     1. -d：字节形式指定set/get大小
     1. -k：1=keep alive 0=reconnect
1. lua
   - 认识：高效的轻量级动态类型的脚本语言，lua是葡萄牙语月亮的意思，是卫星语言，能够方便嵌入其他语言中
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
1. Memcache：高性能分布式内存对象缓存系统，内存里维护一个统一的巨大的hash表，能够存储图像等数据
1. 数据库缓存一致性方案
   - key过期，mysql更新不更新redis
     1. 开发成本低，管理成本低
     1. 不一致时间很长
   - key过期，mysql更新时，更新redis
     1. 延迟更小
     1. 损耗双倍资源
   - key过期，消息队列异步更新redis
   - key过期，从库订阅binlog来更新redis
1. 阿里云架构：百万QPS，最好性能512G内存、最大连载数320000、最大吞吐1536M
   - 负载均衡
   - 多个proxy，负责故障转移
   - 分片服务器，单节点，不需同步数据，不提供数据持久化和备份策略，节点故障会丢失数据。集群版是双节点
   - 配置服务器，即Configserver，存储集群配置信息及分区策略，采用双副本的高可用架构
1. 使用
   - 避免产生hot-key，导致主库节点成为系统的短板
   - 避免产生big-key，导致网卡撑爆、慢查询等
### 架构
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
1. Codis
   - 没有pipeline
1. Pika
1. cluster：太复杂，是去中心化的。没有tw的简单，用的稳定
### wiki
1. 历史
   - 2009年，开源
   - 2.6：set命令增加键存在与否的判断和过期时间的设置，新增lua环境
   - 2.8：新增，支持复制的断线重连时有条件的增量数据传输，可用的哨兵机制
   - 2.8.9：新增，HyperLogLog
   - 2.8.18：新增，无硬盘复制(避免硬盘性能瓶颈)
   - 3.0：2015年，新增，集群功能
1. 数据类型的适用场景
   - string：可持久化的缓存，如session_id为key的session，二进制安全，图片、文件什么的，原子计数器做粉丝数、关注数、ip封锁次数啥的
   - hash：存对象数据，如用户基本信息，直接更新即可
   - list：消息排行，消息队列，日志收集器，配合发布订阅
     1. 队列的安全性：单个队列一旦pop出去客户端崩溃，消息丢失，利用rpoplpush弄个备份队列，数据丢了再去备份队列取一下
   - set：做不重复的集合，存不重复用户名啦、每日投票一次啦
   - zset：有序的不重复集合，如热门内容的排序，只需修改score，排行榜
1. 编程语言客户端
   - php：官方推荐两个
     1. Predis：php代码实现的原生客户端
     1. phpredis：c编写的php扩展，性能更好
   - ruby：redis-rb，最稳定的客户端
   - python：redis-py
   - node：node_redis、ioredis，前者早，后者功能丰富
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
1. 网校redis架构
   - 高可用：confd + etcd + tw + redis一从热备 + sentinel
     1. etcd集群做保活，设置10秒过期，tw每2秒续期，一旦tw发生变化，etcd切换tw，通知confd
        - etcd：go编写，支持watch并且主动通知
     1. confd收到etcd的通知后，完成客户端ip配置文件的更新
     1. 客户端sdk负责负载均衡
     1. 一从热备：假如从库一直提供服务，从库一旦重连导致从库数据不对
     1. 哨兵监控：完成主从切换后，通知etcd
   - 扩容：找新机器，用工具同步存量+增量的旧数据，然后挂到tw上
   







   
1. #主库重启 checklist 

1. 世纪互联主从库节点 zabbix 关闭报警

2. 世纪互联主从库节点 注释脉搏脚本

3.  切换Master到从库，修改参数并重启

redis-cli -h 10.20.52.245 -p 1379 sentinel failover jy-app-redis
redis-cli -h 10.20.52.245 -p 2379 sentinel failover jy-appapimanager-redis
redis-cli -h 10.20.52.245 -p 4379 sentinel failover jy-handout-redis
redis-cli -h 10.20.52.245 -p 5379 sentinel failover jy-material-redis
redis-cli -h 10.20.52.245 -p 6379 sentinel failover jy-workflow-redis
redis-cli -h 10.20.52.245 -p 7379 sentinel failover jy-wordlibrary-redis
redis-cli -h 10.20.52.245 -p 8379 sentinel failover jy-courseware-redis
redis-cli -h 10.20.52.245 -p 9379 sentinel failover jy-tnt-redis


vim /boot/grub/grub.conf
isolcpus=10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29 

for i in {1..9}; do /etc/init.d/${i}379redis stop; done 

init 6

5. 重启完成后sysbench验证,重启redis服务
/bin/rm -rf /root/scripts/sysbench.sh
cd /root/scripts && wget -N --http-user=XueRs --http-passwd=xueersi123 http://soft.xesv5.com:88/dell/sysbench.sh
./sysbench.sh  --test=cpu --num-threads=${v_cpu_num} --max-requests=600000 run

for i in {1..9}; do /etc/init.d/${i}379redis start;sleep 60; done 

for i in {1..9};do sed -i '/slaveof/d' /data/${i}379redis/etc/redis.conf;done

for i in {1..9};do cat /data/${i}379redis/etc/redis.conf |grep slaveof;done

6. 同步完成后，切回原主

redis-cli -h 10.20.52.245 -p 3379 sentinel failover jy-app-redis
redis-cli -h 10.20.52.245 -p 3379 sentinel failover jy-appapimanager-redis
redis-cli -h 10.20.52.245 -p 4379 sentinel failover jy-handout-redis
redis-cli -h 10.20.52.245 -p 5379 sentinel failover jy-material-redis
redis-cli -h 10.20.52.245 -p 6379 sentinel failover jy-workflow-redis
redis-cli -h 10.20.52.245 -p 7379 sentinel failover jy-wordlibrary-redis
redis-cli -h 10.20.52.245 -p 8379 sentinel failover jy-courseware-redis
redis-cli -h 10.20.52.245 -p 9379 sentinel failover jy-tnt-redis

7. 开启zabbix报警和脉搏，sentinel reset 

8. yf的同步节点挂到sjhl从库

9. 
/etc/init.d/irqbalance restart
chkconfig irqbalance on
