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
$userPseudo = $_SESSION['pseudo'];
// avatar de l utilisateur connecte
$userAvatar = $_SESSION['profilePicture'];
//recuperation du numero identiant apres la creation d un utilisateur
$creationId = $_SESSION['idCreate'];
// ---------------//----------------------
// variables de session
// ---------------//----------------------
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
		<title>CCI Messenger - Conversation</title>
		<meta name="author" content="Franck Jakubowski">
		<meta name="description" content="Une mini messagerie accessible après un login.">
		<!-- 
            favicons
         -->
		<!-- bootstrap stylesheet -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
            integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/messaging.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                debut du container pour afficher le tableau des derniers messages
        ----------------------------------------//------------------------------------------------>   
        <div class="container-fluid">            
            <div class="table-responsive">
                <!-- tableau des messages -->
                <table class="table table-striped table-sm">
                    <tbody>
                        <!-- creation de la ligne des entetes -->
                        <tr>
                            <th>MyPhoto</th>
                            <th>MyMsg</th>
                            <th>SenderMsg</th>
                            <th>SenderPhoto</th>
                        </tr>
                        <!-- /creation de la ligne des entetes -->

                        <!--------------------------------------------------------------------------
                                debut script php pour recuperer les donnees dans la table
                        ---------------------------------------------------------------------------->
                        <?php             
                             // preparation de la requete preparee 
                             
                             
                            // on appelle la fonction qui retourne le tableau de ligue 1
                                                   
                            // si la requete retourne un objet
                           
                                //  boucle pour creer les row 
                               // foreach ($conversationList as $key => $value) {
                        ?>
                                <!-- creation de la ligne associee a un club -->
                                <tr>
                                    <!-- on affiche dans la premiere colonne l avatar du receveur -->
                                    <td></td>
                                    <!-- on affiche les messages receveur-expediteur -->
                                    <td></td>
                                    <td></td>
                                    <!-- on affiche l avatar de l expediteur -->
                                    <td</td>
                                </tr>
                                <!-- /creation de la ligne associee a un club -->
                                <?php
                               // } 
                            // si la requete ne retourne rien
                            /*} else {
                                echo 'Aucune données dans la table classement !';
                            } */
                            ?>
                            <!--  /boucle pour creer les row -->                         
                    </tbody>
                </table>
                <!-- /tableau de la saison de ligue 1 2019/2020 -->            
            </div>
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
