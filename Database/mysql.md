### 构成
#### 基本
1. 语法
   - 注释 ：--、#、/**/=
   - 不区分大小写
   - 符号
     1. %百分号通配符: 表示任何字符出现任意次数 (可以是0次).
     1. _下划线通配符:表示只能匹配单个字符,不能多也不能少,就是一个字符.
1. 数据类型
   - 数字
     1. 整数
        - 分类：m仅用于显示不影响存储范围，如int(3)、tinyint(4)，显示为001，和INTEGER相同
          1. tinyint：-128~127，1byte
          1. smallint：前后3万2，2byte
          1. mediumint：前后8.3千万，3byte
          1. int：前后21亿，10位，4byte
          1. bigint：前后9亿亿亿，无符号20位，有符号19位，2E64，8byte
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
   - 日期和时间
     1. datetime
        - 最通用
        - 时区无关
        - 形式：`YYYY-MM-DD HH:MM:SS`
        - 范围：`1000-01-01 00:00:00 ~ 9999-12-31 23:59:59`
        - 大小：v5.6.4之前固定8byte，之后支持微秒，根据毫秒位数确定
        - 最佳实践
          1. 默认可以设置为`1970-01-01 00:00:00`，全是0可能有问题，还会破坏索引
     1. timestamp
        - 表示时间戳的范围
        - 自带时区属性，处理不同时区方便，值会随着服务器时区的变化而变化
        - 形式：`YYYY-MM-DD HH:MM:SS`
        - 范围：`1970-01-01 00:00:01 UTC ~ 2038-01-19 03:14:07 UTC`
        - 大小：v5.6.4之前固定4byte，之后支持微秒，根据毫秒位数确定
        - 最佳实践
          1. 调用底层系统函数有锁，不应依赖数据库
     1. DATE
        - 形式：`YYYY-MM-DD`
        - 范围：`1000-01-01 ~ 9999-12-31`
        - 大小：3byte，支持日期计算
     1. TIME
        - 形式：`HH:MM:SS`
        - 范围：`-838:59:59 ~ 838:59:59`
     1. YEAR
        - 形式：`YYYY`
        - 范围：`1901/2155`
     1. int
     1. string：不推荐，无法使用时间函数
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
   - cast：类型转换，如`cast(1 as signed)`
   - 数学：format/round/pow/abs/sin/cos/tan/bit_and
     1. truncate(xx, 2)：保留n位小数
   - 字符串
     1. char/concat/length
     1. instr('x,x,x', xx)：搜索字符串，逗号分隔
     1. locate(xx, 'x,x,x')：搜索字符串，逗号分隔
   - Find_IN_SET：查找通过,分隔的某一个数据
   - 时间
     1. year()
   - 数据处理
     1. distinct去重可能要全表扫描
     1. concat字符串连接
   - 控制流
     1. IFNULL(expr1, expr2)：接受两个参数，如果不是NULL返回第一个参数。 否则返回第二个参数
     1. ISNULL(expr)：如expr 为null，那么返回1，否则返回0
     1. NULLIF(expr1,expr2)：如果expr1=expr2返回NULL，否则返回expr1
   - password
   - UNIX_TIMESTAMP：时间转换为时间戳
   - match：全文搜索
   - uuid()：aaaaaaaa-bbbb-cccc-dddd-eeeeeeeeeeee
   - 修饰符
     1. unsigned
     1. zerofill
     1. variables
#### 库表
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
     1. 认识：性能分析的存储引擎，提供服务器性能表现，可以监视server的执行，v5.5引入，v5.6性能影响很小
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
   - 行
     1. 单表最大值还受主键大小和磁盘大小限制，索引结构只是增加了io次数
   - 列属性
     1. primary key：主键列，作为一行的唯一标识符用来定位，不能重复不能为空，特殊的唯一索引，可有复合主键 `primary key(id,name)`
     1. auto_increment：自增，必须是索引列(index/primary key)，只能有一个自增列，可以设置起始值和步长
     1. unique/not null/default
     1. 时间
        - DEFAULT CURRENT_TIMESTAMP
        - ON UPDATE CURRENT_TIMESTAMP
     1. foreign key：外键列，保证表之间数据完整性和准确性，体现表之间关系，可进行级联操作，由于对业务的强一致性要求，现在由程序控制，不使用外键关联
        - 基本形式：`constraint foreignKeyName foreign key(selfId) references foreignTable(foreignTableId)`
        - 级联限制：`constraint foreignKeyName foreign key(selfId) references foreignTable(foreignTableId) on delete/update cascade;`，删除被连接数据自己也被删除，连带删除
   - 分类
     1. 临时表：只有当前连接可见，关闭连接自动删除，如`create temporary table tableName ();`，show tables看不到该表
        - 系统自动临时表：排序、分组操作中数量超过一定大小后，查询优化器建立的临时表
     1. 派生表：是select返回的虚拟表，即from使用的独立子查询，可以和子查询互换使用。如`from(select * from table2)derivedTableName`
     1. 公共表表达式：CTE，是一个命名的临时结果集，仅在单个SQL语句的执行范围内存在，比派生表更易读，性能更高
   - 表间关系：一对一、一对多、多对多
   - 改变结构
     1. 特性
        - 支持在线DDL
        - 字段类型、字段宽度都会锁表
     1. 大表结构修改
        - 步骤
          1. 建立新表：修改后的结构
          1. 老表数据导入新表，建立触发器同步修改到新表
          1. 数据同步完成后，老表添加排它锁
          1. 重命名老表和新表的名字：重命名之前不需要有锁，很短暂
          1. 删除老表
        - 工具
          1. pt-online-schema-change：`pt-online-schema-change --alter="" --execute`
