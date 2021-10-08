### go
1. 认识：全称golang，静态强类型、编译型、并发型具有垃圾回收的开源语言，感觉却像动态类型的解释型语言
   - 简洁清晰高效
   - 并发机制，goroutine跟channel，有效利用多核和网络，并发而生
   - go的机器码迅速，可直接编译成机器码，支持跨平台编译
   - 方便的自动垃圾回收
   - 丰富的内置类型支持，支持函数多返回值、匿名函数和闭包、类型和接口、反射
   - 丰富的标准库支持、强大的工具类库
   - 强大的运行时反射机制，便于在线的性能分析，以及堆栈分析
   - 能与c语言交互
   - 缺少框架、软件包管理不完善
1. 特点
   - 性能、简单
   - 每个Go程序都是由包组成的
   - 现代的、支持网络与多核计算的语言，结合了解释型语言的游刃有余，动态类型语言的开发效率，以及静态类型的安全性
1. 用途
   - 服务器编程：处理日志
   - 分布式系统：数据库代理器、NewSQL
   - 网络编程：Web应用、api应用
   - 内存数据库：groupcache、couchbase
   - 云平台：k8s
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
   - 关键字：函数外的每个语句都必须以关键字(var/func/...)开始
   - 行分隔符：每行可以不加分号，写在一行可用;区分不推荐
   - 注释：多行/* */、单行//
   - 标识符：用来命名变量、类型等程序实体
1. 标识符
   - 认识
     1. 可以直接使用，而不用声明
   - 组成
     1. nil：表示指针/map/slice/function/interface/channel的零值，表示声明了没有赋值，不是关键词只是变量名
        - nil和空不同，nil不会指向底层地址，空会
1. 运算符
   - + 字符串连接符
   - 引号
     1. 单引号：只能有一个ASCII码字符，也就是一个字节，输出会返回这个字符的ASCII码 ，如果想输出为字符需要用string()函数转换一下
        ```go
        var asc byte = 'a'
        fmt.Println(asc)        // 输出a的ASCII码值 97
        ```
   - 算术：++、--、+-*/%
   - 关系：==、!=、>、<、>=、<=
   - 逻辑：&&、||、!
   - 按位：&、|、^、<<、>>
   - 赋值：=、+=等
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
        - uintptr：无符号整型，足够大可以容纳任何指针的位模式，跟系统位数有关系，用于存放一个指针
        - 引用：8byte
   - 派生
     1. array
     1. slice
     1. map
     1. struct
     1. func
     1. interface
     1. pointer：指针
     1. chan
   - 特点
     1. 类型零值：变量无初始化时的默认值，可以表现为0，false，""，nil
     1. 类型推导：不指定其类型时，由右值推导得出
     1. 类型转换：T(v)，将值v转换为类型T，不同类型相互转换的时候需要显式转换
     1. 类型别名：`type aInt int`
   - 实例
    ```go
    // 声明类型
    type aInt int                           // 一般类型声明，相当于类型别名
    type aStruct struct {}
    type Ia interface{}
    ```
1. string
   - 认识：字符串，是一串字符连接的任意字节的固定长度的变宽常量字符序列，由单个字节连接起来，使用utf-8编码
     1. 使用双引号或反引号创建
        - 双引号：可解析的。可以转义，不能换行
        - 反引号：原生的。不能转义，可以换行。一般用于sql、html等大段内容，以及正则表达式
     1. 字符串不可改变
        - 内部用指针指向UTF-8字节数组
        - 想要改变：先将字符串转为字节数组`[]byte`或字符数组`[]rune`，有中文使用字符数组
1. array
   - 认识：数组，`[n]T`，相同类型T的值的定长数组
     1. […]：语法糖，让编译器自动推导数组长度
   - 代码
    ```go
    // 定义
    var a [2]string
    a[0]                // 访问
    a[1] = "World"      // 赋值
    ```
1. slice
   - 认识：切片，`[]T`，相同类型的值的变长序列
       ```go
        // 定义
        s := []int                              // 零值是nil，长度和容量是0
        // 构造slice，分配一个零长度的数组并且返回一个slice指向这个数组
        s := make([]int, 5)                     // 5个0的元素
        s := make([]int, 0, 5)                  // 0个元素，但是cap=5，返回的是数组切片分配的空间大小
        // 赋值
        s := []int{2, 3, 5}
        // 访问
        a := s[i]
        // 修改
        s[i] = 1
        // 添加
        s = append(s, 2, 3, 4)
        // 删除，没有提供现成的，原理是以被删除元素为分界点，将前后两个部分的内存重新连接起来
        a = a[n:]                               // 删除头部n个
        a = append(a[:i], a[i+n:]...)           // 删除中间n个，...表示多对使用
        a = a[:i+copy(a[i:], a[i+n:])]
        a = a[:len(a)-n]                        // 删除尾部n个
        // 取子切片
        s[1:4]
        s[0:1:4]
        s[:3]
        s[4:]
        s = s[:cap(s)]
        s = s[1:]
        // 遍历，也适用于map
        for i, v := range pow {}                // 下标i，值v
        for i := range pow {}                   // 只需要下标
        for _, v := range pow {}                // 只需要值，忽略下标

        // s []byte为24byte，s [1024]byte为1024byte
        ```
   - 二维slice
        ```go
        game := [][]string{                     // 定义
            []string{"x",},
            []string{"x",},
        }
        game[0][0] = "X"                        // 赋值
        ```
1. map
   - 认识：字典，键值对，`map[keyType]valueType`，key没有顺序，key唯一
     1. 遍历输出顺序与填充顺序无关，不要期望输出顺序的结果
        ```go
        // 此情况value是一个结构体，可以是其他的基础类型
        type Vertex struct {
            Lat, Long int
        }

        // 定义
        var m map[string]Vertex
        m = make(map[string]Vertex)
        // 定义、赋值
        var m = map[string]Vertex{
            "a": {1, 2},
            "b": vertex{5, 6},
        }

        // 获取
        m["key"]
        // 插入或修改
        m["a"] = Vertex{1, 2}
        // 删除
        delete(m, "key")
        // 检测是否存在，双赋值，ok为bool指示是否存在
        v, ok = m["key"]
        if ok {}
        ```
