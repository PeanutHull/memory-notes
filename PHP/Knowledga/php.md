### php
1. 认识：Hypertext Preprocessor/personal home pages/超文本预处理器，开源、用于产生动态网页的可嵌入HTML中的脚本语言，适合web开发
1. php模式：<?php ?>
1. php的学习层次
   - php技术深入：PHP字符串/数组/文件/高级特性/PHP运行原理
   - 编程思想：设计模式/并发/数据结构/算法
### 语法
1. 数据类型分类
   - 8种原始数据类型
     1. 标量：boolean、integer、float、string
     1. 复合：array、object
     1. 特殊：resource、null
   - 伪类型：mixed(所有)、number(int，float)、callback(V5.4)
1. 数据类型详解：php根据上下文在运行时决定变量的类型
   - bool：被认为false的： 0.0、"0"、[]
   - integer
     1. 八进制加0/十六进制加0x/二进制0b
     1. 整数溢出为float
   - float
     1. 字长和平台相关，通常是1.8e308，具有14位十进制数字的精度，754双精度格式
     1. 永远不要相信浮点数结果精确到了最后一位，也永远不要比较两个浮点数是否相等
     1. double==float，由于历史原因两者都存在
     1. is_nan判断是否为合法数值，is_finite()是否为有限值，is_infinite()是否为无限值
————————————以下没有好好的过手册——————————————
   - string
     1. 理解：由字符组成，每个字符等于一个字节，所以只支持256字符集，不支持Unicode。最大为2G
     1. 4种表达方式：单引号/双引号/heredoc/nowdoc——————待补充<<<结构即定界符
1. 数据类型操作
   - 类型获取：var_dump()，包括方法/类
   - 类型检测：is_int、is_string、不要用gettype()
   - 强制转换：紧贴变量，或中间隔空格
     1. (bool)/(boolean)
     1. (int)/(integer)
     1. (float)/(double)/(real)
     1. (string)/""
     1. (array)
     1. (object)
     1. (unset) // 转化为NULL
     1. (binary)/b // 转为二进制字符串 V5.2
 - settype()
1. 数组：php5.4+中，可以使用[]代替冗长的array()
1. 变量
   - 普通变量
     1. 特点：区分大小写
     1. 赋值：$xx=xx，传址赋值：$xx=&$xx，可变变量：$$a
   - 静态变量：静态变量只存在于函数作用域内，只存活在栈中。再次调用函数会保留
        ```
        function test(){
            static $nm = 1;
        }
        ```
   - 超全局变量
     1. $_ENV
     1. $_REQUEST：包含GET、POST、COOKIE 和 FILE 的数据
     1. $_POST
     1. $_GET
     1. $_FILES
     1. $_COOKIE
     1. $_SESSION
   - 特殊保留变量
     1. $this
     1. $_SERVICE
1. 常量
   - 理解：只能是标量，一旦定义不能修改/删除，可以不用$
   - 分类：用户常量/系统常量(预定义常量)：PHP_VERSION/PHP_O/PHP_EOL/true/false
   - 定义
     1. 全局变量：define('name', 'value');
        - 理解：任意地方定义和访问，不能在类中，大小写敏感，通常大写
        - 使用：常量名/constant()：用于用变量组合常量名得出常量值的情况，如`const PRICE_BUT = 1; constant(__CLASS__ . "::PRICE_" .strtoupper($prod));`
     1. 类常量：const name='value';
        - 理解：只能在类中定义常量，不能在条件语句中，const5.3之后也可在类外定义，是语言结构，比较快，和static不同的是没有权限限定符和不能修改值，7.1中可以加限定符
        - 使用：self::xxx、className::xxx
   - 特点
     1. const只接受静态标量，define可采用任何表达式
     1. const定义的常量时大小写敏感的，而define可通过第三个参数（为true表示大小写不敏感）来指定大小写是否敏感。
     1. 使用const使得代码简单易读，const本身就是一个语言结构。而define是一个函数，const在编译时比define快很多。
   - 检测：isset()/defined()
1. 运算符
   - 计算：%、++$a、$a--
   - 比较：==等于、===全等于，类型相同、!=或<>不等于
   - 赋值：=
   - 逻辑：与and/&&，或or/||，非!
   - 三元表达式：表达式 ? 值1 : 值2
   - 字符串连接符：.
1. 流程控制
   - 顺序自上而下执行，选择if，循环while/for/switch-case，break离开循环，continue跳过本次循环进入下次
