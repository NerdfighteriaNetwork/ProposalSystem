<?php
session_start();
(require_once 'config.php') or die('Configuration is not set.');
(require_once "auth.php") or die("auth.php is not found.");
(require_once "db.php") or die("db.php is not found.");
?>