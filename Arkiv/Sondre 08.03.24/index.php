<?php
$mysqli = new mysqli("localhost","root","","csv_db 10"); 
        
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "csv_db 10";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM poststed";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo $row["postnummer"]. " " . $row["poststed"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();