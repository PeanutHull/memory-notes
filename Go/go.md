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
1. 原则
   - 通过通信共享内存，不要通过共享内存来通信
1. 编程范式
   - 面向接口
   - 函数式编程
   - 并发编程
1. 用途
   - 服务器编程：处理日志
   - 分布式系统：数据库代理器、NewSQL
   - 网络编程：Web应用、api应用
   - 内存数据库：groupcache、couchbase
   - 云平台：k8s
1. 示例
    ```go
    package main

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
     1. 双引号：表示字符串
     1. ``：表示多行文本
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
   - 复合类型：struct、array
   - 引用类型：Slice、Map、Channel、Pointer
   - 派生
     1. func
     1. interface
   - 特点
     1. 类型零值：变量无初始化时的默认值，可以表现为0，false，""，nil
     1. 类型推导：不指定其类型时，由右值推导得出
     1. 类型转换：T(v)，将值v转换为类型T，不同类型相互转换的时候需要显式转换
     1. 类型别名：type可以定义任何自定义的类型
     1. 类型比较：可不可以比较需要根据类型的特性去判断取舍
        - 不同类型不能比较
        - 不可比较的类型：slice、map
        - 如果复合类型中有不可比较的类型，那么复合类型就不可比较
        - 如果接口值的动态值不可比较，直接比较会panic
   - 实例
    ```go
    // 声明自定义类型
    type aStruct struct {}
    type Ia interface{}

    type aInt int                           // 一般类型声明，相当于类型别名。类型别名与原类型是两种类型，不能直接操作，需要进行类型转换
    type 字符串 = string
    type myFunc func(int) int               // 自定义一个叫myFunc的函数类型，函数的签名必须符合输入为int，输出为int。有时会使代码更加简洁
    newFunc := myFunc(sum10)                // newFunc是一个变量，变量类型为myFunc，值为sum10函数

    // 给新加的自定义int类型添加方法
    type myInt int
 
    func (mi myInt) IsZero() bool {
        return mi == 0
    }
    
    func main() {
        var a myInt
        a = 0
        fmt.Println(a.IsZero())        // true
    }

    // 给新加的自定义函数添加方法
    type myFunc func(int) int
 
    func (mf myfunc) sum(a,b int) int {
        c := a + b
        return mf(c)
    }

    type myFunc func(int) int
 
    // 用处举例：外部注入(干预)自定义handlerSum函数的执行过程
        1. 不变的共用的是sum方法
        1. 可以使得handlerSum接受的外部更抽象化，只要是继承实现了sum接口的变量就可以了，可以是一个struct变量，也可以是一个自定义函数类型变量
    func (f myFunc) sum (a, b int) int {
        res := a + b
        return f(res)
    }
    
    func sum10(num int) int {
        return num * 10
    }
    
    func sum100(num int) int {
        return num * 100
    }
    
    func handlerSum(handler myFunc, a, b int) int {
        res := handler.sum(a, b)
        fmt.Println(res)
        return res
    }
    
    func main() {
        newFunc1 := myFunc(sum10)
        newFunc2 := myFunc(sum100)
    
        handlerSum(newFunc1, 1, 1)    // 20
        handlerSum(newFunc2, 1, 1)    // 200
    }

    // 抽象化封装
    type sumable interface {
        sum(int, int) int
    }
    
    // myFunc继承sumable接口
    type myFunc func(int) int
    
    func (f myFunc) sum (a, b int) int {
        res := a + b
        return f(res)
    }
    
    func sum10(num int) int {
        return num * 10
    }
    
    func sum100(num int) int {
        return num * 100
    }
    
    // icansum结构体继承sumable接口
    type icansum struct {
        name string
        res int
    }
    
    func (ics *icansum) sum(a, b int) int {
        ics.res = a + b
        return ics.res
    }
    
    // handler只要是继承了sumable接口的任何变量都行，我只需要你提供sum函数就好
    func handlerSum(handler sumable, a, b int) int {
        res := handler.sum(a, b)
        fmt.Println(res)
        return res
    }
    
    func main() {
        newFunc1 := myFunc(sum10)
        newFunc2 := myFunc(sum100)
    
        handlerSum(newFunc1, 1, 1)    // 20
        handlerSum(newFunc2, 1, 1)    // 200
    
        ics := &icansum{"I can sum", 0}
        handlerSum(ics, 1, 1)         // 2
    }
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
   - 二维slice
    ```go
    // 定义
    s := [][]int{                     
        []int{1},
        []int{2},
    }

    // 赋值
    s[0][0] = 3                        
    ```
   - 使用
    ```go
    // 构造slice，分配一个零长度的数组并且返回一个slice指向这个数组
    s := make([]int, 5)                     // 5个0的元素，不会限制只有5个
    s := make([]int, 0, 5)                  // 0个元素，但是cap=5，返回的是数组切片分配的空间大小
    // 定义
    s := []int{}                            // 零值是nil，长度和容量是0
    // 赋值
    s := []int{2, 3, 5}
    // 访问
    a := s[i]
    // 修改
    s[i] = 1
    // 添加
    s = append(s, 2, 3, 4)
    // 删除，没有提供现成的，原理是以被删除元素为分界点，将前后两个部分的内存重新连接起来
    s = s[n:]                               // 删除头部n个
    s = append(s, a...)                     // 将a全部加入s中
    s = append(s[:i], s[i+n:]...)           // 删除中间n个，...表示多对使用
    s = s[:i+copy(s[i:], s[i+n:])]
    s = s[:len(s)-n]                        // 删除尾部n个
    // 取子切片
    s[1:4]
    s[0:1:4]
    s[:3]
    s[4:]
    s = s[:cap(s)]
    s = s[1:]
    // 遍历，也适用于map
    for i, v := range pow {}
    for i := range pow {}
    for _, v := range pow {}

    // s []byte为24byte，s [1024]byte为1024byte
    ```
