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
            if(isset($_GET['registre'])){
                try{
                    include_once('db.php');
                    
                    $req= $bd -> prepare('SELECT * FROM patient WHERE Registre = :Registre');
                    $req->execute(array('Registre'=>$_GET['registre']));
                    $donnees = $req->fetch();
                }catch(Exception $e){
                    echo 'Erreur de chargement du patient '+$e;
                }
            }elseif(isset($_GET['matricule'])){
                try{
                    include_once('db.php');
                    
                    $req= $bd -> prepare('SELECT * FROM users WHERE Matricule = :Matricule');
                    $req->execute(array('Matricule'=>$_GET['matricule']));
                    $donnees = $req->fetch();
                }catch(Exception $e){
                    echo 'Erreur de chargement du médecin '+$e;
                }
            }elseif(isset($_GET['ID'])){
                try{
                    include_once('db.php');
                    
                    $req= $bd -> prepare('SELECT * FROM consultation WHERE ID = :ID');
                    $req->execute(array('ID'=>$_GET['ID']));
                    $donnees = $req->fetch();
                }catch(Exception $e){
                    echo 'Erreur de chargement de la séance '+$e;
                }
            }else{
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            

            $badNom=false;
            $badPrenom=false;
            $badSexe=false;
            $badRue=false;
            $badNumero=false;
            $badCP=false;
            $badVille=false;
            $badPathologie=false;
            $badBoite=false;
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['rue']) && isset($_POST['numero']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['pathologie'])){
                if(!preg_match("#^[A-Z][a-z]{1,49}$#", $_POST['nom'])){
                    $badNom=true;
                }
                if(!preg_match("#^[A-Z][a-zA-Z]{1,80}$#",$_POST['prenom'])){
                    $badPrenom=true;
                }
                if(!preg_match("#F|M#",$_POST['sexe'])){
                    $badSexe=true;
                }
                if(!preg_match("#[a-z]{1,100}$#",$_POST['rue'])){
                    $badRue=true;
                }
                if(!preg_match("#[0-9]{1,10}$#",$_POST['numero'])){
                    $badNumero=true;
                }
                if(!preg_match("#^[1-9][0-9]{1,3}$#",$_POST['cp'])){
                    $badCP=true;
                }
                if(!preg_match("#[a-z\-\ ]{1,50}$#",$_POST['ville'])){
                    $badVille=true;
                }
                if(!preg_match("#[A-Za-z\ ]#",$_POST['pathologie'])){
                    $badPathologie=true;
                }
                if(!preg_match("#[A-Z0-9]{0,10}#",$_POST['boite'])){
                    $badBoite=true;
                }
                if($badNom==false && $badPrenom==false && $badSexe==false && $badRue==false && $badNumero==false && $badCP==false && $badVille==false && $badPathologie==false && $badBoite==false){
                    try{
                        include_once('db.php');
                        $req= $bd->prepare('UPDATE patient SET Nom=:Nom, Prenom=:Prenom, Sexe=:Sexe, AdresseRue=:Rue, AdresseNumero=:Numero, AdresseBoite=:Boite, AdresseCodePostal=:CP, AdresseVille=:Ville, Pathologie=:Pathologie WHERE Registre=:RegistreToModify');
                        $req->execute(array('Nom' =>$_POST['nom'], 'Prenom' =>$_POST['prenom'], 'Sexe' =>$_POST['sexe'], 'Rue' =>$_POST['rue'], 'Numero' =>$_POST['numero'], 'Boite' =>$_POST['boite'], 'CP' =>$_POST['cp'], 'Ville' =>$_POST['ville'], 'Pathologie' =>$_POST['pathologie'], 'RegistreToModify' =>$_GET['registre']));
                        echo '<meta http-equiv="refresh" content="0;url=patient.php"/>';
                    }catch(Execption $e){
                        echo 'erreur de connection à la db'.$e;
                    }
                }
            }

            $badMail=false;
            $badService=false;
            $badDroit=false;
            $services=array(
                "Urgence",
                "Chirurgie ",
                "Dermathologie",
                "Gastroentérologie",
                "Gynécologie",
                "Neurologie",
                "Psychiatrie",
                "Radiologie",
                "Soins intensifs ",
                "Direction");
            if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email']) && isset($_POST['service']) && isset($_POST['droit'])){
                if(!preg_match("#^[A-Z][a-z]{1,49}$#", $_POST['nom'])){
                    $badNom=true;
                }
                if(!preg_match("#^[A-Z][a-zA-Z\ ]{1,80}$#",$_POST['prenom'])){
                    $badPrenom=true;
                }
                if(!preg_match("#^[0-9a-z\-\_\.]{1,}@[0-9a-z](\.?[0-9a-z])+\.?([a-z]){2,}$#",$_POST['email'])){
                    $badMail=true;
                }
                if(!in_array($_POST['service'],$services)){
                    $badService=true;
                }
                if(!preg_match("#[0-1]{1}$#",$_POST['droit'])){
                    $badDroit=true;
                }
                if(!$badNom && !$badPrenom && !$badMail && !$badService && !$badDroit){
                    try{
                        include_once('db.php');
                        
                        $req= $bd->prepare('UPDATE users SET Nom=:Nom, Prenom=:Prenom, Email=:Email, Service=:Service, Droit=:Droit WHERE Matricule=:MatriculeToModify');
                        $req->execute(array('Nom' =>$_POST['nom'], 'Prenom' =>$_POST['prenom'], 'Email' =>$_POST['email'], 'Service' =>$_POST['service'], 'Droit' =>$_POST['droit'], 'MatriculeToModify' =>$_GET['matricule']));
                        echo 'check DB';
                        echo '<meta http-equiv="refresh" content="0;url=medecin.php"/>';
                    }catch(Exeption $e){
                        echo'erreur de connection à la db'+$e;
                    }
                }
            }
            $badRegistre=false;
            if(isset($_POST['date']) && isset($_POST['registre']) && isset($_POST['prescription']) && isset($_POST['note'])){
                if(!preg_match("#[0-9]{9}$#",$_POST['registre'])){
                    $badRegistre=true;
                }
                strip_tags($_POST['prescription']);
                strip_tags($_POST['note']);
                if(!$badRegistre){
                    try{
                        include_once('db.php');
                        $req= $bd->prepare('UPDATE consultation SET RegistrePatient=:Registre, DateConsultation=:DateConsultation, Prescription=:Prescription, Notes=:Note WHERE ID=:IDToModify');
                        $req->execute(array('Registre' =>$_POST['registre'], 'DateConsultation' =>$_POST['date'], 'Prescription' =>$_POST['prescription'], 'Note' => $_POST['note'], 'IDToModify' =>$_GET['ID']));
                        echo 'go check db';
                        echo '<meta http-equiv="refresh" content="0;url=rdv.php"/>';
                    }catch(Exeption $e){
                        echo 'erreur de co a la db'.$e;
                    }
                }

            }


        if(isset($_GET['registre'])){
        ?>
        <main class="main">
            <section class="section__right section--full">
                <form class="info" method="POST" action='mod.php?registre=<?= $donnees["Registre"] ?>'>
                    <h2 class="info__title">N° de registre national : </h2>
                    <input class="info__input" name="registre" value="<?= $donnees['Registre'] ?>" disabled="disabled">
                    <h2 class="info__title">Nom : </h2>
                    <input class="info__input" name="nom" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];}else{echo $donnees['Nom'];} ?>">
                    <?php
                    if($badNom){
                        echo '<label class="red"> Nom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Prenom : </h2>
                    <input class="info__input" name="prenom" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];}else{echo $donnees['Prenom'];} ?>">
                    <?php
                    if($badPrenom){
                        echo '<label class="red"> Prenom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Sexe : </h2>
                    <input class="info__input" name="sexe" value="<?php if(isset($_POST['sexe'])){echo $_POST['sexe'];}else{echo $donnees['Sexe'];} ?>">
                    <?php
                    if($badSexe){
                        echo '<label class="red"> Sexe invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Rue : </h2>
                    <input class="info__input" name="rue" value="<?php if(isset($_POST['rue'])){echo $_POST['rue'];}else{echo $donnees['AdresseRue'];} ?>">
                    <?php
                    if($badRue){
                        echo '<label class="red"> Rue invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Numéro : </h2>
                    <input class="info__input" name="numero" value="<?php if(isset($_POST['numero'])){echo $_POST['numero'];}else{echo $donnees['AdresseNumero'];} ?>">
                    <?php
                    if($badNumero){
                        echo '<label class="red"> Numero invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Boite : </h2>
                    <input class="info__input" name="boite" value="<?php if(isset($_POST['boite'])){echo $_POST['boite'];}else{echo $donnees['AdresseBoite'];} ?>">
                    <?php
                    if($badBoite){
                        echo '<label class="red"> Boite invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Code Postal : </h2>
                    <input class="info__input" name="cp" value="<?php if(isset($_POST['cp'])){echo $_POST['cp'];}else{echo $donnees['AdresseCodePostal'];} ?>">
                    <?php
                    if($badCP){
                        echo '<label class="red"> Code postal invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Ville : </h2>
                    <input class="info__input" name="ville" value="<?php if(isset($_POST['ville'])){echo $_POST['ville'];}else{echo $donnees['AdresseVille'];} ?>">
                    <?php
                    if($badVille){
                        echo '<label class="red"> Ville invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Pathologie : </h2>
                    <input class="info__input" name="pathologie" value="<?php if(isset($_POST['pathologie'])){echo $_POST['pathologie'];}else{echo $donnees['Pathologie'];} ?>">
                    <?php
                    if($badPathologie){
                        echo '<label class="red"> Pathologie invalide </label>';
                    }
                    ?>
                    <div class="button__container">
                        <a href="patient.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            </section>
        </main>
        <?php 
        }elseif(isset($_GET['matricule'])){
        ?>
        <main class="main">
            <section class="section__right section--full">
                <form class="info" method="POST" action='mod.php?matricule=<?= $donnees["Matricule"] ?>'>
                    <h2 class="info__title">Matricule : </h2>
                    <input class="info__input" name="matricule" value="<?= $donnees['Matricule'] ?>" disabled="disabled">
                    <h2 class="info__title">Nom : </h2>
                    <input class="info__input" name="nom" value="<?php if(isset($_POST['nom'])){echo $_POST['nom'];}else{echo $donnees['Nom'];} ?>">
                    <?php
                    if($badNom){
                        echo '<label class="red"> Nom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Prenom : </h2>
                    <input class="info__input" name="prenom" value="<?php if(isset($_POST['prenom'])){echo $_POST['prenom'];}else{echo $donnees['Prenom'];} ?>">
                    <?php
                    if($badPrenom){
                        echo '<label class="red"> Prenom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Email : </h2>
                    <input class="info__input" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}else{echo $donnees['Email'];} ?>">
                    <?php
                    if($badMail){
                        echo '<label class="red"> Mail invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Service : </h2>
                    <input class="info__input" name="service" value="<?php if(isset($_POST['service'])){echo $_POST['service'];}else{echo $donnees['Service'];} ?>">
                    <?php
                    if($badService){
                        echo '<label class="red"> Service invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Droit : </h2>
                    <input class="info__input" name="droit" value="<?php if(isset($_POST['droit'])){echo $_POST['droit'];}else{echo $donnees['Droit'];} ?>">
                    <?php
                    if($badDroit){
                        echo '<label class="red"> Droit invalide </label>';
                    }
                    ?>
                    <div class="button__container">
                        <a href="medecin.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            </section>
        </main>
        <?php
        }elseif(isset($_GET['ID'])){
        ?>
        <main class="main">
            <section class="section__right section--full">
                <form class="info" method="POST" action='mod.php?ID=<?= $donnees["ID"] ?>'>
                    <h2 class="info__title">Date : </h2>
                    <input class="info__input" name="date" type="date" value="<?php if(isset($_POST['date'])){echo $_POST['date'];}else{echo $donnees['DateConsultation'];} ?>">
                    <h2 class="info__title">Registre : </h2>
                    <input class="info__input" name="registre" value="<?php if(isset($_POST['registre'])){echo $_POST['registre'];}else{echo $donnees['RegistrePatient'];} ?>">
                    <?php
                    if($badRegistre){
                        echo '<label class="red"> Nom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Prescription : </h2>
                    <textarea class="info__textBox" name="prescription"><?php if(isset($_POST['prescription'])){echo $_POST['prescription'];}else{echo $donnees['Prescription'];} ?></textarea>
                    <h2 class="info__title">Notes : </h2>
                    <textarea class="info__textBox" name="note"><?php if(isset($_POST['note'])){echo $_POST['note'];}else{echo $donnees['Notes'];} ?></textarea>
                    <div class="button__container">
                        <a href="rdv.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            </section>
        </main>
        <?php } ?>
        <footer class="footer">
            <p> © 2016-2017 HEH ISFTR - développement </p>
            <p> Florian Simond </p>
            <p> Projet scolaire dans le cadre du cours de PHP </p>
        </footer>
	</body>
</html>