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
