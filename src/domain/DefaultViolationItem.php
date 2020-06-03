<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

/**
 * 默认实现，校验产生错误后会包含这个对象
 * Class DefaultViolationItem
 * User: yanbo
 * Date: 2020/6/2
 * Time: 21:02
 * @package Contract\Domain
 */
class DefaultViolationItem implements ViolationItem {

    /**
     * @var string
     */
    public $field;
    /**
     * @var string
     */
    public $message;

    public function __construct($field, $message)
    {
        $this->message = $message;
        $this->field = $field;
    }

    /**
     * 获取验证失败的字段名
     * @return string 验证失败的字段名
     */
    function getField(): string
    {
        return $this->field;
    }

    /**
     * 设置验证失败的字段名
     * @param string field 验证失败的字段名
     */
    function setField(string $field)
    {
        $this->field = $field;
    }

    /**
     * 获取验证失败的信息
     * @return string 验证失败的信息
     */
    function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 设置验证失败的信息
     * @param string message 验证失败的信息
     */
    function setMessage(string $message)
    {
        $this->message = $message;
    }
}