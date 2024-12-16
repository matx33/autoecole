<html>
    <head>
        <meta charset="utf-8" lang="fr">
        <title>Consultation</title>
        <link rel="stylesheet" href="projet.css">
    </head>
    <body>
        <div class="main-container">
            <br>
            <h1>Consultation d'un élève</h1>
            <?php
            // Connexion à la base de données
            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a051';
            $dbpass = 'F3fBEkGco8eD';
            $dbname = 'nf92a051';

            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
            mysqli_set_charset($connect, 'utf8'); // Les données envoyées vers MySQL sont encodées en UTF-8

            if (isset($_POST['ideleve'])) {
                $ideleve = $_POST['ideleve'];  // Récupérer l'id du thème sélectionné
            
                echo "ID de l'élève consulté : " . $ideleve . "<br>";
            
                $query = "SELECT nom, prenom, dateNaiss, dateInscription FROM eleves WHERE ideleve = $ideleve";
                //echo "<br> la valeur de query : $query <br>";
            
                $result = mysqli_query($connect, $query);
                if (!$result) {
                    echo "Erreur lors de la consultation des eleves: " . mysqli_error($connect);
                } else {
                    echo "<table border='1'>";
                    echo "<tr><th>Nom</th><th>Prénom</th><th>Date de naissance</th><th>Date d'inscription</th></tr>";
                    while ($row = mysqli_fetch_array($result)) {
                        echo "<tr>";
                        echo "<td>".$row['nom']."</td>";
                        echo "<td>".$row['prenom']."</td>";
                        echo "<td>".$row['dateNaiss']."</td>";
                        echo "<td>".$row['dateInscription']."</td>";
                        echo "</tr>";
                    }
                }
            } else {
                echo "Erreur : Aucun élève sélectionner.";
            }
            mysqli_close($connect);
            ?>
        </div>
        <?php include 'banniere.php'; ?>
    </body>
</html>
            