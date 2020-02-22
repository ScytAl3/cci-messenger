<!-- php treatment -->
<?php
    // on démarre la session
    session_start ();
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    // si les variables existes
    if (isset($_POST['sendMessage']))  {
        // on recupere les identifiants des participants
        $senderAndReceiverId = [
            $_SESSION['current_Id'],
            $_SESSION['contactId']
        ];
        // ----------------------------------------------------------
        // on appelle la fonction qui creer la messagerie
        // ----------------------------------------------------------
        $newMessaging = createMessaging($senderAndReceiverId);
        // si l enregistrement s est bien deroule
        if ($newMessaging > 0) {  
            // on recupere le message et le dernier identifiant de messagerie que l on vient de creer
            $arrayMsg = [
                $newMessaging,
                $_POST['messageSend']
            ];
            // ----------------------------------------------------------------------------------------
            // on appelle la fonction qui insert le message dans la tables des messages
            // ----------------------------------------------------------------------------------------
            $newMessage = createMessage($arrayMsg);
            // on redirige vers la page index.php avec les parametrres de session
            $_SESSION['contactId'] = $_SESSION['contactId'];
            $_SESSION['contactAvatar'] = $_SESSION['contactAvatar'];
            $_SESSION['contactPseudo'] = $_SESSION['contactPseudo'];
            // on passe egalement en parametres les informations envoyees pour ne pas devoir tout resaisir
            header('location:/../chat_current.php');
        } else {
            $_SESSION['showErrorSend'] = true;
            $_SESSION['errorMsgSend'] = "Problème lors de l'envoi du message' !";
            // on redirige vers la page de la conversation
            header('location:/../chat_current.php');
        }
    }
?>