<?php
include("header.php");

if(isset($_SESSION['Matricule']))
{
    if(isset($_GET['matricule']) && ($_SESSION['Matricule']==$_GET['matricule'] || $_SESSION['Admin']==1)){
        try{
            include_once("db.php");
            
            $req= $bd -> prepare('DELETE FROM users WHERE Matricule = :Matricule');
            $req->execute(array('Matricule'=>$_GET['matricule']));
            if($_SESSION['Matricule']==$_GET['matricule']){
                session_destroy();
                echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
            }
            echo '<meta http-equiv="refresh" content="0;url=medecin.php"/>';
        }catch (Exception $e){
            echo ("Erreur : "+$e);
        }
    }
    if(isset($_GET['registre']))
    {
        try{
            include_once("db.php");
            
            $req= $bd -> prepare('DELETE FROM patient WHERE Registre = :Registre');
            $req->execute(array('Registre'=>$_GET['registre']));
            echo '<meta http-equiv="refresh" content="0;url=patient.php"/>';
        }catch (Exception $e){
            echo ("Erreur : "+$e);
        }
    }
    if(isset($_GET['ID'])){
        try{
            include_once('db.php');

            $req= $bd->prepare('DELETE FROM consultation WHERE ID = :ID');
            $req->execute(array('ID' =>$_GET['ID']));
            echo '<meta http-equiv="refresh" content="0;url=rdv.php"/>';
        }catch(Exception $e){
            echo 'erreur '+$e;
        }
    }
}
?>