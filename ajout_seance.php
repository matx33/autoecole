<html>
<head>
    <meta charset="utf-8" lang="fr">
    <title>Ajout Séance</title>
    <link rel="stylesheet" href="projet.css">
</head>
<body>
    <div class="main-container">
        <h1>Page de traitement de l'ajout d'une séance</h1>
        <?php
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92a051';

        $dbpass = 'F3fBEkGco8eD';
        $dbname = 'nf92a051';

        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
        mysqli_set_charset($connect, 'utf8'); // les données envoyées vers mysql sont encodées en UTF-8
        $query = "SELECT * FROM themes WHERE supprime=0";

        //echo "<br> la valeur de query : $query <br>";

        $result = mysqli_query($connect, $query);
        if (!$result) {
            echo "<br>pas bon" . mysqli_error($connect);
            exit();
        }
        echo "<form method='POST' action='ajouter_seance.php'>";
        echo "<select name='menuChoixTheme' size='4'>";
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
            echo "<option value='$row[0]'>$row[1]</option>";
        }
        echo "</select>";
        echo "<br><br>";
        echo "<br> Date séance <input type='date' name='DateSeance' required/>";
        echo "<br>";
        echo "<br> Effectif maximum <input type='number' name='EffMax' min='1' required/>";
        echo "<br>";
        echo "<input type='submit' value='Enregistrer séance'>";
        echo "</form>";
        include 'banniere.php';
        mysqli_close($connect);
        ?>
    </div>
</body>
</html>