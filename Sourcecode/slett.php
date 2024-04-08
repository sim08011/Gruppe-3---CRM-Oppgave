<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slett</title>
    </head>
<body>
    <?php
        // Retrieve the ID from the URL parameter
        $ID = isset($_GET['ID']) ? $_GET['ID'] : null;

        // Check if the ID is not null and do further processing if needed
        if($ID !== null) {
            // Your code here
            echo "The ID is: " . $ID;
        } else {
            echo "Missing ID parameter in the URL.";
        }
    ?>
    <?php
    include 'nav.php';
    include 'connection.php';
    include 'authenticate.php';

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
        *{
            margin: 0;
            padding: 0;
        }
        body {
            background-color: aliceblue;
        }
    </style>
</body>
</html>