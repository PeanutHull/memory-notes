### 认识
1. 认识：高吞吐量、高负载量的分布式流处理平台和消息系统
   - 高性能：高吞吐量/高并发/低延迟/时间复杂度O(1)，单机写入TPS约在100万条/秒，消息大小10个字节
   - 高可用：数据快速持久化、故障转移
   - 分布式：基于zk原生支持集群的水平热扩展、集群容错、消息自动平衡
1. 功能
   - 发布/订阅：消息系统，使用推拉模式
   - 提供offset管理，支持消息堆积，可查看历史数据，零消息丢失和高效的一致性处理，
   - 内置流处理：连接、聚合、过滤器、转换
   - 实时事件响应
   - 支持数据批量发送拉取
   - 自己的二进制消息传输协议，消息压缩传输：消费者获取，镜像数据传输
   - 集群镜像：提供官方工具同步并重新发布消息
1. 特点
   - 适用
     1. 消息实时传输：消息系统、用户活动跟踪
     1. 在线和离线分析：大数据日志收集处理
     1. 流式数据处理：能构建实时的流数据处理程序来处理数据流，大数据时代数据管道技术首选
   - 缺点：严格的顺序机制，不支持标准的消息协议，不支持消息优先级
1. 设计
   - 多分区、多副本，消息自动平衡，快速持久化、容错性
   - 支持同步和异步复制：副本模式
     1. 同步：生产者从zk找到leader，发布消息后存入leader的log中，follow使用一个channel来pull消息，写入自己log后发送确认消息，收到所有follow的确认消息才给生产者发送ack
     1. 异步：写入log后立即发送确认信息，无法保证broker故障时的消息分发
   - 基于zk调度，进行服务协调管理
1. 重难点
   - 消息偏移量
   - 日志存储机制
   - 主题订阅
   - 故障发现
### 组成
1. topic
   - 认识：主题，逻辑概念，用于存储、区分消息，在broker上
     1. 紧凑的二进制字节数组，避免了java繁重的堆上内存分配
   - 组成
     1. serializer：序列化器，对象、字节相互转换的编解码器
1. message
   - 组成
     1. key：消息键，决定放到哪个partition
        - 有key：按照key进行哈希，相同key去一个partition
        - 无key：round-robin来选partition
     1. batch：分批发送
     1. schema：消息编码方式
   - 属性
     1. 消费超时时间
     1. 最大重试次数：重新投递给业务方的最大重试次数，业务方消费消息的时间超过"消费超时时间"时，消息会判断消费失败，
     1. QOS：并发回调个数
1. partition
   - 认识：分区，有序的数据存储基本单元，一个topic分为n个有序号的partition
     1. 只支持顺序读写，在尾部追加消息，总是写最新的segment，每个消息有一个位移，单partition消息有序，全局不是
     1. 是分布式的，保证了伸缩性，可用于负载均衡
   - 组成
     1. segment
     1. offset：偏移量，递增的整数值。既可表示消息存在的位置，也能表示消费者消费到的位置
1. replica
   - 认识：副本，partition的复制，防止数据丢失
     1. 一个partition可多个replica，每个都可能成为leader
     1. 主失效立即再选举，从挂掉/卡住/同步太慢会被删除再创建一个
     1. 同一个partition的多个replica不会在一个节点上
   - 组成
    1. leader：首领replica，同一个topic只有一个
        - 接受生产消费请求
        - 明确同步的follower
    1. prefer leader：首选首领，即希望成为leader的partition
        - 如果设置自动leader平衡，那么首选首领不是当前首领时会自动触发选举
    1. follower：主要用于备份消息
        - 从leader复制数据，可以有多个
   - ISR
     1. 认识：in-sync replica，同步的replica，集合里的才能选为主
        - leader检测follower的偏移量，滞后一定程度时踢出ISR，追上再加回，自动的
        - 集合中所有replica都收到消息才会置为已提交
        - kafka的信息交付承诺：在ISR存活的条件下已提交信息不会丢失
     1. 配置
        - min insync replicas：最少同步replica
