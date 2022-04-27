<?php

namespace app\api\controller\v1;

use app\api\model\User;
use app\api\model\User as UserModel;
use app\api\validate\HelpID;
use app\api\validate\HelpNew;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\api\model\Helpinfo as HelpModel;
use app\lib\exception\HelpException;
use app\api\service\Token as TokenService;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;
use app\api\model\Conduct as ConductModel;
use app\api\model\Helpinfo as ModelHelpinfo;
use app\api\model\Topic;
use app\api\validate\HelpSelect;
use think\Db;
use \thinkphp\library\think\db\Query as Query;
class Helpinfo
{
    public function getAllInHelpinfo($id){
        (new IDMustBePositiveInt())->goCheck();
        $helpinfo = HelpModel::getHelpinfoByType($id);
        if(empty($helpinfo)){
            throw new HelpException();
        }
        return $helpinfo;
    }
    public function getAllDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $helpinfo = HelpModel::getHelpinfoByID($id);
        if(empty($helpinfo)){
            throw new HelpException();
        }
        return $helpinfo;
    }
    public function getclassBytype($type){
        $id = Topic::where('id','=',$type)->find()['class'];
        return $id;
    }
    public function createHelpinfo(){
        $validate = new HelpNew();
        $validate->goCheck();//批量验证
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        if(!$user){
            throw new UserException();
        }
        $data = $validate->getDataByRule(input('post.'));
	$user->helpinfo()->save($data);
	$res=$this->testpy($data['content']);
	if($res=='1') {
		$id = Db::table('helpinfo')->getLastInsID();
		// Db::table('urgent')->insert([
		// 	'hid'=>$id,
		// 	'isurgent'=>1,
		// ]);
		$res2 = ModelHelpinfo::where('id',$id)->update(['urgent'=>1]);	

	}
        return json(new SuccessMessage(),201);

    }
    public function isurgent($hid){
	$res = Db::table('urgent')->where('hid','=',$hid)->find();
	return $res;
    }
    public function selectHelpinfo(){//筛选
        $validate = new HelpSelect();
        $validate->goCheck();
        
        $data = $validate->getDataByRule(input('post.'));
        $res = ModelHelpinfo::getHelpinfoBySelection($data['type'],$data['needtype'],$data['position'],$data['mintime'],$data['maxtime']);
        return $res;
    }
    public function deleteOne($id)
    {
        HelpModel::destroy($id);

    }
    public function getuid(){

        $uid = TokenService::getCurrentUid();
        return $uid;
    }
    public function createConduct(){//传入help_id
        $validate = new HelpID();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        $data = $validate->getDataByRule(input('post.'));
        if(!$user){
            throw new UserException();
        }
        $user->conduct()->save($data);
        return json(new SuccessMessage(),201);
    }
    public function ishelp($id){
        //$result = ConductModel::ishelpped($id);
        $conductmodel = new ConductModel();
        $result = $conductmodel->ishelpped($id);
        return $result;
    }
    public function getuserinfo(){
        $uid = TokenService::getCurrentUid();
        $userinfo = HelpModel::where('user_id','=',$uid)
            ->order('create_time desc')
            ->select();
        return $userinfo;
    }
    public function getuserinfo_j(){
        $uid = TokenService::getCurrentUid();
        $userinfo = UserModel::where('id','=',$uid)
            ->with(['helps'=>function($query){
            $query->order(array('create_time'=>'desc'));
        }])
            ->select();
        return $userinfo;
    }
    //得到这个求助单下哪些用户点了发起救助
    public function getUsersByHelpID($id){
        $users = HelpModel::where('id','=',$id)
            ->with('helps')
            ->select();
        return $users;
    }
    public function addscore($id,$ids=''){
        $ids=explode(',',$ids);
        $result = UserModel::where('id','in',$ids)
            ->setInc('score',1);
        return $result;
    }
    public function searchhelpinfoByNeedType($id,$ids=''){
        $ids=explode(',',$ids);
        $result = HelpModel::where('type','=',$id)->where('needtype','in',$ids)
            ->select();
        return $result;
    }
    public function addclick($id){
        $result = HelpModel::where('id','=',$id)
            ->setInc('clicks',1);
        return $result;
    }
    public function addcounts($id){
        $result = HelpModel::where('id','=',$id)
            ->setInc('helpcounts',1);
        return $result;
    }
    public function addscore_2($id,$ids=''){
        $ids=explode(',',$ids);
        $result = ConductModel::where('help_id','=',$id)->where('user_id','in',$ids)
            ->delete();
        return $result;
    }
    public function deleteconduct($id){
        $result = ConductModel::where('help_id','=',$id)
            ->delete();
        return $result;
    }
    public function getallusersByorder(){
        $result = UserModel::order('score','desc')
            ->select();
        foreach($result as $resitem){
            unset($resitem['openid']);
        }
        return $result;
    }
    public function getall(){
        $result = HelpModel::with('getclass')->select();;
        return $result;
    }
    public function testpy($str){
	    $param = $str;
	    //var_dump($param);
	    $py_exe = "python3";
	    $py_file = getcwd()."/urgent/main.py";
	    exec("$py_exe $py_file $param",$data);
	    return $data[0];
    }
}
