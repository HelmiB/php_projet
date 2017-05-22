<!DOCTYPE html>
    <html>
        <head>
            <meta charset ="utf-8"> 
            <title>Profil</title>
            <link rel="stylesheet" href="style.css">
            <meta name='viewport' content="width=device-width, initial-scale=1">
        </head>
        <body>
        <?php
            include("header.php");

        if(isset($_SESSION['Matricule'])){
            echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
        }
        $badLogin=false;
        $badNom=false;
        $badPrenom=false;
        $badMail=false;
        $badMDP=false;
        $badConfirmedMDP=false;
        if(isset($_POST['login'])&& isset($_POST['mdp'])&& isset($_POST['nom'])&& isset($_POST['prenom'])&& isset($_POST['mail'])){
            if(preg_match("#^[1-9][0-9]{5}$#",$_POST['login'])){
                if(preg_match("#^[A-Z][a-z]{1,49}$#",$_POST['nom'])){
                    if(preg_match("#^[A-Z][a-zA-Z\ ]{1,80}$#",$_POST['prenom'])){
                        if(preg_match("#^[0-9a-z\-\_\.]{1,}@[0-9a-z](\.?[0-9a-z])+\.?([a-z]){2,}$#",$_POST['mail'])){
                            if(preg_match("#^[\S]{4,}#",$_POST['mdp'])){
                                if($_POST['mdp']==$_POST['confirmedMdp']){
                                    try{ 
                                        include_once('db.php');
                                        $mdp1 = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
                                        $login = intval($_POST['login']);
                                        $time = time();
                                        
                                        $req= $bd->prepare('INSERT INTO ticket (Matricule, newFirstName, newName, newMail, newMdp, message, ticketDate, raison) VALUE (:Matricule,:Prenom,:Nom,:Email,:Password,:Message,:TicketDate,:Raison)');
                                        $req->execute(array('Matricule' =>$login, 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Email' =>$_POST['mail'], 'Password' =>$mdp1,'Message' =>'Demande d\'inscription', 'TicketDate'=>$time, 'Raison' => 'Inscription'));

                                        echo 'va vérifier dans la db !!';
                                        echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
                                    }catch (Exception $e){
                                        echo 'Erreur de connexion à la BD '.$e;
                                    }
                                }else{
                                    $badConfirmedMDP=true;
                                }
                            }else{
                                $badMDP=true;
                            }
                        }else{
                            $badMail=true;
                        }
                    }else{
                        $badPrenom=true;
                    }
                }else{  
                    $badNom=true;
                }
            }else{
                $badLogin=true;
            }
        }
        ?>
        <main class="main">
            <section class="section__left">
                <h1 class="section__title"> Bonjour, Visiteur</h1>
            </section>
            <section class="section__right">
                <form class="info" method="POST" action="inscription.php">
                    <h2 class="info__title">Matricule : </h2>
                    <input class="info__input" name="login" value="<?php if(isset($_POST['login'])){echo $_POST['login'];} ?>">
                    <?php
                    if($badLogin){
                        echo '<label class="red"> Matricule invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Nom : </h2>
                    <input class="info__input" name="nom" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];} ?>">
                    <?php
                    if($badNom){
                        echo '<label class="red"> Nom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Prenom : </h2>
                    <input class="info__input" name="prenom" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];} ?>">
                    <?php
                    if($badPrenom){
                        echo '<label class="red"> Prénom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Mail : </h2>
                    <input class="info__input" name="mail" value="<?php if(isset($_POST['mail'])){echo $_POST['mail'];} ?>">
                    <?php
                    if($badMail){
                        echo '<label class="red"> Mail invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Mot de passe : </h2>
                    <input class="info__input" type="password" name="mdp">
                    <?php
                    if($badMDP){
                        echo '<label class="red"> Mot de passe invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Confirmer mot de passe : </h2>
                    <input class="info__input" type="password" name="confirmedMdp">
                    <?php
                    if($badConfirmedMDP){
                        echo '<label class="red"> Les 2 mots de passe doivent être identiques </label>';
                    }
                    ?>
                    <button type="submit" class="info__submit contact__submit">Confirmer</button>
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