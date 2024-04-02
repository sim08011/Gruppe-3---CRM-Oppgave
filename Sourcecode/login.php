<?php
session_start();

if($_SESSION["authenticated"] == true){
    $_SESSION["authenticated"] = false;
    header("Location: index.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>CRM Database</title>
</head>

<body>
    <?php
    include 'nav.php';
    include 'connection.php'
        ?>
    <main>

        <form action="login.php" method="post">
            <label for="brukernavn">Brukernavn:</label><br>
            <input type="text" id="brukernavn" name="brukernavn" required maxlength="20" size="100"><br>
            <label for="passord">Passord:</label><br>
            <input type="password" id="passord" name="passord" required maxlength="100"><br>
            <input type="submit" name="Login" value="Logg inn">
            <input type="reset" value="Reset">

            <?php
                // Håndter innloggingsskjemaet
                if (isset($_POST['Login'])) {
                    $brukernavn = $_POST["brukernavn"];
                    $passord = $_POST["passord"];

                    // Utfør en spørring for å finne brukeren i databasen
                    $sql = "SELECT * FROM bruker WHERE brukernavn = '$brukernavn' AND passord = '$passord'";
                    $result = $mysqli->query($sql);

                    if ($result->num_rows == 1) {
                        // Brukeren ble funnet, logg inn brukeren
                        $_SESSION["username"] = $brukernavn;
                        $_SESSION["authenticated"] = true;
                        header("Location: index.php");
                    } else {
                        // Brukeren ble ikke funnet, vis en feilmelding
                        echo "<br>Ugyldig brukernavn eller passord.";
                    }
                }
            ?>
        </form>
    </main>

    <?php
    include 'footer.php'
    ?>
</body>
</html>

<style>
    body {
        background-color: aliceblue;
    }

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
    input[type="password"]{
        width: 95%;
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