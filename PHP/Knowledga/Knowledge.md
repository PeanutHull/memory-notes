### 语法操作
1. 数据类型详解：php根据上下文在运行时决定变量的类型
   - bool：被认为false的：0.0、"0"、[]
   - integer
     1. 八进制加0/十六进制加0x/二进制0b
     1. 整数溢出为float
   - float
     1. 字长和平台相关，通常是1.8e308，具有14位十进制数字的精度，754双精度格式
     1. 永远不要相信浮点数结果精确到了最后一位，也永远不要比较两个浮点数是否相等
     1. double==float，由于历史原因两者都存在
     1. is_nan判断是否为合法数值，is_finite()是否为有限值，is_infinite()是否为无限值
     ————————————以下没有好好的过手册——————————————
   - string
     1. 理解：由字符组成，每个字符等于一个字节，所以只支持256字符集，不支持Unicode。最大为2G，v7.0支持大于2G
     1. 4种表达方式：单引号/双引号/heredoc/nowdoc
        - 单引号：不能解析变量和转义字符
        - 双引号：可以解析变量和任意转义字符，变量可以用特殊字符&等和{}包含，如"abcd'{$a}'ef"，为提高效率'abcd\''.$a'\'ef'
        - Nowdoc类似单引号
        - Heredoc类似双引号，用于长字符串大文本，<<<定界符后边跟自定义字符串以作为结束符，可以解析变量，不转义'
1. 数据类型操作
   - 类型获取：var_dump()，包括方法/类
   - 类型检测：is_int、is_string、不要用gettype()
   - 强制转换：紧贴变量，或中间隔空格
     1. (bool)/(boolean)
     1. (int)/(integer)
     1. (float)/(double)/(real)
     1. (string)/""
     1. (array)
     1. (object)
     1. (unset) // 转化为NULL
     1. (binary)/b // 转为二进制字符串 V5.2
     1. settype()
1. 代码执行顺序：自上而下，从左至右，从里到外
    ```php
    function myfunc($a){
        echo $a + 10;
    }
    $val = 10;
    echo "myfunc($val)=".myfunc($val);          //输出结果为20myfunc(10)
    ```
1. 闭包
   - 理解：即匿名函数、闭包函数，最常用回调函数的参数，v5.3之后使用use传递外面的值(传引用)，将修改值生效。闭包类 Closure，闭包都是Closure类的实例
   - 示例
    ```php
    $func = function($str) {         // 将函数赋值给变量
        echo $str;
    };
    $func('some string');
    function callFunc( $func ) {     // 把匿名函数当做参数传递，并且调用它
        $func( 'some string' );
    }
    ```
1. 使用`parent::__construct()`继承父级的初始化
1. 静态方法：`public static function eat(){}`
1. 简单的静态构造器：PHP没有静态构造器，你可能需要初始化静态类去给静态变量赋值
    ```php
    function Demonstration(){
        return 'This is the result of demonstration()';
    }
    class MyStaticClass {
        //public static $MyStaticVar = Demonstration(); //!!! FAILS: syntax error
        public static $MyStaticVar = null;

        public static function MyStaticInit(){
            //this is the static constructor
            //because in a function, everything is allowed, including initializing using other functions
            self::$MyStaticVar = Demonstration();
        }
    }
    //Call the static constructor
    MyStaticClass::MyStaticInit(); 
    echo MyStaticClass::$MyStaticVar;
    ```
1. 抽象类
    ```php
    abstract class AbstractClass {
        abstract protected function getValue();                             // 抽象方法
        public function printOut() {print $this->getValue() . PHP_EOL;}     // // 普通方法
    }
    class ConcreteClass1 extends AbstractClass {
        protected function getValue() {}
    }
    ```
1. 接口
    ```php
    interface demo {                         // 定义
        function method();
    }
    class example implements demo{}          // 实现
    ```
1. cookie：`setcookie(name,value,time() + 3600,'/');`
1. +和array_merge的前后覆盖顺序不同
1. json中的字段对比是否存在可用键的差值，减少两层循环
1. 用printf代替复杂的字符串拼接
1. create_time和modify_time用sql的自动更新，代码不用维护
1. 统一日志记录
### 应用
1. strtotime
    ```php
    strtotime("10:38pm April 15 2015");
    strtotime("tomorrow");
    strtotime("next Saturday");
    strtotime("+3 Months");
    strtotime("+1 weeks",strtotime("Saturday"));    // 下周六的日期
    $d1=strtotime("December 31");                   // 12月30日之前的天数
    $d2=ceil(($d1-time())/60/60/24);
    echo "距离十二月三十一日还有：" . $d2 ." 天。";
    ```
