### 数据结构
1. 数组：（Array）存储在堆上的对象，长度是固定的，用来存储固定数量的多个同类型变量
   - 定义：`数据类型 数组名[] 或者 数据类型[] 数组名`
   - 声明
        ```Java
        // 声明
        dataType[] myList = new dataType(size);
        dataType[] myList;
        dataType[] myList = {78,93};
        dataType myList[] = {78,93};
        // 访问
        myList[1];
        // 赋值
        myList[1] = 1;
        // 长度
        array.length()
        ```
   - 处理：
        ```Java
        for (int i = 0; i < myList.length; i++) {} // 内循环处理
        for (double element: myList) {} // foreach处理
        ```
   - 作为参数传递：`public static void printArray(int[] array) {}`
   - 二维数组
     1. 声明：`int 数组名[][] = new int[行数][列数]`
        ```Java
        // 定义每个列数可以不同的方法
        int num[][] = new int[2][];
        num[0] = new int[2];
        num[1] = new int[3];
        // 访问
        num[0][0]
        ```
   - Arrays类：java提供的工具类，在java.util包中java.util.Arrays ，包含排序、搜索等方法
     1. 排序
        ```Java
        import java.util.Arrays;
        Arrays.sort(scores);
        ```
     1. 查找：binarySearch：`int binarySearch(Obj[] a, Obj key)`
     1. 比较：equals：`boolean equals(long[] a, long[] a2)`
     1. 填充
     1. Arrays.toString(数组);
1. 枚举：（Enumeration）枚举接口java5.0引入，限制变量只能是预先设定好的值，使用枚举可以减少代码中bug。已经被迭代器取代，很少使用。本质是类，取代定义很多的变量`public static final`
   - 包含：变量、方法、构造函数
   - 特点：可以在任何地方声明枚举
   - 定义
        ```Java
        // 定义枚举
        package com;
        public enum Color {
            RED, GREEN, BLANK, YELLOW 
        }
        // 使用
        Color.RED
        static boolean isRed( Color color ){
            if(Color.RED.equals(color)) {
                return true ;
            }
            return false ;
        }
        ```
   - 自定义函数：
        ```Java
        public enum Color {
            RED("红色", 1), GREEN("绿色", 2), BLANK("白色", 3), YELLO("黄色", 4);
            private String name ;
            private int index ;
            private Color( String name , int index ){
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
        System.out.println( Color.RED.getName() ); // 红色
        ```           
1. 位集合：（BitSet）位集合类实现了一组可以单独设置和清除的位或标志。该类处理一组布尔值的时候很有用。创建一种特殊类型的数组来保存值，数组大小随需要增加。
   - 定义：
        ```Java
        BitSet bits1 = new BitSet(16);
        
        // 有两个构造方法
        BitSet(); // 创建一个默认对象
        BitSet(int size); // 允许用户指定初始大小，默认0
        ```
   - 使用
        ```Java
        bits1.set(i);
        ```
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
        while(vEnum.hasMoreElements())
            System.out.print(vEnum.nextElement() + " ");
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
        Stack()
        // 示例
        Stack st = new Stack();
        static void showpush(Stack st, int a) {
            st.push(new Integer(a));
        }
        ```
   - 方法
     1. `boolean empty()` // 是否为空
     1. `Object peek()` // 查看顶部对象，不移除
     1. `Object pop( )` // 返回顶部并移除
     1. `Object push(Object element)` // 把元素压入顶部
     1. `int search(Object element)` // 对象在堆栈的位置，1为基数
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
1. 哈希表：（Hashtable）Hashtable类提供了用户定义键结构的组织数据的手段，哈希表的键的具体含义取决于使用场景和包含的数据。是原始的java.util的一部分，是Dictionary的具体实现，是其子类。Java 2的Hashtable实现了Map接口，所以现在集成到了集合框架中。和HashMap类似，但是支持同步。哈希表的键经过哈希处理得到的散列码用作值的索引
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
        ```
   - 方法
     1. `String getProperty(String key)` // 搜索属性
     1. `String getProperty(String key, String defaultProperty)` // 搜索属性
     1. `void list(PrintStream streamOut/PrintWriter streamOut)` // 属性列表输出流
     1. `void load(InputStream streamIn) throws IOException` // 从输入流中读取属性列表
     1. `Enumeration propertyNames( )` // 按简单的面向行的格式从输入字符流中读取属性列表
     1. `Object setProperty(String key, String value)` // 调用Hashtable的put方法
     1. `void store(OutputStream streamOut, String description)`
