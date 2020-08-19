### 事务
1. 分布式事务
   - 方案
     1. CAP理论：Consistency 一致性，Availability 可用性，Partition tolerance 分区容错性，不可兼得
     1. BASE方案：Basically Available 基本可用，Soft state 软状态，Eventually Consistent 最终一致，牺牲某时刻一致性保证最终一致性
   - 实现：只能实现弱一致性，TCC、高可用消息服务、最大努力通知
     1. 两阶段提交/XA：事务管理器协调，先问问ok不，再判断是否全部ok，https://github.com/yu199195/happylifeplat-transaction
     1. TCC
        - 认识
          1. 组成
             - try：预处理，业务检查及资源预留
             - confirm：确认，做业务确认操作
             - cancel：撤销，回滚操作
          1. 流程
             - TM发起所有的分支事务的try操作，任何一个分支事务的try操作执行失败，TM将会发起所有分支事务的Cancel操作
             - 若try操作全部成功，TM发起所有分支事务的Confirm操作
             - Confirm/Cancel操作若执行失败，TM会进行重试
        - 参考：https://github.com/yu199195/happylifeplat-tcc
     1. 基于消息中间件的解决分布式事务框架：https://github.com/yu199195/myth
     1. 消息中间件支持：jms(activimq),amqp(rabbitmq),kafka,roceketmq。
     1. rpc框架支持 : dubbo(可用Fescar保持数据一致性),motan,springcloud
     1. 本地事务日志存储支持 : redis,mogondb,zookeeper,file,mysql