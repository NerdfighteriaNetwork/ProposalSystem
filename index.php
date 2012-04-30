<?php
$db = new db;
$categories = $db->getCategories();
?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $conf['Title']; ?></title>
</head>

<body>

<center>

<table>
<tr>
	<td>Categories:</td>
	<td><select name="abbr">
	<?php foreach($categories as $category) { ?>
		<option value="<?php echo $category['abbr']; ?>"><?php echo $category['name']; ?></option>
	<?php } ?>
	</select></td>
</tr>
<tr>
	<td>ACTION:</td>
	<td></td>
</tr>
</table>

</center>

</body>
</html>