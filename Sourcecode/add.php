<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <main>
        <?php
            include 'nav.php';
        ?>  
        <table>
            <tr>
                <th><label for="navn">Navn/Firma</label></th>
                <th><label for="epost">Epost</label></th>
                <th><label for="tlf">Telefon</label></th>
            </tr>
            <tr>
                <td><input type="text" name="navn"></td>
                <td><input type="text" name="epost"></td>
                <td><input type="num" name="tlf" id=""></td>
            </tr>
        </table> 
    </main>


    <?php
        include 'footer.php'
    ?>
</body>
</html>

<style>
    table {
        margin-top: 10vh;
    }

    table, th, td {
        border: 1px solid black;
}
</style>
