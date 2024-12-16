<html>
    <head>
        <title>Noter les Élèves</title>
        <link rel="stylesheet" href="projet.css">
    </head>
    <body>
        <div class="main-container">
            <h1>Enregistrement des Notes</h1>
            <?php
                $dbhost = 'tuxa.sme.utc';
                $dbuser = 'nf92a051';
                $dbpass = 'F3fBEkGco8eD';
                $dbname = 'nf92a051';

                $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Erreur de connexion à la base de données');
                mysqli_set_charset($connect, 'utf8');

                $idseance = $_POST['idseance'];

                if (!isset($_POST['note']) || empty($_POST['note'])) {
                    echo "<br>Erreur : aucune note n'a été saisie.";
                    mysqli_close($connect);
                    exit();
                }

                $notes = $_POST['note'];

                foreach ($notes as $ideleve => $note) {                
                    // Vérifier si la note est valide
                    if (!is_numeric($note)) {
                        echo "<br>Note invalide pour l'élève avec ID $ideleve.";
                        exit(); 
                    }
                    if ($note < 0 || $note > 40) {
                        echo "<br>Note invalide pour l'élève avec ID $ideleve : la note doit être comprise entre 0 et 40.";
                        exit(); 
                    }
                
                    // Récupérer les informations de l'élève
                    $query_np = "SELECT nom, prenom FROM eleves WHERE ideleve = $ideleve";
                    //echo "<br> la valeur de query_np : $query_np <br>";
                    $result_np = mysqli_query($connect, $query_np);
                
                    if (!$result_np) {
                        echo "Erreur lors de l'exécution de la requête pour récupérer les informations de l'élève : " . mysqli_error($connect);
                        exit(); 
                    }
                
                    if ($row = mysqli_fetch_assoc($result_np)) {
                        $nom = htmlspecialchars($row['nom']);
                        $prenom = htmlspecialchars($row['prenom']);
                    } else {
                        echo "Aucun élève trouvé avec l'ID $ideleve.";
                        exit();
                    }
                
                    // Mettre à jour la note de l'élève
                    $query_update = "UPDATE inscription SET note = 40-$note WHERE ideleve = $ideleve AND idseance = $idseance";
                    //echo "<br> la valeur de query_update : $query_update <br>";
                    $result_update = mysqli_query($connect, $query_update);
                
                    if (!$result_update) {
                        echo "<br>Erreur lors de la mise à jour de la note pour $nom $prenom : " . mysqli_error($connect);
                    } else {
                        $note = 40-$note;
                        echo "<br>Note enregistrée pour $nom $prenom : $note/40.";
                    }
                }
                mysqli_close($connect);
            ?>
        </div>
    </body>
</html>