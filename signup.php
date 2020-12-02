<?php

session_start();
include("connection.php");

// defining error messages
$missingUsername = "<p>Please enter Username</p>";
$missingEmail = "<p>Please enter email</p>";
$invalidEmail = "<p>Please enter a valid email address</p>";
$missingPassword = "<p>Enter a password</p>";
$invalidPassword = "<p>Your password should be atleast 6 characters and must contain 1 capital letter and a number.</p>";
$differentPassword = "<p>Password don't Match!</p>";
$missingPassword2 = "<p>Please confirm your password</p>";
$errors = "";
// getting user inputs
// username
if (empty($_POST["username"])) {
    $errors .= $missingUsername;
} else {
    $username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
}

// email
if (empty($_POST["email"])) {
    $errors .= $missingEmail;
} else {
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors .= $invalidEmail;
    }
}

// password
if (empty($_POST["password"])) {
    $errors .= $missingPassword;
} elseif (!(strlen($_POST["password"]) > 6 && preg_match('/[A-Z]/', $_POST["password"]) && preg_match('/[0-9]/', $_POST["password"]))) {
    $errors .= $invalidPassword;
} else {
    $password = filter_var($_POST["password"], FILTER_SANITIZE_STRING);
    if (empty($_POST["password2"])) {
        $errors .= $missingPassword2;
    } else {
        $password2 = filter_var($_POST["password2"], FILTER_SANITIZE_STRING);
        if ($password !== $password2) {
            $errors .= $differentPassword;
        }
    }
}

// print errors
if ($errors) {
    $resultMessage = '<div class="alert alert-danger">' . $errors . '</div>';
    echo $resultMessage;
} else {
    $username = mysqli_real_escape_string($link, $username);
    $email = mysqli_real_escape_string($link, $email);
    $password = mysqli_real_escape_string($link, $password);
    // $password = md5($password); less secure
    $password = hash("sha256", $password);  // 64 bytes

    // check if username exist in db
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>Error running in Query</div>";
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo "<div>Username is already registered.</div>";
        exit;
    }

    // check if email exist in db
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>Error running in Query</div>";
        exit;
    }
    $results = mysqli_num_rows($result);
    if ($results) {
        echo "<div class='alert alert-danger'>Email is already registered.</div>";
        exit;
    }

    // creating activation key
    $activationkey = bin2hex(openssl_random_pseudo_bytes(16));  //32 char hex

    $sql = "INSERT INTO users (`username`,`email`,`password`,`activation`) VALUES ('$username','$email','$password','$activationkey')";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>Error in sending data into database</div>";
        echo mysqli_error($link);
        exit;
    }


    // send activation key to users email with activate.php
    $message = "Please click on this link to activate your account\n\n";
    $message .= "http://thesite.offyoucode.co.uk/onlinenotes/activate.php?email=" . urlencode($email) . "&key=$activationkey";


    // mail($to, $subject, $body, $headers);
    if (mail($email, 'Confirm your Registration', $message, 'From' . 'abhishekghanekar2000@gmail.com')) {
        echo "<div class='alert alert-success'>Confirmation has been send to $email.Click on the Activation link to activate your account.</div>";
    }
}