### Java体系结构
1. Java体系
   - Java SE：java平台标准版。包含最普遍的类库，针对普通的java程序
   - Java EE：java平台企业版。是类库最多、针对web应用的一个规范
   - Java ME：java平台微型版
1. 知识体系
   - 组成：
     1. JDK：Java Development Kit，java开发工具包，包含编译器和调试器，运行环境
     1. JRE：java运行环境，包括JVM(包含解释器)和其他工具
     1. JVM：java虚拟机。光JVM还不能运行，因为没有lib类库，JRE编译时的会载入lib类库
   - 基础
     1. 基础：基本类型, 操作符, 运算符, 表达式
     1. 面向对象：类, 继承, 多态, 重写, 重载
     1. 常用类：String, Object, Array, Enum
     1. 集合类, List, ArrayList, Set, HashSet, Map, HashMap, HashTable
     1. I/O：File, IO, NIO, InputStream, OutputStream, Reader, Writer, Selector
     1. 多线程：并发, Thread, Runnable, Future
     1. 反射、注解、泛型
     1. 异常处理
     1. 多线程
     1. JDBC、网络编程
     1. 设计模式、IOC依赖注入, AOP面向切面编程
     1. JVM
   - JavaEE：Servlet、JSP等12项规范
   - 框架和库
     1. Spring
     1. Hibernate,MyBatis
     1. SpringMVC, Struts
     1. Quartz、Ehcache、Apache commons
1. 开始
    ```Java
    public class HelloWorld {
        /* 第一个Java程序
        */
        public static void main(String[] args) {
            System.out.println("Hello World");
        }
    }
    ```
### 认识
1. 认识
   - 多平台运行，强类型
   - 静态语言中优秀的面向对象特性
   - 传承于C++，在企业，互联网，嵌入式都有广泛的应用
