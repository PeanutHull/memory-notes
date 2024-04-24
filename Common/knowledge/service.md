### 架构
1. 服务治理
   - 高负载/高并发
     1. 集群，负载均衡
     1. 服务发现、弹性扩容
     1. 动态路由、虚拟VIP
   - 高可用
     1. 监控、日志、安全
     1. 限流、熔断、降级、故障转移
     1. 热备、冷备、双活(多活/两地三中心)
1. 技术方案
   - 持久化：
     1. 主从、读写分离、中间件：数据库集群(自己造数据，自己测试性能)
     1. 三副本数据冗余：数据一致性
   - 缓存：redis
   - 队列：kafka
   - 搜索：elasticssearch
1. 高并发
   - 方案
     1. 宏观
        - 服务：集群、负载均衡
        - 业务：业务分离、微服务调用
        - 缓存：热点数据缓存
        - 压测
     1. 微观
        - nginx压缩，浏览器缓存，CDN独立文件存储
        - 减少http请求，页面静态化，业务异步处理
   - 指标
     1. qps：Queries Per Second，每秒处理完的请求量，总完成请求数/平均响应时间
     1. tps：Transactions Per Second，每秒处理事务数，可能包含多个qps
     1. rt：响应时间，请求发出到响应的时间
     1. pv：page view，综合点击量，在24小时内访问的不同页面的数量，访问一次页面算一次
     1. uv：Unique Visitor，独立访客数，一定时间内一个访客多次访问网站只算一个UV
     1. 带宽：计算带宽需要峰值流量和页面平均大小
   - 最佳实践
     1. 1M宽带指1Mbps，即兆比特每秒，除以8就是KB每秒，MB/S是Mbps的8倍，再扣12%的信息头标识等各种控制讯号，上限为112KB/s
     1. 当QPS为2000，文件系统的访问锁成了灾难，做业务分离等
1. 高负载
   - 服务器方面
     1. cpu负载
     1. 内存消耗
     1. 磁盘io用量
     1. 网络带宽负载
   - 程序方面
     1. 执行效率
   - 中间件：数据库、队列等
     1. 主从分离、读写分离
     1. 分库分表
1. 最佳实践
   - 架构设计思路
     1. 海量请求————限流————队列(削峰填谷)————缓存————关系型数据库
     1. 超级海量请求————非关系型数据库以及相关技术(PB级、日处理上亿，因为关系型的存储大量无效数据)
   - 技术方案的确认方法
     1. 明确目标：性能要求，扩展性要求(技术层面、业务层面)，接口标准等
     1. 确定影响范围：上下游业务影响范围、测试范围
     1. 确认实现方案：关键技术点、稳定性
   - 业务流程发生错误如何处理
     1. 直接报警停止，缺陷是已经造成了数据错误，影响了业务，同时人工介入手动补救太慢，无法处理只是一时的抖动引发的问题
     1. 记录一个错误数据表，定时扫表重试处理，或者加入延迟队列但是无法直观查看。问题就是在冗长的业务处理流程中无法从中途启动，即如果中间出错但是要完整走一遍业务流程，可能造成数据重复处理。如mysql成功了，之后的redis失败但是mysql还得再插入一次导致数据重复。案例是测试环境和预发环境的redis版本不同，使用了不兼容的语法导致中途失败，原则就是做幂等，但是不能做成一个大事务，比如mysql的事务不能包括写redis、写kafka等一大堆
        - 解决方案就是改进代码写法，逻辑拆成一个个独立的函数，在某处发生错误停止时，记录停止位置的函数，下次执行时判断是否有执行流程点，有就跳过已经执行的，可以使用责任链模式
     1. 业务查询处，加兜底逻辑补救缺失的非必要数据，来配合处理流程发生错误导致的问题
### 技术平台
1. wiki
   - C10K的并发问题引入epoll解决。随后又有了C10M使用协程
   - 横向扩展、纵向扩展：横向加机器，纵向加内存等
   - 分布式
     1. 认识：无传统概念上的中心节点，松耦合、无状态、伸缩性、冗余性
        - 系统容量如内存、磁盘无上限
        - 可用性强，允许部分节点宕机
   - 集群
     1. 认识：cluster，一组节点作为一个整体集中在一起提供服务。集群不一定是分布式的
        - 处理能力提升
        - 可扩展性
        - 高可用性
   - 部署模式
     1. 蓝绿：同时维护两个线上环境，只有一个对外提供服务，有问题就切回来
     1. 金丝雀：一套，不断翻量，向少数用户(金丝雀用户)发布新版本，观察运行情况和反馈，没问题再全量
   - set化架构：即单元化架构，异地多活，有备的会浪费资源，类似微服务优先自身
     1. 每个集群只负责本单元流量处理和存储，之后做双向数据同步，实现容灾切换需求
   - 混沌工程：通过应用一些经验探索的原则，来学习观察弹性系统是如何反应的，主动发现问题
     1. 通过实践对系统有更新的认知
     1. 方法如模拟整个IDC当掉、选择一部分网络连连接注入特定时间的延迟、随机让一些函数抛出异常、榨干cpu
