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
// recuperation de l identifiant de l utilisateur connecte
$current_Id = $_SESSION['current_Id'];
// pseudo de l utilisateur connecte
$userPseudo = $_SESSION['current_Pseudo'];
// avatar de l utilisateur connecte
$userAvatar = $_SESSION['current_Avatar'];
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
		<title>CCI Messenger - Liste des contacts</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Une mini messagerie accessible après un login.">
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/contact.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                    debut du container pour afficher les derniers messages
        ----------------------------------------//------------------------------------------------>   
        <div class="container">  
            <!-- titre de la page -->
            <div class="p-3 mt-5 mb-2 bg-info text-white">    
                <h1 class="text-center">Séléctionnez un contact pour débuter une conversation</h1> 
            </div>  
            <!-- /titre de la page -->
            <br>        
            <!---------------------------------//-----------------------------------------
                    debut script php pour recuperer les donnees dans la table
            -----------------------------------//----------------------------------------->
            <?php  
                // on appelle la fonction qui retourne le tableau de ligue 1
                $contactsList = dataReader($current_Id);          
                // si la requete retourne un objet
                if ($contactsList) {
                    //  boucle pour creer les row 
                    foreach ($contactsList as $contact => $column) {
            ?>
            <div class="card bg-light border-success mb-3 w-100">
                <div class="card-body">
                    <div class="d-flex ">
                        <img class="avatar-circle" src="/img/profil_pictures/<?=$contactsList[$contact]['userPicture']; ?>" alt="Photo du contact">             
                        <div class="ml-4 align-self-center">
                            <h2 class="card-title"><?=$contactsList[$contact]['userPseudo']; ?></h2>
                            <h4 class="card-text"><?=$contactsList[$contact]['userLastName']; ?>&nbsp;&nbsp;<?=$contactsList[$contact]['userFirstName']; ?></h4>
                        </div>
                        <div class="ml-auto align-self-center">
                            <a href="chat_current.php?contactId=<?=$contactsList[$contact]['userId']; ?>&contactAvatar=<?=$contactsList[$contact]['userPicture']; ?>&contactPseudo=<?=$contactsList[$contact]['userPseudo']; ?>" class="btn btn-primary">Select</a>
                        </div>
                    </div>
                </div>
            </div>  
            <?php
            } 
            // si la requete ne retourne rien
            } else {
                echo 'Aucune données dans la table classement !';
            } 
            ?>
        </div>
        <!--------------------------------------//------------------------------------------------
                    debut du container pour afficher les derniers messages
        ----------------------------------------//------------------------------------------------> 
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
