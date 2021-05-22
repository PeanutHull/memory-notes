### 队列
1. 特点
   - 异步处理：时间无关可延后处理、可以并行处理
   - 解耦：两边修改不互相影响
   - 削峰
1. 问题
   - 高可用：确保消息的可靠传递，数据不丢失、不重复
1. kafkaVsRabbitmq：![avatar](../images/kafkaVsRabbitmq.png)
### RabbitMQ
1. 认识：热门的消息中间件。是生产者/消费者模型，主要负责消息的接收、存储、转发，支持AMQP、STOMP、MQTT协议。erlang编写，因为兔子敏捷并且繁殖很疯狂
   - 高可靠：持久化、传输确认、发布确认、跟踪机制
   - 高可用：内建消息集群，集群镜像
   - 功能多：灵活路由、多协议、多客户端、管理界面、易扩展、插件机制
   - 无法实现消息恰好一次，不会丢也不会多
1. 组成
    1. 生产者：publisher，消息体payload、标签label。根据标签路由消息
    1. 消费者：consumer，获取生产者消息体，不关心生产者是谁
       - 消费模式
         1. 推：消费者持续订阅
         1. 拉
    1. 路由键：routingKey，生产者给交换器发消息时指定路由键，决定消息路由，和交换器类型、绑定键共同起作用
    1. 交换器：exchange，用于和队列关联，接收消息并路由给队列
       - 属性
         1. 持久化
         1. 自动删除：？？？
         1. 内置：只接受交换器不接受生产者过来的消息
       - 类型
         1. fanout：广播，发给所有绑定的队列，最快
         1. direct：直传，routingKey和bindingKey相同传过去
         1. topic：加了匹配规则的direct，用bindingKey匹配routingKey，用.切分一个个单词，通配符#和*，如`#.usa`，*匹配单个单词，#匹配多个单词
         1. headers：匹配header属性的键值对，一致才会传过去，慢，不用了
    1. 绑定键：binding，通过绑定将交换器和队列关联，当路由键和绑定键相同时，会被传递到某个队列。可以和路由键看作一个东西，一个交换器前，一个后
    1. 消息队列：queue，用于存储消息
       - 属性
         1. 排他：仅对首次连接可见，其他排他队列不可新建，连接断开自动删除队列，不能持久化，基于连接
         1. 持久化：重启不丢失
         1. 自动删除：？？？
         1. 优先级
    1. 信道：channel，建立在连接上的双向数据流的虚拟连接，所有消息通过信道发送，多路复用一个tcp连接，避免tcp高额的新建销毁成本    
    1. 消息：包含消息体、属性、header
1. 特性
   - TTL：过期时间，time to live，两者都有取最小，超过后变死信，不设置不过期，设置为0表示不能直接投递则立即丢弃。分为消息自身、队列
   - 死信：DLX 死信交换器，与之匹配的是死信队列，消息变死信后发送到这个交换器，可手动设置。产生条件：被拒绝、未送达、过期、队列达到最大长度
   - 延迟队列：消息发出后，等待特定时间后，消费者才能拿到消息。使用DLX和TTL模拟效果，即消费者订阅某个队列对应的死信队列，队列设置有过期时间，过期后实现延迟效果
   - 优先级队列：优先级高的队列有优先权，优先级高的消息优先被消费。消息的最大优先级不能超过队列的，当消费速度大于生产速度时没意义，因为同时就一条消息
   - 持久化：需要设置交换器和队列的持久化，才能保证消息的持久化有用，所有消息持久化极大影响性能。分类：交换器、队列、消息
   - 消息确认
     1. 生产者确认：confirm，可通过事务、发送方确认机制，都能保证消息已正确送达。后者更轻量级，二者互斥。持久化的话落盘后rabbitmq才会回复确认，是指确认发往交换器。确认就是落盘了，崩溃数据不丢失
        - 发送方确认：confirmSelect不阻塞，可以继续发送下一条，可用waitForConfirm的返回结果进行失败的逻辑处理。原理是开启确认模式后，当前信道每个消息被指派一个唯一id，然后确认时返回这个id。批量confirm和异步confirm性能更高，一个一个的confirm性能只比事务少了一个tcp的ack
        - 事务：一条消息一个commit，发送消息后commit会一直阻塞，直到消息成功被接收，事务才能提交成功
          1. select、commit、rollback：开启事务模式、提交、回滚，提交成功则消息一定到达了rabbitMQ
     1. 消费者确认：ack
        - 等待消费者显式回复ack信号才会删除消息，否则发出去就删除。连接断开会安排未确认的消息重入队列
        - 回复拒绝，可设置重新入队或者删除
        - 消息分发
          1. 多消费者同一队列消息被均摊即轮询
          1. 推模式下，某消费者未确认的消息数量达到阈值，则停止向其派送消息。因为消费者之间的差异，防止消息堆积
          1. 一个信道多个队列情况下，最大未确认消息数？？？
   - RPC：可以和客户端进行RPC通信
