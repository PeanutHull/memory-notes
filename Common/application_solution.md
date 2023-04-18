### 技术类
#### 任务调度
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
##### 分布式实现
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
#### 唯一id
1. 认识
   - 须保证生成的id不重复，笼统上讲需加锁，限制了qps的速率
1. 分布式ID：即全局唯一ID
   - 全局唯一
   - 高性能
   - 高可用
   - 好接入
   - 趋势递增
1. 高性能id生成器
   - 增加多个发号器：发号器即占用不同号段，多个同时使用增加并发能力
   - 提前存储id，直接用
1. 数据库自增
   - mysql步长
     1. 简单，单调自增
     1. 无法高并发、高可用
   - mysql号段模式
     1. 组成：从数据库批量获取id放入内存。每次申请时，根据乐观锁version更新max_id=max_id + step，更新成功表示申请成功
        - 建表，max_id记录最大id，step代表每次申请的步长，version乐观锁，biz_type业务类型
     1. 特点
        - 数据库访问频次低，压力小
        - 性能较好
1. redis原子步长
   - 多台redis设置不同步长，每天重新生成一个id，然后累加获得，实现高可用、负载均衡，性能好，数字ID天然排序
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
1. 百度uid-generator
   - 认识：基于雪花，支持自定义时间戳、工作机器ID和序列号等各部分的位数。https://github.com/baidu/uid-generator
     1. 需要worker_node表，应用每次启动插入数据的自增id为workId
1. 美团leaf
   - 认识：支持号段模式和雪花模式，https://tech.meituan.com/MT_Leaf.html
     1. 号段：需要leaf_alloc表
     1. 雪花：依赖zk的顺序id作worker_id，
1. 滴滴tinyid
   - 认识：号段模式，https://github.com/didi/tinyid/wiki
     1. 提供http和tinyid-client两种方式接入
#### 长连接
1. 实现
   - 轮询
   - websocket
   - 模仿k8s各组件使用的通信机制list-watch的一种实现
     1. list-watch 机制主要实现了两个 Restful API，一个 API 叫 list，一个 API 叫 watch，客户端首先通过 list API 一次性把存在于服务端的所有资源都捞下来缓存在本地，同时服务端一起返回一个叫做 “ResourceVersion” 的标志，该标志全局单调递增，客户端也会将该标志缓存在本地。
     1. 接下来客户端通过 watch API 和服务端建立一条不会断开的长连接，每当服务端的资源发生改变之后，就会把该资源以及对该资源的 增/删/改 之类的操作通过该条长连接发送给客户端，同时把 ResourceVersion + 1，一并发送给客户端，客户端拿到该资源以及该资源对应的操作之后，就要根据对应的操作更新本地的对应资源的缓存以及 ResourceVersion。
     1. 那怎么保证消息的可靠性呢？譬如中间发生了断网之类的情况，此时 ResourceVersion 就派上了用场，客户端通过每次 watch 返回的 ResourceVersion 和本地上一轮缓存的 ResourceVersion 作对比，如果发现差值大于 1，则认为中间可能发生了数据丢失，此时会再进行一次 list API 的操作，重新将服务端的全量数据资源捞下来缓存在本地，这样既保证了消息的实时性，也保证了消息的可靠性。
