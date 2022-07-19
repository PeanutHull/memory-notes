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
   - 类似于C+Python：高效+简单的代码实现复杂逻辑
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
   - 认识：可以直接使用，而不用声明
   - 组成
     1. nil
        - 认识：是一个预先声明的标识符，表示声明了没有赋值，只表示slice/map/channel/point/func/interface六种类型的零值，和null有很多不同点
          1. nil和空不同，nil不会指向底层地址，空会
          1. 设计思想：能不分配的内存就先不分配，nil pointer其实是一切nil值的根本形态，制定很多固定的特殊用法，目的使得nil的使用是非常自然的，这样是好是坏？
        - 特点
          1. nil是不能比较的`nil==nil`
          1. 不同类型nil的指针是一样的，地址都是0x0。不同类型的nil值占用的内存大小可能是不一样的
          1. 不是关键字只是变量名(在buildin/buildin.go中)，如可以定义一个名为nil的变量`var nil = errors.New("11")`不推荐
          1. nil也是有类型的，(*int)(nil)和(interface{})(nil)就是两个不同的变量，即不相等
          1. untyped nil：没有类型的nil，直接写一个nil就是untyped nil
             - 不能直接赋值给变量
             - 可以与一些特定类型的变量进行比较，会根据不同的变量，就会有不同的逻辑
             - 实例
                ```go
                var a = nil                     // 报错
                var a = (*int)(nil)             // 可以
                var _ Conn = (*DBConn)(nil)
                
                var a *B
                print(a == nil)                 // true
                ```
          1. 当一个interface的value和type都unset的时候，它才等于nil
        - 实例
            ```go
            type A interface{}
            type B struct{}
            var a *B

            print(a == nil)                 // true
            print(a == (*B)(nil))           // true
            print((A)(a) == (*B)(nil))      // true，类型都是*B，值都是nil

            print((A)(a) == nil)            // false，结构体的type不是nil
            ```
        - 最佳实践
          1. 检查slice是否为空，请始终使用len(s)==0，而非nil
          1. 作为函数返回值时，不应该明确返回长度为0的slice，应该返回nil代替
   - 方法
     1. 数据操作
        - `len(v T)`：长度，string、array、slice、map、chan、pointer(指向元素的数量)
        - `cap(v T)`：容量，array、slice(返回cap)、chan、pointer(指向元素的数量)
        - `append(slice []T, elems ...T)`、copy(Dst, Src)：slice，容量够重新分配地址以容纳新元素，不够分配新底层数组，变长参数
            ```go
            append(x,4,5,6)                     // 支持多个参数
            append(x,y...)                      // 只支持两个参数，表示把y作为x的类型进行添加
            ```
        - `delete(m map[T]T1, key T)`：map
     1. 资源操作
        - make：只用于slice、map、chan的内存分配，返回有初始值非零的T类型，帮忙将数据初始化好
          1. 因为这三种类型就是引用类型，就没有必要返回他们的指针
        - new：用于任意类型的内存分配，返回传入类型的零值的指针，会将分配出来的内存置零
        - close：`func close(c chan<- Type)`，关闭
     1. 其他
        - 异常
          1. `func panic(v interface{})`
          1. `func recover() interface{}`
        - 复数相关
          1. `func complex(r, i FloatType) ComplexType`
          1. `func real(c ComplexType) FloatType`
          1. `func imag(c ComplexType) FloatType`
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
        - rune：类似int32，代表一个Unicode码，可用来操作中文
        - uintptr：无符号整型，足够大可以容纳任何指针的位模式，跟系统位数有关系，用于存放一个指针
        - 引用：8byte
   - 复合类型：struct、array
   - 引用类型：Slice、Map、Channel、Pointer
   - 派生
     1. func
     1. interface
   - 扩展类型
     1. 组合扩展：struct组合之前的类型
     1. 别名扩展：type定义别名再扩展
   - 特点
     1. 类型零值：变量无初始化时的默认值，可以表现为0，false，""，nil
     1. 类型推导：不指定其类型时，由右值推导得出
     1. 类型转换：T(v)，将值v转换为类型T，不同类型相互转换的时候需要显式转换
     1. 类型别名：type可以定义任何自定义的类型
     1. 类型比较：可不可以比较需要根据类型的特性去判断取舍
        - 不同类型不能比较
        - 可比较的类型：bool、整数、浮点数、复数、字符串、指针、Channel、复合类型
        - 不可比较的类型：slice、map、func
        - 如果复合类型中有不可比较的类型，那么复合类型就不可比较
        - 接口值的动态值不可比较，直接比较会panic
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
   - 最佳实践
     1. string 和 []byte 在底层结构上非常相近，有时这两种类型之间可以通过强转换来避免内存分配
     1. 可以池化字符串，从而帮助编译器只存储一次相同的字符串
     1. 我们可以使用 map（级联）而不是复合键，我们可以使用字节切片。尽量不使用 fmt 包，因为它所有的方法都用到了反射
   - 使用
     1. string转byte数组：`[]byte(str)`
     1. byte数组转string：`string(data[:])`
1. array
   - 认识：数组，`[n]T`，相同类型T的值的定长数组
     1. […]：语法糖，让编译器根据后边元素数量自动推导数组长度
     1. 数组的长度是数组类型的一部分，`[2]int`和`[3]int`是不同的数组类型
        ```go
        arr1 := [2]int{}
        arr2 := [3]int{}
        fmt.Println(arr1 == arr2)           // invalid operation: arr1 == arr2 (mismatched types [2]int and [3]int)
        ```
     1. 赋值和参数传递都是值传递
   - 代码
    ```go
    // 定义
    var a [2]string
    a[0]                // 访问
    a[1] = "World"      // 赋值
    ```
1. slice
   - 认识：切片，`[]T`，相同类型的值的变长序列
     1. 空切片与nil切片
        - 所有空切片的底层引用数组指向的地址都是同一个内存地址，不是nil，没有分配任何内存空间，元素0个
        - 二者append操作对len和cap的效果一样
     1. 由于slice包含了指向底层数据的指针，在复制、作为函数的参数、函数返回值时需要注意
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
   - 最佳实践
     1. 创建slice时，尽可能为make()函数提供一个容量值，如果不能确定，也要预估一个，性能相差4倍
     1. 不要留下不使用的切片部分如果需要从切片中切下一小块并仅使用它，该切片的主要部分也将被保留。正确的做法是，为这小块切片使用新的副本，而将旧的切片扔给 GC
   - 初始化
    ```go
    // 声明
    var s []int                             // 等于nil

    // 定义
    s := []int{}                            // 不等于nil，长度和容量是0

    // 
    s := *new([]int)                        // 等于nil

    // 构造slice，分配一个零长度的数组并且返回一个slice指向这个数组
    s := make([]int, 5)                     // 不等于nil，5个0的元素，不会限制只有5个
    s := make([]int, 0, 5)                  // 0个元素，但是cap=5，返回的是数组切片分配的空间大小

    // 取子切片，s[start(闭区间) : end(开区间) : max(开区间)]，s[start : end]；默认从头、尾开始；和父切片共用底层数组
    s[0:1:4]
    s[1:4]
    s[:3]
    s[4:]
    s[:]                                    // 全部
    ```
   - 使用
    ```go
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

    // 遍历，也适用于map
    for i, v := range pow {}
    for i := range pow {}
    for _, v := range pow {}

    // s []byte为24byte，s [1024]byte为1024byte
    ```
1. map
   - 认识：字典，键值对，`map[keyType]valueType`
     1. key
        - key唯一，必须是可比较的
        - key没有顺序，遍历输出顺序与填充顺序无关，不要期望输出顺序的结果
        - float可以作为map的key，由于精度问题，不要使用
        - struct作为key，如果struct的某个字段值修改了，查询map时无法获取
     1. 返回值可以是一个，可以是两个，第二个用于判断是否存在
     1. 删除并不能释放内存，只会增长，不会减少
     1. map是引用类型，引用类型的变量在使用前必须初始化，未初始化时默认的zero value是nil，此时写入会panic
     1. 运行时检测到同时对map对象有并发访问，就会panic
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
    delete(m, "key")                                    // 并不能释放内存，且没有返回值
    // 检测是否存在，双赋值，ok为bool指示是否存在
    v, ok := m["key"]
    if ok {}
    ```
   - 最佳实践
     1. 尽量少的使用Map，多使用结构体，Map会占用更多的内存且包含指针会增加垃圾回收压力
     1. 空 map 请使用 make(..) 初始化
        ```go
        var (
            // m1 读写安全
            // m2 在写入时会 panic
            m1 = make(map[T1]T2)
            m2 map[T1]T2
        )
        ```
     1. 提前分配内存：初始化指定其大小
     1. 清空 map：map只能增长，不能缩小。我们需要重置map时，删除其所有元素不管用
     1. 尽量不在键值中使用指针：如果 map 中不包含指针，那么GC就不会在上面浪费宝贵的时间。字符串也使用了指针，因此应该使用字节数组而不是字符串作为键
     1. 减少修改次数：同样，我们不想使用指针，可以用map和slice的组合，将键存储在map中，将值存在slice。这样我们就可以不受限制地更改值
   - 常见错误
     1. 未初始化：尤其是在struct中更加容易忘记
        ```go
        var m map[int]int
        fmt.Println(m[100])             // 获取不会panic，会返回零值
        m[100] = 10                     // 会panic
        m := make(map[int]int)          // 先初始化
        ```
     1. 并发读写
        ```go
        var m = make(map[int]int, 10)
        // 初始化一个map
        go func() {
            for {
                m[1] = 1                        // 设置key
            }
        }()
        go func() {
            for {
                _ = m[2]                        // 访问这个map
            }
        }()
        select {}
        ```
   - 并发安全的map
     1. 加读写锁：由于go不支持泛型，实现略显繁琐
        ```go
        type RWMap struct {
            // 一个读写锁保护的线程安全的map
            sync.RWMutex
            // 读写锁保护下面的map字段
            m map[int]int
        }

        func NewRWMap(n int) *RWMap {
            return &RWMap{
                m: make(map[int]int, n),
            }
        }

        func (m *RWMap) Get(k int) (int, bool) {
            m.RLock()
            defer m.RUnlock()
            // 在锁的保护下从map中读取
            v, existed := m.m[k]
            return v, existed
        }
        func (m *RWMap) Set(k int, v int) {
            m.Lock()
            defer m.Unlock()
            m.m[k] = v
        }
        func (m *RWMap) Delete(k int) {
            m.Lock()
            defer m.Unlock()
            delete(m.m, k)
        }
        func (m *RWMap) Len() int {
            m.Lock()
            defer m.RUnlock()
            return len(m.m)
        }
        func (m *RWMap) Each(f func(k, v int) bool) {
            m.Lock()
            defer m.RUnlock()
            for k, v := range m.m {
                if !f(k, v) {
                    return
                }
            }
        }
        ```
     1. 分片
        ```go
        var SHARD_COUNT = 32

        // 分成SHARD_COUNT个分片的map
        type ConcurrentMap []*ConcurrentMapShared

        // 通过RWMutex保护的线程安全的分片，包含一个map
        type ConcurrentMapShared struct {
            items        map[string]interface{}
            sync.RWMutex // Read Write mutex, guards access to internal map.
        }

        // 创建并发map
        func New() ConcurrentMap {
            m := make(ConcurrentMap, SHARD_COUNT)
            for i := 0; i < SHARD_COUNT; i++ {
                m[i] = &ConcurrentMapShared{items: make(map[string]interface{})}
            }
            return m
        }

        // 根据key计算分片索引
        func (m ConcurrentMap) GetShard(key string) *ConcurrentMapShared {
            return m[uint(fnv32(key))%uint(SHARD_COUNT)]
        }
        ```
     1. 分片加锁：性能比以上都好
1. 变量
   - 认识：var或者:=
     1. 类型在变量名后边，避免了类c的含糊不清的定义
     1. 默认类型推导
   - 零值：不指定变量的默认值时，即是零值
     1. 一般：bool false、数值类 0、字符串 ""
     1. nil：slice/map/channel/point/func/interface，只有这6个
   - 分类
     1. 值类型：声明默认分配内存
     1. 引用类型
        - 认识：声明 + 分配内存用于存放值
   - 最佳实践
     1. 若变量类型为 bool 类型，则名称应以 Has, Is, Can 或 Allow 开头
        ```go
        var isExist bool
        var hasConflict bool
        var canManage bool
        var allowGitHook bool
        ```
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
     1. 作用域
        - 分类：局部(花括号内)、全局(函数外)、形式参数(函数定义中)
        - 特点
          1. 局部和全部可以重名，局部变量的改变不会改变全局变量
1. 常量
   - 认识：const，是程序运行时不会被修改的简单值的标识符
     1. 只能是string、bool、数字类型(整数、浮点、复数)
     1. 常量表达式中只能是内置函数，自定义的会报错
     1. 会自动类型推导，分显式类型和隐式类型定义
     1. 作用域
        - 首字母大写可包外
        - 函数体内声明的只在函数体内生效
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
     1. range：后边跟一个可循环的，自动类型推断，可针对string、array、slice、map。`for range`其实是golang的语法糖，在循环开始前会获取其长度，然后再执行固定次数的循环
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
     1. 认识：defer，一般用于异常处理、资源释放、调用栈记录等
        - 在当前函数return前延迟执行函数
        - 所有的defer会压入栈中，先入后出，但是是一层层函数互不影响的
     1. 特点
        - 上层函数panic也会执行defer函数
          1. 每个协程只维护自己的panic、defer、recover链表，只在单个协程中生效
        - 会即时对函数参数进行求值：传递给defer的参数在到达defer时就会确定，之后修改参数不会变
        - 丢弃被修饰函数的返回值
        - 可以影响主函数的返回值：defer在return之前执行
        - 有一定开销, 为节省性能可避免使用
     1. 应用
        - 简化资源回收的同时，安全回收资源
        - 捕获panic异常
     1. 实例
        ```go
        // 安全回收资源
        mu.Lock() 
        defer mu.Unlock()
        ```
1. func 函数
   - 认识：`func xx() [T]{}`，是基本的代码块
     1. 可以返回多个值
     1. 参数传递方式：值传递(默认)、引用传递
     1. 方法的定义：包含了接受者的函数，`func (variable_name variable_data_type) function_name() [return_type]{}`
     1. 没有可选参数，也不支持方法重载
   - 最佳实践
     1. 见名知义，使用动词命名
     1. 长命名并不会使其更具可读性，一份有用的说明文档通常比额外的长名更有价值
     1. 若函数或方法为判断类型（返回值主要为 bool 类型），则名称应以 Has、Is、Can 或 Allow 等判断性动词开头
     1. 使用内联函数或自己内联它们：尝试编写可供编译器内联的小函数，它会很快，甚至快过自己在函数中嵌入代码
     1. 命名返回值：似乎比在函数体中声明更高效
     1. 保存中间结果：帮助编译器优化代码
     1. 仔细地使用defer：尽量不要使用，或者至少不要在循环中使用它
   - 实例
    ```go
    // 定义
    func add(x int, y int) int {            // 参数类型，返回值类型
        return x + y
    }
    // 调用
    aFunc()

    // 直接执行
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
    pos(i)                               // 使用匿名函数


    // 结构体内部的方法类型
    // 声明
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
   - 认识：`var ptr_name *T`，保存变量的内存地址，即间接引用。别人的地址存的是确切的数，指针的地址存的是别的变量的地址，指针类型*T是指向类型T的值的指针，零值是nil
     1. &a：取指针，获取指针
     1. *a：解指针，获取指针对应的值
   - 特点
     1. 二级指针：指向指针的指针变量，第一个指针存放第二个指针的地址，第二个指针存放变量的地址，`var pptr **int`
     1. 值传递和指针传递
        - 值传递：赋值和参数传递时会创建副本赋给对应的变量
          1. 即修改只会影响副本
          1. 复制次数多、复制的值大，造成较大gc压力，使用指针
   - 分类：unsafe.Pointer是桥梁，可以和其他二者相互转换
     1. *：普通类型，只能传递对象地址
     1. unsafe.Pointer：通用类型，用于转换不同类型的指针，不能进行指针运算，不能读取内存存储的值，可以引用内存对象，不被GC
     1. uintptr：运算类型，用于指针运算，GC不将其当指针，即其无法持有对象，表示的地址的数据可能被GC回收
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
   - 最佳实践
     1. 解引用是昂贵的
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
   - 应用场景：在必须传参类型不固定的场景下（业务开发一般用不到）
     1. orm库、json序列化库、运行时
   - 组成
     1. 类型
        - `reflect.Kind`：内置元类型，表示reflect包中定义的十几种，每种有一个整数编号
        - `reflect.Type`：接口
        - `reflect.Value`：结构体类型
     1. 基础反射方法
        - reflect.TypeOf()：，`func TypeOf(v interface{}) Type`，获取type对象，具体类型
        - reflect.ValueOf()：`func ValueOf(v interface{}) Value`，获取value结构体，具体值
          1. CanSet()
          1. Elem()：指针指向的元素类型
   - 最佳实践
     1. 尽量避免使用，涉及内存copy、内存逃逸，性能相对差
     1. 很难实现清晰并可维护的代码，导致代码可读性变差
     1. 优先使用TypeOf，不会产生内存逃逸，性能更高，ValueOf包含了TypeOf
     1. 一定注意不同的数据类型使用对应的函数，否则会导致panic
     1. 官方反射三定律
        - Reflection goes from interface value to reflection object
        - Reflection goes from reflection object to interface value
        - To modify a reflection object, the value must be settable
