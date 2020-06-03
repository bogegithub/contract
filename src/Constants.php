<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract;

interface Constants
{
    // Encode <, >, ', &, and " characters in the JSON, making it also safe to be embedded into HTML.
    // 15 === JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT
    const DEFAULT_ENCODING_OPTIONS = 15;

    const HTTP_METHOD_GET = "GET";
    const HTTP_METHOD_POST = "POST";

    const RESULT_MESSAGE = 'message';
    const RESULT_CODE = 'code';
    const VIOLATION_ITEMS = 'violationItems';
    const VIOLATION_ITEM_FIELD = 'field';

}