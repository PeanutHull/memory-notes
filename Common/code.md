### 整洁代码
1. 整洁代码的优点
   - 降低修改和扩展难度，加速项目开发，减轻开发负担
   - 防止项目走向失控
二、一些原则
   - 要有明确的设计意图，什么是违背的做法，什么是正确的做法
   - 团队规范明确且贯彻执行
   - 逻辑直截了当，简单、明确、有力，争取做到一目了然，不必费心研究
   - 对代码一丝不苟，杜绝妥协，将代码作为思想的表现
   - 尽量减少依赖
   - 消除重复
   - 提早构造简单抽象
   - 每次写完都比写之前的简介，哪怕仅仅改好一个变量名，拆分一个有点长的函数，清理一个嵌套的if语句
1. 一些做法
   - 命名
     1. 明确表达含义：需要完整描述变量、函数等本身，杜绝arr、num等弱含义词汇，需要轻易知道发生了什么来节省时间
     1. 避免误导：长长的相识度极高的变量名很费时间
     1. 有意义的区分：数字系列的名称纯属误导，没有提供意图，Customer类和CustomerObject类，完全没有区别
     1. 读写：使用易读出来、正确的单词，杜绝拼音和英文混杂
     1. 慎用前/后缀：应该让名称尽量小
     1. 类名是名词，方法名是动词，添加语境可以更加易于理解，如addLastName
     1. 函数名应该独一无二，便于搜索
     1. 多花时间想个好名字
   - 函数：是为了描述一件事情怎么做
     1. 整体短小：缩进只有一层或者两层
     1. 只做一件事，做好这件事：是否再能做出一个有意义的拆分，是函数是否只做一件事的划分标准
     1. 一个函数中的语句应该都在同一抽象层级上，否则引起混淆，也应该按照自顶向下的顺序组织代码
     1. 避免参数过多：第三个参数非常不建议，越少越容易理解，大多数方法通用的参数应该封装为类属性
     1. 无副作用：不要干未被预期的事情
     1. 将检测类函数和动作类的分开，使用异常替代返回错误码，抽离try/catch和逻辑，不要放在一起
     1. 不要重复
   - 注释：注释是我们代码表达意图时失败的弥补，它不能美化糟糕的代码，能用代码的不要用注释，好代码即注释，不准确的注释是在满口胡言
     1. 好的注释有以下特征
        - 提供相关的信息
        - 对函数意图的解释
        - 抽象的参数、返回值转变为可读形式
        - 警告一些可能的后果
        - TODO、FIXME这种提示类
     1. 不好的注释有以下特征
        - 喃喃自语，不够精练，随意写的
        - 多余，可能比读代码的时候都长
        - 错误的误导的注释
        - 死板式的注释：每个函数都有一套一摸一样冗长的
        - 注释的代码，应该被删除
   - 类、对象
     1. 单一职责原则：一个类应该有且只有一条加以修改的理由，是应该和其他类配合共同完成某一行为
     1. 开放封闭原则：对扩展开放、对修改封闭。如每当添加新类型就必须修改时，可以使用工厂模式代替
     1. 依赖倒置原则：细节应该依赖于抽象，高层模块不应该依赖底层模块，两个都应该依赖抽象，才能高内聚低耦合，不关心怎么定义，反过来也不关心怎么使用，按照规范实现就好了，don't call me，i will call you
     1. 里氏代换原则：子类必须能够替换父类，并出现在父类出现的任何地方。因为子类可以替换掉父类，父类才能被复用，子类也能增加新的功能
     1. 接口隔离原则：使用多个专门的接口，而不使用单一的总接口，就是接口也要遵从单一职责原则，每一个接口只负责一种角色
     1. 迪米特法则：即最少知识原则，强调类之间的松耦合，应该对其他对象保持最少的了解
     1. 合成/聚合复用原则：要尽量使用合成/聚合，不要滥用继承
   - 其他
     1. 性能：for循环里不能有调用api、数据库操作等，字符串用单引号代替双引号
     1. 格式：整洁、规范、团队统一，垂直方向上空行作为概念的分隔，有联系的代码紧挨着；水平方向上空格表示参数隔离，太长的一行代码不好阅读，严格遵循缩进
### 代码的22种坏味道
1. 重复代码
   - 一个类中：提炼成一个函数
   - 兄弟类中：提炼成一个函数，并且提取到父类中
   - 两个不相关的类：提炼成一个函数，放到两个类中的一个类中或者一个单独的类中
1. 过长函数
1. 过大的类
1. 方法中过长的参数列
1. 发散式变化
   - 一个类做太多的事情了，万能类，经常因为不同的原因在不同的方向上发生变化，将会产生发散式变化
   - 将变化隔离，封装变化，把变化的和不变的部分分开，拆分成多个类