1. GC
   - 认识
     1. 自动垃圾回收：使用 Go 语言创建对象的时候，我们没有回收 / 释放的心理负担，想用就用，想创建就创建
     1. 如果你想使用 Go 开发一个高性能的应用程序的话，就必须考虑垃圾回收给性能带来的影响
        - GC STW(Stop the World) 的存在大的哈希表是非常要命的
          1. 堆上有4千万个对象，GC的扫描过程就超过了4秒钟
   - local cache的优化思路
     1. offheap（堆外内存），GC 只会扫描堆上的对象，那就把对象都搞到栈上去，但是这样这个缓存库就高度依赖 offheap 的 malloc 和 free 操作了
     1. 参考 freecache 的思路，用 ringbuffer 存 entry，绕过了 map 里存指针
     1. 利用Go 1.5+的特性：当map中的key和value都是基础类型时，GC就不会扫到map里的key和value
   - 拷贝场景
     1. 投射到 interface
     1. chan的接收和发送
     1. 替换map中的元素
     1. 向slice添加元素
     1. 迭代（range）
   - 不会内联的场景
     1. recovery
     1. select 块
     1. 类型声明
     1. defer
     1. goroutine
     1. for-range
1. 运行时
   - 获取goroutine id
     1. 简单方式
        ```go
        func GoID() int {
            var buf [64]byte
            n := runtime.Stack(buf[:], false)
            // 得到 id 字符串
            idField := strings.Fields(strings.TrimPrefix(string(buf[:n]), "goroutine "))[0]
            id, err := strconv.Atoi(idField)
            if err != nil {
                panic(fmt.Sprintf("cannot get goroutine id:, %v", err))
            }
            return id
        }
        ```
     1. hacker方式：每个运行的goroutine结构的g指针保存在当前goroutine的TLS对象中，不同Go版本的goroutine的结构可能不同，常用库`petermattis/goid`
        ```go

        ```
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
   - 方法
     1. 认识：属于结构体的函数，`func (variable_name variable_data_type) function_name() [return_type]{}`
        - 定义在结构体作用域外，在函数声明中指定接收者，除了基础类型或其他包的，可以在任意类型里定义方法
        - 非引用形式是深拷贝，每次调用方法时会复制一个结构体出来，表现为多个方法间对结构体数据的作用相互无影响，结构体内部数据不会被修改
     1. demo
        ```go
        type person struct {
            age int
        }

        func (p person) getAge() int {      // 值接收类型
            return p.age
        }

        func (p *person) growUp() {         // 指针接收类型
            p.age += 1
        }

        u1 := person(age:1)                 // 接收者是值类型的方法，自动实现了接收者是指针类型的方法，编译器实现
        u1.growUp()
        u1.getAge()
        u2 := &person(age:1)                // 反过来不会
        u2.growUp()
        u2.getAge()
        ```
   - 匿名组合：可以直接用父结构体的属性和方法，类似继承
     1. 方法的继承和重写：都支持
     1. 实例
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
   - 最佳实践
     1. 避免拷贝大结构体
     1. 避免通过指针访问结构体字段：解引用是昂贵的，尤其是在循环中。同时也失去使用快速寄存器的能力
     1. 构造结构体时根据字段的大小注意字段顺序，进行内存对齐，以此减小结构体本身的大小
     1. 使用空结构体为值：struct{} 什么都不是（不占内存），因此例如传递信号时，使用它是非常有益的
     1. 当对象内部私有变量类型为map时，千万不要将其作为函数的返回值；这样会对外暴露对象内部状态，而且可能会导致其他意外情况
        ```go
        type Stats struct {
            mu sync.Mutex
            counters map[string]int
        }
        
        // Snapshot 返回当前状态。
        func (s *Stats) Snapshot() map[string]int {
            s.mu.Lock()
            defer s.mu.Unlock()
        
            return s.counters

            // 正确做法：创建map类型的副本并返回
            result := make(map[string]int,len(s.counters))
            for k, v := range s.counters {
                result[k] = v
            }
            return result
        }
        
        // 生成的对象内部counters不再受互斥锁保护，修改snapshot将直接影响stats.counters
        snapshot := stats.Snapshot()
        ```
     1. 带 mutex 的 struct 的接收者 receivers 必须是带指针
        ```go
        type foo struct {
                mutex sync.Mutex
                ...
            }

            // 这里的接收者必须是指针，保证只对同一个锁操作，达到对同一个资源操作的互斥效果。
            func (f *foo) Write (content []byte) error {
                f.mutex.Lock()
                defer f.mutex.Unlock()
                
                ...
            }
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
     1. 类型断言：语法`x.(T)`，形式点+括号+类型，即接口类型向普通类型的转换，运行期确定，通过断言实现类型转换，同时加上判断，防止断言失败导致运行错误。x是类型为interface{}的变量。如：`item.(model.id)`
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
   - 接口和方法
    ```go
    type animal interface {
        code()
        debug()
    }

    type dog struct {
        age int
    }

    func (p dog) getAge() int {
        return p.age
    }

    func (p *dog) growUp() {
        p.age += 1
    }

    var a animal = &dog{age:1}              // 正常，
    var b animal = dog{age:1}               // 报错，dog类型没有实现animal接口，以为growUp指向了dog本身
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
   - 最佳实践
     1. 计算内存分配：请记住，要为接口分配值时，首先需要将其复制到某处，然后将指针黏贴给它。关键是复制。事实证明，接口的装箱和拆箱的成本将近似于结构体大小的一次分配
     1. 选择最优类型：在某些情况下，接口的装箱和拆箱期间没有分配。例如，变量和常量的小值或布尔值、具有一个简单字段的结构体、指针（包括 map、channel、func）
     1. 避免内存分配：与其他地方一样，尽量避免不必要的分配。例如将一个接口分配给另一个接口，而不是装箱两次
     1. 仅在需要时使用：避免在频繁调用的函数参数和返回结果中使用接口。我们不需要额外的拆装包操作。减少使用接口方法调用的频率，因为它会阻止内联
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
### 协程
#### 基本
1. 协程
   - 场景
     1. 不适用：cpu密集、阻塞io，如计算
     1. 适用：异步io密集，如读数据库
   - 价值
     1. 轻量级
        - 需要的内存极小，栈空间默认2k，会自动扩容到1GB(不同架构最大数不同)
        - 切换成本低：无需内核态、需要的上下文更少，堆当栈用
        - 大量的 goroutine 对于调度和垃圾回收的耗时还是会有影响的
     1. 易调度：调度更积极主动，给了我们自己调度的自由
     1. 其他操作耗时的时候让出cpu，不用等待
1. goroutine
   - 认识：协程(coroutine)，是go中最小的执行单位，可实现并发编程、并行计算(多处理器同时运行)
     1. 内部调度器在合适点自动切换
     1. 无锁，无callback(写程序不用，底层有)
     1. 协程间的通信和同步基于csp模型
     1. golang中主goroutine退出程序即结束，系统自动回收运行时资源，所以子goroutine也会释放。应该尽量避免泄露，在常驻服务中执行会越来越不稳，和java不一样
   - 优势
     1. 去掉了冗余的协程生命周期管理
     1. 降低额外延迟和开销：来源是协程间的频繁交互
     1. 降低加解锁的频率
   - 实践
     1. 多协程对于全部变量的操作不是可预估的，需要有锁或者once保证只运行一次
     1. go的func的参数，如果不使用闭包参数，则go在运行到时才去拿for中的那个参数，可能导致不准，go闭包会暂存状态
     1. 没有必要阻塞主流程的，并且有完整日志、报警可用的情况下，可以用协程完成
     1. 每个协程一定要有defer里的recover保护，防止因单一协程引起所有程序全部停止
     1. channel 同步比其他同步原语方法慢
   - demo
    ```go
    go say("hello")
    go say("world")

    go func(i int) {
        i++                     // 没有协程切换的机会，会一直运行
    }(i)                        // 传参的形式保存下来

    // 协程和参数
    sli := []int{1, 2, 3, 4, 5, 6, 7, 8, 9}
	wg := sync.WaitGroup{}
	for k, v := range sli {
		wg.Add(1)
		go func() {                             // 会输出一大堆8或者9什么的，因为for的速度太快了，等for到8、9时，协程才起来，于是多个协程同时调用了当时的k, v
			time.Sleep(time.Second)
			fmt.Println(k, v)
			wg.Done()
		}()
	}
	wg.Wait()
    // 解决方案1：协程使用局部变量，因为局部变量是不共享的
    k1 := k
    v1 := v
    // 解决方案2：将k、v以协程参数的形式传过去
    ```
1. wiki
   - 管道和协程为并发编程提供了优雅的、便利的、与传统并发控制不同的方案，并演化出很多并发模式
     1. 传统并发编程问题是共享数据(内存)如何加锁、同步
   - csp：描述两个独立的并发实体通过共享的通讯channel(管道)进行通信的并发模型，go没有全部都实现
     1. 概念：实体 process，通道 channel
     1. 允许使用进程组件来描述系统，它们独立运行，并且只通过消息传递的方式通信
   - 并发控制模式
     1. chan：原始的同步方式，每多一级就需要多一个chan
     1. waitGroup：限制多个的同步
     1. context：多种控制方式，树级多级模型，可传递数据
