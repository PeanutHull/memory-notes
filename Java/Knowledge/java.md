### Java
1. Java体系
   - Java SE：java平台标准版。包含最普遍的类库，针对普通的java程序
   - Java EE：java平台企业版。是类库最多、针对web应用的一个规范
   - Java ME：java平台微型版
1. 认识
   - 多平台运行，静态语言，预先编译，解释执行
   - 纯粹的面向对象特性，语法简单，强类型，传承于C++，不使用指针而是引用，异常处理，垃圾自动回收，安全检查机制、命名空间等
   - 高性能，多线程
   - 在企业，互联网，嵌入式都有广泛的应用
1. 开始
    ```Java
    public class HelloWorld {
        public static void main(String[] args) {
            System.out.println("Hello World");
        }
    }
    ```
### 语法
1. 数据类型
   - 分类：基本类型、引用类型
   - 基本类型
     1. 分类
        - 数值型
          1. 整数：byte, short, int, long
          1. 浮点数：float, double
        - 字符型：char
        - 布尔型：boolean
     1. 基本类型详解：
        - byte：8位有符号二进制补码形式的整数。-128~127——2的7次方。默认0。
        - short：16位有符号二进制补码形式的整数。-32768~32767——2的15次方。默认0。
        - int：32位有符号二进制补码形式的整数。4字节。2的31次方范围(-2147483648~2147483647十亿级)。默认0。
        - long：64位有符号二进制补码形式的整数。2的63次方范围(百亿亿级)。默认0L。表示形式为 Long b = -200000L。
        - float：32位单精度浮点型，不能用于货币。默认0.0f。如 float point = 15.1f;
        - double：64位双精度浮点型，不能用于货币。默认0.0d。如 double d1 = 123.4。
        - char：单一16位Unicode字符，如：`char name = 'A'`，最小值是’\u0000’（即为0）
        - boolean：布尔型，1字节。默认false
     1. 类型转换
        - 原则
          1. 整形、常量、字符可以混合运算，但须转为同一类型。
          1. 低到高排列：byte,short,char—> int —> long—> float —> double
          1. bool不能转换
          1. 对象类型不能改为不相关类
          1. 容量大转小时必须使用强制转换。转换可能导致溢出或损失精度
          1. int不能转char
        - 自动类型转换：容量小的转大的
        - 强制类型转换：数据截断后溢出，转换条件是数据类型必须是兼容的
        ```Java
        double num = 6.66;
        int avg = (int) num;
        // 使用instanceof判断是否能够强制转换
        if(animal instanceof Cat) {}
        ```
   - 引用类型：类似C/C++的指针， 其指向一个类/对象/数组
    ```Java
    Site site = new Site("Runoob")
    ```
   - 区别：基本类型存储的是数据本身，引用类型存储数据空间地址
1. 变量
   - 理解：使用前必须先声明类型
   - 定义
    ```Java
    int a;
    a = 1;          // 先声明，后赋值
    int a = 1;      // 声明并赋值
    ```
   - 分类
     1. 全局变量：即成员变量，或叫实例变量，类中共享的变量
     1. 局部变量：方法中定义的变量，一个方法中局部变量不能重名，局部比全局的优先级高，java会给全局变量定义初始值，不会给局部定义
     1. 类变量：即静态变量。在构造方法和语句块之外。属于类，所有实现的对象共享一份
        ```Java
        // 声明静态变量
        protected static String name = "haha";
        // 声明静态常量
        public static final String A = "666";
        // 使用
        类名.name;(类中)/name;(类外)
        ```
     1. 引用变量：指向对象的变量叫引用变量，这些变量声明时被指定为一个特定类型，一旦声明不能改变类型，默认null
