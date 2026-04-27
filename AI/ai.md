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

     1. LLM：大型语言模型 Large Language Model
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
     1. 多模态LLM：除了文字能力外，还可以理解和生成图片、语音、视频
        - 额外的图片识别模块，如GPT-4V和LLaVA
        - 原生多模态：GPT-4o和Gemini
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
     1. 概念
        - 条件概率：在已知一个事件已经发生的情况下，另一个事件发生的概率
        - 温度参数：控制生成文本的随机性，温度越高，生成的文本越随机；温度越低，生成的文本越确定
     1. 训练方式
        - 大量数据训练
        - 指令微调阶段：instruction tuning
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
   - ORT：ONNX Runtime，用于高性能推理（即模型预测）的跨平台引擎，用于加载和运行由ONNX格式定义的机器学习模型
     1. ONNX：Open Neural Network Exchange，开放的、代表机器学习模型的标准文件格式。
        - 由微软和Facebook于2017年共同创建，旨在促进不同深度学习框架之间的互操作性
        - 支持多种框架，如PyTorch、TensorFlow、MXNet、Caffe2等
     1. tflite：
1. 开发
   - llama.cpp：用c和c++编写的高性能开源推理框架
   - ROCM：Radeon Open Compute Platform，AMD的主要用于GPU计算的开源软件平台
   - CUDA：NVIDIA的gpu开发框架
   - Vulkan：现代的跨平台的移动端的低开销的高性能图形和计算api，能高效地利用gpu，对比传统的OpenGL，即移动端的CUDA
     1. 主要应用场景是推理(inference)，不是训练
   - TPU：专用于大规模神经网络训练和推理的
   - NPU：终端设备的ai加速芯片
     1. TOPS：每秒万亿次运算，衡量NPU理论峰值算力的主要指标，即引擎的最大马力
1. finetune
   - 认识：大模型微调，补充和强化LLM。还是基于冻结的模型(已经训练好不动的)，给大模型多次不同的黑盒向量数值，影响大模型的计算，进而最终得出最好的结果，就是微调llm
   - 概念
     1. 选择性微调：只更新部分参数，放在参数里，技术有Freeze、BitFit
     1. 加性微调：在模型中增加新的参数、模块，追在参数后，技术有Prompt-Tuning软提示、Adapter插入小型层
     1. 重参数化微调：技术有LoRA
   - Prompt-Tuning：RAG本质上还是属于硬提示的范围，只不过提供了更多准确的参考资料、用向量比文字更精确，并没有影响到llm本身，软提示是会影响llm的，是一种高级的提示工程，![](../images/ai/prompt-tuning-type.jpg)
     1. 硬提示：人工设计，仅限于输入层
     1. 软提示：可进行训练，表现比硬的更稳定，增加一点模型参数
   - LoRA：低秩适应，插件式微调，对大语言模型进行个性化的特定任务的定制，其将模型的权重矩阵分解成低秩的相似矩阵，降低了参数空间的复杂性，从而减少微调的计算成本和模型存储
     1. 核心假设：权重更新（ΔW）其实具有较低的“内在秩”（Intrinsic Rank）。意思是，巨大的参数变化可以用一个更小的矩阵来近似表示。
   - PEFT
   - RLFT：人类反馈强化学习，让模型输出更适合人
   - 学习路径
     1. 模型量化：QLora/GPTQ
     1. PET/P - Tuning技术
   - 工具
     1. unsloth：高效的微调开源框架，使用python
        - 替代了PyTorch中原生的一些操作
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
        - 阿里
          1. Qwen3、Qwen2.5 
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
1. RAG
   - 认识：Retrieval Augmented Generation 检索增强生成，用于提升llm生成答案的准确性和时效性的技术框架
     1. 背景：LLM本身的知识滞后、可能“幻觉”两个缺陷，用RAG来增强
     1. 步骤
        - 数据准备
          1. 切分：transformer，切分成小块chunk
          1. 嵌入：使用嵌入模型将每个小块转换为高维度的数字向量
          1. 存储：向量数据库，以便后续进行高效的相似性搜索
        - 检索：提出一个问题时，RAG系统先从向量化后的知识库中搜索与问题最相关的信息片段
          1. 转换：将这个查询也转换为一个向量
          1. 相似性搜索：在向量数据库中进行相似性搜索
        - 增强生成
          1. 构建增强提示：将检索到的最新相关文档和原始问题打包在一起，形成“增强版的提示”。并指令“请根据以下提供的资料来回答问题”
          1. llm有了“实时”的参考资料，大大提高了回答的质量和可靠性
     1. 特点
        - 数据越规范，查询效果越好，结合树形结构或知识图谱结构的数据，RAG可以实现更好的效果
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
     1. 嵌入模型：一种将非结构化数据(如文本、图像、音频)转换为可以被计算机理解和处理的数值向量(如由1024或1536个数字组成的列表)的AI模型。把人类能看懂的文字，翻译成计算机能看懂的“数学语言”
        - 特性：能捕捉原始数据的语义，如“狗”和“宠物”的向量距离会比“狗”和“汽车”的向量距离近得多
        - 原理：通常基于大型语言模型（如BERT、GPT系列）进行训练。通过阅读海量文本学会将含义相似的词或句子映射到向量空间中相近的位置
        - 用途
          1. 搜索：不再只是匹配关键词，而是搜索含义相似的文本
          1. 聚类：将含义相近的文本自动分组
          1. 推荐：推荐与用户喜欢的内容在语义上相似的内容
          1. 异常检测：找出与其他数据在语义上差异很大的outlier
        - 分类
          1. API调用
             - OpenAI：text-embedding-3-small/text-embedding-3-large，最好的
             - Google：text-embedding-004
          1. 开源&可本地部署：通用顶尖
             - BGE系列：BGE-large-en-v1.5、BGE-large-zh-v1.5，开源翘楚，北京智源人工智能研究院
             - e5系列：e5-large-v2、e5-base-v2，性能强劲，微软
             - GTE系列：GTE-large、GTE-base，达摩院
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
     1. 高效：只会在Skill与当前任务相关时才使用，只会加载所需的最少信息和文件
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
     1. 执行任务：Claude会根据用户请求，自动调用相关的skill脚本和资源来完成任务
   - 最佳实践
     1. skill要小而专注
        - description明确触发条件，一定写清楚，有时候skill不起作用就是因为这
        - skill.md要包含具体示例
        - 分离确定性操作
        - 持续迭代
     1. 其他llm使用skill有挑战：claude官方对skill的规范描述的比较清晰，但对于llm怎么使用skill并没有详细描述
     1. 好用的
        - next-chat-skills：自动发现、安装、调用、新建skills的工具，能自动安装skill的依赖、出错自动修复