1. 散弹式变化
   - 一个变化引发多个类的修改，把需要修改的部分抽取出来，放到一个单独的类中
1. 依恋情节
   - 使用了大量其他类的成员
   - 如果该方法只调用了一个类的多个方法。将该方法移到调用类里，如果该方法调用了多个类的多个方法。将该方法拆解。然后分离到调用类里
1. 数据泥团
   - 总是成堆出现在一起的数据，应该封装在一个单独的类中
1. 基本类型偏执
   - 用对象代替基本类型，并不是代替单个的基本类型，而是几个基本类型放在一起更有意义时应该使用对象
1. switch语句
   - 一看到switch语句，你就应该考虑以多态来替换它，如果一个switch操作只是执行简单的行为，就没有重构的必要了
1. 平行继承体系
   - 每当为某个类增加一个子类，必须也为另一个类增加一个子类。消除这种重复性的一般策略是：让一个继承体系的实例引用另一个继承体系的实例
1. 冗赘类
1. 夸夸奇谈谈未来
   - “我想总有一天需要做这事”，并因而企图以各样的钩子和特殊情况来处理一些非必要的事情。如果用不到，就不值得。删掉
1. 令人迷惑的临时字段
   - 有时候你会发现：类中的某个实例变量仅为某种特定情况而设。这样的代码让人难以理解，因为你通常认为对象在所有时候都需要它的所有变量
   - 将这些临时变量集中到一个新类中管理
1. 过度耦合的消息链
   - 有些时候我们在调用某个函数的时候往往会形成A->B->C->D.test(),这个时候如果你在A端，你就产生了Message Chains的坏味道。这种状态使的你客户代码在A中变成getB()->getC()->getD()->test(),这会使得客户代码在以后这些类关系发生变化的时候变得极易修改与相当不稳定。可以使用隐藏“委托关系”，并在服务类上建立客户所需要的所有函数来打破这消息链，理论上你可以重构消息链上的任一对象。但这样做往往会让这些小对象都变成Middle Man(中间人)，通常更好的做法是：查看消息链最终对象是用来干什么的，看看是否能用Extract Method把他提炼到一个独立的函数中去，再运用Move Method把这个函数推入消息链
1. 中间人
   - 大部分都交给中介来处理了。用继承替代委托
1. 狎昵关系
   - 两个类彼此使用对方的私有的东西。可以通过“移动方法”和“移动字段”帮它们划清界限，从而减少狎昵行径
   - 如果两个类实在是情投意合，可以把两者共同点提炼到一个安全地点，让它们坦荡地使用这个新类，从而改变从双向依赖A->B,B->A变成A->C,B->C。或者通过隐藏“委托关系”让另一个类来为它们传递相思情，
1. 异曲同工的类
1. 不完美的库类
   - 包一层函数或包成新的类
1. 纯稚的数据类
   - 类很简单，仅有公共成员变量，或简单操作函数。将相关操作封装进去，减少public成员变量
1. 被拒绝的遗贈
   - 父类里面方法很多，子类只用有限几个,用代理替代继承关系
1. 过多的注释
   - 当你感觉需要撰写注释时，请先尝试重构，试着让所有注释都变得多余。好代码即注释
### 设计模式
1. design pattern
   - 理解
     1. 是遇到问题的解决方案，是自下而上的，来源于实践，发现模式而不是发明模式
     1. 是特定环境下同类问题的解决方案，但是实现细节却有非常多的差别
     1. 问题是所有的基础
     1. 设计模式是语言无关的
     1. 好处：好的代码风格，易读性，扩展性强，稳定性好
     1. 不能解决：是组织代码的模板，不是直接调用库，不要一味追求并套用，合理就好
   - 组成
     1. 组成：命名、问题、解决方案、效果
     1. 格式：意图、动机、适用性、结构交互、实现、相关模式的合作
   - 特性
     1. 尽量解耦
     1. 抽象类高于实现：尽量一般化而不特殊化
1. 分类：23种设计模式
   - 创建型
     1. 类模式：工厂方法
     1. 对象模式：单例、工厂(简单工厂/抽象工厂)、建造者、原型
   - 结构型
     1. 类模式：适配器
     1. 对象模式：桥接、装饰、组合、外观、享元、代理
   - 行为型
     1. 类模式：模版方法、解释器
     1. 对象模式：命令、迭代器、观察者、中介者、备忘录、状态、策略、职责链、访问者
