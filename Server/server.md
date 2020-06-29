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
   - 认识：是一个高可用的分布式键值数据库，可用于分布式系统，从web程序到kubernetes、openstack都在用，基于go，采用raft协议作为一致性算法
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
