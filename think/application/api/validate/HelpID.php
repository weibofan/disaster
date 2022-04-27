<?php

namespace app\api\validate;

class HelpID extends BaseValidate
{
    protected $rule = [
        'help_id' => 'require|isPositiveInt',

    ];
}