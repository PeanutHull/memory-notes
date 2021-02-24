### 基础
1. 空
   - 空字符：''或'\0'，字符编码为0，用于标记字符串结尾，是一个字符，占1字节
   - 空指针：NULL，不和任何数据的有效地址对应，用于文件结尾或未按预期，是一个地址，通常占4字节
   - void：函数返回、参数为空(不带参数可以接受void)、指针指向void(类型为void *的指针代表对象的地址，可以转换为任何数据类型)
   - EOF
     1. End Of File，头文件stdio.h中的常量，由于ascii不能为负定为-1，作为文件结束的标志
     1. 也表示错误的函数返回值，如`while(fscanf("%d",&n) != EOF)`
1. 存储占用
   - 字符'0'：char c = '0'; 它的ASCII码实际上是48。内存中二进制表示：00110000
   - 字符'\0' :ASCII码为0，即二进制00000000，表示一个字符串结束的标志。这是转义字符（整体视为一个字符）
   - 整数0 ：内存中表示为：00000000 00000000 00000000 00000000；虽然都是0，但是跟上面字符'\0'存储占用长度是不一样的
1. 内存
   - 函数是一段代码的封装，函数实质是这段代码的首地址，所以函数名本身就是一个内存地址
   - 从本质来说，使用指针来访问内存和用变量访问内存是一样的，都代表一段内存地址
1. wiki
   - gets()这个函数只有一个参数，那就是字符缓冲区的指针，并没有指定该缓冲区的大小。当输入一个很长字符串时，gets()会把每个字符都存入到栈中，因此可能导致程序异常终止。建议使用fgets()替代
   - 结构体、联合体
     1. 联合体是成员变量共享一块内存，可以根据使用确定含义
     1. 结构体不共享，并且存在内存对齐
### 周边相关
1. GDB
   - 认识：The GNU Project Debugger，即GDB调试器(鱼)，可监控程序的执行流程。诞生于GUN计划，同时的还有GCC、Emacs等
     1. 可按照自定义要求运行程序，如设置参数和环境变量
     1. 支持断点调试，并查看程序状态
     1. 可以直接查看内存数据
     1. 支持C、C++、Go、Objective-C、OpenCL的调试
   - 调试方式
     1. 直接使用gdb
     1. 目标使用gdbserver，本地gdb调试
     1. ulimit -c unlimited生成core文件，本地gdb调试
   - 使用
     1. 调试
        - `gdb program`：开始调试
          1. -p：调试进程id为xx的程序
          1. --args：为程序传递参数
        - `gdb program core dump`：调试core dump，使用`set solib-search-path`加载库文件
        - `gdb -d`：参数载入
     1. 运行
        - `r xx`：run，开始运行、触发第一个断点，也可传递参数
        - `st xx`：start，开始执行程序,在main函数的第一条语句前面停下来
        - `c`：continue，继续程序的运行,直到遇到下一个断点
        - `s`：step，执行下一条语句，如果该语句为函数调用，则进入函数执行其中的第一条语句
        - `n`：next，执行下一条语句，如果该语句为函数调用，不会进入函数内部执行
        - `k`：kill，终止正在调试的程序
        - `q`：退出
     1. 断点相关
        - `source gdb.init`：执行一系列gdb命令
        - `b`：break，设置断点，如`b main.go:17`
          1. `b 行号/函数名/文件名:函数名/文件名:行号`
          1. `b +偏移量/-偏移量`
          1. `break *地址`
          1. `tbreak`：只生效一次的断点，用法同break
          1. `rbreak regex`：函数名满足正则regex的话，就在内部开头打断点，如`rbreak admin_*`是admin开头
        - `d/clear`：delete，删除断点
        - `disable/enable`：停启用断点
        - `condition breakNum condition`：给指定断点添加触发条件
        - `b n [if cond]`：每次程序执行到n行时计算表达式cond的值，为true则暂停
     1. 查看
        - `x`：显示内容，`x/格式 地址`
          1. `x/3xw &r`：查看r内存数据，指针 8 + 长度 4
          1. `x/15xb 0x4212124`
          1. `x/i`：查看指令
        - `p xx`：print，打印变量值
          1. `p $len(s)`：获取对象长度
          1. `p $寄存器`：显示寄存器内容，如p $pc
          1. `p/x $寄存器`：十六进制显示寄存器内容
        - `f`：frame，查看栈帧。`f n`切换到编号为n的栈
        - `bt`：backtrace，查看函数调用信息(堆栈)
          1. `bt full`：不仅显示backtrace，还显示局部变量
          1. `bt n`：显示开头N个栈帧
          1. `bt full n`
        - `i`：info，描述程序状态，`i r`
          1. `info break/breakpoints`：查看所有断点
          1. `info reg`：显示寄存器内容
        - `disassemble`：查看反汇编
          1. `disassembler $pc,+length`：只显示关注的运行指针附近的汇编代码
        - `l main.main:8`：查看源代码
        - `disp`：display，跟踪查看某个变量，每次停下来都显示它的值
        - `watch`：表达式发生变化时暂停运行
          1. `awatch`：表达式被访问、改变时暂停执行
          1. `rwatch`：表达式被访问时暂停执行
        - `set`：改变变量的值
        - `generate-core-file`：生成内核转储文件
        - `dump binary memory FILE START STOP`：dump内存
   - 步骤
     1. 编译程序
        - g添加调试信息使得GDB可以调试
        - -O0不优化，优化等级：-O0~-O4
     1. 调试go
        - `go build -gcflags "-N -l" xx.go`
        - `gdb xx`
   - wiki
     1. DWARFv3：用于放在可执行文件中的表示调试信息的一种格式，DWARF格式，其他有stabs、COFF、IEEE695等，历史都非常悠久，伴随系统、计算机的发展
     1. 其他调试器
        - Remote Debugger：VS自带调试器
        - WinDbg：window下调试器
        - LLDB：xcode自带
        - lldb：mac自带
        - dlv：调试go
