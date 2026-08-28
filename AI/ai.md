### 人工智能
1. 认识：Artificial Intelligence 人工智能
1. 机器学习
   - 理解：利用计算机从历史数据中寻找规律，用这些规律决策未来。数据分析是人的驱动，机器学习是机器的驱动。概率论和数据统计
   - 应用方面
     1. NLP：自然语言处理，情感分析、实体识别
     1. 深度学习
     1. 强化学习
   - 算法
     1. 分类1
        - 有监督：数据被打好标签去训练
        - 无监督：聚类算法
        - 半监督
     1. 分类2
        - 分类和回归
        - 聚类
        - 标注
     1. 分类3
        - 生成模型
        - 辨别模型
        
     1. 排名：C4.5
   - 框架
1. 深度学习
   - 认识：用于图像、语音、文本
   - 步骤
     1. 收集数据集
     1. 训练学习：网络结构、逻辑回归、激励函数、损失函数、梯度下降、网络向量化、网络梯度下降、训练过程
     1. 生成模型
     1. 使用模型
   - 神经网络分类
     1. 深度神经网络：DNN
     1. 循环神经网络：RNN
        - 场景：语音识别、机器翻译，生成图像描述
     1. 卷积神经网络：CNN
        - 认识：对图像切割，对每个切割块进行特征检测
        - 场景
          1. 图片分类/检索
          1. 目标定位检测：faster RCNN、SSD、YOLOv5
          1. 目标分割
          1. 人脸识别
        - 实现
          1. LeNeT：98年，第一代CNN，28*28手写字
          1. AlexNet：2012
          1. VGG、GoogleNet、ResNet
     1. 自动编码器
     1. 稀疏编码
     1. 深度信念网络
     1. 限制玻尔兹曼机
   - 库：可以训练模型
     1. Hugging Face Transformers：最流行的自然语言处理（NLP）库之一
     1. tensorflow：google
     1. pytorch：深度学习框架，facebook，caffe伯克利，caffe2慢慢被PyTorch取代
     1. DeepSpeed：Microsoft
     1. MXNet：apache
   - 训练数据集
     1. MNIST
     1. VOC
     1. COCO
     1. ImageNet
1. wiki
   - 术语
     1. ML：机器学习 Machine Learning
     1. DL：深度学习 Deep Learning

     1. NN：神经网络 Neural Network
     1. NLP：自然语言处理 Natural Language Processing

     1. LLM：Large Language Model 大型语言模型
     1. VLM：Vision Language Model 视觉语言模型
     1. AIGC(人工智能生成内容)、UGC、PGC(专业机构，如影视公司、专家等)
     1. AGI：通用人工智能 Artificial General Intelligence，具备像人类一样全面智能的人工智能系统
        - 能够跨领域、跨任务地发挥作用
        - 具备学习、推理、感知、理解等多方面的能力
        - 是人工智能研究的最终目标之一，也是科幻小说和未来研究的一个共同主题
     1. 端到端：是一种建模思想，指的是模型直接学习从输入到输出的整个映射过程，中间不依赖任何人为设计的中间步骤或模块
        - 如文生音频，不经过以下传统TTS流水线，用一个单一的、巨大的神经网络来替代整个流水线
          1. 文本前端：将输入的文本转换成语言学特征（如音素、韵律等）
          1. 声学模型：将语言学特征转换成声学特征（如梅尔频谱）
          1. 声码器：将声学特征转换成最终的音频波形
     1. 具身大模型：embodied，指智能体拥有一个物理身体，并且这个身体能与环境进行实时交互
### LLM
1. LLM
   - 认识：large language model 大语言模型，通过海量数据训练的、能识别人类语言、执行语言类任务、拥有大量参数的模型。![](../images/ai/llm_model.png)
     1. 玩的是文字接龙
     1. 不同于数据库和搜索引擎，LLM能创造性地生成历史上没有出现过的文本内容。
     1. 会有幻觉，会生成无中生有的回复；训练信息更新不及时、逻辑能力差、推理速度慢
     1. GPT：生成型预训练变换模型，是基于深度学习的大语言模型，旨在通过训练模型预测下一个单词或字符的来学习自然语言的统计规律
     1. 用处是理解和生成自然语言和代码、推理
   - 分类
     1. 多模态llm：除了文字能力外，还可以理解和生成图片、语音、视频
        - 额外的图片识别模块，如GPT-4V和LLaVA
        - 原生多模态：GPT-4o和Gemini
     1. ai生成音视频：从随机噪声出发，通过逐步“去噪”，生成一段在时间上连续一致的图像序列（视频）。即ai并不理解视频内容，只是经验推论，而且不是单帧生成，是连续的
   - 组成
     1. token：将文本、音频、视频分解成不可分割的最小单位，大语言模型中基于token进行上下文长度计算
        - 1个token通常对应英文中的约0.75个单词或3-4个字符；中文1个汉字通常为1-2个token，具体取决于分词方式
        - 大模型上下文窗口大小：是指单个请求中可以使用的最大令牌数。此最大令牌数包含输入令牌、输出令牌和推理令牌
          1. DeepSeek Chat：128K
          1. MiniMax-1M
          1. GPT4.1：1M
     1. text embedding：文本嵌入，将文本（单词、句子或段落）转换为高维向量（一组数值），用于表示文本的语义信息。嵌入后的向量可以计算相似度，实现语义检索（而非关键词匹配）。
        - 认识：将文本转换为向量的过程，向量是一个高维空间中的点，表示文本的语义信息
        - 作用：用于计算文本之间的相似度、检索、分类等任务
        - 分类
          1. 通用嵌入模型
             - OpenAI的text-embedding-ada-002（1536维）
             - Hugging Face的BAAI/bge-small-en-v1.5（多语言支持）
          1. 领域专用模型：法律、医疗等
     1. rerank：在初步检索（如基于嵌入的语义搜索）后，对候选结果进行精细化排序，进一步提升Top结果的准确性。通常使用更复杂的模型对“查询-文档”对进行相关性评分。rerank是精修，text embedding是粗筛
     1. MoE：Mixture of Experts Orchestration，混合专家式，模型内部的专家路由机制
        - 每个专家都是一个子模型，专门处理特定类型的输入或任务
   - 实现原理
     1. 模型在大量文本训练过程中，学习到一种空间结构
        ```
        密码重置 ───── 登录问题
            │
            └──────── 账号安全

        水果苹果 ───── 香蕉
            │
            └──────── 食物

        苹果公司 ───── iPhone ───── 科技产品
        ```
     1. 概念
        - 条件概率：在已知一个事件已经发生的情况下，另一个事件发生的概率
        - 温度参数：控制生成文本的随机性，温度越高，生成的文本越随机；温度越低，生成的文本越确定
     1. 训练方式
        - 预训练：让模型阅读海量文本，决定模型的智商上限。
          1. 预训练结束后的模型，并不会聊天，只会补全
        - 后训练：指令微调阶段：instruction tuning
          1. 训练技术
            - SFT：监督微调
            - Preference Training：偏好训练
            - Reasoning：推理强化，近两年最大的变化。模型会学会：分解问题/写中间步骤/检查错误/自我反思等
            - Safety：安全，拒绝敏感话题
         
           - 通过人类反馈强化学习（RLHF）来优化模型的输出质量。如为理解Jinja2模版语法，模型会被显式训练处理结构化指令，从而强化对特定语法的理解
           - 通过人类标注的示例来指导模型生成更符合人类期望的回答
   - wiki
     1. 大模型如何理解Jinja2，加深大模型处理模式的理解
        - 预训练数据的广泛覆盖
          1. 接触过海量的开源代码、技术文档和论坛内容
          1. 模式识别能力：模型通过统计规律学会{}包裹的内容通常表示变量、{%%}和{{}}是Jinja2的控制块和表达式标记
        - 指令微调：微调阶段会被显式训练处理某种特定数据，并由人类反馈
        - 上下文学习：prompt的明确引导
        - 通用文本模式迁移：符号逻辑的泛化能力，将if-else的逻辑从自然语言如果...否则...迁移到 {% if %}
1. 认识
   - 为什么 GPT 其实只是“预测下一个词”，却能表现出像人一样的智能。
     1. 语言本身就包含了“世界知识”：模型学到了概率结构，地球、掉下来、苹果，那么对应的就是引力的概率最高
        - 语言学里常说：语言是世界知识的压缩表示
     1. Transformer 可以理解“上下文关系”：那么表现的就像是推理
     1. 大规模训练带来的“能力涌现”：知识足够多、理解足够深预测的下一句话看起来就像是推理了
        - 模型规模足够大时突然获得以前没有的能力：
        - 压缩数据(参数训练)更高，那么对于规律的把握就更好：模型规模更大时可以压缩更多规律
        - 大模型的智能，本质是把世界规律压缩进参数里
1. 原理
   - 简述
     1. 把文字变成向量
     1. 把向量变成矩阵
     1. 让GPU疯狂做矩阵乘法
     1. 最后预测下一个Token
   - 搁浅
     1. Q、K、V 到底是怎么来的：这是从“知道 Transformer 在干什么”到“真正理解 Attention”的分水岭。理解了 QKV，你基本就能读懂大部分 LLM 架构图了
        ```go
        // 把大模型推理想成
        for {
            hidden := Transformer(tokens)

            next := Predict(hidden)

            tokens = append(tokens, next)

            if next == EOS {
                break
            }
        }

        // Transformer(tokens)内部干的就是：
        Embedding
        ↓
        Attention
        ↓
        矩阵乘法
        ↓
        Attention
        ↓
        矩阵乘法
        ↓
        ...

        // 把Transformer看成
        func Predict(input string) string {

            x := Embedding(input)

            x = Layer1(x)
            x = Layer2(x)
            x = Layer3(x)
            ...
            x = Layer64(x)

            return Decode(x)
        }
        ```
   - 理解：用神经网络表示函数，用损失函数最小化为目标，通过反向传播训练参数
     1. 神经网络：多个输入——(进行线性变换——进行激活函数)得到隐藏层——继续进行线性变换+激活函数——得到输出层。这是前向传播，就是一点点分步骤把函数计算了出来
        - 从而构成非常复杂的非线性函数，从而根据参数猜出结果，找近似解
        - 搞近似就可以了
        - 用套线性变换、套激活函数，各种函数变换
          1. 非线性的激活函数：平方、sin、e
     1. gpu对于矩阵运算可以并行，因为矩阵就是值交替的进行运算，是可以并行计算的
     1. 卷积神经网络CNN：用于图像识别，适用于静态数据，动态的没法处理
        - 卷积运算：卷积核就是一个小的矩阵，用于提取输入数据中的特征。深度学习里卷积核是未知的
     1. 循环神经网络：RNN，词向量，记录顺序
     1. transformer：基于注意力机制的架构，适用于动态数据。加上位置编码后每个词和其他词进行关联，计算权重。是现在大模型的基础
        - 理解
          1. 位置编码：transformer没有RNN的顺序信息，加上了位置编码
          1. 自注意力机制：每个词和其他词进行关联，计算权重
          1. 多头注意力机制：多个注意力头并行计算，捕捉不同的语义关系
          1. 前馈神经网络：每个位置独立处理
          1. 残差连接和层归一化：稳定训练
          1. 编码器-解码器结构：编码器处理输入序列，解码器生成输出序列
        - 步骤
          1. 将输入参数通过词嵌入的方式转换成词向量矩阵
          1. 加入位置信息
          1. 经过过头注意力处理，给每个词向量增加上下文信息。这是重点
        - 组成
          1. 编码器：将输入转换为向量化表示
          1. 解码器：将向量化反推出对应的输出，即利用概率预测下一个
     1. 注意力机制
        - 稀释：注意力是一个归一化的固定预算，不是无限追加的资源。往prompt里塞的每一句强调，都在和其他所有token抢同一份预算。生成每个新token时,当前位置的Query会和上下文里所有token的Key做点积,得到的分数经过softmax变成注意力权重。关键在softmax所有权重加起来恒等于1。上下文1000token时,平均每个token分到千分之一;10万token就是十万分之一。模型只能重新分配这1的机制。这就是"稀释"的数学本质——你加内容不是在增加模型的关注度总量,而是在切碎它。
          1. 全都重要等于全都不重要：一句重要它的Key和Query的匹配分会相对突出，多个重要就互相抹平了对比度
          1. 重复不线性加权：重复三遍同一条规则，这三处的Key向量高度相似，注意力会在三个副本之间分摊，而不是三倍强化
          1. 位置效应：经验上模型对上下文开头和结尾更敏感
          1. 训练分布：模型在训练时见到的指令遵循数据，大多是少量、清晰的指令。上百条互相牵制的规则本身就偏离了它擅长的分布,遵循能力自然下降。
        - 原理
          1. $\mathrm{Attention}(Q,K,V)=\mathrm{softmax}\left(\frac{QK^T}{\sqrt{d_k}}\right)V$
          1. 组成：Q（Query，查询）、K（Key，标签）、V（Value，含义）三个核心组成，来源于提示词tokenizer后的数字，再token embedding变成4096维矩阵，然后进入多层Transformer，每一层都有Attention，Q,K,V来自模型内部权重的隐藏状态经过投影得到
             - Q（Query）：我现在想找什么信息
             - K（Key）：我这里有什么信息，可以被匹配
             - V（Value）：如果匹配成功，我实际提供什么内容
          1. 计算公式：算相似度、归一化概率、加权求和
          1. 多头注意力机制：多套Q,K,V，多次查询Q，即不同角度理解问题，如Head1学习语法、Head2学习指代、Head3学习知识、
          1. 上下文爆炸：要理解当前词和前面所有词的关系，显存爆炸、计算量爆炸、重要信息淹没
        - 对agent开发的实际含义
          1. 做减法比做加法有效。发现模型不守某条规则,第一反应不该是再加一句强调,而是删掉别的、或把冲突/冗余的规则合并
          1. 关键约束放开头或结尾,别埋中间
          1. 与其用形容词强调("非常重要"),不如给一个正反例。示例改变的是 Key/Value 的语义匹配,比空洞的强调词信号强得多
          1. 能用架构解决的别用 prompt 解决:该验证的用代码校验输出,该分工的拆子 agent(每个 agent 上下文短、规则少),该动态的按需注入上下文而不是全量常驻
          1. 长对话中系统提示会被越冲越淡,必要时在临近任务处重申一次关键约束(一次,不是三次)
     1. 混合注意力架构
        - 上下文压缩：短期记忆对应CSA的滑动窗口，中期记忆对应CSA的压缩+筛选，长期记忆对应HCA的重度压缩。类似人记得当前的所有细节，很久之前缩成模糊印象，细节基本忘光，但"大概发生过什么"还是知道的
   - 前缀缓存
     1. LLM的推理两阶段
        - prefill：处理历史上下文，适合缓存
        - decode：生成新token，基本不能缓存
     1. 缓存原理：利用前缀prompt的中间结果kv cache，就可以跳过把所有token从头做完整计算，适合每轮都一样的巨大系统提示词(知识库、Agent SDK等)，
        - kv cache很大，几十M到几G
1. ML工程基础术语
   - 模型生命周期
     1. pretraining：预训练，从零开始训练大模型，成本极高，普通公司一般不会自己做
     1. fine-tuning：微调，用自己的数据继续训练一个已经训练好的大模型
     1. training：让模型学习数据的过程（泛指）
     1. inference：推理，使用训练好的模型生成结果
   - 模型文件格式
     1. ONNX：Open Neural Network Exchange，开放的机器学习模型的标准文件格式
        - 由微软和Facebook于2017年共同创建，旨在促进不同深度学习框架之间的互操作性
        - 支持多种框架，如PyTorch、TensorFlow、MXNet、Caffe2等
     1. ckpt：.checkpoint，完整模型权重文件
     1. safetensors：更安全、更常见于HuggingFace生态
     1. GGUF：GGML Unified Format，llama.cpp生态常用的量化模型格式，适合本地CPU/GPU混合推理
     1. TFLite：TensorFlow Lite格式，面向移动端和边缘设备的轻量推理格式
   - 推理框架 / 运行时
     1. ORT：ONNX Runtime，用于高性能推理（即模型预测）的跨平台引擎，用于加载和运行由ONNX格式定义的机器学习模型
     1. vLLM：高性能llm推理框架
     1. SGLang：llm推理和agent workflow框架，适合高性能结构化推理
     1. llama.cpp：基于GGUF格式的本地推理引擎，支持CPU和GPU混合运行
1. 微调
   - 微调范式
     1. SFT：Supervised Fine-Tuning，监督微调，用标注的输入输出对直接训练模型，是最基础的微调方式
     1. RLHF：Reinforcement Learning from Human Feedback，人类反馈强化学习，让模型输出更符合人类偏好
        - 通常流程：先SFT → 训练reward model → 用PPO优化
     1. PPO：Proximal Policy Optimization，RLHF中常用的强化学习算法
     1. DPO：Direct Preference Optimization，直接偏好优化，RLHF的简化替代方案，不需要单独训练reward model，直接用偏好数据对比训练
   - 微调方式分类
     1. 选择性微调：只更新部分参数，技术有Freeze、BitFit
     1. 加性微调：在模型中增加新的参数、模块，技术有Prompt-Tuning软提示、Adapter插入小型层
     1. 重参数化微调：技术有LoRA
   - PEFT：Parameter-Efficient Fine-Tuning，参数高效微调，不训练全部参数，只训练极少部分参数
     1. LoRA：Low-Rank Adaptation，低秩适配，在原权重旁边训练一个低秩增量矩阵，是PEFT最流行的一种实现
        - 认识：必须拿到原始模型权重，或者公有云模型开放微调，否则无法训练；要依附基础模型
        - 使用：原始矩阵外挂小矩阵，只训练LoRA Adapter，降低几十倍的量
        - 核心假设：权重更新（ΔW）其实具有较低的"内在秩"（Intrinsic Rank）；巨大的参数变化可以用一个更小的矩阵来近似表示
     1. QLoRA：LoRA + 4bit量化，在消费级显卡上微调大模型的主流方案
     1. Adapter Tuning：在transformer层之间插入小型适配器模块，只训练Adapter参数
     1. Prefix-Tuning：在输入前添加可训练的虚拟token前缀，不修改原始模型参数
     1. Prompt-Tuning：软提示，只训练输入层的prompt embedding，是Prefix-Tuning的简化版
   - 模型量化
     1. GPTQ：基于GPU的训练后量化方法，将权重压缩至4bit/8bit，常见于HuggingFace生态
     1. GGUF/llama.cpp量化：面向本地CPU推理的量化方案，支持Q4_K_M等多种精度
1. 开发
   - llama.cpp：用c和c++编写的高性能开源推理框架
   - ROCM：Radeon Open Compute Platform，AMD的主要用于GPU计算的开源软件平台
   - CUDA：NVIDIA的gpu开发框架
   - Vulkan：现代的跨平台的移动端的低开销的高性能图形和计算api，能高效地利用gpu，对比传统的OpenGL，即移动端的CUDA
     1. 主要应用场景是推理(inference)，不是训练
   - TPU：专用于大规模神经网络训练和推理的
   - NPU：终端设备的ai加速芯片
     1. TOPS：每秒万亿次运算，衡量NPU理论峰值算力的主要指标，即引擎的最大马力
1. 本地部署
   - 工具：ollama、LlamaIndex、Haystack
     1. Ollama
        - 认识：离线本地轻松下载、运行和管理大型语言模型。Ollama更友好易用、有一定定制化能力，适用于开发者
        - 特性
          1. 简单的类似docker的命令、丰富的模型库、本地运行保证隐私和安全
          1. 提供OpenAI API格式兼容的API端点，如http://localhost:11434/v1/chat/completions
          1. 可定制化：通过创建Modelfile来定制自己的模型
        - 使用
          1. 命令
             - ollama run deepseek-r1:8b：运行模型
             - ollama pull：下载模型
             - ollama list：查看已安装的模型
             - ollama ps：查看正在运行的模型
             - ollama rm：删除模型
     1. LM Studio：图形化界面，功能不如Ollama，适用于普通用户
     1. text-generation-webui：专业人士使用
   - 最佳实践
     1. 硬件要求：个人电脑运行LLM，一般最大只能运行20B以下的模型
        - 7B参数模型需要至少8GB内存
        - 33B模型需要32G显存
        - 支持CUDA(NVIDIA)、ROCm(AMD)
     1. 比较适合本地运行的是Phi 3 Medium（14B）、LLaMA 3 8B、Mistral 7B
1. wiki
   - llm越狱：安全机制，避免生成不当内容
   - maas：模型即服务 model as a service，提供api接口的llm服务，如Hugging Face
   - 模型厂家
     1. 闭源
        - OpenAI
          1. GPT-4o：2024-05，当前主力
          1. GPT-4 Turbo
          1. GPT-4.5：2025-02
        - Anthropic：美国，前身为BLOOM
          1. Claude 3.5
          1. Claude 3.7 Sonnet：2025-02
        - Google DeepMind
          1. Gemini
        - Mistral AI：法国
          1. Mistral 7B
        - Microsoft
          1. Copilot：背后基于openai的gpt
        - 阿里巴巴
          1. 通义千问 Qwen-Max
        - 字节跳动
          1. 豆包，基于云雀模型
        - 月之暗面 Moonshot AI
          1. kimi k2
        - 智谱AI
          1. 智谱清言 GLM系列、GLM-4
        - 百度
          1. 文心一言
        - 科大讯飞
          1. 讯飞星火
        - 百川智能
          1. 百小应
     1. 开源
        - Meta
          1. LLaMA
          1. Code Llama
        - DeepSeek
          1. R1
          1. V3
          1. V4-flash-0731
             - 存储量：284B
             - 计算量/激活量：13B
        - kimi
          1. k3
             - 存储量：2.8T
             - 计算量：104B
        - Ali
          1. Qwen3.8-Max
             - 存储量：2.4T
             - 计算量：95B
             - 思维链262K
        - 智谱AI
          1. ChatGLM3
        - 01.AI
          1. Yi 系列
        - Mistral AI
          1. Mixtral
        - Microsoft
          1. Phi-2
          1. Phi-3：小型、能力强大
     1. 其他重要历史模型
        - BERT：由Google发布，开创了Transformer的先河，主要用于NLP任务而非对话
        - RoBERTa：BERT的优化版
        - BLOOM：BigScience项目
   - 周边厂家
     1. 硅基流动：专注于llm推理和部署优化，使开源的llm更快、更便宜的部署
   - 概念名词
     1. 函数叫做模型
     1. 模型中的参数叫做权重，参数多就是大模型，用于自然语言处理的就是大语言模型llm
     1. 调整参数就是训练，预训练——微调
     1. 生成结果就是推理，参数足够大时有了质变产生了一定程度的推理能力
     1. GPT是个系列模型
     1. 代码——>形成权重——>形成服务
     1. 闭源模型：不开放源代码和训练数据，不开放权重；开源模型：不开放源代码和训练数据，开放权重
     1. 温度：控制输出的随机性，让下一个词并不总是概率最高的。太高胡说八道，太低可能说错
     1. top-k：控制从概率最高的词中选择
     1. 幻觉：语言上说得通，但是事实上错误或虚假。用联网、提供上下文减轻
     1. 词嵌入：把文字转换为词向量的方式
     1. 模型压缩：让模型更小，成本减小；量化：降低浮点数精度；蒸馏：用参数量大的指导参数量小的；剪枝：删除不重要的特性
     1. vLLM：提升推理速度的大模型推理引擎
### 基础知识
1. MCP
   - 认识：Model Context Protocol 模型上下文协议。解决llm与外部工具集成的高定制化问题的协议，提供了一种跨模型、跨平台的统一标准，任何工具或数据源只要实现MCP，就可以被不同ai客户端使用。比openai的function calling更先进
     1. MCP跟Function Calling的逻辑基本一致
        - MCP的能力描述和功能逻辑统一封装在Server端，而Function Calling的能力描述配置在客户端，但是功能逻辑却在API，相对割裂，不容易管理
        - Function Calling的方式是API调用，MCP的协议是JSON-RPC 2.0
            ```json
            // 请求
            {
                "jsonrpc": "2.0",
                "id": 1,
                "method": "tools/call",
                "params": {
                    "name": "search",
                    "arguments": {
                        "query": "MCP protocol"
                    }
                }
            }
            // 响应
            {
                "jsonrpc": "2.0",
                "id": 1,
                "result": {
                    "content": "..."
                }
            }
            ```
     1. 解决三个问题
        - 标准化ai工具调用：提供不同ai应用可以调用同一个MCP server的能力
        - 解耦ai与系统：ai不直接访问数据库/API/文件系统，而是通过mcp
        - 支持agent架构：mcp是ai agent工具层标准
   - 特点
     1. 动态发现工具、即插即用，AI决定是否调用
     1. 一次标准化整合
     1. 实时双向通信
   - 组成
     1. 三种标准能力
        - tools：工具，用于调用函数
            ```json
            {
                "name": "search",
                "description": "Search documents",
                "inputSchema": {
                    "type": "object",
                    "properties": {
                    "query": { "type": "string" }
                    }
                }
            }
            ```
        - resources：资源，提供数据源
            ```c
            docs://api
            db://tables
            files://repo
            ```
        - prompts：提示词，提供prompt，在skill hub/ai工具市场里很常见
            ```
            code_review
            write_tests
            ```
     1. 标准传输协议
        - 标准输入/输出（stdio）：用于本地进程通信，即IPC的一种实现方式
        - 可流式传输的HTTP（Streamable Http）：用于远程通信，主要使用POST方式，按需用SSE。Streamable HTTP不是通用协议，是MCP spec定义的一种传输模式
          1. 返回两种可能
            ```
            HTTP 200
            JSON result

            HTTP 200
            Content-Type: text/event-stream
            ```
        - 服务器推（SSE + POST）：已废弃
          1. 旧版HTTP+SSE transport 想要双向通信得弄两个接口；在生产化和规模化部署上存在一些工程局限，因此后来被 Streamable HTTP 取代
     1. 角色
        - mcp server
          1. server capability：向客户端声明自己支持哪些功能接口
            ```json
            {
                "capabilities": {
                    "tools": {},
                    "resources": {},
                    "prompts": {},
                    "logging": {}
                }
            }
            ```
        - mcp client：处在llm和mcp server的中间，在mcp hosts中，处理与mcp server的通信，查询工具，管理请求/响应/通知
          1. mcp hosts：AI应用环境/载体，可以是agent、IDE
   - 实现
     1. 步骤
        - client发起initial request
        - server返回initial response
          1. 能力交换：详细回复自己的能力，可动态地发现服务器提供的功能，同时客户端无需修改代码或重新部署。server有新特性下次client连接时即可获知
        - client发送notification
     1. 实现细节
        - server
          1. 先通过prompts/resources/tools的描述信息，定义服务的能力
          1. 再通过server.setRequestHandler定义接到客户端请求后，执行怎样的逻辑，响应怎样的数据
          1. 最后把server连接到transport，启动服务在本地监听客户端的RPC请求
        - client
          1. 客户端提供让用户提前把需要用到的MCP Servers填到配置里
          1. 客户端启动时，连接到transport，通过client.getServerCapabilities()获取所有已配置的MCP Servers能力，包括prompts/resources/tools等
          1. 用户在客户端输入问题，客户端把用户提问 + MCP Servers能力描述发送给大模型，做意图识别，大模型返回应该调用哪些服务，应该传哪些参数
          1. 客户端带上MCP Server名称和对应的参数，发起一次RPC请求，获得MCP Server响应的数据
          1. 客户端带上用户提问 + MCP Server响应的数据，请求大模型回答，可以理解为一次RAG（Rpc-call-Augmented Generation）
   - 最佳实践
     1. server更新时，需要保证服务的连贯性、向下兼容性
     1. go非常适合写mcp server，很多AI工具如Claude Code/Cursor/Windsurf的MCP Server90%都是Go写的，而不是Python
        - 单文件部署(即装即用，没有运行时依赖、跨平台发布容易)、内存占用少、go对stdio支持好、并发高
     1. claude code的插件其实就是一个mcp server，使用mcp server是最合适的选择
   - mcp推荐
     1. 网络数据获取
        - firecrawl mcp：网页内容提取，支持js渲染
        - playwright mcp：浏览器自动化，模拟真实用户操作
        - fetch mcp：轻量级http请求，快速获取api数据
     1. 数据处理
        - clickhouse mcp
        - mysql mcp
     1. 内容制作
        - word mcp/excel mcp/powerpoint mcp
        - context7 mcp：代码文档智能管理
     1. 桌面自动化
        - desktop commander mcp：操作电脑系统
        - file system mcp：文件系统
        - browser tools mcp：打开浏览器查数据
   - wiki
     1. MCP Spec：mcp协议的正式规范文档
     1. 历史
        - 2023.6.13：OpenAI宣布在Chat Completion模型中加入函数调用（Function calling）功能，全面开放16K对话长度的模型、降低模型调用资费等，这代表着Chat模型不再需要借助LangChain框架就可以直接在模型内部调用外部工具API
        - MCP：前openai高管、anthropic公司提出
1. Skills
   - 认识：Claude推出的用于提升执行特定任务效果的方式；skills是包含指令、脚本和资源的文件夹，Claude应用可以根据需要加载；如使用excel或操作pdf
     1. 是师傅教会徒弟，形成知识固化、一次教会永久使用
   - 特点
     1. 可组合使用：会自动协调使用
     1. 可移植性：都使用相同的格式，只需构建一次，即可在Claude应用、Claude Code和API中使用。一键复用，秒杀配置
     1. 渐进加载：高效，只会在Skill与当前任务相关时才使用，只会加载所需的最少信息和文件
     1. 透明：没有任何黑盒逻辑
     1. 社区即仓库
   - 设计
     1. 渐进式加载机制：既能保持核心指令的简洁，又能在需要时按需加载深度能力
        - 三层懒加载机制
          1. 元数据层：启动时只加载name和description。500个skills也就50k tokens
          1. 指令层：匹配上后才加载完整SKILL.md，通常2k-5k tokens
          1. 资源层：执行时按需加载scripts(直接执行，不占token)和references(按需读取)
   - 组成
     1. SKILL.md
        ```
        ---
        name: meeting-notes
        description: 整理会议纪要，提取行动项和决策。当用户说"整理会议记录"、"帮我总结会议"、"提取会议要点"时使用。
        ---

        # 会议纪要整理技能

        ## 触发场景
        - "帮我整理一下这个会议记录"
        - "总结一下今天的会议"
        - "把这段对话整理成会议纪要"

        ## 工作流程
        ......
        ```
     1. 标准可选组成
        - scripts：确定性执行，js、python等脚本，完成精确、可靠的任务，弥补大模型在确定性任务上的不足
        - references：按需的知识库，详细信息
        - assets：素材，PPT模板/Logo/图标字体/HTML样板文件等，内容不加载到AI上下文，而是由AI直接引用，作为最终交付物的一部分提供给用户

        - config.json          # 必选：安全性与元数据。定义权限边界（联网、读写）和版本信息
        - requirements.txt     # 可选：Python 依赖定义（若有脚本，推荐包含以实现自动隔离安装）
        - package.json         # 可选：Node.js 依赖定义（替代 requirements.txt）
        - reference.md         # 可选：长文档。存储 API 字典或复杂规范，通过“渐进式披露”节省上下文
        - examples.md          # 可选：少样本学习 (Few-shot)。提供最佳实践案例供 Claude 参考
        - .clauderules         # 可选：局部约束。定义在此 Skill 激活时 Claude 必须遵守的特定行为准则
   - 使用
     1. 创建skill：创建一个包含SKILL.md文件和相关脚本/资源的文件夹
     1. 加载skill：在Claude应用或API请求中指定要加载的skill
        - 安装：`npx skills add https://github.com/op7418/guizang-ppt-skill --skill guizang-ppt-skill`
     1. 执行任务：Claude会根据用户请求，自动调用相关的skill脚本和资源来完成任务
   - 最佳实践
     1. 使用：将skill视为行为编程、能力包，而非文档/知识库，要小而专注，要持续迭代(创建readme、安装指南、变更日志)
        - 四类能力
          1. 专用工作流：多步骤、可复用的任务流程
          1. 工具集成：使用特定文件格式/api/cli等的方法
          1. 领域知识：业务规则、数据口径、组织约定
          1. 捆绑资源：脚本、模板、参考资料、素材
     1. 分层实践
        - 元数据层：始终可见，name、description
          1. name：应该短、动词优先
          1. description：只负责描述何时触发，明确触发条件，有时候skill不起作用就是因为这
        - 正文层：skil触发后，提供核心流程和边界，`SKILL.md`
          1. 应该只保留可执行知识：不要背景长/流程散
          1. 按任务风险设置自由度：脆弱任务写死流程，开放任务只给建议
          1. 信息只放一个地方：规则写多容易迷惑
          1. 适当包含具体示例
        - 资源层：任务需要时，承载细节、脚本、模板
          1. 分离确定性操作：资源要分层
          1. 有可验证的机制：运行检测脚本、验收描述、真实任务测试等
     1. 工程实践
        - 通过结构化设计(yaml+markdown、dot流程图(Graph Description Language 图描述语言)、检查表)和严格的约束机制(门控、合理化防御、说服原则)来规范ai代理的行为
        - 其他llm使用skill有挑战：claude官方对skill的规范描述的比较清晰，但对于llm怎么使用skill并没有详细描述
