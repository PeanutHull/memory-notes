### 标准和实现
1. 标准化
   - ISO C：c语言标准，涉及是否支持头文件和库函数
   - IEEE POSIX：可移植操作系统接口，用于提升应用程序在unix系统的可移植性，规定了各种必须的服务
   - Single UNIX Specification：单一unix规范，是POSIX.1标准的超集，包括XSI(X/Open System Interface)
1. 实现：SVR4、BSD、FreeBSD、Linux、Mac OS X、Solaris
1. 限制
   - 编译时限制：头文件中定义
   - 运行时限制：进程调用函数获得、修改
     1. 文件目录：sysconf
     1. 其他：pathconf、fpathconf
1. 整体
   - 系统调用、库函数：unix提供同样名字的系统函数，和库函数对于程序员可视为无区别，但完全不同，如sbrk系统存储空间分配函数，如fork、exec、wait进程控制的系统调用，system、popen的库函数调用
### IO
1. 文件IO：不带缓冲的io，缓冲长度的影响，不是c标准是unix标准
   - 文件描述符：所打开文件通过其引用，是非负整数。内核和进程来回传递，012为三大标准 
   - 常用函数
     1. open、openat(可指定相对目录)：也可以新建文件(O_CREAT)
     1. create、close(释放记录锁、进程终止自动关闭)
     1. lseek：当前文件偏移量，字节为单位，
     1. read、write：管道、FIFO
   - io效率：文件系统的预读技术
   - 文件共享
     1. 内核的表示打开文件的数据结构：每个进程的记录项 --> 每个打开文件的文件表 --> 每个打开文件的v节点结构。dup和fork、fcntl是多个描述符指向一个文件表项
     1. 原子操作：多步操作要么全成功要么全失败，如多个进程共享资源，在于偏移量的控制。其他有记录锁
        - pread、pwrite：XSI扩展中，原子性的执行，包括先lseek再读写
   - sync、fsync：强制缓冲写入硬盘
   - dup、dup2：复制描述符，共享一个文件表项
   - fcntl、ioctl：改变打开文件的属性、杂物箱
   - /dev/fd：打开n相当于复制描述符n，`fd=open("dev/fd/0", mode);`
   - truncate：文件截断
1. 文件和目录的其他属性
   - 属性
     1. stat：返回文件信息结构，fstat(fd)、lstat(符号链接)、fstatat(fd/符号链接)
        - st_size：文件长度
     1. 文件类型
        - 普通文件
        - 目录文件：包含其他文件的名字和指向信息的指针
        - 符号链接：指向一个文件
        
        - FIFO：用于进程间通信，也称命名管道
        - 套接字：socket，用于进程间网络通信，也可一台机器进程间的非网络通信

        - 块特殊文件：针对设备带换冲固定长度的访问
        - 字符特殊文件：对设备无缓冲的长度可变的访问
     1. 时间：数据最后访问时间、数据最后修改时间、i节点最后更改时间
     1. 其他
        - 只有内核可以直接写目录文件，所以只能用函数操作目录
        - 符号链接：硬链接直接指向文件i节点，避开了限制
   - 权限、掩码
     1. 用户ID、组ID：实际/有效/保存，用户ID/组ID。实际决定你是谁，有效决定权限
     1. 权限
        - 特点
          1，所有文件类型都有访问权限，对目录的下的文件删除需要目录的写和执行权限，对文件没有要求
          1. 粘着位：即交换区保存正文副本位，被虚拟存储系统和快速文件系统代替，S_ISVTX，现在可以针对目录如/tmp 
        - 组成：9个访问权限位：用户/组/其他，读/写/执行
        - 函数
          1. 权限测试：access、faccessat
          1. umask：为进程设置文件模式创建屏蔽字
          1. 更改权限：chmod、fchmod、fchmodat。都是指定文件、针对fd、特殊情况下相同
          1. 更改所属：chown、fchown(fd)、fchownat(两种情况)、lchown
   - 创建、重命名、遍历、删除
     1. link、linkat
     1. unlink、unlinkat：打开的进程数和文件链接数都为0时系统才会删除。remove
     1. symlink、symlinkat
     1. readdir
     1. opendir、fdopendir、closedir
     1. rewinddir、telldir、seekdir
     1. futimens、utimensat、utimes：访问时间、修改时间
     1. rename、renameat
     1. mkdir、mkdirat、rmdir
     1. chdir、fchdir、getcwd
