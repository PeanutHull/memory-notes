####知识
1. ContentType定义网络类型和网页编码，决定以什么形式读取这个文件。未指定默认为text/html。
1. form的enctype属性为编码方式，常用有
   - application/x-www-form-urlencoded：窗体数据被编码为名称/值对，也是标准的编码格式
   - multipart/form-data:窗体数据被编码为一条消息，一个控件对应一个部分，同时比urlencoded传输更大数据
   - text/plain:窗体数据以纯文本形式进行编码，不含任何控件或格式字符
   - 当action为get：就用x-www-form-urlencoded方式转为字符串并加到url后面，
   - 当action为post：浏览器把form数据封装到http body中发送
   - 当有file时，就要用到multipart/form-data了
1. URI：通用资源标志符，唯一标识一个资源，一个字符串格式规范，并没有指定用途
URL和URN都是一种URI,
1. URL:统一资源定位符，即网址。URN:统一资源命名，用名字标识资源。文件 `url：file:// ftp.yesky.com/soft/file/robots.txt`
1. RTT:Round Trip Time,往返时间,服务器和客户端传送信息的传输时间
####理解
1. 网络
   - ISO/OSI模型：物理层、数据链路层、网络层、传输层、会话层、表示层、应用层
      ```
      应用层： 用户接口
      表示层： 数据的表现形式(0101互转mp3)、特定功能实现(加密)
      会话层： 对应会话的管理、同步。决定把文件是否进行互联网络的传输
      传输层是段，Tcp协议  :可靠与否的传输、确定端口、传输前的错误检测、流控、传输速度控制
      网络层是报文，ip协议 :利用逻辑地址(ip)找地址、选路
      数据链路层是帧:用MAC访问媒介、错误检验与修正(发现数据错误是可以要求重新传递包的)、负责信息的局域网里的准确传递
      物理层是比特:比特流的传输、电气特性、物理接口(网卡)
      ```
   - TCP/IP模型：网络接口层、网际互联层、传输、应用
      ```
      应用层：对应应用、表示、会话层。包括FTP、Telnet、DNS、SMIP
      传输层：对应传输层。包含TCP、UDP
      网际互联层：对应传输层。包括3个主要协议：网际协议(ip)、互联网组管理协议(IGMP)、互联网控制报文协议(ICMP)
      网络接口层：对应数据链路层、物理层。包含arp协议：————地址解析协议————把ip转为MAC地址。路由器会记录MAX和ip地址的对应。局域网依靠MAC传递数据
      ```
   - XXXX
     1. TCP：面向连接，可靠性高
     1. UDP：无连接，不可靠，传输数据不先建立连接，不能确定是否送达
     1. TCP/IP：在传输层，解决如何传输数据
     1. HTTP：在应用层，定义如何包装数据，工作在TCP/IP之上。应用层协议有HTTP、FTP、TELNET、SSH、SMTP、POP3，也可自定义。`WEB使用HTTP协议作应用层协议，以封装HTTP文本信息，然后使用TCP/IP做传输层协议将它发到网络上`
        - 概念：超文本传输协议
        - HTTP响应组成：
          1. 数字和文字的状态码
          1. 响应头：服务器类型(UA)、日期时间、内容类型、长度
          1. 响应正文
     1. Socket：对TCP/IP协议进行了封装，不是协议是一个调用接口，兼容多网络协议，负责多程序通信
   - 数据封装过程
      ```
      应用数据                                   字节流
      应用层                                 FTP头+数据
      传输层                           TCP头+FTP头+数据
      网络层                      IP头+TCP头+FTP头+数据
      数据链路层           以太帧头+IP头+TCP头+FTP头+数据
      ```
   - 特点：上三层针对用户，下四层针对传输；越到底层，越接近硬件；OSI是通用的，TCP/IP是先有协议后建立模型，不适用非TCP/IP模型
   - 版本：99年1.1版本,15年HTTP/2发布
   - DNS：本地域名服务器缓冲、最后是全球13台根DNS服务器
   - 一般端口号
     1. DNS：53
     1. FTP：20、21
     1. SSH：22
     1. Telnet：23
     1. SMTP：25
     1. POP3：110
   - 网关：交换机是局域网在MAC上进行通信、要是跨ip就要用路由器了，网关就是负责通信的主要接收、分发
   - 优化传输
     1. 减少http请求数：每个新的请求都需要3次握手，很费时间。服务器页面生成————传输延迟————浏览器渲染，非异步阻塞型。
     1. 减少每个文件的大小
     1. 静态资源放到不同的子域名下：浏览器对相同的域名会限制并发连接数，不同子域名则不会，所以静态资源不需要cookie等，直接放到其他子域名下，指向另一个ip，减少服务器请求