1. A2A
   - 认识：Agent-to-Agent，解决不同来源不同框架的agent之间高效、安全、互操作的开放的通信协议标准，google推出
     1. MCP解决智能体与工具/数据源的连接，A2A解决智能体之间的协作，二者互补
   - 工作模式
     1. 顺序流水线（Sequential Pipeline）
     1. 管理者-工作者（Manager-Worker）
     1. 民主共识（Democratic Consensus）：投票
     1. 竞争性（Competitive）
1. 理论
   - 对比
    ```
    | 方案                  |  规划位置   | 典型结构                       | 适合场景                    |
    |----------------------|------------|-------------------------------|---------------------------|
    | Plan-Then-Act        |  执行前     | 先生成任务表，再逐项执行          | 目标清楚、步骤可预估的任务     |
    | ReAct                |  执行中     | 先给粗计划，每几步检查一次        | 工业界常见复杂任务            |
    | Tree/Graph Planning  |  搜索空间中  | 同时探索多条路径，评估后选择      | 高不确定、高价值、可回溯任务    |
    ```
   - 规划策略：![](../images/ai/llm-strong-plan.jpg)
     1. CoT
        - 认识：Chain of Thought：链式思维，直接求解容易出错，引导模型一步一步地想，能极大提高其逻辑准确性
     1. Self-Consistency
        - 认识：多次采样，选择最一致的答案
     1. ToT
        - 认识：思维树，让llm进行“多路径推理”的提示策略，提升解决复杂问题的能力。从“链式”思考转变为“树状”探索
     1. ReAct
        - 认识：Reason + Acting，是一个方法论，基于动态推理与工具调用的智能体实现模式，其核心是让llm通过推理和行动的循环来完成任务
          1. 走一步看一步：给了模型在每一步根据上一步结果调整方向的能力
          1. 是通过组件拼装实现的高级任务解决策略和功能模式，和chain、graph区别在于是动态决定下一步
          1. 就是让大模型从一句话中找出来要调用的方法名和参数，然后代码执行即可
          1. 强调推理与行动交替进行
        - 步骤
          1. reasoning：模型自主分析问题，拆解步骤，如需要查询天气api
          1. acting：调用工具执行具体操作，并根据工具返回结果决定下一步动作
          1. 循环迭代：重复“推理-行动”直到任务完成或达到终止条件
        - 特点
          1. 多步推理
          1. 自我修正
          1. 动态决策
          1. 长任务拆解
        - 优点
          1. 适应不确定任务：无需预先固定流程，可根据执行结果动态调整。适合开放式、探索式、多步骤任务，而流程固定、确定性强的业务，预定义workflow更高效、成本更低
          1. 支持复杂工具编排：能串联多个tool、mcp服务或subAgent完成复杂任务
          1. 具备一定容错能力：执行失败后可重新规划，而不是直接终止
          1. 可扩展性强：容易加入memory、RAG、Human-in-the-loop、预算控制等能力
          1. 透明：推理过程以文字形式展现出来，我们可以理解它的“思考过程”，便于调试和信任。
          1. 减少幻觉：通过外部工具获取事实信息，减少模型依赖内部知识、从而“胡编乱造”的可能性
          1. 能力增强：可调用工具
        - 局限
          1. token消耗更高：每轮都需要再次调用llm
          1. 延迟增加
          1. 需要终止机制：通常会设置最大循环次数、超时时间或成本预算，避免陷入无限循环
          1. 依赖Planner能力：随着模型能力提升，这不是问题
        - 流程
          1. 推理（Think/Reason）：决定下一步该做什么
          1. 行动（Act）：选择工具
          1. 观察（Observe）：接收执行后返回的结果
          1. 循环：基于新的观察结果，再次进行推理，决定下一步行动，如此循环，直到完成
        - 最佳实践
          1. 不能planner一次全部规划：复杂问题不能一步到位
     1. Plan-and-Solve：和ReAct是两个方面，更适合逻辑严密、步骤明确的长程任务
     1. Reflexion
        - 认识：反思，通过自我反思和强化学习提升复杂任务的推理能力
          1. 应用场景
             - 序列决策任务
             - 复杂问答与推理
             - 代码生成与编程
             - 需要高准确性和可靠性的文本生成
        - 组成
          1. 参与者：负责生成初始响应。接收用户输入，产生初步回答、批判性思考、可能用到的工具
          1. 评估者：评估参与者输出的质量，如根据任务特性(如决策、推理、编程)使用不同的奖励函数
          1. 反思者：Reflexion的灵魂所在，根据评估者提供的奖励信号、当前的轨迹以及长期记忆，生成具体、有针对性的语言反馈
          1. 工具：可选组件，提供外部知识或功能支持
        - 流程
          1. 任务输入
          1. 初始响应生成
          1. 评估
          1. 自我反思
          1. 调整与迭代：这个过程会循环多次，直到输出满足要求或达到最大迭代次数
          1. 结果输出
     1. REPL
        - 认识：交互式执行环境的通用模式，核心就是一条循环
          1. Read：读取，读取你输入的一行代码
          1. Eval：求值，执行/解释这行代码
          1. Print：输出，把结果打印出来
          1. Loop：循环，继续等下一条输入
#### openAI API
1. 认识
   - 官方推荐的数据交互格式是json
1. 组成
   - 协议演变
     1. completion（废弃）：prompt → text，就是文本续写器，聊天都得自己拼，GPT-2/GPT-3时代
     1. chat completions：messages → message，聊天接口，奠定了整个llm行业的api格式
        - 新增messages，需要手动把结果塞进messages
     1. function calling：messages → tool_calls → tool result，从chatbot到agent的关键一步
     1. assistants api（废弃）：抽象比较重，又重新设计，assistant/thread/run/step
     1. responses api：定位原生agent api，是agent执行接口，2025年3月发布
        - message仅仅是一种item
1. completion
   - 认识：补全模式，适用于单次文本生成任务，核心功能是根据提示prompt进⾏提示语句的补全（即继续进行后续⽂本创作），它本质上是文本补全模型。如gpt-3.5-turbo
   - 实例
    ```python
    response = openai.Completion.create(
        model="text-davinci-003",
        prompt="This is a test message",
        max_tokens=1000,
    )
    ```
1. chat completion
   - 认识：对话模式，支持多轮对话，通过messages数组管理上下文，包含system、user、assistant三种角色。升级版，更常用。如gpt-4o
   - 参数
     1. model：使用的模型名
     1. messages：List[Dict]，对话消息列表
     1. 概率控制
        - temperature：温度，控制输出的随机性，0~1
          1. 0.0-0.5：低，输出更具聚焦、更保守、也更可预测，容易重复，适用事实问答或代码生成
          1. 0.5-0.8：中，常用的，平衡创造性和连贯性
          1. 0.9-1.0：高，输出更具创造性，但也更容易出现不连贯或不合逻辑的内容，适用创意写作或头脑风暴
        - top_p：核采样概率，控制输出的随机性，更高级，会选择累积概率达到top_p值的词汇，0~1
          1. 在生成多样化文本的同时，避免选择概率极低的词汇，从而减少生成不相关或无意义内容的风险
          1. 0.5为低和高的分界线
          1. 和temperature建议调整其中一个，而不是同时精细调整两者，因为你知道二者的作用机制吗？
        - frequency_penalty：频率惩罚，避免生成重复的词，有助于提高文本的多样性，-2.0 ~ 2.0，适用于发现输出重复啰嗦
          1. <1.0：鼓励重复使用已出现过的词
          1. 0.0：无惩罚。
          1. 1.0：最大惩罚，显著降低重复词的概率
          1. >1.0：非常强的惩罚，可能使文本不自然
        - presence_penalty：存在惩罚，避免重复话题，只关心词语是否出现过，也有助于提高文本的多样性，-2.0 ~ 2.0，适用避免老生常谈
          1. 机制同frequency_penalty
        - logit_bias：直接修改特定词汇在采样前的概率值，最精细、最强大的控制手段，-100 ~ 100
          1. 负减小，正增大；-100禁止，100强制使用
     1. 回复设置
        - stream/stream_options：是否流式输出
        - stop：遇到指定字符串时停止生成，对于控制模型输出的结构和长度非常有用
        - max_tokens：回复的最大token数
     1. 工具相关
        - tools：strict模式支持严格遵循Function的JSON Schema的格式要求，以确保模型输出的Function符合用户的定义
          1. $def定义模块，$ref引用模块或递归
        - tool_choice
     1. 其他
        - vision：视觉模式，图像识别与分析，支持url或base64编码的图像输入
   - role分类
     1. system：系统消息，提供背景信息和指令，使得回答更加精准，更高的指令优先级、更底层的指令约束
     1. user：用户消息，用户输入的内容
     1. assistant：助手消息，助手生成的回复
   - 实例
    ```python
    // 多轮会话的两种实现方式
    // 1. 直接累计上下文都传过去
    completion_second = openai.ChatCompletion.create(
        model="gpt-3.5-turbo-16k-0613",
        messages=[
            {"role": "system", "content": "你是一位精通机器学习和自然语言处理的AI领域专家，具备20年相关经验"}, 
            {"role": "user", "content": "我是一个小白，我想入门AI领域，我需要学习哪些知识"},
            {
                "role": "user",
                "content": [
                    {
                        "type": "text",
                        "text": "分析这张图片"
                    },
                    {
                        "type": "image_url",
                        "image_url": {
                            "url": "..."
                        }
                    }
                ]
            },                                                                                         # 视觉模式
            {"role": "user", "content": "我是一个小白，我想入门AI领域，我需要学习哪些知识"},                   # 多条信息模型只会回答最后一条
            
            # 注意：这里通过设置role =  assistant可以告诉Chat模型，这个输入是模型返回的答案
            {"role": "assistant", "content": "这里填写上一轮对话模型的回复"},
            {"role": "user", "content": "关于第5条深度学习方面，你帮我更加详细的介绍一下"}
        ],
        tools=tools
    )
    tools = [
        {
            "type": "function",
            "function": {
                "name": "get_weather",
                "description": "Get weather of a location, the user should supply a location first.",
                "parameters": {
                    "type": "object",
                    "properties": {
                        "location": {
                            "type": "string",
                            "description": "The city and state, e.g. San Francisco, CA",
                        }
                    },
                    "required": ["location"]
                },
            }
        },
    ]
    tool = message.tool_calls[0]
    messages.append(message)

    messages.append({"role": "tool", "tool_call_id": tool.id, "content": "24℃"})
    message = send_messages(messages)
    print(f"Model>\t {message.content}")

    // 2. 使用会话id
    from openai import OpenAI
    client = OpenAI()

    response = client.responses.create(
        model="gpt-4o-mini",
        input="tell me a joke",
    )
    print(response.output_text)

    second_response = client.responses.create(
        model="gpt-4o-mini",
        previous_response_id=response.id,                                           # 传入会话id
        input=[{"role": "user", "content": "explain why this is funny."}],
    )

    // 返回值
    {
        "id": "chatcmpl-7Hcl1s2t6u1X2K3l4Q5p6r7s8t9u0v",
        "object": "chat.completion",
        "created": 1677654321,
        "model": "gpt-3.5-turbo",
        "choices": [
            {
            "index": 0,
            "message": {
                "role": "assistant",
                "content": "Hello! How can I assist you today?"
            },
            "finish_reason": "stop"
            }
        ],
        "usage": {                                                                  # 消耗的tokens
            "prompt_tokens": 15,
            "completion_tokens": 10,
            "total_tokens": 25
        }
    }
    ```
1. function calling
   - 背景
     1. 大模型的知识是有限的，无法获取最新的知识
     1. 大模型能给出建议，但是无法直接解决
   - 认识：函数调用，开发者描述函数给AI模型，然后模型可以智能地决定输出一个包含调用这些函数的参数的JSON对象
     1. 大模型处理的步骤具体是
        - 匹配给到大模型的外部函数库
        - 选择合适的函数
        - 根据函数逻辑给出回复
   - 使用
     1. 定义JSON Schema
        ```json
            {
            "$schema": "http://json-schema.org/draft-07/schema#",
            "type": "object",
            "properties": {
                "Name": {
                    "type": "string"
                },
                "Age": {
                    "type": "integer",
                    "minimum": 0
                },
                "Salary": {
                    "type": "number"
                },
                "IsMarried": {
                    "type": "boolean"
                }
            },
            "required": ["Name", "Age"]
        }
        ```
     1. 传入参数
        - 参数组成
          1. functions参数：声明外部函数库
          1. function_call参数：控制是否执行Function calling功能
        - 代码示例
            ```python
            functions = [calculate_total_age_from_split_json]
            response = openai.ChatCompletion.create(
                model="gpt-3.5-turbo-16k-0613",
                messages=messages,
                
                # 增加这两行
                functions=functions,
                function_call="auto",  
            )
            ```
     1. 在本地执行外部函数，将计算过程和结果保存为message并追加到messages后面，并第二次调用Chat Completion模型分析函数的计算结果，并最终根据函数计算结果输出用户问题的答案
1. responses api
   - 认识：响应模式，支持状态化交互，可集成外部工具，如mcp协议、文件搜索、代码解释器
   - 功能
     1. 支持previous_response_id，不需要拼接messages
     1. 新增responses websocket：多次http调用改为ws，对于tool-call-heavy的agent workflow实现最高约40%的端到端加速
   - 组成
     1. instructions：system message
     1. input items
        - message
        - reasoning
        - function_call
        - function_call_output
        - skills/mcp
        - web search/file search/tool search/shell/code interpreter
        - computer use
        - image generation
     1. output items
1. conversations api
   - 认识：长期会话容器，服务端持久化会话数据库，可以跨请求、跨session、跨设备甚至跨job继续使用
   - 实例
    ```py
    // 创建
    conversation = client.conversations.create()            // 得到conv_xxxxxxxxx

    // 使用
    response = client.responses.create(
        model="gpt-5.6",
        conversation=conversation.id,
        input="我叫花生，我是一个后端工程师"                     // 不需要关心之前的信息，直接发新的
    )
    ```
1. embeddings api
   - 认识：独立的api路线，嵌入模式，将文本转换为向量表示，用于语义搜索、聚类、相似性匹配、知识检索等任务
     1. 不直接生成文本，而是提供数值化表示
     1. 适用于机器学习任务
   - 使用：`/v1/embeddings`
1. wiki
   - edit：早期独立的编辑api模式，用户提供待修改文本和修改指令，模型返回调整后的内容。用于文本润色、代码优化、语法修正。能力被吞并，目前较少使用，功能已整合至chat模式
#### deepseek API
1. 多轮对话
   - chat/completions无状态：需将之前所有对话历史拼接好后，传递给对话API
1. 思考模式
   - 认识：同时返回reasoning_content和content，默认开启
     1. 在两个user消息之间如果未进行工具调用，中间assistant的reasoning_content无需参与上下文拼接，会被忽略，反之则需要：因为工具调用中回传reasoning_content，本质是将模型的隐式推理链显式化为可追溯的上下文记忆，从而保障多步任务中逻辑连贯性与自主纠错能力。如
        - 用户问：“对比一下北京和上海的天气，告诉我哪里更适合户外运动。”
        - 模型思考并输出：
          1. 推理内容(reasoning_content)：“用户想对比北京和上海天气，并得到户外运动推荐。我需要先获取两地的天气数据。先查北京。”
          1. 返回内容：工具调用(tool_call)：get_weather(city="Beijing")
   - 设置
    ```
    开关：`{"thinking": {"type": "enabled/disabled"}}`

    思考强度控制：
    openai格式：{"reasoning_effort": "high/max"}
    anthropic格式：{"output_config": {"effort": "high/max"}}
    ```
   - 原理
     1. 如何产生：生成最终答案前，会先经历一个扩展的、链式的内部推理阶段，产生的中间思考token序列，就是reasoning_content的雏形
        - 进入一个高计算量、低温度参数的推理模式
        - 对任务空间的一种显式搜索和规划
        - 用于稳定模型内部状态、引导后续token生成方向的工作记忆、利于条件熵减少
     1. 模型的注意力机制
        - 上下文充当外部工作记忆：模型无需依赖内部状态维持任务目标，而是通过重读历史推理链来恢复意图。会同时关注以下内容
          1. 用户原始问题：锚定最终目标
          1. 上一轮用户问题：承接对话上下文

          1. 上一轮content：避免重复或矛盾
          1. 上一轮reasoning_content：恢复推理意图

          1. 上一轮tool_call：明确执行的动作
          1. 工具返回的结果：获取事实依据

          1. 更早轮次的关键信息：维持全局主题（权重较低）
        - 默认关注所有轮次(全部拼接到长序列来生成下一个词)，最近轮次权重更高，超出上下文彻底遗忘
1. 功能
   - Json Output：支持严格按照json格式输出，`response_format:{'type': 'json_object'}`
   - Tool Calls：即提前传入固定格式的tools参数，支持tool专属数据中输出`message.tool_calls[0]`
   - 补全(Beta)
     1. 前缀续写
     1. FIM：补全中间内容
   - 对话前缀缓存：用户的每一个请求都会触发硬盘缓存，依据请求内容是否和之前的完全相同进行判断
1. Responses API兼容
   - 认识：仅兼容核心协议，不是完整复刻，定义为stateless API无国籍api即不绑定任何特定模型，2026.08.13支持
     1. 不支持previous_response_id和conversation，其他不支持MCP、file_search、code_interpreter、computer_use等
1. Gemini API
   - 认识：功能差不多，字段名字不一样
     1. 对话对象：不是messages，是contents
     1. 消息角色：不是system/user/assistant/tool，是system_instruction+user/model
### AI应用
1. 交互范式
   - prompt engineering：怎么问，通过调整提示词的措辞、格式和示例来获得更好的回答
   - context engineering：让ai看到什么，光提示词不够，要完善上下文
   - harness engineering：系统能预防/测量/修复什么
     1. 给ai套上装备，让它能够干活
     1. 设定边界和验收标准
   - loop engineering：来源于cc的/loop命令，底层本身就是个定时任务，就是套个循环壳用于定时和llm交互保证任务效果，有点炒概念。如之前的分布式Raft循环完成选主、k8s中通过循环监控保证节点、负载、各项指标的稳定
     1. 小心循环打爆token /狗头
     1. 三道防线：迭代上限、无进度检测、预算硬上限
     1. 适合的任务：重复出现、有客观的完成信号，不适合没有确定性的
1. 演进历史
   - chatbot：无状态问答
   - workflow：用n8n/LangChain把llm嵌进代码驱动的DAG流里，代码决定模型下一步做什么
   - autonomous agent：模型控制循环，运行时只是执行器
#### prompt
1. prompt engineering
   - 认识：提示词工程，设计、构建和优化与AI大模型交互的指令(即提示词)的艺术与科学。用于引导和启发llm生成更高质量的回答，是目前和llm交互的核心方式。将人工经验与复杂计算完美结合
     1. 更省时间、生成的质量更高、成为生产力工具
     1. 提示词工程的第一性原理是根据给出的词语预测接下来最可能出现的词语序列，现在也拥有了推理能力、语义理解能力
     1. llm已经学习到了一些通用的知识和推理能力，是通过提示词细化模型的推理过程来引导模型发挥其潜力
     1. 简单的提示词
        添加简单的提示词尾缀：如 “请模型一步步思考、一步步解答...”。
        提供标准的回答模板：“请按照示例答复...”。
        进行角色身份设定：“请以XXX的身份答复...”。
     1. 好的提示词
        有效地指导模型思考。
        依赖人工经验和技术创新构造复杂串联或嵌套的提示流程。
     1. 用于弥补现阶段llm能力的不足，随着llm的能力提升，提示词工程的作用会越来越小
1. 使用
   - 组成
     1. 指示：任务描述
     1. 上下文：背景信息
     1. 例子：示范学习
     1. 输入：数据输入
     1. 输出：结果格式
   - 分类
     1. 语言提示词工程：有局限性，但是灵活、快
     1. 代码提示词工程：可以更加深入，利用代码逻辑和流程来控制，即agent
   - 工具
     1. PromptPilot
1. 方法：范式框架 + md格式
   - 入门/基本：角色(Role) + 任务(Task) + 要求(Requirements) + 范例(shot learning)
     1. 角色
        - 原理：为ai分配一个角色，可以有效激活它在训练数据中与该角色相关的知识、风格和思维模式
        - 技巧：“请你扮演（你是）一个/一位/一名 [角色]，……”
        - 案例：
          1. 普通：帮我看看这段代码。
          1. 进阶：请你扮演一名有 10 年经验的资深 Python 架构师，帮我审查以下代码，重点关注其可扩展性和性能瓶颈。
     1. 任务
        - 原理：直接、清晰地告诉模型需要完成的具体动作
        - 技巧：使用行为动词，如“撰写”、“分析”、“总结”、“翻译”、“生成”、“评审”
     1. 要求
        - 原理：通过添加约束条件，进一步缩小模型的输出范围，使其更符合你的预期。这是提升输出质量的关键
        - 技巧：
          1. 使用分隔符：用 ###、"""、---、**、<>、【】、《》等清晰隔开
          1. 明确风格：如“语气要专业且友好”、“风格要幽默风趣”
          1. 限定长度：如“不超过 300 字”、“总结成一句话”
     1. 提供范例
        - 原理：shot learning：样本学习，先给出一段相似的问题和答案然后提问，来指导模型生成回答，就能增强模型的推理能力。问题越复杂，推理越难。用shot不同example既有历史原因也有词性上的原因，shot是指“子弹”，每个example就像一颗子弹一样，能让模型更准确地击中目标，历史上也用shot来指代“示例”
          1. zero-shot：不提供任何示例，直接提问
          1. one-shot：提供一个示例
          1. few-shot：提供多个示例
        - 技巧：示例要与问题相似，且要包含完整的思路链和解答过程
     1. 举例
        ```conf
        请你扮演一名市场分析师。

        ---
        任务：分析以下用户评论，并总结其核心要点。

        ---
        评论文本：
        """
        这款吸尘器吸力很棒，噪音也在接受范围内，但电池续航有点短，希望能改进。
        """

        ---
        要求：
        1. 提取产品的优点和缺点。
        2. 输出格式为两列的 Markdown 表格。
        3. 总结部分需控制在 50 字以内。
        ```
   - 中级
     1. CoT
     1. 自我修正与反思：让模型扮演“检查员”的角色，对自己的输出进行审视和优化。这能有效减少事实性错误和逻辑漏洞
        - 技巧：“请检查你上面的回答是否存在事实错误”、“请评审你写的这段文字，并提出三条修改建议”
     1. "反向提问"：自己不知道时，让ai来提问自己需要哪些信息
   - 高级：实现提示词的系统化和自动化
     1. 提示词模板库：将常用、高效的提示词结构化，形成可复用的模板。例如，为“写周报”、“做竞品分析”、“写代码”等场景分别建立标准模板。
     1. 链式调用：prompt chaining，将一个复杂任务拆解成多个子任务，让多个提示词按顺序执行，前一个的输出作为后一个的输入，形成自动化工作流
     1. 记忆功能：在后续所有对话中都继承设定，无需重复提供背景
   - 寄存器 Scratchpad
1. 原则
   - 清晰明确的问题描述：提供清晰、明确的问题描述，使模型能够准确理解问题的意图并给出准确的回答。避免模糊、含糊不清或歧义性的问题描述。比如：目的是希望输出是一个逗号分隔的列表，请要求它返回一个逗号分隔的列表。Prompt思路：如果希望它在不知道答案时说“我不知道”，请告诉它“如果您不知道答案，请说“我不知道”。
   - 提供必要的上下文信息：根据具体情况，提供适当的上下文信息，以帮助模型更好地理解问题。上下文信息可以是相关背景、之前提及的内容或其他相关细节。
   - 将复杂任务拆分为更简单的子任务和提供关键信息：如果问题较为复杂或需要特定的答案，可以将复杂任务拆分为更简单的子任务，逐步提供关键信息，以帮助模型更好地理解和解决问题。
   - 避免亢余或多余的信息：尽量避免提供亢余或不必要的信息，以免干扰模型的理解和回答。保持问题简洁明了，并提供与问题相关的关键信息
   - 验证和追问回答：对于模型给出的答案，进行验证和追问，确保回答的准确性和合理性。如有需要，提供反馈或额外的说明，以进一步指导模型的回答。
   - 尝试不同的表达方式：如果模型对于某个特定问题无法准确回答，尝试以不同的表达方式或角度提问，给出更多的线索，帮助模型理解并给出正确的回答。
   - 生成多种输出，然后使用模型选择最好的一个
1. 最佳实践
   - 主要关注如何设计、构造和优化提示词prompt，以引导llm生成更准确、更有用、更符合用户需求的文本
   - 使用小模型时各种提示词方法都控制不了输出结果，换成更大更好的模型后，一句提示词就可以解决
   - 提示词不是越长越好的，复杂需求要拆解成独立小任务，完成小任务再继续
   - 每个版本兜底做记录，越调越偏，要及时放弃
   - 指令要极端明确：模糊的指令只会得到模糊的结果，因为描述需要详细一些
     1. 现在模型越来越强大，学的不再是沟通的技巧，而是说清楚自己的问题
   - 先跑通，再优化
   - 数据标注是需要积累的数据资产
1. CoT：Chain of Thought 思维链。![](../images/ai/prompt-level-chai.jpg)
   - Zero-shot-CoT：在提示词中加入“请逐步分析”、“分步思考并解答”、“让我们一步一步来解决这个问题”等指令，引导模型自己生成思维链，提升推理能力。结果不稳定
     1. 举例
        ```conf
        问题：一个农场里有鸡和兔子共 35 头，它们共有 94 只脚。请问鸡和兔子各有多少只？

        请使用链式思维，一步步推理并解答这个问题。
        第一步：定义未知数。
        第二步：根据头的数量列出方程。
        第三-步：根据脚的数量列出方程。
        第四步：解这个方程组。
        第五步：给出最终答案。
        ```
   - Few-shot-CoT：通过编写思维链样本作为提示词，让模型学会思维链的推导方式，从而更好的完成推导任务。结果不稳定
     1. 流程图：![](../images/ai/Few-Shot-LtM_flow.jpeg)
   - LtM提示法：LEAST-TO-MOST PROMPTING 从少到多，让大模型自己找到解决当前问题的思维链，是一种Zero-shot-LtM方法，最为有效的提示学习方法
     1. 步骤
        - 第一个阶段是自上而下的分解问题，引导模型创建子问题
        - 第二个阶段是自下而上的依次解决问题
     1. 示例
        - Q：“杂耍者可以杂耍16个球。一半的球是高尔夫球，一半的高尔夫球是蓝色的。请问总共有多少个蓝色高尔夫球？”
        - A：为了解决“总共有多少个蓝色高尔夫球”这个问题，首先要解决的问题是''
     1. 实例
        - LtM提示工程如何用于数据建模：拆分多步，用代码逻辑控制，实现提升模型的推理能力
          1. 步骤
             - 先把拆解规范指令和问题一起发给模型，让模型自己拆解问题
             - 然后让模型从拆解结果中提取子指令（有约定的规范，如can be solved by: 后面的内容）
             - 循环完成每一个子问题的回答：每一个循环的内容都是上一层的问题+上一层的答案+原始的Few-shot提示词不断的累积拼接，用代码for循环就能实现
          1. 代码
            ```python
            def llm_predict(scan_data, model="text-davinci-003", cd_few_shot, cm_few_shot):
                """
                使用OpenAI的大模型对SCAN数据集进行预测。
                
                此函数的工作流程：
                1. 拆解命令（Command Decomposition）。
                2. 使用拆解后的短命令进行翻译。
                3. 对原始问题提问。
                
                参数:
                - scan_data: 待预测的SCAN数据集。
                - model (str): 使用的OpenAI模型名称，默认为"text-davinci-003"。
                - cd_few_shot: 命令拆解的提示示例。
                - cm_few_shot: 命令映射的提示示例。
                
                返回:
                - pandas.DataFrame: 包含预测结果的数据框。
                """
                
                # 转化为dataframe
                data_frame = data.to_pandas()
                # 初始化预测列
                data_frame['actions_predict'] = 'unkown'
                
                for i, data in enumerate(scan_data):
                    
                    # 阶段一：拆解子命令
                    prompt_cd = cd_few_shot + 'Q：“%s” A:' % data['commands']
                    response_cd = openai.Completion.create(
                            model=model,
                            prompt=prompt_cd,
                            temperature=0.8,
                            max_tokens=1000
                    )
                    # 拆解命令结果
                    cd_result = extract_subcommands(response_cd["choices"][0]["text"].strip())
                    
                    # 阶段二：短命令翻译
                    cm_few_shot_temp = cm_few_shot
                    for qs in cd_result:
                        cm_few_shot_temp += 'Q:“%s” A：' % qs
                        response_cm = openai.Completion.create(
                                            model=model,
                                            prompt=cm_few_shot_temp,
                                            temperature=0.8,
                                            max_tokens=1000
                        )
                        cm_few_shot_temp += response_cm["choices"][0]["text"].strip()
                    
                    # 对原始问题提问
                    prompt_cm = cm_few_shot_temp + 'Q：“%s” A:' % data['commands']
                    response_c, = openai.Completion.create(
                            model=model,
                            prompt=prompt_cm,
                            temperature=0.8,
                            max_tokens=1000
                    )
                    
                    # 将结果保存在dataframe的对应位置
                    data_frame['actions_predict'][i] = format_model_output(response_cm["choices"][0]["text"].strip())
                    
                return data_frame
            # 验证实际预测效果
            data_frame = llm_predict(scan_data=testing_data)
            ```
