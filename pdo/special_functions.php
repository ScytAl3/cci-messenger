<?php
// --------------------------------------------------------------
// FONCTION : Generer Salt
// --------------------------------------------------------------
function generateSalt( $lenght = 10 ) {
    $allowedChar = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $maxLenght = strlen($allowedChar);
    $randomString = '';
    for ($i=0; $i < $lenght; $i++) { 
        $randomString .= $allowedChar[rand(0, $maxLenght-1)];
    }
    $encryptedSalt = md5($randomString);
    return $encryptedSalt;
}

// --------------------------------------------------------------
// FONCTION : Hashage du mot de passe
// --------------------------------------------------------------
function CreateEncryptedPassword( $salt, $password )
{
    $md5Pwd = md5($password);
    $encryptedPwd = md5($salt . $md5Pwd);
    return $encryptedPwd;                   // génère 60 caractères
};

// --------------------------------------------------------------
// FONCTION : Verification du mot de passe
// --------------------------------------------------------------
function VerifyEncryptedPassword( $userSalt, $userPwd, $loginPwd )
{
    $encryptLoginPwd = CreateEncryptedPassword($userSalt, $loginPwd);
    return ($userPwd == $encryptLoginPwd) ? true : false;
};

/* 
// pour construire le jeu de donnees users
$pwdIn = "c4tchM3";
// genere le salt
$mySalt = generateSalt(10);
echo 'le salt = '.$mySalt."\n";
// genere le mdp
$myPwd = CreateEncryptedPassword($mySalt, $pwdIn);
echo 'le pwd chiffré : '.$myPwd."\n";
// verifie le mdp et le 
$check = VerifyEncryptedPassword($mySalt, $myPwd, $pwdIn);
var_dump($check);
*/

// --------------------------------------------------------------
// FONCTION : Telechargement  des images
// --------------------------------------------------------------
function UploadImage($image) {
    // on initialise le tableau des erreurs
    $errors= array();
    // initialisation des variables avec les informations du fichier uploade
    $target_dir = "../img/profil_pictures/";
    $target_file = $target_dir . basename($image["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // on verifie si le fichier image est une vrai image ou une fausse image
    $check = getimagesize($image["tmp_name"]);
    if($check == false) {
        $errors[]= "Le fichier n'est pas une image !";
        return($errors);
    }
    // on verifie que le fichier image n existe pas deja
    if (file_exists($target_file)) {
        $errors[]=  "Le fichier existe déjà dans le dossier $target_file !";
        return($errors);
    }
    // on verifie la taille du fichier
    if ($image["size"] > 2097152) {
        $errors[]= "Le fichier ne doit pas dépasser 2 MB !";
        return($errors);
    }    
    // extensions autorisees pour l upload des images
    $allowedImageExtensions= array("jpeg","jpg","png");
    // on verifie si l extension est valide
    if (in_array($imageFileType, $allowedImageExtensions) === false){
        $errors[]= "Extension non autorisée, choisissez un fichier JPEG ou PNG !";
        return($errors);
    }
    // si aucune erreur : array vide
    if(empty($errors) == true) {
        move_uploaded_file($image["tmp_name"], $target_file);
    } else {
        $errors[] = "Erreur lors du déplacement du fichier vers le répertoire de téléchargement !";
    }  
};

// --------------------------------------------------------------
// FONCTION : Formatage de la date a afficher
// --------------------------------------------------------------
function formatedDateTime($mysqlDate){
    $date = date_format($mysqlDate,"d/m/Y");
    $hour = date_format($mysqlDate, "H");
    $minute = date_format($mysqlDate, "i");
    // on retourne la au format desire
    return  $date.' à '.$hour.'h'.$minute.'.';
};
