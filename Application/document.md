### office
1. 解决方案提供者
   - office官方文档
   - openoffice
   - xdocin
1. 查看
1. 新增
1. 编辑
1. 转换
   - 聚合数据文档转换：https://www.juhe.cn/docs/api/id/259
   - 金山格式转换客户端
   - Aspose：收费
   - Office Web Apps：自行搭建服务
1. 操作
   - JavaCOMBridge：java的jacob包，调用COM对象
   - JCom：类似jacob
   - POI：apache旗下，Java API for Microsoft Documents
   - openoffice：apache旗下，
   - libreoffice：自由免费
### 开放平台
1. 账号体系
   - 用户：级别、账户、余额
     1. 是否第三方登录：自建用户体系，（微信、qq）oauth2.0、OpenID
   - 鉴权：
     1. 将userId和服务id绑定，鉴定具有哪些权限
     1. 过期时间
   - 秘钥管理：accessId、accessKey。用于鉴别是否真正请求人（验证请求的发送者身份），用秘钥和参数生成加密串
     1. Format：json、xml
     1. Version：api版本号
     1. AccessId
     1. Signature：签名结果串
     1. SignatureMethod：签名方式，md5、HMAC-SHA1
     1. SignatureVersion：签名算法版本
     1. Timestamp：请求的时间戳，要标识出来UTC
     1. SignatureNonce：唯一随机数，用于防止网络重放攻击，用户在不同请求间要使用不同的随机数值
1. open api
   - 访问统计：配置能访问的模块
   - 频率控制：独立的流控模块，粒度是每秒/分钟/小时/天，
     1. 单ip
     1. 单应用
     1. 单用户
   - 安全：http/https、注入、网络重放攻击
   - 日志：访问日志
1. 问题
   - 微信为什么要用具有2小时过期的access_token？这个设计思路是：每次验证的时候将（accesskey+accessA+curTimestamp(当前时间戳)+randomNum(随机数)）这个加密，产生一个api_code,发送验证串的时候将api_code和里面的参数带到proxy验证，产生一个access_token和expire_time(token过期时间)。为了校验的时候快速？
1， 方案
   - 设计：产品设计、技术实现
   - accessId、accessKey：一般是把所有的请求参数排序后和apisecretkey做hash生成一个签名sign参数，服务器后台只需要按照规则做一次签名计算，然后和请求的签名做比较，如果相等验证通过，不相等就不通过。此排序严格大小写敏感排序。不包括sign本身
   - 参数：两个部分，公共请求参数，业务参数
   - utf-8编码
   - 返回RequestId：便于追查，和日志放在一起
   - 产品体系
     1. 简介
     1. 定价
     1. 快速入门
     1. 开发指南
     1. 用户指南
     1. 最佳实践：教用户怎么更好使用，比如设计场景，有什么好处
     1. 常见问题
     1. 相关协议
   - 频率控制
	 1. 方案1
        ```
        $listLength = LLEN rate.limiting:$IP

        if ($listLength < 10) {
            LPUSH rate.limiting:$IP now()
        }else{
            $time = LINDEX rate.limiting:$IP, -1
            if (now() - $time < 60){
                print "超过访问限制"
                exit
            }else{
                LPUSH rate.limiting:$IP now()
                LTRIM rate.limiting:$IP, 0, 9
            }
        }
        ```
	 1. 方案2
        ```php
        $key = 'ImageCode_RequestLimit_Uid';  
    	$listLen = lLen($key);  
    	if($listLen < 3){  
       		// 直接将当前时间戳插入List尾部  
        	Lpush($key, now());  
    	} else {  
        	$index0Time = Lindex($key);  
        	if((当前时间 - $index0Time) < 10min){  
            		// 触发10min内请求大于3次，提醒，“请求过多，请稍后再试。”  
            		echo "请求过多，请稍后再试。";  
            		exit;  
        	} else {  
            		// 将当前时间戳插入List尾部  
            		// 取出List头部首元素  
            		Lpush($key, now());  
            		Ltrim($key, 0, 2);  
        	}
    	}
        ```
1. wiki
   - OAuth2.0协议：是为了解决第三方程序可以获取保存在服务器上的用户的信息但用户又能不将自己的账号密码告知第三方程序
