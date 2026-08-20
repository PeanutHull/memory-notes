### 思想
1. 有些时候再好的既有流行方案，从性能上讲可能也比不过自家的破轮子，当然自家的轮子泛化不足，肯定普适性就会差很多
1. 思想
   - 单一职责原则：软件系统中的每个元素只完成自己职责范围内的事，而将其他的事交给别人去做，我只是去调用
   - 开闭原则：OCP，对扩展开放，对修改封闭
   - 软件退化的根源：不要怪罪于版本迭代和需求变更，如果每次软件变更时，适时地进行解耦、内聚，先进行功能扩展，再实现新的功能，就能保持高质量的软件设计。但如果在每次软件变更时没有调整程序结构，而是在原有的程序结构上不断地塞代码，软件就会退化
   - 掌握平衡：一方面要满足当前需求，另一方面要刚刚满足需求，从而使设计最简化、代码最少。这样做，不仅软件设计质量提高了，设计难点也得到了大幅度降低
1. CQRS
   - 认识：Command and Query Responsibility Segregation 命令查询职责分离
     1. api读写分离
     1. 基于CQS设计模式：命令查询分离，在单个对象上分离写入和读取，写的不返回数据，读的不改变数据
     1. 对比rest仅允许http动词作为动词，技术语义已经在api级别丢失
     1. 常和ddd、event sourcing一起
   - 组成
     1. Command：post只写
     1. Query：get只读
1. wiki
   - 真正决定软件复杂性的是设计方法
   - 需求分析阶段：四色原型分析模式
     1. 时刻/时间段原型
     1. 参与方-地点-物品原型
     1. 描述原型：说明
     1. 角色原型
   - 业务需求说明：用例图、时序图、状态图
   - 康威定律：微服务的拆分要对应组织
   - 开发方式
     1. TDD：测试驱动开发，先写测试后写实现，red=>green=>refactor(错误=>正确=>重构)
        - PHPUnit
        - Enhance PHP
        - SimpleTest
     1. BDD：行为驱动开发
        - 分支
          1. SpecBDD：专注代码层面，如phpspec
          1. StoryBDD：专注功能测试，如Behat、Codeception
### 领域驱动设计
1. 最佳实践
   - 分层划分：应用层application、领域服务层service、基础设施层infra + 领域层domain
   - 具备功能
     1. 应用层application：参数校验、调用service
     1. 领域服务层service
        - service和mixService。涉及到service复用的，下沉到mixService里
     1. 基础设施层infra
        - 数据访问层：数据库访问、缓存访问、消息队列访问
        - http访问能力
        - 文件上传能力
     1. 领域层
        - model和cache、es两个顶层文件夹，里边各个业务再创建文件夹。或者反过来也行，先创建领域文件夹
1. 认识
   - DDD：领域驱动设计，软件开发方法论，强调通过深入理解业务领域来设计软件系统。通过对于业务子域和限界上下文的划分，建立跨越业务和技术的统一语言，为业务建模的同时，尽量保持业务和技术实现的平衡。将过程式业务流程设计变为面向对象式。帮助开发人员更好地理解和解决复杂领域的问题，解决软件更新迭代变坏
   - 指导确定系统边界、聚焦核心元素、帮助拆分系统
   - DDD的核心主要还是如何把一个复杂的巨型系统解耦，拆解成合理的微服务。要理解DDD的思想，但不要死搬硬套
   - DDD只是一种软件开发方法论、是个理论，理论是死的，并不代表要完完全全照着去实现
     1. 网上各种公司的DDD框架，也只是对方法论按照自己的理解进行的一种实践和实验。所以不要纠结于什么才是一个DDD框架，怎么写一个DDD框架
     1. 更不要死板的去套DDD的各种充血贫血模型，找到适合自己的模型，解决建模问题才是最重要的。DDD只是为你提供了一套系统的方法论仅此而已，并没有多高大上。
   - DDD在实践中伴随业务的发展需要不断完善模型，调整扩展、边界，用发展的眼光看待和解决问题
1. 概念
   - 理论设计
     1. 事务、行为、关系，将以上三个对应做成一个领域模型，然后通过这个领域模型指导程序设计；在每次需求变更时，先将需求还原到领域模型中分析，根据领域模型背后的真实世界进行变更，然后根据领域模型的变更指导软件的变更，设计质量就可以得到提高
   - 分层设计
     1. interface：用户接口层/用户界面层，负责用户信息的展示，本层可以没有
     1. application：应用层，处理业务流程相关的操作，专注于服务组合和编排。不应包含业务逻辑，对内调用领域对象或领域服务完成各种业务编排、组装。为用户界面层提供应用功能
     1. domain：领域层，包括领域模型和领域服务
        - 领域模型：领域中各个类，以及各类之间的关系。这些是战术类的实践落地
          1. 实体：entity，数据（属性）和行为（业务逻辑关系）的结合体，如博客
          1. 值对象：作为一个属性存放于一个实体内部，如置顶的博客
          1. 领域事件：如发布博客事件、删除博客事件
          1. 聚合根：一组具有内聚关系的领域对象（包括实体和值对象）的集合，作为一个整体被对待，聚合根自己负责管理其内部对象的状态和行为，并提供对接口。如博客基础信息，整合了博客的基础信息和所有评论。设计原则包括单一职责、高内聚/低耦合、事务边界(确保在一个事务中所有相关的对象都被正确地修改)
        - 领域服务：承载串联多个领域对象的操作
     1. infrastructure：基础设施层，为其他层提供通用的技术能力，如应用的消息发送、数据库持久化、消息中间件、网关等
        - 贯穿所有层，为上层提供技术支持
        - 采用依赖倒置设计，封装基础资源服务，实现与其他层的解耦
   - 模式
     1. repository：仓储模式，使领域对象可被透明地持久化和检索，而无需暴露底层数据访问技术细节给领域层，一般将仓储接口定义放在领域层，仓储的具体实现放在基础设施层
        - 就是具体到哪些where条件的实现的那层
   - 确定边界的方法：进行领域划分的方法，是递进的关系
     1. 确定子域
     1. 确定子域的界限上下文
     1. 针对界限上下文，确定层级：接口层、领域层、应用层、基础设施层
     1. 针对领域层，做聚合设计：如合并各个领域做输出
   - 模型分类
     1. 失血模型：仅仅包含数据的定义和getter/setter方法，业务逻辑和应用逻辑都放到服务层中。这种类在Java中叫POJO，在.NET中叫POCO
     1. 贫血模型：包含了一些业务逻辑，但不包含依赖持久层的业务逻辑。这部分依赖于持久层的业务逻辑将会放到服务层中。可以看出，贫血模型中的领域对象是不依赖于持久层的
     1. 充血模型：包含了所有的业务逻辑，包括依赖于持久层的业务逻辑。所以，使用充血模型的领域层是依赖于持久层，简单表示就是 UI层->服务层->领域层->持久层
     1. 胀血模型：把和业务逻辑不想关的其他应用逻辑（如授权、事务等）都放到领域模型中
   - 洋葱架构
     1. 围绕独⽴的领域模型构建应⽤
     1. 内层定义接⼝，外层实现接⼝
     1. 依赖的⽅向指向圆⼼，即领域模型
     1. 所有的应⽤代码可以独⽴于基础设施编译和运⾏
