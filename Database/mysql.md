### 路线：基础知识（操作、配置、历史）——优化方式、方法、注意点——各种技术方案——原理
### 提升：集群部署--中间件实施--备份设计监控--日志处理--授权
### 基础
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
   - 时间
     1. DATETIME：YYYY-MM-DD HH:MM:SS (1000-01-01 00:00:00/9999-12-31 23:59:59)，日期和时间
     1. TIMESTAMP：YYYY-MM-DD HH:MM:SS (1970-01-01 00:00:00/2038 格林尼治时间/北京时间)，日期和时间/时间戳，只是时间戳表示的范围，可自动更新
     1. DATE：YYYY-MM-DD (1000-01-01/9999-12-31)，日期
     1. TIME：HH:MM:SS ('-838:59:59'/'838:59:59')，时间或持续时间
     1. YEAR：YYYY (1901/2155)，年份
   - 其他
     1. enum：枚举，0~65535，如`enum('','')`
     1. set：集合，0~64，可以存一个集合，如`set('','')`
     1. json：5.7.8支持，与longtext大小差不多，不能有默认值，不能直接被编为索引，可以在虚拟列上创建
1. sql语句
   - 分类
     1. DCL：对数据库的操作：mysql、use、set、show
     1. DDL：对表的操作：show、create、drop、alter
     1. DML：对数据操作：select、insert、delete、update、replace
   - 基础
    ```sql
    mysql -h地址(不写-h默认localhost) -u -p                   # 连接
    quit/exit                                               # 断开
    status                                                  # 查看信息：版本、账号等
    show status                                             # 服务器状态
    select version()/database()/user();                   
    ```
   - DCL
    ```sql
    use database;
    set baseName utf8/gbk;                                                                  # 设置库编码
    create database xxx default character set = utf8mb4 COLLATE utf8mb4_general_ci;         # 创建库
    ```
   - DDL
    ```sql
    ## show
    show databases/tables;                                  # 查看所有数据库/表
    show columns/index from tabel;                          # 查看列/索引信息
    show table status from baseName like \G;                # 表信息
    desc tables;                                            # 查看表结构
    show create database/table baseName/tableName;          # 输出标准sql
    ## create
    create table table_name(                                                                # 创建表
        id int unsigned primary key auto_increment,
        username char(25) unique not null default '',
    )ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='';
    create unique/fulltext/spatial index indexName using btree/hash/rtree                   # 创建索引
    create table tableName1 like tableName;                                                 # 复制表结构
    insert into tableName1 select * from tableName;                                         # 复制表数据
    create table tableName1 select * from tableName;                                        # 复制表结构和数据
    ## alter
    alter table tableName rename newName;                                                   # rename，修改表名
    alter table tableName add columnName int unsigned not null default 0;                   # add，追加字段
    alter table tableName add primary key(sid);                                             # add，增加主键
    alter table tableName add index/unique/key/fulltext/spatial indexName(xx);              # add，增加索引
    alter table tableName change new_column column char(20) not null default '';            # change，列名，类型
    alter table tableName modify name char(20) first/after sex;                             # modify，只修改类型，显示顺序调整
    alter table tableName drop columnName;                                                  # drop，删除字段
    alter table tableName drop primary key;                                                 # drop，删除主键，先删除自增，再删字段
    alter table tableName drop index indexName;                                             # drop，删除索引
    alter table tableName engine=mysiam                                                     # 修改引擎
    ## drop
    drop database/table if exists baseName/tableName;                                       # 删除库/表
    drop index indexName on table                                                           # 删除索引，各种类型的索引都用这个删除
    ## lock
    lock tables tableName write/read local;                                                 # 锁表的读/写，local允许其他用户表尾添加行
    unlock tables;
    ```
   - DML
    ```sql
    ## 查询
    select */,/count()/min()/max()/sum()/avg()/median()/rank()/first()/last()/distinct()/concat(,)
    from table、from table1 as x,table2 as x、from (select * from table2) derivedName        # 选择表
    inner/left/right join table2 as x2 on x1.x=x2.x                                         # 连表查询
    union select * from table2                                                              # 组合查询
    select xx from table as x1 join table as x2 on x1.xx=x2.xx                              # 自关联        
    where x.x/=/</>/<=/!=/<>/is null/is not null/in(,,)/not in()/like/REGEXP '^$'           # 条件
    and/or/between xx and xx                                                                # 逻辑
    XX=exists/not exists(select x from table2 where xx=xx);                                 # 子查询，返回布尔值
    group by having condition1 and condition2                                               # 分类筛选
    order by xx1 desc/asc/rand() xx2 asc                                                    # 排序，多个排序规则
    limit x/limit x offset x/limit x.x                                                      # 限制条数/从x行开始的x行
    ## 插入数据
    insert into table set XX=xx/(,,) values (,);                                            # 插入数据
    replace into table (,,) values (,,);                                                    # 插入或更新，命中主键修改，未命中添加
    ## 更新数据
    updata table set XX1=xx1, XX2=xx;                                                       # 更新所有数据
    update t1,t2 set t1.xx=xx,t2.xx=xx                                                      # 多表更新
    update t1 join t2 on t1.xx=t2.xx set t1.xx=xx
    ## 删除数据
    delete from table where XX=xx;                                                    # 删除
    delete from table;                                                                # 删除所有数据
    truncate table;                                                                   # 数据清空，主键归0
    delete t1,t2 from t1 join t2 on t1.xx=t2.xx;                                      # 多表数据删除
    ```
