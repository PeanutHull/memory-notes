### 概念
1. 理解
   - 简洁，代码风格统一
   - goroutine跟channel，利于写出一个并行的程序
   - 便于在线的性能分析，以及堆栈分析
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
1. 数据类型
   - 基本类型
     1. uint uint8(byte) uint16 uint32 uint64 uintptr
     1. int int8 int16 int32(rune，代表一个Unicode码) int64
     1. float32 float64
     1. complex64 complex128
     1. string
     1. bool
   - 其他类型
     1. 零值：可以表现为0，false，""
   - 类型转换：T(v)，将值v转换为类型T
   - 注意：int/uint/uintptr受系统位数影响
1. var 变量
    ```go
    var i,j int = 1,2       // 初始化变量
    k := 3                  // :=简洁赋值，类型推导，只能在函数内使用
    ```
1. const：常量
    ```go
    const Pi = 3.14
    ```
1. func 函数
   - 定义
    ```go
    func add(x int, y int) int {
        return x + y
    }
    ```
   - 使用
     1. split(17)/hypot/compute：返回7和10
1. 流程控制
   - 判断
     1. if
        ```go
        if x < 0 {              // 如：if v := math.Pow(x, n); v < lim {}
            return 1
        } else {
            return 2
        }
        ```
     1. switch
        ```go
        switch os := runtime.GOOS; os {
            case "darwin":          // 匹配则跳过剩下的case
            case "linux":
            default:
        }
        ```
   - 循环
     1. for
        ```go
        sum := 0
        for i := 0; i < 10; i++ {
            sum += i
        }
        ```
     1. while
        ```go
        for sum < 1000 {
            sum += sum
        }
        ```
   - 延迟：defer，会延迟函数的执行直到上层函数返回。特点是所有的defer会压入栈中，并且先入后出
    ```go
    defer fmt.Println("world")
	fmt.Println("hello")
    ```
1. * 指针
   - 理解：指针保留了变量的内存地址，类型*T是指向类型T的值的指针，其零值是nil。与c不同go没有指针运算
        ```go
        var p *int      // 定义一个指针
        i := 42
        p = &i          // &生成指向其对象的指针
        fmt.Println(*p) // 通过指针p读取i
        *p = 21         // 通过指针p设置i
        ```
1. struct 结构体
   - 理解：字段的组合
    ```go
    type Vertex struct {
        X int
        Y int
    }
    Vertex{1, 2}    // 赋值
    Vertex{X: 1}    // Y:0 被省略
    v.X = 4         // 赋值
    v.X             // 访问
    ```
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
### 数据结构
1. array 数组
   - 理解：[n]T有n个类型为T的值的数组，不能改变长度
    ```go
    var a [2]string     // 定义
	a[0] = "Hello"
	a[1] = "World"      // 赋值
    a[0]                // 访问
    ```
1. slice 切片
   - 理解：一个slice会指向一个序列的值，并且包含了长度信息
       ```go
        // 定义
        s := []int
        s := []int{2, 3, 5, 7, 11, 13}
        s := make([]int, 5)                     // 5个0
        s := make([]int, 0, 5)                  // 0个元素，但是cap=5。cap即容量，返回的是数组切片分配的空间大小
        // 赋值
        s == nil                                // slice的默认值为nil，长度和容量都是0
        // 访问
        s[i]
        ```
   - 操作
     1. len(s)：长度
     1. append(s, 0)：新增
   - 二维切片
        ```go
        game := [][]string{                     // 定义
            []string{"a", "a", "a"},
            []string{"a", "a", "a"},
        }
        game[0][0] = "X"                        // 赋值
        // 切片
        s[1:4]                                  // 即第1到第3个，从0开始
        // 遍历
        for i, v := range pow {}                // 下标i，值v
        for i := range pow {}                   // 只需要下标
        for _, v := range pow {}                // 只需要值
        ```
1. map 映射
   - 理解：映射键到值
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
        v, ok = m[key]                          // 双赋值检测是否存在，ok为bool指示是否存在
        ```
   - 操作
     1. delete(m, key)：删除
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
1. goroutine：是go的轻量级线程
   - 使用
        ```go
        go say("world")
        ```
   - select：可以使线程等待
        ```go
        for {
            select {
            case c <- x:
            case <-quit:
            default:
            }
        }
        ```
1. channel：有类型的管道，可以用<-对其发送或者接收值，用来在线程间通信
   - 使用
        ```go
        ch := make(chan int)        // 使用前必须创建
        ch <- v                     // 将v送入channel ch
        v := <-ch                   // 从ch接收，并且赋值给v
        ```
   - 缓冲channel：向缓冲channel发送数据的时，只有缓冲区满时才会阻塞，当缓冲区为空的时候接收操作会阻塞
        ```go
        ch := make(chan int, 100)
        ```
   - 关闭：
        ```go
        c := make(chan int, 10)
        // 发送者可以close一个channel来表示再没有值会被发送
        close(c)
        // 接收者可以通过赋值语句的第二参数来测试channel是否被关闭，ok为false表示已经关闭
        v, ok := <-ch
        // 不断从channel接收值，直到它被关闭
        for i := range c {
            fmt.Println(i)
        }
        ```
1. sync.Mutex：保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
    ```go
    c.mux.Lock()
	c.v[key]++      // Lock 之后同一时刻只有一个goroutine能访问 c.v
	c.mux.Unlock()
    ```
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