### 基础
1. 系统安全：sudo、su、chmod、setfacl
1. 系统关机和重启：shutdown、reboot
1. 进程管理：w、top、ps、kill、pkill、pstree、killall
1. 用户管理：id、usermod、useradd、groupadd、groupdel
1. 命令执行：command1 && command2，可以一次执行两个命令，前一个报错则停止运行
1. 数据重定向
   - 输出：>>追加，>覆盖，如./a.out 1>t.txt 2>f.txt，1标准输出流2标准错误流
   - 输入：<
1. echo &?：获取上一条命令的错误码
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
1. centos7防火墙配置
   - 添加端口：firewall-cmd --zone=public --add-port=80/tcp --permanent
   - 查看端口：firewall-cmd --zone=public --list-ports
   - 开关：systemctl start/disable/restart firewalld
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
1. 进程守护：supervisor、Systemd、monit(还能性能监控等等)、命令(nohup/Screen/Tmux)、Node工具(forever/nodemon/pm2)、写锁(让工作进程和守护进程争抢写锁，当守护获得写锁时重启工作进程并放弃写锁))
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






### 目录
1. 总体知识
1. cd、rm
1. 查看、创建、搜索
1. 重定向、通配符、引用
1. 权限
1. 解压缩
1. 基本操作
1. 软件安装、进程和端口、网络
1. 快捷键、shell、其他
1. 实际操作
### 认识
1. Linux系统分类
   - RedHat系列：Redhat、Centos、Fedora等 
   - Debian系列：Debian、Ubuntu等 
1. Linux的shell
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
1. Linux的文件系统
   - 文件树：一根文件数，根目录为/
   - 分区：sda1、sda2，挂载点：把sda1挂载到根目录/上，则所有数据都在sda1分区。当sda2挂载到/home，则数据到了sda2的分区下 
1. 路径：绝对路径以/开头，相对路径以.或者..开头
   - Linux对后缀不敏感
   - 好玩的命令
    ```
    cowsay
    apt-build moo
    linuxlogo
    aptitube -vv moo
    // 黑客帝国数据流
    apt-get install cmatrix
    cmatrix
    // 火车
    sudo apt-get install sl
    sl
    ```
1. -i  忽略大小写
   -n  显示行号
1. 环境变量：系统预定义的参数。window页也有。作用：在程序里可以获得环境变量的值，根据值决定如何操作，运行，找路径，文件夹等等
### cd————改变目录 change dir
```
cd            回到用户主目录
cd ../../     连续向上
cd -          回到上一次的目录
```
### rm cp mv———文件和目录操作
- 基本用法
```
-r      操作目录时用
-f      强制
```
- 例子
```
cp -r dir1 dir2
mv file dir/
rm -r dir
```
1. 重要文件防删除
```
// 加提醒
chattr +i filename
// 解除
chattr -i filename
```
### 查看———文件和目录
- ls———查看文件和目录
```
// .开头的文件和目录都是隐藏的
// 只显示目录，目录为蓝色，-l参数下目录以d开头
// 显示出的第一个字符代表文件类型，- 文件、d 目录、l 符号链接，其他还有大小、最后修改时间
ls -l | grep ^d
// 查看目录的详细内容
ls -ld dir
```
- less———分页查看文件内容
```
less file.txt
ctrl--            缩小字体
z                 向下滚屏
k                 向上滚屏
/                 字符查找，n查找下一次，gg到文件头，G到文件尾，q退出
```
- more---用于文本较长，无法一屏显示
```
enter    下一行
空格     下一屏
```
- cat———查看文件内容
```
// 同时查看两个文件
cat file1 file2
.
.
// 分页查看，空格翻页，n下一页
cat -n test.log | grep ''| more
// 将显示结果保存到文件
cat -n test.log | grep '' > xxx.txt
// 92行之后的查询结果中显示前20
cat -n test.log | tail -n +92 | head -n 20
.
.
// 查看系统版本
cat /etc/issue
```
- head---输出文件第一部分
- tail---输出文件最后一部分
- file———查看文件详细
- echo———输出到终端
- date
```
-s --set：设置系统时间。
-d --date：显示描述的日期。
```
### 创建————文件和目录
1. 创建文件
```
1.vi file
2.> file
3.touch file
// 创建目录
mkdir -p dir/dir   递归创建
// 创建文件链接
ln -s happygrep xxx
```
1. ln---建立文件或者目录的链接
 - 硬链接：多个路径指向一个文件的inode号，可以防止误删除操作，最后的inode号删除才删除文件。ln默认硬链接
 - 符号链接：类似快捷方式
