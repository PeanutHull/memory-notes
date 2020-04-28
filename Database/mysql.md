### 路线：基础知识（操作、配置、历史）——优化方式、方法、注意点——各种技术方案——原理
### 提升：集群部署--中间件实施--备份设计监控--日志处理--授权
### 基础
1. 数据类型
   - 数字
     1. 整数
        - 分类
          1. tinyint：-128~127
          1. smallint：前后3万2
          1. mediumint：前后8.3千万
          1. int：前后21亿，int中m仅用于显示不影响存储范围，如int(3)，显示为001，和INTEGER相同
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
     1. MyISAM：5.1之前的默认引擎，用于只读提高性能、不支持事务、不支持外键，最大256TB，可以压缩为只读表，支持全文索引、压缩、空间函数。表存两个文件myd和myi，表示数据和索引
     1. InnoDB：性能优秀，数据存在共享表空间，可通过配置分开，支持MVCC，多种行锁机制组合，一致性读或者读快照就是读取当前事务开始之前的数据快照，在这个事务开始之后的更新不会被读到。InnoDB行锁是通过给索引上的索引项加锁来实现的
        - 事务
        - 行级锁
        - 实现sql标准的4种隔离级别
        - 自动插入缓存(insert buffer)
        - 二次写(double write)
        - 读取数据时自动在内存构建hash索引(adaptive hash index)
        - 预读(read ahead)
        - 索引是其表空间的组成部分
        - 通过工具支持热备份
        - 支持崩溃后安全恢复
        - 支持外键
     1. memory；内存表存储在内存中，并使用散列索引，使其比MyISAM表格快，服务器停止数据丢失
     1. Archive、Blackhole、CSV
     1. merge：将具有相似结构的多个MyISAM表组合到一个表中的虚拟表
     1. 对比
        - nodb不支持全文索引，MyISAM支持
1. 库
   - 组成
     1. mysql：用户/权限相关，user表存储用户和权限
     1. information_schema：自身架构相关
     1. performance_schema
     1. sys
1. sql语句
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
1. 其他
   - 注释 ：--、#、/**/=
   - 变量：基于会话，用户变量不区分大小写。定义 `set @a:=/=1`
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
   - 特性
     1. 选择性原则：不重复的索引值和总数的比值。范围0~1，选择性越高查询效率越高，提高查询速度，节省空间和io。唯一索引的选择性是1性能最好。区分度公式COUNT(DISTINCT col)/COUNT(*)
     1. 最左前缀原则：组合索引只会从左边开始按照索引搜索，如果检索条件没有最左的，那么就不会使用到索引，因为不知道去哪儿开始找
     1. 查询只能使用一个索引，会选择限制最严格的索引：where用了order没法用，只有order的字段在where中才会用
     1. 有null的列不会包含在索引中
   - 特点
     1. 表只有一个主键索引，可有多个唯一索引
     1. key和index都是索引，为兼容其他系统，key多了一层约束层含义
     1. hash索引，重复数据多了性能下降，hash碰撞
     1. 使用了索引：意思是使用索引的快速搜索功能，有效的减少了扫描行数。对应的有全索引扫描，是不够快的
