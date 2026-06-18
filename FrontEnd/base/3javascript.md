### Javascript
1. Javascript
   - 认识：解释执行的、基于原型的、动态类型/弱类型(变量类型可变)的脚本语言
   - 特点
     1. 具有一等函数（first-class functions）
   - 组成
     1. ECMAScript，基础语法
     1. DOM：文档对象模型，网页内容的方法和接口，一组用来描述脚本怎样与结构性文档进行交互和访问的Web标准。DOM定义了一系列的对象、方法和属性，用于访问、操作和创建文档中的内容、结构、样式以及行为。
     1. BOM：浏览器对象模型，与浏览器交互的方法和接口
        - 调用父级方法：`parent.method()`，parent为window.parent的简写
        - 打开新窗口：`window.open`
        - cookie
          1. session cookie：临时cookie，浏览器关闭就删除
          1. persistent cookie：持久化cookie
        - 数据类型
          1. number、string、boolean、null、undefined
          1. object：function、array、date
          1. 包装对象：访问基本类型数据会自动转为对应的包装类型对象，临时对象用完即销毁
1. 语法
   - 使用unicode字符集，区分大小写
   - 注释：单行//、多行/* */
1. 标识符
   - 认识：用来命名变量、函数、属性的名称。可包含字母、数字、下划线 _、美元符号 $，不能以数字开头
   - 关键字
     1. this
