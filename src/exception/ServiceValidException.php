<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Exception;

use Contract\Code\CommonCode;

/**
 * 验证参数异常类
 * Class ServiceValidException
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:53
 * @package Contract\Exception
 */
class ServiceValidException extends ServiceLogicException
{

    protected $errorCode;
    private   $violationItems;

    public function __construct(
        string $message = CommonCode::INVALID_ARGS_MSG,
        string $errorCode = CommonCode::INVALID_ARGS,
        array $violationItems = []
    ) {
        parent::__construct($message, 102);
        $this->violationItems = $violationItems;
        $this->errorCode      = $errorCode;
    }

    public function getViolationItems(): array
    {
        return $this->violationItems;
    }
}