### 基础
1. 理解：是用go开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署
1. 特点
   - 轻量，内存占用小，高密度
   - 快速，毫秒启动
   - 隔离，沙盒技术更像虚拟机
1. 概念
   - 镜像：运行时镜像就是容器，保存时容器就是镜像。镜像是分层的
   - 容器：可以理解为在沙盒中运行的进程，沙盒包含了进程运行所必须的资源，包括文件系统、系统类库、shell环境等等。对容器的修改默认不会被保存
   - 仓库
1. 用途
   - web应用的自动化打包和发布
   - 自动化测试和持续集成、发布
### 命令
1. 镜像操作
   - 常用
     1. docker images       # 显示所有
     1. docker load         # 从tar包加载
     1. docker save         # 保存为tar包，带layers和tag信息
     1. docker rmi          # 删除
   - 其他
     1. docker import       # 从tar包创建
     1. docker export       # 导出为tar包，不带layers、tag信息
     1. docker history      # 显示历史
     1. docker tag          # 起tag名
1. 容器信息
   - docker ps              # 查看正在运行的容器，-a 列出所有
   - docker events          # 查看实时事件
   - docker version/info/logs/inspect/diff
   - docker port/top
1. 容器操作
   - docker create                                      # 创建不启动
   - docker run                                         # 创建并启动
     1. -p：-p 8080:80，端口映射，容器中的80映射到8080
     1. -d：将所运行的容器当做守护进程，即一直运行
     1. -v：挂载指向的本地目录
     1. -i：保持shell持续运行
     1. -t：创建虚拟tty
     1. --privileged：docker中的root具有真正的root权限
   - docker attach                                      # 进入容器
   - docker exec                                        # 在容器里执行命令，docker exec -it imageName /bin/bash，执行bash并进入交互式
   - docker start/stop/restart/kill/wait
   - docker commit                                      # 保存容器为新镜像
   - docker rm                                          # 删除容器
1. 文件传输
   - docker cp fileName imageId://usr/download          # 复制文件到容器
   - docker cp                                          # 从容器里向外复制文件
1. 仓库操作：docker login/search/pull/push
### Dockerfile
1. 理解：Dockerfile是docker构建镜像的基础，也是区别于其他容器的重要特征，有了Dockerfile，docker的自动化和可移植性才成为可能
1. 语法
   - FROM                   # 基础镜像
   - MAINTAINER             # 维护者，如MAINTAINER zzg 546268492@qq.com
   - ENV                    # 设置环境变量   
   - RUN                    # 执行命令
   - ADD                    # 添加文件，可加入远程文件
   - COPY                   # 复制文件
   - WORDDIR                # 指定命令运行路径
   - USER                   # 指定运行命令的用户   
   - ENTRYPOINT             # 容器入口   
   - CMD                    # 执行命令
   - EXPOSE                 # 暴露端口
   - VOLUME                 # 指定容器挂载的卷
1. 镜像分层：Dockerfile每一行都产生一个新层
1. 实例
    ```
    # 编辑
    vim Dockerfile
    FROM ubuntu                                                                             // 基础镜像
    MAINTAINER zzg
    RUN sed -i 's/archive.ubuntu.com/mirrors.ustc.edu.cn/g' /etc/apt/sources.list           // 修改源地址
    RUN apt-get update                                                                      // 更新apt库
    RUN apt-get install -y nginx                                                            // -y不需要确认
    COPY index.html /var/www/html
    ENTRYPOINT ["/usr/sbin/nginx", "-g", "daemon off;"]     // 容器入点，数组语法，用数组元素表示隔开的空格，将nginx前台执行，而不是守护进程
    EXPOSE 80
    # 构建运行
    docker build -t zzg/hello-nginx .
    docker run -p 80:80 -d zzg/hello-nginx
    ```
### Volume
1. 理解：提供独立于容器之外的持久化存储
1. 使用
   - docker run -v /usr/download imageName                                  # 给容器指定本地路径，通过inspect查看mounts的路径
   - docker run -v $PWD/locationPosition:/usr/download imageName            # 指定本地和容器目录的挂接
### 实例
1. 根据centos创建带ssh镜像
    ```
    docker run -i -t -d -p 22:22/tcp -p 80:80/tcp --name centos1 centos /bin/bash
    docker attach centos1
    yum -y install openssh-server passwd
    /usr/sbin/sshd
    ssh-keygen -q -t rsa -b 2048 -f /etc/ssh/ssh_host_rsa_key -N ''
    ssh-keygen -q -t ecdsa -f /etc/ssh/ssh_host_ecdsa_key -N ''
    ssh-keygen -t dsa -f /etc/ssh/ssh_host_ed25519_key  -N ''
    /usr/sbin/sshd
    passwd
    docker commit -m '' hash image-name:tagName
    启动新镜像并启动sshd
    ```
1. 运行容器
    ```
    docker load -i okayAdmin.tar
    docker run -t -i -d --privileged -p 8050:8050/tcp -v /xdfapp/centos:/xdfapp/xdf --name containerName xdfAdmin /bin/bash
    docker attach xdfAdmin
    ```
