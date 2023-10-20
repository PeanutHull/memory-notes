### rust
1. 认识：静态的强类型的系统编程语言，mozilla开发
   - 快速变化的是技术的表现形式，而不是技术本身
   - 学习上和c++一样难，但是比其安全；平时运维使用上和go一样是中等
   - Rust for Linux项目是Linux内核至今为止除C以外的语言
   - 字节用了rust，cpu降一半，内存降了75%，平均响应时间提升了3倍，P99降低了10倍
   - webAssembly最佳的语言就是rust
1. 特点：速度快、内存安全、线程安全、泛型支持(比c++好)、模式匹配、类型推断。编译器会检查，不通过
   - 性能：纯计算4倍go性能。因为代码限制更严格所以编译器可更加激进的优化，所以性能部分时候可c和c++
   - 安全：在非unsafe代码中不可能出现内存安全的问题，所以出现coredump直接看很少的unsafe代码就好
   - 协作：是一门真正工程实践出来的语言，可以完全信任别人的代码，c和c++完全做不到
1. go的缺点
   - 深度优化困难，用c和汇编比go快
   - 抽象能力较弱，没有零成本抽象，抽象时成本高
1. 实例：main.rs
    ```rust
    fn main() {
        printLn!("Hello world");
    }
    ```
### 语法
1. 特性
   - xx!：表示这是宏
1. 数据类型
   - 布尔：true，false
   - 整数
     1. 无符号：u8，u16，u32，u64，usize（和平台相关，32位系统就是32位的）
     1. 有符号：i8，i16，i32，i64，isize
   - 浮点数
     1. f32，f64(定义变量不指定类型默认)
1. 字符：''，是unicode码，总是4byte，单引号表示，可以放入emoji(因为都是unicode)
1. 数组
   - 认识：[]，相同类型元素的固定大小
   - 实例
    ```rust
    let xx: [i32, n] = [];
    let xx = [1,2,3];           // 类型推断

    // 访问
    array[n]
    ```
1. 变量
   - 定义
    ```rust
    let x = 1;
    let mut x = 1;      // 变量可变
    ```
   - 分类
     1. 不可变：默认，用于多线程编码，为什么鼓励使用？因为不必跟踪值的更改方式和位置，代码可以更加容易被理解。更极致的是编译器，ssa静态当数值，变量不可以改，而且用完即丢
     1. 可变
1. 常量
   - 认识：只能设置为常量表达式，不能是函数返回值等，即只能编译器计算，不能运行期计算
    ```rust
    const X: i32 = 42;          // 推荐大写
    ```
1. 流程控制
   - if
    ```rust
    if true {         // 允许没有括号，只能是bool值
        a             // 可以忽略return
    }else {
        
    }
    ```
   - loop/while、for(用来遍历集合)
    ```rust
    loop {              // 停不住

    }
    while false {       // 有条件

    }
    
    let a = [1,2,3];
    for element in a.iter() {

    }
    ```
1. 结构体
   - 认识
     1. 结构体是数据的集合；对象是数据 + 算法的集合
     1. 结构体只是打包了数据，对象还定义了使用数据的规则，这是不同的编程思想
   - 实例
    ```rust
    struct Xxx {
        xx1: String,
        xx2: u32,
    }

    // 创建结构体的实例
    let mut xx = Xxx {                  // 想要变加上mut
        xx1: String::from("xxx"),
        xx2: 1,
    }

    // 访问
    xx.xx1
    // 赋值
    xx.xx2 = 2;
    ```
   - 对象：impl，使用对象像使用结构体一样，语法糖
    ```rust
    impl Xxx {              // Xxx是结构体名，为结构体加方法
        fn xx(self) {
            self.xx;
        }
    }

    // 使用
    xx.xx();
    ```
1. 函数
   - 实例
    ```rust
    fn xx(xx: int) -> (u32, u32) {          // 多个返回值
        (1, 2);
    }
    ```
1. 泛型
   - 认识：就是类型不确定，类型也是运行时的一个参数，需要为类型参数取名字，T是type的首字母
   - 类型
     1. Option<T>：代表有无，别的语言用null、void表示
        - Some(T)
        - None
     1. Result<T,E>：代表成功失败，别的语言用try、expression
        - Ok(T)
        - Err(E)
   - 能做什么？比如同一个处理流程，但是需要返回不同的数据类型，难道每个数据类型都写一遍方法？用泛型
    ```rust
    fn xx<T: std::cmp::PartialOrd>(a: T) -> T {
        T
    }

    // 使用
    xx(1);
    xx(1.1);

    // 完整形式
    xx::<T: u32>(1);
    xx::<T: f32>(1.1);
    ```
   - 实例
    ```rust
    fn main() {
        // 返回Option
        match std::env::home_dir() {
            Some(data) => println!("dir: {:?}", data);
            None => println!("none");
        }
        // 返回Result
        match std::env::var("xx") {
            Ok(data) => println!("ok {:?}", data);
            Err(err) => println!("err {}", err);
        }
    }
    ```
1. 所有权
   - 认识
     1. 机制
        - 编译期间计算变量的使用范围：变量不再使用时编译器自动插入free代码
        - rust中所有值都必须有且只有一个所有者、作用域：超出作用域就回收，作用域{}框起来的地方，有多个会让rust的内存回收失效
     1. 所有权转移
   - 内存管理机制
     1. c：malloc、free：手动管理，bug制造机
     1. GC：go、java：自动管理，程序性能下降，底层编写不可能，实时性和性能要求高
     1. 基于生命周期的半自动管理：rust
1. 引用、借用
   - 认识：类似传值、传引用
   - 引用：&，可变引用&mut
     1. 不会获取所有权
     1. 默认不可变
     1. 同时只能存在一个可变引用，主要防止多线程下的数据竞争
1. 工具
   - cargo new project
   - cargo build [--release]：release即发布包，没有调试信息，性能更好
   - cargo run
### 库
1. 基础库：日志、监控、链路追踪、mysql、redis、mq、动态配置
1. Axum：Web 框架
1. tokio
1. Volo：RPC 框架，支持了 GRPC 和 thrift
1. Monoio：异步的运行时，性能非常关键的业务以及基础设施，基础架构的服务去使用
   - 采用 Thread Per Core 模型，这样就可以解决 Tokio 的很多问题
### wiki
1. 历史
   - 08年：私人诞生
   - 15年：1.0，标志稳定性
   - 18年：1.31，标志生产力，引入Async await异步
   - 24年：扩展授权，更加好用，更加易用，更多落地
