<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['user_id']) && $_GET['logout'] == 1) {
    session_destroy();
    setcookie('rememberme', "", time() - 3600);
}