#### 配置方案
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
### 业务实践
#### 库存扣减
1. 演进
   - 单数据库事务保证
     1. 认识：保证订单+库存扣减的正确性
        - 性能问题突出，分库分片也无法解决
     1. demo
        ```sql
        Insert into antiRe(code) value (‘订单号+Sku’)
        Update stockNum set num=num-下单数量 where skuId=商品ID and num-下单数量>0      // 由数据库保证不超卖
        ```
   - redis超卖判断 + 数据库持久化
     1. 认识
        - 数据库不必再超卖判断
        - 订单号分库分表，消除数据热点
     1. redis
        - 多库存项扣减
            ```sh
            // 演示单项扣减，多项相同
            hset iphone inStock 1               # 设置一个可售库存
            hget iphone inStock                 # 查看可售库存为1
            hincrby iphone inStock -1           # 卖出扣减一个，返回剩余0，下单成功
            hget iphone inStock                 # 验证剩余0
            hincrby iphone inStock -1           # 应用并发超卖但Redis单线程返回剩余-1，下单失败
            hincrby iphone inStock 1            # 识别-1，回滚库存加一，剩余0
            hget iphone inStock                 # 库存恢复正常
            ```
        - 扣减的幂等性保证：增加一个防重码校验，`set a100_iphone "1" NX EX 10`
        - 单向保证：顺序要对
          1. 扣减库存：1.扣减库存 2.写入防重码，反过来会超卖
          1. 回滚库存：1.写入防重码 2.扣减库存
     1. 持久化设计
        - 事务demo
            ```sql
            Insert into antiRe(code) value (‘订单号+Sku’)
            Update stockNum set num=num-下单数量 where skuId=商品ID
            ```
        - 任务引擎实现最终一致性：面临子任务的后续一堆处理中，先把任务落库，通过数据库事务保证子任务拆分和父任务完成的事务一致性
          1. 把任务调度抽象为业务无关的框架
          1. 就是抽象个引擎，支持简单的流程编排，并保证至少成功一次，去处理后续的流程
   - 服务接入端加上防刷
     1. 认识：解决过热SKU打向Redis单片的性能抖动
        - 服务端加上毫秒级时间窗的限流：如10ms超过2个就限流，50台服务器一秒可卖1万个货，根据实际情况调整阈值就可以
   - 服务接入端提前分配库存
   - 后台差异对比：只要有异构一定有差异，扫描db中数据修复redis中的数据
#### 数据迁移
1. 方案
   - 每次数据库取一小批，积累一大批后，统一处理————加快速度，数据库压力小
   - 用队列异步拆分生产和消费————增强灵活性
   - 因为会拆成512个表，用512个数组存放逻辑分类后的数据————方便管理、分类
   - 分别添加处理队列、延时队列，延时队列用于数据校验和补偿
   - 用原子变量msg_count判断redis里是否全部处理完了，完了就再添加
   - 由于msg_count的顺序性，数据顺序也不会乱
1. 图：![avatar](../images/data_migration.png)
1. 执行步骤
   - 开启一个php process扫描课班数据表，每次取出1千条数据
   - 将取出的数据根据用户id做hash，财务数据分表有512张，php process建立512个数组，来存放hash的消息数据
   - php process每循环取出1万条数据以后
     1. 将id添加到延时队列(用于延时检测与补偿)
     1. 检测redis变量msg_count是否等于0，等于0则将512个数组打包成512个payload添加到即时队列，添加前设置msg_count++; 否则再循环取1万条数据，积累数据，进行下次进行判断
   - 开启8个消费者处理payload，将payload解析，组装成财务系统需要的数据，批量添加到相应数据表，每个消费者，处理一条payload，就将原子变量msg_count–;
   - 延时检测消费者，取出消息判断财务系统是否存在，不存在则单独补偿
1. 问答
   - 怎样保证数据原子性事务插入
     1. Innodb引擎本身能够保证数据的插入原子性，批量插入数据，要么成功，要么失败
   - 怎样保证迁移数据过程中数据不丢失
     1. 通过延迟消息(5分钟)检测的机制，能够检测出来扫描出来的数据(历史数据)在财务新系统中是否存在，如果不存在，则补偿单独迁移，报警！能够保证数据完整。
   - 怎样保证消息是按照顺序排列的
     1. 脚本通过原子变量msg_count保证生产者添加消息到队列，和消费者从队列里取消息是有序进行的，从而保证了数据表中插入数据是全局有序的
   - 脚本如何优雅关停
     1. php有pcntl类库，脚本通过监听KILL信号，将一个原子任务处理完成后，才会退出，从而保证脚本的优雅关停
#### 日志埋点
1. 组成
   - project项目
   - module模块
   - event_type
     1. launch：应用或客户端启动
     1. pv：完整的页面展示
     1. show：页面上不同元素的曝光，比如卡片、banner等
     1. click：点击行为，可以是点击某个icon、按钮、卡片等
     1. push：统计各类通知日志、环节需要区分请求、下发、到达、展示、点击等
     1. play：播放行为、视频播放开始、结束等
     1. exception：异常行为，记录客户端异常信息
   - 提前预制字段