1. 事务
   - 理解：保证所有操作全部执行，由InnoDB提供，服务层不管理，由下边的引擎实现，在一个事务中，使用多个引擎不靠谱。再开启一个事务会隐式提交上一个事务
   - 特性：ACID
     1. 原子性：一个事务是一个整体，要么全部成功，要么全部失败
     1. 稳定性/一致性：有非法数据(外键约束等)，事务撤回，数据库总是从一个一致性状态转换到另一个一致状态
     1. 隔离性：通常来说，一个事务所做的修改在最终提交以前对其他事务不可见
     1. 持久性/可靠性：一旦事务提交，则其所做的修改就会永久保存到数据库中。此时即使系统崩溃，修改的数据也不会丢失
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
          1. Repeatable Read：可重复读，默认，一个事务开始后其他session对数据库的修改在本事务中不可见，只针对修改不针对插入，避免脏读/不可重复读
          1. Serializable：可序列化，事务串行化顺序执行，性能问题并增加死锁的机率，避免脏读/不可重复读/幻读
     1. 在读取数据的时候,innodb几乎不用获得任何锁, 每个查询都通过版本检查,只获得自己需要的数据版本,从而大大提高了系统的并发度
   - 分布式事务
     1. CAP理论：Consistency 一致性，Availability 可用性，Partition tolerance 分区容错性，不可兼得
     1. BASE方案：Basically Available 基本可用，Soft state 软状态，Eventually Consistent 最终一致，牺牲某时刻一致性保证最终一致性
     1. 分布式事务实现：只能实现弱一致性，TCC、高可用消息服务、最大努力通知
        - 两阶段提交/XA：事务管理器协调，先问问ok不，再判断是否全部ok，https://github.com/yu199195/happylifeplat-transaction
        - TCC：Try-Confirm-Cancel：https://github.com/yu199195/happylifeplat-tcc
        - 基于消息中间件的解决分布式事务框架：https://github.com/yu199195/myth
        - 消息中间件支持：jms(activimq),amqp(rabbitmq),kafka,roceketmq。
        - rpc框架支持 : dubbo(可用Fescar保持数据一致性),motan,springcloud
        - 本地事务日志存储支持 : redis,mogondb,zookeeper,file,mysql
1. 锁
   - 分类
     1. 基于数据操作
        - 共享锁：`lock in share mode;`，读锁，读读可以并行，同时锁拥有者不能修改，保证了拥有者释放锁时其他人读取的是对的
        - 排他锁：`for update`，写锁，读写不能并行，写写不能并行
          1. 锁级别：有主键或索引行级别，无则表级别
          1. 注意
             - 仅适用于InnoDB，必须在事务中执行
             - 存在写锁时普通select拿不到，for update读写都拿不到，update/delete/insert自动加，select任何锁不加
        - 意向共享锁：为了允许行锁和表锁共存，实现多粒度锁机制，意向锁都是表锁，申请表锁时为了快速知道是否可锁，否则需要一行行去看是否有锁
        - 意向排他锁
        - MDL锁
        - 两阶段锁协议
        - 死锁和死锁检测：发生死锁后InnoDB一般都能自动检测到，并使一个事务释放锁并回退，涉及表锁稍微不行
     1. 基于范围
        - 表锁：MyISAM，性能开销小，加锁快，无死锁，冲突高，并发低。可以并发读，写的时候读写都加锁等待，系统自动加锁。因为一次获取所有锁，不会死锁。必须一次锁定所有用到的表，别名也要指定，否则出错
        - 行锁：InnoDB，开销大，加锁慢，有死锁，冲突低，并发高。基于索引，如果改的字段是索引或者自增字段，会锁住整个表
        - 间隙锁：gap锁，范围查找自动锁定范围内所有行，不可以被其他事务读取/修改，防止幻读
        - 页锁：BDB被InnoDB取代，并发介于表和行之间，会死锁
     1. 基于逻辑
        - 悲观锁
          1. 理解：Pessimistic Locking，读取的时候为后面的更新加锁，之后再来的读写都会等待，属于数据库层面的锁
          1. 意义：数据修改排他性，高并发下，数据可以正确写入。但带来数据库性能的大量开销，影响并发访问性，特别是长事务
        - 乐观锁
          1. 理解：Optimistic Locking，乐观并发控制。基于数据版本记录机制实现。如updatetime/version等版本标识字段，根据version更新数据，一旦发现其他并发操作更新，会回退，并从新执行自己
          1. 优缺点：程序实现，不会存在死锁。但是阻止不了程序之外的数据库操作
          1. 流程
             - 读数据时，将version/时间戳一同读出
             - 更新数据时，对比数据局版本
             - 版本正确，更新数据，version加1
             - 版本错误，认为是过期数据，采取补救措施
   - 查看
     1. 表锁争用情况：`show status like 'table%';`
     1. 行锁争用情况：`show status like 'innodb_row_lock%';`，使用监视器`CREATE TABLE innodb_monitor(a INT) ENGINE=INNODB;Show innodb status\G;DROP TABLE innodb_monitor;`
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
   - 查看
     1. `show variables;`
     1. `show variables like 'slow_query%';`
   - 修改
     1. 变量方式：`set global slow_query_log='ON';`
     1. 配置文件方式：my.cnf，`slow_query_log = ON`
   - 安全
     1. sql安全：防注入(预处理)、特殊字符转义、错误信息屏蔽。权限分开、定期修改密码
     1. 备份恢复
        - 定期备份：物理备份、逻辑备份
        - 恢复：binlog增量恢复
   - 导出导入
     1. 导出
        ```sql
        mysqldump -u -p [databaseName or tableName] > data.sql            # -d 只导出结构，-t 只导出数据
        select * into outfile 'xx.txt' fields terminated by ',' optionally enclosed by '"' lines terminated by '\n' from table;
        ```
     1. 导入
        ```sql
        mysqlimport -u -p --local databaseName dump.sql
        source xx.sql
        mysql -u -p databaseName < data.sql
        load data local infile 'xx.txt' into table tableName;
        ```
