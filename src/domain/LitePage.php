<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

/**
 * 轻量化分页接口
 * @package Bhc\Sdk\Model
 */
interface LitePage
{
    /**
     * 获取页号
     * @return int 页号
     */
    function getPageNumber(): int;

    /**
     * 获取每页可显示的记录数
     * @return int 每页可显示的记录数
     */
    function getPageSize(): int;

    /**
     * 获取数据列表
     * @return array 数据列表
     */
    function getResults(): array;

    /**
     * 是否有下一页
     * @return bool
     */
    function hasNext(): bool;
}