1. css
   - 理解：cascading style sheet，层叠样式表，控制网页样式并允许将样式信息和网页内容分离的标记性语言，div，division区块。div+css取代table布局，由电子出版/印刷行业而来
   - 控制页面的方式
     1. 行内样式：标签内书写，`<h1 style="">`
     1. 嵌入样式：通常在head标签中，`<style type="text/css"></style>`
     1. 引入样式：引入单独css文件，`<link rel="stylesheet" type="text/css" href="index.css"/>`
   - 特性
     1. 继承性：后代元素会继承文字相关的样式
     1. 叠加性：样式可叠加，同一优先级后写的有效，选择器优先级越精确越高，为：行内样式>后代>id>类>标签>通用>浏览器预定义>继承样式
   - 语法：选择器和属性，`selector {property: value}`
1. 选择器：可以被多次使用的css定义
   - 基本选择器
        ```
        E{}                 元素选择
        #ID{}               id选择
        .className {}       类选择
        E + F {}            紧邻选择
        E F {}              后代选择，E>F {}，子类选择
        E1，E2，E3 {}        群组选择
        *{}                 通配选择
        ```
   - 属性选择器
        ```
        [attr]                 拥有这个属性即可选择 
        E[attr]                包含这个属性
        E[attr="value"]        指定属性值
        E[attr~="value"]       属性值是一个词列表
        E[attr^="value"]       以value开头
        E[attr$="value"]       以value结束
        E[attr*="value"]       有属性值，而且包含value
        E[attr|="value"]       是value或者以“value-”开头的值
        ```
   - 伪类选择器：向选择器添加特殊状态下的效果
        - 动态伪类
        ```
        :hover                鼠标经过添加样式
        :link                 未访问
        :active               鼠标点中激活那一下
        :visited              访问后
        :focus                元素成为焦点，如表单元素
        :lang                 指定使用的语言        
        :not(selector)
        ```
        - 状态伪类：通常用在form中，IE6-8不支持":checked",":enabled",":disabled"三种选择器
        ```
        :checked
        :enabled
        :disabled
        ```
        - css3的nth选择器
        ```
        :nth-of-type()       选择指定的元素
        :nth-last-of-type()  选择指定的元素，从元素的最后一个开始计算
        :first-of-type       选择一个上级元素下的第一个同类子元素
        :last-of-type        选择一个上级元素的最后一个同类子元素
        :only-of-type        选择一个元素是它的上级元素的唯一一个相同类型的子元素        

        :first-child
        :last-child
        :nth-child()         选择某个元素的一个或多个特定的子元素，参数有num、n、2n+1等
        :nth-last-child()    选择某个元素的一个或多个特定的子元素，从这个元素的最后一个子元素开始算
        :only-child          选择的元素是它的父元素的唯一一个了元素

        :empty               选择的元素里面没有任何内容
        ```
   - 伪元素：将特殊的效果添加到选择器，通过元素来表现
    ```
    ::before         在某元素之前插入某些内容和样式
    ::after          在某元素之后插入某些内容和样式
    ::first-letter   将样式添加到文本首字母
    ::first-line     将样式添加到文本的首行
    ```
1. 样式
   - 基本
    ```
    width/height         max|min-width|height
    color
    background           background-color/image/position/repeat/attachment
                            position：top|center|bottom
                            repeat：repeat-x|y|n
                            attachment：fixed|scroll，背景图滚动方式
    overflow             滚动条，hidden 超出内容隐藏，auto，scroll 始终出现
    opacity              透明度，0-1
    visibility           可见性，visible，hidden
    cursor               鼠标样式，hand/pointer手型，crosshair十字形，text挪到文本的效果，wait等待效果，default默认，help问号
    clear                元素侧面是否允许其他浮动元素，both/left/right
    ```
   - 文字
    ```
    font-family
    font-size            文字大小，px像素，em倍数，可用数字。默认16px
    font-weight          文字粗细，normal标准，bold加粗
    font-style           文字倾斜，normal标准，italic倾斜
    text-decoration      下划线，none无，underline下划线，overline上划线，line-through删除线
    font                 700 14px/40px Microsoft Yahei;
    ```
   - 文字段落
    ```
    text-align           水平对齐，top，bottom，middle
    line-height          行高，px/em，行高设置为元素的高就可实现垂直居中
    text-indent          首行缩进，px/em，2em为两个字
    letter-spacing       字符间距，px/em
    ```
   - 表格：`align/valign：top，bottom，middle`