1. 传统分层架构
   - 分层：Controller -> service -> repository/Infra -> DB -> utils
     1. service：核心业务逻辑，协调多个Repository的操作、调用Infra层的外部服务等
        - 当出现service循环依赖时，可以在service目录新建common目录，将循环依赖的部分抽取到common目录下，也可以使用interface和实现分离的方式来解决
     1. repository：仓储层，包括cache、store、resource等目录，resource提供如登录校验等公用的业务逻辑相关的代码，用起来像utils，但是和utils这种纯工具分开，比service更低一层
     1. Infra：基础设施层，提供如http请求、文件上传等通用的基础的技术能力。一般是与外部服务交互(邮件、短信、第三方API)、基础设施相关代码

     1. db：实际的数据库存储、由ORM或原生SQL驱动处理
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
     1. 依赖倒置原则：高层模块不应该依赖底层模块，二者都应该依赖抽象；细节应该依赖于抽象。才能高内聚低耦合，不关心怎么定义，反过来也不关心怎么使用，按照规范实现就好了，don't call me，i will call you
     1. 里氏代换原则：子类必须能够替换父类，并出现在父类出现的任何地方。因为子类可以替换掉父类，父类才能被复用，子类也能增加新的功能
     1. 接口隔离原则：使用多个专门的接口，而不使用单一的总接口，就是接口也要遵从单一职责原则，每一个接口只负责一种角色
     1. 迪米特法则：即最少知识原则，强调类之间的松耦合，应该对其他对象保持最少的了解
     1. 合成/聚合复用原则：要尽量使用合成/聚合，不要滥用继承
   - 其他
     1. 性能：for循环里不能有调用api、数据库操作等，字符串用单引号代替双引号
     1. 格式：整洁、规范、团队统一，垂直方向上空行作为概念的分隔，有联系的代码紧挨着；水平方向上空格表示参数隔离，太长的一行代码不好阅读，严格遵循缩进
1. 代码的22种坏味道
   - 重复代码
     1. 一个类中：提炼成一个函数
     1. 兄弟类中：提炼成一个函数，并且提取到父类中
     1. 两个不相关的类：提炼成一个函数，放到两个类中的一个类中或者一个单独的类中
   - 过长函数
   - 过大的类
   - 方法中过长的参数列
   - 发散式变化
     1. 一个类做太多的事情了，万能类，经常因为不同的原因在不同的方向上发生变化，将会产生发散式变化
     1. 将变化隔离，封装变化，把变化的和不变的部分分开，拆分成多个类
   - 散弹式变化
     1. 一个变化引发多个类的修改，把需要修改的部分抽取出来，放到一个单独的类中
   - 依恋情节
     1. 使用了大量其他类的成员
     1. 如果该方法只调用了一个类的多个方法。将该方法移到调用类里，如果该方法调用了多个类的多个方法。将该方法拆解。然后分离到调用类里
   - 数据泥团
     1. 总是成堆出现在一起的数据，应该封装在一个单独的类中
   - 基本类型偏执
     1. 用对象代替基本类型，并不是代替单个的基本类型，而是几个基本类型放在一起更有意义时应该使用对象
   - switch语句
     1. 一看到switch语句，你就应该考虑以多态来替换它，如果一个switch操作只是执行简单的行为，就没有重构的必要了
   - 平行继承体系
     1. 每当为某个类增加一个子类，必须也为另一个类增加一个子类。消除这种重复性的一般策略是：让一个继承体系的实例引用另一个继承体系的实例
   - 冗赘类
   - 夸夸奇谈谈未来
     1. “我想总有一天需要做这事”，并因而企图以各样的钩子和特殊情况来处理一些非必要的事情。如果用不到，就不值得。删掉
   - 令人迷惑的临时字段
     1. 有时候你会发现：类中的某个实例变量仅为某种特定情况而设。这样的代码让人难以理解，因为你通常认为对象在所有时候都需要它的所有变量
     1. 将这些临时变量集中到一个新类中管理
   - 过度耦合的消息链
     1. 有些时候我们在调用某个函数的时候往往会形成A->B->C->D.test(),这个时候如果你在A端，你就产生了Message Chains的坏味道。这种状态使的你客户代码在A中变成getB()->getC()->getD()->test(),这会使得客户代码在以后这些类关系发生变化的时候变得极易修改与相当不稳定。可以使用隐藏“委托关系”，并在服务类上建立客户所需要的所有函数来打破这消息链，理论上你可以重构消息链上的任一对象。但这样做往往会让这些小对象都变成Middle Man(中间人)，通常更好的做法是：查看消息链最终对象是用来干什么的，看看是否能用Extract Method把他提炼到一个独立的函数中去，再运用Move Method把这个函数推入消息链
   - 中间人
     1. 大部分都交给中介来处理了。用继承替代委托
   - 狎昵关系
     1. 两个类彼此使用对方的私有的东西。可以通过“移动方法”和“移动字段”帮它们划清界限，从而减少狎昵行径
     1. 如果两个类实在是情投意合，可以把两者共同点提炼到一个安全地点，让它们坦荡地使用这个新类，从而改变从双向依赖A->B,B->A变成A->C,B->C。或者通过隐藏“委托关系”让另一个类来为它们传递相思情，
   - 异曲同工的类
   - 不完美的库类
     1. 包一层函数或包成新的类
   - 纯稚的数据类
     1. 类很简单，仅有公共成员变量，或简单操作函数。将相关操作封装进去，减少public成员变量
   - 被拒绝的遗贈
     1. 父类里面方法很多，子类只用有限几个,用代理替代继承关系
   - 过多的注释
     1. 当你感觉需要撰写注释时，请先尝试重构，试着让所有注释都变得多余。好代码即注释
