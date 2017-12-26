### 设计模式
1. 理解
   - 是遇到问题的解决方案，是自下而上的，来源于实践，发现模式而不是发明模式
   - 是特定环境下同类问题的解决方案，但是实现细节却有非常多的差别
   - 问题是所有的基础
   - 设计模式是语言无关的
1. 组成
   - 组成：命名、问题、解决方案、效果
   - 格式：意图、动机、适用性、结构交互、实现、相关模式的合作
1. 原则
   - 开闭原则：模块应对扩展开放，而对修改关闭
   - 里氏代换原则：如果调用的是父类的话，那么换成子类也完全可以运行
   - 依赖倒转原则：抽象不依赖细节，面向接口编程，传递参数尽量引用层次高的类
   - 接口隔离原则：每一个接口只负责一种角色
   - 合成/聚合复用原则：要尽量使用合成/聚合，不要滥用继承
1. 意义
   - 好处：好的代码风格，易读性，扩展性强，稳定性好
   - 不能解决：是组织代码的模板，不是直接调用库，不要一味追求并套用，合理就好
1. 分类：23种设计模式
   - 创建型
     1. 单例模式、工厂模式（简单工厂、工厂方法、抽象工厂）、创建者模式、原型模式
   - 结构型
     1. 适配器模式、桥接模式、装饰模式、组合模式、外观模式、享元模式、代理模式
   - 行为型
     1. 模版方法模式、命令模式、迭代器模式、观察者模式、中介者模式、备忘录模式、解释器模式、状态模式、策略模式、职责链模式、访问者模式
1. 单例模式
   - 理解：创建型模式，它是建立在面向对象基础上的，要确保某个类只有一个实例，避免不断重新new浪费资源，完善全局变量的功能。php的所有在页面执行完后全部清空削弱了单例的表现
   - 要点
     1. 类只能有一个实例
     1. 它自己自行创建这个实例
     1. 它必须自行向整个系统提供这个实例
   - 基础例子
        ```
        class User{
            static private $_instance = NULL;               // 静态成员变量，保存全局实例
            private function  __construct() {}              // 私有化构造函数，防止外界实例化对象从而失去单例模式的意义

            static public function getInstance() {          // 单例统一访问入口，返回对象的唯一实例
                if (!isset(self::$_instance)) {
                    self::$_instance = new self();
                }
                return self::$_instance;
            }
        }
        
        $obj = User::getInstance();                         // 获得实例
        ```
   - 克隆和继承
        ```
        class Foo {
            static private $instances = [];
            protected function __construct() {}
            final private function __clone() {}             // 私有化克隆函数，防止外界克隆对象

            final static public function getInstance() {
                $class = get_called_class();

                if (!isset(self::$instances[$class])) {
                    self::$instances[$class] = new static;
                }
                return self::$instances[$class];
            }
        }

        class Bar extends Foo {}
        $foo = Foo::getInstance();
        $bar = Bar::getInstance();
        ```
1. 工厂模式
   - 理解：创建型模式，定义一个由工厂方法或者类生成对象的工厂，让子类决定实例化哪一个类
   - 适用性：有众多子类并且会扩充，创建方法比较复杂的情况下适用。工厂类在多态性编程实践中是至关重要的，它允许动态的替换类，修改配置，使程序更加灵活
   - 分类：
     1. 简单工厂：未严格遵循开闭原则，增加新产品时需修改工厂代码。用于客户只知道传入工厂类的参数，对于如何创建对象不关心的场景
        ```
        interface Person {                              // 抽象产品
            public function getName();
        }
        class Teacher implements Person {               // 具体产品实现
            function getName() {
                return "老师";
            }
        }
        class SimpleFactory {                           // 简单工厂
            public static function getPerson($type) {
                if ($type == 'teacher') {
                    $person = new Teacher();
                } elseif ($type == 'student') {
                    $person = new Student();
                }
                return $person;
            }
        }
        ```
     1. 工厂方法：只有一条产品线，抽象工厂的简化。工厂方法严格遵守开闭原则。当一个类希望由子类来指定它所创建的对象，将创建对象的职责委托给多个帮助子类中的某一个，并且你希望将哪一个帮助子类是代理者这一信息局部化的时候使用
     1. 抽象工厂：有多条产品线，系统提供一个产品类的库，所有的产品以同样的接口出现，从而使客户端不依赖于实现。无论是简单工厂模式、工厂模式还是抽象工厂模式，它们本质上都是将不变的部分提取出来，将可变的部分留作接口，以达到最大程度上的复用
