$(function() {
    $('.exit').on('click', function() {
            // alert(11)
            $('.exit_zhezhao').fadeIn(50)
            $('.exit_box').fadeIn(60)
        })
        // exit_box_qx
    $('.exit_box_qx').on('click', function() {
            $('.exit_box').hide()
            $('.exit_zhezhao').hide()

        })
        // exit_box_qd
    $('.exit_box_qd').on('click', function() {
        location.href = './m_login.html'

    })


})