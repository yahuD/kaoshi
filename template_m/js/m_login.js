$(function() {
    //    请填写完整信息后登录 

    $('.no_queding').on('click', function() {
        $('.frm_info_no').fadeOut(100)

    });
    //学员/身份证输入有误
    $('.no_queding2').on('click', function() {
        $('.frm_info_no2').fadeOut(100)

    });
    //密码输入有误,请重新输入
    $('.no_queding3').on('click', function() {
        $('.frm_info_pwderr').fadeOut(100)

    });

})