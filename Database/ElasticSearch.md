### ElasticSearch
1. 认识：基于apache lucene构建的开源分布式数据搜索和分析引擎。java编写
   - 特点
     1. 支持结构化、非结构化搜索，不需要提前定义模式
     1. 近实时存储/检索数据
     1. 支持PB级结构化/非结构化/地理位置/指标数据处理，速度超快
     1. 分布式存储：索引拆分为分片，分片多副本
     1. 提供简单的RESTFul API
     1. 支持集群部署：水平扩展、跨集群复制热备
     1. 支持插件机制：分词/同步/Hadoop/可视化
   - 设计
     1. 全文索引
     1. 多词条查询、匹配度与权重、自动联想、拼写纠错
     1. 负载再平衡和路由大多自动完成
1. 场景
   - 适用
     1. 实时数据搜索：作为关系型数据库全文、多词条搜索的功能补充，将进行全文搜索的数据缓存一份到elasticSearch上，达到处理复杂的业务与提高查询速度的目的
     1. 数据仓库
     1. 数据分析：数据聚合、日志处理与分析
   - 不适用
     1. 事务性、强一致
     1. 权限划分
1. 组成
   - index：索引，库，相同属性的文档集合。分为结构化/非结构化，名称必须小写/无下划线(es关键字前缀为_)，可精确搜索
     1. shards：分片，索引被分为多个分片，es汇总每个分片的查询结果，可水平拆分，默认5个。提高吞吐量、实现高可用
        - 副本：是某个分片的复制
          1. 主分片
   - Type：类型，表，属于index，新版本会干掉
   - Document：文档，行，最小存储单位，属于type
     1. Field：列，属于document。数据类型为
        - 布尔：boolean
        - 二进制：binary
        - 数值：byte、integer、short、long、float、double、half_float(节省空间)、scaled_float
        - 字符串：text、keyword
        - 日期：date
        - 范围类型：integer_range|long_range、float_range|double_range、date_range，新增
     1. MetaData：元数据，用于标注文档信息
        - _index：所在索引名
        - _type：所在类型名
        - _id：唯一id
        - _uid：组合id，由_type和_id组成(6.x，那俩都不起作用)
        - _source：原始json数据
        - _all：组合所有字段内容，占空间，查询慢，新版本默认禁用
   - Mapping：关系描述。index类型，type处理规则，分词处理规则
     1. 为空则为非结构化
1. 集群、节点
1. Query DSL
### Restful Api
1. 使用：
   - http api：http://ip/index/type/doc，get/post/put/delete
     1. 匹配：xx|,|*|_all，单个|多个|通配符|所有
   - Kibana DevTools
1. 索引
   - 查看：`http://ip/index/_settings`，get
   - 创建
        ```json
        // http://ip/index put
        {
            "setting": {                                            // 设置
                "number_of_shards": 5,                                      // 分片数
                "number_of_replicas": 1,                                    // 副本数
                // 分词设置
                "analysis": {
                    "char_filter": {},
                    "tokenizer": {},
                    "filter": {},
                    "analyzer": {
                        "xx": {
                            ...
                        }
                    },
                }
            },
            "mappings": {
                "xx": {                                             // 类型
                    "properties": {                                         // 属性
                        "xx": {                                             // 名称
                            "type": "integer/test/keyword",                 // 字段类型
                            "analyzer": "xx"                                // 指定分词器
                        },
                        "xx": {
                            "type": "date",
                            "format": "yyyy-MM-dd HH:mm:ss || epoch_millis" // || 或的意思
                        }
                    }
                },
            }
        }
        ```
