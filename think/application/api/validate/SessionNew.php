<?php

namespace app\api\validate;

class SessionNew extends BaseValidate
{
    protected $rule = [

      'content'=>'require|isNotEmpty',
      'jiuzhu_id'=>'require',
      
    ];
}