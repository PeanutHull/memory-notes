### 认识
1. 理解：是一种解释性(解释执行)、动态数据类型、面向对象的高级编程语言，抽象层次高，表达能力强，1989年发明。源代码开源，版权与许可证在python软件基金会
   - 易于理解、学习，简单优雅、易于开发
   - 执行效率换来了开发效率
   - 内置电池：官方提供完善广泛的标准库，众多第三方库远超其他语言，如网络编程、输入输出、文件系统、图形处理、数据库、文本处理等
   - 胶水语言：具有可扩展性，丰富api和工具，轻松使用其他语言的模块
1. 用途
   - web
   - 脚本
   - 爬虫
   - 数据分析：商业智能
1. 举例
   - vim hello.py
        ```python
        #!/usr/bin/python3
        print("Hello, World!");
        ```
   - python3 hello.py
### 语法
1. 基础
   - 编码：默认utf8编码，可以指定不同编码：`# -*- coding: cp-1252 -*-`
   - 标识符：不能以数字开头，对大小写敏感
   - 注释：单行 #，多行 '''或"""
   - 行与缩进：用缩进代表代码块，无需大括号包裹。同一代码块的缩进空格数必须相等。使用反斜杠实现多行语句，使用分号表示多条语句在一行
1. 数据类型
   - Bool：True/False，表示1/0，可以和数字直接运算，""也是假，不是基本数据类型
   - Number
     1. 分类
        - int：整数，可以表示长整型，没有python2的long类型
        - float：浮点数，如1.23、1E-2
        - complex：复数，如1 + 2j
     1. 特点
        - 除法(/)总是返回一个浮点数，要获取整数使用//操作符
        - 不同机器上浮点数运算的结果可能不一样
   - String
     1. 分类
        - 自然字符串：前缀r/R表示全部输出，如 r"hello\n"，则\n会显示
        - unicode字符串：前缀u/U
        - 级联字符串：如"this " "is " "string"会被自动转换为this is string
     1. 功能
        - 单引号和双引号完全相同，两者都可表示
        - 字符串不可改变，向一个索引位置赋值，比如word[0] = 'm'会导致错误
        - 字符串截取：从左往右以0开始，从右往左以-1开始
        - 连接符+，转义符\，复制符*
     1. 三引号：从引号和特殊字符串的泥潭中走出来
        ```python
        cursor.execute('''
        CREATE TABLE users (
        login VARCHAR(8),
        uid INTEGER,
        prid INTEGER)
        ''')
        ```
     1. 函数：len()、lower()、count(str,beg= 0,end=len())、encode/decode(encoding='UTF-8',errors='strict')
     1. 方法
        - str.rjust/center/zfill/format
        - str()：以用户易读的方式输出
        - repr()：解释器易读的形式输出
     1. 格式化：
        - 新版：`print('{1} 和 {0}, 和 {other}, 和 {0:.3f} 和 {1:10d}, 和 {5[a]:d} 和{a:d}'.format('a', 'b', other='c', math.pi, '1.2345', dict, **dict))`
        - 旧版：支持格式化输出字符串，就是将值插入到有格式符%s的字符串中，和c的sprintf一样的语法，如`print("我叫 %s 今年 %d 岁!" % ('小明', 10)`
          1. 格式化符号：%c符合和ACSII，%d整数，%u无符号整数，%o八进制，%x十六进制，%X十六进制(大写)，%s字符串...
          1. 辅助指令：*定义宽度或小数点精度，-左对齐，(var)映射变量...
   - List
     1. 理解：列表，数字为索引的数组，使用最频繁，可被索引和切片、元素可被改变、可用+拼接、可继续嵌套
     1. 方法
        - append()/extend()/insert()
        - len()
        - pop()
        - index()
        - max/min()
   - Tuple：元组，元素不能被改变的列表，用括号表示，可以嵌套包含列表等数据类型。只有一个元素需要后边加逗号。string、list和tuple都属于sequence序列
   - Sets：集合，是无序不重复元素的序列，用于成员关系测试和删除重复元素。用{}或set()函数创建集合，必须用set()创建空集合
   - Dictionary：字典
     1. 理解：字典是无序的键值对集合。字典当中的元素是通过键来存取的，而不是通过偏移存取。同一个字典键必须唯一，并且是不可变类型，可以无极限嵌套
     1. 函数
        - len()
     1. 方法
        - clear()
        - keys()/items()
