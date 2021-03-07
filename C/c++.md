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
1. 应用
   - 编写设备驱动程序、有实时性操作硬件的软件，mac和windows系统的主要用户接口使用c++编写
   - 大型桌面应用程序，如chrome和office
   - 大型网站后台
   - 游戏和游戏引擎
   - ai、视觉，如opencv、tensorflow
   - 数据库，如MongoDB、sql server，java虚拟机
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
     1. typedef：为已有数据类型声明新名字，`typedef type newname;`
   - wiki
     1. 早期c编译器int2byte，long int4byte，新版标准兼容了早期
1. 运算符：和c一样
   - 算术
   - 关系
   - 逻辑
   - 位
   - 赋值
   - 杂项
1. 字符串
   - 形式
     1. c风格字符串
     1. c++的string类
   - string类
    ```c++
    #include <string>
 
    using namespace std;

    string str1 = "xx";
    string str2 = "xx";

    // 连接
    str3 = str1 + str2;
    // 长度
    int len;
    len = str3.size();
    ```
### 语法
1. 变量
   - 认识：只不过是程序可操作的存储区的名称，变量类型决定了变量存储的大小和布局
   - 声明和定义：`type var1 = xx, var2, var3, ...;`，type必须是有效的数据类型
   - 限定符
     1. const：改为常量
     1. volatile：告诉编译器不需要优化，可以直接从内存访问，不用可能优化到寄存器中
     1. restrict：指针是唯一一种访问它所指向的对象的方式，C99
   - 存储类：规定变量/函数的可见性和生命周期
     1. static：使声明周期保持存在
        - 局部变量：保持局部变量的存在，而不需要每次进入和离开作用域时进行创建和销毁，可以保持其值，程序运行结束以后才释放
        - 全局变量：只能在本文件中访问，不能在其它文件访问，包括函数，extern来了也不好使
        - 类数据成员：会导致仅有一个该成员的副本被类的所有对象共享
     1. extern：提供对所有文件都可见的引用，用于多个文件共享全局变量和函数
     1. mutable：用于类的对象，允许对象的成员替代常量
     1. thread_local：C++11新增，仅可在其上创建的线程访问，随着线程创建和销毁，每个线程都有自己的变量副本
     1. auto：C++11已删除，C++17不再是，用来自动推断被声明变量的类型，如`auto f=3.14;`，使用少且多余
     1. register：C++17弃用，定义存储在寄存器中而不是内存的局部变量，只是可能存在看实现，最大为寄存器大小，且不能用&，没有内存地址
   - 引用
     1. 认识：是已存在变量的别名，不存在空引用，一旦初始化就不能修改，必须在创建的时候初始化
     1. 使用
        ```c++
        int i = 17;

        // r是一个初始化为i的整型引用
        int&  r = i;
        ```
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
1. 函数：同c
1. 数组：同c
1. 动态内存
   - 认识：内存分为堆和栈
   - 使用
     1. new：为内置数据类型、类、结构体、指针在执行时分配内存。malloc()也可用，new比它多了创建对象
   - 实例
    ```c++
    // 分配内存，检查错误值，是否返回NULL指针
    int* pvalue  = NULL;
    if(!(pvalue = new int))
    {
        exit(1);
    }

    // 释放
    delete pvalue;

    // 数组操作
    char* pvalue  = NULL;
    pvalue  = new char[20];
    delete [] pvalue;
    ```
1. 组成
   - new、delete 和 malloc、free 的区别
   - 深拷贝和浅拷贝
   - 钻石继承问题
   - 虚指针
   - 流类库和文件
   - 指针、内存分配的见解，实践经验
1. 异常处理
   - 认识：转移程序控制权的方式
    ```c++
    throw "xxxx";

    try {
    }catch( ExceptionName e1 ) {

    }catch(const char* msg) {           // 捕获字符串的

    }
    ```
   - 标准异常：<exception>，父子结构，所有异常的父类为`std::exception`
     1. std::bad_alloc
     1. std::bad_exception
     1. std::runtime_error：不可以通过读取代码检测的异常 
        - std::overflow_error，发生数学上溢
        - std::range_error，尝试存储超范围的值
        - std::underflow_error，发生数学下溢
   - 定义新异常
    ```c++
    // 定义
    struct MyException : public exception
    {
        const char * what () const throw ()         // what()被所有子异常类重载
        {
            return "xxx";
        }
    };
    // 使用
    try
    {
        throw MyException();
    }
    catch(MyException& e)
    {
        e.what();
    }
    catch(std::exception& e)
    {
        // 其他的错误
    }
    ```
