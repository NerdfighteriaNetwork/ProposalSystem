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
	header( "Location: ".$_SERVER['HTTP_REFERER']."?result=".base64_encode("(code: ".$result[0]."): ".$result[1]) );
}
else
{
	header( "Location: ".substr($_SERVER['REQUEST_URI'],0,strpost($_SERVER['REQUEST_URI'],"post.php"))."?result=".base64_encode("(code: ".$result[0]."): ".$result[1]) );
}
$db->close();
?>