<?php
$mysqli = new mysqli("localhost:3306","im22son21061","!7z14l2aD","db_im22son21061"); 
        
if ($mysqli -> connect_errno) {
    echo "Feilet med å koble til Databasen: " . $mysqli -> connect_error;
    exit();
}
?>