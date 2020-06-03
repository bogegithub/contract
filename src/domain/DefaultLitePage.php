<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;


use Contract\Exception\ServiceValidException;

/**
 * 默认的轻量翻页实现
 * Class DefaultLitePage
 * User: yanbo
 * Date: 2020/6/2
 * Time: 21:00
 * @package Contract\Domain
 */
class DefaultLitePage implements LitePage
{
    /**
     * 第几页
     */
    public $pageNumber;
    /**
     * 每页显示多少条记录数
     */
    public $pageSize;

    /**
     * 是否有下一页
     * @var bool 是否有下一页
     */
    public $hasNext;

    /**
     * 结果集
     * @var array 结果集
     */
    public $results;

    function __construct(array $results, bool $hasNext, int $pageNumber = 1, int $pageSize = 10)
    {
        if ($pageNumber < 1) {
            throw new ServiceValidException("当前页不能小于1");
        }
        if ($pageSize < 1) {
            throw new ServiceValidException("单页记录不能小于1");
        }
        if ($pageSize > Pages::MAX_PAGE_SIZE) {
            throw new ServiceValidException("单页最多不能超过200条记录");
        }

        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
        $this->results = $results ?? [];
        $this->hasNext = $hasNext;
    }

    /**
     * 获取页号
     * @return int 页号
     */
    function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * 获取每页可显示的记录数
     * @return int 每页可显示的记录数
     */
    function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * 获取数据列表
     * @return array 数据列表
     */
    function getResults(): array
    {
        return $this->results;
    }

    /**
     * 是否有下一页
     * @return bool
     */
    function hasNext(): bool
    {
        return $this->hasNext;
    }
}