1. 单例模式
   - 理解：建立在面向对象基础上，要确保某个类只有一个实例，避免不断new浪费资源，完善全局变量的功能。php的所有在页面执行完后全部清空削弱了单例的表现，饿汉模式、懒汉模式
   - 要点
     1. 类只能有一个实例
     1. 它自己自行创建这个实例
     1. 它必须自行向整个系统提供这个实例
   - 基础例子
        ```php
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
        ```php
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
   - 理解：创建型模式，定义一个由工厂方法或者类生成对象的工厂，让子类决定实例化哪一个类。本质上将不变的部分提取出来，将可变的部分留作接口，以达到最大程度上的复用
   - 适用性：有众多子类并且会扩充，创建方法比较复杂的情况下适用。工厂类在多态性编程实践中是至关重要的，它允许动态的替换类，修改配置，使程序更加灵活
   - 分类
     1. 简单工厂：违背开闭原则，增加新产品时需修改工厂代码。用于客户只知道传入工厂类的参数，将客户端和对象创建隔离
        ```php
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

        // 使用
        $factory = new SimpleFactory();
        $teacher = $factory->getPerson('teacher');
        $teacher->getName();
        ```
     1. 工厂方法：只有一条产品线，抽象工厂的简化。遵守了开闭原则，但是将选择实例化交给了客户。将创建对象的职责转移给子类中的一个，从而实现扩展不修改根代码
        ```php
        // 工厂方法
        interface Factory
        {
            public function produce();
        }
        // 具体实现
        class Farm implements Factory
        {
            public function produce() {}
        }
        class Airport implements Factory
        {
            public function produce() {}
        }
        // 客户端
        $farm = new Farm();
        $farm->produce();
        ```
     1. 抽象工厂：有多条产品线，系统提供一个产品类的库，所有的产品以同样的接口出现，从而使客户端不依赖于实现
        ```php
        // 定义集团
        interface Factory {
            public function createFarm();
            public function createZoo();
        }
        class AnimalFactory implements Factory {
            public function createFarm() {
                return new PigFarm();
            }
            public function createZoo() {
                return new PandaZoo();
            }
        }

        $animal = new AnimalFactory();                                  // 初始化一个动物生产线, 包含了一类产品
        $plant = new PlantFactory();                                    // 初始化一个植物生产线, 包含了一类产品

        // 调用，最后都调用money方法
        function call($factory) {
            $earn = function($income) {
                $income->money();
            };
            $earn($factory->createFarm());
            $earn($factory->createZoo());
        }
        call($animal);
        call($plant);
        ```
1. 建造者模式
   - 理解：就是用一个建造类建造另一个类让对象更方便建造，同样的建造过程创建不同的表示，定义建造的配置，不关心建造过程和细节，简单对象构建复杂对象，
     1. 良好封装性，使用者可以不用了解内部组成就创建可使用的对象
     1. 建造者独立，被建造类容易扩展
   - 实例：建造几个王者荣耀英雄
     1. 被建造类
        ```java
        public class HeroConfig{
            HeroBuilder mbuilder = null;
            // 英雄的两个技能
            private String firstSkill;
            private String secondSkill;
            private String TPeffect = "无回城特效";

            public HeroConfig(HeroBuilder builder) {
                mbuilder = builder;
                init();
            }
            private void init() {
                if(mbuilder.firstSkill != null) {
                    firstSkill = mbuilder.firstSkill;
                }
                if(mbuilder.secondSkill != null) {
                    secondSkill = mbuilder.secondSkill;
                }
                if(mbuilder.TPeffect != null) {
                    TPeffect = mbuilder.TPeffect;
                }
            }
            @Override
            public String toString() {
                return "技能1-->" + firstSkill + " 技能2-->" + secondSkill + " 技能2-->" + thirdSkill + " 回城特效-->" + TPeffect;
            }
        }
        ```
     1. 建造者(即建造执行者)
        ```java
        public static class HeroBuilder{
            // 英雄的两个技能
            private String firstSkill;
            private String secondSkill;
            private String TPeffect;        // 回城效果

            public HeroBuilder(String firstSkill, String secondSkill) {
                this.firstSkill = firstSkill;
                this.secondSkill = secondSkill;
            }

            public HeroConfig create() {
                HeroConfig mHeroConfig = new HeroConfig(this);
                return mHeroConfig;
            }

            public HeroBuilder builderTPeffect(String effect) {
                this.TPeffect = effect;
                return this;                // 实现链式调用
            }
        }
        ```
     1. 使用，来建造类
        ```java
        HeroConfig 韩信 = new HeroConfig.HeroBuilder("无情冲锋","背水一战","国士无双").BuilTPeffect("金光闪闪").create();
        ```
