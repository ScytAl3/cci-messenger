<!-- php treatment -->
<?php
    // import pdo fonction sur la database
    require '../pdo/pdo_db_functions.php';
    
    // si les variables existes
    if (isset($_POST['pseudo']) && isset($_POST['password']))  {
        // on appelle la fonction qui verifie si un utilisateur avec ce pseudo existe
        $testUser = pseudoExiste($_POST['pseudo']);
        // -------------------------------------
        //var_dump($testUser); die;
        // -------------------------------------        
        // si la fonction a retourner un utilisateur
        if ($testUser) { 
            // on appelle la fonction qui verifie le mot de passe saisi avec celui chiffre dans la base de donnees 
            $testPwd = validPassword($_POST['password'], $testUser);
            // --------------------------------------
            //var_dump($testPwd); die;
            // --------------------------------------
            // si le mot de passe utilise est correct
            if ($testPwd) {
                // on peut demarre notre session avec les identifiants de l'utilisateur
                session_start ();
                // on enregistre les paramètres de l utilisateur comme variables de session ($email et $password) et role
                $_SESSION['current_Id'] = $testUser['userId'];
                $_SESSION['pseudo'] = $testUser['userPseudo'];
                $_SESSION['profilePicture'] = $testUser['userPicture']; 
                // on creer une variable de session login
                $_SESSION['session'] = true;
                // on le dirige vers la page d accueil
                // on détruit les variables d erreur de login de notre session
                unset ($_SESSION['showErrorLogin'], $_SESSION['errorMsgLog']);
                header('location: /../chat_list.php');   
            } else {
                // on peut demarre notre session avec les message d erreur (mot de passe non valide)
                session_start ();
                $_SESSION['showErrorLogin'] = true;
                $_SESSION['errorMsgLog'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
                // on redirige vers la page index.php
                header('location:/../index.php');
            }        
        // sinon pas trouve de correspondance email dans la base        
        } else {
            // on demarre notre session avec les messages d erreur (pseudo n existe pas dans la table)
            session_start ();
            $_SESSION['showErrorLogin'] = true;
            $_SESSION['errorMsgLog'] = "Erreur de connexion, veuillez vérifier vos identifiants de connexion";
            // on redirige vers la page index.php avec les parametres pour afficher le message d erreur
            header('location:/../index.php');
        }
    }
?>