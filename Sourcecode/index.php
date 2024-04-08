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
        include 'nav.php'; // Inkluderer navigasjonsmenyen
        include 'header.php'; // Inkluderer overskriften
        include 'connection.php'; // Inkluderer databaseforbindelsen
        if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){
            echo "<style>button{display: inline}</style>"; // Hvis brukeren er autentisert, vis knappene
        } else{
            echo "<style>button{display: none}</style>"; // Ellers skjul knappene
        }
    ?>
    <div id="buttonAndTable-Container">
        <button type="button" name="toggleButton" id="toggleButton">Merk</button> <!-- Knapp for å merke -->
        <a href="add.php"><button id="addButton">Legg til</button></a> <!-- Knapp for å legge til bedrift -->
        <button id="editButton">Rediger</button> <!-- Knapp for å redigere -->
        <button id="deleteButton">Slett</button> <!-- Knapp for å slette -->
        <?php
            echo "<table class='bordered-table'>"; // Oppretter en ny tabell for alle bedriftene
            $counter = 0; // Antall bedrifter på en linje
            echo "<tr>"; // Starter en ny rekke
            if ($result = $mysqli->query("SELECT kunde.*, postnummer.poststed AS poststed FROM kunde
                                    LEFT JOIN postnummer ON kunde.postnummer = postnummer.postnummer")) { // Henter all informasjon samt Postnummer og Poststed
                while ($row = $result->fetch_assoc()) {
                    if ($counter % 5 == 0 && $counter != 0) { // Setter en maks grense på 5 for hver linje
                        echo "</tr><tr>"; // Starter en ny linje for hver femte bedrift
                    }
                    $kundeID = $row['kundeID']; // Henter kundeID
                    echo "<td class='td-link' data-kundeid='$kundeID'>"; // Lager en ny td for hver bedrift
                    echo "<b>Navn:</b> ", $row["navn"] . "<br>"; // Skriver ut navn
                    echo "<b>Postnummer:</b> ", $row["postnummer"]. ", " . $row["poststed"] . "<br>"; // Skriver ut poststed
                    echo "<b>Epost:</b> ", $row["epost"] . "<br>"; // Skriver ut epost
                    echo "<b>Tlf:</b> ", $row["tlf"] . "<br>"; // Skriver ut telefonnummer
                    echo "</td>"; // Avslutter td for bedriften
                    $counter++; // Legger til 1 for hver bedrift
                }
            }
            echo "</tr>"; // Avslutter rekke etter 5 bedrifter
            echo "</table>"; // Avslutter tabellen
        ?>
    </div>
</main>
<script>
    // JavaScript-kode for å håndtere merkingsmodus og knappevisning
    document.addEventListener('DOMContentLoaded', function() {
        var markMode = false; // Variabel for å spore merkingsmodus
        var selectedKundeIDs = []; // Array for å lagre valgte kunde-ID-er

        // Funksjon for å bytte merkingsmodus og oppdatere knappevisning
        function toggleMarkMode() {
            markMode = !markMode; // Bytt merkingsmodus

            // Oppdater knappetekst basert på merkingsmodus
            var toggleButton = document.getElementById('toggleButton');
            toggleButton.textContent = markMode ? 'Avbryt' : 'Merk';

            // Oppdater knappevisning
            updateButtonVisibility();

            // Tilbakestill valgte kunde-ID-er og fjern markeringer hvis merkingsmodus er slått av
            if (!markMode) {
                selectedKundeIDs = [];
                var tds = document.querySelectorAll('.td-link');
                tds.forEach(function(td) {
                    td.classList.remove('markedColor');
                    td.style.backgroundColor = '';
                });

                updateButtonVisibility();
            }
        }

        // Funksjon for å sjekke om det er valgte kunde-ID-er og oppdatere knappevisning
        function updateButtonVisibility() {
            var redigerButton = document.getElementById('editButton');
            var slettButton = document.getElementById('deleteButton');

            if (selectedKundeIDs.length === 0) {
                redigerButton.style.display = 'none';
                slettButton.style.display = 'none';
            } else {
                redigerButton.style.display = 'inline';
                slettButton.style.display = 'inline';
            }
        }

        // Hendelseslytter for "Merk" -knappen for å bytte merkingsmodus
        document.getElementById('toggleButton').addEventListener('click', toggleMarkMode);

        // Hendelseslytter for å klikke på kunderekker
        var tds = document.querySelectorAll('.td-link');
        tds.forEach(function(td) {
            td.addEventListener('click', function() {
                if (markMode) {
                    // Bytt merking av kunderekke
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

                    // Logg valgte kunde-ID-er
                    console.log('Selected kundeIDs:', selectedKundeIDs);

                    // Oppdater knappevisning etter merking
                    updateButtonVisibility();
                } else {
                    window.location.href = 'read.php?ID=' + td.getAttribute("data-kundeid");
                }
            });
        });

        // Hendelseslytter for "Rediger" -knappen
        document.getElementById('editButton').addEventListener('click', function() {
            // Videresend til riktig URL med de valgte kunde-ID-ene
            if (selectedKundeIDs.length === 0) {
                alert('Ingen id valgt for redigering.');
            } else {
                var url = 'edit.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
                window.location.href = url;
            }
        });

        // Hendelseslytter for "Slett" -knappen
        document.getElementById('deleteButton').addEventListener('click', function() {
            // Videresend til riktig URL med de valgte kunde-ID-ene
            if (selectedKundeIDs.length === 0) {
                alert('Ingen id valgt for sletting.');
            } else {
                var url = 'delete.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
                window.location.href = url;
            }
        });

        // Kall funksjonen for å skjule knappene initialt
        updateButtonVisibility();
    });
</script>

</main>
<?php
    include 'footer.php'; // Inkluderer bunnteksten
?>
</body>
</html>


<style>
    body {
        background-color: aliceblue;
    }

    #buttonAndTable-Container {
        margin: auto;
        max-width: 75%;
    }

    #addButton{
        width: 6%;
        background-color: #57B35E;
        color: white;
    }

    #editButton {
        width: 6%;
        background-color: #3262ab;
        color: white;
        display: none;
    }

    #deleteButton {
        width: 6%;
        background-color: #BD0000;
        color: white;
        display: none;
    }

    #toggleButton {
        width: 6%;
        background-color: grey;
        color: white;
    }

    button {
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