1. map
   - 认识：字典，键值对，`map[keyType]valueType`
     1. key唯一
     1. key没有顺序，遍历输出顺序与填充顺序无关，不要期望输出顺序的结果
     1. map是引用类型，引用类型的变量未初始化时默认的zero value是nil，此时写入值会导致运行时错误
   - 使用
    ```go
    // 此情况value是一个结构体，可以是其他的基础类型
    type Vertex struct {
        Lat, Long int
    }

    var m map[string]Vertex
    // 定义
    m := map[string]Vertex{}{}
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
    v, ok := m["key"]
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

    var i,j = 1,true        // 类型推导

    var (                   // 批量格式
        i int = 1
        j float32
    )

    k := 3                  // 简短格式：短声明 + 类型推导
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
        for i,v := range a{}                // 下标i，值v
        for i,v := range a{}                // 只需要下标
        for _,v := range a{}                // 只需要值，忽略下标

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
     1. 参数传递方式：值传递(默认)、引用传递
     1. 方法的定义：包含了接受者的函数，`func (variable_name variable_data_type) function_name() [return_type]{}`
     1. 没有可选参数，也不支持方法重载
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
     1. 认识：定义在一个函数内部的函数，闭包会保留局部变量的引用所以不释放值。闭包是将函数内外部连接起来的桥梁
        - 更为自然，不需要更多的修饰
        - 语法层面：没有lambda表达式，但是有匿名函数
     1. 斐波那契数列
        ```go
        func fibonacci() func() int {
            a, b := 0, 1
            return func() int {
                a, b = b, a + b
                return a
            }
        }

        func main() {
            f := fibonacci()
            fmt.Println(f())    // 1
            fmt.Println(f())    // 1
            fmt.Println(f())    // 2
            fmt.Println(f())    // 3
            fmt.Println(f())    // 5
            fmt.Println(f())    // 8
        }
        ```
     1. 实例
        ```go
        // 上边的普通型，参数和返回值中间加个func()
        // 定义
        var varClosure func() = func() {}

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
        - 认识：只用于slice、map、chan三种类型的内存分配，帮忙将数据初始化好，返回有初始值非零的T类型
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
        - 认识：用于各种类型的内存分配，传入的内存置零，返回传入类型的零值的指针
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
1. 函数式编程
   - 认识：go里函数是一等公民：参数、变量、返回值都可以是函数。c++只有函数指针，java函数只是一个名字无法传给别人
     1. 灵活性大大加强，原来写死的，都可以注入进去改变功能
     1. 方法是一种特殊的函数，可以为函数实现一些方法，从而实现一些接口
   - wiki
     1. 正统函数式编程：数学味道非常浓
        - 不可变性：不能有状态，只有常量和函数
        - 函数只能有一个参数
     1. 高阶函数：函数的参数也是函数
     1. go对函数式编程的支持体现在闭包上面
   - demo
     1. 为函数实现接口，将斐波那契函数包装成文件进行读取
        ```go
        // 利用闭包实现的斐波那契
        func fibonacci() intGen {                               // 这里可以将func() int替换为intGen
            a, b := 0, 1
            return func() int {
                a, b = b, a + b
                return a
            }
        }

        // 定义一个函数类型
        type intGen func() int

        // 函数实现了Reader接口
        func (g intGen) Read(p []byte) (n int, err error) {
            // 运行intGen本身获取值
            next := g()
            // 限制斐波那契运行上限
            if next > 10000 {
                return 0, io.EOF
            }
            s := fmt.Sprintf("%d\n", next)
            // s写进p中，让以下来代理read
            return strings.NewReader(s).Read(p)
        }

        // 负责读取操作
        func printFileContents(reader io.Reader) {
            scanner := bufio.NewScanner(reader)

            for scanner.Scan() {
                fmt.Println(scanner.Text())
            }
        }

        func main() {
            f := fibonacci()
            // fibonacci()函数返回intGen，同时intGen隐式实现Reader接口，所以可作实参
            printFileContents(f)
        }
        ```
