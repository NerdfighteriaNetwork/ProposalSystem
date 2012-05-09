<?php
$prefix = "";

function makeConfig($post){
    $file = fopen('config.php','w+');

    if(file_exists('example.config.php')){
        //open the example file.
        $example = fopen('example.config.php','r');
    }else{
        die("Both the configuration and the example configuration file are not found, install could not proceed.");
    }
    //lock files
    flock($file, LOCK_EX); //lock config.php with writer's rights.
    flock($example, LOCK_SH); //lock example.config.php with readers's rights.

    //start main filereading loop
    while(!feof($example)){
        //get line
        $line = fgets($example);
        if(substr($line,0,1) == "$"){
            //line is a variable declaration
            $equal = strpos($line, "=");
            $key1 = substr($line,7,strpos($line,'\'',8)-7);
            if(substr_count($line,"][")){
                //nested array, find it
                $pos1 = strpos($line,"]")+3;
                $pos2 = strpos($line,"'",$pos1)-$pos1;
                $key2 = substr($line,$pos1,$pos2);
            }
            $line = substr($line,0,$equal+2).$post[$key1.$key2];
            if($key1.$key2 == "sqluser"){ $sql['user'] = $post[$key1.$key2]; }
            if($key1.$key2 == "sqlpass"){ $sql['pass'] = $post[$key1.$key2]; }
            if($key1.$key2 == "sqlserver"){ $sql['server'] = $post[$key1.$key2]; }
            if($key1.$key2 == "sqldatabase"){ $sql['db'] = $post[$key1.$key2]; }
            if($key1.$key2 == "sqlpre"){ $sql['pre'] = $post[$key1.$key2]; }
        }elseif(substr($line,0,3) == "die"){
            $line = "// ".$line;
        }
        fwrite($file,$line);
        //reset variables
        $key = $key2 = "";
        $equal = $pos1 = $pos2 = 0;
    }

    //undo locks
    flock($file, LOCK_UN);
    flock($example, LOCK_UN);
    

    //start SQL stuff
    $file = fopen('install.sql','c+');
    flock($file, LOCK_EX); //lock config.php with writer's rights.

    //start main filereading loop
    while(!feof($file)){
        //get line
        $line = fgets($example);
    }
    //undo locks
    flock($file, LOCK_UN);
    unset($file);
}
function getKeys(){
    $return = array();
    if(file_exists('example.config.php')){
        //open the example file.
        $example = fopen('example.config.php','r');
    }else{
        die("Both the example configuration file not found, install could not proceed.");
    }
    flock($example, LOCK_SH); //lock example.config.php with readers's rights.

    //start main filereading loop
    while(!feof($example)){
        $line = fgets($example);
        if(substr($line,0,1) == "$"){
            //line is a variable declaration
            $key1 = substr($line,7,strpos($line,'\'',8)-7);
            if(substr_count($line,"][")){
                //nested array, find it
                $pos1 = strpos($line,"]")+3;
                $pos2 = strpos($line,"'",$pos1)-$pos1;
                $key2 = substr($line,$pos1,$pos2);
            }
            $varName = $key1.$key2;
            //locate variable explanation.
            
            $return[] = array($varName,$explanation);
        }
    }
}

if(file_exists('config.php')){
    require_once 'config.php';
}elseif(isset($_POST)){
    makeConfig($_POST);
}else{
    //there's no configuration file, show form to make one.
    $data = getkeys();
}
?>
