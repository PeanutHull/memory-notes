### Java体系结构
1. 组成
   - JVM：java虚拟机
   - API：java应用编程接口，提供了独立于平台的标准接口
   - 语法
   - 文件格式
1. Java体系
   - Java SE：java平台标准版
   - Java EE：java平台企业版
   - Java ME：java平台微型版
### 认识
1. 认识
   - 多平台运行，强类型
   - 静态语言中优秀的面向对象特性
   - 传承于C++，在企业，互联网，嵌入式都有广泛的应用
1. 知识体系
   - 组成：
     1. JDK： Java Development Kit，java开发工具包，包含编译器和调试器，运行环境
     1. JRE：java运行环境，java虚拟机JVM(包含解释器)和其他工具
     1. JVM：java虚拟机。光JVM还不能运行，没有lib类库，JRE包含编译时的lib类库
   - 基础
     1. 基础, 基本类型, 操作符, 运算符, 表达式
     1. 面向对象, 类, 继承, 多态, 重写, 重载
     1. String, Object, Array, Enum
     1. 集合, List, ArrayList, Set, HashSet, Map, HashMap, HashTable
     1. File, IO, NIO, InputStream, OutputStream, Reader, Writer, Selector
     1. 多线程, 并发, Thread, Runnable, Future
     1. 注解
     1. 反射
     1. JDBC
     1. IOC依赖注入, AOP 面向切面编程
   - JavaEE
     1. Servlet
     1. JSP, JSTL, EL
     1. Tomcat
   - 框架和库
     1. Spring
     1. Hibernate,IBatis
     1. SpringMVC, Struts
     1. Quartz、Ehcache、Apache commons
   - 版本： 主要区别为基础类库的不同
     1. Java SE： java标准版，包含最普遍的类库，针对普通的java程序。有面向对象/API/JVM..
     1. Java EE： java企业版，类库最多的，针对服务器、web应用。本身是一个规范
        - 多出了Package包，Java容器( Tomcat、 GlassFish、IBM WebSphere )
        - Java EE的子集Servlet/JSP/EJB/服务
        - JCP委员会制定 Java EE 规范，各种实现： sun的 GlassFish， IBM的 Webspher，开源界的tomcat， jetty， jboss。tomcat是用java进行开发的web软件
     1. Java ME： 嵌入式开发，进一步缩减，减少整个环境的占用空间，针对性能不高的游戏/移动/通信等设备
   - 开始
        ```Java
        public class HelloWorld {
            /* 第一个Java程序
            */
            public static void main(String []args) {
                System.out.println("Hello World");
            }
        }
        ```
1. 特点：
   - 语法简单：类似C++，不使用指针而是引用，提供垃圾回收
   - 面向对象：提供类/接口/继承等，只支持类的单继承，但支持接口间的多继承，全面支持动态绑定，纯的面向对象的语言
   - 健壮性：强类型机制，异常处理，垃圾自动回收，丢弃指针。由于 安全检查机制，命名空间等，还有安全性
   - 体系结构中立的：java程序在java平台编译为体系结构中立的字节码格式.class，到处运行。严格要求数据类型的长度，就具有了较强移植性
   - 解释性语言：java程序先编译为字节码格式，java解释器对字节码解释执行，执行中需要的类在联接中载入
   - 高性能：速度越来越接近C++，是多线程的，线程是特殊的对象， 必须由Thread类或其子（孙）类来创建
   - 是动态的
1. 历史发展
   - 从JDK 5.0开始，J2SE等全部改名，JDK5也称为Java5
1. 运行流程：.java源文件———编译———.class字节码文件(与平台无关)———解释———完成

### 语法
1. 数据类型
   - 分类：基本类型、引用类型
   - 基本数据类型
     1. 数值型：整数：byte、short、int、long；浮点数：float、double
     1. 字符型：char
     1. 布尔型：boolean
   - 基本类型详解：
     1. byte：8位有符号二进制补码形式的整数。-128~127——2的7次方。默认0。
     1. short：16位有符号二进制补码形式的整数。-32768~32767——2的15次方。默认0。
     1. int：32位有符号二进制补码形式的整数。4字节。2的31次方范围。默认0。
     1. long：64位有符号二进制补码形式的整数。2的63次方范围。默认0L。如 Long b = -200000L。
     1. float：32位单精度浮点型，不能用于货币。默认0.0f。如 float point = 15.1f;
     1. double：64位双精度浮点型，不能用于货币。默认0.0d。如 double d1 = 123.4。
     1. char：单一16位Unicode字符，如：char name = 'A';最小值是’\u0000’（即为0）
     1. boolean：布尔型，1字节。默认false。
   - 引用数据类型
     1. 理解：类似C/C++的指针， 其指向一个对象，指向对象的变量叫引用变量。这些变量声明时被指定为一个特定类型，一旦声明不能改变类型。默认null
     1. 有：类(接口)、对象、数组
        ```Java
        // 举例
        Site site = new Site("Runoob")
        ```
   - 区别：基本数据类型变量存储的是数据本身，引用类型变量存储数据空间地址
   - 进制
     1. 0表示8进制，0x表示16进制，
     1. 整形都可以用十、八、十六进制表示。
     1. 可以包含unicode字符：char a = '\u0001';
     1. 转义字符：\n换行，\r回车
   - 类型转换
     1. 类型转换
         - 整形、常量、字符可以混合运算，但须转为同一类型。
         - 低到高排列：byte,short,char—> int —> long—> float —> double
         - bool不能转换
         - 对象类型不能改为不相关类
         - 容量大转小时必须使用强制转换。转换可能导致溢出或损失精度。
         - int不能转char。
     1. 自动类型转换：容量小的转大的。
     1. 强制类型转换：数据截断后者溢出。转换条件是数据类型必须是兼容的
        ```Java
        // 举例
        double num = 6.66;
        int avg = (int)num;
        ```
