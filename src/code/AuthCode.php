<?php

/**
 * Created by PhpStorm.
 * User: yanbo
 * Date: 2020/6/2
 * Time: 20:42
 */
namespace Contract\Code;

class AuthCode
{
    const INVALID_SCOPE_PARAMETER = "AUTH_0";
    const INVALID_SCOPE_PARAMETER_MSG = "在请求中存在无效的scope参数";

    const MISSING_SCOPE_PARAMETER = "AUTH_1";
    const MISSING_SCOPE_PARAMETER_MSG = "在请求中scope参数丢失";

    const UNAUTHORIZED_CLIENT = "AUTH_2";
    const UNAUTHORIZED_CLIENT_MSG = "不支持当前的授权方式";

    const AUTHORIZATION_DENIED_BY_USER = "AUTH_3";
    const AUTHORIZATION_DENIED_BY_USER_MSG = "用户授权拒绝";

    const MISSING_CODE_PARAMETER = "AUTH_4";
    const MISSING_CODE_PARAMETER_MSG = "code参数不能为空";

    const MISSING_REDIRECT_URI_PARAMETER = "AUTH_5";
    const MISSING_REDIRECT_URI_PARAMETER_MSG = "redirect_uri参数不能为空";

    const INVALID_REDIRECT_URI_PARAMETER = "AUTH_6";
    const INVALID_REDIRECT_URI_PARAMETER_MSG = "无效的redirect_uri参数";

    const INVALID_AUTHORIZATION_CODE = "AUTH_7";
    const INVALID_AUTHORIZATION_CODE_MSG = "无效的授权码";

    const AUTHORIZATION_CODE_HAS_EXPIRED = "AUTH_8";
    const AUTHORIZATION_CODE_HAS_EXPIRED_MSG = "授权码已过期";

    const MISSING_USERNAME_PARAMETER = "AUTH_9";
    const MISSING_USERNAME_PARAMETER_MSG = "username参数不能为空";

    const MISSING_PASSWORD_PARAMETER = "AUTH_10";
    const MISSING_PASSWORD_PARAMETER_MSG = "password参数不能为空";

    const INVALID_REFRESH_TOKEN = "AUTH_11";
    const INVALID_REFRESH_TOKEN_MSG = "无效的refresh token";

    const MISSING_REFRESH_TOKEN = "AUTH_12";
    const MISSING_REFRESH_TOKEN_MSG = "refresh token参数不能为空";

    const GRANT_NOT_SUPPORTED = "AUTH_13";
    const GRANT_NOT_SUPPORTED_MSG = "不支持的授权类型";


    const INVALID_USERNAME_PARAMETER = "AUTH_14";
    const INVALID_USERNAME_PARAMETER_MSG = "无效的username参数";

    const NO_CLIENT_COULD_BE_FOUND = "AUTH_15";
    const NO_CLIENT_COULD_BE_FOUND_MSG = "无效的客户端";

    const INVALID_ACCESS_TOKEN = "AUTH_16";
    const INVALID_ACCESS_TOKEN_MSG = "无效的access token";

    const INVALID_CLIENT_CREDENTIALS = "AUTH_17";
    const INVALID_CLIENT_CREDENTIALS_MSG = "无效的客户端授权";

    const MISSING_CONFIRM_PASSWORD = "AUTH_18";
    const MISSING_CONFIRM_PASSWORD_MSG = "确认密码不为空";

    const MISSING_VALIDATION_CODE = "AUTH_19";
    const MISSING_VALIDATION_CODE_MSG = "手机验证码不为空";

    const MISSING_ACCESS_TOKEN = "AUTH_20";
    const MISSING_ACCESS_TOKEN_MSG = "access token参数不能为空";

    const ACCESS_TOKEN_HAS_EXPIRED = "AUTH_21";
    const ACCESS_TOKEN_HAS_EXPIRED_MSG = "access token已过期";

    const INVALID_TICKET = "AUTH_22";
    const INVALID_TICKET_MSG = "无效的ticket值";

    const INVALID_TIMESTAMP = "AUTH_23";
    const INVALID_TIMESTAMP_MSG = "无效的timestamp值";

    const INVALID_SIGN = "AUTH_24";
    const INVALID_SIGN_MSG = "无效的签名";

    const INVALID_DATA = "AUTH_25";
    const INVALID_DATA_MSG = "无效的数据";

    const INVALID_VERSION = "AUTH_26";
    const INVALID_VERSION_MSG = "无效的版本号";

}