1. 标准io
   - 流：标准io的核心，使用流和文件关联。FILE承载
     1. 字符和字节：fwide设置
     1. 打开：fopen、freopen、fdopen
     1. 读写
        - getc、fgetc、getchar：输入一个字符。ungetc压回流中
        - fgets、gets：输入一行，换行符结束
        - ferror、feof：出错、到达文件尾端
        - fread、fwrite：二进制操作
     1. 定位
        - ftell、fseek
        - ftello、fseeko
        - fgetpos、fsetpos
     1. 格式化
        - printf、fprintf、dprintf、sprintf、snprintf：输出
        - scanf、fscanf、sscanf：输入
     1. 获得描述符：fileno
     1. 创建临时文件：tmpnam、tmpfile
   - 特征
     1. 认识：ISO C标准说明，SUS扩充
     1. stdin、stdout、stderr
     1. 缓冲：多弄点，多拿点，减少read和write的次数，自动管理，有缓冲区分配，以优化块长度执行io
        - 缓冲类型：全缓冲、行缓冲、不缓冲。stderr无缓冲，终端设备行缓冲，其他全缓冲(填满后进行实际io操作)，函数setbuf、setvbuf
     1. 效率：和直接read、write差不多
     1. 内存流：创建fmemopen、open_memstream、open_wmemstream
1. 系统数据文件和信息
### 进程
1. 运行背景
1. 命令行参数
   - c编译器调用->连接编译器调用->调用特殊启动例程作为程序起始地址，从内核取得命令行参数和环境变量->exec main
   - exec可将命令行参数传递给新程序
1. 环境变量
   - 环境指针：environ，整个环境kv对的全局变量
   - getenv、putenv(只能影响自己和子孙)、unsetenv(删除name)
1. 资源限制
   - getrlimit、setrlimit
   - 修改规则
     1. 软限制必须小等于硬限制
     1. 任何进程可以降低硬限制
     1. 超级用户进程可以提高硬限制
1. 终止
   - 终止方式：只有自愿的exit、_exit、_Exit，非自愿的由信号终止
     1. 正常
        - 从main返回
        - 调用exit：
        - 调用_exit、_Exit
        - 最后一个线程从其启动例程返回
        - 从最后一个线程调用pthread_exit
     1. 异常
        - 调用abort
        - 接到一个信号
        - 最后一个线程对取消请求做出响应
     1. 针对线程 TODO
   - 退出
     1. main返回：特殊启动例程立即调用exit
     1. exit：先清理再返回内核，即关闭所有io(也即缓冲冲洗)，可返回整数形式的终止状态否则状态随机，exit(0)=return(0)
     1. _exit、_Exit：立即进入内核
     1. atexit：注册自动退出时调用的函数，不期望返回值，最多32个
1. 存储空间
   - 布局：空间顶部的环境变量改变会在堆中开辟指针表
   - 分配
     1. malloc、calloc、realloc、free
     1. libmalloc、vmalloc...
1. setjmp、longjmp、goto
1. 多进程编程模型
   - 唯一id标识符：可重用，存在延迟复用算法保证无误认
     1. id为0：调度进程，或交换进程、系统进程，内核一部分
     1. id为1：init进程，绝不会终止，是普通用户进程，以root身份运行
     1. id为2：页守护进程
   - 与标准io：因为标准io是对及哦啊胡设备是行缓冲的，对其他是全缓冲的，fork之后会有两份缓存数据输出
   - 与文件描述符：共享一个文件表项，输出会相互混合，子进程不继承文件锁
   - 与setenv：可以影响子进程的环境变量
   - 竞争条件：避免逻辑依赖因为进程间的执行顺序而受影响，以及轮询等待，使用信号、IPC处理、管道
   - 最小特权模型：更改用户、组ID，setuid、setgid，setreuid、setregid
