### 语法
1. 数据类型转换
    ```go
    var f float64 = float64(i)
    // 或者
    f := float64(i)
    ```
1. 常量
    ```go
    // 数值常量，表示高精度的值
    const (
        Big   = 1 << 100
        Small = Big >> 99
    )

    // 存储数据的Byte、KB、MB、GB、TB、PB的计算
    const(
        b=1<<(10*iota)
        kb
        mb
        gb
        tb
        pb
    )

    func dataByte() {
        fmt.Println("b=",b)
        fmt.Println("kb=",kb)
        fmt.Println("mb=",mb)
        fmt.Println("gb=",gb)
        fmt.Println("tb=",tb)
        fmt.Println("pb=",pb)
    }
    ```
1. if
    ```go
    // 便捷写法，但是变量作用域仅在if范围，包括else范围
    if v := math.Pow(x, n); v < lim {
    }
    ```
1. switch
    ```go
    // 没有条件的switch，代替冗长的if-then-else
    switch {
    case t.Hour() < 12:
    case t.Hour() < 17:
    default:
    }
    ```
1. for简写
    ```go
    for ; sum < 10; {       // 前/后置语句为空，和c、java一样
        sum += sum
    }
    ```
1. 死循环：`for {}`
1. 函数
    ```go
    // 多值返回
    func swap(x, y string) (string, string) {           // 缩写参数类型
        return y, x
    }
    a, b := swap("hello", "world")
    // 命名返回值
    func split(sum int) (x, y int) {                    // x/y为返回值，为变量。长函数中使用会影响可读性
        x = sum * 4 / 9
        y = sum - x
        return
    }
    // 函数作为参数、返回值
    hypot := func compute(fn func(float64, float64) float64) float64 {
        return fn(3, 4)
    }
    ```
1. 在结构体上定义方法
    ```go
    func (v *vertex) Add() float64 {
	    return v.X + v.Y
    }
    v := &vertex{3, 4}
    v.Abs()                 // 使用
    ```
1. 指针访问结构体
    ```go
    v := vertex{1, 2}
	p := &v
    p.X
    ```
