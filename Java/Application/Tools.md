### Maven
1. 理解：项目对象模型(POM)，用一小段描述来管理项目的构建、报告和文档的项目管理工具
1. 标签：项目构建工具
1. 功能：构建、文档生成、报告、依赖、SCMs、发布、分发、邮件列表
1. 概念
   - Project：目标项目
   - POM：如何工作的元数据
   - GroupId：工程名
   - Artifact：构件，存在于仓库中。由GroupId和ArtifactId唯一确定
   - Repository：仓库指定，有中央/公共/私有/本地仓库
   - Dependency：依赖包
   - Plug-in：插件
1. 特点
   - 简化了构建过程，将其标准化。无缝衔接编译、发布、文档生成、团队合作等
   - 约定优于配置，
   - 来自于意第绪语（犹太语），意为知识的积累
1. 组成
   1. 项目对象模型：POM，表述了项目的资源，是做什么，而不是怎么做。有源码/测试/依赖，位于根目录下
   1. 标准集合
   1. 项目生命周期，包括插件和目标
   1. 依赖管理系统
1. 原理
   1. 读取pom文件
   1. 下载依赖到本地
   1. 构建生命周期
   1. 构建phase(阶段)/goal(目标)：阶段由一系列的目标组成
   1. 构建插件：额外的构建目标，有官方的、也可自定义
   1. 构建配置
1. 使用
   - 使用过程
     1. 安装
     1. 指定jar包仓库位置
     1. 编辑pom文件，指定依赖
   - 功能点
     1. 父pom：构建子级项目，继承父pom值
1. 常用命令
   1. `mvn archetype` // 创建maven项目
   1. `mvn compile` // 编译源代码
   1. `mvn test-compile` // 编译测试源代码
   1. `mvn pachage` // 打包项目生成jar
   1. `mvn clean` // 清除项目的结果   
   1. `mvn clean package -Dmaven.test.skip=true` // 清除以前的包后重新打包，跳过测试类
   1. `mvn install` // 在本地Repository中安装jar
   1. `mvn deploy` // 发布项目   
   1. `mvn site` // 生成项目相关信息的网站
   1. `mvn test` // 运行单元测试
   1. `mvnjetty:run` // 启动jetty服务
   1. `mvntomcat:run` // 启动tomcat
   1. `mvn eclipse:eclipse ` // 生成eclipse项目文件
1. 附
   - java发布过程：源代码——生成项目文档——编译——打包——安装jar/war/zip包到服务器
   - 本地jar/项目安装到本地仓库
     1. 本地jar：mvn install:install-file -Dfile=name.jar -DgroupId= -DartifactId= -Dversion= -Dpackaging=jar
     1. 本地项目
        - `mvn clean package`
        - `mvn clean install`
        - 将本目录下的对应路径的依赖复制到本地仓库地址中
   - Maven与Ant
     1. Maven：声明式的方式，指定做什么，而不是怎么做
     1. Ant：命令式的方式
### Gradle
1. 理解：基于Groovy和XML的构建工具
### Ant
1. 理解：集编译、测试、部署的自动化打包部署工具
### Inteill Idea
1. IDEA创建空白Servlet项目
   - 项目设置：File--New--Project--Java--Java EE--Web Application--下一步--项目名称
   - 工程设置
     1. WEB-INF目录--新建classes和lib目录
     1. 编译目录：Project Structure--Modules--Paths选项卡--将Output path和Test output path设置为classes目录
     1. 依赖目录：Project Structure--Modules--Dependencies选项卡--新增Export--JARs or directories--选择lib目录--Jar Directory
     1. 打包方式：Artifacts--fix--add classes...
     1. 配置tomcat
1. 添加Problems(实时编译)功能：设置————compiler————打钩make project automatically
1. IDEA报错功能：设置————inspections————修改报错信息
1. 搭建空白项目
   - IDEA配置SDK、Maven、Tomcat
   - 新建项目————Maven————maven-archetype-webapp————配置项目信息
   - src/main文件夹中创建java文件夹————并置为sources Root
   - src/main文件夹中创建test文件夹————并置为test
   - 添加Tomcat Server————local————Deployment————添加Aritfact————xx.war选项
1. 没有web目录，创建web目录并且启动tomcat的方法
   1. edit Configurations————添加tomcat server————local
   1. 添加Artifacts————Web Application：Exploded————From Modules
   1. 添加Facets————Web————选择Modules
1. 添加额外依赖的jar包
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
1. 添加词库：Settings————Spelling
1. Live Template
   - psvm 主入口
   - sout 打印输出
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