1. 文档
   - 文档数据结构
        ```json
        {
            "_index": "xx",
            "_type": "xx",
            "_id": "xx",
            "_version": x,                                          // 每次更新操作+1，乐观锁的机制，同步更新时发现更新版本小于当前版本则拒绝修改
            "result": "created/updated",
            "_shards": {
                "total": x,
                "successful": x,
                "failed": x,
            },
            "_seq_no": x,
            "_primary_term": x
        }
        ```
   - 插入
     1. 分类
        - 指定id：put方法，`http://ip/index/type/doc_id`
        - 自动生成id：post方法，`http://ip/index/type`
     1. 请求参数
        ```json
        {
            "xx": "name",                                           // 要写入的字段即可
            "date": "2000-01-01"
        }
        ```
   - 批量更新
     1. 意义：一次操作多个文档，减少网络传输开销，提升速率
     1. 使用：`http://ip/_bulk`，post方法，请求体隔一行json一个单独操作，新增和更新紧接着下一行是内容数据。先指定索引和类型，再传数据
     1. 操作分类
        - index：文档已存在覆盖，`{"index":{"_index":"xx", "_type":"xx", "_id":"xx"}}`，换一行是具体文档内容如`{"xx":"xx"}`
        - update
        - create：文档已存在报错
        - delete
   - 批量查询：`http://ip/_mget`，
    ```json
    {
        "docs": [
            {
                "_index": "xx",
                "_type": "xx",
                "_id": "xx",
            }
        ]
    }
    ```
1. 更新
    ```json
    // restful方式

    // http://ip/index/type/doc_id，put方法
    {
        "xx": "xx",                                             // 覆盖
    }
    // http://ip/index/type/doc_id/_update，post方法
    {
        "doc": {
            "xx": "xx",                                         // 更新字段
        }
    }
    

    // 脚本方式
    {
        "script": {
            "lang": "painless/python",                          // painless为es内置脚本语言
            "inline": "ctx._source.age (+= 10/params.age)",     // 脚本内容
            "params": {
                "age": 11
            }
        }
    }
    ```
