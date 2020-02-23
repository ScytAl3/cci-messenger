<?php
// on démarre la session
session_start ();
// ---------------//------------------------
// variables de session
// ---------------//------------------------
// login en cours
$_SESSION['session'] = (isset($_SESSION['session'])) ? $_SESSION['session'] : false;
// peudo de l utilisateur connecte
$_SESSION['current_Pseudo']  =  (isset($_SESSION['current_Pseudo'])) ? $_SESSION['current_Pseudo'] : '';
// avatar de l utilisateur connecte
$_SESSION['current_Avatar'] = (isset($_SESSION['current_Avatar'])) ? $_SESSION['current_Avatar'] : '';
// message d erreur de login
$_SESSION['showErrorLog']  = (isset($_SESSION['showErrorLog'])) ? $_SESSION['showErrorLog'] : false;
$_SESSION['errorMsgLog']  =  (isset($_SESSION['errorMsgLog'])) ? $_SESSION['errorMsgLog'] :'';
// ---------------//------------------------
// variables de session
// ---------------//------------------------
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- default Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CCI Messenger - login</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Une mini messagerie accessible après un login.">
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/index.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body> 
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!------------------------------//--------------------------------------------
                            debut du container de la page de login 
        --------------------------------//-------------------------------------------->   
        <!-- container de la page de login -->   
        <div class="container">
            <div class="d-md-flex flex-md-equal w-100 my-md-3 pl-md-3 justify-content-center">        
                <!-- section pour afficher le formulaire de login -->
                <div class="bg-light mr-md-3 pt-3 px-3 pt-md-5 px-md-5 text-center overflow-hidden">                
                    <div class="my-3 p-3">
                        <!-- message pour tester la connexion a la base de donnees -->
                        <div class="show-bg">
                            <?php require 'pdo/pdo_db_connect.php'; 
                                // on instancie une connexion
                                $pdo = my_pdo_connexxion();
                                if ($pdo) {
                                    echo 'Connexion réussie à la base de données';
                                } else {
                                    var_dump($pdo);
                                }
                            ?>                            
                            </div>
                        <!-- /message d information pour la connexion a la base de donnees -->

                        <!-- titre de la section du formulaire -->
                        <div class="text-center mx-auto">
                            <h2 class="display-4 font-weight-bold text-muted">Accéder à votre messagerie</h2>                       
                            <!-- area pour afficher un message d erreur lors du login -->
                            <div class="show-bg<?= ($_SESSION['showErrorLog'])? '' : 'visible'; ?> text-center mt-5">
                                <p class="lead mt-2"><span><?= $_SESSION['errorMsgLog']; ?></span></p>
                            </div>
                            <!-- /area pour afficher un message d erreur lors du login -->
                        </div>
                        <!-- /titre de la section du formulaire -->

                        <!-- formulaire de connexion -->
                        <div class="<?=($_SESSION['session'])? 'invisible' : 'visible' ; ?>">
                            <form class="form-signin" method="POST" action="forms_processing/login_process.php">
                                <!-- email input -->
                                <div class="input-group margin-bottom-sm">
                                    <input class="form-control fa fa-qq" type="text" name="pseudo" id="pseudo" placeholder="&#xf1d6; Votre pseudo"  required autofocus="">
                                </div>
                                <!-- password input -->
                                <div class="input-group">
                                    <input class="form-control fa fa-key" type="password" name="password" id="password" placeholder="&#xf084; Password" required>
                                </div>
                                <!-- buttons -->
                                <div class="mb-3">
                                    <button class="btn btn-primary btn-lg btn-block" type="submit">LOGIN</button>
                                    <a class="btn btn-primary btn-lg btn-block" name="signup" role="button" href="sign_up.php">SIGN UP</a>
                                </div>
                            </form>
                        </div>
                        <!-- /formulaire de connexion -->
                    </div>            
                </div>
                <!-- /section pour afficher le formulaire de login -->
            </div>
        </div>
        <!-- /container de la page de login -->
<!-- ---------------------//----------------------------- -->
<?php var_dump($_SESSION); ?>
<!-- ----------------- ---//----------------------------- -->
        <!-- import scripts -->
		<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
			integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n"
			crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
			integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
			crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
			integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6"
			crossorigin="anonymous"></script>
		<!-- /import scripts -->
        
	</body>
</html>
