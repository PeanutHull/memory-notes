### 基础
1. 理解docker是用go语言开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署
1. 概念
   - 镜像
   - 仓库
   - 容器：可以理解为在沙盒中运行的进程，沙盒包含了进程运行所必须的资源，包括文件系统、系统类库、shell环境等等
1. 特点
   - 轻量，体现在内存占用小，高密度
   - 快速，毫秒启动
   - 隔离，沙盒技术更像虚拟机
1. 用途
   - web应用的自动化打包和发布
   - 自动化测试和持续集成、发布
1. 镜像和容器：运行时镜像就是容器，保存时容器就是镜像
1. 对容器的修改默认不会被保存，镜像是分层的
### 命令
1. 镜像仓库(registry)操作
   - docker login # 登录到一个registry
   - docker search # 从registry仓库搜索镜像
   - docker pull # 从仓库下载镜像到本地
   - docker push # 将一个镜像push到registry仓库中
1. 镜像操作
   - docker images # 显示本地所有的镜像列表
   - docker import # 从一个tar包创建一个镜像
   - docker export # 将容器整个文件系统导出为一个tar包，不带layers、tag等信息
   - docker build # 使用Dockerfile创建镜像（推荐）
     1. -t：指定镜像名
   - docker commit imageId imageName # 保存对容器的修改，同时提交容器副本(保存改动为新的镜像)
     1. -m：-m ''，备注信息
   - docker rmi # 删除一个镜像
   - docker load # 从一个tar包创建一个镜像，和save配合使用
   - docker save # 将一个镜像保存为一个tar包，带layers和tag信息
   - docker history # 显示生成一个镜像的历史命令
   - docker tag # 为镜像起一个别名
1. 容器相关信息
   - docker version
   - docker info # 本机安装的镜像等信息
   - docker ps # 默认查看正在运行的容器列表，-a 列出所有容器
   - docker inspect imageId # 查看容器详细信息
   - docker logs # 查看容器的日志(stdout/stderr)
   - docker events # 得到docker服务器的实时的事件
   - docker port # 显示容器的端口映射
   - docker top # 显示容器的进程信息
   - docker diff # 显示容器文件系统的前后变化
1. 容器相关操作
   - docker create --name imageName baseImage # 创建一个容器但是不启动它
   - docker run # 创建并启动一个容器
     1. -p：-p 8080:80，端口映射，容器中的80映射到8080
     1. -d：将所运行的容器当做守护进程，即一直运行
     1. -v：挂载指向的本地目录
     1. -i：保持shell持续运行
     1. -t：创建虚拟tty
     1. --privileged：docker中的root具有真正的root权限
   - docker stop # 停止容器运行，发送信号SIGTERM
   - docker start # 启动一个停止状态的容器
   - docker restart # 重启一个容器
   - docker rm # 删除一个容器
   - docker kill # 发送信号给容器，默认SIGKILL
   - docker attach # 连接(进入)到一个正在运行的容器
   - docker exec # 在容器里执行一个命令，docker exec -it imageName /bin/bash，执行bash并进入交互式
   - docker wait # 阻塞到一个容器，直到容器停止运行
1. 文件传输
   - docker cp fileName imageId://usr/download # 复制文件到容器
   - docker cp # 从容器里向外拷贝文件或目录
### Dockerfile
1. 理解：Dockerfile是docker构建镜像的基础，也是区别于其他容器的重要特征，有了Dockerfile，docker的自动化和可移植性才成为可能。要学会编写Dockerfile
1. 语法
   - FROM # 基础镜像
   - MAINTAINER # 维护者，如MAINTAINER zzg 546268492@qq.com
   - ENV # 设置环境变量   
   - RUN # 执行命令
   - ADD # 添加文件，可加入远程文件
   - COPY # 复制文件
   - WORDDIR # 指定命令运行路径
   - USER # 指定运行命令的用户   
   - ENTRYPOINT # 容器入口   
   - CMD # 执行命令
   - EXPOSE # 暴露端口
   - VOLUME # 指定容器挂载的卷
1. 镜像分层：Dockerfile每一行都产生一个新层
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
### Volume
1. 理解：提供独立于容器之外的持久化存储
1. 使用
   - docker run -v /usr/download imageName # 给容器指定本地路径，通过inspect查看mounts的路径
   - docker run -v $PWD/locationPosition:/usr/download imageName # 指定本地和容器目录的挂接
### 举例
1. 运行容器
    ```
    docker load -i okayAdmin.tar
    #启动 /xdfapp/apps/centos改成okayAdmin的本地路径
    docker run -t -i -d --privileged -p 8050:8050/tcp -v /xdfapp/apps/centos:/xdfapp/ubuntuxdf --name containerName xdfokayAdmin /bin/bash
    docker attach xdfokayAdmin
    ```
1. 通过ssh连接docker
   - docker run -i -t -d -p 22:22/tcp -p 80:80/tcp --name centos1 centos /bin/bash
   - docker attach centos1
   - yum -y install openssh-server passwd
   - /usr/sbin/sshd
   - ssh-keygen -q -t rsa -b 2048 -f /etc/ssh/ssh_host_rsa_key -N ''
   - ssh-keygen -q -t ecdsa -f /etc/ssh/ssh_host_ecdsa_key -N ''
   - ssh-keygen -t dsa -f /etc/ssh/ssh_host_ed25519_key  -N ''
   - /usr/sbin/sshd
   - passwd
   - docker commit -m '' hash image-name:tagName
   - 启动新镜像并启动sshd