1. 删除：`http://ip/index/type/doc_id`，http地址最后到哪级删哪级，delete方法
1. 查询
   - 简单查询
     1. `http://ip/index/type/doc_id`，get方法
     1. `/_search?q=xx`，get方法，没有指定字段，使用_all字段。等于将所有字段值连接起来，一起搜索关键字
   - 条件查询
        ```json
        // `http://ip/index/_search`，post方法
        {
            "query": {
                // 字段查询：查询结构化数据，如数字、日期
                "term": {                               // 字段查询，可以使用元数据字段
                    "xx1|_id": x,
                    "xx2": x
                },
                "terms": {                              // 单字段多关键字查询
                    "xx": ["xx","xx"]
                },
                "range": {                              // 范围
                    "xx": {
                        "gte/gt": "2017-01-01",
                        "lte/lt": "now"
                    }
                },

                // 文本查询：文本类型
                "match_phrase": {                       // 精确匹配
                    "xx": "xx"
                },                    
                "match": {                              // 模糊匹配，会进行分词查询
                    "xx": "xx"
                },
                "mult_match": {                         // 多字段同时模糊匹配某一内容
                    "query": "",
                    "fields": ["xx", "xx "]
                },
                "match_all": {},                        // 查询所有

                "query_string": {                       // 语法查询，根据语法规则查询。支持多字段，支持通配符、范围查询、布尔查询、正则
                    "query": "(xx AND xx) OR xx",
                    "fields": {
                        "xx": "",
                        "xx": ""
                    }
                },

                // Query Context，提供_score标识匹配程度。先比较查询条件，然后计算分值，最后返回文档结果
                // Filter Context，查询中只判断是否满足条件，只有是或否，会将结果缓存，比Query快点，对结果缓存，不计算分值
                "bool": {                               // 布尔查询，包含四个子句，filter/should/must/must_not
                    "filter": {
                        "term": {
                            "xx": x
                        },
                        "range": {
                            "xx": {"gt": x}
                        }
                    },
                    "should": [                         // 或的关系
                        "match": {
                            "xx": ""
                        },
                        "match": {
                            "xx": x
                        }
                    ],
                    "must": [
                        "match": {
                            "xx": ""
                        },
                        "match": {
                            "xx": x
                        }
                    ],
                    "must_not": [],
                },
                "constant_score": {                     // 固定分数查询
                    "filter": {
                        "match": {
                            "xx": x
                        }
                    },
                    "boost": x                          // 指定分数
                }
            },
        }
        ```
   - 聚合查询
    ```json
    {
        "aggs": {                                       // 聚合查询关键词
            "xx": {                                         // 聚合查询名称
                "terms": {                                  // 关键词
                    "field": ""                             // 聚合类型
                },
                "stats/min/max": {"field": ""}              // 进行统计计算，如统计/最小/最大
            }
        }
    }
    ```
   - 配置
    ```json
    {
        "highlight": {                              // 高亮
            "field": {
                "name": {}
            }
        },
        "_source": ["xx"],                          // 只取某个字段
        "sort": [
            {"xx": "desc"}                          // 排序
        ],
        "from": 1,                                  // 分页
        "size": 1,
    }
    ```
   - 分页
     1. from + size
     1. scroll：指定保存时间，快照一个个查询
     1. sliced scroll：切片方式指定多scroll并行查询，指定上下文保留时间、最大切片、当前切片
        ```json
        // GET /twitter/_search?scroll=1m
        {
            "slice": {
                "id": 1,
                "max": 2
            },
            "query": {
                "match" : {
                    "xx" : ""
                }
            }
        }
        ```
     1. search after：动态指针的方案，基于上一页排序值检索下一页实现动态分页。search_after操作需要指定一个支持排序且值唯一的字段用来做下一页拉取的指针，这种翻页方式也可以通过bool查询的range filter实现。`"search_after": [1463538857, "654323"],`
   - 结果解析
    ```json
    {
        "took": x,                              // 花费时间，毫秒
        "timed_out": false,                     // 是否超时，可指定最长搜索时间
        "_shards": ...,                         // 参与查询的分片数据，可能有分片失败
        "hits": {
            "total": x,
            "max_score": 1,
            "hits": [                           // 结果集合，默认前10个
                {
                    "_index": "xx",
                    "_type": "xx",
                    "_id": "xx",
                    "_score": x|null,           // 指定排序返回null
                    "_source": {
                        "xx": "xx",
                    },
                }
            ]
        }
    }
    ```
### 应用
1. 工具
   - elasticsearch-head：web管理工具。粗线框为主分片，细的为备份分片
     1. 安装
        - `wget github/elasticsearch-head && cd head`
        - `npm install`
        - `npm run start`
        - `http.cors.enabled: true`，`http.cors.allow-origin: "*"`：最下边添加es配置，解决两个进程跨域问题，
   - elasticsearch-ik：中文分词插件
   - elasticsearch-jdbc：mysql数据导入和计划任务，编写脚本即可实现
   - logstash-input-jdbc：mysql数据同步更新，可做全量同步和增量同步，数据表中定义订阅的update_time字段即可，其他的可以订阅binlog
   - esrally：es压测工具
1. Elastic Stack：新一代ELK
   - elasticsearch：存储、查询、分析
   - logstash：数据收集、聚合
   - Beats：数据收集、聚合
     1. ETL：Extract Transform Load，数据源多样
        - 数据文件：日志、excel
        - 数据库：mysql
        - http服务
        - 网络数据
   - kibana：可视化显示
### 运维
1. 安装/运行
   - `wget es.tar && tar -vxf es.tar && cd es`
   - `./bin/elasticsearch (-d 后台启动)`
1. 配置主从
   - master
     1. cluster.name: clusterName
     1. node.name: master
     1. node.master: 
   - slave
     1. cluster.name: clusterName
     1. node.name: slave1
     1. network.host: ip
     1. http.port: 9201
     1. discovery.zen.ping.unicast.hosts: ["ip"]        // 主节点ip
### wiki
1. 相关
   - 默认端口：9200
   - 版本历史
     1. 1.x
     1. 2.x
     1. 5.x：直接从2到6，支持lucene6性能大幅提升，磁盘空间少一半，索引建立时间少一半，查询性能提升25%，支持ipv6
     1. 7.4
   - 结构化/非结构化数据：无法用统一结构表示的，可称为全文数据
1. 问题
   - term是模糊还是精确匹配？
### pro
1. 搜索引擎
   - 认识：先分词，通过倒排索引获取文档id，再用正排索引获取完整内容
   - 索引类型
     1. 倒排索引：单词到文档id，即书后边的索引
        - 单词词典：Term Dictionary，一般使用B+Tree数实现
          1. 记录所有文档的单词，比较大
          1. 记录单词到倒排列表的偏移
        - 倒排列表：Posting List，记录单词对应文档的集合，由倒排索引项组成。es中每个字段都有自己的倒排索引
          1. 文档id：查最终内容
          1. 单词频率：出现次数，用于相关性算分
          1. 位置：记录文档中的分词位置，用于词语搜索
          1. 偏移：在文档中的开始和结束位置，用于高亮显示
     1. 正排索引：文档id到内容/单词
   - 分词器
     1. 认识：Analyzer，es中处理分词的组件，在查询、新增和更新时使用
        - 分词：analysis，将文本转换成一系列term(单词)，也叫文本分析
     1. 组成
        - character filters：原始文本处理
          1. html strip：去除html标签、转换html实体
          1. 根据mapping进行字符替换
          1. 正则匹配替换
        - tokenizer：按照一定规则切分为term
          1. standard：按照单词
          1. letter：按照非字符类
          1. whitespace：按照空格
          1. UAX URL Email：按照standard，不会分割邮箱和url
          1. NGram/Edge NGram：按照连词，自动提示用到，即结果都是相近的
          1. Path Hierarchy：按照文件路径
        - token filters：对切分后的term再加工，如转小写/删除/近义词/同义词，的/这等语义词处理
          1. lowercase
          1. stop：删除stop word
          1. NGram/Edge NGram
          1. Synonym：添加近义词
     1. 分类
        - standard：默认，按词切分，支持多语言，小写处理
        - simple：非字母切分，小写处理
        - whitespace：空格切分
        - stop：比simple多了stop word处理(指语气助词)
        - keyword：不分词，作为一个单词输出
        - pattern：通过正则自定义分隔符，默认\W+，即非单词，小写处理
        - language：提供常见30种语言的分词器
     1. 中文分词：没有形式上的分隔符(如空格)，一句话多歧义的问题
        - IK：支持中英文切分，可自定义词库，支持热更新分词词典
        - jieba：python中最流行的分词系统，支持词性标注、自定义词典、并行分词、繁体分词
        - 基于自然语言处理的分词系统：HanLp，一系列模型和算法组成的java工具包。THULAC
     1. 调试
        - 认识：es提供验证分词效果的api
        ```json
        // 指定Analyzer
        POST _analyze
        {
            "analyzer": "standard",                 // 分词器
            "text": "xx"                            // 测试文本
        }
        // 指定索引中的字段
        POST index/_analyze
        {
            "field": "xx",                          // 测试字段
            "text": "xx"
        }
        // 自定义分词器
        POST _analyze
        {
            "tokenizer": "standard",                // 分词
            "char_filter": ["html_strip"],          // 原始文本处理
            "filter": [                             // 指定token filters
                "lowercase",
                {
                    "type": "ngram",
                    "min_gram": x,
                    "max_gram": x,
                }
            ],
            "text": "xx"
        }
        ```
     1. 最佳实践
        - 不需要分词的将type设置为keyword，以节省空间和提高写性能
        - 多用分词api查看结果，多测试
1. 顺序扫描法/索引扫描法：将全文数据一部分提取出来变成一定结构，加快搜索速度
1. 原理：将文档传给分词组件，将每一个词排序、记录位置并形成链表，搜索的时候直接查索引。lucene被认为是最好的搜索引擎
1. 优化方式：集群规划、索引配置、存储策略、索引拆分、冷热分区、段合并等几个维度优化
1. 通过有限状态转换器实现全文检索的倒排索引：用于存储数值数据的BKD树，和用于分析的列存储
   - 存储数据时按有序存储
   - 将数据和索引分离；
   - 压缩数据