#### 角色
1. 角色：![avatar](../images/kafka_struct.jpeg)
   - cluster
     1. 认识：集群，很多台机器组成
        - 天然支持集群，没有单节点说法，一台也是集群，通过brokerId区分不同节点
        - 依赖zk进行协调，连接同一个zk就是同一个集群
     1. 组成
        - controller：执行者，活跃broker中选举，负责partition在broker的分配、leader的选举、broker监控，在zk的/brokers/ids节点上注册watch
   - broker
     1. 认识：kafka集群的部署节点
        - 对消息集群内分区部署平衡，partition会平均分布在节点中，自己有协调机制
        - 访问任意一个broker都可以完成请求，因为有数据同步机制
     1. 组成
        - replicaManager：管理当前节点所有分区和副本
        - temporary node：临时节点，其他broker订阅zk的临时节点从而知道有broker宕机
   - client
     1. metadata request：元数据请求，客户端可向任意broker获取topic的分区/副本/leader。客户端会缓存信息并定时刷新，客户端会直接发送请求到leader
1. producer
   - 认识
     1. 批量发送，会积攒一批，然后一起发送
   - 生产请求：produce request
     1. 先验证是否有权限写入
     1. 其次看返回值ack=0、1、all，以便消息成功接收
   - 发送方式
     1. 同步发送：等待返回发送后的结果
     1. 异步发送：不关心是否成功，速度最快
     1. 异步回调发送：使用回调函数保证消息一定收到
     1. 异步阻塞发送
     1. 自定义分区负载均衡
   - 事务方法：跨多分区的原子性写入
     1. initTransactions
     1. beginTransaction
     1. sendOffsets
     1. commitTransaction
     1. abortTransaction
   - 客户端原理：![avatar](../images/kafka_producer_client.png)
   - thread safe：线程安全，生产者时线程安全，消费者不是线程安全的
   - 生产幂等性
     1. 为每个producer分配一个唯一标识pid，producer为每一个partition维护一个单调递增的seq
     1. 当req_seq == broker_seq+1时，broker才会接受该消息，大了还没写入，小了已经写入了
1. consumer group
   - 认识：一组consumer，kafka消费的单位
     1. 单partition只能由组中某个消费者消费，否则kafka需要加锁，会影响性能，就这样规定了
     1. 单个消费者可以消费多个partition
     1. 最佳实践：消费者数量和partation相等，多了没活干歇着浪费，少了性能不行
   - 组成
     1. group coordinator：群组协调器，也是某个broker，负责接收消费者的心跳，传递由群主发来的分区分配信息到其他消费者，总之就是协调消费者的中间角色
     1. group manager：群主，消费者要加入群组时，会向群组协调器发送joinGroup请求。第一个加入群组的消费者将成为群主。群主从协调器拿到消费者列表，并为其他消费者分配分区，之后传递给协调器，协调器在发送所有权关系到相应的消费者，所以只有群主知道所有消费者的分区分配信息。再均衡时这个过程会重复发生
     1. rebalance listener：再均衡监听器，在再均衡发生时，可以让某些消费者失去分区的所有权之前，做一些提交或者清理工作。分别有两个钩子，发生在再均衡之前重分配之后
   - 概念
     1. 规则：控制读写等权限
     1. partition ownership：消费者拥有哪个分区的所有权
     1. consumer heartbeat：消费者心跳，用于维持与群组的关系和分区的所有权。心跳也是在poll或者commit offset时发送的
        - 消费者异常时，群组协调器会等待几秒确认他死亡才触发再均衡，所以正常情况下消费者在主动离开时会告诉协调器，协调器立即触发再均衡，减少停顿，非正常离开可能会导致整个群组在一段时间内无法读取消息
     1. consumer reblance：消费者再均衡，组内发生分区所有权转移
        - 认识
          1. 带来了消费者的高可用性和可伸缩性
          1. 期间消费者无法读取消息，造成群组一小段时间的不可用。另外分区重新分配给消费者时，消费者当前读取状态会丢失，可能需要刷新缓存
          1. 只会在poll操作中发生
        - 发生条件
          1. 消费者加入/崩溃/离组/提交位移
          1. topic数变化
          1. partition数变化
     1. lag：消费者延迟，消费者位置与最新的offset之间的距离
   - 功能
     1. consume request：消费请求，broker会缓冲一些消息，直到达到数量或时间，再返回给消费者。以此提高性能
     1. poll：消费者请求数据的行为。但不只是请求数据，例如心跳的发送，再均衡也是在poll中进行的。所以要确保在poll中任何处理工作尽快完成
     1. commit：更新分区的当前位置，即手动控制offset位置，可提交偏移量到内部主题_consumeroffset
        - auto commit：每过一定周期自动提交poll下来的最大偏移量
        - 应用场景
          1. 指定开始位置
          1. 消费失败，需要重复消费
     1. consume限流，怕把consume流量高打死，用令牌桶方式
     1. 消息投递语义：明确一次的语义需要使用kafka事务，让消费者的offset存储和消费者的输出存储之间实现一个两段式的提交
   - 形式
     1. 多个consumer：![avatar](../images/mult_consumer_one_handle.png)
        - consume数量和partation数量相同，性能最好，否则存在分配的开销
        - consume处于阻塞状态，适合普通业务场景，可以有好的管控，如消费3次不成功就报警
     1. ![avatar](../images/one_consumer_mult_handle.png)
        - consume变成非阻塞消费数据，后边线程池处理业务逻辑，但consume不知道后边是否成功可以commit，特点是减少consume消耗实现快速消费，适合非业务系统，如流处理，gps打点，机器监控，丢一些无所谓