#### 高可用
1. 方案
   - 日志、监控
   - 限流、熔断、降级
   - 冗余
   - 自动故障转移、故障节点自动摘除
   - 故障演练：经常进行，包括风险应对方案、执行人、演练效果记录、是否通过等。![avatar](../images/service_fire.png)
1. 冗余
   - 冷备
   - 热备
   - 双活、多活
     1. 实现方式：流量隔离、数据同步
     1. 异地多活特点
        - 本地强一致
        - 异地最终一致
1. 故障转移
   - 组成
     1. 故障检测
     1. 故障转移
        - dns方式：可以不设置缓存，但是有50毫秒的更新延迟，即最少造成50毫秒服务中断
        - vip方式：只能按照ip漂移，不能按照端口，一台物理机多个redis就会都飘走
   - 步骤
     1. 身份切换
     1. 接管职权
     1. 广而告之
     1. 履行义务
1. db/redis的高可用方式
     1. 加入代理层，包一层后边的db服务
     1. 服务本身高可用：主从配置、副本配置、分片配置，故障节点自动摘除
#### 网校服务和架构梳理
1. 架构组成
   - 服务链路：lvs+keepalived -> openresty -> vanrish -> server
     1. openresty
        - 划分为接入端、API端：HA、API
        - 使用upstream区分各个服务
     1. server
        - php+nginx
          1. php扩展、ini参数
        - supervisor
        - etcd+confd、confd-tw
   - 日志收集：php、nginx
     1. filebeat
        - basiclog.xesv5.com
        - mao.xesv5.com
   - 监控体系
     1. 技术方案
        - flcon-agent
        - grafana
     1. 监控范围
        - 网关监控
        - k8s物理机
     1. 访问平台
        - xesfalcon.xesv5.com
        - datamap.xesv5.com
   - CICD(发布系统)
     1. rsync方式同步代码
1. 现状
   - 体量：eci 1万台以上
   - 网络
     1. vpc
        - vpc未打通比例55%，使用阿里云的云企业网打通vpc，全集团一张大网
        - 集团内需要走专线，各个vpc又有nat、bgp
     1. 北京的南北机房建设
1. 多活实践
   - 遇到的问题
	 1. 系统性单点：BGP、网关、DCDN、CDN
        - 虽然nginx是集群，但是是同一个slb
   - 实现方案
	 1. 网关：相互解耦
### 服务可用性治理
#### 接口
1. 指标
   - qps：调用量
   - 响应时长：服务响应时间与分布
     1. 最大、最小
     1. 均值/中位值：平均响应时长，总和除以数量
     1. P95值：时长从小到大排列，顺序在95%处的值，反应95%的用户的响应时长小于P95
     1. P99值
   - 成功率：错误统计
     1. 4xx、5xx
   - 机器负载
     1. cpu
     1. 内存
     1. 硬盘
     1. 网络
   - 资源依赖负载
     1. redis、mysql
1. 最佳实践
   - 自身了解
     1. 分类
     1. 调用方分布、调用方式、调用速率、调用高峰和分布
   - 维护
     1. 报错数
     1. 慢接口top
     1. 高流量top
1. 设计
   - 防重设计：避免产生重复数据，对接口返回没有太多要求
   - 幂等设计
     1. 认识：多次执行所产生的影响均与一次执行的影响相同
        - 场景
          1. 天然幂等：读
          1. 保证幂等：写、消息订阅和处理
     1. 如何保证：业务无关和业务强关
        - 基于状态：根据状态机，如订单状态的流转，原理同version，但是只应用在状态会变更的情况下
        - 基于唯一键：可以是几个id的组合。如一个用户每天只能领一张优惠券，通过用户id+优惠券类型+日期字符串即可唯一标识
        - 基于数据库
          1. 加悲观锁for update
          1. 加乐观锁version
          1. 加唯一索引
        - 基于redis分布式锁