#### sql
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
    ## lock
    lock tables tableName write/read local;                                                 # 表级锁，锁表的读/写，local允许其他用户表尾添加行
    unlock tables;
    ```
     1. 删除
        - 认识
          1. 不可回滚
          1. 可以减少表空间
        - 组成
          1. drop
             - drop database/table if exists baseName/tableName;                            # 删除库/表，会删除被依赖的约束(constrain)、触发器(trigger)、索引(index)，存储过程/函数保留变为invalid状态
             - drop index indexName on table                                                # 删除索引
          1. truncate table;                                                                # 数据清空，主键归0，其他不变
             - 只能用于表，不会触发触发器
             - 直接删除表再新建，不支持where，比delete快
   - DML
    ```sql
    ## 查询
    select */,/count()/min()/max()/sum()/avg()/median()/rank()/first()/last()/distinct()/concat(,)/truncate(cc,2)
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
    ```
     1. 删除数据
        - 认识
          1. 会走事务，可回滚，可返回删除的条数，会触发触发器
          1. 是一条一条删除，会记录redo和undo日志，不会减少表或索引所占用的空间，下次插入会覆盖，使用optimize会立刻释放磁盘空间
        - delete
          1. delete from table where XX=xx;                                                    # 删除
          1. delete from table;                                                                # 删除所有数据
          1. delete t1,t2 from t1 join t2 on t1.xx=t2.xx;                                      # 多表数据删除
### 基本操作
1. 查询方式
   - 关联查询
     1. 形式
        - inner join：无关系不显示，同join
        - left join：获取左表所有记录，即使右表没有
        - right join：反过来
        - cross join：在mysql中和inner join相同，标准sql中不同，产生笛卡尔集，即M*N
     1. 内连接关系形式
        - 等值连接：on a.id = b.id
        - 不等值连接：on a.id > b.id
        - 自连接：on a1.id = a2.id
   - 组合查询
     1. union：自动处理重合，即去掉重复的数据，以第一个取出的为准
     1. union all：不处理重合，相反，更快
   - 嵌套查询：select * from (select ...);
1. 查询调整
   - 分页：limit 100 offset 517325，这个会查询51万的数据，只保留了你需要的100条，用id>n去实现索引
   - 分组
     1. group by：用列的值进行分组/计算，必须在where之后order by之前，select的字段除了被group的其他要么被统计，要么没有
     1. having：筛选成组后的数据，作用于组，如`having sum(age) > 10`
   - 排序
     1. 常用：`order by xx1 asc/desc xx2 asc/desc/rand()`
     1. 指定顺序：`order by xx asc/desc/rand(), field(xx, '','','') asc/desc/rand()`
     1. 指定条件
        - 如：`order by xx <> 1`，id为1排第一
        - 如：`order by xx not in(x)`
        - 如：
        ```sql
        order by case field
            when '' then 1
            when '' then 2
        end
        ```
     1. 指定其他表的字段：`join xx as x on xx=xx order by x.xx`
   - 数据转换
     1. 时间
        - 格式化时间查询：TIMESTAMP格式的，`DATE_FORMAT(xx,'%m-%d') >= '06-03'`
        - 时间戳
          1. 转为时间戳：`unix_timestamp('2018-01-15 09:45:16');`
          1. 转为时间：` from_unixtime(date, '%Y-%c-%d %h:%i:%s')`
1. 其他
   - checksum：在逻辑备份时候前后可以用于验证数据一致性，`checksum table xxx`
     1. 无关：是否有索引、字符集、引擎类型
     1. 有关：字段顺序
1. 更新
   - replace：是标准sql的mysql扩展，使用primary key/unique key确定是否插入新行
     1. 注意：会抹掉其他未指定数据，应作为插入使用，而不是更新
     1. 原理：将数据插入，成功则结束；否则引发重复键错误，先删除原有记录，然后更新
   - DELAY_KEY_WRITE
     1. 认识：在表关闭之前，将对表的update操作只更新数据到磁盘，而不更新索引到磁盘，把对索引的更改记录在内存，在关闭表的时候一起更新索引到磁盘
        - 使索引更新更快
        - 重启或掉电会导致索引没更新，启动参数加上--myisam-recover
     1. 操作：`ALTER TABLE xxx DELAY_KEY_WRITE=1`
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
### 功能
#### 索引
1. 认识：为加快查询速度，对数据列进行排序的一种结构，包含所有记录的引用指针，查询时先查索引，引擎实现
   - 加快查询速度，加快排序，加快分组，大大减少需要检索的数据
   - 避免排序和临时表，将随机io变顺序io
   - 需要维护索引表，降低写入更新速度，增加查询优化器选择时间，占用磁盘
   - 3层索引3次io对应2500w行~1亿行(看行大小)，是合理的
   - 处于存储引擎层，不是server层
1. 分类
   - 根据类型
     1. 聚集索引：主键、聚簇索引，叶子节点包含所有数据，还存储下一个叶子节点的指针
     1. 非聚集索引：二级、非聚簇索引，只存放主键id和当前索引的数据，有二次查询问题(获取本普通索引之外的数据需要找到主键id，然后去主键索引上拿数据)
   - 根据属性
     1. Hash
     1. btree
     1. full-text：全文索引，倒排索引实现
1. 使用场景
   - 非常小的表：全表扫描效率更高
   - 中大型：索引非常有效
   - 特大型：索引代价增长，使用分区
1. hash
   - 认识：基于hash表实现，只能精确匹配。只需一次定位检索效率很高，不像btree需要多次io跑节点
     1. InnoDB的hash索引是根据使用情况自己建立的，又称自适应hash索引
     1. 需要进行二次查找，hash索引没有存储字段值
     1. 在任何时候都不能避免表扫描：由于hash冲突的存在，还是需要回表对实际数据进行比较
   - 特点
     1. 检索效率比btree高，数据量多hash碰撞大时，效率也不高
     1. 不能范围查找，不能使用前缀索引查询，不能排序，只能等值查询`=、in、<>`
1. btree
   - 认识
     1. 大小限制：InnoDB 767byte，MySIAM 1000byte，整型、浮点型、日期足够了
   - 特性
     1. 选择性原则：不重复的索引值和总数的比值。范围0~1，选择性越高查询效率越高，提高查询速度，节省空间和io。唯一索引的选择性是1性能最好。区分度公式COUNT(DISTINCT col)/COUNT(*)
     1. 最左前缀原则：组合索引只会从左边开始按照索引搜索，如果检索条件没有最左的，那么就不会使用到索引，因为不知道去哪儿开始找
     1. 5.0以前查询只能使用一个索引，会选择限制最严格的那个索引：where用了order没法用，只有order的字段在where中才会用，之前可以使用多个独立索引
     1. 有null的列不会包含在索引中
     1. not in和<>无法使用索引
   - 特点
     1. 表只有一个主键索引，可有多个唯一索引
     1. key和index都是索引，为兼容其他系统，key多了一层约束层含义
     1. 使用了索引：意思是使用索引的快速搜索功能，有效的减少了扫描行数。对应的有全索引扫描，是不够快的
     1. 是顺序存储的，很适合范围查找
     1. 索引也可以用于排序
1. 分类
    ```sql
    key/index               # 普通索引
    key(,)                  # 组合索引
    column(n)               # 前缀索引，鉴于选择性原则，通过select left(column,n)不断增加n查看重复行的减少制定合适的前缀长度以达到最佳查询效果。无法order、group、覆盖扫描

    unique key              # 唯一索引，可组合多个列。具有唯一性约束，除了BDB外允许重复NULL
    primary key             # 主键索引，特殊的唯一索引，不能重复，不为null

    foreign key             # 外键索引，保证数据一致性、完整性，实现级联操作
    fulltext                # 全文索引，用于文本搜索，仅MySIAM，仅用于char/varchar/text，仅英文
    spatial                 # 空间列，值不为null
    ```
#### 事务
1. 事务
   - 认识：是区别文件系统的重要特征，是一组sql语句，用于保证一致性
     1. 由引擎层实现
     1. 不支持嵌套事务：再开启一个事务会隐式提交上一个事务
     1. 一个事务中使用多引擎不靠谱
     1. 主要是mvcc+一些读写锁实现，纯读写锁是上世纪780年代的事情
   - 常见问题
     1. 读顺序：Trx_id解决
     1. 故障恢复：未完全恢复的时候，依然不能被外部看到
     1. 死锁：使用轻量级锁、碰撞检测、等锁超时
   - 常见事务单元
     1. 添加一个索引
     1. 读取一行记录
     1. 写入一行记录，同时更新索引
     1. 删除整张表
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
1. 事务的特性：ACID
   - 原子性：Atomicity，一个事务是一个整体，所有操作要么全部成功，要么全部失败。只保证回滚到之前就行，和一致性没有关系，原子性不关心并发事务时回滚导致的其他数据误覆盖
   - 一致性：Consistency，所有操作在任何时候都保证一致，成功后所有操作才可见，如唯一索引回滚后不能有重复键
   - 隔离性：Isolation，一个事务的修改最终提交前对其他事务不可见，也不会互相影响
   - 持久性：Durability，一旦事务提交，则其所做的修改就会永久保存到数据库中。此时即使系统崩溃，修改的数据也不会丢失
1. 隔离性的隔离级别
   - 认识：用于解决并发事务的问题，并发本身和保证数据正确的"串行化"是矛盾的，用隔离级别平衡隔离和并发的矛盾，是对读写锁的使用
     1. 是sql 92的标准，隔离性的扩展有了快照级(mvcc)
   - 隔离级别：由低到高
     1. Read Uncommitted：未提交读，会导致数据完整性的严重问题
        - 3种问题都存在，可能读到写过程中的数据
        - 只加写锁，读不加锁
        - 读读并行、读写并行、写读并行，写写串行
     1. Read Committed(RC)：读已提交，读取自身版本和最新版本，以最新为主，不加锁读，本事务中可以看到其他事务提交的数据
        - 避免脏读，导致不可重复读、幻读
        - 读锁能被写锁升级，读写并行(写读不行)
     1. Repeatable Read(RR)：可重复读，默认，事务开始后其他session对数据库的修改在本事务中不可见，只针对修改不针对插入，对读和读的范围加锁，新的满足查询条件的记录不能够插入(间隙锁)
        - 避免脏读/不可重复读/幻读
        - 读锁不能被写锁升级，读读并行
     1. Serializable：序列化，事务串行化顺序执行，从mvcc并发控制退化为基于锁的并发控制，读写会冲突，并发度急剧下降并增加死锁机率
        - 避免脏读/不可重复读/幻读
     1. Snapshot isolation：快照
   - 对应的问题
     1. 更新会相互覆盖从而丢失数据
     1. 脏读：A看到了B没commit的数据
     1. 不可重复读：本事务中可以看到其他事务提交的数据，或者读到自己事务内写前后不一的数据
     1. 幻读：A没commit查范围数据时，会受到B新插入数据的影响，前后不一样
   - 实现原理
     1. 读数据前加锁
     1. 一致性数据快照：MVCC
1. 持久性的保证
   - 丢失的原因
     1. 磁盘损坏
     1. 内存易失：刷盘
#### 锁
1. 锁
   - 特点
     1. 行锁基于索引项加锁实现，只有通过索引条件检索数据，InnoDB才使用行级锁，否则，InnoDB将使用表锁
     1. 目前处理死锁的方法是：将持有最少行级排它锁的事务回滚
     1. 并发抢锁的休眠时间应该为范围随机，防止多次争抢
   - 概念
     1. 悲观乐观的选择：数据争抢更严重的用悲观
     1. 加锁方式
        - 悲观锁
          1. 理解：Pessimistic Locking，读取的时候为后面的更新加锁，之后再来的读写都会等待，属于数据库的锁
             - 每次取数据时都认为其他线程会修改
          1. 意义：数据修改排他性，高并发下，数据可以正确写入。但带来数据库性能的大量开销，影响并发访问性，特别是长事务
        - 乐观锁
          1. 理解：Optimistic Locking，乐观并发控制。基于数据版本记录机制或CAS操作实现
            - 每次去取数据的时候总认为不会有其他线程对数据进行修改
          1. 优缺点：程序实现，不会存在死锁。但是阻止不了程序之外的数据库操作
          1. 乐观锁的并发方案：让版本低的并发更新回滚，并发低时性能好，并发高时失败率高
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
     1. U锁：查看一个事务中是否有写，有写就将操作同一数据的读锁直接提升为写锁，防止读写读写交叉的死锁，属于细微的极致优化
     1. 最佳实践
        - 通常来说，死锁都是应用设计的问题。死锁的关键在于两个(或以上)的Session加锁的顺序不一致
        - 如果并发查询多个表，约定访问顺序
        - 批量处理数据时事先对数据排序，保证每个线程按固定顺序处理记录，也可以大大降低出现死锁的可能
        - 在同一个事务中，尽可能做到一次锁定获取所需要的资源，不要先共享锁，再排它锁
        - 小事务发生锁冲突的几率也更小
     1. 处理方案
        - 尽可能不死锁：使用轻量级锁
        - 碰撞检测：性能高成本低
        - 等锁超时
   - 锁类型
     1. 死锁：两个或两个以上争夺资源而相互等待，若无外力将无法推进，导致异常
     1. 活锁：不会阻塞执行，但也不能继续执行，需要一直重复，可能会成功，会降低执行效率，引入随机性解决
        - 像两个过于礼貌的人在路上相遇，彼此让路，然后在另一条路上相遇，然后一直循环
     1. 饥饿：可运行进程能继续执行，但被调度器无限期忽视，而不能被执行，通过计数取样解决
#### 其他
1. 预解析
   - 理解：使用占位符预先准备查询语句，不用解析语句，查询速度更快，防止注入。步骤有：prepare、execute、deallocate prepare(发布)
   - 实例
    ```sql
    PREPARE stmt1 FROM 'select ... ?';          # 准备占位符

    SET @a = '1';
    EXECUTE stmt1 USING @a;

    DEALLOCATE PREPARE stmt1;
    ```
1. 分区
   - 认识：将一个表或索引分解为多个更小的部分，v5.1新增，v5.6支持分区交换
     1. 每个分区都是可以独立处理的对象，也可作为更大对象的一部分进行处理
     1. 只支持水平分区
     1. 是局部分区，既存放数据又存放索引，不支持全局分区(索引独立)
   - 分区交换
     1. 认识：将某个分区的数据交换、移动到其他列属性都一样的表中
        - InnoDB、MyISAM、NDB支持
     1. 要求
        - 要有相同结构
        - 未分区表中的记录必须要在另一表的分区或子分区范围内
        - 交换表中不允许有外键
     1. 分类
        - Range：根据范围
        - List：匹配集合中的
        - Hash：根据给定表达式的计算结果
        - Key：类似hash
     1. 操作
        - 创建
            ```sql
            create table xx (
                id int
            ) engine=innodb
            partition by range (id) (
                partition p0 values less than (10),
                partition p1 values less than (20)
            );
            ```
        - 删除：`alter table xxx remove partition`
        - 交换：`alter table xxx1 exchange partition xx with table xxx2`
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
### 实践
#### 设计实践
1. 范式
   - 认识：为了消除重复数据，更高一级的范式要求先满足下边的范式。涉及数据库理论研究
   - 三范式
     1. 组成
        - 1NF：原子性，属性不可再分解
          1. 要根据具体情况判断是否可以再拆
        - 2NF：惟一性，不存在部分依赖，要求其他字段都依赖于主键。如学号、课程号、姓名、学分中学分依赖课程，但不依赖学号，产生了部分依赖
          1. 数据冗余：修改时需要同时修改多条记录
          1. 删除异常：删除学分，课程号也删除
          1. 插入异常：学生未选课，学分无法记录
        - 3NF：冗余性，不存在传递依赖，要求字段没有冗余。如学号, 姓名, 学院名称, 学院电话，有传递依赖
          1. 数据冗余：修改时需要同时修改多条记录
     1. 特点
        - 没有冗余、表更新快体积小、操作更快
        - 查询需要多表关联，导致性能降低，更难进行索引优化
   - 反范式化：没有冗余的数据库未必是最好的数据库，有时为了提高运行效率，就必须降低范式标准，适当保留冗余数据，达到以空间换时间的目的
1. 结构优化策略
   - 要考虑使用时的场景进行设计
1. 查询优化策略
   - 优化包含not in和<>的子查询：将`select xx NOT IN (select xx)`优化为`LEFT JOIN xx WHERE b.xx IS NULL`
1. 索引优化策略
   - 查询
     1. 索引列上不能使用表达式或函数：无法使用索引了
     1. 字符串字段使用前缀索引
     1. 索引列的选择性：选择区分度高的，尤其是前缀索引
     1. 联合索引和左右顺序：经常用到的优先，区分度高的优先，数据宽度小的优先
     1. 特定情况下使用hash索引优化查询
     1. 降低重复的索引：如单列和联合最左字段重复
   - 排序：explain中type为index就是用到了
     1. 索引的列顺序和order by子句顺序完全一致
     1. 索引中所有列的方向(升降序)和order by子句完全一致
     1. order by中的字段全部在关联表中的第一张表中
   - 锁：减少锁定的行数
   - 维护
     1. 查找未被使用过的索引
        ```sql
        SELECT object_schema, object_name, index_name,b.`TABLE_ROWS`
        FROM performance_schema.table_io_waits_summary_by_index_usage a
        JOIN information_schema.tables b ON
            a.`OBJECT_SCHEMA`=b.`TABLE_SCHEMA` AND
            a.`OBJECT NAME`=b.`TABLE NAME`
        WHERE index_name IS NOT NULL AND count star = 0
        ORDER BY object_schema, object_name;
        ```
     1. 更新索引统计信息、减少索引碎片
1. 事务优化策略
   - 减少锁的范围
   - 允许更多的并行
   - 选择正确的锁类型
1. 设计和使用
   - 数据类型
     1. 尽量使用更简单的类型，数据长度越短越好(更少存储内存空间)
     1. 长数字使用string
     1. 用枚举代替常用字符串类型
     1. 尽量用timestamp，比datetime效率高
     1. 给文本字段留足余量
     1. 不能为null
     1. 日期
        - 不要用字符串，一是不好查，二是不支持时间函数
        - 使用int不如直接使用timestamp
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
     1. 事务执行成本很高，50万事务需要执行2分钟
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
     1. 日志文件和数据文件放在不同的磁盘分区上，获得额外性能提升，也不至于一方占满空间另一方无法使用
     1. 由于MySQL是单进程多线程模型，一个SQL语句无法利用多个cpu core去执行，这也就决定了MySQL比较适合OLTP（特点：大量用户访问、逻辑读，索引扫描，返回少量数据，SQL简单）业务系统，同时要针对MySQL去制定一些建模规范和开发规范，尽量避免使用Text类型，它不但消耗大量的网络和IO带宽，同时在该表上的DML操作都会变得很慢
        - 请求日志写本地log，然后用filebeat抽取到es
        - 图片、文本等扔了oss
        - 复杂统计分析类的SQL放了ck中
1. 使用规范
   - 建库、表
     1. 建表语句必须在sql审核平台审核通过，不然不予以创建，审核地址：http://app.xesv5.com/zeus
     1. MYSQL引擎默认使用InnoDB 使用其他引擎需要特别说明
     1. 字符集使用 utf8mb4 排序规则使用utf8mb4_general_ci
     1. `id` int(11) NOT NULL AUTO_INCREMENT 作为第一个字段，且为主键，有自增属性
     1. 所有类型的字段均有NOT NULL属性，有默认值，不使用保留字（关键字），text和json两种类型因无法设置默认值，因此不需要NOT NULL属性
        - 必须有中文说明 时间类型字段的默认值遵循此类型的范围                          
          1. datetime	0001-01-01 00:00:00	9999/12/31 23:59
          1. timestamp	1970/1/1 8:00	2038/1/19 11:14
          1. date	1000-01-01	9999/12/31
     1. 尽可能不要使用text,blob类型，如果必须使用，不要设置not null属性，不指定DEFAULT。
     1. 不要在数据库中使用varbinary或blob存储图片及文件，mysql 并不适合大量存储这类型文件
     1. 表注释部分要说明此表作用和建表人 例如：COMMENT='课程内容信息-建表人名'
     1. 如果使用分表，表名内有明确的标识作为后缀
     1. 不使用外键，触发器，函数，存储过程，事件
     1. 单表建议控制在5000万以内,文件大小不超过20G
     1. 普通索引命名规则: idx_索引名称 例:KEY `idx_channel_type` (`channel_type`)
     1. 唯一索引命名规则: uniq_索引名称 例：UNIQUE KEY `uniq_email` (`email`)
     1. 不要使用char类型，以varchar代替
   - 索引规范
     1. 单张表的索引数量不超过5个
     1. 复合索引字段数不超过5个
     1. 对长字符串使用前缀索引，前缀长度不超过8个字符
     1. 对特殊字段，增加crc32或md5的伪列并建立索引
     1. 尽量复用联合索引，避免冗余索引
     1. 不在低基数列上建立索引，例如“性别”
     1. UPDATE,DELETE语句的WHERE条件列必须使用索引
   - SQL规范
     1. 通用实例的SQL必须在SQL审核平台确认
     1. 不使用%前导的查询，尽量优化负向查询此类查询不能使用索引例如like “%abc”, not in，!= ，not like, <>
     1. SQL的返回结果尽量少，合理使用分页展示
     1. 注意字段的类型，避免隐式转换即字符型字段的值需要加单引号，数值型不加
     1. 避免使用大表的JOIN，将大SQL拆分成小SQL、OLTP类型SQL建议优化到0.05秒以内、OLAP类型在从库查询，查询最大时间为600秒
     1. 避免在数据库中进行数学运算
     1. 写入大量数据时，必须使用一个insert多个values的形式，一个insert的写入量需小于10000行数据，循环执行，有两秒的间隔
     1. 删除、更新、或查询大量数据时，where 条件必须加上id范围，每次操作1万到2万行，循环执行，且有1秒的sleep时间。例如：where id > 0 and id < 10000
     1. 不在业务高峰期批量写入、更新、删除
     1. 禁止联库查询
     1. 禁止使用 SELECT * 查询### 维护
1. wiki
   - 大表
     1. 定义：一般是超一千万行，大小超10G
     1. 风险
        - 慢查询
        - DDL操作
          1. 建索引：v5.5之前锁表，之后不锁表但主从延迟，修改时间是要double的
   - 大事务
     1. 定义：运行时间较长、操作数据较多的事务
     1. 风险
        - 锁定太多数据，造成大量阻塞、锁超时
        - 容易主从延迟
        - 回滚时间长
     1. 解决
        - 避免一次操作太多数据
        - 移除不必要的sql
#### 优化实践
1. explain
   - 理解：sql语句分析，将过程和索引等信息列出来
   - 使用解析
     1. select_type：查询类型
        - simple
        - primary
        - union
        - subquery
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
1. 实时获取性能问题sql：`select id,user,host,db,command,time,status,info from information_schema.PROCESSLIST where time >= 60`
1. sql度量
   - 获取查询各个阶段的时间花销：推荐用performance_schema代替
     1. 包含的指标
        - starting
        - checking permissions
        - Opening tables
        - init
        - System lock
        - optimizing
        - statistics
        - preparing
        - executing
        - Sending data
        - end
        - Hesinendables
        - freeing items
        - logging slow query
        - cleaning up
     1. performance_schema实操
        ```sql
        SELECT a.THREAD_ID, SQL_TEXT,c.EVENT_NAME,(c.TIMER_END - c.TIMER_START)/1000000000 AS 'DURATION (ms)'
        FROM events_statements_history_long a
        JOIN threads b ON a.'THREAD_ID'=b.'THREAD_ID'
        JOIN events_stages_history_long c ON c.'THREAD_ID'=b.`THREAD_ID`
        AND c.'EVENT_ID' BETWEEN a.EVENT_ID AND a.END_EVENT_ID
        WHERE b.'PROCESSLIST_ID'=CONNECTION_ID()
        AND a.EVENT_NAME= 'statement/sql/select'
        ORDER BY a.THREAD_ID,c.EVENT_ID
        ```
     1. profiling实操
        ```sql
        set profiling = 1;                      # 开启记录，是一个session级的配置
        ...                                     # 执行查询
        show profiles;                          # 总时间
        show profiles for query N;              # 查询详细时间
        show profiles cpu for query N;
        ```
#### 使用实践
1. 一些场景
   - 查询这个数据是否存在，存在则存到另一张表里：`create table temp as select * from admin a where exists (select uid from user u where a.userName = u.account);`
   - 查询两张表中是否有相同数据：`select * from admin where uid IN(select uid from temp);`
   - 求差集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx WHERE B.id IS NULL union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx WHERE A.id IS NULL;`
   - 求全集：`SELECT * FROM A LEFT JOIN B ON A.xx = B.xx union SELECT * FROM A RIGHT JOIN B ON A.xx = B.xx;`
   - 原所有id增加5万，必须倒叙操作：`update user SET uid=uid+50000 order by uid desc;`
   - 插入不重复数据行，mysql特有不是标准sql语法：`INSERT token(udid) values ('{$udid}') ON DUPLICATE KEY UPDATE activetime ='{$time}'`
