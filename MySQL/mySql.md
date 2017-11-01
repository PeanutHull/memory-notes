#### 目录
1. 认识
1. 应用
1. 性能
1. 原理
1. 周边
1. WIKI
### 认识
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
        ```
   - DCL和DDL
        ```
        // show
        show databases/tables;                          # 查看数据库或表
        show create database/table baseName/tableName;  # 输出标准sql语句
        use database;                                   # 选择库
        desc tables;                                    # 查看表结构
        set baseName utf8/gbk;                          # 设置库编码
        // create
        create database xxx default character set = utf8mb4;                              # 创建库
        create table table_name(                                                          # 创建表
            id int unsigned primary key auto_increment,
            username char(25) unique not null default '',
        )ENGINE=InnoDB AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='';
        create table tableName1 like tableName;                                           # 复制表结构
        insert into tableName1 select * from tableName;                                   # 复制表数据
        create table tableName1 select * from tableName;                                  # 复制表结构和数据
        // alter
        alter table tableName rename newName;                                             # rename，修改表名
        alter table tableName add columnName int unsigned not null default 0;             # add，追加字段
        alter table tableName add primary key(sid);                                       # add，增加主键
        alter table tableName drop columnName;                                            # drop，删除字段
        alter table tableName drop primary key;                                           # drop，删除主键，先删除自增，再删字段
        alter table tableName change new_column column char(20) not null default '';      # change，修改字段名或者字段类型
        alter table tableName modify name char(20) after sex;                             # modify，只修改字段类型，显示顺序放到sex字段后
        // drop
        drop database/table if exists baseName/tableName;                                 # 删除库/表
        // lock
        lock tables `user` write;                                                         # 锁表
        unlock tables;
        ```
   - DML
        ```
        // 查询语句组合
        select */,/count()/min()/max()/sum()/avg()/distinct()/concat(XX,XX)               # 选择字段，distinct去重可能要全表扫描，concat字符串连接
        from table/as n from table/from table1 as x,table2 as x/                          # 选择表
        left join table2 as x2 on x1.x=x2.x                                               # 无论右边有没有数据，左边有的信息都显示
        select xx from table as x1 join table as x2 on x1.xx=x2.xx                        # 自关联        
        where x.x/=/<=/like/in(,,)/and/or/between and                                     # 条件
        XX=(select x from table2 where xx=xx);                                            # 子查询，把另一个查询语句的结果做数据来源
        group by having XX                                                                # 分类筛选
        order by XX desc/asc/rand()                                                       # 排序
        limit x offset x                                                                  # 限制条数
        // 插入数据
        insert into table set XX=xx/(,,) values (,);                                      # 插入数据
        // 更新数据
        updata table set XX=xx;                                                           # 会更新所有数据
        replace into table (,,) values (,,);                                              # 替换，命中主键修改，未命中添加
        // 删除数据
        delete from table where XX=xx;                                                    # 删除
        delete from table;                                                                # 只删除数据
        truncate table;                                                                   # 数据清空，主键归0
        ```
1. 索引
1. 事务
   - 理解：全部执行才能完成，要有回滚
   - 特点
     1. 事务只能在单个数据库上起作用，对于主从延迟，可用事务抓住主库进行读写，不存在数据差异的问题了
   - 隔离机制：在一个客户端执行事务未完成，所修改的数据对其他客户端是不可见的，是原来的数据
1. 隔离级别
    ```
    - READ UNCOMMITTED     最低级别，会导致数据完整性的严重问题
    - READ COMMITTED       
    - REPEATABLE READ      默认，一个事务开始后其他session对数据库的修改在本事务中不可见，直到本事务commit或rollback
    - SERIALIZABLE         最高级别，性能问题并增加死锁的机率
    ```
1. 视图
1. 约束
1. 关联表：通过外键约束来保证表与表之间的数据的完整性和准确性，可以进行级联操作，由于对业务的强一致性要求，现在都由成宿控制，不使用外键关联
1. 触发器：triggers
1. 存储过程
1. 存储引擎
   - MyISAM
     1. 特点：
        - 用于只读提高性能
        - 不支持事务
   - InnoDB
     1. MVCC: Multi-Version Concurrency Control 多版本并发控制，多种行锁机制组合
     1. 特点：
        - 支持事务
        - 行级锁
        - 并发
        - 实现sql标准的4种隔离级别
        - 插入缓存(insert buffer)
        - 二次写(double write)
        - 自适应哈西索引(adaptive hash index)
        - 预读(read ahead)
1. 函数
    - rand/replace
    - UNIX_TIMESTAMP：时间转换为时间戳
1. 用户和权限管理
   - user
    ```
    select * from mysql.user\G;                                      # 查看用户
    update mysql.user set password=password('') where user='';       # 修改用户密码
    
    create user userName@'::1' IDENTIFIED by 'password';             # 创建用户 
    rename user oldName to newName;                                  # 重命名
    set password for userName@'%' =password('');                     # 修改用户密码
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
        FLUSH PRIVILEGES;                                               # 刷新权限
        ```
     1. 一些权限的意义
        - INDEX：创建/删除索引
        - PROCESS：查看/杀死线程
        - RELOAD：重载授权表、清空日志/主机缓存/表缓存
        - SHUTDOWN：关闭服务器
        - ALL：所有；ALL PRIVILEGES同义词
        - USAGE：特殊的“无权限”权限
     1. user表中host列的值的意义
        - %：匹配所有主机
        - localhost：localhost不会被解析成IP地址，直接通过UNIXsocket连接
        - 127.0.0.1：会通过TCP/IP协议连接，并且只能在本机访问；
        - ::1：兼容支持ipv6的，表示同ipv4的127.0.0.1
1. 数据传输
    ```
    // 只导出结构
    mysqldump -u -p -d [databaseName or tableName] > data.sql
    // 导出结构和数据
    不加 -d
    ```
### 应用
1. 悲观锁————Pessimistic Locking
   - 理解：读取的时候为后面的更新加锁，之后再来的读操作都会等待。这种是数据库锁
   - 意义：数据修改的排他性。高并发下，数据可以正确写入。但是带来数据库性能的大量开销，影响并发访问性，其他修改操作就需要等待。特别是长事务，无法承受会超时。一般不能用。
   - 分类
     1. Row-Level Lock，InnoDB默认
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
### 性能
1. 优化
   - 硬件：主频高处理快高吞吐低时延，L1/2/3的cache大速度快，内存大磁盘读写少TPS高，固态快机械配阵列卡，网卡好低时延，文件系统用xfs/ext4坚决不用ext3，
   - ddl·sql：
     1. 主键：一定有主键，最好是自增，否则多次读写后更离散，更多随机io
     1. 数据类型：
        - int比string快
        - 坚决不用char/uuid，ip用INT UNSIGNED不用CHAR
        - 增加create_time/update_time字段，用于数据归档/自定义差异备份
     1. 数据长度：越短越好，更少存储/内存空间
     1. 索引：
        - 否则：读取全表扫描，修改全表记录锁
        - innDB行锁基于索引
        - 优先多列联合索引，少单列索引，字符型的用部分索引
     1. sql语句：
        - 无select *，提高利用覆盖索引的几率，避免sql注入，用PREPARE预处理，用SQL_MODE做限制，sql中无计算，where中无函数
        - 所有where条件加引号，防止类型隐式转换
        - like查询%不做最左前导否则索引失效
        - 尽量inner join让优化器自动选择驱动表
        - 关键业务上线前EXPLAIN确认执行计划
 - 运维
### 原理
### 周边
1. mycat：开源分布式数据库中间件
### WIKI
1. 一些操作
   - 插入不重复的数据行，MySQL特有的，不是标准sql语法：`INSERT token(udid) values ('{$udid}') ON DUPLICATE KEY UPDATE activetime ='{$time}'`
   - 原所有id增加5万，必须倒叙操作：`update user SET uid=uid+50000 order by uid desc;`
   - 查询这个数据是否存在，存在则存到另一张表里：`create table temp as select * from admin a where exists (select uid from user u where a.userName = u.account);`
   - 查询两张表中是否有相同的数据：`select * from admin wherer uid IN(select uid from temp);`
1. 各个版本的特性
1. 默认数据库的含义
   - mysql：用户/权限相关
   - information_schema：自身架构相关
   - performance_schema
   - sys
### 问题
1. group by什么概念
1. having什么概念
1. between and什么概念
1. mysql的不等于是什么？
