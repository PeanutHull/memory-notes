### mysql
1. 认识：单进程多线程，插件式的表存储引擎
   - 数据多了，性能下降不是线性的
1. 架构
   - 服务层：————负责跨存储引擎功能的实现，如存储过程、触发器、视图
     1. 连接器：————管理连接、连接权限验证，用户权限信息放在一个变量中以供后续使用，长连接多了容易内存爆满
     1. 查询缓存：————8.0已删除，命中率非常低，表更新会使所有查询缓存清空
     1. 分析器：————词法语法分析，之后进行precheck权限检查
     1. 优化器：————生成执行计划，选择索引
        - 决定使用哪个索引
        - join时决定表的连接顺序
     1. 执行器：————操作引擎(调用引擎接口)，返回结果，再次检查权限，因为有些只能在执行阶段才能知道具体哪张表，如触发器
   - 存储引擎层：————负责数据存取，插件式
     1. InnoDB
     1. MyISAM
     1. Memory
1. sql执行流程
   - 发送sql到服务器
   - 检查查询缓存是否命中该sql：需要sql一模一样，写频繁会降低查询效率，应该关掉
   - sql解析：语法解析，关键字正确与否、顺序是否正确
   - 预处理：表列名字是否正确
   - 由优化器生成执行计划：选择索引
     1. 生成错误查询执行计划的原因
        - 统计信息不准
        - 成本估算不准，不知道哪些页面在内存/在磁盘，可以顺序读取/随机读取
        - 基于模型而不是最快
        - 不考虑其他并发查询
        - 有时候会基于固定规则
        - 不考虑不受其控制的成本：自定义函数、存储过程等
     1. 优化器可改写优化的sql类型
        - 改变表的关联顺序：会通过统计信息决定表的关联顺序
        - 将外连接转化为内连接：join改为where执行
        - 等价变换：优化效果相同的where条件
        - 优化count、min、max：直接看索引就行
        - 将表达式转化为常数
        - 子查询优化：转为关联查询
        - 提前终止查询
        - 对in()优化：先排序再二分查找，比其他等价为多个or的更快
   - 调用存储引擎api执行
   - 返回结果
1. mysql存储结构
   - 数据文件
     1. .frm：存储表的元数据信息，主要是表结构、视图
     1. .ibd：innodb data文件，索引和数据在一起
     1. .index、.0001：binlog文件
     1. .myd、.myi：MyISAM数据文件、索引文件
   - 日志
     1. binlog：二进制日志，记录所有更改数据的语句，可用于复制，事务提交前只写一次
     1. relaylog：中继日志，从接收的主的日志

     1. slowlog：慢查询日志，执行时间超过long_query_time的查询或不使用索引的查询
     1. errorlog：错误日志，启动、运行、停止遇到的问题，平时要关注，并进行数据库优化
     1. general log：通用查询日志，客户端连接和执行的语句
     1. 引擎日志
   - 系统文件目录
     1. --basedir = /usr
     1. --datadir = /var/lib/mysql
     1. --plugin-dir = /usr/lib64/mysql/plugin
     1. --log-error = /var/log/mysqld.log
     1. --pid-file = /var/run/mysqld/mysqld.pid
     1. --socket = /var/lib/mysql/mysql.sock
