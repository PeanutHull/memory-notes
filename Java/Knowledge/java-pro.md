### 数据结构
1. 总结
   - 枚举Enum：只能是预先设置好的值
   - 数组Array————位集合BitSet：长度不能改变
   - 向量Vector————栈Stack：长度可以改变
   - 字典Dictionary————哈希表Hashtable————属性Properties：键映射到值的数据结构，一个抽象类，一个实现了Map接口
1. 数组：Array，存储在堆上的对象，长度是固定的，用来存储固定数量的多个同类型变量
   - 定义
        ```Java
        数据类型 数组名[] // 或者 数据类型[] 数组名
        // 举例
        int[] myArray; // 声明
        myArray = new int[size]; // 指定数组长度
        int[] myArray = new int[size]; // 声明并指定长度
        int[] myArray = {78,93}; // 声明并填充内容
        int myArray[] = {78,93}; // 声明并填充内容
        int[] myArray = new int(){78,93}; // 声明并填充内容
        ```
   - 处理：
        ```Java
        // 访问
        myArray[1];
        // 赋值
        myArray[1] = 1;
        // 长度
        myArray.length();
        // 遍历
        for (int i = 0; i < myArray.length; i++) {} // 内循环处理
        for (double element: myArray) {} // foreach处理
        public static void printArray(int[] myArray) {} // 作为参数传递
        ```
   - 二维数组
     1. 声明：`int 数组名[][] = new int[行数][列数]`
        ```Java
        // 每个数组内容的列数可以不同
        int num[][] = new int[2][];
        num[0] = new int[2];
        num[1] = new int[3];
        // 访问
        num[0][0]
        ```
   - Arrays类：java提供的工具类，包为java.util.Arrays ，包含排序、搜索等方法
     1. 排序
        ```Java
        import java.util.Arrays;
        Arrays.sort(scores);
        ```
     1. 查找：binarySearch：`int binarySearch(Obj[] a, Obj key)`
     1. 比较：equals：`boolean equals(long[] a, long[] a2)`
     1. Arrays.toString(Array);
1. 位集合：（BitSet）位集合类实现了一组可以单独设置和清除的位或标志。该类处理一组布尔值的时候很有用。创建一种特殊类型的数组来保存值，数组大小随需要增加
   - 定义：
        ```Java
        BitSet bits1 = new BitSet(16);
        // 有两个构造方法
        BitSet(); // 创建一个默认对象
        BitSet(int size); // 允许用户指定初始大小，默认0
        ```
   - 使用：`bits1.set(i);`
   - 方法：实现了Cloneable接口中定义的方法
     1. `void and(BitSet set)` // 逻辑与操作
     1. `void andNot(BitSet set)` // 清除此BitSet中所有的位
     1. `int cardinality()` // 返回为true的位数
     1. `void clear()` // 全部位置为false
     1. `void clear(int index)` // 指定位置为false
     1. `void clear(int startIndex, int endIndex)` // 指定位置为false
     1. `boolean get(int index)` // 返回索引处位值
     1. `BitSet get(int startIndex, int endIndex)` // 返回索引处位值
1. 向量：（Vector）向量类和传统数组非常相似，Vector能根据需要动态变化。和数组一样元素能通过索引访问。最主要好处就是在创建对象时不必指定大小，会动态变化。适用在数组要动态变化的情况下
   - 定义
        ```Java
        Vector()
        Vector(int size) // 指定大小
        Vector(int size,int incr) // 用incr确定向量每次增加的元素数目
        Vector(Collection c) // 包含集合C的向量
        // 示例
        Vector v = new Vector(3, 2);
        v.size();
        v.addElement(new Integer(1));
        // 转换为枚举
        Enumeration vEnum = v.elements();
        while(vEnum.hasMoreElements()) {
            vEnum.nextElement() + " ");
        }
        ```
   - 方法
     1. `void add(int index, Object element)` // 添加元素
     1. `boolean add(Object o)` // 添加到末尾
     1. `boolean addAll(int index, Collection c)` // 指定位置插入集合中所有值
     1. `int capacity()` // 返回当前容量
   - 特点：是同步访问的，包含传统方法，和ArrayList类似，不属于集合框架
1. 栈：（Stack）实现了先进后出的数据结构。是Vector的子类
   - 定义
        ```Java
        // 示例
        Stack st = new Stack();
        st.push(new Integer(1));
        ```
   - 方法
     1. `boolean empty()` // 是否为空
     1. `Object peek()` // 查看顶部对象，不移除
     1. `Object pop( )` // 返回顶部并移除
     1. `Object push(Object element)` // 把元素压入顶部
     1. `int search(Object element)` // 对象在堆栈的位置，1为基数
1. 枚举：（Enumeration）枚举接口java5.0引入，限制变量只能是预先设定好的值，使用枚举可以减少代码中bug。已经被迭代器取代，很少使用。本质是类，取代定义很多的变量`public static final`，父类`java.lang.Enum<E>`
   - 包含：变量、方法、构造函数
   - 特点：可以在任何地方声明枚举
   - 定义
        ```Java
        // 定义枚举
        public enum Color {
            RED, GREEN, BLANK, YELLOW 
        }
        // 使用
        Color.RED
        Color.RED.equals(color);
        ```
   - 自定义函数：
        ```Java
        public enum Color {
            RED("红色", 1), GREEN("绿色", 2), BLANK("白色", 3), YELLO("黄色", 4);
            private String name ;
            private int index ;
            private Color( String name, int index ){
                this.name = name ;
                this.index = index ;
            }
            public String getName/getIndex() {
                return name;
            }
            public void setName/setIndex(String name) {
                this.name = name;
            }
        }
        // 使用
        Color.RED.getName();
        ```
