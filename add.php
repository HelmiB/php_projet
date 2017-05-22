<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Ajouter médecin</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
		<?php 
            include('header.php');
            if(!isset($_SESSION['Nom'])||!isset($_SESSION['Prenom'])){
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            $badNom=false;
            $badPrenom=false;
            $badMatricule=false;
            $badMail=false;
            $badMDP=false;
            $badConfirmedMDP=false;
            $badRegistre=false;
            $badSexe=false;
            $badRue=false;
            $badNumero=false;
            $badBoite=false;
            $badCP=false;
            $badVille=false;
            $badPathologie=false;
            if(isset($_GET['add'])){
                if($_GET['add']=='medecin' && $_SESSION['Admin']==1){
                    if(isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['matricule']) && isset($_POST['email']) && isset($_POST['mdp']) && isset($_POST['mdpConfirmed'])){
                        if($_POST['mdp']!=$_POST['mdpConfirmed']){
                            $badConfirmedMDP=true;
                        }
                        if(!preg_match("#^[A-Z][a-z]{1,49}$#", $_POST['nom'])){
                            $badNom=true;
                        }
                        if(!preg_match("#^[A-Z][a-zA-Z\ ]{1,80}$#",$_POST['prenom'])){
                            $badPrenom=true;
                        }
                        if(!preg_match("#^[1-9][0-9]{5}$#",$_POST['matricule'])){
                            $badMatricule=true;
                        }
                        if(!preg_match("#^[0-9a-z\-\_\.]{1,}@[0-9a-z](\.?[0-9a-z])+\.?([a-z]){2,}$#",$_POST['email'])){
                            $badMail=true;
                        }
                        if(!preg_match("#^[\S]{4,}#", $_POST['mdp'])){
                            $badMDP=true;
                        }
                        if(!$badNom && !$badPrenom && !$badMatricule && !$badMail && !$badMDP && !$badConfirmedMDP){
                            try{
                                include_once('db.php');
                                $mdp1 = password_hash($_POST['mdp'], PASSWORD_BCRYPT);
                                $login = intval($_POST['matricule']);
                                
                                if($_POST['service']==''){
                                    echo 'aucun service';
                                    $req= $bd->prepare('INSERT INTO users(Matricule,Prenom,Nom,Email,Password,Droit) VALUE (:Matricule,:Prenom,:Nom,:Email,:Password,:Droit)');
                                    $req->execute(array('Matricule' =>$login, 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Email' =>$_POST['email'], 'Password' =>$mdp1, 'Droit' =>0));
                                }else{
                                    $req= $bd->prepare('INSERT INTO users VALUE (:Matricule,:Prenom,:Nom,:Email,:Password,:Droit,:Service)');
                                    $req->execute(array('Matricule' =>$login, 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Email' =>$_POST['email'], 'Password' =>$mdp1, 'Droit' =>0, 'Service' =>$_POST['service']));
                                }
            
                                echo 'go check DB';                 
                                echo '<meta http-equiv="refresh" content="0;url=medecin.php"/>';
                            }catch(Exeption $e){
                                echo'erreur de connection à la db'+$e;
                            }
                        }
                    }
                }
                else if($_GET['add']=='patient'){
                    if(isset($_POST['registre']) && isset($_POST['nom']) && isset($_POST['prenom'])&& isset($_POST['sexe']) && isset($_POST['rue']) && isset($_POST['numero']) && isset($_POST['cp']) && isset($_POST['ville']) && isset($_POST['pathologie'])){
                        if(!preg_match("#[0-9]{9}$#",$_POST['registre'])){
                            $badRegistre=true;
                        }
                        if(!preg_match("#^[A-Z][a-z]{1,49}$#", $_POST['nom'])){
                            $badNom=true;
                        }
                        if(!preg_match("#^[A-Z][a-zA-Z\ ]{1,80}$#",$_POST['prenom'])){
                            $badPrenom=true;
                        }
                        if(!preg_match("#F|M#",$_POST['sexe'])){
                            $badSexe=true;
                        }
                        if(!preg_match("#[A-Za-z\ ]{1,100}$#",$_POST['rue'])){
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
                        if(!preg_match("#[A-Z0-9]{0,10}#",$_POST['Boite'])){
                            $badBoite=true;
                        }
                        if(!$badRegistre && !$badNom && !$badPrenom && !$badSexe && !$badRue && !$badNumero && !$badCP && !$badVille && !$badPathologie && !$badBoite){
                            try{
                                include_once('db.php');
                                $req= $bd->prepare('INSERT INTO patient VALUE (:Registre,:Prenom,:Nom,:Sexe,:Rue,:Numero,:Boite,:CP,:Ville,:Pathologie)');
                                $req->execute(array('Registre' =>$_POST['registre'], 'Prenom' =>$_POST['prenom'], 'Nom' =>$_POST['nom'], 'Sexe' =>$_POST['sexe'], 'Rue' =>$_POST['rue'], 'Numero' =>$_POST['numero'], 'Boite' =>$_POST['boite'], 'CP' =>$_POST['cp'], 'Ville' =>$_POST['ville'], 'Pathologie' =>$_POST['pathologie']));   
                                echo '<meta http-equiv="refresh" content="0;url=patient.php"/>';
                            }catch(Execption $e){
                                echo 'erreur de connection à la db'.$e;
                            }
                        }
                    }
                }
                else if($_GET['add']=='service'){
                    if(isset($_POST['choix'])){
                        try {
                            include_once("db.php");
                            
                            $req= $bd->prepare('UPDATE users SET Service = :Service WHERE Matricule=:Matricule');
                            $req->execute(array('Service' =>$_POST['choix'], 'Matricule'=>$_SESSION['Matricule']));

                            $_SESSION['Service']=$_POST['choix'];
                            echo 'va vérifier dans la db !!';
                            echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
                        }
                        catch (Exception $e) 
                        {
                            echo 'Erreur de connexion à la BD '.$e;
                        }
                    }
                }
                else if($_GET['add']=='seance'){
                    if(isset($_POST['date']) && isset($_POST['registre']) && isset($_POST['prescription']) && isset($_POST['note'])){
                        if(!preg_match("#[0-9]{9}$#",$_POST['registre'])){
                            $badRegistre=true;
                        }
                        echo $_POST['date'];
                        strip_tags($_POST['prescription']);
                        strip_tags($_POST['note']);
                        if(!$badRegistre){
                            try{
                                include_once('db.php');
                                $req= $bd->prepare('INSERT INTO consultation (MatriculeMedecin, RegistrePatient, Prescription, Notes, DateConsultation) VALUES (:Matricule, :Registre, :Prescription, :Note, :DateConsultation)');
                                $req->execute(array('Matricule' =>$_SESSION['Matricule'], 'Registre' =>$_POST['registre'], 'Prescription' =>$_POST['prescription'], 'Note' =>$_POST['note'], 'DateConsultation' =>$_POST['date']));
                                echo 'go check db';
                                echo '<meta http-equiv="refresh" content="0;url=rdv.php"/>';
                            }catch(Exeption $e){
                                echo 'erreur de co a la db'.$e;
                            }
                        }
                    }
                }
                else{
                    echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
                }
            }else{
                echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
            }
        ?>
        <main class="main">
            <section class="section__right section--full">
            <?php if($_GET['add']=="medecin"){?>
                <form class="info" method="POST" action="add.php?add=medecin">
                    <h2 class="info__title">Matricule : </h2>
                    <input class="info__input" name="matricule" value="<?php if(isset($_POST['matricule'])){echo $_POST['matricule'];} ?>">
                    <?php
                    if($badMatricule){
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
                        echo '<label class="red"> Prenom invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Email : </h2>
                    <input class="info__input" name="email" value="<?php if(isset($_POST['email'])){echo $_POST['email'];} ?>">
                    <?php
                    if($badMail){
                        echo '<label class="red"> Email invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Mot de passe : </h2>
                    <input type='password' class="info__input" name="mdp">
                    <?php
                    if($badMDP){
                        echo '<label class="red"> Mot de passe invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Confirmer mot de passe : </h2>
                    <input type='password' class="info__input" name="mdpConfirmed">
                    <?php
                    if($badConfirmedMDP){
                        echo '<label class="red"> Les 2 mots de passe ne sont pas identiques </label>';
                    }
                    ?>
                    <h2 class="info__title">Service : </h2>
                    <input class="info__input" name="service">
                    <div class="button__container">
                        <a href="medecin.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            <?php } 
            if($_GET['add']=='patient'){?>
                <form class="info" method="POST" action="add.php?add=patient">
                    <h2 class="info__title">N° de registre national : </h2>
                    <input class="info__input" name="registre" value="<?php if(isset($_POST['registre'])){echo $_POST['registre'];} ?>">
                    <?php 
                    if($badRegistre){
                        echo '<label class="red"> Numéro de registre invalide </label>';
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
                    <h2 class="info__title">Sexe : </h2>
                    <input class="info__input" name="sexe" value="<?php if(isset($_POST['sexe'])){echo $_POST['sexe'];} ?>">
                    <?php 
                    if($badSexe){
                        echo '<label class="red"> Sexe invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Rue : </h2>
                    <input class="info__input" name="rue" value="<?php if(isset($_POST['rue'])){echo $_POST['rue'];} ?>">
                    <?php 
                    if($badRue){
                        echo '<label class="red"> Rue invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Numéro : </h2>
                    <input class="info__input" name="numero" value="<?php if(isset($_POST['numero'])){echo $_POST['numero'];} ?>">
                    <?php 
                    if($badNumero){
                        echo '<label class="red"> Numéro invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Boite : </h2>
                    <input class="info__input" name="boite" value="<?php if(isset($_POST['boite'])){echo $_POST['boite'];} ?>">
                    <?php 
                    if($badBoite){
                        echo '<label class="red"> Boite invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Code Postal : </h2>
                    <input class="info__input" name="cp" value="<?php if(isset($_POST['cp'])){echo $_POST['cp'];} ?>">
                    <?php 
                    if($badCP){
                        echo '<label class="red"> Code postal invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Ville : </h2>
                    <input class="info__input" name="ville" value="<?php if(isset($_POST['ville'])){echo $_POST['ville'];} ?>">
                    <?php 
                    if($badVille){
                        echo '<label class="red"> Ville invalide </label>';
                    }
                    ?>
                    <h2 class="info__title">Pathologie : </h2>
                    <input class="info__input" name="pathologie" value="<?php if(isset($_POST['pathologie'])){echo $_POST['pathologie'];} ?>">
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
            <?php }
            if($_GET['add']=='service'){?>
                <form method="POST" action="add.php?add=service">
                    <label class="add__choix"> S'inscrire au service de : </label>
                    <select class="service__comboBox" name="choix">
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
                    </select>
                    <div class="button__container">
                        <a href="service.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            <?php }
            if($_GET['add']=='seance'){?>
                <form class='info' method="POST" action"add.php?add=seance">
                    <h2 class="info__title"> Date de la séance </h2>
                    <input class="info__input" name="date" type="date" value="<?php if(isset($_POST['date'])){echo $_POST['date'];} ?>">
                    <h2 class="info__title"> Numéro de registre national du patient</h2>
                    <input class="info__input" name="registre" value="<?php if(isset($_POST['registre'])){echo $_POST['registre'];} ?>">
                    <?php 
                    if($badRegistre){
                        echo '<label class="red"> Numéro de registre invalide </label>';
                    }
                    ?>
                    <h2 class="info__title"> Presciption </h2>
                    <textarea class="info__textBox" name="prescription"><?php if(isset($_POST['prescription'])){echo $_POST['prescription'];} ?></textarea>
                    <h2 class="info__title"> Notes </h2>
                    <textarea class="info__textBox" name="note"><?php if(isset($_POST['note'])){echo $_POST['note'];} ?></textarea>
                    <div class="button__container">
                        <a href="service.php" class="info__cancel">Annuler</a>
                        <button type="submit" class="info__submit">Confirmer</button>
                    </div>
                </form>
            <?php } ?>
            </section>
        </main>
        <footer class="footer">
            <p> © 2016-2017 HEH ISFTR - développement </p>
            <p> Florian Simond </p>
            <p> Projet scolaire dans le cadre du cours de PHP </p>
        </footer>
	</body>
</html>