### 基础
1. 理解：是用go开发的开源应用容器引擎，可以为应用创建可移植的、轻量级的容器。允许开发者打包应用到一个可移植的容器中，然后可以批量地在生产环境中部署。内核容器技术，将(LXC、cgroups、Union FS)整合和包装，形成了标准镜像格式。容器就是一个进程集合，只需要一个独立的文件系统提供其所需要文件集合即可。所有的文件隔离都是进程级别的，隔离效果相比 VM 要差很多
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
1. 理解：k8s，google开源的一个容器管理、编排、调度引擎和平台。用于管理云平台中多个主机上的容器化的应用，让部署容器化的应用简单并且高效
   - 资源分配管理
   - 健康检查、自愈、伸缩、滚动升级
   - 提供自动负载均衡，自动纠错，自动分配负载、自动回滚，管理应用、负载均衡、域名、服务等
   - 以pod为基本的编排和调度单元，声明式的对象配置模型(控制器、configMap、secret)
1. 特点
   - 是微服务的支撑平台，是可移植的云平台
   - 颁布了云原生的标准，已经成为容器管理领域的标准，支持跨云迁移
   - 生态圈：是google最成熟的管理经验输出，是战胜Docker Swarm和Apache Mesoc唯一值得绑定的平台
     1. google、Red Hat的OpenShift、Microsoft的AWS、IBM的云平台提供商的支持
1. 对微服务的支撑
   - 服务注册发现、服务编排、内部路由
   - 快速部署、负载均衡
   - 有状态的服务支持
1. 组成
   - Master：通过etcd的List-Watch方式通信（事件发送与监听）
     1. APIServer
     1. Controller Manager：管理，调整资源状态、执行宕机修复流程等，是运维自动化的核心，分为8个Controller
     1. Scheduler：调度，关注待调度的Pod、可用的Node，调度算法和策略
        - 将待调度的Pod按照算法和策略绑定到Node上，同时将信息保存在etcd中
        - kubelet 通过 APIServer 监听到 Scheduler 产生的 Pod 绑定事件，然后通过 Pod 的描述装载镜像文件，并且启动容器
   - Node
     1. kubelet：具体执行命令的，Pod创建和容器加载等
     1. kube-proxy：即Service
        - 定义服务访问入口地址：IP+Port
        - Service与后端Pod副本集群通过组(Label Selector)实现连接
        - Service的type=NodePort改为type=LoadBalancer，Kubernetes就会自动创建一个对应的Load Balancer实例并返回它的IP地址供外部客户端使用
     1. Pod
        - cAdvisor：监控资源
        - container：容器
1. 功能
   - Pods：容器组，一个pod具有一个ip，该ip在其容器间共享
   - Label：标签，用于过滤系统中相似资源的方式
   - Annotation：注解，用于以自由的字符串形式保存不同对象的元数据
   - Service Discovery：服务发现
     1. 所有Pod使用自定义的 DNS 服务器
   - ReplicaSet：副本集
     1. 自动伸缩
   - DaemonSet：守护进程集
     1. 代理需要运行在所有节点上
   - StatefulSet：有状态集
   - Job：任务
   - Ingress：路由
   - ConfigMap：配置映射，实际是环境变量键值列表
   - Secret：机密配置，类似ConfigMap，只是会进行加密
   - Deployment：部署
     1. 替换
     1. 滚动升级
   - Storage：存储
1. 容器网络模式
   - 认识
     1.  
   - 分类
     1. 隧道封包模式: VxLan/IPIP/GRE,通过tunnel隧道封包建立overlay 网络，实现Pod到Pod的通信
     1. 路由模式：通过映射目标容器网段和主机IP的关系，Pod 之间的通信数据包通过路由表转发到相应节点上
   - service实现：Service主要解决的是Pod IP 短生命周期带来的问题，Service clutserIP 就是 node side Loadbalancer
     1. iptables
     1. IPVS
     1. BPF
   - 大型容器网络
     1. 最经典的方式是用 VxLAN 方式构建大型 overlay 网络，从 Google 到阿里云底层皆使用 VxLAN 方式构建数据中心网络，使用MAC in UDP的方法进行封装，对端进行解封
     1. BGP Router 模式
