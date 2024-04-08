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
            // Hvis 'kontaktIDs' er satt i URL-en
            if (isset($_GET['kontaktIDs'])) {
                // Dekoder den URL-kodede JSON-strengen og konverterer den til en PHP-array
                $selectedKontaktIDs = json_decode($_GET['kontaktIDs'], true);
    
                // Starter et skjema for å oppdatere kontaktinformasjon
                echo "<form method='post'>";
                echo "<table class='bordered-table'>"; // Starter en tabell for å vise kontaktinformasjon
                $counter = 0; // Antall kontakter per rad
                foreach ($selectedKontaktIDs as $kontaktID) {
                    // Forbereder og utfører SQL-spørringen
                    $query = "SELECT kontaktpersonID, fornavn, etternavn, tlf, epost, stilling, avdeling FROM kontaktperson WHERE kontaktpersonID='$kontaktID'";
                    $result = $mysqli->query($query);
                    while ($row = $result->fetch_assoc()) {
                        if ($counter % 3 == 0 && $counter != 0) { // Maks 3 kontakter per rad
                            echo "</tr><tr>";
                        }
                        echo "<td>"; // Starter en celle for hver kontakt
                        // Viser informasjonen om kontaktpersonen og lar brukeren redigere den
                        echo "<b>KundeID: </b>" . $row["kontaktpersonID"] . "<br>";
                        echo "<b>Fornavn: </b>" . "<input name='fornavn_$kontaktID' required value='" . $row['fornavn'] . "'>" . "<br>";
                        echo "<b>Etternavn: </b>" . "<input name='etternavn_$kontaktID' required maxlength='4' value='" . $row['etternavn'] . "'>" . "<br>";
                        echo "<b>Telefon: </b>" . "<input name='tlf_$kontaktID' required value='" . $row['tlf'] . "'>" . "<br>";
                        echo "<b>Epost: </b>" . "<input type='email' name='epost_$kontaktID' required value='" . $row['epost'] . "'>" . "<br>";
                        echo "<b>Stilling: </b>" . "<input type='text' name='stilling_$kontaktID' value='" . $row['stilling'] . "'>" . "<br>";
                        echo "<b>Avdeling: </b>" . "<input type='text' name='avdeling_$kontaktID' value='" . $row['avdeling'] . "'>" . "<br>";
                        echo "</td>"; // Avslutter cellen for kontaktpersonen
                        $counter++; // Øker telleren for antall kontakter
                    }
                }
                echo "</tr>"; // Avslutter raden
                echo "</table>"; // Avslutter tabellen
                // Legger til en knapp for å oppdatere informasjonen
                echo "<input id='Oppdater' type='submit' name='Oppdater' value='Oppdater'>";
                echo "</form>"; // Avslutter skjemaet

                // Hvis 'Oppdater'-knappen blir trykket
                if (isset($_POST["Oppdater"])) {
                    foreach ($selectedKontaktIDs as $kontaktID) {
                        // Henter oppdaterte verdier fra skjemaet
                        $fornavn = $_POST["fornavn_$kontaktID"];
                        $etternavn = $_POST["etternavn_$kontaktID"];
                        $tlf = $_POST["tlf_$kontaktID"];
                        $epost = $_POST["epost_$kontaktID"];
                        $stilling = $_POST["stilling_$kontaktID"];
                        $avdeling = $_POST["avdeling_$kontaktID"];
                        
                        // Oppdaterer kontaktinformasjonen i databasen
                        $updateKontakt = "UPDATE kontaktperson SET fornavn='$fornavn', etternavn='$etternavn', tlf='$tlf', epost='$epost', stilling='$stilling', avdeling='$avdeling' WHERE kontaktpersonID='$kontaktID'";
                        $mysqli->query($updateKontakt); // Utfører spørringen
                        header("refresh:0.1; url=read.php?ID=" . $ID); // Omlaster siden etter oppdatering
                    }   
                }
            }
        ?>
    </main>

    <?php
        include 'footer.php'; // Inkluderer footeren
    ?>

    <style>
        * {
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