1. A2A
   - 认识：Agent-to-Agent，解决不同来源不同框架的agent之间高效、安全、互操作的开放的通信协议标准，google推出
     1. MCP解决智能体与工具/数据源的连接，A2A解决智能体之间的协作，二者互补
   - 工作模式
     1. 顺序流水线（Sequential Pipeline）
     1. 管理者-工作者（Manager-Worker）
     1. 民主共识（Democratic Consensus）：投票
     1. 竞争性（Competitive）
1. 理论
   - 规划策略：![](../images/ai/llm-strong-plan.jpg)
     1. CoT
        - 认识：Chain of Thought：链式思维，直接求解容易出错，引导模型一步一步地想，能极大提高其逻辑准确性
     1. Self-Consistency
        - 认识：多次采样，选择最一致的答案
     1. ToT
        - 认识：思维树，让llm进行“多路径推理”的提示策略，提升解决复杂问题的能力。从“链式”思考转变为“树状”探索
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
     1. ReAct
        - 认识：Reason + Acting，是一个方法论，基于动态推理与工具调用的智能体实现模式，其核心是让llm通过推理和行动的循环来完成任务
          1. 是通过组件拼装实现的高级任务解决策略和功能模式，和chain、graph区别在于是动态决定下一步
          1. 就是让大模型从一句话中找出来要调用的方法名和参数，然后代码执行即可
        - 步骤
          1. reasoning：模型自主分析问题，拆解步骤，如需要查询天气api
          1. acting：调用工具执行具体操作，并根据工具返回结果决定下一步动作
          1. 循环迭代：重复“推理-行动”直到任务完成或达到终止条件
        - 优点
          1. 透明：推理过程以文字形式展现出来，我们可以理解它的“思考过程”，便于调试和信任。
          1. 减少幻觉：通过外部工具获取事实信息，减少模型依赖内部知识、从而“胡编乱造”的可能性
          1. 能力增强：可调用工具
        - 流程
          1. 推理（Think/Reason）：决定下一步该做什么
          1. 行动（Act）：选择工具
          1. 观察（Observe）：接收执行后返回的结果
          1. 循环：基于新的观察结果，再次进行推理，决定下一步行动，如此循环，直到完成
#### openAI API
1. openAI
   - 认识
     1. 官方推荐的数据交互格式是json
1. openAI API交互模型
   - 文本
     1. completion：补全模式，适用于单次文本生成任务，核心功能是根据提示prompt进⾏提示语句的补全（即继续进行后续⽂本创作），它本质上是文本补全模型。如gpt-3.5-turbo
        ```python
        response = openai.Completion.create(            # 已经淘汰
           model="text-davinci-003",
           prompt="This is a test message",
           max_tokens=1000,
        )
        ```
     1. chat：对话模式，支持多轮对话，通过messages数组管理上下文，包含system、user、assistant三种角色。升级版，更常用。如gpt-4o
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
             - stream：是否流式输出
             - stop：遇到指定字符串时停止生成，对于控制模型输出的结构和长度非常有用
             - max_tokens：回复的最大token数
        - role分类
          1. system：系统消息，提供背景信息和指令，使得回答更加精准
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
                    {"role": "user", "content": "我是一个小白，我想入门AI领域，我需要学习哪些知识"},                   # 多条信息模型只会回答最后一条
                    
                    # 注意：这里通过设置role =  assistant可以告诉Chat模型，这个输入是模型返回的答案
                    {"role": "assistant", "content": "这里填写上一轮对话模型的回复"},
                    {"role": "user", "content": "关于第5条深度学习方面，你帮我更加详细的介绍一下"}
                ]
            )
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
     1. edit：编辑模式，用户提供待修改文本和修改指令，模型返回调整后的内容。用于文本润色、代码优化、语法修正。目前较少使用，部分功能已整合至chat模式
   - embedding：嵌入模式，将文本转换为向量表示，用于语义搜索、聚类、相似性匹配、知识检索等任务
     1. 不直接生成文本，而是提供数值化表示
     1. 适用于机器学习任务

   - responses api：响应模式，支持状态化交互，可集成外部工具（如mcp协议、文件搜索、代码解释器）
   - multi-agent：多代理模式，支持多个ai代理协同工作，如orchestrator-sub-agent模式或直接handoffs（子代理直接与用户交互）

   - vision：视觉模式，图像识别与分析，支持url或base64编码的图像输入
   - streaming：流式模式，支持实时流式返回生成内容，适用于长文本或动态交互
