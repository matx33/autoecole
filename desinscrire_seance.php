<html>
  <head>
    <meta charset="utf-8">
    <title>Désinscription</title>
    <link rel="stylesheet" href="projet.css">
  </head>
  <body>
    <div class="main-container">
      <br>
      <h1>Page de traitement de la désinscription d'un élève d'une séance</h1>

      <?php
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92a051';
        $dbpass = 'F3fBEkGco8eD';
        $dbname = 'nf92a051';

        // Connexion à la base de données
        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
        mysqli_set_charset($connect, 'utf8');

        // Vérification si une sélection a été faite
        if (isset($_POST['selection'])) {
            list($ideleve, $idseance) = explode('|', $_POST['selection']);// pour recuperer ideleve et idseance (separe les valeurs avec le |)

            // Supprimer l'élève de la séance dans la table inscription
            $query = "DELETE FROM inscription WHERE ideleve = $ideleve AND idseance = $idseance";
            $result = mysqli_query($connect, $query);

            if (!$result) {
                echo "Erreur lors de la suppression de l'élève : " . mysqli_error($connect);
            } else {
                echo "Désinscription réussie !";
            }
        } else {
            echo "Erreur : Aucun élève sélectionné et aucune séance sélectionnée.";
        }

        // Fermeture de la connexion
        mysqli_close($connect);
      ?>
    </div>
    <?php include 'banniere.php'; ?>
  </body>
</html>