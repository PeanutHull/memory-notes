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
### 应用
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