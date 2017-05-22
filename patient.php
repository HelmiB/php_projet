<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Patients</title>
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
            <input placeholder="Rechercher..." id="searchBar">
            <button onclick='search("patient");'> Recherche </button>
        </nav>
        <main class="main">
            <section class="section__right user__container section--full">
                <?php
                    try{
                        include_once('db.php');
                        
                        $req= $bd -> query('SELECT * FROM patient ORDER BY Nom');

                        while($donnees = $req->fetch())
                        {
                            $sexe = $donnees["Sexe"];
                            if($sexe=='M'){
                                $source1 = "img/Remove-Male-User.png";
                                $source2 = "img/Edit-Male-User.png";
                            } elseif ($sexe=='F'){
                                $source1 = "img/Remove-Female-User.png";
                                $source2 = "img/Edit-Female-User.png";
                            }
                            echo '<article class="user">
                                <h2 class="user__name"> <span class="uppercase">'.$donnees["Nom"].' </span>'.$donnees["Prenom"].'</h2>
                                <p class="user__sexe"> <span class="bold"> Sexe </span> : '.$donnees["Sexe"].' </p>
                                <p class="user__registre"> <span class="bold"> N° registre national </span>: <span class="numRegistre">'.$donnees["Registre"].'</span> </p>
                                <adress> <span class="bold">Adresse </span> : <br>'.$donnees["AdresseRue"].', '.$donnees["AdresseNumero"].' - '.$donnees["AdresseBoite"].' <br> '.$donnees["AdresseCodePostal"].' '.$donnees["AdresseVille"].' </adress>
                                <p class="pathologie"> <span class="bold">Pathologie </span>: '.$donnees["Pathologie"].' </p>
                                <a class="user__btn" href="#" onclick=\'ConfirmMessage('.$donnees["Registre"].',"del.php?registre=")\'><img src="'.$source1.'" alt="delete user"></a>
                                <a class="user__btn user__btn--modify" href="mod.php?registre='.$donnees["Registre"].'"><img src="'.$source2.'" alt="modify user"></a>
                            </article>';
                        }
                    }catch(Exeption $e){
                        echo 'Erreur de connection a la DB'+$e;
                    }
                    
                ?>
                <article class="user user__add">
                    <a href="add.php?add=patient"><img src="img/add.png" alt="ajouter user"></a>
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