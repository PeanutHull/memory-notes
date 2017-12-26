
### 字符串
1. 处理字符串的匿名
    ```
    $nickname = mb_substr($nickname, 0, 1, 'utf-8').'**'.mb_substr($nickname, mb_strlen($nickname, 'utf-8') - 1, 1, 'utf-8');
    ```
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
   - 可变配置可用example开头
   - 短路写法：`fopen($filename) or die('无法打开')`;
   - echo $str1,$str2;
   - 生成唯一id：uniqid()，前几位一样
   - mb_substr比iconv_substr更快，兼容性好
1. 连续elseif
    ```
    if(($c >= 254)) return false;
    elseif($c >= 252) $bits=6;
    elseif($c >= 224) $bits=3;
    elseif($c >= 192) $bits=2;
    else return false;
    ```




1. session和cookie
   - 客户端把session_id存在客户的cookies中，session中其他的数据存在服务端。客户和服务器的通信就是客户拿着id找服务器，服务器根据这个id可以找到一些只针对于当前id的数据
   - session分为客户端session、服务端session。客户端是服务端给的，存在cookies中
   - session的安全还是程序员自己去保证的
   - cookies用于弥补http无状态的特性
   - session的攻击：会话劫持，就是伪装的和good guy一样的SESSIONID
   - Session 和 Cookie 做着相似的事情，只是 Session 是将数据保存在服务端，通过客户端提交来的 session_id 来获取对应的数据；而 Cookie 是将数据保存在客户端，每次发起请求时将数据提交给服务端的。
   - session_id 可以通过 URL 或 cookie 来传递。url不安全，cookie放到http头中
   - php默认session处理器是$files，存在文件里，不好用，因为会对同一个session加锁，其他脚本就访问不到，不在内存里，成熟的session处理器有：redis、memcached、mongoDB
   - session锁的解决方法是：使用完session后，尽快使用session_write_close() 来保存会话数据并释放文件锁
   - 删除机制：概率gc(garbage collection)，浏览器关闭删除，防呆
   - session 的运行依赖 session id，而 session id 是存在 cookie 中的，也就是说，如果浏览器禁用了 cookie ，同时 session 也会失效（但是可以通过其它方式实现，比如在 url 中传递 session_id）
1. php的stream
  - 概念：php用来补充对本地文件系统、E_mail等文件形式的其他数据源的处理能力————流(stream)，经常和socket联合使用
  - 如fopen————fsockopen
 1. socket编程
   - 概念：TCP/IP协议主要用于局域网及以太网的数据通讯，Socket类遵循这组协议，封装了大量的通讯内部方法，用于创建主机端与客户端的数据通讯，使得程序员工作量大大降低。Socket接口是TCP/IP网络的API。Socket接口，Socket编程基本就是listen，accept以及send，write等几个基本的操作。php更定位于脚本语言
   - php的相关函数：stream_socket_server，stream_socket_client
1. Hook
   - 概念：触发机制，在MVC下，增加系统的灵活性。如文章打印时输出版权信息
   - 步骤;
      1. 设置钩子
      1. 触发事件
      1. 执行行为
1. 获得毫秒数
```
list($t1, $t2) = explode(' ', microtime());
return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
```
1. __FILE__表示的当前载入的文件地址，require进来的就是指那个进来的文件
1. php脚本运行：
 - 给脚本传参数
```
// $argv,给脚本传递的参数数组
// $argv[0]为脚本名称，递增为参数
// 用于定时任务传递参数
var_dump($argv);
//  传递给脚本的参数数目
echo $argc;
```
 - 执行shell，并且设置进程名称
