1. 环境变量
   - /etc/profile：全局环境变量
   - /.bash_profile：个人环境变量
   - souurce /.bash_profile：使生效
   - export PATH=：书写格式
1. 进程后台运行：processName &
1. 查看运行的进程：ps -ef/aux | grep xxx
1. 关闭应用程序
   - 从容停止：kill -QUIT MasterProcessNumber
   - 快速停止：kill -TERM MasterProcessNumber
   - 强制停止：kill -9 programName/nginx
1. 查看centos版本：cat /etc/redhat-
1. 查看ip：ifconfig -a中的inet addr
1. VirtualBox安装虚拟机以及调通网络
   - 安装：http://blog.csdn.net/risingsun001/article/details/37934975
   - 调通网络
     1. vi /etc/sysconfig/network-scripts/ifcfg-eth0
        ```
        NM_CONTROLLED=no
        ONBOOT=yes  #自动启动
        BOOTPROTO=dhcp  #动态IP
        ```
     1. service network start
   - 调通ssh：http://blog.csdn.net/risingsun001/article/details/38040451
1. SELinux：Security Enhanced Linux，安全强化Linux，是强制访问控制系统的一种实现，用于指明进程可以访问的资源，增强系统抵御0-Day的攻击
   - 特点：可查看、热更改、进程初始化/继承/执行三方面进行策略控制、控制范围包括文件系统/目录/文件/文件启动描述符/端口/消息接口/网络接口
   - 使用
     1. getenforce、/usr/sbin/sestatus -v：运行状态，Enforcing/Permissive/Disabled，记录警告并阻止/记录警告不阻止/禁用
     1. setenforce：Enforcing|Permissive|1|0，切换状态保持至关机，从Disabled切出时，要重启并重新创建安全标签(touch /.autorelabel && reboot)
     1. /etc/sysconfig/selinux、/etc/selinux/config：永久修改，修改后重启