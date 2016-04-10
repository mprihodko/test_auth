<?php
include('connect.php');
if (!file_exists('mailer/PHPMailerAutoload.php')) {
    die();
} else {
    require_once 'mailer/PHPMailerAutoload.php';
	$mail = new PHPMailer();	
}
function sendMail($data){	
	if(!is_array($data)) return false;
	$mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Encoding = '7bit';
    $mail->CharSet = 'utf-8';
    $mail->setLanguage('ru', 'mailer/language');
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = 'mprihodko92@gmail.com';
    $mail->Password = 'baccardi92';
    $mail->FromName = "Test";
    $mail->setFrom('Test', '');
    $mail->addReplyTo('Test', '');
    $mail->addAddress($data['email'], '');
    $mail->Subject = 'Данные для входа';
    $mail->Body = '	Ваш логин: ' . $data['login'] . '<br/>
    				Ваш Пароль: ' . $data['password'] . ' <br>
    				Ссылка подтверждения: http://'.$_SERVER['HTTP_HOST'].'/index.php?act='.md5($data['password']);
    $mail->AltBody = '	Ваш логин: ' . $data['login'] . '<br/>
    					Ваш Пароль: ' . $data['password'] . ' <br>
    					Ссылка подтверждения: http://'.$_SERVER['HTTP_HOST'].'/index.php?act='.md5($data['password']); 
    $mail->send();   
}
function activateUser($token){
	$query="SELECT * FROM `users` WHERE `password`='".$token."'";
	$sql=mysql_query($query);
	$result=mysql_fetch_array($sql);
	if(is_array($result)){
		mysql_query("UPDATE `users` SET `activation`=1 WHERE `password`='".$token."'");
	}
}
function validate($post){
	$data=array();
	if(empty($post['login']))  {
    	echo '<br><font color="red">Введите Логин!</font>';
    	return false;
	}elseif (!preg_match("/^\w{3,}$/", $post['login'])) {
		echo '<br><font color="red">В логине введены недопустимые символы!</font>';
		return false;
	}elseif(empty($post['email'])) {
		echo '<br><font color="red">Введите E-mail! </font>';
		return false;
	}elseif (!preg_match("/^[a-zA-Z0-9_\.\-]+@([a-zA-Z0-9\-]+\.)+[a-zA-Z]{2,6}$/", $post['email'])) {
		echo '<br><font color="red">E-mail имеет недопустимый формат, name@gmail.com! </font>';
		return false;
	}elseif(empty($post['password'])) {
		echo '<br><font color="red">Введите пароль!</font>';
		return false;
	}elseif (!preg_match("/\A(\w){6,20}\Z/", $post['password'])) {
		echo '<br><font color="red">Пароль должен быть минимум 6 символов! </font>';
		return false;
	}elseif(empty($post['password2'])) {
		echo '<br><font color="red">Введите подтверждение пароля!</font>';
		return false;
	}elseif($post['password'] != $post['password2']) {
		echo '<br><font color="red">Введенные пароли не совпадают!</font>';
		return false;
	}else{
		$data['login'] = trim(strip_tags($post['login']));
		$data['password'] = trim(strip_tags($post['password']));		
		$data['password2'] = trim(strip_tags($post['password2']));
		$data['email'] = trim(strip_tags($post['email']));
	}
	return $data;
}
function checkLogin($login){
	$query = "SELECT `id` FROM `users` WHERE `login`='".$login."'";
		$sql = mysql_query($query);
		$result=mysql_fetch_array($sql);
		if(!$result){
			return true;
		}else{
			echo '<font color="red">Пользователь с таким логином зарегистрирован!</font>';
			return false;	
		}	
}
function checkEmail($email){
	$query = ("SELECT `id` FROM `users` WHERE `email`='".$email."'");
	$sql = mysql_query($query);
	$result=mysql_fetch_array($sql);
	if (!$result){
		return true;
	}else{
		echo '<font color="red">Пользователь с таким e-mail зарегистрирован!</font>';
		return false;	
	}
}


$client_id = '1056119345682-rsv7hkliruo7mqg4tptuh31qm0hsdioh.apps.googleusercontent.com'; // Client ID
$client_secret = 'H9cS-rydkUrXPUI-RiAmRD9Y'; // Client secret
$redirect_uri = 'http://ibeet.16mb.com/sign_in.php'; // Redirect URI

$url = 'https://accounts.google.com/o/oauth2/auth';

$params = array(
    'redirect_uri'  => $redirect_uri,
    'response_type' => 'code',
    'client_id'     => $client_id,
    'scope'         => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
);

// 
/*
client id google       	
1056119345682-rsv7hkliruo7mqg4tptuh31qm0hsdioh.apps.googleusercontent.com
secrect key 			H9cS-rydkUrXPUI-RiAmRD9Y
*/
?>