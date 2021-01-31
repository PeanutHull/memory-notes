### Linux
1. 特点
   - 一切皆文件
   - 对后缀不敏感
### 文件、目录
1. 查看
   - 目录
     1. pwd
     1. ls [dir]：查看当前或指定目录。-l：列表详细查看，-lh：以兆查看文件大小，-S：按照大小排序
   - 文件
     1. stat：查看文件详情信息，修改时间、Inode、Links数等
     1. file：查看文件类型
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
   - tac：反向查看文件内容
     1. -s：到某一字符串停止
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
        - 同ip访问次数，空格分隔：`cat filename | awk -F '' '{print $1}' | sort | uniq -c > result.txt`
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
   - md5sum：查看校验和，32位小写
     1. `md5sum a.sql`
     1. `echo -n "hello world"|md5sum`
1. wiki
   - .开头的文件和目录都是隐藏的
   - 目录为蓝色，-l参数下-为文件、d为目录、l为符号链接
### 用户、权限
1. 用户和用户组
   - 查看
     1. /etc/passwd
     1. /etc/group
     1. who、w：显示当前用户，w更加详细(显示当前所有已登录的用户)
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
### 网络
1. 应用
   - wget
   - curl
     1. -X POST
     1. -x '127.0.0.1：80'
     1. -H 'CONTENT-TYPE:application/json' -H 'traceid:123abc'：多个就写多个-H
     1. -d '{"id":xx}'
     1. `curl ipinfo.io/curl cip.cc`：查看出口ip
   - rsync
     1. 认识：linux的文件备份、同步工具
        - 计算源文件和目标文件的差异，仅同步差异（因为全量成本高）
        - 压缩、解压数据以进一步提高速度
     1. 参数
        - -r：同步
        - -av：同步文件，删除--delete
   - samba
     1. 运维：`yum install samba`，配置：`/etc/samba/smb.conf`，即可开始共享文件
   - scp
     1. 上传：`scp [-r] local addr@ip:/addr`
     1. 下载：`scp [-r] addr@ip:/addr local`
   - rcp
   - sz/rz
   - ftp/sftp
   - ssh
   - telnet：用于远程登录，基于TCP/IP协议族一员的telnet协议，采用明文传送报文安全性不好，都用ssh
   - nc
1. 检测
   - ping：连通性
   - telnet ip port：检测端口是否打开
   - dig：域名检测，从DNS域名服务器查询主机地址信息
   - nslookup：域名检测
   - host
   - tracepath：端对端路由检测
   - route
     1. 认识：可显示、操作ip路由表，可设置网关来访问Internet
     1. 操作
        - 查看
          1. -n：不显示主机名，直接显示ip、port
        - 操作：`route add/del [-net|-host] [网域或主机] netmask [mask] [gw|dev]`
          1. -net    ：表示后面接的路由为一个网域
          1. -host   ：表示后面接的为连接到单部主机的路由
          1. netmask ：与网域有关，可以设定netmask决定网域的大小
          1. gw      ：指定网关ip
          1. dev     ：指定发送网卡，如eth0
     1. 实操：`route add -net 192.168.62.0 netmask 255.255.255.0 gw 192.168.1.1`
     1. 结果解析
        - Destination：目标网络或目标主机
        - Gateway：网关地址，没有显示星号
        - Genmask：网络掩码
        - Flags：总共有多个旗标，代表的意义如下：                        
          1. U：该路由是启动的                      
          1. H：目标是主机而非网域                      
          1. G：需要透过外部的主机来转递封包                      
          1. R：使用动态路由时，恢复路由资讯的旗标                      
          1. D：已经由服务或转port功能设定为动态路由                       
          1. M：路由已经被修改了                      
          1. !：这个路由将不会被接受
        - Metric 距离、跳数。暂无用。
        - Ref：恒为0，Number of references to this route. (Not used in the Linux  ker-nel.)
        - Use：该路由被使用的次数，可以粗略估计通向指定网络地址的网络流量。
        - Iface：网络接口名
   - traceroute：显示网络数据包传输到指定主机的路径信息，追踪数据传输路由状况
   - openssl：查看网站证书链`openssl s_client -connect github.com:443 -showcerts`
   - lsof：list open files，列出打开文件。linux环境下任何事物都以文件的形式存在
     1. i:80：查看端口号，root用户查看
