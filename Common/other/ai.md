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
     1. pytorch：facebook，caffe伯克利，caffe2慢慢被PyTorch取代
     1. DeepSpeed：Microsoft
     1. MXNet：apache
   - 训练数据集
     1. MNIST
     1. VOC
     1. COCO
     1. ImageNet
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
     1. token：将文本、音频、视频分解成基本单位，大语言模型中基于token进行上下文长度计算
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
   - 操作
     1. finetune：微调，补充和强化LLM。如使用中文数据集微调LLaMA 3 8B可大幅提升中文能力
     1. LoRA：插件式微调，对大语言模型进行个性化的特定任务的定制，其将模型的权重矩阵分解成低秩的相似矩阵，降低了参数空间的复杂性，从而减少微调的计算成本和模型存储
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
     1. llm越狱：安全机制，避免生成不当内容
     1. maas：模型即服务 model as a service，提供api接口的llm服务，如Hugging Face
     1. 模型厂家
        - 有名
          1. GPT
             - GPT-4o：2024-05
             - GPT-4.5：2025-02
          1. Claude
             - Claude 3.7：2025-02
          1. Gemini
          1. Copilot
          1. Mistral
          1. BERT
          1. RoBERTa
        - 国内：通义、文心一言、智谱清言、豆包、kimi、百小应、讯飞星火、海螺
        - 开源：ChatGLM、BLOOM、LLaMA
     1. 大模型如何理解Jinja2，加深大模型处理模式的理解
        - 预训练数据的广泛覆盖
          1. 接触过海量的开源代码、技术文档和论坛内容
          1. 模式识别能力：模型通过统计规律学会{}包裹的内容通常表示变量、{%%}和{{}}是Jinja2的控制块和表达式标记
        - 指令微调：微调阶段会被显式训练处理某种特定数据，并由人类反馈
        - 上下文学习：prompt的明确引导
        - 通用文本模式迁移：符号逻辑的泛化能力，将if-else的逻辑从自然语言如果...否则...迁移到 {% if %}
1. prompt engineering
   - 认识：提示词工程，用于引导和启发llm生成更高质量的回答，是目前和llm交互的核心方式。将人工经验与复杂计算完美结合
     1. llm已经学习到了一些通用的知识和推理能力，是通过提示词细化模型的推理过程来引导模型发挥其潜力
     1. 简单的提示词
        添加简单的提示词尾缀：如 “请模型一步步思考、一步步解答...”。
        提供标准的回答模板：“请按照示例答复...”。
        进行角色身份设定：“请以XXX的身份答复...”。
     1. 好的提示词
        有效地指导模型思考。
        依赖人工经验和技术创新构造复杂串联或嵌套的提示流程。
     1. 用于弥补现阶段llm能力的不足，随着llm的能力提升，提示词工程的作用会越来越小
   - 方法
     1. shot learning：样本学习，根据已有的示例来指导模型生成回答
        - zero-shot
        - one-shot
        - few-shot
     1. CoT：Chain of Thought：思维链，将复杂任务拆解为多个简单的子任务
     1. 寄存器（Scratchpad）等等
   - 原则
     1. 清晰明确的问题描述：提供清晰、明确的问题描述，使模型能够准确理解问题的意图并给出准确的回答。避免模糊、含糊不清或歧义性的问题描述。比如：目的是希望输出是一个逗号分隔的列表，请要求它返回一个逗号分隔的列表。Prompt思路：如果希望它在不知道答案时说“我不知道”，请告诉它“如果您不知道答案，请说“我不知道”。
     1. 提供必要的上下文信息：根据具体情况，提供适当的上下文信息，以帮助模型更好地理解问题。上下文信息可以是相关背景、之前提及的内容或其他相关细节。
     1. 将复杂任务拆分为更简单的子任务和提供关键信息：如果问题较为复杂或需要特定的答案，可以将复杂任务拆分为更简单的子任务，逐步提供关键信息，以帮助模型更好地理解和解决问题。
     1. 避免亢余或多余的信息：尽量避免提供亢余或不必要的信息，以免干扰模型的理解和回答。保持问题简洁明了，并提供与问题相关的关键信息
     1. 验证和追问回答：对于模型给出的答案，进行验证和追问，确保回答的准确性和合理性。如有需要，提供反馈或额外的说明，以进一步指导模型的回答。
     1. 尝试不同的表达方式：如果模型对于某个特定问题无法准确回答，尝试以不同的表达方式或角度提问，给出更多的线索，帮助模型理解并给出正确的回答。
     1. 生成多种输出，然后使用模型选择最好的一个
   - 理解
     1. 主要关注如何设计、构造和优化提示词prompt，以引导llm生成更准确、更有用、更符合用户需求的文本
     1. 使用小模型时各种提示词方法都控制不了输出结果，换成更大更好的模型后，一句提示词就可以解决
   - 组成
     1. 指示：任务描述
     1. 上下文：背景信息
     1. 例子：示范学习
     1. 输入：数据输入
     1. 输出：结果格式
   - 最佳实践
     1. prompt描述的越准确，返回的结果越准确，表现上就是字数写的比较多
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
     1. chat：对话模式，支持多轮对话，通过messages数组管理上下文，包含system、user、assistant三种角色。如gpt-4o
        - role分类
          1. system：系统消息，提供背景信息和指令
          1. user：用户消息，用户输入的内容
          1. assistant：助手消息，助手生成的回复
        - 实例
            ```python
            // 多轮会话
            // 1. 直接累计上下文都传过去
            completion_second = openai.ChatCompletion.create(
                model="gpt-3.5-turbo-16k-0613",
                messages=[
                    {"role": "system", "content": "你是一位精通机器学习和自然语言处理的AI领域专家，具备20年相关经验"}, 
                    {"role": "user", "content": "我是一个小白，我想入门AI领域，我需要学习哪些知识"},
                    
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

            ```
     1. edit：编辑模式，用户提供待修改文本和修改指令，模型返回调整后的内容。用于文本润色、代码优化、语法修正。目前较少使用，部分功能已整合至chat模式
   - embedding：嵌入模式，将文本转换为向量表示，用于语义搜索、聚类、相似性匹配、知识检索等任务
     1. 不直接生成文本，而是提供数值化表示
     1. 适用于机器学习任务

   - responses api：响应模式，支持状态化交互，可集成外部工具（如mcp协议、文件搜索、代码解释器）
   - multi-agent：多代理模式，支持多个ai代理协同工作，如orchestrator-sub-agent模式或直接handoffs（子代理直接与用户交互）

   - vision：视觉模式，图像识别与分析，支持url或base64编码的图像输入
   - streaming：流式模式，支持实时流式返回生成内容，适用于长文本或动态交互