1. 标识符：就是所有定义的东西的名字。有类名/变量名/方法名
     1. 开头：字母、$、下划线
     1. 组成：字母、$、下划线、数字
     1. 特点：大小写敏感、类首字母大写/驼峰法
1. 修饰符： 修饰类、方法和变量
     1. 访问修饰符：可以不使用，默认为default
        - private：同类可见。类和接口不能声明为private，一旦声明私有只能通过getter和setter被外部操作。作用：隐藏类的实现细节和保护类的数据。
        - default：同包可见
        - protected：同包和子类可见。类和接口不能声明为protected，方法和全局变量可以，接口的不行。
        - public：所有类可见。main必须是public的，否则解释器不能运行此类
     1. 访问修饰符的继承：只能往上改，public必须为public，protected为protected或public
     1. 其他修饰符：
        - final：修饰的类不能被继承，修饰的方法不能被重载，修饰的变量为常量不能修改
        - static：创建类变量和类方法
        - abstract：创建抽象类和抽象方法
        - synchronized：同一时间只能被一个线程访问 `public synchronized void showDetails(){}`
        - volatile：每次被线程访问，强制从共享内存中重新读取该成员变量的值。当成员变量改变时强制线程将变化值写回内存。保证不同线程看到同一变量的值
            ```Java
            public class MyRunnable implements Runnable{
                private volatile boolean active;
                public void run(){
                    active = true;
                    while (active) { // 第一行
                        // 代码
                    }
                }
                public void stop(){
                    active = false; // 第二行
                }
            }
            ```
        - transient：JVM跳过`public transient int limit = 55; // 不会持久化`
        - strictfp：浮点数使用严格规则
1. 运算符
   - 分类
     1. 算术： 加减乘除    %取余    ++自增    --自减
     1. 赋值： =    +=    -=    \*=    /=    %=
     1. 比较： > < >= <= == != <<= >>= ^=
     1. 逻辑： && || !
     1. 条件： ? :
     1. 位：&    |    ^(非)    ~(按位补)    <<(按位左移固定位数)    >>    >>>(按位右移补零)
     1. instanceof：检查对象是否是类类型、接口类型
        ```Java
        String name = "James";
        boolean result = name instanceof String; // 由于 name 是 String 类型，所以返回真
        Vehicle a = new Car();
        boolean result = a instanceof Car; // 兼容于右侧类型,该运算符仍然返回true
        ```
   - 优先级：括号的最高
   - 说明：
     1. 自增/减只能用于变量，位置前后作用不同
     1. 只有==和!=两个比较运算符两边可以是引用类型，其他的两边都是数值型
     1. ^ 异或：有且仅有一个才行。java有短路作用，即只执行一部分
1. 引号：单引号是char类型的只能引一个字符，双引号是String类型的
1. 注释和说明
    1. 特点：注释和空行都会被java编译器忽略
    1. 分类：// 单行注释、/\* \*/文档注释、/\* \* \*/多行注释
    1. 注释标签
        ```Java
        @author
        @version
        @param
        @serial
        @exception 对可能的异常的说明
        @link
        @see 参考转向
        @return
        // 例子
        /**
        * This method inputs a number from the user.
        * @return The value input as a double.
        * @exception IOException On input error.
        * @see IOException
        */
        ```
    1. 提取Java注释：javadoc -d doc hello.java
1. 常量
   - 理解：程序运行时，不会修改的量。一旦定义，不许修改。通常大写
   - 定义：
    ```Java
    // 使用final关键字定义
    final String LOVE = "imooc";
    ```
   - 好处：可提高程序可维护性。即避免命名不规范等导致的问题
1. 变量
   - 理解：使用前必须先声明。
   - 定义:
    ```Java
    // 声明并赋值
    int z= 0;
    // 先声明，后赋值   
    int z;
    z= 11;
    ```
   - 分类：
        - 全局变量：即成员变量，类中共享的变量，float int
        - 局部变量：方法中定义的变量。一个方法中局部变量不能重名，局部比全局的优先级高，java会给全局定义初始值(定义不赋值)，不会给局部定
        - 类变量：即静态变量。在构造方法和语句块之外。属于类，所有下边的对象共享只有一份。
            ```Java
            // 声明静态变量
            protected static String name = 'haha';
            // 声明静态常量
            public static final String A = "666";
            // 使用
            类名.name;
            ```
