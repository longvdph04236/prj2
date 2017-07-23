$(document).ready(function () {
    $('#login-a-btn').click(function(){
        $('#loginModal .login-form-2').load( $('#loginModal .login-form-2').attr('data-content'));
    })
})