<?php
include("DatabaseUser.php");
function db_connect($db){
	$MainUser = new DatabaseUser();
	$dblink=new mysqli($MainUser->get_host(),$MainUser->get_name(),$MainUser->get_key(),$db);
    if (mysqli_connect_errno())
    {
        die("Error connecting to database: ".mysqli_connect_error());   
    }
	return $dblink;
}
?>