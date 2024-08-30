### 字符串
1. 处理字符串匿名
    ```
    $nickname = mb_substr($nickname, 0, 1, 'utf-8').'**'.mb_substr($nickname, mb_strlen($nickname, 'utf-8') - 1, 1, 'utf-8');
    ```
1. 编码转换
   - mb_convert_encoding($str, "UTF-8", "GBK/auto"); 支持未知原编码转换，通过auto自动检测
   - iconv('GBK', 'UTF-8', $str);
1. 一个 NULL 字节（"\0"）并不等同于 PHP 的 NULL 常数
### 数组
1. 跳出多层循环
```php
for ($i = 0; $i < 3; $i++){
    echo '外层循环'.$i.' 开始<br/>';
    for ($j = 0; $j < 2; $j++){
        if ($i == 1){
            break 2;    //使用break 2直接跳出2层循环
        }
        echo '内层循环'.$i.'-'.$j.'<br/>';
    }
    echo '外层循环'.$i.' 结束<br/><br/>';
}
```
1. 遍历数组执行函数
    ```
    方法1     array_walk回调处理
    $gbk = [];
    array_walk(
        $arr, 
        function($v, $k) use (&$gbk){ 
            $key = mb_convert_encoding($k, 'GBK', 'UTF-8');
            $gbk[$key] = $v;
        }
    );
    方法2     while循环处理
    while(list($k, $v) = each($arr)) {
        $k = mb_convert_encoding($k, 'gbk', 'UTF-8' );
        $arr[$k] = $v;
    }
    ```
1. 循环处理队列数据
    ```
    // 1.当队列里无数据时，程序自动结束，关键词：false、while
    while (false !== $order_id = $redis->rpoplpush()) {
        $redis->lpop();
    }
    ```
1. 不能捕捉错误的递归
    ```
    function zookeeperTry($n = 0) {
    if ($n >= 60) return "";                                  // 最多递归60次
        $zookeeper = new Zookeeper($address, null, 300);
        try{
            $zookeeper->get($testPath);                       // 测试path是否通
            return $zookeeper;
        }catch (ErrorException $e) {
            return zookeeperTry(++$n);
        }
    }
    ```
### 文件
1. 获取文件大小
   - filesize
   - get_headers
   - strlen
### 网络
1. 获取当前页面完整url
```
function get_self_url($is_root=0) {
    $protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
    $php_self = $_SERVER['PHP_SELF'] ? $_SERVER['PHP_SELF'] : $_SERVER['SCRIPT_NAME'];
    $path_info = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '';
    $relate_url = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$_SERVER['QUERY_STRING'] : $path_info);
    return $protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').(!$is_root ? $relate_url : '');
}
```
1.获得服务器ip和客户端ip
   - 服务端ip
     1. 环境变量：getenv('SERVER_ADDR')
     1. $_SERVER['SERVER_ADDR']
   - 客户端ip
     1. 环境变量：getenv('REMOTE_ADDR')   
     1. $_SERVER的参数
        - REMOTE_ADDR：客户端ip/代理ip
        - HTTP_CLIENT_IP：代理ip，可能存在
        - HTTP_X_FORWARDED_FOR：用户ip使用的代理，可能存在，可以伪造
### 语法
1. 代码技巧
   - 使用数组和array_keys_exists代替switch可以少写很多代码
   - 短路写法：`fopen($filename) or die('无法打开')`;
   - echo $str1,$str2;
   - 生成唯一id：uniqid()，前几位一样
   - mb_substr比iconv_substr更快，兼容性好
   - 配置使用example开头
1. if判断单行写法
    ```
    if(($c >= 254)) return false;
    elseif($c >= 252) $bits=6;
    elseif($c >= 224) $bits=3;
    elseif($c >= 192) $bits=2;
    else return false;
    ```
