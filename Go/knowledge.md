### 基础
1. 打印
   - `fmt.Printf("s[%d] == %d\n", i, s[i])`
     1. %s：字符串
     1. %d：数字
     1. %v：slice
   - `fmt.Println(m)`
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
1. 时间
    ```go
    package main

    import (
        "fmt"
        "time"
    )

    func main() {
        fmt.Println("The time is", time.Now())
    }
    ```
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