1. wiki
   - 用8代替8个字符“ubernete”而成的缩写
   - 前端发布：k8s + skaffold + kaniko + gitops
   - 使用etcd作为数据库
   - ingress相当于7层负载均衡器，工作原理类似nginx
   - service为了访问pod方便，kube-proxy是service的一部分，有四种类型，可以实现接受外边的访问
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
     1. openstack本身不提供虚拟化功能只是管理平台，虚拟化能力由底层的hypervisor（如KVM、Qemu、Xen等）提供，为了方便使用。如果没有openstack，一样可以通过virsh、virt-manager的命令行来实现创建虚拟机的操作
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
   - cloudstack
   - virsh/virt-manager
   - saltstack
     1. 认识：服务器管理平台，具备配置管理、远程执行、监控等功能，用salt命令控制多台机器，基于python实现，用python函数执行。可以批量执行命令
        - 自动化运维利器，提高工作效率、规范业务配置与操作，替换了早期运维人员写特定脚本完成大量重复性工作
        - 使用yaml脚本编写部署规范
        - 适合大规模集群部署
     1. 结构：cs架构，master中心控制，minion被管理客户端
   - ansible
     1. 认识：python开发的开源远程部署工具
        - 轻量级无客户端，使用ssh连接管理系统，不占用机器资源
        - 敏捷容易上手，适合中小型
        - 模块化配置
     1. 使用：playbooks，配置部署编排的规范，语法简单，yml格式
     1. 模块
        - file文件和目录以及权限的操作
        - copy文件传送模块
        - stat远程文件状态信息
        - debug打印语句
        - command/shell执行目标主机命令行
        - template模板传送
        - packaging调用目标主机系统包管理工具yum/apt
        - service系统服务
     1. 实践
        - 确保ansible隔离的独立环境运行，使用virtualenv启动隔离环境实例，实现第三方的包的隔离使用
   - chef
     1. 认识：ruby编写，cs架构，使用recipe脚本编写部署规范
### 微服务
1. 认识
   - 要有服务发现、流量路由调度、负载均衡、请求降级、熔断、mock支持、请求跟踪、监控统计等特性
   - 原有的nginx：vip形式的网关链路上增加了2跳，带来了成本，如生产环境多个机房，或同机房内部有全流量环境、小流量环境等多套，就会有多的路由策略和动态路由切换需求，就需要探索服务层面是否可以有一种对效率和扩展性更好的平衡方式
   - 基于智能客户端：和远程Proxy不同，客户端和服务端直接通信，中间不经过任何节点，性能提升、增强稳定性
服务框架需要支持完善的流量调度和容错设计，同时需要支持常见的服务治理策略，对技术的要求相对较高，对于中小公司来说，开发或维护一款完善的服务框架的开销都是不小的。治理成本高
   - Sidecar：本地部署，端口号访问，本地网络损耗小，挂了影响不大，具有感知本地部署环境的能力，如机房级动态路由调整。需要有一套完善的运维工具体系支撑，很少有公司具备这样的技术实力，因此这种模式在一些中大型互联网公司中得到采用，如Netfilx、Airbnb等
1. 价值
   - 规模大、复杂、大型
   - 业务复杂度高（子模块多）
   - 需要长期演进
1. Service Mesh
   - 认识：服务网格，云原生时代下的微服务架构，解决微服务的通信治理问题，屏蔽了复杂的微服务通信，接入对业务无侵入，直接接管tcp和rpc
1. 组成
   - 服务注册：服务提供方将自己调用地址注册到服务注册中心，心跳包。自注册模式和第三方注册模式
   - 服务发现：找到自己需要调用的服务的地址。从配置中的ip端口变为集中管理的机制，这样可以解耦服务提供方的地址
     1. 客户端发现：客户端与服务注册中心耦合在一起，强要求客户端支持服务发现，但可定制
     1. 服务端发现：中间加一层代理做中心，nginx可做负载均衡器
   - 负载均衡：服务提供方一般以多实例的形式提供服务
   - 服务网关：服务网关是服务调用的唯一入口，可以在这个组件实现用户鉴权、动态路由、灰度发布、A/B 测试、负载限流等功能
   - 分布式事务
   - 配置中心：本地化的配置信息（properties, xml, yaml 等）注册到配置中心
   - 集成框架：集成框架以配置的形式将所有微服务组件集成到统一的界面框架下
   - 调用链：记录完成一个业务逻辑时调用到的微服务，便于排错
   - API管理：以方便的形式编写及更新API文档
   - 支撑平台：系统微服务化后，系统变得更加碎片化，系统的部署、运维、监控等都比单体架构更加复杂，那么，就需要将大部分的工作自动化，如持续集成、蓝绿发布、健康检查、性能健康等
