<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Services</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php 
            include('header.php');
            if($_SESSION['Service']==""){
                echo '<meta http-equiv="refresh" content="0;url=add.php?add=service"/>';
            }
        ?>
        <nav class="nav">
            <input placeholder="Rechercher un médecin..." id="searchBar">
            <select id="serviceSearch">
                <option> Tous </option>
                <option> Urgence </option>
                <option> Chirurgie  </option>
                <option> Dermathologie </option>
                <option> Gastroentérologie </option>
                <option> Gynécologie </option>
                <option> Neurologie </option>
                <option> Psychiatrie </option>
                <option> Radiologie </option>
                <option> Soins intensifs  </option>
                <option> Direction </option>
            </select>
            <button onclick="sort();"> Recherche </button>
        </nav>
        <main class="main">
            <section class="section__right section--full">
                <?php
                try{
                    include_once('db.php');
                    
                    $req= $bd->query('SELECT * FROM service ORDER BY Nom');
                    
                    while($donnees = $req->fetch()){
                        echo '<section class="service"> <h2 class="service__section__title"><span class="serviceNom">'.$donnees['Nom'].'</span> - '.$donnees['NbrMed'].' Médecin(s)</h2>';
                        $sousreq= $bd->query('SELECT * FROM users WHERE Service ="'.$donnees['Nom'].'"');
                        while($service = $sousreq->fetch()){
                            if($donnees['MatriculeTitulaire']==$service['Matricule']){
                                $class='titulaire';
                            }else{
                                $class='';
                            }
                            echo '<article class="user '.$class.'">
                                    <h2 class="user__name"> <span class="uppercase nom">'.$service["Nom"].'</span> '.$service["Prenom"].'</h2>
                                    <p class="user__registre"> <span class="bold"> Matricule </span>: '.$service["Matricule"].' </p>
                                    <p class=" user__info"> <span class="bold">Email </span>: '.$service["Email"].' </p>
                                    <p class=" user__info"> <span class="bold">Service </span>: '.$donnees["Nom"].' </p>
                                </article>';
                        }
                        echo '</section>';
                    }
                }catch(Exeption $e){
                    echo 'Erreur de connection a la DB'+$e;
                }
                ?>
        </main>
        <footer class="footer">
            <p> © 2016-2017 HEH ISFTR - développement </p>
            <p> Florian Simond </p>
            <p> Projet scolaire dans le cadre du cours de PHP </p>
        </footer>
        <script src="js/script.js"></script>
	</body>
</html>