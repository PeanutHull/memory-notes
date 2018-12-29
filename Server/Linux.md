### 基础
1. 环境变量：系统预定义的参数。window也有。作用：在程序里可以获得环境变量的值，根据值决定如何操作，运行，找路径，文件夹等等
   - /etc/profile：全局
   - .bash_profile：个人
   - source .bash_profile：使生效
   - export PATH=：书写格式
1. 重定向
   - 管道：|，前面输出作为后面输入，依次类推。`cat file.txt | uniq | grep txt | sort`
   - 输出：>，>>
     1. more file1 file2 file3 > file2：清空file2
     1. cat file1 1 >> file2：追加，1标准输出流
   - 输入：< <<(表示当前命令的标准输入为来自命令行中一对分隔号之间的内容)
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
1. 运行
   - command1 && command2，可以一次执行两个命令，前一个报错则停止运行
   - 将程序后台执行：&
   - echo &?：获取上一条命令的错误码
   - tee：将程序的输出结果重定向，同时显示和保存。`echo "127.0.0.1 foobar" | sudo tee -a /etc/hosts`
### 文件和目录
1. 查看
   - ls
     1. -ld：查看目录详细
     1. -lh：以兆查看文件大小
   - tree
   - cat：查看文件内容
     1. `cat file1 file2`：同时查看两个文件
     1. `cat -n file | grep ''| more`：分页查看
     1. `cat file > xxx.txt`：将显示结果保存到文件
     1. `cat -n file | tail -n +92 | head -n 20`：92行之后的查询结果中显示前20
   - less/more：分页查看内容，只有less支持卷动
     1. enter：下一行
     1. 空格|n：下一屏
     1. /：字符查找，n查找下一次，gg到文件头，G到文件尾，q退出
   - head：输出文件头
     1. -n：行数
   - tail：输出文件尾
     1. -f：不停显示
   - uniq：唯一显示
   - sort排序显示
   - file：查看文件详细
1. 搜索
   - find：一参指定目录
     1. -type f/d：f文件，d目录
     1. -name：全匹配
     1. -exec：查询文件内容，显示行号-n，显示文件名-print。`find . -type f -exec grep -n 内容 '{}' ';' -print`
   - locate：系统全局范围定位文件，从database中查找数据，一般一天更新一次database，更新文件数据库`sudo updatedb`
     1. --regexp：正则
   - whereis
   - which：查看程序安装位置
1. 操作
   - 切换
     1. cd            回到用户主目录
     1. cd ../../     连续向上
     1. cd -          回到上一次的目录
     1. pwd
   - 复制/移动/删除
     1. cp -r dir1 dir2
     1. mv file dir/
     1. rm -r dir
     1. rename
     1. unlink
   - 创建
     1. mkdir -p dir/dir：递归创建
     1. vi/vim file
     1. touch file
   - 链接，ln，文件或目录
     1. 硬链接：多个路径指向一个inode号，最后inode号删除才删除文件，可防止误删除，默认硬链接
     1. 软连接：-s，即符号链接，类似快捷方式
1. 知识
   - .开头的文件和目录都是隐藏的
   - 只显示目录，目录为蓝色，-l参数下-为文件、d为目录、l为符号链接
   - 重要文件防删除
     1. chattr +i filename      加提醒
     1. chattr -i filename      解除
### 用户、权限
1. 用户和用户组
   - 查看
     1. /etc/passwd
     1. /etc/group
   - 操作
     1. id
     1. useradd/usermod
     1. groupadd/groupmod/groupdel
   - 命令
     1. who、w：显示当前用户
     1. passwd：修改密码
1. 权限
   - 分类：r、w、x
   - 文件模式：即rwxr-r--，如何控制权限
   - 目录权限
     1. r：可查看目录下内容
     1. w：对目录里文件进行创建、删除、重命名等操作
     1. x：可cd目录，一般有
   - 操作
     1. chmod：以8进制控制文件模式
     1. chown
        - -R：递归修改
        - +x：添加
     1. owner
     1. group
     1. setfacl
     1. chgrp