1. openAI的其他
   - Function calling
     1. 背景
        - 大模型的知识是有限的，无法获取最新的知识
        - 大模型能给出建议，但是无法直接解决
     1. 认识：函数调用，开发者描述函数给AI模型，然后模型可以智能地决定输出一个包含调用这些函数的参数的JSON对象
        - 大模型处理的步骤具体是
          1. 匹配给到大模型的外部函数库
          1. 选择合适的函数
          1. 根据函数逻辑给出回复
     1. 使用
        - 定义JSON Schema
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
        - 传入参数
          1. 参数组成
             - functions参数：声明外部函数库
             - function_call参数：控制是否执行Function calling功能
          1. 代码示例
            ```python
            functions = [calculate_total_age_from_split_json]
 ​
            response = openai.ChatCompletion.create(
                model="gpt-3.5-turbo-16k-0613",
                messages=messages,
                
                # 增加这两行
                functions=functions,
                function_call="auto",  
            )
            ```
        - 在本地执行外部函数，将计算过程和结果保存为message并追加到messages后面，并第二次调用Chat Completion模型分析函数的计算结果，并最终根据函数计算结果输出用户问题的答案
     1. 实践
        ```python
        // 对话小助理，while True执行具体的业务逻辑，然后通过依赖ChatConversation对话基类，这个基类又依赖AutoFunctionGenerator进行自动回复
        def chat_with_assistant(functions_list=None, 
            prompt="您好！", 
            model="gpt-3.5-turbo-16k-0613", 
            system_message="你是我的专属小助理"):
     
        # 创建ChatConversation实例
        chat_conversation = ChatConversation(model=model)
        
        # 添加系统消息和用户输入到messages列表中
        messages = [{"role": "system", "content": system_message}]
        messages.append({"role": "user", "content": prompt})
        chat_conversation.messages = messages
        
        while True:
            # 调用run方法处理对话，并得到模型的回答
            answer = chat_conversation.run(functions_list=functions_list)
            
            # 打印模型的回答
            print(f"模型回答: {answer}")
            
            # 添加模型的回答到messages列表中
            messages.append({"role": "assistant", "content": answer})
            
            # 询问用户是否还有其他问题
            user_input = input("如何没有其他问题，可以输入'退出'结束对话): ")
            
            # 如果用户输入'退出'，则结束对话
            if user_input.lower() == "退出":
                break
            
            # 添加用户的问题到messages列表中
            messages.append({"role": "user", "content": user_input})
            
            # 更新ChatConversation实例的messages列表
            chat_conversation.messages = messages


        # ChatConversation的定义——————————————————————————————————————————————————————————————————————————————————————————————
        class ChatConversation:
        """
        ChatConversation 类用于与 OpenAI GPT-3 模型进行聊天对话，并可选地调用外部功能函数。
        
        属性:
        - model (str): 使用的 OpenAI GPT模型名称。
        - messages (list): 存储与 GPT 模型之间的消息。
        - function_repository (dict): 存储可选的外部功能函数。
        
        方法:
        - __init__ : 初始化 ChatConversation 类。
        - add_functions : 添加外部功能函数到功能仓库。
        - _call_chat_model : 调用 OpenAI GPT 模型进行聊天。
        - run : 运行聊天会话并获取最终的响应。
        """
        def __init__(self, model="gpt-3.5-turbo-16k-0613"):
            """
            初始化ChatConversation类。
            """
            self.model = model
            self.messages = []
            self.function_repository = {}
        
        def add_functions(self, functions_list):
            """
            添加功能函数到功能仓库。
    ​
            参数:
            functions_list (list): 包含功能函数的列表。
            """
            self.function_repository = {func.__name__: func for func in functions_list}
    ​
        def _call_chat_model(self, functions=None, include_functions=False):
            """
            调用大模型。
    ​
            参数:
            functions (dict): 功能函数的描述。
            include_functions (bool): 是否包括功能函数和自动功能调用。
    ​
            返回:
            dict: 大模型的响应。
            """
            params = {
                "model": self.model,
                "messages": self.messages,
            }
    ​
            if include_functions:
                params['functions'] = functions
                params['function_call'] = "auto"
    ​
            try:
                return openai.ChatCompletion.create(**params)
            except Exception as e:
                print(f"Error calling chat model: {e}")
                return None
 ​
        def run(self, functions_list=None):
            """
            运行聊天会话，可能包括外部功能函数调用。
            
            参数:
            functions_list (list): 包含功能函数的列表。如果为 None，则只进行常规对话。
    ​
            返回:
            str: 最终的聊天模型响应。
            """
            try:
                # 如果不传入外部函数仓库，就进行常规的对话
                if functions_list is None:
                    response = self._call_chat_model()
                    final_response = response["choices"][0]["message"]["content"]
                    return final_response
                
                else:
                
                    # 添加功能函数到功能仓库
                    self.add_functions(functions_list)
    ​
                    # 如果存在外部的功能函数，生成每个功能函数对应的JSON Schema对象描述
                    functions = AutoFunctionGenerator(functions_list).auto_generate()
    ​
                    # 第一次调用大模型，获取到first reponse
                    response = self._call_chat_model(functions, include_functions=True)
                    response_message = response["choices"][0]["message"]
    ​
                    # 检查在first reponse中是否存在function_call，如果存在，说明需要调用到外部函数仓库
                    if "function_call" in response_message:
    ​
                        # 获取函数名
                        function_name = response_message["function_call"]["name"]
    ​
                        # 获取函数对象
                        function_call_exist = self.function_repository.get(function_name)
    ​
                        if not function_call_exist:
                            print(f"Function {function_name} not found in functions repository.")
                            return None
    ​
                        # 获取函数关键参数信息
                        function_args = json.loads(response_message["function_call"]["arguments"])
    ​
                        # 获取函数逻辑处理后的结果
                        function_response = function_call_exist(**function_args)
    ​
                        # messages = 原始输入 + first reponse + function_response
    ​
                        # messages中拼接first response消息
                        self.messages.append(response_message)  
                        # messages中拼接函数输出结果
                        self.messages.append(
                            {
                                "role": "function",
                                "name": function_name,
                                "content": function_response,
                            }
                        )  
    ​
    ​
                        # 第二次调用模型
                        second_response = self._call_chat_model()
    ​
                        # 获取最终的计算结果
                        final_response = second_response["choices"][0]["message"]["content"]
    ​
                    else:
                        final_response = response_message["content"]
    ​
                    return final_response
    ​
            except Exception as e:
                print(f"An error occurred: {e}")
                return None
        
        # 封装一个自动回复的方法，用于调用函数后自动追加message，是类ChatConversation的基础——————————————————————————————————————————————————————
        class AutoFunctionGenerator:
        """
        AutoFunctionGenerator 类用于自动生成一系列功能函数的 JSON Schema 描述。
        该类通过调用 OpenAI API，采用 Few-shot learning 的方式来生成这些描述。

        属性:
        - functions_list (list): 一个包含多个功能函数的列表。
        - max_attempts (int): 最大尝试次数，用于处理 API 调用失败的情况。
        
        方法:
        - __init__ : 初始化 AutoFunctionGenerator 类。
        - generate_function_descriptions : 自动生成功能函数的 JSON Schema 描述。
        - _call_openai_api : 调用 OpenAI API。
        - auto_generate : 自动生成功能函数的 JSON Schema 描述，并处理任何异常。
        """
        
        def __init__(self, functions_list, max_attempts=3):
            """
            初始化 AutoFunctionGenerator 类。

            参数:
            - functions_list (list): 一个包含多个功能函数的列表。
            - max_attempts (int): 最大尝试次数。
            """
            self.functions_list = functions_list
            self.max_attempts = max_attempts

        def generate_function_descriptions(self):
            """
            自动生成功能函数的 JSON Schema 描述。

            返回:
            - list: 包含 JSON Schema 描述的列表。
            """
            # 创建空列表，保存每个功能函数的JSON Schema描述
            functions = []
            
            for function in self.functions_list:
                
                # 读取指定函数的函数说明
                function_description = inspect.getdoc(function)
                
                # 读取函数的函数名
                function_name = function.__name__
                
                # 定义system role的Few-shot提示
                system_Q = "你是一位优秀的数据分析师，现在有一个函数的详细声明如下：%s" % function_description
                system_A = "计算年龄总和的函数，该函数从一个特定格式的JSON字符串中解析出DataFrame，然后计算所有人的年龄总和并以JSON格式返回结果。\
                            \n:param input_json: 必要参数，要求字符串类型，表示含有个体年龄数据的JSON格式字符串 \
                            \n:return: 计算完成后的所有人年龄总和，返回结果为JSON字符串类型对象"
                
                
                # 定义user role的Few-shot提示
                user_Q = "请根据这个函数声明，为我生成一个JSON Schema对象描述。这个描述应该清晰地标明函数的输入和输出规范。具体要求如下：\
                        1. 提取函数名称：%s，并将其用作JSON Schema中的'name'字段  \
                        2. 在JSON Schema对象中，设置函数的参数类型为'object'.\
                        3. 'properties'字段如果有参数，必须表示出字段的描述. \
                        4. 从函数声明中解析出函数的描述，并在JSON Schema中以中文字符形式表示在'description'字段.\
                        5. 识别函数声明中哪些参数是必需的，然后在JSON Schema的'required'字段中列出这些参数. \
                        6. 输出的应仅为符合上述要求的JSON Schema对象内容,不需要任何上下文修饰语句. "  % function_name

                user_A = "{'name': 'calculate_total_age_function', \
                                'description': '计算年龄总和的函数，从给定的JSON格式字符串（按'split'方向排列）中解析出DataFrame，计算所有人的年龄总和，并以JSON格式返回结果。 \
                                'parameters': {'type': 'object', \
                                                'properties': {'input_json': {'description': '执行计算年龄总和的数据集', 'type': 'string'}}, \
                                                'required': ['input_json']}}"
                
                
                # 定义输入

                system_message = "你是一位优秀的数据分析师，现在有一个函数的详细声明如下：%s" % function_description
                user_message = "请根据这个函数声明，为我生成一个JSON Schema对象描述。这个描述应该清晰地标明函数的输入和输出规范。具体要求如下：\
                                1. 提取函数名称：%s，并将其用作JSON Schema中的'name'字段  \
                                2. 在JSON Schema对象中，设置函数的参数类型为'object'.\
                                3. 'properties'字段如果有参数，必须表示出字段的描述. \
                                4. 从函数声明中解析出函数的描述，并在JSON Schema中以中文字符形式表示在'description'字段.\
                                5. 识别函数声明中哪些参数是必需的，然后在JSON Schema的'required'字段中列出这些参数. \
                                6. 输出的应仅为符合上述要求的JSON Schema对象内容,不需要任何上下文修饰语句. "  % function_name
                
                messages=[
                            {"role": "system", "content": "Q:" +  system_Q + user_Q + "A:" + system_A + user_A },

                            {"role": "user", "content": 'Q:' + system_message + user_message}
                ]

                response = self._call_openai_api(messages)
                functions.append(json.loads(response.choices[0].message['content']))
            return functions

        def _call_openai_api(self, messages):
            """
            私有方法，用于调用 OpenAI API。

            参数:
            - messages (list): 包含 API 所需信息的消息列表。

            返回:
            - object: API 调用的响应对象。
            """
            # 请根据您的实际情况修改此处的 API 调用
            return openai.ChatCompletion.create(
                model="gpt-3.5-turbo-16k-0613",
                messages=messages,
            )
        
        def auto_generate(self):
            """
            自动生成功能函数的 JSON Schema 描述，并处理任何异常。

            返回:
            - list: 包含 JSON Schema 描述的列表。

            异常:
            - 如果达到最大尝试次数，将抛出异常。
            """
            attempts = 0
            while attempts < self.max_attempts:
                try:
                    functions = self.generate_function_descriptions()
                    return functions
                except Exception as e:
                    attempts += 1
                    print(f"Error occurred: {e}")
                    if attempts >= self.max_attempts:
                        print("Reached maximum number of attempts. Terminating.")
                        raise
                    else:
                        print("Retrying...")
        ```
