### go
1. 认识：全称golang，快速、静态强类型、编译型、具有垃圾回收的开源语言，感觉却像动态类型的解释型语言
   - 简洁清晰高效
   - 并发机制/并发编程，goroutine跟channel，有效利用多核和网络，并发而生
   - go的机器码迅速，可直接编译成机器码，支持跨平台编译
   - 方便的自动垃圾回收
   - 强大的运行时反射机制
   - 便于在线的性能分析，以及堆栈分析
   - 丰富的标准库支持、强大的工具类库
   - 丰富的内置类型支持，支持函数多返回值、匿名函数和闭包、类型和接口、反射
   - 能与c语言交互
   - 是静态类型的语言，类型系统没有层级，不需要在定义类型之间的关系上花费时间，这样感觉起来比典型的面向对象语言更轻量级
   - 缺少框架、软件包管理不完善
   - go语言灵魂是：并发计算、共享内存；灵活性不如php，不太适合写复杂的业务逻辑。促销这边有两个逻辑适合用Go实现
1. 特点
   - 性能、简单
   - 每个Go程序都是由包组成的
   - 结合了解释型语言的游刃有余，动态类型语言的开发效率，以及静态类型的安全性。它也打算成为现代的，支持网络与多核计算的语言。要满足这些目标，需要解决一些语言上的问题：一个富有表达能力但轻量级的类型系统，并发与垃圾回收机制，严格的依赖规范等
1. 用途
   - 服务器编程：处理日志
   - 分布式系统：数据库代理器
   - 网络编程：Web应用、api应用
   - 内存数据库：groupcache、couchbase
   - 云平台
1. 示例
    ```go
    package main

    import "fmt"

    const name string = "aa"

    var a string = "1"

    type aInt int                           // 一般类型声明，相当于类型别名

    type aStruct struct {
    }

    type Ia interface{
    }

    func aFunc() {

    }

    func main() {
        fmt.Println("Hello, 世界\n")
    }
    ```
### 语法
1. 语法
   - 函数外的每个语句都必须以关键字(var/func/...)开始
   - main是入口函数，程序必须以package开头
   - 注释：多行/* */、单行//
   - 作用域：首字母大小写来区分，就是public、private那些，首字母大写的名称是被导出的，他包只能读取首字母大写的变量
   - 每行可以不加分号
   - 语法糖
     1. ...：可变参数
     1. :=：声明、赋值、类型推断
1. 数据类型
   - 意义：将数据分为所需内存不同的，充分利用内存
   - 基本
     1. 布尔：bool，只能是true、false
     1. 字符串：string，统一编码为utf-8，16byte
     1. 数值
        - 有符号整形：int8 int16 int32 int64，数字是位数，如int32为前后20亿
        - 无符号整形：uint8 uint16 uint32 uint64
        - 浮点型：float32 float64
        - 复数：complex64 complex128，即实部和虚部
     1. 其他
        - int/uint：32位cpu为4byte，64位为8byte
        - byte：类似uint8
        - rune：类似int32，代表一个Unicode码
        - uintptr：位，无符号整型，用于存放一个指针
        - 引用：8byte
   - 派生
     1. array
     1. slice
     1. map
     1. pointer：指针
     1. struct
     1. func
     1. interface
     1. chan
   - 特点
     1. 类型零值：变量无初始化时的默认值，可以表现为0，false，""
     1. 类型推导：不指定其类型时，由右值推导得出
     1. 类型别名：`type aInt int`
     1. 类型转换：T(v)，将值v转换为类型T，不同类型相互转换的时候需要显式转换
     1. 不像c，不支持地址的直接转换，只能用unsafe.Pointer()
   - 用法
     1. 字节大小：`unsafe.Sizeof()`
     1. 数据类型：`reflect.TypeOf()`
1. 运算符
   - + 字符串连接符
   - 算术：++、--、+-*/%
   - 关系：==、!=、>、<、>=、<=
   - 逻辑：&&、||、!
   - 按位：&、|、^、<<、>>
   - 赋值：=、+=等
