### python
1. 认识：是一种解释型(解释执行)、动态数据类型、面向对象的高级编程语言。开源，版权与许可证在python软件基金会
   - 抽象层次高，表达能力强
   - 易于理解、学习，简单优雅、易于开发
   - 执行效率换来了开发效率
   - 内置包多：官方提供完善广泛的标准库，众多第三方库远超其他语言，如网络编程、输入输出、文件系统、图形处理、数据库、文本处理等
   - 胶水语言：具有可扩展性，丰富api和工具，轻松使用其他语言的模块
1. 用途
   - web
   - 脚本
   - 爬虫
   - 数据分析：商业智能
1. 示例
   - python3 hello.py
    ```py
    #!/usr/bin/python3
    print("Hello, World!");
    ```
### 语法
1. 基础
   - 编码：默认utf8，可以指定不同编码：`# -*- coding: cp-1252 -*-`
    ```py
    # 设置编码
    reload(sys)
    sys.setdefaultencoding("utf-8")
    ```
   - 行与缩进：用缩进代表代码块，无需大括号包裹。同一代码块的缩进空格数必须相等。使用反斜杠实现多行语句，使用分号表示多条语句在一行
   - 标识符：不能以数字开头，大小写敏感
   - 注释
     1. 单行 #
     1. 多行 '''或"""
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
        - 字符串不可改变，向一个索引位置赋值，比如`word[0] = 'm'`会导致错误
        - 字符串截取：从左往右以0开始，从右往左以-1开始
        - 连接符+，转义符\，复制符*
     1. 三引号：从引号和特殊字符串的泥潭中走出来
        ```py
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
1. 类型转换
   - int/long/float/complex()
   - chr(整数转字符)/unichr(整数转unicode)/ord(字符转整数)/hex(整数转十六进制字符串)/oct(整数转八进制字符串)
   - str/repr(表达式字符串)/eval(执行字符串中的python表达式)()
   - list/tuple/set/dict/frozenset(不可变集合)()
1. 运算符
   - 算术运算符：+-*/%，a**b次幂，//取整除
   - 比较运算符：== != > < >= <=
   - 赋值运算符：= += -= *= /= %= **= //=
   - 位运算符：& | ^ ~ << >>
   - 逻辑运算符：and or not，如`if(a and b)`，and从左到右计算表达式，若所有值均为真，返回最后一个值，若存在假，返回第一个假值；or从左到右返回第一个为真的值
   - 成员运算符：in/not in，是否存在于序列中，如`if(a in list)`
   - 身份运算符：is/is not，两个标识符是否引用自一个对象，如`if(a is b)`，a是20b是30都不同。==比较的是值，is比较引用对象
1. 数据结构：相关操作、推导式
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
1. 函数
   - 定义：def
    ```py
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
   - 闭包：原生支持闭包，使用__closure__查看闭包内容
    ```py
    def adder():
        sum = 0

        def f(value):
            nonlocal sum
            sum += value
            return sum
        return f
    ```
   - 匿名函数
     1. 定义：使用lambda来创建
     1. 特点
        - 有自己的命名空间，不能访问自己参数之外或全局命名空间里的参数
        - 是一个表达式，只能写一行，不同于C的内联函数，后者的目的是调用小函数时不占用栈内存从而增加运行效率
     1. 实例
        ```py
        sum = lambda arg1, arg2: arg1 + arg2;   # 可以无限参数，像函数一样
        sum(1, 2)                               # 输出3
        ```
   - 函数分类
     1. 数学函数
     1. 随机数函数
          1. random()：0-1的随机数
          1. choice(seq)：随机挑选一个元素，如随机一个整数 `random.choice(range(10))`
          1. shuffle(list)：随机排序序列
          1. randrange([start,] stop [,step])：指定范围内按指定基数递增的集合中获取一个随机数
          1. uniform(x, y)：随机生成下一个实数
          1. seed([x])：改变随机数生成器的种子
        - 数学函数：round(奇进偶弃，懂？)/max/min/abs/exp/log/pow/sqrt...
        - 三角函数：sin/cos/tan...
        - 数学常量：pi圆周率、e自然常数
     1. id()：获取对象内存地址
     1. enumerate()
1. lambda
1. 流程控制
   - 判断
    ```py
    if 表达式1:
    elif 表达式2:
    else:
    ```
   - 循环：跳出循环，continue/break，但是不会执行else里的语句
    ```py
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
     1. 包：用.实现不同模块间的命名空间，如`import sound.effects.echo`
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
        - sha256：`hmac.new(secret, string, digestmod=hashlib.sha256).digest()`
     1. urllib
        - `urllib.quote`：encode
     1. HTMLParser
     1. XML
     1. json
        - `json.dumps()`：encode
     1. contextlib：读写文件
     1. os：目录接口
     1. glob：从目录通配符搜索中生成文件列表，如`glob.glob('*.py')`
     1. base64
        - `base64.b64encode`：encode
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
     1. requests：基于urllib的http库，更加方便
        - 发送
            ```py
            body = {
                "msgtype": "text",
            }
            headers = {'content-type': 'application/json', 'Accept-Charset': 'UTF-8'}
            r = requests.post(url, data=body, headers=headers)
            ```
        - 请求
          1. r.headers['content-type']
        - 响应
          1. r.encoding：编码
          1. r.status_code
          1. r.text：文本
          1. r.content：二进制
          1. r.json()
     1. chardet：编码
     1. psutil：系统监控
1. 错误和异常
   - 异常处理：try/except
    ```py
    try:
    except OSError:
    except ValueError as err:                       # 单个
    except (RuntimeError, TypeError, NameError):    # 多个
    except:                                         # 最后一个作为通配使用
    else:                                           # 放在except之后，没有异常会执行这里
    finally:                                        # 无论如何都会执行。如果有异常，没有except接住的话，会再抛一次
    ```
   - 抛出异常：raise
    ```py
    raise                                           # 抛出一个异常
    raise NameError('HiThere')                      # 抛出指定异常，参数必须为异常的实例或者异常的类(即Exception的子类)
    ```
   - 自定义异常
    ```py
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
   - 定义：`class Name():`
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
   - difflib：文本差异化比较的标准库
1. 目录
   - pathlib：跨平台的、面向对象的路径操作库
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
     1. `time.time()`：秒为单位的时间戳浮点数，毫秒为单位`str(round(time.time() * 1000))`
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
### 库
1. 数据
   - scapy：数据包构造工具
   - JmesPath/：json增强处理器
   - Chardet：字符集检测
   - Python-dateutil：时间日期处理
1. 文件
   - watchdog：管理文件系统事件的 API 和 shell 工具
   - path.py：对 os.path 进行封装的模块
   - Unipath：用面向对象的方式操作文件和目录
1. 文本
   - Levenshtein：快速计算编辑距离以及字符串的相似度
   - pypinyin/xpinyin：汉字拼音转换工具
   - prettytable：命令行下把数据用表格输出，美观
   - 
   - 文本格式
     1. PDFMiner/PyPDF2/ReportLab：pdf
     1. Mistune/Python-Markdown2/markdown
     1. PyYAML
     1. csvkit：csv
   - Jinja：基于python的模板引擎，功能类似于PHP的smarty
     1. 使用
        - 创建模板
        - 将变量添加到模板上下文中
        - 将模板渲染成 HTML
   - weasyprint/xhtml2pdf：开源的html转为pdf的工具，如用于报告、发票、门票、图书、信件等
     1. 实例
        ```py
        from weasyprint import HTML
        HTML(string=html_out).write_pdf(args.outfile.name, stylesheets=["style.css"])           // 使用css
        ```
1. 图片
   - imghdr：检测图片类型的标准库
   - Pillow：处理图，缩略图、文件格式转换、旋转、应用滤镜等
   - wand：MagickWand的 Python 绑定。MagickWand 是 ImageMagick 的 C API 
   - NetworkX：绘制网络图，图论与复杂网络建模工具
   - turtle：简单、易上手的绘图软件
1. 图像处理
   - nude.py：裸体检测
   - face_recognition：简单易用的 python 人脸识别库
   - imgSeek：一个使用视觉相似性搜索一组图片集合的项目
   - pyBarcode：不借助 PIL 库在 Python 程序中生成条形码
   - hmap：图像直方图映射
   - pygram：类似 Instagram 的图像滤镜
   - python-qrcode：一个纯 Python 实现的二维码生成器
   - Quads：基于四叉树的计算机艺术
   - scikit-image：一个用于（科学）图像处理的 Python 库
   - thumbor：一个小型图像服务，具有剪裁，尺寸重设和翻转功能
   - OCR
     1. pyocr：Tesseract 和 Cuneiform 的一个封装(wrapper)
     1. pytesseract：Google Tesseract OCR 的另一个封装(wrapper)
     1. python-tesseract：Google Tesseract OCR 的一个包装类。
1. 多媒体
   - PyAudio/wave
   - Pygame：是SDL多媒体库的Python装饰器
   - 音频
     1. audiolazy：Python 的数字信号处理包
     1. audioread：交叉库 (GStreamer + Core Audio + MAD + FFmpeg) 音频解码
     1. beets：一个音乐库管理工具及 MusicBrainz 标签添加工具
     1. dejavu：音频指纹提取和识别
     1. django-elastic-transcoder：Django + Amazon Elastic Transcoder
     1. eyeD3：一个用来操作音频文件的工具，具体来讲就是包含 ID3 元信息的 MP3 文件
     1. id3reader：一个用来读取 MP3 元数据的 Python 模块
     1. m3u8：一个用来解析 m3u8 文件的模块
     1. mutagen：一个用来处理音频元数据的 Python 模块
     1. pydub：通过简单、简洁的高层接口来操作音频文件
     1. pyechonest：Echo Nest API 的 Python 客户端
     1. talkbox：一个用来处理演讲/信号的 Python 库
     1. TimeSide：开源 web 音频处理框架
     1. tinytag：一个用来读取 MP3, OGG, FLAC 以及 Wave 文件音乐元数据的库
     1. mingus：一个高级音乐理论和曲谱包，支持 MIDI 文件和回放功能
   - 视频
     1. moviepy
     1. scikit-video
1. 可视化
   - Dash：数据可视化，Flask，Plotly.js，React.js的混合体
1. 数据提取
   - BeautifulSoup：从html和xml中提取数据
1. 分析与计算
   - NumPy
     1. 认识：Numerical python，开源的c语言写的python数据分析和科学计算库，可以替代matlab
        - c写的，速度快
        - 本身的数据结构比python的访问效率更高
        - 支持大量高维度数据和矩阵运算
        - 提供大量的数学函数库
     1. 安装
        - anaconda
   - SciPy：科学计算
1. 绘图库
   - pandas：数据分析
     1. PandasGUI：提供数据预览、筛选、统计、多种图表展示以及数据转换
     1. Pandas Profiling：提供了整体数据概况、每列的详情、列之间的关图、列之间的相关系数
     1. Sweetviz：Pandas Profiling类似，提供每列详细的统计指标、取值分布、缺失值统计以及列之间的相关系数
     1. dtale：提供丰富图表展示数据，还提供很多交互式的接口，对数据进行操作、转换
   - matplotlib：绘图库，给命令，生成图
   - Seaborn
   - Bokeh
1. 安全
   - pyotp：用于二次登录验证(密码+验证码)的验证码生成，如`pyotp.TOTP('YOUR SECRET').now()`
1. 其他
   - Colorama：允许在终端使用颜色
   - 分发
     1. py2app：将python脚本变为独立mac包
     1. py2exe：将python脚本变为独立windows包
### 运维
1. 安装
   - brew：已删除2.7
   - pyenv：python版本管理，切换后，pip和包仓库会自动切换
     1. `pyenv install --list`：查看所有可安装的版本
     1. `pyenv uninstall/install 3.6.5`：安装
     1. `pyenv global 3.6.5 2.7.14 --unset`：指定全局版本顺序/取消，通过~/.pyenv指定，需要先设置pyenv的path
     1. `pyenv local`：指定当前目录的，通过设置.pyenv_version文件指定
1. 运行
   - 运行模式
     1. 交互式：python3、IDLE
        - help()：打印文档，:q退出说明文档
        - 等待用户输入：`input("按下 enter 键后退出")`
        - 构造函数：dict([('a', 1), ('b', 2), ('c', 3)])
     1. 脚本：指定shell脚本解释器，作为脚本文件执行
        - 添加：`#!/usr/bin/env python3`
        - 执行：`./hello.py`
1. 依赖管理
   - 认识
     1. pip/pip3
     1. conda
     1. virtualenv
     1. pipenv
   - anaconda
     1. 认识：开源的python发行版，依赖和环境管理工具，和venv一样，适用于多种语言Python, R, Scala, Java, Javascript, C/C++
        - 精简版：miniconda
     1. 环境管理
        - `conda env list`
        - `conda activate/deactivate [环境名称]`：进入/退出环境
        - `conda create -n [环境名称] [安装库包列表] python=x.x`
        - `conda remove -n [环境名称] --all`
     1. 包管理
        - `conda list`
        - `conda search/install/update/remove [安装包]`
        - requirements.txt
          1. `conda install --yes --file requirements.txt`：安装
          1. `conda list -e > requirements.txt`：导出
        - `conda install --channel $URL $PACKAGE_NAME`：从指定通道安装包
        - `conda clean -t`：清除被缓存包
        - `conda clean -y -a`：清除索引缓存、未使用缓存包
     1. channel：镜像
        - `conda config --get channels`：查看所有源
        - `conda config --remove-key channels`：恢复默认源
   - pip
     1. 认识：来源pypi，Python Package Index，官方的第三方仓库
     1. 安装
        - 最新版本：`pip install/uninstall package`
        - 指定版本：`pip install package ==/>= 1.0.4`
     1. 查看：`pip list/show/search package`
     1. 版本指定：`requirements.txt`，只适用于单虚拟环境
        - 安装：`pip install -r requirements.txt`
        - 生成txt：`pip freeze > requirements.txt`
     1. 自身管理
        - 安装
          1. 手动方式
            ```
            curl https://bootstrap.pypa.io/get-pip.py -o get-pip.py   # 下载安装脚本
            python get-pip.py                                         # 运行安装脚本，用哪个版本python安装就关联到哪个版本
            ```
          1. yum方式：`yum install python-pip`
        - 更新：`pip install --upgrade pip`
   - venv：virtual environment，虚拟且独立的python运行环境，用于隔离不同项目的依赖包。项目下有venv文件夹
     1. 安装：python3 install virtualenv
     1. 在当前目录创建虚拟环境：python3 -m venv .
     1. 在当前目录创建独立的python环境：virtualenv --no-site-packages venv
     1. 激活虚拟环境：source venv/bin/activate
     1. 停用：deactivate
     1. 删除：rm -rf venv
1. 包
   - setuptools
     1. 认识：python自带的构建包的工具，可以直接安装，也可以构建成wheel(.whl)，可供其他人pip install和import
     1. 特性文件
        - setup.py
        - MANIFEST.in：记录路径，用于引入静态文件，如css、图片
        - setup.cfg：而不是setup.py的理由是，前者是声明式的配置文件，后者是实际的python代码，可能不安全
     1. 打包
        - 创建setup.py文件用于打包
            ```py
            import setuptools

            setuptools.setup(
                name='hellopkg',        # 包的名字，可随意取
                py_modules=['hello']    # 对应hello.py，也是安装了包之后实际import的名字
            )
            ```
        - `pip install .`：进行注册，接下来任何地方可以import了
1. 交互
   - 输入输出
     1. 标准输入：input()，默认标准输入为键盘
     1. 标准输出：`sys.stdout`
   - 打印：`print(x)`
     1. 连续打印：`print('hello', 'world')`
     1. 打印变量：`print('hello,', name)`
     1. 不换行和连接符：`print(x, end="", sep='&')`
     1. `print("OS error: {0}".format(err))`
   - 序列化/反序列化：pickle，用于对象信息的保存
### wiki
1. 保留字
   - class，from，import，return，
   - if，elif，else，for，while，continue，break，finally，pass，
   - None，False，True
   - del，in，is，and，or，not，global，nonlocal，def，lambda，yield，
   - try，except，raise，
   - as，assert，with
1. 历史
   - 1989年发明
   - python3不向下兼容，性能有提升，语法差别不大
   - Life is short, you need Python
   - 创始人吉多•范罗苏姆的心思缜密与灵活处事为Python最初的发展营造了良好的环境，包括几次权属的转移、起草新的许可证、机智地与自由软件阵营斡旋，最后安全融入开源的大潮。这一切为Python此后十多年里逐渐成长为主流编程语言赢得了契机
   - Python编程思想包含强烈的黑箱思维，这意味着开发者将愈加重视模块化和流水线式的编程工作
   - python：蟒蛇
1. mysql，SQL占位符是%s
   - pip安装mysql-connector-python驱动：`import mysql.connector`
1. mail
   - smtp
   - pop3
1. 2和3的区别
   - print由语句变为函数
   - 编码默认由asscii变为utf-8，阻止了编码错误
   - 字符串：阻止了编码错误
     1. 2：字符串有两个类型unicode/str，表示文本字符串/字节序列
     1. 3：str表示字符串，byte表示字节序列
   - True和False由全局变量变为关键字，不允许再被重新赋值，因为违背Explicit is better than implicit
   - 迭代器：返回列表对象的内置函数和方法改为迭代器，迭代器的惰性加载特性使得操作大数据更有效率
   - 新增nonlocal，声明非局部变量
