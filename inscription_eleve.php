<html>
<head>
    <meta charset="utf-8" lang="fr">
    <title>inscription d'un élève</title>
    <link rel="stylesheet" href="projet.css">
</head>
<body>
    <div class="main-container">
        <h1>Inscription à une séance</h1>
        <form method="post" action="inscrire_eleve.php">
          <label for="eleve">Choisissez un élève :</label>
          <select name="ideleve" id="eleve">
            <?php
                $dbhost = 'tuxa.sme.utc';
                $dbuser = 'nf92a051';

                $dbpass = 'F3fBEkGco8eD';
                $dbname = 'nf92a051';

                $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
                mysqli_set_charset($connect, 'utf8'); // les données envoyées vers mysql sont encodées en UTF-8
                $query = "SELECT ideleve, nom, prenom FROM eleves";
                $result = mysqli_query($connect, $query);
                //recuperation des eleves
                echo "<option value='' selected disabled>-- Sélectionnez un élève --</option>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='".$row['ideleve']."'>".$row['nom']." ".$row['prenom']."</option>";
                }
                  ?>
              </select>
              <br><br>
              <label for="seance">Choisissez une séance :</label>
              <select name="idseance" id="seance">
              <?php
                // Récupération des séances avec leur thème
                $query = "SELECT seances.idseance, seances.DateSeance, themes.nom AS themeNom 
                          FROM seances 
                          JOIN themes ON seances.Idtheme = themes.idtheme
                          WHERE seances.DateSeance > CURDATE() ";
                $result = mysqli_query($connect, $query);
                echo "<option value='' selected disabled>-- Sélectionnez une séance --</option>";
                while ($row = mysqli_fetch_array($result)) {
                    echo "<option value='".$row['idseance']."'>".$row['themeNom']." - ".$row['DateSeance']."</option>";
                }
              ?>
              </select>
            <br><br>
          <input type="submit" value="Inscrire">
        </form>
      </div>
      <?php include 'banniere.php'; ?>
  </body>
</html>
        

