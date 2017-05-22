<?php
date_default_timezone_set('Europe/Brussels');
$hote='localhost';
$nomBD='hopital';	
$user='root';	
$mdp='';	
$bd=new PDO('mysql:host='.$hote.';dbname='.$nomBD.';charset=UTF8',$user,$mdp);
?>
