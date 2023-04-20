### 认识
1. 用户的输入永远不可靠
### 攻击
1. 攻击思路
   - 收集信息
     1. 推测技术栈，灵活制定策略
        - 网站指纹(独特网站信息)
        - 搜索网站指纹和关键词词法
        - shodan查询服务器信息
   - 攻击测试
     1. 漏洞扫描
     1. SQLmap注入
     1. 注入成功，下载数据库账号和密码
     1. 密码爆破，后台进入
   - 提权
     1. 服务器提权：爆出物理路径，图片木马
     1. 挂马，一句话木马：php的如`<?php @eval(echo $_POST['password'])>`
   - 扩大成果：如内网防护低
   - 清除痕迹
1. 攻击方式
   - 输入输出验证
     1. XSS
     1. CSRF
     1. sql注入
     1. 代码注入
     1. 命令注入
     1. 信息泄露
     1. 暴力破解：穷举、字典、彩虹表(hash和明文的对应表)
     1. 目录穿越：对文件地址使用../等相对路径定位到/etc/passed等绝对路径，实现浏览、修改的目的
     1. 文件上传
        - 远程文件包含：网站会载入外部文件包含在代码里，上传恶意文件就可以执行任意脚本
     1. XFS：iframe别人的页面，使用x-frame-options或者提前检测屏蔽防范
     1. http首部注入：在响应头部插入换行和其他头，实现cookie设置、重定向、修改主体。%0D%0A代表http报文的换行符
        ```
        Location: http://example.com/?cat=101（%0D%0A ：换行符）
        Set-Cookie: SID=123456789
        %0D%0A%0D%0A                                    # 两个换行符表示空行
        任意主体
        ```
   - 设计缺陷
     1. 越权漏洞
        - 横向越权
        - 纵向越权
     1. 非授权对象引用
     1. 业务逻辑缺陷
   - 环境缺陷
     1. 框架漏洞
     1. 基础环境漏洞
   - 透明点击
1. 通信截取攻击
   - 中间人攻击：在数据被截获的情况下，如果不采用https或者用了不验证证书的话，数据都是会被获取，篡改等，其中dns可以伪装正版页面和请求，控制软件升级进一步控制：开放wifi，使用tcpdump获取数据
   - DNS劫持、域名劫持：linux使用dnsmasq配置一台DNS应用服务器。https://www.cnblogs.com/beer/p/4932146.html#baidu-baike-openwrt
   - 流量劫持
1. 攻击软件
   - 手机端：dsploit和busybox
   - 路由器：minidwep/aircrack-ng/Elcomsoft Wireless Security Auditor
   - 路由：dns篡改，dhcp查看
   - 端口：arp嗅探端口
   - 远程调试：adb(5555端口)/genymotion
#### web攻击方式
1. XSS
   - 认识：Cross Site Script 跨站脚本攻击，让网站执行一个非法脚本。如链接中附加js代码，可以获取数据和cookies，修改页面内容等
     1. 条件：非法脚本必须在浏览器中解析，顺序为HTML——URL——JS
        - HTML:浏览器解析顺序：能识别的编码符号都解码(但是只在俩个地反解：标签内容和标签属性值)
        - URL:传输要进行转义：整个URL转用 encodeURI，如果对参数的值转用 encodeURIComponent
        - Javascript特殊字符：JS的转义都采用\解决，三种类型
          1. 反斜杠：  \'\"   \\(转义反斜杠本身)
          1. 十六进制：  \x22\x27
          1. Unicode：  \u0022\u0027
     1. 解决：用适当的方法对html、js转义
   - demo：el.innerHTML = title.value，修改后：el.innerHTML = escapeHTML(title.value);
1. CSRF
   - 认识：Cross-Site Request Forgeries 跨站请求伪造，诱导别人用自己的身份发送伪造的请求来实现攻击。即站点A根据用户B的权限来处理恶意站点C所发起的请求
   - 解决方案
     1. 同源策略：检测Referer和Origin字段，非法的Reffer来源直接拒绝访问
     1. 根据当前session构造唯一token放入请求头、参数中，处理请求时校验，因为攻击者无法拿到这个token
#### sql注入
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
     1. pdo/mysqli：预处理和参数绑定，真正将sql和参数分开才管用，是最佳处理方式，根本杜绝参数变为代码的可能，注意模拟预处理
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
     1. sqlmap：sqlmap.py -u http://x.com/?id=1 --cookie "token=xxx" --batch --dbms MySQL
     1. sqlmap：sqlmap.py -r test.txt
        --headers="User-Agent:66666666666\nReferer:www.666.com"
        --is-dba            检测DBMS当前用户是否DBA
        --users             枚举数据库管理系统用户
        --passwords         枚举数据库管理系统用户密码哈希
        --privileges        枚举数据库管理系统用户的权限
        --roles             枚举数据库管理系统用户的角色
        --dbs               枚举数据库管理系统数据库
        --tables            枚举的DBMS数据库中的表
        --columns           枚举DBMS数据库表列
     1. jsky：漏洞扫描工具
