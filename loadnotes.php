<?php
session_start();
include("connection.php");

// getting user_id
$user_id = $_SESSION['user_id'];

// delete empty notes

$sql = "DELETE FROM `notes` WHERE note=''";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo '<div class="alert alert-warning">An error occured For Empty</div>';
    exit;

}
// run query for notes
$sql = "SELECT * FROM `notes` WHERE user_id='$user_id' ORDER BY time DESC";

// show notes or alert messages
if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $note_id = $row['id'];
            $note = $row['note'];
            $time = $row['time'];
            $time = date("F d,Y", $time);


            echo "
            <div class='row'>
            <div class='col-xs-5 col-sm-5 col-lg-3 delete'>
                <button class='btn btn-lg btn-danger' style='width:100%;'>Delete</button>
            </div>
            <div class='notesheader' id='$note_id'>
            <div class='text'>$note</div>
            <div class='timetext'>$time</div>
            </div>
            </div>";
        }
    } else {
        echo "<div class='alert alert-warning'>You have not Created any Notes</div>";
    }
} else {
    echo '<div class="alert alert-danger">An error occured</div>';
}