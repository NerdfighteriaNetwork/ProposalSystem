<?php 
/* install.php expects the following:
 * lines that contain configuration setting start with $ (no tabs, no spaces!)
 * conf array keys have single quotes.
 * there is one equal(=) symbol
 * after the ; there is a space, followed by // and the meaning of the setting.
*/

session_start();

//general settings
$conf['title'] = "Nerdfighteria Network Proposal System"; //The desired website title

// mysql variables
$conf['sql']['user'] = "root"; //MySQL Username
$conf['sql']['pass'] = ""; //MySQL Password
$conf['sql']['server'] = "localhost"; //MySQL Server address
$conf['sql']['database'] = "proposalSystem"; //MySQL database name
$conf['sql']['pre'] = "PS_"; //if used, all tables in the database will have this prefix. (helpful to avoid collisions in databases used for more than 1 purpose.)

//password encryption settings.
$conf['salt']['useFile'] = FALSE; //If this is TRUE, passwords will use salt.php to generate a salt. This file is not open-source for security reasons.
$conf['salt']['default'] = 'AnPtb6!Dy5g$QGTg#3dUFy)39Crq{sR2pG2sY@P7FTb&5RaF'; //if salt useFile is FALSE, this string is used as the salt. We recommend you generate your own random string for security purposes.

// Comment out the next line by putting // in front of it!
die("Hey... Read the config file!");
?>
