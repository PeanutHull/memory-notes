### 配置
1. ssh省去输入密码
   - ssh -kengen
   - cd ~/.ssh
   - ssh -copy-id peter@happypeter.net       // 把公钥复制到服务器上
1. vim
   - yy 复制当前行
   - dd 删除当前行，并复制
   - p 当前位置之后粘贴，之前粘贴P
   - :20 跳到20行
   - . 重复上一次命令
### 实操 
1. 判断是否是root用户
    ```bash
    #!/bin/bash
    test=$(env | grep USER | cut -d "=" -f 2)
    if [ "$test" == "root" ];then
        echo "you are root now"
    fi
    ```
1. 判断是否是目录
    ```bash
    #!/bin/bash
    read -t 30 -p "input a dir:" dir
    if [ -d "$dir" ]
        then
            echo "dir"
        else
            echo "not dir"
    fi
    ```
1. 批量解压缩脚本
    ```bash
    #! /bin/bash
    cd /root/test
    ls *.tar.gz > ls.log
    for i in $(cat ls.log)
        do
            tar -zxf $i &>/dev/null
        done
    ```
1. 判断apache是否启动
    ```bash
    test=$(ps aux | grep httpd | gerp -v gerp)              # 脚本名中是不能包括httpd关键字的，因为你得脚本也算进程
    /etc/rc.d/init.d/httpd start $>/dev/null                # 启动apache
    echo "aa" >> /tmp/err.log                               # 写入日志文件
    ```
1. 判断磁盘使用率
    ```bash
    #!/bin/bash
    test=$(df -h | grep sda5 | awk '{print $5}' | cut -d "%" -f 1)
    if [ "$test" -ge "90" ];then
        echo "sda5 is full"
    fi
    ```
### 解决方案
1. 进程守护
   - supervisor、Systemd、monit(还能性能监控等等)
   - 命令(nohup/Screen/Tmux)、Node工具(forever/nodemon/pm2)
   - 写锁(让工作进程和守护进程争抢写锁，当守护获得写锁时重启工作进程并放弃写锁))
1. supervisor
   - 认识：进程管理器，用于保证进程的自动重启等。通过fork/exec的方式将这些被管理的进程当作supervisor的子进程来启动，配置好进程命令即可，python写的
   - 配置
    ```
    [unix_http_server]
    file=/tmp/supervisor_zzg.sock                   ; UNIX socket 文件，supervisorctl 会使用
    chmod=0770                                      ; socket 文件的 mode，默认是 0700
    chown=zhaozhigang:www                           ; socket 文件的 owner，格式： uid:gid

    [inet_http_server]                              ; HTTP 服务器，提供 web 管理界面
    port=0.0.0.1:9568                               ; Web 管理后台运行的 IP 和端口，如果开放到公网，需要注意安全性
    username=resource                               ; 登录管理后台的用户名
    password=1a2s3dqwe                              ; 登录管理后台的密码

    [supervisord]
    logfile=/tmp/supervisord_zzg.log                ; 日志文件，默认是 $CWD/supervisord.log
    logfile_maxbytes=50MB                           ; 日志文件大小，超出会 rotate，默认 50MB
    logfile_backups=10                              ; 日志文件保留备份数量默认 10
    loglevel=info                                   ; 日志级别，默认 info，其它: debug,warn,trace
    pidfile=/tmp/supervisord_zzg.pid                ; pid 文件
    nodaemon=false                                  ; 是否在前台启动，默认是 false，即以 daemon 的方式启动
    minfds=1024                                     ; 可以打开的文件描述符的最小值，默认 1024
    minprocs=200                                    ; 可以打开的进程数的最小值，默认 200

    ; the below section must remain in the config file for RPC
    ; (supervisorctl/web interface) to work, additional interfaces may be
    ; added by defining them in separate rpcinterface: sections

    [rpcinterface:supervisor]
    supervisor.rpcinterface_factory = supervisor.rpcinterface:make_main_rpcinterface

    [supervisorctl]
    serverurl=unix:///tmp/supervisor_zzg.sock       ; 通过 UNIX socket 连接 supervisord，路径与 unix_http_server 部分的 file 一致
    ;serverurl=http://127.0.0.1:9001                ; 通过 HTTP 的方式连接 supervisord

    [program:zzg_worker]
    process_name=%(program_name)s_%(process_num)02d
    command=php /xdfapp/apps/develop/okayAdmin_zzg/artisan queue:work redis --daemon --delay=600 --sleep=1 --tries=1 --env=_zzg
    autostart=true
    autorestart=true
    user=zhangyunfei
    numprocs=4
    redirect_stderr=true
    stdout_logfile=/tmp/zzg_worker.log

    [include]
    ;files = /xdfapp/_zzg/*.conf
    ```
   - 启动
    ```
    supervisord -c supervisor.conf                                                          // 通过配置文件启动supervisor
    supervisorctl -c supervisor.conf status/reload//start/stop [all]|[x|zzg_worker]         // 查看状态/重新载入配置文件/启动停止所有一个
    ```
   - 其他配置
    ```
    [program:zzg_worker]
    process_name=%(program_name)s_%(process_num)02d
    command=php /xdfapp/apps/develop/okayAdmin_zzg/artisan queue:work redis --daemon --sleep=1 --tries=1 --env=_lj
    autostart=true
    autorestart=true
    user=zhaozhigang
    numprocs=1
    redirect_stderr=true
    stdout_logfile=/tmp/zzg_worker.log
    ```
