<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Code;

use Throwable;
use Contract\Exception\ServiceErrorException;

/**
 * 错误码常量
 * @package sdk\codes
 */
class ErrorCode
{
    const ERROR_PREFIX = "SYS_";

    const UNKNOWN_ERROR = "1";
    const UNKNOWN_ERROR_MSG = "未知的系统错误";

    const DB_ERROR = "SYS_1";
    const DB_ERROR_MSG = "数据库异常";

    const CACHE_ERROR = "SYS_2";
    const CACHE_ERROR_MSG = "缓存异常";

    const HTTP_ERROR = "SYS_3";
    const HTTP_ERROR_MSG = "调用HTTP接口发生异常";

    const RETURN_NULL_ERROR = "SYS_4";
    const RETURN_NULL_ERROR_MSG = "服务不能返回空对象";

    const SERVER_UNAVAILABLE_ERROR = "SYS_5";
    const SERVER_UNAVAILABLE_ERROR_MSG = "服务端不可用";

    public static function isError(string $code): bool
    {
        return ErrorCode::UNKNOWN_ERROR === $code ||
            (!empty($code) && self::startWith($code, self::ERROR_PREFIX));
    }

    private static function startWith($str, $needle)
    {
        return strpos($str, $needle) === 0;
    }

    /**
     * 用于抛出ServiceErrorException
     * @param string $code
     * @param string $msg
     * @param Throwable|null $cause
     * @return ServiceErrorException
     */
    public static function error(string $code, string $msg, Throwable $cause = null) {
        return new ServiceErrorException($msg, $code, $cause);
    }

}