1. 常量：一旦定义，不能修改，通常大写，可提高程序可维护性，避免命名不规范等问题，使用final定义 `final String LOVE = "imooc";`
1. 符号
   - 运算符
     1. 分类
        - 算术：+-*/  -  %  ++  --
        - 比较：>  <  ><=  ==  !=
        - 逻辑：&&  ||  !
        - 赋值：=  +-*/%=  &|^=  <<=(x=x<<y)  <<<=  <<=
        - 字符串连接：+
        - 条件： ? :
        - 位：&   |   ~(非)   ^(异或)   ~(逐位取反)   <<(按位左移固定位数)   >>   >>>("无符号"右移运算)   <<<
        - 强制类型转换：()
        - instanceof：检测对象是否是一个类实例
     1. 特性
        - 自增/减只能用于变量，位置前后作用不同
        - 括号优先级最高
        - 只有==和!=两个比较运算符两边可以是引用类型，其他的两边都是数值型
        - ^异或：有且仅有一个才行。java有短路执行特性，即只执行一部分
   - 修饰符
     1. 访问：用于修饰类、方法和变量，只能往更宽泛的权限继承，可以没有，默认为default
        - private：本类可见
        - default：其他类和子类不可见
        - protected：其他类不可见
        - public：所有类可见
     1. 其他
        - static：创建类变量和类方法
        - interface：创建接口
        - abstract：创建抽象类和抽象方法
        - final：修饰的类不能被继承，修饰的方法不能被重载，修饰的变量为常量不能修改
        - strictfp：浮点数使用严格规则
        - transient：对象变量持久化跳过修饰符，只修饰变量，不修饰方法和类。`public transient int limit = 1;`
        - synchronized：同一时间只能被一个线程访问 `public synchronized void showDetails(){}`
        - volatile：每次被线程访问，强制从共享内存中重新读取该成员变量的值。当成员变量改变时强制线程将变化值写回内存。保证不同线程看到同一变量的值
        - native：表示方法用非java代码实现
        - assert：断言，判断条件是否满足，一种调试方法
   - 标识符：用于定义名字，大小写敏感，由字母/数字/下划线/$组成，数字不能开头，类首字母大写和驼峰法
   - 注释：// 单行注释、/* */文档注释、/* * */多行注释
     1. 注释标签：提取Java注释：`javadoc -d doc hello.java`
        - 基本说明：@author、@version、@link、@see 参考
        - 方法说明：@param、@serial 序列化属性、@exception、@return
1. 流程控制
   - 判断
    ```Java
    if() {               // if
    }else if(){
    }else{
    }
    switch() {  ·        // switch
        case value1:
        case value2:
        default:
    }
    ```
   - 循环
    ```Java
    for(int i=1,j=1;i <= 1 && j != 0;i++,j--) {}    // for
    while(i <= 1) {                                 // while
        i++;
    }
    do {                                            // do
        i++;
    } while(i <= 100);
    break;continue;                                 // 流程控制
    ```
1. 方法
   - 参数：方法参数的传递永远是传值，基本数据类型值就是值，引用数据类型值是对象的引用，而不是对象本身，说明方法内修改对象是生效的
   - 可变参数：Varargs，jdk1.5，用于参数个数不确定，类型确定的情况
     1. 定义
        ```Java
        public static void printMax(int x, double... y) {}
        public static void printMax(new Class[]int.class, int.class{}) {}       // 数组形式
        ```
     1. 特点
        - 只能出现在参数列表的最后
        - 位于变量类型和变量名之间，前后有无空格都可以
        - 调用可变参数的方法时，编译器为该可变参数隐含创建一个数组，在方法体中以数组的形式访问
1. 代码块
   - 执行顺序：静态代码块>mian方法>构造代码块>构造方法
   - 分类
     1. 普通代码块：就是普通方法里边的大括号
     1. 构造代码块：类中定义，无任何修饰符的大括号，每次创建对象时执行，`public class ClassName{ {} }`
     1. 静态代码块：使用`static`修饰的代码块，用于初始化静态属性，在编译时只执行一次，不能存在于方法体内，不能直接访问静态实例/方法，只能给静态变量赋值，
        `public class ClassName{ static {} }`
     1. 同步代码块：表示同一时间只能有一个线程进入到该方法块中，是一种多线程保护机制。多线程环境下，对共享数据进行读写操作是需要互斥进行的，否则会导致数据的不一致性。冗长的方法中，其实只有一小段代码需要访问共享资源，这时使用同步块，就只将这小段代码裹在synchronized块中，既能够实现同步访问，也能够减少同步引入的开销。必须写在方法中。`public void methodName() { synchronized() {} }`
