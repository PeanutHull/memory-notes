### c3d
1. 原则：建好模，打好光，K动画，玩插件，学渲染
### Fiddler
1. 功能：
   - 解密https的请求
   - 请求替换
   - HTTP 断点调试
   - 伪造请求和响应
   - 网速设定
1. 基于.net的规则语法：Fiddler Script
1. 使用
   - host配置
   - 前后端假数据接口调试
   - 线上bugfix，文件指向本地
   - 网速限制
        ```
        1. 简单模拟，模拟猫的网速，几十kb吧
        Rules – Performances – Simulate Modem Speeds
        2. 精确模拟，编辑CustomRules.js
        Rules – Customize Rules，找到m_SimulateModem标志位
        ```
   - 其他
     1. tcpdump
1. wireshark
   - 认识：捕获网络包，显示包信息
   - 界面
     1. 数据包列表
     1. 数据包详细信息、字节流
        - Frame：物理层
        - Ethernet II：链路层
        - Internet Protocol Version 4：网络层
        - Transmission Control Protocol：传输层，可以查看tcp报文内容
        - Hypertext Transfer Protocol：应用层
     1. 工具栏
        - capture管理
        - packet跳转控制
        - 数据包列表显示大小
     1. 过滤器：左侧小标签选择标签
        - ip
          1. ip.addr/src/dst：如`ip.addr == 10.90.100.46`
        - tcp
          1. tcp.port/srcport
        - http
          1. http.request.method：如`http.request.method == "GET"`
        - 逻辑
          1. or：`ip.src == xx or ip.src == xx`
   - 功能
     1. 统计器
        - 协议统计
        - 包长度统计
        - io统计
        - http统计
        - 等等
     1. 分析器
     1. 电话相关工具
     1. 无线相关工具
        - bluetooth
        - wlan
   - 诊断技巧
     1. `(tcp.flags.reset == 1) && (tcp.seq == 1)`：通常表示握手请求被对方拒绝()连接被拒绝
     1. `(tcp.flags.syn == 1) && (tcp.analysis.retransmission)`：对方没收到，或者对方回复的确认包丢失了的重传握手请求
### DevTool
1. 简介
 - 官方文档：https://developers.google.com/web/tools/
 - 功能：
     1. Elements ：显示／更改DOM
     1. Network ：HTTP的详细信息
     1. Sources : 调试js
     1. Timeline ：页面加载时间的详细分析，
     1. Profiles ：内存／CPU占用
     1. Resources ：本地数据编辑
     1. Audits ：分析页面加载过程，提供减少页面加载时间，提升相应速度的方案
     1. Console ：显示信息，提供shell来和开发者交互
     1. Emulation ：移动端仿真
1. Elements 功能点
 - DOM右键功能
     1. Add Attribute
     1. Force Element State ： 强制元素状态，便于调试
     1. Edit as HTML ：以HTML形式更改页面元素
     1. Copy XPath
     1. Delete Node ： 删除DOM
     1. Break On ： 设置DOM断点
 - 右侧功能区
     1. style
     1. Computed
     1. Event Listenters ：事件侦听——选择事件——右键-show function definition，定位到对应函数
     1. DOM Breakds
     1. Properties ：列出选中内容的所有属性
1. Console
 - 输入变量名，回车查看变量内容
 - Preserve log ：继续保持记录
 - 代码解析功能
 - 记录XHR数据
1. Sources
 - 文件切换与打开
 - 文件查看与搜索
 - 代码格式化：中间左下角`{}`符号
 - workspaces：直接编辑本地代码，并且可以保存
 - 新增代码片段并执行 ：Snippets——new——run
1. Network
 - 界面解析
     1. Initiator ：请求来源
     1. Parser：html解析
     1. Redirect：重定向
     1. Script：js
 - 功能
      1. 红点单步请求
      1. 小三角模拟网络环境
      1. 复制作为HAR，在其他工具中重现请求信息
      1. 过滤，重载
 - 网络电影胶片
      1. 摄像机图标，点击每个截图查看相应时间线的资源加载
 - 抓包：chrome://net-internals/#events
