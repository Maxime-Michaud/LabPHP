<?php 
//Utilise le get au lieu d'une méthode legit pour vérifier si l'utilisateur est un admin... pour des tests seulement?

include_once("functions.php");
$currentpage = strtolower(GetCurrentPage());

if (isset($_SESSION['user']) && $_SESSION['user']['administrateur'] == 1)
{
    if ($currentpage === 'service.php')
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

    if ($currentpage === 'profil.php')
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
        <div class="col-5"><img src="./images/logo.png" /></div>
        <?php 
            echo '<div class="col-2"> '.$lienservice.'</div>';
            echo '<div class="col-2"> '.$lienfacture.'</div>';
        ?>
        <div class="dropdown">
            <div class="search col-3"><form action="search.php" method="post" class="search">
            <input type="text" class="searchBox"><input type="image" id="loupe" src="images/loupe.png"/>
            </form></div>
<!--            <div class="dropdown-content">
                <form action="facture.php" method="post">
                <input name="facture" class="inputRecherche" type="text" placeholder="Numéro de facture">
                <input name="nomClient" class="inputRecherche" type="text" placeholder="Nom du client">
                <input name="confirmation" class="inputRecherche" type="text" placeholder="Confirmation">
                <input name="dateDe" class="inputRechercheDate" type="date" placeholder="Date">à
                <input name="dateA" class="inputRechercheDate" type="date" placeholder="Date">
                <input name="confirmation" class="inputRecherche" type="text" placeholder="Service">
                <input class="button buttonRecherche" type="button" name="recherche">
                <input type="image" id="loupe2" src="images/loupe.png"/>
                </form>
            </div>-->
        </div>   
    </div>
</div>