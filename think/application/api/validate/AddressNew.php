<?php

namespace app\api\validate;

class AddressNew extends BaseValidate
{
    protected $rule = [

      'posname'=>'require|isNotEmpty',
        'pos'=>'require|isNotEmpty',
      'long'=>'require|isNotEmpty',
        'lati'=>'require|isNotEmpty',
      //'uid'=>'..'  不能在这里传，uid自增，传来可能会覆盖其他人，不用传过来的uid，用缓存中的，根据令牌可以读取
    ];
}