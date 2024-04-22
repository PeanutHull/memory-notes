### Javascript
1. 认识
   - 特点：脚本语言、基于原型、动态/弱类型，
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
1. 运算符
   - !=/!==
   - 位：|
   - 字符串连接符：+
1. 数组
   - 认识：[]
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
        ```
1. 对象
   - 认识：{}，键值对的、属性无序的，可分为function、array、date等对象
   - 操作
    ```js
    // 声明
    var obj = {x:1}
    new
    // 赋值
    obj.x、obj.['x']？？？
    obj["fieldName"] = xx
    // 读取
    obj["fieldName"]
    // 遍历
    for in
    for...in
    for...of
    ```
   - 实例
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
1. 变量、常量
   - 认识
     1. 一条语句定义多个变常量用逗号隔开
   - 变量
     1. var：声明函数作用域或全局作用域的变量
     1. let：声明块作用域的局部变量，es6
   - 常量
     1. const：声明块作用域的常量，常量不会改变，但声明的是一个常量引用，这个引用是对象或数组，其内部属性或元素可改变
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
   - 判断：if () {} else {}
   - 循环：for
     1. for 语句
     1. do...while
     1. while
     1. label
     1. break
     1. contin
   - 异步：callback最早，新加入promise、yield、generator
1. 函数
   - 理解：js可以声明/调用/传参/返回函数，是function类的实例。其他语言函数是二等公民
     1. js块：{}声明，没有块级作用域，但有函数作用域
   - 实例
    ```js
    // 声明
    function myfunc() {}
    // 传值
    function myfunc(callback){callback()}
    // 匿名函数/函数表达式
    var myfunc = function() {}
    ```
1. 异常
   - try/catch
    ```js
    try{

    }catch() {

    }finally {

    }
    ```
1. promise
   - 认识：表示异步操作最终完成/失败及其结果值，为异步操作提供了更加灵活和强大的方式，避免了回调地狱(回调函数中嵌套多个回调函数)，通过链式调用`.then()`和`.catch()`方法可更清晰的方式来组织异步逻辑
     1. 之前依赖回调函数callback的方式来处理
   - 组成
     1. 状态
        - Pending 等待中：异步操作尚未完成，Promise对象的初始状态。
        - Fulfilled 已实现：异步操作已经完成，并且成功返回了结果值
        - Rejected 已拒绝：异步操作失败，返回了一个错误
     1. 方法：处理异步操作的结果
        - then(onFulfilled, onRejected)`：添加处理异步操作成功(fulfilled)和失败(rejected)的回调函数
        - catch(onRejected)：添加处理异步操作失败（rejected）的回调函数，是`then(null, onRejected)`的语法糖
        - finally(onFinally)：添加一个回调函数，无论异步操作成功还是失败都会执行
     1. 静态方法：处理多个promise
        - `promise.all(iterable)`：等待所有的Promise成功解决或任何一个被拒绝
        - `promise.race(iterable)`：等待最先一个Promise解决或被拒绝
        - `promise.allsettled(iterable)`：等待所有的Promise被解决或被拒绝，不关心结果是成功还是失败
        - `promise.any(iterable)`：等待任何一个Promise成功解决，如果所有的Promise都失败了，则返回一个聚合错误
### wiki
1. 最佳实践
   - 当存在一个可以快速来回切换的页面在请求接口时，应该加一个全部flag变量，来防止叠加请求接口
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
     1. json
        ```js
        JSON.parse(jsonstr);          json字符串转json对象
        JSON.stringify(jsonobj);      json对象转换成json对符串
        ```
     1. Object
        ```js
        Object.create
        Object.defineProperties
        Object.keys
        ```
     1. Array
        ```js
        Array.indexOf
        Array.every              回调函数遍历
        Array.some               回调函数指定元素遍历
        Array.forEach
        Array.map
        Array.filter
        Array.reduce
        Array.isArray            相比typeof返回的object，instanceof返回的ie错误
        ```
     1. Function
        ```js
        Function.bind
        Function.call
        Function.apply
        ```
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