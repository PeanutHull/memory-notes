### php
1. 认识：Hypertext Preprocessor/personal home pages/超文本预处理器，开源、用于产生动态网页的可嵌入HTML中的脚本语言，适合web开发。web是IO密集型，瓶颈在mysql，体现不出php性能劣势，密集计算方面比C/C++差几十倍
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
   - 超全局变量：也是数组
     1. $GLOBALS：包含全部变量的全局组合数组
     1. $_ENV
     1. $_REQUEST：包含GET、POST、COOKIE 和 FILE 的数据
     1. $_POST：只包含application/x-www-form-urlencoded和multipart/form-data两种类型的post数据
     1. $_GET
     1. $_COOKIE
     1. $_SESSION
     1. $_FILES
   - 特殊保留变量
     1. $this
     1. $_SERVER：php预定义变量，包含服务器信息的数组，由web服务器创建，包含请求头、路径、脚本位置，具体内容会在CGI 1.1规范中说明
   - 作用域
     1. 全局/局部变量：全局变量不能在函数体内使用，需要用global关键字和$GLOBALS['']数组来引用，并且修改也对全局变量生效，对于require和include进来的相当于写了一个文件中
     1. 静态变量：只在局部函数中存在和有效，程序执行离开时值不会消失，可以记录赋值次数用于终止递归
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
1. 函数
   - 参数的传递和引用传递：引用传递可以修改其值
   - 返回值和引用返回：只能返回一个值，引用返回`&func()`会绑定函数的返回值
   - 系统内置函数
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
   - 对象：包含属性、方法，$this是当前对象的引用。对象本身是传址赋值，不像变量赋值时会空间复制
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
   - 后期静态绑定：用于继承范围内引用静态调用的类，就是用static表示引用当前使用的类，v5.3增加
    ```php
    class A {
        public static function who() { echo __CLASS__; }
        public static function test() {
            self::who();                                        // 返回A
            static::who();                                      // 返回B，后期静态绑定
        }
    }

    class B extends A {
        public static function who() { echo __CLASS__; }
    }

    B::test();

    new self();                         // 返回父类
    new static();                       // 返回当前的类
    $class = new static($user);         // 返回一个对象，可以使用当前类的方法，同时类的成员包括$user中的数据
    ```
1. 关键字
   - static：修饰静态变量、静态方法
   - self/parent：对当前/父类的引用
   - final：标记类不能被继承，方法不能被覆写，不能用于变量
   - abstract：修饰抽象类和抽象方法
   - extends：继承
   - interface
   - implements
### 应用
1. 会话控制
   - cookie：$_COOKIE，setcookie()/unset/过期
   - session：$_SESSION，session由服务器存储，基于cookie，信息安全，占用服务器资源，分布式问题
     1. 使用
        - session_start();
        - session_destory();
     1. 传递SessionID
        - session_name()
        - session_id()
        - 
     1. 存储：session_set_save_handler()，默认文件形式，用MySQL、Redis等
     1. 配置
        ```php
        session.auto_start
        session.cookie_domain
        session.cookie_lifetime
        session.cookie_path
        session.name
        session.save_path
        session.save_handler
        session.use_cookies
        session.use_trans_sid
        session.gc_probability
        session.gc_divisor
        session.gc_maxlifetime
        ```
1. 日期时间
   - time        时间戳
   - date        格式化时间/日期
   - strtotime   字符串转为时间戳，啥都能转
   - mktime      日期转为时间戳
