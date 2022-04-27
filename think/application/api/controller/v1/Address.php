<?php

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\model\UserAddress;
use app\api\validate\AddressNew;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\lib\exception\ForbiddenException;
use app\lib\exception\SuccessMessage;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Controller;
class Address extends BaseController
{
    protected  $beforeActionList = [//类似于拦截器
        'checkPrimaryScope'=>['only'=>'createOrUpdateAddress,getUserAddress']
    ];
   // protected function checkPrimaryScope(){//验证初级权限
       // //从缓存读取权限数值 对比之前获取uid
       // $scope = TokenService::getCurrentTokenVar('scope');
       // if($scope) {
       //     if ($scope >= 16) {
       //         return true;
       //     } else {
       //         //抛出异常后，http流程被中断，不再执行接口，得益于自己编写的中断处理
       //         throw new ForbiddenException();
       //     }
       // }
       // else{
       //     throw new TokenException();
       // }
        //TokenService::needPrimaryScope();
    //}
  //  protected $beforeActionList = [
  //      'first'=>['only'=>'second']//定义的意义 只有second要执行前置的first
  //  ];
  //  protected function first(){//接口的前置方法
  //      echo 'first';
  //  }
  //  public function second(){//接口
  //      echo 'second';
  //  }
    //定义控制器下接口方法
    public function createOrUpdateAddress(){
        $validate = new AddressNew();
        $validate->goCheck();
       // (new AddressNew())->goCheck();
        //根据token获取uid
        //根据uid来找用户数据，判断用户是否存在，不存在则抛出异常
        //获取用户从客户端提交来的地址信息
        //根据用户地址是否存在，从而判断是添加地址or更新地址
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);//得到user
        if(!$user){
            throw new UserException();
        }

        $dataArray= $validate->getDataByRule(input('post.'));

        $userAddress = $user->address;//用户地址 通过user的关联模型增记录√下面
        //或者直接用useraddress 在service\UserToken\UserModel已用过
        if(!$userAddress)
        {
            $user->address()->save($dataArray);//实现新增
        }
        else{
            $user->address->save($dataArray);//更新
        }
        return json(new SuccessMessage(),201);
    }
    public function getUserAddress(){
        $uid = TokenService::getCurrentUid();
        $userAddress = UserAddress::where('user_id',$uid)
            ->find();
        if(!$userAddress){
            throw new UserException([
                'msg' => '用户地址不存在',
                'errorCode' => 60001
            ]);
        }
        return $userAddress;
    }
}