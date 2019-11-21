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
   - index：索引，库，相同属性的文档集合。分为结构化/非结构化，名称必须小写/无下划线，可精确搜索
     1. shards：分片，索引被分为多个分片，es汇总每个分片的查询结果，可水平拆分，默认5个
        - 副本：是某个分片的复制，提高吞吐量、实现高可用
          1. 主分片
   - Type：类型，表，属于index
   - Field：列，属于type
   - Document：行，最小存储单位，属于type
   - Mapping：关系描述。index类型，type处理规则，分词处理规则
     1. 为空为非结构化
1. 集群、节点
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
1. ELK：elasticsearch、logstash、kibana三个组件，包含日志收集、聚合、多维度查询、可视化显示
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
### http api
1. 使用：http://ip/索引/类型/文档，restful形式，get/post/put/delete
1. 创建索引
    ```json
    // http://ip/index
    {
        "setting": {                                            // 设置
            "number_of_shards": 5,                                      // 分片数
            "number_of_replicas": 1,                                    // 副本数
        },
        "mappings": {
            "man": {                                            // 类型
                "properties": {                                         // 属性
                    "xx": {                                             // 名称
                        "type": "integer/test/keyword"                  // 字段类型
                    },
                    "date": {
                        "type": "date",
                        "format": "yyyy-MM-dd HH:mm:ss || epoch_millis" // || 或的意思
                    }
                }
            }
        }
    }
    ```
1. 插入文档
    ```json
    // http://ip/index/type/doc_id，使用put指定id，使用post不传id自动生成
    {
        "xx": "name",                                         // 要写入的字段即可
        "date": "2000-01-01"
    }

    // 文档数据结构
    {
        "_index": "xx",
        "_type": "xx",
        "_id": "xx",
        "_version": x,
        "result": "created/updated",
        "_shards": {
            "total": x,
            "successful": x,
            "failed": x,
        },
    }
    ```
1. 更新
    ```json
    // restful方式：http://ip/index/type/doc_id/_update，post方法
    {
        "doc": {
            "xx": "xx",                                         // 要更新的字段
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
   - 简单查询：`http://ip/index/type/doc_id`，get方法
   - 条件查询
        ```json
        // `http://ip/index/_search`，post方法
        {
            // Query Context，判断是否满足查询条件，同时提供_score标识匹配程度


            "query": {

                // 全文本查询：文本类型
                "match_phrase": {                       // 精确匹配
                    "xx": "xx"
                },                    
                "match": {                              // 模糊匹配
                    "xx": "xx"
                },
                "mult_match": {                         // 多字段同时模糊匹配
                    "query": "",
                    "field": {
                        "xx": ""
                    }
                },
                "match_all": {},                        // 查询所有
                query_string: {                         // 语法查询，表达的比较丰富
                    query: "(xx AND xx) OR xx"
                    field: {
                        name: ""
                        description: ""
                    }
                }

                // 字段级别查询：结构化数据，如数字、日期
                term: {
                    age: 1
                }
                range: {                            // 范围查询
                    date: {
                        gt: 2017-01-01
                        lte: now
                    }
                }

                // Filter Context：查询中只判断是否满足条件，只有是或否，会将结果缓存，比Query快点
                bool: {                             // 布尔查询
                    should: {
                        match: {
                            name: ""
                        }
                        match: {
                            age: 1
                        }
                    }
                    must: {
                        match: {
                            name: ""
                        }
                    }
                    must_not: {}                
                    filter: {
                        term: {
                            age: 1
                        }
                    }
                }
                constant_score: {                   // 固定分数查询
                    filter: {
                        match: {
                            age: 1
                        }
                    }
                    boost: 2
                }
            },
            "sort": [
                {"date": {"order": "desc"}}         // 排序
            ],
            "from": 1,                              // 分页
            "size": 1,
        }

        // 结果解析
        {
            "took": x,                              // 花费时间，毫秒
            "timed_out": false,
            "_shards": ...,
            "hits": {
                "total": x,
                "max_score": 1,
                "hits": [                           // 结果集合
                    {
                        "_index": "xx",
                        "_type": "xx",
                        "_id": "xx",
                        "_score": x|null,           // 指定排序返回null
                        "_source": {
                            "xx": "xx",
                            "date": "xx",
                        },
                    }
                ]
            },
        }
        ```
   - 聚合查询
    ```json
    {
        "aggs": {                                     // 聚合查询关键词
            "xx": {                                       // 聚合查询名称
                "terms": {                                // 关键词
                    "field": "word_count/publish_date"    // 聚合类型，如字数统计，发布时间等
                },
                "stats/min/max": {"field": ""}            // 进行统计计算，如统计/最小/最大
            }
        }
    }
    ```
   - 分页
     1. from + size
     1. scroll：指定保存时间，快照一个个查询
     1. sliced scroll：切片方式指定多scroll并行查询，指定上下文保留时间、最大切片、当前切片
        ```json
        GET /twitter/_search?scroll=1m
        {
            "slice": {
                "id": 1,
                "max": 2
            },
            "query": {
                "match" : {
                    "title" : "elasticsearch"
                }
            }
        }
        ```
     1. search after：动态指针的方案，基于上一页排序值检索下一页实现动态分页。search_after操作需要指定一个支持排序且值唯一的字段用来做下一页拉取的指针，这种翻页方式也可以通过bool查询的range filter实现。`"search_after": [1463538857, "654323"],`
### pro
1. 顺序扫描法/索引扫描法：将全文数据一部分提取出来变成一定结构，加快搜索速度
1. 原理：将文档传给分词组件，将每一个词排序、记录位置并形成链表，搜索的时候直接查索引。lucene被认为是最好的搜索引擎
1. 优化方式：集群规划、索引配置、存储策略、索引拆分、冷热分区、段合并等几个维度优化
1. 通过有限状态转换器实现全文检索的倒排索引：用于存储数值数据的BKD树，和用于分析的列存储
   - 存储数据时按有序存储
   - 将数据和索引分离；
   - 压缩数据
