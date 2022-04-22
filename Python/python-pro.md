### 高级
1. 函数式编程
   - 基础函数：filter、map、reduce
   - 返回函数
   - 匿名函数
   - 装饰器：coroutine
    ```py
    # 定义
    def log(func):
        @functools.wraps(func)                                  # 减少副作用
        def wrapper(*args, **kwargs):
            print('print from log. call {}. call time = {}'.format(func.__name__, int(time.time())))
            return func(*args, **kwargs)
        return wrapper

    # 使用
    @log
    def function():
        # print('call function. call time = {}'.format(int(time.time()))
        print('Hello World. Hello function...')
    ```
   - 偏函数
1. 多进程
   - 认识
     1. multiprocessing：多进程管理包
        - Process()：是对象，创建进程
          1. start
        - Queue()
   - 进程池
     1. 认识：和线程一样
     1. 作用：和线程一样，比线程更重
     1. ProcessPoolExecutor：进程池标准库
        - append
        - result
1. 多线程
   - 多线程的特点
     1. 并行提高处理速度，充分利用多核优势
     1. 可将耗时长的任务后台处理
     1. 显示进度条
     1. 每个线程都有一组cpu寄存器，如指令指针、堆栈指针
     1. 线程可以被抢占(中断)、搁置(睡眠)
     1. 分为：内核线程、用户线程
     1. python是伪多线程，因为GIL的存在同时只有一个核工作
        - cpu密集型的用多线程效率下降70%，线程上下文切换，线程越多，上下文切换越多
        - 核数和线程数
          1. cpu密集型：n + 1
          1. io密集型：2n + 1
   - 分类
     1. _thread：thread被废弃，p3叫_thread，提供低级别的、原始的线程以及一个简单的锁，功能有限
     1. threading：使用threading代替
        - 方法
          1. threading.currentThread()：返回当前的线程变量
          1. threading.enumerate(): 返回一个包含正在运行的线程的list
          1. threading.activeCount(): 返回正在运行的线程数量
        - Thread的方法
          1. run()：执行线程的地方
          1. start()：启动线程
          1. join([time])：等待至线程终止
          1. exit()：终止线程
          1. getName()：返回线程名
          1. setName()：设置线程名
   - 线程同步：即线程锁，使用Thread对象的Lock/Rlock，具体为acquire/release方法
   - 线程池
     1. 认识：是存放多个线程的容器，cpu调度线程执行后放回重复利用，减少上下文切换成本
     1. 作用
        - 线程是重型资源
        - 线程创建和业务处理解耦，更加优雅
        - 线程池是使用线程的最佳实践，不建议直接使用线程
     1. ThreadPoolExecutor：官方线程库
1. GIL
   - 认识：Global Interpreter Lock：全局解释锁，互斥锁，在CPython中
     1. 是一个全局锁，全python同一时间只允许执行一个线程
     1. 保证了python解释器的正确运行，简单粗暴的设计使得python茁壮成长，写起来简单
     1. GIL在python中无法剥离，牵扯太多了
   - 多线程切换的过程：100ticks强制切换，python3 5ms强切，发生io释放GIL，所以网络请求会提高速度
     1. 多线程运行需要竞争申请GIL
     1. python虚拟机强制释放GIL
     1. io自动释放GIL
   - 其余语言的多线程支持
     1. ruby：类似GIL
     1. php：c实现的多线程
     1. lua：只支持单线程，但支持多进程
     1. js：单线程，但是异步接口丰富
1. 异步io
   - 协程
   - asyncio
   - async/await
   - aiohttp
