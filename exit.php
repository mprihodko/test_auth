<?php
include('connect.php');
if(isset($_POST['exit'])){	
	session_unset();
}
/*перенаправление на главную */
    header("Location: http://". $_SERVER['HTTP_HOST'] );
?>