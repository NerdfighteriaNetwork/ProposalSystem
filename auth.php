<?php
(require_once 'config.php') or die('Configuration is not set.');
class auth {
    function isLoggedIn()
    {
    	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])
    	{
        	return 1;
    	}
    	return 0; //catch all as not logged in
    }
    function login($db, $user, $pass)
    {
    	$result = $db->lookupUser($user);
    	if($conf['salt']['useFile'])
    	{
    		$saltclass = new salt;
    		$salt = $saltclass->makeSalt();
    	}
    	else
    	{
    		$salt = $conf['salt']['default'];
    	}
    	if( $result === FALSE)
    	{
    		return array(1, "Username does not exist");
    	}
    	else if(!isset($result['Password']))
    	{
    		return array(-1, "Unkown error");
    	}
    	else if($result['Password'] == md5($pass))
    	{
    		$_SESSION['loggedin'] = time();
    		return array(0, "Success");
    	}
    	else
    	{
    		return array(2, "Passwords don't match");
    	}
    }
    function getUserName()
    {
        //placeholder, string expected.
    }
    function getUserID()
    {
        //placeholder, int expected.
        return 1;
    }
}
?>
