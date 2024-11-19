### php
1. 认识：Hypertext Preprocessor/personal home pages/超文本预处理器，开源、用于产生动态网页的可嵌入HTML中的脚本语言，适合web开发。web是IO密集型，瓶颈在mysql，体现不出php性能劣势，密集计算方面比C/C++差几十倍
1. php模式：`<?php ?>`
### 语法
1. 数据类型
   - 8种原始数据类型
     1. 标量：boolean、integer、float、string
     1. 复合：array、object
     1. 特殊
        - resource：资源类型，是特殊变量，保存了到外部资源的一个引用。具体为为打开文件、数据库连接、图形画布区域等特殊句柄，因此将其它类型的值转换为资源没有意义。不可被serialize()
        - null
   - 伪类型：mixed(所有)、number(int，float)、callback(V5.4)、void
1. 变量
   - 普通变量：区分大小写，可变变量 $$a
     1. 赋值：$xx=xx
     1. 传址赋值：$xx=&$xx
   - 静态变量：只存在于函数作用域内，只存活在栈中，再次调用函数会保留，`static $n = 1;`
   - 超全局变量：也是数组
     1. $GLOBALS：包含全部变量的全局组合数组
     1. $_ENV：cli模式下的环境变量
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
        - 全局常量：`define('name', 'value')`，任意地方定义和访问，不能在类中，通常大写
        - 类常量：`const name='value'`，只能在类中定义常量，不能在条件语句中，v5.3之后也可在类外定义，和static不同的是没有权限限定符和不能修改值，7.1中可以加限定符，使用：self::xxx、className::xxx
        - 特点
          1. const只接受标量，define可采用任何表达式。const是一个语言结构。而define是一个函数，const在编译时比define快很多
          1. const定义的常量大小写敏感，define可通过参数指定大小写是否敏感
     1. 系统常量(预定义常量)
        - 整体
          1. PHP_VERSION
          1. PHP_OS                 # 执行PHP解释器的操作系统名称
          1. PHP_SAPI               # 判断是用命令行/浏览器执行的，为cli表示命令行
          1. PHP_INT_MAX
          1. PHP_INT_SIZE
          1. TRUE
          1. FALSE
        - 错误
          1. E_ERROR                # 最近的错误处
          1. E_WARNING
          1. E_PARSE                # 剖析语法有潜在问题处
          1. E_NOTICE
        - 符号
          1. PHP_EOL                # 系统换行符，Windows是（\r\n），Linux是（/n），MAC是（\r）
          1. DIRECTORY_SEPARATOR    # 系统目录分隔符，Windows是反斜线（\），Linux是斜线（/）
          1. PATH_SEPARATOR         # 多路径间分隔符，Windows是反斜线（;），Linux是斜线（:）
1. 运算符
   - 计算：%、++$a、$a--
   - 比较：==等于、===全等于，类型相同、!=或<>不等于
   - 赋值：=
   - 逻辑：and/&&，or/||，!
   - 三元表达式：表达式 ? 值1 : 值2
   - 字符串连接符：.
   - 数组合并符(后边不覆盖前边)：+
1. 流程控制
   - 选择：if
   - 循环：while/for/switch-case
     1. break：离开循环
     1. continue：跳过本次循环进入下次，每执行一次低级语句就判断一下
1. 函数
   - 系统内置函数
   - 闭包：`$varClosure = function() {};`
1. 引用 &
   - 绑定
     1. `&$a`：变量引用，绑定两个变量到同一内存地址
     1. `$a =&$GLOBALS["a"];`：等于`global $a`，绑定全局变量的引用
     1. `method(&$a)`：传址调用，参数和变量绑定内存地址
     1. `$a = &method()`：引用返回，将返回值和一个变量绑定内存地址
     1. `$b=new a; $c=$b`：等于`$b=new a; $c=&$b`，php5默认对象赋值是引用，想要对象副本不影响原对象用__clone
   - 删除：`$a=null`，`unset($a)`
