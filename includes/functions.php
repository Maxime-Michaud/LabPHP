<?php
//Établis la connexion a la bd
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

//Obtiens une liste de toutes les factures. Si la requete est un POST, filtre selon la requete 
function GetFactures(){
    $whereCondition = " 1 = 1";


    if ($_SERVER['REQUEST_METHOD'] === 'POST')    
    {
        if (isset($_POST['facture']) && $_POST['facture'] != "")
            $whereCondition .= " AND f.pk_facture = " . $_POST['facture'];
        
        if (isset($_POST['nomClient']) && $_POST['nomClient'] != "")
            $whereCondition .= " AND (c.prenom LIKE '%" . $_POST['nomClient'] . "%' OR c.nom LIKE '%" . $_POST['nomClient'] . "%')";
        
        if (isset($_POST['confirmation']) && $_POST['confirmation'] != "")
            $whereCondition .= " AND f.no_confirmation LIKE '%" . $_POST['confirmation'] . "%'";

        if (isset($_POST['dateDe']) && $_POST['dateDe'] != "")
            $whereCondition .= " AND f.date_service > '" . $_POST['dateDe'] . "'";

        if (isset($_POST['dateA']) && $_POST['dateA'] != "")
            $whereCondition .= " AND f.date_service < '" . $_POST['dateA'] . "'";

        if (isset($_POST['service']) && $_POST['service'] != "")
            $whereCondition .= " AND s.service_titre LIKE '%" . $_POST['service'] . "%'";
    }

    $query = "SELECT f.pk_facture AS num,
                     concat(c.prenom, ' ', c.nom) AS nom,
                     f.no_confirmation AS confirm,
                     DATE_FORMAT(f.date_service, '%d/%m/%Y') AS date,
                     sum(fs.tarif_facture) AS prix
              FROM facture f INNER JOIN client c ON c.pk_client = f.fk_client
                             INNER JOIN ta_facture_service fs ON f.pk_facture = fs.fk_facture
                             INNER JOIN service s ON s.pk_service = fs.fk_service
              WHERE $whereCondition
              GROUP BY f.pk_facture
              ORDER BY f.pk_facture DESC";
    return mysql_query($query);
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
    
    if($row['administrateur'] != 1)
    {
        $query = "  SELECT  c.nom AS nom, 
                            c.prenom AS prenom,
                            a.no_civique AS Nocivique,
                            a.rue AS Rue,
                            a.fk_ville AS Ville,
                            a.code_postal AS CodePostal,
                            c.telephone AS Telephone,
                            c.fk_utilisateur AS id,
                            c.pk_client AS pk, 
                            c.fk_adresse AS fk_adresse
                    FROM client c INNER JOIN adresse a  ON a.pk_adresse = c.fk_adresse 
                    WHERE c.fk_utilisateur = '".$row['pk_utilisateur']."'";

        $rs = mysql_query($query);

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

//Tente d'ajouter ou updater un utilisateur dans la bd. 
//Si une erreur se produit, retourne une string qui représente l'erreur, sinon null
function AddOrUpdateUser()
{
    //Vérifie qu'il n'y a pas d'adresse email en double
    $query = "  SELECT  pk_utilisateur AS id,
                        courriel       AS courriel 
                FROM    utilisateur
                WHERE   courriel = '" . mysql_real_escape_string($_POST['courriel']) . "'";

    $rs = mysql_query($query);

    if (!$rs) 
        return "erreur";
    $row = mysql_fetch_assoc($rs); 

    if (mysql_num_rows($rs) and    //Il y a un utilisateur avec l'adresse email
        !isset($_SESSION['user']) || //L'utilisateur n'est pas connecté
        $_SESSION['user']['pk_utilisateur'] != $row["id"]) // L'utilisateur connecté n'est pas celui auquel l'adresse appartient' 
    {
        return "email";
    }

    //Puisque l'utilisateur est connecté, on update ses infos'
    if (isset($_SESSION['user']))
    {

        $query = "  UPDATE `utilisateur` 
                    SET `courriel` = " . '"' . mysql_real_escape_string($_POST['courriel'])  . '"' . ",
                        `mot_de_passe`= " . '"' . mysql_real_escape_string($_POST['password'])  . '"' . "
                        WHERE `pk_utilisateur` = \"" . $_SESSION['user']['pk_utilisateur'] . "\"";

        mysql_query($query);
        echo mysql_error();
        $adresse = $_SESSION["client"]['fk_adresse'];

        if ($_SESSION["client"]['CodePostal'] != $_POST['codepostal'] ||
            $_SESSION["client"]['Rue'] != $_POST['rue'] ||
            $_SESSION["client"]['Nocivique'] != $_POST['Nocivique'] ||
            $_SESSION["client"]['Ville'] != $_POST['ville'])
        {
            $query = "INSERT INTO `adresse`(`no_civique`, `rue`, `fk_ville`, `code_postal`) 
                      VALUES (  " . mysql_real_escape_string($_POST['Nocivique']) . ", 
                                " . '"' . mysql_real_escape_string($_POST['rue'])  . '"' . ",
                                " . mysql_real_escape_string($_POST['ville']) . ", 
                                " . '"' . mysql_real_escape_string($_POST['codepostal'])  . '"' . ")";

            $adresse = mysql_insert_id($query);
        }
        

        $query = "  UPDATE `client` 
                    SET `prenom`=  " . '"' . mysql_real_escape_string($_POST['prenom'])  . '"' . ",
                        `nom`= " . '"' . mysql_real_escape_string($_POST['nom'])  . '"' . ",
                        `fk_adresse`= " . $adresse . ",
                        `telephone`= " . '"' . mysql_real_escape_string($_POST['telephone'])  . '"' . "
                    WHERE pk_client = " . $_SESSION["client"]['pk'];
    } else {
        $insertAdresse = "INSERT INTO `adresse`(`no_civique`, `rue`, `fk_ville`, `code_postal`) 
                          VALUES (  " . mysql_real_escape_string($_POST['Nocivique']) . ", 
                                " . '"' . mysql_real_escape_string($_POST['rue'])  . '"' . ",
                                " . mysql_real_escape_string($_POST['ville']) . ", 
                                " . '"' . mysql_real_escape_string($_POST['codepostal'])  . '"' . ")";

        mysql_query($insertAdresse);
        $adresse = mysql_insert_id();

        $insertUser = "INSERT INTO `utilisateur`(`courriel`, `mot_de_passe`) 
                       VALUES ('" . mysql_real_escape_string($_POST['courriel']) . "' ,
                       '" . mysql_real_escape_string($_POST['password']) . "')";
        mysql_query($insertUser);
        $user = mysql_insert_id();

        $insertClient = "INSERT INTO `client`(`fk_utilisateur`, `prenom`, `nom`, `fk_adresse`, `telephone`) 
                         VALUES (" . $user . ",
                                 `" . mysql_real_escape_string($_POST['prenom']) . "`,
                                 `" . mysql_real_escape_string($_POST['nom']) . "`,
                                 " . $adresse . ",
                                 `" . mysql_real_escape_string($_POST['telephone']) . "`)";

        mysql_query($insertClient);
    }
}