1. 流程控制
   - 判断
        ```Java
        // if类型
        if() {
        }else if(){
        }else{
        }
        // switch类型
        switch() {
                case value1:
                // 执行; break;
                default:
                // 执行
        }
        ```
    - 循环
        ```Java
        // while类型
        while(i <= 1000) {
                i++;
        }
        // do类型
        do {
            i++;
        } while(i <= 1000);
        // for类型
        for(int i=1,j=1;i <= 1000 && j != -1000;i++,j--) {
            i++;
        }
        // 循环控制
        break;
        continue;
        ```
1. Java类库，常见的包
   - jsva.lang：语言包
     1. 数据类型包装类
     1. 字符处理
        - String类
        - StringBuffer类
     1. Math：数学类
     1. Object：类
     1. 操作类
        - Class类
        - ClassLoader类
     1. 错误和异常处理类
        - Trowable
        - Exception
        - Error
     1. 线程类
        - Thread类
        - TreadDeath
        - Runnable类
     1. Process：过程类
     1. 系统和运行类
        - System类
        - Runtime类
   - java.util：实用包
     1. 数据结构类
        - LinkedList：链表类
        - Vector：向量类
        - Stack：栈类
        - HashTable：散列表类
     1. Random：随机数类
     1. 日期类
        - Date类
        - Calendar类
        - GregorianCalendar类
   - java.io：输入输出包
     1. InputStream
     1. OutputStream
   - java.net
   - java.sql
   - java.awt/swing：窗口工具包
   - applet
1. 时间和日期
   - 理解：属于java.util包。
   - 示例
        ```Java
        // 实例化，可以传入1970年后的毫秒数
        Date([long millsec])
        // 获取当前时间
        Date date = new Date();
        System.out.println(date.toString());
        ```
   - Date方法：
     1. alter()/before()：是否在日期之前/之后
     1. clone()：返回副本
     1. compareTo()：和日期对比。相同为0，在指定之前为负，之后为后
     1. equals()：对比是否相同
     1. getTime()：获得时间戳
     1. hashCode()：此对象哈希值
     1. setTime()：用时间戳设置时间
     1. toString()：转换Date为String
   - SimpleDateFormat
        ```Java   
        // 格式化时期显示
        Date dNow = new Date();
        SimpleDateFormat ft = new SimpleDateFormat ("E yyyy.MM.dd 'at' hh:mm:ss a zzz");
        ft.format(dNow)
        // 解析字符串为时间
        SimpleDateFormat ft = new SimpleDateFormat ("yyyy-MM-dd");
        String input = "1818-11-11";
        ft.parse(input);
        ```
    - Calendar类
      1. 理解：获取日期的一部分，加减日期
      1. 示例
            ```Java
            Calendar c = Calendar.getInstance(); // 创建，默认当前时区
            Calendar c = Calendar.getInstance(); // 创建指定日期
            c.set(2009, 6 - 1, 12);
            c.get(Calendar.YEAR); // 获得年份
            c.add(Calendar.DATE, 10); // 加10天
            ```
      1. 字段类型：Calendar.YEAR/MOUTH/DATE/DAY\_OF\_MOUTH/HOUR/HOUR\_OF_DAY/MINUTE/SECOND/DAY\_OF\_WEEK
      1. GregorianCalendar类：实现公历日历，是Calendar的一个实现
1. IO
   - 理解：Java.io几乎包含所有操作输入/输出的类。流可以理解为一个数据的序列
   - 控制台输入：由System.in完成，包装在BufferedReader对象中创建字符流。
        ```Java
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
        // 读取字符
        do {
            c = (char)br.read();
            System.out.println(c);
        } while(c != 'q');
        String str = br.readLine(); // 读取字符串
        Scanner类 // jdk5之后可用获得输入
        ```
    - 控制台输入——Scanner类
      1. 理解：Java5的新特性，获取用户输入
      1. 使用
            ```Java
            Scanner s = new Scanner(System.in);
            if(scan.hasNext()){
                String str1 = scan.next();
                System.out.println("输入的数据为："+str1);
            }
            // 或者
            if(scan.hasNextLine()){
                String str2 = scan.nextLine();
                System.out.println("输入的数据为："+str2);
            }
            // 区别：
            next：一定读取到有效字符才结束输入，自动去掉之前空白，有效符后面的空白作为分隔符和结束符，所有不能输入空格
            nextLine：回车为结束符
            ```
    - 控制台输出：print()和println()完成，由类PrintStream定义，System.out是该类的一个引用。PrintStream 继承了 OutputStream类，实现了方法write()，可以写入控制台
        ```Java
        int b = 'A';
        System.out.write(b);
        ```
