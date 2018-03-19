### php
1. 认识：Hypertext Preprocessor/personal home pages/超文本预处理器，开源、用于产生动态网页的可嵌入HTML中的脚本语言，适合web开发
1. php模式：<?php ?>
### 语法
1. 数据类型
   - 8种原始数据类型
     1. 标量：boolean、integer、float、string
     1. 复合：array、object
     1. 特殊：resource、null
   - 伪类型：mixed(所有)、number(int，float)、callback(V5.4)
1. 变量
   - 普通变量：区分大小写，可变变量 $$a
     1. 赋值：$xx=xx
     1. 传址赋值：$xx=&$xx
   - 静态变量：只存在于函数作用域内，只存活在栈中，再次调用函数会保留，`static $n = 1;`
   - 超全局变量
     1. $_ENV
     1. $_REQUEST：包含GET、POST、COOKIE 和 FILE 的数据
     1. $_POST：只包含application/x-www-form-urlencoded和multipart/form-data两种类型的post数据
     1. $_GET
     1. $_COOKIE
     1. $_SESSION
     1. $_FILES
     1. $GLOBALS：包含全部变量的全局组合数组
   - 特殊保留变量
     1. $this
     1. $_SERVER：php预定义变量，包含服务器信息的数组，由web服务器创建，包含请求头、路径、脚本位置，具体内容会在CGI 1.1规范中说明
1. 常量
   - 理解：只能是标量，一旦定义不能修改/删除，可以不用$。常量的范围是全局的，不用管作用区域就可以在脚本的任何地方访问常量
   - 分类
     1. 用户常量
        - 全局常量：`define('name', 'value')`，任意地方定义和访问，不能在类中，大小写敏感，通常大写
        - 类常量：`const name='value'`，只能在类中定义常量，不能在条件语句中，const5.3之后也可在类外定义，是语言结构，比较快，和static不同的是没有权限限定符和不能修改值，7.1中可以加限定符，使用：self::xxx、className::xxx
        - 特点
          1. const只接受标量，define可采用任何表达式。const是一个语言结构。而define是一个函数，const在编译时比define快很多
          1. const定义的常量大小写敏感，define可通过参数指定大小写是否敏感
     1. 系统常量(预定义常量)
        - 整体
          1. PHP_VERSION
          1. PHP_OS
          1. PHP_SAPI ———— 判断是用命令行/浏览器执行的，PHP_SAPI=='cli'表示命令行
          1. PHP_INT_MAX
          1. PHP_INT_SIZE
          1. TRUE
          1. FALSE
        - 错误
          1. E_ERROR ———— 最近的错误处
          1. E_WARNING
          1. E_PARSE ———— 剖析语法有潜在问题处
          1. E_NOTICE
        - 符号
          1. PHP_EOL ———— 系统换行符，Windows是（\r\n），Linux是（/n），MAC是（\r）
          1. DIRECTORY_SEPARATOR ———— 系统目录分隔符，Windows是反斜线（\），Linux是斜线（/）
          1. PATH_SEPARATOR ———— 多路径间分隔符，Windows是反斜线（;），Linux是斜线（:）
1. 运算符
   - 计算：%、++$a、$a--
   - 比较：==等于、===全等于，类型相同、!=或<>不等于
   - 赋值：=
   - 逻辑：and/&&，or/||，!
   - 三元表达式：表达式 ? 值1 : 值2
   - 字符串连接符：.
1. 流程控制：选择if，循环while/for/switch-case，break离开循环，continue跳过本次循环进入下次
### 面向对象
1. 理解
   - 面向过程：优点：用什么功能就编写什么函数，注重实现细节。缺点：数据管理较混乱集中在函数方面
   - 面向对象：万物皆对象，将构成问题的事务分解到各个对象上，建立对象不为完成特定工作，而是为描述某事务在解决问题中的行为，更符合人思维习惯，代码重用性高，可扩展性好。是一种对现实世界理解和抽象的方法，事物抽象成对象，关系抽象成类、继承
1. 特性
   - 封装：成员方法和成员属性封装到类中，限定成员访问权限，数据被保护在内部
   - 继承：类之间的关系，让类能够具有可扩展性
   - 多态：重新改变类的属性或行为，多态就是把子类对象赋值给父类引用，然后调用父类的方法，去执行子类覆盖父类的那个方法。php多态比较弱。其实就是对象类型的变量。把对象赋给变量
1. 组成
   - 接口：接口是特殊的抽象类，所有的方法都是public的抽象方法，所有变量都是常量，可多继承，接口没有构造函数
   - 抽象类：只要包含抽象方法的类，不能实例化只能继承，可定义普通方法和构造函数，抽象方法：抽象方法不能定义具体的实现，不能有主体即{}，子类必须全部重写父类抽象方法，访问控制只能更宽泛
   - 类：具有相同属性和方法的对象集合，只能实例化。类名首字母大写，一个文件可以写多个，规范就一个。可实现多接口，只能继承一个抽象类
   - 对象：包含属性、方法，$this是当前对象的引用
