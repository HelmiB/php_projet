<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Contact</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php 
            include('header.php');
            if(!isset($_SESSION['Nom'])||!isset($_SESSION['Prenom'])){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            if($_SESSION['Admin']==1){
                echo '<meta http-equiv="refresh" content="0;url=admin.php"/>';
            }

            if(isset($_POST['choix']) && isset($_POST['description'])){
                try{
                    include_once('db.php');
                    $time = time();

                    strip_tags($_POST['description']); //vire tout ce qui vient de l'html

                    $req= $bd->prepare('INSERT INTO ticket(matricule, message, ticketDate, raison) VALUES (:matricule,:message,:ticketDate,:raison)');
                    $req->execute(array('matricule' =>$_SESSION['Matricule'], 'message' =>$_POST['description'], 'ticketDate' =>$time, 'raison' => $_POST['choix']));
                    

                    echo "go check DB";
                    echo $time;
                    echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
                }catch (Exeption $e){
                    echo 'Erreur de connection a a DB'.$e;
                }
                
            }
        ?>
        <main class="main main--full">
            <section class="section__right section--full">
                <form method="POST" action="contact.php">
                    <select class="contact__comboBox" name="choix">
                        <option> Reclamation </option>
                        <option> Avertissement </option>
                        <option> Probleme </option>
                        <option> Question </option>
                        <option> Proposition </option>
                    </select>
                    <textarea class="contact__textBox" placeholder="Entrez votre texte ici..." name="description"></textarea>
                    <button type="submit" class="info__submit contact__submit"> Confirmer </button>
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