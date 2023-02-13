### config
1. yaml
   - 认识：YAML Ain't a Markup Language，用于跨不同语言和框架的配置文件，xml子集，01年开始，后缀.yaml或.yml
     1. 缩进和冒号为主要特征，复杂
   - 举例
    ```conf
    key: 
        child-key: value
        child-key2: value2
        
    a1: abc  # string
    a2: true # boolean
    b1: nil  # string
    b2: null # null
    b3: NULL # null
    b4: NuLL # string

    c:
        x: c.x
        y: c.y
    e:
        - x: e[0].x
          y: e[0].y
        - x: e[1].x
          y: e[1].y
    ```
1. toml
   - 认识：Tom's Obvious，Minimal Language，目标成为最小的配置文件格式
     1. 语义精确，格式易于阅读
   - 特点
     1. 区分大小写
     1. 文件只能包含UTF-8编码的Unicode字符
     1. 空格表示制表符（0x09）或空格（0x20）
     1. 换行符表示LF（0x0A）或CRLF（0x0D0A）
   - 举例
    ```conf
    [server]
    name = "magic-lamp"
    port = "8000"
    mode = "test"
    debug = true

    [auth.ucenter]
    appID = ""
    secret = ""


    [f.A]
    x.y = "f.A.x.y"

    [f.B]
    x.y = """
    f.
        B.
            x.
                y
    """

    [f.C]
    points = [
        { x=1, y=1, z=0 },
        { x=2, y=4, z=0 },
        { x=3, y=9, z=0 },
    ]
    ```
1. dotenv项目：从.env文件加载配置到环境变量，认为配置要放在环境变量中，Ruby的
1. .ini
### 任务调度
1. 设计
   - 调度策略
     1. 调度策略
        - 高可用调度

        - 所有机器
        - 故障转移
        - 第一台
        - 最后一台

        - 轮询
        - 随机
        - 一致性HASH
        - 最不经常使用
        - 最近最久未使用
        - 忙碌转移
     1. 阻塞策略
        - 排队等待
        - 放弃本次
        - 终止之前
   - 支持子任务
   - 失败重试次数
   - 超时时间
   - 失败告警
   - 日志
1. crontab实现
   - 认识：方便直接
   - 特点
     1. 大批量任务难以胜任，没有资源监控、执行监控、报警、日志体系
   - 分布式特点
     1. 可视化web后台，方便任务管理
     1. 分布式架构，集群化调度，无单点故障
     1. 追踪任务状态，采集任务输出，可视化log
1. java实现
   - jdk
     1. Thread类：只能执行周期性任务，不能指定时间点
     1. Timer类：jdk的定时器工具，支持指定时间点，单线程执行任务，一个任务阻塞会影响其他任务
     1. ScheduledExecutorService：jdk1.5+的定时器工具，基于多线程执行，不互相影响，复杂定时规则较弱
   - 框架级
     1. spring task：不支持集群方式部署，不能做数据存储型定时任务
     1. spring quartz：多线程异步执行，需要手动配置QuartzJobBean、JobDetail和Trigger等，需引入quartz包
#### 分布式实现
1. xxl-job
   - 认识：开发迅速、学习简单、轻量级、易扩展、开箱即用。对quartz进行了扩展，使用mysql数据库存储数据，并且内置jetty作为RPC服务调用，java开发
     1. 界面维护定时任务和触发规则，容易管理
     1. 能动态启动或停止任务
     1. 支持弹性扩容缩容
     1. 支持任务失败报警
     1. 支持动态分片
     1. 支持故障转移
     1. Rolling实时日志
     1. 支持用户和权限管理
1. elastic-job
   - 认识：采用zookeeper实现分布式协调，实现任务高可用以及分片。专门为高并发和复杂业务场景开发，apache下的项目，java开发
   - 组成：2.x之后
     1. Elastic-Job-Lite：轻量级无中心化解决方案，jar包的形式提供服务
     1. Elastic-Job-Cloud
   - 特点
     1. 分布式调度协调
     1. 弹性扩容缩容
     1. 失效转移
     1. 错过执行作业重触发
     1. 作业分片一致性，保证同一分片在分布式环境中仅一个执行实例
     1. 自诊断并修复分布式不稳定造成的问题
     1. 支持并行调度
   - 整合方式：java api、spring、spring boot
   - 任务类型
     1. simple
     1. dataflow
     1. script
   - 特性
     1. 自定义分片
     1. 作业监听器
     1. 事件追踪
1. Saturn：唯品会开源，在Elastic-Job基础上
1. TBSchedule：阿里开发
1. k8s
   - 基于容器的调度，更强的任务调度能力
   - 相对于xxl-job无需提前准备执行器，无需提前准备代码运行环境
### other
1. 搜索引擎
   - 组成：搜集、分析、索引、查询