### 索引
1. BTree
   - 认识：Balance tree，平衡树。io通过二分查找一级级查向叶子节点，叶子都是有序的
     1. 对一个索引字段进行检索，采用普通索引还是唯一索引在检索效率上基本上没有差别。因为只是加了约束，整页在内存中判断时cpu的时间可以忽略不记
   - 分类
     1. btree：二叉查找树，每个节点只存储一个关键字，等于则命中，小于走左节点，大于走右节点
     1. b-tree：多路查找树，每个节点存储M/2到M个关键字，非叶子节点存储关键字范围和指向的子节点id；所有关键字在整颗树中出现且只出现一次，非叶子节点可以命中，-只是一个连接符不是减
     1. b+tree
        - 认识：在b-tree基础上
          1. 所有数据行都只在叶子节点中出现，非叶子节点作为叶子节点的索引，即总是到叶子节点才命中
          1. 增加链表将叶子节点串联在一起
             - 是双向链表，用以支持前后遍历
        - 最佳实践
          1. 一般情况，根节点存在内存，其他节点存在磁盘
        - 比较
          1. b+tree只在叶子节点存放数据行，而B树则会在叶子和非叶子结点上都放
          1. b-tree的叶子节点不需要链表串联
     1. b*tree：在b+tree基础上，为非叶子节点也增加链表指针，将节点的最低利用率从1/2提高到2/3
   - 实现
     1. 结构：来自于改造的二叉查找树，树中间的节点不存储数据只作为索引，把每个叶子节点串在一条链表上，链表中数据从小到大有序。原理类似跳表
     1. 操作
        - 区间查找：用区间起始值在树中查找直到叶子节点，然后顺着链表往后遍历直到结束值即可
   - 特点
     1. 压缩树高度：io次数是查询最大的成本所在，所以减少io次数至关重要：io次数取决于树的高度H，假设当前数据表的数据为N，每个磁盘块的数据项的数量是M，则有：H=log(M+1)N，当数据量N一定的情况下，M越大，H越小；而M=磁盘块大小/数据项大小，磁盘块大小也就是一个数据页的大小，是固定的
        - 如果数据项占的空间越小，数据项的数量越多，树的高度也就越低，需要的io越少。这也就是为什么每个数据项，即索引字段要尽量的小，比如int占4个字节，要比bigint的8个字节小一半
        - 这也是为什么B+树要求把真实数据放在叶子节点内而不是内层节点内，一旦放到内层节点内，磁盘块的数据项会大幅度的下降，导致树层级的增高。当数据项为1时，B+树会退化成线性表
     1. 最左匹配特性：B+树的数据项是复合性数据结构，比如（name，age，gender）的时候，B+树是按照从左到右的顺序来建立搜索树的，比如当（小张，22，女）这样的数据来检索的时候，B+树会优先比较name来确定下一步的搜索方向，如果name相同再依次比较age和gender，最后得到检索的数据。但是，当（22，女）这样没有name的数据来的时候，B+树就不知道下一步该查哪个节点，因为建立搜索树的时候，name就是第一个比较因子，必须根据name来搜索才知道下一步去哪里查询
     1. 整页读取，在内存中过滤出结果
   - 比较
     1. InnoDB叶子节点存储的是主键id，MySIAM存的是物理地址
   - InnoDB的b+tree索引
     1. 存储形式
        - 磁盘的最小单元是扇区，默认512byte
        - 文件系统的最小单元是块，默认4K
        - InnoDB引擎的最小单元是页(innodb_page_size)，默认16K
        - 数据行都存储在页中，一页可以存储多条数据
     1. 数据组织形式：使用索引组织表，表中的行(记录)都是存储在页中(叶子节点)，也可以是健值和指针(非叶子节点)，当然是有序的
        - 用于页中数据的查找，如果逐条遍历性能差，引入了b+tree
        - 主键索引的叶子节点中存储行数据：![avatar](../images/mysql_index_primary_key.webp)
        - 其他列的索引需要先查到主键id，再去主键索引获取整行的数据。如高度3的树，需要3+3=6次io：![avatar](../images/mysql_index_second_key.webp)
        - 一棵树可以存多少行？总行数 = 根节点指针数 * 单个叶子节点记录条数，如主键id为bigint 8byte，指针大小6byte，单行数据1kb，那么一页能存16384/14=1170个指针，高度为2的树能存放1170*16=18720条，高度为3的2千万行1170*1170*16=21902400
     1. 检索形式
        - 从表空间文件中固定的根页开始
          1. 主键索引b+tree的根页在整个表空间文件中的第3个页开始，根页偏移量为64的地方存放该b+tree的树高度page level
        - 循环使用二分查找法，不停确定下一层的页id，直到找到
     1. 实操
        - 查看一张表的根页id
            ```sql
            SELECT
            b.name, a.name, index_id, type, a.space, a.PAGE_NO
            FROM
            information_schema.INNODB_SYS_INDEXES a,
            information_schema.INNODB_SYS_TABLES b
            WHERE
            a.table_id = b.table_id AND a.space <> 0
            and b.name like '%sp_job_log';
            ```
        - 数据库物理文件存放位置：`show global variables like "%datadir%";`
        - 查看数高度
          1. 获取根页id PAGE_NO，如3
          1. 计算idb的偏移量：16384 * 3 + 64 = 49216
          1. 查看数据：hexdump -s 49216 -n 10  sp_job_log.ibd，如0100，page_level为1，则高度为1+1=2