### xml处理
1. XML：eXtensible Markup Language，可扩展标记语言，半结构化的文件格式，用于描述/存放数据，具有自我描述性，对大小写敏感，都是对标签且必须正确嵌套
   - 节点树：根元素、元素、属性、文本。xml的每个成分都是节点
   - 命名空间：用于避免元素命名冲突，由元素开始标签的xmlns属性定义，值为url不会用于查找，只是用于确定唯一名称，`<td xmlns="http://">`
   - CDATA：由`<![CDATA["`开始，由`"]]>"`结束的部分被解释器忽略
   - 举例
    ```XML
    <?xml version="1.0" encoding="UTF-8"?>          // XML声明可选，都在第一行
    <note>
        <heading>Reminder</heading>        
    </note>
    ```
   - 良好的xml文档规范
     1. 它必须以 XML 声明开头
     1. 它必须拥有唯一的根元素
     1. 开始标签必须与结束标签相匹配
     1. 元素对大小写敏感
     1. 所有的元素都必须关闭
     1. 所有的元素都必须正确地嵌套
     1. 必须对特殊字符使用实体
1. DTD：Document Type Definition，文档类型定义，是关于标记符的语法规则，是XML文件的验证机制。 是一种保证xml文档格式正确的方法，通过比较xml文档和DTD文件来看文档是否符合规范，元素和标签使用是否正确，DTD文件是一个ASCII的文本文件，后缀名为.dtd。HTML4.01中的doctype需要对DTD进行引用，因为HTML4.01基于SGML。而HTML 5不基于SGML，因此不需要对DTD进行引用
    ```XML
    <!DOCTYPE NEWSPAPER [
    <!ELEMENT NEWSPAPER (ARTICLE+)>
    <!ATTLIST ARTICLE EDITION CDATA #IMPLIED>
    ]>
    ```
1. Schema：是基于xml的DTD替代者，可描述xml的结构，使用xml语法，用于描述允许的文档内容/验证数据的正确性/定义数据约束、模型等
    ```XML
    // 一个xml文档
    <?xml version="1.0"?>
    // Schema声明
    <note                                                       // 表示对Schema的引用，Schema文件定义了xml的内容和规范，以xsd为扩展名
    xmlns="http://www.w3schools.com"                            // 默认命名空间
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"       // xsi标准命名空间，用于指定自定义命名空间的schema文件
    xmlns:self="http://"                                        // 自定义命名空间
    xsi:schemaLocation="http://www.w3schools.com/note.xsd">
    <heading>Reminder</heading>
    </note>
    // 示例Schema文件内容
    <?xml version="1.0"?>
    <xs:schema>
    ...
    </xs:schema>
    ```
1. php读取xml数据
   - `simplexml_load_file();`
   - `simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);`
   - DOMDocument
        ```
        $doc = new DOMDocument();
        $doc->load('person.xml'); 
        $humans = $doc->getElementsByTagName("humans")->item(0);                                 // 按标签名查找第一个元素
        $value = $doc->getElementsByTagName("humans")->item(0)->nodeValue/nodeName/nodeType;     // 获得节点内容、名称、类型
        $attribute = $doc->getElementsByTagName("humans")->item(0)->getAttribute();              // 获得属性值
        ```
   - XMLReader
        ```
        $reader = new XMLReader();
        $reader->open('person.xml');
        $reader->read();
        ```
1. 转换
   - xml转数组：`$array = json_decode(json_encode($xmlData), true);`
   - 数组转xml
     1. 方法1
        ```
        $xml = simplexml_load_string('<request />');
        foreach($data as $k=>$v) {
        if(is_array($v)) {
            $x = $xml->addChild($k);
            create($v, $x);
        }else $xml->addChild($k, $v);
        }
        $data = $xml->saveXML();
        ```
     1. 方法2
        ```
        $doc = new DOMDocument('1.0','UTF-8');
        $doc->formatOutput = true;
        $root = $doc->createElement('request');
        $root = $doc->appendChild($root);
        foreach($ar as $title=>$title_v){
            $title = $doc->createElement($title);
            $title = $root->appendChild($title); 
            if(is_array($title_v)){
                foreach($title_v as $k=>$v){
                    $k = $doc->createElement($k);
                    $k = $title->appendChild($k);
                    $text = $doc->createTextNode($v);
                    $text = $k->appendChild($text);
                }
            }else{
                $text = $doc->createTextNode($title_v);
                $text = $title->appendChild($text);
            }
        }
        echo $doc->saveXML();
        ```
     1. XMLWriter
### ssl处理
1. 数据加密
    ```
    $res = openssl_get_privatekey(self::$ali_private_key);      // 获得私密
    openssl_sign($data, $sign, $res);                           // 加密，$data要加密数据,$sign加密后写入此变量,$res私密
    openssl_free_key($res);                                     // 释放资源
    ```
