<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
if(isset($result[0]) && $result[0])
{
	die("Error (code: ".$result[0]."): ".$result[1]);
}
$props = $db->listProposals(array('Status'=>"0"));
if($props[0])
{
	die("Error (code: ".$props[0]."): ".$props[1]);
}
?><!DOCTYPE unspecified PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title><?php echo $conf['title']; ?></title>
</head>

<body>
<a href="<?php
		if(isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'])
		{
			echo $_SERVER['HTTP_REFERER'];
		}
		else
		{
			echo 'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/"));
		}?>">Back</a><br />
Proposals are ordered Most Recent (top) to Oldest (bottom).<br />
<br />
<?php
date_default_timezone_set('UTC');
foreach($props[1] as $proplist)
{
?>
<table border="1" style="width:100%;">
<tr>
<td>ID:</td>
<td style="width:80%;"><?php
echo $proplist['Abbr']."-".str_pad($proplist['Proposal_ID'],3,'0',STR_PAD_LEFT);
if(isset($proplist['parent_ID']) && $proplist['parent_ID'])
{
	$parent = $db->listProposals(array('propID' => $proplist['parent_ID']));
	if(isset($parent[1][0]))
	{
		echo "a - Revised (".$parent[1][0]['Abbr']."-".str_pad($parent[1][0]['Proposal_ID'],3,'0',STR_PAD_LEFT).")";
	}
	else
	{
		echo " - Possible error: inform webmaster.";
	}
} ?></td>
</tr>
<tr>
<td>ACTION:</td>
<td><?php echo $proplist['Action']; ?></td>
</tr>
<tr>
<td>CATEGORY:</td>
<td><?php echo $proplist['Category']; ?></td>
</tr>
<tr>
<td>DATE:</td>
<td><?php echo date("d-m-Y", $proplist['Date']); ?></td>
</tr>
<tr>
<td>PROPOSED BY:</td>
<td><?php echo $proplist['Author']; ?></td>
</tr>
<tr>
<td>SUMMARY:</td>
<td><?php echo str_replace("\n","<br />\n",$proplist['Summary']); ?></td>
</tr>
</table>
<br />
<br />
<?php
}
?>
</body>
</html><?php 
$db->close();
?>