1. 变量：基于会话，用户变量不区分大小写。定义 `set @a:=/=1`
1. 函数
   - 数学：format/round/pow/abs/sin/cos/tan/bit_and
   - 字符串：char/concat/length  
   - cast：类型转换，如`cast(1 as signed)`
   - password
   - UNIX_TIMESTAMP：时间转换为时间戳
   - match：全文搜索
   - uuid()：aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
   - distinct去重可能要全表扫描，concat字符串连接
   - 修饰符
     1. unsigned
     1. zerofill
     1. variables
1. sql
   - 分组
     1. group by：用列的值进行分组/计算，必须在where之后order by之前，select的字段除了被group的其他要么被统计，要么没有
     1. having：筛选成组后的数据，作用于组，如`having sum(age) > 10`
   - 连表
     1. inner join：无关系不显示，同join
     1. left join：获取左表所有记录，即使右表没有
     1. right join：反过来
     1. cross join：在mysql中和inner join相同，标准sql中不同，产生笛卡尔集，即M*N，
   - 组合
     1. union：自动处理重合，即去掉重复的数据，以第一个取出的为准
     1. union all：不处理重合，相反
   - replace：是标准sql的mysql扩展，使用primary key/unique key确定是否插入新行
     1. 注意：会抹掉其他未指定数据，应作为插入使用，而不是更新
     1. 原理：将数据插入，成功则结束；否则引发重复键错误，先删除原有记录，然后更新
1. 表
   - 结构
     1. primary key：主键列，作为一行的唯一标识符用来定位，不能重复不能为空，特殊的唯一索引，可有复合主键 `primary key(id,name)`
     1. auto_increment：自增，必须是索引列(index/primary key)，只能有一个自增列，可以设置起始值和步长
     1. unique/not null/default
     1. foreign key：外键列，保证表之间数据完整性和准确性，体现表之间关系，可进行级联操作，由于对业务的强一致性要求，现在由程序控制，不使用外键关联
        - 基本形式：`constraint foreignKeyName foreign key(selfId) references foreignTable(foreignTableId)`
        - 级联限制：`constraint foreignKeyName foreign key(selfId) references foreignTable(foreignTableId) on delete/update cascade;`，删除被连接数据自己也被删除，连带删除
   - 分类
     1. 临时表：只有当前连接可见，关闭连接自动删除，如`create temporary table tableName ();`，show tables看不到该表
     1. 派生表：是select返回的虚拟表，即from使用的独立子查询，可以和子查询互换使用。如`from(select * from table2)derivedTableName`
     1. 公共表表达式：CTE，是一个命名的临时结果集，仅在单个SQL语句的执行范围内存在，比派生表更易读，性能更高
   - 表间关系：一对一、一对多、多对多
   - 存储引擎
     1. MyISAM：5.5之前的默认引擎，用于只读提高性能、不支持事务、不支持外键，最大256TB，可以压缩为只读表，支持全文索引
     1. InnoDB：支持MVCC，多种行锁机制组合，一致性读或者读快照就是读取当前事务开始之前的数据快照，在这个事务开始之后的更新不会被读到。InnoDB行锁是通过给索引上的索引项加锁来实现的
        - 事务
        - 行级锁
        - 实现sql标准的4种隔离级别
        - 插入缓存(insert buffer)
        - 二次写(double write)
        - 自适应hash索引(adaptive hash index)
        - 预读(read ahead)
        - 索引是其表空间的组成部分
     1. merge：将具有相似结构的多个MyISAM表组合到一个表中的虚拟表
     1. memory；内存表存储在内存中，并使用散列索引，使其比MyISAM表格快，服务器停止数据丢失
