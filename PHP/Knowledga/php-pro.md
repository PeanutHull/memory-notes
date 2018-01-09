### Reflection
1. 理解：反射，用于自动加载插件，是操纵面向对象中元模型的API。在php运行过程中，分析php程序，导出/提取关于类、对象、方法、属性、参数、注释等信息。获取信息和调用对象的方法叫做反射API，是php内建的oop扩展。
1. 后期静态绑定：用于继承范围内引用静态调用的类
    ```
    new self(); // 返回父类
    new static(); // 返回当前的类
    $class = new static($user); // 返回一个对象，可以使用当前类的方法了，同时类的成员包括$user中的数据
    ```
1. 相关函数
   - 方法
     1. func_get_args
   - 类
     1. 获取
        - get_class();
        - get_class_methods();
        - instanceof
        - class_exists();
        - interface_exist();
     1. 调用
        - call_user_func_array()
### Trait
1. 理解：特质,是一种为类似PHP的单继承语言而准备的代码复用机制，使开发人员能够自由地在不同层次结构的独立的类中复用方法集。来避免传统多继承和混入类（Mixin）相关的典型问题，就是先定义trait，用use给类插入代码，代码复用，属于类与对象，5.4加上的
1. 示例
    ```
    class Base {
        public function sayHello () {
            echo 'Hello ' ;
        }
    }
    trait SayWorld {
        public function  sayHello () {
            parent::sayHello();
            echo  'World!';
        }
    }
    class MyHelloWorld extends Base {
        use SayWorld ;
    }
    $o = new MyHelloWorld();
    $o->sayHello ();                        // 输出Hello World!
    ```
#### 协程
1. 理解：在同一进程或线程中运行多个任务，即将任务切换的部分工作从内核转移到应用层，这种解决方案称为协程。任务调度器
1. 特点
   - 为应用层实现多任务提供了工具
   - 协程不允许多任务同时执行，要执行其它协程，必须使用关键字yield主动放弃cpu控制权
   - 协程需要自己写任务管理器，以及任务调度器
   - 减轻了OS处理零散任务和轻量级任务的负担
1. 实现：php5.5加入，使用迭代生成器和yield关键字
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
### 多线程
1. pthreads
### 消息队列
1. gearman
### 守护进程
### swoole
