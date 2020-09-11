### 事务
1. 事务
   - 认识：保证一致性
   - 方法
     1. 排队
     1. 加锁：读写锁
     1. MVCC：实现复杂度高
   - 问题
     1. 读的顺序：mysql的trx_id类似时间戳
     1. 故障恢复：未完全恢复的时候，依然不能被外部看到
     1. 死锁：使用轻量级锁、死锁检测(性能高成本低)、等锁超时(超长事务不可能)
1. 分布式事务
   - 方案
     1. CAP理论
        - Consistency：一致性
        - Availability：可用性
        - Partition tolerance：分区容错性
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
### 分布式存储引擎
1. 分布式存储分类
   - 分布式文件系统：数据多节点存储，以透明的方式对文件进行管理和存取。有HDFS、Ceph、GFS
   - 分布式KV存储：存储关系简单的半结构化数据；通过某种机制将key进行分节点存储；可用于分享配置、缓存和服务发现。有ETCD、Redis，CloudKV
   - 分布式存储引擎：基于分布式文件存储系统和分布式数据处理计算，实现数据的分布式查询分析及更新；有：Hive、Hbase、ElasticSearch、ClickHouse、TiDB、Dremel、Druid
1. 发展
   - oldSql
     1. 特点：行存储、列存储、SMP
     1. 代表：oracle、mysql、postgre
   - noSql：not only sql
     1. 特点：kv/index、mapReduce、MPP
     1. 代表：Hbase、Redis、MangoDB、ElasticSearch、Dremel
   - newSql：sql + noSql
     1. 特点：关系型、列存储、MPP
     1. 代表：Spanner/F1、TiDB、TDSQL、Greenplum
1. 分类
   - 分析型/事务型
     1. OLAP
     1. OLTP
     1. HATP(OLAP&OLTP)
   - 数据模型
     1. Relation
     1. K-V
     1. Document
     1. Gragh
     1. TimeSeries
   - 响应时效性
     1. 实时
     1. 近实时
     1. 离线
1. 存储引擎架构
   - 逻辑架构：从上到下，中间三个左中右
     1. 对外协议及接口
     1. 元数据管理
     1. 引擎处理框架
     1. 系统协调服务
     1. HDFS
   - 处理架构
     1. Master-Slave
        - 应用：Hbase、Druid、TiDB
        - 组成
          1. master：masterNode、masterManager
          1. slave n：slaveNode、TaskWorker
        - 特点
          1. Master作为总体的调度者，负责向slave分配任务
          1. WorkManager统一管理和调度TaskWorker的执行计划
          1. Master可以为Multi-Master
          1. 数据分布在SlaveNode上
          1. Slave扩展能力强，通用的分布式并行计算框架
     1. MapReduce
        - 原理图
          1. ![avatar](../images/mapReduce1.jpg)
          1. ![avatar](../images/mapReduce2.jpg)
        - 特点
          1. 由于MR过程耗时长，适合 PB 级以上海量数据的离线处理分析 ，不适合在线使用场景
          1. 成本低，可以采用廉价的PC机器部署运行
          1. 良好的扩展性：当计算资源不能得到满足时，可通过增加机器来扩展它的计算能力
          1. 高容错性：当其中一台机器挂了，它可以把上面的计算任务可自动转移到另外一个节点上面上运行
        - 应用：Hive
     1. MPP
        - 认识：Massively Parallel Processing，大规模并行处理
          1. 完全并行的MPP + Shared Nothing(不共享硬件，只通过网络沟通)的分布式扁平架构，无Master
          1. 单个节点完全是独立的，不存在单点瓶颈
          1. 业务数据根据数据库模型和应用特点划分到各个节点 上，节点间网络通信，协同计算
          1. 数据加载高效
          1. 行列混合存储，对多维度查询计算支持高效
        - 应用：Dremel、Drill、 ElasticSearch
   - 数据更新方式
     1. 读写分离，数据文件存储和异步加载：70%
     1. 通过version记录更新：20%
     1. 通过事务型操作，直接更新原数据：10%
   - 数据一致性实现
     1. 分布式数据引擎大部分只能满足CAP原理中两点
     1. 分布式数据引擎在一致性上能做到最终一致或者强一致
     1. 一致性与多副本需要协同机制
   - 对外数据接口
     1. JDBC/ODBC
     1. Restful API 
     1. Thrift
     1. 封装为mysql类型的访问协议，SQL标准化 
     1. 自带客户端类型的SQL协议接口
1. 原理和使用技巧