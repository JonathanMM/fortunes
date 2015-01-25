<?php
include('haut.php');

if(isset($_GET['action']) && $_GET['action'] == 'modif')
{ 
	$id = intval($_GET['id']);
	$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'fortunes WHERE id = '.$id);
	$donnees = mysql_fetch_array($requete);
	if((isset($_SESSION['co']) && $_SESSION['co'] == 1 && $donnees['proprio'] == $_SESSION['id']) || ($donnees['proprio'] == 0 && isset($_GET['code']) && strtolower($donnees['code']) == strtolower($_GET['code'])))
	{ ?>
		<form action="fortune.php" method="post">
		<div class="align-accueil">
		Titre : <input style="width: 442px;" name="titre" value="<?php echo str_replace('<br />', "\n", $donnees['titre']); ?>" /><br />
		<textarea style="width: 500px; height: 150px;" name="fortune"><?php echo str_replace('<br />', "", htmlspecialchars_decode($donnees['contenu'], ENT_QUOTES)); ?></textarea><br />
		<input type="hidden" name="envoi" value="1" />
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<input type="submit" value="Envoyer" />
		</div></form>
	<?php } else
		echo '<div class="align-accueil"><p><i>Vous ne pouvez modifier cette fortune.</i><br /><a href="index.php">[Se cacher]</a></p></div>';
} else {
	if($_POST['envoi'] == 1)
	{
		$id = intval($_POST['id']);
		$titre = htmlspecialchars($_POST['titre'], ENT_QUOTES);
		$fortune = nl2br(htmlspecialchars($_POST['fortune'], ENT_QUOTES));

		mysql_query('UPDATE '.$bdd_prefixe.'fortunes SET titre = "'.$titre.'", contenu = "'.$fortune.'", date = "'.time().'" WHERE id = '.$id);
		echo '<div class="align-accueil"><p><i>Votre fortune a été mise à jour</i>.</p></div>';
	} elseif($_GET['id'] == 'alea')
		$id = 'alea';
	else
		$id = intval($_GET['id']);

	if($id == 'alea')
	{
		$pre_requete = mysql_query('SELECT id FROM '.$bdd_prefixe.'fortunes');
		$alea = array();
		while($pre_donnees = mysql_fetch_array($pre_requete))
			$alea[] = $pre_donnees['id'];
		shuffle($alea);
		if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
		{
			$ajout1 = ', f.id AS id';
			$ajout2 = 'LEFT JOIN '.$bdd_prefixe.'votes v ON v.id_fortune = f.id AND v.id_membre = '.$_SESSION['id'];
		}

		$requete = mysql_query('SELECT *'.$ajout1.' FROM '.$bdd_prefixe.'fortunes f LEFT JOIN '.$bdd_prefixe.'membre m ON m.id = f.proprio '.$ajout2.' WHERE f.id = '.$alea[0]);
		$id = $alea[0];
	} else {
		if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
		{
			$ajout1 = ', f.id AS id';
			$ajout2 = 'LEFT JOIN '.$bdd_prefixe.'votes v ON v.id_fortune = f.id AND v.id_membre = '.$_SESSION['id'];
		}

		$requete = mysql_query('SELECT *'.$ajout1.' FROM '.$bdd_prefixe.'fortunes f LEFT JOIN '.$bdd_prefixe.'membre m ON m.id = f.proprio '.$ajout2.' WHERE f.id = '.$id);
	}

	$donnees = mysql_fetch_array($requete);
	if(isset($_SESSION['co']) && $_SESSION['co'] == 1 && $donnees['id_membre'] != NULL)
	{
		if($donnees['type'] == 1)
		{
			$plus = '<b>+'.$donnees['plus'].'</b>';
			$moins = '-'.$donnees['moins'];
		} else
		{
			$plus = '+'.$donnees['plus'];
			$moins = '<b>-'.$donnees['moins'].'</b>';
		}
	} elseif (isset($_SESSION['co']) && $_SESSION['co'] == 1) {
		$plus = '<a href="vote.php?a=p&amp;id='.$id.'">+'.$donnees['plus'].'</a>';
		$moins = '<a href="vote.php?a=m&amp;id='.$id.'">-'.$donnees['moins'].'</a>';
	} else {
		$plus = '+'.$donnees['plus'];
		$moins = '-'.$donnees['moins'];
	}
	?>
	<div id="fortune">
	<div class="titre">Affichage de la fortune n°<a href="fortune.php?id=<?php echo $id; ?>"><?php echo $id; ?></a>
		<?php if(strlen($donnees['titre']) > 0)
			  echo ': '.$donnees['titre'];
		?>
		<div class="date">Ajouté le <?php echo date('d/m/Y \à H:i:s', $donnees['date']); ?><?php if($donnees['proprio'] != 0) echo ' par '.$donnees['pseudo']; ?></div>
		<div class="vote"><?php echo $plus.' '.$moins; ?> (<?php echo ($donnees['plus'] - $donnees['moins']); ?>/<?php $votants = ($donnees['plus'] + $donnees['moins']); echo $votants; ?> vote<?php if($votants > 1) echo 's'; ?>)</div></div>

		<?php echo color_pseudo($donnees['contenu']); ?></p></div>
	<?php if((isset($_SESSION['co']) && $_SESSION['co'] == 1) || $donnees['proprio'] != 0)
	{
		if($donnees['proprio'] == $_SESSION['id'])
			echo '<div class="align-accueil"><p><a href="fortune.php?action=modif&amp;id='.$id.'">[Modifier cette fortune]</a></p></div>';
	} else {?>
		<form action="fortune.php" method="get">
		<div class="align-accueil">Code de modification : <input name="code" /><input type="submit" value="OK" /><input type="hidden" name="action" value="modif" /><input type="hidden" name="id" value="<?php echo $id; ?>" /></div></form>
	<?php
	}
}
include('bas.php');
?>