1. 前端方式：监听dom
### 应用
#### 开放平台
1. 账号体系
   - 用户：级别、账户、余额
     1. 是否第三方登录：自建用户体系，（微信、qq）oauth2.0、OpenID
   - 鉴权：
     1. 将userId和服务id绑定，鉴定具有哪些权限
     1. 过期时间
   - 秘钥管理：accessId、accessKey。用于鉴别是否真正请求人（验证请求的发送者身份），用秘钥和参数生成加密串
     1. Format：json、xml
     1. Version：api版本号
     1. AccessId
     1. Signature：签名结果串
     1. SignatureMethod：签名方式，md5、HMAC-SHA1
     1. SignatureVersion：签名算法版本
     1. Timestamp：请求的时间戳，要标识出来UTC
     1. SignatureNonce：唯一随机数，用于防止网络重放攻击，用户在不同请求间要使用不同的随机数值
1. open api
   - 访问统计：配置能访问的模块
   - 频率控制：独立的流控模块，粒度是每秒/分钟/小时/天，
     1. 单ip
     1. 单应用
     1. 单用户
   - 安全：http/https、注入、网络重放攻击
   - 日志：访问日志
1. 问题
   - 微信为什么要用具有2小时过期的access_token？这个设计思路是：每次验证的时候将（accesskey+accessA+curTimestamp(当前时间戳)+randomNum(随机数)）这个加密，产生一个api_code,发送验证串的时候将api_code和里面的参数带到proxy验证，产生一个access_token和expire_time(token过期时间)。为了校验的时候快速？
1， 方案
   - 设计：产品设计、技术实现
   - accessId、accessKey：一般是把所有的请求参数排序后和apisecretkey做hash生成一个签名sign参数，服务器后台只需要按照规则做一次签名计算，然后和请求的签名做比较，如果相等验证通过，不相等就不通过。此排序严格大小写敏感排序。不包括sign本身
   - 参数：两个部分，公共请求参数，业务参数
   - utf-8编码
   - 返回RequestId：便于追查，和日志放在一起
   - 产品体系
     1. 简介
     1. 定价
     1. 快速入门
     1. 开发指南
     1. 用户指南
     1. 最佳实践：教用户怎么更好使用，比如设计场景，有什么好处
     1. 常见问题
     1. 相关协议
   - 频率控制
	 1. 方案1
        ```
        $listLength = LLEN rate.limiting:$IP

        if ($listLength < 10) {
            LPUSH rate.limiting:$IP now()
        }else{
            $time = LINDEX rate.limiting:$IP, -1
            if (now() - $time < 60){
                print "超过访问限制"
                exit
            }else{
                LPUSH rate.limiting:$IP now()
                LTRIM rate.limiting:$IP, 0, 9
            }
        }
        ```
	 1. 方案2
        ```php
        $key = 'ImageCode_RequestLimit_Uid';  
    	$listLen = lLen($key);  
    	if($listLen < 3){  
       		// 直接将当前时间戳插入List尾部  
        	Lpush($key, now());  
    	} else {  
        	$index0Time = Lindex($key);  
        	if((当前时间 - $index0Time) < 10min){  
            		// 触发10min内请求大于3次，提醒，“请求过多，请稍后再试。”  
            		echo "请求过多，请稍后再试。";  
            		exit;  
        	} else {  
            		// 将当前时间戳插入List尾部  
            		// 取出List头部首元素  
            		Lpush($key, now());  
            		Ltrim($key, 0, 2);  
        	}
    	}
        ```
1. wiki
   - OAuth2.0协议：是为了解决第三方程序可以获取保存在服务器上的用户的信息但用户又能不将自己的账号密码告知第三方程序
#### 登录鉴权
1. 认识
   - 令牌和密码
     1. 令牌是短期的，到期会自动失效，用户自己无法修改。密码一般长期有效，用户不修改，就不会发生变化
     1. 令牌可以被数据所有者撤销，会立即失效。密码一般不允许被他人撤销
     1. 令牌有权限范围，密码一般是完整权限
1. SSO
   - 理解：单点登录，用户的一次登录能得到其他所有系统的信任
     1. 共享同一个身份认证系统，也就是说所有站点的身份验证操作在同一个系统下完成
     1. 每个子系统从共同的身份认证系统中取得用户凭证，包含用户的身份/权限信息等
   - 方案
    1. 服务端写入持久化共享session（db,nosql等)，集中度高
    1. 服务端不保存session，数据由客户端发回服务端，服务端变为无状态，如jwt
1. JWT
   - 认识：JSON Web Token，跨域认证解决方案，服务端签发，客户端发回token进行校验。有官方写法，用base64和hs256
   - 组成：三者base64压缩，用.连接
     1. header：官方声明类型、加密算法
     1. playload：放一些无关紧要的东西，签发者、签发时间、过期时间等
     1. signature：加密的签名token，用来获取后续的信息
