### 网络
1. 理解：互相通信，协议在计算机通信中的重要性，分层负责、对上封装/抽象
1. 网络
   - ISO/OSI模型：为统一不同计算机厂商的通信，国际标准化组织(ISO)制定了通信系统的标准，即开放式通信系统互联参考模型(OSI)。这个模型只是粗略的界定，对协议和接口没有详细定义
      ```
      应用层：      应用协议，如http、dns、pop3、dhcp
      表示层：      负责数据的表现形式/安全/压缩等功能，固有数据格式和网络标准格式的转换
      会话层：      负责会话的管理、同步，决定连接/断开的时间和时机
      传输层：      段，负责传输数据的协议端口号，提供错误检测/流控/速度控制，如tcp
      网络层：      报文，负责逻辑地址寻址、实现路由选择，利用逻辑地址(ip)寻址/选路，有ip协议
      数据链路层：   帧，负责建立逻辑连接、硬件地址寻址、差错校验等。用mac定位媒介、错误检验与修正(发现数据错误是可要求重新传包)、负责信息局域网里的准确传递，帧和比特流的转换
      物理层：      比特，负责比特流的传输，建立物理连接
      ```
   - TCP/IP模型：OSI中的协议没有没有普及，但是其模型常被使用，但非国公共机构指定的标准(IETF)，由大学、计算机行业为中心力量推动的TCP/IP成为了业界标准，成为广泛使用的通信协议。前辈为全球互联网鼻祖(ARPANET)。由于其开放性和注重实用性，迅速流行和发展，笑谈先写程序，后定标准，TCP/IP广义上指所有目前用到的协议
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
        - telnet：用来远程登录，基于TCP/IP协议族一员的telnet协议，采用明文传送报文安全性不好，都用ssh
   - 表示层
     1. DNS：域名解析服务，本地域名服务器缓冲、一级级往上查询，最后是全球13台根DNS服务器
   - 会话层
   - 传输层
     1. TCP：面向连接，可靠性的流协议，提供顺序控制/重发控制/流量控制/拥塞控制，7次握手，窗口发送数据，数据发送会有回执确认。用于需要可靠传输的情况
     1. UDP：无连接，不可靠的数据报协议，传输数据不先建立连接，不能确定是否送达，可以保证收到的大小。用于需要高速传输和实时性较高的场景，如ip电话使用tcp重发的话，就不对了，用udp的话不会有声音大幅度延迟的情况，只是产生停顿或者混乱，通常不影响
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
     1. 各种数据链路(传输技术)：以太网、无线、ATM、FDDI、ADSL(话机到电信局交换机中传输高频数字信号，和低频信号隔离避免噪声干扰啊)
     1. PPP：纯的数据链路层，以太网和FDDI都定义了比特被定义为何种电子信号，还需要物理层实现通信，如ADSL/有线电视通过PPPoE(以太网数据加入PPP帧)实现接入
     1. VPN：依赖交换机，划分虚拟网段，使用ip包中的标签确定用户以在多协议标签交换(MPLS)网中传输，或者使用IPsec技术对ip包进行验证和加密
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
1. 互联网：Internet，多个网络连接形成更大的网络，即网际网。由ARPANET(为可靠军用通信诞生)发展而来
### HTTP
1. 认识：HyperText Transfer Protocol，超文本传输协议，以字节为单位，以ascii码传输。无状态、通信开销小，简单快速、基于BS模式
1. http头
   - 通用
    ```
    Cache-Control                   控制缓存的行为，如Cache-Control: private, max-age=0, no-cache
        响应指令：public/private        其他人是否可使用缓存
        请求指令：no-cache              强制向源服务器再次验证，防止从缓存中返回过期的资源，no-store 不缓冲，max-age 秒 响应的最大Age值，
    Connection                      逐跳首部、连接的管理，Close、Keep-Alive、Upgrade
    Date                            创建报文的日期时间
    Transfer-Encoding               指定报文主体的传输编码方式
    Pragma                          报文指令
    Trailer                         报文末端的首部一览
    Upgrade                         升级为其他协议
    Via                             代理服务器的相关信息
    Warning                         错误通知
    ```
   - 请求头
    ```
    Host                            请求资源所在服务器
    Accept                          用户代理可处理的媒体类型
    Accept-Charset                  优先的字符集
    Accept-Encoding                 优先的内容编码
    Accept-Language                 优先的语言（自然语言）
    If-Match                        比较实体标记（ETag）
    If-Modified-Since               比较资源的更新时间
    If-None-Match                   比较实体标记（与 If-Match 相反）
    If-Range                        资源未更新时发送实体 Byte 的范围请求
    If-Unmodified-Since             比较资源的更新时间（与If-Modified-Since相反）
    Range                           实体的字节范围请求
    User-Agent HTTP                 客户端程序的信息
    Authorization                   Web认证信息
    Proxy-Authorization             代理服务器要求客户端的认证信息
    Referer                         请求中url的原始获取方
    Max-Forwards                    最大传输逐跳数
    TE                              传输编码的优先级
    Expect                          期待服务器的特定行为
    From                            用户的电子邮箱地址
    ```
   - 响应头
    ```
    Server                          HTTP服务器的安装信息
    Set-Cookie
    Accept-Ranges                   是否接受字节范围请求
    ETag                            资源的匹配信息
    Age                             推算资源创建经过时间
    Retry-After                     对再次发起请求的时机要求
    Location                        令客户端重定向至指定URI
    Refresh
    WWW-Authenticate                服务器对客户端的认证信息
    Proxy-Authenticate              代理服务器对客户端的认证信息
    Vary                            代理服务器缓存的管理信息
    ```
   - 实体头
    ```
    Allow                           服务器支持的HTTP方法
    Content-Type                    实体主体的媒体类型，默认为text/html
    Content-Length                  实体主体的大小（单位：字节），keep-alive时不需要
    Content-Encoding                实体主体适用的编码方式
    Content-Language                实体主体的自然语言
    Content-Location                替代对应资源的URI
    Content-MD5                     实体主体的报文摘要
    Content-Range                   实体主体的位置范围
    Expires                         实体主体过期的日期时间
    Last-Modified                   资源的最后修改日期时间
    ```