1. 查看
   - ifconfig：显示、设置网络
     1. -a：inet addr，ip addr
     1. 设置
        - `ifconfig eth0 up/down`：开关网卡
        - `ifconfig eth0 192.168.1.56 `：配置ip
        - `ifconfig eth0 192.168.1.56 netmask 255.255.255.0 broadcast 192.168.1.255`：配置ip、子网掩码、广播地址
        - `ifconfig eth0 add/del 33ffe:3240:800:1005::2/ 64`：增删IPv6地址
        - `ifconfig eth0 hw ether 00:AA:BB:CC:DD:EE`：修改MAC地址
        - `ifconfig eth0 arp/-arp`：开关arp
        - `ifconfig eth0 mtu xx`：设置最大数据包，字节
   - nethogs：实时将进程按网络流量列表显示
   - iftop：实时流量监控工具
     1. TX：发送流量
     1. RX：接收流量
     1. TOTAL：总流量
     1. Cumm：运行iftop到目前时间的总流量
     1. peak：流量峰值
     1. rates：分别表示过去 2s 10s 40s 的平均流量
   - netstat：显示网络连接/运行端口/路由表等，太慢淘汰
     1. -i：网卡列表
     1. -g：组播组关系
     1. -s：网络详细统计
     1. –e：网络统计
     1. -r：路由信息
   - ss：Socket Statistics，用来获取socket统计信息，显示和netstat类似，优势在于能显示更详细的TCP和连接状态的信息，比netstat更快速更高效
     1. -s：socket详细信息
     1. -l：显示本地打开的端口
     1. -pl：每个进程具体打开的socket
     1. -o state xx：显示端口状态为xx的连接，状态有estab，closed，orphaned，synrecv，timewait
     1. -t -a：所有tcp socket
     1. -u -a：所有udp Socekt
     1. src/dst xx.xx.xx.xx：显示本地/远端某ip的连接
     1. dport OP port：显示和端口的连接，OP为运算符，<=、==、!=、<
   - tcpdump
     1. 认识：网络数据包分析器，是网络分析和问题排查的首选工具。支持针对网络层/协议/主机/网络/端口的过滤，并提供and/or/not等逻辑语句去掉无用信息
        - 使用tcpdump抓到包后，往往需要再借助其他的工具进行分析，比如常见的wireshark
     1. 用法：tcpdump [option] [not] proto dir type
        - option
          1. 抓包选项
             - -c：指定要抓取包数量
             - -i：指定监听网卡。如eth0
             - -n：不把ip转化成域名直接显示ip，也就是说不做主机名解析，避免执行DNS lookups的过程，速度会快很多
             - -nn：除了-n的作用外，还把端口显示为数值，否则显示端口服务名
             - -P：指定要抓取的包是流入还是流出的包。可以给定的值为"in"、"out"和"inout"，默认为"inout"
             - -X/-XX：输出包的头部数据，越来越详细
             - -s x：设置数据包抓取长度
          1. 输出选项
             - -e：显示数据链路层头部信息，如mac地址
             - -v/-vv/-vvv：越来越详细的输出
          1. 其他
             - -D：显示可抓包的网卡
        - proto：tcp、udp、ip、ether、arp、icmp
        - dir：src、dst、src and dst、src or dst(默认这个)
        - type：host(ip地址)、net(网段如ip/xx)、port、portrange(xx-xx)
     1. 结果解析
        - Flags标识符
          1. [S] : SYN（开始连接）
          1. [P] : PSH（推送数据）
          1. [F] : FIN （结束连接）
          1. [R] : RST（重置连接）
          1. [.] : 没有 Flag，由于除了SYN包外所有的数据包都有ACK，所以一般这个标志也可表示ACK
     1. 实操
        - `tcpdump -c 10 -nn not port 10088 and not port 8080 and src host xx`：抓10个来自xx ip的数据包
        - `tcpdump -c 10 -nn -v port 80`：抓10个80端口上来回交互的包，并详细显示
        - `tcpdump -nn 'tcp port 80 and (((ip[2:2] - ((ip[0]&0xf)<<2)) - ((tcp[12]&0xf0)>>2)) != 0)'`：源或目的端口是80, 网络层协议为IPv4, 并且含有数据,而不是SYN,FIN以及ACK-only等不含数据的数据包
        - `tcpdump -nn 'tcp[tcpflags] & (tcp-syn|tcp-fin) != 0 and not src and dst net 10.90.100.46'`：打印TCP会话中的的开始和结束数据包，不包括本地的
        - 抓syn包
          1. `tcpdump -i eth0 "tcp[13] & 2 != 0"`
          1. `tcpdump -i eth0 "tcp[tcpflags] & tcp-syn != 0"`
        - 抓syn+ack包
          1. `tcpdump -i eth0 'tcp[13] == 2 or tcp[13] == 16'`
          1. `tcpdump -i eth0 'tcp[tcpflags] == tcp-syn or tcp[tcpflags] == tcp-ack'`
        - 抓post请求的包：`tcpdump -s 0 -A -vv 'tcp[((tcp[12:1] & 0xf0) >> 2):4]'`，判断tcp报文内容来过滤，不能保证post的都抓到因post分了多个tcp包
        - 抓get的包：`tcpdump -s 0 -A -vv 'tcp[((tcp[12:1] & 0xf0) >> 2):4] = 0x47455420'# or$ tcpdump -vvAls0 | grep 'GET'`
        - 提取请求头：` tcpdump -nn -A -s1500 -l | grep "User-Agent:"`
        - 找出发包最多的ip：`tcpdump -nnn -t -c 200 | cut -f 1,2,3,4 -d '.' | sort | uniq -c | sort -nr | head -n 20`
