<html>
    <head>
        <meta charset="utf-8">
        <title>Validation de l'élève</title>
        <link rel="stylesheet" href="projet.css">
    </head>

    <body>
    <div class="main-container">
        <br>
        <h1>Confirmation de l'ajout de l'élève</h1>
        <?php
            $nom = $_POST["nom"];
            $prenom = $_POST["prenom"];
            $dateNaiss = $_POST["dateNaiss"];
            $ajouter = $_POST["ajouter"];

            if ($ajouter == "non") {
                echo "<p>Ajout annulé par l'utilisateur.</p>";
                echo "<br><a href='accueil.html' target ='contenu'>Accueil</a>";
                exit();
            }

            date_default_timezone_set('Europe/Paris');

            $dateInscription = date("Y-m-d");

            $dbhost = 'tuxa.sme.utc';
            $dbuser = 'nf92a051';
            $dbpass = 'F3fBEkGco8eD';
            $dbname = 'nf92a051';

            $connect = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die ('Erreur de connexion à la base de données');
            mysqli_set_charset($connect, 'utf8');
            $query = "INSERT INTO eleves (ideleve, nom, prenom, dateNaiss, dateInscription) VALUES (NULL, '$nom', '$prenom', '$dateNaiss', '$dateInscription')";
            echo "<br>$query<br>";

            $result = mysqli_query($connect, $query);

            if (!$result) {
                echo "<br>Erreur lors de l'ajout: " . mysqli_error($connect);
            } 
            else {
                echo "<br>Ajout réussi !";
            }

            mysqli_close($connect);
            ?>
        </div>
    </body>
</html>