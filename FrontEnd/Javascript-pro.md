1. 类
   - Function
     1. 理解：js内建的类，function是简写的创建函数的方法
     1. 方法：call／apply／bind
     1. 实例：`new Function ([arg], functionBody)`
1. 原型链
    ```
         1. new：构造器的形式，有原型，就是new的那个对象
    这个函数对象默认带一个prototype属性，这个属性是对象属性
    2 new构造一个对象，特点是当前原型会指向上级的prototype属性，一直向上————foo.proto————obj.prototype————null
    3 对象上的属性分对象属性和原型链属性，对象属性是先访问的，没有对象属性才去找原型链属性，实现了继承
    ```
     1. 第三种：obj.create:  var obj = obj.create({x:1});
     1. 使用new和create，其原型就会指向他的构造器的prototype属性，属性访问会向上寻找
   - 结构：
     1. 各种属性
       - obj.hasOwnProperty();        是否是对象本身的成员属性
       - obj.defineProperty();        创建属性
       - obj.propertyIsEnumerable();  是否是可枚举的属性(ToString为false)
     1. [{proto}]原型，prototype对象属性
     1. class标签属于哪一类
     1. extensible是否允许增加新的属性
          1. get和set方法使用函数方法设置和读取属性，原型链上有get/set方法，操作相应属性失败，先走get/set方法,想操作用defineProperty
     1. 设置属性Object.defineProperty()，设置多个属性Object.defineProperties();
    ```
    Object.defineProperty(对象,属性名,{
            // 属性标签
            configurable:,
            writable:,
            enumerable:,
            value:值
    })
    多个属性定义，使用get方法
    Object.defineProperties(对象,{
        title:{value:'',enumerable:true},
        luck:{
            get:function() {
                return Math.random() > 0.5 ? 'good' ： 'bad'
            }
        },
    })
    ```

1. 预解释
 - 理解：寻找全局变量(带var)赋undefined和全局函数(带function)放入内存，之后再从第一行运行js代码。所以js先声明后赋值不出错，函数定义位置不影响调用
    ```
    alert(a);
    var a = 100;
    // 和以下的区别，他们都是不会报错的
    // 预解释时var只能声明，不能定义。function声明和定义是同时的
    a = 100;
    alert(a);
    // 所以下面的看结果就知道
    alert(n);
    var n = 10;
    var n = 9;
    var n;
    alert(n)
    // 和function的对比
    fn();
    function fn() {
        alert('1');
    }
    fn();
    function fn() {
        alert('2');
    }
    fn();
    ```
1. 闭包
 - 理解：源于js特有的链式作用域，即子对象会查找父对象的变量并可见，但是子的变量对父不可见。闭包就是把子的变量作返回值给父，即闭包。如下
    ```
    // f2函数为闭包
    function f1(){
        // 函数内部声明变量时，不使用var，实际上声明了一个全局变量
        var n=999;
        function f2(){
            alert(n);
        }
        return f2;
    }
    var result=f1();
    result(); // 999
    ```
 - 总结：js中，只有函数内部的子函数才能读取局部变量，闭包就是一个函数，一个函数内部的函数。也是一座连接函数内部和外部的桥梁。闭包是有数据的行为
 - 用途：获得函数内部变量，使变量长期保留内存
    ```
    // 闭包可以在父函数外部，改变父函数内部的值，常驻内存随时可以使用
    // nAdd没有使用var关键字，因此nAdd是全局变量，nAdd的值是一个匿名函数，匿名函数本身也是一个闭包，所以nAdd相当于是一个setter，可在函数外部对内部的局部变量操作
    function f1(){
        var n=999;
        nAdd=function(){n+=1}
        function f2(){
            alert(n);
        }
        return f2;
    }
    var result=f1();
    result(); // 999
    nAdd();
    result(); // 1000
    ```
 - 注意：退出函数前，不使用的局部变量要全部删除。在外部可改变内部的值
