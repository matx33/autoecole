<html>
    <head>
        <meta charset="utf-8" lang="fr">
        <title>Ajouter Séance</title>
        <link rel="stylesheet" href="projet.css">
    </head>
    <body>
        <div class="main-container">
            <br>
            <h1>Séances de code non-effectuées par l'élève</h1>
            <?php
            // Connexion à la base de données
            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a051';
            $dbpass = 'F3fBEkGco8eD';
            $dbname = 'nf92a051';

            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
            mysqli_set_charset($connect, 'utf8'); // Les données envoyées vers MySQL sont encodées en UTF-8

            if (isset($_POST['ideleve'])) {
                $ideleve = $_POST['ideleve'];
            
                $query = "SELECT themes.nom, seances.DateSeance, inscription.ideleve, inscription.note
                          FROM themes
                          JOIN seances ON themes.idtheme = seances.idtheme
                          LEFT JOIN inscription ON seances.idseance = inscription.idseance AND inscription.ideleve = $ideleve
                          WHERE seances.DateSeance >= CURDATE() AND inscription.ideleve = $ideleve";
                //echo "<br> La valeur de query pour récupération des séances : $query";
                $result = mysqli_query($connect, $query);
                if (!$result) {
                    echo "Erreur lors de la récupération des séances : " . mysqli_error($connect);
                } elseif (mysqli_num_rows($result) == 0) {
                    echo "<br><b>L'élève a effectué toutes les séances de code auxquelles il/elle est inscrit(e).</b>";
                } else {
                    echo "<br><b>Les séances de code non-effectuées par l'élève sont :</b><br>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<br>" . htmlspecialchars($row['nom']) . " le " . htmlspecialchars($row['DateSeance']);
                    }
                }
            } else {
                echo "Erreur : Aucun élève sélectionné.";
            }
            
            mysqli_close($connect);
            ?>
        </div>
        <?php include 'banniere.php'; ?>
    </body>
</html>