1. 分表分区
   - 认识
     1. 分区：对用户透明，底层分为多个物理分区。用partition by定义每个分区存放的数据，优化器自动使用。适用于数据多，只在表最后有热点数据，其他都是历史数据。分区可以分布在不同机器上独立维护，有很多功能不能用
        - 存储更多数据：可分布在不同的物理设备
        - 优化查询：where语句中包含分区条件时，只会使用某几个分区
        - 类型：RANGE、LIST、HASH、KEY
          1. 两级映射：指定id范围和表的关系，不够了加关系就行，可通过中间件实现
        - 适用于所有数据和索引，两者不能分开
     1. 分表：可以将两种方式结合使用
        - 水平拆分：用于数据本身有独立性，可以拆分，逻辑分层算法无法变更，关键字段取模方式拆到多个表中，降低单表大小
        - 垂直拆分：把属性较多、数据较大的表某些字段拆分到不同的表中，查询时可减少io次数，但是应用增加复杂度。分主表、扩展表。因为数据库的内存buffer存row
     1. 分片
        - 方式
          1. 分片键的hash取模
          1. 分片键范围划分
          1. 时间跨度（年、月、日）分片
          1. 分区键和分片映射表分配
        - 如何生成全局唯一id
          1. 分配auto_increment_increment和auto_increment_offset参数
          1. 全局id生成节点
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
### 运维
#### 基本
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
     1. mysqld_safe：是mysqld的守护进程，在启动服务后继续监控，并在死机时重新启动
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
   - 参数设置：![avatar](../images/mysql_params.jpg)
