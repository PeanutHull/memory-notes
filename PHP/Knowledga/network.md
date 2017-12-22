1. $_SERVER：php的预定义变量，包含服务器信息的数组
   - 请求头：ajax的['HTTP_X_REQUESTED_WITH']为'xmlhttprequest'
   - 路径
   - 脚本位置
1. $_POST只会包含application/x-www-form-urlencoded和multipart/form-data两种类型
1. php页面跳转方法
   - header
        ```PHP
        header("HTTP/1.1 303 See Other");
        header('Location:xxx');exit;
        exit; // 不然会执行如下代码
        ```
   - `window.location.href` 和 `window.open`
   - echo各种标签跳转：META(HTTP-EQUIV)、sc rīpt(window.location.href、window.open)