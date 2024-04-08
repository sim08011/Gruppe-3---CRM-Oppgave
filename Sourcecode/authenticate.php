<?php
// Sjekker om brukeren ikke er autentisert
if ($_SESSION["authenticated"] == false) {
    header("Location: index.php"); // Omdirigerer til index.php hvis brukeren ikke er autentisert
}
?>
