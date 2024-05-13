### 方案知识
1. 限流算法
   - 固定时间窗口算法：即计数器，redis的key一定时间内做使用作减法、一段时间后作加法
     1. 简单粗暴
     1. 时间约小，误差越小
     1. 不是平均速率限流，即一上来全部用光
   - 滑动时间窗口算法
     1. 认识：把时间划片，一点点往前挪，抛弃前一个格子，进入下一个格子，能够保留前后固定时间窗口的请求统计
        - 不存在临界问题。划分格子越多，限流统计越精准
     1. 实例
        ```go
        // TODO 使用环形队列等数据结构来优化性能
        type Bucket struct {                                                                // Bucket 定义了窗口内的一个计数桶
            Timestamp int64 // 桶的时间戳
            Count     int   // 桶内的计数
        }
        type SlidingWindow struct {                                                         // SlidingWindow 定义了滑动窗口的结构
            Buckets map[int64]*Bucket // 窗口内的桶
            Mutex   *sync.RWMutex     // 读写锁，保证并发安全
            Window  time.Duration     // 窗口大小
            Granularity time.Duration // 粒度，即每个桶的时间跨度
        }
        func NewSlidingWindow(windowSize, granularity time.Duration) *SlidingWindow {       // NewSlidingWindow 初始化一个滑动窗口
            return &SlidingWindow{
                Buckets:     make(map[int64]*Bucket),
                Mutex:       &sync.RWMutex{},
                Window:      windowSize,
                Granularity: granularity,
            }
        }
        func (sw *SlidingWindow) getCurrentBucket() *Bucket {                               // getCurrentBucket 获取当前时间的桶
            now := time.Now().UnixNano() / int64(sw.Granularity)
            if bucket, ok := sw.Buckets[now]; ok {
                return bucket
            }

            sw.Mutex.Lock()
            defer sw.Mutex.Unlock()

            bucket, ok := sw.Buckets[now]
            if !ok {
                bucket = &Bucket{Timestamp: now, Count: 0}
                sw.Buckets[now] = bucket
            }

            return bucket
        }
        func (sw *SlidingWindow) removeOldBuckets() {                                       // removeOldBuckets 移除过期的桶
            minTimestamp := (time.Now().UnixNano() / int64(sw.Granularity)) - int64(sw.Window/sw.Granularity)
            sw.Mutex.Lock()
            defer sw.Mutex.Unlock()

            for timestamp := range sw.Buckets {
                if timestamp < minTimestamp {
                    delete(sw.Buckets, timestamp)
                }
            }
        }
        func (sw *SlidingWindow) Increment() {                                              // Increment 增加当前桶的计数
            sw.getCurrentBucket().Count++
            sw.removeOldBuckets()
        }
        func (sw *SlidingWindow) Sum() int {                                                // Sum 获取窗口内的总计数
            sum := 0
            sw.Mutex.RLock()
            defer sw.Mutex.RUnlock()

            minTimestamp := (time.Now().UnixNano() / int64(sw.Granularity)) - int64(sw.Window/sw.Granularity)
            for timestamp, bucket := range sw.Buckets {
                if timestamp >= minTimestamp {
                    sum += bucket.Count
                }
            }
            return sum
        }
        ```
   - 漏斗算法
     1. 认识：把请求往桶中放，定时拿出n个执行，桶满时抛弃，是请求放入入口，固定出口的方式，适合严格限制并发的场景
        - 严格限制执行速率，流入速度大于流出就溢出
        - 想象一个尖嘴向下的漏斗，下边的尖嘴固定时间执行，上边的容器放需要执行的请求
     1. code：make_space是核心，给漏斗腾出空间，取决于于过去了多久及流水速率，
        ```go
        // TODO 需要做高并发情况下的性能优化
        type Funnel struct {                                                    // Funnel 漏斗结构
            capacity  float64   // 漏斗容量
            rate      float64   // 流出速率（每秒）
            water     float64   // 当前水量
            lastLeak  time.Time // 上一次漏水时间
            lock      sync.Mutex
        }
        func NewFunnel(capacity, rate float64) *Funnel {                        // NewFunnel 创建一个新的漏斗
            return &Funnel{
                capacity: capacity,
                rate:     rate,
                water:    0,
                lastLeak: time.Now(),
                }
        }
        func (f *Funnel) leak() {                                               // leak 模拟水漏出
            now := time.Now()
            leakDuration := now.Sub(f.lastLeak).Seconds()
            leakVolume := leakDuration * f.rate // 计算这段时间内应该漏出的水量

            f.water = f.water - leakVolume      // 更新当前水量
            if f.water < 0 {
                f.water = 0                     // 防止水量变成负数
            }

            f.lastLeak = now                    // 更新漏水时间
        }
        func (f *Funnel) TryWater(volume float64) bool {                        // TryWater 尝试加水，如果漏斗未满，返回true；否则返回false
            f.lock.Lock()
            defer f.lock.Unlock()

            f.leak() // 先让水漏出
            if f.capacity-f.water >= volume {
                f.water += volume // 加水
                return true
            }
            return false
        }

        func main() {
            funnel := NewFunnel(10, 1) // 创建一个容量为10，每秒漏水速率为1的漏斗

            for i := 0; i < 20; i++ {
                go func(index int) {
                    ok := funnel.TryWater(1) // 每个请求尝试加1单位的水
                    if ok {
                        fmt.Printf("Request %d passed\
                        ", index)
                        } else {
                        fmt.Printf("Request %d blocked\
                        ", index)
                        }
                    }(i)
                }

            time.Sleep(15 * time.Second) // 等待足够的时间，观察效果
            }
        }
        ```
        ```python
        # coding: utf8
        import time
        class Funnel(object):
            def __init__(self, capacity, leaking_rate):
                self.capacity = capacity                                    # 漏斗容量
                self.leaking_rate = leaking_rate                            # 漏嘴流水速率
                self.left_quota = capacity                                  # 漏斗剩余空间
                self.leaking_ts = time.time()                               # 上一次漏水时间
            def make_space(self):
                now_ts = time.time()
                delta_ts = now_ts - self.leaking_ts                         # 距离上一次漏水，是否可以流入，这里严格限制了并发
                delta_quota = delta_ts * self.leaking_rate
                if delta_quota < 1:
                    return

                self.left_quota += delta_quota                              # 加水
                self.leaking_ts = now_ts                                    # 更新漏水时间
                if self.left_quota > self.capacity:                         # 剩余空间不得高于容量
                    self.left_quota = self.capacity

            def watering(self, quota):
                self.make_space()
                if self.left_quota >= quota:                                # 判断剩余空间是否足够
                    self.left_quota -= quota
                    return True
                return False
        
        funnels = {}                                                        # 所有的漏斗

        # capacity 漏斗容量
        # leaking_rate 漏嘴流水速率 quota/s
        def is_action_allowed(user_id, action_key, capacity, leaking_rate):
            key = '%s:%s' % (user_id, action_key)
            funnel = funnels.get(key)
            if not funnel:
                funnel = Funnel(capacity, leaking_rate)
                funnels[key] = funnel
            return funnel.watering(1)                                       # 进行漏水消费

        # 测试
        for i in range(20):
            print is_action_allowed('laoqian', 'reply', 15, 0.5)
        ```
   - 令牌桶算法：以固定速率往桶中放入令牌，令牌有最大数量，使用时减去相应令牌即可，适合突发特性的流量，漏斗是匀速的无法解决
     1. 拿到令牌才执行请求