1. 特点：
   - 语法简单：类似C++，不使用指针而是引用，提供自动垃圾回收
   - 面向对象：提供类/接口/继承等，只支持类的单继承，但支持接口间的多继承，全面支持动态绑定，纯的面向对象的语言
   - 健壮性：强类型机制，异常处理，垃圾自动回收，丢弃了指针。安全检查机制、命名空间等，还有安全性
   - 体系结构中立：java程序在java平台编译为体系结构中立的字节码格式.class，到处运行。严格要求数据类型的长度，就具有了较强移植性
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
     1. 数值型：
        - 整数：byte、short、int、long
        - 浮点数：float、double
     1. 字符型：char
     1. 布尔型：boolean
   - 基本类型详解：
     1. byte：8位有符号二进制补码形式的整数。-128~127——2的7次方。默认0。
     1. short：16位有符号二进制补码形式的整数。-32768~32767——2的15次方。默认0。
     1. int：32位有符号二进制补码形式的整数。4字节。2的31次方范围(-2147483648~2147483647十亿级)。默认0。
     1. long：64位有符号二进制补码形式的整数。2的63次方范围(百亿亿级)。默认0L。表示形式为 Long b = -200000L。
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
        int avg = (int) num;
        // 使用instanceof判断是否能够强制转换
        if(animal instanceof Cat) {}
        ```
1. 标识符：就是所有定义的东西的名字。有类名/变量名/方法名
     1. 开头：字母、$、下划线
     1. 组成：字母、$、下划线、数字
     1. 特点：大小写敏感、类首字母大写/驼峰法
1. 修饰符： 修饰类、方法和变量
     1. 访问修饰符：可以不使用，默认为default
        - 分类
          1. private：本类可见。类和接口不能声明为private，一旦声明私有只能通过getter和setter被外部操作。作用：隐藏类的实现细节和保护类的数据
          1. default：其他类和子类不可见
          1. protected：其他类不可见。类和接口不能声明为protected，类的方法和全局变量可以，接口的方法和全局变量不行
          1. public：所有类可见。main必须是public的，否则解释器不能运行此类
        - 继承：只能往上改，public必须为public，protected为protected或public
     1. 其他修饰符：
        - final：修饰的类不能被继承，修饰的方法不能被重载，修饰的变量为常量不能修改
        - static：创建类变量和类方法
        - interface：创建接口
        - abstract：创建抽象类和抽象方法
        - transient：即对象变量持久化跳过修饰符，只修饰变量，不修饰方法和类。被修饰的变量和静态变量不能被序列化。`public transient int limit = 55;`
        - strictfp：浮点数使用严格规则
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
1. 运算符
   - 分类
     1. 位：&    |    ~(非)    ^(异或)    ~(逐位取反)    <<(按位左移固定位数)    >>    >>>("无符号"右移运算)    >>>
     1. 逻辑： && || !
     1. 算术： 加减乘除    -取反    %取余    ++自增    --自减
     1. 比较： > < >= <= == !=
     1. 赋值： =    +=    -=    \*=    /=    %=    <<=(x=x<<y)    >>=    >>>=    &=(x=x&y)    |=    ^=
     1. 字符串连接：+
     1. 类型转换：(强转类型)
     1. 条件： ? :
     1. instanceof：检查对象是否是类/接口类型
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
     1. ^ 异或：有且仅有一个才行。java有短路执行特性，即只执行一部分
1. 引号：单引号是char类型只能是一个字符或Unicode字符，双引号是String类型
1. 注释和javadoc、注解
   - 注释
     1. 特点：注释和空行都会被java编译器忽略
     1. 分类：// 单行注释、/\* \*/文档注释、/\* \* \*/多行注释
   - javadoc标签
     1. 举例
        ```Java
        @author
        @version
        @param
        @serial 说明序列化属性
        @exception 对可能的异常的说明
        @link 链接指示
        @see 参考转向
        @return
        ```
     1. 提取Java注释：`javadoc -d doc hello.java`
   - 注解：Annotation
1. 常量
   - 理解：程序运行时，不会修改的量。一旦定义，不许修改。通常大写
   - 定义：
        ```Java
        // 使用final关键字定义
        final String LOVE = "imooc";
        ```
   - 好处：可提高程序可维护性。即避免命名不规范等导致的问题
1. 变量
   - 理解：使用前必须先声明
   - 定义:
    ```Java
    // 声明并赋值
    int z= 0;
    // 先声明，后赋值   
    int z;
    z= 11;
    // 使用
    int age = 0;
    System.out.println(age);
    ```
   - 分类：
     1. 全局变量：即成员变量，或者叫实例变量，类中共享的变量
     1. 局部变量：方法中定义的变量。一个方法中局部变量不能重名，局部比全局的优先级高，java会给全局变量定义初始值(定义不赋值)，不会给局部定义
     1. 类变量：即静态变量。在构造方法和语句块之外。属于类，所有实现的对象共享只有一份
        ```Java
        // 声明静态变量
        protected static String name = "haha";
        // 声明静态常量
        public static final String A = "666";
        // 使用
        类名.name;(类中)/name;(类外)
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
                // 执行;break;
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
        // foreach类型
        List<String> list = new ArrayList<String>(); // 数组类
        for(String item : list){
            System.out.println("循环元素：" + item);
        }
        Map<String, String> map = new HashMap<String, String>(); // 非数组类
        for(Entry<String, String> item : map.entrySet()){
            item.getKey();
            item.getValue());
        }
        // 循环控制
        break;
        continue;
        ```
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
   - Date的方法
     1. alter()/before()：是否在日期之前/之后
     1. clone()：返回副本
     1. compareTo()：和日期对比。相同为0，在指定之前为负，之后为后
     1. equals()：对比是否相同
     1. getTime()：获得时间戳
     1. hashCode()：此对象哈希值
     1. setTime()：用时间戳设置时间
     1. toString()：转换Date为String
   - SimpleDateFormat类
        ```Java   
        // 格式化时期显示
        Date dNow = new Date();
        SimpleDateFormat ft = new SimpleDateFormat("E yyyy.MM.dd 'at' hh:mm:ss a zzz");
        ft.format(dNow)
        // 解析字符串为时间
        SimpleDateFormat ft = new SimpleDateFormat("yyyy-MM-dd");
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
   - 理解：Java.io包几乎包含所有操作输入/输出的类。流可以理解为一个序列的数据
   - 字节流：FileInputStream/FileOutputStream
   - 字符流：FileReader/FileWriter，一般读写两个字节
   - 标准流：
     1. Standard Input：System.in
     1. Standard Output：System.out
     1. Standard Error：System.err
   - 控制台输入/输出：
     1. System.in、Scanner类：输入
        - 方法一
        ```Java
        // 由System.in完成，在BufferedReader对象中创建字符流
        BufferedReader br = new BufferedReader(new InputStreamReader(System.in));
        //读取字符
        do {
            c = (char)br.read();
            System.out.println(c);
        } while(c != 'q');
        String str = br.readLine(); // 读取字符串
        ```
        - 方法二
        ```Java
        // Scanner类，jdk5之后可用获得输入
        Scanner s = new Scanner(System.in);
        if(scan.hasNext()){
            String str1 = scan.next();
            System.out.println("输入的数据为："+str1);
        }
        //或者
        if(scan.hasNextLine()){
            String str2 = scan.nextLine();
            System.out.println("输入的数据为："+str2);
        }
        //区别：
        next：一定读取到有效字符才结束输入，自动去掉之前空白，有效符后面的空白作为分隔符和结束符，所有不能输入空格
        nextLine：回车为结束符
        ```
     1. System.out.write()：输出
