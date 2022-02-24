### 代码段
1. 打印
    ```python
    str = 'abcde'
    print (str[0])       # 输出字符串第一个字符
    print (str[2:])      # 输出从第三个开始的后的所有字符
    print (str[0:-1])    # 输出第一个到倒数第二个的所有字符
    print (str * 2)      # 输出字符串两次
    print (str + "TEST") # 连接字符串
    ```
1. list
   - 使用
        ```python
        list = ['abcd', 786, 70.2]                          # 定义
        list[1:3]                                               # 第二个到第三个元素，第二位置进一
        list[0] = 9                                         # 改变
        del list[2]                                         # 删除
        ['a'] * 4                                           # 重复
        3 in [1, 2, 3]                                      # 检查是否存在，返回Bool
                                                            # 遍历
        for x in [1, 2, 3]:
            print(x, end=" ")
                                                            # 同时遍历更多序列
        num = ['1', '2', '3']
        word = ['a', 'b', 'c']
        for n, w in zip(num, word):
                                                            # 多维
        list = [[0 for i in range(5)] for i in range(5)]
        list[0][0]
        ```
   - 列表推导式：提供了从序列创建列表的简单途径，通过计算、判断得出新的列表
        ```python
        vec = [2, 4, 6]
        [3*x for x in vec]          # 将元素都乘以3，[6, 12, 18]
        [[x, x**2] for x in vec]    # 得出二维列表，[[2, 4], [4, 16], [6, 36]]
        [3*x for x in vec if x > 3] # 判断，[12, 18]

        word = ['  a', '  b ', 'c  ']
        x.strip() for x in freshfruit   # 调用方法处理
        ```
   - 列表嵌套
        ```python
        matrix = [                                          # 3x4矩阵
            [1, 2, 3, 4],
            [5, 6, 7, 8],
            [9, 10, 11, 12],
        ]
        [[row[i] for row in matrix] for i in range(4)]      # 转换为4x3矩阵
        ```
1. Tuple
    ```python
    # 定义
    tuple = ('abcd', 786, 70.2)
    # 定义
    t = 12345, 54321, 'hello!'
    u = t, (1, 2, 3, 4, 5)
    ```
1. Sets
    ```python
    student = {'Tom', 'Jim', 'Mary', 'Tom', 'Jack', 'Rose'}
    # 输出集合，重复的元素被自动去掉
    print(student)
    # 成员测试
    if('Rose' in student) :
        print('Rose 在集合中')
    else :
        print('Rose 不在集合中')
    # set进行集合运算
    a = set('abracadabra')
    b = set('alacazam')
    # 显示结果
    print(a - b)     # a和b的差集
    print(a | b)     # a和b的并集
    print(a & b)     # a和b的交集
    print(a ^ b)     # a和b中不同时存在的元素
    ```
1. Dictionary
    ```python
    # 定义
    dict = {}
    dict['one'] = "1"
    dict[2]     = "2"
    # 定义
    dict = {'name': 'runoob','code': 1}
    dict = dict([('name', 'runoob'), ('code', 1)])
    dict = dict(sape=4139, guido=4127, jack=4098)
    # 输出
    dict['one']
    # 遍历
    for k, v in knights.items():
    ```
1. 变量
    ```python
    counter = 1000         # 整型变量
    name    = "runoob"     # 字符串
    a = b = c = 1          # 多个变量赋值，三个变量被分配到相同的内存空间上
    a, b, c = 1, 2, "abc"  # 多个变量赋多个值
    ```
1. 作用域
    ```python
    b = int(2.9)            # 内建作用域
    g_count = 0             # 全局作用域
    def outer():
        e_count = 1         # 闭包函数外的函数中
        def inner():
            l_count = 2     # 局部作用域
    ```
1. 迭代器
    ```python
    list=[1,2,3,4]
    it = iter(list)    # 创建迭代器对象
    next(it)           # 输出迭代器的下一个元素
    for x in it: 语句   # 可以迭代迭代器
    ```
1. 生成器
    ```python
    def fibonacci(n):                   # 生成器函数 - 斐波那契
        a, b, counter = 0, 1, 0
        while True:
            if (counter > n):
                return
            yield a
            a, b = b, a + b
            counter += 1
    f = fibonacci(10)                   # f 是一个迭代器，由生成器返回生成，已经执行了一次，停在了yield处
    # 执行具体代码
    while True:
        try:
            print (next(f), end=" ")    # 调用next函数，开始执行第二以及更多次
        except StopIteration:
            sys.exit()
    ```
