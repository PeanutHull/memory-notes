#### 目录
1. 认识
1. 应用
1. 性能
1. 原理
1. WIKI
### 路线：基础知识（操作、配置、历史）——优化方式、方法、注意点——各种技术方案——原理
### 提升：集群部署--中间件实施--备份设计监控--日志处理--授权
### 认识
1. 理解
   - 数据库：是按照数据结构来组织、存储和管理数据的仓库，会提供API进行数据的操作。因为文件中读写数据不方便、速度也慢
   - 关系型数据库：建立在关系模型基础上，由行、表、库等组成
   - MySQL：瑞典的属于Oracle公司的开源数据库，使用标准sql语句，支持多种语言如c、php等，32位最大表文件4GB，64的8TB
1. 数据类型
   - 数字
     1. bit：默认1，长度1~64，如bit(6)
     1. tinyint：-128~127，smallint：前后3万2，mediumint：前后8.3千万
     1. int：范围前后21亿，int中m仅用于显示，不影响存储范围，如int(5)，显示为00001，和INTEGER相同
     1. bigint：前后9亿亿亿，19位，2E64，
     1. decimal：精确小数值，m是数字总个数，d是小数点后个数，m最大值为65，d最大值为30，能够存储精确值的原因在于其内部按照字符串存储
     1. float：前后38次方，数值越大，越不准确
     1. double：前后308次方，数值越大，越不准确
   - 字符串
     1. char：定长字符串，0~255字节，m表示长度，即使数据小于m，也占用m长度，处理速度更快，甚至快过varchar50%
     1. varchar：变长字符串，0~255字节，m表示最大保存长度
     1. binary：二进制形式的字符串，即包含字节字符串，不包含字符字符串，没有字符集
     1. text：大字符串，0~65535字节，2E16，mediumtext：1600万，2E24，longtext：42亿长度或4GB字符，tinytext
     1. blob：二进制形式的长文本数据，0~65535字节，tiny/medium/longblob，可变长度
   - 其他
     1. enum：枚举，0~65535，如`enum('','')`
     1. set：集合，0~64，可以存一个集合，如`set('','')`
     1. json：5.7.8支持，与longtext大小差不多，不能有默认值，不能直接被编为索引，可以在虚拟列上创建
   - 时间
     1. DATETIME：YYYY-MM-DD HH:MM:SS (1000-01-01 00:00:00/9999-12-31 23:59:59)，日期和时间
     1. TIMESTAMP：YYYY-MM-DD HH:MM:SS (1970-01-01 00:00:00/2038 格林尼治时间/北京时间)，日期和时间/时间戳，只是时间戳表示的范围，可以有自动更新机制
     1. DATE：YYYY-MM-DD (1000-01-01/9999-12-31)，日期
     1. TIME：HH:MM:SS ('-838:59:59'/'838:59:59')，时间或持续时间
     1. YEAR：YYYY (1901/2155)，年份
   - 修饰符
     1. unsigned
     1. zerofill
