<?php
$hostname = "localhost";
$user = "********";
$password = "******";
$dbname = "thesiteo_onlinenotes";

$link = mysqli_connect($hostname, $user, $password, $dbname);
if (mysqli_connect_error()) {
    die("Error: Unable to connect to database" . mysqli_connect_error());
}
