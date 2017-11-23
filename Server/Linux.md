1. 环境变量
   - /etc/profile：全局环境变量
   - /.bash_profile：个人环境变量
   - souurce /.bash_profile：使生效
   - export PATH=：书写格式
1. 进程后台运行：processName &
1. 查看运行的进程：ps aux | grep xxx
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