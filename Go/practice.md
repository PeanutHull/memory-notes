### 框架
1. Gin：以更好的性能实现类似Martini框架的API，5万star
   - 简洁
   - 高性能路由
1. tars：性能强
1. beego
   - 用于开发api、web的http框架，自带orm，大而全，最后一次更新20年12月
     1. 简单：RESTFul、mvc，支持热编译，自动化打包
     1. 智能：路由、监控
     1. 模块：Session、缓存、日志、配置解析、性能监控、上下文操作、ORM 模块、请求模拟
     1. 性能：原生http包、goroutine
   - 架构
     1. cache
     1. config
     1. context
     1. httplibs
     1. logs
     1. orm
     1. session
     1. toolbox
   - 组成
     1. mvc
     1. 路由
     1. orm
     1. 配置
     1. 模块
     1. 进程内监控
     1. 部署
        - 独立部署：`nohup ./beepkg &`
        - supervisor部署
        - nginx反向代理
1. Echo：简约、高性能，2万star
1. Iris：最快，完善的mvc
1. Buffalo：快速构建web
1. Revel：高效、全栈
1. Martini：轻巧、功能强大、模块化web，不再维护
1. xes解析
    ```go
    // main函数中
    testing.Init()      // 注册测试标志，用于不使用go test的情况下，进行如基准测试的函数调用
    err = gracehttp.Serve(&http.Server{Addr: ":" + configs.GetServer().Server.Port, Handler: g})        // grace承接http服务
    ```
### ORM
1. gorm
1. xorm
1. ent
### 日志
1. logrus：最活跃的日志库
1. zap：日志库
### 库、中间件
1. Sentinel
   - 认识：面向分布式服务架构的高可用流量防护组件，以流量为切入点，从限流、流量整形、熔断降级、系统负载保护、热点防护等多个维度来帮助开发者保障微服务的稳定性
     1. 承接ali的双11流量
   - 生态：![avatar](../images/about_sentinel.png)
1. Loaclcache：bigcache、fastcache、freecache、Caffeine
   - Caffeine：基础存储没有采用复杂数据结构采用的是ConcurrentHashMap，所有的管理操作异步化、数据驱逐（淘汰）算法采用 W-TinyLFU，以及部分情况 LRF+LFU结合的方式，各种优秀的队列设计，冲突严重hash情况下链表降级采用红黑树来处理 等等优化处理
1. grace
   - 认识：零停机部署的开源库，facebook开发
     1. 优雅重启：SIGUSR2
     1. 优雅结束：SIGTERM
   - 过程
     1. 构造server
     1. 设置ConnState，监听各连接的状态变化
     1. 启动新协程，接管各chan信号
     1. 在新协程中正式启动服务
1. viper
   - 认识：配置信息处理框架，各种文件格式、环境变量、ETCD等，检测文件变动
     1. 支持 JSON/TOML/YAML/HCL/envfile/Java properties 等多种格式的配置文件
     1. 可以设置监听配置文件的修改，修改时自动加载新的配置
     1. 从环境变量、命令行选项和io.Reader中读取配置
     1. 从远程配置系统中读取和监听修改，如 etcd/Consul
     1. 代码逻辑中显示设置键值
   - demo
    ```go
    viper.SetConfigName("config")
    viper.SetConfigType("toml")
    viper.AddConfigPath(".")
    viper.SetDefault("redis.port", 6381)
    err := viper.ReadInConfig()
    if err != nil {
        log.Fatal("read config failed: %v", err)
    }
    name := viper.Get("app_name")
    ```
1. fsnotify：viper的内部就是fsnotify
1. json-iterator/go：几倍性能于标准库`encoding/json`的100%兼容的json库
   - 只有使用struct才能获得显著的性能提升，因为struct只需一次反射，map每次都要
   - 1.10后性能和标准库差不多了，意义不大了
1. 其他
   - github.com/libi/dcron：基于一致性哈希的分布式定时任务库
   - NSQ
   - GoDotEnv：Ruby dotenv项目的go版本
     1. 支持yaml语法
     1. 支持不写入环境变量，使用`myEnv, err := godotenv.Read()`读取
