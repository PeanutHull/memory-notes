### php
1. 特性：动态、符号表、间接引用
1. 组成
   - sapi：Server Application Programming Interface，服务器端应用编程端口，是php与其它应用交互的接口，是php的接入层，接受请求，然后调用php内核api，严格来说不属于内核。为内部的PHP提供一套固定的, 统一的接口, 使得PHP自身实现能够不受错综复杂的外部环境影响，保持一定的独立性
   - 引擎
     1. 理解：核心，负责从编译到执行
     1. 组成
        - 编译器：代码->抽象语法树->opcode，相当于gcc，编译器是一个语言实现的基础
        - 执行器：执行opcode，即执行逻辑
     1. 分类
        - Zend
        - HHVM
1. 架构图
   - application：fpm
   - sapi：cli(shell)、cgi、mod_php5(apache)、isapi(iis)
   - php、php api、extension
     1. php api：streams、output
     1. extension：mysql
   - zend api、zend extension api
   - zend engine
1. 相关
   - 数据类型
   - 函数
   - 类、基础语法
   - 编译与执行
   - 内存管理
### 扩展
1. 扩展开发
   - 理解：C/C++基础，同时需要熟悉php扩展api，要用到PHP自身定义的函数和宏
   - 扩展编译分动态编译和静态编译
     1. 动态：phpize、configure
   - ext_skel快速开发工具
   - 开发
     1. config.m4：PHP_ARG_WITH、PHP_ARG_ENABLE
     1. php_xx.h、xx.c
1. posix/pcntl
1. php5和php7的扩展大部分都不一样了
### 编译
1. 原理：默认情况下Zend引擎先将php源码编译为opcode(即字节码/虚拟指令，可理解成C语言级函数，根据指令由相应的C编写的函数来执行)，然后Zend解析引擎逐条执行
1. HHVM提升性能方式：替代Zend引擎将php代码转换成中间字节码(HHVM自己的，通常称为中间语言)，然后运行时通过JIT编译器将字节码转换成机器码，类似于Java的JVM。为了达到最佳优化效果，需要将PHP的变量类型固定下来，而不是让编译器去猜测，Facebook的工程师们就定义一种Hack写法，进而达到编译器优化
1. JIT：just in time，即时编译，表示运行时将指令转为二进制机器码，jit可以将opcode直接转为机器码，大幅提升性能
### 调优
1. 编码级优化
   - 提前销毁大变量
   - 避免使用魔术方法耗性能
   - requiere_once耗性能
   - 少用正则
   - 不要用@符掩盖错误
   - 单引号代替双引号
1. 语言级优化
   - 部署环境：nginx+php-fpm方式
   - 框架选择
   - 缓存
     1. 程序层面的文件静态和优化比底层来的更有效、直接
     1. 开启opcode缓存：避免重复编译，如APC、xcache
     1. 本地缓存：如用xcache缓存元数据，不用每次读文件
   - 文件加载：一个文件操作胜过优化N个CPU指令
   - nginx开启gzip压缩
1. 配置优化
   - php.ini：memory_limit、session.save_handler、output_buffering
   - php-fpm：动态和静态的子进程管理，平衡cpu和内存，参数有pm、pm.max_children、pm.start_servers
1. 发挥PHP7的性能
   - 开启Opcache
     1. zend_extension=opcache.so
     1. opcache.enable=1
     1. opcache.enable_cli=1
   - 使用GCC 4.8以上进行编译
   - 开启HugePage （根据系统内存决定）：操作系统默认的内存是以4KB分页的，而虚拟地址和内存地址需要转换， 而这个转换要查表，CPU为了加速这个查表过程会内建TLB(Translation Lookaside Buffer)。 显然，如果虚拟页越小，表里的条目数也就越多，而TLB大小是有限的，条目数越多TLB的Cache Miss也就会越高，所以如果我们能启用大内存页就能间接降低这个TLB Cache Miss。php将采用大内存页来保存，减少TLB miss，提高性能
   - PGO：Profile Guided Optimization，第一次编译成功后，用项目代码去训练PHP，会产生一些profile信息，最后根据这些信息第二次gcc编译PHP就可以得到量身定做的PHP7
1. 性能
    ```php
    ini_set('memory_limit', "1024M");
    set_time_limit(0);
    echo microtime() . PHP_EOL;
    echo microtime() . PHP_EOL;
    echo memory_get_usage() . PHP_EOL;
    ```
1. xhprof
1. php7性能优化：使用Zend Engine 3.0，ZEND引擎升级到Zend Engine 3，也就是所谓的PHP NG，重写了ZendVM
   - 标量类型声明：为了v7.1的jit特性做准备，因为jit有了准确的变量类型，可以生成最佳的机器指令
   - zval使用栈内存：ZVAL结构的重构，一个php变量就是一个zval指针，之前是动态从堆上分配，php7直接使用栈内存
   - zend_string存储hash值，array查询不再需要重复计算hash
   - hashtable桶内直接存数据，减少了内存申请次数，提升了cache命中率和内存访问速度
   - zend_parse_parameters改为宏实现，性能提升5%
   - 新增4种opcode，call_user_function，defined等函数变为OpCode指令，速度更快
   - int、float改为直接进行值拷贝
   - AST：Abstract Syntax Tree, 抽象语法树，在编译过程中作为中间件，替换原来直接从解释器吐出opcode的方式，让解释器(parser)和编译器(compliler)解耦, 可以减少一些Hack代码, 同时, 让实现更容易理解和可维护
     1. PHP5 : PHP代码 -> Parser语法解析 -> OPCODE -> 执行
     1. PHP7 : PHP代码 -> Parser语法解析 -> AST -> OPCODE -> 执行
   - 数组php5的底层是HashTable实现的，php7使用了新的Zend Array类型，性能和访问速度上都有了大幅度提升
   - https://www.csdn.net/article/2015-09-16/2825720