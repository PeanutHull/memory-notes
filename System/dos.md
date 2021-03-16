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