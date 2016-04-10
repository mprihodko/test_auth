<?php
// проверяем сабмит формы
if (isset($_POST['submit'])){
	//проводим валидацию данных из формы в функции validate вернет либо false либо масив если данные правильные
    $user_data=validate($_POST);
    //проверяем результат функции validate
    if(is_array($user_data)){
    	//проверяем результат функции checkLogin  возвращает true/false
    	if(checkLogin($user_data['login'])){
    		//проверяем результат функции checkEmail  возвращает true/false
    		if(checkEmail($user_data['email'])){
    			sendMail($user_data);
				$query = "INSERT INTO `users` (email,
											   login,
											   password) VALUES (	'".$user_data['email']."',
											    					'".$user_data['login']."',
											     					'".md5($user_data['password'])."')";
				$result = mysql_query($query) or die(mysql_error());
				echo '<font color="green">Вы успешно зарегистрированы!</font><br>';
			}
    	}
	}
}else{ ?> 

<h3>Sign Up</h3>
<form method="post" action="">
	<p><input name="email" type="email" required placeholder="email@email.com"></p>
	<p><input name="login" type="text" required placeholder="Login"></p>
	<p><input name="password" type="password" required placeholder="Password"></p> 
	<p><input name="password2" type="password" placeholder="Repeat password" required></p>
	<p><input type="submit" name="submit" value="Registr"></p>
</form>
<?php 
echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>';
// https://accounts.google.com/o/oauth2/auth?redirect_uri=http://localhost/google-auth&response_type=code&client_id=333937315318-fhpi4i6cp36vp43b7tvipaha7qb48j3r.apps.googleusercontent.com&scope=https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile


?>
<?php } ?>