<?php
session_start();
include('connection.php');

// get id of note sent through Ajax
$id = $_POST['id'];
$note = $_POST['note'];
$time = time();

// run a query to update the note
$sql = "UPDATE `notes` SET note='$note',time='$time' WHERE id='$id'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo "error";
}