```
/* 任务进程检测，同一时刻仅运行一个进程 */
$task_name = $CONFIG['TASK_NAME'];
$cmd = "ps aux | grep -i '".$task_name."' | grep -v grep | wc -l";
if(shell_exec($cmd) > 0){
    echo "【$task_name】进程运行中…\r\n";
    return false;
}
cli_set_process_title($task_name);
```
1. 命名空间：PHP在进行名字空间引用的时候，如果名字空间的第一个字符不是前导斜杠(\)，那么就被自动识别为相对名字空间
1. 预定义常量
 1. 
    - PHP_VERSION
    - PHP_OS
    - PHP_SAPI ———— 用来判断是使用命令行还是浏览器执行的，如果 PHP_SAPI=='cli' 表示是在命令行下执行
 1. 
    - E_ERROR ———— 最近的错误处
    - E_WARNING
    - E_PARSE ———— 剖析语法有潜在问题处
    - E_NOTICE
 1. 
    - PHP_EOL ————   系统换行符，Windows是（\r\n），Linux是（/n），MAC是（\r）
    - DIRECTORY_SEPARATOR ———— 系统目录分隔符，Windows是反斜线（\），Linux是斜线（/）
    - PATH_SEPARATOR ———— 多路径间分隔符，Windows是反斜线（;），Linux是斜线（:）
 1. 
    - PHP_INT_MAX
    - PHP_INT_SIZE
 1. PHP运行环境检测函数php_sapi_name()
1. php读取excel数据
```
// 载入文件，PHPExcel为官方原版
$filename = dirname(__FILE__) . '/appgazelle.xls';
require_once dirname(__FILE__) . '/PHPExcel/IOFactory.php';
// 载入excel
$objReader  = PHPExcel_IOFactory::createReaderForFile($filename);
$objPHPExcel = $objReader->load($filename);
$objPHPExcel->setActiveSheetIndex(0);
// 循环读取数据
for ($i=2; $i < 219; $i++) { 
        $sign = $objPHPExcel->getActiveSheet()->getCell("A$i")->getValue();
        $name = $objPHPExcel->getActiveSheet()->getCell("B$i")->getValue();
        $ename = $objPHPExcel->getActiveSheet()->getCell("C$i")->getValue();
        $code = $objPHPExcel->getActiveSheet()->getCell("D$i")->getValue();
        // 组合标准sql语句，要包含自增字段，否则column数不对
        $num = $i-1;
        $sql = "INSERT INTO `mapi`.`api_country_code` VALUES ('".$num."', '" . $sign . "', '" . $name . "', '" . $ename . "', '" . $code . "', '1');" . "\n";
        // 写入数据
        var_dump($sql);
        file_put_contents('a.sql', $sql, FILE_APPEND);
}
```
1. 获得内存、cpu信息
 - 当前内存：memory_get_usage()、峰值内存：memory_get_peak_usage()
 - CP信息：getrusage()，win不行
1. 系统常量
 - 常量：__LINE__
 - 文件：__FILE__
 - 目录：__DIR__
 - 函数名：__FUNCTION__
 - 类名：__CLASS__
 - 方法名：__METHOD__
 - 命名空间：__NAMESPACE__
#####1. xml学习、php处理xml
- XML：半结构化文件格式，类似html的标记型语言，主要用描述数据和存放数据
DOM:核心DOM、XML DOM、HTML DOM，功能不同
- 节点：xml的每个成分都是节点，有文档节点——元素节点——文本节点——属性节点——注释节点，2015不是元素节点的值，而是文本节点的值，元素节点包含了文本节点
- 节点树：根元素、元素、属性、文本
- 不同浏览器对XML解析：IE的ActiveXObject、FireFox的document.implementation.createDocument
- 使用：通常<?xml version="1.0" encoding="UTF-8"?>标识开始和版本

