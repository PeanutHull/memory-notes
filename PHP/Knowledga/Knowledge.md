### 基本
1. 数据类型详解：php根据上下文在运行时决定变量的类型
   - bool：被认为false的：0.0、"0"、[]
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
     1. 理解：由字符组成，每个字符等于一个字节，所以只支持256字符集，不支持Unicode。最大为2G，v7.0支持大于2G
     1. 4种表达方式：单引号/双引号/heredoc/nowdoc
        - 单引号：不能解析变量和转义字符
        - 双引号：可以解析变量和任意转义字符，变量可以用特殊字符&等和{}包含，如"abcd'{$a}'ef"，为提高效率'abcd\''.$a'\'ef'
        - Nowdoc类似单引号
        - Heredoc类似双引号，用于长字符串大文本，<<<定界符后边跟自定义字符串以作为结束符，可以解析变量，不转义'
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
     1. settype()
1. 代码执行顺序：自上而下，从左至右，从里到外
```php
function myfunc($a){
    echo $a + 10;
}
$val = 10;
echo "myfunc($val)=".myfunc($val);          //输出结果为20myfunc(10)
```
1. 闭包
   - 理解：即匿名函数、闭包函数，最常用回调函数的参数，v5.3之后使用use传递外面的值(传引用)，将修改值生效。闭包类 Closure，闭包都是Closure类的实例
   - 示例
    ```php
    $func = function($str) {         // 将函数赋值给变量
        echo $str;
    };
    $func('some string');
    function callFunc( $func ) {     // 把匿名函数当做参数传递，并且调用它
        $func( 'some string' );
    }
    ```
1. 使用`parent::__construct()`继承父级的初始化
1. 静态方法：`public static function eat(){}`
1. 简单的静态构造器：PHP没有静态构造器，你可能需要初始化静态类去给静态变量赋值
```php
function Demonstration(){
    return 'This is the result of demonstration()';
}
class MyStaticClass {
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
1. 抽象类
```php
abstract class AbstractClass {
    abstract protected function getValue();                             // 抽象方法
    public function printOut() {print $this->getValue() . PHP_EOL;}     // // 普通方法
}
class ConcreteClass1 extends AbstractClass {
    protected function getValue() {}
}
```
1. 接口
```php
interface demo {                         // 定义
    function method();
}
class example implements demo{}          // 实现
```
1. cookie：`setcookie(name,value,time() + 3600,'/');`
### 应用
1. strtotime
```php
strtotime("10:38pm April 15 2015");
strtotime("tomorrow");
strtotime("next Saturday");
strtotime("+3 Months");
strtotime("+1 weeks",strtotime("Saturday"));    // 下周六的日期
$d1=strtotime("December 31");                   // 12月30日之前的天数
$d2=ceil(($d1-time())/60/60/24);
echo "距离十二月三十一日还有：" . $d2 ." 天。";
```
1. fopen
```
$fp = fopen("/tmp/lock.txt", "w+");
if (flock($fp, LOCK_EX)) {                      // 排它型锁定
    fwrite($fp, "Write something here\n");
    flock($fp, LOCK_UN);                        // 释放锁定
} else {
    echo "Couldn't lock the file !";
}
fclose($fp);
```
1. php页面跳转方法
   - header
    ```php
    header("HTTP/1.1 303 See Other");
    header('Location:xxx');exit;
    exit;                                // 不然会继续执行
    ```
   - javascript：`window.location.href`、`window.open`
   - echo标签跳转：META(HTTP-EQUIV)、script(window.location.href、window.open)
1. 图像输出到浏览器或者文件
```php
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
```
1. curl：curl_getinfo可获取Content-Length参数
```php
$ch = curl_init();
curl_setopt($ch , CURLOPT_URL, $url);
curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch , CURLOPT_TIMEOUT, $timeout);
$result = curl_exec($ch);
curl_close($ch);
```
1. 数学
   - mt_rand产生随机数的速度是旧的rand函数的4倍
     1. mt_getrandmax 显示随机数的最大可能值
     1. mt_srand 播下更好的随机数种子
   - 获得指定范围随机浮点数：`return $min + mt_rand() / mt_getrandmax() * ($max - $min);`
1. 脚本：以web服务器的权限来执行
   - fastcgi_finish_request
   - ignore_user_abort
   - register_shutdown_function
   - set_time_limit
   - cli_set_process_title：设定脚本名
   - shell_exec、system，exec，passthru，pcntl_exec：执行脚本
   - memory_get_usage：当前内存
   - memory_get_peak_usage 峰值内存
   - getrusage：CPU信息，win不行
1. 输出缓存区：所有输出的内容放入缓存区
```php
// 实现动态内容静态化
<?php
$cache_name = md5(__FILE__).'.html';
$cache_lifetime = 3600;
if(filectime(__FILE__) <= filectime($cache_name) && file_exists($cache_name) && filectime($cache_name) + $cache_lifetime > time()) {
    include $cache_name;
    exit;
}
ob_start();
?>