1. wiki
   - 引擎支持的索引结构
     1. InnoDB/memory/heap：b+tree、hash
     1. MySIAM：b+tree、rtree(空间列是rtree)
   - InnoDB索引和记录是存储在一起的，MyISAM是分开的
### 事务
1. ACID实现原理
   - 原子性：redo
     1. undo：撤销所有执行了一部分但尚未提交的操作，反向记录操作之前的数据
   - 一致性：undo
   - 隔离性
     1. 全部顺序
     1. 读写锁
     1. MVCC
   - 持久性：redo
     1. redo：redo日志记录LSN，数据页头部也记录LSN，数据库启动时，对比两个LSN，会将redo中多出来的写回页中
     1. 写入原子性：redolog的存储单位是512byte，磁盘扇区大小512byte，扇区是操作系统与磁盘数据交换的基本单位。只需无缓冲写入磁盘就可保证数据原子写入
1. MVCC
   - 认识：Multi-Version Concurrency Control 数据多版本并发控制，一致性数据快照，即非锁定读
     1. mvcc做的事情就是将所有可能读的请求都放在事务开始之前，让你先读到，保证了读写并行、写读并行
     1. 读取数据时InnoDB几乎不用获得任何锁，每个查询都通过版本检查，只获得自己需要的数据版本，从而大大提高了系统的并发度
     1. 提供基于某时间点的快照，提供事务开始时相同的数据，不管事务执行的时间有多长
     1. 对于支持行锁的事务引擎，进行数据库的并发控制，把数据库的行锁与行的多个版本结合起来，只需很小开销就可实现非锁定读，从而大大提高并发性能
     1. 设定多个隔离级别，分批打碎传统的一致性，做到读写、写读不冲突，极大提升性能，就剩下写写的冲突了
     1. 通过保存数据在某个时间点的快照来实现，大多数情况下可以代替行级锁
     1. 理想的mvcc无法实现，Innodb只是借了MVCC这个名字提供了读的非阻塞而已，没有实现核心的多版本共存，只是串行化的结果，因为类似乐观锁的特性无法代替二段提交的强一致性
        - 每行数据都存在一个版本，每次数据更新时都更新该版本
        - 修改时Copy出当前版本随意修改，各个事务之间无干扰
        - 保存时比较版本号，如果成功（commit），则覆盖原记录；失败则放弃copy（rollback）
   - 特点
     1. 针对读多写少场景优化，写多时可能增加系统的成本
     1. 并行度能达到或超过读未提交，而隔离级别很高，跟序列化相差不多
   - 读的分类
     1. 快照读：一致性读，读可见/历史版本，基本不加锁，如读事务开始时之前的版本，可以确保是已经保存的，或者事务自身修改的
        - 每个查询都通过版本检查，只获得自己需要的数据版本，从而大大提高了系统的并发度
     1. 当前读：读最新版本，加锁
     1. 一致性非锁定读：不同隔离级别决定是否会出现不可重复读
     1. 一致性锁定读
        - for update：x锁
        - lock in share mode：s锁
   - 原理
     1. 写时将数据复制一份，以版本号区分，copy on write
     1. 写任务操作新克隆的数据，直至提交
     1. 并发读任务可以继续读取旧版本的数据，不至于阻塞
        - 确定读的顺序：使用逻辑时间戳确定读写顺序，保证时间先后顺序即可，不是真正意义时间的描述，对应物理时间戳
          1. SCN(oracle)
          1. Trx_id(innodb)
1. 内部XA事务
   - 认识：最常见的是binlog和redo log之间，二者要求是原子性的，否则导致主从不一致(因为binlog传给从了)，如果redo没做，重启后就再做一次
### 引擎
1. 认识：基于表
   - 分类
     1. InnoDB
     1. MyISAM
        - Maria：设计取代MyISAM
     1. Memory；存在内存中，默认使用hash索引，比MyISAM快，只支持表锁，服务器停止数据丢失，用于临时表，所有字段为固定的长度
     1. Federated：不存数据，指向远程的表，不支持异构数据表

     1. Archive：提供高速的插入和压缩功能，只支持insert、select，使用zlib将行压缩存储，压缩比一比十，适合存储归档数据如日志，行锁，事务不安全
        - .arz后缀
     1. Merge：将具有相似结构的多个MyISAM表组合到一个表中的虚拟表
     1. Blackhole
     1. CSV
