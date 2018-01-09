
### 字符串
1. 处理字符串匿名
    ```
    $nickname = mb_substr($nickname, 0, 1, 'utf-8').'**'.mb_substr($nickname, mb_strlen($nickname, 'utf-8') - 1, 1, 'utf-8');
    ```
1. 编码转换
   - mb_convert_encoding($str, "UTF-8", "GBK/auto"); 支持未知原编码转换，通过auto自动检测
   - iconv('GBK', 'UTF-8', $str);
### 数组
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
1. XML：半结构化的文件格式，类似html的标记型语言，主要用于描述/存放数据
   - 节点：xml的每个成分都是节点，有文档节点——元素节点——文本节点——属性节点——注释节点，2015不是元素节点的值，而是文本节点的值，元素节点包含了文本节点
   - 节点树：根元素、元素、属性、文本
   - 不同浏览器对XML解析：IE的ActiveXObject、FireFox的document.implementation.createDocument
   - 通常用<?xml version="1.0" encoding="UTF-8"?>标识开始和版本
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
### 其他
1. 获得毫秒数
    ```
    list($t1, $t2) = explode(' ', microtime());
    return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
    ```
1. LDAP：轻量级目录访问协议，Lightweight Directory Access Protocol，用于访问"目录服务器"的协议，发布目录信息到许多不同资源，是一种数据库，通常作为hierarchal数据库使用。类似电话薄，允许任何程序获得目录和其他信息。目录：指一种按照树状结构存储信息的数据库
1. php阻止重复执行脚本
    ```
    cli_set_process_title('worker');                                // 设定脚本title
    $cmd = "ps aux | grep -i 'worker' | grep -v grep | wc -l";      // 检查是否有相同的脚本正在运行
    $rt = shell_exec($cmd);
    return trim($rt) > 1 ? true : false;
    ```