1. 集群
   - 代理：broker，表示消息队列服务器实体
   - 分类
     1. 集群模式
        - 认识：保证节点崩溃后继续可用，提高消息吞吐量。共享基础信息，各干各的活儿，别人崩溃了也不管消息丢失。v2.6支持镜像队列
          1. 共享user/vhost/exchange等
          1. 客户端可看见所有的队列
          1. 节点间不能共享消息
          1. 不能自动故障切换，需要手动删除节点
          1. 只能部署在局域网
        - 分类：可手动设置类型，至少要有一个磁盘节点，否则无法新建修改
          1. 内存节点
          1. 磁盘节点
        - 镜像队列：可以主从切换，防止数据丢失    
        - 配置步骤
          1. 交换秘钥令牌cookie：以获得相互认证
          1. stop_app - reset - joio_cluster/forget_cluster_node - start_app：关闭所有节点，启动时需要先启动最后关闭的节点，否则启动不了，可删节点解决
     1. federation
       1. 认识：联邦，可为不同broker进行消息转发，而无须建立集群。支持不同管理域和广域网。内部基于AMQP协议传递数据
          - 联邦交换器：单向点对点的给不同broker的交换器转发消息，只能转发一次，而且转发后找不到合适队列也不会再次转回原地。允许复杂的路由拓扑提高转发次数，如环状和往返双路线
          - 联邦队列：单向点对点的队列间的负载均衡，联邦队列间某个没消息了就去拿别人的帮忙，提升单队列的容量，消息可游离任意次数
     1. shovel
       1. 认识：铲子，数据挖到另一个地方。数据转发，从一个队列到另一个交换器，也可以交换器/队列到交换器/队列，只是shovel本身自动加了交换器/队列。基于AMQP传递
          - 支持不同管理域的数据迁移
          - 支持广域网、时断时续的传输保证消息可靠性
          - 可用于队列堆积时的搬到另一个集群的数据分摊，即设置一个多了搬走，少了拿过来，相当于备份
   - 比较
     1. 是否是一个逻辑broker、是否所有交换器一样、是否可以看到所有队列
     1. 是否需要相同cookie
     1. CAP理论：集群是CA、federation/shovel是AP
        
1. 网络分区
1. 使用
   - 资源创建方式
     1. 提前静态
     1. 用时动态
   - 配置
   - 消息顺序性：无法保证，由于接收多个生产者消息先后、事务可能回滚、消息优先级、过期时间都会影响
   - 消息传输保障：rabbitMQ支持最多一次和最少一次，因为消息确认环节可能中断导致误解
     1. 层级
        - 最多一次：可能丢失，不会重复
        - 最少一次：不会丢失，可能重复
        - 恰好一次：不会丢失，不会重复正好一次
     1. 最少一次需要做到的，最多一次就随便发，随便接收了
        - 要有发送方确认
        - 交换器、队列、消息要持久化、备份
        - 消费者设置手动确认
   - 保障消息安全
     1. 要有发送方确认
     1. 交换器、队列、消息要持久化、备份
     1. 消费者设置手动确认
1. 运维
   - 安装
     1. 安装erlang
     1. 下载rabbitmq包解压，直接运行
     1. 启动：`rabbitmq-server -detached`，端口5672，会启动erlang虚拟机和rabbitmq服务
   - 配置
     1. 认识：交换器和队列一旦设置属性不能修改
     1. 分类
        - 环境变量：rabbitmq-env.conf
        - 配置文件：rabbitmq.config
        - 运行时参数：不会同步到集群中，运行时可更改，不用重启。分vhost级别、globle级别。Policies支持批量动态修改属性参数
   - 运行指标
     1. 消息：发送速度、确认速度、消费速度、消息总数
     1. 磁盘读写速度、句柄数
     1. socket连接数、connection数、channel数
   - 持久化数据
     1. mnesia：数据库
     1. metadata.json：元数据，就是vhost、交换器那一堆的数据文件
