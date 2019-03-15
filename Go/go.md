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
   - 是静态类型的语言，类型系统没有层级，不需要在定义类型之间的关系上花费时间，这样感觉起来比典型的面向对象语言更轻量级
   - 缺少框架、软件包管理不完善
1. 特点
   - 性能、简单
   - 每个Go程序都是由包组成的
   - 结合了解释型语言的游刃有余，动态类型语言的开发效率，以及静态类型的安全性。它也打算成为现代的，支持网络与多核计算的语言。要满足这些目标，需要解决一些语言上的问题：一个富有表达能力但轻量级的类型系统，并发与垃圾回收机制，严格的依赖规范等
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
   - 注释c风格/* */、c++风格//
   - 每行可以不加分号
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
1. 运算符
   - + 字符串连接符
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
1. 包
   - 导出名：package指定，首字母大写的名称是被导出的，外界只能访问首字母大写的名称。可执行命令必须使用package main
   - 导入：import，用其导出的名称来调用，包名为导入路径的最后一个元素
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
   - 认识：用error值表示错误状态，error是内在接口，为nil时表示成功；非nil表示错误
    ```go
    i, err := strconv.Atoi("42")
    if err != nil {}
    ```
   - error接口：fmt包处理error时会调用Error方法，使用`return 0, errors.New("math: square root of negative number")`
   - 错误处理：Go在错误处理上采用了与C类似的检查返回值的方式，而不是其他多数主流语言采用的异常方式，导致错误处理代码的冗余
### 数据结构
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
1. 类：go没有类，可以在任意类型里定义方法，除了基础类型或其他包的类型。方法接收者出现在func和方法名之间的参数中
    ```go
    func (v *Vertex) Abs() float64 {}           // 接收者为指针，大结构体的话更有效率
    v := &Vertex{3, 4}
    v.Abs()
    // 如
    type MyFloat float64
    func (f MyFloat) Abs() float64 {}
    f := MyFloat()
    f.Abs()
    ```
1. interface 接口
   - 理解：接口类型是一组方法定义的集合
        ```go
        type Abser interface {
            Abs() float64
        }

        type MyFloat float64
        f := MyFloat()

        var a Abser
        a = f                       // a MyFloat实现了Abser
        ```
   - 隐式接口：类通过实现那些方法来实现接口。这就没有了显式声明的必要和关键字implements。解藕了实现接口的包和定义接口的包，因此无需在每个实现上增加新接口，也鼓励了明确的接口定义
1. 内建接口
   - Stringer
    ```go
    func (p Person) String() string {                                   // 改变了结构体输出时的样式，Stringer是一个用字符串描述自己的类型
        return fmt.Sprintf("(name is %v) (%v years)", p.Name, p.Age)
    }
    a := Person{"Arthur Dent", 42}
    z := Person{"Zaphod Beeblebrox", 9001}
    fmt.Println(a, z)
    ```
### 多线程
1. goroutine：go的轻量级线程
    ```go
    go say("world")
    ```
1. channel
   - 理解：有类型的管道，用<-发送或接收值，用来在线程间通信。默认另一端准备好之前发送和接收都会阻塞，使得goroutine可以在没有明确的锁或竞态变量的情况下同步
        ```go
        ch := make(chan int)        // 和map、slice一样，使用前必须创建
        ch <- v                     // 将v送入channel ch
        v := <-ch                   // 从ch接收，并且赋值给v
        ```
   - 缓冲：向缓冲channel发送数据的时，只有缓冲区满时才会阻塞，当缓冲区清空的时候接收操作会阻塞
        ```go
        ch := make(chan int, 100)
        ```
   - 关闭
        ```go
        c := make(chan int, 10)
        // 发送者close channel，表示再没有值会被发送，只有发送者才能关闭channel
        close(c)
        // 接收者通过赋值语句的第二参数来测试channel是否被关闭，ok为false表示已经关闭
        v, ok := <-ch
        // 不断从channel接收值，直到它被关闭
        for i := range c {
            fmt.Println(i)
        }
        ```
   - select：可以使线程在多个通讯操作上等待，select会阻塞直到条件分支中的某个可以继续执行。当多个都准备好的时候，会随机选择一个
        ```go
        select {
            case c <- x:
            case <-quit:
            case <- time.After(5 * time.Second):        // 设置超时
            default:                                    // 其他分支没准备好的时候default分支会被执行，可用于非阻塞的发送或者接收
        }
        ```
   - 互斥：sync.Mutex，保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
        ```go
        c.mux.Lock()
        c.v[key]++      // Lock 之后同一时刻只有一个goroutine能访问 c.v
        c.mux.Unlock()
        ```
### 包
1. 时间
   - time
     1. `time.Now()`
