$(document).ready(function(){
    $(".addbtn").on("click", function(e){
        e.preventDefault();
        if(!$("#service").val()){
            $("#service-error").removeClass("d-none");
            $("#service-error").html("Vui lòng chọn dịch vụ.");
        }else{
            $("#service-error").addClass("d-none");
            $("#service-error").html('');
            $('#modal').modal("show");
        }
    });
    $("#addform").on('submit', function(e){
        e.preventDefault();
        $("#service-error").html('');
        $("#name-error").html('');
        $("#phone-error").html('');
        $("#email-error").html('');
        $.ajax({
            url: $("#addform").attr("action"),
            type: "POST",
            data: $("#addform").serialize(),
            processData : false,
            success: function(response){
                if(response.status == 400){
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html(val[0]);
                        $("#" + key).next().removeClass('d-none');
                    });
                }
                else if (response.status == 401){
                    $('#modal').modal("hide");
                    Swal.fire(
                        'Oops!',
                        response.error,
                        'error'
                    );
                }
                else{
                    $('#addform').trigger('reset');
                    $('#modal').modal("hide");
                    $(".swal2-popup.swal2-modal.swal2-show").addClass(".modify-swal2-popup");
                    $.each(response.errors, function(key, val){
                        $("#" + key).next().html('');
                        $("#" + key).next().addClass('d-none');
                    });
                    Swal.fire({
                        title: '<h2 class="fw-bold mt-4">Số thứ tự được cấp</h2><h3 class="mt-4 fw-bold color-1">'+ response.order +'</h3>',
                        html: 'DV: ' + response.service_name + ' <span class="fw-bold">(tại quầy số ' + response.service_id + ')</span>',
                        footer: '<p class="mb-3">Thời gian cấp: ' + response.created_at + '</p><p>Hạn sử dụng: ' + response.expired_date + '</p>',
                        showCloseButton: true,
                        showConfirmButton: false,
                        customClass: {
                            footer: 'modify-swal2-footer',
                            popup: 'modify-swal2-popup',
                          }
                    }).then(function(){
                        location.href = href + "/" + response.id;
                    });
                }
            },
        });
    });
});