1. 管理
   - 命令行：rabbitmqctl
     1. vhost：虚拟主机，多租户。拥有独立的交换器、队列、权限，逻辑、数据分离，避免命名冲突，易扩展，vhost是AMQP的概念基础，默认/，账号密码guest/guest
        - `list_vhosts`
        - `add_vhost、delete_vhost xx`
        - `list/set/clear_parametyer`：运行参数操作
     1. user：跨越vhost存在，
        - `list_user、authentiçate_user`：验证用户
        - `add_user、delete_user`
        - `change_password、clear_password`
        - `set_user_tag xx none/management/policymaker/monitoring/administrator`：授予角色，访问管理页面/策略参数设置/监控连接等/最高权限
        - `set/clear/list_permissions -p vhost user {conf}{write}{read}`：权限是vhost级别的，可配置/写/读权限的正则，可读包含清空队列
        - `list_user_permissions`
     1. app：应用
        - `stop/shutdown`：关闭erlang虚拟机、关闭rabbitmq服务
        - `start_app/stop_app/wait/reset/force_reset`：针对rabbitMQ服务，reset 清空节点状态
        - `list/set/clear_global_parameters`：全局参数
     1. server：服务端
        - `status`
        - `environment/report`：显示变量、生成状态报告
        - `node_health_check`：队列和交换器是否能够正常返回
        - `eval`：执行erlang语句
        - `list_exchanges [name type durable auto_delete]`：是否持久化、是否自动删除
        - `list_bindings`：绑定关系
        - `list_queues xx message_ready/unacknowledged`：等待投递/未确认消息数
        - `list_consumers`
        - `lìst_connectìons`
        - `list_channels`
     1. cluster：集群
        - `cluster_status`：集群信息
        - `joio_cluster/forget_cluster_node/update_cluster_nodes/set_cluster_name`
        - `sync_queue/cancel_sync_queue`：同步master
        - `change_cluster_node_type/force_boot`
   - 插件：rabbitmq-plugins
     1. `enable/disable rabbitmq_management`
     1. `enable/disable rabbitmq_federation/rabbitmq_management_federation`
     1. `enable/disable rabbitmq_shovel/rabbitmq_shovel_federation`
     1. `lists`
   - management：端口15672
     1. web页面：各种功能
     1. API接口：如`http://xx:15672/api/overview`
1. 原理
   - 存储机制
     1. 现象：持久化的入队列就写入磁盘，内存中也备份一份，内存吃紧就清除。非持久化的只保存在内存中，内存吃紧换入硬盘
   - 集群内部利用erlang的分布式通信框架OTP
   - 流控
   - 镜像队列原理
1. wiki
   - 队列历史
     1. 商业的有微软的MSMQ、IBM的WebSphere
     1. JMS试图通过公共Java API的方式，隐藏不同mq的实际接口，解决互通问题，但是使用单独接口胶合众多不同的接口也是存在很多问题。老牌ActiveMQ是JMS的一种实现
     1. 消息通信标准化方案：2006年思科、红帽等联合制定了AMQP的公开标准。rabbitMQ是其开源实现，阿里的rocketMQ、kafka
   - rabbitMQ历史
     1. RabbitMQ Technologies Ltd开发并提供商业支持
     1. 2010年被VMWare收购
     1. 最新版本3.8
   - AMQP：Advanced Message Queue，高级消息队列协议，是应用层的面向消息的中间件设计和开放标准，基于此协议客户端和消息中间件传递消息，不受产品/语言限制。模型架构和rabbitMQ一样
   - Erlang
     1. 认识：支持多核的特性，分布式特性。面向并发，结构化，动态类型，内建并行计算支持。OTP是实现健壮性和容错性的工具和类库和完整的结构化框架
   - 通信步骤
     1. 生产者：生产者把消息发布到exchange上时一般携带routingKey，exchange的类型和bindingKey一起决定发送到的queue
        - 建立连接：connection
        - 开启信道：channel
        - 创建交换器，设置属性：exchange
        - 创建队列，设置属性：queue
        - 通过路由键绑定交换器和队列：route key
        - 发送消息：message
        - 断开：close
     1. 消费者
        - 建立连接：connection
        - 开启信道：channel
        - 请求消费
        - 接收消息
        - 确认消息：ack
        - 队列删除已确认的消息
        - 关闭信道
        - 关闭连接
