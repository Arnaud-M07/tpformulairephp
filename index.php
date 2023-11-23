<?php
// REGEX 
define('POSTAL_CODE', '^[0-9]{5}$');
define('LASTNAME', '^[A-Za-zéèëêçà]{2,50}(-| )?([A-Za-zéèçà]{2,50})?$');
define('REGEX_LINKEDIN','^(http(s)?:\/\/)?([\w]+\.)?linkedin\.com\/(pub|in|profile)');
define('ARRAY_COUNTRY', ['France', 'Belgique', 'Suisse', 'Luxembourg', 'Allemagne', 'Italie', 'Espagne', 'Portugal']);
define('ARRAY_LANGAGES', ['HTML/CSS', 'PHP', 'Javascript', 'Python', 'Autres']);

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
    $langage = filter_input(INPUT_POST, "langage", FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_REQUIRE_ARRAY);
    var_dump($langage);
    if(!empty($langage) && !in_array($langage, ARRAY_LANGAGES)){
        $error['langage'] = 'Le pays n\'est pas valide';
    }



    // Date 
    // Civilité
    // Mdp 
    // Photo
    // Experience

    // GENRE
    $gender = filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(empty($gender)){
        $error['gender'] = 'Veuillez renseigner un genre valide.';
    } elseif (!in_array($gender,['Mr', 'Mme'])) {
        $error['gender'] = 'Le genre n\'est pas valide';
    }
} 
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="./public/assets/css/style.css">
    <title>Formulaire PHP - Projet TP</title>
</head>
<body>
    <header></header>

    <main>
        <div class="container">
            <form action="" method="POST" class="form" novalidate>
            
                <div class="row form-card p-5">
                <div class="row"><?= $lastname??''?></div>
                    <!-- 1st Col -->
                    <div class="col-12 col-md-6 ">
                        <!-- email OK-->
                        <div class="mb-3">
                            <label for="email">Votre Email *</label>
                            <input name="email" type="email" class="form-control form-control-lg" id="email" placeholder="nom@exemple.com" value="<?=$email??''?>" required>
                            <div class="alert-message"><?= $error['email']??'' ?></div>
                        </div>
                        <!-- password OK-->
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="password">Votre mot de passe *</label>
                                <input pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" name="password" type="password" class="form-control form-control-lg" id="password" placeholder="Mot de passe" >
                            </div>
                            <div class="col-6">
                                <label for="confirmPassword">Confirmez le mot de passe *</label>
                                <input pattern="^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$" name="confirmPassword" type="password" class="form-control form-control-lg" id="confirmPassword" placeholder="Mot de passe" >
                            </div>
                        </div>
                        <!-- Civility NO-->
                        <div class="mb-3">
                            <div>
                                <label for="gender">Votre civilité *</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="gender" value="Mr">
                                <label class="form-check-label" for="inlineRadio1">Mr</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="inlineRadioOptions" id="gender" value="Mme">
                                <label class="form-check-label" for="inlineRadio2">Mme</label>
                            </div>
                            <div class="alert-message"><?=$error['gender']??''?></div>
                        </div>
                        <!-- Name OK-->
                        <div class="mb-3">
                            <label for="lastname">Votre Nom *</label>
                            <input pattern="<?=LASTNAME?>" 
                            value="<?=$lastname??''?>" 
                            name="lastname" 
                            type="text" 
                            class="form-control form-control-lg" 
                            id="lastname" 
                            placeholder="Dupont">
                            <div class="alert-message"><?= $error['lastname']??''?></div>
                        </div>
                        <!-- Birth date NO-->
                        <div class="mb-3">
                            <label for="dateBirth" class="form-label">Votre année de naissance *</label>
                            <input type="date" name="dateBirth" class="form-control form-control-lg" id="dateBirth" min="1950-01-01" max="2030-31-12" >
                        </div>
                        <!-- Birth Country NO-->
                        <div class="mb-3">
                            <label for="country">Votre pays de naissance</label>
                            <select class="form-select" name="country" id="country" aria-label="Floating label select example">
                                <option value="" disabled selected hidden><?='Séléctionnez un pays'?></option>
                                <?php foreach (ARRAY_COUNTRY as $countries) {
                                    $isSelected = ($country && $country == $countries) ? 'selected' : '';
                                    echo "<option value=\"$countries\" $isSelected>$countries</option>";
                                } 
                                ?>
                            </select>
                            <div class="alert-message"><?=$error['country']??''?></div>
                        </div>
                    </div>
                    <!-- 2nd Col -->
                    <div class="col-12 col-md-6 ">
                        <!-- Postal ZIP OK-->
                        <div class="mb-3">
                            <label for="inputZip">Votre code postal *</label>
                            <input 
                                pattern="<?=POSTAL_CODE?>" 
                                value="<?=$zip??''?>" 
                                name="zip" 
                                type="text" 
                                class="form-control form-control-lg" 
                                id="inputZip" 
                                placeholder="80000"
                                autocomplete="postal-code"
                                inputmode="numeric"
                                required
                                >
                            <div class="alert-message"><?= $error['zip']??'' ?></div>
                        </div>
                        
                        <!-- Profil picture NO-->
                        <div class="mb-3">
                            <label for="formFileLg" class="form-label mb-0">Votre photo de profil</label>
                            <input class="form-control form-control-lg" id="formFileLg" type="file">
                        </div>
                        <!-- URL Linkedin OK-->
                        <div class="mb-3">
                            <label for="url">URL de votre compte LinkedIn</label>
                            <input value="<?=$urlLinkedin??''?>" 
                            name="urlLinkedin" 
                            type="url" 
                            class="form-control form-control-lg" 
                            name="url" 
                            id="url" 
                            pattern="https://www.linkedin.com/in/" 
                            placeholder="https://www.linkedin.com/in/profil">
                            <div class="alert-message"><?= $error['urlLinkedin']??'' ?></div>
                        </div>
                        <!-- Web langages NO-->
                        <div class="mb-3">
                            <label for="langage">Quels langages web connaissez-vous ?</label>
                            <div>
                                <?php foreach (ARRAY_LANGAGES as $langages) { 
                                    // $isSelected = ($langage && $langage == $langages) ? 'checked' : '';?>
                                    <div class='form-check-inline'>
                                            <input class='form-check-input' name='langage[]' type='checkbox' value="<?=$langages?>" id='<?=$langages?>"' <?=$isSelected?>>
                                            <label class='form-check-label fw-normal' for='<?=$langages?>'><?=$langages?></label>
                                        </div>
                                    <?php
                                    } 
                                ?>
                                <!--  -->
                                
                                <!--  -->
                                
                                <!-- <div class="form-check-inline">
                                    <input class="form-check-input" name="langage" type="checkbox" value="HTML/CSS" id="langagesInputHTML" selected>
                                    <label class="form-check-label fw-normal" for="langagesInputHTML">HTML/CSS</label>
                                </div> -->
                                
                            </div>
                            <div class="alert-message"><?= $error['langage']??'' ?></div>
                        </div>
                        <!-- Text Area NO-->
                        <div class="">
                            <textarea pattern="^[A-Za-z0-9.]{5,1000}$" name="textArea" class="form-control" placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir." id="textArea" style="height: 160px" minlength="20" maxlength="500"></textarea>
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn btn-submit">Envoyer</button>
                    </div>

                    
                    
                </div>
            </form>
        </div>
    </main>


    <footer></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>
</html>