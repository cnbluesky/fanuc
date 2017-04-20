<?php 
$serverName = "localhost"; 
$connectionInfo = array( "Database"=>"fanuc", "UID"=>"sa", "PWD"=>"123456");
$conn = sqlsrv_connect( $serverName, $connectionInfo);
?>