#### context
1. context Engineering
   - 认识：上下文工程
   - 组成
     1. 保存context：记忆系统，筛选总结，即找个地方保存起来
     1. 选择context
        - 静态选择：每次全都要，永远重要必须遵守的信息，一般比较短小，如cursor.rules、claude.md
        - 动态选择：根据每次任务选择
     1. 压缩context：快占满上下文时要进行压缩，
        - 方式
          1. 滑动窗口
          1. ai总结：总结后把原来的内容扔掉，会丢失细节，但是降低了大小。如claude的压缩方案有重点保存测试输出和代码改动
          1. 向量代替文本：越长的文本向量化效果越好，但是向量化的目的不是压缩，是语义化和可计算化，Mem0/Letta/Zep
             - 相似不等于相关
             - 召回不稳定：embedding 模型换一个，召回结果差别巨大
             - 维护成本高：embedding 模型、向量数据库、
             - 不好调试：需要先把向量反查回原文，还要debug一通索引
          1. 分层存储：用工具调用主动在不同层之间搬数据
             - 分层
               1. 常驻上下文
               1. 最近对话
               1. 远期归档
             - 方法
               1. 移除不重要的、大段的：如旧的工具输出内容，llm已经读取过了，就没必要留着了
               1. 状态机代替对话
               1. AST代替代码
        - 如何保留关键信息：如llm总结的时候会把8100改为几千
          1. 关键字段不进自由摘要：单独抽成结构化字段精确保留
          1. 原文落库可回溯：能回查
     1. 隔离context：不同的上下文之间是隔离的，常见于multi-agent中 
   - 预算管理
    ```
    Token Budget Allocation
    - system: 10%
    - instruction: 10%
    - memory: 30%
    - history: 30%
    - tools/output: 20%
    ```
   - 上下文污染：开放式、需要多轮迭代的，即会产生很多一次性的附属信息的，应该用独立agent去处理
#### rag
1. RAG
   - 认识：Retrieval Augmented Generation 检索增强生成，用于提升llm生成答案的准确性和时效性的技术框架
     1. 背景：LLM本身的知识滞后、可能“幻觉”两个缺陷，用RAG来增强
     1. 步骤
        - 数据准备
          1. 切分：chunk，切分成小块
          1. 向量化：embedding，使用嵌入模型将每个小块转换为高维度的数字向量
          1. 存储/建索引：indexing，向量数据库，以便后续进行高效的相似性搜索
        - 检索/召回：retrieval，提出一个问题时，RAG系统先从向量化后的知识库中搜索与问题最相关的信息片段
          1. 转换：将这个查询也转换为一个向量
          1. 相似性搜索：在向量数据库中进行相似性搜索
        - 增强生成
          1. 构建增强提示：将检索到的最新相关文档和原始问题打包在一起，形成“增强版的提示”。并指令“请根据以下提供的资料来回答问题”
          1. llm有了“实时”的参考资料，大大提高了回答的质量和可靠性
     1. 特点
        - 数据越规范，查询效果越好，结合树形结构或知识图谱结构的数据，RAG可以实现更好的效果
     1. 适用场景
        - 巨型库加跨库检索
        - 纯语义、非结构化查询
          1. 如不知道自己在找什么词：想要知道差旅报销政策，可能叫出差补贴规定、外出费用管理办法等
        - 多人协作的知识库类查询
        - 多模态数据
   - 向量化
     1. 认识：一种有损的语义压缩过程。将高维、稀疏的离散符号(token)映射到低维、稠密的连续向量空间
     1. 目的
        - 语义化：保留文本的语义信息，同时降低其表示的复杂性和存储成本
        - 可计算化
     1. 特性
        - 固定大小：输出向量的维度是模型定义的（如768维），与输入文本长度无关。这是实现对长文本“体积压缩”的基础
        - 不可逆：无法从向量完美还原原始文本。丢失精确词法、句法细节，保留核心语义
        - 几何语义：向量空间中的距离、方向表征语义相似性（余弦相似度、欧氏距离）
     1. 最佳实践
        - 需要评估场景：注意对短文本向量体积可能大于文本长度，对长文本如一本书向量化是强大的压缩手段
        - 语义>语法：向量擅长捕获“意思”，但几乎丢弃了“写法”。如果任务严重依赖句法结构（如代码生成、语法检查），需谨慎使用或结合其他特征
        - 模型是核心：高质量的现代嵌入模型（如text-embedding-3）的效果远超陈旧模型，这是成本最低的优化手段
        - 无法完美处理反义词、否定和复杂的逻辑关系
        - 实践工具：直接使用成熟的Embedding API（如OpenAI, Cohere）或开源模型（如HuggingFace上的all-MiniLM-L6-v2）开始实验，无需从零训练。
   - 组成
     1. 嵌入模型
        - 认识：Embedding模型层/向量生成器，一种将非结构化数据(如文本、图像、音频)转换为可以被计算机理解和处理的数值向量(如由1024或1536个数字组成的列表)的AI模型。把人类能看懂的文字，翻译成计算机能看懂的“数学语言”
        - 特性：能捕捉原始数据的语义，如“狗”和“宠物”的向量距离会比“狗”和“汽车”的向量距离近得多
        - 原理：通常基于大型语言模型（如BERT、GPT系列）进行训练。通过阅读海量文本学会将含义相似的词或句子映射到向量空间中相近的位置
        - 用途
          1. 向量检索：不再只是匹配关键词，而是搜索含义相似的文本
          1. 聚类：语义相似度匹配，将含义相近的文本自动分组
          1. 推荐：推荐与用户喜欢的内容在语义上相似的内容
          1. 异常检测：找出与其他数据在语义上差异很大的outlier
          1. rerank
        - 分类
          1. API调用
             - OpenAI：text-embedding-3-small/text-embedding-3-large，最好的
             - Google：text-embedding-004
          1. 开源&可本地部署：通用顶尖
             - BGE系列
               1. 认识：BAAI General Embedding，中文优化很强、多任务、国内RAG非常主流，开源翘楚，北京智源人工智能研究院
               1. 模型：BGE-large-en-v1.5、BGE-large-zh-v1.5
             - e5系列：e5-large-v2、e5-base-v2，性能强劲，微软
             - GTE系列
               1. 认识：英文+多语言能力较均衡，常用于替代openai embedding，达摩院
               1. 模型：GTE-large、GTE-base
          1. 开源&可本地部署：轻量高效
             - all-MiniLM-L6-v2：开源之王
             - Snowflake Arctic Embed
     1. 向量/矢量数据库：可以存储和管理大量的矢量数据，如图像、文本、音视频，提供高效检索功能，存储非结构化的数据和进行对比
        - 分类
          1. 开源
             - chroma：轻量、简单，中小型应用的首选
             - qdrant：高性能、企业级、功能丰富。Rust编写，性能极佳
             - weaviate：功能最全，内置模块化的机器学习模型、自动将数据向量化、支持graphql查询
             - milvus：支持大规模数据，部署和维护相对复杂，开源，最常用
             - lancedb：向量数据库里的SQLite
          1. 云服务
             - Pinecone
             - Redis，v7.0
             - PostgreSQL，pgvector扩展
   - 框架
     1. WeKnora
        - 认识：基于llm的文档理解与语义搜索框架，专注于文档问答流程，腾讯开源
          1. 基于RAG的核心搜索流程，将上下文相关片段与语言模型结合
        - 功能
          1. Agent模式：支持ReACT Agent模式
          1. 精准理解：支持PDF、Word、图片等文档的结构化内容提取，统一构建语义视图
          1. 智能推理：支持精准问答与多轮对话
          1. 强效检索：混合多种检索关键词、向量、知识图谱，支持跨知识库检索
          1. 便于集成与扩展：从解析、嵌入、召回到生成全流程解耦
          1. 支持mcp
     1. RagFlow：开源开发框架，用于多文档深度理解，文档处理能力强
        - 功能：文档解析、向量检索、生成答案、引用溯源
        - 关键技术：深度文档理解、多路召回、融合重排序
     1. Cognita：开源开发框架
        - 组成
          1. 数据加载与分块：支持从pdf、ppt、html等多种格式加载文档，并提供智能的文本分割策略
          1. 向量化与存储：可以集成各种嵌入模型将文本块转换为向量，并存储到向量数据库中
          1. 检索与生成：可以集成各种llm来生成答案
          1. 评估与调试：是Cognita的核心价值
             - 检索质量：检索到的文档块是否真的与问题相关
             - 生成质量：最终答案是否准确、相关、基于上下文
             - 真实性：答案是否减少了“幻觉”
             - 可视化调试
     1. FastGPT
        - 认识：支持工作流的开源的RAG，NextJs + TS + MongoDB + PostgreSQL (PG Vector 插件)/Milvus
        - 组成
          1. 应用编排能力
             - 支持工作流、MCP
          1. 知识库能力
             - 支持编辑知识库
             - 支持各种格式
          1. 应用调试能力：知识库单点搜索、调用链路日志等
   - 向量数据库
     1. milvus
        - 组成
          1. collection：向量集合，相当于关系型数据库的表
             - 主键
             - 向量字段
          1. partition：分区，相当于表的分区
          1. index：索引，加速向量搜索
          1. segment：段，存储实际数据
          1. field：字段，相当于表的列
          1. vector：向量，存储实际的向量数据
   - 算法
     1. 余弦相似度
     1. 欧氏距离
   - wiki
     1. 数据蒸馏：将大型数据集浓缩为小型数据集
     1. embedding：是文本的数值表示，可以用来衡量两段文本之间的相关性。是一种将离散的符号或类别信息（如单词、字符或实体）映射到连续向量空间的技术，如将长文本编码为紧凑的高维向量、保持上下文连贯性
1. 常见困难
   - 文档格式复杂、切分粒度不一致、同义问法多、权限隔离强、模型容易基于不完整证据生成
1. 组成
   - 文档侧：结构化解析和标题路径保留
   - 检索侧：三段式检索架构，可能BM25找不到，但是embedding能找到；
     1. BM25：粗召回
        - 认识：一个词出现越多越重要，太常见的词不重要。搜索引擎时代留下来的经典算法
        - 特点：关键词准、不懂语义
        - 作用：快速找关键词、别漏掉关键词
     1. embedding：语义召回。懂语义、不懂精确匹配
        - 认识：就是向量计算
        - 特点：懂语义、不懂关键词
        - 作用：快速找语义、别漏掉语义
        - 常见模型：text-embedding-3-large、bge-large-zh、
     1. reranker：精排。最准、贵、慢
        - 认识：重新阅读原始文档，将Query和Document一起输入给模型
          1. 如果直接把每个文档都进行reranker，成本太爆炸了，需要上边俩先过滤一波
        - 作用：精确排序，把真正相关的内容排到最前面，决定哪些chunk有资格进入llm的上下文窗口
        - 常见模型：bge-reranker-v2、Cohere Rerank、jina-reranker-v2
   - 构建侧：Context Builder：生产环境不是直接取topK，策略有
     1. 分数阈值过滤：避免分数高的雷同大的垃圾内容混进上下文
     1. 去重
     1. token budget控制
     1. 引用链：循环llm阅读->发现信息不足->再次检索，补充上下文->回答
   - 生成侧：强制引用chunk，不允许无证据回答
   - 权限侧：在召回前后都做ACL过滤
   - 评测侧：沉淀gold chunk和线上badcase回归，把问题从“模型不稳定”拆成可定位、可优化的工程链路
1. 原理
   - 检索和生成流程
    ```
    用户问题
        │
        ▼
    BM25召回 Top100
        │
        ├────┐
        │    │
        ▼    ▼
    Vector召回 Top100
        │
        └────┘
            ▼
        合并
            ▼
        Top200
            ▼
        Reranker
            ▼
        Top10
            ▼
        LLM
            ▼
        答案
    ```
1. 架构：如企业智能问答系统
   - 接入层：用户、租户、权限、限流
   - 知识层：文档解析、清洗、切分、元数据、向量索引和倒排索引
   - 检索层：query改写、混合召回、rerank、权限过滤
   - 生成层：证据约束、引用返回、无答案兜底
   - 平台层：会话管理、Feedback、评测集、Prompt版本、灰度发布
   - 运维层：tracing、成本、延迟、命中率、幻觉率监控。重点不是做一个聊天框，而是把权限、召回质量、可观测、评测闭环和知识更新机制打通
1. WeKnora：腾讯开源，前后端一体的RAG框架
   - 平台能力
     1. 前端：vue3 + vite
     1. 界面：web ui/restful api/weknora cli/chrome extension/网站嵌入widget/微信小程序
     1. 后端：go + python(文档解析)
     1. 部署方式：docker compose/helm

     1. 多租户架构
        - rbac权限(四级租户owner/admin/contributor/viewer)、跨租户超级管理员
        - oidc集成(sso)
     1. 安全
        - ssrf防护
        - skill沙箱隔离
          1. 理解：永远不直接访问系统资源
             - Actor：独立空间、不共享全局对象
             - capability：包装能力对象去用，如带校验和审核的工具执行器。如skill只会执行`runtime.readfile("a.txt")`，完全不知道文件在哪儿、有没有ssh等
             - virtual resource：资源虚拟化，如真实是/home/user/project，skill看到的是workspace://main
          1. 组成：权限隔离 + 运行时隔离 + 上下文隔离 + 生命周期管理
          1. 实现方面
             - prompt sandbox：利用前置prompt限制行为，框定在特定条件下。如不要修改源文件、只完成xx功能
             - memory sandbox：只抽取和skill相关的记忆
             - environment/workspace sandbox：目录路径、范围控制
             - permission sandbox：执行命令经过包装后的执行器，执行器会校验
             - process/lifecycle sandbox：限制硬件资源最大使用量、超时时间、生命周期
   - 集成
     1. llm provider：yaml声明式管理，openai/anthropic/gemini、deepseek/qwen、ollama/openrouter等13+
     1. 向量数据库：PostgreSQL(pgvector)/ES/OpenSearch/Milvus/Weaviate/Qdrant/Doris/VectorDB
     1. embedding：BGE/GTE/智谱/openai兼容接口/ollama
     1. 可观测性：集成langfuse

     1. 网络搜索：duckduckgo/bing/google/tavily/baidu/ollama/searxng
        - duckduckgo：一个主打“隐私保护”的互联网搜索引擎，尽量不收集或追踪用户的个人数据
        - tavily：专门为llm/agent设计的搜索api服务，解决传统搜索对llm不友好(html太脏、广告多、需要清洗)
        - searXNG：开源元搜索引擎，自己不建搜索索引，而是转发查询→聚合多个搜索引擎结果
          1. 隐私优先：无用户搜索历史、无用户画像、可自托管(放在自己服务器上运行)
          1. 去中心化：可配置来源
          1. 可定制：排序策略、引擎权重等
     1. 网站嵌入：支持给某个网站嵌入widget形式的智能体，支持域名白名单、限流与安全模式token交换
     1. 对象存储：本地/腾讯云COS/火山引擎TOS/MinIO/AWS S3/阿里云 OSS/金山云 KS3/华为云 OBS

     1. im集成：wecom/feishu/dingding/slack/telegram/mattermost
   - 智能对话
     1. 问答模式
        - 快速问答：RAG流水线，`用户提问 → 查询重写 → 混合检索（向量+关键词）→ RRF 融合 → Reranking → LLM生成`
        - 智能推理：ReACT Agent，`用户提问 → Agent分析 → 检索知识 → 调用MCP工具 → 网络搜索 → 反思推理 → 多轮迭代 → 最终回答`
        - wiki：agent驱动从原始文档中自动生成并维护结构化、相互链接的markdown wiki知识页面
     1. agent工具：mcp协议(含oauth2远程服务)/skill系统/数据分析/网络搜索
     1. 特性操作
        - 支持会话管理、分组会话
        - 对话策略：在线prompt编辑、检索阈值调节、多轮上下文感知
        - 引用与RAG进度：对话内引用浮层、RAG流水线分阶段进度展示
        - 支持相关问题推荐
     1. 支持异步任务管理
   - 知识管理
     1. 知识库类型：faq/文档/wiki
     1. 文档格式：pdf/word/excel/ppt/html/markdown/picture/audio/csv/json
     1. 检索策略：BM25 稀疏召回/Dense 稠密召回/GraphRAG 图谱增强/父子分块/pgvector HNSW加速(1024维)/多维度索引
     1. 端到端测试：检索+生成全链路可视化，评估召回命中率、BLEU/ROUGE等指标
     1. 导入
        - 支持增量/全量
        - 数据源支持飞书/Notion/语雀/RSS
        - 导入方式：文件夹、URL、在线录入
        - 支持多标签管理
        - 按批次解析配置：覆盖解析引擎、分块、多模态(VLM/ASR)、图谱抽取与问题生成；支持 reparse 时调整配置
   - 架构
     1. handler层：gin
     1. service层：knowledge base + agent engine + session service
     1. repository层：gorm
     1. infrastructure层：postgre + vector store + neo4j(graphrag)
   - 实现
     1. 依赖注入：uber-go/dig，让每一层都只依赖接口而非具体实现，实现切换向量数据库从Qdrant到Milvus只需要换一个Provider，业务逻辑代码零修改
        ```go
        container := dig.New()
        // 注册基础设施
        conntainer.Provide(NewPostgresDB)

        // 注册Repository层
        container.Provide(repository.NewKnowledgeBaseRepo)

        // 注册Service层
        container.Provide(service.NewSessionService)

        // 注册Handler层
        container.Provide(handler.NewSessionHandler)

        // 启动
        container.Invoke(StartServer)
        ```
     1. 异步任务处理：文档处理(解析/分块/向量化)使用Asynq + Redis实现异步，比Python的Celery更轻量，类型安全的任务定义，goroutine天然支持高并发消费
     1. RAG流水线
        - 文档解析和提取：在Asynq中，使用DocReader这个Python的gRPC服务，解析PDF/PPT/OCR等，因为其更成熟
        - 父子分块策略：子块用于精确匹配语义，父块提供完整上下文——解决了传统固定大小分块"要么太碎丢失上下文，要么太粗匹配不准"的问题。
            ```go
            // 层级化分块
            type Chunk struct {
                ID         string
                ParentID   *string     // 父块 ID（可选）
                Content    string      // 块内容
                TokenCount int         // Token 数
                Metadata   ChunkMeta   // 元数据（来源、页码等）
            }

            // 检索时：用子块（小粒度）匹配，返回父块（大上下文）
            // 这样既保证了检索精度，又提供了足够的上下文
            ```
        - 混合检索：多路召回 + RRF融合
          1. 特性
             - BM25的中文分词：结巴分词的中文分词的gojieba
             - 并行检索：用errgroup让混合检索的两路召回并行
          1. 代码
            ```go
            func (s *SearchService) HybridSearch(ctx context.Context, query string) ([]Result, error) {
                g, ctx := errgroup.WithContext(ctx)

                var sparseResults []Result  // BM25 关键词检索
                var denseResults []Result   // 向量语义检索

                // 并行执行两路检索
                g.Go(func() error {
                    // BM25：基于 gojieba 中文分词
                    sparseResults = s.bm25.Search(ctx, query)
                    returnnil
                })
                g.Go(func() error {
                    // Dense：向量相似度搜索
                    denseResults = s.vectorStore.Search(ctx, queryEmbedding)
                    returnnil
                })
                g.Wait()

                // RRF (Reciprocal Rank Fusion) 合并
                merged := s.rrf.Fuse(sparseResults, denseResults)

                // Reranking 重排
                reranked := s.reranker.Rerank(ctx, query, merged)

                // MMR 去重
                return s.mmr.Deduplicate(reranked), nil
            }
            ```
     1. ReACT Agent引擎
        - 流程
          1. 用户提问
          1. Agent思考：需要什么信息？
          1. Agent反思：信息够了吗？不够继续调用工具，够了返回结果
        - 组成
          1. 工具系统
            ```go
            type Tool interface {
                Name() string
                Description() string
                Execute(ctx context.Context, params map[string]any) (string, error)
            }

            // 内置工具
            tools := []Tool{
                &KnowledgeSearchTool{Store: vectorStore},
                &WebSearchTool{Client: httpClient},
                &DataAnalysisTool{},  // CSV/Excel 分析
                &FinalAnswerTool{},   // 带耗时跟踪的最终回答
            }

            // MCP 扩展工具
            mcpTools := mcpManager.DiscoverTools()
            tools = append(tools, mcpTools...)
            ```
          1. 并行工具调用
            ```go
            func (a *Agent) executeTools(ctx context.Context, calls []ToolCall) []ToolResult {
                g, ctx := errgroup.WithContext(ctx)
                results := make([]ToolResult, len(calls))

                for i, call := range calls {
                    i, call := i, call
                    g.Go(func() error {
                        result := a.executeTool(ctx, call)
                        results[i] = result
                        returnnil
                    })
                }
                g.Wait()
                return results
            }
            ```
          1. mcp集成：使用mark3labs/mcp-go
            ```go
            // MCP 配置
            type MCPServerConfig struct {
                Transport string // "stdio" | "sse" | "streamable-http"
                Command   string // stdio 模式的启动命令
                URL       string // SSE/HTTP 模式的 URL
                Args      []string
            }

            // 支持 uvx 和 npx 启动器
            // 自动发现工具并注册到 Agent 工具表
            // v0.3.6 新增自动重连机制
            ```
     1. GraphRAG 知识图谱增强检索：当知识分散在多份文档中时，传统 RAG 只能检索片段，而 GraphRAG 可以沿关系图谱找到完整的信息链
        ```go
        // GraphRAG 工作流
        // 1. 文档摄取时：LLM 提取实体和关系 → 写入 Neo4j
        // 2. 查询时：先从知识图谱找到相关实体 → 沿关系扩展 → 获取更完整的上下文

        type GraphRAGService struct {
            neo4j    *neo4j.DriverWithContext
            llm      LLMProvider
            chunkRepo ChunkRepository
        }

        // 实体提取
        func (g *GraphRAGService) ExtractEntities(ctx context.Context, chunk Chunk) ([]Entity, []Relation) {
            // LLM 从文本中提取实体和关系
            prompt := fmt.Sprintf("从以下文本中提取实体和关系：\n%s", chunk.Content)
            result := g.llm.Chat(ctx, prompt)
            return parseEntities(result), parseRelations(result)
        }
        ```
#### workflow
1. 编排
   - 认识
     1. llm能力有限，编排增强能力
        - 整合和协同
        - 任务分解和自动化
        - 灵活性和可扩展性
     1. 大模型应用的特点
        - 核心是大模型，大模型的输出、组件的交互、数据的流转，都可以用有向图来表示
   - 分类
     1. chain：链式
     1. graph：图式
1. 最佳实践
   - 保证llm返回的一定是json结构
     1. prompt约束：可靠性低，不推荐生产，结构可能跑偏如age应该返回int类型的18，却返回了字符串类型的"18岁"
     2. json mode：一些api支持严格返回json格式，只能保证输出是json，不能保证字段正确（缺少、类型错误），ds只支持这个
     3. structured output：能保证符合schema，国外基本支持，国内豆包和千问部分模型支持
     4. function calling/tool calling：保证符合tool schema，agent常用，因为agent本来就是大量使用function calling，构建一个假的函数就可以拿到很严格的json，agent常用这个就是因为顺手的事儿，使用姿势有点偏门，推荐structured output
#### agent
1. agent
   - 背景：大模型时代的人机交互范式，llm将结构化/非结构化的数据结合工具自动处理，变为了人和llm交互，![](../images/ai/why_agent.jpg)
   - 认识：智能体，搭配查网、查数据库等能力，可以执行任务、推理，实现一定程度的自主行动
     1. 现阶段的Agent只能算工作流，什么时候Agent能根据用户要求直接创建好Agent，才算是真正的智能体
        - 早期的如搜索引擎、个人助理等
        - 现在的Agent = LLM + Planning + Memory + Tools。实现任务自动化，并且能够不断探索、规划和发展新技能
     1. 是AGI的前奏，是实现AGI的最优方式，在大模型AI时代下，大模型应用 or AI Power+的应用就是大模型Agent，等同于移动互联时代的APP
     1. 目前好用的Agent平台是Coze和Dify
     1. 未来Agent将会成为真正的智能体，可以做到自主学习、自主决策、自主执行、自主学习、自主创造
   - 分类
     1. 工具类
     1. 对话类
     1. 多模类
   - 实例
     1. agent预订餐厅：获取定位、确定匹配餐厅(查询饮食偏好、人数)、预定餐厅
     1. 完成工作报表
        - 第一步：规划（Planning）：设计Prompt引导大模型拆解“生成工作报告”任务，细化为四步：数据收集、报告整理、汇报人选定、自动提交
        - 第二步：工具（Tools）：针对大模型知识局限，采用 RAG 技术接入私有数据中心 API，获取客户数据；同时接入工作报告应用API，赋予数据填充与提交权限
        - 第三步：记忆（Memory）：分析员工历史报告，提炼风格、格式、周期、汇报人等特征，形成长记忆库，辅助新报告撰写
        - 第四步：行动（Action）：依托工作报告应用权限，大模型完成报告后自动执行提交，实现全程自动化
   - wiki
     1. ETL：提取、转换、加载，数据处理的三个主要步骤
     1. RPA：机器人流程自动化
        - 实现方式
          1. 传统：搭建「桌面」流程后，可以对系统、网页、程序等进行自动化操作
          1. 在线：如N8N、coze，更多聚焦在“云端API连接”和“数据流转”
          1. AI编程：如Claude Code能通过MCP访问文件系统、调用playwright完成页面自动化
     1. 交互方式
        - 嵌入：embedding，人类指定，ai执行
        - 副驾驶：copilot，人类和ai是伙伴关系共同完成任务，ai提供建议并协助任务，ai像知识丰富的伙伴而非工具
        - 智能体：agent，人类设定目标并提供资源，ai独立完成大部分工作，最后人类监督和评估结果
1. 组成
   - 模型：llm，大脑，充当协调者的智能体核心，某llm
   - 循环
     1. planning：规划，赋予智能体类似思维模式，精准拆解复杂任务，分步解决
        - 有反馈规划方法，如ReAct和Reflexion
     1. team：智能体团队
        - 子智能体：subagents
   - 调度
   - 会话
     1. 沙箱
        - 即使路径检查或命令策略存在遗漏，工具仍然被限制在一个物理隔离环境中，不能接触宿主机进程、环境和文件系统
     1. 状态管理
        - metadata：记录干到哪了、共享数据等
     1. HITL：Human In The Loop 人在回路中，在Agent/工作流/自动化系统里，系统执行到某个关键步骤时暂停，等待人工确认后继续
        - 理解：因为ai可能幻觉、理解错需求、调用错工具、执行危险操作，人工必须参与其中
        - 实现
            ```json
            // 说明：在安全的规则体系下，指导llm返回以下数据进入approve流程，可携带参数，此时agent会进入挂起suspend状态
            {
                "action": "approve",
                "modified_args": {
                    "amount": 1000
                }
            }
            ```
   - 存储
   - 记忆：memory
     1. 记忆入口：怎么选择记忆
     1. 短期：上下文窗口限制
     1. 长期：向量和文本存储
   - 工具：提供使用的工具，如api、图表生成等
   - 技能：skill
   - UI 
1. 如何测评
   - 离线评测
     1. 上线前先拦住明显问题
   - 在线监控
     1. 关注trace、span、延迟与反馈
   - 发现失败case
     1. 识别异常任务与失败样本
   - 失败原因分析
     1. 定位意图、检索、工具或生成问题
   - 样本回流再测试
     1. 补回离线集，下一版继续验证
1. 保障对齐方法
   - 明确能力、权利边界
   - 工具
     1. 权限控制
     1. 业务能实现重试、幂等、回滚：不是agent一个人的事儿，都要配合
        - 幂等：有的工具不能调两遍
        - 回滚：遇到问题工具能自动实现回滚
   - 流程控制：状态机和流程约束
     1. 防死循环
        - 最大步数：通常15步，超过强制终止
        - 超时控制：整个任务设最大执行时间
   - HITL
   - 输出校验和结果审查
   - 监控、审计和可回滚