1. 遍历
    ```python
    # 遍历数字
    for i in range(5):
    ```
1. 类
    ```python
    class MyClass(BaseClass1, BaseClass2):      # 继承，子类没有方法，从左至右的父级中查找
        def __init__(self, realpart):
            self.r = realpart
        i = 12345
        def f(self):                            # 类的方法与普通的函数只有一个区别就是有一个额外的第一参数，惯例为self
            this = self.class                   # 指向类
            j = self.i                          # 访问类变量
            return 'hello world'
    x = MyClass(3306)                           # 实例化类
    x.i                                         # 访问类属性
    x.f()                                       # 访问类方法
    ```
1. 类的关系判断
    ```python
    class A:
        pass
    class B(A):
        pass

    isinstance(A(), A)    # returns True
    type(A()) == A        # returns True
    isinstance(B(), A)    # returns True
    type(B()) == A        # returns False
    ```
1. 文件
    ```python
    f = open("/tmp/foo.txt", "wb+")           # 二进制方式读写，默认r
    f.write( "你好! \n" )
    value = ('a', 1)                          # 先转换
    s = str(value)
    f.write(s)
    f.close()
    ```
1. 正则
   - match
    ```python
    matchObj = re.match('www', 'www.a.com').span()      # 在起始位置匹配
    matchObj.group(num=0)                               # 包含对应组的值
    matchObj.groups()                                   # 包含所有小组字符串的元组
    ```
   - sub
    ```python
    # 被替换者可以是个函数
    def double(matched):
        value = int(matched.group('value'))
        return str(value * 2)

    s = 'A23G4HFD567'
    print(re.sub('(?P<value>\d+)', double, s))          # 输出A46G8HFD1134
    ```
1. 输入
    ```python
    str = input("请输入：");
    print("你输入的内容是: ", str)
    ```
1. 序列化
    ```python
    output = open('data.pkl', 'wb')
    pickle.dump(data1, output)
    pickle.dump(data2, output, -1)          # 结尾添加
    output.close()
    ```
1. 反序列化
    ```python
    pkl_file = open('data.pkl', 'rb')
    data1 = pickle.load(pkl_file)
    pprint.pprint(data1)
    pkl_file.close()
    ```
1. 多线程
   - _thread
    ```python
    # 为线程定义一个函数
    def print_time( threadName, delay):
        count = 0
        while count < 5:
            time.sleep(delay)
            count += 1
            print ("%s: %s" % ( threadName, time.ctime(time.time())))
    # 创建线程
    _thread.start_new_thread(print_time, ("Thread-1", 2,))
    ```
   - threading
    ```python
    class myThread (threading.Thread):
        def __init__(self):
            threading.Thread.__init__(self)
        def run(self):
            print ("开始线程：" + self.name)
            print ("退出线程：" + self.name)
    # 创建新线程
    thread1 = myThread()
    # 开始运行
    thread1.start()
    thread1.join()
    ```
1. 线程同步
    ```python
    class myThread (threading.Thread):
        def __init__(self):
            threading.Thread.__init__(self)
        def run(self):
            threadLock.acquire()        # 获取锁，用于线程同步
            threadLock.release()        # 释放锁，开启下一个线程

    threadLock = threading.Lock()
    threads = []

    # 创建新线程
    thread1 = myThread()
    # 开启新线程
    thread1.start()
    # 等待所有线程完成
    threads.join()
    ```
1. 优先级队列
    ```python
    import queue
    import threading
    import time

    exitFlag = 0

    class myThread (threading.Thread):
        def __init__(self, threadID, name, q):
            threading.Thread.__init__(self)
            self.threadID = threadID
            self.name = name
            self.q = q
        def run(self):
            print ("开启线程：" + self.name)
            process_data(self.name, self.q)
            print ("退出线程：" + self.name)

    def process_data(threadName, q):
        while not exitFlag:
            queueLock.acquire()
            if not workQueue.empty():
                data = q.get()
                queueLock.release()
                print ("%s processing %s" % (threadName, data))
            else:
                queueLock.release()
            time.sleep(1)

    threadList = ["Thread-1", "Thread-2", "Thread-3"]
    nameList = ["One", "Two", "Three", "Four", "Five"]
    queueLock = threading.Lock()
    workQueue = queue.Queue(10)
    threads = []
    threadID = 1

    # 创建新线程
    for tName in threadList:
        thread = myThread(threadID, tName, workQueue)
        thread.start()
        threads.append(thread)
        threadID += 1

    # 填充队列
    queueLock.acquire()
    for word in nameList:
        workQueue.put(word)
    queueLock.release()

    # 等待队列清空
    while not workQueue.empty():
        pass

    # 通知线程是时候退出
    exitFlag = 1

    # 等待所有线程完成
    for t in threads:
        t.join()
    print ("退出主线程")
    ```
