<script src="http://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous"></script>
<?php 
include_once("functions.php");
$currentpage = strtolower(GetCurrentPage());

if (isset($_SESSION['user']) && $_SESSION['user']['administrateur'] == 1)
{
    if ($currentpage === 'services.php')
        $lienservice = '<a href="./services.php" class="current">Services</a>';
    else
        $lienservice = '<a href="./services.php">Services</a>';

    if ($currentpage === 'facture.php')
        $lienfacture = '<a href="./facture.php" class="current">Facture</a>';
    else
        $lienfacture = '<a href="./facture.php">Facture</a>';
    
    $panier = "";
    $log = "<a href='./connexion.php?deconnexion=1'>Se déconnecter</a>";
} else {
    if ($currentpage === 'catalogue.php')
        $lienservice = '<a href="./catalogue.php" class="current">Catalogue</a>';
    else
        $lienservice = '<a href="./catalogue.php">Catalogue</a>';

    if ($currentpage === 'inscription.php')
        $lienfacture = '<a href="./inscription.php" class="current">Profil</a>';
    else
        $lienfacture = '<a href="./inscription.php">Profil</a>';

    if (isset($_SESSION['user']))
    {
        $log = "<a href='./connexion.php?deconnexion=1'>Se déconnecter</a>";
        $panier = '<a href="./panier.php">Panier</a>';
    }
    else
    {
        $log = "<a href='./connexion.php'>S'identifier</a>";
        $panier = "";
    }
}
?>

<div class="header">
    <div class="top-right-corner col-12">
        <?php 
            echo $panier;
            echo $log;
        ?>
    </div>

    <div class="logo">
        <div class="flex-3"><img src="./images/logo.png" /></div>
            <?php 
                echo '<div class="flex-1"> '.$lienservice.'</div>';
                echo '<div class="flex-1"> '.$lienfacture.'</div>';
            ?>
        <div class="dropdown flex-1">
            <div class="search"><form action="search.php" method="post" class="search">
            <input type="text" class="searchBox"><input type="image" id="loupe" src="images/loupe.png"/>
            </form></div>
        </div>   
    </div>
</div>