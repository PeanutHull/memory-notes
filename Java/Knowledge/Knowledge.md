### 常用类和集合
1. Character类：           
   - isLetter()：是否一字母
   - isDigit()：是否一数字字符
   - isWhitespace()：是否空格
   - isUpperCase/LowerCase()：是否大、小写字母
   - toUpperCase/toLowerCase()：设置大、小写
   - toString()：返回字符的字符串形式
1. String类的方法
   - int length()：长度
   - concat()：连接
   - charAt()：指定位置的值，返回的值可以为char`char charAt(int index)`
   - copyValueOf()：返回数组中指定的偏移和长度的字符串。`public static String copyValueOf(char[] data, int offset, int count)`
   - indexOf()：字符在此字符串第一次出现的索引，二参为开始搜索位置`int indexOf(String/int, int ch)`
   - lastIndexOf()：字符串最后一次出现的索引`int lastIndexOf(int ch, int fromIndex)`
   - equals()：与String对象进行比较，返回布尔值`boolean equals(Obj obj)`
   - equalsIgnoreCase()：与String对象进行比较忽略大小写，返回布尔值`boolean equalsIgnoreCase (String str/String str)`
   - compareTo()：与String对象进行比较，相等返回int0，小于为负数，大于为正数`int compareTo(Obj obj)`
   - compareToIgnoreCase()：与String对象进行比较，比较时忽略大小写`int compareToIgnoreCase (String str)`
   - contentEquals()：将此字符串与StringBuffer比较是否相同`boolean contentEquals(StringBuffer sb)`
    ```Java
    String str1 = "String1";
    String str2 = "String2";
    StringBuffer str3 = new StringBuffer( "String1");
    boolean result = str1.contentEquals( str3 ); // true
    result = str1.contentEquals( str3 ); // false
    ```
   - trim()：去掉前后空白`String trim()`
   - replace()
   - replaceAll()
   - replaceFirst()
   - split()：正则拆分字符串`String[] split(String regex, [int limit])`
   - substring()：返回新子字符串`String substring(int beginIndex)`
   - matches()：是否匹配给定的正则`boolean matches(String regex)`
   - regionMatches()
   - intern()：String 返回字符串的规范化表示形式`String intern()`
   - hashCode()：int hashCode()，哈希值`Int hashCode()`
   - startsWith()：是否以指定的后缀结束`boolean startsWith(String str)`
   - endsWith()：是否以指定的后缀结束`boolean endsWith(String str)`
   - getBytes()：使用字符集将字符串编码为byte序列`byte[] getBytes()`
    ```Java
    byte[] Str2 = Str1.getBytes();
    Str2 = Str1.getBytes( "UTF-8" );
    Str2 = Str1.getBytes( "ISO-8859-1" );
    ```
   - getChars()：将字符串复制到字符数组`void getChars(int srcBegin, int srcEnd, char[] dst, int dstBegin)`
   - toCharArray()：转为字符串数组`char[] toCharArray()`
   - toLowerCase()：所有转为小写`String toLowerCase([Locale locale])`
   - toUpperCase()：所有转为小写`String toUpperCase([Locale locale])`
   - format()：格式化字符串
1. Arrays类：java提供的工具类，包为java.util.Arrays ，包含排序、搜索等方法
   - 排序：`Arrays.sort();`
   - 查找：binarySearch：`int binarySearch(Obj[] a, Obj key)`
   - 比较：equals：`boolean equals(long[] a, long[] a2)`
   - Arrays.toString(Array);
1. BitSet类
   - `void and(BitSet set)` // 逻辑与操作
   - `void andNot(BitSet set)` // 清除此BitSet中所有的位
   - `int cardinality()` // 返回为true的位数
   - `void clear()` // 全部位置为false
   - `void clear(int index)` // 指定位置为false
   - `void clear(int startIndex, int endIndex)` // 指定位置为false
   - `boolean get(int index)` // 返回索引处位值
   - `BitSet get(int startIndex, int endIndex)` // 返回索引处位值
