### 算法
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