<?php

namespace app\api\validate;

class TopicNew extends BaseValidate
{
    protected $rule = [
        'name'=>'require',
        'imgurl'=>'require',
        'class'=>'require|isPositiveInt',
        
    ];
}