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
### 语法
1. package 包
   - 导出名：首字母大写的名称是被导出的，外界只能访问首字母大写的名称
   - 导入：import 
        ```go
        import "fmt"
        import "math"
        // 推荐下面的
        import (
            "fmt"
            "math"
        )
        ```
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
    // 函数作为返回值
    func compute(fn func(float64, float64) float64) float64 {
        return fn(3, 4)
    }
	hypot := func(x, y float64) float64 {
		return math.Sqrt(x + y)
	}
	hypot(5, 12)                                // 使用
    // 函数作为参数
    func compute(fn func(float64, float64) float64) float64 {
        return fn(3, 4)
    }
    compute(hypot)                              // 使用
    // 函数的闭包
    func adder() func(int) int {                // 返回一个函数的计算结果，同时sum每次积累的不变，pos按照pos的节奏sum变，neg按照...，因为是两个独立的变量被赋值
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
   - switch
    ```go
    switch os := runtime.GOOS; os {
	case "darwin":
        // 匹配则跳过剩下的case
	case "linux":
	default:
	}
    // 没有条件的switch，代替冗长的if-then-else
    switch {
	case t.Hour() < 12:
	case t.Hour() < 17:
	default:
	}
    ```
   - defer
    ```go
    // defer语句会延迟函数的执行直到上层函数返回。特点是所有的defer会压入栈中，并且先入后出
    defer fmt.Println("world")
	fmt.Println("hello")
    ```
1. \* 指针
   - 理解：指针保留了变量的内存地址，类型*T是指向类型T的值的指针，其零值是nil。与C不同go没有指针运算
   - 实例
    ```go
    var p *int      // 定义一个指针
    i := 42
    p = &i          // &生成指向其对象的指针
    fmt.Println(*p) // 通过指针p读取i
    *p = 21         // 通过指针p设置i
    ```
1. struct 结构体
   - 理解：字段的组合
   - 示例
    ```go
    type Vertex struct {
        X int
        Y int
    }
    Vertex{1, 2}    // 赋值
    Vertex{X: 1}    // Y:0 被省略
    v.X = 4         // 赋值
    v.X             // 访问
    v := Vertex{1, 2}
	p := &v
	p.X             // 指针访问
    // 在结构体上定义方法
    func (v *Vertex) Add() float64 {
	    return v.X + v.Y
    }
    v := &Vertex{3, 4}
    v.Abs()                 // 使用
    ```
1. array 数组
   - 理解：[n]T有n个类型为T的值的数组，不能改变长度
   - 示例
    ```go
    var a [2]string     // 定义
	a[0] = "Hello"
	a[1] = "World"      // 赋值
    a[0]                // 访问
    ```
1. slice 切片
   - 理解：一个slice会指向一个序列的值，并且包含了长度信息
   - 示例
    ```go
    s := []int{2, 3, 5, 7, 11, 13}          // 定义
    s := make([]int, 5)                     // 5个0
    s := make([]int, 0, 5)                  // 0个元素，但是cap=5。cap即容量，返回的是数组切片分配的空间大小
    s := []int
	s == nil                                // slice的默认值为nil，长度和容量都是0
    s[i]                                    // 访问
    fmt.Printf("s[%d] == %d\n", i, s[i])    // 打印
    len(s)                                  // 长度
    // 二维切片
    game := [][]string{                     // 定义
		[]string{"a", "a", "a"},
		[]string{"a", "a", "a"},
	}
    game[0][0] = "X"                        // 赋值
    // 对slice切片
    s[1:4]                                  // 即第1到第3个，从0开始
    // 新增
    append(s, 0)                            // 返回的是新增后的slice
    // 遍历
    for i, v := range pow {}                // 下标i，值v
    for i := range pow {}                   // 只需要下标
    for _, v := range pow {}                // 只需要值
    ```
1. map 映射
   - 理解：映射键到值
   - 示例
    ```go
    type Vertex struct {
        Lat, Long int
    }
    var m map[string]Vertex                 // 定义
	m = make(map[string]Vertex)             // 创建
    m["a"] = Vertex{                        // 创建后才能使用
		1, 2,
	}
    var m = map[string]Vertex{              // 赋值
        "a": {1, 2},
        "b": {3, 4},
    }
    m[key] = elem                           // 插入或修改
    elem = m[key]                           // 获取
    delete(m, key)                          // 删除
    v, ok = m[key]                          // 双赋值检测是否存在，ok为bool指示是否存在
    ```
### 面向对象
1. 特点
   - go没有类，可以在struct上定义方法
   - go可以在任意类型里定义方法，除了其他包的类型或基础类型
   - 型通过实现那些方法来实现接口。没有显式声明的必要，所以也就没有关键字“implements“。隐式接口解藕了实现接口的包和定义接口的包：互不依赖。因此，也就无需在每一个实现上增加新的接口名称，这样同时也鼓励了明确的接口定义
1. interface 接口
   - 理解：是由一组方法定义的集合
   - 示例
    ```go
    type Abser interface {
        Abs() float64
    }
    ```
1. 内建接口
   - Stringer
    ```go
    func (p Person) String() string {                                   // 改变了结构体输出时的样式
        return fmt.Sprintf("(name is %v) (%v years)", p.Name, p.Age)
    }
    a := Person{"Arthur Dent", 42}
    z := Person{"Zaphod Beeblebrox", 9001}
    fmt.Println(a, z)
    ```
   - error
### 并发
### 其他
1. IO包
   - Reader接口：go标准库包括了文件、网络连接、压缩、加密等实现
     1. 方法：func (T) Read(b []byte) (n int, err error)，用数据填充指定的字节slice，数据流结尾返回io.EOF错误
        ```go
        // 以每次8字节的速度读取
        r := strings.NewReader("Hello, Reader!")
        b := make([]byte, 8)
        for {
            n, err := r.Read(b)
            fmt.Printf("n = %v err = %v b = %v\n", n, err, b)
            fmt.Printf("b[:n] = %q\n", b[:n])
            if err == io.EOF {
                break
            }
        }
        ```
1. Http包
   - web服务器
    ```go
    var h Hello
	err := http.ListenAndServe("localhost:4000", h)
	if err != nil {
		log.Fatal(err)
	}
    ```
1. Image包
    ```go
    m := image.NewRGBA(image.Rect(0, 0, 100, 100))
	m.Bounds()
	m.At(0, 0).RGBA()
    ```
1. 错误：使用error值表示错误状态，error为nil时表示成功；非nil表示错误
    ```go
    i, err := strconv.Atoi("42")
    if err != nil {
        fmt.Printf("couldn't convert number: %v\n", err)
        return
    }
    fmt.Println("Converted integer:", i)
    ```