1. 数据库组成
   - mysql：用户/权限相关，user表存储用户和权限
   - information_schema：自身架构相关
   - performance_schema
   - sys
1. 视图
   - 理解：即虚拟表，可以对视图进行操作，作用有简化查询，限制用户访问和权限。不支持物理视图，可以进行查询和更改，表改变不会联动视图改变    
   - 创建：`create view viewName as select * from table`，分辨视图 `show full tables;`
1. 触发器
   - 理解：triggers，自动执行响应事件的存储程序
   - 分类：before/after insert/update/delete
   - 实例
    ```sql
    create trigger triName
        before update on table
        for each row
    begin
        # some sql
    end;
    ```
1. 预解析
   - 理解：使用占位符预先准备查询语句，不用解析语句，查询速度更快，防止注入。步骤有：prepare、execute、deallocate prepare(发布)
   - 实例
    ```sql
    PREPARE stmt1 FROM 'select ... ?';          # 准备占位符

    SET @a = '1';
    EXECUTE stmt1 USING @a;

    DEALLOCATE PREPARE stmt1;
    ```
1. 存储过程
   - 理解：在mysql中存储了sql语句，预先缓存编译结果、执行速度快，传输数据少。耗内存，不灵活
   - 实例
    ```sql
    CREATE PROCEDURE procedureName()
    BEGIN
        SELECT * FROM user;
    END
    ```
1. 注释 ：--、#、/**/=
### 应用
1. 索引
   - 理解：为了加快查询速度，对数据列进行排序的一种结构，包含所有记录的引用指针，查询数据时先检查索引是否存在，用于精确到对应行，
   - 特点
     1. 选择性原则：指不重复的索引值和总数的比值，范围0~1，索引的选择性越高查询效率越高，唯一索引的选择性是1性能是最好的
     1. 最左前缀原则：组合索引只会从左边开始按照索引搜索，如果检索条件没有最左的，那么就不会使用到索引，因为不知道去哪儿开始找。所以不用给联合索引最左边的列单独建立索引
     1. 查询只能使用一个索引，会选择限制最严格的索引：where用了order没法用，只有order的字段在where中才会用
     1. key和index：相同，mysql为了兼容其他系统，都是索引，key多了一层约束层含义
     1. 数据库会同时维护索引表，太多索引影响更新/插入
   - 分类
     1. key/index：普通索引，只用于加快查询速度
     1. primary key：主键索引，不能重复，不为null
     1. unique/unique key：唯一索引，可组合多个列。除了BDB外，都允许重复NULL
     1. column(n)：前缀索引，鉴于选择性原则，根据内容制定合适的前缀长度，以达到最佳查询效果。无法做order、group、覆盖扫描
     1. fulltext：全文索引，用于文本搜索，仅MySIAM支持，仅用于char/varchar/text
     1. spatial：空间列，值不为null
     1. foreign key：外键索引
   - 建立原则
     1. 数据量少的、数据经常改变的不能建立
     1. 数据差别不大的不能建立：区分度公式COUNT(DISTINCT col)/COUNT(*)，表示字段不重复比率
     1. 有null的列不会包含在索引中
     1. 尽量建立适当短索引、前缀索引：选择性原则，提高查询速度，节省空间和io。通过select left(column,n)不断增加n查看重复行的减少，以达到最佳选择
     1. 尽可能扩展和整合索引，而不是增加索引：如联合索引
     1. 索引越多，占用空间越大，新增修改越慢
   - 使用原则
     1. 不在列上运算：因为每个行要运算所以索引失效
     1. 使用索引列排序：唯一索引原则
     1. like：最左原则，%aa%不使用索引，而aa%使用
     1. !=、not in、<>：不使用索引，范围查询可能用到索引如>、in等
     1. or：前后条件都有索引，整个语句才使用索引，否则推荐用union
