<?php
require('config.php') or die('Configuration is not set.');
class db {
    $auth = new auth;
    $sql = $conf['sql'];

    function propose($action, $category, $summary) {
        /*
         * This function inserts a new proposal into the database.
         * All parameters are assumed SQL-safe.
        */
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
            $CID = mysql_fetch_row($result)[0];
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
        $qry = "SELECT Name AS 'name', Abbr AS 'abbr' FROM ".$conf['table_prefix']."categories ORDER BY name ASC";
        $result = mysql_query($qry);
        while($return[] = mysql_fetch_assoc($result));
        return $return;
    }
}
?>
