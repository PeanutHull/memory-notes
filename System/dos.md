### 操作
1. 目录操作
    ```
    cd           显示当前目录或改变目录
    cd ..        退回上级目录
    c：          进入C盘
    dir          显示目录中文件和子目录，查看文件
    md/mkdir     创建目录
    ```
1. 文件操作
    ```
    cd .>a.txt                    创建
    del                           删除
    copy C:\1\mima.txt C:\2\      复制
    find                          查找
    ```
1. 其他
    ```
    cls                 清屏
    calc                计算器
    regedit             注册表
    edit                文本编辑器
    exit                退出cmd
    netsh               强大的命令行下修改tcp/ip配置的工具
    shutdown -h now     关机
    rononce -p          15秒关机
    ```
### 应用
1. 使cmd后台运行
   - 将脚本写入xxx.cmd
   - 在xxx_hide.vbs中写入
        ```
        // /c后面是所要隐藏的脚本名
        Set ws = CreateObject("Wscript.Shell")
        ws.run "cmd /c redis_server.cmd",vbhide
        ```
   - 执行xxx_hide.vbs即可
1. 杀掉pid
```
tasklist|find -i "redis"           // 获得pid
taskkill /f /pid *                 // 强制杀掉pid
```
### wiki
1. cmd 在windows下是DOS模拟器
1. 在当前目录的地址栏输入cmd，进入对应目录cmd
1. 操作系统
   - MS-DOS
     1. 认识：微软磁盘操作系统，是早期windows系统用的一种硬盘操作系统，就是提供硬盘的访问功能
     1. 历史
        - 1980，微软购买一名24岁程序员写的86-DOS的全部版权，并更名为MS-DOS。买下版权，推向市场
        - 之后windows 1.x/2.x/3.x/9x/Me全部是基于MS-DOS的图形用户界面程序，windows NT不需要dos
        - windows2000(NT 5.0)/XP(NT 5.1)/Vista(NT 6)/7(NT 6.1)，才抛弃MS-DOS
   - NT：New Technology，从零设计 从零开发的一个操作系统
   - OS/2：Operating System/2，IIBM设计、微软协助开发的操作系统，受DOS在PC上的巨大成功影响而开发。2005年停止开发
   - Macintosh
     1. 1984年，其具备的全图形化操作界面设计，以及使用鼠标操作的方式，为操作系统产业界带来革命性的概念。微软仍还停留在DOS文字界面
     1. 1988年，IBM终于在OS/2 1.1版套上的图形界面，并成为在Intel CPU上的首个多工操作系统。后来，微软利用了与IBM合作得来的系统开发经验和技术用来开发自己的Windows 3.0操作系统，荒废了与IBM的合作。IBM得知微软的盘算之后，便和微软分道扬镳，从此完全自主进行OS/2的后续版本更新
     1. OS/2高稳定性，全世界第一个真正的全32位操作系统，稳定性远优于当时的所有竞争操作系统。Window 95使用了32/16位混合设计，用以兼容过去的老应用，消费者纷纷投向Windows平台。而虽然后续的Windows 98/98SE与ME就只是个金玉其外的垃圾，尤其是后二者，在正常使用下一段时间后就会自我崩溃，使用者往往不得不隔一段时间就重新安装，稳定性极差