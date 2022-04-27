<?php

use think\Route;

Route::get('api/:version/helpinfo/gettype','api/:version.Helpinfo/getAllInHelpinfo');//得到事件下所有求助信息
Route::get('api/:version/jiuzhuinfo/gettype','api/:version.Jiuzhuinfo/getAllInJiuzhuinfo');//得到某一事件下所有救助信息

Route::post('api/:version/token/user','api/:version.Token/getToken');//小程序用户登录申请token
Route::post('api/:version/token/verify','api/:version.Token/verifyToken');//验证小程序端传来的token是否过期了
Route::post('api/:version/token/app','api/:version.Token/getAppToken');//网页管理员登录获取token
Route::post('api/:version/updatename','api/:version.Token/updatename');//刷新昵称

Route::post('api/:version/address','api/:version.Address/createOrUpdateAddress');//新增or修改地址
Route::post('api/:version/addhelpinfo','api/:version.Helpinfo/createHelpinfo');//创建求助
Route::post('api/:version/selecthelpinfo','api/:version.Helpinfo/selectHelpinfo');//求助信息筛选
Route::post('api/:version/addjiuzhuinfo','api/:version.Jiuzhuinfo/createJiuzhuinfo');//发救助信息
Route::get('api/:version/pagesession','api/:version.Jiuzhuinfo/getsessions');//得到救助id下的会话（分页）
Route::post('api/:version/addsession','api/:version.Jiuzhuinfo/createSession');//发布会话

Route::get('api/:version/getall','api/:version.Helpinfo/getall');//加载所有求助信息
Route::get('api/:version/getallTopics','api/:version.Topic/getallTopics');//加载所有话题
Route::get('api/:version/getallNews','api/:version.Newsinfo/getallNews');//加载所有新闻
Route::get('api/:version/deletetopic/:id', 'api/:version.Topic/deleteOne');//删除话题以及下面的求助救助信息
Route::post('api/:version/addtopic','api/:version.Topic/createTopic');//创建话题
Route::get('api/:version/deletenews/:id', 'api/:version.Newsinfo/deleteOne');//删除新闻
Route::post('api/:version/addnews','api/:version.Newsinfo/createNew');//创建话题
Route::get('api/:version/getclassBytype','api/:version.Helpinfo/getclassBytype');//根据type找到class
Route::post('api/:version/myupload','api/:version.Jiuzhuinfo/myupload');//上传图片
Route::get('api/:version/isurgent','api/:version.Helpinfo/isurgent');//运行py脚本

Route::get('api/:version/address','api/:version.Address/getUserAddress');//获得用户的地址
Route::get('api/:version/loadhelpdetail','api/:version.Helpinfo/getAllDetail');
Route::delete('api/:version/deleteinfo/:id', 'api/:version.Helpinfo/deleteOne');
Route::post('api/:version/conducthelp','api/:version.Helpinfo/createConduct');
Route::get('api/:version/getuid-now','api/:version.Helpinfo/getuid');
Route::get('api/:version/ishelpped','api/:version.Helpinfo/ishelp');

Route::get('api/:version/getuserinfo','api/:version.Helpinfo/getuserinfo');
Route::get('api/:version/getuserinfo_j','api/:version.Helpinfo/getuserinfo_j');
Route::get('api/:version/getuserinfo_r','api/:version.Jiuzhuinfo/getuserinfo_r');//查看某个用户的发起救援
Route::get('api/:version/getUsersByHelpID/:id','api/:version.Helpinfo/getUsersByHelpID');
Route::get('api/:version/addscore','api/:version.Helpinfo/addscore');
Route::get('api/:version/addclick','api/:version.Helpinfo/addclick');
Route::get('api/:version/addcounts','api/:version.Helpinfo/addcounts');
Route::get('api/:version/searchByNeedtype','api/:version.Helpinfo/searchhelpinfoByNeedType');

Route::delete('api/:version/addscore2','api/:version.Helpinfo/addscore_2');
Route::delete('api/:version/deleteconduct/:id','api/:version.Helpinfo/deleteconduct');
Route::get('api/:version/getsallusersByorder','api/:version.Helpinfo/getallusersByorder');