1. sql基本操作
   - SQL操作语言的分类
     1. DCL：对数据库的操作：mysql、use、set、show
     1. DDL：对表的操作：show、create、drop、alter
     1. DML：对数据操作：select、insert、delete、update、replace
   - 基础
        ```
        mysql -h地址(不写-h默认localhost) -u账号 -p密码          # 连接
        quit/exit                                             # 断开
        status 包含版本、连接的账号                              # 状态
        select version()/database()/user();                   # 查看
        show status                                           # 服务器状态
        ```
   - DCL和DDL
        ```
        // show
        show databases/tables;                          # 查看数据库或表
        show create database/table baseName/tableName;  # 输出标准sql语句
        show columns/index from tabel;                  # 查看列/索引信息
        show table status from baseName like \G;        # 显示匹配的表信息
        use database;                                   # 选择库
        desc tables;                                    # 查看表结构
        set baseName utf8/gbk;                          # 设置库编码
        // create
        create database xxx default character set = utf8mb4 COLLATE utf8mb4_general_ci;   # 创建库
        create table table_name(                                                          # 创建表
            id int unsigned primary key auto_increment,
            username char(25) unique not null default '',
        )ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='';
        create table tableName1 like tableName;                                           # 复制表结构
        insert into tableName1 select * from tableName;                                   # 复制表数据
        create table tableName1 select * from tableName;                                  # 复制表结构和数据
        create unique/fulltext/spatial index indexName using btree/hash/rtree             # 创建索引
        // alter
        alter table tableName rename newName;                                             # rename，修改表名
        alter table tableName add columnName int unsigned not null default 0;             # add，追加字段
        alter table tableName add primary key(sid);                                       # add，增加主键
        alter table tableName add index/unique/key/fulltext/spatial indexName(xx);        # add，增加索引
        alter table tableName change new_column column char(20) not null default '';      # change，列名，类型
        alter table tableName modify name char(20) first/after sex;                       # modify，只修改类型，显示顺序调整
        alter table tableName engine=mysiam                                               # 修改引擎
        alter table tableName drop columnName;                                            # drop，删除字段
        alter table tableName drop primary key;                                           # drop，删除主键，先删除自增，再删字段
        alter table tableName drop index indexName;                                       # drop，删除索引
        // drop
        drop database/table if exists baseName/tableName;                                 # 删除库/表
        drop index indexName on table                                                     # 删除索引，各种类型的索引都用这个删除
        // lock
        lock tables `user` write/read;                                                    # 锁表
        unlock tables;
        ```
   - DML
        ```
        // 查询语句组合
        select */,/count()/min()/max()/sum()/avg()/distinct()/concat(XX,XX)               # 选择字段，distinct去重可能要全表扫描，concat字符串连接
        from table/from table1 as x,table2 as x/from(select * from table2)derivedName     # 选择表
        inner/left/right join table2 as x2 on x1.x=x2.x                                   # 连表查询
        union select * from table2                                                        # 组合查询
        select xx from table as x1 join table as x2 on x1.xx=x2.xx                        # 自关联        
        where x.x/=/</>/<=/!=/<>/is null/is not null/like/in(,,)/not in/REGEXP '^$'       # 条件
        and/or/between xx and xx                                                          # 逻辑
        XX=exists/not exists(select x from table2 where xx=xx);                           # 子查询，把另一个查询语句的结果做数据来源，加上exists则返回布尔值
        group by having condition1 and condition2                                         # 分类筛选
        order by xx1 desc/asc/rand() xx2 asc                                              # 排序，多个排序规则
        limit x/limit x offset x/limit x.x                                                # 限制条数/从x行开始的x行
        // 插入数据
        insert into table set XX=xx/(,,) values (,);                                      # 插入数据
        replace into table (,,) values (,,);                                              # 插入或更新指定数据，未指定恢复默认值，命中主键修改，未命中添加
        insert into table1 select ,, from table2                                          # 复制表
        // 更新数据
        updata table set XX1=xx1, XX2=xx;                                                 # 会更新所有数据
        update t1,t2 set t1.xx=xx,t2.xx=xx                                                # 多表更新
        update t1 join t2 on t1.xx=t2.xx set t1.xx=xx                                     # 多表更新,join
        // 删除数据
        delete from table where XX=xx;                                                    # 删除
        delete t1,t2 from t1 join t2 on t1.xx=t2.xx;                                      # 多表数据删除
        delete from table;                                                                # 删除所有数据
        truncate table;                                                                   # 数据清空，主键归0
        ```
1. 变量：基于会话，用户变量不区分大小写。定义 `set @a:=/=1`
1. 数据
   - 查询
     1. 精确：is null、is not null、regexp ''
     1. 模糊：like、in、not in
     1. 聚集函数：count()/sum()/min()/max()/avg()/median()/rank()/first()/last()/distinct()/concat(XX,XX)
     1. 分组
        - group by：用列的值进行分组/计算，必须在where之后order by之前，select的字段除了被group的其他要么被统计，要么没有
        - having：筛选成组后的数据，作用于组，如`having sum(age) > 10`
     1. 多表
        - 连表
          1. inner join：无关系不显示，同join
          1. left join：获取左表所有记录，即使右表没有
          1. right join：反过来
          1. cross join：在mysql中和inner join相同，标准sql中不同，产生笛卡尔集，即M*N，
        - 组合
          1. union：自动处理重合，即去掉重复的数据，以第一个取出的为准
          1. union all：不处理重合，相反
   - 更新
     1. replace
        - 认识：是标准sql的mysql扩展，使用primary key/unique key确定是否插入新行，注意！！！会抹掉其他未指定数据，这个应作为插入数据使用，而不是更新
        - 原理：将数据插入，成功则结束；否则引发重复键错误，先删除原有记录，然后更新
