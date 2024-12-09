### 心得
1. php从5.6升级到7性能可以有两倍甚至三倍的提升，越是复杂的接口倍数越高(即redis查询、mysql查询、逻辑处理等)
### 易错点
1. 因为PHP代码问题出了个事故。因为ob_start()的使用引起的。在他们合并php文件的时候，在 <?php 前面增加了一个换行符，然后 这些换行符或空格仍然会皮捕获到输出缓冲中，最终在脚本结束或调用 ob end flush()时输出； 业务调用他们接口的时候，没有进行trim，造成反序列化失败。
   - php输出机制：会将<?php中间的内容作为代码执行，之外的、之前的包括空白符、换行符都会输出到输出缓冲区，最终发给客户端。跟ob_start()没啥关系，都会输出
   - 解决方法
     1. ob_start()后立即调用ob_clean()，屏蔽错误
     1. 业务代码在序列化之前进行trim()处理
1. 因为composer的依赖安装错误出了个事故
   - 原因
     1. 因为一没有提交composer.lock文件
     1. 二上线打包composer install时因为repositories配置中私有库被视为规范库，所以没有去公有库中安装更新的版本，导致打包安装了低版本的库导致找不到php文件，整个服务全部不可用
   - 解决
     1. 将composer.lock提交到版本库中
     1. 配置私有库为非规范库，允许去其他库拉取更高版本的库
        ```conf
        "repositories": {
            "counter": {
                "type": "composer",
                "url": "https://douyu-devops-composer.pkg.coding.net/arch/counter",
                "canonical": false,                                                     // 设置为非规范库，没有only选项也可以解决
                "only": ["arch/counter"],                                               // 设置只拉取的库，感觉比canonical方案更加靠谱
            }
        }
        ```