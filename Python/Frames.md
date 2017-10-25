## Django
1. 特点
   - 效率高：使用ORM
   - 大量内置应用，后台管理admin，用户认证auth，会话系统sessions
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
## Web.py
## Flask