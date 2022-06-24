### 数据结构
1. string
   - 认识：[]rune，字符数组实现
1. array
   - 认识
     1. 是一个在栈上分配的连续内存
     1. 编译期间的类型检查时会检测下标是否越界，因此使用起来比C语言的数组安全
   - 组成
     1. 编译期间
        ```go
        // src/go/types/type.go
        type Array struct {
            len  int64
            elem Type
        }
        ```
     1. 运行时：进行内存的分配
        ```go
        // runtime/malloc.go
        func newarray(typ *_type, n int) unsafe.Pointer {
            if n == 1 {
                return mallocgc(typ.size, typ, true)
            }
            mem, overflow := math.MulUintptr(typ.size, uintptr(n))
            if overflow || mem > maxAlloc || n < 0 {
                panic(plainError("runtime: allocation size out of range"))
            }
            //申请一块内存空间
            return mallocgc(mem, typ, true)
        }
        ```
1. slice
   - 认识：内部通过指针引用底层数组，设定相关属性将数据读写操作限定在指定的区域内。组成有
     1. 会判断越界
     1. 旧底层数组仍然会被旧slice引用，新slice和旧slice不再共享同一个底层数组
   - 组成
     1. 
        ```go
        // runtime/slice.go
        type slice struct {
            array unsafe.Pointer        // 指针，可指向数组的首地址、中间位置，数组可以被多个slice同时指向
            len   int                   // 长度
            cap   int                   // 容量，容量 >= 长度
        }
        ```
   - slice自动扩容的策略
     1. len小于1024，cap翻倍
     1. 大于1024每次四分之一翻倍，直至大于要求容量
     1. 每次扩容最后都要进行内存(向上)对齐，`roundupsize(size uintptr) uintptr`
   - 浅拷贝和深拷贝
     1. slice之间赋值是浅拷贝，包括子slice
     1. append是深拷贝
     1. copy是深拷贝
1. map
   - 认识
     1. 解决hash冲突：主要用两个数组分别存储键和值(数组是内存上的连续空间)，同时正常桶的bmap关联溢出桶的bmap实际构成了链表关系
     1. 写数据时并没有单独维护键值对的顺序，php5通过一个全局链表维护了map里元素的顺序
   - 组成
     1. 结构
        - hmap：包含多个bmap数组
          1. buckets：指向类型为[]bmap的数组，正常桶
          1. oldbuckets：扩容时，存放之前的buckets

          1. extra：溢出桶结构体
             - overflow：溢出桶。类型是[]bmap
             - oldoverflow：扩容时存放之前的overflow(Map扩容相关字段)
             - nextoverflow：指向溢出桶里下一个可以使用的bmap
          1. noverflow：溢出桶里bmap大致的数量
          1. nevacuate：分流次数，成倍扩容分流操作计数的字段(Map扩容相关字段)

          1. flags：状态标识，比如正在被写、buckets和oldbuckets在被遍历、等量扩容(Map扩容相关字段)
        - bmap：包含两个数组分别存放key和value
          1. topbits：长度为8的数组，[]uint8，元素为：key获取的hash的高8位，遍历时对比使用，提高性能
          1. keys：长度为8的数组，[]keytype，元素为：具体的key值
          1. elems：长度为8的数组，[]elemtype，元素为：键值对的key对应的值
          1. overflow：指向的hmap.extra.overflow溢出桶里的bmap
          1. pad：对齐内存使用的，不是每个bmap都有会这个字段，需要满足一定条件
     1. 特性
        - hmap
          1. 没有溢出桶或者溢出桶用完了，内存空间重新分配一个bmap
          1. 溢出桶可以继续关联溢出桶
        - bmap
          1. topbits、keys、elems长度为8，每个bmap结构最多存放8组键值对，
          1. bmap.overflow是个存放了对应使用的溢出桶hmap.extra.overflow里的bmap的地址的指针类型，某个bmap存满了就往指向的这个bmap里存
     1. 流程
        - 读
          1. 获取bmap数组的索引位置：key进行hash和位操作
          1. 通过高8位topbits加速查找
          1. 遍历bmap里的键，和目标key对比获取key的索引
          1. 根据key的索引通过计算偏移量，获取到对应value
          1. 查找溢出桶获取值，即如果当前“正常桶的bmap”中的overflow值不为nil(说明“正常桶的bmap”关联了“溢出桶的bmap”)，则遍历当前指向的“溢出桶的bmap”继续上边的bmap遍历
        - 遍历：因为遍历map的索引的起点是随机的
        - 写：为什么遍历索引起点是随机的，因为map本质上是“无序的”
          1. 正常写入：写入无法确认hash到具体哪个bucket上，不是按buckets顺序写入
          1. 哈希冲突写入：会写到同一个bucket上，但是bucket上的位置不确定，甚至也许写到溢出桶上
        - 扩容
          1. 成倍扩容：迫使元素顺序变化
             - 条件
               1. map写操作
               1. (元素数量/bucket数量) > 6.5
             - 过程
               1. 原buckets指向oldbuckets
               1. 初始化成倍新的buckets指向buckets
               1. 每次只扩容当前的键对应的bucket(bmap)
               1. 原bucket(bmap)被分流到两个新的bucket(bmap)中
          1. 等量扩容：4没有改变元素顺序
             - 目的：整理溢出桶，GC回收冗余的溢出桶
             - 条件：溢出桶的数量大于等于2*B时，函数 `tooManyOverflowBuckets`，公式 `noverflow >= uint16(1)<<(B&15)`
   - wiki
     1. 要点
        - map实现的了解
        - map如何读取数据
        - 溢出桶
        - 遍历是无序的
     1. 一般map
        - 结构
          1. 数组：数组里的值指向一个链表
          1. 链表：目的解决hash冲突的问题，并存放键值
        - 流程
          1. key通过hash函数得到key的hash
          1. key的hash通过取模或者位操作得到key在数组上的索引，位操作的性能好些
          1. 通过索引找到对应的链表
          1. 遍历链表对比key和目标key
          1. 相等则返回value
