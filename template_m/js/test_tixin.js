$(function() {
    // 
    $('.begin_test').on('click', function() {
        $('.zhezhao').fadeIn(50)
        $('.test_time_no').fadeIn(100)
    })

    // 点击确定遮罩跟弹出层隐藏
    $('.test_time_no_btn').on('click', function() {
        $('.zhezhao').fadeOut(50)
        $('.test_time_no').fadeOut(50)
    })

    // 考试icon点击去往考试列表页面
    $('.ks_icon').on('click', function() {
        location.href = './index_more.html'
    })

})