<?php
    // Henter ID-parametern fra URL-en hvis den eksisterer, ellers settes den til null
    $ID = isset($_GET['ID']) ? $_GET['ID'] : null;

    // Sjekker om ID-en ikke er null og utfører videre behandling ved behov
    if($ID !== null) {
        // Din kode her
        echo "ID-en er: " . $ID;
    } else {
        echo "Mangler ID-parameter i URL-en.";
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
        include 'nav.php'; // Inkluderer navigasjonsmenyen
        include 'connection.php'; // Inkluderer databaseforbindelsen
        include 'authenticate.php'; // Inkluderer autentiseringssjekken
    ?>
    <main>
    <?php
        // Sjekker om 'kundeIDs' parameteren er satt i URL-en
        if (isset($_GET['kundeIDs'])) {
            // Dekoder den URL-kodede JSON-strengen og konverterer den til en PHP-array
            $selectedKundeIDs = json_decode($_GET['kundeIDs'], true);

            // Starter et skjema for å oppdatere kundeinformasjon
            echo "<form method='post'>";
            echo "<table class='bordered-table'>"; // Starter en tabell for å vise kundeinformasjon
            $counter = 0; // Antall kunder per rad
            foreach ($selectedKundeIDs as $kundeID) {
                // Forbereder og utfører SQL-spørringen
                $query = "SELECT kundeID, navn, postnummer, tlf, epost, nettsted FROM kunde WHERE kundeID='$kundeID'";
                $result = $mysqli->query($query);
                while ($row = $result->fetch_assoc()) { 
                    if ($counter % 3 == 0 && $counter != 0) { // Maks 3 kunder per rad
                        echo "</tr><tr>";
                    }
                    echo "<td>"; // Starter en celle for hver kunde
                    // Viser informasjonen om kunden og lar brukeren redigere den
                    echo "<b>KundeID: </b>" . $row["kundeID"] . "<br>";
                    echo "<b>Navn: </b>" . "<input name='navn_$kundeID' required value='" . $row['navn'] . "'>" . "<br>";
                    echo "<b>Postnummer: </b>" . "<input name='postnr_$kundeID' required maxlength='4' value='" . $row['postnummer'] . "'>" . "<br>";
                    echo "<b>Telefon: </b>" . "<input name='tlf_$kundeID' required value='" . $row['tlf'] . "'>" . "<br>";
                    echo "<b>Epost: </b>" . "<input type='email' name='epost_$kundeID' required value='" . $row['epost'] . "'>" . "<br>";
                    echo "<b>Nettside: </b>" . "<input type='text' name='nettsted_$kundeID' value='" . $row['nettsted'] . "'>" . "<br>";
                    echo "</td>"; // Avslutter cellen for kunden
                    $counter++; // Øker telleren for antall kunder
                }
            }
            echo "</tr>"; // Avslutter raden
            echo "</table>"; // Avslutter tabellen
            // Legger til en knapp for å oppdatere informasjonen
            echo "<input id='Update' type='submit' name='Update' value='Oppdater'>";
            echo "</form>"; // Avslutter skjemaet

            // Håndterer skjemainnsendingen
            if (isset($_POST["Update"])) {
                foreach ($selectedKundeIDs as $kundeID) {
                    // Henter oppdaterte verdier fra skjemaet
                    $navn = $_POST["navn_$kundeID"];
                    $postnr = $_POST["postnr_$kundeID"];
                    $tlf = $_POST["tlf_$kundeID"];
                    $epost = $_POST["epost_$kundeID"];
                    $nettsted = $_POST["nettsted_$kundeID"];
                    
                    // Oppdaterer kundeinformasjonen i databasen
                    $updateQuery = "UPDATE kunde SET navn='$navn', postnummer='$postnr', tlf='$tlf', epost='$epost', nettsted='$nettsted' WHERE kundeID='$kundeID'";
                    $mysqli->query($updateQuery); // Utfører spørringen
                    header("refresh:0.1; url=index.php"); // Omlaster siden etter oppdatering
                }
            }
        }
    ?>
    </main>
    <?php
        include 'footer.php'; // Inkluderer footeren
    ?>

    <style>
        #Update {
            font-size: 17px;
            margin-left: 45vw;
            cursor: pointer;
        }

        table {
            font-size: 17px;
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