1. Vector向量
   - `void add(int index, Object element)` // 添加元素
   - `boolean add(Object o)` // 添加到末尾
   - `boolean addAll(int index, Collection c)` // 指定位置插入集合中所有值
   - `int capacity()` // 返回当前容量
1. Stack栈
   - `boolean empty()` // 是否为空
   - `Object peek()` // 查看顶部对象，不移除
   - `Object pop()` // 返回顶部并移除
   - `Object push(Object element)` // 把元素压入顶部
   - `int search(Object element)` // 对象在堆栈的位置，1为基数
1. Dictionary字典
   - `boolean isEmpty()` // 是否空字典
   - `int size()` // 数量
   - `Object get(Object key)` // 返回键对应的值
   - `Object put(Object key, Object value)` // 插入或更新
   - `Object remove(Object key)` // 删除
   - `Enumeration keys()` // 返回字典中键的枚举
   - `Enumeration elements()` // 返回字典中值的枚举
1. HashTable哈希表
   - `Object get(Object key)` // 返回值
   - `Object put(Object key, Object value)` // 添加或更新
   - `Object remove(Object key)` // 删除
   - 
   - `boolean contains(Object value)` // 此映射表中是否存在与指定值关联的键
   - `boolean containsKey(Object key)` // 是否存在键
   - `boolean containsValue(Object value)` // 是否存在值
   - `boolean isEmpty()` // 是否为空
   - `int size()` // 键的数量
   - 
   - `Enumeration keys()` // 返回键的枚举
   - `Enumeration elements()` // 返回值的枚举
   - `String toString()` // 返回哈希对象的字符串表示形式
   - 
   - `void clear( )` // 清空
   - `Object clone()` // 创建浅表副本
   - `void rehash()` // 增加此哈希表的容量并在内部对其进行重组，以便更有效地容纳和访问其元素
1. Properties属性
   - `load(InputStream streamIn)` // 从输入流中读取属性列表
   - `propertyNames( )` // 按简单的面向行的格式从输入字符流中读取属性列表
   - `list(PrintStream streamOut/PrintWriter streamOut)` // 属性列表输出流
   - `getProperty(String key)` // 搜索属性
   - `getProperty(String key, String defaultProperty)` // 搜索属性
   - `setProperty(String key, String value)` // 调用Hashtable的put方法
   - `store(OutputStream streamOut, String description)` // 输出配置
   - `clear()` // 清楚装载的配置
1. Collections工具类：对集合进行操作，`Java.util.Collections`
1. Map
   - `Object get(Object k)` // 通过键返回值，不存在为null
   - `Object put(Object k, Object v)` // 更新或添加
   - `Object remove(Object k)` // 通过键删除
   - `void putAll(Map m)` // 一个映射复制到另一个映射
   - `boolean equals(Object obj)` // 比价指定的对象和此映射是否相同
   - `boolean containsKey(Object k)` // 是否存在指定键
   - `boolean containsValue(Object v)` // 是否存在指定值
   - `int size( )` // 返回关系数量
   - `boolean isEmpty()` // 是否为空
   - `void clear( )` // 删除所有映射关系
   - `Set keySet( )` // 返回键的Set视图
   - `Collection values( )` // 返回值的Collection视图
   - `Set entrySet( )` // 返回映射关系的Set视图
   - `int hashCode()` // 返回映射的哈希码值
1. Date日期
   - alter()/before()：是否在日期之前/之后
   - clone()：返回副本
   - compareTo()：和日期对比。相同为0，在指定之前为负，之后为后
   - equals()：对比是否相同
   - getTime()：获得时间戳
   - hashCode()：此对象哈希值
   - setTime()：用时间戳设置时间
   - toString()：转换Date为String
1. Math类
   - 定义：提供了基本数学运算的属性和方法。如初等函数、对数、平方根和三角函数，都是静态函数
   - 示例
        ```Java
        Math.sin(Math.PI/2) // 90 度的正弦值 
        ```
   - 常用方法：
     1. x.byteValue()：将Number对象转换为基本数据类型。如short/int/long/float/doubleValue();
        ```Java
        Integer x = 1;
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
        Integer x = 1;
        Integer y = 1;
        System.out.println(x.equals(y));
        ```
     1. compareTo(param)：将number对象和参数比较。同类型数据比较，返回值：0相等、小于参数-1、大于1
     1. abs()：绝对值
     1. ceil、floor、rint()：对整形变量向左、右取整、最接近的整数，返回double类型
     1. round()：返回最接近的int、long值
     1. min、max()：两个参数得最大小值
     1. random()：返回随机值，0到1之间，无参数