<p>This is page</p>

<?php
$content = ob_get_contents();
ob_end_flush();
file_put_content($cache_name, $content);
?>
```
### pro
1. spl_autoload_register
```php
// 遵守PSR-4规范的自动载入简单实现
class Loader {                                                                  // 加载类
    public static $vendorMap = array(                                           // 路径映射
        'app' => __DIR__ . DIRECTORY_SEPARATOR . 'app',
    );
    public static function autoload($class) {                                   // 自动加载器
        $file = self::findFile($class);
        if (file_exists($file)) {
            self::includeFile($file);
        }
    }
    private static function findFile($class) {                                  // 解析文件路径
        $vendor = substr($class, 0, strpos($class, '\\'));                      // 顶级命名空间
        $vendorDir = self::$vendorMap[$vendor];                                 // 文件基目录
        $filePath = substr($class, strlen($vendor)) . '.php';                   // 文件相对路径
        return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR);        // 文件标准路径
    }
    private static function includeFile($file) {                                // 引入文件
        if (is_file($file)) {
            include $file;
        }
    }
}
// 使用
include 'Loader.php';                                       // 引入加载器
spl_autoload_register('Loader::autoload');                  // 注册自动加载

new \app\mvc\view\home\Index();                             // 实例化未引用的类
```
### IoC、DI
1. Ioc：Inversion of Control，控制反转，意味着将你设计好的对象交给容器控制，而不是传统的在你的对象内部直接控制。由外部负责其依赖需求的行为，我们可以称其为控制反转。容器控制应用程序，由容器反向的向应用程序注入应用程序所需要的外部资源
   - 为解决多个类之间的依赖
1. DI：依赖注入，应用程序依赖容器创建并注入它所需要的外部资源
1. 区别：ioc从容器的角度，di从应用程序的角度，ioc是目的，di是手段。是同一件不同层面的解读
1. 简单举例
   - 工厂模式和依赖：类所依赖的外部事物的实例都可以被一、多个工厂创建的开发模式即"工厂模式"
        ```
        class SuperModuleFactory {                                          // 工厂方法，创建超人技能模块
            public function makeModule($moduleName) {
                switch ($moduleName) {
                    case 'Fight': 
                        return new Fight();
                    case 'Shot': 
                        return new Shot();
                }
            }
        }
        class Superman {                                                    // 超人类
            protected $power;

            public function __construct(array $modules) {
                $factory = new SuperModuleFactory;                          // 初始化工厂

                foreach ($modules as $moduleName) {                         // 通过工厂提供的方法制造需要的模块
                    $this->power[] = $factory->makeModule($moduleName);
                }
            }
        }
        // 结果：轻松实例化不同超人，扩展的话增加或修改工厂方法即可        
        ```
   - 依赖注入：工厂模式的问题，只是由对多个外部类的依赖变成了对一个"工厂"的依赖。有了统一的接口实现(契约)，就可以动态注入依赖
        ```
        interface SuperModuleInterface {
            public function activate();
        }
        class Superman {
            protected $module;

            public function __construct(SuperModuleInterface $module) {
                $this->module = $module;
            }
        }
        // 依赖注入典型示例
        $superModule = new XPower;                                          // 实例化技能模块
        $superMan = new Superman($superModule);                             // 注入技能模块依赖
        ```
   - IoC容器：工厂模式的升华，向工厂提交一个脚本，工厂通过指令自动化生产
        ```
        class Container {                                                   // 容器
            protected $binds;
            protected $instances;

            public function bind($abstract, $concrete) {
                if ($concrete instanceof Closure) {
                    $this->binds[$abstract] = $concrete;
                } else {
                    $this->instances[$abstract] = $concrete;
                }
            }
            public function make($abstract, $parameters) {
                if (isset($this->instances[$abstract])) {
                    return $this->instances[$abstract];
                }
                array_unshift($parameters, $this);

                return call_user_func_array($this->binds[$abstract], $parameters);
            }
        }
        $container = new Container;
        $container->bind('superman', function($container, $moduleName) {    // 添加超人生产脚本
            return new Superman($container->make($moduleName));
        });
        // 添加超能力模组的生产脚本
        $container->bind('xpower', function($container) {
            return new XPower;
        });
        // 开始启动生产
        $superman_1 = $container->make('superman', 'xpower');
        $superman_2 = $container->make('superman', 'ultrabomb');
        // 结果：解决了类和外部类的依赖关系，容器类也没有和外部类有依赖。通过注册/绑定的方式向容器中添加可被执行的回调(匿名函数、函数、类的方法)作为类的实例的脚本，只有生产时才触发。真正的IoC容器会根据类的需求，自动注册/绑定符合需求的依赖，自动注入到构造函数中去，通过反射
        ```
   - 关键词：控制反转, 依赖注入, 工厂模式, 契约, IoC容器, 服务容器, 服务提供者，反射
1. AOP：面向切面编程，剖开封装的对象内部，并将影响多个类的公共行为封装到一个模块。是OOP的补充完善
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
1. 装饰着模式
   - 认识：动态地给一个对象增加一些额外的职责，对于扩展比继承更有弹性。
   - 原理：将一个类的对象嵌入另一个对象中，由另一个对象来决定是否调用嵌入对象的行为以便扩展自己的行为，我们称这个嵌入的对象为装饰器
### 函数大全
1. 字符串类
   - explode/str_split/preg_split/chunk_split           分割
   - trim/str_replace/preg_replace/preg_filter          替换
   - substr/strstr/preg_match/preg_match_all            截取
   - strlen/substr_count                                统计
   - strpos/stripos/strrpos/strripos                    位置
   - strrev/str_repeat/str_shuffle/rand                 其他操作
   - printf/vprintf/vsprintf                            格式化
1. 数组类
   - implode
   - count/in_array
   - sort/ksort/asort/array_multisort/usort/shuffle                                 k是键，默认和a是值，r倒序，u自定义
   - array_keys/array_values/array_slice/array_chunk/preg_grep/array_column         数据获取
   - array_pop/array_push/array_shift/array_unshift                                 元素处理
   - each/reset/current/next                                                        指针处理
   - array_unique/array_sum/array_reverse                                           加工处理
   - array_diff/array_merge                                                         多数组处理
   - list                                                                           把数组值给一组变量赋值，是语言结构
   - array_change_key_case                                                          修改健名大小写
1. 判断类
   - empty/isset                                        empty不存在或值等于false，isset变量存在且不是null，都不报错
   - defined/constant/get_defined_constants             常量
   - is_dir/is_link/is_file/file_exist/is_readable
   - get_class/call_user_func                           反射族
1. 编码类
   - chr/ord                                                ascii转换
   - iconv/iconv_substr                                     字符集转换
   - mb_convert_encoding/mb_strlen/mb_strcut/mb_substr      多字节字符串处理
   - hex2bin/pack                                           进制处理
   - json_encode/json_decode                                json编解码
   - base64_encode/base64_decode                            mime base64编解码
   - convert_uuencode                                       uuencode编解码
   - urlencode/urldecode                                    url编码，空格转为+
   - rawurlencode/rawurldecode                              url编码，空格转为%20
   - addslashes/stripslashes                                斜线转义
   - htmlentities                                           html转义编解码
   - htmlspecialchars/htmlspecialchars_decode/strip_tags    特殊字符、html实体转换
   - quotemeta/nl2br
   - serialize/unserialize                                  字符序列化
1. 时间类
   - date_default_timezone_set
   - time/microtime
   - mktime/strtotime
   - date
1. 文件类
   - mkdir
   - dirname
   - basename
   - getcwd
   - pathinfo
   - filetime
   - rename
   - stat
   - file_get_content/file_put_content
   - fopen
   - fread/fgets/fgetc
   - readfile
   - filesize
   - unlink
   - getimagesize
   - move_uploaded_file
1. 网络类
   - http_build_query
   - fopen/file_get_contents
   - ldap_connect
   - header
1. 安全类
   - md5/md5_file
   - sha1
   - crypt
   - addslashes/stripslashes
   - escapeshellarg
   - mysql_escape_string
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
   - pow
   - uniqid
   - round
   - abs 绝对值
   - rand/mt_rand
1. 系统类
   - const
   - getenv/putenv
   - ini_set/ini_get
   - php_sapi_name
   - set_include_path/get_include_path
   - shell_exec/system/proc_open
   - extract
   - set_time_limit
   - fastcgi_finish_request
   - ignore_user_abort
   - register_shutdown_function
   - echo 
   - print/printf/print_r/sprintf
   - var_dump/var_export
   - getmypid
1. 函数处理
   - function_exists
   - call_user_func/call_user_func_array
   - forward_static_call/forward_static_call_array
   - func_get_arg/func_get_args/func_num_args
   - get_defined_functions
   - register_shutdown_function
   - register_tick_function/unregister_tick_function
1. 资源
   - is_resource/get_resource_type
1. **的背面
   - 装饰者模式，在一个model里的多个方法定义要获取的select，最后用一个end方法将结果返回。其实是个伪装饰者，就是一个对象层层返回，类似orm查询，能放到一个model执行查询的就放，不行的就另起一个查询并添加数据到数组里。在controller里链式调用，最终组合出自己想要的结果。真正的装饰者人家不干预主逻辑，只是前后执行自己的逻辑
### 版本更新
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
     1. 核心错误可以通过异常捕获了：很多致命错误以及可恢复的致命错误，都被转换为异常来处理，这些异常继承自Error类、实现了Throwable接口。PHP7实现了一个全局的throwable接口，原来的Exception和部分Error都实现这个接口，以接口的方式定义了异常的继承结构
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