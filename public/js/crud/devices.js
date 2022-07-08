$(document).ready(function(){
    $(".addbtn").on('click', function(e){
        e.preventDefault();
        $("#device_code-error").html('');
        $("#device_type-error").html('');
        $("#device_name-error").html('');
        $("#username-error").html('');
        $("#ip_address-error").html('');
        $("#password-error").html('');
        $("#description-error").html('');
        $.ajax({
            url: $("#addform").attr("action"),
            method: "POST",
            data: $("#addform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                        if(key == 'description'){
                            $("#description-error").append(val);
                        }
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
        $("#device_code-error").html('');
        $("#device_type-error").html('');
        $("#device_name-error").html('');
        $("#username-error").html('');
        $("#ip_address-error").html('');
        $("#password-error").html('');
        $("#description-error").html('');
        $.ajax({
            url: $("#editform").attr("action"),
            type: "PUT",
            data: $("#editform").serialize(),
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                        if(key == 'description'){
                            $("#description-error").append(val);
                        }
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
            },
        });
    });
});
