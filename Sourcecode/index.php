<?php
session_start();
if($_SESSION["authenticated"] == true){
    echo "<style>#button-container{display: inline}</style>";
}
else{
    echo "<style>#button-container{display: none}</style>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bitnami.css">
    <title>Hovedside</title>
</head>
<body>

    <?php
        include 'nav.php';
        include 'header.php';
        include 'connection.php'
    ?>
<div id="buttonOgTable-container">
    <button type="button" name="toggleButton" id="toggleButton">Merk</button> <!-- Knapp for å merkere -->
    <button id="Redigerknapp">Rediger</button> <!-- Knapp for å redigere -->
    <button id="SlettKnapp">Slett</button> <!-- Knapp for å slette -->
    <a href="add.php"><button id="LeggtilKnapp">Legg til</button></a> <!-- Knapp for å Legge til bedrift -->
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

                    // Fjerner kundeID fra array 
                    var kundeIDIndex = selectedKundeIDs.indexOf(td.getAttribute('data-kundeid'));
                    if (kundeIDIndex !== -1) {
                        selectedKundeIDs.splice(kundeIDIndex, 1);
                    }
                } else {
                    td.classList.add('markedColor'); //Hvis den ikke er markert marker den
                    td.style.backgroundColor = '#f0f8ff'; // Sett bakgrunns farge

                    // Legg til kundeID i array
                    var kundeID = td.getAttribute('data-kundeid');
                    selectedKundeIDs.push(kundeID);
                }
                console.log('Selected kundeIDs:', selectedKundeIDs); //Printer ut (Bare for å sjekke at det fungerer)
            } else {
                //Lager en ny url med kundeID slik at den printer ut riktig informasjon
                window.location.href = 'les.php?ID=' + td.getAttribute("data-kundeid");
            }
        });

    });


    document.getElementById('Redigerknapp').addEventListener('click', function() {
    // Lager en url med alle kundeID som ligger i array
    var url = 'rediger.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
    // Sender deg til riktig sted med urlen
    window.location.href = url;
});
    document.getElementById('SlettKnapp').addEventListener('click', function() {
    // Lager en url med alle kundeID som ligger i array
    var url = 'slett.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
    // Sender deg til riktig sted med urlen
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

<?php
    include 'footer.php';
?>
</body>
</html>


    <style>
        main {
            height: 100vh;
        }

        body {
            background-color: aliceblue;
        }

        #buttonOgTable-container{
            margin: auto;
            max-width: 80%;
        }

        #LeggtilKnapp{
            width: 6%;
            background-color: #3262ab;
            color: white;
        }

        #Redigerknapp {
            width: 6%;
            background-color: #BD0000;
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
            margin-left: auto;
            margin-right: auto;
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
    </style>
