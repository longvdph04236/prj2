$(document).ready(function(e){
    $('.status').change(function(){
        var id = $(this).parent('form').attr('id');
        var stt = $(this).children(':selected').attr('value');
        $.ajax({
            url:  $(this).parent('form').attr('action'),
            data : {id:id,stt:stt},
            type: 'post',
            success : function (data) {
                if(data) {
                    alert('đổi thành công');
                }else {
                    alert('đổi không thành công');
                }
            }
        });
    });
});