1. 连接方式
   - tcp/ip套接字：`mysql -h127.0.0.1`
   - 域套接字：`mysql -S /tmp/mysql.sock`
   - 命名管道、共享内存：通过配置开启
#### 性能和调优
1. 性能表现
   - 4核8G的机器MySQL5.7大概支撑500的TPS和10000的QPS
1. 影响性能的方面
   - 硬件、系统
     1. 主数据库用RAID10做保障，从用RAID0、RAID5节省成本，注意5磁盘损坏性能的大幅下降
     1. san/nas等网络存储设备：数据库需要大量随机io他们不是优势，一旦出问题需要厂商协助恢复时间长，可以作为备份使用
     1. 足够的内存可以将随机io变为顺序io，把多次写变为一次写
   - 系统参数、数据库参数、存储引擎
   - 表结构、索引、sql
1. 调优
   - 硬件
     1. cpu：区分oltp和olap
     1. 内存：大内存性能线性提高
     1. ssd
     1. RAID
   - 参数
     1. Innodb_buffer_pool
     1. Innodb_buffer_pool_instances
     1. innodb_flush_log_at_trx_commit
     1. binlog-format
     1. transaction-isolation
     1. sync_binlog
   - 单表不能超过20G
   - 慢查询
     1. 认识：记录超过一定时间的查询的修改的已经回滚的sql，获取有性能问题的sql
     1. 配置
        ```conf
        slow_query_log = ON                                         # 开关，可通过脚本更加自动化控制
        slow_query_log_file = /usr/local/mysql/data/slow.log        # 指定路径，默认存在mysql数据目录中，日志和数据分区存储更好
        long_query_time = 1                                         # 阈值，单位秒，默认10
        ```
     1. 工具
        - mysqldumpslow：可筛选，`mysqldumpslow -s -r -t 10 xx.log`
        - pt-query-digest：可查询通用、二进制、慢查询日志，报告更加详细，可直接查看查询计划(explain的结果)
   - 查询优化：以下三者需要齐头并进才有效果
   - 索引优化
   - 库表优化
     1. analyze table：分析表
        - 对表的cardinality（散列程度）进行统计和更新，重新生成表统计信息。因为它决定是否走索引，如果cardinality和实际数据严重不符，会导致查询优化器做出错误判断，引起索引失效
        - MySIAM会存储在磁盘中，进行全索引扫描，会添加只读锁，不能新增和修改数据
        — InnoDB通过随机索引访问并将结果存储在内存中，虽然不太准，但是不锁表
     1. check table：检查表
        - 检查表的错误和索引
     1. optimize table：优化表
        - 只能优化varchar、blob、text，会优化表和索引的碎片、空洞
        - 会添加只读锁，不能新增和修改数据
1. 参数
   - mysql
     1. 命令行、配置文件
     1. 全局参数、会话参数
     1. 内存
        - mysql自身运行的占用：无法控制
        - 最大使用内存
          1. 32位系统无法超过3G
          1. 超过物理内存造成内存溢出
        - 每个连接的使用内存
          1. sort_buffer_size：排序缓冲区大小，需要排序时不管实际用多少全部占用
          1. join_buffer_size：连接缓冲区大小，每关联一个表就分配一个
          1. read_buffer_size：MySIAM表全表扫描的读缓冲区大小，不管大小全部占用，得是4k倍数
          1. read_rnd_buffer_size：索引缓冲区大小，只会分配需要的大小，不是参数指定的大小
        - 操作系统
          1. 独占一台物理机，不要多实例混部，也不要混合其他服务，避免资源争用
        - 缓冲池
          1. innodb_buffer_pool_size：innodb缓冲池大小，对性能非常重要，要缓存索引、数据、自适应hash索引、插入缓冲、锁、其他内部数据结构，还帮助延迟顺序写入，要分配足够的内存大小，重启才能更改，太大了重启慢需要刷脏页，总大小 = 每个线程需要的内存 * 连接数 - 系统保留内存
          1. key_buffer_size：MySIAM的索引缓冲，因为系统表还在用MySIAM
     1. io：性能和安全的取平衡
        - innodb_log_file_size/innodb_log_file_in_group：事务日志大小的单个和个数，即redolog的，事务日志总大小为二者相乘，事务日志是循环写入的，配置多个是没有意义的，业务忙设置大些，一般记录一个小时的信息
        - innodb_log_buffer_size：日志缓冲区大小，能够保留至少一秒的事务就够，32M~128M
        - innodb_flush_log_at_trx_commit：事务日志的刷新频繁程度，和innodb_log_buffer_size搭配的
        - innodb_flush_method = O_DIRECT：flush的方式，会影响读写，这个通知操作系统不要预读也不要缓存，读写通过存储设备完成，避免操作系统和innodb的双重缓存，linux的最好选择
        - innodb_file_per_table = 1：指定innodb为每个表建立表空间，否则放入系统表空间，强烈建议开启
        - innodb_doublewrite = 1：是否开启双写缓冲，防止没有写完整导致的数据损坏，一个页默认16k，建议开启，性能影响不大
        - delay_key_write OFF：延迟键写入，每次写操作后刷新键缓冲中的脏块到磁盘，OFF最安全，ON只对建表时指定的生效，ALL所有MySIAM都使用。如果服务器崩溃内存中脏块没写回，就需要对MySIAM修复
     1. 安全
        - expire_logs_days：自动清理binlog的天数，防止占用太多空间，应该至少覆盖两次全备间隔的天数
        - max_allowed_packet：mysql可以接收的包大小，同时影响用户定义的变量容量，主从应该一致否则同步失败，如32M
        - skip_name_resolve：禁用dns查找，加快访问速度，用户授权只能使用ip了
        - sysdate_is_now：确保sysdata()返回确定性日期，建议设置，否则基于段的主从复制的不一致导致中断
        - read_only：禁止非super的写权限，建议从库指定，保证主从一致
        - skip_slave_start：禁用slave自动恢复，崩溃后自动恢复不安全
        - sql_mode：sql模式，默认比较宽松，改了可能现在的程序无法运行
          1. strict_trans_tables：如果数据无法插入到事务型引擎中会中止操作，非事务不影响
          1. no_engine_subtitution：如果引擎不可用也会建立不成功，否则使用默认引擎，确保使用想要的引擎
          1. no_zero_date：不能写入小于0的日期
          1. no_zero_in_date：不接受部分为0的日期
          1. only_full_group_by
     1. 服务器
        - sync_binlog：控制什么时候磁盘刷新binlog，建议为1，避免主崩溃，cache日志没有同步到从中，就会很难恢复
        - tmp_table_size/max_heap_table_size：控制内存临时表大小。隐式的超过后转为磁盘临时表，不要太大防止内存溢出
        - max_connections：最大连接数，一般为3000或更大
     1. 数据库设计
        - 过分的反范式化设计，建立太多列
        - 过分的范式化设计，太多的表关联
        - oltp使用分区表，分区还是olap中使用
        - 使用外键
   - 内核
     1. 配置文件：`/etc/sysctl.conf`
     1. 网路
        - net.core.somaxconn：65535，socket listen的backlog上限，监听队列每个端口最大的长度
        - net.core.netdev_max_backlog：65535，当个别接口接收包的速度快于内核处理速度时允许的最大的包数量
        - net.ipv4.tcp_max_syn_backlog：65535，还未获得连接的请求的最大数量，超出被抛弃
        - net.core.netdev_budget：每次软中断处理的网络包个数
        - net.ipv4.tcp_max_tw_buckets＝5000：同时保持TIME_WAIT套接字的最大数量

        - net.ipv4.tcp_fin_timeout：10，tcp等待超时时间，加快tcp连接回收速度，适用于大量tcp连接的系统
        - net.ipv4.tcp_tw_reuse：1，
        - net.ipv4.tcp_tw_recycle：1，

        - net.core.wmem_default：87380，tcp接收和发送的缓冲区大小和默认值，应该大一些
        - net.core.wmem_max：16777216
        - net.core.rmem_default：87380
        - net.core.rmem_max：16777216

        - net.ipv4.tcp_keepalive_time：120，发送keepalive的时间间隔(秒)，用于确认tcp是否有效，应该小一些
          1. 减少tcp失效连接占用系统资源的数量，加快资源回收效率
        - net.ipv4.tcp_keepalive_intvl：30，消息未获得响应时，重发该消息的间隔，秒
        - net.ipv4.tcp_keepalive_probes：3，认定tcp失效前最多发送多少keepalive消息
     1. 内存
        - kernel.shmmax=4294967295：定义单个共享内存段的最大值，应该足够大，能容下整个InnoDB缓冲池的大小，过低需要创建多个共享内存段，性能下降
          1. 可取最大值为物理内存值-1byte，建议为一半，一般大于InnoDB缓冲池即可
        - vm.swappiness=0：除非虚拟内存全部占满，否则不用内存交换分区
          1. 一旦发生内存交换，性能巨大影响。禁用临时需要大内存时一降低系统性能，二容易造成内存溢出、崩溃、被系统kill
   - 资源限制
     1. 配置文件：`/etc/security/limit.conf`，重启生效
     1. 文件打开数
        ```
        soft nofile 65535   # * 所有用户生效，soft 当前系统生效
        hard nofile 65535   # hard 系统中所能设定的最大值
        ```
   - 文件系统
     1. 选择：window选ntfs，linux选xfs
     1. 参数
        - ext3/ext4：最佳实践`/dev/sda1/ext4 noatime,nodiratime,data=writeback 1 1`
          1. data
             - writeback：最快
             - journal：最慢先写日志，innodb不需要
             - ordered
          1. noatime/nodiratime：不记录文件和文件夹读取的时间，加快磁盘速度
   - 磁盘调度策略
     1. 配置
        - 文件：`/sys/block/devname/queue/scheduler`
        - 设置：`echo deadline /sys/block/sda/queue/scheduler`
     1. 分类
        - cfg：公平调度
        - noop：电梯式，实现了FIFO队列，像电梯的工作方式对io进行组织，新请求到来合并到最近的请求之后保证请求同一介质，倾向饿死读而利于写。对内存、嵌入式最合适
        - anticipatory：预料io调度式，本质和deadline一致，最后一次读后等待6ms才对其他io调度，每个6ms插入新io操作，合并为大写入流，用写入延时换取最大吞吐量，适合写入较多，如文件服务器，数据库性能会很差
        - deadline：截止时间式，确保一个可调整的截止时间内的请求，默认读期限小于写，防止了写因为不能被读取而饿死，是数据库类最好的选择