1. jaeger
   - 认识：链路追踪，![avatar](../../images/jaeger_struct.jpg)
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
   - 项目应用原理：![avatar](../../images/jaeger_in_project.jpg)
1. prometheus
   - 认识：SoundCloud的开源的Google BorgMon的监控、告警、时序数据数据库组合的解决方案，适用于容器环境。![avatar](../images/prometheus_struct.webp)
     1. 多维度数据模型
     1. 灵活的查询语言
     1. 不依赖分布式存储，单个服务器节点是自主的
     1. 通过基于HTTP的pull方式采集时序数据
     1. 可以通过中间网关进行时序列数据推送
     1. 通过服务发现或者静态配置来发现目标服务对象
     1. 支持多种多样的图表和界面展示，比如Grafana等
   - 组件
     1. Client Library：客户端组合metrics并暴露给Push Gateway
     1. Push Gateway：支持临时性Job主动推送指标的中间网关
     1. Server：主要负责数据采集和存储，提供PromQL查询语言的支持
     1. Alertmanager：警告管理器，从server接收到alert后，进行去重、分组，并路由对应的接受方式，发出报警
     1. Exporter：暴露已有的第三方服务给server
     1. instance：一个单独监控的目标，一般是一个进程
     1. jobs：一组同类型的instances
   - metric类型
     1. counter：累加，如请求的个数、出现的错误数
     1. gauge：任意加减
     1. histogram：可对观察结果采样、分组、统计，如柱状图
     1. summary：提供观测值的count、sum功能，如请求持续时间
   - 原理：Prometheus的基本原理是通过HTTP协议周期性抓取被监控组件的状态，任意组件只要提供对应的HTTP接口就可以接入监控。不需要任何SDK或者其他的集成过程。这样做非常适合做虚拟化环境监控系统，比如VM、Docker、Kubernetes等。输出被监控组件信息的HTTP接口被叫做exporter 。目前互联网公司常用的组件大部分都有exporter可以直接使用，比如Varnish、Haproxy、Nginx、MySQL、Linux系统信息(包括磁盘、内存、CPU、网络等等)
   - 服务过程
     1. Prometheus Daemon负责定时去配置好的jobs/exporter/pushgateway抓取metrics(指标)数据，每个抓取目标需要暴露一个http服务的接口给它定时抓取。Prometheus支持通过配置文件、文本文件、Zookeeper、Consul、DNS SRV Lookup等方式指定抓取目标。Prometheus采用PULL的方式进行监控，即服务器可以直接通过目标PULL数据或者间接地通过中间网关来Push数据
     1. Prometheus在本地存储抓取的所有数据，并通过一定规则进行清理和整理数据，并把得到的结果存储到新的时间序列中
     1. Prometheus通过PromQL和其他API可视化地展示收集的数据。Prometheus支持很多方式的图表可视化，例如Grafana、自带的Promdash以及自身提供的模版引擎等等。Prometheus还提供HTTP API的查询方式，自定义所需要的输出
     1. PushGateway支持Client主动推送metrics到PushGateway，而Prometheus只是定时去Gateway上抓取数据
     1. Alertmanager是独立于Prometheus的一个组件，可以支持Prometheus的查询语句，提供十分灵活的报警方式
   - PromQL：时间序列数据查询语音
### IM设计
1. 认知
   - 消息是广义的，还存在用户看不见的各种指令和通知，如进群退群通知、好友添加通知等
   - 和普通的api不同，im聊天记录落在用户本地，为的是减少对服务端的查询压力，在需要消息同步的时候才通信
1. 功能点
   - 可靠性：不重、不丢、及时触达，是消息系统的核心指标
     1. 发送失败，对于这种情况IM系统必须要感知到，明确反馈发送方。如果此消息没有发送成功，发送方可以选择重试或者稍后再试
   - 有序性
   - 实时性
     1. 客户端重连机制，消息如何补齐
     1. 如果接收方处在“在线”状态，应该立即收到此消息。如果接收方处在“离线”状态不能收到消息，一旦上线则立刻收到消息。
   - 扩展性：一切皆消息的消息模型
     1. 聊天类型：单聊、群聊、大群
     1. 消息类型：文本、图片、视频、地理位置、自定义消息等
     1. 消息功能：已读未读、撤回、在线状态、对方正在输入、阅后即焚等
     1. 通知角度：进群、退群、添加好友、验证好友等各种通知
#### 技术点
1. 推送、拉取
   - 认识
     1. 推模式
        - 可保证消息的实时性
        - 伪在线丢数据：长连接断开一个心跳周期后服务端才能感知，这时服务端会错误地以为用户还在线，造成数据无法到达，可用消息seq解决拉消息的问题
     1. 拉模式
        - 一般用于获取历史消息
     1. 推拉结合模式：服务端有推，客户端有拉
        - 最好用写扩散，因为写扩散只需拉一条时间线的个人信箱就好了，而读扩散有N条时间线（每个信箱一条），如果也定时拉取的话性能会很差
   - 场景
     1. 系统通知
     1. 状态同步
     1. 网页消息
     1. 群已读回执