1. 错误和异常
   - 理解：Error和Exception都实现了Throwable接口，可用`handler(Throwable $e)`
     1. 错误：错误不能以异常的形式捕获，php7中大多数错误被作为Error抛出，可用`Error`或`Throwable`捕获，不捕获就变为fatal_error，Exception不可以捕获错误。Throwable不可以捕获notice如`$a['notExist']`
        - 类型
          1. E_PARSE、E_ERROR、E_WARNING、E_NOTICE：语法解析错误、致命错误暂停执行脚本、警告、注意
          1. E_USER_ERROR、E_USER_WARNING、E_USER_NOTICE、E_USER_DEPRECATED：用户自定义的用trigger_error触发的
          1. E_CORE_ERROR, E_CORE_WARNING、E_COMPILE_ERROR, E_COMPILE_WARNING：php核心、编译的错误和警告
          1. E_ALL：所有的错误和警告，不包括E_STRICT
          1. E_STRICT：编码标准化警告
          1. E_RECOVERABLE_ERROR：可被捕捉的致命错误，如果没有set_error_handler捕捉，就变为E_ERROR并停止运行
          1. E_DEPRECATED：运行时通知。会对在未来版本中可能无法正常工作的代码给出警告
   - 使用
     1. 处理
        - set_exception_handler/set_error_handler：设置异常、错误处理时的函数，不能捕获E_ERROR、E_PARSE
        - register_shutdown_function：设置php终止执行的函数，脚本执行完后或exit后，可多次调用则依次执行，常配合error_get_last
        - error_get_last/error_clear_last
        - trigger_error：抛出用户级错误
        - error_log/debug_backtrace/debug_print_backtrace：产生一条回溯跟踪
        - @：错误控制运算符，放在表达式前，该表达式可生的任何错误信息都被忽略
     1. 显示控制
        - display_errors
        - error_reporting：除了NOTICE的写法，`(E_ALL & ~E_NOTICE)`或`(E_ALL ^ ~E_NOTICE)`
     1. 配置
        - php.ini
          1. log_errors：开关
          1. display_errors：是否显示
          1. error_reporting：错误级别
          1. error_log：日志地址
        - php-fpm.conf
          1. error_log
          1. log_level
   - 预定义的异常：即老的异常
     1. Exception：是所有异常的基类
        - 抛出：`throw new Exception()`
        - 捕获：`try {} catch (Exception $e) {} finally {}`
        - 方法
          1. Exception::getMessage/getCode — 获取异常消息内容
          1. Exception::getFile/getLine/getTrace — 获取创建的异常所在文件中的行号
          1. Exception::getPrevious — 返回异常链中的前一个异常
        - 自定义异常处理类
          1. 定义
            ```php
            class MyException extends Exception {
                // 重定义构造器使 message 变为必须被指定的属性
                public function __construct($message, $code = 0, Exception $previous = null) {
                    // 自定义的代码
                    // 确保所有变量都被正确赋值
                    parent::__construct($message, $code, $previous);
                }
                // 自定义字符串输出的样式
                public function __toString() {
                    return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
                }
            }
            ```
          1. 抛出：`throw new MyException('a', 5);`
     1. ErrorException：错误异常
        - 方法
          1. `ErrorException::getSeverity`：获取异常级别
        - 将错误信息托管至ErrorException
            ```php
            function exception_error_handler($errno, $errstr, $errfile, $errline ) {
                throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
            }
            set_error_handler("exception_error_handler");
            ```
1. 反射
   - 认识：reflection，在php运行中分析php程序，提取类/对象/方法/属性/参数/注释等信息
   - 组成
     1. 反射api：非常强大，任何信息都可以获取，是php内建的oop扩展
        ```php
        $class = new ReflectionClass('Person');                                     // 建立Person类的反射类
        $instance  = $class->newInstanceArgs($args);                                // 实例化Person类
        $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);         // 获取公共属性
        $ec=$class->getmethod();                                                    // 获得方法
        $ec->invoke($instance);                                                     // 执行方法  
        ```
     1. 函数
        - 判断
          1. interface_exist/trait_exists...
          1. class_exists/is_subclass_of/instanceof...
          1. property_exists/method_exists...
          1. is_null/is_int/is_string...
        - 获取
          1. get_class/get_class_methods
          1. get_defined_functions/get_defined_vars/get_called_class/get_declared_interfaces/func_get_args
        - 使用
          1. call_user_func/forward_static_call
1. 其他语法
   - declare：用于设置影响整个脚本或某代码块的指令，主要用于设置脚本执行时间和线程栈大小
     1. 语法
        ```php
        declare (directive);            // 作用于整个脚本，通常放在脚本的开头
        // 代码块

        declare (directive) {           // 作用于某代码块
            // 代码块
        }
        ```
     1. 示例
        ```php
        // 指定脚本字符编码，encoding是v7.2及以后可用
        declare(encoding='UTF-8');
        
        // 每隔一定时间执行回调函数
        function tick_handler() {
            echo "Tick handler called\n";
        }

        // 注册回调函数
        declare(ticks=1);
        register_tick_function('tick_handler');

        // 执行一些代码
        for ($i = 0; $i < 10; $i++) {               // 每次循环都会触发一次tick_handler函数
            echo "Loop iteration $i\n";
        }
        ```
### 面向对象
1. 理解
   - 面向过程：优点：用什么功能就编写什么函数，注重实现细节。缺点：数据管理较混乱集中在函数方面
   - 面向对象：万物皆对象，将构成问题的事务分解到各个对象上，不为完成特定工作建立对象，而是为描述某事务在解决问题中的行为，更符合人思维习惯，代码重用性高，可扩展性好。是一种对现实世界理解和抽象的方法，事物抽象成对象，关系抽象成类、继承
   - 面向接口：就是接口层的概念，是一组规则的集合，规定了实现本接口的类或接口必须拥有的一组规则，是更高层次的抽象
1. 特性
   - 封装：成员方法和成员属性封装到类中，限定成员访问权限，数据被保护在内部
   - 继承：类之间的关系，让类能够具有可扩展性
   - 多态：父类定义的方法可以调用子类实现的方法，不同的子类有不同的实现，从而带来新的属性或行为，在继承的基础之上