1. 数据表
   - 结构设计
     1. auto_increment：自增，必须是索引列(index/primary key)，而且只能有一个自增列，可以设置起始值和步长
     1. primary key：主键约束，作为一行的标识符，通过其来定位，不能重复不能为空，特殊的唯一索引，复合主键也唯一如`primary key(id,name)`
     1. foreign key：外键约束，保证表之间数据完整性和准确性，体现表之间关系，可以进行级联操作，由于对业务的强一致性要求，现在都由程序控制，不使用外键关联
        - 基本形式：`constraint foreignKeyName foreign key(self_id) references foreign_table(foreign_table_id)`，这时被连接的表中被连接的数据不能被删除
        - 级联限制：`constraint foreignKeyName foreign key(self_id) references foreign_table(foreign_table_id) on delete/update cascade;`，删除被连接数据自己也被删除，连带删除
     1. unique：唯一约束，保证列数据的唯一性
     1. not null
     1. default
   - 存储引擎
     1. MyISAM：5.5之前的默认引擎，用于只读提高性能、不支持事务、不支持外键，最大256TB，可以压缩为只读表
     1. InnoDB
        - MVCC: Multi-Version Concurrency Control 多版本并发控制，多种行锁机制组合
        - 特点：
          1. 事务
          1. 行级锁
          1. 并发
          1. 实现sql标准的4种隔离级别
          1. 插入缓存(insert buffer)
          1. 二次写(double write)
          1. 自适应hash索引(adaptive hash index)
          1. 预读(read ahead)
          1. 索引是其表空间的组成部分
     1. merge：将具有相似结构的多个MyISAM表组合到一个表中的虚拟表
     1. memory；内存表存储在内存中，并使用散列索引，使其比MyISAM表格快，服务器停止数据丢失
   - 索引
     1. 理解
        - 为了加快查询速度，对数据列进行排序的一种结构，类似于目录，是一种特殊的文件，包含所有记录的引用指针
        - 在查询数据时先检查索引是否存在，然后精确到对应行，而不是扫描整表
     1. 特点
        - mysql的索引都是b+tree
        - 数据库必须构建、维护索引表，太多的索引影响更新和插入的速度。加快查询速度，减慢修改速度
        - 查询时只能使用一个索引，会选择限制最严格的索引
        - 最左前缀原则：组合索引只会从左边开始按照索引搜索，如果检索条件没有最左的，那么就不会使用到索引，因为不知道去哪儿开始找。所以不用给联合索引最左边的单独建立索引了
        - key和index：相同，mysql为了兼容其他系统，都是索引，key多了一层约束层含义
        - 选择性：指不重复的索引值和总数的比值，范围0~1，索引的选择性越高查询效率越高，唯一索引的选择性是1性能是最好的
     1. 分类
        - 普通索引：key、index，只用于加快访问速度
        - 唯一索引：unique、unique key，唯一值，可以组合索引。除了BDB外，都允许重复的NULL值
        - 主键索引：primary key，不能重复，不能为null，隐式声明不能为null
        - 外键索引：foreign key
        - 前缀索引：column(n)，鉴于选择性原则，根据内容制定合适的前缀长度，以达到最佳查询效果。无法做order、group、覆盖扫描
        - 全文索引：fulltext，用于文本搜索，仅MySIAM支持，仅作用于char/varchar/text
        - spatial：空间列，值不能为null
     1. 类型分类
        - 聚簇索引：按数据存放的物理位置为顺序，提高多行的检索速度
        - 非聚簇索引：单行检索快
     1. 聚集索引或非聚集索引的选择
     1. 建立原则
        - 更多的索引意味着增删改更慢，占用更多空间
        - 数据量少的不能建立
        - 数据差别不大，数据又经常改变的不适用
        - 使用短索引：提高查询速度，节省空间和io
        - 尽量选择区分度高的列作为索引：区分度的公式是COUNT(DISTINCT col)/COUNT(*)，表示字段不重复的比率，比率越大我们扫描的记录数就越少，唯一索引是1
        - 尽可能扩展索引，而不是增加索引
        - 长字符串使用前缀索引：通过select left(column,n)不断增加n查看重复行的减少，以达到最佳选择性
        - 合理添加联合索引：多列经常查询/排序使用联合索引
        - 不能有null：有null的列不会包含在索引中
     1. 使用原则
        - !=、not in、<>不使用索引，范围查询可能用到索引如>、in等
        - or前后条件都有索引，整个语句才使用索引，否则推荐用union
        - 不在列上运算：因为每个行要运算所以索引失效
        - like使用：最左原则，%aa%不使用索引，而aa%使用
        - 索引列排序：一个查询语句只用一个索引：where用了，order by就没法用，所以只有order的字段在where中才会用
     1. 结构
        - 分类
          1. hash索引：由引擎根据情况自动创建，不能人为干涉
          1. B+tree：mysql中是否还存在B-类型？？？
        - Hash索引
          1. 理解：比较hash计算后的hash值会变得没有规律，只能等值过滤
          1. 优点：只需一次定位检索效率很高，不像btree需要多次io跑节点
          1. 缺点
             - 不能范围查找，只能=/<>/in
             - 不支持索引的排序操作
             - 不能使用前缀索引查询
             - 任何时候不能避免全表查询，因为重复hash值的存在，需要查表获得实际数据
        - 索引结构引擎支持
          1. InnoDB/memory/heap：b+tree、hash
          1. MySIAM：b+tree、rtree(空间列是rtree)
   - 事务
     1. 理解：保证所有操作全部执行，用于数据量大、复杂的操作
     1. 特性：ACID
        - 原子性：一个事务是一个整体，要么全部成功，要么全部失败
        - 稳定性：有非法数据(外键约束等)，事务撤回
        - 隔离性：在一个客户端执行事务未完成，所修改的数据对其他客户端是不可见的，是原来的数据
        - 可靠性
     1. 隔离级别
        - READ UNCOMMITTED     最低级别，会导致数据完整性的严重问题
        - READ COMMITTED       
        - REPEATABLE READ      默认，一个事务开始后其他session对数据库的修改在本事务中不可见，直到本事务commit或rollback
        - SERIALIZABLE         最高级别，性能问题并增加死锁的机率
     1. InnoDB行锁基于索引
     1. 示例
        ```
        set autocommit=0/1;                 # 禁止/开启自动提交
        set transaction;                    # 设置隔离级别
        
        begin;/start transaction;
        commit;
        rollback;

        savepoint xx;                       # 创建标记点
        release savepoint xx;               # 删除标记点
        rollback to xx;                     # 回滚到标记点
        ```
   - 临时表
     1. 临时表：只在当前连接可见，关闭连接自动删除，如`create temporary table tableName ();`，show tables看不到该表
     1. 派生表：是select返回的虚拟表，即from使用的独立子查询，可以和子查询互换使用。如`from(select * from table2)derivedTableName`
     1. 公共表表达式：CTE，是一个命名的临时结果集，仅在单个SQL语句的执行范围内存在，比派生表更易读，性能更高 
   - 表间关系
     1. 一对一
     1. 一对多
     1. 多对多
