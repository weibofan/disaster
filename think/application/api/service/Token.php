<?php

namespace app\api\service;
use app\api\service\Token as TokenService;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;
class Token
{
    public static function generateToken(){//获取随机字串token的键
        $randChars = getRandChar(32);//这个方法独立于这些，可以放到common.php
        //加强安全性：用三组字符串，进行md5加密
        $timestamp = $_SERVER['REQUEST_TIME_FLOAT'];
        //salt盐 随机字符串
        $salt = config('secure.token_salt');
        return md5($randChars.$timestamp.$salt);
    }
    public static function getCurrentTokenVar($key){//根据token从缓存拿对应的用户信息
        //从http请求的header拿到token  首先获取request实例 除了在控制器里用，其他地方也可以
        $token = Request::instance()
            ->header('token');
        $vars = Cache::get($token);
        if(!$vars){
            throw new TokenException();//看默认值，判断是否要覆盖新值
        }
        else{
            //存进去存的是字符串，转为数组
            if(!is_array($vars))
            {
                $vars = json_decode($vars,true);
            }
            if(array_key_exists($key,$vars)){//vars数组中存在key
                return $vars[$key];
            }
            else{
                throw new Exception('尝试获取的token变量不存在');//这样的错误不用返回客户端，因此采用tp5自带的
            }
        }
    }
    public static function getCurrentUid(){//根据token从缓存拿到用户id
        //得到token
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }
    public static function needPrimaryScope(){//权限验证，是否为本平台使用者
        $scope = self::getCurrentTokenVar('scope');
        if($scope)
        {
            if($scope >= ScopeEnum::User){
                return true;
            }
            else
            {
                throw new ForbiddenException();
            }
        }
        else{
            throw new TokenException();
        }
    }
    public static function needExclusiveScope(){//权限验证，是否为本平台管理员
        //从缓存读取权限数值 对比之前获取uid
        $scope = self::getCurrentTokenVar('scope');
        if($scope) {
            if ($scope == 32) {//只让管理员访问
                return true;
            } else {
                //抛出异常后，http流程被中断，不再执行接口
                throw new ForbiddenException();
            }
        }
        else{
            throw new TokenException();
        }
    }
    public static function isValidOperate($checkedUID){//比对两个用户id，判断是否为当前用户
        if(!$checkedUID){
            throw new Exception('检查UID时必须传入一个被检查的UID');
        }
        //当前请求用户的uid
        $currentOperateUID = self::getCurrentUid();
        if($currentOperateUID == $checkedUID){
            return true;
        }
        return false;
    }
    public static function verifyToken($token)//当前token是否在缓存中
    {
        $exist = Cache::get($token);
        if($exist){
            return true;
        }
        else{
            return false;
        }
    }
}