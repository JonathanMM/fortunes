<?php
header("Content-Type: text");
require('config.inc.php'); 
$xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\r\n<fortunes>\r\n";
$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'fortunes');
while($donnees = mysql_fetch_array($requete))
{
	$xml .= "\t<fortune>\r\n\t\t<id>".$donnees['id']."</id>";
		if(strlen($donnees['titre']) > 0)
			$xml .= "\r\n\t\t<title>".$donnees['titre']."</title>";
		
	$xml .= "\r\n\t\t<date>".date('c', $donnees['date'])."</date>\r\n\t\t<content>".str_replace('<br />', '', $donnees['contenu'])."</content>\r\n\t</fortune>\r\n";
}
$xml .= "</fortunes>";
mysql_close();

echo $xml;
?>