1. 变量
   - 认识：var或者:=
     1. 类型在变量名后边，避免了类c的含糊不清的定义
     1. 默认类型推导
   - 举例
    ```go
    // 声明变量
    var i,j int = 1,2       // 声明、赋值
    k := 3                  // 简短格式：短声明 + 类型推导
    var (                   // 批量格式
        i int = 1
        j float32
    )


    var i,j = 1,true        // 类型推导
    ```
   - 特点
     1. _：匿名变量，类似黑洞，可像其他标识符那样用于变量的声明或任何类型都可以给它赋值，但任何赋给这个标识符的值都将被抛弃，可极大增强代码灵活性
     1. 变量类型转换：必须是显式的，只能发生在两种兼容的类型之间，如int和bool不可以。`a := int32(b)`
     1. 作用域：局部(函数内)、全局(函数外)、形式参数(函数定义中)
1. 常量
   - 认识：const，是程序运行时不会被修改的简单值的标识符
     1. 只能是string、bool、数字类型(整数、浮点、复数)
     1. 常量表达式中只能是内置函数，自定义的会报错
     1. 会自动类型推导，分显式类型和隐式类型定义
   - 定义：`const identifier [type] = value`
    ```go
    const PI = 3.14
    const i,j = 1,true
    const (
        a int = 1
        b int = 1
    )

    const c = len(b)    // 通过内置函数定义
    ```
   - iota：无类型整数常量，可被编译器修改，iota在const关键字出现时将被重置为0，在下一个const出现之前，每出现一次iota则iota+1，`const a = iota`
     1. 跳值使用法
        ```go
        const (
            a = iota
            _ = iota        // 跳过了，b为2，中间不想有其他常量，黑洞嘛
            b = iota
        )

        const (             // 简写，输出为012
            a = iota
            b
            c
        )
        ```
     1. 插队使用法
        ```go
        const (
            a = iota
            b = 1           // 独立值，iota += 1，输出为012
            c = iota
        )
        ```
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
        - 特点
          1. 默认匹配跳过剩下的case，不用加break，取消break用fallthrough
          1. case后的所有val必须为同一类型或最终结果为相同类型的表达式
        - 实例
            ```go
            switch os := runtime.GOOS; os {
            case "darwin":                      
                return 1
            case "linux", "mac":                // 可写多个
                return 1
            case f():
                return 1
            default:
            }
            
            // type-switch，判断某个interface变量的实际变量类型
            switch x.(type){
            case type:
                statement(s);
            case type:
                statement(s);
            default:
                statement(s);
            }
            // 实例
            switch i := x.(type) {
            case nil:
                fmt.Printf(" x 的类型 :%T",i)
            case int:
                fmt.Printf("x 是 int 型")
            default:
                fmt.Printf("未知型")
            }
            ```
   - 循环：不能使用()
     1. for
        ```go
        // 形式
        for init; condition; post {}        // 赋值表达式、关系表达式或逻辑表达式(循环控制条件)、赋值表达式
        for condition {}
        for {}


        sum := 0
        for i := 0; i < 10; i++ {
            sum += i
        }
        // 无限循环
        for {}
        for true{}
        ```
     1. range：后边跟一个可循环的，自动类型推断，可针对string、array、slice、map
        ```go
        a := []string{"a","b"};
        for key,value := range a{}
        for _,value := range a{}
        ```
     1. while：for代替，没有分号
        ```go
        for sum < 1000 {
            sum += sum
        }
        ```
     1. 循环控制
        - break：中断当前循环
        - continue：跳过当前循环
        - fallthrough：强制执行后面的case代码，不能用在最后一个分支上
        - goto：跳跃
            ```go
            goto LABEL;
            ...
            LABEL: statement;       // 标记点，后边是表达式

            // 无限循环
            goto LABEL
            LABEL:
            LABEL:
            goto LABEL
            ```
   - 延迟
     1. 认识：defer，会延迟函数的执行直到上层函数返回。所有的defer会压入栈中，先入后出，一般用于异常处理、释放资源、清理数据、记录日志等
        - 每次defer语句执行时，defer修饰函数的返回值和参数取值会照常进行计算和保存，但是defer修饰的函数不会执行，同时丢弃被修饰函数的返回值
        - 如果被修饰函数的值为nil，会在该函数执行时panic，不会在defer执行时panic。被修饰函数的上一级函数即使抛出异常，被修饰函数也会执行，确保资源被合法释放
        - 有一定开销, 为节省性能可避免使用
     1. 应用
        ```go
        // 简化资源回收，安全回收资源
        mu.Lock() 
        defer mu.Unlock()
        // 捕获panic异常
        // 函数return后修改返回值
        ```
     1. 实例
        ```go
        defer fmt.Println("world")
        fmt.Println("hello")
        ```