### AI应用
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
          1. 总结：总结后把原来的内容扔掉，会丢失细节，但是降低了大小。如claude的压缩方案有重点保存测试输出和代码改动
          1. 外化：
            - 移除不重要的、大段的
            - 向量化：越长的文本向量化效果越好，但是向量化的目的不是压缩，是语义化和可计算化
          1. 预算管理
            ```
            Token Budget Allocation
            - system: 10%
            - instruction: 10%
            - memory: 30%
            - history: 30%
            - tools/output: 20%
            ```
     1. 隔离context：不同的上下文之间是隔离的，常见于multi-agent中 
     1. 
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
   - 组成
     1. llm：大脑，充当协调者的智能体核心，某llm
     1. planning：规划，赋予智能体类似思维模式，精准拆解复杂任务，分步解决
        - 有反馈规划方法，如ReAct和Reflexion
     1. memory：记忆，管理智能体的过往行为
        - 形式：
          1. 短期：上下文窗口限制
          1. 长期：储存智能体的历史行为和思考，通过外部向量存储实现，以便快速检索重要信息
          1. 混合记忆：自然语言、嵌入向量、数据库或结构化列表等
        - 记忆格式
     1. tool：工具，提供使用的工具，如调用业务api、语音识别、图像识别、图表生成等
        - MRKL、Toolformer、函数调用(使其能够处理超出其训练数据范围的任务)、HuggingGPT
     1. 行动：依规划与记忆执行具体行动
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
   - Agent Loop
     1. 沙盒环境
   - 状态管理
   - 记忆系统
     1. 长期记忆
   - 工具集
   - 技能模块
   - 智能体团队
     1. 子智能体
     1. 消息网关
