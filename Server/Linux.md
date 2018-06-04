### 基础
1. 系统安全：sudo、su、chmod、setfacl
1. 系统关机和重启：shutdown、reboot
1. 进程管理：w、top、ps、kill、pkill、pstree、killall
1. 用户管理：id、usermod、useradd、groupadd、groupdel
1. 文件
   - 文件系统：mount、umount、fsck、df、du
   - 文件查找比较：locate、find
     1. 全局查找指定文件名：find / -name fileName|'*name'
   - 文件内容查看：head、tail、less、more
   - 文件处理：touch、unlink、rename、ln、cat
   - 文件权限：setfacl、chmod、chown、chgrp
   - 文件传输：ftp、scp
1. 目录操作：cd、mv、rm、pwd、tree、cp、ls
1. 压缩解压：bzip2/bunzip2、gzip/gunzip、zip/unzip、tar
1. 网络
   - 网络应用：curl、telnet、mail、elinks
   - 网络测试：ping、netstat、host
   - 网络配置：hostname、ifconfig
1. 常用工具：ssh、screen、clear、who、date
1. 软件包管理：yum、rpm、apt-get
### 查看
1. 查看运行的进程：ps -ef/aux | grep xxx
1. 查看程序安装位置：which nginx
1. 查看端口号：lsof -i:80，root用户查看
1. 查看centos版本：cat /etc/redhat-release
1. 查看centos位数：getconf LONG_BIT
1. 查看ip：ifconfig -a中的inet addr
### 操作
1. 进程后台运行：processName &
1. 关闭应用程序
   - 从容停止：kill -QUIT MasterProcessNumber
   - 快速停止：kill -TERM MasterProcessNumber
   - 强制停止：kill -9 programName/nginx
1. 环境变量
   - /etc/profile：全局
   - .bash_profile：个人
   - source .bash_profile：使生效
   - export PATH=：书写格式
1. iptables
   - 编辑：`vim /etc/sysconfig/iptables`
   - 增加：`-A INPUT -m state --state NEW -m tcp -p tcp –-dport 80 -j ACCEPT`
   - 状态/重启/关闭：`/etc/init.d/iptables status/restart/stop`
1. 定时任务
   - crontab：添加 `crontab -e`，格式：* * * * *(分时日月周)
   - at：执行一次，`at 2:00 tomorrow`，`at>/home/job`
1. vim
   - 一般模式：用于删除、复制、粘贴
     1. x、X、dd、ndd、yy、nyy、p、P、ctrl+r
     1. 视图模式：v、V、ctrl+v、y、d
   - 编辑模式：i、a、r
   - 命令行模式：: / ?
     1. 查找和替换
     1. 配置：:setnu、:setnonu
1. 脚本执行
   - 加权限执行：chmod+x、./、source
   - 编写
     1. 解释器：bash、csh、ash、bsh、ksh
     1. 指定解释器：#!，如#!/bin/sh
### 应用
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
1. supervisor
   - 认识：进程管理器，用于保证进程的自动重启等。通过fork/exec的方式将这些被管理的进程当作supervisor的子进程来启动，配置好进程命令即可
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
   - 安装：`yum supervisor`
### 知识
1. SELinux：Security Enhanced Linux，安全强化Linux，是强制访问控制系统的一种实现，用于指明进程可以访问的资源，增强系统抵御0-Day的攻击
   - 特点：可查看、热更改、进程初始化/继承/执行三方面进行策略控制、控制范围包括文件系统/目录/文件/文件启动描述符/端口/消息接口/网络接口
   - 使用
     1. getenforce、/usr/sbin/sestatus -v：运行状态，Enforcing/Permissive/Disabled，记录警告并阻止/记录警告不阻止/禁用
     1. setenforce：Enforcing|Permissive|1|0，切换状态保持至关机，从Disabled切出时，要重启并重新创建安全标签(touch /.autorelabel && reboot)
     1. /etc/sysconfig/selinux、/etc/selinux/config：永久修改，修改后重启
1. 目录结构
   - 系统目录
     1. /：根目录，不要存放文件，/etc、/bin、/dev、/lib、/sbin应该和根目录在一个分区中
     1. /boot：启动文件存放
     1. /etc：系统配置文件
     1. /dev：设备文件
     1. /sbin：可执行命令
     1. /lib：函数库
     1. /srv：数据
     1. /var：数据经常变化
     1. /mnt：磁盘挂载点
     1. /proc：内存数据
   - 软件安装目录
     1. /opt：存放应用安装
     1. /usr：/usr/bin 存放应用程序，/usr/sbin 存放可执行文件，/usr/local 习惯安装应用程序
   - 其他目录：/home、/root、/tmp、/lost+fount
1. mac环境变量默认地址
   - /bin、/sbin：系统命令目录
   - /usr/bin、/usr/sbin：用户程序命令目录，如php、php-config、phpize、php-fpm
1. iTerm快捷键设置：Profiles->Keys
   - ctrl + a/e：移动到行首尾
   - ctrl + ←/→：单词移动，需设置`Send Escape Sequence + d/f`
   - shift + ←/→：单词选择，需设置`Move Start of Selection Left By Word`，`Move End of Selection Right By Word`
   - ctrl + w：单词删除