1. 事务
   - 理解：保证所有操作全部执行，用于数据量大、复杂的操作
   - 特性：ACID
     1. 原子性：一个事务是一个整体，要么全部成功，要么全部失败
     1. 稳定性：有非法数据(外键约束等)，事务撤回
     1. 隔离性：在一个客户端执行事务未完成，所修改的数据对其他客户端是不可见的，是原来的数据
     1. 可靠性
   - 使用
    ```sql
    set autocommit=0/1;                 # 禁止/开启自动提交
    set transaction;                    # 设置隔离级别
    
    begin;/start transaction;
    commit;
    rollback;

    savepoint xx;                       # 创建标记点
    release savepoint xx;               # 删除标记点
    rollback to xx;                     # 回滚到标记点
    ```
   - 并发事务
     1. 产生的问题
        - 更新覆盖丢失
        - 脏读
        - 不可重复读
        - 幻读
     1. 事务隔离：并发本身和数据冲突的"串行化"是矛盾的，用隔离级别平衡隔离和并发的矛盾
        - 方法
          1. 读取数据前加锁
          1. 使用一致性数据快照：MVCC，Multi-Version Concurrency Control 数据多版本并发控制
        - 隔离级别：由低到高
          1. Read Uncommitted：未提交读，会导致数据完整性的严重问题，4种问题都存在
          1. Read committed：已提交读
          1. Repeatable Read：可重复读，默认，一个事务开始后其他session对数据库的修改在本事务中不可见，直到本事务commit或rollback
          1. Serializable：可序列化，性能问题并增加死锁的机率
1. 分布式事务
1. 锁
   - 分类
     1. 表锁：MyISAM，开销小，加锁快，无死锁，冲突高，并发低。可以并发读，写的时候读写都加锁等待，系统自动加锁。因为一次获取所有锁，不会死锁。必须一次锁定所有用到的表，别名也要指定，否则出错
     1. 行锁：InnoDB，开销大，加锁慢，有死锁，冲突低，并发高。基于索引，如果改的字段是索引或者自增字段，会锁住整个表
     1. 间隙锁：范围查找自动锁定范围内所有行，防止幻读
     1. 页锁：BDB被InnoDB取代，介于表和行之间，会死锁
   - 表锁：lock table给InnoDB加表级锁
   - 行锁
     1. 共享锁：`lock in share mode;`，可读不可拿到写锁
     1. 排他锁：`for update`，读写锁都拿不到，update/delete/insert自动加，select任何锁不加
   - 查看
     1. 表锁争用情况：`show status like 'table%';`
     1. 行锁争用情况：`show status like 'innodb_row_lock%';`，使用监视器`CREATE TABLE innodb_monitor(a INT) ENGINE=INNODB;Show innodb status\G;DROP TABLE innodb_monitor;`
   - 死锁：发生死锁后InnoDB一般都能自动检测到，并使一个事务释放锁并回退，涉及表锁稍微不行
   - 悲观锁
     1. 理解：Pessimistic Locking，读取的时候为后面的更新加锁，之后再来的读写都会等待，属于数据库锁
     1. 意义：数据修改排他性，高并发下，数据可以正确写入。但带来数据库性能的大量开销，影响并发访问性，特别是长事务
   - 乐观锁
     1. 理解：Optimistic Locking，乐观并发控制。基于数据版本记录机制实现。如updatetime/version等版本标识字段，根据version更新数据，一旦发现其他并发操作更新，会回退，并从新执行自己
     1. 优缺点：程序实现，不会存在死锁。但是阻止不了程序之外的数据库操作
     1. 流程
        - 读数据时，将version/时间戳一同读出
        - 更新数据时，对比数据局版本
        - 版本正确，更新数据，version加1
        - 版本错误，认为是过期数据，采取补救措施