#### channel
1. channel
   - 认识：有类型的管道，用于协程间通信，操作符<-
     1. 使得goroutine可以在没有明确的锁或竞态变量(共享内存)的情况下同步，更高级，可以用-race检测数据访问冲突，内部还是有锁的
   - 特性：![avatar](../images/channel_status.webp)
     1. nil的chan
        - 只声明不分配资源，var声明的是，make不是
        - 读写不会报错，永远阻塞
     1. 无缓冲chan
        - 即同步chan，不会存储数据，双方都没准备好，双方都会阻塞
        - 读写不能放一个协程里，写读颠倒会死锁
     1. 有缓冲chan
        - 可以提高性能
        - 缓冲区满时写阻塞，缓冲区空时读会阻塞
     1. 已关闭的chan
        - 只有发送者才能关闭chan，表示再没有值会被发送
        - 通过二参判断是否关闭
        - 读，可以一直读取非阻塞
          1. 有剩余缓存：返回缓存，第二个bool值（是否读成功）为true
          1. 无剩余缓存：返回chan的零值，第二个bool为false
        - 写，会panic
     1. chan中的元素是任意的类型，所以也可能是chan类型
        - <-有个规则，总是尽量和左边的 chan 结合，可以区分属于哪个chan
     1. 操作
        - cap：返回chan的容量
        - len：返回chan中缓存的还未被取走的元素数量
        - for、range：遍历，会等待channel一直到channel被关闭
            ```go
            // 清空ch
            for range ch {}
            ```
        - 双向通道可以赋值给单向,反过来不可以
     1. main协程没有其他协程并且阻塞时，会fatal error deadlock(源码逻辑)
   - 实例
    ```go
    ch := make(chan int)        // ch是一个指针类型
    v := <- ch                  // 读
    ch <- v                     // 写
    foo(<-ch)                   // 作为参数传给函数
    close(ch)                   // 关闭

    // 缓冲chan
    ch := make(chan int, 100)
    ch := make(chan int)

    // 单向chan
    var send chan <- int         // 只能发送
    var receive <- chan int      // 只能接收

    // 简便写法，不断从channel接收值，直到它被关闭，可替换下边判断的写法
    for v := range ch{}         
    // 检测channel是否关闭
    v,ok := <-ch                    
    for{
        v,ok := <- ch
        if ok == false {        // 通道已关闭
            break
        }
    }
    ```
1. select
   - 认识：同时监听多个chan并收发消息，会阻塞直到条件分支中的某个可以继续执行
     1. 可用于多个写，一个读场景
     1. 谁来的快收谁
   - 特性
     1. 每次select都会对所有通信表达式求值
        - `case <- timer.After(time.Second)`：不应该解释为每一秒执行一次，而是其它case如果有一秒都没有执行，那么就执行这个case
     1. 多个都准备好的伪随机选一个
     1. 其他的case不满足则执行default，有default就变为非阻塞，套层for就是循环default，去掉default就是deadlock
        - 一般for和default基本不会同时出现
     1. 读写case中为nil的chan，会直接忽略，永远走不到
   - 实践
     1. case中使用go可能导致go中还没处理完，select又接到了下一步的任务，如果二者有依赖的话导致go之后的流程在go没完成的情况下执行了
     1. 为了让select多次执行套上for
   - 实例
    ```go
    select {
        case ch <- ch1:                               // 如果成功向c信道成功发送数据，则执行该分支
        case <- ch:                                   // 如果从c信道成功接收数据，则执行该分支
        case <- time.After(5 * time.Second):          // 设置超时
        default:

        // 读多个chan，都返回给一个chan
        case n := <- ch1:
        case n := <- ch2:
            out <- n                                // 这样会阻塞
        case out <- n:                              // 这样不会阻塞
    }

    // 将当前goroutine阻塞住
    select {}
    ```
1. channel和基本并发原语
   - 认识
     1. 管道是内置类型，sync、atomic需要引入包才能使用
     1. 管道和基本并发原语是有竞争关系的
     1. 管道用于协调，锁用于同步、并发保护
   - 选择使用准则
     1. 共享资源的并发访问使用传统并发原语
     1. 消息通知机制使用 chan，除非只想signal一个goroutine，才使用 sync.cond

     1. 需要和select结合，使用 chan
     1. 简单等待所有任务的完成用 waitGroup，也有 chan 的推崇者用 chan，都可以
     1. 需要和超时配合时，使用 chan 和 context
     1. 复杂的任务编排和消息传递使用 chan
1. 应用场景
   - 数据传递：将数据从一个goroutine转移到另一个goroutine中，即数据的拥有权 (引用) 托付出去
   - 队列、缓存
     1. 认识：内部实现看是以一个循环队列的方式存放数据，所以可以当成线程安全的queue和buffer使用，解决生产者和消费者的问题
        - 多个goroutine可以并发当作生产者和消费者
        - 多个goroutine可以安全的读写数据
     1. bad demo：解耦生产者、消费者，可以分别设置最大值，提高系统处理能力
        - goroutine数量会爆掉型
            ```go
            for _, payload := range content.Payloads {
                go payload.UploadToS3()
            }
            ```
        - 没解决根本问题型。关键点没有增加处理器的数量，会导致任务堆积，生产、消费还是没有解耦
            ```go
            for _, payload := range content.Payloads {          // 添加任务
                Queue <- payload
            }

            func StartProcessor() {                             // 处理任务
                for {
                    select {
                    case job := <-Queue:
                        job.payload.UploadToS3()
                    }
                }
            }
            ```
     1. good demo
        ```go
        // 正解。创建2个chan，一个用于作业排队，另一个用于控制同时消费的消费者数量
        // 1. 隔离了生产者、消费者
        //    生产者：有JobQueue实现排队，队列满了阻塞
        //           方式：无脑将需要处理的job扔到JobQueue
        //    消费者：共用调度器的消费者池，调度器启动一下子塞满可用的消费者池，有空闲消费者立马取出JobQueue进行处理
        // 2. 实现了生产者、消费者最大数量的控制
        var (                                                       // 控制处理器、排队队列的最大数量
            MaxWorker = os.Getenv("MAX_WORKERS")
            MaxQueue  = os.Getenv("MAX_QUEUE")
        )

        type Job struct {                                           // 任务本身
            Payload Payload
        }

        var JobQueue chan Job                                       // 排队队列

        type Worker struct {                                        // 消费者
            WorkerPool  chan chan Job                                   // 共用的任务池
            JobChannel  chan Job                                        // 任务排队队列
            quit    	chan bool
        }
        func NewWorker(workerPool chan chan Job) Worker {
            return Worker{
                WorkerPool: workerPool,
                JobChannel: make(chan Job),
                quit:       make(chan bool)}
        }

        func (w Worker) Start() {                                   // 开动消费者
            go func() {
                for {
                    
                    w.WorkerPool <- w.JobChannel                    // 将自己注册到共用消费者池，如果共用消费者池满了就阻塞在这里，富余一个消费者等待递补干活

                    select {
                    case job := <-w.JobChannel:                     // 获得一个可处理的请求，并进行处理
                        if err := job.Payload.UploadToS3(); err != nil {
                            log.Errorf("Error uploading to S3: %s", err.Error())
                        }

                    case <-w.quit:                                  // 监听退出信号
                        return
                    }
                }
            }()
        }
        func (w Worker) Stop() {                                    // 退出方法
            go func() {
                w.quit <- true
            }()
        }

        // 调度器，用于管理消费者
        type Dispatcher struct {
            WorkerPool chan chan Job                                // 调度器的消费者池
        }

        func NewDispatcher(maxWorkers int) *Dispatcher {
            pool := make(chan chan Job, maxWorkers)
            return &Dispatcher{WorkerPool: pool}
        }

        func (d *Dispatcher) Run() {
            for i := 0; i < d.maxWorkers; i++ {
                worker := NewWorker(d.pool)
                worker.Start()
            }

            go d.dispatch()                                         // 开始调度
        }

        func (d *Dispatcher) dispatch() {
            for {
                select {
                case job := <-JobQueue:                             // 收到任务
                    go func(job Job) {
                        jobChannel := <-d.WorkerPool                // 尝试获取可用的消费者，会阻塞直到一个消费者空闲
                                                                    // 如果所有消费者都在忙，那么d.WorkerPool是空的，因为被自己拿光了

                        jobChannel <- job                           // 将任务加到任务池
                    }(job)
                }
            }
        }

        // 最终使用，启动调度器 + 添加任务
        dispatcher := NewDispatcher(MaxWorker)
        dispatcher.Run()

        // 添加任务的入口
        func payloadHandler(w http.ResponseWriter, r *http.Request) {
            for _, payload := range content.Payloads {
                work := Job{Payload: payload}
                JobQueue <- work
            }
        }
        ```
   - 锁：模拟为锁
     1. 方式
        - 容量为1的chan，谁接收到谁有锁，放回去就是释放锁
        - 容量为1的chan，谁发送到谁有锁，反之亦然
     1. 搭配功能：TryLock、Timeout
        - select中的default实现TryLock
        - Timer实现Timeout
     1. demo
        ```go
        // 使用chan实现互斥锁
        type Mutex struct {
            ch chan struct{}
        }

        // 使用锁需要初始化
        func NewMutex() *Mutex {
            mu := &Mutex{make(chan struct{}, 1)}
            mu.ch <- struct{}{}
            return mu
        }

        // 请求锁，直到获取到
        func (m *Mutex) Lock() {
            <-m.ch
        }

        // 解锁
        func (m *Mutex) Unlock() {
            select {
            case m.ch <- struct{}{}:
            default:
                panic("unlock of unlocked mutex")
            }
        }

        // 尝试获取锁
        func (m *Mutex) TryLock() bool {
            select {
            case <-m.ch:
                return true
            default:
            }
            return false
        }

        // 加入一个超时的设置
        func (m *Mutex) LockTimeout(timeout time.Duration) bool {
            timer := time.NewTimer(timeout)
            select {
            case <-m.ch:
                timer.Stop()
                return true
            case <-timer.C:
            }
            return false
        }

        // 锁是否已被持有
        func (m *Mutex) IsLocked() bool {
            return len(m.ch) == 0
        }


        func main() {
            m := NewMutex()
            ok := m.TryLock()
            fmt.Printf("locked v %v\n", ok)
            ok = m.TryLock()
            fmt.Printf("locked %v\n", ok)
        }
        ```
   - 信号通知：将信号从一个goroutine传递给另一个或者另一组goroutine
     1. 场景
        - 利用空chan的receiver一直阻塞，实现wait/notify模式
     1. demo
        - 如实现程序优雅退出，退出前给shutdownChan发个信号，如退出程序非常耗时
          1. 给业务也发一个退出信号
          1. 有退出超时逻辑
          1. 代码
            ```go
            func main() {
                var closing = make(chan struct{})
                var closed = make(chan struct{})

                go func() {
                    // 模拟业务处理
                    for {
                        select {
                        case <-closing:
                            return
                        default:
                            // ....... 业务计算
                            time.Sleep(100 * time.Millisecond)
                        }
                    }
                }()

                // 处理CTRL+C等中断信号
                termChan := make(chan os.Signal)
                signal.Notify(termChan, syscall.SIGINT, syscall.SIGTERM)
                <-termChan

                close(closing)                                                  // 告诉业务逻辑协程进行退出，因为业务也用了协程
                // 执行退出之前的清理动作
                go doCleanup(closed)

                select {
                case <-closed:
                case <-time.After(time.Second):
                    fmt.Println("清理超时，不等了")                               // 清理时间兜底
                }
                fmt.Println("优雅退出")
            }

            func doCleanup(closed chan struct{}) {
                time.Sleep((time.Minute))
                close(closed)
            }
            ```
   - 任务编排：击鼓传花，控制goroutine按照一定顺序并发或串行的执行
     1. 流水线模式：一个个轮着来
     1. 扇入模式：多个源channel输入、一个目的channel输出
        ```go
        // 递归模式
        func fanInRec(chans ...<-chan interface{}) <-chan interface{} {
            switch len(chans) {
            case 0:
                c := make(chan interface{})
                close(c)
                return c
            case 1:
                return chans[0]
            case 2:
                return mergeTwo(chans[0], chans[1])
            default:
                m := len(chans) / 2
                return mergeTwo(
                    fanInRec(chans[:m]...),
                    fanInRec(chans[m:]...))
            }
        }

        func mergeTwo(a, b <-chan interface{}) <-chan interface{} {
            c := make(chan interface{})
            go func() {
                defer close(c)
                for a != nil || b != nil { //只要还有可读的chan
                    select {
                    case v, ok := <-a:
                        if !ok { // a 已关闭，设置为nil
                            a = nil
                            continue
                        }
                        c <- v
                    case v, ok := <-b:
                        if !ok { // b 已关闭，设置为nil
                            b = nil
                            continue
                        }
                        c <- v
                    }
                }
            }()
            return c
        }

        // 反射模式
        func fanInReflect(chans ...<-chan interface{}) <-chan interface{} {
            out := make(chan interface{})
            go func() {
                defer close(out)
                // 构造SelectCase slice
                var cases []reflect.SelectCase
                for _, c := range chans {
                    cases = append(cases, reflect.SelectCase{
                        Dir:  reflect.SelectRecv,
                        Chan: reflect.ValueOf(c),
                    })
                }
                
                // 循环，从cases中选择一个可用的
                for len(cases) > 0 {
                    i, v, ok := reflect.Select(cases)
                    if !ok { // 此channel已经close
                        cases = append(cases[:i], cases[i+1:]...)
                        continue
                    }
                    out <- v.Interface()
                }
            }()
            return out
        }
        ```
     1. 扇出模式：和上者相反
        ```go
        func fanOut(ch <-chan interface{}, out []chan interface{}, async bool) {
            go func() {
                defer func() { //退出时关闭所有的输出chan
                    for i := 0; i < len(out); i++ {
                        close(out[i])
                    }
                }()

                for v := range ch { // 从输入chan中读取数据
                    v := v
                    for i := 0; i < len(out); i++ {
                        i := i
                        if async { //异步
                            go func() {
                                out[i] <- v // 放入到输出chan中,异步方式
                            }()
                        } else {
                            out[i] <- v // 放入到输出chan中，同步方式
                        }
                    }
                }
            }()
        }
        ```
     1. Stream模式：把channel当作流式管道使用
        ```go
        // 创建流
        func asStream(done <-chan struct{}, values ...interface{}) <-chan interface{} {
            s := make(chan interface{}) //创建一个unbuffered的channel
            go func() { // 启动一个goroutine，往s中塞数据
                defer close(s) // 退出时关闭chan
                for _, v := range values { // 遍历数组
                    select {
                    case <-done:
                        return
                    case s <- v: // 将数组元素塞入到chan中
                    }
                }
            }()
            return s
        }
        // 方法
        // takeN：只取流中的前n个数据
        func takeN(done <-chan struct{}, valueStream <-chan interface{}, num int) <-chan interface{} {
            takeStream := make(chan interface{}) // 创建输出流
            go func() {
                defer close(takeStream)
                for i := 0; i < num; i++ { // 只读取前num个元素
                    select {
                    case <-done:
                        return
                    case takeStream <- <-valueStream: //从输入流中读取元素
                    }
                }
            }()
            return takeStream
        }
        // takeFn：筛选流中的数据，只保留满足条件的数据
        // takeWhile：只取前面满足条件的数据，一旦不满足条件，就不再取
        // skipN：跳过流中前几个数据
        // skipFn：跳过满足条件的数据
        // skipWhile：跳过前面满足条件的数据，一旦不满足条件，当前这个元素和以后的元素都会输出给 Channel 的 receiver。
        ```

     1. 等待模式：模拟WaitGroup功能，即启动一组goroutine执行任务，然后等待这些任务都完成
     1. Or-Done模式：只要有一个就通知
        - 实现
          1. 当 chan 的数量大于 2 时，使用二分法递归的方式等待信号，case值是个函数，一级级case回来
          1. 数据量多递归用反射代替，最笨的是为每一个channel启动一个goroutine
        - demo
            ```go
            func or(channels ...<-chan interface{}) <-chan interface{} {
                // 特殊情况，只有零个或者1个chan
                switch len(channels) {
                case 0:
                    return nil
                case 1:
                    return channels[0]
                }

                orDone := make(chan interface{})
                go func() {
                    defer close(orDone)

                    switch len(channels) {
                    case 2: // 2个也是一种特殊情况
                        select {
                        case <-channels[0]:
                        case <-channels[1]:
                        }
                    default: //超过两个，二分法递归处理
                        m := len(channels) / 2
                        select {
                        case <-or(channels[:m]...):
                        case <-or(channels[m:]...):
                        }
                    }
                }()

                return orDone
            }

            func sig(after time.Duration) <-chan interface{} {
                c := make(chan interface{})
                go func() {
                    defer close(c)
                    time.Sleep(after)
                }()
                return c
            }

            // 测试程序
            func main() {
                start := time.Now()

                <-or(                                               // 在这里只要一个返回就可以
                    sig(10*time.Second),
                    sig(20*time.Second),
                    sig(30*time.Second),
                    sig(40*time.Second),
                    sig(50*time.Second),
                    sig(01*time.Minute),
                )

                fmt.Printf("done after %v", time.Since(start))
            }
            ```
     1. map-reduce模式
        - 认识
          1. map是协程异步处理，reduce是不断从map生成的结果chan中取数据处理
          1. reduce利用for range实现不close这个chan，就一直取数据处理
        - 代码
            ```go
            // map
            func mapChan(in <-chan interface{}, fn func(interface{}) interface{}) <-chan interface{} {
                out := make(chan interface{}) //创建一个输出chan
                if in == nil { // 异常检查
                    close(out)
                    return out
                }

                go func() { // 启动一个goroutine,实现map的主要逻辑
                    defer close(out)
                    for v := range in { // 从输入chan读取数据，执行业务操作，也就是map操作
                        out <- fn(v)
                    }
                }()

                return out
            }

            // reduce
            func reduce(in <-chan interface{}, fn func(r, v interface{}) interface{}) interface{} {
                if in == nil { // 异常检查
                    return nil
                }

                out := <-in // 先读取第一个元素
                for v := range in { // 实现reduce的主要逻辑
                    out = fn(out, v)
                }

                return out
            }

            // 处理一组整数，map 函数就是为每个整数乘以 10，reduce 函数就是把 map 处理的结果累加起来
            func asStream(done <-chan struct{}) <-chan interface{} {                                    // 生成一个数据流
                s := make(chan interface{})
                values := []int{1, 2, 3, 4, 5}
                go func() {
                    defer close(s)
                    for _, v := range values { // 从数组生成
                        select {
                        case <-done:
                            return
                        case s <- v:
                        }
                    }
                }()
                return s
            }

            func main() {
                in := asStream(nil)

                // map操作: 乘以10
                mapFn := func(v interface{}) interface{} {
                    return v.(int) * 10
                }

                // reduce操作: 对map的结果进行累加
                reduceFn := func(r, v interface{}) interface{} {
                    return r.(int) + v.(int)
                }

                sum := reduce(mapChan(in, mapFn), reduceFn) //返回累加结果
                fmt.Println(sum)
            }
            ```
