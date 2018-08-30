####git操作流程
  - 如果想merge，先到被merge分支把代码pull到最新，再到另一分支执行merge方法，不能在当前分支去pull另一分支，这样会导致另一分支merge进当前分支，不推荐这么做。假如当前机器没有新建的分支，就用git pull先更新分支信息，再切换。
  - merge步骤：merge————解决冲突————git add < filename >————git commit --no-ff————合并完成
  - 要使用merge --no-ff
  - 多人rebase流程：git fetch origin branch————git rebase origin branch————git push。即先用远程的commit history纠正本地的history，才不会出错
  - rebase冲突解决：fetch——rebase——冲突——git add 更新索引——git rebase --continue。随时退出：git rebase --abort

------------
####git组合知识
 - git add < filename >               不用撤销add，直接再add一次就可以覆盖
 - git，开源分布式版本控制系统。
 - github,基于git的代码托管平台
 - gitlab,基于git的项目管理软件
 - bitbucket，代码托管网站
 - 文件的三种状态：1.没有暂存2.已暂存3.已提交
 - 三棵树：工作目录、暂存区、HEAD
 - merge：会将不同人的commit合并到一起，而rebase类似嫁接，把分开的commit记录拉直，把本地的commit丢掉，git gc后会删除
 - rebase：是对commit history的改写。多人开发下嫁接，merge会产生交叉的合并记录，而rebase只保留一条线，用于log树上的更好体现
 - rebase的风险：本地分支中的对象被提交到远程后，不能对此分支进行rebase，因为你rebase过程中抛弃了现存的提交对象而创造了一些类似但不同的新的提交对象，其他人在你之前的提交对象开发的话就需要重新合并代码。你的rebase会对其他人造成困惑
 - git xxx --help

------------
####git init————创建
- git init     初始化项目
- git --bare init    初始化项目为远程

------------
####git config
- git配置的级别：
   1. --system 系统级
   1. --global 用户全局
   1. --local 单独一个项目
- 给git命令起别名：
git config --global alias.c 'commit -m'
- 配置用户：git config --global user.name ''/user.email ''/
- 列举所有配置：git config -l

------------
####git diff————比较差异
- git diff < file >     工作区和暂存区的差异
- git diff --cached              暂存区和版本库的差异
- git diff --cached              add之后查看差异
- git diff -w                    忽略空白变更
- git diff HASH HASH             两次提交的差异
- git diff < branch1 > < branch2 >     两个分支的比较
- git diff < branch > < filename >     不同分支某文件的比较

------------
####git add
- git add -p     追加文件的部分变更，细化提交

------------
####git status
- git status -sb

------------
####rm————删除文件
- rm < file >   工作区删除
- git rm < file >    工作区删除，该删除操作提交到暂存区，告诉git我删除了一个文件
- git rm --cached < file >  会从暂存区删除，同时不再跟踪其变更

------------
####git pull————拉取内容
- git pull                  git fetch + git merge
- git fetch                拉取
- git merge              合并
- git pull --rebase    变更基线特殊用法:迫使git将远程分支的变更同步到本地，然后将尚未推送的提交重新应用到这个最新版本，避免丑陋的合并信息

------------
####git commit
- git reset --hard HASH      push之前删除错误的commit用，不会删除commit
- git commit --amend         修改commit的内容，必须在push之前，可以在错误的commit之后，再add一次，然后commit --amend可以追加你的修改到commit
- git log                               查看commit日志

------------
####git log
- git log 查看有哪些commit
- git log -n 1 仅查看最后一次的提交
- git log -n 1 --stat 查看最近一次提交更改过的文件
- git log -p  查看pull之后和之前的代码差异
- git -log -p < filename >    查看某文件每次修改的信息，之后可以用less检索命令：/检索词
- git log --oneline --graph   显示分支合并的历史

------------
####git push————推送
- git push     推送所有分支
- git push origin < branch_name >       单分支推送
- git push -u origin < branch_name >    单分支推送、没有则创建
- git push -f < branch_name >           强制推送，但是不能再多人工作的目录进行

