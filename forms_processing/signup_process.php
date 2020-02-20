<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_function.php';

    // si le formulaire a ete envoyer les variables existes
    if (isset($_FILES['fileToUpload'], $_POST['lastName'], $_POST['firstName'],$_POST['pseudo'], $_POST['email'], $_POST['password']))  {
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui verifie que le pseudo n est pas deja utilise
        // ------------------------------------------------------------------------------------
        $userPseudo = pseudoExiste($_POST['pseudo']);    
        // -----------------------------------------------------
        // var_dump($userCheck); die;
        // -----------------------------------------------------  
        // si pas de correspondance
        if ($userPseudo) { 
             // on demarre une session avec les parametres de gestion d erreur pseudo
            session_start();
            $_SESSION['showCeateError'] = true;
            $_SESSION['errorCreateMsg'] = "Ce pseudo est déjà utilisé !";
            // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../sign_up.php');
        }
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui verifie que le pseudo n est pas deja utilise
        // ------------------------------------------------------------------------------------
        $userEmail = emailExiste($_POST['email']);    
        // -----------------------------------------------------
        // var_dump($userEmail); die;
        // -----------------------------------------------------  
        // si pas de correspondance
        if ($userEmail) { 
             // on demarre une session avec les parametres de gestion d erreur email
            session_start();
            $_SESSION['showCeateError'] = true;
            $_SESSION['errorCreateMsg'] = "Cette email est déjà utilisée !";
            // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../sign_up.php');
        }
        // ------------------------------------------------------------------------------------
        // on appelle la fonction qui creer le Salt et chiffre le mot de passe
        // ------------------------------------------------------------------------------------  
            $hashPwd = CreateHashPassword($_POST['password']);
            // on recupere les informations saisies et le mot de passe chiffre dans un tableau       
            $userData = [
                $_POST['firstName'], 
                $_POST['lastName'], 
                $_POST['pseudo'],
                $_POST['email'], 
                $hashPwd,
                $_FILES['fileToUpload']
            ];                 
            // -----------------------------------------------------
            // var_dump($userData); die;
            // -----------------------------------------------------    
            // ------------------------------------------------------------------------------------
            // on appelle la fonction qui creer le Salt et chiffre le mot de passe
            // ------------------------------------------------------------------------------------ 




            // ------------------------------------------------------------------------------------
            // on appelle la fonction qui gere l upload de fichier
            // ------------------------------------------------------------------------------------



            // ------------------------------------------------------------------------------------
            // on appelle la fonction qui creer le nouvelle utilisateur
            // ------------------------------------------------------------------------------------
            // on appelle la fonction pour le creer
            $newUser = createUser($userData);
            // on peut démarrer notre session
            session_start ();
            // on enregistre les paramètres de l utilisateur comme variables de session ($email et $password)
            $_SESSION['firstName'] = $_POST['firstName'];
            $_SESSION['lastName'] = $_POST['lastName'];
            $_SESSION['role'] = 'Default';
            $_SESSION['idCreate'] = $newUser;
            // on creer une variable de session login
            $_SESSION['session'] = true;
            // on détruit les variables d erreur de creation de notre session
            unset ($_SESSION['showCeateError'], $_SESSION['errorCreateMsg']);       
            // on redirige vers la page d accueil
            header('location:/../accueil.php');   
        } else {
           
        }
    }
?>