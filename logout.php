<?php
    include_once('db.php');
    $login = $_COOKIE['login'];
    mysqli_query($link, "UPDATE users SET token='' WHERE login='$login'");
    setcookie('token', '', time());
    setcookie('login', '', time());
    echo('ok');
?>