1. 字典：（Dictionary）字典类是抽象类，定义键映射到值的数据结构。通过键而不是整数索引来访问数据时使用。因为是抽象类，所以只提供数据结构，没有提供具体实现。存储键/值对，作用和Map类相似
   - 定义
   - 方法
     1. `boolean isEmpty()` // 是否空字典
     1. `int size()` // 数量
     1. `Object get(Object key)` // 返回键对应的值
     1. `Object put(Object key, Object value)` // 插入或更新
     1. `Object remove(Object key)` // 删除
     1. `Enumeration keys()` // 返回字典中键的枚举
     1. `Enumeration elements()` // 返回字典中值的枚举
1. 哈希表：（Hashtable）Hashtable类提供了用户定义键结构的组织数据的手段，哈希表的键的具体含义取决于使用场景和包含的数据。是原始的java.util的一部分，是Dictionary的具体实现，是其子类。Java 2的Hashtable实现了Map接口，所以现在集成到了集合框架中，和HashMap类似，但是支持同步。哈希表的键经过哈希处理得到的散列码用作值的索引
   - 定义：
        ```Java
        Hashtable()
        Hashtable(int size)
        Hashtable(int size,float fillRatio) // fillRatio指定填充比例(0.0~1.0)，决定了重新调整大小的充满程度
        Hashtable(Map m) // 以M中元素为初始化元素的哈希表，哈希表的容量被设置为M的两倍
        ```
   - 实例
        ```Java
        Hashtable balance = new Hashtable();
        balance.put("Zara", new Double(3434.34));
        ```
   - 方法
     1. `Object get(Object key)` // 返回值
     1. `Object put(Object key, Object value)` // 添加或更新
     1. `Object remove(Object key)` // 删除
     1. 
     1. `boolean contains(Object value)` // 此映射表中是否存在与指定值关联的键
     1. `boolean containsKey(Object key)` // 是否存在键
     1. `boolean containsValue(Object value)` // 是否存在值
     1. `boolean isEmpty()` // 是否为空
     1. `int size()` // 键的数量
     1. 
     1. `Enumeration keys()` // 返回键的枚举
     1. `Enumeration elements()` // 返回值的枚举
     1. `String toString()` // 返回哈希对象的字符串表示形式
     1. 
     1. `void clear( )` // 清空
     1. `Object clone()` // 创建浅表副本
     1. `void rehash()` // 增加此哈希表的容量并在内部对其进行重组，以便更有效地容纳和访问其元素
1. 属性：（Properties）Properties类是Hashtable的子类，表示一个持久的属性集。属性列表中每个键和对应值都是字符串。获取环境变量时它作为System.getProperties()的返回值
   - 定义
        ```Java
        Properties()
        Properties(Properties propDefault)
        // 定义如下实例变量，这个变量有Properties对象相关的默认属性列表
        Properties defaults;
        ```
   - 实例
        ```Java
        Properties capitals = new Properties();
        capitals.put("aa", "11");
        // 读取配置
        InputStream in = new BufferedInputStream(new FileInputStream(new File(basePath)));
        Properties prop = new Properties();
        prop.load(in);
        prop.getProperty("path");
        ```
   - 方法
     1. `load(InputStream streamIn)` // 从输入流中读取属性列表
     1. `propertyNames( )` // 按简单的面向行的格式从输入字符流中读取属性列表
     1. `list(PrintStream streamOut/PrintWriter streamOut)` // 属性列表输出流
     1. `getProperty(String key)` // 搜索属性
     1. `getProperty(String key, String defaultProperty)` // 搜索属性
     1. `setProperty(String key, String value)` // 调用Hashtable的put方法
     1. `store(OutputStream streamOut, String description)` // 输出配置
     1. `clear()` // 清楚装载的配置
### 集合框架
1. 总结
   - ArrayList 排列有序可重复
   - HashMap 键值对
   - HashSet 排列无序不可重复
1. 简介：是一种工具类，具有共同属性的数据集合，是盛装其他对象的容器，Java2引入，是用来代表/操作集合的统一架构，集合框架围绕一组标准接口而设计，可以直接使用接口的标准实现，常用有ArrayList、HashMap，HashSet不常用。
1. 组成
   - Collection：内部存储的都是一个个的对象，单个的
     1. List：序列，排列有序可重复
        - ArrayList：数组序列，底层由数组实现
     1. Queue：队列，排列有序可重复
        - LinkedList：链表，同时也是List的实现类
     1. Set：集，无序不可重复
        - HashSet：哈希集
   - Map：包含了很多的映射，一对的，有众多子接口
     1. HashMap：哈希map，基于hash表实现
   - 工具接口和类
     1. Collections：工具类，最常用sort方法
     1. Comparable接口：默认比较规则
     1. Comparator接口：临时比较规则
1. Collection
   - List：查询效率高，插入和删除低，因为引起其他元素改变。Set查询效率低，插入和删除效率高
     1. `AbstractList`：继承于AbstractCollection，实现了大部分List接口。子类AbstractSequentialList提供对数据元素的链式访问，不是随机访问
     1. `ArrayList`：实现可变大小的数组，线程不同步
     1. `LinkedList`：实现了List接口，允许null存在。用于创建链表数据结构，查找效率低。没有同步方法，多线程需要自己实现访问同步，解决方案：创建List时候构造一个同步的List。
   - Set：没有get方法，想要访问只能通过foreach和iterator方法遍历，而且每次迭代的结果都不一样。Set中不论添加多少次，因为不能重复，所以只能有一个
     1. `AbstractSet`：继承于AbstractCollection，实现大部分Set接口
     1. `HashSet`：不允许元素重复，不保证元素顺序，最多有一个null值
     1. `LinkedHashSet`：可预知迭代顺序的Set接口的哈希表和链接列表实现
     1. `TreeSet`：实现Set接口，实现排序等功能
