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
1. goroutine
   - 每个goroutine stack的size默认设置为2k，可以轻易创建几十万goroutine不用担心内存耗尽等问题
   - scheduler：go的调度器要将众多goroutine放在有限的线程上去调度执行。使用M:N的G-P-M线程调度模型
   - sysmon：用于监控的线程，改变goroutine的抢占标志位，goroutine下一次调用时runtime可以将其抢占
     1. 释放闲置超过5分钟的span物理内存
     1. 如果超过2分钟没有垃圾回收，强制执行
     1. 将长时间未处理的netpoll结果添加到任务队列
     1. 向长时间运行的G任务发出抢占调度
     1. 收回因syscall长时间阻塞的P