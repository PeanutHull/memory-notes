### Maven
1. 理解：用一小段描述来管理项目的构建、报告和文档的构建管理工具。来自于意第绪语（犹太语），意为知识的积累
1. 特点
   - 用于构建、文档生成、报告、依赖、SCMs、发布、分发、邮件列表
   - 简化了构建过程，将其标准化。无缝衔接编译、发布、文档生成、团队合作等
   - 约定优于配置
1. 概念
   - Project：目标项目
   - Pom：project object model，POM，项目对象模型，如何工作的元数据，表述了项目的资源，是做什么，而不是怎么做。位于根目录下
   - GroupId：工程名
   - Artifact：构件，存在于仓库中。由GroupId和ArtifactId唯一确定
   - Repository：仓库指定，有中央/公共/私有/本地仓库
   - Dependency：依赖包
   - Plug-in：插件
1. 原理
   1. 读取pom文件
   1. 下载依赖到本地
   1. 构建生命周期
   1. 构建phase(阶段)/goal(目标)：阶段由一系列的目标组成
   1. 构建插件：额外的构建目标，有官方的/自定义
   1. 构建配置
1. 命令
   1. `mvn archetype` // 创建maven项目
   1. `mvn install` // 在本地仓库安装依赖
   1. `mvn compile` // 编译源代码
   1. `mvn test-compile` // 编译测试源代码
   1. `mvn test` // 运行单元测试
   1. `mvn package` // 打包项目生成jar
   1. `mvn deploy` // 发布项目
   1. `mvn clean` // 清除项目的结果
   1. `mvn site` // 生成项目相关信息的网站
   1. `mvnjetty:run` // 启动jetty服务
   1. `mvntomcat:run` // 启动tomcat
   1. `mvn eclipse:eclipse ` // 生成eclipse项目文件
1. 使用
   - `mvn install:install-file -Dfile=name.jar -DgroupId= -DartifactId= -Dversion= -Dpackaging=jar` // 本地jar安装到本地仓库
   - `mvn clean package -Dmaven.test.skip=true` // 清除以前的包后重新打包，跳过测试类
### Gradle
1. 理解：基于Groovy和XML的构建工具
### Ant
1. 理解：集编译、测试、部署的自动化打包部署工具
1. Maven与Ant
   - Maven：声明式的方式，指定做什么，而不是怎么做
   - Ant：命令式的方式
### Tomcat
1. 理解：web服务器，也是servlet/jsp的运行环境/容器，最新servlet/jsp规范总能得到体现，技术先进、性能稳定、免费开源。静态html能力不如apache，可作为辅助web容器。组成：Container容器——Engine——HOST——Servlet。响应http过程：浏览器——tomcat——servlet容器——servlet实例...
1. 特点
   - web项目放在webapps下，默认访问ROOT目录
   - WEB-INF下的classes存放编译文件，容器利用web.xml中定义的路径可以找到多层目录下的编译文件
   - 自带docs/examples/manager/host-manager等工具文档
1. 运维
   - 手动部署war
     1. 删除webapp目录下的warName.war文件和warName文件夹，并放置新的war包
     1. 删除webapp同级文件夹work的Catalina
     1. 重启tomcat
   - 热部署war
     1. server.xml编辑 `<Context path="war路径" docBase="war名" reloadable="true"/>`
   - idea部署war
### Intellij Idea
1. 建立项目
   - 空白java：new--java--完成
   - 空白web
     1. 项目设置：File--New--Project--Java--Java EE--Web Application--下一步--项目名称
     1. 工程设置
        - WEB-INF目录--新建classes和lib目录
        - 编译目录：Project Structure--Modules--Paths选项卡--将Output path和Test output path设置为classes目录
        - 依赖目录：Project Structure--Modules--Dependencies选项卡--新增Export--JARs or directories--选择lib目录--Jar Directory
        - 打包方式：Artifacts--fix--add classes...
        - 配置tomcat
   - 空白maven项目
     1. 配置SDK、maven、tomcat
     1. 新建项目————maven————maven-archetype-webapp————配置项目信息
     1. src/main文件夹中创建java文件夹————并置为sources Root
     1. src/main文件夹中创建test文件夹————并置为test
     1. 添加tomcat server————local————Deployment————添加Aritfact————xx.war选项
