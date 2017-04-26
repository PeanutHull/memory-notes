1. $_SERVER：php的预定义变量，包含服务器信息
   - 请求头：ajax的$\_SERVER['HTTP\_X\_REQUESTED_WITH']
   - 路径
   - 脚本位置
1. php页面跳转方法
   - header
        ```PHP
        header("HTTP/1.1 303 See Other");
        header('Location:xxx');exit;
        ```
   - `window.location.href` 和 `window.open`