1. sql注入
   - 类型：like注入，使用php的addcslashes
   - 安全措施
     1. 不要相信用户输入
     1. 不要动态拼接sql，使用参数化sql或存储过程
     1. 异常信息尽量少给出提示
   - 工具
     1. jsky：漏洞扫描工具
### 性能和调优
1. 设计和使用
   - 数据类
     1. 一定有主键，最好是自增，否则多次读写后更离散，更多随机io
     1. 数据长度越短越好，更少存储/内存空间
     1. int比string快，长数字使用string
     1. 增加create_time/update_time字段，用于数据归档/自定义差异备份
   - sql
     1. 无select *，sql中无计算，where中无函数，提高索引利用覆盖率
     1. 所有where条件加引号，防止类型隐式转换
     1. 尽量inner join让优化器自动选择驱动表
     1. 关键业务上线前explain确认执行计划
     1. 存了数字的字符串加上引号     
1. explain
   - 理解：sql语句分析，将过程和索引等信息列出来
   - 使用解析
     1. select_type：查询类型，simple、primary、union、subquery
     1. type：在表中找到所需行的方式，即访问类型，效率由高到低system、const、eq_ref、ref、range、index、All
        - system/const：最多一个匹配行，主键或者唯一索引，性能最优
        - eq_ref：多表连接中使用唯一索引
        - ref：非唯一索引/唯一索引的前缀扫描
        - range：索引范围扫描
        - index：索引全扫描
        - all：全表扫描
     1. possible_keys：可用的索引
     1. key：实际使用索引
     1. key_len：索引使用字节数，越小越好越快
     1. ref：另外表的数据列名字
     1. row：预计读出的数据行数，里面所有数字乘积代表需要处理的组合数
     1. extra：问题解决提示信息
1. 慢查询：记录超过一定时间的查询语句
    ```
    slow_query_log = ON
    slow_query_log_file = /usr/local/mysql/data/slow.log
    long_query_time = 1
    ```
1. 性能测试原则：数据多才有参考价值，数据总量超过内存总量，如几百条数据第一条命令下去就全部加载到内存了，没有参考意义
1. 硬件：主频高处理快高吞吐低时延，L1/2/3的cache大速度快，内存大磁盘读写少TPS高，固态快机械配阵列卡，网卡好低时延，文件系统用xfs/ext4不用ext3
### 运维
1. 安装
   - 安装：`yum -y install mysql-server`
   - 设置字符集：`vim /etc/my.cnf` ([mysqld]下添加)
     1. `character-set-server=utf8`
     1. `default-character-set=utf8`
1. 配置
   - 查看配置：`show variables like 'slow_query%';`
   - 变量配置：`set global slow_query_log='ON';`
   - 配置文件配置：my.cnf，`slow_query_log = ON`
1. 使用
   - 启动：`mysqld_safe &`
   - 关闭：`mysqladmin -u -p shutdown`
   - 重启：`service mysqld restart`
   - 查看：`ps -ef | grep mysqld`
1. 数据库操作
   - 备份库
   - 恢复库
1. 数据库中间件，故障切换
1. mycat：开源分布式数据库中间件
1. 主从，amoeba
1. 读写分离
1. 分表
1. 监控系统
1. 物理备份、逻辑备份、binlog增量恢复
1. 数据操作
   - 导出
    ```sql
    mysqldump -u -p [databaseName or tableName] > data.sql            # -d 只导出结构，-t 只导出数据
    select * into outfile 'xx.txt' fields terminated by ',' optionally enclosed by '"' lines terminated by '\n' from table;
    ```
   - 导入
    ```sql
    mysqlimport -u -p --local databaseName dump.sql
    source xx.sql
    mysql -u -p [databaseName] < data.sql
    load data local infile 'xx.txt' into table tableName;
    ```