1. 打印
   - `fmt.Printf("s[%d] == %d\n", i, s[i])`
     1. %s：字符串
     1. %d：数字
     1. %v：slice
   - `fmt.Println(m)`
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
1. 反射
   - 类型
     1. `reflect.Kind`：内置元类型，表示reflect包中定义的十几种，每种有一个整数编号
        ```go
        const (
            Invalid Kind = iota         // 不存在的无效类型
            Bool
            Int
            Int8
            Int16
            Int32
            Int64
            Uint
            Uint8
            Uint16
            Uint32
            Uint64
            Uintptr                     // 指针的整数类型，对指针进行整数运算时使用
            Float32
            Float64
            Complex64
            Complex128
            Array
            Chan
            Func
            Interface
            Map
            Ptr                         // 指针类型
            Slice 
            String
            Struct                      // 结构体类型
            UnsafePointer               // unsafe.Pointer 类型
        )
        ```
     1. `reflect.Type`：接口
        ```go
        type Type interface {
            // 返回接口原类型
            Kind() Kind
            // 自身包内的类型名，如果是未命名类型会返回""
            Name() string
            // 返回类型的包路径，即明确指定包的import路径，如"encoding/base64"
            // 如果类型为内建类型(string, error)或未命名类型(*T, struct{}, []int)，会返回""
            PkgPath() string
            // 返回类型的字符串表示。该字符串可能会使用短包名（如用base64代替"encoding/base64"）
            // 也不保证每个类型的字符串表示不同。如果要比较两个类型是否相等，请直接用Type类型比较。
            String() string
            // 返回要保存一个该类型的值需要多少字节；类似unsafe.Sizeof
            Size() uintptr
            // 返回当从内存中申请一个该类型值时，会对齐的字节数
            Align() int
            // 返回当该类型作为结构体的字段时，会对齐的字节数
            FieldAlign() int
            // 如果该类型实现了u代表的接口，会返回真
            Implements(u Type) bool
            // 如果该类型的值可以直接赋值给u代表的类型，返回真
            AssignableTo(u Type) bool
            // 如该类型的值可以转换为u代表的类型，返回真
            ConvertibleTo(u Type) bool
            // 返回该类型的字位数。如果该类型的Kind不是Int、Uint、Float或Complex，会panic
            Bits() int
            // 返回array类型的长度，如非数组类型将panic
            Len() int
            // 返回该类型的元素类型，如果该类型的Kind不是Array、Chan、Map、Ptr或Slice，会panic
            Elem() Type
            // 返回map类型的键的类型。如非映射类型将panic
            Key() Type
            // 返回一个channel类型的方向，如非通道类型将会panic
            ChanDir() ChanDir
            // 返回struct类型的字段数（匿名字段算作一个字段），如非结构体类型将panic
            NumField() int
            // 返回struct类型的第i个字段的类型，如非结构体或者i不在[0, NumField())内将会panic
            Field(i int) StructField
            // 返回索引序列指定的嵌套字段的类型，
            // 等价于用索引中每个值链式调用本方法，如非结构体将会panic
            FieldByIndex(index []int) StructField
            // 返回该类型名为name的字段（会查找匿名字段及其子字段），
            // 布尔值说明是否找到，如非结构体将panic
            FieldByName(name string) (StructField, bool)
            // 返回该类型第一个字段名满足函数match的字段，布尔值说明是否找到，如非结构体将会panic
            FieldByNameFunc(match func(string) bool) (StructField, bool)
            // 如果函数类型的最后一个输入参数是"..."形式的参数，IsVariadic返回真
            // 如果这样，t.In(t.NumIn() - 1)返回参数的隐式的实际类型（声明类型的切片）
            // 如非函数类型将panic
            IsVariadic() bool
            // 返回func类型的参数个数，如果不是函数，将会panic
            NumIn() int
            // 返回func类型的第i个参数的类型，如非函数或者i不在[0, NumIn())内将会panic
            In(i int) Type
            // 返回func类型的返回值个数，如果不是函数，将会panic
            NumOut() int
            // 返回func类型的第i个返回值的类型，如非函数或者i不在[0, NumOut())内将会panic
            Out(i int) Type
            // 返回该类型的方法集中方法的数目
            // 匿名字段的方法会被计算；主体类型的方法会屏蔽匿名字段的同名方法；
            // 匿名字段导致的歧义方法会滤除
            NumMethod() int
            // 返回该类型方法集中的第i个方法，i不在[0, NumMethod())范围内时，将导致panic
            // 对非接口类型T或*T，返回值的Type字段和Func字段描述方法的未绑定函数状态
            // 对接口类型，返回值的Type字段描述方法的签名，Func字段为nil
            Method(int) Method
            // 根据方法名返回该类型方法集中的方法，使用一个布尔值说明是否发现该方法
            // 对非接口类型T或*T，返回值的Type字段和Func字段描述方法的未绑定函数状态
            // 对接口类型，返回值的Type字段描述方法的签名，Func字段为nil
            MethodByName(string) (Method, bool)
            // 内含隐藏或非导出方法
        }
        ```
     1. `reflect.Value`：结构体类型
        ```go
        func (v Value) IsNil() bool
        func (v Value) IsValid() bool       // 返回v是否持有一个值。如v是Value零值会返回假，此时v除了IsValid、String、Kind之外方法都导致panic
        func (v Value) Kind() Kind          // Kind返回v持有的值的分类，如果v是Value零值，返回值为Invalid
        func (v Value) Type() Type          // 返回v持有的值的类型的Type表示
        // Elem返回v持有的接口保管的值的Value封装，或者v持有的指针指向的值的Value封装。
        // 如果v的Kind不是Interface或Ptr会panic；如果v持有的值为nil，会返回Value零值。
        func (v Value) Elem() Value
        func (v Value) Bool() bool          // 返回v持有的布尔值，如果v的Kind不是Bool会panic
        ......
        func (v Value) NumField() int       // 返回v持有的结构体类型值的字段数，如果v的Kind不是Struct会panic
        func (v Value) Field(i int) Value   // 返回结构体的第i个字段（的Value封装）。如果v的Kind不是Struct或i出界会panic
        ......
        func (v Value) Send(x Value)        // 方法向v持有的通道发送x持有的值。如果v的Kind不是Chan或x持有值不能直接赋值给v持有通道的元素类型，会panic
        .......
        func (v Value) Call(in []Value) []Value     // Call方法使用输入的参数in调用v持有的函数
        ....
        func (v Value) CanAddr() bool       // 返回是否可以获取v持有值的指针
        func (v Value) CanSet() bool        // 返回v是不是可被设定的
        func (v Value) SetBool(x bool)      // 设置v的持有值。如果v的Kind不是Bool或者v.CanSet()返回假，会panic。
        func (v Value) SetInt(x int64)      // 设置v的持有值。如果v的Kind不是Int、Int8、Int16、Int32、Int64之一或者v.CanSet()返回假，会panic。
        .......
        ......
        func DeepEqual(a1, a2 interface{}) bool     // 判断两个值是否深度相等.结构体会对字段进行深度对比，array/slice对比成员/长度等，map深度对比键值对
        ```
   - 实例
    ```go
    // 常规操作
    var demoV1 DemoInt
    demoV1 = 100

    reflectTDV1 := reflect.TypeOf(demoV1)
    reflectTDV1.Kind()                          // int，原始类型
    reflectTDV1.Name()                          // demoInt，如果是原int则是int
    reflectTDV1.String()                        // main.demoInt
    reflectTDV1.Align()                         // 8

    reflectVDV1 := reflect.ValueOf(demoV1)
    reflectVDV1.Type()                          // main.demoInt
    reflectVDV1.Kind()                          // int

    // CanAddr
    demoV1 := 100
    reflect.ValueOf(&demoV1).CanAddr()          //false
    //reflect.ValueOf(&demoV1).Elem().CanAddr()   //true

    // Set
    var a []int
    ra := reflect.ValueOf(&a)
    aElem := ra.Elem()
    fmt.Println("elem ", aElem, " source slice:", a)    //elem  []  source slice: []

    aElem.Set(reflect.ValueOf([]int{11}))
    // Comparable，判断是否可比较
    func canCompare(source interface{}) {
        sType := reflect.TypeOf(source)
        sType.Comparable()
    }

    // Call
    val := reflect.ValueOf(a)
    val.Method(1).Call(nil)                             //获取到第二个方法，调用它
    val.MethodByName("SumNum").Call(nil)
    ```
