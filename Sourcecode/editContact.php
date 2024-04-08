<?php
        $ID = isset($_GET['ID']) ? $_GET['ID'] : null;

        // Check if the ID is not null and do further processing if needed
        if($ID !== null) {
            // Your code here
            echo "The ID is: " . $ID;
        } else {
            echo "Missing ID parameter in the URL.";
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
        include 'authenticate.php';
       ?> <main>
        <?php
    if (isset($_GET['kontaktIDs'])) {
                // Decode the URL-encoded JSON string and convert it to a PHP array
                $selectedKontaktIDs = json_decode($_GET['kontaktIDs'], true);
    
                echo "<form method='post'>";
                // Iterate over each kundeID
                echo "<table class='bordered-table'>";
                $counter = 0;
                foreach ($selectedKontaktIDs as $kontaktID) {
                    // Prepare and execute the SQL query
                    $query = "SELECT kontaktpersonID, fornavn, etternavn, tlf, epost, stilling, avdeling FROM kontaktperson WHERE kontaktpersonID='$kontaktID'";
                    $result = $mysqli->query($query);
                    while ($row = $result->fetch_assoc()) { 
                        if ($counter % 3 == 0 && $counter != 0) {
                            echo "</tr><tr>";
                        }
                        echo "<td>";
                        echo "<b>KundeID: </b>" . $row["kontaktpersonID"] . "<br>";
                        echo "<b>Fornavn: </b>" . "<input name='fornavn_$kontaktID' required value='" . $row['fornavn'] . "'>" . "<br>";
                        echo "<b>Etternavn: </b>" . "<input name='etternavn_$kontaktID' required maxlength='4' value='" . $row['etternavn'] . "'>" . "<br>";
                        echo "<b>Telefon: </b>" . "<input name='tlf_$kontaktID' required value='" . $row['tlf'] . "'>" . "<br>";
                        echo "<b>Epost: </b>" . "<input type='email' name='epost_$kontaktID' required value='" . $row['epost'] . "'>" . "<br>";
                        echo "<b>Stilling: </b>" . "<input type='text' name='stilling_$kontaktID' value='" . $row['stilling'] . "'>" . "<br>";
                        echo "<b>Avdeling: </b>" . "<input type='text' name='avdeling_$kontaktID' value='" . $row['avdeling'] . "'>" . "<br>";
                        echo "</td>";
                        $counter++;
                    }
                }
                echo "</tr>"; // Avslutter rekke etter 5 bedrifter
                echo "</table>"; // Avslutter table
                }

                // Submit button
                echo "<input id='Oppdater' type='submit' name='Oppdater' value='Oppdater'>";
                echo "</form>";

                if (isset($_POST["Oppdater"])) {
                    foreach ($selectedKontaktIDs as $kontaktID) {
                        // Retrieve updated values from the form
                        $fornavn = $_POST["fornavn_$kontaktID"];
                        $etternavn = $_POST["etternavn_$kontaktID"];
                        $tlf = $_POST["tlf_$kontaktID"];
                        $epost = $_POST["epost_$kontaktID"];
                        $stilling = $_POST["stilling_$kontaktID"];
                        $avdeling = $_POST["avdeling_$kontaktID"];
                        
                        // Update kunde record in the database
                        $updateKontakt = "UPDATE kontaktperson SET fornavn='$fornavn', etternavn='$etternavn', tlf='$tlf', epost='$epost', stilling='$stilling', avdeling='$avdeling' WHERE kontaktpersonID='$kontaktID'";
                        $mysqli->query($updateKontakt);
                        header("refresh:0.1; url=les.php?ID=" . $ID);
                    }   
                }
    ?>
    </main>
<?php
    include 'footer.php';
?>
<style>
    *{
            margin: 0;
            padding: 0;
        }
        body {
            background-color: aliceblue;
        }

        #Oppdater {
            font-size: 17px;
            margin-left: 45vw;
            cursor: pointer;
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
