### 日志
1. log的缺陷
   - 不支持日志切割
     1. 日期方式
     1. 最大行数方式
     1. 最大容量方式
   - 不支持多个日志级别
   - 不支持日志格式化
   - 大量使用interface{}和反射，内存分配次数多，性能低
1. logrus：最活跃的日志库
   - 特点
     1. 完全兼容标准日志库，拥有七种日志级别：Trace, Debug, Info, Warning, Error, Fataland Panic
     1. 可扩展的Hook机制，允许使用者通过Hook的方式将日志分发到任意地方，如本地文件系统，logstash，elasticsearch或者mq等，或者通过Hook定义日志内容和格式等
     1. 可选的日志输出格式，内置了两种日志格式JSONFormater和TextFormatter，还可以自定义日志格式
     1. Field机制，通过Filed机制进行结构化的日志记录
     1. 线程安全
1. zap：uber开源的高性能日志库，结构化的多日志级别的日志格式，性能比logrus好，更少的内存分配次数
   - 组成
     1. Sugared Logger
     1. Logger：比SugaredLogger更快，只支持强类型的结构化日志记录
   - 使用
     1. 日志切割：搭配lumberjack
     1. 全局Logger：`zap.S()`，`zap.L()`
   - demo
    ```go
    logger, _ = zap.NewProduction()
    defer logger.Sync()
    logger.Error("Error fetching url..", zap.String("url", url), zap.Error(err))
    logger.Info("Success..", zap.String("statusCode", resp.Status), zap.String("url", url))
    ```
### 框架
1. Gin：以更好的性能实现类似Martini框架的API，5万star
   - 特点
     1. 简洁
     1. 高性能路由
   - validator
     1. 功能
        - 自定义约束
        - 错误处理
     1. 范围约束
        - len：等于
        - max：小于等于
        - min：大于等于
        - eq：等于，注意与len不同。对于字符串，eq约束字符串本身的值，而len约束字符串长度
        - ne：不等于
        - gt：大于
        - gte：大于等于
        - lt：小于
        - lte：小于等于
        - oneof：只能是列举出的值其中一个，这些值必须是数值或字符串，以空格分隔，如果字符串中有空格，将字符串用单引号包围，如`oneof=red green`
     1. 跨字段约束：形式为约束组合
        - 组成
          1. 约束：如eq
          1. 更深层次的字段：cs，cross-struct
          1. field
        - 举例
          1. `eqfield=Xx`
          1. `eqcsfield=Xx.Xx`
     1. 字符串
        - contains=：包含参数子串
        - containsany：包含参数中任意的 UNICODE 字符
        - containsrune：包含参数表示的 rune 字符
        - excludes：不包含参数子串
        - excludesall：不包含参数中任意的 UNICODE 字符
        - excludesrune：不包含参数表示的 rune 字符，excludesrune=☻
        - startswith：以参数子串为前缀
        - endswith：以参数子串为后缀
     1. 特殊
        - -：跳过该字段不检验
        - |：多个约束只需要满足其中一个
        - required：字段必须设置，不能为默认值
        - omitempty：如果字段未设置，则忽略它
        - 唯一性：`unqiue|unqiue=field`，可约束数组/切片的元素、map的值、struct的字段
        - 邮件：`email`
     1. 其他：ASCII/UNICODE字母、数字、十六进制、十六进制颜色值、大小写、RBG颜色值，HSL颜色值、HSLA颜色值、JSON 格式、文件路径、URL、base64编码串、ip地址、ipv4、ipv6、UUID、经纬度等
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
1. 分类
   - 大型：功能大而全
     1. tars
   - rpc
     1. gRPC：本身不是分布式的，作为框架需要搭配很多东西
     1. tars：性能强
     1. rpcx
        - 认识：RPC服务治理框架
          1. 高性能：gRPC性能的两倍
          1. 交叉语言：各种编程语言的调用
          1. 服务发现：支持直连、Zookeeper、Etcd、Consul、mDNS等注册中心
          1. 服务治理：支持Failover、Failfast、Failtry、Backup等失败模式，支持随机、轮询、权重、网络质量、一致性哈希、地理位置等路由算法
   - web
     1. Echo：简约、高性能，2万star
     1. Iris：最快，完善的mvc
     1. Buffalo：快速构建web
     1. Revel：高效、全栈
     1. Martini：轻巧、功能强大、模块化web，不再维护