PHP操作xml：
1. 从xml中获取数组，实战可用
```
$xmlData = file_get_contents("php://input");
if ($xmlData) {
    $postObj = simplexml_load_string($xmlData, 'SimpleXMLElement', LIBXML_NOCDATA);
    if (! is_object($postObj)) {
        return false;
    }
    // $array = json_decode(json_encode($postObj), true); // xml对象转数组
    $array = (array)$postObj; // 不用这么麻烦，直接就变，但是不能处理二维的xml
} else {
    return false;
}
```
1. 把XML文件或XML字符转为对象，只能处理二维xml，也是种是实战方法
```
$xml = simplexml_load_string($string);
$xml = (array)simplexml_load_string($result, 'SimpleXMLElement', LIBXML_NOCDATA);
$xml = xml_load_file('xml.txt');
```
1. 使用DOMDocument读取xml，一般不用，但是挺普遍
```
$doc = new DOMDocument();
//读取xml文件
$doc->load('person.xml'); 
//按标签名查找的第一个元素
$humans = $doc->getElementsByTagName( "humans" )->item(0);
</br>
// 获得节点内容
$value = $doc->getElementsByTagName( "humans" )->item(0)->nodeValue;
// 获得节点名称
$name = $doc->getElementsByTagName( "humans" )->item(0)->nodeName;
// 获得节点类型
$type = $doc->getElementsByTagName( "humans" )->item(0)->nodeType;
</br>
// 获得属性值
$attribute = $doc->getElementsByTagName( "humans" )->item(0)->getAttribute();
// 获得属性值的属性
$attributeType = $doc->getElementsByTagName( "humans" )->item(0)->getAttributeNode();
</br>
//创建标签
$humans = $doc->createElement_x_x( "humans" );
```
1. 数组转xml
方法1：
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
方法2：
```
thinkphp的data_to_xml(),但是生成的xml数据不全
```
方法3：          // 较繁琐，但是功能强大
```
$doc = new DOMDocument('1.0','UTF-8');
// we want a nice output
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
1. XMLWriter系列函数用于写入xml内容，了解即可
1. XMLReader读取xml，主要用于读取标签属性，了解即可
```
$reader = new XMLReader();
$reader->open('person.xml'); //读取xml数据
$reader->read()              //是否读取
```

#####3. ssl校验处理
1. 数据加密
```
// 获得私密
$res = openssl_get_privatekey(self::$ali_private_key);
// 加密，$data要加密数据,$sign加密后写入此变量,$res私密
openssl_sign($data, $sign, $res);
// 释放资源
openssl_free_key($res);
```
1. 验证
```
//转换为openssl格式密钥
$res = openssl_get_publickey($pubKey);
//调用openssl内置方法验签，返回bool值
$result = (bool)openssl_verify($data, $sign, $res);
//释放资源
openssl_free_key($res);
```
1. 解密
```
//转换为openssl密钥，必须是没有经过pkcs8转换的私钥
$res = openssl_get_privatekey($priKey);
//声明明文字符串变量
$result  = '';
//循环按照128位解密
for($i = 0; $i < strlen($content)/128; $i++  ) {
    $data = substr($content, $i * 128, 128);
    //拆分开长度为128的字符串片段通过私钥进行解密，返回$decrypt解析后的明文
    openssl_private_decrypt($data, $decrypt, $res);
    //明文片段拼接
    $result .= $decrypt;
}
//释放资源
openssl_free_key($res);
//返回明文
return $result;
```

#####4. curl获取网页数据
```
function curl_get_contents($url, $timeout=1) {
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL, $url);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch , CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

```
#####5. 字符编码转换
1. 已知编码的转换
```
header("content-Type: text/html; charset=Utf-8");
echo mb_convert_encoding("你是我的好朋友", "UTF-8", "GBK");
```
1. 未知编码转已知
```
header("content-Type: text/html; charset=Utf-8");
echo mb_convert_encoding($str, "UTF-8", "auto"); //未知原编码，通过auto自动检测
```
1. 对整个页面转换
   - 方法一：把前128字符之外的字符集都用NCR表示，这样的编码任意环境都能显示。加如下代码
```
mb_internal_encoding("gb2312");  // 这里的gb2312是网站原来的编码
mb_http_output("HTML-ENTITIES");
ob_start('mb_output_handler');
```
   - 方法二：用iconv转换，不如mb_convert_encoding
```
$contents = file_get_contents($in_filename);
$contents = iconv('GBK', 'UTF-8', $contents);
```

#####6.获取文件大小的5种方法
1. 方法一   filesize   $filesize< 5120    //即小于5K
1. 方法一   header
```
<?php   
get_headers($url,true);   
   
 //返回结果    
 Array   
 (   
    [0] => HTTP/1.1 200 OK   
    [Date] => Sat, 29 May 2004 12:28:14 GMT   
    [Server] => Apache/1.3.27 (Unix)  (Red-Hat/Linux)   
    [Last-Modified] => Wed, 08 Jan 2003 23:11:55 GMT   
    [ETag] => "3f80f-1b6-3e1cb03b"   
    [Accept-Ranges] => bytes   
    <STRONG>[Content-Length] => 438 </STRONG>  
    [Connection] => close   
    [Content-Type] => text/html   
 )   
 ?>   