1. 运算符
   - 算术运算符：+-*/%，a**b次幂，//取整除
   - 比较运算符：== != > < >= <=，==比较的是值，is比较引用对象
   - 赋值运算符：= += -= *= /= %= **= //=
   - 位运算符：& | ^ ~ << >>
   - 逻辑运算符：and or not，如`if(a and b)`，and从左到右计算表达式，若所有值均为真，返回最后一个值，若存在假，返回第一个假值；or从左到右返回第一个为真的值
   - 成员运算符：in/not in，是否存在于序列中，如`if(a in list)`
   - 身份运算符：is/is not，两个标识符是否引用自一个对象，如`if(a is b)`，a是20b是30都不同
1. 类型转换
   - int/long/float/complex()
   - chr(整数转字符)/unichr(整数转unicode)/ord(字符转整数)/hex(整数转十六进制字符串)/oct(整数转八进制字符串)
   - str/repr(表达式字符串)/eval(执行字符串中的python表达式)()
   - list/tuple/set/dict/frozenset(不可变集合)()
1. 变量
   - 理解：不需要声明，使用前必须赋值，赋值之后变量才会被创建。变量的类型由赋予它的值来决定，以值为基准，一个值一个内存地址，多个变量可以指向一个内存地址，变量没有类型，仅仅是一个对象的引用
   - 操作
     1. del：删除对象引用，如`del a, b`，如删除多个 `del a[2:4]/a[:]`
     1. *：重复
     1. in：是否存在
     1. for x in：迭代
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
   - 切片
   - 列表生成式
   - 迭代器：iter/next，s是可以记住遍历的位置的对象，从第一个元素开始，只能往前不能后退
   - 生成器：使用yield的函数是生成器，是一个返回迭代器的函数，只能用于迭代操作。在调用生成器运行的过程中，每次遇到yield时函数会暂停并保存当前所有的运行信息，返回yield的值。并在下一次执行next()方法时从当前位置继续运行，就是在yield处中断并返回一个结果，然后再次调用的时候再恢复中断继续运行，特点是一边循环一边计算，比如节省内存
1. 函数
   - 定义：def
    ```python
    def 函数名( 参数 ):
        "可以第一行为注释"
        return              # 没有return，函数返回None
    ```
   - 参数
     1. 必需：正常的，不能缺失，顺序不能变
     1. 关键字：参数顺序可打乱，根据参数名解释器对应，如 `printinfo(age=1, name="a");`
     1. 默认：函数自己定义默认值，如 `def printinfo(name, age = 35):`
     1. 不定长：加*号的变量名会存放所有未命名的参数，没有参数就是空元组，**会将参数转为字典如 `def printinfo(arg1, *vartuple):`
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
1. 流程控制
   - 判断
    ```python
    if 表达式1:
    elif 表达式2:
    else:
    ```
   - 循环：跳出循环，continue/break，但是不会执行else里的语句
    ```python
    # for
    for x in y:
    else:
    # while
    while 判断条件:
    else:
    while 判断条件:
    ```
   - pass：空/占位语句，为了保持程序结构完整，无意义
