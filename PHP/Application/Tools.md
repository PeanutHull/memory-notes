### Composer
1. 理解：php依赖管理工具
1. 使用
   - 安装
     1. composer create-project                         // 创建Composer项目
     1. composer init                                   // 初始化项目依赖，自动生成json文件
     1. composer install/update (foo/bar:1.0.0)         // 安装/更新所有/单个依赖
   - 自动加载：composer自动会生成一个vender/autoload.php，载入这个文件后，直接new，就会自动载入。在composer.json的autoload字段中增加自己的autoloader
        ```
        "autoload": {                       // Composer将注册一个PSR-4 autoloader到Acme命名空间
            "psr-4": {"Acme\\": "src/"}
        }
        ```
   - 为生产环境做准备：`composer dump-autoload --optimize`
1. 参数
   - --prefer-dist：用于install/update，强制下载源代码，在修改文件后更新文件会给出提示
   - --prefer-source
   - --lock：仅更新锁文件，用于update
1. 运维
   - 更新
     1. composer/php composer.phar -V
     1. composer self-update
1. 考虑缓存，dist包优先？？？
### PSR
1. 解释：PHP Standards Recommendation，是PHP-FIG组织制定的php推荐书写标准
1. 分类
   - PSR-1：基本的代码风格
     1. 标签   php代码必须在<?php ?>中
     1. 编码   必须使用utf8，不能有字节顺序标记(BOM Byte Order Mark)
     1. 常量   全部大写，可用下划线
     1. 类名   必须驼峰
     1. 方法名 小写开头+驼峰
     1. 加载   命名空间和类必须遵守psr-4自动加载器标准
     1. 目的   一个php文件，要么定义符号，要么执行操作，不能同时做
   - PSR-2：严格的代码风格
     1. 贯彻   首先遵守psr-1
     1. 缩进   四个空格
     1. 文件和代码行、关键字、命名空间、类、方法、可见性、控制结构
   - PSR-3：日志记录器接口，不是指导，是一个接口
   - PSR-4：自动加载，命名空间前缀和文件系统的目录对应起来，代替PSR-0(已弃用)
   - PSR-7：http通信标准
1. 注释书写参考
   - @access
   - @param  string|array
   - @static
   - @return  void|
   - @desc
   - @example
   - @version
### 函数大全
1. 字符串类
   - serialize
   - preg_split
   - split
   - chunk_split
   - strpos
   - str_split
   - explode
   - trim
   - strrev
   - substr
   - mb_substr
   - iconv_substr
   - mb_strlen
   - mb_strcut
   - preg_replace
   - preg_match
   - preg_match_all
   - chr
   - ord
   - str_repeat
   - substr_count
   - str_shuffle
1. 数组类
   - implode别名join
   - array_diff
   - array_column
   - array_unique
   - array_sum
   - empty(只能检测变量)
   - count
   - array_merge
   - in_array
   - array_pop
   - array_push
   - array_shift
   - array_values(键名全置数字)
   - array_slice
   - list(给一组变量赋值)
   - each
   - reset
   - ksort
   - array_reverse
   - serialize()     序列化
   - unserialize()   反序列化
1. 判断类
   - is_null
   - is_int
   - is_array
   - is_string
   - is_file
   - is_dir
   - is_writeable
   - empty
   - in_array
   - function_existsde
1. 编码类
   - json_decode
   - iconv
   - mb_convert_encoding
   - htmlentities
   - htmlspecialchars
   - htmlspecialchars_decode
   - strip_tags
   - addslashes
   - stripslashes
   - quotemeta
   - nl2br
   - strip_tags
   - mysql_real_escape_string
   - mysql_escape_string
   - base64_decode
   - base64_encode
   - rawurldecode
   - rawurlencode
   - urldecode
   - urlencode
1. 常变量
   - const
   - define
   - defined
   - constant
1. 类类
   - class_exists();
   - get_class();
   - get_class_methods();
   - interface_exist();
   - instanceof
1. 时间类
   - time
   - date
   - strtotime
   - microtime
   - mktime
1. 文件类
   - is_writeable
   - is_readable
   - unlink
   - mkdir
   - readfile
   - filetime
   - basename
   - dirname
   - rename
   - pathinfo
   - file_get_content
   - file_put_content
   - is_file
   - is_dir
   - file_exist
   - filesize
   - stat
   - getcwd
   - getimagesize
   - getimagesizefromstring
   - move_uploaded_file
1. 网络类
   - http_build_query
   - file_get_contents
   - fopen
   - fget
   - fgetc
   - fclose
   - ldap_connect
   - header
1. 安全类
   - md5
   - sha1
   - crypt
   - addslashes
   - stripslashes
   - mysql_real_escape_string
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
   - rand
   - mt_rand
   - pow
   - uniqid
   - round
   - abs 绝对值
1. 系统类
   - onst
   - list
   - getenv
   - putenv
   - shell_exec
   - system
   - call_user_func_array()
   - extract()
   - var_export
   - var_dump
   - set_time_limit