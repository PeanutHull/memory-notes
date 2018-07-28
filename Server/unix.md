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
### IO
1. 文件：不带缓冲的io，缓冲长度的影响，不是c标准是unix标准
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
   - dup、dup2：复制描述符，共享一个文件表项
   - sync、fsync：强制缓冲写入硬盘
   - fcntl、ioctl：改变打开文件的属性、杂物箱
   - /dev/fd：打开n相当于复制描述符n，`fd=open("dev/fd/0", mode);`
1. 文件和目录
   - 属性
     1. stat：返回文件信息结构
   - 权限、掩码
   - 创建、删除、重命名
   - 遍历
   - stdin、stdout、stderr
1. 标准io
1. 系统数据文件和信息
### Application
1. 同时读写：`open(path, O_RDWR|O_CREAT|O_TRUNC, mode);`，creat需要开关两次实现
### 问题
1. 多进程模式下的文件原子读写