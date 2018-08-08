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
### 进程间通信
1. IPC
1. 进程间通信对象：消息队列、信号量、共享存储对象，实际系统没当成文件
### Application
1. 同时读写：`open(path, O_RDWR|O_CREAT|O_TRUNC, mode);`，creat需要开关两次实现
1. 进程崩溃时临时文件的确保删除：进程运行，open临时文件后，就unlink，等崩溃时就会删除
1. 获取命令行参数：getopt、getopt_long
### 问题
1. 多进程模式下的文件原子读写