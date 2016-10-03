<?php 
session_start(); 
include_once('includes/functions.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = AddOrUpdateUser();

}
    


?>
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
                $Nom = 'value="' . $_SESSION['client']['nom'] . '"';
                $Prenom = 'value="' . $_SESSION['client']['prenom'] . '"';
                $Nocivique = 'value="' . $_SESSION['client']['Nocivique'] . '"';
                $Rue = 'value="' . $_SESSION['client']['Rue'] . '"';
                $Ville = 'value="' . $_SESSION['client']['Ville'] . '"';
                $CodePostal = 'value="' . $_SESSION['client']['CodePostal'] . '"';
                $Telephone = 'value="' . $_SESSION['client']['Telephone'] . '"';
                $Courriel = 'value="' . $_SESSION['user']['courriel'] . '"';
            }
            else
            {
                $Confirmation = 'Confirmation du ';
                $Nom = 'placeholder="Nom"';
                $Prenom = 'placeholder="Prenom"';
                $Nocivique = 'placeholder="No civique"';
                $Rue = 'placeholder="Rue"';
                $Ville = 'placeholder="Ville"';
                $CodePostal = 'placeholder="Code Postal"';
                $Telephone = 'placeholder="Numéro de téléphone"';
                $Courriel = 'placeholder="Courriel"';
            }
        ?>
        <main>
            <form action="inscription.php" method="POST"  onSubmit="return validationFormulaire();" >
                <p>
                    Remplissez ce formulaire pour créer votre profil
                    <div class="RedReminder">Tous les champs sont obligatoires</div>
                </p>
                <div>
                    <input type="text" required name="nom" <?php echo $Nom ?>>
                    <input type="text" required name="prenom" <?php echo $Prenom ?>>
                </div>

                <div>
                    <div class="flex-container flex-1">
                        <input class="flex-1" required  type="text" name="Nocivique" <?php echo $Nocivique ?>>
                        <input class="flex-2" required  type="text" name="rue" <?php echo $Rue ?>>
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
                                    echo '<option value="'.$row['pk_ville'].'" selected>'.$row['ville'].'</option>';
                                else
                                    echo '<option value="'.$row['pk_ville'].'">'.$row['ville'].'</option>';
                            }
                        ?>
                    </select>
                </div>

                <div>
                    <input type="text" required name="codepostal" <?php echo $CodePostal ?>>
                    <input type="text" required name="telephone" <?php echo $Telephone ?>>
                </div><br>

                <p>Votre courriel servira à vous identifier lors de votre prochaine visite
                    <div class="RedReminder">Votre mot de passe doit contenir un minimum de 8 caratères</div>
                </p>
                
                <div> 
                    <input type="text" required name="courriel" <?php echo $Courriel ?>>
                    <input type="text" required name="confirmationcourriel" <?php echo $Courriel ?>>
                </div>
                <div>
                    <input type="password" required name="password" placeholder="Mot de passe">
                    <input type="password" required name="confirmationpassword" placeholder="Confirmation">
                </div>
                <div>
                    <input name="infolettre" type="checkbox" class="css-checkbox" id="checkbox">
                    <label for="checkbox" class="css-label">Souhaitez-vous recevoir les promotions et les nouveautés</label>
                </div>
                
                <input type="submit" value="Confirmer" class="button">
            </form>
        </main>

        <script src="scripts/inscription.js"></script>
    </body>
</html>
