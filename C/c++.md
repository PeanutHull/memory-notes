### c++
1. 认识：静态类型、编译型，中级语言
   - 基本兼容c的语法
   - 支持过程化、面向对象和泛型编程，c是面向过程的
   - 检查严格类型，手动回收内存
   - 支持运算符重载
   - 支持泛型编程、模板
   - 支持异常处理
1. 特点
   - 强大的抽象封装能力，强大的工程开发能力
   - 高性能，占用资源少，低功耗，可以将性能发挥更多
   - 语法复杂，细节多，需要好的范式，否则难以维护
1. 应用：编写设备驱动程序、有实时性操作硬件的软件，mac和windows系统的主要用户接口使用c++编写
   - 大型桌面应用程序，如chrome和office
   - 大型网站后台
   - 游戏和游戏引擎
   - ai、视觉，如opencv、tensorflow
   - 数据库，如MongoDB、sql server
   - 嵌入式，自动驾驶系统
1. begin
    ```c++
    #include <iostream>

    int main() {
        std::cout << "Hello, World!" << std::endl;
        return 0;
    }
    ```
### 基础
1. 特性：和C高度相同，大小写区分、标识符、注释等
1. 组成
     1. 核心语音
     1. 标准库，提供大量函数，用于操作文件、字符串等
     1. 标准模板库：STL，提供用于操作数据结构的方法
1. 数据类型
   - 分类
     1. bool：布尔
     1. char：字符，1byte，-128~127或0~255
     1. int：整型，4byte，-2147483648~2147483647
        - unsigned int：4byte
        - short int：2byte
        - long int：8byte，-9,223,372,036,854,775,808~9,223,372,036,854,775,807，
        - unsigned short int：2byte，0~65,535
     1. float：浮点，4byte，+/-3.4e+/-38，7个数字。格式为1位符号，8位指数，23位小数
     1. double：双浮点，8byte。格式为1位符号，11位指数，52位小数
        - long double：16byte
     1. void：无类型，表示类型的缺失
     1. wchar_t：宽字符，`typedef short int wchar_t;`，2或4byte
   - 类型修饰符
     1. 特点
        - 可使用速记符号来声明无符号短整数或无符号长整数，即不写int
     1. 分类
        - signed、unsigned：可用于整型、字符型，可作为short、long的前缀
        - short：可用于整型
        - long：可用于整型、双精度型
   - 派生类型
     1. enum
        - 认识：枚举，由用户定义的若干枚举常量的集合
        ```
        enum 枚举名{ 
            标识符[=整型常数], 
            标识符[=整型常数], 
        ... 
            标识符[=整型常数]
        } 枚举变量;        
        ```
        - 使用
        ```c++
        // red为0，默认整型常数自增也可自定义
        // 变量c的类型为color，最后c被赋值为blue
        enum color { red, green, blue } c;
        c = blue;

        // blue为6，具备某枚举值定义后后边枚举自增特性，前边的不管
        enum color { red, green=5, blue };
        ```
   - 操作
     1. typedef：为已有类型声明新名字，`typedef type newname;`
   - wiki
     1. 早期c编译器int2byte，long int4byte，新版标准兼容了早期
1. 变量
   - 认识：只不过是程序可操作的存储区的名称，变量类型决定了变量存储的大小和布局
   - 声明和定义：`type var1 = xx, var2, var3, ...;`，type必须是有效的数据类型
   - 作用域
     1. 局部：函数或代码块内部声明，只能内部使用，不会被初始化，局部会覆盖全局
     1. 全局：函数外部声明，会被初始化
        - 初始化对应表
          1. int：0
          1. char：'\0'
          1. float：0
          1. double：0
          1. pointer：NULL
     1. 形式参数：函数参数的定义中声明
   - 限定符
     1. const
     1. volatile：告诉编译器不需要优化，可以直接从内存访问，不用可能优化到寄存器中
     1. restrict：指针是唯一一种访问它所指向的对象的方式，C99