1. mysql操作
   - mysql服务
     1. 查看：`ps -ef | grep mysqld`
     1. 启动：`mysqld_safe &`
     1. 关闭：`mysqladmin -u -p shutdown`
   - 视图
     1. 理解：即虚拟表，可以对视图进行操作，作用有简化查询，限制用户访问和权限。不支持物理视图，可以进行查询和更改，表改变不会联动视图改变    
     1. 创建：`create view viewName as select * from table`，分辨视图 `show full tables;`
   - 触发器
     1. 理解：triggers，自动执行响应事件的存储程序
     1. 分类
        - before/after insert/update/delete
     1. 实例
        ```
        create trigger triName
            before update on table
            for each row
        begin
            # some sql
        end;
        ```
   - 预解析
     1. 理解：使用占位符预先准备查询语句，不用解析语句，查询速度更快，防止注入。步骤有：prepare、execute、deallocate prepare(发布)
     1. 实例
        ```
        PREPARE stmt1 FROM 'select ... ?';          # 准备占位符

        SET @a = '1';
        EXECUTE stmt1 USING @a;

        DEALLOCATE PREPARE stmt1;
        ```
   - 存储过程
     1. 理解：在mysql中存储了sql语句，预先缓存编译结果、执行速度快，传输数据少。耗内存，不灵活
     1. 实例
        ```
        CREATE PROCEDURE procedureName()
        BEGIN
            SELECT * FROM user;
        END
        ```
   - explain
     1. 性能测试原则：数据多才有参考价值，例如几百条数据第一条命令下去就全部加载到内存了，没有参考意义。只有记录超过1000条，数据总量超过内存总量
     1. 理解：对语句进行分析，将过程和索引等信息列出来
     1. 结果解析
        - select_type：查询类型，simple、primary、union、subquery
        - type：在表中找到所需行的方式，即访问类型，效率由高到低system、const、eq_ref、ref、range、index、All
          1. system/const：最多一个匹配行，主键或者唯一索引，性能最优
          1. eq_ref：多表连接中使用唯一索引
          1. ref：非唯一索引/唯一索引的前缀扫描
          1. range：索引范围扫描
          1. index：索引全扫描
          1. all：全表扫描
        - possible_keys：可用的索引
        - key：实际使用索引
        - key_len：索引使用字节数，越小越好越快
        - ref：另外表的数据列名字
        - row：预计读出的数据行数，里面所有数字乘积代表需要处理的组合数
        - extra：问题解决提示信息
   - 慢查询
