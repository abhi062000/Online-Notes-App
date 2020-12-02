<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("location: index.php");
}
include('connection.php');

$user_id = $_SESSION['user_id'];

//get username and email
$sql = "SELECT * FROM users WHERE user_id='$user_id'";
$result = mysqli_query($link, $sql);

$count = mysqli_num_rows($result);

if ($count == 1) {
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $username = $row['username'];
    $email = $row['email'];
} else {
    echo "There was an error retrieving the username and email from the database";
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
        #done {
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

        tr {
            cursor: pointer;
        }
    </style>
    <title>Profile</title>
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
                    <a class="nav-link" href="#">Profile </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Help</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="mainpageloggedin.php">My Notes</a>
                </li>
            </ul>
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Logged in as <?php echo $username; ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?logout=1">Logout</a>
                </li>

            </ul>
        </div>
    </nav>

    <!-- content -->
    <div class="container" id="container">
        <div class="row">
            <div class="col-md-offset-3 col-md-6">
                <h2>General Account Setting</h2>
                <div class="table-responsive">
                    <table class="table table-hover table-condensed table-bordered">
                        <tr data-target="#updateusernameModal" data-toggle="modal">
                            <td>Username</td>
                            <td><?php echo $username; ?></td>
                        </tr>
                        <tr data-target="#updateemailModal" data-toggle="modal">
                            <td>Email</td>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr data-target="#updatepasswordModal" data-toggle="modal">
                            <td>Password</td>
                            <td>**hidden**</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- update username -->
    <form method="POST" id="updateusernameForm">
        <div class="modal fade" id="updateusernameModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter new Username</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="updateusernamemessages"></div>

                        <div class="form-group">
                            <label for="updateusername">Username:</label>
                            <input type="text" class="form-control" name="updateusername" id="updateusername" value="<?php echo $username; ?>">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="usernamesubmit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- update email -->
    <form method="POST" id="updateemailForm">
        <div class="modal fade" id="updateemailModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Enter new Email</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="updateemailmessages"></div>

                        <div class="form-group">
                            <label for="updateemail">Email:</label>
                            <input type="email" class="form-control" name="updateemail" id="updateemail">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="usernamesubmit" value="Submit">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>

                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- update password -->
    <form method="POST" id="updatepasswordForm">
        <div class="modal fade" id="updatepasswordModal" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Choose new Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- message from php -->
                        <div id="updatepasswordmessages"></div>

                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Current Password" name="currentpassword" id="currentpassword">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="New Password" name="updatepassword" id="updatepassword">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" placeholder="Confirm Password" name="updatepassword2" id="updatepassword2">
                        </div>


                    </div>
                    <div class="modal-footer">
                        <input type="submit" class="btn green" name="usernamesubmit" value="Submit">
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
    <script src="profile.js"></script>
</body>

</html>