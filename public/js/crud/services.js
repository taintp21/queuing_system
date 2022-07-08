$(document).ready(function(){
    $("#increase_number").on('click', function(){
        if( $('#increase_number').is(':checked')) $('input[name="number_from"], input[name="number_to"]').prop("disabled", false);
        else $('input[name="number_from"], input[name="number_to"]').prop("disabled", true);
    });
    $("#prefix").on('click', function(){
        if($("#prefix").is(':checked')) $('input[name="prefix"]').prop("disabled", false);
        else $('input[name="prefix"]').prop("disabled", true);
    });

    $("#surfix").on('click', function(){
        if($("#surfix").is(':checked')) $('input[name="surfix"]').prop("disabled", false);
        else $('input[name="surfix"]').prop("disabled", true);
    });

    $(".addbtn").on('click', function(e){
        e.preventDefault();
        $("#service_code-error").html('');
        $("#service_name-error").html('');
        $.ajax({
            url: $("#addform").attr("action"),
            method: "POST",
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
        $("#service_code-error").html('');
        $("#service_name-error").html('');
        $.ajax({
            url: $("#editform").attr("action"),
            type: "PUT",
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
            },
        });
    });
});