1. 结构体
   - 内存对齐
### 语法
1. defer
   - 数据结构：defer有栈地址
    ```go
    type _defer struct {
        sp      uintptr   // 函数栈指针
        pc      uintptr   // 程序计数器
        fn      *funcval  // 要执行的函数地址
        link    *_defer   // 指向自身结构的指针，用于链接多个defer
    }
    ```
   - 认识
     1. 有全局和p本地的defer池，新声明的defer复用拿到的defer对象
        - defer池：减少反复资源申请、GC，预备了不同大小的defer池，反复使用，并且申请了也不会释放
        - 会切换到系统栈再去拿，从全局拿到p本地，只有系统栈才会处理扩栈
     1. 内存结构上，defer函数的参数不在_defer结构体中，而是紧跟着
     1. deferreturn通过递归来回切换需要执行的defer函数和主流程函数
        - 两种递归结束方式
          1. d为nil，链表为空，说明没执行的了
          1. d.sp != sp，如果_defer对象的sp和调用deferreturn的sp不一样，说明不是本层函数要执行的defer，这是为什么不同层函数defer不会执行的原因
        - 每次递归都不会增加栈空间，为啥，来回倒腾bp、sp
   - 流程
     1. 编译期
        - defer翻译成对deferproc函数的调用：将 defer 关键字转换成 runtime.deferproc
        - 并在调用 defer 关键字的函数返回之前插入 runtime.deferreturn
     1. 运行时
        - 调用 runtime.deferproc 会将一个新的 runtime._defer 结构体追加到当前 Goroutine 的链表头
        - 对_defer对象进行赋值
        - 返回到调用 deferproc 的函数继续执行后面的代码
        - 调用 runtime.deferreturn 会从 Goroutine 的链表中取出 runtime._defer 结构并依次执行
1. panic
   - 遍历当前 goroutine 所注册的 defered 函数并通过 reflectcall 调用遍历到的函数，如果某个 defered 函数调用了recover（对应到runtime的gorecover函数）则使用 mcall(recovery)  恢复程序的正常流程，否则执行完所有的 defered 函数之后打印出 panic 的栈信息然后退出程序
