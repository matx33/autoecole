<html>
	<head>
		<meta charset = "utf-8">
        <title>Ajouter Thème</title>
        <link rel="stylesheet" href="projet.css">
	</head>
		<body>
        <div class="main-container">
			<br>
            <h1>Page de traitement de l'ajout d'un thème</h1>
            
            <?php 
            $nom=$_POST["nom"];
            $descriptif=$_POST["descriptif"];

            if (empty($nom) || empty($descriptif)){
                echo "<br><b>Erreur</b> : un champ est vide";
                exit();
            }
            if (strlen($nom) > 30 || strlen($descriptif) > 100){
                echo "<br><b>Erreur</b> : un champ est trop long";
                exit();
            }
            if (is_numeric($nom) || is_numeric($descriptif)){
                echo "<br><b>Erreur</b> : un champ est numerique";
                exit();
            }

            //echo "<br> incrustation de code html";
           // echo "<br> le nom est: ".$nom;

            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a051';
            $dbpass = 'F3fBEkGco8eD';

            $dbname = 'nf92a051';
            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Error connecting to mysql');
            //la ligne suivante permet d'éviter les problèmes d'accent entre la page ouèbe et le serveur mysql
            mysqli_set_charset($connect, 'utf8'); //les données envoyées vers mysql sont encodées en UTF-8
           
            $query_doublons = 'SELECT * FROM themes WHERE nom="'.$nom.'"';
            $result_doublons = mysqli_query($connect, $query_doublons);

            if (mysqli_num_rows($result_doublons) > 0) {
                $query_suppr = "SELECT supprime FROM themes WHERE nom='$nom'";
                $result_suppr = mysqli_query($connect, $query_suppr);
                $row = mysqli_fetch_array($result_suppr);
                if ($row['supprime'] == 0) {
                    echo "<br><b>Erreur</b> : le thème existe déjà";
                    exit();
                } else {
                    $query = "UPDATE themes SET supprime = 0, descriptif = '$descriptif' WHERE nom='$nom'";
                    $result = mysqli_query($connect, $query);
                    if (!$result) {
                        echo "<br>Erreur lors de la mise à jour du thème : " . mysqli_error($connect);
                        exit();
                    }
                    echo "<br>Le thème a été ajouté avec succès";
                    exit();
                }
            }

            $query = "INSERT INTO themes VALUES (NULL,'$nom',0, '$descriptif')";

            //echo "<br>$query<br>";
            // important echo a faire systematiquement, c'est impose !
            echo "<br>Le thème a été ajouté avec succès";

            $result = mysqli_query($connect, $query); //bool
            // $query utilise comme parametre de mysqli_query
            // le test ci-dessous est desormais impose pour chaque appel de :
            // mysqli_query($connect, $query);
            if (!$result)
            {
            echo "<br>pas bon".mysqli_error($connect);
            }
            mysqli_close($connect);
            ?>
        </div>
        <?php include 'banniere.php'; ?>
	</body>
</html>