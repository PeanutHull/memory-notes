# 豆伴匠 MAPI 开发指南

## 项目概述

**框架：** Laravel 8.x
**PHP版本：** PHP 7.2+
**数据库：** MySQL 5.7+ / Redis 6.0+

---

## 项目架构

### 分层架构

```
Controller → Service → Business → Model
```

**各层职责：**
- **Controller**：接收请求、验证参数、返回响应
- **Service**：业务编排、外部调用、事务管理
- **Business**：数据访问、数据处理
- **Model**：数据库操作、关系定义

### 调用规则

✅ **允许：** Controller → Service → Business → Model
❌ **禁止：** 跳层调用、反向依赖

---

## 命名规范

### 类命名

| 类型 | 规范 | 示例 |
|------|------|------|
| 模型 | `{功能}` | `BusOrders`, `User` |
| 服务 | `{功能}Service` | `PlaceOrderService` |
| 业务 | `{功能}Business` | `OrderBusiness` |
| 控制器 | `{功能}Controller` | `OrderController` |
| 队列 | `{功能}Job` | `ProcessOrderJob` |
| 异常 | `{功能}Exception` | `OrderProcessException` |

### 方法命名

- 获取：`get{实体}()` / `get{实体}List()`
- 保存：`save{实体}()`
- 更新：`update{实体}()`
- 删除：`delete{实体}()`
- 验证：`validate{实体}()`
- 私有方法：动词+名词

### 变量命名

- 小驼峰：`$userId`, `$orderNo`
- 数组复数：`$users`, `$orders`
- 布尔值：`$isValid`, `$hasPermission`

### 常量命名

```php
// 状态常量
const STATUS_WAIT = 0;
const STATUS_ENABLE = 1;
const STATUS_DISABLE = 2;

// 配置常量
private const CACHE_TTL = 3600;
private const MAX_RETRY = 3;
```

---

## 数据库规范

### 表命名

- 前缀：`tbl_`
- 模式：`tbl_{领域}_{功能}`
- 示例：`tbl_bus_orders`

### 模型结构

- 继承 `Model` 类
- 定义 `$table` 属性
- 定义 `$fillable` 属性
- 定义状态常量
- 定义关联关系

### 查询优化

- 使用查询构建器
- 预加载避免 N+1
- 使用 chunk 处理大数据

---

## Redis 规范

### Key 管理

**统一配置：** 所有 Redis Key 必须在 `config/rediskey.php` 中统一管理

**配置格式：**
- 简单格式：`'key_name' => 'prefix:key:pattern:%s'`
- 数组格式：`'key_name' => ['key' => 'prefix:key:%s', 'expire' => 3600]`
- 分组管理：`'module' => ['sub_key' => ['key' => 'module:sub:%d', 'expire' => 3600]]`

### 缓存职责

**Business 层：**
- 封装所有 Redis 读写操作
- 提供带缓存的数据访问方法
- 管理缓存过期时间

**Service 层：**
- 调用 Business 层方法获取数据
- 不直接操作 Redis
- 专注于业务逻辑编排

### 命名规范

**Key 格式：** `{模块}:{功能}:{标识}:{参数}`

示例：`user:course:info:%d`、`reseller:grant:config:%d`、`market:activity_poster:sign:%s`

### 过期时间

| 类型 | 过期时间 | 说明 |
|------|----------|------|
| 短期缓存 | 60-300秒 | 实时数据、高频更新 |
| 中期缓存 | 300-3600秒 | 用户数据、配置信息 |
| 长期缓存 | 86400秒+ | 静态数据、字典表 |

### 使用示例

```php
// 获取配置
$redisKey = config('rediskey.module.sub_key');
$cacheKey = sprintf($redisKey['key'], $param);

// 设置缓存
Redis::setex($cacheKey, $redisKey['expire'], json_encode($data));

// 防并发锁
Redis::set($lockKey, 1, 'NX', 'EX', 60);
```

---

## 错误处理

### 异常规范

- 使用自定义异常
- 避免通用异常

### 响应格式

```php
// 成功
['code' => 200, 'msg' => 'success', 'data' => $data]

// 失败
['code' => $errorCode, 'msg' => $errorMessage, 'data' => []]
```

---

## 代码规范

### 基本规范

- **缩进：** 4空格
- **行长：** 120字符
- **标准：** PSR-12
- **类型声明：** 必须使用

---

## 队列任务

### 结构

- 实现 `ShouldQueue` 接口
- 使用相关 Trait
- 定义队列常量

---

## 日志规范

### 日志渠道

- 业务日志：`ChannelLog`
- SCrm 日志：`SCrmBusLog`
- Laravel 日志：`Log`

---

## API 文档规范

### 文件组织

**目录结构：** `docs/api/`

**命名规范：** `{完整路由}.json`
- 将路由中的 `/` 替换为 `-`
- 去掉开头的 `/`
- 示例：`reseller-grant-detail.json`、`user-user-info.json`

**原则：** 1接口1文件，使用 JSON 格式

### OpenAPI 3.0 文档结构

#### 必填字段

| 字段 | 说明 |
|------|------|
| `openapi` | OpenAPI 版本，固定为 3.0.0 |
| `info.title` | 接口/模块名称 |
| `info.version` | 文档版本 |
| `paths` | 接口路径定义 |
| `paths.{path}.{method}.summary` | 接口标题 |
| `paths.{path}.{method}.responses` | 响应定义 |

#### 可选字段

| 字段 | 说明 |
|------|------|
| `info.description` | 详细描述 |
| `servers` | 服务器地址列表 |
| `tags` | 接口分组标签 |
| `security` | 认证方式 |
| `components` | 可复用组件 |

#### 响应格式规范

**成功响应：** 包含 code、msg、data 字段

**错误响应：** 引用通用响应定义

#### Schema 定义规范

- 使用 `type` 定义数据类型
- 使用 `description` 添加说明
- 使用 `required` 标识必填字段
- 使用 `$ref` 引用其他 schema

#### 认证方式

- BearerAuth: JWT Token 认证
- ApiKeyAuth: API Key 认证

---

## 最佳实践

### 1. 避免硬编码

- 使用常量替代魔法数字
- 配置项集中管理

### 2. 事务管理

- 使用 `DB::beginTransaction()` 开启事务
- 成功时 `DB::commit()`
- 失败时 `DB::rollBack()`

### 3. 批量操作

- 使用 `insert()` 批量插入
- 使用 `whereIn()` 批量更新

---

## 核心业务模块

| 模块 | 功能 |
|------|------|
| 订单 | `PlaceOrderService`, `OrderBusiness` |
| 用户 | `LoginServices`, `UserAccountBusiness` |
| 营销 | `UserRedeemCouponService`, `ChannelBindService` |
| SCrm | `ScrmChannelBusiness`, `AllotSeatCaseUserService` |

---

**版本：** v4.0
**更新日期：** 2026-02-26
