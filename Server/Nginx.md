### 认识
1. 原理：基于事件驱动，轻量级、高性能的http/反向代理/负载均衡服务器。C编写，官方测试5万并发。windows系统不能发挥全部的性能
1. 特点
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
### 应用
1. nginx.conf配置
    ```
    user                        www;                            # 用户和用户组
    worker_processes            8;                              # 进程数，建议设置为cpu核心数
    error_log                   /var/nginx/error.log;           # 全局错误日志，类型有debug|info|notice|warn|error|crit
    pid                         /var/nginx.pid;                 # 进程文件
    worker_rlimit_nofile        65535                           # 一个nginx进程打开的最多文件描述符数

    events {                                                    # 工作模式
        worker_connections      1024;                           # 单个进程最大连接数，最大连接数=连接数*进程数
        use epoll               kqueue|epoll|poll               # epoll模型是Linux2.6以上内核高性能网络I/O模型，如果FreeBSD用kqueue
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
1. server配置
    ```
    server {
        listen       80;
        listen       somename:8080;
        server_name  somename  alias  another.alias;

        location / {
            root   html;
            index  index.html index.htm;
        }

        location ~ \.php$ {                                                         # php-fpm
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }

        location ~* .(gif|png|jpg|jpeg|zip|apk)$ {                                  # 定向文件
            root   /mnt/opt/wecook-base/uploads;
            expires 7d;                                     // 缓存时间
            access_log off;
        }
        location ~* (^/statics/dishes/.*\.(html|js|css|eot|svg|ttf|woff)$){
            root /Users/Treri/project/wecook/mobile;
        }

        location / {                                                                # 重动向
            if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?s=$1  last;
                break;
            }
        }

        location / {                                                                # 反向代理，请求转发
            proxy_pass http://localhost:99;
            proxy_set_header Host $host;
            proxy_set_header X-Real-IP $remote_addr;
            proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            proxy_redirect off;
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
    }
    ```
1. gzip压缩：可在任何层级定义，越细优先级越高
    ```
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
1. 负载均衡：weight是权重，权值越高被分配到几率越大
    ```
    upstream somename {
        server 192.168.80.121:80 weight=3;              
        server 192.168.80.122:80 weight=2;
        server 192.168.80.123:80 weight=3;
    }
    server {
        location / {
            proxy_pass http://somename
        }
    }
    ```
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
1. 操作
   - 启动：`nginx`
   - 热重启：`nginx -s stop/reload`
### wiki
1. nginx依赖
   - pcre：Perl Compatible Regular Expressions，是Perl库。nginx的http模块使用pcre来解析正则表达式
   - zlib：提供了多种压缩/解压缩的方式。nginx使用zlib对http包的内容进行gzip
   - openssl
1. nginx层级：http{}、server{}、location{}