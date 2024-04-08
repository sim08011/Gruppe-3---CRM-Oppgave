<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Kontaktperson</title>
</head>
<body>
<?php
    include 'nav.php';
    include 'connection.php';
    $ID = isset($_GET['ID']) ? $_GET['ID'] : null; // Check if ID parameter exists in the URL
    if(isset($_SESSION['authenticated']) && $_SESSION['authenticated'] == true){echo "<style>button{display: inline}</style>";} else{echo "<style>button{display: none}</style>";}
    if($ID !== null) {
?>  
    <main>
    <div id="buttonOgTable-container">
            <button type="button" name="toggleButton" id="toggleButton">Merk</button> <!-- Knapp for å merkere -->
            <button id="LeggtilKnapp">Legg til</button> <!-- Knapp for å Legge til bedrift -->
            <button id="Redigerknapp">Rediger</button> <!-- Knapp for å redigere -->
            <button id="SlettKnapp">Slett</button> <!-- Knapp for å slette -->
<?php
    echo "<table>";
    if ($result = $mysqli->query("SELECT kontaktperson.*, kunde.navn AS kunde_navn FROM kontaktperson INNER JOIN kunde ON kontaktperson.kundeID = kunde.kundeID WHERE kontaktperson.kundeID = $ID")) {
        if ($result->num_rows > 0) { // Change this line to check if there are rows returned
            $rad = $result->fetch_assoc(); // Fetching the first row
            $kunde_navn = $rad["kunde_navn"]; // Store the value of kunde.navn
            $counter = 0;
            echo "<h1>$kunde_navn </h1>"; // Output the value of kunde.navn
            do {
                if ($counter % 5 == 0) {    
                    echo "<tr>"; // Start a new row every five elements
                }
                $kontaktID = $rad['kontaktpersonID']; //Henter kundeID
                echo "<td class='td-link' data-kontaktid='$kontaktID'>";
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
    } else {
        echo "<p>Missing ID parameter in the URL.</p>";
    }
?>

<?php
    include 'footer.php';
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var markMode = false; // Lager en variabel for om markeringsmodus er på eller ikke
    var selectedKundeIDs = []; // Array med idene til kundene som er markerte

    var tds = document.querySelectorAll('.td-link'); //
    tds.forEach(function(td) { // For hver td
        td.addEventListener('click', function() { // Funksjon for når du klikker på en kunde
            if (markMode) { // Sjekker om du har klikket på merk knapp
                document.getElementById("Redigerknapp").style.display = "inline"; //Endrer synligheten for Rediger knapp
                document.getElementById("SlettKnapp").style.display = "inline"; //Endrer synligheten for Rediger knapp

                if (td.classList.contains('markedColor')) { //Hvis td har fargen som er markerings farge
                    td.classList.remove('markedColor'); //Fjerner fargen på td
                    td.style.backgroundColor = '';

                    var kundeIDIndex = selectedKundeIDs.indexOf(td.getAttribute('data-kontaktid'));
                    if (kundeIDIndex !== -1) {
                        selectedKundeIDs.splice(kundeIDIndex, 1);
                    }
                } else {
                    td.classList.add('markedColor'); //Hvis den ikke er markert marker den
                    td.style.backgroundColor = '#f0f8ff'; // Sett bakgrunns farge

                    // Legg til kundeID i array
                    var kundeID = td.getAttribute('data-kontaktid'); // Change 'data-kundeid' to 'data-kontaktid'
                    selectedKundeIDs.push(kundeID); 
                }
                console.log('Selected kundeIDs:', selectedKundeIDs); //Printer ut (Bare for å sjekke at det fungerer)
            }
        });

    });


    document.getElementById('Redigerknapp').addEventListener('click', function() {
    // Lager en url med alle kundeID som ligger i array
    var url = 'editContact.php?kontaktIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs)) + '&ID=' + encodeURIComponent(<?php echo $ID; ?>);
    // Sender deg til riktig sted med urlen
    window.location.href = url;
});
    document.getElementById('SlettKnapp').addEventListener('click', function() {
    // Construct the URL with both IDs
    var url = 'deleteContact.php?kontaktIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs)) + '&ID=' + encodeURIComponent(<?php echo $ID; ?>);
    // Redirect to the appropriate URL
    window.location.href = url;
});
document.getElementById('LeggtilKnapp').addEventListener('click', function() {
    // Construct the URL with both IDs
    var url = 'addContact.php?ID=' + encodeURIComponent(<?php echo $ID; ?>);
    // Redirect to the appropriate URL
    window.location.href = url;
});

    document.getElementById('toggleButton').addEventListener('click', function() {
        markMode = !markMode; // Skrur på merkerings modus
        if (markMode) {
            this.textContent = 'Avbryt'; // Hvis du har klikket på teksten endre knapp tekst til avbryt
        } else {
            this.textContent = 'Merk'; // Endre den til Merk hvis du avbryter
            document.getElementById("Redigerknapp").style.display="none"; //Skjuler Rediger knapp hvis du avbryter
            document.getElementById("SlettKnapp").style.display="none";
            // Resetter alle markerte td
            tds.forEach(function(td) {
                td.classList.remove('markedColor');
                td.style.backgroundColor = ''; // Resetter fargen til tdene 
            });
            selectedKundeIDs = []; // Fjerner alle kundeID'er fra array
        }
    });
});
</script>





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
    h1 {
        text-align: center;
    }
    p {
        font-size: small;
    }

    td {
        border: 2px solid black;
    }

    #buttonOgTable-container{
            margin: auto;
            max-width: 75%;
            margin-top: 3%;
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
            width: 13vw;
            cursor: pointer;
        }
</style>
