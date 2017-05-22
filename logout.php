<?php
include("header.php");
    if(isset($_SESSION['Matricule']))
    {
        session_destroy();
        
    }
echo '<meta http-equiv="refresh" content="0;url=index.php"/>';
?>