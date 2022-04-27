<?php

namespace app\api\validate;

use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck(){//批量验证，抛出错误
        //获取所有参数
        $request = Request::instance();
        $params = $request->param();

        $result = $this->batch()->check($params);
        if(!$result){
            $e=new ParameterException([
                'msg' => $this->error,
            ]);
            throw $e;
        }
        else{
            return true;
        }
    }
    protected function nocheck($value,$rule='',$data='',$field=''){
        return true;
    }
    protected function isPositiveInt($value,$rule='',$data='',$field=''){//自定义验证规则
        if(is_numeric($value) && is_int($value+0) && ($value+0)>0 ){
            return true;
        }
        else{
            //不符合验证规则的说明 字段
            return false;
        }
    }
    protected function isNotEmpty($value,$rule='',$data='',$field=''){
        if(empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    protected function isMobile($value)
    {
        //$rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $rule = '^[0-9][0-9][0-9]-\d{8}$^';
        $result=preg_match($rule,$value);
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    public function getDataByRule($arrays){//接收客户端传过来的所有参数变量，在内部做过滤筛选
        if(array_key_exists('user_id',$arrays)|array_key_exists('uid',$arrays))
        {   //不允许包含user_id uid，防止恶意覆盖user_id外键
            throw new ParameterException(
                [
                    'msg'=>'参数中包含非法参数名user_id或者uid'
                ]
            );
        }
        $newArray=[];
        foreach($this->rule as $key => $value)
        {
            $newArray[$key]=$arrays[$key];
        }
        return $newArray;
    }
}