1. 类
   - 魔术常量
    ```php
    __NAMESPACE__       // 当前命名空间名
    __CLASS__           // 类名
    __METHOD__          // 方法名
    __LINE__    
    __FILE__            // 当前文件的完整路径和文件名
    __DIR__
    __FUNCTION__    
    __TRAIT__           // 5.4新增，返回trait被定义时的名字
    ```
   - 魔术变量
   - 魔术方法：13个
    ```php
    __autoload()            // 载入：实例化一个对象时，如果对应的类不存在，则该方法被调用
    __get/set()             // 属性：拦截器，外部读取、设置属性时自动调用
    __isset/unset()         // 检测/删除一个对象时调用
    __call()                // 方法：调用不存在方法时自动调用，可以屏蔽错误
    __construct()           // 构造方法：实例化类时自动被调用，执行类初始化工作。可传参，无返回值，存在父子级覆盖问题
    __destruct()            // 析构方法：对象在内存中销毁时自动执行，无参。如最后一个类的对象赋值NULL时触发
    __sleep()               // serialize之前调用，若对象比较大，想删减一点东东再序列化，可考虑一下此函数
    __wakeup()              // unserialize时被调用，做些对象的初始化工作
    __clone()               // 克隆：对象时被调用。如：$t=new Test();$t1=clone $t; 
    __toString()            // 打印：一个对象的时被调用。如echo/print，必须有返回值
    ```
   - 特点：方法名和类名相同即自动执行，类似__construct()
1. 静态类：速度快，效率高，直接加载到内存，公用性强，使用时不生成对象就执行，不属于对象，不依赖对象调用，静态方法只能访问静态属性
   - 静态变量：类变量/成员属性，属于类
   - 静态方法：类方法/成员方法，静态方法不能被非静态方法重写
1. 关键字
   - static：修饰静态变量、静态方法
   - self/parent：对当前/父类的引用
   - final：标记类不能被继承，方法不能被覆写，不能用于变量
   - abstract：修饰抽象类和抽象方法
   - extends：继承
   - interface
   - implements
### 应用
1. 会话控制：cookie、session
1. 日期时间
   - time        时间戳
   - date        格式化时间/日期
   - strtotime   字符串转为时间戳，啥都能转
   - mktime      日期转为时间戳
1. 文件/目录
   - 获取文件信息
     1. mime_content_type：类型
     1. stat/filesize：大小，在部分x86系统上读取大于2GB文件会报错
     1. file_get_contents：内容
   - 写入文件
     1. file_put_content
     1. fopen,fwrite,fclose
   - 创建目录：mkdir
   - 查看目录
     1. glob：查找文件
     1. scandir：列出目录
     1. dirname(dirname(__FILE__))：访问上上级目录
   - 判断：is_file、is_dir、file_exists。后一速度最慢
1. 网络/IO
   - socket：socket类遵循tcp/ip协议，封装大量的内部通讯方法，用于创建主机端与客户端的数据通讯，就是listen/accept/send/write等几个基本操作，相关函数：fopen/fsockopen/stream_socket_server/stream_socket_client
   - stream：流，补充文件形式的其他数据源的处理能力，经常和socket联合使用
   - php协议：php://stdin/stdout/stderr/input/output/fd/filter：`file_get_contents("php://input")`：获取不同content-type下的post数据，type为multipart/form-data时无效
1. 编解码
    ```php
    // web传输
    urlencode/urldecode             // 转换-_.，空格转为+。rawencode把空格转为%20
    http_build_query                // 转换数组
    // web展示
    strip_tags                      // 去掉所有html/php的标记字符
    htmlspecialcharshtmlentities    // 四个特殊字符("&<>)转为实体，如"转为&quot;
    // 转义
    addslashes/stripslashes         // '"\NULL添加反斜线转义
    stripslashes                    // 清除转义，两个留一个，一个就去除
    // 其他
    base64_encode                   // 可用于邮件传输，但是处理后有/+=等危险字符，url编码中+代表空格
    json                            // 默认将中文转为unicode，使用`json_encode($message, JSON_UNESCAPED_UNICODE);`保留中文
    serialize()/unserialize()
    gzcompress()/gzuncompress()
    ```
1. 加密
   sha1：用于校验文件完整性，是否被篡改，可生成一个160位校验值，不可逆
1. 正则
   - 匹配手机号：`preg_match("/^(1([34578]))\d{9}$/", $mobile)`
   - 4到6位数字：`preg_match("/^\d{4,6}$/", $code)`
1. 异常
   - 抛出异常：`throw new Exception();`
   - try：`try {} catch (Exception $e) {}`