1. 原型模式
   - 理解：复制原型创建新的对象，从一个对象克隆一个新的，而不需要知道如何创建的细节。可用于创建对象成本过高
     1. 浅复制：引用不会被复制
     1. 深复制：可调用被引用对象自身的克隆方法进行复制
   - 代码
        ```php
        // 原型接口
        abstract class PrototypeAbstract {
            protected $_name;
            abstract public function getName();
            abstract public function getPrototype();            // 声明克隆自身的方法，从而允许克隆
        }
        // 原型实体
        class Prototype extends PrototypeAbstract {
            public function __set($name='', $value='')
            {
                $this->$name = $value;
            }
            public function getName() {
                echo $this->_name;
            }
            public function getPrototype() {
                return clone $this;
            }
        }

        // 创建一个原型对象
        $prototype = new Prototype();
        // 获取一个原型的clone
        $prototypeCloneOne = $prototype->getPrototype();
        $prototypeCloneOne->_name = 'one';
        $prototypeCloneOne->getName();
        // 获取一个原型的clone
        $prototypeCloneTwo = $prototype->getPrototype();
        $prototypeCloneTwo->_name = 'two';
        $prototypeCloneTwo->getName();
        // 再次获取$prototypeCloneOne的名称
        $prototypeCloneOne->getName();
        ```
1. 适配器模式
   - 理解：把实现了不同接口的对象通过适配器的方式组合起来放在一个新的环境
    ```php
    class Adapter {
        private $_advancePlayerInstance;
        private $_type = '';
        public function __construct($type='') {
            switch ($type) {
                case 'mp4':
                    $this->_advancePlayerInstance = new AdvanceMp4Player();
                    break;
                case 'wma':
                    $this->_advancePlayerInstance = new AdvanceWmaPlayer();
                    break;
                default:
            }
            $this->_type = $type;
        }
        public function play($file='') {
            switch ($this->_type) {
            case 'mp4':
                $this->_advancePlayerInstance->playMp4($file);
                break;
            case 'wma':
                $this->_advancePlayerInstance->playWma($file);
                break;
            default:
                break;
            }
        }
    }
    class AudioPlayer implements MediaInterface {
        public function play($file='', $type='') {
            switch ($type) {
            case 'mp3':
                echo 'playing file: ' . $file . ".mp3\n";
                break;
            case 'mp4':
                $adapter = new Adapter($type);
                $adapter->play($file);
                break;
            case 'wma':
                $adapter = new Adapter($type);
                $adapter->play($file);
                break;
            default:
                break;
            }
        }
    }

    $mp4 = new AudioPlayer();
    $mp4->play('忍者', 'mp3');
    $mp4->play('彩虹', 'wma');
    ```
1. 桥接模式
   - 理解：基础的结构型设计模式，将抽象和实现解耦，对抽象的实现是实体行为对接口的实现
1. 装饰模式
   - 理解：动态地给一个对象增加一些额外的职责，就增加功能来说比生成子类更加灵活。将一个类的对象嵌入另一个对象中，由另一个对象来决定是否调用嵌入对象的行为以扩展自己的行为，称这个嵌入的对象为装饰器。
     1. 组装过程中建造者模式要求建造过程是稳定的，装饰模式不稳定
     1. 就是为已有功能添加更多功能的方式，即这些功能仅仅是特殊情况下才会加入的，装饰模式将装饰功能封装到具体的类中，就可以有选择、有顺序的使用了
   - 组成
     1. 结构图
        - Component接口：下边是Decorator装饰抽象类和ConcreteComponent具体类，继承关系
        - Decorator装饰抽象类：下边ConcreteDecorator具体装饰类
     1. 组成
        - Component接口：定义具体需要装饰的方法，只有一个装饰器的话，需要将Decorator继承ConcreteComponent
        - ConcreteComponent：具体装饰，给Component添加职责的功能
        - Decorator：装饰抽象类
        - ConcreteDecorator：具体装饰类，实现需要装饰的方法，添加自己的特点
   - demo
    ```c#
    namespace 装饰模式
    {
        abstract class Component
        {
            public abstract void Operation();
        }

        class ConcreteComponent : Component
        {
            public override void Operation()
            {
                Console.WriteLine("具体对象的操作");
            }
        }

        abstract class Decorator : Component
        {
            protected Component component;

            public void SetComponent(Component component)
            {
                this.component = component;
            }

            public override void Operation()
            {
                if (component != null)
                {
                    component.Operation();
                }
            }
        }

        class ConcreteDecoratorA : Decorator
        {
            private string addedState;                      // 本类独有功能

            public override void Operation()
            {
                base.Operation();                           // 一层层装饰能够连续进行的保证***
                addedState = "New State";                   // 本装饰的作用
                Console.WriteLine("具体装饰对象A的操作");
            }
        }

        class ConcreteDecoratorB : Decorator
        {
            private void AddedBehavior()

            public override void Operation()
            {
                base.Operation();
                AddedBehavior();
                Console.WriteLine("具体装饰对象B的操作");
            }
        }

        class Program
        {
            static void Main(string[] args)
            {
                ConcreteComponent c = new ConcreteComponent();          // 初始化装饰器
                ConcreteDecoratorA d1 = new ConcreteDecoratorA();       // 初始化装饰
                ConcreteDecoratorB d2 = new ConcreteDecoratorB();

                d1.SetComponent(c);                                     // 一层层加入装饰***
                d2.SetComponent(d1);

                d2.Operation();
            }
        }
    }
    ```
