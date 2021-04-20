### 网络
1. 认识：互相通信，协议在计算机通信中的重要性，分层负责、对上封装/抽象
1. 网络模型
   - ISO/OSI：为统一不同计算机厂商的通信ISO制定了通信系统的标准，即OSI。这只是粗略的界定，对协议和接口没有详细定义
     1. 组成：七层网络
        - 应用层：应用协议，如http、dns、pop3、dhcp
        - 表示层：数据的表现形式/安全/压缩等功能，固有数据格式和网络标准格式的转换
        - 会话层：会话的管理、同步，决定连接/断开的时间和时机
        - 传输层：段，传输数据的协议端口号，提供错误检测/流控/速度控制，如tcp
        - 网络层：报文，逻辑地址寻址、实现路由选择，利用逻辑地址(ip)寻址/选路，有ip协议
        - 数据链路层：帧，硬件地址寻址、差错校验等。用mac定位媒介、错误检验与修正(发现数据错误可要求重新传包)、负责信息局域网里的准确传递，帧和比特流的转换
        - 物理层：比特，比特流的传输，建立物理连接
     1. 特点
        - 上三层针对用户，下四层针对传输
        - 越到底层，越接近硬件
        - OSI是通用的，TCP/IP是先有协议后建立模型，不适用非TCP/IP模型
   - TCP/IP：由FTP、SMTP、TCP、UDP、IP、ARP、ICMP等协议构成的协议簇，因为TCP协议和IP协议最具代表性所以命名。OSI中的协议没有普及，但是其模型常被使用，IETF，由大学、计算机行业为中心力量推动的TCP/IP成为了业界标准和广泛使用的通信协议。开放性和注重实用性，迅速流行和发展
     1. 组成：四层网络
        - 应用层：对应应用、表示、会话层，包括ftp、telnet、dns、smtp
        - 传输层：对应传输层，包含tcp、udp
        - 网际互联层：对应传输层，包括3个主要协议：网际协议(ip)、互联网组管理协议(igmp)、互联网控制报文协议(icmp)
        - 网络接口层：对应数据链路层、物理层，包含地址解析协议(arp)
     1. 数据封装过程
        - 应用数据                                   字节流
        - 应用层                                 FTP头+数据
        - 传输层                           TCP头+FTP头+数据
        - 网络层                      IP头+TCP头+FTP头+数据
        - 数据链路层           以太帧头+IP头+TCP头+FTP头+数据
1. ISO/OSI网络组成
   - 应用层
     1. HTTP、FTP、TELNET、SSH、P2P、SMTP、POP3、MIME、LDAP，也可自定义
   - 表示层
     1. 域名：ICANN，全世界域名的最高管理机构
        - .com：顶级域名，理论上所有域名的查询都必须先查询根域名，因为只有根域名才能告诉你某个顶级域名由哪台服务器管理。15年时1058个
          1. 通用：com、net、org
          1. 国家：cn。cn托管商就是中国互联网络信息中心
        - baidu：二级域名
        - www：三级域名
     1. DNS：域名解析服务，本地域名服务器缓冲、一级级往上查询，最后是全球13台根DNS服务器，保留了对所有域名的起始解释权。不会自己存，只是会告诉你去哪里找![avatar](../images/dns.jpeg)
        - SOA服务器：起始权威服务器，可以新增和删除记录。一个域SOA只有一个，而NS可以有多个
        - NS服务器：表示哪些DNS服务器可以解析该域名。NS服务器包含SOA，SOA是一种特殊的NS
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
     1. 硬件设备
        - 网卡
        - 中继器/集线器：物理层延长网络的设备，数据广播发送，功能是对信号进行放大
        - 网桥：数据链路层延长网络的设备
        - 路由器：网络层转发分组数据的设备
        - 交换机：传输层以上网络传输的设备
          1. 网关：交换机是局域网在MAC上进行通信、要是跨ip就要用路由器了，网关就是负责通信的主要接收、分发。网间连接器、协议转换器，用于不同的高层协议网络互连。主机发现数据包目的主机不在本地网络中，就转发给自己的网关，再由网关间转发
          1. 子网掩码：是为了区分网络位和主机位，解决ip地址扩展问题
          1. CIDR：无类域间路由，采用任意长度分割 IP 地址的网络号和主机号
             - 把多个网段聚合到一起，生成一个更大的网段
             - 汇总路由表 IP 地址，分担路由表压力
          1. VLSM：可变长子网掩码，可以对A、B、C类地址再进行子网划分
