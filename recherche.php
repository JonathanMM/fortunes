<?php
include('haut.php');
?>
<div class="align-accueil"><h3>Rechercher</h3></div>
<?php
if($_POST['envoi'] == 1)
{
	$terme = htmlspecialchars($_POST['recherche'], ENT_QUOTES);
	if($_POST['type'] == 'membre')
		$terme = '&lt;'.$terme.'&gt;';

	$requete = mysql_query('SELECT * FROM '.$bdd_prefixe.'fortunes WHERE contenu LIKE "%'.$terme.'%" ORDER BY id DESC');
	while($donnees = mysql_fetch_array($requete))
	{ ?>
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
				echo color_pseudo($donnees['contenu']); ?></div>
	<?php } ?>
<?php } else {
?><form action="recherche.php" method="post">
<div class="align-accueil"><input name="recherche" style="width: 400px;" />
<input type="radio" name="type" value="mot" id="mot" /> <label for="mot">Terme</label>
<input type="radio" name="type" value="membre" id="membre" /> <label for="mot">Membre</label>
<input type="submit" value="Rechercher" /><input type="hidden" name="envoi" value="1" /></div>
</form>
<?php
}
include('bas.php');
?>