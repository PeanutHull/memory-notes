### git
1. 认识：git，开源分布式版本控制系统
   - git xxx --help
1. 基础知识
   - 组成
     1. 文件的三种状态：1.没有暂存 2.已暂存 3.已提交
     1. 三棵树：工作目录、暂存区、HEAD
   - 组成平台
     1. github,基于git的代码托管平台
     1. gitlab,基于git的项目管理软件
     1. bitbucket，代码托管网站
### 修改
#### init
1. git init：初始化项目，--bare 初始化项目为远程
#### fetch
1. 认识：获取
1. git fetch       创建并更新所有远程分支的本地的远程分支
1. git fetch -p    获取最新数据(如最新分支数据)和清除旧数据
#### pull
1. git pull               git fetch + git merge
1. git fetch              拉取最新代码，但不合并
1. git merge              合并
1. git pull --rebase      变更基线拉取：拉取最新更改fetch后，把你本地的更改（即本地尚未推送的提交）重新应用`rebase`在这些远程更改之上。会改历史，将本地的提交放到远程提交的顶部，就好像这些本地提交是在远程提交之后进行的一样
   - 更改本地的提交历史以创建一个线性的历史记录，这样做的目的是为了避免不必要的合并提交，并保持项目历史的清晰
   - 通常用于个人开发分支，以保持历史记录的整洁性
1. git pull --ff          快进拉取：会尝试快进合并，如果当前分支可以直接快进到最新的话就快进，不会创建新的合并而提交，否则就会pull失败。通常应用在本地更改与远程更改不冲突的情况下。--no-ff会创建一个新的合并提交
   - 更多地用于公共或共享分支，其中快进合并是首选的更新方式

#### add
1. git add -p     追加文件的部分变更，细化提交
1. 最佳实践
   - git add < filename >：不用撤销add，直接再add一次就可以覆盖
#### commit
1. git reset --hard HASH      push之前删除错误的commit用，不会删除commit
1. git commit --amend         修改commit的内容，必须在push之前，可以在错误的commit之后，再add一次，然后commit --amend可以追加你的修改到commit
1. git log                               查看commit日志
#### checkout
1. git checkout < filename >         用HEAD最新内容替换工作目录文件，暂存区不变
1. git checkout < branch_name >/HASH < filename >   从其他分支或者提交中恢复文件

1. git checkout < branch_name >            切分支/新建分支，不切换

1. git checkout -t origin/feature/xxx      跟踪远程分支，相当于找远程的有没有

1. git checkout -f < branch_name >         强制抛弃本地修改，代码以切换后分支为准

1. git checkout -b < branch_name >   创建并切换
1. git checkout -b < local_branch_name > origin/< branch_name >    本地分支指向远程
1. git checkout -b < new_branch > < branch_name >    基于branch创建新的new_branch
1. git checkout -B < branch >        强制切换
#### reset
1. 改变暂存区，本质是重置HEAD，指定版本库覆盖暂存区
1. git reset HEAD < file >    暂存区恢复到工作区(默认最后版本HASH)
1. git reset HASH                恢复到指定的提交版本,该HASH之后的版本提交恢复到工作区
1. git reset --soft HASH      返回到某个节点，保留工作区，或者-soft。意义为把之前N次的提交作为一次提交
1. git reset file                      从暂存区中移除
1. git reset --hard HASH      返回到某个节点，不保留工作区，即HASH之后的提交全部抛弃
1. git refolg show master     显示版本记录————重新重置，如果发现错误重置，HEAD指向了重置的$id，该版本之后的提交都不见了(git log找不到)时使用

#### merge
1. 认识：commit history会多出来一条merge记录
   - merge：会将不同人的commit合并到一起，而rebase类似嫁接，把分开的commit记录拉直，把本地的commit丢掉，git gc后会删除
1. git merge < branch_name >        将此分支合并到当前分支
1. git merge origin/master --no-ff     不要fast-forward合并，可生成merge提交
1. git merge --no-ff ff合并会显示成一条直线，这样做会强迫git保留分支历史，可以展示合并分支树
   - —ff：fast-forward 快进，不会创建新的提交，直接合并提交
   - --no-ff：会创建新的merging commit，产生了父子提交，可保留分支历史
