<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

use Contract\Code\ErrorCode;
use Contract\Code\SuccessCode;
use Contract\Constants;
use Contract\Exception\ServiceErrorException;
use Contract\Exception\ServiceValidException;

/**
 * Result的无效返回实现
 * Class InvalidResult
 * User: yanbo
 * Date: 2020/6/2
 * Time: 21:03
 * @package Contract\Domain
 */
class InvalidResult implements Result
{

    public $code;
    public $message;
    public $violationItems;

    public function __construct(string $message, string $code, array $violationItems = [])
    {
        $this->message = $message;
        $this->code = $code;
        $this->violationItems = $violationItems;
    }

    /**
     * 获取错误码
     * @return string 错误码
     */
    function getCode(): string
    {
        return $this->code;
    }

    /**
     * 获取成功或错误的信息
     * @return string 成功或错误的信息
     */
    function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 获取数据
     * @return object 数据
     */
    function getData()
    {
        return null;
    }

    /**
     * 获取校验失败的字段
     * @return array 校验失败的字段
     */
    function getViolationItems(): array
    {
        return $this->violationItems;
    }

    /**
     * 设置错误码
     * @param string code 错误码
     * @return Result Result对象
     */
    function setCode(string $code): Result
    {
        $this->code = $code;
        return $this;
    }

    /**
     * 设置成功或错误的信息
     * @param string message 成功或错误的信息
     * @return Result
     */
    function setMessage(string $message): Result
    {
        $this->message = $message;
        return $this;
    }

    /**
     * 设置数据
     * @param mixed data 数据
     * @return Result
     */
    function setData($data): Result
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 设置验证失败的字段
     * @param ViolationItem[] 验证失败的字段
     * @return Result
     */
    function setViolationItems(array $violationItems)
    {
        $this->violationItems = $violationItems;
        return $this;
    }

    /**
     * 添加 ViolationItem
     * @param string field ViolationItem 的 field
     * @param string message ViolationItem 的 message
     * @return Result
     */
    function addViolationItem(string $field, string $message): Result
    {
        if (!isset($this->violationItems)) {
            $this->violationItems = [];
        }
        $this->violationItems[] = new DefaultViolationItem($field, $message);
        return $this;
    }

    /**
     * 是否成功
     * @return bool
     */
    function isSuccess(): bool
    {
        return (SuccessCode::SUCCESS === $this->code);
    }

    /**
     * 是否错误
     * @return bool
     */
    function isError(): bool
    {
        return ErrorCode::isError($this->code);
    }

    private function startWith($str, $needle)
    {
        return strpos($str, $needle) === 0;
    }

    /**
     * 是否是业务处理失败，业务异常
     * @return bool
     */
    function isFailure(): bool
    {
        return (!$this->isSuccess()) && (!$this->isError());
    }

    /**
     * 有无校验失败的项目
     * @return bool true表示存在校验失败的项目
     */
    function hasViolationItems(): bool
    {
        return !empty($this->violationItems);
    }

    /**
     * 如果isError()为true，抛出ServiceErrorException
     * 如果isFailure()为true，抛出ServiceLogicException或ServiceValidException
     * @return mixed
     * @throws ServiceErrorException
     */
    function checkAndGetData()
    {
        if ($this->isError()) {
            throw new ServiceErrorException($this->getMessage(), $this->getCode());
        } elseif ($this->isFailure()) {
            throw new ServiceValidException($this->getMessage(), $this->getCode(), $this->getViolationItems());
        }
        return $this->getData();
    }

    function __toString()
    {
        return json_encode($this, Constants::DEFAULT_ENCODING_OPTIONS);
    }

    function jsonSerialize()
    {
        return $this;
    }
}
