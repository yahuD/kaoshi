//
//
$(function() {

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
        // //单选按钮字体设置颜色
    $('.rad_lm').on('change', function() {


        $(this).siblings('span').css('color', '#0b80b9')


        $(this).parent('.cur_radColor').siblings('.cur_radColor').children('span').css('color', '#000')



    })

    //多选按钮字体设置颜色
    $('.checkbox_lm').on('change', function() {

        $(this).siblings('span').toggleClass('toggleColor')




    })


    // 考试时间到关闭
    $('.close3').on('click', function() {
        $('.text_dao').fadeOut(100)
    })



    // 考试开始15分钟后才能交卷end
    $('.close_fifty').on('click', function() {
        $('.fify_text').fadeOut(100)

    })


    //有试题未完成，是否现在交卷？
    $('.quxiao_tiku').on('click', function() {
            $('.body_zhezhao').fadeOut(50)
            $('.shezhi_logout1').fadeOut(100)
        })
        // 
    $('.queding_tiku').on('click', function() {

        $('.form_bottom').click()

        location.href = './index.html'

    })





    function saveReport() { 
        // jquery 表单提交 
        caclPrecent()
        $("#myForm").ajaxSubmit(function(message) { 
            console.log(message)
        // 对于表单提交成功后处理，message为提交页面saveReport.htm的返回内容 
        }); 
        return false; // 必须返回false，否则表单会自己再做一次提交操作，并且页面跳转 
    }
    //表单提交事件
    $('#shijuan_sub').on('click', function() {
        caclPrecent()
        $("#myForm").ajaxSubmit(function(message) { 
            console.log(message)
        // 对于表单提交成功后处理，message为提交页面saveReport.htm的返回内容 
        }); 
        return false;
    //     $('.body_zhezhao').show()
    //     $('.shezhi_logout1').fadeIn(100)
    })


    //是否现在交卷
    $('.quxiao_now').on('click', function() {

        $('.now_jiaojuan').fadeOut(100)
        $('.body_zhezhao').hide()

    })

    $('.queding_now').on('click', function() {

        $('.form_bottom').click()
        location.href = './index.html'

    })

    //输入框变成蓝色
    $('.tiankong_ipt').on('mouseenter', function() {
            $(this).addClass('border_blue')
        })
        // 
    $('.tiankong_ipt').on('mouseleave', function() {
        $(this).removeClass('border_blue')
    })

    function cacluTotalFen(){
        var totalFen=0;
        var fenArr1=$(".calcuFen"),fenArr2=$('.fill')
        for(var i=0;i<fenArr1.length;i++){
            totalFen+=Number($(fenArr1[i]).attr('data-fen'))
        }
        for(var i=0;i<fenArr2.length;i++){
            totalFen+=Number(fenArr2[i].value)
        }
        $(".process_bottom").text(totalFen)
    }   
    cacluTotalFen()
    //  $(".fill").bind('input focus', function(e) {
    //     var datas=e.currentTarget.dataset;
    //     if(Number(datas.score)<Number(e.currentTarget.value)){
    //         alert('分值大于题目的总分值')
    //         return;
    //     }
    //     cacluTotalFen()
    // });

    $(".fill").bind('input blur', function(e) {
        var datas=e.currentTarget.dataset;
        if(Number(datas.score)<Number(e.currentTarget.value)){
            // alert('分值大于题目的总分值')
            return;
        }
        cacluTotalFen()
    });

    // 富文本编辑器

    layui.use('layedit', function() {
        var layedit = layui.layedit;

        layedit.build('demo', {
            height: 350,
            tool: ['image'],
        }); //建立编辑器



    });

    // 点击答题卡题跳转到对应题目


    // 点击 答题卡 题目定位
    $('.rad_answer').on('click', 'li', function() {
            var $this = $(this)
            var mIdx = $this.parents('.rad_answer').index('.rad_answer')
            var sIdx = $this.index();
            var $item = $('.frm_box').find('.items').eq(mIdx).find('label').eq(sIdx)
            if ($item.length > 0) {
                var offset = 20
                var top = $item.offset().top - $('.header_huan').outerHeight() - offset
                $('html, body').animate({
                    scrollTop: top + 'px'
                })
            }
        })
        // 修改图片title属性layui-icon











})