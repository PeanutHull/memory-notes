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