### 面向对象
1. 包
   - 作用：package，对类和接口归类，用于解决文件名冲突，方便查找和使用
   - 声明：`package com.imooc.myPackage1 myPackage2;`
   - 使用：`import com.imooc.*`，`import com.imooc.myClass`
   - 特点：
     1. 默认引入lang包，不需要显式import
     1. 采用了树形目录的存储方式，不同包中的类名可以相同
     1. 限定了访问权限，有包的权限才能访问包中的类
     1. 可以定义自己的包
1. 接口：常量和抽象方法的集合，规定了子类必须提供某些方法，接口不是类，接口不是被类继承，而是被实现。可理解为对象间通信的协议。标记接口是指没有任何属性和方法的接口，仅表明它的类属于一个特定的类型
   - 特点
     1. 接口：不能被实例化，没有构造方法。接口可以多继承，extends要在implements前边
     1. 属性：每个属性都被指定为public static final
     1. 方法：
        - 接口类和方法都是隐式抽象的，只能是public，可以不用abstract，默认加上，接口中不能实现方法，只能在实现类中实现
        - 除非是抽象类，否则子类必须全部实现接口的所有方法
        - 实现接口方法时，不能抛出强制性异常，只能在接口或继承接口的抽象类中抛出
        - 重写方法时保持一致的方法名，相同或兼容的返回值
   - 实例
       ```Java
        public/protected/private interface 接口名称 [extends 父接口1，父接口2] {            // 声明
            // 常量、抽象方法
        }
        public class Dog implements Animal{}                                            // 实现
       ```
1. 抽象类
   - 理解：父类约束子类应该有哪些方法，抽象出来，避免子类设计的随意性，必须继承使用
   - 特点：除了不能被实例化，属性、方法、构造器和权限访问和类都一样，有抽象方法的一定是抽象类，抽象类中不一定包含抽象方法。子类必须重写全部抽象方法，或者声明自己为抽象类，否则不能被实例化。构造方法和类方法不能申明为抽象方法
   - 定义和继承
        ```Java
        public abstract class Animal{}          // 定义
        public class Cat extends Animal{}       // 继承
        ```
   - 抽象方法：具体实现由子类确定，没有花括号，没有方法体，`public abstract double computePay();`
1. 类：由属性和方法组成，`public/protected/private class 类名{}`，只支持类的单继承，静态变量和方法随着类的消失而消失
   - 属性：全局变量、局部变量、类变量
   - 方法
     1. 特点
        - 参数由参数类型和参数名组成，空格隔开
        - 定义方法时有形参，调用方法时传递实参
        - 返回值类型为void的不能有return
     1. 定义：`public String show(String str) {return str;}`
     1. 分类
        - 普通
        - 静态：定义 `public static void 方法名() {}`，使用：类.方法() 或 对象.方法()
        - 构造方法：和类名相同，没有返回值，不能定义为void，用于初始化对象。没有定义编译器自动为类提供默认构造方法。一个类可有多个构造方法，只是参数不同。子类不能继承父类的构造器，必须调用父类的构造方法，有默认和显式调用两种。父类构造器带参数得，要用super方法显式调用并匹配相应参数、并且在子类构造方法的第一行，父类的默认构造器(没有任何参数)系统自动调用，都没有的报错
        - 析构方法：定义 `protected void finalize(){}`
   - 内部类
     1. 理解：就是一个类中定义的类，对应的是外部类。提供了更好的封装，不允许其他类访问该类，内部类可以访问外部类的所有数据，包括私有数据，不受访问修饰符影响
     1. 分类
        - 普通：即成员内部类
            ```Java
            Inner i= o.new Inner();     // o为外部类，实例化内部类
            Outer.this.method();        // 内部类调用外部类方法
            ```
        - 静态
          1. 静态内部类可以直接访问外部类的静态成员和静态方法
          1. 可以直接访问/调用与内部类静态成员名/方法名不相同的外部类成员/方法，相同需要加上类名
          1. 可以直接创建静态内部类的实例
        - 方法：定义在方法中，不能在当前方法之外的地方使用，不能使用访问控制符和static修饰符
        - 匿名
          1. 价值：经常配合接口使用，关注实现而不关注名称
          1. 使用：直接new一个接口，实现其方法
             ```Java
             new myInterface(){
                 public void method() {}
             }.method();
             ```