1. 命名空间
   - 认识：定义了一个范围
   - 实例
    ```c++
    // 定义，可以写在一个文件里，写多次就是添加元素
    namespace namespaceName {}

    // 调用
    name::code;
    name::code();

    // 声明使用的命名空间
    using namespace std;
    using std::cout;                // 部分引用

    // 嵌套
    namespace namespaceName1 {
        namespace namespaceName2 {
        }
    }
    using namespace namespaceName1::namespaceName2;
    ```
1. 模板
   - 认识：是泛型编程的基础，是创建泛型类或函数的蓝图或公式，可以用来定义函数和类，
     1. 泛型编程：以一种独立于任何特定类型的方式编写代码
   - 分类
     1. 函数模板：`template <typename type> returnType funcName(parameter list){}`，type是占位符类型名称，可在类实例化时指定
     1. 类模板：`template <class type> class class-name {}`
   - 定义
    ```c++
    // 实例，比较大小
    template <typename T>
    inline T const& Max (T const& a, T const& b) 
    { 
        return a < b ? b:a; 
    } 
    // 使用
    Max(i, j)
    ```
### 面向对象
1. 类
   - 定义：成员访问运算符.，范围解析运算符::
    ```c++
    class ClassName
    {
        public:                 // 访问修饰符，public、protected、private
            int xx;             // 成员变量
            friend void xxx(ClassName className);      // 声明类的友元函数
        private:
            int xx();           // 成员方法声明
            int xx(){};         // 成员方法定义
        protected:
            ClassName()         // 构造函数
            ~ClassName()        // 析构函数
            Line( const Line &obj);                     // 拷贝构造函数
    };                          // 封号结束类
    // 成员函数定义
    double ClassName::xx()
    {
    }
    // 友元类
    friend class ClassTwo;
    ```
   - 静态：使用::访问
     1. 静态成员：所有对象都只有一个副本。创建第一个对象时所有的静态数据会被初始化为零，不能把静态成员的初始化放在类的定义中
     1. 静态成员函数：类对象不存在也能被调用，只能访问静态成员数据，没有this指针
   - 抽象类：为了给其他类提供一个可以继承的适当的基类。如果类中至少有一个纯虚函数，那就是，不能实例化对象会编译错误，只能当接口
   - explicit：用于修饰只有一个参数的类构造函数, 防止类构造函数的隐式自动转换，构造函数默认implicit
   - 初始化列表：快捷初始化变量值
    ```c++
    Line::Line( double len): length(len)
    {
    }
    // 相当于
    Line::Line( double len)
    {
        length = len;
    }
    ```
   - this：this指针是所有成员函数的隐含参数，可用来指向调用对象，就是代替对象，如`this->xx()`
   - 类指针
    ```c++
    Box *ptrBox;
    ptrBox = &Box1;
    ptrBox->xx();
    ```
   - 拷贝构造函数
     1. 通过使用另一个同类型的对象来初始化新创建的对象
     1. 复制对象把它作为参数传递给函数
     1. 复制对象，并从函数返回这个对象
   - 友元函数/友元类：定义在类外部但这个函数有权访问类的private、protected成员，友元函数不是成员函数。友元类所有成员都是友元
   - 内联函数：inline，为解决程序中函数调用的效率问题，是空间代价换时间的节省。编译器会将其内联展开, 而不是按通常的函数调用机制进行调用，少于10行再用
     1. 优点: 当函数体比较小的时候, 内联该函数可以令目标代码更加高效. 对于存取函数以及其它函数体比较短, 性能关键的函数, 鼓励使用内联
     1. 缺点: 滥用内联将导致程序变慢. 内联可能使目标代码量或增或减, 这取决于内联函数的大小. 内联非常短小的存取函数通常会减少代码大小, 但内联一个相当大的函数将戏剧性的增加代码大小. 现代处理器由于更好的利用了指令缓存, 小巧的代码往往执行更快
1. 对象
   - 定义
    ```c++
    ClassName ObjectName;
    ObjectName.xx;
    ObjectName.xx();
    ```
1. 继承
   - 认识：
     1. 继承了所有的基类方法，除外有构造函数、析构函数、拷贝构造函数、友元函数、重载运算符
     1. 继承类型：控制成员的可见性
        - public：公是公，保护是保护
        - protected：公和保护都是保护
        - private：公和保护都是私
     1. 多继承
     1. 虚拟继承：virtual，解决环状继承
   - 定义：基类、派生类
    ```c++
    // 基类
    class Animal
    {
    };
    //派生类
    class Dog : public Animal, public Earth
    {
    };
    ```
1. 重载
   - 函数重载：同样的函数名称，不同的形参，编译器会进行重载决策，决定合适的定义
   - 运算符重载：`ClassName operator+ ();`，关键字operator + 符号
     1. 不可重载的运算符
        - .：成员访问运算符
        - .*, ->*：成员指针访问运算符
        - ::：域运算符
        - sizeof：长度运算符
        - ?:：条件运算符
        - #： 预处理符号
