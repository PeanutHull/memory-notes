###基础
1. 理解docker是用go语言开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署
1. 概念
   - 镜像
   - 仓库
   - 容器：可以理解为在沙盒中运行的进程，沙盒包含了进程运行所必须的资源，包括文件系统、系统类库、shell环境等等
1. 用途
   - web应用的自动化打包和发布
   - 自动化测试和持续集成、发布
1. 镜像和容器：运行时镜像就是容器，保存时容器就是镜像
###命令
1. 基础
   - docker version
   - docker info：本机安装的镜像等信息
   - docker ps：查看正在运行的容器列表
   - docker inspect imageId：查看容器详细信息
1. 镜像
   - docker search userName/imageName
   - docker pull userName/imageName
   - docker images：查看所有安装过的镜像
1. 使用镜像
   - docker load xx.tar
   - docker run 镜像名 (要在镜像中运行的命令)
   - docker attach imageName：对容器的修改即时生效
1. 镜像生成
   - docker commit imageId imageName：提交容器副本
   - docker push userName/imageName：将镜像发布到官网
###举例
1. 进入容器
```
docker load -i okayAdmin.tar
#启动 /xdfapp/apps/centos 改成okayAdmin的本地路径
docker run -t -i --privileged -p 8050:8050/tcp -p 8888:8888/tcp -p 2181:2181/tcp -d --name xdfokayAdmin -v /xdfapp/apps/centos:/xdfapp/ubuntuxdf /bin/bash
docker attach xdfokayAdmin
```