### 进程、系统
1. 系统
   - uname -a 显示系统信息
   - uptime：当前系统时间、开机到现在运行时间、用户在线数、系统平均负载
   - free
     1. -m 以兆显示内存状态
   - runlevel：查看系统运行级别，修改系统默认运行级别`cat /etc/inittab id:3:initdefault:`
   - sudo、su、setfacl
1. 进程
   - 查看
     1. ps：显示系统运行状态
        - aux：pid，process ID，进程号
     1. top：查看活跃进程
        - VIRT：virtual memory usage 虚拟内存
          1. 进程“需要的”虚拟内存大小，包括进程使用的库、代码、数据等
          1. 假如进程申请100m的内存，但实际只使用了10m，那么它会增长100m，而不是实际的使用量
        - RES：resident memory usage 常驻内存
          1. 进程当前使用的内存大小，但不包括swap out
          1. 包含其他进程的共享
          1. 如果申请100m的内存，实际使用10m，它只增长10m，与VIRT相反
          1. 关于库占用内存的情况，它只统计加载的库文件所占内存大小
        - SHR：shared memory 共享内存
          1. 计算某个进程所占的物理内存大小公式：RES – SHR
          1. pstree
          1. pidof：打印pid
   - 操作
     1. kill/pkill/killall：杀死所有fpm`ps -ef|grep php-fpm|awk -F ' ' '{print $2}'|xargs kill -9`
        - -USR2 pid
        - -QUIT：从容
        - -TERM：快速
        - -9 pid：强制
1. 知识
   - 整个桌面进程都拖死，因为linux运行着7个工作台的，切到第一个工作台，杀死那个进程，ctrl+alt+1
### 网络
1. 网络
   - ifconfig：显示当前网络接口状态、配置网络
     1. -a：inet addr，ip地址
   - netstat：显示网络连接/运行端口/路由表等
     1. anpt：查看端口占用，`netstat anpt | grep 80`
   - traceroute：显示网络数据包传输到指定主机的路径信息，追踪数据传输路由状况
   - ping
   - host
   - nethogs: 将进程按网络流量列表显示
   - lsof
     1. i:80：查看端口号，root用户查看
1. 操作
   - telnet：使用telnet协议通信
   - curl
   - elinks
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
1. 数据传输
   - rsync
     1. -r：同步
     1. -av：同步文件，删除--delete
   - scp
     1. 上传：scp [-r] local addr@ip:/addr
     1. 下载：scp [-r] addr@ip:/addr local
   - rcp
   - ftp
   - ssh
     1. ssh addr@ip
### 磁盘
1. mount/umount：挂载
1. df：查看磁盘占用情况
1. du
1. fsck：检查文件系统，并尝试修复
1. mkfs
1. fdisk
1. parted
1. iotop: 将进程按磁盘写次数排序，并且显示程序写磁盘的次数和频率
1. 文件系统
   - 文件树：一根文件数，根目录为/
   - 分区：sda1、sda2
   - 挂载点：把sda1挂载到根目录/上，则所有数据都在sda1分区。当sda2挂载到/home，则数据到了sda2的分区下 
### 应用
1. 压缩、解压缩
   - tar
     1. tar.gz
        - zxvf       解压缩
        - zcvf       压缩
     1. tar.bz2
        - jxvf       解压缩
        - jxvf       压缩
   - bzip2/bunzip2
   - gzip/gunzip
   - zip/unzip
1. 时间
   - date
     1. -s：设置系统时间
1. 定时任务
   - crontab：linux原生定时器
     1. -l
     1. -e： 添加，* * * * *(分时日月周) php index.php >> index.log
     1. at：执行一次，`at 2:00 tomorrow`
   - 运维
     1. service crond start/stop/restart/reload/status
     1. chkconfig -level 35 crond on       加入开机启动
     1. ntsysv                             查看是否开机启动
