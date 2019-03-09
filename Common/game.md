1. 游戏引擎
   - 大而全
     1. 虚幻4：Unreal Engine 4，主要C++，主机、pc、vr
     1. Unity3D：主要C#和JS，跨平台好，技术门槛低
   - 小而美
     1. Cocos2D：主要C++，MIT协议的开源
     1. 白鹭：Egret，主要Typescript，跨平台强，适合h5、微信小程序游戏
     1. LayaAir：国内h5引擎，相对Egret起步晚，支持AS3.0、Typescript、JS
   - 其他：游戏设计器
1. 图形API
   - 方法：先学背景、想法、思路，再学具体的操作和细节
   - 理解：Open Graphics Library，跨语言，跨平台的编程图形程序接口，将计算机资源抽象为OpenGL的对象，对对象的操作抽象为指令
     1. OpenGL ES：OpenGL for Embedded Systems，针对嵌入式的子集，目前3.0最流行
   - 组成
     1. 上下文：庞大的状态机，是指令执行的基础，函数都是面向过程的。不同的控制模块使用独立状态管理如多线程，防止上下文状态切换开销，共享纹理、缓冲区等资源，比反复切换上下文或大量修改渲染状态更加合理高效
     1. 帧缓冲区：FrameBuffer，即画板，可以是纹理、渲染缓冲区，放置称为Attachment 帧缓冲区的附着
        - 附着：ColorAttachment、DepthAttachment、StencilAttachment，颜色、深度(判断远近实现遮挡)、模板(一般用于渲染时像素级剔除和遮挡效果，常见应用场景如三维物体描边)，对应ColorBuffer、DepthBuffer、StencilBuffer
     1. Texture 纹理、RenderBuffer 渲染缓冲区
     1. VertexArray 顶点数组、VertexBuffer 顶点缓冲区
     1. ElementArray 索引数组、ElementBuffer 索引缓冲区
     1. Shader 着色器程序
     1. Per-Fragment Operation 逐片段操作
        - Test 测试：PixelOwnershipTest 像素所有者、ScissorTest 裁剪测试、StencilTest 模板测试、DepthTest 深度测试
        - Blending 混合
        - Dithering 抖动
     1. 渲染到纹理
     1. SwapBuffer 渲染上屏/交换缓冲区
        