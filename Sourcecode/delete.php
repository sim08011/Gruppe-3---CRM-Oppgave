<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Slett</title>
</head>
<body>
    <?php
        // Henter ID-en fra URL-parameteren
        $ID = isset($_GET['ID']) ? $_GET['ID'] : null;

        // Sjekker om ID-en ikke er null og utfører videre behandling ved behov
        if($ID !== null) {
            echo "ID-en er: " . $ID;
        } else {
            echo "Mangler ID-parameter i URL-en.";
        }
    ?>
    <?php
    include 'nav.php'; // Inkluderer navigasjonsmenyen
    include 'connection.php'; // Inkluderer databaseforbindelsen
    include 'authenticate.php'; // Inkluderer autentiseringssjekken

    if (isset($_GET['kundeIDs'])) {
        // Dekoder den URL-kodede JSON-strengen og konverterer den til en PHP-array
        $selectedKundeIDs = json_decode($_GET['kundeIDs'], true);
        foreach ($selectedKundeIDs as $kundeID) {
            // Forbereder SQL-spørringen for å slette kontaktpersoner og kunder
            $sql_kontaktpersoner = "DELETE FROM kontaktperson WHERE kundeID = '$kundeID'";
            $sql_kunde = "DELETE FROM kunde WHERE kundeID = '$kundeID'";

            $mysqli->query($sql_kontaktpersoner); // Utfører spørringen for å slette kontaktpersonene
            $mysqli->query($sql_kunde); // Utfører spørringen for å slette kunden

            header("refresh:0.5; url=index.php"); // Omlaster siden etter 0.5 sekunder
        }
    }    
    ?>
</body>
</html>
