### 扩展
1. PEAR：php扩展和应用仓库，将常用功能(数据库访问、文件操作、数据结构、缓冲操作、网络协议)写成类库，提供下载，提高开发效率，php编写
1. PECL：PHP Extension Community Library，php扩展社区库，C编写，是通过pear打包系统的php扩展库
1. 扩展安装
   - yum(推荐)：yum/apt-get install php-pear
   - 源码编译安装
     1. cd ext/pcntl
     1. phpize：准备扩展库的编译环境，产生configure
     1. ./configure --prefix=/ --with-php-config=/usr/local/php/bin/php-config
     1. make && make install
     1. php.ini：extension=pcntl.so && restart
   - pecl
     1. pecl install xx
     1. php.ini：extension=xx.so && restart
1. 扩展开发
   - 理解：C/C++基础，同时需要熟悉php扩展API
     1. 要用到PHP自身定义的函数和宏
   - 扩展编译分动态编译和静态编译
     1. 动态：phpize、configure
   - ext_skel快速开发工具
   - 开发
     1. config.m4：PHP_ARG_WITH、PHP_ARG_ENABLE
     1. php_xx.h、xx.c
1. posix/pcntl
1. php5和php7的扩展大部分都不一样了
### 编译
1. opcode：即字节码
1. 默认情况下，Zend引擎先将PHP源码编译为opcode，然后Zend解析引擎逐条执行。这里的opcode码，可以理解成C语言级的函数。而HHVM提升性能方式为替代Zend引擎将PHP代码转换成中间字节码（HHVM自己的中间字节码，通常称为中间语言），然后在运行时通过即时（JIT）编译器将这些字节码转换成x64的机器码，类似于Java的JVM。HHVM为了达到最佳优化效果，需要将PHP的变量类型固定下来，而不是让编译器去猜测。Facebook的工程师们就定义一种Hack写法，进而来达到编译器优化的目的
1. 所有的用户编写的PHP代码，都会被翻译成PHP的虚拟机ZE的虚拟指令（OPCODES）来执行，不论细节的话，就是说，我们所编写的任何PHP脚本，都会最终被翻译成一条条的指令，从而根据指令，由相应的C编写的函数来执行
### SAPI模块
### 引擎
1. HHVM：重写的php引擎
1. JIT特性
1. php特性：动态、符号表、间接引用
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
1. JIT：just in time，即时编译，表示运行时将指令转为二进制机器码，jit可以将opcode直接转为机器码，大幅提升性能
### 内存
1. 类和对象在内存中的体现
   - 栈空间段：存储占用相同空间长度并且占用空间小的数据类型，可直接存取，存对象名称
   - 堆空间段：不定长、体积大，不可直接存取，存对象。通过名称找对象
   - 代码段
   - 初使化静态段:存放静态属性和方法，类第一次被加载即放入，可被堆内存的对象所共享
### 调优
1. 发挥PHP7的性能
   - 开启Opcache
     1. zend_extension=opcache.so
     1. opcache.enable=1
     1. opcache.enable_cli=1
   - 使用GCC 4.8以上进行编译
   - 开启HugePage （根据系统内存决定）：操作系统默认的内存是以4KB分页的，而虚拟地址和内存地址需要转换， 而这个转换要查表，CPU为了加速这个查表过程会内建TLB(Translation Lookaside Buffer)。 显然，如果虚拟页越小，表里的条目数也就越多，而TLB大小是有限的，条目数越多TLB的Cache Miss也就会越高，所以如果我们能启用大内存页就能间接降低这个TLB Cache Miss。php将采用大内存页来保存，减少TLB miss，提高性能
   - PGO：Profile Guided Optimization，第一次编译成功后，用项目代码去训练PHP，会产生一些profile信息，最后根据这些信息第二次gcc编译PHP就可以得到量身定做的PHP7