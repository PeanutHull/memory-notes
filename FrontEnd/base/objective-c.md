### 认识
1. 理解：通用的、面向对象的语言，用于开发iOS和Mac OS X操作系统和其应用，支持c和c++语言语法，是对c语言面向对象的扩展。最初由NeXT为NeXTSTEP操作系统开发，.h是头文件，.m是实现文件
1. 组成：预处理命令，变量，方法，语句和表达式，接口，实现，注释
1. 实例
    ```c
    #import <Foundation/Foundation.h>

    int main()
    {
        NSLog(@"Hello, World!");
        return 0;
    }
    ```
### 语法
1. 基础
   - 令牌：包括关键字、标识符、常量、字符串
   - 分号：每个单独语句必须以分号结束
   - 标识符：字母或者下划线开头，后边可以跟数字
   - 空白：编译器忽略空白
   - 区分大小写
   - 注释：单行//，多行/**/
1. 数据类型
   - 基本
     1. 基本类型
        - int：2/4bytes，-32768~32767/20多亿
        - float：4bytes，1.2E-38 to 3.4E+38，精确到6个小数点
        - double：8bytes，2.3E-308 to 1.7E+308，15个小数点
        - char：1bytes，-128~127/0~255
        - NSString :@"hello world"
        - "hello world"
     1. 限定词
        - short：2bytes，-32768~32767；unsigned short：翻倍        
        - long：4bytes，20多亿；unsigned long：翻倍；long double：10byte，3.4E-4932 to 1.1E+4932，19个小数点
        - long long
        - unsigned：unsigned int；unsigned char
        - signed：signed char
   - void：函数无返回值，没有参数的函数可以接受一个void参数
   - 枚举
   - 派生
     1. 指针
     1. 数组
     1. 结构
     1. 联合
     1. 函数
1. 运算符
   - 算术运算符：+ - * / % ++ --
   - 关系运算符：== != > < >= <=
   - 逻辑运算符：&& || !
   - 赋值运算符：= +-*/%<<>>&|^= sizeof & * ?:
   - 位运算符：& | ^ ~ << >>
   - 其他运算符：
1. 变量
   - 理解：一个指向存储区域的名称，让程序可以操控。变量为坐值表达式，
   - 定义：type variable_list
        ```c
        int/float/double/char    i, j, k=5;         # 变量初始化
        extern int i;                               # TODO ？？？
        NSString *lhString;                         # 指针变量
        int func();                                 # 得到函数返回值
        int func()
        {
            return 0;
        }
        int i = func();
        ```
   - 编译、链接、宏
     1. extern
     1. const
     1. static
1. 常量
   - 理解：不能被改变，可以为任意基本数据类型，北鼻称为literals
   - 实例
        ```c
        #define LENGTH 10               # 习惯大写
        const char NEWLINE = '';
        ```
1. 流程控制
   - 循环
     1. for：`int a; for(a=10; a<20; a=a+1){}`
     1. while：`while(condition) {}`
     1. do while：保证能循环一次，`do{}while(condition);`
     1. break;continue;
   - 判断
     1. if：`if() {} else {}`
     1. switch：没有break就继续往下一个case执行，`switch() { case : case : default :}`
1. 表达式
   - 分类
     1. 左值：可能在左边或右边被赋值
     1. 右值：只能出现在右边
1. 函数
   - 定义：指定返回值类型
    ```c
    # C语言形式的函数
    int countNum(int a, int b) {
      int s = a + b;
      return s;
    }
    void show() {
      NSLog(@"hello");
    }
    ```
   - sizeof：返回对象/类型的字节为单位的存储大小，`sizeof(int)`
1. 打印：`NSLog(@"Storage size for int : %d", sizeof(int));`
1. XCFramework
   - 认识：更方便的分发二进制包格式，其中包含一个框架或库的变体使得可在多个平台上使用(MacOS/tvOS)
     1. 可以是静态或动态的，并且可以包含标头
### 面向对象
1. 类
   - 定义和实现
        ```c
        @interface SampleClass:NSObject                             # 继承 NSObject
        @property NSString *name                                    # 类的属性声明
        @property int num                                           # 类的属性声明
        - (void)sampleMethod;
        - (void)sampleMethodWithValue:(SomeType)value;
        + (id)stringWithString:(NSString *)aString;
        @end

        @implementation SampleClass                                 # 实现
        - (void)sampleMethod {
            NSLog(@"Hello, World!");
        }
        @end

        SampleClass *sampleClass = [[SampleClass alloc]init];       # 调用
        [sampleClass sampleMethod];
        ```
1. 方法
   - 分类
     1. 减号方法：即普通方法/对象方法
     1. 加号方法：即类方法/静态方法
1. Foundation框架
   - 特点
     1. 包括NSArray，NSDictionary中的NSSet等扩展数据类型
     1. 包含丰富的函数、字符串处理、url、日期时间、错误处理
### WIKI
1. 关键字
   - auto，else，long，switch
   - break，enum，register，typedef
   - case，extern，return，union
   - char，float，short，unsigned
   - const，for，signed，void
   - continue，goto，sizeof，volatile
   - default，if，static，while
   - do，int，struct，_Packed
   - double，protocol，interface，implementation
   - NSObject，NSInteger，NSNumber，CGFloat
   - property，nonatomic;，retain，strong
   - weak，unsafe_unretained;，readwrite，readonly
1. CocoaPods
   - 认识：是Swift和Objective-C Cocoa项目的依赖管理器
   - 使用
     1. pod install
     1. pod update
### swift
1. 变量 var，常量 let