1. 网络编程服务端实例
    ```python
    serversocket = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
    serversocket.bind((socket.gethostname(), 9999))
    serversocket.listen(5)                              # 最大连接数，超过后排队
    # 阻塞监听
    while True:
        clientsocket,addr = serversocket.accept()       # 建立客户端连接
        msg='你好'+ "\r\n"
        clientsocket.send(msg.encode('utf-8'))
        clientsocket.close()
    ```
   - 客户端实例
    ```python
    s = socket.socket(socket.AF\_INET, socket.SOCK_STREAM)
    s.connect((socket.gethostname(), 9999))
    msg = s.recv(1024)                  # 接收小于1024字节的数据
    s.close()
    ```
### 线程池
1. 简单的线程池
    ```python
    import time
    import threading

    class SimpleThreadPool:
        def process(self):
            while True:
                if len(self.queue) == 0:
                    time.sleep(1)
                    continue
                task = self.queue.pop()
                task()

        def __init__(self, size):
            self.pool = []
            self.queue = []
            for i in range(size):
                self.pool.append(threading.Thread(target=self.process))

        def submit(self, task):
            self.queue.append(task)

        def start(self):
            for thread in self.pool:
                thread.start()

    def _task():
        for i in range(2):
            print('this is a _task. i = {}. thread id = {}'.format(i, threading.get_native_id()))
            time.sleep(1)


    if __name__ == '__main__':
        pool = SimpleThreadPool(10)
        pool.start()
        for i in range(10):
            pool.submit(_task)
    ```
1. 官方线程池示例
    ```python
    import time
    import threading
    from concurrent.futures import ThreadPoolExecutor


    def _task():
        for i in range(2):
            print('this is a _task. i = {}. thread id = {}'.format(i, threading.get_native_id()))
            time.sleep(1)
        return time.time()


    tp = ThreadPoolExecutor(10)                     # 初始化

    futures = []
    for i in range(10):
        # future对象
        future = tp.submit(_task)                   # 提交任务
        futures.append(future)                          # feture对象可能是还未执行完的
        
    for future in futures:
        print(future.result())                      # 获取结果，是阻塞的，所以要所有任务提交后再拿结果
    ```
### 应用
1. CGI编程
   - 示例
    ```python
    import cgi, cgitb
    # 实例化cgi
    form = cgi.FieldStorage()
    # 获取数据
    form.getvalue('name')
    # 获取环境变量
    for key in os.environ.keys():
        pass
    os.environ.get('HTTP_COOKIE')
    # 上传文件
    fileitem = form['filename']
    fn = os.path.basename(fileitem.filename)                # 设置文件路径
    open('/tmp/' + fn, 'wb').write(fileitem.file.read())
    # 返回数据
    print ("Content-type:text/html")
    print ()                                                # 空行，告诉服务器结束头部
    print ('<html></html>')
    ```
1. 连接MySQL
   - 理解：p3使用PyMySQL，p2使用mysqldb
   - 方法
     1. 查询：fetchall()全部结果/fetchone下一条结果
   - 示例
    ```python
    import pymysql
    db = pymysql.connect("localhost","user","test","test" )             # 打开数据库连接
    cursor = db.cursor()                                                # 创建光标对象
    try:
        cursor.execute("DROP TABLE IF EXISTS table")                     # 执行sql语句
        db.commit()
    except:
        db.rollback()
    db.close()
    ```
1. json解析：json.dumps()，编码。json.loads()，解码
    ```python
    import json
    data = {'no':1,'name':'Runoob'}
    json_str = json.dumps(data)
    print ("Python 原始数据：", repr(data))
    print ("JSON 对象：", json_str)
    ```
