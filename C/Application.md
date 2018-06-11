### 语法文档
1. 函数
   - printf
     1. 参数分类：%d 整数，%c 字符，%s 字符串，%x 十六进制, %p 十六进制数, %lu 32位无符号整数，%E 以指数形式输出单/双精度实数
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
### 应用代码
1. 无限循环：`for( ; ; ) {}`
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