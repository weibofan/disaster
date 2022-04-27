$(function(){
    $(document).on('click','#login',function(){
        var $userName=$('#user-name'),
            $pwd=$('#user-pwd');
        if(!$userName.val()) {
            $userName.next().show().find('div').text('输入用户名');
            return;
        }
        if(!$pwd.val()) {
            $pwd.next().show().find('div').text('输入密码');
            return;
        }
        var params={
            url:'token/app',
            type:'post',
            data:{name:$userName.val(),pw:$pwd.val()},
            sCallback:function(res){
                if(res){
                    window.base.setLocalStorage('token',res.token);
                    window.location.href = 'index.html';
                }
            },
            eCallback:function(e){
                if(e.status==401){
                    $('.error-tips').text('帐号或密码错误').show().delay(2000).hide(0);
                }
            }
        };
        window.base.getData(params);
    });

    $(document).on('focus','.normal-input',function(){
        $('.common-error-tips').hide();
    });
});