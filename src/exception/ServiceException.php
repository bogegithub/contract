<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Exception;

use RuntimeException;

class ServiceException extends RuntimeException
{
    protected $errorCode;

    public function __construct(
        string $message,
        string $errorCode,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 100, $previous);
        $this->errorCode = $errorCode;
    }

    /**
     * getErrorCode 获取下游服务的异常码
     * @return string
     * @author yanbo
     * @date 2020/6/2
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
