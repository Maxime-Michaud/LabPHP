<?php

mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');

//Obtiens le nom de la page en cours
function GetCurrentPage()
{
    $url = $_SERVER['REQUEST_URI'];
    $pattern = '~.*\/(.*?\.php)~';

    preg_match($pattern, $url, $matches);

    return $matches[1];
}

//Connecte un utilisateur. Retourne si la connexion a réussie ou non
function connexion()
{
    $query = "SELECT * FROM utilisateur WHERE courriel ='".$_POST["user"]."' AND mot_de_passe ='".$_POST["password"]."'";
    $rs = mysql_query($query);
    if ($rs == false) 
        return $rs;

    $row = mysql_fetch_array($rs, MYSQL_ASSOC);
    $_SESSION["user"] = $row;
    
    echo '<br> user connecté <br>';

    if($row['administrateur'] != 1)
    {
        echo '<br> user non admin <br>';

        $query = "  SELECT  c.nom AS nom, 
                            c.prenom AS prenom,
                            a. no_civique AS Nocivique,
                            a.rue AS Rue,
                            a.fk_ville AS Ville,
                            a.code_postal AS CodePostal,
                            c.telephone AS Telephone
                    FROM client c INNER JOIN adresse a  ON a.pk_adresse = c.fk_adresse 
                    WHERE c.fk_utilisateur = '".$row['pk_utilisateur']."'";

        $rs = mysql_query($query);
        echo '<br> query effectuée <br>';

        $row = mysql_fetch_array($rs, MYSQL_ASSOC);

        $_SESSION["client"] = $row;
    }
    return true;
}

//Obtiens tous les produits
function getAllProduit()
{
    
$query = "SELECT * FROM service";
$rs = mysql_query($query);

if ($rs === false || $rs === NULL)
    return false;

return $rs;
}