#### sync
1. 认识：提供了并发编程中基本的同步原语，保证执行不会出现混乱。这是传统的同步机制，是通过共享内存来通信的，更高级别的同步最好通过通道和通信来完成，多协程就要用到sync了
   - sync的同步原语在使用后是不能复制的，因为原变量状态不确定
1. 互斥锁
   - 认识：`sync.Mutex`，保证同时只有一个goroutine能访问一个共享的变量从而避免冲突
     1. 使用不恰当有死锁问题
     1. Mutex的零值是还没有 goroutine 等待的未加锁的状态，所以不需要额外的初始化，直接声明变量即可
   - 特点
     1. 因为Mutex的实现中没有记录哪个 goroutine 拥有这把锁，所以mutex不是可重入的锁，Unlock方法也可以被任意的 goroutine 调用释放锁，所以一定要遵循谁申请、谁释放的原则，尤其注意加解锁不在一个方法里
     1. cas和非公平锁的目的都是为了减少线程的上下文的切换，因为如果我们能够把锁交给正在占用 CPU 时间片的 goroutine 的话，那就不需要做上下文的切换，在高并发的情况下，可能会有更好的性能
   - 方法
     1. `Lock()`
     1. `Unlock()`：作用于未加锁的会panic
     1. `TryLock()`：TryLock的使用通常表明在特定的互斥锁使用中存在更深层次的问题，go一开始说不加的，v1.18
        - 意义在于不会阻塞，要么就加上了锁，要么返回false，lock方法没超时嘛
        - 可用于并发修改，只要有一个成功了就行，其他人撤就可以
   - 使用方法
    ```go
    // 基本语法
    var mu sync.Mutex
    mu.Lock()
    mu.Unlock()

    // 临界区使用：在临界区前面获取锁，在离开临界区的时候释放锁
    c.mux.Lock()                            
    defer c.mux.Unlock()                                    // 非临界区使用的解锁的正确写法

    // 嵌入字段：在struct上直接调用锁方法
    type Counter struct {
        sync.Mutex    
        Count uint64
    }

    // 可以用匿名函数实现逻辑体的加解锁
    func() {     
        c.mux.Lock()
        defer c.mux.Unlock()     
    }()
    ```
   - 易错场景
     1. Lock/Unlock 不是成对出现：保证Lock/Unlock成对出现，尽可能采用 defer mutex.Unlock 的方式，把它们成对、紧凑地写在一起
        - 代码中有太多的 if-else 分支，可能在某个分支中漏写了 Unlock
        - 在重构的时候把 Unlock 给删除了
        - Unlock 误写成了 Lock
     1. Copy已使用的Mutex
     1. 重入：不是可重入的，同一个goroutine重复加锁了
     1. 死锁
        - 如RWMutex：有活跃 reader 的时候，writer 会等待，如果我们在 reader 的读操作时调用 writer 的写操作（它会调用 Lock 方法），那么，这个 reader和 writer 就会形成互相依赖的死锁状态
   - 可重入锁的实现
     1. 记录goroutine id：解决了重入问题，recursion是辅助字段记录次数
        ```go
        // RecursiveMutex 包装一个 Mutex, 实现可重入
        type RecursiveMutex struct {
            sync.Mutex
            owner     int64                                 // 当前持有锁的 goroutine id
            recursion int32                                 // 这个 goroutine 重入的次数
        }

        func (m *RecursiveMutex) Lock() {
            gid := goid.Get()
            // 如果当前持有锁的 goroutine 就是这次调用的 goroutine, 说明是重入
            if atomic.LoadInt64(&m.owner) == gid {
                m.recursion++
                return
            }
            m.Mutex.Lock()
            // 获得锁的 goroutine 第一次调用， 记录下它的 goroutine id, 调用次数加 1
            atomic.StoreInt64(&m.owner, gid)
            m.recursion = 1
        }
        func (m *RecursiveMutex) Unlock() {
            gid := goid.Get()
            // 非持有锁的 goroutine 尝试释放锁， 错误的使用
            if atomic.LoadInt64(&m.owner) != gid {
                panic(fmt.Sprintf("wrongtheowner( % d):%d!", m.owner, gid))
            }
            // 调用次数减 1
            m.recursion--
            if m.recursion != 0 {
                // 如果这个 goroutine 还没有完全释放， 则直接返回
                return
            }
            // 此 goroutine 最后一次调用， 需要释放锁
            atomic.StoreInt64(&m.owner, -1)
            m.Mutex.Unlock()
        }
        ```
     1. 使用token：就是不用goroutine id，需要使用token作为凭证
        ```go
        // Token方式的递归锁
        type TokenRecursiveMutex struct {
            sync.Mutex
            token     int64
            recursion int32
        }

        // 请求锁，需要传入token
        func (m *TokenRecursiveMutex) Lock(token int64) {
            if atomic.LoadInt64(&m.token) == token {
                // 如果传入的 token 和持有锁的 token 一致，
                m.recursion++
                return
            }
            m.Mutex.Lock()
            // 传入的 token 不一致， 说明不是递归调用
            // 抢到锁之后记录这个 token
            atomic.StoreInt64(&m.token, token)
            m.recursion = 1
        }

        // 释放锁
        func (m *TokenRecursiveMutex) Unlock(token int64) {
            if atomic.LoadInt64(&m.token) != token {
                // 释放其它 token 持有的锁
                panic(fmt.Sprintf("wrongtheowner(%d):%d!", m.token, token))
            }
            m.recursion--
            // 当前持有这个锁的 token 释放锁
            if m.recursion != 0 {
                // 还没有回退到最初的递归调用
                return
            }
            atomic.StoreInt64(&m.token, 0)

            // 没有递归调用了，释放锁
            m.Mutex.Unlock()
        }
        ```
   - 基本同步原语模拟TryLock
    ```go
    const (
        mutexLocked      = 1 << iota // 加锁标识位置
        mutexWoken                   // 唤醒标识位置
        mutexStarving                // 锁饥饿标识位置
        mutexWaiterShift = iota      // 标识 waiter的起始bit位置
    )

    // 扩展一个 Mutex 结构
    type Mutex struct {
        sync.Mutex
    }

    // 尝试获取锁
    func (m *Mutex) TryLock() bool {
        // 如果能成功抢到锁
        if atomic.CompareAndSwapInt32((*int32)(unsafe.Pointer(&m.Mutex)), 0, mutexLocked) {
            return true
        }

        // 如果处于唤醒、 加锁或者饥饿状态， 这次请求就不参与竞争了， 返回 false
        old := atomic.LoadInt32((*int32)(unsafe.Pointer(&m.Mutex)))
        if old&(mutexLocked|mutexStarving|mutexWoken) != 0 {
            return false
        }
        // 尝试在竞争的状态下请求锁
        newed := old | mutexLocked
        return atomic.CompareAndSwapInt32((*int32)(unsafe.Pointer(&m.Mutex)), old, newed)
    }
    ```
   - 模拟协程安全的队列：结合slice
    ```go
    type SliceQueue struct {
        data []interface{}
        mu   sync.Mutex
    }

    func NewSliceQueue(n int) (q *SliceQueue) {
        return &SliceQueue{data: make([]interface{}, 0, n)}
    }

    // Enqueue 把值放在队尾
    func (q *SliceQueue) Enqueue(v interface{}) {
        q.mu.Lock()
        q.data = append(q.data, v)
        q.mu.Unlock()
    }

    // Dequeue 移去队头并返回
    func (q *SliceQueue) Dequeue() interface{} {
        q.mu.Lock()
        if len(q.data) == 0 {
            q.mu.Unlock()
            return nil
        }
        v := q.data[0]
        q.data = q.data[1:]
        q.mu.Unlock()
        return v
    }
    ```
1. 读写互斥锁
   - 认识：`sync.RWMutex`，变为并行读，在某一时刻只能由任意数量的reader持有，或者是只被单个的writer持有
     1. 零值是未加锁的状态，声明或嵌入struct都不必显式初始化
     1. 应用场景：可以明确区分reader和writer goroutine的场景，且有大量的并发读、少量的并发写，并且有强烈的性能需求
   - 方法
     1. RLock()/RUnlock()：读时用，如果锁已经被writer持有会一直阻塞
     1. Lock()/Unlock()：写时用，如果锁已经被reader或writer持有会一直阻塞
     1. RLocker()：返回读对象
   - 使用方法：同Mutex
