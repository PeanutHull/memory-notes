### android
#### 认识
1. 组件
   - retrofit：网络框架，对okhttp的封装，用来发api
   - butterknife：view注入和绑定框架
   - glide：图片加载框架，网络/本地
   - dbflow：数据库框架，编译时注解，性能及其接近原生
1. im：即时通信，四大协议
   - IMPP：即时信息和空间协议
   - XMPP：可扩展通信和表示协议，基于xml
   - SIMPLE：SIP，对impp的扩充协议
   - PRIM：不用了
1. 文件
   - apk
   - jar：Java Archive，Java归档文件，平台无关的允许将多文件组合成一个压缩文件的文件格式，只包含源码，不包含资源文件
   - arr：Android Archive Android归档文件，包含源码和资源文件
   - dex
     1. 认识：能够被DVM识别、加载并执行的文件格式，每个apk安装包里都有。包含应用程序的全部操作指令以及运行时数据
        - 相对于PC上的java虚拟机能运行.class；android上的Davlik虚拟机能运行.dex
        - 当java程序编译成class后，还需要使用dx工具将所有的class文件整合到一个dex文件，目的是其中各个类能够共享数据，在一定程度上降低了冗余，同时也是文件结构更加经凑，实验表明，dex文件是传统jar文件大小的50%左右
     1， 作用
        - dex里面包含了所有app代码，利用反编译工具可以获取java源码。理解并修改dex文件，就能更好的apk破解和防破解
1. am
   - 认识：activity manager，Android下的实用命令，代码在frameworks\base\cmds\am\src\com\android\commands\am
   - 使用
     1. 获取package和launch_activity：`adb shell dumpsys window windows | findstr "Current"`
     1. 启动：`am start`
#### wiki
1. root方式
   - 以前版本中最流行的 root 方法 —— 即，将 su守护程序 放置到 /system 分区，并在启动时取得所需的权限
   - systemless方式：不修改/system分区
1. Bootloader
   - 认识
     1. 操作系统内核运行之前运行，是加电后执行的第一段代码
        - 嵌入式系统通常没有像BIOS那样的固件程序，有的cpu有短小的启动程序
     1. 初始化硬件设备、建立内存空间映射图
   - 操作模式
     1. 启动加载模式：正常工作模式
     1. 下载模式：将通过串口或网络等通信手段从开发主机
1. Recovery
   - TWRP：Team Win Recovery Project,是一款易于使用和可以自定义的Recovery
#### tool
1. Android Studio
1. Android SDK
   - adb：Android Debug Bridge，操作管理模拟器或设备
     1. adb shell env   # 查看Android的环境变量
1. Magisk
   - 认识：独特的挂载机制，systemless特质
   - 理解：通过挂载一个与系统文件相隔离的文件系统来加载自定义内容，为系统分区打开了一个通往平行世界的入口，所有改动在那个世界（Magisk 分区）里发生，在必要的时候却又可以被认为是（从系统分区的角度而言）没有发生过
     1. 原系统完整性未损，需要root验证、需要验证系统完整性的OTA更新没有任何问题
     1. 严格来说 Magisk 可以被看作是一种文件系统
   - 作用
     1. 可以有针对性地隐藏 root，甚至暂时隐藏 Magisk 本身（随机包名进行重新安装）
     1. 加载各种第三方模块
        - 开机自启crond等
   - wiki
     1. Xposed：通过劫持Android系统的zygote进程来加载自定义功能，像半路截杀，在应用运行之前就已经将我们需要的自定义内容强加在了系统进程当中
     1. TaiChi：是一个使用Xposed模块的框架，带或不带Root/Unlock bootloader
     1. 安装：需要解锁 Bootloader 并刷入第三方 Recovery
1. busybox
   - 集成了相当完整的linux命令环境和工具的软件，即工具箱，如http服务器、telnet服务器
1. Termux
   - 认识：终端模拟器，甚至可被认为是Linux发行版，仅仅是模拟器有点小器了
     1. 自带包管理器apt
     1. 工具包：Clang，FFMPEG，OpenSSH，Python，Vim
     1. 不遵循文件系统层次结构标准，在Termux下无法找到 /bin、/etc、/usr、/tmp 等Linux基础目录。因此，所有程序都应打补丁并重新编译才能在 Termux 环境上运行，否则它们将无法找到其配置文件或其他数据
     1. 执行具标准she-bang的（e.g. #!/bin/sh）的脚本时可能也会遇到问题。在执行之前需要使用 termux-fix-shebang 脚本修改要运行的脚本。好在最新版本的 Termux 提供了标准she-bangs的支持。
     1. Termux 导出特殊变量 $LD_LIBRARY_PATH，它告诉链接器在哪里可以找到共享库文件
   - 作用
     1. 安装python实现python编程，可以用手机架设 Server，同样可以用于渗透测试等
   - wiki
     1. aid Learning：类似termux，适用于新手机