1. 模块
   - 特点
     1. 模块名为py文件的文件名
     1. 不管import多少次，都只会引入一次
     1. 搜索目录：文件只要存在于sys.path输出的目录下即可，结果第一个表示当前脚本目录
   - 组成
     1. `__name__`：当值为'__main__'时，模块为自身运行，否则被引入执行
   - 使用
     1. 使用
        - `module.func()`：直接执行模块中方法
        - `mod = module.func`：将模块的函数写入变量，再执行
        - `dir(module)`：显示模块中定义的所有名称
     1. 导入
        - `import modules.child`：导入模块，使用时需要带上全路径
        - `from modules import child`：导入子模块
        - `from module import firstfunc, secondfunc`：导入模块的某个函数，`from module import *`：导入模块的全部函数
   - 内置模块
     1. sys：
        - `sys.argv` 输出命令行参数
        - `sys.path` python安装路径
        - `sys.stderr.write('Warning')` 错误输出重定向
     1. itertools：操作迭代对象
     1. collections：集合类
     1. struct：处理字节
     1. hashlib：摘要算法，如md5
     1. hmac：哈希算法
     1. urllib
     1. HTMLParser
     1. XML
     1. contextlib：读写文件
     1. os：目录接口
     1. glob：从目录通配符搜索中生成文件列表，如`glob.glob('*.py')`
     1. base64
     1. datetime：日期和时间，如`date.today()`
     1. pprint
     1. pickle：序列化/反序列化对象
     1. re：正则匹配
     1. math
     1. urllib/smtplib：网络和邮件
     1. zlib：打包和压缩，zlib.compress/decompress/crc32(s)
     1. timeit：性能度量工具，如`Timer('a,b = b,a', 'a=1; b=2').timeit()`
     1. doctest/unittest、
   - 第三方模块
     1. Pillow：图像处理
     1. requests：处理url
     1. chardet：编码
     1. psutil：系统监控
1. 错误和异常
   - 异常处理：try/except
    ```python
    try:
    except OSError:
    except ValueError as err:                       # 单个
    except (RuntimeError, TypeError, NameError):    # 多个
    except:                                         # 最后一个作为通配使用
    else:                                           # 放在except之后，没有异常会执行这里
    finally:                                        # 无论如何都会执行。如果有异常，没有except接住的话，会再抛一次
    ```
   - 抛出异常：raise
    ```python
    raise                                           # 抛出一个异常
    raise NameError('HiThere')                      # 抛出指定异常，参数必须为异常的实例或者异常的类(即Exception的子类)
    ```
   - 自定义异常
    ```python
    class Error(Exception):                         # 定义一个基础的类，通过继承扩展异常类型
    class InputError(Error):
    class TransitionError(Error):
    ```
1. 调试，单元测试，文档测试
### 面向对象
1. 面向对象
   - 理解：尽量不增加新的语法和语义
   - 特点
     1. 私有属性/方法：以两个下划线开头，不能在类外部访问和直接访问
     1. 方法访问：直接向上的、从左至右的查找
     1. 方法重写：子类直接覆盖方法名
   - 类的专有方法
     1. `__init__`
     1. `__del__`：析构
     1. `__repr__`：打印，转换
     1. `__call__`：函数调用
     1. `__setitem/getitem/len/cmp/add/sub/mul/div/mod/pow__`：各种运算类的时候用
   - 数据类型判断
     1. type：不认为子类是一种父类类型
     1. isinstance：认为子类是一种父类类型
1. 类
   - __solts__
   - @property
   - 多重继承
   - 定制类
   - 枚举类
   - 元类
### 应用
1. 文件
   - 方式：文件指针默认在文件头部
     1. r：只读
     1. w：只用于写入
     1. +：读写
     1. a：用于追加，文件指针在结尾
     1. b：二进制格式
   - 方法：对象为file.xxx
     1. read(size)：限定大小，无则全部
     1. readline()：读取一行，换行符为\n
     1. next()：返回文件下一行
     1. write()：返回写入的字符数
     1. tell()：指针位置
     1. seek(offset, from)：参一字符数，参二0开头，1当前，2结尾
     1. close()：关闭文件释放资源
     1. flush()：刷新缓冲，缓冲区数据立即写入
     1. fileno()：返回文件描述符，用在os模块等底层操作上
1. 目录
   - `os.system('')`：执行系统命令
   - `os.chroot/getcwd()`：改变当前进程根目录
   - `os.chdir/mkdir/rmdir()`
   - `os.access/chown/chmod(path, mode)`：检测权限，mode包括os.F_OK存在/R_OK读/W_OK写/X_OK执行
   - `os.open/remove(path)`：打开文件
   - `os.mkfifo(path[, mode])`：创建命名管道，默认0666
   - `os.symlink(src, dst)`：软链接
   - `os.link(src, dst)`：硬链接
1. 时间和日期
   - time
     1. `time.time()`：时间戳
     1. `time.asctime(time.localtime(time.time()))`：格式化时间，Thu Apr  7 10:29:13 2016
     1. `time.strftime("%Y-%m-%d %H:%M:%S", time.localtime())`：格式化时间，2016-03-20 11:45:39
   - calendar
     1. `calendar.month(2016, 1)`：输出日历
