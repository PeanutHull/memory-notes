### Web
1. Django
   - 认识：全能型Web框架
     1. 效率高：使用ORM
     1. 大量内置应用，后台管理admin，用户认证auth，会话系统sessions，最流行
     1. 安全性好：表单验证、SQL注入、跨站点攻击
     1. 易于扩展
   - 安装
     1. 安装django：`pip install Django==1.10`或者`python setup.py install`
     1. 新建项目：`django-admin startproject siteName`，`django-admin`为框架管理命令
     1. 启动项目：`python manage.py runserver 0.0.0.0:5000`，`vim demosite/settings.py--ALLOWED_HOSTS = ['*',]`
     1. 创建应用：`python manage.py startapp blog`，之后将应用名添加到settings.py的NSTALLED_APPS
     1. 查看命令行：`python manage.py`
   - 项目结构
     1. manage.py：项目管理文件
     1. siteName目录
     1. setting.py：配置文件
     1. urls.py：路由
     1. wsgi.py：和web服务器的接口
   - Django Shell：可以输入命令，做一些调试工作
    ```python
    python manage.py shell      # 进入shell
    Article.objects.all()       # 查询数据
    ```
1. FastAPI
1. flask：流行的微框架
1. bottle：类似flask
1. web.py：小巧
1. falcon，高性能api
1. Tornado：Facebook的开源异步web框架，非阻塞io
   - 认识：高性能异步的开源web框架，最早的python2的时候实现第三方协程的框架，python3也提供官方的协程实现
     1. 自己写的协程调度，基本原理和这个框架是一样的
        - @tornado/tornado/gen.py
        - @tornado/tornado/platform/asyncio.py：官方协程
1. 模板
   - jinja2：flask默认模板
   - Mako
   - Cheetah
   - Django：是一站式框架，内置一个用{% ... %}和{{ xxx }}的模板
### 服务器
1. wsgi：Python Web Server GateWay Interface，web服务器和只应用于python服务器通信的协议
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
1. uwsgi
   - 理解：是web服务器，c编写，实现了WSGI、uwsgi、http等协议。可以将http协议转换为wsgi协议让python使用，uwsgi似乎不能充分利用cpu和内存达到无上限并发。到达瓶颈后cpu和内存还剩下很多
     1. Django自带服务器不稳定只能用于测试，搭配uwsgi和nginx实现服务器
     1. uwsgi：uWSGI服务器实现的独有协议
   - 配置
     1. 使用配置文件：uwsgi --ini uwsgi.ini
        ```conf
        [uwsgi]
        socket = 127.0.0.1:9090
        master = true         # 启动主进程，方便管理所有进程
        vhost = true          # 多站模式
        chdir = /etc
        no-site = true        # 多站模式时不设置入口模块和文件
        workers = 2           # 子进程数
        reload-mercy = 10     
        vacuum = true         # 退出、重启时清理文件
        max-requests = 1000   
        limit-as = 512
        buffer-size = 30000
        pidfile = /var/run/uwsgi9090.pid    # pid文件，用于下面的脚本启动、停止该进程
        daemonize = /website/uwsgi9090.log
        ```
     1. 指定参数
        ```python
        uwsgi
        --http :9090                                    # 使用http协议，不限定来源？
        --socket :5000                                  # 和nginx配合
        --http-socket 127.0.0.1:3031                    # 使用http协议
        --wsgi-file foobar.py                           # 指定运行文件
        --chdir /etc                                    # 指定项目路径
        --master --processes 4 --threads 2              # 启动多进程、多线程，并发访问
        --daemonize                                     # 增加守护进程，稳定性
        --stats 127.0.0.1:9191                          # 监控子系统，pip install uwsgitop
        ```
   - 入口文件：搜索默认函数application，使用Django就指向Django的目录
    ```python
    def application(env, start_response):
        start_response('200 OK', [('Content-Type','text/html')])
        return [b"Hello World"]
    ```
   - 配合nginx
    ```conf
    server {
        listen       80;
        server_name  localhost;
        
        location / {            
            include  uwsgi_params;
            uwsgi_pass  127.0.0.1:9090;                  //必须和uwsgi中的设置一致
            uwsgi_param UWSGI_SCRIPT index.wsgi;         //入口文件，即wsgi.py相对于项目根目录的位置，“.”相当于一层目录
            uwsgi_param UWSGI_CHDIR /home/python;        //项目根目录
            index  index.html index.htm;
            client_max_body_size 35m;
        }
    }
    ```
1. gunicorn
   - 认识：轻量级、高性能WSGI HTTP Server，兼容多数python web框架，只在linux运行
     1. 反向代理、负载均衡、web应用
     1. pre-fork worker model：就php那种形式，请求来之前就fork好了
### 爬虫
1. scrapy
1. wiki：‌组合利用好各种api可以实现数据统计的效果，如和地图结合查看数据分布，定时监控某个想要的数据
### 数据清洗
### 人工智能
1. pytorch
   - 认识：facebook的研究员在17年开源的，也会用到c++
1. PaddleSpeech：中英文语音识别与语音合成