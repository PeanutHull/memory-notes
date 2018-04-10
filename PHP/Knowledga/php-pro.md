### 命名空间、文件载入
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
     1. 查找逻辑：找到即终止
        - 如果给出路径按照路径查找
        - 从include_path查找
        - 从调用脚本目录和当前工作目录查找
     1. 分类
        - include()/include_once()：运行前引入、运行次数越多效率越高，出错产生警告
        - require()/require_once()：用到才引入，出错抛出错误并终止脚本
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
### Reflection
1. 理解：反射，是在php运行过程中分析php程序，提取类/对象/方法/属性/参数/注释等信息。获取信息和调用对象的方法叫做反射api，是php内建的oop扩展
1. 分类
   - 反射api：非常强大，任何信息都可以获取
    ```php
    $class = new ReflectionClass('Person');                                     // 建立Person类的反射类
    $instance  = $class->newInstanceArgs($args);                                // 实例化Person类
    $properties = $class->getProperties(ReflectionProperty::IS_PUBLIC);         // 获取公共属性
    $ec=$class->getmethod();                                                    // 获得方法
    $ec->invoke($instance);                                                     // 执行方法  
    ```
   - 函数
     1. interface_exist
     1. class_exists
     1. get_class
     1. get_class_methods
     1. instanceof
     1. func_get_args
     1. call_user_func_array
### Trait
1. 理解：特质,是一种为类似PHP的单继承语言而准备的代码复用机制，使开发人员能够自由地在不同层次结构的独立的类中复用方法集。来避免传统多继承和混入类（Mixin）相关的典型问题，就是先定义trait，用use给类插入代码，代码复用，属于类与对象，v5.4
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
### 并发处理
1. 进程、线程、协程
   - 进程：是某数据集合上的一次运行活动，是系统进行资源分配和调度的基本单位，是操作系统结构的基础
     1. 三态模型：多程序系统中，进程在处理器上交替运行，状态不端变化
        - 运行：此状态的进程数小于等于处理器数，没有进程可执行时通常自动执行系统空闲进程
        - 就绪：获得了除处理机的所有资源，可按多个优先级划分队列。如由于时间片用完进入就绪状态时进入低优先级，io操作完成进入高优先级
        - 阻塞：也是等待、睡眠状态，即等待某一事件发生(如请求io而等待)，暂时停止运行，即使给了处理器也无法运行
     1. 五态模型：进程的状态和转换更复杂
        - 新建：进程刚刚创建没有被提交的状态，等待系统完成创建所有的必要信息
        - 活跃就绪：在内存中可被调度的状态，
        - 静止就绪：被对换到辅存时的就绪状态，不能直接被调度，没有活跃就绪或者自身更优先，系统则将其调回主存转为活跃
        - 运行
        - 活跃阻塞：在主存，一旦等待事件产生进入活跃就绪状态
        - 静止阻塞：在辅存，一旦等待事件产生进入静止就绪状态
        - 终止：进程终止运行，回收除进程控制块之外的其他资源，并让其他进程从进程控制块中收集信息
   - 线程：程序执行流的最小单元，可由系统独立调度和分派cpu，线程可以创建和撤销另一个线程，多线程可并发执行
     1. 就绪：同进程
     1. 运行：占有处理机正在运行
     1. 阻塞：等待一个事件，如某个信号量，逻辑上不可执行
   - 协程：是用户态的轻量级线程，由用户控制调度。有自己的寄存器上下文和栈，协程调度切换时，将二者保存到其他地方，切回来恢复之前的，直接操作栈基本没有内核切换开销，可不加锁的访问全局变量，所以上下文切换非常快。
   - 进程和线程
     1. 线程是进程中的实体、执行单元。所有线程共享进程地址空间，进程是资源分配和拥有的单位，进程有自己的地址空间
     1. 一个程序最少有一个线程，就是程序本身。线程是处理器调度的基本单位，进程不是
     1. 都可并发执行
     1. 每个线程都有运行入口、顺序执行序列、程序出口，不能独立执行，必须在程序中由程序提供多个线程执行的控制
   - 线程和协程
     1. 线程、进程都可有多个协程
     1. 线程进程都是同步，协程是异步
     1. 协程能保留上一次调用时的状态，每次过程重入时，相当于进入上一次的状态
   - 多线程、多进程
     1. 多进程：多个进程同时运行，多分配了一份资源，进程间通讯不方便，边玩游戏边听歌
     1. 多线程：同时运行，可以直接通信
php reactor
1. 同步阻塞模型、异步非阻塞
1. 并发编程实战
#### 协程
1. 理解：在同一进程或线程中运行多个任务，即将任务切换的部分工作从内核转移到应用层，这种解决方案称为协程。任务调度器
1. 特点
   - 为应用层实现多任务提供了工具
   - 协程不允许多任务同时执行，要执行其它协程，必须使用关键字yield主动放弃cpu控制权
   - 协程需要自己写任务管理器，以及任务调度器
   - 减轻了OS处理零散任务和轻量级任务的负担
1. php7：生成器（或者叫迭代器更合适）可以有一个最终返回值（return），也可以通过 yield from 的新语法进入一个另外一个生成器中（生成器委托）。生成器的两个新特性（return 和 yield from）可以组合
1. 实现：v5.5加入，使用迭代生成器和yield关键字
    ```
    function gen(){
        echo "hello gen".PHP_EOL;
        $ret = (yield "gen1");
        var_dump($ret);
        $ret = (yield "gen2");
        var_dump($ret);
    }
    $myGen = gen();                         // 使用
    var_dump($myGen->current());
    var_dump($myGen->send("main send"));
    ```
#### SPL
1. 理解：Standard PHP Library，PHP标准库，用于解决典型问题的一组接口和类的集合
1. 数据结构：对应数据的存储结构，数据的存储和操作
   - 双向链表：SplQueue
   - 堆：SplStack
   - 阵列：SplFixedArray
   - 映射：SplObjectStorage
1. 迭代器：以不同的方式来遍历操作的对象，提供了对应数据类型的迭代器。虽然更多的代码，但是高度重用且可测试，都可以尝试下spl的迭代器，或许能改变你编写传统代码的习惯
```php
class RecursiveFileFilterIterator extends FilterIterator {

    // 满足条件的扩展名
    protected $ext = array('jpg','gif');
    // 提供 $path 并生成对应的目录迭代器
    public function __construct($path) {
        parent::__construct(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)));
    }
    // 检查文件扩展名是否满足条件
    public function accept() {
        $item = $this->getInnerIterator();
        if ($item->isFile() && in_array(pathinfo($item->getFilename(), PATHINFO_EXTENSION), $this->ext)) {
            return TRUE;
        }
    }
}

// 实例化
foreach (new RecursiveFileFilterIterator('/path/to/something') as $item) {
    echo $item . PHP_EOL;
}
```
1. 其他spl函数：文件处理、接口、异常、类和接口
### 其他
1. 多线程：pthreads
1. 消息队列：gearman
1. 守护进程
