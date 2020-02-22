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
// reuperation des informations du contact
$_SESSION['contactId'] = (isset($_SESSION['contactId'])) ? $_SESSION['contactId'] : $_GET['contactId'];
$_SESSION['contactAvatar'] = (isset($_SESSION['contactAvatar'])) ? $_SESSION['contactAvatar'] : $_GET['contactAvatar'];
$_SESSION['contactPseudo'] = (isset($_SESSION['contactPseudo'])) ? $_SESSION['contactPseudo'] : $_GET['contactPseudo'];
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
		<link href="css/chat_current.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//------------------------------------------------
                    debut du container pour afficher la conversation en cours
        ----------------------------------------//------------------------------------------------>   
        <div class="container mt-5">
            <!--------------------------------------//-------------------------------------------
                    debut script php pour recuperer les donnees de la conversation
            ----------------------------------------//------------------------------------------->
            <?php
                // on recupere la variable de session de l identifant du contact
                $contact_Id = $_SESSION['contactId'];
                // on appelle la fonction qui retourne les donnees
                $conversation = messageReader($current_Id, $contact_Id);               
                //
                //var_dump($conversation); die;
                //       
                // si la requete retourne un objet
                if ($conversation) {
                    //  boucle pour creer les row 
                    foreach ($conversation as $message => $column) {
                        if ($conversation[$message]['receiverId'] == $current_Id ) {
                        ?> 
                        <div class="mb-3 w-75 mr-auto">                            
                                <div class="d-flex">
                                    <img class="avatar-circle" src="/img/profil_pictures/<?=$userAvatar ?>" alt="Ma photo">             
                                    <div class="ml-4">
                                        <p class="card-text"><?=$conversation[$message]['create_at']; ?></p>
                                        <h3 class="card-title p-2 message-receiver-bg"><?=$conversation[$message]['messageBody']; ?></h3>                                        
                                    </div>
                                </div>                            
                        </div> 
                        <?php
                        } else {
                        ?>
                        <div class="mb-3 w-75 ml-auto">
                            <div>
                                <div class="d-flex justify-content-end">                                               
                                    <div class="mr-4 px-3 py-2 text-right">
                                        <p class="card-text"><?=$conversation[$message]['create_at']; ?></p>
                                        <h3 class="card-title p-2 message-sender-bg"><?=$conversation[$message]['messageBody']; ?></h3>
                                    </div>
                                    <img class="avatar-circle" src="/img/profil_pictures/<?=$_SESSION['contactAvatar'] ?>" alt="Photo du contact">  
                                </div>
                            </div>
                        </div> 
                        <?php
                            }
                        }
                    } else {
                    ?>
                    <div class="mb-3 w-100">                                                                       
                        <div class="mr-4 px-3 py-2 text-center message-sender-bg">
                            <h2 class="card-title">C'est votre première conversation avec <strong><?=$_SESSION['contactPseudo'] ?> !</h2>
                        </div>
                    </div> 
                    <?php
                    }
                    ?>   
            <!-- formulaire pour saisir du texte -->             
            <div class="card text-white bg-success px-3 py-2 mb-3 w-100">                    
                <form class="form-inscription" action="/forms_processing/message_sending_process.php" method="POST">    
                    <div class="d-flex ">                                
                        <div class="w-100 align-self-center">
                            <textarea class="form-control" name="messageSend"   id="messageSend" placeholder="Votre message message.." required></textarea>
                            <input type="hidden" id="custId" name="custId" value="3487">
                            <input type="hidden" id="custId" name="custId" value="3487">
                            <input type="hidden" id="custId" name="custId" value="3487">
                            <input type="hidden" id="custId" name="custId" value="3487">
                        </div>
                        <div class="ml-auto">
                            <button class="btn btn-primary btn-lg btn-block  h-100 align-items-stretch" type="submit" name="sendMessage">Submit</button>
                        </div>
                    </div>
                </form>                     
            </div>
            <!-- f/ormulaire pour saisir du texte -->
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
