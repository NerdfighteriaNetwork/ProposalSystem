<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}


$user = mysql_real_escape_string($_POST['username']);
$pass = mysql_real_escape_string($_POST['password']);

$result = $db->auth->login($db, $user, $pass);
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
{
	header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))."?result=".base64_encode($result[1])  );
}
else
{
	header( "Location: ".substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"/"))."?result=".base64_encode($result[1])  );
}
?>