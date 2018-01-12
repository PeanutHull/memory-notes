1. Controller：和Model层通过JavaBean交流数据
1. Model
   - DAO：即数据模型，不处理业务逻辑，只为业务层提供辅助，完成获取原始数据或持久层数据等。被Service层调取执行数据操作，逻辑在service层写
   - Pojo：原始的数据Bean
1. Bean
   - 理解：遵循了JavaBean规范的类
   - 特点
     1. 必须为公共类，可序列化
     1. 若有构造参数，必须是无参的，类中不能出现main函数
     1. 所有属性是私有的，必须通过public的get/set/isXxx来操作
     1. 包含必要的事件处理方法，如addXxxListener、XxxEvent
   - 组成
     1. 属性
        - Simple属性：具有setter、getter方法对的属性
        - Indexed属性：表示数据值，针对数据的simple属性
        - Bound属性：属性值发生变化时，会触发其他JavaBean
        - Constrained属性：属性值将要发生变化时，与该属性建立关系的其他java对象可以否决其改变
     1. 事件：是事件发起者，也是接收者
1. POJO：Plain Old Java Objects，简单java对象，使编写应用程序类快速和简单，使用面向对象的角度写代码
1. Bean和EJB和POJO
   - 在java1996年发布,当年12月即发布了java bean1.00-A,有什么用呢?通过统一的规范可以设置对象的值(get,set方法),这是最初的java bean
   - 在实际企业开发中,需要实现事务,安全,分布式,javabean就不好用了.sun公司就开始往上面堆功能,这里java bean就复杂为EJB
   - EJB功能强大,但是太重了，此时出现DI、AOP技术,通过简单的java bean也能完成EJB的事情,这里的java bean简化为POJO
   - Spring诞生了
### DAO
1. 理解：Data Access Object，用来封装访问数据库的代码，即持久层
1. 部署脚本
    ```java
    echo "======更新代码======="    
    cd /developer/git-repository/mmall
    git fetch
    git pull
    echo "======编译并跳过单元测试======="
    mvn clean package -Dmaven.test.skip=true
    echo "======转移war包======="
    rm /developer/apache-tomcat-7.0.73/webapps/ROOT.war    
    cp /developer/mmall.war  /developer/apache-tomcat-7.0.73/webapps/ROOT.war
    rm -rf /developer/apache-tomcat-7.0.73/webapps/ROOT
    echo "======启动tomcat======="
    /developer/apache-tomcat-7.0.73/bin/shutdown.sh
    for i in {1..10}
    do
    echo $i"s"
    sleep 1s
    done
    /developer/apache-tomcat-7.0.73/bin/startup.sh
    ```
1. Java 从零打造企业级电商实战 - 服务端
   - MyBatis
     1. 返回新增的主键：mapper.xml文件中insert标签加入属性：`useGeneratedKeys="true" keyProperty="id"`
     1. 数据绑定更新对应数据：mapper.xml文件中update指定parameterType的类地址：`parameterType="com.mall.pojo.Xxx"`
     1. 批量插入：对应于子订单的批量插入
   - 获得当前运行的文件夹目录：`request.getSession().getServletContext().getRealPath('upload');`
   - 当使用`Set<Object>`，即自定义对象的Set集合，要在pojo中重写equals和hashCode方法，因为要保证这两个方法针对的对象属性相同，才能保证输出的bool结果的一致
   - 返回值为List的写法提醒`ServerResponse<List<Category>>`
### 淘淘商城
1. 技术点
   - Nginx反向代理
   - Druid数据库连接池
   - FastDFS：分布式文件系统
   - Redis集群缓存
   - Solr集群搜索
   - Freemaker模板引擎
   - 单点登录、session共享
   - Quartz任务调度：定时器
1. 架构组成
   - taotao-common：项目中用到的通用工具类和pojo
   - taotao-parent
   - taotao-manage
1. 功能点
   - maven的tomcat7插件启动项目：manager项目————右键————run as————第二个maven build————clean tomcat7:run
   - 静态资源映射：`<mvc:resources location="/WEB-INF/js/" mapping="/js/**"/>`，指定到WEB-INF目录下
   - 分页插件的使用
     1. 添加pagehelper的依赖
     1. myBatis配置文件中加入分页插件
        ```xml
        <plugins>
            <plugin interceptor="com.github.pagehelper.PageHelper">
            <!-- 指定使用的数据库是什么 -->
            <property name="dialect" value="mysql" />
            </plugin>
        </plugins>
        ```
     1. 书写分页代码
        ```java
        // 分页处理
		PageHelper.startPage(page, rows);
		// 执行查询
		TbItemExample example = new TbItemExample();
		List<TbItem> list = itemMapper.selectByExample(example);
		// 取分页信息
		PageInfo<TbItem> pageinfo = new PageInfo<>(list);
		// 返回结果
		EasyUIDataGridResult result = new EasyUIDataGridResult();
		result.setTotal(pageinfo.getTotal());
		result.setRows(list);
        return result;
        ```
   - 图片服务器
   - FastDFS：开源国产的分布式文件存储系统，实现了冗余备份、负载均衡、线性扩容等机制，注重高可用、高性能，提供上传、下载功能。Tracker集群提供负载均衡等调度，Storage集群提供存储
1. 知识点
   - 传参中使用Integer等包装类，起到缺少参数但是不报错的作用
   - log4j调试方法，怎么关闭运行时不停输出log信息