1. url
   - url类
     1. URL // 创建url
     1. getHost/getPath/getQuery()/getRef()
     1. openConnection()
   - URLConnections类
     1. getContent()
     1. getContentLength()
     1. getLastModified()/getExpiration
     1. InputStream/OutputStream
1. UUID
   - 理解：算法的核心思想是结合机器的网卡、当地时间、一个随即数来生成GUID，从理论上讲，如果一台机器每秒产生10000000个GUID，则可以保证（概率意义上）3240年不重复。java 5新增
    ```Java
    import java.util.UUID;
    UUID.randomUUID().toString();
    ```
### java-pro
1. Thread类
```Java
run()                                               被覆盖方法
start()                                             线程开始执行，JVM调用run方法    
yield()                                             暂停当前进程，执行其他进程
sleep(long millisec)                                毫秒数休眠
join(long millisec)                                 设置等待该线程的最长时间
interrupt()                                         中断线程
isAlive()                                           检测是否处于活动状态

Thread currentThread()                              返回对当前正在执行的线程对象的引用

setName(String name)/setPriority(int priority)      设置名字、优先级
setDaemon(boolean on)                               设为守护线程或用户线程

boolean holdsLock(Object x)                         当且仅当当前线程在指定的对象上保持监视器锁时，才返回 true

dumpStack()                                         将当前线程的堆栈跟踪打印至标准错误流
```
### javaee
1. servlet
   - request
    ```Java
    getRemoteAddr()              // 获取请求者ip
    getAuthType()                // 如SSL、BASIC，无则null
    getHeaderNames()
    getHeader(String name)
    getMethod()
    getQueryString()             // get参数
    getContentLength()           // post的长度，字节为单位，未知为-1
    getAttribute()               // 以对象形式返回属性，无则null
    getParameterMap()            // 以map形式返回属性
    getCookies()            
    getSession()                 // 获取session对话，无则创建
    ```
   - response
    ```Java
    setStatus()                  // 设置状态码
    addHeader()
    setHeader()
    setContentLength()
    addCookie()

    setBufferSize()              // 为响应主体设置首选缓冲大小
    flushBuffer()                // 缓冲写入客户端
    resetBuffer()                // 清除缓冲区内容，不清除状态码和头
    reset()                      // 都清除
    sendError()                  // 出现tomcat原生的错误页面
    sendRedirect()               // 302跳转，带一个location头
    ```
   - out
     1. getBufferSize：缓冲区字节数
   - cookie类：`javax.servlet.http.Cookie`
    ```Java
    getName()
    getValue()/setValue()
    setPath()
    getDomain()/setDomain()      // cookie的域
    getMaxAge()/setMaxAge()
    setSecure()/getComment()/setComment(String purpose)
    ```
   - session
    ```Java
    isNew()
    getId()                     // 返回唯一标识符
    getCreationTime()
    getLastAccessedTime()
    removeAttribute()
    getAttributeNames()         // 返回名称集
    getValueNames()
    ```
   - Locale
    ```Java
    getCountry()                 // 两个大写字母形式的ISO 3166格式国家代码
    getDisplayCountry()          // 国家名称
    getLanguage()                // 小写字母的 ISO 639格式语言代码
    getDisplayLanguage()         // 语言名称
    getISO3Country()             // 国家的3个字母缩写
    getISO3Language()            // 语言的3个字母缩写
    ```