1. 代码简化
    ```go
    []T{T{}, T{}}
    // 切片表达式简化为
    []T{{}, {}}

    s[a:len(s)]
    // 切片表达式简化为
    s[a:]

    for x, _ = range v {...}
    // 迭代简化为
    for x = range v {...}

    for _ = range v {...}
    // 迭代简化为
    for range v {...}
    ```
### 最佳实践
1. 编写思路
   - 编程起势：首先通过划分结构体，定义不同的功能模块，然后分别实现，最终实现功能
   - 函数式编程：通过参数、返回值、变量都是函数的形式，实现更加灵活的处理
     1. 将具体执行的逻辑包装成一个方法，大家执行这个方法，内部自己定义，就可以将实现解耦了，大家不用关心执行的内容了
   - 并行思想：之前用的读io然后处理的单线程模式，改为：起多个不同的协程(有的处理读io，有的处理逻辑)，协程之间通过chan传递数据，一边读取一边处理的协程模式了
     1. 耗时的goroutine可以多起几个
1. channel相关
   - 时间的处理：放在select的case中
     1. 两个time.After()，长的设置总运行时间，短的设置超时时间
     1. time.Tick()设置定时任务，如报告与之相关的channel的状态
1. 应用场景
   - channel
     1. 通过设置为缓存通道，实现抢购场景的解决方案
     1. 通过通信共享内存，不要通过共享内存来通信
        ```go
        // 响应公共结构体
        type APIBase struct {
            Code    int32  `json:"code"`
            Message string `json:"message"`
        }

        // 模拟接口A的响应结构体
        type APIDemoA struct {
            APIBase
            Data APIDemoAData `json:"data"`
        }

        type APIDemoAData struct {
            Title string `json:"title"`
        }

        // 模拟接口B的响应结构体
        type APIDemoB struct {
            APIBase
            Data APIDemoBData `json:"data"`
        }

        type APIDemoBData struct {
            SkuList []int64 `json:"sku_list"`
        }

        // 模拟接口逻辑
        func main() {
            // 创建接口A传输结果的通道
            execAResult := make(chan APIDemoA)
            // 创建接口B传输结果的通道
            execBResult := make(chan APIDemoB)

            // 并发调用接口A
            go func(execAResult chan<- APIDemoA) {
                // 模拟接口A远程调用过程
                time.Sleep(2 * time.Second)
                execAResult <- APIDemoA{}
            }(execAResult)

            // 并发调用接口B
            go func(execBResult chan<- APIDemoB) {
                // 模拟接口B远程调用过程
                time.Sleep(1 * time.Second)
                execBResult <- APIDemoB{}
            }(execBResult)

            var resultA APIDemoA
            var resultB APIDemoB
            i := 0
            for {
                if i >= 2 {
                    fmt.Println("退出")
                    break
                }
                select {
                case resultA = <-execAResult: // 等待接口A的响应结果
                    i++
                    fmt.Println("resultA", resultA)
                case resultB = <-execBResult: // 等待接口B的响应结果
                    i++
                    fmt.Println("resultB", resultB)
                }
            }
        }
        ```
   - io/ioutil：读取所有字符
    ```go
    resp, err := http.Get("http://example.com?user_id=121212")
	if err != nil {
	}
	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
	}
    ```
