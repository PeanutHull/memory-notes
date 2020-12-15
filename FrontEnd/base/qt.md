### qt
1. 认识：用于开发图形界面程序，是 GUI framework，xml语法的.ui定义界面，还有pyqt
   - 简单易学，封装的很好，不需要了解window api。资料丰富
   - 界面优秀，功能丰富。多线程、访问数据库、图库处理、音视频处理、网络通信、文件操作等，用于桌面级和嵌入式的开发
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