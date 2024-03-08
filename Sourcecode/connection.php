<?php
$mysqli = new mysqli("localhost","root","","crm_database"); 
        
if ($mysqli -> connect_errno) {
    echo "Feilet med å koble til Databasen: " . $mysqli -> connect_error;
    exit();
}
?>