1. 实用技巧
   - 全局变量：可以避免重复申请带来的内存交互
   - sync.Pool：重复申请的对象，可以减少GC的成本
    ```go
    // 使用sync.Pool
    func BenchmarkDemo_Pool(b *testing.B) {
        // 使用缓存池sync.Pool
        demoPool := &sync.Pool{
            // 定义初始化结构体的匿名函数
            New: func() interface{} {
                return &AddressModule{
                    Country: &Country{
                        ID:   0,
                        Name: "",
                    },
                    Province: &Province{
                        ID:   0,
                        Name: "",
                    },
                    City: &City{
                        ID:   0,
                        Name: "",
                    },
                    County: &County{
                        ID:   0,
                        Name: "",
                    },
                    Street: &Street{
                        ID:   0,
                        Name: "",
                    },
                }
            },
        }
        b.RunParallel(func(pb *testing.PB) {
            for pb.Next() {
                // 从缓存池中获取对象
                addressModule, _ := (demoPool.Get()).(*AddressModule)
                // 下面这段代码没意义 只是为了不报语法错误
                if addressModule == nil {
                    return
                }

                // 重置对象 准备归还对象到缓存池
                addressModule.Consignee = ""
                addressModule.Email = ""
                addressModule.Mobile = 0
                addressModule.Country.ID = 0
                addressModule.Country.Name = ""
                addressModule.Province.ID = 0
                addressModule.Province.Name = ""
                addressModule.County.ID = 0
                addressModule.County.Name = ""
                addressModule.Street.ID = 0
                addressModule.Street.Name = ""
                addressModule.DetailedAddress = ""
                addressModule.PostalCode = ""
                addressModule.IsDefault = false
                addressModule.Label = ""
                addressModule.Longitude = ""
                addressModule.Latitude = ""
                // 还对象到缓存池
                demoPool.Put(addressModule)
            }
        })
    }

    // 使用sync.Pool执行结果
    // goos: darwin
    // goarch: amd64
    // pkg: demo
    // cpu: Intel(R) Core(TM) i5-7360U CPU @ 2.30GHz
    // BenchmarkDemo_Pool-4   	988550808	        12.41 ns/op	       0 B/op	       0 allocs/op
    // PASS
    // ok  	demo	14.215s
    ```
   - sync/singleflight：缓存等穿透时减少请求数
    ```go
    func TestDemo_Singleflight(t *testing.T) {
        t.Parallel()
        singleGroup := singleflight.Group{}
        wg := sync.WaitGroup{}
        // 模拟并发远程调用
        for i := 0; i < 3; i++ {
            wg.Add(1)
            go func() {
                defer wg.Done()
                // 使用singleflight
                res, err, shared := singleGroup.Do("cache_key", func() (interface{}, error) {
                    resp, err := http.Get("http://example.com")
                    if err != nil {
                        return nil, err
                    }
                    body, err := ioutil.ReadAll(resp.Body)
                    if err != nil {
                        return nil, err
                    }
                    return body, nil
                })
                if err != nil {
                    t.Error(err)
                    return
                }
                _, _ = res.([]byte)
                t.Log("log", shared, err)
            }()
        }

        wg.Wait()
    }
    ```