#### 性能
1. 硬件指标
   - kvm：单台8核16G，查询5-6次redis，接口的qps可以为5000~6000
     1. 物理机
        - 品牌型号：dell(R440、R420)、lenovo(SR530、SR570)、hpe
        - 配置：联想SR570
          1. 3个PCIe 3.0
          1. 2*4114：24核
          1. 256G：2666MHz，ddr4 
          1. 4*960G：标配4个3.5英寸硬盘
          1. 电口：2*1000M，光口：2*10G含模块
          1. RAID10 5：标配raid软件，还有Raid卡
          1. 2*550W 电源
        - 价格
          1. 服务器：单台服务器7W，单台实体机可以虚拟化成7台8核虚机
          1. 机架租赁：10U的机柜，7500机柜/月
   - aliyun云服务
     1. mysql 8核16G：最大连接数 4000（qps），最大iops8000
     1. redis 16G集群版：最大连接数 20000，160000 qps，私网带宽 1.5Gbps
     1. rocketMQ 标准版本：弹性上限5000qps
   - 网络
     1. 阿里云CDN：1Tbps
     1. 阿里云到世纪互联带宽：5Gbps
     1. 世纪互联接入互联网上行和下行专线带宽(未知)：1G/根 * 2
     1. 世纪互联出口带宽和用户数的预估，实际占用最高1.9G为71万用户，14G支持200万、20G支持300万、70G支持1000万
     1. 专线质量
        - 延时 <=2ms，1.5ms，2.5ms
        - 丢包：<=0.03%
        - 带宽：10G x 4，多线路冗余自愈
1. 耗时分析
   - 网校网关损耗
     1. 网校网关：多半1ms以下，2ms、3ms依次减少，三者占99%
     1. 容器网关：1ms以下
   - 数据库连接
     1. mysql连接：1.5ms
     1. redis连接：0.3ms
     1. 走索引单条sql查询：0.6ms
   - 一次api请求：几十ms，大于100都是慢的。例php返回字符串请求耗时6ms，其中php处理时间：1.3ms
     1. dns解析：0.01ms、0.02ms、0.8ms、1ms
     1. connect_time：0.1ms、1.2ms
     1. pretransfer_time：1.4ms
     1. starttransfer_time：6.9ms
   - 硬件延迟数字：主要看比例，cpu缓存访问秒，读内存分钟，网络发送小时，读SSD天，读机械硬盘个月，数据包来回年
     1. cpu
        - 寄存器：300ps
        - l1缓存访问：1ns
        - l2缓存访问：4ns
        - l3缓存访问：12ns
        - 分支预测错误：5ns
        - 互斥锁/解锁：25ns
     1. 内存
        - cpu访问一次内存：60~100ns
        - 内存中连续读取1mb：250µs
        - 操作带宽：7000MBps
     1. 网络
        - 通过1Gbps发送2kb：20µs
     1. 存储
        - SSD随机读取：150µs
        - SSD连续读取1mb：1ms
        - 机械磁盘寻道：10ms
        - 机械磁盘连续读取1mb：20ms
     1. 其他
        - 压缩1kb：3µs
        - 同一个数据中心的来回：0.5ms
1. 调优思路
   - 根据不同机器调整参数
   - 大内存的，响应参数往大调
   - 增大tcp缓冲区，提高吞吐量，但是多占内存
   - 能够打开的文件句柄数，多占内存
   - tcp
     1. tcp最长空余时间，用heartbeat代替更好
     1. 允许内核重用time_wait状态的套接字
     1. 减少连接关闭的时间
