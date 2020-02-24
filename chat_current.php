<?php
// on démarre la session
session_start ();
// verification que l utilisateur ne passe pas par l URL
if (isset($_SESSION['session']) && $_SESSION['session'] == false) {
    header('location:index.php');
}
// import du script pdo des fonctions sur la database
require 'pdo/pdo_db_functions.php';
// ----------------------------//---------------------------
//                  variables de session
// ---------------------------------------------------------
// login en cours
$current_session = $_SESSION['session'];
// recuperation de l identifiant de l utilisateur connecte
$current_Id = $_SESSION['current_Id'];
// pseudo de l utilisateur connecte
$userPseudo = $_SESSION['current_Pseudo'];
// avatar de l utilisateur connecte
$userAvatar = $_SESSION['current_Avatar'];
// reuperation des informations du contact
$_SESSION['contact_Id'] = (isset($_GET['contactId'])) ? $_GET['contactId'] : $_SESSION['contact_Id'];
$_SESSION['contact_Avatar'] = (isset($_GET['contactAvatar'])) ? $_GET['contactAvatar'] : $_SESSION['contact_Avatar'];
$_SESSION['contact_Pseudo'] = (isset($_GET['contactPseudo'])) ? $_GET['contactPseudo'] : $_SESSION['contact_Pseudo'];
/// ----------------------------------------------------------
//                  variables de session
// ----------------------------//-----------------------------
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
        <!-- font awesome stylesheet -->
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- default stylesheet -->
		<link href="css/chat_current.css" rel="stylesheet" type="text/css">
        <!-- includes stylesheet -->
        <link href="css/header.css" rel="stylesheet" type="text/css">
    </head>    
    
	<body>   
        <!-- import du header -->
        <?php include 'includes/header.php'; ?>
        <!-- /import du header -->
        <!--------------------------------------//--------------------------------------------------
                    debut du container global pour afficher la conversation en cours
        ------------------------------------------------------------------------------------------->   
        <div class="container-fluid mt-5">
            <!--------------------------------------//---------------------------------------------
                ## debut script php pour recuperer les donnees de la conversation ##
            ----------------------------------------//--------------------------------------------->
            <?php
                // on recupere la variable de session de l identifant du contact
                $contact_Id = $_SESSION['contact_Id'];
                // on appelle la fonction qui retourne les messages de la conversation
                $conversation = messageList($current_Id, $contact_Id); 
                // si la requete retourne un objet
                if ($conversation) {
                // on recupere les informations du dernier objet (message) du tableau $conversation : le plus recent
                $lastAvatar = (end($conversation)['senderId'] == $contact_Id) ? $_SESSION['contact_Avatar'] : $userAvatar;
                $lastPseudo = (end($conversation)['senderId'] == $contact_Id) ? $_SESSION['contact_Pseudo'] : $userPseudo;
                // on recupere la date renvoyee par MySQL
                $lastDateTime = date_create(end($conversation)['create_at']);
                // on appelle la fonction qui la transfome au format choisi
                $formatDate = formatedDateTime($lastDateTime);
                ?>
                <!---------------------------------------------------------//------------------------------------------------------------
                        debut du container pour afficher les informations du dernier messages de la conversations
                ------------------------------------------------------------------------------------------------------------------------->
                <div class="container-fluid card-header mb-5">
                    <div class="row">
                        <!-- bouton pour retourner vers la liste des messageries --> 
                        <div class="col align-self-center text-left">
                            <a class="direction-arrow" href="chat_list.php"><i class="fa fa-chevron-left fa-lg"></i></a>
                        </div>
                        <!-- /bouton pour retourner vers la liste des messageries -->
                        <!-- photo avatar -->
                        <div class="col">
                            <img class="avatar-circle" src="/img/profil_pictures/<?=$lastAvatar ?>" alt="Avatar dernier message">         
                        </div>
                        <!-- /photo avatar -->
                        <!-- pseudo & presentation -->
                        <div class="col-10 align-self-center">
                            <h2 class="card-title"><strong><?=$lastPseudo ?></strong></h2>
                            <h4 class="card-text">Dernier message le <?=$formatDate ?></h4>
                        </div>
                        <!-- /pseudo & presentation -->
                    </div>
                </div>
                <!-----------------------------------------------------------------------------------------------------------------------
                        /debut du container pour afficher les informations du dernier messages de la conversations
                ------------------------------------------------------------//----------------------------------------------------------->
                <div class="container">
                <?php 
                    //  boucle afficher les messages  de la conversation
                    foreach ($conversation as $message => $column) {
                        $dateMessage = date_create($conversation[$message]['create_at']); 
                        if ($conversation[$message]['senderId'] == $current_Id ) {
                        ?> 
                        <!---------------------------------------------------------//------------------------------------------------------------
                                                                debut du container pour afficher la conversations
                        ------------------------------------------------------------------------------------------------------------------------->                        
                            <div class="mb-3 w-75 ml-auto">
                                <div>
                                    <div class="d-flex justify-content-end">                                               
                                        <div class="mr-4 px-3 py-2 text-right">
                                            <p class="card-text"><?=formatedDateTime($dateMessage) ?></p>
                                            <h3 class="card-title p-2 message-sender-bg"><?=$conversation[$message]['messageBody']; ?></h3>
                                        </div>
                                        <img class="avatar-circle" src="/img/profil_pictures/<?=$userAvatar ?>" alt="Avatar du contact">  
                                    </div>
                                </div>
                            </div> 
                            <?php
                            } else {
                            ?>
                            <div class="mb-3 w-75 mr-auto">                            
                                    <div class="d-flex">
                                        <img class="avatar-circle" src="/img/profil_pictures/<?=$_SESSION['contact_Avatar'] ?>" alt="Avatar utilisateur en cours">             
                                        <div class="ml-4">
                                            <p class="card-text"><?=formatedDateTime($dateMessage) ?></p>
                                            <h3 class="card-title p-2 message-receiver-bg"><?=$conversation[$message]['messageBody']; ?></h3>                                        
                                        </div>
                                    </div>                            
                            </div>                                               
                        <?php
                            }
                        }
                    } else {
                    ?>
                    <!---------------------------------------------------------//------------------------------------------------------------
                                            debut du container pour un message si premiere conversation avec ce contact         -->
                    <div class="container-fluid card-header mb-3"> 
                        <div class="row info-message-bg">
                            <!-- bouton pour retourner vers la liste des contacts --> 
                            <div class="col align-self-center text-left">
                                <a class="direction-arrow" href="contacts_list.php"><i class="fa fa-chevron-left fa-lg"></i></a>
                            </div>
                            <!-- /bouton pour retourner vers la liste des contacts -->                                                                      
                            <div class="px-3 py-4 col-10">
                                <h2 class="card-title">C'est votre première conversation avec <strong><?=$_SESSION['contact_Pseudo'] ?> !</h2>
                            </div>
                        </div>
                    </div>
                     <!--                   /debut du container pour un message si premiere conversation avec ce contact
                    ------------------------------------------------------------//------------------------------------------------------------->
                    <?php
                    }
                    ?>
                    <!-----------------------------------------------------------------------------------------------------------------------
                                                                /debut du container pour afficher la conversations
                    -----------------------------------------------------------//-------------------------------------------------------------->

                    <!-----------------------------------------------------------------------------------------------------------------------
                                                                                formulaire pour saisir du texte                                                 -->          
                    <div class="card text-white bg-success px-3 py-2 mb-3 w-100">                    
                        <form class="form-inscription" action="/forms_processing/message_sending_process.php" method="POST">    
                            <div class="d-flex ">                                
                                <div class="w-100 align-self-center">
                                    <textarea class="form-control" name="messageSend"   id="messageSend" placeholder="Votre message message.." required></textarea>
                                    <!-- passage des indentifiants utilisateurs en parametres caches pour le traitement du formulaire -->
                                    <input type="hidden" id="currentId" name="currentId" value="<?=$_SESSION['current_Id'] ?>">
                                    <input type="hidden" id="contactId" name="contactId" value="<?=$_SESSION['contact_Id'] ?>">
                                    <input type="hidden" id="contactAvatar" name="contactAvatar" value="<?=$_SESSION['contact_Avatar'] ?>">
                                    <input type="hidden" id="contactPseudo" name="contactPseudo" value="<?=$_SESSION['contact_Pseudo'] ?>">
                                </div>
                                <div class="ml-auto">
                                    <button class="btn btn-primary btn-lg btn-block  h-100 align-items-stretch" type="submit" name="sendMessage">Submit</button>
                                </div>
                            </div>
                        </form>                     
                    </div>
                    <!--                                                        /formulaire pour saisir du texte
                    -----------------------------------------------------------//-------------------------------------------------------------->
            </div>
        </div>
        <!----------------------------------------------------------------------------------------
                    /debut du container global pour afficher la conversation en cours
        ----------------------------------------//------------------------------------------------>
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
