### 认识
1. caddy：开源的go写的http服务器
   - http新特性支持全面，如http2、quic、https
   - 配置简便，5秒可完成配置
1. apache
   - 特点
     1. 模块化，模块多
     1. 支持虚拟主机
     1. 支持cgi、fastcgi、ssl、servlet
   - 工作模式
     1. cgi模式
        - 用法：`Action application/x-httpd-php "/php/php-cgi.exe"`
        - 原理：apache调用php.exe去解释文件，再将结果以网页的形式返回给客户机
     1. 模块模式
        - 用法：`LoadModule php5_module "c:/php/php5apache2.dll"`
        - 原理：php和apache一起启动并运行
     1. FastCGI模式
        - 下载fastcgi模块mod_fcgid.so/mod_fcgid.pd
        - 添加配置
   - 常用命令
     1. httpd.exe -t // 检测配置文件是否正确
     1. httpd.exe -k install
     1. httpd.exe -k start/stop/restart
   - window下安装apache+php
     1. 安装目录
        - Apache：C://http/http/Apache24
        - PHP：C://http/php
     1. 安装vc_redist.x64.exe和vcredist_x64
     1. apache配置修改
        - 将c:/Apache24全部替换成c:/http/http/Apache24
        - 在#LoadModule xml2enc_module modules/mod_xml2enc.so下面添加
          1. LoadModule php5_module "C:/http/php/php5apache2_4.dll"
          1. AddType application/x-httpd-php .php .html .htm
          1. PHPIniDir "C:/http/php"
        - 将DirectoryIndex index.html改为DirectoryIndex index.php index.html
        - 将ServerName www.example.com:80的注释去掉
     1. php环境配置
        - 把php文件目录下的libeay32.dll/php5ts.dll/ssleay32.dll和ext文件中的php_curl.dll复制到windows/system32下
        - 把C:/http/php和C:/http/php/ext加入环境变量
     1. php配置
        - 将php.ini-development在当前目录复制一份，保存为php.ini
        - extension_dir 指向c://http/php/ext
        - extension=php_curl.dll的分号去掉
        - date.timezone = 修改为date.timezone = Asia/Shanghai，去掉分号
     1. 启动
        - 双击C://http/php/php.exe
        - httpd.exe -k install
        - httpd.exe -k start
1. 部署：基于systemctl + nginx实现高可用，不是nginx + keepalive？
### 服务组件
#### confd
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