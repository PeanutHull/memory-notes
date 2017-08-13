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
   - Maven与Ant
     1. Maven：声明式的方式，指定做什么，而不是怎么做
     1. Ant：命令式的方式
### Ant
1. 理解：集编译、测试、部署的自动化打包部署工具
### Gradle
1. 理解：基于Groovy抛弃基于XML的构建工具
### Inteill Idea
1. Live Template
   - psvm 主入口
   - sout 打印输出