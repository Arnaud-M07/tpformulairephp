<!-- SIGN UP FORM -->
<div class="container container-form">
        <?php if ($_SERVER['REQUEST_METHOD'] !='POST' || !empty($error)){ ?>
            <form action="" method="POST" class="form" novalidate enctype="multipart/form-data">
        
            <div class="row form-card p-5">
            
                <!-- 1st Col -->
                <div class="col-12 col-md-6">
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
                            <input pattern= "<?=REGEX_PASSWORD?>"
                            name="password" 
                            type="password" 
                            class="form-control form-control-lg" 
                            id="password" 
                            placeholder="Mot de passe" 
                            required>
                        </div>
                        <div class="col-6">
                            <label for="confirmPassword">Confirmez le mot de passe *</label>
                            <input pattern= "<?=REGEX_PASSWORD?>"
                            name="confirmPassword" 
                            type="password" 
                            class="form-control form-control-lg" 
                            id="confirmPassword" 
                            placeholder="Mot de passe" 
                            required>
                        </div>
                        <div class="alert-message"><?= $error['password']?? ''?></div>
                    </div>
                    <!-- Civility NO-->
                    <div class="mb-3">
                        <div>
                            <label for="gender">Votre civilité *</label>
                        </div>
                        
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="0" value="0">
                            <label class="form-check-label" for="0">Mr</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="gender" id="1" value="1">
                            <label class="form-check-label" for="1">Mme</label>
                        </div>
                        <div class="alert-message"><?= $error['gender']??''?></div>
                        
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
                        <label for="dateBirth" class="form-label">Votre date de naissance *</label>
                        <input value="<?=$dateBirth??''?>" 
                        pattern= "<?=REGEX_DATE?>"
                        type="date" 
                        name="dateBirth" 
                        class="form-control form-control-lg" 
                        id="dateBirth" 
                        min="<?=$startDate?>" 
                        max="<?=$currentDate?>" >
                        <div class="alert-message"><?= $error['dateBirth']??''?></div>
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
                        <input class="form-control form-control-lg" name="photo" id="formFileLg" type="file" accept=".png, image/jpeg">
                    </div>
                    <div class="alert-message"><?= $error['photo']??''?></div>

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
                                ?>
                                <div class='form-check-inline'>
                                        <input class='form-check-input' name='langage[]' type='checkbox' value='<?=$langages?>' id='<?=$langages?>' <?= (isset($langage) && in_array($langages, $langage)) ? 'checked' : ""?> >
                                        <label class='form-check-label fw-normal' for='<?=$langages?>'><?=$langages?></label>
                                    </div>
                                <?php
                                } 
                            ?>
                        </div>
                        <div class="alert-message"><?= $error['langage']??'' ?></div>
                    </div>

                    <!-- Text Area NO-->
                    <div class="">
                        <textarea pattern= "<?=REGEX_TEXTAREA?>" 
                        name="textArea" 
                        class="form-control" 
                        placeholder="Racontez une expérience avec la programmation et/ou l'informatique que vous auriez pu avoir." 
                        id="textArea" 
                        style="height: 160px" 
                        minlength="20" 
                        maxlength="500"><?=$textArea?? ''?></textarea>
                    </div>
                    <div class="alert-message"><?= $error['texteArea']??'' ?></div>
                </div>
                <div>
                    <button type="submit" class="btn btn-submit">Envoyer</button>
                </div>
            </div>
        </form>

        <!-- Lorsque le formulaire passe en POST (toutes les données renseignées), afficher les résultats. -->
        <?php
        } else { ?>
        <div class="row form-card p-5">
            <div class="col">
                <!-- Affichage des réponses -->
                <h1>Résultats du formulaire</h1>
                <p><strong>Email :</strong> <?= $email ?></p>
                <p><strong>Nom :</strong> <?= $lastname ?></p>
                <p><strong>Pays de naissance :</strong> <?= $country ?? 'Non renseigné' ?></p>
                <p><strong>Code postal :</strong> <?= $zip ?></p>
                <p><strong>URL LinkedIn :</strong> <?= $urlLinkedin ?? 'Non renseigné' ?></p>
                <p><strong>Langages web :</strong> <?php foreach($langage as $value){echo $value.' ';} ?></p>
                <p><strong>Civilité :</strong> <?php 
                    if($gender==0){
                        echo "Mr";
                    } elseif($gender==1) {
                        echo "Mme";
                    } else {
                        echo 'Non renseigné';
                    }
                ?></p>
                <p><strong>Mot de passe :</strong> <?= $pass_hash ?? 'Non renseigné' ?></p>
                <p><strong>Texte : </strong> <?= $textArea ?? 'Non renseigné' ?></p>
                <p><strong>Photo de profil : </strong> <img src="/public/uploads/users/<?=$toFront?>" alt="Photo de profil"></p>
            </div>
        </div>
        
        <?php
        }
        ?>

</div>
