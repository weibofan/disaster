<?php

namespace app\api\controller\v1;

use app\api\model\Newsinfo as ModelNewsinfo;
use app\lib\exception\SuccessMessage;

class Newsinfo{
    //加载所有话题
    public static function getallNews(){
        $res=ModelNewsinfo::order('create_time desc')->select();
        return $res;
    }
    public static function deleteOne($id){
        ModelNewsinfo::destroy($id);
        return json(new SuccessMessage(),201);
    }
    public static function createNew(){
        $data = input('post.');
        $news = new ModelNewsinfo();
        $news->save($data);
        return json(new SuccessMessage(),201);
    }
}