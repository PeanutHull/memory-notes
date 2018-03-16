### Swoole
### ThinkPHP
1. 结构
   - URL模式：普通(get参数形式)、PATHINFO、REWRITE、兼容(不支持PATHINFO)。优点排序：REWRITE>PATHINFO>普通
   - MVC
   - 视图：模板和模板引擎
   - 控制器：核心控制器、逻辑控制器
   - 行为：钩子，标签位
   - 导入文件：1命名空间的自动载入，2impost的手动载入
   - 项目编译缓冲：第一次加载文件并合并到一个，下次载入编译后的
1. 路由
   - 分类
     1. 全局路由：需要在路由地址加模块名，在全局配置中配置
     1. 模块路由：在模块中配置
   - 路由表达式：正则路由、规则路由、静态路由(URL映射)、闭包支持
1. 使用
   - 参数：I('id');
   - 模块：D('Admin/');
   - 读写分离：自动判断方法写入或读，原生写操作必须用execute，读必须用query
   - 双大C嵌套可以实现主配置文件定义应用模式，写出很多副配置，修改主配置文件就可以切换模式。如:C(C('WECHAT_MODEL'));
   - 查询缓冲：$Model->cache('cache_name')->select();
   - display的原理就是声明正确的header，然后echo就行
### Yii
1. 理解：Yes It Is，易，极致简单，不断演变，快速、安全、专业、高性能、自带丰富功能。基于组件和事件驱动编程模式
1. 功能
   - MVC
   - DAO(数据库访问对象)/ActiveRecord
   - 身份验证和RBAC
   - 整合jQuery
   - 表单输入和验证：有验证器、辅助方法和部件
   - web2.0部件：自动完成输入字段，TreeView
   - 国际化（I18N）和本地化（L10N）
   - 分层缓存方案： 数据缓存，页面缓存，片段缓存和动态内容，灵活存储介质
   - 错误处理和日志记录：日志信息分类，过滤并分配到不同的位置
   - 安全：XSS跨站攻击、CSRF跨站请求伪造、Cookie篡改预防
   - GII代码生成
1. Yii2.0对比1.1
   - 命名空间
   - 匿名函数
   - 数组短语法形式
   - 使用<?=取代echo
   - 标准php库(SPL)库和接口
   - 延迟静态绑定
   - php标准日期时间
1. Yii框架的应用结构————MVC/入口脚本/应用/应用组件/模块/过滤器/小部件
   - MVC的设计模式
     1. 模型：数据、业务逻辑和规则
     1. 控制器：接受输入，转换为模型和视图的命令
     1. 视图：模型的输出
   - 入口脚本：定义全局常量/注册Composer自动加载器/包含YII类文件/加载应用配置/创建应用并配置/调用yii/base/Application::run()处理请求
   - 应用主体
    1. 解释：只包含一个应用主体，入口脚本创建并通过 Yii::$app全局可访问。分为yii/web/Application和yii/console/Application
    1. 属性
      - 必要属性 yii/base/Application::id/basePath
      - 重要属性，应用组件/语言/配置/布局/视图地址 yii/base/Application::aliases/controllerMap/components/language/params/layout/layoutPath/viewPath/vendorPath
   - 应用组件
     1. 解释：应用主体是服务定位器，部署很多应用组件来处理请求。如urlManager处理路由到控制器的路由组件，db组件。第一次使用会创建实例，后续无需创建
     1. 访问组件：`Yii::$app->componentID`
     1. 核心应用组件：request组件/db数据库连接/Session/UrlManager