1. 同步器
   - 认识：`sync.WaitGroup`，是信号量，需要某个条件完成才能继续，解决的是并发 - 等待的问题，用于并发控制/并发编排/任务编排
     1. 场景：在一个goroutine等待一组goroutine执行完成的通知时
     1. 原理：拥有一个内部计数器。当计数器等于0时，则Wait()方法会立即返回。否则一直阻塞执行Wait()方法的goroutine
     1. 特点：WaitGroup 是可以重用的
     1. 替代实现：低级的用轮询实现，初级的可以多用一个done的channel阻塞实现等待某个goroutine结束的通知，每次循环进出这个channel；多个可以使用通道切片来分别存储，使用waitGroup更加高效优雅
     1. 类似
        - linux中的barrier
        - pthread(POSIX 线程)中的barrier
        - c++中的std::barrier
        - java中的CyclicBarrier、CountDownLatch
   - 方法
     1. `Add(n)`：设置计数器数量n，传负数就是减n
     1. `Done()`：计数器数量减一
     1. `Wait()`：等待，调用这个方法的goroutine会同步等待所有记录的协程全部结束
   - demo
    ```go
    var wg sync.WaitGroup
    
    wg.Add(2)
    go func() {
        defer wg.Done()
    }()
    go func() {
        defer wg.Done()
    }()

    wg.Wait()                           // 阻塞，使其等待
    ```
   - 常见问题
     1. 进行了复制
        ```go
        type TestStruct struct {
            Wait sync.WaitGroup
        }

        func main() {
            w := sync.WaitGroup{}
            w.Add(1)
            t := &TestStruct{
                Wait: w,
            }
            t.Wait.Done()
            fmt.Println("Finished")
        }
        ```
     1. 计数器设置为负
     1. 不期望的Add时机：add和done写在了一起，wait不起作用，可以提前add好
     1. 前一个Wait还没结束就重用WaitGroup：因为可重用，如果没有恢复到零值就重用会panic
1. 条件变量/发送信号
   - 认识：`sync.Cond`，为等待/通知场景下的并发问题提供支持，通常应用于等待某个条件的一组goroutine，等条件变为true时其中一个或所有的goroutine都会被唤醒执行。用于发出信号（一对一）或广播信号（一对多）到goroutine，特定场景
     1. caller和waiter的数量对应是不确定的，如N:M
     1. 原理：关联的Locker实例可以通过c.L访问，它内部维护着一个先入先出的等待队列，操作是移除并唤醒
     1. 违反go的基本原则：不要通过共享进行通信；而是通过通信共享
     1. 有人认为Cond是唯一难以掌握的Go并发原语
   - 比较
     1. 可以通过channel、waitGroup代替通知，实现更简洁，不容易出错，好多都被替换了
        - Channel 被 close 掉了之后不支持再open，可以加for一直监听嘛
        - waitGroup只支持确定的数量，cond支持任意多
     1. Cond三点特性是channel无法替代的
        - 和一个Locker关联，可以利用这个 Locker 对相关的依赖条件更改提供保护
        - 可以同时支持signal和broadcast方法，channel只能同时支持一种
        - Broadcast 方法可以被重复调用。等待条件再次变成不满足的状态后，我们又可以调用 Broadcast 再次唤醒等待的 goroutine。这也是 Channel 不能支持的，适用于每次改变了就通知
   - 方法：是计算机科学中条件变量的通用方法名
     1. `NewCond()`：创建，需要关联一个Locker接口的实例
     1. `Signal`：唤醒一个，从等待队列中移除第一个goroutine并唤醒
     1. `Broadcast`：唤醒所有
     1. `Wait`：将调用者放入Cond的等待队列中并阻塞，直到被唤醒
        - 要求持有c.L的锁，即加锁，上边俩不要求
        - waiter goroutine 被唤醒不等于等待条件被满足，需要进一步检查，因为不知道前N-1个被唤醒的waiter所作的修改是否使等待条件再次成立
   - demo
    ```go
    // 复杂在于：一，这段代码有时候需要加锁，有时候可以不加；二，Wait 唤醒后需要检查条件；三，条件变量的更改，其实是需要原子操作或者互斥锁保护的
    c := sync.NewCond(&sync.Mutex{})
	var ready int
	for i := 0; i < 10; i++ {
		go func(i int) {
			time.Sleep(time.Duration(rand.Int63n(10)) * time.Second)
			// 加锁更改等待条件
			c.L.Lock()
			ready++
			c.L.Unlock()
			log.Printf("运动员#%d已准备就绪\n", i)
			// 广播唤醒所有的等待者
			c.Broadcast()
		}(i)
	}
	c.L.Lock()
	for ready != 10 {
		c.Wait()
		log.Println("裁判员被唤醒一次")
	}
	c.L.Unlock()
	// 所有的运动员是否就绪
	log.Println("所有运动员都准备就绪。比赛开始，3，2，1,.....")
    ```
   - 常见错误
     1. 调用 Wait 的时候没有加锁
     1. 只调用了一次 Wait，没有检查等待条件是否满足，结果条件没满足，程序就继续执行了：因为每次都会唤醒等待着
1. 并发池
   - 认识：`sync.Pool`，可以保存池化的、临时的、多协程安全的对象
     1. 可以有效地减少新对象的申请
     1. 池化的对象可能会被垃圾回收掉，对于长连接等场景不合适
   - 背景
     1. 性能优化之对象池：把重复使用的对象回收起来避免被垃圾回收掉，这样使用的时候就不必在堆上重新创建了，减轻重新创建的成本，减轻垃圾收集器的压力
     1. gc耗时特别高，有大量的相同类型的临时对象不断地被创建销毁时
   - 方法
     1. `New()`：没有元素可返回时，会调用New方法创建
     1. `Get()`：随机移除返回，没有元素并且不设置New方法返回nil，无法保证以固定的顺序
     1. `Put()`：放到池中，给nil会忽略
   - 常见问题
     1. 内存泄漏：在使用 sync.Pool 回收 buffer 的时候，一定要检查回收的对象的大小。如果 buffer 太大，就不要回收了，否则就太浪费了
        - 因为 Pool 回收的机制，重新放回的大的Buffer(slice类型)可能不被回收，而是会一直占用很大的空间，这属于内存泄漏的问题
          1. 改成放回的超过一定大小的 buffer，就直接丢弃掉，不再放到池子中
     1. 内存浪费：大buffer中只用到很少一部分
        - 将buffer按照大小分层，分层依据：512 bytes、1k、4k
   - 常用三方库
     1. bytebufferpool：提供了校准（calibrate，用来动态调整创建元素的权重）的机制，可以“智能”地调整 Pool 的 defaultSize 和 maxSize。一般来说，我们使用 buffer size 的场景比较固定，所用 buffer 的大小会集中在某个范围里。有了校准的特性，bytebufferpool 就能够偏重于创建这个范围大小的 buffer，从而节省空间
     1. oxtoacart/bpool：保持持池子中固定的元素数量，多了丢弃，sync.Pool是没有限制的；bpool基于channel实现，性能不如原生
        - BufferPool：元素类型bytes.Buffer
        - BytesPool：元素类型byte slice
        - SizedBufferPool：限制最大大小
   - 场景引申
     1. 有大量的相同类型的临时对象，不断地被创建销毁：sync.Pool
     1. 大量的并发Client请求：池化Client
     1. goroutine数量非常多：通过Worker Pool降低数量
1. 只执行一次
   - 认识：`sync.Once`，一个函数在所有goroutine执行且仅执行一次，常用于单例对象的初始化或只需初始化一次的共享资源的场景
   - 方法
     1. `Once.Do(f func())`：只有这一个，可以多次调用但只有第一次才执行，f是无参数无返回值的函数
        - 在一个文件中多次调用，只有第一次执行，即使f不同
   - go的初始化方式
     1. package级别的变量
     1. 在init函数中
     1. 执行自定义初始化函数
   - 常见错误
     1. 死锁：f中再次执行Once.Do()
     1. 未初始化：f 方法执行的时候 panic，或者f方法失败
     1. 内部实现不熟悉：内部用了锁
        ```go
        type Once struct {
            m sync.Mutex
        }

        func (o *Once) doSlow() {
            o.m.Lock()
            defer o.m.Unlock()
            // 这里更新的o指针的值!!!!!!!, 会导致上一行Unlock出错。因为修改Once的指针后，上边Lock的指针变为了一个未加锁的Locker，Unlock就报错了
            *o = Once{}
        }
        func main() {
            var once Once
            once.doSlow()
        }
        ```
   - 应用案例
     1. 支持查询是否初始化过版
        ```go
        // Once是一个扩展的sync.Once类型，提供了一个Done方法
        type Once struct {
            sync.Once
        }

        // Done返回此Once是否执行过
        // 如果执行过则返回true
        // 如果没有执行过或者正在执行，返回false
        func (o *Once) Done() bool {
            return atomic.LoadUint32((*uint32)(unsafe.Pointer(&o.Once))) == 1
        }
        func main() {
            var flag Once
            // false
            fmt.Println(flag.Done())
            flag.Do(func() {
                time.Sleep(time.Second)
            })
            // true
            fmt.Println(flag.Done())
        }
        ```
     1. 返回当前调用 Do 方法是否正确完成、初始化失败后如果再调用 Do 方法会再次尝试初始化
        ```go
        // 一个功能更加强大的Once
        type Once struct {
            m    sync.Mutex
            done uint32
        }

        // 传入的函数f有返回值error如果初始化失败，需要返回失败的error
        // Do方法会把这个error返回给调用者
        func (o *Once) Do(f func() error) error {
            if atomic.LoadUint32(&o.done) == 1 {
                // fast path
                return nil
            }
            return o.slowDo(f)
        }

        // 如果还没有初始化
        func (o *Once) slowDo(f func() error) error {
            o.m.Lock()
            defer o.m.Unlock()
            var err error
            // 双检查，还没有初始化
            if o.done == 0 {
                err = f()
                // 初始化成功才将标记置为已初始化
                if err == nil {
                    atomic.StoreUint32(&o.done, 1)
                }
            }
            return err
        }
        ```
1. `sync/singleflight`
   - 认识：重复函数调用抑制
1. 并发版map
   - 认识：`sync.Map`，并发安全版的基于特定场景的map
     1. RWLock配合map方案在高读取+多核cpu上表现不佳，为了改善多核读多写少的性能而引入
     1. 普通map并发操作下会panic，对sync.Map的读写，不需要加锁
   - 使用场景
     1. 只会增长的缓存系统中，读多写少
     1. 多个goroutine为不相交的键集读、写、重写键值对
   - 特性
     1. 和普通map相比，仅遍历的方式略有区别
     1. 所有的key和value都是interface{}，换言之失去了类型检查
     1. 一旦使用不能复制
   - 方法
     1. Load()：检索
     1. Range()：遍历，支持在多goroutine下运作，能确保每个key最多被处理一次，但是无法保证遍历过程中实时同步其他goroutine的增删操作
        ```go
        x.Range(func(k, v interface{}) bool {
            err := v.(error)
            if err != nil {
                return false
            }
            return true
        })
        ```
     1. Store()：添加
     1. Delete()：删除
     1. LoadOrStore()：检索或新增
1. wiki
   - 临界区：受影响的最小范围，要最小化锁粒度，提高性能
   - race detector：检测并发访问共享资源是否有问题的工具，基于Google的C/C++ sanitizers。编译器通过探测所有的内存访问(加入代码能监视对这些内存地址的访问（读还是写）)。在代码运行的时候，race detector 就能监控到对共享变量的非同步访问
     1. 只能通过真正对实际地址进行读写访问的时候才能探测，所以它并不能在编译的时候发现
     1. 而且，在运行的时候，只有在触发了 data race 之后，才能检测到，如果碰巧没有触发也是检测不到
   - vet：可以发现死锁和一些并发问题，go有在运行时检查死锁的机制
     1. 如对Mutex进行复制的问题
##### atomic
1. 认识：`sync.atomic`，实现了同步算法底层的原子的内存操作原语，提供实现原子操作的方法
   - 这个是保护一个值，逻辑需要自己处理，channel/sync可以同步保护一段逻辑
   - 很多场景中，使用并发原语实现起来比较复杂，而原子操作可以帮助我们更轻松地实现底层的优化，不需要复杂的逻辑
     1. 比如特简单的flag场景
     1. 比如简单的实现配置对象的更新和加载
     1. 在实现lock-free的数据结构时，我们可以不使用互斥锁这样就不会让线程因为等待互斥锁而阻塞休眠，而是让线程保持继续处理的状态。另外，不使用互斥锁的话，lock-free的数据结构还可以提供并发的性能
   - 提供了非常好的支持各种平台的一致性的API
1. 特点
   - atomic操作的对象是一个地址，要把可寻址的变量的地址作为参数传递给方法，而不是变量值
1. 组成
   - 操作的对象：6个，int32/int64/uint32/uint64/uintptr/unsafe.Pointer(Add方法不支持)
   - 类型
     1. Value：可以原子地存取对象类型，只能存取，不能CAS和Swap，常用在配置变更等场景
   - 方法：即使在多处理器、多核、有CPU cache的情况下也是一个原子操作
     1. `LoadInt32(&addr)`：读取
     1. `StoreInt32(&addr,newaddr)`：存储，别的协程不会看到存了一半的值
     1. `AddInt32(&addr,n)`：增减，n负数为减，只能操作数值类
     1. `SwapInt32(&addr,newaddr)`：直接交换，不管旧值，可以返回旧值
     1. `CompareAndSwapInt32(&addr,old,new)`：比较并交换，Compare And Swap 即CAS，判断相等才替换，比较当前addr地址的值是不是old，如果不等于old，就返回false；如果等于old，就把此地址的值为new
1. 实践
   - 无符号整数和uinptr类型实现减去一个值：利用计算机补码的规则
    ```go
    AddUint32(&x, ^uint32(c-1))
    // 减1简化为
    AddUint32(&x, ^uint32(0))
    ```
   - 第三方库
     1. uber-go/atomic：封装了几种与常见类型相对应的原子操作，类型如Bool、Duration、Error、Float64、String，操作如CAS、Store、Swap、Toggle、MarshalJSON等
