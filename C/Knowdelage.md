### 语法文档
1. 存储类别
   - 特性
     1. 作用域：描述可见性
        - 文件作用域
        - 块作用域
     1. 链接：描述可见性
        - 内部：一个文件内
        - 外部：另一个文件
     1. 存储期：描述内存存在时间
        - 静态
        - 线程：每个线程的私有备份，线程期一直存在
        - 自动：进存退消
        - 动态分配
   - 分类
     1. 自动
     1. 寄存器
     1. 静态、无链接：块中static
     1. 静态、外部链接：没有static
     1. 静态、内部链接：函数外static
   - 函数的存储类别
     1. 外部：默认，可被其他文件访问
     1. 静态：只能本文件
     1. 内联：C99
1. 存储类说明符
   - static
        ```c
        #include <stdio.h>

        void func1(void);           // 函数声明
        static int count=10;        // 全局变量 - static 是默认的
        
        int main() {
            while (count--) {
                func1();
            }
            return 0;
        }
        
        void func1(void)
        {
            // 'thingy' 是 'func1' 的局部变量，只初始化一次，每次调用函数 'func1'，'thingy' 值不会被重置
            static int thingy=5;
            thingy++;
            printf(" thingy 为 %d ， count 为 %d\n", thingy, count);
        }
        ```
1. 变量限定符
    ```c
    volatile const int loc;             // 程序不能更改，代理可更改，两个符号顺序无所谓
    ```
1. 定义可变参数
    ```c
    #include <stdio.h>
    #include <stdarg.h>

    void average(int num, ...){
        va_list valist;                     # 创建va_list类型变量
        
        va_start(valist, num);              # 为 num 个参数初始化 valist
        for (i = 0; i < num; i++) {
            va_arg(valist, int);            # 访问所有赋给 valist 的参数
        }
        va_end(valist);                     # 清理为 valist 保留的内存
    }
    ```
1. io
   - gets：`char *gets(char *s)`
   - puts：`int puts(const char *s)`
1. 文件
   - 函数
     1. fopen：`FILE *fopen(const char * filename, const char * mode);`
     1. fclose：`int fclose(FILE *fp);`

     1. fgetc：`int fgetc(FILE * fp);`
     1. fgets：`char *fgets(char *buf, int n, FILE *fp);`
     1. fscanf：`int fscanf(FILE *fp, const char *format, ...)`

     1. fputc：`int fputc(int c, FILE *fp );`
     1. fputs：`int fputs(const char *s, FILE *fp);`
     1. fprintf：`int fprintf(FILE *fp, const char *format, ...)`，输出到标准错误流：`fprintf(stderr, i)`

     1. fseek：`int fseek(FILE *fp, long offset, int whence);`
   - 示例代码
     1. 读取文件
        ```c+
        int ch;
        FILE * fp;
        fp = fopen("a.txt", "r");
        while ((ch = getc(fp)) != EOF) {        // 如果单判断ch值尚未确定，
            putchar(ch);
        }
        ```
1. 预处理命令示例
    ```c
    // 宏定义
    #define MAX_ARRAY_LENGTH 20
    // 宏定义运算符
    #define tokenpaster(n) \
        printf ("token" #n " = %d", token##n)
    #define MAX(x,y) ((x) > (y) ? (x) : (y))            // 宏函数

    int main(void) {
        int token34 = 40;

        tokenpaster(34);
        return 0;
    }

    // 文件包含
    #include <stdio.h>                      # 从系统库中获取stdio.h
    #include "myheader.h"                   # 从本地目录中获取myheader.h

    // 条件预处理
    #ifndef MESSAGE
        #define MESSAGE "aaa"
    #endif
    // 是否定义判断符
    #if !defined (MESSAGE)
        #define MESSAGE "aaa"
    #endif
    ```
1. 头文件
    ```c
    // 宏名配置头文件
    #define SYSTEM_H "system_1.h"
    #include SYSTEM_H
    // 有条件引用
    #if SYSTEM_1
    # include "system_1.h"
    #elif SYSTEM_2
    # include "system_2.h"
    #elif SYSTEM_3
    #endif
    // 实际实用：使用_GLOBAL_H将所有头文件集合，所有文件就拥有了
    #ifndef _GLOBAL_H
    #define _GLOBAL_H
    #include 其他头文件...
    #endif
    ```