1. func 函数
   - 认识：`func xx() [T]{}`，是基本的代码块
     1. 可以返回多个值
     1. 函数参数：值传递(默认)、引用传递
     1. 方法：包含了接受者的函数，`func (variable_name variable_data_type) function_name() [return_type]{}`
   - 实例
    ```go
    // 定义函数
    func add(x int, y int) int {            // 参数类型，返回值类型
        return x + y
    }
    // 调用
    aFunc()
    // 直接执行函数
    func() {
    }()

    // 返回多个值
    func aFunc() {
        return x, y
    }

    // 可变参数，value是形参名称，类型统一
    func add(value...int) {
        for _,v := range value {}
    }

    // 函数变量
    hypot := func(x, y int) int {}

    // 匿名函数，可作闭包，函数内变量保留
    func adder() func(int) int {
        i:=0
        return func(x int) int {
            i += x
            return i
        }
    }
    pos := adder()
    pos(i)                              // 使用匿名函数

    // 方法
    type Circle struct {                // 定义结构体
        radius float64
    }
    func (c Circle) getArea() float64 { //method 属于 Circle 类型对象中的方法
    ```
   - 闭包
     1. 认识：定义在一个函数内部的函数，是将函数内外部连接起来的桥梁
     1. 实例
        ```go
        // 上边的普通型，参数和返回值中间加个func()

        // defer模拟
        x, y := 1,2
        defer func(a int){
            fmt.Println("defer x, y = ", a, y)  //y为闭包引用
        }(x)                                        //x值拷贝 调用时传入参数
        x += 100
        y += 200
        fmt.Println(x, y)

        // 多个匿名函数
        func calc(base int) (func(int) int, func(int) int) {
            add := func(i int) int {
                return base
            }
            sub := func(i int) int {
                return base
            }
            return add, sub
        }
        f1, f2 := calc(100)

        // goroutine模拟：闭包 + goroutine的死锁，goroutine未启动前，变量已经改变
        ```
   - 内嵌函数
     1. `len(v T)`：长度，string、array、slice、map、chan、pointer(指向元素的数量)
     1. `cap(v T)`：容量，array、slice(返回cap)、chan、pointer(指向元素的数量)
     1. `append(slice []T, elems ...T)`、copy(Dst, Src)：slice，容量够重新分配地址以容纳新元素，不够分配新底层数组，变长参数
        ```go
        append(x,4,5,6)                     // 支持多个参数
	    append(x,y...)                      // 只支持两个参数，表示把y作为x的类型进行添加
        ```
     1. `delete(m map[T]T1, key T)`：map
     1. make
        - 认识：可以创建slice、map、chan三种类型，即让帮忙将数据初始化好，返回引用类型
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
     1. 异常
        - `func panic(v interface{})`
        - `func recover() interface{}`
     1. 复数相关
        - `func complex(r, i FloatType) ComplexType`
        - `func real(c ComplexType) FloatType`
        - `func imag(c ComplexType) FloatType`
     1. `func close(c chan<- Type)`：关闭，chan
1. * 指针
   - 认识：`var ptr_name *T`，保存变量的内存地址，即间接引用。指针类型*T是指向类型T的值的指针，零值是nil
   - 特点
     1. 二级指针：指向指针的指针变量，第一个指针存放第二个指针的地址，第二个指针存放变量的地址，`var pptr **int`
     1. 值传递和指针传递
   - 分类
     1. *：普通类型，只能传递对象地址
     1. unsafe.Pointer：通用类型，用于转换不同类型的指针，不能进行指针运算，不能读取内存存储的值
     1. uintptr：运算类型，用于指针运算，GC不把uintptr当指针，无法持有对象，表示的地址的数据可能被GC回收
   - 指针数组
     1. 指针数据：是数组，数组中全是指针
        ```go
        a := []int{10,100,200}
        var i int
        var ptr [3]*int;        // 指针数组
        ptr[i] = &a[i]
        ```
     1. 数组指针：是指针
        ```go
        arr := make([]int, 2)
        arrPoint := &arr
        ```
   - 结构体指针
     1. 结构体指针方法和值方法调用时形式上没有区别，一个可以改变结构体内部状态另一个不会。指针方法使用结构体值变量可以调用，值方法使用结构体指针变量也可调用
     1. 通过指针访问内部字段需要2次内存读取操作，第一步取得指针地址，第二步读取地址内容，比值访问要慢。但在方法调用时，指针传递可避免结构体的拷贝操作，结构体比较大时，性能差距会比较明显
     1. 一些特殊结构体不允许被复制，如结构体内部包含锁时，这时就必须使用它的指针形式来定义方法，否则会发生一些莫名其妙的问题
   - 实例
    ```go
    var ptr *int      // 声明指针类型，ptr是指针变量名

    i := 42
    ptr = &i          // 赋值指针一个作用对象
    *ptr              // 读取i，*又变为取值运算符
    *ptr = 21         // 设置i
    ```
1. 错误和异常
   - 错误处理：通过内置的error接口作为错误处理的标准模式，如果函数要返回错误，则返回值类型列表中肯定包含error。为nil时表示成功；非nil表示错误
    ```go
    // 定义
    type error interface {
        Error() string
    }
    // 抛出
    func Sleep() (int,error) {
        return 0, errors.New("xxxx")
    }
    // 使用
    i, err := strconv.Atoi("42")
    if err != nil {}
    ```
   - 异常
     1. 认识：`panic recover`，抛出、接收异常
        - panic：可中断原有的控制流程，进入panic流程中
          1. 已经载入的defer函数会正常执行
          1. 可手动触发，可运行时错误产生，如访问越界的数组
          1. panic无法跨协程, 当前协程产生的异常, 必须由当前协程处理，没有用recover捕获的话，进程打印异常信息后直接退出
          1. panic可以嵌套
        - recover：可以捕获到panic的输入值，让进入panic流程中的goroutine恢复正常执行
          1. 只能在defer语句中使用，直接使用返回nil没有任何效果
          1. recover后, 当前函数panic后面没执行的代码也不会再继续执行
     1. 实例
        ```go
        // 定义
        func panic(interface{})//接受任意类型参数 无返回值 
        func recover() interface{}//可以返回任意类型 无参数

        // 实例
        defer func() {                  // 直接执行的匿名方法
            msg := recover()            // 捕获，判断类型
            switch msg.(type) {
                case string:
                    fmt.Print("string", msg)
                case error:
                    fmt.Print("error", msg)
                default:
            }
        }()
        panic("haha")                   // string类型
        panic(errors.New("kuku"))       // error类型
        ```
   - 比较
     1. 在错误处理上采用了与c类似的检查返回值方式
     1. 异常定义为无法预测的，几乎不可能失败但是特殊条件下也没法返回错误，也无法继续执行
