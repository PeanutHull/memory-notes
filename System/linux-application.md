### 运维
1. 软件安装
   - RedHat
     1. rpm：以.rpm结尾的软件包名称，方便安装/升级/卸载，不能处理包依赖
        - -i：安装
        - -ivh：安装，显示文件信息，显示安装进度
        - -q：查询
        - -q afilcdR：查询已安装的，文件名绝对路径，安装包信息，安装目录，配置文件，文档位置，所依赖的文件
        - -qpi：查询未安装的，版本信息
        - -e：卸载，先用-q查询名称
        - -U：升级
        - -Uvh：升级，显示文件信息，显示安装进度
        - –requires：显示依赖信息
        - --import：签名导入
     1. yum：Yellow dog Updater Modified，包管理工具，基于rpm，epel是yum的扩展源
        - 参数
          1. search
          1. install/update/remove
          1. list/info installed/updates
        - 查看安装的服务：`rpm -qa | grep bind`
        - 查看安装的位置：`rpm -ql bind`
        - 配置yum源：配置分两部分，全局配置项为/etc/yum.conf，定义每个源/服务器的具体配置在/etc/yum.repo.d的rep文件
   - Debian
     1. deb/dpkg：软件包名称，比rpm晚，`dpkg -l`
     1. apt-get：包管理工具，基于deb。`install/remove/purge`
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
1. 运维
   - 组成
     1. 基础：配机器
     1. 私有云：openstack
     1. 监控
     1. 网络
     1. 开发：配套工具和功能开发
   - 分类
     1. 监控
     1. 部署
        - openstack：用于管理基础设施的一系列开源项目组成的平台
          1. Neutron：flat\flatdhcp\vlan，网络服务
          1. Horizon：可视化、ui服务
          1. Cinder/Swift：存储服务
          1. Nova：计算服务
          1. Glance：镜像服务
          1. Keystone：认证、身份服务
          1. Heat：编排组织服务
          1. Ceilometer：监控计量服务
        - 远程控制：saltstack，分主从，salt-master和salt-minion
     1. cmdb
   - 技术
     1. nat：网络地址转换服务，可基于状态过滤连接（就是内网出去的能回来，其他进不来），可做对外网的口子
     1. lvm：逻辑卷管理，动态扩缩容
     1. DNS：智能dns，DNS view，可根据用户ip返回不同的ip，解决了同域名不同解析地址问题，使用bind 9
### 应用
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
   - x、X、ndd、nyy、p、P、ctrl+r
   - 视图模式：v、V、ctrl+v、y、d
   - 编辑模式：i、a、r
   - 命令行模式：: / ?
   - 查找和替换
   - 配置：:setnu、:setnonu
### 优化
1. 查看系统性能
   - ps
   - top：`man top`
     1. shift+p：占用cpu最高的进程
     1. top -Hp 进程号：占用CPU最高的线程
   - free：-m
   - vmstat：3 3秒更新一次
   - sar
   - mpstat