1. demo
   - 多协程等待通知，就加载最新的配置
    ```go
    type Config struct {
        NodeName string
        Addr     string
        Count    int32
    }

    func loadNewConfig() Config {
        return Config{
            NodeName: "北京",
            Addr:     "10.77.95.27",
            Count:    rand.Int31(),
        }
    }
    func main() {
        var config atomic.Value                                                 // 使用具备原子操作的结构体
        config.Store(loadNewConfig())
        var cond = sync.NewCond(&sync.Mutex{})
        // 设置新的config
        go func() {
            for {
                time.Sleep(time.Duration(5+rand.Int63n(5)) * time.Second)
                config.Store(loadNewConfig())
                // 通知等待着配置已变更
                cond.Broadcast()
            }
        }()
        go func() {
            for {
                cond.L.Lock()
                cond.Wait()
                // 等待变更信号
                c := config.Load().(Config)
                // 读取新的配置
                fmt.Printf("newconfig:%+v\n", c)
                cond.L.Unlock()
            }
        }()
        select {}
    }
    ```
   - 使用atomic实现Lock-Free queue：先入先出
    ```go
    主要逻辑
    // 使用一个辅助头指针（head），头指针不包含有意义的数据，只是一个辅助的节点，这样的话，出队入队中的节点会更简单
    // 入队的时候，通过CAS操作将一个元素添加到队尾，并且移动尾指针
    // 一个是queue自身的头、尾指针，一个是节点里的移动下一跳指针
    // 出队的时候移除一个节点，并通过CAS操作移动head指针，同时在必要的时候移动尾指针


    // lock-free的queue
    type LKQueue struct {
        head unsafe.Pointer
        tail unsafe.Pointer
    }

    // 通过链表实现，这个数据结构代表链表中的节点
    type node struct {
        value interface{}
        next  unsafe.Pointer
    }

    func NewLKQueue() *LKQueue {
        n := unsafe.Pointer(&node{})
        return &LKQueue{head: n, tail: n}
    }

    // 入队
	func (q *LKQueue) Enqueue(v interface{}) {
		n := &node{value: v}
		for {
			tail := load(&q.tail)
			next := load(&tail.next)
			// 下边开始每一步都是原子操作
			// 尾还是尾 ———— 因为并发的存在，需要看下上边拿到的尾巴是否还处于尾部，不是的话，需要利用for循环重来，粗粒度的更早放弃争抢节约性能
			if tail == load(&q.tail) {
				// 还没有新数据入队 ———— 因为并发的存在，需要判断是否修改当前拿到tail，因为tail可能继续改变
				if next == nil {
					// 增加到队尾
					// 证明确实拿到了队尾
					if cas(&tail.next, next, n) {
						// 入队成功，移动尾巴指针 ———— 再修改尾巴指针为新加入的
						cas(&q.tail, tail, n)
						return
					}
				} else {
					// 已有新数据加到队列后面，需要移动尾指针 ———— 弥补没来得及改的next值？
					cas(&q.tail, tail, next)
				}
			}
		}
	}

    // 出队，没有元素则返回nil
	func (q *LKQueue) Dequeue() interface{} {
		for {
			head := load(&q.head)
			tail := load(&q.tail)
			next := load(&head.next)
			// head还是那个head
			if head == load(&q.head) {
				// head和tail一样
				if head == tail {
					// 是空队列
					if next == nil {
						return nil
					}
					// 只是尾指针还没有调整，弥补尝试调整它指向下一个
					cas(&q.tail, tail, next)
				} else {
					// 读取出队的数据
					v := next.value
					// 既然要出队了，头指针移动到下一个
					if cas(&q.head, head, next) {
						// Dequeue is done，return
						return v
					}
				}
			}
		}
	}

    // 将unsafe.Pointer原子加载转换成node
    func load(p *unsafe.Pointer) (n *node) {
        return (*node)(atomic.LoadPointer(p))
    }

    // 封装CAS, 避免直接将*node转换成unsafe.Pointer
    func cas(p *unsafe.Pointer, old, new *node) (ok bool) {
        return atomic.CompareAndSwapPointer(p, unsafe.Pointer(old), unsafe.Pointer(new))
    }
    ```
1. wiki
   - 泛型支持后atomic的API会清爽很多
   - cpu的单条指令是原子的，多核处理器的实现比较复杂，不同架构cpu提供了不同的原子操作指令
   - 由于cpu的cache、指令重排，可见性的存在，cpu采用内存屏障(memory fence，管道中所有写都刷新到内存中)保证数据正确性
   - 内存对齐用一条指令写内存可防止多条指令对于内存的撕裂写(torn write)
#### context
1. 认识：控制生命周期、追踪协程之间的调用树(上下文树，继承衍生)，在这些树中传递通知和元数据，用在发生超时、主动取消、产生异常时需要进行的抢占、中断其他等后续操作，是一种协程调度的方式。v1.7
   - 使用一条context链贯穿Server、Connection、Request等，可以将上游的信息共享给下游任务、可发送取消所有下游任务的信号
   - context本身是不可变的，是线程安全的，可以放心地在多个协程中传递使用
   - 底层依赖channel实现
   - v1.7加入标准库
   - 问题：Context在函数里满天飞，还支持了超时、截止时间方法等“额外”方法
1. 应用场景
   - 上下文信息传递：如http的链路信息传递
   - 控制子goroutine的运行、取消、超时
1. 组成
   - `type CancelFunc`：取消方法
   - `type Context`：初始化
     1. 默认：`Context.Background()`，返回非nil的、空的、不会被取消的、无截止时间、无超时的context。作为初始节点，方便以后初始化cancelCtx, timerCtx。通常在主方法、初始化、测试时用
     1. 未定：`Context.TODO()`，返回非nil的、空的、不会被取消的、无截止时间、无超时的context。不清楚是否使用或目前还不知道要传递什么上下文信息的时候使用。这俩底层实现一样，仅仅是约定俗成
     1. 传值：`Context.WithValue()`，复制类型为valueCtx的父Context，保存一个kv对，用于传递数据
        - 优先从自己存储中检查key，不存在会一级级从parent中继续检查直到顶
   - 方法
     1. 取消方法：`WithCancel()`，创建基于parent的可取消的cancelCtx类型的副本，返回一个context和一个CancelFunc，调用CancelFunc即可触发cancel操作
        - 会向下传递不会向上传递，cancelCtx取消时会将后代节点中所有cancelCtx类型的Context都取消
        - 处理完后需要调用CancelFunc否则资源占用不释放，可以使用defer确保
     1. 截止时间：`WithDeadline()`，创建一个基于parent的可取消的context，其过期时间deadline不晚于所设置时间
        - 如果它的截止时间晚于parent的截止时间就以parent的为准，因为parent的截止时间到了就会取消这个cancelCtx
        - 如果当前时间已经超过了截止时间，就直接返回一个已经被cancel的timerCtx
     1. 超时时间：`WithTimeout()`，类似WithDeadline，时间是相对当前时间的过期时长
1. 最佳实践
   - 使用
     1. 一般函数第一个形参通常都为变量命名为ctx的context
     1. 不将nil作为Context类型的参数值，用Background或TODO创建一个空的
     1. 只用来临时做函数之间的上下文透传，不持久化 
     1. key的类型不应该是字符串类型或者其它内建类型，否则容易在包之间使用Context时产生冲突。使用WithValue时，key应是自定义类型
     1. 常常使用struct{}作为定义key的底层类型。对于exported key的静态类型，常常是接口或指针。这样可以尽量减少内存分配
     1. context.WithValue()只用于传输流程和API的请求范围数据，不要用它来传递可选参数
     1. 不要把context存储在结构体中，而是要显式地进行传递
   - 要尽早地调用才能尽早释放资源，不要单纯地依赖截止时间被动取消
1. 实例
    ```go
    ctx= context.TODO()
    ctx = context.WithValue(ctx, "key1", "0001")
    ctx = context.WithValue(ctx, "key2", "0001")
    ctx = context.WithValue(ctx, "key3", "0001")
    ```