1. 异步
 - 原因：单线程即任何一个函数都是从头到尾——界面更新／鼠标事件／计时器都先排队，后串行执行
 - 定义：javascript的异步编程模式，XHR/异步函数？
 - 对js的理解：js是单线程执行的脚本语言
 - 实际使用
     1. 实现方式：回调函数(注入函数触发)／事件触发(XHR的成功和错误)
     1. 回调与异步：会带来严重的函数嵌套问题，优秀的异步接口设计方案CommonJS
    ```
    // Promises/A
    method()
    .then(function(fs) {
        return fs.method1();
    })
    .then(function(fs) {
       // 链式调用
    });
    ```
     1. 异步同步化：即用同步的方式写异步
1. 回调
 - 定义：一个函数的指针(地址)被用为它指向的函数，这就是回调函数，回调函数不是由该函数的实现方直接调用，而是在特定的事件/方法时另一方调用
 - 对function理解：在js中，function是内置的类对象，就可以储存和传递。回调：是功能性编程技术
 - 回调函数理解：来自函数式编程，是其重要的技术。
 - 代码层理解：将一个函数作为参数传递给其他的函数/方法
    ```
    // 回调举例，将函数传递给了forEach方法
    var friends = ["Mike", "Stacy", "Andy", "Rick"];
    friends.forEach(function (eachName, index){
    console.log(index + 1 + ". " + eachName); // 1. Mike, 2. Stacy, 3. Andy, 4. Rick
    });
    ```
 - 实际使用
     1. 回调赋值方法
    ```
    // 提前定义好
    function name() {
    }
    method(name)
    // 匿名函数
    method(function () {
    })
    ```
     2. 回调可以用在同步/异步中
    ```
    // 同步
    var fun1 = function(callback) {
        callback();
    }
    // 异步
    $.ajax().done(callback);
    ```
     2. 执行回调函数
    ```
    (callback && typeof(callback) === "function") && callback();
    ```
     2. 回调函数传递参数
    ```
    $.get('myhtmlpage.html', myCallBack('foo', 'bar'));//这是错的，那么要带参数呢？
    $.get('myhtmlpage.html', function(){//带参数的使用函数表达式
        myCallBack('foo', 'bar');
    });    
    ```
     1. this/call/apply
    ```
    函数中的回调函数的this指向的是window，call和apply可以保护this对象
    callback.apply (callback);
    ```
   - 属性访问表达式：var o = {x:1}   o.x  o['x']

对象/数组操作：加减：push/splice，合并：to = to.concat(mergeFrom)
  - 检测数据类型：
     1. typeof：适合基本类型的判断，数组、函数、对象都判断为对象，null失效
     1. instanceof:用于判断对象，基于原型链，不能跨ifame
    ```
    obj instanceof Object
    左边操作数上的原型链上是否有右边构造函数的prototype属性
    JavaScript是按引用查找对象，会一直向上查找，
    prototype解释：
    任何构造函数(new之前的)都有prototype属性，他是用new方法构造出的对象的原型
    ```
 - Object.prototype.toString: ie678会把null弄成obj
    ```
    示例：
    Object.prototype.toString.apply([]) === "[object Array]"
    Object.prototype.toString.apply(null) === "[object Null]"
    Object.prototype.toString.apply(undefined) === "[object Undefined]"
    Object.prototype.toString.apply(function(){}) === "[object Function]"
    ```
 - constructor：对象都有constructor属性，指向构造这个对象的构造器，
 - duck type：鸭子
 delete obj.x   变成undefined，去掉对象的值
   - 其他：delete/in/instanceof/typeof/new/this/void(0)
     1. x in window // true   
     1. delete obj.x/不可以删除var定义的变量，无var的隐式定义可以删除     
        - for in: 执行顺序不确定，对象属性的原型链属性也会出现。`for(var x in obj) {}`
   - with：不用加对象来访问属性，层数较多时可以用，不建议使用，严格模式禁止了。`with({x:1}) {}`