1. 对象
   - 理解：java中只有基本数据类型和静态成员不是对象，其他都是对象。类是java.lang.Class类的对象
   - 访问属性和方法：对象名.变量; 对象名.方法();
   - 复制
     1. 浅表复制：自带，指的是同一个对象
     1. 深表复制：另起一个对象
   - Object：所有类默认继承Object类
     1. 方法
        - toString：返回对象hash(对象地址字符串)
        - equals：比较对象的引用是否指向同一块内存地址
   - 匿名对象调用：`new Car().run();`
1. 封装/继承/多态
   - 封装：隐藏类的实现细节，保护类的数据，不让外部直接访问，而是通过类提供的方法来访问，保护屏障，适当的封装更容易修改和实现。步骤：添加修饰符，创建getter/setter方法
   - 继承：extends，可以重用父类/超类的方法和属性。拥有父类非private和default的属性、方法，可以对父类扩展，可以覆写父类方法。初始化顺序为父类属性初始化——父类构造方法——子类属性初始化——子类构造方法
   - 多态：父类引用指向子类对象，调用方法时会调用子类的实现，而不是父类的实现，先检查父级有没有，没有就报错，因此不能使用子类特有的成员属性/方法，使程序有良好的扩展性、灵活性。要存在继承或者接口
     1. 引用多态
        ```Java
        Animal parent = new Animal();         // 指向本类
        Animal child = new Dog();             // 指向子类
        parent.foo();
        child.foo();                          // 先实例子类，再实例父类，使用子类方法
        Dog obj3 = new Animal();              // 这是错误的
        ```
     1. 方法多态：能使用子类或者本类的方法
        - overload：重载，类中方法名相同，参数个数或类型不同的多个方法叫重载。顺序和类型都生效，java可以根据参数确定调用相应的方法。常用于构造器的重载。返回类型和修饰符可不一样，类中和子类中都可重载
        - override：重写，和父类允许访问的方法名/参数相同
          1. 返回类型和形参不能改变
          1. 不能抛出更宽泛的异常
          1. 访问权限不能更低，异常的子类可以
          1. 声明为static的方法不能被重写，但是可以被再次声明
          1. 声明为final的方法不能被重写
1. 浅表复制和深表复制
1. 关键字
   - extends：继承，`public class B extends A`
   - abstract：抽象类
    ```Java
    abstract class A{}
    class B extends A{}
    ```
   - interface：声明接口
   - implements：用于实现接口
    ```Java
    public interface A {}
    public interface B {}
    public class C implements A,B {}
    ```
   - super和this：super实现对父类成员的访问，代表父类，this是所属对象的引用
    ```Java
    super.move();
    this.move();
    ```
   - final
### 数据和数据结构
1. 包装类
   - 定义：将内置数据类型作为对象使用，包装类和基本类型可以自动转换，叫自动封箱和自动解封，属于java.lang包
   - 分类
     1. Byte、Integer、Short、Long、Float、Double
     1. Character、Boolean
