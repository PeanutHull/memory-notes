1. 限流方案：基于计数器，不存在则设置限流的单位过期时间，存在则+1并判断是否超过
   - 简单版：基于set的nx、ex
    ```php
    <?php
    // 连接到 Redis 服务器
    $redis = new Redis();
    $redis->connect('127.0.0.1', 6379);

    // 定义限流器的键名、限制和持续时间
    $rateLimitKey = 'rate_limit_key';
    $limit = 500;
    $duration = 1; // 1秒

    // 尝试初始化计数器（仅在键不存在时设置）
    $initialSet = $redis->set($rateLimitKey, 0, ['nx', 'ex' => $duration]);

    // 尝试增加计数器的值
    $currentCount = $redis->incr($rateLimitKey);

    // 如果计数器超过了限制，则拒绝请求
    if ($currentCount > $limit) {
        // 减少计数器，因为我们不应该增加它
        $redis->decr($rateLimitKey);
        echo "Rate limit exceeded. Please try again later.\n";
    } else {
        echo "Request allowed. Current count: $currentCount\n";
    }
    ```
   - 通用版：lua方式，加载lua脚本可初始化到框架中间件中，然后业务直接使用
    ```php
    <?php
    // 框架初始化时加载 Lua 脚本，用于原子地增加计数器并设置过期时间
    $luaScript = "
    local current = redis.call('INCR', KEYS[1])
    if tonumber(current) == 1 then
        -- 如果这是第一个请求，设置过期时间为1秒
        redis.call('PEXPIRE', KEYS[1], ARGV[1])
    end
    if tonumber(current) > tonumber(ARGV[2]) then
        -- 如果计数器超过了限制，返回-1表示拒绝
        return -1
    else
        -- 否则，返回当前计数
        return current
    end
    ";
    // 加载 Lua 脚本并获取其 SHA1 校验码，并放入全局上下文
    $scriptSha = $redis->script('load', $luaScript);


    // 定义限流器的键名、限制和持续时间
    $rateLimitKey = 'rate_limit_key';
    $limit = 500;
    $duration = 1000; // 1秒，以毫秒为单位

    // 执行 Lua 脚本
    $currentValue = $redis->evalsha($scriptSha, 1, $rateLimitKey, $duration, $limit);

    if ($currentValue == -1) {
        echo "Rate limit exceeded. Please try again later.\n";
    } else {
        echo "Request allowed. Current count: $currentValue\n";
    }
    ```