1. 扩散读、扩散写
   - 认识：没有完美的解决方案，只有最合适的解决方案，各有取舍
     1. 扩散读：存储一次，所有人读一份，每条消息只存一份，群聊成员都读取同一份数据
        - 优点
          1. 数据实时性高
          1. 写入逻辑简单
          1. 节约存储空间
        - 缺点
          1. 其他业务场景需要保存配套数据，如需要维护离线群成员与未读消息的关系
          1. 数据量大：数据热点问题
     1. 扩散写：每人写一份，各自读。每条消息存多份，每个群聊成员在自己的存储都有一份
        - 优点
          1. 控制逻辑与数据读取逻辑简单
          1. 用户数据独立，满足更多的业务场景，比如：回执消息、云端删除等等
          1. 一个数据点丢失，不影响其他用户的数据点
        - 缺点
          1. 增加存储空间
          1. 数据量大：数据实时性差，需要引入队列
     1. 公共信箱：当需要给1亿人通知时，扩散写数据量太多，扩散读大家不在一个频道需要自定义。方案为：公共信箱 + 个人信箱timeline组合，公共信箱用服务器内存作缓存防大流量
   - 场景
     1. 群消息
     1. feed流
1. 递增的消息ID
   - 方式
     1. 连续递增
     1. 单调递增：不需要连续
   - 类型
     1. 全局递增
     1. 用户级别递增
     1. 会话级别递增
   - 场景
     1. 写扩散：信箱时间线ID使用用户级别递增，消息ID全局递增，此时只要保证单调递增就可以了
     1. 读扩散：消息ID可以使用会话级别递增并且最好是连续递增
1. 企业微信的四维关系链
   - 一维关系链：链式结构，单个节点和节点的连接，即好友关系，可以用一张大网把所有人连接起来
   - 二维关系链：组织结构，在一维关系链的基础上，额外增加组织的关系，形成多层树状抽象
   - 三维关系链：属性抽象，在二维基础上引入属性与操作权限的概念，把组织也看做属性的一种
     1. 互联企业：创建圈子概念，在同一个圈子中的员工，拥有相同的属性，例如互相可见，互相可通信，用以实现多个企业之间的部分人沟通
     1. 集团架构：在圈子基础上增加对操作权限进行方向控制的等级属性，就实现了从属关系，如高等级单位可以见下级单位，下级单位不可见高级单位
   - 四维关系链：跨领域，连接两个领域的数据，抽象一个更高的id系统
     1. 不同的低层系统记录同一个高层系统的id，高层系统把所有底层系统的id也都记录，实现联合，![](../images/common/ww_we_how_id_connect.png)
#### 最佳实践
1. 如何保证消息的可靠性
1. 如何保证消息的实时性
   - 假如我们推送的时候使用MQ去处理并推送一个万人群的消息，推送一个人需要2ms，那么推完一万人需要20s，那么后面的消息就阻塞了20s。把每一个环节的吞吐量评估好了，才能保证消息推送的实时性
1. 如何保证消息时序
   - 可能乱序场景
     1. 使用http不使用ws做消息连接
     1. 前端根据seq显示时：可以通过在用户切换窗口的时候再进行重排来解决，接收方每次收到消息都先往最后面追加
     1. 按to_user_id进行Sharding：使用该策略如果需要做多端同步的话发送方多个端进行同步可能会乱序，因为不同队列的处理速度可能会不一样。可以使用from_user_id
1. 如何确认用户在线状态
   - heartbeat
1. 多端同步怎么做
   - 读扩散：前端收到推的消息如果发现消息ID不连续就请求后端重新获取消息。但这样仍然可能丢失会话的最后一条消息。可在历史会话列表的会话里再带上最后一条消息的ID，前端在收到新消息的时候会先拉取最新的会话列表，然后判断会话的最后一条消息是否存在，如果不存在，消息就可能丢失了，前端需要再拉一次会话的消息列表。这样请求量大，最好将历史会话列表存到开了AOF（用RDB的话可能会丢数据）的Redis
   - 写扩散：多端同步就简单了，前端只需要记录最后同步的位点，同步的时候带上同步位点，然后服务器就将该位点后面的数据全部返回给前端，前端更新同步位点就可以
1. 如何处理未读数
   - 读扩散：将会话未读数跟总未读数都存在后端，使用redis事务。需要保证会话未读数跟总未读数都在同一个Redis节点
   - 写扩散来说，服务端通常会弱化会话的概念，即服务端不存储历史会话列表，前端计算未读数。标记已读跟标记未读可以只记录一个事件到信箱里，各个端通过重放该事件的形式来处理会话未读数，如微信
     1. 如果写扩散也通过历史会话列表来存储未读数的话那用户时间线服务跟会话服务紧耦合，这个时候需要保证原子性跟一致性的话那就只能使用分布式事务了，会大大降低系统的性能
1. 如何存储历史消息
   - 读扩散：按会话ID进行Sharding存储一份即可
   - 写扩散：需要存两份：一份以用户为Timeline的消息列表，一份以会话为Timeline的消息列表。分别以用户ID、会话ID做Sharding
1. 如何数据冷热分离
   - HWC架构：Hot-Warm-Cold。刚发送的消息放到Hot存储系统（可用Redis）跟Warm存储系统，然后由Store Scheduler根据一定的规则定时将冷数据迁移到Cold存储系统。获取消息的时候需要依次访问Hot、Warm跟Cold存储系统，由Store Service整合数据返回给IM Service
1. 接入层怎么做
   - 添加lvs等4层负载均衡，以备扩容缩容
   - 添加长连接ip调度服务做先导，增加灰度策略、就近原则、最少连接数等灵活性
#### Open-IM
1. IM设计
   - 一切皆消息的消息模型
   - 写扩散 + 推拉结合：解决基础问题
   - 写扩散跟读扩散结合：解决大群问题