1. 结构
   - 服务发布和引用常用的三种方式：RESTful API、XML配置、IDL文件
     1. IDL：接口描述文件，如thrift框架、gRPC
   - 服务注册发现：zk、etcd、
1. 服务注册发现
   - 注册中心
     1. 服务注册、注销
     1. 心跳、健康检测
     1. 服务状态变更通知
     1. 白名单、权限校验
1. 发展历史
   - 第一代：集中代理方式，如nginx、lvs，需要引入dns进行配合
     1. 需要运维手动配置灵活性不高、配置效率低
     1. 多一跳开销、单点失败问题
   - 第二代：客户端嵌入式代理方式，需要独立服务注册中心配合(注册、保活)，然后发现服务实例ip列表来实现，主流，如eureka+ribbon(spring cloud封装这俩)、dubbo、nacos、consul
     1. 灵活开发可自助，但语言栈依赖：不同语言栈不同的客户端，同时引入复杂性
     1. 没有单点、性能好
   - 第三代：主机独立进程代理方式，独立进程部署在每个主机上，主机上消费者共享代理来实现发现和均衡，需要服务注册中心配合
     1. 即service mesh，如envoy、linkerd，istio作服务注册中心，还有流量治理、监控安全等功能
     1. k8s内置这个方案，nacos、consul也支持这种sidecar模式
     1. 性能好、语言栈无关，引入门槛高、运维部署复杂
1. 应用
   - Istio：就是gateway，istio像nginx作外部网关，envoy作为服务层的sidecar，可以识别内部调用走内部mesh集群调用
   - Envoy
     1. 认识：C++编写的云原生高性能边缘代理、中间代理和服务代理，在服务层上边，作为专门为微服务架构设计的通信总线，定位是作为Service Mesh的数据平面，接管微服务通信的全部流量，对应用程序屏蔽网络和通信的复杂性
        - 内置一个HTTP Server，作为Envoy的管理平面，会注册一系列Handler，对外暴露管理平面的API，用于外界查询当前Envoy各个维度的状态，比如外界可以通过管理平面API查询Envoy当前的集群和路由配置、当前的统计信息等
        - Envoy对Service Mesh的一大贡献是第一个提出了通用数据平面API的概念，通过通用数据平面API，建立了数据平面和控制平面之间交互的标准，实现了数据平面和控制平面通信的标准化。只要基于数据平面API实现，可以根据需要方便的对数据平面或控制平面进行替换，有利于Service Mesh生态体系的建设
        - Nginx的关键词是web服务器和反向代理，Envoy是透明接管流量，更加体现对流量的控制和掌控力，而且调用时不需感知其存在
     1. 组成
        - 数据平面，对流量路由和转发相关的策略和配置进行管理
        - 控制平面
        - 管理平面
1. 实例
   - 使用Spring Cloud提供的 服务注册(Eureka)、服务发现(Ribbon)、服务网关(Zuul)三个组件即可以快速入门
     1. 步骤
        - 现有技术体系开发单一职责微服务————注册中心、服务发现、负载均衡
        - 服务提供方将地址信息注册到注册中心，调用方将服务地址从注册中心拉下来
        - 通过服务网关将微服务API暴露给门户或移动APP————服务网关
        - 将管理端模块集成到统一的操作界面上————管理端集成框架
     1. 技术点
        - 负载均衡：实现服务注册和转发功能
        - 服务网关：反向代理、权限认证、数据剪裁、数据聚合
        - 管理端框架
### 云原生
1. 认识：云原生技术有利于各组织在公有云、私有云和混合云等新型动态环境中构建和运行可弹性扩展的应用。云原生的代表技术包括容器、服务网格、微服务、不可变基础设施和声明式API。这些技术能够构建容错性好、易于管理和便于观察的松耦合系统。结合可靠的自动化手段，云原生技术使工程师能够轻松地对系统做出频繁和可预测的重大变更
   - 就是之前是服务器改为云部署，本质没变，“原生”的意义在于享受云带来的一系列便利性，改革技术栈、工具链、交付体系，如service mesh
1. 容器：云原生的代表技术，是被隔离和限制资源的进程
   - 镜像
   - 命名空间
   - cgroup：限制资源的使用，硬件资源切割为多份
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
1. DevOps
   - CICD
     1. 持续集成：将各个开发人员的工作集合到一个代码仓库中
     1. 持续交付：将构建部署的每个步骤自动化
     1. 持续部署：代码如何改变都会自动进行构建/部署