1. 数据库操作
   - 备份库
   - 恢复库
### 应用
1. 锁
1. 悲观锁————Pessimistic Locking
   - 理解：读取的时候为后面的更新加锁，之后再来的读操作都会等待。这种是数据库锁
   - 意义：数据修改的排他性。高并发下，数据可以正确写入。但是带来数据库性能的大量开销，影响并发访问性，其他修改操作就需要等待。特别是长事务，无法承受会超时。一般不能用
   - 分类
     1. 行级锁：Row-Level Lock，InnoDB默认
     1. Table Lock
   - 举例
        ```
        // 要使用悲观锁，我们必须关闭mysql数据库的自动提交属性，因为MySQL默认使用autocommit模式，也就是说，当你执行一个更新操作后，MySQL会立刻将结果进行提交。
        我们可以使用命令设置MySQL为非autocommit模式：
        set autocommit=0;
        //0.开始事务
        begin;/begin work;/start transaction; (三者选一就可以)
        //1.查询出商品信息，本次事务完成后才能修改数据
        select status from goods where id=1 for update;
        //2.根据商品信息生成订单
        insert into orders (id,goods_id) values (null,1);
        //3.修改商品status为2
        update t_goods set status=2;
        //4.提交事务
        commit;/commit work;
        // 再次给同一行加锁时，需要等待上一次锁的结束
        // MyIsam引擎这样会将整个表锁住
        // InnoDB会锁住当前行，但是如果改的字段是索引或者自增字段，也会锁住整个表
        update xxx SET xxx WHERE xxx=xxx for update;
        // Thinkphp的悲观锁，只有数据库提供的锁才能保证正确
        $User->lock(true)->save($data);
        ```
1. 乐观锁————Optimistic Locking
   - 定义：乐观并发控制，Optimistic concurrency control
   - 理解：基于数据版本（ Version ）记录机制实现。给普通的数据表添加updatetime/version等版本标识字段，先读数据，再根据version的值去更新数据，这样在高并发情况下，数据不会产生错误。
   - 特点：一旦发现其他并发操作更新，会回退，并从新执行自己的流程。
   - 优缺点：程序实现，不会存在死锁。但是阻止不了除了程序之外的数据库操作
   - 方法：
    1. 数据版本记录机制
       - 读数据时，将version一同读出
       - 更新数据时，对比数据局版本
       - 版本正确，更新数据，version加1
       - 版本错误，认为是过期数据，采取补救措施
    1. 时间戳对比记录机制
   - 举例
    ```
    // 得到原始的version值
    select version from product;
    // 依据当时的version值去更新数据
    update xx SET xx WHERE xx=xx AND version=1
    // 当effect=0时，即证明数据早被更新了。要采取其他手段去补救
    // Thinkphp的乐观锁
    继承高级模型，加上lock_version字段，定义optimLock属性
    ```
