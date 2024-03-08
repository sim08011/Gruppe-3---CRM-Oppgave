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

        
        $mysqli = new mysqli("localhost","root","","crm_database"); 
        
        if ($mysqli -> connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
    ?>

<?php
echo "<table>";
$counter = 0;
if ($result = $mysqli->query("SELECT * FROM kunde")) {
    echo "<tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<td>";
        echo "Navn: ", $row["navn"] . "<br>";
        echo "Postnummer: ", $row["postSted_postnummer"] . "<br>";
        echo "Epost: ", $row["epost"] . "<br>";
        echo "Tlf: ", $row["tlf"] . "<br>";
        echo "</td>";
        $counter++;
        if ($counter % 5 == 0) {
            echo "</tr><tr>";
        }
    }
    echo "</tr>";
}
echo "</table>";
?>

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