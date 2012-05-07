<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}
$props = $db->listProposals();
if($props[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}
?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $conf['Title']; ?></title>
</head>

<body>
<center>
<div style="position:absolute;top:5px;left:5px;text-align:left;">
<form action="view.php" method="get">
<input type="submit" value="View Proposals" />
</form>
</div>
<form action="login.php" method="post">
<table>
<tr>
	<td colspan="2">Registration:</td>
</tr>
<tr>
	<td>Username:</td>
	<td><input type="text" name="username" /></td>
</tr>
<tr>
	<td>Email:</td>
	<td><input type="text" name="email" /></td>
</tr>
<tr>
	<td>Password:</td>
	<td><input type="password" name="password" /></td>
</tr>
<tr>
	<td>Confirm Password:</td>
	<td><input type="password" name="confpassword" /></td>
</tr>
<tr>
	<td colspan="2" align="right"><a href="./">Login</a> <input type="submit" name="register" value="Register" /></td>
</tr>
</table>
</center>
</form>
</body>
</html><?php 
$db->close();
?>