1. Agent
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
1. 应用
   - dify
   - LangChain
     1. 认识：用于语言模型和应用程序开发的开源框架，简化与LLMs的交互，整合数据检索和功能模块，从而构建端到端的应用程序，由Lang.AI开发
     1. 功能
        - 模型集成：支持OpenAI的GPT系列、Google的LaMDA、Meta的LLaMa等
        - 数据集成：提供如文件、数据库、搜索引擎等数据源集成的能力
        - 链式调用：创建一系列可以顺序执行的语言模型调用和其他操作的链
        - 提供上下文感知与逻辑推理：允许开发者将多个预训练模型进行联合推理
        - 预制链与组件：包含大量预制链和组件，方便开发
     1. 项目
        - langchain-ChatGLM
           1. 认识：利用ChatGLM-6B + langchain实现的基于本地知识的问答机器人，如淘宝衣服尺寸机器人
           1. 架构：![](../../images/langchain-ChatGLM-struct.webp)
   - 其他
     1. FastGPT
     1. Coze：字节跳动旗下的AI聊天机器人开发平台
1. 数据
   - 矢量/向量数据库：可以存储和管理大量的矢量数据，如图像、文本、音视频，提供高效检索功能，存储非结构化的数据和对比
   - RAG：Retrieval Augmented Generation 检索增强生成
     1. 主要的应用场景是企业客服系统和搜索结果结构化展示（代表作是Perplexity和秘塔）
     1. 对数据的规范程度要求比较高，数据越规范，查询效果越好，结合树形结构或知识图谱结构的数据，RAG可以实现更好的效果
     1. 为Agent提供了额外的知识来源
     1. 框架：Cohere、Cognita
   - 数据蒸馏：将大数据集浓缩为小型数据
   - embedding：是文本的数值表示，可以用来衡量两段文本之间的相关性。是一种将离散的符号或类别信息（如单词、字符或实体）映射到连续向量空间的技术，如将长文本编码为紧凑的高维向量、保持上下文连贯性
1. 最佳实践
   - 如何使用：和AI协作就像带新人，目标明确、步骤细化、实时盯进度，才能高效拿到结果
     1. 描述清晰目标
     1. 拆解步骤：别指望一个prompt搞定所有事，必须把开发分成小步骤，精准控制prompt
     1. 迭代验证：让ai每步汇报进展，人检查通过后再往下走，大幅减少幻觉
   - 提示词prompt是进入的门槛，也是基础
   - ai做的是执行层，思考层还要人来，帮助人更好的思考
1. wiki
   - MCP：Model Context Protocol 模型上下文协议。解决 AI 模型与外部工具集成的高定制化问题，提供了一种跨模型、跨平台的统一标准。比OpenAI的Function Calling更先进，前OpenAI高管搞的
   - semantic kernel：用于自然语言处理和信息检索的技术。微软研发的一个开源的、面向大模型的开发框架（SDK）
     1. 应用场景
        - 问答系统：用户可以从可信的源文档（如公司内部文档）中提问并获得答案
        - 聊天和会话创建：开发者可以使用Semantic Kernel构建聊天机器人，实现自动化的问答和对话功能
        - 数据处理：包括结构化和非结构化数据的处理，如分析产品反馈情绪、分析支持电话和记录等
        - 代码生成或转换：例如，将一种编程语言转换为另一种，为函数生成文档字符串等
        - 新闻内容创作：用于创建新的新闻内容或重写用户提交的新闻内容，作为预定义主题的写作辅助
   - 本地部署LLM工具：个人电脑运行LLM，一般最大只能运行20B以下的模型，33B模型需要32G显存
     1. 比较适合本地运行的是Phi 3 Medium（14B）、LLaMA 3 8B、Mistral 7B
     1. 推荐以下两个客户端：Ollama； LM Studio
     1. 工具：ollama、langChain、langGraph、langSmith、LlamaIndex、Haystack
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
     1. 复杂逻辑编排：react智能体通过graph编排实现自主决策，如模型判断是否调用工具（如天气查询api），并将工具结果作为下一轮输入，形成循环推理链，以及是否及时中断
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
#### Dify
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

### 图像
### 视频
1. 大模型
   - Sora：openai的文生视频
   - Stable Diffusion：由CompVis、Stability AI和LAION的研究人员于2022年联合发布
   - DALL-E：
1. 国外平台
   - midjourney：基于Stable Diffusion网络模型开发
   - runway gen2
1. 国内平台
   - 可灵Kling：快手
   - 即梦AI Dreamina：剪映
   - 智谱
### 最佳实践
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
