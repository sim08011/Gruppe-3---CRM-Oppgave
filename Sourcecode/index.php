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
    <div id="button-container">
        <button type="button" name="toggleButton" id="toggleButton">Merk</button>
        <button id="Redigerknapp">Rediger</button>
        <a href="add.php"><button id="LeggtilKnapp">Legg til</button></a>
    </div>
<?php
    echo "<table class='bordered-table'>";
    $counter = 0;
    echo "<tr>"; // Start a new row
    if ($result = $mysqli->query("SELECT kunde.*, postnummer.poststed AS poststed FROM kunde
                                LEFT JOIN postnummer ON kunde.postnummer = postnummer.postnummer")) {
        while ($row = $result->fetch_assoc()) {
            if ($counter % 5 == 0 && $counter != 0) {    
                echo "</tr><tr>"; // Start a new row every five elements
            }
            // Assuming 'kundeID' is one of the fields in the database
            $kundeID = $row['kundeID'];
            // Output the <td> with the kundeID as a data attribute
            echo "<td class='td-link' data-kundeid='$kundeID'>";
            // Output other information within the <td>
            echo "<b>Navn:</b> ", $row["navn"] . "<br>";
            echo "<b>Postnummer:</b> ", $row["postnummer"]. ", " . $row["poststed"] . "<br>";
            echo "<b>Epost:</b> ", $row["epost"] . "<br>";
            echo "<b>Tlf:</b> ", $row["tlf"] . "<br>";
            echo "</td>"; // Close <td> tag
            $counter++;
        }
    }
    echo "</tr>"; // Close the last row
    echo "</table>";
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var markMode = false; // Variable to track mark mode
    var selectedKundeIDs = []; // Array to store selected kundeIDs

    var tds = document.querySelectorAll('.td-link');
    tds.forEach(function(td) {
        td.addEventListener('click', function() {
            if (markMode) { // Check if mark mode is active
                if (td.classList.contains('markedColor')) {
                    td.classList.remove('markedColor');
                    td.style.backgroundColor = '#f0f8ff'; // Reset background color
                    // Remove kundeID from array when deselected
                    var kundeIDIndex = selectedKundeIDs.indexOf(td.getAttribute('data-kundeid'));
                    if (kundeIDIndex !== -1) {
                        selectedKundeIDs.splice(kundeIDIndex, 1);
                    }
                } else {
                    td.classList.add('markedColor');
                    td.style.backgroundColor = '#f0f8ff'; // Change background color to yellow
                    // Add kundeID to array when selected
                    var kundeID = td.getAttribute('data-kundeid');
                    selectedKundeIDs.push(kundeID);
                }
                // Log selected kundeIDs array
                console.log('Selected kundeIDs:', selectedKundeIDs);
            } else {
                window.location.href = 'les.php?ID=<?php echo $kundeID?>';

            }
        });
    });

    document.getElementById('Redigerknapp').addEventListener('click', function() {
    // Construct the URL with selected kundeIDs as parameters
    var url = 'rediger.php?kundeIDs=' + encodeURIComponent(JSON.stringify(selectedKundeIDs));
    // Log the constructed URL
    console.log('Constructed URL:', url);
    // Redirect to rediger.php
    window.location.href = url;
    // Log a message after the redirection
    console.log('After redirection');
});

    document.getElementById('toggleButton').addEventListener('click', function() {
        markMode = !markMode; // Toggle mark mode
        if (markMode) {
            this.textContent = 'Avbryt'; // Change button text
        } else {
            this.textContent = 'Merk'; // Change button text
            // Reset all marked colors and styles
            tds.forEach(function(td) {
                td.classList.remove('markedColor');
                td.style.backgroundColor = ''; // Reset background color
            });
            selectedKundeIDs = []; // Clear the selected IDs array
        }
        // Log mark mode status
        console.log('Mark mode:', markMode);
    });
});

</script>

<?php
    include 'footer.php';
?>
</body>
</html>


    <style>
        body {
            background-color: aliceblue;
        }

        #button-container{
            margin-left: 73%;
        }

        #LeggtilKnapp{
            width: 5vw;
            background-color: #3262ab;
            color: white;
        }

        #Redigerknapp {
            width: 5vw;
            background-color: #BD0000;
            color: white;
            position: relative;
        }

        #toggleButton{
            width: 4vw;
            background-color: grey;
            color: white;

        }

        button{
            width: 13vw;
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