1. stream
   - 认识：流式数据处理，通过state store实现高效状态操作，支持原语processor和高层抽象DSL
     1. stream流处理流程
        - 有inputTopic和outputTopic，处理完自动输出，state store记录每个task的状态
     1. stream高层架构
     1. stream开发
   - 组成
     1. 流、流处理器
     1. 流处理拓扑
     1. 源处理器、sink处理器
1. connector
   - 认识：是流式计算的一部分，用来和其他中间件建立流式通道，支持流式和批处理集成
     1. 作用、背景
        - 连接一端数据转换后输出到另一端
        - 连接器，直连db数据交互，从源系统中拉取数据到kafka
        - 大家都用的少，logstace比他强
     1. 高层架构
     1. 使用
        - confluent：常用的依赖jdbc的connector组件
          1. 指定根据哪个字段作为新增或者修改数据的依据
          1. 指定数据修改的模式
   - 模式
     1. standalone
     1. distributed
1. api
   - admin
     1. 查看topic列表、属性等
   - producer
     1. high level api：替我们把很多事情都干了，offset，路由啥都替我们干了，用以来很简单
     1. simple api：offset啥的都是要我们自己记录
   - consumer
   - stream processor：高效将输入流转换到输出流
   - connector
#### 设计
1. partition
   - 读写
     1. 特点
        - 每个partition的日志分为n个大小相等的segment文件存储
        - 每个segment的消息数量不一定相等(消息大小不同)
     1. 写
        - partition将消息串行追加到最后一个segment上，segment达到阈值就滚动到新segment
          1. active segment：活跃片段，当前正在写入的片段，活动片段不会被删除
        - segment一定阈值后flush到磁盘上
     1. 读：一级级的检索快速找到消息内容，顺序读取磁盘可以有很高的性能
        - 用offset通过active segment list文件：找出具体的哪个segment
        - 找这个segment的index文件得到segment中消息的起始位置offset
        - 通过上个offset移动到某条消息的开头后，先读取4字节，就可以知道整个消息的长度了，最后读取整个消息内容
   - offset保存
     1. 保存在__consumeroffsets的topic中，消息的key由groupid、topic、partition组成
     1. value是偏移量offset，清理策略compact，缓存在内存中，第一次遍历partition建立缓存
   - 分配
     1. 步骤
        - 将n个broker和待分配的partition排序
        - 将第i个partition分配到第(i mod n)个leader broker上
        - 将第i个partition的第j个replica分配到第((i+j) mode n)个broker上
     1. 重分配：partition reassign：发生在分区数变化，或分区更改到其他broker
   - 多副本同步
     1. 认识：处理follower批量拉取数据同步leader
     1. 消息生产可靠性：`request.required.acks`
        - 0，发过去就完事了，不关心broker是否处理成功，可能丢数据
        - 1，当写Leader成功后就返回,其他的replica都是通过fetcher去同步的,所以kafka是异步写，主备切换可能丢数据
        - -1，要等到ISR里大于min.insync.replicas同步成功，才能返回成功，延时取决于最慢的机器。强一致，不会丢数据
     1. epoch机制