### 设计模式
1. design pattern
   - 理解
     1. 是特定环境下同类问题的解决方案，是自下而上的，来源于实践，发现模式而不是发明模式
     1. 是对高频变化点的结构化处理
        - 未来最可能变化的是什么？变化应该被隔离在哪一层？谁应该依赖谁？运行时还是编译时决定？是数据变化、行为变化，还是流程变化？
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
    | 类型 | 核心问题 | 关键提问 | 隔离的变化 | 具体模式 |
    |------|----------|----------|------------|----------|
    | 创建型 | 解决对象怎么产生 | `new谁？什么时候new？` | 隔离“实例化变化” | 单例、工厂、抽象工厂、建造者、原型 |
    | 结构型 | 解决对象怎么组合 | `这些东西怎么拼起来？` | 隔离“依赖关系变化” | 适配器、桥接、组合、装饰器、外观、享元、代理 |
    | 行为型 | 解决对象怎么协作 | `逻辑怎么流转？谁负责什么？` | 隔离“算法/流程变化” | 责任链、命令、解释器、迭代器、中介者、备忘录、观察者、状态、策略、模版方法、访问者 |
1. 比较
    | 模式                | 目的                |
    | ----------------- | ----------------- |
    | Adapter 适配器                    | 不兼容接口 → 兼容接口           |
    | Decorator 装饰器                  | 原有功能 → 我给它加点能力        |
    | Facade 外观                       | 复杂接口 → 提供简单接口         |
    | Proxy 代理                        | 增加代理的逻辑                 |

    | Chain of Responsibility 责任链    | 请求沿着处理链一个个传递         |
    | Command  命令                     | 做什么                        |
    | Mediator 中介者                   | 集中协调多个对象之间的交互        |
    | Observer 观察者                   | 一个事件发生，通知一批订阅者      |
    | State 状态                        | 现在是什么状态，所以决定怎么做    |
    | Strategy 策略                     | 选择怎么做，调用方主动选择策略    |

   - 策略模式：封装一堆算法，用的时候注入不同的策略
1. 单例模式
   - 理解：保证只有一个实例，并提供一个访问它的全局访问点，避免不断new浪费资源，同时承担全局唯一的功能。php的所有在页面执行完后全部清空削弱了单例的表现，饿汉模式、懒汉模式
   - 要点
     1. 类只能有一个实例
     1. 它自己自行创建这个实例
     1. 它必须自行向整个系统提供这个实例
   - 最佳实践
     1. go中
        - 一般使用直接实例化就够了，更推荐通过依赖注入管理生命周期
        - 不封装到内部的单例经常是臭味，会产生隐式依赖和全局状态；和go的设计哲学(显式依赖和可测试性)存在一些冲突
          1. 隐式全局状态：通过参数传递、结构体字段或接口显式注入依赖，让数据流清晰可见来解决
             - 状态共享不可见：调用方不知道某个函数内部依赖了全局单例，依赖关系被隐藏
             - 难以推理：单例的状态可能被任意代码修改，程序的执行结果可能依赖于调用顺序或并发时序
          1. 测试困难
             - 无法替换实现：单例硬编码了具体类型，测试时难以用Mock或Fake替换
             - 状态污染：单例的全局状态可能在测试用例之间残留，导致测试相互影响（需手动重置）
          1. 并发安全问题：优先使用无状态设计；若有状态，则明确其生命周期和所有者，避免全局共享
             - 虽然用sync.Once解决了单例初始化线程安全，但单例内部可变状态的并发访问仍需额外加锁
             - 锁可能成为性能瓶颈或死锁源头
          1. 违反“显式优于隐式”原则
             - 让函数签名“说谎”：如函数签名无参数，却依赖全局单例
             - 增加代码维护者的认知负担（需要查找隐藏的依赖）
   - 实例
     1. go
        ```go
        // go这么写很多时候已经够了
        var DefaultClient = &Client{}

        // 更推荐
        // 1. 通过依赖注入管理生命周期
        type Service struct {
            db *sql.DB
        }

        func NewService(db *sql.DB) *Service {
            return &Service{db: db}
        }

        // 2. 通过context或配置结构体传递，避免全局可变状态
        ```
     1. php
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
   - 理解：定义一个用于创建对象的接口，让子类决定实例化哪一个类，使实例化延迟到其子类来决定
     1. 本质是将不变的部分提取出来，将可变的部分留作接口，以达到最大程度上的复用
   - 场景：有众多子类且会扩充，创建方法比较复杂的情况下适用。工厂类在多态性编程实践中是至关重要的，它允许动态的替换类/修改配置，使程序更加灵活
   - 最佳实践
     1. go中通常一次性完成整个dependency graph，`NewApplication(config)`
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
     1. 工厂方法：遵守开闭原则，一个方法只创建一种产品，通过继承让子类决定创建哪个具体产品
        ```php
        // 产品接口
        interface Button {
            public function render();
        }

        // 具体产品
        class WindowsButton implements Button {
            public function render() { echo "Windows 按钮\n"; }
        }

        class MacButton implements Button {
            public function render() { echo "Mac 按钮\n"; }
        }

        // 抽象创建者
        abstract class Dialog {
            // 工厂方法：子类决定创建什么
            abstract protected function createButton(): Button;

            // 使用产品的逻辑
            public function renderDialog() {
                $button = $this->createButton();
                $button->render();
            }
        }

        // 具体创建者
        class WindowsDialog extends Dialog {
            protected function createButton(): Button {
                return new WindowsButton();
            }
        }

        class MacDialog extends Dialog {
            protected function createButton(): Button {
                return new MacButton();
            }
        }

        // 使用
        $dialog = new WindowsDialog();
        $dialog->renderDialog();  // 输出：Windows 按钮
        ```
     1. 抽象工厂：Abstract Factory，一个工厂创建一组相关的产品，通过组合切换整个产品族，保证产品之间风格/版本一致
        ```go
        // 产品接口
        type Button interface {
            Render()
        }

        type InputBox interface {
            Render()
        }

        // Windows 产品族
        type WindowsButton struct{}
        func (b WindowsButton) Render() { fmt.Println("Windows 按钮") }

        type WindowsInputBox struct{}
        func (b WindowsInputBox) Render() { fmt.Println("Windows 输入框") }

        // Mac 产品族
        type MacButton struct{}
        func (b MacButton) Render() { fmt.Println("Mac 按钮") }

        type MacInputBox struct{}
        func (b MacInputBox) Render() { fmt.Println("Mac 输入框") }

        // 抽象工厂接口
        type UIFactory interface {
            CreateButton() Button
            CreateInputBox() InputBox
        }

        // Windows 工厂
        type WindowsUIFactory struct{}
        func (f WindowsUIFactory) CreateButton() Button { return WindowsButton{} }
        func (f WindowsUIFactory) CreateInputBox() InputBox { return WindowsInputBox{} }

        // Mac 工厂
        type MacUIFactory struct{}
        func (f MacUIFactory) CreateButton() Button { return MacButton{} }
        func (f MacUIFactory) CreateInputBox() InputBox { return MacInputBox{} }

        func main() {
            var factory UIFactory = WindowsUIFactory{}
            
            button := factory.CreateButton()
            inputBox := factory.CreateInputBox()
            
            button.Render()    // Windows 按钮
            inputBox.Render()  // Windows 输入框
        }
        ```