1. Map：映射，用来存储键值对
   - 特点：通过key查找value。内部以映射存储数据，就是Entry(键值对)类的实例，key和value可以是任意的对象。key不可重复，value可以。支持泛型：`Map<k,v>`
   - 组成
     1. `AbstractMap`：实现大部分Map接口
     1. `HashMap`：是一个散列表，访问速度很快，线程不同步，键最多一个null
        - `WeakHashMap`：弱秘钥的哈希表
        - `LinkedHashMap`：按自然顺序对元素排序
        - `IdentityHashMap`：比较文档时使用引用相等
     1. `TreeMap`：使用一棵树
     1. `synchronizedMap`：具有线程同步的能力
   - 方法
     1. `Object get(Object k)` // 通过键返回值，不存在为null
     1. `Object put(Object k, Object v)` // 更新或添加
     1. `Object remove(Object k)` // 通过键删除
     1. `void putAll(Map m)` // 一个映射复制到另一个映射
     1. `boolean equals(Object obj)` // 比价指定的对象和此映射是否相同
     1. `boolean containsKey(Object k)` // 是否存在指定键
     1. `boolean containsValue(Object v)` // 是否存在指定值
     1. `int size( )` // 返回关系数量
     1. `boolean isEmpty()` // 是否为空
     1. `void clear( )` // 删除所有映射关系
     1. `Set keySet( )` // 返回键的Set视图
     1. `Collection values( )` // 返回值的Collection视图
     1. `Set entrySet( )` // 返回映射关系的Set视图
     1. `int hashCode()` // 返回映射的哈希码值
   - 实例
    ```Java
    Map map = Maps.newHashMap();
    ```
1. 工具类
   - Java.util.Collections
1. 迭代器：Iterator，用来遍历集合中的元素，类似for和增强for，继承自Iterator接口或继承自ListIterator
   - 遍历ArrayList
        ```Java
        // for循环
        for(int i=0;i<list.size();i++) {}
        // foreach
        for (String str : list) {}
        // 链表转为数组遍历
        String[] strArray=new String[list.size()];
        list.toArray(strArray);
        for(int i=0;i<strArray.length;i++) {}
        // 迭代器遍历
        Iterator<String> ite=list.iterator();
        while(ite.hasNext()) {}
        ```
   - 遍历Map
        ```Java
        // 通过Map.keySet遍历
        for (String key : map.keySet()) {
            tmpKey = key
            tmpValue = map.get(key));
        }
        // 通过Map.values()遍历所有的value，但不能遍历key
        for (String v : map.values()) {
            tmpValue = v;
        }
        // 通过Map.entrySet使用iterator遍历
        Iterator<Map.Entry<String, String>> it = map.entrySet().iterator();
        while (it.hasNext()) {
            Map.Entry<String, String> entry = it.next();
            tmpKey = entry.getKey();
            tmpValue = entry.getValue();
        }
        // 推荐，尤其容量大时。通过Map.entrySet遍历
        for (Map.Entry<String, String> entry : map.entrySet()) {
            tmpKey = entry.getKey();
            tmpValue = entry.getValue();
        }
        ```
1. 比较器：Comparator，用来精确定义排序规则，以不同方式排序集合
1. 内部组成
     1. 接口
        - `Collection`：最基本集合接口，java不提供直接继承自Collection的类来使用，只提供继承Collection的子接口，如List和Set
        - `List`：是有序的，精确控制每个元素的位置。通过索引(类似数组的小标)访问其中的元素，允许有相同元素
        - `Set`：无序的，与Collection完全一样，但是行为上不同。不能有相同元素，访问集合中的元素只能根据元素本身来访问。子接口SortedSet接口保存有序集合
        - `Map`：唯一键映射到值。Map.Entry描述Map中的键值对，是Map的内部类。子接口SortedMap，使key保持升序
        - `Enumeration`：一个传统的接口和数据定义方法，已被迭代器取代
     1. 集合类：即接口的实现类
        - `AbstractCollection`：实现了大部分的集合接口
        - 其他具体的：ArrayList、HashMap、HashSet等
     1. 集合算法：用于搜索和排序，被定义为集合类的静态方法，定义了三个静态变量：EMPTY\_SET，EMPTY\_LIST，EMPTY_MAP，不可改变
### 注解
1. 理解：Java5.0引入，是一种应用于类、方法、参数、变量、构造器及包声明中的特殊修饰符。是描述数据的数据，也叫元数据。和具体业务逻辑无关
1. 价值：功能声明。XML的描述功能维护非常困难，只适用于设置很多参数，耦合代码并且声明作用需要简单直接的方法
1. 分类
   - Java SE5内置三种标准注解
     1. @Override 覆盖超类方法
     1. @Deprecated 表示弃用的代码
     1. @SuppressWarnings 关闭不当编译器警告信息
   - Servlet3.0新增
     1. `WebInitParam` 声明Servlet/过滤器的初始化参数
     1. `WebServlet` 声明一个Servlet的配置
     1. `WebFilter` 声明一个Server过滤器
     1. `WebListener` 事件声明监听器
     1. `HandlesTypes` 表示一组传递给ServletContainerInitializer的应用类
     1. `HttpConstraint`  该注解代表所有HTTP方法的应用请求的安全约束
