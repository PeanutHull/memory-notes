### Web
1. Django：全能型Web框架
   - 效率高：使用ORM
   - 大量内置应用，后台管理admin，用户认证auth，会话系统sessions，最流行
   - 安全性好：表单验证、SQL注入、跨站点攻击
   - 易于扩展
1. 安装
   - 安装django：`pip install Django==1.10`或者`python setup.py install`
   - 新建项目：`django-admin startproject siteName`，`django-admin`为框架管理命令
   - 启动项目：`python manage.py runserver`
   - 创建应用：`python manage.py startapp blog`，之后将应用名添加到settings.py的NSTALLED_APPS
   - 查看命令行：`python manage.py`
1. 项目结构
   - manage.py：项目管理文件
   - siteName目录
     1. setting.py：配置文件
     1. urls.py：路由
     1. wsgi.py：和web服务器的接口
1. Django Shell：可以输入命令，做一些调试工作
    ```python
    python manage.py shell      # 进入shell
    Article.objects.all()       # 查询数据
    ```
1. flask：流行的微框架
1. bottle：类似flask
1. web.py：小巧
1. falcon，高性能api
1. Tornado：Facebook的开源异步web框架
### 服务器
1. wsgi：web服务器和应用服务器通信的协议，用于python程序
   - 响应：要求实现application函数，就可以响应http
    ```python
    def application(environ, start_response):
        start_response('200 OK', [('Content-Type', 'text/html')])
        return [b'<h1>Hello, web!</h1>']
    ```
   - 创建服务器：server.py
    ```python
    from wsgiref.simple_server import make_server
    from hello import application                       # 导入我们自己编写的application函数:
    
    httpd = make_server('', 8000, application)          # 创建一个服务器，ip地址为空，端口是8000，处理函数是application:
    print('Serving HTTP on port 8000...')
    httpd.serve_forever()                               # 开始监听http
    ```
1. uwsgi：是uWSGI服务器的独占通信协议
1. uWSGI
   - 理解：web应用服务器，c编写，可以将http协议转换为wsgi协议让python使用
   - 和框架：Django自带服务器不稳定只能用于测试，搭配uwsgi和nginx实现服务器
   - 配置
     1. uwsgi.ini
        ```
        [uwsgi]
        socket = 127.0.0.1:9090
        master = true         //主进程
        vhost = true          //多站模式
        no-site = true        //多站模式时不设置入口模块和文件
        workers = 2           //子进程数
        reload-mercy = 10     
        vacuum = true         //退出、重启时清理文件
        max-requests = 1000   
        limit-as = 512
        buffer-size = 30000
        pidfile = /var/run/uwsgi9090.pid    //pid文件，用于下面的脚本启动、停止该进程
        daemonize = /website/uwsgi9090.log
        ```
     1. nginx配置
        ```
        server {
            listen       80;
            server_name  localhost;
            
            location / {            
                include  uwsgi_params;
                uwsgi_pass  127.0.0.1:9090;              //必须和uwsgi中的设置一致
                uwsgi_param UWSGI_SCRIPT demosite.wsgi;  //入口文件，即wsgi.py相对于项目根目录的位置，“.”相当于一层目录
                uwsgi_param UWSGI_CHDIR /demosite;       //项目根目录
                index  index.html index.htm;
                client_max_body_size 35m;
            }
        }
        ```
   - 运行：uwsgi --ini /etc/uwsgi9090.ini
### 爬虫
1. scrapy