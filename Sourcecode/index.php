<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>



    <?php
        include 'nav.php';
        include 'header.php';
        include 'connection.php'
    ?>

    <table>
    <?php
    if ($result = $mysqli -> query("SELECT * FROM kunde")) {
            while ($row = $result -> fetch_assoc()) {
                echo "<td>";
                echo "ID: ",$row["kundeID"]."<br>";
                echo "Navn: ",$row["navn"]."<br>";
                echo "Postnummer: ",$row["postSted_postnummer"]."<br>";
                echo "Epost: ",$row["epost"]."<br>";
                echo "Tlf: ",$row["tlf"]."<br>";
                echo "</td>";
            }
        }
    ?>
    </table>

    <style>
        table {
            margin-top: 6%;
            margin-left: auto;
            margin-right: auto;
            border-style: solid;
            border-width: 2px;
            border-color: black;
        }
    </style>
    
</body>
</html>