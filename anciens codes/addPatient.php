<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Ajouter patient</title>
        <link rel="stylesheet" href="style.css">
        <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
	</head>
	<body>
		<?php 
            include('header.php');
            if(!isset($_SESSION['Nom'])||!isset($_SESSION['Prenom'])){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }

            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['rue']) && isset($_POST['numero']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['pathologie'])){
                try{
                    include_once('db.php');
                    $bd=new PDO('mysql:host='.$hote.';dbname='.$nomBD,$user,$mdp);
                    if($_POST['boite']==0){
                        $req= $bd->prepare('INSERT INTO patient(Registre, Prenom, Nom, Sexe, AdresseRue, AdresseNumero, AdresseCodePostal, AdresseVille, Pathologie) VALUE (:Registre,:Prenom,:Nom,:Sexe,:Rue,:Numero,:CP,:Ville,:Pathologie)');
                        $req->execute(array('Registre' =>$_POST['registre'], 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Sexe' =>$_POST['sexe'], 'Rue' =>$_POST['rue'], 'Numero' =>$_POST['numero'], 'CP' =>$_POST['cp'], 'Ville' =>$_POST['ville'], 'Pathologie' =>$_POST['pathologie']));
                    }else{
                        $req= $bd->prepare('INSERT INTO patient VALUE (:Registre,:Prenom,:Nom,:Sexe,:Rue,:Numero,:Boite,:CP,:Ville,:Pathologie)');
                        $req->execute(array('Registre' =>$_POST['registre'], 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Sexe' =>$_POST['sexe'], 'Rue' =>$_POST['rue'], 'Numero' =>$_POST['numero'], 'Boite' =>$_POST['boite'], 'CP' =>$_POST['cp'], 'Ville' =>$_POST['ville'], 'Pathologie' =>$_POST['pathologie']));
                    }
                    echo '<meta http-equiv="refresh" content="0;url=patient.php"/>';
                }catch(Exeption $e){
                    echo'erreur de connection à la db'+$e;
                }
            }
        ?>
        <main class="main">
            <section class="section__left">
                <a href="patient.php" class="btn__choice"><h2>Annuler</h2></a>
            </section>
            <section class="section__right">
                <form class="info" method="POST" action="add.php?add=patient">
                    <h2 class="info__title">N° de registre national : </h2>
                    <input class="info__input" name="registre">
                    <h2 class="info__title">Nom : </h2>
                    <input class="info__input" name="nom">
                    <h2 class="info__title">Prenom : </h2>
                    <input class="info__input" name="prenom">
                    <h2 class="info__title">Sexe : </h2>
                    <input class="info__input" name="sexe">
                    <h2 class="info__title">Rue : </h2>
                    <input class="info__input" name="rue">
                    <h2 class="info__title">Numéro : </h2>
                    <input class="info__input" name="numero">
                    <h2 class="info__title">Boite : </h2>
                    <input class="info__input" name="boite">
                    <h2 class="info__title">Code Postal : </h2>
                    <input class="info__input" name="cp">
                    <h2 class="info__title">Ville : </h2>
                    <input class="info__input" name="ville">
                    <h2 class="info__title">Pathologie : </h2>
                    <input class="info__input" name="pathologie">
                    <button type="submit" class="info__submit">Confirmer</button>
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