1. Claude Desktop
   - Cowork：AI Agent模式。把Claude从“聊天助手”升级为一个真正能替你在电脑上干活的AI同事，可以自动执行复杂的多步骤任务。如整理文件、分析excel、整理笔记为报告
     1. 常见能力
        - 文件操作
        - 文档生成
        - 数据分析
        - 自动化任务：多任务并行、定期
        - 操作应用：如浏览器
1. OpenClaw
   - 认识：
     1. 渐进式生长：累积知识、错误的不再犯，通过搭配SOUL.md、MEMORY.md不断积累更新
   - 组成
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
1. Pi Agent
   - 流程：用户发消息 → 加载session(jsonl历史)→ 构建上下文(system prompt+工具定义+对话历史)→ 进入while循环 → 调用llm(流式请求)→ 接收响应(text_delta/tool_call)→ 判断是否需工具调用 → 执行工具并收集结果 → 写回上下文 → 继续循环（直到完成）→ 持久化session(写入jsonl)→ 返回结果
   - 组成
     1. jsonl session管理
        - jsonl：即每行只能一条压缩的json数据
        - jsonl树结构：在json中标记自己的父级是谁(每条记录带id和parentId)，这样一点点往上推就能得到整个有分支的会话历史
     1. extension系统设计
        - 拒绝mcp，私有协议，用cli工具 + readme做渐进式发现，agent需要某个能力时，通过bash调用cli，按需付上下文成本。避免了mcp的一般情况下的13k~18k token预加载开销
     1. 极简system prompt：对赌未来模型能力，留给用户更多上下文，关键时刻安全性可能不足
   - 架构：四层分包架构，每层解决一个问题
     1. pi-ai
        - 认识：模型通信层，多供应商统一接口
        - 特性
          1. 统一流式接口：text_delta | toolcall_start | done | error —— 所有供应商统一输出格式
          1. 10+ 供应商支持：anthropic/openai/google/xai/groq/mistral/ollama/deepseek
          1. 一行代码切换模型：getmodel(provider, model) —— 不改业务逻辑，只换供应商
     1. pi-agent-core
        - 认识：agent循环层，业界共识架构
        - 特性
          1. while循环：即核心，无DAG、无编排引擎，`发消息 → 工具调用 → 执行 → 循环直到完成`
          1. 事件订阅系统：实时感知agent状态，message_update/tool_start/tool_end/done
          1. 流式处理：逐字符推流，ui实时更新。text_delta/toolcall_delta
     1. pi-coding-agent
        - 认识：交互式编码代理cli，开发者实际使用的入口
        - 特性
          1. session持久化：jsonl树结构，支持分支/恢复，原始历史一条不丢
          1. 内置工具：四工具。read · write · edit · bash：grep/find等通过bash调用
          1. extension系统
     1. pi-tui
        - 认识：终端ui层
        - 特性
          1. markdown渲染 + 语法高亮：差分渲染，只重绘变化行。比 claude code 闪烁少
          1. 多行编辑器 + tab自动补全：历史命令、vi快捷键支持
          1. synchronized output：终端缓冲区批量刷新，消除流式渲染的撕裂感
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
   - openclaw的名字历史：Clawdbot、Moltbot
   - agent其他产品
     1. Nanobot：4K行代码，理解AI Agent是怎么工作的，如工具调用循环、上下文管理、多轮对话状态
     1. KimiClaw：全球部署，封装的利用了Cloudflare的边缘网络
     1. PicoClaw：路由器、开发板适用

     1. Qclaw：对openclaw产品化封装变成傻瓜式的本地安装包，直连微信（使用微信下命令、操作微信🐶）
     1. WorkBuddy：CodeBuddy团队自己做的独立产品，偏商务（企业级的安全审计能力、支持多个im平台）