### 协程
1. goroutine
   - 特点、设计目标
     1. 需要协程时方便使用
     1. 高效的调度执行
     1. 公平的调度策略
     1. 无大小限制的goroutine栈
   - 认识
     1. goroutine stack大小默认设置2k，可轻易创建几十万goroutine不用担心内存耗尽等问题
     1. 遇到阻塞就换出
     1. M结束系统调用会被放进闲置M链表
     1. 由于当前栈可能还有很多其他操作，栈会继续增长，切换的时候会切到systemstack
     1. 公平性和抢占
        - 认识
          1. 长时间霸占cpu的必然引起不公平，需要进行抢占
          1. go对于轮询更加合适：有runtime、golang编译器控制代码、正好有检测是否扩栈的指令
          1. 有个理论缺陷：若有一个死循环，里面的所有代码都不包含check指令，依然会无法抢占，基本不存在情况
          1. 系统调用问题：线程一旦进入系统调用会脱离runtime的控制无法抢占，是否会一直阻塞？解决方案是不抢占，由其主动让出
             - 线程A在系统调用之前handoff让出Processor的执行权，唤醒一个空闲线程B做交接。当线程A从系统调用返回时，不会继续执行，而是将G放到run queue，然后进入idle状态等待唤醒，这样一来便能确保活跃线程数依然与Processor数量相同
        - 抢占常见方式
          1. 中断：通过信号，系统依赖
          1. 轮询：效率低一些
     1. G的栈采用的是Growable stack方案，在函数入口会有栈检查的指令，如需扩容栈，会拷贝到新申请的更大的栈
     1. Go runtime还会用Background thread来运行一些相对特别的G（如 Network Poller、Timer）
   - scheduler
     1. 认识：调度器，基于M:N的G-P-M线程调度模型，![avatar](../images/goroutine_base_schedule.png)
        - 协程调度：模仿linux的进程调度，在其之上自己实现一套。m是machine相当于cpu，g相当于进程，g在m上运行，p按照规则自己给自己做调度，调度室代码+数据
     1. GMP
        - g：goroutine，执行的go代码片段/用户态协程
        - m：machine，内核线程
          1. 和一个P互相绑定
          1. 负责执行G的调度，通过调度当前M绑定的P的G队列、以及全局G队列，达到G可被并发执行的目的
          1. 负责执行P调度过来的当前G
        - p：processor，对处理器的抽象，通常和逻辑cpu数量相同
          1. 和一个M互相绑定
          1. 维护了一个可执行G的队列，分自己/全局
     1. 组成
        - g0是特殊的协程，负责创建
        - sysmon：用于监控的线程，改变goroutine的抢占标志位，goroutine下一次调用时runtime可以将其抢占
          1. 释放闲置超过5分钟的span物理内存
          1. 如果超过2分钟没有垃圾回收，强制执行
          1. 将长时间未处理的netpoll结果添加到任务队列
          1. 向长时间运行的G任务发出抢占调度
          1. 收回因syscall长时间阻塞的P
   - 调度算法：优先级、时间片相关，
     1. 创建新协程
     1. io、select
     1. timer：定时器
     1. channel
     1. netPoll：网络轮询器
     1. syscall：函数调用(有时)
     1. 等待锁：G和M锁定
     1. runtime.Gosched()
     1. 抢占
   - 特性
     1. 逃逸分析
   - 思想
     1. 资源池、资源池分离：对有一定规模约束的资源进行池化管理，如内存池、机器池、协程池、线程池等
     1. 计算存储分离，分别从逻辑、数据结构两个角度进行设计，规划二者的耦合关系
#### channel
1. 数据类型：runtime.hchan
1. 方法
   - makechan：目标生成hchan对象，makechan64只做了size检查，底层都是makechan
   - chansend：chansend1调用chansend
   - chanrecv1、chanrecv2：一个参数、两个参数，会调用chanrecv
   - closechan
