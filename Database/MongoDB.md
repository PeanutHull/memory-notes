### MongoDB
1. 认识
   - 解释：基于文档的非关系型数据库。文档按照BSON(json的轻量化二进制格式)存储，增删改查等命令和js语法很像。
   - 组成：集合(collection)和文档(document)来描述和存储数据，collection相当于表，document相当于行，但是一个集合里的文档可以有不同的结构。
1. 连接：mongo默认启动无鉴权，可以配置
1. 集合操作
   - 查
    ```sql
    use accounts
    show collections
    // 得到集合对象
    use accounts
    coll = db.getCollection("accounts")
    ```
   - 增
    ```sql
    // 无新建数据库功能，可以先切库，再新建库
    use accounts
    db.createCollection('accounts')
    show dbs
    ```
   - 改
   - 删
    ```sql
    use accounts
    db.dropDatabase()
    // 和
    use accounts
    coll = db.getCollection("accounts")
    coll.drop();
    ```
1. 文档操作
   - 查
    ```sql
    use accounts
    coll = db.getCollection("accounts")
    coll.find({name:"ZhangSan"})
    ```
   - 增
    ```sql
    use accounts
    coll = db.getCollection("accounts")
    coll.insert({name:"ZhangSan",password:"123456"})
    coll.insert({name:"WangEr",password:"nicai"})
    ```
   - 改
    1. save(obj)
    ```sql
    // 直接更新对象
    coll.save({_id:ObjectId("55cc3e25b36"),name:"ZhangSan",password:"5690"})
    ```
    1. update(query, update, options)。
    ```sql
    coll.update({name:"ZhangSan"},{name:"ZhangSan",password:"567890"})
    // 或者
    coll.update({name:"ZhangSan"},{$set: {password:"567890"}});
    ```
   - 删
    ```sql
    // 将传入的对象属性和数据库的对比，匹配到即删除
    use accounts
    coll = db.getCollection("accounts")
    coll.remove({name:"WangEr"})
    coll.find()
    coll.remove({}) // 删除所有
    coll.find()
    ```