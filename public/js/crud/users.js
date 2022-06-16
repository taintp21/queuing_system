$(document).ready(function(){
    $("#addform").on('submit', function(e){
        e.preventDefault();
        $("#name-error").html('');
        $("#username-error").html('');
        $("#phone-error").html('');
        $("#password-error").html('');
        $("#email-error").html('');
        $("#password_confirmation-error").html('');
        $.ajax({
            url: $(this).attr("action"),
            method: $(this).attr("method"),
            data: $("#addform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                    });
                }
                else{
                    $(".content div span").html('');
                    $(".content div span").addClass('d-none');
                    $('#addform')[0].reset();
                    Swal.fire(
                        'Hoàn tất!',
                        'Thêm thành công!',
                        'success'
                    );
                }
            }
        });
    });
    $("#editform").on('submit', function(e){
        e.preventDefault();
        $("#name-error").html('');
        $("#username-error").html('');
        $("#phone-error").html('');
        $("#password-error").html('');
        $("#email-error").html('');
        $("#password_confirmation-error").html('');
        $.ajax({
            url: $(this).attr("action"),
            method: "PUT",
            data: $("#editform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                    });
                }else{
                    $(".content div span").html('');
                    $(".content div span").addClass('d-none');
                    Swal.fire(
                        'Hoàn tất!',
                        'Cập nhật thành công!',
                        'success'
                    );
                }
            }
        })
    });
});