1. 正则
   - 理解：自1.5增加re模块，提供Perl风格的正则模式
   - 函数
     1. match：只从起始位置匹配，否则返回None，成功返回对象
     1. search：查找，用法同match
     1. sub：替换
   - 修饰符
     1. re.I 大小写
     1. re.L 本地化识别匹配
     1. re.M 多行
     1. re.S 匹配所有字符
     1. re.U 根据Unicode字符集解析字符，影响\w/W/b/B
     1. re.X 给允更灵活的方式
### 高级
1. 函数式编程
   - 返回函数
   - 匿名函数
   - 装饰器
   - 偏函数
1. 多进程：分布式进程
1. 多线程
   - 多线程的特点
     1. 并行提高处理速度，充分利用多核优势
     1. 可将耗时长的任务后台处理
     1. 显示进度条
     1. 每个线程都有一组cpu寄存器，如指令指针、堆栈指针
     1. 线程可以被抢占(中断)、搁置(睡眠)
     1. 分为：内核线程、用户线程
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
1. 异步io
   - 协程
   - asyncio
   - async/await
   - aiohttp
1. 网络编程
   - 分类
     1. 低级别：提供了标准的BSD Sockets API，可以访问底层操作系统Socket接口的全部方法
     1. SocketServer：简化网络服务开发
     1. tcp/udp
   - 定义
    ```python
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
### 运维
1. 运行模式
   - 交互式：python3、IDLE
     1. help()：打印文档，:q退出说明文档
     1. 等待用户输入：`input("按下 enter 键后退出")`
     1. 构造函数：dict([('a', 1), ('b', 2), ('c', 3)])
   - 脚本：指定shell脚本解释器，作为脚本文件执行
     1. 添加：`#!/usr/bin/env python3`
     1. 执行：`./hello.py`
1. 交互
   - 输入输出
     1. 标准输入：input()，默认标准输入为键盘
     1. 标准输出：`sys.stdout`
   - 打印：print(x)
     1. 连续打印：`print('hello', 'world')`
     1. 打印变量：`print('hello,', name)`
     1. print("OS error: {0}".format(err))
     1. 不换行和连接符：`print(x, end="", sep='&')`
   - 序列化/反序列化：pickle，用于对象信息的保存
1. 依赖管理工具：pip，pip3
   - 安装包
     1. pip install package              # 最新版本
     1. pip install package==1.0.4       # 指定版本
     1. pip install 'package>=1.0.4'     # 最小版本
   - 更新包：pip install --upgrade package
   - 可更新的包：pip list -o package
   - 其他操作：pip list/show/search/uninstall/ package
   - 更新自己：pip3 install --upgrade pip
1. python解释器
   - 理解：开源，有多种
   - 分类
     1. CPython：官方，c语言开发，提示符>>>
     1. IPython：交互方式增强，提示符:
     1. PyPy：执行速度快，使用JIT技术进行动态编译，和其他解释器执行可能有不同地方
     1. Jython：java平台上的，可将python编译为java字节码
     1. IronPython：.net平台上的
   - 虚拟环境：virtualenv
## WIKI
1. 保留字
   - class，from，import，return，
   - if，elif，else，for，while，continue，break，finally，pass，
   - None，False，True
   - del，in，is，and，or，not，global，nonlocal，def，lambda，yield，
   - try，except，raise，
   - as，assert，with
1. 历史
   - python3不向下兼容，性能有提升，语法差别不大
   - Life is short, you need Python
   - 创始人吉多•范罗苏姆的心思缜密与灵活处事为Python最初的发展营造了良好的环境，包括几次权属的转移、起草新的许可证、机智地与自由软件阵营斡旋，最后安全融入开源的大潮。这一切为Python此后十多年里逐渐成长为主流编程语言赢得了契机
   - Python编程思想包含强烈的黑箱思维，这意味着开发者将愈加重视模块化和流水线式的编程工作
   - python：蟒蛇
1. PyPI：Python Package Index，官方的第三方仓库
1. mysql，SQL占位符是%s
   - pip安装mysql-connector-python驱动：`import mysql.connector`
1. mail
   - smtp
   - pop3
