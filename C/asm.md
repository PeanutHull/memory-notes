### base
1. asm
   - 认识：assembly language，汇编语言，是机器指令的助记符表示。汇编文件.s和.S结尾
     1. 不同平台的指令集和寄存器不一样，因为cpu设计不同
     1. 寄存器是离cpu最近的，因为cpu比内存快太多了，而且内存地址太长不利于计算
     1. 函数的调用只使用寄存器是搞不定了，需要内存的配合，在内存中建立一个叫做栈的数据结构，相当于寄存器当作笔在内存(纸)上操作
   - 格式分类
     1. intel x86：把右边的值复制到左边
     1. AT&T：把左边值复制放到右边
     1. plan9
1. 寄存器
   - 认识：是cpu的存储结构，可用来暂存指令、数据和地址。是cpu运算时最频繁、最快速的一种方式
   - 分类
     1. 通用寄存器：保存短暂的数据
        - ah/al：8 位，高位、地位
        - ax/bx/cx/dx：16 位
          1. eax/ebx/ecx/edx：32 位，扩展(Extend)到32位加上了e
          1. rax/rbx/rcx/rdx：64 位，用16进制表示就是0x0000000000000000（16个），因为2进制和16进制转换就是2的4次方
        - si/di：Source Index/Destination Index，专门复制数据，作为内存操作指令中的源地址/目的地址使用
          1. edi/esi：32 位
          1. rdi/rsi：64 位
        - r8-r15
     1. 栈地址寄存器
        - 认识：专门做函数调用，做栈操作
          1. 函数跳转时需要将上一个函数的bp记录到当前函数的栈帧；函数执行完，把内存中保存的值恢复到EBP中，并且移动ESP到上个栈帧的顶部就可以了。仅使用两个寄存器，就能记录无穷无尽的函数调用了
             - 因为栈是从高到低的，所以只记录bp就是上个栈帧的头(顶部)，自己的bp就是上个栈帧的sp
        - 分类
          1. sp/esp/rsp：栈顶寄存器
          1. bp/ebp/rbp：基址寄存器
     1. 段寄存器
        - 认识：存下一个要执行的指令地址
          1. 通过段寄存器，cpu可以使用普通寄存器读取或者改变内存中的数据
          1. 实模式和保护模式
        - 组成
          1. 段地址
          1. 偏移地址寄存器
     1. 指令寄存器：存储将要执行的指令的内存地址
        - pc：x86
        - ip：amd64
          1. rip
          1. eip
     1. 标志寄存器：记录各种运算结果，如是否为0，是否发生溢出
        - eflags
        - rflags
1. 指令
   - 分类
     1. 数据传输：把数据从一个位置复制到另外一个位置，如内存、寄存器、数据三者互传，
        ```s
        mov ax，3210H           ;将0x3210放入寄存器ax
        mov ax，bx              ;将bx寄存器的值放入ax
        mov ax，[3640]          ;将一个内存单元的值送入ax
        mov [502c]，bx          ;将bx寄存器的值送入内存单元
        ```
     1. 算术和逻辑运算：加减乘除、AND、OR、左移、右移
        ```s
        add ax  bx              ; 把ax和bx的值相加，把结果放入ax寄存器
        add ax, [37a0]          ; 把ax和内存的值相加，结果放到ax寄存器
        inc bx                  ; 对bx的内容加1
        shl bx  1               ; 把bx的值左移一位
        and al, 11110110b       ; and操作，相当于清除位 0 和位 3 ，其他位不变
        ```
     1. 流程控制：需要多方配合，如标志位
        ```s
        // 利用ZF(零标志位)判断跳转
        cmp ax bx               ; 比较ax 和 bx ，如果相等，就把ZF标记为1
        je  .L1                 ; 如果ZF 为1 ，则跳转到.L1处
        ......代码略......
        .L1  sub ax 10
        ```
   - 举例
     1. call：函数调用，CALL指令将其返回地址压入堆栈，再把被调用过程的地址复制到指令指针寄存器。当过程准备返回时，它的 RET 指令从堆栈把返回地址弹回到指令指针寄存器
     1. lea：取有效地址至寄存器
     1. ret：返回
     1. push/pop
     1. jmp