1. 用户和权限管理
   - user
    ```sql
    select * from mysql.user\G;                                             # 查看用户
    create user userName@'::1' identified by 'password';                    # 创建用户 
    drop user username;                                                     # 删除用户
    rename user oldName to newName;                                         # 重命名
    update mysql.user set password=password('') where user='';              # 修改用户密码
    set password for userName@'%' = password('');                           # 修改用户密码
    ```
   - 权限
     1. 指令
        ```sql
        show grants (for userName);                                         # 查看用户权限
        grant select,update on *.* to userName@'%';                         # 赋予查询更新权限
        grant all privileges on *.* to userName@"";                         # 所有权限，不包括管理权限
        grant all privileges on *.* to userName@'' WITH GRANT OPTION;       # 管理权限，也就是管理员
        revoke select on *.* from userName;                                 # 回收权限
        revoke grant option on *.* from userName;                           # 回收管理权限，需要显示指定
        FLUSH PRIVILEGES;                                                   # 刷新权限，更改了都要刷新
        ```
     1. user表中host列的值的意义
        - %：匹配所有主机
        - localhost：localhost不会被解析成IP地址，直接通过UNIXsocket连接
        - 127.0.0.1：会通过TCP/IP协议连接，并且只能在本机访问；
        - ::1：兼容支持ipv6的，表示同ipv4的127.0.0.1
     1. 权限意义
        - usage：无权限
        - ALL：所有，同ALL PRIVILEGES，除grant外
        - INDEX：创建/删除索引
        - PROCESS：查看/杀死线程
        - RELOAD：重载授权表、清空日志/主机缓存/表缓存
        - SHUTDOWN：关闭服务器
### WIKI
1. 概念
   - 数据库：文件中读写数据不方便、速度慢，按照数据结构来组织、存储和管理数据的仓库，提供API进行数据操作
   - 关系型数据库：建立在关系模型基础上，由行、表、库等组成
   - MySQL：瑞典的属于Oracle公司的开源数据库，使用标准sql语句，支持多客户端语言如c、php等，32位最大表文件4GB，64的8TB
1. 聚集索引/非聚集索引
   - 聚簇索引：按数据存放的物理位置为顺序，提高多行的检索速度
   - 非聚簇索引：单行检索快
1. gist
   - 查询这个数据是否存在，存在则存到另一张表里：`create table temp as select * from admin a where exists (select uid from user u where a.userName = u.account);`
   - 查询两张表中是否有相同数据：`select * from admin wherer uid IN(select uid from temp);`
   - 求差集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx WHERE B.id IS NULL union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx WHERE A.id IS NULL;`
   - 求全集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx;`
   - 原所有id增加5万，必须倒叙操作：`update user SET uid=uid+50000 order by uid desc;`
   - 插入不重复数据行，mysql特有不是标准sql语法：`INSERT token(udid) values ('{$udid}') ON DUPLICATE KEY UPDATE activetime ='{$time}'`
1. 知识点
   - 严格模式
   - NULL与任何其它值的比较永远返回false，即使NULL=NULL也返回false