1. 配置
   - /etc/sysconfig/network-scripts/ifcfg-eth0
   - hostname
   - ifdown/ifup
   - ethtool
   - 防火墙
     1. iptables
        - 编辑：`vim /etc/sysconfig/iptables`
        - 增加：`-A INPUT -m state --state NEW -m tcp -p tcp –-dport 80 -j ACCEPT`
        - 状态/重启/关闭：`/etc/init.d/iptables status/restart/stop`
     1. centos7防火墙配置
        - 添加端口：firewall-cmd --zone=public --add-port=80/tcp --permanent
        - 查看端口：firewall-cmd --zone=public --list-ports
        - 开关：systemctl start/disable/restart firewalld
1. 路由
   - 子网通信：两个子网想要通信，需要连接两个网络的路由器，或者同时位于两个网络的网关
   - 永久保存路由
     1. `/etc/rc.local`添加
     1. `/etc/sysconfig/network`添加到末尾
     1. `/etc/sysconfig/static-router`：`any net x.x.x.x/24 gw y.y.y.y`
1. 参数
   - 查看
     1. SYN queue：`/proc/sys/net/ipv4/tcp_max_syn_backlog`
     1. Accept queue：`/proc/sys/net/core/somaxconn`或/etc/sysctl.conf的`net.core.somaxconn=128`
     1. 重传SYN+ACK次数：`net.ipv4.tcp_synack_retries`：默认为5，表示重发5次，每次等待30~40秒，即半连接默认时间大约为180秒
     1. 查看进程连接、排队状况：`netstat -lntup`
     1. 查看tcp状态数量：`netstat -an | awk '/^tcp/ {++S[$NF]}  END {for (a in S) print a,S[a]}'`
   - 队列
     1. 查看SYN queue溢出：`netstat -s | grep LISTEN`
     1. 查看Accept queue溢出：`netstat -s | grep TCPBacklogDrop`
   - keepalive
     1. tcp_keepalive_time：从连接开始到发送探测数据包之间的空闲时间
     1. tcp_keepalive_probes：发送探测数据包的最大数量，之后关闭连接
     1. tcp_keepalive_intvl：发送两个探测数据包的间隔时间
1. wiki
   - 端口号1024以下是系统保留的，总共65526个
### 磁盘
1. 认识
   - linux规定，硬盘用sda/sdb/sdc依次命名，一块硬盘只能存在4个主分区，为sda1/sda2/sda3/sda4，逻辑分区不限制数量，从5开始
