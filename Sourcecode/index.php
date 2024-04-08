<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Hovedside</title>
</head>
<body>
<main>
    <?php
        include 'nav.php';
        include 'header.php';
        include 'connection.php';
        if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){
            echo "<style>button{display: inline}</style>";
        } else{
            echo "<style>button{display: none}</style>";
        }
    ?>
    <div id="buttonOgTable-container">
        <button type="button" name="toggleButton" id="toggleButton">Merk</button> <!-- Knapp for å merkere -->
        <a href="add.php"><button id="LeggtilKnapp">Legg til</button></a> <!-- Knapp for å Legge til bedrift -->
        <button id="Redigerknapp">Rediger</button> <!-- Knapp for å redigere -->
        <button id="SlettKnapp">Slett</button> <!-- Knapp for å slette -->
        <?php
            echo "<table class='bordered-table'>"; // Lager en ny table for alle bedriftene
            $counter = 0; // Antall bedrifter på en linje
            echo "<tr>"; // Starter en ny rekke 
            if ($result = $mysqli->query("SELECT kunde.*, postnummer.poststed AS poststed FROM kunde
                                    LEFT JOIN postnummer ON kunde.postnummer = postnummer.postnummer")) { // Henter all informasjon samt Postnummer og Poststed
                while ($row = $result->fetch_assoc()) { 
                    if ($counter % 5 == 0 && $counter != 0) { // Setter en maks grense på 5 for hver linje
                        echo "</tr><tr>"; // Starter en ny linje for hver femte bedrift
                    }
                    $kundeID = $row['kundeID']; //Henter kundeID
                    echo "<td class='td-link' data-kundeid='$kundeID'>"; //Lager en ny td for hver bedrift
                    echo "<b>Navn:</b> ", $row["navn"] . "<br>"; //Printer ut navn
                    echo "<b>Postnummer:</b> ", $row["postnummer"]. ", " . $row["poststed"] . "<br>"; // Printer ut poststed
                    echo "<b>Epost:</b> ", $row["epost"] . "<br>"; // Printer ut epost
                    echo "<b>Tlf:</b> ", $row["tlf"] . "<br>"; // Printer ut telefon nummer
                    echo "</td>"; // Avslutter td for bedriften
                    $counter++; // Legger til 1 for hver bedrift
                }
            }
            echo "</tr>"; // Avslutter rekke etter 5 bedrifter
            echo "</table>"; // Avslutter table
        ?>
    </div>
</main>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var markMode = false; // Variable to track marking mode
        var selectedKundeIDs = []; // Array to store selected customer IDs

        // Function to toggle marking mode
        function toggleMarkMode() {
            markMode = !markMode; // Toggle marking mode

            // Update button text based on marking mode
            var toggleButton = document.getElementById('toggleButton');
            toggleButton.textContent = markMode ? 'Avbryt' : 'Merk';

            // Show or hide "Rediger" and "Slett" buttons based on marking mode and selected IDs
            var redigerButton = document.getElementById('Redigerknapp');
            var slettButton = document.getElementById('SlettKnapp');
            if (markMode || selectedKundeIDs.length > 0) {
                redigerButton.style.display = 'inline';
                slettButton.style.display = 'inline';
            } else {
                redigerButton.style.display = 'none';
                slettButton.style.display = 'none';
            }

            // Reset selected customer IDs and clear markings if marking mode is toggled off
            if (!markMode) {
                selectedKundeIDs = [];
                var tds = document.querySelectorAll('.td-link');
                tds.forEach(function(td) {
                    td.classList.remove('markedColor');
                    td.style.backgroundColor = '';
                });
            }
        }

        // Event listener for "Merk" button to toggle marking mode
        document.getElementById('toggleButton').addEventListener('click', toggleMarkMode);

        // Event listener for clicking on customer rows
        var tds = document.querySelectorAll('.td-link');
        tds.forEach(function(td) {
            td.addEventListener('click', function() {
                if (markMode) {
                    // Toggle marking of customer row
                    if (td.classList.contains('markedColor')) {
                        td.classList.remove('markedColor');
                        td.style.backgroundColor = '';
                        var kundeIDIndex = selectedKundeIDs.indexOf(td.getAttribute('data-kundeid'));
                        if (kundeIDIndex !== -1) {
                            selectedKundeIDs.splice(kundeIDIndex, 1);
                        }
                    } else {
                        td.classList.add('markedColor');
                        td.style.backgroundColor = '#DBEEFF';
                        var kundeID = td.getAttribute('data-kundeid');
                        selectedKundeIDs.push(kundeID);
                    }

                    // Log selected customer IDs
                    console.log('Selected kundeIDs:', selectedKundeIDs);
                } else {
                    window.location.href = 'les.php?ID=' + td.getAttribute("data-kundeid");
                }
            });
        });

        // Event listener for "Rediger" button
        document.getElementById('Redigerknapp').addEventListener('click', function() {
            // Redirect to the appropriate URL with the selected customer IDs
            var url = 'rediger.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
            window.location.href = url;
        });

        // Event listener for "Slett" button
        document.getElementById('SlettKnapp').addEventListener('click', function() {
            // Redirect to the appropriate URL with the selected customer IDs
            var url = 'slett.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
            window.location.href = url;
        });
    });
</script>
</main>
<?php
    include 'footer.php';
?>
</body>
</html>


    <style>
        *{
            margin: 0;
            padding: 0;
        }

        body {
            background-color: aliceblue;
        }

        #buttonOgTable-container{
            margin: auto;
            max-width: 75%;
        }

        #LeggtilKnapp{
            width: 6%;
            background-color: #57B35E;
            color: white;
        }

        #Redigerknapp {
            width: 6%;
            background-color: #3262ab;
            color: white;
            display: none;
        }

        #SlettKnapp {
            width: 6%;
            background-color: #BD0000;
            color: white;
            display: none;
        }

        #toggleButton{
            width: 6%;
            background-color: grey;
            color: white;

        }

        button{
            width: 6%;
            cursor: pointer;
        }

        table {
            margin-top: 1%;
            border-collapse: separate;
            border-spacing: 10px;
            border: 2px solid black;
            background-color: white;
            margin-bottom: 50px;
        }

        td {
            border: 2px solid black;
            cursor: pointer;
        }
        a {
            text-decoration: none;
        }
    </style>
