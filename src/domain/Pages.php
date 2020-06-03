<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Domain;

/**
 * 分页静态工厂
 * @package bhc\sdk\model
 */
class Pages
{
    /**
     * 默认每页显示的记录数
     */
    const DEFAULT_PAGE_SIZE = 20;

    /**
     * 单页最多显示记录数
     */
    const MAX_PAGE_SIZE = 200;

    /**
     * 翻页静态创建方法
     * @param array $results 数据列表
     * @param int $totalCount 总记录数
     * @param int $pageNumber 当前页数
     * @param int $pageSize 每页显示的记录数
     * @return Page
     */
    public static function page(array $results, int $totalCount, int $pageNumber = 1,
                                int $pageSize = Pages::DEFAULT_PAGE_SIZE)
    {
        return new DefaultPage($results, $totalCount, $pageNumber, $pageSize);
    }

    /**
     * 轻量级的翻页静态创建方法
     * 只有下一页，没有最终页
     * @param array $results 数据列表
     * @param bool $hasNext 是否有下一页
     * @param int $pageNumber 当前页数
     * @param int $pageSize 每页显示的记录数
     * @return LitePage
     */
    public static function litePage(array $results, bool $hasNext, int $pageNumber = 1,
                                    int $pageSize = Pages::DEFAULT_PAGE_SIZE)
    {
        return new DefaultLitePage($results, $hasNext, $pageNumber, $pageSize);
    }

    /**
     * 游标翻页静态创建方法
     * 只有下一页，没有最终页
     *
     * @param string|int $pageCursor 当前页的游标
     * @param int $pageSize 每页显示的记录数
     * @param bool $hasNext 有无下一页
     * @param string|int|null $nextCursor 下一页的游标
     * @param array $results 数据列表
     * @return CursorPage
     */
    public static function cursorPage(array $results, bool $hasNext, $nextCursor, $pageCursor,
                                      int $pageSize = Pages::DEFAULT_PAGE_SIZE)
    {
        return new DefaultCursorPage($results,
            $hasNext,
            $nextCursor,
            $pageCursor,
            $pageSize);
    }

}