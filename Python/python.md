## 认识
1. 理解：是一种解释性、动态数据类型、面向对象的高级编程语言，抽象层次高，表达能力强，1989年发明。Python3不向下兼容
1. 特点
   - 易于理解、学习
   - 拥有广泛的标准库，广泛用于爬虫、数学分析
1. 举例
   - vim hello.py
        ```python
        #!/usr/bin/python3
        print("Hello, World!");
        ```
   - python3 hello.py
## 语法
1. 基础
   - 编码：默认utf8编码，可以指定不同编码：`# -*- coding: cp-1252 -*-`\
   - 标识符：不能以数字开头，对大小写敏感
   - 注释：单行 #，多行 '''或"""
   - 行与缩进：用缩进代表代码块，无需大括号包裹。同一代码块的缩进空格数必须相等。使用反斜杠实现多行语句，使用分号表示多条语句在一行
   - 关键字：True/False，表示1/0，可以和数字直接运算，""也是假，不是基本数据类型
1. 数据类型
   - Number：数字
     1. 分类
        - int：整数，可以表示长整型，没有python2的long类型
        - float：浮点数，如1.23、1E-2
        - complex：复数，如1 + 2j
     1. 运算符
        - 算术运算符：+-*/%，a**b次幂，//取整除
        - 比较运算符：== != > < >= <=，==比较的是值，is比较引用对象
        - 赋值运算符：= += -= *= /= %= **= //=
        - 位运算符：& | ^ ~ << >>
        - 逻辑运算符：and or not，如`if(a and b)`，and从左到右计算表达式，若所有值均为真，返回最后一个值，若存在假，返回第一个假值；or从左到右返回第一个为真的值
        - 成员运算符：in/not in，是否存在于序列中，如`if(a in list)`
        - 身份运算符：is/is not，两个标识符是否引用自一个对象，如`if(a is b)`，a是20b是30都不同
     1. 特点
        - 除法(/)总是返回一个浮点数，要获取整数使用//操作符
        - 不同机器上浮点数运算的结果可能不一样
   - String：字符串
     1. 功能
        - 单引号和双引号完全相同，两者都可表示
        - 字符串不可改变，向一个索引位置赋值，比如word[0] = 'm'会导致错误
        - 字符串截取：左往右以0开始，从右往左以-1开始
        - 连接符+，转义符\，复制符*
     1. 分类
        - 自然字符串：加前缀r/R，表示全部输出。如 r"hello\n"，则\n会显示
        - unicode字符串：加前缀u/U
        - 级联字符串：如"this " "is " "string"会被自动转换为this is string
     1. 三引号：从引号和特殊字符串的泥潭中走出来
        ```python
        cursor.execute('''
        CREATE TABLE users (
        login VARCHAR(8),
        uid INTEGER,
        prid INTEGER)
        ''')
        ```
     1. 格式化：
        - 新版：`print('{1} 和 {0}, 和 {other}, 和 {0:.3f} 和 {1:10d}, 和 {5[a]:d} 和{a:d}'.format('a', 'b', other='c', math.pi, '1.2345', dict, **dict))`
        - 旧版格式化：支持格式化输出字符串，就是将值插入到有格式符%s的字符串中，和c的sprintf一样的语法，如`print("我叫 %s 今年 %d 岁!" % ('小明', 10)`
          1. 格式化符号：%c符合和ACS||，%s字符串，%d整数，%u无符号整数，%o八进制，%x十六进制，%X十六进制(大写)...
          1. 辅助指令：*定义宽度或小数点精度，-左对齐，(var)映射变量...
     1. 函数：len(string)、lower()、count(str, beg= 0,end=len(string))、encode/decode(encoding='UTF-8',errors='strict')、
     1. 方法
        - str.rjust/center/zfill/format
        - str()：以用户易读的方式输出
        - repr(`：解释器易读的形式输出
     1. 实例
        ```python
        str = 'abcde'
        print (str[0])       # 输出字符串第一个字符
        print (str[2:])      # 输出从第三个开始的后的所有字符
        print (str[0:-1])    # 输出第一个到倒数第二个的所有字符
        print (str * 2)      # 输出字符串两次
        print (str + "TEST") # 连接字符串
        ```
   - List：列表
     1. 理解：使用最频繁，可以继续嵌套列表，可以被索引和切片、可以用+拼接、元素可以被改变，以数字为索引
     1. 实例
        ```python
        # 定义
        list = ['abcd', 786, 70.2]
        # 使用
        list[1:3]        # 第二个到第三个元素，第二位置进一
        # 改变
        list[0] = 9
        # 删除
        del list[2]
        # 重复
        ['a'] * 4
        # 检查是否存在，返回True
        3 in [1, 2, 3]
        # 遍历
        for x in [1, 2, 3]:
            print(x, end=" ")
        # 同时遍历更多序列
        num = ['1', '2', '3']
        word = ['a', 'b', 'c']
        for n, w in zip(num, word):
        # 多维
        list = [ [0 for i in range(5)] for i in range(5)]
        listp[0][0]
        ```
     1. 方法
        - len()
        - append()/extend()/insert()
        - pop()
        - index()
        - max/min()
     1. 列表推导式：提供了从序列创建列表的简单途径，通过计算、判断得出新的列表
        ```python
        vec = [2, 4, 6]
        [3*x for x in vec]          # 将元素都乘以3，[6, 12, 18]
        [[x, x**2] for x in vec]    # 得出二维列表，[[2, 4], [4, 16], [6, 36]]
        [3*x for x in vec if x > 3] # 判断，[12, 18]

        word = ['  a', '  b ', 'c  ']
        x.strip() for x in freshfruit   # 调用方法处理
        ```
     1. 列表嵌套
        ```python
        matrix = [                                          # 3x4矩阵
            [1, 2, 3, 4],
            [5, 6, 7, 8],
            [9, 10, 11, 12],
        ]
        [[row[i] for row in matrix] for i in range(4)]      # 转换为4x3矩阵
        ```
   - Tuple
     1. 理解：元组，元素不能被改变的列表，用括号表示，可以嵌套包含列表等数据类型。只有一个元素需要后边加逗号。string、list和tuple都属于sequence序列
     1. 定义
        ```python
        # 定义
        tuple = ('abcd', 786, 70.2)
        # 定义
        t = 12345, 54321, 'hello!'
        u = t, (1, 2, 3, 4, 5)
        ```
   - Sets：集合
     1. 理解：是无序不重复元素的序列，用于成员关系测试和删除重复元素。用{}或set()函数创建集合，必须用set()创建空集合
     1. 实例
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
   - Dictionary：字典
     1. 理解：字典是无序的键值对集合。字典当中的元素是通过键来存取的，而不是通过偏移存取。同一个字典键必须唯一，并且是不可变类型，可以无极限嵌套
     1. 函数
        - len()
     1. 方法
        - clear()
        - keys()/items()
     1. 实例
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
   - 类型转换
     1. int/long/float/complex()
     1. str/repr(表达式字符串)/eval(执行字符串中的python表达式)()
     1. list/tuple/set/dict/frozenset(不可变集合)()
     1. chr(整数转字符)/unichr(整数转unicode)/ord(字符转整数)/hex(整数转十六进制字符串)/oct(整数转八进制字符串)
1. 变量
   - 理解：不需要声明，使用前必须赋值，赋值之后变量才会被创建。变量的类型由赋予它的值来决定，以值为基准，一个值一个内存地址，多个变量可以指向一个内存地址，变量没有类型，仅仅是一个对象的引用
   - 操作
     1. del：删除对象引用，如`del a, b`，如删除多个 `del a[2:4]/a[:]`
     1. *：重复
     1. in：是否存在
     1. for x in：迭代
   - 数据类型判断
     1. type：不认为子类是一种父类类型
     1. isinstance：认为子类是一种父类类型
     1. 实例
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
   - 作用域
     1. 分类
        - L：local，局部作用域
        - E：enclosing，闭包函数外的函数中
        - G：global，全局作用域
        - B：built-in，内建作用域
     1. 特点
        - 只有模块（module），类（class）以及函数（def、lambda）才会引入新的作用域。其他的如if、try、for都不会
        - 函数内部是局部作用域
     1. 修改作用域
        - global：定义为全局变量
        - nonlocal：当函数嵌套时，内层函数内使用nonlocal声明全局变量
     1. 实例
        ```python
        b = int(2.9)            # 内建作用域
        g_count = 0             # 全局作用域
        def outer():
            e_count = 1         # 闭包函数外的函数中
            def inner():
                l_count = 2     # 局部作用域
        ```
   - 迭代器
     1. 理解：是可以记住遍历的位置的对象，从第一个元素开始，只能往前不能后退
     1. 实例
        ```python
        list=[1,2,3,4]
        it = iter(list)    # 创建迭代器对象
        next(it)           # 输出迭代器的下一个元素
        for x in it: 语句   # 可以迭代迭代器
        ```
   - 生成器
     1. 理解：使用yield的函数是生成器，是一个返回迭代器的函数，只能用于迭代操作。在调用生成器运行的过程中，每次遇到 yield 时函数会暂停并保存当前所有的运行信息，返回yield的值。并在下一次执行next()方法时从当前位置继续运行，就是在 yield 处中断并返回一个结果，然后再次调用的时候再恢复中断继续运行，可以节省内容
     1. 实例
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
   - 举例
    ```python
    counter = 1000         # 整型变量
    name    = "runoob"     # 字符串
    a = b = c = 1          # 多个变量赋值，三个变量被分配到相同的内存空间上
    a, b, c = 1, 2, "abc"  # 多个变量赋多个值
    ```
1. 函数
   - 定义：def
    ```python
    def 函数名( 参数 ):
        "可以第一行为注释"
        return              # 没有return，函数返回None
    ```
   - 参数
     1. 分类
        - 必需：正常的，不能缺失，顺序不能变
        - 关键字：参数顺序可打乱，根据参数名解释器对应，如 `printinfo(age=1, name="a");`
        - 默认：函数自己定义默认值，如 `def printinfo(name, age = 35):`
        - 不定长：加*号的变量名会存放所有未命名的参数，没有参数就是空元组，**会将参数转为字典如 `def printinfo(arg1, *vartuple):`
   - 参数传递与值改变
     1. 传不可变对象：如String、Tuples、Numbers，函数不会改变函数外其原本的值
     1. 传可变对象：如List、Dict，函数会改变其原本的值
   - 匿名函数
     1. 定义：使用lambda来创建
     1. 特点
        - 有自己的命名空间，不能访问自己参数之外或全局命名空间里的参数
        - 是一个表达式，只能写一行，不同于C的内联函数，后者的目的是调用小函数时不占用栈内存从而增加运行效率
     1. 实例
        ```python
        sum = lambda arg1, arg2: arg1 + arg2;   # 可以无限参数，像函数一样
        sum(1, 2)                               # 输出3
        ```
   - 分类
     1. 数学函数
        - 随机数函数
          1. random()：0-1的随机数
          1. choice(seq)：随机挑选一个元素，如随机一个整数 `random.choice(range(10))`
          1. shuffle(list)：随机排序序列
          1. randrange([start,] stop [,step])：指定范围内按指定基数递增的集合中获取一个随机数
          1. uniform(x, y)：随机生成下一个实数
          1. seed([x])：改变随机数生成器的种子
     1. 数学函数：round(奇进偶弃，懂？)/max/min/abs/exp/log/pow/sqrt...
     1. 三角函数：sin/cos/tan...
     1. 数学常量：pi圆周率、e自然常数
   - id()：获取对象内存地址
   - enumerate()
1. 流程控制
   - 判断
    ```python
    if 表达式1:
        语句
    elif 表达式4:
        语句
    else:
        语句
    ```
   - 循环
    ```python
    # for
    for x in y:
        语句
    else:
        语句
    # while
    while 判断条件：
        语句
    else:
        语句
    while 判断条件：语句
    # 遍历数字
    for i in range(5):
        语句
    # 跳出循环，continue，break，但是不用执行else里的语句
    ```
   - pass：空/占位语句，为了保持程序结构完整，无意义
1. 模块
   - 特点
     1. 模块名为py文件的文件名
     1. 不管import多少次，都只会引入一次
     1. 搜索目录：文件只要存在于sys.path输出的目录下即可，结果第一个表示当前脚本目录
   - 组成
     1. `__name__`：当值为'\_\_main__'时，模块为自身运行，否则被引入执行，
   - 使用
     1. 使用
        - `module.func()`：直接执行模块中方法
        - `mod = module.func`：将模块的函数写入变量，再执行
        - `dir(module)`：显示模块中定义的所有名称
     1. 导入
        - `import modules.child`：导入模块，使用时需要带上全路径
        - `from modules import child`：导入子模块
        - `from module import firstfunc, secondfunc`：导入模块的某个函数，`from module import *`：导入模块的全部函数
   - 标准模块
     1. sys：
        - `sys.argv` 输出命令行参数
        - `sys.path` python安装路径
        - `sys.stderr.write('Warning')` 错误输出重定向
     1. os：目录接口
     1. glob：从目录通配符搜索中生成文件列表，如`glob.glob('*.py')`
     1. datetime：提供了很多日期和时间的方法，date.today()
     1. re：正则匹配
     1. pickle：序列化/反序列化对象
     1. zlib：打包和压缩，zlib.compress/decompress/crc32(s)
     1. timeit：性能度量工具，如`Timer('a,b = b,a', 'a=1; b=2').timeit()`
     1. doctest/unittest：
     1. urllib/smtplib：网络和邮件
     1. math
     1. pprint
1. 面向对象
   - 理解：尽量不增加新的语法和语义，
   - 特点
     1. 私有属性：以两个下划线开头，不能在类外部访问和直接访问
     1. 私有方法：以两个下划线开头
     1. 方法访问：直接向上的、从左至右的查找
     1. 方法重写：子类直接覆盖方法名重写
   - 类的专有方法
     1. \_\_init__
     1. \_\_del__：析构
     1. \_\_repr__：打印，转换
     1. \_\_call__：函数调用
     1. \_\_setitem/getitem/len/cmp/add/sub/mul/div/mod/pow__：各种运算类的时候用
   - 实例
    ```python
    class MyClass(BaseClass1, BaseClass2):      # 继承，子类没有方法，从左至右的父级中查找
        def \__init__(self, realpart):
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
1. IO
   - 文件
     1. 理解
        - 对待方式：文件指针默认在文件头部
          1. r：只读
          1. w：只用于写入
          1. +：读写
          1. a：用于追加，文件指针在结尾
          1. b：二进制格式
     1. 方法：对象为file.xxx
        - read(size)：限定大小，无则全部
        - readline()：读取一行，换行符为\n
        - next()：返回文件下一行
        - write()：返回写入的字符数
        - tell()：指针位置
        - seek(offset, from)：参一字符数，参二0开头，1当前，2结尾
        - close()：关闭文件释放资源
        - flush()：刷新缓冲，缓冲区数据立即写入
        - fileno()：返回文件描述符，用在os模块等底层操作上
     1. 实例
        ```python
        f = open("/tmp/foo.txt", "wb+")           # 二进制方式读写，默认r
        f.write( "你好! \n" )
        value = ('a', 1)                          # 先转换
        s = str(value)
        f.write(s)
        f.close()
        ```
   - 目录
     1. `os.system('')`：执行系统命令
     1. `os.getcwd()`：当前目录，如`os.getcwd()`
     1. `os.chdir()`
     1. `os.mkdir()`
     1. `os.rmdir()`
     1. `os.chroot()`：改变当前进程根目录
     1. `os.access(path, mode)`：检测权限，mode包括os.F\_OK存在/R\_OK读/W\_OK写/X_OK执行
     1. `os.chmod(path, mode)`
     1. `os.chown()`
     1. `os.open(path)`：打开文件
     1. `os.remove(path)`：删除文件
     1. `os.mkfifo(path[, mode])`：创建命名管道，默认0666
     1. `os.symlink(src, dst)`：软链接
     1. `os.link(src, dst)`：硬链接
   - 序列化/反序列化
     1. 理解：用于对象信息的保存
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
   - 输入输出
     1. 标准输出文件：`sys.stdout`
     1. 键盘输入：python的默认标准输入为键盘
        ```python
        str = input("请输入：");
        print("你输入的内容是: ", str)
        ```
   - 打印：`print(x)`，不换行和连接符`print(x, end="", sep='&')`
1. 多线程
   - 多线程的特点
     1. 并行提高处理速度，充分利用多核优势
     1. 可将耗时长的任务后台处理
     1. 显示进度条
     1. 每个线程都有一组cpu寄存器，如指令指针、堆栈指针
     1. 线程可以被抢占(中断)、搁置(睡眠)
     1. 分为：内核线程、用户线程
   - 分类
     1. \_thread：thread被废弃，p3叫_thread，提供低级别的、原始的线程以及一个简单的锁，功能有限
        ```python
        # 为线程定义一个函数
        def print_time( threadName, delay):
            count = 0
            while count < 5:
                time.sleep(delay)
                count += 1
                print ("%s: %s" % ( threadName, time.ctime(time.time())))
        # 创建线程
        \_thread.start\_new\_thread(print_time, ("Thread-1", 2,))
        ```
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
        - 实例
            ```python
            class myThread (threading.Thread):
                def \_\_init__(self):
                    threading.Thread.\_\_init__(self)
                def run(self):
                    print ("开始线程：" + self.name)
                    print ("退出线程：" + self.name)
            # 创建新线程
            thread1 = myThread()
            # 开始运行
            thread1.start()
            thread1.join()
            ```
   - 线程同步：即线程锁，使用Thread对象的Lock/Rlock，具体为acquire/release方法
        ```python
        class myThread (threading.Thread):
            def \_\_init__(self):
                threading.Thread.\_\_init__(self)
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
   - 优先级队列
     1. 理解：Queue模块提供了同步的、线程安全的队列类，实现了锁原语，可以使用队列实现线程间的同步、
     1. 分类
        - Queue：先入先出，FIFO
        - LifoQueue：后入先出，LIFO
        - PriorityQueue：优先级队列
     1. 方法
        - Queue.qsize()/empty()/full()/maxsize()
        - Queue.get([block[, timeout])/get\_nowait()：获取队列，get_nowait和get(false)相同
        - Queue.put(item)/put\_nowait()：写入队列，put_nowait()相当于put(item, False)
        - Queue.task_done()：完成一项工作后，向已完成的队列发送一个信号
        - Queue.join()：等到队列为空，再执行别的操作
     1. 实例
        ```python
        import queue
        import threading
        import time

        exitFlag = 0

        class myThread (threading.Thread):
            def \_\_init__(self, threadID, name, q):
                threading.Thread.\_\_init__(self)
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
1. 函数式编程
1. 装饰器模式
1. 时间和日期
   - time
     1. time.time()：时间戳
     1. time.asctime(time.localtime(time.time()))：格式化时间，Thu Apr  7 10:29:13 2016
     1. time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())：格式化时间，2016-03-20 11:45:39
   - calendar
     1. calendar.month(2016, 1)：输出日历