1. 验证
    ```
    $res = openssl_get_publickey($pubKey);                      // 获得公密
    $result = (bool)openssl_verify($data, $sign, $res);         // 验证
    openssl_free_key($res);                                     // 释放资源
    ```
1. 解密
    ```
    $res = openssl_get_privatekey($priKey);                     // 获得私密
    for($i = 0; $i < strlen($content)/128; $i++  ) {            // 循环按照128位解密
        $data = substr($content, $i * 128, 128);                // 拆分开长度为128的字符串片段
        openssl_private_decrypt($data, $decrypt, $res);         // 解密
        $result .= $decrypt;                                    // 明文片段拼接
    }
    openssl_free_key($res);                                     // 释放资源
    return $result;                                             // 返回明文
    ```
### 加解密
```
/**
* 字符串加密解密
* @param  string $string 需要加密或解密的字符串
* @param  string $key 加密密钥
* @param  string $operation 加密还是解密,默认解密
* @return string             加密或者解密结果
*/
function authCode($string, $key = '', $operation = 'DECODE')
{
    if (empty($string)) {
        return $string;
    }
    // 密匙
    $key = md5($key ? $key : 'admin.xuersi.com');
    $keyLength = strlen($key);
    // 前八位用于验证数据完整性
    $string = $operation == 'DECODE' ? base64_decode($string) : substr(md5($string . $key), 0, 8) . $string;
    $stringLength = strlen($string);
    $rndkey = $box = array();
    $result = '';
    // 产生密匙簿
    for ($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($key[$i % $keyLength]);
        $box[$i] = $i;
    }
    // 用固定的算法，打乱密匙簿，增加随机性，虽复杂但实际上不会增加密文的强度
    for ($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for ($a = $j = $i = 0; $i < $stringLength; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    //解密
    if ($operation == 'DECODE') {
        if (substr($result, 0, 8) == substr(md5(substr($result, 8) . $key), 0, 8)) {
            return substr($result, 8);
        }
        return '';
    }
    // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
    return str_replace('=', '', base64_encode($result));
}
```
### 脚本
1. php阻止重复执行脚本
    ```
    cli_set_process_title('worker');                                // 设定脚本title
    $cmd = "ps aux | grep -i 'worker' | grep -v grep | wc -l";      // 检查是否有相同的脚本正在运行
    $rt = shell_exec($cmd);
    return trim($rt) > 1 ? true : false;
    ```
1. 主动重启、信号处理
   - 意义
     1. 常驻进程防止内存泄露
     1. 程序优雅退出，防止数据处理一半造成错误
   - 实现
     1. $this->loop总体控制while循环是否退出
     1. 时间减法确定是否重启
     1. pcntl信号处理
   - 代码
    ```php
    $job = new Job();
    $job->handle();
    class Job
    {
        const MAX_RUN_TIME = 3600;  //最长运行1小时
        private $redis;
        private $loop = true;
        private $startTime;
        public function __()
        {
            //信号安装
            $this->installSignal();
            $this->redis = new \Redis();
            $this->redis->connect('127.0.0.1', 6379);
        }

        //处理函数
        public function handle()
        {
            $this->startTime = time();
            while($this->loop) {
                //检查运行时间
                $this->checkRunTime();
                //信号分发
                pcntl_signal_dispatch();
                $data = $this->redis->lPop('QUEUE:JOB');
                if(!$data) {
                    sleep(5);       //spare sleep
                    continue;
                }
                //do data
                //比如：将数据存储到文件中……
                file_put_contents('/data/data.txt', $data, FILE_APPEND);
            }
        }
        
        //检查运行时间
        private function checkRunTime()
        {
            if (time() - $this->startTime > self::MAX_RUN_TIME) {
                $this->loop = false;
            }
        }
        //信号安装
        function installSignal()
        {
            //绑定QUIT信号
            pcntl_signal(SIGQUIT, array($this, 'sigalHndler'));
            pcntl_signal(SIGTERM, array($this, 'sigalHndler'));
            pcntl_signal(SIGHUP, array($this, 'sigalHndler'));
            pcntl_signal(SIGINT, array($this, 'sigalHndler'));
        }
        //信号处理函数
        private function sigalHndler($signo)
        {
            switch ($signo) {
                case SIGTERM:
                case SIGHUP:
                case SIGINT:
                case SIGQUIT:
                    $this->loop = false;
                    break;
                default:
                    // 处理所有其他信号
            }
        }
    }
    ```