#### 监控
1. 监控
   - 性能测试：数据多才有参考价值，数据总量超过内存总量，如几百条数据第一条命令下去就全部加载到内存了，没有参考意义
   - 性能：连接数、qps
     1. `show status like 'Threads%';`：查看连接数
     1. `show processlist;`：查看所有连接
     1. `show variables like '%connect%';`：查看连接的配置
   - 硬件：主频高处理快高吞吐低时延，L1/2/3的cache大速度快，内存大磁盘读写少TPS高，固态快机械配阵列卡，网卡好低时延
     1. 更大内存、更快磁盘：比业务服务器要求高
   - 指标
     1. qps：select、delete、insert、update，物理机qps30000，tps10000，虚拟机qps5000，tps1000
     1. sort
        - sort_range：使用范围完成的排序数
        - sort_rows：排序的行数，sort_merge_passes：排序算法必须执行的合并传递的数量。 如果此值很大，则应考虑增加sort_buffer_size系统变量的值。
        - sort_scan：通过扫描表格完成的排序数量
     1. thread：单用户2000，单实例5000
        - conneted
        - cached
        - created
        - running
     1. threadpool_used_percent：连接数占比
     1. seconds_behind_master：主从延迟
     1. slave_status：slave_io_running，从库IO线程状态
     1. innodb_rows：每秒增删改查的行数
     1. innodb_row_lock
        - innodb_row_lock_waits：等待行锁的总次数
        - innodb_row_lock_time：等待行锁的总时间
     1. mysql_locks
        - table_locks_immediate：申请时立刻获得表锁次数
        - table_locks_waited：申请表锁时等待的次数
     1. mysql_handler
        - Handler_commit：内部提交语句数
        - Handler_delete：请求从表中删除行的次数
        - Handler_read_prev：按照键顺序读取一行的请求数。该方法主要用于优化Order By DESC
        - Handler_read_rnd_next：在数据文件中读下一行的请求数，如果你正在进行大量的表扫描，该值较高。同城说明你的表索引不正确或写入的查询没有利用索引。
        - Handler_read_last：根据键读最后一行的请求数
        - Handler_read_first：索引中第一条被读的次数。如果较高，建议服务器正执大量全索引扫描。例如 SELECT col1 From foo 假定col1有索引
        - Handler_read_next：按照键顺序读取下一行的请求数。如果你用范围约束或如果执行搜索扫描来查询索引列，该值增加
        - Handler_update：请求更新表中一行的次数
        - Handler_read_rnd：根据固定位置读一行的请求数，如果你正执行大量查询并需要对结果进行排序该值较高。你可能使用了大量需要MySQL扫描整个表的查询或你的连接没有正确使用索引
        - Handler_write：请求向表中插入一行的次数
     1. innodb_pages 
        - innodb_pages_created：buffer pool创建页的数
        - innodb_pages_read：从buffer pool中读取的页数
        - innodb_pages_written：写buffer pool的页数
     1. innodb_bytes
        - bytes_sent：发送给所有客户端的字节数
        - bytes_received：从所有客户端接收的字节数
     1. innodb_buffer_pool_bytes
        - buffer_pool_bytes_data：buffer pool中数据页的大小
        - buffer_pool_bytes_dirty：buffer pool中脏页的大小
     1. innodb_buffer_pool_pages
        - buffer_pool_pages_misc：用于存储行锁，自适应哈希索引等信息的管理层的页数
        - buffer_pool_pages_free：buffer pool中空闲的页书目
        - buffer_pool_pages_made_young：标记为young的页数目
        - buffer_pool_pages_old：在buffer pool LRU old段的页数
        - buffer_pool_pages_flushed：请求flush pages的次数
        - buffer_pool_pages_total：buffer pool包含的总页数
        - buffer_pool_pages_data：buffer pool包含数据的页数(包括dirty和clean页)
        - buffer_pool_pages_made_not_young：进入buffer pool后未被标记为young的页数
        - buffer_pool_pages_dirty：buffer pool中脏页数目
     1. innodb_data
        - data_written：innodb写入的总数据量，单位字节
        - data_writes：innodb数据写入的总次数
        - data_fsyncs：innodb进行fsync的次数
        - data_read：innodb读取的总数据量
        - data_reads：innodb数据读取的总次数
     1. mysql_innodb_log
        - innodb_os_log_fsyncs：调用fsync() writes写redo log的次数
        - innodb_log_waits：log buffer 空闲空间不足，必须等待其被写入所造成的等待数
        - innodb_log_write_requests：写redo log的请求次数
        - innodb_log_writes：redo log的物理写次数
        - innodb_os_log_written：写入redo log的bytes
     1. cardinality是索引中不重复记录的预估值，会有更新机制，不准，很小需要评估索引是否有意义
1. 监控
   - 方面
    1. 数据库服务可用性
      1. 主从复制
         - 状态：`Slave_IO_Running`、`Slave_SQL_Running`，都是yes主从才正常
         - 延迟
           1. `show slave status`：Seconds_Behind_Master这个不准确，因为是按照从执行时间减去主执行的时间，假如主阻塞很久但从都消费完了，则表现为无延迟
           1. 正确的：需要多线程程序同时检查主从的binlog偏移量
         - 数据一致性：主上执行，可以自动发现所有的从，并验证数据是否一致。`pt-table-checksum u= p= --database xx --replicate test.checksums`
      1. 是否可连接：`mysqladmin -u -p ping`、`telnet ip port`
      1. 是否可读写：`read_only=off`、简单监控表的更新测试、简单查询`select @@version`
    1. 数据库性能
      1. 服务器资源监控
        - cpu
        - 内存
        - 磁盘空间使用率
        - iops
        - 网络流量
        - 会话连接数：Threads_connected / max_connections > 0.8
          1. `show variables like max_connections`
          1. `show global status like Threads_connected`
      1. 引擎监控
        - qps/tps：单位时间内查询数、插入/修改/删除数
        - InnoDB Data读写吞吐量
        - bp请求次数
        - bp命中率
        - redo写次数
          1. innodb_log_writes
          1. innodb_os_log_fsyncs
        - row operations
          1. innodb_rows_read/inserted/deleted
          1. innodb_log_writes
          1. innodb_rows_updated
        - 内存页
          1. innodb_buffer_pool_pages_flushed
          1. innodb_buffer_pool_pages_dirty
        - 行锁
          1. innodb_row_lock_time
          1. innodb_row_lock_time_avg
          1. innodb_row_lock_waits
        - 临时表数量
        - 执行次数
        - 刷盘次数
      1. 部署监控
        - io线程状态
        - sql线程状态
        - 主从延迟时间
      1. 并发请求数：`show global status like Threads_running`：越多性能越下降，这个数远小于连接数，否则就产生了大量的阻塞
      1. innodb阻塞
        ```sql
        // 因为阻塞的sql已经执行完了，所以可能会抓到select这样的语句
        SELECT
            b.trx_mysql_thread_id AS '被阻塞线程',
            b.trx_query AS '被阻塞SQL',
            c.trx_mysql_thread_id AS '阻塞线程',
            c.trx_query AS '阻塞SQL',
            (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(c.trx_started)) AS '阻塞时间' 
        FROM 
            information_schema.innodb_lock_waits a 
        JOIN 
            information_schema.innodb_trx b ON a.requesting_trx_id = b.trx_id 
        JOIN 
            information_schema.innodb_trx c ON a.blocking_trx_id = c.trx_id 
        WHERE 
            (UNIX_TIMESTAMP()-UNIX_TIMESTAMP(c.trx_started)) > 60
        ```
    1. 慢查询
#### 备份和恢复
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
          1. 认识：开源的支持在线增量备份，原理是先全备，记录此时的LSN，增量时比较LSN并且不断更新LSN
     1. 复制
     1. 逻辑备份
        - mysqldump：`mysqldump -u -p [databaseName or tableName] > data.sql`
          1. -d 只导出结构
          1. -t 只导出数据
          1. --all-databases：所有数据库
          1. --master-data=2：记录当前备份的binlog文件信息和偏移量，知道在哪儿备份的
          1. --single-transaction：设置要保证事务一致性
          1. --lock-on-tables：要备份InnoDB和MySIAM混合的需要锁表
        - select ... into outfile：`select * into outfile 'xx.txt' fields terminated by ',' optionally enclosed by '"' lines terminated by '\n' from table;`
     1. 二进制备份：用`flush logs`生成新日志文件，然后备份旧的
     1. 快照备份
        - 认识：把所有日志放到同一个逻辑卷中，用lvm快照
   - 备份方法
     1. 全量备份
     1. 实时备份
        - 实时二进制日志备份：`mysqlbinlog --raw --read-from-remote-server --stop-never --host localhost --port 3306 -u -p xxxx xx.000011`
     1. 基于时间点备份
