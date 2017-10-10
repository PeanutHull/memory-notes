### 概念
1. 理解：
1. 特点
   - 每个Go程序都是由包组成的
1. 示例
    ```go
    package main
    import "fmt"
    func main() {
        fmt.Println("Hello, 世界")
    }
    ```
### 组成
1. 数据类型
   - 基本类型
     1. uint uint8(byte) uint16 uint32 uint64 uintptr
     1. int  int8  int16  int32(rune，代表一个Unicode码)  int64
     1. float32 float64
     1. complex64 complex128
     1. string
     1. bool
   - 其他类型
     1. 零值：可以表现为0，false，""
   - 类型转换
     1. 表现：T(v)，将值v转换为类型T
     1. 使用
        ```go
        i := 42
        f := float64(i)
        // 即
        var i int = 42
        var f float64 = float64(i)
        // 类型推导，差不多隐式转换
        i := 42 // int
        f := 3.142 // float64
        ```
   - 注意：int，uint和uintptr受系统位数影响
1. package 包
   - 导出名：首字母大写的名称是被导出的，外界只能访问首字母大写的名称
1. import 导入
    ```go
    import "fmt"
    import "math"
    // 推荐下面的
    import (
        "fmt"
        "math"
    )
    ```
1. var 变量
    ```go
    var i,j int = 1,2 // 初始化变量
    k := 3 // :=简洁赋值，只能在函数内使用
    ```
1. const 常量
    ```go
    const Pi = 3.14
    // 数值常量，表示高精度的值
    const (
        Big   = 1 << 100
        Small = Big >> 99
    )
    ```
1. func 函数
    ```go
    func add(x int, y int) int {
        return x + y
    }
    // 缩写参数类型，将类型放到最后
    func add(x, y int) int {
        return x + y
    }
    // 可以返回任意数量返回值
    func swap(x, y string) (string, string) {
        return y, x
    }
    a, b := swap("hello", "world")
    // 命名返回值，指定返回值
    func split(sum int) (x, y int) {
        x = sum * 4 / 9
        y = sum - x
        return
    }
    split(17) // 返回7和10
    ```
1. 流程控制
   - for
    ```go
    sum := 0
	for i := 0; i < 10; i++ {
		sum += i
	}
    // 或者
    for ; sum < 1000; {
		sum += sum
	}
    // while形式
    for sum < 1000 {
		sum += sum
	}
    // 死循环
    for {
	}
    ```
   - if
    ```go
    if x < 0 {
		return 1
	} else {
		return 2
	}
    // 中间放一个简单语句搞一下
    if v := math.Pow(x, n); v < lim {
		return v
	}
	return lim
    ```