<html>
  <head>
    <meta charset="utf-8">
    <title>Inscrire un élève à une séance</title>
    <link rel="stylesheet" href="projet.css">
  </head>
  <body>
    <div class="main-container">
      <br>
      <h1>Page de traitement de l'inscription d'un élève à une séance</h1>
      <?php
        $dbhost = 'tuxa.sme.utc';
        $dbuser = 'nf92a051';
        $dbpass = 'F3fBEkGco8eD';
        $dbname = 'nf92a051';

        // Connexion à la base de données
        $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
        mysqli_set_charset($connect, 'utf8');

        $ideleve = $_POST['ideleve'];
        $idseance = $_POST['idseance'];

        // Vérification si l'inscription existe déjà
        $query_check = "SELECT * FROM inscription WHERE ideleve = $ideleve AND idseance = $idseance";
        //echo "<br> la valeur de query : $query_check <br>";
        $result_check = mysqli_query($connect, $query_check);

        if (mysqli_num_rows($result_check) > 0) {
          echo "<br><b>Erreur</b>: L'élève est déjà inscrit à cette séance.";
          exit();
        } 
        if (empty($ideleve) || empty($idseance)) {
          echo "Erreur : veuillez sélectionner un élève et une séance.";
        }

        $query_check_effMax = "SELECT COUNT(*) FROM inscription WHERE idseance = $idseance";
        //echo "<br> la valeur de query : $query_check_effMax <br>";
        $result_check_effMax = mysqli_query($connect, $query_check_effMax);
        $row_check = mysqli_fetch_array($result_check_effMax);

        $query_donne_effMax = "SELECT EffMax FROM seances WHERE idseance = $idseance";
        //echo "<br> la valeur de query : $query_donne_effMax <br>";
        $result_donne_effMax = mysqli_query($connect, $query_donne_effMax);
        $row_donne = mysqli_fetch_array($result_donne_effMax);

        if ($row_check[0] >= $row_donne[0]) {
          echo "<br><b>Erreur</b>: L'effectif maximum de la séance est atteint.";
          exit();
        }
        else {
          // Insertion de l'inscription
          $query_insert = "INSERT INTO inscription (idseance, ideleve, note) VALUES ($idseance, $ideleve, NULL)";
          if (mysqli_query($connect, $query_insert)) {
            echo "Inscription réussie !";
          } else {
            echo "Erreur lors de l'inscription : " . mysqli_error($connect);
          }
        }
        // Fermeture de la connexion
        mysqli_close($connect);
      ?>
    </div>
    <?php include 'banniere.php'; ?>
  </body>
</html>