### Linux
1. 特点
   - 一切皆文件
   - 对后缀不敏感
### 文件、目录
1. 查看
   - 目录
     1. pwd
     1. ls [dir]：查看当前或指定目录。-l：列表详细查看，-lh：以兆查看文件大小
   - 文件
     1. stat：查看文件详情信息，修改时间、Inode、Links数等
     1. file：查看文件属性
   - 搜索
     1. find：查找具有某些特征的文件或目录，可遍历整个文件系统。`find pathname -options`：路径+命令选项
        - -type：f文件，d目录，p管道文件，i符号链接文件，b块设备文件，e字符设备文件
        - -name：按照文件名查找
        - -print：显示文件名
        - -depth：查找层级
        - -mtime -n +n：按照修改时间查找，-n表示距现在n天以内，+n表示距现在n天以前，还有atime、ctime
        - -newer file1 !file2：查找更改时间比file1新，但比file2旧的
        - -exec：执行操作
        - -perm：按照文件权限查找
        - -user：按照文件属主查找
     1. locate：系统全局范围定位文件，从database中查找数据。一般一天更新一次，更新文件数据库`updatedb`。-r：正则
     1. whereis
1. 操作
   - 目录切换
     1. cd：回到用户主目录
     1. cd ../../：连续向上
     1. cd -：回到上一次的目录
   - 创建
     1. mkdir
        - -p dir/dir：递归创建
     1. vi/vim file
     1. touch file
   - 删除
     1. rm
        - -r dir：删除目录
        - 文件防删除：chattr +i|-i file：加/解除提醒
   - 复制
     1. cp
        - -r dir1 dir2：递归复制
   - 移动
     1. mv file|dir dir/
     1. rename
   - 链接
     1. ln/link：文件或目录，默认硬链接
        - 硬链接：多个路径指向一个inode号，最后inode号删除才删除文件，可防止误删除
        - 软连接：-s，即符号链接，类似快捷方式
     1. unlink
1. 查看内容
   - cat：查看文件内容
     1. `cat file1 file2`：同时查看两个文件
     1. `cat -n file | grep ''| more`：分页查看
     1. `cat file > xxx.txt`：将显示结果保存到文件
     1. `cat -n file | tail -n +92 | head -n 20`：92行之后的查询结果中显示前20
   - head/tail：输出文件头/尾
     1. -n：行数
     1. -f：tail不停显示
   - less/more：分页查看内容，less在另一屏打开，不占用当前屏幕内容
     1. -M：显示更多文件信息：页码等
     1. enter：下一行
     1. space：下一屏
     1. B：上一屏
     1. /：字符查找，n查找下一次，gg到文件头，G到文件尾，q退出
   - awk：
     1. 认识：从文件或字符串中基于指定规则浏览和抽取信息，是一种自解释的编程语言。`awk [options] 'command' files`。三剑客：awk sed grep
     1. awk脚本：用awk命令解释器作为脚本的首行，以便通过键入脚本名称来调用它
     1. 域标识：浏览域，标记为$1/$2/$n，$0为所有域
     1. 使用
        - 输出所有行
          1. `awk '{print $0}' file`
          1. `awk -F : '{ print $1 }' file`：只是以:作为分隔符
        - 给结果加上头尾字符串：`awk 'BEGIN {print "begin\n"}{print $1 "\t" $4} END{print "end"}' file`
        - 匹配第一个行是xx：`awk '{if($1=="xx") print $0}' file`
   - sed
     1. 认识：文本过滤工具，是一种非交互性的文本流编辑
     1. 运行方式：`sed [options] 'command' files`，脚本执行方式：`sed[options] -f sed脚本文件`
     1. 查找文本方式：行号(可范围)，正则
     1. 选项
        - -n：只打印匹配信息
     1. 操作模式：替换c\，删除d，后附加a\，打印p，显示行号h，前插入i\，
     1. 使用
        - `sed '2,4p' file`：打印2到4行
        - `sed '/xx/p' file`：匹配并打印
        - `sed '/xx/a\XX' file`：匹配到xx后附加XX
        - `sed '2,/xx/p' file`：从第二行开始直到正则匹配第一个并打印
        - `sed '2,4d' file`：删除2到4行
   - grep：过滤作用，`grep [options] '基本正则表达式' file`
     1. -n：只显示匹配行及其行号
     1. -c：只输出匹配行的数量
     1. -i：不区分大小写（只适用于单个字符）
     1. -H：只显示文件名
   - cut：内容查看、删除指定部分
     1. -b：指定范围
     1. -c：指定行显示，如-c1-3为1到3行
     1. -d：指定字段分隔符
     1. -f：显示指定字段
   - wc：Word Count，统计文件或输入
     1. -c：字节数
     1. -l：行数
     1. -m：字符数
     1. -w：字数
   - sort：排序显示
     1. -u：删除同样行
     1. -r：逆序
     1. -c：测试文件是否已排序
     1. -m：合并两个排序文件
     1. -o：存储sort结果的输出文件名
     1. -t：域分隔符，用非空格或tab开始排序
     1. +n：n为列号，使用此列号开始排序
     1. -n：指定排序是域上的数字分类项
   - uniq：过滤显示
     1. -u：只显示不重复行
     1. -d：只显示有重复数据行
     1. -c：打印每一重复行出现次数
   - join：连接显示 
   - split：切割显示
     1. -l，每个分割文件的行数，-n同-l
     1. -b，每个分割文件的大小n
     1. -C，每个分割文件一行最多n字节
   - cut：截取显示
     1. -c n-m：截取的字符范围，单位字符
   - diff：查看文件差异
