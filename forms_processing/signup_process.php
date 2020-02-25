<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';

    // si le formulaire a ete envoyer les variables existes
    if (isset($_FILES['fileToUpload'], $_POST['lastName'], $_POST['firstName'],$_POST['pseudo'], $_POST['email'], $_POST['password']))  {      
        // on demarre une session la session
        session_start();  
        // avec en parametres les informations envoyees pour ne pas devoir tout ressaisir
        $_SESSION['inputLastName'] = $_POST['lastName'];
        $_SESSION['inputFirstName'] = $_POST['firstName'];
        $_SESSION['inputPseudo'] = $_POST['pseudo'];
        $_SESSION['inputMail'] = $_POST['email']; 
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui verifie que le pseudo n est pas deja utilise
        // ------------------------------------------------------------------------------------
        $userPseudo = pseudoExiste($_POST['pseudo']); 
        //------------------------------------------------------------
        // si on a trouver une correspondance dans la base
        //------------------------------------------------------------
        if ($userPseudo) { 
            // on passe en variables de session les parametres de gestion d erreur psudo
            $_SESSION['showErrorSignup'] = true;
            $_SESSION['errorMsgSignUp'] = "Ce pseudo est déjà utilisé !";                                  
            // on redirige vers la page du formulaire d inscription
            header('location:/../sign_up.php');
            exit;
        }
        // ------------------------------------------------------------------------------------------
        // on appelle la fonction qui verifie que l adresse mail n est pas deja utilisee
        // ------------------------------------------------------------------------------------------
        $userEmail = emailExiste($_POST['email']);  
        //------------------------------------------------------------
        // si on a trouver une correspondance dans la base
        //------------------------------------------------------------
        if ($userEmail) { 
             // on passe en variables de session les parametres de gestion d erreur email
            $_SESSION['showErrorSignup'] = true;
            $_SESSION['errorMsgSignUp'] = "Cette email est déjà utilisée !";
            // on redirige vers la page du formulaire d inscription
            header('location:/../sign_up.php');
            exit;
        }
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui creer le Salt et chiffre le mot de passe
        // ------------------------------------------------------------------------------------  
        // creation du Salt associe a l utilisateur
        $userSalt = generateSalt(10);
        // creation du mot de passe associe a l utilisateur avec son Salt
        $userEncryptPwd = CreateEncryptedPassword($userSalt, $_POST['password']);
        // on recupere les informations saisies et le mot de passe chiffre dans un tableau       
        $userData = [
            $_POST['firstName'], 
            $_POST['lastName'], 
            $_POST['pseudo'],
            $_POST['email'], 
            $userEncryptPwd,
            $userSalt,
            $_FILES['fileToUpload']['name']
        ];
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui gere l upload de fichier
        // ------------------------------------------------------------------------------------
        $userUpload = UploadImage($_FILES['fileToUpload']);
        // si la fonction ne revoie aucune erreur = photo deplacee dans le dossier img/        
        if (empty($userUpload) == true) {
            // --------------------------------------------------------
            // on appelle la fonction qui creer l utilisateur
            // --------------------------------------------------------
            $newUser = createUser($userData);
            // si l enregistrement s est bien deroule
            if ($newUser > 0) {
                // on passe en parametre le nouvel identifiant cree
                $_SESSION['current_Id'] = $newUser;
                $_SESSION['current_Pseudo'] = $_POST['pseudo'];
                $_SESSION['current_Avatar'] = $_FILES['fileToUpload']['name'];
                // on creer une variable de session login
                $_SESSION['session'] = true;
                // on détruit les variables d erreurs liees au formulaire et celles des champs de saisie
                unset ($_SESSION['showErrorSignup'], $_SESSION['errorMsgSignUp'], $_SESSION['inputLastName'], $_SESSION['inputFirstName'], $_SESSION['inputMail']);       
                // on redirige vers la page de la liste des messagerie
                header('location:/../chat_list.php');       
                exit;        
            } else {
                // on demarre une session avec les parametres de gestion d erreur email
                $_SESSION['showErrorSignup'] = true;
                $_SESSION['errorMsgSignUp'] = "Problème lors de la création de votre compte !";
                // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
                header('location:/../sign_up.php');
                exit;
            }               
        } else {
            // on demarre une session avec les parametres de gestion d erreur de  l upload de l image
            $_SESSION['showErrorSignup'] = true;
            $_SESSION['errorMsgSignUp'] = $userUpload[0];
            // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../sign_up.php');
            exit;
        }                
    } else {
            // on demarre une session avec les parametres de gestion d erreur de  l upload de l image
            $_SESSION['showErrorSignup'] = true;
            $_SESSION['errorMsgSignUp'] = "Il y a eu un problème lors de l'envoi de votre formulaire !";
            // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../sign_up.php');
            exit;
    }
?>