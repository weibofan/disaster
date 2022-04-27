$(function(){
    $(document).on('click','#posttopic',function(){
        var $topicName=$('#topic-name'),
            $topicUrl=$('#topic-imgurl'),
            $topicClass=$('#topic-class');
        if(!$topicName.val()) {
            $topicName.next().show().find('div').text('输入话题名称');
            return;
        }
        if(!$topicUrl.val()) {
            $topicUrl.next().show().find('div').text('输入图片网址');
            return;
        }
        if(!$topicClass.val()) {
            $topicClass.next().show().find('div').text('输入灾害类型');
            return;
        }
        
        if(!(Number($topicClass.val())==1 || Number($topicClass.val())==2 || Number($topicClass.val())==3 || Number($topicClass.val())==4) ){
            $topicClass.next().show().find('div').text('1:气象灾害 2:地质灾害 3:传染疾病 4:其他\n请输入正确的值');
            return;
        }
        var params={
            url:'addtopic',
            type:'post',
            tokenFlag:true,
            data:{name:$topicName.val(),imgurl:$topicUrl.val(),class:Number($topicClass.val())},
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