```
1. 方法二   fopen
```
function getFileSize($url)   
 {   
    $url = parse_url($url);   
    if($fp = @fsockopen($url['host'],emptyempty($url['port'])?80:$url['port'],$error))   
    {   
        fputs($fp,"GET ".(emptyempty($url['path'])?'/':$url['path'])." HTTP/1.1\r\n");   
        fputs($fp,"Host:$url[host]\r\n\r\n");   
        while(!feof($fp))   
        {   
            $tmp = fgets($fp);   
            if(trim($tmp) == '')   
            {   
                break;   
            }   
            elseif(preg_match('/Content-Length:(.*)/si',$tmp,$arr))   
            {   
                return trim($arr[1]);   
            }   
        }   
        return null;   
    }   
    else   
    {   
        return null;   
    }   
 }  
```
1. 方法三   ob_start
```
function remote_filesize($uri,$user='',$pw='')   
 {   
    // start output buffering    
    ob_start();   
    // initialize curl with given uri    
    $ch = curl_init($uri);   
    // make sure we get the header    
    curl_setopt($ch, CURLOPT_HEADER, 1);   
    // make it a http HEAD request    
    curl_setopt($ch, CURLOPT_NOBODY, 1);   
    // if auth is needed, do it here    
    if (!emptyempty($user) && !emptyempty($pw))   
    {   
        $headers = array('Authorization: Basic ' . base64_encode($user.':'.$pw));   
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);   
    }   
    $okay = curl_exec($ch);   
    curl_close($ch);   
    // get the output buffer    
    $head = ob_get_contents();   
    // clean the output buffer and return to previous    
    // buffer settings    
    ob_end_clean();   
   
    echo '<br>head-->'.$head.'<----end <br>';   
   
    // gets you the numeric value from the Content-Length    
    // field in the http header    
    $regex = '/Content-Length:\s([0-9].+?)\s/';   
    $count = preg_match($regex, $head, $matches);   
   
    // if there was a Content-Length field, its value    
    // will now be in $matches[1]    
    if (isset($matches[1]))   
    {   
        $size = $matches[1];   
    }   
    else   
    {   
        $size = 'unknown';   
    }   
    //$last=round($size/(1024*1024),3);    
    //return $last.' MB';    
    return $size;   
 }   
