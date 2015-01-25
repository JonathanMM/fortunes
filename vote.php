<?php include('haut.php');
$id = intval($_GET['id']);
if($id > 0)
{
	if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
	{
		$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'votes WHERE id_fortune = '.$id.' AND id_membre = '.$_SESSION['id']);
		if(mysql_num_rows($requete) == 0)
		{
			if($_GET['a'] == 'p')
			{
				mysql_query('UPDATE '.$bdd_prefixe.'fortunes SET plus = plus + 1 WHERE id = '.$id);
				mysql_query('INSERT INTO '.$bdd_prefixe.'votes VALUES ("", '.$id.', '.$_SESSION['id'].', 1)');
				echo '<div class="align-accueil">Votre vote positif a bien été comptabilisé</div>';
			} elseif($_GET['a'] == 'm')
			{
				mysql_query('UPDATE '.$bdd_prefixe.'fortunes SET moins = moins + 1 WHERE id = '.$id);
				mysql_query('INSERT INTO '.$bdd_prefixe.'votes VALUES ("", '.$id.', '.$_SESSION['id'].', 2)');
				echo '<div class="align-accueil">Votre vote négatif a bien été comptabilisé</div>';
			}
		} else {
			$donnees = mysql_fetch_array($requete);
			if($donnees['type'] == 1)
				$vote = 'plus';
			elseif($donnees['type'] == 2)
				$vote = 'moins';
			echo '<div class="align-accueil">Désolé, mais vous avez déjà voté '.$vote.' a cette fortune</div>';
		}
	} else
		echo '<div class="align-accueil">Désolé mais il faut être connecté pour pouvoir voter</div>';
} else
	echo '<div class="align-accueil">Désolé, mais la fortune au quel vous voulez voter n\'existe pas</div>';
include('bas.php'); ?>