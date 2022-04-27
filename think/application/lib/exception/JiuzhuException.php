<?php

namespace app\lib\exception;

class JiuzhuException extends BaseException
{
    public $code = 404;
    public $msg = '该事件下无救助信息';
    public $errorCode = 20000;
}