###网络
1. 理解：协议在计算机通信中的重要性，分层负责、对上封装/抽象，
1. 网络
   - ISO/OSI模型：为统一不同计算机厂商的通信，国际标准化组织(ISO)制定了通信系统的标准，即开放式通信系统互联参考模型(OSI)。这个模型只是粗略的界定，对协议和接口没有详细定义
      ```
      应用层： 应用协议
      表示层： 数据的表现形式、特定功能实现，固有数据格式和网络标准格式的转换
      会话层： 通信的管理、同步，决定连接/断开的时间和时机
      传输层：段，负责数据的可靠传输，可靠与否的传输、确定端口、传输前的错误检测、流控、速度控制，有Tcp协议
      网络层：报文，地址管理和路由选择，利用逻辑地址(ip)寻址/选路，有Ip协议
      数据链路层：帧，用MAC定位媒介、错误检验与修正(发现数据错误是可以要求重新传递包的)、负责信息的局域网里的准确传递，帧和比特流的转换
      物理层：比特流的传输、电气特性、物理接口(网卡)
      ```
   - TCP/IP模型：OSI中的协议没有没有普及，但是其模型常被使用，但非国公共机构指定的标准(IETF)，由大学、计算机行业为中心力量推动的TCP/IP成为了业界标准，成为广泛使用的通信协议。前辈为全球互联网鼻祖(ARPANET，为可靠军用通信诞生)。由于其开放性和注重实用性，迅速流行和发展，笑谈先写程序，后定标准，TCP/IP广义上指所有目前用到的协议
      ```
      应用层：对应应用、表示、会话层，包括FTP、Telnet、DNS、SMIP
      传输层：对应传输层，包含TCP、UDP
      网际互联层：对应传输层，包括3个主要协议：网际协议(ip)、互联网组管理协议(IGMP)、互联网控制报文协议(ICMP)
      网络接口层：对应数据链路层、物理层，包含地址解析协议(arp)
      ```
   - 特点
     1. 上三层针对用户，下四层针对传输
     1. 越到底层，越接近硬件
     1. OSI是通用的，TCP/IP是先有协议后建立模型，不适用非TCP/IP模型
   - 数据封装过程
      ```
      应用数据                                   字节流
      应用层                                 FTP头+数据
      传输层                           TCP头+FTP头+数据
      网络层                      IP头+TCP头+FTP头+数据
      数据链路层           以太帧头+IP头+TCP头+FTP头+数据
      ```
1. 网络组成
   - 应用层
     1. HTTP、FTP、TELNET、SSH、P2P、SMTP、POP3、MIME、LDAP，也可自定义
   - 表示层
     1. DNS：域名解析服务，本地域名服务器缓冲、一级级往上查询，最后是全球13台根DNS服务器
   - 会话层
   - 传输层
     1. TCP：面向连接，可靠性高，可丢包重发，7次握手
     1. UDP：无连接，不可靠，传输数据不先建立连接，不能确定是否送达
     1. SCTP/DCCP
   - 网络层
     1. IP
        - 特点：面向无连接，为了简化和提速，可靠性上移
        - IP路由：即多跳路由，维护路由控制表，IP分片和重组适应不同数据链路的传输能力，路由器做分片，目标主机做重组。IPv4/IPv6
        - 路由协议：缓存ip和mac地址，只决定下一跳的地址
        - 路由算法：RIP、RIP2、OSFP、BGP，类型分类有
          1. 距离向量算法：根据路由跳数决定，由互换路由信息完成，无法获知整个传输链路的状态，容易路由循环
          1. 链路状态算法：了解整个网络连接状态下生成路由控制表，每个路由器保持相同的信息
     1. ICMP：检测ip包是否送达，包废弃原因
     1. ARP：地址解析协议，广播通过ip寻找mac地址，广播不能跨路由器，所以需要ip和mac地址。路由器会记录mac和ip地址的对应，依靠mac传递数据
     1. RARP：mac广播找ip，反过来
     1. DHCP：自动ip分配
     1. NAT：公私ip转换协议，NAPT端口转换协议
   - 数据链路层
     1. MAC：交换机负责维护单一层次的mac转发表，实现信息转发，可自学地址/环路检测(防止数据无休传输)
     1. 非共享介质网络：依赖交换机，可以构建虚拟局域网(VLAN)，用于划分虚拟网段
     1. 各种数据链路(传输技术)：以太网、无线、ATM、FDDI、ADSL(话机到电信局交换机中传输高频数字信号，和低频信号隔离避免噪声干扰啊)
     1. PPP：纯的数据链路层，以太网和FDDI都定义了比特被定义为何种电子信号，还需要物理层实现通信，如ADSL/有线电视通过PPPoE(以太网数据加入PPP帧)实现接入
     1. VPN：使用ip包中的标签确定用户以在多协议标签交换(MPLS)网中传输，或者使用IPsec技术对ip包进行验证和加密
   - 物理层
     1. 分组交换
     1. 各种网络构成：接入层、边缘网络、骨干网
     1. ISP：互联网服务供应商
     1. 硬件设备
        - 网卡
        - 中继器：物理层延长网络的设备
        - 网桥：数据链路层延长网络的设备
        - 路由器：网络层转发分组数据的设备
        - 交换机：传输层以上网络传输的设备
        - 网关：交换机是局域网在MAC上进行通信、要是跨ip就要用路由器了，网关就是负责通信的主要接收、分发