1. 外观模式
   - 理解：为子系统中的一组接口提供一致的界面，使得子系统更加容易调用，也可以包装复杂的内部接口，重新提供简单的接口
   - code
    ```c#
    class SubSystemOne
    {
        public void MethodOne()
        {
            Console.WriteLine(" 子系统方法一");
        }
    }

    class SubSystemTwo
    {
        public void MethodTwo()
        {
            Console.WriteLine(" 子系统方法二");
        }
    }

    class SubSystemThree
    {
        public void MethodThree()
        {
            Console.WriteLine(" 子系统方法三");
        }
    }

    class SubSystemFour
    {
        public void MethodFour()
        {
            Console.WriteLine(" 子系统方法四");
        }
    }

    class Facade                                                // 门面类
    {
        SubSystemOne one;
        SubSystemTwo two;
        SubSystemThree three;
        SubSystemFour four;

        public Facade()
        {
            one = new SubSystemOne();
            two = new SubSystemTwo();
            three = new SubSystemThree();
            four = new SubSystemFour();
        }

        public void MethodA()                                   // 封装了调用，需要对子系统了解
        {
            Console.WriteLine("\n方法组A() ---- ");
            one.MethodOne();
            two.MethodTwo();
            four.MethodFour();
        }

        public void MethodB()
        {
            Console.WriteLine("\n方法组B() ---- ");
            two.MethodTwo();
            three.MethodThree();
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Facade facade = new Facade();

            facade.MethodA();
            facade.MethodB();

            Console.Read();
        }
    }
    ```
1. 代理模式
   - 理解：对其他对象添加一层代理，就可以附加多种用途
   - 作用
     1. 可对一个类在不同地址空间进行局部代表，隐藏了一个类在不同空间的事实
     1. 虚拟代理：提前做一些事情，比如预加载图片时虚拟类先弄个框，速度更快
     1. 安全代理：控制权限
     1. 其他：引用计数等
   - code
    ```c#
    abstract class Subject
    {
        public abstract void Request();             // 定义共同接口，使得proxy可以完全代替实体
    }

    class RealSubject : Subject                     // 真实实体
    {
        public override void Request()
        {
            Console.WriteLine("真实的请求");
        }
    }

    class Proxy : Subject                           // 代理类
    {
        RealSubject realSubject;
        public override void Request()
        {
            if (realSubject == null)
            {
                realSubject = new RealSubject();
            }

            realSubject.Request();
        }
    }

    class Program
    {
        static void Main(string[] args)
        {
            Proxy proxy = new Proxy();              // 代理访问
            proxy.Request();

            Console.Read();
        }
    }
    ```
1. 模板方法模式
   - 理解：定义好骨架，将一些步骤延迟到子类中，使得子类不改变骨架即可重定义某些步骤。把不变的聚合，变的暴露出来
   - code
    ```c#
    class TestPaper
    {
        public void TestQuestion1()
        {
            Console.WriteLine(" 杨过得到，后来给了郭靖，炼成倚天剑、屠龙刀的玄铁可能是[ ] a.球磨铸铁 b.马口铁 c.高速合金钢 d.碳素纤维 ");
            Console.WriteLine("答案：" + Answer1());
        }

        public void TestQuestion2()
        {
            Console.WriteLine(" 杨过、程英、陆无双铲除了情花，造成[ ] a.使这种植物不再害人 b.使一种珍稀物种灭绝 c.破坏了那个生物圈的生态平衡 d.造成该地区沙漠化  ");
            Console.WriteLine("答案：" + Answer2());
        }

        protected virtual string Answer1()
        {
            return "";
        }

        protected virtual string Answer2()
        {
            return "";
        }
    }
    //学生甲抄的试卷
    class TestPaperA : TestPaper
    {
        protected override string Answer1()
        {
            return "b";
        }

        protected override string Answer2()
        {
            return "c";
        }
    }
    //学生乙抄的试卷
    class TestPaperB : TestPaper
    {
        protected override string Answer1()
        {
            return "c";
        }

        protected override string Answer2()
        {
            return "a";
        }
    }

    // 试卷答题
    class Program
    {
        static void Main(string[] args)
        {
            Console.WriteLine("学生甲抄的试卷：");
            TestPaper studentA = new TestPaperA();
            studentA.TestQuestion1();
            studentA.TestQuestion2();

            Console.WriteLine("学生乙抄的试卷：");
            TestPaper studentB = new TestPaperB();
            studentB.TestQuestion1();
            studentB.TestQuestion2();

            Console.Read();
        }
    }
    ```
