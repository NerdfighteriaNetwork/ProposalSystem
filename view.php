<?php
(require "include.php") or die("include.php is not found.");
$db = new db;
$result = $db->connect();
echo "<pre>";
var_dump($db->listProposals());
echo "</pre>";
?>