1. 反射
   - 认识：reflect，反射是在运行时动态的针对对象，获取属性、调用方法，go是静态类型的语言
     1. go的反射是基于interface的
     1. go会记录变量的类型等信息
     1. 应用在必须传参类型不固定的场景下（业务开发一般用不到）
   - 最佳实践
     1. 尽量避免使用，涉及内存copy、内存逃逸，性能相对差，导致代码可读性变差
     1. 优先使用TypeOf，不会产生内存逃逸，性能更高，ValueOf包含了TypeOf
     1. 一定注意不同的数据类型使用对应的函数，否则会导致panic
     1. 官方反射三定律
        - Reflection goes from interface value to reflection object.
        - Reflection goes from reflection object to interface value.
        - To modify a reflection object, the value must be settable.
   - 应用
     1. orm库、json序列化库、运行时
   - 组成
     1. 类型
        - `reflect.Kind`：内置元类型，表示reflect包中定义的十几种，每种有一个整数编号
        - `reflect.Type`：接口
        - `reflect.Value`：结构体类型
     1. 基础反射方法
        - reflect.TypeOf()：，`func TypeOf(v interface{}) Type`，返回type对象
        - reflect.ValueOf()：`func ValueOf(v interface{}) Value`，返回value结构体
          1. CanSet()
          1. Elem()：指针指向的元素类型
1. 扩展类型
   - 组合扩展：struct组合之前的类型
   - 别名扩展：type定义别名再扩展
### 面向对象
1. struct
   - 理解：结构体，`type struct`，字段的组合
     1. 字段标签：tag，不是注释是描述字段的元数据。不属于数据的组成部分是类型的组成部分
        ```go
        type user struct {
            name string `昵称`
            age  int    `年龄`
        }
        ```
     1. 结构体方法
        - 定义在结构体作用域外，在函数声明中指定接收者，除了基础类型或其他包的，可以在任意类型里定义方法
        - `func (variable_name variable_data_type) function_name() [return_type]{}`
     1. 匿名组合：类似继承
        ```go
        // 结构体组合
        type Animal struct{
            Color string
        }
        type Dog1 struct{
            Animal                  // 匿名组合：可以直接用父结构体的属性和方法
            name string
        }
        dog.Color = "1"             // 直接使用

        type Dog2 struct{
            someAnimal Animal       // 把父结构体作为一个属性使用
            name string
        }
        ```
     1. 不支持多态
   - 实例
    ```go
    // 定义
    type Dog struct {
        x int               // 封装
        y int
    }

    // 赋值方法1
    dog := Dog{x: 1}               	// 指定字段，y:0可以被省略
    dog := Dog{1, 2}
    dog := Dog{}                    // 都用零值初始化
    // 赋值方法2
    dog := new(Dog)
    var dog *Dog = new(Dog)         // 返回的是指针类型
    dog.x = 1
    // 赋值方法3
    var dog Dog
    dog.x = 1

    // 访问
    dog.x

    // 添加方法
    func (d *Dog) Run {}            // 函数名前加接受者
    func (d Dog) Run {}				// 深拷贝，会复制一个出来

    var p *Dog
    p = &Dog{1, 2}                  // 类型为 *Dog
    ```
1. interface 接口
   - 理解：接口类型是一组具有共性的方法定义在一起的集合。即抽象、封装、多态
     1. ‌是派生类型
     1. 接口是松散的结构，不与定义绑定，可以同时从多个维度对数据进行抽象，找出共同点，并使用同一套逻辑来处理。弱关联关系，接口已经可以在很多方面替代继承的作用，比如多态和泛型，而且接口的关系松散、随意，可以有更高的自由度、更多的抽象角度。
   - 接口实现：接口的实现都是隐式的，实现接口了的所有方法就隐式地实现了接口，是duck-type编程的一种体现，不关心属性（数据），只关心行为（方法）
     1. 没有了显式声明的必要。解藕了实现接口的包和定义接口的包
     1. 结构体指针实现接口，结构体初始化变量不会编译通过，因为go的传参值拷贝特性，全新的变量不会指向原来的结构体，也就找不到了，所以提示未实现接口
        - 反之则可以，因为可以隐式的对变量解引用（dereference）获取指针指向的结构体
        - 实现接口的具体方法时，如果以指针作为接收者，接口的具体实现类型只能以指针方式使用，值接收者既可以按指针方式使用也可以按值方式使用
   - 接口变量赋值
     1. 认识：要保证这个值实现了接口的所有方法，在使用接口时，我们要将接口看成一个特殊的容器，这个容器只能容纳一个对象，只有实现了这个接口类型的对象才可以放进去
     1. 方式
        - 实现接口的对象实例赋值给接口
        - 另外一个接口赋值给接口
   - 空接口类型：`interface{}`，可用于存储任意数据类型的实例，达到抽象数据类型的目的
     1. 所有的数据类型都实现了空接口，参数是的话表明以使用任何类型的数据，函数内部该变量仍然为空接口类型，而不是传入的实参类型
     1. 类型断言：即接口类型向普通类型的转换，运行期确定
        ```go
        func printArray(arr interface{}){
            a,ok := arr.([]int)                 //通过断言实现类型转换，同时加上判断，房子断言失败导致运行错误
            if ok {}
        }
        ```
   - 接口组合：继承，和struct一样，支持组合
    ```go
    // 接口组合,默认继承了IReader和IWriter中的抽象方法
    type IReader interface {
       Read(file string) []byte
    }
    type IWriter interface {
        Write(file string, data string)
    }

    type IReadWriter interface {
        IReader
        IWriter
    }
    ```
   - 实例
    ```go
    // 定义
    type ISayHello interface {
        sayHello()
        sayGoodbye()
    }
    // 实现
    type AmericalPerson struct {}
    func (person AmericalPerson) sayHello(){
        fmt.Println("Hello！")
    }
    func (person AmericalPerson) sayGoodbye(){
        fmt.Println("Goodbye！")
    }
    // 使用
    ameriacal := AmericalPerson{}
    var i ISayHello                             // 1. 定义接口变量
    i = ameriacal                               // 2. 赋值给变量，即ameriacal实现了ISayHello
    i.sayHello()                   
    ```
   - 内置接口
     1. Stringer
        ```go    
        type Person struct {
	        name string
	        age int
        }

        func (p Person) String() string {                                   // 改变了结构体输出时的样式，Stringer是一个用字符串描述自己的类型
	        return fmt.Sprintf("(name is %v) (%v years)", p.name, p.age)
        }

        func main() {
            a := Person{"Arthur Dent", 42}
            z := Person{"Zaphod Beeblebrox", 9001}
            fmt.Println(a, z)
        }
        ```
     1. error
