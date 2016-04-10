<?php
$hostname="mysql.hostinger.com.ua"; 
$username="u326498385_ibeet";  
$password="ibeet2015";     
$database="u326498385_ibeet";  
$con=mysql_connect($hostname,$username,$password);
if(! $con)
{
die('Connection Failed'.mysqli_error());
}

mysql_select_db($database,$con);
session_start();

?>