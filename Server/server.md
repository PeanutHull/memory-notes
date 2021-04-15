### confd+etcd
1. confd
   - 认识：是一个轻量级的配置管理工具，应用非常广泛的是etcd+confd，后端支持的数据类型有：etcd、consul、vault、environment variables、redis、zookeeper、dynamodb、stackengine、rancher
     1. 可通过查询etcd，结合配置模板引擎，用于保持本地配置最新
     1. 具备定期探测机制，配置变更自动reload
   - 工作流程
     1. 读取后端配置
     1. 组装到template，生成stage_files
     1. 对比stage_files和dest_file，有变更，更新dest_file、reload cmd
     1. 继续下一次循环
   - 运维
     1. 安装：下载、运行
        - `confd --help`
        - `confd-cli getall/get/set/delete` 操作confd的命令行程序
     1. confd配置：`confd -config-file xx.toml`
        ```conf
        backend = "etcdv3"
        confdir = "/home/www/confd-tw"                  # 指向模板配置文件
        log-level = "debug"
        watch = true # watch模式，实时更新。设置为interval = xxx 时为轮询模式，定时查询
        nodes = [
            "http://10.90.72.49:2379",
            "http://10.90.72.56:2379",
        ]
        ```
     1. 模板配置
        - `conf.d/xx/xx/config.toml`：指定模板
            ```conf
            [template]
            src = 'zhongtai/tnt/config.tmpl'
            dest = '/home/www/tnt.xesv5.com/database/redistw/tnt.php'
            keys = [
                "/serviceMesh/twemproxy-redis/twemproxy/zhong-tai/tnt",
            ]
            check_cmd="/usr/local/php7/bin/php -l  {{.src}}"
            ```
        - `templates/xx/xx/config.tmpl`：模板内容
            ```conf
            <?php
            return[
            {{range gets "/serviceMesh/twemproxy-redis/twemproxy/zhong-tai/tnt/*" -}}
            {{$data := split (.Value) ":" }}
                [
                "host" => "{{index $data 0}}",
                "port" => {{index $data 1}},
                "auth" => "",
                "pconnect" => 0,
                "timeout" => 100,
                "weight" => "{{index $data 2}}",
                ],
            {{end}}
            ];
            ```
1. etcd
   - 认识：开源的分布式的键值对数据存储系统，提供共享配置、服务的注册和发现，分布式一致性解决方案。从web程序到kubernetes、openstack都在用，go编写
     1. 简单安全：配置简单、提供http+json的api形式、支持ssl验证
     1. 快速：单实例支持每秒2k+读操作、1k写操作
     1. 可靠：采用raft算法，实现分布式系统数据的可用性和一致性
   - 服务发现
     1. 强一致性、高可用的服务存储目录
     1. 注册服务的健康状况机制：如设置key ttl，保持服务心跳
     1. 查找和连接服务：集群中互相连接，如集群中每个机器部署proxy模式的etcd
   - 使用
     1. 数据库操作：`etcdctl set/get/update/rm/mk/ [/xx/xx] xx`，`etcdctl mkdir/setdir/updatedir/rmdir/ls`
     1. 备份数据：`etcdctl backup`
     1. watch：`etcdctl watch/exec-watch`，值一旦变化则输出/执行命令
     1. 集群操作：`etcdctl member list/remove/add`，节点管理
   - 运维
     1. 单节点、集群安装：因为go写的，只需下载二进制文件就可运行，集群最少3个节点
     1. etcd 服务端，etcdctl 客户端
     1. 端口
        - 2379：http api
        - 2380：peer通信
   - 应用
     1. 使用心跳检测：保证服务稳定，通过etcd的目录关联，而不是直接关联，极大减少耦合性
     1. 可代替zookeeper，可做配置存储
1. 比较
   - Nacos ：是构建以“服务”为中心的现代应用架构 (例如微服务范式、云原生范式) 的服务基础设施致力于发现、配置和管理微服务。并且提供了一组简单易用的特性集，能够快速实现动态服务发现、服务配置、服务元数据及流量管理。帮助开发人员更敏捷和容易地构建、交付和管理微服务平台。
   - Consul：基于Go语言开发的支持多数据中心分布式高可用的服务发布和注册服务软件，采用Raft算法保证服务的一致性，且支持健康检查。提供了服务发现、服务配置、服务隔离三种不同的应用场景，每一个功能都能够进行单独使用，或者进行组合构建完整的服务管理系统。
   - Etcd：etcd与zookeeper相比算是轻量级系统，两者的一致性协议也一样，etcd的raft比zookeeper的paxos简单
   - Eureka：Netflix开发的服务发现框架，本身是一个基于REST的服务，主要用于定位运行在AWS域中的中间层服务，以达到负载均衡和中间层服务故障转移的目的。SpringCloud将它集成在其子项目spring-cloud-netflix中，以实现SpringCloud的服务发现功能。主要是包含两个组件，Eureka Server和Eureka Client。
   - Zookeeper：ZooKeeper是一个分布式的，开放源码的分布式应用程序协调服务，是Google的Chubby一个开源的实现，是Hadoop和Hbase的重要组件。它是一个为分布式应用提供一致性服务的软件，提供的功能包括：配置维护、域名服务、分布式同步、组服务等。
1. 对比：![avatar](../images/serviceSupport.png)
### caddy
1. 认识：开源的go写的http服务器
   - http新特性支持全面，如http2、quic、https
   - 配置简便，5秒可完成配置