1. 互联网
   - 认识：Internet，多个网络连接形成更大的网络，即网际网。由ARPANET(为可靠军用通信诞生)发展而来
   - LAN：局域网
     1. VLAN：虚拟局域网，划分便于管理，一个vlan里可以相互通信(如arp)，不同vlan需要单臂路由或者三层交换机
   - 路由
     1. 单臂路由：普通二层交换机加路由器
     1. 三层交换机：二层交换+三层转发，本质是带有路由功能的二层交换机，避免大量vlan下路由器成为网络瓶颈
1. 远程控制协议
   - telnet
   - ssh
   - vnc：virtual network computing 虚拟网络计算机，可以实现图形化的远程控制
1. 指标
   - Bandwidth：带宽
   - Latency：延时
   - Throughput：吞吐
   - Response Time：响应时间
1. 网络
   - 广播地址：ip地址中的主机号全部为1的地址，它是向同一个网段中的所有主机发送数据包
     1. ip组播：用于将包发送给特定组内的所有主机，可以跨网段给全网所有组员发送组播包。广播只能在路由器范围内
   - IP路由：是设备根据 IP 地址对数据进行转发的操作。当一个数据包到达路由器时，路由器根据数据包的目的地址查询路由表，根据查询结果将数据包转发出去，这个过程就是
     1. 路由表：为了将数据包发给目的节点，所有节点都维护着一张路由表
     1. Hop：跳，指网络中的不经过路由器而能直接到达的相连主机或路由器网卡的一个区间。IP包就是在网络中一跳一跳的转发
     1. 默认路由：为 0.0.0.0/0 或 default
     1. 主机路由：ip/32 被称为主机路由
     1. 回环地址：以127开头的ip地址都是
   - ip分片与重组
### ARP
1. 认识：Address Resolution Protocol，地址解析协议，通过ip拿mac地址，先局域网广播询问物理地址，之后缓存一段时间，ipV6中用NDP代替
   - RARP：反向地址转换协议
   - ARP响应：发现是自己的ip，告诉别人
   - ARP欺骗：由于建立在互相信任基础上，攻击者可伪造目标机器的ARP信息，导致数据会通过攻击者转发
### ICMP
1. 认识：Internet Control Message Protocol，Internet控制报文协议，ping通过ICMP消息
   - 用于在IP主机、路由器之间传递控制消息
   - 面向无连接的协议，是网络层协议
1. 功能
   - 确认IP包是否成功到达目标地址
   - 通知在发送过程中IP包被丢弃的原因
   - 控制发送速率，改变路由路径
1. 组成
   - 报错报文
   - 控制报文
     1. 拥塞控制、源站抑制
     1. 路由控制与重定向报文
1. wiki
   - 基于IP协议工作，并不是传输层的功能，因此仍然归结为网络层协议
   - IPv6要用ICMPv6
