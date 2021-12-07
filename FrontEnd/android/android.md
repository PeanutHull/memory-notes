### android
1. 组件
   - retrofit：网络框架，对okhttp的封装，用来发api
   - butterknife：view注入和绑定框架
   - glide：图片加载框架，网络/本地
   - dbflow：数据库框架，编译时注解，性能及其接近原生
1. im：即时通信，四大协议
   - IMPP：即时信息和空间协议
   - XMPP：可扩展通信和表示协议，基于xml
   - SIMPLE：SIP，对impp的扩充协议
   - PRIM：不用了
1. 文件
   - apk
   - jar
   - dex
     1. 认识：能够被DVM识别、加载并执行的文件格式，每个apk安装包里都有。包含应用程序的全部操作指令以及运行时数据
        - 相对于PC上的java虚拟机能运行.class；android上的Davlik虚拟机能运行.dex
        - 当java程序编译成class后，还需要使用dx工具将所有的class文件整合到一个dex文件，目的是其中各个类能够共享数据，在一定程度上降低了冗余，同时也是文件结构更加经凑，实验表明，dex文件是传统jar文件大小的50%左右
     1， 作用
        - dex里面包含了所有app代码，利用反编译工具可以获取java源码。理解并修改dex文件，就能更好的apk破解和防破解
1. am
   - 认识：activity manager，Android下的实用命令，代码在frameworks\base\cmds\am\src\com\android\commands\am
   - 使用
     1. 获取package和launch_activity：`adb shell dumpsys window windows | findstr "Current"`
     1. 启动：`am start`
### wiki
1. root方式
   - 以前版本中最流行的 root 方法 —— 即，将 su守护程序 放置到 /system 分区，并在启动时取得所需的权限
   - systemless方式：不修改/system分区
1. Bootloader
   - 认识
     1. 操作系统内核运行之前运行，是加电后执行的第一段代码
        - 嵌入式系统通常没有像BIOS那样的固件程序，有的cpu有短小的启动程序
     1. 初始化硬件设备、建立内存空间映射图
   - 操作模式
     1. 启动加载模式：正常工作模式
     1. 下载模式：将通过串口或网络等通信手段从开发主机
1. Recovery
   - TWRP：Team Win Recovery Project,是一款易于使用和可以自定义的Recovery
### tool
1. Android Studio
1. Android SDK
   - adb：Android Debug Bridge，操作管理模拟器或设备
     1. adb shell env   # 查看Android的环境变量
1. Magisk
   - 认识：独特的挂载机制，systemless特质
   - 理解：通过挂载一个与系统文件相隔离的文件系统来加载自定义内容，为系统分区打开了一个通往平行世界的入口，所有改动在那个世界（Magisk 分区）里发生，在必要的时候却又可以被认为是（从系统分区的角度而言）没有发生过
     1. 原系统完整性未损，需要root验证、需要验证系统完整性的OTA更新没有任何问题
     1. 严格来说 Magisk 可以被看作是一种文件系统
   - 作用
     1. 可以有针对性地隐藏 root，甚至暂时隐藏 Magisk 本身（随机包名进行重新安装）
     1. 加载各种第三方模块
        - 开机自启crond等
   - wiki
     1. Xposed：通过劫持Android系统的zygote进程来加载自定义功能，像半路截杀，在应用运行之前就已经将我们需要的自定义内容强加在了系统进程当中
     1. TaiChi：是一个使用Xposed模块的框架，带或不带Root/Unlock bootloader
     1. 安装：需要解锁 Bootloader 并刷入第三方 Recovery
1. busybox
   - 集成了相当完整的linux命令环境和工具的软件，即工具箱，如http服务器、telnet服务器
1. Termux
   - 认识：终端模拟器，甚至可被认为是Linux发行版，仅仅是模拟器有点小器了
     1. 自带包管理器apt
     1. 工具包：Clang，FFMPEG，OpenSSH，Python，Vim
     1. 不遵循文件系统层次结构标准，在Termux下无法找到 /bin、/etc、/usr、/tmp 等Linux基础目录。因此，所有程序都应打补丁并重新编译才能在 Termux 环境上运行，否则它们将无法找到其配置文件或其他数据
     1. 执行具标准she-bang的（e.g. #!/bin/sh）的脚本时可能也会遇到问题。在执行之前需要使用 termux-fix-shebang 脚本修改要运行的脚本。好在最新版本的 Termux 提供了标准she-bangs的支持。
     1. Termux 导出特殊变量 $LD_LIBRARY_PATH，它告诉链接器在哪里可以找到共享库文件
   - 作用
     1. 安装python实现python编程，可以用手机架设 Server，同样可以用于渗透测试等
   - wiki
     1. aid Learning：类似termux，适用于新手机
1. mt管理器：集成多个工具的文件管理器，如dex编辑器