1. XML解析
   - XML理解：可扩展标记语言，通用标记语言的子集
   - 方案
     1. SAX：Simple API for XML，采用事件驱动模型，包含解析器和事件处理器，python标准库包含SAX解析器
        ```python
        # 创建一个 XMLReader
        parser = xml.sax.make_parser()
        parser.setFeature(xml.sax.handler.feature_namespaces, 0)        # turn off namepsaces
        Handler = MovieHandler()                                        # 重写 ContextHandler
        parser.setContentHandler(Handler)
        parser.parse("movies.xml")

        class MovieHandler( xml.sax.ContentHandler ):
            def \_\_init__(self):
            # 元素开始调用
            def startElement(self, tag, attributes):
            # 元素结束调用
            def endElement(self, tag):
            # 读取字符时调用
            def characters(self, content):
        ```
     1. DOM：Document Object Model，将xml数据在内存中解析为一个树
        ```python
        from xml.dom.minidom import parse
        import xml.dom.minidom
        
        # 使用minidom解析器打开 XML 文档
        DOMTree = xml.dom.minidom.parse("movies.xml")
        collection = DOMTree.documentElement
        collection.hasAttribute("shelf")
        collection.getAttribute("shelf")
        collection.getElementsByTagName("movie")
        ```
1. 场景
   - Pandas + Jinja + WeasyPrint制作pdf报告
### socket通信
1. client
    ```python
    import socket


    client = socket.socket()
    print('client.fileno:', client.fileno())

    client.connect(('127.0.0.1', 8999))

    while True:
        content = input('>>>')
        client.send(bytes(content, 'utf-8'))
        content = client.recv(1024)
        print('client recv content:', content)
    ```
1. server单连接
    ```python
    import socket


    # 1. 创建套接字
    server = socket.socket()
    print('server.fileno:', server.fileno())
    # 2. 绑定套接字
    server.bind(('127.0.0.1', 8999))
    # 3. 监听套接字
    server.listen(1)
    # 4. 接受连接
    s, addr = server.accept()
    print('s.fileno:', s.fileno())
    print('connect addr:', addr)

    while True:
        # 接受信息
        content = s.recv(1024)
        if not content:
            break
        # 发送信息
        s.send(content.upper())
        print('server recv content:', content)
    ```
1. server多线程：一个连接一个线程，占用资源大
    ```python
    import socket
    import threading


    def thread_process(s):
        while True:
            content = s.recv(1024)
            if len(content) == 0:
                break
            s.send(content.upper())
            print(str(content, encoding='utf-8')) # 接受来自客户端的消息，并打印出来
            # s.close()

    server = socket.socket() # 1. 新建socket
    server.bind(('127.0.0.1', 8999)) # 2. 绑定IP和端口（其中127.0.0.1为本机回环IP）
    server.listen(5) # 3. 监听连接

    while True:
        s, addr = server.accept() # 4. 接受连接

        new_thread = threading.Thread(target=thread_process, args=(s, ))
        print('new thread process connect addr：{}'.format(addr))
        new_thread.start()
    ```
1. server：io多路复用epoll实现
    ```python
    import socket
    import select

    def serve():
        server = socket.socket()
        server.bind(('127.0.0.1', 8999))
        server.listen(1)

        # 申请epoll对象
        epoll = select.epoll()
        # 对server的这个套接字文件，注册可读事件
        epoll.register(server.fileno(), select.EPOLLIN)

        connections = {}
        contents = {}
        while True:
            # 通过epoll系统调用，监听可读fds
            events = epoll.poll(10)
            for fileno, event in events:
                # 新连接
                if fileno == server.fileno():
                    s, addr = server.accept()
                    print('new connection from addr:', addr)
                    epoll.register(s.fileno(), select.EPOLLIN)
                    connections[s.fileno()] = s
                # 读事件就绪，有新数据可读
                elif event == select.EPOLLIN:
                    s = connections[fileno]
                    content = s.recv(1024)
                    # 关闭连接
                    if not content:
                        epoll.unregister(fileno)
                        s.close()
                        connections.pop(fileno)
                    else:
                        content = content.upper()
                        # 改为关注写事件
                        epoll.modify(fileno, select.EPOLLOUT)
                        contents[fileno] = content
                # 写事件就绪
                elif event == select.EPOLLOUT:
                    try:
                        content = contents[fileno]
                        s = connections[fileno]
                        s.send(content)
                        # 改为关注读事件
                        epoll.modify(fileno, select.EPOLLIN)
                    except:
                        epoll.unregister(fileno)
                        s.close()
                        connections.pop(fileno)
                        contents.pop(fileno)


    if __name__ == '__main__':
        serve()
    ```
