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
     1. AIGC：人工智能生成内容、UGC、PGC(专家)
     1. AGI：通用人工智能 Artificial General Intelligence，具备像人类一样全面智能的人工智能系统
        - 能够跨领域、跨任务地发挥作用
        - 具备学习、推理、感知、理解等多方面的能力
        - 是人工智能研究的最终目标之一，也是科幻小说和未来研究的一个共同主题
     1. 生成式人工智能（Generative AI）
### LLM
1. LLM
   - 认识：large language model 大语言模型，通过海量数据训练的、能识别人类语言、执行语言类任务、拥有大量参数的模型。![](../../images/ai/llm_model.png)
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
1. finetune
   - 认识：大模型微调，补充和强化LLM。还是基于冻结的模型(已经训练好不动的)，给大模型多次不同的黑盒向量数值，影响大模型的计算，进而最终得出最好的结果，就是微调llm
   - 概念
     1. 选择性微调：只更新部分参数，放在参数里，技术有Freeze、BitFit
     1. 加性微调：在模型中增加新的参数、模块，追在参数后，技术有Prompt-Tuning软提示、Adapter插入小型层
     1. 重参数化微调：技术有LoRA
   - Prompt-Tuning：RAG本质上还是属于硬提示的范围，只不过提供了更多准确的参考资料、用向量比文字更精确，并没有影响到llm本身，软提示是会影响llm的，是一种高级的提示工程，![](../../images/ai/prompt-tuning-type.jpg)
     1. 硬提示：人工设计，仅限于输入层
     1. 软提示：可进行训练，表现比硬的更稳定，增加一点模型参数
   - LoRA：低秩适应，插件式微调，对大语言模型进行个性化的特定任务的定制，其将模型的权重矩阵分解成低秩的相似矩阵，降低了参数空间的复杂性，从而减少微调的计算成本和模型存储
     1. 核心假设：权重更新（ΔW）其实具有较低的“内在秩”（Intrinsic Rank）。意思是，巨大的参数变化可以用一个更小的矩阵来近似表示。
   - PEFT
   - RLFT：人类反馈强化学习，让模型输出更适合人
   - 学习路径
     1. 模型量化：QLora/GPTQ
     1. PET/P - Tuning技术
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
     1. PGC(专业机构，如影视公司、专家等)、UGC、AIGC
     1. AGI：通用人工智能
     1. 模型压缩：让模型更小，成本减小；量化：降低浮点数精度；蒸馏：用参数量大的指导参数量小的；剪枝：删除不重要的特性
     1. vLLM：提升推理速度的大模型推理引擎
### AI应用
1. 认识
   - 大模型的强大的通用计算能力和涌现性，这使得其在应用开发中成本效益极高
     1. 历史过程
        - AI敏捷开发的新范式：利用大模型优化和自动化应用开发流程————就是让大模型生成代码，然后用于大模型理解并使用Function calling，就是让大模型生成大模型要干的活儿，现在看来这个东西已经成为通常的做法，是一种提高效率和能力的思想
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
        - 认识：Reason + Act，是一个方法论，让llm通过推理(Reasoning)和行动(Acting)的循环来完成任务
        - 优点
          1. 透明：推理过程以文字形式展现出来，我们可以理解它的“思考过程”，便于调试和信任。
          1. 减少幻觉：通过外部工具获取事实信息，减少模型依赖内部知识、从而“胡编乱造”的可能性
          1. 能力增强：可调用工具
        - 流程
          1. 推理（Think/Reason）：决定下一步该做什么
          1. 行动（Act）：选择工具
          1. 观察（Observe）：接收执行后返回的结果
          1. 循环：基于新的观察结果，再次进行推理，决定下一步行动，如此循环，直到完成
