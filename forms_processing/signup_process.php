<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_function.php';

    // si le formulaire a ete envoyer les variables existes
    if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password']))  {
        // on appelle la fonction qui verifie le mail utilise pour verifie qu il nest pas deja utilise
        $userCheck = emailExiste($_POST['email']);    
        // -----------------------------------------------------
        // var_dump($userCheck); die;
        // -----------------------------------------------------  
        // si pas de correspondance
        if (!$userCheck) {       
            // on appelle la fonction pour chiffrer le mot de passe saisi
            $hashPwd = CreateHashPassword($_POST['password']);
            // on recupere les informations saisies et le mot de passe chiffre dans un tableau       
            $userData = [
                $_POST['firstName'], 
                $_POST['lastName'], 
                $_POST['email'], 
                $hashPwd,
                'Default'
            ];                 
            // -----------------------------------------------------
            // var_dump($userData); die;
            // -----------------------------------------------------     
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
            // on demarre une session avec les parametres de gestion d erreur
            session_start();
            $_SESSION['showCeateError'] = true;
            $_SESSION['errorCreateMsg'] = "Cet utilisateur existe déjà !";
            // sinon on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../sign_up.php');
        }
    }
?>