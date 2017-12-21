### php
1. 认识：Hypertext Preprocessor/personal home pages/超文本预处理器，开源、用于产生动态网页的可嵌入HTML中的脚本语言，适合web开发
1. php模式：<?php ?>
1. php的学习层次
   - php技术深入：PHP字符串/数组/文件/高级特性/PHP运行原理
   - 编程思想：设计模式/并发/数据结构/算法
### 语法
1. 数据类型分类
   - 8种原始数据类型
     1. 标量：boolean、integer、float、string
     1. 复合：array、object
     1. 特殊：resource、null
   - 伪类型：mixed(所有)、number(int，float)、callback(V5.4)
1. 数据类型详解：php根据上下文在运行时决定变量的类型
   - bool：被认为false的： 0.0、"0"、[]
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
     1. 理解：由字符组成，每个字符等于一个字节，所以只支持256字符集，不支持Unicode。最大为2G
     1. 4种表达方式：单引号/双引号/heredoc/nowdoc——————待补充<<<结构即定界符
1. 变量
   - 普通变量
     1. 特点：区分大小写
     1. 赋值：$xx=xx，传址赋值：$xx=&$xx，可变变量：$$a
   - 超全局变量
     1. $_ENV
     1. $_REQUEST：包含GET、POST、COOKIE 和 FILE 的数据
     1. $_POST
     1. $_GET
     1. $_FILES
     1. $_COOKIE
     1. $_SESSION
   - 特殊保留变量
     1. $this
     1. $_SERVICE
1. 常量
   - 理解：常量只能是标量，一旦定义不能修改/删除
   - 系统常量：PHP_VERSION/PHP_OS/true/false
   - 定义
     1. define('name', 'value'); // 任意地方定义和访问，不能在类中
     1. const name='value'; // 类成员变量的定义，不能在条件语句中
   - 使用：直接用常量名，或者self::xxx
   - 检测：isset()/defined()
1. 运算符
   - 计算：%、++$a、$a--
   - 比较：==等于、===全等于，类型相同、!=或<>不等于
   - 赋值：=
   - 逻辑：与and/&&，或or/||，非!
   - 三元表达式：表达式 ? 值1 : 值2
   - 字符串连接符：.
1. 流程控制
   - 顺序自上而下执行，选择if，循环while/for/switch-case，break离开循环，continue跳过本次循环进入下次
### 面向对象
1. 理解
   - 面向过程：优点：用什么功能就编写什么函数，注重实现细节。 缺点：数据管理较混乱集中在函数方面
   - 面向对象：万物皆对象，将构成问题的事务分解到各个对象上，建立对象不为完成特定工作，而是为描述某事务在解决问题中的行为更符合人思维习惯，代码重用性高，可扩展性好。是一种对现实世界理解和抽象的方法，事物抽象成对象，关系抽象成类、继承
1. 特性
   - 封装：成员方法和成员属性封装到类中，限定成员访问权限，数据被保护在内部
   - 继承：类之间的关系
   - 多态：重新改变类的属性或行为，多态就是把子类对象赋值给父类引用，然后调用父类的方法，去执行子类覆盖父类的那个方法。php多态比较弱。其实就是对象类型的变量。把对象赋给变量
1. 组成
   - 接口：包含空的和public的成员方法和属性为常量的集合。空的方法需要继承类去实现。接口可实现多继承，抽象类和普通类都能实现接口，接口没有构造函数，抽象类可以定义构造函数，接口方法都是public，一个类可实现多接口，只能继承一个抽象类。用interface定义，implements实现，extends继承，避免继承的链式问题？啥叫继承的链式问题
   - 抽象类：具有抽象方法的类，抽象类不能实例化只能继承，里面可定义普通方法。抽象方法不能有主体即{}，子类必重写父类抽象方法，用abstract定义
   - 类：具有相同属性和方法的对象集合，只能实例化。类名首字母大写，一个文件可以写多个，一般就一个。类方法名和类名相同即自动执行，用__construct()代替
   - 对象
1. 关键字
   - static：修饰静态变量、静态方法
   - self/parent：对当前/父类的引用
   - final：标记类不能被继承、方法不能被覆写，不能用于变量
