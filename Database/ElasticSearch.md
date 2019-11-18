### ElasticSearch
1. 认识
   - 基于Apache Lucene构建的开源搜索引擎，用于数据搜索、数据仓库、数据分析
   - 支持集群部署，支持PB级结构化/非结构化数据处理，速度超快
   - java编写，提供简单的RESTFul API
1. 组成
   - 索引、类型、文档，文档是最小存储单位，必须属于一个类型。索引名称必须小写，无下划线，分为结构化/非结构化，就是没有那些字段吧。结构化/非结构化：无法用统一结构表示的，可称为全文数据
     1. 索引：库
     1. 类型：表
     1. 文档：数据
   - 集群和节点
   - 分片、备份
     1. 分片：每个索引都有多个分片，每个分片是一个Lucene索引。分担索引压力，提高搜索效率，可以进行水平拆分，默认5个
     1. 备份：即备份分片，默认1个
### 使用
1. 使用
   - http方式：http://ip/索引/类型/文档，get/post/put/delete
1. 查询
   - 简单查询：`http://ip/索引名/类型/文档id`，get方法
   - 条件查询
     1. `http://ip/索引名/_search`，post方法
        ```json
        query: {
            // Query Context，判断是否满足查询条件，同时提供_score标识匹配程度            
            // 全文本查询：文本类型
            match_all: {}                       // 查询所有
            match_phrase: {}                    // 精确匹配
            match: {                            // 模糊匹配
                description: ""
            }
            mult_match: {                       // 多个字段同时模糊匹配
                query: ""
                field: {
                    name: ""
                    description: ""
                }
            }
            query_string: {                     // 语法查询，表达的比较丰富
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
        }
        sort: {
            date: {order: desc}
        }
        from: 1,
        size: 1,
        ```
   - 聚合查询
    ```json
    aggs: {
        aggs_name1: {                           // 聚合名称
            terms: {                            // 关键词
                field: ""                       // 聚合的类型
            }
            stats/min/max: {field: ""}          // 统计计算
        }
        aggs_name2: {
            terms: {
                field: ""
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
1. 创建/指定索引：`http://ip/索引名`
```json
{
    setting: {
        number_of_shards: 5,
        number_of_replicas: 1,
    }
    mappings: {
        man: {                                      // 索引类型的映射
            properties: {
                name: {
                    type: test
                }
                description: {
                    type: keyword
                }
                age: {
                    type: integer
                }
                date：{
                    type: date
                    format: yyyy-MM-dd HH:mm:ss || epoch_millis
                }
            }
        }
        woman: {}
    }
}
```
1. 插入：`http://ip/索引名/类型/文档id，默认put方法，不传id会自动生成，使用post方法`
```json
{
    name: name,
    age: 1,
    date: 2000-01-01
}
```
1. 修改：`http://ip/索引名/类型/文档id/_update`，post方法
   - restful
   - 脚本
    ```json
    script: {
        lang: painless/python           // painless为es内置脚本语言
        inline: ctx.source.age (+= 10/params.age)
        params: {
            age: 11
        }
    }
    ```
1. 删除：http地址定位到哪级执行哪级的，delete方法
1. 运维
   - 安装：wget es.tar && tar -vxf es.tar && cd es
   - 运行：./bin/elasticsearch (-d 后台启动)
   - 配置主从
     1. master
        - cluster.name: clusterName     // 集群名称
        - node.name: master
        - node.master: 
     1. slave
        - cluster.name: clusterName
        - node.name: slave1
        - network.host: ip
        - http.port: 9201
        - discovery.zen.ping.unicast.hosts: ["ip"]        // 主节点ip
1. wiki
   - 默认端口：9200
   - 版本历史：1.x->2.x->5.x
   - ELK：elasticSearch、logstash、kibana
### 应用
1. elasticsearch-head：web管理工具。粗线框为主分片，细的为备份分片
   - 安装
     1. wget github/elasticsearch-head && cd head
     1. npm install
     1. npm run start
     1. 最下边添加es配置，解决两个进程跨域问题，`http.cors.enabled: true`，`http.cors.allow-origin: "*"`
1. elasticsearch-ik：中文分词插件
1. elasticsearch-jdbc：mysql数据导入和计划任务，编写脚本即可实现
1. logstash-input-jdbc：mysql数据同步更新，可做全量同步和增量同步，数据表中定义订阅的update_time字段即可，其他的可以订阅binlog
### pro
1. 顺序扫描法/索引扫描法：将全文数据一部分提取出来变成一定结构，加快搜索速度
1. 原理：将文档传给分词组件，将每一个词排序、记录位置并形成链表，搜索的时候直接查索引。lucene被认为是最好的搜索引擎
1. 优化方式：集群规划、索引配置、存储策略、索引拆分、冷热分区、段合并等几个维度优化
