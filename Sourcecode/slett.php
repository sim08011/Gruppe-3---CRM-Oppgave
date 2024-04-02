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
    <?php
    include 'nav.php';
    include 'connection.php';

    if (isset($_GET['kundeIDs'])) {
        // Decode the URL-encoded JSON string and convert it to a PHP array
        $selectedKundeIDs = json_decode($_GET['kundeIDs'], true);
        foreach ($selectedKundeIDs as $kundeID) {
            // Prepare the SQL query
            $sql_kontaktpersoner = "DELETE FROM kontaktperson WHERE kundeID = '$kundeID'";
            $sql_kunde = "DELETE FROM kunde WHERE kundeID = '$kundeID'";

            $mysqli->query($sql_kontaktpersoner);
            $mysqli->query($sql_kunde);

            header("refresh:0.5; url=index.php");
        }
    }
    
    ?>

    <style>
        body {
            background-color: aliceblue;
        }
    </style>
</body>
</html>