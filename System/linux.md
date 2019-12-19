### Linux
1. 特点
   - 一切皆文件
   - linux对后缀不敏感
   - 输出语句中有空格需加双引号
   - logout、exit：退出
1. 系统
   - `cat /etc/redhat-release`：查看centos版本
   - `getconf LONG_BIT`：查看centos位数
   - uname -a 显示系统信息
   - uptime：当前系统时间、开机到现在运行时间、用户在线数、系统平均负载
   - runlevel：查看系统运行级别，修改系统默认运行级别`cat /etc/inittab id:3:initdefault:`
1. 环境变量：系统预定义的参数。window也有。作用：在程序里可以获得环境变量的值，根据值决定如何操作，运行，找路径，文件夹等等
   - /etc/profile：全局
   - .bash_profile：个人
   - source .bash_profile：使生效
   - export PATH=：书写格式
1. 重定向
   - tee：将程序的输出结果重定向，同时显示和保存。`echo "127.0.0.1 foobar" | sudo tee -a /etc/hosts`
   - 管道：|，前面输出作为后面输入，依次类推。`cat file.txt | uniq | grep txt | sort`
   - 输出：>，>>
     1. more file1 file2 file3 > file2：清空file2
     1. cat file1 1 >> file2：追加，1标准输出流
   - 输入：>/< <<(表示当前命令的标准输入为来自命令行中一对分隔号之间的内容)
   - 2>&1 > /dev/null，Shell会自动打开和关闭0、1、2这三个文件描述符
     1. /dev/null是黑洞，只写文件，写进去找不回来
     1. 2>&1：&表示等同于，2等同于1
    ```shell
    cat > ~/xjj <<EOF
    echo "pleasant taste"
    EOF
    ```
   - 输入输出方式
     1. 标准输入文件stdin 0
     1. 标准输出文件stdout 1
     1. 标准错误输出文件stderr 2
1. 通配符
   - 分类
     1. * 一个或多个
     1. ? 单一字符
     1. [] 包含在其中的任意字符
   - 举例
     1. ls /dev/sda[12345]：出现/dev/sda1  /dev/sda2  /dev/sda3
     1. ls [0-9]?.conf：以数字开头，随后一个是任意字符，接着以.conf结尾的所有文件
1. 输出
   - echo：输出，-e 支持反斜线控制的字符转换，\a 警告音 \n 换行键 \r 回车键 \t 制表符，Tan键 \v 垂直制表符
   - print 默认带换行符，printf 没有
   - awk：每一行扫描显示文件内容，命令+正则+文件，`awk '条件{命令}' 文件`
     1. `awk '{print $0}' /etc/passwd`：等于`cat /etc/passwd`
     1. `awk -F":" '{ print $1 }' /etc/passwd`：以:作为分隔符，显示第一个
   - sed：实现数据的替换c，删除d，增加a，选取p等，`sed '命令' 文件`
     1. `sed '2,4d' file`：删除2到4行
     1. `sed  '2a liu .....\`
        `>shengxi is shuai !!!'  file_name `：第2行新增2行
   - grep：过滤，`grep '字符' file`
     1. 使用
        - 正则：`grep 'w[ea]ll' a.log`，显示e或a
     1. 命令行
        - -n：显示行号
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
1. 命令执行
   - sudo、su、setfacl
   - command1 && command2，可以一次执行两个命令，前一个报错则停止运行
   - echo &?：获取上一条命令的错误码
1. 启动
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
1. 知识
   - 整个桌面进程都拖死，因为linux运行着7个工作台的，切到第一个工作台，杀死那个进程，ctrl+alt+1
   - date
     1. -s：设置系统时间
### 文件、目录
1. 查看
   - 目录
     1. ls
        - -l：列表详细查看
          1. -lh：以兆查看文件大小
        - -d：查看目录本身详细
     1. pwd
     1. file：查看文件属性
   - 文件
     1. cat：查看文件内容
        - `cat file1 file2`：同时查看两个文件
        - `cat -n file | grep ''| more`：分页查看
        - `cat file > xxx.txt`：将显示结果保存到文件
        - `cat -n file | tail -n +92 | head -n 20`：92行之后的查询结果中显示前20
     1. less/more：分页查看内容，less在另一屏打开，不占用当前屏幕内容
        - enter：下一行
        - space：下一屏
        - /：字符查找，n查找下一次，gg到文件头，G到文件尾，q退出
     1. head/tail：输出文件头/尾
        - -n：行数
        - -f：tail不停显示
     1. uniq：过滤重复再显示
     1. sort：排序显示
1. 搜索
   - find：递归模糊查找文件名
     1. -type：f文件，d目录
     1. -name：精确匹配
     1. -exec：执行操作。如`find . -type f -exec grep -n 内容 '{}' ';' -print` 显示行号-n，显示文件名-print(默认)
   - locate：系统全局范围定位文件，从database中查找数据。一般一天更新一次，更新文件数据库`updatedb`
     1. -r：正则
   - whereis
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
   - 压缩/解压缩
     1. tar
        - tar.gz
          1. zxvf：解压缩
          1. zcvf：压缩
        - tar.bz2
          1. jxvf：解压缩
          1. jxvf：压缩
     1. zip/unzip
     1. gzip/gunzip
     1. bzip2/bunzip2
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
### 网络
1. 查看
   - ping
   - traceroute：显示网络数据包传输到指定主机的路径信息，追踪数据传输路由状况
   - ifconfig：显示当前网络接口状态、配置网络
     1. -a：inet addr，ip地址
   - nethogs: 将进程按网络流量列表显示
   - lsof
     1. i:80：查看端口号，root用户查看
   - netstat：显示网络连接/运行端口/路由表等
     1. anpt：查看端口占用，`netstat anpt | grep 80`
   - ss
     1. 认识：Socket Statistics，用来获取socket统计信息，显示和netstat类似，优势在于能显示更详细的TCP和连接状态的信息，比netstat更快速更高效
   - host
   - dig
     1. 认识：从DNS域名服务器查询主机地址信息
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
### 内存
1. free
   - -m 以兆显示内存状态
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
### Tools
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
### wiki
1. linux分类
   - RedHat系列：Redhat、Centos、Fedora等
   - Debian系列：Debian、Ubuntu等 
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
1. 命令
   - 帮助一般为：-h/-help/--help
   - man：查看命令手册
1. 参数
   -i       忽略大小写
   -n       显示行号
   -r/-R    一般没区别