1. 方法
   - 判断是否有漏洞
     1. 单双引号报错法
     1. 正确错误法：当使用and 1=1进行测试时返回正常页面而and 1=2进行测试时返回错误页面或者页面没有正常显示则说明该链接存在SQL漏洞
   - 判断常见数据库类型：不同的数据库的函数、注入方法有差异
   - 注入参数类型判断
     1. 数字型
     1. 字符型
     1. 搜索型
   - 注入类型
     1. 基于报错注入
     1. 基于时间的盲注
     1. 基于布尔的盲注：返回页面判断条件真假的注入，部分盲注可以观察不同的HTTP状态码，确定响应时间、内容的长度，并在HTTP响应中的查看HTML内容来进行确认
#### 路由器攻击
1. 密码破解：WPA2加密的用BT5或者奶瓶（Beni），先搞到握手包，然后有一个强大的字典（字典十分重要，是否能破解主要靠字典），爆破出密码。WEP加密的也用BT3或BT5抓包破解
1. 数据抓取
   - 使用路由器API和后台管理系统
   - 使用路由器漏洞
   - 刷路由器固件：路由器刷入openwrt的嵌入式linux系统(如pandorabox)————安装tcpdump————将抓包数据导入本地Wireshark中
   - 电脑冒充路由器：ARP欺骗，局域网所有数据包发送到这台路由器
   - 路由器和电脑连接同一个hub，运行抓包软件
   - Cisco路由器：路由跟踪功能
   - 主流路由器固件有 dd-wrt,tomato,openwrt三类。现在市场上的商用路由器，价格上远低于一台主机电脑，然后网络功能齐全，且带有大容量的硬盘，只要刷成openwrt之后，就可以拥有自己的私有的git服务器或者文件服务器了
1. 数据抓取
   - wifi密码破解：http://blog.csdn.net/zero9988/article/details/51866882
     1. CDlinux.iso  ：一个Linux系统，集成了wifi密码的PIN码破解软件。
     1. UltraISO：把CDlinux.iso写入U盘
     1. grub4dos：取出其中的grldr、grub.exe、menu.lst三个文件
     1. grubinst_gui2：U盘启动引导安装
     1. BOOTICE：U盘启动引导安装
   - Mac地址修改器：修改自己的MAC地址，防止被封
   - ettercap 0.8.0 (ettercap-graphical) ： ARP欺骗工具
   - wireshark：抓包工具
   - driftnet：抓图片流工具
#### 工具
1. Burpsuite
   - 认识：代理拦截器，常用攻击工具。针对包的拦截、修改。拦截——抓包——改包——重放
   - 功能分析
     1. proxy：设置代理参数，进行拦截、弃包、执行相关动作
     1. repeater：重放，可修改包、发送包
     1. intruder：爆破，配置参数，进行爆破
1. Aircrack-ng
   - 认识：网络的监视，测试，攻击和破解
1. Nmap
   - 认识：识别网络中的开放端口和漏洞、设备，`nmap -p1-1000 xx.com | grep filtered > 1000`
1. Metasploit：漏洞利用
1. Hashcat：开源密码破解工具
1. JTR：密码破解和恢复工具
1. WPScan：扫描WordPress
1. Nessus：漏洞扫描
1. MobSF：移动应用程序的安全评估
1. 搜索黑语法：Google Hacking，即高级搜索，搜索引擎都支持
   - 特性：过滤、精确、高级操作符、关键词顺序
   - 操作
     1. inurl：url中包含的字符串，
     1. intitle：网页标题包含的字符串，`intitle:index.of “Apache/1.3.27 Server at”`
     1. intext：网页正文包含的字符串
   - 实践
     1. 查询登录界面
### 防御
1. 网络防御
   - 防火墙 Firewall：网络NAT、包过滤规则、端口映射
   - 入侵检测 IDS
   - 入侵防御 IPS：数据包进行检测（深度包检测 DPI）对蠕虫、病毒、木马、拒绝服务等攻击进行查杀，增加 IPS 特征库
   - 统一威胁安全网关 (UTM)：同时具备防火墙、 防毒墙、入侵防护
   - 上网行为管理
   - 漏洞扫描
   - 异常流量清洗
   - 防止暴力破解
     1. 添加验证码、token(后台发的token)
        - 验证码：识别字符、识别特殊颜色、逻辑计算性、图像识别(如12306的)、手机验证码
