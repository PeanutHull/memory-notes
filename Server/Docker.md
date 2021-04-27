### 基础
1. 理解：是用go开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署。内核容器技术，将(LXC、cgroups、Union FS)整合和包装，形成了标准镜像格式
1. 特点
   - 轻量，内存占用小，高密度(每个虚拟机需要一套os)
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
    ## TODO 应该设置开机启动，否则需要先进入shell
    ```
1. 运行容器
    ```
    docker load -i okayAdmin.tar
    docker run -t -i -d --privileged -p 8050:8050/tcp -v /xdfapp/centos:/xdfapp/xdf --name containerName xdfAdmin /bin/bash
    docker attach xdfAdmin
    ```
### Kubernetes
1. 理解：k8s，google开源的一个容器管理、编排、调度引擎和平台，是微服务的支撑平台，是可移植的云平台。用于管理云平台中多个主机上的容器化的应用，让部署容器化的应用简单并且高效，提供自动负载均衡，自动纠错，自动分配负载、自动回滚，管理应用、负载均衡、域名、服务
   - 以Pod为基本的编排和调度单元，声明式的对象配置模型(控制器、configMap、secret)
   - 资源分配管理
   - 健康检查、自愈、伸缩、滚动升级
1. 特点
   - 颁布了云原生的标准，已经成为容器管理领域的标准，支持跨云迁移
   - 生态圈：是google最成熟的管理经验输出，是战胜Docker Swarm和Apache Mesoc唯一值得绑定的平台，是google、Red Hat的OpenShift、Microsoft的AWS、IBM的云平台提供商的支持
1. 组成
   - Deployment：部署
   - Pods：容器组
   - Service：服务
   - Ingress：路由
   - ConfigMap：配置项
1. 对微服务的支撑
   - 服务注册发现、服务编排、内部路由
   - 快速部署、负载均衡
   - 有状态的服务支持
1. 前端发布：k8s+skaffold +kaniko + gitops
### 云计算
1. 认识
   - 云部署形式
     1. 公有云
     1. 私有云：企业内部
     1. 混合云：如存储内部、计算外部
   - 云服务模式
     1. IaaS：基础设施即服务
     1. PaaS：平台即服务
     1. SaaS：软件即服务，面向用户
1. 虚拟机
   - 认识：VM，Virtual Machine
   - 虚拟技术
     1. 全虚拟化：软件模拟硬件接口，性能低
     1. 半虚拟化：修改客户操作系统配合
     1. 硬件辅助虚拟化：硬件支持虚拟硬件接口
     1. 主机虚拟化
        - 虚拟硬件接口
        - 虚拟操作系统接口：更轻量，无法更深层次虚拟，不安全
     1. 操作系统虚拟化
1. Hypervisor
   - 认识：VMM，即Virtual Machine Monitor，虚拟机监视器，一种运行在物理服务器和操作系统之间的中间软件层,可允许多个操作系统共享硬件
     1. 是一种在虚拟环境中的“元”操作系统。他们可以访问服务器上磁盘和内存在内的所有物理设备
     1. 不但协调着这些硬件资源的访问，而且在各个虚拟机之间施加防护
   - 分类
     1. I型：虚拟机直接运行在系统硬件上，创建硬件全仿真实例，被称为“裸机”型。直接管理调用硬件资源，不需要底层操作系统，也可以将Hypervisor看作一个很薄的操作系统
        - 方案的性能处于主机虚拟化与操作系统虚拟化之间
     1. II型：虚拟机运行在传统操作系统上，同样创建的是硬件全仿真实例，被称为“托管（宿主）”型，性能是三种虚拟化技术中最差的
     1. III型：虚拟机运行在传统操作系统上，创建一个独立的虚拟化实例（容器），指向底层托管操作系统，被称为“操作系统虚拟化”。
        - 在操作系统中模拟出运行应用程序的容器，所有虚拟机共享内核空间，性能最好，耗费资源最少。缺点是底层和上层必须使用同一种操作系统
   - 厂商和产品
     1. VMware vSphere
     1. 微软Hyper-V
     1. Citrix XenServer 
     1. IBM PowerVM
     1. Red Hat Enterprise Virtulization
     1. Huawei FusionSphere
     1. 开源的：KVM、Xen、VirtualBSD等
1. kvm
   - 认识：Kernel-Based Virtual Machine，是集成到linux内核的Hypervisor，完全内置于Linux，只需加载即可
     1. 开源的，需要硬件支持(如Intel-VT，AMD-V)的完全虚拟化
     1. kvm本身只关注虚拟机调度和内存管理、硬件交互。IO外设的任务交给linux内核和qemu
   - qemu：虚拟化软件，可以虚拟不同的cpu，支持异构（x86架构可虚拟化出不是x86的架构）
     1. qemu-kvm：kvm借鉴qemu进行一定修改而形成，用户态管理kvm，网卡，声卡，PCI设备等都是qemu来管理
   - 安装
     1. 确认cpu支持虚拟化，intel的VMX，amd的SVM。`grep -E "svm|vmx" /proc/cpuinfo`
     1. 安装
        - `yum install -y qemu-kvm libvirt`
        - `yum install -y virt-install`
     1. 创建虚拟磁盘：`qemu-img create`
     1. 启动服务：`systemctl enable libvirtd`
     1. 上传镜像
     1. 挂载目录
     1. 创建虚拟机：`virt-install`
     1. 启动、查看：`virsh list/start xx`
     1. 热添加cpu：`virsh edit xx.xml`
   - 优化
     1. cpu：物理机到虚拟机多次的上下文切换有性能问题，intel实现了技术VT-x在cpu硬件实现加速转换
     1. cpu缓存绑定：提高ln缓存亲和力从而提升性能
     1. 内存：以前VMM通过影子页表决解内存转换，coreI7系列处理器上集成了EPT技术，以硬件辅助的方式完成客户物理内存到机器物理内存的转换，完成内存虚拟化
1. 云管理平台
   - 认识：部署，配置管理
     1. openstack是本身不提供虚拟化功能，虚拟化能力由底层的hypervisor（如KVM、Qemu、Xen等）提供。所谓管理平台只是为了方便使用。如果没有openstack，一样可以通过virsh、virt-manager的命令行来实现创建虚拟机的操作
   - openstack：用于管理基础设施的一系列开源项目组成的平台，是拥有众多支持者的大项目，白金会员等等一堆
     1. 基础设施层
        - Nova：计算服务
        - Glance：镜像服务
        - Keystone：认证、身份服务
     1. 扩展基础设施层
        - Neutron：flat\flatdhcp\vlan，网络服务
        - Cinder/Swift：存储服务
        - Designate：dns
        - ironic：裸机服务
     1. 增强特性
        - Horizon：可视化、ui服务
        - Ceilometer：监控计量服务
     1. 消费型服务
        - Heat：编排组织服务
   - saltstack
     1. 认识：服务器管理平台，具备配置管理、远程执行、监控等功能，用salt命令控制多台机器，基于python实现，用python函数执行。可以批量执行命令
        - 自动化运维利器，提高工作效率、规范业务配置与操作，替换了早期运维人员写特定脚本完成大量重复性工作
     1. 结构：master中心控制，minion被管理客户端
   - cloudstack
   - virsh/virt-manager
### wiki
1. wiki
   - 应用部署形式：物理单机->虚拟机(openstack)->容器->云原生，更敏捷、自动化、效率、低成本
   - 其他：Swarm、Mesos
   - 边缘计算：是一种分散式运算的架构，将应用程序、数据资料与服务的运算，由网络中心节点移往网络逻辑上的边缘节点来处理。类似cdn思想，实现更快速，去中心化
   - 裸金属服务器：就是直接对接hypervisor的服务器
   - DevOps
     1. Prometheus监控：资源、性能、办公网连通性、流量
     1. Graylog日志
   - vagrant：基于Ruby的工具，用于创建和部署虚拟化开发环境。使用Oracle的开源VirtualBox，使用Chef创建自动化虚拟环境
1. 和虚拟机比较：![avatar](../images/compareWithHypervisor.jpg)