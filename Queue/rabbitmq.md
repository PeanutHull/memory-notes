### 认识
1. 认识：开源的消息中间件，支持AMQP、STOMP、MQTT协议。erlang编写，因为兔子敏捷并且繁殖很疯狂
   - 高可靠：支持持久化、传输确认、发布确认、跟踪机制
   - 高可用：集群模式丰富，集群镜像
   - 功能多：灵活路由、多协议、多客户端、管理界面、易扩展、插件机制
1. 特点
   - 高负载下资源占用大
### 组成
1. publisher
   - 认识：生产者
   - 属性
     1. mandatory：发布消息到交换机时如果无法到达任何一个队列，消息是否会返回给生产者
     1. delivery_mode
        - persistent：2，消息是否持久化，只有当交换机、队列、消息都是持久的，消息才不会丢失
   - publish：发布消息
   - 消息确认
     1. 认识：默认生产消息无确认信息，为了确认消息broker是否收到
        - 需要落盘的，落盘后才会通知
     1. 分类
        - transaction机制：只有消息成功被broker接受，事务提交才能成功
          1. txSelect()：设置为事务模式
          1. txCommit()：提交事务
          1. txRollback()：回滚事务
        - confirm机制：此模式下，会返回唯一id，并异步回调通知
          1. confirmSelect()：将channel设置为confirm模式
          1. 回调编程方式
             - 普通：发送一条消息后，立即调用waitForConfirms()，串行
             - 批量：发送一批消息后，再调用waitForConfirms()
             - 异步：提供回调方法
          1. 回调类型
             - confirm：消息收到
             - nack：消息丢失
     1. 比较
          1. confirm比transaction的轻量一点点，二者不能共存
          1. 异步和批量confirm性能是其他的10倍
1. consumer
   - 认识：消费者
   - 动作
     1. subscribe：订阅队列
   - 属性
     1. prefetch：确认消息前可以一次性接收的消息数量，要选个合适的大小，性能和可靠
   - 消费模式
     1. 推：消费者持续订阅
     1. 拉：定时拉
   - ack：消费者确认，告知服务器消费成功，服务端才会删除消息，否则发出去就删除。连接断开会安排未确认的消息重入队列。`noAck=false`
   - reject/nack：消费者拒绝，告知服务器消费失败，可设置是否重新投递到队列
     1. 消息分发
        - 多消费者同一队列消息被均摊即轮询
        - 推模式下，某消费者未确认的消息数量达到阈值，则停止向其派送消息。因为消费者之间的差异，防止消息堆积
        - 一个信道多个队列情况下，最大未确认消息数？？？
1. exchange
   - 认识：交换器，用于和队列关联，接收消息并根据标签路由给队列
   - 属性
     1. durable：持久化
     1. auto delete：没有队列绑定自动删除
     1. alternate exchange：无法路由，消息无法被路由时来这里
     1. internal exchange：内置交换器，只能用于交换机与交换机的绑定
        - amq.前缀：是RabbitMQ内部交换机，通常用来实现没有规定exchange的场景
     1. consumer utilisation：反映消费者工作状态的指标，此值太小，说明消费者可能有异常或者消费速度远远赶不上生产速度
   - 类型
     1. fanout：广播，发给所有绑定的队列，最快
     1. direct：直传，routing key和binding相同直传过去
     1. topic：主题
        - .切分单词
        - 通配符匹配：*一个单词，#0个或多个单词，如`#.usa`
     1. headers：匹配header属性的键值对，一致才会传过去，慢，不用了
1. routing key
   - 认识：路由键，交换机用来决定消息要投递到哪个队列所需要的信息。类似信封上的地址，邮局通过这个地址选择路径
1. binding
   - 认识：绑定键，将交换器和队列关联，当路由键和绑定键相同时，会被传递到某个队列。可以和路由键看作一个东西，一个交换器前，一个后
