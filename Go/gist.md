### 应用实践
1. 自己踩的坑
   - map需要先make
   - json需要先判断不为空再Unmarshal
   - 开协程go一定要要有recover
   - gorm的Take/First/Last方法要避免ErrRecordNotFound异常
   - mysql加表了要想着加索引
   - proto相关
     1. proto修改，上下游服务都需要重启
     1. proto跟顺序强相关，加字段要在下边加，不能在中间
   - 接口相关
     1. 常识
        - 接口都支持多个，单个的也使用多个的获取
        - 限制每次请求的条数
        - 限制每次查询返回的条数
1. 踩坑大问题
   - 调用外部服务(如昵称的敏感词检测服务)，在遇到外部服务报错时阻塞了自己的修改头像昵称的业务流程，造成了业务有损，以后三方服务要有兜底措施，不能造成自身业务损失
   - 长期执行的定时任务中判断执行错误时，写了return，会导致所有定时任务都停止。不能加，这跟im消息返回中加return把所有消息都终止是一样的
   - 仓储层要加空数据判断，不能直接扔给find，否则会查询所有数据。导致查询所有的用户并且放入了map中
   - 接口幂等性：不能依赖数据库，并发请求的话基本拦不住，用redis设置一个较短时间过期的key，如果依赖数据库的主键或唯一索引，还不是幂等，会更新n次数据库
   - 结构体json化时不加tag字段名是和结构体字段相同大小写的原样输出
   - 定时任务用mysql表user_switch的某个字段的值作为锁，干活前写为1。有个场景是改为1后，正干着活儿呢，上线了，然后旧pod没了，这些正在处理的定时任务数据就噶了停了，而且标志位不释放，后续相同类型的定时任务也无法执行
1. 踩坑小问题
   - 输出时间没有用format格式化，导致差个时区，所以go输出时间时要格式化：`biManage.Date.Format("2006-01-02")`
   - 输出浮点数没有保留一位小数，导致后边跟了十多位小数：`strconv.ParseFloat(fmt.Sprintf("%.1f", 1784/0.3), 64)`
   - controller层写日志没有明确的msg的title，记录的param也不全
   - 循环删除slice中元素，导致slice乱套，最佳实践
    ```go
    // 可以用新slice承接，但是太费内存，下边这种不费内存
    slice := []int{1, 2, 3, 4, 5}
    n := 0

    for _, x := range slice {
        if x%2 != 0 {               // 裁切数据的方式举例：保留奇数
            slice[n] = x
            n++
        }
    }

    slice = slice[:n]

    // 或者每次循环时动态计算slice的长度
    slice := []int{1, 2, 3, 4, 5}

    for i := 0; i < len(slice); {
        if slice[i]%2 == 0 { // 举例：删除偶数
            // 删除当前元素
            slice = append(slice[:i], slice[i+1:]...)
        } else {
            i++
        }
    }
    ```
#### 思路思想
1. 编写思路
   - 编程起势：首先通过划分结构体，定义不同的功能模块，然后分别实现，最终实现功能
     1. 封装模块
        - 在一个文件中定义一组接口interface
        - 定义结构体struct，可以在一个文件或文件夹中专门存放需要用到的struct
        - 定义new结构体struct的方法，用sync.Once实现单例返回，返回值为接口interface
        - 定义属于结构体struct、并且实现了接口interface的所有方法，完成~
     1. 定义对象：针对一类组合，要定义一个结构体作为包装这个对象的载体，而不是孤零零的散着各种数据，面向对象嘛
   - 函数式编程：通过参数、返回值、变量都是函数的形式，实现更加灵活的处理
     1. 将具体执行的逻辑包装成一个方法，大家执行这个方法，内部自己定义，就可以将实现解耦了，大家不用关心执行的内容了
     1. 针对需要外部定义处理的函数，用函数式编程，实现外部定义实现，内部调度，执行那个方法就可以了
        ```go
        type Han struct {
            UseMethod func(int) bool
        }

        func main() {
            h := Han{
                UseMethod: func(i int) bool {
                    return true
                },
            }
            // 使用
            h.UseMethod(1)
        }
        ```
   - 并行思想：之前用的读io然后处理的单线程模式，改为：起多个不同的协程(有的处理读io，有的处理逻辑)，协程之间通过chan传递数据，一边读取一边处理的协程模式了
     1. 耗时的goroutine可以多起几个
   - 如何设计一个特定领域的整体的处理框架，整体架构就是先划分不同角色，怎么划分好角色最重要，然后利用interface去高内聚每个角色，之间相互配合，实现更强的扩展性
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
   - json解析不存在的默认给类型零值，所以接口请求参数不要使用0作为特殊意义值
