<?php

namespace app\api\validate;

class IDCollection extends BaseValidate
{
    protected $rule=[
        'ids' => 'require|checkIDs'
    ];
    protected $message = [
        'ids'=>'id必须是正整数'
    ];
    protected function checkIDs($values){
        $values = explode(',',$values);
        if(empty($values)){
            return false;
        }
        foreach($values as $id){
            //判断id是否都是正整数，在idmustbepositive里已经有，把一部分提取到基类里basevalidate
            if(!$this->isPositiveInt($id)){
                return false;
            }
        }
        return true;
    }
}