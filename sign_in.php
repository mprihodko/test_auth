<?php
include('functions.php'); 

if (isset($_GET['code'])) {
	$result = false;	
    $params = array(
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri'  => $redirect_uri,
        'grant_type'    => 'authorization_code',
        'code'          => $_GET['code']
    );

	$url_token = 'https://accounts.google.com/o/oauth2/token';

	$curl = curl_init();	
	curl_setopt($curl, CURLOPT_URL, $url_token);
	curl_setopt($curl, CURLOPT_POST, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$result = curl_exec($curl);
	curl_close($curl);

	$tokenInfo = json_decode($result, true);

	if (isset($tokenInfo['access_token'])) {
	    $params['access_token'] = $tokenInfo['access_token'];

	    $userInfo = json_decode(file_get_contents('https://www.googleapis.com/oauth2/v1/userinfo' . '?' . urldecode(http_build_query($params))), true);
	    if (isset($userInfo['id'])) {
	        $userInfo = $userInfo;
	        $result = true;
	    }
	}

}
if(isset($userInfo)){
	$get_user=mysql_query("SELECT * FROM `users` WHERE `password`='".md5($userInfo['id'])."'");
	$result_sql=mysql_fetch_array($get_user);
	if(!isset($result_sql['id'])){
		$query = "INSERT INTO `users` (email,
							   login,
							   password) VALUES (	'".$userInfo['email']."',
							    					'".$userInfo['name']."',
							     					'".md5($userInfo['id'])."')";
		$result = mysql_query($query) or die(mysql_error());
		$get_user=mysql_query("SELECT * FROM `users` WHERE `password`='".md5($userInfo['id'])."'");
		$result_sql=mysql_fetch_array($get_user);
		if(isset($result_sql['id'])){
			$_SESSION['password'] = md5($userInfo['id']); 
		    $_SESSION['login'] = $userInfo['name']; 
		    $_SESSION['id'] = $result_sql['id'];
		}
	}else{
		$_SESSION['password'] = $result_sql['password']; 
		$_SESSION['login'] = $result_sql['login']; 
		$_SESSION['id'] = $result_sql['id'];
	}
}
header("Location: http://". $_SERVER['HTTP_HOST'] );

?>