1. 避坑指南
   - 谨慎使用全局变量，全局变量不会像PHP一样，在完成一次请求之后被销毁，而是会被改变
   - 形参是slice、map类型的参数，注意值可被全局修改，array则不会
     1. 因为：浅复制过程中slice和map底层的类型是个结构体，实际存储值的类型是个指针
     1. 解决：深拷贝，开辟新内存，指针指向新内存地址，并把原有的值复制过去
        ```go
        package main

        import "fmt"

        func main() {
            paramDemo := []int32{1}
            fmt.Println("main.paramDemo 1", paramDemo)
            // 初始化新空间
            paramDemoCopy := make([]int32, len(paramDemo))
            // 深拷贝
            copy(paramDemoCopy, paramDemo)
            demo(paramDemoCopy)
            fmt.Println("main.paramDemo 2", paramDemo)
        }

        func demo(paramDemo []int32) ([]int32, error) {
            paramDemo[0] = 2
            return paramDemo, nil
        }

        // [Running] go run ".../demo/main.go"
        // main.paramDemo 1 [1]
        // main.paramDemo 2 [1]
        ```
   - 资源使用完毕，记得释放资源或回收资源
     1. 原因
        - 资源连接数线性增长
        - 如果一直持有，资源服务端也有超时时间
     1. 方法：写成`defer close()`
   - 不要依赖map遍历的顺序
     1. 因为：底层实现都是数组+类似拉链法，以下3点都决定了map本来就是无序的，所以Go语言为了避免开发者依赖元素顺序，每次遍历的时候都是随机了一个索引起始值。然后PHP通过额外的内存空间维护了map元素的顺序
        - hash函数无序写入
        - 成倍扩容
        - 等量扩容
   - 不要并发写map，会触发panic
   - 注意判断指针类型不为空nil，再操作
    ```go
    resp, err := http.Get("https://www.example.com")

    // 错误示范
	if resp.StatusCode != http.StatusOK || err != nil {
		// 当 resp为nil时 会触发panic
		// 当 resp.StatusCode != http.StatusOK 时err可能为nil 触发panic
		log.Printf("err: %s", err.Error())
	}

    // 正确示范
    if err != nil {
		// 报错并记录异常日志
		log.Printf("err: %s", err.Error())
		return
	}
	// 模拟业务code不为成功的code
	if resp != nil && resp.StatusCode != http.StatusOK {
		// 报错并记录异常日志
	}
    ```
1. web错误处理
   - defer + panic + recover：多加一层panic，优化默认http的的报错展示
   - Type Assertion：通过类型定义，区分用户展示和服务器展示
   - 函数式编程：实现错误处理的代理，接收各种逻辑处理函数遇到的错误，形式为
    ```go
    func errorWrapper(handler appHandler) func(http.ResponseWriter, *http.Request) {
        return func(writer http.ResponseWriter, request *http.Request) {
            // 多加一层panic
            defer func() {
                if r := recover(); r != nil {

                }
            }
            // 错误逻辑处理
        }
    }
    ```
1. 引号输出
   - 使用反引号：`a := `"xx"``
   - 使用转义：`a := "\"xx\""`
   - 使用strconv包：`a := strconv.Quote("xx")`
1. 函数可选参数实践
    ```go
    // 使用NewQueue，动态改变可选的新参数的方法
    // 用新的方法处理不同情况下不同的参数，NewQueue相当于一个代理方法


    type Queue struct {
        Name     string
        MaxLimit int

        // monitor
        MonitorInterval int
    }

    type QueueOption func(*Queue)

    func WithMaxLimit(max int) QueueOption {
        return func(q *Queue) {
            q.MaxLimit = max
        }
    }

    func WithMonitorInterval(seconds int) QueueOption {
        return func(q *Queue) {
            q.MonitorInterval = seconds
        }
    }

    func NewQueue(name string, options ...QueueOption) *Queue {
        queue := &Queue{name, 10, 5}

        for _, o := range options {
            o(queue)
        }

        return queue
    }
    ```
