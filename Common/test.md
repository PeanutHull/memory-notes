### 测试
1. 自动化测试
   - ui自动化：Selenium等
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
     1. grinder：
   - 性能监控
     1. 操作系统
     1. 架构组件
   - 结果分析
     1. 指标
        - 并发数：uv
        - 处理数：tps
        - 响应时间
        - 设备性能
1. 表格驱动测试
   - 认识：测试数据和测试逻辑分开，更专注于测试数据。写个for里边放测试数据，然后循环这个进行调用测试
   - wiki
     1. 传统测试缺点
        - 测试数据和逻辑混在一起
        - 出错信息不明确
        - 一个出错立即停止
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
1. 渗透测试
1. 模糊测试
   - 认识：fuzz测试，是一种测软件健壮性的黑盒测试，使用坏数据、执行大量的次数的模糊测试方法
### 流量复制
### 流量回放
1. 认识
   - 把线上的流量放到测试环境回放进行自动回归测试，回放后分析系统存在的问题
   - 三个步骤：录制、回放、对比
1. 组成
   - 线上服务：流量复制服务
   - 中间层：流量处理服务
   - 被测试服务：流量回放服务
   - 最终：结果对比
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
   - 添加监视器Listener：`View Results Tree`、`Summary Report`
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
     1. siege
     1. LoadRunner：收费
     1. http_load
     1. webbench：最多可以模拟3万个并发连接，`webbench -c 1000 -t 30 http://xxx`
        - -t：并发
        - -c：时间
     1. locust
     1. GoReplay
     1. TcpCopy
     1. ab：`ab -n total -c runNum http://`，QPS/TPS=并发数/平均响应时间
     1. wrk：轻量级HTTP性能测试工具，比ab好用？
        ```lua
        // wrk.lua文件
        --school/course/detail
        --wrk -t 2 -c 10 -d 10s --timeout=5 -s wrk.lua --latency http://api-fzinner.jiaoyanyun.com/
        -- 这条命令表示，利用 wrk 对 api-fzinner.jiaoyanyun.com 测试网关下某个API 发起压力测试，线程数为 2，模拟 10 个并发请求，持续 10 秒。


        wrk.method = "POST"
        wrk.path = '//detail'
        wrk.body = '{"userId":100019,"periodId":3,"subjectId":3,"gradeId":10,"versionId":1,"scene":6,"volume":4,"orgId":1063,"productId":100111}'
        wrk.headers["X-Auth-Appid"] = ""
        wrk.headers["X-Auth-TimeStamp"] = ""
        wrk.headers["X-Auth-Sign"] = ""
        wrk.headers["Content-Type"] = "application/json"
        wrk.headers["Cookie"] = "_ga=GA1.2.1784594164.1511502670" 
        wrk.headers["User-Agent"] = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10_12_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/62.0.3202.94 Safari/537.36"

        request = function()
        return wrk.format(wrk.method, wrk.path, wrk.headers)
        end

        response = function(status, headers, body)
            -- print(wrk.path)
            if status ~= 200 then  
                -- print(body)  
                wrk.thread:stop()
            end
        end


        done = function(summary, latency, requests)
            io.write("------------------------------------\n")
            for _, p in pairs({50, 90, 99, 99.999 }) do
            n = latency:percentile(p)
            io.write(string.format("%g%%,延时: %d ms\n", p, n/1000))
            end

            io.write("=============ERROR====================\n")
            errors = summary["errors"]
            io.write("total socket connection errors: " .. errors["connect"] .. "\n")
            io.write("total socket read errors:       " .. errors["read"] .. "\n")
            io.write("total socket write errors:      " .. errors["write"] .. "\n")
            io.write("total HTTP status codes > 399:  " .. errors["status"] .. "\n")
            io.write("total request timeouts:         " .. errors["timeout"] .. "\n")
            io.write("=============END ERROR================\n")
        end
        ```
   - 分布式压测
   - 配套工具
     1. jvisualvm：jdk提供的负载、进程监控插件，能够监控本地以及远程
     1. jstack：jdk提供的java日志分析工具