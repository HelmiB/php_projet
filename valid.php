<?php
    include('header.php');
    if(isset($_GET['ticket'])){
        include_once('db.php');
        if($_GET['valid']=='inscription'){
            try{
                /*$req= $bd -> query('SELECT * FROM ticket WHERE IDTicket ='.$_GET['ticket'].'');
                $donnees = $req->fetch();
                echo ($donnees['matricule'].'   ');
                echo ($donnees['newName'].'   ');
                echo ($donnees['newFirstName'].'   ');
                echo ($donnees['newMail'].'   ');
                echo ($donnees['newMdp'].'   ');
                
                $matricule = intval($donnees['matricule']);
                $req2= $bd->prepare('INSERT INTO users VALUE (:Matricule,:Prenom,:Nom,:Email,:Password,:Droit');
                $req2->execute(array('Matricule' =>$matricule, 'Prenom' =>$donnees['newFirstName'], 'Nom' =>$donnees['newName'], 'Email' =>$donnees['newMail'], 'Password' =>$donnees['newMdp'], 'Droit' =>0));

                //$req= $bd -> query('DELETE FROM ticket WHERE IDTicket = '.$_GET['ticket'].'');*/

                $req = $bd -> query('INSERT INTO users(Matricule, Prenom, Nom, Email, Password) SELECT matricule, newFirstName, newName, newMail, newMdp FROM ticket WHERE IDTicket = '.$_GET['ticket'].'');
                $req = $bd -> query('UPDATE ticket SET traite = 1 WHERE IDTicket = '.$_GET['ticket'].'');
                echo 'va vérifier dans la db !!';
                echo '<meta http-equiv="refresh" content="0;url=admin.php"/>';
            }catch(Exeption $e){
                echo 'Erreur de connection a la DB'+$e;
            }
        }
        if($_GET['valid']=='modification'){
            try{
                $req = $bd->query('SELECT * FROM ticket WHERE IDTicket='.$_GET['ticket']);
                $donnees = $req->fetch();
                $req = $bd->prepare('UPDATE users SET Nom=:Nom, Prenom=:Prenom, Email=:Email, Password=:Password WHERE Matricule='.$donnees['matricule']);
                $req->execute(array( 'Nom' =>$donnees['newName'], 'Prenom' =>$donnees['newFirstName'], 'Email' =>$donnees['newMail'], 'Password' =>$donnees['newMdp']));
                $req = $bd -> query('UPDATE ticket SET traite = 1 WHERE IDTicket = '.$_GET['ticket'].'');
                $_SESSION['Nom']==$donnees['newName'];
                $_SESSION['Prenom']==$donnees['newFirstName'];
                $_SESSION['Mail']==$donnees['newMail'];
                echo 'va vérifier dans la db !!';
                echo '<meta http-equiv="refresh" content="0;url=admin.php"/>';
            }catch(Exeption $e){
                echo 'Erreur de connection a la DB'+$e;
            }
        } 
        $req = $bd -> query('UPDATE ticket SET traite = 1 WHERE IDTicket = '.$_GET['ticket'].'');
        echo '<meta http-equiv="refresh" content="0;url=admin.php"/>';
    }
?>