1. String
   - 理解：java使用String类来创建和操作字符串，不是8种基本类型，是特殊的对象，默认值null
   - 特点
     1. 有11个构造方法
     1. 字符串的不变性：String对象创建后不可修改，所谓的修改就是创建了新的对象，指向了不同的空间。有很多修改，使用StringBuffer和StringBuilder
   - 子类
     1. StringBuilder
        - 理解：被修改时不产生新对象，非线程安全，不能同步访问，更快，建议使用
        - 方法：append、insert、toString、length
        - 例子：`productName = new StringBuilder().append("%").append(productName).append("%").toString();`
     1. StringBuffer
        - 理解：被修改时不产生新对象，线程安全
        - 方法：append、insert、reverse、replace、delete
1. 数据结构
   - 分类
     1. Enum 枚举：只能是预先设置好的值、Array 数组：长度固定、BitSet 位集合：长度不固定
     1. Vector 向量：长度不固定————Stack栈：先进后出
     1. Dictionary 字典————Hashtable 哈希表————Properties 属性
   - 枚举：Enumeration，Enum，java5.0引入，只能是预先设定好的值，取代定义很多变量，已被迭代器取代，很少使用，本质是类
   - 数组：Array，用来存储固定数量的多个同类型变量，是一种数据结构/容器。定义：数据类型 数组名[] 或者 数据类型[] 数组名。二维数组：`int array[][] = new int[行数][列数]`    
   - 位集合：BitSet，存储一组位或标志，长度不固定
   - 向量：Vector，长度不固定，通过索引访问，线程安全，和ArrayList类似
     1. 栈：Stack，实现了先进后出的数据结构，是Vector的子类
   - 字典：Dictionary，定义键值数据结构的抽象类。因为是抽象类，所以只提供数据结构，没有具体实现，和Map类相似
     1. 哈希表：HashTable，字典的具体实现，Java 2实现了Map接口，集成到了集合中，和hashMap类似，支持同步。哈希散列码用作值的索引，属于java.util
        - 属性：Properties，是哈希表的子类，表示持久属性集，键值都是字符串，获取环境变量时作为System.getProperties()的返回值
1. 集合
   - 理解：具有共同属性的数据集合/工具类，是盛装其他对象的容器，Java2引入，用来代表/操作集合的统一架构
   - 特点
     1. ArrayList 数组序列，排列有序可重复
     1. HashSet 哈希集，排列无序不可重复
     1. HashMap 散列表，键值对
   - 组成
     1. Collection：内部存储为一个个对象，list查询效率高，插入、删除低，因为引起其他元素改变，set查询效率低，插入、删除效率高
        - AbstractList：排列有序可重复
          1. ArrayList：可变大小的数组，不同步
          1. 链表 LinkedList：队列，允许null存在，查找效率低，不同步
        - Set：集，无序不可重复，没有get方法，只能通过遍历访问，每次迭代结果不一样，抽象类AbstractSet
          1. HashSet：不保证元素顺序，最多有一个null
          1. LinkedHashSet：可预知迭代顺序的Set接口的哈希表和链接列表实现
          1. TreeSet：实现排序等
     1. Map：存储键值对，内部以映射存储数据，key不可重复，value可以。抽象类AbstractMap
        - HashMap：访问速度很快，线程不同步，键最多一个null，基于hash表实现。子类有WeakHashMap、LinkedHashMap、IdentityHashMap
        - TreeMap
        - synchronizedMap：线程同步
   - 迭代器：Iterator，遍历集合元素
   - 比较器：Comparator，用来精确定义排序规则，以不同方式排序集合
   - 工具类：Collections(sort)、Arrays(toString/asList)
### 应用
1. 时间和日期：属于java.util
   - Date
   - SimpleDateFormat
   - Calendar：日期，GregorianCalendar：公历日历
1. 文件和目录：File类，文件和目录即对象
1. IO
   - 理解：Java.io包几乎包含所有操作输入/输出的类。流可以理解为一个序列的数据
     1. 字节流：FileInputStream/FileOutputStream
        - 输入流：FileInputStream、ByteArrayInputStream、DataInputStream
        - 输出流：FileOutputStream、ByteArrayOutputStream、DataOutputStream
     1. 字符流：FileReader/FileWriter，一般读写两个字节
     1. 标准流
        - Standard Input：System.in
        - Standard Output：System.out
        - Standard Error：System.err