1. 建造者模式
   - 理解：把复杂对象的构建过程从对象本身剥离
     1. 用于参数很多、构建过程复杂的对象
     1. 良好封装性，使用者可以不用了解内部组成就创建可使用的对象
     1. 建造者独立，被建造类容易扩展
   - 最佳实践
     1. go中
        - 是非常值得掌握的模式，大量go sdk都这么设计
   - 实例
    ```go
    // functional options
    type Server struct {
        addr    string
        timeout time.Duration
    }

    type Option func(*Server)

    func WithAddr(addr string) Option {
        return func(s *Server) {
            s.addr = addr
        }
    }
    func WithTimeout(timeout time.Duration) Option {
        return func(s *Server) {
            s.timeout = timeout
        }
    }

    // 建造者
    func NewServer(opts ...Option) *Server {
        s := &Server{
            addr:    ":8080",
            timeout: 3 * time.Second,
        }

        for _, opt := range opts {
            opt(s)
        }

        return s
    }

    // 调用
    server := NewServer(
        WithAddr(":9000"),
        WithTimeout(5*time.Second),
    )
    ```
1. 原型模式
   - 理解：复制原型创建新的对象，从一个对象克隆一个新的，而不需要知道如何创建的细节。可用于创建对象成本过高
     1. 浅拷贝：引用不会被复制，注意共享修改
     1. 深拷贝：可调用被引用对象自身的克隆方法进行复制
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
   - 理解：把一个“接口不兼容”的现有对象，转换成你想要的接口，是“事后兼容”
     1. 屏蔽多来源细节，统一调用
     1. 建立防腐层，阻止外部系统的数据结构、接口设计和SDK细节污染自己的业务代码
   - 场景
     1. 接第三方SDK
     1. 多来源(供应商、存储系统、MQ等)统一接口
     1. 老接口迁移到新接口
   - 最佳实践
     1. go中
        - go里的Adapter往往非常薄，甚至可以只有几行，因为是隐式实现接口
   - 示例
    ```go
    type Payment interface {
	    Pay() string
    }

    type Alipay struct{}
    func (Alipay) DoPay() string {              // 支付宝SDK长这样
        return "alipay"
    }

    type AlipayAdapter struct {                 // 针对aliPay的适配器
        Alipay
    }
    func (a AlipayAdapter) Pay() string {
        return a.DoPay()
    }

    // 业务代码使用
    func checkout(p Payment) {
        fmt.Println(p.Pay())
    }
    func main() {
        checkout(AlipayAdapter{Alipay{}})
    }
    ```
1. 桥接模式
   - 理解：把“抽象”和“实现”拆成两个独立维度，通过组合连接起来，让它们可以分别变化，是“事前解耦”
     1. 就是解耦了排列组合
     1. 场景：两个维度都在变化，如果全靠继承/组合类型，会产生类爆炸
        ```
        如：
        消息类型：普通消息、紧急消息
        发送渠道：短信、微信、Email

        如果直接组合成类型会越来越多：
        普通短信
        普通微信
        紧急短信
        紧急微信
        ...

        桥接模式把它拆开：
        消息类型 ──> 桥接 ──> 发送渠道
        ```
   - 示例
    ```go
    type Sender interface {
        Send(string)
    }

    type SMS struct{}
    func (SMS) Send(s string) { fmt.Println("SMS:", s) }

    type Message struct {                                       // 桥，不自己实现发送，而是持有一个Sender
        sender Sender
    }
    func (m Message) Send(s string) {
        m.sender.Send(s)
    }

    // 使用
    Message{SMS{}}.Send("hello")

    // 以后增加微信消息
    type WeChat struct{}
    func (WeChat) Send(s string) { fmt.Println("WeChat:", s) }
    // 再增加消息类型
    type Urgent struct {
        sender Sender
    }
    func (u Urgent) Send(s string) {
        u.sender.Send("[紧急]" + s)
    }

    // 直接
    Message{WeChat{}}.Send("hello")
    Urgent{SMS{}}.Send("服务器挂了")
    ```
1. 组合模式
   - 认识：单个和整体统一对待，专治树形结构。把“单个对象”和“一组对象”统一成同一种接口，让调用方不用区分叶子节点还是组合节点
     1. 关键点是文件和目录都实现同一个接口
     1. 场景：特别适合树形结构，如目录下有目录和文件，目录又有目录和文件
   - 最佳实践
     1. go里的组合模式通常非常轻，因为go不需要继承
   - 示例
    ```go
    type Node interface {
        Print()
    }

    type File string
    func (f File) Print() {
        fmt.Println(f)
    }

    type Dir []Node
    func (d Dir) Print() {
        for _, n := range d {
            n.Print()
        }
    }

    func main() {
        root := Dir{                        // 最关键的是这个Dir，既可以放File，又可以放Dir
            File("a.txt"),
            File("b.txt"),
            Dir{
                File("c.txt"),
            },
        }

        root.Print()
    }
    ```
