<?php
$errorMsgs = array();
$hostname = "localhost";
$username = "adminer";
$passwd = "doubt-drink-37";
$DBName = "onlinestores1";


//constructor call (new object can be fed parameters)
$DBConnect = @new mysqli($hostname, $username, $passwd, $DBName);
if($DBConnect->connect_error){
    $errorMsgs[] = "Unable to connect to the database server.".
    " Error code " . $DBConnect->connect_errno. 
    ": ". $DBConnect->connect_error;
}
?>