1. 文件/目录
   - 文件
     1. filetype/mime_content_type：类型
     1. filesize/stat：大小，在部分x86系统上读取大于2GB文件会报错
     1. 文件属性：file_exists、is_readable、is_writable、is_executable、filectime、fileatime、filemtime
     1. 读取内容
        - file_get_contents
        - fopen：打开模式：r/r+、w/w+、a/a+、x/x+、b、t，各种头/尾、追加/覆盖写入，二进制文件打开等
        - fread/fgets/fgetc：一行、一个字符
     1. 写入内容
        - file_put_content
        - fwrite,fclose
     1. 复制：copy
     1. 删除：unlink
     1. 文件截取：ftruncate
     1. 文件锁：flock
     1. 文件指针：ftell、fseek、rewind
   - 目录
     1. 查看
        - pathinfo
        - basename
        - dirname(dirname(__FILE__))：访问上上级目录
     1. 读取：opendir、readdir、closedir、rewinddir、scandir
     1. 创建：mkdir
     1. 删除空目录：rmdir
   - 磁盘：disk_free_space、disk_total_space
   - 判断：is_file、is_dir
   - 查找：glob
   - 重命名/移动：rename
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
1. 正则：用于分割、查找、匹配、替换
   - 组成
     1. 分隔符：/斜线 #hash符号 ~取反符号
     1. 通用原子：\d\D\w\W\s\S
     1. 元字符：. * ? ^ $ + {n} {n,} {n,m} [] () [^] | [-]
     1. 模式修正符：i m e s U x A D u(用于utf8模式下的匹配)
   - 特性
     1. 后向引用：一个字符类外面，反斜线紧跟一个大于0的数字就是之前出现的某个捕获组的后向引用
        ```php
        $str = '<b>abc</b>'
        $pattern = '/<b>(.*)<\/b>/';
        preg_replace($pattern, '\\1', $str);        // 用\\1后向引用括号中匹配到的
        ```
     1. 贪婪模式
        ```php
        $str = '<b>abc</b><b>bcd</b>'
        $pattern = '/<b>.*?<\/b>/';                 // ?取消贪婪模式，要不一直往后匹配
        $pattern = '/<b>.*?<\/b>/U';                // U取消
        preg_replace_all($pattern, '\\1', $str);
        ```
     1. 断言：分为前瞻断言/后瞻断言，正面断言(?<=)/消极断言(?<!)
   - 步骤
     1. 写出要匹配的字符串
     1. 从左向右使用原子和元字符拼接
     1. 加入模式修正符
   - 实例
     1. 匹配手机号：`preg_match("/^(1([34578]))\d{9}$/", $mobile)`
     1. 4到6位数字：`preg_match("/^\d{4,6}$/", $code)`
     1. 匹配中文+数字，不能是纯中文，也不是纯数字：`preg_match('/^(?!\d+$)(?![\x{4e00}-\x{9fa5}]+$)[\x{4e00}-\x{9fa5}\d]+$/u', $string)`
     1. 匹配img标签中的src值
        ```php
        $str = '<img id="aa" src="aa.jpg">';
        $pattern = '/<img.*?src="(.*?).*?\/?>"/i';
        preg_match($pattern, $str, $match);
        var_dump($match);
        ```
1. 异常
   - 理解：与异常类似，错误异常一直冒泡直到到达第一个匹配的catch块。如果没有匹配的，使用set_exception_handler()安装的默认异常处理程序，没有默认的，异常将被转换为致命错误，并将像传统错误一样处理。所以`catch（Error $e）{}`或`set_exception_handler()`是必须的。如`(DivisionByZeroError $e)`
   - 抛出异常：`throw new Exception();`
   - try：`try {} catch (Exception $e) {}`
1. 连接数据库
   - PDO
   - MySQLi：要淘汰
   - mysql函数：不支持预处理，不安全
