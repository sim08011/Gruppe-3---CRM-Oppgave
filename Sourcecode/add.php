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

        <form action="add.php" method="post">
            <label for="navn">Navn:</label><br>
            <input type="text" id="navn" name="navn" required maxlength="45" size="100"><br>
            <label for="epost">Epost:</label><br>
            <input type="email" id="epost" name="epost" required maxlength="100"><br>
            <label for="tlf">Telefon nummer:</label><br>
            <input type="tel" id="tlf" name="tlf" required maxlength="12" ><br>
            <label for="postSted">Post kode:</label><br>
            <input type="text" id="postSted" name="postSted" required maxlength="4"><br>
            <input type="submit" value="Leggtil">
            <input type="reset" value="Reset">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $name = $_POST['navn'];
                $email = $_POST['epost'];
                $phone = $_POST['tlf'];
                $postal = $_POST['postSted'];
                if (isset($name) && isset($email) && isset($phone) && isset($postal)) {
                    $sql = "INSERT INTO kunde (navn, epost, tlf, postSted)
                VALUES ('$name', '$email', '$phone', '$postal')";
                    if ($mysqli->query($sql) === TRUE) {
                        echo "Bedrift lagt til";
                        header("refresh:2; url=index.php");
                    } else {
                        echo "Error: " . $sql . "<br>" . $mysqli->error;
                    }
                } else {
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