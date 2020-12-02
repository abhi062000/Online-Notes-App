<?php
session_start();
include('connection.php');
include('logout.php');
include('remember.php');
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
    <title>Online Notes App</title>
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
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#loginModal" data-toggle="modal">Login</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- jumbotron -->
    <div class="jumbotron">
        <div class="container-fluid">
            <h1>Online Notes App</h1>
            <p>Your notes with you wherever you go!</p>
            <p>Easy to use, protects all your notes.</p>
            <button type="button" class="btn btn-lg green" data-toggle="modal" data-target="#signupModal">Sign up-It's Free</button>
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
                            <input type="password" placeholder="Password" class="form-control" name="loginpassword" id="loginpassword">
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


                        <input type="submit" value="Login" class="btn green" name="login">
                        <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- signup form -->
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
                            <input type="password" placeholder="Choose a Password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <input type="password" placeholder="Confirm Password" class="form-control" name="password2" id="password2">
                        </div>
                    </div>
                    <div class="modal-footer">

                        <input type="submit" value="Sign Up" class="btn green" name="signup">
                        <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
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
                        <div id="forgotpasswordmessage">

                        </div>

                        <div class="form-group">
                            <input type="email" placeholder="Email" class="form-control" name="forgotemail" id="forgotemail">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default mr-auto" data-dismiss="modal" data-target="#signupModal" data-toggle="modal" name="forgotpasswordregister">Register</button>
                        <input type="submit" value="Submit" class="btn green" name="forgotpasswordsubmit">
                        <input type="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">

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
    <script src="index.js"></script>
</body>

</html>