### AI开发
#### 开发框架
1. airflow
   - 认识：Apache Airflow，代码优先的编排、调度和监控工作流的开源平台，纯python代码定义DAGs的编程模式
     1. 调度能力极其强大，是n8n、dify等？？？
   - 概念
     1. DAG：有向无环图
        - Task：任务，一个节点
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
1. AutoGen
   - 认识：类似HuggingGPT，微软、python
1. CrewAI
   - 认识：角色化多个智能体的开源的ai编排平台，侧重于解决特定任务，如分析报告、决策，适用于股票分析、内容创作、研究自动化等业务流程
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
   - 认识：用于构建检索增强生成RAG系统的数据框架，解决给llm提供私有数据的问题。LLM看作是聪明但失忆的大脑，LlamaIndex就是为它打造的“外接硬盘和高效搜索引擎”，让它能随时读取和回忆你的专属知识
   - 功能
     1. 数据连接器：各种数据源，如本地文件(pdf/word/ppt)、数据库(sql, nosql)、api(notion/slack/discord)等
     1. 索引：将加载的非结构化或结构化数据转换成一种易于LLM查询的优化格式，将数据分割成块chunks，并创建向量嵌入embeddings，存储在向量数据库中，实现快速、准确的语义搜索
     1. 查询接口：提供一个自然的语言接口来向你索引的数据提问。它接收你的问题，在索引中检索最相关的上下文信息，然后将“问题+上下文”一起组装成一个提示prompt发送给LLM，从而得到一个基于你私有数据的准确回答
1. 开发平台
   - CozeLoop
   - Langfuse
     1. 认识：llm应用的观测、监控与分析平台，开源
   - langSmith
     1. 认识：LLM应用的开发运维LLMOps平台，提供了贯穿开发、测试、生产全周期的工具。是LLM应用的集成开发环境IDE+应用性能管理APM工具，LangGraph官方出品，闭源
        - 解决如提示词prompt难以调试、评估困难、监控缺失等问题
     1. 功能
        - debugging & tracing：调试和溯源，自动记录每次llm的调用的溯源图。看到输入、输出、耗时、成本，快速定位问题
        - testing & evaluation：测试和评估，创建数据集、运行批量测试等
        - monitoring：监控，延迟、错误率、输出质量，设置警报
        - collaboration：协作，共享提示模板、跟踪记录、数据集等
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
#### 开发平台
1. coze
   - coze studio：扣子开发平台
   - coze loop：扣子罗盘
