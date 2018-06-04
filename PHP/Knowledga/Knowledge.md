### PSR
1. 解释：PHP Standards Recommendation，php推荐标准，是PHP-FIG组织制定的php推荐书写标准
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
### 算法
1. 理解：解决特定问题的步骤的描述，每个算法效率不一样
1. 特点：有穷性、确切性、输入项、输出项、可行性
1. 时间复杂度、空间复杂度
   - 时间复杂度：执行算法需要的计算量，是问题规模n的函数f(n)，记做T(n)=O(f(n))，即计算次数。如常数阶`O(1)`、线性阶`O(n)`、平方阶`O(n^2)`、对数阶`O(log2n)`
     1. 得出算法的计算次数公式
     1. 用常数1取代所有时间中的所有加法常数
     1. 只保留最高阶项
     1. 如果最高阶存在且不是1，则去除与这个项相乘的常数
   - 空间复杂度：需要的内存空间，包含代码所占空间，输入数据所占空间，辅助变量所占空间。和时间的表示一样
1. 常见排序算法
   - 冒泡排序：两两相邻的数进行比较，如果反序就交换。时间最坏/平均O(n^2)，空间O(1)
   - 直接插入排除：每次从无序表中取出第一个元素，插入到有序表的合适位置。时间最坏/平均O(n^2)，空间O(1)
   - 希尔排序：把待排序的根据增量分成几个子序列，对子序列插入排序，直到增量为1，直接插入排序。增量的排序一般是数组长度的一半，再变为原来增量的一版，直到为1。时间最坏O(n^2)/平均O(nlog2n)，空间O(1)
   - 选择排序：每次从待排序的数据中选出最大/小的元素，放在起始位置，直到排完。时间最坏/平均O(n^2)，空间O(1)
   - 堆排序：把待排序的元素按照大小在二叉树位置上排列，排序规则为父节点大于等于子节点，即堆化过程，如果根节点最大叫大根堆，最小小根堆，把根节点拿出来再堆化循环到最后一个节点。时间最坏/平均O(nlog2n)，空间O(1)
   - 归并排序：将两个或以上有序表合并为新的有序表，即把待排序序列分为若干有序的子序列，再把有序的子序列合并为整体有序序列。时间最坏/平均O(nlog2n)，空间O(n)
   - 快速排序：通过一趟排序将数据分割为两部分，一部分比另一部分所有数据都小，递归对两部分快排。时间最坏O(n^2)/平均O(nlog2n)，空间最坏O(n)/平均O(log2n)
1. 常见查找算法
   - 顺序查找：就按顺序找。时间最坏/平均O(n)，空间O(1)
   - 二分查找：从数组中间开始，命中结束，之后在偏向的方向查找。时间最坏/平均O(log2n)，空间迭代O(1)递归O(log2n)
   - 插值查找
   - 斐波那契查找
   - 树表查找
   - 分块查找
   - 哈希查找
1. 五大算法
   - 穷举法
   - 贪婪算法
   - 动态规划算法
   - 分治算法
   - 分治算法
   - 分支限界算法
1. 其他
   - 分治 Divide Conquer
   - 宽度优先搜索 Breadth First Search 
   - 深度优先搜索 Depth First Search
   - 回溯法 Backtracking
   - 双指针 Two Pointers
   - 动态规划 Dynamic Programming
   - 扫描线 Scan-line algorithm
   - 快排 Quick Sort
### 数据结构
1. Stack：栈，只有一个出口，先进后出
1. queue：队列，先进先出
1. list：线性表，长度有限，除了首尾其他元素首尾相接
   - LinkedList：链表，线性表一种，除了首尾其他元素首尾相接，顺序存储结构和链式存储结构两种方式
   - doubly-linked-list：双向链表，每个元素都是对象，都有一个关键字key两个指针next和prev
1. Array：数组，最简单最广泛，使用连续内存来存储，所有元素类型相同或衍生，可下标访问
1. Heap：堆，一般叫二叉堆，类似二叉树，子节点键值总小于父节点，节点邻居都是二叉堆，分大根堆小根堆
1. set：集合，不重复的元素
1. 哈希表 Hash Table
1. 二叉树 Binary Tree
1. 并查集 Union Find
1. 字典树 Trie
1. map：字典，键值对
1. graph：图，通常使用邻接矩阵和邻接表表示，前者对于稀疏矩阵浪费时间，后者检索时间复杂度高
### 调优
1. 编码级优化
   - 提前销毁大变量
   - 避免使用魔术方法耗性能
   - requiere_once耗性能
   - 少用正则
   - 不要用@符掩盖错误
   - 单引号代替双引号
1. 语言级优化
   - 部署环境：nginx+php-fpm方式
   - 框架选择
   - 缓存
     1. 程序层面的文件静态和优化比底层来的更有效、直接
     1. 开启opcode缓存：避免重复编译，如APC、xcache
     1. 本地缓存：如用xcache缓存元数据，不用每次读文件
   - 文件加载：一个文件操作胜过优化N个CPU指令
   - nginx开启gzip压缩
1. 配置优化
   - php.ini：memory_limit、session.save_handler、output_buffering
   - php-fpm：动态和静态的子进程管理，平衡cpu和内存，参数有pm、pm.max_children、pm.start_servers
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
### 函数大全
1. 字符串类
   - explode/str_split/preg_split/chunk_split           分割
   - trim/str_replace/preg_replace/preg_filter          替换
   - substr/strstr/preg_match/preg_match_all            截取
   - strlen/substr_count                                统计
   - strpos/stripos/strrpos/strripos                    位置
   - strrev/str_repeat/str_shuffle/rand                 其他操作
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
1. **的背面
   - 装饰者模式，在一个model里的多个方法定义要获取的select，最后用一个end方法将结果返回。其实是个伪装饰者，就是一个对象层层返回，类似orm查询，能放到一个model执行查询的就放，不行的就另起一个查询并添加数据到数组里。在controller里链式调用，最终组合出自己想要的结果。真正的装饰者人家不干预主逻辑，只是前后执行自己的逻辑