1. 待定
   - 元素类型：display，inline/block/inline-block/none
     1. 块级元素：有宽高属性，独占一行，默认宽度100%，如p、div、h1~h6、ul、li
     1. 行级元素：无宽高属性，宽高根据内容，margin只有左右没有上下，如a、span
     1. 行内块级元素：有宽高属性，不占一行，如img、from、input、textarea、select
   - 盒子模型：是css的基石，所有元素被看成矩形的盒子，由内容/填充(内边距)/边框/边界(外边距)组成，页面由很多通过纵向/横向/嵌套等方式堆积
     1. padding：内边距，padding-top/right/bottom/left，参数为上下左右/上下和左右/上和左右和下/上右下左顺时针
     1. margin：外边距，和padding相同
     1. border：边框，border-left/width/color/style，`1px solid red`，`border-top-style：solid|dashed 虚线|dotted 点状`
1. 定位机制
   - 标准文档流
   - float：浮动，left/right
     1. 是半脱离文档流的左右浮动，所有元素都能浮动，会和正常元素重叠，但是正常元素的子元素会绕开
     1. 浮动元素是一直运动着的，浮动元素遇到浮动元素和父级元素会停止，宽度不够会向下挤
     1. 浮动元素不能撑开父级，加上`overflow：hidden`就可以了
     1. 行级元素浮动会变块级
   - position：定位，left/top，只有定位元素有`z-index`属性
     1. 相对定位：relative，右下为正方向，即相对于左上，原有位置还会占用
     1. 绝对定位：absolute，相对于最近的有定位属性的父级元素定位，一级级往上找，完全脱离文档流，原有位置不占用
   - fixed：固定定位
###wiki
1. 技巧
   - css导入其他css文件：`@import url(hd.css)`
   - 块级元素水平居中：margin：0px auto;
   - padding不可能为负，margin可为负
   - 两个相邻的margin值会合并
   - div背景设置黑色，图片透明度0.6，再加hover透明度1,可以实现鼠标滑过图片亮一下效果
   - html元素属性和css样式的区别：属性`<a width="64"></a>`不用加封号和px，css用width:64px;
   - 参数里只有0可以不加单位
   - 写页面三大步骤
     1. 根据内容选标签
     1. 定位置
     1. 改样式
   - 全局reset
    ```
    *{
        padding：0px；
        margin：0px；
    }
    ```
1. @media-query
1. @font-face
   - 介绍：css2的语法，允许网页上显示自定义字体。即使客户端没有安装，网页也可以显示。浏览器支持有ttf/otf、woff、eot、svg，由于浏览器兼容差异，至少需要woff,eot两种格式字体
   - 实例
     1. 定义字体
        ```
        @font-face {                            // 兼容所有浏览器，Bulletproof的@font-face写法
            font-family: 'YourWebFontName';
            src: url('YourWebFontName.eot?') format('eot');/*IE*/
            src: url('YourWebFontName.woff') format('woff'), url('YourWebFontName.ttf') format('truetype');/*non-IE*/
        }
        ```
     1. 使用字体：`font-family: "YourWebFontName";`
   - 资源
     1. 字体转码网站：https://www.fontsquirrel.com/tools/webfont-generator
     1. 字体网站： https://fonts.google.com/、http://www.zitikoudai.com/
   - 中文字体：由于中文文件太大，使用fontCreator制作需要的字体文件即可
     1. 拿到中文字体文件，使用fontCreator打开
     1. 搜索需要的文字，复制文字、unicode码、右键Glyph Properties中的LSB、RSB
     1. 新建项目，添加粘贴文字和属性即可。不能删除原有的内容。最后导出其他格式
   - 字体格式介绍
     1. ttf：TrueType，windows和mac最常用，最大特点是基于一种数学模式的轮廓技术来定义，这使比基于矢量的字体更容易处理，保证了屏幕与打印输出的一致性
     1. otf：OpenType
     1. woff：Web开发字体格式，专门为web设计的字体格式标准，是对于ttf/otf等的封装，每个字体文件中含有字体/针对字体的元数据，字体文件被压缩以便网络传输
     1. eot：Embedded Open Type，是微软和adobe共同开发的字体，是嵌入式字体，ie浏览器全部采用这种字体，致力于替代ttf
     1. svg：用svg来呈现字体
1. css hack：为了兼容性而生，效果不好单独给浏览器下指令，尽量避免使用
   - 条件注释法
     1. `<!--[if IE]> 所有的IE可识别 <![endif]-->`
     1. `<!--[if IE 9]> 仅IE9可识别 <![endif]-->`
     1. `<!--[if gte IE 9]> IE9以及IE9以上版本可识别 <![endif]-->`
   - 属性前缀法
     1. "\9"：IE6/IE7/IE8/IE9/IE10都生效
     1. "\0"：IE8/IE9/IE10都生效，是IE8/9/10的hack
     1. "\9\0"：只对IE9/IE10生效，是IE9/10的hack
   - 内核前缀法
     1. -ms-
     1. -webkit-
     1. -moz-
     1. -o-
1. Sprite：雪碧图，背景精灵技术，节省服务器请求