1. 数据类型
   - 基本类型/值类型
     1. boolean：布尔，true、false
     1. number：数字，可带小数点也可不带
     1. string：字符串，可使用单引号或双引号，es6加入`
     1. undefined：未定义，不含有值
     1. null：空，来清空变量
     1. symbol：表示独一无二的值，es6
     1. bigInt：es2020
   - 引用类型/对象类型
     1. array：数组
     1. set：集合
     1. object：对象
     1. function：函数
     1. date：日期
     1. regexp：正则
   - 类型转换
     1. 会自动进行类型转换，可能会导致一些非预期行为
     1. 显性转换：Number()、String()、Boolean()等函数
1. 运算符
   - 算数操作符：+ - * / %
   - 比较操作符：== === != !== > < >= <=
   - 逻辑操作符：&& || !
   - 位操作符： & | ^ ~ << >> >>>
   - 其他：字符串连接符+、三元操作符? :、delete、typeof、instanceof
1. 数组
   - 认识：[]
   - 方法
     1. Array.indexOf
     1. Array.every：回调函数遍历
     1. Array.some：回调函数指定元素遍历
     1. Array.forEach
     1. Array.map
     1. Array.filter
     1. Array.reduce
     1. Array.isArray            相比typeof返回的object，instanceof返回的ie错误
     1. Array.forEach()：`array.forEach(function(currentValue, index, arr), thisValue)`
        - 特点
          1. 不会改变原数组
          1. 范围在第一次调用回调函数之前就已确定，调用之后添加到数组中的项不会被遍历到
          1. 未被遍历到的元素被改变会读到已改变的，已删除或未初始化的索引不会被遍历到
          1. 无法中途停止或跳出循环，除非抛异常，这种情况可使用简单循环、for...of或Array.prototype.every()、Array.prototype.some()
          1. 
        - 参数
          1. currentValue：必需，数组中正在处理的当前元素
          1. index：可选，数组中正在处理的当前元素的索引
          1. arr：可选，forEach正在操作的数组
          1. thisValue：可选，执行回调时使用的`this`值
   - 实例
     1. 新增
        ```js
        // 定义
        let arr = [1, 2, 3];  
        // 赋值
        arr[3] = 4;

        // 添加
        arr.push(4);                    // 末尾追加，并返回新的长度
        arr.unshift(4);                 // 开头追加，并返回新的长度
        // 任意位置添加
        arr.splice(2, 0, 4);            // arr is now [1, 2, 4, 3]

        // 修改
        newArr = arr.filter(function(item) {                        // es6，false会删除
            return item !== "xxx"
        });
        let template = tmplIds.filter(k => r[k] === 'accept');      // 从tmplIds数组中筛选出那些在对象r中对应值为'accept'的元素，并将这些元素作为一个新数组赋值给变量template。举例来说，如果tmplIds是['id1', 'id2', 'id3']，并且对象r是{ id1: 'accept', id2: 'reject', id3: 'accept' }，那么template的值将会是['id1', 'id3']
        // slice不会改变原数组，而是返回新数组
        arr.slice(0, 1).concat(arr.slice(2));

        // 删除
        arr.pop(4);                     // 末尾删除，并返回新的长度
        arr.shift(4);                   // 开头删除，并返回新的长度
        // 位置 + 数量
        arr.splice(1, 1);
        
        // 连接
        arr = arr.concat([4]);          // arr is now [1, 2, 3, 4]

        // 遍历
        fruits.forEach(function(item, index) {});
        for (const value of arr) {}
        ```
   - 应用实例
    ```js
    // 按照年份分成二维数组
    list.forEach((obj, i) => {
        obj.playTime = formatTime(obj.createdAt, 'yyyy.MM.dd');
        obj.playYear = obj.playTime.slice(0, 4);
        if (info[obj.playYear]) {
            info[obj.playYear].recordList.push(obj);
        } else {
            info[obj.playYear] = { hasRetract: i === 0 ? true : false };
            info[obj.playYear].recordList = [obj];
        }
    });
    this.userScriptList = Object.assign(this.userScriptList, info);
    ```
1. 集合
   - 认识：set，存储原始值或引用对象的唯一值，es6
     1. 唯一性：内部唯一
     1. 不会发生类型转换：2和"2"被认为是两个不同的值
     1. 有序：迭代顺序是插入顺序
   - 属性
     1. size：数量
   - 方法
     1. add(value)：如已存在忽略操作
     1. delete(value)：如果元素存在并被成功删除返回true，否则false
     1. has(value)：如果存在返回true，否则返回false
     1. clear()：清空所有元素
   - 实例
    ```js
    // 声明
    let mySet = new Set([1, 2, 3, 4, 5]);           // 数组中重复的值会被忽略
    ```
1. 变量、常量
   - 认识
     1. es6之前变量作用域只有两种，函数外的全局变量和函数内的局部变量
     1. 一条语句定义多个变常量用逗号隔开
   - 变量
     1. var：声明函数作用域或全局作用域的变量，可先使用后声明。二者不可混合修改同一变量，全局作用域二者作用类似
     1. let：声明块作用域的局部变量，不可先使用后声明，es6
   - 常量
     1. const：声明块作用域的常量。声明的是常量引用，被声明的对象或数组是可变的
   - 用法
     1. 解构赋值：Destructuring Assignment，语法，从一个对象中提取多个属性，并将这些属性作为变量赋值到当前的作用域中
        ```js
        const {
            id, 
            type,
            Param,
            status,
            name,
        } = obj;
        ```
   - 最佳实践
     1. 避免var，因为其作用域规则可能导致难以发现的错误
     1. 推荐const，除非你确知变量的值需要改变
1. 流程控制
   - 判断：if、else if、else、switch
     1. if () {} else {}
   - 循环
     1. for
     1. while
     1. do...while
     1. for...in：遍历对象的所有可枚举的包括继承的可枚举的属性，每次迭代中都会将对象的键赋值给循环变量
        ```js
        // 语法，没有别的了，只取键
        for (const key in obj) {}

        // 过滤掉继承的属性
        for (const key in obj) {
            if (obj.hasOwnProperty(key)) {
            }
        }
        ```
     1. for...of：用于迭代可迭代对象的值，包括数组、字符串、map、set，直接获取值，不能直接用于普通对象因为其不是内置的可迭代对象会抛出错误，es6
        ```js
        for (const value of arr) {}
        ```
     1. label
     1. break
     1. contin
1. 函数
   - 理解：js可以声明/调用/传参/返回函数，是function类的实例。其他语言函数是二等公民
     1. js块：{}声明
   - 分类
     1. 匿名函数/函数表达式：`var myfunc = function() {}`
     1. 箭头函数
        - 认识：Arrow Functions，更简洁的不绑定自己的this、arguments、super或new.target的写函数表达式的方式，适合使用函数表达式的地方如回调函数
        - 特点
          1. 没有自己的this：箭头函数内的this值等同于它所在上下文的this值，这使得箭头函数特别适合用作回调函数
          1. 不可作为构造函数：不能使用new关键字调用箭头函数，因为箭头函数内部没有自己的this，所以也就没有构造方法
          1. 内部没有arguments对象：如果要访问函数的参数列表，使用剩余参数`...args`
          1. 不能用作生成器函数：不能使用yield关键字
        - 形式：`const funcName = (参数1,参数N) => 表达式`
          1. 只有一个参数可以省略参数周围的括号
          1. 如果函数体只是个表达式可以省略大括号，函数会隐式返回表达式的值
   - 方法
     1. Function.bind
     1. Function.call
     1. Function.apply
   - 实例
    ```js
    // 声明
    function myfunc() {}
    var myfunc = function() {}

    // 传值
    function myfunc(callback){callback()}
    
    // 箭头函数
    const sayHello = () => console.log("Hello!");           // 无参数
    sayHello();

    const square = x => x * x;                              // n个参数
    square(5);
    const add = (a, b) => a + b;
    add(5, 3);
    const multiply = (a, b) => {
        let result = a * b;
        return result; // 需要明确返回值
    };
    ```
1. 异常
   - try/catch
    ```js
    try{

    }catch() {

    }finally {

    }
    ```
1. 模块化
   - import/export：导入导出
1. 应用
   - json
     1. JSON.parse(jsonstr);          json字符串转json对象
     1. JSON.stringify(jsonobj);      json对象转换成json对符串
### 面向对象
1. 对象
   - 认识：{k1:v1,k2:v2}，键值对的、属性无序的，键是字符串，值可以是任何类型
   - 组成
     1. 属性：obj.xx
     1. 方法：obj.xxx()
   - 方法：Object，es2017
     1. Object.keys(obj)：输出键
     1. Object.values(obj)：输出值
     1. Object.entries(obj)：输出包含字段名的键值对，如[["field1", "xx"], ["field2", xx]]
     1. Object.create
     1. Object.defineProperties
   - 操作
    ```js
    // 声明
    var obj = {x:1}
    new

    // 创建
    对象字面量
    构造函数
    Object.create()

    // 读取
    obj.xxx                             // 点运算符
    obj["xxx"]                          // 方括号运算符
    var propName = "name";              // 使用变量访问属性
    obj[propName];

    // 赋值
    obj.xx = xx
    obj.['x']？？？
    obj["xx"] = xx

    // 遍历
    for (const key in obj) {}
    ```
1. this
   - 认识：被用于引用执行上下文中的当前对象的关键字
   - 分类
     1. 全局对象this：在任何函数之外，在浏览器中等于window
     1. 函数上下文中的this
        - 普通函数：非严格模式指向全局对象，否则this为undefined
        - 函数作为对象的方法被调用时，this指向这个对象
            ```javascript
            const obj = {
                show: function() {
                    console.log(this);
                }
            };
            obj.show();                     // this指向obj
            ```
        - 构造函数：使用new关键字调用构造函数时，指向新创建的对象
            ```javascript
            function Person(name) {
                this.name = name;
            }
            const person = new Person('Alice');
            console.log(person.name);       // Alice
            ```
        - 箭头函数：箭头函数不绑定自己的this，它会捕获其所在上下文的`this`值作为自己的`this`值，无论它是如何被调用的
            ```javascript
            const obj = {
                show: () => {
                    console.log(this);
                }
            };
            obj.show();                     // 在浏览器中，箭头函数中的this指向window，因为它捕获了全局上下文中的this
            ```
     1. 显式绑定this：Function.prototype
        ```js
        // call、apply，都会立即执行函数，call接收一个参数列表，apply接收包含多个参数的数组
        function introduce(name) {
            console.log(`My name is ${name}, and I am ${this.age}.`);
        }

        const person = { age: 30 };

        introduce.call(person, 'Alice');
        introduce.apply(person, ['Alice']);

        // bind，返回一个新函数，当被调用时，这个新函数的this被指定为bind的第一个参数
        const introduceAlice = introduce.bind(person, 'Alice');
        introduceAlice();
        ```
1. 原型链
   - 认识：是一种允许对象继承另一个对象的属性和方法的机制，是js对象之间实现继承的方式
     1. 每个js对象都有一个对另一个对象的引用的内部属性 prototype，即该对象的原型，通过__proto__属性或Object.getPrototypeOf()方法访问，访问属性或方法时对象本身没有会递归在对象的原型上找
   - 示例
    ```js
    function Person(name) {
        this.name = name;
    }

    Person.prototype.sayHello = function() {
        console.log('Hello, my name is ' + this.name);
    };

    var person1 = new Person('Alice');
    person1.sayHello();                                                 // 输出：Hello, my name is Alice
    console.log(person1.__proto__ === Person.prototype);                // 输出：true
    console.log(person1.__proto__.__proto__ === Object.prototype);      // 输出：true
    console.log(person1.__proto__.__proto__.__proto__);                 // 输出：null
    ```
### 异步
1. 异步编程
   - 回调函数
    ```js
    // print是一个回调函数
    function print() {
        document.getElementById("demo").innerHTML="RUNOOB!";
    }
    setTimeout(print, 3000);
    ```
   - promise
     1. 认识：表示异步操作最终完成/失败及其结果值，为异步操作提供了更加灵活强大的方式，避免了回调地狱(回调函数中嵌套多个回调函数)，通过链式调用`.then()`和`.catch()`可更清晰的方式来组织异步逻辑
        - 之前依赖callback回调函数处理
     1. 组成
        - 状态
          1. Pending 等待中：异步操作尚未完成，Promise对象的初始状态。
          1. Fulfilled 已实现：异步操作已经完成，并且成功返回了结果值
          1. Rejected 已拒绝：异步操作失败，返回了一个错误
        - 方法：处理异步操作的结果
          1. then(onFulfilled, onRejected)`：添加处理异步操作成功(fulfilled)和失败(rejected)的回调函数
          1. catch(onRejected)：添加处理异步操作失败（rejected）的回调函数，是`then(null, onRejected)`的语法糖
          1. finally(onFinally)：添加一个回调函数，无论异步操作成功还是失败都会执行
        - 静态方法：处理多个promise
          1. `promise.all(iterable)`：等待所有的Promise成功解决或任何一个被拒绝
          1. `promise.race(iterable)`：等待最先一个Promise解决或被拒绝
          1. `promise.allsettled(iterable)`：等待所有的Promise被解决或被拒绝，不关心结果是成功还是失败
          1. `promise.any(iterable)`：等待任何一个Promise成功解决，如果所有的Promise都失败了，则返回一个聚合错误
   - async/await
    ```js
    // 效果展示
    print(1000, "First").then(function () {             // 原函数
        return print(4000, "Second");
    }).then(function () {
        print(3000, "Third");
    });

    async function asyncFunc() {                        // 优化函数
        await print(1000, "First");
        await print(4000, "Second");
        await print(3000, "Third");
    }
    asyncFunc();
    ```
   - yield
   - generator
