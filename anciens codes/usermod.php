<?php
    include('header.php');

    if(isset($_SESSION['Matricule'])){
        if(isset($_POST['nom']) || isset($_POST['prenom']) || isset($_POST['mail']) || (isset($_POST['oldMdp'])&&isset($_POST['newMdp'])&&isset($_POST['confirmedMdp']) && $_POST['newMdp']==$_POST['confirmedMdp'])){
            include_once("db.php");

            try 
            { 
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
        }else{
            echo "mauvaise condition";
        } 
    }else{
        echo "Pas de droit";
    }
?>