1. 性能优化
   - 当一个结构体很大、并且在函数中传递时，可以将结构体拆分成小的，将小的单独传递，将小的组合成原来的大的嘛，可以提升性能
   - 全局变量可以避免重复申请带来的内存交互
#### 高级编码
1. option编程
   - 认识：使用函数式编程的装饰器模式优化工厂模式
     1. 实现方式：把属性拆成一个个独立构造函数 + go可变参数特性
     1. 适用点：结构体属性在多次实例化时变化比较大，且所有属性和需要实例化的属性数量差异较大
   - 前提场景
    ```go
    // 一个构造结构体的工厂
    type Diss struct {
        Topic  string
        Person string
        Time   int
    }

    func traditionalNew(topic, person string, time int) Diss {
        return Diss{
            Topic:  topic,
            Person: person,
            Time:   time,
        }
    }
    ```
   - 假设我们不想传入时间参数怎么办？
    ```go
    type Option func(d *Diss)
    
    func optionNew(option ...Option) *Diss{             // 只需要传入option变量就可以构造结构体了，所以需要构造函数
        diss := &Diss{}
        for _, o := range option {
            o(diss)
        }
        return diss
    }

    // 具体构造函数
    func WithTopic(topic string) Option {
        return func(d *Diss) {
            d.Topic = topic
        }
    }
    func WithPerson(person string) Option {
        return func(d *Diss) {
            d.Person = person
        }
    }
    func WithTime(time int) Option {
        return func(d *Diss) {
            d.Time = time
        }
    }

    func main() {
        dissByOption := optionNew(WithTopic("something bad"), WithTime(2), WithPerson("funk"))
    }
    ```
