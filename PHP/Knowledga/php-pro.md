### Opcache
1. 认识：将opcode存储到共享内存中来提升性能，省去了每次加载和解析php脚本的开销，同时还应用了一些代码优化模式使之更快。还有WinCache
1. 方法
   - opcache_get_status()：状态信息
   - opcache_get_configuration()：获取配置
   - opcache_is_script_cached()：判断是否缓存

   - opcache_compile_file()：编译并缓存php脚本
   - opcache_invalidate()：废除缓存
   - opcache_reset()：重置所有缓存内容
1. 运维
   - `opcache.enable`：默认关闭，开启后需重启php
   - `opcache.enable_file_override`：用于file_exists、is_file、is_readable的缓存
   - `opcache.validate_timestamps`：每隔`opcache.revalidate_freq`秒检查脚本是否更新，设置2~5合适，高了更新不及时，性能提升有限
1. 其他优化器：APC、xcache、eAccelerator
### Swoole
1. 理解：面向生产环境的php异步网络通信引擎，可以编写高性能的异步并发TCP/UDP/Unix Socket/HTTP/WebSocket服务
   - 纯C编写，提供php语言的异步多线程服务器
   - 异步IO，事件驱动的异步编程模式
   - 异步TCP/UDP网络客户端，异步MySQL，异步Redis，数据库连接池，AsyncTask，消息队列，毫秒定时器，异步文件读写，异步DNS查询。Swoole内置了Http/WebSocket服务器端/客户端、Http2.0服务器端
   - 为PHP多进程的模式设计了多个并发数据结构和IPC通信机制，大大简化多进程并发编程的工作。其中包括了并发原子计数器，并发HashTable，Channel，Lock，进程间通信IPC等特性
   - 支持异步/同步/协程，v2.0实现协程，可以使用完全同步的代码实现异步程序，底层自动进行协程调度，实现异步
   - 支持SSL/TLS加密
   - 包含分配线程、心跳线程的reator的epoll模型后边连接多个由manager进程管理的worker进程，用reator接受连接，worker进程处理，即异步+同步，并发+php处理
1. 观念：swoole在服务端只编译一次，一直存于内存，使用swoole来编写常规项目时，需要将自己置身于第三方上帝的角色，而非访问者的角色来编写并阅读自己的代码。PHP入门时就必须要掌握的session，对于运用了swoole扩展的PHP程序而言，完全可以用一个变量来替换
1. 历史
   - 1.6.2：异步支持，像node
   - 2.0：内置协程+通道，代替异步回调
   - 4.0：重构协程内核
### PHPUnit
1. 认识：xUnit的体系结构的面向php的php开发的单元测试框架，源于SUnit
   - 特点
     1. 命令可以操控测试脚本
     1. 测试性能
     1. 测试代码覆盖率
     1. 自动化的更新测试用例的参数数据
     1. 各种格式的日志
   - annotation：标注
     1. `@test`：标记为测试方法
     1. `@depends`：标记依赖谁，自动执行依赖
     1. `@assert`：框架生成器，搭配--skeleton
     1. `@dataProvider`：标记数据供给方
     1. `@expectedException...`：异常标记，还有另外3个
     1. `@after/before`
     1. `@covers`
   - fixture：基境
     1. 理解：设置成某个已知的状态称为基境
     1. setUp()：运行方法前运行，用于设置环境
     1. tearDown()：运行方法后运行
   - 方面
     1. 测试类建立
        - XxxTest：测试类
        - testXxx：测试方法
     1. assert：断言
        - assertEquals
        - ssertArrayHasKey
     1. Stubs、Mock
        - 理解：替身，使用替身的实践方法称为上桩；保证对象预期行为必会发生的实践方法为模仿。可以对web请求、文件系统(vfsStream)进行模仿
        - 方法：`createMock->method->willReturn`
        - 方法：`getMockBuilder->with->expects->attach`
        - Prophecy：极为自我却又非常强大灵活的PHP对象模仿框架，PHPUnit对用Prophecy建立测试替身提供了内建支持
     1. DBUnit
        - 数据库查询：`$queryTable = $this->getConnection()->createQueryTable('guestbook', 'SELECT * FROM guestbook');`
     1. 流程控制
        - 跳过测试：`markTestSkipped`，或者`@requires extension mysqli`
     1. 错误和异常
        - expectException
        - expectExceptionCode
        - expectExceptionMessage
        - expectExceptionMessageRegExp
     1. 代码覆盖率
     1. Logging：日志记录
     1. 扩展
        - 自定义断言
        - 测试监听器
        - 测试修饰器
   - 运行
     1. phpunit：--include-path 指定路径，--configuration 指定配置文件
     1. xml配置：
        - 理解：自动载入`phpunit.xml`配置文件
        - demo
            ```xml
            <phpunit bootstrap="vendor/autoload.php">
            <testsuites>
                <testsuite name="money">
                    <directory>tests</directory>
                    <file>ControllerNewsTest.php</file>
                </testsuite>
            </testsuites>
            <!--配合@group使用，指定要测试的分类-->
            <groups>
                <include>
                    <group>news</group>
                    <group>base</group>
                </include>
            </groups>
            </phpunit>
            ```
