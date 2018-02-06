####模块规范
1. 分类：
 - CommonJS
 - AMD
 - CMD
1. Webpack
 - 解释：前端工具、解决模块加载、依赖，预处理、打包、有requirejs、gulp的功能
 - 优点：支持commonJS、AMD模块，支持多模块加载器如less等的打包，支持css、图片打包
 - 命令：
    ```
    webpack         // 最基本的启动webpack的方法
    webpack -w      // 提供watch方法；实时进行打包更新
    webpack -p      // 对打包后的文件进行压缩
    webpack -d      // 提供source map，方便调式代码
    ```
1. RequireJS
 - 解释：代码模块化、加速优化代码、以module ID代替url
 - 使用：
    1. 以相对于baseUrl的地址加载所有代码，默认假定依赖资源都是js文件，无需加.js后缀，RequireJS进行module ID到path时自动补足后缀，可在path config设置脚本
    ```
    // 页面顶层script标签的特殊属性data-main，require用它来启动脚本的加载过程，一般baseUrl和该属性地址相一致
    // baseUrl可通过RequireJS config手动设置，没指定config、data-main，则默认baseUrl为包含requrieJS的目录
    <script data-main="scripts/main.js" src="scripts/require.js"></script>
    ```
    1. 避开baseUrl + paths解析过程，直接加载为相对于当前html文档的脚本，则module ID符合以下规则
    ```
    以 ".js" 结束.
    以 "/" 开始.
    包含 URL 协议, 如 "http:" or "https:".
    ```
###NPM
1. 理解：nodejs的包管理器npm是全球最大的开源库生态系统。就是给js赋予了更多底层的能力
1. package.json
 - 理解：具有的版本管理的nodejs配置文件，运行 npm install 就会自动安装
 - 安装
```
npm init
```
1. npm
 - 查看当前插件
```
npm list
```
 - 安装插件
```
npm install <name> [-g] [--save-dev]
-g 全局安装：将安装在C:\Users\Administrator\AppData\Roaming\npm，并写入环境变量。本地安装的话在定位目录的node_modules文件夹下，通过require()调用
--save 保存配置信息至nodejs的配置文件package.json中
--dev 保存至package.json的devDependencies节点，不指定-dev将保存至dependencies节点
```
 - 卸载
```
// 不能直接删除
npm uninstall <name> [-g] [--save-dev]
```
 - 更新
```
npm update <name> [-g] [--save-dev]
```
 - 选装cnpm
```
执行：   npm install cnpm -g --registry=https://registry.npm.taobao.org
安装完成查看版本： cnpm -v
使用和npm一致，npm更换为cnpm
```
###Gulp
####Gulp
1. 理解：基于流的自动化构建工具
1. 功能：
 - 测试
 - 语法检查
 - 文件合并、压缩
 - 格式化
 - 浏览器自动刷新
 - 部署文件生成
 - 监听文件变化并重复以上步骤
1. 特点：
 - 基于nodeJS
 - 速度、效率、简化
 - 插件丰富，几乎不用自己用js写构建过程
 - 代码优于配置：构建脚本是代码，不是配置
1. 使用步骤：安装nodejs -> 全局安装gulp -> 项目安装gulp以及gulp插件 -> 配置gulpfile.js -> 运行任务
 1. 查看gulp
```
gulp -v
```
 1. 全局安装gulp
```
npm install gulp -g
```
 1. 本地初始化nodejs环境，新建package.json文件
 1. 作为项目的开发依赖安装
```
install gulp --save-dev
```
 1. 本地安装gulp插件
```
// 初始化本地环境
npm install --save-dev
// 安装插件
npm install gulp-less --save-dev
```
 1. 创建gulp配置文件gulpfile.js

    - 
```javascript
// 初始内容
var gulp = require('gulp');
gulp.task('default', function () {
});
.
// 五个基础API
gulp.task(name[, deps], fn) 定义任务  name：任务名称 deps：依赖任务名称 fn：回调函数
gulp.src(globs[, options]) 执行任务处理的文件  globs：处理的文件路径(字符串或者字符串数组)
gulp.dest(path[, options]) 处理完后文件生成路径
gulp.watch(glob[, options], tasks)／gulp.watch(glob[, options, cb])
gulp.run
```
    - 示例less编译
