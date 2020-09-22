$(function() {
    $("#timeExec1").hide();
    $("#timeExec2").hide();
    $("#timeExec3").hide();
    $("#timeExec4").hide();
    var precent=0;
    var editIndex=[];
    var layedit='';
    //表单字体变小
    var font = 14;
    $('#descFont').on('click', function() {
            $('.frm_box').css('fontSize', --font)

        })
        //表单字体变大

    $('#addFont').on('click', function() {
            if (font > 18) {
                font = 14
            }
            $('.frm_box').css('fontSize', ++font)


        })

    //答题卡定位题目
    $('.rad_answer').on('click', 'li', function() {
        var $this = $(this)
        var mIdx = $this.parents('.rad_answer').index('.rad_answer')
        var sIdx = $this.index();
        var sIdx = $('.rad_answer li').index(this)
        var $item = $('.frm_box').find('.items').eq(sIdx).find('label').eq(0)
        if ($item.length > 0) {
            var offset = 20
            var top = $item.offset().top - $('.header_huan').outerHeight() - offset
            $('html, body').animate({
                scrollTop: top + 'px'
            })
        }
    })

    //试卷提交
    $("#shijuan_sub").click(function(){
        for (var i = 0; i < editIndex.length; i++) {
            layedit.sync(editIndex[i].value);

            var tmpId = $("#"+editIndex[i].key).attr("data-id");
            var content = $("#"+editIndex[i].key).val();
            if(content != '') {
                $(".em"+tmpId).addClass("answer_current");
            } else {
                $(".em"+tmpId).removeClass("answer_current");
            }
        }
        var flag = caclPrecent();
        var nowefttime = $("#nowefttime").val()
        if (nowefttime < 1000*60*15) {
            //小于15分钟,不得交卷
            $(".body_zhezhao").show();
            $("#timeExec2").show();
        } else {
            
            if (!flag) {
                $(".body_zhezhao").show();
                $("#timeExec3").show();
            } else {
                $(".body_zhezhao").show();
                $("#timeExec4").show();
            }
            
        }
        

        
    })



    //输入框变成蓝色
    $('.tiankong_ipt').on('mouseenter', function() {
            $(this).addClass('border_blue')
        })
        // 
    $('.tiankong_ipt').on('mouseleave', function() {
        $(this).removeClass('border_blue')
    })

    //进度条
    function caclPrecent(){
        var formData = getFromData();
        i = 0
        for (let index = 0; index < formData.length; index++) {
            const element = formData[index];
            i += element.length;
        }
        var total=$('.process_bottom').attr('data-id');
        precent=Math.ceil(i/total*100);
        $("#progress").text(i);
        $('.layui-progress-bar').css('width',precent+"%")
        $('.layui-progress-text').text(precent+"%")
        if (precent == 100) {
            return true;
        } else {
            return false;
        }
    }

    //填空题 
    $(".fill").on('input', function() {
        caclPrecent()
        var tmpId = $(this).attr("data-id");
        flag = false;
        $(".fill"+tmpId).each(function(){
            if ($(this).val() != '' && !flag) {
                flag = true;
            }
        });
        if(flag) {
            $(".em"+tmpId).addClass("answer_current");
        } else {
            $(".em"+tmpId).removeClass("answer_current");
        }
    });

    //单选题
    $('.rad_lm').on('change', function() {
        caclPrecent()
        var tmpId = $(this).attr("data-id");
        $(".em"+tmpId).addClass("answer_current");
        $(this).parent('.items').children('span').css('color', '#000')
        $(this).siblings('span').css('color', '#0b80b9')
    })

    //判断题
    $('.binary').on('change', function() {
        caclPrecent()
        var tmpId = $(this).attr("data-id");
        $(".em"+tmpId).addClass("answer_current");
        $(this).parent('.cur_radColor').find("span").css('color', '#000')
        $(this).next('span:eq(0)').css('color', '#0b80b9')
    })

    //多选题
    $("input[type='checkbox']").on('change', function() {
        caclPrecent()
        var tmpId = $(this).attr("data-id");
        if($(this).is(":checked")) {
            $(this).siblings('span').css('color', '#0b80b9')
        } else {
            $(this).siblings('span').css('color', '#000')
        }
        if($(".duoxuan"+tmpId+":checked").length > 0) {
            $(".em"+tmpId).addClass("answer_current");
        } else {
            $(".em"+tmpId).removeClass("answer_current");
        } 
    })



    layui.use(['layer','layedit', 'form','jquery'],function() { 

        var form = layui.form, layer = layui.layer; 
        layedit = layui.layedit; 


        layedit.set({ 
            uploadImage: { 
                url: '/index.php?ctl=index&act=upload', //图片上传接口url 
                type: 'post' //默认post 
            } 
        });
        //简答题 
        $(".jisuan").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 480, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        })

        $(".zuopin").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 480, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        })

        $(".jianda").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 480, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        })

        $(".wenda").each(function(){
            tmpIdx = $(this).attr("name")
            
            editIdx = layedit.build(tmpIdx, { 
                height: 480, //设置编辑器高度 
                tool: ['image']
            }); //建立编辑器
            editIndex.push({'key':tmpIdx,'value':editIdx})
        })

    })

})