1. 编写自定义注解
   - 元注解
     1. @Documented 注解是否将包含在JavaDoc中
     1. @Retention 什么时候使用该注解
        - RetentionPolicy.SOURCE 编译阶段丢弃
        - RetentionPolicy.CLASS 类加载时丢弃
        - RetentionPolicy.RUNTIME 始终不会丢弃
     1. @Target 注解用于什么地方
     1. @Inherited –是否允许子类继承该注解
        - ElementType.TYPE:用于描述类、接口或enum声明
        - ElementType.FIELD:用于描述实例变量
        - ElementType.METHOD
        - ElementType.PARAMETER
        - ElementType.CONSTRUCTOR
   - 反射方法
     1. `getAnnotations()` 返回该元素的所有注解
     1. `isAnnotationPresent(annotation)` 检查传入的注解是否存在于当前元素
     1. `getAnnotation(class)` 按照传入的参数获取指定类型的注解
   - 例子
        ```Java
        // 定义注解
        @Target(ElementType.METHOD)
        @Retention(RetentionPolicy.RUNTIME)
        @interface Todo {
            public enum Priority {LOW, MEDIUM, HIGH}
            public enum Status {STARTED, NOT_STARTED}
            String author() default "peanut";
            Priority priority() default Priority.LOW;
            Status status() default Status.NOT_STARTED;
        }
        // 使用注解
        @Todo(priority=Todo.Priority.MEDIUM, author="aaa", status=Todo.Status.STARTED)
        public void incompleteMethod() {}
        // 使用反射得到注解后的类信息
        Class businessLogicClass = BusinessLogic.class;
        for(Method method : businessLogicClass.getMethods()) {
            Todo todoAnnotation = (Todo)method.getAnnotation(Todo.class);
            if(todoAnnotation != null) {
                System.out.println(" Method Name : " + method.getName());
                System.out.println(" Author : " + todoAnnotation.author());
                System.out.println(" Priority : " + todoAnnotation.priority());
                System.out.println(" Status : " + todoAnnotation.status());
            }
        }
        ```
### 泛型
1. 泛型
   - 理解：为了参数化类型，JDK5引入的新特性，提供编译时的参数类型检测
   - 特点：泛型集合中的限定类型，不能使用基本数据类型，必须使用包装类
   - 泛型变量
        ```Java
        // 普通定义方式
        List list = new ArrayList();
        // 泛型变量定义方式
        List<String> list = new ArrayList<String>();
        ```
   - 泛型成员变量
        ```Java
        // Course是一个对象
        public List<Course> course; // 带有泛型的变量
        course = new ArrayList<Course>(); // 赋值带有泛型的变量
        ```
   - 泛型方法：在调用方法的时候指明泛型的具体类型，根据参数类型，泛型方法适当处理每一个方法调用
     1. 特点
        - <T>声明此方法为泛型方法，才能使用T作为返回值
        - T可以随便写为任意标识，如T、E、K、V等
     1. 定义
        ```Java
        public static <T> T genericMethod(Class<T> tClass) throws InstantiationException, IllegalAccessException{
            T instance = tClass.newInstance();
            return instance;
        }
        ```
     1. 泛型方法和可变参数
        ```java
        public <T> void printMsg(T... args){
            for(T t : args){}
        }
        ```
   - 泛型类：类后面加类型参数声明部分，在实例化该类时，必须指明泛型T的具体类型
     1. 定义
        ```Java
        public class Box<T> {
            private T t;
        }
        ```
   - 泛型接口
        ```java
        public interface Generator<T> {}
        ```
   - 类型通配符:用?代替具体的类型参数，此处?是类型实参，而不是类型形参，?也是一种实际的类型，看成所有类型的父类
        ```Java
        public static void getData(List<?> data) {}
        ```
   - 有界的类型参数
        ```java
        public static <T extends Comparable<T>> T maximum(T x, T y, T z)
        // 只接受Number及其子类型
        public static void getUperNumber(List<? extends Number> data)
        ```
   - 泛型数组
        ```java
        List<String>[] ls = new ArrayList[10];
        List<?>[] ls = new ArrayList<?>[10]; // 最后取出数据要做显式的类型转换
        List<String>[] ls = new ArrayList<String>[10]; // 这样不可以
        ```
### 反射
1. 总结
   - 获得类类型：Foo.class/foo.getClass()/Class.forName()
   - 获得实例对象：c1.newInstance()
   - 方法反射的操作：m.invoke()
1. 理解：获取类的名称、变量、方法等信息。java中只有基本数据类型和静态成员不是对象，其他都是对象。类是java.lang.Class类的对象
1. Class类的使用
   - 获得类或者实例对象
     1. Class的实例对象的获取，即得到类类型
        - `CLass c1 = Foo.class` 通过类本身的隐含静态成员变量获取类类型
        - `Class c2 = foo.getClass()` 通过实例化后的对象获取类类型，c1等于c2的，
        - `Class c3 = Class.forName('com.imooc.reflect.foo')` 通过Class类的方法
     1. 通过类类型获取实例对象
        - `Foo foo = (Foo) c1.newInstance()` 要做强制类型转换
   - 获取类的基本信息
     1. 方法
        - `c.getName()` 类名
        - `c.getSimpleName()` 不包含包名
     1. 实例
        ```java
        Class c1 = double.class;
        Class c2 = Double.class;
        Class c3 = void.class;
        ```
   - 获取成员变量的信息：成员变量也是对象，继承java.lang.reflect.Field
     1. `c.getFields()` 获取所有public的成员变量的信息
     1. `c.getDeclaredFields()` 获取自己声明的所有变量
     1. `field.getName` 成员变量的名称
     1. `field.getType()` 成员变量的类型的类类型
   - 获取方法的信息
     1. `c.getMethods()` 获取所有public的方法，包含继承来的
     1. `c.getDeclaredMethods()` 获取该类所有的自己声明的方法，忽略访问权限
     1. `method.getName()` 获取方法名
     1. `method.getReturnType()` 方法的返回值类类型
     1. `method.getParameterTypes()` 方法的参数类类型 
   - 获取构造函数的信息：构造函数继承java.lang.Constructor
     1. `c.getConstructtor()` 获取所有public的构造方法，包含继承来的
     1. `c.getDeclaredConstructtor()` 获取自己定义的所有的构造方法
     1. `constructor.getName()`
     1. `constructor.getParameterTypes()`
