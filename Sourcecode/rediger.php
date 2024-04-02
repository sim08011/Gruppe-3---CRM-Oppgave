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
    <link rel="stylesheet" href="bitnami.css">
    <title>Redigering</title>
</head>
<body>
    <br><br><br><br>
    <?php
        include 'nav.php';
        include 'connection.php';

        // Check if the database connection is initialized
        if ($mysqli === null) {
            die("Database connection is not initialized.");
        }

        // Check if kundeIDs parameter is set in the URL
        if (isset($_GET['kundeIDs'])) {
            // Decode the URL-encoded JSON string and convert it to a PHP array
            $selectedKundeIDs = json_decode($_GET['kundeIDs'], true);

            // Output a form for updating kunde records
            echo "<form method='post'>";
            // Iterate over each kundeID
            echo "<table class='bordered-table'>";
            foreach ($selectedKundeIDs as $kundeID) {
                // Prepare and execute the SQL query
                $query = "SELECT kundeID, navn, postnummer, tlf, epost, nettsted FROM kunde WHERE kundeID='$kundeID'";
                $result = $mysqli->query($query);
                $counter = 0;
                while ($row = $result->fetch_assoc()) { 
                    if ($counter % 2 == 0 && $counter != 0) {
                        echo "</tr><tr>";
                    }
                    echo "<td>";
                    echo "<b>KundeID: </b>" . $row["kundeID"] . "<br>";
                    echo "<b>Navn: </b>" . "<input name='navn_$kundeID' required value='" . $row['navn'] . "'>" . "<br>";
                    echo "<b>Postnummer: </b>" . "<input name='postnr_$kundeID' required maxlength='4' value='" . $row['postnummer'] . "'>" . "<br>";
                    echo "<b>Telefon: </b>" . "<input name='tlf_$kundeID' required value='" . $row['tlf'] . "'>" . "<br>";
                    echo "<b>Epost: </b>" . "<input type='email' name='epost_$kundeID' required value='" . $row['epost'] . "'>" . "<br>";
                    echo "<b>Nettside: </b>" . "<input type='email' name='nettsted_$kundeID' value='" . $row['nettsted'] . "'>" . "<br>";
                    echo "</td>";
                    $counter++;
                }
            }
            echo "</tr>"; // Avslutter rekke etter 5 bedrifter
            echo "</table>"; // Avslutter table
            }

            // Submit button
            echo "<input type='submit' name='Oppdater' value='Oppdater'>";
            echo "</form>";

            // Handle form submission
            if (isset($_POST["Oppdater"])) {
                foreach ($selectedKundeIDs as $kundeID) {
                    // Retrieve updated values from the form
                    $navn = $_POST["navn_$kundeID"];
                    $postnr = $_POST["postnr_$kundeID"];
                    $tlf = $_POST["tlf_$kundeID"];
                    $epost = $_POST["epost_$kundeID"];
                    
                    // Update kunde record in the database
                    $updateQuery = "UPDATE kunde SET navn='$navn', postnummer='$postnr', tlf='$tlf', epost='$epost' WHERE kundeID='$kundeID'";
                    $mysqli->query($updateQuery);
                }
                echo "<p>BRA!</p>";
            }
    ?>

    <style>
        body {
            background-color: aliceblue;
        }

        table {
            font-size: 17px;;
            margin-left: auto;
            margin-right: auto;
            margin-top: 1%;
            border-collapse: separate;
            border-spacing: 10px;
            border: 2px solid black;
            background-color: white;
            margin-bottom: 50px;
            width: 35vw;
        }

        td {
            border: 2px solid black;
            padding: 20px;
        }
    </style>

</body>
</html>
