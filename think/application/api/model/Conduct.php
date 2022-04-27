<?php

namespace app\api\model;

use app\api\service\Token as TokenService;
use traits\model\SoftDelete;
class Conduct extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    public function helpid()
    {
        return $this->belongsTo('helpinfo', 'help_id', 'id');
    }
    public function userid()
    {
        return $this->belongsTo('user','user_id','id');
    }
    public function ishelpped($help_id){
        $uid = TokenService::getCurrentUid();
        $result = self::where('user_id','=',$uid)
            ->where('help_id','=',$help_id)
            ->select();
        return $result;
    }
}