```
ln -s    进行软连接
```
### 搜索
- locate---系统全局范围定位文件
```
// 找出所有
// 从database中查找数据，一般一天更新一次database，
locate vimrc
// 支持正则表达式
locate --regexp xxx
// 更新文件数据库
sudo updatedb
locate aa.txt
```
- find
```
// 指定目录查找
find .|grep .txt
find . -type f/d    f文件/d目录
// 查询文件内容,用-exec，显示行号-n，显示文件名-print
find . -type f -exec grep -n 内容 '{}' ';' -print
```
- grep
### 权限
1. permission 概述
   - 分类：r、w、x--------读、写、执行
   - 文件模式：如何控制权限：即rwxr-r--
```
// 查看目录的权限
// r 代表可以查看里面的内容、对于目录即有哪些文件
// w 编辑里面的内容，对于目录即对里面的文件进行创建、删除、重命名操作
// x 执行这个文件，对于目录即可以cd进这个目录，一般是有这个权限的
ls -ld dir
```
   - chmod：控制文件模式，以8进制的形式进行控制
```
// 综合使用chmod、chown owner和group去控制
```
   - chown -R    递归修改
   - chown +x fileOrdir 添加权限
### 重定向和通配符、引用
1. 输入输出方式：标准输入文件stdin0、标准输出文件stdout1、标准错误输出文件stderr2，数字是文件描述符
1. 重定向
   - 分类
     1. 管道线--pipeline
```
// 前面的输出作为后面的输入，并依次类推
// | 管道符
// Uniq唯一显示，sort排序显示
cat file.txt | uniq | grep txt | sort
```
     1. 输出重定向
```
// > 输出重定向符
// 重定向之前清空file2的内容，写入输出
cat file1 > file2
// 重定向追加内容，使用>>
cat file1 >> file2
// 合并输出
more file1 file2 file3 >file
```
     1. 标准错误输出重定向
```
// 标准错误输出是不能用>重定向的
// 重定向错误输出，只在错误的时候才记录
cat file1 2> file2
```
     1. 标准输入重定向
```
// 用处：将一个文件的内容作为命令的输入，而不从键盘输入
// 分类：< <<
// << 表示当前命令的标准输入为来自命令行中一对分隔号之间的内容
// 不常用
cowsay < file
```
     1. 组合功能
```
1.将标准错误输出流拐到标准输出里
2.一条数据流分叉向两个方向
```
1. 通配符
 - 理解：方便用户对文件或者目录的描述
 - 分类：* 一个或多个，? 单一字符，[] 包含在其中的任意字符
```
// 举例
ls /dev/sda[12345]
/dev/sda1  /dev/sda2  /dev/sda3  /dev/sda4  /dev/sda5
// 这条命令列出当前目录下以数字开头，随后一个是任意字符，接着以“.conf”结尾的所有文件
ls [0-9]?.conf
// 这条命令列出当前目录下以x、y或z开头，最后以“.txt”结尾的文件
ls [xyz]*.txt
```
 - 命令搭配通配符，这是命令的魅力之处
```
echo a*.html
```
1. 引用
   - 理解：通知shell将特殊字符当做普通字符来使用
   - 分类
     1. 转义字符 \
