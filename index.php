<!DOCTYPE html>
<html>
	<head>
		<title>Welcome</title>
		<meta charset="UTF-8">
		<script type="text/javascript" src="jquery-1.12.3.min.js"></script>
		<?php 
			ini_set('error_reporting', E_ALL);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);
		?>
		<?php include('functions.php'); ?>

	</head>
	<body width="450px">
		<br>

		<?=isset($_SESSION['login']) ? 'Привет, '.$_SESSION['login']. '<form style="display:inline" action="exit.php" method="post"> 
				<input type="submit" value="Exit" name="exit">
			</form>': ''?>

		<br>
		<?php 
		if(isset($_GET['act'])){
			activateUser($_GET['act']);
		}
		$page = isset($_GET["page"])?$_GET["page"] : null;
		switch ($page) {
			case 'sign_up':
				require_once('sign_up.php');
				break;
			
			default:			 
			// если залогинен не показываем формы входа и регистрации
			if(!isset($_SESSION['login'])){ ?>
				<form action="login.php" method="POST">
					<table>
						<tr>
							<td>Логин:</td>
							<td><input type="text" name="login"></td>
						</tr>

						<tr>
							<td>Пароль:</td>
							<td><input type="password" name="password"></td>
						</tr>

						<tr>
							<td colspan="2"><input type="submit" value="Войти" name="submit"></td>
						</tr>
					</table>
				</form>
				<?php echo $link = '<p><a href="' . $url . '?' . urldecode(http_build_query($params)) . '">Аутентификация через Google</a></p>'; ?>
				<a href="http://<?=$_SERVER["HTTP_HOST"]?>/index.php?page=sign_up">Регистрация</a>
		<?php }else{
			?>
			<form action="exit.php" method="post"> 
				<input type='submit' value="Exit" name="exit">
			</form>
			<?php
		}
				break;
		}?>
		<!-- <pre> -->
 		<?php //var_dump($_SERVER); ?>
		<!-- </pre> -->
		

		
	</body>
</html> 
