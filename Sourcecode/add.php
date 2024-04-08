<?php
// Inkluderer nødvendige filer
include 'nav.php'; // Inkluderer navigasjonsmenyen
include 'authenticate.php'; // Inkluderer autentiseringssjekk
include 'connection.php'; // Inkluderer tilkobling til databasen
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Legg til</title>
</head>

<body>
    <br><br><br><br><br><br>
    <main>

        <form action="add.php" method="post">
            <label for="navn">Navn:</label><br>
            <input type="text" id="navn" name="navn" required maxlength="45" size="100"><br>
            <label for="epost">Epost:</label><br>
            <input type="email" id="epost" name="epost" required maxlength="100"><br>
            <label for="tlf">Telefonnummer:</label><br>
            <input type="tel" id="tlf" name="tlf" required minlength="8" required maxlength="12"><br>
            <label for="postnummer">Postnummer:</label><br>
            <input type="text" id="postnummer" name="postnummer" required maxlength="4"><br>
            <input type="submit" value="Legg til"> <!-- Send-knapp -->
            <input type="reset" value="Reset">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['navn'];
                $email = $_POST['epost'];
                $phone = $_POST['tlf'];
                $postal = $_POST['postnummer'];
                
                // Sjekker om postnummeret allerede finnes i databasen
                $stmt = $mysqli->prepare("SELECT postnummer FROM postnummer WHERE postnummer = ?");
                $stmt->bind_param("s", $_POST["postnummer"]);
                $stmt->execute();
                $exists = $stmt->fetch();
                $stmt->close();

                if (!$exists) {
                    // Hvis postnummeret ikke finnes
                    echo "Vennligst oppgi et gyldig postnummer";
                } elseif (isset($name) && isset($email) && isset($phone) && isset($postal)) {
                    // Setter inn verdiene i databasen
                    $sql = "INSERT INTO kunde (navn, epost, tlf, postnummer)
                    VALUES ('$name', '$email', '$phone', '$postal')";
                    // Utfører SQL-spørringen
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Bedrift lagt til"; // Melding om vellykket tillegg
                        // Oppdaterer siden etter 2 sekunder for å vise endringene
                        header("refresh:2; url=index.php");
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

<style>
    main {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
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