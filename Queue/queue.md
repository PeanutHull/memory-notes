### 队列
1. 作用
   - 生产者/消费者模型
   - 负责消息的接收、存储、转发
1. 特点
   - 异步处理：时间无关可延后处理、可以并行处理
   - 解耦：两边修改不互相影响
   - 削峰
1. 问题
   - 高可用：确保消息的可靠传递，数据不丢失、不重复
1. Kafka Vs Rabbitmq：![avatar](../images/kafkaVsRabbitmq.png)
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
### RocketMQ
1. 认识：阿里kafka基础上开源
   - 高性能、高可用
   - 微服务架构设计，每个部分都支持多节点扩展
   - 基于Netty异步事件驱动通讯框架，采用长连接
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