### 应用demo
1. 读取二进制的bmp文件头
    ```go
    import (
        "encoding/binary"
        "fmt"
        "os"
    )

    type BitmapInfoHeader struct {
        Size           uint32 // 结构体大小
        Width          int32  // 宽度
        Height         int32  // 高度
        Planes         uint16 // 面， 恒定为1
        BitCount       uint16 // 每个像素占用的字节数
        Compression    uint32 // 压缩类型
        SizeImage      uint32 // 图形大小
        XPerlsPerMeter int32  // 水平分辨率 每米的像素数
        YPerlsPerMeter int32  // 每米的像素数
        ClrUsed        uint32 // 颜色数
        ClrImportant   uint32 // 调色版
    }

    func main() {
        // 读取文件
        file, err := os.Open("image.bmp")
        if err != nil {
            fmt.Println(err)
            return
        }

        // 逐个部门一点点读取属性
        var headA, headB byte                                   // 读文件头，为 BM
        binary.Read(file, binary.LittleEndian, &headA)
        binary.Read(file, binary.LittleEndian, &headB)

        var size uint32                                         // 读文件大小
        binary.Read(file, binary.LittleEndian, &size)

        var reserveA, reserveB uint16
        binary.Read(file, binary.LittleEndian, &reserveA)
        binary.Read(file, binary.LittleEndian, &reserveB)

        var offbits uint32                                      // 读偏移数据，文件真正开始的地方
        binary.Read(file, binary.LittleEndian, &offbits)

        fmt.Println(headA, headB, size, reserveA, reserveB, offbits)

        // 读接下来的数据：构造好结构体绑定，一次性获取属性，快速
        infoHeader := new(BitmapInfoHeader)
        if err := binary.Read(file, binary.LittleEndian, infoHeader); err != nil {
            fmt.Println(err)
            return
        }
        fmt.Println(infoHeader)
    }
    ```
1. 自定义时间格式
    ```go
    en["date_format"]="%Y-%m-%d %H:%M:%S"
    cn["date_format"]="%Y年%m月%d日 %H时%M分%S秒"

    fmt.Println(date(msg(lang,"date_format"),t))

    func date(fomate string,t time.Time) string{
        year, month, day = t.Date()
        hour, min, sec = t.Clock()
        //解析相应的%Y %m %d %H %M %S然后返回信息
        //%Y 替换成2012
        //%m 替换成10
        //%d 替换成24
    }
    ```
1. aes加解密
    ```go
    import (
        "crypto/aes"
        "crypto/cipher"
        "fmt"
        "os"
    )

    var commonIV = []byte{0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f}

    func main() {
        //需要去加密的字符串
        plaintext := []byte("My name is Astaxie")
        //如果传入加密串的话，plaint就是传入的字符串
        if len(os.Args) > 1 {
            plaintext = []byte(os.Args[1])
        }

        //aes的加密字符串
        key_text := "astaxie12798akljzmknm.ahkjkljl;k"
        if len(os.Args) > 2 {
            key_text = os.Args[2]
        }

        fmt.Println(len(key_text))

        // 创建加密算法aes
        c, err := aes.NewCipher([]byte(key_text))
        if err != nil {
            fmt.Printf("Error: NewCipher(%d bytes) = %s", len(key_text), err)
            os.Exit(-1)
        }

        //加密字符串
        cfb := cipher.NewCFBEncrypter(c, commonIV)
        ciphertext := make([]byte, len(plaintext))
        cfb.XORKeyStream(ciphertext, plaintext)
        fmt.Printf("%s=>%x\n", plaintext, ciphertext)

        // 解密字符串
        cfbdec := cipher.NewCFBDecrypter(c, commonIV)
        plaintextCopy := make([]byte, len(plaintext))
        cfbdec.XORKeyStream(plaintextCopy, ciphertext)
        fmt.Printf("%x=>%s\n", ciphertext, plaintextCopy)
    }
    ```
1. goroutine的斐波那契数列
    ```go
    func fibonacci(c, quit chan int) {
        x, y := 0, 1
        for {
            select {
            case c <- x:
                x, y = y, x+y
            case <-quit:
                fmt.Println("quit")
                return
            }
        }
    }

    func main() {
        c := make(chan int)
        quit := make(chan int)
        go func() {
            for i := 0; i < 10; i++ {
                fmt.Println(<-c)
            }
            quit <- 0
        }()
        fibonacci(c, quit)
    }
    ```
### 算法
1. 外部排序
   - 解析：pipeline思想，将源数据分成一个个的节点，然后归并到最终集
     1. 每个节点内部使用sort包的内部排序
     1. 多个节点进行归并计算
   - 实现
     1. 多个节点值的归并：可选参数 + 递归
        ```go
        func MergeM(inputs ...<-chan int) <-chan int {
            if len(inputs) == 1 {
                return inputs[0]
            }

            m := len(inputs) / 2
            return Merge(MergeN(inputs[:m]...), MergeN(inputs[m:]...))      // slide和可变参数的转换
        }
        ```
### 部署