1. 恢复
   - 逻辑日志导入
     1. mysql -u -p databaseName < data.sql
     1. source xx.sql
     1. load data local infile 'xx.txt' into table tableName;
     1. mysqlimport -u -p --local databaseName dump.sql
   - 二进制日志导入
     1. mysqlbinlog
        - start/stop-position：开始结束位置
        - --database
        - `mysqlbinlog xx.xx | mysql -u -p`
        - `mysqlbinlog xx.xx < xx.sql`
     1. binlog2sql：回滚指定时间点的sql语句
     1. xtrabackup：录binlog位置后copy文件，速度比逻辑备份快上百倍
        - innobackupex：一个工具，同时支持InnoDB引擎以及MyISAM引擎
   - 恢复方式
     1. 基于时间点恢复：`mysqlbinlog --start-position=1 --stop-position=2 --database xx.000011 < xx.sql`
        - 具有时间点之前的mysqldump全备：通过时间点确认LSN
        - 具有全备到指定时间点的mysql二进制日志：用LSN恢复
#### 基准测试
1. 基准测试
   - 认识：进行可复现的某时刻的性能基准测试，以便当系统发生软硬件变化时重新进行测试以评估变化对性能的影响
     1. 要求：要简单、直接、易于比较，用于评估服务器的处理能力。和业务逻辑无关，是一种简化的压力测试
     1. 目的
        - 确定当前mysql服务器的运行情况
        - 模拟更高的负载，以找出系统的扩展瓶颈
          1. 如并发和性能的曲线关系
          1. 测试不同的软硬件、系统参数等
     1. mysql由于数据一致性的要求无法简单的水平扩展(即加机器)，主要评估qps和响应时间
   - 方式
     1. mysqlslap：简单，容易使用，自带，适合对既有数据库单个sql进行优化测试
        - `--auto-generate-sql-load-type`：指定测试中使用的类型(读、写、删除、更新)
        - `--auto-generate-sql-write-number`：指定初始化数据生成的数据量
        - `--concurrency=5000`：并发数
        - `--number-of-queries`：总查询数
     1. sysbench：内嵌lua脚本，可生成指定规模数据，主流厂商(Oracle/Percona)使用，支持多线程，支持多种数据库
        - 建表，塞1百万数据：`sysbench --monitis=oltp --oltp-table-size=1000000 --mysql-db=xx --mysql-user=root --mysql-password=xx prepare`
        - 开始测试：`sysbench --monitis=oltp --oltp-table-size=1000000 --mysql-db=xx –mysql-user=root –mysql-password=xx –max-time=60 –oltp-read-only=on –max-requests=0 –num-threads=8 run`
     1. mysql-tpcc
   - 性能评估
     1. 1核1G：最大连接数300
     1. 1核2G：最大连接数600
     1. 2核4G：最大连接数1200
     1. 4核16G：最大连接数4000
     1. 8核32G：最大连接数8000
     1. 16核64G：最大连接数16000
#### 实例迁移
1. 实例切换
   - 操作步骤
     1. 停服
        - 新实例挂载为旧的从库，并设置为只读，防止两边写
        - 上线切换代码
        - 放开新实例的DML操作
   - 注意项
     1. 常驻程序的重启，如supervisor
     1. 依赖方
        - 直接使用旧从库的，注意切换，如其他业务方、数仓、es
     1. 请求、任务失败，需要有反向check机制
1. 实例迁移步骤
   - 搭建新实例实时和旧的同步
   - 业务方修改配置
   - 业务方停止增删改操作（停服）
   - 删除写用户，保留只读用户 （防止丢数据）
   - 断开新实例到老实例同步，开启新主库可写入
   - 发布，验证业务
   - 删除旧实例
1. 问题排查思路
   - 查看现场：`show full processlist`
   - 分析情况：`explain xx`
   - 查看信息
     1. 正在执行的事务：`select * from information_schema.innodb_trx`
     1. 锁等待：`select * from information_schema.innodb_lock_waits w inner join information_schema.innodb_trx b on b.trx_id=w.blocking_trx_id inner join information_schema.innodb_trx r on r.trx_id=w.requesting_trx_id`
     1. 锁表情况：`show open tables where In_use > 0`
     1. 锁定的事务：`select * from information_schema.innodb_locks`
     1. 锁等待的事务：`select * from information_schema.innodb_lock_waits`
     1. 死锁：``
   - 日志分析：general.log
1. 配置从
   - 主配置
    ```conf
    # vi my.cnf
    server-id = 3             #这个设置3
    log-bin = mysql-bin         #开启binlog日志
    max_binlog_size = 500M #每个bin-log最大大小，当此大小等于500M时会自动生成一个新的日志文件。一条记录不会写在2个日志文件中，所以有时日志文件会超过此大小。
    binlog_cache_size = 128K  #日志缓存大小
    slave-skip-errors = all      #跳过主从复制出现的错误
    # 不同步哪些数据库 
    binlog-ignore-db = mysql  
    binlog-ignore-db = test  
    binlog-ignore-db = information_schema  
    
    # 只同步哪些数据库，除此之外，其他不同步 
    binlog-do-db = game  
    
    # 日志保留时间 
    expire_logs_days = 10   #设置bin-log日志文件保存的天数，此参数mysql5.0以下版本不支持。

    # 日志格式，建议mixed 
    # statement 保存SQL语句 
    # row 保存影响记录数据 
    # mixed 前面两种的结合 
    binlog_format = mixed  #设置bin-log日志文件格式为：MIXED，可以防止主键重复。
    ```
   - 主库创建同步账号：只有同步权限，`mysql > grant replication slave on *.* to ‘rep’@‘192.168.18.214’ identified by ‘123456’;`
   - 从配置
    ```conf
    # vi my.cnf
    [mysqld]

    server-id=2
    master-host=192.168.1.2
    master-user=repl
    master-password=123456
    master-port=3306
    master-connect-retry=30  #这个选项控制重试间隔，默认为60秒。

    #开启日志
    #log-bin=mysql-bin
    #read_only=on

    # 设置忽略数据库
    replicate_do_db=test
    replicate_wild_do_table=test.% #可以使用通配符
    replicate_wild_ignore_table=mysql.%

    slave-skip-errors=1062 # 忽略相关信息
    ```
   - 备份主库：`# mysqldump -uroot -p123 --routines --single_transaction --master-data=2 --databases weibo > weibo.sql`
     1. --single_transaction：导出开始时设置事务隔离状态，并使用一致性快照开始事务，然后unlock tables;而lock-tables是锁住一张表不能写操作，直到dump完毕。
     1. --master-data：默认等于1，将dump起始（change master to）binlog点和pos值写到结果中，等于2是将change master to写到结果中并注释。
   - 把备份库拷贝到从库：`# scp weibo.sql root@192.168.18.214:/home/root`
   - 在主库创建test_tb表，模拟数据库新增数据，weibo.sql是没有的：`# mysql> create table test_tb(id int,name varchar(30));`
   - 从库导入备份库：`# mysql -uroot -p123 weibo < weibo.sql`
   - 在备份文件weibo.sql查看binlog和pos值
    ```
    # head -25 weibo.sql
    -- CHANGE MASTER TO MASTER_LOG_FILE='mysql-bin.000001', MASTER_LOG_POS=107;   #大概22行
    ```
   - 从库设置从这个日志点同步，并启动。可以看到IO和SQL线程均为YES，说明主从配置成功
    ```
    mysql> change master to master_host='192.168.18.212',
        -> master_user='sync',
        -> master_password='sync',
        -> master_log_file='mysql-bin.000001',
        -> master_log_pos=107;
    mysql> start slave;


    mysql> show slave status\G;
    ERROR 2006 (HY000): MySQL server has gone away
    No connection. Trying to reconnect...
    Connection id:    90
    Current database: *** NONE ***
    *************************** 1. row ***************************
                Slave_IO_State: Waiting for master to send event
                    Master_Host: 192.168.18.212
                    Master_User: sync
                    Master_Port: 3306
                    Connect_Retry: 60
                Master_Log_File: mysql-bin.000001
            Read_Master_Log_Pos: 358
                Relay_Log_File: mysqld-relay-bin.000003
                    Relay_Log_Pos: 504
            Relay_Master_Log_File: mysql-bin.000001
                Slave_IO_Running: Yes
                Slave_SQL_Running: Yes
    ```
#### 其他
1. 碎片整理
   - 认识
     1. 产生原因
        - 删除数据时引起对应的二级索引值的随机的增删改会留下数据空洞，便于插入数据时使用，可能会一直存在，如text、varchar类型
        - 随机写入（聚集索引非线性增加）会导致页分裂，页分裂导致页面的利用空间少于50%
     1. 增加了存储，增加io负担降低扫描效率
     1. 原理：将数据页紧密存储，自然就减少占用了
   - 解决方案
     1. 查看
        - 看data_free
        ```sql
        SELECT CONCAT(TRUNCATE(SUM(data_length)/1024/1024,2),'MB') AS data_size,
            CONCAT(TRUNCATE(SUM(max_data_length)/1024/1024,2),'MB') AS max_data_size,
            CONCAT(TRUNCATE(SUM(data_free)/1024/1024,2),'MB') AS data_free,
            CONCAT(TRUNCATE(SUM(index_length)/1024/1024,2),'MB') AS index_size
        FROM information_schema.tables WHERE TABLE_NAME = 'datainfo';
        ```
        - 是否开启独享表空间：`show variables like 'innodb_file_per_table'`
          1. 独享表空间的无法进行optimize操作，因为会重组索引并释放对应空间
     1. 方法1：会锁表，比较慢一百万需要37秒。每月、每周一次就可以
        - ALTER TABLE datainfo ENGINE=InnoDB;
        - ANALYZE TABLE datainfo;
        - optimize table datainfo;
     1. 方法2：`alter table t1 engine = innodb;`，可以先看下data_free
        - 遍历旧表主键索引的数据页，把数据页中的记录生成B+树结构，存储到磁盘上的临时文件中，数据页遍历完了之后，用临时文件替换掉旧表的数据文件。从MySQL5.6版本之后，这个操作是 Online DDL 的，需要扫描表数据文件对于大表非常耗时，如果是线上服务需要避开业务高峰期，小心操作
     1. 方法3：建立按月的分区表，只需要创建一个中间普通表，在业务低峰期做两次分区交换，既可以删除无效数据，又能回收空，而且没有空间碎片，不会影响表上的索引及SQL的执行计划
   - 数据的复用
     1. 数据节点的复用
     1. 数据页的复用
   - 哪些操作会造成数据空洞
     1. 删除数据
     1. 插入数据
     1. 更新数据