1. File
   - 读取文件
     1. 创建
        ```Java
        // 创建对象来读取文件
        InputStream f = new FileInputStream("C:/java/hello"); // 创建输入流对象
        File f = new File("C:/java/hello"); // 创建使用文件对象创建输入流对象
        InputStream f = new FileInputStream(f);
        ```
     1. 方法
        ```Java
        public int read(byte[] r) throws IOException{}
        public int read(int r)throws IOException{}
        protected void finalize()throws IOException {}
        public void close() throws IOException{}
        public int available() throws IOException{}
        ```
     1. 其他输入流：ByteArrayInputStream、DataInputStream
   - 写入文件
     1. 创建
        ```Java
        OutputStream f = new FileOutputStream("C:/java/hello") // 创建输出流对象
        File f = new File("C:/java/hello"); // 创建使用文件对象创建输出流对象
        OutputStream f = new FileOutputStream(f);
        ```
     1. 方法
        ```Java
        public void close() throws IOException{}
        protected void finalize()throws IOException {}
        public void write(int w)throws IOException{}
        public void write(byte[] w)
        ```
     1. 其他输出流：ByteArrayOutputStream、DataOutputStream
   - 目录
     1. 创建
        ```Java
        bool mkdir() // 返回false表明已存在或父级目录不存在
        bool mkdirs() // 递归创建文件夹
        // java自动识别win和unit系统的分隔符
        // 例子
        String dirname = "/tmp/user/java/bin";
        File d = new File(dirname);
        d.mkdirs();
        ```
      1. 读取：一个目录即一个对象，
            ```Java
            File d = new File(dirname);
            d.isDirectory(); // 是否是目录
            d.list(); // 列出文件和文件夹列表
            ```
    - 删除文件/目录
        ```Java
        File folder = new File("/tmp/java/test");
        String[]entries = folder.list();
        for(String s: entries){
            File currentFile = new File(folder.getPath(),s);
            currentFile.delete();
        }
        ```
1. Stream
1. 正则表达式
   - 理解：定义了字符串的模式。Java的和Perl类似。存于java.util.regex包
   - 主要的类
     1. Patten：patten对象是一个正则表达式的编译表示。无公共构造方法，首先调用公共静态编译方法，获得Patten对象，接受一个正则表达式为一参
     1. Matcher：matcher对象是对输入的字符串进行解释和匹配操作的引擎。无公共构造方法，用Patten的matcher方法获得Matcher对象。
     1. PattenSyntaxException：非强制异常类，表示正则表达式模式的语法错误
   - 示例
      ```Java
      import java.util.regex.*;
      String content = "aaa";
      String pattern = ".\*bbb.\*";
      boolean isMatch = Pattern.matches(pattern, content); // 返回结果
      ```
   - 捕获组：将多个字符当一个独立单元处理的方法。调用matcher对象的groupCount方法统计组数
1. 异常
   - 认识异常：有语法错误`java.lang.Error`、`java.lang.ArithmeticException`。发生原因：非法数据、JVM内存溢出。错误和异常是不同的。
     1. 分类：JVM异常，如NullPointerException、ClassCastException；程序集异常：IllegalArgumentException
   - Exception类：Throwable是老祖宗，有两个子类：Exception和Error。所有异常类都是Exception的子类。
     1. 分类：检查性异常类：Exception；运行时异常类：RuntimeException
   - 捕获异常：case语句包含异常的声明，定义捕获哪种类型的异常
        ```Java
        try{
        }catch(ExceptionName e1) {
        }
        // 例子
        try{
            int a[] = new int[2];
            System.out.println("Access element three :" + a[3]);
        }catch(ArrayIndexOutOfBoundsException e){
            System.out.println("Exception thrown  :" + e);
        }
        // 多重捕获
        try{
        }catch(异常类型1 异常的变量名1){
        }catch(异常类型2 异常的变量名2){
        }finally{
        // 此代码块总会被执行，适用善后性质的语句
        }
        try{
            file = new FileInputStream(fileName);
            x = (byte) file.read();
        }catch(IOException i){
            i.printStackTrace();
            return -1;
        }catch(FileNotFoundException f) //Not valid!{
            f.printStackTrace();
            return -1;
        }
        ```
    - 抛出异常：throw
        ```Java
        throw new RemoteException();
        ```
    - 自定义异常
        ```Java
        // 声明异常类
        class MyException extends Exception/RuntimeException{}
        ```