1. wiki
   - .开头的文件和目录都是隐藏的
   - 目录为蓝色，-l参数下-为文件、d为目录、l为符号链接
### 用户、权限
1. 用户和用户组
   - 查看
     1. /etc/passwd
     1. /etc/group
     1. who、w：显示当前用户，w更加详细
   - 管理
     1. id
     1. useradd/usermod
     1. groupadd/groupmod/groupdel
   - 操作
     1. passwd：修改密码
1. 权限
   - 认识
     1. 分类：r、w、x
     1. 目录含义
        - r：可查看目录下内容
        - w：对目录里文件进行创建、删除、重命名等操作
        - x：可进入到目录中
     1. 文件模式：即rwxr-r--
   - 操作
     1. chmod：改变权限，以8进制控制文件模式
     1. chown：改变所有者和组
        - -R：递归修改
        - +x：添加
     1. owner
     1. group
     1. setfacl
     1. chgrp
     1. su/sudo
### 内存
1. free
   - -m 以兆显示内存状态
### 网络
1. 查看
   - ping
   - traceroute：显示网络数据包传输到指定主机的路径信息，追踪数据传输路由状况
   - ifconfig：显示当前网络接口状态、配置网络
     1. -a：inet addr，ip地址
   - nethogs: 将进程按网络流量列表显示
   - lsof：list open files，列出打开文件。linux环境下任何事物都以文件的形式存在
     1. i:80：查看端口号，root用户查看
   - netstat：显示网络连接/运行端口/路由表等
     1. anpt：查看端口占用，`netstat anpt | grep 80`
   - ss：Socket Statistics，用来获取socket统计信息，显示和netstat类似，优势在于能显示更详细的TCP和连接状态的信息，比netstat更快速更高效
   - host
   - dig
     1. 认识：从DNS域名服务器查询主机地址信息
   - telnet ip port：检测端口是否打开
1. 配置
   - /etc/sysconfig/network-scripts/ifcfg-eth0
   - hostname