1. 实现设计
   - 服务端架构：由接入层、逻辑层和存储层组成
     1. 接入层：消息通过 websocket 协议接入，其他通过 http/https 协议接入，消息是高频及核心功能，通过双协议路由，体现了轻重分离的设计思想。
     1. 逻辑层：通过 rpc 实现无状态逻辑服务，易于平行扩展，消息通过 MQ 解耦。
     1. 存储层：redis 存储 token 和 seq；mongodb 存储离线消息，并定时删除 14 天（可自行配置）前数据；mysql 存储全量历史消息以及用户相关资料。数据分层存储，充分利用不同存储组件的特性
     1. Etcd：服务注册和发现、以及分布式配置中心
   - 消息架构：消息模型采用经典的收件箱模型，并通过全局 seq 做消息对齐
     1. msg gateway：收发消息，服务模块无状态，柔性伸缩
        - 功能
          1. 负责用户连接管理，保持长连接，存储uid->conn映射关系
          1. 负责把消息推送给在线状态的接收者
             - 做成了“半状态”服务，即在节点本地存储了用户连接信息，没有redis全局共享。push推送消息时向所有msg_gateway发送推送请求，带来一定“惊群效应”，由于msg_gateway节点不多，所以影响有限，带来的好处则是在不影响性能的前提下，msg_gateway设计和实现简单，运维也更简单
        - 组成
          1. producer：给msg trasfer生产消息
          1. sender：发送在线消息
          1. msg sync
     1. msg trasfer
        - 关联seq和msg，并以receiverUserid为key存储到mongodb
        - 全量历史消息无收件箱概念，消息作为流水记录落地mysql即可
        - msg作为无状态服务节点，如果消息量增加，可以启动冗余节点服务，加快消息处理流程
     1. pusher
        - third party services：发送离线消息
     1. storage
        - redis：seq token
        - mongodb：offline message
        - musal：persistent message
   - 客户端架构
     1. 认识：Open-IMSDK，客户端SDK负责和IM服务端交互，本地数据存储和同步，消息、事件回调。开发者通过集成SDK，自行开发聊天界面UI，设置事件监听回调实现数据和UI对接
        - 采用golang实现客户端逻辑，主要负责
          1. 本地消息/会话等db数据存储及更新
          1. 消息及各种通知的回调。通过通知机制完成本地数据实时同步，同时兼顾客户端缓存的作用，有效缓解了服务端压力
          1. 断网重连及管理
        - 利用golang跨平台特性
     1. 组成
        - 网络层：ws goroutine，负责和服务端保持ws连接、断网重连、接收消息推送，确保在线时消息及各种事件实时达到。负责初始登录和重连时数据补齐，通过对比本地seq和服务端最大seq同步拉取差值消息或事件，确保客户端和服务端达到最终一致的状态
        - 逻辑层：针对主动调用接口和事件被动触发，对接网络层和存储层，实现业务细节，根据逻辑完成与UI之间的回调。如发送消息，SDK为UI提供发送消息及回调接口，逻辑层调用存储层存储本地消息，调用网络层发送消息，成功或失败回调 UI，并触发会话改变回调。同样接收消息或事件，网络层把消息或事件传给逻辑层，逻辑层根据消息或事件的类型做相应处理，比如存储本地消息，触发会话改变回调等
          1. sdk listener goroutine
          1. sdk callback goroutine
        - 存储层：集成sqlite轻量级数据库，完成本地和服务端的数据同步，包括会话、消息、事件、通讯录、群组等，对外提供的数据 get 接口，通过本地数据库获取，实现了无网络情况下能查看消息等本地数据，同时也能有效缓解服务端的压力，达到了数据同步和缓存的双重目的
   - 组件作用
     1. mysql：后台持久化全量历史消息以及用户相关资料
     1. redis：存储 token 和 seq
     1. es
     1. mongodb：存储离线消息，并定时删除14天内
     1. kafka
        - ws2ms_chat：异步mongo和mysql保存消息
        - msg_to_mongo
        - ms2ps_chat
     1. etcd：服务注册和发现、分布式配置中心
   - rtc微服务
     1. 房间管理
     1. 信令控制
     1. 会议模式
     1. 音频3A
     1. 拥塞控制
     1. 回声消除
     1. 噪声控制
     1. 自动增益
1. 技术点
   - 消息同步及对齐seq
     1. 客户端接收推送消息时：local seq非递增小于则server seq则丢失拉取，大于则重复抛弃
     1. 用户在登录、或者断网重连时
        - 拉取最大seq
        - 调用接口同步自身收件箱的数据完成消息对齐
1. 应用
   - 客户端原理
     1. election如何集成im sdk？go生成exe可执行文件(或mac的可执行文件)，election直接同步启动并管理进程即可
     1. ios、android如何集成im sdk？gomobile生成对应的android arr和jar包，或者xcframework文件，导入项目即可
     1. web如何集成im sdk？之前是单独部署到服务器中，利用wasm本地聊天记录存储在浏览器，彻底放弃之前jssdk server服务端
        - 借助sql.js（同样使用emscripten将SQLite编译为webassembly）和IndexedDB在Web环境中增加了消息本地存储能力，这使得SDK整体使用更加高效
