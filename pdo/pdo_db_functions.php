<?php
// -- import du script de connexion a la db
require 'pdo_db_connect.php'; 
// -- import du script des fonctions speciales
require 'special_functions.php';

// -----------------------------//-------------------------------
//      fonction pour verifier l existence du pseudo
// -----------------------------//-------------------------------
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
    $sqlInsert = "INSERT INTO users (userFirstName, userLastName, userEmail, userPassword, userRole) VALUES (?, ?, ?, ?, ?)";
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

// ------------------------------------------------------------
//     fonction pour renvoyer les lignes d une table
// -----------------------------------------------------------
function dataReader($query) {
    // on instancie une connexion
    $pdo = my_pdo_connexxion();   
    // preparation de la requete pour execution
    try {
        $statement = $pdo -> prepare($query, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
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