1. 请求
   - 方法：get/post/put/delete/head/options/trace/connect
   - 组成：
     1. 请求行
     1. 头信息
     1. 空行：CR+LF，回车换行，0x0d0x0a
     1. 主体
   - 实体类型
     1. multipart/form-data
     1. multipart/byteranges
   - Get
        ```
        GET / HTTP/1.1
        Host: xx.com
        Accept: text/html
        Cache-Control: no-cache
        ```
   - Post：头信息每行一条，空行之后便是body，普通的post实体是键值对
        ```HTTP
        POST / HTTP/1.1
        Content-Type: application/x-www-form-urlencoded
        Accept-Encoding: gzip, deflate
        Host: w.sohu.com
        Content-Length: 21
        Connection: Keep-Alive
        Cache-Control: no-cache
        ```
1. 响应
   - 数字和文字的状态码
   - 响应头：服务器类型(UA)、日期时间、内容类型和长度
   - 响应正文
1. http认证方式
   - BASIC 基本认证，使用base64认证，直接传输账号密码
   - DIGEST 摘要认证，接收服务端的质询码，计算后服务端验证
   - SSL客户端认证
1. https：加密发生在应用层与传输层之间，调试工具可以看到的是应用层的数据，传输层传输的是加密后的密文，防止传输过程中被监听，在tcp和http中间加了ssl/tls
   - SSL/TLS：TLS协议是继承了SSL协议并写入RFC，标准化后的产物，通常用SSL来指代SSL/TLS协议。SSL2.0和3.0不安全
     1. 协议栈：握手、记录、修改密码规范、警报
     1. 运作流程
        - 握手阶段：客户端发送ClientHello、接收公钥并加密客户端生成的会话密钥，服务器确认会话密钥后，通知客户端开始用对称加密通信。其中两者还要商量协议版本和加密算法、两端随机数
        - 应用数据传输阶段：按照SSL记录协议收发应用数据