```
// 将abc?*重命名为abc，将C:\backup重命名为backup
mv abc\?\*  abc
mv C\:\\backup backup
```
     1. 单引号 ''
```
// 单引号中的所有字符串的特殊意义都被忽略
mv 'C:\backup'  backup
```
     1. 双引号 ""
```
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
### 压缩和解压缩
1. unzip/zip
1. .tar.gz
```
tar zxvf FileName      解压缩
tar zcvf dir           压缩
```
1. tar.bz2
```
tar jxvf FileName      解压缩
tar jxvf dir           压缩
```
### 基本操作
1. 软件启动
   - 七级启动级别
     0 为停机，机器关闭。（千万不要把initdefault设置为0）
     1 为单用户模式，就像Win9x下的安全模式类似。
     2 为多用户模式，但是没有NFS支持。
     3 为完整的多用户模式，是标准的运行级。
     4 一般不用，在一些特殊情况下可以用它来做一些事情。例如在笔记本电脑的电池用尽时，可以切换到这个模式来做一些设置。
     5 就是X11，进到X Window系统了。
     6 为重启，运行init 6机器就会重启。（千万不要把initdefault设置为6 ）
   - 查看所有开机启动项：chkconfig --list (查看单一软件)
   - 添加/删除开机启动项：chkconfig --add/--del name
   - 编辑启动级别：chkconfig --level 2345 name on/off
1. shutdown————关机和重启
```
-c   取消前一个关机命令
-h   关机
-r   重启，如shutdown -r 05：30。就会阻塞用户操作，ctrl+c退出
// shutdown命令是最安全的关机和重启命令，会保存用户的配置和服务
// 其他关机命令：halt、poweroff、init 0
// 其他重启命令：reboot init 6
```
1. &————将命令后台执行
```
shutdown -r 05：30 &
```
1. logout或者exit————正确退出命令
1. 重启 service 
```
service servicename restart
nginx reload
```
1. 用户和用户组
 - 用户
```
// 查看所有用户信息
/etc/passwd
```
 - 用户组
```
// 查看所有用户组信息
/etc/group
// 添加/编辑用户组
groupadd xxx
groupmod -n xxx  修改名称
groupmod -g 668 xxx  修改编号
groupdel xxx
// 添加用户
useradd -g groupName userName
```
1. mount————挂载
### 网络
1. ifconfig 显示当前网络接口状态、配置网络
1. 文件配送网络：vi /etc/sysconfig/network-scripts/ifcfg-eth0
1. netstat 显示本机网络连接、运行端口和路由表等
1. telnet 通过telnet协议与远程主机通信或者获取远程主机对应端口的信息
1. traceroute显示网络数据包传输到指定主机的路径信息，追踪数据传输路由状况
1. wget 网络上下软件
1. SSH省去输入密码
```
ssh -kengen
cd ~/.ssh
ls
id_rsa id_rsa.pub
// 把公钥复制到服务器上
ssh -copy-id peter@happypeter.net
```
1. tumx 断网保存用户操作的界面
1. 文件上传
```
// 建立同步文件夹
rsync -r mydir happycas.net:
// 同步文件
rsync -av mydir/ happycas.net:mydir/
// 同步删除文件
rsync -av --delete mydir/ happycas.net:mydir/
// 下载
rsync -r happycas.net:mydir .
```
1. SSH命令
```
// 登录
ssh username@ip
// 上传文件
scp [-r] 本地文件 username@ip:路径
// 下载文件
scp [-r] username@ip:文件路径 本地路径
```
### 进程和端口
1. 进程
 - process PID
 - 获取进程号
```
// 获得vim的进程号PID
ps aux | less
/vim
// 或
ps aux | grep vim
```
 - 将程序后台执行
```
// shell还能输入加&
firefox &
// 假如firefox已经运行，将：暂停firefox，回到后台，到前台，结束程序
ctrl+z
bg
fg
ctrl+c
```
 - kill
```
// 程序不响应时，要杀死进程
ps aux|grep vim
kill -9 PID
/
/
// 整个桌面进程都拖死，因为linux运行着7个工作台的
// 切到第一个工作台，杀死那个进程
ctrl+alt+1
```
1. 端口
   - 查看端口占用：netstat -anpt | grep 80
### 软件安装
1. 源码包编译安装
```
// 三大步骤
./configure
make
make install
```
1. RedHat 系列
 - rpm包
```
// rpm是linux的一种软件包名称，以.rpm结尾
// 用于redhat的平台上，方便进行安装、升级、卸载
// 由于rpm格式的通常是已编译的程序，所以需指明平台。如sfotware-1.2.3-1.i386.rpm
// rpm只能安装已经下载到本地机器上的rpm 包. yum能在线下载并安装rpm包,能更新系统,且还能自动处理包与包之间的依赖问题,这个是rpm 工具所不具备的。
rpm -参数
rpm -qa 查询所有安装的包 rpm -qa | grep xxx
```
 - 包管理工具 Yum
    1. 基本介绍
```
// 全称：Yellow dog Updater, Modified
// 基於rpm包管理
// epel是yum的扩展源
```
    1. 扩展
```
rpm -qa|grep yum      查看系统默认安装的yum
yum search xxxx       查找
yum install xxxx      安装
yum remove xxxx       卸载
yum update xxxx       更新
yum list installed    列出已安装的包
yum list updates      列出可更新的包
yum info xxxx         列出软件包信息
yum info installed    列出已安装的软件包信息
```
    1. 配置yum源
```
// 配置文件分为两部分
// 唯一的main：全局配置项，位于/etc/yum.conf
// repository：定义每个源/服务器的具体配置，位于/etc/yum.repo.d
// 步骤：
修改 /etc/yum.repos.d/下的repo文件
导入GPG KEY：yum可以使用gpg对包进行校验确保下载完整性，诸如RPM-GPG-KEY-CentOS-5 之类的纯文本文件，下载下来用rpm --import RPM-GPG-KEY-CentOS-5 命令将key导入。
yum makecache
执行yum命令： yum install xxxx
```
1. Debian系列
    - deb包/dpkg包
```
// 是linux的一种软件包名称
// 是Debian Linux提供的包管理器，比RPM晚
dpkg -参数
dpkg -l 查看安装的软件
```
   - 包管理工具 apt-get
```
// 建立在deb上，有包管理的功能。用于自动从互联网的软件仓库中搜索、安装、升级、卸载软件
apt-get install git
apt-get remove git
// 删除配置文件
apt-get purge git
```
### 快捷键
```
tabtab     显示可选项
ctrl+a     跳到行头
ctrl+e     跳到行尾
ctrl+b     光标左移一个字母

