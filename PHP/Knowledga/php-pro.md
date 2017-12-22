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
#### IoC和DI
1. IoC(控制反转)和DI(依赖注入)
   - IoC——Inversion of Control，即控制器反转。Ioc意味着将你设计好的对象交给容器控制，而不是传统的在你的对象内部直接控制。IoC 容器控制了对象。
```
由外部负责其依赖需求的行为，我们可以称其为 控制反转（IoC）
```

   - 工厂模式和依赖
```
// 接口、类、对象
问题：面对的对象的变化，解决依赖，通过IoC解耦，自由组合
——————————————————————————————————————————————————————————————
// 工厂模式
一个类所依赖的外部事物的实例，都可以被一个或多个 “工厂” 创建的这样一种开发模式，就是 “工厂模式”。如下利用工程模式实例化超人，给其添加各种属性.
结果：我们不需要依赖任何"超能力"类，轻松实例化不同的超人。增加或修改能力修改工厂方法即可。
// 工厂方法
class SuperModuleFactory
{
        public function makeModule($moduleName, $options)
        {
            switch ($moduleName) {
                case 'Fight': 
                    return new Fight($options[0], $options[1]);
                case 'Force': 
                    return new Force($options[0]);
                case 'Shot': 
                    return new Shot($options[0], $options[1], $options[2]);
            }
        }
}
// 超人类
class Superman
{
        protected $power;
.
        public function __construct(array $modules)
        {
            // 初始化工厂
            $factory = new SuperModuleFactory;

            // 通过工厂提供的方法制造需要的模块
            foreach ($modules as $moduleName => $moduleOptions) {
                $this->power[] = $factory->makeModule($moduleName, $moduleOptions);
            }
        }
}
.
// 创建超人
$superman = new Superman([
         'Fight' => [9, 100],
         'Shot' => [99, 50, 2]
]);
```
   - 依赖注入
```
// 依赖注入
工厂模式的问题：只是由对多个外部类的依赖变成了对一个"工厂"的依赖。即缺点为：接口未知(没有好的契约模型)，工厂要求必须有统一的接口，
// 契约，即统一的接口实现，否则无法"生产"，如下
interface SuperModuleInterface
{
        /**
         * 超能力激活方法
         * 任何一个超能力都得有该方法，并拥有一个参数
         *@param array $target 针对目标，可以是一个或多个，自己或他人
         */
        public function activate(array $target);
}
// 规定必须使用 SuperModuleInterface接口的类
class Superman
{
        protected $module;
.
        public function __construct(SuperModuleInterface $module)
        {
            $this->module = $module;
        }
}
// 依赖注入的典型示例
// 超能力模组
$superModule = new XPower;
// 初始化一个超人，并注入一个超能力模组依赖
$superMan = new Superman($superModule);
```
   - IoC容器
```
// IoC容器，工厂模式的升华。向工厂提交一个脚本，工厂通过指令自动化生产。容器举例
class Container
{
        protected $binds;

        protected $instances;

        public function bind($abstract, $concrete)
        {
            if ($concrete instanceof Closure) {
                $this->binds[$abstract] = $concrete;
            } else {
                $this->instances[$abstract] = $concrete;
            }
        }

        public function make($abstract, $parameters = [])
        {
            if (isset($this->instances[$abstract])) {
                return $this->instances[$abstract];
            }

            array_unshift($parameters, $this);

            return call_user_func_array($this->binds[$abstract], $parameters);
        }
}
// 使用容器
// 创建一个容器（后面称作超级工厂）
$container = new Container;
.
// 向该 超级工厂添加超人的生产脚本
$container->bind('superman', function($container, $moduleName) {
    return new Superman($container->make($moduleName));
});
.
// 向该 超级工厂添加超能力模组的生产脚本
$container->bind('xpower', function($container) {
    return new XPower;
});
.
// 同上
$container->bind('ultrabomb', function($container) {
    return new UltraBomb;
});
.
// ****************** 华丽丽的分割线 **********************
// 开始启动生产
$superman_1 = $container->make('superman', 'xpower');
$superman_2 = $container->make('superman', 'ultrabomb');
$superman_3 = $container->make('superman', 'xpower');
// 结果：解决了类和外部类的依赖关系，容器类也没有和外部类有依赖。通过注册/绑定的方式向容器中添加可被执行的回调(匿名函数、函数、类的方法)作为类的实例的脚本，只有生产时才触发
// 后记：真正的IoC容器会根据类的需求，自动注册/绑定符合需求的依赖，自动注入到构造函数中去，通过php的反射做的。
```
   - IoC和DI的区别：依赖注入是从应用程序的角度在描述，可以把依赖注入描述完整点：应用程序依赖容器创建并注入它所需要的外部资源；而控制反转是从容器的角度在描述，描述完整点：容器控制应用程序，由容器反向的向应用程序注入应用程序所需要的外部资源。
   - 关键词： Facade, IoC容器, Laravel, 依赖注入, 反射, 契约, 工厂模式, 控制反转, 服务容器, 服务提供者
1. Reflection————反射
   - 目的：自动加载插件，
   - 解释：是操纵面向对象中元模型的API。在php运行过程中，分析php程序，导出/提取关于类、对象、方法、属性、参数、注释等信息。获取信息和调用对象的方法叫做反射API，是php内建的oop扩展。
1. 后期静态绑定
   - 解释：用于继承范围内引用静态调用的类
   - 例子
```
new self(); // 返回父类
new static(); // 返回当前的类
$class = new static($user); // 返回一个对象，可以使用当前类的方法了，同时类的成员包括$user中的数据
```
