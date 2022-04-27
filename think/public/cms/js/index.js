$(function(){

    if(!window.base.getLocalStorage('token')){
        window.location.href = 'login.html';
    }

    var moreDataFlag=true;
    getOrders();
    getNews();
    //加载话题
    function getOrders(){
        var params={
            url:'getallTopics',
            tokenFlag:true,
            sCallback:function(res) {
                // console.log('ss')
                // console.log(res);
                var str = getOrderHtmlStr(res);
                $('#order-table').append(str);
            }
        };
        window.base.getData(params);
    }
    //加载新闻
    function getNews(){
        var params={
            url:'getallNews',
            sCallback:function(res) {
                //console.log(res);
                var str = getOrderHtmlStr2(res);
                $('#news-table').append(str);
            }
        }
        window.base.getData(params);
    }
    /*拼接html字符串-话题*/
    function getOrderHtmlStr(res){
        var arr = ['气象','地质','传染疾病','其他'];
        if (res){
            var len = res.length,
                str = '', item;
            if(len>0) {
                for (var i = 0; i < len; i++) {
                    item = res[i];
                    str += '<tr>' +
                        '<td>' + item.name + '</td>' +
                        '<td>' + item.imgurl + '</td>' +
                        '<td>' + item.admin.name + '</td>' +
                        '<td>' + item.create_time + '</td>' +
                        '<td>' + arr[item.class-1] + '</td>' +
                        '<td data-id="' + item.id + '">' + '<span class="order-btn done"> 删除 </span>' + '</td>' +
                        '</tr>';
                }
            }
            
            return str;
        }
        return '';
    }

    /*拼接html字符串-新闻*/
    function getOrderHtmlStr2(res){
        
        if (res){
            var len = res.length,
                str = '', item;
            if(len>0) {
                for (var i = 0; i < len; i++) {
                    item = res[i];
                    str += '<tr>' +
                        '<td>' + item.title + '</td>' +
                        '<td>' + item.content + '</td>' +
                        '<td>' + item.imgurl + '</td>' +
                        '<td>' + item.create_time + '</td>' +
                        '<td data-id="' + 'a'+item.id + '">' + '<span class="order-btn done"> 删除 </span>' + '</td>' +
                        '</tr>';
                }
            }
            
            return str;
        }
        return '';
    }

    /*添加*/
    $(document).on('click','#load-more',function(){
        window.location.href = 'topic.html';
    });

    $(document).on('click','#news-more',function(){
        window.location.href = 'news.html';
    });
    /*删除*/
    $(document).on('click','.order-btn.done',function(){
        var $this=$(this),
            $td=$this.closest('td'),
            $tr=$this.closest('tr'),
            id=$td.attr('data-id'),
            $tips=$('.global-tips'),
            $p=$tips.find('p');
        if(id[0]!=='a'){//删除话题
            var params={
                url:'deletetopic/'+id,
                type:'get',
                tokenFlag:true,
                sCallback:function(res) {
                    if(res.code.toString().indexOf('2')==0){
                        $p.text('操作成功');
                    }else{
                        $p.text('操作失败');
                    }
                    $tips.show().delay(1500).hide(0);
                },
                eCallback:function(){
                    $p.text('操作失败');
                    $tips.show().delay(1500).hide(0);
                }
            };
            window.base.getData(params);
        }
        else{//删除新闻
            var n = '';
            for(var i=1;i<id.length;i++){
                n+=id[i];
            }
            var params={
                url:'deletenews/'+n,
                type:'get',
                sCallback:function(res) {
                    if(res.code.toString().indexOf('2')==0){
                        $p.text('操作成功');
                    }else{
                        $p.text('操作失败');
                    }
                    $tips.show().delay(1500).hide(0);
                },
                eCallback:function(){
                    $p.text('操作失败');
                    $tips.show().delay(1500).hide(0);
                }
            };
            window.base.getData(params);
        }
    });

    /*退出*/
    $(document).on('click','#login-out',function(){
        window.base.deleteLocalStorage('token');
        window.location.href = 'login.html';
    });
});
