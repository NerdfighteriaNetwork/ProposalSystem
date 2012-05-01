<?php
(require_once 'config.php') or die('Configuration is not set.');
class auth {
    function isLoggedIn(){
    	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
    	{
        	return 1;
    	}
    	return 0; //catch all as not logged in
    }
    function getUserName(){
        //placeholder, string expected.
    }
    function getUserID(){
        //placeholder, int expected.
        return 1;
    }
}
?>
