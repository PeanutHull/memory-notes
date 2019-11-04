### 队列
1. 特点
   - 异步处理：时间无关可延后处理、可以并行处理
   - 解耦：两边修改不互相影响
   - 削峰
1. 问题
   - 高可用：确保消息的可靠传递，数据不丢失、不重复
### RabbitMQ
1. 认识：热门的消息中间件。是生产者/消费者模型，主要负责消息的接收、存储、转发。erlang编写，因为兔子敏捷并且繁殖很疯狂
   - 灵活路由：交换器
   - 高可靠：持久化、传输确认、发布确认、跟踪机制
   - 高可用：内建消息集群，集群镜像
   - 功能多：多协议(AMQP、STOMP、MQTT)、多客户端、管理界面、易扩展、插件机制
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
         1. 自动删除：没有绑定的队列时触发
         1. 内置：只接受交换器不接受生产者过来的消息
       - 类型
         1. fanout：广播，发给所有绑定的队列，最快
         1. direct：直传，routingKey和bindingKey相同传过去
         1. topic：加了匹配规则的direct，用bindingKey匹配routingKey，用.切分一个个单词，通配符#和*，如`#.usa`，*匹配单个单词，#匹配多个单词
         1. headers：匹配header属性的键值对，一致才会传过去，慢，不用了
    1. 绑定键：binding，通过绑定将交换器和队列关联，当路由键和绑定键相同时，会被传递到某个队列。可以和路由键看作一个东西，一个交换器前，一个后
    1. 消息队列：queue，用于存储消息，多消费者同一队列消息被均摊即轮询
       - 属性
         1. 排他：仅对首次连接可见，其他排他队列不可新建，连接断开自动删除队列，不管持久化，基于连接
         1. 持久化：重启不丢失
         1. 自动删除：？？？
         1. 优先级：priority
    1. 信道：Channel，建立在连接上的双向数据流的虚拟连接，所有消息通过信道发送，多路复用一个tcp连接，避免tcp高额的新建销毁成本    
1. 高级特性
   - TTL
   - 死信
     1. 被拒绝、未送达的消息
   - 延迟队列
   - 优先级队列
   - RPC
   - 消息持久化
   - 消息确认
     1. 等待消费者显示回复ack信号才会删除消息，否则发出去就删除。连接断开会安排未确认的消息重入队列
     1. 回复拒绝，可设置重新入队或者删除
   - 事务
1. 集群
   - 虚拟主机：Virtual Host，一个独立的虚拟的包含交换器、队列等rabbitMQ服务器
   - 代理：Broker，表示消息队列服务器实体
1. 网络分区
1. 使用
   - 资源创建方式
     1. 提前静态
     1. 用时动态
   - 配置
1. 运维
   - 安装
     1. 安装erlang
     1. 下载rabbitmq包解压，直接运行
     1. 启动：`rabbitmq-server -detached`
   - 管理：rabbitmqctl
     1. `status/cluster_status`：信息、集群信息
     1. `add_user/add_permissions/set_user_tag xx administrator`：添加用户、添加权限
     1. `stop`：关闭erlang节点
     1. `start_app、stop_app、reset`：针对rabbitMQ程序
     1. `list_exchanges、list_bindings、list_queues [name type durable auto_delete]`：是否持久化、是否自动删除
     1. `list_queues xx message_ready/unacknowledged`：等待投递/未确认消息数
   - 集群
     1. 认识：保证节点崩溃后继续可用，提高消息吞吐量。共享user/vhost/exchange等，v2.6支持镜像队列，最少一个磁盘节点，其他为内存节点
     1. 节点配置
        - rabbitmqctl -n rabbit_1 join_cluster rab@rab：加入cluster
        - RABBITMQ_NODENAME=rabbit_1 RABBITMQ_NODE_PORT=5672 ./sbin/rabbitmq-server -detached
1. 原理
   - 集群内部利用erlang的分布式通信框架OTP
   - 存储机制
   - 流控
   - 镜像队列原理
1. wiki
   - 队列历史
     1. 商业的有微软的MSMQ、IBM的WebSphere
     1. JMS试图通过公共Java API的方式，隐藏不同mq的实际接口，解决互通问题，但是使用单独接口胶合众多不同的接口也是存在很多问题。老牌ActiveMQ是JMS的一种实现
     1. 消息通信标准化方案：2006年思科、红帽等联合制定了AMQP的公开标准。rabbitMQ是其开源实现，阿里的rocketMQ、kafka
        - AMQP：Advanced Message Queue，高级消息队列协议，是应用层的面向消息的中间件设计和开放标准，基于此协议客户端和消息中间件传递消息，不受产品/语言限制。模型架构和rabbitMQ一样
   - rabbitMQ历史
     1. RabbitMQ Technologies Ltd开发并提供商业支持
     1. 2010年被VMWare收购
     1. 最新版本3.8
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
### Kafka
1. 认识：流式分发平台，可水平扩展z
   - 发布/订阅：消息系统
   - 实时事件响应
   - 有备份、容错的分布式持久化集群
1. topic：用于存储消息