### 面向对象
1. 封装/继承/多态
   - 封装：将类的实现信息隐藏起来，不能让外部直接访问，而是通过类提供的方法来访问
     1. 封装的好处：安全、保护屏障，隐藏类实现细节，适当的封装更容易修改和实现
     1. 封装的步骤：修改可见性添加修饰符——创建getter/setter方法——getter/setter设置控制语句
     1. 示例
        ```Java
        private float num;
        public float getNum() {
                return num;
        }
        public void setNum(float num) {
                this.num = num;
        }
        ```
   - 继承：可以重用父类的方法和属性，超类——子类
     - 使用：对象名.属性/方法。关键字：、。默认继承object
     - 特点：拥有父类非private的属性、方法，可以对父类扩展，也可以覆写父类方法，可多重继承
     - 关于构造方法：子类不能继承构造器(构造方法、构造函数)。父类构造器带参数得，要用super方法显式调用并匹配相应参数`super(params)`，父类构造器不带参数的，没有super系统自动调用
     - 关键字
         1. extends：`public class B extends A`
         1. implements：用于类继承接口
            ```Java
            public interface A {
                public void eat();
                public void sleep();
            }

            public interface B {
                public void show();
            }

            public class C implements A,B {}
            ```
         1. super和this：super实现对父类成员的访问，表示当前对象的父类，this是自己的引用
            ```Java
            super.move(); // 调用父级方法            
            ```                        
         1. final
            ```Java
            // 修饰属性：不能被修改
            // 修饰方法：不能被重写
            // 修饰类：不能被继承
            ```
   - 多态：同一个行为具有多个不同表现形式或形态的能力。就是同一个接口，使用不同实例而执行不同操作
     - 存在条件：继承、重写、父类引用指向子类对象
     - 多态的实现
       1. 重写
       1. 接口
       1. 抽象类和抽象方法
     - 优点：消除类型之间的耦合关系，灵活性，可替换性、扩充性。使程序有良好的扩展，对所有类的对象进行通用处理
     - 示例
        ```Java
        // Animal是abstract抽象类，其他是子类。Animal只有eat方法，所以可以执行eat()
        Animal a = new Cat();  // 向上转型  
        a.eat();               // 调用的是 Cat 的 eat
        Cat c = (Cat)a;        // 向下转型
        c.work();              // 调用的是 Cat 的 catchMouse，不向下转报错，因为Animal无work方法
        ```
     - 虚拟方法：使用多态调用方法时(即实例化的对象为父类的对象)，先检查父级有没有，没有就报错，但是最终执行的是子类的方法，这就叫虚方法。实例化的对象为子类，则不会检查。
        ```Java
        Salary s = new Salary("员工 A", "北京");
        Employee e = new Salary("员工 B", "上海");
        s.mailCheck();
        e.mailCheck(); // 先实例子类，再实例父类
        ```     
     - override重写：对父类允许访问的方法重写，返回值和形参不能改变，不能抛出更宽泛的异常，异常的子类可以。外壳不变，核心重写。
       1. 重写规则：参数和返回类型完全相同，访问权限不能更低，声明为static的方法不能被重写，但是可以被再次声明，包影响可以重写的方法访问权限，构造方法不能被重写，能继承才能重写方法。父类的方法只能被子类重写，声明为final的方法不能被重写，
     - overload重载：在一个类中，方法名字相同，参数不同。最常用构造器的重载
       1. 重载的规则：参数不一样、顺序和类型都生效，返回类型和修饰符可不一样，检查异常可扩展，类中和子类中都可重载，
1. 属性
   - 全局变量：即成员变量
   - 局部变量
   - 类变量：即静态变量
1. 方法
   - 定义：以字母、下划线、美元符开头，可包括数字
        ```Java
        访问修饰符 返回值类型 方法名(参数列表) {
            方法体
        }
        // 修饰符：public/protected/private/省略
        // 返回值类型：void 不返回任何类型，不能有return；写出类型，并在方法中有return
        // 参数：参数类型和参数名组成，空格隔开
        public static void main(String[] args) {} // 主方法
        public String show(String str) {
                return str;
        }
        // 调用：对象名.方法名(参数)
        ```
   - 分类：构造/静态/普通
        ```Java
        // 构造方法的定义
        public 类名(参数) {}
        // 构造方法的重载
        参数不同的构造方法，java实例化时会自动选择不同的构造方法
        // 静态方法的定义
        public static void 方法名() {}
        // 静态方法的使用
        类.方法();  或者 对象.方法();
        ```
   - 示例
        ```Java
        // 声明
        修饰符 返回值类型 方法名(参数类型 参数名){
            方法体...
            return 返回值;
        }
        // 如：public static int age(int birthday){...}
        // 空的返回值类型为：void
        ```
   - 可变参数：jdk1.5开始，方法支持传递同类型的可变参数
        ```Java
        public static void printMax(double... numbers) {} // 可传递int、double
        ```
   - 命令行参数：程序运行时传递参数给main()实现
   - 重载：建立多个同名方法，定义不同类型参数。Java根据参数确定调用相应方法
   - 构造方法：初始化对象，和类名相同，没有返回值。所有方法默认有个构造方法
   - 析构方法：析构即回收
        ```Java
        protected void finalize(){
            // 在这里终结代码
        }
        ```
1. 对象
   - 访问属性和方法：对象名.变量; 对象名.方法();
   - 复制
     1. 浅表复制：自带，指的是同一个对象
     1. 深表复制：另起一个对象
1. 类：由方法和属性组成
     1. 定义
    ```Java
    package com.imooc // 包名
    public/protected/private function 类名{
            float score;
    }
    ```
     1. 访问修饰符
     1. 初始化块
        - 作用：顺序执行其中的代码，包括为变量赋值
    ```Java
    public class 类{
    String name;
            {
                name = "haha";
            }
    }
    // 特点：可以用静态修饰，由于普通的属性/方法，只能实例化后使用，所以静态初始化块只能给静态变量赋值
    ```
     1. 构造方法
        - 解释：没有显式定义类的构造方法，java编译器会为该类提供默认构造方法。创建对象至少调用一个构造方法，构造方法必须和类同名，一个类可以有多个构造方法
    ```Java
    public class Puppy{
        public Puppy(){
        }
        public Puppy(String name){
        // 构造器
        }
     }
    ```
     1. this关键字：this.属性，this.方法