1. MyISAM
   - 认识：5.5之前的默认引擎，用于olap
     1. 不支持事务、不支持外键、表大小默认256TB
     1. 支持全文索引、压缩(myisampack)、空间函数，可以压缩为只读表
     1. 系统表、临时表的类型
   - 特点
     1. 缓冲池只缓冲索引，没有数据
1. CSV
   - 认识：不适合大表和在线处理。每次查询要全表扫描
     1. csv格式的文件方式存储
     1. 所有列不为null
     1. 不支持索引
   - 文件组成
     1. .csv：表内容
     1. .csm：表元数据，如状态和数据量
#### InnoDB
1. InnoDB
   - 认识：性能优秀
     1. 事务：支持sql标准的4种隔离级别
     1. 多种行级锁
     1. 非锁定读：通过读取undo实现，没有额外开销，默认读取不产生锁，因为没人改
     1. 通过工具支持热备份
     1. 支持崩溃后安全恢复
   - 特性
     1. mvcc
     1. insert buffer：插入缓存，性能提升
     1. double write：二次写
     1. adaptive hash index：主动式hash索引，读取数据时自动在内存构建hash索引
     1. read ahead：预读
     1. next-key locking：避免幻读phantom
1. 存储结构
   - 逻辑存储结构
     1. tablespace：表空间，包含数据、索引、插入缓冲bitmap，即ibd文件
        - 默认表空间文件初始大小10m、名称ibdate1
        - 可指定独立表空间，不用系统表空间，命名为tableName.ibd，提倡
        - 多文件可组合表示表空间，即多个磁盘文件负载可平均，可提高性能，可自动扩充大小
     1. segment/inode：段，innoDB自身控制，空间分配的最小单位。每个segment都会从表空间FREE_PAGE中分配32个page
        - 组成
          1. 索引段：b+tree的非叶子节点
          1. 数据段：b+tree的叶子节点
          1. 回滚段
        - page不够用的扩展规则
          1. 当前小于1个extent，则扩展到1个extent
          1. 小于32MB每次一个extent
          1. 大于32MB每次4个extent
     1. extent：区，连续页组成，都是1m，逻辑管理单位
     1. page：数据页/块，大小默认16k，页号是一个32位int表示页数量，对应innodb单表的64TB存储容量(16kb * 2^32)。innodb磁盘管理的最小单位
        - 结构
          1. 页头：页号、前后指针、伪记录
          1. 数据
          1. 空闲区
          1. 页目录
          1. 页尾：8byte，校验码
        - 类型
          1. b-tree node：数据页
          1. undo log page：undo页
          1. system page：系统页
          1. transaction system page：事务数据页
          1. insert buffer bitmap：插入缓冲位图页
          1. insert buffer free list：插入缓冲空闲列表页
          1. uncompressed blob page：未压缩的二进制页
          1. compressed blob page：压缩的二进制页
        - 和索引
          1. 在每个数据页里选出主键id和所在页号，组成新的record放入新生成的数据页中，加入上下页层级概念，就是B+树，用于加速查询，2层的2次io就可以完成
          1. 最末级叶子节点存放数据，其他只放下一步的页号
          1. 页的页号并不是连续的，在磁盘里也不一定是挨在一起的，这就是空洞
     1. row：行
        - 记录格式
          1. Redundant：稀疏，最早
          1. Compact：紧凑，5.0.3以后默认
          1. Dynamic：动态，将长字段完全off-page存储
          1. Compressed：压缩，行数据会以zlib算法进行压缩
   - 物理存储结构
     1. 数据文件
        - 系统表空间：存储系统数据，如information_schema
        - 用户表空间
        - 共享表空间：共用的，`.ibdata1`
        - 独占表空间：表独立存储，innodb_file_per_table=1开启
          1. `table_name.frm`：存储表结构信息
          1. `table_name.ibd`：存储数据
        - Undo表空间：存储Undo信息
     1. 日志文件
        - ib_logfileN：重做日志文件