1. 十亿行挑战：处理性能感知
   - 认识：从一个包含十亿行信息的文本文件中检索温度测量值，并计算每个气象站的最小、平均值和最高温度，每一行即气象站名字和温度的键值对
   - 对任务的初步认识：机器配置了SSD和32G内存
     1. 10亿行，大小13GB文件
     1. cat读取13GB，第一次操作接近6秒，之后越来越快到1秒，说明被放在了磁盘缓存中
     1. wc计算13GB，需要55秒
     1. 使用awk`time gawk -b -f 1brc.awk measurements.txt >measurements.out`，需要7分钟，说明最简单粗暴的Go方法，也能在7分钟左右搞定问题
   - 方案一：简单常见的go代码，bufio.Scanner读数据行，strings.Cut用“；”分隔，strconv.ParseFloat解析温度，用map累积结果，1分45秒内完成
    ```go
    // 数据结构
    type stats struct {
        min, max, sum float64
        count         int64
    }
    stationStats := make(map[string]stats)
    ```
   - 方案二：带指针值的map，因为每次存在一次读取、一次修改，所以数据结构改为map[string]*stats，1分30秒完成缩短了15秒
     1. cpuprofile分析发现，Map操作占用了30%的时间，其中12%用于分配，17%用于查找
   - 方案四：浮点数改为整数表示，浮点指令的执行速度要比整数指令慢得多，55秒完成缩短了5秒
   - 方案八：并行处理各块，Map-Reduce类问题，把文件分为几个块并行处理，单行版的1分45秒完成缩短到24秒

   - 方案七：自定义哈希表，40秒完成缩短了15秒
     1. Go中自定义哈希表并不复杂，只需使用带有线性探测的FNV-1a哈希算法即可。如果发生冲突，则使用下一空槽
     1. 预先分配大量哈希桶，哈希冲突的几率大概是2%
     1. 代码
        ```go
        // The hash table structure:
        type item struct {
            key  []byte
            stat *stats
        }
        items := make([]item, 100000) // hash buckets, linearly probed
        size := 0                     // number of active items in items slice

        buf := make([]byte, 1024*1024)
        readStart := 0
        for {
            // ... same chunking as r6 ...

            for {
                const (
                    // FNV-1 64-bit constants from hash/fnv.
                    offset64 = 14695981039346656037
                    prime64  = 1099511628211
                )

                // Hash the station name and look for ';'.
                var station, after []byte
                hash := uint64(offset64)
                i := 0
                for ; i < len(chunk); i++ {
                    c := chunk[i]
                    if c == ';' {
                        station = chunk[:i]
                        after = chunk[i+1:]
                        break
                    }
                    hash ^= uint64(c) // FNV-1a is XOR then *
                    hash *= prime64
                }
                if i == len(chunk) {
                    break
                }

                // ... same temperature parsing as r6 ...

                // Go to correct bucket in hash table.
                hashIndex := int(hash & uint64(len(items)-1))
                for {
                    if items[hashIndex].key == nil {
                        // Found empty slot, add new item (copying key).
                        key := make([]byte, len(station))
                        copy(key, station)
                        items[hashIndex] = item{
                            key: key,
                            stat: &stats{
                                min:   temp,
                                max:   temp,
                                sum:   int64(temp),
                                count: 1,
                            },
                        }
                        size++
                        if size > len(items)/2 {
                            panic("too many items in hash table")
                        }
                        break
                    }
                    if bytes.Equal(items[hashIndex].key, station) {
                        // Found matching slot, add to existing stats.
                        s := items[hashIndex].stat
                        s.min = min(s.min, temp)
                        s.max = max(s.max, temp)
                        s.sum += int64(temp)
                        s.count++
                        break
                    }
                    // Slot already holds another key, try next slot (linear probe).
                    hashIndex++
                    if hashIndex >= len(items) {
                        hashIndex = 0
                    }
                }
            }

            readStart = copy(buf, remaining)
        }
        ```
   - 方案三：去掉 strconv.ParseFloat，不需要标准库函数处理特殊情况，都是一位小数，直接从Scanner.Bytes使用字节切片，1分完成缩短了30秒
   - 方案五：去掉bytes.Cut，直接从后往前查找“；”来解析温度，其速度会比直接扫描完整气象站名称来查找“；”更快，50秒完成缩短了4秒
    ```go
    // 从后往前读，切割字符串
    end := len(line)
    tenths := int32(line[end-1] - '0')
    ones := int32(line[end-3] - '0') // line[end-2] is '.'
    var temp int32
    var semicolon int
    if line[end-4] == ';' {          // positive N.N temperature
        temp = ones*10 + tenths
        semicolon = end - 4
    } else if line[end-4] == '-' {   // negative -N.N temperature
        temp = -(ones*10 + tenths)
        semicolon = end - 5
    } else {
        tens := int32(line[end-4] - '0')
        if line[end-5] == ';' {      // positive NN.N temperature
            temp = tens*100 + ones*10 + tenths
            semicolon = end - 5
        } else {                     // negative -NN.N temperature
            temp = -(tens*100 + ones*10 + tenths)
            semicolon = end - 6
        }
    }
    station := line[:semicolon]
    ```
   - 方案六：去掉bufio.Scanner，整合扫描器在必须查看所有字节寻找换行符时，同时找“；”，f.Read代替bufio.Scanner，46秒完成缩短了5秒

   - 方案九：优化加并行，上边所有优化+并行，4秒之内处理10亿行
