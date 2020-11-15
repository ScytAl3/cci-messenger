<!-- php treatment -->
<?php
// import pdo fonction sur la database
require '../pdo/pdo_db_functions.php';
// si le formulaire du message a ete envoye
if (isset($_POST['sendMessage'])) {
    //
    // var_dump($_POST); die;
    //
    // on recupere les identifiants des participants qui ont ete envoye cache avec le message
    $theReceiver = $_POST['contactId'];
    $theSender = $_POST['currentId'];
    // on les stock dans un tableau pour le passage de parametre dans la fonction qui recupere les messages de la conversation
    $senderAndReceiverId = [
        $theReceiver,
        $theSender
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
        // on demarre la session
        session_start();
        header('location:/../chat_current.php');
    } else {
        // on demarre la session
        session_start();
        $_SESSION['showErrorSend'] = true;
        $_SESSION['errorMsgSend'] = "Problème lors de l'envoi du message' !";
        // on redirige vers la page de la conversation
        header('location:/../chat_current.php');
    }
}
?>