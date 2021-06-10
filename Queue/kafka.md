### 基础
1. 认识：高吞吐量、高负载量的分布式流处理平台和消息系统。适用于消息传输、流式数据处理、在线和离线分析
   - 高性能：高吞吐量/高并发/低延迟/时间复杂度O(1)：每秒几十万
   - 分布式：基于zk，可水平热扩展、集群容错
   - 高可用：数据流永久存储、负载均衡、故障转移
1. 特点
   - 流处理平台：吞吐量高，能构建实时的流数据处理程序来变换或处理数据流
     1. 高性能：单机写入TPS约在100万条/秒，消息大小10个字节
   - 提供发布订阅、topic的支持：本身是分布式流处理平台，只是支持发布订阅和Topic，才认为可以做队列
   - 快速持久化：可以在O(1)的系统开销下进行消息持久化
   - 完全分布式：Broker、Producer和Consumer都原生自动支持分布式，自动实现负载均衡
   - 消息有序：消费者采用Pull方式获取消息。通过控制能够保证，所有消息被消费且仅被消费一次
1. 设计
   - 分区、副本、基于zk调度
   - 持久化：多副本/容错性/消息自动平衡
   - 发布/订阅：消息系统，使用推拉模式
   - 实时事件响应
   - 消息压缩传输：消费者获取，镜像数据传输
   - 内置流处理：连接、聚合、过滤器、转换
   - 保证排序、零消息丢失和高效的一次性处理
   - 提供offset管理，可以使用历史数据
   - 自己的二进制消息传输协议
   - 集群镜像：提供官方工具同步并重新发布消息
   - 支持同步和异步复制
   - 支持数据批量发送拉取
   - 支持消息堆积
   - 副本模式
     1. 同步：生产者从zk找到leader，发布消息后存入leader的log中，follow使用一个channel pull消息，写入自己log后发送确认消息，收到所有确认消息才给生产者发送
     1. 异步：写入log后立即发送确认信息，无法保证broker故障时的消息分发
   - 利用zk进行服务协调管理
1. 应用场景
   - 流式系统、日志收集
   - 消息系统
   - 用户活动跟踪、运营指标监控，即实时处理
### 组成
1. 组成：![avatar](../images/kafka_struct.jpeg)
   - producer
   - consumer/consumer group：topic中增减消息
     1. 一对一
     1. 发布订阅
   - topic：主题，逻辑概念，用于存储、区分消息，在broker上存储
     1. 组成：紧凑的二进制字节数组，避免了java繁重的堆上内存分配
        - key：消息键，决定哪个partition
        - value：消息体
        - timestamp：消息发送时间戳，用于流式处理和其他依赖时间的
   - partition
   - replica：副本，用于防止数据丢失，一个分区多个副本
   - broker：节点，kafka集群的服务器节点
     1. partition会平均分布在节点中
     1. ReplicaManager：管理当前Broker所有分区和副本
   - leader/follower：取代主备的提法，仅一个为主提供服务，从同步数据作为替补，从的写由主的数据变更的广播获取
     1. 主失效立即再选举，从挂掉/卡住/同步太慢会被删除再创建一个
     1. kafaka保证同一个分区的多个副本不会在一个节点上，毕竟不会实现备份冗余的效果
     1. ISR：in-sync replica，和主保持同步的副本集合，集合里的才能选为主
       1. 集合中所有副本都收到消息才会置为已提交。当副本滞后一定程度时才踢出ISR，追上再加回，自动的
       1. kafka的信息交付承诺：在ISR存活的条件下已提交信息不会丢失
1. producer
   - 认识
     1. 是批量发送，不是接一条发一条
   - 发送方式
     1. 同步发送
     1. 异步发送
     1. 异步阻塞发送
     1. 异步回调发送
     1. 自定义分区负载均衡
   - 消息传递保障：依赖producer和consumer共同实现，主要是producer
     1. 最多一次
     1. 至少一次
     1. 正好一次
   - 客户端原理：![avatar](../images/kafka_producer_client.png)
1. consumer
   - 认识
     1. 客户端使用，配置
     1. 高级特性
   - 手动控制分区
   - 手动控制offset位置
     1. 应用场景
        - 指定开始位置
        - 消费失败，需要重复消费
   - kafka记offset的方式有哪些
   - consume限流，怕把consume流量高打死，用令牌桶方式
   - reblance，加入，崩溃，离组，提交位移的操作，类似乐观锁还有什么java的解决方案
