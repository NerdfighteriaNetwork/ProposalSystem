<?php
(require_once 'config.php') or die('Configuration is not set.');
class auth {
	
	function randStr($length = 16, $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789")
	{
		global $conf;
		$size = strlen( $chars );
		for( $i = 0; $i < $length; $i++ )
		{
			$str .= $chars[ rand( 0, $size - 1 ) ];
		}
		return $str;
	}
	function confirm($email, $code)
	{
		$qry = sprintf("UPDATE ".$conf['sql']['pre']."users SET `Confirmed`=%u".
				" WHERE `Email` = '%s';",
				1, $email);
        $result = mysql_query($qry);
        
        if($result !== FALSE)
        {
    		$_SESSION['loggedin'] = time();
    		$_SESSION['email'] = $email;
            return array(0, "Success");
        }
        else
        {
            return array(5, "Error confirming username with that confirmation code.");
        }
	}
	function register($user, $email, $pass)
	{
		global $conf;
		$qry = sprintf("INSERT INTO ".$conf['sql']['pre']."users (`Username`, `Email`, `Password`, `Confirmed`)".
				" VALUES ('%s', '%s', MD5('%s'), %u);",
				$user, $email, $pass, 0);
        $result = mysql_query($qry);
        
        $to      = $email;
        $subject = 'Confirmation Email';
        $message = '<html>';
        $message .= '<body>';
        $message .= 'You have successfully registered with the Nerdfighteria Network Proposal System.<br />';
        $message .= 'Please follow the link below to confirm your account:<br />';
        $message .= '<a href="'.'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/")).'confirm.php?email='.$email.'&code='.$this->randStr().'">'
        	.'http://'.$_SERVER['SERVER_NAME'].'/'.substr($_SERVER['REQUEST_URI'],0,strrpos($_SERVER['REQUEST_URI'],"/")).'confirm.php?email='.$email.'&code='.$this->randStr().'</a>';
        $message .= '</body>';
        $message .= '</html>';
        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $headers .= 'From: "DFTBA no-reply" <no-reply@staff.dftba.net>' . "\r\n" .
        		'Reply-To: no-reply@staff.dftba.net' . "\r\n" .
        		'Return-Path: no-reply@staff.dftba.net' . "\r\n" .
        		'X-Mailer: PHP/' . phpversion();
        $args = '-fno-reply@staff.dftba.net';
        
        mail($to, $subject, $message, $headers, $args);
        
        if($result !== FALSE)
        {
            return array(0, "Success");
        }
        else
        {
            return array(5, "Username could not be registered (username may already exist).");
        }
	}
    function isLoggedIn()
    {
		global $conf;
    	if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] >= time()-1800)
    	{
    		$_SESSION['loggedin'] = time();
        	return 1;
    	}
    	return 0; //catch all as not logged in
    }
    function login($db, $user, $pass)
    {
		global $conf;
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
    		$email = $this->getEmail($user);
    		if(!$email[0])
    		{
    			$_SESSION['loggedin'] = time();
    			$_SESSION['email'] = $email[1];
    			return array(0, "Success");
    		}
    		else
    		{
    			return array(-1, $email[1]);
    		}
    	}
    	else
    	{
    		return array(2, "Passwords don't match");
    	}
    }
    function getEmail($user)
    {
		global $conf;
		$qry = "SELECT `Email` FROM ".$conf['sql']['pre']."users WHERE `Username` = '".$user."'";
        $result = mysql_query($qry);
        if($result !== FALSE)
        {
    		$list = mysql_fetch_assoc($result);
    		$email = $list['Email'];
            return array(0, $email);
        }
        else
        {
            return array(-1, "Error");
        }
        //placeholder, int expected.
    }
    function getUserName()
    {
		global $conf;
        //placeholder, string expected.
    }
    function getUserID()
    {
		global $conf;
		$qry = "SELECT `UID` FROM ".$conf['sql']['pre']."users WHERE `Email` = '".$_SESSION['email']."'";
		$result = mysql_query($qry);
		if($result !== FALSE)
		{
			$list = mysql_fetch_assoc($result);
			$id = $list['UID'];
			return $id;
		}
		else
		{
			return array(-1, "Error");
		}
    }
}
?>