### RocketMQ
1. 认识：阿里kafka基础上开源
   - 微服务架构设计
   - 基于Netty异步事件驱动通讯框架，采用长连接
   - 高性能、高可用
   - 每个部分都支持多节点扩展
1. 功能
   - 消息类型
     1. 普通
     1. 顺序(全局/分区)
     1. 定时/延时
     1. 分布式事务：类似 X/Open XA 的分布事务，保证最终一致性
   - 发布/订阅、集群消费(全部/任一)
   - 消息路由
   - sql形式的消息查询，全链路消息轨迹、消息回放
1. 特点
   - 单机支持上万Topic，Topic 数量增加对性能影响很小
   - 内存模式支持同步请求处理，不落盘，适用于“request-reply”同步请求处理场景
   - 流数据处理：如日志流数据，支持log4j、logback等日志异步appender，其他非交易数据处理需求，也可采用异步发送+batch模式提高数据传输效率
   - Consumer支持Java,C++,Go
   - 企业服务总线
1. 组成：
   - NameServer：注册中心，各节点互相独立，彼此没有通信关系
   - broker集群：支持主从模式，有同步双写、异步复制两种模式
   - Producer集群
   - Consumer集群
### Kafka
1. 认识：高吞吐量的分布式、分区的、持久化、多副本备份、基于zookeeper协调的流处理平台和消息系统。强大消息传输效率、完备的分布式解决方案。核心是消息存储，来读即可。适用于消息传输、日志收集(超吞吐量)、在线和离线分析、流式数据处理
   - 分区、副本、基于zk调度(强依赖zk)
   - 分布式：有备份、有容错
   - 高伸缩性：可水平扩展
   - 负载均衡、故障转移
   - 高性能：高吞吐量/高并发/低延迟/时间复杂度O(1)：每秒几十万
   - 持久化：多副本/容错性/消息自动平衡
1. 设计
   - 发布/订阅：消息系统，使用推拉模式
   - 实时事件响应
   - 消息压缩传输：消费者获取，镜像数据传输
   - 自己的二进制消息传输协议
   - 集群镜像：提供官方工具同步并重新发布消息
   - 副本模式
     1. 同步：生产者从zk找到leader，发布消息后存入leader的log中，follow使用一个channel pull消息，写入自己log后发送确认消息，收到所有确认消息才给生产者发送
     1. 异步：写入log后立即发送确认信息，无法保证broker故障时的消息分发
1. 组成
   - broker：节点，kafka集群的服务器节点
     1. partition会平均分布在节点中
     1. ReplicaManager：管理当前Broker所有分区和副本
   - topic：主题，逻辑概念，用于存储、区分消息，在broker上存储
     1. 组成：紧凑的二进制字节数组，避免了java繁重的堆上内存分配
        - key：消息键，决定哪个partition
        - value：消息体
        - timestamp：消息发送时间戳，用于流式处理和其他依赖时间的
   - partition：分区，有序的数据存储基本单元，一个topic分为n个分区，分区有序号，只能在分区尾部追加消息，并且每个消息有一个位移，每个分区用多个segment文件存储
     1. 一个分区消息有序，多个无法保证顺序。要保证消息顺序分区设为1
     1. 用于负载均衡，根据实际需要设置数量，实现性能最大化
   - replica：副本，用于防止数据丢失，一个分区多个副本
   - leader/follower：取代主备的提法，仅一个为主提供服务，从同步数据作为替补，从的写由主的数据变更的广播获取
     1. 主失效立即再选举，从挂掉/卡住/同步太慢会被删除再创建一个
     1. kafaka保证同一个分区的多个副本不会在一个节点上，毕竟不会实现备份冗余的效果
     1. ISR：in-sync replica，和主保持同步的副本集合，集合里的才能选为主
       1. 集合中所有副本都收到消息才会置为已提交。当副本滞后一定程度时才踢出ISR，追上再加回，自动的
       1. kafka的信息交付承诺：在ISR存活的条件下已提交信息不会丢失
   - producer/consumer/consumer group：topic中增减消息
     1. 一对一
     1. 发布订阅
