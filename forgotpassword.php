<?php
session_start();
include("connection.php");
$missingEmail = "<p>Please enter email</p>";
$invalidEmail = "<p>Please enter a valid email address</p>";

$errors = "";
if (empty($_POST["forgotemail"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["forgotemail"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
    exit;
}
$email = mysqli_real_escape_string($link, $email);
// check if email exist in db
$sql = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "<div class='alert alert-danger'>Error running in Query</div>";
    exit;
}
$count = mysqli_num_rows($result);
if (!$count) {
    echo "<div class='alert alert-danger'>Email is not registered</div>";
    exit;
}
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
$user_id = $row['user_id'];
// create activation key
$key = bin2hex(openssl_random_pseudo_bytes(16));
$time = time();
$status = 'pending';
$sql = "INSERT INTO forgotpassword (`user_id`,`rkey`,`time`,`status`) VALUES ('$user_id','$key','$time','$status')";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-danger">There was an error inserting the users details in the database!</div>';
    exit;
}


// send mail for reset password
$message = "Please click on this link to Reset the Password\n\n";
$message .= "http://thesite.offyoucode.co.uk/onlinenotes/resetpassword.php?user_id=$user_id&key=$key";


// mail($to, $subject, $body, $headers);
if (mail($email, 'Reset your Password', $message, 'From' . 'abhishekghanekar2000@gmail.com')) {
    echo "<div class='alert alert-success'>Confirmation has been send to $email.Click on the link to reset password.</div>";
} else {
    echo "Email not sent";
}