1. io包
   - 目录：Mkdir/MkdirAll/Remove/RemoveAll：`os.Mkdir("a", 0777)`
   - 文件
     1. Create/NewFile
     1. Open/OpenFile
     1. Read/ReadAt
     1. Write/WriteString
     1. Remove
   - Reader接口：go的标准库，包括了文件、网络连接、压缩、加密等实现
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
1. http包、log包
   - 核心功能
     1. Conn：使用goroutines保证请求独立性
     1. ServeMux：数据路由
   - web服务器
        ```go
        import (
            "log"
            "net/http"
        )

        type Hello struct{}
        var h Hello
        func (h Hello) ServeHTTP(w http.ResponseWriter,r *http.Request) {
            r.ParseForm()                           // 解析参数
            // form
            r.Form
            r.Form["id"]
            // url
            r.URL.Path
            r.URL.Scheme
            // cookis
            cookie := r.Cookie("id")
            for _, cookie := range r.Cookies() {
                fmt.Fprint(w, cookie.Name)
            }
            // echo
            fmt.Fprintf(w, "Hello!")
        }

        // cookis
        expiration := time.Now()
        expiration = expiration.AddDate(1, 0, 0)
        cookie := http.Cookie{Name: "id", Value: "astaxie", Expires: expiration}
        http.SetCookie(w, &cookie)

        err := http.ListenAndServe("localhost:4000", h)
        if err != nil {
            log.Fatal(err)
        }
        ```
   - ip：`addr := net.ParseIP()`
1. image包
    ```go
    m := image.NewRGBA(image.Rect(0, 0, 100, 100))
	m.Bounds()
	m.At(0, 0).RGBA()
    ```
1. math
   - `math.Nextafter(2, 3)`
   - `rand.Intn(10)`："math/rand"
1. runtime
   - 多线程
     1. Goexit
     1. Gosched
     1. NumCPU
     1. NumGoroutine
     1. GOMAXPROCS
### 应用
1. 工作空间
   - src
   - pkg：包对象
   - bin：可执行命令
