<html>
    <head>
        <meta charset="utf-8" lang="fr">
        <title>Ajouter Séance</title>
        <link rel="stylesheet" href="projet.css">
    </head>
    <body>
        <div class="main-container">
            <br>
            <h1>Page d'ajout d'une séance</h1>
            <?php
            // Connexion à la base de données
            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a051';
            $dbpass = 'F3fBEkGco8eD';
            $dbname = 'nf92a051';

            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
            mysqli_set_charset($connect, 'utf8'); // Les données envoyées vers MySQL sont encodées en UTF-8

            // Récupération des entrées du formulaire
            $idtheme = $_POST['menuChoixTheme'] ?? null;
            $DateSeance = $_POST['DateSeance'] ?? null;
            $EffMax = $_POST['EffMax'] ?? null;

            // Vérifications des entrées
            if (empty($idtheme) || empty($DateSeance) || empty($EffMax)) {
                echo "<b>Erreur</b> : Tous les champs doivent être remplis.";
                exit();
            }

            if (!is_numeric($EffMax) || $EffMax <= 0 || intval($EffMax) != $EffMax) {
                echo "<b>Erreur</b> : Vous n'avez pas rentré un nombre acceptable pour l'effectif maximum.";
                exit();
            }

            $currentDate = date('Y-m-d'); // YYYY-MM-DD
            if ($DateSeance < $currentDate) {
                echo "<b>Erreur</b> : La date de la séance ne peut pas être antérieure à la date du jour.";
                exit();
            }

            // Vérification s'il existe déjà une séance avec le même thème à la même date
            $query_meme_date = "SELECT * FROM seances WHERE DateSeance='$DateSeance' AND idtheme='$idtheme'";
            //echo "<br> La valeur de query pour vérification : $query_meme_date";

            $result_meme_date = mysqli_query($connect, $query_meme_date);
            if (!$result_meme_date) {
                echo "<br>Erreur lors de la vérification : " . mysqli_error($connect);
                exit();
            }

            $meme_date = mysqli_num_rows($result_meme_date);
            if ($meme_date == 0) {
                $queryu = "INSERT INTO seances (idseance, DateSeance, EffMax, Idtheme) VALUES (NULL, '$DateSeance', $EffMax, '$idtheme')";
                //echo "<br> La valeur de query pour insertion : $queryu";

                $resultu = mysqli_query($connect, $queryu);
                if (!$resultu) {
                    echo "<br>Erreur lors de l'ajout de la séance : " . mysqli_error($connect);
                } else {
                    echo "<br> La séance a été ajoutée avec succès.";
                }
            } else {
                // Séance existe déjà
                echo "<br><b>Erreur</b>: Une séance existe déjà pour cette date et ce thème.";
                exit();
            }
            echo "<br> L'ID du theme : $idtheme";
            echo "<br> La date de la séance : $DateSeance";
            echo "<br> L'effectif maximum' : $EffMax";

            mysqli_close($connect);
            ?>
        </div>  
        <?php include 'banniere.php'; ?>  
    </body>
</html>