#### Feed流
1. 实现方案
   - 读扩散：也称为拉模式，最符合我们直觉的一种实现方式，即去关注者的收件箱主动拉取帖子
     1. 原理：粉丝来阅读时，系统首先需要拿到粉丝关注的所有人，然后遍历所有发布者的发件箱，取出他们所发布的帖子，然后依据发布时间排序，展示给阅读者
     1. 认识
        - 实现简单
        - 读操作会非常重：读一次Feed流，后台会扩散为N次读操作，N等于关注的人数。遍历关注的所有人并且再聚合
        - 深分页问题，不断向下滑动越来越慢
   - 写扩散：也称为“推模式”，大多数Feed流产品的读写比大概在100:1，因此读扩散那种很重的读逻辑并不适合大多数场景
     1. 原理：每次发表帖子，都会扩散为M次写操作（M等于自己的粉丝数），后台起异步任务不慌不忙地往粉丝收件箱投递帖子
     1. 认识
        - 适用于粉丝量不大的情况，如微信限制好友5000人，微博限制2000个关注人
   - 读写混合模式：比较一下读扩散与写扩散的优缺点，不难发现两者适用场景是互补的。因此在设计后台存储时，如果能区分一下场景，在不同场景下选择最适合的方案，并且动态调整策略，就实现了读写混合模式
     1. 原理：当粉丝量超多的大V发帖时，将帖子写入大V的发件箱，提取出一批大V活跃粉丝，将大V的帖子写入他们的收件箱。粉丝量小的账号还是写入所有粉丝收件箱
        - 区分是否活跃粉丝：筛选掉大部分其他人，并给活跃粉丝推帖子，保证活跃用户的体验
        - 非活跃用户突然登录刷feed流时，一方面需读他的收件箱，另一方面需遍历他所关注的大V的发件箱提取帖子，并且做聚合展示。同时判断是否升级为活跃用户
        - 区分是否大V：在系统发展过程中动态地识别和调整，项目规模发展到一定程度时才可用
1. 分页偏移问题
   - 认识：拉取时有帖子新增，对第n页的读取产生偏移影响。不使用page_size和page_num，使用last_id和page_size
1. 内容排序
   - 认识：受到状态、属性影响排序，如根据时间判断的状态流转(预告中、直播中、回放)、广告接入、特别关注、热点话题等，时间变化要对排序做出变化
   - 解决方案：构建数据快照，满足当下查询
     1. 基于状态流转是否结束，来确定扩散方式，“直播中”与“预告中”没结束采用读扩散，“回放”已结束采取写扩散
#### 协同编辑
1. 解决方案的效果：可以看到协作者列表以及每个协作者的正在输入的位置，实时看到他们输入了什么内容，我们甚至可以直接相互对话，这种方式可以有效避免冲突
1. 思想：系统自身不需要保证是正确的，它只需要保持协同各方一致，并且努力保持协同各方的意图
   - 协同编辑的冲突处理不一定是完全正确的，因为冲突本来就意味着操作是互斥的，互斥双方的操作意图不可能完全保留
   - 冲突处理最重要的是保证协同双方最终数据的一致性，然后在这个基础上努力保持各自的操作意图
1. 技术背景
   - 富文本数据模型：数据的修改都可以由在网络中传输的操作对象表达，实现基于操作的内容更新，是协同编辑的一个基础
     1. 2012年：Quill编辑器->Delta模型，定义三种操作（insert、retain、delete），编辑器产生的每一个操作记录都保存了对应的操作数据，操作列表即最终的结果
        ```json
        // 输出加粗的Hello Quill!
        {
            "ops": [
                {
                    "insert": "Hello "
                }
                {
                    "attributes": {
                       "bold": true
                    },
                    "insert": "Quill"
                },
                {
                    "insert": "!"
                }
            ]
        }
        ```
     1. 2016年：Slate -> JSON
        ```json
        // 表示放了一张图
        [
            {
                "type": "image",
                "children": [
                    {
                        "text": "",
                    }
                ],
                "width": 385,
                "height": 590,
                "thumbUrl": "https://atlas.pingcode.com/files/public/xxx",
                "originUrl": "https://atlas.pingcode.com/files/public//origin-url",
                "align": "center"
            }
        ]

        // 属性修改操作
        [
            {
                "type": "set_node"
                "path": [
                    0
                ],
                "properties": {
                    "align": "center"
                },
                "newProperties": {
                    "align": "right"
                ｝
            }
        ]
        ```
   - 面临的问题
     1. 技术/学术问题：数据一致性问题、要保证最终数据的一致性
        - 脏路径：别人的修改污染索引等路径数据，导致同步时数据找不到正确落脚点而错误
        - 并发冲突：多方基于相同的位置修改了相同的属性
        - undos/redos：脏路径 + 并发冲突
          1. 撤回应当只撤回自己的操作，协同者的操作应当被忽略
     1. 落地的具体问题/工程问题
        - 操作的同步
        - 光标的同步
        - 网络不可知（网络抖动、网络延时、消息重连以及重连后的各种情况处理）
        - 文档版本历史
        - 离线编辑
1. 数据一致性问题方案
   - OT 算法
     1. 认识：操作变换 Operational Transformation，最主要的技术选择，石墨/钉钉/腾讯文档/Office 365/Google docs使用，1989年提出的协同冲突处理算法
     1. 核心思想：对用户协同编辑中产生的并发操作(冲突/脏路径)进行转换，修正后的操作重新应用到文档中，保证操作的正确性和最终数据一致性
        - 即比如两边用户从同一个起点分别应用操作a和b后，两边的文档内容都发生变化，且不一致；对a和b进行操作转换transfrom(a, b) => (a', b')得到两个衍生的操作作a'和b'，使其达到一致
        - 转换过程并没有太复杂，真实场景需要对每一种操作类型做交叉操作转换，如Delta支持三种操作，就需要3*3次种操作变换
     1. 操作举例
        - 解决脏路径：判断对方操作路径索引是否小于本地操作路径索引，如果小于就直接操作，如果大于则将对方操作路径索引加上本地操作的索引作为新操作路径索引，对方反之亦然，只不过操作路径索引是反过来，即本地的操作是对方的远端操作，对方的操作是本地的远端操作
        - 解决并发冲突：按照谁后到服务端，补偿将之前的给覆盖掉
        - 解决undso/redos：对undo栈、redo栈中的所有操作循环执行操作转换逻辑
     1. 最佳实践
        - 只需要把本地所产生的operations提交给协同引擎，并由协同引擎通过OT算法处理本地以及服务端发来的operations冲突，最后以处理后的operations驱动模型更新，即可实现协同编辑效果
   - CRDT 算法
     1. 认识：无冲突复制数据类型
        - CRDT数据满足交换性和幂等性：最初为解决分布式系统最终数据一致性而提出，支持各个主机副本之间数据修改的直接同步，而且数据修改的同步顺序以及同步的次数不影响最终结果，保证分布式应用的数据一致性
        - 文档协同编辑可以理解为分布式应用的一种，其本质也是数据结构，通过数据结构的设计保证并发操作数据的最终一致性
        - 2011年正式提出，基于CRDT的协同编辑框架Yjs在2015年开源，Yjs是专门为在web上构建协同应用程序而设计的
     1. 核心思想：为文档中每个字符分配一个唯一的标识符，即使在删除字符时也会保留元数据
        - 支持点对点传输的冲突处理模型
        - 它的插入操作是基于已有字符的相对位置，在OT中使用的相当于是基于索引的绝对位置。然后就是CRDT冲突的处理，主要是比较用户标识符，标识符小的先应用，标识符大的后应用
        - 用唯一标识代替从0开始步长为1的索引
        - 使用双向链表的数据结构来实现
     1. 操作举例
        - 解决并发冲突：如从一个起点140开始，各自产生了141和142两个新的双向链表的节点，比较后142放在141的后边，不仅可以描述最终的数据状态，还可以表达数据修改的顺序
          1. 示意图：win是最终的数据结构，内容从center各自产生left和right的变化，图中演示了其演变过程，![](../images/common/CDRT-demo.png)
        - 解决脏路径：完全没有这个问题，并发冲突问题也完全可以基于CRDT的标识符（时间戳）去解决
        - 解决undso/redos：只需要根据CRDT的数据结构的新增或者删除实现undos/redos栈就可以有效解决问题，如生成后撤回时就可把它标记删除
     1. 最佳实践
        - 与OT不同，CRDT是一种全新的解决方案，它不要求编辑器的实现方式，对于任何的编辑器数据模型都可以使用一套CRDT数据结构去处理冲突，也是因为数据结构的性质，它也可以不依赖中心化的服务器，而且稳定性非常高，这区别于OT，OT可以理解为是通过算法控制保证数据一致性，CRDT通过数据结构设计保证数据一致性，它在复杂的网络环境中的处理是更稳健的，CRDT的代价就是要保存更多的元数据，这会带来一定内存消耗，但是这是可优化的，事实证明这个代价在协同编辑场景是完全可忽略不计的
