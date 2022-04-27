$(function(){
    $(document).on('click','#postnews',function(){
        var $newsName=$('#news-name'),
            $newsUrl=$('#news-imgurl'),
            $newsContent=$('#news-content');
        if(!$newsName.val()) {
            $newsName.next().show().find('div').text('输入新闻标题');
            return;
        }
        if(!$newsUrl.val()) {
            $newsUrl.next().show().find('div').text('输入图片网址');
            return;
        }
        if(!$newsContent.val()) {
            $newsContent.next().show().find('div').text('输入新闻内容');
            return;
        }
        
        var params={
            url:'addnews',
            type:'post',
            data:{title:$newsName.val(),imgurl:$newsUrl.val(),content:$newsContent.val()},
            sCallback:function(res){
                if(res){
                    window.location.href = 'index.html';
                }
            },
            
        };
        window.base.getData(params);
    });

    $(document).on('focus','.normal-input',function(){
        $('.common-error-tips').hide();
    });
});