1. GCC
   - 认识：GNU Compile Collection，unix上的GNU编译器套装。包含C/C++/Java/Python/OC/Ada/Fortran/Pascal等编译器，能够为很多不同机器生成机器码。紧跟c标准的变动
     1. gcc：GNU C Compiler，c编译器
     1. g++：c++编译器
   - 作用：源代码 —— 预处理器 .i —— 编译器 .s —— 汇编器 .o —— 连接器 —— 可执行二进制文件
     1. `gcc -E hello.c hello.i`：预处理阶段，预处理器cpp进行宏展开、删除注释等简单工作
     1. `gcc -S hello.c hello.s`：编译阶段，cc，转成汇编
     1. `gcc -c hello.c hello.o`：汇编阶段，as，翻译成机器指令，打包成可重定位目标文件，包括词法分析、语法分析、语义检查、中间码生成、代码优化、目标代码生成
     1. `gcc -o hello.o a.o`：链接阶段，ld，用输入的可重定位目标文件和分别进行编译生成的程序模块(如果有)及系统提供的标准库函数连接一起，生成可执行目标文件，默认使用动态库
        - 符号解析：将目标文件中每个符号（静态变量、函数、全局变量）和其定义进行关联
        - 重定位：重新编排来自不同文件的符号的定义与具体在虚拟内存中的地址(.rel.text来描述)。变量不再有内外部之分，都成了本地变量
   - 使用
     1. -I：指定编译查找的路径
     1. `gcc -std=c11`：切换编译使用的c标准
     1. `gcc -O2 -g -o p main.c sum.c`：
        - -g：生成调试信息，core dump文件
        - O2：2级优化
        - -o：目标文件名
     1. `gcc sourceCode.c xx/xx.a -o xx`：使用静态库.a，也可以直接用.o
     1. `gcc -shared -fPIC sourceCode1.c sourceCodeN.c -o xx.so`：导出动态链接库，fPIC用于生成地址无关代码，因为编译时无法确定符号的运行时地址，只能基于全局偏离表给出相对位置
     1. `gcc sourceCode.c -LlibraryPath -llibraryName -o xx`：引用动态库进行编译
   - 多文件编译：-o compileName.out
     1. 源文件编译
        - 引入文件
          1. `#include b.c`
          1. gcc a.c
        - 全部编译：gcc a.c b.c -o rs.out
        - 分开编译：gcc a.c b.o
     1. 头文件编译：使用头文件指示函数情况
        - vim b.h：`int method()`
        - `#include b.h`
        - gcc a.c b.o
   - 链接
     1. 分类
        - 静态链接：程序编译过程的动作称作静态链接，确定外部符号的地址并将依赖的符号所对应的目标文件编译到一起形成最终的可执行文件
        - 动态链接：程序运行时的动作称作动态链接，根据需要加载的动态链接库在加载时再确定外部符号的地址，使用共享内存链接库有效减少内存占用
   - wiki
     1. 编译器：转换为目标代码
        - ICL：Intel C/C++ Compiler
        - VectorC
        - windows的gcc移植版
          1. MinGW：Minimalist GNU on Windows，开源，包含几乎所有win32API。主要方向是能使用win32API来编程，最接近win32，更像是vc的替代品
          1. Cygwin：在windows平台上提供一个类UNIX模拟环境，当然包括gcc了，目标是让unix程序在windows下直接被编译。是cygnus solutions公司开发的自由软件
          1. Djgpp：应用于dos系统
        - MSVC：微软(ms)的VC编译器
     1. windows的unix环境
        - MSYS：Minimal GNU（POSIX）system on Windows，是windows下最优秀的小型GNU环境，提供模拟unix环境来使用MinGW
        - WSL：Windows Subsystem for Linux，windows下的linux子系统
          1. WSL2基于hyper-v功能的子集提供了“真正的linux内核”，比1的linux要更完整