### 练习
#### 语法练习
1. 数据类型
   - 引号输出
     1. 使用反引号：`a := `"xx"``
     1. 使用转义：`a := "\"xx\""`
     1. 使用strconv包：`a := strconv.Quote("xx")`
   - 类型转换
     1. 实例
        ```go
        var f float64 = float64(i)
        // 或者
        f := float64(i)

        // string转为int、int64
        aa := "111"
        // 这样是转成 int
        b, err := strconv.Atoi(aa)
        fmt.Printf("b: %d, err: %v   \n", b, err)

        // 这样是转成 int64
        c, err := strconv.ParseInt(aa, 10, 64)
        fmt.Printf("c: %d, err: %v   \n", c, err)
        ```
   - 类型检查
     1. 需要无数的`if v,ok=value.(xxType);!ok{}`
     1. 或者用`v.(xxType)`直到panic
     1. 或者封装snyc.Map并且对外提供指定类型的Load，Delete等方法实现类型限定
        - 如果改变类型，就需要重新创建一个结构体和方法，这也是go没有泛型所带来的烦恼之一
     1. 用反射帮助做类型检查
        ```go
        // 使用反射帮助做sync.Map的类型检查
        type ConcurrentMap struct {
            m         sync.Map
            keyType   reflect.Type
            valueType reflect.Type
        }

        func NewConcurrentMap(keyType, valueType reflect.Type) (*ConcurrentMap, error) {
            if keyType == nil {
                return nil, errors.New("nil key type")
            }
            if !keyType.Comparable() {
                return nil, fmt.Errorf("incomparable key type: %s", keyType)
            }
            if valueType == nil {
                return nil, errors.New("nil value type")
            }
            cMap := &ConcurrentMap{
                keyType:   keyType,
                valueType: valueType,
            }
            return cMap, nil
        }

        func (cMap *ConcurrentMap) Delete(key interface{}) {
            if reflect.TypeOf(key) != cMap.keyType {                                            // 检查是否和map本身的一致
                return
            }
            cMap.m.Delete(key)
        }
        ```
   - 判断接口类型 + 结构体切片用法
    ```go
    // 参数支持constant.ServerConfig或者[]constant.ServerConfig
    func (n *ConfigureCenterNacos) InitServer(opts interface{}) (interface{}, error) {
        switch v := opts.(type) {                                                           // v获取了opts的值和类型
        case constant.ServerConfig:
            n.serverConfig = []constant.ServerConfig{                                       // 结构体切片的赋值方式
                v,
            }
            return n.serverConfig, nil
        case []constant.ServerConfig:
            n.serverConfig = v
            return n.serverConfig, nil
        default:
            return nil, errors.New("config opts error")
        }
    }
    ```
   - 自定义类型
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
1. slice
   - slice底层和append的值传递特性
    ```go
    a := make([]int, 0, 5)
    a = append(a, 1)
    b := append(a, 2)
    c := append(a, 3)
    fmt.Printf("v=%v || p=%p\n", a, &a) // v=[1] || p=0xc00000c060
    fmt.Printf("v=%v || p=%p\n", b, &b) // v=[1 3] || p=0xc00000c080
    fmt.Printf("v=%v || p=%p\n", c, &c) // v=[1 3] || p=0xc00000c0a0

    type slice struct {
        array unsafe.Pointer
        len   int
        cap   int
    }
    // 原因：append对于参数a是值传递，因为slice底层指向点相同，所以第二次和第三次都是针对a进行追加，导致第二次被覆盖，同时因为是新值b和c的内存地址不同，b和c都是slice哦
    ```
   - 当作函数参数传递时修改slice
    ```go
    func fn(in []int) {
        in[0] = 100                 // 引用传递方式(因为slice底层数组是一个)
    }

    func fn(in []int) {
        in = append(in, 5)          // 值传递方式
    }
    ```
   - 在循环中修改数组的值
    ```go
	slice := []int{10, 20, 30, 40}
	for index, value := range slice {
		slice[index] = 66
		fmt.Printf("value = %d , value-addr = %x , slice-addr = %x\n", value, &value, &slice[index])
	}
	fmt.Print(slice)
    ```
   - 进阶练习
    ```go
    slice := []int{0, 1, 2, 3, 4, 5, 6, 7, 8, 9}
	s1 := slice[2:5]
	s2 := s1[2:6:7]

	s2 = append(s2, 100)
	s2 = append(s2, 200)

	s1[2] = 20

	fmt.Println(s1)
	fmt.Println(s2)
	fmt.Println(slice)
    ```