1. 开源落地方案
   - 基于 OT 的 ShareDB 方案：2013年开源代表着基于 OT 的一套完整解决方案的落地
   - 基于 CRDT 的 Yjs 方案
     1. 2015年开源代表着基于 CRDT 的协同方案正式得到发展
     1. 2020年slate-yjs开源，是Yjs和Slate的结合，有了一个基于Slate的完整协同方案
### 全局唯一ID
1. 最佳实践
   - 问题
     1. 生成的ID太长，索引效率不高
        - uuid和雪花都太长，uuid是128bit的string类型，雪花是64bit的int64类型
     1. ID要趋势递增，但不想连续给业务数据带来安全风险
        - uuid不可以，雪花可以
     1. 瞬时并发量不够，雪花算法一毫秒内一个节点才能生成4096个ID
     1. 不能解决时间回拨问题
     1. 不支持后补生成前序ID
     1. 可能依赖外部存储系统
     1. 系统运行100年以上
   - 高性能id生成器实现方式
     1. 增加多个发号器：发号器即占用不同号段，多个同时使用增加并发能力
     1. 节点水平复制提升并发能力
     1. 提前存储id，直接用
1. yitter/IdGenerator
   - 认识：多语言实现的高性能生成唯一数字id的优化的雪花漂移算法
     1. 整形数字，随时间单调递增（不一定连续），长度更短，默认用50年都不会超过js Number类型最大值
     1. 速度更快，是传统雪花算法的2-5倍，基于8代低压i7并发处理能力50W/0.1s
     1. 支持时间回拨处理。比如服务器时间回拨1秒，本算法能自动适应生成临界时间的唯一ID
     1. 支持后补生成前序id/手工插入新id。当业务需要在历史时间生成新ID时，用本算法的预留位能生成5000个每秒
     1. 不依赖任何外部缓存和数据库。（k8s环境下自动注册 WorkerId 的动态库依赖 redis）
     1. 容器环境部署支持水平复制、自动扩容（自动注册WorkerId），单机或分布式唯一IdGenerator，默认最多支持64个节点

     1. 多语言支持，提供其它适用于其它语言的多线程安全调用动态库（FFI）
     1. 兼容所有雪花算法（号段模式或经典模式，大厂或小厂），将来可做任意的升级切换
     1. 是计算机历史上最全面的雪花ID生成工具。【截至2022年8月】
   - 最佳实践
     1. 增加SeqBitLength会让性能更高，但生成的id会更长
1. UUID
   - 认识：通用唯一标识符，128bit的string类型，一般用十六进制。为保证唯一性，规范定义了包括网卡MAC地址、时间戳、名字空（Namespace）、随机或伪随机数、时序等元素，以及从这些元素生成的算法，可实现全球唯一
   - 优点
     1. 生成简单，无网络消耗，可以唯一
   - 缺点
     1. 太长了，存了数据库性能低
     1. 没有排序，无法按序递增
     1. 内容没有意义
   - 版本
     1. 版本1：基于时间戳和mac地址，容易被攻击
     1. 版本2：基于时间戳，mac地址和POSIX UID/GID，容易被攻击
     1. 版本3：基于MD5哈希算法
     1. 版本4：基于随机数，最常用
     1. 版本5：基于SHA-1哈希算法
   - 举例
     1. c2b8c2b9e46c47e3b30dca3b0d447718
     1. aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
   - ULID：通用唯一词典分类标识符，既基于时间戳又基于随机数，按字典顺序排序，转换成字符串比UID更加友好，如01ARZ3NDEKTSV4RRFFQ69G5FAV
     1. 时间戳精确到毫秒，毫秒内有1.21e + 24个随机数，不存在冲突的风险
     1. URL安全，不使用任何特殊字符
     1. 不区分大小写和80位随机性是主要缺点
