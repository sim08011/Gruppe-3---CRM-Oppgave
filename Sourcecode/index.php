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
        include 'header.php';
        include 'connection.php'
    ?>
<div id="button-container">
    <a href="rediger.php"><button id="Redigerknapp">Rediger</button></a>
    <a href="add.php"><button id="LeggtilKnapp">Legg til</button></a>
</div>

<?php
echo "<table class='bordered-table'>";
$counter = 0;
if ($result = $mysqli->query("SELECT kunde.*, poststed.poststed FROM kunde
                              LEFT JOIN poststed ON kunde.postSted = poststed.postnummer")) {
    while ($row = $result->fetch_assoc()) {
        if ($counter % 5 == 0) {
            echo "<tr>"; // Start a new row every five elements
        }
        echo "<td style='cursor: pointer;' onclick=\"window.location='';\">";
        echo "<b>Navn:</b> ", $row["navn"] . "<br>";
        echo "<b>Postnummer:</b> ", $row["postSted"]. ", " . $row["poststed"] . "<br>";
        echo "<b>Epost:</b> ", $row["epost"] . "<br>";
        echo "<b>Tlf:</b> ", $row["tlf"] . "<br>";
        echo "</td>";
        $counter++;
        if ($counter % 5 == 0) {
            echo "</tr>";
        }
    }
}
echo "</table>"
?>


    <style>
        body {
            background-color: aliceblue;
        }

        #button-container{
            margin-left: 77%;
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

        button{
            width: 13vw;
            cursor: pointer;
        }

        table {
            margin-left: auto;
            margin-right: auto;
            margin-top: 1%;
            border-collapse: separate;
            border-spacing: 10px;
            border: 2px solid black;
            background-color: white;
        }

        td {
            border: 2px solid black;
        }
    </style>
    <?php
    include 'footer.php';
    ?>
    </body>
</html>