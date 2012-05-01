<?php
(require "include.php") or die("include.php is not found.");
$_SESSION['loggedin'] = 1; // to do: actually make a login script
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
{
	header( "Location: ".$_SERVER['HTTP_REFERER'] );
}
else
{
	header( "Location: ".substr($_SERVER['REQUEST_URI'],0,strpost($_SERVER['REQUEST_URI'],"logout.php")) );
}
?>