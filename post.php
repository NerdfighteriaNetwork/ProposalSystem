<?php
(require "include.php") or die("include.php is not found.");
// the following is temporary:
$db = new db;
$db->connect();

$action = mysql_real_escape_string($_POST['action']);
$category = mysql_real_escape_string($_POST['abbr']);
$summary = mysql_real_escape_string($_POST['summary']);

$result = $db->propose($action, $category, $summary);

if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
{
	header( "Location: ".substr($_SERVER['HTTP_REFERER'],0,strrpos($_SERVER['HTTP_REFERER'],"/"))."?result=".base64_encode($result[1]) );
}
else
{
	header( "Location: ".'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"))."?result=".base64_encode($result[1]) );
}
$db->close();
?>