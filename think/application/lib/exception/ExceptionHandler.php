<?php

namespace app\lib\exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    //要返回到客户端的URL路径

    public function render(\Exception $e){//所有抛出的异常由render来渲染，决定返回
       if($e instanceof BaseException){
           $this->code = $e ->code;
           $this->msg = $e ->msg;
           $this -> errorCode = $e -> errorCode;
       }
       else{
           //$switch=true;
           //Config::get('app_debug');
           if(config('app_debug')){
               return parent::render($e);
           }else {
               $this->code = 500;
               $this->msg = '服务器内部错误';
               $this->errorCode = 999;
               $this->recordErrorLog($e);//调用
           }
       }
       $request = Request::instance();

       $result = [
           'msg'=> $this->msg,
           'error_code'=>$this->errorCode,
           'request_url'=>$request->url()
       ];
       return json($result,$this->code);//给客户端
   }
    private function recordErrorLog(\Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error']
        ]);
        Log::record($e->getMessage(),'error');//只有高于error级别的才会记录
    }
}