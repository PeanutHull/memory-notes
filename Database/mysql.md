### 基础
1. 基础
   - 注释 ：--、#、/**/=
   - 不区分大小写
   - 符号
     1. %百分号通配符: 表示任何字符出现任意次数 (可以是0次).
     1. _下划线通配符:表示只能匹配单个字符,不能多也不能少,就是一个字符.
1. 数据类型
   - 数字
     1. 整数
        - 分类：m仅用于显示不影响存储范围，如int(3)、tinyint(4)，显示为001，和INTEGER相同
          1. tinyint：-128~127
          1. smallint：前后3万2
          1. mediumint：前后8.3千万
          1. int：前后21亿
          1. bigint：前后9亿亿亿，19位，2E64
        - 属性
          1. unsigned
     1. 实数
        - float：前后38次方，数值越大，越不准确
        - double：前后308次方，数值越大，越不准确
        - decimal：精确小数值，m数字总个数，d小数点后个数，m最大65d最大30，内部按字符串存储
     1. 位
        - bit：默认1，长度1~64
   - 字符串
     1. char：定长字符串，0~255字节，m最大保存长度，数据小于m空格填充，速度更快甚至快过varchar50%，用于很短字符串或长度接近的，经常变更的，char不容易产生碎片
     1. varchar：变长字符串，根据字符串确认最大长度，如utf8最多2万，m最大保存长度，超出截断，使用1或2个字节记录字符串长度
     1. text：大字符串，0~65535字节，2E16，mediumtext：1600万，2E24，longtext：42亿长度或4GB字符，tinytext
     1. blob：二进制形式的长文本数据，0~65535字节，tiny/medium/longblob，可变长度，避免使用，会用到临时表，性能开销
     1. binary：二进制形式的字符串，即包含字节字符串，不包含字符字符串，没有字符集，避免使用，会用到临时表，性能开销
   - 日期时间
     1. DATETIME：YYYY-MM-DD HH:MM:SS (1000-01-01 00:00:00/9999-12-31 23:59:59)，日期和时间
     1. TIMESTAMP：YYYY-MM-DD HH:MM:SS (1970-01-01 00:00:00/2038 格林尼治时间/北京时间)，日期和时间/时间戳，只是时间戳表示的范围，可自动更新
     1. DATE：YYYY-MM-DD (1000-01-01/9999-12-31)，日期
     1. TIME：HH:MM:SS ('-838:59:59'/'838:59:59')，时间或持续时间
     1. YEAR：YYYY (1901/2155)，年份
   - 其他
     1. enum：枚举，0~65535，如`enum('','')`
     1. set：集合，0~64，可以存一个集合，如`set('','')`
     1. json：5.7.8支持，与longtext大小差不多，不能有默认值，不能直接被编为索引，可以在虚拟列上创建
1. 变量
   - 分类
     1. 局部变量：必须在存储过程中并且在最开始写
        ```sql
        BEGIN
            # 定义
            declare xx int(4);

            # 直接赋值
            set xx = 2;

            #使用查询结果赋值
            select id into xx from xxx where xxxx = 'xxxx';
        END
        ```
     1. 用户变量：作用域是当前连接，声明、赋值、查询都用@符号
        ```sql
        # 声明、赋值
        set @xx = 2;
        set @xx := 2;
        select id into @xx from xxx where xxxx = 'xxxx';
        ```
     1. 会话变量：作用域是当前连接
        ```sql
        # 显示所有的会话变量
        show session variables;

        # 查询
        show variables like '%auto_increment_increment%';   #查询变量值的通用方式
        select @@auto_increment_increment;                  #使用@@方式查询
        select @@session.auto_increment_increment;          
        select @@local.auto_increment_increment;            

        # 设置
        set auto_increment_increment=1;                     #直接设置
        set session auto_increment_increment=1;             #使用session关键字，设置选定的范围
        set @@session.auto_increment_increment=1;           
        set @@local.auto_increment_increment=1;             
        ```
     1. 全局变量：作用域是server整个生命周期
        ```sql
        # 显示所有的全局变量
        show global variables;

        # 查询
        show variables like '%sql_warnings%';               #查询变量值的通用方式
        select @@global.sql_warnings;                       

        # 设置
        set sql_warnings = FALSE;                           #直接设置
        set global sql_warnings = FALSE;                    #使用global关键字，设置选定的范围，最好加上global
        set @@global.sql_warnings = OFF;                    
        ```
