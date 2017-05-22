<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Médecins</title>
        <link rel="stylesheet" href="style.css?v2">
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
            <select id="categorieSearch">
                <option>Tous</option>
                <option>Reclamation</option>
                <option>Avertissement</option>
                <option>Probleme</option>
                <option>Question</option>
                <option>Proposition</option>
                <option>Modification</option>
                <option>Inscription</option>
            </select>
            <select id="checkSearch">
                <option>Tous</option>
                <option>Non-traites</option>
                <option>Traites</option>
            </select>
            <button onclick="tri();"> Recherche </button>
        </nav>
        <main class="main">
            <section class="section__right section--full">

            <?php
                try{
                    include_once('db.php');
                    
                    $req= $bd->query('SELECT * FROM ticket  GROUP BY raison ');
                    
                    while($donnees = $req->fetch()){
                        echo '<section class="admin__section"> <h2 class="admin__section__title categorie">'.$donnees['raison'].'</h2>';
                        $sousreq= $bd->query('SELECT * FROM ticket WHERE raison ="'.$donnees['raison'].'"');
                        while($categorie = $sousreq->fetch()){
                            if($categorie['traite']==1){
                                $class='traite';
                                echo '<article class="admin__article '.$class.'">
                                        <h2 class="admin__article__matricule"> <span class="uppercase">'.$categorie["matricule"].' </span></h2>
                                        <p class="admin__article__desc"> <span class="bold"> Description </span> : '.$categorie["message"].' </p>
                                        <p class="admin__article__date"> <span class="bold"> Date </span>: '.date('d/m/y',$categorie["ticketDate"]).'-'.date('H:i:s',$categorie["ticketDate"]).' </p>
                                    </article>';
                            }else{
                                $class='nonTraite';
                                $src='img/valid-icon.png';
                                if($categorie['raison']=='Inscription'){
                                    echo '<article class="admin__article '.$class.'">
                                            <h2 class="admin__article__matricule"> <span class="uppercase">'.$categorie["matricule"].' </span></h2>
                                            <p class="admin__article__desc"> <span class="bold"> Description </span> : '.$categorie["message"].' </p>
                                            <p class="admin__article__date"> <span class="bold"> Date </span>: '.date('d/m/y',$categorie["ticketDate"]).'-'.date('H:i:s',$categorie["ticketDate"]).' </p>
                                            <a class="user__btn" href="valid.php?ticket='.$categorie['IDTicket'].'&valid=inscription" ><img src="'.$src.'" alt="delete"></a>
                                        </article>';
                                }else if( $categorie['raison']=='Modification' ){
                                    echo '<article class="admin__article '.$class.'">
                                            <h2 class="admin__article__matricule"> <span class="uppercase">'.$categorie["matricule"].' </span></h2>
                                            <p class="admin__article__desc"> <span class="bold"> Description </span> : '.$categorie["message"].' </p>
                                            <p class="admin__article__date"> <span class="bold"> Date </span>: '.date('d/m/y',$categorie["ticketDate"]).'-'.date('H:i:s',$categorie["ticketDate"]).' </p>
                                            <a class="user__btn" href="valid.php?ticket='.$categorie['IDTicket'].'&valid=modification" ><img src="'.$src.'" alt="delete"></a>
                                        </article>';
                                }else{
                                    echo '<article class="admin__article '.$class.'">
                                            <h2 class="admin__article__matricule"> <span class="uppercase">'.$categorie["matricule"].' </span></h2>
                                            <p class="admin__article__desc"> <span class="bold"> Description </span> : '.$categorie["message"].' </p>
                                            <p class="admin__article__date"> <span class="bold"> Date </span>: '.date('d/m/y',$categorie["ticketDate"]).'-'.date('H:i:s',$categorie["ticketDate"]).' </p>
                                            <a class="user__btn" href="valid.php?ticket='.$categorie['IDTicket'].'"><img src="'.$src.'" alt="delete"></a>
                                        </article>';
                                }
                                
                            }
                        }
                        echo '</section>';
                    }
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