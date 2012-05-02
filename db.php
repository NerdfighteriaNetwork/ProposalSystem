<?php
(require_once 'config.php') or die('Configuration is not set.');
(require_once "auth.php") or die("auth.php is not found.");
class db {
    public $auth;
    private $link;
    
    function __construct() {
        /*
         * This function is the constructor.
         * $auth is required to be defined here.
        */
        global $conf;
        $this->auth = new auth;
    }
    
    function connect() {
        /*
         * This function starts a connection to the SQL database.
        */
        global $conf;
        $this->link = mysql_connect($conf['sql']['server'], $conf['sql']['user'], $conf['sql']['pass']);
        if (!$this->link){
            return array(1, "Could not connect: " . mysql_error());
        }elseif(!mysql_select_db($conf['sql']['database'])){
            return array(2, "Could select database: " . mysql_error());
        }else{
            return array(0, "Success");
        }
    }

    function close() {
        /*
         * This function stops a connection to the SQL database, if any.
        */
        global $conf;
        mysql_close($this->link);
    }

    function propose($action, $category, $summary) {
        /*
         * This function inserts a new proposal into the database.
         * All parameters are assumed SQL-safe.
        */
        global $conf;
        if(!$this->auth->isLoggedIn()){
            return array(1, "Not logged in.");
        }

        if(preg_match('/^\s*$/', $action)){
            return array(2, "Action is empty.");
        }

        $qry = "SELECT idcategories AS 'CID' FROM ".$conf['sql']['table_prefix']."categories WHERE Abbr = '".$category."'";
        $result = mysql_query($qry);
        if($result !== FALSE){
            if(mysql_num_rows($result) == 0){
                return array(3, "Category is invalid.");
            }else{
                $CID = mysql_fetch_row($result);
                $CID = $CID[0];
            }
        }else{
            return array(3, "Category is invalid.");
        }

        if($summary == ''){
            return array(4, "Summary is empty.");
        }

        $qry = "SELECT `Proposal_ID` FROM ".$conf['sql']['table_prefix']."proposals WHERE `categories_idcategories` = '".$CID."' ORDER BY `Proposal_ID` DESC LIMIT 1";
        $result = mysql_query($qry);
        if($result !== FALSE){
            if(mysql_num_rows($result) == 0){
                $id = 1;
            }else{
                $id = mysql_fetch_row($result);
                $id = $id[0]+1;
            }
        }else{
            return array(6, "Could not get Proposal ID.");
        }

        $date = mktime (0, 0, 0); //set date to be midnight today
        $UID = $this->auth->getUserID(); //get the current logged in User ID

        //insert this shit into the database, yo.
        $qry = sprintf("INSERT INTO ".$conf['sql']['table_prefix']."proposals (`Proposal_ID`, `Action`, `Date`, `Summary`, `is_rev`, `parent_ID`, ".
            "`users_UID`, `categories_idcategories`) VALUES ('%s', '%s', '%s', '%s', '0', NULL, '%s', '%s');",
            $id, $action, $date, $summary, $UID, $CID);
        $result = mysql_query($qry);
        if($result !== FALSE){
            return array(0, "Success");
        }else{
            return array(5, "Proposal could not be posted.");
        }
    }

    function getCategories() {
        /*
         * this function will return an enum array of assoc arrays, containing the abbrevation (abbr) and names (name) of each category.
        */
        global $conf;
        $qry = "SELECT Name AS 'name', Abbr AS 'abbr' FROM ".$conf['sql']['table_prefix']."categories ORDER BY name ASC";
        $result = mysql_query($qry);
        if($result !== FALSE){
            while($return[] = mysql_fetch_assoc($result));
            unset($return[count($return)-1]);
        }else{
            $return[] = array("name" => "error", "abbr" => "ERR");
        }
        return $return;
    }
    
    function lookupUser($user)
    {
    	global $conf;
    	$qry = "SELECT * FROM users WHERE `Username` = '".$user."'";
    	$result = mysql_query($qry);
    	if($result !== FALSE)
    	{
    		return mysql_fetch_assoc($result);
    	}
    	else
    	{
    		return array(-1, mysql_error());
    	}
    }
}
?>