1. 日志
   - 认识
     1. 以partition为单位进行保存，offset就是起始位置
   - 组成
     1. TopicName + Num：日志目录
     1. partition
     1. active segment list：追加、读取、删除，用于确认具体的索引文件
        - 是一个offset区间，有了offset就可确认哪个segment
        - 查找消息用二分法，找出对应的offset在哪个segment的索引中，在定位出offset在segment中的大概位置，再遍历查找message
     1. segment
          1. xxxxxxx.index：
             - 左边是partation的全局offset，右边是segment的offset，
             - 一条条的记录每条消息的字节位置，这样直接可以取到消息
          1. xxxxxxx.log：segment file，包含一个个的message内容
          1. xxxxxxx.timeindex：时间排序的索引
          1. leader-epoch-checkpoint
     1. message
        - offset：4byte
        - message length：4byte(1+4+n)，消息长度
        - crc：4byte，CRC校验码
        - magic value：1byte，版本号
        - attributes：1byte
        - timestamp：4byte
        - key length：4byte
        - key
        - value length：4byte
        - playload：n byte，消息内容
   - 索引
     1. 认识：为减少索引文件大小方便直接加载进内存，索引使用稀疏矩阵，每隔一定的字节数再建立一条索引
     1. 组成
        - baseOffset：对应segment文件中的第几条message。方便使用数值压缩算法节省空间。如varint
        - position：在segment中的绝对位置
1. 情况设计
   - leader选举
     1. unclean leader election：不完全首领选举，允许不同步的副本成为首领，提高可用性，增加丢消息的风险
     1. 过程
        - 没有采用多数投票来选举，首先通过抢注zookeeper的/controller+epoch机制竞争leader
        - 当controller发现有broker离开集群，在ISR中选择速度比较快的作为leader，谁先接收到算谁
        - 随后新leader开始接受生产消费请求，follower从leader复制数据
   - leader容灾
     1. broker宕机后，controller从zk的/brokers/topics/[topic]/partitions/[partition]/state中，读取ISR（in-sync replica已同步的副本）列表，选一个出来做leader
   - broker容灾
     1. 认识
        - 不会因为节点故障丢失数据
        - kafka的语义担保也能很大程度避免数据丢失
        - 会对消息进行reblance，减少节点消息热度太高
     1. 判定标准：心跳未保持、消息落后leader太多
     1. 动作：移除
