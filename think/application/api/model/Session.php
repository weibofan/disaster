<?php

namespace app\api\model;
use traits\model\SoftDelete;
class Session extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    
    //根据救助id找到下面的session
    public static function getSessionPage($id,$page=1,$size=10)
    {
        $data = self::where('jiuzhu_id','=',$id)->order('create_time desc')->paginate($size,true,['page'=>$page]);
        return $data;
    }
}