1. 多进程进程管理
   - 获取标识符：getpid、getppid、getuid、geteuid、getgid、getegid
   - 创建：fork，父子谁先执行不确定，取决于内核的调度算法，需要互相同步需要进程间通信，不会执行父进程数据段、栈、堆的完全副本，使用写时复制。
     1. 用法：一父进程复制自己，同一时间执行不同代码段，如fpm。二执行不同程序，fork返回后立即exec
     1. fork失败：系统有太多进程，或实际用户id的进程总数超过限制
     1. 有些系统将fork后exec合成一个操作，成为spawn
     1. vfork废弃，创建子进程后立即exec，不会复制父空间，在父进程空间中执行，效率高，保证子进程先执行，返回之后父进程才可能执行。如果子进程修改数据，函数调用，没有exec或exit就返回会导致未知后果
   - 调用：exec函数，从main函数开始运行，用磁盘新程序替换了当前进程的正文段、数据段、堆和栈段。有execl/v/le/ve/lp/vp、fexecve
     1. 路径：搜索path或绝对路径，作为可执行文件或者shell执行
     1. 继承了调用进程的：各种用户ID、当前工作目录、文件锁、未处理信号
     1. 解释器文件：#! /bash/sh 的脚本文件
   - 等待：获取终止状态
     1. 进程收养：一个进程终止，检查所有活动进程，父进程终止子进程被pid为1的init进程收养，保证每个进程都有父进程
     1. 僵死进程：已经终止，父进程尚未进行处理(获取终止信息、释放占用的资源)的进程
     1. wait、waitpid：4个互斥的WIF*宏获取终止原因
        - 所有子进程运行，则阻塞
        - 一个子进程终止，正等待父进程获取终止状态，则立即返回
        - 没有子进程，出错返回
        - 接到SIGCHLD信号：调用wait会立即返回，进程终止向父进程发送异步信号，默认动作忽略，也可指定信号发生时的函数(信号处理程序)
     1. waitpid
        - 可指定进程号获取终止状态，也可通过循环wait存储每个终止状态实现
        - 提供wait的非阻塞版本
        - 通过WUNTRACED和~支持作业控制
     1. waitid：更加灵活的waitpid，可指定pid类型，其他的终止情况
     1. wait3、wait4：允许内核返回终止进程和其所有子进程使用的资源情况
1. 进程状态
   - fd：
   - 子进程：资源的继承
1. 进程组
1. 作业控制
### 信号
1. 使父子进程同步
### 进程间通信
1. IPC
1. 进程间通信对象：消息队列、信号量、共享存储对象，实际系统没当成文件
1. 操作：建立，同步，通信，互斥
1. 复用：select，poll，epoll
### Application
1. 同时读写：`open(path, O_RDWR|O_CREAT|O_TRUNC, mode);`，creat需要开关两次实现
1. 进程崩溃时临时文件的确保删除：进程运行，open临时文件后，就unlink，等崩溃时就会删除

1. 获取命令行参数：getopt、getopt_long

1. for循环的写法
   - for (i=0; i<5; i++)
   - for (i=0; argv[i] != NULL; i++)
   - for (dirst=readdir(dir); dirst; dirst=readdir(dir))

1. realloc可创建恰好的数组，如路径
### 问题
1. 多进程模式下的文件原子读写
1. 啥是作业控制
### wiki
1. libc：泛指C函数库，包括头文件和基本C库libc.a，最初由c发明者写，后来移植到多个平台，有了多个版本。包含常用的数据结构和处理方法，如数组(长度可变),单(双)向链表,hash表,队列,关系，处理方法如:字符串,标准输出(g_print等),错误输出,日志记录，还有事件循环,线程,IO操作等，是ANSI C函数库
   - glibc：c运行库，是GNU发布的libc库，是linux最底层的api，包括了unix通行的标准，各发行版Linux用的就是glibc，是GUN C函数库，Linux下面的标准c库还有uclibc、klibc、libc，glibc用得最多，glib是GTK+的基础库
1. 动态库、静态库、共享库：动态库so
1. unix
   - cpu、memcory、devices->kernel->applications
1. Linux：Linux的基石是Unix内核，其基于Unix的基本特点以及POSIX和单独的UNIX规范标准