1. 抽象类
   - 理解：为了将来对类进行扩充。除了不能被实例化，其他功能都存在。属性、方法、构造器和权限访问都一样。必须继承使用，表示一种继承关系，一个类只能继承一个抽象类，但可以实现多个接口
   - 定义和继承使用
        ```Java
        // 定义
        abstract class Animal{
            private double leng;
            public abstract void work(
            );
        }
        // 继承
        public class Cat extends Animal{} // 继承了父类的成员变量和成员方法
        ```
   - 抽象方法：具体实现由子类确定，就可声明为抽象方法。没有花括号，没有方法体
     1. 定义
       ```Java
        public abstract class Employee
        {
            private String name;
            public abstract double computePay();
        }
       ```
     1. 特点：有抽象方法的一定是抽象类，抽象类中不一定包含抽象方法。子类必须重写抽象方法，或者声明自己为抽象类，否则不能被实例化，即实例化就报错。构造方法和类方法(static)不能申明为抽象方法
   - 特点：
     1. 可以包含抽象方法和非抽象方法。有抽象方法必须为抽象类，抽象类可以没有抽象方法。抽象方法决定抽象类
     1. 抽象方法没有任何实现，由子类具体实现。不能由final和static修饰
     1. 子类必须实现父类所有抽象方法，除非子类也是抽象类
1. 接口：抽象方法的集合，子类通过实现接口来实现所有的抽象方法。接口类和方法都是隐式抽象的，可以不用abstract。接口不是类，但是编写方式和类很像，接口不是被类继承，而是被实现。可理解为对象间通信的协议
   - 声明：interface
       ```Java
        [可见度] interface 接口名称 [extends 其他的类名] {
            // 声明变量
            // 抽象方法
        }
        // 接口的多继承
        public interface Hockey extends Sports, Event{}
       ```
   - 实现：implements
       ```Java
       public class MammalInt implements Animal{}
       // 实现接口方法时，不能抛出强制性异常，只能在接口或继承接口的抽象类中抛出
       // 重写方法时保持一致的方法名，相同或兼容的返回值
       ```
   - 特点
     1. 本身：不能被实例化，没有构造方法。一个类只能继承一个类，可以实现多接口继承。接口可以多继承，所有参与继承的方法都要实现。
     1. 属性：不能包含成员变量，除了static和final变量。
     1. 方法：接口中所有方法必须是public的抽象方法，接口中不能实现方法，只能在实现类中实现。除非是抽象类，否则子类必须全部实现接口里的所有方法。
       ```Java
       // 接口的每个方法都是隐式抽象的，即：public abstract，只能是public，否则报错，只有这一种
       // 接口的每个属性都被指定为public static final变量，只有这一种
       ```
   - 标记接口：没有任何属性和方法的接口，仅表明它的类属于一个特定的类型
1. 包
   - 作用：解决文件名冲突，对类和接口分类，方便查找和使用。
   - 组成：类、接口、枚举和注释
   - 声明
        ```Java
        package com.imooc.myClass(包名) 包名1 包名2;
        public class Something{}
        // 路径为：com.imooc.myClass/Something
        ```
   - 使用 `import com.imooc.*`
   - 系统中的包
        ```Java
        java.功能.类
        java.lang. 语言基础类
        java.util. 工具类
        java.io. 输入输出相关类
        ```
   - 特点：
     1. 默认引入lang包，不需要import引入
     1. 开发者可以定义自己的包，
     1. 包采用了树形目录的存储方式，不同包中的类名可以相同，加上包名区别不同包中的类。
     com.runoob.test的目录结构为`CLASSPATH\com\runoob\test\类名`
     1. 包也限定了访问权限，有包的权限才能访问包中的类
1. 其他特点
   1. 内部类
      - 定义：就是一个类中定义的类，对应的是外部类
      - 作用：更好的封装
### 类的解释
1. System：系统类
1. 包装类
   - 定义：将内置数据类型作为当做对象使用。都是抽象类Number的子类，属于java.lang包
   - 分类：Byte、Integer、Short、Long、Float、Double
   - 示例
        ```Java
        // 内置数据类型
        int a = 5000;
        // 包装类
        Integer x = 5;
        ```