1. 日志
   - 认识
     1. undo是回滚，redo是前滚
     1. redo和binlog相比
        - redo引擎层产生，binlog库上层产生，binlog会包含redo的
        - redo是物理格式，记录每个页的修改；binlog是逻辑日志，记录对应sql
        - 写入磁盘时机：redo不断写入，binlog事务commit后一次写入
   - undolog
     1. 认识：回滚日志，用于回滚/崩溃恢复，记录数据修改前的数据，记录与当前操作相反的逻辑日志，用于做相反操作
        - update/delete存放数据旧记录
        - insert记录新数据行的PK(rowid)
   - redolog
     1. 认识：重做日志，存储事务日志，保证可靠的事务，存储每个页的修改，不是某行
        - 一是延迟同步了磁盘文件，二是顺序写速度快，三可以用来恢复数据
        - InnoDB独有，顺序整块写，效率高。大小固定，写满后循环记录
        - 至少有一个文件组，至少2个文件，循环2个文件一个个写入。可有多个镜像日志组，更高可靠性，有了高可用方案如磁盘阵列可不用
        - 有LSN落后数量最多检查阈值，否则需要将缓冲池的脏页列表的部分写回磁盘，会阻塞用户线程
        - 不需要对redo进行读取
     1. 结构：有几十种类型
        - redo_log_type：类型
        - space：表空间id
        - page_no：页偏移量
        - redo_log_body：数据部分，恢复时需要调用相应函数进行解析
     1. 流程
        - 先写入buffer，然后顺序写入日志文件
        - 刷盘：根据innodb_flush_log_at_trx_commit确定刷盘策略
          1. 流程：![avatar](../images/redo-buffer.jpeg)
             - write pos：当前记录的LSN
             - check point：已刷盘的LSN，之前的已刷盘
             - check point到write pos是未刷盘的，当write pos追上check point，先推动check point向前移动，空出位置再记录新的日志
          1. 特点
             - 触发条件有主线程、事务提交
             - 主线程每秒将buffer写入文件，不论事务是否提交
             - 每秒刷盘和崩溃恢复的逻辑，innodb认为redo log在commit时不需要fsync了，写到page cache就够了
        - 固定512byte(扇区大小)写磁盘，扇区是写入的最小单位，保证写入必定成功，不需要doublewrite
     1. 组成
        - LSN：Log Sequence Number 日志逻辑序列号，版本标记的计数，单调递增的值，写多少日志，就加多少
        - checkpoint
          1. 认识：保证checkpoint之前的脏页都刷新回磁盘，那么崩溃恢复直接从checkpoint的点开始应用redo即可
          1. 分类
             - sharp checkpoint：保证所有的脏页刷新到磁盘
             - fuzzy checkpoint
          1. 触发情形
             - master thread固定频率checkpoint
             - redo log不够用了，强制checkpoint以释放redo空间被新事务覆盖(write pos追上check point)
             - buffer不够用了，LRU list淘汰page，淘汰的page属于脏页，需要强制checkpoint
     1. 配置
        - innodb_flush_log_at_trx_commit：提交事务时的文件写入策略
          1. 0：不写，等待主线程每秒刷新，10倍性能提升，最多丢失1秒的数据
          1. 1：默认，最安全，性能最差，调用fsync，为了保持持久性，必须为1，才能保证宕机能够用redo恢复。flush log除非磁盘或者操作系统做了伪刷新
          1. 2：异步写，等待操作系统落盘，不能保证commit时肯定写入了redo log，6倍性能提升
        - innodb_log_file_size：日志文件大小，太小老checkpoint性能抖动，太大恢复时间长
1. WAL
   - 认识：Write-Ahead Logging，日志先行，先写日志再持久化数据文件，保证持久化数据之前日志已经记录
     1. binlog和redo log都落盘了，保证mysql不丢数据
     1. 写磁盘需要随机写，顺序写性能高
   - 步骤
     1. 执行器通知引擎数据更新
     1. 引擎将新数据更新到脏页内存中
     1. 引擎此时开始记录redolog，并将该记录置为prepare状态
     1. 执行器写binlog
     1. 引擎提交事务，并更新此行数据的redolog状态为commit
     1. Force Log at Commit：持久化redo后才能进行事务的commit，保证持久性
     1. 当MySQL空闲时，会将内存中的数据落盘
   - 解释
     1. 步骤
        - 账本记录卖一瓶可乐（redolog 处于 prepare）
        - 收钱放入抽屉（binlog）
        - 收完钱，在账本该记录上打对勾，代表抵账（redolog 置为 commit）
     1. 纠错
        - 若收钱过程被打断，则整理交易时，发现只是记账了却没收钱，则删除该账本记录（回滚）
        - 若收了钱，有事情耽误了抵账，那么之后闲下来对账的时候，将账本该记录打勾即可（即commit）