1. 函数
   - 数学：format/round/pow/abs/sin/cos/tan/bit_and
   - 字符串：char/concat/length  
   - cast：类型转换，如`cast(1 as signed)`
   - Find_IN_SET：查找通过,分隔的某一个数据
   - password
   - UNIX_TIMESTAMP：时间转换为时间戳
   - match：全文搜索
   - uuid()：aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
   - distinct去重可能要全表扫描，concat字符串连接
   - 修饰符
     1. unsigned
     1. zerofill
     1. variables
### 组成
1. 库
   - mysql
     1. 认识：系统库，服务器运行相关信息
     1. 分类
        - slave相关
          1. ndb_binlog_index
          1. slave_master_info/slave_relay_log_info/slave_worker_info
        - 日志相关
          1. general_log
          1. slow_log
        - 权限相关
          1. user
          1. db
          1. host
          1. tables_priv/columns_priv/procs_priv/proxies_priv：3为存储过程和函数权限
        - 优化器统计相关：innodb_index_stats、innodb_table_stats
        - 时区相关：time_zone
        - 帮助相关表：help_category等
        - 其他：事件 event、用户函数 func、插件表 plugin、存储过程和函数 proc、防火墙等
   - information_schema
     1. 认识：提供元数据相关信息，提供服务器、库、表相关信息。一些是只读的，实际是视图不是表
     1. 分类
        - 系统组成相关
          1. schemata
          1. tables
          1. columns
          1. views
          1. triggers
          1. engines
          1. plugins
        - innodb相关
        - xtradb
        - 字符集相关
   - performance_schema
     1. 认识：提供服务器性能表现，可以监视server的执行
     1. 分类
        - 全局状态
          1. global_status 
          1. global_variables
          1. setup_instruments：配置监控选项
          1. status_by_account/status_by_thread/status_by_host
          1. threads
        - 连接、登录相关
          1. accounts：连接用户列表
          1. users
          1. hosts/host_cache
          1. session_status/session_connect_attrs/session_variables
        - 事件相关
          1. events_stages_current
          1. events_statements_current
          1. events_transactions_current
          1. events_waits_current
        - socket相关
          1. socket_instances
          1. socket_summary_by_event_name
        - 内存相关
          1. memory_summary_by_account_by_event_name
          1. memory_summary_by_user_by_event_name
          1. memory_summary_by_host_by_event_name
        - 表io相关
          1. table_handles
          1. table_io_waits_summary_by_index_usage
        - 文件相关
          1. file_instances
          1. file_summary_by_event_name
          1. file_summary_by_instance
        - 复制相关
          1. replication_applier_status
          1. replication_connection_status
        - 其他
          1. mutex_instances
          1. metadata_locks
          1. rwlock_instances
   - sys
     1. 认识：数据来自performance，降低复杂度便于查看，5.7默认安装。字母开头给人看的，x$开头用于工具采集。可以统计哪个表/文件/账号/连接的次数最多/延迟多/内存占用多/线程多少/sql最多
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
1. sql
   - 分类
     1. DCL：对数据库的操作：mysql、use、set、show
     1. DDL：对表的操作：show、create、drop、alter
     1. DML：对数据操作：select、insert、delete、update、replace
   - 基础
    ```sql
    mysql -h地址(不写-h默认localhost) -u -p -P 3306           # 连接
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
    desc/describe tables;                                   # 查看表结构
    show create database/table baseName/tableName;          # 输出标准sql
    ## create
    create table table_name(                                                                # 创建表
        id int unsigned primary key auto_increment,
        username char(25) unique not null default '',
    )ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='' CHECKSUM=1 DELAY_KEY_WRITE=1 ROW_FORMAT=DYNAMIC;
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
    lock tables tableName write/read local;                                                 # 表级锁，锁表的读/写，local允许其他用户表尾添加行
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
    limit x/limit x offset y/limit x.y                                                      # 限制条数/跳过x行的y行
    ## 插入数据
    insert into table(xx) set XX=xx/(,,) values (,) on duplicate key update;                # 插入数据，如果引发唯一或主键索引重复则更新
    replace into table (,,) values (,,);                                                    # 插入或更新，命中主键修改，未命中添加
    ## 更新数据
    update table set XX1=xx1, XX2=xx;                                                       # 更新所有数据
    update t1,t2 set t1.xx=xx,t2.xx=xx                                                      # 多表更新
    update t1 join t2 on t1.xx=t2.xx set t1.xx=xx
    ## 删除数据
    delete from table where XX=xx;                                                    # 删除
    delete from table;                                                                # 删除所有数据
    truncate table;                                                                   # 数据清空，主键归0
    delete t1,t2 from t1 join t2 on t1.xx=t2.xx;                                      # 多表数据删除
    ```