1. 文本处理
   - string：分割、连接、转换等
     1. strings包
        - 查找：`strings.Index/Contains(src))`
        - 修改：`strings.Join/Trim/TrimSpace/Fields/Repeat/Replace/Split(src))`
     1. strconv包
        ```go
        strconv.AppendInt/AppendBool/AppendQuote/AppendQuoteRune()         // 转换为字符串后添加到字节数组中
        strconv.FormatBool/FormatInt/FormatUint/FormatFloat/Itoa()         // 转换为字符串
        strconv.ParseBool/ParseInt/ParseUint/ParseFloat/Atoi()             // 字符串转换为其他类型
        ```
   - reg：regexp包，实现RE2标准，实现搜索、替换、解析，strings包优先
        ```go
        regexp.MatchString("^[0-9]+$", os.Args[1])
        regexp.Compile("\\<script[\\S\\s]+?\\</script\\>")
        ```
   - xml：encoding/xml包，读取Unmarshal，生成Marshal/MarshalIndent
   - json：encoding/json包，读取Unmarshal，生成Marshal，Javascript Object Notation，具有自我描述性且易于阅读
        ```go
        // 已知结构的
        type Server struct {
            ServerName string
            ServerIP   string
        }
        type Serverslice struct {
            Servers []Server
        }

        var s Serverslice
        str := `{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`
        json.Unmarshal([]byte(str), &s)
        fmt.Println(s)
        // 未知结构，interface和type assert配合
        str := `{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`
        var f interface{}
        err := json.Unmarshal(str, &f)
        m := f.(map[string]interface{})         // 断言形式
        for k, v := range m {
            switch vv := v.(type) {
            case string:
            case int:
            case float64:
                fmt.Println(k,"is float64",vv)
            case []interface{}:
                fmt.Println(k, "is an array:")
                for i, u := range vv {
                    fmt.Println(i, u)
                }
            default:
                fmt.Println(k, "is of a type I don't know how to handle")
            }
        }
        // 第三方simplejson包
        js, err := NewJson([]byte(`{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`))
        arr, _ := js.Get("servers").Get("name").Array()
        i, _ := js.Get("servers").Get("name").Int()
        ms := js.Get("servers").Get("name").MustString()
        ```
   - 命令行：`os.Args/os.Args[1]`
1. 加解密
   - base64
     1. `base64.StdEncoding.EncodeToString(src)`
     1. `base64.StdEncoding.DecodeString(string(src))`
   - aes：`aes.NewCipher`，crypto.des/aes、crypto/cipher
   - sha：`h := sha256.New()`，crypto/sha256/sha1
   - md5：`h := md5.New()`，crypto/md5
1. 数据库
   - database/sql：接口，无官方数据库驱动，为驱动定义了标准接口，有sql.Register、driver.Driver、driver.Conn等
   - MySQL：github的go-sql-driver/mysql，beego的orm
   - NOSQL：github的garyburd/redigo
1. web服务
   - Socket：Socket数据传输是Unix特殊的I/O，分为流式Socket(SOCK_STREAM，面向连接，TCP)、数据报式Socket(SOCK_DGRAM，无连接，UDP)
     1. tcp
        ```go
        // client
        tcpAddr := net.ResolveTCPAddr("tcp4", service)
        conn := net.DialTCP("tcp", nil, tcpAddr)
        result := ioutil.ReadAll(conn)
        // server，单任务
        tcpAddr := net.ResolveTCPAddr("tcp4", service)
        listener := net.ListenTCP("tcp", tcpAddr)
        for {
            conn := listener.Accept()
            conn.Write()
            conn.Close()
        }
        // server，多任务
        tcpAddr := net.ResolveTCPAddr("tcp4", service)
        listener := net.ListenTCP("tcp", tcpAddr)
        for {
            conn := listener.Accept()
            go handleClient(conn)
        }

        func handleClient(conn net.Conn) {
            defer conn.Close()
            // 超时断开
            conn.SetReadDeadline(time.Now().Add(2 * time.Minute)) // set 2 minutes timeout
            conn.Write()
        }
        ```
     1. udp
        ```go
        // client
        udpAddr := net.ResolveUDPAddr("udp4", service)
        conn := net.DialUDP("udp", nil, udpAddr)
        conn.Write()
        var buf [512]byte
        n := conn.Read(buf[0:])
        // server，多任务
        udpAddr := net.ResolveUDPAddr("udp4", ":1200")
        conn := net.ListenUDP("udp", udpAddr)
        for {
            var buf [512]byte
            _, addr, err := conn.ReadFromUDP(buf[0:])
            conn.WriteToUDP([]byte(), addr)
        }
        ```
     1. 控制连接：DialTimeout、SetReadDeadline、SetWriteDeadline、SetKeepAlive
   - WebSocket：go.net子包有，`golang.org/x/net/websocket`
   - RPC：标准包提供，支持三个级别：TCP、HTTP、JSONRPC，只支持go内部，使用Gob编码
     1. 访问条件：`func (t *T) MethodName(argType T1, replyType *T2) error`，T/T1/T2必须能被encoding/gob包编解码
        - 函数必须是导出的(首字母大写)
        - 必须有两个导出类型的参数，第一个参数是接收的参数，第二个参数是返回给客户端的参数，第二个参数必须是指针类型的
        - 函数要有一个返回值error
     1. http协议
        ```go
        // client
        client := rpc.DialHTTP("tcp", "127.0.0.1:1234")
        // Synchronous call
        var reply int
        err = client.Call("Xxx.func", args, &reply)

        // server
        type Xxx int
        xxx := new(Xxx)
        rpc.Register(xxx)
        rpc.HandleHTTP()                            // 注册到了HTTP协议上
        err := http.ListenAndServe(":1234", nil)
        ```
     1. tcp协议
        ```go
        // client
        client, err := rpc.Dial("tcp", "127.0.0.1")
        // Synchronous call
        var reply int
        err = client.Call("Xxx.Multiply", args, &reply)

        // server
        xxx := new(Xxx)
        rpc.Register(xxx)
        tcpAddr := net.ResolveTCPAddr("tcp", ":1234")
        listener := net.ListenTCP("tcp", tcpAddr)
        for {
            conn := listener.Accept()                       // 需要自己控制连接
            rpc.ServeConn(conn)                             // 有连接后，把连接交给rpc来处理
	    }
        ```
     1. JSON RPC：使用json编码，不是gob
        ```go
        // client
        client, err := jsonrpc.Dial("tcp", service)
        // Synchronous call
        args := Args{17, 8}
        var reply int
        err = client.Call("Xxx.Multiply", args, &reply)

        // server
        xxx := new(Xxx)
        rpc.Register(xxx)
        tcpAddr := net.ResolveTCPAddr("tcp", ":1234")
        listener := net.ListenTCP("tcp", tcpAddr)
        for {
            conn := listener.Accept()
            jsonrpc.ServeConn(conn)
        }
        ```
   - SOAP RPC：不支持
1. 国际化
   - 地区：`i18n.SetLocale("zh-CN")`
   - 资源：展示
        ```go
        locales = make(map[string]map[string]string, 2)
        en := make(map[string]string, 10)
        cn := make(map[string]string, 10)

        en["pea"] = "pea"
	    cn["pea"] = "豌豆"
        locales["en"] = en
        locales["zh-CN"] = cn
        lang := "zh-CN"

        fmt.Println(msg(lang, "pea"))
        ```
   - 日期和时间：格式、时区
        ```go
        en["time_zone"]="America/Chicago"
        cn["time_zone"]="Asia/Shanghai"

        loc,_ := time.LoadLocation(msg(lang,"time_zone"))
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
   - 14年1.4版本
1. wiki
   - int/uint/uintptr受系统位数影响
1. 测试：go test和testing包构成
1. 数据构造
   - new：分配置零的内存的内建函数，并返回指针(地址)
        ```go
        type SyncedBuffer struct {}
        p := new(SyncedBuffer)              // type *SyncedBuffer
        ```
   - make：只用于创建slice、map和channel