1. 观察者模式
   - 理解：
   - code
    ```c#

    ```
1. 策略模式
   - 理解：定义了算法家族，分别封装起来，算法变化和用户使用进行了隔离，减少了算法类和使用算法之间的耦合，使其之间可以相互替换，比简单工厂单纯列举条件（主要是简单工厂遇到算法变化也要变化导致）要高级
     1. 算法随时可能替换，这是变化点，封装变化点是面向对象的一个很重要的思维方式
     1. 策略模式封装了变化，即写代码中消除了条件语句
     1. 可以使用反射消除客户端对于算法选择的switch判断代码
   - 组成
     1. 结构图
        - 策略接口：下边具体的策略类，继承关系
        - 上下文：用一个配置维护对策略类对象的引用
     1. 组成
        - 策略接口：定义所有支持的算法的公共接口
        - 具体策略类：封装了算法或者行为
        - 上下文类
   - demo
    ```c#
    namespace 策略模式
    {
        //抽象算法类
        abstract class Strategy
        {
            //算法方法
            public abstract void AlgorithmInterface();
        }
        //具体算法A
        class ConcreteStrategyA : Strategy
        {
            //算法A实现方法
            public override void AlgorithmInterface()
            {
                Console.WriteLine("算法A实现");
            }
        }
        //具体算法B
        class ConcreteStrategyB : Strategy
        {
            //算法B实现方法
            public override void AlgorithmInterface()
            {
                Console.WriteLine("算法B实现");
            }
        }

        //上下文
        class Context
        {
            Strategy strategy;

            public Context(Strategy strategy)
            {
                this.strategy = strategy;
            }
            //上下文接口
            public void ContextInterface()
            {
                strategy.AlgorithmInterface();
            }
        }

        class Program
        {
            static void Main(string[] args)
            {
                Context context;

                context = new Context(new ConcreteStrategyA());
                context.ContextInterface();

                context = new Context(new ConcreteStrategyB());
                context.ContextInterface();
            }
        }
    }
    ```
1. 职责链模式
   - 理解：利用抽象方法，将业务请求连成一条链层层传递，谁符合条件谁处理，重点在于多个对象都有机会处理请求，需要解耦请求发送者和接受者的关系
     1. 客户端不需要关心处理类，可以灵活设置链条
     1. 扩展处理方法不需要修改处理类，直接新增即可
   - 组成
     1. 一个抽象类，多个具体处理类：抽象类定义链条上下级和抽象处理方法
     1. 客户端设置链条中的执行顺序
   - demo
    ```c#
    // 抽象类
    abstract class Handler
    {
        protected Handler successor;

        public void SetSuccessor(Handler successor)                     // 设置链条继任者
        {
            this.successor = successor;
        }

        public abstract void HandleRequest(int request);                // 抽象处理方法
    }

    // 具体处理类
    class ConcreteHandler1 : Handler
    {
        public override void HandleRequest(int request)
        {
            if (request >= 0 && request < 10)
            {
                Console.WriteLine("{0}  处理请求  {1}", this.GetType().Name, request);
            }
            else if (successor != null)
            {
                successor.HandleRequest(request);
            }
        }
    }
    class ConcreteHandler2 : Handler
    {
        public override void HandleRequest(int request)
        {
            if (request >= 10 && request < 20)
            {
                Console.WriteLine("{0}  处理请求  {1}", this.GetType().Name, request);
            }
            else if (successor != null)
            {
                successor.HandleRequest(request);
            }
        }
    }
    // 客户端代码
    class Program
    {
        static void Main(string[] args)
        {
            Handler h1 = new ConcreteHandler1();
            Handler h2 = new ConcreteHandler2();
            Handler h3 = new ConcreteHandler3();
            h1.SetSuccessor(h2);                                    // 设置链条
            h2.SetSuccessor(h3);

            int[] requests = { 2, 5, 14, 22, 18, 3, 27, 20 };

            foreach (int request in requests)
            {
                h1.HandleRequest(request);
            }
        }
    }
    ```