1. sql介绍
   - 关联查询
     1. inner join：无关系不显示，同join
     1. left join：获取左表所有记录，即使右表没有
     1. right join：反过来
     1. cross join：在mysql中和inner join相同，标准sql中不同，产生笛卡尔集，即M*N
   - 内连接关系形式
     1. 等值连接：on a.id = b.id
     1. 不等值连接：on a.id > b.id
     1. 自连接：on a1.id = a2.id
   - 组合查询
     1. union：自动处理重合，即去掉重复的数据，以第一个取出的为准
     1. union all：不处理重合，相反，更快
   - 嵌套查询：select * from (select ...);
   - 分页：limit 100 offset 517325，这个会查询51万的数据，只保留了你需要的100条，用id>n去实现索引
   - 分组
     1. group by：用列的值进行分组/计算，必须在where之后order by之前，select的字段除了被group的其他要么被统计，要么没有
     1. having：筛选成组后的数据，作用于组，如`having sum(age) > 10`
   - replace：是标准sql的mysql扩展，使用primary key/unique key确定是否插入新行
     1. 注意：会抹掉其他未指定数据，应作为插入使用，而不是更新
     1. 原理：将数据插入，成功则结束；否则引发重复键错误，先删除原有记录，然后更新
   - 数据转换
     1. 时间
        - 格式化时间查询：TIMESTAMP格式的，`DATE_FORMAT(xx,'%m-%d') >= '06-03'`
        - 时间戳
          1. 转为时间戳：`unix_timestamp('2018-01-15 09:45:16');`
          1. 转为时间：` from_unixtime(date, '%Y-%c-%d %h:%i:%s')`
   - checksum：在逻辑备份时候前后可以用于验证数据一致性，`checksum table xxx`
     1. 无关：是否有索引、字符集、引擎类型
     1. 有关：字段顺序
   - DELAY_KEY_WRITE
     1. 认识在表关闭之前，将对表的update操作只更新数据到磁盘，而不更新索引到磁盘，把对索引的更改记录在内存，在关闭表的时候一起更新索引到磁盘
        - 使索引更新更快
        - 重启或掉电会导致索引没更新，启动参数加上--myisam-recover
     1. 操作：`ALTER TABLE xxx DELAY_KEY_WRITE=1`
