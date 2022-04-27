<?php

namespace app\api\validate;

class HelpSelect extends BaseValidate
{
    protected $rule = [
        'type'=>'require|isPositiveInt',
        'needtype'=>'require|isNotEmpty',
        'position'=>'nocheck',
        'mintime'=>'require|isPositiveInt',
        'maxtime'=>'require|isPositiveInt',
        
    ];
}