### 架构
1. 中间件
   - MQProxy
     1. 认识：让用户更便捷的使用kafka，用户无需对kafka有过多的了解，无需过多关心kafka的健康状况，专注业务编码
        - 通过http 的形式和proxy进行交互，proxy负责保障数据写入的可靠性和位移提交的便捷性
        - java dobbo开发
     1. 提供的服务
        - 延时队列
        - 重复消费
        - 位移回溯
        - 死信队列
        - lag监控
        - 消息灾备：由决策器来判断将消息发往目标kafka还是备份kafka
        - 消息回调
     1. 待开发的服务
        - 顺序性
        - 事务性
        - 消息审计
        - trace
        - 死信重发
     1. 架构
        - 生产者
          1. 心跳连接：生产者代理收到消息后通过和kafka之间的心跳来判断server的健康状态
          1. 重新投递：发往备份kafka的消息都会由备份kafka的消费者从新把消息投递回目标队列
          1. 本地存储/删除：生产者异步的将消息发送到kafka,发送前会把消息存储至本地mapdb做磁盘存储，成功就删除
        - 消费者
          1. 过期时间：可以指定消息的最大消费次数,和消费时间
          1. 重复消费: 在指定的消费时间内没有提交位移,我们会把消息重新投递给业务方,直到消息提交或达到消息的最大消费次数为止
          1. 预拉取: 为了保障业务方的消费速率,我们采用的是预拉取模式,即预先将消息拉取到mqproxy内存中,但是这样使得mqproxy变成了有状态模型
          1. 无状态: 为了消除对业务方的状态,我们采用了java的高速率分布式传输框架dubbo,dubbo的提供者(server端)负责从kafka拉取消息, dubbo的消费者(portal端)负责从提供者拉取消息并推送给业务方,server和portal通过zookeeper做协同, 这样对于业务方来说mqproxy是无状态的,即可以从portal的任意节点拉取消息
          1. 位移合并细节实现
             - merge proxy 负责将业务方提交的位移进行合并
             - 它用流计算的方式 消费"offset-commit-topic"中的消息,并进行位移合并,将合并的结果存放到"offset-merge-topic"
             - "offset-merge-topic"是compact类型的topic,因为最后一次的位移结果对mqproxy来说才是有价值的
             - offset-merge-topic的key值设计为 topic+group+partition , value值设计为 位移合并结果如:[1-80],[82-100]
             - 消费者代理第一次启动会读取"offset-merge-topic"中的所有位移,并找到回溯位置进行消息回溯,因为是compact类型的topic,所以这个过程很快
        - 延时队列架构
          1. 指定级别延时队列实现
             - 预先创建常用固定时延级别的topic，用户只能发送这些时延种类的消息
             - proxy消费这些消息并且把消息拉取到内存中,在java的延时队列中进行倒计时
             - 倒计时结束，将消息投递给真实的topic，并且向固定时延的topic提交位移
          1. 任意级别延时队列实现
             - 基于指定级别延时队列来实现任意级别延时队列
             - 投递到一个指定级别的topic中,如果在这个级别的消息过期后,我们再将它投递到下一个级别的topic中，余数原理
   - 多数据中心数据同步：MirrorMaker是Kafka官方提供的用来做跨机房同步的组件，使用Kafka Connect的方式进行部署，现在还有2.0版本
     1. 可实现主主、主备
        - 主备：数据同步到备，必要时（如failover）启动，使用历史数据进行恢复
        - 主主：数据同步到其他数据中心，被其他数据中心的消费者消费。同步后的Topic带有机房标识的前缀，应该有明确的需要同步的topic列表便于控制，而不是全部
1. 应用案例
   - 基于SSD的Kafka应用层缓存架构设计与实现
     1. 背景
        - 出色的io优化和异步化设计
        - Produce的Server端的I/O线程统一将请求中的数据写入到操作系统的PageCache后立即返回，当消息条数到达一定阈值后，Kafka应用本身或操作系统内核会触发强制刷盘操作
        - Consume请求主要利用了操作系统的ZeroCopy机制，Broker接收到读数据请求时，会向操作系统发送sendfile系统调用，操作系统接收后，首先试图从PageCache中获取数据；如果数据不存在，会触发缺页异常中断将数据从磁盘读入到临时缓冲区中，随后通过DMA操作直接将数据拷贝到网卡缓冲区中等待后续的TCP传输
     1. 问题：多个Consumer时，竞争PageCache资源导致产生延迟。消费延迟后会刷盘而且PageCache中不存在，读的时候需要多一次磁盘读取并触发预读部分数据到PageCache，因为LRU策略会替换PageCache中实时的缓存数据
        - 消费能力充足的Consumer消费时会失去PageCache的性能红利
        - 多个Consumer相互影响，预期外的磁盘读增多，HDD负载升高，毛刺增多，服务不稳
     1. 现状：通过线上统计消费延迟分布情况，20%的没有使用PageCache，单机的PageCache平均分配为80GB，流量在170MB/s，PageCache最大可缓存数据时间跨度为80*1024/170/60 = 8min，对延迟消费容忍度较低
     1. 方案
        - 根据数据局部性原理：SSD做"PageCache"高速存储，HDD做更底层存储，技术有FlashCache、BCache、DM-Cache、OpenCAS
          1. 优点：数据对应用层透明，应用代码改动小
          1. 问题：没有根本改变，都会发生缓存污染
        - kafka内部实现：维护的消息偏移量区分实时和低速消费，随时间的推移淘汰到HDD上，采用
          1. 优点：充分考虑kafka读写特性，实时消费全在SSD保证低时延，HDD读取不会会刷到SSD防止缓存污染；日志段有明确唯一状态，查询路径最短，不存在CacheMiss的开销
          1. 缺点：需要server端改进，开发、测试工作量大，需要随社区大版本升级，但可以代码贡献社区解决迭代问题