1. queue
   - 认识：消息队列，用于存储消息
   - 属性
     1. max length：最大长度
     1. max length bytes：最大字节长度
     1. durable：持久化

     1. auto delete：没有消费者订阅后自动删除
     1. auto expire：队列多久未使用后自动删除

     1. x-max-priority：优先级，0~255，资源占用多
     1. maximum priority：最大优先级，同时也是优先级队列的开关
     1. x-message-ttl：存活时间
     1. queue.declare：懒队列

     1. x-dead-letter-exchange：指定死信交换器，DLX
     1. x-dead-letter-routing-key：指定死信routing key，DLK
   - 特性
     1. ttl队列：过期队列，超过后变死信，不设置不过期，设置为0表示不能直接投递则立即丢弃
     1. delay queue：延时队列，队列TTL + 死信队列实现，消费者订阅某队列对应的死信队列，队列设置过期时间，过期后实现延迟效果
     1. priority queue：优先级队列，优先级高的消息先被消费，不是先进先出的，v3.5.0
     1. dead letter queue
        - 认识：死信队列，DLX死信交换器，与之匹配的是死信队列，为了确保消息不会被无故丢弃将其置于特殊的队列
        - 产生条件：被拒绝并且requeue为false、过期、队列达到最大长度
     1. 重回队列：没有ack的重新投递到broker
     1. exclusive queue：专用队列，队列只能被一个连接使用，并且连接断开后会被删除，不能持久化
     1. lazy queue：v3.6.0，尽可能早地放到磁盘，只在消费者请求时才加载到内存
        - 为能够支持非常长的队列
1. message
   - 认识：消息
   - 属性
     1. expiration：和队列都起作用，谁小谁先生效
   - 组成
     1. metadata：元数据
     1. 消息体
     1. 属性
     1. header
#### 角色
1. broker
   - 认识：节点，消息队列服务器实体
     1. RPC：可以和客户端进行RPC通信
   - 属性
     1. policies：策略，如高可用等
1. channel
   - 认识：信道，建立在连接上的双向数据流的虚拟连接，所有消息通过信道发送，多路复用一个tcp connection，避免tcp高额的新建销毁成本   
1. vhost
   - 认识：虚拟主机，多租户。拥有独立的交换器、队列、权限，逻辑、数据分离，避免命名冲突，易扩展，vhost是AMQP的概念基础，默认/，账号密码guest/guest
1. user
   - 认识：跨越vhost存在
#### 设计
1. 消息可靠性投递：confirm，可通过事务、发送方确认机制，都能保证消息已正确送达。后者更轻量级，二者互斥。持久化的话落盘后rabbitmq才会回复确认，是指确认发往交换器。确认就是落盘了，崩溃数据不丢失
   - 发送方确认：confirmSelect不阻塞，可以继续发送下一条，可用waitForConfirm的返回结果进行失败的逻辑处理。原理是开启确认模式后，当前信道每个消息被指派一个唯一id，然后确认时返回这个id。批量confirm和异步confirm性能更高，一个一个的confirm性能只比事务少了一个tcp的ack
     1. channel开启确认模式 `channel.confirmSelect()`
     1. channel添加监听，addConfirmListener
   - ReturnListener：用于监听不可达的消息，`Mandatory:true`，false直接删除
   - 事务：消息落库，消息状态打标。一条消息一个commit，发送消息后commit会一直阻塞，直到消息成功被接收，事务才能提交成功
     1. select、commit、rollback：开启事务模式、提交、回滚，提交成功则消息一定到达了rabbitMQ
1. qos：服务质量保证，消费端限流，防止压垮消费者。在非自动确认消息下，一定数量消息未被确认前，不进行消费新消息
   - prefetchSize：0，rabbitmq没实现
   - prefetchCount：qos值
   - global：设置channel/consumer级别，rabbitmq没实现
1. 数据文件
   - mnesia：数据库
   - metadata.json：元数据，就是vhost、交换器那一堆的数据文件
1. 持久化
   - 认识需要设置交换器和队列的持久化，才能保证消息的持久化有用，所有消息持久化极大影响性能
     1. 分类：交换器、队列、消息
1. 原理
   - 存储机制：持久化的入队列就写入磁盘，内存中也备份一份，内存吃紧就清除。非持久化的只保存在内存中，内存吃紧换入硬盘
   - 集群内部利用erlang的分布式通信框架OTP
   - 流控
   - 镜像队列原理
### 架构
1. 集群
   - 认识
     1. rabbitMQ集群本身并非为了严格的可伸缩性，为了实现严格意义的伸缩性扩展，建议使用多个单机模式的broker。cluster能够更好的为自带的HA服务