1. mt管理器：集成多个工具的文件管理器，如dex编辑器
### objective-c
#### 认识
1. 理解：通用的、面向对象的语言，用于开发iOS和Mac OS X操作系统和其应用，支持c和c++语言语法，是对c语言面向对象的扩展。最初由NeXT为NeXTSTEP操作系统开发，.h是头文件，.m是实现文件
1. 组成：预处理命令，变量，方法，语句和表达式，接口，实现，注释
1. 实例
    ```c
    #import <Foundation/Foundation.h>

    int main()
    {
        NSLog(@"Hello, World!");
        return 0;
    }
    ```
#### 语法
1. 基础
   - 令牌：包括关键字、标识符、常量、字符串
   - 分号：每个单独语句必须以分号结束
   - 标识符：字母或者下划线开头，后边可以跟数字
   - 空白：编译器忽略空白
   - 区分大小写
   - 注释：单行//，多行/**/
1. 数据类型
   - 基本
     1. 基本类型
        - int：2/4bytes，-32768~32767/20多亿
        - float：4bytes，1.2E-38 to 3.4E+38，精确到6个小数点
        - double：8bytes，2.3E-308 to 1.7E+308，15个小数点
        - char：1bytes，-128~127/0~255
        - NSString :@"hello world"
        - "hello world"
     1. 限定词
        - short：2bytes，-32768~32767；unsigned short：翻倍        
        - long：4bytes，20多亿；unsigned long：翻倍；long double：10byte，3.4E-4932 to 1.1E+4932，19个小数点
        - long long
        - unsigned：unsigned int；unsigned char
        - signed：signed char
   - void：函数无返回值，没有参数的函数可以接受一个void参数
   - 枚举
   - 派生
     1. 指针
     1. 数组
     1. 结构
     1. 联合
     1. 函数
1. 运算符
   - 算术运算符：+ - * / % ++ --
   - 关系运算符：== != > < >= <=
   - 逻辑运算符：&& || !
   - 赋值运算符：= +-*/%<<>>&|^= sizeof & * ?:
   - 位运算符：& | ^ ~ << >>
   - 其他运算符：
1. 变量
   - 理解：一个指向存储区域的名称，让程序可以操控。变量为坐值表达式，
   - 定义：type variable_list
        ```c
        int/float/double/char    i, j, k=5;         # 变量初始化
        extern int i;                               # TODO ？？？
        NSString *lhString;                         # 指针变量
        int func();                                 # 得到函数返回值
        int func()
        {
            return 0;
        }
        int i = func();
        ```
   - 编译、链接、宏
     1. extern
     1. const
     1. static
1. 常量
   - 理解：不能被改变，可以为任意基本数据类型，北鼻称为literals
   - 实例
        ```c
        #define LENGTH 10               # 习惯大写
        const char NEWLINE = '';
        ```
1. 流程控制
   - 循环
     1. for：`int a; for(a=10; a<20; a=a+1){}`
     1. while：`while(condition) {}`
     1. do while：保证能循环一次，`do{}while(condition);`
     1. break;continue;
   - 判断
     1. if：`if() {} else {}`
     1. switch：没有break就继续往下一个case执行，`switch() { case : case : default :}`
1. 表达式
   - 分类
     1. 左值：可能在左边或右边被赋值
     1. 右值：只能出现在右边
1. 函数
   - 定义：指定返回值类型
    ```c
    # C语言形式的函数
    int countNum(int a, int b) {
      int s = a + b;
      return s;
    }
    void show() {
      NSLog(@"hello");
    }
    ```
   - sizeof：返回对象/类型的字节为单位的存储大小，`sizeof(int)`
1. 打印：`NSLog(@"Storage size for int : %d", sizeof(int));`
1. XCFramework
   - 认识：更方便的分发二进制包格式，其中包含一个框架或库的变体使得可在多个平台上使用(MacOS/tvOS)
     1. 可以是静态或动态的，并且可以包含标头
#### 面向对象
1. 类
   - 定义和实现
        ```c
        @interface SampleClass:NSObject                             # 继承 NSObject
        @property NSString *name                                    # 类的属性声明
        @property int num                                           # 类的属性声明
        - (void)sampleMethod;
        - (void)sampleMethodWithValue:(SomeType)value;
        + (id)stringWithString:(NSString *)aString;
        @end

        @implementation SampleClass                                 # 实现
        - (void)sampleMethod {
            NSLog(@"Hello, World!");
        }
        @end

        SampleClass *sampleClass = [[SampleClass alloc]init];       # 调用
        [sampleClass sampleMethod];
        ```