1. 访问者模式
   - 理解：设计模式中最复杂的一个模式。表示作用于某对象结构中的各元素的操作，可以在不改变各元素的类的前提下定义作用于这些元素的新操作。即改变的新增的是访问者
     1. 就是将处理从数据结构分离出来，将数据结构和作用于数据结构的操作解耦合，使得操作可以自由变化，体现开放-封闭原则
     1. 适用于数据结构相对稳定，又有变化多端的算法。也就是启用条件苛刻：大多时候你并不需要访问者模式，一旦需要时就真的需要了
     1. 新增数据结构就比较麻烦了
     1. 双分派技术：不仅受具体状态的影响，还受访问的人的影响
        - 第一次分派：状态作为参数传递给具体人类
        - 第二次分派：人类调用某个访问者方法后，将自己(this)作为参数传递进去
   - 组成
     1. 一个访问者抽象类：稳定的按照数据结构个数安排的抽象逻辑方法，多个具体算法状态类
     1. 数据结构抽象类：有一个用结构具体类使用访问者的哪一个方法的抽象方法
   - demo
    ```c#
    // 定义访问者抽象类
    abstract class Visitor
    {
        // 以下两个抽象方法决定了只有两个数据结构
        public abstract void VisitConcreteElementA(ConcreteElementA concreteElementA);

        public abstract void VisitConcreteElementB(ConcreteElementB concreteElementB);
    }

    // 访问者实现类
    class ConcreteVisitor1 : Visitor
    {
        public override void VisitConcreteElementA(ConcreteElementA concreteElementA)
        {
            Console.WriteLine("{0}被{1}访问", concreteElementA.GetType().Name, this.GetType().Name);
        }

        public override void VisitConcreteElementB(ConcreteElementB concreteElementB)
        {
            Console.WriteLine("{0}被{1}访问", concreteElementB.GetType().Name, this.GetType().Name);
        }
    }

    // 数据结构抽象类
    abstract class Element
    {
        public abstract void Accept(Visitor visitor);
    }

    // 数据结构具体类
    class ConcreteElementA : Element
    {
        public override void Accept(Visitor visitor)                // 双分派的第一次分派
        {
            visitor.VisitConcreteElementA(this);                    // 双分派的第二次分派
        }

        public void OperationA()
        { }
    }

    class Program
    {
        static void Main(string[] args)
        {
            ConcreteElementA a = new ConcreteElementA();
            ConcreteElementB b = new ConcreteElementB();

            ConcreteVisitor1 v1 = new ConcreteVisitor1();
            ConcreteVisitor2 v2 = new ConcreteVisitor2();

            a.Accept(v1);
            a.Accept(v2);
            b.Accept(v1);
            b.Accept(v2);
        }
    }
    ```
1. 注册树模式
   - 意图：全局共享/交换对象
### wiki
1. 自举
   - 理解：就是先用其他语言写出编译器用，然后自己写出自己的编译器来编译自己，当准确无误后，就可以删掉其他语言的编译器了，就自举了，可以证明语言完善，功能强大。如c++11编译c++14，之后c++14编译c++17，一代代传下去
1. 有限状态机
   - 理解：Finite-state machine, FSM。是一个模型，可模拟世界上大部分事物。进行对象行为建模，作用主要是描述对象在生命周期内所经历的状态序列、事件处理
   - 特征
     1. 状态总数是有限的
     1. 任一时刻，只处在一种状态之中
     1. 某种条件下，会从一种状态转变到另一种状态
1. 图灵完备：是针对一套数据操作规则而言的概念，这个规则可以是编程语言，也可以是指令集。当这套规则可以实现图灵机模型里的全部功能时，就称它具有图灵完备性
   - 图灵机：只要图灵机可以被实现，就可以用来解决任何可计算问题
     1. 计算问题的可计算性
