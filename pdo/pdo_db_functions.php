<?php
// -- import du script de connexion a la db
require 'pdo_db_connect.php'; 
// -- import du script des fonctions speciales
require 'special_functions.php';

// ---------------------------------------------//-----------------------------------------
//      fonction pour verifier l existence du pseudo qui doit être unique
// ---------------------------------------------//-----------------------------------------
function pseudoExiste($pseudoToTest) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour verifier si l adresse email (email unique) est deja utilisee
    $query = "SELECT * FROM users WHERE userPseudo = :bp_pseudo";
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l email saisi en  parametre
        $statement->bindParam(':bp_pseudo', $pseudoToTest, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute(); 
        $user_count = $statement->rowCount();       
        // --------------------------------------------------------------
        //var_dump($user_row = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($user_count == 1) {
            // on recupere les donnees trouvees dans 
            $user_row = $statement->fetch();
        } else {
            $user_row = false;
        }         
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $user_row; 
}

// ---------------------------------------------//-----------------------------------------
//      fonction pour verifier l existence du email qui doit être unique !! TO-DO une fonction qui prend en parametre le where pour ne pas faire doublon !!
// ---------------------------------------------//-----------------------------------------
function emailExiste($emailToTest) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour verifier si l adresse email (email unique) est deja utilisee
    $query = "SELECT * FROM users WHERE userEmail = :bp_email";
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l email saisi en  parametre
        $statement->bindParam(':bp_email', $emailToTest, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute(); 
        $user_count = $statement->rowCount();       
        // --------------------------------------------------------------
        //var_dump($user_row = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($user_count == 1) {
            // on recupere les donnees trouvees dans 
            $user_row = $statement->fetch();
        } else {
            $user_row = false;
        }         
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $user_row; 
}
// ------------------------------------------------------------
//           fonction pour verifier le mot de passe
// ------------------------------------------------------------
function validPassword($loginPwd, $user) {
    // on on appelle la fonction speciale qui verifie le mot de passe saissi grace au Salt et mot de passe chiffre associes a l utilisateur
    $checkPwd = VerifyEncryptedPassword($user['userSalt'], $user['userPassword'], $loginPwd);
    // ------------------------------------
    //var_dump($checkPwd); die;
    // ------------------------------------
    // si identique
    if ($checkPwd) {        
        $user_valid = true;
    } else {        
        $user_valid = false;
    } 
    // on retourne le resultat
    return $user_valid; 
}

// -------------------------------------------------------------------------
//          fonction pour recuperer les donnees d un utilisateur
// -------------------------------------------------------------------------
function dataUser($userId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la  requete preparee pour mettre
    $sql = "SELECT * FROM users ";
    $where = "WHERE userId = ?";
    // construction de la requete
    $query = $sql.$where;
    // preparation de l execution de la requete
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
       // passage du numero d identification en  parametre
        $statement->bindParam(1, $userId, PDO::PARAM_INT);
        // execution de la requete
        $statement -> execute(); 
        $user_count = $statement->rowCount();       
        // --------------------------------------------------------------
        // var_dump($user_row = $statement->fetch()); die; 
        // --------------------------------------------------------------
        // si on trouve un resultat
        if ($user_count == 1) {
            // on recupere les donnees trouvees dans 
            $user_row = $statement->fetch();
        } else {
            $user_row = false;
        }         
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    $statement = null;
    $pdo = null;
    // on retourne le resultat
    return $user_row; 
}

// -----------------------------------------------------------
//              fonction pour creer un utilisateur
// -----------------------------------------------------------
function createUser($userData) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                users (`userLastName`, `userFirstName`, `userPseudo`, `userEmail`, `userPassword`, `userSalt`, `userPicture`) 
                            VALUES 
                                (?, ?, ?, ?, ?, ?, ?)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($userData);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}

// ------------------------------------------------------------------------
//     fonction pour renvoyer les messageries de l utilisateur
// ------------------------------------------------------------------------
function allMessaging($userId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee pour execution
    $queryList = "SELECT `userId`, `userPseudo`, `userPicture` FROM `users` 
                            WHERE userId IN (
                                            SELECT distinct receiverId FROM messaging
                                            WHERE senderId = :bp_userId
                                            UNION
                                            SELECT distinct senderId FROM messaging
                                            WHERE receiverId = :bp_userId)";
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l identifiant utilisateur
        $statement->bindParam(':bp_userId', $userId, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myMessagerie = $statement->fetchAll();            
        } else {
            $myMessagerie = false;
        }   
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le resultat
    return $myMessagerie; 
}

// ----------------------------------------------------------------------
//     fonction pour renvoyer les lignes d une conversation
// ----------------------------------------------------------------------
function messageList($idOne, $idTwo) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee pour execution
    $queryList = "SELECT `receiverId`,
                                            `senderId`,
                                            `create_at`,
                                            `messageBody`
                            FROM `messages` l
                            INNER JOIN `messaging` m ON l.messagingId = m.messagingId
                            WHERE (receiverId = :bp_idOne OR senderId = :bp_idOne)
                            AND (receiverId = :bp_idTwo OR senderId =:bp_idTwo)"; 
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage des identifiants des users en parametres
        $statement->bindParam(':bp_idOne', $idOne, PDO::PARAM_STR);
        $statement->bindParam(':bp_idTwo', $idTwo, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetchAll();            
        } else {
            $myReader = false;
        }   
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le resultat
    return $myReader; 
}

// ----------------------------------------------------------------------
//     fonction pour renvoyer la liste de contacts/utilisateurs
// ----------------------------------------------------------------------
function dataReader($currentId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete preparee 
    $queryList = "SELECT `userId`,
                                            `userLastName`,
                                            `userFirstName`,
                                            `userPseudo`,
                                            `userPicture`
                            FROM users
                            WHERE userId !=  :bp_userId";   
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($queryList, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // passage de l identifiant utilisateur
        $statement->bindParam(':bp_userId', $currentId, PDO::PARAM_STR);
        // execution de la requete
        $statement -> execute();
        // on verifie s il y a des resultats
        // --------------------------------------------------------
        //var_dump($statement->fetchColumn()); die; 
        // --------------------------------------------------------
        if ($statement->rowCount() > 0) {
            $myReader = $statement->fetchAll();            
        } else {
            $myReader = false;
        }   
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le resultat
    return $myReader; 
}

// ------------------------------------------------------------------------------------------
//    fonction pour creer une entree receiver-sender dans la table messaging
// ------------------------------------------------------------------------------------------
function createMessaging($arrayId) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                `messaging`(`receiverId`, `senderId`) 
                            VALUES 
                                (?, ?)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($arrayId);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}

// ------------------------------------------------------------------------------------------
//    fonction pour creer une entree receiver-sender dans la table messages
// ------------------------------------------------------------------------------------------
function createMessage($arrayMsg) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();
    // preparation de la requete pour creer un utilisateur
    $sqlInsert = "INSERT INTO 
                                `messages`(`messagingId`, `create_at`, `messageBody`)
                            VALUES 
                                (?, now(), ?)";
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($sqlInsert, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        // execution de la requete
        $statement -> execute($arrayMsg);
        $statement -> closeCursor();
    } catch(PDOException $ex) {         
        $statement = null;
        $pdo = null;
        die("Secured"); 
    }
    // on retourne le dernier Id cree
    return $pdo -> lastInsertId(); 
}