```
1. 方法四   strlen
```
$fCont = file_get_contents("http://www.weiyeying.cn/");   
echo strlen($fCont)/1024;  
```

#####7.php钩子机制
- 解释：全局变量记录一个函数放入数组，需要就用
- 例子
```
<?php
function addHook($name,$fun){
    $GLOBALS['hookList'][$name][] = $fun;
}
function runHook($name){
    $value = func_get_args();
    unset($value[0]);
    foreach ($GLOBALS['hookList'][$name] as $key => $fun) {
        call_user_func_array($fun, $value);
    }
}
测试：
addHook('hookTest',function($text,$text2){
echo "测试多个参数: {$text} , {$text2} <br/> \n";
});
runHook('hookTest','参数1','参数2');
```
   
#####8.php轮询、长连接
1. 实现方式
  - 轮询
  - 长连接 (long polling)
  - websocket (套接字)
  - NodeJS的Socket.IO
1. 技术原理：
  - 一个站点的同一session在使用时session会被锁住，下个页面请求只能等待。解决办法：1不用session。2sesssion使用后立即释放(session_write_closes释放session锁)。3绕圈子使用其他jsonp、ajax放到其他域下
  - 低版本浏览器使用：把数据给iframe，iframe用form提交接收返回数据在iframe，没有ajax方便
  - 长轮询：客户端向服务器发送Ajax请求，服务器接到请求后hold住连接，直到有新消息才返回响应信息并关闭连接，客户端处理完响应信息后再向服务器发送新的请求。
优点：在无消息的情况下不会频繁的请求，耗费资源小。
缺点：服务器hold连接会消耗资源，返回数据顺序无保证，难于管理维护。
实例：WebQQ、Hi网页版、Facebook IM。
  - 长连接：在页面里嵌入一个隐蔵iframe，将这个隐蔵iframe的src属性设为对一个长连接的请求或是采用xhr请求，服务器端就能源源不断地往客户端输入数据。
优点：消息即时到达，不发无用请求；管理起来也相对方便。
缺点：服务器维护一个长连接会增加开销。
实例：Gmail聊天
  - 反向Ajax、轮询（polling）、流（streaming）、Comet和长轮询（long polling）

#####9.后台基础账号系统
1. 综述
 - 组合：
    1. 系统访问权限检测。即：在被访问的控制器/方法外加一层对用户是否有权限的判断
    1. 系统权限管理
    1. 菜单管理
1. 网站登录流程及原理
 - 流程
```
1:用户输入用户名密码,POST数据到服务器
2:服务器判断用户名密码是否正确,若正确,则在客户端创建一个存储SESSION_ID的COOKIE,并且在服务器中创建一个相对应的SESSION_ID的SESSION,SESSION里面的数据可能为用户的数据
3:以后该用户进行操作时,先从客户端取出SESSION_ID,找到服务器相对应的SESSION,取出数据,进行校验后再进行下一步操作..
```
1. SSO——单点登录
 - 特点：用户的一次登录能得到其他所有系统的信任
    1. 共享同一个身份认证系统，也就是说所有站点的身份验证操作在同一个系统下完成
    1. 每个子系统从共同的身份认证系统中取得用户凭证，包含用户的身份、权限信息等
 - 现成方案：
   1. 客户端登陆同时写入session和加密的cookie，当访问其他服务器时检查session，再检查cookie，再为客户端写入session即可。即Cookie存储加密的密码.访问的时候服务器用Cookie里存储的密码验证
```
1.将用户信息['uid'=>123, 'username'=>'testuser', 'end_time'=>'']的数组序列化字符串后，使用可逆加密算法加密该字符串，写到userinfo的cookie中
2.由于可逆加密易被破解，所以加入将userinfo加盐的不可逆加密的infodig的cookie
3.以上两个COOKIE,为增强安全性,防止用户被XSS攻击后拿到,可以设置http-only属性
4.服务端拿到这两个cookie，先看infodig和加密后的userinfo是否一致，再看是否有uid，判断是否到了过期时间，最后写入session即可
```
   1. 共享SESSION（db,nosql等)，通过接口对每个域名下写cookie（常见ucenter)。
   1. 先跳到统一登录页，之后跳转回去，走到哪都带上ticket，子域名拿ticket去ucenter校验，成功就直接跳过登录，其中ticket要检验过期时间
 - ticket的加密和解密鉴定是用thinkphp的方法进行
1. RBAC——基于角色的访问控制
1. AUTH——基于节点的权限管理
 - 用户通过角色与权限进行关联。即：用户-角色-权限-资源”的授权模型。依次之间为多对多关系，角色即权限的载体。
 - 相关表结构
    1. wc_ucenter_member：用户表
    1. wc_auth_group：组数据表
    1. wc_auth_group_access：用户、组关系表
    1. wc_auth_rule：权限表————模块+控制器+方法名、名称
 - 权限表中的权限全部从菜单表中拉取，菜单即权限
 - UcenterMember记录用户用户名、手机、密码等基本信息，UserApi利用其做中间接口和前台交互数据，Member记录用户详细信息：地址、昵称
 - 动态设置admin的uid、allow_ip设置是否是管理员标志，admin在权限鉴定中全部通过
 - 权限控制系统有一个统一开关控制是否检测权限
 - 过程
```
全局检测是否登陆—————————————————————————去登陆Account
        |                                        |
        |                                        |
管理员？验id、ip                    UserApi/UcMember验密码/Member生成session
        |                                        |
        |                                        |
是否有权限                            生成通行证ticket
        |
        |
访问权限————权限系统控制的基本方法的禁止、允许访问
        |
        |
节点权限————thinkphp的检测设置
        |
        |