1. OpenClaw
   - 认识：
     1. 渐进式生长：累积知识、错误的不再犯，通过搭配SOUL.md、MEMORY.md不断积累更新
   - 组成：![](../images/ai/openclaw_struct.jpg)
     1. 模块：ai + 记忆memory + 技能skill + 电脑
        - 聊天交互
        - 记忆系统
        - 技能积累
        - 定时任务
     1. 文件
        - 配置：`~/.openclaw/openclaw.json`
        - 身份
          1. SOUL.md：智能体的"人格文件"
          1. IDENTITY.md：快速参考名片
          1. USER.md：智能体需要了解的"甲方画像"
        - 行为
          1. AGENTS.md：行为手册，告诉agent具体怎么干活。定义会话启动流程、任务处理规则、安全边界
          1. TOOLS.md：能力清单
          1. Cron：定时调度
          1. HEARTBEAT.md：自愈机制
        - 知识层
          1. memory/*.md、MEMORY.md：日常记忆、精炼的长期记忆
          1. shared-context/：跨智能体共享知识
        - 其他
          - agents/
          - sessions/
          - skills/
          - credentials/
   - 特点
     1. agent + 电脑：拓展能力范围
     1. 持续记忆更新：长期记忆模块，记录和积累用户的交互历史、偏好和反馈。这个是openclaw最大的特点和优点
     1. 直接im远程对话：方便快捷
     1. 安全模型是加法思维，默认什么都能做
     1. clawHub生态：skill实时更新
   - 使用
     1. openclaw gateway restart
     1. openclaw plugins install/list @openclaw/acpx
   - 架构：在pi agent之上包了一层gateway和bridge，加了skill marketplace、多渠道接入、企业管理后台
     1. 接入层：用户层，接收用户消息。如飞书、web控制台
     1. bridge层：协议转换 + 消息标准化，即渠道适配 + 消息格式统一转换
        - 渠道适配：channel plugin
          1. websocket桥接
          1. webhook
          1. 原生协议
        - 消息格式统一：msgContext
          1. body、from、to、channel、sessionkey等
     1. gateway层：网关层，端口18789、认证、路由、分发
        - 设备配对、token认证
          1. 风险：token无过期时间、默认无设备绑定
        - 消息路由：agent路由表
          1. agentId + sessionKey解析
        - websocket 双向通信
          1. ai中间状态实时推送
        - 心跳&多设备广播
          1. ping/pong
          1. 断线重连
          1. 全端同步
     1. agent runtime层：核心执行层，pi agent引擎 + openclaw平台层
        - pi agent引擎
          1. pi-ai多模型抽象：10+模型供应商
          1. system prompt：< 1000 token
          1. agent循环：while + 工具调用
          1. 工具能力：四工具，read/write/edit/bash
          1. session管理：jsonl树形/支持分支
        - openclaw 平台层
          4. 子agent系统
          1. skill系统：1700+技能
          3. 安全配置：白名单/审计
          5. 管理后台
   - 实现
     1. 流程
        - 微信clawchat → bridge（消息格式转换）→ gateway（认证、路由）→ agent runtime（意图理解、skill 调度、模型调用）→ 文件系统操作 → 结果回传 → gateway → bridge → 微信 clawchat
     1. 记忆系统
        - 认识：关机重启都存在
          1. memory_search、memory_get：在你保存记忆文件后，系统会用Chokidar工具监控文件变化，为了避免频繁写入触发重复操作，还设置了1.5秒的防抖延迟；然后，系统会把文件内容分成约400个token的文本块，相邻文本块会保留80个token的重叠区域，这样既能保证语义连贯，又能提高检索精度；接着每个文本块会被传入embedding模型，转换成1536维的embedding数据，最后存储在数据库里。这个数据库里有四张核心表，分别存储文本块、embedding数据、全文检索内容和向量缓存（存储文本哈希值和对应向量，用于避免生成重复向量）。过程中，会结合语义检索（向量检索）和关键词检索（BM25）两种方式，按 7:3 的权重计算最终检索得分，公式如下最终得分 = 0.7 × 向量检索得分 + 0.3 × 关键词检索得分这样的混合检索方式，既能匹配语义相近的抽象内容（比如 “关于数据库的相关讨论”），又能精准捕捉人名、编号、日期这类具体信息（比如某人哪天提了什么信息）。
          1. 不同agent有自己独特的MEMORY.md
          1. 记忆刷写：启动对话历史压缩
        - 组成
          1. 本地markdown文件 + sqlite向量索引
          1. 日志层记忆 memory/YYYY-MM-DD.md + 长期记忆层 MEMORY.md
     1. Skill执行引擎
     1. 上下文管理器
     1. 模型路由器
     1. Gateway

     1. Skill Marketplace
1. pi-mono
   - 认识：openclaw底层依赖的llm库
   - 流程：用户发消息 → 加载session(jsonl历史)→ 构建上下文(system prompt+工具定义+对话历史)→ 进入while循环 → 调用llm(流式请求)→ 接收响应(text_delta/tool_call)→ 判断是否需工具调用 → 执行工具并收集结果 → 写回上下文 → 继续循环（直到完成）→ 持久化session(写入jsonl)→ 返回结果
   - 组成
     1. jsonl session管理
        - jsonl：即每行只能一条压缩的json数据
        - jsonl树结构：在json中标记自己的父级是谁(每条记录带id和parentId)，这样一点点往上推就能得到整个有分支的会话历史
     1. extension系统设计
        - 拒绝mcp，私有协议，用cli工具 + readme做渐进式发现，agent需要某个能力时，通过bash调用cli，按需付上下文成本。避免了mcp的一般情况下的13k~18k token预加载开销
     1. 极简system prompt：对赌未来模型能力，留给用户更多上下文，关键时刻安全性可能不足
   - 架构：四层分包架构，每层解决一个问题，可以单独引用某一个包，核心的是后三层
     1. pi-tui
        - 认识：终端ui层
        - 特性
          1. markdown渲染 + 语法高亮：差分渲染，只重绘变化行。比 claude code 闪烁少
          1. 多行编辑器 + tab自动补全：历史命令、vi快捷键支持
          1. synchronized output：终端缓冲区批量刷新，消除流式渲染的撕裂感
     1. pi-coding-agent
        - 认识：开发者实际使用的入口，面向用户的最厚的那层
        - 特性
          1. cli/tui(Terminal UI)、sdk嵌入、extension、skill
          1. session
             - session持久化：jsonl树结构，支持分支/恢复，原始历史一条不丢
          1. tool：四工具(read/write/edit/bash)。grep/find等通过bash调用
     1. pi-agent-core
        - 认识：agent运行时内核，即loop 循环层(发消息 → 调工具 → 再发消息)
          1. 这层不知道"文件系统"、"bash"、"session"这些概念，干干净净
          1. while循环：即核心，无DAG、无编排引擎，`发消息 → 工具调用 → 执行 → 循环 → 直到完成`
        - 特性
          1. 双消息队列机制、并发工具执行、生命周期事件总线
          1. 支持事件订阅：实时感知agent状态，message_update/tool_start/tool_end/done
          1. 流式处理：逐字符推流，ui实时更新。text_delta/toolcall_delta
     1. pi-ai
        - 认识：模型通信层，多供应商统一接口
        - 特性
          1. 统一流式接口：text_delta | toolcall_start | done | error —— 所有供应商统一输出格式
          1. 10+ 供应商支持：anthropic/openai/google/xai/groq/mistral/ollama/deepseek
          1. 一行代码切换模型：getmodel(provider, model) —— 不改业务逻辑，只换供应商
1. 原理
   - 整体
     1. 架构图：![](../images/ai/hermes_agent_struct.jpg)
   - loop
     1. 架构图：![](../images/ai/agent_loop_struct.png)
     1. 代码示例
        ```py
        while True:
            response = client.messages.create(messages=messages, tools=tools)
            if response.stop_reason != "tool_use":
                break
            for tool_call in response.content:
                result = execute_tool(tool_call.name, tool_call.input)
                messages.append(result)
        ```
   - 反思
1. 设计
   - 如果Agent需要执行系统命令或访问文件，你怎么防止它越权删除数据库、读取主机敏感文件?
     1. 理解：核心原则是模型不能直接碰系统权限，只能调用受控Tool。生产上做五层防护
        - 命令白名单，禁用rm、curl、scp、chmod、数据库drop等高危操作
        - 沙箱执行，用docker/gVisor限制CPU、内存、网络、目录，agent只能“申请执行”，不能拥有宿主机权限
        - 文件访问做工作目录隔离和路径规范化，禁止../、/etc、w/.ssh
        - 高危操作必须HITL审批
        - 全量审计Tool入参、执行人、结果和回滚点（就是记日志）
1. deepseek-harness
   - 认识：一切皆插件
     1. 进化方式：重新组合agent结构
   - 组成
     1. Cordis：内核，只负责插件的加载、卸载和依赖关系，不承载
        - 服务与事件
        - 配置层自由组合
     1. 插件：提供能力，包括loop等
     1. 会话日志：仅追加设计的事件流
        - 包含：系统提示词(每一次上下文注入)、思维链、工具调用与结果、子agent调度
        - 操作：恢复、分叉、检索、回放
   - 使用
     1. 模式
        - 标准模式：功能完整的编码agent，支持文件编辑、shell、文件与网页检索、skills、计划、目标、子代理和工作流
        - PTC模式：标准模式 + Code Mode SDK
        - 极简模式：仅提供持久bash与str_replace_editor的双工具编码Agent，用于最小化环境下的模型基准测试
          1. 在最干净、最可控的环境下，测试模型的基础编码能力：没有辅助的情况下纯靠模型自身能力能把编码任务做到什么程度
             - 模型基准测试
             - 消除干扰变量
        - 创造模式：用于创建自定义agent preset，标准模式 + 运行时检查、插件实验和preset创作指导
   - wiki
     1. Cordis
        - 特性
          1. Temporal composability 时间可组合性，一个插件卸载之后它之前产生的副作用能不能完整撤销
          1. Spatial composability 空间可组合性，一个插件如果依赖其他插件，当其他插件出现、消失、改变时，它能不能动态地重新处理自己的依赖
     1. Code Mode SDK
        - 认识：工具，让AI模型不再“一步步调用工具”，而是直接写一段ts代码来批量、组合式地完成多步操作的机制。把多个工具调用组织成一个有逻辑的包含变量、循环、条件判断、数据转换等的程序
          1. 从“对话式调用”到“编程式编排”
        - 特点
          1. 减少往返延迟：多步操作在一次代码执行中完成，无需反复通信
          1. 模型可以表达复杂逻辑：复杂控制流在传统模式下很难表达，但在代码中天然支持
            ```
            如果 A 成功，则做 B；否则回退到 C；
            把 B 的结果转换格式后再传给 D；
            对结果列表做过滤和排序。
            ```
     1. agent preset
        - 认识：预先配置好的agent包：把模型/系统提示词/工具集/参数配置/行为规则等打包在一起，形成一个可复用、可分享、可实例化的agent定义
          1. 可以检查当前运行时、在内存中试验Cordis插件，并据此组合和创作新的模式
1. 其他
   - HappyCapy：agent原生电脑，专门运行在远程电脑上的openclaw
   - Hermes Agent
     1. 认识：长期运行、自我学习的agent
        - 自我进化循环：闭合学习循环机制，能自动将任务执行经验转化为可复用skill
        - 进化方式：学习并修改自身知识/技能
     1. 自学习与自进化：两者属于不同层次
        - self-learning：hermes agent内置，通过任务反思积累和更新memory、skill
        - self-evolution：独立的自动优化项目，通过评估和搜索优化skill等文本参数
     1. 自学习
        - 核心组成
          1. 存储层：memory、skill
          1. 反思层：background review
          1. 治理层：curator
             - 背景：学得越多，不一定越好，会出现重复、冲突、过期、错误、极其具体的进化内容
             - 方式
               1. 跟踪view、use、patch、last-used
               1. 管理active、stale、archived
               1. 启动辅助模型去合并、修复、更新
        - 步骤
          1. 执行任务
          1. 产生经验
          1. reflection 反思
          1. 判断有没有值得长期保存的东西
          1. memory/skill
          1. 下次任务重新调用
          1. 根据新的经验继续修改skill
     1. 自进化
        - 认识：dspy(优化框架) + gepa(优化算法)，评估并优化skill等文本参数，当前是独立项目，并非hermes agent内置的在线学习机制
        - 流程
          1. 读取当前skill或prompt
          1. 构建评估数据集
          1. 生成候选版本
          1. 执行并评估候选
          1. 通过约束检查
          1. 选择最佳版本
          1. 提交人工审核
     1. DSPY
        - 认识：可优化的llm程序框架，用于框架化llm调用，stanford nlp做的
          1. 把传统手搓 prompt变成写llm程序
          1. 为了让rag、分类器、agent loop等llm系统变得模块化且可优化
        - 方式
          1. 定义输入、输出、模块和流程
          1. 让dspy的optimizer去优化真正喂给模型的instruction、few-shot examples等
     1. GEPA
        - 认识：genetic-pareto 反思式提示词优化算法
          1. 不容易过早陷入局部最优：使用pareto-aware selection，会尽量保留这种在不同样本/目标上有优势的候选，而不是过早只留下一个全局平均分最高的版本。论文描述为利用自身尝试形成的 pareto frontier，并组合其中互补的经验。
        - 方式
          1. 让另一个llm查看完整上下文execution traces
          1. 直接产生一个新的prompt候选，提出并测试新的文本参数
   - Evolver
     1. 认识：把ai agent从一次性工具变成可积累、可遗传、可进化的数字生命体系，像文明一样持续演化
        - agent自进化：基于GEP协议的AI智能体自进化引擎
        - agent交易市场：把零散的prompt调优变成可审计、可复用的进化资产
        - 反幻觉：用一套评估标准
        - 碳硅共生：双螺旋宣言、宪法、伦理委员会
     1. 解决的问题
        - agent不会“遗传”和”共享“：一个agent花了3天学习了新东西，别的agent完全不知道，等于每个ai都在重复踩坑
        - prompt无法工业化：无法像npm包一样传播、无法被别的agent自动采用
        - ai没有“文明”：人类文明发展靠知识积累、经验传播、技能遗传、方法论进化
     1. 存在挑战：虽然理念很酷，但是有很多挑战
        - “自我进化”容易失控：无限循环、性能退化、幻觉放大
        - knowledge graph很难维护：schema难设计、entity resolution复杂
        - 真正的“能力遗传”其实非常难：很多时候依赖当前模型/当前上下文/当前Tool/当前环境，未必真的能泛化
     1. 特点
        - GEP协议：Genome Evolution Protocol 基因进化协议，即ai能力遗传协议，“任务完成后自动提取可复用资产”的闭环范式
          1. gene：基因，agent的技能包，可以是
             - 网页自动化策略
             - 代码修复能力
             - mcp tool调度逻辑
             - prompt模板
             - react推理链
             - 某种workflow
             - 某种记忆机制
          1. capsule：胶囊，经过验证的经验结论，如“这个API要先sleep2秒，否则429”
          1. GDI：Global Desirability Index，给Agent能力打分，维度有使用量、fork、调用次数、社区反馈、成功率
        - 三层记忆体系：持久事实层 + 程序性记忆层 + 历史搜索层
        - 周期性反射循环：“技能在使用中自我改进”
        - 真正核心：知识图谱，号称跨会话知识持久性、代理的语义记忆、图形推理，用关系网络支持ai的记忆
     1. 适用
        - 团队维护大规模agent提示词和日志
        - 需要可审计进化痕迹的场景（genes、capsules、events）
        - 需要确定性、协议约束变更的环境
     1. evolver做什么
        - evolver是一个提示词生成器，不是代码修改器
        - 每个进化周期
          1. 扫描`memory/`目录中的运行日志、错误模式和信号
          1. 从`assets/gep/`中选择最匹配的gene或capsule
          1. 输出一份严格的、受协议约束的gep提示词来引导下一步进化
          1. 记录可审计的evolutionEvent以便追溯
1. wiki
   - agent对话中工具响应占67.6%token，工具定义占10.7%，system prompt只占3.4%。这意味着优化工具输出（限制返回长度、截取关键信息）比优化prompt“更能省钱
   - 对比
    ```
    | 维度           | Claude Code                              | Pi Agent（OpenClaw 引擎）                  |
    |----------------|------------------------------------------|-------------------------------------------|
    | Agent 循环     | while 循环 + 工具调用                    | 同样是 while 循环 + 工具调用              |
    | System Prompt  | 几千 token，详细的行为规范               | <1000 token，极简指令                     |
    | 核心工具       | Read / Write / Edit / Bash / Glob / Grep | Read / Write / Edit / Bash（四个）        |
    | 扩展机制       | MCP 协议（标准化、生态大）               | Extension 系统（私有、高效）              |
    | 模型绑定       | 深度优化 Claude                          | 模型无关，支持十几个 Provider            |
    | 上下文管理     | 自动压缩（85% 阈值触发）                 | 无内置压缩，依赖极简 prompt 控制上下文    |
    | 权限模型       | 默认拒绝（白名单机制）                   | YOLO 模式（默认全开）                     |
    | Sub-Agent      | Task 工具生成子 Agent                    | 反对编排式子 Agent，推荐 bash 调自身      |
    | Session 持久化 | 内存 + 自动摘要                          | JSONL 树形结构，支持分支 / 恢复           |
    | 终端 UI        | SSE 流式渲染                             | 差分渲染 + synchronized output            |
    ```
   - 安全建议
     1. 不要给agent完整的文件系统读写权限
     1. 不要让agent自动发送外部通信
     1. 不要把api密钥写进记忆文件
     1. 禁止公网暴露端口
     1. 定期审计skill
   - openclaw
     1. 名字历史：Clawdbot、Moltbot
     1. openclaw其他产品
        - Claude Desktop
          1. Cowork：AI Agent模式。把Claude从“聊天助手”升级为一个真正能替你在电脑上干活的AI同事，可以自动执行复杂的多步骤任务。如整理文件、分析excel、整理笔记为报告
        - Nanobot：4K行代码，理解AI Agent是怎么工作的，如工具调用循环、上下文管理、多轮对话状态
        - KimiClaw：全球部署，封装的利用了Cloudflare的边缘网络
        - PicoClaw：路由器、开发板适用

        - Qclaw：对openclaw产品化封装变成傻瓜式的本地安装包，直连微信（使用微信下命令、操作微信🐶）
        - WorkBuddy：CodeBuddy团队自己做的独立产品，偏商务（企业级的安全审计能力、支持多个im平台）
   - agent连接chrome
     1. 方式一
        - 原理：extension + native bridge，由于是多进程间状态同步 + IPC时序问题，导致连接不稳定
        - 涉及组件
            ```
            Codex Runtime（Agent）
                    ↓
            browser-client.mjs              控制浏览器的客户端，通常运行在node、cli中，负责：找Chrome、建立连接、bootstrap browser context、claim session、发送控制命令、接收页面状态、
                    ↓
            Chrome Extension（扩展）         浏览器内部的当前tab、DOM、JS、模拟用户行为，基于安全原因都是不开放外部的，扩展可以，扩展是浏览器里的代理人
                    ↓
            Native Messaging Host           扩展不能启动本地进程、操作文件系统、跟Node runtime建立任意socket，chrome官方机制，解决了浏览器世界和本地系统世界互通，可以启动native host进程，如go、node、python、rust
                    ↓
            指定的Chrome Profile            浏览器用户环境，可以有多个，互相是独立的，包含登录状态、cookie、localstorage、浏览器配置、扩展
                    ↓
            当前浏览器 Tab / Session
            ```
        - 为什么不用remote-debugging-port
          1. 不安全：会开放9222端口，容易让黑客完全控制浏览器、获取浏览器的所有数据
          1. 更像调试接口，不是稳定API：过程中tab 生命周期变化、页面刷新、Chrome 崩了、profile 切换都会使浏览器环境发生变化，从而让agent的基础条件遭到破坏；DevTools模式通常要求单独启动Chrome；多profile很难管理
          1. chrome升级经常变更影响协议，不好适配
     1. 方式二
        - 原理：Computer Use MCP，即依赖操作系统的ui自动化能力，通过操作系统的可访问性api获取accessibility tree（优先于截图使用tree这种结构化的数据），同时搭配窗口截图（视觉上下文，就是截图然后提取文字，让llm知道界面上都有啥）实现通用的应用操作，可以操作鼠标、键盘点击、滚动
          1. 能驾驭那些完全没有可用api的应用，甚至使用iPhone镜像
          1. 但是有些应用可访问性(盲人操作、阅读)做的比较差，那codex就会完不成任务，比如飞书 这种应用
     1. 方式三
        - @Browser：内置浏览器，不需要登录、cookie等，是安全的屏障
     1. 方式四
        - 截图：不断的截图
#### 效果验收
1. LLM-as-Judge：用一个llm来评价另一个llm的输出质量
1. 工具
   - Langfuse
     1. 认识：llm应用的观测、监控与分析平台，ts写的，开源
        - 属于目前业界最主流的llm基础设施之一，很多团队会直接接入
        - 架构定位
            ```
            Agent App
                │
                ▼
            Agent Runtime (ADK/LangGraph/OpenAI SDK)
                │
                ▼
            Langfuse (Trace/Eval/Prompt)
                │
                ▼
            ClickHouse/Postgres
            ```
     1. 功能
        - Prompt Trace：链路追踪，包括
          1. User Input
          1. LLM Call #1
          1. Tool Call(Search/DB)
          1. LLM Call #2
          1. Final Output
        - Token和成本统计
        - Agent可视化
        - Evaluation评测
   - CozeLoop
   - LangSmith
     1. 认识：LLM应用的开发运维的商业LLMOps平台，提供了贯穿开发、测试、生产全周期的工具。是LLM应用的集成开发环境IDE+应用性能管理APM工具，LangGraph官方出品，闭源
        - 解决如提示词prompt难以调试、评估困难、监控缺失等问题
     1. 功能
        - debugging & tracing：调试和溯源，自动记录每次llm的调用的溯源图。看到输入、输出、耗时、成本，快速定位问题
        - testing & evaluation：测试和评估，创建数据集、运行批量测试等
        - monitoring：监控，延迟、错误率、输出质量，设置警报
        - collaboration：协作，共享提示模板、跟踪记录、数据集等
#### 架构
1. 工作流/agent
   - 架构如
     1. Agent App
     1. Agent Runtime (ADK/LangGraph/OpenAI SDK)
     1. Langfuse (Trace/Eval/Prompt)
     1. ClickHouse/Postgres
1. 评估工具
#### 多模态
1. ai生成ppt
   - 认识：应该追求视觉效果
   - 生成方式
     1. 以前：问题就是设计能力弱，看起来不高级
        - llm生成大纲
        - 选择模版
        - llm对模版的内容进行替换
     1. 现在：核心是解决了页面设计这个做ppt的核心，把页面设计交给了图像模型，而不是模板引擎。如Codex + Image2 + Presentation Skills
        - llm生成大纲
        - 利用图像模型生成每页图片，规划页面结构、排版、字体等，如image2
        - 利用skill生成ppt等格式
   - 如何生成质量更高&定制化更高的ppt
     1. 利用skill：生成流程 + 全方面的经验教训标注是核心，即注意事项等。参考https://github.com/op7418/guizang-ppt-skill
        - skill里说明工作流步骤，让生成变的完善和可控制
        - 将大量、巨量的专业经验落地在references中，是效果的保障
1. ComfyUI：复杂工作流编排生成音视频，Stable Diffusion生态发展而来
   - 功能
     1. 文生图、图生图、视频生成
     1. 局部重绘Inpaint(就是局部修改，如人物衣服区域打mask)、高清放大/细节修复
     1. ControlNet：控制姿势、构图、边缘、空间结构
        - 姿势 OpenPose
        - 边缘 Canny
        - 深度 Depth
        - 线稿 Lineart
        - 涂鸦 Scribble
        - 法线 Normal
        - 分割图 Segmentation
     1. LoRA：小型风格/角色/概念模型，用于保持角色风格
     1. IP-Adapter：让模型参考图片内容
     1. SDXL：是个模型
### AI开发
1. 开发平台
   - coze
     1. coze studio：扣子开发平台
     1. coze loop：扣子罗盘
   - dify
     1. 认识：简单快速创建ai应用的llmops平台，内置了构建llm应用所需的关键技术栈
     1. 功能
        - 支持开箱即用的聊天对话模式的web站点
        - 后端api（组件、上下文增强）
        - 可视化prompt编排界面、上下文、插件等
        - 数据集管理（标注、改进）、日志等
        - 兼容openai、langchain等多种llm
        - 高质量的rag引擎
        - 灵活的agent框架
        - 声明式yaml文件做配置
     1. 组成
        - 模型：系统推理、embedding文本嵌入、rerank、tts、asr
     1. 应用
        - 交付结果：有鉴权的控制api、可二开的webapp、一套包含提示词工程、上下文管理、日志分析和标注的易用界面
        - 分类
          1. chatbot聊天助手：基于llm构建对话式交互的助手
          1. text generator文本生成应用：面向文本生成类任务的助手，例如撰写故事、文本分类、翻译等
          1. agent：能够分解任务、推理思考、调用工具的对话式智能助手
          1. chatflow对话流：适用于定义等复杂流程的多轮对话场景，具有记忆功能的应用编排方式
          1. workflow工作流：适用于自动化、批处理等单轮生成类任务的场景的应用编排方式
1. Ai浏览器
   - 认识：浏览器作为web主入口，仅仅展示数据太可惜了
   - 产品
     1. ChatGPT Atlas
     1. Tabbit
        - 智能代理模式（Agent）：录制Skill与脚本Script
        - 全能输入框：一键@所有数据，链接、截图、文件夹
#### 开发框架
1. agent的分层的技术栈
   - Agent 产品层
     1. Coze
     1. Manus
     1. Devin
   - Agent 编排层（Workflow/Graph）
     1. LangGraph：仅python
     1. Eino ADK
     1. Google ADK：仅支持python
   - Agent 执行层（Engine/Runtime）：engine层负责怎么思考、怎么编排、怎么执行，runtime层负责怎么稳定运行、怎么管理生命周期、怎么接入环境
     1. Pi
     1. Claude Agent SDK：官方开源的agent运行时的sdk，开放了loop、自动压缩上下文、子agent、读写、bash、mcp等能力，目前支持python/typescript，都是偏向自家模型api，不够中立
     1. OpenAi Agents SDK：仅支持python，都是偏向自家模型api，不够中立
     1. Goclaw
   - agent平台基础设施层
     1. Veadk：Volcengine Agent Development Kit 火山引擎智能体开发套件，agent平台+agent框架，偏平台化
1. 架构
   - 编排方式
     1. Compose：函数组合的简单的固定的流水线，没有显式的edge、条件跳转、循环，整个compose本身又可以看成一个新的node
        - 用于封装一个能力
     1. Graph
        - 可以Fan-out（并行）、Fan-in（汇聚）、Condition（条件）、Loop（循环）、Retry、Router
        - 用于编排多个能力
   - 构建分层、多智能体的执行架构：不同层面的机制
     1. cycleAgent：控制同一个Agent内部的迭代推理(Plan → Execute → Reflect)
     1. transfer_to_agent：控制不同agent之间的职责切换和控制权转移。
   - Agent Runtime的自动化：帮开发者完成agent的生命周期管理
     1. 能自动管理的场景：多轮循环、tool calling、context维护、agent transfer等
     1. 能力要素
        - stream→stream     节点连接、invoke↔stream 自动适配
        - metadata/context/event/cancellation 自动传播、传递
        - 生命周期/backpressure 管理
        - graph中混合stream/非stream节点
1. go做agent的优势
   - 高性能的并发模型
   - 单二进制部署
1. 最佳实践
   - "什么时候用 Graph，什么时候用 Agent"仍然是一个需要经验判断的决策。
1. go
   - trpc-agent-go
     1. 认识：以agent抽象为中心，五种内置agent组合使用，生态功能丰富，官方定位go版langGraph，25年5月发布
        - agent-first：统一agent run返回 <-chan *event.event/tools/info/subagents
        - 理念比eino起步高，原生agent更易使用，生态更全，带session/memory/artifacts/代码执行沙箱/agent评估框架(eino都没有)
          1. Artifacts：agent运行过程中产生的可持久化的大文件对象(文件资产)，而不是普通的上下文消息Message或者短期状态Memory，就是支持内存/S3/COS等方式去存储文件
     1. 组成
        - agent能力：5种
          1. LLMAgent：llm对话 + 工具调用
          1. ChainAgent：顺序流水线
          1. GraphAgent：类型安全图工作流，多条件路由
          1. ParallelAgent：并发合并
          1. CycleAgent：planner+executor迭代循环，ReAct模式，
        - tool
          1. 工具接口
             - CallableTool：同步
             - StreamableTool：流式，那种支持流式输出的工具，如Web Search、RAG、A2A等，可以让llm可以边看边思考，加快速度，但是现在llm基本不支持流式输入，某些场景如语音测评可以，只是在agent边执行边调度、持续产出事件等场景使用
          1. 函数工具：function.NewFunctionTool
          1. 内置工具
             - 沙箱代码执行：本地/docker/e2b/jupyter，docker是最合适的agent代码执行环境
               1. Jupyter：一种交互式计算环境，可以运行在宿主机、Docker 容器或云服务中，支持多语音、脱胎于python，真正执行代码的是kernel
               1. E2B：专门提供AI Agent安全代码执行环境(Code Interpreter)的云平台，可以理解为托管版的docker/jupyter沙箱
             - duckduckgo搜索
             - 文件操作
        - session：内存/redis/mysql/postgres/sqlite
        - memory：跨会话
        - rag：向量库嵌入与检索
        - mcp：基于trpc-mcp-go，支持stdio/SSE/streamable三种传输
        - artifacts文件
     1. 能力
        - llm支持：openai兼容api为主，原生anthropic适配器，各大模型都支持
        - 编排能力
          1. 编排方式：通过agent组合（chain/parallel/cycle/graph即编排原语）
          1. 类型安全：GraphAgent类型安全，明确声明输入和输出类型，而不是依赖map[string]any或interface{}，可以编译期发现问题、更好的可维护性、IDE支持完善、大型agent编排更可靠
          1. 编排产物复用：agent可嵌套为subagent
        - 多agent支持
          1. 委托机制
             - SubAgents()/FindSubAgent() + llmagent.WithSubAgents()
             - transfer_to_agent：本质是agent handoff智能体移交事件，不是普通的tool call。表示当前agent决定把后续任务交给另一个agent，由另一个agent接管整个会话或当前子任务的执行。最大的作用是agent路由，可以交由专家agent执行
               1. 类似概念
                  - OpenAI Agents SDK：Handoff
                  - Google ADK：Agent Transfer
                  - AutoGen：Agent Routing
          1. 人机协作：无
          1. 跨语言互操作
             - A2A：兼容Google ADK Python，跨语言多agent系统可行
        - 流式处理
          1. 事件驱动：run返回事件channel，实时接收模型对话、工具调用/响应、agent转移、错误四类事件
          1. 自动化：GenerationConfig{Stream: true}
        - 可观测性
          1. 追踪/日志/指标：内置opentelemetry全链路(model/tool/runner层，OTLP导出)，langfuse集成示例
          1. 可视化调试：兼容Google ADK Web UI的Debug Server(非自带 GUI) + AG-UI/SSE
             - AG-UI：一种agent与前端ui通信的标准协议，还没有达到mcp那样的行业标准地位。采用SSE，最初是由CopilotKit团队提出并开源，支持者有LangGraph/CrewAI/Google ADK/Microsoft Agent Framework/LlamaIndex，对接CopilotKit/TDesign
        - agent评估框架：可复用eval set + 可插拔指标    
   - eino
     1. 认识：以组件+编排为中心，提供chain/graph/workflow三套泛型安全编排工具，流式处理自动化程度业界领先，ADK模块补齐多agent与人机协作能力
        - 编排-first：组件抽象(ChatModel/Tool/Retriever/Embedding/Lambda等) + 编排图，ADK模块提供agent抽象
        - 设计借鉴 langChain/llamaIndex/Google ADK
        - 前期起步太早借鉴langChain，后期为了赶上ReAct agent的步伐，引入ADK，设计上有明显的历史包袱，使用上稍微有点别扭，但是理念跟得上
        - 编排表达力强(字段级映射、泛型约束)，流式自动化更强(拼接/装箱/合并/复制业界领先)，支持人机协作interrupt/resume，和Kitex/Hertz生态协同
        - 组件+编排+流范式概念多于agent-first模型
        - 用Graph表示确定性编排，用ADK表示自主决策
     1. 特点
        - 数据流类型自动互转、流式优先的架构：组件只管业务，框架兜底流式。开发效率高、降低开发所需成本
          1. 组件只需根据真实业务场景实现对应的流式范式(如chatmodel实现stream，tool实现invoke)框架自动处理流的拼接(concat)/流化(box)/合并(merge)和复制(copy)
          1. 译后的runnable统一支持四种执行模式，不管内部组件实现了哪些范式
        - 泛型驱动的类型安全：编译器即可发现
        - 显式优于隐式：编排是显式的定义(graph/workflow)，状态管理是显式的(state handler)，不是隐式注入。易于排查、定义明确
        - 薄抽象，厚编排：ChatModel/Tool/Retriever这些概念是通用的，组件接口只定义I/O类型和必要方法；编排层承担类型检查、流式处理、并发管理等横切关注点。让组件实现者负担小，也让编排能力足够强
          1. 抽象越多，灵活性越差；抽象越少，重复代码越多
        - 是sdk的定位而非平台
     1. 组成
        - agent能力：ADK提供
          1. ChatModelAgent：内部实现ReAct循环
          1. Deep Agent：任务拆解/委派/进度跟踪
          1. Supervisor：层级协调
          1. SequentialAgent
        - 工具
          1. 工具接口
            - Tool组件
            - InvokableGraphTool：把整个graph封装成一个标准tool，可调用一个完整的graph，实现graph的模块化与组合，用于子agent、workflow复用、graph嵌套
              1. 利用 Go 反射自动适配任意输入/输出类型
          1. 函数工具：通过组件封装
          1. 内置工具：eino-ext支持
        - session：无
        - memory：无
        - rag：eino-ext支持，Retriever/Indexer/Embedding组件
        - mcp：eino-ext支持
        - artifacts文件
     1. 能力
        - llm支持：ChatModel组件抽象，eino-ext提供各厂商实现
        - 编排能力：编排表达力强(字段级映射、泛型约束)
          1. 编排方式：三套独立编排工具
             - chain：链式，只能前进
             - graph：有向有环/无环图
             - workflow：DAG，支持结构体字段级数据映射
          1. 类型安全：使用泛型，编译期类型检查，就能发现节点间类型不匹配的问题，而不是等到运行时才炸，`NewChain[I,O]/NewGraph[I,O]/NewWorkflow[I,O]`
          1. 编排产物复用：编排图可独立运行，经NewInvokableGraphTool包装为Agent的工具
        - 多agent支持
          1. 委托机制：ADK多智能体协同，跨agent边界上下文自动管理
          1. 人机协作：Interrupt/Resume：任意 Agent 可暂停等待人工审批并从中断处精确恢复
          1. 跨语言互操作：不支持A2A
        - 自动化
          1. 四范式：四种io组合，是eino最核心的设计之一，很多框架LangChain/LlamaIndex只有invoke和stream两种调用方式
             - 认识：让所有组件都遵循一致的调用协议，框架能够自动适配不同的数据流形态，在graph中与其他组件组合，`schema.StreamReader[T]`
               1. 使得graph节点无需关心上下游的数据是一次性还是流式的，大幅降低了组件组合和复用的复杂度，使得eino在构建复杂agent工作流时能够天然支持端到端的数据流处理
             - 组成
               1. Invoke：普通的同步调用
               1. Stream：流式输出
               1. Collect：流输入转为一次输出，得到完整消息，如ASR
               1. Transform：流输入转为流输出，入和出都是流，可以让整个 Pipeline每一层都不用等待上一层结束。如实时翻译、markdown→html、流式过滤、事件转换、流水线处理
          1. Automatic Data Wiring 编排层自动处理
             - 认识：上游节点输出的数据结构，如何自动适配下游节点的输入。
               1. 编排层里一个比较有特色的能力，很多Agent框架如LangGraph要求你写大量lambda/adapter/mapper来转换节点之间的数据，而eino把这些数据流转换内置到了编排层
               1. 很多agent框架的编排图除了控制执行顺序，还需要开发者编写大量胶水代码来完成节点间的数据转换
             - 数据流变换方式
               1. 复制：copy 扇出，一个输出复制给多个节点
               1. 合并：merge 扇入，多个输入合并到一个节点
               1. 装箱：box，把简单值包装成结构体
               1. 拼接：concatenate，更偏顺序拼接，多个连续数据拼接为一个连续数据
        - 可观测性
          1. 追踪/指标：固定切面回调，`OnStart/OnEnd/OnError/OnStartWithStreamInput/OnEndWithStreamOutput，经WithCallbacks注入`
          1. 可视化调试：无
        - agent评估框架：无
        - 架构
          1. schema层：定义层，`schema.Message(支持多模态)、schema.ToolInfo(基于json schema)、schema.StreamReader[T]`
          1. component层：组件层，定义了清晰的组件接口，如`type ChatModel interface`，在eino-ext
          1. composition层：编排层
             - 类型
               1. chain：一个节点的输出是下一个节点的输入，像流水线
               1. graph：支持pregel模式、条件分支、并行执行，react agent基于graph实现
               1. workflow：声明式数据映射，支持在结构体字段级别进行FieldMapping，适合复杂的数据流转场景
             - 编译过程做了几件关键的事：类型检查(确保相邻节点类型匹配)、构建执行引擎(runner)、注入回调切面。最终产出Runnable[I, O]，统一支持四种执行方式
          1. adk层：是高层抽象。如GraphTool可以把一个编译好的Graph暴露为Tool，供Agent调用，确定性工作流和自主决策不再是互斥的选择
             - ChatModelAgent：封装了ReAct循环
             - DeepAgent：支持多智能体编排、任务分解和子智能体委派
         1. cross-cutting concerns层：横切关注点
             - callback系统：OnStart/OnEnd/OnError/OnStartWithStreamInput/OnEndWithStreamOutput五个切面点，可以注入日志、追踪、指标
             - interrupt/resume：任何Agent或Tool都可以暂停执行等待人工审批，然后从checkpoint精确恢复
             - option分配：可以全局设置，也可以针对特定组件类型或特定节点设置
   - adk-go
     1. 认识：Agent Development Kit，构建、评估、部署复杂agent的go工具包，声明式确定性多agent编排，官方的
        - code-first：用代码定义agent逻辑、工具和编排，而一堆prompt
          1. 整个Agent的定义就是一个llmagent.Config结构体，没有装饰器和元编程这种隐式的写法，非常直接，源于显式优于隐式的理念
             - 装饰器：go没有@xxx这种不修改原函数代码的情况下，给函数增加能力的python语法糖语法
             - 元编程：程序去操作程序本身，如反射和自动注册等机制，如自动提取类的元数据组成json schema`User.__annotations__`这种写法
        - 工作流原语 + llm委派：确定性最高，可预测、可测试
        - 2026年5月，v2.0
        - 局限
          1. 生态还在早期
          1. google强绑定味道：如Gemini 偏向、a2a的google cloud优先支持
     1. 组成
        - MCP
        - A2A
        - OpenTelemetry：原生内置，支持生成结构化的trace和span，如agent调用链(模型延迟/工具执行/错误定位)
     1. 能力
        - 工作流
          1. Agents、Tools、Functions作为工作流图中的节点
        - agent
          1. llmagent.config暴露subagents、description、disallowTransferToParent/peers字段
          1. AgentTool：将子agent包装为工具，父agent显式调用
          1. InvocationContext 状态共享
        - 多agent模式：8种设计模式
          1. Sequential Pipeline：顺序流水线，最基础的模式，按列表声明顺序线性执行，如提取、解析、提取、生成
             - 会共享session state
          1. Coordinator/Dispatcher：调度器，中央agent指挥，如客服系统
             - 也叫Agent Transfer、Dynamic Routing、LLM-Driven Delegation
             - AutoFlow
               1. 父agent配置subagents列表，框架基于子agent的description做llm驱动的任务委派（agent transfer）
          1. Parallel Fan-Out：并行扇出，多个agent同时执行不相关的任务，最后聚合结果。如代码审查中安全审计、风格检查、性能分析三个Agent同时跑，最后结果汇总
          1. Hierarchical Decomposition：层次分解，复杂任务被分解为子任务，子任务再分解为更小的子任务。像套娃一样层层递进。如研究报告
          1. Generator and Critic：生成器与评审者，一个生成内容，另一个审查，不通过就打回去重来。如SQL生成，包含生成器和评审器
          1. Iterative Refinement：迭代优化，类似生成器-评审者，不是"通过/不通过"的二分法，而是"不够好，再改进一点"的渐进优化。如文案优化
          1. Human-in-the-Loop：人机协作，高风险操作、未确定事项
            ```go
            myTool, _ := functiontool.New(functiontool.Config{
                Name:                "delete_database",
                Description:         "Deletes a production database instance.",
                RequireConfirmation: true, // 触发 HITL 审批流程
            }, deleteDBFunc)
            ```
          1. Composite：组合模式，以上模式的组合
        - model-agnostic：gemini特定优化，支持任何llm
          1. agnostic：与某个具体实现无关
        - Plugin系统
          1. Retry and Reflect：自修复插件系统，这个插件可以拦截工具调用的错误，模型根据反馈调整参数，重新调用
            ```go
            r, _ := runner.New(runner.Config{
                Agent: myAgent,
                SessionService: mySessionService,
                PluginConfig: runner.PluginConfig{
                    Plugins: []*plugin.Plugin{
                        // 工具调用失败时，自动反思并重试3次
                        retryandreflect.MustNew(retryandreflect.WithMaxRetries(3)),
                        // 集中记录每个turn的日志
                        loggingplugin.MustNew(""),
                    },
                },
            })
            ```
     1. 示例
        ```go
        func main() {
            ctx := context.Background()

            model, err := gemini.NewModel(ctx, "gemini-flash-latest", &genai.ClientConfig{
                APIKey: os.Getenv("GOOGLE_API_KEY"),
            })
            if err != nil {
                log.Fatalf("Failed to create model: %v", err)
            }

            timeAgent, err := llmagent.New(llmagent.Config{
                Name:        "hello_time_agent",
                Model:       model,
                Description: "Tells the current time in a specified city.",
                Instruction: "You are a helpful assistant that tells the current time in a city.",
                Tools: []tool.Tool{
                    geminitool.GoogleSearch{},
                },
            })
            if err != nil {
                log.Fatalf("Failed to create agent: %v", err)
            }

            config := &launcher.Config{
                AgentLoader: agent.NewSingleLoader(timeAgent),
            }

            l := full.NewLauncher()
            if err = l.Execute(ctx, config, os.Args[1:]); err != nil {
                log.Fatalf("Run failed: %v\n\n%s", err, l.CommandLineSyntax())
            }
        }
        ```
   - langchaingo
     1. 认识：生态组件最广，维护已显著放缓，2025年10月最后一次release，2023年2月创建，历史最久
   - genkit：google的开源ai应用框架，和google生态绑定比较紧密
   - deer-go：deer-flow的go移植版，基于eino。`https://github.com/cloudwego/eino-examples/blob/main/flow/agent/deer-go/README.md`
1. airflow
   - 认识：Apache Airflow，代码优先的编排、调度和监控工作流的开源平台，纯python代码定义DAGs的编程模式
     1. 调度能力极其强大，是n8n、dify等？？？
   - 概念
     1. DAG：有向无环图
        - Task：任务，一个节点
     1. Pregel：有环有向图
     1. Operator：单个任务操作
     1. Scheduler：调度器，执行工作流
1. AutoGPT
   - 认识：能够利用llm的能力，自主决策并生成结果的ai智能体的开源项目，是ReAct一个非常强大和自动化的实现，python写的，autoGPT风格
   - 特点
     1. 自主性：只需要给出一个高级别的、模糊的目标，就会自动分解成一系列子任务并尝试完成，无需用户的任何干预
     1. 自我提示：会自己给自己生成提示，驱动ReAct循环。会思考“为了达成最终目标，我现在应该先做什么？”
     1. 多模态和能力：集成多种工具
     1. 记忆管理：解决llm的有限上下文窗口问题，引入了向量数据库等外部记忆体
1. MetaGPT
   - 认识：将llm的能力与标准化软件工程流程（SOP）相结合的开源的多智能体框架，适用于交付代码、文档、设计图等，类似ChatDev
     1. 将SOP编码为提示词、模块化输出验证
     1. 预定义严格流程（产品经理→架构师→工程师）
1、 HuggingGPT
   - 认识：用一个中心llm来协调调用众多专家模型(其他领域的模型)共同完成复杂任务的系统框架。侧重多模态
     1. JARVIS是开源的代码实现，微软和浙江大学
1. CrewAI
   - 认识：角色化多个智能体的开源的ai编排平台，侧重于解决特定任务，如分析报告、决策，适用于股票分析、内容创作、研究自动化等业务流程，python
1. AutoGen
   - 认识：类似HuggingGPT，微软、python，生产上是实验性质的
1. deer-flow
   - 认识：字节开源的从深度研究工具变成超级agent框架，python写的，基于langChain
     1. 倾向多agent协作，类比manus和hermes(单agent深度工作)
   - 功能
     1. 长时间运行的任务：计划和子任务
     1. 上下文工程：长时记忆/短时记忆
     1. 带文件系统的沙箱：像真正的电脑
     1. 技能和工具的扩展性
1. wiki
   - java：DJL Deep Java Library，是java的开源的深度学习库
     1. LangChain4j：最活跃、最受关注的AI应用开发框架
     1. Spring AI
     1. Spring Cloud Alibaba AI
   - semantic kernel：用于自然语言处理和信息检索的技术。微软研发的一个开源的、面向大模型的开发框架、SDK，深度集成微软生态，类似langChain
     1. 应用场景
        - 问答系统：用户可以从可信的源文档（如公司内部文档）中提问并获得答案
        - 聊天和会话创建：开发者可以使用Semantic Kernel构建聊天机器人，实现自动化的问答和对话功能
        - 数据处理：包括结构化和非结构化数据的处理，如分析产品反馈情绪、分析支持电话和记录等
        - 代码生成或转换：例如，将一种编程语言转换为另一种，为函数生成文档字符串等
        - 新闻内容创作：用于创建新的新闻内容或重写用户提交的新闻内容，作为预定义主题的写作辅助
##### LangChain
1. LangChain
   - 认识：用于语言模型和应用程序开发的开源框架，简化与LLMs的交互，整合数据检索和功能模块，从而构建端到端的应用程序，由Lang.AI开发，2022年10月首次提交
   - 功能
     1. 模型集成：支持OpenAI的GPT系列、Google的LaMDA、Meta的LLaMa等
     1. 数据集成：提供如文件、数据库、搜索引擎等数据源集成的能力
     1. 链式调用：创建一系列可以顺序执行的语言模型调用和其他操作的链
     1. 提供上下文感知与逻辑推理：允许开发者将多个预训练模型进行联合推理
     1. 预制链与组件：包含大量预制链和组件，方便开发
   - 项目
     1. langchain-ChatGLM
        - 认识：利用ChatGLM-6B + langchain实现的基于本地知识的问答机器人，如淘宝衣服尺寸机器人
        - 架构：![](../images/langchain-ChatGLM-struct.webp)
1. LangGraph
   - 认识：复杂工作流的编排引擎。构建具有循环和状态的复杂的多步骤llm应用程序的库，基于langChain构建，弥补传统链chain的不足，采用了有向图graph的概念。2024年初推出
   - 功能
     1. 多角色协作：让一个llm扮演“作家”，另一个扮演“校对员”
     1. 循环和条件判断：根据llm的输出决定下一步做什么（例如：“这个答案足够好了吗？不行就重写”）
     1. 保持状态：在多个步骤中维护和更新一个共享的上下文，如对话历史、中间结果
   - 组成
     1. graph：图，由节点和边组成，表示整个工作流的结构
     1. nodes：节点，图中的每个节点是一个函数或一个可运行单元（如调用一次llm、执行一个工具）
     1. edges：边，连接节点的线，表示节点之间的依赖关系
     1. state：状态，即上下文，表示工作流在某个时刻的具体情况，包括变量值、上下文等信息
1. LlamaIndex
   - 认识：帮助llm高效连接外部数据的数据框架，用于构建agent、rag、workflow等ai应用  
   - 功能
     1. 数据连接器：Data Connectors，各种数据源
        - 本地文件：pdf/word/ppt
        - 数据库：sql/nosql
        - 向量数据库：milvus/pinecone
        - 云存储
        - saas：notion/slack/discord/github等
     1. 索引：将加载的非结构化或结构化数据转换成一种易于LLM查询的优化格式，将数据分割成块chunks，并创建向量嵌入embeddings，存储在向量数据库中，实现快速、准确的语义搜索
     1. 检索：Retriever，提供一个自然的语言接口来向你索引的数据提问。它接收你的问题，在索引中检索最相关的上下文信息，然后将“问题+上下文”一起组装成一个提示prompt发送给LLM，从而得到一个基于你私有数据的准确回答
     1. query engine：自动组合retriever、prompt交给llm
     1. agent能力
##### Eino
1. Eino
   - 字节开源的Golang的AI应用开发框架
     1. 明确的组件定义
     1. 强大的流程编排功能
   - 功能
     1. 对话与交互类：ChatModel组件，构建多轮对话系统，结合模板功能动态生成提示词、流式输出等
        - 利用角色定义和prompt模板，如fstring、jinja2
     1. 数据处理与自动化：将用户自然语言转换为结构化查询条件，如解析为数据库查询参数
        - 实现
          1. DataOperator组件：核心，数据处理
          1. Tool组件：BindTools绑定外部工具，如数据库、爬虫、OCR服务
          1. 流程编排
     1. 扩展与集成能力：bindtools绑定外部api或自定义函数
     1. 复杂逻辑编排：ReAct智能体通过graph编排实现自主决策，如模型判断是否调用工具（如天气查询api），并将工具结果作为下一轮输入，形成循环推理链，以及是否及时中断等

     1. RAG：结合向量化知识库，通过语义检索召回相关信息，增强模型回答的准确性
        - 文档加载器和检索器组件
     1. 内容生成、多模态：multicontent字段
   - 组成
     1. 基础组件
        - ChatModel：与大模型交互，输入Message上下文，得到模型的输出Message
          1. DataOperator
             - StreamOperator：流式数据支持     
          1. ChatTemplate：接收外界输入，转化成预设格式的prompt交给模型
     1. 工具
        - Tool：与世界交互的工具，根据模型的输出，执行对应的动作
        - Lambda：用户定制function
     1. 流程编排
        - chain
        - graph
     1. RAG
        - Embedding：将文本转为向量，即捕获文本语义，Retriever和Indexer的共同依赖
        - Indexer：存储文本并建立向量索引
        - Retriever：从向量数据库中查询
        - Transformer：用于文档转换和处理的组件，如分割、过滤、合并等
        - Loader：加载指定文本
     1. EinoDev插件：辅助开发的可视化工具，用于快速生成和验证，支持调试
        - 使用步骤
          1. 编辑器安装插件
          1. 新建Graph编排，增加编排内容
          1. 导出为代码
     1. CozeLoop插件
        - 痛点
          1. 运行流程黑盒：无法清晰了解模型具体的运行逻辑；采用callback模式查看日志过于原始过于繁琐；相同输入内部graph走的逻辑和节点可能完全不同
          1. 迭代和评估异常原始：修改prompt、RAG语料、编排，数据都无法回收，进行筛选清洗重运用
          1. prompt没有版本管理
   - 高级功能
     1. Compose：声明式地组合多个组件或逻辑单元，构建数据处理流程。将独立模块（如模型调用、工具执行、数据处理）串联成可复用的任务流水线
        - Compose快速组合线性/简单分支逻辑，Graph处理复杂拓扑（循环、多分支）
     1. 并发处理、扇入扇出、通用横切面、option分配
1. 基础组件
   - 类型定义
     1. `schema.Message{}`：和llm交互的消息，包含了system、assistant、user、tool四种类型
     1. `schema.MultiContent{}`：多模态内容，包含Text、ImageURL
   - 接口
     1. BaseChatModel接口
        - `Generate(ctx context.Context, input []*schema.Message, opts ...Option) (*schema.Message, error)`：普通输出模式方法
        - `Stream(ctx context.Context, input []*schema.Message, opts ...Option) (*schema.StreamReader[*schema.Message], error)`：流式输出模式方法
     1. ChatModel接口：废弃，使用ToolCallingChatModel接口
     1. ToolCallingChatModel接口
        - `BaseChatModel{}`：组合基础chatModel接口
        - `WithTools(tools []*schema.ToolInfo) (ToolCallingChatModel, error)`：绑定工具
1. Tool组件
   - 认识：通过调用外部工具来扩展模型能力的组件
     1. 适用场景：访问外部数据库、执行计算任务、调用API等
   - 类型定义
     1. `schema.ToolInfo{}`：工具信息，包含Name、Desc、*ParamsOneOf
        - Name：工具名称，唯一标识
        - Desc：工具描述，告诉模型如何/何时/为什么使用这个工具，可以在描述中包含少量示例
        - *ParamsOneOf：支持两种方式描述
          1. 使用ParameterInfo：`schema.NewParamsOneOfByParams(params)`
          1. 使用OpenAPIV3：`schema.NewParamsOneOfByOpenAPIV3(openAPIV3)`
   - 接口
     1. BaseTool接口：基础工具接口，提供工具信息
        - `Info(ctx context.Context) (*schema.ToolInfo, error)`
     1. InvokableTool接口：同步执行工具
        - `BaseTool`
        - `InvokableRun(ctx context.Context, argumentsInJSON string, opts ...Option) (string, error)`
     1. StreamableTool接口：流式执行工具
        - `BaseTool`
        - `StreamableRun(ctx context.Context, argumentsInJSON string, opts ...Option) (*schema.StreamReader[string], error)`
   - 实例
     1. 调用本地函数
        ```go
        type Game struct {
            Name string `json:"name"`
            Url  string `json:"url"`
        }
        type InputParams struct {
            Name string `json:"name" jsonschema:"description=the name of game"`
        }

        // CreateTool 创建一个获取游戏网址的工具
        func CreateTool() tool.InvokableTool {
            getGameTool := utils.NewTool(&schema.ToolInfo{
                Name: "get_game",
                Desc: "get a game url by name",
                ParamsOneOf: schema.NewParamsOneOfByParams(
                    map[string]*schema.ParameterInfo{
                        "name": &schema.ParameterInfo{
                            Type:     schema.String,
                            Desc:     "game's name",
                            Required: true,
                        },
                    },
                ),
            }, GetGame)
            return getGameTool
        }
        // GetGame 根据游戏名称返回对应的游戏网址
        func GetGame(_ context.Context, params *InputParams) (string, error) {
            GameSet := []Game{
                {Name: "原神", Url: "https://ys.mihoyo.com/tool"},
                {Name: "鸣潮", Url: "https://mc.kurogames.com/tool"},
                {Name: "明日方舟", Url: "https://ak.hypergryph.com/tool"},
            }
            for _, game := range GameSet {
                if game.Name == params.Name {
                    return game.Url, nil
                }
            }
            return "", nil
        }
        ```
     1. 调用浏览器
        ```go
        func main() {
            ctx := context.Background()
            but, err := browseruse.NewBrowserUseTool(ctx, &browseruse.Config{})
            if err != nil {
                log.Fatal(err)
            }

            url := "https://www.google.com"
            result, err := but.Execute(&browseruse.Param{
                Action: browseruse.ActionGoToURL,
                URL:    &url,
            })
            if err != nil {
                log.Fatal(err)
            }
            fmt.Println(result)
            time.Sleep(10 * time.Second)
            but.Cleanup()
        }
        ```
1. prompt模板
   - 接口
     1. ChatTemplate接口
        - `Format(ctx context.Context, vs map[string]any, opts ...Option) ([]*schema.Message, error)`：格式化模版
   - 实现结构体
     1. DefaultChatTemplate：默认的ChatTemplate实现
        - 组成
          1. `templates []schema.MessagesTemplate`：模板列表
          1. `formatType`：模板类型，如FString、GoTemplate、Jinja2
        - 方法
          1. `Format(ctx context.Context, vs map[string]any, opts ...Option) ([]*schema.Message, error)`：格式化模版
   - 方法
     1. `FromMessages(formatType schema.FormatType, templates ...schema.MessagesTemplate) *DefaultChatTemplate`：创建默认的ChatTemplate
   - 功能
     1.  动态变量填充：将上下文数据（如用户输入、历史对话）自动插入模板
     1.  多格式支持：兼容FString（Python 风格）、Jinja2（逻辑控制）等模板引擎
     1.  角色定义：为模型设定行为风格（如客服、编程助手）
     1.  工具描述集成：在ReAct模式中，自动生成工具调用指令
   - 模版
     1.  FString：Formatted String Literals。简洁的 {variable} 占位符，适合简单插值，python v3.6+引入的字符串格式化方式，允许在字符串中直接嵌入表达式（变量、运算、函数调用等），使代码更简洁直观
        ```go
        template := prompt.FromMessages(schema.FString,
            schema.SystemMessage("你是一个{role}"),
            &schema.Message{
                Role:    schema.User,
                Content: "请帮帮我，史瓦罗先生，{task}",
            },
        )
        params := map[string]any{
            "role":        "机器人史瓦罗先生",
            "task":        "写一首诗",
        }
        messages, err := template.Format(ctx, params)
        ```
     1.  Jinja2：支持条件判断、循环等逻辑的适合复杂场景的模板引擎
        ```python
        {% if user.role == "vip" %}             # 逻辑判断是控制块 {% %}
        尊贵的VIP用户，您的问题已优先处理：
        {{ user_input }}                        # 变量是表达式 {{ }}
        {% else %}
        您好，您的问题正在处理中：
        {{ user_input }}
        {% endif %}
        ```
   - 功能
     1. 模板继承
        ```jinja2
        {% extends "base_prompt.j2" %}
        {% block content %}用户问题: {{input}}{% endblock %}
        ```
     1. 自动变量补全：`{{time|default:"2024-07-15"}}`
     1. 多模态支持：`![image]({{image_url}})`
1. RAG
   - 类型定义
     1. `schema.Document{}`：文档，包含ID、Content、MetaData
   - 接口
     1. Embedder接口
        - `EmbedStrings(ctx context.Context, texts []string, opts ...Option) ([][]float64, error)`：将文本切片转换为向量
     1. Indexer接口
        - `Store(ctx context.Context, docs []*schema.Document, opts ...Option) (ids []string, err error)`：用于存储文档(包括文本和向量值)的组件
     1. Retriever接口
        - `Retrieve(ctx context.Context, query string, opts ...Option) ([]*schema.Document, error)`：用于检索文档
     1. Transformer接口
        - `Transform(ctx context.Context, src []*schema.Document, opts ...TransformerOption) ([]*schema.Document, error)`：用于转换文档
   - 认识
     1. 支持的向量数据库：milvus、es8、redis
     1. Transformer官网还有很多例子，可以参考使用
     1. 整体的实例可以看stage6
   - 实例
     1. NewEmbedder
        ```go
        func EmbedText() {
            ctx := context.Background()

            // 初始化嵌入器
            timeout := 30 * time.Second
            embedder, err := ark.NewEmbedder(ctx, &ark.EmbeddingConfig{
                APIKey:  os.Getenv("ARK_API_KEY"),
                Model:   os.Getenv("EMBEDDER"),                                 // 使用的嵌入模型，决定了生成的向量即变量embeddings的长度
                Timeout: &timeout,
            })
            if err != nil {
                panic(err)
            }

            // 生成文本向量
            texts := []string{
                "这是第一段示例文本",
                "这是第二段示例文本",
            }
            embeddings, err := embedder.EmbedStrings(ctx, texts)
            if err != nil {
                panic(err)
            }

            // 使用生成的向量
            for i, embedding := range embeddings {
                println("文本", i+1, "的向量维度:", len(embedding))
            }
            // 如2560个浮点数的向量
            fmt.Println(embeddings)
        }
        ```
     1. Indexer
        ```go
        import (
            cli "github.com/milvus-io/milvus-sdk-go/v2/client"
        )

        var MilvusCli cli.Client
        // 初始化客户端
        func InitClient() {
            ctx := context.Background()
            client, err := cli.NewClient(ctx, cli.Config{
                Address: "localhost:19530",
            })
            if err != nil {
                log.Fatalf("Failed to create client: %v", err)
            }
            MilvusCli = client
        }

        var collection = "AwesomeEino"                                      // 集合名
        var fields = []*entity.Field{                                       // 定义字段，包括主键id、向量字段vector、文本内容content、元数据metadata
            {
                Name:     "id",
                DataType: entity.FieldTypeVarChar,
                TypeParams: map[string]string{
                    "max_length": "255",
                },
                PrimaryKey: true,
            },
            {
                Name:     "vector", // 确保字段名匹配
                DataType: entity.FieldTypeBinaryVector,
                TypeParams: map[string]string{
                    "dim": "81920",
                },
            },
            {
                Name:     "content",
                DataType: entity.FieldTypeVarChar,
                TypeParams: map[string]string{
                    "max_length": "8192",
                },
            },
            {
                Name:     "metadata",
                DataType: entity.FieldTypeJSON,
            },
        }

        func IndexerRAG() {
            ctx := context.Background()
            // 初始化嵌入器
            timeout := 30 * time.Second
            embedder, err := ark.NewEmbedder(ctx, &ark.EmbeddingConfig{
                APIKey:  os.Getenv("ARK_API_KEY"),
                Model:   os.Getenv("EMBEDDER"),
                Timeout: &timeout,
            })
            if err != nil {
                panic(err)
            }

            indexer, err := milvus.NewIndexer(ctx, &milvus.IndexerConfig{           // 创建索引器
                Client:            MilvusCli,
                Collection:        collection,
                Fields:            fields,
                Embedding:         embedder,
                DocumentConverter: floatDocumentConverter,
            })
            if err != nil {
                log.Fatalf("Failed to create indexer: %v", err)
            }

            docs := []*schema.Document{
                {
                    ID:      "1",
                    Content: "你说得对。但是原神是一款二次元开放大世界游戏",
                    MetaData: map[string]any{
                        "author": "木乔",
                    },
                },
            }

            ids, err := indexer.Store(ctx, docs)                                    // 保存
            if err != nil {
                log.Panicf("Failed to store documents: %v", err)
            }

            log.Printf("Stored documents with IDs: %v", ids)
        }
        ```
     1. Retriever
        ```go
        retriever, err := milvus.NewRetriever(ctx, &milvus.RetrieverConfig{
            Client:            MilvusCli,                                               // 引入上边的milvus连接
            Collection:        "AwesomeEino",
            Partition:         nil,
            VectorField:       "vector",
            OutputFields: []string{
                "id",
                "content",
                "metadata",
            },
            TopK:      1,
            Embedding: embedder,                                                        // 引入上边的embedder
        })
        if err != nil {
            panic(err)
        }

        results, err := retriever.Retrieve(ctx, "原神")
        if err != nil {
            panic(err)
        }
        ```
     1. Transformer
        ```go
        // 一个分割的例子
        // go get github.com/cloudwego/eino-ext/components/document/transformer/splitter/markdown
        splitter, err := markdown.NewHeaderSplitter(ctx, &markdown.HeaderConfig{            // 初始化分割器
            Headers: map[string]string{
                "#":   "h1",
                "##":  "h2",
                "###": "h3",
            },
            TrimHeaders: false,
        })
        if err != nil {
            panic(err)
        }

        // 准备要分割的文档
        content, err := os.OpenFile("./document.md", os.O_CREATE|os.O_RDWR, 0755)           // 对一个md文件进行分割
        if err != nil {
            panic(err)
        }
        defer content.Close()
        bs, err := os.ReadFile("./document.md")
        if err != nil {
            panic(err)
        }
        docs := []*schema.Document{
            {
                ID:      "doc1",
                Content: string(bs),
            },
        }

        // 执行分割
        results, err := splitter.Transform(ctx, docs)
        if err != nil {
            panic(err)
        }

        // 处理分割结果
        for i, doc := range results {
            println("片段", i+1, ":", doc.Content)
            println("标题层级：")
            for k, v := range doc.MetaData {
                if k == "h1" || k == "h2" || k == "h3" {
                    println("  ", k, ":", v)
                }
            }
        }
        ```
1. 流程编排
   - 节点
     1. Lambda：用户自定义节点
   - 特性
     1. 横切：使用callback在节点前后插入逻辑、通用逻辑(日志、监控、错误处理等)
     1. state：全局状态、节点间共享状态
   - 实现分类
     1. chain：线性执行多个数据处理步骤，链式有向图，始终向前
     1. graph：有向图，有最大的灵活性，通过可视化节点（如分支、循环）实现复杂条件逻辑
   - 实现步骤
     1. 注册链条/图
     1. 编写节点
     1. 编写分支
     1. 加入节点
        - model节点放在最后，用于接收前边的分支结果，或者放在中间用于判断输出
     1. 节点连接
     1. 编译运行
   - 图编排
     1. 组成
        - 节点：node，`AddChatModelNode/AddLambdaNode/AddGraphNode`
        - 分支：branch，节点之间的分支关系，用于连接不同的节点，用分支连接就不用边来连接了，`AddBranch`
        - 边：edge，节点之间的关系，`AddEdge`
     1. 高级特性
        - state：全局状态各节点共享，eino框架会在所有读写state的位置加锁。`compose.WithGenLocalState`
          1. 作用
             - 跨节点数据共享：存入state用作记忆功能
             - 添加一些配置：如maxStep最大步数，限制模型反复思考的次数
          1. 使用场景
             - 节点执行前读写：`StatePreHandler/StreamStatePreHandler `
             - 节点执行后读写：`StatePostHandler/StreamStatePostHandler`
        - callback：在固定的时机，把自己是谁(runInfo)，以及当时发生了什么(input/output)传出去，横切点思路，不影响主流程
          1. 作用：汇报、打印、日志记录
          1. 使用：`callbacks.NewHandlerBuilder().OnStartFn/OnEndFn().Build()`
        - 图嵌套：图编排产物runnable与lambda的接口形式非常相似，因此编译好的图可以简单的封装为lambda，并以lambda节点的形式嵌套进其他图中，实现上就是保持上下游类型对齐
   - 实例
     1. Lambda节点、简单的chain
        ```go
        // 初始化模型
        model, err := ark.NewChatModel(ctx, &ark.ChatModelConfig{
            APIKey:  os.Getenv("ARK_API_KEY"),
            Model:   "doubao-1.5-pro-32k-250115",
            Timeout: &timeout,
        })
        if err != nil {
            panic(err)
        }

        //编写lambda节点
        lambda := compose.InvokableLambda(func(ctx context.Context, input string) (output []*schema.Message, err error) {
            desuwa := input + "回答结尾加上desuwa"
            output = []*schema.Message{
                {
                    Role:    schema.User,
                    Content: desuwa,
                },
            }
            return output, nil
        })

        // 注册链条
        chain := compose.NewChain[string, *schema.Message]()
        // 连接起各个节点
        chain.AppendLambda(lambda).AppendChatModel(model)

        // 编译
        r, err := chain.Compile(ctx)
        if err != nil {
            panic(err)
        }
        // 执行
        answer, err := r.Invoke(ctx, "你好，请告诉我你的名字")
        if err != nil {
            panic(err)
        }
        fmt.Println(answer.Content)
        ```
     1. 使用工具的简单的链式agent
        ```go
        func SimpleAgent() {
            ctx := context.Background()
            // 创建工具
            getGameTool := CreateTool()
            // 大模型的回调函数
            modelHandler := &callbackHelpers.ModelCallbackHandler{
                OnEnd: func(ctx context.Context, info *callbacks.RunInfo, output *model.CallbackOutput) context.Context {
                    // 1. output.Result 类型是 string
                    fmt.Println("模型思考过程为：")
                    fmt.Println(output.Message.Content)
                    return ctx
                },
            }
            // 工具的回调函数
            toolHandler := &callbackHelpers.ToolCallbackHandler{
                OnStart: func(ctx context.Context, info *callbacks.RunInfo, input *tool.CallbackInput) context.Context {
                    fmt.Printf("开始执行工具，参数: %s\n", input.ArgumentsInJSON)
                    return ctx
                },
                OnEnd: func(ctx context.Context, info *callbacks.RunInfo, output *tool.CallbackOutput) context.Context {
                    fmt.Printf("工具执行完成，结果: %s\n", output.Response)
                    return ctx
                },
            }
            // 构建实际回调函数Handler
            handler := callbackHelpers.NewHandlerHelper().
                ChatModel(modelHandler).
                Tool(toolHandler).
                Handler()
            
            // 初始化模型
            timeout := 30 * time.Second
            model, err := ark.NewChatModel(ctx, &ark.ChatModelConfig{
                APIKey:  os.Getenv("ARK_API_KEY"),
                Model:   "doubao-1.5-pro-32k-250115",
                Timeout: &timeout,
            })
            if err != nil {
                panic(err)
            }

            // 绑定工具
            info, err := getGameTool.Info(ctx)
            if err != nil {
                panic(err)
            }
            infos := []*schema.ToolInfo{
                info,
            }
            err = model.BindTools(infos)
            if err != nil {
                panic(err)
            }

            // 创建tools节点
            ToolsNode, err := compose.NewToolNode(context.Background(), &compose.ToolsNodeConfig{
                Tools: []tool.BaseTool{
                    getGameTool,
                },
            })
            if err != nil {
                panic(err)
            }
            // 创建完整的处理链
            chain := compose.NewChain[[]*schema.Message, []*schema.Message]()
            chain.
                AppendChatModel(model, compose.WithNodeName("chat_model")).
                AppendToolsNode(ToolsNode, compose.WithNodeName("tools"))

            // 编译
            agent, err := chain.Compile(ctx)
            if err != nil {
                log.Fatal(err)
            }
            // 运行
            resp, err := agent.Invoke(ctx, []*schema.Message{
                {
                    Role:    schema.User,
                    Content: "请告诉我原神的URL是什么",
                },
            }, compose.WithCallbacks(handler))
            if err != nil {
                log.Fatal(err)
            }

            // 输出结果
            for _, msg := range resp {
                fmt.Println(msg.Content)
            }
        }
        ```
     1. 使用一个分支的图编排
        ```go
        func OrcGraphWithCallback(ctx context.Context, input map[string]string) {
            g := compose.NewGraph[map[string]string, *schema.Message](
                compose.WithGenLocalState(genFunc),
            )
            lambda := compose.InvokableLambda(func(ctx context.Context, input map[string]string) (output map[string]string, err error) {
                //在节点内部处理state
                _ = compose.ProcessState[*State](ctx, func(_ context.Context, state *State) error {
                    state.History["tsundere_action"] = "我喜欢你"
                    state.History["cute_action"] = "摸摸头"
                    return nil
                })
                if input["role"] == "tsundere" {
                    return map[string]string{"role": "tsundere", "content": input["content"]}, nil
                }
                if input["role"] == "cute" {
                    return map[string]string{"role": "cute", "content": input["content"]}, nil
                }
                return map[string]string{"role": "user", "content": input["content"]}, nil
            })
            TsundereLambda := compose.InvokableLambda(func(ctx context.Context, input map[string]string) (output []*schema.Message, err error) {
                _ = compose.ProcessState[*State](ctx, func(_ context.Context, state *State) error {
                    input["content"] = input["content"] + state.History["tsundere_action"].(string)
                    return nil
                })
                return []*schema.Message{
                    {
                        Role:    schema.System,
                        Content: "你是一个高冷傲娇的大小姐，每次都会用傲娇的语气回答我的问题",
                    },
                    {
                        Role:    schema.User,
                        Content: input["content"],
                    },
                }, nil
            })

            CuteLambda := compose.InvokableLambda(func(ctx context.Context, input map[string]string) (output []*schema.Message, err error) {
                return []*schema.Message{
                    {
                        Role:    schema.System,
                        Content: "你是一个可爱的小女孩，每次都会用可爱的语气回答我的问题",
                    },
                    {
                        Role:    schema.User,
                        Content: input["content"],
                    },
                }, nil
            })

            cutePreHandler := func(ctx context.Context, input map[string]string, state *State) (map[string]string, error) {
                input["content"] = input["content"] + state.History["cute_action"].(string)
                return input, nil
            }

            model, err := ark.NewChatModel(ctx, &ark.ChatModelConfig{
                APIKey: os.Getenv("ARK_API_KEY"),
                Model:  os.Getenv("MODEL"),
            })
            if err != nil {
                panic(err)
            }

            //注册节点
            err = g.AddLambdaNode("lambda", lambda)
            if err != nil {
                panic(err)
            }
            err = g.AddLambdaNode("tsundere", TsundereLambda)
            if err != nil {
                panic(err)
            }
            err = g.AddLambdaNode("cute", CuteLambda, compose.WithStatePreHandler(cutePreHandler))
            if err != nil {
                panic(err)
            }
            err = g.AddChatModelNode("model", model)
            if err != nil {
                panic(err)
            }

            //加入分支
            g.AddBranch("lambda", compose.NewGraphBranch(func(ctx context.Context, in map[string]string) (endNode string, err error) {
                if in["role"] == "tsundere" {

                    return "tsundere", nil
                }
                if in["role"] == "cute" {
                    return "cute", nil
                }
                return "tsundere", nil
            }, map[string]bool{"tsundere": true, "cute": true}))

            //链接节点
            err = g.AddEdge(compose.START, "lambda")
            if err != nil {
                panic(err)
            }
            err = g.AddEdge("tsundere", "model")
            if err != nil {
                panic(err)
            }
            err = g.AddEdge("cute", "model")
            if err != nil {
                panic(err)
            }
            err = g.AddEdge("model", compose.END)
            if err != nil {
                panic(err)
            }

            //编译
            r, err := g.Compile(ctx)
            if err != nil {
                panic(err)
            }
            //执行
            answer, err := r.Invoke(ctx, input, compose.WithCallbacks(genCallback()))
            if err != nil {
                panic(err)
            }
            fmt.Println(answer.Content)
        }

        func genCallback() callbacks.Handler {
            handler := callbacks.NewHandlerBuilder().OnStartFn(func(ctx context.Context, info *callbacks.RunInfo, input callbacks.CallbackInput) context.Context {
                fmt.Printf("当前%s节点输入:%s\n", info.Component, input)
                return ctx
            }).OnEndFn(func(ctx context.Context, info *callbacks.RunInfo, output callbacks.CallbackOutput) context.Context {
                fmt.Printf("当前%s节点输出:%s\n", info.Component, output)
                return ctx
            }).Build()
            return handler
        }
        ```
     1. 使用state
        ```go
        // 定义上下文状态结构体
        func genFunc(ctx context.Context) *State {
            return &State{
                History: make(map[string]any),
            }
        }

        // 初始化state
        g := compose.NewGraph[map[string]string, *schema.Message](
            compose.WithGenLocalState(genFunc),
        )

        // 使用state
        lambda := compose.InvokableLambda(func(ctx context.Context, input map[string]string) (output map[string]string, err error) {
            //在节点内部处理state
            _ = compose.ProcessState[*State](ctx, func(_ context.Context, state *State) error {
                state.History["tsundere_action"] = "我喜欢你"
                state.History["cute_action"] = "摸摸头"
                return nil
            })
            if input["role"] == "tsundere" {
                return map[string]string{"role": "tsundere", "content": input["content"]}, nil
            }
            if input["role"] == "cute" {
                return map[string]string{"role": "cute", "content": input["content"]}, nil
            }
            return map[string]string{"role": "user", "content": input["content"]}, nil
	    })
        ```
     1. 使用callback
        ```go
        func genCallback() callbacks.Handler {
            handler := callbacks.NewHandlerBuilder().OnStartFn(func(ctx context.Context, info *callbacks.RunInfo, input callbacks.CallbackInput) context.Context {
                fmt.Printf("当前%s节点输入:%s\n", info.Component, input)
                return ctx
            }).OnEndFn(func(ctx context.Context, info *callbacks.RunInfo, output callbacks.CallbackOutput) context.Context {
                fmt.Printf("当前%s节点输出:%s\n", info.Component, output)
                return ctx
            }).Build()
            return handler
        }
        ```
     1. ReAct的简单实现
        - 实现本质
          1. 通过prompt模板引导模型生成推理步骤，包含工具描述、推理步骤占位符等
          1. 通过graph的循环实现“行动结果→重新推理”的闭环
          1. 通过tool绑定提供可调用的外部能力，如api、数据库
        - 示例
            ```go
            // 核心实现
            请根据任务决定是否需要调用工具：
            问题: {{question}}
            可用工具:
            - 天气查询: 输入地点，返回天气数据
            - 订单查询: 输入订单号，返回状态
            逐步思考后，按格式响应：
            Thought: <推理步骤>
            Action: <工具名|null>                   # 方法<>
            ActionInput: <参数>             # 方法<># 参数<>


            // 1. 定义工具函数
            func fetchWeather(location string) string {
                // 模拟天气API调用
                return fmt.Sprintf(`{"location": "%s", "weather": "晴", "temp": 25}`, location)
            }

            // 2. ReAct Prompt模板（简化版）
            const reactPrompt = `
            请逐步思考并决定是否需要调用工具。可用工具：
            - get_weather(location): 查询天气

            当前任务: {{.input}}
            按格式响应：
            Thought: <思考步骤>
            Action: <get_weather|null>
            ActionInput: <参数>`

            func main() {
                // 3. 初始化Eino组件
                // 绑定工具
                weatherTool := eino.BindTool("get_weather", fetchWeather)
                
                // 创建ChatModel（加载ReAct模板）
                model := eino.ChatModel{
                    PromptTemplate: eino.NewPromptTemplate("react", reactPrompt, "jinja2"),
                    Tools:          []eino.Tool{weatherTool},
                }

                // 4. 构建ReAct Graph
                graph := eino.NewGraph().
                    AddNode("reason", model).                                                       // 推理节点
                    AddNode("act_weather", weatherTool).                                            // 工具节点
                    AddEdge("reason", "act_weather", eino.If(func(ctx eino.Context) bool {
                        // 条件边：当模型输出Action=get_weather时触发
                        return ctx.LastOutput().Action == "get_weather"
                    })).
                    AddEdge("act_weather", "reason", eino.OnSuccess())                              // 循环边：工具结果返回推理

                // 5. 执行任务
                input := "杭州明天适合穿什么？"
                result := graph.Run(input)
                fmt.Println("最终回答:", result.Text)
                
                /* 预期输出流程：
                1. 模型推理: Thought: 需要查询杭州天气 → Action: get_weather, ActionInput: 杭州
                2. 调用工具: fetchWeather("杭州") 返回天气数据
                3. 二次推理: Thought: 晴天25度建议穿短袖 → Action: null
                4. 输出结果: "杭州明天晴25°C，建议穿短袖"
                */
            }


            // ReAct Prompt模板（完整版，但是上边的代码用不了，因为返回的格式不一样）
            const reactPrompt = `
            # 角色与任务
            你是一个自主智能体（AI Agent），能够通过结合推理（Reasoning）和工具调用（Acting）解决复杂问题。请严格按以下步骤执行：

            # 可用工具
            {{tools}}
            {{#each tools}}
            - **{{this.name}}**: {{this.description}} 
            参数格式: {{this.parameters}}
            {{/each}}

            # 执行规则
            1. **逐步思考**：明确任务目标，拆解必要步骤。
            2. **工具调用**：若需外部数据或操作，选择合适工具并生成调用指令。
            3. **验证结果**：检查工具返回是否满足需求，必要时迭代。

            # 输出格式
            必须按以下格式响应，禁止缺失字段：
            \`\`\`json
            {
            "thought": "当前思考步骤和计划",
            "action": "工具名|null",
            "action_input": {"参数键": "参数值"} | null,
            "observation": "工具返回结果或用户输入补充",
            "final_answer": "最终回答（若无需工具）"
            }
            \`\`\`
            ```