1. consumer group
   - 认识：是kafka消费的单位
     1. 单partition只能由组中某个消费者消费，否则kafka需要加锁，会影响性能，就这样规定了
     1. 单个消费者可以消费多个partition
     1. 最佳实践：消费者数量和partation相等，多了没活干歇着浪费，少了性能不行
   - 规则：控制读写等权限
   - 形式
     1. 多个consumer：![avatar](../images/mult_consumer_one_handle.png)
        - consume数量和partation数量相同，性能最好，否则存在分配的开销
        - consume处于阻塞状态，适合普通业务场景，可以有好的管控，如消费3次不成功就报警
     1. ![avatar](../images/one_consumer_mult_handle.png)
        - consume变成非阻塞消费数据，后边线程池处理业务逻辑，但consume不知道后边是否成功可以commit，特点是减少consume消耗实现快速消费，适合非业务系统，如流处理，gps打点，机器监控，丢一些无所谓
1. topic
   - 删除
     1. 认识
        - 需要考虑生产者生产，消费者消费，broker损坏怎么办
     1. 设置
        - auto.create.topics.enable = false：要不然删不掉
        - delete.topic.enable = true：最好打开，不然有问题
     1. 原理
        - 特点
          1. 异步线程 + 延时操作
        - 步骤
          1. 注册zk的delete_topics节点的变化监听器
          1. 启动删除topic线程，这时删除线程阻塞并等待删除事件
          1. 执行删除命令时，在delete_topics节点添加
          1. 唤起删除线程
          1. 执行删除逻辑：删除分区信息、删除zk目录、清除controller中相关cache
          1. 删除线程继续阻塞
     1. 最佳实践
        - 断掉所有访问：使用域名访问，切断解析，保证一定无流量进入
        - 进行删除
1. partition
   - 认识：分区，有序的数据存储基本单元，一个topic分为n个有序号的partition
     1. 只支持顺序读写，只能在partition尾部追加消息，总是写最新的segment，每个消息有一个位移
     1. 单partition消息保证有序，全局不保证
        - 要保证消息顺序partition可以设为1，一个partation只能有一个consume，性能太低，不如天生有序的rabbiemq呢
        - 可以使用key + offset做到业务有序，一个key确定同一类型，offset作为顺序的判断，如先存了es，时序数据库中，攒够了一起处理
     1. 用于负载均衡，根据实际需要设置数量，实现性能最大化
   - 组成
     1. 特点
        - 每个partition的日志分为n个大小相等的segment文件存储
        - 每个segment的消息数量不一定相等(消息大小不同)
     1. 写
        - partition将消息串行追加到最后一个segment上，segment达到阈值就滚动到新segment
        - segment一定阈值后flush到磁盘上
     1. 读：一级级的检索快速找到消息内容，顺序读取磁盘可以有很高的性能
        - 用offset通过active segment list文件：找出具体的哪个segment
        - 找这个segment的index文件得到segment中消息的起始位置offset
        - 通过上个offset移动到某条消息的开头后，先读取4字节，就可以知道整个消息的长度了，最后读取整个消息内容
1. message
   - 属性
     1. 消费超时时间
     1. 最大重试次数：业务方消费消息的时间超过"消费超时时间"时，消息会判断消费失败，重新投递给业务方的最大重试次数
     1. QOS：并发回调个数
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
   - consumer
   - stream processor：高效将输入流转换到输出流
   - connector：
### 架构
1. 集群
   - 认识
     1. 天然支持集群，没有单节点说法，一台也是集群，通过brokerId区分不同节点
     1. 依赖zk进行协调，连接同一个zk就是同一个集群
   - 组成
     1. 节点
        - 访问任意一个broker都可以完成请求，因为有数据同步机制
     1. 副本
        - 认识：将每个topic的日志复制多份
        - 组成
          1. broker：部署节点
             - 对消息集群内平衡，就是不会将一个Topic的多个partation，也不会将一个partation的多个副本放在一个broker上，自己有协调机制
          1. leader：用于处理消息的接口、消费等需求
             - produce和consume都去leader存取数据
             - 同一个Topic的partation只能有一个leader，可以有多个flower
          1. follower：主要用于备份消息
             - 可以单独指定partation的副本数量
     1. 11版本前非常依赖zk，之后慢慢减轻
   - 运维
     1. leader选举
        - 没有采用多数投票来选举
        - 在ISR中选择速度比较快的作为leader，谁先接收到算谁
     1. 节点故障
        - 认识
          1. 不会因为节点故障丢失数据
          1. kafka的语义担保也能很大程度避免数据丢失
          1. 会对消息进行reblance，减少节点消息热度太高
        - 判定标准：心跳未保持、消息落后leader太多
        - 动作：移除
     1. 工具
        - 监控：cmak，即kafka manager
        - 管理工具：kafka-run-class.sh