1. 装饰器模式
   - 理解：不修改原对象代码，通过“套一层壳”的方式，动态给对象增加功能
     1. 即原能力加日志、加重试、加监控、加缓存，每一层都实现同一个接口 + 持有同一个接口
     1. 组成：原对象、装饰器A、装饰器B
   - 最佳实践
     1. 常用于中间件middleware的使用，如
        ```go
        func Auth(next Handler) Handler {
            return func(ctx context.Context, req Request) Response {
                // check token
                return next(ctx, req)
            }
        }
        ```
   - 示例
    ```go
    // 通常用interface + struct包装实现
    // 核心模版代码
    type Component interface {
        Do()
    }

    type Decorator struct {
        Component
    }

    func (d Decorator) Do() {
        // 增强逻辑
        d.Component.Do()
    }


    // 示例：有一个发送消息的能力
    type Sender interface {
        Send()
    }

    type Email struct{}
    func (Email) Send() {
        fmt.Println("send email")
    }

    // 日志机制
    type LogSender struct {
        Sender
    }
    func (l LogSender) Send() {
        fmt.Println("log")
        l.Sender.Send()
    }

    // 重试机制
    type RetrySender struct {
        Sender
    }
    func (r RetrySender) Send() {
        fmt.Println("retry")
        r.Sender.Send()
    }
    
    // 使用
    s := LogSender{Email{}}
    s.Send()
    // 继续套
    s := RetrySender{
	    LogSender{
            Email{},
        },
    }
    s.Send()
    ```
1. 外观模式
   - 理解：给一堆复杂子系统包一层简单入口，让调用方不用关心内部怎么协作
     1. 如下单实际涉及库存检查、支付、物流、通知，不能让业务方自己挨个调用
   - 示例
    ```go
    type Stock struct{}
    func (Stock) Check() { fmt.Println("检查库存") }

    type Pay struct{}
    func (Pay) Do() { fmt.Println("支付") }

    type OrderFacade struct {
        stock Stock
        pay   Pay
    }

    func (o OrderFacade) Place() {
        o.stock.Check()
        o.pay.Do()
    }

    func main() {
        OrderFacade{}.Place()
    }
    ```
1. 享元模式
   - 理解：把大量重复对象中“相同的部分”抽出来共享，避免重复创建对象，主要目的是省内存
     1. 相同的东西只存一份，不同的东西从外面传：大量业务对象主动引用同一个共享对象，从对象模型层面消除重复状态
     1. 如假设系统里有100万棵树，树种/纹理/颜色大量重复，所以不要创建100万份完整对象，而是100万个坐标 + 共享少量TreeType
     1. 场景：对象特别多，并且对象之间存在大量重复数据
   - 示例
    ```go
    // 多的是用户，固定的是角色
    type Role struct {
        Name  string
    }

    var roles = map[string]*Role{}
    func GetRole(name string) *Role {
        if roles[name] == nil {
            roles[name] = &Role{name}
        }
        return roles[name]
    }

    type User struct {
        ID   int
        Role *Role
    }

    func main() {
        // 用户可以有很多，但是角色就那么些
        a := User{1, GetRole("teacher")}
        b := User{2, GetRole("teacher")}

        fmt.Println(a.Role == b.Role)       // true，证明只共享了一份角色
    }
    ```
1. 代理模式
   - 理解：不让调用方直接访问真实对象，而是先经过一个“代理对象”，由代理决定要不要、什么时候、怎么访问真实对象
     1. 常用于：缓存、权限校验、限流、远程调用封装、延迟加载
   - code
    ```go
    type UserService interface {
        Get(id int) string
    }

    type DBUserService struct{}
    func (DBUserService) Get(id int) string {
        return "用户数据" // 模拟查 DB
    }

    type UserProxy struct {
        real  UserService
        cache map[int]string
    }
    func (p *UserProxy) Get(id int) string {
        if v, ok := p.cache[id]; ok {
            return v
        }

        v := p.real.Get(id)
        p.cache[id] = v
        return v
    }
    ```
1. 注册树模式
   - 理解：注册表模式，为了解决全局共享，将创建好的对象注册到注册树上，需要访问直接从注册树上查询即可
     1. 核心是`map[string]xxx`
   - 示例
    ```go
    var registry = map[string]Obj{}

    func Register(name string, p Obj) {
        registry[name] = p
    }
    ```
1. 责任链模式
   - 理解：把一堆处理器串成链，请求沿着链往下传，每个处理器只负责自己那一小段逻辑。即把请求交给责任链的下一个节点
     1. 可以灵活设置链条
     1. 每一步可以随时终止流程
     1. 扩展处理方法直接新增、不需要修改之前的
     1. 在业务开发中很常见，如下单操作为参数→库存→风控→创建订单，中间件middleware的next就是
   - demo
    ```go
    // 一个订单处理流程
    type Handler interface {
        Handle(order *Order) error
    }

    // 定义链条
    type HandlerFunc struct {
        next Handler
        fn   func(*Order) error
    }
    func (h HandlerFunc) Handle(o *Order) error {
        if err := h.fn(o); err != nil {
            return err
        }
        if h.next != nil {
            return h.next.Handle(o)
        }
        return nil
    }

    // 定义业务节点
    stock := HandlerFunc{fn: func(o *Order) error {
        if o.Stock <= 0 {
            return errors.New("库存不足")
        }
        return nil
    }}
    risk := HandlerFunc{fn: func(o *Order) error {
        if o.Amount > 10000 {
            return errors.New("触发风控")
        }
        return nil
    }}

    // 串起来
    stock.next = risk
    err := stock.Handle(order)
    ```
1. 命令模式
   - 理解：把“一次操作”封装成一个对象，让操作可以被存储、排队、重试、记录、撤销，而不是立即执行
     1. 以前是“直接调用函数”，现在变成“先把要干什么包装成一个任务，再决定什么时候执行”
     1. 之前是调用方和具体业务逻辑耦合在一起，现在拆开了
     1. 意义在于可以：延迟、异步、失败重试、权限校验、批量
     1. 把函数调用，从“现在立即执行的代码”，升级成“可以被管理的数据/对象化”，把行为本身当成数据传递
   - 最佳实践
     1. php中封装成job，可以独立运行，也可以异步运行
   - 示例
    ```go
    // 单支付成功后发优惠券
    type Command interface {
        Execute()
    }

    type SendCoupon struct {                        // 是核心，变成了一个命令
        userID int
    }
    func (c SendCoupon) Execute() {
        fmt.Println("发优惠券:", c.userID)
    }

    func run(cmd Command) {
        cmd.Execute()
    }

    // 使用
    run(SendCoupon{userID: 1001})
    ```
