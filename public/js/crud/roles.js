$(document).ready(function(){
    $("#all1").on('click', function(){
        var checkedState = this.checked;
        $(".group-1 .form-check :checkbox").each(function(){
            this.checked = checkedState;
        });
    });
    $("#all2").on('click', function(){
        var checkedState = this.checked;
        $(".group-2 .form-check :checkbox").each(function(){
            this.checked = checkedState;
        });
    });
    let token = $("meta[name='csrf-token']").attr("content");
    $(".addbtn").on('click',function(e){
        e.preventDefault();
        $("#role_name-error").html('');
        $("#role-error").html('');
        var checkboxes = [];
        $('input[name="role_delegation"]').each(function(){
            if($(this).is(":checked")){
                checkboxes.push($(this).val());
            }
        });
        checkboxes = checkboxes.toString();
        $.ajax({
            url: $("#addform").attr("action"),
            method: 'POST',
            data: {
                _token: token,
                role_name : $('input[name="role_name"]').val(),
                description : $('textarea[name="description"]').val(),
                role_delegation : checkboxes
            },
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
        $("#role_name-error").html('');
        $("#role-error").html('');
        var checkboxes = [];
        $('input[name="role_delegation"]').each(function(){
            if($(this).is(":checked")){
                checkboxes.push($(this).val());
            }
        });
        checkboxes = checkboxes.toString();
        $.ajax({
            url: $("#editform").attr("action"),
            method: "PUT",
            data: {
                _token: token,
                role_name : $('input[name="role_name"]').val(),
                description: $('textarea[name="description"]').val(),
                role_delegation: checkboxes
            },
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
        });
    });
});