### 微服务
1. 微服务
   - 理解：微服务架构是一种更独立的架构模式，能够单独更新和发布。是分布式网状结构，它提倡将单一应用程序划分成一组小的服务，服务之间互相协调、互相配合，为用户提供最终价值。微服务架构 ≈ 模块化开发 + 分布式计算
   - 好处
     1. 逻辑清晰
     1. 快速迭代
     1. 多语音组合
1. 微服务架构：![avatar](../images/micro_service_struct.png)
   - 设计原则
     1. 要领域驱动设计，不是数据驱动设计，也不是界面驱动设计
     1. 边界清晰
     1. 分层清晰
1. go-micro
   - 认识：构建、管理分布式程序的系统，微服务框架
   - 组成
     1. runtime：运行时，即micro工具，管理配置、认证、网络
        - api网关
        - broker：允许异步消息的代理
        - network：通过微网络服务构建多云网络
        - new：服务模板生成器
        - proxy：透明服务代理
        - registry：服务资源管理器
        - store：简单的状态存储
        - web：仪表盘浏览服务
     1. framework：开发框架,![avatar](../images/go_micro_framework.png)
        - server、client
        - registry：提供服务发现机制
        - selector：服务选择器
        - transport：服务间的通信接口
        - broker：异步的消息发布、订阅接口
        - codec：消息的编解码
     1. clients：多语言客户端
   - 使用
     1. 注册服务
     1. micro工具new生成服务
   - 历史：1.0、2.0、3.0的升级都不兼容，3.0改为了云原生的托管平台收费模式(就像阿里云卖硬件，它卖软件)。Licence改为了Polyform Shield，就是还是开源，但是防止AWS这样的云服务部署Micro服务，和Micro公司进行直接竞争
   - 组件
     1. 注册配置中心：consul
     1. 链路追踪：jaeger
     1. 监控：promethues
     1. 熔断器：hystrix
     1. 通信：grpc
     1. 限流：ratelimit
     1. 负载均衡：selector
     1. 日志：zap + ELK
     1. 协议：protobuf
1. consul
   - 认识：注册中心，支持多数据中心的分布式高可用的服务发布和注册服务，基于go开发
     1. 可组合构建完整的服务管理系统
     1. 是一种服务网格解决方案
   - 功能
     1. 提供了三种不同的应用场景，每个功能都能单独使用
        - 服务注册发现：就是可以让服务地址想怎么变就怎么变
        - 服务配置(kv形式)：可用于动态配置、功能标记、协调、leader选举
        - 服务隔离(分段)
     1. 支持健康检查、运行状况检查
     1. 支持多数据中心
     1. 安全服务通信：可为服务生成、分发tls证书，建立相互的tls连接
     1. 内置简单代理
   - 使用流程：![avatar](../images/consol_process.png)
   - 架构：![avatar](../images/consul_struct.png)
     1. 两个数据中心，通过wan gossip
     1. 数据中心内部，分leader、follower
   - 协议
     1. Raft Protocol：选举，保证服务的一致性
     1. Gossip Protocol：八卦，一个事件发生时，其他节点需要知道这个事件
        - lan pool：局域网池
        - wan pool
1. jaeger
   - 认识：链路追踪，![avatar](../images/jaeger_struct.jpg)
     1. 高扩展
     1. 可观察
     1. 原生支持openTracing
   - 设计
     1. jaeger-client：使用thrift通过udp发送给agent
     1. jaeger-agent：go，使用thrift通过Tchannel发送给collector
     1. jaeger-collector：go，队列入存储
     1. jaeger-query：go
     1. jaeger-ui：react
     1. 存储：cassandra
   - 组成
     1. span：逻辑工作单元，有操作名称、开始时间、持续时间，跨度可以嵌套并排序，建立因果关系模型
        - 对象
          1. tag：标签集合
          1. log：一组span日志集合
          1. spanContext：上下文对象
          1. reference：span间关系
   - 项目应用原理：![avatar](../images/jaeger_in_project.jpg)
