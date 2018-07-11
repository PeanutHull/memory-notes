### 架构演进、自主探索路线
1. 面临的问题和技术手段：高并发、高可用、分布式
   1. 高并发：tomcat集群，负载均衡，请求转发机双机热备，双向同步；session集群服务器；
   1. 大负载/持久化：数据库集群(自己造数据，自己测试性能)、主从配置、读写分离；分布式文件系统
   1. 缓存：redis分布式缓存
   1. 队列：rabbitMQ原理并记录心得
   1. 搜索：Elasticssearch
1. 优化
   1. mysql优化
   1. nginx优化
   1. tomcat优化
   1. JVM调优
1. 挑战词儿：高并发、高可用、大负载
1. 解决词儿：弹性扩容、故障转移(双机热备)、负载均衡、主从配置
### LB
1. 即负载均衡，做双机热备
1. 概念
   - 轮询
   - 随机
   - 最小响应时间
   - 最小并发数
1. 调度策略
   1. 轮询：实现简单、但是不考虑每台服务器的处理能力
   1. 权重：考虑了服务器的处理能力
   1. 地址散列：保证同一个用户访问同一台服务器
     1. 原ip地址
     1. 目标地址
     1. 最小连接：让服务器负载更加均匀
     1. 加权最小连接
1. 实现
   - 硬件
     1. F5
   - 软件
     1. LVS
     1. HAproxy
     1. Nginx Upstream
### 分布式缓存
### 分布式事务
   - 基于消息中间件的解决分布式事务框架：https://github.com/yu199195/myth
   - 消息中间件支持：jms(activimq),amqp(rabbitmq),kafka,roceketmq。
   - rpc框架支持 : dubbo,motan,springcloud。
   - 本地事务日志存储支持 : redis,mogondb,zookeeper,file,mysql
   - TCC：https://github.com/yu199195/happylifeplat-tcc
   - 二阶段提交：https://github.com/yu199195/happylifeplat-transaction
### 消息中间件
1. 中间件
   - ActiveMQ
     1. 概述：Apache出品，是最流行的开源消息总线。完全支持JMS1.1和J2EE1.4规范的JMS provider实现
     1. 特性
        - 多语言客户端：Java、C、C++、C#、Ruby、Python、PHP
        - 多种应用协议：OpenWire、Stomp REST、WS Notification、XMPP、AMQP
        - 支持JMS1.1和J2EE1.4规范，包括持久化、XA消息、事务
        - 高级特性：虚拟主题、组合目的、镜像队列
     1. 优点：遵循JMS规范、安装部署方便
     1. 缺点：会丢消息，重心在下代产品上
     1. 适用：中小企业级消息应用场景
   - rabbitMQ
     1. 概述：是开源的AMQP实现，服务端用Erlang编写，用于分布式系统中存储转发消息，易用性、扩展性、高可用性等表现不俗
     1. 特性
        - 支持多客户端：Java、JMS、C、.Net、Ruby、Python、PHP、ActionScript
        - AMQP的完整实现：vhost、Exchange、Binding、Routing key(虚拟主机、路由器、绑定、交换器)
        - 事务支持/发布确认
        - 消息持久化
     1. 优点：稳定性、安全性有保障
     1. 缺点：不支持动态扩展
     1. 适用：企业级应用
   - Kafka
     1. 概述：是高吞吐量的分布式发布订阅消息系统，是分布式的、分区的、可靠的分布式日志存储服务。本身做日志存储的，对消息的顺序要求严格
     1. 特性
        - 通过O(1)磁盘数据结构提供消息持久化，对于TB级的消息存储也能够保持长时间的稳定性能
        - 高吞吐量：普通硬件也支持每秒数百万的消息
        - Partition、Consumer Group
     1. 优点：可动态扩展节点、高性能、高吞吐量、无限扩容、消息可指定追溯
     1. 缺点：严格的顺序机制，不支持标准的消息协议，不支持消息优先级，不利于平台迁移
     1. 适用：大数据日志处理，对实时性、可靠性要求稍低
   - 比较
     1. RabbitMQ平台无关，剩下两个都偏Java
### 服务治理