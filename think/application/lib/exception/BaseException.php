<?php

namespace app\lib\exception;

use think\Exception;

class BaseException extends \Exception//第一个异常分类
{
    public $code=400;
    public $msg='参数错误';
    public $errorCode=10000;//状态码，错误具体信息，自定义的错误码
    public function __construct($params=array()){
        if(!is_array($params)){
            return;
            //throw new Exception('参数必须是数组');
        }
        if(array_key_exists('code',$params)){
            $this->code=$params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg=$params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode=$params['errorCode'];
        }
       //parent::_construct($params);
    }
}