1. 应用
   - 表单提交
     1. enctype属性：表单数据的编码方式
        - `application/x-www-form-urlencoded`：名称/值，默认的编码方式
          1. 当action为get：就用x-www-form-urlencoded方式转为字符串并加到url后面(url编码)
          1. 当action为post：浏览器把form数据封装到http body中发送
        - `multipart/form-data`：以二进制格式传输数据，改造post方式而来，一个控件对应一个部分，比urlencoded传输更大数据，传输文件时使用
          1. 当action为get：url参数追加形式，没有被上传文件的实际数据
          1. 当action为post：Content-Type会追加boundary，其值作为请求体的文件数据分隔符，支持post的工具改变数据包装方式都能支持
        - `text/plain`：以纯文本形式进行编码，空格转换为加号，不对特殊字符编码。不含任何控件或格式字符
   - 断点续传：利用http请求头的Range确定传输的起点，响应头Content-Range返回大小。php使用fread/fseek确定读取文件的范围和小大从而实现功能
   - 缓存控制
   - 获取客户端ip
     1. 参数
        - HTTP_CLIENT_IP：未成标准，不一定服务器都实现，一和二可以用来表示负载均衡后的真实ip
        - HTTP_X_FORWARDED_FOR：有标准定义，用来识别经HTTP代理后的客户端IP地址，没有代理则为空，格式：clientip,proxy1,proxy2(因为可能多个代理)
        - REMOTE_ADDR：是可靠的，是最后一个跟你握手的ip，因为否则reponse不会达到，这个可能为代理ip
        - HTTP_VIA：代理服务器ip
     1. 代理类型
        - 透明代理：HTTP_X_FORWARDED_FOR传真实用户ip，HTTP_VIA如实
        - 普通匿名代理：HTTP_X_FORWARDED_FOR传真实代理ip，HTTP_VIA如实
        - 欺骗性代理：HTTP_X_FORWARDED_FOR传随机ip，HTTP_VIA如实
        - 高匿名代理：HTTP_X_FORWARDED_FOR和HTTP_VIA无数值
1. 请求过程：不止这些，基于浏览器的策略和长连接，nginx的策略肯定比这复杂的多
   - 建立tcp连接
   - 浏览器发送请求、头信息
   - 服务器发送应答头信息、数据
   - 服务器关闭tcp连接
1. wiki
   - 版本特性
     1. http 1.0：性能缺陷无法复用连接，队头阻塞
        - 无状态、无连接，规定和服务器保持短暂的连接。每次请求都需要建立tcp连接，服务器完成后立即断开(无连接)，服务器不跟踪每个客户端也不记录过去的请求(无状态)
        - 上一个请求到达之后下一个才能发送
     1. http 1.1：大范围使用的
        - 增加长连接：增加Connection头，设置Keep-Alive
        - 缓存处理：增加cache-control，强缓存和协商缓存
        - 断点传输
        - 增加host字段：使得一个服务器可以创建多个站点
        - 支持请求管道化：基于长连接可以在一个连接发送多个请求，但是要求顺序返回响应，而且不能并行请求和响应。无法解决头阻塞太苛刻很少应用，现代浏览器采用同时多个tcp连接并行加载资源
     1. http 2.0：多路复用，二进制分帧，双向并行传输，突破性能限制，改进传输性能，没有改变1.x的语义
        - 多路复用：在一个tcp连接之上增加二进制分帧层，把header和body用frame封装了，承载任意数量的双向数据流
          1. stream：流，已建立连接上的双向字节流
          1. 消息：数据流，包含header帧、body帧，可以设置优先级、依赖
          1. frame：帧，通信最小单位，会标识所属的流，可以乱序发送，然后再根据帧头部的流标识符重新组装
        - 头部压缩：1.x头部元数据以纯文本形式发送，给请求增加几百字节的负荷，如cookie。使用encoder，通讯双方各自cache一份header fields表，避免header重复传输，减小传输大小
        - 服务器推送：服务器可主动推送
   - 历史：90年诞生，96年1.0版本，97年1.1版本，15年HTTP2发布
   - web使用http协议作应用层协议，然后使用tcp/ip做传输层协议将它发到网络上
   - ajax的['HTTP_X_REQUESTED_WITH']为'xmlhttprequest'   
1. webSocket
   - 理解：全双工通讯的网络技术，属于应用层协议，基于tcp传输协议，并复用http的握手通道
     1. 更好的二进制支持
     1. 较少的控制开销：数据交换的数据头部较小
     1. 支持扩展
   - 步骤
     1. 建立连接：先期使用http建立一次连接，之后转换为websocket
        ```
        // 两个http请求头表示发起websocket请求
        Upgrade: websocket
        Connection: Upgrade
        ```
     1. 交换数据
     1. 数据帧格式
     1. 维持连接：鉴于传输中多次路由转发等的不稳定，会发送ping/pong心跳包检测连接活性
   - 头信息
     1. Sec-WebSocket-Key 校验key，校验原理是什么？？？
     1. Sec-WebSocket-Protocol 需要的服务名称
     1. Sec-WebSocket-Version 版本号