1. 分布式事务
1. 主从，amoeba，故障切换
1. 读写分离
1. 数据库中间件，故障切换
1. 监控系统
1. 分表
1. 物理备份、逻辑备份、binlog增量恢复
1. sql注入
   - 类型：like注入，使用php的addcslashes
   - 安全措施
     1. 不要相信用户输入
     1. 不要动态拼接sql，使用参数化sql或存储过程
     1. 异常信息尽量少给出提示
   - 工具
     1. jsky：漏洞扫描工具
### 性能
1. 硬件：主频高处理快高吞吐低时延，L1/2/3的cache大速度快，内存大磁盘读写少TPS高，固态快机械配阵列卡，网卡好低时延，文件系统用xfs/ext4坚决不用ext3，
1. 设计和使用
   - 主键：一定有主键，最好是自增，否则多次读写后更离散，更多随机io
   - 数据类型：
     1. int比string快
     1. 坚决不用char/uuid，ip用INT UNSIGNED不用CHAR
     1. 长数字使用字符串存储，不能用int，会慢
     1. 增加create_time/update_time字段，用于数据归档/自定义差异备份
   - 数据长度：越短越好，更少存储/内存空间
   - sql语句：
     1. 无select *，提高利用覆盖索引的几率，避免sql注入，用PREPARE预处理，用SQL_MODE做限制，sql中无计算，where中无函数
     1. 所有where条件加引号，防止类型隐式转换
     1. like查询%不做最左前导否则索引失效
     1. 尽量inner join让优化器自动选择驱动表
     1. 关键业务上线前EXPLAIN确认执行计划
     1. 存了数字的字符串加上引号     
   - 运维
1. 配置调优
   - 运行和错误日志
   - 软、硬件崩溃后，InnoDB数据表驱动会利用日志文件重构修改。可靠性和高速度不可兼得，innodb_flush_log_at_trx_commit 选项 决定什么时候吧事务保存到日志里
### 原理
1. 语法分析器：优化查询，会帮你优化成索引可以识别的模式
1. 磁盘
   - 数据数据交换：总用时9ms，500-MIPS的机器每秒可以执行5亿条指令，执行一次I/O的时间可以执行40万条指令。数据库动辄百万级甚至千万级的数据，每次9ms的时间，显然是一个灾难
     1. 寻道时间：5ms
     1. 旋转延迟：7200转，1/120/2=4.17ms
     1. 传输时间：0.nms
   - 磁盘访问的成本大概是内存访问成本的十万倍左右
   - 内存读取数据的局部预读性，每一次I/O读取的数据我们称之为一页（Page）。具体一页的数据有多大，这个跟操作系统有关，一般为4K或8K