### 运维
1. mac启动
   - `zookeeper-server-start /usr/local/etc/kafka/zookeeper.properties`
   - `kafka-server-start /usr/local/etc/kafka/server.properties`
1. 命令行使用
   - topic
     1. 查看列表：`kafka-topics --list --bootstrap-server localhost:9092`
     1. 查看某个：`kakfa-topics --describe --zookeeper localhost:2181 --topic xx`
     1. 创建：`kakfa-topics --create --zookeeper localhost:2181 --topic xx --partition 1 --replication-factor 1`
        - replication factor：复制系数，一个分区的副本数量
     1. 删除：`kafka-topics --delete --zookeeper localhost:2181 --topic`
   - 消息
     1. 发送：`kafka-console-producer --broker-list localhost:9092 --topic xx`：不间断，回车发送
     1. 消费：`kafka-console-consumer --bootstrap-server localhost:9092 --topic xx --form-beginning`
1. 创建
   - 参数
     1. 节点选取
     1. topic名称
     1. 分区数
        - 压缩类型：zstd、lz4、snappy、gzip、生产者决定
        - 清理策略
          1. 方式
             - compact：压实
               1. 当键不为null时，相同的键只会保留最后的值
             - delete
               1. 完全删除某个key：设置value=null。kafka会先进行常规清理，该消息作为墓碑消息保留一段时间
             - compact + delete
          1. 单分区数据保留字节数
          1. 单分区数据保留天数
     1. 副本
        - 数量：2副本、3副本
        - 不完全副本选举
          1. 开启：可用性优先
          1. 不开启：可靠性优先
     1. 最大消息字节数：最大10MB
     1. 消息版本号：0.11之前不推荐使用
     1. 最少ISR
        - 1：可用性优先
        - 2：可靠性优先
   - 注意点
     1. 高峰流量峰值
     1. 高峰流量时段
     1. 低峰流量时段
1. 配置
   - broker
     1. unclean.leader.election.enable：不严格的leader选举，助于集群健壮，但有丢失数据风险
     1. min.insync.replicas：最小的同步状态的副本，否则不接受写入请求
     1. cleanup.policy：生命周期结束的数据处理，默认删除
     1. flush.messages：强制刷新写入的最大缓存消息数
     1. flush.ms：强制刷新写入的最大等待时长
   - 消息大小：最大2G
     1. broker
        - message.max.bytes :524288000B(500M)，单消息最大值
        - replica.fetch.max.bytes :536870912B(512M)，可复制的单消息最大值，比上边小了复制不了
     1. producer
        - max.request.size：524288000B(500M) 生产者能请求的最大消息，大于或等于message.max.bytes
     1. consumer
        - fetch.message.max.bytes：524288000B(500M) 消费者能读取的消息最大值，大于或等于message.max.bytes
     1. jvm
        - 堆内存：kafka-server-start.sh文件的`export KAFKA_HEAP_OPTS="-Xmx6G -Xms6G"`
   - 生产者
     1. ack
     1. 压缩
     1. 生产方式：同步、异步
   - 消费者：设置不合理会频繁发生rebalance，造成消费不可用
     1. session.timeout.ms：超时时间
     1. heartbeat.interval.ms：心跳时间间隔，需要有心跳线程
     1. max.poll.interval.ms：每次消费的处理时间
     1. max.poll.records：每次消费的消息数
   - 服务器
     1. 文件描述符：10万以上
     1. pagecache：和大多数的激活日志段大小相同
     1. 禁用swap
     1. 分区：单broker数量不超2000，大小不超25G
1. 监控
   - web管理界面：cmak，即Kafka-Manager
   - 管理工具：kafka-run-class.sh
   - 脑裂问题：检测、自动恢复？
