<?php
(require_once 'config.php') or die('Configuration is not set.');
(require_once "auth.php") or die("auth.php is not found.");
class db {
    public $auth;
    private $sql;
    private $link;
    
    function __construct() {
        /*
         * This function is the constructor.
         * $auth is required to be defined here.
        */
    	global $conf;
    	$this->auth = new auth;
    	$this->sql = $conf['sql'];
    }
    
    function connect()
    {
    	global $conf;
    	$this->link = mysql_connect($conf['sql']['server'], $conf['sql']['user'], $conf['sql']['pass']);
    	if (!$this->link) {
    		die('Could not connect: ' . mysql_error());
    	}
    	if(!mysql_select_db($conf['sql']['database']))
    	{
    		die('Could select database: ' . mysql_error());
    	}
    }
    function close()
    {
    	global $conf;
    	mysql_close($this->link);
    }

    function propose($action, $category, $summary) {
        /*
         * This function inserts a new proposal into the database.
         * All parameters are assumed SQL-safe.
        */
    	global $conf;
        if(!$auth->isLoggedIn()) {
            return array(1, "Not logged in.");
        }

        
        if(preg_match('/^\s*$/', $action)){
            return array(2, "Action is empty.");
        }

        $qry = "SELECT idcategories AS 'CID' FROM ".$conf['table_prefix']."categories WHERE Abbr = '".$category."'";
        $result = mysql_query($qry);
        if(mysql_num_rows($result) == 0) {
            return array(3, "Category is invalid.");
        }else{
            $CID = mysql_fetch_row($result);
            $CID = $CID[0];
        }

        if($summary == ''){
            return array(4, "Summary is empty.");
        }

        $date = mktime (0, 0, 0); //set date to be midnight today
        $UID = $auth->getUserID(); //get the current logged in User ID

        //insert this shit into the database, yo.
        $qry = sprintf("INSERT INTO ".$conf['table_prefix']."proposals (`Proposal_ID`, `Action`, `Date`, `Summary`, `is_rev`, `parent_ID`, ".
            "`users_UID`, `categories_idcategories`) VALUES ('%s', '%s', '%s', '%s', '0', NULL, '%s', '%s');",
            $id, $action, $date, $summary, $UID, $CID);

        return array(0, "Success");
    }

    function getCategories() {
        /*
         * this function will return an enum array of assoc arrays, containing the abbrevation (abbr) and names (name) of each category.
         * Example: array(0 => array('abbr' => 'GEN', 'name' => 'General'), 0 => array('abbr' => 'WEB', 'name' => 'Website'))
        */
    	global $conf;
        $qry = "SELECT Name AS 'name', Abbr AS 'abbr' FROM ".$this->sql['table_prefix']."categories ORDER BY name ASC";
        $result = mysql_query($qry);
        if($result !== FALSE)
        {
        	while($return[] = mysql_fetch_assoc($result));
        	unset($return[count($return)-1]);
        }
        else
        {
        	$return[] = array("name" => "error", "abbr" => "error");
        }
        return $return;
    }
}
?>