### 协程
1. goroutine：go的协程(coroutine)，协程间需要通信、同步，是并行运行的(多处理器同时)，需要的内存极小，实际可以cpu核数减一来设置，给系统留下
    ```go
    go say("hello")
    go say("world")
    ```
1. 认识
   - 并行与并发：并发只是假装同时进行
   - 协程调度模仿的就是linux的进程调度，在其之上自己实现了一套。m是machine相当于cpu，g相当于进程，g在m上运行，p按照规则自己给自己做调度，调度室代码+数据
   - io密集的可以使用协程如读数据库，cpu密集的就不要了比如网站的逻辑层
   - 协程的意义
     1. 不必陷入内核态，而且占用资源少、切换快，堆当栈用
     1. 其他操作耗时的时候让出cpu，不用等待
     1. 给了我们自己调度的自由
1. channel
   - 认识：有类型的管道，用于协程间通信。使得goroutine可以在没有明确的锁或竞态变量的情况下同步
     1. 默认另一端准备好之前发送和接收都会阻塞
     1. 无缓冲channel
        - 读时没有数据会阻塞
        - 没有取数据时goroutine会阻塞
        - 读写不能放一个协程里，写读颠倒会死锁
     1. 是nil的channel：发送、接收数据，造成永远阻塞 
     1. 已关闭的channel
        - 发送数据，引起panic 
        - 接收数据，返回channel中缓存的值，如果通道中无缓存，返回0
   - 定义
        ```go
        ch := make(chan int)
        ch <- v                     // 写
        v := <- ch                  // 读

        // 单向通道
        var send chan <- int         // 只能发送
        var receive <- chan int      // 只能接收
        ```
   - 缓冲
        ```go
        ch := make(chan int, 100)   // 有缓冲通道，只有缓冲区满时才会阻塞，当缓冲区清空的时候接收操作会阻塞
        ch := make(chan int)        // 无缓冲通道/同步通道，即通道大小为0，不会存储数据
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
   - select：同时监听多个管道并收发消息，会阻塞直到条件分支中的某个可以继续执行。多个都准备好的随机选一个。可用于多个写入，一个读取场景
        ```go
        select {
            case c <- chName1:
            case <- quitChName:                         // 只要有数据，不管值是什么
            case <- time.After(5 * time.Second):        // 设置超时
            default:                                    // 其他分支没准备好的时候default分支会被执行，可用于非阻塞的发送或者接收
        }
        ```
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
        c.v[key]++          // Lock 之后同一时刻只有一个goroutine能访问 c.v
        c.mux.Unlock()
        ```
     1. 读写互斥锁：`sync.RWMutex`
     1. map：`sync.Map`
1. context：库，1.7加入，跟踪goroutine调用树，并在这些树中传递通知和元数据
   - 退出通知机制：传递给所有树节点
   - 传递数据：传递给所有树节点
### 包
1. package
   - 认识：包，封装，是最基本的分发单位和工程管理中依赖的体现，提供更好的可重用性与封装性
   - 定义
     1. 程序必须以package开头，用来表示所属代码包，`package packageName`
     1. 同一个目录下包名必须相同，一个包可拆成多个源文件，即同一个目录下可有多个文件
     1. 可执行的程序必须有main包，并且main包有main函数
     1. 首字母大小写来区分包的可见性，首字母大写的名称是被导出的可被其他包读取的
   - 导入
     1. 认识：import，`import path`，顺序导入有依赖的包，两种导入方式，导入未使用的包会报错，包只会被导入一次，import只有这一个功能
        - 先导入最上层依赖的包
        - 然后初始化包中常量和变量
        - 所有包可包含一个没有任何返回值和参数的不能显式调用的导入时自动执行的init函数
        - 所有包导入完成后，对main初始化常量和变量、执行init方法
     1. 导入方式
        ```go
        import "fmt"
        import "math"
        // 多包导入，推荐
        import (
            "fmt"
            "math"
            "math/rand"         // 导入某一个包

            xx "math"           // 别名
            . "math"            // 调用该包函数可省略包名，不建议用，容易迷惑
            _ "math"            // 不导入整个包，只执行init函数，用来注册包中引擎
        )
        ```
   - 导出：package，可执行命令必须使用main包
