<?php

namespace app\api\model;

use think\Collection as ThinkCollection;
use think\model\Collection;
use traits\model\SoftDelete;
class Helpinfo extends BaseModel
{
    use SoftDelete;
    protected static $deleteTime = 'delete_time';
    public function conduct(){
        return $this->hasOne('conduct','help_id','id');
    }
    public function helps()
    {
        return $this->belongsToMany('User','conduct','user_id','help_id');
    }
    public function getclass()
    {
        return $this->belongsTo('topic','type','id');
    }
    public static function getHelpinfoByType($id){
        $helpinfo = self::where('type','=',$id)
            ->order('create_time desc')
            ->select();
        return $helpinfo;
    }
    public static function getHelpinfoByID($id){
        $helpinfo = self::where('id','=',$id)
            ->select();
        return $helpinfo;
    }
    public static function getHelpinfoBySelection($type,$needtype,$position="",$mintime,$maxtime){
        $needtype=explode(',',$needtype);
        $helpinfos = self::where('type','=',$type)->where('needtype','in',$needtype) -> where('create_time','>=',$mintime) -> where('create_time','<',$maxtime) -> order('create_time')
        ->select();
        if($position=="") return $helpinfos;
        $res = new Collection();
        $helpinfos->each(function ($helpinfo) use (&$res,$position){
            //var_dump(strpos($helpinfo['position'],$position));
            if(strpos($helpinfo['position'],$position) !== false){
                $res->unshift($helpinfo);
            }
        });
        
        return $res;
    }
    
}