1. 代码测试
   - 分类
     1. 功能测试：http、大块代码，如Codeception、Selenium、Mink
     1. 单元测试：对软件的基本单元进行测试，监控其行为和返回值。相互隔离、单一功能。对单独的代码对象进行测试的过程，比如对函数、类、方法进行测试。单元测试可以使用任意一段已经写好的测试代码，单元测试框架提供了一系列共同、有用的功能来帮助人们编写自动化的检测单元，报告测试结果和代码覆盖率。就是覆盖被测方法所有预期行为的测试，提升开发者对代码的自信心
   - 原则
     1. 测试调用的方式嵌入到框架中，不同框架测试方法不同
     1. 单元测试需要载入类，功能测试直接访问地址
     1. 正确的单元测试就是确保测试代码准确隔离（isolate）了待测代码，如果你测试一个类，那么测试代码中就应该避免出现对于其他类的依赖
     1. 即使方法的返回结果的确要依赖前置条件才能正确输出，单元测试本身也不应该浪费精力在塑造这些前置条件上，而是应该把重点放在测试和保障该方法的返回结果是预期的并且在可预见的各种边缘条件下该方法的返回结果都不会超出预期之上。可以伪造（后面会讲）它们而不是去调用真正生成它们的其他代码，只有这样才能保证“隔离性”，才能称的上是单元测试
     1. 只写必要的测试，只写关键的测试
     1. 测试代码应当尽可能简短精确
        - 你不希望因为生产代码的小变更而需要对测试代码进行数量可观的修改
        - 你希望在哪怕好几个月以后也能轻松地阅读并理解测试代码
     1. 需要编写的是那些觉得能运作但却失败或觉得必将失败但却成功的测试。另外一种思考方式是从成本/收益的关系上去考量。需要编写的是能够给出反馈信息的测试。
1. wiki
   - 具体操作
     1. get/post()：发出http请求
     1. assertXxx()：判断
     1. Array::get()
     1. seeJson/seeJsonEquals()：是否精确的json
     1. actingAs()：绑定用户
     1. seeInDatabase
     1. DatabaseMigrations：每次测试后回滚数据库并在下次测试前重新迁移
     1. DatabaseTransactions：使用事务
     1. 反射
     1. 上桩：继承类并覆盖方法、值，模拟数据对象
   - 代码覆盖算法：大致上对比准确性：路径覆盖 > 条件覆盖 ~= 判定覆盖 > 语句覆盖
   - 其他框架：JUnit
### 协程
1. 理解：协作式的用户态"线程"，任务调度器，在用户程序中实现了协作式任务调度，是在同一进程或线程中运行多个任务，将任务切换的部分工作从内核转移到应用层
   - php的协程是generator，是stackless协程，需要自己实现调度逻辑。是比js的async/await还要不方便的特性，go是stackfull协程。运行时自动调度，完全是用同步的方式来实现异步效果
   - async/await和yielf from原理一样，只是方便理解、代码更简洁，php没有async、await
1. 特点
   - 以写同步代码的方式写出异步代码般的效率
   - 进程调度可以很好的控制资源分配，线程调度让进程内部不因某个操作阻塞而整体阻塞。协程则是在用户态来优化程序，让程序员以写同步代码的方式写出异步代码般的效率
   - 为应用层实现多任务提供了工具
   - 协程不允许多任务同时执行，非抢占式多任务处理，由协程主动交出控制权
   - 协程需要自己写任务管理器，以及任务调度器
   - 减轻了OS处理零散任务和轻量级任务的负担
1. 优势
   - 内存消耗小：线程8m的内存申请量，协程2k
   - 上下文切换快：不经过内核
1. php7：迭代器，可以有一个最终返回值，也可以通过yield from的新语法进入一个另外一个生成器中。生成器的两个新特性（return 和 yield from）可以组合
1. 实现：v5.5加入，使用迭代生成器和yield关键字
    ```php
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
1. 实现生产者、消费者自协调
   - 生产者通过调度生成器去调节消费者的启动时机，消费者执行完了再去启动生产者，二者用send通信
1. 生成器协程
   - 认识：将生成器封装成生成器协程，然后用生成器协调调度器调度
   - 组成
     1. 生成器协程：用生成器协程适配器
     1. 事件循环协程
     1. 协程调度器
   - 特点
     1. 生成器和列表内存模型怎么不一样
     1. 可以大幅降低内存使用，并且性能更好，列表是线性增长，生成器只有自身的内存
     1. 生成器可以实现延时计算，这个延时指的是一直就没停，只是切出去了，和函数不一样，函数执行一次就完事了，没有延时的概念，就是
        ```
        while true
            aa = yield
        ```
        然后外边不时的send一下，就算延时了
     1. yield在函数里会把函数变为生成器type(func())，须加()，yield表现就是切出，“暂停”
     1. yield from可以在一个生成器里迭代另一个生成器，就可以切换到别的生成器迭代了
     1. next控制生成器进入下一个，next可以激活生成器，或者用send(None)激活
     1. send是给生成器送参数，aa = yield，那么send后就是aa的值
     1. StopIteration异常，表示生成器已经结束，可以用try捕获
     1. 装饰器：统一的行为放里边，简化函数，如@coroutine
   - 步骤：通过装饰器将生成器交给调度器运行
     1. 将socket封装一下，变成普通的io，用协程调度
1. 事件驱动协程调度器
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
    - PSR-11：（接口相关的吧）
1. 注释书写参考
   - @access
   - @param  string|array
   - @static
   - @return  void|
   - @desc
   - @example
   - @version
### SPL
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
1. 消息队列：gearman
1. 守护进程