1. 日志
   - 分类
     1. 错误：启动、运行、停止遇到的问题
     1. 通用查询：客户端连接和执行的语句
     1. 二进制：记录更改数据的语句
     1. 中继：从接收的主的数据
     1. 慢查询：执行时间超过long_query_time的查询或不使用索引的查询
     1. DDL：元数据操作的语句
   - frm,myd,myi
   - binlog
     1. 认识：记录所有除查询的DDL和DML语句，以事件形式记录、包含执行的时间、事务安全型的二进制文件集合。分为本身和索引文件(记录有效的文件)，开启1%的性能损耗
        - 生成新的日志文件的情况：重启时、执行`flush logs`、大小超过`max_binlog_size`
        - 记录的格式
          1. STATEMENT：基于SQL语句。不记录每行变化，减少了日志量节约了IO，为了slave正确运行需要记录相关信息
          1. ROW：基于行，5.7.7及以上默认，之前是STATEMENT。只记录行的修改点，避免了存储过程/function/trigger的调用和触发无法被正确复制的问题，日志量大
          1. MIXED：混合模式，一般用statment，无法完成主从复制的操作用row
        - 配置
          1. sync_binlog：刷新到磁盘的事务执行次数，为1最安全在系统故障时最多丢失一个事务的更新
        - 事件类型：QUERY_EVENT、STOP_EVENT等
     1. 用途
        - 主从复制：传输binlog
        - 数据恢复：使用mysqlbinlog工具
     1. 使用
        - sql
          1. `show binary logs;`：查看二进制文件列表和大小，如mysql-bin.*
          1. `show binlog events in '' from pos limit [offset,]count;`：查看某个binlog
          1. `reset master;`：清空所有
        - 工具：mysqlbinlog，直接恢复：`mysqlbinlog /var/lib/mysql/mysqld-bin.000001 | mysql -uroot`
          1. --database DB_name
          1. --no-defaults 
          1. --start/stop-datetime、--start/stop-position
1. 监控
   - 性能测试：数据多才有参考价值，数据总量超过内存总量，如几百条数据第一条命令下去就全部加载到内存了，没有参考意义
   - 性能：连接数、qps
     1. `show status like 'Threads%';`：查看连接数
     1. `show processlist;`：查看所有连接
     1. `show variables like '%connect%';`：查看连接的配置
   - 硬件：主频高处理快高吞吐低时延，L1/2/3的cache大速度快，内存大磁盘读写少TPS高，固态快机械配阵列卡，网卡好低时延，文件系统用xfs/ext4不用ext3
     1. 更大内存、更快磁盘：比业务服务器要求高
1. 慢查询：记录超过一定时间的查询语句
    ```
    slow_query_log = ON
    slow_query_log_file = /usr/local/mysql/data/slow.log
    long_query_time = 1
    ```
1. 调优
   - 参数
     1. Innodb_buffer_pool
     1. Innodb_buffer_pool_instances
     1. innodb_flush_log_at_trx_commit
     1. binlog-format
     1. transaction-isolation
     1. sync_binlog