1. Dify
   - 认识：简单快速创建AI应用的LLMOps平台，内置了构建LLM应用所需的关键技术栈
   - 功能
     1. 支持开箱即用的聊天对话模式的web站点
     1. 后端api(组件、上下文增强)

     1. 可视化Prompt编排界面、上下文、插件等
     1. 数据集管理(标注、改进）、日志等
     1. 兼容OpenAI、Langchain等多种LLM

     1. 高质量的RAG引擎
     1. 灵活的Agent框架
     1. 声明式YAML文件做配置
   - 组成
     1. 模型：系统推理、Embedding 文本嵌入、Rerank、TTS、ASR
   - 应用
     1. 交付结果：有鉴权的控制api、可二开的webApp、一套包含提示词工程、上下文管理、日志分析和标注的易用界面
     1. 分类
        - Chatbot 聊天助手：基于 LLM 构建对话式交互的助手
        - Text Generator 文本生成应用：面向文本生成类任务的助手，例如撰写故事、文本分类、翻译等
        - Agent：能够分解任务、推理思考、调用工具的对话式智能助手
        - Chatflow 对话流：适用于定义等复杂流程的多轮对话场景，具有记忆功能的应用编排方式
        - Workflow 工作流：适用于自动化、批处理等单轮生成类任务的场景的应用编排方式
   - 其他产品
     1. coze：字节跳动旗下
1. Ai浏览器
   - 认识：浏览器作为web主入口，仅仅展示数据太可惜了
   - 产品
     1. ChatGPT Atlas
     1. Tabbit
        - 智能代理模式（Agent）：录制Skill与脚本Script
        - 全能输入框：一键@所有数据，链接、截图、文件夹
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
#### 编程范式
1. 交互范式
   - prompt engineering：怎么问，通过调整提示词的措辞、格式和示例来获得更好的回答
   - context engineering：让ai看到什么，光提示词不够，要完善上下文
   - harness engineering：系统能预防/测量/修复什么
1. 编码范式
   - vibe coding：草图、快速探索，可靠性、完整性不足
     1. 适合快速实现、小工具；商业项目慎用、关键系统不可靠
   - spec-driven：蓝图、规范执行
     1. 能够实现既定目标
   - harness engineering：建筑工地、系统工程
     1. 设定边界和验收标准
1. vibe coding
   - 认识：氛围编程，氛围指的是开发者想表达的整体意图、风格、上下文和目标，让AI在“理解氛围”的情况下生成代码。即不需要精确写每一行代码，而是描述想做什么+怎么感觉比较对
   - 基本组成
     1. 任务氛围：想要实现什么
     1. 技术氛围：技术栈、代码风格
     1. 项目上下文
1. spec-driven
   - 认识：规范驱动开发，在做任何事/生成任何代码之前，必须先通过结构化的文档明确需求、设计与任务。就是说话先于代码，之前是先有代码后有文档
     1. 在于其方法论本身非常强大
     1. 解决AI编程需求理解偏差及工程质量不高等核心痛点
     1. AI编程2.0时代的轮廓：一个由规范驱动、流程严谨、人机协同的全新开发模式。从“能用”到“好用”，再到“专业”的需求升级
     1. 主要实现路径是强化和标准化规范的编写与使用，提升ai协作的清晰度和质量
   - spec kit框架
     1. 认识：GitHub开发的命令行工具
   - Kiro工具的使用方式
     1. 认识：亚马逊开发
     1. 需求分析 (Requirements)：requirements.md
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
   - 认识：TUI客户端+本地服务器的架构，天然支持“多客户端驱动同一个agent能力”，不只是终端里打一行命令那么简单
   - 组成
     1. 模块化实现
        - cmd 命令行入口
        - app 核心应用服务、config 配置管理、db 数据库与存储、llm 模型抽象层
        - message 消息管理、session 会话管理、lsp 语言服务器协议集成
     1. 工作流：llm + 工具调用，工具包括读写、bash、todowrite 任务编排、skill等
#### 编辑器
1. Codex
   - 功能
     1. 多Workspace管理：支持Workspace工作区，可以放多个项目
     1. 支持并行处理
     1. 内置Worktrees：对同一个项目并行开发，不会冲突，可以查看clean diff，即git的Worktree，相当与不同的git分支
     1. 支持Plan Mode
     1. 内置MCP、Skills管理界面
     1. 支持Automations自动化、定时任务
1. wiki
   - 其他编辑器
     1. Windsurf
     1. Augment：插件形式，上下文很强，复杂项目很给力，比cursor好用
     1. Roo Code：完全免费，对token的使用非常透明会有显示
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
   - 与其让每个环节都变复杂，不如让一个环节足够强，其他环节保持简单
     1. 不使用向量数据库/向量索引，只用grep和ripgrep。因为有足够聪明的大脑llm理解搜索结果
   - llm当指挥官，llm知道应该怎么做
     1. 工具决策、任务决策都交给llm
1. 组成
   - CLAUDE.md：写给Claude的规则、init会初始化项目简介、项目规范、代码风格、不能动的配置、工作流规则
     1. 简介、干净第一
     1. 应该是个索引，而不是大全
     1. 如果规则太多，就拆到rules/
   - MEMORY.md
   - .claude/
     1. 分类
        - 项目级
        - 全局级
     1. 组成
        - .claude/settings.json
        - .claude/skill/
        - .claude/hooks/
        - .claude/rules/
1. 功能
   - worktree：隔离支持，包括memory维度、agent维度
     1. 使用：`claude --worktree`，创建独立的git worktree并运行
   - /hook：支持各个操作节点添加钩子：支持本地shell命令和http hook
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
   - /loop：定时调度，直接写做什么，就直接能理解
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
   - /todos：让claude按顺序一个个做，支持任务依赖追踪
     1. 使用
        ```
        任务1: 创建数据库schema
        任务2: 写CRUD接口 (依赖任务1)
        任务3: 写单元测试 (依赖任务2)
        任务4: 写文档 (可以并行)
        ```
   - /simplify：代码审查和直接修复，从三个方面，之后再总结。代码复用性、代码质量和可维护性、性能和效率
     1. 对刚写完、"能跑就行"状态的代码特别有用。趁着context还新鲜，跑一遍/simplify，代码质量能上一个台阶。不适合在别人的代码上乱跑，那个需要上下文，让它随便改会出问题
   - /batch：跨文件、跨模块的大规模代码迁移
     1. 使用：`/batch 把 src/ 目录的组件从 React class 语法迁移到 hooks`
     1. 步骤：先展示一个迁移计划，然后把工作拆成若干个独立的工作单元，每个单元分配一个独立Agent、在独立的git worktree里运行，并行推进，互不干扰
   - /claude-api：把完整的Anthropic SDK参考注入到当前会话上下文里，避免开浏览器标签翻文档和当前上下文的频繁切换。包括各种编程语言的完整Claude API参考、工具使用模式和流式实现细节、消息批处理和结构化输出、常见坑的说明，如go、php、curl等
     1. 专门把某个领域的知识确定性地装进去
   
   - /plugins、/reload-plugins
     1. 认识：插件可以包含斜杠命令、Subagent定义、Hooks配置、MCP服务器配置、各种设置，还能发布到marketplace让别人用，成为团队的共同插件
     1. 常用插件
        - `claude plugin install code-simplifier`：保证功能的前提下的代码优化工具
        - `claude plugin install gopls/php/-lsp@claude-plugins-official`：支持lsp：真正理解代码的语义
   - /mcp
     1. 常用：`claude mcp add Laravel boost/k8s/grafana`
   - /skills
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

   - /agents：subagent，独立的专业分工的可并行执行的claude实例，有自己的上下文，后加&即可异步执行
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
   - agent teams
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
1. 特性
   - /memory：auto memory
     1. 认识：claude写给自己的笔记，claude主动维护
        - 前200行的硬上限自动加载进系统prompt，其他按需获取
        - 和CLAUDE.md冲突时，更具体的规则优先
     1. 结构
        ```
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
1. 使用
   - /init：分析当前repo，生成说明文档claude.md
     1. esc：暂停当前操作
     1. --add-dir：从额外的目录加载claude.md文件
   - /clear
   - /model：切换模型
     1. shift+tab：切换plan和自动编辑、yolo(更高权限)模式
     1. effort
        - 认识：推理强度，默认中等，绝大多数日常任务够用
          1. Opus 4.6用的是自适应思维（adaptive thinking），模型会根据任务的复杂程度自行判断推理深度
        - 操作
          1. --effort high、/model：设置强度
          1. ultrathink：单次超控，这次最高，下次恢复
   - /compact：压缩对话，不希望丢掉之前的记忆
     1. `Summarize from here`：只想压缩前半段，后面的几条消息还有用，前面的背景交代可以浓缩掉，对于超长session特别有用
   - /insights：分析当前claude code的工作成果和改进地方，分析你使用的特点和不足
   - /debug：让claude排查当前session的问题，如反应慢、某工具调用总是失败等
   - /status、/doctor
   - /cost：花费
   - /logout、/login
   - /chrome：claude in chrome，官方出品的浏览器控制插件
   - IDE集成：显示“IDE connected”，即可让IDE显示代码变更，就跟cursor一样
   - claude remote-control：支持手机或浏览器扫码，远程控制当前的claude
1. 原理
   - 认识：是一个Node.js应用，用ts写的
   - 提示词组装
     1. 认识
        - 根据状态、工具、模式动态组装出来的，类似数字人课件，是企业级的做法
        - 不是一个单一的长提示词，而是几十个模块化的提示词组合在一起，会用到变量替换、if判断等
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
     1. context window
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
        - 原则
          1. 核心是索引，不是存储
          1. 能从代码库中重新推导出的信息，绝不应该被存储
        - 分层：每次会话启动时按层加载
          1. user preferences：用户偏好，个人层面的习惯和偏好设置
          1. project claude.md：项目配置，当前项目的特定指令和上下文
          1. managed policy：组织级策略，企业或团队层面的统一规范
          1. auto-memory：自动学习模式，agent从历史交互中学到的用户模式
             - 允许agent学习用户工作模式，并写入memory.md供未来会话使用
             - 用户不需要反复解释相同的事情
          1. session：会话上下文，当前会话的临时信息
          1. sub-agent memory：子agent记忆，各子agent独立维护的专项记忆
        - 机制
          1. 下次调用时自动加载前200行记忆
          1. 记忆提取机制：会自动更新记忆
             - 触发时机：每轮回答完成后启动，有限流
             - 由独立fork agent完成：继承主对话上下文，但只能读文件和写入记忆目录，不能执行bash
     1. 权限系统
        - 工具调用都经过静态分析层的多层白名单校验：bashsecurity.ts里有23项编号的安全检查
          1. 18个被阻止的zsh内置命令
          1. 防御zsh equals expansion：=curl这种写法可以绕过对curl的权限检查
          1. unicode零宽字符注入
          1. ifs null-byte注入
          1. 一个在hackeron审查期间发现的恶意token绕过
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
### 最佳实践
1. 在ai开发中要摒弃一切都是确定的的传统思维，要相信llm可以像人一样灵活应变。
1. openclaw的提示词维度更加的高，并没有详细说明什么情况下应该怎么做，而是给出了理想和原则，是更高维度的提示词，是适配更高级模型的正确思路
1. 心得
   - compact压缩一次上下文就丢一次细节，越到后面越拉胯
     1. 记录关键决策可以减轻
   - 如果要处理确定性强的、不容有失的，可以使用流程编排等确定性手段
   - 模型能力的提升正在让"精心设计的 prompt"变得越来越不重要
1. 知识
   - 现在llm
     1. 上下文窗口一般为128k、256k，最大的1m
        - 类似live-sr、student-rtim-sr这种项目就是100~200k，live-class-sr是1m
     1. 参数量为数千亿→万亿级，通常是MoE(混合专家)实际每次只激活一部分参数，本地的是几亿(即几B)
1. 胡思乱想
   - 真正的高精尖技术都是从学术中来的，只考虑实现一个专有的场景，之后再添砖加瓦扩展到其他领域
     1. 如agent team功能从“分别从安全性、性能、测试覆盖率等不同角度同时审查代码，然后互相质疑和补充”开始mesh架构工作
     1. 那种一上来就要吃个胖子，面面俱到的往往无法获取成功
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
### wiki
1. 其他方面的应用
   - 图像应用
     1. 大模型：文生图像、图像编辑、图像扩展
        - gpt-image-2
        - dall-e：最新dall-e 3，openai的闭源
        - stable diffusion：生态丰富如lora微调、controlnet控制构图。stability ai开源的2022年发布
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