1. 错误和异常
   - 异常处理：try/except
    ```python
    try:
    except OSError as err:
        print("OS error: {0}".format(err))
    except ValueError:
    except (RuntimeError, TypeError, NameError):
    except:                                         # 最后一个作为通配使用
    else:                                           # 放在except之后，没有异常会执行这里
    finally:                                        # 无论如何都会执行。如果有异常，没有except接住的话，会再抛一次
    ```
   - 抛出异常：raise
    ```python
    raise                           # 抛出一个异常
    raise NameError('HiThere')      # 抛出指定异常，参数必须为异常的实例或者异常的类(即Exception的子类)
    ```
   - 自定义异常
    ```python
    class Error(Exception):             # 定义一个基础的类，通过继承扩展异常类型
        pass
    class InputError(Error):
    class TransitionError(Error):
    ```
1. 正则
   - 理解：自1.5增加re模块，提供Perl风格的正则模式
   - 函数
     1. match：只从起始位置匹配，否则返回None，成功返回对象
        ```python
        matchObj = re.match('www', 'www.a.com').span()      # 在起始位置匹配
        matchObj.group(num=0)                               # 包含对应组的值
        matchObj.groups()                                   # 包含所有小组字符串的元组
        ```
     1. search：查找，用法同match
     1. sub：替换
        ```python
        # 被替换者可以是个函数
        def double(matched):
            value = int(matched.group('value'))
            return str(value * 2)

        s = 'A23G4HFD567'
        print(re.sub('(?P<value>\d+)', double, s))          # 输出A46G8HFD1134
        ```
   - 修饰符
     1. re.I 大小写
     1. re.L 本地化识别匹配
     1. re.M 多行
     1. re.S 匹配所有字符
     1. re.U 根据Unicode字符集解析字符，影响\w/W/b/B
     1. re.X 给允更灵活的方式