### 集合框架
1. 简介：Java2引入，是用来代表/操作集合的统一架构，集合框架围绕一组标准接口而设计，可以直接使用接口的标准实现，如LinkedList、HashSet、TreeSet，也可以通过接口实现自己的集合。提供了预先包装的数据结构供使用
1. 理解：具有共同属性的数据集合。对数据进行组织和大数量的操作，是盛装其他对象的容器
1. 分类
   - Collection：内部都是一个个的对象
     1. List：(序列)排列有序可重复
        - ArrayList：(数组序列)
     1. Queue：(队列)排列有序可重复
        - LinkedList：(链表)，同时也是List的实现类
     1. Set：(集)无序不可重复
        - HashSet：(哈希集)
   - Map：有众多子接口
     1. HashMap：(哈希表)
1. Collection
   - 比较：
     1. List查询效率高，插入和删除低，因为改起其他元素改变；Set查询效率低，插入和删除效率高
     1. Set没有List的get方法，只能通过foreach和iterator方法遍历，而且每次迭代的结果都不一样。Set中不论添加多少次，因为不能重复，所以只能有一个
1. Map：(映射) 用来存储键值对。可以通过key查找value。内部以映射存储数据，就是Entry(键值对)类的实例，key和value可以是任意的对象。key不可重复，value可以。组成有Map自己是个接口、众多子接口和实现类。支持泛型：`Map<k,v>`
   - 特点
     1. 访问的值不存在，抛出NoSuchElementException异常
     1. 对象类型和Map的元素类型不兼容时，抛出ClassCastException
     1. 不允许使用Null对象的Map中使用Null，抛出NullPointerException
     1. 修改只读Map时，抛出UnsupportedOperationException
   - 方法
     1. `Object get(Object k)` // 通过键返回值，不存在为null
     1. `Object put(Object k, Object v)` // 更新或添加
     1. `Object remove(Object k)` // 通过键删除
     1. `void putAll(Map m)` // 一个映射复制到另一个映射
     1. 
     1. `boolean equals(Object obj)` // 比价指定的对象和此映射是否相同
     1. `boolean containsKey(Object k)` // 是否存在指定键
     1. `boolean containsValue(Object v)` // 是否存在指定值
     1. `int size( )` // 返回关系数量
     1. `boolean isEmpty()` // 是否为空
     1. `void clear( )` // 删除所有映射关系
     1. 
     1. `Set keySet( )` // 返回键的Set视图
     1. `Collection values( )` // 返回值的Collection视图
     1. `Set entrySet( )` // 返回映射关系的Set视图
     1. 
     1. `int hashCode()` // 返回映射的哈希码值