1. 文件系统
   - 文件树：一根文件数，根目录为/
   - 分区
     1. 分区名称：sda1、sda2
     1. swap分区：交换区，物理内存不够时，将不用的内存数据放到这个分区。分的大了浪费小了影响性能，小内存为2倍，大内存(8G)相等
        - swappiness：使用权重，复杂算法
        - swapon：启用，-s，查看swap相关信息
        - swapoff：关闭/回收
        - mkswap：格式化
   - 挂载点：把sda1挂载到根目录/上，则所有数据都在sda1分区
1. 操作
   - mount/umount：挂载
     1. /dev/sd*：设备文件，`mount /dev/sda1 /mnt/sda1`
   - df：查看磁盘占用情况
     1. -a：显示所有文件系统信息，包括系统特有/proc、/sysfs
     1. -m：以mb为单位显示容量，默认kb
     1. -h：使用人们习惯的KB、MB或GB等单位自行显示容量
     1. -T：显示名称
     1. -i：不用硬盘容量显示，用inode数量
   - du：统计目录或文件所占大小。df从文件系统角度，du从文件角度，df更准
     1. -a：显示每个子文件的磁盘占用量。默认只统计子目录的磁盘占用量
     1. -h：使用习惯单位显示磁盘占用量，如KB、MB
     1. -s：统计总磁盘占用量，而不列出子目录和子文件的磁盘占用量
   - dlkid
   - fsck：检查文件系统，并尝试修复
   - fdisk：分区，大于2TB用parted
   - parted
   - mkfs：对分区进行格式化
   - lvreduce
1. 查看
   - iotop: 查看进程和磁盘，将进程按磁盘读写次数、频率排序，无法统计内核的io
   - iostat：查看io状态，`iostat/iostat 3/iostat 3 3`：用法和mpstat一致。`iostat -dxm 3`
### 内存
1. free：-m 以兆显示内存状态
1. vmstat：Virtual Meomory Statistics，虚拟内存统计信息，是实时系统监控工具，包括进程情况、内存情况、交换页、I/O、系统中断、CPU。`vmstat/vmstat 3/vmstat 3 3`：用法和mpstat一致
   - `vmstat -a`：查看活动和非活动内存
1. pmap：查看进程内存占用信息。`pmap -d xx`
### cpu
1. nice：设置cpu使用优先级，如用来对付那些缓慢而且漫长的io进程
### 进程
1. 运行
   - 后台运行：xx &
   - 断开shell继续运行：因为shell断开进程收到SIGHUP，该信号的默认处理导致进程终止，进程不终止主要是处理SIGHUP信号
     1. 未运行
        - `nohup xx &`：需要按下任意键返回shell，并且使用exit退出，不能直接断开shell，否则还是会shutdown
          1. 同时不输出日志：`nohup xx 1>/dev/null 2>&1 &`
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
   - ps：显示进程状态
     1. `ps -aux --sort -pcpu,+pmem | less`，所有进程并且详细模式，按cpu升序、内存降序。x显示没有控制终端的进程。less可换成`head -n 10`显示前10个
     1. `ps -f -C php-fpm`：查看某进程详细信息
     1. `ps -L pid`：查看某进程的线程
   - pstree：树状显示所有进程，`pstree | grep php`
   - pidof：打印pid
   - jstack：查看进程
   - pidstat：进程信息，默认显示进程的cpu使用信息
     1. -r：显示内存使用信息
     1. -d：显示IO使用信息
     1. -w：显示上下文切换信息
     1. -t：显示线程信息
     1. -p：指定进程号
   - which：查看程序安装位置
   - 查看/设置允许打开的最大文件句柄数：`ulimit -n xx`，重启或用户退出失效
1. 杀死
   - 分类
     1. kill：发信号
        - -2：SIGINT
        - -4：SIGTERM
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
        - 查看一个进程的最大限制：`ulimit -n`
        - 查看某个进程已经打开的文件数：`cat /proc/pid/limits|fd`
     1. 修改
        - 临时修改：`ulimit -HSn 2048`
        - 永久修改：`vi /etc/security/limits.conf`
   - 单机最大连接数
     1. 进程的文件句柄限制，可以改配置变大
     1. 端口号限制，根据tcp连接标识定义，连接数即客户端ip数×客户端port数，不考虑地址重用/地址分类，对于ipv4，server端单机最大tcp连接数约为2的48次方
