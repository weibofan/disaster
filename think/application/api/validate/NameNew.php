<?php

namespace app\api\validate;

class NameNew extends BaseValidate
{
    protected $rule = [
        'name'=>'require|isNotEmpty',

    ];
}