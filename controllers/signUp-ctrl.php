<?php
// Appel des constantes
require_once __DIR__ . '/../config/const.php';

$startDate = (date('Y') - 100).'-01-01';
$currentDate = Date('Y-m-d');

if($_SERVER['REQUEST_METHOD'] =='POST'){
    // Tableau d'erreurs
    $error = [];

    // EMAIL INPUT
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    if(empty($email)){
        $error['email'] = 'Veuillez renseigner votre email.';
    } else {
        $isOk = filter_var($email, FILTER_VALIDATE_EMAIL);
        if(!$isOk){
            $error['email'] = 'L\'email n\'est pas valide.';
        }
    }

    // LASTNAME INPUT
    $lastname = filter_input(INPUT_POST,'lastname', FILTER_SANITIZE_SPECIAL_CHARS);
    if(empty($lastname)){
        $error['lastname'] = 'Veuillez renseigner votre nom.';
    } else {
        $isOk = filter_var($lastname, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.LASTNAME.'/')));
        // $isOK = preg_match('/^[A-Za-zéèëêçà]{2,50}(-| )?([A-Za-zéèçà]{2,50})?$/', $_POST['lastname']);
        if(!$isOk){
            $error['lastname'] = 'Le nom n\'est pas valide.';
        }
    }
    
    // ZIP INPUT
    $zip = filter_input(INPUT_POST, 'zip', FILTER_SANITIZE_NUMBER_INT);
    if(empty($zip)){
        $error['zip'] = 'Veuillez renseigner un code postal valide.';
    } else {
        $isOk = filter_var($zip, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.POSTAL_CODE.'/')));
        if(!$isOk){
            $error['zip'] = 'Le code postal n\'est pas valide.';
        }
    }

    // URL
    $urlLinkedin = filter_input(INPUT_POST, 'urlLinkedin', FILTER_SANITIZE_URL);
    if(!empty($urlLinkedin)){
        $isOk = filter_var($urlLinkedin, FILTER_VALIDATE_URL);
        if(!$isOk || str_contains($urlLinkedin, "linkedin.com/in/") === false){
            $error['urlLinkedin'] = 'L\'URL n\'est pas valide.';
        }
    }
    
    // PAYS DE NAISSANCE
    $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(!empty($country) && !in_array($country, ARRAY_COUNTRY)){
        $error['country'] = 'Le pays n\'est pas valide';
    }


    // LANGAGE
    // Nettoyage de $langage
    $langage = filter_input(INPUT_POST, "langage", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    
    // Validation de $langage
    if($langage !=null){
        foreach($langage as $value){
        if(!empty($langage) && !in_array($value, ARRAY_LANGAGES)){
                $error['langage'] = 'Le langage n\'est pas valide';
            }
    }
    }
    
    // DATE DE NAISSANCE 
    $dateBirth = filter_input(INPUT_POST, 'dateBirth', FILTER_SANITIZE_NUMBER_INT);
    
    if(!empty($dateBirth)){
        $isOk = filter_var($dateBirth, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEX_DATE.'/')));
        if((!$isOk || $dateBirth >= $currentDate || $dateBirth <= $startDate)){
            $error['dateBirth'] = 'La date de naissance n\'est pas valide.';
        }
    }

    // CIVILITE
    $gender = intval(filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_NUMBER_INT));
    
    if(!empty($gender)){
        $isOk = filter_var($gender, FILTER_VALIDATE_INT, array("options"=>array("min_range"=> 0, "max_range"=> 1)));
        if((!$isOk)){
            $error['gender'] = 'Le genre n\'est pas valide.';
        }
    }


    // MOT DE PASSE 
    // On ne nettoie pas un password
    $password = filter_input(INPUT_POST, 'password');
    $confirmPassword = filter_input(INPUT_POST, 'confirmPassword');

    if(empty($password) || empty($confirmPassword)){
        $error['password'] = 'Veuillez renseigner un mot de passe.';
    } else {
        $isOk = filter_var($password, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEX_PASSWORD.'/')));
        $isOk2 = filter_var($confirmPassword, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEX_PASSWORD.'/')));
        if ($isOk!=$isOk2){
            $error['password'] = 'Les champs ne sont pas identiques';
        } elseif (!$isOk || !$isOk2){
            $error['password'] = 'Le mot de passe n\'est pas valide.';
        } else {
            // Crée une clé de hachage pour le mot de passe
            $pass_hash = password_hash($isOk2, PASSWORD_DEFAULT);
        }
    }

    // EXPERIENCE
    $textArea = filter_input(INPUT_POST, 'textArea', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!empty($textArea)){
        if (strlen($textArea) > 1000){
            $error['textArea'] = 'Le texte renseigné n\'est pas valide.(1000 caractères max)';
        }

        // Methode REGEX
        // $isOk = filter_var($textArea, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>'/'.REGEX_TEXTAREA.'/')));
        // if(!$isOk){
        //     $error['textArea'] = 'Le texte renseigné n\'est pas valide.';
        // }
    }

    // PHOTO
    try {
        if(empty($_FILES['photo']['name'])){
            throw new Exception("Ajoutez une photo.");
        } 
        if($_FILES['photo']['error']!=0){
            throw new Exception("Une erreur s'est produite.");
        }
        if (!in_array($_FILES['photo']['type'], ARRAY_TYPES)){
            throw new Exception("Le format de l'image n'est pas correct.");
        }
        if($_FILES['photo']['size'] > UPLOAD_MAX_SIZE){
            throw new Exception("Le fichier est trop lourd.");
        }
        $filename = uniqid("img_");
        $extension = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        
        $from = $_FILES['photo']['tmp_name'];
        $to = __DIR__ . '/../public/uploads/users/'. $filename.'.'. $extension;
        $toFront = $filename.'.'. $extension;
        
        move_uploaded_file($from, $to);
        
    } catch (\Throwable $th) {
        $error['photo'] = $th->getMessage();
    }

}
include __DIR__ . '/../views/templates/header.php';
include __DIR__ . '/../views/signUp.php';
include __DIR__ . '/../views/templates/footer.php';