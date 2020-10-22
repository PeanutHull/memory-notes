### 基础
1. 数据类型转换
    ```go
    var f float64 = float64(i)
    // 或者
    f := float64(i)
    ```
1. 常量
    ```go
    // 数值常量，表示高精度的值
    const (
        Big   = 1 << 100
        Small = Big >> 99
    )
    ```
1. if
    ```go
    // 便捷写法，但是变量作用域仅在if范围，包括else范围
    if v := math.Pow(x, n); v < lim {
    }
    ```
1. switch
    ```go
    // 没有条件的switch，代替冗长的if-then-else
    switch {
    case t.Hour() < 12:
    case t.Hour() < 17:
    default:
    }
    ```
1. for简写
    ```go
    for ; sum < 10; {       // 前/后置语句为空，和c、java一样
        sum += sum
    }
    ```
1. 死循环：`for {}`
1. 函数
    ```go
    // 多值返回
    func swap(x, y string) (string, string) {           // 缩写参数类型
        return y, x
    }
    a, b := swap("hello", "world")
    // 命名返回值
    func split(sum int) (x, y int) {                    // x/y为返回值，为变量。长函数中使用会影响可读性
        x = sum * 4 / 9
        y = sum - x
        return
    }
    // 函数作为参数、返回值
    hypot := func compute(fn func(float64, float64) float64) float64 {
        return fn(3, 4)
    }
    ```
1. 在结构体上定义方法
    ```go
    func (v *vertex) Add() float64 {
	    return v.X + v.Y
    }
    v := &vertex{3, 4}
    v.Abs()                 // 使用
    ```
1. 指针访问结构体
    ```go
    v := vertex{1, 2}
	p := &v
    p.X
    ```
1. 打印
   - `fmt.Printf("s[%d] == %d\n", i, s[i])`
     1. %s：字符串
     1. %d：数字
     1. %v：slice
   - `fmt.Println(m)`
1. goroutine的斐波那契数列
    ```go
    func fibonacci(c, quit chan int) {
        x, y := 0, 1
        for {
            select {
            case c <- x:
                x, y = y, x+y
            case <-quit:
                fmt.Println("quit")
                return
            }
        }
    }

    func main() {
        c := make(chan int)
        quit := make(chan int)
        go func() {
            for i := 0; i < 10; i++ {
                fmt.Println(<-c)
            }
            quit <- 0
        }()
        fibonacci(c, quit)
    }
    ```
1. 闭包
    ```go
    // 闭包，闭包是一个函数值，来自函数体的外部的变量引用，函数可以对这个引用值进行访问和赋值；换句话说这个函数被“绑定”在这个变量上
    func adder() func(int) int {   // 函数adder返回一个闭包。每个闭包都被绑定到其各自的sum变量上，pos按照pos的节奏，neg按照..，两个独立变量被赋值
        sum := 0
        return func(x int) int {
            sum += x
            return sum
        }
    }
    pos, neg := adder(), adder()
    for i := 0; i < 10; i++ {
        fmt.Println(
            pos(i),
            neg(-2*i),
        )
    }
    ```
1. aes加解密
    ```go
    import (
        "crypto/aes"
        "crypto/cipher"
        "fmt"
        "os"
    )

    var commonIV = []byte{0x00, 0x01, 0x02, 0x03, 0x04, 0x05, 0x06, 0x07, 0x08, 0x09, 0x0a, 0x0b, 0x0c, 0x0d, 0x0e, 0x0f}

    func main() {
        //需要去加密的字符串
        plaintext := []byte("My name is Astaxie")
        //如果传入加密串的话，plaint就是传入的字符串
        if len(os.Args) > 1 {
            plaintext = []byte(os.Args[1])
        }

        //aes的加密字符串
        key_text := "astaxie12798akljzmknm.ahkjkljl;k"
        if len(os.Args) > 2 {
            key_text = os.Args[2]
        }

        fmt.Println(len(key_text))

        // 创建加密算法aes
        c, err := aes.NewCipher([]byte(key_text))
        if err != nil {
            fmt.Printf("Error: NewCipher(%d bytes) = %s", len(key_text), err)
            os.Exit(-1)
        }

        //加密字符串
        cfb := cipher.NewCFBEncrypter(c, commonIV)
        ciphertext := make([]byte, len(plaintext))
        cfb.XORKeyStream(ciphertext, plaintext)
        fmt.Printf("%s=>%x\n", plaintext, ciphertext)

        // 解密字符串
        cfbdec := cipher.NewCFBDecrypter(c, commonIV)
        plaintextCopy := make([]byte, len(plaintext))
        cfbdec.XORKeyStream(plaintextCopy, ciphertext)
        fmt.Printf("%x=>%s\n", ciphertext, plaintextCopy)
    }
    ```