1. Systemd
   - 背景：linux采用init进程启动服务，如`/etc/init.d/apache2 start`或`service apache2 start`，缺点为只能串行启动，只启动脚本，不管其他事情，如session信号通知，
   - 理解：linux系统自带，是操作系统一部分，直接与内核交互，性能出色、功能强大、面向目标，体系庞大复杂。给出目标及依赖条件即可执行。即将程序交给系统管理了，d是daemon的缩写，systemd取代initd，成为系统的第一个进程（PID等于1），其他进程都是它的子进程，EL7才能用
     1. 处理进程和服务
     1. 挂载文件系统
     1. 监控网络套接字(如动态开关进程)
     1. 运行时系统
   - 功能：处理时称之为单元，有单元类型
     1. 服务单元：控制unix上的传统服务守护进程
     1. 挂载单元：控制文件系统的挂载
     1. 目标单元：控制其余的单元，通常是通过将他们分组的方式
   - 使用：编写.service文件，通过设置参数决定某一命令的守护
1. VirtualBox安装虚拟机、连接网络
   - 安装：blog.csdn.net/risingsun001/article/details/37934975
   - 调通网络
     1. vi /etc/sysconfig/network-scripts/ifcfg-eth0
        ```
        NM_CONTROLLED=no
        ONBOOT=yes  #自动启动
        BOOTPROTO=dhcp  #动态IP
        ```
     1. service network start
   - 调通ssh：blog.csdn.net/risingsun001/article/details/38040451
1. 判断分支、提交develop、合并到release、自动递增tag号的shell脚本
    ```bash
    #!/bin/bash
    branch='develop';
    status=`git status`
    status=${status:9:8};
    # 判断是否在develop分支上
    if [ $status != $branch ];then
        git checkout develop;
    fi

    # 提交develop分支
    git pull;
    git add -A;
    git commit -m "$1";
    git push origin develop;

    # 提交release分支
    git checkout release;
    git pull;
    git merge develop;
    git push origin release;

    # 打tag
    res=`git tag -l`
    tag=`echo $res | awk -F ' ' '{print $NF}'`
    # 创建tag号
    # 三级版本号情况
    if [ ${#tag} = 6 ];then
        last=$[${tag:5:1}+1];
        newTag=${tag:0:5}$last;
    fi
    # 二级版本号情况
    if [ ${#tag} = 4 ];then

        newTag=${tag}'.1';
    fi
    # push tag
    git tag $newTag;
    git push origin tag $newTag;
    ```
