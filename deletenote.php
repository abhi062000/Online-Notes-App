<?php
session_start();
include('connection.php');

// get rid of id on note through ajax
$note_id = $_POST['id'];
// run query to delete the note
$sql = "DELETE FROM notes WHERE id='$note_id'";
$result = mysqli_query($link, $sql);
if (!$result) {
    echo 'error';
}