1. 常量
   - 认识：是程序执行期间不会改变的固定值，是基本数据类型，是不能改的变量，通常大写，也叫字面量
   - 定义
     1. #define：cpp，定义，`#define identifier value`
     1. const：关键字，声明，`const type variable = value;`
   - 分类
     1. 整数常量
        - 前缀指定基数
          1. 0x/0X：十六
          1. 0：八
          1. 无前缀：十
        - 后缀：u和l的组合，不区分大小写，二者前后顺序任意
          1. U：无符号整数，unsigned
          1. L：长整数，long，
     1. 浮点常量：由整数、小数点、小数、指数组成，可使用小数形式、指数形式来表示浮点常量，指数用e或E 
     1. 布尔常量：true、false，不能将二者看为1和0
     1. 字符常量：括在单括号中
        - 分类
          1. 窄字符常量：存储在char中
          1. 宽字符常量：以L开头，如`L'x'`，存储在wchar_t的变量中
        - 字符分类
          1. 普通：'a'
          1. 转义序列：'\t'
          1. 通用字符：'\u02C0'
     1. 字符串常量：括在双引号中，空格连接符，\ 分行符
1. 组成
   - const的用法
   - 引用的用法
   - define用法
   - 构造函数
   - 析构函数
   - 拷贝构造
   - new、delete 和 malloc、free 的区别
   - 访问限定符 public、private、protected
   - 深拷贝和浅拷贝
   - 友元函数
   - static
   - 内联函数
   - 继承、虚继承
   - 钻石继承问题
   - 同名覆盖问题
   - 虚函数表
   - 虚指针
   - 虚函数、纯虚函数
   - 接口
   - 多态
   - 重写
   - 重载
   - 函数重载
   - 运算符重载
   - 流类库和文件
1. 重难点
   - 指针、内存分配的见解，实践经验
1. 多线程
   - Thread：c++ 11有了
1. 编译器：g++
### 高级
1. 泛型编程
1. lambda
### 库
1. folly
1. boost：为标准库提供扩展的c++程序的总称，由boost社区维护(各种大牛)。20多个分类，字符串、算法、高阶编程等。一般标准库功能都有了，体积又太大，不建议为了用而用
1. STL：Standard Template Library，是泛型的
   - 组件
     1. 仿函数
     1. 算法
     1. 迭代器
     1. 适配器：adapter
     1. 空间配置器：内存分配管理
     1. 容器
### wiki
1. 关键是要理解概念，而不应过于深究语言的技术细节
1. 历史
   - 标准化：ANSI标准，为确认其通用性，所有主要的c++编译器都支持
     1. C++98：1998，第一个标准
     1. C++03：2003，第二个
     1. C++11：2011，第三个
     1. C++14：2014，第四个
     1. parallelism TS：2015，并行计算的扩展
     1. TM TS：2015，事务性内存扩展
     1. coroutines TS：2017，协程库扩展
     1. C++17：2017，第五个
     1. C++20
   - 过程
     1. 1979年，出现，Bjarne Stroustrup在贝尔实验室设计开发
     1. 1983年，c with classes，第一版，正式命名
     1. 1998年，c++标准委员会发布第一个c++国际标准，即c++ 98，STL标准库诞生
     1. 2011年，c++ 11诞生，一些新模块从boost库中派生出来，之后三年一版发布新的语言标准
1. wiki
   - 后缀
     1. .cpp/.hpp：vs的文件
     1. .cc/.cxx/.hh/.hxx/.c++：gcc的文件，为了区别c，表示c++源/头文件
   - 编程风格：Fortran、C、Smalltalk等
   - 关键字
     1. bool、true、false、int、float、double、char、wchar_t
     1. unsigned、signed、short、long
     1. enum
     1. asm、struct、union
     1. return、if、else、for、while、do、break、continue、switch、case、default、goto
     1. void
     1. namespace、class、new、this、private、protected、public
     1. static、static_cast、dynamic_cast、const、const_cast、volatile、typedef、sizeof
     1. try、catch、throw
     1. 
     1. auto、operator、explicit、export、extern、register、typeid、reinterpret_cast、typename、friend、using、virtual、inline、delete
	 1. mutable、template
1. 三字符组
   - 认识：用于表示另一个字符的三个字符序列，vc++ 2010开始不再替换，g++支持但给出编译警告
     1. 总是以两个问号开头
     1. 可以出现在任何地方，包括字符串、字符序列、注释和预处理指令
     1. 双问号输出方式
        - 字符串的自动连接："?""?"
        - 转义序列："?\?"
   - 组成
     1. ??=：#
     1. ??/：\
     1. ??'：^
     1. ??(：[
     1. ??)：]
     1. ??!：|
     1. ??<：{
     1. ??>：}
     1. ??-：~