#### rebase
1. 认识：嫁接、变基，会基于两个分支共同基座之后修改的部分和自己分支的修改进行冲突合并，然后修改commit history，禁止使用，看不清谁合并了谁
   - 多人开发下嫁接，merge会产生交叉的合并记录，而rebase只保留一条线
   - 变基与合并的重大区别：git不会尝试确定要保留或不保留哪些文件。执行rebase的分支总是含有我们想要保留的最新近的修改！这样不会遇到任何合并冲突，而且可以保留一个漂亮的、线性的Git历史记录
   - rebase在为复制的提交创建新的hash时会修改项目的历史记录，会导致混淆
   - 如果你在开发一个feature分支并且master分支已经更新过，那么变基就很好用。你可以在你的分支上获取所有更新，这能防止未来出现合并冲突
1. 风险：本地分支中的对象被提交到远程后，不能对此分支进行rebase，因为你rebase过程中抛弃了现存的提交对象而创造了一些类似但不同的新的提交对象，其他人在你之前的提交对象开发的话就需要重新合并代码。你的rebase会对其他人造成困惑
1. 多人rebase流程
   - git fetch origin branch
   - git rebase origin branch
   - git push：即先用远程的commit history纠正本地的history，才不会出错
1. 命令
   - git rebase --continue      继续合并过程，用于解决完冲突后
   - git rebase --abort         退出rebase过程，并将代码恢复到rebase之前的状态
1. 交互式变基：Interactive Rebase，支持6个操作，可以对commit进行操作，如丢弃drop等
   - reword：修改提交信息
   - edit：修改此提交
   - squash：将提交融合到前一个提交中
   - fixup：将提交融合到前一个提交中，不保留该提交的日志消息
   - exec：在每个提交上运行我们想要 rebase 的命令
   - drop：移除该提交
#### cherry-pick
1. 认识：拣选，当另一个分支包含我们需要的某个提交时，对那个提交执行cherry-pick时，会创建一个新的提交，其中包含了由拣选出来的提交所引入的修改
   - 一个分支上的修改另一个分支也需要时，不能单纯的去另一个分支改，merge会产生冲突
   - 会产生新的hash，但是git知道这个新hash和旧hash是相同的，不会出问题。在以后merge时不会认为同样的文件，不同人修改是冲突的
1. 步骤
    ```s
    # 切到缺hash的分支上
    git cherry-pick hash
    git log        // 查看结果
    git push XXX
    ```
#### revert
1. 认识：撤销某次提交，修改HEAD继续往前，产生新的commit，但是会撤销特定的提交(某次提交的代码)，同时不会修改分支的历史，就很好用
1. git revert < HASH >
1. git revert HEAD
1. 理解：reset是把HEAD向后移动。revert继续往前，不会改变项目历史
#### push
1. git push     推送所有分支
1. git push origin < branch_name >       单分支推送
1. git push -u origin < branch_name >    单分支推送、没有则创建
1. git push -f < branch_name >           强制推送，但是不能再多人工作的目录进行
#### rm
1. rm < file >   工作区删除
1. git rm < file >    工作区删除，该删除操作提交到暂存区，告诉git我删除了一个文件
1. git rm --cached < file >  会从暂存区删除，同时不再跟踪其变更

### 功能
#### tag
1. 查看
 ```
 git tag    ||    git tag -l                查看标签列表
 ```
1. 打标签
 ```
 git tag <tagname> <hash>                   打标签
 git tag -a <tagname> -m '附注' <hash>       打带附注的标签
 ```
1. 发布
 ```
 git push origin <tagname>                  远端提交tag
 git push origin –tags                      远端提交所有tag
 ```
1. 删除
 ```
 git tag -d <tagname>                       删除本地指定tag
 git push origin :refs/tags/<tagname>       删除远程tag
 ```
1. 切换到
 ```
 git checkout <tagname>
 ```
1. 打印信息
 ```
 git show <tagname>
 git show <hash>
 ```
#### stash
1. 认识：暂存，当前分支已经操作，修改尚不能提交，需要新分支去解决问题。这时就可以去其他分支操作了
1. git stash         工作区修改暂存git栈中
1. git stash list    查看所有暂存
1. git stash apply < stash_id >    恢复，不传则恢复栈顶，不删除暂存
1. git stash drop <stash_id>       删除暂存
1. git stash pop     栈顶恢复，并删除
1. git stash clear   清空暂存
1. git stash -p/--keep-index   只备份没有add的文件，1.add不想备份的文件2.-p备份3.reset取消已经add的文件的备份
#### submodule
1. 认识：支持子模块的需求，可将多个独立仓库包含到同一个主工程中
   - 通过子模块既可以各自独立的修改和提交代码，又可以将改动作用到依赖它的父工程
   - 主工程并不直接跟踪子模块的代码，而仅仅只跟踪子模块的commit id的改动
   - 支持嵌套添加子模块