1. 自定义时间格式
    ```go
    en["date_format"]="%Y-%m-%d %H:%M:%S"
    cn["date_format"]="%Y年%m月%d日 %H时%M分%S秒"

    fmt.Println(date(msg(lang,"date_format"),t))

    func date(fomate string,t time.Time) string{
        year, month, day = t.Date()
        hour, min, sec = t.Clock()
        //解析相应的%Y %m %d %H %M %S然后返回信息
        //%Y 替换成2012
        //%m 替换成10
        //%d 替换成24
    }
    ```
### skill
1. 语言编程基础
   - 关键词和语法（Language Syntax）
   - 数据类型（Arrays, Slices and Maps）
   - 流程控制（if/else，for/range）
   - Go 函数（Function）
   - 面向对象（Methods, Interfaces and Embedding）
   - 包处理（Packaging and Exporting）
   - Go 指针（Using Pointers）
   - 程序测试（Testing and Debugging）
   - 对象合成（Composition）
   - 错误处理（Error Handling）
   - 标准库（Standard Library）
   - 反射（Reflection）
1. web编程
   - Web基础
     1. Web工作方式
     1. Go 搭建一个简单的web服务
     1. Go 的 HTTP 包详解
   - 表单
     1. 处理表单的输入
     1. 验证表单的输入
     1. 预防跨站脚本
     1.  防止多次递交表单
     1. 处理文件上传
   - 数据库
     1. database/sql接口
     1. 使用MySQL数据库
     1. 使用PostgreSQL数据库
     1. 使用beedb库进行ORM开发
     1. NOSQL数据库操作
   - Session 和数据存储
     1. Session 和 Cookie
     1. Go 如何使用 Session
     1. Session 存储
     1. 预防 Session 劫持
   - 文本文件处理
     1. XML 处理
     1. JSON 处理
     1. 正则处理
     1. 模板处理
     1. 文件操作
     1. 字符串处理
   - Web服务
     1. Socket 编程
     1. WebSocket
     1. REST
   - 安全与加密
     1. 预防 CSRF 攻击
     1. 确保输入过滤
     1. 避免 XSS 攻击
     1. 避免 SQL 注入
     1. 存储密码
     1. 加密和解密数据
   - 错误处理，调试和测试
     1. 错误处理
     1. 使用GDB调试
     1. Go怎么写测试用例
   - 部署与维护
     1. 应用日志
     1. 网站错误处理
     1. 应用部署
     1. 备份和恢复
   - 如何设计一个Web框架　
     1. 项目规划　
     1. 自定义路由器设计
     1. Controller 设计
     1. 日志和配置设计
     1. 实现博客的增删改
   - 扩展Web框架
     1. 静态文件支持
     1. Session 支持
     1. 表单支持
     1. 用户认证
     1. 多语言支持
     1. pprof支持
1. 并发编程
   - Go 并发基础（Concurrency, Race Conditions and Channels）
   - 并发模式（Concurrency Patterns）
   - 读写锁
   - 协程：协程泄露
1. Go 应用
   - Docker
   - Bee Go
   - NSQ
   - NewSQL
