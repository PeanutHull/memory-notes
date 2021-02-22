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
### ffmpeg
1. 认识：音视频编辑、播放器、音视频编解码，99%软件底层都用ffmpeg
   - 通过ffmpeg的api，我们不用关心各种音视频文件结构怎么写，就能正确写出音视频文件
1. 组成
   - ffmpeg
     1. -i：前视频后音频冒号分隔，如`-i :0`
     1. -f
   - ffprobe
   - ffplay
1. 使用
   - 提取音频：`ffmpeg -i source.mp4 -vn -c:a copy out.aac`
   - 提取视频：`ffmpeg -i source.mp4 -an -c:v copy out.mp4`
   - 合并文件：`ffmpeg -i source.mp4 -i source.aac out.mp4`
   - 格式转换：`ffmpeg -i source.mp4 out.flv`
   - 音频采集：`ffmpeg -f avfoundation -i :0 out.wav`
### 音频
1. 格式
   - 原始格式
     1. pcm：原始的、数字的采集过来的数据，跟文件格式没有关系
        - 数据流
          1. 采集：pcm——编码器——套马甲(封装为mp4)
          1. 播放：马甲——解码器——pcm
     1. wav：可以存储压缩数据或原始数据，在pcm之上套个头
        - RIFF字符串：包含chunkSize大小等，就是表明这是wav，微软和ibm定义
        - fmt：fmt开头，码率相关描述
        - data：data开头，数据部分，
   - 码率：采样率*采样大小*声道数，如44.1kHz * 16bit * 2 = 1411.2Kb/s，1.4MB/s很大了，需要压缩
1. 编解码器
   - opus：新的现在流行，延迟小、压缩率高，延迟在20ms，webRTC默认的
   - aac：应用最广泛，延迟比较高在200ms，不适合实时通信，
   - mp3
   - speex：包括回音消除
   - ogg：收费
   - ilbc
   - amr
   - g711：固话用，丢数据多
1. aac
   - 目的取代mp3，sony、杜比实验室等共同开发，基于mpeg-4，加入了sbr、ps技术
   - 格式
     1. ADIF：可以确定找到音频数据的开始，只能从头开始解码，常用于磁盘文件
     1. ADTS：每一帧都有同步字，可以在任意位置解码，类似于数据流格式
   - 规格
     1. lc：low complexity，低复杂度，128k码流(采样率)，
     1. he v1：lc + sbr，按频谱保存，低频编码保存主要成分，高频单独放大保存音质，64k
     1. he v2：v1 + ps，只存储一个声道全部信息，然后花很少字节保存不一样的地方，最常用
1. wiki
   - 声音
     1. 认识：震动产生、固液气传播、耳膜震动
     1. 三要素
        - 音调：音频的快慢
        - 音量：震动幅度
        - 音色：谐波，就是小震动
     1. 人耳听觉范围：20Hz~20kHz
   - 模数转换
     1. 数字采样：即量化
        - 采样大小：bitsPerSample，一个采样的存储比特数，通常16bit
        - 采样率：sampleRate，采样频率，8k(打电话，能听出来人特质)、16k、32k、44.1k、48k(基本完全还原)
        - 声道：channel，单声道、双声道、多声道、立体声(>1)
     1. 转为二进制：二进制方波
   - 音频重采样：将音频三元组的值转成另外的值，api有：swr_alloc_set_opts、swr_init、swr_convert、swr_free
     1. 从设备采集的音频数据和编码器要求的不一样：如对PCM数据进行重采样以达到AAC编码的要求
     1. 扬声器要求的和播放的不一致
     1. 更方便计算，如回声消除
   - 音频压缩：失真程度和最大压缩
     1. 有损压缩：去除冗余信息，包含人听觉范围外和被掩蔽的信号
        - 频域遮蔽效应
        - 时域遮蔽效应
     1. 无损编码
        - 熵编码
          1. 哈夫曼编码：用小的二进制数代替长字符串，哈夫曼树搭配对应表，实现压缩
          1. 算术编码：二进制小数
          1. 香农编码
   - 音频编码过程
     1. 时域转频域、心理声学模型(人听觉范围)：剩下有用的数据
     1. 量化编码
     1. 比特流格式化：形成可传输的数据
   - 3A处理：回音消除、降噪、自动增益
   - 丢包、抖动
### 视频
1. 视频
   - 视频帧：一组图像组成
     1. 帧率：fps，平滑程度，每秒采集、播放的图像个数，动画帧数为25，常见15、30、60
     1. 分辨率：清晰程度，x轴像素个数 * y轴像素个数，常见有360p、720p、1k、2k，常见宽高比16:9、4:3
        - 像素：一个点，每三个红绿蓝二极管组成一个像素
          1. RGB
             - RGB：24位
             - RGBA：32位，加了透明度，即位深
          1. BGR：bmp使用，需要和RGB进行转换
          1. YUV：YCbCr，y明亮度，uv描述影像色彩和饱和度，采样格式有：4:2:0、4:2:2、4:4:4。RGB用于图像显示，YUV用于采集和编码，可以互转
   - 屏幕
     1. PPI：pixels per inch，每英寸的像素数量，>300是视网膜级别
     1. DPI：dots per inch，每英寸的点数
     1. 图像处理：拉伸/留白、缩小/截断
   - RGB码流：kb/s，宽 * 高 * 3byte(rgb) * 帧率，如720p的25帧视频每秒500多M
1. 组成
   - 流
   - 轨
1. 编解码器：可以压缩
   - h264
     1. 格式：yuv420p
   - h265
   - vpx：vp8、vp9
1. 流媒体服务器
   - nginx
   - srs
   - cdn
   - rtmp
1. wiki
   - 直播架构
     1. 推流工具：推到流媒体服务器，如obs、ffplay
        - 采集、编码(有损、无损)
        - 传输
        - 解码、渲染
     1. 流媒体服务器，如rtmp://
     1. 拉流工具：vlc等支持网络流的
   - 硬件加速：指用gpu运算，释放cpu，对音视频做指令集优化，速度快
### webRTC
1. 认识：音视频实时通信，3A处理，网络传输策略，由谷歌推广的开源实时音视频技术栈，是W3C标准，还有对应的IETF工作组(RTCWEB)
   - 主流浏览器都支持，省去客户端工作，回声消除，双讲抑制
   - 媒体服务器：客户端只和服务器建立媒体传输通道
     1. SFU：Selected Forward Unit，并发转发多路信号，带宽占用高，灵活分发
        - 媒体流：RTP数据包
        - 媒体控制流：RTCP包，包含NACK, PLI, REMB, Receiver Report
     1. MCU：Multipoint Control Unit，转码/混流后传输，带宽占用少，对服务器性能要求高，实时性稍差
     1. 开源媒体服务器：janus、licode、mediasoup
   - RTC：实时音视频通信
   - 底层也用ffmpeg
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