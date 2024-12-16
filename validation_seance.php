<html>
<head>
    <meta charset="utf-8" lang="fr">
    <title>Validation d'une séance</title>
    <link rel="stylesheet" href="projet.css">
</head>
<body>
    <div class="main-container">
        <h1>Validation d'une séance</h1>
        <form method="post" action="valider_seance.php">
        <label for="seance">Choisissez une séance:</label>
        <select name="idseance" id="seance">
            <?php
                $dbhost = 'tuxa.sme.utc';
                $dbuser = 'nf92a051';

                $dbpass = 'F3fBEkGco8eD';
                $dbname = 'nf92a051';

                $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
                mysqli_set_charset($connect, 'utf8'); // les données envoyées vers mysql sont encodées en UTF-8
                echo "Début de script";
                //$query = "SELECT * FROM seances WHERE DateSeance < CURDATE()";
                $query = "SELECT seances.idseance, seances.DateSeance, themes.nom AS themeNom 
                          FROM seances 
                          JOIN themes ON seances.Idtheme = themes.idtheme
                          JOIN inscription ON seances.idseance = inscription.idseance
                          WHERE seances.DateSeance < CURDATE()
                          GROUP BY seances.idseance
                          HAVING COUNT(inscription.ideleve) > 0";
                        
                //echo "$query";
                $result = mysqli_query($connect, $query);
                if (!$result) {
                    echo "Erreur lors de la récupération des données : " . mysqli_error($connect);
                }
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='".$row['idseance']."'>".$row['themeNom']." ".$row['DateSeance']."</option>";
                }
            ?>
        </select>
        <br><br>
        <input type="submit" value="Valider la séance">
    </form>
    </div>
    <?php include 'banniere.php'; ?>
  </body>
</html>
        