<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Inscription à un service</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	</head>
	<body>
		<?php 
            include('header.php');
            if($_SESSION['Service']!=""){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            if(isset($_POST['choix'])){
                include_once("db.php");

                try {
                    $bd=new PDO('mysql:host='.$hote.';dbname='.$nomBD,$user,$mdp);
                    $req= $bd->prepare('UPDATE users SET Service = :Service WHERE Matricule=:Matricule');
                    $req->execute(array('Service' =>$_POST['choix'], 'Matricule'=>$_SESSION['Matricule']));

                    $_SESSION['Service']=$_POST['choix'];
                    echo 'va vérifier dans la db !!';
                    echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
                }
                catch (Exception $e) 
                {
                    echo 'Erreur de connexion à la BD '.$e;
                }
            }
        ?>
        <main class="main">
            <section class="section__right section--full">
                <form method="POST" action="addService.php">
                    <label class="add__choix"> S'inscrire au service de : </label>
                    <select class="service__comboBox" name="choix">
                        <option> Urgence </option>
                        <option> Pharmacie </option>
                        <option> Chirurgie  </option>
                        <option> Dermathologie </option>
                        <option> Diététique </option>
                        <option> Endocrinologie </option>
                        <option> Gastroentérologie </option>
                        <option> Génétique </option>
                        <option> Gériatrie </option>
                        <option> Gynécologie </option>
                        <option> Hématologie </option>
                        <option> Kinésithérapie </option>
                        <option> Medecine interne </option>
                        <option> Neurologie </option>
                        <option> Ophtalmologie </option>
                        <option> ORL </option>
                        <option> Pédiatrie </option>
                        <option> Pneumologie </option>
                        <option> Psychiatrie </option>
                        <option> Radiologie </option>
                        <option> Soins intensifs  </option>
                        <option> Anatomie pathologique </option>
                        <option> Anesthéologie </option>
                        <option> Cordiologie </option>
                    </select>
                    <button class="info__submit service__submit">Confirmer</button>
                </form>
            </section>
        </main>
        <footer class="footer">
            <p> © 2016-2017 HEH ISFTR - développement </p>
            <p> Florian Simond </p>
            <p> Projet scolaire dans le cadre du cours de PHP </p>
        </footer>
	</body>
</html>