1. 基准测试：进行定量的、可复现的测试，不关心业务逻辑，对比于压力测试。mysql由于数据一致性的要求无法简单的水平扩展(即加机器)，主要评估qps和响应时间
   - mysqlslap：简单，容易使用，无法生成数据，适合对既有数据库单个sql进行优化测试
   - Sysbench：内嵌lua脚本，可生成指定规模数据，主流厂商(Oracle/Percona)使用，支持多线程，支持多种数据库
     1. 建表，塞1百万数据：`sysbench --monitis=oltp --oltp-table-size=1000000 --mysql-db=xx --mysql-user=root --mysql-password=xx prepare`
     1. 开始测试：`sysbench --monitis=oltp --oltp-table-size=1000000 --mysql-db=xx –mysql-user=root –mysql-password=xx –max-time=60 –oltp-read-only=on –max-requests=0 –num-threads=8 run`
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
1. 实例迁移步骤
   - 搭建新实例实时和旧的同步
   - 业务方修改配置
   - 业务方停止增删改操作（停服）
   - 删除写用户，保留只读用户 （防止丢数据）
   - 断开新实例到老实例同步，开启新主库可写入
   - 发布，验证业务
   - 删除旧实例
### 实践
1. 设计和使用
   - 数据类型
     1. 尽量使用更简单的类型，数据长度越短越好(更少存储内存空间)
     1. 长数字使用string
     1. 用枚举代替常用字符串类型
     1. 尽量用timestamp，比datetime效率高
     1. 给文本字段留足余量
     1. 不能为null
   - 列设计
     1. 一定有主键，最好是自增，否则多次读写后更离散，更多随机io
     1. 增加create_time/update_time字段，用于数据归档/自定义差异备份
     1. 大数据字段独立表进行存储，提交表性能
     1. 名称不要和关键字碰撞
   - 索引
     1. 建立原则
        - 数据量少的、数据经常改变的、数据差别不大的不能建立
        - 字符串使用前缀索引，节省大量空间
        - 尽可能扩展和整合索引，而不是增加索引
        - 最左前缀原则：不用给组合索引最左边的列单独建立索引
     1. 使用原则
        - like：最左原则，%aa%不使用索引，而aa%使用
        - or：前后条件都有索引才使用索引，否则用union
        - !=、not in、<>：不使用索引，范围查询可能用到索引如>、in等
        - 字符串列加引号，否则索引失效
        - 不在列上运算：因为每个行要运算所以索引失效
        - 使用索引列排序：唯一索引原则
        - 优化器会评估，有可能放弃使用索引
        - on、using子句上有索引，否则全表
   - 事务
     1. 不能运行大事务，否则导致主从延迟，事务执行多长时间，就延迟多长时间
   - 查询
     1. 无select *，sql中无计算、无函数
     1. 提高索引利用率
     1. 所有where条件加引号，防止类型隐式转换
     1. 尽量用union代替子查询
     1. union all代替union
     1. group和order尽量在一个表中，否则在两个表中两个表全表扫描
     1. 不需要排序用order by null否则依然排序
     1. 使用count(*)忽略所有列，不用列名
     1. 尽量inner join让优化器自动选择驱动表
     1. 一个大查询可以分解为小查询，内部每秒能扫描百万行
     1. 开启查询缓存
   - 运维
     1. 慢查询日志，不要直接打开，使用pt-query-digest工具分析
     1. set profile = 1;show profile;show profile for query 1;获取sql执行时间
     1. show status;show global status;分析计数器
     1. show processlist;查看线程状态
     1. 关键业务上线前explain确认执行计划
1. explain
   - 理解：sql语句分析，将过程和索引等信息列出来
   - 使用解析
     1. select_type：查询类型，simple、primary、union、subquery
     1. type：访问类型，在表中找到所需行的方式，效率由高到低
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
1. gist
   - 查询这个数据是否存在，存在则存到另一张表里：`create table temp as select * from admin a where exists (select uid from user u where a.userName = u.account);`
   - 查询两张表中是否有相同数据：`select * from admin where uid IN(select uid from temp);`
   - 求差集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx WHERE B.id IS NULL union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx WHERE A.id IS NULL;`
   - 求全集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx;`
   - 原所有id增加5万，必须倒叙操作：`update user SET uid=uid+50000 order by uid desc;`
   - 插入不重复数据行，mysql特有不是标准sql语法：`INSERT token(udid) values ('{$udid}') ON DUPLICATE KEY UPDATE activetime ='{$time}'`
