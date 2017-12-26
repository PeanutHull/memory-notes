1. 处理字符串的匿名
```
$nickname = mb_substr($nickname, 0, 1, 'utf-8').'**'.mb_substr($nickname, mb_strlen($nickname, 'utf-8') - 1, 1, 'utf-8');
```
1. mb_substr比iconv_substr更快，兼容性好
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