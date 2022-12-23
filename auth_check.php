<?php
    $result = NULL;

    if (isset($_COOKIE['token']) and isset($_COOKIE['login'])) {
        $token = $_COOKIE['token'];
        $login = $_COOKIE['login'];
        include_once('db.php');
        $result = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='$login'"));
    }

    if ($result == NULL or !password_verify($result['token'] ,$token))
        header('Location:welcome.php');
?>