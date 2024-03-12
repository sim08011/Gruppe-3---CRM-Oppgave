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

<?php
echo "<table>";
$counter = 0;
if ($result = $mysqli->query("SELECT kunde.*, poststed.poststed FROM kunde
                              LEFT JOIN poststed ON kunde.postSted = poststed.postnummer")) {
    while ($row = $result->fetch_assoc()) {
        if ($counter % 5 == 0) {
            echo "<tr>"; // Start a new row every five elements
        }
        echo "<td style='cursor: pointer;' onclick=\"window.location='';\">";
        echo "Navn: ", $row["navn"] . "<br>";
        echo "Postnummer: ", $row["postSted"]. ", " . $row["poststed"] . "<br>";
        echo "Epost: ", $row["epost"] . "<br>";
        echo "Tlf: ", $row["tlf"] . "<br>";
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
        button{
            width: 13vw;
        }

        table {
            margin-top: 6%;
            margin-left: auto;
            margin-right: auto;
            border-style: solid;
            border-width: 2px;
            border-color: black;
        }
    </style>
    <?php
    include 'footer.php';
    ?>
    </body>
</html>