1. 
    ```c
    int *getx() {
        int x = 10;
        return &x;
    }

    int main(void) {
        int *p = getx();        # 因为getx()中变量x的作用域为getx()函数内部，这里得到一个临时栈变量x的地址，getx()函数调用结束后地址就无效了，但是后面的*p=20仍然在对其进行访问并修改，结果可能对也可能错
        *p = 20;
        printf("%d", *p);
        getchar();
    }
    ```
1. typedef
   - typedef：为类型取新名字，作为缩写使用，通常大写，提高程序可读性
    ```c
    // 为单字节数字定义了术语 BYTE
    typedef unsigned char BYTE;
    BYTE  b1, b2;                    // 相当于unsigned char b1,b2
    // 对结构体使用typedof定义新数据类型，使用新类型直接定义结构变量
    typedef struct Books {} Book;
    Book book;
    ```
   - typedef和#define：都是为数据类型定义
     1. #define不仅可以为类型定义名称，也能为数值定义名称。就是字面上的替换
     1. typedof编译器执行解释，#define语句由预编译器处理
     1. #define对typedef定义的名称不能扩展
     1. 连续定义变量时，typedef能保证所有变量为同类型，#define不行
        ```c
        #define PTR_INT int *
        PTR_INT p1, p2;             //p1、p2 类型不相同，宏展开后变为int *p1, p2;
        typedef int * PTR_INT
        PTR_INT p1, p2;             //p1、p2 类型相同，都指向int类型的指针
        ```
1. print参数
   - %d 十进制整型，%f 浮点型
   - %c 字符，%s 字符串
   - %p 指针
   - %x 十六进制, %a 浮点数/十六进制/p计数法，%lu 32位无符号整数，%E 以指数形式输出单/双精度实数
### 数据结构
1. 链表：前一个结构存储下一个结构的指针，来连起来，动态分配结构的序列链
```c
struct film{
    char title[10];
    struct film * next;
}
```
1. 队列：特殊链表，先进先出，队尾加入，队首离开，类似排队，可用环形、链表实现
1. 二叉查找树：结合了二分查找策略的结构，每个节点包含一个项和两个指向其他节点的指针。二叉树只有满员(平衡)时效率最高
### wiki
1. 问题
   - auto修饰符的作用————
   - 头文件是啥？作用有什么————
   - 宏的完整理解————
   - 注释的形式————
   - char数据类型的理解————
   - signed类型的char什么意思————
   - 枚举类型的学习、派生类型的深入了解
   - 数组类型的学习————
   - 指针的学习————
   - c语言的变量的内存结构和表示
   - 存储类的作用，c语言的寄存器的理解————
   - &运算符是干啥的————
   - 指针的运算和为什么按照类型的长度增加，十六进制的运算
   - 指针的++和--怎么回事
   - size_t什么玩意————
   - 数据类型unsigned的是什么类型————
   - 结构体数组没有深入了解————
   - 文件访问模式，带加号的和不带的啥区别
   - EOF是什么玩意————
   - 头文件引入前端目录怎么写
   - typedef的学习和其他复杂声明的学习，优先级
   - 两条线：一条笔记线，一条书的目录线，优先将书过一遍，到12章了
     1. 书后B部分基础看一下就可以看书中内容，高深的有基础了再看
### 未整理
1. 内存管理
   - 自己手动创建的，都要自己手动销毁，比如某一个结构体里边的malloc，结构体销毁了，malloc出来的可不会销毁，需要手动销毁
常见的内存错误及其对策

发生内存错误是件非常麻烦的事情。编译器不能自动发现这些错误，通常是在程序运行时才能捕捉到。而这些错误大多没有明显的症状，时隐时现，增加了改错的难度。有时用户怒气冲冲地把你找来，程序却没有发生任何问题，你一走，错误又发作了。

常见的内存错误及其对策如下：

内存分配未成功，却使用了它。编程新手常犯这种错误，因为他们没有意识到内存分配会不成功。常用解决办法是，在使用内存之前检查指针是否为NULL。如果指针p是函数的参数，那么在函数的入口处用assert(p!=NULL)进行检查。如果是用malloc或new来申请内存，应该用if(p==NULL) 或if(p!=NULL)进行防错处理。