1. 方法
   - 分类
     1. 减号方法：即普通方法/对象方法
     1. 加号方法：即类方法/静态方法
1. Foundation框架
   - 特点
     1. 包括NSArray，NSDictionary中的NSSet等扩展数据类型
     1. 包含丰富的函数、字符串处理、url、日期时间、错误处理
#### WIKI
1. 关键字
   - auto，else，long，switch
   - break，enum，register，typedef
   - case，extern，return，union
   - char，float，short，unsigned
   - const，for，signed，void
   - continue，goto，sizeof，volatile
   - default，if，static，while
   - do，int，struct，_Packed
   - double，protocol，interface，implementation
   - NSObject，NSInteger，NSNumber，CGFloat
   - property，nonatomic;，retain，strong
   - weak，unsafe_unretained;，readwrite，readonly
1. CocoaPods
   - 认识：是Swift和Objective-C Cocoa项目的依赖管理器
   - 使用
     1. pod install
     1. pod update
#### swift
1. 变量 var，常量 let
### QT
1. delphi：可开发直接运行的桌面系统的工具
1. 认识：用于开发图形界面程序，是 GUI framework，xml语法的.ui定义界面，还有pyqt
   - 简单易学，封装的很好，不需要了解window api。资料丰富
   - 界面优秀，功能丰富。网络通信、数据库、图库处理、音视频处理、文件操作、xml、多线程等，用于桌面级和嵌入式的开发
   - 跨平台支持很好，成本很低
1. 工具
   - qmake：构建工具，生成跨平台的.pro项目文件，生成不同系统的makefile
   - uic：user interface compiler，用户界面编辑器，uic根据.ui生成c++代码头文件
   - moc：meta-object compiler，元对象编辑器，处理Q_OBJECT宏，生成源对象代码文件，如moc_*.cpp，用于实现qt信号槽机制、运行时类型定义、动态属性系统
   - rcc：resource compiler，资源文件编辑器，编译构建过程中.qrc资源文件，将资源嵌入qt程序里
   - designer：qt设计师，可视化界面编辑工具，用于设计qml界面
   - linguist：qt语言家，多语种翻译
   - qmlscene：代替qmlviewer，进行原型设计和测试
   - assistant：qt助手，文档查询工具
   - qtcreator：IDE，项目生成管理、代码编辑、编译生成、调试、上下文帮助、版本控制、手机/嵌入式程序生成
1. 组成
   - 模块
   - 定时器
   - QString
   - QObject
   - QThread
   - QDir/QFileInfo
   - QFont
   - QIcon
   - QDebug
   - QSetting
   - QApplication
   - QUrl
   - Qwebengineview
1. 模块
   - Qt Core：核心非图形类
   - Qt GUI：图形界面基础类，包括openGL
   - Qt Multimedia：音视频类
   - Qt Multimedia Widgets：音视频组件类
   - Qt Network
   - Qt QML：qml和js的类
   - Qt Quick Controls/Dialogs/Layouts：定制界面的声明框架
   - Qt SQL
   - Qt Test
   - Qt Widgets
1. QML
   - 组成
     1. import：指定引入的模块
     1. qml元素：类似xml，子元素的xy坐标只相对于父元素
1. QtQuick：使用xml作为界面描述，使用JavaScript来驱动，能用类似css的技术效果比较好。如果有特殊的开发需求，可以用C++和原来的QT库连接。直接对手是Electron
1. 应用
   - Qt支持PDF模块：一种嵌入v8引擎，一种是直接使用最底层的PDFium
### GTK
#### 认识
1. 认识：开源的也是c编写，同时也移植到了macOS和windows上，现在都是GTK+，目前有v3和v4版本，支持c、js、python、go，python资料最多
   - 布局：xml方式，使用GtkBuilder，结构：interface-object...
   - 样式：css
   - glade：RAD（rapid application develop，快速应用开发）工具，能够为gtk+和gnome桌面环境开发界面，就是所见即所得
   - 配置方式
     1. 环境变量
     1. 配置文件：settings.ini
     1. 代码修改
   - 内存管理
     1. ref引用计数
     1. 浮动引用：防止造成内存泄露，就是弄个标记原来的加1，给减1了，为0正好不用管了
   - 到时候写的时候找东西抄，就像抄主题一样
1. 组成
   - GtkWindow
   - GtkGrid
   - GtkTreeView：可以展示列表和层级
   - GtkListStore
