<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    if (isset($_GET['kontaktIDs'])) {
        $selectedkontaktIDs = json_decode($_GET['kontaktIDs'], true);
        foreach ($selectedkontaktIDs as $kontaktIDs) {
            // Forbereder SQL-spørringen for å slette kontaktpersoner
            $sql_kontaktpersoner = "DELETE FROM kontaktperson WHERE kontaktpersonID = '$kontaktIDs'";

            $mysqli->query($sql_kontaktpersoner); // Utfører spørringen for å slette kontaktpersonen

            header("refresh:0.1; url=read.php?ID=" . $ID); // Omlaster siden etter 0.5 sekunder
        }
    }
    
    ?>
</body>
</html>

<style>
        body {
            background-color: aliceblue;
        }
</style>
