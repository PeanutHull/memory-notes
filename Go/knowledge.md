1. 打印
   - `fmt.Printf("s[%d] == %d\n", i, s[i])`
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
    // 可以返回任意数量返回值
    func swap(x, y string) (string, string) {           // 缩写参数类型
        return y, x
    }
    a, b := swap("hello", "world")
    // 命名返回值，指定返回值
    func split(sum int) (x, y int) {
        x = sum * 4 / 9
        y = sum - x
        return
    }
    // 函数作为参数、返回值
    hypot := func compute(fn func(float64, float64) float64) float64 {
        return fn(3, 4)
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
    for ; sum < 10; {
        sum += sum
    }
    ```
1. 死循环：`for {}`
1. 在结构体上定义方法
    ```go
    func (v *Vertex) Add() float64 {
	    return v.X + v.Y
    }
    v := &Vertex{3, 4}
    v.Abs()                 // 使用
    ```
1. 指针访问结构体
    ```go
    v := Vertex{1, 2}
	p := &v
    p.X
    ```
