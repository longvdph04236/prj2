$(document).ready(function () {
    $('#resend-link').click(function (e) {
        e.preventDefault();
        $.ajax({
            url: $(this).attr('href'),
            success: function(data){
                if(data) {
                    alert('Mã đã được gửi lại');
                } else {
                    console.log(data);
                }
            }
        });
    })
})