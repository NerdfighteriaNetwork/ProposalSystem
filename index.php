<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$db->connect();
$categories = $db->getCategories();
?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $conf['Title']; ?></title>
</head>

<body>

<center>
<?php
if($db->auth->isLoggedIn())
{
?>
<form action="logout.php" method="post">
<input style="position:absolute;top:5px;left:5px;" type="submit" name="logout" value="Logout" />
</form>
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
	<td><input type="text" name="action" /></td>
</tr>
<tr>
	<td>Summary (Proposal Body):</td>
	<td><textarea name="summary"></textarea></td>
</tr>
<tr>
	<td colspan="2"><input type="submit" name="post" value="Post" /></td>
</tr>
</table>
</form>
<?php
}
else
{
?>
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
	<td colspan="2"><input type="submit" name="login" value="Login" /></td>
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