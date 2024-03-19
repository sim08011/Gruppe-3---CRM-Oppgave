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

        <form action="addContact.php" method="post">
            <label for="fornavn">Fornavn: *</label><br>
            <input type="text" id="fornavn" name="fornavn" required maxlength="45" size="100"><br>
            <label for="etternavn">Etternavn: *</label><br>
            <input type="text" id="etternavn" name="etternavn" required maxlength="45" size="100"><br>
            <label for="stilling">Stilling: *</label><br>
            <input type="text" id="stilling" name="stilling" required maxlength="80" size="100"><br>
            <label for="avdeling">Avdeling: *</label><br>
            <input type="text" id="avdeling" name="avdeling" required maxlength="80"><br>
            <label for="tlf">Telefonnummer: *</label><br>
            <input type="tel" id="tlf" name="tlf" required maxlength="12" ><br>
            <label for="epost">Epost: *</label><br>
            <input type="email" id="epost" name="epost" required maxlength="100" ><br>
            <input type="submit" value="Legg til">
            <input type="reset" value="Reset">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $firstName = $_POST['fornavn'];
                $sirName = $_POST['etternavn'];
                $position = $_POST['stilling'];
                $department = $_POST['avdeling'];
                $phone = $_POST['tlf'];
                $email = $_POST['epost'];
            

                if (isset($firstName) && isset($sirName) && isset($position) && isset($department) && isset($phone) && isset($email)) {
                    $sql = "INSERT INTO kontaktperson (fornavn, etternavn, stilling, avdeling, tlf, epost, kundeID)
                    VALUES ('$firstName', '$sirName', '$position', '$department', '$phone', '$email', 25)";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Kontaktperson lagt til";
                        header("refresh:2; url=index.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $mysqli->error;
                    }
                } 
                else {
                    echo "Et eller flere felt mangler";
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