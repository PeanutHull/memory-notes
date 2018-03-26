1. 认识
   - 基于Apache Lucene构建的开源搜索引擎，用于数据搜索、数据分析、数据仓库
   - java编写，提供简单的RESTFul API
   - 支持集群部署，支持PB级结构化/非结构化数据处理，速度超快
1. 理解
   - 集群和节点
   - 索引、类型、文档：即库、表、数据，文档是最小存储单位，必须属于一个类型。索引名称必须小写，无下划线，分为结构化/非结构化，就是没有那些字段吧
   - 分片、备份
     1. 分片：每个索引都有多个分片，每个分片是一个Lucene索引。分担索引压力，提高搜索效率，可以进行水平拆分，默认5个
     1. 备份：即备份分片，默认1个
1. 使用
   - api格式：http://<ip>:<port>/<索引>/<类型>/<文档>
   - 动词：get/post/put/delete
1. 查询
   - 简单查询
     1. `http://ip/索引名/类型/文档id`，get方法
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
   - 配置管理工具elasticsearch-head
     1. wget github/elasticsearch-head && cd head
     1. npm install
     1. npm run start
     1. 最下边添加es配置，解决两个进程跨域问题
        - http.cors.enabled: true
        - http.cors.allow-origin: "*"
1. wiki
   - 默认端口：9200
   - web端管理工具：
   - 版本历史：1.x->2.x->5.x
   - head中粗线框为主分片，细的为备份分片