1. 动态加载类
   - 理解：区分编译和运行。编译时刻加载类是静态加载类，运行时加载类是动态加载类
   - 实现：将需要被加载的类都实现同一接口，用`Class.forName()`获取类类型和`newInstance()`实例化对象来动态加载类
   - 实例
    ```java
    Class c = Class.ForName(className);
    interfaceName obj = (interfaceName) c.newInstance();
    obj.method();
    ```
1. 方法的反射
   - 方法反射的操作：invoke
    ```java
    Class c = a.getClass();
    Method m = c.getMethod("methodName", Int.class, Double.class); // 跟参数类型，没有这里和下一句就不写
    m.invoke(a, 1, 1,1);
    ```
### 多线程
1. 理解：使用更小资源开销，轮候使用cpu，存在等待，线程多了因为上下文切换反而效率下降
1. 重难点
   - ThreadPoolExecutor
   - J.U.C
   - Atomic*
   - Fork/Join
1. 状态
   - 新建：Thread类及其子类建立线程对象后
   - 就绪：线程对象调用start()后，等待JVM调度器的调度
   - 运行：获取cpu资源，可以执行run方法，可以变为就绪、阻塞、死亡状态
   - 阻塞：三种阻塞类型
     1. 等待阻塞：运行中的线程执行wait()方法
     1. 同步阻塞：线程获取synchronized同步锁失败
     1. 其他阻塞：调用sleep()或join()发出io请求时，当这些结束时，线程重新进入就绪状态
   - 死亡：完成任务或者终止条件发生时
1. 优先级：整数，范围1~10，默认5，但是不能保证线程执行的顺序，非常依赖于平台
1. 创建
   - 实现Runnable接口
        ```Java
        class RunnableDemo implements Runnable {}
        ```
   - 继承Thread类
     1. 实例
        ```Java
        class ThreadDemo extends Thread {}
        ```
     1. 普通方法
          1. `public void start()` // 线程开始执行，JVM调用run方法
          1. `public void run()` // 
          1. `public void interrupt()` // 中断线程
          1. `public final boolean isAlive()` // 检测是否处于活动状态
          1. `public final void setName(String name)/setPriority(int priority)` // 设置名字、优先级
          1. `public final void setDaemon(boolean on)` // 设为守护线程或用户线程
          1. `public final void join(long millisec)` // 设置等待该线程的最长时间
     1. 静态方法
          1. `public static void yield()` // 暂停当前进程，执行其他进程
          1. `public static void sleep(long millisec)` // 毫秒数休眠
          1. `public static boolean holdsLock(Object x)` // 当且仅当当前线程在指定的对象上保持监视器锁时，才返回 true
          1. `public static Thread currentThread()` // 返回对当前正在执行的线程对象的引用
          1. `public static void dumpStack()` // 将当前线程的堆栈跟踪打印至标准错误流
   - 通过Callable和Future
        ```Java
        public class CallableThreadTest implements Callable<Integer> {
            public static void main(String[] args)  {
                CallableThreadTest ctt = new CallableThreadTest();
                FutureTask<Integer> ft = new FutureTask<>(ctt);
            }
        }
        @Override
        public Integer call() throws Exception  {
            Thread.currentThread().getName();
        }
        ```
   - 比较：使用Runnable、Callable还可以继承其他类，使用Thread，直接使用this获得当前线程
1. 概念
   - 线程控制(挂起/停止/恢复)
   - 线程同步：即任意时刻只能有一个线程同时写，可以保证数据一致
   - 线程死锁
   - 线程间通信
### 代理模式
1. 理解：代理是一种设计模式，提供了对目标对象另外的访问方式，即通过代理对象访问目标对象
   - 三方角色：用户、代理对象、目标对象。代理对象是对目标对象的扩展