#### mutex
1. 设计历程
   - 第一版：会排队等待获取互斥锁，
   - 第二版：排队的唤醒之后要和正在请求锁的 goroutine 进行竞争。这会让 CPU 中正在执行的 goroutine 有更多的机会获取到锁，在一定程度上提高了程序的性能，还能优化
   - 第三版：获取不到锁会通过自旋一定次数后，再执行原来的逻辑，更加公平
     1. 因为一般抢锁临界区都很小，节约了休眠唤醒的成本
   - 1.9：增加饥饿模式，进入饥饿模式，优先让等待者先获取到锁。不公平的等待时间限制在1ms，新来的同学主动谦让一下，给老同志一些机会
   - 2019：对于 Mutex 唤醒后持有锁的那个 waiter，调度器可以有更高的优先级去执行，这已经是很细致的性能优化了
### 内存管理
1. 背景
   - 多线程的今天之前共享内存，线程之前在申请内存(虚拟内存)时，由于并行问题会产生竞争不安全，加锁又会影响性能
1. 认识：使用内存分配器，采用了和TCMalloc一样的三层架构，不够了一级级去拿，提前申请好
   - mcache被逻辑处理器p持有，而不是系统线程m
   - 申请的内存对象按大小分为了三类
     1. 微对象：0 < Micro Object < 16B
     1. 小对象：16B =< Small Object <= 32KB
     1. 大对象：32KB < Large Object
1. 逻辑结构
   - mcache：线程缓存
   - mcentral：中央缓存，136个mcentral类型元素的数组构成
   - mheap：堆内存
1. 内存逃逸
   - 认识：将变量的内存分配在合适的地方，要不然就找不到了。判断整个生命周期是否在运行时完全可知，如果变量通过了这些校验就可以在栈上分配。https://zhuanlan.zhihu.com/p/145468000
   - 逃逸分析：基本原则是如果函数返回了变量的引用，那么这个变量就会逃逸。编译器通过分析代码决定变量分配的地方
   - 变量逃逸到堆上的典型情况
     1. 在方法内把局部变量指针返回
     1. 发送指针或带有指针的值到 channel 中
     1. 在一个切片上存储指针或带指针的值
     1. slice 的背后数组被重新分配了，因为 append 时可能会超出其容量(cap)
     1. 在 interface 类型上调用方法
1. GC
   - 认识：独立进程运行
     1. 三色标记清扫算法
        - 无分代：对象没有代际之分
        - 不整理：回收过程中不对对象进行移动与整理
        - 并发：与用户代码并发执行
   - 使用
     1. 手动触发：`runtime.GC()`，释放内存，但是性能短时间下降
     1. 析构方法：`runtime.SetFinalizer()`
        - 被GC时触发，由于可能任意时间被触发，因此一般只用于长期运行的程序中释放非内存资源
        - 会按依赖顺序执行
   - GC
     1. 根对象：gc在标记过程时最先检查的对象
        - 全局变量：程序在编译期就能确定的那些存在于程序整个生命周期的变量
        - 执行栈：每个 goroutine 都包含自己的执行栈，这些执行栈上包含栈上的变量及指向分配的堆内存区块的指针
        - 寄存器：寄存器的值可能表示一个指针，参与计算的这些指针可能指向某些赋值器分配的堆内存区块
     1. 实现方式：二者混合运用
        - 追踪式：从根对象出发，根据对象之间的引用信息，一步步推进直到扫描完毕整个堆并确定需要保留的对象，从而回收所有可回收的对象。Go、 Java、V8 对 JavaScript 的实现等均为追踪式 GC
          1. 标记清扫：从根对象出发，将确定存活的对象进行标记，并清扫可以回收的对象。
          1. 标记整理：为了解决内存碎片问题而提出，在标记过程中，将对象尽可能整理到一块连续的内存上。
          1. 增量式：将标记与清扫的过程分批执行，每次执行很小的部分，从而增量的推进垃圾回收，达到近似实时、几乎无停顿的目的。
          1. 增量整理：在增量式的基础上，增加对对象的整理过程。
          1. 分代式：将对象根据存活时间的长短进行分类，存活时间小于某个值的为年轻代，存活时间大于某个值的为老年代，永远不会参与回收的对象为永久代。并根据分代假设(如果一个对象存活时间不长则倾向于被回收，如果一个对象已经存活很长时间则倾向于存活更长时间)对对象进行回收。
        - 引用计数式：每个对象自身包含一个被引用的计数器，当计数器归零时自动得到回收。因为此方法缺陷较多，在追求高性能时通常不被应用。Python、Objective-C 等均为引用计数式 GC