1. 集群模式
   - cluster
     1. 认识：保证节点崩溃后继续可用，提高消息吞吐量。共享基础信息，各干各的活儿，别人崩溃了也不管消息丢失。v2.6支持镜像队列
        - 共享user/vhost/exchange等
        - 客户端可看见所有的队列
        - 节点间不能共享消息
        - 不能自动故障切换，需要手动删除节点
        - 只能部署在局域网
     1. 分类：内存/磁盘节点，至少要有一个磁盘节点，否则无法新建修改
     1. 模式
        - 普通：warren 兔子窝模式，并发不高
        - 镜像
          1. 主提供读写，镜像提供备份，可主从切换，最少3节点数据同步，两个haproxy
          1. 主备强一致，任何节点都有集群上所有队列的元信息，备节点操作会被路由到主节点
   - federation
     1. 认识：多活模式，可为不同broker进行消息转发，而无须建立集群。支持不同管理域和广域网。内部基于AMQP协议传递数据，下游从上游拉取订阅的队列消费
          - 联邦交换器：单向点对点的给不同broker的交换器转发消息，只能转发一次，而且转发后找不到合适队列也不会再次转回原地。允许复杂的路由拓扑提高转发次数，如环状和往返双路线
          - 联邦队列：单向点对点的队列间的负载均衡，联邦队列间某个没消息了就去拿别人的帮忙，提升单队列的容量，消息可游离任意次数
   - shovel
     1. 认识：远程模式，跨地域集群互联，基于AMQP传递
        - 支持不同管理域的数据迁移
        - 支持广域网、时断时续的传输保证消息可靠性
        - 可用于队列堆积时的搬到另一个集群的数据分摊，即设置一个多了搬走，少了拿过来，相当于备份
   - 比较
     1. 是否是一个逻辑broker、是否所有交换器一样、是否可以看到所有队列
     1. 是否需要相同cookie
     1. CAP理论：集群是CA、federation、shovel是AP
1. network partitions：网裂、网络分区，指集群由于网络原因被分成几个能够独立运行的部分，不同部分各自认为对方宕机，从而不能构成一个整体，不能保证数据一致性
### 最佳实践
1. 使用
   - 资源创建方式
     1. 提前静态
     1. 用时动态
   - 保障消息安全
     1. 要有发送方确认
     1. 交换器、队列、消息要持久化、备份
     1. 消费者设置手动确认
### 运维
1. 安装
   - 安装erlang
   - rabbitmq下载、解压
   - 启动：`rabbitmq-server -detached`，端口5672，会启动erlang虚拟机和rabbitmq服务
1. 配置
   - 认识：交换器和队列一旦设置属性不能修改
   - 分类
     1. 环境变量：rabbitmq-env.conf
     1. 配置文件：rabbitmq.config
     1. 运行时参数：不会同步到集群中，运行时可更改，不用重启。分vhost级别、globle级别
1. 管理
   - rabbitmqadmin：基于HTTP API的零依赖命令行管理工具
   - rabbitmqctl
     1. vhost
        - `list_vhosts`
        - `add_vhost、delete_vhost xx`
        - `list/set/clear_parametyer`：运行参数操作
     1. user
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
   - rabbitmq-plugins：插件管理
     1. `enable/disable rabbitmq_management`：端口15672
     1. `enable/disable rabbitmq_federation/rabbitmq_management_federation`
     1. `enable/disable rabbitmq_shovel/rabbitmq_shovel_federation`
     1. `lists`
   - rabbitmq-diagnostics：监控、健康检查、可观察性工具
   - rabbitmq-queues：对仲裁队列的操作
1. 监控
   - 消息：发送速度、确认速度、消费速度、消息总数
   - 磁盘读写速度、句柄数
   - socket连接数、connection数、channel数
### wiki
1. 历史
   - RabbitMQ Technologies Ltd开发并提供商业支持
   - 2010年被VMWare收购
   - 最新版本3.8
1. AMQP
   - 认识：Advanced Message Queue 高级消息队列协议，是应用层的面向消息的中间件设计和开放标准，基于此协议客户端和消息中间件传递消息，不受产品/语言限制。模型架构和rabbitMQ一样
     1. 用exchange做路由转发到队列，不需要关心具体哪些队列，这是特点
   - 组成
     1. channel：网络通道，就是一个会话
     1. virtual host：虚拟地址，用于逻辑隔离，最上层的消息路由，不能包含多个同名的exchange和message queue
     1. exchange：交换机，根据路由键转发消息到绑定的队列
        - binging：exchange和queue的虚拟连接，可以包含routing key
        - routing key：一个路由规则，用来确定如何路由一个特定消息
     1. message queue：队列，保存消息
     1. message：由properties和body组成，如消息优先级、延迟等
1. 其他
   - Erlang：支持多核的特性，分布式特性。面向并发，结构化，动态类型，内建并行计算支持。OTP是实现健壮性和容错性的工具和类库和完整的结构化框架
   - time to live 过期时间