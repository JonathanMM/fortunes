<?php
session_start();
require('config.inc.php'); 

function color_pseudo($texte)
{
	$pseudo = array();
	$couleur = array('#FF9900', '#339933', '#6633FF', '#990099', '#e02b1e', '#4f8774', '#875062', '#452a07');
	shuffle($couleur); //On mélange les couleurs :)
	$coupe = explode('<br />', $texte);
	$i_max = count($coupe) - 1;
	$nb_pseudo = 0;
	$i = 0;
	$j = 0;
	while($i <= $i_max)
	{
		if(preg_match("#^\s*\*#U", $coupe[$i]))
			$coupe[$i] = '<span style="color: #006600;">'.$coupe[$i].'</span>';
		elseif(preg_match("#&lt;([a-zA-Z0-9_+-\[\]]+)&gt;#U", $coupe[$i], $resultat))
		{
			$plop = $resultat[1];
			if(array_key_exists($plop, $pseudo))
				$coupe[$i] = preg_replace('#&lt;([a-zA-Z0-9_+-\[\]]+)&gt;#U', '&lt;<span style="color: '.$pseudo[$plop].';">$1</span>&gt;', $coupe[$i]);
			else
			{
				$pseudo[$resultat[1]] = $couleur[$nb_pseudo];
				$nb_pseudo++;
				$coupe[$i] = preg_replace('#&lt;([a-zA-Z0-9_+-\[\]]+)&gt;#U', '&lt;<span style="color: '.$pseudo[$plop].';">$1</span>&gt;', $coupe[$i]);
			}
		}

		$i++;
	}

	$texte = '';
	while($j <= $i_max)
	{
		$texte .= $coupe[$j];
		if($j != $i_max)
			$texte .= '<br/>';
		$j++;
	}

	return $texte;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
   <head>
       <title>Les fortunes du chan de Nolife</title>
       <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="design.css" />
   </head>
   <body>
<div id="menu"><a href="index.php">[Accueil]</a><br />
<a href="alea">[Afficher une fortune au hasard]</a><br />
<a href="recherche.php">[Rechercher]</a><br />
<a href="ajout.php">[Ajouter une fortune]</a><br />
<a href="export.php">[Exporter toute la base]</a><br />
<a href="membre.php">[Espace membre]</a></div>
<div id="haut"><h1 style="text-align: center;">Les fortunes du chan #nolife</h1></div>