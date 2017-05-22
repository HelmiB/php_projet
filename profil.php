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
            include('header.php');
            if(!isset($_SESSION['Matricule'])){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            try{
                include_once('db.php');
                $req= $bd ->prepare('SELECT * FROM users WHERE Matricule = :login');
                $req->execute(array('login' => $_SESSION['Matricule']));
                $donnees = $req->fetch();
            }catch(Exeption $e){
                echo 'erreur '+$e;
            }
            $badNom=false;
            $badPrenom=false;
            $badMail=false;
            $badOldMDP=false;
            $badNewMDP=false;
            $badConfirmedMDP=false;
            if(isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['mail']) || (isset($_POST['oldMdp'])&&isset($_POST['newMdp'])&&isset($_POST['confirmedMdp']) && $_POST['newMdp']==$_POST['confirmedMdp'])){
                if(!preg_match("#^[A-Z][a-z]{1,49}$#",$_POST['nom'])){
                    $badNom=true;
                } 
                if(!preg_match("#^[A-Z][a-zA-Z\ ]{1,80}$#",$_POST['prenom'])){
                    $badPrenom=true;
                }
                if(!preg_match("#^[0-9a-z\-\_\.]{1,}@[0-9a-z](\.?[0-9a-z])+\.?([a-z]){2,}$#",$_POST['mail'])){
                    $badMail=true;
                }
                if(!password_verify($_POST['oldMdp'], $donnees['Password'])){
                    $badOldMDP=true;
                }
                if(!preg_match("#^[\S]{4,}#",$_POST['newMdp'])){
                    $badNewMDP=true;
                }
                if($_POST['newMdp']!=$_POST['confirmedMdp']){
                    $badConfirmedMDP=true;
                }
                if(!$badNom && !$badPrenom && !$badMail && !$badOldMDP && !$badNewMDP && !$badConfirmedMDP){
                    try 
                    { 
                        include_once("db.php");
                        $mdp1 = password_hash($_POST['newMdp'], PASSWORD_BCRYPT);
                        $desc = 'Demande de modification de profil';
                        $time = time();
                        
                        $req= $bd->prepare('INSERT INTO ticket(matricule, newName, newFirstName, newMail, newMdp, message, ticketDate, raison) VALUE (:matricule,:newNom,:newPrenom,:newMail,:newPassword,:message, :ticketDate,:raison)');
                        $req->execute(array('matricule' =>$_SESSION['Matricule'], 'newNom' =>$_POST['nom'], 'newPrenom' =>$_POST['prenom'], 'newMail' =>$_POST['mail'], 'newPassword' =>$mdp1, 'message' =>$desc, 'ticketDate' =>$time, 'raison' => 'Modification'));

                        echo "go check DB";
                        echo $time;
                        echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
                    }
                    catch (Exception $e) 
                    {
                        echo 'Erreur de connexion à la BD '.$e;
                    }
                }
            }
        ?>
        <main class="main main--full">
            <section class="section__left">
                <h1 class="section__title"> Bonjour, <?php echo ($_SESSION['Prenom']." ".$_SESSION['Nom']); ?></h1>
            </section>
            <section class="section__right">
                <form class="info" method="POST" action="profil.php">
                    <h2 class="info__title">Nom : </h2>
                    <input class="info__input" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];}else{ echo $_SESSION['Nom'];}?>" name="nom">
                    <?php
                    if($badNom){
                        echo '<label class="red"> Nom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Prenom : </h2>
                    <input class="info__input" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];}else{ echo $_SESSION['Prenom'];}?>" name="prenom">
                    <?php
                    if($badPrenom){
                        echo '<label class="red"> Prenom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Mail : </h2>
                    <input class="info__input" value="<?php if(isset($_POST['mail'])){echo $_POST['mail'];}else{ echo $_SESSION['Mail'];}?>" name="mail">
                    <?php
                    if($badMail){
                        echo '<label class="red"> Mail invalide </label>';
                    }
                    ?>
                    <?php 
                    if($_SESSION['Service']!=''){ 
                    ?>
                    <h2 class="info__title">Service : </h2>
                    <input class="info__input" value="<?php if(isset($_POST['service'])){echo $_POST['service'];}else{ echo $_SESSION['Service'];}?>" name="service" disabled="disabled">
                    <?php 
                    } 
                    ?>
                    <h2 class="info__title">Ancien mot de passe : </h2>
                    <input class="info__input" type="password" name="oldMdp">
                    <?php
                    if($badOldMDP){
                        echo '<label class="red"> Ancien mot de passe invalide</label>';
                    }
                    ?>
                    <h2 class="info__title">Nouveau mot de passe : </h2>
                    <input class="info__input" type="password" name="newMdp">
                    <?php
                    if($badNewMDP){
                        echo '<label class="red"> Mot de passe invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Confirmer mot de passe : </h2>
                    <input class="info__input" type="password" name="confirmedMdp">
                    <?php
                    if($badConfirmedMDP){
                        echo '<label class="red"> Les 2 nouveaux mots de passe doivent être identiques </label>';
                    }
                    ?>
                    <button type="submit" class="info__submit">Modifier</button>
                    <a class="info__supp" href="del.php?matricule=<?=$_SESSION['Matricule']?>"> Supprimer mon compte </a>
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