1. File
   - 读取文件：File类、FileInputStream类
     1. 创建
        ```Java
        // 创建输入流对象
        InputStream f = new FileInputStream("C:/java/hello");
        // 创建使用文件对象创建输入流对象
        File file = new File("C:/java/hello");
        InputStream f = new FileInputStream(file);
        ```
     1. 方法
        - public int available() throws IOException{}
        - public int read(byte[] r) throws IOException{}
        - public int read(int r)throws IOException{}
        - protected void finalize()throws IOException {}
        - public void close() throws IOException{}
     1. 其他输入流
        - ByteArrayInputStream
        - DataInputStream
   - 写入文件：FileOutputStream类
     1. 创建
        ```Java
        // 创建输出流对象
        OutputStream f = new FileOutputStream("C:/java/hello");
        // 创建使用文件对象创建输出流对象
        File file = new File("C:/java/hello");
        OutputStream f = new FileOutputStream(file);
        ```
     1. 方法
        - protected void finalize()throws IOException {}
        - public void write(int w)throws IOException{}
        - public void write(byte[] w)
        - public void close() throws IOException{}
     1. 其他输出流：ByteArrayOutputStream、DataOutputStream
1. 目录
   - 读取：一个目录即一个对象
    ```Java
    File d = new File(dirname);
    d.isDirectory(); // 是否是目录
    d.list(); // 列出文件和文件夹列表
    ```
   - 创建：mkdir()/mkdirs()
    ```Java
    bool mkdir() // 返回false表明已存在或父级目录不存在
    bool mkdirs() // 递归创建文件夹
    // java自动识别win和unit系统的分隔符
    // 例子
    String dirname = "/tmp/user/java/bin";
    File d = new File(dirname);
    d.mkdirs();
    ```
   - 删除文件/目录：delete()
    ```Java
    File folder = new File("/tmp/java/test");
    String[] entries = folder.list();
    for(String s: entries){
        File currentFile = new File(folder.getPath(),s);
        currentFile.delete();
    }
    ```