1. 标准库
   - 语法相关
     1. unsafe
        - 认识：不安全的直接操作内存，避免使用，只有两个类型，三个函数
          1. 内存对齐：每种类型占用内存不同，结构体8byte对齐，占不满8byte的不连续的独占，连续的n个类型共同8byte
        - 组成
          1. 类型
             - `type ArbitraryType int`：int别名，代表一个任意go表达式类型
             - `type Pointer *ArbitraryType`：int指针类型别名，可理解成任何指针的父类型
          1. 函数
             - `unsafe.Sizeof()`：接受任意类型的值或表达式，返回其占用的字节数
             - `func Offsetof(x ArbitraryType) uintptr`：返回结构体中元素所在内存的偏移量
             - `func Alignof(x ArbitraryType) uintptr`：返回变量对齐字节数量，对齐因子
        - 用法
            ```go
            // 修改、读取不可访问的私有变量
            func GetDemoStruct() DemoStruct {                                                   // 获取一个DemoStruct对象
                return DemoStruct{age: 21, Name: "hong", Id: 2, Man: false, china: true}
            }
            func changeUnreadField()  {                                                         // 修改不可读取的变量
                demo := common.GetDemoStruct()
                fmt.Println("demo is ",demo)
                *(*uint8)(unsafe.Pointer(uintptr(unsafe.Pointer(&demo)) + 32) ) = 100           // 32是结构体的内存偏移量
                fmt.Println("demo now is ",demo)
            }

            // 绕开编译器的对类型做强制转换
            func Float64ToUint64(f float64) uint64 {
                p := unsafe.Pointer(&f)                     // 拿到指向f的指针(通过f的地址拿到可操作的指针Pointer)
                p2 := (*uint64) (p)                         // 将指针(*float)转换为uint64指针(*uint64)类型。因为uint64为无符号位，所有能够拿出当前64位bit内容
                return * p2
            }
            
            // 保存任意类型，用于系统函数交互、cgo等
            syscall.Syscall(SYS_READ, uintptr(fd), uintptr(unsafe.Pointer(p)), uintptr(n))
            ```
        - 最佳实践
          1. 类型转换必须是可相互转的类型，否则panic
          1. uintptr指针失效
            ```go
            func UitptrDisable() {
                demo := common.GetDemoStruct()
                //引入临时变量
                tmp := uintptr(unsafe.Pointer(&demo)) + 32
                demoAge := (*uint8)(unsafe.Pointer(tmp))
                demoAge = nil                                   //临时变量可能会被gc回收
                *demoAge  = 98
                fmt.Println("demo now is ",demo)
            }
            ```
     1. reflect
     1. fmt
        - 认识：类似c的printf和scanf的格式化I/O
          1. 格式化动作('verb')源自c但更简单
          1. scann扫描格式化文本以生成值
        - 方法分类
          1. print：输出到标准输出流，支持多个参数输出
             - 后边加f：根据format参数，默认采用默认格式
             - 前边加F：写入给定源，默认写入标准输出
             - 后边加Ln：总是用空格分隔，并且加换行符
             - 前边加S：返回该字符串
          1. scann
          1. Errorf 
     1. errors
        - `errors.New("xxxx")`
     1. builtin：为go的预声明标识符提供文档
     1. bytes：实现操作[]byte的常用函数
     1. sort：切片、集合的排序操作
     1. expvar：提供公共变量的标准接口
   - 文本相关
     1. text
     1. encoding：编码
        - json
        - xml
        - base64
        - base32
        - csv：csv读写逗号分隔值（csv）的文件.
        - hex：hex包实现了16进制字符表示的编解码.
        - binary：实现数字与字节序列的转换、变长值的编解码

        - ascii85：ascii85数据编码
        - asn1：DER编码的ASN.1数据结构
        - gob：gob流——在编码器（发送器）和解码器（接受器）之间交换的binary值.
        - pem：PEM数据编码
     1. unicode：提供测试Unicode码点属性的数据和函数
        - utf16
        - utf8
     1. html：转义和解转义HTML文本的函数
        - template：实现数据驱动模板，用于生成可对抗代码注入的安全html输出
     1. mime：实现了MIME的部分规定
        - multipart：实现MIME的multipart解析
        - quotedprintable

     1. regexp：正则
        - syntax
     1. strings：操作字符
     1. strconv：基本数据类型和其字符串表示的相互转换
        - `strconv.Quote("xx")`：可以输出双引号
   - 编码相关
     1. compress：解压缩
        - zlib
        - gzip
        - bzip2
        - flate：deflate压缩数据格式
        - lzw：Lempel-Ziv-Welch数据压缩格式
     1. crypto：加解密
        - rand：实现用于加解密的更安全的随机数生成器

        - md5
        - sha1
        - sha256：实现SHA224和SHA256哈希算法
        - sha512：实现SHA384和SHA512哈希算法

        - des：实现DES标准和TDEA算法
        - aes

        - rsa：RSA加密算法
        - dsa：DSA算法
        - ecdsa：实现椭圆曲线数字签名算法

        - hmac
        - tls

        - cipher：实现多个标准的用于包装底层块加密算法的加密算法实现
        - elliptic：实现几条覆盖素数有限域的标准椭圆曲线
        - rc4：RC4加密算法
        - subtle
        - x509：x509包解析X.509编码的证书和密钥.
        - pkix：pkix包提供了共享的、低层次的结构体，用于ASN.1解析和X.509证书、CRL、OCSP的序列化.
     1. hash：哈希函数
        - adler32
        - crc32
        - crc64
        - fnv：实现了FNV-1和FNV-1a（非加密hash函数）
   - io相关
     1. io：提供i/o原语的基础接口
     1. bufio：带缓存增强版，如可读取一行
     1. path：路径
        - filepath：兼容各操作系统文件路径的实用操作函数
     1. archive：文件解压缩
        - `archive.tar`
        - `archive.zip`
   - net
     1. 子包
        - http：提供http客户端和服务端的实现
          1. cgi：实现RFC3875协议描述的CGI（公共网关接口）
          1. fcgi：实现FastCGI协议
          1. httputil：提供http公用函数，是http的函数补充
          1. cookiejar：实现保管在内存中的符合RFC 6265标准的httpCookieJar接口
          1. pprof：返回runtime的统计数据，返回pprof可视化工具规定的格式
          1. httptest：http测试的单元工具
          1. httptrace
        - url
        - rpc
          1. jsonrpc
        - mail：解析邮件消息
        - smtp：简单邮件传输协议
        - textproto：实现对基于文本的请求/回复协议的一般性支持
     1. 核心功能
        - Conn：使用goroutines保证请求独立性
        - ServeMux：数据路由
     1. ip：`addr := net.ParseIP()`
     1. web服务器
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
   - 常用
     1. time
        - `time.Now()`
        - `time.Sleep(time.Second * 5)`
     1. database/sql：数据库驱动的标准接口
   - 系统相关
     1. os
        - 子包
          1. exec：执行外部命令
          1. signal：对输入信号的访问
          1. user：查询用户帐户
        - 目录：Mkdir/MkdirAll/Remove/RemoveAll：`os.Mkdir("a", 0777)`
        - 文件
          1. Create/NewFile
          1. Open/OpenFile
          1. Read/ReadAt
          1. Write/WriteString
          1. Remove
        - Reader接口：`func (T) Read(b []byte) (n int, err error)`，数据填充指定字节的slice，数据流结尾返回io.EOF错误
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
     1. syscall
     1. log：简单的日志服务
        - syslog：简单的系统日志服务的接口
     1. sync：互斥锁的同步原语
        - atomic：底层的原子性内存原语
     1. flag：命令行标签解析
   - 语言相关
     1. runtime
        - 子包
          1. cgo：含有cgo工具生成的代码的运行时支持
          1. debug：debug包含有程序在运行时调试其自身的功能
          1. pprof：按照可视化工具pprof所要求的格式写出运行时分析数据
          1. race：实现数据竞争检测逻辑
          1. trace：Go execution tracer
        - 组成
          1. `runtime.GOMAXPROCS`：使用最大核心数
          1. `runtime.NumCPU`：cpu核心数
          1. `runtime.Gosched()`：使goroutine让出cpu时间片
          1. `runtime.Goexit()`：使goroutine立即终止
          1. NumGoroutine
     1. go：语法包
     1. debug：调试包
        - dwarf
        - elf
        - gosym
        - macho
        - pe
        - plan9obj
     1. plugin：go的组件包
     1. testing：go包的自动测试支持
        - iotest
        - quick
   - 其他
     1. container：数据结构
        - heap：任意类型的堆操作
        - list：双向链表
        - ring：环形链表
     1. math
        - 子包
          1. big：大数的高精度运算
          1. cmplx：为复数提供基本常量和数学函数
          1. rand：伪随机数生成器
        - 组成
          1. `math.Nextafter(2, 3)`
          1. `rand.Intn(10)`："math/rand"
     1. image
        - 子包
          1. color：基本的颜色库
             - palette：标准的调色板
          1. draw：提供组装图片的方法
          1. gif
          1. jpeg
          1. png
        - 实例
        ```go
        m := image.NewRGBA(image.Rect(0, 0, 100, 100))
        m.Bounds()
        m.At(0, 0).RGBA()
        ```
     1. index	    	
        - suffixarray：suffixarrayb包通过使用内存中的后缀树实现了对数级时间消耗的子字符串搜索
