### 基础
1. 理解docker是用go语言开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署
1. 概念
   - 镜像
   - 仓库
   - 容器：可以理解为在沙盒中运行的进程，沙盒包含了进程运行所必须的资源，包括文件系统、系统类库、shell环境等等
1. 用途
   - web应用的自动化打包和发布
   - 自动化测试和持续集成、发布
1. 镜像和容器：运行时镜像就是容器，保存时容器就是镜像
1. 对容器的修改默认不会被保存
### 命令
1. 基础
   - docker version
   - docker info————本机安装的镜像等信息
   - docker ps————默认查看正在运行的容器列表
     1. -a：列出所有容器
   - docker inspect imageId————查看容器详细信息
1. 镜像
   - docker search userName/imageName
   - docker pull userName/imageName
   - docker rmi imageId————删除镜像
   - docker images————查看所有安装过的镜像
1. 使用镜像
   - docker load dockerfile
   - docker run 镜像名 (要在镜像中运行的命令)
     1. -p：-p 8080:80，端口映射，容器中的80映射到8080
     1. -d：将所运行的容器当做守护进程，即一直运行
     1. -v：挂载指向的本地目录
   - docker stop imageId
   - docker attach imageName
1. 镜像生成
   - docker commit imageId imageName————保存对容器的修改，同时提交容器副本(保存改动为新的镜像)
     1. -m：-m ''，备注信息
   - docker build imageLocation：用Dockerfile构建镜像
     1. -t：指定镜像名
   - docker push userName/imageName————将镜像发布到官网
1. 容器
   - docker rm————删除container
1. 文件传输
   - docker cp fileName imageId://usr/download————复制文件到容器
### Dockerfile
1. 语法
   - FROM————基础镜像
   - RUN————执行命令
   - ADD————添加文件，可加入远程文件
   - COPY————复制文件
   - CMD————执行命令
   - EXPOSE————暴露端口
   - WORDDIR————指定命令运行路径
   - MAINTAINER————维护者
   - ENV————设置环境变量
   - ENTRYPOINT————容器入口
   - USER————指定运行命令的用户
   - VOLUME————指定容器挂载的卷
1. 镜像分层：Dockerfile每一行都产生一个新层
### Volume
1. 理解：提供独立于容器之外的持久化存储
### 举例
1. 运行容器
```
docker load -i okayAdmin.tar
#启动 /xdfapp/apps/centos 改成okayAdmin的本地路径
docker run -t -i --privileged -p 8050:8050/tcp -d --name xdfokayAdmin -v /xdfapp/apps/centos:/xdfapp/ubuntuxdf /bin/bash
docker attach xdfokayAdmin
```
1. Dockerfile构建镜像
```
vim Dockerfile
#文件内容
FROM ubuntu // 基础镜像
MAINTAINER zzg
RUN sed -i 's/archive.ubuntu.com/mirrors.ustc.edu.cn/g' /etc/apt/sources.list // 修改源地址
RUN apt-get update // 更新apt库
RUN apt-get install -y nginx // -y不需要确认
COPY index.html /var/www/html
ENTRYPOINT ["/usr/sbin/nginx", "-g", "daemon off;"] // 容器入点，数组语法，用数组元素表示隔开的空格，将nginx前台执行，而不是守护进程
EXPOSE 80 // 暴露80端口
#文件内容
docker build -t zzg/hello-nginx .
docker run -p 80:80 -d zzg/hello-nginx
```