1. double write
   - 认识：两次写，保证redo数据页的完整可靠性。即再写一个页的副本，redo前先通过副本还原该页。有些文件系统提供了部分写失效的防范机制(ZFS)，不用开启两次写
     1. 部分写失效：一页没有写完整，redo log是无法解决，页本身损坏重做无意义
     1. 文件系统写失效：只写入了页缓存，并没有同步到磁盘上
        - unix的高速页缓存机制：大多数磁盘io都通过缓冲进行，用fsync主动触发，同步磁盘太慢了
   - 组成
     1. 内存buffer：2m大小
     1. 共享表空间：2m大小，连续128个页，2个区extent
   - 写入流程：在redo commit之后进行
     1. 缓冲池脏页刷新时，先memcpy到buffer
     1. buffer分2次，每次1m顺序写入共享表空间，然后立即fsync
        - 因为顺序写入，开销不大
     1. buffer再写入各个表空间
   - 恢复流程
     1. redo log失败的话，通过binlog计算正确的数据，重新写入redo log
     1. 从redo log获取页副本，复制到redo log，再应用重做操作
1. 索引
   - 认识：聚集方式
     1. 数据存在共享表空间，可通过配置分开
     1. 索引是其表空间的组成部分
   - innoDB表都有聚集索引
     1. 如果定义了PK，则PK就是聚集索引
     1. 如果表没有定义PK，则第一个非空unique列是聚集索引
     1. 否则，InnoDB会创建一个隐藏的rowid作为聚集索引
   - 行锁的实现：通过给索引上的索引项加锁来实现，![avatar](../images/db/innoDB_struct.jpeg)
1. wiki
   - innoDB最早是第三方引擎，被oracle收购，5.5.8开始是默认引擎
### 日志
1. 数据更新流程
   - 认识：流程和wal一致，![avatar](../images/mysql-update.jpeg)
     1. 读写数据：缓存提高效率
        - 脏页：缓存中的数据发生变更的内存页
        - 刷脏页：数据发生变更的缓存刷到磁盘中
     1. mysql宕机：缓存中数据来不及刷盘，数据丢失，需要用日志恢复
     1. 磁盘特点：写入系统文件缓存page cache，并没有持久化，非常快，和写内存差不多(本质就是写内存)。一般fsync才占用iops
     1. 两阶段提交：平衡各方都完成
     1. 正常数据落盘和redo没有关系，脏页到ibdata
     1. 事务回滚：redo中commit的发现LSN落后的就重放刷盘，没commit的判断binlog是否完整来重新commit或者回滚
   - 重启操作
     1. 数据页中的LSN小于redo log的LSN，说明redo log上记录着数据页没完成的操作，就会从最近的一个check point出发，开始重放刷盘
     1. 数据库重启先进行crash recovery保证crash-safe，binlog和redolog通过事件xid关联，保证数据一致性
   - 双一问题：可以主双一，从非双一，提高性能
     1. sync_binlog不为1，服务器宕机会丢失binlog
     1. innodb_flush_log_at_trx_commit为1
        - 可以在redo commit时不进行fsync，就无法保证一致性，但是提高了效率
        - innodb_support_xa不为1，redo没commit重启后要回滚，但是binlog记录了，造成问题
   - 数据丢失场景
     1. mysql宕机：写入了文件缓存就丢不了
     1. 服务器宕机：没有设置双一，就可能丢
