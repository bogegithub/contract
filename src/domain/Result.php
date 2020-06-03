<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

use JsonSerializable;

/**
 * 返回接口
 * @package Wedoctor\Convention\Domain
 */
interface Result extends JsonSerializable
{

    /**
     * 获取错误码
     * @return string 错误码
     */
    function getCode(): string;

    /**
     * 获取成功或错误的信息
     * @return string 成功或错误的信息
     */
    function getMessage(): string;

    /**
     * 获取数据
     * @return mixed 数据
     */
    function getData();

    /**
     * 如果isError()为true，抛出ServiceErrorException
     * 如果isFailure()为true，抛出ServiceException或ServiceValidException
     * @return mixed
     */
    function checkAndGetData();

    /**
     * 获取校验失败的字段
     * @return array 校验失败的字段
     */
    function getViolationItems(): array;

    /**
     * 设置错误码
     * @param string code 错误码
     * @return Result 对象
     */
    function setCode(string $code): Result;

    /**
     * 设置成功或错误的信息
     * @param string message 成功或错误的信息
     * @return Result
     */
    function setMessage(string $message): Result;

    /**
     * 设置数据
     * @param object data 数据
     * @return Result
     */
    function setData($data): Result;

    /**
     * 设置验证失败的字段
     * @param ViolationItem[] 验证失败的字段
     * @return Result
     */
    function setViolationItems(array $violationItems);

    /**
     * 添加 ViolationItem
     * @param string field ViolationItem 的 field
     * @param string message ViolationItem 的 message
     * @return Result
     */
    function addViolationItem(string $field, string $message): Result;

    /**
     * 是否成功
     * @return bool
     */
    function isSuccess(): bool;

    /**
     * 是否错误
     * @return bool
     */
    function isError(): bool;

    /**
     * 是否是业务处理失败，业务异常
     * @return bool
     */
    function isFailure(): bool;

    /**
     * 有无校验失败的项
     * @return bool true表示存在校验失败的项目
     */
    function hasViolationItems(): bool;

}