1. 索引的数据结构
   - 理解：是常见的数据结构，可以显著减少定位记录需要的过程，一般用于数据的索引。B被认为Balance的缩写
   - 分类
     1. btree：二叉搜索树，每个结点只存储一个关键字，等于则命中，小于走左结点，大于走右结点
     1. b-tree：多路搜索树，每个结点存储M/2到M个关键字，非叶子结点存储指向关键字范围的子结点；所有关键字在整颗树中出现，且只出现一次，非叶子结点可以命中
     1. b+tree：在B-树基础上，为叶子结点增加链表指针，所有关键字都在叶子结点中出现，非叶子结点作为叶子结点的索引；B+树总是到叶子结点才命中
     1. b*tree：在B+树基础上，为非叶子结点也增加链表指针，将结点的最低利用率从1/2提高到2/3
   - 涉及知识点：平衡算法
   - B+tree
     1. 理解
        - 二分查找一级级向叶子节点，io查找数据库和指针，内存计算向哪个方向
        - 三层的B+树可以表示上百万的数据，如果上百万的数据查询只需要三次I/O，性能提高将会是巨大的。B+树就是一种索引数据结构，如果没有这样的索引，每个数据项发生一次I/O，那么成本将会大大提升
        - I/O的次数取决于B+树的高度H，假设当前数据表的数据为N，每个磁盘块的数据项的数量是M，则有：H=log(M+1)N，当数据量N一定的情况下，M越大，H越小；而M=磁盘块大小/数据项大小，磁盘块大小也就是一个数据页的大小，是固定的，如果数据项占的空间越小，数据项的数量越多，树的高度也就越低。这也就是为什么每个数据项，即索引字段要尽量的小，比如int占4个字节，要比bigint的8个字节小一半。这也是为什么B+树要求把真实数据放在叶子节点内而不是内层节点内，一旦放到内层节点内，磁盘块的数据项会大幅度的下降，导致树层级的增高。当数据项为1时，B+树会退化成线性表
        - B+树的数据项是复合性数据结构，比如（name，age，gender）的时候，B+树是按照从左到右的顺序来建立搜索树的，比如当（小张，22，女）这样的数据来检索的时候，B+树会优先比较name来确定下一步的搜索方向，如果name相同再依次比较age和gender，最后得到检索的数据。但是，当（22，女）这样没有name的数据来的时候，B+树就不知道下一步该查哪个节点，因为建立搜索树的时候，name就是第一个比较因子，必须根据name来搜索才知道下一步去哪里查询。比如，当（小张，男）这样的数据来检索时，B+树就可以根据name来指定搜索方向，但下一字段age缺失，所以只能把名字是“小张”的所有数据都找到，然后再匹配性别是“男”的数据了。这个是非常重要的一条性质，即索引的最左匹配特性
   - 不同引擎的区别
     1. Innodb中，Leaf Nodes存放其他字段实际数据，还包含主键值，Secondary Index和普通b-tree相同，所以主键查询非常快，Secondary需要先找到Leaf再找主键值
### 运维
1. 安装
    ```java
    yum -y install mysql-server // 安装
    vim /etc/my.cnf // 设置字符集
    character-set-server=utf8 // [mysqld]下添加
    default-character-set=utf8
    ```
1. 数据导入和导出
   - 导出
    ```
    mysqldump -u -p [databaseName or tableName] > data.sql                  # -d 只导出结构，-t 只导出数据
    select * into outfile 'data.txt' fields terminated by ',' optionally enclosed by '"' lines terminated by '\n' from table;
    ```
   - 导入
    ```
    mysqlimport -u -p --local databaseName dump.sql
    source xx.sql
    mysql -u -p [databaseName] < data.sql
    load data local infile 'data.txt' into table tableName;
    ```
1. 用户和权限管理
   - user
    ```
    select * from mysql.user\G;                                      # 查看用户
    update mysql.user set password=password('') where user='';       # 修改用户密码
    
    create user userName@'::1' identified by 'password';             # 创建用户 
    rename user oldName to newName;                                  # 重命名
    set password for userName@'%' = password('');                    # 修改用户密码
    drop user username;                                              # 删除用户
    ```
   - 权限
     1. 指令
        ```
        show grants (for userName);                                     # 查看用户权限
        grant select,update on *.* to userName@'%';                     # 赋予权限
        grant all privileges on *.* to userName@"";                     # 所有权限，不包括管理权限
        grant all privileges on *.* to userName@'' WITH GRANT OPTION;   # 具有管理权限，也就是管理员
        revoke select on *.* from userName;                             # 回收权限
        revoke grant option on *.* from userName;                       # 回收管理权限，需要显示指定
        FLUSH PRIVILEGES;                                               # 刷新权限，更改了都要刷新
        ```
     1. user表中host列的值的意义
        - %：匹配所有主机
        - localhost：localhost不会被解析成IP地址，直接通过UNIXsocket连接
        - 127.0.0.1：会通过TCP/IP协议连接，并且只能在本机访问；
        - ::1：兼容支持ipv6的，表示同ipv4的127.0.0.1
     1. 一些权限的意义
        - usage：无权限
        - select：查询
        - select,insert：查询，插入
        - INDEX：创建/删除索引
        - PROCESS：查看/杀死线程
        - RELOAD：重载授权表、清空日志/主机缓存/表缓存
        - SHUTDOWN：关闭服务器
        - ALL：所有；ALL PRIVILEGES同义词，除grant外
