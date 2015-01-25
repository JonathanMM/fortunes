<?php
$host = '';
$username = '';
$password = '';
$bdd_name = '';
$bdd_prefixe = 'fortunes_';

// Connexion a la base de donnée
mysql_connect($host,$username,$password);
mysql_select_db($bdd_name);
?>