1. 内部组成
   - 组成：接口、实现类(集合类)、算法（如搜索和排序）
     1. 接口
        - `Collection`：最基本集合接口，java不提供直接继承自Collection的类来使用，只提供继承Collection的子接口，如List和Set
        - `List`：是有序的，精确控制每个元素的位置。通过索引(类似数组的小标)访问其中的元素，允许有相同元素
        - `Set`：无序的，与Collection完全一样，但是行为上不同。不能有相同元素。子接口SortedSet接口保存有序集合。
        - `Map`：唯一键映射到值。Map.Entry描述Map中的键值对，是Map的内部类。子接口SortedMap，使key保持升序。
        - `Enumeration`：一个传统的接口和数据定义方法，已被迭代器取代
     1. 集合类：具体类可以直接使用，抽象类提供了接口的部分实现
        - `AbstractCollection`：实现了大部分的集合接口
        - `AbstractList`：继承于AbstractCollection，实现了大部分List接口。子类AbstractSequentialList提供对数据元素的链式访问，不是随机访问
        - `ArrayList`：实现可变大小的数组，非同步        
        - `LinkedList`：实现了List接口，允许null存在。用于创建链表数据结构，查找效率低。没有同步方法，多线程需要自己实现访问同步，解决方案：创建List时候构造一个同步的List。
        - `AbstractSet`：继承于AbstractCollection，实现大部分Set接口
        - `HashSet`：不允许元素重复，不保证元素顺序，最多有一个null值
        - `LinkedHashSet`：可预知迭代顺序的Set接口的哈希表和链接列表实现
        - `TreeSet`：实现Set接口，实现排序等功能
        - `AbstractMap`：实现大部分Map接口
        - `HashMap`：是一个散列表，是键值对的映射。根据键的哈希值存储数据，访问速度很快。不同步，最多一个null。WeakHashMap：弱秘钥的哈希表；LinkedHashMap：按自然顺序对元素排序；IdentityHashMap：比较文档时使用引用相等
        - `TreeMap`：使用一棵树
     1. 集合算法：被定义为集合类的静态方法，定义了三个静态变量：EMPTY\_SET，EMPTY\_LIST，EMPTY_MAP，不可改变
   - 迭代器：用来遍历集合中的元素，类似for和增强for，继承自Iterator接口或继承自ListIterator
     1. 遍历ArrayList
            ```Java
            // 组建数组
            List<String> list=new ArrayList<String>();
            list.add("Hello");
            list.add("World");
            list.add("HAHAHAHA");
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
     1. 遍历Map
            ```Java
            Map<String, String> map = new HashMap<String, String>();
            map.put("1", "value1");
            map.put("2", "value2");
            map.put("3", "value3");
            String tmpKey;
            String tmpValue;
            // 通过Map.keySet遍历
            for (String key : map.keySet()) {
                tmpKey = key
                tmpValue = map.get(key));
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
            // 通过Map.values()遍历所有的value，但不能遍历key
            for (String v : map.values()) {
                tmpValue = v;
            }
            ```
   - 比较器：用来精确定义排序规则，以不同方式排序集合。使用Comparator
1. 特点：对基本集合(动态数组/链表/树/哈希表)的实现是高性能的，允许不同类型的集合以类似的方式工作，对集合的扩展和适应是简单的。重点是ArrayList、HashSet、HashMap
### 泛型
1. 泛型
   - 理解：JDK5引入的新特性，提供编译时的类型检测
   - 特点
     1. 泛型集合中的限定类型，不能使用基本数据类型，非要使用就通过包装类限定存入的类型。如int就用Integer，long就用Long。int的包装类就是Integer
   - 泛型类：类后面加类型参数声明部分，包含n个类型参数
     1. 定义
        ```Java
        public class Box<T> {
            private T t;
            public void add(T t) {
                this.t = t;
            }
            public T get() {
                return t;
            }

            // 使用
            public static void main(String[] args) {
                Box<Integer> integerBox = new Box<Integer>();
                Box<String> stringBox = new Box<String>();

                integerBox.add(new Integer(10));
                stringBox.add(new String("菜鸟教程"));

                // integerBox.get()
                // stringBox.get()
            }
        }
        ```
   - 泛型方法：根据参数类型，泛型方法适当处理每一个方法调用
     1. 特点：都有尖括号分隔的类型参数声明部分，这个部分包含n个类型的参数，称为类型变量。类型参数能被用来声明返回值类型，也能作为泛型方法的得到实参的占位符，即引用类型，不是原始类型
     1. 举例
        ```Java
        // 泛型方法 printArray                         
        public static < E > void printArray( E[] inputArray ){
            // 输出数组元素            
            for ( E element : inputArray ){        
                System.out.printf( "%s ", element );
            }
        }
        // 可以传入不同类型
        Integer[] intArray = { 1, 2, 3, 4, 5 };
        Double[] doubleArray = { 1.1, 2.2, 3.3, 4.4 };
        printArray( intArray  ); // 传递一个整型数组
        printArray( doubleArray ); // 传递一个双精度型数组
        // 有界的类型参数
        public static <T extends Comparable<T>> T maximum(T x, T y, T z)
        ```
   - 泛型成员变量
        ```Java
        // Course是一个对象
        public List<Course> course; // 带有泛型的变量
        this.course = new ArrayList<Course>(); // 赋值带有泛型的变量
        ```
   - 类型通配符:用?代替具体的类型参数，如List<?>可以代表List<String>,List<Integer>等
        ```Java
        public static void getData(List<?> data) {}
        // 只接受Number及其子类型
        public static void getUperNumber(List<? extends Number> data)
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
### 多线程
1. 理解：阻塞当前进程，让出cpu。是并发执行的，线程多了因为上下文的切换反而效率下降，使用更小资源开销，轮候使用cpu，存在等待。
1. 状态
   - 新建：new或者Thread类及其子类建立线程对象后
   - 就绪：线程对象调用start()后，等待JVM调度器的调度
   - 运行：获取cpu资源，可以执行run()，可以变为就绪、阻塞、死亡状态
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
1. 概念：线程同步、线程间通信、线程死锁、线程控制(挂起/停止/恢复)
### 版本
1. Java 8：即jdk1.8，14年3月发布
   - 新特性
     1. Lambda 表达式：Lambda允许函数作为参数传递
     1. 方法引用：可以直接引用已有对象/类的方法，使语言结构更简洁紧凑
     1. 实现方法：就是类在接口里有个实现的方法
     1. 新工具：如新的编译工具，Nashorn引擎jjs、类依赖分析器jdeps
     1. Stream API：即java.util.stream，把真正的函数式编程引入java中
     1. DateTime API：加强日期和时间的处理
     1. Optional 类：解决空指针异常
     1. Nashorn JavaScript 引擎：允许在JVM上运行javascript应用