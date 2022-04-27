<?php

namespace app\api\service;

use app\api\model\Admin;
use app\lib\exception\TokenException;

class AppToken extends Token{
    public function get($name,$pw)//到数据库比对，并存入缓存
    {
        $res = Admin::check($name,$pw);
        if(!$res){
            throw new TokenException([
                'msg' => '登录失败!',
                'errorCode' => 10004
            ]);
        }
        else{
            
            $store = [
                'scope' => $res->scope,
                'uid' => $res->id,
            ];
            //存入缓存
            return $this->saveToCache($store);
        }
    }
    private function saveToCache($store){
        $token = self::generateToken();
        $expire_in = config('setting.token_expire_in');
        $res = cache($token,json_encode($store),$expire_in);
        if(!$res){
            throw new TokenException([
                'msg' => '服务器缓存异常',
                'errorCode' => 10005
            ]);
        }
        return $token;
    }
}