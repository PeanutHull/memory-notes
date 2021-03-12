### 认识
1. asm：assembly language，汇编语言，为cpu设计的指令，使用助记符表示，可以转换为二进制序列。不同平台的指令集和寄存器不一样，这是汇编本身的性质。汇编文件.s和.S结尾
   - 分类
     1. intel x86
     1. AT&T
     1. plan9
1. 内存布局
   - 用户内存和操作系统内存是分开的，依次往上为操作系统内存栈，自由分配区，堆，数据区，代码区，数据区存常量变量，![avatar](../images/memary.jpg)
   - 堆
     1. 认识：heap，从低往高，动态内存区域。自由、随时申请和释放，大小自定义。堆由操作系统的堆管理器管理进行动态存储分配，采用链式存储结构
        - 频繁地malloc/free造成内存空间不连，产生大量碎片。申请堆空间时库函数按照算法搜索可用的足够空间。因此堆的效率比栈要低的多
   - 栈
     1. 认识：stack，从高往低、先入后出(FIFO)、以栈帧为单位处理的连续的内存地址
        - 最先进入的内存地址最大，出口在最小内存地址那
        - 数mb大小，window为2mb，linux为1、2、4、8mb，用户能从栈中获取的空间较小,栈的最大尺寸固定，超出则引起栈溢出
        - 每个线程都有自己专属的栈
        - rsp、rbp确定栈帧位置。函数栈帧：![avatar](../images/func_stack_frame.jpeg)
     1. 对比
        - 栈快，但是容量小
        - 堆可提供全局访问，需要自行处理生命周期
   - 全局区(静态区)：存放全局和静态变量、常量，可读可写，由编译器决定的固定空间
   - 字面量区：常量字符串存储区
   - 代码区：text，程序被操作系统加载到内存的时候，所有的可执行代码都加载到代码区，这块内存在程序运行期间不变，放在低位不会被堆栈溢出覆盖
1. 寄存器
   - 认识：是cpu的存储结构，可用来暂存指令、数据和地址。是cpu运算时最频繁、最快速的一种方式
   - 分类
     1. 通用寄存器：保存短暂的数据
        - ah/al：8 位
        - ax/bx/cx/dx：16 位
          1. eax/ebx/ecx/edx：32 位
          1. rax/rbx/rcx/rdx：64 位，用16进制表示就是0x0000000000000000（16个），因为2进制和16进制转换就是2的4次方
        - di/si：内存操作指令中作为“源地址/目的指针”使用
          1.rdi/rsi/edi/esi
        - r8-r15
     1. 段寄存器：存下一个要执行的指令地址，包括段地址和偏移地址寄存器
        - 通过段寄存器，cpu可以使用普通寄存器读取或者改变内存中的数据
     1. 栈地址寄存器：做栈操作
        - bp/rbp：基址寄存器
        - sp/rsp：栈顶寄存器
     1. 指令寄存区：存储将要执行的指令的内存地址
        - pc
        - ip
          1. rip
          1. eip
     1. 标志寄存器：记录各种运算结果，如是否为0，是否发生溢出
        - eflags
        - rflags
   - plan9
     1. 规则
        - 没有r或e的前缀
     1. 伪寄存器
        - pc：即意义和作用都是指令寄存器，x86是ip，amd64上是rip
        - sb：全局静态基指针，一般用来声明函数或全局变量
        - fp：使用symbol+offset的方式，引用函数的输入参数，如`arg1+8(FP)`
          1. 不加symbol时，无法通过编译，只是是为了提升代码可读性
        - sp：指向当前栈帧的局部变量的开始位置，使用symbol+offset的方式引用函数的局部变量
          1. offset的合法取值是-framesize到0，注意是个左闭右开的区间。假如局部变量都是8字节，第一个局部变量就可用localvar0-8(SP)来表示
          1. symbol+offset(SP)形式表示伪寄存器SP。offset(SP)则表示硬件寄存器SP
1. 指令
   - mov
   - lea：取有效地址至寄存器
   - push/pop
   - jmp
   - call：函数调用，CALL指令将其返回地址压入堆栈，再把被调用过程的地址复制到指令指针寄存器。当过程准备返回时，它的 RET 指令从堆栈把返回地址弹回到指令指针寄存器
   - ret：返回
   - plan9
     1. 常数：$num表示，默认十进制，用$0x123表示十六进制
     1. 栈调整：没有pop、push，通过SP进行运算实现
     1. 数据搬运
        - 方法：可实现数据、寄存器、内存三者间的数据搬运，长度由mov的后缀确定
          1. MOVB：1 byte，byte
          1. MOVW：2 bytes，word
          1. MOVL：4 bytes，long
          1. MOVQ：8 bytes，quadword
        - 方向：和intel相反，左到右
     1. 计算指令，也是后缀对应不同长度
        - ADD
        - SUB：减
        - MUL：乘
        - DIV：除
        - AND：逻辑与
        - OR
        - NOT
     1. 跳转
        - JMP：无条件跳转
        - JL：Jump if less
        - JLZ：Jump if less or equal
        - JE：Jump if equal
        - JNE：Jump if not equal
        - JG：Jump if greater
        - JGE：Jump if greater or equal
        - JZ：Jump if equal zero
        - JNZ：Jump if not equal zero
     1. 方法调用
        - CALL
     1. 取地址
        - LEA
     1. SIMD