### TCP
1. 认识：一条tcp连接是由源IP、源端口、目的IP、目的端口四元组决定的，所以服务器可以支持的连接数理论无穷尽
1. tcp过程
   - 3次握手：为了确认双方的接收能力和发送能力是否正常
     1. 服务端：进入LISTEN状态
     1. 客户端：发送SYN包(seq=x)，进入SYN_SEND状态
     1. 服务端：返回SYN(seq=y)+ACK(x+1)应答包，进入SYN_RECV状态
     1. 客户端：收到服务端包后，发送ACK(y+1)，双方进入ESTABLISHED状态
   - 传输数据
     1. 超时重传：客户端每次发送数据包都有seq号，服务端收到数据后会回复ack(seq+1)进行确认。在发送了一段时间后，如果没有收到对应的ack回复就认为报文丢失，会重传
     1. 快速重传：服务端主动告诉客户端重传
     1. 流量控制：TCP滑动窗流量控制，服务端告诉发送端自己还有多少缓冲区可以接收数据，发送端就根据服务端的处理能力来发送数据
     1. 拥塞控制：基于整个网络来考虑，因为重传可能带来网络风暴，拥塞策略算法主要包括：慢启动，拥塞避免，拥塞发生，快速恢复
   - 4次挥手：整了2次FIN、ACK
     1. 说明
        - 主动关闭方状态：FIN-WAIT-1、FIN-WAIT-2、TIME-WAIT、CLOSE
        - 被动关闭方状态：CLOSE-WAIT、LAST-ACK、CLOSE
        - 为什么挥手要4次：由TCP的半关闭造成的，只有等到被动关闭方确认他自己所有的报文都发送完了，才发送FIN报文
          1. 半关闭：tcp提供了连接的一端在结束它的发送后还能接收来自另一端数据的能力
     1. 流程
        - 主动关闭方：发送FIN包(seq=x)，进入FIN-WAIT-1状态
        - 被动关闭方：收到FIN后，发送ACK(seq=y,ack=x+1)，进入CLOSE-WAIT状态
        - 主动关闭方：收到ACK后，进入FIN-WAIT-2状态
        - 被动关闭方：之后主动发送FIN(seq=z,ack=x+1)，进入LAST-ACK状态，并关闭连接。告诉主动关闭方，我的数据也发送完了，不会再给你发数据了
        - 主动关闭方：收到FIN后，发送ACK(seq=x+1,ack=z+1)，进入TIME-WAIT状态，等待2MSL后，关闭连接，进入CLOSED状态，完成了循环
        - 被动关闭方：收到ACK后，进入CLOSE状态
   - 理解
     1. CLOSE就是初始的状态，或者是LISTEN状态
     1. 半连接队列：服务端把处于SYN_RCVD状态的连接放入队列，称为半连接队列，全连接就是完成握手的连接。指数级SYN-ACK重传，达到最大次数后从半连接队列删除
     1. SYN攻击：服务器端的资源分配是在二次握手时分配的，而客户端的资源是在完成三次握手时分配的。服务端容易收到SYN洪水攻击，就是短时间伪造大量不存在的ip地址，不断发送SYN包，让服务端不断重发ACK，占满服务端的半连接队列，正常请求因队列满而丢弃，是典型的Dos/DDos攻击
        - 判断方式：大量半连接，ip地址随机
        - 防御方式：缩短超时（SYN Timeout）时间、增加最大半连接数、过滤网关防护、SYN cookies技术
     1. MSL：Max Segment Lifetime，最长报文段寿命
     1. ISN：Initial Sequence Number，SYN的初始序号，32bit的计数器，每4ms加1。防止在网络中被延迟的分组在以后又被传送，而导致某个连接的一方对它做错误的解释。是动态生成的
     1. TIME_WAIT的意义
        - 可靠地实现TCP全双工连接的终止：因为给被动方的最后一个ACK可能丢失，被动方可以重传FIN+ACK报文，主动方在2MSL内的收到的话，重传ACK，并重启2MSL计时器，保证双方能正常进入CLOSED状态
        - 保证旧报文在网络中消逝：因为要防止超时重传的ACK先发挥关闭作用后，旧的ACK误将新建立的连接关闭，同时禁止主动方在time_wait期间用相同的端口再起一个连接，2MSL后旧的ACK报文肯定被丢弃了
   - 异常
     1. reset报文：RST包，用于释放连接，如服务端在以下情况发送RST包：客户端尝试和未对外提供服务的端口连接时返回、数据交互时程序崩溃时发送、不在其已建立的TCP连接列表内发送、超出重传后超时发送
1. 调优
   - backlog
     1. 认识：包含半/全连接两种状态，如果满了，客户端会收到连接拒绝。计算方式最好为qps=backlog
        - 半连接：SYN queue，SYN_RCVD服务器端口状态
        - 全连接：Accept queue，ESTABLISHED服务器端口状态
     1. 半连接状态下的tcp交互步骤
        - 服务端进入SYN_RCVD状态，但是Accept queue已满，服务端丢弃后续客户端的ACK请求
        - 客户端误以为连接已建立，开始调用等待至超时
        - 服务器则等待ACK超时，会重传SYN+ACK给客户端
   - TIME_WAIT巨大：可能是短连接太多占用了TW，尽量使用长连接，否则会有TCP drop风险
### HTTP
1. 认识：HyperText Transfer Protocol，超文本传输协议，以字节为单位，以ascii码传输。无状态、通信开销小，简单快速、基于BS模式
   - 请求过程：不止这些，基于浏览器的策略和长连接，nginx的策略肯定比这复杂的多
     1. 建立tcp连接
     1. 浏览器发送请求、头信息
     1. 服务器发送应答头信息、数据
     1. 服务器关闭tcp连接
