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

    if (isset($_GET['kontaktIDs'])) {
        $selectedkontaktIDs = json_decode($_GET['kontaktIDs'], true);
        foreach ($selectedkontaktIDs as $kontaktIDs) {
            // Prepare the SQL query
            $sql_kontaktpersoner = "DELETE FROM kontaktperson WHERE kontaktpersonID = '$kontaktIDs'";

            $mysqli->query($sql_kontaktpersoner);

            header("refresh:0.5; url=les.php?ID=" . $ID);
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