1. 方法：
   - 闭包
     1. 理解：即匿名函数、闭包函数，最常用回调函数的参数，5.3之后使用use传递外面的值，使用传引用，将修改值生效，如`use($pro)`
     1. 示例
        ```
        // 将函数赋值给变量
        $func = function($str) {
            echo $str;
        };
        $func('some string');
        // 把匿名函数当做参数传递，并且调用它
        function callFunc( $func ) {
            $func( 'some string' );
        }
        ```
### 面向对象
1. 理解
   - 面向过程：优点：用什么功能就编写什么函数，注重实现细节。 缺点：数据管理较混乱集中在函数方面
   - 面向对象：万物皆对象，将构成问题的事务分解到各个对象上，建立对象不为完成特定工作，而是为描述某事务在解决问题中的行为更符合人思维习惯，代码重用性高，可扩展性好。是一种对现实世界理解和抽象的方法，事物抽象成对象，关系抽象成类、继承
1. 特性
   - 封装：成员方法和成员属性封装到类中，限定成员访问权限，数据被保护在内部
   - 继承：类之间的关系
   - 多态：重新改变类的属性或行为，多态就是把子类对象赋值给父类引用，然后调用父类的方法，去执行子类覆盖父类的那个方法。php多态比较弱。其实就是对象类型的变量。把对象赋给变量
1. 组成
   - 接口：接口是特殊的抽象类，接口所有的方法都是抽象方法，不能声明变量，能声明常量，接口可实现多继承，抽象类和普通类都能实现接口，接口没有构造函数，接口方法都是public
   - 抽象类：包含抽象方法的类，不定义具体的实现，类的强制继承，抽象类不能实例化只能继承，里面可定义普通方法，抽象类可以定义构造函数，只要类中有一个抽象方法，这个类就要定义为抽象类。抽象方法不能有主体即{}，子类必须全部重写父类抽象方法，访问控制只能更宽泛
   - 类：具有相同属性和方法的对象集合，只能实例化。类名首字母大写，一个文件可以写多个，规范就一个。一个类可实现多接口，只能继承一个抽象类
   - 对象：包含属性、方法，$this是当前对象的引用
1. 关键字
   - static：修饰静态变量、静态方法
   - self/parent：对当前/父类的引用
   - extends
   - final：标记类不能被继承、方法不能被覆写，不能用于变量
   - abstract：修饰抽象类和抽象方法，加上方法即为抽象方法
   - interface
   - implements
1. 类
   - 魔术常量
     1. __FILE__       文件完整路径和文件名
     1. __CLASS__      类名
     1. __LINE__    
     1. __METHOD__     方法名
     1. __FUNCTION__    
     1. 魔术变量
   - 魔术方法————13个
    1. 类的载入
       - __autoload()：实例化一个对象时，如果对应的类不存在，则该方法被调用
    1. 对象本身的实例化/销毁
       - __construct()：构造方法，实例化类时自动被调用，执行类初始化工作。可传参，无返回值，存在父子级覆盖问题
       - __destruct()：析构方法，对象在内存中销毁时自动执行，无参。例如最后一个类的对象赋值NULL时触发
    1. 属性
       - __get/set()：拦截器：外部读取、设置属性时自动调用
       - __isset/unset()：检测/删除一个对象时调用
    1. 方法
       - __call()：调用不存在方法时自动调用，可以屏蔽错误
    1. 对象序列化操作
       - __sleep()：serialize之前调用，若对象比较大，想删减一点东东再序列化，可考虑一下此函数
       - __wakeup()：unserialize时被调用，做些对象的初始化工作
    1. 克隆/打印
       - __clone()：克隆对象时被调用。如：$t=new Test();$t1=clone $t; 
       - __toString()：打印一个对象的时被调用。如echo/print，必须有返回值
   - 特点：方法名和类名相同即自动执行，类似__construct()
   - 方法：function_exists()、method_exists()
   - 静态类：速度快，效率高，直接加载到内存，省掉实例化类的空间，公用性强，使用时不生成对象就执行，不属于对象，不依赖对象调用，静态方法只能访问静态属性
     1. 静态变量：类变量/成员属性，属于类，只赋值一次，`static public $head=1;`
     1. 静态方法：类方法/成员方法，静态方法不能被非静态方法重写，`public  static function eat(){}`
     1. 简单的静态构造器：PHP没有静态构造器，你可能需要初始化静态类去给静态变量赋值
        ```
        function Demonstration(){
                return 'This is the result of demonstration()';
        }

        class MyStaticClass
        {
                //public static $MyStaticVar = Demonstration(); //!!! FAILS: syntax error
                public static $MyStaticVar = null;

                public static function MyStaticInit(){
                    //this is the static constructor
                    //because in a function, everything is allowed, including initializing using other functions
                    self::$MyStaticVar = Demonstration();
                }
        }
        //Call the static constructor
        MyStaticClass::MyStaticInit(); 
        echo MyStaticClass::$MyStaticVar;
        ```
   - 类的继承：让类能够具有可扩展性，使用`parent::__construct()`继承父级的初始化
   - 抽象类
        ```
        abstract class AbstractClass {
            // 强制要求子类定义这些方法
            abstract protected function getValue();

            // 普通方法（非抽象方法）
            public function printOut() {print $this->getValue() . PHP_EOL;}
        }

        class ConcreteClass1 extends AbstractClass {
            protected function getValue() {
                return "ConcreteClass1";
            }
        }
        ```
   - 接口
        ```
        interface demo{                         // 定义接口
            function method1();
            function method2();
        }
        class example implements demo{}         // 实现接口
        ```