1. 使用
   - 添加Problems(实时编译)功能：设置————compiler————打钩make project automatically
   - idea报错功能：设置————inspections————修改报错信息
   - 添加词库：Settings————Spelling
   - Live Template
     1. psvm 主入口
     1. sout 打印输出
   - 没有web目录，创建web目录并且启动tomcat的方法
     1. edit Configurations————添加tomcat server————local
     1. 添加Artifacts————Web Application：Exploded————From Modules
     1. 添加Facets————Web————选择Modules
   - 添加额外依赖的jar包
     1. 将包放置在webapp的lib目录中
     1. Project Structure————Modules————Dependencies————+号
     1. 添加maven的编辑插件，将本地的jar包也包含进去，目录指向lib目录
        ```xml
        <plugin>
        <groupId>org.apache.maven.plugins</groupId>
        <artifactId>maven-compiler-plugin</artifactId>
        <configuration>
            <source>1.8</source>
            <target>1.8</target>
            <encoding>UTF-8</encoding>
            <compilerArguments>
            <extdirs>${project.basedir}/src/main/webapp/WEB-INF/lib</extdirs>
            </compilerArguments>
        </configuration>
        </plugin>
        ```
1. 快捷键
   - 代码操作
     1. `Control + Enter`：智能辅助输入、getter和setter方法、生成接口类/接口实现类、生成单元测试类
     1. `Command + N`：getter和setter、构造函数、hashCode/equals,toString
     1. `Command + D`：复制当前行
     1. `Command + Delete`：删除当前行
     1. `Command + Option + T`：包围选中代码，有if、try、for等
     1. `Command + Shift + Enter`：自动结束代码
     1. `Command + Option + L`：格式化代码
   - 选择操作
     1. `Command + Shift + 上/下`：移动当前行上下
     1. `Shift + Enter`：开始新一行
     1. `Control + g`：向下选择相同的
     1. `Option + Shift + 左键双击`：多选
     1. `Option + 上/下`：渐进/渐退选择代码
     1. `Option + 左/右`：左右单词跳转
     1. `Option + Shift + 左/右`：左右选择单词代码
     1. `Option + Delete`：删除到单词的开头
     1. `Option + Fn + Delete`：删除到单词的末尾
   - 书签
     1. `Control + Shift + 1`：快速添加书签
     1. `Control + 1`：快速跳转到书签
   - 调试
     1. `F7`：下一步，进入方法
     1. `F8`：下一步，不进入方法
     1. `Shift + F8`：跳出
     1. `Option + F9`：如果光标前有其他断点会进入到该断点
     1. `Command + F8`：取消/添加当前行断点
     1. `Command + Option + R`：恢复程序运行，如果该断点下面代码还有断点则停在下一个断点上
     1. `Command + Shift + F8`：查看断点信息
   - 查询
     1. `Double Shift`：查询任何东西
     1. `Command + Shift + F`：全局查找
     1. `Command + G`：查找模式下，向下查找
     1. `Command + Shift + G`：查找模式下，向上查找
   - 导航
     1. `Control + 左/右`：标签页切换
     1. `Command + O`：快捷查找类文件
     1. `Command + L`：跳转行号
     1. `Command + B`：跳转到定义的方法
   - 文件
     1. `F5`：复制文件
     1. `F6`：移动文件
     1. `Shift + F6`：重命名
   - 其他
     1. `Control + 上/下`：方法间跳转
     1. `Command + Shift + U`：大小写切换
     1. `Command + .`：收缩/放开方法
     1. `Command + P`：显示方法的参数信息  