1. 原始操作
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>

    static void print_hello(GtkWidget *widget, gpointer data) {
        g_print("Hello World\n");
    }

    static void activate(GtkApplication *app, gpointer user_data) {
        // 创建窗体
        GtkWidget *window = gtk_application_window_new(app);
        gtk_window_set_title(GTK_WINDOW(window), "HelloWorld");
        gtk_window_set_default_size(GTK_WINDOW(window), 200, 200);

        // 创建按钮
        GtkButtonBox *button_box = gtk_button_box_new(GTK_ORIENTATION_HORIZONTAL);
        gtk_container_add(GTK_CONTAINER(window), button_box);
        GtkButton *button = gtk_button_new_with_label("Hello World");
        gtk_container_add(GTK_CONTAINER(button_box), button);

        // 绑定事件
        g_signal_connect(button, "clicked", G_CALLBACK(print_hello), NULL);
        g_signal_connect_swapped(button, "clicked", G_CALLBACK(gtk_window_close), window);

        gtk_widget_show_all(window);
    }

    int main(int argc, char **argv) {
        // 创建应用
        GtkApplication *app = gtk_application_new("com.bennyhuo.clang", G_APPLICATION_FLAGS_NONE);
        // 添加事件
        g_signal_connect(app, "activate", G_CALLBACK(activate), NULL);
        // 运行
        int status = g_application_run(app, argc, argv);
        // 解引用
        g_object_unref(app);

        return status;
    }
    ```
1. 使用xml
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    int main(int argc, char **argv) {
        GError *error = NULL;

        // 初始化gtk
        gtk_init(&argc, &argv);

        GtkBuilder *builder = gtk_builder_new();
        // 通过xml加载布局
        if (gtk_builder_add_from_file(builder, "builder.ui", &error) == 0){
            g_printerr("Error loading file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        g_object_unref(builder);

        gtk_main();

        return 0;
    }
    ```
1. 使用glade
    ```c
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    // 为glade编写的函数
    G_MODULE_EXPORT void print_hello2(GtkWidget *widget, GtkTextBuffer *data) {
        GtkTextIter start;
        GtkTextIter end;
        gtk_text_buffer_get_start_iter(data, &start);
        gtk_text_buffer_get_end_iter(data, &end);
        g_print("Hello2 : %s\n", gtk_text_buffer_get_text(data, &start, &end, FALSE));
    }

    int main(int argc, char **argv) {
        GError *error = NULL;

        gtk_init(&argc, &argv);

        GtkBuilder *builder = gtk_builder_new();
        if (gtk_builder_add_from_file(builder, "builder2.ui", &error) == 0){
            g_printerr("Error loading file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        gtk_main();

        // 解引用放在后边，要不glade加载不出来
        g_object_unref(builder);

        return 0;
    }
    ```
1. 使用css
    ```
    #include <stdio.h>
    #include <gtk/gtk.h>
    #include <stdlib.h>

    int main(int argc, char **argv) {
        GError *error = NULL;

        gtk_init(&argc, &argv);

        // 加载css
        GtkCssProvider *css_provider = gtk_css_provider_new();

        if(gtk_css_provider_load_from_path(css_provider, "builder3.css", &error) == 0) {
            g_printerr("Error loading css file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        // 使用xml
        GtkBuilder *builder = gtk_builder_new();
        if (gtk_builder_add_from_file(builder, "builder3.ui", &error) == 0){
            g_printerr("Error loading builder file: %s\n", error->message);
            g_clear_error(&error);
            return 1;
        }

        // 应用css
        GObject *window = gtk_builder_get_object(builder, "window");
        gtk_style_context_add_provider_for_screen(gtk_window_get_screen(GTK_WINDOW(window)),
                                                    (GtkStyleProvider *) css_provider, GTK_STYLE_PROVIDER_PRIORITY_USER);

        gtk_main();

        g_object_unref(builder);

        return 0;
    }
    ```
1. 配置
    ```c
    int main(int argc, char **argv) {
        putenv("GTK_CSD=1");
        g_object_set(gtk_settings_get_default(), "gtk-theme-name", "Desert-1.2", NULL);     // 设置主题
    }
    ```
1. 其他
   - AWTK：基于c语言开发的GUI框架，支持跨平台同步开发
#### 运维
1. 打包发布：将依赖的动态库、静态库、资源文件都放到需要的目录下，然后搭配安装制作工具发布包
#### wiki
1. 面向对象设计理念
   - 在c中实现面向对象比较麻烦，定义多个属性父类(属性可以有多个)，再定义唯一一个覆写父类行为的class(行为都相同)
   - 由于结构体的第一个元素位置和结构体的起始位置相同，利用这个可以实现继承
   - gtk的继承关系：GObject->GInitiallyUnowned->GtkWidget->GtkContainer->GtkBin->GtkButtion->GtkToggleButton
1. wiki
   - 问题
     1. 怎么告诉gtk进行ui刷新，ui刷新的成本有多高？
     1. gtk会不停监听事件变化
