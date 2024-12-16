<html>
	<head>
		<meta charset = "utf-8">
    <link rel="stylesheet" href="projet.css">
	</head>
		<body>
      <div class="main-container">
			<br>
          <h1>Consultation des calendriers des élèves</h1>
          <form action = "visualiser_calendrier.php" method = "post">
                Choisir un élève
                <br>
                  <select name="ideleve" required>
                    <option value="">--Choisir un élèves--</option>
                    <?php
                      $dbhost = 'tuxa.sme.utc';
                      $dbuser = 'nf92a051';
                      $dbpass = 'F3fBEkGco8eD';
                      $dbname = 'nf92a051';

                      $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
                      mysqli_set_charset($connect, 'utf8');

                      $query = "SELECT * FROM eleves";
                      $result = mysqli_query($connect, $query);
                      while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['ideleve'] . "'>" . htmlspecialchars($row['nom']) ." ". htmlspecialchars($row['prenom']). "</option>";
                      }
                    ?>
                  </select>
                  <br><br>
                  <input type='submit' value='choisir'>
          </form>
        </div>
        <?php include 'banniere.php'; ?>
		</body>
</html>