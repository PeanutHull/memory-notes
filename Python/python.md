### 认识
1. 理解：是一种解释性、动态数据类型、面向对象的高级编程语言，1989年发明。Python3不向下兼容
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
### 语法
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
     1.  运算符
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
     1. 格式化：支持格式化输出字符串，就是将值插入到有格式符%s的字符串中，和c的sprintf一样的语法，如`print("我叫 %s 今年 %d 岁!" % ('小明', 10)`
        - 格式化符号：%c符合和ACS||，%s字符串，%d整数，%u无符号整数，%o八进制，%x十六进制，%X十六进制(大写)...
        - 辅助指令：*定义宽度或小数点精度，-左对齐，(var)映射变量...
     1. 函数：len(string)、lower()、count(str, beg= 0,end=len(string))、encode/decode(encoding='UTF-8',errors='strict')、
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
        # 迭代
        for x in [1, 2, 3]:
            print(x, end=" ")
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
   - Tuple：元组，元素不能被改变的列表，用括号表示，可以嵌套包含列表等数据类型。只有一个元素需要后边加逗号。如`tuple = ('abcd', 786, 70.2)`。string、list和tuple都属于sequence序列
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
        
        # set可以进行集合运算
        a = set('abracadabra')
        b = set('alacazam')
        
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
        tinydict = {'name': 'runoob','code':1, 'site': 'www.runoob.com'}
        # 输出
        dict['one']
        ```
   - 类型转换
     1. int/long/float/complex()
     1. str/repr(表达式字符串)/eval(执行字符串中的python表达式)()
     1. list/tuple/set/dict/frozenset(不可变集合)()
     1. chr(整数转字符)/unichr(整数转unicode)/ord(字符转整数)/hex(整数转十六进制字符串)/oct(整数转八进制字符串)
1. 变量
   - 理解：不需要声明，使用前必须赋值，赋值之后变量才会被创建。变量的类型由赋予它的值来决定，以值为基准，一个值一个内存地址，多个变量可以指向一个内存地址，变量没有类型，仅仅是一个对象的引用
   - 操作
     1. del：删除对象引用，如`del a, b`
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
1. 导入
   - 整个模块导入：`import somemodule`
   - 模块的某个函数：`from somemodule import firstfunc, secondfunc`
   - 模块的全部函数：`from somemodule import *`
1. 命令行：python3 -h
1. 交互式编辑模式：输入python3进入
   - help(max)：打印文档，:q退出说明文档
   - 等待用户输入：`input("按下 enter 键后退出")`
   - 构造函数：dict([('a', 1), ('b', 2), ('c', 3)])
1. 脚本式模式：指定Shell脚本的解释器，作为脚本执行
    - 添加：#! /usr/bin/env python3
    - 执行命令：./hello.py
1. 输出：`print(x)`，不换行连接符`print(x, end="", sep='&')`
### WIKI
1. 保留字
   - class，from，import，return，
   - if，elif，else，for，while，continue，break，finally，pass，
   - None，False，True
   - del，in，is，and，or，not，def，lambda，yield，
   - try，except，
   - as，assert，global，nonlocal，raise，with，