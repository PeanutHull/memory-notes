#### 任务调度
1. 任务调度
   - 功能
     1. 超时时间
     1. 失败重试次数
     1. 日志
     1. 失败告警
     1. 支持子任务

     1. 可视化web后台，方便任务管理
     1. 分布式架构，集群化调度，无单点故障
     1. 追踪任务状态，采集任务输出，可视化log
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
   - 实现方式
     1. crontab：方便直接，大批量任务难以胜任，没有资源监控、执行监控、报警、日志体系
     1. TBSchedule：阿里开发
     1. Saturn：唯品会开源，在Elastic-Job基础上
     1. xxl-job
     1. elastic-job
     1. k8s
        - 基于容器的调度，更强的任务调度能力
        - 相对于xxl-job无需提前准备执行器，无需提前准备代码运行环境
     1. java
        - jdk
          1. Thread类：只能执行周期性任务，不能指定时间点
          1. Timer类：jdk的定时器工具，支持指定时间点，单线程执行任务，一个任务阻塞会影响其他任务
          1. ScheduledExecutorService：jdk1.5+的定时器工具，基于多线程执行，不互相影响，复杂定时规则较弱
        - 框架
          1. spring task：不支持集群方式部署，不能做数据存储型定时任务
          1. spring quartz：多线程异步执行，需要手动配置QuartzJobBean、JobDetail和Trigger等，需引入quartz包
     1. node
        - whyour/qinglong：支持多脚本语言(python3/js/shell/ts)的在线管理脚本/环境变量/配置文件的调度管理平台
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
#### 开放平台设计
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
1. 方案
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