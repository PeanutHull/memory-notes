###关于Apache
1. 特点
   - 模块化，模块多
   - 支持虚拟主机
   - 支持cgi、fastcgi、ssl、servlet
1. Apache的工作模式
   - CGI模式
     1. 用法：`Action application/x-httpd-php "/php/php-cgi.exe"`
     1. 原理：apache调用php.exe去解释文件，再将结果以网页的形式返回给客户机
   - 模块模式
     1. 用法：`LoadModule php5_module "c:/php/php5apache2.dll"`
     1. 原理：php和apache一起启动并运行
   - FastCGI模式
     1. 用法：1. 下载fastcgi模块mod_fcgid.so/mod_fcgid.pd。2. 添加配置
###常用命令
1. windows下
   - httpd.exe -t // 检测配置文件是否正确
   - httpd.exe -k install
   - httpd.exe -k start/stop/restart
###window下安装apache+php
1. 安装目录：
   - Apache：C://http/http/Apache24
   - PHP：C://http/php
1. 安装vc_redist.x64.exe和vcredist_x64
1. apache配置修改
   - 将c:/Apache24全部替换成c:/http/http/Apache24
   - 在#LoadModule xml2enc_module modules/mod_xml2enc.so下面添加
     1. LoadModule php5_module "C:/http/php/php5apache2_4.dll"
     1. AddType application/x-httpd-php .php .html .htm
     1. PHPIniDir "C:/http/php"
   - 将DirectoryIndex index.html改为DirectoryIndex index.php index.html
   - 将ServerName www.example.com:80的注释去掉
1. php环境配置
   - 把php文件目录下的libeay32.dll/php5ts.dll/ssleay32.dll和ext文件中的php_curl.dll复制到windows/system32下
   - 把C:/http/php和C:/http/php/ext加入环境变量
1. php配置
   - 将php.ini-development在当前目录复制一份，保存为php.ini
   - extension_dir 指向c://http/php/ext
   - extension=php_curl.dll的分号去掉
   - date.timezone = 修改为date.timezone = Asia/Shanghai，去掉分号
1. 启动
   - 双击C://http/php/php.exe
   - httpd.exe -k install
   - httpd.exe -k start
