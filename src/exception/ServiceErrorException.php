<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Princebo\Contract\Exception;

use Princebo\Contract\Code\ErrorCode;

class ServiceErrorException extends ServiceException
{
    protected $errorCode;

    public function __construct(
        string $message = ErrorCode::UNKNOWN_ERROR_MSG,
        string $errorCode = ErrorCode::UNKNOWN_ERROR,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 101, $previous);
        $this->errorCode = $errorCode;
    }
}