1. 解释器模式
   - 理解：把一套“规则/表达式”解析成程序可以执行的逻辑。是自定义的一套小语法/DSL，让不同的“表达式对象”解释它
     1. 规则不是写死在代码里的，而配置出来的，可以做到动态化组合
     1. 场景：动态规则、权限表达式、筛选条件、风控规则、优惠规则
     1. 执行流程：规则配置 -> 表达式树 -> 递归执行每个节点
   - 示例
    ```go
    // 评估对象
    type Order struct {
        VIP    bool
        Amount int
    }

    // 表达式基结构
    type Expr interface {
        Match(Order) bool
    }

    type VIP struct{}                               // vip规则
    func (VIP) Match(o Order) bool {
        return o.VIP
    }

    type AmountGT struct {
        N int
    }
    func (e AmountGT) Match(o Order) bool {         // 大于规则
        return o.Amount > e.N
    }

    type And struct {                               // 且规则
        A, B Expr
    }
    func (e And) Match(o Order) bool {
        return e.A.Match(o) && e.B.Match(o)
    }

    type Or struct {                                // 或规则
        A, B Expr
    }
    func (e Or) Match(o Order) bool {
        return e.A.Match(o) || e.B.Match(o)
    }

    // 使用
    func main() {
        // 定义规则
        rule := And{
            VIP{},
            AmountGT{100},
        }

        // 进行评判
        fmt.Println(rule.Match(Order{
            VIP:    true,
            Amount: 200,
        }))
    }
    ```
1. 迭代器模式
   - 理解：把“怎么遍历一堆数据”这件事，从业务代码里抽出去。即调用方只管不断Next()，不用知道数据底层是数组、链表、分页接口还是数据库游标
     1. 把for循环背后的“取下一个数据”逻辑封装起来，价值是隐藏了分页/游标/批量查询等复杂的遍历逻辑
   - 示例
    ```go
    // 待处理订单
    type Order struct {
        ID int
    }

    // 迭代器
    type OrderIterator struct {
        orders []Order
        index  int
    }
    func (it *OrderIterator) HasNext() bool {
        return it.index < len(it.orders)
    }
    func (it *OrderIterator) Next() Order {
        o := it.orders[it.index]
        it.index++
        return o
    }

    // 使用
    it := &OrderIterator{
        orders: []Order{{1}, {2}, {3}},
    }
    for it.HasNext() {
        order := it.Next()
        fmt.Println(order.ID)
    }
    ```
1. 中介者模式
   - 理解：多个业务模块不要互相直接调用，统一通过一个“中间人”协调
     1. 核心：降低对象之间的网状依赖，因为业务一复杂模块之间就互相引用
     1. 中介者可以协调逻辑、顺序、条件判断
     1. EventBus很多时候就是Mediator + Observer
   - 示例
    ```go
    // 如支付成功之后改订单状态、扣库存、发通知
    type OrderService struct{}
    func (OrderService) Paid(id int) {}

    type StockService struct{}
    func (StockService) Deduct(id int) {}

    type NotifyService struct{}
    func (NotifyService) Send(id int) {}

    type Mediator struct {
        order  OrderService
        stock  StockService
        notify NotifyService
    }
    func (m Mediator) PaySuccess(orderID int) {
        m.order.Paid(orderID)
        m.stock.Deduct(orderID)
        m.notify.Send(orderID)
    }

    // 使用
    m := Mediator{}
    m.PaySuccess(1001)

    // 更标准一点的写法是抽接口
    ```
1. 备忘录模式
   - 理解：在不暴露对象内部实现的情况下，保存对象某一时刻的状态，并且以后可以恢复，给业务对象做一个“快照/撤销点”
     1. 别记录“怎么改回去”，直接保存“改之前是什么样”
     1. 用于检查点、存档、快照、undo等
   - 最佳实践
     1. go中注意slice/map/pointer的浅复制问题
   - 示例
    ```go
    // 修改订单信息，支持撤销
    type Order struct {
        Status string
        Amount int
    }

    type Snapshot struct {                          // 快照本体
        Status string
        Amount int
    }
    func (o *Order) Save() Snapshot {
        return Snapshot{o.Status, o.Amount}
    }
    func (o *Order) Restore(s Snapshot) {
        o.Status = s.Status
        o.Amount = s.Amount
    }



    // 使用
    var history []Snapshot
    order := &Order{"pending", 100}

    history = append(history, order.Save())
    order.Status = "paid"
    history = append(history, order.Save())
    order.Status = "refund"

    // 撤销
    last := history[len(history)-1]
    history = history[:len(history)-1]

    order.Restore(last)
    ```
1. 观察者模式
   - 理解：一个对象发生变化后，自动通知一批依赖它的对象
     1. 和发布订阅很像：但观察者通常是发布者直接持有观察者，而Pub/Sub中间通常多一层Broker/EventBus
   - 示例
     1. 通常写法
        ```go
        // 如支付成功之后改订单状态、扣库存、发通知
        type Observer interface {                               // 观察者抽象
            Update(orderID int)
        }

        type Order struct {
            observers []Observer
        }
        func (o *Order) Subscribe(obs Observer) {               // 用户提供的订阅方法
            o.observers = append(o.observers, obs)
        }
        func (o *Order) Pay(orderID int) {                      // 用户发生的事件
            for _, obs := range o.observers {                   // 用户主动触发依赖
                obs.Update(orderID)
            }
        }

        // 两个观察者
        type PointService struct{}
        func (PointService) Update(orderID int) {
            fmt.Println("增加积分:", orderID)
        }

        type CouponService struct{}
        func (CouponService) Update(orderID int) {
            fmt.Println("发优惠券:", orderID)
        }

        // 使用
        order := &Order{}

        order.Subscribe(PointService{})
        order.Subscribe(CouponService{})

        order.Pay(1001)
        ```
     1. 精简写法
        ```go
        type Order struct {                                 // interface能省就省，直接把函数当观察者
            observers []func(int)
        }

        func (o *Order) Subscribe(fn func(int)) {
            o.observers = append(o.observers, fn)
        }

        func (o *Order) Pay(id int) {
            for _, fn := range o.observers {
                fn(id)
            }
        }
        // 使用
        order := &Order{}

        order.Subscribe(func(id int) {
            fmt.Println("增加积分", id)
        })

        order.Subscribe(func(id int) {
            fmt.Println("发优惠券", id)
        })

        order.Pay(1001)
        ```
