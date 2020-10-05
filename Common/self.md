1. 范儿
   - 追求极致
     1. 提高要求，延迟满足感
     1. 在更大范围里找最优解，不放过问题，思考本质
     1. 持续学习和成长
   - 务实敢为
     1. 直接体验，深入事实
     1. 不自嗨，注重效果，能突破有担当，打破定式
     1. 尝试多种可能，快速迭代
   - 开放谦逊
     1. 乐于助人和求助，合作成大事
     1. 格局大，上个台阶想问题
   - 坦诚清晰
   - 始终创业
     1. 自驱，不设边界，不怕麻烦
     1. 有韧性，直面现实并改变它
     1. 拥抱变化，对不确定性保持乐观
### 如何快速、深入学习新技术
1. 先宏观认识，从头看到尾，知道大概的样子
1. 了解技术的套路是什么，就是整个项目结构都有什么，肯定是有重复性的代码，有规律可循
1. 自己搭建一个最基本的hello world，然后不断往上加功能，自己做自己的主考官，出需求
1. 分清理论型还是实践型的技术，理论型的要拆解目标，逐个击破，实践型的要要对实践有了清晰的基础理论，实践的过程就是揭晓谜底的过程
1. 区分概念的用于和可以，”可以“从需要理解某件事情出发。”用于“是来理解某个东西本身
### 如何解释一件修复事情
1. 事情发生的过程
1. 如何发现的这个过程
1. 事情为什么会发生
1. 对于原因的确认验证和测试
1. 如何修复这个问题
1. 反思和总结
### book
1. 携程架构实践
   - 组成
     1. 移动大前端：pc、h5、hybird、小程序
     1. 用户接入
   - React Native：携程安装包所用技术
     1. 热更新：绕过ios限制
     1. 不同业务不同rn框架，切换使用预加载
     1. 差分包对比，减少差分包大小
     1. 配套系统
        - 性能报表：首屏加载时长、分布
        - 错误报表：js异常、native runtime异常
   - CWX：针对微信小程序的，为业务提供基础微服务的业务体系框架
     1. cli
     1. 运行时框架：封装不同小程序的语法差异为统一入口
     1. 发布自动化：selenium
   - CRN-web：按需打包(tree shaking)、按需加载(热加载)、懒加载、多级缓存、pwa。AST解析、DSL转换
   - node：做数据聚合、部署工具、SSR
   - 用户接入
     1. GLSB、CDN、CND
     1. LB：硬件
     1. SLB：软负载均衡，基于nginx，
     1. API Gateway：收口的统一网关，之前基于zuul，现在是netty，通过将filter编译层class实现动态更新，采用了私有tcp通信
   - 呼叫中心
     1. 
### work gist
1. 门户
   - 新增关联用户的方法
    ```php
    public function addAdminLink() {

        $data = [
            'unique_user_id'    => 46919,
            'linked_user_id'    => 65034,
            'create_time'       => time(),
        ];

        $rs = Model_Mysql::factory()->addOrUpdate('jy_admins_link', $data);

        print_r($rs);die;
    }
    ```
   - 修改用户信息
    ```php
    public function updateAdminInfo() {

        $data = [
            'id'    => 21880,
            'name'  => 'v_yanxipeng',
        ];

        $rs = Model_Mysql::factory()->addOrUpdate('jy_admins', $data);

        print_r($rs);die;
    }
    ```
1. 课件
   - 根据课件id查询课件数据
    ```sql
    SELECT c.id,p.id as pageid,res.resource_id,res.path
    FROM xes_coursewares c,xes_courseware_relation_package r,xes_package_relation_page rp,xes_pages p,xes_page_resource res
    WHERE c.id = r.courseware_id
    AND r.package_id = rp.package_id
    AND rp.page_id = p.id
    AND res.page_id = p.id
    AND c.`id` = 1009482
    ```
   - 统计课件数量
    ```sql
    SELECT count(p.id)
    FROM xes_coursewares c,xes_courseware_relation_package r,xes_package_relation_page rp,xes_pages p
    WHERE c.id = r.courseware_id
    AND r.package_id = rp.package_id
    AND rp.page_id = p.id
    AND c.school_id = 1 AND c.is_freeze = 1 AND c.source_from = 2 AND (c.status = 5 OR c.status=10)
    AND r.status = 1 AND rp.status = 1
    ```
   - 查询课件api
    ```shell
    curl --location --request POST 'http://coursewareapi.xesv5.com/CourseWare/Courseware/getCoursewareInfo' \
    --header 'X-Auth-Appid: 1001060' \
    --header 'X-Auth-TimeStamp: 1593400201' \
    --header 'X-Auth-Sign: c611bca0e5c1f9da905a7f9730dec037' \
    --header 'Content-Type: application/x-www-form-urlencoded' \
    --data-urlencode 'coursewareId=50527' \
    --data-urlencode 'type=1'
    ```
   - 文档地址
     1. 总的：https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=30852539
     1. 文件夹：https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=38822201
     1. 异步定稿：https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=30852968
     1. 课件平台：https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=90909004
     1. 对外
        - https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=60813822
        - https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=58724741
   - 优网海外
     1. 不需要验证码登录
     1. 服务器直连数据库：`mysql -hxuexi-test-01-xesdb.chmwbtopgut6.us-west-2.rds.amazonaws.com -uxes_courseware_rw -pKvPSMGkn5jgbpEa9df0NFENnXSgfiZT6+`
        ```php
        public function checkPwdWithoutVerification()
        {
            $this->setIfRes(empty($this->params['name']))->echoFormatError(10002, '账号不能为空');
            $this->setIfRes(empty($this->params['pwd']))->echoFormatError(10003, '密码不能为空');
            $this->setIfRes(empty($this->params['verification']))->echoFormatError(10004, '验证码不能为空');
            $this->setIfRes(empty($this->params['key']))->echoFormatError(10005, '缺少必要参数');

            // 向教师中心询问登录
            $params = [
                'header' => [
                    'schoolCode'    => '415',
                    'platform'      => 'thinkTeach',
                ],
                'data'  => [
                    'accountName'       => $this->params['name'],
                    'password'          => $this->params['pwd'],
                    'teachingType'      => 0,
                ]
            ];
            $rs = $this->loadComponent('CurlService')->login(100002, $params);
            $this->setIfRes(!isset($rs['code']) || $rs['code'] != 0)->echoFormatError(10704, '账号或密码错误');
            $userInfo = $rs['data'];

            //token
            $userInfo = $this->_writeUserInfo($userInfo);

            echo $this->formatData(100, ['stat' => '1', 'data' => $userInfo]);
        }
        ```
1. 数据库操作
1. 框架
   - slim执行任意sql
    ```php
    $model = $this->loadModel('Mysql\Courseware\Courseware');
    $sql = "UPDATE `xes_courseware_folder` SET `difficulty_id` = '3' WHERE `id` = '3';";
    $rs = $model->db->query($sql);
    print_r($rs);die;
    ```
### work wiki
1. 课件
   - 三个课件对外接口
     1. /CourseWare/Courseware/getClientCoursewareInfo
     1. /CourseWare/Package/getPackageByCourseware
     1. /CourseWare/Courseware/getKaTexPath
1. 监控
   - 教研tw看板：http://app.xesv5.com/zeus_grafana/d/RTeQqLZz/jiao-yan-tw-kan-ban?orgId=1&from=now-5m&to=now&refresh=5s
1. CDN
   - 域名整理：https://wiki.zhiyinlou.com/pages/viewpage.action?pageId=63621439