1. 错误和异常
   - 理解：错误和异常不同，Throwable基类，两个子类：Exception和Error
   - 错误：java.lang.Error包
   - 异常
     1. 理解：所有异常类都是Exception的子类
        - 检查性异常类：Exception
        - 运行时异常类：RuntimeException
     1. 捕获异常：catch语句包含异常的声明，定义捕获哪种类型的异常
        ```Java
        try{
        }catch(异常类型1 异常的变量名1){                  // 多重捕获
        }catch(异常类型2 异常的变量名2){
        }finally{}                                    // 总会被执行
        ```
     1. 抛出异常
        - throw，方法体中，`throw new Exception();`
        - throws，在用声明方法时
     1. 自定义异常：声明异常类
        ```Java
        class MyException extends Exception/RuntimeException{}
        ```
1. 正则表达式
   - 理解：和Perl类似，属于java.util.regex
     1. Patten：正则表达式的编译表示
     1. Matcher：对字符串进行解释和匹配操作的引擎
     1. PattenSyntaxException：非强制异常类，表示正则表达式模式的语法错误
### 运维
1. java安装
   - JDK
     1. rpm安装
     1. centos手动安装
        - 官网下载jdk，即java se
        - tar -zxvf jdk-8-linux-x64.tar.gz
        - mv jdk1.8.0 /usr/local
        - vi /etc/profile
        - 末尾添加
          1. export JAVA_HOME=/usr/java/jdk1.7.0_80
          1. export CLASSPATH=.:$JAVA_HOME/jre/lib/rt.jar:$JAVA_HOME/lib/dt.jar:$JAVA_HOME/lib/tools.jar
          1. export MAVEN_HOME=/developer/apache-maven-3.0.5
          1. export CATALINA_HOME=/developer/apache-tomcat-7.0.73
          1. export PATH=$PATH:$JAVA_HOME/bin:$CATALINA_HOME/bin:$MAVEN_HOME/bin:$NODE_HOME/bin:/usr/local/bin:$RUBY_HOME/bin
        - source /etc/profile
        - java -version
   - Tomcat
      ```java
      tar -zxvf tomcat.tar.gz
      vim conf/server.xml                   // 编辑配置文件，<Connector ... URIEncoding="UTF-8">等
      ./bin/startup.sh                      // 启动
      // 多个tomcat
      cp ~/tomcat-8 /usr/local/tomcats/tomcat1 -r
      cp ~/tomcat-8 /usr/local/tomcats/tomcat2 -r
      vim tomcat1/conf/server.xml           // 自增端口号等
      tomcat1/bin/startup.sh                // 启动
      ```
1. 命令行
   - javac：编译
     1. -cp：指定jar包位置，后边跟jar包的位置
     1. -D：指定调用的类
     1. -d：要生成的目录
     1. -encoding：utf-8
   - java：运行
     1. -jar：运行jar包，环境变量CLASSPATH和在命令行中指定的所有类路径都被JVM所忽略
     1. -classpath：设定要搜索的类路径
   - jar
     1. c：生成jar包，需要先编译
     1. f：指定包名
   - 控制台输入/输出：System.in/out