1. topic删除
   - 认识
     1. 需要考虑生产者生产，消费者消费，broker损坏怎么办
   - 设置
     1. auto.create.topics.enable = false：要不然删不掉
     1. delete.topic.enable = true：最好打开，不然有问题
   - 原理
     1. 特点
        - 异步线程 + 延时操作
     1. 步骤
        - 注册zk的delete_topics节点的变化监听器
        - 启动删除topic线程，这时删除线程阻塞并等待删除事件
        - 执行删除命令时，在delete_topics节点添加
        - 唤起删除线程
        - 执行删除逻辑：删除分区信息、删除zk目录、清除controller中相关cache
        - 删除线程继续阻塞
     1. 最佳实践
        - 断掉所有访问：使用域名访问，切断解析，保证一定无流量进入
        - 进行删除
### 最佳实践
1. topic分区数如何确定：根据实际需要设置数量，实现性能最大化
   - 特点
     1. kafka集群非常喜欢顺序读写，过多的分区会使得集群退化为随机读写
   - 原则
     1. 最好为broker的倍数，一般为3的倍数，这样分区可以均匀分布在所有broker上
     1. key hash的业务，需要在最初就定义好分区数，因为如果添加分区，原来的数据是不会自动重新hash的
1. 实现顺序消费
   - 业务自己封装基于分区的顺序消费，即不同分区，放到不同线程，另外提高并发度之一就是降低锁的粒度，可以基于业务key的放到不同线程中处理，如不同用户的账户增减可以并行
   - 要保证消息顺序，可将partition设为1，一个partation只能有一个consume，性能太低，不如天生有序的rabbiemq呢
   - 可以使用key + offset做到业务有序，一个key确定同一类型，offset作为顺序的判断，如先存了es，时序数据库中，攒够了一起处理
1. out-of-range
   - 认识：一般是消费速度不够快，服务端已经删除了消息。要么增大kafka的保留策略，要么提高消费能力
### wiki
1. 端口
   - kafka：9092
   - zk：2181
1. 历史
   - 最新：2.8
   - 2019.10：2.3.1
   - 2017.11：稳定版本
   - 2011：加入apache
   - 2010：开源，由Scala和Java编写，最初由Linkedin开发，最后贡献给Apache基金会并成为顶级开源项目
1. 版本
   - 0.11：事务支持，11版本前非常依赖zk，之后慢慢减轻
   - 0.10：推出kafka streams组件，成为流式处理框架，本质还是消息的流转
   - 0.8：集群间备份，java重写生产者，不再依赖zk
1. 其他
   - Confluent Platform：分为开源和商业版本，提供了kafka没有的完善的跨数据中心数据备份和集群监控方案等
   - linux比windows的io模型和网络传输的零拷贝都厉害
   - SASL：一种身份认证框架，sasl验证架构决定服务器本身如何存储客户端的身份证书以及如何核验客户端提供的密码。成功通过验证服务端能确定用户的身份和权限
     1. kafka使用java认证和授权服务（JAAS）进行SASL配置
   - LinkIn开源的东西
     1. Databus：分布式数据同步系统
     1. Cubert：高性能计算引擎
     1. ParSeq：java异步处理框架
### 源码与实现
1. 认识
   - 底层实现知道原理，来龙去脉，不变应万变
   - 会比较晦涩
1. 设计原理
   - 顺序读写、快速检索
   - partition机制
   - 批量发送接收、数据压缩机制
   - 可伸缩的消息持久化
   - 高效率
   - 消息传递保障
   - 副本集
   - leader选举
   - 日志压缩
   - 存储：采用内存页缓存 + 异步io + 追加写入的方式，磁盘顺序访问，实现吞吐量高，写操作性能强
   - 读取：消费过程零拷贝 + 线性操作 + 批量操作。将突发消息转化为线性写入，用少量的延迟换取更好的吞吐
     1. 避免了过高的byte copying和过多的small I/O，良好调优的磁盘io负载很少，因为直接命中缓存
     1. 使用基础
        - java nio channel.transforTo
        - linux sendfile系统调用：io不需上下文切换(内核和用户态之间)，利用直接存储器访问技术(DMA 内核缓冲区之间)
   - 故障转移：基于zk的会话注册机制
   - 伸缩性：基于zk保存服务器状态和消费者信息
