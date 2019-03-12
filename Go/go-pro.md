1. 闭包
    ```go
    // 闭包
    func adder() func(int) int {   // 返回一个函数的计算结果，同时sum每次积累的不变，pos按照pos的节奏sum变，neg按照...，因为是两个独立的变量被赋值
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