1. post知识
   - post发送类型，只有下面这两种才会放入$_POST变量中
    1. application/x-www-form-urlencoded(默认值)，post不写类型默认就这个，意味内容会被url编码
    1. multipart/form-data，以二进制格式传输数据
   - 发送一个post数据，以下为默认数据
      ```HTTP
      POST / HTTP/1.1
      Content-Type:application/x-www-form-urlencoded
      Accept-Encoding: gzip, deflate
      Host: w.sohu.com
      Content-Length: 21
      Connection: Keep-Alive
      Cache-Control: no-cache
      ```
    - 特点：普通的post请求，头信息里注明内容长度，头信息每行一条，空行之后便是body，即内容entity
1. Http
   - 请求头信息
     1. `Accept` // 指定客户端可接受的MIME类型，如 image/png
     1. `Accept-Charset` //字符集，如ISO-8859-1
     1. `Accept-Encoding` // 编码类型，如gzip
     1. `Accept-Language` // 首选语言，如en、en-us、ru
     1. `Host` // 主机和端口
     1. `Content-Length` // POST数据的大小，字节为单位
     1. `Cookie` // 携带的服务器给的cookie
     1. `Authorization` // 鉴权信息     
     1. `User-Agent` // 客户端标识
     1. `Connection` // 是否处理持久Http连接，Keep-Alive为持久连接
     1. `If-Modified-Since` // 数据缓冲，否则服务器返回304
     1. `If-Unmodified-Since` // 数据缓冲
     1. `Referer` // 上一个页面的url
   - 相应头信息
     1. `Allow` // 服务器支持的方法
     1. `Cache-Control` // 表示此文档是否可安全缓冲，有public、private、no-cache，private表示只能存在私有缓冲中
     1. `Connection` // 是否持久连接：close、keep-alive
     1. `Content-Disposition` // 指定保存的文件名
     1. `Content-Encoding` // 编码方式
     1. `Content-Language` //
     1. `Content-Length` // keep-alive时不需要
     1. `Content-Type` // MIME类型
     1. `Expires` // 过期时间，即缓冲删除时间
     1. `Last-Modified` // 文件最后修改时间
     1. `Location、Refresh、Retry-After`
     1. `Set-Cookie`
1. tcp：三次握手建立连接，中间保持连接会发送心跳包两端回应，四次握手断开连接
1. Socket：Socket是应用层与各种网络协议通信的中间软件抽象层，是一组接口/API/封装。用socket组织数据，以符合指定的协议
1. WebSocket
   - 特点
     1. 鉴于传输中多次路由转发等的不稳定，ws会发送ping/pong心跳包检测连接活性
   - 步骤：先期使用http建立一次连接，之后转换为websocket
        ```
        // 两个http头表示发起websocket请求
        Upgrade: websocket
        Connection: Upgrade
        ```
   - 头信息
     1. Sec-WebSocket-Key 校验key，校验原理是什么？？？
     1. Sec-WebSocket-Protocol 需要的服务名称
     1. Sec-WebSocket-Version 版本号
1. 断点续传：利用http请求头的Range确定传输的起点，响应头Content-Range返回大小。php使用fread/fseek确定读取文件的范围和小大从而实现功能
1. tcp/ip
   - 概述：信息流的分段传输，七层协议，分开自己的任务
   - 最下边两个负责信息传输到目的的，即路由控制，路由协议，路由算法距离向量算法。链路状态算法。比较路由表决定去路，再上保证收的到，再上就是具体的应用，缓存路由，下一跳只记住下一个路由地址，缓冲mac地址，arp广播找mac地址，rarp反过来找，dns找ip