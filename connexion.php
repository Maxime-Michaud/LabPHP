<!DOCTYPE html>
<?php
session_start();
include_once("includes/functions.php");
if(isset($_GET["deconnexion"]))
{
    unset($_SESSION);
    session_destroy();
}
else if(isset($_POST["user"]) || isset($_POST["password"]))
{
    $success = connexion();

    if ($success)
    {
        $domain = 'localhost/dev/';
        print_r($_SESSION['user']);
        if ($_SESSION['user']['administrateur'] == 1)
        {
            header("Location: http://" . $domain . "services.php");
        }
        else
        {
            header("Location: http://" . $domain . "catalogue.php");
        }
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>connexion</title>
        <link rel="stylesheet" href="styles/connexion.css">    
        <script>
            function resetPW(){
                if(document.getElementById("email").value != "")
                {
                    alert("Votre mot de passe temporaire vous a été envoyé par email." +
                            "\nVeuillez l'utiliser pour vous connecter et réinitialiser votre mot de passe.");
                } else {
                    alert("Le courriel est requis pour cette action.");
                }
            }
        </script>
     </head>
    <body>
        <?php include('includes/header.php'); ?>
        <div class="col-12">
            <div class="col-6 col-offset-3">
                <p class="center">Veuillez vous identifier pour avoir la possibilité d'acheter des formations</p>
                <form action="connexion.php" method="post">
                    <div class="LogInTextBox">
                        <input type="text" name="user" id="email" placeholder="Utilisateur ou email"><br>
                        <input type="password" name="password" placeholder="Mot de passe"><br>
                        <br><a onclick="resetPW()" class="RedReminder">Mot de passe oublié?</a><br>
                     </div><br>
                     <input type="submit" value="Connexion" class="button">
                     <input type="button" value="S'inscrire" onclick="window.location='inscription.php';" class="button"><br><br>
                     <img src="images/facebook.png" alt='Connexion via facebook'/>
                </form> 

            </div>
        </div>
    </body>
</html>
