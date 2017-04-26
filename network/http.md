#####知识

1. ContentType定义网络类型和网页编码，决定以什么形式读取这个文件。未指定默认为text/html。
1. php的系统数组$_SERVER是一个包含诸如头信息(header),路径(path)和脚本位置(script locations)的数组。
 - $\_SERVER['HTTP_HOST']带http的都是header信息的值，可以自己指定header里得信息
 - ajax的$\_SERVER['HTTP\_X\_REQUESTED_WITH']) = 'xmlhttprequest')
1. form的enctype属性为编码方式，常用有
 - application/x-www-form-urlencoded：窗体数据被编码为名称/值对，也是标准的编码格式
 - multipart/form-data:窗体数据被编码为一条消息，一个控件对应一个部分，同时比urlencoded传输更大数据
 - text/plain:窗体数据以纯文本形式进行编码，不含任何控件或格式字符
 - 当action为get：就用x-www-form-urlencoded方式转为字符串并加到url后面，
 - 当action为post：浏览器把form数据封装到http body中发送
 - 当有file时，就要用到multipart/form-data了
1. URI:通用资源标志符，唯一标识一个资源，一个字符串格式规范，并没有指定用途
URL和URN都是一种URI,1URL:统一资源定位符，即网址。URN:统一资源命名，用名字标识资源。
文件url：file:// ftp.yesky.com/soft/file/robots.txt
1. 跳转方法，防止程序继续执行，但是浏览器没有显示为html加exit
```
header('Location: ./install.php');
exit;
```

1. HTTP请求过程：
  1. 建立TCP连接(基于TCP)
  1. 浏览器发送请求
  1. 浏览器发送头信息
  1. 服务器应答
  1. 服务器发送应答头信息
  1. 服务器发送数据
  1. 服务器关闭TCP连接
1. HTTP响应组成：
  - 数字和文字的状态码
  - 响应头：服务器类型(UA)、日期时间、内容类型和长度
  - 响应正文
1. XMLHttpRequest方法：
  - 发送：open/send/setRequestHeader
  - 接收：status/statusText/getAllResponseHeader
```
var request = new XMLHttpRequest;
request.open("GET", "get.php", true);
request.send();
request.onreadystatechange = function() {
    if(request.readyState === 4 && request.status === 200) {
        console.log('接收成功');
    }
}
```

1. php跳转方法
 - 使用header
```
Header("HTTP/1.1 303 See Other"); 
Header("Location: $url");
exit; // 不然会执行如下代码
```
 - echo各种标签跳转：META(HTTP-EQUIV)、sc rīpt(window.location.href、window.open)
 - thinkphp的redirect

------------

1. post知识
 - post发送类型，只有下面这两种才会放入$_POST变量中
    1. application/x-www-form-urlencoded(默认值)，post不写类型默认就这个，意味内容会被url编码
    1. multipart/form-data，以二进制格式传输数据
 - 发送一个post数据，以下为默认数据
```
POST / HTTP/1.1
Content-Type:application/x-www-form-urlencoded
Accept-Encoding: gzip, deflate
Host: w.sohu.com
Content-Length: 21
Connection: Keep-Alive
Cache-Control: no-cache
。。。。。。空一行
txt1=hello&txt2=world
// 普通的post请求，头信息里注明内容长度，头信息每行一条，空行之后便是body，即内容entity
```

1. socket、TCP/IP、HTTP
 - 7层网络：物理层、数据链路层、网络层、传输层、会话层、表示层和应用层
 - HTTP工作在应用层，解决如何包装数据，使传输的数据有意义。http工作在tcp/ip之上。应用层协议有HTTP、FTP、TELNET，可以自己定义
```
// WEB使用HTTP协议作应用层协议，以封装HTTP文本信息，然后使用TCP/IP做传输层协议将它发到网络上
```
 - TCP/IP在传输层，解决如何传输数据。
```
TCP是面向链接的，虽然说网络的不安全不稳定特性决定了多少次握手都不能保证连接的可靠性，实际上也很大程度上保证了连接的可靠性
UDP不是面向连接的，UDP传送数据前并不与对方建立连接，对接收到的数据也不发送确认信号，发送端不知道数据是否会正确接收，当然也不用重发，UDP是无连接的、不可靠的一种数据传输协议
```
 - socket是对TCP/IP协议的封装，本身不是协议，是一个调用接口(api)。socket设计上就要兼容多网络协议，负责多个程序之间的通信


1. HTTP
- 概念：超文本传输协议。
1. ISO/OSI模型：
 1. 7层的OSI模型规定了世界计算机相互连接的标准，HTTP、HTTPS、FTP、TELNET、SSH、SMTP和POP3都属于最上边的第七应用层。
```
各个层都有自己的数据单元
应用层              :用户接口
表示层              :数据的表现形式(0101互转mp3)、特定功能实现(加密)
会话层              :对应会话的管理、同步。决定把文件是否进行互联网络的传输
传输层是段，Tcp协议  :可靠与否的传输、确定端口、传输前的错误检测、流控、传输速度控制
网络层是报文，ip协议 :利用逻辑地址(ip)找地址、选路
数据链路层是帧       :用MAC访问媒介、错误检验与修正(发现数据错误是可以要求重新传递包的)、负责信息的局域网里的准确传递
物理层是比特         :比特流的传输、电气特性、物理接口(网卡)
```
 1. 上三层针对用户，下四层针对传输
 1. 越到底层，越接近硬件
 1. 版本：99年1.1版本,15年HTTP/2发布
1. TCP/IP模型
 1. 4层：应用、传输、网际互联层、网络接口层。更接近我们实际使用的模型，每一层都和OSI对应
```
应用层        ：对应应用、表示、会话层。包括FTP、Telnet、DNS、SMIP
传输层        ：对应传输层。包含TCP、UDP
网际互联层    ：对应传输层。包括3个主要协议：网际协议(ip)、互联网组管理协议(IGMP)、互联网控制报文协议(ICMP)
网络接口层    ：对应数据链路层、物理层。包含arp协议：————地址解析协议————把ip转为MAC地址。路由器会记录MAX和ip地址的对应。局域网依靠MAC传递数据
```
 1. 数据封装过程
```
应用数据                                   字节流
应用层                                 FTP头+数据
传输层                           TCP头+FTP头+数据
网络层                      IP头+TCP头+FTP头+数据
数据链路层          以太帧头+IP头+TCP头+FTP头+数据
```
 1. http在任何可提供稳定传输上都可传输数据，TCP/IP就是其传输层
 1. OSI是通用的，TCP/IP是先有协议后建立模型，不适用非TCP/IP模型
1. 其他网络必备
 1. 端口
```
FTP端口号：20、21
SSH端口号：22
telnet端口号：23
DNS端口号：53
SMTP端口号：25
POP3端口号：110
```
 1. DNS
```
域名解析服务
host文件优先级高于DNS
// 查询过程
本地域名服务器缓冲、最后是大家都知道的全球13台根DNS服务器、
```
 1. 网关
```
交换机是局域网在MAC上进行通信、要是跨ip就要用路由器了
网关就是负责通信的主要接收、分发
```
1. 优化传输
    1. 减少http请求数：每个新的请求都需要3次握手，很费时间。服务器页面生成————传输延迟————浏览器渲染，非异步阻塞型。
    1. 减少每个文件的大小
    1. 静态资源放到不同的子域名下：浏览器对相同的域名会限制并发连接数，不同子域名则不会，所以静态资源不需要cookie等，直接放到其他子域名下，指向另一个ip，减少服务器请求