1. 雪花算法
   - 认识：64bit的int64类型，来自twitter的scala编写，正数位(1byte)+ 时间戳(41byte)+ 机器ID(5byte)+ 数据中心(5byte)+ 自增值(12byte)
     1. 正数位：一般为0，正数
     1. 时间戳：毫秒时间戳，不建议存当前时间戳，而是用（当前时间戳 - 固定开始时间戳）的差值，可以使产生的ID从更小的值开始，41位的时间戳可以使用69年
     1. 自增值：支持同一毫秒内同一个节点可以生成4096个ID
   - 特点
     1. 能满足高并发分布式系统环境下ID不重复
     1. 基于时间戳，可以保证基本有序递增，集群时钟不一致可能不是自增
     1. 依赖机器时钟，倒拨可能重复
     1. 不依赖于第三方的库或者中间件
   - 组成
     1. 0～11bit	12bits	序列号，用来对同一个毫秒之内产生不同的ID，可记录4095个
     1. 12～21bit	10bits	10bit用来记录机器ID，总共可以记录1024台机器
     1. 22～62bit	41bits	用来记录时间戳，这里可以记录69年
     1. 63bit	1bit	符号位，不做处理
1. 其他方式
   - 百度uid-generator：基于雪花，支持自定义时间戳、工作机器ID和序列号等各部分的位数。https://github.com/baidu/uid-generator
     1. 需要worker_node表，应用每次启动插入数据的自增id为workId
   - 美团leaf：支持号段模式和雪花模式，https://tech.meituan.com/MT_Leaf.html
     1. 号段：需要leaf_alloc表
     1. 雪花：依赖zk的顺序id作worker_id，
   - 滴滴tinyid：号段模式，https://github.com/didi/tinyid/wiki
     1. 提供http和tinyid-client两种方式接入
   - 数据库自增
     1. mysql步长
        - 简单，单调自增
        - 无法高并发、高可用
     1. mysql号段模式
        - 组成：从数据库批量获取id放入内存。每次申请时，根据乐观锁version更新max_id=max_id + step，更新成功表示申请成功
          1. 建表，max_id记录最大id，step代表每次申请的步长，version乐观锁，biz_type业务类型
        - 特点
          1. 数据库访问频次低，压力小
          1. 性能较好
   - redis原子步长：多台redis设置不同步长，每天重新生成一个id，然后累加获得，实现高可用、负载均衡，性能好，数字ID天然排序
### 登录鉴权
1. 登录和鉴权方式
   - 账号密码
   - MFA：多因素认证，增加基于应用的令牌、指纹
   - SSO
     1. 认识：单点登录，用户的一次登录能得到其他所有系统的信任
        - 共享同一个身份认证系统，也就是说所有站点的身份验证操作在同一个系统下完成
        - 每个子系统从共同的身份认证系统中取得用户凭证，包含用户的身份/权限信息等
     1. 方案
        - 服务端写入持久化共享session（db,nosql等)，集中度高
        - 服务端不保存session，数据由客户端发回服务端，服务端变为无状态，如jwt
     1. 应用协议
        - CAS：Central Authentication Service 中央认证服务，一种开放的易于集成的sso协议，没认证会将用户重定向到cas服务器进行登录后再重定向回去，能够与ldap/数据库等认证机制集成，1998年创建
        - SAML：Security Assertion Markup Language，基于XML的支持sso的开放标准
   - OAuth2.0
     1. 认识：Open Authorization 开放式授权，为解决第三方程序可获取服务器上的用户信息但用户又不用将自己的账号密码告知第三方程序的问题，v1.0有漏洞
     1. 授权方式
        - 授权码（authorization-code）：最常用，最安全。授权码前端传送，令牌存在后端，所有与资源服务器通信都在后端，前后端分离，避免了令牌泄露
          1. 前端交互授权码
          1. 后端和资源服务器交互令牌
        - 隐藏式（implicit）：纯前端模式，称为(授权码)隐藏式，令牌直接给到前端，但是令牌位置是url锚点，不是查询字符串，因为浏览器跳转时锚点不会发到服务器，减少了泄漏令牌的风险
        - 密码式（password）：适用于高度信任的第三方系统，直接用源站的账号密码登录
        - 客户端凭证（client credentials）：纯后端模式，针对第三方应用而不是用户，即有可能多个用户共享同一个令牌
     1. 流程
        - 第三方备案申请
        - 第三方请求令牌
        - 用户输入本方密码，发放令牌
        - 利用令牌访问相应api
        - 令牌更新：颁发令牌时颁发两个，一个获取数据，一个用于获取新的，到期前用refresh token去获取新令牌
1. 解决方案
   - JWT
     1. 认识：JSON Web Token，跨域认证解决方案，服务端签发，客户端发回token进行校验。有官方写法，用base64和hs256
     1. 组成：三者base64压缩，用.连接
        - header：官方声明类型、加密算法
        - playload：放一些无关紧要的东西，签发者、签发时间、过期时间等
        - signature：加密的签名token，用来获取后续的信息
   - ADDS
     1. 认识：Active Directory Domain Service，ad域服务器，利用ldap命名路径（LDAP naming path）来表示对象在ad内的位置，提供查询、修改等服务。ad域内的资源以Object(对象)的形式存在，对象通过属性描述特征，就像电话簿中的一个记录，有姓名、地址等
        - LDAP：Lightweight Directory Access Protocol，轻量级目录访问协议，用来查询、更新Active Directory的目录服务通信协议，可以允许任何程序获得目录和其他信息，类似电话薄
          1. 目录：指一种按照树状结构存储信息的数据库
1. 权限管理
   - ACL：Access Control List 访问控制列表，就是用户直接关联权限，数据分散，不方便集中管理
   - ABAC：Attribute Base Access Control 基于属性的权限控制，通过动态计算n个属性是否满足设置好的逻辑进行授权判断，控制可以更加细粒度
     1. 属性四类：用户属性（如用户年龄），环境属性（如当前时间），操作属性（如读取），对象属性（如一篇文章，又称资源属性）
     1. 配置文件管理
   - RBAC
     1. 认识：基于角色的访问控制，用户通过角色与权限进行关联，即 用户-角色-权限-资源
     1. 表结构
        - ucenter_member：用户表
        - auth_group：组数据表
        - auth_group_access：用户、组关系表
        - auth_rule：权限表，模块+控制器+方法名、名称
1. wiki
   - 令牌和密码
     1. 令牌是短期的，到期会自动失效，用户自己无法修改。密码一般长期有效，用户不修改，就不会发生变化
     1. 令牌可以被数据所有者撤销，会立即失效。密码一般不允许被他人撤销
     1. 令牌有权限范围，密码一般是完整权限