1. demo
   - demo1
    ```go
    // WithTimeout相关，子线程监听主线程传入的ctx实现监听主线程状态，一旦ctx.Done()返回子线程即可获知主线程超时

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
		case <-ctx.Done():                                              // goroutine需要尝试检查Context的Done是否关闭
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
#### 扩展并发原语
1. 信号量
   - 认识：Semaphore，是用来控制(保护)多个goroutine同时访问多个资源的并发原语，比如数据库连接池、一组客户端的连接
     1. 优势：在批量获取资源的场景中，我建议你尝试使用官方扩展的信号量
   - 操作
     1. P：减少
     1. V：增加
   - 分类
     1. 计数信号量：计数使用数字可以是任意值，到达某个特殊值时有固定操作
     1. 二进位信号量：计数值只能是0或者1，就是互斥锁了
   - go使用
     1. go的扩展包：Weighted，使用互斥锁+List实现
     1. go内部：信号量的P/V操作通过函数实现
        ```go
        type Mutex struct {
            state int32
            sema  uint32                // 这个就是信号量
        }

        func runtime_Semacquire(s *uint32)
        func runtime_SemacquireMutex(s *uint32, lifo bool, skipframes int)
        func runtime_Semrelease(s *uint32, handoff bool, skipframes int)
        ```
1. SingleFlight
   - 认识：请求合并，多个goroutine同时调用同一个函数，只让一个goroutine去执行，且返回时给到所有goroutine，减少并发调用的数量，go开发组提供
     1. 和sync.Once的区别是只有一次，而SingleFlight主要用在合并并发请求的场景中
     1. 使用互斥锁Mutex和Map实现
     1. 特别适合缓存击穿场景
   - 组成
     1. 类型：Group
     1. 方法
        - Do()：通过传入一个key识别在同一时间只有一个在执行，其他并发的请求会等待。第一个执行的请求返回的结果，就是它的返回结果。shared表示是否返回给多个请求
        - DoChan()：类似Do，只不过返回一个chan，有了结果能从这个chan接收
        - Forget()：忘记，对这个key不进行合并
1. CyclicBarrier
   - 认识：循环栅栏，可重用，用来控制一组请求同时执行的数据结构，用于重复进行一组goroutine同时执行的场景中。大家都到后放开栅栏通过，类似java的CountDownLatch/CyclicBarrier，C#的Barrier
     1. 允许一组 goroutine 彼此等待，到达一个共同的执行点
     1. 和WaitGroup，
        - WaitGroup：适用“一个goroutine等待一组goroutine到达同一个执行点”或者不需要重用的场景，重用需要小心翼翼，需要保证将WaitGroup的计数值重置到n的时候不会出现并发问题
        - CyclicBarrier：适合在“固定数量的 goroutine 等待同一个执行点”场景中
   - 方法
     1. New()：指定循环栅栏参与者的数量
     1. NewWithAction()：额外提供一个函数可以在每一次到达执行点的时候执行一次。具体的时间点是在最后一个参与者到达之后、其它参与者还未被放行之前。可以利用它做放行之前一些共享状态的更新等操作
   - demo
    ```go
    // 三条产线，生产氢原子，氧原子，最后等待一起输出水
    // 定义水分子合成的辅助数据结构
    type H2O struct {
        // 氢原子的信号量
        semaH *semaphore.Weighted
        // 氧原子的信号量
        semaO *semaphore.Weighted
        // 循环栅栏， 用来控制合成
        b cyclicbarrier.CyclicBarrier
    }

    func New() *H2O {
        return &H2O{
            // 氢原子需要两个
            semaH: semaphore.NewWeighted(2),
            // 氧原子需要一个
            semaO: semaphore.NewWeighted(1),
            // 需要三个原子才能合成1
            b: cyclicbarrier.New(3),
        }
    }

    func (h2o *H2O) hydrogen(releaseHydrogen func()) {
        h2o.semaH.Acquire(context.Background(), 1)
        // 输出H
        releaseHydrogen()
        // 等待栅栏放行
        h2o.b.Await(context.Background())
        // 释放氢原子空槽
        h2o.semaH.Release(1)
    }

    func (h2o *H2O) oxygen(releaseOxygen func()) {
        h2o.semaO.Acquire(context.Background(), 1)
        releaseOxygen()
        // 输出O
        h2o.b.Await(context.Background())
        // 等待栅栏放行
        h2o.semaO.Release(1)
        // 释放氢原子空槽
    }

    func TestWaterFactory(t *testing.T) {
        // 用来存放水分子结果的channel
        var ch chan string
        releaseHydrogen := func() {
            ch <- "H"
        }
        releaseOxygen := func() {
            ch <- "O"
        }
        // 300个原子，300个goroutine, 每个goroutine并发的产生一个原子
        var N = 100
        ch = make(chan string, N*3)
        h2o := New()
        // 用来等待所有的goroutine完成
        var wg sync.WaitGroup
        wg.Add(N * 3)
        // 200个氢原子goroutine
        for i := 0; i < 2*N; i++ {
            go func() {
                time.Sleep(time.Duration(rand.Intn(100)) * time.Millisecond)
                h2o.hydrogen(releaseHydrogen)
                wg.Done()
            }()
        }
        // 100个氧原子goroutine
        for i := 0; i < N; i++ {
            go func() {
                time.Sleep(time.Duration(rand.Intn(100)) * time.Millisecond)
                h2o.oxygen(releaseOxygen)
                wg.Done()
            }()
        }
        // 等待所有的goroutine执行完
        wg.Wait()
        // 结果中肯定是300个原子
        if len(ch) != N*3 {

            t.Fatalf("expect %d atom but got %d", N*3, len(ch))
        }
        // 每三个原子一组，分别进行检查。要求这一组原子中必须包含两个氢原子和一个氧原子，这样才能
        var s = make([]string, 3)
        for i := 0; i < N; i++ {
            s[0] = <-ch
            s[1] = <-ch
            s[2] = <-ch
            sort.Strings(s)
            water := s[0] + s[1] + s[2]
            if water != "HHO" {
                t.Fatalf("expect a water molecule but got %s", water)
            }
        }
    }
    ```
#### 特定场景的应用
1. 通过设置为缓存通道，实现抢购场景的解决方案
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
1. 超时控制：使用channel的阻塞特性
   - 简单啰嗦版
    ```go
    timeoutCh := make(chan struct{}, 1)
    go func() {
        time.Sleep(100 * time.Millisecond)
        timeoutCh <- struct{}{}
    }()
    ```
   - `case <-time.After(100 * time.Millisecond)`
   - `context.WithCancel(context.Background())`
   - `context.WithTimeout(context.Background(), time.Millisecond)`
1. 限流
   - 简单的多协程的时间频率limiter：常见于限制自己的程序
    ```go
    ratelimiter := time.Tick(100 * time.Millisecond)

    // 调用处
    <-ratelimiter
    ```
   - 简单的多协程的并存数limiter：常见于限制外部
    ```go
    type ConnLimiter struct {
        concurrentConn int
        bucket         chan int
    }

    func NewConnLimiter(cc int) *ConnLimiter {
        return &ConnLimiter{
            concurrentConn: cc,
            bucket:         make(chan int, cc),
        }
    }

    func (cl *ConnLimiter) GetConn() bool {
        if len(cl.bucket) >= cl.concurrentConn {
            log.Printf("Reached the rate limitation.")
            return false
        }

        cl.bucket <- 1
        return true
    }

    func (cl *ConnLimiter) ReleaseConn() {
        C := <-cl.bucket
        log.Printf("New connction coming: %d", C)
    }

    // 使用
    用的时候先GetConn，然后defer ReleaseConn
    ```
1. select的简单调度
    ```go
    func createWorker(id int) chan<- int {
        c := make(chan int)
        go worker(id, c)
        return c
    }

    func main() {

        var c1, c2 = generator(), generator()
        var worker = createWorker(0)

        var values []int
        tm := time.After(10 * time.Second)
        tick := time.Tick(time.Second)

        for {
            var acticeWorker chan<- int
            var acticeValue int
            if len(values) > 0 {                                // 利用切片实现，生产者比消费者快的积压效果，不丢数据
                acticeWorker = worker                           // 由于chan类型的c是一个指针，返回了一个指针，这样go worker(id, c)这个协程就能跑起来
                acticeValue = values[0]
            }

            select {
            case n := <-c1:
                values = append(values, n)
            case n := <-c2:
                values = append(values, n)
            case acticeWorker <- acticeValue:                   // 利用var出来的为nil的channel，实现没有值时阻塞
                values = values[1:]
            case <-time.After(800 * time.Millisecond):          // 超时时间，和总时长原理相同
                fmt.Print("timeout")
            case <-tick:                                        // 定时报告channel的状态
                fmt.Print("queue len = ", len(values))
            case <-tm:                                          // 总运行时长，time.After控制
                fmt.Print("bye")
                return
            }
        }
    }
    ```
1. 动态数量的case处理：利用反射`reflect.Select`
    ```go
    func main() {
        var ch1 = make(chan int, 10)
        var ch2 = make(chan int, 10)

        // 创建SelectCase
        var cases = createCases(ch1, ch2)

        // 执行10次select
        for i := 0; i < 10; i++ {                                           // 不用在意这个for，因为select中本来就不是顺序循环
            chosen, recv, ok := reflect.Select(cases)                       // 从cases中选择一个case执行，相当于普通的select
            if recv.IsValid() { // recv case
                fmt.Println("recv:", cases[chosen].Dir, recv, ok)
            } else { // send case
                fmt.Println("send:", cases[chosen].Dir, ok)
            }
        }
    }

    func createCases(chs ...chan int) []reflect.SelectCase {                // 业务可以改造这个方法，创造自己要的case
        var cases []reflect.SelectCase


        // 创建recv case
        for _, ch := range chs {
            cases = append(cases, reflect.SelectCase{
                Dir:  reflect.SelectRecv,
                Chan: reflect.ValueOf(ch),
            })
        }

        // 创建send case
        for i, ch := range chs {
            v := reflect.ValueOf(i)
            cases = append(cases, reflect.SelectCase{
                Dir:  reflect.SelectSend,
                Chan: reflect.ValueOf(ch),
                Send: v,
            })
        }

        return cases
    }
    ```
1. select无任务退出
    ```go
    forloop:
    for {
        select {
        case d :=<- dc:
            log.Printf("Executor received: %v", d)
        default:
            break forloop                               // 只执行一次
            goto forloop                                // 会在for和forloop循环运行
        }
    }
    ```
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
### 标准库
1. 语法相关
   - reflect
   - errors
     1. `errors.New("xxxx")`
   - builtin：为go的预声明标识符提供文档
1. 基础类型和变量
   - bytes：实现操作[]byte的常用函数
   - sort：常见数据类型的排序操作
     1. sort.Ints()/sort.Float64s()
     1. sort.Strings()
     1. sort.Slice()/sort.SliceStable()/sort.SliceIsSorted()
     1. sort.Search()/sort.SearchStrings()：使用二分搜索来查找并返回[0, n)中f(i)为真的最小索引i
   - expvar：提供公共变量的标准接口
1. 文本相关
   - text
   - strings：操作字符
   - strconv：基本数据类型和其字符串表示的相互转换
     1. `strconv.Quote("xx")`：可以输出双引号
   - index
     1. suffixarray：suffixarrayb包通过使用内存中的后缀树实现了对数级时间消耗的子字符串搜索
   - regexp：正则
     1. syntax

   - encoding：编码
     1. json
     1. xml
     1. base64
     1. base32
     1. csv：csv读写逗号分隔值（csv）的文件.
     1. hex：hex包实现了16进制字符表示的编解码.
     1. binary：实现数字与字节序列的转换、变长值的编解码

     1. ascii85：ascii85数据编码
     1. asn1：DER编码的ASN.1数据结构
     1. gob：gob流——在编码器（发送器）和解码器（接受器）之间交换的binary值.
     1. pem：PEM数据编码
   - unicode：提供测试Unicode码点属性的数据和函数
     1. utf16
     1. utf8
   - html：转义和解转义HTML文本的函数
     1. template：实现数据驱动模板，用于生成可对抗代码注入的安全html输出
     1. charset
        - charset.DetermineEncoding()
   - mime：实现了MIME的部分规定
     1. multipart：实现MIME的multipart解析
     1. quotedprintable
1. 编码相关
   - compress：解压缩
     1. zlib
     1. gzip
     1. bzip2
     1. flate：deflate压缩数据格式
     1. lzw：Lempel-Ziv-Welch数据压缩格式
   - crypto：加解密
     1. rand：实现用于加解密的更安全的随机数生成器

     1. md5
     1. sha1
     1. sha256：实现SHA224和SHA256哈希算法
     1. sha512：实现SHA384和SHA512哈希算法

     1. des：实现DES标准和TDEA算法
     1. aes

     1. rsa：RSA加密算法
     1. dsa：DSA算法
     1. ecdsa：实现椭圆曲线数字签名算法

     1. hmac
     1. tls

     1. cipher：实现多个标准的用于包装底层块加密算法的加密算法实现
     1. elliptic：实现几条覆盖素数有限域的标准椭圆曲线
     1. rc4：RC4加密算法
     1. subtle
     1. x509：x509包解析X.509编码的证书和密钥.
     1. pkix：pkix包提供了共享的、低层次的结构体，用于ASN.1解析和X.509证书、CRL、OCSP的序列化.
   - hash：哈希函数
     1. adler32
     1. crc32
     1. crc64
     1. fnv：实现了FNV-1和FNV-1a（非加密hash函数）
1. io相关
   - io：提供i/o原语的基础接口
     1. `io.Reader`：作为流存在，不支持多次读取
     1. `io.TeeReader`：支持多次读取
   - bufio：带缓存增强版，比io写的快多了，一口气flush到硬盘
     1. 可读取一行
     1. 会缓存下来，遇到flush才输出`bufio.NewWriter.Flush()`
   - io/ioutil：实现一些io实用功能，v1.16后逐步放到了io、os中
   - path：路径
     1. filepath：兼容各操作系统文件路径的实用操作函数
   - archive：文件解压缩
     1. `archive.tar`
     1. `archive.zip`
1. 系统相关
   - os
     1. 子包
        - exec：执行外部命令
          1. exec.Command()
          1. exec.ExitError
        - signal：对输入信号的访问
        - user：查询用户帐户
     1. 目录：Mkdir/MkdirAll/Remove/RemoveAll：`os.Mkdir("a", 0777)`
     1. 文件
        - Create/NewFile
        - Open/OpenFile
          1. seek()：设置文件相对于当前/首/尾的偏移量
        - Read/ReadAt
        - Write/WriteString
        - Remove
     1. Reader接口：`func (T) Read(b []byte) (n int, err error)`，数据填充指定字节的slice，数据流结尾返回io.EOF错误
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
   - syscall
   - log
     1. 认识：写入stderr并打印每条记录消息的日期和时间，每条都在单独的行上输出
        - fmt属于stdout输出
     1. 方法
        - Print()：输出日志
        - Fatal()：输出日志同时调用os.Exit(1)退出，小提示：如果函数下存在defer不会执行
        - Panic()：输出日志同时调用panic，defer会执行
        - New()：可指定写入日志的目的地、前缀、属性
     1. 函数
        - log.SetFlags()：定义日志输出格式
        ```go
        // 系统常量
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
        log.SetFlags(log.Ldate | log.Ltime | log.LUTC | log.Lshortfile)
        ```
        - log.SetPrefix()：设置前缀
        - log.SetOutput()：设置输出方式
            ```go
            // 设置文件的输出方式
            logFileLocation, _ := os.OpenFile("/Users/q1mi/test.log", os.O_CREATE|os.O_APPEND|os.O_RDWR, 0744)
            log.SetOutput(logFileLocation)
            ```
        - log.New()：返回新的Logger类型，并定义一些特性
     1. 子包
        - syslog：使用域套接字、udp、tcp时可向syslog守护进程发送日志，可以Dial远端也可以本地，不再更新，有替代产品
   - flag：用于命令行的标签解析
1. 语言相关
   - runtime
     1. 子包
        - cgo：含有cgo工具生成的代码的运行时支持
        - debug：debug包含有程序在运行时调试其自身的功能
        - pprof：按照可视化工具pprof所要求的格式写出运行时分析数据
        - race：实现数据竞争检测逻辑
        - trace：Go execution tracer
     1. 组成
        - `runtime.GOMAXPROCS`：使用最大核心数
        - `runtime.NumCPU`：cpu核心数
        - `runtime.Gosched()`：使goroutine让出调度
        - `runtime.Goexit()`：使goroutine立即终止
        - NumGoroutine
   - container：数据结构
     1. heap：任意类型的堆操作
     1. list：双向链表
     1. ring：环形链表
   - unsafe
     1. 认识：不安全的直接操作内存，避免使用，只有两个类型，三个函数
        - 内存对齐：每种类型占用内存不同，结构体8byte对齐，占不满8byte的不连续的独占，连续的n个类型共同8byte
     1. 组成
        - 类型
          1. `type ArbitraryType int`：int别名，代表一个任意go表达式类型
          1. `type Pointer *ArbitraryType`：int指针类型别名，可理解成任何指针的父类型
        - 函数
          1. `unsafe.Sizeof()`：接受任意类型的值或表达式，返回其占用的字节数
          1. `func Offsetof(x ArbitraryType) uintptr`：返回结构体中元素所在内存的偏移量
          1. `func Alignof(x ArbitraryType) uintptr`：返回变量对齐字节数量，对齐因子
     1. 用法
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
     1. 最佳实践
        - 类型转换必须是可相互转的类型，否则panic
        - uintptr指针失效
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
   - internal：内部包，不在internal根目录的不让引用
     1. cpu
     1. poll
     1. syscall
     1. race
1. 工具链
   - go：语法包
   - plugin：组件包，实现了go插件的加载和符号解析
   - debug：调试包
     1. dwarf
     1. elf
     1. gosym
     1. macho
     1. pe
     1. plan9obj
   - testing：go包的自动测试支持
     1. iotest
     1. quick
     1. B
        - 方法
          1. RunParallel
1. 应用级
   - fmt
     1. 认识：类似c的printf和scanf的格式化I/O
        - 格式化动作('verb')源自c但更简单
        - scann扫描格式化文本以生成值
     1. 方法分类
        - print：输出到标准输出流，支持多个参数输出
          1. 后边加f：根据format参数，默认采用默认格式，`fmt.Printf("%3d", val)表示3位对齐`
          1. 前边加F：写入给定源，默认写入标准输出
          1. 后边加Ln：总是用空格分隔，并且加换行符
          1. 前边加S：返回该字符串
             - scann
             - Errorf
     1. 格式化参数
        - %t   布尔
        - %d   十进制表示
        - %g   根据情况选择 %e 或 %f 以产生更紧凑的（无末尾的0）输出 
        - %s   字符串或切片的无解译字节

        - %+v  添加字段名(如结构体)
        - %#v　相应值的Go语法表示
        - %p   十六进制表示，前缀 0x (用于指针和chan)
   - time
     1. 类型
        - Time：时间
        - Location：时区
        - Duration：int64纳秒计数的单调时钟
          1. ParseDuration()：解析持续时间字符串，`time.ParseDuration("1h10m10s")`
          1. Since()：缩写，`time.Now().Sub(t)`
          1. Until()：缩写，`t.Sub(time.Now())`
          1. Nanoseconds()：返回纳秒数 
        - Timer：用来代表一个单独的事件，当设置的时间过期后，发送当前的时间到channel
     1. 方法
        - `time.Tick(d)`：每隔一段时间送一个值过来
        - `time.After(d)`：倒计时，结束后往channel里送一个时间，可利用阻塞实现定时，for里边的select每次循环都重新开启
        - `time.Sleep(time.Second * 5)`
     1. 应用
        - 时间
          1. 获取时间(time类型的格式)：`time.Now()`
        - 字符串和时间
          1. 获取格式化时间，并转为字符串：`time.Now().Format("2006-01-02 15:04:05")`
          1. 字符串转时间
            ```go
            timeStr := "2015-01-01 00:00:00"
            loc, _ := time.LoadLocation("Local")
            timeObj, _ := time.ParseInLocation("2006-01-02 15:04:05", timeStr, loc)
            ```  
        - 时间戳和时间
          1. 获取时间戳/时间转时间戳：`time.Now().Unix()`
          1. 时间戳转时间，并且格式化：`time.Unix(sr, 0).Format("2006-01-02 15:04:05")`
   - math
     1. 子包
        - big：大数的高精度运算
        - cmplx：为复数提供基本常量和数学函数
        - rand：伪随机数生成器
          1. `rand.Intn(10)`："math/rand"
     1. 组成
        - `math.Nextafter(2, 3)`
   - image
     1. 子包
        - color：基本的颜色库
          1. palette：标准的调色板
        - draw：提供组装图片的方法
        - gif
        - jpeg
        - png
     1. 实例
        ```go
        m := image.NewRGBA(image.Rect(0, 0, 100, 100))
        m.Bounds()
        m.At(0, 0).RGBA()
        ```
   - database/sql：数据库驱动的标准接口
#### net
1. net
   - 类型
     1. Conn：使用goroutines保证请求独立、非阻塞
        - 连接控制
          1. 方法
             - DialTimeout
             - SetDeadline/SetReadDeadline/SetWriteDeadline：超时失败，只是一个超时抛异常机制，不会断开连接。可以重新调用SetDeadline，实现不断的刷新状态，否则状态不变
          1. 最佳实践
             - 所有timeout操作都是通过设置Deadline实现的
             - 明确设置ReadTimeout和WriteTimeout，并使用相应的方法来使server更完善
             - Contexts一个优点是树形的一个取消，关闭所有子context
     1. ServeMux：多路复用器，用作请求的路由分发
     1. ip
        - `addr := net.ParseIP()`
   - 子包
     1. http
     1. url
     1. rpc
        - 认识：支持三个级别：TCP、HTTP、JSONRPC，使用Gob编码的只能go内部
          1. SOAP RPC：不支持
        - 访问条件：`func (t *T) MethodName(argType T1, replyType *T2) error`，T/T1/T2必须能被encoding/gob包编解码
          1. 函数必须是导出的
          1. 必须有两个导出类型的参数，第一个参数是接收的参数，第二个参数是返回给客户端的参数，第二个参数必须是指针类型的
          1. 函数要有一个返回值error
        - tcp协议
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
        - json rpc：使用json编码，不是gob，支持跨语言调用
            ```go
            // client
            client, err := jsonrpc.Dial("tcp", service)
            // synchronous call
            args := Args{17, 8}
            var reply int
            err = client.Call("Xxx.Multiply", args, &reply)

            // server
            xxx := new(Xxx)
            rpc.Register(xxx)
            tcpAddr := net.ResolveTCPAddr("tcp", ":1234")
            listener := net.ListenTCP("tcp", tcpAddr)
            for {
                conn, _ := listener.Accept()
                go jsonrpc.ServeConn(conn)                      // 要异步，只能接收一个就阻塞了
            }
            ```
        - http协议
            ```go
            // client
            client := rpc.DialHTTP("tcp", "127.0.0.1:1234")
            // synchronous call
            var reply int
            err = client.Call("Xxx.func", args, &reply)

            // server
            type Xxx int
            xxx := new(Xxx)
            rpc.Register(xxx)
            rpc.HandleHTTP()                                    // 注册到HTTP协议上
            err := http.ListenAndServe(":1234", nil)
            ```
     1. mail：解析邮件消息
     1. smtp：简单邮件传输协议
     1. textproto：实现对基于文本的请求/回复协议的一般性支持
1. http
   - 认识：提供http客户端和服务端的实现
   - 特点
     1. serve方法中对panic作了保护，防止服务停止
   - 类型
     1. http.Client
        - 实现连接池的代码在Transport类型中，使用idleConn保存持久化的可重用的长连接
     1. http.Handler
     1. http.Request
     1. http.Response
   - 子包
     1. cookiejar：实现保管在内存中的符合RFC 6265标准的httpCookieJar接口
     1. httputil：提供http公用函数，是http的函数补充
        - ReverseProxy()：设置反向代理
        - DumpResponse()：打印响应体
     1. cgi：实现RFC3875协议描述的CGI（公共网关接口）
     1. fcgi：实现FastCGI协议
     1. httptest：http测试的单元工具
     1. pprof：返回runtime的统计数据，返回pprof可视化工具规定的格式
     1. httptrace
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
   - reg
     1. 认识：regexp包，实现RE2标准，实现搜索、替换、解析，strings包优先
        - 正则预编译，可以加快速度：`regexp.MustCompile()`
     1. 实例
        ```go
        regexp.Compile("\\<script[\\S\\s]+?\\</script\\>")                          // 判断是否能解析，并返回用于匹配的对象
        regexp.MustCompile("\\<script[\\S\\s]+?\\</script\\>")                      // 不能解析就panic
        regexp.MatchString("^[0-9]+$", os.Args[1])：是否包含，用于快速判断
        ```
   - xml：encoding/xml包，读取Unmarshal，生成Marshal/MarshalIndent
   - json：encoding/json包
     1. 认识
        - 共性
          1. 只有可导出成员(首字母大写)才可和json互转，加了tag也不行
          1. 当变量实现了Marshaler或者Unmarshaler，会调用其MarshalJSON或者UnmarshalJSON方法来生成json编码
        - 编码时
          1. 添加的tag作用
             - 为_的不输出
             - "xx,string"的转换类型
             - "xx,omitempty"的该字段值为0值或者空值时不会输出到json中
          1. 指针变量编码时自动转换为所指向的值
        - 解码
          1. 从json中确认字段的查找顺序：tag注明的->首字母大写其他小写的字段名->首字母之外其他大小写随意的导出字段(如NAME/NAmE)
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
            conn.SetReadDeadline(time.Now().Add(2 * time.Minute))
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
   - webSocket：go.net子包有，`golang.org/x/net/websocket`
1. gRPC
   - 认识：基于http2.0的基于protoBuf的cs型的高性能、开源的rpc框架，比webSocket高效，google主导开发，包 `google.golang.org/grpc`
     1. 支持多语音，默认采用protocol buffers数据序列化协议
     1. 可实现多路复用，就是并发的请求和接收
   - 模式
     1. 简单模式：单调的顺序请求、响应
     1. 双向数据流模式：请求、响应并行起来
   - 实例
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
   - go test使用
     1. 写法
        - 必须import一个testing，以_test.go结束
        - 每个test case必须以Test开头，否则不执行
        - test case的入参为t *testing.T或者b *testing.B
     1. 实践
        - 使用t.Run()来执行子test，用于控制测试的依赖
        - 使用testMain作为入口，做一些初始化的工作
     1. 实例
        ```go
        func TestDemo(t *testing.T) {
            t.SkipNow()                            // 跳过写到第一行才管用
            t.Errorf("aaaaaa")                  // 触发会跳过当前case
        }

        func TestMain(m *testing.M) {
            m.Run()                                 // 有了TestMain没有Run其他test不执行，包括benchmark
        }
        ```
   - benchmark使用
     1. 认识
        - 函数一般以Benchmark开头
        - case一般会跑N次，case无法达到一个稳态时无法完成测试
     1. 使用
        ```go
        // 调用：go test -bench=.
        func BenchmarkAll(b *testing.B) {               // 会自动跑到稳态时，才停止
            for n:=0; n <b.N; n++ {
            }
        }
        ```
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
   - 测试框架
     1. GoConvey
     1. GoStub
     1. GoMock
     1. Monkey
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
   - go-torch：开源工具，将profile信息转换成火焰图
   - 逃逸分析：`go build -gcflags "-m -l" *.go`
   - 汇编代码：`go run -gcflags -S main.go`
1. GUI
   - govcl
     1. 认识：跨平台的开源的gui库，核心绑定于liblcl
        - 原生的，不是基于html的，更别说DirectUI
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
     1. `go vet`：代码格式错误检查
     1. `go bug`：调试
     1. `go tool`
        - `go tool compile -N -l -S main.go`：不优化编译，可用dlv调试
        - `go tool pprof`：性能分析工具
        - `go tool cover`：覆盖率分析工具
        - `go tool cgo`
   - 运行和编译
     1. `go run hello.go`：进行高速编译，用作脚本语言
        - -race：race detector
     1. `go build`
        - 认识：用于测试编译
          1. 会同时编译依赖包，会在GOROOT/src和GOPATH/src搜索包，默认编译当前目录下的所有go文件，可指定要编译的文件名，会忽略_或.开头的go文件，会根据当前系统选择性地编译以系统名结尾的文件(_linux|darwin|windows|freebsd.go)
          1. 普通包不产生任何文件只做检查性编译，main包生成可执行文件
        - 条件编译
          1. 认识：`// +build condition`，构建约束，和编译条件`-tags`相同字符的才编译在包中
             - 约束可以出现在任何文件中
             - +build必须出现在package之前，之后应要有一个空行
             -  *_GOOS、*_GOARCH、*_GOOS_GOARCH结尾的隐式包含构建约束
          1. 语法
             - 只允许是字母数字或_
             - 多个条件之间，空格表示OR；逗号表示AND；叹号(!)表示NOT
             - 一个文件可以有多个+build，关系是AND
          1. 应用
             - `// +build ignore`：用于不想编译某文件
        - 参数
          1. -v：打印包名
          1. -o：指定输出的可执行文件
          1. -ldflags "-s -w"
             - -s：去掉符号信息，panic时候的stack trace就没有任何文件名/行号信息了，等价于c/c++的strip
             - -w：去掉DWARF调试信息，不能用gdb调试了
          1. -gcflags "-N -l"：关闭内联优化
          1. 跨平台
             - GOOS=linux
             - GOARCH=amd64 
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
     1. `go list`：查看安装的package
        - -f '{<!-- -->{.GoFiles}}'：查看将被编译的文件名
   - 工具
     1. golint：代码规范的错误
     1. gofmt：格式化
     1. govet：代码格式错误检查
     1. gometalinter：代码静态分析并规范化其输出的linter工具集
     1. godegragh：
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
     1. 配置goimport、gofmt，在Tools > File Watcher
     1. 运行
        - go工具实参：`-gcflags="all=-N -l"`
        - 程序实参：`-conf=$ProjectFileDir$/configs/dev`
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
1. Goscript：通过 WASM 实现，Go语言规范的非官方实现，用于Rust项目的内嵌或封装。像 Lua 之于 Redis/WoW，或者 Python 之于 NumPy
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
   - go都是值传递
   - go没有引用类型，只有指针
   - slice类型是不可比较的
   - go没有提供session的支持
     1. session设计要点
        - 创建
        - 全局管理器
        - Session ID的全局唯一性
        - 存储（可以存储到内存、文件、数据库等）
        - 过期处理
   - go没有的元素：不要想着去模拟这些元素，要用新的思想去思考
     1. 类、继承、多态、重载：go有不同的世界观，面向对象也流行变继承为组合的思维。面向对象的元素太容易被滥用，go为组合提供了直接的支持
     1. try/catch/finally：常态化的err处理，高效不出错
        - 太多的错误被当作异常
        - 很多c++项目组禁用try/catch
        - 正确使用try/catch处理错误，导致代码混乱
        - try/catch在产品代码中并不能减少开发人员负担
     1. 泛型
        - 泛型作为模板类型，实际想实现duck typing，go支持了
        - 泛型来约束参数类型，本身复杂：类型通配符、covariance等问题。go支持强类型的slice、map、channel，这个解决了大部分约束参数类型的场景
     1. 操作符重载
     1. 构造函数/析构函数/RAII
        - 大型项目很少使用构造函数，多使用工厂函数
        - 析构函数和垃圾回收不匹配
        - RAII技巧性太强，隐藏了意图
          1. Resource Acquisition Is Initialization：资源获取就是初始化，是c++一种管理资源、避免泄漏的惯用法。构造时获取资源，对象生命期内控制对资源的访问，对象析构时释放资源
   - 开发工具链
     1. tool：build、install、fmt
     1. test、benchmark、builtin
   - 箴言
     1. 不要通过共享内存进行通信，通过通信共享内存
     1. 并发不是并行
     1. 管道用于协调；互斥量（锁）用于同步
     1. 接口越大，抽象就越弱
     1. 利用好零值
     1. 空接口 interface{} 没有任何类型约束
     1. Gofmt 的风格不是人们最喜欢的，但 gofmt 是每个人的最爱
     1. 允许一点点重复比引入一点点依赖更好
     1. 系统调用必须始终使用构建标记进行保护
     1. 必须始终使用构建标记保护 Cgo
     1. Cgo 不是 Go
     1. 使用标准库的 unsafe 包，不能保证能如期运行
     1. 清晰比聪明更好
     1. 反射永远不清晰
     1. 错误是值
     1. 不要只检查错误，还要优雅地处理它们
     1. 设计架构，命名组件，（文档）记录细节
     1. 文档是供用户使用的
     1. 不要（在生产环境）使用 panic()