1. jsp
   - 指令标记：page的属性
     1. language：指定页面的脚本语言，默认java
     1. import：指定使用的类
     1. contentType：MIME和字符编码
     1. extends：指定Servlet继承
     1. info：页面的描述信息
     1. session：是否使用session
     1. errorPage：发生错误转向的错误页面
     1. isErrorPage：表示本页面是否可作为错误页面
     1. buffer：out对象使用缓冲区的大小
     1. autoFlush：控制out对象的缓冲区
     1. isELIgnored：是否执行EL表达式
     1. isScriptingEnabled：脚本元素是否能被使用
     1. isThreadSafe：指定对页面的访问是否为线程安全
   - 标记别名
     1. <%! %>：声明，<jsp:declaration></jsp:declaration>
     1. <%= %>：表达式，<jsp:expression></jsp:expression>
     1. <% %>：脚本，<jsp:scriptlet></jsp:scriptlet>
   - JSTL
     1. 安装：将官方jsp的jar包放到`/WEB-INF/lib/`下
        ```XML
        <jsp-config>                                                        // web.xml配置
            <taglib>
                <taglib-uri>http://java.sun.com/jstl/fmt</taglib-uri>
                <taglib-location>/WEB-INF/fmt.tld</taglib-location>
            </taglib>
        </jsp-config>
        <%@ taglib uri="http://java.sun.com/jsp/jstl/core(fmt/sql/xml/functions)" prefix="c"%>    // jsp页面中导入核心标签库
        ```
     1. 格式化标签
        - `<fmt:formatNumber>` // 针对指定格式或精度的数字
        - `<fmt:parseNumber>` // 解析代表数字、货币、百分比的字符串
        - `<fmt:formatDate>` // 针对日期和时间
        - `<fmt:parseDate>` // 解析代表日期和时间的字符串
        - `<fmt:setLocale>` // 指定地区
        - `<fmt:timeZone>` // 指定时区
        - `<fmt:setTimeZone>` // 指定时区
        - `<fmt:bundle>` // 绑定资源
        - `<fmt:setBundle>` // 绑定资源
        - `<fmt:message>` // 显示资源配置文件信息
        - `<fmt:requestEncoding>` // 设置request的字符编码
     1. sql标签
        - `<sql:setDataSource>` // 指定数据源
        - `<sql:query>` // 运行查询语句
        - `<sql:update>` // 运行更新语句
        - `<sql:param>` // 设置sql语句的参数
        - `<sql:dateParam>` // 将SQL语句中的日期参数设为指定的java.util.Date值
        - `<sql:transaction>` // 执行事务语句
     1. xml标签
        - `<x:out>` // 类似<%= ... >，只用于XPath表达式
        - `<x:parse>` // 解析xml
        - `<x:set>` // 设置XPath表达式
        - `<x:if>` // 判断XPath表达式
        - `<x:forEach>` // 迭代xml的节点
        - `<x:choose>/<x:when>/<x:otherwise>` // 
        - `<x:transform>` // XSL转换应用在XML中
        - `<x:param>` // 和<x:transform>共同使用，用于设置XSL样式表
     1. JSTL函数
        - `fn:length()` // 字符串长度
        - `fn:join()` // 字符串合并
        - `fn:replace()` // 替换字符串
        - `fn:split()` // 分割字符串
        - `fn:trim()` // 移除首尾空白
        - `fn:toLowerCase()/fn:toUpperCase()` // 转大小写
        - `fn:indexOf()	` // 返回指定字符串出现的位置
        - `fn:substring()/fn:substringAfter()/` // 返回(之前/之后)的子串
        - `fn:contains()/fn:containsIgnoreCase()` // 测试字符串是否包含指定的子串
        - `fn:startsWith()` // 是否以指定开头开始
        - `fn:endsWith()` // 是否以指定后缀结尾
        - `fn:escapeXml()` // 跳过可以作为XML标记的字符
### 零散
1. 汇总
   - main必须是public的，否则解释器不能运行此类
   - 动/静态语言，编译/解释
   - 线程安全=同步访问
   - instanceof和isInstance
     1. instanceof：`obj.instanceof(class)`，对象是不是类/接口的实现，凡是null的都是false`null.instanceof(class)`
     1. isInstance：对象能不能被转化为这个类/接口
1. 中文处理
    ```Java
    String str = java.net.URLEncoder.encode("中文"，"UTF-8");
    String str = java.net.URLDecoder.decode("编码后的字符串","UTF-8");
    ```
