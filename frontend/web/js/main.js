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

    $('#newstadiumform-city,#filterstadiumform-city,#fclist-city').blur(function () {
        //console.log($(this).val());
        var s = $(this);
        $.ajax({
            url: $('#city').data('href'),
            data: {n: $(this).val()},
            method: 'post',
            dataType: 'json',
            success: function(response){

                if(response != false){
                    console.log(response);
                    s.parents('form').find('.district').empty();
                    response.forEach(function(item,index){
                        e = '<option value="'+item+'">';
                        s.parents('form').find('.district').append(e);
                    })
                }
            }
        })
    });

    $('table a.book-a-btn').click(function () {
        var d = $(this).parent().data('date');
        var t = $(this).parent().data('time');
        var fid = $(this).parents('.tab-pane.active').attr('id');
        var id = fid.substr(6);
        var type = $(this).parents('table').data('type');

        $('#schedule-time_range option[value="'+t+'"]').attr('selected','selected');
        $('#schedule-date').val(d);
        $('#schedule-field_id').val(id);
        $('#schedule-field_type input[value='+ type +']').prop('checked','checked');
    })
    
    $('#book-a-btn').click(function () {
        $('#schedule-time_range option[selected=selected]').removeAttr('selected');
        $('#w6')[0].reset();
        $('#schedule-field_type input[type=radio]').prop('checked', false);
    });

    $('.accept-book').click(function () {
        var v = $(this).data('id');
        var btn = $(this);
        $.ajax({
            url: $(this).data('url'),
            data: {v:v},
            method: 'post',
            success: function (res) {
                toastr.success('Cập nhật thành công');
                console.log(res);
                btn.parents('tr').find('.code').text(res);
                btn.remove();
                window.location.reload();
            }
        })
    })
    
})


$(window).on("load",function(){
    $('.comment-list').mCustomScrollbar({
        scrollButtons:{enable:true},
        theme:"dark-3",
    });
});