1. 其他包
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

        // 另一个例子
        type User struct {
            Name        string `json:"name"`
            Age         int    `json:"age,omitempty"`
            IgnoreField int    `json:"-"`
            ID          int64  `json:"id,string"`
        }

        u := User{
            Name:        "zhangsan",
            Age:         10,
            IgnoreField: 88,
            ID:          374827929374927394,
        }

        byts, err := json.Marshal(u)
        if err != nil {
            panic(err)
        }

        fmt.Println(string(byts))
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
   - socket：Socket数据传输是Unix特殊的I/O，分为流式Socket(SOCK_STREAM，面向连接，TCP)、数据报式Socket(SOCK_DGRAM，无连接，UDP)
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
     1. 连接控制：DialTimeout、SetReadDeadline、SetWriteDeadline、SetKeepAlive
   - webSocket：go.net子包有，`golang.org/x/net/websocket`
   - rpc：标准包提供，支持三个级别：TCP、HTTP、JSONRPC，只支持go内部，使用Gob编码
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
1. 测试：go test和testing包
### 运维
1. 运行
   - 环境变量
     1. GOROOT：go的安装路径，可以不设置，默认在/usr/local/go，编译的时候从GOROOT找system libariry
     1. GOPATH：开发的工作空间，作为编译后二进制的存放目的地和import包时的搜索路径。必须设置，可以有多个。可以弄俩，第一个放第三方包(因为默认安装到第一个)，第二个自己的
        - src：源码目录，import时来src查找
        - bin：可执行命令，go get二进制文件下载的目的地
        - pkg：包对象，编译生成的lib文件存储的地方
     1. GO111MODULE：mod功能是否打开
        - off：使用$GOPATH/src或vendor
        - on：在$GOPATH/src不找也不存放，放在$GOPATH/pkg/mod，多项目可共享
        - auto：检测到go.mod就开启
     1. CGO_ENABLED
     1. 代理
        - `GOPROXY=https://proxy.golang.org,direct|off`
          1. 多个代理逗号分隔
          1. direct：回源到模块版本的源地址去抓取
        - `GOSUMDB=sum.golang.org|off`：校验是否被篡改

        - `GOPRIVATE=*.100tal.com`：设置不走代理的，GOPRIVATE会作为另外俩的默认值
        - `GONOPROXY=*.100tal.com`
        - `GONOSUMDB=*.100tal.com`