1. 多态
   - 定义：多种形态，就是在继承形态下，不同派生类有各自的方法，是否使用派生类自己方法的问题，不加virtual就用基类的
     1. 虚函数：类中virtual声明的函数，派生类中重新定义基类中的虚函数时，会告诉编译器不要静态链接到该函数，要根据所调用的对象类型来选择调用的函数，叫动态链接
     1. 纯虚函数：`virtual int xx() = 0;`，告诉编译器函数没有实体
### 应用
1. 预处理：同c
1. io
   - 输入输出
     1. <iostream>：cin、cout、cerr、clog对象，即标准输入流、标准输出流、非缓冲标准错误流、缓冲标准错误流，<< >>可多次使用
        - cin：和流提取运算符 >> 结合使用。附属到标准输入设备，通常是键盘
          1. `cin >> xx;`，按照回车键后获取所有字符
          1. `cin >> xx1 >> xx2;`，相当于赋值两次
        - cout：和流插入运算符 << 结合使用。附属到标准错误设备，通常是显示屏
          1. `cout << "xx"`
          1. `cout << "xxxxxx" << varName << endl;`
        - endl：在行末添加一个换行符
        - cerr：非缓冲，每个流插入都会立即输出
        - clog：插入到clog会先存储在缓冲区，直到缓冲填满或缓冲区刷新时才输出
     1. <iomanip>：从文件读取信息
     1. <fstream>：表示文件流
   - 文件
    ```c++
    // 以写模式打开文件
    ofstream outfile;
    outfile.open("afile.dat");
    outfile.close();
    
    // 以读模式打开文件
    ifstream infile; 
    infile.open("afile.dat"); 
    infile >> data; 
    infile.close();

    // 文件位置指针， istream的seekg()、ostream的seekp() 
    ios::beg                // 流开头开始定位
    ios::cur
    ios::end
    ```
1. 类库
   - cgicc：`libcgicc.so`，c++处理cgi请求的
   - folly
   - boost：为标准库提供扩展的c++程序总称，由boost社区维护(各种大牛)。20多个分类，字符串、算法、高阶编程等。一般标准库功能都有了，体积又太大，不建议为了用而用
1. 标准库
   - 分类
     1. 标准函数库：继承自c，包含了所有的c标准库，为支持类型安全做一定的添加和修改
     1. 面向对象类库
        - io类
        - String类
        - 数值类
        - 异常处理类
        - 
   - <cmath>
     1. sin()
     1. cos()
     1. tan()
     1. srand()/rand()
   - <ctime>：处理时间
1. STL：Standard Template Library，标准模板库，提供了通用的模板类和函数，可以实现多种流行和常用的算法和数据结构，如向量、链表、队列、栈。是泛型的
   - 组件
     1. 容器：用来管理某一类对象的集合
     1. 算法：提供作用于容器的各种操作方式
     1. 迭代器：用于遍历对象集合的元素
     1. 适配器：adapter
     1. 空间配置器：内存分配管理
     1. 仿函数
1. cgi编程
   - 环境变量：`getenv("CONTENT_TYPE")`，包括CONTENT_TYPE、CONTENT_LENGTH、HTTP_COOKIE、REMOTE_HOST、REMOTE_ADDR、SERVER_NAME等
   - 使用cigcc
    ```c++
    #include <cgicc/CgiDefs.h> 
    #include <cgicc/Cgicc.h> 
    #include <cgicc/HTTPHTMLHeader.h> 
    #include <cgicc/HTMLClasses.h>  

    using namespace std;
    using namespace cgicc;

    Cgicc cgi;

    // 获取get参数
    orm_iterator fi = cgi.getElement("xx");  
    if( !fi->isEmpty() && fi != (*cgi).end()) {  
        cout << **fi << endl;  
    }

    // 获取cookie
    const CgiEnvironment& env = cgi.getEnvironment();
    for( cci = env.getCookieList().begin(); cci != env.getCookieList().end(); ++cci )
    {
        cci->getName()
        cci->getValue()
    }

    // 获取文件
    const_file_iterator file = cgi.getFile("xx");
    if(file != cgi.getFiles().end()) {
        // 在 cout 中发送数据类型
        cout << HTTPContentHeader(file->getDataType());
        // 在 cout 中写入内容
        file->writeToStream(cout);
    }
    ```
### 高级
1. 泛型编程
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
     1. auto、register、static、extern、export、template、const、mutable、volatile
     1. static_cast、dynamic_cast、reinterpret_cast、const_cast
     1. typedef、sizeof、typeid
     1. if、else ———— switch、case、default ———— for、while、do、break、continue、goto
     1. void、return
     1. namespace、using、class、explicit、implicit、virtual、friend、inline、operator、private、protected、public、this
     1. try、catch、throw
     1. new、delete
     1. typename
   - 特点
     1. 悬挂指针、内存越界
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