1. 对象：包含属性、方法，$this是当前对象的引用
1. 类
   - 魔术常量
     1. __FILE__       文件完整路径和文件名
     1. __CLASS__      类名
     1. __LINE__    
     1. __METHOD__     方法名
     1. __FUNCTION__    
     1. 魔术变量
   - 魔术方法————13个
    1. 类的载入
       - __autoload()：实例化一个对象时，如果对应的类不存在，则该方法被调用
    1. 对象本身的实例化/销毁
       - __construct()：构造方法，实例化类时自动被调用，执行类初始化工作。可传参，无返回值，存在父子级覆盖问题
       - __destruct()：析构方法，对象在内存中销毁时自动执行，无参。例如最后一个类的对象赋值NULL时触发
    1. 属性
       - __get/set()：拦截器：外部读取、设置属性时自动调用
       - __isset/unset()：检测/删除一个对象时调用
    1. 方法
       - __call()：调用不存在方法时自动调用，可以屏蔽错误
    1. 对象序列化操作
       - __sleep()：serialize之前调用，若对象比较大，想删减一点东东再序列化，可考虑一下此函数
       - __wakeup()：unserialize时被调用，做些对象的初始化工作
    1. 克隆/打印
       - __clone()：克隆对象时被调用。如：$t=new Test();$t1=clone $t; 
       - __toString()：打印一个对象的时被调用。如echo/print，必须有返回值
   - 静态类：速度快，效率高，直接加载到内存，省掉实例化类的空间，公用性强，使用时不生成对象就执行，不属于对象，不依赖对象调用，静态方法只能访问静态属性
    1. 静态变量：类变量/成员属性，属于类，只赋值一次，`static public $head=1;`
    1. 静态方法：类方法/成员方法，静态方法不能被非静态方法重写，`public  static function eat(){}`
   - 类的继承：让类能够具有可扩展性
#####概念
 1. 类——抽象出一个类
    - 类中定义常量：const
```
echo self::constant; // 类内使用self访问
echo MyClass::constant; // 类外使用类名访问
```
    - 类的强制继承————抽象
```
// 没有大括号和具体内容，加关键字的方法即抽象方法
abstract function fun1();
// 只要类中有一个抽象方法，这个类就要定义为抽象类
// 抽象类不能直接使用，也不能实例化使用，用于子类的模板。所有的抽象方法必须全部在子类实现，否则报错
abstract class demo {}
// 实现抽象类
interface example extends demo{}
```
    - 类的多重继承————接口
```
// 接口是特殊的抽象类，接口所有的方法都是抽象方法，不能声明变量，但是能声明const常量
interface demo{
            function method1();
            function method2();
}
// 实现接口
class example implements demo{}
// 只能继承一个类，但是能继承多个接口
class example extends class implements demo1, demo2{}
```
 1. __autoload()————自动载入类
```
function __autoload($classname){
    require_once $classname . '.php';
}
.
//MyClass1类不存在时，自动调用__autoload()函数，传入参数”MyClass1”
$obj = new MyClass1();
```
1. 内存中的体现
 - 内存在逻辑中的分类：
    1. 栈空间段：存储占用相同空间长度并且占用空间小的数据类型，可直接存取，存对象名称
    1. 堆空间段：不定长、体积大，不可直接存取，存对象。通过名称找对象
    1. 代码段
    1. 初使化静态段:存放静态属性和方法，类第一次被加载即放入，可被堆内存的对象所共享
```
$p1 = new Person();
$p2 = clone $p1;
```
    - __toString()：打印时调用
 1. __autoload()
    - __autoload()：自动实例化类，实例化未知类时自动调用，按需载入的作用
```
function __autoload(￥_className){
        require strtolower(￥_className) . 'class.php';
}
$class = new Unknow();
```
1. 关于类的函数
   - class_exists();
   - get_class();
   - get_class_methods();
   - interface_existd();
1. 反射API
   - 用来更加了解一个类，私有成员、保护成员、期望的参数
```
$reflector = new ReflectionClass('A');
```
### 应用
1. 会话控制：由于http协议的无状态性，使用cookie鉴别用户。`setcookie(name,value,time() + 3600,'/');`
1. 编解码
   - web传输
     1. urlencode转换-_.，空格转为+。rawencode把空格转为%20。urlencode转换字符，http_build_query转换数组
     1. urldecode解码
   - web展示
     1. strip_tags：去掉所有HTML/PHP的标记字符
     1. htmlspecialchars：特殊字符转成实体，只转4个:[" & < >]，如"(双引号)转成&quot;。htmlentities:将所有字符转成html格式
     1. addslashes/stripslashes：addslashes是使用反斜线引用字符串，数据库操作的必要步骤，给'、"、\、NULL字符加反斜线，stripslashes是去除反斜线，有两个就留一个，一个就去除
   - base64_encode：可用于邮件传输，但是处理后有/ + =等危险字符，url编码中+代表空格
   - json：默认将中文转为unicode，使用`json_encode($message, JSON_UNESCAPED_UNICODE);`保留中文
1. 加密
   sha1：用于校验文件完整性，是否被篡改，可生成一个160位校验值，不可逆
1. 正则
   - 匹配手机号：`preg_match("/^(1([34578]))\d{9}$/", $mobile)`
   - 4到6位数字：`preg_match("/^\d{4,6}$/", $code)`
1. 文件/目录处理
### 规范
1. 命名空间
### 运维
1. PHP安装
1. PHP配置：修改php.ini
   - php标签
   1. 只使用<?php，无结束符，防止输出空格。也可以用`<script language="php"></script>`