### wiki
1. 最佳实践
   - 当存在一个可以快速来回切换的页面在请求接口时，应该加一个全部flag变量，来防止叠加请求接口
   - 课件渲染技术方案：自定义json -> react 虚拟dom树 -> canvas（底层渲染，可切换cocos等）
1. JSX
   - 认识：是js的语法扩展，允许在js中编写jsx标签(类似html的结构)，这种语法使得创建/维护/删除组件的结构更加直观
   - ESLint：开源的js和JSX代码质量和风格检查工具。用于识别代码的编码规范。目的是帮助开发人员遵循一致的编码风格和避免常见的编程错误
1. 历史
   - ECMAScript：是JavaScript的标准规范，ES6是5.1以后的下一代标准的JavaScript，包含了ES2015、ES2016、ES2017等
     1. ECMAScript 1.0： 96年，Netscape提交到ECMA(标准化组织)成为国际标准，即ECMA-262
     1. ECMAScript 5.1： 11年
     1. ECMAScript 6.0： 15年，简称ES2015
     1. ECMAScript 6.1： 16年，新增了数组实例的includes方法和指数运算符
   - ES6：maps、sets、promises、generators 生成器，模块、类
     1. 箭头操作符 =>
     1. 增强的对象字面量
     1. 字符串模版
     1. 解构
     1. 参数默认值，不定参数，扩展参数
     1. let与const关键字
     1. for of循环
     1. iterator, generator
     1. Promises
     1. 模块
     1. 类的支持，class关键字
     1. Proxies
     1. Symbols
     1. Math，Number，String，Object 的新API
   - ES5：原生json对象、继承的方法、高级属性的定义、引入严格模式
   - 支持情况
     1. 移动端ES5都支持
     1. PC端IE9以上ES5都支持，注意IE9的兼容
1. 其他
   - 代码解释器被称为JavaScript引擎
   - 严格模式：修复部分语言不足，更强错误检查，增强安全性。`use strict`
1. 学习资料
   - 重学前端：https://time.geekbang.org/column/intro/100023201，深层次的讲解了js的底层
   - JavaScript 核心原理解析：https://time.geekbang.org/column/intro/100039701，重点讲了语法
   - JavaScript 进阶实战课：https://time.geekbang.org/column/intro/100122101，是挺进阶的，讲的语法、设计的高度比较高

   - 图解 Google V8：https://time.geekbang.org/column/intro/100048001，重点讲了V8
   - 浏览器工作原理与实践：https://time.geekbang.org/column/intro/100033601，感觉不咋地
   
   - WebAssembly 入门课：https://time.geekbang.org/column/intro/100059901