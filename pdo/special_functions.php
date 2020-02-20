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
    $errors= array();
    // initialisation des variables avec les informations du fichier uploade
    $file_tmp =$image['tmp_name'];
    $file_name = $image['name'];
    $file_size =$image['size'];
    $file_type=$image['type'];
    $fileNameCmps = explode(".", $file_name);
    $file_ext = strtolower(end($fileNameCmps));
    // on supprime les espaces et caracteres speciaux
    $newFileName = md5(time() . $file_name) . '.' . $file_ext;       
    // dossier dans lequel l image sera deplacee
    $target_dir = "img/";
    //$target_file = $target_dir . basename($file_name);    
    /*$uploadFileDir = "img/";
    $dest_path = $uploadFileDir . $newFileName;*/
    $dest_path = $target_dir . $newFileName;
    // extensions autorisees pour l upload des images
    $allowedImageExtensions= array("jpeg","jpg","png");
    // on verifie si l extension est valide
    if (in_array($file_ext, $allowedImageExtensions) === false){
        $errors[] = "Extension non autorisée, choisissez un fichier JPEG ou PNG !";
    }
    // on verifie la taille de l image
    if ($file_size > 2097152){
        $errors[] = 'Le fichier ne doit pas dépasser 2 MB !';
    }
    // on verifie que le fichier n existe pas deja
    if (file_exists($target_dir)) {
        $errors[] = "Le target_dir existe déjà dans le dossier $target_dir !";
    } 

    // si aucune erreur
     if(empty($errors) == true){
        move_uploaded_file($file_tmp, $dest_path);
        var_dump($file_tmp)."\n";
        var_dump($dest_path); die;
        $errors[] =  "Success";
      }else{
        $errors[] = "Erreur lors du déplacement du fichier vers le répertoire de téléchargement !";
      }      
    return($errors);
};
?>