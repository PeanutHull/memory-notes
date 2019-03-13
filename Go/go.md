### 概念
1. 理解：全称golang，快速、静态强类型、编译型、具有垃圾回收的开源语言，感觉却像动态类型的解释型语言
   - 简洁清晰高效
   - 并发机制/并发编程，goroutine跟channel，有效利用多核和网络
   - go的机器码迅速，可直接编译成机器码，支持跨平台编译
   - 方便的自动垃圾回收
   - 强大的运行时反射机制
   - 便于在线的性能分析，以及堆栈分析
   - 丰富的标准库支持、强大的工具、
   - 丰富的内置类型支持，支持函数多返回值、匿名函数和闭包、类型和接口、反射
   - 能与c语言交互
   - 缺少框架、软件包管理不完善
1. 特点
   - 每个Go程序都是由包组成的
1. 用途：
   - 服务器编程：处理日志
   - 分布式系统：数据库代理器
   - 网络编程：Web应用、api应用
   - 内存数据库：groupcache、couchbase
   - 云平台
1. 示例
    ```go
    package main

    import "fmt"

    func main() {
        fmt.Println("Hello, 世界\n")
    }
    ```
### 语法
1. 语法
   - 函数外的每个语句都必须以关键字(var/func/...)开始
1. 数据类型
   - 基本
     1. bool
     1. string
     1. int int8 int16 int32(rune，代表一个Unicode码) int64
     1. uint uint8(byte) uint16 uint32 uint64 uintptr：位
     1. float32 float64
     1. complex64 complex128
   - 其他
     1. 零值：无初始化时，可以表现为0，false，""
   - 特点
     1. 类型推导：不指定其类型时，由右值推导得出
     1. 类型转换：T(v)，将值v转换为类型T，不同类型相互转换的时候需要显式转换
1. 变量：var :=
    ```go
    var i,j int = 1,2       // 初始化变量
    var i,j = 1,true        // 使用表达式，可省略类型
    k := 3                  // 短声明、类型推导：:=，只能在函数内使用
    ```
1. 常量：const，可以是字符、string、bool或数字类型
    ```go
    const Pi = 3.14
    ```
1. func 函数
   - 定义
    ```go
    func add(x int, y int) int {
        return x + y
    }
    // 函数值
    hypot := func(x, y int) int {}
    ```
   - 使用
     1. split(17)/hypot/compute：返回7和10
1. 流程控制
   - 判断：不能使用()
     1. if
        ```go
        if x < 0 {
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
        case f():
        default:
        }
        ```
   - 循环：不能使用()
     1. for
        ```go
        sum := 0
        for i := 0; i < 10; i++ {
            sum += i
        }
        ```
     1. while：for代替，没有分号
        ```go
        for sum < 1000 {
            sum += sum
        }
        ```
   - 延迟：defer，会延迟函数的执行直到上层函数返回。所有的defer会压入栈中，并且先入后出
    ```go
    defer fmt.Println("world")
	fmt.Println("hello")
    ```
1. * 指针
   - 理解：保留了变量的内存地址，类型*T是指向类型T的值的指针，其零值是nil，即间接引用。与c不同go没有指针运算
        ```go
        var p *int      // 定义一个指针
        i := 42
        p = &i          // 生成指向其作用对象的指针
        *p              // 读取i
        *p = 21         // 设置i
        ```
1. struct 结构体
   - 理解：字段的组合
    ```go
    type vertex struct {
        X int
        Y int
    }
    vertex{1, 2}        // 赋值
    vertex{X: 1}        // Y:0 被省略
    Vertex{}            // X:0 和 Y:0 被忽略
    p = &Vertex{1, 2}   // 类型为 *Vertex
    v.X                 // 访问
    v.X = 4             // 赋值
    ```
1. 包
   - 导出名：package指定，首字母大写的名称是被导出的，外界只能访问首字母大写的名称
   - 导入：import，用其导出的名称来调用
        ```go
        import "fmt"
        import "math"
        // 推荐下面的
        import (
            "fmt"
            "math"
            "math/rand"         // /导入某一个包
        )
        ```
1. 错误
   - 认识：使用error值表示错误状态，error为nil时表示成功；非nil表示错误
    ```go
    i, err := strconv.Atoi("42")
    if err != nil {
        fmt.Printf("couldn't convert number: %v\n", err)
        return
    }
    fmt.Println("Converted integer:", i)
    ```
### 数据结构
1. array 数组
   - 理解：[n]T有n个类型为T的值的数组，不能改变长度
    ```go
    // 定义
    var a [2]string
    a[0]                // 访问
    a[1] = "World"      // 赋值
    ```