1. ADK
   - 认识：Agent Development Kit，帮助构建、运行、管理agent的开发框架
   - 组成
     1. ChatModelAgent：“思考”部分，利用llm作为核心，理解自然语言，进行推理、规划、生成响应，并动态决定如何执行或使用哪些工具
     1. Workflow Agents：协调管理部分，基于预定义的逻辑，按照自身类型（顺序/并发/循环）控制子agent执行流程，产生确定性的，可预测的执行模式，不同于ChatModel Agent生成的动态随机的决策
     1. Supervisor Agent：监督者模式，一个supervisorAgent和多个subAgents，supervisorAgent控制所有通信流程和任务委托，并根据当前上下文和任务需求决定调用哪个agent
     1. Plan-Execute Agent：计划-执行模式，生成含多个步骤的计划，Execute Agent根据用户query和计划来完成任务。Execute后会再次调用Plan，决定完成任务/重新进行规划
        - 组成：Planner 规划器先规划步骤、Executor 执行器将结果汇总到Replanner 重规划器决定结束还是loop运行
     1. deepagents：基于chatmodelagent，开箱即用的agent方案
        - 能力
          1. 规划能力：通过write_todos进行任务拆解与进度跟踪
          1. 文件系统：提供read_file、write_file、edit_file、ls、glob、grep，用于读取和写入上下文
          1. shell访问：使用execute运行命令
          1. 子agent：通过task将工作委派给拥有独立上下文窗口的子智能体
          1. 智能默认配置：内置prompt，教模型如何高效使用这些工具
          1. 上下文管理：长对话历史自动摘要，大体量输出自动保存到文件
   - 结构
     1. 核心结构
        ```go
        type Agent interface {
            Name(ctx context.Context) string
            Description(ctx context.Context) string
            Run(ctx context.Context, input *AgentInput) *AsyncIterator[*AgentEvent]
        }
        ```