1. binlog
   - 认识：记录所有除查询的DDL和DML语句，以事件形式记录的事务安全型的二进制文件集合，包含执行的时间
     1. 具体的写入时间：配置控制是否执行fsync，只写入了缓存
     1. 会重写密码，不以纯文本展示；8可以进行加密
     1. 生成新的日志文件的情况：重启时、执行`flush logs`、大小超过`max_binlog_size`
     1. 开启1%的性能开销
   - 用途
     1. 主从复制：传输binlog
     1. 数据恢复：使用mysqlbinlog工具，可进行任意时间点恢复
     1. 增量备份
     1. 审计：是否有攻击
   - 组成
     1. xx.index：索引文件，存储产生的二进制日志序号
     1. xx.0001
        - 格式
          1. Statement：基于sql和上下文环境，不记录每行变化
             - 减少了日志量节约了io，尤其是修改量大的场景
             - 主从版本可以不一样，从可以更高
          1. Row：只记录行的修改点，5.7.7及以上默认，会一步步的优化的更好，主流使用，之前是Statement。最好同时设置`binlog_row_image=minimal`
             - 避免了存储过程/function/trigger的调用和触发无法被正确复制的问题
             - 加快从库重放日志的效率
             - 日志量大，`alter tableh`每条都会记录，新版优化了
          1. MIXED：混合模式，系统选择，一般用statment，无法完成主从复制的操作用row
        - 事件类型：QUERY_EVENT、STOP_EVENT等
   - 格式对复制的影响
     1. Statement
        - 为slave正确运行而记录相关信息，但uuid()等非确定性函数还是无法复制导致主从不一致
        - 日志量较row小
        - 需要更多的行锁，主上锁多长时间，从就锁多久
     1. Row
        - 包含了要精确操作的行的主键ID，不会出现主从不一致
        - 日志量较statement大多了
        - 可应用于任何sql的复制，包括非确定函数、存储过程等
        - 传输数据量大，网络不好延迟大，同机房可保证更好
        - 减少锁的使用，因为更新时只锁那一条
        - 要求主从表结构相同
        - 无法单独执行触发器
     1. Mixed
        - 当MySQL判断可能数据不一致时用row格式，否则用statement格式
   - 写入流程
     1. 基于session，根据binlog_cache_size写入缓存或临时文件
     1. group commit，写入磁盘，清空缓存，同时根据sync_binlog判断是否fsync
   - 特点
     1. 一个事务的binlog不会拆开，要确保一次性写入
     1. 事务组提交：group commit，会把后边来的事务一起处理，到时候他们直接返回，一起处理的越多，效果越好
   - 使用
     1. 配置
        - log-bin：是否开启binlog及文件名
        - binlog_cache_size：未提交的日志记录缓存的大小，超过了写入临时文件，基于会话。binlog_cache_use、binlog_cache_disk_use用于判断设置是否合适
        - sync_binlog：写缓冲多少次就同步磁盘，1是同步写磁盘，默认0，建议设置为100~1000
        - innodb_support_xa：为1解决binlog和innodb的数据文件的同步
        - max_binlog_size：单个最大值，超过就加序号新建文件
        - binlog-do-db/binlog-ignore-db：要记录库的范围
        - log-slave-update：从库需要设置，不记录自己的master的日志
        - binlog_format：格式
        - expire_logs_days：保存天数
     1. sql
        - `show variables like '%log_bin%';`：查看配置
        - `show variables like 'binlog_format';`：查看格式
          1. `set global binlog_format='ROW/STATEMENT/MIXED';`：清空所有
        - `show binary logs;`：查看二进制文件列表和大小
        - `show binlog events in '' from pos limit [offset,]count;`：查看某个binlog
        - `show master status;`：查看日志写入状态
        - `reset master;`：清空所有
     1. 工具
        - mysqlbinlog：查看、恢复
          1. -v/-vv：显示详细信息
          1. 直接恢复：`mysqlbinlog /var/lib/mysql/mysqld-bin.000001 | mysql -uroot`
          1. --database DB_name
          1. --no-defaults 
          1. --start/stop-datetime、--start/stop-position
1. GTID
   - 认识：Global Transaction ID 全局事务id，已提交事务的唯一的编号，v5.6。格式：source_id:transaction_id
     1. 全局唯一性
     1. 趋势递增
   - 作用
     1. 保证了同一个事务只在指定的从库执行一次，可以找到正确的复制位置，大大简化复制的维护
     1. 强化了主备一致性，故障恢复以及容错能力
        - 之前基于二进制日志的复制中从库需要告知主库从哪个偏移量进行增量同步，如果指定错误会造成数据的遗漏，从而造成数据的不一致
