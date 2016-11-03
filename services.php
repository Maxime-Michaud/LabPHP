<?php session_start();
if(!isset($_SESSION["nbItemPanier"]))
    $_SESSION["nbItemPanier"]=0;?>
<!DOCTYPE html>
<html>
    <head>
        <title>Services</title>
        <meta charset="UTF-8"/>
        <!-- Mettez la balise html à jour pour inclure les attributs itemscope et itemtype. -->
<html itemscope itemtype="http://schema.org/Product">

<!-- Ajoutez les trois balises suivantes dans l'en-tête. -->
<meta itemprop="name" content="Service offrt par info ++">
<meta itemprop="description" content="Super service et en plus plein de promotion">
<meta itemprop="image" content="http://localhost/labphp/images/logo.png">
        <link href="./styles/style.css" rel="stylesheet" type="text/css">
        <link href="./styles/services.css" rel="stylesheet" type="text/css">
    </head>
<script src="https://apis.google.com/js/platform.js" async defer>
  {lang: 'fr'}
</script>
    <body>
        <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=202384993526513";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        <?php 
            include('./includes/header.php'); 
            echo '<main>';
            include('./includes/services.php');
            echo '</main>';
        ?>
    </body>
    
</html>
