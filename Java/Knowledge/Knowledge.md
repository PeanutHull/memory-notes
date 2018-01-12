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
### 设计模式
1. 建造者模式
   - 理解：就是用一个建造类建造一个类让对象更方便建造
   - 特点
     1. 良好封装性，使用者可以不用了解内部组成就创建可使用的对象
     1. 建造者独立，被建造类容易扩展
   - 实例：建造几个王者荣耀英雄
     1. 被建造类
        ```java
        public class HeroConfig{
            HeroBuilder mbuilder = null;
            // 英雄的三个技能
            private String firstSkill;
            private String secondSkill;
            private String thirdSkill;
            private String TPeffect = "无回城特效";

            public HeroConfig(HeroBuilder builder) {
                mbuilder = builder;
                init();
            }
            private void init() {
                if(mbuilder.firstSkill != null) {
                    firstSkill = mbuilder.firstSkill;
                }
                if(mbuilder.secondSkill != null) {
                    secondSkill = mbuilder.secondSkill;
                }
                if(mbuilder.thirdSkill != null) {
                    thirdSkill = mbuilder.thirdSkill;
                }
                if(mbuilder.TPeffect != null) {
                    TPeffect = mbuilder.TPeffect;
                }
            }
            @Override
            public String toString() {
                return "技能1-->" + firstSkill + " 技能2-->" + secondSkill + " 技能2-->" + thirdSkill + " 回城特效-->" + TPeffect;
            }
        }
        ```
     1. 建造者(即建造执行者)
        ```java
        public static class HeroBuilder{
            // 英雄的三个技能
            private String firstSkill;
            private String secondSkill;
            private String thirdSkill;
            private String TPeffect; // 回城效果

            // 英雄的三个技能是必选的，回城的特效是可选的，所以构造方法只设置三个技能
            public HeroBuilder(String firstSkill, String secondSkill, String thirdSkill) {
                this.firstSkill = firstSkill;
                this.secondSkill = secondSkill;
                this.thirdSkill = thirdSkill;
            }

            public HeroConfig create() {
                HeroConfig mHeroConfig = new HeroConfig(this);
                return mHeroConfig;
            }

            public HeroBuilder builderTPeffect(String effect) {
                this.TPeffect = effect;
                return this; // 实现链式调用
            }
        }
        ```
     1. 使用，来建造类
        ```java
        HeroConfig.HeroBuilder("","","").BuilXX("").create();
        HeroConfig 韩信 = new HeroConfig.HeroBuilder("无情冲锋","背水一战","国士无双").BuilTPeffect("金光闪闪").create();
        ```
### 常用类
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
1. UUID
   - 理解：算法的核心思想是结合机器的网卡、当地时间、一个随即数来生成GUID，从理论上讲，如果一台机器每秒产生10000000个GUID，则可以保证（概率意义上）3240年不重复。java 5新增
   - 使用
   ```Java
   import java.util.UUID;
   UUID.randomUUID().toString();
   ```
### 其他
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