### 领域驱动设计
1. DDD
   - 认识：领域驱动设计，将过程式业务流程设计变为面向对象式
   - 好处
     1. 指导确定系统边界
     1. 聚焦核心元素
     1. 帮助拆分系统
   - 概念
     1. entity：实体，数据（属性）和行为（业务逻辑关系）的结合体，如博客
     1. 值对象：作为一个属性存放于一个实体内部，如置顶的博客
     1. 聚合：一组具有内聚关系的领域对象（包括实体和值对象）的集合，如博客基础信息
     1. repository：仓储，连接领域层和基础设施层的桥梁，一般将仓储接口定义放在领域层，仓储的具体实现放在基础设施层
   - 分层设计
     1. infrastructure：基础设施层，为其他层提供通用的技术能力，如应用的消息发送、领域持久化等
     1. domain：领域层
        - 领域模型：领域中各个类，以及各类之间的关系
        - 领域服务：承载串联多个领域对象的操作
     1. application：应用层，对外为用户界面层提供各种应用功能，对内调用领域层的领域对象或领域服务完成各种业务编排、组装1
     1. interface：接口层/用户界面层，负责用户信息的展示，本层可以不存在
   - wiki
     1. 真正决定软件复杂性的是设计方法
     1. 康威定律：微服务的拆分要对应组织
     1. 业务需求说明：用例图、时序图、状态图
     1. 需求分析阶段：四色原型分析模式
        - 时刻/时间段原型
        - 参与方-地点-物品原型
        - 描述原型：说明
        - 角色原型
   - 开发方式
     1. TDD：测试驱动开发，先写测试后写实现，red=>green=>refactor(错误=>正确=>重构)
        - PHPUnit
        - Enhance PHP
        - SimpleTest
     1. BDD：行为驱动开发
        - 分支
          1. SpecBDD：专注代码层面，如phpspec
          1. StoryBDD：专注功能测试，如Behat、Codeception
1. 认识：解决软件更新迭代变坏的理念
   - 软件的本质就是对真实世界的模拟，将软件设计和真实世界对应起来，在每次需求变更时，将变更还原到真实世界中，看看真实世界是什么样子的，根据真实世界进行变更。设计质量就可以得到保证，这就是“领域驱动设计”的思想
   - 事务、行为、关系，将以上三个对应做成一个领域模型，然后通过这个领域模型指导程序设计；在每次需求变更时，先将需求还原到领域模型中分析，根据领域模型背后的真实世界进行变更，然后根据领域模型的变更指导软件的变更，设计质量就可以得到提高
1. 背景
   - 单一职责原则：软件系统中的每个元素只完成自己职责范围内的事，而将其他的事交给别人去做，我只是去调用
   - 开闭原则（OCP）：对扩展开放，对修改封闭
   - 软件退化的根源：不是版本迭代和需求变更，如果每次软件变更时，适时地进行解耦，进行功能扩展，再实现新的功能，就能保持高质量的软件设计。但如果在每次软件变更时没有调整程序结构，而是在原有的程序结构上不断地塞代码，软件就会退化
   - 掌握一个平衡，一方面要满足当前的需求，另一方面要让设计刚刚满足需求，从而使设计最简化、代码最少。这样做，不仅软件设计质量提高了，设计难点也得到了大幅度降低
   - 实体和值对象分开
### 接口
1. 自身了解
   - 分类
   - 调用方分布、调用方式、调用速率、调用高峰和分布
1. 指标
   - qps
   - 响应时长
     1. 平均响应时长
     1. 最大、最小
   - 错误统计
     1. 4xx、5xx
   - 资源依赖负载
     1. redis、mysql
1. 维护
   - 报错数
   - 慢接口top
   - 高流量top
1. 机器负载
   - cpu
   - 内存
   - 硬盘
   - 网络
1. 设计
   - 防重设计：避免产生重复数据，对接口返回没有太多要求
   - 幂等设计
     1. 认识：多次执行所产生的影响均与一次执行的影响相同
        - 场景
          1. 天然幂等：读
          1. 保证幂等：写、消息订阅和处理
     1. 如何保证
        - 基于状态：根据状态机，如订单状态的流转，原理同version，但是只应用在状态会变更的情况下
        - 基于唯一键：可以是几个id的组合。如一个用户每天只能领一张优惠券，通过用户id+优惠券类型+日期字符串即可唯一标识
        - 基于数据库
          1. 加悲观锁for update
          1. 加乐观锁version
          1. 加唯一索引
        - 基于redis分布式锁
### 软件
1. 建模与设计
   - uml：用uml模型表达设计意图，去形成完整软件模型，可以作为设计文档。层次分明，表达明确
     1. 类图：关系
     1. 序列图：动态调用关系和对象间的交互
     1. 组件序列图：粗粒度的调用关系和交互
     1. 部署图：物理实现的蓝图，服务器数量等，概要设计阶段
     1. 用例图：需求分析阶段，反映用户和软件系统的交互，描述软件的功能需求
     1. 状态图：对象的描述状态变更
     1. 活动图：(流程图)，描述业务逻辑、业务流程
        - 实心圆 流程开始，空心圆 流程结束，圆角矩形 活动，菱形 分支判断
        - 泳道 范围划分