1. 注册树模式
   - 意图：全局共享/交换对象
### PSR
1. 解释：PHP Standards Recommendation，是PHP-FIG组织制定的php推荐书写标准
1. 分类
   - PSR-1：基本的代码风格
     1. 标签   php代码必须在<?php ?>中
     1. 编码   必须使用utf8，不能有字节顺序标记(BOM Byte Order Mark)
     1. 常量   全部大写，可用下划线
     1. 类名   必须驼峰
     1. 方法名 小写开头+驼峰
     1. 加载   命名空间和类必须遵守psr-4自动加载器标准
     1. 目的   一个php文件，要么定义符号，要么执行操作，不能同时做
   - PSR-2：严格的代码风格
     1. 贯彻   首先遵守psr-1
     1. 缩进   四个空格
     1. 文件和代码行、关键字、命名空间、类、方法、可见性、控制结构
   - PSR-3：日志记录器接口，不是指导，是一个接口
   - PSR-4：自动加载，命名空间前缀和文件系统的目录对应起来，代替PSR-0(已弃用)
   - PSR-7：http通信标准
1. 注释书写参考
   - @access
   - @param  string|array
   - @static
   - @return  void|
   - @desc
   - @example
   - @version
### 函数大全
1. 字符串类
   - serialize
   - preg_split
   - split
   - chunk_split
   - strpos
   - str_split
   - explode
   - trim
   - strrev
   - substr
   - mb_substr
   - iconv_substr
   - mb_strlen
   - mb_strcut
   - preg_replace
   - preg_match
   - preg_match_all
   - chr
   - ord
   - str_repeat
   - substr_count
   - str_shuffle
1. 数组类
   - implode别名join
   - array_diff
   - array_column
   - array_unique
   - array_sum
   - empty(只能检测变量)
   - count
   - array_merge
   - in_array
   - array_pop
   - array_push
   - array_shift
   - array_values(键名全置数字)
   - array_slice
   - list(给一组变量赋值)
   - each
   - reset
   - ksort
   - array_reverse
   - serialize()     序列化
   - unserialize()   反序列化
1. 判断类
   - is_null
   - is_int
   - is_array
   - is_string
   - is_file
   - is_dir
   - is_writeable
   - empty
   - in_array
   - function_existsde
1. 编码类
   - json_decode
   - iconv
   - mb_convert_encoding
   - htmlentities
   - htmlspecialchars
   - htmlspecialchars_decode
   - strip_tags
   - addslashes
   - stripslashes
   - quotemeta
   - nl2br
   - strip_tags
   - mysql_real_escape_string
   - mysql_escape_string
   - base64_decode
   - base64_encode
   - rawurldecode
   - rawurlencode
   - urldecode
   - urlencode
1. 常变量
   - const
   - define
   - defined
   - constant
1. 类类
   - class_exists();
   - get_class();
   - get_class_methods();
   - interface_exist();
   - instanceof
   - func_get_args
1. 时间类
   - time
   - date
   - strtotime
   - microtime
   - mktime
1. 文件类
   - is_writeable
   - is_readable
   - unlink
   - mkdir
   - readfile
   - filetime
   - basename
   - dirname
   - rename
   - pathinfo
   - file_get_content
   - file_put_content
   - is_file
   - is_dir
   - file_exist
   - filesize
   - stat
   - getcwd
   - getimagesize
   - getimagesizefromstring
   - move_uploaded_file
1. 网络类
   - http_build_query
   - file_get_contents
   - fopen
   - fget
   - fgetc
   - fclose
   - ldap_connect
   - header
1. 安全类
   - md5
   - sha1
   - crypt
   - addslashes
   - stripslashes
   - mysql_real_escape_string
1. 数学类
   - cadd 精度加法
   - bcsub 精度减法
   - bcmul 精度乘法
   - bcdiv 精度除法
   - bcscale 精度小数点保留位数
   - bccomp 精度比较
   - bcmod 精度取模
   - bcpow 精度成方
   - bcsqrt 精度二次方根
   - gmp 函数，专业计算
   - intval
   - number_format
   - rand
   - mt_rand
   - pow
   - uniqid
   - round
   - abs 绝对值
1. 系统类
   - onst
   - list
   - getenv
   - putenv
   - shell_exec
   - system
   - extract
   - var_export
   - var_dump
   - call_user_func_array
   - fastcgi_finish_request
   - ignore_user_abort
   - register_shutdown_function
   - set_time_limit
