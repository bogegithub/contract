# 异常规约

### 【强制】：Bug或系统故障统一抛出ServiceErrorException
`说明`：通常是系统产生了未知的异常或者是由于其他底层服务出现状况导致后续无法处理的情况。如数据库连接异常、缓存连接异常、数据库SQL执行异常，程序产生Bug等

`正例`：服务错误异常，针对于无法处理的异常业务需要转换成ServiceErrorException抛出
```php
try {
  // 业务代码
} catch (DataBaseIOExcpetion $ex) {
  throw new ServiceErrorException(ErrorCode::DB_ERROR, $ex);
}
```

### 【强制】：业务异常统一抛出ServiceLogicException
`说明`：业务逻辑状态或应用的功能相关的异常，如用户不存在、排班已满、由于余额不足导致转账失败等

`正例`：对于ServiceLogicException的抛出方式可分为两类，一种是自身要抛出的业务异常
```php
// 业务代码
throw new ServiceLogicException(
    AuthCode::INVALID_SCOPE_PARAMETER_MSG,
    AuthCode::INVALID_SCOPE_PARAMETER);
```
另外一种是由于内部的一些异常导致的一些非错误的异常。
```php
try {
// 业务代码
} catch (UrlEncodingExcpetion $ex) {
    throw new ServiceLogicException(
        CommonCode::URL_ENCODING_MSG,
        CommonCode::URL_ENCODING,
        $ex);
}
```

### 【强制】：参数校验失败统一抛出ServiceValidException
`说明`：代码中校验各种入参时抛出的异常，ServiceValidException继承ServiceException

`正例`：可以不传参数
```php
// 业务代码
throw new ServiceValidException();
```

如果存在多个字段出错可以加入字段
```php
$violationItems = [
    Results::buildViolationItem("username", "用户名不能为空"),
    Results::buildViolationItem("password", "密码不能为空")];

throw new ServiceValidException(
            CommonCode::INVALID_ARGS_MSG,
            CommonCode::INVALID_ARGS,
            $violationItems);
```

还可以使用框架的`Preconditions`类的`checkArgument`方法来抛出ServiceValidException
```php
public static function checkArgument(
    bool $expression,
    string $message = CommonCode::INVALID_ARGS_MSG,
    string $errorCode = CommonCode::INVALID_ARGS,
    array $violationItems = [])
{
    if (!$expression) {
        throw new ServiceValidException($message, $errorCode, $violationItems);
    }
}
```

### 【强制】：成功的code编号为0
`说明`：保持公司先前约定好的规范

### 【强制】：未知错误的code编号为1，对应ServiceErrorException异常
`说明`：保持公司先前约定好的规范

### 【强制】：除code编号为1以外的ServiceErrorException对应的code编号必须以SYS_打头
`说明`：code为1保持公司先前约定好的规范，同时为避免和先前的code重复，所以采用"SYS_"打头

`正例`："SYS_1"、"SYS_2"、"SYS_3"

### 【强制】：业务异常的code编号以"业务简称_数字"的方式表示
`说明`：自己业务抛出的业务异常对应的code除开框架提供的公共的code外，只能使用自己的业务code。以保障code在公司全局的唯一性。

比如，用户中心的业务编号可以是"UC_1"、"UC_2"、"UC_3"，其他业务不能直接抛出code为"UC_1"、"UC_2"、"UC_3"之类的异常。
但如果服务A调用了服务B，遇到了服务B抛出来的异常，允许服务A抛出服务B产生的异常。

### 【强制】：code编号为"C\_"或"AUTH\_"打头的为系统默认公用的ServiceLogicException对应的code编号
`说明`："C\_"、"AUTH\_"、"SYS_"打头的由框架提供的团队进行维护，开发者可以给框架开发团队提需求进行完善

### 【强制】：自定意的Code必须定义成类，且后缀必须为Code
`说明`：比如 UserCode、SignCode等

### 【强制】：定义的 message的名称 = code常量名称 + "_MSG"
`说明`：参照如下代码：
```php
    const INVALID_SCOPE_PARAMETER = "AUTH_0";
    const INVALID_SCOPE_PARAMETER_MSG = "在请求中存在无效的scope参数";

    const MISSING_SCOPE_PARAMETER = "AUTH_1";
    const MISSING_SCOPE_PARAMETER_MSG = "在请求中scope参数丢失";
```

### 【推荐】：默认的校验失败的通用code编号为"C_1"
`说明`：可以根据自身业务状况调整，如果业务对code有特殊含义和特殊的判断分支，可以自行定义当前的编号。

## 异常码约定

ServiceErrorException、ServiceLogicException、ServiceValidException这三个异常都包含了code属性，用于表示异常的错误编号

由于先前非常的多的项目都定义了自己的code编号，且code都是数字，而且不同项目的数字已经出现重复定义的情况，我们希望看到的是在全公司的项目中，异常号能够不重复，且在后面都能逐步统一起来。所以，在这里我们一方面在保持和先前异常号兼容的同时，定义了一套新的异常规范。

新的code规范都是采用了`【业务简称】_【数字】` 的方式来进行定义。`【业务简称】`需要保障全公司唯一性。
具体见下表:

| code | 含义 | 对应异常 | 对应枚举类型 | 备注 |
| - | - | - | - | - |
| 0 | 成功 | 无 | SuccessCode | |
| 1 | 未知异常  |  ServiceErrorException | ErrorCode | 兼容老系统
| SYS_数字 | 系统错误  | ServiceErrorException | ErrorCode | 新的系统错误编码规范都是`SYS_数字`的组合方式，比如SYS_1 表示数据库异常
| C_数字 | 通用业务异常  | ServiceLogicException | CommonCode | 通用的业务异常编码规范 |
| C_1 | 校验异常 | ServiceValidException | CommonCode | 业务校验失败的编码 |
| AUTH_数字 | OAuth验证的通用异常  | ServiceLogicException | AuthCode | |
| 业务简称_数字 | 各业务自定义的业务异常  | ServiceLogicException | 业务自己定义错误消息和错误号 | |

上面 SuccessCode、ErrorCode、CommonCode、AuthCode 在wedoctor-convention包里面已经进行了定义，如果各业务上还需对上面的这几类异常号补充，请各位与我们进行联系。

项目中各自业务有各自的编码，大家可以通过定义自己的Code来做到。可以照搬CommonCode的写法，进行自己业务编码定义。
