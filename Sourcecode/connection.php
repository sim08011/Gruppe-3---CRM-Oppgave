<?php
// Oppretter en tilkobling til databasen
$mysqli = new mysqli("localhost", "root", "", "crm_database");

// Sjekker om tilkoblingen feiler
if ($mysqli->connect_errno) {
    echo "Feilet med å koble til databasen: " . $mysqli->connect_error; // Viser feilmelding hvis tilkoblingen mislykkes
    exit(); // Avslutter skriptet
}
?>
