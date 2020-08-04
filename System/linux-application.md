### 解决方案
1. SELinux：Security Enhanced Linux，安全强化Linux，是强制访问控制系统的一种实现，用于指明进程可以访问的资源，增强系统抵御0-Day的攻击
   - 特点：可查看、热更改、进程初始化/继承/执行三方面进行策略控制、控制范围包括文件系统/目录/文件/文件启动描述符/端口/消息接口/网络接口
   - 使用
     1. getenforce、/usr/sbin/sestatus -v：运行状态，Enforcing/Permissive/Disabled，记录警告并阻止/记录警告不阻止/禁用
     1. setenforce：Enforcing|Permissive|1|0，切换状态保持至关机，从Disabled切出时，要重启并重新创建安全标签(touch /.autorelabel && reboot)
     1. /etc/sysconfig/selinux、/etc/selinux/config：永久修改，修改后重启
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
        - 实际应用配置
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
        - xes的tw配置
            ```conf
            [program:confd-tw]
            command=/usr/local/bin/confd -config-file /home/www/confd-tw/etc/confd-tw.toml
            autostar=true
            autorestart=true
            redirect_stderr=true
            stdout_logfile =/dev/stdout
            stderr_logfile=/dev/stdout
            loglevel=info
            startretries=3000
            stopwaitsecs=300
            startsecs=10
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
   - 理解：域名解析服务，域名和ip的绑定查询，一级级的往上查询，使用UDP协议，53端口
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
   - httpDNS：指通过ip和http协议直接访问dns服务器获取解析，绕过本地运营商。因为智能dns有很多弊端，如nat转换导致解析链路加长等原因，移动端用的多
1. tumx：多个界面，断网保存用户操作的界面
1. 数据恢复工具：ext3grep
### 性能监控
1. cpu工具
   - ps
     1. %CPU：cpu使用占比
     1. %MEM：内存使用占比
     1. VSZ：虚拟内存大小
     1. RSS：占用物理内存大小，kb
     1. STAT：进程状态
     1. TTY：命令所运行的位置(终端)
     1. START：进程开始时间
     1. TIME：占用CPU的时间
     1. COMMAND：所执行的命令
   - top
     1. 功能
        - 基础：系统时间，系统运行时间，登录用户数，平均负载
          1. 平均负载：1、5、15分钟的指标，每5秒检查活跃进程数，特定算法算出，除以逻辑cpu数量高于5表示高负荷运转
        - 进程数：总数、运行数、休眠数、停止数
        - cpu使用率
        - 内存使用率
          1. total
          1. free：内核还未纳入控制的大小，纳入内核管理的内存不一定都在使用中，还包括过去使用过的现在可以被重复利用的内存，内核并不把这些可被重新使用的内存交还到free中去，因此linux上free内存会越来越少，但不用担心
          1. used：内核使用的内存
          1. buff/cache：缓存的内存大小
        - 内存交换率：swap
          1. total
          1. free
          1. used
          1. avail Mem
     1. 参数解读
        - USER：进程所有者
        - PR：进程优先级
        - NI：nice值
        - VIRT：virtual memory usage，指进程使用的虚拟内存总量，单位kb，VIRT = SWAP + RES
          1. 进程“需要的”虚拟内存大小，包括进程使用的库、代码、数据等
          1. 假如进程申请100m的内存，但实际只使用了10m，那么它会增长100m，而不是实际的使用量
        - RES：resident memory usage 指进程使用的、未被换出的内存大小，RES = CODE + DATA
          1. 进程当前使用的内存大小，但不包括swap out
          1. 包含其他进程的共享
          1. 如果申请100m的内存，实际使用10m，它只增长10m，与VIRT相反
          1. 关于库占用内存的情况，它只统计加载的库文件所占内存大小
        - SHR：shared memory 共享内存。计算某个进程所占的物理内存大小公式：RES – SHR
        - S：进程状态
        - %MEM：进程使用的物理内存百分比
        - TIME+：进程使用的CPU时间总计
     1. 使用
        - `shift+p`：占用cpu最高的进程
        - `top -Hp pid`：占用CPU最高的线程
        - `x`：高亮排序的列
        - `shift >/shift <`：左右切换高亮排序的列
   - mpstat
        - usr：用户态的cpu时间百分比，不包含nice值为负进程
        - nice：nice值为负进程的cpu时间百分比
        - sys：核心时间百分比
        - iowait：硬盘IO等待时间百分比
        - irq：硬中断时间百分比
        - soft：软中断时间百分比
        - steal：显示虚拟机管理器在服务另一个虚拟处理器时虚拟cpu处在非自愿等待下花费时间的百分比
        - guest：显示运行虚拟处理器时cpu花费时间的百分比
        - gnice
        - idle：cpu除去等待磁盘IO操作外的因为任何原因而空闲的时间闲置时间百分比
        - intr/s：每秒cpu接收的中断总数
1. 内存工具
   - free：分mem和swap两种，free的数据和top中的一致
   - vmstat
     1. 参数解读
        - r：run queue，运行队列里等待cpu的个数
        - b：被资源阻塞(blocked)的任务数(io/页面调度等)，通常接近0
1. 硬盘工具
   - sar
     1. -r：内存
        - kbmemfree：类似free命令的free，所以不包括buffer和cache
        - kbmemused：类似free命令的used，所以包括buffer和cache
        - %memused：kbmemused和内存总量(不包括swap)的百分比
        - kbbuffers和kbcached：free命令的buffer和cache
        - kbcommit：保证当前系统所需要的内存，即为了确保不溢出而需要的内存(RAM+swap)
        - %commit：kbcommit与内存总量(包括swap)的百分比
     1. -d 2 3：io
        - DEV：设备编号
        - tps：实际每秒的io次数，多个逻辑请求可能合成一个io请求
        - avgrq：请求的平均大小
        - avgqu：请求的平均队列长度
        - await：每次io操作的平均等待时间，包括队列和服务的时间，单位ms。和svctm接近则性能很好，高的话就io等待了
        - svctm：每次io操作的平均服务时间，单位ms
        - %util：向设备发送io操作的时间占比(设备的带宽利用率)，接近100%，则已满负荷，越高负荷越重
     1. -n：network
        - IFACE：网络设备名称
        - rxpck/s：接收包数/每秒钟
        - txpck/s：发送包数/每秒钟
        - rxkB/s：接收字节数/每秒钟
        - txkB/s：发送字节数/每秒钟
        - rxcmp/s：接收压缩包数/每秒钟
        - txcmp/s：发送压缩包数/每秒钟
        - rxmcst/s：接收的多播包包数/每秒钟
   - iotop
     1. read/write_bytes/s
     1. TID
     1. PRIO
     1. DISK READ/WRITE
     1. SWAPIN
     1. IO>
   - iostat：cpu信息、读写速率、读写字节数大小
     1. rrqm/s、wrqm/s：进行merge的读写操作数量/每秒
     1. r/s、 w/s：完成读写io设备次数/每秒
     1. Blk_read/s、Blk_wrtn/s：块数/每秒
     1. Blk_read/Blk_wrtn：取样时间间隔内 读写扇区数量
     1. rsec/s、wsec/s：读写扇区数/每秒
     1. rkB/s、wkB/s：每秒读写kb/每秒。是rsect/s的一半，因为每扇区大小为512字节
     1. avgrq-sz：平均每次设备io操作的数据大小 (扇区)
     1. avgqu-sz：平均io队列长度
     1. await：平均每次设备io操作的等待时间 (毫秒)
     1. svctm：平均每次设备io操作的服务时间 (毫秒)
     1. %util：一秒中有百分之多少的时间用于 io 操作，或者说一秒中有多少时间io队列是非空的
1. 网络工具
   - netstat
     1. Active Internet connections
        - Proto：协议，tcp
        - Recv-Q
        - Send-Q
        - Local Address
        - Foreign Address：ip:port
        - State：ESTABLISHED
     1. Active UNIX domain sockets
        - Proto
        - RefCnt
        - Flags
        - Type：DGRAM、STREAM
        - State：CONNECTED
        - I-Node
        - Path：执行的命令
   - nicstat：solaris平台下的，需要安装
1. 进程
   - pidstat
     1. CPU：处理进程的cpu编号
     1. Minflt/s：任务每秒发生的次要错误，不需要从磁盘中加载页
     1. Majflt/s：任务每秒发生的主要错误，需要从磁盘中加载页
     1. kB_rd/s：每秒从磁盘读取的kb
     1. kB_wr/s：每秒写入磁盘kb
     1. kB_ccwr/s：任务取消写入磁盘的kb。当任务截断脏的pagecache的时候会发生
     1. Cswch/s：每秒主动任务上下文切换数量
     1. Nvcswch/s：每秒被动任务上下文切换数量
     1. TGID：主线程的表示
     1. TID：线程id
1. 指标
   - cpu
     1. 缩写
        - id：CPU完全空闲百分比，不包括i/o等待时间，`idle`
        - sy：内核空间和中断占用CPU百分比，`system`
        - us：用户空间占用CPU百分比，`user space`
        - wa：io等待占比，`io wait`

        - cs：每秒做上下文切换的数，`context switch`
        - in：每秒被中断数，`interrupts`
        - hi：硬中断占比，`hardware interrupts`
        - si：软中断占比，`software interrupts`
        - ni：nice值，改变过优先级的进程占比，负值表示高优先级，正值表示低优先级
        - st：被Hypervisor偷去给其它虚拟机使用的CPU时间占比，steal time
     1. 认识：如sy高us低，以及高cs，说明应用程序进行了大量的系统调用
        - CPU利用率
          1. User Time <= 70%
          1. System Time <= 35%
          1. User Time + System Time <= 70%
        - 上下文切换：与CPU利用率相关联，如果CPU利用率状态良好，大量的上下文切换可接受
        - 可运行队列：每个处理器不超过3个线程
   - 内存：数据源头在/proc/meminfo
     1. 指标
        - memory
          1. total：不包括内核使用的总内存大小
          1. used：被使用的内存总额
          1. free：自由物理内存大小，单位kb
          1. buff：被用来缓存读写操作的大小，做磁盘缓存。缓存满了一次写，提高io性能(内存 -> 磁盘)
          1. cache：被用来缓存进程地址空间的大小，做文件缓存区。读取过的数据缓存起来，减少io(磁盘 -> 内存)，会动态调整
          1. share：多进程共享的内存总额
        - swap
          1. swpd：已使用的swap空间大小
          1. si：swap in，到内存的速率，单位block/s
          1. so：swap out，从内存出的速率
        - /proc/meminfo
          1. MemAvailable：MemFree不能代表全部可用的内存，有些内存虽被使用但可回收。MemAvailable = MemFree + 可回收的cache/buffer/slab等，这是系统估算值，不准确
          1. Buffers：直接访问块设备时缓冲区的总大小，有时对文件系统元数据的操作也会用到buffers。这部分内存不好直接对应到某个用户进程，应该算作kernel占用
          1. Cached：包括所有file-backed pages
          1. Mapped/LRU/Hugepages
     1. 认识
        - 留30%的内存
        - swap大小越少内存越够，如果swap的used不断变化，说明内存不够用，cpu在频繁进行内存和swap的数据交换
        - swap操作可导致io性能下降
        - 延迟、冲突、阻塞等因素影响机器性能
        - 内存黑洞：kernel没有统计所有内存分配，如动态分配的一部分，所以用量总和物理内存对不上
   - 硬盘：busy-percent、msec-weighted-total(io完成时间和积压)
     1. 指标
        - read/write_bytes：大小
        - read/write-ms&num：速率
        - free-mount：剩余空间
        - inodes-free：inode空余
        - bi：每秒读取的块数，块大小为1024bytes
        - bo：每秒写入的块数
     1. 认识
        - iowait % < 20%
        - 提高性能可以提高命中率，一个方法为增大文件缓存区面积，缓存区越大预存的页面就越多，命中率也越高。内核希望尽可能产生次缺页中断（从文件缓存区读）并避免主缺页中断（从硬盘读），随着次缺页中断的增多文件缓存区也越大，直到系统只有少量可用物理内存的时候linux才开始释放一些不用的页
   - 网卡：received、transmitted、drop、time-wait数量、reqTime、5xx次数、out/in/dropped_bytes、out/in/dropped_packets、abort-ontimeout(达到最大重试时间/次数的次数)、time-outs(超时重传时间)
     1. 认识
        - 接收/发送缓冲区等待处理的网络包耗时较少
   - 进程：fpm active processes
     1. 进程状态
        - R：正在执行中，run
        - S：静止状态，sleep
        - T：暂停执行，traced
        - D：无法中断的休眠状态(通常io等待的进程)
        - Z：不存在但暂时无法消除，僵尸进程
        - <：高优先序的行程
        - N：低优先序的行程
        - W：没有足够的记忆体分页可分配
        - L：有记忆体分页分配并锁在记忆体内 (实时系统或I/O)
     1. cpu相关
        - %guest：进程在虚拟机占用cpu的百分比
1. 分析
   - 很多参数可以看到系统从重启以来的数据，这个可用于分析系统平均负载
   - 内存
     1. VSZ：当程序真正用到内存时，内核再映射到物理内存
     1. 内存够用，si和so基本都是0，长期大于0，磁盘和cpu都被消耗，系统性能受影响
     1. free要和si、so一起看，free很少，si和so也很少、不代表系统性能不足
   - vmstat/mpstat差别：mpstat可显示每个处理器的统计，而vmstat显示所有。可用于分析程序运行的cpu均衡性
### 优化
1. 问题定位
   - strace：跟踪系统调用的执行
   - tcpdump
1. 问题解决
1. irqbalance
### 软件安装
1. 软件安装
   - RedHat
     1. rpm：以.rpm结尾的软件包名称，方便安装/升级/卸载，不能处理包依赖
        - -q：查询
        - -q afilcdR：查询已安装的，文件名绝对路径，安装包信息，安装目录，配置文件，文档位置，所依赖的文件
        - -qpi：查询未安装的，版本信息
        - –requires：显示依赖信息
        - -i：安装
        - -ivh：安装，显示文件信息，显示安装进度
        - -U：升级
        - -Uvh：升级，显示文件信息，显示安装进度
        - -e：卸载，先用-q查询名称
        - --import：签名导入
     1. yum：Yellow dog Updater Modified，包管理工具，基于rpm，epel是yum的扩展源
        - 参数
          1. search/info
          1. install/update/remove
          1. list/info installed/updates
        - 查看安装的服务：`rpm -qa | grep xx`
        - 查看安装的位置：`rpm -ql xx`
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
1. ssh省去输入密码
   - ssh -kengen
   - cd ~/.ssh
   - ssh -copy-id peter@happypeter.net       // 把公钥复制到服务器上
### 运维相关
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
### wiki
1. 快捷键
   - ctrl+s     暂停该终端，ctrl+q恢复
   - ctrl+z     把当前进程转到后台运行，使用 fg 命令恢复
   - ctrl+u     清除光标前至行首间的内容
   - ctrl+k     清除光标后至行尾的内容
   - ctrl+y     粘贴或者恢复上次的删除
   - ctrl+l     清屏，相当于clear