### 特性
1. 索引
   - 认识：为加快查询速度，对数据列进行排序的一种结构，包含所有记录的引用指针，查询时先查索引，引擎实现
     1. 加快查询速度，大大减少服务器的检索数据
     1. 避免排序和临时表，将随机io变顺序io
     1. 同时维护索引表，降低写入更新速度，占用磁盘
   - 使用场景
     1. 非常小的表：全表扫描效率更高
     1. 中大型：索引非常有效
     1. 特大型：索引代价增长，使用分区
   - 特性
     1. 选择性原则：不重复的索引值和总数的比值。范围0~1，选择性越高查询效率越高，提高查询速度，节省空间和io。唯一索引的选择性是1性能最好。区分度公式COUNT(DISTINCT col)/COUNT(*)
     1. 最左前缀原则：组合索引只会从左边开始按照索引搜索，如果检索条件没有最左的，那么就不会使用到索引，因为不知道去哪儿开始找
     1. 查询只能使用一个索引，会选择限制最严格的那个索引：where用了order没法用，只有order的字段在where中才会用
     1. 有null的列不会包含在索引中
   - 特点
     1. 表只有一个主键索引，可有多个唯一索引
     1. key和index都是索引，为兼容其他系统，key多了一层约束层含义
     1. hash索引，重复数据多了性能下降，hash碰撞
     1. 使用了索引：意思是使用索引的快速搜索功能，有效的减少了扫描行数。对应的有全索引扫描，是不够快的
   - 分类
    ```
    key/index               # 普通索引
    key(,)                  # 组合索引
    column(n)               # 前缀索引，鉴于选择性原则，通过select left(column,n)不断增加n查看重复行的减少制定合适的前缀长度以达到最佳查询效果。无法order、group、覆盖扫描

    unique key              # 唯一索引，可组合多个列。具有唯一性约束，除了BDB外允许重复NULL
    primary key             # 主键索引，特殊的唯一索引，不能重复，不为null

    foreign key             # 外键索引，保证数据一致性、完整性，实现级联操作
    fulltext                # 全文索引，用于文本搜索，仅MySIAM，仅用于char/varchar/text，仅英文
    spatial                 # 空间列，值不为null
    ```
1. 事务
   - 理解：保证一致性，所有操作全部执行
     1. 服务层不管理，由引擎实现
     1. 不支持嵌套事务：再开启一个事务会隐式提交上一个事务
     1. 一个事务中使用多引擎不靠谱
   - 使用
    ```sql
    set autocommit=0/1;                 # 禁止/开启自动提交
    set transaction;                    # 设置隔离级别
    
    begin;/start transaction;           # 显式开启事务，自动事务前禁止自动提交，事务后关闭
    commit;
    rollback;

    # 保存点
    savepoint xx;                       # 创建标记点
    release savepoint xx;               # 删除标记点
    rollback to xx;                     # 回滚到标记点，用rollback才会结束事务

    # 分布式事务
    XA {START|BEGIN} xid [JOIN|RESUME]
    ```
   - 并发事务
     1. 问题
        - 更新覆盖丢失
        - 脏读：A看到了B没commit的数据，A读取的数据是错误的
        - 不可重复读：本事务中可以看到其他事务提交的数据
        - 幻读：A没commit查范围数据时，会受到B新插入数据的影响，前后不一样
     1. 事务隔离：并发本身和数据冲突的"串行化"是矛盾的，用隔离级别平衡隔离和并发的矛盾
        - 方法
          1. 读取数据前加锁
          1. 使用一致性数据快照：MVCC
        - 隔离级别：由低到高
          1. Read Uncommitted：未提交读，会导致数据完整性的严重问题，3种问题都存在
          1. Read Committed：已提交读，避免脏读，本事务中可以看到其他事务提交的数据，导致不可重复读、幻读
          1. Repeatable Read：可重复读，默认，一个事务开始后其他session对数据库的修改在本事务中不可见，只针对修改不针对插入，避免脏读/不可重复读/幻读
          1. Serializable：可序列化，事务串行化顺序执行，从mvcc并发控制退化为基于锁的并发控制，读写冲突，并发度急剧下降并增加死锁的机率，避免脏读/不可重复读/幻读
     1. 在读取数据的时候,innodb几乎不用获得任何锁, 每个查询都通过版本检查,只获得自己需要的数据版本,从而大大提高了系统的并发度
