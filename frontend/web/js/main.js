$(document).ready(function () {
    $('#login-a-btn').click(function(){
        $('#loginModal .login-form-2').load( $('#loginModal .login-form-2').attr('data-content'));
    })

    $('button[name=cancel-button]').click(function(){
        window.location.reload();
    });

    $('.change-profile-pic').click(function(e){
        e.preventDefault();
        $('#user-newphoto').click();
    });

    function previewimg(input){
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic-container img').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('change',"#user-newphoto",function(){
        previewimg(this);
        //console.log($(this).val());
    });

    $('#newstadiumform-city').blur(function () {
        //console.log($(this).val());
        $.ajax({
            url: $('#city').data('href'),
            data: {n: $(this).val()},
            method: 'post',
            dataType: 'json',
            success: function(response){
                $('#district').empty();
                response.forEach(function(item,index){
                    e = '<option value="'+item+'">';
                    $('#district').append(e);
                })
            }
        })
    })
})