### 工具
1. 定时任务
   - crontab：linux原生定时器
     1. -l
     1. -e：打开vi后添加`* * * * *(分时日月周) php index.php >> index.log`
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
   - gzip/gunzip：gz结尾
     1. -d：解压缩
   - bzip2/bunzip2
   - rar/unrar
1. 相关库、框架
   - OpenSSL：是用于TLS和SSL的工具包和加密库，可用来进行安全通信，包含了SSL协议库、应用程序、密码算法库
   - Socket：应用层与各种网络协议通信的中间软件抽象层，是一组调用接口/API/封装。用socket组织数据，兼容多网络协议，负责程序通信，以符合指定的协议
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
     1. 使用jstack pid得到java执行栈，然后grep16进制找到相应的信息
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
     1. dmesg：显示内核相关信息
   - 系统版本
     1. `cat /etc/redhat-release`：查看centos版本
     1. `cat /proc/version`：查看内核版本
     1. `getconf LONG_BIT`：查看centos位数
   - 硬件
     1. `cat /proc/cpuinfo`：cpu信息
     1. `lscpu`：cpu信息
   - 硬盘
     1. `cat /proc/meminfo`：查看物理内存和文件缓存情况
   - 状态
     1. vmstat
     1. iostat
     1. netstat
     1. nicstat
     1. pidstat
     1. mpstat
        - 认识：Multiprocessor Statistics，实时系统监控工具，查看cpu信息
        - 使用
          1. `mpstat`：从启动以来的平均值
          1. `mpstat 5 2`：生成2个间隔5秒的报告
          1. `mpstat -P ALL 5 2`：分别查看每个cpu
   - 全局监控
     1. top/htop：查看系统性能，htop高亮，3秒刷新一次
     1. sar：System Activity Reporter 系统活动情况报告，最全面的系统性能分析工具之一，可以看文件读写、系统调用情况、磁盘I/O、CPU效率、内存使用、进程活动及IPC等
        - -A：所有报告的总和

        - -p：报告每个CPU的状态
        - –u：输出cpu使用情况和统计信息

        - -R：显示内存状态
        - -B：显示换页状态
        - -r：报告内存利用率的统计信息
        - -w：显示交换分区的状态

        - -b：显示I/O和传递速率的统计信息
        - -d：输出每一块磁盘的使用信息
     
        - -x：显示给定进程的装

        - –v：显示索引节点、文件和其他内核表的状态
        - -e：设置显示报告的结束时间
        - -f：从制定的文件读取报告
        - -i：设置状态信息刷新的间隔时间
     1. dstat
        - -tpcdrmgln 2 2：刷新
        - --output xx.csv：输出，用excel生成趋势图
        - -m：内存
        - -s：交换分区
        - -r：io
        - -p：进程
        - -ipc：ipc消息队列、信号
        - lock
        - --socket/--udp/--tcp：tcp、udp端口状态
1. 环境变量
   - 认识：系统预定义的参数。window也有。作用：在程序里可以获得环境变量的值，根据值决定如何操作，运行，找路径，文件夹等等
     1. SHELL：当前用户使用的Shell
     1. HOSTNAME：主机名
     1. LANG：系统所用语言，`echo $LANG`
   - 组成
     1. `/etc/bashrc或/etc/profile或/etc/environment`：全局
     1. `~/.bashrc或~/.bash_profile或~/.bash_login`：个人
   - 操作
     1. `set`
     1. `env`：显示当前用户所有变量
     1. `export`：显示系统定义的所有环境变量
     1. `echo $SHELL`：查看
     1. `export PATH=xx:$PATH`：临时修改PATH，用:连接，用$PATH防止覆盖。仅对当前用户立即生效，关闭窗口后无效，
     1. `source .bash_profile`：使生效，修改后要么重新登录要么用source
1. 输入输出
   - 分类
     1. 标准输入文件stdin 0
     1. 标准输出文件stdout 1
     1. 标准错误输出文件stderr 2
   - 命令
     1. echo：输出，-e 支持反斜线控制的字符转换，\a 警告音 \n 换行键 \r 回车键 \t 制表符，Tan键 \v 垂直制表符
     1. print：默认带换行符，printf 没有
     1. write/wall：给同一台机器正在登录的其他用户发消息，历史上最古老的即时通信，wall给所有人发
