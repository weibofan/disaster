<?php

namespace app\api\model;

use traits\model\SoftDelete;
class Admin extends BaseModel
{
    protected $autoWriteTimestamp = false;
    public static function check($name,$pw){
        $res = self::where('name','=',$name)
        ->where('password','=',$pw)
        ->find();
        return $res;
    }
    public function topic(){
        return $this->hasOne('topic','creator_id','id');
    }
}