1. wiki
   - 指针大小：8字节，64位系统的寻址范围
   - 内存线性分配
     1. 认识：用到哪了标识到哪，释放的使用FreeList形式的链表标识
        - 没有Next属性，使用前8字节存放下一个节点的指针(一个节点最小为8字节)
        - 分配出去的节点，节点整块内存空间可以被复写
   - 虚拟内存
     1. 认识：进程运行在虚拟内存上的、连续的，和物理内存通过MMU(Memory Manage Unit)映射
        - 安全：隔绝篡改
   - TCMalloc
     1. 认识：Thread Cache Memory alloc 线程缓存内存分配器，基于FreeList实现，并引入了线程级别的缓存，性能更加优异。google开源
        - 给线程添加内存缓存，减少竞争从而提高性能，当线程内存不足时才会加锁去共享的内存中获取内存
     1. 逻辑架构
        - ThreadCache：线程缓存
        - CentralFreeList(CentralCache)：中央缓存
        - PageHeap：堆内存
     1. 概念
        - Page
        - Span
          1. SpanList
        - Object
          1. SizeClass
   - go的内存对齐和unsafe包的关系和特点
     1. go可以设置内存对齐的字节数，默认为8字节
     1. 内存对齐为什么可以做到原子性？
   - 模糊堆栈，编译器自动优化放堆还是放栈
   - 贪婪占用不返还，是带GC程序的通病。程序不断执行，idle memory（即HeapIdle）会被重用，但很少归还到操作系统。
   - GC成本很高25%
### 应用
1. http
   - 核心组成
     1. 创建一个路由表，http.NewServeMux()
     1. 向路由表注册路由，并绑定处理器Handler{}
     1. 调用 http.ListenAndServe(":9090", mutex)提供服务
   - 路由表结构体解析
    ```go
    type ServeMux struct {
        mu sync.RWMutex             // 锁，由于请求涉及到并发处理，因此这里需要一个锁机制
        m map[string]muxEntry       // 路由规则，一个 string 对应一个 mux 实体，这里的 string 就是注册的路由表达式
        es []muxEntry               // 路由表达式切片，按路由从最⻓到最短排序，用来实现最⻓前缀匹配
        hosts bool                  // 是否在任意的规则中带有 host 信息
    }
    ```
   - 流程
     1. 
     1. 实例化 Server
     1. 调用 Server 的 ListenAndServe ()
     1. 调用 net.Listen ("tcp", addr) 监听端口
     1. 启动一个 for 循环，在循环体中 Accept 请求
     1. 对每个请求实例化一个 Conn，并且开启一个 goroutine 为这个请求进行服务 go c.serve () 6 读取每个请求的内容，把请求分配到路由表处理
     1. 判断 handler 是否为空，如果没有设置 handler，handler 就设置为 DefaultServeMux 8 调用 handler 的 ServeHttp
     1. 根据 request 选择 handler，并且进入到这个 handler 的 ServeHTTP
     1. 选择 handler:
        - map精确匹配
        - 切片最⻓前缀匹配，`strings.HasPrefix`
        - 如果没有路由满足，调用 NotFoundHandler 的 ServeHTTP
### 源码阅读
1. 方法
   - 如果你阅读的是syscall包，恭喜你，感觉正常：再简洁的语言，遇到环境相关，仍然会有很多 tricks，甚至用到 Cgo
   - 如果你阅读的是os一类的包，恭喜你，感觉也挺正常：涉及到与其他层面的调用， 正常
   - 如果你阅读的是net/http一类的包，那么可能是你对这部分协议不大理解，可以先看看相关的 RFC 之类的，应该会容易得多
   - 如果你阅读的是它的解释器和编译器，那么你需要先有一点编译原理的基础，至少你得知道什么是lexer，什么是parser，好歹能用yacc实现一个玩具语言，会轻松很多
   - 如果你阅读了math等包，那么很有可能是你相关算法、细节知识不足（对于并发有关的包也是如此），这不是语言的原因，是素养的问题，可以选择相应的进行适当的知识扩充。- 可以先从strings，bufio，io/ioutils这一类不大需要背景知识的包开始，感受 Golang 标准库的魅力
   - 借助注释，英文不理解的可以借助机器翻译