1. 错误和异常
   - 认识：错误和异常是不同的，Throwable是老祖宗，有两个子类：Exception和Error。所有异常类都是Exception的子类
   - 错误： `java.lang.Error`
   - 异常
     1. 分类
        - 检查性异常类：Exception
        - 运行时异常类：RuntimeException
     1. 捕获异常：catch语句包含异常的声明，定义捕获哪种类型的异常
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
        }catch(FileNotFoundException f) { //Not valid
            f.printStackTrace();
            return -1;
        }
        ```
     1. 抛出异常：throw
        ```Java
        throw new RemoteException();
        ```
     1. 自定义异常
        ```Java
        // 声明异常类
        class MyException extends Exception/RuntimeException{}
        ```
1. 正则表达式
   - 理解：定义了字符串的模式。Java的和Perl类似。存于java.util.regex包
   - 主要类
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
### Java类库
1. Java类库，常见的包
   - java.lang：语言包
     1. 数据类型包装类
     1. 字符处理类
        - String类
        - StringBuffer类
     1. Math/Character/Date：数学日期类
     1. Object：类，所有类都继承，唯一没有父类的类
     1. 操作类
        - Class类(反射类)
        - ClassLoader类
     1. Process：过程类
     1. 系统和运行类
        - System类
        - Runtime类
     1. 错误和异常处理类
        - Throwable
        - Exception
        - Error
     1. 线程类
        - Thread类
        - TreadDeath
        - Runnable类
   - java.util：实用包
     1. Random/UUID：随机数/UUID类
     1. 数据结构类
        - Vector：向量类
        - Stack：栈类
        - HashTable：散列表类
        - LinkedList：链表类
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
1. 包装类
   - 定义：将内置数据类型作为当做对象使用。都是抽象类Number的子类，属于java.lang包
   - 分类
     1. Byte、Integer、Short、Long、Float、Double
        ```Java
        // 内置数据类型
        int a = 5000;
        // 包装类
        Integer x = 5;
        ```
     1. Character、Boolean
        - 定义：是char的包装类，对单个字符进行操作，包装了一个char类型的对象
        - 示例：
            ```Java
            char ch = 'a'; // char数据类型
            char uniChar = '\u039A'; // unicode形式的char数据类型
            char[] charArray ={ 'a', 'b', 'c', 'd', 'e' }; // 字符数组
            Character a = new Character('a'); //Character类对象
            ```
        - 常用方法：
           1. isLetter()：是否一字母
           1. isDigit()：是否一数字字符
           1. isWhitespace()：是否空格
           1. isUpperCase/LowerCase()：是否大、小写字母
           1. toUpperCase/toLowerCase()：设置大、小写
           1. toString()：返回字符的字符串形式
   - 特点：包装类和基本类型可以自动转换，叫做自动封箱和自动解封
        ```Java
        // 内置数据类型
        int a = 5000;
        // 包装类
        Integer x = 5; //自动封箱
        int x1 = x; //自动解封
        ```
1. String
   - 理解：java使用String类来创建和操作字符串，不是8种基本类型，是特殊的对象，默认值是null
   - 特点
     1. 有11个构造方法
     1. 字符串的不变性：String对象创建后不可修改，所谓的修改就是创建了新的对象，指向了不同的空间
     1. 一旦创建不可改变，如果有很多修改，使用StringBuffer和StringBuilder
   - 创建
        ```Java
        String s1 = "aaa";
        String s2 = new Stirng();
        String s3 = new String("aaa");
        // 提供一个字符数组参数
        char[] helloArray = { 'r', 'u', 'n', 'o', 'o', 'b'};
        String helloString = new String(helloArray); // 输出runoob
        // 字符串的比较
        s1 == s2 // false
        s1.equqls(s2); // true
        ```
   - 方法
     1. int length()：长度
     1. concat()：连接
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
1. StringBuilder
   - 理解：同StringBuffer，但不是线程安全的，即不能同步访问。更快，建议使用
   - 方法
     1. append
     1. insert
     1. toString
     1. length
   - 例子
    ```Java
    productName = new StringBuilder().append("%").append(productName).append("%").toString();
    ```
1. StringBuffer
   - 理解：对字符串进行修改时用到，能够被修改并且不产生新对象。如果要求线程安全，则必须使用StringBuffer
   - 方法
     1. append()：追加字符串`StringBuffer append(String str)`
     1. reverse()：以反转形式取代`StringBuffer reverse(StringBuffer sb)`
     1. delete()：删除字符串中某些`StringBuffer delete(int start, int end)`
     1. insert()：插入`StringBuffer insert(int offset, int )`
     1. replace
1. Math类
   - 定义：提供了基本数学运算的属性和方法。如初等函数、对数、平方根和三角函数，都是静态函数
   - 示例
        ```Java
        Math.sin(Math.PI/2) // 90 度的正弦值
        ```
   - 常用方法：
     1. x.byteValue()：将Number对象转换为基本数据类型。如short/int/long/float/doubleValue();
        ```Java
        Integer x = 5;
        x.byteValue()
        ```
     1. toString()：以字符串形式返回
     1. parseInt()：将字符串解析为int类型
     1. valueOf()：返回参数的原生Number对象值。参数为原生数据类型、String。
        ```
        static Integer valueOf(int i)
        static Integer valueOf(String s)
        static Integer valueOf(String s, int radix)
        ```
     1. equals(param)：number对象是否和参数相等
        ```Java
        Integer x = 5;
        Integer y = 5;
        System.out.println(x.equals(y));
        ```
     1. compareTo(param)：将number对象和参数比较。同类型数据比较，返回值：0相等、小于参数-1、大于1
     1. abs()：绝对值
     1. ceil、floor、rint()：对整形变量向左、右取整、最接近的整数，返回double类型
     1. round()：返回最接近的int、long值
     1. min、max()：两个参数得最大小值
     1. random()：返回随机值，0到1之间，无参数
1. UUID
   - 理解：算法的核心思想是结合机器的网卡、当地时间、一个随即数来生成GUID，从理论上讲，如果一台机器每秒产生10000000个GUID，则可以保证（概率意义上）3240年不重复。java 5新增
   - 使用
   ```Java
   import java.util.UUID;
   UUID.randomUUID().toString();
   ```
1. Apache Commons包
   - commons-lang3-3.1.jar
     1. 理解：对JDK中java.lang包的补充，提供了很多Utilities工具类
     1. 使用
        - `StringUtils.isEmpty()/trim()/split()/join()` 字符串操作
        - `StringEscapeUtils.escapeCsv/escapeHtml4/escapeJava/escapeEcmaScript/escapeXml` 字符串的转义
        - `RandomStringUtils.random/randomAlphabetic/randomAlphanumeric/randomAscii` 随机数
        - `ArrayUtils.add/remove/subarray/clone/contains/indexOf/lastIndexOf/toMap/isEmpty/isNotEmpty/isSameLength/toPrimitive/toObject` 数组
        - `DateUtils.parseDate/addDays/addMonths/isSameDay/` 日期
        - `DateFormatUtils.format` 日期
   - commons-beanutils-1.8.3.jar
     1. 理解：用于操作Bean、url、Date
     1. 使用
        - `BeanUtils.getProperty/setProperty/cloneBean/describe/populate/getArrayProperty/getIndexedProperty/getMappedProperty/getProperty/getNestedProperty` Bean
        - `url.getProtocol/getHost/getPath` url
        - `ConvertUtils.register(converter, Date.class/String.class);` ConvertUtils
        - Base64
        - StringHelper
### 面向对象
1. 封装/继承/多态
   - 封装：将类的实现信息隐藏起来，不能让外部直接访问，而是通过类提供的方法来访问
     1. 封装的好处：安全、保护屏障，隐藏类实现细节，适当的封装更容易修改和实现
     1. 封装的步骤：修改可见性添加修饰符——创建getter/setter方法——getter/setter设置控制语句
     1. 内部类
        - 定义：就是一个类中定义的类，对应的是外部类
        - 作用
          1. 提供了更好的封装，不允许其他类访问该类
          1. 内部类可以访问外部类的所有数据，包括私有数据，不受访问修饰符影响
        - 分类
          1. 成员内部类
            ```Java
            // 即普通内部类
            Inner i= o.new Inner(); // 调用方法，o为外部类，不能直接实例化内部类
            Outer.this.method(); // 内部类调用外部类方法，外部类不能直接调用内部类的对象，需要实例化内部类
            ```
          1. 静态内部类
             - 静态内部类可以直接访问外部类的静态成员和静态方法
             - 可以直接访问/调用与内部类静态成员名/方法名不相同的外部类成员/方法，相同需要加上类名
             - 可以直接创建静态内部类的实例
          1. 方法内部类
             - 即定义在外部类方法中的内部类，不能在当前方法之外的地方使用，因此方法内部类不能使用访问控制符和static修饰符
          1. 匿名内部类
             - 价值：经常配合接口使用，关注实现而不关注名称
             - 使用：直接new一个接口，实现其方法
             ```Java
             new myInterface(){
                 public void method() {}
             }.method();
             ```
   - 继承：extends，可以重用父类/超类的方法和属性
     - 特点：拥有父类非private的属性、方法，可以对父类扩展，也可以覆写父类方法。只支持类的单继承，但支持接口间的多继承
     - 继承的初始化顺序：父类属性初始化——父类构造方法——子类属性初始化——子类构造方法
     - 关于构造方法：子类不能继承父类的构造器，必须调用父类的构造方法，有默认和显式调用两种。父类构造器带参数得，要用super方法显式调用并匹配相应参数、并且在子类构造方法的第一行，父类的默认构造器(没有任何参数)系统自动调用，都没有的报错
     - 关键字
       1. extends：继承
            ```
            public class B extends A
            ```
       1. abstract：声明抽象类
            ```Java
            abstract class A{}
            class B extends A{}
            ```
       1. interface：声明接口
       1. implements：用于实现接口
            ```Java
            public interface A {}
            public interface B {}
            public class C implements A,B {}
            ```
       1. super和this：super实现对父类成员的访问，代表父类，this是自己的引用
            ```Java
            super.move(); // 调用父类方法   
            this.name;
            this.move();
            ```                        
       1. final
            ```Java
            // 修饰属性：不能被修改
            // 修饰方法：不能被重写
            // 修饰类：不能被继承
            ```
       1. Object：所有类默认继承Object类
          - 方法
            1. toString，返回对象hash(对象地址字符串)
            1. equals，比较对象的引用是否指向同一块内存地址
   - 多态：对象的多种形态。就是同一个接口，使用不同实例而执行不同操作
     - 存在条件：继承————>重写————>父类引用指向子类对象
     - 实现：重写、接口、抽象类和抽象方法
     - 优点：使程序有良好的扩展性、灵活性
     - 分类
       1. 引用多态
            ```Java
            Animal obj1 = new Animal(); // 指向本类
            Animal obj2 = new Dog(); // 指向子类
            Dog obj3 = new Animal(); // 这是错误的
            ```
       1. 方法多态：能使用子类或者本类的方法
          - override重写：对父类允许访问的方法重写，外壳不变，核心重写
            - 遵循的规则
               1. 返回类型和形参不能改变
               1. 不能抛出更宽泛的异常
               1. 访问权限不能更低，异常的子类可以
               1. 声明为static的方法不能被重写，但是可以被再次声明
               1. 声明为final的方法不能被重写
          - overload重载：在类中存在方法名字相同，参数个数或类型不同的多个方法叫重载。Java可以根据参数确定调用相应的方法。常用于构造器的重载
            - 重载的规则：参数不一样、顺序和类型都生效，返回类型和修饰符可不一样，检查异常可扩展，类中和子类中都可重载
     - 虚拟方法：使用多态调用方法时(即实例化的对象为父类的对象)，会先检查父级有没有，没有就报错，但最终执行的是子类的方法，叫做虚方法
        ```Java
        Salary s = new Salary("员工 A", "北京");
        Employee e = new Salary("员工 B", "上海"); // 实例化了父类的对象
        s.mailCheck();
        e.mailCheck(); // 先实例子类，再实例父类
        ```
1. 属性
   - 全局变量：即成员变量
   - 局部变量
   - 类变量：即静态变量
1. 方法
   - 特点
     1. 返回值类型为void的不能有return
     1. 参数：参数类型和参数名组成，空格隔开
     1. 定义方法时有形参，调用方法时传递实参
   - 定义：以字母、下划线、美元符开头，可包括数字
    ```Java
    public String show(String str) { return str; }
    ```
   - 分类
     1. 普通
     1. 静态
        - 定义
            ```java
            public static void 方法名() {}
            ```
        - 使用：类.方法(); 或者 对象.方法();
     1. 构造：和类名相同，没有返回值，用于初始化对象。所有都默认有一个构造方法。也就是构造函数，没有返回类型，也不能定义为void/方法类型，方法名和类名相同。只要作用是完成类的初始化工作。创建对象至少调用一个构造方法，如果没有显式定义类的构造方法，java编译器会为该类提供默认构造方法。一个类可以有多个构造方法，只是参数不同
        - 定义
            ```Java
            // 构造方法的定义
            public 类名(参数) {}
            ```
        - 重载：参数不同的构造方法，java实例化时会自动选择不同的构造方法
     1. 析构
        ```java     
        // 析构方法
        protected void finalize(){}
        ```
   - 可变参数：Varargs，jdk1.5开始，适用于参数个数不确定，类型确定的情况
     1. 定义
        ```Java
        public static void printMax(int x, double... paramName) {
            int sum = x;
            for(int i=0;i<paramName.length;i++){
                sum += paramName[i];
            }
        }
        ```
     1. 特点
        - 只能出现在参数列表的最后
        - 位于变量类型和变量名之间，前后有无空格都可以
        - 调用可变参数的方法时，编译器为该可变参数隐含创建一个数组，在方法体中以数组的形式访问可变参数
   - 命令行参数：程序运行时传递参数给main()实现
1. 代码块
   - 分类
     1. 普通代码块：就是普通方法里边的大括号
     1. 构造代码块：类中定义，无任何修饰符的大括号
        ```Java
        public class className{
            {
                System.out.println("构造代码块");
            }
        }
        ```
     1. 静态代码块：使用`static`修饰的代码块，用于初始化静态属性
        ```Java
        public class className{
            static {
                System.out.println("构造代码块");
            }
        }
        ```
     1. 同步代码块：表示同一时间只能有一个线程进入到该方法块中，是一种多线程保护机制。多线程环境下，对共享数据进行读写操作是需要互斥进行的，否则会导致数据的不一致性。冗长的方法中，其实只有一小段代码需要访问共享资源，这时使用同步块，就只将这小段代码裹在synchronized  block，既能够实现同步访问，也能够减少同步引入的开销
        ```Java
        public class className{
            public void methodName() {
                synchronized(obj) {
                    System.out.println("构造代码块");
                }
            }
        }
        ```
   - 特点
     1. 执行顺序：静态代码块>mian方法>构造代码块>构造方法
     1. 构造代码块每次创建对象时执行
     1. 静态代码块在编译时只执行一次，不能存在于任何方法体内，不能直接访问静态实例变量和实例方法，需要通过类的实例对象来访问，静态初始化块只能给静态变量赋值
     1. 同步代码块须写在方法中
1. 对象
   - 访问属性和方法：对象名.变量; 对象名.方法();
   - 复制
     1. 浅表复制：自带，指的是同一个对象
     1. 深表复制：另起一个对象
   - 对象序列化
     1. 理解：JVM独立的，可进行可序列化和反序列化
     1. 对象被序列化成功的条件：
        - 必须实现java.io.Serializable对象
        - 类的所有属性必须是可序列化的，即不被transient修饰或者不是静态变量
     1. 操作
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
     1. 相关类：Externalizable，表示没有任何东西可以自动序列化，需要在writeExternal方法中进行手工指定
1. 类：由方法和属性组成
    ```Java
    package com.imooc // 包名
    public/protected/private class 类名{}
    ```
1. 抽象类
   - 理解：为了对类进行扩充，除了不能被实例化，属性、方法、构造器和权限访问和类都一样，必须继承使用
   - 价值
     1. 父类约束子类应该有哪些方法，但是不知道如何实现
     1. 抽象出来，避免子类设计的随意性
   - 特点：有抽象方法的一定是抽象类，抽象类中不一定包含抽象方法。子类必须重写全部抽象方法，或者声明自己为抽象类，否则不能被实例化。构造方法和类方法(static)不能申明为抽象方法
   - 定义和继承使用
        ```Java
        // 定义
        abstract class Animal{
            private double leng;
            public abstract void work();
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
1. 接口：全局变量和抽象方法的集合，规定了子类必须提供某些方法，子类通过实现接口来实现所有的抽象方法。接口不是类，但是编写方式和类很像，接口不是被类继承，而是被实现。可理解为对象间通信的协议
   - 特点
     1. 本身：不能被实例化，没有构造方法。接口可以多继承，所有参与继承的方法都要实现
     1. 属性：每个属性都被指定为public static final
     1. 方法：
        - 接口类和方法都是隐式抽象的，只能是public，接口中不能实现方法，只能在实现类中实现
        - 除非是抽象类，否则子类必须全部实现接口里的所有方法
        - 实现接口方法时，不能抛出强制性异常，只能在接口或继承接口的抽象类中抛出
        - 重写方法时保持一致的方法名，相同或兼容的返回值
     1. extends要在implements前边
     1. 可以不用abstract，默认接口和方法都会加上
   - 声明：interface
       ```Java
        public/protected/private interface 接口名称 [extends 父接口1，父接口2] {
            // 多个常量
            // 抽象方法
        }
       ```
   - 实现：implements
       ```Java
       public class Dog implements Animal{}
       ```
   - 标记接口：没有任何属性和方法的接口，仅表明它的类属于一个特定的类型
1. 包
   - 作用：package，解决文件名冲突，对类和接口归类，方便查找和使用
   - 组成：类、接口、枚举和注释
   - 声明
        ```Java
        package com.imooc.myClass(包名) 包名1 包名2;
        public class Something{}
        // 路径为：com.imooc.myClass/Something
        ```
   - 使用 `import com.imooc.*`
   - 特点：
     1. 默认引入lang包，不需要再次import
     1. 包采用了树形目录的存储方式，不同包中的类名可以相同。com.runoob.test的目录结构为`CLASSPATH\com\runoob\test\类名`
     1. 包也限定了访问权限，有包的权限才能访问包中的类
     1. 可以定义自己的包