1. 防火墙
   - iptables
     1. 编辑：`vim /etc/sysconfig/iptables`
     1. 增加：`-A INPUT -m state --state NEW -m tcp -p tcp –-dport 80 -j ACCEPT`
     1. 状态/重启/关闭：`/etc/init.d/iptables status/restart/stop`
   - centos7防火墙配置
     1. 添加端口：firewall-cmd --zone=public --add-port=80/tcp --permanent
     1. 查看端口：firewall-cmd --zone=public --list-ports
     1. 开关：systemctl start/disable/restart firewalld
1. 功能
   - telnet：使用telnet协议通信
   - curl
     1. -X POST
     1. -x '127.0.0.1：80'
     1. -H 'CONTENT-TYPE:application/json' -H 'traceid:123abc'：多个就写多个-H
     1. -d '{"id":xx}'
   - elinks
   - 数据传输
     1. rsync
        - 认识：linux的文件备份、同步工具
          1. 计算源文件和目标文件的差异，仅同步差异（因为全量成本高）
          1. 压缩、解压数据以进一步提高速度
        - 命令行
          1. -r：同步
          1. -av：同步文件，删除--delete
     1. scp
        - 上传：scp [-r] local addr@ip:/addr
        - 下载：scp [-r] addr@ip:/addr local
     1. rcp
     1. ftp
     1. ssh
        - ssh addr@ip
     1. sz/rz
1. 参数
   - 查看
     1. SYN queue：`/proc/sys/net/ipv4/tcp_max_syn_backlog`
     1. Accept queue：`/proc/sys/net/core/somaxconn`或/etc/sysctl.conf的`net.core.somaxconn=128`
     1. 重传SYN+ACK次数：`net.ipv4.tcp_synack_retries`：默认为5，表示重发5次，每次等待30~40秒，即半连接默认时间大约为180秒
   - 操作
     1. 查看SYN queue溢出：`netstat -s | grep LISTEN`
     1. 查看Accept queue溢出：`netstat -s | grep TCPBacklogDrop`
1. wiki
   - 端口号1024以下是系统保留的，总共65526个
### 磁盘
1. mount/umount：挂载
   - /dev/sd*：设备文件，`mount /dev/sda1 /mnt/sda1`
1. df：查看磁盘占用情况
1. dlkid
1. du
1. fsck：检查文件系统，并尝试修复
1. mkfs
1. fdisk
1. parted
1. lvreduce
1. iotop: 将进程按磁盘写次数排序，并且显示程序写磁盘的次数和频率
1. 文件系统
   - 文件树：一根文件数，根目录为/
   - 分区：sda1、sda2
     1. swap分区：交换区，物理内存不够时，将不用的内存数据放到这个分区。分的大了浪费小了影响性能，小内存为2倍，大内存(8G)相等
        - swappiness：使用权重，复杂算法
        - swapon：启用，-s，查看swap相关信息
        - swapoff：关闭/回收
        - mkswap：格式化
   - 挂载点：把sda1挂载到根目录/上，则所有数据都在sda1分区。当sda2挂载到/home，则数据到了sda2的分区下
1. linux规定，硬盘用sda/sdb/sdc依次命名，一块硬盘只能存在4个主分区，为sda1/sda2/sda3/sda4，逻辑分区不限制数量，从5开始
### 进程
1. 运行
   - 后台运行：xx &
   - 断开shell继续运行：因为shell断开进程收到SIGHUP，该信号的默认处理导致进程终止，进程不终止主要是处理SIGHUP信号
     1. 未运行
        - `nohup xx &`
        - `setsid xx &`
     1. 已运行
        - disown
            ```shell
            $ xx &
            [1] 2222
            $ disown -h %1
            ```
        - `screen -dmS|-r xx`
        - subshell：实质为子进程执行方式，通常为fork
        - `trap "" SIGHUP SIGINT | trap SIGHUP SIGINT | trap "" 1 2 | trap : 1 2`