1. Math类
   - 定义：提供了基本数学运算的属性和方法。如初等函数、对数、平方根和三角函数，都是静态函数
   - 示例
        ```Java
        Math.sin(Math.PI/2) // 90 度的正弦值
        ```
   - 常用方法：
     1. x.byteValue()：将Number对象转换为xx数据类型。如short/int/long/float/double、Value();
        ```Java
        Integer x = 5;
        x.byteValue()
        ```
     1. equals(param)：number对象是否和参数相等
        ```Java
        Integer x = 5;
        Integer y = 5;
        System.out.println(x.equals(y));
        ```
     1. compareTo(param)：将number对象和参数比较。同类型数据比较，返回值：0相等、小于参数-1、大于1
     1. valueOf()：返回参数的原生Number对象值。参数为原生数据类型、String。
        ```
        static Integer valueOf(int i) //
        static Integer valueOf(String s)
        static Integer valueOf(String s, int radix)
        ```
     1. toString()：以字符串形式返回
     1. parselnt()：将字符串解析为int类型
     1. abs()：绝对值
     1. ceil、floor、rint()：对整形变量向左、右取整、最接近的整数，返回double类型
     1. round()：返回最接近的int、long值
     1. min、max()：两个参数得最大小值
     1. random()：返回随机值，0到1之间，无参数
1. Character类
   - 定义：对单个字符进行操作，包装一个char类型的对象
   - 示例：
    ```Java
    char ch = 'a';
    char uniChar = '\u039A'; // unicode形式
    char[] charArray ={ 'a', 'b', 'c', 'd', 'e' }; // 字符数组
    // CHaracter类对象
    Character ch = new Character('a');
    ```
   - 特点：当char作为Character类的参数时，自动将char转为Character类型。称为装箱，反之为拆箱
   - 常用方法：
     1. isLetter()：是否一字母
     1. isDigit()：是否一数字字符
     1. isWhitespace()：是否空格
     1. isUpperCase、LowerCase()：是否大、小写字母
     1. toUpperCase、toLowerCase()：设置大、小写
     1. toString()：返回字符的字符串形式
1. String：不是8种基本类型，是特殊的对象。对象默认值是null，String有其他对象没有的特性
   - 理解：java中字符串属于对象，java使用String类来创建和操作字符串
   - 特点
     1. 有11个构造方法
     1. 一旦创建不可改变，如果有很多修改，使用StringBuffer和StringBuilder类
   - 方法：
     1. int length()：长度`int length()`
        ```Java
        String site = "www.runoob.com";
        int len = site.length();
        ```
      1. concat()：连接`String concat(String str)`
            ```Java
            "我的名字".concat("Runoob");
            // 更常用+号连接
            "Hello," + " runoob"
            ```
     1. charAt()：指定位置的值，返回的值可以为char`char charAt(int index)`
     1. copyValueOf()：返回数组中指定的偏移和长度的字符串。`public static String copyValueOf(char[] data, int offset, int count)`
     1. indexOf()：字符在此字符串第一次出现的索引，二参为开始搜索位置`int indexOf(String/int, int ch)`
     1. lastIndexOf()：字符串最后一次出现的索引`int lastIndexOf(int ch, int fromIndex)`
     1. equals()：与String对象进行比较，返回布尔值`boolean equals(Obj obj)`
     1. equalsIgnoreCase()：与String对象进行比较忽略大小写，返回布尔值`boolean equalsIgnoreCase (String str/String str)`
     1. compareTo()：与String对象进行比较，相等返回int0，小于为负数，大于为正数`int compareTo(Obj obj)`
     1. compareToIgnoreCase()：与String对象进行比较，比较时忽略大小写`int compareToIgnoreCase (String str)`
     1. contentEquals()：将此字符串与StringBuffer比较是否相同`boolean contentEquals(StringBuffer sb)`
        ```Java
        String str1 = "String1";
        String str2 = "String2";
        StringBuffer str3 = new StringBuffer( "String1");
        boolean result = str1.contentEquals( str3 ); // true
        result = str1.contentEquals( str3 ); // false
        ```
     1. trim()：去掉前后空白`String trim()`
     1. replace()
     1. replaceAll()
     1. replaceFirst()
     1. split()：正则拆分字符串`String[] split(String regex, [int limit])`
     1. substring()：返回新子字符串`String substring(int beginIndex)`
     1. matches()：是否匹配给定的正则`boolean matches(String regex)`
     1. regionMatches()
     1. intern()：String 返回字符串的规范化表示形式`String intern()`
     1. hashCode()：int hashCode()，哈希值`Int hashCode()`
     1. startsWith()：是否以指定的后缀结束`boolean startsWith(String str)`
     1. endsWith()：是否以指定的后缀结束`boolean endsWith(String str)`
     1.
     1. getBytes()：使用字符集将字符串编码为byte序列`byte[] getBytes()`
        ```Java
        byte[] Str2 = Str1.getBytes();
        Str2 = Str1.getBytes( "UTF-8" );
        Str2 = Str1.getBytes( "ISO-8859-1" );
        ```
     1. getChars()：将字符串复制到字符数组`void getChars(int srcBegin, int srcEnd, char[] dst, int dstBegin)`
     1. toCharArray()：转为字符串数组`char[] toCharArray()`
     1. toLowerCase()：所有转为小写`String toLowerCase([Locale locale])`
     1. toUpperCase()：所有转为小写`String toUpperCase([Locale locale])`
     1. format()：格式化字符串
        ```Java
        System.out.printf("浮点型变量的的值为 " +"%f, 整型变量的值为 " + " %d, 字符串变量的值为 " + "is %s", floatVar, intVar, stringVar);
        String fs; fs = String.format("浮点型变量的的值为 " + "%f, 整型变量的值为 " + " %d, 字符串变量的值为 " + " %s", floatVar, intVar, stringVar);
        ```
   - 示例：
        ```Java
        // 创建字符串
        String greeting = "菜鸟教程";
        // 提供一个字符数组参数
        char[] helloArray = { 'r', 'u', 'n', 'o', 'o', 'b'};
        String helloString = new String(helloArray); // 输出runoob
        ```