### 运维
1. PHP安装
   - linux
     1. 源码安装
        - 安装php：开启fpm等配置
        ```
        ./configure --prefix=/opt/php --with-mysql --with-gd --with-curl        // 安装位置和扩展
        make
        sudo make install           // 以管理员权限安装
        ```
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
1. PHP配置：php.ini。register_globals(变量注入代码)、allow_url_include(包含远程文件)、allow_url_fopen、date.timezone、display_errors、error_reporting、safe_mode、post_max_size
1. PHP扩展安装
### wiki
1. php运行模式：SAPI，Server Application Programming Interface 服务器端应用编程端口，是php与其它应用交互的接口
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
   - Module
     1. 理解：将php集成到web服务器，以同一个进程运行。php作为apache的模块，预先生成多个进程副本驻留内存，一旦请求出现就立即响应，省去创建子进程的延迟，处理完成后不退出，等待下次请求
   - ISAPI
     1. 理解：微软提供的一套面向Internet服务的API接口，ISAPI的dll被请求激活后常驻内存，不停接受请求。dll和web服务器处于同一个进程中，5.3舍弃
     1. 特点：微软的排他性，只能在windows运行、效率高于CGI、稳定性不好，php出错，IIS或apache也死掉
   - Cli
     1. php_sapi_name：运行环境检测
     1. 参数
        - php -h                                              // 查看帮助
        - php -m                                              // 查看cli模式安装的扩展
        - php --ini                                           // 查看cli模式的配置文件位置
        - php-config
        - php file                                            // 执行php文件
        - php -S 127.0.0.1:80 -t /www /www/index.php          // 启动一个单线程http服务器，可以用于开发和测试
1. PHP-FPM：fastcgi Process Manager，fastcgi进程管理器，比spawn-fcgi更优秀，官方收录。fastcgi是一个协议，php-fpm实现了这个协议。v5.3.29自带fpm，之前需要另外加载模块
   - 特点
     1. 有效控制内存/进程
     1. 支持平滑停止/启动的高级进程管理功能
     1. 发生意外情况的时候能够重新启动并缓存被破坏的 opcode
   - 运维
     1. 杀掉主进程就是重启
     1. 有了pid文件后，可以理解信号：INT/TERM 立刻终止，QUIT 平滑终止，USR1 重新打开日志文件、USR2 平滑重载所有worker进程并重新载入配置和二进制模块
        - 重启：`kill -USR2 'cat /usr/local/php/var/run/php-fpm.pid'`
1. ts/nts
   - 查看：phpinfo()————Thread Safety
   - 分类   
     1. Thread Safe：线程安全，执行时会进行线程安全检查，防止有新要求就启动新线程的cgi执行方式耗尽系统资源
        - ISAPI执行方式以DLL动态库的形式使用，在处理完一个用户请求后不会马上消失，需要进行线程安全检查
     1. Non Thread Safe：非线程安全，执行时不进行线程安全检查
        - FastCGI执行方式以单一线程来执行操作，不需要检查，效率更高
1. PHP-GTK：gui
1. 流行的php三种使用模式
   - nginx + php-fpm
   - apache + mod_php5
   - lighttp + spawn-fcgi
1. 版本历史
   - 5.3
     1. 增加命名空间
   - 5.4
     1. <?= 标签取代 echo
     1. [] 代替 array()
   - 5.6
     1. 增加可变参数，如`function sum(...$int) {}`，`sum(2, 3)`
   - 7.2
     1. 优化opcache
     1. 弃用__autoload、each()、assert
