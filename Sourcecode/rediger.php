<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

            // Iterate over each kundeID
            foreach ($selectedKundeIDs as $kundeID) {
                // Prepare and execute the SQL query
                $query = "SELECT kundeID, navn, postnummer, tlf, epost FROM kunde WHERE kundeID='$kundeID'";
                $result = $mysqli->query($query);
                $counter = 0;
                // Check if there are results
                if ($result && $result->num_rows > 0) {
                    // Output data of each row
                    while ($row = $result->fetch_assoc()) {
                        if ($counter % 2 == 0 && $counter != 0) {
                            echo "</tr><tr>";
                        }
                        echo "<table class='bordered-table'>";
                        echo "<td>";
                        echo "<b>KundeID: </b>" . $row["kundeID"] . "<br>";
                        echo "<b>Navn: </b>" . "<input value=" . $row['navn'] . ">" . "<br>";
                        echo "<b>Postnummer: </b>" . "<input value=" . $row['postnummer'] . ">" . "<br>";
                        echo "<b>Telefon: </b>" . "<input value=" . $row['tlf'] . ">" . "<br>";
                        echo "<b>Epost: </b>" . "<input value=" . $row['epost'] . ">" . "<br>";
                        echo "</td>";
                        echo "</table>";
                        $counter++;
                }
                } else {
                    // Output a message if no results found for the kundeID
                    echo "<tr><td colspan='5'>No results found for kundeID: $kundeID</td></tr>";
                }
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
