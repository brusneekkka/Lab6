<?php
    include_once('db.php');
    $login = $_POST['login'] ?? null;
    $pass = $_POST['pass'] ?? '';

    if(empty($_POST)) {
        $flag= '0'; //предохранение от захода без запроса
    } else if($login == '' or $pass == '') {
        $flag = '1'; //некорректный логин или пароль
    } else if(strlen($pass) < 6 or !preg_match("#[0-9]+#", $pass ) or !preg_match("#[a-z]+#", $pass)) {
        $flag = '3'; //пароль не прошёл валидацию
    } else {
        $result = mysqli_fetch_assoc(mysqli_query($link, "SELECT * FROM users WHERE login='$login'"));    
        
        if ($result === NULL) {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $token = random_bytes(16);
            $token = password_hash("$token", PASSWORD_DEFAULT);
            mysqli_query($link, "INSERT INTO users (login, hash, token) VALUES ('$login', '$hash', '$token')");
            $flag='-1'; //успех 
        } else {
            $flag='2'; // логин занят
        }
    }
    echo($flag);
?>
