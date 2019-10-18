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