1. 问题定位
1. 问题解决
### 解决方案
1. 进程守护
   - supervisor、systemd、monit(还能性能监控等等)
     1. supervisor：进程管理器，用于保证进程的自动重启等。通过fork/exec的方式将这些被管理的进程当作supervisor的子进程来启动，配置进程命令即可，python写的
        - 配置
            ```conf
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
            supervisord -c supervisor.conf                                                       // 通过配置文件启动supervisor
            supervisorctl -c supervisor.conf status/reload/start/stop [all]|[x|zzg_worker]       // 查看状态/重新载入配置文件/启动停止所有一个
            ```
        - 其他配置
            ```conf
            [program:zzg_worker]
            process_name=%(program_name)s_%(process_num)02d
            command=php /xdfapp/develop/okayAdmin/artisan queue:work redis --daemon --sleep=1 --tries=1 --env=_lj
            autostart=true
            autorestart=true
            user=zhaozhigang
            numprocs=1
            redirect_stderr=true
            stdout_logfile=/tmp/zzg_worker.log
            ```
     1. Systemd
        - 背景：linux采用init进程启动服务，如`/etc/init.d/apache2 start`或`service apache2 start`，缺点为只能串行启动，只启动脚本，不管其他事情，如session信号通知
        - 理解：linux系统自带，是操作系统一部分，直接与内核交互，性能出色、功能强大、面向目标，体系庞大复杂。给出目标及依赖条件即可执行。即将程序交给系统管理了，d是daemon的缩写，systemd取代initd，成为系统的第一个进程（PID等于1），其他进程都是它的子进程，EL7才能用
          1. 处理进程和服务
          1. 挂载文件系统
          1. 监控网络套接字(如动态开关进程)
          1. 运行时系统
     1. 功能：处理时称之为单元，有单元类型
          1. 服务单元：控制unix上的传统服务守护进程
          1. 挂载单元：控制文件系统的挂载
          1. 目标单元：控制其余的单元，通常是通过将他们分组的方式
     1. 使用：编写.service文件，通过设置参数决定某一命令的守护
   - 命令(nohup/Screen/Tmux)、Node工具(forever/nodemon/pm2)
   - 写锁(让工作进程和守护进程争抢写锁，当守护获得写锁时重启工作进程并放弃写锁))
1. DNS
   - 理解：域名解析服务，域名和ip的绑定查询，一级级的往上查询
     1. 域名：.(根域)，com(一级域名)，二级三级...
     1. 解析记录分类
        - A记录：单一指向ip
        - CNAME记录：多个域名到ip，也有域名到域名
        - MX记录：不返回权威解析
        - NS记录：针对邮件服务解析，配合A记录
     1. dns解析
        - 正向查询：A记录，域名找ip
        - 反向查询：PTR记录，ip找域名
        - 迭代查询：服务器角度，是否多次查询
        - 递归查询
   - 组成
     1. bind服务
        - 理解：加州大学开发的开源、稳定、应用广泛的dns服务
          1. 组成：域名解析服务、权威域名解析服务(级级查询中最终提供ip的服务)、dns工具
        - 安装：`yum install bind bind-chroot`，`apt-get install bind9`
        - 配置：options、logging、zone dns域解析
          1. 配置域名
            ```shell
            // named.conf
            zone "imooc.com" {                                                      // 一个域名一个 
                type master;                                                        // 主从配置
                file "imooc.com.zone";
            }
            // imooc.com.zone，@是保留字，表示当前域名
            $TTL 7200
            imooc.com. IN SOA imooc.com. jeson.imooc.com. (222 1H 15M 1W 1D)        // 解析域的开始
            imooc.com. IN NS dns1.imooc.com.
            dns1.imooc.com. IN A 10.10.10.135
            www.imooc.com IN A 2.2.2.2                                              // 解析了一个ip
            // 查询命令
            dig @ 10.10.10.135 www.imooc.com
            nslookup www.imooc.com
            ```
        - 应用场景
     1. bind负载均衡
        - dns转发：子域授权
        - dns主从模式：主从传输、主从同步、数据加密、事务签名
        - dns传输限制
     1. 智能dns
        - 理解：能够基于IP信息给不同的用户最合适的服务器IP，关键在于搭建ip库，提供完整准确的ip地址和位置，由第三方、isp、APINC提供。即把地理位置和dns解析服务器绑定一起，不用走多余的网络路线
          1. 特点：减少动态服务响应延迟，cdn加速，负载均衡，防止ddos
        - 攻击
          1. dns污染：dns劫持
          1. ddos
          1. 放大攻击：dns服务器被作为肉鸡
     1. CDN：：内容分发网络，部署大量网络节点通过服务器缓存加速，让用户就近更快访问网络。指标有带宽、命中率、请求数