```javascript
//导入工具包 require('node_modules里对应模块')
var gulp = require('gulp'), //本地安装gulp所用到的地方
            less = require('gulp-less');
.
//定义一个testLess任务（自定义任务名称）
gulp.task('testLess', function () {
          gulp.src('src/less/index.less') //该任务针对的文件
              .pipe(less()) //该任务调用的模块
              .pipe(gulp.dest('src/css')); //将会在src/css下生成index.css
});
.
gulp.task('default',['testLess', 'elseTask']); //定义默认任务
```
    - 示例语法检查和合并文件
```
var gulp = require('gulp');
var jshint = require('gulp-jshint');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
.
// 语法检查
gulp.task('jshint', function () {
            return gulp.src('src/*.js')
                .pipe(jshint())
                .pipe(jshint.reporter('default'));
});
.
// 合并文件之后压缩代码
gulp.task('minify', function (){
            return gulp.src('src/*.js')
                .pipe(concat('all.js'))
                .pipe(gulp.dest('dist'))
                .pipe(uglify())
                .pipe(rename('all.min.js'))
                .pipe(gulp.dest('dist'));
});
.
// 监视文件的变化
gulp.task('watch', function () {
            gulp.watch('src/*.js', ['jshint', 'minify']);
});
.
// 注册缺省任务
gulp.task('default', ['jshint', 'minify', 'watch']);
```
 1. 运行gulp
```
// 执行特定任务
gulp 任务名称；
// 如编译less
gulp testLess；
```
1. 总结
```
// 将获取的文件的处理结果再传给下面，直到全部完成
// pipe是stream 模块里负责传递流数据的方法，将stream对象返回出去，以便任务之间依次传递执行
gulp.task('任务名称', function () {
        return gulp.src('文件')
            .pipe(...)
            .pipe(...)
            // 直到任务的最后一步
            .pipe(...);
});
```
1. 更多插件
 - 语法检查（gulp-jshint）
 - 合并文件（gulp-concat）
 - 压缩代码（gulp-uglify）
 - 文件改名（gulp-rename）
 - 。。。。。。。。。。。。
1. 建议
 - 花点时间浏览一下 gulp.js 插件库，大致了解下利用已有的插件你都可以做哪些事情
 - 对于常用的插件，仔细阅读它们自己的文档，以便发挥出它们最大的功效
 - 抽时间学习 gulp.js API，特别是 gulp.task() 里关于任务体的详细描述，学会如何执行回调函数（callback），如何返回 promise 等等
 - 尝试编写适合自己工作流程和习惯的任务，如果它工作良好，把它做成插件发布给大家吧！
1. RequireJS
 1. 特点：防止js加载阻塞页面渲染。以module ID替代URL地址。
 1. 功能
   - 防止命名冲突
   - 解决js之间的依赖
   - 模块化代码
 1. API：
```
define           定义一个模块
require          加载依赖模块，并执行加载完后的回调函数，会按照先后顺序加载js的
requirejs        requirejs === require
```
 1. 使用步骤
   1. 引入requirejs、配置好主js文件app.js
   1. define模块，require加载
 1. 举例
```
定义模块、声明依赖、使用依赖的js文件
// 例1
// mod1.js
=================
define(function() {
        return {a:3};
})
// mod2.js
=================
define(['mod1'],function(m1) {
        var a,b=2;
        a = b*m1.a;
        return {
            a:a
            b:b
        }
})
// 例2
// animate.js
=================
define(function() {
        function Animate() {};
        return {Animate:Animate};
});
// tabview.js
=================
define(['animate'], function(a) {
        function TabView() {
            this.animate = new a.Animate();
        };
        return {TabView:TabView};
})
// main.js
=====================
require(['tabview'], function(tab) {
        var tabview = new tab.TabView;
})
```
 1. 常识
   - data-main：所指js将在加载完reuqire.js后处理，并且将此作为默认为根路径baseUrl，可省去.js后缀
