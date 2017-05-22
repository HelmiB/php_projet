<?php
    session_start();
    
?>
<header class="header">
    <div class="linkContainer">
        <a href="patient.php"> Patient </a>
        <a href="rdv.php"> Agenda </a>
        <?php 
            if(isset($_SESSION['Admin']) && $_SESSION['Admin']==1){
                echo '<a href="medecin.php"> Médecin </a>';
            }
        ?>
    </div>  
    <div class="dropdown">
        <a href="profil.php" class="dropdown__title"> Profil </a>
        <div class="dropdown__content">
            <?php
                if(isset($_SESSION['Matricule'])){
                    echo '<a href="profil.php"> Informations personnelles </a>';
                    echo '<a href="service.php"> Services </a>';
                    echo '<a href="contact.php"> Contacter l\'administrateur </a>';
                    echo '<a href="logout.php"> Se déconnecter </a>';
                }else{
                    echo '<a href="inscription.php"> S\'inscrire </a>';
                    echo '<a href="index.php"> Se connecter </a>';
                }
            ?>
        </div>
    </div>
</header> 