生成菜单
```
1. 其他经验
 - 所有登陆操作都已接口API形式引入使用，密码加密要加盐md5
 - 一般cookie中只存放uid、username，不能存放用户敏感的数据

#####10.AOP——面向切面编程
 - 概念：剖开封装的对象内部，并将影响多个类的公共行为封装到一个模块。是OOP的补充完善，OOP适合从上到下，AOP适合定义从左到右的关系。

#####12.SPL——PHP标准库 Standard PHP Library
1. 理解：用于解决典型问题的一组接口和类的集合
1. 组成
 - 数据结构————对应数据的存储结构
    1. 双向链表：SplQueue
    1. 堆：SplStack
    1. 阵列：SplFixedArray
    1. 映射：SplObjectStorage
 - 迭代器————以不同的方式来遍历操作的对象，提供了需要的对应数据类型的迭代器
   1. 举例：虽然更多的代码，但是高度重用且可测试，都可以尝试下spl的迭代器，或许能改变你编写传统代码的习惯
```
class RecursiveFileFilterIterator extends FilterIterator {
        // 满足条件的扩展名
        protected $ext = array('jpg','gif');

        /**
        * 提供 $path 并生成对应的目录迭代器
        */
        public function __construct($path) {
                parent::__construct(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path)));
        }

        /**
        * 检查文件扩展名是否满足条件
        */
        public function accept() {
                $item = $this->getInnerIterator();
                if ($item->isFile() && 
                        in_array(pathinfo($item->getFilename(), PATHINFO_EXTENSION), $this->ext)) {
                return TRUE;
                }
        }
}

// 实例化
foreach (new RecursiveFileFilterIterator('/path/to/something') as $item) {
        echo $item . PHP_EOL;
}
```
 - SPL函数
    1. 自动载入函数————适应php的管理要求
```
类载入的基本流程：当前文件找类————spl_autoload_register————__autoload函数找类————异常
使用SPL分离 __autoload 的载入逻辑，可以使逻辑更加清晰。然后用spl函数重载它即可
```
```
// 使用spl载入文件
// 设置自动载入文件的后缀，多个逗号隔开，有前后顺序
spl_autoload_extensions('.class.php', '.php');
// 设置自动载入文件的目录，多个目录用PATH_SEPARATOR分割
set_include_path(get_include_path() . PATH_SEPARATOR);
// 注册
spl_autoload_register()    ;
new Test();

// 使用__autoload载入文件
// 找不到类就自动执行
function __autoload($className) {
            require_once('libs' . $className . '.php');
}
new Test();

// 自定义函数装载类
function classLoader($className) {
            require_once('libs' . $className . '.php');
}
spl_autoload_register('classLoader');
new Test();

// 重新使用spl载入文件
function classLoader($className) {
            set_include_path('libs');
            // 不使用require和include时，要使用spl的自动载入
            spl_autoload($className);
}
spl_autoload_register('classLoader');
new Test();
```
 - 文件处理
 - 接口
 - 异常
 - 其他类和接口

#####13. LDAP——轻量级目录访问协议 Lightweight Directory Access Protocol
1. 理解：简单的目录协议，即用于访问"目录服务器"(Directory Servers)的协议，发布目录信息到许多不同资源的协议。是一种数据库，通常作为hierarchal数据库使用。类似电话薄，允许任何程序获得目录和其他信息
1. 目录：指一种按照树状结构存储信息的数据库
1. 使用；PHP有专门的函数操作

#####14.php执行定时脚本
```
$ldap_host = "ldap://192.168.3.1";  //LDAP 服务器地址
$ldap_port = "389";  //LDAP 服务器端口号
// or die 来美化错误信息
$ldap_conn = ldap_connect($ldap_host, $ldap_port) or die("Can't connect to LDAP server");
```
1. php重复执行脚本
```
    // 设定脚本title
    cli_set_process_title('ocstaskworker');

    // 检查是否有相同的脚本正在运行
    $cmd = "ps aux | grep -i 'ocstaskworker' | grep -v grep | wc -l";
    $rt = shell_exec($cmd);

    return trim($rt) > 1 ? true : false;
```