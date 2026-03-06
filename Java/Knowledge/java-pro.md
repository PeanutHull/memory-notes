### 泛型
1. 泛型
   - 理解：为了参数化类型，JDK5引入的新特性，提供编译时的参数类型检测。泛型集合中必须使用包装类，不能基本类型
   - 类型通配符:用?代替具体类型参数，此处?是类型实参，而不是类型形参，?也是一种实际的类型，看成所有类型的父类
    ```Java
    public static void getData(List<?> data) {}
    ```
   - 有界的类型参数
    ```java
    public static <T extends Comparable<T>> T method(T x, T y, T z)？？？
    public static void getUperNumber(List<? extends Number> data)           // 只接受Number及其子类型
    ```
   - 泛型数组
    ```java
    List<String>[] ls = new ArrayList[10];
    List<?>[] ls = new ArrayList<?>[10];            // 最后取出数据要做显式的类型转换
    ```
   - 泛型变量
    ```Java
    List list = new ArrayList();                    // 普通定义方式
    List<String> list = new ArrayList<String>();    // 泛型变量定义方式
    // 泛型成员变量
    public List<Course> course;             // 带有泛型的变量
    course = new ArrayList<Course>();       // 赋值带有泛型的变量
    ```
   - 泛型方法：在调用方法的时候指明泛型的具体类型，根据参数类型，泛型方法适当处理每一个方法调用
     1. 特点：<T>声明此方法为泛型方法，才能使用T作为返回值，T可以随便写为任意标识
     1. 定义
        ```Java
        public static <T> T genericMethod(Class<T> tClass) {
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
   - 泛型接口：`public interface Generator<T> {}`
### 注解
1. 理解：Annotation，Java5引入，是一种应用于类、方法、参数、变量、构造器及包声明中的特殊修饰符。是描述数据的数据，也叫元数据。和具体业务逻辑无关
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
### 反射
1. 理解：Java允许程序化的方式间接对Class进行获取和操作，可以获取类的名称、变量、方法等
   - 获得类类型：Foo.class/foo.getClass()/Class.forName()
   - 获得实例对象：c1.newInstance()
   - 反射执行方法：m.invoke()
1. 获取类信息
   - 获得类、实例对象
    ```Java
    // 获得类类型，即Class类的实例对象
    CLass c1 = Foo.class                                    // 通过类本身的隐含静态成员变量获取类类型
    Class c2 = foo.getClass()                               // 通过实例化后的对象获取类类型，c1等于c2
    Class c3 = Class.forName('com.imooc.reflect.foo')       // 通过Class类的方法
    // 通过类类型获取实例对象
    Foo foo = (Foo) c1.newInstance()                        // 要做强制类型转换
    ```
   - 获取类的基本信息
     1. `c.getName()` 类名
     1. `c.getSimpleName()` 不包含包名
   - 获取成员变量的信息：成员变量也是对象，继承java.lang.reflect.Field
     1. `c.getFields()` 获取所有public的成员变量的信息
     1. `c.getDeclaredFields()` 获取自己声明的所有变量
     1. `field.getName` 成员变量的名称
     1. `field.getType()` 成员变量的类型的类类型
   - 获取构造函数的信息：构造函数继承java.lang.Constructor
     1. `c.getConstructtor()` 获取所有public的构造方法，包含继承来的
     1. `c.getDeclaredConstructtor()` 获取自己定义的所有的构造方法
     1. `constructor.getName()`
     1. `constructor.getParameterTypes()`
   - 获取方法的信息
     1. `c.getMethods()` 获取所有public的方法，包含继承来的
     1. `c.getDeclaredMethods()` 获取该类所有的自己声明的方法，忽略访问权限
     1. `method.getName()` 获取方法名
     1. `method.getReturnType()` 方法的返回值类类型
     1. `method.getParameterTypes()` 方法的参数类类型 
1. 加载类
   - 分类：编译和运行，编译时加载类是静态加载，运行时加载类是动态加载
   - 实例
        ```java
        ----通过类装置器----
        // 获取Car类，通过类装载器获取Car类
        ClassLoader loader = Thread.currentThread().getContextClassLoader();
        class clazz = loader.loadClass("com.smart.reflect.Car");
        // 实例化Car，获取类的默认构造对象并通过它实例化Car
        Constructor cons = Clazz.getDeclaredConstructor((Class[])null);
        Car car = (Car) cons.newInstance();
        ----通过接口----
        // 实例化Car，通过指定接口实例化出对象
        Class Car = Class.ForName("com.smart.reflect.Car");
        CarInterface car = (CarInterface) Car.newInstance();
        ----操作对象----
        // 操作对象，通过反射方法
        Method setColor = clazz.getMethod(“setColor”, String.class); // 跟两个参数类型，没有这里，下一句就不写
        setColor.invoke(car, “黑色”);
        ```
### 多线程
1. 理解：使用更小资源开销，轮候使用cpu，存在等待，线程多了因为上下文切换反而效率下降。目的就是伪同时运行，因为cpu处理速度快
1. 创建
   - 继承Thread类：Thread类用于描述线程，线程是需要任务的用run来表示
     1. 步骤：定义类继承Thread--覆盖run方法--创建子类对象来创建线程--调用start方法开启线程(即run方法执行)
   - 实现Runnable接口：单独封装，避免单继承的局限，更常用。
     1. 步骤：定义类实现Runnable接口--覆盖run方法--创建子类对象并作为参数传递给Thread类的构造方法--start开启线程
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
1. 线程安全：操作共享数据时，产生数据偏差
   - 同步：synchronized，用同步代码争抢一个锁(this)，解决共享数据问题，锁的判断开销很大。
   - 同步代码块：锁是任意的对象，如果用this的话可以和同步`public synchronized void add(int num){}`
1. 锁
   - Lock接口，可以一个锁加多个监视器。JDK1.5出现
     1. lock()：获取锁
     1. unlock()：释放锁
   - Condition接口，替代Object中的wait/notify方法，变成Condition监视器对象，可以对任意锁进行组合
     1. await：wait
     1. signal：notify，signalAll
1. 死锁
   - 同步嵌套：自己需要的锁互相在对方那里
1. 线程间通信
   - 等待/唤醒机制
     1. wait()：线程冻结，存储到线程池中。可以不指定时间
        - wait：释放cpu执行权，释放锁
        - sleep：释放cpu执行权，不释放锁
     1. notify()：唤醒线程池中一个线程。notifyAll()唤醒所有
     1. interrupt()：将线程从冻结状态强制恢复到运行状态
1. volatile
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
1. 状态
   - 新建：Thread类及其子类建立线程对象
   - 就绪：线程对象调用start()后，等待JVM调度器的调度
   - 运行：获取cpu资源，执行run方法，可以变为就绪、阻塞、死亡状态
   - 阻塞：三种阻塞类型
     1. 等待阻塞：运行中的线程执行wait()方法
     1. 同步阻塞：线程获取synchronized同步锁失败
     1. 其他阻塞：调用sleep()或join()发出io请求时，当这些结束时，线程重新进入就绪状态
   - 死亡：完成任务或者终止条件发生时
1. 优先级：整数范围1~10，默认5，不保证线程执行顺序，非常依赖平台
1. 概念
   - 线程控制(挂起/停止/恢复)
   - 线程同步：即任意时刻只能有一个线程同时写，保证数据一致
   - 线程死锁
   - 线程间通信
1. 重难点
   - ThreadPoolExecutor
   - J.U.C
   - Atomic*
   - Fork/Join
### 代理模式
1. 理解：代理是一种设计模式，提供了对目标对象另外的访问方式，即通过代理对象访问目标对象。三方角色：用户、代理对象、目标对象
1. 价值：可以在实现目标对象的基础上,增强额外的功能操作和功能扩展。不要随意修改已经写好的代码，如需修改使用代理的方式扩展该方法   
1. 分类：静态代理，动态代理，Cglib代理
1. 静态代理
   - 理解：需要被代理对象与代理对象一起实现同一接口或继承同一父类，目标对象传入代理对象实例化，调用被代理方法，套了一层代码，然后执行。可以在不修改目标代理前提下，实现功能拓展，会产生很多代理类，要维护两份类
   - 示例
    ```Java
    public interface IUserDao {void save();}                                // 接口
    public class UserDao implements IUserDao { public void save() {}}       // 目标对象
    public class UserDaoProxy implements IUserDao{                          // 代理对象
        private IUserDao target;
        public UserDaoProxy(IUserDao target){
            this.target=target;
        }
        public void save() {
            // 执行其他逻辑
            target.save();                                                  // 执行目标对象的方法
            // 其他逻辑                
        }
    }
    
    UserDao target = new UserDao();                                         // 测试类
    UserDaoProxy proxy = new UserDaoProxy(target);                          // 建立代理关系
    proxy.save();                                                           // 执行代理方法
    ```
1. 动态代理
   - 理解：使用代理类`java.lang.reflect.Proxy`，在内存中构建代理对象，也叫JDK代理/接口代理
   - 实现方法：`newProxyInstance(ClassLoader loader, Class<?>[] interfaces,InvocationHandler h )`
     1. ClassLoader loader：指定当前目标对象使用类加载器
     1. Class<?>[] interfaces：目标对象实现的接口的类型，目标对象一定要实现接口
     1. InvocationHandler h：把当前执行目标对象的方法作为参数传入
   - 示例
    ```Java
    public class ProxyFactory{                                                      // 代理类
        private Object target;
        public ProxyFactory(Object target){
            this.target=target;
        }
        public Object getProxyInstance(){                                           // 给目标对象生成代理对象
            return Proxy.newProxyInstance(
                    target.getClass().getClassLoader(),
                    target.getClass().getInterfaces(),
                    new InvocationHandler() {
                        @Override
                        public Object invoke(Object proxy, Method method, Object[] args) throws Throwable {
                            // 其他逻辑
                            Object returnValue = method.invoke(target, args);       // 执行目标对象方法
                            // 其他逻辑
                            return returnValue;
                        }
                    }
            );
        }
    }
    IUserDao target = new UserDao();                                                // 测试类
    IUserDao proxy = (IUserDao) new ProxyFactory(target).getProxyInstance();        // 创建代理对象
    proxy.save();                                                                   // 执行代理方法
    ```
1. Cglib代理
   - 理解：在内存中构建目标对象的子类实现代理，也叫子类代理。可以在运行期扩展java类，被spring aop使用来提供interception(拦截)
   - 原理：Cglib包的底层是通过使用一个小而快的字节码处理框架ASM来转换字节码并生成新的类
   - 举例
    ```Java
    public class ProxyFactory implements MethodInterceptor{
        private Object target;
        public ProxyFactory(Object target) {
            this.target = target;
        }
        public Object getProxyInstance(){                           // 创建代理对象
            Enhancer en = new Enhancer();                           // 1.工具类
            en.setSuperclass(target.getClass());                    // 2.设置父类
            en.setCallback(this);                                   // 3.设置回调函数
            return en.create();                                     // 4.创建子类(代理对象)
        }
        @Override
        public Object intercept(Object obj, Method method, Object[] args, MethodProxy proxy) throws Throwable {
            // 其他逻辑
            Object returnValue = method.invoke(target, args);       //执行目标对象的方法
            // 其他逻辑
            return returnValue;
        }
    }
    UserDao target = new UserDao();                                 // 测试方法
    UserDao proxy = (UserDao) new ProxyFactory(target).getProxyInstance();
    proxy.save();                                                   // 执行代理方法
    ```
### NIO
1. 理解：java 1.4新出的io接口，标准的io编程接口是面向字节流和字符流的，而NIO是面向通道和缓冲区的，针对数据流有了新的操作方式
   - 通道和缓冲区：Channels/Buffers，数据总是从通道中读到buffer内，或者从buffer写入到通道中
   - 异步io：单线程通过通道读/写数据到buffer，同时可以继续做别的事情，当数据读取到buffer中后，线程再继续处理数据
   - 选择器：Selectors，可以检测多个通道的事件状态，如链接打开/数据到达，允许单线程操作多个通道，用于维持大量链接，同时每个链接io带宽不高的情况，如聊天服务器
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
1. Channel
   - FileChannel
     1. 理解：读写文件的通道，不能设置为非阻塞模式，只能再阻塞模式下运行
     1. 方法
        - position：获取/设置位置，channel位置尽头返回-1，channel在写入时会自动扩展，所以可能导致channel出现空洞
          1. `long pos channel.position()`;
          1. `channel.position(pos +123)`;
        - size：返回channel的大小，`long fileSize = channel.size();`
        - truncate：从channel中截取指定长度的文件，`channel.truncate(1024);`
        - force：将所有未写入磁盘的数据全部写入，因为不能保证write写入channel后就写到了磁盘上。`channel.force(true);`
     1. 使用
        ```java
        // 写入buffer数据
        RandomAccessFile aFile = new RandomAccessFile("data/nio-data.txt", "rw"); // 打开一个文件通道，通过输入/输出流或RandomAccessFile，rw：read和write
        FileChannel inChannel = aFile.getChannel();
        ByteBuffer buf = ByteBuffer.allocate(48);
        int bytesRead = inChannel.read(buf); // 返回值表示写入buffer的字节数，-1表示已经读取到文件结尾
        channel.close();

        // write，写入文件通道数据
        String newData = "New String to write to file..." + System.currentTimeMillis();
        ByteBuffer buf = ByteBuffer.allocate(48);
        buf.clear();
        buf.put(newData.getBytes());
        buf.flip();
        while(buf.hasRemaining()) {
            channel.write(buf);
        }
        ```
   - SocketChannel
     1. 理解：用于TCP网络连接的套接字接口，相当于Socket套接字接口
     1. 创建
        - 打开SocketChannel并连接到一台服务器时
        - 当ServerSocketChannel接收到一个连接请求时，会创建一个SocketChannel
     1. 方法
        - open：打开一个SocketChannel
            ```java
            SocketChannel socketChannel = SocketChannel.open();
            socketChannel.connect(new InetSocketAddress("http://unknow.com", 80));
            ```
        - close：关闭连接，`socketChannel.close();`
        - read：还是先开辟buffer，把channel的数据放到buffer中
        - write：`channel.write(buf);`
     1. 非阻塞模式：调用connect/read/write都是异步的
        - connect：调用connect()后，方法会在链接建立前就直接返回
            ```java
            socketChannel.configureBlocking(false);
            socketChannel.connect(new InetSocketAddress("http://jenkov.com", 80));

            while(!socketChannel.finishConnect()){
                // wait, or do something else...
            }
            ```
        - read/write：都不能确认是否得到了执行，需要write放到循环内，read自己检查返回值
   - ServerSocketChannel
     1. 理解：用于监听TCP链接请求的通道，类似ServerSocket
     1. 方法
        - open
            ```java
            ServerSocketChannel serverSocketChannel = ServerSocketChannel.open();
            serverSocketChannel.socket().bind(new InetSocketAddress(9999));
            while(true) {
                SocketChannel socketChannel = serverSocketChannel.accept(); // accept()是阻塞操作，阻塞当前线程直到返回一个连接，所以用while包裹
                //do something with socketChannel and add interrupt...
                serverSocketChannel.close();
            }
            ```
     1. 非阻塞模式：accept会立刻返回，如果当前没有请求，返回null
   - DatagramChannel
     1. 理解：发送/接收UDP数据包的通道，由于UDP是面向无连接的网络协议，不能直接读写数据，应该是发送/接收数据包
     1. 方法
        - open/receive////
            ```java
            DatagramChannel channel = DatagramChannel.open();
            channel.socket().bind(new InetSocketAddress(9999));
            ByteBuffer buf = ByteBuffer.allocate(48);
            buf.clear();

            channel.receive(buf); // 接收到的数据拷贝给Buffer中，数据包超过大小被丢弃
            int byteSent = channel.send(buf, new InetSocketAddress("jenkov.com", 80)); // 不会收到数据包是否被接收的的通知，因为UDP不保证数据发送问题
            ```
   - AsynchronousFileChannel
     1. 理解：Java 7新增，异步文件读写channel
1. Pipe
   - 理解：是两个线程间单向传输数据的连接。包含source channel和sink channel。数据写入sink，可以通过source再读出来
   - 使用
        ```java
        Pipe pipe = Pipe.open(); // 创建
        // 写入数据
        String newData = "New String to write to file..." + System.currentTimeMillis();
        ByteBuffer buf = ByteBuffer.allocate(48);
        buf.clear();
        buf.put(newData.getBytes());
        buf.flip();

        Pipe.SinkChannel sinkChannel = pipe.sink(); // 访问sink
        while(buf.hasRemaining()) {
            sinkChannel.write(buf); // 写入
        }
        // 读取数据
        Pipe.SourceChannel sourceChannel = pipe.source();
        ByteBuffer buf = ByteBuffer.allocate(48);
        int bytesRead = inChannel.read(buf);
        ```
1. Path
   - Java 7新增，java.nio.file包下，一个Path实例代表一个文件系统内的路径，指向文件或目录。java.no.file.Path接口和java.io.File比较相似
   - 实例
        ```java
        import java.nio.file.Path;
        import java.nio.file.Paths;
        Path path1 = Paths.get("c:\\data\\myfile.txt"); // 创建的是绝对路径，Unix中是/home/myfile.txt
        Path path2 = Paths.get(basePath, relativePath); // 相对路径
        Path path3 = path1.normalize();
        ```
1. Files
   - 理解：java.nio.file.Files，提供了多种操作文件系统的文件的方法
   - 方法
     1. Files.exists()
     1. Files.createDirectory()
     1. Files.copy()
     1. Files.copy(sourcePath, destinationPath, StandardCopyOption.REPLACE_EXISTING) 覆盖文件
     1. Files.move()
     1. Files.delete()
1. NIO和IO
   - 面向流和面向缓冲区：可以操作缓冲区中数据的读取位置position
   - 阻塞和非阻塞
   - 适用场景：数据量少、连接多，就用非阻塞单线程；占用大带宽、连接少，就用阻塞多线程
1. 非阻塞服务器
   - 阻塞IO通道的优/缺点：实现简单，必须为每个数据数量分配一个单独的线等待IO数据的返回，造成内存暴增，缺乏伸缩性，线程池也不能有效解决。
   - 非阻塞IO通道：通过Message Reader/Write协议组织碎片化的channel数据，组成完整一个数据，提供给其他组件。用可伸缩的buffer存储不完整的Message，有拷贝扩容/追加扩容/TLV编码消息等方式
1. selector背后：epoll
1. nio的selector背后：select并非iocp
1. nio2背后：iocp
### 网络编程
1. 理解：java.net包中，有接口和类提供底层通信细节
1. Socket编程
   - 使用套接字建立TCP连接的过程
     1. 服务器实例化ServerSocket对象，调用accept()方法，等待客户端连接相应端口
     1. 客户端实例化Socket对象，指定地址等参数请求连接，连接建立
     1. 服务端的accept()方法返回新的与客户端连接的socket引用，使用I/O流进行通信，服务端和客户端的输出流和输入流分别相互连接。TCP是双向的，两个数据流可以同一时间发送
### Lambda
1. 理解：表达式，一种语法，为了书写更加简单，就是一段代码赋给变量，同时省去了一些可以省略的写法而成，形式为->。Java 8中用来实现匿名方法，允许函数作为参数传递，可在某些场景作为匿名类的替代方案
    ```Java
    // 遍历
    List<String> items = new ArrayList<>();                     // List
    items.forEach(item->{});
    Map<String, Integer> items = new HashMap<>();               // Map
    items.forEach((k,v)->{});
    ```
1. 函数式编程
### 字节码增强
1. 认识：在类加载的间隙“偷天换日”，修改指令
