### 认识
1. 认识：基于事件驱动，轻量级、高性能非阻塞的http/反向代理/负载均衡服务器。C编写，官方测试5万并发。windows系统不能发挥全部的性能
   - 资源消耗低，运行稳定，并发高
   - 分阶段资源分配技术，cpu/内存占用率低
   - 静态文件可开启索引和描述符缓冲
   - 简单的负载均衡
   - 支持热部署
   - 不支持cgi
1. 使用场景
   - 静态资源服务器：如js、images
   - 虚拟主机：实现一台服务器虚拟出多个网站
   - 反向代理、负载均衡
### 配置
1. 认识：一门微型的编程语言
   - 层级：http-->server-->location
1. nginx.conf配置
    ```lua
    user                        www;                            # 用户和用户组
    worker_processes            8;                              # 同时工作的进程数，建议设置为cpu核心数
    error_log                   /var/nginx/error.log;           # 全局错误日志，类型有debug|info|notice|warn|error|crit
    pid                         /var/nginx.pid;                 # 进程文件
    worker_rlimit_nofile        65535                           # 一个nginx进程打开的最多文件描述符数

    events {                                                    # 工作模式
        worker_connections      1024;                           # 单个进程最大连接数，最大连接数=连接数*进程数
        use epoll               kqueue|epoll|poll
    }

    http {                                                      # 服务器配置
        include                 /etc/nginx/mime.types;
        default_type            application/octet-stream;
        client_max_body_size    8M;
        
        access_log              /var/log/nginx/access.log  main;

        sendfile                on;                             # 高效文件传输模式，指定nginx是否调用sendfile函数来输出文件，普通应用为on，下载等应用磁盘IO重负载应用可为off，以平衡磁盘与网络I/O处理速度，降低系统的负载。如果图片显示不正常改成off
        send_timeout            60;                             # 防止网络阻塞
        tcp_nopush              on;

        keepalive_timeout       65;                             # 长连接超时时间，秒

        include /etc/nginx/conf.d/*.conf;
    }
    ```
1. 变量
   - 认识：$开头
   - 内置全局环境变量
     1. 请求类
        - $remote_addr                客户端的IP地址
        - $remote_port                客户端的端口
        - $remote_user                已经经过Auth Basic Module验证的用户名
        
        - $request_uri                包含请求参数的原始URI，不包含主机名，如：”/foo/bar.php?arg=baz”
        - $uri                        不带请求参数的当前URI，$uri不包含主机名，如”/foo/bar.html”
        - $document_uri               与$uri相同
        - $args                       等于请求行中的参数，同$query_string
        - $document_root              当前请求在root指令中指定的值

        - $server_protocol            请求使用的协议，通常是HTTP/1.0或HTTP/1.1
        - $host                       请求主机头字段，否则为服务器名称
        - $content_length             请求头中的Content-length字段
        - $content_type               请求头中的Content-Type字段
        - $http_cookie                客户端cookie信息
        - $http_user_agent            客户端agent信息

        - $scheme                     HTTP方法（如http，https）
        - $request_method             客户端请求的动作，通常为GET或POST
        - $request_filename           当前请求的文件路径，由root或alias指令与URI请求生成
     1. 自身配置
        - $limit_rate                 可以限制连接速率
        - $server_addr                服务器地址，在完成一次系统调用后可以确定这个值
        - $server_name                服务器名称
        - $server_port                请求到达服务器的端口号
1. server配置，决定虚拟主机
    ```lua
    server {
        listen       80;
        listen       somename:8080;
        server_name  somename  alias  another.alias;
    }
    ```