1. 锁
   - 特点
     1. 行锁基于索引项加锁实现，只有通过索引条件检索数据，InnoDB才使用行级锁，否则，InnoDB将使用表锁
     1. 目前处理死锁的方法是：将持有最少行级排它锁的事务回滚
   - 概念
     1. 加锁方式
        - 悲观锁
          1. 理解：Pessimistic Locking，读取的时候为后面的更新加锁，之后再来的读写都会等待，属于数据库的锁
             - 每次取数据时都认为其他线程会修改
          1. 意义：数据修改排他性，高并发下，数据可以正确写入。但带来数据库性能的大量开销，影响并发访问性，特别是长事务
        - 乐观锁
          1. 理解：Optimistic Locking，乐观并发控制。基于数据版本记录机制或CAS操作实现
            - 每次去取数据的时候总认为不会有其他线程对数据进行修改
          1. 优缺点：程序实现，不会存在死锁。但是阻止不了程序之外的数据库操作
          1. 流程：如updatetime/version等版本标识字段，根据version更新数据，一旦发现其他并发操作更新，会回退，并从新执行自己
             - 读数据时，将version/时间戳一同读出
             - 更新数据时，对比数据局版本
             - 版本正确，更新数据，version加1
             - 版本错误，认为是过期数据，采取补救措施
     1. 基于范围
        - 表锁：MyISAM，性能开销小，加锁快，无死锁，冲突高，并发低。可以并发读
          1. 写的时候读写都加锁等待，系统自动加锁。因为一次获取所有锁，不会死锁
          1. 必须一次锁定所有用到的表，别名也要指定，否则出错
        - 行锁：InnoDB，记录锁，开销大，加锁慢，有死锁，冲突低，并发高。基于索引，如果改的字段是索引或者自增字段，会锁住整个表
        - 页锁：BDB被InnoDB取代，并发介于表和行之间，会死锁
     1. 加锁方式
        - 一次性锁协议：所有锁一次性申请和释放，不会产生死锁
        - 两阶段锁协议：分成加锁(不能解锁)阶段，和释放第一个锁后就进入解锁(不能加锁)阶段
          1. 使得事务具有较高的并发度，因为解锁不必发生在事务结尾，但有死锁
   - mysql的锁
     1. Shared and Exclusive Lock
        - 特点
          1. 强锁
          1. 锁级别：有主键或索引行级别，无则表级别
          1. 仅适用于InnoDB，必须在事务中执行
          1. 存在写锁时普通select拿不到，for update读写都拿不到，update/delete/insert自动加，select任何锁不加
        - 分类
          1. Shared  Lock：共享锁，读锁，s，其他人读可以并行，锁拥有者不能修改，保证了拥有者释放锁时其他人读取的是对的，`lock in share mode`
          1. Exclusive Locks：排他锁，写锁，x，其他人读写都不能并行，`for update`
     1. Intention Lock
        - 认识：意向锁，表锁，为了允许行锁和表锁共存，实现多粒度锁机制。申请表锁时为了快速知道是否可锁，否则需要一行行去看是否有锁
          1. 弱锁，仅仅表明意向
          1. 给一个数据行加锁前必须先取得该表对应的意向锁
          1. 是InnoDB自动加的，不需用户干预
        - 分类
          1. 意向共享锁：is
          1. 意向排他锁：ix
     1. Auto-inc Lock
        - 认识：自增锁，特殊的表级锁，专门针对事务插入AUTO_INCREMENT类型的列
          1. 如果插入位置冲突，多个事务会阻塞，以保证数据一致性
          1. innodb_autoinc_lock_mode：调节该锁的模式与行为，3种配置，0加自增锁，1回滚自增列不连续，2批量插入自增列可能不连续，主从同步可能出问题
     1. Record Lock
        - 认识：记录锁，索引记录上加锁
     1. Gap Lock
        - 认识：间隙锁，范围查找自动锁定区间内所有行，索引记录中的间隔加锁，不可以被其他事务读取/修改，防止幻读
        - 分类
          1. Insert Intention Lock
             - 认识：插入意向锁，插入操作时使用，多个事务在同一个索引、同一个范围区间插入记录时，如果插入的位置冲突会阻塞
             - 实际是gap锁上加一个LOCK_INSERT_INTENTION标记
     1. Next-key Lock
        - 认识：Ordinary Lock 临键锁，同时锁住索引的记录和间隙
          1. 在RR下有效，防止幻读
          1. 两种锁可能只成功一个，所以next-key是半开半闭区间，且是下界开，上界闭
     1. Metadata Lock
        - 认识：MDL锁，是server层的锁，主要用于隔离DML和DDL操作之间的干扰
          1. 每执行一条DML、DDL语句时都会申请，DML需MDL读锁，DDL需MDL写锁，有活动事务时会等待
          1. 加锁过程自动控制
          1. 查看：`select * from performance_schema.metadata_locks;`
        - 会话锁
          1. `get_lock(key, timeout)`：按key名加锁，使用元数据锁定(MDL)，没人用
          1. `release_lock(key)/release_all_lock()`：释放锁，关闭连接锁也释放
          1. `is_free_lock(key)/is_used_lock(key)`
   - 查看
     1. 表锁争用情况：`show status like 'table%';`
     1. 行锁争用情况：`show status like 'innodb_row_lock%';`，使用监视器`CREATE TABLE innodb_monitor(a INT) ENGINE=INNODB;Show innodb status\G;DROP TABLE innodb_monitor;`
   - 死锁
     1. 表现
        - 记录锁（LOCK_REC_NOT_GAP）: lock_mode X locks rec but not gap
        - 间隙锁（LOCK_GAP）: lock_mode X locks gap before rec
        - 插入意向锁（LOCK_INSERT_INTENTION）: lock_mode X locks gap before rec insert intention
        - Next-key锁（LOCK_ORNIDARY）: lock_mode X
     1. 解决方案
        - 通常来说，死锁都是应用设计的问题。死锁的关键在于两个(或以上)的Session加锁的顺序不一致
        - 如果并发查询多个表，约定访问顺序
        - 批量处理数据时事先对数据排序，保证每个线程按固定顺序处理记录，也可以大大降低出现死锁的可能
        - 在同一个事务中，尽可能做到一次锁定获取所需要的资源，不要先共享锁，再排它锁
        - 小事务发生锁冲突的几率也更小
