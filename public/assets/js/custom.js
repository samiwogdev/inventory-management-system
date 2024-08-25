$(document).ready(function () {
    $("#currentPassword").keyup(function () {
        var currentPassword = $("#currentPassword").val();
        
        $.ajax({
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            type: "post",
            url: "/admin/check-current-password",
            data: {currentPassword: currentPassword},
            success: function (response) {
                if(response === 'true'){  // Changed '=' to '===' for comparison
                    $('#currentPassordMsg').html("<span style='color: green;'>Current Password is Correct</span>");
                } else {
                    $('#currentPassordMsg').html("<span style='color: red;'>Current Password is Incorrect</span>");
                }
            },
            error: function (xhr, status, error) {
                // Log error details to the console
                console.error('AJAX error:', status, error);
                console.error('Response text:', xhr.responseText);

                // Optionally, show a user-friendly error message
                alert('An error occurred while checking the password. Please try again.');
            }
        });

    });
});