1. location配置，匹配路径
   - 语法：优先级递减
     1. =     精确匹配    1
     1. ^~    以某个字符串开头，不以开头的可以新建另一个server不同port解决    2
     1. ~     开头表示区分大小写的正则匹配    3
     1. ~*    开头表示不区分大小写的正则匹配    4
     1. !~    区分大小写不匹配的正则    5
     1. !~*   不区分大小写不匹配的正则    6
     1. /     通用匹配，任何请求都会匹配到    7
   - 实例
    ```lua
    location / {
        root   html;
        index  index.html index.htm;
    }

    location ~ \.php$ {                                                         # php-fpm
        fastcgi_pass   127.0.0.1:9000;
        fastcgi_index  index.php;
        fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;     # 以下两句也可替换为include fastcgi.conf;
        include        fastcgi_params;                                          # 这是个文件
    }

    location ~* .(gif|png|jpg|jpeg|zip|apk)$ {                                  # 定向文件
        root   /mnt/opt/wecook-base/uploads;
        expires 7d;                                     // 缓存时间
        access_log off;
    }
    location ~* (^/statics/dishes/.*\.(html|js|css|eot|svg|ttf|woff)$){
        root /Users/Treri/project/wecook/mobile;
    }

    location / {                                                                # 重定向
        if (!-e $request_filename) {
            rewrite  ^(.*)$  /index.php?s=$1  last;
            break;
        }

        if (-d $request_filename) { 
            rewrite [^/]$ $uri/?$query_string break;                            # 携带参数跳转
        }
    }
    # last – 基本上都用这个Flag。
    # break – 中止Rewirte，不在继续匹配
    # redirect – 返回临时重定向的HTTP状态302
    # permanent – 返回永久重定向的HTTP状态301

    location / {                                                                # 反向代理，请求转发
        proxy_pass http://localhost:99;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_redirect off;             # 当上游服务器返回的响应是重定向或刷新请求时，是否重设http头部的location或refresh字段
        proxy_next_upstream off;        # 当请求服务器发生错误或超时时，转发到下一台服务器，默认off
    }

    error_page   500 502 503 504  /50x.html;                                    # 错误页面
    location = /50x.html {
        root   html;
    }

    location ~ /\.ht {                                                          # 拒绝
        allow 127.0.0.1/24;
        deny  all;
    }
    location ~ /\.(git|svn|vcs)/ {
        return 404;
    }

    location / {                                                                # 添加header
        add_header headerName headerValue
    }
    ```
