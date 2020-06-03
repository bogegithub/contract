<?php

namespace Contract\Exception;

/**
 * 业务逻辑异常类
 * Class ServiceLogicException
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:51
 * @package Contract\Exception
 */
class ServiceLogicException extends ServiceException
{
    public function __construct(
        string $message,
        string $errorCode,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 103, $previous);
        $this->errorCode = $errorCode;
    }
}
