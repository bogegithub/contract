# Controller返回规约

### 【强制】：Controller的JSON接口方法返回必须是Result对象对应的序列化结果
除非系统为满足其他外部接口的特殊数据格式要求。

`正例`：
```php
return Results::success($user);
```

## JSON数据结构

要求JSON的数据结构必须如下：
```$json
{
    code:"0", // 错误码
    message:"成功！" // 错误信息
    data: { // 返回结果
        id: 1,
        name: "晓燕"
        age: "20"
    }
}
```
Http Status 总是返回200

## 数据返回API使用手册
考虑到我们主要是基于Laravel作为Web框架，为保障数据结构的统一性，我们整理了一套规约包，要求所有开发在返回数据接口的时候都必须用到这里的类。

### 成功调用API
#### 成功调用且无返回

```php
return Results.success();
```
序列化生成的JSON为：
```$json
{
    code:"0",
    message:"成功！"
    data: null
}
```

#### 成功调用且有返回

```php
return Results.success(new User(1, "晓燕", 20));
```
序列化生成的JSON为：
```$json
{
    code:"0",
    message:"成功！"
    data: {
        id: 1,
        name: "晓燕"
        age: 20
    }
}
```

### 翻页API
#### 常规翻页
最普遍的翻页
```php
return Results.success(Pages.page($results, $totalCount, $pageNumber, $pageSize));
```

序列化生成的JSON为：
```$json
{
    code:"0",
    message:"成功！"
    data: {
        pageNumber:10, //当前页
        pageSize:20, //每页显示记录数
        totalPages:10, //总页
        totalCount:99, //总记录数
        // 记录集合
        results:[
            {
                id: 1,
                name: "晓燕"
                age: 20
            },
            {
                id: 2,
                name: "少建"
                age: 20
            },
            {
                id: 3,
                name: "小松"
                age: 20
            }
        ];
    }
}
```

#### 轻量级翻页
避免使用select count语句
```php
return Results.success(
    Pages.litePage($results, $hasNext, $pageNumber, $pageSize));
```

序列化生成的JSON为：
```$json
{
    code:"0",
    message:"成功！"
    data: {
        pageNumber:10, //当前页
        pageSize:20, //每页显示记录数
        hasNext:true, //有无下一页
        // 记录集合
        results:[
            {
                id: 1,
                name: "晓燕"
                age: 20
            },
            {
                id: 2,
                name: "少建"
                age: 20
            },
            {
                id: 3,
                name: "小松"
                age: 20
            }
        ];
    }
}
```

#### 游标翻页
【推荐】：约定数据量较大且按照时间倒序的分页优先使用CursorPage游标分页来提升查询性能
具体可以看一下[用Twitter的cursor方式进行Web数据分页](https://timyang.net/web/pagination/) 这篇文章

cursorPage
```php
return Results.success(Pages.cursorPage($results,
                                 $hasNext,
                                 $nextCursor,
                                 $pageCursor,
                                 $pageSize));
```

序列化生成的JSON为：
```$json
{
    code:"0",
    message:"成功！"
    data: {
        pageNumber:10, //当前页
        pageSize:20, //每页显示记录数
        hasNext:true, //有无下一页
        pageCursor:12121223231323, // 当前页面的游标
        nextCursor:12121223232323, // 下一页的游标
        // 记录集合
        results:[
            {
                id: 1,
                name: "晓燕"
                age: 20
            },
            {
                id: 2,
                name: "少建"
                age: 20
            },
            {
                id: 3,
                name: "小松"
                age: 20
            }
        ];
    }
}
```

### 校验失败

```php
return Results.invalid();
```

序列化生成的JSON为：
```$json
{
    code:"C_1",
    message:"参数无效",
    violationItems:[]
}
```

也可以把对应的校验出错的字段补充进来，比如:
```php
$result = Results.invalid(CommonCode::INVALID_ARGS_MSG, CommonCode::INVALID_ARGS,
    [
        Results::buildViolationItem('username', '用户名不能为空'),
        Results::buildViolationItem('id', 'id不能为空')
    ]);
return $result;
```

序列化生成的JSON为：
```$json
{
    code:"C_1",
    message:"参数无效",
    violationItems:
    [
        {'username': '用户名不能为空'},
        {'id': 'id不能为空'}
    ]
}
```

### 业务逻辑错误

表示一些常规的业务逻辑状态及分支。比如，转账失败。
```php
return Results.failure("余额不足，转账失败！", "PAY_1")
```

序列化生成的JSON为：
```$json
{
    code:"PAY_1",
    message:"余额不足，转账失败！"
    data: null
}
```

### 系统故障及Bug
系统故障的错误码我们约定必须以`SYS_`作为前缀。
```php
return Results.error(ErrorCode::DB_ERROR_MSG, ErrorCode::DB_ERROR)
```
序列化生成的JSON为：
```$json
{
    code:"SYS_1",
    message:"数据库异常"
    data: null
}
```