1. 使用方式
   - 脚本式模式：指定Shell脚本的解释器，作为脚本文件执行
     1. 添加：#! /usr/bin/env python3
     1. 执行命令：./hello.pf
   - 命令行：python3 -h
   - 交互式编辑模式：输入python3进入
     1. help(max)：打印文档，:q退出说明文档
     1. 等待用户输入：`input("按下 enter 键后退出")`
     1. 构造函数：dict([('a', 1), ('b', 2), ('c', 3)])

## 使用
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
    cursor = db.cursor()                                                # 创建游标对象
    try:
        cursor.execute("DROP TABLE IF EXISTS USER")                     # 执行sql语句
        db.commit()
    except:
        db.rollback()
    db.close()
    ```
1. 网络编程
   - 分类
     1. 低级别：提供了标准的BSD Sockets API，可以访问底层操作系统Socket接口的全部方法
     1. SocketServer：简化网络服务开发
   - 定义
    ```python
    import socket
    # 参一套接字家族，为AF\_UNIX或者AF_INET
    # 参二，套接字类型，SOCK\_STREAM或SOCK_DGRAM
    serversocket = socket.socket(socket.AF\_INET, socket.SOCK\_STREAM)
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
   - 服务端实例
    ```python
    serversocket = socket.socket(socket.AF\_INET, socket.SOCK\_STREAM)
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
1. json解析：json.dumps()，编码。json.loads()，解码
    ```python
    import json
    data = {
        'no' : 1,
        'name' : 'Runoob',
    }

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
## WIKI
1. 保留字
   - class，from，import，return，
   - if，elif，else，for，while，continue，break，finally，pass，
   - None，False，True
   - del，in，is，and，or，not，global，nonlocal，def，lambda，yield，
   - try，except，raise，
   - as，assert，with