1. ORM
   - gorm
   - xorm
   - ent
   - go-redis
     1. 认识：官方推荐第一个
        - 全命令支持
        - 自带的自动连接池，超时控制
        - pipeline、script支持
        - 订阅、事务支持
        - 哨兵、集群支持
        - 报表支持
     1. 生态：分布式锁、缓存、限流
     1. 连接池配置说明
        ```go
        gClient = redis.NewClient(&redis.Options{
            //连接信息
            Network:  "tcp",
            Addr:     "127.0.0.1:6379",
            Password: "",
            DB:       0,

            // 连接池
            PoolSize:     15,                           // 最大连接数，默认为4倍CPU数， 4 * runtime.NumCPU
            MinIdleConns: 10,                           // 启动阶段指定的Idle连接，即长期维持的最少数量

            //超时
            DialTimeout:  5 * time.Second,              // 连接建立超时时间，默认5秒
            ReadTimeout:  3 * time.Second,              // 读超时，默认3秒， -1表示取消读超时
            WriteTimeout: 3 * time.Second,              // 写超时，默认等于读超时
            PoolTimeout:  4 * time.Second,              // 当所有连接都处在繁忙状态时，客户端等待可用连接的最大等待时长，默认为读超时+1秒

            // 闲置连接检查
            IdleCheckFrequency: 60 * time.Second,       // 闲置连接检查的周期，默认为1分钟，-1表示不做周期性检查，只在客户端获取连接时对闲置连接进行处理
            IdleTimeout:        5 * time.Minute,        // 闲置超时，默认5分钟，-1表示取消闲置超时检查
            MaxConnAge:         0 * time.Second,        // 连接存活时长，从创建开始计时，超过指定时长则关闭连接，默认为0，即不关闭存活时长较长的连接

            // 命令执行失败时的重试策略
            MaxRetries:      0,                         // 命令执行失败时，最多重试多少次，默认为0即不重试
            MinRetryBackoff: 8 * time.Millisecond,      // 每次计算重试间隔时间的下限，默认8毫秒，-1表示取消间隔
            MaxRetryBackoff: 512 * time.Millisecond,    // 每次计算重试间隔时间的上限，默认512毫秒，-1表示取消间隔

            // 自定义连接函数
            Dialer: func() (net.Conn, error) {
                netDialer := &net.Dialer{
                    Timeout:   5 * time.Second,
                    KeepAlive: 5 * time.Minute,
                }
                return netDialer.Dial("tcp", "127.0.0.1:6379")
            },

            // 钩子函数
            OnConnect: func(conn *redis.Conn) error {   // 连接池需要新建连接时则会调用此钩子函数
            },
        })

        defer gClient.Close()
        ```
1. wiki
   - xes解析
    ```go
    // main函数中
    testing.Init()      // 注册测试标志，用于不使用go test的情况下，进行如基准测试的函数调用
    err = gracehttp.Serve(&http.Server{Addr: ":" + configs.GetServer().Server.Port, Handler: g})        // grace承接http服务
    ```
   - rpc
     1. 认识：Remote Procedure Call Protocol，远程过程调用协议，打通了应用层和传输层，不需要关注通信细节直接调用远程方法，实现函数调用模式的网络化
        - 包含了传输协议、编码协议
        - 内含多种实现方案(socket/管道)，linux的固定端口111
     1. 意义
        - 不用关心连接的网络细节
        - 分布式部署
        - 程序内连接，解耦
        - 面向过程，restful面向资源
     1. 分类
        - java：古老的RMI、dobbu、motan、spring cloud
          1. 如dobbu是产品级的rpc框架
        - go：rpcx
        - 跨语言：grpc、thrift
          1. 没有服务发现、负载均衡等相关机制
        - 其他：phprpc、yar、swoole、hprose
     1. thrift：接口描述语言和二进制通讯协议，跨语言，Apache的
     1. 跨语言rpc
        - 实现基础
          1. 通用数据结构
          1. 网络编程
        - 实现方式
          1. 文件
             - web service
               1. 实现原理：将被调用的方法名、参数封装到WSDL的xml文件中，然后解析xml进行调用
               1. 弊端：xml的数据传输低效性，网络传输的路径长(基于http协议)
          1. 二进制
             - 新一代rpc实现原理
               1. 编写描述文件
               1. 转换描述文件为相应语言的数据结构(结构体、类等)，使用Protobuf
               1. 翻译：将数据结构转为二进制数据、字节数组
               1. 传输：通过socket传给另一个编程语言
               1. 再次翻译：翻译为本语言的数据结构
               1. 调用执行
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
1. fsnotify：监听文件变化，viper的内部就是fsnotify
1. json-iterator/go：几倍性能于标准库`encoding/json`的100%兼容的json库
   - 只有使用struct才能获得显著的性能提升，因为struct只需一次反射，map每次都要
   - 1.10后性能和标准库差不多了，意义不大了
1. Simplejson：json快速处理器，关键部分c实现
1. go-resty/resty/v2：http请求库
   - 简单、功能丰富，链式调用
   - 自动Unmarshal
1. go-callvis：函数调用关系图
1. 其他
   - github.com/libi/dcron：基于一致性哈希的分布式定时任务库
   - NSQ
   - GoDotEnv：Ruby dotenv项目的go版本
     1. 支持yaml语法
     1. 支持不写入环境变量，使用`myEnv, err := godotenv.Read()`读取
   - go-app：是一个使用 Go + WebAssembly技术编写渐进式Web应用的库，可以输出布局