1. 命令
   - 执行
     1. sudo、su、setfacl
     1. command1 && command2，可以一次执行两个命令，前一个报错则停止运行
     1. echo &?：获取上一条命令的错误码
     1. watch：可以重复执行命令，默认2秒间隔，搭配cat方便查看文件内容`watch cat xx`
        - -n：执行间隔时间
        - -d：高亮显示变化的区域
   - 重定向
     1. |：管道，前面输出作为后面输入。`cat file.txt | uniq | grep txt | sort`
     1. > >>：输出
        - `more file1 file2 file3 > file2`：清空file2
        - `cat file1 1 >> file2`：追加，1标准输出流
        - `> file3`：清空文件
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
     1. man/info：查看命令手册。帮助一般为：-h/-help/--help
     1. 输出语句中有空格需加双引号
1. 日志
   - 认识：一般保存在/var/log目录下，linux日志守护进程为syslog，希望生成日志的程序都可以向syslog发送信息。发行版的日志系统都略有差异
     1. 类别
        - kern：系统内核
        - local0.local7：由自定义程序使用
        - auth/authpriv：用户认证日志，如login/su命令
        - ftp：ftp服务
        - cron：定时任务
        - daemon：守护进程
        - console：系统控制台
        - lpr：打印机
        - mail：邮件
        - mark：产生时间戳，系统每隔一段时间向日志文件中输出当前时间，每行的格式类似于 May 26 11:17:09 rs2 -- MARK --，可以由此推断系统发生故障的大概时间
        - news：网络新闻传输协议(nntp)
        - ntp：网络时间协议(ntp)
        - user：用户进程
     1. 优先级：emerg、alert、crit、err、warning、notice、info、debug
     1. 常用日志文件
        - /var/log/boot.log：系统开机自检
        - /var/log/syslog：只记录警告信息，常常是系统出问题的信息
        - /var/log/messages ：常见的系统和服务
        - /var/log/secure ：Linux系统安全日志，记录用户和工作组变坏情况、用户登陆认证情况
        - /var/log/btmp ：记录Linux登陆失败的用户、时间以及远程IP地址
        - /var/log/lastlog ：最后一次用户成功登陆的时间、ip等信息
        - /var/log/wtmp：该日志文件永久记录每个用户登录、注销及系统的启动、停机的事件，使用last命令查看
        - /var/run/utmp：该日志文件记录有关当前登录的每个用户的信息。如 who、w、users、finger等就需要访问这个文件
   - 命令
     1. journalctl：查看内存日志
     1. last：显示所有登入系统的用户信息
     1. lastlog：所有用户最后一次登录的时间信息
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
     1. 2  不完全多用户，不含NFS服务
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
1. 时间
   - date：查看时间
     1. -s：设置系统时间
   - timedatectl：查看时间详细信息，时区等
   - chronyc：centos7.2开始用chrony同步时间
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
   - RedHat
     1. RHEL：Redhat Enterprise Linux，红帽的企业级商业化版本。红帽：来源于开源社区，服务于开源社区
     1. Fedora：红帽赞助的社区免费版本，有点像实验版本，经过测试稳定后，增加的特性和功能会迁移到RHEL上
     1. Centos：模仿红帽企业版的免费版本，无法得到红帽公司的商业支持，但可以获得开源社区的维护和支持，使用上相差无几
   - SUSE
     1. SUSE Linux Enterprise：novell公司的商业化版本
     1. openSUSE：novell公司的社区版本
   - Debian
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
   - GUN：GUN's Not UNIX，GUN计划，自由软件计划，参与者包括emacs、gcc、linux，即革奴计划，理查德·斯托曼1983年发起，目标打造出一套完全自由（即自由使用、自由更改、自由发布）、开源的操作系统
1. 命令
   - i       忽略大小写
   - n       显示行号
   - r/-R    一般没区别
   - 字符串参数最好采用是双引号括，一是以防被误解为shell命令，二是可以用来查找多个单词组成的字符串
1. 命令的语法风格
   - UNIX 风格：选项可组合，选项前必有“-”连字符
   - BSD 风格：选项可组合，选项前不能有“-”连字符
   - GNU 风格：选项前有两个“-”连字符
