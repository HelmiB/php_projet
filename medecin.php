<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Médecins</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php 
            include('header.php');
            if($_SESSION['Admin']!=1){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
        ?>
        <nav class="nav">
            <input placeholder="Rechercher..." id="searchBar">
            <button onclick='search("medecin");'> Recherche </button>
        </nav>
        <main class="main">
            <section class="section__right user__container section--full">
                <?php
                    try{
                        include_once('db.php');
                        
                        $req= $bd -> query('SELECT * FROM users ORDER BY Nom');

                        while($donnees = $req->fetch())
                        {   
                            echo '<article class="user">
                                <h2 class="user__name"> <span class="uppercase">'.$donnees["Nom"].' </span>'.$donnees["Prenom"].'</h2>
                                <p class="user__registre"> <span class="bold"> Matricule </span>: <span class="matricule">'.$donnees["Matricule"].'</span> </p>
                                <p class="user__mail"> <span class="bold">Email </span>: '.$donnees["Email"].' </p>
                                <p class="user__service"> <span class="bold">Service </span>: '.$donnees["Service"].' </p>
                                <a class="user__btn" href="#" onclick=\'ConfirmMessage('.$donnees['Matricule'].',"del.php?matricule=")\'><img src="img/Remove-Male-User.png" alt="delete user"></a>
                                <a class="user__btn user__btn--modify" href="mod.php?matricule='.$donnees["Matricule"].'"><img src="img/Edit-Male-User.png" alt="delete user"></a>
                            </article>';
                        }
                    }catch(Exeption $e){
                        echo 'Erreur de connection a la DB'+$e;
                    }
                    
                ?>
                <article class="user user__add">
                    <a href="add.php?add=medecin"><img src="img/add.png" alt="ajouter user"></a>
                </article>
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