1. * 指针
   - 认识：`var ptr_name *T`，保存变量的内存地址，即间接引用。指针类型*T是指向类型T的值的指针，零值是nil
     1. &a：取指针，获取指针
     1. *a：解指针，获取指针对应的值
   - 特点
     1. 二级指针：指向指针的指针变量，第一个指针存放第二个指针的地址，第二个指针存放变量的地址，`var pptr **int`
     1. 值传递和指针传递
   - 分类
     1. *：普通类型，只能传递对象地址
     1. unsafe.Pointer：通用类型，用于转换不同类型的指针，不能进行指针运算，不能读取内存存储的值
     1. uintptr：运算类型，用于指针运算，GC不将其当指针，无法持有对象，表示的地址的数据可能被GC回收
   - 指针数组
     1. 指针数据：是数组，数组中全是指针
        ```go
        var i int
        // 数组
        a := []int{10,100,200}
        
        // 指针数组
        var ptr [3]*int;
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
        - panic：中断原有流程，进入panic流程。执行每一层的已经载入的defer函数，如果没有遇到recover进程打印异常信息后程序退出
          1. 可手动触发，可运行时错误产生，如访问越界的数组
          1. panic无法跨协程, 当前协程产生的异常, 必须由当前协程处理
          1. panic可以嵌套
        - recover：可以捕获到panic的输入值，让进入panic流程中的goroutine恢复正常执行
          1. 只能在defer语句中使用，直接使用返回nil没有任何效果
          1. recover后, 当前函数panic后面没执行的代码也不会再继续执行
          1. 如果无法处理，可以重新panic
     1. 定义
        ```go
        func panic(interface{})         // 接受任意类型参数 无返回值 
        func recover() interface{}      // 可以返回任意类型 无参数
        ```
     1. 实例
        ```go
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
     1. 意料之中用error，如文件打不开；意料之外用panic，如数组越界。异常定义为无法预测的，几乎不可能失败但是特殊条件下也没法返回错误，也无法继续执行
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
1. 理解：核心是合成复用
1. struct
   - 理解：结构体，`type struct`，字段的组合
     1. 不支持多态
     1. 字段标签：tag，不是注释是描述字段的元数据。不属于数据的组成部分是类型的组成部分
        ```go
        type user struct {
            name string `昵称`
            age  int    `年龄`
        } `我也是标签`

        // 最佳实践写法
        type user struct {
            name, realname              string
            createTime,modifyTime       int
        }
        ```
     1. 方法
        - 属于结构体的方法
          1. 定义在结构体作用域外，在函数声明中指定接收者，除了基础类型或其他包的，可以在任意类型里定义方法
          1. `func (variable_name variable_data_type) function_name() [return_type]{}`
        - 结构体内部的方法类型
            ```go
            // 申明
            type hasMethod struct {
                myMethid func() int
            }
            // 定义
            s := hasMethod{myMethid: func() int {
                fmt.Print(111)
                return 0
            }}
            // 调用
            s.myMethid()
            ```
     1. 匿名组合：可以直接用父结构体的属性和方法，类似继承
        ```go
        // 结构体组合
        type Animal struct{
            Color string
            Size int
        }
        type Dog1 struct{
            Animal
            name string
            Color string
        }
        dog := Dog1{                // 定义变量
            Animal{"red", 11},
            "miao",
            "blue",
        }
        dog.Color = "1"             // 直接使用，优先级高于父级的

        type Dog2 struct{
            someAnimal Animal       // 把父结构体作为一个属性使用，原理类似
            name string
        }

        fmt.Println(dog.someAnimal.Color)
        ```
   - 实例
    ```go
    // 定义
    type Dog struct {
        x int               // 封装
        y int
    }
    var Dog struct{
        x int  
    }{}

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

    // 定义+赋值
    dog := struct {
        x int
        y int
    }{
        1,
        2,
    }

    // 访问
    dog.x

    // 添加方法
    func (d *Dog) Run {}            // 函数名前加接受者
    func (d Dog) Run {}				// 深拷贝，会复制一个出来

    var p *Dog
    p = &Dog{1, 2}                  // 类型为 *Dog

    // 结构体切片
    s := []Dog{
		Dog{1},
		Dog{2},
	}
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
     1. 所有的数据类型都实现了空接口，参数是的话表明可以使用任何类型的数据，函数内部该变量仍然为空接口类型，而不是传入的实参类型
     1. 函数也是一种类型，也可以实现接口`type funcTypeName func() int`
     1. 类型断言：语法`x.(T)`，即接口类型向普通类型的转换，运行期确定，通过断言实现类型转换，同时加上判断，防止断言失败导致运行错误。x是类型为interface{}的变量
        ```go
        func printArray(arr interface{}){
            a,ok := arr.([]int)                 // 返回转换后的变量、是否成功
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
1. goroutine
   - 认识：go的协程(coroutine)，协程间需要通信、同步，是并行运行的(多处理器同时)，需要的内存极小，实际可以cpu核数减一来设置，给系统留下
   - 特点
     1. 并发基于csp模型
     1. 非抢占式多任务处理
     1. 调度器会在合适的点进行切换，其他语音需要指定切换的点
        - io、select
        - channel
        - 等待锁
        - 函数调用(有时)
        - runtime.Gosched() 
     1. 不需要锁，不需要callback(写程序不用，底层有)
     1. 可以实现并发编程、并行计算
   - 优势
     1. 去掉了冗余的协程生命周期管理
     1. 降低额外延迟和开销：来源是协程间的频繁交互
     1. 降低加解锁的频率
   - 成本：增加额外的耗时、内存消耗
   - demo
    ```go
    go say("hello")
    go say("world")

    go func(i int) {
        i++                     // 没有协程切换的机会，会一直运行
    }(i)                          // 外部传进i，否则就是闭包
    ```
   - wiki
     1. 并行与并发：并发只是假装同时进行
     1. 协程调度模仿的就是linux的进程调度，在其之上自己实现了一套。m是machine相当于cpu，g相当于进程，g在m上运行，p按照规则自己给自己做调度，调度室代码+数据
     1. io密集的可以使用协程如读数据库，cpu密集的就不要了比如网站的逻辑层
     1. 价值
        - 不必陷入内核态，而且占用资源少、切换快，堆当栈用
        - 其他操作耗时的时候让出cpu，不用等待
        - 给了我们自己调度的自由
1. channel
   - 认识：有类型的管道，用于协程间通信。使得goroutine可以在没有明确的锁或竞态变量的情况下同步，即飞行中加油
     1. 和正在跑的协程进行通信
     1. 没有锁，可以用-race检测数据访问冲突
     1. 默认另一端准备好之前发送和接收都会阻塞
   - 特性
     1. 无缓冲channel
        - 读时没有数据会阻塞
        - 没有取数据时goroutine会阻塞
        - 读写不能放一个协程里，写读颠倒会死锁
     1. nil的channel：发送、接收数据，不会报错，是永远阻塞的，用var声明的就是nil channel 
     1. 已关闭的channel
        - 发送数据，引起panic 
        - 接收数据，返回channel中缓存的值，如果通道中无缓存，返回0
   - 阻塞
     1. 原因：供需失衡
        - 有缓存的，生产多了生产者阻塞
        - 消费没了消费者阻塞
     1. 后果：非主流程拿不到数据，主流程进入阻塞无法响应请求
     1. 骚操作：利用阻塞实现多协程锁
   - 定义
        ```go
        ch := make(chan int)        // 这个ch是一个指针类型
        ch <- v                     // 写
        v := <- ch                  // 读

        // 单向通道
        var send chan <- int         // 只能发送
        var receive <- chan int      // 只能接收
        ```
   - 缓冲：可以提高性能
        ```go
        ch := make(chan int, 100)   // 有缓冲通道，只有缓冲区满时才会阻塞，当缓冲区清空的时候接收操作会阻塞
        ch := make(chan int)        // 无缓冲通道/同步通道，即通道大小为0，不会存储数据
        ```
   - 关闭
        ```go
        // 发送者close channel，表示再没有值会被发送，只有发送者才能关闭channel
        c := make(chan int, 10)
        close(c)                        

        // 接收者通过赋值语句的第二参数来测试channel是否被关闭，ok为false表示已经关闭
        v,ok := <-ch                    
        for{
            v,ok := <- ch
            if ok == false {        // 通道已经关闭
                break
            }
        }

        // 简便写法，不断从channel接收值，直到它被关闭，可替换以上判断的写法
        for v := range ch{}         
        ```
   - select：同时监听多个管道并收发消息，会阻塞直到条件分支中的某个可以继续执行。多个都准备好的随机选一个。可用于多个写入，一个读取场景
     1. 谁来的快收谁
     1. 加了default相当于非阻塞式的获取，之前channel都是阻塞的，套层for就是循环default，去掉default就是deadlock
        ```go
        select {
            case c <- chName1:
            case <- quitChName:                         // 只要有数据，不管值是什么
            case <- time.After(5 * time.Second):        // 设置超时
            default:                                    // 其他分支没准备好的时候default分支会被执行，可用于非阻塞的发送或者接收

            case n := <- c1:                         // 可以实现读一堆，然后返回给一个
                out <- n                                // 这样会阻塞
            case n := <- c2:
            case out <- n:                            // 这样不会阻塞
        }
        ```
1. sync：提供了并发编程中基本的同步原语，保证执行不会出现混乱。这是传统的同步机制，是通过共享内存来通信的，更高级别的同步最好通过通道和通信来完成
   - 同步器
     1. 认识：`sync.WaitGroup`，是信号量，需要某个条件完成才能继续，用于并发控制
        - 场景：在一个goroutine等待一组goroutine执行完成的通知时。初级的可以多用一个done的channel阻塞实现等待某个goroutine结束的通知，每次循环进出这个channel，多个可以使用通道切片来分别存储，使用waitGroup更加高效优雅
     1. 原理：拥有一个内部计数器。当计数器等于0时，则Wait()方法会立即返回。否则一直阻塞执行Wait()方法的goroutine
     1. 方法
        - Add(n)：设置计数器数量n，传负数就是减n
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
     1. 互斥锁：sync.Mutex，保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
        ```go
        c.mux.Lock()
        defer c.mux.Unlock()          // 这才是解锁的正确写法
        c.v[key]++                          // Lock 之后同一时刻只有一个goroutine能访问 c.v

        func() {                                // 可以用匿名函数实现逻辑体的加解锁
            c.mux.Lock()
            defer c.mux.Unlock()     
        }()
        ```
     1. 读写互斥锁：sync.RWMutex。RWMutex允许至少一个读锁或一个写锁存在，而sync.Mutex允许一个读锁或一个写锁存在
        - RLock、RUnlock：可进行并发读取
   - 发送信号：sync.Cond
     1. 认识：用于发出信号（一对一）或广播信号（一对多）到goroutine
        - 创建sync.Cond需要sync.Locker对象（sync.Mutex或sync.RWMutex）
        - 破坏了go的基本原则：不要通过共享进行通信；而是通过通信共享，但是通过channel模拟广播的唯一方法是关闭channel，只能广播一次，cond可以多次
     1. 方法
        - `sync.NewCond(&sync.Mutex{})`：创建
        - `Signal`：发送单个信号
        - `Broadcast`：发送广播信号
   - 并发池：sync.Pool
     1. 认识：安全地保存一组对象
     1. 方法
        - Get()：随机取，无法保证以固定的顺序
        - Put()
   - sync/singleflight
     1. 认识：重复函数调用抑制
   - sync.Map
     1. 认识：并发安全版map
     1. 方法
        - Load()：检索
        - Range()：遍历
        - Store()：添加
        - Delete()：删除
        - LoadOrStore()：检索或新增
   - atomic：底层的原子性内存原语
     1. 方法
        - AddInt32()
   - 一个函数在所有goroutine仅执行一次：sync.Once
     1. 执行方法：`once.Do()`
1. context
   - 认识：控制生命周期、追踪协程之间的调用树，在这些树中传递通知和元数据，是一种协程调度的方式。v1.7
     1. 用在发生超时、主动取消、产生异常时需要进行的抢占、中断其他等后续操作
     1. context本身是不可变的，是线程安全的，可以放心地在多个协程中传递使用
     1. 理解为一颗上下文树，继承衍生
   - 组成
     1. 初始化
        - Background()：返回非nil的、永不取消的、无值、无截止时间的空context，通常主方法、初始化、测试时用
        - TODO()：返回非nil的context，不确定使用什么context、不可用、没扩展的时候使用
        - WithValue(parent Context, key, val interface{})：返回父context的复制，用于传递数据
     1. 操作
        - WithCancel()：创建一个基于parent的可取消的context(cancelCtx类型)，返回一个context和一个CancelFunc，调用CancelFunc即可触发cancel操作
        - WithDeadline()：创建一个基于parent的可取消的context，其过期时间deadline不晚于所设置时间d
        - WithTimeout()：类似WithDeadline，时间是相对当前时间的过期时长
   - 设计
     1. cancelCtx取消时，会将后代节点中所有的cancelCtx都取消
   - 使用规范
     1. 第一形参通常都为context，并且把变量命名为ctx
     1. 不要把context存储在结构体中，而是要显式地进行传递
     1. 就算是程序允许，也不要传入一个nil的context，如果不知道是否要用context的话，用context.TODO()来替代
     1. context.WithValue()只用于传输流程和API的请求范围数据，不要用它来传递可选参数
   - demo1
    ```go
    // WithTimeout相关，子线程监听主线程传入的ctx，一旦ctx.Done()返回空channel，子线程即可获知超时
    ctx, cancel := context.WithTimeout(context.TODO(), 5*time.Second)
	defer cancel()
	go func(ctx context.Context) {
		execResult := make(chan bool)
		// 模拟业务逻辑
		go func(execResult chan<- bool) {
			// 模拟处理超时
			time.Sleep(6 * time.Second)
			execResult <- true
		}(execResult)
		// 等待结果
		select {
		case <-ctx.Done():
			fmt.Println("超时退出")
			return
		case <-execResult:
			fmt.Println("处理完成")
			return
		}
	}(ctx)

	time.Sleep(10 * time.Second)
    ```
   - demo2
    ```go
    // WithCancel相关，搭配WaitGroup实现主协程等待子协程

    // 初始化一个context
	parent := context.Background()
	// 生成一个取消的context
	ctx, cancel := context.WithCancel(parent)
	runTimes := 0

	var wg sync.WaitGroup
	wg.Add(1)
	go func(ctx context.Context) {
		for {
			select {
			case <-ctx.Done():
				fmt.Println("Goroutine Done")
				return
			default:
				fmt.Printf("Goroutine Running Times : %d\n", runTimes)
				runTimes = runTimes + 1
			}
			if runTimes > 5 {
				cancel()
				wg.Done()
			}
		}
	}(ctx)
	wg.Wait()
    ```
1. wiki
   - 并发控制模式
     1. chan：原始的同步方式，每多一级就需要多一个chan
     1. waitGroup：限制多个的同步
     1. context：多种控制方式，树级多级模型，可传递数据
   - 并发路线
     1. 内存模型
     1. 并发机制原理
     1. 锁
     1. 并发数据结构
     1. 并发工具
     1. 协程池
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
        - 所有包包含一个没有任何返回值和参数的、不能显式调用的、包完成初始化后自动执行的、执行优先级比main函数高的init函数
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
   - 初始化
     1. 导入包：依次执行包中的常量申明、变量定义、init方法
     1. 常量申明
     1. 变量定义
     1. init方法
     1. main函数
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
     1. errors
        - `errors.New("xxxx")`
     1. builtin：为go的预声明标识符提供文档
   - 基础类型和变量
     1. bytes：实现操作[]byte的常用函数
     1. sort：切片、集合的排序操作
     1. expvar：提供公共变量的标准接口
   - 文本相关
     1. text
     1. strings：操作字符
     1. strconv：基本数据类型和其字符串表示的相互转换
        - `strconv.Quote("xx")`：可以输出双引号
     1. index
        - suffixarray：suffixarrayb包通过使用内存中的后缀树实现了对数级时间消耗的子字符串搜索
     1. regexp：正则
        - syntax

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
        - charset
          1. charset.DetermineEncoding()
     1. mime：实现了MIME的部分规定
        - multipart：实现MIME的multipart解析
        - quotedprintable
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
        - `io.Reader`
     1. bufio：带缓存增强版，比io写的快多了，一口气flush到硬盘
        - 可读取一行
        - 会缓存下来，遇到flush才输出`bufio.NewWriter.Flush()`
     1. io/ioutil：实现一些io实用功能，v1.16后逐步放到了io、os中
     1. path：路径
        - filepath：兼容各操作系统文件路径的实用操作函数
     1. archive：文件解压缩
        - `archive.tar`
        - `archive.zip`
   - 应用
     1. fmt
        - 认识：类似c的printf和scanf的格式化I/O
          1. 格式化动作('verb')源自c但更简单
          1. scann扫描格式化文本以生成值
        - 方法分类
          1. print：输出到标准输出流，支持多个参数输出
             - 后边加f：根据format参数，默认采用默认格式，`fmt.Printf("%3d", val)表示3位对齐`
             - 前边加F：写入给定源，默认写入标准输出
             - 后边加Ln：总是用空格分隔，并且加换行符
             - 前边加S：返回该字符串
          1. scann
          1. Errorf
     1. time
        - `time.Now()`
        - `time.Now().Format("2006-01-02 15:04:05")`
        - `time.Tick()`：每隔一段时间送一个值过来
        - `time.After(n)`：倒计时，结束后往channel里送一个时间，可利用阻塞实现定时，for里边的select每次循环都重新开启
        - `time.Sleep(time.Second * 5)`
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
             - seek()：设置文件相对于当前/首/尾的偏移量
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
        - 方法
          1. Print()：输出日志
          1. Fatal()：输出日志同时调用os.Exit(1)退出，小提示：如果函数下存在defer不会执行
          1. Panic()：输出日志同时调用panic，defer会执行
        - 函数
          1. log.SetFlags()：定义日志输出格式
            ```go
            const (
                Ldate         = 1 << iota     // 日期示例：2009/01/23
                Ltime                         // 时间示例: 01:23:23
                Lmicroseconds                 // 毫秒示例: 01:23:23.123123.
                Llongfile                     // 绝对路径和行号: /a/b/c/d.go:23
                Lshortfile                    // 文件和行号: d.go:23.
                LUTC                          // 日期时间转为0时区的
                LstdFlags     = Ldate | Ltime // Go提供的标准抬头信息
            )

            // 示例
            log.SetFlags(log.Ldate|log.Lshortfile)
            ```
          1. log.SetPrefix()：设置前缀
          1. log.SetOutput()：设置输出方式
            ```go
            // 设置文件的输出方式
            logFileLocation, _ := os.OpenFile("/Users/q1mi/test.log", os.O_CREATE|os.O_APPEND|os.O_RDWR, 0744)
            log.SetOutput(logFileLocation)
            ```
          1. log.New()：返回新的Logger类型，并定义一些特性
        - 子包
          1. syslog：使用域套接字、udp、tcp时可向syslog守护进程发送日志，可以Dial远端也可以本地，不再更新，有替代产品
     1. flag：用于命令行的标签解析
   - net
     1. 组成
        - Conn：使用goroutines保证请求独立、非阻塞
        - ServeMux：多路复用器，用作请求的路由分发
     1. 方法
        - ip：`addr := net.ParseIP()`
     1. 子包
        - http：提供http客户端和服务端的实现
          1. 特点
             - serve方法中对panic作了保护，防止服务停止
          1. 组成
             - Handler
             - Request
             - Response
          1. 子包
             - cookiejar：实现保管在内存中的符合RFC 6265标准的httpCookieJar接口
             - httputil：提供http公用函数，是http的函数补充
               1. ReverseProxy()：设置反向代理
               1. DumpResponse()：打印响应体
             - cgi：实现RFC3875协议描述的CGI（公共网关接口）
             - fcgi：实现FastCGI协议
             - httptest：http测试的单元工具
             - pprof：返回runtime的统计数据，返回pprof可视化工具规定的格式
             - httptrace
        - url
        - rpc
          1. jsonrpc
        - mail：解析邮件消息
        - smtp：简单邮件传输协议
        - textproto：实现对基于文本的请求/回复协议的一般性支持
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
          1. `runtime.Gosched()`：使goroutine让出调度
          1. `runtime.Goexit()`：使goroutine立即终止
          1. NumGoroutine
     1. go：语法包
     1. container：数据结构
        - heap：任意类型的堆操作
        - list：双向链表
        - ring：环形链表
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
        - B
          1. 方法
             - RunParallel
### 应用
1. 文本处理
   - string：分割、连接、转换、取索引、前后缀检测等
     1. strings包
        - 查找：`strings.Index/Contains/HasPrefix/HasSuffix(src))`：索引、是否包含
        - 修改：`strings.Trim/TrimSpace/Fields/Repeat/Replace/Join/Split(src))/ToLower/ToUpper`
     1. strconv包
        - 转换为字符串：`strconv.FormatBool/FormatInt/FormatUint/FormatFloat/Itoa()`：Itoa/Atoi针对int，FormatInt/ParseInt针对int64，可支持进制
        - 字符串转换为其他类型：`strconv.ParseBool/ParseInt/ParseUint/ParseFloat/Atoi()`
        - 转换为字符串后添加到字节数组中：`strconv.AppendInt/AppendBool/AppendQuote/AppendQuoteRune()`
   - reg：regexp包，实现RE2标准，实现搜索、替换、解析，strings包优先
        ```go
        regexp.MatchString("^[0-9]+$", os.Args[1])
        regexp.Compile("\\<script[\\S\\s]+?\\</script\\>")
        ```
   - xml：encoding/xml包，读取Unmarshal，生成Marshal/MarshalIndent
   - json：encoding/json包
     1. 认识
        - 共性
          1. 只有可导出成员(首字母大写)才可和json互转
          1. 当变量实现了Marshaler或者Unmarshaler，会调用其MarshalJSON或者UnmarshalJSON方法来生成json编码
        - 编码
          1. 输出首字母小写的json串只能通过tag实现，tag为_的不输出，tag有"xx,string"的会转换类型，tag有"xx,omitempty"的该字段值为0值或者空值时不会输出到json中
          1. 指针变量编码时自动转换为所指向的值
        - 解码
          1. 字段查找顺序：tag->字段名->首字母之外其他大小写不敏感的导出字段
          1. 空字段默认给出类型默认值，指定默认值的一个方法是：定义一个带需要的默认值的结构体变量给到Unmarshal
          1. 使用空接口可实现任意类型的成员赋值和转换
          1. map结构是采用map[string]interface{}和[]interface{}结构来存储任意的JSON对象和数组
     1. Marshal：序列化为json，用于map和struct
        ```go
        type Server struct {
            ServerName string `json:"name"`     // 这是tag，生成json时替换key，做个映射，反过来也会用到
            ServerIP   string `json:"ip"`
        }

        server := new(Server)
        server.ServerName = "1"

        a, _ := json.Marshal(server)

        fmt.Println(string(a))
        ```
     1. Unmarshal：反序列化json
        - struct
            ```go
            // 已知结构的
            type Server struct {
                ServerName string `json:"name"`
                ServerIP   string `json:"ip"`
            }
            type Serverslice struct {
                Servers []Server
            }

            var s Serverslice
            str := `{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"},{"name":"2"}]}`
            err := json.Unmarshal([]byte(str), &s)     // 强行转为数组
            fmt.Println(s)
            ```
        - map
            ```go
            // 未知结构，interface和type assert配合
            str := []byte(`{"name":"tom","age":6,"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`)
            var f interface{}
            _ = json.Unmarshal(str, &f)
            m := f.(map[string]interface{})             // 断言形式来访问
            for k, v := range m {
                switch vv := v.(type) {
                case string:
                    fmt.Println(k, "is string", vv)
                case int:
                    fmt.Println(k, "is int", vv)
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
            fmt.Println(m["servers"])
            // f的形式为
            f = map[string]interface{}{
                "Name": "tom",
                "Age":  6,
                "Parents": []interface{}{
                    "1",
                    "127",
                },{
                    "2",
                    "127",
                },
            }


            // 第三方simplejson包
            js, err := NewJson([]byte(`{"servers":[{"name":"1","ip":"127"},{"name":"2","ip":"127"}]}`))
            arr, _ := js.Get("servers").Get("name").Array()
            i, _ := js.Get("servers").Get("name").Int()
            ms := js.Get("servers").Get("name").MustString()
            ```
   - 命令行
     1. 简单：`os.Args/os.Args[1]`
     1. 复杂：`flag`
        ```go
        // 格式化定义
        ptr := flag.String/Int("name", "default", "demo")
        // 解析
        flag.Parse()
        // 使用
        *ptr
        ```
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
   - 发起http请求
    ```go
    resp, err := http.Get("http://")
    defer resp.Body.Close()

    s, err := httputil.DumpResponse(resp, true)
    fmt.Printf("%s\n", s)
    ```
   - web服务器
    ```go
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
   - 服务端cookie操作
     1. 直接操作http头部
        ```go
        // 获取cookie，r *http.Request
        r.Header.Get("Cookie")

        // 设置Set-Cookie字段，w http.ResponseWriter
        c2 := http.Cookie{
            Name:     "second_cookie",
            Value:    "Go Web Programming",
            HttpOnly: true,
        }
        w.Header().Set("Set-Cookie", c2.String())
        w.Header().Add("Set-Cookie", c2.String())
        ```
     1. 使用http方法
        ```go
        // 获取
        http.Request.Cookie(key string)         // 单个
        http.Request.Cookies()                  // 所有
        // 设置
        http.SetCookie(w, &c2)
        ```
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
   - rpc：`net/rpc`提供，支持三个级别：TCP、HTTP、JSONRPC，只支持go内部，使用Gob编码
     1. 访问条件：`func (t *T) MethodName(argType T1, replyType *T2) error`，T/T1/T2必须能被encoding/gob包编解码
        - 函数必须是导出的
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
     1. json rpc：使用json编码，不是gob，支持跨语言调用
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
     1. proto rpc
        - 编写proto文件，生成.pb.go代码：`protoc --go_out= plugin= protorpc=. arith.proto`，包含了rpc方法定义和服务注册的代码
        - 使用
          1. 服务端：`pb.ListenAndServeArithService("tcp", "127.0.0.1:8097", new(Arith))`
          1. 客户端
            ```go
            conn, err := pb.DialArithService("tcp", "127.0.0.1:8097")
            if err != nil {
                log.Fatalln("dailing error: ", err)
            }
            defer conn.Close()

            req := &pb.ArithRequest{9, 2}

            res, err := conn.Multiply(req)
            if err != nil {
                log.Fatalln("arith error: ", err)
            }
            ```
     1. grpc
        - 包：`google.golang.org/grpc`
        - 使用
          1. 编写proto或protoc(有service)文件，
          1. 实现pb.go的RegisterXXServiceServer接口
          1. 服务端
            ```go
            // 1. new一个grpc的server
            rpcServer := grpc.NewServer()

            // 2. 将刚刚我们新建的ProdService注册进去
            service.RegisterProdServiceServer(rpcServer, new(service.ProdService))

            // 3. 新建一个listener，以tcp方式监听8082端口
            listener, err := net.Listen("tcp", ":8082")
            if err != nil {
                log.Fatal("服务监听端口失败", err)
            }

            // 4. 运行rpcServer，传入listener
            _ = rpcServer.Serve(listener)
            ```
          1. 客户端
            ```go
            conn, err := grpc.Dial(":8082", grpc.WithInsecure())
            if err != nil {
                log.Fatal(err)
            }

            // 退出时关闭链接
            defer conn.Close()

            // 2. 调用Product.pb.go中的NewProdServiceClient方法
            productServiceClient := service.NewProdServiceClient(conn)

            // 3. 直接像调用本地方法一样调用GetProductStock方法
            resp, err := productServiceClient.GetProductStock(context.Background(), &service.ProductRequest{ProdId: 233})
            if err != nil {
                log.Fatal("调用gRPC方法错误: ", err)
            }

            fmt.Println("调用gRPC方法成功，ProdStock = ", resp.ProdStock)
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
1. 测试
   - 方式
     1. testing包：使用包中方法
     1. go test：自动读取源码目录下*_test.go文件，生成并运行测试用的可执行文件
   - 分类
     1. 单元测试：`go test -timeout 30s -run ^TestDemo$ demo -v -count=1`
        ```go
        // 简单
        func TestDemo(t *testing.T) {
            t.Parallel()
            // 模拟调用接口
            resp, err := http.Get("http://example.com?user_id=121212")
            if err != nil {
                t.Error(err)
                return
            }
            body, err := ioutil.ReadAll(resp.Body)
            if err != nil {
                t.Error(err)
                return
            }
            t.Log("body", string(body))
        }
        // 多个测试用例
        func TestDemo(t *testing.T) {
            t.Parallel()
            tests := []struct {
                TestName string
                *Req
            }{
                {
                    TestName: "测试用例1",
                    Req: &Req{
                        UserID: 12121212,
                    },
                },
                {
                    TestName: "测试用例2",
                    Req: &Req{
                        UserID: 829066,
                    },
                },
            }
            for _, v := range tests {
                t.Run(v.TestName, func(t *testing.T) {
                    // 模拟调用接口
                    url := fmt.Sprintf("http://example.com?user_id=%d", v.UserID)
                    resp, err := http.Get(url)
                    if err != nil {
                        t.Error(err)
                        return
                    }
                    body, err := ioutil.ReadAll(resp.Body)
                    if err != nil {
                        t.Error(err)
                        return
                    }
                    t.Log("body", string(body), url)
                })
            }
        }
        ```
     1. 基准测试
        - 认识：`go test -benchmem -run=^$ -bench ^(BenchmarkSyncMap)$ demo -v -count=1 -cpuprofile=cpu.profile -memprofile=mem.profile -benchtime=10s`
          1. 生成cpu.profile文件和mem.profile文件
        - 参数
          1. -benchmem: 输出内存指标
          1. -run: 正则，指定需要test的方法
          1. -bench: 正则，指定需要benchmark的方法
          1. -v: 即使成功也输出打印结果和日志
          1. -count: 执行次数
          1. -cpuprofile: 输出cpu的profile文件
          1. -memprofile: 输出内存的profile文件
          1. -benchtime: 执行时间
        - demo
            ```go
            // 简单
            func BenchmarkSyncMap(b *testing.B) {
                demoMap := &sync.Map{}
                b.RunParallel(func(pb *testing.PB) {
                    for pb.Next() {
                        demoMap.Store("a", "a")
                        for i := 0; i < 1000; i++ {
                            demoMap.Load("a")
                        }
                    }
                })
            }

            // 对比
            // 压力测试sync.Map
            func BenchmarkSyncMap(b *testing.B) {
                demoMap := &sync.Map{}
                b.RunParallel(func(pb *testing.PB) {
                    for pb.Next() {
                        demoMap.Store("a", "a")
                        for i := 0; i < 1000; i++ {
                            demoMap.Load("a")
                        }
                    }
                })
            }

            // 用读写锁实现一个并发map
            type ConcurrentMap struct {
                value map[string]string
                mutex sync.RWMutex
            }

            // 写
            func (c *ConcurrentMap) Store(key string, val string) {
                c.mutex.Lock()
                defer c.mutex.Unlock()
                if c.value == nil {
                    c.value = map[string]string{}
                }
                c.value[key] = val
            }

            // 读
            func (c *ConcurrentMap) Load(key string) string {
                c.mutex.Lock()
                defer c.mutex.Unlock()
                return c.value[key]
            }

            // 压力测试并发map
            func BenchmarkConcurrentMap(b *testing.B) {
                demoMap := &ConcurrentMap{}
                b.RunParallel(func(pb *testing.PB) {
                    for pb.Next() {
                        demoMap.Store("a", "a")
                        for i := 0; i < 1000; i++ {
                            demoMap.Load("a")
                        }
                    }
                })
            }
            ```
1. 性能分析
   - `go tool cover -html=c.out`：分析由`go test -coverprofile`生成的覆盖率测试的结果，绿色是覆盖的，红色未覆盖，采用插桩源码方式
   - `go tool trace`
     1. 认识：调用链路，找出程序在一段时间内正在做什么，诊断性能问题，如延迟，并行化、竞争异常
        - 清晰查看每个逻辑处理器中Goroutine的执行过程，可以很直观看出Goroutine的阻塞消耗，包含网络阻塞、同步阻塞(锁)、系统调用阻塞、调度等待、GC执行耗时、GC STW(Stop The World)耗时
     1. 步骤
        - 生成trace.out文件命令：`go test -benchmem -run=^$ -bench ^BenchmarkDemo_Pool$ demo -v -count=1 -trace=trace.out `
        - web版：`curl http://localhost:8888/debug/pprof/trace?seconds=20 > trace.out`
        - 分析trace.out文件命令：`go tool trace -http=127.0.0.1:8000 trace.out`
   - `go tool pprof`
     1. 认识：性能分析，找出时间花在哪里
        - 解决那些耗时占比大的，看看怎么解决
     1. 分析场景
        - 静态应用：查看profile文件，可视化看到火焰图、调用链路耗时图、Top函数，`go tool pprof -http=:8000 cpu.profile`，
          1. 步骤：循环头尾进行，不断优化
             - -cpuprofile生成profile
             - pprof分析profile
             - 分析慢在哪里
             - 优化代码
          1. -http: 指定ip:port，启动web服务可视化查看分析，浏览器会自动打开页面 
        - web应用
            ```go
            // 开启访问入口
            go func() {
                http.ListenAndServe(":8888", nil)
            }()
            // 直接访问
            http://localhost:8888/debug/pprof/
            // pprof工具获取
            go tool pprof -http=:8000 http://localhost:8888/debug/pprof/profile?seconds=5

            // 另一边可以施加流量，用以观察
            siege -c 50 -t 100 "http://localhost:8080/ping"


            // demo
            import (
                "net/http"
                _ "net/http/pprof"
                "github.com/gin-gonic/gin"
            )

            var GlobalVarDemo int32 = 0

            // 模拟接口逻辑
            func main() {
                r := gin.Default()
                r.GET("/ping", func(c *gin.Context) {
                    GlobalVarDemo++
                    c.JSON(200, gin.H{
                        "message": GlobalVarDemo,
                    })
                })
                // 再开启一个端口获取pprof数据
                go func() {
                    http.ListenAndServe(":8888", nil)
                }()
                // 启动web服务
                r.Run()
            }
            ```
   - 断点调试：dlv
   - 逃逸分析：`go build -gcflags "-m -l" *.go`
   - 汇编代码：`go run -gcflags -S main.go`
1. GUI
   - fyne
   - gio
     1. 认识：全平台的可移植的即时模式gui程序，对浏览器的实验性支持 (Webassembly/WebGL)
     1. 组成
        - 基于Pathfinder的高效矢量渲染器
        - 基于piet-gpu的实验渲染器，两种渲染器都支持Vulkan、Metal、Direct3D 11和OpenGL ES
### 运维
1. cli
   - 查看
     1. `go version`
     1. `go env`：查看当前go的环境变量
     1. `go doc`：用于查看文档
        - `godoc -http=:8080`：生成本机的go官网，可用浏览器打开
     1. `go help`
   - 编写
     1. `go fmt`
        - 认识：格式化代码文件，是gofmt的简单封装
          1. 传入文件路径会格式化这个文件 ———— 如果传入目录格式化目录中所有.go文件 ———— 如果不传参数，格式化当前目录下的所有.go文件
          1. 默认不对代码进行简化，-s启动简化
     1. `go test`
     1. `go fix`：转换老版本的代码到新版本
     1. `go generate`：用于在编译前自动化生成某类代码
        - 写法举例：`//go:generate go tool yacc -o gopher.go -p parser gopher.y`
   - 调试
     1. `go vet`：静态错误检查
     1. `go bug`：调试
     1. `go tool`
        - `go tool compile -N -l -S main.go`：不优化编译，可用dlv调试
        - `go tool pprof`：性能分析工具
        - `go tool cover`：覆盖率分析工具
        - `go tool cgo`
   - 运行和编译
     1. `go run hello.go`：进行高速编译，用作脚本语言
        - -race：检测数据访问冲突
     1. `go build`
        - 认识：用于测试编译
          1. 会同时编译依赖包，会在GOROOT/src和GOPATH/src搜索包，默认编译当前目录下的所有go文件，可指定要编译的文件名，会忽略_或.开头的go文件，会根据当前系统选择性地编译以系统名结尾的文件(_linux|darwin|windows|freebsd.go)
          1. 普通包不产生任何文件只做检查性编译，main包生成可执行文件
        - 参数
          1. -v：打印包名
          1. -o：指定输出的可执行文件
          1. -ldflags "-s -w"：-s 去掉符号信息。-w 去掉DWARF调试信息
          1. -gcflags "-N -l"：关闭内联优化
     1. `go install`：编译和安装，将编译好的结果移到$GOPATH/pkg或$GOPATH/bin。.a移到$GOPATH/pkg，可执行文件移到$GOPATH/bin
        - `go install example.com/pkg@v1.2.3`：忽略mod文件指定依赖版本
     1. `go clean`：移除当前源码包里面编译生成的文件，如_obj/、_test/、test.out
   - 模块
     1. `go get`
        - 认识：动态安装远程代码包，包含clone和install，不推荐使用。本质是先通过源码工具clone代码到GOROOT/src目录，然后执行go install
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
     1. 代理相关
        - 走代理
          1. `GOPROXY=https://proxy.golang.org,direct|off`
             - 多个代理逗号分隔
             - direct：回源到模块版本的源地址去抓取
          1. `GOSUMDB=sum.golang.org|off`：校验是否被篡改
        - 不走代理
          1. `GOPRIVATE=*.100tal.com`：设置不走代理的，GOPRIVATE会作为下边俩的默认值
          1. `GONOPROXY=*.100tal.com`
          1. `GONOSUMDB=*.100tal.com`
     1. CGO_ENABLED
   - 编译
     1. 一个package只能有一个main，否则build不过
   - 开发
     1. 配置GOROOT、GOPATH
     1. 配置代理：`GOPROXY=https://goproxy.cn;GOPRIVATE=*.100tal.com`
     1. 配置注释空格：设置 Preferences > Editor > Code Style > Go > Other 勾选上 Add leading space to comments
     1. 配置goimport、go fmt，在Tools > File Watcher
   - 部署
     1. supervisor来管理go程序，go自己用异常捕捉来处理
     1. 打包linux的：`CGO_ENABLED=0 GOOS=linux GOARCH=amd64 go build main.go`
     1. 编译脚本
        ```shell
        #!/bin/bash

        # 设置环境变量
        export GO111MODULE=on
        export GOPROXY=https://goproxy.cn,direct
        export GOSUMDB="off"
        export GOPRIVATE=*.100tal.com

        # 配置git，能够拉取gitlab依赖
        git config --global url."ssh://git@git.100tal.com/".insteadOf https://git.100tal.com/

        # 编译
        make
        ```
1. 依赖管理
   - Go Module
     1. 认识：官方的包依赖版本管理工具，前身vgo
        - 支持vendor、GOPATH
        - go命令内置对模块的支持
        - 至少1.11及以上版本，最好1.13或以上，撑13以下是老版本，哈哈
     1. 组成
        - go.mod文件，可以将工程从GOPATH中移出来
            ```go
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

        - go get：添加
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
### wiki
1. 语言编程基础
   - 关键词和语法（Language Syntax）
   - 数据类型（Arrays, Slices and Maps）
   - 流程控制（if/else，for/range）
   - Go 函数（Function）
   - 面向对象（Methods, Interfaces and Embedding）
   - 包处理（Packaging and Exporting）
   - Go 指针（Using Pointers）
   - 错误处理（Error Handling）
   - 反射（Reflection）
   - 标准库（Standard Library）
   - 程序测试（Testing and Debugging）
1. 并发编程
   - Go 并发基础（Concurrency, Race Conditions and Channels）
   - 并发模式（Concurrency Patterns）
   - 读写锁
   - 协程：协程泄露
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
   - 1.18
     1. net/netip包：之前ip包设计不合理。定义了ip地址类型Addr，占用更少内存（24 byte），不可变（immutable），具有可比性（支持==并作为map键）
1. wiki
   - 语法糖
     1. ...：可变参数
     1. :=：声明、赋值、类型推断
   - go先写变量名，再写类型，和c是反的，其实更加符合人写程序的思考方式
   - go没有引用类型，只有指针
   - slice类型是不可比较的
   - go没有提供session的支持
     1. session设计要点
        - 创建
        - 全局管理器
        - Session ID的全局唯一性
        - 存储（可以存储到内存、文件、数据库等）
        - 过期处理
