### 框架
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
1. Gin：以更好的性能实现类似Martini框架的API，5万star
   - 简洁
   - 高性能路由
1. Echo：简约、高性能，2万star
1. Iris：最快，完善的mvc
1. Buffalo：快速构建web
1. Revel：高效、全栈
1. Martini：轻巧、功能强大、模块化web，不再维护
### ORM
1. gorm
1. xorm
1. ent
### 日志
1. logrus：最活跃的日志库
1. zap：日志库
### 微服务
1. 非常适合微服务
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
1. Viper：配置信息处理框架，各种文件格式、环境变量、ETCD等，检测文件变动
1. fsnotify：viper的内部就是fsnotify
1. 其他
   - github.com/libi/dcron：基于一致性哈希的分布式定时任务库
   - NSQ
   - GoDotEnv：Ruby dotenv项目的go版本
     1. 支持yaml语法
     1. 支持不写入环境变量，使用`myEnv, err := godotenv.Read()`读取
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