1. fopen
    ```php
    $fp = fopen("/tmp/lock.txt", "w+");
    if (flock($fp, LOCK_EX)) {                      // 排它型锁定
        fwrite($fp, "Write something here\n");
        flock($fp, LOCK_UN);                        // 释放锁定
    } else {
        echo "Couldn't lock the file !";
    }
    fclose($fp);
    ```
1. php页面跳转方法
   - header
    ```php
    header("HTTP/1.1 303 See Other");
    header('Location:xxx');exit;
    exit;                                // 不然会继续执行
    ```
   - javascript：`window.location.href`、`window.open`
   - echo标签跳转：META(HTTP-EQUIV)、script(window.location.href、window.open)
1. 图像输出到浏览器或者文件
    ```php
    header('Content-type: image/png');
    imagepng($im);
    imagedestroy($im);
    ```
1. curl：curl_getinfo可获取Content-Length参数
    ```php
    $ch = curl_init();
    curl_setopt($ch , CURLOPT_URL, $url);
    curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch , CURLOPT_TIMEOUT, $timeout);
    $result = curl_exec($ch);
    curl_close($ch);
    ```
1. 数学
   - mt_rand产生随机数的速度是旧的rand函数的4倍
     1. mt_getrandmax 显示随机数的最大可能值
     1. mt_srand 播下更好的随机数种子
   - 获得指定范围随机浮点数：`return $min + mt_rand() / mt_getrandmax() * ($max - $min);`
1. 脚本：以web服务器的权限来执行
   - fastcgi_finish_request
   - ignore_user_abort
   - register_shutdown_function
   - set_time_limit
   - cli_set_process_title：设定脚本名
   - shell_exec、system，exec，passthru，pcntl_exec：执行脚本
   - memory_get_usage：当前内存
   - memory_get_peak_usage 峰值内存
   - getrusage：CPU信息，win不行
1. 输出缓存区：所有输出的内容放入缓存区
    ```php
    // 实现动态内容静态化
    <?php
    $cache_name = md5(__FILE__).'.html';
    $cache_lifetime = 3600;
    if(filectime(__FILE__) <= filectime($cache_name) && file_exists($cache_name) && filectime($cache_name) + $cache_lifetime > time()) {
        include $cache_name;
        exit;
    }
    ob_start();
    ?>

    <p>This is page</p>

    <?php
    $content = ob_get_contents();
    ob_end_flush();
    file_put_content($cache_name, $content);
    ?>
    ```
1. 上传文件夹下所有文件和文件夹
    ```php
    public function uploadAllFile($dir, $p, $uploadDir, $result = [], $content = '')
    {
        $handle = opendir($dir);
        if ($handle) {
            while (($file = readdir($handle)) !== false) {
                if ($file != '.' && $file != '..') {
                    $cur_path = $dir . DIRECTORY_SEPARATOR . $file;
                    if (is_dir($cur_path)) {
                        $result = $this->uploadAllFile($cur_path, $p, $uploadDir, $result, $content);
                        $result = $result['data'];
                    } else {
                        $res = str_replace($p, $uploadDir, $cur_path);
                        $res = str_replace('\\', '/', $res);
                        $r = $this->uploadCloudServer($cur_path, $res, 1, '');
                        if (empty($r['stat'])) {
                            file_put_contents(
                                '/tmp/fieldUpload.log',
                                date('Y-m-d H:i:s') . $file . '上传失败' . $r['data'] . chr(10),
                                8
                            );
                            $this->sendDindDindMsg($content . ", 资源{$cur_path}上传到{$res}失败，请查看");
                            return $r;
                        }
                        array_push($result, $r['data']);
                    }
                }
            }
            closedir($handle);
        }

        return ['stat' => 1, 'data' => $result];
    }
    ```
#### pro
1. spl_autoload_register
    ```php
    // 遵守PSR-4规范的自动载入简单实现
    class Loader {                                                                  // 加载类
        public static $vendorMap = array(                                           // 路径映射
            'app' => __DIR__ . DIRECTORY_SEPARATOR . 'app',
        );
        public static function autoload($class) {                                   // 自动加载器
            $file = self::findFile($class);
            if (file_exists($file)) {
                self::includeFile($file);
            }
        }
        private static function findFile($class) {                                  // 解析文件路径
            $vendor = substr($class, 0, strpos($class, '\\'));                      // 顶级命名空间
            $vendorDir = self::$vendorMap[$vendor];                                 // 文件基目录
            $filePath = substr($class, strlen($vendor)) . '.php';                   // 文件相对路径
            return strtr($vendorDir . $filePath, '\\', DIRECTORY_SEPARATOR);        // 文件标准路径
        }
        private static function includeFile($file) {                                // 引入文件
            if (is_file($file)) {
                include $file;
            }
        }
    }
    // 使用
    include 'Loader.php';                                       // 引入加载器
    spl_autoload_register('Loader::autoload');                  // 注册自动加载

    new \app\mvc\view\home\Index();                             // 实例化未引用的类
    ```