1. array：数组
   - 理解：[n]T有n个类型为T的值的数组，不能改变长度
    ```go
    // 定义
    var a [2]string
    a[0]                // 访问
    a[1] = "World"      // 赋值
    ```
1. slice 切片，s []byte为24byte，s [1024]byte为1024byte
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
   - 理解：键值对，key没有顺序，key唯一
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
            "c": vertex{5, 6},
        }

        // 获取
        m["key"]
        // 插入或修改
        m["a"] = Vertex{1, 2}
        // 删除
        delete(m, "key")
        // 双赋值检测是否存在，ok为bool指示是否存在
        v, ok = m["key"]
        ```
   - 操作
     1. delete(m, key)：删除
1. 变量
   - 认识：var或者:=
    ```go
    var i,j int = 1,2       // 声明、赋值
    var i,j = 1,true
    var (                   // 多个进行
        i int = 1
        j float32
    )
    k := 3                  // 短声明、类型推导：:=，只能在函数内使用
    ```
   - _：特殊变量，类似黑洞
   - 变量类型转换：必须是显式的，只能发生在两种兼容的类型之间，如int和bool不可以。`a := int32(b)`
1. 常量
   - 认识：const，只能是string、bool、数字类型，自定义函数操作常量会报错，只能内置函数操作
    ```go
    const Pi = 3.14
    const i,j = 1,true
    const (
        a int = 1
        b int = 1
    )
    ```
   - iota：特殊常量，iota在const关键字出现时将被重置为0，const中每新增一行常量声明则+1，`const a = iota`
     1. 跳值使用法
        ```go
        const (
            a = iota
            _ = iota        // 跳过了，b为3，中间不想有其他常量
            b = iota
        )
        ```
     1. 插队使用法
        ```go
        const (
            a = iota
            b = 1           // 插队了
            c = iota
        )
        ```
     1. 表达式隐式使用法
        ```go
        const (
            a,b = iota, iota+3
            c,d             // c,d分别为1,4，隐式引用了上一个
            c = iota
        )
        ```
     1. 单行使用法：`const a,b = iota, iota+3`
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
     1. switch：还可用于type-switch来判断某个interface变量的实际变量类型
        ```go
        switch os := runtime.GOOS; os {
        case "darwin":          // 匹配则跳过剩下的case
            return 1
        case "linux":
            return 1
        case f():
            return 1
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
        // foreach
        a := []string{"a","b"};
        for key,value := range a{}
        for _,value := range a{}
        // 无限循环
        for {}
        ```
     1. while：for代替，没有分号
        ```go
        for sum < 1000 {
            sum += sum
        }
        ```
     1. range：后边跟一个可循环的，自动类型推断
   - 跳转：goto
    ```go
    goto one
    one:
    // 无限循环
    one:
    goto one
    ```
   - 延迟：defer，会延迟函数的执行直到上层函数返回。所有的defer会压入栈中，并且先入后出
    ```go
    defer fmt.Println("world")
	fmt.Println("hello")
    ```
1. func 函数
   - 定义
    ```go
    func add(x int, y int) int {            // 参数类型，返回值类型
        return x + y
    }
    // 函数值
    hypot := func(x, y int) int {}
    func add(value...int) {                 // 可变参数，value是形参名称，类型统一
        for _,v := range value {
        }
    }
    ```
   - 使用
     1. split(17)/hypot/compute：返回7和10
   - 内建方法
     1. make
        - 认识：可以创建slice、map、chan三种类型，返回引用类型，即让帮忙将数据初始化好
        - 使用
            ```go
            // slice
            mSlice := make([]string, 3)
            // map
            mMap := make(map[int]string)
            // chan
            mChan := make(chan int, 3)
            ```
     1. new
        - 认识：传入的内存置零，返回传入类型的指针
        - 使用
            ```go
            // slice
            mSlice := make([]string, 3)
            // map
            mMap := new(map[int]string)
            // chan
            mChan := make(chan int, 3)
            ```
     1. append、copy：对slice进行操作，`mSlice = append(mSlice, "aa")`，`copy(Dst, Src)`，append会预判多加长度，copy只操作Dst原有长度范围的数据
     1. delete：对map进行操作，`delete(mMap, xxKey)`
     1. len、cap、close
        - len：长度，string、array、slice、map、chan
        - cap：容量，slice、array、chan
        - close：关闭，chan
1. * 指针
   - 理解：保留了变量的内存地址，类型*T是指向类型T的值的指针，其零值是nil，即间接引用。与c不同go没有指针运算
     1. 指向指针的指针
     1. 值传递和指针传递
        ```go
        i := 42
        var p *int      // 声明指针类型
        p = &i          // 赋值指针一个作用对象
        *p              // 读取i，*又变为取值运算符
        *p = 21         // 设置i
        ```
   - 指针数组
     1. 指针数据：是数组，数组中全是指针
        ```go
        a,b := 1,2
        pointArr := [...]*int(&a, &b)
        ```
     1. 数组指针：是指针
        ```go
        arr := [...]int(1,2)
        arrPoint := &arr
        ```
1. 错误和异常
   - 错误
     1. 认识：用error值表示错误状态，error是内在接口，为nil时表示成功；非nil表示错误
        - error接口：fmt包处理error时会调用Error方法，使用`return 0, errors.New("math: square root of negative number")`
            ```go
            i, err := strconv.Atoi("42")
            if err != nil {}
            ```
   - 比较
     1. 在错误处理上采用了与C类似的检查返回值的方式，而异常定义为无法预测的，几乎不可能失败但是特殊条件下也没法返回错误，也无法继续执行，这时就会返回异常panic
   - 异常
     1. 认识：panic、recover，抛出，接收异常
        ```go
        defer func() {                  // 直接执行的匿名方法
            msg := recover()            // 捕获，判断类型
            switch msg.(type) {
                case string:
                case error:
                default:
            }
        }()
        panic("haha")                   // string类型
        panic(error.New("kuku"))        // string类型
        ```
### 面向对象
1. struct
   - 理解：结构体，字段的组合
    ```go
    type Dog struct {
        x int               // 封装
        y int
    }
    // 赋值1
    var dog Dog
    dog.x = 1
    // 赋值2
    dog := Dog{1, 2}
    Dog{x: 1}               // y:0 被省略
    Dog{}                   // 都被忽略
    // 赋值3
    dog := new(Dog)
    dog.x = 1

    // 访问
    dog.x

    // 添加方法
    func (d *Dog) Run {}

    p = &Dog{1, 2}          // 类型为 *Dog
    ```
   - 组合：继承
    ```go
    type Animal struct{
        Color string
    }
    type Dog struct{
        Animal                  // 就组合了，可以用父结构体的属性和方法
        name string
    }
    dog.Color = "1"             // 就可以直接用了
    ```
1. interface 接口
   - 理解：接口类型是一组方法定义的集合。即抽象、封装、多态
        ```go
        type Abser interface {
            Abs() float64
        }

        type MyFloat float64
        f := MyFloat()

        var a Abser                 // 1. 接口定义变量
        a = f                       // 2. 方法赋值给变量，即a MyFloat实现了Abser
        ```
   - 隐式接口：接口的实现都是隐式的，实现接口的所有方法就隐式地实现了接口
     1. 没有了显式声明的必要。解藕了实现接口的包和定义接口的包，因此无需在每个实现上增加新接口，也鼓励了明确的接口定义
     1. ‌interface{}类型不是任意类型，只是‌interface类型
     1. 结构体指针实现接口，结构体初始化变量不会编译通过，因为go的传参值拷贝特性，全新的变量不会指向原来的结构体，也就找不到了，所以提示未实现接口
        - 反之则可以，因为可以隐式的对变量解引用（dereference）获取指针指向的结构体
1. go没有类，可以在任意类型里定义方法，除了基础类型或其他包的类型。方法接收者出现在func和方法名之间的参数中
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
### 协程
1. 认识
   - 并行与并发：并发只是假装同时进行
   - 协程调度模仿的就是linux的进程调度，在其之上自己实现了一套。m就是machine，相当于cpu，g相当于进程，g在m上跑和运行，是没有专门的调度程序的，是p按照提前定义好的规则自己给自己做调度的，调度室是代码+数据
   - 协程的意义
     1. 其他操作耗时的时候让出cpu，不用等待
     1. 给了我们自己调度的自由
1. goroutine：go的协程(coroutine)，协程间需要通信、同步，是并行运行的(多处理器同时)，需要的内存极小，实际可以cpu核数减一来设置，给系统留下
    ```go
    go say("hello")
    go say("world")
    ```
1. channel
   - 认识：有类型的管道，用于协程间通信。默认另一端准备好之前发送和接收都会阻塞，使得goroutine可以在没有明确的锁或竞态变量的情况下同步
        ```go
        ch := make(chan int)
        ch <- v                     // 写
        v := <- ch                  // 读

        // 单向通道
        var send chan <- int         // 只能发送
        var receive <- chan int      // 只能接收
        ```
   - 关闭
        ```go
        c := make(chan int, 10)
        close(c)                        // 发送者close channel，表示再没有值会被发送，只有发送者才能关闭channel

        v,ok := <-ch                    // 接收者通过赋值语句的第二参数来测试channel是否被关闭，ok为false表示已经关闭
        for{
            v,ok := <- ch
            if ok == false {        // 通道已经关闭
                break
            }
        }
        for v := range ch{}         // 简便写法，不断从channel接收值，直到它被关闭
        ```
   - 缓冲
        ```go
        ch := make(chan int, 100)   // 有缓冲通道，只有缓冲区满时才会阻塞，当缓冲区清空的时候接收操作会阻塞
        ch := make(chan int)        // 无缓冲通道/同步通道，即通道大小为0，不会存储数据
        ```
   - select：同时监听多个管道并收发消息，会阻塞直到条件分支中的某个可以继续执行。多个都准备好的随机选一个。可用于多个写入，一个读取场景
        ```go
        select {
            case c <- chName1:
            case <- quitChName:                         // 只要有数据，不管值是什么
            case <- time.After(5 * time.Second):        // 设置超时
            default:                                    // 其他分支没准备好的时候default分支会被执行，可用于非阻塞的发送或者接收
        }
        ```
   - 特性
     1. 无缓冲通道读时没有数据会阻塞，没有取数据时goroutine会阻塞，读写不能放一个协程里，写读颠倒会死锁
     1. 给一个nil的channel发送数据，造成永远阻塞 
     1. 从一个nil的channel接收数据，造成永远阻塞
     1. 给一个已经关闭的channel发送数据，引起panic 
     1. 从一个已经关闭的channel接收数据，返回channel中缓存的值，如果通道中无缓存，返回0
1. sync
   - 同步器：`sync.WaitGroup`，是信号量，需要一个条件完成，才能继续
     1. 方法
        - Add(n)：设置计数器数量n
        - Done()：计数器数量减一
        - Wait()：等待，同步等待所有的记录的协程全部结束
     1. 示例
        ```go
        var wg sync.WaitGroup
        
        wg.Add(2)
        go func() {
            defer wg.Done()
        }()
        go func() {
            defer wg.Done()
        }()
        wg.Wait()                       // 阻塞，使其等待
        ```
   - 锁
     1. 互斥锁：`sync.Mutex`，保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
        ```go
        c.mux.Lock()
        c.v[key]++      // Lock 之后同一时刻只有一个goroutine能访问 c.v
        c.mux.Unlock()
        ```
     1. 读写互斥锁：`sync.RWMutex`
     1. map：`sync.Map`
1. context：库，1.7加入，跟踪goroutine调用树，并在这些树中传递通知和元数据
   - 退出通知机制：传递给所有树节点
   - 传递数据：传递给所有树节点
### 包
1. package
   - 认识：包，是最基本的分发单位和工程管理中依赖的体现
     1. go源代码开头都必须以package声明开头，用来表示所属代码包
     1. 同一个路径下只能存在一个package(同一个目录下包名相同)，一个package可拆成多个源文件(同一个目录下可有多个文件)
     1. 可执行的程序必须有main包，并且该包下有main函数
   - 导入
     1. 认识：import，顺序导入有依赖的包，两种导入方式，导入未使用的包会报错，包只会被导入一次，import只有这一个功能
        - 先导入最上层依赖的包
        - 然后初始化包中常量和变量
        - 然后包中有init方法则执行
        - 所有包导入完成后，对main初始化常量和变量、执行init方法
     1. 导入方式
        ```go
        import "fmt"
        import "math"
        // 推荐下面的
        import (
            "fmt"
            "math"
            "math/rand"         // 导入某一个包
        )
        ```
     1. 别名：`import xx/./_ "fmt"`
       1. .：点标识的包导入后，调用该包函数可以省略包名，不建议用，容易迷惑
       1. _：不导入整个包，只执行init函数，用来注册包中引擎
   - 导出：package，可执行命令必须使用main包
1. time
   - time
     1. `time.Now()`
     1. `time.Sleep(time.Second * 5)`
1. os
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
1. bufio：os包的增强版，如可读取一行
1. net、log
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

        err := http.ListenAndServe("localhost:4000", h)                             // 启动服务器
        if err != nil {
            log.Fatal(err)
        }
        ```
   - ip：`addr := net.ParseIP()`
1. image
    ```go
    m := image.NewRGBA(image.Rect(0, 0, 100, 100))
	m.Bounds()
	m.At(0, 0).RGBA()
    ```
1. math
   - `math.Nextafter(2, 3)`
   - `rand.Intn(10)`："math/rand"
1. database/sql：数据库驱动的标准接口
1. archive
   - `archive.tar`
   - `archive.zip`
1. reflect
   - TypeOf()/Type()
   - ValueOf()/Value()
     1. CanSet()
   - Elem()：指针指向的元素类型
1. runtime
   - `runtime.GOMAXPROCS`：使用最大核心数
   - `runtime.NumCPU`：cpu核心数
   - `runtime.Gosched()`：使goroutine让出cpu时间片
   - `runtime.Goexit()`：使goroutine立即终止
   - 多线程
     1. Goexit
     1. Gosched
     1. NumCPU
     1. NumGoroutine
     1. GOMAXPROCS
### 应用
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
   - json：encoding/json包
     1. Marshal：序列化，用于map和struct
        ```go
        type Server struct {
            ServerName string `json:"name"`     // 这是tag，生成json时替换key，做个映射，反过来也会用到
            ServerIP   string `json:"ip"`
        }

        server := new(Server)
        server.ServerName = "1"

        a,err := json.Marshal(server)       // 序列化
        if err != nil {
            return err.Error()
        }
        ```
     1. Unmarshal：反序列化
        - struct
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
            err := json.Unmarshal([]byte(str), &s)     // 强行转为数组
            fmt.Println(s)
            ```
        - map
            ```go
            // 未知结构，interface和type assert配合
            str := `{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`
            var f interface{}
            err := json.Unmarshal(str, &f)
            m := f.(map[string]interface{})             // 断言形式

            // 下边这些不知道在干嘛
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
1. 配合其他语言
   - python
   - c
     1. 认识：cgo，就是先由编译器识别出import "C"的位置，然后在其上的注释中提取C代码，最后调用C编译器进行分开编译
        - go代码开始部分(package xxx之后)，添加注释，注释中编写需要使用的C语言代码
        - 紧挨着注释结束，另起一行增加import "C"，且不要跟其他golang的import放在一起
     1. demo
        ```go
        package main

        // #include <stdio.h>
        // #include <stdlib.h>
        /*
        void print(char *s) {
            printf("print used by C language:%s\n", s);
        }
        */
        import "C" //和上一行"*/"直接不能有空行或其他注释

        import "unsafe"

        func main() {
            s := "hello"
            cs := C.CString(s)
            defer C.free(unsafe.Pointer(cs))
            C.print(cs)
        }
        ```
### 运维
1. 运行
   - 环境变量
     1. GOROOT：告知当前go的位置，可以不设置，默认在/usr/local/go，编译的时候从GOROOT找system libariry
     1. GOPATH：告知去哪里找代码，必须设置，可以修改，工作空间为
        - src：源码目录，import时来src查找
        - bin：可执行命令，go get二进制文件下载的目的地
        - pkg：包对象，编译生成的lib文件存储的地方
   - module
     1. 认识：go Module，模块的版本管理工具，命令行支持modules操作，modules用来替换GOPATH的
     1. 组成
        - go.mod文件，可以将工程从GOPATH中移出来
            ```
            module rsc.io/hello

            go 1.12

            require (
                "golang.org/x/text" v0.0.0-20180208041248-4e4a3210bb54
                "rsc.io/quote" v1.5.2
            )
            ```
        - go.sum文件：用来校验文件，都是命令行自动操作
     1. 使用
        - 初始化：`go mod init`
        - 查看
          1. 打印：`go mod graph`
          1. 展示依赖关系：`go mod why`
        - 操作
          1. 下载：`go get`
          1. 下载：`go build`
          1. 编辑：`go mod edit -module/require/version/print xx`
          1. 下载：`go mod download`
          1. 将依赖放入vendor目录：`go mod vendor`，将GOPATH分开，用于打包构建
          1. 验证：`go mod verify`
          1. 整理：`go mod tidy`，需要的加，不要的删
   - 依赖管理
     1. 认识：dep，实现了tag管理代码，而不是trunk/mainline，如go get下载的代码，依赖管理工具为应用管理代码，go get为GOPATH管理代码
     1. 组成
        - `Gopkg.toml`：配置文件，可以手工修改
        - `Gopkg.lock`
        - vendor：依赖管理目录，vendor属性是go编译时，先从项目根目录的vendor目录查找代码，有则不再去GOPATH中去查找
     1. 命令
        - `dep init`：初始化新项目
        - `dep status`
        - `dep check`：检查toml和lock文件是否同步
        - `dep ensure`
          1. `dep ensure`：安装依赖
          1. `dep ensure -update`：更新依赖
          1. `dep ensure -add github.com/pkg/errors`：添加依赖
        - `dep version`：dep的版本
     1. 其他依赖管理工具
        - godep：Godeps/Godeps.json
        - glide：glide.yaml、glide.lock，官方建议迁移到dep
        - govendor
        - gvt
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
        - `go tool compile -N -l -S main.go`：不优化编译，可用dlv调试
     1. `go vet`：静态检查工具，项目快完成时进行进行优化
   - 运行和编译
     1. `go run hello.go`
     1. `go build`：用于测试编译，普通包不产生任何文件，main包生成可执行文件，会在GOROOT/src和GOPATH/src搜索包
        - `go build -ldflags "-s -w"`：-s 去掉符号信息。-w 去掉DWARF调试信息
        - `go build -gcflags "-N -l"`：关闭内联优化
     1. `go install`：生成可执行文件，结果移到$GOPATH/pkg(bin)
     1. `go clean`：移除当前源码包里面编译生成的文件
   - 模块
     1. `go get`：动态获取远程代码包，下载和install，下载到GOROOT/src
     1. `go list`：查看安装的packag
1. 部署
   - supervisor来管理go程序，go自己用异常捕捉来处理
   - 打包linux的：`CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build main.go`
### wiki
1. 关键字和标识符
   - 关键字：25个
     1. var、const、map、struct、type
     1. if、else、for、switch、select、break、continue、case、default、range
     1. goto、defer
     1. func、interface、return
     1. go、chan
     1. package、import
     1. fallthrough
   - 标识符：36个
     1. 基础数据类型
        - iota
        - nil、bool、false、true、byte、string
        - int、int8、int16、int32、int64、uint、uint8、uint16、uint32、uint64、uintptr、float32、float64、complex、complex64、complex128
        - imag、panic、recover
     1. 内嵌函数
        - copy、append、cap、close、len、real
        - make、new
        - print、println
1. 历史
   - 07年开发
   - 09年开源
   - 12年1.0稳定版本
   - 14年1.4版本
   - 1.11
     1. 库文件管理模块go module
1. wiki
   - int/uint/uintptr受系统位数影响，64位系统就是64位
1. 测试：go test和testing包
