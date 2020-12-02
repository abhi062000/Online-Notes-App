// AJAX CALL FOR SIGNUP FORM    
// once form is submitted
// signup form
$("#signupForm").submit(function (event) {

    // prevent default php processing
    event.preventDefault();
    // collecting user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);

    // sending data to signup.php using ajax
    $.ajax({
        type: "POST",
        url: "signup.php",
        data: datatopost,
        success: function (data) {
            if (data) {
                $("#signupmessage").html(data);
            }
        },
        error: function () {
            $("#signupmessage").html("<div class='alert alert-danger'>Error in Ajax Call. Try again later.</div>");
        }
    });

});

// login form
$("#loginForm").submit(function (event) {
    console.log("Loginform");
    // prevent default php processing
    event.preventDefault();
    // collecting user inputs
    var datatopost = $(this).serializeArray();


    // sending data to signup.php using ajax
    $.ajax({
        type: "POST",
        url: "login.php",
        data: datatopost,
        success: function (data) {
            if (data == "success") {
                window.location = "mainpageloggedin.php";
            } else {
                $('#loginmessages').html(data);
            }
        },
        error: function () {
            $("#loginmessages").html("<div class='alert alert-danger'>Error in Ajax Call. Try again later.</div>");
        }
    });

});

// forgot password
$("#forgotPasswordForm").submit(function (event) {
    console.log("ForgotPasswordform");
    // prevent default php processing
    event.preventDefault();
    // collecting user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);


    // sending data to signup.php using ajax
    $.ajax({
        type: "POST",
        url: "forgotpassword.php",
        data: datatopost,
        success: function (data) {
            $("#forgotpasswordmessage").html(data);
        },
        error: function () {
            $("#forgotpasswordmessage").html("<div class='alert alert-danger'>Error in Ajax Call. Try again later.</div>");
        }
    });

});