1. 互联网：Internet，多个网络连接形成更大的网络，即网际网。由ARPANET发展而来，
### HTTP
1. 概念：超文本传输协议。99年1.1版本,15年HTTP2发布
1. 请求和响应
   - 请求头信息
     1. `Accept` // 指定客户端可接受的MIME类型，如 image/png
     1. `Accept-Charset` // 可接受的字符集，如ISO-8859-1
     1. `Accept-Encoding` // 编码类型，如gzip
     1. `Accept-Language` // 首选语言，如en、en-us、ru
     1. `Host` // 主机和端口
     1. `Content-Length` // POST数据的大小，字节为单位
     1. `Cookie` // 携带的服务器给的cookie
     1. `Authorization` // 鉴权信息     
     1. `User-Agent` // 客户端标识
     1. `Connection` // 是否处理持久Http连接，keep-alive为持久连接
     1. `If-Modified-Since` // 数据缓冲，否则服务器返回304
     1. `If-Unmodified-Since` // 数据缓冲
     1. `Referer` // 上一个页面的url
   - HTTP响应组成：
     1. 数字和文字的状态码
     1. 响应头：服务器类型(UA)、日期时间、内容类型、长度
     1. 响应正文
   - 响应头信息
     1. `Allow` // 服务器支持的方法
     1. `Cache-Control` // 表示此文档是否可安全缓冲，有public、private、no-cache，private表示只能存在私有缓冲中
     1. `Connection` // 是否持久连接：close、keep-alive
     1. `Content-Disposition` // 指定保存的文件名
     1. `Content-Encoding` // 内容编码方式
     1. `Content-Language` // 内容语言
     1. `Content-Length` // keep-alive时不需要
     1. `Content-Type` // MIME类型。网页编码，默认为text/html
     1. `Expires` // 过期时间，即缓冲删除时间
     1. `Last-Modified` // 文件最后修改时间
     1. `Location、Refresh、Retry-After`
     1. `Set-Cookie`
1. 表单提交
   - enctype属性：数据的编码方式，常用有
     1. `application/x-www-form-urlencoded`：名称/值，默认的编码方式
       - 当action为get：就用x-www-form-urlencoded方式转为字符串并加到url后面(url编码)
       - 当action为post：浏览器把form数据封装到http body中发送
     1. `multipart/form-data`：以二进制格式传输数据，一条消息，一个控件对应一个部分，同时比urlencoded传输更大数据。传输文件时使用
     1. `text/plain`：窗体数据以纯文本形式进行编码，不含任何控件或格式字符
1. post
   - 特点：头信息每行一条，空行之后便是body
   - post默认数据
        ```HTTP
        POST / HTTP/1.1
        Content-Type:application/x-www-form-urlencoded
        Accept-Encoding: gzip, deflate
        Host: w.sohu.com
        Content-Length: 21
        Connection: Keep-Alive
        Cache-Control: no-cache
        ```
### WebSocket
1. WebSocket
   - 特点
     1. 鉴于传输中多次路由转发等的不稳定，会发送ping/pong心跳包检测连接活性
   - 步骤：先期使用http建立一次连接，之后转换为websocket
        ```
        // 两个http请求头表示发起websocket请求
        Upgrade: websocket
        Connection: Upgrade
        ```
   - 头信息
     1. Sec-WebSocket-Key 校验key，校验原理是什么？？？
     1. Sec-WebSocket-Protocol 需要的服务名称
     1. Sec-WebSocket-Version 版本号
### 其他传输技术
1. Socket：Socket是应用层与各种网络协议通信的中间软件抽象层，是一组调用接口/API/封装。用socket组织数据，兼容多网络协议，负责程序通信，以符合指定的协议
1. 断点续传：利用http请求头的Range确定传输的起点，响应头Content-Range返回大小。php使用fread/fseek确定读取文件的范围和小大从而实现功能
### wiki
1. 优化传输
   - 减少http请求数：每个新的请求都需要3次握手，很费时间
   - 减少传输文件大小
1. URI：通用资源标志符，唯一标识一个资源，一个字符串格式规范，并没有指定用途。包含URL和URN
   - URL:统一资源定位符，即网址
   - URN:统一资源命名，用名字标识资源。文件 `file://ftp.yesky.com/soft/file/robots.txt`
1. 端口号
   - DNS：53
   - FTP：20、21
   - SSH：22
   - Telnet：23
   - SMTP：25
   - POP3：110