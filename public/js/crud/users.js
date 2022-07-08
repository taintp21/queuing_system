$(document).ready(function(){
    $(".addbtn").on('click', function(e){
        e.preventDefault();
        $("#name-error").html('');
        $("#username-error").html('');
        $("#phone-error").html('');
        $("#password-error").html('');
        $("#email-error").html('');
        $("#password_confirmation-error").html('');
        $.ajax({
            url: $("#addform").attr('action'),
            method: 'POST',
            data: $("#addform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                    });
                }
                else{
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html('');
                        $("#" + key).next().addClass('d-none');
                    });
                    $('#addform').trigger('reset');
                    Swal.fire({
                        icon: 'success',
                        title: 'Hoàn tất',
                        text: 'Thêm mới thành công!',
                    });
                }
            }
        });
    });
    $(".editbtn").on('click', function(e){
        e.preventDefault();
        $("#name-error").html('');
        $("#username-error").html('');
        $("#phone-error").html('');
        $("#password-error").html('');
        $("#email-error").html('');
        $("#password_confirmation-error").html('');
        $.ajax({
            url: $("#editform").attr('action'),
            method: "PUT",
            data: $("#editform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                    });
                }
                else{
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html('');
                        $("#" + key).next().addClass('d-none');
                    });
                    Swal.fire({
                        icon: 'success',
                        title: 'Hoàn tất',
                        text: 'Cập nhật thành công!',
                    });
                }
            }
        })
    });
});