### 函数大全
1. 字符串类
   - explode/str_split/preg_split/chunk_split           分割
   - trim/str_replace/preg_replace/preg_filter          替换
   - substr/strstr/preg_match/preg_match_all            截取
   - strlen/substr_count                                统计
   - strpos/stripos/strrpos/strripos                    位置
   - strrev/str_repeat/str_shuffle/rand                 其他操作
   - printf/vprintf/vsprintf                            格式化
1. 数组类
   - implode
   - count/in_array
   - sort/ksort/asort/array_multisort/usort/shuffle                                 k是键，默认和a是值，r倒序，u自定义
   - array_keys/array_values/array_slice/array_chunk/preg_grep/array_column         数据获取
   - array_pop/array_push/array_shift/array_unshift                                 元素处理
   - each/reset/current/next                                                        指针处理
   - array_unique/array_sum/array_reverse                                           加工处理
   - array_diff/array_merge                                                         多数组处理
   - list                                                                           把数组值给一组变量赋值，是语言结构
   - array_change_key_case                                                          修改健名大小写
1. 判断类
   - empty/isset                                        empty不存在或值等于false，isset变量存在且不是null，都不报错
   - defined/constant/get_defined_constants             常量
   - is_dir/is_link/is_file/file_exist/is_readable
   - get_class/call_user_func                           反射族
1. 编码类
   - chr/ord                                                ascii转换
   - iconv/iconv_substr                                     字符集转换
   - mb_convert_encoding/mb_strlen/mb_strcut/mb_substr      多字节字符串处理
   - hex2bin/pack                                           进制处理
   - json_encode/json_decode                                json编解码
   - gzdecode/gzencode                                      gzip解压缩处理，通常用于base64数据太大
   - base64_encode/base64_decode                            mime base64编解码
   - convert_uuencode                                       uuencode编解码
   - urlencode/urldecode                                    url编码，空格转为+
   - rawurlencode/rawurldecode                              url编码，空格转为%20
   - addslashes/stripslashes                                斜线转义
   - htmlentities                                           html转义编解码
   - htmlspecialchars/htmlspecialchars_decode/strip_tags    特殊字符、html实体转换
   - quotemeta/nl2br
   - serialize/unserialize                                  字符序列化
1. 时间类
   - date_default_timezone_set
   - time/microtime
   - mktime/strtotime
   - date
1. 文件类
   - mkdir
   - dirname
   - basename
   - getcwd
   - pathinfo
   - filetime
   - rename
   - stat
   - file_get_content/file_put_content
   - fopen
   - fread/fgets/fgetc
   - readfile
   - filesize
   - unlink
   - getimagesize
   - move_uploaded_file
1. 网络类
   - http_build_query
   - fopen/file_get_contents
   - ldap_connect
   - header
1. 安全类
   - md5/md5_file
   - sha1
   - crypt
   - addslashes/stripslashes
   - escapeshellarg
   - mysql_escape_string
1. 数学类
   - cadd 精度加法
   - bcsub 精度减法
   - bcmul 精度乘法
   - bcdiv 精度除法
   - bcscale 精度小数点保留位数
   - bccomp 精度比较
   - bcmod 精度取模
   - bcpow 精度成方
   - bcsqrt 精度二次方根
   - gmp 函数，专业计算
   - intval
   - number_format
   - pow
   - uniqid
   - round
   - abs 绝对值
   - rand/mt_rand
1. 系统类
   - const
   - getenv/putenv
   - ini_set/ini_get
   - php_sapi_name
   - set_include_path/get_include_path
   - shell_exec/system/proc_open
   - extract
   - set_time_limit
   - fastcgi_finish_request
   - ignore_user_abort
   - register_shutdown_function
   - echo 
   - print/printf/print_r/sprintf
   - var_dump/var_export
   - getmypid
1. 函数处理
   - function_exists
   - call_user_func/call_user_func_array
   - forward_static_call/forward_static_call_array
   - func_get_arg/func_get_args/func_num_args
   - get_defined_functions
   - register_shutdown_function
   - register_tick_function/unregister_tick_function
1. 资源
   - is_resource/get_resource_type
1. 错误
   - set_error_handler
   - trigger_error
   - display_errors/ini_set
   - error_reporting
1. **的背面
   - 装饰者模式，在一个model里的多个方法定义要获取的select，最后用一个end方法将结果返回。其实是个伪装饰者，就是一个对象层层返回，类似orm查询，能放到一个model执行查询的就放，不行的就另起一个查询并添加数据到数组里。在controller里链式调用，最终组合出自己想要的结果。真正的装饰者人家不干预主逻辑，只是前后执行自己的逻辑