1. 价值：可以在实现目标对象的基础上,增强额外的功能操作和功能扩展。不要随意修改已经写好的代码，如需修改使用代理的方式扩展该方法   
1. 分类
   - 静态代理
     1. 理解：静态代理在使用时,需要定义接口或者父类,被代理对象与代理对象一起实现相同的接口或者是继承相同父类。就是把目标对象传入代理对象实例化，然后调用相同方法，代理对象中多加了一些方法，适当时候调用目标对象的方法。就是套了一层，然后执行
     1. 特点
        - 可以在不修改目标代理前提下，实现功能拓展
        - 会产生很多代理类，要维护两份类
     1. 示例
        ```Java
        public interface IUserDao {void save();} // 接口
        public class UserDao implements IUserDao { public void save() {}} // 目标对象
        public class UserDaoProxy implements IUserDao{ // 代理对象
            private IUserDao target;
            public UserDaoProxy(IUserDao target){
                this.target=target;
            }
            public void save() {
                // 执行其他逻辑
                target.save();//执行目标对象的方法
                // 其他逻辑                
            }
        }
        // 测试类
        public static void main(String[] args) {
            // 目标对象
            UserDao target = new UserDao();
            // 代理对象,把目标对象传给代理对象,建立代理关系
            UserDaoProxy proxy = new UserDaoProxy(target);
            // 执行代理方法
            proxy.save();
        }
        ```
   - 动态代理
     1. 理解：利用API在内存中构建代理对象，也叫JDK代理,接口代理
     1. 使用
        ```Java
        代理类所在包：java.lang.reflect.Proxy
        实现方法：static Object newProxyInstance(ClassLoader loader, Class<?>[] interfaces,InvocationHandler h )
        参数：
        `ClassLoader loader` 指定当前目标对象使用类加载器
        `Class<?>[] interfaces` 目标对象实现的接口的类型
        `InvocationHandler h` 把当前执行目标对象的方法作为参数传入
        ```
     1. 特点：代理对象不需要实现接口,但是目标对象一定要实现接口
     1. 示例
        ```Java
        public class ProxyFactory{ // 代理类
            // 维护一个目标对象
            private Object target;
            public ProxyFactory(Object target){
                this.target=target;
            }
            // 给目标对象生成代理对象
            public Object getProxyInstance(){
                return Proxy.newProxyInstance(
                        target.getClass().getClassLoader(),
                        target.getClass().getInterfaces(),
                        new InvocationHandler() {
                            // 代理的方法
                            @Override
                            public Object invoke(Object proxy, Method method, Object[] args) throws Throwable {
                                // 其他逻辑
                                // 执行目标对象方法
                                Object returnValue = method.invoke(target, args);
                                // 其他逻辑
                                return returnValue;
                            }
                        }
                );
            }
        }
        // 测试类
        IUserDao target = new UserDao();
        // 给目标对象，创建代理对象
        IUserDao proxy = (IUserDao) new ProxyFactory(target).getProxyInstance();
        // class $Proxy0   内存中动态生成的代理对象
        // 执行方法   【代理对象】
        proxy.save();
        ```
   - Cglib代理
     1. 理解：以目标对象子类的方式在内存中构建子类实现代理，也叫子类代理
     1. 价值：适用于目标对象没有实现接口的情况，可以在运行期扩展java类和实现java接口，被spring aop使用来提供interception(拦截)
     1. 原理：Cglib包的底层是通过使用一个小而块的字节码处理框架ASM来转换字节码并生成新的类
     1. 举例
        ```Java
        public class ProxyFactory implements MethodInterceptor{
            //维护目标对象
            private Object target;
            public ProxyFactory(Object target) {this.target = target;}
            //给目标对象创建一个代理对象
            public Object getProxyInstance(){
                //1.工具类
                Enhancer en = new Enhancer();
                //2.设置父类
                en.setSuperclass(target.getClass());
                //3.设置回调函数
                en.setCallback(this);
                //4.创建子类(代理对象)
                return en.create();
            }
            @Override
            public Object intercept(Object obj, Method method, Object[] args, MethodProxy proxy) throws Throwable {
                // 其他逻辑
                //执行目标对象的方法
                Object returnValue = method.invoke(target, args);
                // 其他逻辑
                return returnValue;
            }
        }
        // 测试方法
        //目标对象
        UserDao target = new UserDao();
        //代理对象
        UserDao proxy = (UserDao)new ProxyFactory(target).getProxyInstance();
        //执行代理对象的方法
        proxy.save();
        ```
### 网络编程
1. 理解：java.net包中，有接口和类提供低层次的通信细节。
1. Socket编程
   - 使用套接字建立TCP连接的过程
     1. 服务器实例化ServerSocket对象，调用accept()方法，等待客户端连接相应端口
     1. 客户端实例化Socket对象，指定地址等参数请求连接，连接建立
     1. 服务端的accept()方法返回新的与客户端连接的socket引用，使用I/O流进行通信，服务端和客户端的输出流和输入流分别相互连接。TCP是双向的，两个数据流可以同一时间发送
   - 实例
        ```Java
        // 服务端
        public class GreetingServer extends Thread{
            private ServerSocket serverSocket;
            public GreetingServer(int port) throws IOException
            {
                serverSocket = new ServerSocket(port);
                serverSocket.setSoTimeout(10000);
            }
            public void run()
            {
                while(true)
                {
                    Socket server = serverSocket.accept();
                    server.close();
                }
            }
            // 入口程序
            public static void main(String [] args)
            {
                Thread t = new GreetingServer(port);
                t.start();
            }
        }
        // 客户端
        Socket client = new Socket(serverName, port);
        client.close();
        ```
   - ServerSocket类的构造方法
     1. `public ServerSocket(int port) throws IOException` // 绑端口
     1. `public ServerSocket(int port, int backlog) throws IOException` // 指定backlog和本地端口号
     1. `public ServerSocket(int port, int backlog, InetAddress address) throws IOException` // 绑定backlog、端口和本地ip
     1. `public ServerSocket() throws IOException` // 创建非绑定Socket
   - ServerSocket类的常用方法
     1. `public int getLocalPort()` // 返回监听的端口
     1. `public Socket accept() throws IOException` // 开始监听
     1. `public void setSoTimeout(int timeout)` // 指定超时时间，毫秒为单位
     1. `public void bind(SocketAddress host, int backlog)` // 绑定ip和backlog
   - Socket类的构造方法：java.net.Socket代表服务端和客户端都用来通信。客户端实例化Socket，服务端通过accept()方法返回
     1. `public Socket(String host, int port) throws UnknownHostException, IOException.` // 连接指定主机ip和端口
     1. `public Socket(InetAddress host, int port) throws IOException` // 少了找不到异常
     1. `public Socket(String host, int port, InetAddress localAddress, int localPort) throws IOException.` // 连接到远程主机和端口
     1. `public Socket()` // 创建未连接的套接字
   - Socket类的常用方法
     1. `public void connect(SocketAddress host, int timeout) throws IOException` // 开始连接和超时时间
     1. `public InetAddress getInetAddress()` // 返回地址
     1. `public int getPort()` // 获得远程接口
     1. `public SocketAddress getRemoteSocketAddress()` // 获得远程地址
     1. `public int getLocalPort()` // 获得本地接口
     1. `public InputStream getInputStream() throws IOException` // 获得输入流
     1. `public OutputStream getOutputStream() throws IOException` // 获得输出流
     1. `public void close() throws IOException` // 关闭套接字
    - InetAddress类的方法
     1. `static InetAddress getByAddress(byte[] addr)`
     1. `static InetAddress getByName(String host)`
     1. `String getHostName() `
     1. `` // 
     1. `String toString()` // ip地址转为String
     1. `` // 