1. 运行
   - 特点
     1. 源文件名：必须和类名相同
     1. 主方法入口：所有java程序由public static void main(String[] args)开始执行
     1. 流程：.java源文件———编译———.class字节码文件(与平台无关)———解释———完成
   - 运行场景
     1. 单跑：安装JDK，添加path，javac编译，java运行
        - 依赖其他类：默认同级目录和CLASSPATH引入，使用import按照包名查找对应目录下的类，如`import tool.MyDate`，可以添加CLASSPATH的引用目录
        - 依赖其他jar包：还是用import引入类，编译时，添加-cp参数指定jar位置
     1. tomcat
        - 对于servlet，不能和html结合，只能在java程序里一句句输出html字符，文件路径要正确，web.xml在WEB-INF下，编译文件在classes下
        - 对于jsp，写个index.jsp放到ROOT目录即可
        - 依赖其他类和资源文件：web.xml中找编译文件从classes中找，其他类型文件按照目录找，java程序中找类和单跑一样，IDE会自动帮你找，并且编译
        - 依赖其他jar包：一般放在WEB-INF/lib中，类似依赖类，容器根据web.xml配置会自动解jar包进行类的载入
     1. idea
        - 依赖其他类
        - 依赖其他jar包
        - idea跑web
        - idea用maven跑
        - idea用maven跑web
     1. maven
        - 单maven跑：官网的例子archetype:generate--package--java -cp--Hello World!
        - 单maven跑tomcat：涉及打包后部署
1. 打包和部署
   - 特点
     1. java发布过程：源代码——编译——打包——安装jar/war/zip包到服务器
     1. 依赖的jar包：打包时要么在tomcat的lib目录下，要么声明在path中，如果用IDE就设置好就行
   - Jar包
     1. 理解：Java Application Archive，java归档文件，是与平台无关的文件格式，允许将许多文件组合成一个压缩文件，是文件封装的最小单元。包含META-INF 目录：存储配置数据，xxx.SF 签名文件等
     1. 特点
        - 以zip文件格式为基础，提供压缩/部署/封装库，可被编译器和jvm直接使用，无需事先提取文件或设置类路径
        - 包含特殊的文件，如manifests和部署描述符，用来指示工具如何处理特定的jar
     1. 创建
        - 所有代码放到一个目录中
        - 某个位置创建manifest文件，写入主类`Main-Class: HelloWorld`
        - 编译 `javac HelloWorld.java`
        - 打包 `jar cmf manifest jarName.jar ./`
     1. 使用 `java -jar jarName.jar`
   - War包
     1. 理解：Web Application Archive，web应用归档文件，一个Web应用程序被定义为单独的一组文件/类/资源，可以对jar封装作为小型服务程序(servlet)来访问，包含了全部Web应用程序，包括jsp/图片等文件，用于封装web模块。放在tomcat/webapp下，容器会自动解压并运行
     1. 打包
        - 压缩，改后缀名
        - 手动打包：`jar cmf warName.war ./`？？？
        - maven打包
        - idea打包
   - Ear：Enterprise Application Archive，企业应用归档文件，一个企业应用程序被定义为多个jar文件/资源/类、Web应用程序、ejb的集合，即jar、war、ejb
### wiki
1. 知识体系
   - 组成：JDK—->JRE—->JVM
     1. JDK：Java Development Kit，开发工具包，包含编译器和调试器，运行环境
     1. JRE：Java Runtime Environment，运行环境，包括JVM(包含解释器)和其他工具
     1. JVM：Java Virtual Machine，虚拟机，光JVM还不能运行，因为没有lib类库，JRE编译时的会载入lib类库
   - 框架和库
     1. Spring
     1. Hibernate,MyBatis
     1. SpringMVC, Struts
     1. Quartz、Ehcache、Apache commons
1. 版本发展
   - 历史：JDK5开始，Java8=JDK 8=JavaSE8=JavaSE1.8，不再使用J2SE等
   - 框架
     1. Spring 5.0/4.3
     1. Hibernate 5.2.x
     1. Mybatis 3.4
   - 工具
     1. Tomcat 9.0.0
     1. Jetty 9.4.6
     1. Jboss 7.1/wildfly
     1. Maven 3.3.9
     1. Jekins 2.6
     1. Junit 4.12
     1. Log4j 1.2.17
   - Java8：jdk1.8，14年3月发布
     1. Lambda表达式
     1. 方法引用：可以直接引用已有对象/类的方法，使语言结构更简洁紧凑
     1. 实现方法：就是类在接口里有个实现的方法
     1. 新工具：如新的编译工具，Nashorn引擎js、类依赖分析器jdeps
     1. Stream API：即java.util.stream，把真正的函数式编程引入java中
     1. DateTime API：加强日期和时间的处理
     1. Optional 类：解决空指针异常
     1. Nashorn JavaScript 引擎：允许在JVM上运行javascript应用