1. 关键概念
   - 对象
     1. yii/base/Object
     1. 解释：轻量级的基类，getters、setters定义对象属性，用不到事件或行为，应使用yii/base/Object类作为基类，通常表示基本的数据结构，仅包含属性
     1. 统一的对象配置方法，所有Object的子类(包括Component)如果需要构造方法，用下面的
    ```php
    class MyClass extends YII/base/Object{
        public function __construct($param1, $param2, $config = [])
        {
            // ... 配置生效前的初始化过程
            parent::__construct($config);
        }
        public function init()
        {
            parent::init();
            // ... 配置生效后的初始化过程
        }
    }
    ```
   - 组件
     1. yii/base/Component
     1. 解释：继承自yii/base/Object，进一步支持事件、行为，是yii应用的基石
     1. 三个区分它和其他类的功能，其中单独使用或彼此配合，属性/事件/行为
        - 属性：类定义的一部分，用来表现一个实例的状态，支持getter和setter方法来定义属性
        - 事件：将自定义代码“注入”到现有代码，附加自定义代码到某个事件
        ```php
        // 用 yii/base/Component::trigger() 方法来触发相关事件
        $event = new YII/base/Event;
        $component->trigger($eventName, $event);
        // 给事件附加一个事件事件处理器，使用 yii/base/Component::on() 方法
        $component->on($eventName, $handler);
        // 解除事件处理器，使用 off 方法：
        $component->off($eventName, $handler);
        ```
        - 行为：行为是yii/base/Behavior或其子类的实例。当行为附加到组件后，它将“注入”它的方法和属性到组件，然后可以像访问组件内定义的方法和属性一样访问它们。类注入、对象注入
          1. 定义行为
        ```php
        // 继承yii/base/Behavior或其子类
        class MyBehavior extends Behavior{}
        ```
          1. 处理事件
        ```php
        // 让行为响应对应组件的事件触发，就应覆写 yii/base/Behavior::events() 方法
        public function events(){
            return [
                ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate',
            ];
        }
        public function beforeValidate($event){}
        ```
   - 配置：配置格式、初始化组件/应用、其他配置
   - 类自动加载
     1. 高性能、完美支持PSR-4标准
     1. 使用自动加载器
       - 规则：必须置于命名空间下、每个类保存为单独文件，其完整路径可用算法算出来
       - 途径：类映射表、composer
   - 依赖注入
    1. 解释：程序=算法+数据结构。依赖注入就是剥离算法和数据结构之间在方法中的强耦合的关系。即将定义使用何种查询结构交给外面的逻辑，通过参数/构造函数传入，扩展应用的使用范围。数据结构也可以是其他的类，他们有共同的方法，但是作用不同
   - 依赖注入————容器
    1. 解释：定义并解决依赖关系。依赖注入容器就是一个对象，知道怎么初始化并配置对象以及依赖的对象，即DI容器。
    1. 支持的注入方法
      - 构造方法注入
        ```php
        use yii/di/Container;                                  // 使用容器类
        class Foo{
            public function __construct(Bar $bar){}
        }
        $foo = $container->set('Bar', 'mySelfBar');            // 指定容器使用的加载类，指明命名空间，指明使用哪个类
        $foo = $container->get('Foo');                         // 使用容器的get方法自动获得需要实例化的类
        // 上面的代码等价于：
        $bar = new Bar;
        $foo = new Foo($bar);
        ```
      - Setter和属性注入、PHP回调注入
   - 依赖注入————服务定位器
     1. 解释：配置服务参数。服务定位器是一个了解如何提供各种应用所需的服务（或组件）的对象。在服务定位器中，每个组件都只有一个单独的实例，并通过ID 唯一地标识。用这个 ID 就能从服务定位器中得到这个组件
        ```php
        use yii/di/ServiceLocator
        $sl = new ServiceLocator;                      // 汽车和什么司机的问题
        $sl->set('car',[                               // 指明使用的类
            'class' => '/Car',
        ]);
        YII::$container->set('/Bar', '/mySelfBar');   // 或者使用容器指定依赖，此项可无
        $car = $sl->get('car');                       // 获得汽车的实例
        $car->run();
        ```
     1. yii服务定位器的使用
        ```php
        'car'    => [                                   // 在web.php中的components定义，即注册组件，在系统初始化时加载
            'class' => '/Car',
        ]
        YII::$container->set('/Bar', '/mySelfBar');     // 当使用属性方式访问某一个属性，会让容器帮助加载，自动解决依赖的关系
        YII::$app->car->run();
        ```
     1. 原理：服务定位器调用容器的方法去实例化类
   - 路径别名：以 `@` 符号开头，路径别名也和类的命名空间密切相关。建议给每一个根命名空间定义一个路径别名，从而无须额外配置，便可启动 Yii 的类自动加载机制
1. 模型
   - 模型基类：yii/base/Model，普通模型的父类并与数据表无关
   - 查询生成器(Query Builder)
   - 高级模型：活动记录(Active Record)
