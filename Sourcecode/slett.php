<?php
session_start();

if($_SESSION["authenticated"] == false){
    header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slett</title>
</head>
<body>
    
</body>
</html>