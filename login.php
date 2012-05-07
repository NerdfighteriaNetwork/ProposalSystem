<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}

if(isset($_POST['login']))
{
	$user = mysql_real_escape_string($_POST['username']);
	$pass = mysql_real_escape_string($_POST['password']);
	
	$result = $db->auth->login($db, $user, $pass);
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
}
else if(isset($_POST['register']))
{
	$user = mysql_real_escape_string($_POST['username']);
	$email = mysql_real_escape_string($_POST['email']);
	$pass = mysql_real_escape_string($_POST['password']);
	
	$result = $db->auth->register($user,$email,$pass);
	
	if($result[0] == 0)
	{
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
		{
			header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))."?result=".base64_encode("Check your email to confirm.")  );
		}
		else
		{
			header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"))."?result=".base64_encode("Check your email to confirm.")  );
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
}
else
{
	if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
	{
		header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))."?result=".base64_encode("error") );
	}
	else
	{
		header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"))."?result=".base64_encode("error") );
	}
}
$db->close();
?>