1. 查看
   - which：查看程序安装位置
   - ps：显示系统运行状态
     1. aux：pid，process ID，进程号
   - top：查看活跃进程
     1. VIRT：virtual memory usage 虚拟内存
        - 进程“需要的”虚拟内存大小，包括进程使用的库、代码、数据等
        - 假如进程申请100m的内存，但实际只使用了10m，那么它会增长100m，而不是实际的使用量
     1. RES：resident memory usage 常驻内存
        - 进程当前使用的内存大小，但不包括swap out
        - 包含其他进程的共享
        - 如果申请100m的内存，实际使用10m，它只增长10m，与VIRT相反
        - 关于库占用内存的情况，它只统计加载的库文件所占内存大小
     1. SHR：shared memory 共享内存
        - 计算某个进程所占的物理内存大小公式：RES – SHR
        - pstree
        - pidof：打印pid
   - 查看/设置允许打开的最大文件句柄数：`ulimit -n xx`，重启或用户退出失效
1. 杀死
   - 分类
     1. kill：发信号
     1. killall：按照名字消灭进程
     1. pkill：根据名字和其它属性查看、发出信号
     1. skill：发送信号、报告进程状态
   - 参数
     1. -USR2 pid
     1. -QUIT：从容
     1. -TERM：快速
     1. -9 pid：强制
   - 应用
     1. 杀死僵死进程：`ps -ef | grep defunct | grep -v grep | cut -b8-20 | xargs kill -9`
     1. 杀死所有fpm：`ps -ef | grep php-fpm | awk -F ' ' '{print $2}' | xargs kill -9`
1. systemctl
1. 参数
   - 查看内核所能打开的线程数：`cat /proc/sys/kernel/threads-max`
   - 最大文件打开数
     1. 查看
        - 查看系统级最大限制：`cat /proc/sys/fs/file-max`
        - 查看用户级最大限制：`ulimit -n`
        - 查看某个进程已经打开的文件数：`cat /proc/pid/limits|fd`
     1. 修改
        - 临时修改：`ulimit -HSn 2048`
        - 永久修改：`vi /etc/security/limits.conf`
### 工具
1. 定时任务
   - crontab：linux原生定时器
     1. -l
     1. -e： 添加，* * * * *(分时日月周) php index.php >> index.log
     1. at：执行一次，`at 2:00 tomorrow`
   - 运维
     1. service crond start/stop/restart/reload/status
     1. chkconfig -level 35 crond on       加入开机启动
     1. ntsysv                             查看是否开机启动
