###ECMAScript
1. Javascript
   - 特点：脚本语言、基于原型、动态/弱类型，它的解释器被称为JavaScript引擎
   - 组成
     1. ECMAScript，基础语法
     1. DOM：文档对象模型，网页内容的方法和接口
     1. BOM：浏览器对象模型，与浏览器交互的方法和接口
1. 数据类型
   - number、string、boolean、null、undefined
   - object：function、array、date
   - 包装对象：访问基本类型数据会自动转为对应的包装类型对象，临时对象用完即销毁
1. 运算符
   - !=/!==
   - 位：|
   - 字符串连接符：+
1. 变量：一条语句定义多个变量用逗号隔开
1. 流程控制
   - callback最早，新加入promise、yield、generator
1. 函数
   - 理解：其他语言函数是二等公民，js不一样，可以声明/调用/传参/返回，是function类的实例，非常重要。js块：用{}声明，没有块级作用域，但有函数作用域
   - 实例
    ```
    function myfunc() {}                        声明
    function myfunc(callback){callback()}       传值
    var myfunc = function() {}                  匿名函数/函数表达式    
    ```
1. 对象
   - 理解：属性无序，都是键值对，可分为function、array、date等对象
   - 声明：var obj = {x:1}、new
   - 属性读取：obj.x、obj.['x']、for in
1. 异常
   - try/catch
    ```
    try{
    }catch() {
    }finally {}
    ```
###DOM
1. dom：一组用来描述脚本怎样与结构性文档进行交互和访问的Web标准。DOM定义了一系列的对象、方法和属性，用于访问、操作和创建文档中的内容、结构、样式以及行为。
###BOM
1. 调用父级方法：`parent.method()`，parent为window.parent的简写
1. 打开新窗口：`window.open`
###wiki
1. 严格模式：修复部分语言不足，更强错误检查，增强安全性。`use strict`
1. 历史版本：ECMAScript是JavaScript的标准规范，二者相同。ES6含义是5.1以后的JavaScript的下一代标准，包含ES2015、ES2016、ES2017等
   - ECMAScript 1.0： 96年，Netscape提交到ECMA(标准化组织)成为国际标准，即ECMA-262
   - ECMAScript 5.1： 11年
   - ECMAScript 6.0： 15年，简称ES2015
   - ECMAScript 6.1： 16年，新增了数组实例的includes方法和指数运算符
1. 版本更新情况
   - ES5 新功能：原生JSON对象、继承的方法、高级属性的定义、引入严格模式
     1. json
    ```
    JSON.parse(jsonstr);          json字符串转json对象
    JSON.stringify(jsonobj);      json对象转换成json对符串
    ```
     1. Object
    ```
    Object.create
    Object.defineProperties
    Object.keys
    ```
     1. Array
    ```
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
    ```
    Function.bind
    Function.call
    Function.apply
    ```
   - ES6 新功能：模块、类及特性，Maps、Sets、Promises、Generators(生成器)
     1. 箭头操作符 =>
     1. 类的支持，class关键字
     1. 增强的对象字面量
     1. 字符串模版
     1. 解构
     1. 参数默认值，不定参数，扩展参数
     1. let与const关键字
     1. for of循环
     1. iterator, generator
     1. 模块
     1. Proxies
     1. Symbols
     1. Math，Number，String，Object 的新API
     1. Promises
   - 支持情况
     1. 移动端ES5都支持
     1. PC端IE9以上ES5都支持，注意IE9的兼容