1. php7
   - 整体：性能提升，内核更加健壮，抛弃了很多历史包袱，同时最大程度保证向前兼容，之前的代码基本可以无缝升级
     1. PHPNG代码合并到PHP7，速度是v5.6的3倍，内存消耗比v5.6低50％
     1. 一致的64位支持
   - 更新内容：标量返回值类型、匿名类、常量数组、use、<=>、??、闭包对象绑定优化、层次异常扩展
   - 新特性
     1. ZEND引擎升级到Zend Engine 3，也就是所谓的PHP NG
     1. 增加抽象语法树，使编译更加科学
     1. 64位的INT支持
     1. 统一的变量语法
     1. 原声的TLS - 对扩展开发有意义
     1. 一致性foreach循环的改进
     1. 新增 <=>、**、?? 、\u{xxxx}操作符
     1. 增加了返回类型的声明
     1. 增加了标量类型的声明
     1. 核心错误可以通过异常捕获了：很多致命错误以及可恢复的致命错误，都被转换为异常来处理，这些异常继承自Error类，此类实现了 Throwable 接口。更多的Error变为可捕获的Exception，PHP7实现了一个全局的throwable接口，原来的Exception和部分Error都实现了这个接口（interface），以接口的方式定义了异常的继承结构
     1. 增加了上下文敏感的词法分析
   - 移除的特性
     1. 移除的扩展：Ereg正则表达式、mysql(迁移到了PECL)
     1. 移除SAPIs的支持
     1. <?和<? language=“php”这样的标签被移除了
     1. 16进制的字符串转换被废除
        ```php
        //PHP5
        "0x10" == "16"
        //PHP7
        "0x10" != "16"
        ```
     1. $o = & new className{}，不再支持这样的写法
     1. php.ini文件移除了#作为注释，统一用;去注释
   - 标量/返回值类型声明
     1. 理解：参数和返回值增加了类型限定，如`function test(int $a, string $b, array $c) : int {}`
     1. 选项
        - 强制：默认，也可以不声明类型
        - 严格：开始 `declare(strict_types=1);`
     1. 类型字段：bool、int、float、string、array、callable、interfaces
   - 匿名类：可以代替完整的类定义
    ```php
    interface Logger { public function log(string $msg); }

    class Application {
        private $logger;
        public function getLogger(): Logger { return $this->logger; }
        public function setLogger(Logger $logger) { $this->logger = $logger; }
    }

    $app = new Application;
    $app->setLogger(new class implements Logger {
        public function log(string $msg) {
            print($msg);
        }
    });

    $app->getLogger()->log("My first Log Message");
    ```
   - 常量数组：使用define定义数组常量，v5.6中只能使用类常量const定义
    ```php
    define('animals', [
        'dog',
        'cat',
    ]);
    ```
   - use增强：可以使用单个use从相同的命名空间导入类/函数/常量，如`use com\{ClassA, ClassB as B};`
   - 空合并运算符：用空合并运算符??代替isset和三元结合的操作
    ```php
    $username ?? 'no';
    isset($username) ? $username : 'no';
    $username = $_GET['username'] ?? $_POST['username'] ?? 'not passed';        // 连续判断并采用
    ```
   - 太空船运算符(组合比较符)：<=>，第一个表达式大等小于第二个分别返回-1/0/1
    ```php
    1 <=> 1     // 0
    1 <=> 2     // -1
    2 <=> 1     // 1
    ```
   - Closure::call()：作为一个简短的方式来临时绑定一个对象作用域到一个闭包并调用它，比v5的bindTo快很多
    ```php
    class A { private $x = 1; }

    $getValue = function() { return $this->x; };          // php5之前
    $value = $getValue->bindTo(new A, 'A');
    print($value());

    $value = function() { return $this->x; };             // php7
    print($value->call(new A));
    ```
   - 错误处理：大多数错误被作为Error异常抛出
   - 废弃特性
     1. php4样式的构造函数(即和类名相同)，弃用
     1. 对非静态方法的静态调用，弃用。`class A { function b() {}}`，`A::b();`
   - 其他
     1. list不再按照相反的顺序赋值
     1. 对变量、属性和方法的间接调用现在将严格遵循从左到右的顺序来解析，而不是之前混杂着几个特殊的案例
     1. Unicode codepoint转译语法：接受任何有效的16进制的codepoint，如 `echo "\u{9999}"; // 香`
     1. 零成本断言增加：向后兼用并增强之前的assert的方法，使得在生产环境中启用断言为零成本，并提供当断言失败时抛出特定异常的能力
        ```php
        ini_set('assert.exception', 1);
        class CustomError extends AssertionError {}
        assert(false, new CustomError('Some error message'));
        ```
     1. 过滤unserialize()：方便在对不可信数据上的对象进行反序列化时提供更好的安全性，防止可能的代码注入
        ```php
        $serializedObj = serialize($obj);
        $data = unserialize($serializedObj , ["allowed_classes" => ["MyClass1", "MyClass2"]]);
        ```
     1. 新增：intdiv整数除法
     1. CSPRNG：两个新函数来以跨平台的方式生成密码安全的整数和字符串，`random_bytes/random_int`
     1. IntlChar类：试图揭示额外的ICU功能，用来处理Unicode字符