### 其他
1. 获得毫秒数
    ```
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    ```
1. php监听队列消息
    ```php
    $connection = new AMQPConnection([]);
    $channel = new AMQPChannel($connection);
    $queue = new AMQPQueue($channel);
    $queue->setName($queueName);
    // 消费队列消息
    while(TRUE) {
        $queue->consume('processMessage');
    }
    // 断开连接
    $connection->disconnect();

    function processMessage($envelope, $queue) {
        $msg = $envelope->getBody();
        $queue->ack($envelope->getDeliveryTag());           // 手动发送ACK应答
    }
    ```
1. redis
   - php扩展：PRedis、phpredis(c扩展)
   - windows下安装php的redis扩展
    ```
    // 下载：php_redis.dll、php_igbinary.dll————注意ts/nts
    // 添加配置文件
    extension=php_igbinary.dll
    extension=php_redis.dll
    ```
1. php集合
   - 互斥锁实现集合：https://github.com/php-lock/lock
1. redlock
    ```php
    <?php

    namespace XesLib\RedLock;

    class PHPRedLock
    {
        private $retryDelay;
        private $retryCount;
        private $clockDriftFactor = 0.01;
        private $quorum;

        private $servers = array();
        private $instances = array();

        protected $_succIns = [];
        //记录抢锁成功的实例的索引 
        //抢锁失败的实例，在释放锁时，不需要去释放

        function __construct(array $instances, $retryDelay = 200, $retryCount = 1)
        {
            $this->instances = $instances;

            $this->retryDelay = $retryDelay;
            $this->retryCount = $retryCount;

            $this->quorum  = min(count($instances), (count($instances) / 2 + 1));

            $this->_succIns = [];
        }

        public function lock($resource, $ttl)
        {
            $this->initInstances();

            $token = uniqid();
            $retry = $this->retryCount;
            $this->_succIns = [];

            do {
                $n = 0;

                $startTime = microtime(true) * 1000;

                foreach ($this->instances as $index => $instance) {
                    if ($this->lockInstance($instance, $resource, $token, $ttl)) {
                        $this->_succIns[] = $index;
                        $n++;
                    }
                }

                # Add 2 milliseconds to the drift to account for Redis expires
                # precision, which is 1 millisecond, plus 1 millisecond min drift
                # for small TTLs.
                $drift = ($ttl * $this->clockDriftFactor) + 2;

                $validityTime = $ttl - (microtime(true) * 1000 - $startTime) - $drift;

                if ($n >= $this->quorum && $validityTime > 0) {
                    return [
                        'validity' => $validityTime,
                        'resource' => $resource,
                        'token'    => $token,
                    ];

                } else {
                    foreach ($this->instances as $index => $instance) {
                        if(!in_array($index, $this->_succIns)){
                            continue;
                        }
                        $this->unlockInstance($instance, $resource, $token);
                    }
                }

                // Wait a random delay before to retry
                $delay = mt_rand(floor($this->retryDelay / 2), $this->retryDelay);
                usleep($delay * 1000);

                $retry--;

            } while ($retry > 0);

            return false;
        }

        public function unlock(array $lock)
        {
            $this->initInstances();
            $resource = $lock['resource'];
            $token    = $lock['token'];

            foreach ($this->instances as $index => $instance) {
                $this->unlockInstance($instance, $resource, $token);
            }
        }

        private function initInstances()
        {
            if (empty($this->instances)) {
                foreach ($this->servers as $server) {
                    list($host, $port, $timeout) = $server;
                    $redis = new \Redis();
                    $redis->connect($host, $port, $timeout);

                    $this->instances[] = $redis;
                }
            }
        }

        private function lockInstance($instance, $resource, $token, $ttl)
        {
            $result = $instance->set($resource, $token, ['NX', 'PX' => $ttl]);

            if(is_array($result)){
                return $result['result'];
            }
            return $result;
        }

        private function unlockInstance($instance, $resource, $token)
        {
            $script = '
                if redis.call("GET", KEYS[1]) == ARGV[1] then
                    return redis.call("DEL", KEYS[1])
                else
                    return 0
                end
            ';
            return $instance->eval($script, [$resource, $token], 1);
        }
    }
    ```