内存分配虽然成功，但是尚未初始化就引用它。犯这种错误主要有两个起因：一是没有初始化的观念；二是误以为内存的缺省初值全为零，导致引用初值错误（例如数组）。内存的缺省初值究竟是什么并没有统一的标准，尽管有些时候为零值，我们宁可信其无不可信其有。所以无论用何种方式创建数组，都别忘了赋初值，即便是赋零值也不可省略，不要嫌麻烦。

内存分配成功并且已经初始化，但操作越过了内存的边界。例如在使用数组时经常发生下标“多1”或者“少1”的操作。特别是在for循环语句中，循环次数很容易搞错，导致数组操作越界。

忘记了释放内存，造成内存泄露。含有这种错误的函数每被调用一次就丢失一块内存。刚开始时系统的内存充足，你看不到错误。终有一次程序突然死掉，系统出现提示：内存耗尽。动态内存的申请与释放必须配对，程序中malloc与free的使用次数一定要相同，否则肯定有错误（new/delete同理）。

释放了内存却继续使用它。

有三种情况：

(1). 程序中的对象调用关系过于复杂，实在难以搞清楚某个对象究竟是否已经释放了内存，此时应该重新设计数据结构，从根本上解决对象管理的混乱局面。

(2). 函数的return语句写错了，注意不要返回指向“栈内存”的“指针”或者“引用”，因为该内存在函数体结束时被自动销毁。

(3). 使用free或delete释放了内存后，没有将指针设置为NULL。导致产生“野指针”。

那么如何避免产生野指针呢？这里列出了5条规则，平常写程序时多注意一下，养成良好的习惯。

规则1：用malloc或new申请内存之后，应该立即检查指针值是否为NULL。防止使用指针值为NULL的内存。

规则2：不要忘记为数组和动态内存赋初值。防止将未被初始化的内存作为右值使用。

规则3：避免数组或指针的下标越界，特别要当心发生“多1”或者“少1”操作。

规则4：动态内存的申请与释放必须配对，防止内存泄漏。

规则5：用free或delete释放了内存之后，立即将指针设置为NULL，防止产生“野指针”。


2.内存出错误的原因：
    (1)内存申请未成功，然后进行使用；//在编程时经常用if (p == NULL) 进行判断；
    (2)内存申请成功，但是没有初始化，会造成内存出错；
    (3)内存初始化成功，但是操作越界，比如在数组的操作当中加一；char a [5] = "hello";会造成段错误,没有考虑到'\0'的存储空间，若越界访问的内存空间是空闲的，则程序可能不受影响。若空间已经被占用，若执行了非法操作，程序可能奔溃。
    (4)忘记释放内存或者释放一部分则会造成内存泄露。
 
3.malloc 的使用：
    (1)在申请时必须指明大小；
    (2)判断是否申请成功，若不成功则不能进行使用，否则会造成内存出错；
    (3)返回指针是一个void * ,所以在使用前必须进行强制转换；
    (4)显式初始化， 堆区的内容在自动分配时不会初始化(包括清零操作)，所以程序中要进行必要的初始化。
 
4.free函数的使用：
    (1)在申请完内存时，忘记释放或者释放一部分，会导致内存泄露；
    (2)重复释放会 导致内存出错；//当第一次释放内存时，指针指向的堆区会释放。此时，操作系统有可能给释放的堆区分配其他的应用程序，当进行第二次释放时，会破坏其他的应用程序的数据。
    (3)在内存释放结束之后，指针要清空(p == NULL)， 因为在执行free函数之后，指针指向的空间会释放，但是p仍然是一个地址值。
    (4)malloc 必须和 free成对使用；
    (5)free 只能释放堆区（动态存储区），不能释放静态区，还有栈区。
 
5.内存泄露：
      当动态分配的内存不在使用时， 它应给被释放，这样以后可以重新使用内存。分配内存但是在使用完毕之后不进行释放将会引起内存泄露。内存泄漏并非指内存在物理上的消失，而是应用程序分配某段内存后，由于设计错误，导致在释放该段内存之前就失去了对该段内存的控制，从而造成了内存的浪费。
      在一个进程中创建多个线程如果对线程资源不进行释放phread_join()，则会造成内存泄露
https://www.cnblogs.com/tuhooo/p/7221136.html