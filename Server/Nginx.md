### 认识
1. 原理：基于事件驱动，轻量级、高性能的http/反向代理/负载均衡服务器。C语音编写，官方测试5万并发。windows系统不能发挥全部的性能
1. 特点
   - 资源消耗低，运行稳定，并发高
   - 分阶段资源分配技术，cpu/内存占用率低
   - 静态文件可开启索引和描述符缓冲
   - 简单的负载均衡
   - 支持热部署
   - 不支持cgi
1. 使用场景
   - 静态资源服务器：如js、css、images等
   - 虚拟主机：实现一台服务器虚拟出多个网站
   - 反向代理/负载均衡
### 使用
1. 默认配置
   - 表现：nginx.conf，`http {...}`，
   - 顶级配置
     1. user www：用户和用户组
     1. worker_processes 8：进程数，建议设置为cpu核心数
     1. error_log logs/error.log info：全局错误日志，位置和类型(debug|info|notice|warn|error|crit)
     1. pid logs/nginx.pid：进程文件
     1. worker_rlimit_nofile 65535：一个nginx进程打开的最多文件描述符数目，理论值是最多打开文件数与nginx进程数相除，但nginx分配请求并不均匀，所以建议与系统的值(ulimit -n)的值保持一致
     1. include：载入其他配置文件
   - events：工作模式
     1. use epoll：kqueue|rtsig|epoll|/dev/poll|select|poll，epoll模型是Linux2.6以上内核的高性能网络I/O模型，如果跑在FreeBSD上用kqueue
     1. worker_connections 65535：单个进程最大连接数，最大连接数=连接数*进程数
   - http：服务器配置
     1. include mime.types：
     1. default_type application/octet-stream：
     1. client_header_buffer_size 32k/large_client_header_buffers 4 64k：
     1. client_max_body_size 8m：
     1. sendfile on：高效文件传输模式，指定nginx是否调用sendfile函数来输出文件，普通应用为on，下载等应用磁盘IO重负载应用可为off，以平衡磁盘与网络I/O处理速度，降低系统的负载。如果图片显示不正常改成off
     1. autoindex on：目录列表访问，默认关闭
     1. tcp_nopush/tcp_nodelay on：防止网络阻塞
     1. keepalive_timeout 120：长连接超时时间，单位是秒
1. 虚拟host配置
   - 初始配置
        ```
        server {
            listen       80;
            listen       somename:8080;
            server_name  somename  alias  another.alias;

            location / {
                root   html;
                index  index.html index.htm;
            }
        }
        ```
   - php-fpm配置
        ```
        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
        ```
   - 定向文件
        ```
        location ~* .(gif|png|jpg|jpeg|zip|apk)$ {
            root   /mnt/opt/wecook-base/uploads;
            expires 7d;                                     // 缓存时间
            access_log off;
        }
        location ~* (^/statics/dishes/.*\.(html|js|css|eot|svg|ttf|woff)$){
            root /Users/Treri/project/wecook/mobile;
        }
        ```
   - 重动向
        ```
        location / {
            if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?s=$1  last;
                break;
            }
        }
        ```
   - gzip压缩
        ```
        gzip on;
        gzip_static on;        
        gzip_min_length 1k/1024;                        // 最小压缩文件大小
        gzip_http_version 1.1;                          // 压缩版本，默认1.1
        gzip_buffers 16 8k;                             // 压缩缓冲区
        gzip_comp_level 6;                              // 压缩等级
        gzip_types text/plain application/x-javascript application/javascript application/json text/javascript text/css;
        gzip_disable "msie6";
        gzip_vary on;
        gzip_proxied any;
        limit_zone crawler $binary_remote_addr 10m;     // 开启限制IP连接数的时候需要使用
        ```
   - 反向代理，请求转发
        ```
        location / {
                proxy_pass http://localhost:99;
                proxy_set_header Host $host;
                proxy_set_header X-Real-IP $remote_addr;
                proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
                proxy_redirect off;
        }
        ```
   - 负载均衡：weight是权重，权值越高被分配到几率越大
        ```
        upstream somename {
            server 192.168.80.121:80 weight=3;              
            server 192.168.80.122:80 weight=2;
            server 192.168.80.123:80 weight=3;
        }
        ```
   - 错误页面
        ```
        error_page   500 502 503 504  /50x.html;
        location = /50x.html {
            root   html;
        }
        ```
   - 拒绝
        ```
        location ~ /\.ht {
            allow 127.0.0.1/24;
            deny  all;
        }
        location ~ /\.(git|svn|vcs)/ {
            return 404;
        }
        ```
### 运维
1. 安装nginx
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
1. 基本操作
   - 启动：`usr/local/nginx/sbin/nginx|./nginx`
   - 热重启：`nginx -s reload`
   - 关闭：`nginx -s stop`
1. 初始配置文件
### wiki
1. nginx依赖
   - PCRE：Perl Compatible Regular Expressions，是Perl库。nginx的http模块使用pcre来解析正则表达式
   - zlib：提供了多种压缩/解压缩的方式。nginx使用zlib对http包的内容进行gzip
   - openssl