### 高级
1. 主从，主主，amoeba
   - 原理：主库将更改记录到二进制日志binlog，从库复制到中继日志，读取中继重新放到库中
     1. 负载均衡，降低压力
     1. 高可用，故障切换
   - 查看
     1. `show master status;`
1. 读写分离：采用数据库主从方式，多个从库分担读，主库负责写
1. 分表分区
   - 认识
     1. 分区：对用户透明，底层分为多个物理分区。用partition by定义每个分区存放的数据，优化器自动使用。适用于数据多，只在表最后有热点数据，其他都是历史数据。分区可以分布在不同机器上独立维护，有很多功能不能用
        - 存储更多数据：可分布在不同的物理设备
        - 优化查询：where语句中包含分区条件时，只会使用某几个分区
        - 类型：RANGE、LIST、HASH、KEY
        - 适用于所有数据和索引，两者不能分开
     1. 分表：可以将两种方式结合使用
        - 水平拆分：用于数据本身有独立性，可以拆分，逻辑分层算法无法变更，关键字段取模方式拆到多个表中，降低单表大小
        - 垂直拆分：把属性较多、数据较大的表某些字段拆分到不同的表中，查询时可减少io次数，但是应用增加复杂度。分主表、扩展表。因为数据库的内存buffer存row
   - 跨表分页
     1. 全局视野法：改造分页sql，每个表都取出来，然后放一起再排序。`offset X limit Y`改为`offset 0 limit X+Y`。精准返回，页码增加性能急剧下降
     1. 业务折衷
        - 禁止跳页查询：第一页作为第二页的查询条件，再全局视野
        - 允许数据精度损失：认定数据足够随机，取模去取数据
     1. 二次查询法
        - 将order by time offset X limit Y，改写成order by time offset X/N limit Y
        - 找到所有表中的最小值time_min
        - between二次查询，order by time between $time_min and $time_N_max
        - 拿time_min在各个分库中比较，得出每个表的虚拟offset，相加从而得到time_min在全局的offset
        - 得到了time_min在全局的offset，自然得到了全局的offset X limit Y，要什么从后推着拿就行
1. 数据库中间件
   - mycat
     1. 认识：开源分布式数据库中间件
     1. 高可用：采用去中心化的集群，在虚拟ip下，在不同的节点部署多个mycat，根据某种策略(ip选举策略)选举某一个为临时master，之间采用心跳机制进行通信维持故障切换。可使用zk、haproxy、keepalived等组件，可以有选举、心跳、切换ip等功能
### WIKI
1. 当系统遇到无法解决的技术难题时，可以通过变换业务逻辑实现功能
1. 概念
   - 数据库：文件中读写数据不方便、速度慢，按照数据结构来组织、存储和管理数据的仓库，提供API进行数据操作
   - 关系型数据库：建立在关系模型基础上，由行、表、库等组成
   - MySQL：瑞典的属于Oracle公司的开源数据库，使用标准sql语句，支持多客户端语言如c、php等，32位最大表文件4GB，64的8TB
1. 聚集索引/非聚集索引
   - 非聚簇索引：MyISAM的方式，单行检索快
   - 聚簇索引：叶结点包含了完整的数据记录，按数据存放的物理位置为顺序，多行检索快。辅助索引搜索需要检索两遍索引：首先检索辅助索引获得主键，然后用主键到主索引中检索获得记录
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
### 原理
1. 架构
   - Server：————负责跨存储引擎功能的实现，如存储过程、触发器、视图
     1. 连接器：————管理连接、连接权限验证，用户权限信息放在一个变量中以供后续使用，长连接多了容易内存爆满
     1. 查询缓存：————8.0已删除，命中率非常低，表更新会使所有查询缓存清空
     1. 分析器：————词法语法分析，之后进行precheck权限检查
     1. 优化器：————生成执行计划，选择索引
        - 决定使用哪个索引
        - join时决定表的连接顺序
     1. 执行器：————操作引擎(调用引擎接口)，返回结果，再次检查权限，因为有些只能在执行阶段才能知道具体哪张表，如触发器
   - 存储引擎：————负责数据存取，插件式
     1. InnoDB
     1. MyISAM
     1. Memory