1. http头
   - 通用
     1. Cache-Control：控制缓存的行为，如`Cache-Control: private, max-age=0, no-cache`，
        - 请求指令：
          1. no-cache：强制向源服务器再次验证，防止从缓存中返回过期的资源
          1. no-store：不缓冲
          1. max-age：秒，指定缓存有效的最大Age值
          1. s-maxage：覆盖max-age、expires，仅用于共享缓存，私有缓存会被忽略
        - 响应指令：public/private，其他人是否可使用缓存
     1. Connection：逐跳首部、连接的管理，Close、Keep-Alive、Upgrade
     1. Date：创建报文的日期时间
     1. Transfer-Encoding：指定报文主体的传输编码方式
     1. Pragma：报文指令
     1. Trailer：报文末端的首部一览
     1. Upgrade：升级为其他协议
     1. Via：代理服务器的相关信息
     1. Warning：错误通知
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
    Content-Disposition             请求内容存为文件时提供默认文件名，如attachment;filename="aaa.csv"，设置为空可以防止浏览器下载
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
    Expires                         实体主体过期的日期时间，是http1.0的标准，cache-control的优先级更高
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
   - 数字和文字的状态码：负责表示HTTP请求的返回结果
     1. 1xx：请求处理中
     1. 2xx：正常处理。200 ok，206 范围请求
     1. 3xx：重定向
        - 301 永久重定向
        - 302 临时重定向
        - 304 未修改(未符合If-Match，If-None-Match，If-Modified-Since，If-Unmodified-Since、If-Range)
     1. 4xx：客户端错误
        - 400 请求报文语法错误
        - 401 未认证
        - 403 阻止
        - 404 未找到
        - 408 连接超时(请求发送到网站时间过长，如访问google)
        - 499 客户端或服务端主动断开连接
     1. 5xx：服务器错误
        - 500 无法预料的错误
        - 501 服务器不支持或者无法识别请求的功能
        - 502 bad gateway，上游无效响应(无法连接、连接断开等)
        - 503 service unavailable，服务不可用，提醒稍后再试，fpm不够用，可返回Retry-After头表示恢复时间
        - 504 gateway timeout，响应超时
   - 响应头：服务器类型(UA)、日期时间、内容类型和长度
   - 响应正文
1. https
   - 认识：加密发生在应用层与传输层之间，传输层传输的是加密后的密文，防止传输过程中被监听。即http和tcp中间加了ssl/tls。调试工具看到的是应用层数据
     1. 就是客户端先用服务器的公钥非对称加密自己生成的对称加密的秘钥给服务端，之后双方就可以用对称加密通信了，成本低，又安全
   - SSL/TLS：通常用ssl指代SSL/TLS协议，因为ssl更常用
     1. 加密方式：ECC、RSA、DSA
     1. 协议栈：握手、记录、修改密码规范、警报
     1. 运作流程
        - 握手阶段
          1. 客户端发送ClientHello、接收公钥并加密客户端生成的会话密钥
          1. 服务器确认会话密钥，发送ServerHello，包括协议版本/加密算法/随机数，通知客户端开始用对称加密通信
        - 应用数据传输阶段：按照SSL记录协议收发应用数据
   - SSL：Secure Socket Layer 安全套接层，http之下tcp之上的一个协议加密层。网景公司开发
   - TLS：Transport Layer Security，传输层安全协议。继承ssl协议并写入RFC，标准化后的名称。利用对称加密、公私钥不对称加密及其密钥交换算法，CA系统进行加密且可信任的信息传输。SSL2.0和3.0不安全
     1. 协议组
        - tls记录协议
        - tls握手协议
   - SNI：为解决一个服务器使用多个域名和证书的SSL/TLS扩展，原理是进行SSL/TLS握手之前先发送要访问的域名，服务器根据域名返回合适的证书
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
1. http2.0
   - 多路复用
     1. 客户端一次发起多个请求，服务器一次返回多个响应
     1. 双方可以同时互相发送数据
   - grpc：google主导开发的基于http2.0的cs型的rpc框架
   - SPDY
     1. 认识：google开发的基于tcp的对http的增强的协议，目的是降低延迟，提升速度，提升网络使用体验，IETF标准了SPDY推出了http2，都放弃支持了
        - 页面加载时间减少一半
        - 减少部署复杂性，使用tcp作为传输层，不改现有网络设施
        - 支持SDPY改的是客户端代理和web服务器
     1. 功能
        - 单tcp连接支持并发http请求
        - http报头压缩，减少带宽、包数量
        - 强制ssl
        - 高级特征：允许服务器对客户端发起连接并推送数据
        - 请求优先级
     1. 原理：在ssl层之上增加SPDY会话层，为编码和传输数据设计新帧格式，这样一个tcp可以实现并发流
