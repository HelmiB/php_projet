<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Consultation</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php 
            include('header.php');
            if(!isset($_SESSION['Nom'])||!isset($_SESSION['Prenom'])){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
        ?> 
        <nav class="nav">
            <input placeholder="Rechercher un patient..." id='searchBar'>
            <input type="date" placeholder="Recherche une date..." id='dateSearchBar'>
            <button onclick='rdvTracker();'> Recherche </button>
        </nav>
        <main class="main">
            <section class="section__right section--full">
            <article class="seance seance--add">
                <a href="add.php?add=seance"><img src="img/Calendar-Add.png" alt='add seance'></a>
            </article>
            <?php
                try{
                    include_once('db.php');
                    
                    $req= $bd -> query('SELECT * FROM consultation WHERE MatriculeMedecin = '.$_SESSION["Matricule"].' ORDER BY DateConsultation');
                    
                    while($donnees = $req->fetch())
                    {
                        $subreq = $bd -> query('SELECT Nom, Prenom FROM patient WHERE Registre = '.$donnees['RegistrePatient']);
                        $nom = $subreq->fetch();
                        if(!isset($date)){
                            $date=$donnees['DateConsultation'];
                            echo '<section class="seance__container"> <h2 class="seance__date">'.$date.'</h2>';
                        }else{
                            if($date!=$donnees['DateConsultation']){
                                $date=$donnees['DateConsultation'];
                                echo '</section>';
                                echo '<section class="seance__container"> <h2 class="seance__date">'.$date.'</h2>';
                            }
                        }
                        echo '<article class="seance">
                            <p class="seance__patient"> <span class="bold"> Patient </span>: <span class="uppercase nom">'.$nom['Nom'].'</span> '.$nom['Prenom'].' </p>
                            <p class="seance__notes"> <span class="bold">Notes </span>: '.$donnees["Notes"].' </p>
                            <p class="seance__prescription"> <span class="bold"> Prescription </span>: '.$donnees["Prescription"].' </p>
                            <a class="user__btn" href="#" onclick=\'ConfirmMessage('.$donnees["ID"].',"del.php?ID=")\'><img src="img/delete-icon.png" alt="delete seance"></a>
                            <a class="user__btn user__btn--modify" href="mod.php?ID='.$donnees["ID"].'"><img src="img/modify-icon.png" alt="modify seance"></a>
                        </article>';
                    }
                    echo '</section>';
                }catch(Exeption $e){
                    echo 'Erreur de connection a la DB'+$e;
                }
            ?>
            </section>
        </main>
        <footer class="footer">
            <p> © 2016-2017 HEH ISFTR - développement </p>
            <p> Florian Simond </p>
            <p> Projet scolaire dans le cadre du cours de PHP </p>
        </footer>
        <script src="js/script.js"></script>
	</body>
</html>