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
        $domain = 'weba.cegepsherbrooke.qc.ca/~tia16007/';
        print_r($_SESSION['user']);
        if ($_SESSION['user']['administrateur'] == 1)
        {
            header("Location: http://" . $domain . "services.php");
        }
        else
        {
            header("Location: http://" . $domain . "inscription.php");
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
                     <input type="hidden" id="access_token" name="access_token" value=""/>
                     <input type="hidden" id="fb_email" name="fb_email" value=""/>
                     <div class="fb-login-button real_login_facebook" data-max-rows="1" data-size="xlarge" data-show-faces="false" data-auto-logout-link="false" data-scope="public_profile,email"></div>
                </form> 
		<div id="fb-root"></div>
			<!-- IMPORTANT: fait en équipe avec Philippe Normandin, code: Philippe Normandin -->
		<script>

			var user_email = "";
			var access_token = "";
			
			// This is called with the results from FB.getLoginStatus().
  			function statusChangeCallback(response) {
				console.log('statusChangeCallback');
				console.log(response);
				// The response object is returned with a status field that lets the
				// app know the current login status of the person.
    			if (response.status === 'connected') {
      				// Logged into your app and Facebook.
      				console.log(response.authResponse.accessToken);
					FB.api('/me?fields=id,name', function(response) {
							console.log('Successful login for: ' + response.name);
					});
    			} else if (response.status === 'not_authorized') {
      				// The person is logged into Facebook, but not your app.
					document.getElementById('access_token').value = "";
					document.getElementById('email').value = "";
      				document.getElementById('status').innerHTML = 'Please log ' +
        			'into this app.';
    			} else {
      				// The person is not logged into Facebook, so we're not sure if
      				// they are logged into this app or not.
					document.getElementById('email').value = "";
					document.getElementById('access_token').value = "";
      				document.getElementById('status').innerHTML = 'Si vous détenez un compte Facebook, ' +
        			'vous pouvez vous connecter avec celui-ci.';
    			}
  			}
			
			// Initialise Facebook api
			window.fbAsyncInit = function() {
				FB.init({
					appId      : '202384993526513',		// works on a registered url
				  	xfbml      : true,
				  	version    : 'v2.7'
				});
				
				// Ce code permet de récupérer les infos d'une connexion avec FB
				/*
				FB.getLoginStatus(function(response) {
					statusChangeCallback(response);
				});
				*/
				
				// Ce code est exécuté dès qu'un changement survient, comme par exemple
				// utilisateur qui clique sur le login
				FB.Event.subscribe('auth.authResponseChange', function(response) {
					if (response.status === 'connected') {
						// Récupère le access token
						access_token = response.authResponse.accessToken;
						document.getElementById('access_token').value = access_token;
						FB.api('/me?fields=id,name,email,permissions', function(response) {
							// Récupère le email
							user_email = response.email;
							document.getElementById('fb_email').value = user_email;
							// Envoie le formulaire
							var form = document.getElementById("login_form");
							form.action = "./partial/facebook_login.php";
							form.submit();
						});
					}
				});		
		    };

			// Load the SDK asynchronously
			(function(d, s, id) {
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) return;
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/fr_CA/sdk.js#xfbml=1&version=v2.8&appId=876410859161681";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
			
		</script>
            </div>
        </div>
    </body>
</html>
