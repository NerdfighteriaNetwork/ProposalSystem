<?php
(require "include.php") or die("include.php is not found.");
$_SESSION['loggedin'] = 0;
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
{
	header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/")) );
}
else
{
	header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strpos($_SERVER['REQUEST_URI'],"/")) );
}
?>