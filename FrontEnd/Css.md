1. css
   - 理解：层叠样式表，由电子出版/印刷行业而来
   - 属性
     1. 伪类：向某些选择器添加特殊的效果，是一个类，作用于标签本身
        ```
        :active       将样式添加到激活的元素
        :focus        将样式添加到选中的元素
        :hover        鼠标经过添加样式
        :link         将样式添加到未访问的链接
        :visited      将样式添加到已访问的链接
        :first-child  将样式添加到元素的第一个子元素
        :lang         定义指定元素使用的语言
        ```
     1. 伪元素：将特殊的效果添加到某些选择器，其效果通过一个元素来表现，作用于内容
        ```
        ::before         在某元素之前插入某些内容和样式
        ::after          在某元素之后插入某些内容和样式
        ::first-letter   将样式添加到文本首字母
        ::first-line     将样式添加到文本的首行
        ```
   - 选择器
     1. 基本选择器
        ```
        E{}                 元素选择
        #ID{}               id选择
        .className {}       class选择
        E1，E2，E3 {}        群组选择
        E F {}              后代选择
        E>F {}              子类选择
        *{}                 通配选择
        ```
     1. 属性选择器
        ```
        E[attr]                包含这个属性即可选择
        E[attr="value"]        指定属性值
        E[attr~="value"]       属性值是一个词列表
        E[attr^="value"]       以value开头
        E[attr$="value"]       以value结束
        E[attr*="value"]       有属性值，而且包含value
        E[attr|="value"]       是value或者以“value-”开头的值
        ```
     1. 伪类选择器
        - 动态伪类
            ```
            a:link                 链接没被访问时
            a:visited              链接被访问后
            a:active               鼠标点中激活链接那一下
            a:focus                用于元素成为焦点，经常用在表单元素
            :not(selector)
            ```
        - 状态伪类：通常用在form中，IE6-8不支持":checked",":enabled",":disabled"三种选择器
            ```
            :checked
            :enabled
            :disabled
            ```
     1. css3的nth选择器
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
1. css hack：尽量避免使用
   - 条件注释法
    ```
    1.<!--[if IE]> 所有的IE可识别 <![endif]-->
    1.<!--[if IE 9]> 仅IE9可识别 <![endif]-->
    1.<!--[if gte IE 9]> IE9以及IE9以上版本可识别 <![endif]-->
    ```
   - 属性前缀法
    ```
    "\9" IE6/IE7/IE8/IE9/IE10都生效
    "\0" IE8/IE9/IE10都生效，是IE8/9/10的hack
    "\9\0" 只对IE9/IE10生效，是IE9/10的hack
    ```
   - 内核前缀法
    ```
    -ms-
    -webkit-
    -moz-
    -o-
    ```