1. 内存布局
   - 认识：用户内存和操作系统内存是分开的，依次往上为操作系统内存栈，自由分配区，堆，数据区，代码区，数据区存常量变量，![avatar](../images/memary.jpg)、![avatar](../images/func_stack_frame.jpeg)
   - 分类
     1. 堆
        - 认识：heap，从低往高，动态内存区域。自由、随时申请和释放，大小自定义。堆由操作系统的堆管理器管理进行动态存储分配，采用链式存储结构，是执行程序时存放对象的内存空间
          1. 频繁地malloc/free造成内存空间不连，产生大量碎片。申请堆空间时库函数按照算法搜索可用的足够空间。因此堆的效率比栈要低的多
     1. 栈
        - 认识：stack，从高往低、先入后出(LIFO)、以栈帧为单位处理的连续的内存地址
          1. 最先进入的内存地址最大，出口在最小内存地址那
          1. 数mb大小，window为2mb，linux为1、2、4、8mb，用户能从栈中获取的空间较小,栈的最大尺寸固定，超出则引起栈溢出
          1. 每个线程都有自己专属的栈
          1. rsp、rbp确定栈帧位置
          1. 栈实现了内存简洁、高效的利用，而堆需要内存回收器的介入
             - 上下栈帧有依赖就延迟释放，对外有依赖就是堆内存
        - 对比
          1. 栈快，但是容量小
          1. 堆可提供全局访问，需要自行处理生命周期
          1. 堆栈的生长方向是相对的，挨一块的时候报错
     1. 全局区
        - 认识：静态区，存放全局和静态变量、常量，可读可写，由编译器决定的固定空间
     1. 字面量区
        - 认识：常量字符串存储区
     1. 代码区
        - 认识：text，程序被操作系统加载到内存的时候，所有的可执行代码都加载到代码区，这块内存在程序运行期间不变，放在低位不会被堆栈溢出覆盖
### plan9
1. 规则
   - 没有r或e的前缀
1. 伪寄存器
   - pc：即意义和作用都是指令寄存器
   - sb：全局静态基指针，用以指示所有内存的基地址，一般用来声明函数或全局变量
   - fp：使用symbol+offset的方式，引用函数的输入参数，如`arg1+8(FP)`
     1. 不加symbol时，无法通过编译，只是是为了提升代码可读性
   - sp：指向当前栈帧的局部变量的开始位置，使用symbol+offset的方式引用函数的局部变量
     1. offset的合法取值是-framesize到0，注意是个左闭右开的区间。假如局部变量都是8字节，第一个局部变量就可用localvar0-8(SP)来表示
     1. symbol+offset(SP)形式表示伪寄存器SP。offset(SP)则表示硬件寄存器SP
1. 指令
   - 常数：$num表示，默认十进制，用$0x123表示十六进制
   - 栈调整：没有pop、push，通过SP进行运算实现
   - 数据传输
     1. 认识：可实现数据、寄存器、内存三者间的数据搬运
        - 长度由mov的后缀确定
        - 方向和intel相反，左到右
     1. 方法
        - MOVB：1 byte，byte
        - MOVW：2 bytes，word
        - MOVL：4 bytes，long
        - MOVQ：8 bytes，quadword
   - 计算指令，也是后缀对应不同长度
     1. ADD
     1. SUB：减
     1. MUL：乘
     1. DIV：除
     1. AND：逻辑与
     1. OR
     1. NOT
   - 跳转
     1. JMP：无条件跳转
     1. JL：Jump if less
     1. JLZ：Jump if less or equal
     1. JE：Jump if equal
     1. JNE：Jump if not equal
     1. JG：Jump if greater
     1. JGE：Jump if greater or equal
     1. JZ：Jump if equal zero
     1. JNZ：Jump if not equal zero
   - 方法调用
     1. CALL
   - 取地址
     1. LEA
   - SIMD
1. 全局变量
   - 声明：`GLOBL symbol(SB), width`，变量符号 + 内存宽度。没有类型，内存宽度必须是2的指数倍，编译器最终会保证变量的真实地址对齐到机器字倍数
     1. 如int32的变量`GLOBL ·count(SB),$4`：点开头表示是当前包的变量
   - 赋值：`DATA symbol+offset(SB)/width,value`：width必须是1、2、4、8几个宽度之一，因为再大的内存无法一次性用一个uint64大小的值表示
   - 整型
    ```s
    # 可以逐个字节初始化，也可以一次性初始化：

    GLOBL ·count(SB),$4
    DATA ·count+0(SB)/1,$1
    DATA ·count+1(SB)/1,$2
    DATA ·count+2(SB)/1,$3
    DATA ·count+3(SB)/1,$4
    // or
    DATA ·count+0(SB)/4,$0x04030201
    ```
   - 布尔
    ```s
    GLOBL ·trueValue(SB),$1             # var trueValue = true
    DATA ·trueValue(SB)/1,$1            # 非 0 均为 true
    
    GLOBL ·falseValue(SB),$1            # var falseValue = true
    DATA ·falseValue(SB)/1,$0
    ```
1. 函数声明
   - 认识：`TEXT symbol(SB), [flags,] $framesize[-argsize]`，表示该行开始的指令定义在TEXT内存段
     1. TEXT指令、函数名、可选的flags标志、函数帧大小、可选的函数参数大小
   - 实例
    ```s
    // func add(a,b int) int
    TEXT main.add(SB), NOSPLIT,$0-24
    ```