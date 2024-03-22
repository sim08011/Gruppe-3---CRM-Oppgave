<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Document</title>
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
            foreach ($selectedKundeIDs as $kundeID) {
                // Prepare and execute the SQL query
                $query = "SELECT kundeID, navn, postnummer, tlf, epost FROM kunde WHERE kundeID='$kundeID'";
                $result = $mysqli->query($query);

                // Check if there are results
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        echo "<table class='bordered-table'>";
                        echo "<td>";
                        echo "<b>KundeID: </b>" . $row["kundeID"] . "<br>";
                        // Input fields with unique names for each kunde record
                        echo "<b>Navn: </b>" . "<input name='navn_$kundeID' value='" . $row['navn'] . "'>" . "<br>";
                        echo "<b>Postnummer: </b>" . "<input name='postnr_$kundeID' required maxlength='4' value='" . $row['postnummer'] . "'>" . "<br>";
                        echo "<b>Telefon: </b>" . "<input name='tlf_$kundeID' value='" . $row['tlf'] . "'>" . "<br>";
                        echo "<b>Epost: </b>" . "<input name='epost_$kundeID' value='" . $row['epost'] . "'>" . "<br>";
                        echo "</td>";
                        echo "</table>";
                    }
                } else {
                    // Output a message if no results found for the kundeID
                    echo "<p>No results found for kundeID: $kundeID</p>";
                }
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
        } else {
            echo "No kundeIDs selected.";
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
