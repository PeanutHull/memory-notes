### config
1. yaml
   - 认识：YAML Ain't a Markup Language，用于跨不同语言和框架的配置文件，xml子集，01年开始，后缀.yaml或.yml
     1. 缩进和冒号为主要特征，复杂
   - 举例
    ```conf
    key: 
        child-key: value
        child-key2: value2
        
    a1: abc  # string
    a2: true # boolean
    b1: nil  # string
    b2: null # null
    b3: NULL # null
    b4: NuLL # string

    c:
        x: c.x
        y: c.y
    e:
        - x: e[0].x
          y: e[0].y
        - x: e[1].x
          y: e[1].y
    ```
1. toml
   - 认识：Tom's Obvious，Minimal Language，目标成为最小的配置文件格式
     1. 语义精确，格式易于阅读
   - 特点
     1. 区分大小写
     1. 文件只能包含UTF-8编码的Unicode字符
     1. 空格表示制表符（0x09）或空格（0x20）
     1. 换行符表示LF（0x0A）或CRLF（0x0D0A）
   - 举例
    ```conf
    [server]
    name = "magic-lamp"
    port = "8000"
    mode = "test"
    debug = true

    [auth.ucenter]
    appID = ""
    secret = ""


    [f.A]
    x.y = "f.A.x.y"

    [f.B]
    x.y = """
    f.
        B.
            x.
                y
    """

    [f.C]
    points = [
        { x=1, y=1, z=0 },
        { x=2, y=4, z=0 },
        { x=3, y=9, z=0 },
    ]
    ```
1. dotenv项目：从.env文件加载配置到环境变量，认为配置要放在环境变量中，Ruby的
1. .ini