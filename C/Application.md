### 语法文档
1. 函数
   - printf
     1. 参数分类：%d 整数，%lu 32位无符号整数，%E 以指数形式输出单/双精度实数
1. 存储类
   - static
    ```c
    #include <stdio.h>

    /* 函数声明 */
    void func1(void);
    
    static int count=10;        /* 全局变量 - static 是默认的 */
    
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
### 代码片段
1. 无限循环
```c
for( ; ; ) {}
```
1. 输入输出
    ```
    // argc，参数个数
    // argv，字符串数组
    int main(int argc, char *argv[]) {
        printf("可执行程序 %s ,参数个数为[%d], 运行输出：[%s]\n",argv[0],argc,argv[1]); 
        return 0;
    }
    // ./a.out Hello,World!
    ```