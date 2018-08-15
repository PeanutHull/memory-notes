#####认识
1. 功能：
   - 解密https的请求
   - 请求替换
   - HTTP 断点调试
   - 伪造请求和响应
   - 网速设定
1. 基于.net的规则语法：Fiddler Script
#####应用
1. host配置
1. 前后端假数据接口调试
1. 线上bugfix，文件指向本地
1. 网速限制
```
1. 简单模拟，模拟猫的网速，几十kb吧
Rules – Performances – Simulate Modem Speeds
2. 精确模拟，编辑CustomRules.js
Rules – Customize Rules，找到m_SimulateModem标志位
```