1. agent
   - 背景：大模型时代的人机交互范式，llm将结构化/非结构化的数据结合工具自动处理，变为了人和llm交互，![](../../images/ai/why_agent.jpg)
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
        - 有反馈规划方法：包括ReAct和Reflexion
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
     1. 交互方式
        - 嵌入：embedding，人类指定，ai执行
        - 副驾驶：copilot，人类和ai是伙伴关系共同完成任务，ai提供建议并协助任务，ai像知识丰富的伙伴而非工具
        - 智能体：agent，人类设定目标并提供资源，ai独立完成大部分工作，最后人类监督和评估结果
1. RAG
   - 认识：Retrieval Augmented Generation 检索增强生成，用于提升llm生成答案的准确性和时效性的技术框架
     1. 背景：LLM本身的知识滞后、可能“幻觉”两个缺陷，用RAG来增强
     1. 步骤
        - 检索：提出一个问题时，RAG系统先从向量化后的知识库中搜索与问题最相关的信息片段
        - 增强生成：将检索到的最新相关文档和原始问题打包在一起，形成“增强版的提示”。并指令“请根据以下提供的资料来回答问题”。这样LLM的回答就基于提供的最新的确凿的证据，而不是仅仅依赖它可能过时或不完整的内部知识，从而大大提高了回答的质量和可靠性
     1. 特点
        - 数据越规范，查询效果越好，结合树形结构或知识图谱结构的数据，RAG可以实现更好的效果
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
             - milvus：支持大规模数据，部署和维护相对复杂
             - lancedb：向量数据库里的SQLite
          1. 云服务
             - Pinecone
             - Redis，v7.0
             - PostgreSQL，pgvector扩展
   - 框架
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
   - 算法
     1. 余弦相似度
     1. 欧氏距离
   - wiki
     1. 数据蒸馏：将大型数据集浓缩为小型数据集
     1. embedding：是文本的数值表示，可以用来衡量两段文本之间的相关性。是一种将离散的符号或类别信息（如单词、字符或实体）映射到连续向量空间的技术，如将长文本编码为紧凑的高维向量、保持上下文连贯性
1. MCP
   - 认识：Model Context Protocol 模型上下文协议。解决ai模型与外部工具集成的高定制化问题，提供了一种跨模型、跨平台的统一标准。比openai的function calling更先进
     1. 发展历史
        - 2023.6.13：OpenAI宣布在Chat Completion模型中加入函数调用（Function calling）功能，全面开放16K对话长度的模型、降低模型调用资费等，这代表着Chat模型不再需要借助LangChain框架就可以直接在模型内部调用外部工具API
        - MCP：前openai高管、anthropic公司开发
   - 特点
     1. 一次标准化整合
     1. 实时双向通信
     1. 动态发现工具、即插即用
   - 组成
     1. mcp server
     1. mcp client：中介层，在mcp hosts中，处理与MCP服务器的通信，查询工具功能，管理请求/响应/通知
     1. mcp hosts：AI应用环境/载体，可以是agent、IDE
   - 步骤/workflow
     1. transfer layer
        - client发起initial request，server返回initial response
        - client发送notification
1. A2A
   - 认识：解决不同来源不同框架的agent之间高效、安全、互操作的开放的通信协议标准，google推出
     1. MCP解决智能体与工具/数据源的连接，A2A解决智能体之间的协作，二者互补
