<?php

namespace app\api\model;

use app\api\validate\BaseValidate;

class User extends BaseModel
{
    public function conduct(){
        return $this->hasOne('conduct','user_id','id');
    }
    public function helps()
    {
        return $this->belongsToMany('Helpinfo','conduct','help_id','user_id');
    }
    public static function getByOpenID($openid){
        $user = self::where('openid','=',$openid)
            ->find();
        return $user;
    }
    public function address(){
        return $this->hasOne('UserAddress','user_id','id');
    }
    public function helpinfo(){
        return $this->hasOne('helpinfo','user_id','id');
    }
    public function jiuzhuinfo(){
        return $this->hasOne('jiuzhuinfo','user_id','id');
    }
    public function session(){
        return $this->hasOne('session','uid','id');
    }
    
}