1. 目标文件
   - 认识：二进制的包含一些section的描述文件，包含代码和数据，用于二进制文件、可执行文件、目标代码、共享库的转储。汇编器和链接器可以解析，分别会从两个角度解读
     1. .o结尾
     1. 程序由操作系统将其可执行二进制文件整体加载到内存中才能运行，二进制文件包含了程序的代码段、数据段。段寄存器就是定位这些内存的主要方式
   - 格式
     1. COFF：Common Object File Format 通用对象文件格式，二进制文件格式
     1. PE：Portable Executable，windows上可移植可执行的标准文件格式，如exe、dll、vxd、sys、vdm
     1. ELF：Executable and Linkable Format，unix上主要的二进制可执行文件格式，从COFF衍生出来
        - readelf：linux命令
     1. OMF：Object Module File 对象模型文件
   - 形式
     1. 可重定位目标文件：即代码段和数据段的地址还没有最终确定，可以和其他目标文件进行合并，创建一个可执行目标文件。如启动代码/库代码/目标代码
     1. 可执行目标文件：可直接被加载器加载执行，包含启动代码/操作系统相关的接口/库函数
        - 启动代码：是程序和操作系统之间的接口
        - 操作系统加载可执行文件时，将逻辑地址与物理地址进行映射，实现将可执行二进制码加进物理内存
     1. 共享目标文件：可被动态的加载和链接
   - 库，即函数集合，存放头文件中的函数原型和对应的目标代码、链接过程的重定位信息
     1. 静态库：.a结尾，是.o文件的集合（就一.o文件的压缩包），vc下的lib文件，在程序链接阶段使用，程序运行不再使用静态库，不能共享，使得可执行文件变大
     1. 动态库/共享库：以.so结尾，shared object，windows以dll结尾，程序运行中使用，文件小，只需要存在于特定路径当中
        - ldd：列出程序所需要得动态链接库
        - c++filt：查看c++的原有值
        - pkg-config：获得某一个库/模块的所有编译相关的信息
   - 存储空间布局
     1. .text：代码段，正文段，cpu执行的机器指令部分，通常该部分内存只读防修改，并共享即其它程序可调用。text、data、bss地址在执行时是连续的
     1. .data：已初始化可读写数据段，存放已初始化的全局变量/静态全局变量/静态局部变量/常量
     1. .bss：未初始化可读写数据段，仅是占位符，表示占用的字节数，不占用空间，存放未初始化的全局变量/静态全局变量/静态局部变量/常量，通过节头表说明预留的空间，区分二者为了空间效率
        - 未初始化的全局变量和局部静态变量的初始值为0，即没有占用任何空间，所以bss段不占用空间
        - 程序运行结束时自动释放
        - bss在程序执行之前会被系统自动清0完成初始化
        - 静态数据成员要在程序一开始运行时就必须存在
     1. .symbtab：符号表，存放函数和全局变量信息，不包含局部信息，不会加载到内存
     1. .rel/.debug/.line：调试信息，不会加载到内存，.rel.text/data，text和data节的重定位信息
     1. 栈：自动变量、每次函数需保存的信息(如返回地址和上下文)，递归依赖每次函数使用新栈帧互不影响，数MB大小
        - 运行时栈：编译器自动释放，存放函数的参数值/局部变量/方法返回值等。函数被调用时该函数的返回类型和调用信息存储到栈顶，调用结束后被弹出并释放内存。从高位向低位增长，是连续的内存区域，最大容量是由系统预先定义，用户能从栈中获取的空间较小
     1. 堆：在其中进行动态存储分配，如malloc、calloc、realloc、free，32位的不到2GB
        - 运行时堆：用于存放进程运行中被动态分配的内存段，从低位向高位增长，采用链式存储结构。频繁地malloc/free造成内存空间不连，产生大量碎片。申请堆空间时库函数按照算法搜索可用的足够空间。因此堆的效率比栈要低的多
     1. 内存映射区域：例将动态库/共享内存等虚拟空间的内存映射到物理空间的内存，一般是mmap函数所分配的虚拟内存空间
   - 类和对象在内存中的体现
     1. 栈空间段：存储占用相同空间长度并且占用空间小的数据类型，可直接存取，存对象名称
     1. 堆空间段：不定长、体积大，不可直接存取，存对象。通过名称找对象
     1. 代码段
     1. 初始化静态段：存放静态属性和方法，类第一次被加载即放入，可被堆内存的对象所共享
