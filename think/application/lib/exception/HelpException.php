<?php

namespace app\lib\exception;

class HelpException extends BaseException
{
    public $code = 404;
    public $msg = '该事件下无求助信息';
    public $errorCode = 20000;
}