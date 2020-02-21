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
// on détruit les variables d erreur de login de notre session
unset ($_SESSION['showErrorLog'], $_SESSION['errorMsgLog']);
// message d erreur de creation
$_SESSION['showMsg']  = (isset($_SESSION['showMsg'])) ? $_SESSION['showMsg'] : false;
$_SESSION['message']  =  (isset($_SESSION['message'])) ? $_SESSION['message'] :'';
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
		<title>CCI Messenger - Liste des derniers messages</title>
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
                    debut du container pour afficher les derniers messages
        ----------------------------------------//------------------------------------------------>           
        <div class="container-fluid">
            <!-- titre de la page -->
            <div class="p-3 mt-5 mb-2 bg-info text-white">    
                <h1 class="text-center">Vous avez XXXXXX messagerie(s) en cours</h1> 
            </div>  
            <!-- /titre de la page -->
            <!-- area pour afficher un message d erreur lors de la creation -->
            <div class="show-bg <?=($_SESSION['showMsg']) ? '' : 'visible'; ?> text-center mt-5">
                <p class="lead mt-2"><span><?=$_SESSION['message'][0]; ?></span></p>
            </div>
            <!-- /area pour afficher un message d erreur lors de la creation -->           
            <div class="table-responsive">
                <!-- tableau des messages -->
                <table class="table table-striped table-sm">
                    <tbody>
                        <!-- creation de la ligne des entetes -->
                        <tr>
                            <th>Phto</th>
                            <th>Expéditeur</th>
                            <th>Action</th>
                        </tr>
                        <!-- /creation de la ligne des entetes -->

                        <!--------------------------------------------------------------------------
                                debut script php pour recuperer les donnees dans la table
                        ---------------------------------------------------------------------------->
                        <?php             
                             // preparation de la requete preparee 
                           $queryMsg = "SELECT u.userId, 
                                                                u.userPseudo AS pseudo,
                                                                u.userPicture AS pic,
                                                                max(t.create_at),
                                                                t.messageBody 
                                                    FROM messages t, messaging m, users u 
                                                    WHERE t.messagingId = m.messagingId 
                                                    AND m.senderId = u.userId
                                                    AND m.receiverId = 1";        
                            // on appelle la fonction qui retourne le tableau de ligue 1
                            $conversationList = dataReader($queryMsg);                        
                            // si la requete retourne un objet
                            if ($conversationList) {
                                //  boucle pour creer les row 
                                foreach ($conversationList as $key => $value) {
                        ?>
                                <!-- creation de la ligne associee a un club -->
                                <tr>
                                    <!-- on affiche dans la premiere colonne l avatar de l expediteur -->
                                    <td><img src="/img/profil_pictures/<?=$conversationList[$key]['pic']; ?>" alt="Photo du contact"></td>
                                    <!-- on affiche le pseudo et un resume du dernier message -->
                                    <td><?=$conversationList[$key]['pseudo']; ?></td>
                                    <!-- on affiche le bouton pour afficher la conversation -->
                                    <td class="d-flex justify-content-center"><a class="btn btn-dark" href="chat_current.php?usrId=<?= $current_Id; ?>">Show</a></td>
                                </tr>
                                <!-- /creation de la ligne associee a un club -->
                                <?php
                                } 
                            // si la requete ne retourne rien
                            } else {
                                echo 'Aucune données dans la table classement !';
                            } 
                            ?>
                            <!--  /boucle pour creer les row -->                         
                    </tbody>
                </table>
                <!-- /tableau  -->    
                <!-- lien vers le formulaire pour ajouter un club si admin -->
                <div class="mb-2 mx-auto">
                    <a class="btn btn-success btn-lg btn-block" href="/contacts_list.php">Nouvelle conversation</a>
                </div>         
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