------------
####git checkout————替换
- git checkout < filename >         用HEAD最新内容替换工作目录文件，暂存区不变
- git checkout < branch_name >/HASH < filename >   从其他分支或者提交中恢复文件

- git checkout < branch_name >            切分支/新建分支，不切换

- git checkout -t origin/feature/xxx      跟踪远程分支，相当于找远程的有没有

- git checkout -f < branch_name >         强制抛弃本地修改，代码以切换后分支为准

1. git checkout -b < branch_name >   创建并切换
1. git checkout -b < local_branch_name > origin/< branch_name >    本地分支指向远程
1. git checkout -b < new_branch > < branch_name >    基于branch创建新的new_branch
1. git checkout -B < branch >        强制切换

------------
####git reset
1. 改变暂存区，本质是重置HEAD，指定版本库覆盖暂存区
- git reset HEAD < file >    暂存区恢复到工作区(默认最后版本HASH)
- git reset HASH                恢复到指定的提交版本,该HASH之后的版本提交恢复到工作区
- git reset --soft HASH      返回到某个节点，保留工作区，或者-soft。意义为把之前N次的提交作为一次提交
- git reset file                      从暂存区中移除
- git reset --hard HASH      返回到某个节点，不保留工作区，即HASH之后的提交全部抛弃
- git refolg show master     显示版本记录————重新重置，如果发现错误重置，HEAD指向了重置的$id，该版本之后的提交都不见了(git log找不到)时使用

------------
####git cherry-pick
1. 应用场景：一个分支上的修改，另一个分支也需要，不能单纯的去另一个分支改，merge会产生冲突，cherry-pick为此而生
1. 摘出一个分支上的某一个commit修改，放到另一个分支上，auth不变，但是会产生新的hash，但是git知道这个新hash和旧hash是相同的，不会出问题。在以后merge时不会认为同样的文件，不同人修改是冲突的
1. 步骤
```
1 切到缺hash的分支上
2 git cherry-pick hash
3 git log        // 查看结果
4 git push XXX
```

------------
####git merge————合并
- git merge < branch_name >        将此分支合并到当前分支
- git merge origin/master --no-ff     不要fast-forward合并，可生成merge提交
- git merge --no-ff 本地两个分支合并，是会显示成一条直线的，强迫git保留分支历史，可以有合并分支树

------------
####git rebase————衍合
- git rebase --continue      继续合并过程
- git rebase --abort           退出rebase过程，并将代码恢复到rebase之前的状态

------------
####git branch————分支
- git branch          查看本地分支和所在分支
- git branch -r       查看远程分支
- git branch -a       查看所有分支，远程分支为红色

- git branch < branch_name >        新建分支

- git branch -d < branch_name >     删除本地分支
- git push origin --delete < branch_name >     删除远程分支
- git branch -D < branch_name >     强制删除分支(未合并分支需要强制删除)
- git push origin < branch_name >   删除远程分支(先删除本地分支)，原理是push空的到本分支上

- git branch --merge           查看已经合并到当前分支的分支
- git branch --no--merge       查看没有合并到当前分支的分支

1. git branch -m < old_name > < new_name >    重命名

------------
####git stash————暂存
- 解释：当前分支已经操作，修改尚不能提交，需要新分支去解决问题。这时就可以去其他分支操作了
- git stash         工作区修改暂存git栈中
- git stash list    查看所有暂存
- git stash apply < stash_id >    恢复，不传则恢复栈顶，不删除暂存
- git stash drop <stash_id>       删除暂存
- git stash pop     栈顶恢复，并删除
- git stash clear   清空暂存
- git stash -p/--keep-index   只备份没有add的文件，1.add不想备份的文件2.-p备份3.reset取消已经add的文件的备份

------------
####git revert————撤销某次提交，恢复到HEAD之前
   - git revert < HASH >
   - git revert HEAD
   - 理解：reset是把HEAD向后移动，revert继续往前

