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
   - 注释：注释是我们代码表达意图时失败的弥补，它不能美化糟糕的代码，能用代码的不要用注释，不准确的注释是在满口胡言
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
     1. 开放闭合原则：对扩展开放、对修改封闭。如每当添加新类型就必须修改时，可以使用工厂模式代替
     1. 依赖倒转原则：细节应该依赖于抽象，高层模块不应该依赖底层模块，两个都应该依赖抽象
     1. 里氏代换原则：子类必须能够替换父类，并出现在父类出现的任何地方
     1. 接口隔离原则：使用多个专门的接口，而不使用单一的总接口，就是接口也要遵从单一职责原则
     1. 迪米特法则：即最少知识原则，强调类之间的松耦合，应该对其他对象保持最少的了解
   - 其他
     1. 性能：for循环里不能有调用api、数据库操作等，字符串用单引号代替双引号
     1. 格式：整洁、规范、团队统一，垂直方向上空行作为概念的分隔，有联系的代码紧挨着；水平方向上空格表示参数隔离，太长的一行代码不好阅读，严格遵循缩进
### 设计模式
1. 认识：design pattern，
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
1. java实现
   - 单例模式：用if判断多次申请只返回同一个对象
   - 建造者模式
     1. 理解：就是用一个建造类建造一个类让对象更方便建造
     1. 特点
        - 良好封装性，使用者可以不用了解内部组成就创建可使用的对象
        - 建造者独立，被建造类容易扩展
     1. 实例：建造几个王者荣耀英雄
        - 被建造类
            ```java
            public class HeroConfig{
                HeroBuilder mbuilder = null;
                // 英雄的三个技能
                private String firstSkill;
                private String secondSkill;
                private String thirdSkill;
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
                    if(mbuilder.thirdSkill != null) {
                        thirdSkill = mbuilder.thirdSkill;
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
        - 建造者(即建造执行者)
            ```java
            public static class HeroBuilder{
                // 英雄的三个技能
                private String firstSkill;
                private String secondSkill;
                private String thirdSkill;
                private String TPeffect; // 回城效果

                // 英雄的三个技能是必选的，回城的特效是可选的，所以构造方法只设置三个技能
                public HeroBuilder(String firstSkill, String secondSkill, String thirdSkill) {
                    this.firstSkill = firstSkill;
                    this.secondSkill = secondSkill;
                    this.thirdSkill = thirdSkill;
                }

                public HeroConfig create() {
                    HeroConfig mHeroConfig = new HeroConfig(this);
                    return mHeroConfig;
                }

                public HeroBuilder builderTPeffect(String effect) {
                    this.TPeffect = effect;
                    return this; // 实现链式调用
                }
            }
            ```
        - 使用，来建造类
            ```java
            HeroConfig.HeroBuilder("","","").BuilXX("").create();
            HeroConfig 韩信 = new HeroConfig.HeroBuilder("无情冲锋","背水一战","国士无双").BuilTPeffect("金光闪闪").create();
            ```