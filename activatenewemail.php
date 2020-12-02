<?php
//The user is re-directed to this file after clicking the link received by email and aiming at proving they own the new email address
//link contains three GET parameters: email, new email and activation key
session_start();
include('connection.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New Email activation</title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        h1 {
            color: purple;
        }

        .contactForm {
            border: 1px solid #7c73f6;
            margin-top: 50px;
            border-radius: 15px;
        }
    </style>

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-offset-1 col-sm-10 contactForm">
                <h1>Email Activation</h1>
                <?php
                //If email, new email or activation key is missing show an error
                if (!isset($_GET['email']) || !isset($_GET['newemail']) || !isset($_GET['key'])) {
                    echo '<div class="alert alert-danger">There was an error. Please click on the link you received by email.</div>';
                    exit;
                }
                //else
                //Store them in three variables
                $email = $_GET['email'];
                $newemail = $_GET['newemail'];
                $key = $_GET['key'];
                //Prepare variables for the query
                $email = mysqli_real_escape_string($link, $email);
                $newemail = mysqli_real_escape_string($link, $newemail);
                $key = mysqli_real_escape_string($link, $key);
                //Run query: update email
                $sql = "UPDATE users SET email='$newemail', activation2='0' WHERE (email='$email' AND activation2='$key') LIMIT 1";
                $result = mysqli_query($link, $sql);
                //If query is successful, show success message
                if (mysqli_affected_rows($link) == 1) {
                    session_destroy();
                    setcookie("rememeberme", "", time() - 3600);
                    echo '<div class="alert alert-success">Your email has been updated.</div>';
                    echo '<a href="index.php" type="button" class="btn-lg btn-sucess">Log in<a/>';
                } else {
                    //Show error message
                    echo '<div class="alert alert-danger">Your email could not be updated. Please try again later.</div>';
                    echo '<div class="alert alert-danger">' . mysqli_error($link) . '</div>';
                }
                ?>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
   <!-- bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>