1. 运维
   - 安装
     1. 下载解压
     1. 安装java，启动zk
     1. kafka-server-start.sh config/server.properties
   - 使用
     1. 创建topic：`kakfa-topics.sh --create --zookeeper localhost:2181 --topic xx --partition 1 --replication-factor 1`，一个分区一个副本
     1. 查看topic：`kakfa-topics.sh --describe --zookeeper localhost:2181 --topic xx`
     1. 发送消息：`kafka-console-producer.sh --broker-list localhost:9092 --topic xx`：不间断，回车发送
     1. 消费消息：`kafka-console-consumer.sh --bootstrap-server localhost:9092 --topic xx --form-beginning`
   - 脑裂问题：检测、自动恢复？
1. 原理
   - 写入：不支持参与物理io操作，采用追加写入页缓存的方式，不能修改已写入的，磁盘顺序访问型，吞吐量高，写操作性能强
   - 消费：sendfile零拷贝和大量使用页缓存(在内存中)，一个io处理不需上下文切换(内核和用户态之间)，利用直接存储器访问技术(DMA 内核缓冲区之间)。良好调优的kafaka有负载磁盘io也很少，因为直接命中缓存
   - 故障转移：基于zk的会话注册机制
   - 伸缩性：基于zk保存服务器状态和消费者信息
1. wiki
   - 其他
     1. 大数据时代数据管道技术首选
     1. Confluent Platform：分为开源和商业版本，提供了kafka没有的完善的跨数据中心数据备份和集群监控方案等
     1. linux比windows的io模型和网络传输的零拷贝都厉害
   - 其他
     1. 实时流处理
     1. 传统批处理
   - 历史
     1. 2.3.1：2019年10月
     1. 1.0：2017年11月，进入稳定版本
     1. 0.11：事务支持
     1. 0.10：推出kafka streams组件，成为流式处理框架，本质还是消息的流转
     1. 0.8：集群间备份，java重写生产者，不再依赖zk
     1. 加入apache：2011年
     1. 开源：2010年
     1. 由Scala和Java编写，最初由Linkedin开发，最后贡献给Apache基金会并成为顶级开源项目。和生产消费者交流消息，利用zk进行服务协调管理
        - wiki
   - LinkIn开源的东西
        - Databus：分布式数据同步系统
        - Cubert：高性能计算引擎
        - ParSeq：java异步处理框架
1. 他山之玉
   - 基于SSD的Kafka应用层缓存架构设计与实现
   - 背景
     1. 出色的io优化和异步化设计
     1. Produce的Server端的I/O线程统一将请求中的数据写入到操作系统的PageCache后立即返回，当消息条数到达一定阈值后，Kafka应用本身或操作系统内核会触发强制刷盘操作
     1. Consume请求主要利用了操作系统的ZeroCopy机制，Broker接收到读数据请求时，会向操作系统发送sendfile系统调用，操作系统接收后，首先试图从PageCache中获取数据；如果数据不存在，会触发缺页异常中断将数据从磁盘读入到临时缓冲区中，随后通过DMA操作直接将数据拷贝到网卡缓冲区中等待后续的TCP传输
   - 问题：多个Consumer时，竞争PageCache资源导致产生延迟。消费延迟后会刷盘而且PageCache中不存在，读的时候需要多一次磁盘读取并触发预读部分数据到PageCache，因为LRU策略会替换PageCache中实时的缓存数据
     1. 消费能力充足的Consumer消费时会失去PageCache的性能红利
     1. 多个Consumer相互影响，预期外的磁盘读增多，HDD负载升高，毛刺增多，服务不稳
   - 现状：通过线上统计消费延迟分布情况，20%的没有使用PageCache，单机的PageCache平均分配为80GB，流量在170MB/s，PageCache最大可缓存数据时间跨度为80*1024/170/60 = 8min，对延迟消费容忍度较低
   - 方案
     1. 根据数据局部性原理：SSD做"PageCache"高速存储，HDD做更底层存储，技术有FlashCache、BCache、DM-Cache、OpenCAS
        - 优点：数据对应用层透明，应用代码改动小
        - 问题：没有根本改变，都会发生缓存污染
     1. kafka内部实现：维护的消息偏移量区分实时和低速消费，随时间的推移淘汰到HDD上，采用
        - 优点：充分考虑kafka读写特性，实时消费全在SSD保证低时延，HDD读取不会会刷到SSD防止缓存污染；日志段有明确唯一状态，查询路径最短，不存在CacheMiss的开销
        - 缺点：需要server端改进，开发、测试工作量大，需要随社区大版本升级，但可以代码贡献社区解决迭代问题
