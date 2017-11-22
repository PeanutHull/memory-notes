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
1. 基本操作
   - 启动
    ```
    cd usr/local/nginx/sbin
    nginx
    ```
   - 重启
    ```
    nginx -s reload                     # 热重启，重新加载文件
    ```
   - 关闭
    ```
    nginx -s stop
    ps -ef/aux | grep nginx
    kill -QUIT MasterProcessNumber      # 从容停止
    kill -TERM MasterProcessNumber      # 快速停止
    kill -9 nginx                       # 强制停止
    ```
1. 初始配置文件
1. 多域名配置
   - nginx.conf引入文件：bmp.local.conf
   - 写入bmp.local.conf如下内容，并修改域名
    ```
    server {
        listen 80;
        server_name bmp.local;
        root D:\PHPSTUDY\WWW\bmp;
        index index.html index.htm index.php;

        ### Gzip setting from nginx.conf
        gzip on;
        gzip_disable "msie6";
        gzip_vary on;
        gzip_proxied any;
        # gzip_comp_level 6;
        gzip_buffers 16 8k;
        gzip_http_version 1.1;
        gzip_static on;
        gzip_min_length 1024;
        gzip_types text/plain application/xml application/x-javascript application/javascript application/json text/javascript text/css;
        ###

        # location ~* (^/statics/dishes/.*\.(html|js|css|eot|svg|ttf|woff)$){
        #     root /Users/Treri/project/wecook/mobile;
        # }

        location ~ /\.(git|svn|vcs)/ {
            return 404;
        }

        location / {
            if (!-e $request_filename) {
                rewrite  ^(.*)$  /index.php?s=$1  last;
                break;
            }
        }

        location ~ \.php$ {
            fastcgi_pass   127.0.0.1:9000;
            fastcgi_index  index.php;
            fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
            include        fastcgi_params;
        }
    }
    ```
   - 最简单域名配置
    ```
    server {
        listen       80;
        server_name  test3.taotao.com;

        #charset koi8-r;

        #access_log  logs/host.access.log  main;

        location / {
            root   html;                            # 根目录，相对于nginx的安装目录？？？
            index  index.html index.htm;
        }
    }
    ```
1. 重定向文件
    ```
    location ~* .(gif|png|jpg|jpeg|zip|apk)$ {
        root   /mnt/opt/wecook-base/uploads;
        expires 7d;
        access_log off;
    }
    ```
1. 反向代理，即请求转发，可以转向其他端口或地址
    ```
    server {
        listen 80;
        server_name 127.0.0.1;
        location / {
                proxy_pass http://localhost:99;
            #   proxy_set_header Host $host;
            #   proxy_set_header X-Real-IP $remote_addr;
            #   proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
            #   proxy_redirect off;
        }
    }
    ```
1. 更新nginx的yum源，官方提供的packages
    ```
    // 创建/etc/yum.repos.d/nginx.repo
    // 写入以下内容
    // 注意修改OS和OSRELEASE，如centos6则把OS改成centos, OSRELEASE改成6
    [nginx]
    name=nginx repo baseurl=http://nginx.org/packages/mainline/OS/OSRELEASE/$basearch/ gpgcheck=0
    enabled=1
    // 更新yum缓存并安装
    yum makecache
    yum install -y nginx
    ```
1. 安装时的依赖
   - PCRE：Perl Compatible Regular Expressions，是Perl库。nginx的http模块使用pcre来解析正则表达式
   - zlib：库提供了很多种压缩和解压缩的方式。nginx使用zlib对http包的内容进行gzip
   - openssl：