### 操作
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
        - 配置yum源：配置分两部分，全局配置项为/etc/yum.conf，定义每个源/服务器的具体配置在/etc/yum.repo.d的rep文件
   - Debian
     1. deb/dpkg：软件包名称，比rpm晚，`dpkg -l`
     1. apt-get：包管理工具，基于deb。`install/remove/purge`
1. 启动
   - chkconfig：开机启动项
     1. --list
     1. --add/--del name
     1. --level 2345 name on/off
   - shutdown：关机、重启，是最安全的会保存用户的配置和服务。halt、poweroff、init 0：关机，reboot init 6：重启
     1. -h：关机
     1. -r：重启
     1. -c：取消前一个关机命令
### 运维
1. 组成
   - 基础：配机器
   - 私有云：openstack
   - 监控
   - 网络
   - 开发：配套工具和功能开发
1. 分类
   - 监控
   - 部署
     1. openstack
        - 网络：neutron：flat\flatdhcp\vlan
        - 可视化：horizon
        - 块存储：cinder
        - 计算：nova
        - 镜像：glance
        - 认证：keystone
     1. 远程控制：saltstack，分主从，salt-master和salt-minion
   - cmdb
1. 技术
   - nat：网络地址转换服务，可基于状态过滤连接（就是内网出去的能回来，其他进不来），可做对外网的口子
   - lvm：逻辑卷管理，动态扩缩容
   - DNS：智能dns，DNS view，可根据用户ip返回不同的ip，解决了同域名不同解析地址问题，使用bind 9
### wiki
1. linux分类
   - RedHat系列：Redhat、Centos、Fedora等
     1. cat /etc/redhat-release：查看centos版本
     1. getconf LONG_BIT：查看centos位数
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
1. 输入输出方式
   - 标准输入文件stdin0
   - 标准输出文件stdout1
   - 标准错误输出文件stderr2
1. 运行级别
   - 0  关机
   - 1  单用户，即window的安全模式，启动最小的程序模式，多用于修复系统
   - 2  不完全多用户，不含NFS服务。NFS是linux的文件共享服务
   - 3  完全多用户，标准的运行级
   - 4  未分配
   - 5  图形界面
   - 6  重启
1. 特点
   - linux对后缀不敏感
   - 输出语句中有空格需加双引号
   - man：查看命令手册
   - logout、exit：退出
1. 参数
   -i       忽略大小写
   -n       显示行号
   -r/-R    一般没区别
1. SELinux：Security Enhanced Linux，安全强化Linux，是强制访问控制系统的一种实现，用于指明进程可以访问的资源，增强系统抵御0-Day的攻击
   - 特点：可查看、热更改、进程初始化/继承/执行三方面进行策略控制、控制范围包括文件系统/目录/文件/文件启动描述符/端口/消息接口/网络接口
   - 使用
     1. getenforce、/usr/sbin/sestatus -v：运行状态，Enforcing/Permissive/Disabled，记录警告并阻止/记录警告不阻止/禁用
     1. setenforce：Enforcing|Permissive|1|0，切换状态保持至关机，从Disabled切出时，要重启并重新创建安全标签(touch /.autorelabel && reboot)
     1. /etc/sysconfig/selinux、/etc/selinux/config：永久修改，修改后重启
1. 快捷键
   - ctrl+s     暂停该终端，ctrl+q恢复
   - ctrl+z     把当前进程转到后台运行，使用 fg 命令恢复
   - ctrl+u     清除光标前至行首间的内容
   - ctrl+k     清除光标后至行尾的内容
   - ctrl+y     粘贴或者恢复上次的删除
   - ctrl+l     清屏，相当于clear
1. iTerm快捷键设置：Profiles->Keys
   - ctrl + a/e：移动到行首尾
   - ctrl + ←/→：单词移动，需设置`Send Escape Sequence + d/f`
   - shift + ←/→：单词选择，需设置`Move Start of Selection Left By Word`，`Move End of Selection Right By Word`
   - ctrl + w：单词删除
1. tumx：多个界面，断网保存用户操作的界面