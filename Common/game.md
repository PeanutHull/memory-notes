### game
1. 游戏：就是可控制的逻辑多变的一帧帧动画
   - 显示
     1. 图形系统
        - Shader
        - 动画系统：控制播放
        - 底层渲染
     1. 物理系统：碰撞检测、重力、惯性、速度
     1. 粒子系统
   - 逻辑
     1. 输入控制
     1. AI：NPC互动、自动寻路、追逐敌人
   - 声音
1. 游戏引擎
   - 特点
     1. 减少工作
     1. 减少重复开发
     1. 降低门槛
   - 分类
     1. 大而全
        - 虚幻4：Unreal Engine 4，主要C++，主机、pc、vr
        - Unity3D
     1. 小而美
        - Cocos2dx
        - 白鹭：Egret，主要Typescript，跨平台强，适合h5、微信小程序游戏
        - LayaAir：国内h5引擎，相对Egret起步晚，支持AS3.0、Typescript、JS
     1. 其他：游戏设计器
1. 游戏团队：策划、美术、声音(相对独立，单独团队)、程序员
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
### Unity3D
1. 认识：支持C#/JS/Boo，跨平台好，技术门槛低入门快、操作方便、开发迅速
   - 完美跨平台
   - 简单流程、方便的编辑器
   - 官方支持Asset Store
### Cocos
1. 认识：游戏引擎，MIT协议的开源。包小，兼容性好，性能高，热更新方便，如保卫萝卜
1. 分类
   - Cocos2d-x：c++/lua/js，一次编写，跨平台部署
   - Cocos2d-js：贼火
   - Cocos2d-lua
1. 组成
   - 图形特性
     1. 基本绘制：旋转、位移、缩放、横切
     1. 动画序列帧
     1. Action系统
     1. 骨骼动画
   - Box2D物理引擎
   - 音频系统
   - http网络模块
### UE4
1. Epic公司的，UE4开源+授权费，支持c++、blueprint，如绝地求生
   - 游戏开发
   - 应用软件
   - 影视动画
