<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

/**
 * 游标分页接口
 * Interface CursorPage
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:58
 * @package Contract\Domain
 */
interface CursorPage
{
    /**
     * 当前页的游标
     * @return mixed
     */
    function getPageCursor();

    /**
     * 获取每页可显示的记录数
     * @return int
     */
    function getPageSize(): int;

    /**
     * 下一页的游标
     * @return mixed
     */
    function getNextCursor();

    /**
     * 是否存在下一页
     * @return bool
     */
    function hasNext(): bool;

    /**
     * 获取数据列表
     * @return mixed
     */
    function getResults();
}