1. 移动端调试
 - 截取长图：三个点中有capture full-page screenshots
1. ShortCuts
 - 全局
     1. 打开DevTool： Cmd +Option+I
     1. 切换选取元素： Cmd + Shift + C
     1. 刷新页面忽略缓冲： Cmd + Shift + R
     1. 查找下一个：Cmd + G
     1. 查找上一个：Cmd + Shift + G
     1. 选中地址栏：Cmd + L
     1. 历史记录：Cmd + Y
     1. 下载记录：Cmd + Shift + J
 - 打开与查找
     1. 打开文件：Cmd + O
     1. 当前文件/面板查找： Cmd +F
     1. 所有资源查找： Cmd + Opt + F
     1. 撤销/重做： Cmd + Z/Y
     1. 打开移动模式： Cmd + Shift + M
 - DOM面板
     1. 选取dom： up / down
     1. 展开/折叠： left / right
     1. 编辑： enter / Double-click
     1. 隐藏元素： H
 - 样式侧边栏(Style Sidebar)
     1. 插入：空白处单击
     1. 编辑：single-click
     1. 选取下一个：tab
     1. 定位到属性定义处：Cmd + 单击
 - Sources 资源面板
     1. 打开文件：Cmd + O
     1. 打开当前页面方法：Cmd + Shift + O
     1. 快速文件切换：Cmd + P

     1. 暂停/回复脚本运行：Cmd + \
     1. 单步执行函数调用：Cmd + '
     1. 进入下一个函数调用：Cmd + ;
     1. 跳出当前函数：Cmd + Shift + ;
     1. 切换断点：Cmd + B，左侧边栏单击

     1. 关闭标签：Opt + W
     1. 跳转到行：Ctrl + G
     1. 注释：Cmd + /
     1. 选择下一个出现：Cmd + D，多选
     1. 撤销上一次操作：Cmd + U
 - TimeLine 面板
     1. 启动/停止记录：Cmd + E
     1. 保存timeline数据：Cmd + S
     1. 加载timeline数据：Cmd + O
 - Profiles 面板
     1. 启动/停止记录：Cmd + E
 - Console 控制台
     1. 清空：Cmd + K
     1. 可以输入执行命令，回车执行
     1. 右键查看XHR的记录
1. 实践
 - 手机端进行chrome-devtools调试 ：打开use调试——输入chrome://inspect——点击inspect
 - Elements功能体验：Edit as HTML，dom断点
 - XPath ：是一门在XML中查找信息的语言。a标签的Xpath为：/html/body/div[2]/p[1]/a，解读为：html里面body标签的第二个div标签的第一个p标签下的a标签
 - DOM事件：点击／移动到／按键／重新调整大小
 - DOM断点：监听DOM修改情况，分为：子节点修改／自身属性修改，一旦DOM被修改，断点会定位到执行的代码
 - XML：是一个浏览器接口
 - WebSocket：定义了一种API，可建立套接字连接，即持久的连接，双方可以随时发送数据
1. 全局搜索文件和关键字：ctrl+shift+F
1. 执行命令：ctrl+shift+P
1. 事件断点：Sources——右侧面板——Event Listener Breakpoints，会在事件产生时产生断点
### API
1. GraphQL：用于api接口的查询语言，client可自由获取、组合server提前定义好的数据，提高了接口的灵活性。可替代rest，玩不转，后端太重
1. APIJSON：
### brew
1. brew update：自身更新

1. brew info/search：查看包
1. brew list：查看已安装

1. brew install/uninstall go@1.16.8：安装指定版本
1. brew upgrade go：安装最新版

1. brew switch go 1.17.1：切换版本
1. brew unlink go：将当前软链移除
1. brew link go@1.12：指定新的软链

1. brew cleanup go：清理旧的升级包