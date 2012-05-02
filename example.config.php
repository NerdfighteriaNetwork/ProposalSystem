<?php 
session_start();
// change the following to the desired Website Title (<title></title>)
$conf['Title'] = "Nerdfighteria Network Proposal System";

// mysql variables
$conf['sql']['user'] = "root";
$conf['sql']['pass'] = "";
$conf['sql']['server'] = "localhost";
$conf['sql']['database'] = "proposalSystem";
$conf['sql']['table_prefix'] = "PS_";

//password encryption settings.
$conf['salt']['useFile'] = FALSE; //If this is TRUE, passwords will use salt.php to generate a salt. This file is not open-source for security reasons.
$conf['salt']['default'] = 'AnPtb6!Dy5g$QGTg#3dUFy)39Crq{sR2pG2sY@P7FTb&5RaF'; //if salt useFile is FALSE, this string is used as the salt. We recommend you generate your own random string for security purposes.

// Comment out the next line by putting // in front of it!
die("Hey... Read the config file!");
?>
