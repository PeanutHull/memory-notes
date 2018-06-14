### 语法文档
1. 函数
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
### 应用代码
1. 无限循环：`for( ; ; ) {}`
1. 输入输出
    ```c
    // 获取输入参数
    int main(int argc, char *argv[]) {                  // argc 1参数个数，argv 字符串数组
        printf("可执行程序 %s ,参数个数为[%d], 运行输出：[%s]\n",argv[0],argc,argv[1]); 
        return 0;
    }
    // ./a.out Hello,World!
    // 判断停止输入
    while(scanf("%d",&n)!=EOF|-1);
    // 获取空格后继续输入
    scanf("%[^\n]", str;
    ```
1. 内联汇编获取寄存器的值
    ```c
    unsigned ueax,uebx,uecx,uedx;
    __asm  //使用__asm进行内联汇编
    {
        //使用mov指令将eax寄存器的内容保存到ueax变量
        mov ueax, eax
        mov uebx, ebx
        mov uecx, ecx
        mov uedx, edx
    }
    printf("eax=%x\tebx=%x\tecx=%x\tedx=%x\n", ueax, uebx, uecx, uedx);
    return 0;
    ```
1. 使用回调函数
    ```c
    #include <stdlib.h>  
    #include <stdio.h>
    
    void populate_array(int *array, size_t arraySize, int (*getNextValue)(void)) {
        for (size_t i=0; i<arraySize; i++)
            array[i] = getNextValue();
    }

    // 回调函数 
    int getNextRandomValue(void) {          // 获取随机值
        return rand();
    }
    
    int main(void) {
        int myarray[10];
        populate_array(myarray, 10, getNextRandomValue);
        for(int i = 0; i < 10; i++) {
            printf("%d ", myarray[i]);
        }
        printf("\n");
        return 0;
    }
    ```
1. 错误处理
    ```c
    FILE * pf;
    int errnum;
    pf = fopen ("unexist.txt", "rb");
    if (pf == NULL)
    {
        errnum = errno;
        fprintf(stderr, "错误号: %d\n", errno);
        perror("通过 perror 输出错误");
        fprintf(stderr, "打开文件错误: %s\n", strerror( errnum ));
    }
    else
    {
        fclose (pf);
    }
    ```