ctrl+c     杀死当前进程。
ctrl+d     退出当前 Shell
ctrl+s     暂停该终端，ctrl+q恢复
ctrl+z     把当前进程转到后台运行，使用 fg 命令恢复


ctrl+u     清除光标前至行首间的内容
ctrl+k     清除光标后至行尾的内容
ctrl+y     粘贴或者恢复上次的删除
ctrl+l     清屏，相当于clear

ctrl+shift+t 打开新的shell
```
### 其他
- 如果输出的语句中有空格就需要加双引号，`echo "i love you"`
- w 用户登录查看命令。who 显示登陆到系统的用户，或者用w
- -r和-R一般是没有区别的，具体用哪个看--help区分
- passwd 修改密码
- clear 清除屏幕
- uname -a 显示系统信息
- uptime  输出当前系统时间、系统开机到现在的运行时间、目前有多少用户在线和系统平均负载等。
- free -m 以兆显示内存状态
- ps 显示系统运行状态
- top 查看活跃的进程，类似进程管理器
- df 查看磁盘占用情况
- fsck 检查文件系统，并尝试修复
- split 分割文件
- scp 传文件Unix系统里，每行结尾只有“<换行>”，即“\n”；Windows系统里面，每行结尾是“<换行><回车 >”，即“\n\r”；Mac系统里，每行结尾是“<回车>”。一个直接后果是，Unix/Mac系统下的文件在Windows里打开 的话，所有文字会变成一行；而Windows里的文件在Unix/Mac下打开的话，在每行的结尾可能会多出一个^M符号。
- 命令提示
   1. man 命令：查看命令手册
   1. /- 参数：查找参数，查找下一个敲 n
- 系统运行级别
   1. 归属动作
```
// 查看系统运行级别
runlevel
// 修改系统默认运行级别
cat /etc/inittab    id:3:initdefault:
```
   1. 运行级别
```
0  关机
1  单用户，即window的安全模式，启动最小的程序模式，多用于修复系统
2  不完全多用户，不含NFS服务。NFS是linux的文件共享服务
3  完全多用户
4  未分配
5  图形界面
6  重启
```
- rcp可以在linux中传输文件
### shell编程
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
1. 命令
   - echo：打印，-e 支持反斜线控制的字符转换
     1. \a 警告音
     1. \n 换行键
     1. \r 回车键
     1. \t 制表符，Tan键
     1. \v 垂直制表符
   - awk、cut
1. wiki
   - 查看shell版本：`echo $SHELL`
   - 注释：#
   - 进入sh的shell：`sh`
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
### 应用
1. Vim快捷键
   - 基本命令
     1. yy 复制当前行
     1. dd 删除当前行，并复制
     1. p 当前位置之后粘贴，之前粘贴P
   - 升级
     1. :20 跳到20行
     1. . 重复上一次命令
1. 定时任务
 - 方法1：crontab————Linux原生定时器
     1. 解释：crontab是定时执行的工具，使用crontab来配置cron任务
     1. 查看
 ```
 // 查看定时任务
 crontab -l
 ```
     1. 操作
 ```
 yum install crontabs // 安装crontab
 /sbin/service crond start          // 启动服务
 /sbin/service crond stop           // 关闭服务
 /sbin/service crond restart        // 重启服务
 /sbin/service crond reload         // 重新载入配置
 service crond status
 chkconfig -level 35 crond on       // 加入开机启动
 ntsysv                             // 查看是否开机启动
 ```
     1. 添加php定时
 ```
 // 添加定时任务
 crontab -e
 ** * * * /usr/bin/php -f /root/test.php >> test.log       // -q是安静模式
 chmod +x test.php           // 必须为可执行文件
 ```
 - 方法2：使用php内置函数
     1. 解释：最好分master和worker，master负责监控是否有任务执行，以免某次任务出问题，系统挂掉
     1. 示例
 ```
 ignore_user_abort();//关掉浏览器，PHP脚本也可以继续执行.
 set_time_limit(0);// 通过set_time_limit(0)可以让程序无限制的执行下去
 $interval=60*30;// 每隔半小时运行
 do{
  //这里是你要执行的代码 
  sleep($interval);// 执行程序间隔的时间
 }while(true);
 ```
 - 方法3：用C语言写一个守护程序
1. tail查看系统日志，nginx日志文件地址在配置中存着
    ```
    tail      显示指定文件末尾内容，并且不停刷新可以看到最新的内容
    tail -1000f test.log        最后1000不停刷新
    grep '搜索内容' 日志文件
    ```
1. supervisor——保持进程常驻工具，用python写的
   - 配置文件
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
1. 判断是否是root用户
    ```bash
    #!/bin/bash
    test=$(env | grep USER | cut -d "=" -f 2)
    if [ "$test" == "root" ];then
        echo "you are root now"
    fi
    ```
1. 判断磁盘使用率
    ```bash
    #!/bin/bash
    test=$(df -h | grep sda5 | awk '{print $5}' | cut -d "%" -f 1)
    if [ "$test" -ge "90" ];then
        echo "sda5 is full"
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