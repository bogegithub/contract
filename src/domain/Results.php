<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Princebo\Contract\Domain;

use Princebo\Contract\Code\CommonCode;
use Princebo\Contract\Code\ErrorCode;
use Princebo\Contract\Code\SuccessCode;
use Princebo\Contract\Exception\ServiceErrorException;
use Princebo\Contract\Exception\ServiceLogicException;
use Princebo\Contract\Exception\ServiceValidException;

final class Results
{
    /**
     * 成功
     * @param mixed data 并设置data参数
     * @return Result
     */
    public static function success($data = null)
    {
        return new DefaultResult(SuccessCode::SUCCESS_MSG, SuccessCode::SUCCESS, $data);
    }

    /**
     * 参数校验失败的返回
     * @param ViolationItem[] $violationItems 错误字段
     * @param string $code 错误码
     * @param string $message 错误信息
     * @return Result
     */
    public static function invalid($message = CommonCode::INVALID_ARGS_MSG,
                                   $code = CommonCode::INVALID_ARGS,
                                   array $violationItems = [])
    {
        return new InvalidResult($message, $code, $violationItems);
    }

    public static function invalidByEx(ServiceValidException $ex) {

        return new InvalidResult($ex->getMessage(), $ex->getErrorCode(), $ex->getViolationItems());
    }

    /**
     * 失败
     * @param string $message 失败信息
     * @param string $code 失败编码
     * @return Result 返回对象
     */
    public static function failure(string $message, string $code) {
        return new DefaultResult($message, $code);
    }

    /**
     * 失败
     * @param ServiceLogicException $exception
     * @return Result
     */
    public static function failureByEx(ServiceLogicException $exception) {
        return new DefaultResult($exception->getMessage(), $exception->getErrorCode());
    }

    /**
     * 错误
     * @param string $message 错误信息
     * @param string $errorCode 错误码
     * @return Result
     */
    public static function error(string $message, string $errorCode = ErrorCode::UNKNOWN_ERROR) {
        return new DefaultResult($message, $errorCode);
    }

    /**
     * 错误
     * @param ServiceErrorException $exception
     * @return Result
     */
    public static function errorByEx(ServiceErrorException $exception) {
        return new DefaultResult($exception->getMessage(), $exception->getErrorCode());
    }

    /**
     * 针对于异常的返回
     * @param \Throwable | ServiceValidException | ServiceLogicException | ServiceErrorException $throwable
     * @return Result
     */
    public static function resultByEx(\Throwable $throwable) {
        if ($throwable instanceof ServiceValidException) {
            return Results::invalidByEx($throwable);
        } else if ($throwable instanceof ServiceLogicException) {
            return Results::failureByEx($throwable);
        } else if ($throwable instanceof ServiceErrorException) {
            return Results::errorByEx($throwable);
        } else {
            return new DefaultResult(ErrorCode::UNKNOWN_ERROR_MSG, ErrorCode::UNKNOWN_ERROR);
        }
    }

    /**
     * 构建参数验证失败的项目
     * @param string field 字段名称
     * @param string message 信息
     * @return ViolationItem 参数验证失败的项目
     */
    public static function buildViolationItem(string $field, string $message)
    {
        return new DefaultViolationItem($field, $message);
    }
}