### WIKI
1. 一些操作
   - 插入不重复的数据行，MySQL特有的，不是标准sql语法：`INSERT token(udid) values ('{$udid}') ON DUPLICATE KEY UPDATE activetime ='{$time}'`
   - 原所有id增加5万，必须倒叙操作：`update user SET uid=uid+50000 order by uid desc;`
   - 查询这个数据是否存在，存在则存到另一张表里：`create table temp as select * from admin a where exists (select uid from user u where a.userName = u.account);`
   - 查询两张表中是否有相同的数据：`select * from admin wherer uid IN(select uid from temp);`
   - 求差集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx WHERE B.id IS NULL union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx WHERE A.id IS NULL;`
   - 求全集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx;`
1. 默认数据库的含义
   - mysql：用户/权限相关，user表存储了用户和权限
   - information_schema：自身架构相关
   - performance_schema
   - sys
1. 函数
    - 数学：format()/round()/pow()/abs()/sin()/cos()/tan()/bit_and()/
    - 字符串：char()/concat()/length()  
    - 常用
      1. cast：类型转换，如`cast(1 as signed)`
      1. rand
      1. replace
    - password
    - UNIX_TIMESTAMP：时间转换为时间戳
    - match：全文搜索
    - uuid()：aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
1. 严格模式
1. mycat：开源分布式数据库中间件
1. NULL与任何其它值的比较永远返回false，即使NULL=NULL也返回false
1. 注释 ：--、#、/**/
1. 5.6版本的新特性
   - server参数默认值设置的变化
   - innodb增强
     1. 支持online DDL
     1. 新增参数innodb_page_size设置页大小
     1. undo log可独立出系统表空间
     1. redo log最大增至512G
     1. 独立表空间的.ibd文件可以在建表时指定目录
     1. 支持read-only事务
     1. 支持全文本搜索
     1. 导入和导出表空间，copy文件的方式比mysqldump快好多
     1. 缓冲池flush算法增强
     1. innodb内部性能增强：包括将flushing操作独立出主线程，减少核心互斥锁，可设置多个清除线程，减少大内存系统的资源争夺
     1. 检测死锁算法增强。在非递归情况下死锁检测：死锁信息可以记录到 error 日志，方便分析
     1. 优化器统计持续化：重启不丢失
   - 复制和日志增强
     1. 新增GTID复制
     1. 新增binlog_row_image
     1. master.info和relay-log.info支持存储在表中
     1. mysqlbinlog命令支持binlog备份
     1. 支持延时复制：MASTER_DELAY
     1. 基于schema级别的多线程复制
     1. binlog支持crash-safe
   - 数据类型
     1. datetime类型支持DEFAULT CURRENT_TIMESTAMP和ON UPDATE CURRENT_TIMESTAMP
   - 分区增强
     1. 最大分区个数增至8192，包括分区和子分区
     1. 支持分区表的分区（或子分区）与非分区表交换：ALTER TABLE ... EXCHANGE PARTITION
     1. 简化分区锁增强性能
   - 优化器增强
     1. limit/MRR/ICP/新增连接算法BKA/子查询优化：包括物化和半连接优化等特性/面向开发者的优化器追踪特性
   - MySQL Performance Schema 增强
     1. Statements/execution stages - 找出消耗资源热点SQL
     1. Table and Index I/O ： 那些表和索引引起负载过高 ？
     1. Table Locks ： 那些表引起竞争？
     1. Users/Hosts/Accounts 级别资源消耗 ：找出消耗资源最多的Users/Hosts/Accounts
     1. Network I/O ： 网络还是应用程序？ 会话闲置多久？
     1. 通过 thread, user, host, account, object聚合总结
1. 5.7
   - 查询json数据：json_column->"$.id"，和json_extract，是两种使用方式。->>表示去掉转义符
    ```sql
    SELECT
        json_extract (
            json_data,
            '$.content.answer[*].group[*].value'
        )
    FROM
        entity_question
    WHERE
        JSON_SEARCH (
            json_data,
            'all',
            '行到水穷处',
            NULL,
            '$.content.answer[*].group[*].value'
        )  IS NOT NULL;
    SELECT
        json_extract (
            json_data,
            '$.content.answer'
        )
    FROM
        entity_question
    WHERE
    	JSON_EXTRACT(json_data, "$.content.answer[*].group[*].type") != 'text';
    ```