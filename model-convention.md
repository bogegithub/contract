# Model规约

### 【强制】：所有新创建的Model都必须继承`Wedoctor\Convention\Illuminate\Database\Model`
`说明` 这个Model包含了公司的数据库的一些命名规范。
表名称为单数形式，对应的类名为Pascal，字段默认包含`gmt_created`、`gmt_modified`。
加入了我们约定的可返回`Page`、`LitePage`的翻页方法。

表名对照： 如表名为 `user_profile` 对应 `UserProfile` 类名 

`正例`
```php
// 对应 user_profile 表
class UserProfile extends Model
{
}
```


### 【强制】：不允许对数据库使用多表的关联查询
这涉及到数据库后面的扩展性，可以从多个Model里面获取数据，通过程序来完成数据组装。如果涉及到及其复杂的查询则需要通过搜索的方式来解决。

### 【推荐】：如无特殊情况，尽量不要输出`gmt_created`、`gmt_modified`字段

`正例`

```php
class Bar extends Model
{
    protected $hidden = ['gmt_created', 'gmt_modified'];
}
```

### 【推荐】：数据库表中需要加入软删除字段
为保障误操作，以及一些核心的数据不允许被真实删除，都需要加入软删除字段。

`正例`

可以在数据库中添加一个名为`deleted_at`类型为`datetime`的字段，然后 use SoftDeletes。
```php
class Bar extends Model
{
    use SoftDeletes;

    protected $hidden = ['deleted_at', 'gmt_created', 'gmt_modified'];
}
```
把`deleted_at`加入 $hidden , 保障显示的时候不输出。

更多细节参看Laravel中软删除相关的文档

考虑到有部分表是以一个`boolean`型或者是`tinyint`类型以`0`或`1`表示是否删除的字段，可以采用use HasIsDeleted的方式。用法和SoftDeletes保持一致。
但SoftDeletes、HasIsDeleted只能2选1。

```php
class Bar extends Model
{
    use HasIsDeleted;

    // 默认字段为 is_deleted, 可通过重新定义IS_DELETED常量来修改字段名称
    // const IS_DELETED = 'is_removed';
    
    protected $hidden = ['is_deleted', 'gmt_created', 'gmt_modified'];
}
```

### 【推荐】：id尽量使用ObjectId的生成算法
使用ObjectId对于数据库未来分库分表有好处，同时也避免了id被黑客可推导，以自增的方式脱库。

`正例`

在表将字段`id`修改为`varchar(24)`，然后在对应的类中 use UseObjectId。
保存的时候不需要给`id`赋值，系统会自动的生成ObjectId并写入到`id`。

```php
class Bar extends Model
{
    use SoftDeletes, UseObjectId;
    
    protected $hidden = ['pkid', 'deleted_at', 'gmt_created', 'gmt_modified'];
}
```
为保障自增id必须要有，需添加`pkid`字段且最为自增代替。
把`pkid`加入`$hidden`, 保障显示的时候不输出。

### 【强制】：常规的翻页采用系统Model中的page方法来实现
通过 `page($pageNumber, $pageSize)` 方法获取分页对象

`正例`

```php
public function index(Request $request, Foo $foo)
{
    $uid = $request->input('user_id');
    $pageNumber = intval($request->input('pageNumber', 1));
    $pageSize = intval($request->input('pageSize', 20));
    $foo->newQuery()->where('user_id', $uid);
    return Results::success(Foo::page($pageNumber, $pageSize));
}
```

### 【推荐】：尽量不要求返回总页数，尽量多是使用`litePage`方法

通过 `litePage($pageNumber, $pageSize)` 方法获取的分页对象，不包含总页数，只包含有无下一页的判断

`正例`

```php
public function litePage(Request $request, Foo $foo) {

    $this->validate($request,
        [
            'user_id'  => 'required',
        ],
        [],
        [
            'user_id'  => '用户Id',
        ]
    );
    $uid = $request->input('user_id');
    $pageNumber = intval($request->input('pageNumber', 1));
    $pageSize = intval($request->input('pageSize', 20));
    $foo->newQuery()->where('user_id', $uid);
    return Results::success(Foo::litePage($pageNumber, $pageSize));
}
```

对应的序列化生成的JSON结构如下：
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

### 【推荐】：针对于一些时间倒的逻辑，推荐使用`cursorPage`方法
约定数据量较大且按照时间倒序的分页优先使用CursorPage游标分页来提升查询性能

具体可以看一下[用Twitter的cursor方式进行Web数据分页](https://timyang.net/web/pagination/) 这篇文章

`正例`

在表添加`cursor_id`修改为`bigint(20)`，然后在对应的Model类中 use HasCursorPage。
当插入的时候会自动的生成时间戳写入到`cursor_id`。

```php
class Bar extends Model
{
    use HasCursorPage; // 支持以游标的方式进行分页，数据库需要有cursor_id字段
    
    // 默认字段为 cursor_id, 可通过重新定义CURSOR_ID常量来修改字段名称
    // const CURSOR_ID = 'cid';
}
```

对应的调用方法如下：
```php
public function index(Request $request, Bar $bar)
{
    $uid = $request->input('user_id');
    $pageCursor = intval($request->input('pageCursor', 0));
    $pageSize = intval($request->input('pageSize', Pages::DEFAULT_PAGE_SIZE));

    $bar->newQuery()->where('user_id', $uid);

    return Results::success(Bar::cursorPage($pageCursor, $pageSize));
}
```
    
序列化生成的JSON结构如下：
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

