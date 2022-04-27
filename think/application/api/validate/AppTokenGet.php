<?php

namespace app\api\validate;

class AppTokenGet extends BaseValidate
{
    protected $rule = [
        'name' => 'require|isNotEmpty',
        'pw' => 'require|isNotEmpty',
    ];
}