1. 优先级队列
   - 理解：Queue模块提供了同步的、线程安全的队列类，实现了锁原语，可以使用队列实现线程间的同步
   - 分类
     1. Queue：先入先出，FIFO
     1. LifoQueue：后入先出，LIFO
     1. PriorityQueue：优先级队列
   - 方法
     1. Queue.qsize()/empty()/full()/maxsize()
     1. Queue.get([block[, timeout])/get_nowait()：获取队列，get_nowait和get(false)相同
     1. Queue.put(item)/put_nowait()：写入队列，put_nowait()相当于put(item, False)
     1. Queue.task_done()：完成一项工作后，向已完成的队列发送一个信号
     1. Queue.join()：等到队列为空，再执行别的操作
1. 网络编程
   - 分类
     1. 低级别：提供了标准的BSD Sockets API，可以访问底层操作系统Socket接口的全部方法
     1. SocketServer：简化网络服务开发
     1. tcp/udp
   - 定义
    ```py
    import socket
    # 参一套接字家族，为AF_UNIX或者AF_INET
    # 参二套接字类型，SOCK_STREAM或SOCK_DGRAM
    serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    ```
   - 方法
     1. 服务端：bind()/listen()/accept()
     1. 客户端：connect()/connect_ex()
     1. 公共
        - send()：发送tcp数据
        - recv(size)：接受tcp数据，指定最大接收量
        - sendto()：发送UDP数据
        - recvform()：接收UDP数据
        - settimeout()：超时期
   - 网络模块
     1. HTTP
     1. NNTP：帖子
     1. FTP
     1. Telnet：命令行
     1. Gopher：信息查找
     1. SMTP/POP3/IMAP4
1. 图形界面
   - Tk
   - wxWidgets
   - Qt
   - GTK
1. python解释器
   - 分类
     1. CPython：最官方的开源的，c语言开发，提示符>>>
     1. Jython：java实现，可将python编译为java字节码
     1. PyPy：python实现，执行速度快，使用JIT技术进行动态编译，和其他解释器执行可能有不同地方
     1. IronPython：.net平台上的
     1. IPython：交互方式增强，提示符:
   - 虚拟环境：virtualenv
### 协程
1. 协程学习目录
   - 基础知识
     1. 用户态和内核态
     1. 同步和异步
     1. 并行和并发
     1. 计算密集型和io密集型
   - 线程和进程
     1. 进程五态模型，调度方式
     1. 线程的实现方式
     1. 上下文切换
     1. 协程本质
   - 多线程实践
     1. 线程池
     1. 线程池标准库ThreadPoolExecutor
     1. 控制变量法分析
   - 多进程实践
     1. 进程池标准库ProcessPoolExecutor
     1. 多进程局限性
     1. 进程和线程比较，进程更重，更占资源
   - 生成器协程
     1. 学完好好补充一下
   - 实现生成器协程调度器
     1. 学完好好补充一下
   - 事件驱动编程
     1. socket编程
     1. fd认识
     1. tcp服务器原理
     1. 网络io模型认识
     1. 事件驱动编程原理和实现
   - 协程调度器
     1. async，await，可等待对象和future，协程调度器eventLoop
     1. socket协程适配器SocketWrapper
     1. 事件驱动在调度器的应用
     1. 协程tcp网络服务器
   - python协程生态
     1. aiohttp和aiodns基于asyncio的第三方库
1. 迭代器：iter/next，s是可以记住遍历的位置的对象，从第一个元素开始，只能往前不能后退
   - 概念
     1. 迭代
     1. 迭代器
     1. 可迭代对象
1. 生成器
   - 认识：是一次生成一个值的特殊类型的函数，可视为可恢复函数。使用了yield的函数就是生成器，是一个返回迭代器的函数，只能用于迭代操作
     1. send可以实现延时计算
   - 特点
     1. 只能遍历一次
     1. 占用内存空间是一定的，大幅节省内存，性能更高，因为普通的是越大的数组占用的内存越大
   - 步骤
     1. 调用生成器运行的过程中，每次遇到yield时函数会暂停并保存当前所有的运行信息，并返回yield的值。就是在yield处中断并返回一个结果
     1. 下一次执行next()时从暂停的位置恢复运行
     1. 然后再次调用的时候再恢复中断继续运行
   - 关键字
     1. yield xx
        - 可以接收、向外传递值
        - 可以把yield写在while中，实现暂停
     1. yield from：允许在一个生成器里切换迭代另一个生成器
     1. next(gen)：控制执行步骤
        - 遍历一边就结束了，然后抛出StopInteration异常
     1. gen.send()：接受外部调用者的赋值，传给yield，然后yield可以给别人 `xx = yield`
        - 也是恢复生成器执行
        - 需要先调用next激活生成器
        - 可以一直send数据
   - 应用
     1. 生产者-消费者模型：消费者yield阻塞，生产者用send发任务。可以加个调度策略，独立出来一个调度器，让生产者和消费者协调，如生产10秒就去消费
   - 原理
     1. 抢占式、协作式，
     1. yield本质是
        - 让出cpu
        - 保存当前运行进度
        - 切换运行栈
        - 从新的栈运行
1. 协程
   - 认识
     1. 可等待对象
     1. future：协程对象引用，完成标记、执行结果
   - 关键字
     1. async
        - 和await一起使用
     1. await
1. 协程实现
   - 实现类型
     1. 生成器协程
        - 协程适配器：重写生成器的方法，如send、next等
        - 调度器YieldLoop：加个队列存下来调用
     1. 事件驱动协程
        - 适配器
        - 调度器
   - 协程调度器
1. 项目：并行下载器
   - 下载模块：多线程、多进程、协程进化
   - 哈希模块
   - 存储模块
1. 协程生态
   - asyncio
     1. 认识：python3.4的标准协程库，python的协程进一步成熟
   - aiohttp/aiodns/aioredis/aiomysql
     1.认识：基于asyncio封装的第三方协程库
        - 提供http client、http server、websocket、http的路由、中间件等
        - 加速dns解析
   - aiofile
     1. 认识：线程池模拟实现的异步文件io库
   - tornado
     1. 认识：高性能异步的开源web框架，最早的python2的时候实现第三方协程的框架，python3也提供官方的协程实现
        - 自己写的协程调度，基本原理和这个框架是一样的
          1. @tornado/tornado/gen.py
          1. @tornado/tornado/platform/asyncio.py：官方协程
   - gevent