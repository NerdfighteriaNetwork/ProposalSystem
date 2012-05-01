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

// Comment out the next line by putting // in front of it!
die("Hey... Read the config file!");
?>