### shell
1. 理解：壳，命令行解释器，利用ASCII码表转换将命令传给内核，敲命令的界面就是shell。支持命令执行、条件判断、循环控制
1. 运算符：expr、let
1. 变量
   - 声明
     1. declare————声明变量类型
     1. declare +/-X 变量名
   - 选项
     1. -    给变量设定类型属性
     1. +    取消变量类型属性
     1. -a   声明为数组型
     1. -i   整数型int
     1. -x   环境变量
     1. -r   只读变量
     1. -p   显示被声明的类型，不加变量参数的话查询所有的
   - 分类
     1. 环境变量：作用———定义每个用户的操作环境。如PATH、ps1。有环境变量的配置文件
     1. 预定义变量
     1. 位置参数变量
     1. 用户自定义变量(本地变量)
   - 实例
    ```bash
    aa=11                    # 整型
    bb=22
    cc=$aa+$bb
    echo cc                  # 结果为11+22
    declare -i cc=$aa+$bb    # 为33
    # 数组型
    movie[0] = cl
    echo ${movie[0]}
    echo ${movie}
    ```
1. 流程控制
   - 判断
     1. if
        ```bash
        # 写法1
        if [ 条件 ];then
        fi
        # 写法2
        if [ 条件 ]
            then
        else
        fi
        # 写法3
        if [ 条件 ]
            then
        elif [ 条件 ]
            then
        else
        fi
        ```
     1. case
        ```bash
        case $var in
            "value1")
                ;;
            "value2")
                ;;
            "*")
                ;;
        esac
        ```
   - 循环
     1. for
        ```bash
        for 变量 in 值1 值2 值3
            do
                命令
            done
        ```
     1. while/until
        ```bash
        while [ 条件判断式 ]
            do
                命令
            done
        ```
1. 判断
   - 文件判断
     1. 判断文件类型
        ```
        方法1(推荐)：[-X /root/install.log]
        方法2：test -X /root/install.log
        参数：
        -b 是否存在,块设备文件
        -c 是否存在,字符设备文件(一切皆文件)
        -e 是否存在
        -d 是否存在,目录
        -f 是否存在,普通文件
        -L 是否存在,符号链接文件
        -p 是否存在,管道文件
        -s 是否存在,是否为空
        -S 是否存在，套接字文件
        // 例
        [-d /root] && echo "yes" || echo "no"     // 如果为真则yes
        ```
     1. 文件权限
        ```
        -r 是否存在，是否有读权限
        -w 是否存在，写
        -x 是否存在，执行
        -u 是否存在，是否有SUID
        -g 是否存在，SGID
        -k 是否存在，SBit
        // 例
        [-d /root]    // 只要有读的等就为真，要是判断用户和用户组的需要自己截取权限位
        ```
     1. 两个文件比较
        ```
        文件1 -nt 文件2      修改时间1是否比2新
        文件1 -ot 文件2      修改时间1是否比2旧
        文件1 -et 文件2       判断Inode号是否一致，即是否同一文件，用来判断硬链接
        // 例
        [ /root/a.log -ef /tmp/b.log]
        ```
   - 常量判断
     1. 整型比较
        ```
        [ num1 -eq num2]
        -ne 不相等
        -gt 大于
        -lt 小于
        -ge 大于等于
        -le 小于等于
        ```
     1. 字符串比较
        ```
        -z string   是否为空
        -n string   是否非空
        == 相等
        != 不等
        // 例子：
        aa=11 bb=22
        [ "$aa" == "$bb" ] && echo "yes" || echo "no"        // no，不等
        ```
     1. 多重条件判断
        ```
        判断1 -a 判断2   逻辑与
        判断1 -o 判断2   逻辑或
        ！ 判断          逻辑非
        例子：
        aa=11
        [ -n "$aa" -a "$aa" -gt 23 ] && echo "yes" || "no"
        ```