1. vim
   - 打开
     1. vim +n file：打开文件，置于第n行首
     1. vim + file：打开文件，置于最后一行首
     1. vim +/pattern file：打开文件，光标到第一个匹配的地方
     1. vim file file：打开多个，依次编辑
   - 状态
     1. 视图模式：v、V、ctrl+v、y、d
     1. 编辑模式：i、a、r
     1. 命令行模式：: / ?
     1. :setnu：显示行号
     1. :syntax on：语法高亮
     1. ctrl+b：向上翻一屏
     1. ctrl+f：向下翻一屏
   - 跳转
     1. :n/nG：跳到n行
     1. nk：向上移动n行
     1. nj：向下移动n行

     1. space：右移一个字符
     1. backSpace：左移一个字符

     1. w：右移一个字到字首
     1. b：左移一个字到字首
     1. e：右移一个字到字尾

     1. (：移到句首
     1. )：移到句尾
     1. {：移到段落开头
     1. }：移到段落结尾

     1. H：移至屏幕顶
     1. L：移至屏幕底
     1. gg：移至第一行
     1. G：移至最后一行
   - 操作
     1. 插入
        - i：在光标前
        - a：在光标后
     1. 删除
        - d$：删至行尾
        - do：删至行首
        - dd：删除当前行，ndd删除当前和之后的n-1行
     1. 复制粘贴
        - yy：复制当前行，nyy复制n行
        - p：之后粘贴，之前粘贴P
     1. 撤销
        - u：撤销
     1. 查找替换
        - /pattern：向文件尾搜索
        - ?pattern：向文件首搜索
        - n/N：向下上继续搜索
     1. 书签
        - m[a-z]：打书签，a-z26个字母
        - `a-z：移动到书签
1. 解压缩
   - tar
     1. tar.gz
        - zxvf：解压缩
        - zcvf：压缩
     1. tar.bz2
        - jxvf：解压缩
        - jxvf：压缩
   - zip/unzip
     1. `zip -r xx.zip dir/`
     1. `unzip xx.zip`、`unzip -o xx.zip -d dir/`
   - gzip/gunzip
     1. gz
        - -d：解压缩
   - bzip2/bunzip2
   - rar/unrar
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
   - 命令、目录自动补全
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
### 系统
1. 查看状态
   - 系统信息
     1. uname -a：显示系统信息
     1. uptime：当前系统时间、开机到现在运行时间、用户在线数、系统平均负载
     1. runlevel：查看系统运行级别，修改系统默认运行级别`cat /etc/inittab id:3:initdefault:`
   - 系统版本
     1. `cat /etc/redhat-release`：查看centos版本
     1. `cat /proc/version`：查看内核版本
     1. `getconf LONG_BIT`：查看centos位数
   - 硬件
     1. `cat /proc/cpuinfo`：cpu信息
1. 环境变量
   - 认识：系统预定义的参数。window也有。作用：在程序里可以获得环境变量的值，根据值决定如何操作，运行，找路径，文件夹等等
   - 组成
     1. /etc/profile：全局
     1. .bash_profile：个人
   - 操作
     1. export PATH=：书写格式，也可查看环境变量
     1. source .bash_profile：使生效
1. 输入输出
   - 分类
     1. 标准输入文件stdin 0
     1. 标准输出文件stdout 1
     1. 标准错误输出文件stderr 2
   - 命令
     1. echo：输出，-e 支持反斜线控制的字符转换，\a 警告音 \n 换行键 \r 回车键 \t 制表符，Tan键 \v 垂直制表符
     1. print 默认带换行符，printf 没有
1. 命令
   - 执行
     1. sudo、su、setfacl
     1. command1 && command2，可以一次执行两个命令，前一个报错则停止运行
     1. echo &?：获取上一条命令的错误码
   - 重定向
     1. |：管道，前面输出作为后面输入。`cat file.txt | uniq | grep txt | sort`
     1. > >>：输出
        - `more file1 file2 file3 > file2`：清空file2
        - `cat file1 1 >> file2`：追加，1标准输出流
        - demo
            ```shell
            cat > ~/xjj <<EOF
            echo "pleasant taste"
            EOF
            ```
     1. < <<：输入，表示当前命令的标准输入为来自命令行中一对分隔号之间的内容
     1. tee：将程序的输出结果重定向，同时显示和保存。`echo "127.0.0.1 foobar" | tee -a /etc/hosts`
     1. xargs：给命令传递参数的过滤器，捕获一个命令输出，传递给另外一个命令，一般和管道一起使用。因为很多命令不支持管道来传递参数
        - 可读取管道、标准输入、文件输出的数据，并转换成命令行参数
        - 可将单/多行文本输入转换为其他格式，例多行变单行，单行变多行
        - 默认命令为echo，换行和空白经过xargs处理被空格替代
     1. `2>&1 > /dev/null`，shell会自动打开和关闭0、1、2这三个文件描述符
        - /dev/null是黑洞，只写文件，写进去找不回来
        - 2>&1：&表示等同于，2等同于1
   - 通配符
     1. 分类
        - * 一个或多个
        - ? 单一字符
        - [] 包含在其中的任意字符，- 字符范围
     1. 举例
        - `ls /dev/sda[12345]`：出现/dev/sda1  /dev/sda2  /dev/sda3
        - `ls [0-9]?.conf`：以数字开头，随后一个是任意字符，接着以.conf结尾的所有文
   - wiki
     1. man：查看命令手册。帮助一般为：-h/-help/--help
     1. 输出语句中有空格需加双引号
1. 开关机
   - chkconfig：开机启动项
     1. --list
     1. --add/--del name
     1. --level 2345 name on/off
   - shutdown：关机、重启，是最安全的会保存用户的配置和服务。halt、poweroff、init 0：关机，reboot init 6：重启
     1. -h：关机
     1. -r：重启
     1. -c：取消前一个关机命令
   - 运行级别
     1. 0  关机
     1. 1  单用户，即window的安全模式，启动最小的程序模式，多用于修复系统
     1. 2  不完全多用户，不含NFS服务。NFS是linux的文件共享服务
     1. 3  完全多用户，标准的运行级
     1. 4  未分配
     1. 5  图形界面
     1. 6  重启
   - logout、exit、q：退出
   - 整个桌面进程都拖死，因为linux运行着7个工作台的，切到第一个工作台，杀死那个进程，ctrl+alt+1
1. 正则
   - 认识：用来描述文本模式的特殊用法
   - 元字符集
     1. ^：只匹配行首
     1. $：只匹配行尾
     1. *：匹配0个或多个单字符
     1. .：匹配任意单字符
     1. [,]：只匹配[]内字符，,表示多字符序列，-表示字符序列范围
     1. \{n,m\}：字符重复次数的范围
     1. \：屏蔽一个元字符的特殊含义
1. date -s：设置系统时间
### 应用
1. find
   - 全局查找文件：`find / -name "nginx.conf"`
   - 查找txt结尾的文件并输出：`find -name "*.txt" -print`
   - 查找所有sh文件并输出：`find ".sh" -print`
   - 查找当前目前目录所有文件的指定内容
     1. `grep -rn "内容"`：查找精确，还带高亮
     1. `find . -type f -exec grep -n 内容 '{}' ';' -print`：查找精确
     1. `find . | xargs grep -rin "内容"`：查找出了重复内容
   - 删除目录中的所有class文件：`find . | grep .class$ | xargs rm -rvf`
   - 把所有的rmvb文件拷贝到目录：`ls *.rmvb | xargs -n1 -i cp {} /tmp`
1. grep
   - 显示e或a：`grep 'w[ea]ll' a.log`
   - 匹配以非2、1、0开头的行：`grep ^[^210] file`
### wiki
1. 操作系统分类
   - 硬实时：RT-Linux
   - 软实时
   - 嵌入式/专用操作系统：vxWorks、ucos
1. linux的发行版本
   - RedHat系列：Redhat、Centos、Fedora等
     1. Redhat Enterprise：红帽的企业级商业化版本
     1. Fedora：红帽赞助的社区免费版本
     1. Centos：模仿红帽企业版的免费版本
   - SUSE系列
     1. SUSE Linux Enterprise：novell公司的商业化版本
     1. openSUSE：novell公司的社区版本
   - Debian系列：Debian、Ubuntu等
     1. Debian：免费版本
     1. Ubuntu：类似Debian的免费版本
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
1. 历史
   - linux
     1. 1991，linus开源
     1. 1994，内核1.0发布
     1. 2010，centos6，内核2.6发布，ext4
     1. 2017，centos7.4，内核3.1，xfs
     1. 最新内核5.4
   - unix
     1. 1969，AT&T实验室一个研究项目
     1. 1979，无偿提供使用
        - BSD：伯克利软件发行版，伯克利分校修改的unix版本。1989，无unix代码的完全开源的BSD诞生，后续有FreeBSD、OpenBSD
   - GUN：GUN's Not UNIX，GUN计划，自由软件计划，参与者包括emacs、gcc、linux
1. 命令
   - i       忽略大小写
   - n       显示行号
   - r/-R    一般没区别
   - 字符串参数最好采用是双引号括，一是以防被误解为shell命令，二是可以用来查找多个单词组成的字符串