### 架构
1. 主从
   - 原理：主库将更改记录到二进制日志binlog，从库复制到中继日志，读取中继重新放到库中。是异步实时的
     1. 计算主从的LSN，可得出时延
     1. 使用Replication协议
   - 作用
     1. 负载均衡，降低压力：读写分离，采用数据库主从方式，多个从库分担读，主库负责写
     1. 高可用，故障切换
        - 对从进行快照保存，可以防止主drop database级的防御
        - 对从设置read-only，防止误改
        - 主从自动切换
     1. 数据备份：异步实时备份，复制不能代替备份，因为执行删除命令同步的很快，这个时候只能依赖备份了
   - 角色
     1. 从库线程
        - Slave_IO_Running：到主库取日志，放入relay log，是顺序写效率较高
        - Slave_SQL_Running：解析relay log并执行，可能随机io成本较高；是单线程的，一个DDL等待之后的都延迟
   - 步骤：![avatar](../images/mysql_slave_process.webp)
     1. master记录到binlog
     1. slave创建的io线程连接master，请求指定文件的指定位置之后的内容
     1. master创建独立异步的log dump线程发送binlog
        - 防止影响主库的更新
        - 会消耗主库资源，占用带宽等
     1. slave的io线程将接收的日志依次记录到relay log末尾中，将binlog日志名和位置记录到masterinfo中。防止影响从库的更新
     1. slave的sql线程检测到relay log新增了内容，解析并执行
   - 查看
     1. `show master status;`
     1. `show slave status;`
   - 配置
     1. 主
        - bin_log=mysql-bin
        - server_id=100
     1. 从
        - bin_log=mysql-bin
        - server_id=101
        - relay_log=mysql-relay-bin
        - log_slave_update=on(可选，是否要当其他的主)
        - read_only=on(建议)
   - 场景
     1. 从库延迟
        - 认识：正常在毫秒级别，秒级就需告警了
        - 一些原因
          1. 一个事务主库执行n分钟，给到从库就会执行n分钟，这个事务导致从库延迟n分钟
          1. 当主库的TPS并发较高，产生的DDL对relay log的回放超过从库sql线程所能承受的范围，延时就产生了
          1. 从库的大型查询语句产生的锁等待
        - 解决方案
          1. 数据冗余，不要再查，直接传输所有数据
          1. 使用Cache，但是更新怎么办，不行
          1. 查主库
1. 复制
   - 复制方式
     1. 异步：主库宕了没同步binlog丢失数据
     1. 半同步：提交commit后等待至少有一个从库收到binlog并写入到中继日志中，再返回给客户端成功，可确保永远有两个节点拥有完整数据，降低了主库写效率，v5.5
        - rpl_semi_sync_master_wait_for_slave_count：设置收到的从库数量才触发，v5.7
     1. 组复制：MGR，MySQL Group Replication，基于paxos协议的状态机复制，需要通过一致性协议层的同意才能提交，大多数节点同意，v5.7
        - 解决传统异步复制和半同步复制可能产生数据不一致的问题
        - paxos作为分布式一致性算法被广泛使用
        - 仅支持InnoDB表，并且每张表一定要有一个主键，用于做write set的冲突检测
        - 必须打开GTID特性，二进制日志格式必须设置为ROW，用于选主与write set
   - 复制方法
     1. 基于日志点的复制
        - 建立从账号：`grant replication slave on *.* to xx@ip段`
        - 备份主库
          1. 被备份表加锁：`mysqldump --master-data=2 --single-transaction`
          1. 热备，InnoDB不加，其他的加，最好的方式：`xtrabackup --slave-info`
        - scp传输sql文件
        - 从导入基础数据
        - 设置复制链路，包括binglog文件和日志点：`change master to master_host='', master_user='', master_password='', master_log_file='', master_log_pos='';`
        - 启动复制：`start slave`
     1. 基于GTID的复制
        - 认识：从告诉主已经执行到的GTID值，主发送回没没执行的GTID值
          1. 很方便进行故障转移
          1. 从不会丢失主的修改：因为自动按照GTID识别同步
        - 步骤
          1. 主：`gtid_mode=on`、`enforce-gtid-consiste`、`log-slave-updates=on(5.6要求,5.7去掉了,会带来负担)`
          1. 从：`gtid_mode=on`、`enforce-gtid-consistency`、`master_info_repository=tables(建议)`、`relay_log_info_repository=table(建议)`
          1. 备份主库，类似以上
          1. scp传输sql文件
          1. 从导入基础数据
          1. 设置复制链路，gtid方式：`change master to master_host='', master_user='', master_password='', master_auto_position=1;`
          1. 启动复制：`start slave`
   - 性能
     1. 写入binlog的时间，事务太大，主从延迟严重
     1. binlog传输时间，同机房部署、`binlog_row_image=minimal`
     1. 从只有一个sql线程，主上的并发写，从变成串行，如大事务后边所有的修改都阻塞，5.7使用多线程复制
        - `stop slave`
        - `set global slave_parallel_type='logical_clock'`：使用逻辑时钟方式
        - `set global slave_parallel_workers=4`：线程数
        - `start slave`
   - 常见问题
     1. 解决方案
        - 恢复复制
        - 最终都要数据对比
     1. 主从宕机
        - 特点
          1. 主宕机：主回滚事务，从拿不到
          1.  从宕机：master_info没写入磁盘，造成重复获取主的二进制日志，基于日志点会出现主键重复、基于Statement出现重复更新
        - 解决方案
          1. 跳过二进制日志事件：日志点复制方式
          1. 注入空事务先恢复中断复制链路：日志点或GTID方式
     1. 数据损坏
        - 特点
          1. 主binlog损坏
          1. 从relay_log损坏
        - 解决方案
          1. 通过change master重新指定
     1. 从进行了数据修改：丢掉从的修改
     1. 不唯一的server_id、server_uuid：从之间重复，数据相互拿的不对，甚至主从切换失败
     1. max_allow_packet：不一致
   - 无法解决的
     1. 自动故障转移、主从切换
     1. 读写分离
1. 主主
   - auto_increment_offset设置差1，auto_increment_increment设置为2：防止主键冲突
   - log_slave_updates：两节点都要开启，就是反着搭建主备同步
1. 网校架构
   - 主要
     1. 一主两从，读写分离
     1. 版本5.7.24，启用GTID模式，启用半同步复制
   - 功能划分
     1. 主库功能（rw）：承载DDL、DML、查询操作，并且通过binlog将所有操作在从库上复现，从而实现主从数据一致
     1. 线上从库功能（ro）：承载线上查询（select）操作，以减轻主库压力
     1. 线下从库功能（ofl）：供数据部门（统计类型业务）、开发进行相关查询操作，以避免慢查询影响线上业务
   - 主从切换机制：Arksentinel
     1. Arksentinel中每个哨兵均每隔一段时间探测一次状态为“online”+“normal”的数据库实例，判断其是否存活或者正常服务，若不可访问/不可正常服务，则会连续探测多次；其中间隔时长和探测次数可由参数“ping间隔时间(ms)”和“ping次数”指定
     1. 若某个哨兵连续探测次数达到参数“ping次数”之后节点仍未正常，则该哨兵标记该节点为“SDOWN”状态，此时会询问其他哨兵该节点状态。
     1. 若其他哨兵中认为该节点状态为“SDOWN”的个数达到quorum（法定数量）后，则Arksentinel认为该节点实例为“ODOWN”状态，即哨兵集群认为该数据库节点已不可用，应当发起故障切换
        - quorum法定数量是指N个节点中有N/2+1个，例如5个节点的quorum就是3，6个节点的quorum就是4；SDOWN是Subjective Down，某个哨兵主观认为节点宕机；ODOWN是Objective Down，客观事实该节点已经宕机可不服务。
        - 此处系统还有一个特殊情况处理，若非所有哨兵均认为节点SDOWN，则会延迟后面的投票和选举等操作一段时间，这样是为了极大情况排除机房间断网或者网络闪断而发生切换的情况。
     1. 哨兵内部会发起选举和投票，以选出一个Leader来执行数据库故障切换操作。
        - 哨兵的每一次探测、选举和投票，均针对其内部的同一个epoch，即不会发生某个哨兵对上一轮的选举发起投票的情况。
     1. Leader哨兵会根据用户自定义的故障转移方案完成整个高可用切换，包括MySQL集群关系重新建立、新Master/Write节点关闭read_only参数、VIP/DNS漂移等，并标记故障节点为“offline”+“problem”状态，即不再对外提供服务，需要用户在节点恢复后手动置为“online”状态。
        - 对于主从复制架构来说，新Master会选取Retrive Binlog最大的节点，即从原Master上获得最多Binlog的节点，其上的Binlog才是相对最完整的。当然新Master/Write节点的选取，还会参照权重、机房和主从复制延迟多个维度，保障数据的完整性和一致性
   - dbproxy扩容
     1. 原理图：![avatar](../images/dbproxy_expansion.png)
     1. 说明
        - Step 1：业务方将App Server的Mysql请求迁移到Nginx四层代理，Nginx四层代理指向Mysql Proxy及后面的Mysql老集群
        - Step 2：启动Mysql数据全量同步及增量同步，并始终开启新老两个集群的maxwell binlog抽取，分别写入kafka的不同topic
        - Step 3：增量数据同步结束后，执行新老集群数据对比，确保两个集群数据一致
        - Step 4：Nginx四层代理切换流量到新的Mysql Proxy
     1. 一致性保证
        - 原因：由于在Step 4的过程中，可能会出现以下两个数据来源的写入乱序，因此切流新Mysql Proxy前需要先关闭Kafka的Data Loader，而Kafka的Data Loader流量来源于业务方写入老的Mysql Proxy的流量，而这个binlog抽取可能会有延迟，该延迟理论值小于10ms（待观察），需流量低谷执行
          1. Kafka数据抽取，通过Data Loader写入新的Mysql Proxy
          1. 切流量后，业务方的请求写入新的Mysql Proxy
        - 步骤
          1. 停止老的Mysql Proxy流量
          1. 等大概200ms时间
          1. 关闭Kafka Consumer（Data Loader）
          1. 将流量切到新的Mysql Proxy
          1. 打开Kafka Consumer，观察是否还有遗漏的数据，并进行手动修复（极小概率发生）
### 中间件
1. 现有mysql的问题
   - 无集群化的解决方案
   - 无在线扩容方案，横向分片需要业务改造
   - 网络模型限制了连接数
   - 不支持跨机房部署、sql分发
   - 不支持Paxos、Raft、Dynamo等一致性协议