1. Servlet
   - 调试：`System.out.println()`，输出的信息会记录在web服务器日志里
   - 跳转：/表示根目录
	```Java
	response.sendRedirect(request.getContextPath + "/要跳转的页面相对地址"); // 重定向，地址改变
	request.getRequestDispatcher("/要跳转的页面相对地址").forward(request, response); // 转发请求，地址不变
	```
1. 进制
   - 0表示8进制，0x表示16进制
   - 整形可以用十、八、十六进制表示
   - 字符型可以包含unicode字符：char a = '\u0001';
   - 转义字符：\n换行，\r回车
1. 对象序列化
   - 理解：JVM独立的，可进行可序列化和反序列化
   - 对象被序列化成功的条件：
     1. 必须实现java.io.Serializable对象
     1. 类的所有属性必须是可序列化的，即不被transient修饰或者不是静态变量
   - 操作
     1. 序列化
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
     1. 反序列化
        ```Java
        FileInputStream fileIn = new FileInputStream("/tmp/employee.ser");
        ObjectInputStream in = new ObjectInputStream(fileIn);
        e = (Employee) in.readObject();
        in.close();
        fileIn.close();
        ```
   - 相关类：Externalizable，表示没有任何东西可以自动序列化，需要在writeExternal方法中进行手工指定
### 其他
1. 常见包
   - java.lang：语言包，Number/Character/Boolean、String、Math、Object、Class、Thread、Process、Throwable
   - java.util：工具包，Array/Vector/Dictionary/Collection/map、Date、Random/UUID
   - java.text：处理文本、日期、数字和消息的类和接口
   - java.io/net/sql/awt/swing
   - apache.commons.lang/beanutils
   - google.guava
1. 常用类库
   - 日志：apache-log4j、Logback、slf4j-api
   - Json：Jackson、Gson
   - XML：jdom、dom4j、xercesImpl
   - 日期：joda.time
   - Jsoup：分析html
   - Lomobok：消除冗长代码
1. 关键字
   - 数据类型：byte、short、int、long、float、double、char、boolean
   - 流程控制
     1. if、else、switch、case、default
     1. for、do、while、break、continue
     1. return、void
   - 异常：try、catch、finally、throw、throws
   - 修饰符：vstrictf、native、volatile、synchronized、transient
   - 判断：assert、instanceof
   - 面向对象
     1. 包： package、import
     1. 接口： interface、implements
     1. 抽象类： abstract、extends
     1. 类： class、new、this、super
     1. 修饰符： private/protected/public、static、final
   - 预留关键字：goto，const
1. 基础
   - 基础：数据类型, 操作符, 运算符, 表达式
   - 面向对象：类
   - 常用类：String
   - 集合类：ArrayList，HashSet，HashMap
   - 反射、注解、泛型
   - 多线程：Thread, Runnable, Future
   - I/O：File, IO, NIO, InputStream, OutputStream, Reader, Writer, Selector
   - JDBC、网络编程
   - 设计模式、IOC依赖注入, AOP面向切面编程
   - JVM
1. 知识点
   - 环知识点：基础，web开发，常用框架，设计模式，数据库和网络，数据结构和算法
   - 扩展知识点：多线程 NIO 并发 jvm 分布式 mysql redis mq 微服务
1. 关键字
   - 高级关键字
     1. quartz
     1. 事务管理
     1. 连接池
     1. dubbo
     1. 分布式
     1. Netty
     1. CDN
     1. Elasticsearch
     1. solr
     1. mysql集群
     1. JVM性能调优
     1. 负载均衡
1. 关键功能具备
   - 异步任务
   - 缓存
   - 日志
1. 轻量级容器
   - 理解：提供了可插拔的体系结构
   - 容器提供的服务
     1. 声明周期管理
     1. 依赖解析
     1. 组件查找
     1. 应用程序配置
     1. 事物管理
     1. 安全性
     1. 线程管理
     1. 对象和资源池
     1. 对组件的远程访问
     1. 通过JMX之类的API管理组件
     1. 容器的扩展和定制
   - 控制反转