1. 预解析
   - 理解：使用占位符预先准备查询语句，不用解析语句，查询速度更快，防止注入。步骤有：prepare、execute、deallocate prepare(发布)
   - 实例
    ```sql
    PREPARE stmt1 FROM 'select ... ?';          # 准备占位符

    SET @a = '1';
    EXECUTE stmt1 USING @a;

    DEALLOCATE PREPARE stmt1;
    ```
1. 视图
   - 理解：即虚拟表，可以对视图进行操作，作用有简化查询，限制用户访问和权限。不支持物理视图，可以进行查询和更改，表改变不会联动视图改变    
   - 创建：`create view viewName as select * from table`，分辨视图 `show full tables;`
1. 触发器
   - 理解：triggers，自动执行响应事件的存储程序，滥用造成数据库的维护困难
   - 分类：before/after insert/update/delete
   - 实例
    ```sql
    create trigger triName
        before update on table
        for each row
    begin
        # sql
    end;
    ```
1. 存储过程
   - 理解：是以后使用而保存的一条或多条sql集合，预先缓存编译结果，是业务逻辑和流程的集合。执行速度快，传输数据少，耗内存，不灵活
   - 实例
    ```sql
    CREATE PROCEDURE procedureName()
    BEGIN
        SELECT * FROM user;
    END
    ```
   - 游标：只能用在存储过程，类似指针
    ```sql
    declare num cursor;
    open num;
    close num;
    ```
### 维护
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
### 运维
1. 安装
   - 安装：`yum -y install mysql-server`
   - 设置字符集：`vim /etc/my.cnf` ([mysqld]下添加)
     1. `character-set-server=utf8`
     1. `default-character-set=utf8`
1. 使用
   - 启动：`mysqld_safe &`
   - 关闭：`mysqladmin -u -p shutdown`
   - 重启：`service mysqld restart`
   - 查看：`ps -ef | grep mysqld`
1. 配置
   - 配置文件
     1. `mysql --help | grep my.cnf`
   - 查看
     1. `show variables;`
     1. `show variables like 'slow_query%';`
   - 修改
     1. 变量方式：`set global slow_query_log='ON';`
     1. 配置文件方式：my.cnf，`slow_query_log = ON`
   - 安全
     1. sql安全：防注入(预处理)、特殊字符转义、错误信息屏蔽。权限分开、定期修改密码
     1. 备份恢复
