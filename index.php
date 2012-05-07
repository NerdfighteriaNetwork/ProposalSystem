<?php
(require "include.php") or die("include.php is not found.");
if(file_exists("install.php") || file_exists("install.sql"))
{
	die("Be sure to run install.php! If you already have, delete both install.php and install.sql");
}
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}
$categories = $db->getCategories();
?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $conf['Title']; ?></title>
</head>

<body>

<center>
<?php echo base64_decode($_GET['result']); ?>
<?php
if($db->auth->isLoggedIn())
{
	if(substr($_SESSION['email'],strrpos($_SESSION['email'],"@")) == "@staff.dftba.net")
	{
?>
<div style="position:absolute;top:5px;left:5px;text-align:left;">
<form action="logout.php" method="post">
<input type="submit" name="logout" value="Logout" />
</form>
<form action="view.php" method="get">
<input type="submit" value="View Proposals" />
</form>
</div>
<form action="post.php" method="post">
<table>
<tr>
	<td>Category:</td>
	<td><select name="abbr">
	<?php foreach($categories as $category) { ?>
		<option value="<?php echo $category['abbr']; ?>"><?php echo $category['name']; ?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td>Action (Title):</td>
	<td><input style="width:300px;" type="text" name="action" /></td>
</tr>
<tr>
	<td style="vertical-align:top;">Summary (Proposal Body):</td>
	<td><textarea style="width:400px;height:250px;" name="summary"></textarea></td>
</tr>
<tr>
	<td colspan="2" align="right">
	<?php date_default_timezone_set('UTC'); echo "Submit before ".date("H:i \U\T\C", $_SESSION['loggedin']+1800)." or you will be logged out." ?><br />
	<input type="submit" name="post" value="Post" />
	</td>
</tr>
</table>
</form>
<?php
	}
	else
	{
?>
<div style="position:absolute;top:5px;left:5px;text-align:left;">
<form action="logout.php" method="post">
<input type="submit" name="logout" value="Logout" />
</form>
<form action="view.php" method="get">
<input type="submit" value="View Proposals" />
</form>
</div>
You are not a staff member.
<?php
	}
}
else
{
?>
<div style="position:absolute;top:5px;left:5px;text-align:left;">
<form action="view.php" method="get">
<input type="submit" value="View Proposals" />
</form>
</div>
<form action="login.php" method="post">
<table>
<tr>
	<td colspan="2">Please Login</td>
</tr>
<tr>
	<td>Username:</td>
	<td><input type="text" name="username" /></td>
</tr>
<tr>
	<td>Password:</td>
	<td><input type="password" name="password" /></td>
</tr>
<tr>
	<td colspan="2" align="right"><a href="register.php">Register</a> <input type="submit" name="login" value="Login" /></td>
</tr>
</table>
</form>
<?php
}
?>
</center>

</body>
</html><?php 
$db->close();
?>