1. 实例
   - Hertz路由中处理SSE连接
    ```go
    eino.Get("/stream", func(c context.Context, ctx *app.RequestContext) {
        ctx.SetContentType("text/event-stream")
        for {
            data := getStreamData()                 // 从 Eino 流式节点获取数据
            ctx.SSEvent("message", data)            // 发送 SSE 事件
            ctx.Flush()                             // 立即推送至客户端
        }
    })
    ```
##### Goclaw
1. 认识
   - 对比Eino ADK
     1. Goclaw：偏执行器框架、agent runtime，专业的REPL+工具调度器
        - 诞生于小龙虾之后，架构上更先进，有控制台，能动态接入其他能力，是个完整的管理平台，eino的能力太少了
        - 有全部的源码可直接定制化
     1. Eino ADK：偏平台框架，帮把agent变成“可管理系统”的一整套工程体系，不是一个开放性的能接入更多能力的平台，包含了确定性的编排如graph/DAG/状态机
        - 其迭代直接从BaseChatModel/ToolCallingChatModel变为了ChatModelAgent，可见其落后性
1. 理解
   - 提示词是如何组装的：SOUL.md像“底座人格”，调用方system prompt像“本次会话的临时场景说明”
   - 流程
     1. 一次性的ContextStage
     1. 每次turn都执行一次的顺序是
        - PruneStage
        - ThinkStage
        - ToolStage：并行执行、沙箱执行
        - ObserveStage：结果整理器，它收集并发新消息、区分中间工具回复与最终回答、执行最终回答 Hook、决定是否需要再给模型一轮机会，并跨轮保存模型生成的图片；但它本身不直接控制流水线退出。
        - CheckpointStage：保存检查点，每5轮记入Session Store
     1. 一次性的FinalizeStage
   - HITL的实现是每次的ToolStage阶段的channel阻塞和唤醒，没有持久化机制，断电丢失，即没有调度器重新装载checkpoint，再恢复pipeline
   - Provider：对ds的支持还只是使用OpenAI兼容的API格式，并不支持ds新支持的Responses API格式
   - 窗口上下文大小管理
     1. 预算计算公式：上下文总窗口大小 - OverheadTokens 每次输入开销(System Message + Tool Schemas) - MaxTokens 为本轮模型回答预留的输出空间 - ReserveTokens 额外的安全缓冲空间(本地token计数与Provider实际计数存在偏差、在恰好贴近硬上限时发生溢出)
     1. 压缩规则：占用超过70%进行处理，默认5分钟的缓存时间 + 软裁剪 + 分层摘要
     1. 软裁剪：只处理较老、体积较大的 tool result，保留开头和结尾，删除中间
     1. llm压缩方法：少于6条不压缩，最少保留最近4条且30%的消息，调整切分点避免拆开tool_call、tool_result，然后进行前70%的分层摘要
        - 分层摘要：不同类型的消息分别进行压缩，user一个chunk，assistant一个chunk，assistant tool call+tool result一个chunk，最后所有chunk合并要压缩
   - 工具使用
     1. 沙箱：启动的时候判断docker命令是否存在，存在就用沙箱，不存在就不用
     1. filesystem 读工具
        - 四种职责
          1. 逻辑文件路由	    提示Context、Memory、System Prompt 虚拟文件直接从上下文读
          1. 权限与隔离	        多租户、team、group、delegation
          1. 存储后端	        宿主机文件系统、Docker FsBridge、数据库
          1. LLM输出适配	    二进制拒绝、分页、50K字符上限、错误提示
        - 路径检查：计算授权目录workspace，纵深检查路径是否在授权内
          1. 只能读文本文件，目录、symlink、socket、FIFO/命名管道、字符设备和块设备、hardlink文件不允许，防止永久阻塞、设备数据泄漏等
        - 命令规范：经过Unicode NFKC规范化、删除零宽字符，防止模型用全角字符、零宽字符拆开危险命令，从而绕过正则匹配
1. 设计不合理的地方
   - runGateway的wireExtras、registerAllMethods两个大方法，耦合了很多方面的业务，参数有七八个之多
   - 负责全局路由表的MethodRouter还负责了公共权限中间层、系统方法处理器，导致MethodRouter类型又循环引用了Server，形成了较强耦合
### AI编程
1. 理解
   - 代码理解的架构方式
     1. agent+全仓库工具链式的推理：动态代码探索，更进一步的agent模式写代码，比较费token。如claude code和codex
        - 特点
          1. 具备了agent的特点，即自动完成任务，是完成任务，而不仅仅是改代码
          1. 对整个项目的理解更深入：类似人一点点推理
        - 理解方式
          1. 长上下文推理
          1. 代码关系理解
          1. 递归分析
     1. 向量检索+代码理解：Hybrid Retrieval 多层检索架构。如cursor
        - 特点
          1. 需要不断指挥AI进行代码修改，，本质是AI原生IDE，AI更像一个智能工具而不是完全自动化的agent
          1. 10万行以上代码Claude Code理解能力会突然“碾压” Cursor：因为数据多了相似度会增加，向量检索都是废话了(历史代码多个版本)
        - 理解方式
          1. embedding search：向量检索，提供了快速定位相关代码的能力，但是向量索引 ≠ 深度理解
          1. keyword search：关键词/BM25搜索，通常会会同时跑这个搜索，如keyword search 关键字检索、regex search 正则查找、symbol search 符号查找
          1. symbol analysis：Symbol索引分析，用的AST
        - 目标：Cursor默认不会主动递归读取大量文件，因为这会增大延迟、token成本
          1. 低延迟
          1. 局部代码生成
          1. 编辑效率
     1. 未来趋势：Code Graph，把代码库变成“图”而不是“向量”
        - Symbol Index：符号索引，类似AST 抽象语法树、LSP 语言服务器这种构建代码理解
        - Embedding Search：快速的方法、函数定位
        - Agent：其一如像人一样一步步追代码
1. 怎么确保AI编程工程生成代码的质量
   - 理解：出发点是对AI低信任度，但是把AI产物纳入工程质量体系
   - 做法
     1. 第零层
        - 难任务使用plan模式：不要一上来就动代码
        - 长时间任务使用goal模式：要明确完成标准
     1. 第一层：做prompt约束
        - 提示词组成的标准：目标、上下文、约束、完成标准
        - 使用截图、粘贴原始需求：增加原始资料，你的转述是一个信息的有损管道
        - 对项目编写agent.md，明确项目偏好、目录结构、编码规范、异常处理、日志、单测要求等（项目层）
          1. AGENTS.md可以放在不同层级，越靠近当前目录的说明优先级越高
        - codex编辑config.toml的developer_instructions（全局层）
     1. 第二层：自动化工具检测
        - 静态扫描、lint、安全扫描
          1. agent会自动跑检查
             - go
               1. gofmt -w .：格式化
               1. go build ./...：编译检查
               1. go test ./...：单元测试
               1. golangci-lint run：lint检查
             - php
               1. php -l
               1. vendor/bin/phpunit
        - 编排agent对结果进行同步检查，重点是ai助手和人同时进行检查，输出可行结果
          1. 特点：又快又多一重保障，ai检查结果为辅，扫一眼就行，重点输出逻辑错误、隐患
          1. 实现：配置codex/cc的after_edit hook执行`./review.sh`，利用钩子让电脑界面弹出对话框人工确认是否执行检查，是的话让其二者互相检查，检查者输出一个报告即可
     1. 第三层：人工code review
        - 人工确认业务逻辑，保证自己知道业务逻辑，避免“ai写的，我也不知道，我得翻翻”
        - 重点看边界条件、事务一致性、并发安全、权限校验
     1. 第四层：充分测试
        - 单测：现在ai生成单测的成本太低了，而且主流编程工具默认生成单测，随着ai在项目中代码编写的占比提升，单测会越来越完善
        - 集成测试：跑起来环境，让ai自己查询db/redis/mq的结果、自己请求接口检查数据是否正确
          1. 实际踩过的坑：ai会生成了清除数据的测试脚本，导致自己清掉了测试环境的数据，工作上第一次这种低级错误丢人了
        - 回归测试：按需把所有的单测都跑一遍，考虑到每次修改的成本，在发布到测试环境时执行一次即可
        - 线上通过灰度、监控、回滚保证风险可控
1. 大型项目的ai编程
   - 爆上下文、跨几十个文件的改动
     1. 严重依赖一个好的起点context
     1. 并行subagent分摊独立任务
   - CLAUDE.md怎么写
   - lsp、skill、mcp怎么配
1. 最佳实践
   - 代码得一行一行过
     1. 业务逻辑得自己知道，是自己设计的，并且达到了自己的设计目标
     1. 测试用例正确、全面，不能有危险操作，如删库表
        - 如：任何操作包括编写测试用例，不要有删除数据库表的操作
   - 不同任务的调整
     1. 调整权限的检查方式：线上数据要一点点放行
     1. 调整推理强度，让项目该健壮的时候健壮，该快速的时候快速
   - 不要只看“生成了多少代码”，要看“节省了多少流程”
     1. 哪些重复任务被自动化了？
     1. 哪些测试、排查、修复流程变短了？
     1. 哪些内部工具可以通过插件共享给全团队？
     1. 哪些人已经把codex融入真实工作流？
     1. 哪些业务场景最适合做agent化改造？
#### 编程范式
1. 编码范式
   - vibe coding：草图、快速探索，可靠性、完整性不足
     1. 适合快速实现、小工具；商业项目慎用、关键系统不可靠
   - spec-driven：蓝图、规范执行
     1. 能够实现既定目标
1. 编程工作流
   - Spec-Kit
   - OpenSpec
   - Superpowers
     1. 认识：通过一组可组合的“技能”来约束ai行为，7个流程 + 14个技能 + 3条铁律，![](../images/ai/superpowers.png)
     1. 使用步骤
        - 安装：`/plugin install superpowers@superpowers-marketplace`
        - 编写需求文档
            ```
            docs/
                requirements/
                    用户管理.md
                    订单系统.md
                    权限模型.md

                architecture/
                    系统架构.md
                    微服务关系.md
                    RPC调用.md
            ```
        - 告诉agent在完成什么任务时，应该读哪些文档(不会主动读)
        - 写自己的skill，替代重复性工作
1. vibe coding
   - 认识：氛围编程，氛围指的是开发者想表达的整体意图、风格、上下文和目标，让AI在“理解氛围”的情况下生成代码。即不需要精确写每一行代码，而是描述想做什么+怎么感觉比较对
   - 基本组成
     1. 任务氛围：想要实现什么
     1. 技术氛围：技术栈、代码风格
     1. 项目上下文
