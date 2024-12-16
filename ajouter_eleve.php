<html>
	<head>
		<meta charset="utf-8">
		<title>Ajouter Eleve</title>
		<link rel="stylesheet" href="projet.css">
	</head>
	<body>
		<div class="main-container">
			<br>
			<h1>Page de traitement de l'ajout d'un élève</h1>

			<?php 
				$nom = $_POST["nom"];
				$prenom = $_POST["prenom"];
				$dateNaiss = $_POST["dateNaiss"];

				if (empty($nom) || empty($prenom) || empty($dateNaiss)) {
					echo "<br>Erreur: un champ est vide";
					exit();
				}
				if (strlen($nom) > 30 || strlen($prenom) > 30) {
					echo "<br>Erreur: un champ est trop long";
					exit();
				}
				if (is_numeric($nom) || is_numeric($prenom)) {
					echo "<br>Erreur: un champ est numérique";
					exit();
				}
				if ($dateNaiss > date('Y-m-d')) { // vérifie si la date de naissance est supérieure à la date du jour
					echo "<br>Erreur: la date de naissance est postérieure à la date du jour";
					exit();
				}

				$minDate = date('Y-m-d', strtotime('-100 years')); // vérifie si la date de naissance est inférieure à 100 ans
				$maxDate = date('Y-m-d', strtotime('-15 years'));

				if ($dateNaiss < $minDate) {
					echo "<br>Erreur: la date de naissance est supérieure à 100 ans";
					exit();
				}
				if ($dateNaiss > $maxDate) {
					echo "<br>Erreur: la personne est trop jeune pour s'inscrire dans l'auto-école, il faut avoir au moins 15 ans.";
					exit();
				}

				echo "<br>Le nom est: " . $nom;
				echo "<br>Le prénom est: " . $prenom;
				echo "<br>La date de naissance: '" . $dateNaiss . "' <br>";

				date_default_timezone_set('Europe/Paris');
				$dateInscription = date("Y-m-d");
				echo "<br>La date d'inscription: '" . $dateInscription . "' <br>";

				$dbhost = 'tuxa.sme.utc';
				$dbuser = 'nf92a051';
				$dbpass = 'F3fBEkGco8eD';
				$dbname = 'nf92a051';

				$connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Erreur de connexion à la base de données');
				mysqli_set_charset($connect, 'utf8');

				$query_nom_prenom = "SELECT * FROM eleves WHERE nom = '$nom' AND prenom = '$prenom'";
				$result_nom_prenom = mysqli_query($connect, $query_nom_prenom);
				if (mysqli_num_rows($result_nom_prenom) > 0) {
					// L'entrée existe déjà dans la base de données
					echo "<p>Ce nom et prénom existent déjà dans la base de données. Voulez-vous continuer et l'ajouter ?</p>";
					echo "<form method='post' action='valider_eleve.php'>";
					echo "<input type='hidden' name='nom' value='$nom'>";
					echo "<input type='hidden' name='prenom' value='$prenom'>";
					echo "<input type='hidden' name='dateNaiss' value='$dateNaiss'>";
					echo "<input type='radio' name='ajouter' value='oui' id='oui'><label for='oui'>Oui</label><br>";
					echo "<input type='radio' name='ajouter' value='non' id='non' checked><label for='non'>Non</label><br><br>";
					echo "<input type='submit' value='Confirmer'>";
					echo "</form>";
					mysqli_close($connect);
					exit();
				}

				if (isset($_POST['ajouter']) && $_POST['ajouter'] == 'non') {
					echo "<br>L'ajout a été annulé par l'utilisateur.";
					exit();
				}

				$query = "INSERT INTO eleves (ideleve, nom, prenom, dateNaiss, dateInscription) VALUES (NULL, '$nom', '$prenom', '$dateNaiss', '$dateInscription')";
				//echo "<br>$query<br>";

				$result = mysqli_query($connect, $query);

				if (!$result) {
					echo "<br>Erreur lors de l'ajout: " . mysqli_error($connect);
				} else {
					echo "<br>Ajout réussi !";
				}
				mysqli_close($connect);
			?>
		</div> 
		<?php include 'banniere.php'; ?>
	</body>
</html>
