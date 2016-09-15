<?php session_start(); ?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>inscription</title>
        <link rel="stylesheet" href="./styles/inscription.css">
        <!--<link rel="stylesheet" href="./styles/style.css"> Inclus dans /styles/inscription.css-->

    </head>
    <body>
        <?php 
            include('includes/header.php'); 
            if (isset($_SESSION['client']))
            {
                $Confirmation = '';
                $Nom = $_SESSION['client']['nom'];
                $Prenom = $_SESSION['client']['prenom'];
                $Nocivique = $_SESSION['client']['Nocivique'];
                $Rue = $_SESSION['client']['Rue'];
                $Ville = $_SESSION['client']['Ville'];
                $CodePostal = $_SESSION['client']['CodePostal'];
                $Telephone = $_SESSION['client']['Telephone'];
                $Courriel = $_SESSION['user']['courriel'];
            }
            else
            {
                $Confirmation = 'Confirmation du ';
                $Nom = 'Nom';
                $Prenom = 'Prenom';
                $Nocivique = 'No civique';
                $Rue = 'Rue';
                $Ville = 'Ville';
                $CodePostal = 'Code Postal';
                $Telephone = 'Numéro de téléphone';
                $Courriel = 'Courriel';
            }
        ?>
        <main>
            <p>
                Remplissez ce formulaire pour créer votre profil
                <div class="RedReminder">Tous les champs sont obligatoires</div>
            </p>

            <div>
                <input type="text" name="nom" placeholder=<?php echo $Nom ?>>
                <input type="text" name="prenom" placeholder=<?php echo $Prenom ?>>
            </div>

            <div>
                <div class="flex-container flex-1">
                    <input class="flex-1" type="text" name="Nocivique" placeholder=<?php echo $Nocivique ?>>
                    <input class="flex-2" type="text" name="rue" placeholder=<?php echo $Rue ?>>
                </div>
                
                <select name="ville" class="flex-1">
                    <?php 
                        if (isset($_SESSION['client']))
                            echo '<option value="Ville" disabled>Ville</option>';
                        else 
                            echo '<option value="Ville" selected disabled>Ville</option>';
                        
                        $rs = mysql_query('SELECT * FROM ville');
                        while ($row = mysql_fetch_array($rs))
                        {
                            if ($row['pk_ville'] == $Ville)
                                echo '<option value="'.$row['ville'].'" selected>'.$row['ville'].'</option>';
                            else
                                echo '<option value="'.$row['ville'].'">'.$row['ville'].'</option>';


                        }
                    ?>
                </select>
            </div>

            <div>
                <input type="text" name="codepostal" placeholder=<?php echo $CodePostal ?>>
                <input type="text" name="notel" placeholder=<?php echo $Telephone ?>>
            </div><br>

            <p>Votre courriel servira à vous identifier lors de votre prochaine visite
                <div class="RedReminder">Votre mot de passe doit contenir un minimum de 8 caratères</div>
            </p>
            
            <div> 
                <input type="text" name="courriel" placeholder=<?php echo $Courriel ?>>
                <input type="text" name="confirmationcourriel" placeholder=<?php echo $Confirmation.$Courriel ?>>
            </div>
            <div>
                <input type="password" name="modivepasse" placeholder="Mot de passe">
                <input type="password" name="confirmationmodivepasse" placeholder="Confirmation">
            </div>
            <div>
                <input type="checkbox" class="css-checkbox" id="checkbox">
                <label for="checkbox" class="css-label">Souhaitez-vous recevoir les promotions et les nouveautés</label>
            </div>
            
            <input type="submit" value="Connexion" class="button">
            
        </main>
    </body>
</html>