1. 使用
   - 添加
    ```sh
    // .gitmodules文件
    [submodule "cmd/Open-IM-SDK-Core"]
        path = cmd/Open-IM-SDK-Core
        url = git@xxxx:Mind/Service/IM/Mind-IM-SDK-Core.git
    ```
   - 拉取
     1. `git clone <repository> --recursive`：递归的方式克隆整个项目
     1. `git submodule add <repository> <path>`：添加子模块
     1. `git submodule init`：初始化子模块
     1. `git submodule update --remote`：更新子模块
     1. `git submodule foreach git pull`：拉取所有子模块
   - 删除
     1. rm -rf 子模块目录 删除子模块目录及源码
     1. vi .gitmodules 删除项目目录下.gitmodules文件中子模块相关条目
     1. vi .git/config 删除配置项中子模块相关条目
     1. rm .git/module/* 删除模块下的子模块目录，每个子模块对应一个目录，注意只删除对应的子模块目录即可
     1. git rm --cached 子模块名称
1. 最佳实践
    ```sh
    // 子模块, 初始化
    git submodule deinit -f cmd/Open-IM-SDK-Core
    git submodule init
    // 更新子模块代码为远程最新代码
    git submodule update --remote

    rm -rf .git/modules/cmd/Open-IM-SDK-Core/modules/internal/sdk_advanced_function
    ```

### 查看
#### status
1. git status -sb
#### show
1. git show branchName:firename     查看其它分支的文件
#### diff
1. git diff < file >     工作区和暂存区的差异
1. git diff --cached              暂存区和版本库的差异
1. git diff --cached              add之后查看差异
1. git diff -w                    忽略空白变更
1. git diff HASH HASH             两次提交的差异
1. git diff < branch1 > < branch2 >     两个分支的比较
1. git diff < branch > < filename >     不同分支某文件的比较
#### log
1. git log 查看有哪些commit
1. git log -n 1 仅查看最后一次的提交
1. git log -n 1 --stat 查看最近一次提交更改过的文件
1. git log -p  查看pull之后和之前的代码差异
1. git -log -p < filename >    查看某文件每次修改的信息，之后可以用less检索命令：/检索词
1. git log --oneline --graph   显示分支合并的历史
#### branch
1. git branch          查看本地分支和所在分支
1. git branch -r       查看远程分支
1. git branch -a       查看所有分支，远程分支为红色

1. git branch < branch_name >        新建分支

1. git branch -d < branch_name >     删除本地分支
1. git push origin --delete < branch_name >     删除远程分支
1. git branch -D < branch_name >     强制删除分支(未合并分支需要强制删除)
1. git push origin < branch_name >   删除远程分支(先删除本地分支)，原理是push空的到本分支上

1. git branch --merge           查看已经合并到当前分支的分支
1. git branch --no--merge       查看没有合并到当前分支的分支

1. git branch -m < old_name > < new_name >    重命名
#### bisect
1. 认识：定位故障版本
1. git bisect 使用分治算法查找出错版本号，一个个的版本让你试，没问题就敲git bisect good
#### gc
1. 认识：压缩git，垃圾回收
#### remote
1. 认识：远程操作
1. git remote -v     查看远程服务器地址和仓库名称
1. git remote show origin   查看仓库状态

### 运维
#### 使用
1. 建立ssh连接，省略每次输密码
1. 修改clone时的端口
   - 临时方法：`git remote set-url origin ssh://git@domain.com:3022/~/Projects/p1.git`
   - 配置文件方法
        ```c
        // 修改xx.git项目下的git配置文件，不论linux和window都在用户的ssh文件夹下添加配置文件
        cat>~/.ssh/config
        // 映射一个别名
        host newdomain
        hostname domain.com
        port 3022
        ```
#### linux安装git
1. yum已经安装的，卸载
1. 安装依赖包：`yum install curl-devel expat-devel gettext-devel openssl-devel zlib-devel gcc perl-ExtUtils-MakeMaker`
1. 下载源码并解压缩
    ```
    wget https://www.kernel.org/pub/software/scm/git/git-2.8.0.tar.gz
    unzip v2.3.0.zip
    tar zxvf file
    cd git-2.3.0
    ```
1. 编译安装
    ```
    ./configure
    make
    make install
    // 指定路径安装
    make prefix=/usr/local/git all
    sudo make prefix=/usr/local/git install
    ```
1. 检查安装位置
    ```
    whereis git
    ```
1. 添加环境变量
    ```
    vim /etc/profile
    // 文件最后一行添加
    PATH=/usr/local/git/bin:$PATH
    应用修改
    source /etc/profile
    ```
### 最佳实践
1. pull
   - pull等于fetch + merge
1. merge
   - 如果想merge，先到被merge分支把代码pull到最新，再到另一分支执行merge方法，不能在当前分支去pull另一分支，这样会导致另一分支merge进当前分支，不推荐这么做。假如当前机器没有新建的分支，就用git pull先更新分支信息，再切换。
   - merge步骤：merge————解决冲突————git add < filename >————git commit --no-ff————合并完成
   - 要使用merge --no-ff
#### config
1. 配置级别
   - --system 系统级
   - --global 用户全局
   - --local 单独一个项目
1. 别名：git config --global alias.c 'commit -m'
    ```conf
    alias.ll=pull
    alias.s=status
    alias.d=diff
    alias.a=add -A
    alias.cm=commit -m
    alias.po=push origin
    alias.ch=checkout
    alias.br=branch
    alias.rs=restore --staged
    ```
1. 列举所有配置：git config -l
1. 编辑：git config --global --edit
1. 代理设置方法
   - git config --global https.proxy 'socks5://127.0.0.1:1080'
   - git config --global --unset https.proxy
#### git-flow
1. 概念：利用git实现不同操作的隔离，这种活动模型为git-flow
1. 分支：主分支、辅助分支
   - 主分支：组织与软件开发、部署活动
     1. master： 存放随时可部署的代码，不同版本最好加上标签(TAG)
     1. develop：存放最新开发成果的分支，测试之后放到master上
   - 辅助分支：解决特定问题，新功能的并行开发、辅助版本发布工作、对生产代码修复
     1. feature：从develope中派生。新功能
     1. release：从develope派生。
        - 辅助版本发布，做小缺陷修正，准备版本发布的各项信息。
        - 当develope包含目前发布功能后，可以准备release分支，以便develope为下一功能服务
     1. hotfix：从master派生。修正代码缺陷。计划外的，不会打断进行的develope工作
1. 流程
   - 线上修复bug拉hotfix：master拉hotfix分支——修改代码——合到release分支——合到master分支
### wiki
#### DevOps、CI/CD
1. 认识
   - 持续集成：CI，将各个开发人员的工作集合到一个代码仓库中
   - 持续交付：CD，将构建部署的每个步骤自动化
   - 持续部署：代码如何改变都会自动进行构建/部署
1. Jenkins
   - 认识：开源的自动化测试、持续集成工具
     1. pipeline as code，构建code工作流，包含阶段、节点、步骤
   - 操作
     1. 插件管理
     1. 配置
        - 添加用户、权限控制
     1. 任务：创建jenkins自动化部署任务：使用groovy或者shell脚本
   - 启动：java jenkins.war
1. 实例
   - 微服务的腾讯云k8s发布脚本
    ```sh
    #子模块, 初始化
    git submodule deinit -f cmd/Open-IM-SDK-Core
    git submodule init
    #更新子模块代码为远程最新代码
    git submodule update --remote
    #拉取sdk-core的子模块
    cd cmd/Open-IM-SDK-Core
    git reset --hard origin/$branchType
    cd ../../
    cd ./script;./build_jenkins_all_service.sh

    echo "code build success"

    cd ../deploy_k8s

    for s in ${serverName//|/ }
    do
    mv ../bin/open_im_${s} ./${s}/
    done

    echo "move success"

    echo "start to build images"

    curDate=`date '+%Y%m%d'`
    curTime=`date '+%Y-%m-%d %H:%M:%S'`
    REV=$BUILD_NUMBER
    TENCENT_REPO_MIND_PRE=ccr.ccs.tencentyun.com/mind_release/

    kubectl config use-context cls-ewr0i52r-100023200878-context-default

    for s in ${serverName//|/ }
    do
        echo "start to build images" $s
        cd $s
        pod=${s/_/-}
        image="${TENCENT_REPO_MIND_PRE}""$pod"":""$curDate-$BUILD_NUMBER"
        docker build --no-cache -f ./${s}.Dockerfile . -t "$image"
        echo "build ${dockerfile} success"
        docker push $image
        echo "push ${image} success"
        
        kubectl set image deployments/"mind-im-"$pod"-server" "mind-im-"$pod"-server"="$image"
        
        cd ..    
    done  

    echo "Build Successfull"
    ```
#### 搭建gitlab
1. 步骤
   - bitnami.com，没试过
   - 教程地址：http://www.gitlab.cc/downloads/#centos6
     1. 系统防火墙里面开放HTTP和SSH端口
        ```
        sudo yum install curl openssh-server openssh-clients postfix cronie
        sudo service postfix start
        sudo chkconfig postfix on
        sudo lokkit -s http -s ssh
        ```
    1. 下载安装包并安装
        ```c
        // 一般需要添加清华的镜像源
        安装地址：https://mirror.tuna.tsinghua.edu.cn/help/gitlab-ce/
            1.新建: /etc/yum.repos.d/gitlab-ce.repo
            2.内容为:
                [gitlab-ce]
                name=gitlab-ce
                baseurl=http://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el7
                repo_gpgcheck=0
                gpgcheck=0
                enabled=1
                gpgkey=https://packages.gitlab.com/gpg.key
            3.执行:
                sudo yum makecache
                sudo yum install gitlab-ce 
        // 命令管道安装方式
        curl -sS http://packages.gitlab.cc/install/gitlab-ce/script.rpm.sh | sudo bash
        sudo yum install gitlab-ce
        // 下载安装脚本或者手动下载安装包(ROM/Deb)
        curl -LJO https://mirrors.tuna.tsinghua.edu.cn/gitlab-ce/yum/el6/gitlab-ce-XXX.rpm
        rpm -i gitlab-ce-XXX.rpm
        ```
    1. 配置ip地址
        ```
        vim /etc/gitlab/gitlab.rb
        修改 external_url 'hostname' 为 external_url='真实ip'
        ```
    1. 启动GitLab
        ```
        sudo gitlab-ctl reconfigure
        ```
1. 问题
   - 默认用户名和密码：root 5iveL!fe
   - 查看运行状态：gitlab-ctl status，都是几秒几秒就可以了
   - 提示内存不足不能创建object————shared_buffers————解决：vim /etc/gitlab/gitlab.rb,修改 external_url 'hostname' 为 external_url='真实ip'
   - postfix启动不了：重启/etc/init.d/postfix restart
   - gitlab-http.conf文件地址在/var/opt/gitlab/nginx/conf
   - 修改监听端口：external_url 'hostname' 为 external_url='ip:port'，并重新配置
   - 修改unicorn的端口，占用8080，要改为9090
   - 查看日志：gitlab-ctl --help，然后找tail查看
   - 收不到邮件就设置smtp邮箱
        ```
        vim /etc/gitlab/gitlab.rb
        // 贴上smtp配置信息
        gitlab_rails['smtp_enable'] = true
        gitlab_rails['smtp_address'] = "smtp.163.com"
        // 端口为25，不是465
        gitlab_rails['smtp_port'] = 25
        gitlab_rails['smtp_user_name'] = "xxxxxxx@163.com"
        // 这里的密码是授权码，不是密码
        gitlab_rails['smtp_password'] = "xxxxxxxxx"
        gitlab_rails['smtp_domain'] = "163.com"
        gitlab_rails['smtp_authentication'] = "login"
        // 取消自动使用SSL
        gitlab_rails['smtp_enable_starttls_auto'] = false
        gitlab_rails['smtp_openssl_verify_mode'] = "peer"
        // 网易服务器smtp机器要求身份验证帐号和发信帐号必须一一致，否则拒绝发送
        gitlab_rails['gitlab_email_from'] = "xxxxxxx@163.com"
        user["git_user_email"] = "xxxxxxx@163.com"
        ```
 - 解决图片不显示的问题
        ```
        Omnibus 版 Gitlab
        vim /etc/gitlab/gitlab.rb
        增加：gitlab_rails['gravatar_plain_url'] = 'http://gravatar.duoshuo.com/avatar/%{hash}?s=%{size}&d=identicon'
        gitlab-ctl reconfigure 
        gitlab-rake cache:clear RAILS_ENV=production
        ```
#### SVN
1. 获取：svn checkout address localDir --username 用户名 --password 密码
1. 更新：svn update
2. 信息：svn info
3. 代码回滚：svn revert fileName
4. 查看日志：svn log fileName
5. 忽略目录：svn propedit svn:ignore dirName
5. 添加文件：svn add fileName
6. 提交文件：svn commit fileName1 fileName2 -m ''