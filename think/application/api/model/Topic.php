<?php

namespace app\api\model;
use traits\model\SoftDelete;
class Topic extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    public function helpinfo(){
        return $this->hasOne('helpinfo','type','id');
    }
    public function admin(){
        return $this->belongsTo('admin','creator_id','id');
    }
}