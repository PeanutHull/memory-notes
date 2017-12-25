### Reflection
1. 理解：反射，用于自动加载插件，是操纵面向对象中元模型的API。在php运行过程中，分析php程序，导出/提取关于类、对象、方法、属性、参数、注释等信息。获取信息和调用对象的方法叫做反射API，是php内建的oop扩展。
1. 后期静态绑定：用于继承范围内引用静态调用的类
    ```
    new self(); // 返回父类
    new static(); // 返回当前的类
    $class = new static($user); // 返回一个对象，可以使用当前类的方法了，同时类的成员包括$user中的数据
    ```
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
1. 理解：在同一进程或线程中运行多个任务，即将任务切换的部分工作从内核转移到应用层，这种解决方案称为协程
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
#### IoC、DI
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
        // 结果：解决了类和外部类的依赖关系，容器类也没有和外部类有依赖。通过注册/绑定的方式向容器中添加可被执行的回调(匿名函数、函数、类的方法)作为类的实例的脚本，只有生产时才触发。真正的IoC容器会根据类的需求，自动注册/绑定符合需求的依赖，自动注入到构造函数中去，通过php的反射做的
        ```
   - 关键词：控制反转, 依赖注入, 工厂模式, 契约, IoC容器, 服务容器, 服务提供者，反射