1. wiki
   - 聊天前端项目：open webUI（原名ollama webUI）、chatbox、Cherry Studio、Page Assist、chatbot-ui，类似gpt的界面
     1. chatbox的功能：文字聊天(markdown渲染、代码渲染、mermaid图像表格渲染、思维导图、语法高亮、内置html渲染)、联网搜索(网页爬取)、文件交互(图片)、调用mcp服务、本地化向量知识库、图像生成
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
1. 方法
   - 入门/基本：角色(Role) + 任务(Task) + 要求(Requirements) + 范例(Example)
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
        - shot learning：样本学习，根据已有的示例来指导模型生成回答
          1. zero-shot
          1. one-shot
          1. few-shot
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
     1. CoT：Chain of Thought：链式思维，直接求解容易出错，引导模型一步一步地想，能极大提高其逻辑准确性
        - 技巧：在提示词中加入“请逐步分析”、“分步思考并解答”、“让我们一步一步来解决这个问题”等指令
        - 举例
            ```conf
            问题：一个农场里有鸡和兔子共 35 头，它们共有 94 只脚。请问鸡和兔子各有多少只？

            请使用链式思维，一步步推理并解答这个问题。
            第一步：定义未知数。
            第二步：根据头的数量列出方程。
            第三-步：根据脚的数量列出方程。
            第四步：解这个方程组。
            第五步：给出最终答案。
            ```
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
1. 理解
   - 主要关注如何设计、构造和优化提示词prompt，以引导llm生成更准确、更有用、更符合用户需求的文本
   - 使用小模型时各种提示词方法都控制不了输出结果，换成更大更好的模型后，一句提示词就可以解决
1. 组成
   - 指示：任务描述
   - 上下文：背景信息
   - 例子：示范学习
   - 输入：数据输入
   - 输出：结果格式
1. 分类
   - 语言提示词工程：有局限性，但是灵活、快
   - 代码提示词工程：可以更加深入
1. CoT：思维链
   - One-shot、Few-shot：先给出一段相似的问题和答案，然后提问，就能增强模型的推理能力。问题越复杂，推理越难
   - Zero-shot-CoT：提示词尾部追加一句“Let’s think step by step”，深度思考模式
   - Few-shot-CoT：通过编写思维链样本作为提示词，让模型学会思维链的推导方式，从而更好的完成推导任务。结果不稳定
   - LtM提示法：LEAST-TO-MOST PROMPTING，让大模型自己找到解决当前问题的思维链，是一种Zer-shot-LtM方法，最为有效的提示学习方法。Few-Shot-LtM流程图：![](../../images/ai/Few-Shot-LtM_flow.jpeg)
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
1. 最佳实践
   - prompt描述的越准确，返回的结果越准确，表现上就是字数写的比较多
   - 数据标注是需要积累的核心的数据资产
   - 现在模型越来越强大，学的不再是沟通的技巧，而是说清楚自己的问题
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
             - temperature：控制输出的随机性
             - top_p：核采样概率，与temperature二选一
             - presence_penalty：避免重复话题
             - frequency_penalty：避免重复用词
             - logit_bias：调整特定 token 的生成概率
             - top_p
          1. 回复设置
             - stream：是否流式输出
             - stop：遇到指定字符串时停止生成
             - max_tokens：回复的最大 token 数
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
#### 开发框架
1. AutoGPT
   - 认识：能够利用llm的能力，自主决策并生成结果的ai智能体的开源项目，是ReAct一个非常强大和自动化的实现，python写的，autoGPT风格
   - 特点
     1. 自主性：只需要给出一个高级别的、模糊的目标，就会自动分解成一系列子任务并尝试完成，无需用户的任何干预
     1. 自我提示：会自己给自己生成提示，驱动ReAct循环。会思考“为了达成最终目标，我现在应该先做什么？”
     1. 多模态和能力：集成多种工具
     1. 记忆管理：解决llm的有限上下文窗口问题，引入了向量数据库等外部记忆体
1、 HuggingGPT
   - 认识：用一个中心llm来协调调用众多专家模型(其他领域的模型)共同完成复杂任务的系统框架。侧重多模态
     1. JARVIS是开源的代码实现，微软和浙江大学
1. AutoGen
   - 认识：类似HuggingGPT，微软、python
1. MetaGPT
   - 认识：将llm的能力与标准化软件工程流程（SOP）相结合的开源的多智能体框架
1. CrewAI
   - 认识：多智能体ai编排平台
