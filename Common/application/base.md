### 算法
1. 心得
   - O(1)复杂度的具有获取最小值的栈问题、和 O(1)复杂度的具有获取最大值的队列问题，前者用栈不断累积最小值，pop就同时一起pop，push就比较下然后同时也push进min栈；而后者也是个栈，是push时for循环比较，小的就Push_back扔出去了，只有大的在最下边，然后小的跟了后边，pop的时候比较下，相同也是跟了后边就行
1. 练功心法
   - 方面
     1. 数组、字符串
     1. 双指针
     1. 滑动窗口
     1. 哈希表
     1. 区间
     1. 栈
     1. 链表
     1. 二叉树
        - 遍历
        - 搜索
        - 字典树
     1. 回溯、分治
     1. 二分查找
     1. 堆
     1. 位运算
   - 方式
     1. 利用原有go的函数解决
        - copy(dst, src)
        - strconv.FormatInt/ParseInt：转为字符串，转为数字
        - sort.Ints()：无返回值，sort.Slice()：自定义排序
        - strings.Contains/Count/HasPrefix/HasSuffix/Index/Trim/Split/Replace/ToLower
     1. 利用双指针、快慢指针
#### 数据结构
1. 栈
   - 数组实现
    ```go
    //自定义栈结构
    type Stack struct {
        Top    int
        MaxTop int
        arr    []interface{}
    }

    //初始化一个栈，传入一个最大个数
    func NewStack(size int) (*Stack, error) {
        if size <= 0 {
            return nil, errors.New("初始化栈失败")
        }

        stack := &Stack{
            Top:    -1,
            MaxTop: size - 1,
            arr:    make([]interface{}, size),
        }

        return stack, nil
    }

    //弹入一个元素
    func (this *Stack) Push(val interface{}) error {
        if this.IsFull() {
            return errors.New("栈已满,暂不能插入")
        }

        this.Top++
        this.arr[this.Top] = val

        return nil
    }

    //弹出一个元素
    func (this *Stack) Pop() (interface{}, error) {
        if this.IsEmpty() {
            return nil, errors.New("栈已空,暂不能弹出")
        }

        val := this.arr[this.Top]

        this.Top--
        return val, nil
    }

    func (this *Stack) IsEmpty() bool {
        return this.arr == nil || this.Top == -1
    }

    func (this *Stack) IsFull() bool {
        return this.arr != nil && this.Top == this.MaxTop
    }
    ```
   - 链表实现
    ```go
    ```
1. 队列
   - 数组实现：涉及head和tail两个指针指向队列的位置，指针到尾数据搬迁
    ```go
    type customQueue struct {
        queue []string
        lock  sync.RWMutex
    }

    func (c *customQueue) Enqueue(name string) {
        c.lock.Lock()
        defer c.lock.Unlock()
        c.queue = append(c.queue, name)
    }

    func (c *customQueue) Dequeue() error {
        if len(c.queue) > 0 {
            c.lock.Lock()
            defer c.lock.Unlock()
            c.queue = c.queue[1:]
            return nil
        }
        return fmt.Errorf("Pop Error: Queue is empty")
    }

    func (c *customQueue) Front() (string, error) {
        if len(c.queue) > 0 {
            c.lock.Lock()
            defer c.lock.Unlock()
            return c.queue[0], nil
        }
        return "", fmt.Errorf("Peep Error: Queue is empty")
    }

    func (c *customQueue) Size() int {
        return len(c.queue)
    }

    func (c *customQueue) Empty() bool {
        return len(c.queue) == 0
    }
    ```
   - 单链表实现
    ```go
    type ListNode struct {
        data interface{}
        next *ListNode
    }

    type Queue struct {
        front *ListNode
        rear  *ListNode
        size  int
    }

    func (q *Queue) enQueue(data interface{}) {
        rear := new(ListNode)
        rear.data = data
        if q.isEmpty() {
            q.front = rear
        } else {
            oldLast := q.rear
            oldLast.next = rear
        }
        q.rear = rear
        q.size++
    }

    func (q *Queue) deQueue() (interface{}, error) {
        if q.isEmpty() {
            q.rear = nil
            return nil, errors.New("unable to deQueue element, queue is empty")
        }
        data := q.front.data
        q.front = q.front.next
        q.size--
        return data, nil
    }

    func (q *Queue) frontElement() (interface{}, error) {
        if q.isEmpty() {
            return nil, errors.New("unable to peek element, queue is empty")
        }
        return q.front.data, nil
    }

    func (q *Queue) isEmpty() bool {
        return q.front == nil
    }

    func (q *Queue) length() int {
        return q.size
    }

    func (q *Queue) String() string {
        var result bytes.Buffer
        result.WriteByte('[')

        j := q.front
        for i := 0; i < q.size; i++ {
            result.WriteString(fmt.Sprintf("%v", j.data))
            if i < q.size-1 {
                result.WriteByte(' ')
            }
            j = j.next
        }
        result.WriteByte(']')
        return result.String()
    }
    ```
   - channel实现
    ```go
    type queue struct {
        ch chan int
    }

    func (self *queue) init(i int) {
        self.ch = make(chan int, i)
    }

    func (self *queue) Enqueue(i int) {
        self.ch <- i
    }

    func (self *queue) Dequeue() int {
        return <-self.ch
    }

    func (self *queue) length() int {
        return len(self.ch)
    }
    ```
   - ​借助​container/list​实现
    ```go
    type customQueue struct {
        queue *list.List
    }

    func (c *customQueue) Enqueue(value string) {
        c.queue.PushBack(value)
    }

    func (c *customQueue) Dequeue() error {
        if c.queue.Len() > 0 {
            ele := c.queue.Front()
            c.queue.Remove(ele)
        }
        return fmt.Errorf("Pop Error: Queue is empty")
    }

    func (c *customQueue) Front() (string, error) {
        if c.queue.Len() > 0 {
            if val, ok := c.queue.Front().Value.(string); ok {
                return val, nil
            }
            return "", fmt.Errorf("Peep Error: Queue Datatype is incorrect")
        }
        return "", fmt.Errorf("Peep Error: Queue is empty")
    }

    func (c *customQueue) Size() int {
        return c.queue.Len()
    }

    func (c *customQueue) Empty() bool {
        return c.queue.Len() == 0
    }
    ```
