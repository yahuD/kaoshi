$(function() {

    
    $('.datika_btn').on('click', function() {
        caclPrecent()
        $('.zhezhao').show()
        $('.test_jiaojuan').show()
    })

    

    // 答题卡区域的点击跳转
    // var len = $('.rad_ka_ul li').length
    // console.log(len)

    // $('.rad_ka_ul li').on('click', function() {
    //     console.log($(this).index())
    // })

    $('#datikaShow').on('click', function() {

        $('.datika_Box').show()

    })

    // 关闭按钮
    $('.datika_close').on('click', function() {
        $('.datika_Box').fadeOut(100)
    })


})