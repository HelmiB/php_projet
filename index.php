<!DOCTYPE html>
<html>
	<head>
		<meta charset ="utf-8"> 
		<title>Hopital</title>
        <link rel="stylesheet" href="style.css">
        <meta name='viewport' content="width=device-width, initial-scale=1">
	</head>
	<body>
        <?php 
        include("header.php");
        $badlogin = false;
        $badMDP = false;
        if(!isset($_SESSION['Matricule'])){
            if(isset($_POST['login'])&& isset($_POST['mdp'])){
                if(preg_match("#^[1-9][0-9]{5}#", $_POST['login'])){
                    try{
                        include_once("db.php");
                        
                        $req= $bd ->prepare('SELECT * FROM users WHERE Matricule = :login');
                        $req->execute(array('login' => $_POST['login']));
                        $donnees = $req->fetch();
                        if(!empty($donnees)){
                            if(password_verify($_POST['mdp'], $donnees['Password'])){
                                $_SESSION['Nom']=$donnees['Nom'];
                                $_SESSION['Prenom']=$donnees['Prenom'];
                                $_SESSION['Mail']=$donnees['Email'];
                                $_SESSION['Matricule']=$donnees['Matricule'];
                                $_SESSION['Admin']=$donnees['Droit'];
                                $_SESSION['Service']=$donnees['Service'];
                                echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
                            }else{
                                $badMDP=true;
                            }
                        } 
                        else{
                            $badlogin=true;
                        }
                    }
                catch (Exception $e) {
                        echo 'Erreur de connexion à la BD '.$e;
                    }
                }else{
                    $badlogin = true;
                }
            }
        }else{
            echo '<meta http-equiv="refresh" content="0;url=profil.php"/>';
        }
        ?>      
        <main class="main main--full">
            <section class=" section__left about">
                <h1 class="about__title uppercase"> About </h1>
                <p class="about__text"> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam sed dapibus leo, nec dignissim eros. Quisque eros magna, faucibus et lobortis et, interdum in purus. Duis nulla massa, imperdiet non odio vel, euismod laoreet urna. Maecenas rutrum pellentesque tempor. Ut mollis enim odio, vitae eleifend ante malesuada condimentum. Suspendisse potenti </p>
            </section>
            <section class="login">
                <form method="POST" action="index.php" class="login__form">
                    <div class="login__content">
                        <h2 class="login__title"> Matricule : </h2>
                        <input type="text" class="input" name="login" placeholder="Entrez votre matricule">
                        <?php
                        if($badlogin){
                            echo '<label class="red"> Mauvais matricule</label>';
                        }
                        ?>
                            
                    </div>
                    <div class="login__content">
                        <h2 class="login__title"> Mot de passe : </h2>
                        <input type="password" class="input" name="mdp" placeholder="Entrez votre mot de passe">
                        <?php
                        if($badMDP){
                            echo '<label class="red"> Mauvais mot de passe </label>';
                        }
                        ?>
                        
                    </div>

                    <a href="inscription.php" class="login__link login__link--inscription"> S'inscrire </a>
                    <button type="submit" class="login__link login__link--connexion"> Se connecter </button>
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