$(function() {

    var index = 0;
    var len = $('.items').length;
    var editIndex=[];
    var layedit='';

    $('.total_ti').html(len)

    function caclPrecent(){
        var a = $('form').serializeArray();
        var $radio = $('form input[type=radio],input[type=checkbox],textarea');
        var temp = {};
        $.each($radio, function () {
            if (!temp.hasOwnProperty(this.name)) {
                if ($("input[name='" + this.name + "']:checked").length == 0) {
                    temp[this.name] = "";
                    a.push({name: this.name, value:0});
                }
            }
        });
        var i=0;
        var filterArr=[],temp1={};
        for (var k=0;k<a.length;k++){
            if (!temp1.hasOwnProperty(a[k].name)) {
                temp1[a[k].name] = a[k].value;
                filterArr.push({name:a[k].name,value:a[k].value})
            }
        }
        for (var j=0;j<filterArr.length;j++){
            if(layedit&&indexLayEdit){
                var v=layedit.getContent(indexLayEdit);
                if(filterArr[j]['name']=='zuopin'){
                    filterArr[j]['value']=v;
                }
            }
            
            if (filterArr[j]['value']!=0&&filterArr[j]['value']!='点击输入答案'){
                tmpId = $("[name='"+filterArr[j]['name']+"']").attr("data-id")
                $(".em"+tmpId).addClass("current_dati");
                i++;
            }
        }
        var precent=Math.ceil(i/filterArr.length*100);
        $('.layui-progress-bar').attr('lay-percent',precent+"%")
        $('.layui-progress-bar').css('width',precent+"%")
        $('.layui-progress-text').text(precent+"%")
        if (precent == 100) {
            return true;
        } else {
            return false;
        }
    }

    caclPrecent();
    $('.next_btn').on('click', function() {
        for (var i = 0; i < editIndex.length; i++) {
            layedit.sync(editIndex[i].value);

            var tmpId = $("#"+editIndex[i].key).attr("data-id");
            var content = $("#"+editIndex[i].key).val();
            if(content != '') {
                $(".em"+tmpId).addClass("current_dati");
            } else {
                $(".em"+tmpId).removeClass("current_dati");
            }
        }

        index = index + 1;
        demo(index)
        caclPrecent();

    })

        // 返回上一题
    $('.prev_btn').on('click', function() {
        for (var i = 0; i < editIndex.length; i++) {
            layedit.sync(editIndex[i].value);

            var tmpId = $("#"+editIndex[i].key).attr("data-id");
            var content = $("#"+editIndex[i].key).val();
            if(content != '') {
                $(".em"+tmpId).addClass("current_dati");
            } else {
                $(".em"+tmpId).removeClass("current_dati");
            }
        }
        index = index - 1;
        demo(index)
        caclPrecent();

    })


    // 事件代理

    $('.tijiao_btn').on('click', function() {
        var flag = caclPrecent();
        var nowefttime = $("#nowefttime").val()
        if (nowefttime < 1000*60*15) {
            //小于15分钟,不得交卷
            $('.zhezhao').show()
            $("#timeExec2").show();
        } else {
            $('.zhezhao').show()
            if (!flag) {
                $("#timeExec3").show();
            } else {
                $("#timeExec4").show();
            }
            
        }
        

    })


    // $('.test_jiaojuan_yes').on('click', function() {
    //     $('.tijiao').click();
    //     location.href = './index_more.html';
    // })


    //获的焦点 文字清除
    $('.tiankong_ipt').on('focus', function() {

        if ($(this).val() === '点击输入答案') {
            $(this).val('')
        }
    });

    //失去焦点 文字清除
    $('.tiankong_ipt').on('blur', function() {

        if ($(this).val() === '') {

            $(this).val('点击输入答案')
            $(this).css('color', '#999')
        } else {
            $(this).css('color', '#333')
        }
    });

    

    //富文本
    var layedit;
    var indexLayEdit;
    layui.use('layedit', function() {
        layedit = layui.layedit;

        layedit.set({ 
            uploadImage: { 
                url: '/index.php?ctl=index&act=upload', //图片上传接口url 
                type: 'post' //默认post 
            } 
        }); 

        $(".jisuan").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 350, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        });

        $(".wenda").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 350, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        });

        $(".jianda").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 350, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        });


        $(".zuopin").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 350, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        });

    //     indexLayEdit=layedit.build('demo1', {
    //         // height: 350,
    //         tool: ['image'],
    //     }); //建立编辑器

    //     var active={
    //         content:function(){
    //             console.log(layedit.getContent(indexLayEdit))
    //         },
    //         text:function(){
    //             console.log(layedit.getText(indexLayEdit))
    //         }
    //     }

    });

    //取消
    $('.test_jiaojuan_no').on('click', function() {
        $('.zhezhao').hide()
        $('.test_jiaojuan').hide()
    })

    //确定
    
    $('.test_jiaojuan_yes').on('click', function() {

        $('.datika_btn_hidden').click();
        // caclPrecent()
        
        return false;
        
        // 
        // 
        // $.post("?ctl=index&act=testPost", $('#mobilePostForm').serialize(),
        //     function(data){
        //         console.log(data);
        //         if(data.res == 'failed'){
        //             dtAlert({ message:data.msg,title:'<i class="glyphicon glyphicon-remove"></i>',style:'primary' });
        //             return false;
        //         }else{
        //             dtAlert({ message:'提交成功,正在跳转',title:'<i class="glyphicon glyphicon-ok"></i>',style:'primary',callback:'window.location.href="?/ctl=index";' });
        //         }
        // }, "json");

    })

    
    //顶部返回按钮效果是提交试卷
    $('.back').on('click', function() {
        $('.tijiao_btn').click()
    })

});
function demo(index) {
    var len = $('.items').length;
    if (index >= len - 1) {
        index = $('.items').length - 1;
        $('.end').html(len)
        $('.items').eq(index).show().siblings('.items').hide()
        //显示
        $('.next_btn').hide()
        $('.tijiao_btn').show();
    } else {
        $('.items').eq(index).show().siblings('.items').hide()
        $('.end').html(index + 1)
        $('.next_btn').show()
        $('.tijiao_btn').hide()
    }

    
    // 判断是否有对应的类
    // 
    if($('.items').eq(index).hasClass('items_radio')) {
        $('.radio_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_duoxuan')) {
        $('.check_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_panduan')) {
        $('.panduan_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_tiankong')) {
        $('.tiankong_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_jisuan')) { 
        $('.jisuan_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_wenda')) {
        $('.wenda_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_jianda')) {
        $('.jianda_ti_title').show().siblings('.ti_title').hide()
    }else if($('.items').eq(index).hasClass('items_zuopin')) {
        $('.zuopin_ti_title').show().siblings('.ti_title').hide()
    }
}