1. 组成
   - 接口：接口是特殊的抽象类，所有的方法都是public的抽象方法，所有变量都是常量，可多继承，接口没有构造函数
   - 抽象类：只要包含抽象方法的类，不能实例化只能继承，可定义普通方法和构造函数，抽象方法：抽象方法不能定义具体的实现，不能有主体即{}，子类必须全部重写父类抽象方法，访问控制只能更宽泛
   - 类：具有相同属性和方法的对象集合，只能实例化。类名首字母大写，一个文件可以写多个，规范就一个。可实现多接口，只能继承一个抽象类
   - 对象：包含属性、方法，$this是当前对象的引用。对象本身是传址赋值，不像变量赋值时会空间复制
1. 类
   - 魔术常量：8个
    ```php
    __DIR__
    __FILE__            // 当前文件的绝对路径和文件名，不论文件是否被包含
    __NAMESPACE__       // 当前命名空间名
    __TRAIT__           // 5.4新增，返回trait被定义时的名字
    __CLASS__           // 类名
    __METHOD__          // 返回类名和方法名
    __FUNCTION__        // 只返回函数名
    __LINE__    
    ```
   - 魔术变量
   - 魔术方法：13个
    ```php
    __autoload()            // 载入：实例化一个对象时，如果对应的类不存在，则该方法被调用
    __get/set()             // 属性：拦截器，外部读取、设置属性时自动调用
    __isset/unset()         // 检测/删除一个对象时调用
    __call()                // 方法：调用不存在方法时自动调用，可以屏蔽错误
    __callStatic
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
   - 延迟静态绑定：用于继承范围内引用静态调用的类，就是用static表示引用当前使用的类，v5.3增加，只有在继承中才会体现
    ```php
    class A {
        public static function who() { echo __CLASS__; }
        public static function test() {
            self::who();                                        // 返回A
            static::who();                                      // 返回B，延迟静态绑定
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
1. 特质
   - 认识：trait，是一种为类似PHP的单继承语言而准备的代码复用机制，使开发人员能够自由地在不同层次结构的独立的类中复用方法集。来避免传统多继承和混入类（Mixin）相关的典型问题，就是先定义trait，用use给类插入代码，代码复用，属于类与对象，v5.4
    ```php
    class Base {
        public function sayHello () {
            echo 'Hello ' ;
        }
    }
    trait SayWorld {
        public function sayHello () {
            parent::sayHello();
            echo 'World!';
        }
    }
    class MyHelloWorld extends Base {
        use SayWorld;
    }
    $o = new MyHelloWorld();
    $o->sayHello ();                        // 输出Hello World!
    ```
### 应用
#### 基础
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
        - basename：文件名
        - pathinfo：较全的路径信息
        - dirname(dirname(__FILE__))：访问上上级目录
     1. 读取：opendir、readdir、closedir、rewinddir、scandir
     1. 创建：mkdir
     1. 删除空目录：rmdir
   - 磁盘：disk_free_space、disk_total_space
   - 判断：is_file、is_dir
   - 查找：glob
   - 重命名/移动：rename
1. 网络/IO
   - socket：对底层Socket API的封装，socket类遵循tcp/ip协议，封装大量的内部通讯方法，用于创建主机端与客户端的数据通讯，就是listen/accept/send/write等几个基本操作，相关函数：fopen/fsockopen/stream_socket_server/stream_socket_client
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
1. 日期时间函数
   - time        时间戳
   - strtotime   字符串转为时间戳，啥都能转
   - mktime      日期转为时间戳
   - date        格式化时间/日期
   - gmdate
#### 组件
1. 连接数据库
   - PDO：php database object
     1. 理解：提供了一个数据访问抽象层，这意味着不管使用哪种数据库，都可以用相同的方法来查询和获取数据
     1. 特性
        - 长连接：可以设置长连接，但是会受上一个锁等待，事务回滚的影响，可以设置超时断开时间30秒，正好一个web响应时间，`PDO::ATTR_PERSISTENT => true`
        - 预处理
            ```php
            $stmt = $dbh->prepare("(:name, :value)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':value', $value);

            // 插入一行
            $name = 'one';
            $value = 1;
            $stmt->execute();
            // 用不同的值插入另一行
            $name = 'two';
            $value = 2;
            $stmt->execute();

            // prepare另一种方式
            $stmt = $dbh->prepare("(?, ?)");                # ：问号方式、别名方式
            $stmt->bindParam(1, $name);
            $stmt->bindParam(2, $value);

            // 绑定方式
            bindValue
            bindParam
            execute：直接传递参数

            // 其他方法
            bindColumn
            rowCount
            ```
        - 事务
          1. `PDO::beginTransaction()`
          1. `PDO::commit()`
          1. `PDO::rollBack()`
     1. 异常处理
        - PDO::ATTR_ERRMODE：错误抛出方式
          1. PDO::ERRMODE_SILENT：不报错，默认
          1. PDO::ERRMODE_WARNING：以E_WARNING
          1. PDO::ERRMODE_EXCEPTION：以异常
   - MySqli：可以设置长连接，进程重用长连接，但是mysqli会做一些清理工作
   - mysql函数：不支持预处理，不安全，已经淘汰
#### pro
1. 缓冲区
   - 认识：是用来存储速度不同步或优先级不同的设备之间传输数据的内存地址空间。通过缓冲可以使进程之间的交互时间等待变小，从而使从速度慢的设备读取数据时，速度快的设备的操作进程不发生间断
     1. 缓冲区是层层嵌套的，满了就会流到下一层
     1. cli模式下会直接流到sapi的缓冲区
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
1. 线程、进程管理
   - pcntl/posix：进程管理扩展，用于进程创建、信号处理、进程中断，仅用于linux，window没有，fpm模式会有意外问题
     1. pcntl_fork
     1. pcntl_signal_dispatch
     1. pcntl_signal
   - Pthread：多线程、线程管理、锁的支持
1. 事件管理
   - Libevent：对libevent库的封装
   - Event：基于Libevent更高级的封装，提供了面向对象接口、定时器、信号处理的支持
#### 服务
1. php运行模式
   - Cli：command-line interface
     1. php_sapi_name：运行环境检测
     1. 参数
        - php -h                                              // 查看帮助
        - php -m                                              // 查看cli模式安装的扩展
        - php --ri curl                                       // 查看扩展信息
        - php --ini                                           // 查看cli模式的配置文件位置
        - php-config
        - php file                                            // 执行php文件
        - php -S 127.0.0.1:80 -t /www /www/index.php          // 启动一个单线程http服务器，可以用于开发和测试
   - CGI
   - FastCGI
   - Module
     1. 理解：将php集成到web服务器，以同一个进程运行。php作为apache的模块，预先生成多个进程副本驻留内存，一旦请求出现就立即响应，省去创建子进程的延迟，处理完成后不退出，等待下次请求
   - ISAPI
     1. 理解：微软提供的一套面向Internet服务的API接口，ISAPI的dll被请求激活后常驻内存，不停接受请求。dll和web服务器处于同一个进程中，php5.3舍弃
     1. 特点：微软的排他性，只能在windows运行、效率高于CGI、稳定性不好，php出错，IIS或apache也死掉
1. PHP-FPM：fastcgi Process Manager，fastcgi进程管理器，比spawn-fcgi更优秀，官方收录。php-fpm实现了fastcgi这个协议
   - 特点
     1. 有效控制内存/进程
     1. 支持平滑停止/启动的高级进程管理功能
     1. 发生意外情况的时候能够重新启动并缓存被破坏的opcode
   - 工作流程
     1. 读取php.ini、php-fpm.conf
     1. 创建master进程，监听9000端口，创建子进程
        - 子进程管理的三种方式
          1. static：静态，固定子进程数
          1. dynamic：动态，可配置启动数、最大/小空闲数、最大数。灵活节省内存，fork过程有性能损耗
          1. ondemand：按需，可配置最大数、子进程空闲时间后被kill
     1. 当有连接9000的客户端时，空闲子进程accept，子进程全部忙碌的话，连接会被master放入队列，等待子进程空闲
   - 运维
     1. 杀掉主进程就是重启
     1. 有了pid文件后，可以理解信号：INT/TERM 立刻终止，QUIT 平滑终止，USR1 重新打开日志文件、USR2 平滑重载所有worker进程并重新载入配置和二进制模块
        - 关闭：`pkill php-fpm`
        - 重启：`kill -USR2 'cat /usr/local/php/var/run/php-fpm.pid'`
   - 配置
        ```conf
        // 基础
        pid = /usr/local/php7/var/run/php7-fpm.pid

        // 请求设置
        request_terminate_timeout = 600
        request_slowlog_timeout = 600

        listen = /dev/shm/php7-cgi.sock                         // 也可用ip:端口，socket性能更好(更少数据拷贝和上下文切换)，但需指定用户身份，文件建在哪儿都行，nginx有权限读就可以
        listen.backlog = 4096                                   // 积压连接的队列长度，太短请求拒绝连接，太长nginx那边超时甚至连接断开，最大为系统的somaxconn
        listen.owner = nobody
        listen.group = nobody
        listen.mode = 0666
        listen.allowed_clients = 127.0.0.1                      // 设置允许连接fpm的地址，逗号分隔

        pm = static
        pm.max_children = 10                                    // 始终保持10个worker子进程

        pm = dynamic                                            // 动态
        pm.max_children = 144
        pm.start_servers = 96                                   // 启动时创建数/最小子进程数量
        pm.min_spare_servers = 72                               // 闲置时最少数
        pm.max_spare_servers = 144                              // 闲置时最大数
        pm.process_idle_timeout = 10s;                          // 闲置时长
        pm.max_requests = 102400                                // 每个子进程最大处理请求数就被回收，可防止内存泄露
        pm.status_path = /php7fpmstatus

        pm = ondemand                                           // 按需，连接过来时才启动，可能会关闭所有的worker
        pm.max_children = 144
        pm.process_idle_timeout = 10s                           // 闲置10s后杀掉

        // log
        log_level = notice                                      // 可选：alert、error、warning、notice、debug
        slowlog =  /usr/local/php7/var/log/php7-fpm.slow
        request_slowlog_timeout = 2s                            // 写慢日志最小记录时间
        error_log = /usr/local/php7/var/log/php7-fpm.log
        access.format = %R - %u %t "%m %r%Q%q" %s %f %{mili}d %{kilo}M %C%%
        syslog.facility = daemon                                // 将日志写进系统log
        syslog.ident = php-fpm                                  // 系统日志标示，多个fpm下用于区分是哪个fpm

        // 以什么身份运行
        user = nobody
        group = nobody

        // 进程设置
        process_control_timeout = 10                            // 子进程接受主进程复用信号的超时时间
        process.max = 128                                       // 动态管理子进程时，最大子进程数
        process.priority = -19                                  // 设置子进程的优先级，以root用户启动有效，不设置继承主进程的

        // 重启设置，在interval时间内，出现SIGSEGV或SIGBUS的子进程数超过threshold数，fpm优雅重启
        emergency_restart_threshold = 10
        emergency_restart_interval = 10s                        // 0表示关闭，单位：s秒,m分,h时,d天

        // 其他
        rlimit_files = 1024                                     // 设置master进程最多能打开的文件，默认为系统的值
        rlimit_core = 0                                         // 最多的核心使用数，默认为系统的值
        events.mechanism = epoll                                // 事件处理机制，默认自动检测，可选值：select，poll，epoll(linux>=2.5.44)，kqueue，/dev/poll，port
        systemd_interval = 10s                                  // 当fpm被设置为系统服务时，多久向服务器报告一次状态，单位有s,m,h。
        daemonize = yes                                         // 设置成no用于调试bug，默认为yes
        include=/usr/local/php7/etc/php-fpm.d/*.conf
        ```
1. 流行的php三种使用模式
   - nginx + php-fpm
   - apache + mod_php5
   - lighttp + spawn-fcgi
1. PHP-GTK：gui
### 包和依赖
1. 命名空间：解决重名，v5.3引入
   - 全局空间：没有声明命名空间的默认空间，使用\表示使用全局空间
   - 命名空间
     1. namespace：声明命名空间，在所有代码之前
        ```php
        namespace foo\bar;                                  // 子命名空间定义
        namespace foo\bar1{ // php代码 }                     // 另一种命名空间定义语法，可支持一个文件多个命名空间
        ```
     1. use：导入类，v5.6支持导入函数和常量
        ```php
        use foo\bar as Another;                             // 声明别名，可一行引入多个
        use function foo\bar\functionName as func;
        use const Mfooy\bar\CONSTANT;
        ```
     1. 作用范围：使用和定义时默认使用当前空间
     1. 使用
        ```php
        namespace foo;
        use My\Full\Classname as Another;
        new namespace\Another;                              // 实例化 foo\Another 对象

        new __NAMESPACE__ . '\\' . $classname;              // 动态创建名称
        ```
1. 文件载入
   - 普通
     1. 理解：once确保文件只被包含一次，避免函数重定义、变量重新赋值
     1. 分类
        - include()/include_once()：运行前引入、运行次数越多效率越高，出错产生警告
        - require()/require_once()：用到才引入，出错抛出错误并终止脚本
     1. 查找逻辑：找到即终止
        - 如果给出路径按照路径查找
        - 从include_path查找(include_path就是一个在php.ini中配置的，也可以用set_include_path()配置的用于载入文件的路径，path分隔符使用系统的)
        - 从调用脚本目录(getcwd())和当前工作目录(__FILE__)查找
   - __autoload
     1. 理解：当需要使用的类没有被引入时，会在php报错前被触发，未定义的类名会被当作参数传入，这样就不用一个个的文件去require了，v7.2废弃
    ```php
    function __autoload($classname) {
        require_once $classname . '.class.php';
    }
    $obj = new MyClass();                                       // MyClass类不存在时，自动调用__autoload()函数并传入参数”MyClass”
    ```
   - spl方式
     1. 理解：使载入逻辑更加清晰，分离autoload的载入逻辑，重载spl函数即可。spl_autoload_register功能就是把传入的函数(函数或者回调函数)注册到spl的autoload函数队列中，并移除默认的autoload函数。当调用未定义类时，系统按顺序调用注册到register的所有函数，而不是只能载入一次
     1. 使用spl载入文件
        ```php
        // 默认sql载入
        spl_autoload_extensions('.class.php', '.php');              // 设置自动载入文件的后缀，有前后顺序
        set_include_path(get_include_path() . PATH_SEPARATOR);      // 设置自动载入文件的目录，多个目录用PATH_SEPARATOR分割
        spl_autoload_register();                                    // 注册
        new Test();                                                 // 使用
        // 使用自定义函数载入
        function classLoader($className) {
            set_include_path('libs');
            spl_autoload($className);                               // sql方式
            // require_once('libs' . $className . '.php');          // 或者使用普通方式
        }
        spl_autoload_register('classLoader');
        new Test();
        ```
1. 依赖管理工具：Composer
   - 命令
     1. composer config                               // 配置设置
     1. composer global config --list                 // 查看全局配置
     1. composer init                                 // 初始化项目依赖，自动生成json文件
     1. composer install/update (foo/bar:1.0.0)       // 安装/更新所有/单个依赖
     1. composer show                                 // 查看安装的依赖和依赖的版本号
     1. composer dump-autoload --optimize             // 为生产环境做准备
   - 参数
     1. --prefer-dist：用于install/update，强制下载源代码，在修改文件后更新文件会给出提示
     1. --prefer-source
     1. --lock：仅更新锁文件，用于update
     1. --no-dev：跳过require-dev中的包
     1. -V
   - 功能
     1. 锁文件：会将把安装时确切的版本号列表写入，install会在lock存在情况下下载lock中的，忽略json中的，update会更新lock文件
     1. 自动加载：composer自动会生成一个vender/autoload.php，载入这个文件后，直接new，就会自动载入。命名空间的申明应该以\\结束
        - 在composer.json的autoload字段中增加自己的autoloader
            ```json
            "autoload": {                       
                "psr-4": {"Acme\\": "src/"}     // 注册一个PSR-4 autoloader到Acme命名空间
            }
            ```
        - PSR-0： PEAR形式的路径映射
        - include-path：追加传统的引用路径，不建议
   - 考虑缓存，dist包优先？？？
   - 配置
     1. 镜像地址
        - 全局：`composer config -g repo.packagist composer https://packagist.phpcomposer.com`
        - 局部：项目目录下执行，`composer config repo.packagist composer https://packagist.phpcomposer.com`
        - 删除：`composer config -g --unset repos.packagist`
   - json文件架构
     1. 包版本
        - 1.0.2：确切
        - >=1.0：范围，,为and，|为or。>、>=、<、<=、!=，如>=1.0,<2.0
        - 1.0.*：通配符
        - ~1.0：适用遵循语义化版本号，以最后一位数字加1为上限，相当于>=1.0,<2.0
        - 1.0.0-stable/dev/alpha3/beta2/RC5：添加后缀
        - 1.0.0#2eb0c0978d29：添加提交编号，不建议
        - ^1.8：允许指定最小版本，允许Composer自动更新到该主要版本内的任何更高版本，但不允许跨越主要版本
     1. 包类型
        - php：php版本要求
        - hhvm：HipHop Virtual Machine，是Facebook执行php的虚拟机，是JIT（Just-In- Time）编译器，同时具有产生快速代码和即时编译的优点
        - ext-：php扩展限制，可用*指定版本，如`ext-gd`
        - lib-：php库的版本，如lib-curl
     1. 稳定性
        - 全局设置
          1. minimum-stability：最小稳定容忍，有dev、alpha、beta、RC、stable
          1. prefer-stable：是否更倾向稳定版，有true、false
     1. type：安装类型
        - library：默认，复制文件
        - project：表示当前包是一个项目
        - metapackage：当一个空的包，包含依赖并且需要触发依赖的安装，这将不会对系统写入额外的文件。因此这种安装类型并不需要一个 dist 或 source
        - composer-plugin：自定义安装类型，可以继承接口写一个installler
     1. require-dev：root-only，开发或测试使用
     1. repositories：资源库，设置某个库拉取的地址
        - 指定多个资源库，位置靠前的先使用
        ```json
        {
            "repositories": [
                {
                    "type": "composer",
                    "url": "http://packages.example.com"
                },
                {
                    "type": "composer",
                    "url": "https://packages.example.com",
                    "options": {
                        "ssl": {
                            "verify_peer": "true"
                        }
                    }
                },
            ]
        }
        ```
   - 最佳实践
     1. composer.lock提交到代码库，利用lock文件确认深层次依赖中每一个的版本号，命令` composer install -vvv --no-dev --ignore-platform-reqs --no-interaction --optimize-autoloader`
### 测试与性能
1. 代码调试
   - xdebug：本地调试
   - tideways：性能分析工具，给php.ini添加配置，后台自动收集，还配置了web界面。提供函数调用次数、执行时间、内存使用等信息
   - xhprof
     1. 认识：php的层次性能分析工具，查看资源占用和各个调用的耗时，搭配graphviz图显示更直接，还有xhGui。facebook开源，性能开销低，可用在生产活动中
        - graphviz：开源的图形可视化软件，以简单的文本语言获取图形的描述，应用于网页、svg、pdf、postscript中，有颜色，字体，表格节点布局，线条样式，超链接和自定义形状的选项
     1. 使用
        ```php
        // 抓取
        xhprof_enable(XHPROF_FLAGS_NO_BUILTINS | XHPROF_FLAGS_CPU | XHPROF_FLAGS_MEMORY);
        // --业务代码--
        $xhprof_data = xhprof_disable();

        // 获取此次分析id
        include_once "/usr/share/pear/xhprof_lib/utils/xhprof_lib.php";
        include_once "/usr/share/pear/xhprof_lib/utils/xhprof_runs.php";
        $xhprof_runs = new XHProfRuns_Default();
        $run_id = $xhprof_runs->save_run($xhprof_data, "dengling");

        // 查看生成报告，nginx指向xhprof的目录
        http://xhprof.xesv5.com/index.php?run=604994b1e56a4&source=dengling
        ```
     1. 字段含义
        - microsec：微秒
        - Calls：方法被调用的次数
        - Incl.Wall Time：方法执行花费的时间，包括子方法执行时间
        - IWall%：方法执行花费的时间百分比
        - Excl. Wall Time(microsec)：方法本身执行花费的时间，不包括子方法
        - Incl. CPU(microsecs)：方法执行花费的CPU时间，包括子方法
     1. 配置
        ```conf
        [xhprof]
        extension=xhprof.so;
        xhprof.output_dir=/tmp/xhprof           // 分析文件生成地址
        ```
1. 性能检测
    ```php
    ini_set('memory_limit', "1024M");
    set_time_limit(0);
    echo microtime() . PHP_EOL;
    echo microtime() . PHP_EOL;
    echo memory_get_usage() . PHP_EOL;
    ```
#### 调优
1. 优化方式
   - 编码方面
     1. 文件加载：一个文件操作胜过优化N个CPU指令
     1. 提前销毁大变量
     1. 避免使用魔术方法耗性能
     1. requiere_once耗性能
     1. 少用正则
     1. 不要用@符掩盖错误
     1. 单引号代替双引号
   - php方面
     1. 配置
        - php.ini：memory_limit、session.save_handler、output_buffering
        - php-fpm：动态和静态的子进程管理，平衡cpu和内存
   - 架构方面
     1. 部署环境：nginx+php-fpm方式
     1. 框架选择
     1. 缓存
        - 程序层面的文件静态和优化比底层来的更有效、直接
        - 开启opcode缓存：避免重复编译，如APC、xcache
        - 本地缓存：如用xcache缓存元数据，不用每次读文件
     1. 外部
        - nginx开启gzip压缩
1. 发挥PHP7的性能
   - 开启Opcache
     1. zend_extension=opcache.so
     1. opcache.enable=1
     1. opcache.enable_cli=1
   - 使用GCC 4.8以上进行编译
   - 开启HugePage（根据系统内存决定）：操作系统默认的内存是以4KB分页的，而虚拟地址和内存地址需要转换，而这个转换要查表，CPU为了加速这个查表过程会内建TLB(Translation Lookaside Buffer)。 显然，如果虚拟页越小，表里的条目数也就越多，而TLB大小是有限的，条目数越多TLB的Cache Miss也就会越高，所以如果我们能启用大内存页就能间接降低这个TLB Cache Miss。php将采用大内存页来保存，减少TLB miss，提高性能
   - PGO：Profile Guided Optimization，第一次编译成功后，用项目代码去训练PHP，会产生一些profile信息，最后根据这些信息第二次gcc编译PHP就可以得到量身定做的PHP7
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
1. PHP配置：php.ini
   - register_globals(变量注入代码)
   - allow_url_include(包含远程文件)
   - allow_url_fopen
   - date.timezone
   - display_errors
   - error_reporting
   - safe_mode
   - post_max_size

   - pcre.jit
   - session.gc_maxlifetime
   - upload_max_filesize/max_file_uploads = 200M
   - max_input_vars：影响最大表单数量
1. PHP扩展安装
   - yum：`yum/apt-get install php-pear`，推荐
   - 源码编译
     1. `cd ext/pcntl`
     1. `phpize`：准备扩展库的编译环境，产生configure
     1. `./configure --prefix=/ --with-php-config=/usr/local/php/bin/php-config`
     1. `make && make install`
     1. `php.ini：extension=pcntl.so && restart`
   - pecl：PHP Extension Community Library，php扩展社区库，c编写，是通过pear打包系统的php扩展库
     1. pecl install xx
     1. php.ini：extension=xx.so && restart
   - pear：php扩展和应用仓库，将常用功能(数据库访问/文件操作/数据结构/缓冲操作/网络协议)写成类库，提供下载，提高开发效率，php编写
   - phar：php archive，php的打包文件
1. PHP开发
   - 配置
     1. brew安装的php.ini位置：`/opt/homebrew/etc/php/8.2/`
     1. brew安装的位置：`/opt/homebrew/opt/php@7.2`
   - 启动/停止fpm
     1. `brew services start/stop php@8.2`
     1. `brew services start/stop shivammathur/php/php@7.3`
   - nginx
     1. 启动/停止
        - 前台：`/opt/homebrew/opt/nginx/bin/nginx -g daemon\ off\;`
        - 后台：`brew services start/stop nginx`
     1. 配置：`/opt/homebrew/etc/nginx/nginx.conf`
        - 文件路径：`/opt/homebrew/var/www`
        - 文件路径：`/opt/homebrew/etc/nginx/servers/`
### wiki
1. 历史
   - 1994：Rasmus Lerdorf为维护个人网页而制作了一个简单的用Perl语言编写的程序，称为Personal Home Page
   - 1995：Rasmus Lerdorf用C对Personal Home Page进行重新编写，包括可以访问数据库，于1995年6月发布首个公开版。即PHP1.0
   - 1997：Rasmus Lerdorf、Andi Gutmans 和 Zeev Suraski 加入了该语言的第三个版本的开发，并进行根本性的重新设计，性能大大提升。从那之后， PHP 开发组也创建并发展起来。PHP 也在这个时候改称为 PHP：Hypertext Preprocessor
   - 2000：以 Zend Engine 1.0 为基础的 PHP 4 正式发布，自此，PHP 的性能才开始变得正式起来
   - 2004：发布了 PHP 5，PHP 5 使用了第二代的 Zend Engine。PHP 包含了许多新特色，如强化的面向对象功能、引入PDO、许多效能增强
   - 2015：12月3日，P7.0正式发布，使用的 Zend Engine 3 带来了 100% 的性能提升，还有统一的变量语法，基于抽象语法树编译过程
1. 版本
   - 2
     1. 发布PHP/FI
   - 3
     1. 重写php解释器
   - 4
     1. Zend Engine 1.0
   - 5
     1. Zend Engine 2.0
     1. 完全实现面向对象
     1. PDO
     1. v5.3.29开始自带fpm，之前需要另外加载模块
   - 5.3
     1. 增加命名空间
   - 5.4
     1. <?= 标签取代 echo
     1. [] 代替 array()
   - 5.6
     1. 增加可变参数，如`function sum(...$int) {}`，`sum(2, 3)`，使用可变参数`array_intersect($v, ...$vv)`;相当于一次传入了多个参数
     1. 常量增强
     1. 命名空间增强
   - 7.0
     1. 重构Zend引擎，显著提升性能可达两倍，内存消耗有所降低。性能提升为未来优化如JIT编译提供可能
     1. 优化错误处理机制，许多以前的致命错误现在被改为抛出异常
     1. 增加标量类型声明，包括int、float、string、bool
     1. 增加太空船运算符(组合比较符) <=>
     1. NULL合并运算符 ??
     1. 增强错误处理：许多致命错误和可恢复的致命错误被转换为异常，便于错误处理
   - 7.1
     1. 增加"类型推断"，是正在实现的JIT的前驱
     1. 增加可为空(Nullable)类型：类型声明允许使用?标记为可为空
     1. 多异常捕获：可以在一个catch块中捕获多个异常类型
   - 7.2
     1. sparse conditional constant propagation
     1. 逃逸分析
     1. 移除“死代码”（消除没有副作用的代码）
     1. 引入"HYBRID VM"虚拟机引擎
     1. 优化opcache
     1. 弃用__autoload、each()、assert
   - 7.3
     1. 性能提升：比7.0快22%，比5.6快3倍
   - 7.4
     1. PDO持久化：PDO支持持久化连接，提高了数据库操作的性能
     1. 增加声明类属性的类型
     1. 增加OPCache预加载，显著提高应用的启动速度
   - 8.0
     1. 引入JIT，显著提高PHP应用的执行速度
     1. 增加函数命名参数，提高了代码的可读性和灵活性。
     1. 联合类型：允许使用多个类型作为参数或返回值的类型声明
   - 8.1
     1. 增加枚举类型，用于表示一组命名的常量
     1. 增加声明只读的类属性，不能通过常规方式修改其值
     1. 增加Fiber协程，提供了一种轻量级的并发执行机制
   - 8.3
1. TSRM
   - 理解：Thread Safe Resource Manager，线程安全资源管理器，保证在单线程和多线程模型下的线程安全，和代码一致性
1. ts/nts
   - 查看：phpinfo()————Thread Safety
   - 分类   
     1. Thread Safe：线程安全，执行时会进行线程安全检查，防止有新要求就启动新线程的cgi执行方式耗尽系统资源
        - ISAPI执行方式以DLL动态库的形式使用，在处理完一个用户请求后不会马上消失，需要进行线程安全检查
     1. Non Thread Safe：非线程安全，执行时不进行线程安全检查
        - FastCGI执行方式以单一线程来执行操作，不需要检查，效率更高
#### 版本更新
1. php7
   - 整体：性能提升，内核更加健壮，抛弃了很多历史包袱，同时最大程度保证向前兼容，之前的代码基本可以无缝升级
     1. PHPNG代码合并到PHP7，速度是v5.6的3倍，内存消耗比v5.6低50％
     1. 一致的64位支持：不论32位64位机，变量占用不变
     1. 7.2是7.1的10%性能提升
   - 更新内容：标量和返回值类型、匿名类、常量数组、use增强、<=>、??、闭包对象绑定优化、层次异常扩展、原生的TLS
     1. ZEND引擎升级到Zend Engine 3，也就是所谓的PHP NG
     1. 增加抽象语法树，使编译更加科学
     1. 64位的INT支持，变量突破最大4G的限制
     1. 统一的变量语法
     1. 原生的TLS - 对扩展开发有意义
     1. 一致性foreach循环的改进
     1. 新增 <=>、**、?? 、\u{xxxx}操作符
     1. 增加了返回类型的声明
     1. 增加了标量类型的声明
     1. 错误处理：大多数错误被作为Error异常抛出，核心错误可以通过异常捕获了：很多致命错误以及可恢复的致命错误，都被转换为异常来处理，这些异常继承自Error类、实现了Throwable接口。PHP7实现了一个全局的throwable接口，原来的Exception和部分Error都实现这个接口，以接口的方式定义了异常的继承结构
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
     1. php4样式的构造函数(即和类名相同)，弃用
     1. 对非静态方法的静态调用，弃用。`class A { function b() {}}`，`A::b();`
   - 返回值类型声明
     1. 理解：参数和返回值增加了类型限定，可以是标量或者对象，如`function test(int $a, string $b, array $c) : int {}`
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
