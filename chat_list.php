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
// on détruit les variables d erreur de login de notre session
unset ($_SESSION['showErrorSignup'], $_SESSION['errorMsgSignUp']);
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
		<title>CCI Messenger - Liste des messageries en cours</title>
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
		<link href="css/chat_list.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                            debut du container pour afficher les messageries
        ----------------------------------------//------------------------------------------------>           
        <div class="container-fluid">            
            <!---------------------------------//-----------------------------------------
                    debut script php pour recuperer les donnees dans la table
            -----------------------------------//----------------------------------------->
            <?php   
                // on appelle la fonction qui retourne le tableau de ligue 1
                $messagerieList = allMessaging($current_Id);          
                //
                //var_dump($messagerieList); die;
                //
                // si la requete retourne un objet
                if ($messagerieList) {
                    // on compte le nombre d'item dans l array
                    $countMessagerie = count($messagerieList); 
                    // on affiche un message avec le nombre de messageries
                ?>
                <!-- titre de la page avec le nombre de messagerie existantes -->
                <div class="my-3 w-100">                                                                       
                    <div class="mx-auto px-3 py-2 text-center info-message-bg">
                        <h2 class="card-title">Vous avez <strong><?= $countMessagerie ?></strong> messagerie(s) en cours</h2>
                    </div>
                </div>
                <!-- /titre de la page avec le nombre de messagerie existantes --> 
            <?php 
                //  boucle pour afficher les messageries
                foreach ($messagerieList as $contact => $column) {
            ?>
            <!-- on recupere les valeurs des differents champs d une ligne -->             
            <div class="container-fluid card-header mb-3">
                <div class="row">
                    <!-- photo avatar -->
                    <div class="col">
                        <img class="avatar-circle" src="/img/profil_pictures/<?=$messagerieList[$contact]['userPicture']; ?>" alt="Photo du contact">         
                    </div>
                    <!-- /photo avatar -->
                    <!-- pseudo & presentation -->
                    <div class="col-10 align-self-center">
                        <h2 class="card-title"><strong><?=$messagerieList[$contact]['userPseudo']; ?></strong></h2>
                        <h4 class="card-text text-truncate">Lorem ipsum dolor sit amet consectetur adipisicing elit. Aperiam quasi voluptate expedita aspernatur veniam, voluptatem qui praesentium consequatur quo, fugit dignissimos magni illo atque facere non fugiat provident maxime iste.</h4>
                    </div>
                    <!-- /pseudo & presentation -->
                    <!-- bouton pour afficher la messagerie selectionnee --> 
                    <div class="col align-self-center text-right">
                        <a class ="direction-arrow"href="chat_current.php?contactId=<?=$messagerieList[$contact]['userId']; ?>&contactAvatar=<?=$messagerieList[$contact]['userPicture']; ?>&contactPseudo=<?=$messagerieList[$contact]['userPseudo']; ?>"><i class="fa fa-chevron-right fa-lg"></i></a>
                    </div>
                    <!-- /bouton pour afficher la messagerie selectionnee --> 
                </div>
            </div>  
            <?php
            } 
            // si la requete ne retourne rien
            } else {
            ?>
            <div class="my-3 w-100">                                                                       
                <div class="mr-4 px-3 py-2 text-center info-message-bg">
                    <h2 class="card-title">Vous n'avez aucune messagerie pour l'instant !</h2>
                </div>
            </div> 
            <?php
            }
            ?>            
            <!-- lien vers la liste des utilisateurs -->
            <div class="mb-2 mx-auto">
                <a class="btn btn-success btn-lg btn-block" href="/contacts_list.php">- Nouvelle conversation -</a>
            </div> 
            <!-- /lien vers la liste des utilisateurs -->
        </div>
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
