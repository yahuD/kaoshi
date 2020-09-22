$(function() {


    $('.user').on('click', function() {
            $('.shezhi').slideDown(100)



        })
        // 鼠标离开

    $('.user').on('mouseleave', function() {
        $('.shezhi').slideUp(100)



    })

    // 当前考试和历史考试切换样式

    $('.tab_btn .btn').on('click', function() {
        $(this).addClass('btn_cur').siblings('.btn').removeClass('btn_cur')

    })

    // 当前
    $('.btn_c').on('click', function() {
            $('.items_current').show()
            $('.items_history').hide()
            $('.items_jinxing').hide()
            $('.items_end').hide()

        })
        //历史
    $('.btn_h').on('click', function() {
        $('.items_current').hide()
        $('.items_history').show()
        $('.items_jinxing').hide()
        $('.items_end').hide()
    })

    // close

    $('.close').on('click', function() {
        $('.fix_user').fadeOut(100)
        $('.body_zhezhao').fadeOut(50)
    })

    //点击个人信息
    $('.showUser').on('click', function() {
        $('.body_zhezhao').fadeIn(50)
        $('.fix_user').fadeIn(100)
    })

    // 退出功能

    $('#btnLogOut').on('click', function() {
        $('.body_zhezhao').fadeIn(50)
        $('.shezhi_logout').fadeIn(100)
    })


    //取消点击
    $('.quxiao').on('click', function() {
            $('.shezhi_logout').fadeOut(100)
            $('.body_zhezhao').fadeOut(50)
        })
        //绑定确定事件
    $('.queding').on('click', function() {
        location.href = './login.html'
    })



    // 考试已结束 有疑问请联系班主任 close1
    $('.close1').on('click', function() {
            $('.end_text').fadeOut(100)

        })
        // 考试时间未到，请耐心等待
    $('.close2').on('click', function() {
        $('.text_notime').fadeOut(100)

    })


})