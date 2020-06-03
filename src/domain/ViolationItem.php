<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Princebo\Contract\Domain;

interface ViolationItem{

    /**
     * 获取验证失败的字段名
     * @return string 验证失败的字段名
     */
    function getField():string;

    /**
     * 设置验证失败的字段名
     * @param string field 验证失败的字段名
     */
    function setField (string $field);

    /**
     * 获取验证失败的信息
     * @return string 验证失败的信息
     */
    function getMessage():string;

    /**
     * 设置验证失败的信息
     * @param string message 验证失败的信息
     */
    function setMessage(string $message);

}