1. 审计范围
   - 网络安全：行为审计、内容审计、行为报警、行为控制，提供完整的上网记录，便于信息追踪、系统安全管理和风险防范
   - 日志
   - 运维安全审计：堡垒机
   - 数据库安全
1. 工具
   - 分析：火绒剑（行为分析）、IDA 7.6（反汇编）、Exeinfo PE（PE文件分析）
   - 防御
     1. libModSecurity：是入侵侦测与防护引擎，用于web服务器，可以为nginx配置WAF
1. 部署方式
   - 旁路部署：通过在核心交换机上设置镜像口，将镜像数据发送到审计设备
#### 加密方式
1. 认识
   - 没有绝对安全的加密，越复杂、越难破解的加密算法需要的计算时间也越长
1. 摘要算法
   - 特点
     1. 只要源文本不同，计算得到的结果，必然不同（或者说机会很少），哈希碰撞
     1. 无法从结果反推出源数据
   - 分类
     1. MD5：Message-Digest Algorithm 5，消息摘要算法，单向加密
     1. SHA：Secure Hash Algorithm 安全散列算法，单向加密，SHA-256、SHA-1
     1. HMAC：把key混入计算哈希的过程，对所有哈希算法都通用
1. 对称加密算法
   - DES：Data Encryption Standard，对称加密标准，被AES替代
   - AES
     1. 认识：Advanced Encryption Standard，高级加密标准，又称Rijndael加密法，美国联邦政府采用的一种区块加密标准。AES-128、AES-192、AES-256
        - 是基于数据块的加密方式，即分组密码（区别于基于比特位的流密码）
        - 密钥长度（位）：128、192、256
        - CBC和CTR安全性最高且最常用
     1. 加密模式
        - CBC：电码本
        - ECB：密码分组链接
        - CTR：计算器
        - OCF：密码反馈
        - CFB：输出反馈
    - IDEA、RC2/RC4
1. 非对称加密算法
   - RSA：非对称加密，分公钥和私钥，计算开销比aes大。ssh是先rsa加密，再aes加密传数据
   - DSA
   - ECDSA：椭圆曲线签名算法，使用的椭圆曲线是一个已经定义好的标准曲线secp256k1
### 最佳实践
1. 视频安全方案
   - 访问限制：黑白名单的方式
     1. Referer、User-Agent，安全性低，易伪造
     1. IP：不适合大量C端用户的分发
   - 播放鉴权：进一步的播放控制
     1. url鉴权：生成动态变化的加密URL，可进行URL时效控制，自定义过期时间。防止固定不变的播放地址导致视频内容被持久的非法扩散传播，且无法有效遏制
     1. 远程鉴权：视频服务透传业务请求信息给客户自定义鉴权中心来判断是否进行播放，如业务方可将其用户的登录Cookie或UUID等信息隐藏于播放请求中，进而透传到自己的鉴权中心以判定是否为合法用户。需要客户自己开发和部署鉴权中心
   - 视频加密：防止拿到视频合法的防盗链播放URL，将视频下载到本地进行二次分发，如适用于付费观看模式
     1. 私有加密：是对视频本身加密，需要播放器具有相匹配的解密能力
        - 每个媒体文件拥有独立的加密钥匙，能有效避免采用单一密钥时，一个密钥的泄露引起大范围的安全问题
        - 提供信封加密机制密文Key+明文Key，仅密文Key入库，明文Key不落存储，所有过程只在内存中，用完即销毁
     1. HLS标准加密：是HLS规定的通用加密方案，使用AES_128对视频内容本身进行加密，同时能支持所有的HLS播放器，用户可选择使用自研或开源的播放器。比私有加密灵活性更好，但安全性更低
        - 用户需搭建密钥管理服务，提供密钥生成（用于转码时对视频内容进行加密）和解密服务（用于播放时获取解密密钥）
        - 用户需提供令牌颁发服务，用于验证播放端的身份，避免解密密钥被非法获取
        - 播放器和云端传输明文Key，容易被窃取
     1. 商业DRM：高端的视频节目，需要满足内容版权和提供商的安全要求，如好莱坞、华纳等，需支付额外的License费用。安全等级：商业DRM>私有加密>HLS标准加密
   - 安全下载
     1. 离线播放：将视频文件通过私钥进行二次加密，下载后在播放器SDK内部完成视频解密，保障离线视频仅能通过唯一应用（安全下载中设定的bundleID或keystore）进行安全播放的一种下载方式
        - 不需要联网，可离线解密、播放，且只能由该应用播放
        - 私钥文件加密后存储，有效防止被窃取
        - 每个视频文件在每个应用上都有独立的私钥，即便单个泄露也不会影响其它视频