1. 认识
   - 优点
     1. 对前端透明
     1. 自动故障转移(带事务重放)、主从切换、从节点选取
     1. 集群健康度检查，包括复制链路
     1. 读写分离、读负载均衡
     1. 分库分表：垂直、水分拆分
     1. 防火墙：sql审核、过滤、改写、容错、转换、慢指纹、错误sql指纹
     1. 连接池
     1. 配置热加载、ip白名单
     1. 跨机房双活、多集群、多租户
     1. 查询路由
     1. 方便的运维方案：实例申请、建库表、慢查询统计、在线DDL
   - 缺点
     1. 增加中间层，执行效率降低，先进行基准测试
     1. 需要控制是否读写分离
1. 集群方案
   - MMM
     1. 认识：Master-Master replication managerfor Mysql Mysql主主复制管理器，perl实现的双主故障切换、管理的脚本程序
        - 功能
          1. 主主的管理、监控、故障迁移、主从备份、节点重新同步、宕机从自动剔除
          1. 提供多个VIP，同一时间只有一个主可写
        - 缺点
          1. 性能没有提升，每个主都要写
          1. 主从切换容易数据丢失：只做了切换，不会主动补齐丢失的数据
          1. 无读负载均衡
     1. 部署：三台服务器，两台配置主主复制，第三台作为从服务器的同时作为监控节点对主主复制进行监控
   - MHA
     1. 认识：Master High Availability 主高可用，完成主从架构下完成主从切换和从之间的选举，最大程度保证一致性，30s内完成切换，perl开发
        - 主从切换
        - 从之间的选举
        - 最大程度保证一致性
          1. 会保存主的binlog，如果主硬件、网络等无法访问，可能会丢失数据，可以结合v5.5半同步功能
          1. 新主和其他从同步差异
          1. 应用原主的binlog
          1. 提升新主
          1. 迁移其他从
        - 支持GTID
     1. 特点
        - 缺少从的vip功能，也不能自动剔除宕机从
        - 监控过程中不会管主从复制链路的健康度
        - 需要打通ssh，存在安全隐患
        - 无读负载均衡
     1. 组成
        - Manager
        - Node：部署在每台实例上
   - pxc
     1. 认识：数据多向同步的同步复制的高可用性和扩展性的集群方案，基于Percona Server 
        - 多主复制，任意节点写操作
        - 故障切换、自动节点克隆
     1. 原理
        - 在所有集群节点都要提交
     1. 注意
        - 尽可能的控制PXC集群的规模，节点越多，数据同步速度越慢
        - 所有PXC节点的硬件配置要一致，如果不一致，配置低的节点将拖慢数据同步速度
        - 只支持InnoDB
   - mysqlProxy
     1. 认识：mysql官方，很久，实验项目
   - Orchestrator：mySQL高可用性和复制拓扑管理工具，支持调整复制拓扑、自动故障转移、手动主从切换等，go写的，网校在用
   - maxscale
     1. 认识：支持高可用、负载均衡、扩展插件式的数据库中间件，mariaDB出品
        - 主从复制状态监测，自动故障转移
        - 读写分离、读负载均衡
     1. 插件
        - 认证
        - 协议
        - 路由
        - 监控
        - 过滤日志：简单防火墙，sql过滤和改写、容错、转换
   - oneProxy
     1. 认识：将一个表分片，数据写到两个实例中，也可以保持两个实例都有一个相同的表，貌似也停止维护
   - mycat
     1. 认识：开源分布式数据库中间件，13年阿里开源，java写的。支持读写分离、高可用(主没了选从)、拆分(垂直、水平)
        - 高可用：采用去中心化的集群，在虚拟ip下，在不同的节点部署多个mycat，根据某种策略(ip选举策略)选举某一个为临时master，之间采用心跳机制进行通信维持故障切换。可使用zk、haproxy、keepalived等组件，可以有选举、心跳、切换ip等功能
        - 功能复杂，细节还待改善
   - proxySQL
   - dbproxy：美团开源，Atlas基础上开发，17年停止维护
   - wxproxy
     1. 优势
        - 分片功能实现横向扩容
          1. 分片查询：Proxy根据SQL语句解析出AST，再根据AST里的WHERE条件判断是否满足id的查询条件，最后将SQL路由至该Shard
        - proxy的仅有10%性能损失
        - 监控体系：实现问题的发现、报警、追踪、排查、解除，提供web界面
        - 双活机房部署支持，配置热加载，秒级主从机房切换
     1. 功能
        - 执行计划缓存
        - 事务追踪
        - 全局索引
        - 分布式事务
        - 平滑的扩容、缩容
        - 注解路由：通过注释解析
          1. 强制读主库
          1. 强制路由到本地机房
     1. 部署
        - 前端Nginx+KeepAlived作四层负载均衡，dbproxy本身作为无状态服务，可以非常方便地横向扩容
        - etcd作配置中心
     1. 一致性支持：支持多种级别
        - 弱一致：纯异步的复制机制，通过Maxwell异步复制Binlog支持
        - 强一致：Proxy在执行SQL写入时，强制双写Local机房及Remote机房，确保两个机房都写成功后，返回客户端
          1. 强一致场景仍然会有数据不一致风险，比如主机房写入成功，从机房写入失败，则在短暂时间内会有两个机房数据不一致的情况发生，后续可通过业务重试解决
          1. 使用事务强一致可以避免数据不一致，跨库事务会有一定的开销但总体上不会太大
        - 事务强一致：通过1PC Best Effort或2PC事务（需要Mysql调整隔离级别Serializable）确保本地机房和远端机房原子性写
     1. SQL解析缓存
        - Mysql Proxy在转发SQL请求时，会经历以下几个步骤：
          1. Mysql协议解析
          1. SQL解析：确定路由规则
          1. 路由算法匹配
          1. 通过连接池分发SQL到后端的Mysql实例
        - 其中，步骤2耗时较长，因此，我们需要针对SQL解析后的AST增加缓存机制。具体做法是先将请求的SQL转化成SQL Statement（SQL指纹），屏蔽SQL中变量、大小写等
        - 然后以SQL Statement为Key缓存解析后的AST。
     1. Proxy高可用：在某个Proxy不可用时，由于Nginx本身有重试机制，当一个upstream中某个Backend无法响应时，Nginx会继续尝试下一个Backend。
     1. 数据度量
        - 单行查询的case，单核1W QPS
        - 同机房部署比直连延迟额外增加在1ms以内
        - 主从复制延迟
          1. 同机房300us
          1. 跨机房视专线网络RTT
        - 连接数
          1. 业务到Proxy：核数 * 5000
          1. Proxy到Mysql：3000/数据库实例
     1. 核心指标
        - 服务器资源用量：CPU、RAM、网络带宽、磁盘占用
        - 慢SQL
        - 错误SQL
        - SQL执行延迟
        - 业务请求QPS
        - 连接数
   - gaea
     1. 认识：定位轻量级, 高性能，小米开源
   - cetus
   - DataX：阿里巴巴开源的离线数据同步工具
   - PMM：percona公司提供的MySQL和MongoDB的监控和管理平台
   - amoeba
   - atlas：360开源
   - kingshard：个人的go开发，读写分离、分库分表、sql黑名单
1. maxwell
   - 认识：同步binlog以json写入到kafka、redis、es等流平台，用于ETL、缓存刷新、指标收集、增量到搜索引擎、数据分区迁移、切库binlog回滚等场景，java写的
     1. 有过滤器功能
     1. 优缺点
        - 优点：业务解耦，准实时
        - 缺点：只能单表操作，不适用于涉及到数据聚合的地方或者有父子关系的
   - 原理：伪装为slave，接收binlog events，然后根据schemas信息拼装，可接受ddl、xid、row等各种event
   - 使用
     1. 流程
        - mysql配置maxwell用户、给与权限
        - 配置连接mysql信息
        - 配置连接kafka信息，topic
     1. maxwell-bootstrap：基于SELECT*FROM table帮助完成数据初始化
     1. 特点
        - timestamp column：对时间类型当字符串处理。所以更合理的做法是提供时区参数，然后maxwell自动处理时区问题
        - binary column：做base64_encode，消费者需要解码
   - 配置
     1. mysql角色
        - host：主机，建maxwell库表，存储捕获到的schema等信息
        - replication_host：复制主机，Event监听，读取该主机binlog
          1. 将host和replication_host分开，可以避免replication_user往生产库里写数据
        - schema_host：schema主机，捕获表结构schema的主机
          1. binlog没有字段信息，所以m需要从数据库查出schema，存起来
     1. 过滤器
        - --filter='exclude: foodb.*, include: foodb.tbl, include: foodb./table_\d+/'：# 仅匹配foodb数据库的tbl表和所有table_数字的表
        - --filter = 'exclude: *.*, include: db1.*'：排除所有库所有表，仅匹配db1数据库
        - --filter = 'exclude: db.tbl.col = reject'：排除含db.tbl.col列值为reject的所有更新
        - --filter = 'exclude: *.*.col_a = *'：排除任何包含col_a列的更新
        - --filter = 'blacklist: bad_db.*'：blacklist 黑名单，完全排除bad_db数据库，若要恢复，必须删除maxwel
     1. 输出格式
        - 是否包含 binlog position
        - 是否包含 gtid position
        - 是否包含 commit and xid
   - 架构
     1. 高可用
        - 最小队列粒度也是表，根据数据量级分开
        - 不直接支持ha，但支持断点还原
        - 不支持控制数据速率
        - 监控：baselogging mechanism,JMX,HTTP,bypush toDatadog
        - 报警
          1. 进程是否存在
          1. 监控异常日志
          1. 网络监控
          1. 数据一致性：可手动修改position位置
        - 主从切换：通过域名访问mysql，跟着切换走
     1. 架构：跟着数据库在不同集群就行，关系就是和mysql、kafka
   - 性能表现
     1. qps 16w，单核2G，20%cpu，7%内存占用，带宽会很高
   - 其他
     1. canal Otter：分为服务端和客户端，需要自己编写客户端来消费服务端解析到的数据。性能稳定，功能强大，阿里。maxwell不用客户端了简单
     1. mysql_streamer
     1. datax
     1. flink
### wiki
1. 路线
   - 路线：基础知识(操作/配置)——优化方式、方法、注意点——各种技术方案——原理
   - 提升：集群部署--中间件实施--备份设计监控--日志处理--授权
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
     1. 按照逻辑时钟方式分配sql线程，解决5.6多线程复制性能可能更低的问题
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
     1. 允许用户自定义表空间：可做到数据冷热分离，用HDD和SSD通过mount相应逻辑卷lv分别存储冷热数据，如用户、订单表放在SSD
