# 路由规约

## 【强制】HTTP动词只允许出现`GET`或`POST`方法。 

`正例`

|动词 | 操作 |
| :-: | :- | 
| GET | 查询 |
| POST | 增加、删除、修改 |

## 【强制】URL路径名称不使用restful化的URL。
`说明` 考虑到基于restful化的URL命名规约很多人都遵守或设计得不好，还是回归传统传参的方式。 
不建议使用复数的命名原则
`正例`

| 动词 | 路径 | 方法 | 类名 | 描述 |
| :-: | :- | :-: | :-: | :- |
| GET | /message/get?id={id} | show | MessageController | 获取单条数据 |
| GET | /message/list | list | MessageController | 获取多条、分页数据 |
| GET | /message/count | count | MessageController | 获取总数 |
| POST | /message/add | add | MessageController | 创建数据 |
| POST | /message/update | update | MessageController | 更新数据 |
| POST | /message/delete | delete | MessageController | 删除数据 |

## 【强制】任何情况下，HTTP STATUS总是返回200。
`说明` 为避免过于复杂。所以，保障降低开发人员思考成本与调用成本。HTTP STATUS都统一返回200。




