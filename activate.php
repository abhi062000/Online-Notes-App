<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation</title>
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <div class="container alert alert-success">
        <?php

        session_start();
        include('connection.php');

        // if email or activation key is missing 
        if (!isset($_GET['email']) || !isset($_GET['key'])) {
            echo '<div class="alert alert-danger">There was an error.Please click on the activation link</div>';
            exit;
        }

        $email = $_GET['email'];
        $key = $_GET['key'];

        $email = mysqli_real_escape_string($link, $email);
        $key = mysqli_real_escape_string($link, $key);

        // run query set activation field to activated
        $sql = "UPDATE users SET activation='activated' WHERE (email='$email' AND activation='$key')LIMIT 1";

        $result = mysqli_query($link, $sql);

        if (mysqli_affected_rows($link) == 1) {
            echo '<div class="alert alert-success">Your account has been activated</div>';
            echo '<a href="index.php">Log In</a>';
        } else {
            //error
            echo '<div class="alert alert-danger">Your account could not be activated.Please try again later</div>';
            echo mysqli_error($link);
        }
        ?>
    </div>
</body>

</html>