1. StringBuffer
   - 理解：对字符串进行修改时用到，能够被修改并且不产生新对象。如果要求线程安全，则必须使用StringBuffer
   - 方法
     1. append()：追加字符串`StringBuffer append(String str)`
     1. reverse()：以反转形式取代`StringBuffer reverse(StringBuffer sb)`
     1. delete()：删除字符串中某些`StringBuffer delete(int start, int end)`
     1. insert()：插入`StringBuffer insert(int offset, int )`
     1. replace
1. StringBuilder
   - 理解：同StringBuffer，但不是线程安全的，即不能同步访问。更快，建议使用
1. 对象序列化
   - 理解：JVM独立的，可进行可序列化和反序列化
   - 被序列化成功的条件：必须实现java.io.Serializable对象，类的所有属性必须是可序列化的。通过文档查看类是否实现Serializable接口即可知道是否可序列化
   - 序列化
        ```Java
        // 准备类
        Employee e = new Employee();
        // 将序列化的类写入文件
        FileOutputStream fileOut = new FileOutputStream("/tmp/employee.ser");
        ObjectOutputStream out = new ObjectOutputStream(fileOut);
        out.writeObject(e);
        out.close();
        fileOut.close();
        ```
   - 反序列化
        ```Java
        FileInputStream fileIn = new FileInputStream("/tmp/employee.ser");
        ObjectInputStream in = new ObjectInputStream(fileIn);
        e = (Employee) in.readObject();
        in.close();
        fileIn.close();
        ```
### 使用
1. Applet基础：是java的一种应用程序，要求浏览器支持JVM，作用类似flash，嵌入在html中，现在基本没人用
1. 开发
 - Eclipse开发java：创建java项目——创建程序包——编写java源程序——运行java
 - Eclipse开发java web： 安装Java/Eclipse/Tomcat——Eclipse配置JRE——集成Tomcat——创建项目——部署(发布)到tomcat——启动tomcat
 - Intellij开发java web：安装Java/Intellij/Tomcat——配置JRE/Tomcat——创建项目——部署(发布)到tomcat——启动tomcat
 - Mac启动tomcat：进入bin目录——sudo chmod 755 \*.sh——sudo sh startup.sh。关闭：sudo sh shutdown.sh。部署项目后需要重启
 - java web项目组成
     1. index.jsp
     1. WEB-INF:classes放字节码文件，lib放jar包
### WIKI
1. java程序特点
     1. 源文件名：必须和类名相同
     1. 主方法入口：所有java程序由public static void main(String[] args)开始执行
1. 知识点
 - 环知识点：基础，web开发，常用框架，工程与设计模式，数据库和网络，数据结构和算法
 - 扩展知识点：多线程 io jvm 分布式 mysql spring redis mq 微服务
1. 关键字： 不能用于标识符的使用
     1. 面向对象
         - 包： package

         - 类的操作： import 、 abstract 、 super
         - 接口： interface、implements

         - 类： class
         - 继承： extends、final

         - 修饰符： private、protected、public、 static
         - 实例化： new
     1. 数据类型
         - byte、short、int、long
         - float、double、strictfp
         - char、transient
         - boolean、enum
     1. 流程控制
         - switch、case、default、break、continue
         - for，do、while，
         - if、else
         - return、void
     1. 异常
         - try、catch、 finally 、 throw、throws
     1. 其他
         - this
         - native、 volatile、 synchronized
     1. 判断
         - assert、instanceof
     1. 未使用
         - goto，const
     1. 解释
         -  package： 相关类组成一个包

         -  import： 导入类； abstract： 定义抽象类； super： 基类； class： 定义类
         -  interface：一种抽象类型，定义接口，仅有方法和常量的定义； implements： 一个类实现接口

         -  extends：继承； final：值初始化后不能被改变/方法不能被重写/类不能再有子类
         -  public： 共有属性或方法； static： 类级别定义，所有实例共享
         -  new：分配新的类实例
         -  byte：8-bit 有符号数据类型；
         - short：16位数字；int：32位整数； long：64位整数；

         - float：32-bit 单精度浮点数； double：64-bit 双精度浮点数； strictfp：严格规则浮点数

         -  char：16-bit Unicode字符数据类型； transient：修饰不要序列化的字段；

         -  void：标记方法不返回任何值

         -  throws：定义方法可能抛出的异常

         -  this：表示当前实例/调用另一个构造函数；

         -  native：表示方法用非java代码实现

         -  synchronized：表示同一时间只能由一个线程访问的代码块
         -  volatile：标记字段可能被多个线程同时访问而不做同步
         -  assert：判断条件是否满足 ？
         -  instanceof：检测对象是否是一个类实例