1. 二叉树
   - 前序遍历
    ```go
    // TreeNode 表示二叉树节点  
    type TreeNode struct {  
        Val   int  
        Left  *TreeNode  
        Right *TreeNode  
    }  
    
    // PreorderTraversal 实现二叉树前序遍历  
    func PreorderTraversal(root *TreeNode) {  
        if root == nil {  
            return  
        }  
        fmt.Println(root.Val) // 输出当前节点值  
        PreorderTraversal(root.Left)   // 遍历左子树  
        PreorderTraversal(root.Right)  // 遍历右子树  
    }  
    
    func main() {  
        // 构造二叉树  
        root := &TreeNode{Val: 1}  
        root.Left = &TreeNode{Val: 2}  
        root.Right = &TreeNode{Val: 3}  
        root.Left.Left = &TreeNode{Val: 4}  
        root.Left.Right = &TreeNode{Val: 5}  
        root.Right.Left = &TreeNode{Val: 6}  
        root.Right.Right = &TreeNode{Val: 7}  
    
        // 前序遍历二叉树  
        PreorderTraversal(root)  
    }
    ```
1. 大顶堆
    ```go
    // ​借助​container/heap实现
    type IntHeap []int

    func (h IntHeap) Less(i, j int) bool {
        return h[i] > h[j]
    }
    func (h IntHeap) Len() int {
        return len(h)
    }
    func (h IntHeap) Swap(i, j int) {
        h[i], h[j] = h[j], h[i]
    }
    func (h *IntHeap) Push(v interface{}) {
        *h = append(*h, v.(int))
    }
    func (h *IntHeap) Pop() interface{} {
        old := *h
        n := len(old)
        max := old[n-1]
        *h = old[:n-1]
        return max
    }


    func main() {
        h := &IntHeap{1, 3, 2}
        heap.Init(h)
        heap.Push(h, 9)
        heap.Push(h, 1)
        heap.Push(h, 3)
        heap.Push(h, 2)
        fmt.Println(heap.Pop(h))
    }
    ```
#### 排序
1. 认识
   - 场景：整数排序、字符串排序、自定义排序
   - 在有序数组上进行：二分查找、双指针
1. 冒泡
    ```go
    func main() {
        s := []int{1,2,4,3}

        res := bubbleSort(s)

        fmt.Print(res)
    }

    func bubbleSort(s []int) []int {
        l := len(s)

        for i := 0; i < l-1; i++ {
            for j := 0; j < l-i-1; j++ {
                if s[j] > s[j+1] {
                    s[j], s[j+1] = s[j+1], s[j]
                }
            }
        }

        return s
    }
    ```
1. 快速
   - 认识
     1. 关键点：哨兵划分、递归
   - 示例
    ```go
    func main() {
        s := []int{1,2,4,3}

        res := quickSort(s, 0, len(s)-1)

        fmt.Print(res)
    }

    func quickSort(s []int, left, right int) []int {
        // 子数组长度为1时终止递归
        if left >= right {
            return []int{}
        }

        // 获取第一个分界点
        p := partition(s, left, right)

        // 递归左右子数组执行哨兵划分
        quickSort(s, left, p-1)
        quickSort(s, p+1, right)

        return s
    }

    // 以最左边为分界点
    func partition(s []int, left, right int) int {
        l, r, cur := left, right, s[left]

        for l < r {
            // 先计算好左右两边要挪几个位置出来
            for l < r && s[r] >= cur {
                r--
            }
            for l < r && s[l] <= cur {
                l++
            }

            // 然后互换左右，详细的递归再去分就好了
            s[l], s[r] = s[r], s[l]
        }

        s[left], s[r] = s[r], s[left]

        return l
    }
    ```
### 场景
1. top-k问题
   - 解决方案
     1. 利用hash将同类型数据放到一个文件中，既能内存放得下，又能用map统计
     1. 位操作：利用位作标记记录需要的情况，可以按顺序切分位到多个机器上，去满足内存的处理
