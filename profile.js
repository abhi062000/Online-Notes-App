// Ajax call to updateusername.php
$("#updateusernameForm").submit(function (event) {
    console.log("Username");
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updateusername.php",
        type: "POST",
        data: datatopost,
        success: function (data) {
            if (data) {
                $("#updateusernamemessages").html(data);
            } else {
                location.reload();
            }
        },
        error: function () {
            $("#updateusernamemessages").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

        }

    });

});


// Ajax call to updatepassword.php
$("#updatepasswordForm").submit(function (event) {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updatepassword.php",
        type: "POST",
        data: datatopost,
        success: function (data) {
            if (data) {
                $("#updatepasswordmessages").html(data);
            }
        },
        error: function () {
            $("#updatepasswordmessages").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

        }

    });

});

// Ajax call to updateemail.php
$("#updateemailForm").submit(function (event) {
    //prevent default php processing
    event.preventDefault();
    //collect user inputs
    var datatopost = $(this).serializeArray();
    //    console.log(datatopost);
    //send them to updateusername.php using AJAX
    $.ajax({
        url: "updateemail.php",
        type: "POST",
        data: datatopost,
        success: function (data) {
            if (data) {
                $("#updateemailmessages").html(data);
            }
        },
        error: function () {
            $("#updateemailmessages").html("<div class='alert alert-danger'>There was an error with the Ajax Call. Please try again later.</div>");

        }

    });

});