<?php
// Inkluderer nødvendige filer
include 'nav.php'; // Inkluderer navigasjonsmenyen
include 'connection.php'; // Inkluderer tilkobling til databasen
include 'authenticate.php'; // Inkluderer autentiseringssjekk

// Henter ID-en fra URL-parameteren
$ID = isset($_GET['ID']) ? $_GET['ID'] : ''; // Setter $ID til $_GET['id'] hvis den eksisterer, ellers settes den til en tom streng
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Legg til kontaktperson</title>
</head>

<body>
    <br><br><br><br><br><br><br>
    <main>

        <form action="addContact.php?ID=<?php echo $ID; ?>" method="post">
            <label for="fornavn">Fornavn: </label><br>
            <input type="text" name="fornavn" required maxlength="45" size="100"><br>
            <label for="etternavn">Etternavn: *</label><br>
            <input type="text" name="etternavn" required maxlength="45" size="100"><br>
            <label for="stilling">Stilling: *</label><br>
            <input type="text" name="stilling" required maxlength="80" size="100"><br>
            <label for="avdeling">Avdeling: *</label><br>
            <input type="text" name="avdeling" required maxlength="80"><br>
            <label for="tlf">Telefonnummer: *</label><br>
            <input type="tel" name="tlf" required maxlength="12"><br>
            <label for="epost">Epost: *</label><br>
            <input type="email" name="epost" required maxlength="100"><br>
            <input type="submit" value="Legg til"> <!-- Send-knapp -->
            <input type="reset" value="Reset">
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $firstName = $_POST['fornavn'];
                $sirName = $_POST['etternavn'];
                $position = $_POST['stilling'];
                $department = $_POST['avdeling'];
                $phone = $_POST['tlf'];
                $email = $_POST['epost'];
                $kundeID = $ID;

                // Sjekker om alle påkrevde felt er satt
                if (isset($firstName) && isset($sirName) && isset($position) && isset($department) && isset($phone) && isset($email)) {
                    // SQL-spørring for å sette inn ny kontakt i databasen
                    $sql = "INSERT INTO kontaktperson (fornavn, etternavn, stilling, avdeling, tlf, epost, kundeID)
                    VALUES ('$firstName', '$sirName', '$position', '$department', '$phone', '$email', '$kundeID')";
                    // Utfører SQL-spørringen
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Kontaktperson lagt til"; // Melding om vellykket tillegg
                        // Oppdaterer siden etter 2 sekunder for å vise endringene
                        header("refresh:2; url=read.php?ID=$ID");
                    } else {
                        echo "Error: " . $sql . "<br>" . $mysqli->error; // Feilmelding hvis spørringen mislykkes
                    }
                } else {
                    echo "Et eller flere felt mangler"; // Feilmelding hvis påkrevde felt mangler
                }
            }
            ?>
        </form>
    </main>
    <br><br>
    <?php
    include 'footer.php' // Inkluderer bunnteksten
    ?>
</body>

</html>
</html>
</html>

<style>
    main {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    }

    form {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        background-color: #FFF;
        border: 1px solid #000;
    }

    label {
        display: block;
        margin-bottom: 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="tel"] {
        width: 85%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 5px;
        border: 1px solid #ccc;
    }

    input[type="submit"],
    input[type="reset"] {
        width: 100%;
        padding: 10px;
        background-color: #3262ab;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    input {
        margin: 5px;
    }
</style>