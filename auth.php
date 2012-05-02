<?php
(require_once 'config.php') or die('Configuration is not set.');
class auth {
    function isLoggedIn()
    {
    	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] >= time()-1800)
    	{
    		$_SESSION['loggedin'] = time();
        	return 1;
    	}
    	return 0; //catch all as not logged in
    }
    function login($db, $user, $pass)
    {
    	$result = $db->lookupUser($user);
    	if($result[0] != 0) /// 0 is success
    	{
    		return $result;
    	}
    	if($conf['salt']['useFile'])
    	{
    		$saltclass = new salt;
    		$salt = $saltclass->makeSalt();
    	}
    	else
    	{
    		$salt = $conf['salt']['default'];
    	}
    	if($result[1] === FALSE) //no rows
    	{
    		return array(1, "Username does not exist");
    	}
    	else if(!isset($result[1]['Password']))
    	{
    		return array(-1, "Unkown error");
    	}
    	else if($result[1]['Password'] == md5($pass))
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