### 运维
1. PHP安装
   - linux
     1. 源码安装
        - 安装php：开启fpm等配置
        - 启动fpm：复制fpm配置文件，修改用户和权限组，启动 `/usr/local/php/sbin/php-fpm`
        - 安装nginx
        - nginx配置fpm：添加fastcgi支持
   - window
     1. apache+php
        - 安装vc_redist.x64.exe和vcredist_x64
        - apache配置修改
          1. 将c:/Apache24全部替换成c:/http/Apache24
          1. 在#LoadModule xml2enc_module modules/mod_xml2enc.so下面添加
             - LoadModule php5_module "C:/http/php/php5apache2_4.dll"
             - AddType application/x-httpd-php .php .html .htm
             - PHPIniDir "C:/http/php"
          1. 将DirectoryIndex index.html改为DirectoryIndex index.php index.html
          1. 将ServerName www.example.com:80的注释去掉
        - php环境配置
          1. 把php文件目录下的libeay32.dll/php5ts.dll/ssleay32.dll和ext文件中的php_curl.dll复制到windows/system32下
          1. 把C:/http/php和C:/http/php/ext加入环境变量
        - php配置
          1. 将php.ini-development在当前目录复制一份，保存为php.ini
          1. extension_dir 指向c://http/php/ext
          1. extension=php_curl.dll的分号去掉
          1. date.timezone = 修改为date.timezone = Asia/Shanghai，去掉分号
        - 启动php：双击C://http/php/php.exe
        - 启动apache
          1. httpd.exe -k install
          1. httpd.exe -k start
1. PHP依赖：Composer，依赖管理工具
   - 命令
     1. composer create-project                       // 创建Composer项目
     1. composer init                                 // 初始化项目依赖，自动生成json文件
     1. composer install/update (foo/bar:1.0.0)       // 安装/更新所有/单个依赖
   - 参数
     1. --prefer-dist：用于install/update，强制下载源代码，在修改文件后更新文件会给出提示
     1. --prefer-source
     1. --lock：仅更新锁文件，用于update
   - 功能
     1. 自动加载：composer自动会生成一个vender/autoload.php，载入这个文件后，直接new，就会自动载入。在composer.json的autoload字段中增加自己的autoloader
        ```
        "autoload": {                       
            "psr-4": {"Acme\\": "src/"}     // 注册一个PSR-4 autoloader到Acme命名空间
        }
        ```
     1. 为生产环境做准备：`composer dump-autoload --optimize`
   - 运维
     1. composer/php composer.phar -V
     1. composer self-update
     1. 考虑缓存，dist包优先？？？
1. PHP配置：php.ini
1. PHP扩展安装
### wiki
1. php运行模式
   - CGI
     1. 理解：通用网关接口，外部应用程序和web服务器的接口标准，允许web服务器执行外部程序，并将输出发回web服务器。早期动态网页处理程序一次只能处理一个请求。跨平台性极佳，性能低下
     1. 原理
        - 请求——创建子进程——处理，即fork-and-execute模式，请求数=cgi子进程数，子进程的反复加载是cgi性能低下的原因，会大量占用cpu和内存
        - 每个web请求都必须重新解析php.ini，重新载入全部扩展，初始化全部数据结构
   - FastCGI
     1. 理解：类似常驻型cgi，先启一个master，cgi解释器保持在内存中并接受fastcgi的调度，类似线程池的技术特性
     1. 原理
        - web服务器载入fastcgi进程管理器
        - fastcgi自身初始化，启动多个cgi解释器进程等待调用
        - 请求到达时，fastcgi选择并连接到一个cgi解释器
     1. 特点
        - 所有配置只在进程启动时加载一次
        - PHP死掉不会带死apache，而且会立即启动一个新的php进程
        - fastcgi是适用高并发场景的，对web服务器不挑可以自由更换
        - php5.3.29之后自带fpm，之前需要另外加载模块。PHP-FPM：fastcgi Process Manager，fastcgi进程管理器，有效控制内存、进程，平滑重载php配置，比spawn-fcgi更优秀，官方收录。fastcgi是一个协议，php-fpm实现了这个协议
   - Module
     1. 理解：将php集成到web服务器，以同一个进程运行。php作为apache的模块，预先生成多个进程副本驻留内存，一旦请求出现就立即响应，省去创建子进程的延迟，处理完成后不退出，等待下次请求
   - ISAPI
     1. 理解：微软提供的一套面向Internet服务的API接口，ISAPI的dll被请求激活后常驻内存，不停接受请求。dll和web服务器处于同一个进程中，5.3舍弃
     1. 特点：微软的排他性，只能在windows运行、效率高于CGI、稳定性不好，php出错，IIS或apache也死掉
   - Cli
     1. php_sapi_name：运行环境检测
     1. 参数
        - php -h
        - php -m // 查看安装的扩展
        - php -S 127.0.0.1:80 -t /www /www/index.php // 启动一个单线程http服务器，可以用于开发和测试
   - 流行的php三种使用模式
     1. nginx + php-fpm
     1. apache + mod_php5
     1. lighttp + spawn-fcgi
1. ts/nts
   - 查看：phpinfo()————Thread Safety
   - 分类   
     1. Thread Safe：线程安全，执行时会进行线程安全检查，防止有新要求就启动新线程的cgi执行方式耗尽系统资源
        - ISAPI执行方式以DLL动态库的形式使用，在处理完一个用户请求后不会马上消失，需要进行线程安全检查
     1. Non Thread Safe：非线程安全，执行时不进行线程安全检查
        - FastCGI执行方式以单一线程来执行操作，不需要检查，效率更高
1. 版本历史
   - 5.3
     1. 增加命名空间
   - 5.4
     1. <?= 标签取代 echo
     1. [] 代替 array()
