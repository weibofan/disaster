<?php

namespace app\api\model;
use traits\model\SoftDelete;
class Jiuzhuinfo extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    
    //根据事件id找到下面的救助信息
    public static function getJiuzhuinfoByType($id){
        $jiuzhuinfo = self::where('type','=',$id)->order('create_time desc')->select();
        return $jiuzhuinfo;
    }

    //sessioncounts+1
    public static function addsession($id){
        self::where('id','=',$id)->setInc('sessioncounts',1);
        return;
    }

    
}