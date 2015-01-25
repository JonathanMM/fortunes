<?php
include('haut.php');
?>
<div class="align-accueil"><h3>Liste des 10 dernières fortunes</h3></div>
<?php
$pre_requete = mysql_query('SELECT COUNT(*) AS nb FROM '.$bdd_prefixe.'fortunes');
$pre_donnees = mysql_fetch_array($pre_requete);
$page_max = ceil($pre_donnees['nb'] / 10);

if(isset($_GET['page']) AND intval($_GET['page']) > 0)
{
	$page = intval($_GET['page']);
	$limite = (($page - 1)* 10).', 10';
} else {
	$page = 1;
	$limite = '0, 10';
}

if(isset($_SESSION['co']) && $_SESSION['co'] == 1)
{
	$ajout1 = ', f.id AS id';
	$ajout2 = 'f LEFT JOIN '.$bdd_prefixe.'votes v ON v.id_fortune = f.id AND v.id_membre = '.$_SESSION['id'];
}

$requete = mysql_query('SELECT *'.$ajout1.' FROM '.$bdd_prefixe.'fortunes '.$ajout2.' ORDER BY date DESC LIMIT '.$limite);
while($donnees = mysql_fetch_array($requete))
{ 
	if(isset($_SESSION['co']) && $_SESSION['co'] == 1 && $donnees['id_membre'] != NULL)
	{
		if($donnees['type'] == 1)
			$signe = '+';
		elseif($donnees['type'] == 2)
			$signe = '-';

		$vote = '<div class="suite">[('.($donnees['plus'] - $donnees['moins']).') '.$signe.']</div>';
	} else
		$vote = '<div class="suite">[<a href="vote.php?a=p&amp;id='.$donnees['id'].'">+</a> ('.($donnees['plus'] - $donnees['moins']).') <a href="vote.php?a=m&amp;id='.$donnees['id'].'">-</a>]</div>';
?>
	<div class="fortune-accueil">
		<div class="titre">
			<span class="date">Le <?php echo date('d/m/Y \à H:i:s', $donnees['date']); ?></span>
			<a href="<?php echo $donnees['id']; ?>">#<?php echo $donnees['id']; ?></a>
			<?php if(strlen($donnees['titre']) > 0)
				  echo ' '.$donnees['titre'].'<br />';
			?></div>
	<?php if(substr_count($donnees['contenu'], '<br />') > 10)
		{
			$coupe = explode('<br />', $donnees['contenu'], 11);
			$recolle = $coupe[0].'<br />'.$coupe[1].'<br />'.$coupe[2].'<br />'.$coupe[3].'<br />'.$coupe[4].'<br />'.$coupe[5].'<br />'.$coupe[6].'<br />'.$coupe[7].'<br />'.$coupe[8].'<br />'.$coupe[9];
			echo color_pseudo($recolle).'<div class="suite"><a href="'.$donnees['id'].'">[Lire la suite]</a></div>';
		}
		else
			echo color_pseudo($donnees['contenu']).$vote; ?></div>
<?php } ?><p id="pages-accueil">[Pages : 
<?php $page_boucle = 1;
while($page_boucle <= $page_max)
{
	if($page_boucle == $page)
		echo '<b>'.$page.'</b> ';
	else
		echo '<a href="index.php?page='.$page_boucle.'">'.$page_boucle.'</a> ';
	$page_boucle++;
} ?>]</p>
<?php
include('bas.php');
?>