1. Java周边
   - Groovy：Groovy是JVM衍生的与JAVA语法高度兼容的动态强类型语言，可以运行在JVM上
   - Scala：是一门多范式的编程语言,设计初衷是要集成面向对象编程和函数式编程的各种特性，支持函数式编程的类LISP语言，可以运行在JVM上
   - Clojure：是一种运行在Java平台上的Lisp方言
   - Guava：开源Java库，提供了用于集合，缓存，支持原语，并发性，常见注解，字符串处理，I/O和验证的实用扩展方法
   - JNI：提供了若干的API实现了Java和其他语言的通信（主要是C&C++）
   - Applet
     1. 理解：java编写的小应用程序，可以包含在html页中，内嵌于浏览器执行。产生于浏览器出现不久还只能支持静态页面的时候，用于创建RIAs，用于提供丰富互联网服务，如动画、动态内容、与服务器通讯、富客户端应用。是java的一种应用程序，要求浏览器支持JVM，作用类似flash，嵌入在html中，现在基本没人用
     1. 特点
        - 可以实现图形、人机交互等多媒体表现
        - 提供了抽象窗口工具箱的窗口环境开发工具，用于建立标准的图形用户界面
        - 可以包含awt、swing的组件
        - Applet必须运行于某个特定的“容器”，这个容器可以是浏览器本身，也可以是通过各种外挂程式，或者包括支持Applet的移动设备在內的其他各种程序来运行。与一般的Java应用程序不同，Applet不是通过main方法來运行的。在运行时Applet通常会与用戶进行互动，显示动态的画面，并且还会遵循严格的安全检查，阻止潜在的不安全因素（例如根据安全策略，限制Applet对客戶端文件系统的访问）
     1. 使用：要求为支持java的浏览器在下载applet后在用户计算机上运行
     1. 历史
        - Flash出现后，Applet没有竞争力
        - 后来ajax出现了，浏览器可以和服务器通讯了
        - 后来Html5出现了，有音频、视频、2D图形(Canvas)，WebGL引入了3D图形
     1. RIA三大技术：Flash、Silverlight、JavaFX
   - Awt
     1. 理解：Abstract Window ToolKit 抽象窗口工具包。提供了一套与本地图形界面进行交互的接口，实际上是在利用操作系统所提供的图形库来构建界面
     1. 特点
        - 由于不同操作系统的图形库所提供的功能是不一样的，在一个平台上存在的功能在另外一个平台上则可能不存在。为了实现Java语言所宣称的"一次编译，到处运行"的概念，AWT 不得不通过牺牲功能来实现其平台无关性，也就是说，AWT 所提供的图形功能是各种通用型操作系统所提供的图形功能的交集
        - AWT 是基于本地方法的C/C++程序，其运行速度比较快
   - Swing
     1. 理解：用于开发Java应用程序用户界面的开发工具包。开发出来的程序可以在java虚拟机里独立运行，为了解决awt的问题而推出，比awt有更好的屏幕显示元素。是在AWT的基础上构建的一套新的图形界面系统，拥有更多的界面库
   - JavaFX
     1. 理解：是Java的下一代图形用户界面工具包，对标Flash，用于创建RIAs(Rich Internet application)，是一种跨平台的桌面技术，2008年发布正式版
     1. 组成
        - JavaFX脚本
        - JavaFX Mobile(一种移动操作系统)
     1. 特点
        - 可以直接调用java API
        - JDK支持三大操作系统
        - css定义外观，有WebView、3D图形、富文本、多点触控
   - jython：java版本的python解释器，可以在java环境中运行python，在python中调试java，自由混合两种语言
   - Py4J：同jython，python和java的桥梁
