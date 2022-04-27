<?php

namespace app\api\service;

use app\api\model\User;
use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code ;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $wxLoginUrl;

    function __construct($code){
        $this->code=$code;
        $this->wxAppID=config('wx.app_id');
        $this->wxAppSecret=config('wx.app_secret');
        $this->wxLoginUrl=sprintf(config('wx.login_url'),$this->wxAppID,$this->wxAppSecret,$this->code);

    }

    public function get($code){//访问微信服务器拿到code
        //发送一个http请求 指定访问url
        $result=curl_get($this->wxLoginUrl);//请求的调用结果 字符串
        //变成一个对象or数组y
        $wxResult = json_decode($result,true);
        if(empty($wxResult)){//code码非法情况
            throw new Exception('获取session_key、openid时异常');//不想让他返回客户端去，所以用thinkphp的exception
        }
        else{
            //进一步判断
            $loginFail = array_key_exists('errcode',$wxResult);//如果errorkey存在
            //tip 无论成功or失败，微信都返回2..状态码
            if($loginFail){
                $this->processLoginError($wxResult);//封装成方法易于扩展，直接在这里写异常代码也可以
            }
            else{//成功返回了需要的消息
                return $this->grantToken($wxResult);//颁发令牌
            }
        }
    }
    //拿到openid
    //去数据库里看一下openid是否已经存在(用户已经生成） 没有则为用户生成一条user记录
    //生成token 写入缓存
    //把令牌返回到客户端去
    private function grantToken($wxResult){//核心
        
        $openid = $wxResult['openid'];
        $user=UserModel::getByOpenID($openid);
        if($user){
            $uid=$user->id;
        }
        else{
            //编写一个插入用户的方法
            $uid=$this->newUser($openid);
        }
        $cachedValue=$this->prepareCachedValue($wxResult,$uid);
        $token = $this->saveToCache($cachedValue);
        return $token;
    }
    private function saveToCache($cachedValue){//存入缓存
        $key=self::generateToken();//生成key:令牌
        //value要字符串，把数组转为字符串
        $value = json_encode($cachedValue);
        $expire_in = config('setting.token_expire_in');
        //使用tp5自带的缓存系统
        $request = cache($key,$value,$expire_in);//默认使用文件系统缓存
        if(!$request){
            //结果不存在，则抛出异常返回客户端
            throw new TokenException([
               'msg'=>'服务器缓存异常',
               'errorCode'=>10005
            ]);
        }
        return $key;
    }
    private function prepareCachedValue($wxResult,$uid){//缓存数据打包
        $cachedValue=$wxResult;
        $cachedValue['uid']=$uid;
        //16代表app用户的权限 32代表CMS管理员的权限 用枚举类型表示 用其他模拟 在lib下面新建enum文件夹
        $cachedValue['scope']=ScopeEnum::User;//权限，越大级别越大
        return $cachedValue;
    }
    private function newUser($openid){//向数据库写入一条记录
        $user=UserModel::create([
            'openid'=>$openid,
            'score'=>0
        ]);//以模型的形式
        return $user->id;
    }
    //异常处理：抛出访问微信服务器失败异常
    private function processLoginError($wxResult){
        throw new WeChatException([
            'msg'=>$wxResult['errmsg'],
            'errorCode'=>$wxResult['errcode']
        ]);
    }
}