1. coze
   - coze studio：扣子开发平台
   - coze loop：扣子罗盘
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
        - 架构：![](../../images/langchain-ChatGLM-struct.webp)
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
1. langSmith
   - 认识：LLM应用的开发运维LLMOps平台，提供了贯穿开发、测试、生产全周期的工具。是LLM应用的集成开发环境IDE+应用性能管理APM工具”
     1. 解决如提示词prompt难以调试、评估困难、监控缺失等问题
   - 功能
     1. debugging & tracing：调试和溯源，自动记录每次llm的调用的溯源图。看到输入、输出、耗时、成本，快速定位问题
     1. testing & evaluation：测试和评估，创建数据集、运行批量测试等
     1. monitoring：监控，延迟、错误率、输出质量，设置警报
     1. collaboration：协作，共享提示模板、跟踪记录、数据集等
1. Langfuse
   - 认识：llm应用的观测、监控与分析平台，是后台
1. FastGPT
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
     1. RAG：结合向量化知识库，通过语义检索召回相关信息，增强模型回答的准确性
        - 文档加载器和检索器组件
     1. 复杂逻辑编排：ReAct智能体通过graph编排实现自主决策，如模型判断是否调用工具（如天气查询api），并将工具结果作为下一轮输入，形成循环推理链，以及是否及时中断
     1. 内容生成、多模态：multicontent字段
     1. 扩展与集成能力：bindtools绑定外部api或自定义函数
   - 组成
     1. 功能组件
     1. prompt模板
     1. 流程编排
   - 功能组件
     1. ChatTemplate：接收外界输入，转化成预设格式的prompt交给模型

     1. Embedding：Retriever和Indexer的共同依赖，文本转向量，捕获文本语义
     1. Indexer：存储文件并建立索引，供后续Retriever使用
     1. Retriever：获取相关的上下文，让模型的输出基于高质量的事实

     1. ChatModel：与大模型交互，输入Message上下文，得到模型的输出Message
     1. Tool：与世界交互的工具，根据模型的输出，执行对应的动作

     1. Document Loader：加载指定的文本
     1. Document Transformer：按照特定规则转化指定的文本

     1. DataOperator
        - StreamOperator：流式数据支持     
     1. Lambda：用户定制function

     1. EinoDev：可视化工具
   - prompt模板
     1. 功能
        - 动态变量填充：将上下文数据（如用户输入、历史对话）自动插入模板
        - 多格式支持：兼容FString（Python 风格）、Jinja2（逻辑控制）等模板引擎
        - 角色定义：为模型设定行为风格（如客服、编程助手）
        - 工具描述集成：在ReAct模式中，自动生成工具调用指令
     1. 模版
        - FString：Formatted String Literals。简洁的 {variable} 占位符，适合简单插值，python v3.6+引入的字符串格式化方式，允许在字符串中直接嵌入表达式（变量、运算、函数调用等），使代码更简洁直观
            ```python
            # 伪代码：用户问答模板
            template = """
            你是一个专业客服，请回答用户问题：
            用户输入: {user_input}
            历史记录: {history}
            请用中文回复，不超过100字。
            """
            ```
        - Jinja2：支持条件判断、循环等逻辑的适合复杂场景的模板引擎
            ```python
            {% if user.role == "vip" %}             # 逻辑判断是控制块 {% %}
            尊贵的VIP用户，您的问题已优先处理：
            {{ user_input }}                        # 变量是表达式 {{ }}
            {% else %}
            您好，您的问题正在处理中：
            {{ user_input }}
            {% endif %}
            ```
        - ReAct专用模板
            ```python
            请根据任务决定是否需要调用工具：
            问题: {{question}}
            可用工具:
            - 天气查询: 输入地点，返回天气数据
            - 订单查询: 输入订单号，返回状态
            逐步思考后，按格式响应：
            Thought: <推理步骤>
            Action: <工具名|null>                   # 方法<>
            ActionInput: <参数>             # 方法<># 参数<>
            ```
     1. 功能
        - 模板继承
            ```jinja2
            {% extends "base_prompt.j2" %}
            {% block content %}用户问题: {{input}}{% endblock %}
            ```
        - 自动变量补全：`{{time|default:"2024-07-15"}}`
        - 多模态支持：`![image]({{image_url}})`
   - 流程编排
     1. 概念
        - 节点：node
        - 边：edge，节点之间的关系
        - 分支：branch，节点之间的分支关系
     1. 实现方式
        - chain：线性执行多个数据处理步骤，链式有向图，始终向前
        - graph：有向图，有最大的灵活性，通过可视化节点（如分支、循环）实现复杂条件逻辑
     1. 可实现的模式
        - ReAct：reasoning + acting，基于动态推理与工具调用的智能体实现模式，是通过组件拼装实现的高级功能模式。和chain、graph区别在于是动态决定下一步，是Eino支持的一种高级任务解决策略、或者动态组合出“推理-行动”的循环能力。就是让大模型从一句话中找出来要调用的方法名和参数，然后代码执行即可
          1. 认识
             - reasoning：模型自主分析问题，拆解步骤，如需要查询天气api
             - acting：调用工具执行具体操作，并根据工具返回结果决定下一步动作
             - 循环迭代：重复“推理-行动”直到任务完成或达到终止条件
          1. 实现本质
             - 通过prompt模板引导模型生成推理步骤，包含工具描述、推理步骤占位符等
             - 通过graph的循环实现“行动结果→重新推理”的闭环
             - 通过tool绑定提供可调用的外部能力，如api、数据库
          1. 示例
            ```go
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
            `
            ```
   - 功能
     1. Compose：声明式地组合多个组件或逻辑单元，构建数据处理流程。将独立模块（如模型调用、工具执行、数据处理）串联成可复用的任务流水线
        - Compose快速组合线性/简单分支逻辑，Graph处理复杂拓扑（循环、多分支）
   - 高级功能
     1. 并发处理、扇入扇出、通用横切面、option分配
   - 实例
     1. 图编排
        ```go
        // 定义查询工具
        dbTool := eino.BindTool("photo_db", func(query Query) Result {
            return DB.Execute("SELECT * FROM photos WHERE year=? ORDER BY size", query.Year)
        })

        // 图编排
        graph := eino.NewGraph().
            AddNode("parse_input", ChatModel.WithPrompt(intent_prompt)).
            AddNode("query_db", dbTool).
            AddEdge("parse_input", "query_db", eino.IfNeedTool())

        // 执行
        result := graph.Run(userInput)
        ```
     1. Hertz路由中处理SSE连接
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
#### 应用平台
1. coze：字节跳动旗下
##### Dify
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
1. 组成
   - 模型
     1. 分类：系统推理、Embedding 文本嵌入、Rerank、TTS、ASR
   - 应用
     1. 交付结果：有鉴权的控制api、可二开的webApp、一套包含提示词工程、上下文管理、日志分析和标注的易用界面
     1. 分类
        - Chatbot 聊天助手：基于 LLM 构建对话式交互的助手
        - Text Generator 文本生成应用：面向文本生成类任务的助手，例如撰写故事、文本分类、翻译等
        - Agent：能够分解任务、推理思考、调用工具的对话式智能助手
        - Chatflow 对话流：适用于定义等复杂流程的多轮对话场景，具有记忆功能的应用编排方式
        - Workflow 工作流：适用于自动化、批处理等单轮生成类任务的场景的应用编排方式
#### 最佳实践
1. 最佳实践
   - 如何使用：和AI协作就像带新人，目标明确、步骤细化、实时盯进度，才能高效拿到结果
     1. 描述清晰目标
     1. 拆解步骤：别指望一个prompt搞定所有事，必须把开发分成小步骤，精准控制prompt
     1. 迭代验证：让ai每步汇报进展，人检查通过后再往下走，大幅减少幻觉
   - 提示词prompt是进入的门槛，也是基础
   - ai做的是执行层，思考层还要人来，帮助人更好的思考
   - 大模型最与众不同的能力是意图提取，是自然语言理解
1. 大模型的用法
   - 认识
     1. 模型的能力快到达极限，前10名的能力差距从10%缩小到5%
   - 方法
     1. 方法一：system中提示类似RAG的很多的数据，让大模型更加了解，从而提升回答的准确性
     1. 方法二：system中写入多轮对话，或者使用user和assistant告诉大模型多轮对话的结果。所以如何用system来提供背景信息是关键的技术手段
        - 超大规模的本地文本采用时间窗口算法，会产生遗忘，可以用总结全面且关键的信息的方式提升效果
        - 实时匹配用户的问题来选取不同的prompt，将与用户问题相关性最高的文本片段以system消息形式输入模型，然后再获取回答
   - 实现的效果
     1. 可以实现一个本地知识库问答系统，根据库中知识实时喂给大模型来实现问答
1. 使用高级设置
   - 大模型的topP、topK
   - 提示词模版
   - mcp调用是提示词还是function calling
   - 向量库的切分模式、向量维度的调整
### wiki
1. 图像和视频应用
   - 大模型
     1. Sora：文生视频、图生视频、视频编辑与扩展，OpenAI的闭源
     1. DALL-E：文生图像、图像编辑、图像扩展，最新DALL-E 3，OpenAI的闭源
     1. Stable Diffusion：文生图像，生态丰富如LoRA微调、ControlNet控制构图。Stability AI开源的2022年发布
   - 应用平台
     1. 国外
        - Midjourney
        - Runway Gen
        - Pika Labs
     1. 国内平台
        - 可灵Kling：快手
        - 即梦AI Dreamina：剪映
        - 海螺AI
1. 图像翻译
   - 分类：配对、非配对
   - 应用
     1. 风格迁移：斑马变成黑马、文字换字体
     1. 人脸卡通化
     1. 虚拟试衣
     1. 换脸
     1. 照片上色：老照片上色
     1. 超分辨率：模糊图变清晰
   - 操作三部曲：pix2pix、pix2pixHD、vid2vid
   - 换脸：使用UNI2I框架
1. 语音应用
   - 精品SFT复刻语料要求：
     1. 同一说话人至少60分钟音频，最好是同一状态下的音频。并匹配准确的逐字稿。
     1. 最好是专业录制设备在录音棚录制，无背景噪声，无回声混响，信噪比大于40dB
     1. 录音条件为在录音状态下的正式录音，保证平稳完整输出频率
     1. 录音文件要包含录制者习惯或需要的气口、情绪起伏及长段文字播读
     1. 录音时保证话筒或录制设备与播讲人保持的距离尽量一致，防止因声音忽大忽小影响复刻效果
     1. 单声道，无压缩PCM WAV格式，44100以上采样率，16bit以上位深度
1. ai在游戏上的应用
   - 海龟蘑菇汤
     1. 场景：游戏中需要主持人作准确的语义理解
     1. 效果：语义理解准确度在90%以上
     1. 问题
        - 降低大模型应用的费用：GPT-4的成本较高，单次Demo体验下来的token消耗大概在10-15美元左右，一开始估算平均每个用户使用 token 的成本在 140 人民币左右
          1. 控制token消耗：包括保存问题库、近似检索、模仿搜索引擎的Auto Complete提示等，即直接保存了问题结果进行回答，用类似传统搜索引擎的技术支持的，绕过了大模型的支持。同一个问题，大模型只需要回答一次
        - 为什么选择费用最贵的GPT-4：测试过市面上所有的模型，得出了GPT4是最贵的，但也是正确率最高的，不怕最贵，但求最好
   - Suck Up
     1. 场景：玩家欺骗ai支撑的NPC来达到目的(吸血)，推动游戏发展
     1. 效果：ai驱动的npc带来不确定性和惊喜
     1. 问题
        - 加入“信任系统”来平衡游戏关卡的难度
        - 缩短ai反馈的速度：增强反应速度并降低大模型幻觉
          1. 提示词方法：预先准备好答案