1. 5.6新特性
   - server参数默认值改变
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
1. 5.7新特性
```sql
# 查询json数据：json_column->"$.id"，和json_extract，是两种使用方式。->>表示去掉转义符
SELECT json_extract (json_data, '$.content.answer[*].group[*].value') FROM entity_question WHERE JSON_SEARCH (json_data,'all','行到水穷处',NULL,'$.content.answer[*].group[*].value') IS NOT NULL;
SELECT json_extract (json_data,'$.content.answer') FROM entity_question WHERE JSON_EXTRACT(json_data, "$.content.answer[*].group[*].type") != 'text';
```
### 原理
1. 语法分析器：优化查询，会帮你优化成索引可以识别的模式
1. 索引
   - 分类
     1. Hash：由引擎根据情况自动创建，不能人为干涉。比较hash计算后的hash值会变得没有规律，只能等值过滤。只需一次定位检索效率很高，不像btree需要多次io跑节点
        - 不能范围查找，只能=/<>/in
        - 不支持索引的排序操作
        - 不能使用前缀索引查询
        - 任何时候不能避免全表查询，因为重复hash值的存在，需要查表获得实际数据
     1. B+Tree：B被认为是Balance的缩写，平衡算法
   - 引擎支持的索引结构
     1. InnoDB/memory/heap：b+tree、hash
     1. MySIAM：b+tree、rtree(空间列是rtree)
   - 不同引擎的区别
     1. Innodb中，Leaf Nodes存放其他字段实际数据，还包含主键值，Secondary Index和普通b-tree相同，所以主键查询非常快，Secondary需要先找到Leaf再找主键值
1. B+Tree
   - 特点
     1. 二分查找一级级向叶子节点，io查找数据库和指针，内存计算向哪个方向
     1. 三层的B+树可以表示上百万的数据，如果上百万的数据查询只需要三次I/O，性能提高将会是巨大的。B+树就是一种索引数据结构，如果没有这样的索引，每个数据项发生一次I/O，那么成本将会大大提升
     1. I/O的次数取决于B+树的高度H，假设当前数据表的数据为N，每个磁盘块的数据项的数量是M，则有：H=log(M+1)N，当数据量N一定的情况下，M越大，H越小；而M=磁盘块大小/数据项大小，磁盘块大小也就是一个数据页的大小，是固定的，如果数据项占的空间越小，数据项的数量越多，树的高度也就越低。这也就是为什么每个数据项，即索引字段要尽量的小，比如int占4个字节，要比bigint的8个字节小一半。这也是为什么B+树要求把真实数据放在叶子节点内而不是内层节点内，一旦放到内层节点内，磁盘块的数据项会大幅度的下降，导致树层级的增高。当数据项为1时，B+树会退化成线性表
     1. B+树的数据项是复合性数据结构，比如（name，age，gender）的时候，B+树是按照从左到右的顺序来建立搜索树的，比如当（小张，22，女）这样的数据来检索的时候，B+树会优先比较name来确定下一步的搜索方向，如果name相同再依次比较age和gender，最后得到检索的数据。但是，当（22，女）这样没有name的数据来的时候，B+树就不知道下一步该查哪个节点，因为建立搜索树的时候，name就是第一个比较因子，必须根据name来搜索才知道下一步去哪里查询。比如，当（小张，男）这样的数据来检索时，B+树就可以根据name来指定搜索方向，但下一字段age缺失，所以只能把名字是“小张”的所有数据都找到，然后再匹配性别是“男”的数据了。这个是非常重要的一条性质，即索引的最左匹配特性
   - 分类
     1. btree：二叉搜索树，每个结点只存储一个关键字，等于则命中，小于走左结点，大于走右结点
     1. b-tree：多路搜索树，每个结点存储M/2到M个关键字，非叶子结点存储指向关键字范围的子结点；所有关键字在整颗树中出现，且只出现一次，非叶子结点可以命中
     1. b+tree：在B-树基础上，为叶子结点增加链表指针，所有关键字都在叶子结点中出现，非叶子结点作为叶子结点的索引；B+树总是到叶子结点才命中
     1. b*tree：在B+树基础上，为非叶子结点也增加链表指针，将结点的最低利用率从1/2提高到2/3
1. 磁盘
   - 数据数据交换：总用时9ms，500-MIPS的机器每秒可以执行5亿条指令，执行一次I/O的时间可以执行40万条指令。数据库动辄百万级甚至千万级的数据，每次9ms的时间，显然是一个灾难
     1. 寻道时间：5ms
     1. 旋转延迟：7200转，1/120/2=4.17ms
     1. 传输时间：0.nms
   - 磁盘访问的成本大概是内存访问成本的十万倍左右
   - 内存读取数据的局部预读性，每一次I/O读取的数据我们称之为一页（Page）。具体一页的数据有多大，这个跟操作系统有关，一般为4K或8K
