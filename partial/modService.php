<?php
    function getImageName($name)
{
    $pattern = '~.*\/(.*?\.(jpg|png|gif))~';

    preg_match($pattern, $name, $matches);

    return $matches[1];
}

mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');

$row = explode("|", $_POST['row']);
var_dump($row);
var_dump($_POST);
var_dump($_POST['image']);
var_dump(getImageName($_POST['image']));
 if($_POST['titre'] != $row[1])
 {
     $query= 'UPDATE `service` SET `service_titre` = \''.$_POST['titre'].'\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 
  if($_POST['description'] != $row[2])
 {
     $query= 'UPDATE `service` SET `service_description` = \''.$_POST['description'].'\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 
 $h = array("h", "H");
   if(str_replace($h,"",$_POST['heure']) != $row[3])
 {
     $query= 'UPDATE `service` SET `duree` = \''.str_replace($h,"",$_POST['heure']).'\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 
    if(str_replace("$","",$_POST['montant']) != $row[4])
 {
     $query= 'UPDATE `service` SET `tarif` = \''.str_replace("$","",$_POST['montant']).'\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 
     if($_POST['actif'])
 {
     $query= 'UPDATE `service` SET `actif` = \'1\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 else
 {
     $query= 'UPDATE `service` SET `actif` = \'0\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
 
      if(getImageName($_POST['image']) != $row)
 {
     $query= 'UPDATE `service` SET `image` = \''.getImageName($_POST['image']).'\' WHERE `service`.`pk_service` = '.$row[0];
     $rs = mysql_query($query);
 }
?>

