<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Document</title>
</head>
<body>
    <?php
        include 'nav.php';
        include 'connection.php';
    ?>  
    <main>
    
    <?php
    $ID = $_GET['ID'];
        echo "<table>";
        $counter = 0;
        if ($result = $mysqli->query("SELECT kontaktperson.*, kunde.navn AS kunde_navn FROM kontaktperson INNER JOIN kunde ON kontaktperson.kundeID = kunde.kundeID WHERE kontaktperson.kundeID = $ID")) {
            if ($result->num_rows > 0) {
                $rad = $result->fetch_assoc(); // Fetching the first row
                $kunde_navn = $rad["kunde_navn"]; // Store the value of kunde.navn
                echo "<caption>$kunde_navn"; // Output the value of kunde.navn
                
                echo '<section id="button-container">';
                echo '<button type="button" name="toggleButton" id="toggleButton">Merk</button>';
                echo '<button id="Redigerknapp">Rediger</button>';
                echo "<a href='addContact.php?id=$ID'><button id='LeggtilKnapp'>Legg til</button></a>";
                echo '</section>';
                echo '</</caption>';
                do {
                    if ($counter % 5 == 0) {    
                        echo "<tr>"; // Start a new row every five elements
                    }

                    echo "<td>";
                    echo "<b>Navn:</b> ", $rad["fornavn"] . "<br>";
                    echo "<b>Etternavn:</b> ", $rad["etternavn"] . "<br>";
                    echo "<b>Stilling:</b> ", $rad["stilling"] . "<br>";
                    echo "<b>Avdeling:</b> ", $rad["avdeling"] . "<br>";
                    echo "<b>Telefon:</b> ", $rad["tlf"] . "<br>";
                    echo "<b>Epost:</b> ", $rad["epost"] . "<br>";
                    echo "</td>";
                    $counter++;
                    if ($counter % 5 == 0) {    
                        echo "</tr>"; // End the row every five elements
                    }
                } while ($rad = $result->fetch_assoc()); // Fetching rows inside the loop
            } else {
                echo "<caption>Ikke noe data i tabellen.</caption>";
            }
        } else {
            echo "<caption>Error</caption>";
        }
        echo "</table>";
    ?>
    </main>

    <?php
        include 'footer.php';
    ?>
</body>
</html>

<style>
    body {
        background-color: aliceblue;
    }
    main {
        margin-top: 5%;
    }
    table {
        margin-left: auto;
        margin-right: auto;
        margin-top: 1%;
        border-collapse: separate;
        border-spacing: 10px;
        border: 2px solid black;
        background-color: white;
        margin-bottom: 50px;
        
    }
    caption {
        font-size: 3rem;
    }

    td {
        border: 2px solid black;
    }

    #button-container{
            margin-left: 73%;
        }

        #LeggtilKnapp{
            width: 5vw;
            background-color: #3262ab;
            color: white;
        }

        #Redigerknapp {
            width: 5vw;
            background-color: #BD0000;
            color: white;
            position: relative;
        }

        #toggleButton{
            width: 4vw;
            background-color: grey;
            color: white;

        }

        button{
            width: 13vw;
            cursor: pointer;
        }
</style>
