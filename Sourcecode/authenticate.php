<?php
if($_SESSION["authenticated"] == false){
    header("Location: index.php");
}
?>