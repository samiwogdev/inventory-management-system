$(document).ready(function () {
$("#currentPassword").keyup(function () {
    var currentPassword = $("#currentPassword").val();
    // alert(currentPassword);
    $.ajax({
        // headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "post",
        url: "/admin/check-current-password",
        data: {currentPassword: currentPassword},
        success: function (response) {
            if(response = 'true'){
                $('#currentPassordMsg').html("<span style='color: green;'>Current Password is Correct</span>");
            }else{
                $('#currentPassordMsg').html("<span style='color: red;'>Current Password is Incorrect</span>");
            }
        },error:function(){
            alert('Error');
        }
    });

});
});