1. 中间件
   - MQProxy
     1. 分区数不建议超过6个
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
1. 安装
   - 下载解压
   - 安装java，启动zk
   - `kafka-server-start.sh config/server.properties`
1. 命令行使用
   - 创建topic：`kakfa-topics.sh --create --zookeeper localhost:2181 --topic xx --partition 1 --replication-factor 1`，一个分区一个副本
   - 查看topic：`kakfa-topics.sh --describe --zookeeper localhost:2181 --topic xx`
   - 发送消息：`kafka-console-producer.sh --broker-list localhost:9092 --topic xx`：不间断，回车发送
   - 消费消息：`kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic xx --form-beginning`
1. 创建
   - 参数
     1. 节点选取
     1. topic名称
     1. 分区数
        - 压缩类型：zstd、lz4、snappy、gzip、生产者决定
        - 清理策略
          1. 方式
             - compact：压实
             - delete
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
1. 其他
   - web管理界面：Kafka-Manager
   - 脑裂问题：检测、自动恢复？
### 设计
1. 日志
   - 认识
     1. 以partition为单位进行保存，offset就是起始位置
   - 组成
     1. TopicName + Num：日志目录
     1. partition
     1. active segment list：追加、读取、删除，操作索引文件
        - 是一个offset区间，有了offset就可确认哪个segment
     1. segment
          1. xxxxxxx.index：
             - 左边是partation的全局offset，右边是segment的offset，
             - 一条条的记录每条消息的字节位置，这样直接可以取到消息
          1. xxxxxxx.log：segment file，包含一个个的message内容
          1. xxxxxxx.timeindex：时间排序的索引
          1. leader-epoch-checkpoint
     1. message
        - message length：4byte(1+4+n)，消息长度
        - magic value：1byte，版本号
        - crc：4byte，CRC校验码
        - playload：n byte，消息内容
1. 实现方式
   - 日志存储机制
   - 偏移量
   - 主题订阅、故障发现
### 实现
1. 认识
   - 底层实现知道原理，来龙去脉，不变应万变
   - 会比较晦涩
1. 特点
   - 为什么吞吐量大？
1. 设计原理
   - 顺序读写、快速检索
   - partition机制
   - 批量发送接收、数据压缩机制
   - 持久性
   - 高效率
   - 消息传递保障
   - 副本集
   - leader选举
   - 日志压缩
   - 写入：不支持参与物理io操作，采用追加写入页缓存的方式，不能修改已写入的，磁盘顺序访问型，吞吐量高，写操作性能强
   - 消费：sendfile零拷贝和大量使用页缓存(在内存中)，一个io处理不需上下文切换(内核和用户态之间)，利用直接存储器访问技术(DMA 内核缓冲区之间)
     1. 良好调优的kafaka有负载磁盘io也很少，因为直接命中缓存
     1. 之前是磁盘io ———— 内核读取缓冲区  ———— 用户缓冲区 ———— socket缓冲区 ———— 网络io，现在直接从磁盘io到网络io，用文件描述符控制就行，是用户空间零拷贝
        - 4步变2步，不仅节省了大量文件拷贝，而且节省用户上下文切换
   - 故障转移：基于zk的会话注册机制
   - 伸缩性：基于zk保存服务器状态和消费者信息
### wiki
1. 端口
   - kafka：9092
   - zk：2181
1. SASL：一种身份认证框架，sasl验证架构决定服务器本身如何存储客户端的身份证书以及如何核验客户端提供的密码。成功通过验证服务端能确定用户的身份和权限
   - kafka使用java认证和授权服务（JAAS）进行SASL配置
1. 其他
   - 大数据时代数据管道技术首选
   - Confluent Platform：分为开源和商业版本，提供了kafka没有的完善的跨数据中心数据备份和集群监控方案等
   - linux比windows的io模型和网络传输的零拷贝都厉害
1. 历史
   - 最新：2.8
   - 2019.10：2.3.1
   - 2017.11：稳定版本
   - 2011：加入apache
   - 2010：开源，由Scala和Java编写，最初由Linkedin开发，最后贡献给Apache基金会并成为顶级开源项目
1. 版本更新
   - 0.11：事务支持
   - 0.10：推出kafka streams组件，成为流式处理框架，本质还是消息的流转
   - 0.8：集群间备份，java重写生产者，不再依赖zk
1. LinkIn开源的东西
   - Databus：分布式数据同步系统
   - Cubert：高性能计算引擎
   - ParSeq：java异步处理框架