1. 类的操作
   - 自动载入类，__autoload()
        ```
        function __autoload($classname){
            require_once $classname . '.class.php';
        }
        // MyClass1类不存在时，自动调用__autoload()函数，传入参数”MyClass”
        $obj = new MyClass();
        ```
   - 反射API：`$reflector = new ReflectionClass('A');`
   - 相关函数
     1. class_exists()
     1. get_class()
     1. get_class_methods()
     1. interface_exists()：检查接口是否已被定义
### 应用
1. 会话控制：由于http协议的无状态性，使用cookie鉴别用户。`setcookie(name,value,time() + 3600,'/');`
1. 编解码
   - web传输
     1. urlencode转换-_.，空格转为+。rawencode把空格转为%20。urlencode转换字符，http_build_query转换数组
     1. urldecode解码
   - web展示
     1. strip_tags：去掉所有HTML/PHP的标记字符
     1. htmlspecialchars：特殊字符转成实体，只转4个:[" & < >]，如"(双引号)转成&quot;。htmlentities:将所有字符转成html格式
     1. addslashes/stripslashes：addslashes是使用反斜线引用字符串，数据库操作的必要步骤，给'、"、\、NULL字符加反斜线，stripslashes是去除反斜线，有两个就留一个，一个就去除
   - base64_encode：可用于邮件传输，但是处理后有/ + =等危险字符，url编码中+代表空格
   - json：默认将中文转为unicode，使用`json_encode($message, JSON_UNESCAPED_UNICODE);`保留中文
   - serialize()/unserialize()
   - gzcompress()/gzuncompress()
1. 加密
   sha1：用于校验文件完整性，是否被篡改，可生成一个160位校验值，不可逆
1. 正则
   - 匹配手机号：`preg_match("/^(1([34578]))\d{9}$/", $mobile)`
   - 4到6位数字：`preg_match("/^\d{4,6}$/", $code)`
1. 日期时间
   - date()        把时间戳转换为日期，不传时间戳则为服务器的当前时间
   - mktime()      日期转为时间戳
   - strtotime()   把人类可读的字符串转为时间戳，强大，啥都能转
        ```
        strtotime("10:38pm April 15 2015");
        strtotime("tomorrow");
        strtotime("next Saturday");
        strtotime("+3 Months");
        strtotime("+1 weeks",strtotime("Saturday"));    // 下周六的日期
        $d1=strtotime("December 31");                   // 12月30日之前的天数
        $d2=ceil(($d1-time())/60/60/24);
        echo "距离十二月三十一日还有：" . $d2 ." 天。";
        ```
1. 文件/目录处理
   - 引入文件：once确保文件只被包含一次，避免函数重定义、变量重新赋值
     1. include()/include_once()：运行前引入、运行次数越多效率越高，如`include('route.php');`，需要PHP引擎去include_path中迭代查找所有名称为'include.php'才能查找到相应对象，要直接指明文件路径
     1. require()/require_once()：用到才引入
   - 获取文件信息
     1. 内容：file_get_contents()，获取长度是正确的，但变量长度受到内存制约，读取超过php memory limit的文件触发PHP Fatal Error        
     1. 类型：mime_content_type($filename)
     1. 大小：stat()/filesize()，在部分x86系统上读取大于2GB文件会报错
   - 操作
     1. 判断文件和目录是否存在，is_file和is_dir的速度都比file_exists快，不论传入的是目录还是文件，只要存在就true
     1. glob()查找文件、scandir()浏览目录
     1. 连续两次dirname(dirname(__FILE__))可获得当前文件目录的上上级目录
     1. mkdir(path, 0777, true) 递归创建文件夹
1. curl：curl_getinfo可获取Content-Length参数
1. cli模式和脚本
   - 运行命令
        1. 设定脚本名：cli_set_process_title('ocstaskworker')
        1. 执行脚本：shell_exec()
        1. 检查是否有相同的脚本正在运行：$cmd = "ps aux | grep -i 'ocstaskworker' | grep -v grep | wc -l";
   - 参数
     1. php -h
     1. php -m // 查看安装了哪些扩展
### 运维
1. PHP安装
1. PHP配置：修改php.ini
   - php标签
   1. 只使用<?php，无结束符，防止输出空格。也可以用`<script language="php"></script>`
### wiki
1. 规范
   - 命名空间：解决重名的作用，有use、\
   - psr
1. 代码执行顺序：从左至右，从里到外
    ```
    function myfunc($a){
        echo $a + 10;
    }
    $val = 10;
    echo "myfunc($val)=".myfunc($val); //输出结果为20myfunc(10)
    ```
1. PHP工作模式
   - CGI
     1. 理解：CGI，通用网关接口，即外部应用程序和web服务器之间的接口标准，CGI允许web服务器执行外部程序，并将输出发回web服务器。早期动态网页处理程序只能处理一个请求
     1. 原理
        - 遇到请求——创建子进程——处理，即fork-and-execute模式
        - 请求数=cgi子进程数，子进程的反复加载是cgi性能低下的原因，会大量占用cpu和内存
        - 每个web请求都必须重新解析php.ini，重新载入全部扩展，初始化全部数据结构
     1. 特点
        - 跨平台性极佳
        - 性能低下
   - Module
     1. 理解：将php集成到web服务器，以同一个进程运行。php作为apache的模块，预先生成多个进程副本驻留内存，一旦请求出现就立即响应，省去创建子进程的延迟，处理完成后不退出，等待下次请求。
   - FastCGI
     1. 理解：类似常驻型cgi，php使用PHP-FPM(FastCGI Process Manager)即进程管理器进行管理。CGI解释器保持在内存中并接受FastCGI的调度，类似线程池的技术特性
     1. 原理：
        - web服务器载入FastCGI进程管理器
        - FastCGI自身初始化，启动多个cgi解释器进程等待调用
        - 请求到达时，FastCGI选择并连接到一个cgi解释器
     1. 特点
        - 所有配置只在进程启动时加载一次
        - PHP死掉不会带死apache，而且会立即启动一个新的php进程
        - FastCGI是适用高并发场景的，对web服务器不挑可以自由更换
        - php5.3.29之后自带fpm，之前需要另外加载模块
   - ISAPI
     1. 理解：微软提供的一套面向Internet服务的API接口，ISAPI的dll被请求激活后常驻内存，不停接受请求。dll和web服务器处于同一个进程中
     1. 特点
        - 微软的排他性，只能在windows运行
        - 效率高于CGI
        - 稳定性不好，php出错，apache也死掉
   - Apache的工作模式
     1. CGI模式
        - 用法：`Action application/x-httpd-php "/php/php-cgi.exe"`
        - 原理：apache调用php.exe去解释文件，再将结果以网页的形式返回给客户机
     1. 模块模式：
        - 用法：`LoadModule php5_module "c:/php/php5apache2.dll"`
        - 原理：php和apache一起启动并运行
     1. FastCGI模式：
        - 用法：1. 下载fastcgi模块mod_fcgid.so/mod_fcgid.pd。2. 添加配置
   - 流行的三种模式，后两种性能更高些
     1. Apache+mod_php5
     1. lighttp+spawn-fcgi
     1. nginx+PHP-FPM
1. 内存中的体现
   - 栈空间段：存储占用相同空间长度并且占用空间小的数据类型，可直接存取，存对象名称
   - 堆空间段：不定长、体积大，不可直接存取，存对象。通过名称找对象
   - 代码段
   - 初使化静态段:存放静态属性和方法，类第一次被加载即放入，可被堆内存的对象所共享