1. 连接方式
   - tcp/ip套接字：`mysql -h127.0.0.1`
   - 域套接字：`mysql -S /tmp/mysql.sock`
   - 命名管道、共享内存：通过配置开启
1. 实例迁移步骤
   - 搭建新实例实时和旧的同步
   - 业务方修改配置
   - 业务方停止增删改操作（停服）
   - 删除写用户，保留只读用户 （防止丢数据）
   - 断开新实例到老实例同步，开启新主库可写入
   - 发布，验证业务
   - 删除旧实例
1. 备份
   - 认识
     1. 备份文件：逻辑文件，文件可读如mysqldump，恢复时间长，用于升级、迁移等工作；裸文件
     1. 备份方式：完全、增量（记录LSN之后的备份）、日志
   - 备份策略最佳实践：定期备份
     1. 本地备份
     1. 本地增量备份：每天和每10分钟一次，备份到同机房其他服务器
     1. 异地备份，先随机加密，后传输到异地，异地双备份
   - 备份要求
     1. 备份的一致性
     1. 做好异地容灾
     1. 定期覆盖度测试
   - 备份方式
     1. 冷备
        - 理解：复制相关文件即可，应该存放到远程服务器中。如shell(mysqldump) + rsync + crontab，或者直接复制文件
        - 备份内容：frm、ibdata1、*.ibd、redo log、my.conf
     1. 热备
        - ibbackup
          1. 认识：官方提供，不阻塞，性能好(复制日志文件)，支持压缩。不支持真正增量备份，只是某时刻的恢复
          1. 原理：记录LSN，开始备份，然后找回来备份时的redo log
        - xtrabacup
          1. 认识：开源，支持增量备份，原理是先全备，记录此时的LSN，增量时比较LSN并且不断更新LSN
     1. 复制
     1. 逻辑备份
        - mysqldump：`mysqldump -u -p [databaseName or tableName] > data.sql`
          1. -d 只导出结构
          1. -t 只导出数据
          1. --all-databases：所有数据库
          1. --single-transaction：设定备份一致性
        - select ... into outfile：`select * into outfile 'xx.txt' fields terminated by ',' optionally enclosed by '"' lines terminated by '\n' from table;`
     1. 二进制备份：用`flush logs`生成新日志文件，然后备份旧的
     1. 快照备份
        - 认识：把所有日志放到同一个逻辑卷中，用lvm快照
1. 恢复
   - 逻辑日志导入
     1. mysql -u -p databaseName < data.sql
     1. source xx.sql
     1. load data local infile 'xx.txt' into table tableName;
     1. mysqlimport -u -p --local databaseName dump.sql
   - 二进制日志导入
     1. mysqlbinlog
        - start/stop-position：开始结束位置
        - `mysqlbinlog xx.xx | mysql -u -p`
        - `mysqlbinlog xx.xx > xx.sql`
1. 工具
   - binlog2sql：回滚指定时间点的sql语句
   - xtrabackup：录binlog位置后copy文件，速度比逻辑备份快上百倍
### WIKI
1. 相关
   - 数据库：文件中读写数据不方便、速度慢，按照数据结构来组织、存储和管理数据的仓库，提供API进行数据操作
   - 关系型数据库：建立在关系模型基础上，由行、表、库等组成
   - MySQL：瑞典的属于Oracle公司的开源数据库，使用标准sql语句，支持多客户端语言如c、php等，32位最大表文件4GB，64的8TB
1. 其他
   - 严格模式
   - NULL与任何其它值的比较永远返回false，即使NULL=NULL也返回false
   - 修饰符：格式化显示 \G、取消当前sql \c、退出 \q、显示状态 \s、\h、\d
   - 数据大小写
     1. 默认的字符检索策略：utf8_general_ci，不区分大小写
     1. utf8_general_cs 表示区分大小写，utf8_bin表示二进制比较，同样也区分大小写
     1. 解决方案
        - 直接修改字符集属性
        - 搜索时添加关键字binary表示二进制区分：`SELECT * FROM a WHERE binary name LIKE 'a%';`