1. 熔断
   - 认识：hystrix-go，记录成功调用、失败、超时、拒绝数量，在需要的地方加熔断，要根据业务设计一整套的熔断流程和处理逻辑
     1. 熔断计数器：默认DefaultMetricCollector，保存熔断器的所有状态数量
     1. 熔断器状态
        - close：允许流量通过
        - open：不允许
        - half_open：允许一部分，如果出现异常，进入open，否则一点点放量
     1. 字段
        - timeout：超时时间
        - maxConCurrentRequest：最大并发量
        - sleepWindow：熔断后重启时间，默认5秒
        - requestVolumeThreshold：单位时间请求量
        - errorPercentThreshold：熔断百分比，超过自动熔断
     1. hystrix-dashboard：web管理平台
1. 限流
   - 认识：uber/limit，保护后端服务
1. 负载均衡：selector
1. apm
   - 认识：应用性能产品，保障健康可监测性
     1. 分布式链路追踪
     1. 性能指标分析
     1. 应用和服务依赖
   - demo
     1. 听云
     1. 网校探针：发生故障的时候，能够快速定位和解决问题
     1. skywalking：是观察性分析平台和应用性能管理系统。提供分布式追踪、服务网格遥测分析、度量聚合和可视化一体化解决方案，可用于php
     1. 元老：openTracing、opencensus
### 技术解决方案
1. 千万级WebSocket弹幕消息推送服务
   - 难点
     1. 推送频率：在线人数 * 每秒弹幕数 = 10亿条每秒
     1. 有多个房间
   - 方案
     1. 推拉模式的选择：拉请求量不可控，并且大多数请求无效，消息不及时；推需要维持多个长链接
     1. 瓶颈破除
        - 内核：linux内核发送tcp极限包频100万/秒
          1. 方案：消息合并，将同一秒内n条消息合并成1条，这样每秒推送次数只等于在线连接数
        - 锁：需要维护在线用户集合(百万在线)，1. 发送消息需要遍历，耗时长，2. 推送期间客户端正常上下线，集合需要上锁
          1. 方案：大拆小
             - 连接打散到多个集合中，每个集合有自己的锁
             - 多线程并发推送多个集合，避免锁竞争
             - 读写锁替代互斥锁
        - cpu：百万级消息百万次json编码非常耗费cpu
          1. 方案：减少重复计算，编码前置，n条消息只编码1次
     1. 分布式架构：上下三层，通过网关集群对外用http1.1打散管理一部分连接，网关对内用http2对接业务服务器
        - http2支持连接复用，可以在单个连接上可以实现高吞吐的通讯，作为内部通讯rpc很适合
   - demo实现
     1. api设计：拿一个结构体，读消息用in chan，发消息用out chan
     1. websocket设计：go起一个协程，for死循环读websocket消息扔到in chan；go再起一个协程，死循环读out chan，将消息写到websocket
        - 问题1：当in chan写满进入读ws协程阻塞时，写协程网络报错关闭ws链接，此时读协程不知道链接已经关闭了
          1. 解决方案：用select同时监听in chan和新加的容量为1的close chan，当进入close chan分支时(关闭ws时同时关闭close chan使其不阻塞)，表示链接被关闭了。同样ws断了链接api也会阻塞，所以都加上
        - 问题2：ws的close是线程安全的，是可重入的，所以可多次关闭，但是close chan不可重入，所以用结构体的标志位指示是否关闭，同时用mutex锁住防止并发关闭
### wiki
1. 脚手架
   - 认识：比喻各类语言的前期工作环境，方便直接进行开发
   - 组成举例
     1. git代码管理工具
     1. gin框架
     1. gorm操作数据库
     1. godotenv加载
     1. go-playground/validator
     1. golang-jwt/jwt
     1. logker日志库 
1. 目标
   - 编码能力和质量
   - 并发编程实践、设计模式实践
