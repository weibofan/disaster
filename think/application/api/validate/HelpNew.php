<?php

namespace app\api\validate;

class HelpNew extends BaseValidate
{
    protected $rule = [
        'name'=>'require|isNotEmpty',
        'mobile'=>'require|isNotEmpty',
        'position'=>'require|isNotEmpty',
        'type'=>'require|isPositiveInt',
        'needtype'=>'require|isPositiveInt',
        'content'=>'require|isNotEmpty',
        'long'=>'require|isNotEmpty',
        'lati'=>'require|isNotEmpty',
        'clicks'=>'nocheck',
        'helpcounts'=>'nocheck',
        'urgent'=>'nocheck'
        //'uid'=>'..'  不能在这里传，uid自增，传来可能会覆盖其他人，不用传过来的uid，用缓存中的，根据token可以读取
    ];
}