1. 自动化测试
   - Selenium
     1. 理解：脚本控制浏览器
     1. 成员
        - IDE：脚本录制工具
        - WebDriver
        - Grid
   - 接口自动化测试框架
     1. RobotFramework：python开发，
     1. jmeter
     1. TestNG+HttpClient：ng负责用例的管理和执行，java开发
1. 性能测试
   - 性能场景设计
     1. 项目分析：目标、架构、业务流程
     1. 需求分析：28原则、公认标准
     1. 场景选定、数据确定
   - 测试脚本开发
     1. jmeter
     1. LoadRunner
     1. apache banch
   - 性能监控
     1. 操作系统
     1. 架构组件
   - 结果分析
     1. 指标
        - 并发数：uv
        - 处理数：tps
        - 响应时间
        - 设备性能
   - apm：应用性能管理，如听云
1. 安全测试
   - 测试方法
   - 测试工具
     1. appscan、webinspect、Fortity
     1. nessus：针对服务器
     1. Nmap：端口嗅探
     1. MetaSploit：很多工具
     1. WebScarab：代理劫持的工具
     1. W3AF：开源漏洞扫描工具
   - 漏洞原理
   - 防范方法
   - 自动化审计
1. vagrant：基于Ruby的工具，用于创建和部署虚拟化开发环境。使用Oracle的开源VirtualBox，使用Chef创建自动化虚拟环境
### Jmeter
1. 认识：100%java开发的开源免费的测试工具，主要用来功能测试和性能测试
1. 特性
   - 可测试http、https、Rest、db、LDAP、tcp、mail
   - 记录、构建、调试
   - 可自定义变量
   - 格式解析
   - 动态html解析
1. 功能
   - 配置元件
   - 定时器
   - 前后置处理器
   - 监听器
   - 断言：正则匹配，判断结果
   - 控制器：组合多个请求，如简单/交替/循环/随机/事务控制器
   - 命令行模式
1. 使用步骤
   - 新建Thead Group：所有任务由线程处理
   - 新建Http Request：填写相关参数，添加配置元件等
   - 添加监视器：`View Results Tree`、`Summary Report`
   - 添加断言：`Assertion`、`Assert Results`
   - 点击运行、点击停止、点击清除结果等按钮：结果会累加，需要手动清楚
1. 压测
   - 参数
     1. 线程数：N
        - 模拟将有多少个用户要执行
        - 每个线程独立运行测试计划
     1. 加速时间：Ramp-up Period，S
        - 表示用多少秒启动所有的线程，启动间隔为S/N
        - 表示每个线程间隔多长时间循环执行
        - 要做到足够长避免一上来大负载，也要足够小让最后一个线程在第一个完成前启动
     1. 循环次数：C
        - 可以延长每个线程的执行时间
     1. 调度器：持续时间、启动延迟
   - 特性
     1. 并发：即线程同时执行达到的最大数，协调S和C，即最后一个线程开始执行时，第一个线程依然在执行等(增加C)，要根据需要的并发量决定
   如果模拟10个用户，每个用户迭代10次，那么这里显示100
1. 用法
   - 关联其他请求：上一个请求的结果作为下一个的参数：如登录后继续操作，`Post Processors -> Regular Expresstion Extractor`
   - 录制脚本：XXX语言
   - 集群测试：jmeter-server，分布式测试
1. wiki
   - 监视器Summary Report
     1. Label：             测试主体的元素名称
     1. Samples：           总请求数
     1. Average：           平均响应时间，单位毫秒
     1. Median：            50％用户响应时间
     1. Min：               最小响应时间
     1. Max：               最大响应时间
     1. Error：             出现错误率
     1. Throughput：        吞吐量，默认表示每秒完成的请求数
     1. Received KB/Sec
     1. Send KB/Sec
   - 其他压测工具
     1. ab：`ab -n total -c runNum http://`，QPS/TPS=并发数/平均响应时间
     1. LoadRunner：收费
     1. http_load
   - 分布式压测