1. WAL
   - 认识：Write-Ahead Logging，预写式日志。先写内存日志，再更新。当MySQL空闲时，将内存中的数据落盘
   - 步骤
     1. 执行器取ID=2的数据
     1. 引擎判断数据页是否在内存中，没有则从磁盘读取到内存中，从内存中返回行数据；（内存大的服务器的好处）
     1. 执行器将该数据值加1，之后写入新行，通知引擎
     1. 引擎将新数据更新到内存中
     1. 引擎此时开始记录redolog，并将该记录置为prepare状态（SSD磁盘读写快，写日志嗖嗖的）
     1. 执行器写binlog
     1. 引擎提交事务，并更新此行数据的redolog状态为commit
     1. 当MySQL空闲时，会将内存中的数据落盘
   - 解释
     1. 步骤
        - 账本记录卖一瓶可乐（redolog 处于 prepare）
        - 收钱放入抽屉（binlog）
        - 收完钱，在账本该记录上打对勾，代表抵账（redolog 置为 commit）
     1. 纠错
        - 若收钱过程被打断，则整理交易时，发现只是记账了却没收钱，则删除该账本记录（回滚）
        - 若收了钱，有事情耽误了抵账，那么之后闲下来对账的时候，将账本该记录打勾即可（即commit）
1. 日志
   - 分类
     1. Server：binlog，是Server层的追加记录的日志记录功能，当文件写到一定大小会新增文件继续记录，属于全量日志
     1. InnoDB
        - undolog：回滚日志，记录事务开始前的数据，update/delete操作存放数据旧记录，insert操作记录新数据行的PK(rowid)，用于回滚、崩溃恢复，实际做的是相反的操作
        - redolog：重做日志，记录事务运行中的改动。InnoDB独有，是物理页上的直接改动，顺序写的方式，效率很高。固定大小，循环记录
   - 联系
     1. binlog和redolog通过事件id关联，并存可以保证数据一致性，即crash-safe
     1. redo是前滚，undo是事务前回滚
1. ACID
   - 概括
     1. undo保证事务的原子性，redo保证持久性，隔离性通过锁和mvcc实现，其他通过日志
     1. 数据库重启先进行crash recovery
   - 持久性和原子性
     1. 持久性和事务原子性
        - redo：redo日志记录LSN(每一个事务写入重做日志的字节总量)，数据页头部也记录LSN，数据库启动时，对比两个LSN，会将redo中多出来的写回页中
        - undo：撤销所有执行了一部分但尚未提交的操作
     1. 写入原子性：redo日志以512字节存储，称为重做日志块。磁盘一个扇区是512字节，操作系统与磁盘的数据交换扇区为基本单位。只需无缓冲写入磁盘就可保证数据原子写入
   - 一致性：原子性不能保证一致性，为了保证并发情况下的一致性，引入了隔离性
   - 隔离性：保证每个事务看到的数据是一致的，就象其它并发事务不存在。
     1. MVCC
        - 认识：Multi-Version Concurrency Control 数据多版本并发控制
          1. 提供基于某时间点的快照。可提供事务开始时相同的数据，不管事务执行的时间有多长
          1. 对于支持行锁的事务引擎，进行数据库的并发控制，把数据库的行锁与行的多个版本结合起来,只需很小开销就可实现非锁定读,从而大大提高并发性能
        - 原理
          1. 写任务发生时，将数据克隆一份，以版本号区分；
          1. 写任务操作新克隆的数据，直至提交
          1. 并发读任务可以继续读取旧版本的数据，不至于阻塞
1. 索引
   - 类型分类
     1. 主键索引
     1. 普通索引：如果查询普通索引获取本普通索引之外的数据，那么就需要找到主键id，然后去主键索引上拿数据，n个普通索引的记录，就需要重复n次去主键上取数据
   - 属性分类
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
