1. web攻击方式
   - XSS：Cross Site Script，跨站请求攻击，链接中附加js代码，可以获取数据和cookies，修改页面内容
   - CSRF：Cross-Site Request Forgeries，跨站点请求伪造，诱导点击，或者直接触发访问，利用别人的认证id实现操作，使用同源策略防范
   - XFS：iframe别人的页面，使用x-frame-options或者提前检测屏蔽防范
   - http首部注入：在响应头部插入换行和其他头，实现cookie设置、重定向、修改主体。%0D%0A代表http报文的换行符
    ```
    Location: http://example.com/?cat=101（%0D%0A ：换行符）
    Set-Cookie: SID=123456789
    %0D%0A%0D%0A                                    # 两个换行符表示空行
    任意主体
    ```
   - 透明点击
   - sql注入
   - os命令注入：在可以执行shell脚本的地方注入
   - 目录遍历：对文件地址使用../等相对路径定位到/etc/passed等绝对路径，实现浏览、修改的目的
   - 远程文件包含：网站会载入外部文件包含在代码里，上传恶意文件就可以执行任意脚本
   - 密码破解：穷举、字典、彩虹表(hash和明文的对应表)
1. 通信截取方式
   - 中间人攻击：在数据被截获的情况下，如果不采用https或者用了不验证证书的话，数据都是会被获取，篡改等，其中dns可以伪装正版页面和请求，控制软件升级的升级包进一步控制
     1. 开放wifi，使用tcpdump获取数据
   - 挂马
1. 网站信息获取
   - 网站指纹(独特网站信息)
   - 搜索网站指纹和关键词词法
   - shodan查询服务器信息
   - 漏洞扫描
   - SQLmap注入
   - 注入成功，下载数据库账号和密码
   - 密码爆破，后台进入
   - 服务器提权：爆出物理路径，图片木马
1. 路由器密码破解：WPA2加密的用BT5或者奶瓶（Beni），先搞到握手包，然后要有一个强大的字典（字典十分重要，是否能破解主要靠字典），然后爆破出密码。WEP加密的也用BT3或BT5抓包破解
1. 路由器数据抓取
   - 使用路由器API和后台管理系统
   - 使用路由器漏洞
   - 刷路由器固件：路由器刷入openwrt的嵌入式linux系统(如pandorabox)————安装tcpdump————将抓包数据导入本地Wireshark中
   - 电脑冒充路由器：ARP欺骗，局域网所有数据包发送到这台路由器
   - 路由器和电脑连接同一个hub，运行抓包软件
   - Cisco路由器：路由跟踪功能
   - 主流路由器固件有 dd-wrt,tomato,openwrt三类。现在市场上的商用路由器，价格上远低于一台主机电脑，然后网络功能齐全，且带有大容量的硬盘，只要刷成openwrt之后，就可以拥有自己的私有的git服务器或者文件服务器了
1. 路由器数据抓取
   - wifi密码破解：http://blog.csdn.net/zero9988/article/details/51866882
     1. CDlinux.iso  ：一个Linux系统，集成了wifi密码的PIN码破解软件。
     1. UltraISO：把CDlinux.iso写入U盘 
     1. grub4dos：取出其中的grldr、grub.exe、menu.lst三个文件
     1. grubinst_gui2：U盘启动引导安装
     1. BOOTICE：U盘启动引导安装
   - Mac地址修改器：修改自己的MAC地址，防止被封
   - ettercap 0.8.0 (ettercap-graphical)  ： ARP欺骗工具
   - wireshark：抓包工具
   - driftnet：抓图片流工具
