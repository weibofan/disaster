<?php

namespace app\api\validate;

use think\Validate;

class IDMustBePositiveInt extends BaseValidate
{
    protected $rule = [
        'id' => 'require|isPositiveInt',

    ];
    protected $message=[
        'id'=>'id必须是正整数'
    ];
}