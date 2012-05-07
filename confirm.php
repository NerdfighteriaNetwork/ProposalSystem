<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}
$code = mysql_real_escape_string($_GET['code']);
$email = mysql_real_escape_string($_GET['email']);

$result = $db->auth->confirm($email,$code);

if($result[0] == 0)
{
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
	{
		header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))  );
	}
	else
	{
		header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"))  );
	}
}
else
{
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
	{
		header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))."?result=".base64_encode($result[1])  );
	}
	else
	{
		header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"))."?result=".base64_encode($result[1])  );
	}
}

?>