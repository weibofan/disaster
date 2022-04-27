<?php

namespace app\api\controller\v1;

use app\api\model\Admin;
use app\api\model\User;
use app\api\service\UserToken;
use app\api\validate\NameNew;
use app\api\validate\TokenGet;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;
use app\api\model\User as UserModel;
use app\api\service\AppToken;
use app\api\validate\AppTokenGet;
use app\lib\exception\SuccessMessage;

class Token
{
    public function getToken($code=''){//通过在小程序里调用wx接口获取code参数
        (new TokenGet())->goCheck();//code参数验证
        $ut = new UserToken($code);//新建UserTokenService类
        $token = $ut->get($code);//得到token
        return [
            'token'=>$token
        ];//把token返回客户端
    }
    public function verifyToken($token='')
    {
        if(!$token){
            throw new ParameterException([
               'token不能为空'
            ]);

        }
        $valid = TokenService::verifyToken($token);
        return [
            'isValid' => $valid
        ];
    }
    public function updatename(){
        $validate = new NameNew();
        $validate->goCheck();
        $uid = TokenService::getCurrentUid();
        $user = UserModel::get($uid);
        $arr = $validate -> getDataByRule(input('post.'));
        $user->save($arr);

        return json(new SuccessMessage(),201);
    }
    //网页端获取令牌
    public function getAppToken($name='',$pw='')//账号，密码
    {
        (new AppTokenGet())->goCheck();
        $admin = new AppToken();
        $token = $admin->get($name,$pw);//验证是否匹配
        return [
            'token'=>$token
        ];
    }
}