1. spec-driven
   - spec
     1. 认识：Specification 规范，软件系统的详细行为描述，不仅是文档，是开发流程的核心驱动力
     1. 特点
        - 可执行性：可运行、可验证。如使用Gherkin语法编写的.feature文件(验收测试)，或OpenAPI/Swagger规范(可生成mock服务器和客户端)
        - 单一事实来源：开发/测试/文档/甚至部署配置都从这份spec生成或校验
        - 约定优先于实现：先明确系统应该做什么(spec)，再讨论怎么写代码(实现)
        - 人机可读：既让业务方、QA、开发者能理解业务规则，又能被工具自动解析
     1. Gherkin举例
        ```gherkin
        Feature: 用户登录
            Scenario: 正确密码
                Given 用户已注册
                When 用户输入正确密码
                Then 登录成功
        ```
     1. SDD：规范驱动开发
     1. BDD：行为驱动开发，是一套将spec落地为可执行验证的实践方法论，包含了协作流程+工具链，内容是如何编写、维护、验证这些行为描述，核心特征是spec必须可执行，包括了从需求到验收的整个过程
        - Given-When-Then模板：是BDD规范的核心编写格式，强制用统一的语法来描述行为
          1. Given：上下文/前置条件，设定场景开始前的状态，如“用户已注册且已登录”
          1. When：事件/动作，描述用户或系统执行的操作，如“用户将一件商品添加到购物车”
          1. Then：预期结果，描述操作后系统应该发生的、可观察的变化，如“购物车中的商品数量增加1”
   - 认识：规范驱动开发，在做任何事/生成任何代码之前，必须先通过结构化的文档明确需求、设计与任务。就是说话先于代码，之前是先有代码后有文档
     1. 在于其方法论本身非常强大
     1. 解决AI编程需求理解偏差及工程质量不高等核心痛点
     1. AI编程2.0时代的轮廓：一个由规范驱动、流程严谨、人机协同的全新开发模式。从“能用”到“好用”，再到“专业”的需求升级
     1. 主要实现路径是强化和标准化规范的编写与使用，提升ai协作的清晰度和质量
   - 理念设计
     1. 所有开发范式的底层都是同一条有损管道：从意图->表达->代码->行为，是结构性的必然
        - 把所有框架、工具、方法论剥掉，软件开发就一件事：人有意图，机器产生行为。中间是一条有损管道
        - 人脑里的意图天然带着大量隐性成分：偏好、经验、语境、审美、风险直觉。代码是形式化的、离散的。从连续到离散，信息必然损失
     1. SDD：用显式契约把损耗逼到可控位置，用一个外化产物重新接管意图
        - prompt是一次性指令，spec是可审计的责任链：SDD不消除损耗，世上没有无损管道。它做的事是让损耗可见、可审计、可归因
     1. spec的本质定义：对"可接受实现空间"的最小、可验证、可演进的显式编码
        - 概念组成
            ```
            | 关键词   | 为什么必须                                         | 反面
            | 最小充分 | 太松→歧义爆炸；太死→等于用自然语言写代码，维护成本爆炸    | 把 PRD 全文复制进 spec.md
            | 可验证   | 不能绝对判定对错的不是规格，是许愿                     | "界面要美观"、"性能要好"
            | 可演进   | 意图会变，规格要可diff/merge/delta                  | 写完就不碰的spec快照
            | 显式编码 | 隐性的留在脑里不叫spec，叫经验                        | "大家都知道这里要做幂等"
            ```
        - 结构组成
          1. L1锁方向：Why+What，做对的事
          1. L2锁路径：How，把事做对
        - 使用
          1. spec是心脏，但SDD是意图编码 + 产物传递 + 人审卡点的完整闭环
          1. 在prompt和code之间插入一层显式的、持久的、可验证的 spec
        - 理解
          1. 代码正在变便宜，意图正在变昂贵
          1. 没对齐L1就先拍L2：是ai coding最普遍的翻车模式
          1. "写给ai看的详细文档"是最大误解
   - 最佳实践
     1. AI时代软件开发的核心矛盾变了：不是写不出代码，是没人能证明代码是对的
        - 意图持有者和代码编写者的分离，是所有SDD问题的第一因
        - 未来工程师的稀缺能力不是写代码快，是把验收标准写得能被机器执行
     1. prompt用完即弃，spec可追溯/可审计/可回归
        - SDD的真正价值不是提升ai输出质量，是让"谁定义的正确性"这件事有据可查
        - 不能自动验证的spec注定会烂(跟技术文档一个命运)、没有闭环的spec跟PRD没区别(sdd不是给ai多写一份文档)：如能不能在CI里自动判定pass/fail
          1. 以前的"正确性参照"是写代码人的脑子；然后文档是给别人看的，不是给自己验证用的，现在意图持有者和代码编写者分离了
          1. 模型越强，能从更少的约束推断更多细节，spec的未来不是更详细的文档，是更锋利的约束。
          1. spec向可执行方向演进，现在是EARS句式，未来spec本身就是可执行的验证程序
          1. 模型变强后，ai辅助写、辅助维护spec，写spec的成本继续降低
     1. spec不是代码的真相，是意图的契约：试图当蓝图就会崩，一旦试图让spec描述所有实现细节，它就会比代码腐烂得更快
        - spec若比代码短，就必然省略了某些实现决策。反过来一份无损到能完整生成全部代码的spec，信息量不可能小于代码本身。那它就不是spec了，是一门新编程语言
        - spec聚焦L1意图(验收标准、业务约束、边界条件)，做到"最小且可验证"。L2细节交给模型，但verify oracle要能在它做错时抓住
     1. 什么时候应该直接写代码？什么时候写spec
        ```
        | 风险/复杂度                     | 最佳策略                | 为什么                                |
        |------------------------------ |------------------------|--------------------------------------|
        | 低（脚本、原型、内部工具）        | vibe coding            | spec 成本 > 收益，写了也没人维护          |
        | 中（功能迭代、CRUD）            | Plan Mode + 轻量 spec   | 一页 spec 锁住核心约束就够               |
        | 高（支付、权限、数据删除、合规）   | SDD 全流程              | 返工成本太高，必须迁移锁定                |
        ```
     1. 选工具不是选功能：是看你的控制链断在哪？？？
     1. 编码阶段提速10倍，端到端交付只快了13%，中间损耗在哪儿？
   - Spec Kit框架
     1. 认识：GitHub开发的命令行工具
     1. 设计
        - 多层编码-解码链：核心设计决策，把复杂任务拆成多个可审阶段，层层递进。每一层独立产物，可以单独审、单独改
          1. 优势：阶段多、可审性最强。从零建大项目时过程最稳——你总是知道"现在走到哪了、下一步是什么"
   - OpenSpec
     1. 认识：开源
        - spec跟代码一样是活产物，不维护就会死
     1. 设计
        - spec不是一次性快照，而是随系统一起活着的基线。每次变更是对基线的增量（delta），archive 回写让基线永远跟代码同步。
          1. 传递损耗小：proposal/delta/tasks，在同一上下文一次生成、聚合评审，不做多层翻译
          1. 抗漂移：delta回写，规格永远是活的。对老系统持续演进，这个属性价值极高
   - Kiro工具的使用方式
     1. 认识：亚马逊开发
     1. 设计
        - 需求歧义是损耗的最大来源。如果能在需求层用形式化句式消除歧义，后续的design/code偏差率大幅下降
     1. 需求分析 (Requirements)：requirements.md/spec.md
        - EARS语法：以标准句式消除需求歧义，Easy Approach to Requirements Syntax
          1. 用户故事 (User Story): As a [role], I want [feature], so that [benefit].
          1. 验收标准 (Acceptance Criteria): WHEN [event] THEN the system SHALL [response].
     1. 系统设计 (Design)：design.md
        - 系统架构图 (Architecture)
        - 组件与接口定义 (Components and Interfaces)
        - 数据模型 (Data Models)
        - 错误处理机制 (Error Handling)
        - 测试策略 (Testing Strategy)
     1. 实现计划 (Implementation)：tasks.md
   - 一个开源的Harness ASD：Agent-Spec-Driven Development，把三层架构(Orchestrator/Knowledge/Delivery)落成一个可直接接入的项目级运行时
    ```conf
    asd/
    ├── manifest.yaml                 # 项目声明（唯一配置入口，换项目只改此文件）
    ├── kernel/                       # Harness 引擎（v1.0.0，整体升级，项目不改）
    │   ├── orchestrator/             # 控制面
    │   │   ├── rules.md              #   Agent 行为规则 → @import CLAUDE.md
    │   │   ├── flow.yaml             #   阶段行为指南（非状态机）
    │   │   └── templates/            #   Spec 模板（Form Follows Reviewer）
    │   ├── knowledge/                # 知识引擎
    │   │   ├── loader.sh             #   按关键词检索 + 同义词扩展
    │   │   └── sync.sh               #   中心知识库 pull/push/status
    │   └── delivery/                 # 交付管道
    │       ├── pipeline.sh           #   manifest 驱动闸门管道
    │       ├── bootstrap.sh          #   环境 + 依赖服务健康检查
    │       ├── deploy.sh             #   Docker 构建 + K8s 部署 + 灰度
    │       └── gates/                #   5 个闸门脚本
    │           ├── spec-lint.sh      #     Spec 格式 + AC 编号校验
    │           ├── ac-coverage.sh    #     AC ↔ 测试覆盖清点
    │           ├── drift-check.sh    #     DDL/路由/错误码与 spec 一致性
    │           ├── compliance.sh     #     知识引用 + 澄清记录审计
    │           └── spec-lock.sh      #     多 Agent 并发编辑锁
    ├── skills/                       # 5 个 Agent Skill 声明
    │   ├── brainstorm.md             #   需求 → 知识加载 → 澄清 → Spec
    │   ├── init.md                   #   /init 交互式初始化
    │   ├── learn.md                  #   /learn 知识沉淀
    │   ├── verify.md                 #   /verify 验证管道
    │   └── plan.md                   #   /plan 降级模式
    ├── knowledge/                    # 项目知识库（版本化，持久资产）
    │   ├── index.md                  #   触发关键词索引
    │   └── synonyms.txt              #   同义词表（模糊匹配）
    ├── specs/                        # Spec 契约（用完即弃）
    └── plans/                        # 执行计划（用完即弃）
    ```
1. harness engineering
   - 背景
     1. 需求背景
        - 没有大局观：百万行级业务产品代码，因为缺乏上下文和工作环境，进度非常慢
        - 得把AI驾驭好，而不是一直跟着它的报错在后面擦屁股
        - 打造一套极其严密的护栏，上下文系统和反馈回路，用这套“缰绳”去驾驭AI这个生产力怪兽
        - 当所有东西都“重要”时，就等于什么都不重要
        - 给ai一张地图，而不是一本厚重的说明书
     1. 实现目标
        - 写代码讲究“对人友好”，现在得讲究“对AI友好”
        - 模型本身的智力已不再是最大瓶颈
        - 软件工程的鲁棒性开始转移到了支撑智能体上
   - 认识：驾驭工程，围绕ai模型设计系统、约束、反馈循环和基础设施，以确保ai agent能够在生产环境中可靠、安全且可控地执行任务
     1. 渐进式的信息披露机制：按照指南去查找深层资料
   - 组成
     1. 人类工程师：构建与维护。定义意图、搭建护栏、建立反馈、不写业务代码
     1. 缰绳系统：the harness，约束与指引
        - 导航地图：agents.md
        - 架构约束
           1. 自定义linter
           1. 结构化测试
        - ai基础设施
           1. devtools接入
           1. ci自动化验证
     1. ai智能体：探索文档、编写逻辑、修复bug、自动重构
   - 架构
     1. 规划器
        ```md
        代码仓库/
        ├── AGENTS.md (仅作导航地图，告诉AI去哪找什么)
        ├── docs/ （仅仅是正向的指导）
        │   ├── design-docs/ (核心理念与设计状态)
        │   ├── exec-plans/  (正在执行的计划与技术债)
        │   └── generated/   (由 AI 自动生成的 Schema 等)
        └── src/
        ```
     1. 执行器
     1. 检查器：约束、反馈、记录
        - 形态
          1. 单元测试 unit test：验证每个函数/模块行为是否符合预期
          1. 代码覆盖率 coverage：检查测试是否覆盖了足够多的代码路径
          1. code review：人工审查代码逻辑、规范与风险
          1. 多维度评分机制：通过指标体系对执行结果进行综合评估
        - 组成
          1. GAN对抗：两者反复博弈，卷出以假乱真的AI
             - 生成器：负责"造假"，产出尽可能以假乱真的内容
             - 判别器：负责"打假"，识别内容是否真实可信
          1. 消融工程
             - 背景：随着底层大模型能力不断增强，消融工程是Harness Engine长期主线的唯一方向
             - 理解：逐步安全地去掉不再必要的枷锁，让模型越来越"聪明"
   - 分层
     1. 上下文与记忆管理：动态组装当前任务所需上下文，管理短期/长期记忆，防止上下文过载
     1. 架构约束与护栏：强制执行架构边界，限定agent的操作权限，定义"绝对不能做什么"
     1. 验证与反馈循环建立自我纠错机制，运行测试验证输出，高风险操作引入人类审批
     1. 工具集成与编排：连接外部api、终端等工具，在复杂任务中协调多个子agent协同
     1. 垃圾回收与系统治理：定期清理过时文档和陈旧上下文，管理系统技术债务
   - wiki
     1. 控制工程：反馈回路、约束条件、安全联锁、降级策略
     1. 目前最成熟的harness系统是claude code本身
1. OpenCode
   - 认识：开源的ai编程工具，对标cc
   - 架构
     1. TUI客户端+本地服务器的架构，天然支持“多客户端驱动同一个agent能力”，不只是终端里打一行命令那么简单
   - 组成
     1. 模块化实现
        - cmd 命令行入口
        - app 核心应用服务、config 配置管理、db 数据库与存储、llm 模型抽象层
        - message 消息管理、session 会话管理、lsp 语言服务器协议集成
     1. 工作流：llm + 工具调用，工具包括读写、bash、todowrite 任务编排、skill等
#### 编程agent
1. Windsurf
   - 认识
     1. 依托Devin(一个完全的编程智能体/虚拟程序员)，设计了Agent Command Center 智能体指挥中心，即工头驾驶舱，把多智能体管理做成了产品
     1. 设计了ACP，Agent Client Protocol 智能体客户端协议，开源协议，现在说支持cc、codex等
        - 智能体这边只管按协议把自己包装好，编辑器那边只管按协议接。任何一个兼容ACP的智能体，就能在任何一个兼容ACP的编辑器里跑起来
     1. 改名为Devin Desktop，模型在变成水电煤，谁攥住那个壳谁赢
1. wiki
   - 其他编辑器
     1. Augment：插件形式，上下文很强，复杂项目很给力，比cursor好用
     1. Roo Code：完全免费，对token的使用非常透明会有显示
##### codex
1. Codex
   - 功能
     1. 多Workspace管理：支持Workspace工作区，可以放多个项目
     1. 支持并行处理
     1. 内置Worktrees：对同一个项目并行开发，不会冲突，可以查看clean diff，即git的Worktree，相当与不同的git分支
     1. 支持Plan Mode
     1. 内置MCP、Skills管理界面
     1. 支持Automations自动化、定时任务
1. ~/.codex
   - config.toml
     1. developer_instructions：被注入到prompt stack的developer role(开发者层)，优先级高于AGENTS.md产生的用户指令，但低于codex内置的system prompt
1. Agent Loop
   - 流程
    ```
    System Prompt
        ↓
    Permissions Instructions
        ↓
    developer_instructions   ← config.toml
        ↓
    AGENTS.md
        ↓
    User Prompt
    ```
1. 组成
   - Agent Runtime
     1. 认识：用于支持Thread、Tool、Sandbox、Skill、Memory、Permission等能力
     1. 事件流组成：双通道设计，同一份内容会沿两条不同用途的通道各走一遍
        - event_msg：UI/事件通道(衍生品)，发给前端渲染、给人看、做记账用的，方便日志、恢复、重放、debug
        - response_item：模型上下文通道，真正拼进prompt、发给模型api的东西
        - turn_context 轮次的上下文，每轮都会变化
     1. 机制
        - tool_search_output：大模型让codex搜索自身的工具库
        - subagent：spawn_agent/resume_agent/close_agent/wait_agent/send_input
        - codex更新自身：automation_update/fork_thread/create_thread
   - 沙箱
     1. 依赖技术：Agent沙箱隔离技术，codex使用OS原生沙箱
        ```
        | 隔离方式                                                                             | 隔离对象           | 开销 | 安全性 |
        | ----------------------------------------------------------------------------------  | -----------      | ---- | --- |
        | OS原生沙箱sandbox-exec(macOS)、Landlock/seccomp(linux)、受限令牌/job object(windows)   | 一个进程           | 很低  | 中等  |
        | Namespace/Bubblewrap                                                                | 一个进程+文件系统   | 低   | 较高  |
        | Docker                                                                              | 一个容器           | 中   | 高   |
        | MicroVM(Firecracker/Kata)                                                           | 一个虚拟机         | 高   | 最高  |
        ```
     1. 自动审批：用了一个llm驱动的审批副模型，cc更多依赖应用层的权限提示加上hook钩子来把关
   - 核心用rust重写(即codex-rs)
1. Codex Agent Runtime的事件流Event Stream Rollout
   - session_meta：首先写入metadata
     1. 最顶级的system prompt：你是codex...
     1. fork、create等codex thread的操作方法
   - event_msg
     1. task_started 开始一轮，唯一轮次id、有开始和结束
   - response_item
     1. message：这批前言每一轮都会重新拼进上下文，是token消耗和"上下文很快被填满"的主要来源之一，所以AGENTS.md要按目录作用域收窄，别放全局。
        - 权限系统介绍
        - codex app的上下文
        - 当前模式，是默认还是计划
        - skill介绍，所有已开启的skill都会存在
        - plugins介绍
        - 记忆介绍
          1. 记忆的标准用法、位置、组成
          1. 包含了用户独有的总结的记忆
     1. message
        - 用户环境上下文：目录、语言
     1. message
        - output_text：展示给用户看的
     1. tool_search_call/tool_search_output
   - turn_context 轮次的上下文，每轮都会变化、都会写一条
     1. 权限信息
     1. 沙箱信息
     1. 时区、时间
     1. 用的什么模型、推理强度
   - response_item
     1. message：用户的原始问题
   - event_msg
     1. user_message：用户的原始问题
     1. agent_reasoning 内部推理过程
   - response_item
     1. reasoning：加密了
     1. function_call：如何执行工具
        ```json
        // 数据示例
        {
            "type": "function_call",
            "id": "fc_0aa4395ab2a315e1016a4380b644948191a43dcb0da05df4d1",
            "name": "exec_command",
            "arguments": "{\"cmd\":\"date\",\"workdir\":\"/Users/huasheng/js\",\"yield_time_ms\":1000,\"max_output_tokens\":2000}",     // 标识了命令本身、执行目录、最长执行时间、最大接受的token
            "call_id": "call_mKcqdi9Q1uM1rfGQlUCEuGa2",
            "internal_chat_message_metadata_passthrough": {
                "turn_id": "019f17ae-ad3a-79f2-8c41-391d4c2dbdfa"
            }
        }
        ```
     1. function_call_output
   - event_msg
     1. token_count
     1. agent_message：展示给用户的提示
   - response_item
     1. message：llm返回的结果
   - event_msg
     1. token_count
     1. task_complete
##### cursor
1. 认识：把ai变成可信的工程伙伴。AI是工具，不是魔法：给足够上下文、清晰约束、微粒度任务，就能成为可靠的协作伙伴
   - AI编码助手 VS AI编码代理
     1. 代码助手
        - 代码补全
        - 代码生成
        - 代码重构
        - 代码翻译
        - 代码注释
        - 代码审查
     1. 编码代理agent：从“辅助开发者”向“与开发者协作”的模式转变
   - 距离全功能的交互和集成还是有距离的：如展示有bug的代码行数，高亮有bug的代码行数。就是向下的功能层面的交互。已经有一些agent操作能力
1. 功能
   - 交互形式
     1. 右侧对话框：agent、ask
     1. ctrl + k的即时对话框，提前选中代码或者@添加任意上下文的引用：让提问更准
   - Memories：记住对话信息并在未来交流过程中引用，按项目和个人级别存储，可在设置中管理。
     1. 如强制记住php的版本号
   - Commands：以“/”前缀触发的可复用工作流程。使用命令来规范流程，并提高常见任务的效率
   - SubAgents
   - Skills
   - Rules
1. 基础设置
    ```json
    {
        // 设置go安装的位置
        "go.goroot": "/usr/local/Cellar/go/1.25.1",
        "go.alternateTools": {
            "go": "/usr/local/Cellar/go/1.25.1/bin/go"
        }
    }
    ```
1. 最佳实践
   - 写接口
     1. 说清楚内部逻辑
     1. 给出明确的请求参数、返回值
     1. 给出必要的数据，如表结构
   - 知识库模板：为ai提供上下文，是AI的《员工手册》
     1. 举例
        ```json
        docs/
        └─ ai-template/
           ├─ 01_tech_stack.md          # 语言 / 框架 / 版本
           ├─ 02_architecture.md        # 架构分层 / 目录结构
           ├─ 03_coding_rules.md        # 命名、异常、日志、SQL 安全
           ├─ 04_business_glossary.md   # 领域术语
           └─ 99_prompt_snippets.md     # 常用提示词片段
        ```
   - Memories：记住对话信息并在未来交流过程中引用，按项目和个人级别存储，可在设置中管理。
     1. 如强制记住php的版本号
   - rules：设置通用、场景rules
     1. go
        - 判断nil时使用`if x != nil`，而不是`if x == nil`
        - 查询不要使用first，要使用find
     1. base
        - 代码风格要参考现有的风格
        - 不要创建SQL文件、README文档、测试用例
     1. sql
        - 删除要使用软删除
        - 尽可能提高数据库的使用效率，包括不限于能批量查询的不要循环查询
        - 在编写逻辑时，要注意避免因为主从延迟而导致的逻辑判断错误问题，比如在刚更新的数据条上进行其他形式的逻辑查询
     1. 实例
        ```conf
        ---
        description: |
        你是一个优秀的技术架构师和优秀的程序员，
        在进行架构分析、功能模块分析，以及进行编码的时候，请遵循如下规则：
        1. 分析问题和技术架构、代码模块组合等的时候请遵循“第一性原理”
        2. 在编码的时候，请遵循 “DRY原则”、“KISS原则”、“SOLID原则”、“YAGNI原则”
        3. 如果单独的类、函数或代码文件超过500行，请进行识别分解和分离
        globs: "**/*"
        alwaysApply: true
        ---

        ---
        description: 参考项目中相同功能定位的代码来写代码。不要将代码换行，一行代码多长都可以
        globs:
        - "**/*.php"
        - "**/*.go"
        alwaysApply: true
        ---
        ```
1. 一些方法
   - claude code处理终端任务、调用MCP，cursor负责ide内编码
   - 多模型协作：让不同模型独立生成，用第三款模型做diff评论，合并交集，由人类确认冲突
   - 任务清单驱动：使用Markdown task‑list，AI可自动勾选已完成项
   - Cursor Automations：类似OpenClaw，自动化审核、监控、修复代码，定时任务等
##### claude code
1. 亮点
   - 把确定性工具交给模型，把检索决策权还给模型，让模型在多轮工具反馈中逐步逼近答案
   - llm当指挥官，llm知道应该怎么做：与其让每个环节都变复杂，不如让一个环节足够强，其他环节保持简单
     1. 工具决策、任务决策都交给llm
     1. 不使用向量数据库/向量索引，只用grep和ripgrep。因为有足够聪明的大脑llm理解搜索结果
   - claude code大约90%、超过80%的合并进生产环境的代码是它自己写的，初期就3个工程师
     1. 代码审查，一下子把所有代码都跑一遍
     1. 测试用TDD，写的成本极低，达成的效果极高，总之效率极高
     1. 值班和线上事故响应，找根因极快
1. 命令
   - `/init`
     1. 认识：分析当前repo，自动生成说明文档claude.md
     1. esc：暂停当前操作
     1. --add-dir：从额外的目录加载claude.md文件
   - `/clear`
   - `/model`
     1. 认识：切换模型
     1. shift+tab：切换plan和自动编辑、yolo(更高权限)模式
     1. effort
        - 认识：推理强度，默认中等，绝大多数日常任务够用
          1. Opus 4.6用的是自适应思维（adaptive thinking），模型会根据任务的复杂程度自行判断推理深度
        - 操作
          1. --effort high、/model：设置强度
          1. ultrathink：单次超控，这次最高，下次恢复
   - `/compact`
     1. 认识：压缩对话，不希望丢掉之前的记忆
     1. 使用场景
        - 探索阶段结束，准备开始编码之前
        - 完成一个里程碑之后
        - 上下文用量到60%-70%的时候
        - 任务方向发生重大转变时
     1. `Summarize from here`：只想压缩前半段，后面的几条消息还有用，前面的背景交代可以浓缩掉，对于超长session特别有用
   - `/insights`：分析当前claude code的工作成果和改进地方，分析你使用的特点和不足
   - `/debug`：让claude排查当前session的问题，如反应慢、某工具调用总是失败等
   - `/status、/doctor`
   - `/cost`：花费
   - `/logout、/login`

   - `/simplify`
     1. 认识：代码审查和直接修复，从三个方面，之后再总结。代码复用性、代码质量和可维护性、性能和效率
        - 对刚写完、"能跑就行"状态的代码特别有用。趁着context还新鲜，跑一遍/simplify，代码质量能上一个台阶。不适合在别人的代码上乱跑，那个需要上下文，让它随便改会出问题
   - `/batch`
     1. 认识：跨文件、跨模块的大规模代码迁移
     1. 使用：`/batch 把 src/ 目录的组件从 React class 语法迁移到 hooks`
     1. 步骤：先展示一个迁移计划，然后把工作拆成若干个独立的工作单元，每个单元分配一个独立Agent、在独立的git worktree里运行，并行推进，互不干扰
   - `/claude-api`
     1. 认识：把完整的Anthropic SDK参考注入到当前会话上下文里，避免开浏览器标签翻文档和当前上下文的频繁切换。包括各种编程语言的完整Claude API参考、工具使用模式和流式实现细节、消息批处理和结构化输出、常见坑的说明，如go、php、curl等
        - 专门把某个领域的知识确定性地装进去
1. .claude
   - 认识
     1. 将.claude/视为基础架构
   - 分类
     1. 全局级：在当前用户下，包含很多东西
        - .claude/settings.json
        - .claude/CLAUDE.md
        - .claude/memory/
        - .claude/skill/
        - .claude/rules/

        - .claude/projects/
        - .claude/plans/

        - .claude/hooks/
     1. 项目级
        - CLAUDE.md
        - .claude/settings.local.json
   - `CLAUDE.md`
     1. 认识：写给cc的规则，包括项目规范、代码风格、不能动的配置、工作流规则等
        - 给agent看的配置：作为基准事实、默认前提
          1. 每个session开始的时候，都会自动把这类文件读一遍放入上下文，启动时全量加载
          1. 每层代码都可以有，越接近代码的优先级越高
          1. README是写给人看的，CLAUDE.md是写给agent看的
        - 简洁、干净第一：应该是个索引，而不是大全
        - 精确、可验证第一：不要让ai猜
     1. 最佳实践
        - 四大原则
          1. 简洁
             - 单文件控制在200行以内
             - 根目录的CLAUDE.md应该只放指针和关键的坑，其他细节都会变成噪音
             - 控制在200行以内的时候，规则遵守率大概92%。但写到400行往上，遵守率就肉眼可见地往下掉；如果把200行拆成5个30行的模块化文件，丢到.claude/rules/目录里，遵守率反而能涨到96%
             - 对每一行CLAUDE.md都问「如果删掉这行，Claude还会按这条规则做事吗？」答案是会(常识或代码已经体现)就该删，答案是不会才值得留
          1. 精确
             - 直接在你要改的子目录启动：注意力立刻聚焦到xx领域
          1. 告诉为什么
          1. 持续更新
        - 分层编写
          1. `~/.claude/CLAUDE.md`：全局，跨项目的个人偏好，如4空格缩进、测试用户不要清空数据库
          1. `项目根的CLAUDE.md`：整个项目的通用约定，如技术栈、目录、命令、硬约束
          1. `子目录的CLAUDE.md`：特定组件的特定约束，是按需加载，claude工作到该目录才生效，不污染整个项目上下文
        - /init会自动分析项目，并生成
          1. 会引用全局~/.claude/CLAUDE.md的内容注入项目中
          1. 不完美，得review一遍删掉不准的、补上漏掉的
        - 如果规则太多，就拆到rules/
        - 三类反例
          1. 复述、不及时更新：如复制大幅官方文档/教程、架构变更不同步更新
          1. 愿望型：如目标是0bug、希望多写测试、保持代码整洁、遵循最佳实践
          1. 术语型：通用术语都懂不要废话，真正需要解释的是团队特有的黑话
        - 实际使用
          1. CLAUDE.md：写`@AGENTS.md`，@是引用指令，将内容引到AGENTS.md
          1. AGENTS.md：写实际内容
          1. GEMINI.md
   - `.claude/rules/`
     1. 认识：每条规则是一个独立的md文件，组成包括元数据和规范，支持条件规则。如security.md、testing.md
     1. 举例
        ```c
        ---
        name: 前端规范
        description: React + Tailwind 项目规范
        paths: ["**/*.tsx", "**/*.jsx"]                 // path-scoped rules 路径作用域规则：只有修改tsx文件时才起效
        ---

        # 前端规范
        ...（规则正文）
        ```
   - `.claude/agents/`
     1. 认识：每个subagent就是一个独立的.md文件，![](../images/ai/cc_command_vs_agent.png)
   - `memory`
     1. 认识：auto memory，claude写给自己的笔记，claude主动维护
        - 前200行或25K的双硬上限自动加载进系统prompt，其他按需获取
        - 和CLAUDE.md冲突时，更具体的规则优先
     1. 结构
        ```c
        // 用户目录
        // 项目目录
        ~/.claude/projects/<git-root-hash>/memory/
        ├── MEMORY.md          # 主入口，每次session自动加载前200行
        ├── debugging.md       # claude记录的调试经验
        ├── api-conventions.md # api设计决策
        └── patterns.md        # 发现的代码模式
        ```
     1. 使用
        - 看到“Recalled X memories”，说明claude加载了之前的记忆
        - 看到“Wrote X memories”，说明增加了新的记忆
