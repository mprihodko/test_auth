<?php
include('functions.php');

if (isset($_POST['login'])){
    $login = $_POST['login']; 
    if ($login == '') {
        unset($login);
        exit ("Введите пожалуйста логин!");
    } 
}
if (isset($_POST['password'])){
    $password = $_POST['password']; 
    if ($password == '') {
        unset($password);
        exit ("Введите пароль");
    }
}
$login = trim(strip_tags($login));
$password =trim(strip_tags(md5($password)));

$user = mysql_query("SELECT `id` FROM `users` WHERE `login`='".$login."'
                                                AND `password`='".$password."' 
                                                AND `activation`=1");
$id_user = mysql_fetch_array($user);
if (empty($id_user['id'])){
    exit ("Извините, введённый вами логин или пароль неверный.");
}else {    
    $_SESSION['password'] = $password; 
    $_SESSION['login'] = $login; 
    $_SESSION['id'] = $id_user['id']; 
}

/*Если логин успешен перенаправление на главную */
    header("Location: http://". $_SERVER['HTTP_HOST'] );


?>