1. 面试题
   - 为什么吞吐量大？
   - Kafka的用途有哪些？使用场景如何？
   - Kafka中的ISR、AR又代表什么？ISR的伸缩又指什么
   - Kafka中的HW、LEO、LSO、LW等分别代表什么？
   - Kafka中是怎么体现消息顺序性的？
   - Kafka中的分区器、序列化器、拦截器是否了解？它们之间的处理顺序是什么？
   - Kafka生产者客户端的整体结构是什么样子的？
   - Kafka生产者客户端中使用了几个线程来处理？分别是什么？
   - Kafka的旧版Scala的消费者客户端的设计有什么缺陷？
   - “消费组中的消费者个数如果超过topic的分区，那么就会有消费者消费不到数据”这句话是否正确？如果不正确，那么有没有什么hack的手段？
   - 消费者提交消费位移时提交的是当前消费到的最新消息的offset还是offset+1?
   - 有哪些情形会造成重复消费？
   - 那些情景下会造成消息漏消费？
   - KafkaConsumer是非线程安全的，那么怎么样实现多线程消费？
   - 简述消费者与消费组之间的关系
   - 当你使用kafka-topics.sh创建（删除）了一个topic之后，Kafka背后会执行什么逻辑？
   - topic的分区数可不可以增加？如果可以怎么增加？如果不可以，那又是为什么？
   - topic的分区数可不可以减少？如果可以怎么减少？如果不可以，那又是为什么？
   - 创建topic时如何选择合适的分区数？
   - Kafka目前有那些内部topic，它们都有什么特征？各自的作用又是什么？
   - 优先副本是什么？它有什么特殊的作用？
   - Kafka有哪几处地方有分区分配的概念？简述大致的过程及原理
   - 简述Kafka的日志目录结构
   - Kafka中有那些索引文件？
   - 如果我指定了一个offset，Kafka怎么查找到对应的消息？
   - 如果我指定了一个timestamp，Kafka怎么查找到对应的消息？
   - 聊一聊你对Kafka的Log Retention的理解
   - 聊一聊你对Kafka的Log Compaction的理解
   - 聊一聊你对Kafka底层存储的理解（页缓存、内核层、块层、设备层）
   - 聊一聊Kafka的延时操作的原理
   - 聊一聊Kafka控制器的作用
   - 消费再均衡的原理是什么？（提示：消费者协调器和消费组协调器）
   - Kafka中的幂等是怎么实现的
   - Kafka中的事务是怎么实现的（这题我去面试6加被问4次，照着答案念也要念十几分钟，面试官简直凑不要脸。实在记不住的话...只要简历上不写精通Kafka一般不会问到，我简历上写的是“熟悉Kafka，了解RabbitMQ....”）
   - Kafka中有那些地方需要选举？这些地方的选举策略又有哪些？
   - 失效副本是指什么？有那些应对措施？
   - 多副本下，各个副本中的HW和LEO的演变过程
   - 为什么Kafka不支持读写分离？
   - Kafka在可靠性方面做了哪些改进？（HW, LeaderEpoch）
   - Kafka中怎么实现死信队列和重试队列？
   - Kafka中的延迟队列怎么实现（这题被问的比事务那题还要多！！！听说你会Kafka，那你说说延迟队列怎么实现？）
   - Kafka中怎么做消息审计？
   - Kafka中怎么做消息轨迹？
   - Kafka中有那些配置参数比较有意思？聊一聊你的看法
   - Kafka中有那些命名比较有意思？聊一聊你的看法
   - Kafka有哪些指标需要着重关注？
   - 怎么计算Lag？(注意read_uncommitted和read_committed状态下的不同)
   - Kafka的那些设计让它有如此高的性能？
   - Kafka有什么优缺点？
   - 还用过什么同质类的其它产品，与Kafka相比有什么优缺点？
   - 为什么选择Kafka?
   - 在使用Kafka的过程中遇到过什么困难？怎么解决的？
   - 怎么样才能确保Kafka极大程度上的可靠性？
   - 聊一聊你对Kafka生态的理解