1. DNS劫持：linux使用dnsmasq配置一台DNS应用服务器。https://www.cnblogs.com/beer/p/4932146.html#baidu-baike-openwrt
1. 手机端路由器攻击软件：dsploit和busybox
路由器：minidwep/aircrack-ng/Elcomsoft Wireless Security Auditor
路由：dns篡改，dhcp查看
端口：arp嗅探端口
远程调试：adb(5555端口)/genymotion
### sql注入
1. 理解：构建特殊输入，数据变成了代码被执行
   - 不要相信用户输入
   - 不同网站防护情况不同注入的效果是不同的，不能一条指令走到黑，需要调整注入的参数，例如是否加长时间延迟、是否采用随机头部、是否加大注入级别
1. 产生和阻止
   - 类型
     1. 配置
        - 密码强加密，多类型组合无规律长字符串，阻止爆破
        - 最小化细分权限
        - ssl加密连接
     1. 类型
        - 是什么类型就转为什么类型：过滤非法字符
     1. 转义
        - 特殊符号：' " \ NULL
        - url编码
        - 进制转换
     1. 执行
     1. 错误
        - 关闭错误提示（防止得到更多信息）
   - 处理：要么数据转义和过滤，要么让mysql预处理
     1. 数据转义
        - intval、floatval
        - addcslashes、real_escape_string：或开启magic_quotes_gpc，like注入
        - mysql_escape_string、mysql_real_escape_string
     1. pdo/mysqli预处理、参数绑定：注意模拟预处理，真正将sql和参数分开才管用，最佳处理方式，根本杜绝参数变为代码的可能
        - bindParam、execute(真正将参数传递给mysql)
1. 注入
   - 类型
     1. 强制产生错误
     1. 转义字符
        - `/*!12345select*//**/from`
        - `/*!50001select*/from`
        - `Select/**/column_name/**/from`
        - `/*!/*!select*/column_name/*!/*!from*/`
        - `空格用/*!*/代替`
        - `%53elect/*!1,2,schema_name%0aFROM`
        - `Get+Post，编码，超长内容等`
        - `%23%0a`：绕过正则，空格payload
        - `0x12312`：十六进制
        - 避开过滤
        - `xx'#`：sql注释，后边sql不执行，或--
        - `xx' OR 1='1`：根据sql不同，可为)，"动态添加，可用于判断有无注入点
        - `UNION SELECT * `：
        - `sleep(3)`
        - 动态查询。截断、url编码、空字节的使用、大小写变种、嵌套剥离表达式
     1. 推断
        - 查看相关字段和表名
        - 根据一点信息暴力跑
        - 经验、社工
     1. 二次注入：写入数据库后读取时触发
   - 常用
     1. 查看表名：`SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'database';`
     1. 查看字段：`SHOW columns FROM table`
     1. 爆出错误：`SELECT id FROM keyword WHERE id=1 UNION SELECT 1 FROM (SELECT COUNT(*),CONCAT(FLOOR(RAND(0)*2),(SELECT CONCAT(0x5f,DATABASE(),0x5f,USER(),0x5f,VERSION())))a FROM information_schema.tables GROUP BY a)b--`
   - 工具
     1. sqlmap：sqlmap.py -u http://x.com/?id=1 --dbs --users)
     1. jsky：漏洞扫描工具
### xss扫描器
1. XSS与防范
 - 概念：跨站脚本(Cross Site Script)：让某网站执行一个非法脚本。
 - 发生条件：非法脚本必须在浏览器中解析，点在HTML、URL、javascript，顺序为HTML——URL——JS
 - HTML:浏览器解析顺序：能识别的编码符号都解码(但是只在俩个地反解：标签内容和标签属性值)
 - URL:传输要进行转义：整个URL转用 encodeURI，如果对参数的值转用 encodeURIComponent
 - Javascript特殊字符：JS的转义都采用\解决，三种类型：
      - 直接反斜杠：  \'\"   \\(转义反斜杠本身)
      - 十六进制：  \x22\x27
      - Unicode：  \u0022\u0027
 - 举例：
```
危险写法，这里输入来自用户，用户输入不可靠：
el.innerHTML = title.value;
修改后：
el.innerHTML = escapeHTML(title.value);
```
 - 阻止办法：用适当的方法对html、js转义