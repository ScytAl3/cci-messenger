<?php
// on démarre la session
session_start ();
// import du script pdo des fonctions sur la database
require 'pdo/pdo_db_functions.php';
// ---------------------------------------
// variables de session
// ---------------------------------------
// login en cours
$current_session = $_SESSION['session'];
// pseudo de l utilisateur connecte
$userPseudo = $_SESSION['current_Pseudo'];
// avatar de l utilisateur connecte
$userAvatar = $_SESSION['current_Avatar'];
// on détruit les variables d erreur de login de notre session
unset ($_SESSION['showErrorLog'], $_SESSION['errorMsgLog']);
// message d erreur de creation
$_SESSION['showErrorSignup']  = (isset($_SESSION['showErrorSignup'])) ? $_SESSION['showErrorSignup'] : false;
$_SESSION['errorMsgSignUp']  =  (isset($_SESSION['errorMsgSignUp'])) ? $_SESSION['errorMsgSignUp'] :'';
// recuperation des champs si le formulaire a ete envoye avec des erreurs
$userLastName = (isset($_SESSION['inputLastName'])) ? $_SESSION['inputLastName'] : '';
$userFirstName = (isset($_SESSION['inputFirstName'])) ? $_SESSION['inputFirstName'] : '';
$userPseudo = (isset($_SESSION['inputPseudo'])) ? $_SESSION['inputPseudo'] : '';
$userEmail = (isset($_SESSION['inputMail'])) ? $_SESSION['inputMail'] : '';
// ---------------//----------------------
// variables de session
// ---------------//----------------------
// verification que l utilisateur ne passe pas par l URL
if (!isset($_SESSION['session'])) {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- default Meta -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>CCI Messenger - Formulaire d'inscription</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Une mini messagerie accessible après un login.">
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/sign_up.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!-----------------------------------//-----------------------------------------
                 debut du container de la page du formulaire d inscription
        -------------------------------------//----------------------------------------->
        <div class="d-md-flex flex-md-equal w-100 mt-5 pl-md-3 justify-content-center">						            
            <div class="mr-md-3 px-md-5 col-md-8 bg-info">  			
				<!-- titre du formulaire -->              
				<div class="py-2 text-center">
					<h1><strong>INSCRIPTION</strong></h1>
					<!-- area pour afficher un message d erreur lors de la creation -->
					<div class="show-bg <?=($_SESSION['showErrorSignup']) ? '' : 'visible'; ?> text-center mt-5">
						<p class="lead mt-2"><span><?=$_SESSION['errorMsgSignUp']; ?></span></p>
					</div>
					<!-- /area pour afficher un message d erreur lors de la creation -->
					<hr class="mb-1">
				</div>
                <!-- titre du formulaire -->

				<!-- section pour afficher le formulaire d inscription -->
				<form class="form-inscription" action="forms_processing/signup_process.php" method="POST" enctype="multipart/form-data">
                    <!-- champs des saisies -->	
                    <!-- photo avatar -->
					<div class="mb-4">
						<label for="fileToUpload">Votre photo de profil</label>
                        <input class="form-control" id=" fileToUpload" name="fileToUpload" type="file" >
                    </div>
                    
                    <!-- nom -->
					<div class="mb-4">
						<label for="lastName">Nom</label>
						<input class="form-control" name="lastName" id="lastName" type="text" value="<?=$userLastName; ?>" required
							pattern="^[A-Z][a-z -]{1,75}$">
                    </div>	
                    		
					<!-- prenom -->
					<div class="mb-4">
						<label for="firstName">Prénom</label>
						<input class="form-control" name="firstName" id="firstName" type="text" value="<?=$userFirstName; ?>" required
							pattern="^[A-Z][a-z -]{1,75}$">
                    </div>		
                    
                    <!-- pseudo -->
					<div class="mb-4">
						<label for="pseudo">Pseudo</label>
						<input class="form-control" name="pseudo" id="pseudo" type="text" value="<?=$userPseudo; ?>" required >
					</div>

					<!-- email -->
					<div class="mb-4">
						<label for="email">Courriel</label>
						<input class="form-control" type="email" name="email" id="email"
							placeholder="utilisateur@domaine.fr" value="<?=$userEmail; ?>" required
							pattern="^[\w!#$%&'*+/=?`{|}~^-]+(?:\.[\w!#$%&'*+/=?`{|}~^-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,6}$">
						<span class="invalid-feedback" aria-live="polite">
					</div>

					<!-- Mot de passe -->
					<div class="mb-4">
						<label for="pwd1">Mot de passe</label>
						<input class="form-control" name="password" id="password" type="password" required>
					</div>
					<!-- Mot de passe confirmation -->
					<div class="mb-4">
						<label for="pwd2">Mot de passe <span class="text-muted">(confirmation)</span>
						</label>
						<input class="form-control" name="confirm_password" id="confirm_password"
							type="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
					</div>
					<!-- /champs des saisies -->

					<hr class="my-4">
					<!-- zone des boutons -->
					<div class="container mb-3">
						<div class="row justify-content-center">
							<!-- submit button -->
							<div class="col-md-4 mb-3">
								<button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
							</div>
							<!-- reset button -->
							<div class="col-md-4 mb-3">
								<button class="btn btn-primary btn-lg btn-block" type="reset">Reset</button>
							</div>
						</div>
					</div>
				</form>
				<!-- /section pour afficher le formulaire d inscription -->
            </div>
            <!-- /section pour afficher le formulaire de login -->
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
