<html>
  <head>
    <title>Valider la Séance</title>
    <link rel="stylesheet" href="projet.css">
  </head>
  <body>
  <div class="main-container">
    <h1>Valider la Séance Sélectionnée</h1>
    <?php
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92a051';
        $dbpass = 'F3fBEkGco8eD';
        $dbname = 'nf92a051';

        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
        mysqli_set_charset($connect, 'utf8');

        $idseance = $_POST['idseance'];

        // Si l'utilisateur souhaite modifier les notes après confirmation
        if (isset($_POST['modifier']) && $_POST['modifier'] === 'oui') {
            // Afficher le formulaire de saisie des notes
            echo "<h3>Entrez le nombre d'erreurs pour chaque élève</h3>";
            echo "<form method='post' action='noter_eleves.php'>";
            echo "<input type='hidden' name='idseance' value='$idseance'>";

            // Récupérer tous les élèves inscrits à cette séance
            $query = "SELECT eleves.ideleve, eleves.nom, eleves.prenom, inscription.note 
                      FROM inscription 
                      JOIN eleves ON inscription.ideleve = eleves.ideleve 
                      WHERE inscription.idseance = $idseance";
            //echo "<br> la valeur de query : $query <br>";
            $result = mysqli_query($connect, $query);

            // Parcourir chaque ligne de résultat de la requête
            while ($row = mysqli_fetch_array($result)) {
                // Vérifier si une note existe déjà pour cet élève
                $note = isset($row['note']) ? $row['note'] : "";
                $erreurs = $note !== "" ? 40 - $note : ""; // Calculer le nombre d'erreurs à partir de la note
            
                // Afficher le label avec le nom et le prénom de l'élève
                echo "<label>" . htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) . " :</label>";
            
                // Créer un champ de saisie pour le nombre d'erreurs de l'élève
                echo "<input type='number' name='note[" . htmlspecialchars($row['ideleve']) . "]' min='0' max='40' value='$erreurs'><br><br>";
            }

            echo "<input type='submit' value='Enregistrer les notes'>";
            echo "</form>";
        } 
        else if (isset($_POST['modifier']) && $_POST['modifier'] === 'non') {
            echo "<p>Vous avez choisi de ne pas modifier les notes de cette séance.</p>";
            echo "<a href='accueil.html'>Retour à l'accueil</a>";
            include 'banniere.php';
            mysqli_close($connect);
            exit();
        }
        else {
            // Vérifier si la séance a déjà été notée
            $query_check_note = "SELECT * FROM inscription WHERE note IS NOT NULL AND idseance = $idseance";
            $result_check_note = mysqli_query($connect, $query_check_note);

            if (!$result_check_note) {
                echo "<br>Erreur lors de la vérification des notes : " . mysqli_error($connect);
                exit();
            }

            if (mysqli_num_rows($result_check_note) > 0) {
                // La séance a déjà été notée, demander confirmation
                echo "<p>Cette séance a déjà été notée. Voulez-vous continuer et modifier les notes ?</p>";
                echo "<form method='post' action='valider_seance.php'>";
                echo "<input type='hidden' name='idseance' value='$idseance'>";
                echo "<input type='radio' name='modifier' value='oui' id='oui'><label for='oui'>Oui</label><br>";
                echo "<input type='radio' name='modifier' value='non' id='non' checked><label for='non'>Non</label><br><br>";
                echo "<input type='submit' value='Confirmer'>";
                echo "</form>";
            } else {
                // Si la séance n'a jamais été notée, continuer directement à la saisie
                echo "<h3>Entrez le nombre d'erreurs pour chaque élève</h3>";
                echo "<form method='post' action='noter_eleves.php'>";
                echo "<input type='hidden' name='idseance' value='$idseance'>";

                // Récupérer tous les élèves inscrits à cette séance
                $query = "SELECT eleves.ideleve, eleves.nom, eleves.prenom 
                          FROM inscription 
                          JOIN eleves ON inscription.ideleve = eleves.ideleve 
                          WHERE inscription.idseance = $idseance";
                //echo "<br> la valeur de query : $query <br>";
                $result = mysqli_query($connect, $query);

                // Parcourir chaque ligne de résultat de la requête
                while ($row = mysqli_fetch_array($result)) {
                    // Pas de note existante pour cette séance
                    $note = "";

                    echo "<label>" . htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) . " :</label>";

                    echo "<input type='number' name='note[" . htmlspecialchars($row['ideleve']) . "]' min='0' max='40' value='$note'><br><br>";
                }

                echo "<input type='submit' value='Enregistrer les notes'>";
                echo "</form>";
            }
        }
        mysqli_close($connect);
    ?>
    </div>
    <?php include 'banniere.php'; ?>
</body>
</html>