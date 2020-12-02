<?php

if (!isset($_SESSION['user_id']) && !empty($_COOKIE['rememberme'])) {
    // extract authenticators1 ,2 from cookie
    list($authenticator1, $authenticator2) = explode(',', $_COOKIE['rememberme']);
    $authenticator2 = hex2bin($authenticator2);
    $f2authenticator2 = hash('sha256', $authenticator2);

    // look for authenticator 1 in remember me table
    $sql = "SELECT * FROM rememberme WHERE authenticator1='$authenticator1'";
    $result = mysqli_query($link, $sql);
    if (!$result) {
        echo "<div class='alert alert-danger'>There was errror ruuning query</div>";
        exit;
    }
    $count = mysqli_num_rows($result);
    if ($count != 1) {
        echo '<div class="alert alert-danger">Remember me process failed!</div>';
        exit;
    }
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // if authenticator 2 does not match
    if (!hash_equals($row['f2authenticator2'], $f2authenticator2)) {
        echo "Hash not Equals";
    } else {
        $authenticator1 = bin2hex(openssl_random_pseudo_bytes(10));
        $autheticator2 = openssl_random_pseudo_bytes(20);

        // storing them in cookie
        function f1($a, $b)
        {
            $c = $a . "," . bin2hex($b);
            return $c;
        }
        $cookieValue = f1($authenticator1, $autheticator2);
        //expires in 15 days -> 1296000sec
        setcookie(
            "rememberme",
            $cookieValue,
            time() + 1296000
        );

        // run query to store in rememberme table
        function f2($a)
        {
            $b = hash('sha256', $a);
            return $b;
        }
        $f2authenticator2 = f2($authenticator2);
        $user_id = $_SESSION['user_id'];
        $expiration = date('Y-m-d H:i:s', time() + 1296000);
        $sql = "INSERT INTO rememberme
            (`authenticator1`,`f2authenticator2`,`user_id`,`expires`)
            VALUES ('$authenticator1','$f2authenticator2','$user_id','$expiration')";
        $result = mysqli_query($link, $sql);
        if (!$result) {
            echo "<div class='alert alert-danger'>There was error remember the data</div>";
        }
        $_SESSION['user_id'] = $row['user_id'];
        header('location:mainpageloggedin.php');
    }
}