1. 实践
   - 先通览，再找感兴趣的，语言相关的肯定难
   - 先会用，才知道这么设计的目的
   - 先理解流程+设计思想，通过画图来辅助
   - 由简入深，先看相对独立的简单模块，如map，slice，channel
1. 学习资料
   - 书
     1. `go语言高级编程`：侧重源码级高级应用，CGO介绍
     1. `Go语言学习笔记`：系统化的介绍源码
   - 零散知识：https://zhuanlan.zhihu.com/poloxue-go
1. 内容
   - 编译原理
     1. 抽象语法树：语法分析之后的表示编程语言的语法结构，辅助编译器进行语义分析
     1. 中间代码：是一种应用于抽象机器的编程语言
        - SSA：静态单赋值，即每个变量只会被赋值一次。中间代码的特性，属于编译器后端，是代码优化的一种方法。编译器生成代码的优化也是一个非常古老并且复杂的领域
     1. 指令集：cpu的架构，如x86_64，精简和复杂没有绝对的好坏
     1. 阶段：词法与语法分析、类型检查和AST转换、通用SSA生成、机器代码生成
        - 词法分析：将字符串序列转换成Token序列，即标记序列
        - 语法分析：将Token序列按照定义好的文法生成有意义的结构体即抽象语法树，不存在语法错误了
        - 类型检查：遍历抽象语法树，改写内建函数、关键字等，不存在类型错误了
          1. 常量、类型和函数名及类型
          1. 变量的赋值和初始化
          1. 函数和闭包的主体
          1. 哈希键值对的类型
          1. 导入函数体
          1. 外部的声明
        - 抽象语法树转为中间代码，Goroutine会参与。也要经过多轮性能优化，也会根据不平平台特定的修改
          1. 关键字和内置函数的功能是由编译器和运行时共同完成的：即编译器替换名称为运行时包中的方法名，然后运行时进行调用
        - 中间码生成不同平台的机器码
   - 语言基础
     1. 接口：
        - iface：结构体，包含方法的interface{}类型
        - eface：结构体，不包含任何方法的interface{}类型
   - 运行时：runtime只提供go程序执行时候使用的库
1. 目录
   - src/cmd/compile：编译器所在
     1. src/cmd/compile/internal/gc/main.go：编译器入口
     1. src/cmd/compile/internal：机器码生成相关的包，不同平台兼容性可能会有问题
     1. src/cmd/compile/internal/ssa：对SSA中间代码进行降级、执行架构特定的优化和重写并生成obj.Prog指令
     1. src/cmd/internal/obj：作为汇编器，最终转换成机器码完成编译
1. wiki
   - 编译器
     1. 前端：词法分析、语法分析、类型检查和中间代码生成
     1. 后端：目标代码的生成和优化（二进制码）
   - 汇编器
1. interface
   - 组成
     1. ‌runtime.iface 表示第一种
     1. runtime.eface 表示第二种不包含任何方法的接口
### wiki
1. 认识
   - 通过这样复杂的检查、判断和设置，实现一些目的。了解了设计思想，看实现是一个证实的过程
   - 现在的 Mutex 代码已经复杂得接近不可读的状态了，而且代码也非常长，删减后占了几乎三页纸。但是，作为第一个要详细介绍的同步原语，我还是希望能更清楚地剖析 Mutex 的实现，向你展示它的演化和为了一个貌似很小的 feature 不得不将代码变得非常复杂的原因
1. 重难点
   - 并发模型GPM
   - goroutine、channel调度
   - 内存管理、GC
1. goyacc：和yacc的功能一样，根据输入的语法规则文件，生成该语法规则的golang版的yacc
   - Lex & Yacc：用来生成词法分析器和语法分析器的工具，yacc用c写的
     1. Flex&Bison：Flex是由Vern Paxon实现的一个Lex，Bison则是GNU版本的YACC