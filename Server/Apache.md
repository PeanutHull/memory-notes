1. Apache的工作模式
   - CGI模式
     1. 用法：`Action application/x-httpd-php "/php/php-cgi.exe"`
     1. 原理：apache调用php.exe去解释文件，再将结果以网页的形式返回给客户机
   - 模块模式：
     1. 用法：`LoadModule php5_module "c:/php/php5apache2.dll"`
     1. 原理：php和apache一起启动并运行
   - FastCGI模式：
     1. 用法：1. 下载fastcgi模块mod_fcgid.so/mod_fcgid.pd。2. 添加配置