1. slice 切片
   - 理解：指向一个序列的值，包含了长度信息
       ```go
        // 定义/赋值
        s := []int                              // slice的零值是nil，长度和容量是0
        s := []int{2, 3, 5, 7, 11, 13}
        // 构造slice，分配一个零长度的数组并且返回一个slice指向这个数组
        s := make([]int, 5)                     // 5个0的元素
        s := make([]int, 0, 5)                  // 0个元素，但是cap=5。cap即容量，返回的是数组切片分配的空间大小
        // 访问
        s[i]
        // 遍历，也适用于map
        for i, v := range pow {}                // 下标i，值v
        for i := range pow {}                   // 只需要下标
        for _, v := range pow {}                // 只需要值，忽略下标
        // 赋值
        s == nil                                // slice的默认值为nil，长度和容量都是0
        // 添加
        s = append(s, 2, 3, 4)                  // 添加所有的T类型，s的底层数组太小不够容纳自动分配更大的数组
        // 切片
        s[1:4]                                  // 即第1到第3个(后边为n-1)，从0开始
        s[:3]
        s[4:]
        s = s[:cap(s)]                          // len(s)=5, cap(s)=5
        s = s[1:]                               // len(s)=4, cap(s)=4
        ```
   - 操作
     1. len(s)：长度
     1. cap(s)：容量
     1. append(s, 0)：新增
   - 二维slice
        ```go
        game := [][]string{                     // 定义
            []string{"a", "a", "a"},
            []string{"a", "a", "a"},
        }
        game[0][0] = "X"                        // 赋值
        ```
1. map 映射
   - 理解：映射键到值
        ```go
        type Vertex struct {
            Lat, Long int
        }
        // 定义
        var m map[string]Vertex
        // 创建
        m = make(map[string]Vertex)

        // 定义、赋值
        var m = map[string]Vertex{
            "a": {1, 2},
            "b": {3, 4},
            "c": vertex{
                5, 6,
            },
        }

        // 获取
        elem = m["key"]
        // 插入或修改
        m["a"] = Vertex{
            1, 2,
        }
        // 删除
        delete(m, "key")
        // 双赋值检测是否存在，ok为bool指示是否存在
        v, ok = m["key"]
        ```
   - 操作
     1. delete(m, key)：删除
### 面向对象
1. 特点
   - go没有类，可以在struct上定义方法
   - go可以在任意类型里定义方法，除了其他包的类型或基础类型
   - 类通过实现那些方法来实现接口。没有显式声明的必要，没有关键字“implements“。隐式接口解藕了实现接口的包和定义接口的包：互不依赖。因此，也就无需在每一个实现上增加新的接口名称，这样同时也鼓励了明确的接口定义
1. interface 接口
   - 理解：由一组方法定义的集合
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
### 包
1. 时间
   - time
     1. `time.Now()`
1. io包
   - Reader接口：go标准库包括了文件、网络连接、压缩、加密等实现
     1. 方法：`func (T) Read(b []byte) (n int, err error)`，数据填充指定字节的slice，数据流结尾返回io.EOF错误
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
1. http包
   - web服务器
        ```go
        var h Hello
        err := http.ListenAndServe("localhost:4000", h)
        if err != nil {
            log.Fatal(err)
        }
        ```
1. image包
    ```go
    m := image.NewRGBA(image.Rect(0, 0, 100, 100))
	m.Bounds()
	m.At(0, 0).RGBA()
    ```
1. math
   - `math.Nextafter(2, 3)`
   - `rand.Intn(10)`："math/rand"
### 多线程
1. goroutine
   - 理解：go的轻量级线程
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
1. channel
   - 理解：有类型的管道，可以用<-对其发送或者接收值，用来在线程间通信
        ```go
        ch := make(chan int)        // 使用前必须创建
        ch <- v                     // 将v送入channel ch
        v := <-ch                   // 从ch接收，并且赋值给v
        ```
   - 缓冲：向缓冲channel发送数据的时，只有缓冲区满时才会阻塞，当缓冲区为空的时候接收操作会阻塞
        ```go
        ch := make(chan int, 100)
        ```
   - 关闭
        ```go
        c := make(chan int, 10)
        // 发送者close channel，表示再没有值会被发送
        close(c)
        // 接收者通过赋值语句的第二参数来测试channel是否被关闭，ok为false表示已经关闭
        v, ok := <-ch
        // 不断从channel接收值，直到它被关闭
        for i := range c {
            fmt.Println(i)
        }
        ```
   - 互斥：sync.Mutex，保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
        ```go
        c.mux.Lock()
        c.v[key]++      // Lock 之后同一时刻只有一个goroutine能访问 c.v
        c.mux.Unlock()
        ```
### 运维
1. cli
   - 基础
     1. `go help`
     1. `go version`
   - 编写
     1. `go env`：查看当前go的环境变量
     1. `go fmt`：格式化代码文件，`gofmt -w src`格式化全部
     1. `go doc`：用于查看文档
     1. `go test`：自动读取源码目录下*_test.go文件，生成并运行测试用的可执行文件
     1. `go fix`：转换老版本的代码到新版本
   - 调试
     1. `go bug`：调试
     1. `go tool`：pprof性能检查工具，cgo跟C语言和GO语言有关的命令
     1. `go vet`：静态检查工具，项目快完成时进行进行优化
   - 运行和编译
     1. `go run hello.go`
     1. `go build`：用于测试编译，普通包不产生任何文件，main包生成可执行文件
     1. `go install`：生成可执行文件，结果移到$GOPATH/pkg(bin)
     1. `go clean`：移除当前源码包里面编译生成的文件
   - 依赖
     1. `go get`：动态获取远程代码包，下载和install
     1. `go list`：查看安装的package
### wiki
1. 历史
   - 07年开发
   - 09年开源
   - 12年1.0稳定版本
1. wiki
   - int/uint/uintptr受系统位数影响