1. 状态模式
   - 理解：同一个对象，因为当前状态不同，对同一个操作表现出不同的行为。把`if status == xxx`这种状态判断，拆到不同的状态对象里，因为状态变多判断就变多了
     1. 把“根据状态判断该干什么”，变成“让当前状态自己决定该干什么”：剥离了本体对于分支业务的不同状态的判断包袱，让分支业务自己处理
     1. 用于状态流转的逻辑处理，且状态数量较多且可能变化，一两个就没必要复杂设计了
        - 状态机关注“状态怎么流转”
        - 状态模式关注“不同状态下行为怎么变化”
   - 示例
    ```go
    // 待支付/已支付/已取消，不同状态下能否取消订单不一样
    type State interface {
        Cancel()
    }

    type Pending struct{}
    func (Pending) Cancel() {
        fmt.Println("订单取消成功")
    }

    type Paid struct{}
    func (Paid) Cancel() {
        fmt.Println("已支付，不能直接取消")
    }

    type Order struct {
        State State
    }
    func (o *Order) Cancel() {
        o.State.Cancel()
    }

    // 使用
    order := Order{State: Pending{}}
    order.Cancel()

    order.State = Paid{}
    order.Cancel()
    ```
1. 策略模式
   - 理解：把一组“可以互相替换的业务算法”抽出来，调用方根据场景选择其中一个
     1. 当多个分支代表“同一件事的不同做法”时，把“做法”抽成策略
        - 不要一看到switch就使用策略模式，关键看这些分支是不是同一个业务目标的不同实现方式
     1. 调用方主动选择策略
   - 示例
    ```go
    // 打折逻辑

    // 坏味道的代码
    switch userType {                                                       // 这里会变成巨大的策略分发中心，很糟糕
    case "vip":
        price *= 0.9
    case "svip":
        price *= 0.8
    }

    // 策略模式
    type Discount interface {
        Calc(float64) float64
    }

    type VIP struct{}
    func (VIP) Calc(price float64) float64 { return price * 0.9 }
    type SVIP struct{}
    func (SVIP) Calc(price float64) float64 { return price * 0.8 }

    func checkout(price float64, d Discount) float64 {                      // 策略执行器
        return d.Calc(price)
    }

    // 使用
    price := checkout(100, VIP{})  // 90
    price := checkout(100, SVIP{}) // 80


    // 极简写法
    type Sender func(string)

    func send(msg string, sender Sender) {
        sender(msg)
    }

    sms := func(msg string) { fmt.Println("短信:", msg) }
    email := func(msg string) { fmt.Println("邮件:", msg) }

    send("验证码1234", sms)
    send("订单支付成功", email)
    ```
1. 模板方法模式
   - 理解：把一套固定流程放在“模板”里，流程中的某些步骤留给具体实现去决定
     1. 场景：整体流程一样，但某几个步骤会因业务不同而变化
   - 最佳实践
     1. go中没有继承，所以通常用接口 + 组合来实现模板方法
     1. 和策略模式经常一起出现，用策略替换其中的可变部分
   - 示例
    ```go
    // 短信和邮件的发送流程都是参数校验、构造内容、发送
    type Sender interface {
        Build() string
        Send(string)
    }

    func SendMessage(s Sender) {                // 模板方法
        fmt.Println("校验参数") // 固定

        msg := s.Build()       // 可变
        s.Send(msg)            // 可变

        fmt.Println("记录日志") // 固定
    }

    // 短信实现
    type SMS struct{}
    func (SMS) Build() string {
        return "验证码：1234"
    }
    func (SMS) Send(msg string) {
        fmt.Println("发送短信:", msg)
    }

    // 使用
    SendMessage(SMS{})
    ```
1. 访问者模式
   - 理解：对象类型比较稳定，但针对这些对象的“操作”经常增加时，把操作从对象里抽出去
     1. 数据结构和业务操作解耦：操作可以自由变化，体现开放-封闭原则
     1. 场景：数据结构稳定，有多变化的算法
     1. 新增操作会很舒服，于新增对象类型很痛苦(原有的操作都需要补)
   - 最佳实践
     1. go没有OOP方法重载，通常用Accept()/VisitXXX()显式的模拟出来
     1. AST是Visitor的教科书级场景
   - 示例
    ```go
    // 系统里长期存在订单、退款，需要做审计、导出、统计、风控检查等
    type Order struct{ ID int }
    func (o *Order) Accept(v Visitor)  { v.VisitOrder(o) }
    type Refund struct{ ID int }
    func (r *Refund) Accept(v Visitor) { v.VisitRefund(r) }

    type Visitor interface {
        VisitOrder(*Order)
        VisitRefund(*Refund)
    }

    // 审计操作
    type AuditVisitor struct{}
    func (AuditVisitor) VisitOrder(o *Order)   { fmt.Println("审计订单", o.ID) }
    func (AuditVisitor) VisitRefund(r *Refund) { fmt.Println("审计退款", r.ID) }

    // 使用
    v := AuditVisitor{}                         // 把横向操作拿出去，要不然Order/Refund会逐渐承担一堆本来不属于订单核心领域逻辑的职责
    (&Order{ID: 1}).Accept(v)                   // 双分派：第一次确定对象类型，第二次执行的操作
    (&Refund{ID: 2}).Accept(v)
    ```
### 软件设计模式
1. IoC和DI
   - 认识
     1. 作用：降低代码之间耦合度、提高灵活性和可维护性、易于扩展
     1. ioc从容器的角度，di从应用程序的角度，ioc是目的，di是手段。是同一件不同层面的解读
   - DI：依赖注入，用于实现控制反转。在这种模式下一个对象的依赖项（即其使用的其他对象）不是由对象自己创建，而是在其运行期间由外部实体（如容器或框架）提供给它。这种方式允许对象专注于其核心职责，而不必关心其依赖项的创建和管理
     1. 常见实现方式有构造器参数、setter方法注入
     1. 支持延迟加载：只有需要时才会创建对象实例
   - IoC：Inversion of Control，控制反转，用于降低计算机程序各个模块之间的耦合。应用程序中的组件不再负责其依赖项的创建和管理，而是将这些职责交给外部容器或框架来处理。这样组件之间的耦合度降低，系统的可维护性和可扩展性得到提高
     1. 为解决多个类之间的依赖
     1. 将一个对象的依赖关系从硬编码中解耦出来，并将其交由外部的容器来管理。这个容器会负责创建和查找对象，并将它们注入到需要它们的对象中
     1. 降低了代码的复杂性，使得代码更易于理解和测试。同时，它也使得代码的模块化程度更高，可以更方便地进行替换和扩展
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
1. AOP：面向切面编程，剖开封装的对象内部，并将影响多个类的公共行为封装到一个模块。旨在通过将应用程序中的横切关注点从业务逻辑中分离出来，提高代码的可重用性和可维护性。是OOP（面向对象编程）的延续
   - 比如公共依赖的db、log等组件
