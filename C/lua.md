### lua
1. lua
   - 认识：高效的、简洁轻量的、动态类型的、可扩展的脚本语言，lua是葡萄牙语月亮的意思，是卫星语言，能够方便嵌入其他语言中
     1. redis内嵌lua就是为了提供给用户无限可能，因为命令不可能无限提供
   - 基础
     1. 不要求缩进，结尾可以省略;
     1. 注释：-- 单行，--[[]] 多行
     1. 操作符
        - + - * / % ^
        - == ~=(不等于) > < >=
        - not and or：支持短路，只要不是nil或false就是真，0和空字符串也是真
        - ..：连接符
        - #：字符串/表长度计算符
   - 数据类型
     1. 分类
        - nil：空
        - boolean：true、false
        - number：整数和浮点数
        - string：字符串，二进制安全，单双引号定义，支持换行符
        - table：表，数组或者字典，唯一数据结构，索引为整数时和数组一样，数组从1开始
        - function：是一等值，可存变量、作为返回值等
     1. 操作
        - 转换：tonumber、tostring
     1. 详细
        - table
            ```lua
            -- 表
            a = []                          -- 定义
            a = {                           -- 定义
                k = 'v'
            }

            a['k'] = 'v'                    -- 赋值

            a.k                             -- 访问
            for k,v in pairs(a) do          -- 遍历，pairs类似迭代器，ipairs用于数组，前者遍历不为nil的，后者只会遍历整数
            end
            ```
        - 函数
            ```lua
            local a = function (...)        -- 定义，可变参数
            end
            local function a ()             -- 语法糖
            end
            ```
   - 变量
     1. 全局变量：`a = 1`
     1. 局部变量
        ```lua
        local a = 1
        local e,f
        ```
   - 流程控制
     1. if
        ```lua
        if xx then
        elseif xx then
        else
        end
        ```
     1. 循环
        ```lua
        for 初值，终止，步长 do
        end

        while xx do
        end

        repeat 
        until xx
        ```
   - 标准库
     1. 分类：Base、String、Table、Math、Debug、cJson、cmsgpack
     1. 使用：`string.len(str)`
   - wiki
     1. 速查表：https://github.com/skywind3000/awesome-cheatsheets/blob/master/languages/lua.lua