1. Core Dump
   - 认识：程序运行时异常终止或崩溃，操作系统会将程序当时的内存状态、寄存器信息、内存管理信息、操作系统信息等记录下来，保存在一个文件中，可以再现程序出错时的情景。中文翻译为核心转储
   - 产生原因
     1. 内存访问越界
        - 由于使用错误的下标，导致数组访问越界。
        - 搜索字符串时，依靠字符串结束符来判断字符串是否结束，但是字符串没有正常的使用结束符。
        - 使用strcpy, strcat, sprintf, strcmp,strcasecmp等字符串操作函数，将目标字符串读/写爆。应该使用strncpy, strlcpy, strncat, strlcat, snprintf, strncmp, strncasecmp等函数防止读写越界
     1. 多线程程序使用了线程不安全函数，应该使用可重入函数
     1. 多线程读写的数据未加锁保护。
     1. 非法指针
        - 使用空指针
        - 随意使用指针转换。一个指向一段内存的指针，除非确定这段内存原先就分配为某种结构或类型，或者这种结构或类型的数组，否则不要将它转换为这种结构或类型的指针，而应该将这段内存拷贝到一个这种结构或类型中，再访问这个结构或类型。这是因为如果这段内存的开始地址不是按照这种结构或类型对齐的，那么访问它时就很容易因为bus error而core dump
     1. 堆栈溢出
        - 不要使用大局部变量（因为局部变量都分配在栈上），容易造成堆栈溢出，破坏系统的栈和堆结构，导致出现莫名其妙的错误
### 项目实战
1. 项目体会
   - 先写头文件：划分、定义核心模块
   - 核心方法写好后，可以被测试用例和ui的方法调用，这样核心就完成了，实现和上层的解耦
   - 编写测试用例，保证接口正确性
   - 内存泄露问题要高度警觉，使用了new和malloc一定要尽早的(调用链条不能太长)、谁调用谁释放，gui程序特别容易发生内存泄露
   - sqllite非常小巧，可以嵌入到程序中当存储，好用
   - c中全是用回调函数写东西，要平衡好垃圾回收和方法聚类封装，可以适当引入下mvc思想，划分清晰
1. 计算器
   - 架构
     1. 底层相同的计算器核心接口定义
     1. 上层console和图形界面
   - 项目编写过程
     1. operation——calculator——ui
     1. console_ui——unit_test_ui
     1. gtk_ui
   - 先写头文件：划分、定义核心计算模块、计算器本身上下文
     1. 创建计算器上下文
        - 分配内存：`CalcContext *calc_context = malloc(sizeof(CalcContext));`，用malloc分配内存，CalcContext是自己定义的承载计算器上下文的结构体
     1. 清空刚创建的上下文
        ```c
        static void ClearAll(CalcContext *context) {
            context->input_buffer[0] = 0;                                       // 清空字符串
            memset(&context->previous_operation, 0, sizeof(Operation));         // 清空结构体
        }
        ```
     1. 清除结构体
        ```c
        void DestroyCalcContext(CalcContext **p_context){
            free(*p_context);
            *p_context = NULL;
        }
        ```
   - 编写ui和计算器核心方法绑定，使用宏代替重复代码，并且利用了嵌套宏实现多次宏替换
1. 跨平台下载软件
   - 架构
     1. gtk做gui
     1. 线程池实现下载任务，分为主线程和专注于下载的io线程
     1. 底层libcurl和sqllite3，记录下载记录和进度
   - 项目编写过程
     1. sqlite_manager(sql封装层)——task_info(下载任务的DAO层)
     1. http_manager——http_common(curl封装)
     1. threadpool_manager——request_api
     1. ui_main——ui_new_task(新建任务的ui)
     1. ui_task_list(负责承接db和curl层的封装)——ui_download_task(负责ui展示的更新)
   - 先写头文件：定义接口和模块