1. 压测
   - 开发过程压测
     1. 影响压测结果外界因素：本机句柄数限制(一般最大1024)，dns解析速度，网络质量，服务端连接数限制等
     1. 工具
        - ab：apache banch
        - apipost：可视化一键压测，底层采用自研的基于golang的压测引擎
   - 性能场景设计
     1. 项目分析：目标、架构、业务流程
     1. 需求分析：28原则、公认标准
        - 出现问题停止即可，再大无意义
     1. 场景选定、数据确定
   - 性能监控
     1. 操作系统
     1. 架构组件
   - 结果分析
     1. 指标
        - 并发数：uv
        - 处理数：tps
        - 响应时间
        - 设备性能
   - 最佳实践
     1. 测试机和服务不能在一台服务器上
     1. 不能针对线上服务做压力测试
     1. 观察测试机和服务机的cpu、内存、网路都不能超过75%
     1. 能承受最大的QPS
   - 压测工具：测试脚本开发
     1. jmeter
     1. loadRunner
     1. grinder
     1. ab：apache benchmark，apache官方推出的工具，创建多个并发访问线程，测试目标基于url
        - 参数：-c 并发数，-n 总请求数
        - 结果解读：响应长度，总花费时间，失败数，QPS，平均响应时间，时间花费分布区间
     1. curl的mult
     1. pcntl
#### 日志
1. kibana
   - 网关日志
   - 业务日志
1. 链路追踪
#### 监控与预警、故障排查
1. grafana
1. 监控
   - 基础设施
     1. 高峰流量峰值
     1. 高峰流量时段
     1. 低峰流量时段
   - 中间件、公共服务
   - 应用服务
1. 预警
   - 阈值设置
   - 事件响应机制
1. 基础设施
   - 硬件：cpu温度、服务器功率、cpu风扇转速
   - 网络
     1. 网络流出入速率
     1. tcp连接数、打开数、接收发送包速率、错误和重传数
   - 操作系统/容器：进线程数
   - 主机
     1. cpu：负载、上下文切换、可运行队列
     1. mem：使用率、swap
     1. io：文件、磁盘、网络
     1. 磁盘：使用率、读写速度/次数
1. 公共服务
   - mysql
     1. 数据增长率、连接数、表空间、非法访问
     1. qps、慢查询数量、慢sql
   - redis：内存占用、qps、连接数
   - nginx：qps、处理时间、服务器错误率
1. 应用服务
   - 服务状态(接口)：每个接口qps、接口发送/接收字节数、最大/平均响应时间、可用性检测
   - 服务错误数：5xx
   - 调用链：sql耗时、api耗时
   - 日志收集：响应码、上下游请求响应数据
##### 链路追踪、APM
1. 认识
   - 认识：生成、收集、导出监测数据(Metrics、Logs、Traces)，应用性能产品，保障健康可监测性
     1. 分布式链路追踪
     1. 性能指标分析
     1. 应用和服务依赖
   - demo
     1. opentelemetry
     1. 听云
     1. 网校探针：发生故障的时候，能够快速定位和解决问题
     1. skywalking：是观察性分析平台和应用性能管理系统。提供分布式追踪、服务网格遥测分析、度量聚合和可视化一体化解决方案，可用于php，支持多语言，支持Istio + Envoy服务网格，国内开源并提交到Apache孵化器，华为
     1. 元老：openTracing、opencensus
     1. zipkin：Spring Cloud全家桶自带
     1. opencensus：支持多语言，谷歌出品
     1. jeager：Uber
     1. CAT：点评的
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
##### 故障排查
1. 故障常见原因
   - 连表
   - 没加索引
   - 关键数据没有做好缓存
   - 计算复杂度高、逻辑复杂放到了c端
   - 监控项缺失：无法先兆发现
   - 没有全方位压测：最后一道保障
     1. 全链路压测能力不足，不能只从内网压测，无法模拟外网全链路
   - 客户端疯狂重试，造成雪崩
1. 常见问题梳理
   - cpu处理不及时，源源不断的客户端请求会堆积在内存中，导致内存占用增加，进一步导致处理时间变慢
   - 网络故障
     1. es脑裂
     1. tw：tw每10秒向etcd续活，超过时间后续活失败，etcd就删除对应的key，导致confd下发的配置缺失
        - 方案：网络恢复后，tw继续向etcd申请新key+续活
   - 磁盘故障导致发布系统删除了一台机器，但是修复后网关系统却加上了，导致业务代码落后
   - IDC机房清洗
     1. 机房发现异常流量进行302清洗
     1. cdn缓存，1分钟缓存过期后回源再次循环302
     1. 页面302无法访问
   - 由于高峰期占用cpu，停止了clamav导致中病毒
   - mysql连接没有关闭，导致连接数打满
   - redis消费慢导致数据延迟展示
   - 队列积压导致job机oom
   - 机器光口线序不对、raid卡错误
