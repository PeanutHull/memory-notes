### 队列
1. 特点
   - 业务解耦
   - 异步处理
   - 削峰
1. 问题
   - 高可用：数据不丢失、不重复、
### RabbitMQ
1. 认识：erlang编写，应用的通信方式，用来确保消息的可靠传递，实现异步处理、错峰流控
   - 可靠：持久化、传输确认、发布确认，跟踪机制
   - 灵活路由：内置Exchange机制、插件自定义路由
   - 消息集群：内建
   - 高可用：实现集群镜像
   - 插件机制(支持自定义)、多协议(STOMP、MQTT)、多客户端、管理界面
1. 概念
   - 基本
     1. 消息：包含routing-key(路由键)、priority(优先级)、delivery-mode(是否持久化)
     1. 生产者、消费者：Publisher、Consumer
   - 传输
     1. 交换器：Exchange，接收消息并路由给队列。绑定，Binding，用于和队列关联
     1. 消息队列：Queue
     1. 连接：Connection，如一个tcp
     1. 信道：Channel，多路复用连接中一条独立的双向数据流通道，tcp上的虚拟链接。所有消息是通过信道发送，避免tcp的高额新建销毁
   - 集群
     1. 虚拟主机：Virtual Host，一个独立的虚拟的包含交换器、队列等的raMQ服务器
     1. 代理：Broker，表示消息队列服务器实体。
1. 消息路由
   - 理解：生产者把消息发布到exchange上时一般携带routingKey，exchange的类型和bindingKey一起决定发送位置
   - Exchange类型
     1. direct：完全匹配，routingKey和bindingKey相同直传过去
     1. fanout：广播，发给所有绑定的队列，最快
     1. topic：用bindingKey匹配routingKey，用.切分，通配符#和*，如`#.usa`
     1. headers：匹配header，和direct一致，慢不用了
1. 消息持久化
1. 消息确认、事务机制
1. 运维
   - 安装：依赖erlang，单独安装
   - 启动：./sbin/rabbitmq-server -detached(后台方式)
   - 管理：rabbitmqctl
     1. status、cluster_status
     1. stop：关闭erlang节点
     1. start_app、stop_app、reset：针对raMQ程序
     1. list_exchanges、list_bindings、list_queues [name type durable auto_delete]：后俩为是否持久化、是否自动删除
   - 集群
     1. 认识：保证节点崩溃后继续可用，提高消息吞吐量。共享user/vhost/exchange等，v2.6支持镜像队列，最少一个磁盘节点，其他为内存节点。
     1. 节点配置
        - rabbitmqctl -n rabbit_1 join_cluster rab@rab：加入cluster
        - RABBITMQ_NODENAME=rabbit_1 RABBITMQ_NODE_PORT=5672 ./sbin/rabbitmq-server -detached
1. 原理
   - 集群内部利用 Erlang 提供的分布式通信框架 OTP
1. wiki
   - AMQP：Advanced Message Queue，高级消息队列协议，是面向消息的开放协议，RabbitMQ是其开源实现
   - 其他队列产品：老牌ActiveMQ、阿里的RocketMQ、Kafka