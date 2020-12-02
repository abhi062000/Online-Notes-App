<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header('location:index.php');
}

include('connection.php');

$user_id = $_SESSION['user_id'];

//get username 
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $username = $row['username'];
    
} else {
    echo "There was an error retrieving the username from the database";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- css -->
    <link rel="stylesheet" href="style.css">
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&family=Lobster&display=swap" rel="stylesheet">
    <style>
        #container {
            margin-top: 100px;
        }

        #allNotes,
        #done,
        #notepad,
        .delete {
            display: none;
        }

        .buttons {
            margin-bottom: 1rem;
        }

        textarea {
            width: 100%;
            max-width: 100%;
            padding: 0.6rem;
            border-left-width: 20px;
            border-color: rgb(204, 115, 130);
            color: rgb(204, 115, 130);
            font-size: 1.2rem;

        }



        .notesheader {
            background-image: linear-gradient(to right top, #d9dee7, #ced5e6, #c6cbe4, #c0c1e2, #bcb6de);
            border-radius: 10px;
            padding: 0 5px;
            margin-bottom: 10px;
            border: 0.5px solid black;
            cursor: pointer;
            width: 100%;
        }

        .text {
            font-weight: 900;
            font-size: 1.3rem;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .timetext {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
    </style>
    <title>My Notes</title>
</head>

<body>
    <!-- navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-fixed-top navbar-custom navbar-dark">
        <a class="navbar-brand" href="#">Online Notes</a>
        <button class="navbar-toggler d-lg-none" type="button" data-toggle="collapse" data-target="#collapsibleNavId" aria-controls="collapsibleNavId" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <ul class="nav navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">My Notes</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Logged in as <strong><?php echo $username; ?></strong></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout=1">Logout</a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- content -->
    <div class="container" id="container">
        <!-- alert message -->
        <div class="alert alert-danger collapse" id="alert">
            <a data-dismiss="alert" style="cursor: pointer;">
                &times;
            </a>
            <p id="alertContent"></p>
        </div>

        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <div class="buttons">
                    <button id="addNote" type="button" class="btn btn-lg btn-info">Add Note</button>
                    <button id="edit" type="button" class="btn btn-lg btn-info">Edit</button>
                    <button id="done" type="button" class="btn btn-lg green">Done</button>
                    <button id="allNotes" type="button" class="btn btn-lg btn-info">All Notes</button>
                </div>
                <div id="notepad">
                    <textarea name="note" id="note" rows="10"></textarea>
                </div>
                <div id="notes" class="notes">
                    <!-- ajax used -->
                </div>
            </div>
        </div>
    </div>


    <!-- login form -->
    <form method="POST" id="loginForm">
        <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Login</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="loginmessages"></div>

                        <div class="form-group">
                            <input type="email" placeholder="Email" class="form-control" name="loginemail" id="loginemail">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Password" class="form-control" name="loginpassword" id="loginpassword">
                        </div>
                        <div class="checkbox">
                            <label for="rememberme">
                                <input type="checkbox" name="rememberme" id="rememberme">
                                Remember Me
                            </label>
                            <a href="#forgotPasswordModal" data-toggle="modal" style="cursor: pointer; float:right" data-dismiss="modal">Forgot Password?</a>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal" name="register">Register</button>
                        <button type="button" class="btn green" name="login">Login</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- signup form -->
    <!-- Modal -->
    <form method="POST" id="signupForm">
        <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Sign up Today</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="signupmessage"></div>
                        <div class="form-group">
                            <input type="text" placeholder="Username" class="form-control" name="username" id="username">
                        </div>
                        <div class="form-group">
                            <input type="email" placeholder="Email Address" class="form-control" name="email" id="email">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Choose a Password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Confirm Password" class="form-control" name="password2" id="password2">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn green" name="signup">Sign Up</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- forgot password form -->
    <form method="POST" id="forgotPasswordForm">
        <div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Forgot Password? Enter your Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="forgotpasswordmessage"></div>

                        <div class="form-group">
                            <input type="email" placeholder="Email" class="form-control" name="forgotemail" id="forgotemail">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal" name="forgotpasswordregister">Register</button>
                        <button type="button" class="btn green" name="forgotpasswordsubmit">Submit</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>




    <!-- bootstrap js -->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <!-- script -->
    <script src="mynotes.js"></script>
</body>

</html>