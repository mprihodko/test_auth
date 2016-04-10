<?php 

if(isset($_GET['act']) AND isset($_GET['login'])) {
$act = $_GET['act'];
$act = stripslashes($act);
$act = htmlspecialchars($act);

$login = $_GET['login'];
$login = stripslashes($login);
$login = htmlspecialchars($login);
}
else{
exit("Вы зашил на страницу без кода подтверждения!");
}
 
$activ = mysql_query("SELECT id FROM users WHERE login='$login'"); //извлекаем идентификатор пользователя с данным логином
$id_activ = mysql_fetch_array($activ); 
$activation = md5($id_activ['id']);
if ($activation == $act) {//сравниваем полученный из url и сгенерированный код
mysql_query("UPDATE users SET activation='1' WHERE login='$login'");
echo "Ваш аккуант <strong>".$login."</strong> успешно активирован! Теперь вы можете зайти на сайт под своим логином и паролем!<br><a href='index.php'>Главная страница</a>";
}
else {
echo "Ошибка! Ваш аккуант не активирован. Обратитесь к администратору.<br><a href='index.php'>Главная страница</a>";
}
?>