1. 功能
   - `/skills`
     1. 使用
        - token黑洞：注意mcp对于token的占用，使用不当或者装多了，可能没说话就占用41%的上下文，更新了自动模式机制，检测占多了就懒加载
        - mcp和skill都会进入llm inference pipeline从而占用token，插件和command不会
     1. command：自定义的命令，.claude/commands/目录下的Markdown文件，集成到了skill里
        - 组成
          1. allowed-tools：限制Claude可以使用的工具（安全考虑）
          1. argument-hint：向用户显示需要提供哪些参数
          1. description：在/help中显示，提高可发现性
        - 举例：如/create-api
        ```md
        ---
        description: 生成带有完整设置的REST API端点
        argument-hint: [endpoint-name] [method?]
        ---

        # API端点生成器：$ARGUMENTS

        创建一个完整的API端点，包含所有必要的组件：

        ## 实现文件
        1. **路由处理程序**（`routes/${endpoint}.ts`）
        2. **控制器**（`controllers/${endpoint}Controller.ts`）
        3. **服务**（`services/${endpoint}Service.ts`）
        4. **类型**（`types/${endpoint}Types.ts`）

        ## 附加组件
        - 使用Joi/Yup进行输入验证
        - 所有层的单元测试
        - API文档（OpenAPI/Swagger）
        - 速率限制配置

        @routes/ @types/ @controllers/
        ```
   - `/mcp`
     1. 常用：`claude mcp add Laravel boost/k8s/grafana`
   - `/plugins、/reload-plugins`
     1. 认识：skill的升级版，包含斜杠命令、Subagent定义、Hooks配置、MCP服务器配置、各种设置等更多内容，还能发布到marketplace让别人用，成为团队的共同插件
     1. 常用插件
        - `claude plugin install code-simplifier`：保证功能的前提下的代码优化工具
        - `claude plugin install gopls/php/-lsp@claude-plugins-official`：支持lsp：真正理解代码的语义

   - `/agents`
     1. 认识：subagent，独立的专业分工的可并行执行的claude实例，有自己的上下文，后加&即可异步执行
     1. 创建demo
        ```
        ---
        name: backend-dev
        description: 后端API开发专家，专注Spring Boot和微服务。
        tools: Read, Write, Edit, Bash
        ---

        你是我的后端开发专家。

        技术栈：
        - Spring Boot 3.x + Spring Cloud
        - MyBatis Plus
        - MySQL 8 + Redis 7
        - Kafka消息队列
        - Elasticsearch搜索

        开发规范：
        - Controller只做参数校验和结果封装
        - Service处理业务逻辑
        - DAO只负责数据访问
        - 所有接口都要做幂等
        - 统一异常处理

        每个API endpoint：
        1. 先校验参数
        2. 处理异常
        3. 返回统一格式
        4. 写清楚日志
        ```
     1. 使用demo
        ```
        用backend-dev重构用户服务 &
        用frontend-dev更新前端组件 &
        code-reviewer等他们完成后审查 &     // 最后一个等前两个完成再动手。全程自动协调
        ```
   - `agent teams`
     1. 认识：从单会话到Subagent再到Agent Teams，Subagent就是各干各的，中间没有沟通，最后拿到所有的结果总结一下输出，而team是互相沟通
        - 二者在跨层级重构、多模块联调时差距非常明显，可以省掉大量上下文传递开销
        - 更加耗费token，几个team成员就是几倍的token，因为team中的成员是整个team全量的数据，不光包含自己的，还有其他人的
        - Agent Teams目前还是实验性功能，默认关闭
        - 有人用tmux脚本、OpenClaw搞过类似的东西，可以看出原生集成和脚本糊出来的体验完全不在一个量级
        - 子agent之间的上下文同步、冲突处理、错误回滚，都是硬骨头
     1. 认识：像真实公司一样运转。utils/swarm/目录下是完整多agent协作框架
        - 每个team有leader和多个teammate
        - 支持三种执行方式：同进程隔离、tmux窗口、iterm2分割窗格
        - 每个agent有自己的邮箱文件做异步通信
        - 每个agent可在独立的git worktree中工作，互不干扰
        - 权限冒泡：teammate遇到需确认的操作，权限请求冒泡给leader而非直接弹给用户
     1. 对比
        - | 维度 | sub-agents | agent teams |
          |------|------------|-------------|
          | 进程模型 | 主agent的子进程 | 独立的对等进程 |
          | 通信方式 | 任务结束时返回摘要 | 持续的消息/广播ipc |
          | context | 隔离，任务后丢弃 | 独立，持久保留 |
          | 协调方式 | 顺序委托 | 共享任务列表，自主认领 |
          | 适合场景 | 研究、探索、代码审查 | 跨模块并行实现 |
     1. 多Agent之间如何通信
        - message passing 消息传递：agent之间互发消息，通信灵活但是token消耗很大、调试困难、上下文容易失控。![](../images/ai/message_passing.png)，主要在学术研究出现
        - orchestrator + shared state 中心调度器 + 共享状态：所有消息经过中心调度器读取和写入数据，并且所有agent通过一个共享的状态对象进行交互，不同的agent读取状态、处理任务、把结果写回状态，orchestrator统一负责调度和状态流转。简单可控，出了问题也好排查。如langGraph的StateGraph，最常见。![](../images/ai/orchestrator_shared_state.png)
          1. 避免agent间形成复杂依赖
          1. 提升系统的可观测性、可恢复性和可维护性
          1. 通常存储在redis或数据库中
        - Event Bus 事件总线：采用事件发布、订阅机制，不同agent进行通信。![](../images/ai/event_bus.png)
     1. 六种工作流模式：![](../images/ai/agent_team_six_struct.png)
        - | 维度 | sub-agents | agent teams |
          |------|------------|-------------|
          | 进程模型 | 主agent的子进程 | 独立的对等进程 |
          | 通信方式 | 任务结束时返回摘要 | 持续的消息/广播ipc |
          | context | 隔离，任务后丢弃 | 独立，持久保留 |
          | 协调方式 | 顺序委托 | 共享任务列表，自主认领 |
          | 适合场景 | 研究、探索、代码审查 | 跨模块并行实现 |
     1. 如何设计agent角色分工
        - 单一职责
        - 高内聚，低耦合
        
        - 按能力边界拆分：负责搜索、写作、审核
        - 按流程拆分：适合业务逻辑

   - `/loop`
     1. 认识：定时调度，直接写做什么，就直接能理解
     1. 使用
        - `/loop 5m check if the deployment finished and tell me what happened`，每5分钟
        - `/loop check the build every 2 hours`，每2小时
        - `remind me at 3pm to push the release branch in 45 minutes, check whether the integration tests passed`：也支持处理一次性的事，到时候自动删除这个任务
     1. 特性
        - 是session级别的，session消息，则任务消失
        - 3天自动过期，防止无限跑下去
        - 任务到期，会等Claude当前回合结束再执行，不会打断会话
     1. 实现
        - 底层依赖CronCreate、CronList、CronDelete三个工具，每个任务有8位ID，单个session最多50个任务
   - `/todos`
     1. 认识：让claude按顺序一个个做，支持任务依赖追踪
     1. 使用
        ```
        任务1: 创建数据库schema
        任务2: 写CRUD接口 (依赖任务1)
        任务3: 写单元测试 (依赖任务2)
        任务4: 写文档 (可以并行)
        ```
   - `/goal`
     1. 认识：不达目标不罢休，先由ai制定一个工作流，然后依次执行，称为Dynamic Workflows 动态工作流
     1. 适合大批量、深度、多角度
   - `worktree`
     1. 认识：隔离支持，包括agent/memory维度
     1. 使用：`claude --worktree`，创建独立的git worktree并运行
   - `/hook`
     1. 认识：支持各个操作节点添加钩子：支持本地shell命令和http hook
     1. 分类
        ```md
        | Hook类型        | 触发时机                | 常见用途                     |
        |-----------------|------------------------|------------------------------|
        | SessionStart    | 会话启动时              | 加载项目配置、初始化环境     |
        | SessionEnd      | 会话结束时              | 清理临时文件、发送总结       |
        | UserPromptSubmit| 用户提交prompt时        | 添加上下文信息、预处理输入   |
        | PreToolUse      | Claude执行工具前        | 拦截危险命令、权限检查       |
        | PostToolUse     | Claude执行工具后        | 自动格式化、运行测试         |
        | Stop            | Claude停止响应时        | 发送完成通知                 |
        | PreCompact      | 上下文压缩前            | 保存重要信息                 |
        | PostCompact     | 上下文压缩后            | 恢复必要上下文               |
        | Notification    | 收到通知时              | 转发到其他渠道               |
        | SubagentStop    | Subagent停止时          | 汇总子任务结果               |
        ```
     1. 示例
        ```conf
        {
            "hooks": {
                "PreToolUse": [
                    // http hook
                    {
                        "type": "http",
                        "url": "https://your-internal-audit.company.com/claude-events",
                        "headers": {
                            "Authorization": "Bearer ${AUDIT_TOKEN}"
                        }
                    }
                    // 本地shell
                    // 危险命令拦截
                    {
                        "matcher": "Bash",
                        "hooks": [
                            {
                                "type": "command",
                                "command": "if echo \"$CLAUDE_BASH_COMMAND\" | grep -qE '(rm -rf|DROP TABLE|DELETE FROM)'; then echo '危险命令已拦截' >&2; exit 2; fi"
                            }
                        ]
                    }
                ]
            }
        }
        ```
   - chrome：claude in chrome，官方出品的浏览器控制插件，现在支持ios模拟器
   - IDE集成：显示“IDE connected”，即可让IDE显示代码变更，就跟cursor一样
   - claude remote-control：支持手机或浏览器扫码，远程控制当前的claude
1. 原理
   - 认识：是一个node.js应用，用ts写的
     1. 将全套的完整的经过实际工程经验都传递给llm的”操作系统“
   - 特点
     1. claude api的prompt cache是基于字节级前缀匹配的，就是字母匹配

     1. 静动分离的提示词组装
     1. 独立小模型快速扫描所有记忆文件，选出5个跟当前对话最相关的，放入提示词

     1. 详细的给llm看的工具手册，且工具手册是延迟加载的
     1. ”先读后改“的铁律：禁止不看就改

     1. 三层压缩
        - 微压缩：压缩旧的工具调用结果，如把"10分钟前读的那个500行文件的内容"替换成[Oldtoolresult content cleared].
        - 自动压缩：接近上下文窗口的87%自动触发，有熔断器压缩3次失败停止
        - 完全压缩：用ai总结，并且提醒不要调用任何工具(任务是总结，别干别的)

     1. kairos模式：做梦模式，低活跃期蒸馏原始日志形成结构化主题文件
   - 总览
    ```
    用户输入
        -> 动态组装7层系统提示词
        -> 注入git状态、项目约定、历史记忆
        -> 42个工具各自附带使用手册：详细说明了工具的作用、禁忌、边界
        -> llm决定使用哪个工具
        -> 9层安全审查(ast解析、ml分类器、沙箱检查)
        -> 权限竞争解析(本地键盘/ide/hook)
        -> 200ms防误触延迟
        -> 执行工具
        -> 结果流式返回
        -> 上下文接近极限？三层压缩
        -> 需要并行？生成子Agent蜂群
        -> 循环直到任务完成
    ```
   - 提示词组装
     1. 认识
        - 根据状态、工具、模式动态组装出来的，类似数字人课件，是企业级的做法
        - 不是一个单一的长提示词，而是几十个模块化的提示词组合在一起，会用到变量替换、if判断等
        - 静态内容在先，动态内容在后：静态的在前边claude服务端可以缓存(加速/省钱)
        - 组成
          1. Intro：你是一个交互式代理，帮助用户执行软件工程任务
          1. System：你输出给用户的文字会直接显示、用户拒绝工具后不要机械重试
          1. Doing tasks：不要只口头回答，要真的改代码/处理任务、改代码前先读代码
          1. Executing actions with care：对高风险、高破坏性、难回滚、影响共享环境的动作先确认
          1. Using your tools：能用专用工具就不要用Bash、用task/todo工具管理任务
          1. Tone and style：除非用户要求，不要用emoji、回复应简洁、引用代码要带file_path:line_number
          1. Output efficiency / Communicating with the user
          1. 
          1. __SYSTEM_PROMPT_DYNAMIC_BOUNDARY__：静动边界标记，这不是给模型看的业务规则，更多是给系统做缓存切分，前面的静态段尽量跨session复用
          1. 
          1. Session-specific guidance
          1. Memory
          1. Environment
          1. Language
          1. Output Style: xxx
          1. MCP Server Instructions
          1. Scratchpad Directory
          1. Function Result Clearing
          1. Summarize tool results
          1. Numeric length anchors
          1. Token budget
          1. Brief
     1. 组成
        - 主系统提示词：约3000tokens
        - 工具描述提示词：如bash工具约1000tokens，write工具约150tokens
        - 子代理提示词：每个子代理独立的系统提示词，如Explore Agent分析代理、Plan Agent计划代理、总结Agent
        - 系统提醒提示词：特殊提示词，会在特定条件下动态注入
          1. 五步工作流
             - Phase 1: Initial Understanding - 理解需求，启动Explore Agent搜索代码
             - Phase 2: Design - 启动Plan Agent设计方案
             - Phase 3: Review - 审查方案，确保和用户意图一致
             - Phase 4: Final Plan - 写最终方案到plan文件
             - Phase 5: Call ExitPlanMode - 告诉用户规划完成
        - Skills提示词
          1. 认识：安装的每个Skill的元数据(name + description)会格式化成XML注入到这里
            ```xml
            # 语法
            ${FORMAT_SKILLS_AS_XML_FN(LIMITED_COMMANDS, AVAILABLE_SKILLs.length)}
            
            # 举例
            <available_skills>
                <skill name="commit" description="Create git commits with conventional commit messages"/>
                <skill name="review-pr" description="Review pull requests for code quality"/>
                <skill name="pdf" description="Generate PDF documents from markdown"/>
            </available_skills>
            ```
     1. 提示词的衔接内部prompt举例：如"帮我修复src/utils/parser.ts里的类型错误"
        ```
        ---------------------------------------------- 主上下文
        [主系统提示词]
        - 包含：不要改没读过的代码、避免过度设计等规则

        [工具描述]
        - ReadFile工具：怎么读文件
        - Edit工具：怎么编辑文件
        - Bash工具：怎么跑测试

        [你的消息]
        - 帮我修复src/utils/parser.ts里的类型错误

        ---------------------------------------------- 规划模式
        [Plan Mode系统提醒]
        - 你现在不能执行任何修改操作
        - 按照五步工作流进行规划
        - 可以启动Explore Agent搜索代码
        - 最后要调用ExitPlanMode

        ---------------------------------------------- 决定使用Explore Agent时，用Task工具启动
        [Explore Agent专属提示词]
        - 你是文件搜索专家
        - 只能读取，不能修改
        - 使用Glob、Grep、ReadFile工具

        [工具描述]
        - 只包含只读工具的描述

        [父代理传递的任务]
        - 探索认证模块的代码结构
        
        ---------------------------------------------- 自动压缩
        [总结Agent专属提示词]
        - 按照8个维度进行总结
        - 保留所有用户消息
        - 特别关注错误和修复

        [之前的完整对话历史]
        ```
   - 三层架构
     1. prompt system：几千token的system prompt
        - claude的prompt非常细致，本质上是把十几年工程实践中总结的"好习惯"硬编码进了prompt，这些在关键操作上是救命稻草，如git commit不能主动加--no-verify
     1. agent loop：think->tool->observe->repeat
        - llm当指挥官：核心就是一个while循环，没有复杂的DAG、状态机、编排引擎。理念是llm当指挥官知道应该怎么做，不需要去编排每一步
          1. 收到用户输入 → 组装prompt → 发给claude → claude返回结果(可能包含工具调用)→ 执行工具 → 把结果塞回prompt → 再发给claude → 直到claude说"我完成了"
          1. 只负责驱动循环、执行工具调用、感知结果。所有的推理、决策、何时停止，全部都交给模型
             - 对比LangChain这种在框架层做各种“聪明编排”的路线形成了鲜明对比
          1. 简单不简陋，有很多细活。如工具失败不会破坏循环会发给llm判断失败原因
        - llm会话无状态：每次都叠加上次会话数据一起扔给服务端，然后服务端处理缓存后扔给llm
          1. cc的server端会递次缓存之前的每轮会话，产生多个递进的缓存，只要没有修改之前的都会命中缓存，如果修改了就会在缓存后边进入新的会话分支，所以无状态不会导致上下文爆炸，大多数90%都会命中缓存，缓存读取花费是输入token的10%、缓存写入成本是输入token的125%、缓存有效期5分钟每次命中会刷新
             - ps：openai的api默认无状态，需要请求方自己拼接历史会话，同时提供2种官方会话能力conversation/previous_response_id不需要自己传历史会话，默认保存30天，其他background/streaming临时10分钟，音频多轮状态1小时
        - 有最多100轮限制防止死循环
     1. tooling：read/write/edit/bash(git/npm/docker)
   - 其他部分
     1. context window：![](../images/ai/cc_use.png)
        - 原则
          1. context不是越大越好，而是越干净越好
        - 治理体系
          1. 自动压缩：占用约70%时自动触发，用llm摘要替换原始对话轮次，释放空间同时保留关键决策
          1. sub-agent隔离：重型探索、研究任务卸载给独立子agent
              - 子agent运行自己独立的taor循环，有自己的context预算
              - 任务完成后只把摘要返回给主agent，主agent的context不被污染
              - 细节：子agent有自己的maxtokens上限、compaction机制、memory.md
           1. prompt cache：递进缓存
        - session管理
          1. context管理不只在单次会话内，而是跨会话的
          1. 会话像git branch运作，可checkpoint、rollback、fork
        - wiki
          1. 最普遍的失败模式 context collapse：上下文窗口被填满 → 记忆退化 → 幻觉出现 → agent在噪音里迷失
     1. memory
        - 认识：结构化文件 + 小模型当选择器，简单比向量检索好用得多
          1. 核心是一个索引，不是存储
          1. 能从代码库中重新推导出的信息，绝不应该被存储
        - 思想
          1. 结构化优于自由文本
          1. 索引常驻 + 内容按需
          1. 廉价模型帮忙
        - 架构
          1. 静态层：主/项目级/子目录级CLAUDE.md、用户注入(--include)、全局/项目配置(.claude/settings.json)
          1. 动态层
             - 对话记忆：近期对话，保持上下文连贯
             - 事实记忆：关键信息，跨会话留存
             - 偏好记忆：用户偏好，行为模式
             - 历史记忆：长期沉淀，自动归档
        - 机制
          1. 调用：使用<system-reminder>标签注入上下文
             - 会话开始：自动加载前200行或最大25k
             - 用Sonnet选top-5：扫描所有记忆文件的头部信息，只读每个文件前30行，原则是不确定的就别选
               1. 上一轮对话已经露过脸的记忆，这次直接排除
               1. 不选最近用过的工具的用法参考文档，但保留工具的“警告、坑点、已知问题”，因为正在用的时候恰好是这些警告最该出现的时候
             - 2天前的记忆主动加stale提醒
          1. 生成：会自动更新记忆
             - 触发时机：每轮回答完成后启动，通过stopHook钩子触发，有限流
               1. 由独立fork agent完成：继承主对话上下文，完全复用提示词缓存，但只能读文件和写入记忆目录，不能执行bash
             - 只记四种类型：无关的、临时的、可推导的、敏感数据的、过期的，都不要
               1. user 用户画像，如”十年go，刚接触react“
               1. feedback 行为偏好，强制结构是why为什么 + How to apply什么情况下生效
               1. project 项目动态
               1. reference 引用，记录“去哪查什么”
             - 格式：每个都是独立md文件，用name、description、metadata描述
                ```
                ---
                name: no-drop-table-ever
                description: ABSOLUTE GLOBAL RULE — never generate, run, or suggest any operation that drops database tables/databases, in any repo or context
                metadata:
                    type: feedback
                ---

                ......
                ```
             - 步骤
               1. 扫一遍这一轮对话里用户的反馈、纠正、信息
               1. 跟现有记忆比对，看有没有重复
               1. 如果有新的值得记的内容，按四种类型分类，写一个新文件
     1. 读代码
        - 认识：agentic search，让claude像agent一样去搜
          1. 三工具 + 并行subagent(隔离上下文) + 多轮迭代
        - 工具
          1. glob：类似find，找文件/目录
             - 结果按修改时间倒序排列：最近改过的就是跟当前任务最相关的
             - 100 文件硬上限：避免输出爆炸
          1. grep：找内容
             - 权限统一管控
             - 输出格式可控：行号、上下文行、按文件分组、甚至支持只返回匹配文件名、只返回匹配数量三种粒度，token耗费少
             - 性能：基于ripgrep，rust写的，多线程并行、自动遵守.gitignore
             - cc文档要求开放式、需要多轮迭代的搜索，请用agent工具
          1. read：读，不使用向量
             - 默认只读2000行：按需读取，不贪心
             - 读取最新内容：直接stat磁盘文件，不缓存、不索引、不预处理
        - 步骤：整个过程是模型一步步推进的
          1. 先用glob找候选文件
          1. 用grep在这些文件里搜关键字
          1. 用read读命中文件的相关行段，看具体实现。
        - 理由
          1. 代码不像散文，切不动：容易破坏代码结构，都是有逻辑关系的，切了以后幻觉概率直接拉满
          1. 向量无法做到精确匹配：向量相似不等于代码正确
          1. 索引会过期：每天提交几百个commit，embedding pipeline根本跟不上，一旦落后就会误导llm
             - 文件刚改完，下一秒就要读到最新内容
             - top-k是一次性下注
          1. 冷启动为零。RAG在百万行代码库上建一次索引要十几分钟
          1. 精确匹配向量干不了：代码大多数要的是精确，不是相似
        - 特点
          1. 严重依赖一个好的起点context
     1. 压缩
        - 认识：上下文窗口有最大限制；窗口越大模型注意力越分散容易“忘记”早期的关键指令，或者把中间某次失败的尝试和最终的修复方案搞混
        - 机制
          1. 微压缩：MicroCompaction，规则驱动/预处理，对工具结果在llm读取后做裁剪、去掉冗余输出，不会调用llm
             - 有一个可压缩工具的名单：FILE_READ/EDIT/WRITE_TOOL_NAME、GREP/GLOB_TOOL_NAME、WEB_SEARCH/FETCH_TOOL_NAME等
             - 这些结果在模型处理完之后，完整的返回值就没什么用了，把旧的tool_result内容截断或替换成占位文本[Old tool result content cleared]
             - 基于时间间隔的清理：Anthropic的kv cache是5分钟或60分钟，MicroCompaction统一设为60分钟，缓存已经冷掉时，下次请求本来就要重新计算前缀，那就先把旧工具结果瘦身，减少重新发送的数据量
             - 保留最近5个可压缩工具的结果：基于经验值
          1. 自动压缩：AutoCompaction
             - 触发阈值：输入输出共享同一个上下文大小，既要接收输入，又要为输出留出。200K为83.5%，1M为96.7%
             - 压缩路径
               1. 会话记忆压缩：开启了会话记忆功能，会在后台持续做增量笔记。压缩时直接用这些笔记作为摘要，不需要原文了，至少保留5条最近对话和10K token的内容。速度快、实验功能
               1. 全量对话压缩：forked独立agent，消耗的token相当于全部会话+输出的压缩内容
                  - 只有一轮机会maxTurns:1，禁止调用工具(前后插入严厉的提示词，但是和主agent共享工具集用于复用kv cache)
                  - 压缩提示词要求模型输出两个XML块：一个analysis块记录思考过程类似CoT，一个summary块正式的摘要（包含）
                    1. Primary Request and Intent：用户的核心需求和意图
                    1. Key Technical Concepts：涉及的技术概念和框架
                    1. Files and Code Sections：操作过的文件、代码片段、修改记录
                    1. Errors and Fixes：遇到的错误和修复方案
                    1. Problem Solving：解决的问题和正在排查的问题
                    1. All User Messages：所有非工具结果的用户消息（原文）
                    1. Pending Tasks：待完成的任务
                    1. Current Work：压缩前正在做什么
                    1. Optional Next Step：下一步计划
               1. 部分压缩：只需要压缩之前压缩后的新增部分，输入少、速度快
          1. 阻塞限制：超88.5%时拒绝发送api请求，避免浪费api；连续失败3次停止自动压缩
          1. 响应式兜底：API返回prompt_too_long直接逐条删除最旧的消息
     1. 权限系统
        - 工具调用都经过静态分析层的多层白名单校验：bashsecurity.ts里有23项编号的安全检查
          1. 18个被阻止的zsh内置命令
          1. 防御zsh equals expansion：=curl这种写法可以绕过对curl的权限检查
          1. unicode零宽字符注入
          1. ifs null-byte注入
          1. 一个在hackeron审查期间发现的恶意token绕过
   - harness架构
     1. CLAUDE.md
     1. LSP
     1. Skills
     1. MCP
     1. Plugins
     1. Subagent
     1. Hooks
   - 设计
     1. Haiku模型做辅助任务：如生成对话摘要(用于resume功能)、检测bash命令是否有注入攻击(用llm来判断另一个llm生成的命令是否危险)
1. 最佳实践
   - 项目初始化
     1. 编辑CLAUDE.md：补充项目特殊信息，如技术栈、架构决策、编码规范、注意事项等
     1. 安装团队skill
     1. 开始工作：大多数会话从Plan mode开始，讨论好细节和计划后，再一次性接受所有改动
   - 模型对比
     1. 2025年2月24日，Claude Code随着Claude 3.7 Sonnet一起发布
     1. Opus 4：做到70%开始出错
     1. Opus 4.5：一次过，每个都对，比4错误率下降了50-75%
     1. Opus 4.6："vibe working"，从编程扩展到全面办公，支持1M上下文
     1. Sonnet4.6只比Opus4.6低了大概2%的能力，但是价格是其五分之一。Sonnet4.6把以前"要用旗舰才能做"的事，拿到了中档价位
        - SWE-bench Verified：评测AI解决真实开源项目bug的能力
        - OSWorld-Verified：评测AI操控真实电脑界面的能力
1. wiki
   - 更新
     1. 2.1.172：subagent能自己再起subagent，最多套五层，意义是增强了处理 复杂问题的能力，因为一个复杂的问题到了subagent还是复杂需要继续拆，不继续嵌套的话主agent不可能管理那么多细节，就像公司组织架构不能只有两层
     1. 2.1.178：删掉TeamCreate、TeamDelete工具，team改成"按session隐式存在"，收缩Agent Teams概念，一是用户心智负担重玩不明白，二是工程上制造的复杂度大于它带来的价值。本来就应该是在干活的过程中自然形成team，teammate(隐式团队成员)可以在tmux的独立pane里跑起来
### 最佳实践
1. 在ai开发中要摒弃一切都是确定的的传统思维，要相信llm可以像人一样灵活应变。
1. openclaw的提示词维度更加的高，并没有详细说明什么情况下应该怎么做，而是给出了理想和原则，是更高维度的提示词，是适配更高级模型的正确思路
1. 心得
   - compact压缩一次上下文就丢一次细节，越到后面越拉胯
     1. 记录关键决策可以减轻
   - 如果要处理确定性强的、不容有失的，可以使用流程编排等确定性手段
   - 模型能力的提升正在让"精心设计的 prompt"变得越来越不重要
   - 不论是dot-skill、nuwa-skill这种生成skill的skill，都是普通的提示词，其他核心价值在于其提示词怎么写，如从哪些维度、有哪些验证规则(提炼规则、质量验证规则)，所以如果你是一个专家，才可以全面、专业的生成指导
   - dify是一个低代码llm应用编排平台，适合快速跑通，验证业务、调试提示词和业务。大规模部署还是自己实现一遍
   - ai能够大量生成代码，节省人力
   - 人要驱动ai，而不是被ai左右
     1. ai是执行工具，不能替代人进行架构设计和方案决策
     1. 与ai持续battle，明确技术栈和规范，掌握实现逻辑、避免黑盒开发、确保实现符合规范
   - 实现变的便宜了，做对并没有
1. 历程
   - ai太好了，我不会的全部可以教我，记得遇到不懂的不要妥协，去问ai老师
   - 现在掌握信息的效率太低了，提高方法
1. 知识
   - 现在llm
     1. 上下文窗口一般为128k、256k，最大的1m
        - 类似live-sr、student-rtim-sr这种项目就是100~200k，live-class-sr是1m
        - 1m token大概两百多万字母
     1. 参数量为数千亿→万亿级，通常是MoE(混合专家)实际每次只激活一部分参数，本地的是几亿(即几B)
1. 胡思乱想
   - 真正的高精尖技术都是从学术中来的，只考虑实现一个专有的场景，之后再添砖加瓦扩展到其他领域
     1. 如agent team功能从“分别从安全性、性能、测试覆盖率等不同角度同时审查代码，然后互相质疑和补充”开始mesh架构工作
     1. 那种一上来就要吃个胖子，面面俱到的往往无法获取成功
   - agent治理是一个大问题，很快就会有通用的agent面世，当下有Claude Managed Agents
1. 基础思考
   - ai做的是执行层，思考层还要人来，帮助人更好的思考
   - 大模型最与众不同的能力是意图提取，是自然语言理解
   - 现在llm的能力非常强了，只要给出足够的资料，准确的要求，都能准确的输出
   - 提示词prompt是进入的门槛，也是基础
   - 如何使用：和AI协作就像带新人，目标明确、步骤细化、实时盯进度，才能高效拿到结果
     1. 描述清晰目标
     1. 拆解步骤：别指望一个prompt搞定所有事，必须把开发分成小步骤，精准控制prompt
     1. 迭代验证：让ai每步汇报进展，人检查通过后再往下走，大幅减少幻觉
   - 使用高级设置
     1. 大模型的topP、topK
     1. 提示词模版
     1. mcp调用是提示词还是function calling
     1. 向量库的切分模式、向量维度的调整
   - 调提示词，效果不明显时，换模型
   - 做简单且管用的事：在意影响力的大小，而不是方法的精巧；只需要自行车时,我们不会去造飞船
1. 工程实践
   - 用ai分析一个db，快速数据导入，本来需要3天的事情，半天搞定，作为项目写进去
   - 接入shengwang mcp
     1. 背景：临时需要踢出用户
     1. 方案：接入shengwang mcp后生成curl，快速解决、高效解决
     1. 意义：人工翻文档、生成token得尝试1天；接入mcp加速对声网文档的理解
   - 想做生产级系统，要性能，要部署简单，要吞吐量。所以选了Go
   - 给模型让路，让它自己做
1. 程序员如何用ai
   - 应用ai的方面
     1. 编码
        - 开发：同时跑n个任务，只要计划够好，几乎每次都能一次性写对
          1. 有人会部署自己从没亲手验证过、自己不了解的软件
          1. 当工程团队翻倍、人均产出还能涨67%的时候，稀缺的从来不是"会写代码的人"，而是"知道该写什么、还能判断写得对不对的人"，能指挥一群ai、还能替它们把关的那个人
        - 代码审查，一下子把所有代码都跑一遍
        - 测试用TDD，写的成本极低，达成的效果极高，总之效率极高
        - 值班和线上事故响应，找根因极快
     1. 查找问题、资料：飞书的知识问答、aily
     1. 把每天做超过一次的事都做成了command、skill
     1. 使用hook做自动化桥接
   - CLAUDE.md起步；长了拆到rules/；高频工作流写到commands/；可复用能力封装成skills/；高隔离度的添加agents/
### wiki
1. 其他方面的应用
   - 图像应用
     1. 大模型：文生图像、图像编辑、图像扩展
        - 产品
          1. gpt-image-2：对文字处理很强，生成商业广告图
          1. stable diffusion：生态丰富如lora微调、controlnet控制构图。stability ai开源的2022年发布
          1. dall-e：最新dall-e 3，openai的闭源
        - 模型
          1. FLUX.1(Dev/Pro)：更前沿研究路线
          1. LongCat-Image：diffusion原理
     1. 图像翻译
        - 分类：配对、非配对
        - 应用
          1. 风格迁移：斑马变成黑马、文字换字体
          1. 人脸卡通化
          1. 虚拟试衣
          1. 换脸
          1. 照片上色：老照片上色
          1. 超分辨率：模糊图变清晰
        - 操作三部曲：pix2pix、pix2pixhd、vid2vid
        - 换脸：uni2i框架
   - 语音应用
     1. 精品sft复刻语料要求：
        - 同一说话人至少60分钟音频，最好是同一状态下的音频。并匹配准确的逐字稿。
        - 最好是专业录制设备在录音棚录制，无背景噪声，无回声混响，信噪比大于40db
        - 录音条件为在录音状态下的正式录音，保证平稳完整输出频率
        - 录音文件要包含录制者习惯或需要的气口、情绪起伏及长段文字播读
        - 录音时保证话筒或录制设备与播讲人保持的距离尽量一致，防止因声音忽大忽小影响复刻效果
        - 单声道，无压缩pcm wav格式，44100以上采样率，16bit以上位深度
   - 视频应用
     1. 大模型
        - seedance2.0
        - sora：文生视频、图生视频、视频编辑与扩展，openai的闭源
     1. 应用平台
        - 国外
          1. midjourney
          1. runway gen
          1. pika labs
        - 国内平台
          1. 可灵kling：快手
          1. 即梦ai dreamina：剪映
          1. 海螺ai
   - ai在游戏的应用
     1. 海龟蘑菇汤
        - 场景：游戏中需要主持人作准确的语义理解
        - 效果：语义理解准确度在90%以上
        - 问题
          1. 降低大模型应用的费用：gpt-4的成本较高，单次demo体验下来的token消耗大概在10-15美元左右，一开始估算平均每个用户使用token的成本在140人民币左右
             - 控制token消耗：包括保存问题库、近似检索、模仿搜索引擎的auto complete提示等，即直接保存了问题结果进行回答，用类似传统搜索引擎的技术支持的，绕过了大模型的支持。同一个问题，大模型只需要回答一次
          1. 为什么选择费用最贵的gpt-4：测试过市面上所有的模型，得出了gpt4是最贵的，但也是正确率最高的，不怕最贵，但求最好
     1. suck up
        - 场景：玩家欺骗ai支撑的npc来达到目的(吸血)，推动游戏发展
        - 效果：ai驱动的npc带来不确定性和惊喜
        - 问题
          1. 加入"信任系统"来平衡游戏关卡的难度
          1. 缩短ai反馈的速度：增强反应速度并降低大模型幻觉
             - 提示词方法：预先准备好答案
   - 聊天前端项目：open webUI（原名ollama webUI）、chatbox、Cherry Studio、Page Assist、chatbot-ui，类似gpt的界面
     1. chatbox的功能：文字聊天(markdown渲染、代码渲染、mermaid图像表格渲染、思维导图、语法高亮、内置html渲染)、联网搜索(网页爬取)、文件交互(图片)、调用mcp服务、本地化向量知识库、图像生成
1. 算力
   - 单位
     1. 计算速度：TOPS = TFLOPS = PFLOPS/1024
        - TOPS   = 10¹² Operations/s
        - TFLOPS = 10¹² Floating Point Operations/s
     1. 浮点数位数：FP32/FP16/FP8/FP4，同样的算力32位/16位/8位/4位的TFLOPS差距为数十、数百、上千、数千
        - 高精度适用于游戏、低精度适用于推理
   - 大模型开发者看显卡AI性能的注意顺序：显存容量>显存带宽>FP8/FP4算力>TOPS数字
