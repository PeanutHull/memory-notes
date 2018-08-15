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
### wiki
1. 监视器Summary Report
   - Label：             测试主体的元素名称
   - Samples：           总请求数
   - Average：           平均响应时间，单位毫秒
   - Median：            50％用户响应时间
   - Min：               最小响应时间
   - Max：               最大响应时间
   - Error：             出现错误率
   - Throughput：        吞吐量，默认表示每秒完成的请求数
   - Received KB/Sec
   - Send KB/Sec
1. 其他压测工具
   - ab：`ab -n total -c runNum http://`，QPS/TPS=并发数/平均响应时间
   - LoadRunner：收费
   - http_load