------------
####git show————查看
1. git show branchName:firename     查看其它分支的文件

------------
####git remote————远程操作
- git remote -v     查看远程服务器地址和仓库名称
- git remote show origin   查看仓库状态

------------
####git fetch————获取
- git fetch       创建并更新所有远程分支的本地的远程分支
- git fetch -p    获取最新数据(如最新分支数据)和清除旧数据

------------
####git bisect————定位故障版本
- git bisect 使用分治算法查找出错版本号，一个个的版本让你试，没问题就敲git bisect good

------------
####git gc————压缩git，垃圾回收

------------
####git tag————打标签
 - 查看tag
 ```
 git tag    ||    git tag -l                查看标签列表
 ```
 - 打标签
 ```
 git tag <tagname> <hash>                   打标签
 git tag -a <tagname> -m '附注' <hash>       打带附注的标签
 ```
 - 发布tag
 ```
 git push origin <tagname>                  远端提交tag
 git push origin –tags                      远端提交所有tag
 ```
 - 删除tag
 ```
 git tag -d <tagname>                       删除本地指定tag
 git push origin :refs/tags/<tagname>       删除远程tag
 ```
 - 切换到tag
 ```
 git checkout <tagname>
 ```
 - 打印tag信息
 ```
 git show <tagname>
 git show <hash>
 ```

------------
####建立ssh连接，省略每次输密码
1. 使用https每次需要输入密码，ssh不用
1. windows系统生成
 - 客户端生成公私钥：           $ ssh-keygen -t rsa -C "zhigang.zhao@wecook.cn"
 - 向服务端告诉gitlib你的公钥：   在C盘——用户——Administrator.114-20150302TLJ——.ssh文件文件夹——复制id_rsa.pub——粘贴到浏览器中SSH的公钥中————点击空白处自动生成title。添加成功后, 即可使用git将gitlab上的项目 clone 到本地
1. linux的git使用ssh
 - 步骤
    1. 本地生成秘钥对
 ```
 // SSH秘钥存在账户主目录的~/.ssh中
 // id_dsa/id_rsa为密钥对，有.pub为公钥，另一个为秘钥。
 // 都没有用以下命令创建
 ssh-keygen -t rsa -C "your_email@youremail.com"
 ```
    1. 设置gitlab的公钥，和window的操作一样
    1. 修改remote url为git协议
1. 修改clone时的端口
 - 临时方法：git remote set-url origin ssh://git@domain.com:3022/~/Projects/p1.git
 - 配置文件方法
 ```
 \# 修改xx.git项目下的git配置文件，不论linux和window都在用户的ssh文件夹下添加配置文件
 cat>~/.ssh/config
 \# 映射一个别名
 host newdomain
 hostname domain.com
 port 3022
 ```
####linux安装git
1. yum已经安装的，卸载
1. 安装依赖包
 ```
 yum install curl-devel expat-devel gettext-devel openssl-devel zlib-devel gcc perl-ExtUtils-MakeMaker
 ```
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
1. 检查git版本
 ```
 git --version
 ```
####git-flow
1. 概念：利用git实现不同操作的隔离，这种活动模型为git-flow
1. 分支：主分支、辅助分支
    1. 主分支：组织与软件开发、部署活动
        1. master： 存放随时可部署的代码，不同版本最好加上标签(TAG)
        1. develop：存放最新开发成果的分支，测试之后放到master上
    1. 辅助分支：解决特定问题，新功能的并行开发、辅助版本发布工作、对生产代码修复
        1. feature：从develope中派生。新功能
        1. release：从develope派生。
            - 辅助版本发布，做小缺陷修正，准备版本发布的各项信息。
            - 当develope包含目前发布功能后，可以准备release分支，以便develope为下一功能服务
        1. hotfix：从master派生。修正代码缺陷。计划外的，不会打断进行的develope工作
1. 流程
 - 线上修复bug拉hotfix：master拉hotfix分支——修改代码——合到release分支——合到master分支——合到develop分支

------------
####搭建gitlab
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
 ```
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