1. if
1. rewrite
   - 认识：重定向的重要指令，根据正则匹配内容跳转到replacement
   - 场景
     1. 调整用户浏览的URL，看起来规范
     1. 为了让搜索引擎收录网站内容，让用户体验更好
     1. 网站更换新域名后
     1. 根据特殊的变量、目录、客户端信息进行跳转
   - 使用
     1. 应用位置：server、location、if
     1. 默认值：none
   - 指令：`rewrite regex replacement [flag];`
     1. regex：表示想要匹配的目标URL
     1. replacement：将正则匹配的内容替换成replacement
        - $1是取自regex部分()里的内容
     1. flag
        - last	本条规则匹配完成后继续向下匹配新的location URI规则
        - break	本条规则匹配完成后终止，不在匹配任何规则
        - redirect	返回302临时重定向
        - permanent	返回301永久重定向
   - 实例
     1. `rewrite /last.html /index.html last;`
     1. `rewrite ^/html/(.+?).html$ /post/$1.html permanent;`：把/html/*.html => /post/*.html，301定向
     1. `rewrite ^/(.*) http://www.jd.com/$1 permanent;`：把当前域名的请求，跳转到新域名上，域名变化但路径不变
1. 超时时间
   - proxy_connect_timeout：和后端服务器的连接(发起握手后的)等待超时时间
   - proxy_read_timeout：等待后端服务器的响应超时时间
   - proxy_send_timeout：发送请求给后端服务器的超时时间，规定时间之内后端服务器接收完所有的数据
1. 缓存大小
   - proxy_buffer_size：缓存区大小
   - proxy_buffers：缓存区大小和数量
   - proxy_busy_buffers_size：高负荷下缓存大小
   - proxy_temp_file_write_size：缓存临时文件大小

   - client_max_body_size 500m;              # 客户端请求服务器最大允许大小
   - client_body_buffer_size     128k;       # nginx分配给请求数据的Buffer大小
   - proxy_ignore_client_abort   on;         # 是否开启proxy忽略客户端中断
1. https：`listen 443 ssl;`
1. fastcgi：`fastcgi.conf`
    ```conf
    fastcgi_param  SCRIPT_FILENAME    $document_root$fastcgi_script_name;
    fastcgi_param  QUERY_STRING       $query_string;
    fastcgi_param  REQUEST_METHOD     $request_method;
    fastcgi_param  CONTENT_TYPE       $content_type;
    fastcgi_param  CONTENT_LENGTH     $content_length;

    fastcgi_param  SCRIPT_NAME        $fastcgi_script_name;
    fastcgi_param  REQUEST_URI        $request_uri;
    fastcgi_param  DOCUMENT_URI       $document_uri;
    fastcgi_param  DOCUMENT_ROOT      $document_root;
    fastcgi_param  SERVER_PROTOCOL    $server_protocol;
    fastcgi_param  REQUEST_SCHEME     $scheme;
    fastcgi_param  HTTPS              $https if_not_empty;

    fastcgi_param  GATEWAY_INTERFACE  CGI/1.1;
    fastcgi_param  SERVER_SOFTWARE    nginx/$nginx_version;

    fastcgi_param  REMOTE_ADDR        $remote_addr;
    fastcgi_param  REMOTE_PORT        $remote_port;
    fastcgi_param  SERVER_ADDR        $server_addr;
    fastcgi_param  SERVER_PORT        $server_port;
    fastcgi_param  SERVER_NAME        $server_name;

    # PHP only, required if PHP was built with --enable-force-cgi-redirect
    fastcgi_param  REDIRECT_STATUS    200;
    ```
1. 其他配置文件
   - mime.types：文件扩展名与文件类型映射表，找不到使用默认default_type
   - fastcgi.conf/fastcgi_params/uwsgi_params/scgi_params：使用对应cgi时，向cgi传递的变量
   - koi-utf/koi-win/win-utf：编码转换映射文件
### 应用
1. gzip压缩：可在任何层级定义，越细优先级越高
    ```lua
    gzip on;
    gzip_static on;        
    gzip_min_length 1k/1024;                            // 最小压缩文件大小
    gzip_http_version 1.1;                              // 压缩版本，默认1.1
    gzip_buffers 16 8k;                                 // 压缩缓冲区
    gzip_comp_level 6;                                  // 压缩等级
    gzip_types text/plain application/x-javascript application/javascript application/json text/javascript text/css;
    gzip_disable "msie6";
    gzip_vary on;
    gzip_proxied any;
    limit_zone crawler $binary_remote_addr 10m;         // 开启限制IP连接数的时候需要使用
    ```
1. 负载均衡
   - 特点：实现了七层负载均衡，功能多、性能好、运行稳定，自动剔除不正常服务器，上传文件使用异步模式，有权重等多种分配策略
   - 内置策略
     1. ip hash：变相轮询算法，将访问固定到某一机器上
     1. 加权轮询：一直给高权重机器，分配请求会权重降低。先给高权重机器，直到该机器权值降到了比其他机器低才给其他机器，weight是权重。当所有机器都down时，nginx会立即将所有机器标志位变初始状态，避免全部timeout的状态
   - 扩展策略
     1. fair策略：根据机器响应时间判断负载情况，选出最快的
     1. 通用hash：以nginx内置的变量为key进行hash
     1. 一致性hash：使用nginx内置的一致性hash环
   - 内置策略：nginx的proxy
    ```lua
    --print("七层")
    http{
        upstream host {
            ip_hash;                                                    # 加上几位ipHash策略，去掉为加权
            server 0.0.0.1:80 weight=3 max_fails=3 fail_timeout=30s;    # max_fails节点多少次失败就摘除，fail_timeout节点不可用时暂停多久
            server 0.0.0.2:80 weight=2 backup;                          # 别的节点都挂了才用这个
            server 0.0.0.3:80 weight=3 proxy_next_upstream;
            keepalive_timeout 5s;                                       # nginx主动发起关闭tcp通道的时间，防止上游关闭连接的瞬间，下游来请求产生502
        }
        server {
            location / {
                proxy_pass http://somename
            }
        }
    }
    --print("四层")
    stream {
        server {
            listen 1034;
            proxy_pass app;
        }
        upstream app {
            server 192.168.0.3:1034;
        }
    }
    ```
1. 防盗链：通过Referer或者签名，检测访问的来源网页
    ```lua
    location ~ .*\.(gif|jpg|png|fiv|swf)$ {
        valid_referers none blocked imooc.com *.imooc.com       # 针对referer
        if($invalid_referer) {
            rewrite ^/ http://403.jpg
        }

        # 针对伪造referer，第三方模块HttpAccessKeyModule
        accesskey on;
        accesskey_hashmethod md5;
        accesskey_arg "key";                                    # get参数名称
        accesskey_signature "mypass$remote_addr"                # 加密规则，nginx会检查签名的正误
    }
    ```
1. CORS
    ```lua
    location / {
        if ($request_method = 'OPTIONS') {
            add_header 'Access-Control-Allow-Origin' '*';
            add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
            #
            # Custom headers and headers various browsers *should* be OK with but aren't
            #
            add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
            #
            # Tell client that this pre-flight info is valid for 20 days
            #
            add_header 'Access-Control-Max-Age' 1728000;
            add_header 'Content-Type' 'text/plain; charset=utf-8';
            add_header 'Content-Length' 0;
            return 204;
        }
        if ($request_method = 'POST') {
            add_header 'Access-Control-Allow-Origin' '*';
            add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
            add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
            add_header 'Access-Control-Expose-Headers' 'Content-Length,Content-Range';
        }
        if ($request_method = 'GET') {
            add_header 'Access-Control-Allow-Origin' '*';
            add_header 'Access-Control-Allow-Methods' 'GET, POST, OPTIONS';
            add_header 'Access-Control-Allow-Headers' 'DNT,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type,Range';
            add_header 'Access-Control-Expose-Headers' 'Content-Length,Content-Range';
        }
    }
    ```
1. 改为长连接
    ```lua
    server {
        location /api/wx1matrix/ {
            rewrite ^.+api/wx1matrix/?(.*)$ /$1 break;
            proxy_set_header Host wx1matrix.xueersi.com;

            // 改为长连接用这俩，必须都有，否则不生效
            proxy_http_version 1.1;
            proxy_set_header Connection "";

            proxy_redirect off;
            proxy_pass http://images;
        }
    }
    upstream images {
        server 10.20.27.13:80;
        server 10.20.27.14:80;
        
        // 改为长连接同时需要搭配这个
        keepalive 100;
    }
    ```
1. 网关：应用服务管理、流量调度策略、业务监控告警，扩容铺机器就可以
   - 权限校验
   - vhost和upstream管理
   - 流量控制和限流：可根据接口响应时间判断服务健康度制定限流值，也可根据某特征实现访问控制
   - 分流：指定请求转发，用于A\B测试
   - 缓存：vanish
   - 放火：故障模拟，如500、502、504等故障和响应时长变长，可用于制定容灾方案
   - 流量克隆：请求在网关层的完全复制，可用于业务重构时流量双写到新的b系统
   - 防火墙
   - 健康检查
     1. 检查类型
        - tcp检测
        - http检测：基于检测接口，如php7fpmstatus
     1. 检查项
        - 超时时间
        - 检查间隔时间
        - 合法状态码
        - 累计失败数：连续检测多少次失败后网关认为该节点已挂
        - 累计成功数：连续检测多少次成功后网关认为该节点已恢复
        - 是否通知
        - 是否摘除
1. 网关接口
   - CGI
     1. 理解：Common Gateway Interface，通用网关接口，外部应用程序和web服务器的数据交换的接口标准，允许web服务器执行外部程序，并将输出发回web服务器。早期动态网页处理程序一次只能处理一个请求。跨平台好，性能低下，NCSA维护
     1. 原理
        - 请求——创建子进程——处理，即fork-and-execute模式，请求数=cgi子进程数，子进程的反复加载是cgi性能低下的原因，会大量占用cpu和内存
        - 每个web请求都必须重新解析php.ini，重新载入全部扩展，初始化全部数据结构
   - FastCGI
     1. 理解：类似常驻型cgi，先启一个master，cgi解释器保持在内存中并接受fastcgi的调度，类似线程池的技术特性，也是一个协议
     1. 原理
        - web服务器载入fastcgi进程管理器
        - fastcgi自身初始化，启动多个cgi解释器进程等待调用
        - 请求到达时，web服务器连接到fastcgi，fastcgi选择一个cgi解释器交给web服务器
        - cgi将结果返回web服务器
     1. 特点
        - 所有配置只在进程启动时加载一次
        - PHP死掉不会带死apache，而且会立即启动一个新的php进程
        - fastcgi是适用高并发场景的，对web服务器不挑可以自由更换
   - SCGI：Simple CGI，精简数据协议和响应过程的FCGI，为适应ajax和rest，做出更快更简介应答，并规定http响应后立刻关闭链接，适合SOA提倡的请求-忘记的通信模式
   - WSGI：Web Server Gateway Interface，
   - GRPC
    ```
    server {
        listen 1443 ssl http2;
        ssl_certificate     ssl/xx.pem;
        ssl_certificate_key     ssl/xx.pem;

        location / {
            grpc_pass grpc://grpc_server;

            error_page 502 = /error502grpc;
        }

        location /error502grpc {
            internal;                   # ???
            
            return 204;
        }
    }

    upstream grpc_server {
        server 127.0.0.1:10000;
        server 127.0.0.1:10001;
    }
    ```
### 调优
1. worker_processes
1. worker_rlimit_nofile
1. worker_connections
1. tcp_max_syn_backlog
   - 太大：php-fpm处理不过来，nginx等待超时断开连接，报504 gateway timeout，同时php-fpm处理完准备write数据给nginx时发现TCP连接断开报Broken pipe
   - 太小：进不了php-fpm的accept queue，报502 Bad Gateway
1. 优化：修改配置项目
   - worker_processes 8;                                    # 进程数
   - worker_cpu_affinity 1000 0100 0010 0001;               # 每个进程分配cpu，这是4核
   - worker_connections 65535;                              # 连接数=进程数*单个进程连接数
   - worker_rlimit_nofile 65535;                            # 打开的最多文件描述符
   - use epoll;                                             # 不同系统不同模型
   - keepalive_timeout 60;
   - gzip on;
### 运维
1. 安装
   - linux
     1. 源码安装
        ```
        yum -y install gcc gcc-c++ automake autoconf libtool make                           // 编译依赖

        wget ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.41.tar.gz         // pcre
        tar -zxvf pcre-8.41.tar.gz && ./configure && make && make istall
        wget http://zlib.net/zlib-1.2.11.tar.gz                                             // zlib
        tar -zxvf zlib-1.2.11.tar.gz && ./configure && make && make istall
        wget http://nginx.org/download/nginx-1.12.2.tar.gz
        tar -zxvf nginx-1.12.2.tar.gz && cd nginx-1.12.2

        groupadd  www                                                                       // 添加www组    
        useradd -g  www www -s /bin/false                                                   // 加入到www组，不允许www用户直接登录系统

        ./configure \
        --user=www --group=www \
        --sbin-path=/usr/local/nginx/nginx \
        --conf-path=/usr/local/nginx/nginx.conf \
        --pid-path=/usr/local/nginx/nginx.pid \
        --with-http_ssl_module \
        --with-pcre=/opt/app/openet/oetal1/chenhe/pcre-8.37 \
        --with-zlib=/opt/app/openet/oetal1/chenhe/zlib-1.2.8 \
        --with-openssl=/opt/app/openet/oetal1/chenhe/openssl-1.0.1t
        make
        make install
        ```
     1. yum安装
        - 更新至nginx官方yum源，如centos6则OS=centos, OSRELEASE=6
        ```
        vim /etc/yum.repos.d/nginx.repo
        [nginx]
        name=nginx repo baseurl=http://nginx.org/packages/mainline/OS/OSRELEASE/$basearch/ gpgcheck=0
        enabled=1

        yum makecache
        yum install nginx
        ```
   - tengine
    ```
    wget -c --no-check-certificate ftp://ftp.csx.cam.ac.uk/pub/software/programming/pcre/pcre-8.39.tar.gz
    wget -c --no-check-certificate https://www.openssl.org/source/openssl-1.0.2j.tar.gz
    wget -c --no-check-certificate https://github.com/alibaba/tengine/archive/tengine-2.2.0.tar.gz
    tar -zxf pcre/openssl/tengine
    cd tengine
    ./configure --with-pcre=pcre解压位置 --with-openssl=openssl解压位置
    make && make install
    ```
1. 操作
   - 启动：`nginx`
   - 热重启：`nginx -s stop/reload`
### 架构
1. 网关
   - 作用
     1. 反向代理
     1. 负载均衡
     1. api管理
        - 限流
   - 架构：cdn——负载均衡器——api网关——k8s的ingress控制器——web服务
### 中间件
1. nginx + lua
   - 认识：结合nginx的并发处理epoll优势，和lua的轻量实现简单的功能切高并发的场景
     1. 用命令行进入能执行代码的，就是这个语言的解释器
     1. nginx在不同阶段调用lua，同时也提供了自己的api
   - 使用
     1. nginx调用lua：nginx的可插拔模块化加载执行，共11个处理阶段
        - set_by_lua、set_by_lua_file：设置nginx变量，可以实现复杂的赋值逻辑
        - access_by_lua、access_by_lua_file：请求访问阶段处理，用于访问控制
        - content_by_lua、content_by_lua_file：内容处理器，接收请求处理并输出响应
     1. lua调用nginx api
        - ngx.var                   nginx变量
        - ngx.req.get_headers       获取请求头
        - ngx.req.get_uri_args      获取url请求参数
        - ngx.redirect              重定向
        - ngx.print                 输出响应内容体
        - ngx.say                   同print，最后再输出一个换行符
        - ngx.header                输出响应头
   - 实例
     1. 基于ip的灰度选择功能
        ```lua
        // nginx配置
        server {
            listen 80;
            server_name localhost;

            location /myip {
                default_type 'text/plain';
                content_by_lua '
                    clientIp = ngx.req.get_headers()["x_forwarded_for"]
                    ngx.say("IP:",clientIp)
                ';
            }

            location / {
                content_by_lua_file /xx/xx.lua
            }

            location @server {
                proxy_pass http://server
            }

            location @server_test {
                proxy_pass http://server_test
            }
        }

        // lua文件，memcache里边存储灰度ip，判断是否相等
        
        // 获取客户ip
        clientIp = ngx.req.get_headers()["x_forwarded_for"]

        // 初始化memcache
        local memcached = require "resty.memcached"
        local memc, err = memcached:new()
        if not memc then
            ngx.say("failed to instantiate memc: ", err)
            return
        end

        // 连接memcache
        local ok, err = memc:connect("127.0.0.1", 11211)
        if not ok then
            ngx.say("failed to connect: ", err)
            return
        end

        // 能否获取值
        local res, flags, err = memc:get(clientIP)
        ngx.say("value key:",res,clientIP)
        if err then
            ngx.say("failed to get clientIP ", err)
            return
        end

        // 选择调用哪个location
        if res == "1" then
            ngx.exec("@server_test")
            return
        end
        ngx.exec("@server")
        ```
   - 搭建
     1. 依赖
        - luaJIT：更快的解释器
        - ngx_devel_kit、ua-nginx-module
        - 重新编译nginx
     1. 步骤：https://www.imooc.com/article/19597
1. OpenResty：ngx_openresty，基于nginx与lua的高性能web平台，用于方便地搭建处理高并发、扩展性的服务和动态网关
   - 可以使用lua脚本语言调动nginx的各种c、lua模块，让web服务直接跑在nginx内部
   - 针对域名、目录结构做分流、转发的策略，既能做负载又能做反向代理
   - 具有Lua协程 + Nginx 事件驱动的事件循环回调机制，即Cosoket，对远程后端如MySQL、Memcached、Redis等都可实现同步写代码的方式实现非阻塞I/O
   - 依托于LuaJit，即时编译器会将频繁执行的代码编译成机器码缓存起来，当下次调用时将直接执行机器码，相比原生逐条执行虚拟机指令效率更高，而对于那些只执行一次的代码仍然可以逐条执行
1. wiki
   - C10K：OpenResty、JavaNetty、Golang、NodeJS 
   - 调整文件打开数、设置 TCP Buckets、设置 TIME_WAIT等
   - 马蜂窝广告数据处理
     1. 收集
        - lua代码缓存，设置Resolver、epoll、keepalive
        - 数据收集部分不需要考虑时序或对数据进行聚合处理，因此核心的推送介质选择 Lua 共享内存即可，以 I/O 请求来代替访问其他中间件所需要的网络服务
     1. 处理
        - FFI处理ip
        - 之后创建内部的日志 location，结合 Lua 自定义 log_format，利用 Nginx 子请求特性离线完成数据落盘，同时保证数据延迟时长在毫秒级
        - Redis+FluxDB
          1. 去中心化，配置链接池来增加链接复用，增加 AOF与延时入库保证可靠
          1. FluxDB保证数据日志时序性可查，聚合统计与实时报表表现较优
     1. 存储
        - 实时数据源：数据采集服务→ Filebeat → Kafka → Flink → ES
        - 离线数据源：HDFS → Spark → Hive → ES
     1. 流程
        - init_worker_by_lua阶段：负责服务配置业务
        - access_by_lua阶段：负责CC防护、权限准入、流量时序监控等业务
        - content_by_lua阶段：负责实现限速器、分流器、WebAPI、流量采集等业务
        - log_by_lua阶段：负责日志落盘等业务
     1. 分流器业务：NodeJS上报cpu、内存使用情况；Lua脚本调用RedisCluster获取时间窗口内NodeJS集群使用情况，计算出负载较高的，进行熔断、降级、限流等处理；将监控数据同步InfluxDB，进行时序监测
     1. 小型web防火墙：使用第三方开源 lua_resty_waf 类库实现，支持 IP 白名单和黑名单、URL 白名单、UA 过滤、CC 攻击防护功能。在此基础上增加WAF对InfluxDB 的支持，进行时序监控和服务预警
1. kong
### 实际应用
1. 代理线上配置
    ```lua
    server { 
        listen 80;
        server_name tntapi.xesv5.com ;
        set_by_lua_block $request_trace_id {
            local mid = ngx.var.pid..ngx.var.server_addr..ngx.var.remote_addr..ngx.var.connection..ngx.var.connection_requests..ngx.var.bytes_sent..ngx.now()
            return ngx.md5(mid)
        }
        access_log /home/nginx/logs/tntapi.xesv5.com_access.log main;
        error_page 500 502 503 504  http://www.xueersi.com/wait.html;
        location /  { 
            add_header 'Access-Control-Allow-Methods' 'GET,POST,OPTIONS';
            add_header 'Access-Control-Allow-Credentials' 'true';
            add_header 'Access-Control-Allow-Origin' '$http_origin';
            add_header 'Access-Control-Allow-Headers' 'prelogid,Authorization,DNT,User-Agent,Keep-Alive,Content-Type,accept,origin,X-Requested-With,rpcid,traceid,jytoken';
            proxy_pass http://tntapi.xesv5.com;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Request-Id $request_trace_id;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_redirect off;
            client_max_body_size 500m;
            client_body_buffer_size 128k;
            proxy_ignore_client_abort on;
            proxy_connect_timeout 60;
            proxy_send_timeout 60;
            proxy_read_timeout 60;
            proxy_buffer_size 128k;
            proxy_buffers 32 32k;
            proxy_busy_buffers_size 128k;
            proxy_temp_file_write_size 128k;
            proxy_next_upstream off;
            add_header X-Request-Id $request_trace_id;
            add_header "Set-Cookie" "X-Request-Id=$request_trace_id; path=/";
            add_header Xes-App $upstream_http_server;
        } 
    } 
    ```
1. 线上业务机配置
    ```lua
    user  nobody nobody;
    worker_processes auto;
    error_log  /home/nginx/logs/error.log  error;
    pid        /home/nginx/logs/nginx.pid;

    worker_rlimit_nofile 51200;

    events {
        use epoll;
        worker_connections 51200;
    }

    http {
        include       mime.types;
        default_type  application/octet-stream;

        server_names_hash_bucket_size 128;
        client_header_buffer_size 4k;
        large_client_header_buffers 4 32k;
        client_max_body_size 500m;

        sendfile on;
        tcp_nopush     on;

        server_tag xes-app/bj-sjhl-api-jiaoyan-online-94-32;

        keepalive_timeout 75;

        tcp_nodelay on;

        fastcgi_connect_timeout 300;
        fastcgi_send_timeout 300;
        fastcgi_read_timeout 300;
        fastcgi_buffer_size 256k;
        fastcgi_buffers 4 256k;
        fastcgi_busy_buffers_size 512k;
        fastcgi_temp_file_write_size 512k;

        client_body_buffer_size 256k;
        send_timeout 3m;
        proxy_ignore_client_abort on;

        gzip on;
        gzip_min_length  1k;
        gzip_buffers     4 16k;
        gzip_http_version 1.0;
        gzip_comp_level 2;
        gzip_types text/plain text/css text/javascript application/json application/javascript application/x-javascript application/xml application/x-httpd-php image/jpeg image/gif image/png font/ttf font/otf image/svg+xml;
        gzip_vary on;

        server {
                listen  80;
                server_name 10.20.94.32;

                location /nginx_status {
                        stub_status on;
                        access_log   off;
                }
                location ~ ^/(php56fpmstatus)$ {
                        fastcgi_index index.php;
                        fastcgi_pass  unix:/dev/shm/php56-cgi.sock;
                        include fastcgi.conf;
                }

                location ~ ^/(php7fpmstatus)$ {
                        fastcgi_index index.php;
                        fastcgi_pass  unix:/dev/shm/php7-cgi.sock;
                        include fastcgi.conf;
                }
        }

        log_format main '{ "@timestamp": "$time_iso8601", '
                '"hostname": "$hostname", '
                '"server_name": "$server_name", '
                '"xes-app": "$upstream_http_server", '
                '"remote_addr": "$remote_addr", '
                '"remote_user": "$remote_user", '
                '"body_bytes_sent": $body_bytes_sent, '
                '"request_time": $request_time, '
                '"upstream_response_time": "$upstream_response_time", '
                '"status": $status, '
                '"upstream_status": "$upstream_status", '
                '"connection_requests": $connection_requests, '
                '"request": "$request", '
                '"request_method": "$request_method", '
               # '"request_body": "$request_body", '
                '"http_referrer": "$http_referer", '
                '"http_cookie": "$http_cookie", '
                '"http_x_request_id": "$http_x_request_id", '
                '"http_user_agent": "$http_user_agent" }';

        include vhost/*.conf;
    }
    ```
1. 平滑升级版本
   - 新老版本安装目录一致
   - 老版本备份：nginx -> nginx.old
   - reload重启
### 原理
1. 内存池，连接池，自旋锁，红黑树
1. 进程模型：管理进程(master)和工作进程(worker)
1. 模块化设计：主框架只提供核心代码，各模块继承同套标准接口规范和数据结构，模块进行分层，为核心/配置/事件/HTTP/mail
1. 事件驱动：event模块，采用红黑树管理事件定时器，支持各种事件驱动模型
1. 网络模型
   - apache是线程池实现多请求，占用资源多
   - nginx是io多路复用
### wiki
1. 版本
   - 1.13.10：支持grpc
1. nginx依赖
   - pcre：nginx的http模块使用pcre来解析正则表达式
   - zlib：提供了多种压缩/解压缩的方式。nginx使用zlib对http包的内容进行gzip
   - openssl
1. Lighttpd：web服务器，低内存开销、模块丰富、动态页面处理能力很强
1. HaProxy
   - 认识：基于tcp、http的提供高可用、高并发、负载均衡的应用代理。c语言编写，通过反向代理实现负载均衡，不是web服务器，是专门的应用代理
     1. 快速、免费、可靠
     1. 事件驱动、单一进程模型，可以支持很大的并发连接数
     1. 适用场景：需要会话保持、负载均衡的高并发、多连接数的场景
   - 功能
     1. 支持负载均衡，支持长连接，支持正则调度
     1. 支持添加cookie后调度，支持基于cookie调度
     1. 支持双向http的header数据增删改查
     1. 支持基于端口的监控、故障切换
     1. 支持停机模式、支持监控界面、监控api输出
     1. 支持虚拟主机