### wiki
1. GDB
   - 认识：The GNU Project Debugger，即GDB调试器(鱼)，可监控程序的执行流程。诞生于GUN计划，同时的还有GCC、Emacs等
     1. 可按照自定义要求运行程序，如设置参数和环境变量
     1. 支持断点调试，并查看程序状态
     1. 可以直接查看内存数据
     1. 支持C、C++、Go、Objective-C、OpenCL的调试
   - 调试方式
     1. 直接使用gdb
     1. 目标使用gdbserver，本地gdb调试
     1. ulimit -c unlimited生成core文件，本地gdb调试
   - 使用
     1. 调试
        - `gdb program`：开始调试
          1. -p：调试进程id为xx的程序
          1. --args：为程序传递参数
        - `gdb program core dump`：调试core dump，使用`set solib-search-path`加载库文件
        - `gdb -d`：参数载入
     1. 运行
        - `r xx`：run，开始运行、触发第一个断点，也可传递参数
        - `st xx`：start，开始执行程序,在main函数的第一条语句前面停下来
        - `c`：continue，继续程序的运行,直到遇到下一个断点
        - `s`：step，执行下一条语句，如果该语句为函数调用，则进入函数执行其中的第一条语句
        - `n`：next，执行下一条语句，如果该语句为函数调用，不会进入函数内部执行
        - `k`：kill，终止正在调试的程序
        - `q`：退出
     1. 断点相关
        - `source gdb.init`：执行一系列gdb命令
        - `b`：break，设置断点，如`b main.go:17`
          1. `b 行号/函数名/文件名:函数名/文件名:行号`
          1. `b +偏移量/-偏移量`
          1. `break *地址`
          1. `tbreak`：只生效一次的断点，用法同break
          1. `rbreak regex`：函数名满足正则regex的话，就在内部开头打断点，如`rbreak admin_*`是admin开头
        - `d/clear`：delete，删除断点
        - `disable/enable`：停启用断点
        - `condition breakNum condition`：给指定断点添加触发条件
        - `b n [if cond]`：每次程序执行到n行时计算表达式cond的值，为true则暂停
     1. 查看
        - `x`：显示内容，`x/格式 地址`
          1. `x/3xw &r`：查看r内存数据，指针 8 + 长度 4
          1. `x/15xb 0x4212124`
          1. `x/i`：查看指令
        - `p xx`：print，打印变量值
          1. `p $len(s)`：获取对象长度
          1. `p $寄存器`：显示寄存器内容，如p $pc
          1. `p/x $寄存器`：十六进制显示寄存器内容
        - `f`：frame，查看栈帧。`f n`切换到编号为n的栈
        - `bt`：backtrace，查看函数调用信息(堆栈)
          1. `bt full`：不仅显示backtrace，还显示局部变量
          1. `bt n`：显示开头N个栈帧
          1. `bt full n`
        - `i`：info，描述程序状态，`i r`
          1. `info break/breakpoints`：查看所有断点
          1. `info reg`：显示寄存器内容
        - `disassemble`：查看反汇编
          1. `disassembler $pc,+length`：只显示关注的运行指针附近的汇编代码
        - `l main.main:8`：查看源代码
        - `disp`：display，跟踪查看某个变量，每次停下来都显示它的值
        - `watch`：表达式发生变化时暂停运行
          1. `awatch`：表达式被访问、改变时暂停执行
          1. `rwatch`：表达式被访问时暂停执行
        - `set`：改变变量的值
        - `generate-core-file`：生成内核转储文件
        - `dump binary memory FILE START STOP`：dump内存
   - 步骤
     1. 编译程序
        - g添加调试信息使得GDB可以调试
        - -O0不优化，优化等级：-O0~-O4
     1. 调试go
        - `go build -gcflags "-N -l" xx.go`
        - `gdb xx`
   - wiki
     1. DWARFv3：用于放在可执行文件中的表示调试信息的一种格式，DWARF格式，其他有stabs、COFF、IEEE695等，历史都非常悠久，伴随系统、计算机的发展
     1. 其他调试器
        - Remote Debugger：VS自带调试器
        - WinDbg：window下调试器
        - LLDB：xcode自带
        - lldb：mac自带
        - dlv：调试go
1. 框架
   - 异常使用规范
     1. 统一异常捕获
     1. 区分中间件异常、业务异常
   - 其他细节
     1. 返回码：stat、code、data、msg、trace_id
     1. 多版本开发，v1、v2，提高代码复用率
   - 配置方案
     1. yaml
        - 认识：YAML Ain't a Markup Language，用于跨不同语言和框架的配置文件，xml子集，01年开始，后缀.yaml或.yml
          1. 缩进和冒号为主要特征，复杂
        - 举例
            ```conf
            key: 
                child-key: value
                child-key2: value2
                
            a1: abc  # string
            a2: true # boolean
            b1: nil  # string
            b2: null # null
            b3: NULL # null
            b4: NuLL # string

            c:
                x: c.x
                y: c.y
            e:
                - x: e[0].x
                y: e[0].y
                - x: e[1].x
                y: e[1].y
            ```
     1. toml
        - 认识：Tom's Obvious，Minimal Language，目标成为最小的配置文件格式
          1. 语义精确，格式易于阅读
        - 特点
          1. 区分大小写
          1. 文件只能包含UTF-8编码的Unicode字符
          1. 空格表示制表符（0x09）或空格（0x20）
          1. 换行符表示LF（0x0A）或CRLF（0x0D0A）
        - 举例
            ```conf
            [server]
            name = "magic-lamp"
            port = "8000"
            mode = "test"
            debug = true

            [auth.ucenter]
            appID = ""
            secret = ""


            [f.A]
            x.y = "f.A.x.y"

            [f.B]
            x.y = """
            f.
                B.
                    x.
                        y
            """

            [f.C]
            points = [
                { x=1, y=1, z=0 },
                { x=2, y=4, z=0 },
                { x=3, y=9, z=0 },
            ]
            ```
     1. .env：dotenv项目，从.env文件加载配置到环境变量，认为配置要放在环境变量中，Ruby的
     1. .ini
     1. confd+etcd：用于做服务的配置中心
     1. k8s的配置中心
     1. 环境变量