1. 变量
   - 迭代器变量
    ```go
    func main() {
        var out []*int
        for i := 0; i < 3; i++ {
            out = append(out, &i)
        }
        
        fmt.Println("值:", *out[0], *out[1], *out[2])
        fmt.Println("地址:", out[0], out[1], out[2])
    }

    // 期望
    // 值: 0 1 2
    // 地址: 0x01 0x02 0x03  // 不同的地址

    // 实际
    // 值: 3 3 3
    // 地址: 0xc0000a6010 0xc0000a6010 0xc0000a6010

    // 解决方案
    // j:=i ------ 使用新变量
    // 也可以将迭代部分使用匿名函数包起来，将迭代变量通过参数的方式传递过去。基本解决思路一致，都是生成一个新的数据副本，将其和迭代变量脱离关联
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
   - 基础
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
    // 可选参数传递
    func Del(key ...string) {
        err = vr.Del(key...)                            // 使用...传递可选参数
        return
    }
    ```
   - 可选参数实践
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
   - 函数式编程和循环
    ```go
    for _, m := range mySlice {
        correctM ：= m
        a := myStruct{
            name: "xx"
            myFunc: func() int {
                return m                // 这里只是返回了一个函数，这个函数的执行时机是整个for循环结束后，所以这么写m无法达到目的，应该使用另外定义的变量
            }
        }
    }
    ```
   - 闭包
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
1. 结构体
   - 方法的接收者是否使用指针类型取决于，即加不加*
     1. 方法能够修改接收者指向的值，即方法会不会改变结构体的内容，如`func (m Mystruct) myMethod() {}`
     1. 避免在每次调用方法时复制该值，在值的类型为大型结构体时，这样做会更加高效
   - 在结构体上定义方法
    ```go
    func (v *vertex) Add() float64 {
	    return v.X + v.Y
    }
    v := &vertex{3, 4}
    v.Abs()                 // 使用
    ```
   - 指针访问结构体
    ```go
    v := vertex{1, 2}
	p := &v
    p.X
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

        // demo
        v := reflect.ValueOf(v)
        v.Kind()                        // 获取其类型
        fmt.Println(v.String())         // 返回其值
        fmt.Println(v.Int())            // 返回其值
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
1. 上下文
   - context
     1. pipeLine的每个工人函数都使用switch处理case <-ctx.Done()。作为生产线上的命令控制
        ```go
        func lineParser(ctx context.Context, base int, in <-chan string) (<-chan int64, <-chan error, error) {
            ...
            go func() {
                defer close(out)
                defer close(errc)

                for line := range in {

                    n, err := strconv.ParseInt(line, base, 64)
                    if err != nil {
                        errc <- err
                        return
                    }

                    select {
                    case out <- n:
                    case <-ctx.Done():
                        return
                    }
                }
            }()
            return out, errc, nil
        }
        ```
     1. 超时控制
        ```go
        ctx, cancel := context.WithTimeout(context.Background(), 50*time.Millisecond)
        defer cancel()

        select {
        case <-time.After(1 * time.Second):
            fmt.Println("overslept")
        case <-ctx.Done():
            fmt.Println(ctx.Err()) // prints "context deadline exceeded"
        }
        ```
     1. 传递数据
        ```go
        var UserId = FooKey("user-id")

        ctx := context.Background()
        // 设置
        ctx = context.WithValue(ctx, UserId, "1")
        // 获取
        fmt.Println(ctx.Value(UserId))
        ```
1. io
   - io/ioutil：读取所有字符
    ```go
    resp, err := http.Get("http://example.com?user_id=121212")
	if err != nil {
	}
	body, err := ioutil.ReadAll(resp.Body)
	if err != nil {
	}
    ```
1. 代码简写
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
#### 应用实例
1. 数学相关
   - 生成随机数
    ```go
    rand.Seed(time.Now().Unix())        // 需要改变随机数种子，否则每次程序启动生成的随机数相同，因为种子默认为1
    rand.Int()
    ```
1. 打印
   - `fmt.Printf("s[%d] == %d\n", i, s[i])`
     1. %s：字符串
     1. %d：数字
     1. %v：slice
   - `fmt.Println(m)`
1. 时间相关
   - 计算时间差
    ```go
    s := time.Now()
    dur := time.Now().Sub(s)
    ```
   - 自定义时间格式
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
1. web
   - url编解码
     1. get参数
        ```go
        // url encode
        v := url.Values{}
        v.Add("a", "aa")
        v.Add("b", "bb")
        v.Add("c", "有没有人")
        body := v.Encode()
        fmt.Println(v)
        fmt.Println(body)
        // url decode
        m, _ := url.ParseQuery(body)
        fmt.Println(m)
        ```
     1. 内容
        ```go
        urltest := "http://www.baidu.com/s?wd=自由度"
        // 编码
        encodeurl:= url.QueryEscape(urltest)
        fmt.Println(encodeurl)
        // 解码
        decodeurl,err := url.QueryUnescape(encodeurl)
        if err != nil {
            fmt.Println(err)
        }
        fmt.Println(decodeurl)
        ```
   - web错误处理
     1. defer + panic + recover：多加一层panic，优化默认http的的报错展示
     1. Type Assertion：通过类型定义，区分用户展示和服务器展示
     1. 函数式编程：实现错误处理的代理，接收各种逻辑处理函数遇到的错误，形式为
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
1. 命令行执行
    ```go
    // 转换pdf为图片，依赖imageMagick
    cmd := exec.Command("convert",
        "-density", "108", // 200时间超长？
        "-units", "PixelsPerInch",
        "-resize", "1040x1471^>",
        "-background", "white",
        "-flatten",
        fmt.Sprintf("%s[%d]", i.OutPut.FilePath, j),
        filepath.Join(i.OutPut.ImageDir, "%d.jpeg"))
    
    // 获取执行结果
    result, err := cmd.CombinedOutput()

    // 错误判断
    code := 0
    if ee, ok := err.(*exec.ExitError); ok {
        code = ee.ProcessState.ExitCode()
    }
    ```
1. 插件
   - 一种优雅的Golang的库插件注册加载机制
     1. 说明：注册方面，巧妙使用隐式import来做插件的注册。而加载方面，巧妙使用有buffer的channel作为加载队列
     1. 实现
        - 框架定义插件的格式
            ```go
            type Plugin interface{
                Name() string
                Setup(config map[string]string) error
            }
            ```
        - 框架定义包含所有插件的全局变量
            ```go
            var plugins map[string]Plugin
            ```
        - 框架提供注册插件的方法
            ```go
            Register(plugin Plugin)
            ```
        - 框架加载插件
            ```go
            // 加载，直接引入即可实现
            _ import "github.com/foo/myplugin"

            // 配置，定义文件如config/plugins/myplugin.yaml

            // 依赖方案：将所有插件放在chan中，然后一个个调用Setup，遇到Depend其他插件的且依赖还未被加载，则将当前插件放在队列最后（重新塞入channel）
            // 最精妙的就是使用了一个有buffer的channel作为一个队列，消费队列一方SetupPlugins，除了消费队列，也有可能生产数据到队列，这样就保证了队列中所有plugin都是被按照标记的依赖被顺序加载的
            var setupStatus map[string]bool

            func loadPlugins() (plugin chan Plugin, setupStatus map[string]bool) {          // 获取所有注册插件
                // 这里定义一个长度为10的队列
                var sortPlugin = make(chan Plugin, 10)
                var setupStatus = make[string]bool
                
                // 所有的插件
                for name, plugin := range plugins {
                    sortPlugin <- plugin
                    setupStatus[name] = false
                }
                
                return sortPlugin, setupStatus
            }

            // 加载所有插件
            func SetupPlugins(pluginChan chan Plugin, setupStatus map[string]bool) error {
                num := len(pluginChan)
                for num > 0 {
                    plugin <- pluginChan
                    
                    canSetup := true
                    if deps, ok := p.(Depend); ok {
                        depends := deps.DependOn()
                        for _, dependName := range depends{
                            if _, setuped := setupStatus[dependName]; !setup {
                            // 有未加载的插件
                            canSetup = false
                            break
                            }
                        }
                    }
                
                    // 如果这个插件能被setup
                    if canSetup {
                        plugin.Setup(xxx)
                        setupStatus[p.Name()] = true
                    } else {
                        // 如果插件不能被setup, 这个plugin就塞入到最后一个队列
                        pluginChan <- plugin
                    }
                }
                return nil
            }
            ```
        - 插件的基本样子
            ```go
            package MyPlugin

            type MyPlugin struct{}

            func (m *MyPlugin) Setup(config map[string]string) error {}

            func (m *MyPlugin) Name() string {
                return "myPlugin"
            }

            func init() {
                plugin.Register(&MyPlugin)
            }
            ```
### 算法
1. 手动内存管理
   - 回收器：多goroutine通信共享channel，实现内存共享池。有获取、回收等操作，实现内存复用，减少累积的内存占用
    ```go
    var makes int
    var frees int
    
    func makeBuffer() []byte {
        makes += 1
        return make([]byte, rand.Intn(5000000)+5000000)
    }
    
    type queued struct {
        when time.Time
        slice []byte
    }
    
    func makeRecycler() (get, give chan []byte) {
        get = make(chan []byte)
        give = make(chan []byte)
    
        go func() {
            q := new(list.List)
            for {
                if q.Len() == 0 {
                    q.PushFront(queued{when: time.Now(), slice: makeBuffer()})
                }
    
                e := q.Front()
    
                timeout := time.NewTimer(time.Minute)
                select {
                case b := <-give:
                    timeout.Stop()
                    q.PushFront(queued{when: time.Now(), slice: b})
    
                case get <- e.Value.(queued).slice:
                    timeout.Stop()
                    q.Remove(e)
        
                case <-timeout.C:
                    e := q.Front()
                    for e != nil {
                        n := e.Next()
                        if time.Since(e.Value.(queued).when) > time.Minute {
                            q.Remove(e)
                            e.Value = nil
                        }
                        e = n
                    }
                }
            }
    
        }()
    
        return
    }
    
    func main() {
        pool := make([][]byte, 20)
    
        get, give := makeRecycler()
    
        var m runtime.MemStats
        for {
            b := <-get
            i := rand.Intn(len(pool))
            if pool[i] != nil {
                give <- pool[i]
            }
    
            pool[i] = b
    
            time.Sleep(time.Second)
    
            bytes := 0
            for i := 0; i < len(pool); i++ {
                if pool[i] != nil {
                    bytes += len(pool[i])
                }
            }
    
            runtime.ReadMemStats(&m)
            fmt.Printf("%d,%d,%d,%d,%d,%d,%d\n", m.HeapSys, bytes, m.HeapAlloc
                m.HeapIdle, m.HeapReleased, makes, frees)
        }
    }
    ```
1. Nagle算法
   - 认识：借用tcp协议里的概念，数据包会在以下两个情况被发送。理解即公交车装满走人，或者定时到点走人
     1. 缓冲区的数据包长度达到某个长度（MSS）时
     1. 或者等待超时（一般为200ms）。在超时之前，来的那么多个数据包，就是凑不齐MSS长度，现在超时了，不等了，立即发送
   - 特点
     1. 动态积攒一批处理，提高了吞吐量
   - 实现：定义一个带锁的全局队列（链表）
    ```go
    func CallAPI() error {
        size := 100
        batch := 20
        // 接收任务
        videoInfos := make([]IVideoInfo, 0, size)

        // 设置一个200ms定时器
        tick := time.NewTicker(200 * time.Microsecond)
        defer tick.Stop()

        // 死循环
        for {
            select {
            // 由于定时器，每200ms，都会执行到这一行
            case <-tick.C:
                if len(videoInfos) > 0 {
                    // 200ms超时，发车！去请求下游
                    limitStartFunc(videoInfos, true)
                    // 请求结束后把之前收集的数据清空，重新开始收集
                    // TODO 这里不行吧，上下两行会弄丢数据吧？另外如果limitStartFunc时间太长就排队了
                    videoInfos = make([]IVideoInfo, 0, size)
                }
            // AddChan就是所谓的全局队列
            case videoInfo, ok := <-AddChan:
                if !ok {
                    // 通道关闭时，处理剩余数据
                    limitStartFunc(videoInfos, false)
                    videoInfos = make([]IVideoInfo, 0, size)
                    return nil
                } else {
                    videoInfos = append(videoInfos, videoInfo)
                    // 攒够了一批，发车！
                    if len(videoInfos) > batch {
                        limitStartFunc(videoInfos, false)
                        videoInfos = make([]IVideoInfo, 0, size)
                        // 重置定时器
                        tick.Reset(200 * time.Microsecond)
                    }
                }
            }
        }
        return nil
    }
    ```
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
