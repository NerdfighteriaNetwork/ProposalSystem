<?php
(require "include.php") or die("include.php is not found.");
// the following is temporary:
if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
{
	header( "Location: ".$_SERVER['HTTP_REFERER'] );
}
else
{
	header( "Location: ".substr($_SERVER['REQUEST_URI'],0,strpost($_SERVER['REQUEST_URI'],"post.php")) );
}
?>