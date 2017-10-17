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
     1. 单引号和双引号完全相同，两者都可表示
     1. 字符串不可改变，向一个索引位置赋值，比如word[0] = 'm'会导致错误
     1. 字符串截取：左往右以0开始，从右往左以-1开始
     1. 自然字符串：加前缀r/R，表示全部输出。如 r"hello\n"，则\n会显示
     1. unicode字符串：加前缀u/U
     1. 级联字符串：如"this " "is " "string"会被自动转换为this is string   
     1. 连接符+，转义符\，复制符*
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
     1. 理解：使用最频繁，可以嵌套列表，也可以被索引和切片、用+拼接、元素被改变。
     1. 实例
        ```python
        # 定义
        list = ['abcd', 786, 70.2]
        # 使用
        list[1:3]        # 第二个到第三个元素，第二位置进一
        # 改变
        list[0] = 9
        ```
     1. 方法
        - append()
        - pop()
   - Tuple：元组，元素不能被改变的列表，可以嵌套包含列表等数据类型。只有一个元素需要后边加逗号。如`tuple = ('abcd', 786, 70.2)`。string、list和tuple都属于sequence序列
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
     1. 理解：列表是有序的对象结合，字典是无序的键值对集合。字典当中的元素是通过键来存取的，而不是通过偏移存取。同一个字典键必须唯一，并且是不可变类型
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
   - 理解：不需要声明，使用前必须赋值，赋值之后变量才会被创建。变量的类型由赋予它的值来决定，变量以内容为基准，会存在多个变量指向一个值，即一个内存地址
   - del：删除对象引用，如`del a, b`
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
   - 举例
    ```python
    counter = 1000         # 整型变量
    a = b = c = 1          # 多个变量赋值，三个变量被分配到相同的内存空间上
    a, b, c = 1, 2, "abc"  # 多个变量赋多个值
    name    = "runoob"     # 字符串
    print(counter)
    ```
1. 导入
   - 整个模块导入：`import somemodule`
   - 模块的某个函数：`from somemodule import firstfunc, secondfunc`
   - 模块的全部函数：`from somemodule import *`
1. 函数
   - 随机数函数
     1. random()：0-1的随机数
     1. choice(seq)：随机挑选一个元素，如随机一个整数 `random.choice(range(10))`
     1. shuffle(list)：随机排序序列
     1. randrange([start,] stop [,step])：指定范围内按指定基数递增的集合中获取一个随机数
     1. uniform(x, y)：随机生成下一个实数
     1. seed([x])：改变随机数生成器的种子
   - 数学函数：round(奇进偶弃，懂？)/max/min/abs/exp/log/pow/sqrt...
   - 三角函数：sin/cos/tan...
   - 数学常量：pi圆周率、e自然常数
   - id()：获取对象内存地址
1. 命令行：python3 -h
1. 交互式编辑模式：输入python3进入
   - help(max)：打印文档，:q退出说明文档
   - 等待用户输入：`input("按下 enter 键后退出")`
   - 构造函数：dict([('a', 1), ('b', 2), ('c', 3)])
1. 脚本式模式：指定Shell脚本的解释器，作为脚本执行
    - 添加：#! /usr/bin/env python3
    - 执行命令：./hello.py
1. 输出：`print(x)`，不换行`print(x, end="")`
1. 空行：函数之间或类的方法之间用空行分隔，表示一段新的代码的开始。类和函数入口之间也用一行空行分隔，以突出函数入口的开始。空行不是语法，只是为了好看，缩进是，空行也是程序代码的一部分
### WIKI
1. 保留字
   - class，from，import，return，
   - if，elif，else，for，continue，break，finally，while，
   - None，False，True
   - del，in，is，and，or，not，
   - try
   - as，assert，def，except，global，lambda，nonlocal，pass，raise，with，yield