1. 控制器
   - 操作过滤器：通过行为(behavior)来实现，绑定到控制器通过如下代码
    ```php
    public function behaviors() {
        return [
            'access' => [
                'class' => 'yii/filters/AccessControl',
                'rules' => [
                    ['allow' => true, 'actions' => ['admin'], 'roles' => ['@']],
                ],
            ],
        ];
    }
    ```
   - 过滤器
    1. 解释：本质是一类特殊的行为
    1. 控制器中过滤器
    ```php
    // 覆盖 yii/base/Controller::behaviors()方法申明过滤器
    public function behaviors(){
        return [
            [
                'class' => 'yii/filters/HttpCache',
                'only' => ['index', 'view'],
                'lastModified' => function ($action, $params) {
                    $q = new YII/db/Query();
                    return $q->from('user')->max('updated_at');
                },
            ],
        ];
    }
    ```
     1. 单独过滤器
        ```php
        // 创建过滤器
        继承 yii/base/ActionFilter 类
        覆盖 
        yii/base/ActionFilter::beforeAction()
        和/或
        yii/base/ActionFilter::afterAction()
        方法来创建动作的过滤器
        ```
     1. 核心过滤器
        ```php
        // 在yii/filters命名空间下
        1.访问控制：yii/filters/AccessControl————————授权章节
        2.认证方法：yii/filters/auth/HttpBasicAuth——————认证章节，通常在RESTful中，基于HTTP Basic Auth或OAuth 2
        3.响应内容/格式：yii/filters/ContentNegotiator，检查 GET 参数和 Accept HTTP头部来决定响应内容格式和语言
        4.缓冲：yii/filters/HttpCache/PageCache
        5.速率限制：yii/filters/VerbFilter
        6.跨域资源共享：yii/filters/Cors
        ```
1. 视图
   - $this指向yii/web/View 的实例，想要在视图中访问一个控制器或小部件，可以使用$this->context
   - 任何地方都可通过表达式 `Yii::$app->view` 访问yii/base/View应用组件
   - 前端资源(Assets)：资源包(Asset Bundle)
     1. 解释：一个资源包是一个目录下的资源文件(js/css/picture)集合，每个资源包表示为一个类，继承自yii/web/AssetBundle，注册后即可使用，会自动使用包内的资源
     1. 注册资源包：yii/web/AssetBundle::register()
   - 表单，基于yii/widgets/ActiveForm
    ```php
    <?php $form = yii/widgets/ActiveForm::begin(); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="form-group">
                <?= Html::submitButton('Login') ?>
            </div>
    <?php yii/widgets/ActiveForm::end(); ?>
    ```
   - 渲染另一个视图：`<?= $this->render('_overview') ?>`
   - 视图事件，在不同视图处理前触发：EVENT_BEFORE_RENDER/EVENT_END_BODY
   - 小部件
     1. 解释：视图中可重用单元，使用面向对象创建，复杂/可配置的单元
     1. 基类： yii/base/Widget
     1. 方法：yii/base/Widget::begin()，yii/base/Widget::end() 和 yii/base/Widget::widget()
     1. 最佳实践：是可重用的视图代码，遵循mvc模式，逻辑代码在小部件类中，展示内容在视图中，小部件类依赖外部资源(js/css)，可以用资源包来解决
   - 资源包
     1. 解释：放在一个目录下的资源集合，
     1. 定义：继承yii/web/AssetBundle的类
     1. 资源路径、资源依赖、Bower和NPM资源
     1. 使用
        ```php
        use app/assets/AppAsset;
        AppAsset::register($this);  // $this 代表视图对象
        ```
1. 安全
   - 认证
     1. 解释鉴定用户身份，通常一个标示符、一个加密令牌，来鉴定身份，是登录功能的基础
     1. 适用无状态RESTful和保持登录的身份认证，获取用户校验token、cookies，从而检验用户身份
   - 授权
     1. 分类：存取控制过滤器(ACF)、基于角色的存取控制(RBAC)
     1. ACF：使用yii/filters/AccessControl类来实现简单授权方法，即检查action
     1. RBAC:集中式存取控制。步骤：建立授权数据/根据授权数据在需要的地方执行检查
1. 控制台应用(Console Application)
   - 解释：创建网站后台处理的任务。类似yii的web程序，由yiy/console/Controller组成，
   - 使用：参数根据 yii/console/Controller::options() 的声明来解析，`yii <route> [arguments] [options]`
1. 国际化：消息翻译由 `i18n` 应用组件执行
1. 助手类
 - yii/helpers/Html
 - yii/helpers/ArrayHelper
 - yii/helpers/StringHelper
 - yii/helpers/FileHelper
 - yii/helpers/Json
### Laravel
1. 介绍：提供常用组件，简化程序开发，让开发更有乐趣
1. laravel哲学
   - 富有表达性、简洁语法的应用框架，开发过程应该是愉悦并且有创造性的，快乐的开发者才能创造最棒的代码
   - laravel易于理解且强大，杰出的IoC、数据库迁移工具、紧密集成的单元测试