1. 历史
   - 5.6
     1. server参数默认值改变
     1. innodb增强
        - 支持online DDL
        - 新增参数innodb_page_size设置页大小
        - undo log可独立出系统表空间
        - redo log最大增至512G
        - 独立表空间的.ibd文件可以在建表时指定目录
        - 支持read-only事务
        - 支持全文本搜索
        - 导入和导出表空间，copy文件的方式比mysqldump快好多
        - 缓冲池flush算法增强
        - innodb内部性能增强：包括将flushing操作独立出主线程，减少核心互斥锁，可设置多个清除线程，减少大内存系统的资源争夺
        - 检测死锁算法增强。在非递归情况下死锁检测：死锁信息可以记录到 error 日志，方便分析
        - 优化器统计持续化：重启不丢失
     1. 复制和日志增强
        - 新增GTID复制
        - 新增binlog_row_image
        - master.info和relay-log.info支持存储在表中
        - mysqlbinlog命令支持binlog备份
        - 支持延时复制：MASTER_DELAY
        - 基于schema级别的多线程复制
        - binlog支持crash-safe
     1. 数据类型
        - datetime类型支持DEFAULT CURRENT_TIMESTAMP和ON UPDATE CURRENT_TIMESTAMP
     1. 分区增强
        - 最大分区个数增至8192，包括分区和子分区
        - 支持分区表的分区（或子分区）与非分区表交换：ALTER TABLE ... EXCHANGE PARTITION
        - 简化分区锁增强性能
     1. 优化器增强
        - limit/MRR/ICP/新增连接算法BKA/子查询优化：包括物化和半连接优化等特性/面向开发者的优化器追踪特性
     1. MySQL Performance Schema 增强
        - Statements/execution stages - 找出消耗资源热点SQL
        - Table and Index I/O ： 那些表和索引引起负载过高 ？
        - Table Locks ： 那些表引起竞争？
        - Users/Hosts/Accounts 级别资源消耗 ：找出消耗资源最多的Users/Hosts/Accounts
        - Network I/O ： 网络还是应用程序？ 会话闲置多久？
        - 通过 thread, user, host, account, object聚合总结
     1. 联合普通索引，过滤比较完所有的条件后，才去主键索引上查，有效减少回主键索引次数，提高了效率
   - 5.7
     1. json
        ```sql
        # 查询json数据：json_column->"$.id"，和json_extract，是两种使用方式。->>表示去掉转义符
        SELECT json_extract(json_data, '$.content.answer[*].group[*].value') FROM entity_question WHERE JSON_SEARCH (json_data,'all','行到水穷处',NULL,'$.content.answer[*].group[*].value') IS NOT NULL;
        # 以下这条不能准确的搜索，因为不能遍历所有的type
        SELECT json_extract(json_data,'$.content.answer') FROM entity_question WHERE JSON_EXTRACT(json_data, "$.content.answer[*].group[*].type") != 'text';
        ```
     1. 虚拟列：可以根据逻辑抽出某个字段的某种数据，查的时候方便了，不像以前不用再新建汇总表了。`alter table xxx add xx char(1) generated always as (left(xx, 1));`
   - 8.0
     1. 索引相关
        - 支持多种索引
          1. 隐藏索引：不会被优化器使用
          1. 降序索引：descending index，只有innodb支持，只支持btree
        - 支持函数索引：在索引中使用函数，支持json数据索引，基于虚拟列实现
     1. 支持通用表表达式：CTE，即with子句，和派生表类似，像语句级别的临时表或视图，用完就不用管了，类似临时的变量等
        - 可以引用其他cte
     1. 支持窗口函数，也叫分析函数，over，和分组聚合类似，是每一行生成一个结果，可以结合统计函数一起使用，非常灵活
        - row_number/rank
        - first_value/last_value/lead
        - cume_dist/nth_value
     1. innodb增强
        - 集成数据字典
        - 支持原子DDL语句
        - 自增列持久化
        - 死锁检查控制
        - 锁定语句选项
        - 其他
     1. json增强
        - 内联路径操作：->>
        - 聚合函数：json_arrayagg
        - 实用函数
        - 合并函数
        - 表函数