1. 业务相关
   - casbin/casbin：访问控制库，支持ACL/RBAC/ABAC
1. 图像
   - plot：绘图库，内置很多组件，可以生成静态图片
     1. 支持折线图、直方图、函数图像、气泡图
     1. 搭配web服务可以直接返回一张图片给前端
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
1. 连接池
   - 原理：![avatar](../images/conn_pool.png)
   - go-redis
     1. 特点
        - 只实现了简单的轮询形式，没有加权等筛选
     1. 实现
        - 使用chan作为存储池
        - 使用mutex作为增减chan与其配套数据的互斥保证
        - 队列、池子就是slice和chan的配合使用
        - 利用连接池最大数量作为一个chan(随便struct{}类型就可以)的缓冲大小，存储工作的连接
          1. 在从连接池拿连接时写入chan，不停拿不停写，写满阻塞实现了池的最大忙碌数量，这时候计时器介入，实现获取连接的超时逻辑
          1. 往连接池放连接时，不停放，不停取出chan的值，作减法
1. 爬虫
   - 设计思想
     1. engine：总协调作用，需要轻量，耗时操作要交出去
   - 实现方案
     1. 用http获取原始页面html字符串
     1. 用同一类的parser解析同一类的页面，用正则获取目标下一个页面，将下一个页面的url和对应使用的解析器放入engine中等待scheduler获取
        - 解析内容的方式：正则、css选择器、xpath
     1. 用正则在页面中获取需要的信息
   - 并发版：使用调度器scheduler，最重要的是调度器
     1. 第一版：简易
        - 只是简单的新起多个协程的scheduler去投递给所有worker公用的一个worker chan，让多个worker抢这个chan，但是由于和engine他们三者互通chan，导致worker数量占满后，没有可用的worker去接收调度器的任务，即循环等待
          1. 解决方案：调度器投递worder的chan时，每次新建协程处理，就不会卡主了
        - 只是交给了go自己去调度，自己不用管，虽然不是性能最好的，但是最方便的
     1. 第二版：队列版
        - 特点
          1. scheduler自己维护request chan和worker chan
          1. 利用一个select，同时用两个分别的slice缓存接收到的request和worker，判断二者都有时，才协调二者同时运行，同时能运行入/运行出放到队列里，这就是一种任务分发
        - 代码
            ```go
            s.workerChan = make(chan chan engine.Request)
            s.requestChan = make(chan engine.Request)
            go func() {
                var requestQ []engine.Request
                var workerQ []chan engine.Request
                for {
                    var activeRequest engine.Request
                    var activeWorker chan engine.Request
                    if len(requestQ) > 0 && len(workerQ) > 0 {
                        activeWorker = workerQ[0]
                        activeRequest = requestQ[0]
                    }
                    select {                                        // 将任务分发和内部的两个队列缓存，一起调度
                    case r := <-s.requestChan:
                        requestQ = append(requestQ, r)
                    case w := <-s.workerChan:
                        workerQ = append(workerQ, w)
                    case activeWorker <- activeRequest:             // 只有request和worker都ready时，才进行任务分发，因为request和worker都要干活
                        workerQ = workerQ[1:]
                        requestQ = requestQ[1:]
                    }
                }
            }
            ```
   - 分布式版：新起goroutine同步调用jsonrpc
     1. 使用连接池管理不同(端口)的rpc server
        - go只需要一个chan就可以解决大多数连接池遇到的加锁、同步问题，只需要写入、读取
     1. 启动rpc server process作为服务承载
        - 后续这些自己写的服务process，可以接入服务发现框架consul，实现更健壮的控制
     1. rpc不能传输函数
        - 解决方案：传函数名称的字符串过去，用switch选择
1. 流媒体任务调度
    ```go
    func (r *Runner) startDispatch() {
        defer func() {
            if !r.longLived {
                close(r.Controller)
                close(r.Data)
                close(r.Error)
            }
        }()

        for {
            select {                                                    // 指示进行何种任务，生产者消费者模型，dispatcher完后加入到executor
            case c :=<- r.Controller:
                if c == READY_TO_DISPATCH {
                    err := r.Dispatcher(r.Data)                         // 执行任务的数据
                    if err != nil {
                        r.Error <- CLOSE
                    } else {
                        r.Controller <- READY_TO_EXECUTE
                    }
                }

                if c == READY_TO_EXECUTE {
                    err := r.Executor(r.Data)
                    if err != nil {
                        r.Error <- CLOSE
                    } else {
                        r.Controller <- READY_TO_DISPATCH
                    }
                }
            case e :=<- r.Error:
                if e == CLOSE {
                    return
                }
            default:
            }
        }
    }
    ```
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
