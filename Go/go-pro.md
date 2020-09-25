### code
1. 闭包
    ```go
    // 闭包，闭包是一个函数值，来自函数体的外部的变量引用，函数可以对这个引用值进行访问和赋值；换句话说这个函数被“绑定”在这个变量上
    func adder() func(int) int {   // 函数adder返回一个闭包。每个闭包都被绑定到其各自的sum变量上，pos按照pos的节奏，neg按照..，两个独立变量被赋值
        sum := 0
        return func(x int) int {
            sum += x
            return sum
        }
    }
    pos, neg := adder(), adder()
    for i := 0; i < 10; i++ {
        fmt.Println(
            pos(i),
            neg(-2*i),
        )
    }
    ```
### 认识
1. 数据构造
   - new：分配置零的内存的内建函数，并返回指针(地址)
        ```go
        type SyncedBuffer struct {}
        p := new(SyncedBuffer)              // type *SyncedBuffer
        ```
   - make：只用于创建slice、map和channel
1. GC
   - 认识：独立进程运行
   - 使用
     1. 手动触发：`runtime.GC()`，释放内存，但是性能短时间下降
     1. 析构方法：`runtime.SetFinalizer()`
        - 被GC时触发，由于可能任意时间被触发，因此一般只用于长期运行的程序中释放非内存资源
        - 会按依赖顺序执行