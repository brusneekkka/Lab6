<?php
    include_once("db.php");
    $flag = '0';
    $login = $_POST['login'] ?? '';
    $pass = $_POST['pass'] ?? '';
    
    if(empty($_POST)) {
        $flag = '0'; //предохранение от захода без запроса
    } else if($login == '' or $pass == '') {
        $flag = '1'; //некорректный логин или пароль
    } else {
        $res = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='$login'"));
        if ($res !== NULL and password_verify($pass, $res['hash'])) {
            $token = $res['token'];
            $token = password_hash("$token", PASSWORD_DEFAULT);
            setcookie("login", "$login", time()+3600*24);
            setcookie("token", "$token", time()+3600*24);
            $flag = '-1';
        } else {
            $flag = '1'; //некорректный логин или пароль
        }
    }
    echo "$flag";
?>