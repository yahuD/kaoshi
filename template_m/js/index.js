$(function() {
    //当前按钮和历史按钮切换
    $('.index_btn').on('click', function() {
        $(this).addClass('current').siblings('.index_btn').removeClass('current')
    });
    // 切换展示
    $('.current_test').on('click', function() {
            $('.current_list1').show()
            $('.history_list').hide()
                // 标题显示隐藏
            $('.cur_test_info').show()
            $('.history_test_info').hide()

        })
        //hositry_test
    $('.hositry_test').on('click', function() {
            $('.current_list').hide()
            $('.current_list1').hide()
            $('.history_list').show()
                // 标题显示隐藏
            $('.cur_test_info').hide()
            $('.history_test_info').show()
        })
        //

    //考试时间未到 遮罩层对应的弹出层

    $('.begin_test_btn').on('click', function() {
        $('.zhezhao').fadeIn(50)
        $('.test_time_no').fadeIn(100)
    })

    // 点击确定遮罩跟弹出层隐藏
    $('.test_time_no_btn').on('click', function() {
        $('.zhezhao').fadeOut(50)
        $('.test_time_no').fadeOut(50)
    })

    // 考试时间已经结束
    $('.begin_test1').on('click', function() {
        // alert(11)
        $('.zhezhao').show()
        $('.test_time_end').show()
    })
    $('.test_time_end_btn').on('click', function() {
        $('.zhezhao').hide()
        $('.test_time_end').hide()
    })

})