1. OAuth
   - Open Authorization，开放式授权，用来授权第三方应用，获取用户数据，v1.0有漏洞
     1. 可以让第三方应用获得权限，同时又随时可控，不会危及系统安全
   - 授权方式
     1. 授权码（authorization-code）：最常用，最安全。授权码前端传送，令牌存在后端，所有与资源服务器通信都在后端，前后端分离，避免了令牌泄露
        - 前端交互授权码
        - 后端和资源服务器交互令牌
     1. 隐藏式（implicit）：纯前端模式，称为(授权码)隐藏式，令牌直接给到前端，但是令牌位置是url锚点，不是查询字符串，因为浏览器跳转时锚点不会发到服务器，减少了泄漏令牌的风险
     1. 密码式（password）：适用于高度信任的第三方系统，直接用源站的账号密码登录
     1. 客户端凭证（client credentials）：纯后端模式，针对第三方应用而不是用户，即有可能多个用户共享同一个令牌
   - 流程
     1. 第三方备案申请
     1. 第三方请求令牌
     1. 输入本方密码，发放令牌
     1. 利用令牌访问相应api
     1. 令牌更新：颁发令牌时颁发两个，一个获取数据，一个用于获取新的，到期前用refresh token去获取新令牌
1. AUTH：基于节点的权限管理
1. RBAC
   - 理解：基于角色的访问控制，用户通过角色与权限进行关联，即 用户-角色-权限-资源
   - 表结构
     1. ucenter_member：用户表
     1. auth_group：组数据表
     1. auth_group_access：用户、组关系表
     1. auth_rule：权限表，模块+控制器+方法名、名称
1. ACL
   - 认识：Access Control List 访问控制列表，就是用户直接关联权限，数据分散，不方便集中管理
1. ABAC
   - 认识：Attribute Base Access Control 基于属性的权限控制，通过动态计算一个或一组属性是否满足设置好的逻辑进行授权判断。设计复杂，控制可以更加细粒度。如允许所有班主任在上课时间自由进出校门
     1. 属性四类：用户属性（如用户年龄），环境属性（如当前时间），操作属性（如读取），对象属性（如一篇文章，又称资源属性）
     1. 配置文件管理
1. ADDS：Active Directory Domain Service，ad域服务器，利用ldap命名路径（LDAP naming path）来表示对象在ad内的位置，提供查询、修改等服务。ad域内的资源以Object(对象)的形式存在，对象通过属性描述特征，就像电话簿中的一个记录，有姓名、地址等
   - LDAP：Lightweight Directory Access Protocol，轻量级目录访问协议，用来查询、更新Active Directory的目录服务通信协议，可以允许任何程序获得目录和其他信息，类似电话薄
     1. 目录：指一种按照树状结构存储信息的数据库
   - AD域切换技术方案：分三个阶段实施
     1. 活跃账号同步
        - 建立一张新的xes_admins表（新表名：xes_admins_ldap）
        - adminapi对接新的LDAP
        - 所有登录admin系统的账号，都在新的LDAP查询一次账号信息，在xes_admins表找到对应的adminid，再写入xes_admins_ldap中
     1. 数据比对
        - 比对xes_admins与xes_admins_ldap表中的数据，找到有差异的行数据
        - 针对有差异的行数据做甄别，判断是否有潜在风险，确认无风险后，做到数据一致
        - 如果判断没有风险，找一个晚上业务空闲时间做xes_admins表切换
     1. 在线数据切换
        - 将xes_admins表中的临时账户数据一次性导入到xes_admins_ldap表（临时账户数据是指没有匹配到工号的数据）
          1. 注：考虑到审计需要和老员工离职再入职等情况，不能只导正常账户，“冻结”和“注销”的数据也要导入到新表
        - 禁止xes_admins表新增，将xes_admins表名改为xes_admins_old，将xes_admins_ldap表名改为xes_admins（理论上表重名可以online操作，需要咨询DBA）
        - xes_admins_old 表自增id + 10000 （万一出现问题便于回滚）
#### IM
1. 方案
   - 扩散读：每条消息只存一份，群聊成员都读取同一份数据
   - 扩散写：每条消息存多份，每个群聊成员在自己的存储都有一份
   - 合并插入
1. 功能点
   - 消息收发
   - 已读未读
   - 群聊、单聊