1. 引用
   - 理解：通知shell将特殊字符当做普通字符来使用
   - 分类
     1. 转义字符：\
        - `mv abc\?\* abc`：将abc?*重命名为abc
        - `mv C\:\\backup backup`：将C:\backup重命名为backup
     1. 单引号 ''，单引号中的所有字符串的特殊意义都被忽略
        - `mv 'C:\backup'  backup`
     1. 双引号 ""
        ```shell
        // $、\和`在双引号中不能被转成普通意义
        str="The \$SHELL Current shell is $SHELL"
        str1="\$$SHELL"
        echo $str
        The $SHELL Current shell is /bin/bash
        echo $str1
        $/bin/bash
        从上面可以看出，$和\在双引号内仍然保留了特殊含义。
        str="This hostname is `hostname`" 
        echo $str
        This hostname is WEBServer
        ```
1. 知识
   - 查看shell版本：`echo $SHELL`
   - 注释：#
   - 进入sh的shell：`sh`
   - 解释器：bash、csh、ash、bsh、ksh
   - 指定解释器：#!，如#!/bin/sh
   - 主要语法类型，彼此不兼容
     1. Bourne：包括标准的Bash、sh、ksh、psh、zsh
     1. C：包括csh、tcsh。C shell主要在Unix中使用，语法有较大区别
   - 指定解析器：#!/bin/bash #!/usr/bin/env bash/python/ruby
   - 语句即命令，命令就是语句
   - shell语法不重要，实现功能即可，不用考虑多人访问
   - $n 表示第n个参数，$#表示参数总个数
   - 脚本执行
     1. ./a.sh           当前脚本不会更换路径
     1. bash hello.sh
     1. source a.sh      会改变当前的路径，在当前的shell执行，脚本在另一shell中执行看不见
   - 不同shell稍稍不同，shell的语法分析是指对命令的扫描处理过程
   - shell命令格式：command [options] [arguments] ------命令本身+选项+操作对象即参数
    ```
    ls–a –l
    // 也可写成
    ls -al
    // 加上参数
    ls –al  /etc
    // 一行输入多个命令用;隔开
    // 一个命令多行用\持续
    ```
   - 找出占用cpu最高的线程：`ps -eo %cpu,pid |sort -n -k1 -r (第一列倒序排序)| head -n 1 (取第一行)|  awk '{print $2}' (取第二列)|xargs  top -b -n1 -Hp | grep COMMAND -A1 (后面一行)| tail -n 1 (取最后一行)| awk '{print $1}' | xargs printf 0x%x`
     1. 在命令行输入top，然后shift+p查看占用CPU最高的进程，记下进程号
     1. 在命令行输入top -Hp 进程号，查看占用CPU最高的线程
     1. 使用printf 0x%x 线程号，得到其16进制线程号
     1. 使用jstack 进程号得到java执行栈，然后grep16进制找到相应的信息
1. demo
   - 判断是否是root用户
        ```bash
        #!/bin/bash
        test=$(env | grep USER | cut -d "=" -f 2)
        if [ "$test" == "root" ];then
            echo "you are root now"
        fi
        ```
   - 判断是否是目录
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
   - 批量解压缩脚本
        ```bash
        #! /bin/bash
        cd /root/test
        ls *.tar.gz > ls.log
        for i in $(cat ls.log)
            do
                tar -zxf $i &>/dev/null
            done
        ```
   - 判断apache是否启动
        ```bash
        test=$(ps aux | grep httpd | gerp -v gerp)              # 脚本名中是不能包括httpd关键字的，因为你得脚本也算进程
        /etc/rc.d/init.d/httpd start $>/dev/null                # 启动apache
        echo "aa" >> /tmp/err.log                               # 写入日志文件
        ```
   - 判断磁盘使用率
        ```bash
        #!/bin/bash
        test=$(df -h | grep sda5 | awk '{print $5}' | cut -d "%" -f 1)
        if [ "$test" -ge "90" ];then
            echo "sda5 is full"
        fi
        ```
   - git：判断分支、提交develop、合并到release、自动递增tag号
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