1. URL处理
   - URL 类方法
     1. `public URL(String protocol, String host, int port, String file) throws MalformedURLException` // 创建url
     1. `public URL(String url) throws MalformedURLException` // 给定url创建url
     1. `public URL(URL context, String url) throws MalformedURLException` // 创建相对url地址
     1. `public String getPath()` // 
     1. `public String getQuery()` // 
     1. `public String getAuthority()` // 
     1. `public int getPort()` // 80
     1. `public int getDefaultPort()` // 80
     1. `public String getProtocol()` // http、https
     1. `public String getHost()` // baidu.com
     1. `public String getFile()` // index.html
     1. `public String getRef()` // 获得锚点:j2se
     1. `public URLConnection openConnection() throws IOException` // 打开url，访问资源
   - URLConnections类方法：返回HttpURLConnection或者JarURLConnection对象
     1. `Object getContent()` // 获得内容
     1. `Object getContent(Class[] classes)` // 检索链接内容
     1. `String getContentEncoding()` // 返回 content-encoding 值
     1. `int getContentLength()` // 返回 content-type
     1. `int getLastModified()` // 返回 last-modified
     1. `long getExpiration()`
     1. `long getIfModifiedSince()`
     1. `public void setDoInput/setDoOutput(boolean input)` // 设置url连接是否用于输入/输出
     1. `public InputStream getInputStream() throws IOException` // 返回输入流，用于读取
     1. `public OutputStream getOutputStream() throws IOException` // 返回输出流，用于写入
     1. `public URL getURL()` // 返回url
### IO/NIO
1. 理解：java 1.4新出的io接口，标准的IO编程接口是面向字节流和字符流的，而NIO是面向通道和缓冲区的，针对数据流有了新的操作方式
   - 通道和缓冲区：Channels/Buffers，数据总是从通道中读到buffer内，或者从buffer写入到通道中
   - 异步io：单线程通过通道读/写数据到buffer，同时可以继续做别的事情，当数据读取到buffer中后，线程再继续处理数据
   - 选择器：Selectors，可以检测多个通道的事件状态，如链接打开，数据到达；允许单线程操作多个通道，用于有大量的链接，同时每个链接的IO带宽不高的情况，如聊天服务器
