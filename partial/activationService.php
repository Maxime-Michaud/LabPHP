<?php
mysql_connect('localhost','tia16007','kaxelu');
mysql_select_db('tia16007');
$query= 'UPDATE `service` SET `actif` = \'0\' WHERE `service`.`pk_service` = '.$_POST['id'].';';
 $rs = mysql_query($query);
 
 if($_POST['reactivate'] == 'oui')
 {
     $query= 'UPDATE `service` SET `actif` = \'1\' WHERE `actif`= 0 ';
     $rs = mysql_query($query);
 }
?>



