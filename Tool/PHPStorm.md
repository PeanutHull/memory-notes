####概述
1. 目的：提高用户效率，理解用户代码，快速导航，即时错误检查
1. 功能
    1. 编辑器功能
 - 代码补全
 -  快速导航  - 智能重复编码检测器
    1. 附加功能
 - 可视化phpUnit测试运行
 - 自动生成phpDoc的注释
 - php和js、html设置断点
 - git、svn、数据库的支持
 - 生成类的继承关系图
######功能
1. 全局搜索：两次shift
1. 项目列表：alt+1
1. 方法列表：alt+7
1. 数据库显示：ctri+tab+0
1. 数据库隐藏：ctrl+esc
#####快捷键
1. 编辑器操作
```
Ctrl+反引号           快速切换皮肤。
双Alt                      显示其他功能面板
```
1. 文件操作
```
Ctrl+E               打开最近关闭的文件
Ctrl+Shift+O     打开文件
Ctrl+O               打开类
```
1. 代码操作
```
----类、整体----
alt+↑或↓              方法间跳转
ctrl+b/ctrl+click   追踪类或方法
ctrl+q                   查看方法、类、变量的类中的信息 ----常用----
Ctrl+F                  查找
Ctrl+Shift+F         全文件搜索 Ctrl+R                  替换
Ctrl+Shift+V         选择需要粘贴的最近内容
Ctrl+Alt+ ←→      操作动作前进/回退
Ctrl+W                 依次选择代码
Ctrl+空格             代码补全/提示
Ctrl+O                  打开类 ----其他----
command + /       行注释
Ctrl+Shift + /        块注释
Ctrl+Shift+u         切换大小写
Ctrl+g                  选取多个
Ctrl+上/下            方法间切换
Command+[/]      切换到代码块开头/结尾
Command+j        查看快捷输入代码
```
1. 前端操作
```
HTML标签+右键+Show Applied Styles For Tag  查看标签应用的样式
```
1. 未理解
```
1.alt+f7寻找类、方法、变量
1.看类或方法的符号：ctrl+q
1.ctrl+F12在当前类文件里快速查找方法，回车选中
1.shift+f6快速重命名所有类，回车确定
1.tab选中当前代码提示
1.alt+f1查看dom样式结构
1.shift+esc切换编辑页面和工具栏，f12返回最后一个工具栏
1.Ctrl+Alt+V
1.Ctrl+P
1.Ctrl+Shift+Backspace
1.Ctrl+Shift+F7   Shift+F3   F3
1.Ctrl+Alt+Shift+N
1.Alt+Shift+C
1.Alt+Shift+F10
1.Ctrl+Shift+I
1.Shift+F6
1.Alt+Home   Alt+9
1.Ctrl+Alt+F7
1.Ctrl+Alt+T
1.Ctrl+Shift+A
1.Alt+Enter
1.Ctrl+Shift+n
1.shift+click
1.ctrl+k
1.alt+q
1.F2/Shift+F2
1.Ctrl+Shift+J
1.ctrl+H
```
#####编辑器设置
1. 导出设置方法：File -> Export Settings，导入设置方法：File -> Import Settings
1. 去掉波浪线
settings -> Editor -> Colors & Fonts -> General -> TYPO->Effects
1. 添加插件
settings->editor ->plugins->browse repositories -> 插件内容
1. 编辑的文件加*标识
settings -> editor -> editor tabs -> 勾选 mark modifed tabs
#####其他功能
1. 利用xdebug单步调试，入门级
 - 配置步骤
```
1.开启php的xdebug模块
2.配置phpstorm来挂接xdebug
3.使用调试功能
```
 - 开启xdebug
```
1.配置php.ini
引入xdebug文件              zend_extension="D:\Program Files\phpStudy\php54n\ext\xdebug.dll"
是否允许远程终端，必须开启    xdebug.remote_enable=ON
调试器关键字                xdebug.idekey="PHPSTORM"
指定远程调试接口             xdebug.remote_port = 8998
2.检测xdebug是否开启
phpinfo(); 查找xdebug
```
 - 配置PhpStorm
```
编辑器右上角———Edit Configurations
添加PHP Web Application
添加————应用名称、配置服务器信息、选择默认浏览器
服务器配置：名称、主机地址
调试开始的url
```
 - 使用调试功能
```
打断点—>点击臭虫—>点击浏览器页面触发断点—>自动跳转回PhpStorm—>查看携带的数据（调试的目的）—>可按步执行查找问题点—>点击运行（或者F5）—>浏览器页面继续执行—>调试完成
```
 - 总结
```
Xdebug可以用来跟踪，调试和分析PHP程序的运行状况。本文重点是调试。Xdebug本身拥有大量内置函数，可以分析php程序性能瓶颈等问题。关于其高级使用方法还有很多。灵活使用Xdebug，对提高调试效率会有很大帮助。原文地址：http://blog.csdn.net/knight_quan/article/details/51953269
```
 - xdebug函数
```
xdebug_call_class()      // 取文件名，行号，函数名
xdebug_get_headers()     // header信息
xdebug_time_index()      // 执行时间
```