1. 组成
   - Channels：所有io操作从Channel开始，类似流
     1. 分类
        - FileChannel
        - DatagramChannel：用于UDP的数据读写
        - SocketChannel：用于TCP的数据读写
        - ServerSocketChannel：监听TCP连接请求
     1. transferFrom/transferTo
        - transferFrom：把数据从channel到FileChannel
        - transferTo：把FileChannel数据传输到另一个channel
        - 示例
            ```java
            RandomAccessFile fromFile = new RandomAccessFile("fromFile.txt", "rw");
            FileChannel fromChannel = fromFile.getChannel();
            RandomAccessFile toFile = new RandomAccessFile("toFile.txt", "rw");
            FileChannel toChannel = toFile.getChannel();
            // 定义属性
            long position = 0;
            long count = fromChannel.size(); // 数量

            toChannel.transferFrom(fromChannel, position, count);
            fromChannel.transferTo(position, count, toChannel);
            ```
     1. 示例
        ```java
        RandomAccessFile aFile = new RandomAccessFile("data/nio-data.txt", "rw");
        FileChannel inChannel = aFile.getChannel();
        // create buffer with capacity of 48 bytes
        ByteBuffer buf = ByteBuffer.allocate(48);
        // 写入buffer
        int bytesRead = inChannel.read(buf);
        while (bytesRead != -1) {
            System.out.println("Read " + bytesRead);
            // 转换为读模式
            buf.flip();
            while(buf.hasRemaining()){
                System.out.print((char) buf.get()); // read 1 byte at a time
            }
            buf.clear(); // 改为写模式
            bytesRead = inChannel.read(buf);
        }
        aFile.close();
        ```
   - Buffers
     1. 理解：本质是一块内存区，被NIO Buffer包裹提供了读写方便开发的接口
     1. 实现类
        - Byte/Short/Int/LongBuffer：MappedBytesBuffer，一般用于和内存映射的文件
        - Float/DoubleBuffer
        - CharBuffer
     1. 属性
        - capacity：容量，最多只能写入容量的字节
        - position：位置，写入/读取数据的开始位置，最大为capacity-1。写转读时，position归零
        - limit：上限，写模式表示能写入最大数据量，等于capacity；读模式为能读取的最大数据量
     1. 方法
        - allocate：创建，即分配内存，值为字节。`CharBuffer buf = CharBuffer.allocate(1024)`
        - 写入数据
          1. 从channel写入：` int bytesRead = inChannel.read(buf)`
          1. put方法：`buf.put(127)`，可以指定位置等其他参数
        - 读取数据
          1. 从channel读取：`int bytesWritten = inChannel.write(buf)`
          1. get方法：`byte aByte = buf.get()`，get有很多版本
        - flip：将写模式改为读模式，会将position归零，将limit设为之前position，即将limit指向最大
        - rewind：将position置为0，可以重复读取buffer中的值
        - clear：改为写模式，清空整个buffer。重置position为0，limit为capacity。实际上Buffer中数据并没有清空
        - compact：改为写模式，只清空已读取的数据，未被读取的数据会被移动到buffer的开始位置，写入位置则近跟着未读数据之后
        - mark/reset：标记/回复当前position。应该是暂存postion的位置，操作后再写回去
        - equals/compareTo：比较两个buffer
          1. equals：类型相同、buffer中剩余字节数相同、所有剩余字节相等
          1. compareTo：比较buffer中的剩余元素，适用于比较排序
     1. Scatter/Gather：
        - Scatter：代表数据从一个channel到多个buffer
        - Gather：从多个buffer把数据写入一个channel
        - 示例
            ```java
            ByteBuffer header = ByteBuffer.allocate(128);
            ByteBuffer body   = ByteBuffer.allocate(1024);
            // 定义并写入
            ByteBuffer[] bufferArray = { header, body };
            channel.read(bufferArray);
            channel.write(bufferArray);            
            ```
     1. 读写数据的步骤
        - 数据写入buffer
        - 调用flip
        - buffer中读取数据
        - 调用buffer.clear()/compact()
   - Selectors
     1. 理解：Channel必须是非阻塞的，FileChannel不能切换为非阻塞模式不适用
     1. 关注集合：代表我们关注的channel状态，有四种基础类型可供监听
        - Connect：连接就绪，用常量表示即SelectionKey.OP_CONNECT
        - Accept：可连接就绪，即server channel接收请求连接时
        - Read：读就绪，即有数据可读时
        - Write：写就绪，即有数据可写时
        - 多事件：`int interestSet = SelectionKey.OP_READ | SelectionKey.OP_WRITE;`
     1. 选择channel
        - int select()：返回所有处于就绪状态的channel数，就自上一次select后有多少channel进入就绪状态，不会累计。select()方法在返回channel之前处于阻塞状态
        - int select(long timeout)：阻塞有超时限制
        - int selectNow()：不会阻塞，根据当前状态立刻返回合适的channel
     1. SelectionKeys对象
        - interestSet：我们希望处理的事件的集合
            ```java
            // 按位与将事件取出来
            int interestSet = selectionKey.interestOps();
            boolean isInterestedInAccept  = interestSet & SelectionKey.OP_ACCEPT;
            boolean isInterestedInConnect = interestSet & SelectionKey.OP_CONNECT;
            boolean isInterestedInRead    = interestSet & SelectionKey.OP_READ;
            boolean isInterestedInWrite   = interestSet & SelectionKey.OP_WRITE;
            ```
        - readySet：就绪集合
            ```java
            int readySet = selectionKey.readyOps();
            // 更简单方法
            selectionKey.isAcceptable();
            selectionKey.isConnectable();
            selectionKey.isReadable();
            selectionKey.isWritable();
            ```
        - 操作Channel和Selector
            ```java
            Channel channel = selectionKey.channel(); // 需要强转为实际使用的channel类型，如：ServerSocketChannel/SocketChannel
            Selector selector = selectionKey.selector();
            ```
        - 添加Object：增加channel的附加信息
            ```java
            selectionKey.attach(Object);
            Object attachedObj = selectionKey.attachment();
            // 注册时添加对象
            SelectionKey key = channel.register(selector, SelectionKey.OP_READ, theObject);
            ```
        - remove：Selector本身并不会移除SelectionKey对象
     1. wakeUp：由于调用select而被阻塞的线程可以在另一个线程中调用wakeup，就会立刻返回channel
     1. close：操作Selector完毕后，需要调用close方法。会关闭Selector并使相关SelectionKey都失效，channel本身不被关闭
     1. 使用
        ```java
        Selector selector = Selector.open();
        channel.configureBlocking(false);
        SelectionKey key = channel.register(selector, SelectionKey.OP_READ);

        while(true) {
            // 获取channels
            int readyChannels = selector.select();
            if(readyChannels == 0) continue;

            Set<SelectionKey> selectedKeys = selector.selectedKeys();

            Iterator<SelectionKey> keyIterator = selectedKeys.iterator();

            while(keyIterator.hasNext()) {

                SelectionKey key = keyIterator.next();

                if(key.isAcceptable()) {
                    // a connection was accepted by a ServerSocketChannel.
                } else if (key.isConnectable()) {
                    // a connection was established with a remote server.
                } else if (key.isReadable()) {
                    // a channel is ready for reading
                } else if (key.isWritable()) {
                    // a channel is ready for writing
                }

                keyIterator.remove();
            }
        }
        selector.close();
        ```
1. 重难点
   - Stream
   - Buffer
   - java.io.\*/java.nio.*
1. BIO
1. AIO
### Lambda表达式
1. 理解：Java 8中用来实现匿名方法，可在某些场景作为匿名类的替代方案
### Java 8
1. 即jdk1.8，14年3月发布
   - 新特性
     1. Lambda表达式：Lambda允许函数作为参数传递
     1. 方法引用：可以直接引用已有对象/类的方法，使语言结构更简洁紧凑
     1. 实现方法：就是类在接口里有个实现的方法
     1. 新工具：如新的编译工具，Nashorn引擎jjs、类依赖分析器jdeps
     1. Stream API：即java.util.stream，把真正的函数式编程引入java中
     1. DateTime API：加强日期和时间的处理
     1. Optional 类：解决空指针异常
     1. Nashorn JavaScript 引擎：允许在JVM上运行javascript应用
   - foreach和Lambda
     1. 遍历Map
      ```Java
      Map<String, Integer> items = new HashMap<>();
      items.put("A", 10);

      items.forEach((k,v)->{
          System.out.println("Item : " + k + " Count : " + v);
      });
      ```
     1. 遍历List
      ```Java
      List<String> items = new ArrayList<>();
      items.add("A");

      items.forEach(item->{
          System.out.println(item);
      });

      //method reference
      //Output : A,B,C,D,E
      items.forEach(System.out::println);

      //Stream and filter
      //Output : B
      items.stream()
          .filter(s->s.contains("B"))
          .forEach(System.out::println);
      复制代码
      ```