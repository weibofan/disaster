<?php

namespace app\api\controller\v1;

use app\api\model\Jiuzhuinfo as ModelJiuzhuinfo;
use app\api\model\Session;
use app\api\model\User;
use app\api\service\Token;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\JiuzhuNew;
use app\api\validate\PagingParameter;
use app\api\validate\SessionNew;
use app\lib\exception\JiuzhuException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use think\File;
use think\Request;

class Jiuzhuinfo
{
    //根据事件id拿到该事件下所有救助信息
    public function getAllInJiuzhuinfo($id){
        (new IDMustBePositiveInt())->goCheck();
        $jiuzhuinfo = ModelJiuzhuinfo::getJiuzhuinfoByType($id);
        if(empty($jiuzhuinfo)){
            throw new JiuzhuException();
        }
        return $jiuzhuinfo;
    }
    public function createJiuzhuinfo(){
        $validate = new JiuzhuNew();
        $validate->goCheck();
        $uid = Token::getCurrentUid();
        $user = User::get($uid);
        if(!$user){
            throw new UserException();
        }
        $data = $validate->getDataByRule(input('post.'));
        $user->jiuzhuinfo()->save($data);
        return json(new SuccessMessage(),201);

    }
    //得到救助id下的会话
    public function getsessions($id,$page=1,$size=10)
    {
        (new PagingParameter())->goCheck();
        $data = Session::getSessionPage($id,$page,$size);
        if ($data->isEmpty())
        {
            return [
                'current_page' => $data->currentPage(),
                'data' => []
            ];
        }
        $res = $data ->toArray();
        return [
            'current_page' => $data->currentPage(),
            'data' => $res
        ];
    }

    //发布会话
    public function createSession(){
        $validate = new SessionNew();
        $validate->goCheck();
        
        $uid = Token::getCurrentUid();
        $user=User::get($uid);
        if(!$user) throw new UserException();
        $data = $validate->getDataByRule(input('post.'));
        $data['name']=$user->name;
        $id = $data['jiuzhu_id'];
        $add = ModelJiuzhuinfo::addsession($id);
        $user->session()->save($data);
        return json(new SuccessMessage(),201);
    }

    //根据uid查找发布的救助信息
    public function getuserinfo_r(){
        $uid = Token::getCurrentUid();
        $userinfo = ModelJiuzhuinfo::where('user_id','=',$uid)
            ->order('create_time desc')
            ->select();
        return $userinfo;
    }

    //在线图片
    public  function myupload(){
    
        $file = request()->file('file');
        $filepath = 'public'.DS.'uploads';
        $info = $file->move(ROOT_PATH.$filepath);
        
        if($info){
            $res = 'https://www.disasteruser.info/disaster/think/public'.DS.'uploads'.DS.$info->getSaveName();
            $res = str_replace('\/','/',$res);
            return $res;
        }
        else{
            return $file->getError();
        }

    }
}