1. 路由
   - 路由参数、路由别名、路由群组
1. 视图
   - 输出视图用`return view('member/info', []);`
   - 文件名xx.blade.php，模板引擎Blade，不限制使用原生php
   - 输出变量用{{}}
1. 模型
   - DB facade(原始查找)
   - 查询构造器：提供方便、流畅的接口，建立/执行数据库操作方法。使用PDO参数绑定，免于SQL注入，参数不需转义
   - Eloquent ORM：优美、简洁的ActiveRecord实现，firstOrCreate/firstOrNew
1. 中间件：过滤http请求，在请求到达最终动作之前对请求进行过滤和处理。如Auth中间件身份校验地址导向，CORS为离开程序的响应加标头。用于日志\维护\CSRF保护\身份验证等。有前置/后置中间件
1. 队列
 - 理解：将用框架处理的东西，放到一个队列里，延迟执行
    ```php
    Queue::push('SendEmail', array('message' => $message)); // 添加队列，指定SendEmail的jobs之类执行，fire为默认执行方法 
    Queue::connection('redis')->later($later, 'ParserQuestion', ['question_str' => $value]); // 指定连接队列，延迟执行
    class ParserQuestion extends BaseJob {}// 定义解决队列问题的方法，在app/jobs目录下，fire为默认执行方法 
    ```
1. Artisan命令行工具：基于Symfony Console开发。新增app/commands文件夹下继承Command即可
    ```php
    php artisan list                                // 显示命令列表
    php artisan *** --env=zzg                       // 指定配置环境
    php artisan config:cache                        // 缓冲配置信息到文件，更快
    php artisan read:word                           // 生成队列
    php artisan queue:work redis                    // 消费队列
    php artisan queue:work connection --daemon      // 常驻队列
    php artisan dump-autoload                       // 重新载入类
    ```
1. 配置
   - app/config下配置多文件夹界定不同环境配置，修改.env即可
    ```php
    php artisan env --env=_zzg
    fastcgi_param  ENV '_zzg';      // 修改nginx配置
    ```
   - 使用`Config::get('app.aa')`或`Config::get('question.aa')`获取对应配置，配置都在超全局变量$_ENV中
1. 日志：`app/storage/logs`，查看日志`grep "ERROR" laravel.log`

1. Contracts：契约，定义框架核心服务的接口
1. Facade：门面，模拟一个类，提供静态魔术方法`__callStatic`，将该静态方法映射到真正的方法上
1. 服务容器：IoC容器，是laravel的核心，该容器提供了整个框架中的一系列服务
1. 服务提供者
   - 一个类能够被提取，要先被注册，绑定到容器，提供服务并绑定服务至容器的东西就是服务提供者
   - 意义：是启动laravel的真正关键，自己和所有的laravel都是通过服务提供者启动的。启动指注册事物，包括注册服务容器绑定/事件侦听器/中间件/路由，有些属于延迟注册。应用程序创建————服务提供者注册————请求转义至已启动的应用程序。默认的服务提供者在 `app\Providers` 目录下，config/app.php的providers数组即是
   - 组成：`register`（注册） 和 `boot`（引导、初始化）
1. 5.X启动过程
   - 单入口文件
   - 加载Composer自动加载器，获取bootstrap\app.php中的laravel实例
   - laravel第一步创建 应用程序 / 服务容器 的实例
   - 流向http核心 app/Http/Kernel.php，核心加载行为之一————服务提供者，调用所有提供者的 `register` 方法，注册完后，调用 `boot` 方法
   - 设置错误处理/日志记录/环境监测
   - 转移到路由器进行分配，运行 `中间件`，再到路由/控制器

1. 运维
   - 安装：`composer create-project laravel/laravel your-project-name --prefer-dist "5.1.*"`
   - 目录
     1. app 应用程序核心代码
        - console 全部的Artisan命令
        - Jobs 放置应用程序可队列的任务
        - Events 事件类
        - Listeners 事件的处理类，如UserRegistered可由SendWelcomeEmail侦听
        - Exceptions 应用程序的异常处理进程，
        - Providers
     1. bootstrap 框架启动和自动加载设置的文件，cache 包含启动性能优化的文件
     1. public 前端控制器和资源文件
     1. resource 视图、原始的资源文件(LESS/SASS/CoffeeScript)、语言包
     1. storage 编译后的blade模板，基于文件的session，文件缓冲等其他文件。包含app存储应用程序使用的文件/framework保存框架生成的文件和缓冲/logs
