<?php

namespace app\api\controller\v1;

use app\api\model\Admin;
use app\api\model\Conduct;
use app\api\model\Helpinfo;
use app\api\model\Jiuzhuinfo;
use app\api\model\Session;
use app\api\model\Topic as ModelTopic;
use app\api\model\User;
use app\api\service\Token;
use app\api\validate\TopicNew;
use app\lib\exception\SuccessMessage;
use think\model\Collection;

class Topic{
    //加载所有话题
    public static function getallTopics(){
        $res=ModelTopic::order('create_time desc')->with('admin')->select();
        return $res;
    }

    //删除以及下面的求助救助session
    public function deleteOne($id)
    {
        //得到helpinfo的ids
        $ids = Helpinfo::where('type','=',$id)->field('id')->select();
        $ids->each(function ($id) {
            $id = $id['id'];
            //删除conduct表
            $res = Conduct::where('help_id','=',$id)->delete();
            //删除helpinfo表
            Helpinfo::destroy($id);
        });
        
        //得到jiuzhuinfo的ids
        $ids_j = Jiuzhuinfo::where('type','=',$id)->field('id')->select();
        $ids_j->each(function ($id) {
            $id = $id['id'];
            //删除session表
            $res = Session::where('jiuzhu_id','=',$id)->delete();
            //删除jiuzhuinfo表
            Jiuzhuinfo::destroy($id);
        });
        //删除topic
        ModelTopic::destroy($id);
        return json(new SuccessMessage(),201);
    }

    //创建话题
    public function createTopic(){
        $validate = new TopicNew();
        $validate->goCheck();
        $uid = Token::getCurrentUid();
        $user = Admin::get($uid);
        // var_dump($uid);
        $data = $validate->getDataByRule(input('post.'));
        $user->topic()->save($data);
        return json(new SuccessMessage(),201);

    }
}