### TCP
1. tcp过程
   - 3次握手
     1. 客户端：发送SYN包(seq=x)，进入SYN_SEND状态
     1. 服务端：返回SYN(seq=y)+ACK(x+1)应答包，进入SYN_RECV状态
     1. 客户端：收到服务端包后，发送ACK(y+1)，双方进入ESTABLISHED状态
   - 传输数据
     1. 超时重传：客户端每次发送数据包都有seq号，服务端收到数据后会回复ack(seq+1)进行确认。在发送了一段时间后，如果没有收到对应的ack回复就认为报文丢失，会重传
     1. 快速重传：服务端主动告诉客户端重传
     1. 流量控制：TCP滑动窗流量控制，服务端告诉发送端自己还有多少缓冲区可以接收数据，发送端就根据服务端的处理能力来发送数据
     1. 拥塞控制：基于整个网络来考虑，因为重传可能带来网络风暴，拥塞策略算法主要包括：慢启动，拥塞避免，拥塞发生，快速恢复
   - 4次挥手
     1. 主动关闭方：发送FIN包(seq=x)
     1. 被动关闭方：发送ACK
     1. 被动关闭方：发送FIN，告诉主动关闭方，我的数据也发送完了，不会再给你发数据了
     1. 主动关闭方：收到FIN后，发送ACK
### wiki
1. ASCII码：美国信息交换标准代码，基于拉丁字母的主要用于显示现代英语和其他西欧语言现今最通用的单字节编码系统，等同于国际标准ISO/IEC646
   - 标准ASCII码：使用7 位二进制数（剩下的1位二进制为0）来表示
     1. 大/小写字母
     1. 数字0-9
     1. 标点符号
     1. 美式英语中的特殊控制字符：LF（换行）、CR（回车）、FF（换页）、DEL（删除）、BS（退格)、BEL（响铃）
     1. 通信专用字符：SOH（文头）、EOT（文尾）、ACK（确认）
   - 扩展ASCII码：后128个
1. URI：通用资源标志符，唯一标识一个资源，一个字符串格式规范，并没有指定用途。包含URL和URN
   - URL:统一资源定位符，即网址
   - URN:统一资源命名，用名字标识资源。文件 `file://ftp.yesky.com/soft/file/robots.txt`
1. 状态码：负责表示HTTP请求的返回结果
   - 1xx：请求处理中
   - 2xx：正常处理。200 ok，206 范围请求
   - 3xx：重定向。301 永久重定向，302 临时重定向，304 未修改(未符合If-Match，If-None-Match，If-Modified-Since，If-Unmodified-Since、If-Range)
   - 4xx：客户端错误。400 请求报文语法错误，401未认证，403 阻止，404 未找到
   - 5xx：服务器错误。500 内部错误，503 服务不可用
1. 端口号
   - DNS：53
   - FTP：20、21
   - SSH：22
   - Telnet：23
   - SMTP：25
   - POP3：110
1. socket：Socket是应用层与各种网络协议通信的中间软件抽象层，是一组调用接口/API/封装。用socket组织数据，兼容多网络协议，负责程序通信，以符合指定的协议
1. 优化传输
   - 减少http请求数：每个新的请求都需要3次握手，很费时间
   - 减少传输文件大小
### Tools
1. traceroute/tracert
   - 认识
     1. 认识：利用IP数据包的TTL字段值 + ICMP，用于探测网络路径的数据包的IP之上的协议可以是UDP、TCP或ICMP，显示经过的路由器ip和时间。ping只能显示终点
        - TTL：数据包生存时间，每次转发都减1，为0就丢弃
        - TCMP：产生一个主机不可达的ICMP数据报返回给主机
     1. 原理：TTL=1开始，循环+1探测经过的路由器，依赖ICMP返回获取路由器数据，同时使用udp的大于30000的端口，利用目的主机只能发送端口不可达的ICMP数据识别终点
        - TCMP：出于安全性考虑，大多数防火墙以及启用了防火墙功能的路由器缺省配置为不返回各种ICMP报文，其余路由器或交换机也可能被管理员主动修改配置变为不返回 ICMP报文，不一定能拿到所有的沿途网关地址
        - UDP：UDP常被用来做网络攻击，因为UDP无需连接，因而没有任何状态约束它，方便攻击者伪造源IP、伪造目的端口发送任意多的UDP包，长度自定义。所以运营商为安全考虑，对于UDP端口常常采用白名单ACL，如允许DNS/DHCP/SNMP等
   - 使用
     1. 模式
        - UDP模式：UDP探测数据包（目标端口大于30000） + 中间网关发回 ICMP TTL 超时数据包 + 目标主机发回 ICMP Destination Unreachable 数据包
        - TCP模式：TCP[SYN]探测数据包 + 中间网关发回ICMP TTL超时数据包 + 目标主机发回TCP[SYN ACK]数据包
        - ICMP模式：ICMP Echo (ping) Request 探测数据包 + 中间网关发回ICMP TTL超时数据包 + 目标主机发回ICMP Echo (ping) reply 数据包