1. 应用
   - 压缩
     1. 认识：内容编码的一种，内容即body请求体，也可以搅乱、加密。纯文本可压缩到40%，gzip对jpg支持不够好
     1. 组成
        - 请求头
          1. `Accept-Encoding:gzip,deflate`：以下算法全部无损
             - gzip：GNU zip格式压缩，就是找相同字符进行替换进行减小体积，所以html/css/js效果好
             - compress：Unix的文件压缩程序
             - deflate：zlib的格式压缩
             - identity：没有编码
        - 响应头
          1. `Content-Encoding:gzip`
          1. `Content-Length:xx`：这个指压缩后大小，字节
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
   - 登录认证
     1. BASIC 基本认证，使用base64认证，直接传输账号密码
     1. DIGEST 摘要认证，接收服务端的质询码，计算后服务端验证
     1. SSL客户端认证
1. 优化
   - 传输
     1. 减少http请求数：每个新的请求都需要3次握手，很费时间
     1. 减少传输文件大小
1. 历史
   - 认识：90年诞生，96年1.0版本，97年1.1版本，15年HTTP2发布
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
1. wiki
   - web使用http协议作应用层协议，然后使用tcp/ip做传输层协议将它发到网络上
   - ajax的['HTTP_X_REQUESTED_WITH']为'xmlhttprequest'
### FTP
1. 认识：File Transfer Protocol，文件传输协议，是一种应用层协议，可很好的实现跨平台，但无法实现文件系统挂载等其他功能
   - 用到2种tcp连接：一是命令连接，用于客户端和服务端之间传递命令，监听在tcp/21端口；另一个是数据传输连接，用来传输数据，监听的端口是随机的
   - 主动模式、被动模式：主要是防火墙阻挡问题，被动模式基于服务端的防火墙的连接追踪能解决防火墙问题，用的多
### wiki
1. URI：通用资源标志符，唯一标识一个资源，一个字符串格式规范，并没有指定用途。包含URL和URN
   - URL:统一资源定位符，即网址
   - URN:统一资源命名，用名字标识资源。文件 `file://ftp.yesky.com/soft/file/robots.txt`
1. QUIC：Quick UDP Internet Connection，谷歌制定的基于UDP的低时延传输层协议。融合了包括TCP，TLS，HTTP/2等协议的特性
   - 2016年，第一次QUIC工作组会议，受到关注
1. IDC：互联网数据中心
   - IDC机房
1. BGP：边界网关协议，运行于TCP上的一种自治系统的路由协议，可选择最佳路由距离
   - BGP机房：即多线机房，你用联通访问机房就将数据发给联通返回给你，速度快，真正BGP要有AS证书，需要相互和IDC学习对方ip，假的是双线双ip
1. WINS服务：将NetBIOS名转解析ip地址，实现ip和计算机名映射，作用范围是某个内部网络
1. Gopher：比Internet早几年的只支持文本的信息索引程序，是一种传输协议
1. socks：防火墙安全会话转换协议，只提供两端连接和数据包传递，在握手阶段通知客户端，用于客户端与外网的中间传递(如防火墙)，5支持udp，4是tcp
1. ADDS：Active Directory Domain Service，ad域服务器，利用ldap命名路径（LDAP naming path）来表示对象在ad内的位置，提供查询、修改等服务。ad域内的资源以Object(对象)的形式存在，对象通过属性描述特征，就像电话簿中的一个记录，有姓名、地址等
   - LDAP：Lightweight Directory Access Protocol，轻量级目录访问协议，用来查询、更新Active Directory的目录服务通信协议，可以允许任何程序获得目录和其他信息，类似电话薄
     1. 目录：指一种按照树状结构存储信息的数据库
   - AD域切换技术方案：分三个阶段实施
     1. 活跃账号同步
        - 建立一张新的xes_admins表（新表名：xes_admins_ldap）
        - adminapi对接新的LDAP
        - 所有登录admin系统的账号，都在新的LDAP查询一次账号信息，在xes_admins表找到对应的adminid，再写入xes_admins_ldap中
     1. 数据比对
        - 比对xes_admins与xes_admins_ldap表中的数据，找到有差异的行数据
        - 针对有差异的行数据做甄别，判断是否有潜在风险，确认无风险后，做到数据一致
        - 如果判断没有风险，找一个晚上业务空闲时间做xes_admins表切换
     1. 在线数据切换
        - 将xes_admins表中的临时账户数据一次性导入到xes_admins_ldap表（临时账户数据是指没有匹配到工号的数据）
          1. 注：考虑到审计需要和老员工离职再入职等情况，不能只导正常账户，“冻结”和“注销”的数据也要导入到新表
        - 禁止xes_admins表新增，将xes_admins表名改为xes_admins_old，将xes_admins_ldap表名改为xes_admins（理论上表重名可以online操作，需要咨询DBA）
        - xes_admins_old 表自增id + 10000 （万一出现问题便于回滚）