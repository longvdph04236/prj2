$(document).ready(function () {
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-left",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $('#login-a-btn,.login-a-btn').click(function(){
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
                //console.log($(input).parent().next().children('img.img-display'));
                $(input).parent().next().next().attr('src', e.target.result);
                $(input).parent().parent().next().next().attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $(document).on('change',".img-input[type=file]",function(){

        previewimg(this);
        //console.log($(this).val());
        if($(this).val() != ''){
            console.log($(this).parent().parent().next().next());
            $(this).parent().parent().next().next().next().attr("value","");
            $(this).parent().parent().addClass("has-img");
        }

        if($(".product-img-list .img-holder:last-of-type").hasClass('has-img') == true){
            var grp = "<div class='img-holder'><div class='form-group field-newstadiumform-photos'><input type='hidden' name='NewStadiumForm[photos][]' value=''><input type='file' id='products-imgfiles' class='img-input' name='NewStadiumForm[photos][]' accept='image/*'><div class='help-block'></div></div><div class='overlay-grp-btn'><button type='button' class='add-img'><i class='fa fa-plus'></i></button><div class='edit-grp-btn'><button type='button' class='edit-img'><i class='fa fa-pencil'></i></button><button type='button' class='del-img'><i class='fa fa-times'></i></button></div></div><img src='' class='img-display' alt=''><input type='hidden' class='old-img' name='oldImg[]'></div>";
            $(".product-img-list").append(grp);
        }
    });

    if($(".product-img-list .img-holder:last-of-type").hasClass('has-img') == true || $(".product-img-list").children().length == 0){
        var grp = "<div class='img-holder'><div class='form-group field-newstadiumform-photos'><input type='hidden' name='NewStadiumForm[photos][]' value=''><input type='file' id='products-imgfiles' class='img-input' name='NewStadiumForm[photos][]' accept='image/*'><div class='help-block'></div></div><div class='overlay-grp-btn'><button type='button' class='add-img'><i class='fa fa-plus'></i></button><div class='edit-grp-btn'><button type='button' class='edit-img'><i class='fa fa-pencil'></i></button><button type='button' class='del-img'><i class='fa fa-times'></i></button></div></div><img src='' class='img-display' alt=''><input type='hidden' class='old-img' name='oldImg[]'></div>";
        $(".product-img-list").append(grp);
    }

    $(document).on('click','button.add-img',function(e){
        e.preventDefault();
        $(this).parent().prev().children('input.img-input').click();

    });

    $(document).on('click','button.edit-img',function(e){
        e.preventDefault();
        $(this).parent().parent().prev().find('input.img-input').click();

    });

    $(document).on('click','button.del-img',function(e){
        e.preventDefault();
        $(this).parents('.img-holder').remove();
    });

    $(document).on('change',"#user-newphoto",function(){
        previewimg(this);
        //console.log($(this).val());
    });

    $('#newstadiumform-city,#filterstadiumform-city,#fclist-city,#findbytimeform-city,#findbynameform-city,#filterfcform-city').blur(function () {
        //console.log($(this).val());
        var s = $(this);
        $.ajax({
            url: $('#city').data('href'),
            data: {n: $(this).val()},
            method: 'post',
            dataType: 'json',
            success: function(response){

                if(response != false){
                    //console.log(response);
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
                if(res != 'false'){
                    toastr.success('Cập nhật thành công');
                    //console.log(res);
                    btn.parent('td').prev().prev().html('<span class="label label-success">Thành công</span>');
                    btn.parents('tr').find('.code').text(res);
                    btn.remove();
                } else {
                    toastr.info('Yêu cầu đặt sân đã bị hủy');
                    btn.parent('td').prev().prev().html('<span class="label label-danger">Hủy</span>');
                    btn.parents('tr').find('.code').text('Hủy');
                    btn.remove();
                }
            }
        })
    })

    if(document.location.hostname == 'localhost'){
        url = document.location.origin + '/project2';

    } else {
        url = document.location.origin;

    }

    // notification update
    var oldData = null;
    var newData;
    var diff;
    // schedule update
    var rendered = null;
    var newSch;
    var postRender;
        /*$.each(a, function( index, value ) {
         b = $.grep(b, function(v) {
         return v != value;
         });
         });*/
    setInterval(function () {

        $.ajax({
            url: url + '/thong-bao/update-noti-count',
            dataType: 'json',
            success: function(data){
                if(data != false){
                    newData = data[0];
                    //console.log(data);
                    $('.li-notify span.badge').text(newData);
                    if(oldData != null){
                        diff = newData-oldData
                        if(diff > 0){
                            toastr.info('Bạn có '+diff+' thông báo đặt sân mới');
                        } else if(data[1] == 'member' && diff < 0){
                            toastr.info(Math.abs(diff)+' yêu cầu đặt sân được cập nhật');
                        }
                    }
                    oldData = newData;
                }
            }
        });

        if(document.location.href.match("^"+url+"/san-bong/chi-tiet/")){
            var href = $('#all-fields .nav-tabs[role=tablist] li.active a').attr('href');
            var id = href.replace('#field-','');


            if(Array.isArray(rendered)){
                postRender = rendered[id];
            } else {
                postRender = rendered;
            }


            $.ajax({
                url: url + '/san-bong/update-lich',
                dataType: 'json',
                method: 'post',
                data: {rendered:postRender, id:id},
                success: function (data) {
                    newSch = new Array();
                    newSch = data[1];
                    if(!rendered || (Array.isArray(rendered) && !rendered[id])){
                        if(!Array.isArray(rendered)){
                            rendered = new Array();
                        }
                        rendered[id] = new Array();
                    }

                    $.each(newSch, function (i, v) {
                        if(data[0] == 'manager'){
                            e = '<p><b>'+v['name']+'</b></p><span>Mã: <b class="text-success">'+v['tracking_code']+'</b></span><a href="/project2/san-bong/xoa-lich/'+v['id']+'">Xóa</a>';
                        } else {
                            e = '<p><b>'+v['name']+'</b></p><span>Mã: <b class="text-success">'+v['tracking_code']+'</b></span>';
                        }
                        $("div"+href+".tab-pane table.table td[data-date='"+v['date']+"'][data-time='"+v['time_range']+"']").html(e);
                        $("div"+href+".tab-pane table.table td[data-date='"+v['date']+"'][data-time='"+v['time_range']+"']").addClass('bg-success');
                        $("div"+href+".tab-pane table.table td[data-date='"+v['date']+"'][data-time='"+v['time_range']+"']").attr('id',v['id'])
                        rendered[id].push(v['id']);
                        //console.log(v['name']);
                    });
                    //console.log(rendered[id]);
                }
            });

            $.ajax({
                url: url + '/san-bong/update-lich-2',
                dataType: 'json',
                method: 'post',
                data: {rendered:postRender, id:id},
                success: function (data) {
                    newSch = data[0];
                    //console.log(rendered);
                    if(Array.isArray(rendered) && rendered[id]){
                        $.each(newSch,function (i, v) {
                            rendered.splice($.inArray(v ,rendered),1);
                            //console.log('trong if');
                            if(data[1] == 'true'){
                                e = '<p><small><i>Sân trống</i></small></p><a href="" class="login-a-btn" data-toggle="modal" data-target="#loginModal"><span class="text-danger text-uppercase">Đặt sân</span></a>';
                            } else {
                                e = '<p><small><i>Sân trống</i></small></p><a href="" class="book-a-btn" data-toggle="modal" data-target="#bookModal"><span class="text-danger text-uppercase">Đặt sân</span></a>';
                            }
                            $("td#"+v).html(e);
                            $("td#"+v).removeClass('bg-success');
                            $("td#"+v).removeAttr('id');
                        });
                    }
                    //console.log(rendered);
                }
            });
        }

    },500)

})


$(window).on("load",function(){
    $('.comment-list').mCustomScrollbar({
        scrollButtons:{enable:true},
        theme:"dark-3",
    });
});