### 阿里云
1. ACK
   - 认识
     1. clb作4层负载均衡将流量引过来指向节点，节点接收网络转给k8s
     1. k8s的路由ingress用nginx做7层负载均衡，指向service
     1. service可以是集群内部的ip，也可以是负载均衡(包括本地和集群两种)
   - 信息
     1. 传统型clb指向虚拟服务器组ecs，是4层的tcp代理，clb的带宽值为5120Mbps
     1. k8s添加service可以添加集群ip ClusterIP和负载均衡
     1. k8s添加路由可以指定Nginx和ALB、MSE等阿里云自身服务
   - service的网络模式：是4层负载均衡
     1. ClusterIP：用于集群内部的应用间访问
     1. NodePort：将集群中部署的应用通过集群节点上的一个固定端口暴露出去，这样在集群外部就可通过节点ip和这个固定端口来访问
     1. LoadBalancer：用了阿里云的负载均衡，比NodePort有更高的可用性和性能。直接就把流量从外边接进来了
   - 网络模型：实现同一个vpc下pod和ecs之间互相能访问
     1. Terway：云原生的基于阿里云的虚拟化网络中的弹性网卡资源直接分配vpc中的ip地址，不需额外指定虚拟pod网段
        - 全平面，便于业务云原生化迁移
        - 不依赖封包或者路由表，分配给容器的网络设备本身可以用来通信
        - 可以直接把容器挂载到SLB后端，无需在节点上使用NodePort进行转发
        - 在使用Alibaba Cloud Linux系统作为节点的操作系统时，Terway网络模式支持使用更高效的IPvlan+eBPF链路，加速容器网络性能
     1. Flannel
        - pod网段独立于vpc的网段。pod网段会按照掩码均匀划分给每个集群中的节点，每个节点上的Pod会从节点上划分的网段中分配IP地址
1. SLB
   - 组成：面向4层的网络型负载均衡NLB、面向7层的应用型负载均衡ALB和传统型负载均衡CLB
     1. 除了传统的是传统型负载均衡按规格售卖，需要根据业务规模预估带宽峰值，其他二者都是网络型负载均衡处理能力随业务规模自动弹性伸缩，无需进行峰值与规格预估
     1. 传统和应用型的、以及EIP，都可以直接作为ingress网关使用，传统的是load balancer，alb是ingress。他们都经过Container Scheduling and Orchestration容器调度和编排
   - 传统型负载均衡CLB
     1. 认识：就是个网关，把请求转发到ecs上，基于物理机架构，单实例最大支持100万并发、5万QPS，支持云原生与阿里云ACK/ASK等容器服务结合使用
        - 网站/系统同地域、跨地域容灾高可靠负载均衡场景
        - 四层流量大并发业务负载均衡场景
     1. 功能
        - 路由转发：支持tcp、udp、http、https协议
        - 调度
          1. 算法：加权轮询(WRR)、轮询(RR)、一致性哈希(CH)
             - 一致性哈希(CH)算法：根据不同的哈希因子将访问请求均匀的分配到后端服务器，并在后端服务器个数发生变化时，依然保持均匀分配
          1. http的支持指定域名url路由转发
        - 健康检查、单点故障后端排除、抗DDoS
     1. 特性
        - 提供最大带宽
        - 会话保持：tcp协议将同一ip地址的请求转发到同一台后端云服务器处理
        - 超时时间
          1. tcp超时时间设置：30秒，超时自动断开
          1. 连接空闲超时时间
          1. 连接请求超时时间：60秒，即接口响应时间
        - 其他
          1. Gzip数据压缩
          1. 附加HTTP头字段
   - 网络型负载均衡NLB：聚焦TCP、UDP和TCPSSL协议，单实例最大支持1亿并发连接，支持云原生业务场景
     1. 四层大流量高并发业务场景
     1. 物联网、车联网等IoT业务入口
     1. 多活容灾、IDC云上出入口场景
   - 应用型负载均衡ALB：丰富的7层高级路由功能，聚焦HTTP、HTTPS和QUIC应用层协议，官方云原生Ingress网关，支持流量拆分、镜像、灰度发布和蓝绿测试的负载均衡能力
     1. 互联网应用7层高性能自动弹性负载均衡场景
     1. 音视频应用大流量低时延负载均衡场景
     1. 云原生应用金丝雀蓝绿发布负载均衡场景
1. 网络
   - 认识：vpc是给一堆服务器打通网络用的，cen是给北京和美西、自建IDC之间打通用的
   - 分类
     1. NAT网关：提供公网NAT和私网NAT两种功能，就是常规的NAT服务，用于网络联通
        - 公网NAT网关通过自定义SNAT、DNAT规则可为云上服务器提供对外公网服务及主动访问公网能力
        - 私网NAT网关(也即VPC NAT网关)可使VPC内的ECS实例通过私网地址转换服务，实现VPC与VPC之间、及VPC与线下IDC互访能力
     1. 智能接入网关：SDWAN的云计算边缘访问和接入的服务。可实现Internet就近加密接入，更智能、更可靠、更安全。主要是就近

     1. VPC：Virtual Private Cloud 虚拟专有网络，用于构建逻辑隔离的云上数据中心，由逻辑网络设备（如虚拟路由器，虚拟交换机）组成，可以通过专线/VPN等连接方式与传统数据中心组成一个按需定制的网络环境，实现应用的平滑迁移上云
        - 组成：每个VPC都由一个路由器、至少一个私网网段和至少一个交换机
     1. VPN网关：通过加密通道将企业数据中心、办公网或终端与专有网络（VPC）安全可靠连接起来的服务。支持IPsec VPN、SSL VPN及国密算法等能力，满足分支互联、移动办公等接入场景，主要是加密

     1. 云企业网CEN：能快速构建混合云和分布式业务系统的全球网络服务，企业级规模和通信能力云上网络。适用于集团企业、全球网络等场景
        - 功能有大规模灵活组网、网络资源互通、路由自动学习和分发、带宽共享与自主管理
        - 腾讯云叫云联网
