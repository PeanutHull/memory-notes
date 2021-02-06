### 图形库
1. OpenGL：Open Graphics Library 开放图形库，是用于渲染2D、3D矢量图形的跨语言、跨平台的API，大部分API使用硬件加速而设计。本身并不是一个API，是由Khronos组织制定并维护的规范，开发者通常是显卡生产商
   - 分类
     1. Desktop
     1. OpenGL ES：用于手机
   - 语言无关：若干可被调用的函数语言独立，有许多语言绑定
     1. JavaScript：WebGL，OpenGL ES 2.0在Web浏览器中的进行3D渲染的API，把他们两者结合在一起，可为Canvas提供硬件3D加速渲染
     1. C：WGL、GLX和CGL
     1. IOS、Android
   - 平台无关：专注于渲染，不提供输入、音频以及窗口相关的API
1. Vulkan：是OpenGL的下一代版本，由开发OpenGL的团队提出，相对于OpenGL可实现30%的效率提升。可以更详细的向显卡描述你的应用程序打算做什么，从而可以获得更好的性能和更小的驱动开销
1. DirectX
   - 分类
     1. Direct3D：微软制定的3D图形API，可绕过图形显示接口（GDI）直接进行硬件的底层操作，提高游戏的运行速度。基于微软的通用对象模式COM（Common Object Mode）。简称D3D
     1. Direct2D：2D图形API，增加硬件加速。Vista中GDI无法进行硬件加速
   - 版本：DirectX 12，刚刚迁移到win7
1. Angle：D3D API的映射，但其语法本身依旧基于OpenGL
1. Metal：Apple推出的游戏渲染平台Metal，是低层次的渲染接口
1. 编程语言
   - GLS：基于OpenGL的可编程语言，可实现对GPU的编程
   - HLSL：基于D3D的GPU编程技术
### 视觉库
1. OpenCV
   - 认识：开源的跨平台的计算机视觉库，基于BSD许可，实现了图像处理和计算机视觉方面的很多通用算法，由一系列C函数和少量C++类构成
     1. 轻量高效，
     1. 提供了Python、Ruby、MATLAB、C#、Ch、Ruby、GO等的接口
     1. 应用于：人机互动、物体识别、图像分割、人脸识别、动作识别、运动跟踪、运动分析、机器视觉、结构分析、汽车驾驶
   - 历史
     1. 1999年Intel建立
     1. 如今由Willow Garage提供支持
1. libui：简单易用的c语言gui库，支持window、mac、linux三大平台，使用其本地gui技术
1. libpng
1. libjpeg
1. stb_image
1. openalpr：开源的车牌识别
### webRTC
1. 由谷歌推广的开源实时音视频技术栈，是W3C标准，还有对应的IETF工作组(RTCWEB)
   - 主流浏览器都支持，省去客户端工作，回声消除，双讲抑制
   - 媒体服务器：客户端只和服务器建立媒体传输通道
     1. SFU：Selected Forward Unit，并发转发多路信号，带宽占用高，灵活分发
        - 媒体流：RTP数据包
        - 媒体控制流：RTCP包，包含NACK, PLI, REMB, Receiver Report
     1. MCU：Multipoint Control Unit，转码/混流后传输，带宽占用少，对服务器性能要求高，实时性稍差
     1. 开源媒体服务器：janus、licode、mediasoup
   - RTC：实时音视频通信
1. 高级
   - 流程：采集、处理、传输，传输难以把控，时延、抖动、丢包
   - Qos：Quality of Service，服务质量
     1. ARQ：自动重传请求，是数据链路层的错误纠正协议之一，使用NACK机制
     1. FEC：前向纠错，是增加数据通讯可靠度的方法
     1. Jitter Buffer：抖动缓冲，通过在接收端维护一个数据缓冲区，可以对抗一定程度的网络抖动
     1. Congestion Control：拥塞控制， WebRTC利用GCC算法来控制传输
   - Qoe：Quality of Experience，质量体验
1. p2p：peer to peer，点对点技术，P2P网络中的所有计算机上记载着除该台计算机外所有计算机的信息
   - 创世节点
   - 节点通信建立，NAT穿透：Network Address Translation，网络地址转换，网络地址翻译技术，将内部的私有IP转换成公网IP，一个解决地址不够，二是安全(不在转换列表的全都拒绝)
1. irc：古老简单的网络聊天协议，linux的server：ircd-hybrid，客户端：irssi/weechat，小圈子，因为古老而有门槛和纯粹