1. cli
   - 基础
     1. `go help`
     1. `go version`
   - 编写
     1. `go env`：查看当前go的环境变量
     1. `go fmt`：格式化代码文件
        - `gofmt -w src`：格式化src下全部
     1. `go doc`：用于查看文档
     1. `godoc -http=:8080`：生成本机的go官网，可用浏览器打开
     1. `go test`：自动读取源码目录下*_test.go文件，生成并运行测试用的可执行文件
     1. `go fix`：转换老版本的代码到新版本
     1. `go generate`：用于在编译前自动化生成某类代码
        - 写法举例：`//go:generate go tool yacc -o gopher.go -p parser gopher.y`
   - 调试
     1. `go bug`：调试
     1. `go tool`
        - `go tool compile -N -l -S main.go`：不优化编译，可用dlv调试
        - `go tool pprof`：性能检查工具
        - `go tool cover`
        - `go tool cgo`
     1. `go vet`：静态错误检查
   - 运行和编译
     1. `go run hello.go`：进行高速编译，用作脚本语言
     1. `go build`
        - 认识：用于测试编译
          1. 会同时编译依赖包，会在GOROOT/src和GOPATH/src搜索包，默认编译当前目录下的所有go文件，可指定要编译的文件名，会忽略_或.开头的go文件，会根据当前系统选择性地编译以系统名结尾的文件(_linux|darwin|windows|freebsd.go)
          1. 普通包不产生任何文件只做检查性编译，main包生成可执行文件
        - 参数
          1. -v：打印包名
          1. -o：指定输出的可执行文件
          1. -ldflags "-s -w"：-s 去掉符号信息。-w 去掉DWARF调试信息
          1. -gcflags "-N -l"：关闭内联优化
     1. `go install`：编译和安装，将编译好的结果移到$GOPATH/pkg或$GOPATH/bin。.a移到$GOPATH/pkg，可执行文件移到$GOPATH/bin中，给$GOPATH/bin添加PATH就可以直接执行了
        - `go install example.com/pkg@v1.2.3`：指定版本，忽略mod文件
     1. `go clean`：移除当前源码包里面编译生成的文件，如_obj/、_test/、test.out
   - 模块
     1. `go get`
        - 认识：动态获取远程代码包，包含clone和install，不推荐使用。本质是先通过源码工具clone代码到GOROOT/src目录，然后执行go install
          1. 会回写go.mod文件，更新直接的模块依赖
          1. 会自动根据不同域名调用不同源码工具，如git或svn
        - 参数
          1. 支持build的参数
          1. `golang.org/x/text@latest`：指定包名和版本
             - latest：拉取最新的版本，若存在tag，则优先使用
             - master：拉取 master 分支的最新 commit
             - v0.3.2：指定tag
             - 342b2e：指定commit，最终转换为tag
             - none：
          1. `-u`：强制使用网络更新直接或间接的依赖模块
          1. `-t ./...`：包括单元测试中用到的
          1. `-d`：不构建或安装，只下载
          1. `-v`：显示执行的命令
     1. `go list`：查看安装的packag
1. 依赖管理
   - Go Module
     1. 认识：官方的包依赖版本管理工具，前身vgo
        - 支持vendor、GOPATH
        - go命令内置对模块的支持
        - 至少1.11及以上版本，最好1.13或以上，撑13以下是老版本，哈哈
     1. 组成
        - go.mod文件，可以将工程从GOPATH中移出来
            ```conf
            module rsc.io/hello                                             // 模块名

            go 1.12

            require (
                golang.org/x/text v0.0.0-20180208041248-4e4a3210bb54
                rsc.io/quote v1.5.2
                github.com/BurntSushi/toml v0.4.1 // indirect               // 表示该模块为间接依赖
            )

            replace (                                                       // 指定替换包
                golang.org/x/text => github.com/golang/text v0.3.0
            )
            exclude example.com/thismodule v1.3.0                           // 从使用中排除特定模块版本
            ```
        - go.sum文件：用来校验文件，都是命令行自动操作
     1. 命令：`go mod <command> [arguments]`
        - init：初始化

        - tidy：整理，需要的加，不要的删
        - download：下载
        - edit -module/require/version/print xx：手动修改依赖文件
        - vendor：导出依赖放入vendor目录
        - verify：验证是否被篡改过

        - graph：查看现有的依赖结构
        - why：查看为什么需要依赖某模块
   - 发展
     1. 阶段
        - GOPATH：所有包必须放GOPATH目录下，无法支持不同版本包存在
        - Vendor：工程子目录存放依赖包，没有版本记录
        - Module：官方指定默认开启
     1. 时间线
        - 13年：Godep
        - 16年：vendor机制 默认开启，v1.6
        - 17年：Dep作为准官方试验
        - 18年：Modules作为官方试验，v1.11
        - 19年：默认开启Go Mod，v1.13
   - 其他
     1. dep
        - 认识：实现了tag管理代码，而不是trunk/mainline，如go get下载的代码
          1. 依赖管理工具为应用管理代码，而go get为GOPATH管理代码
        - 组成
          1. `Gopkg.toml`：配置文件，可以手工修改
          1. `Gopkg.lock`
          1. vendor：依赖管理目录，vendor属性是go编译时，先从项目根目录的vendor目录查找代码，有则不再去GOPATH中查找
        - 命令
          1. `dep init`：初始化新项目
          1. `dep status`
          1. `dep check`：检查toml和lock文件是否同步
          1. `dep ensure`
             - `dep ensure`：安装依赖
             - `dep ensure -update`：更新依赖
             - `dep ensure -add github.com/pkg/errors`：添加依赖
          1. `dep version`：dep的版本
     1. godep：Godeps/Godeps.json
     1. glide：glide.yaml、glide.lock，官方建议迁移到dep
     1. govendor
     1. gvt
1. 部署
   - supervisor来管理go程序，go自己用异常捕捉来处理
   - 打包linux的：`CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build main.go`
### wiki
1. 关键字和标识符、符号：程序一般由关键字、常量、变量、运算符、类型和函数组成
   - 关键字：25个
     1. var、const、map、struct、type
     1. if、else、for、range、switch、case、fallthrough、break、continue、default
     1. goto、defer
     1. func、interface、return
     1. go、chan、select
     1. package、import
   - 标识符：39个
     1. 分类
        - 空白标识符：_，用作匿名占位
        - 预先声明的标识符
          1. 类型
             - bool、byte、string、uintptr
             - int、int8、int16、int32、int64、uint、uint8、uint16、uint32、uint64、float32、float64、complex64、complex128
             - error、rune
          1. 常量
             - true、false、iota
          1. 零值
             - nil
          1. 方法
             - len、cap
             - append、copy、delete
             - print、println：输出到标准错误流，不建议写程序使用，debug可以用
             - make、new、close
             - panic、recover
             - complex、real、image
1. 历史
   - 07年开发
   - 09年开源
   - 12年1.0稳定版本
   - 14年1.4版本
   - 1.8
     1. 移除yacc工具，使用goyacc
   - 1.11
     1. 库文件管理模块go module
1. wiki
   - 语法糖
     1. ...：可变参数
     1. :=：声明、赋值、类型推断
